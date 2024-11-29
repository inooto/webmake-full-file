<?php
namespace SWELL_Theme\Consts;

use \SWELL_Theme as SWELL;

if ( ! defined( 'ABSPATH' ) ) exit;

// 後方互換用
define( 'IS_ADMIN', is_admin() );
define( 'IS_LOGIN', is_user_logged_in() );

/**
 * 子テーマから上書き可能
 */
add_action( 'after_setup_theme', function() {
	// SWELLバージョンを定数化 : 3.0で廃止
	if ( ! defined( 'SWELL_VERSION' ) ) {
		define( 'SWELL_VERSION', ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? wp_date( 'mdGis' ) : SWELL::$swell_version );
	}

	// ポストビューの保存キー
	if ( ! defined( 'SWELL_CT_KEY' ) ) {
		define( 'SWELL_CT_KEY', 'ct_post_views_byloos' );
	}
}, 10 );


/**
 * カスタマイザー以外の設定に依存していて早めにセットしておくもの
 */
add_action( 'init', __NAMESPACE__ . '\set_data__init', 8 );
function set_data__init() {
	$OPTION       = SWELL::get_option();
	$is_customize = is_customize_preview();

	SWELL::set_use( 'pjax', ( 'pjax' === $OPTION['use_pjax'] && ! $is_customize ) );
	SWELL::set_use( 'prefetch', ( 'prefetch' === $OPTION['use_pjax'] && ! $is_customize ) );
	SWELL::set_use( 'ajax_footer', ( $OPTION['ajax_footer'] && ! $is_customize ) );
	SWELL::set_use( 'ajax_after_post', ( $OPTION['ajax_after_post'] && ! $is_customize ) );
	SWELL::set_use( 'card_cache__in', $OPTION['cache_blogcard_in'] );
	SWELL::set_use( 'card_cache__ex', $OPTION['cache_blogcard_ex'] );
	SWELL::set_use( 'delay_js', $OPTION['use_delay_js'] );
	SWELL::set_use( 'pv_count', ! $OPTION['remove_pv_count'] );
}


/**
 * カスタマイザーのデータを受け取ってからセットするデータ
 *    プレビュー画面の即時反映データも受け取れる
 *    AJAXでもギリギリ呼び出される
 *    Gutenbergの<ServerSideRender />でも実行されてるっぽい?
 *      （ after_setup_theme で定義した定数は使えなかった ）
 */
add_action( 'wp_loaded', __NAMESPACE__ . '\hook_wp_loaded', 11 );
function hook_wp_loaded() {

	$SETTING      = SWELL::get_setting();
	$is_customize = is_customize_preview();

	SWELL::set_use( 'acc_submenu', $SETTING['acc_submenu'] );
	SWELL::set_use( 'sp_head_nav', has_nav_menu( 'sp_head_menu' ) );
	SWELL::set_use( 'fix_header', $SETTING['fix_header'] );
	SWELL::set_use( 'head_bar', 'head_bar' === $SETTING['phrase_pos'] || $SETTING['show_icon_list'] );

	// NO IMAGE画像
	$noimg_id              = $SETTING['noimg_id'];
	$noimg_url             = wp_get_attachment_url( $noimg_id ) ?: SWELL::get_setting( 'no_image' ) ?: T_DIRE_URI . '/assets/img/no_img.png';
	$noimg_m_url           = $noimg_id ? wp_get_attachment_image_url( $noimg_id, 'medium' ) : $noimg_url;
	SWELL::$noimg['id']    = absint( $noimg_id );
	SWELL::$noimg['url']   = $noimg_url;
	SWELL::$noimg['small'] = $noimg_m_url;

	// ロゴ画像
	$logo_id      = $SETTING['logo_id'];
	$logo_url     = wp_get_attachment_url( $logo_id ) ?: SWELL::get_setting( 'logo' );
	$logo_top_id  = $SETTING['logo_top_id'];
	$logo_top_url = wp_get_attachment_url( $logo_top_id ) ?: SWELL::get_setting( 'logo_top' );

	// デモサイトのロゴのときは未設定状態に戻す
	if ( false !== strpos( $logo_url, 'demo.swell-theme.com' ) ) {
		$logo_url = '';
	}
	if ( false !== strpos( $logo_top_url, 'demo.swell-theme.com' ) ) {
		$logo_top_url = '';
	}

	SWELL::$site_data['logo_id']      = $logo_id;
	SWELL::$site_data['logo_url']     = $logo_url;
	SWELL::$site_data['logo_top_id']  = $logo_top_id;
	SWELL::$site_data['logo_top_url'] = $logo_top_url;

	// キャッチフレーズ
	SWELL::$site_data['catchphrase'] = get_option( 'blogdescription' );
	if ( $SETTING['show_title'] ) {
		SWELL::$site_data['catchphrase'] .= ' | ' . SWELL::site_data( 'title' );
	}

	// リストタイプ
	SWELL::$list_type = ( IS_MOBILE ) ? $SETTING['post_list_layout_sp'] : $SETTING['post_list_layout'];

	// 抜粋文の長さ
	SWELL::$excerpt_length = IS_MOBILE ? (int) $SETTING['excerpt_length_sp'] : (int) $SETTING['excerpt_length_pc'];

	// 後方互換用
	define( 'PLACEHOLDER', SWELL::$placeholder );
	define( 'USE_AJAX_FOOTER', SWELL::is_use( 'ajax_footer' ) );
	define( 'USE_AJAX_AFTER_POST', SWELL::is_use( 'ajax_after_post' ) );
	define( 'LOGO', $logo_url );
	define( 'LIST_TYPE', SWELL::$list_type );
	define( 'NOIMG', $noimg_url );
	define( 'NOIMG_S', $noimg_m_url );
	// define( 'NOIMG_ID', $noimg_id );

	// lazyload
	SWELL::$lazy_type = $SETTING['lazy_type'];
	if ( 'lazysizes' === SWELL::$lazy_type ) {
		SWELL::set_use( 'lazysizes', true );
	}
}


/**
 * 条件分岐が有効になってから定義するもの
 */
add_action( 'wp', __NAMESPACE__ . '\hook_wp', 2 );
function hook_wp() {
	define( 'IS_TOP', SWELL::is_top() );
	define( 'IS_TERM', SWELL::is_term() );

	// mvタイプ
	$mv_type = SWELL::get_setting( 'main_visual_type' );

	// mv種別はpjax時のCSS判定に必要なのでページ分岐せずに取得
	if ( 'slider' === $mv_type && count( SWELL::get_mv_slide_imgs() ) === 1 ) {
		SWELL::$site_data['mv'] = 'single';
	} else {
		SWELL::$site_data['mv'] = $mv_type;
	}

	if ( SWELL::is_top() && ! is_paged() ) {

		if ( 'no' !== SWELL::get_setting( 'header_transparent' ) ) {
			SWELL::set_use( 'top_header', true );
		}

		SWELL::set_use( 'mv', 'none' !== $mv_type );
		SWELL::set_use( 'post_slider', 'on' === SWELL::get_setting( 'show_post_slide' ) );
	}

}
