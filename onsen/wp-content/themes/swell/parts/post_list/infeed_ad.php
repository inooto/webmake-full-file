<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$infeed = ( IS_MOBILE ) ? SWELL_Theme::get_setting( 'infeed_code_sp' ) : SWELL_Theme::get_setting( 'infeed_code_pc' );
if ( ! empty( $infeed ) ) {
	echo '<li class="p-postList__item c-infeedAd">' . do_shortcode( $infeed ) . '</li>';
}
