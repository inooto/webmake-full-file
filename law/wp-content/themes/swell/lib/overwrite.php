<?php
namespace SWELL_Theme\Overwrite;

if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * 投稿・固定ページにて、各種設定を上書きする
 */
add_action( 'wp', __NAMESPACE__ . '\hook_wp', 11 );
function hook_wp() {

	$the_id = get_queried_object_id();

	set_show_sidebar( $the_id );
	set_show_index( $the_id );
	set_show_toc_ad( $the_id );
	set_show_ttlpos( $the_id );
	set_show_pickbnr( $the_id );

	if ( is_category() || is_tag() || is_tax() ) {
		set_show_term_navigation( $the_id );
	}

}


/**
 * サイドバーの設定
 * トップページも上書き設定可能に。
 */
function set_show_sidebar( $page_id ) {

	$meta = '';
	if ( is_single() || is_page() || is_home() ) {
		$meta = get_post_meta( $page_id, 'swell_meta_show_sidebar', true );
	} elseif ( \SWELL_Theme::is_term() ) {
		$meta = get_term_meta( $page_id, 'swell_term_meta_show_sidebar', true );
	}

	if ( 'show' === $meta ) {
		add_filter( 'swell_is_show_sidebar', '__return_true' );
	} elseif ( 'hide' === $meta ) {
		add_filter( 'swell_is_show_sidebar', '__return_false' );
	}
}


/**
 * 目次の表示設定
 */
function set_show_index( $page_id ) {

	if ( ! is_singular() ) return;

	$meta = get_post_meta( $page_id, 'swell_meta_show_index', true );
	if ( 'show' === $meta ) {
		add_filter( 'swell_is_show_index', '__return_true' );
	} elseif ( 'hide' === $meta ) {
		add_filter( 'swell_is_show_index', '__return_false' );
	}

	$meta = get_post_meta( $page_id, 'swell_meta_toc_target', true );
	if ( $meta ) {
		add_filter( 'swell_toc_target', function() use ( $meta ) {
			return $meta;
		});
	}
}


/**
 * 目次広告の表示設定
 */
function set_show_toc_ad( $page_id ) {
	if ( ! is_singular() ) return;

	$meta = get_post_meta( $page_id, 'swell_meta_hide_before_index', true );
	if ( '1' === $meta ) {
		add_filter( 'swell_is_show_toc_ad', '__return_false' );
	}
}


/**
 * タイトル表示位置
 */
function set_show_ttlpos( $page_id ) {

	$meta = '';
	if ( is_single() || is_page() || is_home() ) {
		$meta = get_post_meta( $page_id, 'swell_meta_ttl_pos', true );
	} elseif ( \SWELL_Theme::is_term() ) {
		$meta = get_term_meta( $page_id, 'swell_term_meta_ttlpos', true );
	}
	if ( 'top' === $meta ) {
		add_filter( 'swell_is_show_ttltop', '__return_true' );
	} elseif ( 'inner' === $meta ) {
		add_filter( 'swell_is_show_ttltop', '__return_false' );
	}
}


/**
 * ピックアップバナー表示設定
 */
function set_show_pickbnr( $page_id ) {
	if ( is_page() || is_home() || is_single() ) {
		$meta = get_post_meta( $page_id, 'swell_meta_show_pickbnr', true );
		if ( 'show' === $meta ) {
			add_filter( 'swell_is_show_pickup_banner', '__return_true' );
		} elseif ( 'hide' === $meta ) {
			add_filter( 'swell_is_show_pickup_banner', '__return_false' );
		}
	}
}


/**
 * タームナビ
 */
function set_show_term_navigation( $the_id ) {
	$meta = get_term_meta( $the_id, 'swell_term_meta_show_nav', true );
	if ( 'show' === $meta ) {
		add_filter( 'swell_show_term_navigation', '__return_true' );
	} elseif ( 'hide' === $meta ) {
		add_filter( 'swell_show_term_navigation', '__return_false' );
	}
}
