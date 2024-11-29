<?php
namespace SWELL_Theme\Update;

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'admin_init', function() {

	// sslverifyオフ
	add_filter( 'puc_request_update_options_theme-swell', function( $option ) {
		$option['sslverify'] = false;
		return $option;
	} );

	if ( ! class_exists( '\Puc_v4_Factory' ) ) {
		require_once T_DIRE . '/lib/update/plugin-update-checker.php';
	}

	if ( class_exists( '\Puc_v4_Factory' ) ) {
		\Puc_v4_Factory::buildUpdateChecker(
			\SWELL_Theme::get_update_json_path(),
			T_DIRE . '/functions.php',
			'swell'
		);
	}
}, 99 );
