<?php
if ( ! defined( 'ABSPATH' ) ) exit;

use \SWELL_Theme\Legacy_Widget as Widget;

/**
 * 広告表示用のウィジェット
 */
class SWELL_Ad_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct(
			false,
			$name = __( '[SWELL] 広告コード', 'swell' ),
			['description' => __( '広告表示エリア', 'swell' ) ]
		);
	}

	// 設定
	public function form( $instance ) {

		$instance = wp_parse_args( (array) $instance, [
			'code'  => '',
			'is_pc' => false,
			'is_sp' => false,
		] );

		Widget::textarea_field([
			'label'    => __( '広告タグ', 'swell' ),
			'id'       => $this->get_field_id( 'code' ),
			'name'     => $this->get_field_name( 'code' ),
			'value'    => $instance['code'],
			'rows'     => '8',
		]);
		Widget::check_field([
			'label'       => __( 'PCのみ表示する', 'swell' ),
			'id'          => $this->get_field_id( 'is_pc' ),
			'name'        => $this->get_field_name( 'is_pc' ),
			'checked'     => ! empty( $instance['is_pc'] ), // 昔オンの時 'on' だった
		]);
		Widget::check_field([
			'label'       => __( 'SPのみ表示する', 'swell' ),
			'id'          => $this->get_field_id( 'is_sp' ),
			'name'        => $this->get_field_name( 'is_sp' ),
			'checked'     => ! empty( $instance['is_sp'] ),
		]);
	}

	// 保存
	public function update( $new_instance, $old_instance ) {
		return $new_instance;
	}


	// 出力
	public function widget( $args, $instance ) {
		$instance = wp_parse_args( (array) $instance, [
			'code'  => '',
			'is_pc' => false,
			'is_sp' => false,
		] );

		// 本文を取得
		$code  = $instance['code'];
		$is_pc = ! empty( $instance['is_pc'] );
		$is_sp = ! empty( $instance['is_sp'] );

		// ウィジェットプレビュー時
		if ( \SWELL_Theme::is_widget_iframe() ) {
			echo '<pre>' . esc_html( $code ) . '</pre>';
			return;
		}

		// memo: チェックボックスで実装しているので、両方チェックがある場合も考慮しなくてはいけない。
		if ( ( $is_pc && $is_sp ) || ( ! $is_pc && ! $is_sp ) ) {
			// 両方表示
			$before_widget = $args['before_widget'];

		} elseif ( $is_pc ) {
			// PCのみ表示する
			$before_widget = str_replace( 'widget_swell_ad_widget', 'widget_swell_ad_widget pc_', $args['before_widget'] );

		} elseif ( $is_sp ) {
			// モバイルのみ表示する
			$before_widget = str_replace( 'widget_swell_ad_widget', 'widget_swell_ad_widget sp_', $args['before_widget'] );

		} else {
			$before_widget = $args['before_widget'];
		}

		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $before_widget . do_shortcode( $code ) . $args['after_widget'];

	}

}
