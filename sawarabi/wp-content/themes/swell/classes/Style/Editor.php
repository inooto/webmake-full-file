<?php
namespace SWELL_Theme\Style;

use \SWELL_Theme as SWELL;
use SWELL_Theme\Style as Style;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * エディター用に出力したいCSS
 */
class Editor {

	/**
	 * 記事コンテンツの背景色。
	 */
	public static function content_bg() {

		global $post_id; // 新規追加時は null
		global $post_type;

		// コンテンツの背景を白にするがオンのページを判定
		$is_bg_white = false;
		if ( 'frame_off' !== SWELL::get_setting( 'content_frame' ) ) {

			$frame_scope = SWELL::get_setting( 'frame_scope' );

			if ( '' === $frame_scope ) {
				// 全ページが対象のとき
				$is_bg_white = true;
			} else {
				$front_id = (int) get_option( 'page_on_front' );
				$is_page  = 'page' === $post_type && $post_id !== $front_id;
				$is_post  = 'post' === $post_type;

				if ( 'no_front' === $frame_scope ) {
					$is_bg_white = $post_id !== $front_id;
				} elseif ( 'page' === $frame_scope && $is_page ) {
					$is_bg_white = true;
				} elseif ( 'post' === $frame_scope && $is_post ) {
					$is_bg_white = true;
				} elseif ( 'post_page' === $frame_scope && ( $is_post || $is_page ) ) {
					$is_bg_white = true;
				}
			}
		}

		if ( $is_bg_white ) {
			Style::add_root( '--color_content_bg', '#fff' );
		} else {
			Style::add_root( '--color_content_bg', SWELL::get_setting( 'color_bg' ) );
		}
	}

	/**
	 * シャドウをeditorにだけ
	 */
	public static function balloon() {
		if ( ! SWELL::get_setting( 'to_site_flat' ) ) {
			Style::add(
				'.is-style-balloon .c-tabList__button',
				'box-shadow: 0 2px 4px rgba(0,0,0,.12)'
			);
		}
	}


/**
	 * ブロックサイズ
	 */
	public static function css_block_width() {

		global $post_id; // 新規追加時は null
		global $post_type;

		// $page_template = basename( get_page_template_slug() ) ?: '';
		$front_id           = (int) get_option( 'page_on_front' );
		$container_size     = (int) SWELL::get_setting( 'container_size' );
		$article_size       = (int) SWELL::get_setting( 'article_size' );
		$block_size_at_2col = $container_size - 348; // 300 + 48

		$is_2col_page = false;

		// 投稿タイプごとのデフォルト
		if ( 'page' === $post_type ) {
			$is_2col_page = SWELL::get_setting( 'show_sidebar_page' );
		} else {
			$is_2col_page = SWELL::get_setting( 'show_sidebar_post' );
		}

		if ( $post_id ) {
			if ( $front_id === $post_id ) {
				$is_2col_page = SWELL::get_setting( 'show_sidebar_top' );
			} else {
				$meta = get_post_meta( $post_id, 'swell_meta_show_sidebar', true );
				if ( 'show' === $meta ) {
					$is_2col_page = true;
				} elseif ( 'hide' === $meta ) {
					$is_2col_page = false;
				}
			}
		}

		$block_width = $is_2col_page ? $block_size_at_2col : $article_size;

		// ブロック幅
		Style::add( 'body', '--block_max_width:' . $block_width . 'px' );
	}

}
