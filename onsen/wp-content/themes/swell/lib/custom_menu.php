<?php
namespace SWELL_Theme\Custom_Menu;

use \SWELL_Theme as SWELL;

if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * カスタムメニューのロケーション登録
 */
add_action( 'after_setup_theme', __NAMESPACE__ . '\hook_after_setup_theme', 9 );
function hook_after_setup_theme() {
	register_nav_menus( [
		'header_menu'     => __( 'グローバルナビ', 'swell' ),
		'sp_head_menu'    => __( 'スマホ用ヘッダー', 'swell' ),
		'nav_sp_menu'     => __( 'スマホ開閉メニュー内', 'swell' ),
		'footer_menu'     => __( 'フッター', 'swell' ),
		'fix_bottom_menu' => __( '固定フッター（SP）', 'swell' ),
		'pickup_banner'   => __( 'ピックアップバナー', 'swell' ),
	] );
}


/**
 * liタグのIDを削除する
 */
add_filter( 'nav_menu_item_id', __NAMESPACE__ . '\hook_nav_menu_item_id', 10, 3 );
function hook_nav_menu_item_id( $menu_id, $item, $args ) {
	$noid_locations = [
		'header_menu',
		'sp_head_menu',
		'nav_sp_menu',
		'footer_menu',
		'fix_bottom_menu',
		'pickup_banner',
	];
	if ( in_array( $args->theme_location, $noid_locations, true ) ) {
		return '';
	}
	return $menu_id;
}


/**
 * liに付与されるクラスをカスタマイズ
 */
add_filter( 'nav_menu_css_class', __NAMESPACE__ . '\hook_nav_menu_css_class', 10, 3 );
function hook_nav_menu_css_class( $classes, $item, $args ) {

	$location = $args->theme_location;

	if ( 'sp_head_menu' === $location ) {

		$classes[] = 'swiper-slide';

	} elseif ( 'pickup_banner' === $location ) {

		$classes[] = 'p-pickupBanners__item';

	}

	return $classes;
}

/**
 * リストのHTMLを組み替える
 * 例：「説明」を追加（ナビゲーションの英語テキストに使用）
 */
add_filter( 'walker_nav_menu_start_el', __NAMESPACE__ . '\hook_walker_nav_menu_start_el', 10, 4 );
function hook_walker_nav_menu_start_el( $item_output, $item, $depth, $args ) {

	// 特定のメニューに対して処理
	$menu_location = $args->theme_location;
	if ( $menu_location === 'header_menu' || $menu_location === 'nav_sp_menu' ) {
		if ( ! empty( $item->description ) ) {
			// desc はしばらく残す
			$item_output = str_replace( '</a>', '<span class="c-smallNavTitle desc">' . $item->description . '</span></a>', $item_output );
		}

		if ( SWELL::is_use( 'acc_submenu' ) && in_array( 'menu-item-has-children', $item->classes, true ) ) {
			$item_output = str_replace(
				'</a>',
				'<button class="c-submenuToggleBtn c-plainBtn" data-onclick="toggleSubmenu" aria-label="' . esc_attr__( 'サブメニューを開閉する', 'swell' ) . '"></button></a>',
				$item_output
			);
		}
	} elseif ( $menu_location === 'fix_bottom_menu' ) {

		// 固定フッターメニュー
		$target      = ( $item->target === '_blank' ) ? ' target="_blank" rel="noopener noreferrer"' : '';
		$item_output = '<a href="' . $item->url . '"' . $target . '>' .
			'<i class="' . $item->description . '"></i><span>' . $item->title . '</span>' .
		'</a>';

	} elseif ( $menu_location === 'pickup_banner' ) {

		// ピックアップバナー
		$item_output = SWELL::get_pluggable_parts( 'pickup_banner', [
			'item'       => $item,
			'menu_count' => $args->menu->count,
		] );

	} elseif ( $menu_location === '' ) {
		if ( SWELL::is_use( 'acc_submenu' ) && in_array( 'menu-item-has-children', $item->classes, true ) ) {
			$span        = '<button class="c-submenuToggleBtn c-plainBtn" data-onclick="toggleSubmenu" aria-label="' . esc_attr__( 'サブメニューを開閉する', 'swell' ) . '"></button>';
			$item_output = str_replace( '</a>', $span . '</a>', $item_output );
		}
	}

	// icon 使えるように
	$item_output = do_shortcode( $item_output );

	return $item_output;
}
