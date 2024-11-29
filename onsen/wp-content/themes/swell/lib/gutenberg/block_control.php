<?php
namespace SWELL_Theme\Gutenberg;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * セパレート出力をオン
 */
// add_filter( 'separate_core_block_assets', '__return_true' );

/**
 * 選択できないレガシーウィジェット選択可能にする
 */
add_filter( 'widget_types_to_hide_from_legacy_widget_block', function( $widget_types ) {

	// "pages" , "calendar" , "archives" , "media_audio" , "media_image" , "media_gallery" , "media_video" , "search" , "text" , "categories" , "recent-posts" , "recent-comments" , "rss" , "tag_cloud" , "custom_html" , "block"

	$widget_types = array_diff( $widget_types, ['search', 'custom_html', 'text' ] );
	$widget_types = array_values( $widget_types );
	return $widget_types;
});
