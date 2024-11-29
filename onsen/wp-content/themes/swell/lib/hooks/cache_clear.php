<?php
namespace SWELL_Theme\Hooks;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * カスタマイザー表示時、一旦全キャッシュ削除
 */
// if ( is_customize_preview() ) \SWELL_Theme::clear_cache();


/**
 * カスタマイザーの設定変更後、キャッシュを削除
 */
add_action( 'customize_save_after', function() {
	$keys         = \SWELL_Theme::$cache_keys;
	$cache_keys   = array_merge( $keys['style'], $keys['header'], $keys['post'], $keys['widget'] );
	$cache_keys[] = 'swell_mv';
	\SWELL_Theme::clear_cache( $cache_keys );
});


/**
 * サイト名・キャッチフレーズの設定更新時
 */
add_action( 'update_option', function( $option_name ) {
	if ( 'blogname' === $option_name || 'blogdescription' === $option_name ) {
		$keys = \SWELL_Theme::$cache_keys;
		\SWELL_Theme::clear_cache( $keys['header'] );
	}
});


/**
 * 投稿の保存・更新時
 */
add_action( 'save_post', function( $post_ID ) {
	$keys       = \SWELL_Theme::$cache_keys;
	$cache_keys = array_merge( $keys['widget'], $keys['post'] );
	\SWELL_Theme::clear_cache( $cache_keys );
}, 99);


/**
 * 投稿ステータスが変更される時（future → publish は cron が使えないローカル環境だと検知できない？）
 */
add_action( 'transition_post_status', function( $old_status, $new_status ) {
	if ( $old_status === $new_status ) return;
	$keys       = \SWELL_Theme::$cache_keys;
	$cache_keys = array_merge( $keys['widget'], $keys['post'] );
	\SWELL_Theme::clear_cache( $cache_keys );
}, 10, 2 );


/**
 * カテゴリー・タグの更新時
 */
add_action( 'edited_terms', function( $post_ID ) {
	$keys       = \SWELL_Theme::$cache_keys;
	$cache_keys = array_merge( $keys['header'], $keys['widget'], $keys['post'] );
	\SWELL_Theme::clear_cache( $cache_keys );
}, 99);


/**
 * ウィジェット更新時
 */
add_filter('widget_update_callback', function( $instance, $new_instance, $old_instance, $this_item ) {
	$this_item_id = $this_item->id;
	$widgets      = wp_get_sidebars_widgets();  // = get_option( 'sidebars_widgets' );

	$keys       = \SWELL_Theme::$cache_keys;
	$cache_keys = $keys['widget'];

	// ヘッダー内ウィジェット更新時
	if ( isset( $widgets['head_box'] ) && is_array( $widgets['head_box'] ) ) {
		if ( in_array( $this_item_id, $widgets['head_box'], true ) ) {
			$cache_keys = array_merge( $cache_keys, $keys['header'] );
		}
	}
	\SWELL_Theme::clear_cache( $cache_keys );
	return $instance;

}, 99, 4);


/**
 * ウィジェットの登録数が変わっている場合の処理（編集ではなく新規追加時の対応）
 */
add_action( 'widgets_init', function() {
	if ( ! is_admin() ) return;
	$cache_data  = get_transient( 'swell_parts_sidebars_widgets' );
	$widget_data = wp_get_sidebars_widgets();

	if ( $cache_data !== $widget_data ) {

		$keys       = \SWELL_Theme::$cache_keys;
		$cache_keys = $keys['widget'];

		if ( isset( $cache_data['head_box'] ) && isset( $widget_data['head_box'] ) ) {
			if ( $cache_data['head_box'] !== $widget_data['head_box'] ) {
				$cache_keys = array_merge( $cache_keys, $keys['header'] );
			}
		}
		\SWELL_Theme::clear_cache( $cache_keys );

		// ウィジェット登録状況をキャッシュ
		set_transient( 'swell_parts_sidebars_widgets', $widget_data );
	}
}, 99);


/**
 * カスタムメニューの更新時にキャッシュ削除
 */
add_action( 'wp_update_nav_menu', function( $menu_id ) {
	$locations = get_nav_menu_locations();

	$keys       = \SWELL_Theme::$cache_keys;
	$cache_keys = $keys['widget'];

	// ロケーションに登録済みのナビであれば、ロケーションに応じてキャッシュを削除
	foreach ( $locations as $location => $id ) {
		if ( $menu_id === $id ) {

			// 複数のロケーションに設定する場合もあるので、elseif ではなく全て if で。
			if ( 'header_menu' === $location || 'sp_head_menu' ) {
				$cache_keys = array_merge( $cache_keys, $keys['header'] );
			}
			if ( 'pickup_banner' === $location ) $cache_keys[]   = 'swell_pickup_banner';
			if ( 'fix_bottom_menu' === $location ) $cache_keys[] = 'swell_fix_bottom_menu';
		}
	}
	\SWELL_Theme::clear_cache( $cache_keys );

}, 99);
