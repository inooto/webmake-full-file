<?php
if ( version_compare( phpversion(), '7.3.0', '<' ) ) {
	$GLOBALS['swell_env_err_text'] = sprintf( __( 'お使いのPHPバージョン(%s)がSWELLの必要動作環境を満たしていません。PHPバージョン7.3.0以上へ更新してください。', 'swell' ), phpversion() );
}
if ( version_compare( get_bloginfo( 'version' ), '5.6', '<' ) ) {
	$GLOBALS['swell_env_err_text'] = sprintf( __( 'お使いのWordPressバージョン(%s)がSWELLの必要動作環境を満たしていません。WordPressバージョン5.6以上へ更新してください。', 'swell' ), get_bloginfo( 'version' ) );
}

if ( isset( $GLOBALS['swell_env_err_text'] ) ) {
	add_action( 'admin_notices', function () {
		echo '<div class="notice error"><p>' . $GLOBALS['swell_env_err_text'] . '</p></div>'; // phpcs:ignore
	} );
}
