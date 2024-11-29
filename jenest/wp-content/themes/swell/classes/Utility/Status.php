<?php
namespace SWELL_Theme\Utility;

if ( ! defined( 'ABSPATH' ) ) exit;

trait Status {

	/**
	 * WodPressのバージョンチェック
	 */
	public static function wpver_is_above( $version ) {
		global $wp_version;
		return ( version_compare( $wp_version, $version . '-beta' ) >= 0 );
	}


	/**
	 * $use の値を取得
	 */
	public static function is_use( $key ) {
		if ( ! isset( self::$use[ $key ] ) ) {
			return false;
		}
		return self::$use[ $key ];
	}


	/**
	 * $use の値を取得
	 */
	public static function set_use( $key, $val ) {
		self::$use[ $key ] = $val;
	}


	/**
	 * モバイル判定
	 */
	public static function is_mobile() {

		$ua = \SWELL_Theme::$user_agent;

		// iPhone
		if (strpos( $ua, 'iphone' ) !== false) return true;
		// Android Mobile
		if (strpos( $ua, 'android' ) !== false && strpos( $ua, 'mobile' ) !== false) return true;
		// BlackBerry
		if (strpos( $ua, 'blackberry' ) !== false) return true;
		// FireFox Mobile
		if (strpos( $ua, 'firefox' ) !== false && strpos( $ua, 'mobile' ) !== false) return true;
		// Win mobile
		if (strpos( $ua, 'windows' ) !== false && strpos( $ua, 'phone' ) !== false) return true;

		return false;
	}


	/**
	 * モバイル判定 の結果を IS_MOBILE に渡すための関数
	 * customize_previewed_device はカスタマイザーのプレビュー画面で受け取れる値
	 */
	public static function get_is_mobile() {

		// phpcs:disable WordPress.Security.NonceVerification.Recommended
		$customize_previewed_device = '';
		if ( isset( $_GET['customize_previewed_device'] ) ) {
			$customize_previewed_device = $_GET['customize_previewed_device'];

		}
		return self::is_mobile() || 'mobile' === $customize_previewed_device;
	}


	/**
	 * Android判定
	 */
	public static function is_android() {
		$is_android = strpos( \SWELL_Theme::$user_agent, 'android' ) !== false;
		return (bool) $is_android;
	}


	/**
	 * ボット判定
	 */
	public static function is_bot() {
		$bots = [
			'googlebot',            // Google
			'yahoo',                // Yahoo
			'bingbot',              // Bing
			'msnbot',               // = Bingbot
			'baiduspider',          // Baidu
			'yeti',                 // NAVER
			'naverbot',             // NAVER
			'livedoor',             // Livedoor
			'twitterbot',           // Twitter
			'facebookexternalhit',  // Facebook
			'pinterest',            // Pinterest
			'tumblr',               // Tumblr
			'feedly',               // Feedly
		];
		foreach ( $bots as $bot ) {
			if ( stripos( \SWELL_Theme::$user_agent, $bot ) !== false ) {
				return true;
			}
		}
		return false;
	}


	/**
	 * トップページかどうか (フロントページの存在しない場合の投稿ページまで考慮)
	 */
	public static function is_top() {
		if ( is_front_page() ) {
			return true;
		} elseif ( is_home() && 0 === get_queried_object_id() ) {
			return true;
		}
		return false;
	}


	/**
	 * タームアーカイブページかどうか
	 */
	public static function is_term() {
		return is_category() || is_tag() || is_tax();
	}


	/**
	 * 管理者権限を持つかどうか。
	 */
	public static function is_administrator() {
		return current_user_can( 'manage_options' );
	}


	/**
	 * ウィジェットブロック化が有効かどうか
	 */
	public static function use_widgets_block() {

		if ( ! function_exists( '\wp_use_widgets_block_editor' ) ) {
			return false;
		}
		return wp_use_widgets_block_editor();
	}


	/**
	 * RESTリクエスト中かどうか
	 */
	public static function is_rest( $type = '' ) {
		$is_rest = ( defined( 'REST_REQUEST' ) && REST_REQUEST );

		if ( 'lazyload' === $type ) {
			return $is_rest && isset( $_REQUEST['placement'] );
		}
		return $is_rest;
	}


	/**
	 * ウィジェットプレビューiframeの中かどうか
	 */
	public static function is_iframe() {
		return ( defined( 'IFRAME_REQUEST' ) && IFRAME_REQUEST );
	}


	/**
	 * ウィジェットプレビューiframeの中かどうか
	 */
	public static function is_widget_iframe() {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		return ! empty( $_GET['legacy-widget-preview'] );
	}


	/**
	 * アイキャッチ画像を表示するかどうか
	 */
	public static function is_show_thumb( $post_id ) {

		if ( ! $post_id ) return false;

		$setting_key = ( is_single() ) ? 'show_post_thumb' : 'show_page_thumb';

		$is_show_thumb = get_post_meta( $post_id, 'swell_meta_show_thumb', true );
		if ( $is_show_thumb === 'show' ) {

			$is_show_thumb = true;

		} elseif ( $is_show_thumb === 'hide' ) {

			$is_show_thumb = false;

		} else {

			$is_show_thumb = self::get_setting( $setting_key );

		}

		// アイキャッチを表示しない場合の追加条件
		if ( (int) get_query_var( 'page' ) !== 0 ) {
			$is_show_thumb = false;
		}

		return $is_show_thumb;
	}


