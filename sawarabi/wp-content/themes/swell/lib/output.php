<?php
namespace SWELL_Theme\Output;

use \SWELL_Theme as SWELL,
	SWELL_Theme\Style;

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_head', __NAMESPACE__ . '\hook_wp_head_9', 9 );
add_action( 'wp_head', __NAMESPACE__ . '\hook_wp_head_999', 999 );
add_action( 'wp_footer', __NAMESPACE__ . '\hook_wp_footer_1', 1 );
add_action( 'wp_footer', __NAMESPACE__ . '\hook_wp_footer_20', 20 );
add_action( 'admin_head', __NAMESPACE__ . '\hook_admin_head', 20 );
add_action( 'wp_body_open', __NAMESPACE__ . '\hook_wp_body_open', 1 );

// @phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped

/**
 * wp_headで出力するコード 優先度：9
 */
function hook_wp_head_9() {

	echo PHP_EOL;
	output_google_font();
	output_noscript_css();
}


/**
 * wp_headで出力するコード 優先度：999 → カスタムCSSより後で出力する
 */
function hook_wp_head_999() {

	echo PHP_EOL;

	// 印刷用CSS
	// phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedStylesheet
	echo '<link rel="stylesheet" href="' . esc_attr( T_DIRE_URI ) . '/build/css/print.css" media="print" >';

	echo PHP_EOL;

	// 記事ごとのカスタムCSSの出力
	output_meta_custom_css();

	// 「head内コード」の出力
	if ( $head_code = SWELL::get_setting( 'head_code' ) ) echo $head_code . PHP_EOL;

	// 「自動広告用コード」の出力
	output_auto_ad();

}


/**
 * wp_footerで出力するコード 優先度:1
 */
function hook_wp_footer_1() {

	// スクロール監視用
	echo '<div class="l-scrollObserver" aria-hidden="true"></div>';

	$pjax = SWELL::is_use( 'pjax' );

	// lazysizes
	if ( $pjax || SWELL::is_use( 'lazysizes' ) ) {
		wp_enqueue_script( 'swell_lazysizes', T_DIRE_URI . '/assets/js/plugins/lazysizes.min.js', [], SWELL_VERSION, true );
	}

	if ( $pjax || SWELL::is_use( 'fix_header' ) ) {
		wp_enqueue_script( 'swell_set_fix_header', T_DIRE_URI . '/build/js/front/set_fix_header.min.js', [], SWELL_VERSION, true );
	}

	if ( $pjax || SWELL::is_use( 'ol_start' ) ) {
		wp_enqueue_script( 'swell_set_olstart', T_DIRE_URI . '/build/js/front/set_olstart.min.js', [], SWELL_VERSION, true );
	}

	if ( $pjax || SWELL::is_use( 'rellax' ) ) {
		wp_enqueue_script( 'swell_set_rellax', T_DIRE_URI . '/build/js/front/set_rellax.min.js', [ 'swell_rellax' ], SWELL_VERSION, true );
	}

	if ( $pjax || SWELL::is_use( 'count_CTR' ) ) {
		wp_enqueue_script( 'swell_count_CTR', T_DIRE_URI . '/build/js/front/count_CTR.min.js', [], SWELL_VERSION, true );
	}

	// accordion
	if ( $pjax || SWELL::is_use( 'accordion' ) ) {
		wp_enqueue_script( 'swell_accordion', T_DIRE_URI . '/build/js/front/accordion.min.js', [], SWELL_VERSION, true );
	}

	// Luminous
	if ( $pjax || SWELL::is_use( 'luminous' ) ) {
		wp_enqueue_style( 'swell_luminous', T_DIRE_URI . '/build/css/plugins/luminous.css', [], SWELL_VERSION );
		wp_enqueue_script( 'swell_set_luminous', T_DIRE_URI . '/build/js/front/set_luminous.min.js', [ 'swell_luminous' ], SWELL_VERSION, true );
		wp_localize_script( 'swell_set_luminous', 'swlLuminousVars', [ 'postImg' => ! SWELL::get_setting( 'remove_luminous' ) ] );
	}

	// clipboard.js
	if ( $pjax || SWELL::is_use( 'clipboard' ) ) {
		wp_enqueue_script( 'swell_set_urlcopy', T_DIRE_URI . '/build/js/front/set_urlcopy.min.js', [ 'clipboard' ], SWELL_VERSION, true );
	}

	// pinit.js
	if ( $pjax || SWELL::is_use( 'pinterest' ) ) {
		// phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedScript
		echo '<script async defer src="//assets.pinterest.com/js/pinit.js"></script>';
	}
}


