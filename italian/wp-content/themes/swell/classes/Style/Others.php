<?php
namespace SWELL_Theme\Style;

use \SWELL_Theme as SWELL;
use SWELL_Theme\Style as Style;

if ( ! defined( 'ABSPATH' ) ) exit;

class Others {

	/**
	 * タイトル背景
	 */
	public static function title_bg() {

		style::add( '.l-topTitleArea.c-filterLayer::before', [
			'background-color:' . SWELL::get_setting( 'ttlbg_overlay_color' ),
			'opacity:' . SWELL::get_setting( 'ttlbg_overlay_opacity' ),
			'content:""',
		]);
	}


	/**
	 * 目次関連
	 */
	public static function toc() {
		$toc_before_color = SWELL::get_setting( 'toc_before_color' );
		if ( 'main' === $toc_before_color ) {
			style::add( '.p-toc__list.is-style-index li::before', 'color:var(--color_main)' );
		} elseif ( 'custom' === $toc_before_color ) {
			style::add( '.p-toc__list.is-style-index li::before', 'color:' . SWELL::get_setting( 'toc_before_custom_color' ) );
		}
	}


	/**
	 * セクションタイトル
	 */
	public static function section_title() {

		// ウィジェットタイトル用のCSSを使い回せる
		$styles = Widget::get_widget_title_style( SWELL::get_setting( 'sec_title_style' ) );

		Style::add( '.c-secTitle', $styles['main'] );
		Style::add( '.c-secTitle::before', $styles['before'] );
		Style::add( '.c-secTitle::after', $styles['after'] );
	}


	/**
	 * SPメニュー
	 */
	public static function spmenu() {
		Style::add( '.p-spMenu', 'color:' . SWELL::get_setting( 'color_spmenu_text' ) );
		Style::add( '.p-spMenu__inner::before', [
			'background:' . SWELL::get_setting( 'color_spmenu_bg' ),
			'opacity:' . SWELL::get_setting( 'spmenu_opacity' ),
		] );
		Style::add( '.p-spMenu__overlay', [
			'background:' . SWELL::get_setting( 'color_menulayer_bg' ),
			'opacity:' . SWELL::get_setting( 'menulayer_opacity' ),
		] );
	}


	/**
	 * サイドバー
	 */
	public static function sidebar() {
		if ( 'left' === SWELL::get_setting( 'sidebar_pos' ) ) {
			Style::add( '#main_content', 'order:2', 'pc' );
			Style::add( '#sidebar', 'order:1', 'pc' );
		}
	}


	/**
	 * ページャー
	 */
	public static function pager() {

		$pager_style = [];

		if ( 'circle' === SWELL::get_setting( 'pager_shape' ) ) {
			$pager_style[] = 'border-radius:50%;margin:4px';
		}

		if ( 'bg' === SWELL::get_setting( 'pager_style' ) ) {
			$pager_style[] = 'color:#fff;background-color:#dedede';
		} else {
			$pager_style[] = 'color:var(--color_main);border: solid 1px var(--color_main)';
		}

		Style::add( '[class*="page-numbers"]', $pager_style );
	}


	/**
	 * リンクに下線つけるかどうか
	 */
	public static function link() {
		if ( ! SWELL::get_setting( 'show_link_underline' ) ) {
			Style::add( 'a', 'text-decoration: none' );
		}
	}

}
