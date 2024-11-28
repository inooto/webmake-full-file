<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$the_id    = get_the_ID();
$post_data = get_post( $the_id );

if ( SWELL_Theme::is_show_page_links() ) : // 前の記事・次の記事
	SWELL_Theme::get_parts( 'parts/single/prev_next_link' );
endif;

// CTAウィジェット
SWELL_Theme::outuput_cta();

// 著者情報
$show_meta = get_post_meta( $the_id, 'swell_meta_show_author', true );
if ( 'hide' !== $show_meta && ( 'show' === $show_meta || SWELL_Theme::get_setting( 'show_author' ) ) ) :
	SWELL_Theme::get_parts( 'parts/single/post_author', $post_data->post_author );
endif;

// 関連記事前ウィジェット
\SWELL_Theme::outuput_widgets( 'before_related', [
	'before' => '<div class="l-articleBottom__section w-beforeRelated">',
	'after'  => '</div>',
] );

// 関連記事
$show_meta = get_post_meta( $the_id, 'swell_meta_show_related', true );
if ( 'hide' !== $show_meta && ( 'show' === $show_meta || SWELL_Theme::get_setting( 'show_related_posts' ) ) ) :
	SWELL_Theme::get_parts( 'parts/single/related_post_list' );
endif;

// 関連記事前ウィジェット
\SWELL_Theme::outuput_widgets( 'after_related', [
	'before' => '<div class="l-articleBottom__section w-afterRelated">',
	'after'  => '</div>',
] );
