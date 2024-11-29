<?php
namespace SWELL_Theme\Hooks;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * タグクラウドにクラスを追加する
 */
add_filter( 'wp_generate_tag_cloud', __NAMESPACE__ . '\add_class_tag_cloud_link' );  // 'wp_tag_cloud'フックでもOK ?
function add_class_tag_cloud_link( $links ) {
	$links = str_replace( 'class="tag-cloud-link', 'class="tag-cloud-link hov-flash-up', $links );
	return $links;
}


/**
 * カテゴリーリストの件数を</a>の中に移動 & spanで囲む
 */
add_filter( 'wp_list_categories', __NAMESPACE__ . '\hook_wp_list_categories', 10, 2 );
function hook_wp_list_categories( $output, $args ) {
	$output = preg_replace( '/<\/a>\s*\(([0-9,]*)\)/', ' <span class="cat-post-count">($1)</span></a>', $output );

	if ( \SWELL_Theme::is_use( 'acc_submenu' ) ) {
		$span   = '<button class="c-submenuToggleBtn c-plainBtn" data-onclick="toggleSubmenu" aria-label="' . esc_attr__( 'サブメニューを開閉する', 'swell' ) . '"></button>';
		$output = preg_replace( '/<\/a>([^<]*)<ul/', $span . '</a><ul', $output );
	}

	return $output;
}


/**
 * 固定ページリストへのフック
 */
add_filter( 'wp_list_pages', __NAMESPACE__ . '\hook_wp_list_pages', 10, 3 );
function hook_wp_list_pages( $output, $parsed_args, $pages ) {

	if ( \SWELL_Theme::is_use( 'acc_submenu' ) ) {
		$span   = '<button class="c-submenuToggleBtn c-plainBtn" data-onclick="toggleSubmenu" aria-label="' . esc_attr__( 'サブメニューを開閉する', 'swell' ) . '"></button>';
		$output = preg_replace( '/<\/a>([^<]*)<ul/', $span . '</a><ul', $output );
	}

	return $output;
}


/**
 * 年別アーカイブリストの投稿件数 を</a>の中に置換
 */
add_filter( 'get_archives_link', __NAMESPACE__ . '\hook_get_archives_link', 10, 6 );
function hook_get_archives_link( $link_html, $url, $text, $format, $before, $after ) {
	if ( 'html' === $format ) {
		$link_html = '<li>' . $before . '<a href="' . $url . '">' . $text . '<span class="post_count">' . $after . '</span></a></li>';
	}
	return $link_html;
}


/**
 * リスト系ウィジェットにクラスを付ける
 */
add_filter( 'dynamic_sidebar_params', __NAMESPACE__ . '\hook_dynamic_sidebar_params' );
function hook_dynamic_sidebar_params( $params ) {
	foreach ( $params as $i => $param ) {
		if ( ! isset( $param['before_widget'] )) continue;

		$before_widget = $param['before_widget'];

		$is_list = false !== stripos( $before_widget, 'widget_categories' )
				|| false !== stripos( $before_widget, 'widget_archive' )
				|| false !== stripos( $before_widget, 'widget_nav_menu' )
				|| false !== stripos( $before_widget, 'widget_pages' );

		if ( ! $is_list ) continue;

		$before_widget          = str_replace( 'c-widget', 'c-widget c-listMenu', $before_widget );
		$param['before_widget'] = $before_widget;
		$params[ $i ]           = $param;
	}
	return $params;
}


add_filter( 'render_block_core/categories', __NAMESPACE__ . '\render_core_categories', 10, 2 );
function render_core_categories( $block_content, $block ) {
	$atts = $block['attrs'] ?? [];
	if ( ! isset( $atts['displayAsDropdown'] ) ) {
		$block_content = str_replace( 'wp-block-categories-list', 'wp-block-categories-list c-listMenu', $block_content );
	}
	return $block_content;
}


add_filter( 'render_block_core/archives', __NAMESPACE__ . '\render_core_archives', 10, 2 );
function render_core_archives( $block_content, $block ) {
	$atts = $block['attrs'] ?? [];
	if ( ! isset( $atts['displayAsDropdown'] ) ) {
		$block_content = str_replace( 'wp-block-archives-list', 'wp-block-archives-list c-listMenu', $block_content );
	}
	return $block_content;
}
