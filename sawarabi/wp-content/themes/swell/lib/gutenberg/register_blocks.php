<?php
namespace SWELL_Theme\Gutenberg;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * ブロックカテゴリー追加
 * // ver5.8.0~: block_categories_all
 */
$hookname = \SWELL_Theme::wpver_is_above( '5.8' ) ? 'block_categories_all' : 'block_categories';
add_filter( $hookname, __NAMESPACE__ . '\register_swell_categories', 5 );
function register_swell_categories( $categories ) {
	$my_category = [
		'slug'  => 'swell-blocks',  // ブロックカテゴリーのスラッグ
		'title' => __( 'SWELLブロック', 'swell' ),   // ブロックカテゴリーの表示名
		'icon'  => null,
	];
	// array_splice( $categories, 3, 0, [ $my_category ] );
	array_unshift( $categories, $my_category );
	return $categories;
}


/**
 * ダイナミックブロックを登録
 */
add_action( 'init', __NAMESPACE__ . '\register_swell_blocks' );
function register_swell_blocks() {
	register_normal_blocks();
	register_dynamic_blocks();
}


/**
 * 普通のカスタムブロックの登録
 */
function register_normal_blocks() {

	$blocks = [
		'accordion',
		'accordion-item',
		'ab-test-a',
		'ab-test-b',
		'banner-link',
		'box-menu',
		'box-menu-item',
		'button',
		'cap-block',
		'columns',
		'column',
		'dl',
		'dl-dt',
		'dl-dd',
		'faq',
		'faq-item',
		'full-wide',
		'link-list-item',
		'step',
		'step-item',
		'tab',
		'tab-body',
	];
	foreach ( $blocks as $block_name ) {
		\SWELL_Theme::register_block( $block_name );
	}

}


/**
 * ダイナミックブロックの登録
 */
function register_dynamic_blocks() {
	$dynamic_blocks = [
		'ab-test',
		'ad-tag',
		'balloon',
		'blog-parts',
		'link-list',
		'post-list',
		'post-link',
		'restricted-area',
		'review',
		'rss',
	];
	foreach ( $dynamic_blocks as $block_name ) {
		require_once __DIR__ . "/block/{$block_name}.php";
	}
}