/**
 * wp_footerで出力するコード 優先度:20
 */
function hook_wp_footer_20() {

	// JSON LD
	if ( SWELL::get_setting( 'use_json_ld' ) ) {
		$ld = \SWELL_Theme\Json_Ld::generate();
		if ( $ld ) {
			echo PHP_EOL . '<!-- JSON-LD @SWELL -->' . PHP_EOL;
			echo '<script type="application/ld+json">' . $ld . '</script>'; // phpcs:ignore WordPress.Security
			echo PHP_EOL . '<!-- / JSON-LD @SWELL -->' . PHP_EOL;
		}
}

	// Custom JS の出力
	output_meta_custom_js();
}


/**
 * admin_headで出力するコード
 * スタイル用
 */
function hook_admin_head() {

	global $hook_suffix;
	$is_swell_page   = strpos( $hook_suffix, 'swell_settings' ) !== false;
	$is_balloon_page = strpos( $hook_suffix, 'swell_balloon' ) !== false;

	if ( $is_swell_page || $is_balloon_page ) {
		echo '<style id="loos-block-style">' . Style::get_editor_css() . '</style>' . PHP_EOL;
	}
}



/**
 * wp_body_open()で出力するコード
 */
function hook_wp_body_open() {

	if ( $body_open_code = SWELL::get_setting( 'body_open_code' ) ) {
		echo $body_open_code . PHP_EOL;
	}
}


/**
 * WEBフォント
 */
function output_google_font() {
	$google_font = SWELL::get_google_font();
	if ( ! $google_font ) return;

	// phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedStylesheet
	echo '<link href="' . esc_url( $google_font ) . '" rel="stylesheet">' . PHP_EOL;
}


/**
 * noscript時CSS
 */
function output_noscript_css() {
	// phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedStylesheet
	echo '<noscript><link href="' . esc_url( T_DIRE_URI . '/build/css/noscript.css' ) . '" rel="stylesheet"></noscript>' . PHP_EOL;
}


/**
 * 記事ごとのカスタムCSSの出力
 */
function output_meta_custom_css() {
	$css      = '';
	$is_plane = false;

	if ( is_single() || is_page() || is_home() ) {
		$the_ID   = get_queried_object_id();
		$css      = get_post_meta( $the_ID, 'swell_meta_css', true );
		$is_plane = get_post_meta( $the_ID, 'swell_meta_css_plane', true ) ?: false;
	}

	if ( SWELL::is_use( 'pjax' ) && ! $is_plane ) {

		echo '<style id="swell_custom_css">' . $css . '</style>' . PHP_EOL; // pjax時は空でも出力

	} elseif ( $css ) {

		if ( $is_plane ) {
			echo $css . PHP_EOL;
		} else {
			echo '<style id="swell_custom_css">' . $css . '</style>' . PHP_EOL;
		}
	}
}


/**
 * 記事ごとのカスタムJSの出力
 */
function output_meta_custom_js() {
	$js       = '';
	$is_plane = false;

	if ( is_single() || is_page() || is_home() ) {
		$the_ID   = get_queried_object_id();
		$js       = get_post_meta( $the_ID, 'swell_meta_js', true );
		$is_plane = get_post_meta( $the_ID, 'swell_meta_js_plane', true ) ?: false;
	}

	if ( SWELL::is_use( 'pjax' ) && ! $is_plane ) {

		echo '<script id="swell_custom_js">' . $js . '</script>' . PHP_EOL; // pjax時は空でも出力

	} elseif ( $js ) {

		if ( $is_plane ) {
			echo $js . PHP_EOL;
		} else {
			echo '<script id="swell_custom_js">' . $js . '</script>' . PHP_EOL;
		}
	}
}


/**
 * 自動広告用コード
 */
function output_auto_ad() {
	if ( is_single() || is_page() || is_home() ) {
		$is_hide_ad = get_post_meta( get_the_ID(), 'swell_meta_hide_autoad', true );
		if ( '1' === $is_hide_ad ) return;
	}

	$auto_ad_code = SWELL::get_setting( 'auto_ad_code' );

	if ( ! $auto_ad_code) return;

	echo $auto_ad_code . PHP_EOL;
}
