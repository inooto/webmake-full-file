<?php
if ( ! defined( 'ABSPATH' ) ) exit;

if ( \SWELL_Theme::is_top() ) {
	\SWELL_Theme::outuput_widgets( 'sidebar_top' );
}
if ( IS_MOBILE && is_active_sidebar( 'sidebar_sp' ) ) {
	// SPかつsidebar_spがあれば
	\SWELL_Theme::outuput_widgets( 'sidebar_sp' );
} else {
	\SWELL_Theme::outuput_widgets( 'sidebar-1' );
}

if ( ! IS_MOBILE ) {
	\SWELL_Theme::outuput_widgets( 'fix_sidebar', [
		'before' => '<div id="fix_sidebar" class="w-fixSide pc_">',
		'after'  => '</div>',
	] );
}
