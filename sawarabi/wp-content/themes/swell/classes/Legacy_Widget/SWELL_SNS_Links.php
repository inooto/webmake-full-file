<?php
if ( ! defined( 'ABSPATH' ) ) exit;

use \SWELL_Theme\Legacy_Widget as Widget;

/**
 * SNSリンク
 */
class SWELL_SNS_Links extends WP_Widget {
	public function __construct() {
		parent::__construct(
			false,
			$name = __( '[SWELL] SNSリンク', 'swell' ),
			[ 'description' => __( 'SWELLで設定されているSNSリンクを表示', 'swell' ) ]
		);
	}

	// 設定
	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, [
			'title'          => '',
			'show_search'    => false,
			'is_icon_circle' => false,
		] );

		Widget::text_field([
			'label'    => __( 'タイトル', 'swell' ),
			'id'       => $this->get_field_id( 'title' ),
			'name'     => $this->get_field_name( 'title' ),
			'value'    => $instance['title'],
			'help'     => __( '※ 空の場合は何も出力されません。', 'swell' ),
		]);
		Widget::check_field([
			'label'       => __( '「検索」アイコンを表示する', 'swell' ),
			'id'          => $this->get_field_id( 'show_search' ),
			'name'        => $this->get_field_name( 'show_search' ),
			'checked'     => '1' === $instance['show_search'],
		]);
		Widget::check_field([
			'label'       => __( 'アイコンを丸枠で囲む', 'swell' ),
			'id'          => $this->get_field_id( 'is_icon_circle' ),
			'name'        => $this->get_field_name( 'is_icon_circle' ),
			'checked'     => '1' === $instance['is_icon_circle'],
		]);

		?>
		<p><?=esc_html__( 'SNSリンクが設置されます。(カスタマイザーの「SNS設定」でURLが設定されているもの)', 'swell' )?></p>
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
			'title'          => '',
			'show_search'    => false,
			'is_icon_circle' => false,
		] );

		$widget_title   = $instance['title'] ?: '';
		$show_search    = $instance['show_search'];
		$is_icon_circle = $instance['is_icon_circle'];

		// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $args['before_widget'];
		if ( $widget_title ) {
			echo $args['before_title'], apply_filters( 'widget_title', $widget_title ), $args['after_title'];
		}

		// SNSアイコンリスト
		$sns_settings = \SWELL_Theme::get_sns_settings();

		if ( $show_search !== false ) {
			$sns_settings['search'] = 1;
		}
		if ( ! empty( $sns_settings ) ) :
			$list_data = [
				'list_data' => $sns_settings,
			];
			if ( $is_icon_circle === false ) {
				$list_data['fz_class'] = 'u-fz-16';
			} else {
				$list_data['ul_class']  = 'is-style-circle';
				$list_data['fz_class']  = 'u-fz-14';
				$list_data['hov_class'] = 'hov-flash-up';
			}
			\SWELL_Theme::get_parts( 'parts/icon_list', $list_data );
		else :
			esc_html_e( '※ カスタマイザーの「SNS設定」が空です。', 'swell' );
		endif;

		echo $args['after_widget'];
	}
}
