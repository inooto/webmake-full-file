<?php
namespace SWELL_Theme\Gutenberg;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * render_hook
 */
require __DIR__ . '/render_hook/core_table.php';
require __DIR__ . '/render_hook/faq.php';


/**
 * SVGの属性値がsaveでおかしくなるバグへの対応
 */
add_filter( 'render_block_loos/box-menu-item', __NAMESPACE__ . '\render_fix_svg_props', 10, 2 );
function render_fix_svg_props( $block_content, $block ) {
	$block_content = str_replace( 'strokewidth=', 'stroke-width=', $block_content );
	$block_content = str_replace( 'strokelinecap=', 'stroke-linecap=', $block_content );
	$block_content = str_replace( 'strokelinejoin=', 'stroke-linejoin=', $block_content );
	return $block_content;
}


/**
 * リッチカラムCSS変数名の後方互換
 */
add_filter( 'render_block_loos/columns', __NAMESPACE__ . '\replace_columns_css_prop', 10, 2 );
function replace_columns_css_prop( $block_content, $block ) {
	$block_content = str_replace( '--swl-fb_pc:', '--clmn-w--pc:', $block_content );
	$block_content = str_replace( '--swl-fb_tab:', '--clmn-w--tab:', $block_content );
	$block_content = str_replace( '--swl-fb:', '--clmn-w--mobile:', $block_content );
	return $block_content;
}

/**
 * ボックスCSS変数名の後方互換
 */
add_filter( 'render_block_loos/box-menu', __NAMESPACE__ . '\replace_box_menu_css_prop', 10, 2 );
function replace_box_menu_css_prop( $block_content, $block ) {
	$block_content = str_replace( '--swl-fb_pc:', '--the-box-width--pc:', $block_content );
	$block_content = str_replace( '--swl-fb_tab:', '--the-box-width--tab:', $block_content );
	$block_content = str_replace( '--swl-fb:', '--the-box-width--mb:', $block_content );
	return $block_content;
}


/**
 * タブブロックのid重複時の追加処理
 */
add_filter( 'render_block_loos/tab', __NAMESPACE__ . '\check_duplicate_tab_id', 10, 2 );
function check_duplicate_tab_id( $block_content, $block ) {

	// role="tab" がない場合の追加処理
	if ( ! str_contains( $block_content, ' role="tab" ' ) ) {
		$block_content = str_replace( ' aria-selected=', ' role="tab" aria-selected=', $block_content );
	}

	if ( ! isset( $block['attrs']['tabId'] ) ) {
		return $block_content;
	}

	$tab_id    = $block['attrs']['tabId'];
	$check_key = 'swl-tab-id-' . $tab_id;

	// 同じidが使用済みの場合
	if ( isset( $GLOBALS[ $check_key ] ) ) {
		$GLOBALS[ $check_key ] += 1;
		return str_replace( 'tab-' . $tab_id, 'tab-' . $tab_id . $GLOBALS[ $check_key ], $block_content );
	}

	$GLOBALS[ $check_key ] = 1;
	return $block_content;
}


/**
 * アコーディオンの後方互換処理・スクリプトの登録処理
 */
add_filter( 'render_block_loos/accordion-item', __NAMESPACE__ . '\render_accordion', 10, 2 );
function render_accordion( $block_content, $block ) {
	\SWELL_Theme::set_use( 'accordion', true );

	// 旧DOMかどうかの判定 memo: 親ブロックはクラスとか自由に付けれるので一応 summary でチェック
	if ( ! str_contains( $block_content, '<summary class="swell-block-accordion__title' ) ) {
		$attrs         = $block['attrs'] ?? [];
		$isDefultOpen  = $attrs['isDefultOpen'] ?? false;
		$opened_class  = $isDefultOpen ? ' is-opened' : '';
		$block_content = str_replace(
			'<div class="swell-block-accordion__item',
			'<div class="swell-block-accordion__item' . $opened_class,
			$block_content
		);
	}

	return $block_content;
}

/**
 * 6.3で画像ブロックにstyleでw,hが指定されるようになったので、それをaspect-ratioに変換する
 */
add_filter( 'render_block_core/image', __NAMESPACE__ . '\fix_img_v63', 10, 2 );
function fix_img_v63( $block_content, $block ) {
	$attrs = $block['attrs'] ?? [];

	$w = $attrs['width'] ?? '';
	$h = $attrs['height'] ?? '';
	if ( $w && $h ) {
		$size_style    = "width:{$w}px;height:{$h}px";
		$ratio         = "{$w}/{$h}";
		$block_content = str_replace( $size_style, "aspect-ratio:{$ratio}", $block_content );
	}
	return $block_content;
}
