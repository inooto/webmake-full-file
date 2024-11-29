<?php
if ( ! defined( 'ABSPATH' ) ) exit;

use \SWELL_Theme\Legacy_Widget as Widget;

/**
 * 目次ウィジェット
 */
class SWELL_Index extends WP_Widget {
	public function __construct() {
		parent::__construct(
			false,
			$name = __( '[SWELL] 目次', 'swell' ),
			['description' => __( '目次を表示', 'swell' ) ]
		);
	}


	// 設定
	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, [
			'title' => '',
		] );

		Widget::text_field([
			'label'    => __( 'タイトル', 'swell' ),
			'id'       => $this->get_field_id( 'title' ),
			'name'     => $this->get_field_name( 'title' ),
			'value'    => $instance['title'],
		]);

		echo '<p class="u-lh-15"><small>' . esc_html__( '※ 記事ページでのみ表示されます。また、目次用デザインは適用されないので「サイドバー」でご利用ください。', 'swell' ) . '</small></p>';
	}


	// 保存
	public function update( $new_instance, $old_instance ) {
		$new_instance['title'] = wp_strip_all_tags( $new_instance['title'] );
		return $new_instance;
	}


	// 出力
	public function widget( $args, $instance ) {
		if ( ! ( is_single() || is_page() || is_archive() ) ) return;

		$instance = wp_parse_args( (array) $instance, [
			'title' => '',
		] );

		$widget_title = $instance['title'] ?: __( '目次', 'swell' );

		// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $args['before_widget'] . $args['before_title'] . apply_filters( 'widget_title', $widget_title ) . $args['after_title'];
		echo '<div class="p-toc post_content"></div>';
		echo $args['after_widget'];
	}
}
