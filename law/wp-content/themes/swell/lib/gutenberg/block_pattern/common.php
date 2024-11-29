<?php
namespace SWELL_Theme\Gutenberg\Patterns;

if ( ! defined( 'ABSPATH' ) ) exit;

// パターンカテゴリーを登録
$pattern_category = 'swell-patterns';
register_block_pattern_category(
	$pattern_category,
	[ 'label' => '[SWELL] ' . __( '汎用パターン', 'swell' ) ]
);

function render_ul( $content ) {
	return '<!-- wp:list -->' . "\n" .
	'<ul>' . $content . '</ul>' . "\n" .
	'<!-- /wp:list -->';
};
function render_list_item( $text ) {
	return '<li>' . $text . '</li>';

	// 6.1 からはこっち → 後方互換的にしばらく6.0までの方にしておく
	// return '<!-- wp:list-item -->' . "\n" .
	// '<li>' . $text . '</li>' . "\n" .
	// '<!-- /wp:list-item -->';
};

$LIST_TEXT    = __( 'リスト', 'swell' );
$LISTS_TRIPLE = render_ul( render_list_item( $LIST_TEXT ) . render_list_item( $LIST_TEXT ) . render_list_item( $LIST_TEXT ) );


// パターン1
$PATTERN_1 = '<!-- wp:paragraph {"align":"center","className":"u-mb-0 u-mb-ctrl","style":{"typography":{"lineHeight":"2"}}} -->' . $n .
'<p class="has-text-align-center u-mb-0 u-mb-ctrl" style="line-height:2"><span class="swl-fz u-fz-s">' . __( '＼ ぼたんだよ ／', 'swell' ) . '</span></p>' . $n .
'<!-- /wp:paragraph -->' . $n .
$n .
'<!-- wp:loos/button {"hrefUrl":"###","iconName":"LsCart","color":"blue","className":"is-style-btn_normal"} -->' . $n .
'<div class="swell-block-button blue_ is-style-btn_normal"><a href="###" class="swell-block-button__link" data-has-icon="1"><svg class="__icon" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" viewBox="0 0 48 48"><circle cx="37.5" cy="42.5" r="4"></circle><circle cx="13.5" cy="42.5" r="4"></circle><path d="M43.5 8.5H10.2l-.7-5.3c-.1-1-1-1.7-2-1.7h-5c-1.1 0-2 .9-2 2s.9 2 2 2h3.2l3.8 29.3c.1 1 1 1.7 2 1.7h29c1.1 0 2-.9 2-2s-.9-2-2-2H13.3l-.4-4h28.6c1 0 1.9-.8 2-1.8l2-16c.1-1.1-.8-2.2-2-2.2z"></path></svg><span>購入する</span></a></div>' . $n .
'<!-- /wp:loos/button -->';


register_block_pattern(
	'swell-pattern/button-with-microcopy',
	[
		'title'         => __( 'マイクロコピーとアイコン付きのボタン', 'swell' ),
		'content'       => $PATTERN_1,
		'categories'    => [ $pattern_category ],
		'description'   => '',
		'viewportWidth' => 600,
		'blockTypes'    => [ 'core/paragraph', 'loos/button' ],
	]
);


// パターン2
$PATTERN_2 = '<!-- wp:group {"className":"has-border -border01"} -->' . $n .
'<div class="wp-block-group has-border -border01">' . $LISTS_TRIPLE . '</div>' . $n .
'<!-- /wp:group -->';

register_block_pattern(
	'swell-pattern/list-border',
	[
		'title'         => __( '枠線付きのリスト', 'swell' ),
		'content'       => $PATTERN_2,
		'categories'    => [ $pattern_category ],
		'description'   => '',
		'viewportWidth' => 600,
		'blockTypes'    => [ 'core/list', 'core/group' ],
		'keywords'      => [ 'list', 'group', 'リスト', 'グループ' ],
	]
);