	/**
	 * ページタイトルをコンテンツ上部に表示するかどうか
	 */
	public static function is_show_ttltop() {

		if ( self::is_top() || is_search() ) return false;

		if ( is_single() ) {
			$title_pos = self::get_setting( 'post_title_pos' );
		} elseif ( is_page() || is_home() ) {
			$title_pos = self::get_setting( 'page_title_pos' );
		} elseif ( self::is_term() ) {
			$title_pos = self::get_setting( 'term_title_pos' );
		} else {
			$title_pos = '';
		}

		$is_show_ttltop = ( 'top' === $title_pos ) ? true : false;
		return apply_filters( 'swell_is_show_ttltop', $is_show_ttltop );

	}


	/**
	 * 目次機能を使うかどうか
	 */
	public static function is_show_index() {

		$is_show = false;

		if ( ! is_singular( 'lp' ) && is_single() ) {
			$is_show = self::get_setting( 'show_index' );
		} elseif ( ! is_front_page() && is_page() ) {
			$is_show = self::get_setting( 'show_index_page' );
		}

		return apply_filters( 'swell_is_show_index', $is_show );
	}


	/**
	 * 目次広告を表示するかどうか
	 */
	public static function is_show_toc_ad() {

		$is_show = false;

		if ( ! is_singular( 'lp' ) && is_single() ) {
			$is_show = self::get_setting( 'show_toc_ad_alone_post' ) || self::is_show_index();
		} elseif ( ! is_front_page() && is_page() ) {
			$is_show = self::get_setting( 'show_toc_ad_alone_page' ) || self::is_show_index();
		}

		return apply_filters( 'swell_is_show_toc_ad', $is_show );
	}


	/**
	 * 各ページでサイドバーを使用するかどうか
	 */
	public static function is_show_sidebar() {

		if ( self::is_top() ) {

			$is_show = self::get_setting( 'show_sidebar_top' );

		} elseif ( is_singular( 'lp' ) ) {

			$is_show = false;

		} elseif ( is_page() || is_home() ) {

			$is_show = self::get_setting( 'show_sidebar_page' );

		} elseif ( is_single() ) {

			$is_show = self::get_setting( 'show_sidebar_post' );

		} elseif ( is_archive() ) {

			$is_show = self::get_setting( 'show_sidebar_archive' );

		} elseif ( is_search() ) {

			$is_show = self::get_setting( 'show_sidebar_archive' );

		} else {

			$is_show = false;

		}

		return apply_filters( 'swell_is_show_sidebar', $is_show );

	}


	/**
	 * コメントを使用するかどうか
	 */
	public static function is_show_comments( $post_id ) {

		$is_show = true;

		if ( post_password_required( $post_id ) ) {
			// パスワード保護記事ではコメントエリア非表示
			$is_show = false;

		} elseif ( ! comments_open( $post_id ) && intval( get_comments_number( $post_id ) ) < 1 ) {
			// コメント非許可、かつコメントがまだない時
			$is_show = false;

		} elseif ( is_single() ) {
			// カスタマイザーの設定に依存
			$is_show = self::get_setting( 'show_comments' );

			// メタで上書き
			$comments_meta = get_post_meta( $post_id, 'swell_meta_show_comments', true );
			if ( 'hide' === $comments_meta ) {
				$is_show = false;
			} elseif ( 'show' === $comments_meta ) {
				$is_show = true;
			}
		}

		return apply_filters( 'swell_is_show_comments', $is_show );
	}


	/**
	 * ピックアップバナーを使用するかどうか
	 */
	public static function is_show_pickup_banner() {

		$cached_flag = wp_cache_get( 'is_show_pickup_banner', 'swell' );
		if ( $cached_flag ) return $cached_flag;

		if ( is_paged() ) return false;
		if ( ! has_nav_menu( 'pickup_banner' ) ) return false;

		$is_show = false;

		if ( self::is_top() ) {
			$is_show = true;
		} else {
			$is_show = self::get_setting( 'pickbnr_show_under' );
		}

		$is_show = apply_filters( 'swell_is_show_pickup_banner', $is_show );
		wp_cache_set( 'is_show_pickup_banner', $is_show, 'swell' );
		return $is_show;
	}



	/**
	 * 投稿ページの前の記事・次の記事リンクを使用するかどうか
	 */
	public static function is_show_page_links() {
		$is_show = self::get_setting( 'show_page_links' );
		return apply_filters( 'swell_is_show_page_links', $is_show );
	}


	/**
	 * 投稿ページの前の記事・次の記事リンクを使用するかどうか
	 */
	public static function is_show_sns_cta() {
		$data = self::get_sns_cta_data();
		return ( $data['tw_id'] || $data['fb_url'] || $data['insta_id'] );
	}



	/**
	 * CSSをインライン出力するかどうか
	 */
	public static function is_load_css_inline() {
		$cached_flag = wp_cache_get( 'is_load_css_inline', 'swell' );
		if ( $cached_flag ) return $cached_flag;

		$flag = \SWELL_Theme::get_option( 'load_style_inline' );

		wp_cache_set( 'is_load_css_inline', $flag, 'swell' );
		return $flag;
	}


	/**
	 * 必要なCSSだけを読み込むかどうか
	 */
	public static function is_separate_css() {

		if ( is_customize_preview() ) return false;
		if ( self::is_use( 'pjax' ) ) return false;

		$flag = (bool) \SWELL_Theme::get_option( 'separate_style' );
		return apply_filters( 'swell_is_separate_css', $flag );
	}

}
