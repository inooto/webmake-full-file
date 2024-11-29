<?php
namespace SWELL_Theme\Style;

use \SWELL_Theme as SWELL;
use SWELL_Theme\Style as Style;

if ( ! defined( 'ABSPATH' ) ) exit;

class Top {


	/**
	 * メインビジュアル
	 */
	public static function mv() {

		$SETTING = SWELL::get_setting();

		// 高さ
		$mv_slide_height_sp = 'auto';
		$mv_slide_height_pc = 'auto';
		if ( 'set' === $SETTING['mv_slide_size'] ) {
			$mv_slide_height_pc = $SETTING['mv_slide_height_pc'];
			$mv_slide_height_sp = $SETTING['mv_slide_height_sp'];
		}
		Style::add( '.p-mainVisual__inner', 'height:' . $mv_slide_height_sp );
		Style::add( '.p-mainVisual__inner', 'height:' . $mv_slide_height_pc, 'pc' );

		// 画像の高さそのまま使う時、かつスライドの表示枚数が複数の時、画面表示の瞬間に高さのチラツキ防止するために横幅先に決定させる
		if ( 'img' === $SETTING['mv_slide_size'] ) {
			$pc_num    = (float) $SETTING['mv_slide_num'];
			$pc_num_sp = (float) $SETTING['mv_slide_num_sp'];
			if ( $pc_num > 1 ) {
				Style::add_root( '--swl-mv_slide_width--pc', floor( 100 / $pc_num ) . 'vw' );
			}
			if ( $pc_num_sp > 1 ) {
				Style::add_root( '--swl-mv_slide_width--sp', floor( 100 / $pc_num_sp ) . 'vw' );
			}
		}

		// メボタンの丸み
		Style::add_root( '--mv_btn_radius', $SETTING['mv_btn_radius'] . 'px' );

		// スライダーアニメーション
		Style::add_root( '--mv_slide_animation', $SETTING['mv_slide_animation'] );

		// オーバレイカラー
		Style::add(
			'.p-mainVisual .c-filterLayer::before',
			[
				'background-color:' . $SETTING['mv_overlay_color'],
				'opacity:' . $SETTING['mv_overlay_opacity'],
				'content:""',
			]
		);

		// ページネーション表示時は、スライダーのscrollを少し上にずらす
		if ( $SETTING['mv_on_pagination'] ) {
			Style::add( '.-type-slider .p-mainVisual__scroll', 'padding-bottom: 16px' );
		}
	}


	/**
	 * 記事スライダー
	 */
	public static function post_slider() {

		$SETTING = SWELL::get_setting();

		// スライドがページ表示の瞬間にでかくなるのを防ぐための横幅定義
		$pc_num    = (float) $SETTING['ps_num'];
		$pc_num_sp = (float) $SETTING['ps_num_sp'];
		if ( $pc_num > 1 ) {
			Style::add_root( '--swl-post_slide_width--pc', floor( 100 / $pc_num ) . '%' );
		}
		if ( $pc_num_sp > 1 ) {
			Style::add_root( '--swl-post_slide_width--sp', floor( 100 / $pc_num_sp ) . '%' );
		}

		// 上下の余白量
		switch ( $SETTING['pickup_pad_tb'] ) {
			case 'small':
				$ps_pad    = '16px';
				$ps_pad_mb = '16px';
				break;
			case 'middle':
				$ps_pad    = '40px';
				$ps_pad_mb = '5vw';
				break;
			case 'wide':
				$ps_pad    = '64px';
				$ps_pad_mb = '8vw';
				break;
			default:
				// 'none'
				$ps_pad    = '0px';
				$ps_pad_mb = '0px';
				break;
		}

		Style::add_root( '--swl-post_slide_padY', $ps_pad );
		Style::add_root( '--swl-post_slide_padY--mb', $ps_pad_mb );

		$ps_style = [];

		// 背景色
		$ps_bg_color = $SETTING['ps_bg_color'];
		if ( $ps_bg_color ) {
			$ps_style[] = 'background-color:' . $ps_bg_color;
		}

		// 文字色
		$pickup_font_color = $SETTING['pickup_font_color'];
		if ( $pickup_font_color ) {
			$ps_style[] = 'color:' . $pickup_font_color;
		}

		Style::add( '.p-postSlider', $ps_style );

		// スライド間の余白
		if ( ! $SETTING['ps_no_space'] ) {
			$ps_space = '8px';
		} else {
			$ps_space = '0';
			Style::add( '#post_slider .p-postList__thumb', 'box-shadow:none;border-radius:0' );
			Style::add( '#post_slider .p-postList__link', 'border-radius:0' );
		}
		Style::add_root( '--ps_space', $ps_space );

		// その他
		$ps_swiper = [];
		if ( $SETTING['ps_on_pagination'] ) {
			// ページネーションがあればpaddingつける
			$ps_swiper[] = 'padding-bottom:24px';
		}

		// 左右の余白量
		switch ( $SETTING['pickup_pad_lr'] ) {
			case 'small': // 左右に少し余白あり
				Style::add( '#post_slider', 'padding-left:40px;padding-right:40px', 'pc' );
				break;
			case 'wide': // コンテンツ幅に収める
				if ( ! $SETTING['ps_no_space'] ) {
					$ps_swiper[] = 'margin-left:-8px;margin-right:-8px;';
				}
				break;
			default:
				break;
		}

		Style::add( '#post_slider .swiper', $ps_swiper );

	}

}
