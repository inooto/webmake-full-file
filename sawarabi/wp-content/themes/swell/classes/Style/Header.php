<?php
namespace SWELL_Theme\Style;

use \SWELL_Theme as SWELL;
use SWELL_Theme\Style as Style;

if ( ! defined( 'ABSPATH' ) ) exit;

class Header {

	/**
	 * ヘッダーの境界線
	 */
	public static function header_border() {
		$header_border = SWELL::get_setting( 'header_border' );
		if ( $header_border === 'border' ) {
			Style::add( '.l-header', 'border-bottom: solid 1px rgba(0,0,0,.1)' );
		} elseif ( $header_border === 'shadow' ) {
			Style::add( '.l-header', 'box-shadow: 0 1px 4px rgba(0,0,0,.12)' );
		}

	}

	/**
	 * ヘッドバー
	 */
	public static function head_bar() {
		$color_head_bar_bg = SWELL::get_setting( 'color_head_bar_bg' ) ?: 'var(--color_main)';

		if ( SWELL::is_use( 'head_bar' ) ) {
			Style::add( '.l-header__bar', [
				'color:' . SWELL::get_setting( 'color_head_bar_text' ),
				'background:' . $color_head_bar_bg,
			]);
		}

		// ヘッドバーの内容がなくてもボーダーとして表示する（PCのみ）
		if ( SWELL::get_setting( 'show_head_border' ) ) {
			Style::add( '.l-header', 'border-top: solid 4px ' . $color_head_bar_bg, 'pc' );
		}
	}

	/**
	 * ヘッダー（SP）のレイアウト
	 */
	public static function header_sp_layout() {

		switch ( SWELL::get_setting( 'header_layout_sp' ) ) {
			case 'center_right':
				$menu_btn   = 'order:3';
				$custom_btn = 'order:1';
				$logo_wrap  = 'order:2;text-align:center';
				$head_inner = '';
				break;
			case 'center_left':
				$menu_btn   = 'order:1';
				$custom_btn = 'order:3';
				$logo_wrap  = 'order:2;text-align:center';
				$head_inner = '';
				break;
			default:
				$menu_btn   = '';
				$custom_btn = '';
				$logo_wrap  = 'margin-right:auto';
				$head_inner = '-webkit-box-pack:end;-webkit-justify-content:flex-end;justify-content:flex-end';
				break;
		}
		Style::add( '.l-header__menuBtn', $menu_btn );
		Style::add( '.l-header__customBtn', $custom_btn );
		Style::add( '.l-header__logo', $logo_wrap, 'sp' );
		Style::add( '.l-header__inner', $head_inner, 'sp' );
	}

	/**
	 * スマホのヘッダーボタン
	 */
	public static function header_menu_btn() {
		$menu_btn_bg   = SWELL::get_setting( 'menu_btn_bg' );
		$custom_btn_bg = SWELL::get_setting( 'custom_btn_bg' );

		if ( $menu_btn_bg !== '' ) {
			Style::add( '.l-header__menuBtn', 'color:#fff;background-color:' . $menu_btn_bg );
		}
		if ( $custom_btn_bg !== '' ) {
			Style::add( '.l-header__customBtn', 'color:#fff;background-color:' . $custom_btn_bg );
		}
	}

	/**
	 * ロゴ画像
	 */
	public static function logo() {
		Style::add_root( '--logo_size_sp', SWELL::get_setting( 'logo_size_sp' ) . 'px' );
		Style::add_root( '--logo_size_pc', SWELL::get_setting( 'logo_size_pc' ) . 'px' );
		Style::add_root( '--logo_size_pcfix', SWELL::get_setting( 'logo_size_pcfix' ) . 'px' );
	}


