<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$the_id = get_queried_object_id();

// 記事タイトル
if ( ! SWELL_Theme::is_show_ttltop() ) {
	\SWELL_Theme::pluggable_parts( 'page_title', [
		'title'     => get_the_title( $the_id ), // home.php用に get_queried_object_id をしっかり渡す
		'subtitle'  => get_post_meta( $the_id, 'swell_meta_subttl', true ),
		'has_inner' => true,
	] );
}

// アイキャッチ画像
if ( SWELL_Theme::is_show_thumb( $the_id ) ) {
	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo SWELL_PARTS::post_thumbnail( $the_id );
}

// コンテンツ上ウィジェット
SWELL_Theme::outuput_content_widget( 'page', 'top' );
