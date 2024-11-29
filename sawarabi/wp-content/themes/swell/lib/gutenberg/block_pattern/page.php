<?php
namespace SWELL_Theme\Gutenberg;

if ( ! defined( 'ABSPATH' ) ) exit;


// パターンカテゴリーを登録
$pattern_category = 'swell-page-patterns';
register_block_pattern_category(
	$pattern_category,
	[ 'label' => '[SWELL] ' . __( 'ページ用', 'swell' ) ]
);


$big_text      = '<!-- wp:paragraph {"fontSize":"large"} -->' . $n . '<p class="has-large-font-size">' . __( '大きなテキスト', 'swell' ) . '</p>' . $n . '<!-- /wp:paragraph -->';
$media_content = '<div class="wp-block-media-text__content">' . $big_text . $paragraph . '</div>';


/**
 * カード型のメディアと文章
 */
$figure01 = '<figure class="wp-block-media-text__media" style="background-image:url(https://s.w.org/images/core/5.3/MtBlanc1.jpg);background-position:50% 50%"><img src="https://s.w.org/images/core/5.3/MtBlanc1.jpg" alt=""/></figure>';

$content__double_card = '<!-- wp:media-text {"mediaId":0,"mediaLink":"","mediaType":"image","imageFill":true,"className":"is-style-card"} -->' .
	$n .
	'<div class="wp-block-media-text alignwide is-stacked-on-mobile is-image-fill is-style-card">' . $figure01 . $media_content . '</div>' .
	$n .
	'<!-- /wp:media-text -->' .
	$n .
	'<!-- wp:media-text {"mediaPosition":"right", "mediaId":0,"mediaLink":"","mediaType":"image","imageFill":true,"className":"is-style-card"} -->' .
	$n .
	'<div class="wp-block-media-text alignwide has-media-on-the-right is-stacked-on-mobile is-image-fill is-style-card">' . $figure01 . $media_content . '</div>' .
	$n .
	'<!-- /wp:media-text -->' .
$n;

register_block_pattern( 'swell-pattern/media-text-double-card', [
	'title'       => __( 'カード型のメディアと文章', 'swell' ),
	'content'     => $content__double_card,
	'categories'  => [ $pattern_category ],
	'description' => '',
] );


/**
 * ブロークン型のメディアと文章
 */
$figure02 = '<figure class="wp-block-media-text__media" style="background-image:url(https://s.w.org/images/core/5.3/Windbuchencom.jpg);background-position:50% 50%"><img src="https://s.w.org/images/core/5.3/Windbuchencom.jpg" alt=""/></figure>';

$paragraph__R = '<!-- wp:paragraph {"align":"right"} -->' .
$n .
'<p class="has-text-align-right">' . __( 'ここは段落ブロックです。文章をここに入力してください。', 'swell' ) . '</p>' . $n . '<!-- /wp:paragraph -->';
$big_text__R  = '<!-- wp:paragraph {"align":"right", "fontSize":"large"} -->' . $n . '<p class="has-text-align-right has-large-font-size">' . __( '大きなテキスト', 'swell' ) . '</p>' . $n . '<!-- /wp:paragraph -->';

$media_content__L = '<div class="wp-block-media-text__content"><!-- wp:group {"backgroundColor":"white"} -->' . $n . '<div class="wp-block-group has-white-background-color has-background">' . $big_text . $paragraph . '</div>' . $n . '<!-- /wp:group --></div>';
$media_content__R = '<div class="wp-block-media-text__content"><!-- wp:group {"backgroundColor":"white"} -->' . $n . '<div class="wp-block-group has-white-background-color has-background">' . $big_text__R . $paragraph__R . '</div>' . $n . '<!-- /wp:group --></div>';

$content__double_card = '<!-- wp:media-text {"mediaId":0,"mediaLink":"","mediaType":"image","imageFill":true,"className":"is-style-broken"} -->' . $n . '<div class="wp-block-media-text alignwide is-stacked-on-mobile is-image-fill is-style-broken">' . $figure02 . $media_content__L . '</div>' . $n . '<!-- /wp:media-text -->' . $n . '<!-- wp:media-text {"mediaPosition":"right", "mediaId":0,"mediaLink":"","mediaType":"image","imageFill":true,"className":"is-style-broken"} -->' . $n . '<div class="wp-block-media-text alignwide has-media-on-the-right is-stacked-on-mobile is-image-fill is-style-broken">' . $figure02 . $media_content__R . '</div>' . $n . '<!-- /wp:media-text -->' . $n;

register_block_pattern(
	'swell-pattern/media-text-double-broken',
	[
		'title'       => __( 'ブロークン型のメディアと文章', 'swell' ),
		'content'     => $content__double_card,
		'categories'  => [ $pattern_category ],
		'description' => '',
	]
);


/**
 * フルワイドセクション
 */
// $content__fullwide = '<!-- wp:loos/full-wide -->' . $n . '<div class="swell-block-fullWide pc-py-60 sp-py-40 alignfull" style="background-color:#f7f7f7"><div class="swell-block-fullWide__inner l-article"><!-- wp:heading {"className":"is-style-section_ttl"} -->' . $n . '<h2 class="is-style-section_ttl">' . __( 'セクション', 'swell' ) . '<small class="mininote">section</small></h2>' . $n . '<!-- /wp:heading -->' . $n . $n . $paragraph . '</div></div>' . $n . '<!-- /wp:loos/full-wide -->' . $n;

// register_block_pattern(
// 	'swell-pattern/full-wide-section',
// 	[
// 		'title'       => __( 'フルワイドセクション', 'swell' ),
// 		'content'     => $content__fullwide,
// 		'categories'  => [ $pattern_category ],
// 		'description' => '',
// 	]
// );
