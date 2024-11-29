<?php
namespace SWELL_Theme\Load_Files;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * jQueryの読み込み
 */
add_action( 'wp', __NAMESPACE__ . '\load_jquery' );
function load_jquery() {
	if ( is_admin() ) return;
	if ( \SWELL_Theme::is_widget_iframe() ) return;

	// いったん登録を削除
	wp_deregister_script( 'jquery' );

	// migrate読み込むかどうか
	$jquerys = ( \SWELL_Theme::get_setting( 'remove_jqmigrate' ) ) ? ['jquery-core' ] : ['jquery-core', 'jquery-migrate' ];

	// jQueryをfootで読み込むかどうか
	if ( \SWELL_Theme::get_setting( 'jquery_to_foot' ) ) {

		// 再登録
		wp_register_script( 'jquery-core', includes_url( '/js/jquery/jquery.js' ), [], '1.12.4-wp', true );
		wp_register_script( 'jquery-migrate', includes_url( '/js/jquery/jquery-migrate.min.js' ), [], '1.4.1', true );
		wp_register_script( 'jquery', false, $jquerys, '1.12.4-wp', true );

	} else {

		// 再登録
		wp_register_script( 'jquery', false, $jquerys, '1.12.4-wp', false );
	}

	if ( \SWELL_Theme::get_setting( 'load_jquery' ) ) {
		wp_enqueue_script( 'jquery' );
	}
}
