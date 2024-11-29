<?php
namespace SWELL_Theme\Activate;

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'current_screen', function() {
	global $hook_suffix;

	// アクティベートページのみの処理
	if ( false !== strpos( $hook_suffix, 'swell_settings_swellers' ) ) {

		// POSTチェック
		if ( isset( $_POST['swlr_activate_submit'] ) ) {

			$submit_type = $_POST['swlr_activate_submit'];
			$email       = sanitize_email( $_POST['sweller_email'] ?? '' );

			// nonceチェック
			if ( ! \SWELL_Theme::check_nonce( '_activate' ) ) {
				wp_die( esc_html__( '不正アクセスです。', 'swell' ) );
			}

			if ( 'delete' === $submit_type ) {

				\SWELL_Theme\License::delete_swlr( $email );

			} elseif ( 'check' === $submit_type ) {

				// 先にDB程度更新
				update_option( 'sweller_email', $email );

				\SWELL_Theme\License::delete_status_cache();
				\SWELL_Theme\License::check_swlr( $email, 'form' );
			}
		}

		// GETチェック
		// phpcs:ignore
		if ( isset( $_GET['cache'] ) && 'delete' === wp_unslash( $_GET['cache'] ) ) {
			\SWELL_Theme\License::delete_status_cache();
			wp_safe_redirect( admin_url( 'admin.php?page=swell_settings_swellers' ) );
		}
	}

}, 99 );
