<?php
namespace SWELL_Theme\Customizer;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * $wp_customize->selective_refresh->add_partialのコールバックを集めたクラス
 */
class Partial {

	private function __construct() {}

	/**
	 * ヘッダーロゴ
	 */
	public static function head_logo() {
		$logo = \SWELL_PARTS::head_logo();
		return $logo;
	}


	/**
	 * 記事スライダー
	 */
	public static function post_slider() {
		if ('on' !== \SWELL_Theme::get_setting( 'show_post_slide' ) ) return '';

		ob_start();
		\SWELL_Theme::get_parts( 'parts/top/post_slider' );
		return ob_get_clean();
	}


	/**
	 * パンくず
	 */
	public static function breadcrumb() {
		ob_start();
		\SWELL_Theme::get_parts( 'parts/breadcrumb' );
		return ob_get_clean();
	}
}
