<?php
namespace SWELL_Theme\Style;

use SWELL_Theme\Style as Style;

if ( ! defined( 'ABSPATH' ) ) exit;

class Post_List {

	/**
	 * サムネイル比率
	 */
	public static function thumb_ratio( $card_ratio, $list_ratio, $big_ratio, $thumb_ratio, $blogcard_ratio ) {

		Style::add_root(
			'--card_posts_thumb_ratio',
			\SWELL_Theme::$thumb_ratios[ $card_ratio ]['value']
		);
		Style::add_root(
			'--list_posts_thumb_ratio',
			\SWELL_Theme::$thumb_ratios[ $list_ratio ]['value']
		);
		Style::add_root(
			'--big_posts_thumb_ratio',
			\SWELL_Theme::$thumb_ratios[ $big_ratio ]['value']
		);
		Style::add_root(
			'--thumb_posts_thumb_ratio',
			\SWELL_Theme::$thumb_ratios[ $thumb_ratio ]['value']
		);
		Style::add_root(
			'--blogcard_thumb_ratio',
			\SWELL_Theme::$thumb_ratios[ $blogcard_ratio ]['value']
		);

	}

	/**
	 * READ MORE
	 */
	public static function read_more() {
		Style::add(
			['.-type-list2 .p-postList__body::after', '.-type-big .p-postList__body::after' ],
			'content: "' . \SWELL_Theme::get_setting( 'post_list_read_more' ) . ' »";'
		);
	}

	/**
	 * カテゴリー部分
	 */
	public static function category( $cat_bg_style, $cat_bg_color, $cat_txt_color ) {

		$style = ['background-color:' . $cat_bg_color, 'color:' . $cat_txt_color ];

		if ( 'stripe' === $cat_bg_style ) {
			$style[] = 'background-image: repeating-linear-gradient(-45deg,rgba(255,255,255,.1),rgba(255,255,255,.1) 6px,transparent 6px,transparent 12px)';
		} elseif ( 'gradation' === $cat_bg_style ) {
			$col1    = $cat_bg_color;
			$col2    = \SWELL_Theme::get_rgba( $cat_bg_color, 1, .6 );
			$style[] = 'background: repeating-linear-gradient(100deg, ' . $col1 . ' 0, ' . $col2 . ' 100%)';
		}
		Style::add( '.c-postThumb__cat', $style );
	}

}
