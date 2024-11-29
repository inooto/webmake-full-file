<?php
if ( ! defined( 'ABSPATH' ) ) exit;

use \SWELL_Theme\Legacy_Widget as Widget;

/**
 * 最新記事一覧ウィジェット
 */
class SWELL_New_Posts extends WP_Widget {
	public function __construct() {
		parent::__construct(
			false,
			$name = '[SWELL] ' . __( '新着記事', 'swell' ),
			['description' => __( '新着順で記事を表示', 'swell' ) ]
		);
	}

	// 設定
	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, [
			'title'        => '',
			'num'          => 5,
			'type'         => 'card_style',
			'show_date'    => false,  // null -> falseに
			'show_cat'     => false,  // null -> falseに
			'hide_top'     => false,
			'hide_post'    => false,
			'hide_page'    => false,
			'hide_archive' => false,
		] );

		Widget::text_field([
			'label'    => __( 'タイトル', 'swell' ),
			'id'       => $this->get_field_id( 'title' ),
			'name'     => $this->get_field_name( 'title' ),
			'value'    => $instance['title'],
		]);
		Widget::num_field([
			'label'    => __( '表示する投稿数', 'swell' ),
			'id'       => $this->get_field_id( 'num' ),
			'name'     => $this->get_field_name( 'num' ),
			'value'    => $instance['num'] ?: 5,
			'step'     => '1',
			'min'      => '1',
			'max'      => '10',
			'size'     => '3',
		]);
		Widget::radio_field([
			// 'label'    => __( '', 'swell' ),
			'id'       => $this->get_field_id( 'type' ),
			'name'     => $this->get_field_name( 'type' ),
			'value'    => $instance['type'] ?: 'card_style',
			'choices'  => [
				[
					'key'   => 'card',
					'label' => __( 'カード型', 'swell' ),
					'value' => 'card_style',
				],
				[
					'key'   => 'list',
					'label' => __( 'リスト型', 'swell' ),
					'value' => 'list_style',
				],
			],
		]);
		Widget::check_field([
			'label'       => sprintf( __( '%sを表示する', 'swell' ), __( '投稿日', 'swell' ) ),
			'id'          => $this->get_field_id( 'show_date' ),
			'name'        => $this->get_field_name( 'show_date' ),
			'checked'     => '1' === $instance['show_date'],
		]);
		Widget::check_field([
			'label'       => sprintf( __( '%sを表示する', 'swell' ), __( 'カテゴリー', 'swell' ) ),
			'id'          => $this->get_field_id( 'show_cat' ),
			'name'        => $this->get_field_name( 'show_cat' ),
			'checked'     => '1' === $instance['show_cat'],
		]);

		?>
		<div class="swl-widgetExSetting">
			<div class="__title">
				<?=sprintf( esc_html__( '%sにするページを選択', 'swell' ), '<b>' . esc_html_x( '非表示', 'show', 'swell' ) . '</b>' )?>
			</div>
			<?php
				$hide_arr = [
					'hide_top'     => _x( 'トップページ', 'page', 'swell' ),
					'hide_post'    => _x( '投稿ページ', 'page', 'swell' ),
					'hide_page'    => _x( '固定ページ', 'page', 'swell' ),
					'hide_archive' => _x( 'アーカイブページ', 'page', 'swell' ),
				];
				foreach ( $hide_arr as $key => $label ) :
					Widget::check_field([
						'label'       => $label,
						'id'          => $this->get_field_id( $key ),
						'name'        => $this->get_field_name( $key ),
						'checked'     => '1' === $instance[ $key ],
					]);
				endforeach;
			?>
		</div>
		<?php
	}


	// 保存
	public function update( $new_instance, $old_instance ) {
		$new_instance['title'] = wp_strip_all_tags( $new_instance['title'] );
		return $new_instance;
	}


	// 出力
	public function widget( $args, $instance ) {
		$instance = wp_parse_args( (array) $instance, [
			'title'        => '',
			'num'          => 5,
			'type'         => 'card_style',
			'show_date'    => false, // null -> falseに
			'show_cat'     => false,  // null -> falseに
			'hide_top'     => false,
			'hide_post'    => false,
			'hide_page'    => false,
			'hide_archive' => false,
		] );

		// ajax時は未定義となることに注意
		if ( \SWELL_Theme::is_top() && $instance['hide_top'] ) {
			return;
		} elseif ( is_single() && $instance['hide_post'] ) {
			return;
		} elseif ( is_page() && $instance['hide_page'] ) {
			return;
		} elseif ( is_archive() && $instance['hide_archive'] ) {
			return;
		}

		$widget_title = $instance['title'] ?: __( '新着記事', 'swell' );

		// クエリ生成
		$query_args = [
			'post_status'         => 'publish',
			'no_found_rows'       => true,
			'ignore_sticky_posts' => true,
			'posts_per_page'      => (int) $instance['num'],
		];

		// 除外するカテゴリー・タグ
		$exc_cat = explode( ',', \SWELL_Theme::get_setting( 'exc_cat_id' ) );
		$exc_tag = explode( ',', \SWELL_Theme::get_setting( 'exc_tag_id' ) );

		if ( ! empty( $exc_cat ) ) {
			$query_args['category__not_in'] = $exc_cat;
		}
		if ( ! empty( $exc_tag ) ) {
			$query_args['tag__not_in'] = $exc_tag;
		}

		$list_args = [
			'widget_type' => 'new',
			'list_type'   => $instance['type'],
			'show_date'   => $instance['show_date'],
			'show_cat'    => $instance['show_cat'],
		];

		// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $args['before_widget'];
		echo $args['before_title'] . apply_filters( 'widget_title', $widget_title ) . $args['after_title'];

		// 投稿一覧
		\SWELL_Theme::get_parts( 'parts/post_list/loop_by_widget', [
			'query_args' => $query_args,
			'list_args'  => $list_args,
		] );

		echo $args['after_widget'];
	}
}
