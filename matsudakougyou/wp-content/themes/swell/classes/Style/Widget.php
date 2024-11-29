<?php
namespace SWELL_Theme\Style;

use \SWELL_Theme as SWELL;
use SWELL_Theme\Style as Style;

if ( ! defined( 'ABSPATH' ) ) exit;

class Widget {

	/**
	 * ウィジェットタイトルのスタイルを生成する関数
	 */
	public static function get_widget_title_style( $type, $frame_class = '' ) {

		$is_on_frame = false;
		if ( $frame_class && '-frame-off' !== $frame_class ) {
			$is_on_frame = true;
		}

		$title         = '';
		$title__before = '';
		$title__after  = '';

		switch ( $type ) {
			case 'b_left':
				$title .= 'border-left:solid 2px var(--color_main);padding:0em .75em';
				break;
			case 'fill':
				if ( $is_on_frame ) {
					$title .= 'padding:.5em 1em;border-radius: var(--swl-radius--4,0) var(--swl-radius--4,0) 0 0;';
					if ( '-frame-on -frame-off-sidebar' !== $frame_class ) {
						$title .= 'margin: -16px -16px 1.5em;';
					}
				} else {
					$title .= 'padding:.5em .75em;border-radius:var(--swl-radius--2, 0px);';
				}
				$title .= 'background:var(--color_main);color:#fff;';
				break;
			case 'b_lr':
				$title         .= 'text-align:center;padding:.25em 3.5em;';
				$ba_common      = 'content:"";top:50%;width:2em;background:currentColor;';
				$title__before .= $ba_common . 'left:1em';
				$title__after  .= $ba_common . 'right:1em';
				break;
			case 'b_bottom':
				$title         .= $is_on_frame ? 'padding:0 .5em .5em' : 'padding:.5em';
				$title__before .= 'content:"";bottom:0;left:0;width:40%;z-index:1;background:var(--color_main)';
				$title__after  .= 'content:"";bottom:0;left:0;width:100%;background:var(--color_border)';
				break;
			default:
				break;
		}

		return [
			'main'   => $title,
			'before' => $title__before,
			'after'  => $title__after,
		];
	}

	/**
	 * ウィジェットタイトル
	 */
	public static function title( $frame_class ) {

		$styles          = self::get_widget_title_style( SWELL::get_setting( 'sidettl_type' ), $frame_class );
		$sidettl_type_sp = SWELL::get_setting( 'sidettl_type_sp' );
		$styles_sp       = $sidettl_type_sp ? self::get_widget_title_style( $sidettl_type_sp, $frame_class ) : '';

		// スマホとPCでスタイルが分かれるかどうか
		if ( $styles_sp ) {
			Style::add( '.c-widget__title.-side', $styles_sp['main'], 'sp' );
			Style::add( '.c-widget__title.-side::before', $styles_sp['before'], 'sp' );
			Style::add( '.c-widget__title.-side::after', $styles_sp['after'], 'sp' );

			Style::add( '.c-widget__title.-side', $styles['main'], 'pc' );
			Style::add( '.c-widget__title.-side::before', $styles['before'], 'pc' );
			Style::add( '.c-widget__title.-side::after', $styles['after'], 'pc' );
		} else {
			Style::add( '.c-widget__title.-side', $styles['main'] );
			Style::add( '.c-widget__title.-side::before', $styles['before'] );
			Style::add( '.c-widget__title.-side::after', $styles['after'] );
		}
	}


	/**
	 * ウィジェットタイトル（SPメニュー）
	 */
	public static function spmenu_title() {

		$styles = self::get_widget_title_style( \SWELL_Theme::get_setting( 'spmenu_title_type' ) );
		Style::add( '.c-widget__title.-spmenu', $styles['main'] );
		Style::add( '.c-widget__title.-spmenu::before', $styles['before'] );
		Style::add( '.c-widget__title.-spmenu::after', $styles['after'] );
	}


	/**
	 * ウィジェットタイトル（フッター）
	 */
	public static function footer_title() {

		$styles = self::get_widget_title_style( \SWELL_Theme::get_setting( 'footer_title_type' ) );
		Style::add( '.c-widget__title.-footer', $styles['main'] );
		Style::add( '.c-widget__title.-footer::before', $styles['before'] );
		Style::add( '.c-widget__title.-footer::after', $styles['after'] );
	}

}