	/**
	 * グローバルナビ
	 */
	public static function gnav() {

		// グロナビ背景の上書き
		if ( 'overwrite' === SWELL::get_setting( 'gnav_bg_type' ) ) {
			Style::add_root( '--color_gnav_bg', SWELL::get_setting( 'color_gnav_bg' ) ?: 'var(--color_main)' );
		}

		$gnav_a_after        = [];
		$sp_head_nav_current = [];

		// ヘッダーメニューボーダー  メイン色かテキスト色か a::afterは親のみ
		if ( 'main' === SWELL::get_setting( 'color_head_hov' ) ) {
			$gnav_a_after[]        = 'background:var(--color_main)';
			$sp_head_nav_current[] = 'border-bottom-color:var(--color_main)';
		} else {
			$gnav_a_after[]        = 'background:var(--color_header_text)';
			$sp_head_nav_current[] = 'border-bottom-color:var(--color_header_text)';
		}

		$gnav_li_hover_a_after = [];
		// グロナビのホバーエフェクト
		switch ( SWELL::get_setting( 'headmenu_effect' ) ) {
			case 'line_center':
				$gnav_a_after[]          = 'width:100%;height:2px;transform:scaleX(0)';
				$gnav_li_hover_a_after[] = 'transform: scaleX(1)';
				break;
			case 'line_left':
				$gnav_a_after[]          = 'width:0%;height:2px';
				$gnav_li_hover_a_after[] = 'width:100%';
				break;
			case 'block':
				$gnav_a_after[]          = 'width:100%;height:0px';
				$gnav_li_hover_a_after[] = 'height:6px';
				break;
			case 'bg_gray':
				$gnav_li_hover_a[] = 'background:#f7f7f7;color: #333';
				break;
			case 'bg_light':
				$gnav_li_hover_a[] = 'background:rgba(250,250,250,0.16)';
				break;
			default:
				break;
		}

		if ( ! empty( $gnav_a_after ) ) {
			Style::add( '.c-gnav a::after', $gnav_a_after );
		}
		if ( ! empty( $sp_head_nav_current ) ) {
			Style::add( '.p-spHeadMenu .menu-item.-current', $sp_head_nav_current );
		}
		if ( ! empty( $gnav_li_hover_a ) ) {
			Style::add( ['.c-gnav > li:hover > a', '.c-gnav > .-current > a' ], $gnav_li_hover_a );
		}
		if ( ! empty( $gnav_li_hover_a_after ) ) {
			Style::add( ['.c-gnav > li:hover > a::after', '.c-gnav > .-current > a::after' ], $gnav_li_hover_a_after );
		}

		// サブメニューの色
		$subbg_is_white = 'main' !== SWELL::get_setting( 'head_submenu_bg' );
		$submenu_color  = $subbg_is_white ? '#333' : '#fff';
		$submenu_bg     = $subbg_is_white ? '#fff' : 'var(--color_main)';
		Style::add( '.c-gnav .sub-menu', [
			'color:' . $submenu_color,
			'background:' . $submenu_bg,
		] );
	}


	/**
	 * お知らせバー
	 */
	public static function info_bar() {

		$infoBar = [];

		// テキスト色
		$infoBar[] = 'color:' . SWELL::get_setting( 'color_info_text' );

		// 背景
		$bgcol_01 = SWELL::get_setting( 'color_info_bg' );
		$bgcol_02 = SWELL::get_setting( 'color_info_bg2' );

		// 背景グラデーションかどうか
		if ( 'gradation' === SWELL::get_setting( 'info_bar_effect' ) ) {
			if ( $bgcol_02 ) {
				$gradation_bg = 'repeating-linear-gradient(' .
					'100deg,' .
					\SWELL_Theme::get_rgba( $bgcol_01, 1, .1 ) . ' 0,' .
					$bgcol_01 . ' 5%,' .
					$bgcol_02 . ' 95%,' .
					\SWELL_Theme::get_rgba( $bgcol_02, 1, .1 ) . ' 100%' .
				')';
			} else {
				// 背景色02が指定されていなければ、単一色からグラデーションを計算
				$gradation_bg = 'repeating-linear-gradient(' .
					'100deg, ' . $bgcol_01 . ' 0,' .
					\SWELL_Theme::get_rgba( $bgcol_01, 1, .1 ) . ' 10%,' .
					\SWELL_Theme::get_rgba( $bgcol_01, 1, .4 ) . ' 90%,' .
					\SWELL_Theme::get_rgba( $bgcol_01, 1, .5 ) . ' 100%' .
				')';
			}

			$infoBar[] = 'background-image:' . $gradation_bg;
		} else {
			$infoBar[] = 'background-color:' . $bgcol_01;
		}

		// $head_style .= '.c-infoBar{'. $notice_style .'}';
		Style::add( '.c-infoBar', $infoBar );

		// フォントサイズ
		switch ( SWELL::get_setting( 'info_bar_size' ) ) {
			case 'small':
				$fz_tab    = '12px';
				$fz_mobile = '3vw';
				break;
			case 'big':
				$fz_tab    = '16px';
				$fz_mobile = '3.8vw';
				break;
			default:
				$fz_tab    = '14px';
				$fz_mobile = '3.4vw';
				break;
		}
		Style::add( '.c-infoBar__text', 'font-size:' . $fz_mobile );
		Style::add( '.c-infoBar__text', 'font-size:' . $fz_tab, 'tab' );

		// ボタンの色
		$color_info_btn = SWELL::get_setting( 'color_info_btn' ) ?: 'var(--color_main)';
		Style::add( '.c-infoBar__btn', 'background-color:' . $color_info_btn . ' !important' );

	}
}