// パターン3
$PATTERN_3 = '<!-- wp:group {"className":"has-border -border04", "backgroundColor":"swl-pale-02"} -->' . $n .
'<div class="wp-block-group has-border -border04 has-swl-pale-02-background-color has-background">' . $LISTS_TRIPLE . '</div>' . $n .
'<!-- /wp:group -->';

register_block_pattern(
	'swell-pattern/list-border-bg',
	[
		'title'         => __( '薄い枠線と背景付きのリスト', 'swell' ),
		'content'       => $PATTERN_3,
		'categories'    => [ $pattern_category ],
		'description'   => '',
		'viewportWidth' => 600,
		'blockTypes'    => [ 'core/list', 'core/group' ],
		'keywords'      => [ 'list', 'group', 'リスト', 'グループ' ],
	]
);


// パターン4
$PATTERN_4 = '<!-- wp:group {"className":"is-style-big_icon_point"} -->' . $n .
'<div class="wp-block-group is-style-big_icon_point">' . $paragraph . $n .
$LISTS_TRIPLE . '</div>' . $n .
'<!-- /wp:group -->';

register_block_pattern(
	'swell-pattern/point-group',
	[
		'title'         => __( 'ポイントグループ', 'swell' ),
		'content'       => $PATTERN_4,
		'categories'    => [ $pattern_category ],
		'description'   => '',
		'viewportWidth' => 600,
		'blockTypes'    => [ 'core/list', 'core/group' ],
		'keywords'      => [ 'list', 'group', 'リスト', 'グループ' ],
	]
);

// パターン5
function render_rich_column( $content ) {
	return '<!-- wp:loos/column -->' . "\n" .
	'<div class="swell-block-column swl-has-mb--s">' . $content . '</div>' . "\n" .
	'<!-- /wp:loos/column -->';
};
function render_link_list_p5( $content ) {
	return '<!-- wp:loos/link-list {"listStyle":"button","icon":"swl-svg-chevronRight","iconPos":"right","fontSize":"0.9em","color":"var(\u002d\u002dcolor_main)","isFill":true} -->' . "\n" .
	'<ul class="swell-block-linkList is-style-button -fill" style="--the-fz:0.9em;--the-color:var(--color_main)">' . $content . '</ul>' . "\n" .
	'<!-- /wp:loos/link-list -->';
};
function render_link_list_item( $text ) {
		return '<!-- wp:loos/link-list-item -->' . "\n" .
		'<li class="swell-block-linkList__item"><a class="swell-block-linkList__link">' .
		'<!-- icon-placeholder --><span class="swell-block-linkList__text">' . $text . '</span>' .
		'</a></li>' . "\n" .
		'<!-- /wp:loos/link-list-item -->';
};

function render_img_p5( $img ) {
	return '<!-- wp:image {"width":90,"height":90,"sizeSlug":"full","linkDestination":"none","className":"is-style-border"} -->
	<figure class="wp-block-image size-full is-resized is-style-border"><img src="' . $img . '" alt="" width="90" height="90"/></figure>
	<!-- /wp:image -->';
};


$PATTERN_5 = '<!-- wp:loos/columns {"colPC":"4","colMobile":"2"} -->
<div class="swell-block-columns" style="--clmn-w--pc:25%;--clmn-w--mobile:50%"><div class="swell-block-columns__inner">' .
	render_rich_column(
		render_img_p5( $noimg ) .
		render_link_list_p5(
			render_link_list_item( 'カテゴリーA' ) .
			render_link_list_item( 'カテゴリーB' ) .
			render_link_list_item( 'カテゴリーC' ) .
			render_link_list_item( 'カテゴリーD' )
		)
	) .
	render_rich_column(
		render_img_p5( $noimg ) .
		render_link_list_p5(
			render_link_list_item( 'カテゴリーE' ) .
			render_link_list_item( 'カテゴリーF' ) .
			render_link_list_item( 'カテゴリーG' ) .
			render_link_list_item( 'カテゴリーH' )
		)
	) .
	render_rich_column(
		render_img_p5( $noimg ) .
		render_link_list_p5(
			render_link_list_item( 'カテゴリーI' ) .
			render_link_list_item( 'カテゴリーJ' ) .
			render_link_list_item( 'カテゴリーK' ) .
			render_link_list_item( 'カテゴリーL' )
		)
	) .
	render_rich_column(
		render_img_p5( $noimg ) .
		render_link_list_p5(
			render_link_list_item( 'カテゴリーM' ) .
			render_link_list_item( 'カテゴリーN' ) .
			render_link_list_item( 'カテゴリーO' ) .
			render_link_list_item( 'カテゴリーP' )
		)
	) .
