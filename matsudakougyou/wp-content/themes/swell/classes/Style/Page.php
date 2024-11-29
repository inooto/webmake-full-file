<?php
namespace SWELL_Theme\Style;

use \SWELL_Theme as SWELL;
use SWELL_Theme\Style as Style;

if ( ! defined( 'ABSPATH' ) ) exit;

class Page {

	/**
	 * タイトル横の日付
	 */
	public static function title_date() {

		if ( ! SWELL::get_setting( 'show_title_date' ) ) {
			style::add( '.single .c-postTitle__date', 'display:none', 'pc' );
		}
		if ( ! SWELL::get_setting( 'show_title_date_sp' ) ) {
			style::add( '.single .c-postTitle__date', 'display:none', 'sp' );
		}
	}


	/**
	 * シェアボタン
	 */
	public static function share_btn() {

		$share_btn_style = SWELL::get_setting( 'share_btn_style' );

		$btn_mr  = '';
		$btn_css = [];
		switch ( $share_btn_style ) {
			case 'btn':
			case 'btn-small':
				$btn_mr    = '8px';
				$btn_css[] = 'padding:6px 8px;border-radius:2px';
				break;
			case 'icon':
			case 'box':
				// 共通のスタイル
				style::add( '.c-shareBtns__btn:not(:hover)', 'background:none' );
				style::add( '.-fix .c-shareBtns__btn:not(:hover)', 'background:#fff' );
				style::add( '.c-shareBtns__btn:not(:hover) .c-shareBtns__icon', 'color:inherit' );

				$btn_mr    = '8px';
				$btn_css[] = 'padding:8px 0;transition:background-color .25s';

				// 個別のスタイル
				if ( 'icon' === $share_btn_style ) {
					$btn_css[] = 'box-shadow:none!important';
					style::add( '.c-shareBtns__list', [
						'padding: 8px 0',
						'border-top: solid 1px var(--color_border)',
						'border-bottom: solid 1px var(--color_border)',
					] );
				} else {
					$btn_css[] = 'border: solid 1px';
				}
				break;
			default:
				// block
				$btn_mr    = '4px';
				$btn_css[] = 'padding:8px 0';
				break;
		}
		style::add( '.c-shareBtns__item:not(:last-child)', 'margin-right:' . $btn_mr );
		style::add( '.c-shareBtns__btn', $btn_css );
	}

}
