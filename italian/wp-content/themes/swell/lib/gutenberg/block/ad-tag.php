<?php
namespace SWELL_Theme\Block\Ad_Tag;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * 広告タグ
 */
\SWELL_Theme::register_block( 'ad-tag', [
	'render_callback' => function( $attrs ) {
		// \SWELL_Theme::set_use( 'count_CTR', true );
		ob_start();
		echo do_shortcode( '[ad_tag id="' . $attrs['adID'] . '" class="' . $attrs['className'] . '"]' );
		return ob_get_clean();
	},
] );
