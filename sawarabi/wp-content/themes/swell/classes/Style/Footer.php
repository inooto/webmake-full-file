<?php
namespace SWELL_Theme\Style;

use \SWELL_Theme as SWELL;
use SWELL_Theme\Style as Style;

if ( ! defined( 'ABSPATH' ) ) exit;

class Footer {


	/**
	 * ページトップボタン
	 */
	public static function pagetop_btn() {
		if ( SWELL::get_setting( 'pagetop_style' ) === 'fix_circle' ) {
			Style::add( '#pagetop', 'border-radius:50%' );
		}
	}

	/**
	 * 目次ボタン
	 */
	public static function index_btn() {
		if ( SWELL::get_setting( 'index_btn_style' ) === 'circle' ) {
			Style::add( '#fix_tocbtn', 'border-radius:50%' );
		}
	}

	/**
	 * 固定フッターメニューが表示される場合の固定ボタンたち
	 */
	public static function fix_menu_btns() {

		Style::add( '#fix_bottom_menu', 'color:' . SWELL::get_setting( 'color_fbm_text' ) );
		Style::add( '#fix_bottom_menu::before', [
			'background:' . SWELL::get_setting( 'color_fbm_bg' ),
			'opacity:' . SWELL::get_setting( 'fbm_opacity' ),
		] );

		if ( SWELL::get_setting( 'show_fbm_pagetop' ) ) {
			Style::add( '#pagetop', 'display:none', 'sp' );
		}
		if ( SWELL::get_setting( 'show_fbm_index' ) ) {
			Style::add( '#fix_tocbtn', 'display:none', 'sp' );
		}
	}

}
