<?php
namespace SWELL_Theme\Style;

use \SWELL_Theme as SWELL;
use SWELL_Theme\Style as Style;

if ( ! defined( 'ABSPATH' ) ) exit;

class Body {

	/**
	 * フォント
	 * memo: "Segoe UI" は 500でboldになってしまうので游ゴシックでは使えない
	 */
	public static function font() {

		// コンテンツエリアのフォントサイズ
		Style::add_root( '--swl-fz--content', SWELL::get_setting( 'post_font_size_sp' ) );
		Style::add_root( '--swl-fz--content', SWELL::get_setting( 'post_font_size_pc' ), 'tab' );

		$letter_space = SWELL::get_setting( 'site_letter_space' );
		if ( $letter_space && 'normal' !== $letter_space ) {
			Style::add_root( '--swl-letter_spacing', SWELL::get_setting( 'site_letter_space' ) );
		}

		// フォントファミリー & 基本weight
		$font_weight = '400';
		$font_family = 'sans-serif';
		switch ( SWELL::get_setting( 'body_font_family' ) ) {
			case 'yugo':
				$font_weight = '500';
				$font_family = '"游ゴシック体", "Yu Gothic", YuGothic, "Hiragino Kaku Gothic ProN", "Hiragino Sans", Meiryo, sans-serif';
				break;
			case 'hirago':
				$font_family = '"Helvetica Neue", Arial, "Hiragino Kaku Gothic ProN", "Hiragino Sans", Meiryo, sans-serif';
				break;
			case 'notosans':
				$font_family = '"Noto Sans JP", sans-serif';
				break;
			case 'serif':
				$font_family = '"Noto Serif JP", "Hiragino Mincho ProN", serif';
				break;
			default:
				break;
		}

		Style::add_root( '--swl-font_family', $font_family );
		Style::add_root( '--swl-font_weight', $font_weight );
		// Style::add( 'body', [
		// 	'font-weight:' . $font_weight,
		// 	'font-family:' . $font_family,
		// ] );
	}


	/**
	 * コンテンツサイズ
	 */
	public static function content_size() {
		$container_size = (int) SWELL::get_setting( 'container_size' );
		$article_size   = (int) SWELL::get_setting( 'article_size' );
		Style::add_root( '--container_size', $container_size . 'px' );
		Style::add_root( '--article_size', $article_size . 'px' );
		Style::$ex_css .= '@media (min-width: ' . ( $article_size + 200 + 8 ) . 'px) {.alignwide{left:-100px;width:calc(100% + 200px);}}';
		Style::$ex_css .= '@media (max-width: ' . ( $article_size + 200 + 8 ) . 'px) {' .
			'.-sidebar-off .swell-block-fullWide__inner.l-container .alignwide{left:0px;width:100%;}}';
	}


	/**
	 * 背景
	 */
	public static function bg() {

		if ( SWELL::get_setting( 'body_bg' ) === '' ) return;

		// backgroundプロパティ生成
		$bg_repeat = ( SWELL::get_setting( 'noloop_body_bg' ) ) ? 'no-repeat' : 'repeat';
		$bg_prop   = 'url(' . SWELL::get_setting( 'body_bg' ) . ') ' . $bg_repeat . ' ' . SWELL::get_setting( 'body_bg_pos_x' ) . ' ' . SWELL::get_setting( 'body_bg_pos_y' );
		if ( SWELL::get_setting( 'body_bg_size' ) !== '' ) {
			$bg_prop .= ' / ' . SWELL::get_setting( 'body_bg_size' );
		}

		// fixかどうかで変える
		$selector = SWELL::get_setting( 'fix_body_bg' ) ? '#body_wrap::before ' : '#body_wrap';

		Style::add( $selector, 'background:' . $bg_prop );
		if ( SWELL::get_setting( 'body_bg_sp' ) !== '' ) {
			// spの画像が指定されていれば、imageだけ上書き
			Style::add( $selector, 'background-image:url(' . SWELL::get_setting( 'body_bg_sp' ) . ')', 'sp' );
		}
	}


	/**
	 * 記事コンテンツ部分の背景色
	 */
	public static function content_frame( $frame_class ) {

		// frame-on は 2パターンあるので、 !frame-off で判定
		if ( '-frame-off' !== $frame_class ) {
			Style::add_root( '--color_content_bg', '#fff' );
		} else {
			Style::add_root( '--color_content_bg', 'var(--color_bg)' );
		}
	}

}