'</div></div>
<!-- /wp:loos/columns -->';

register_block_pattern(
	'swell-pattern/link-list-A',
	[
		'title'         => __( 'カテゴリー導線', 'swell' ),
		'content'       => $PATTERN_5,
		'categories'    => [ $pattern_category ],
		'description'   => '',
		'viewportWidth' => 1000,
		'blockTypes'    => [ 'loos/link-list', 'loos/columns' ],
		'keywords'      => [ 'list', 'link', 'リスト', 'リンク' ],
	]
);



// パターン6
function render_link_list_p6( $content ) {
	return '<!-- wp:loos/link-list {"icon":"swl-svg-caretRight","fontSize":"0.9em"} -->' . "\n" .
	'<ul class="swell-block-linkList is-style-default" style="--the-fz:0.9em">' . $content . '</ul>' . "\n" .
	'<!-- /wp:loos/link-list -->';
};
function render_heading_p6( $text ) {
	return '<!-- wp:heading {"level":3,"className":"u-mb-ctrl u-mb-10"} -->' . "\n" .
	'<h3 class="u-mb-ctrl u-mb-10">' . $text . ' </h3>' . "\n" .
	'<!-- /wp:heading -->';
};

$PATTERN_6 = '<!-- wp:loos/columns {"colPC":"4","colMobile":"2"} -->
<div class="swell-block-columns" style="--clmn-w--pc:25%;--clmn-w--mobile:50%"><div class="swell-block-columns__inner">' .
	render_rich_column(
		render_heading_p6( 'カテゴリーA' ) .
		render_link_list_p6(
			render_link_list_item( '子カテゴリー' ) .
			render_link_list_item( '子カテゴリー' ) .
			render_link_list_item( '子カテゴリー' ) .
			render_link_list_item( '子カテゴリー' )
		)
	) .
	render_rich_column(
		render_heading_p6( 'カテゴリーB' ) .
		render_link_list_p6(
			render_link_list_item( '子カテゴリー' ) .
			render_link_list_item( '子カテゴリー' ) .
			render_link_list_item( '子カテゴリー' ) .
			render_link_list_item( '子カテゴリー' )
		)
	) .
	render_rich_column(
		render_heading_p6( 'カテゴリーC' ) .
		render_link_list_p6(
			render_link_list_item( '子カテゴリー' ) .
			render_link_list_item( '子カテゴリー' ) .
			render_link_list_item( '子カテゴリー' ) .
			render_link_list_item( '子カテゴリー' )
		)
	) .
	render_rich_column(
		render_heading_p6( 'カテゴリーD' ) .
		render_link_list_p6(
			render_link_list_item( '子カテゴリー' ) .
			render_link_list_item( '子カテゴリー' ) .
			render_link_list_item( '子カテゴリー' ) .
			render_link_list_item( '子カテゴリー' )
		)
	) .
'</div></div>
<!-- /wp:loos/columns -->';

register_block_pattern(
	'swell-pattern/link-list-B',
	[
		'title'         => __( 'カテゴリー導線B', 'swell' ),
		'content'       => $PATTERN_6,
		'categories'    => [ $pattern_category ],
		'description'   => '',
		'viewportWidth' => 1000,
		'blockTypes'    => [ 'loos/link-list', 'loos/columns' ],
		'keywords'      => [ 'list', 'link', 'リスト', 'リンク' ],
	]
);
