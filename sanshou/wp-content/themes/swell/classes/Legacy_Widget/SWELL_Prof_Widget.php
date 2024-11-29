<?php
if ( ! defined( 'ABSPATH' ) ) exit;

use \SWELL_Theme\Legacy_Widget as Widget;

/**
 * プロフィール表示用のウィジェット
 * @phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
 */
class SWELL_Prof_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct(
			false,
			$name = __( '[SWELL] プロフィール', 'swell' ),
			['description' => __( '運営者プロフィールを表示', 'swell' ) ]
		);
	}

	// 設定
	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, [
			'user_name'      => '',
			'user_job'       => '',
			'user_profile'   => '',
			'user_icon'      => '',
			'user_bg'        => '',
			'btn_link'       => '',
			'btn_text'       => '',
			'btn_color'      => '#666',
			'show_user_sns'  => false,
			'is_icon_circle' => false,
		] );

		Widget::text_field([
			'label'    => __( '名前', 'swell' ),
			'id'       => $this->get_field_id( 'user_name' ),
			'name'     => $this->get_field_name( 'user_name' ),
			'value'    => $instance['user_name'],
		]);
		Widget::text_field([
			'label'    => __( '役職（肩書き）', 'swell' ),
			'id'       => $this->get_field_id( 'user_job' ),
			'name'     => $this->get_field_name( 'user_job' ),
			'value'    => $instance['user_job'],
		]);
		Widget::textarea_field([
			'label'    => __( 'プロフィール文', 'swell' ),
			'id'       => $this->get_field_id( 'user_profile' ),
			'name'     => $this->get_field_name( 'user_profile' ),
			'value'    => $instance['user_profile'],
		]);
		Widget::media_field([
			'label'       => __( 'アイコン画像', 'swell' ),
			'id'          => $this->get_field_id( 'user_icon' ),
			'name'        => $this->get_field_name( 'user_icon' ),
			'value'       => $instance['user_icon'],
			'width'       => '120px',
			'height'      => '120px',
			'field_class' => '-center',
		]);
		Widget::media_field([
			'label'       => __( 'プロフィール背景画像', 'swell' ),
			'id'          => $this->get_field_id( 'user_bg' ),
			'name'        => $this->get_field_name( 'user_bg' ),
			'value'       => $instance['user_bg'],
			'field_class' => '-center',
		]);
		Widget::text_field([
			'label'       => __( 'ボタンリンク先', 'swell' ),
			'id'          => $this->get_field_id( 'btn_link' ),
			'name'        => $this->get_field_name( 'btn_link' ),
			'value'       => $instance['btn_link'],
			'placeholder' => __( 'URLを入力', 'swell' ),
		]);
		Widget::text_field([
			'label'       => __( 'ボタンテキスト', 'swell' ),
			'id'          => $this->get_field_id( 'btn_text' ),
			'name'        => $this->get_field_name( 'btn_text' ),
			'value'       => $instance['btn_text'],
		]);
		Widget::color_field([
			'label'       => __( 'ボタンの色', 'swell' ),
			'id'          => $this->get_field_id( 'btn_color' ),
			'name'        => $this->get_field_name( 'btn_color' ),
			'value'       => $instance['btn_color'],
		]);
		Widget::check_field([
			'label'       => __( 'SNSアイコンリストを表示する', 'swell' ),
			'id'          => $this->get_field_id( 'show_user_sns' ),
			'name'        => $this->get_field_name( 'show_user_sns' ),
			'checked'     => ! empty( $instance['show_user_sns'] ),
		]);
		Widget::check_field([
			'label'       => __( 'アイコンを丸枠で囲む', 'swell' ),
			'id'          => $this->get_field_id( 'is_icon_circle' ),
			'name'        => $this->get_field_name( 'is_icon_circle' ),
			'checked'     => ! empty( $instance['is_icon_circle'] ),
		]);
	}


	// 保存
	public function update( $new_instance, $old_instance ) {
		$new_instance['user_name']    = wp_strip_all_tags( $new_instance['user_name'] );
		$new_instance['user_job']     = wp_strip_all_tags( $new_instance['user_job'] );
		$new_instance['btn_link']     = wp_strip_all_tags( trim( $new_instance['btn_link'] ) );
		$new_instance['btn_text']     = wp_strip_all_tags( $new_instance['btn_text'] );
		$new_instance['user_profile'] = wp_kses_post( $new_instance['user_profile'] );
		return $new_instance;
	}


	// 出力
	public function widget( $args, $instance ) {
		// echo '<pre style="margin: 100px;">';
		// var_dump( get_option( 'widget_swell_prof_widget' ) );
		// echo '</pre>';

		$instance = wp_parse_args( (array) $instance, [
			'user_name'      => '',
			'user_job'       => '',
			'user_profile'   => '',
			'user_icon'      => '',
			'user_bg'        => '',
			'btn_link'       => '',
			'btn_text'       => '',
			'btn_color'      => '#666',
			'show_user_sns'  => false,
			'is_icon_circle' => false,
		] );

		echo $args['before_widget'];
		\SWELL_Theme::get_parts( 'parts/profile_box', $instance );
		echo $args['after_widget'];
	}
}
