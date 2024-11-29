<?php
namespace SWELL_Theme\Style;

use \SWELL_Theme as SWELL;
use SWELL_Theme\Style as Style;

if ( ! defined( 'ABSPATH' ) ) exit;

class Color {

	/**
	 * カラー変数のセット（フロント & エディターで共通のもの）
	 */
	public static function common() {
		$color_main = SWELL::get_setting( 'color_main' );
		$color_text = SWELL::get_setting( 'color_text' );

		Style::add_root( '--color_main', $color_main );
		Style::add_root( '--color_text', $color_text );
		Style::add_root( '--color_link', SWELL::get_setting( 'color_link' ) );
		Style::add_root( '--color_htag', SWELL::get_setting( 'color_htag' ) ?: $color_main );

		Style::add_root( '--color_bg', SWELL::get_setting( 'color_bg' ) );
		Style::add_root( '--color_gradient1', SWELL::get_setting( 'color_gradient1' ) );
		Style::add_root( '--color_gradient2', SWELL::get_setting( 'color_gradient2' ) );

		Style::add_root( '--color_main_thin', SWELL::get_rgba( $color_main, 0.05, 0.25 ) );
		Style::add_root( '--color_main_dark', SWELL::get_rgba( $color_main, 1, -.25 ) );

		// リストアイコンの色
		// Style::add_root( '--color_list_dot', SWELL::get_editor('color_list_dot' ) ?: $color_text );
		Style::add_root( '--color_list_check', SWELL::get_editor( 'color_list_check' ) ?: $color_main );
		Style::add_root( '--color_list_num', SWELL::get_editor( 'color_list_num' ) ?: $color_main );
		Style::add_root( '--color_list_good', SWELL::get_editor( 'color_list_good' ) );
		Style::add_root( '--color_list_triangle', SWELL::get_editor( 'color_list_triangle' ) );
		Style::add_root( '--color_list_bad', SWELL::get_editor( 'color_list_bad' ) );

		// FAQ
		Style::add_root( '--color_faq_q', SWELL::get_editor( 'color_faq_q' ) );
		Style::add_root( '--color_faq_a', SWELL::get_editor( 'color_faq_a' ) );

		$cell_icon_keys = [
			'doubleCircle',
			'circle',
			'triangle',
			'close',
			'hatena',
			'check',
			'line',
		];

		foreach ( $cell_icon_keys as $key ) {
			Style::add(
				'.swl-cell-bg[data-icon="' . $key . '"]',
				'--cell-icon-color:' . SWELL::get_editor( 'color_cell_icon_' . $key )
			);
		}

		// キャプション付きブロックの色
		for ( $i = 1; $i < 4; $i++ ) {
			Style::add( '.cap_box[data-colset="col' . $i . '"]',
				[
					'--capbox-color:' . SWELL::get_editor( 'color_cap_0' . $i ),
					'--capbox-color--bg:' . SWELL::get_editor( 'color_cap_0' . $i . '_light' ),
				]
			);
		}

		// アイコンボックスの色
		foreach ( [
			'color_icon_good',
			'color_icon_good_bg',
			'color_icon_bad',
			'color_icon_bad_bg',
			'color_icon_info',
			'color_icon_info_bg',
			'color_icon_announce',
			'color_icon_announce_bg',
			'color_icon_pen',
			'color_icon_pen_bg',
			'color_icon_book',
			'color_icon_book_bg',
			'color_icon_point',
			'color_icon_check',
			'color_icon_batsu',
			'color_icon_hatena',
			'color_icon_caution',
			'color_icon_memo',
		] as $color_key ) {
			Style::add_root( '--' . $color_key, SWELL::get_editor( $color_key ) );
		}
	}

	/**
	 * フロントだけで使うもの
	 */
	public static function front() {

		// ヘッダーやフッターの色
		Style::add_root( '--color_header_bg', SWELL::get_setting( 'color_header_bg' ) );
		Style::add_root( '--color_header_text', SWELL::get_setting( 'color_header_text' ) );
		Style::add_root( '--color_footer_bg', SWELL::get_setting( 'color_footer_bg' ) );
		Style::add_root( '--color_footer_text', SWELL::get_setting( 'color_footer_text' ) );

		if ( $color_footwdgt_bg = SWELL::get_setting( 'color_footwdgt_bg' ) ) {
			Style::add( '.l-footer__widgetArea', 'background:' . $color_footwdgt_bg );
		}
		if ( $color_footwdgt_text = SWELL::get_setting( 'color_footwdgt_text' ) ) {
			Style::add( '.l-footer__widgetArea', 'color:' . $color_footwdgt_text );
		}

	}


	/**
	 * エディターだけで使うもの
	 */
	public static function editor() {
	}

}
