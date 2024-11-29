<?php
namespace SWELL_Theme;

use \SWELL_Theme\Customizer\Sanitize;
use \SWELL_Theme\Customizer\Control\Base_Control;
use \SWELL_Theme\Customizer\Control\Big_Title;
use \SWELL_Theme\Customizer\Control\Sub_Title;
use \SWELL_Theme\Customizer\Control\Color_Control;
use \SWELL_Theme\Customizer\Control\Image_Control;
use \SWELL_Theme\Customizer\Control\Media_Control;
use \SWELL_Theme\Customizer\Control\Old_Img_Control;
use \SWELL_Theme\Customizer\Control\Clear_Media_Control;

if ( ! defined( 'ABSPATH' ) ) exit;

class Customizer {

	// 外部からインスタンス化させない
	private function __construct() {}


	/**
	 * デフォルト値とマージ
	 */
	public static function set_args( $args = [] ) {

		$defaults = [
			'classname'   => '',
			'label'       => '',
			'description' => '',
			'type'        => '',
			'title'       => '',
			'mime_type'   => '',
			'choices'     => [],
			'input_attrs' => [],
			// 'sanitize' => '',
			'transport'   => 'refresh',
			'partial'     => [],
			'target_id'   => '',
		];
		return array_merge( $defaults, $args );
	}


	/**
	 * add
	 */
	public static function add( $section = '', $id = '', $args = [], $Classname = '' ) {

		if ( '' === $id ) return;

		global $wp_customize;

		$args         = self::set_args( $args );
		$customize_id = 'loos_customizer[' . $id . ']';
		$type         = $args['type'];
		$partial      = $args['partial'];

		// setting 用
		$setting_args = [
			'default'           => \SWELL_Theme::get_default_customize( $id ),
			'type'              => 'option',
			'transport'         => $args['transport'],
			'sanitize_callback' => isset( $args['sanitize'] ) ? $args['sanitize'] : Sanitize::get_sanitize_name( $type, $args['mime_type'] ),
		];

		// partialありの時、settingオプション追加
		if ( ! empty( $partial ) ) {
			$setting_args['transport'] = 'postMessage';
		}

		// add setting
		$wp_customize->add_setting( $customize_id, $setting_args );

		// control用
		$control_args = [
			'label'       => $args['label'],
			'description' => $args['description'],
			'section'     => $section,
			'settings'    => $customize_id,
			'type'        => $type,
			'classname'   => $args['classname'],
			'title'       => $args['title'],
			'input_attrs' => $args['input_attrs'],
			'target_id'   => $args['target_id'],
		];

		$control_instance = null;

		// 追加処理
		if ( 'color' === $type ) {

			$control_instance = new Color_Control( $wp_customize, $customize_id, $control_args );

		} elseif ( 'image' === $type ) {

			$control_instance = new Image_Control( $wp_customize, $customize_id, $control_args );

		} elseif ( 'media' === $type ) {

			$control_args['mime_type'] = $args['mime_type'];
			$control_instance          = new Media_Control( $wp_customize, $customize_id, $control_args );

		} elseif ( 'clear-media' === $type ) {

			$control_instance = new Clear_Media_Control( $wp_customize, $customize_id, $control_args );

		} elseif ( 'old-image' === $type ) {

			$control_instance = new Old_Img_Control( $wp_customize, $customize_id, $control_args );

		} elseif ( 'radio' === $type || 'select' === $type ) {

			$control_args['choices'] = $args['choices'];

		} elseif ( 'number' === $type ) {

			$control_args['input_attrs'] = $args['input_attrs'];

		} elseif ( 'code_editor' === $type ) {

			$control_args['code_type'] = $args['code_type'];

		}

		// インスタンスまだなければ Base_Control で生成
		if ( null === $control_instance ) {
			$control_instance = new Base_Control( $wp_customize, $customize_id, $control_args );
		}

		// add control
		$wp_customize->add_control( $control_instance );

		// add partial
		if ( ! empty( $partial ) ) {
			$wp_customize->selective_refresh->add_partial( $customize_id, $partial );
		}
	}


	/**
	 * カスタマイザーの大タイトル
	 */
	public static function big_title( $section = '', $id = '', $args = [] ) {

		if ( '' === $id  ) return;
		$args = self::set_args( $args );

		$control_args = [
			'label'       => $args['label'],
			'description' => $args['description'],
			'section'     => $section,
			'classname'   => $args['classname'],
		];

		global $wp_customize;
		$wp_customize->add_setting( 'big_ttl_' . $id, [] );
		$wp_customize->add_control(
			new Big_Title( $wp_customize, 'big_ttl_' . $id . '', $control_args )
		);
	}

	/**
	 * カスタマイザーのサブタイトル
	 */
	public static function sub_title( $section = '', $id = '', $args = [] ) {

		if ( '' === $id  ) return;
		$args = self::set_args( $args );

		$control_args = [
			'label'       => $args['label'],
			'description' => $args['description'],
			'section'     => $section,
			'classname'   => $args['classname'],
		];

		global $wp_customize;
		$wp_customize->add_setting( 'sub_ttl_' . $id, [] );
		$wp_customize->add_control(
			new Sub_Title( $wp_customize, 'sub_ttl_' . $id . '', $control_args )
		);
	}


	/**
	 * 存在しないメディアIDがセットされているかどうかをチェック
	 */
	public static function is_non_existent_media_id( $id ) {
		return $id && is_int( $id ) && ! wp_attachment_is_image( $id );
	}

}
