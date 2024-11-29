<?php
namespace SWELL_Theme\Utility;

if ( ! defined( 'ABSPATH' ) ) exit;

trait Attrs {

	/**
	 * 配列からhtml属性用の文字列を生成
	 */
	public static function array_to_html_attrs( $attrs = [], $use_trim = true ) {
		$attr_str = '';
		foreach ( $attrs as $name => $val ) {
			// falseの場合は出力スキップする
			if ( false === $val ) continue;

			// 任意の文字列を出力する
			if ( 'custom' === $name ) {
				$attr_str .= ' ' . $val;
				continue;
			}

			// 通常。name="value" の形式で出力する
			$attr_str .= ' ' . $name . '="' . esc_attr( $val ) . '"';
		}

		// 最初のスペースをtrimするかそのまま返すか
		if ( $use_trim ) return trim( $attr_str );
		return $attr_str;
	}


	/**
	 * HTMLタグに付与する属性値
	 */
	public static function root_attrs() {
		$attrs  = 'data-loaded="false"'; // DOM読み込み御用
		$attrs .= ' data-scrolled="false"'; // スクロール制御用
		$attrs .= ' data-spmenu="closed"'; // SPメニュー制御用

		echo apply_filters( 'swell_root_attrs', $attrs ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * #body_wrap に付与する属性値
	 */
	public static function body_attrs() {
		$attrs = self::is_use( 'pjax' ) ? 'data-barba="wrapper"' : '';
		echo apply_filters( 'swell_body_attrs', $attrs ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}


	/**
	 * #content に付与する属性値
	 */
	public static function content_attrs() {
		$attrs = '';
		if ( is_single() || is_page() || ( ! is_front_page() && is_home() ) ) {
			$the_id = get_queried_object_id();
			$attrs .= ' data-postid="' . $the_id . '"';
		}

		$is_bot = self::is_bot() || is_robots();
		if ( is_singular( self::$post_types_for_pvct ) && ! is_user_logged_in() && ! $is_bot ) {
			$attrs .= ' data-pvct="true"';
		}

		echo trim( apply_filters( 'swell_content_attrs', $attrs ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}


	/**
	 * #lp-content に付与する属性値
	 */
	public static function lp_content_attrs() {
		$attrs = 'data-postid="' . get_queried_object_id() . '"';
		echo trim( apply_filters( 'swell_lp_content_attrs', $attrs ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

}
