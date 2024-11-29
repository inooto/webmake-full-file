<?php
namespace SWELL_Theme;

use \SWELL_Theme as SWELL;
use \SWELL_Theme\Style as Style;

if ( ! defined( 'ABSPATH' ) ) exit;

class Style {

	/**
	 * CSS変数をまとめておく
	 */
	public static $root_styles = [
		'all'    => '',
		'pc'     => '',
		'sp'     => '',
		'tab'    => '',
		'mobile' => '',
	];

	/**
	 * 最終的に吐き出すCSS
	 */
	public static $styles = [
		'all'    => '',
		'pc'     => '',
		'sp'     => '',
		'tab'    => '',
		'mobile' => '',
	];

	/**
	 * 別ファイルとして分離しているCSS
	 */
	public static $modules = [];

	/**
	 * 直書きスタイル
	 */
	public static $ex_css = '';

	/**
	 * 外部からのインタンス呼び出し無効
	 */
	private function __construct() {}


	/**
	 * reset
	 */
	public static function reset() {
		self::$root_styles = [
			'all'    => '',
			'pc'     => '',
			'sp'     => '',
			'tab'    => '',
			'mobile' => '',
		];

		self::$styles = [
			'all'    => '',
			'pc'     => '',
			'sp'     => '',
			'tab'    => '',
			'mobile' => '',
		];

		self::$ex_css = '';
	}


	/**
	 * :rootスタイル生成
	 */
	public static function add_root( $name, $val, $media_query = 'all' ) {
		self::$root_styles[ $media_query ] .= $name . ':' . $val . ';';
	}


	/**
	 * スタイル生成
	 */
	public static function add( $selectors, $properties, $media_query = 'all', $branch = '' ) {

		if ( empty( $properties ) ) return;

		if ( is_array( $selectors ) ) {
			$selectors = implode( ',', $selectors );
		}

		if ( is_array( $properties ) ) {
			$properties = implode( ';', $properties );
		}

		if ( 'editor' === $branch ) {
			if ( ! is_admin() ) return;
		} elseif ( 'front' === $branch ) {
			if ( is_admin() ) return;
		}

		self::$styles[ $media_query ] .= $selectors . '{' . $properties . '}';
	}


	/**
	 * スタイル生成（フロントとエディターで出し分ける）
	 */
	public static function add_post_style( $selectors, $properties, $media_query = 'all', $branch = 'both' ) {

		if ( empty( $properties ) ) return;
		if ( 'editor' === $branch && ! is_admin() ) return;
		if ( 'front' === $branch && is_admin() ) return;

		$new_selector = '';
		foreach ( $selectors as $s ) {
			if ( is_admin() ) {
				$new_selector .= '.mce-content-body ' . $s . ', .editor-styles-wrapper ' . $s;
			} else {
				$new_selector .= '.post_content ' . $s;
			}
			if ( end( $selectors ) !== $s ) {
				$new_selector .= ',';
			}
		}

		self::add( $new_selector, $properties, $media_query );
	}


	/**
	 * パーツ化したCSSファイルの読み込み
	 */
	public static function add_module( $filename = '' ) {
		self::$modules[] = $filename;
	}


	/**
	 * CSSの生成
	 */
	public static function generate_css() {
		$styles      = self::$styles;
		$root_styles = self::$root_styles;

		$css  = '';
		$css .= ':root{' . $root_styles['all'] . '}';
		$css .= $styles['all'];
		$css .= '@media screen and (min-width: 960px){:root{' . $root_styles['pc'] . '}' . $styles['pc'] . '}';
		$css .= '@media screen and (max-width: 959px){:root{' . $root_styles['sp'] . '}' . $styles['sp'] . '}';
		$css .= '@media screen and (min-width: 600px){:root{' . $root_styles['tab'] . '}' . $styles['tab'] . '}';
		$css .= '@media screen and (max-width: 599px){:root{' . $root_styles['mobile'] . '}' . $styles['mobile'] . '}';
		$css .= self::$ex_css;

		self::reset();
		return $css;
	}


	/**
	 * 生成したCSSの出力
	 */
	public static function load_modules( $is_inline ) {
		$return = '';
		foreach ( self::$modules as $filename ) {

			if ( $is_inline ) {
				$include_path = T_DIRE . '/build/css/modules/' . $filename . '.css';
				$return      .= SWELL::get_file_contents( $include_path );
			} else {
				$include_path = T_DIRE_URI . '/build/css/modules/' . $filename . '.css';
				wp_enqueue_style( "swell-{$filename}", $include_path, [ 'main_style' ], SWELL_VERSION );
			}
		}

		$return        = str_replace( '@charset "UTF-8";', '', $return );
		self::$modules = [];
		return $return;
	}


	/**
	 * パーツ化したCSSファイルの読み込み
	 */
	public static function set_front_common_modules() {

		// サイト全体の立体設定
		if ( ! SWELL::get_setting( 'to_site_flat' ) ) {
			self::add_module( 'site-solid' );
		}

		// サイト全体の画像を丸くするかどうか
		if ( SWELL::get_setting( 'to_site_rounded' ) ) {
			self::add_module( 'site-radius' );
		}

		if ( SWELL::is_use( 'head_bar' ) ) {
			self::add_module( 'parts/head_bar' );
		}

		// スマホヘッダーメニュー
		if ( SWELL::is_use( 'sp_head_nav' ) ) {
			self::add_module( 'parts/sp-head-nav' );
		}

		// ヘッダーレイアウト
		if ( 'series_right' === SWELL::get_setting( 'header_layout' ) || 'series_left' === SWELL::get_setting( 'header_layout' ) ) {
			self::add_module( 'parts/header--series' );
		} else {
			self::add_module( 'parts/header--parallel' );
		}

		// グロナビ背景の上書き
		if ( 'overwrite' === SWELL::get_setting( 'gnav_bg_type' ) ) {
			self::add_module( 'parts/gnav-overwrite' );
		}

		// グロナビとスマホメニューのサブメニューの展開方式
		if ( SWELL::is_use( 'acc_submenu' ) ) {
			self::add_module( 'submenu-acc' );
		} else {
			self::add_module( 'submenu-normal' );
		}

	}


	/**
	 * フロントスタイル - 全ページ共通
	 */
	public static function get_front_common_style() {

		self::set_content_style();

		// カラー
		Style\Color::front();

		Style\Body::content_size();
		Style\Body::bg();

		// header
		Style\Header::header_border();
		Style\Header::head_bar();
		Style\Header::header_sp_layout();
		Style\Header::header_menu_btn();
		Style\Header::logo();
		Style\Header::gnav();
		if ( SWELL::is_use( 'fix_header' ) ) {
			self::add( '.l-fixHeader::before', 'opacity:' . SWELL::get_setting( 'fix_header_opacity' ) );
			self::add_module( 'parts/fix-header' );
		}

		// お知らせバー
		if ( 'none' !== SWELL::get_setting( 'info_bar_pos' ) ) {
			Style\Header::info_bar();
			self::add_module( 'parts/info-bar' );
		}

		// footer
		Style\Footer::pagetop_btn();
		Style\Footer::index_btn();

		// 下部固定メニュー
		if ( has_nav_menu( 'fix_bottom_menu' ) ) {
			Style\Footer::fix_menu_btns();
			self::add_module( 'parts/fix_bottom_menu' );
		}

		// フッター前マージン
		if ( SWELL::get_setting( 'footer_no_mt' ) ) {
			self::add( '#before_footer_widget', 'margin-bottom:0' );
		}

		// ウィジェット
		Style\Widget::spmenu_title();
		Style\Widget::footer_title();

		// その他
		Style\Others::section_title();
		Style\Others::spmenu();
		Style\Others::sidebar();
		Style\Others::pager();
		Style\Others::link();
		Style\Others::title_bg();
		Style\Others::toc();

		// 共通モジュール
		self::set_front_common_modules();

		$css  = self::generate_css();
		$css .= self::load_modules( 1 );
		return $css;
	}


	/**
	 * フロントスタイル - ページによって異なる
	 */
	public static function get_front_page_style() {
		$SETTING = SWELL::get_setting();

		// frameで変わるスタイル
		if ( ! is_singular( 'lp' ) ) {

			$frame_class = SWELL::get_frame_class();
			if ( '-frame-off' === $frame_class ) {
				self::add_module( 'frame-off' );
			} else {
				self::add_module( 'frame-on' );
			}
			Style\Body::content_frame( $frame_class );
			Style\Widget::title( $frame_class );

		}

		// トップページ
		if ( SWELL::is_top() && ! is_paged() ) {
			// コンテンツ上の余白量
			self::add( '.top #content', 'padding-top:' . SWELL::get_setting( 'top_content_mt' ) );

			if ( SWELL::is_use( 'top_header' ) ) {
				if ( SWELL::get_setting( 'fix_header_sp' ) ) {
					self::add_module( 'parts/top-header--spfix' );
				} else {
					self::add_module( 'parts/top-header--spnofix' );
				}
			}

			if ( SWELL::is_use( 'mv' ) ) {
				Style\Top::mv();
			}
			if ( SWELL::is_use( 'post_slider' ) ) {
				Style\Top::post_slider();
			}
		}

		// 投稿ページ
		if ( is_single() ) {
			Style\Page::title_date();
			Style\Page::share_btn();
			if ( ! SWELL::get_setting( 'show_toc_ad_alone_post' ) ) {
				style::add( '.single.-index-off .w-beforeToc', 'display:none' );
			}

			self::add_module( 'parts/related-posts--' . SWELL::get_setting( 'related_post_style' ) );
		}

		// 固定ページ
		if ( is_page() ) {
			if ( ! SWELL::get_setting( 'show_toc_ad_alone_page' ) ) {
				style::add( '.page.-index-off .w-beforeToc', 'display:none' );
			}
		}

		$css  = self::generate_css();
		$css .= self::load_modules( 1 );
		return $css;
	}


	/**
	 * フロント&エディター共通
	 */
	public static function set_content_style() {

		// フォント
		Style\Body::font();

		// カラー用CSS変数のセット
		Style\Color::common();

		// ボタン
		Style\Post::btn();

		// 引用
		Style\Post::blockquote( SWELL::get_editor( 'blockquote_type' ) );

		// メインカラー
		$color_main = SWELL::get_setting( 'color_main' );

		// パレット
		self::add_root( '--color_deep01', SWELL::get_editor( 'color_deep01' ) );
		self::add_root( '--color_deep02', SWELL::get_editor( 'color_deep02' ) );
		self::add_root( '--color_deep03', SWELL::get_editor( 'color_deep03' ) );
		self::add_root( '--color_deep04', SWELL::get_editor( 'color_deep04' ) );
		self::add_root( '--color_pale01', SWELL::get_editor( 'color_pale01' ) );
		self::add_root( '--color_pale02', SWELL::get_editor( 'color_pale02' ) );
		self::add_root( '--color_pale03', SWELL::get_editor( 'color_pale03' ) );
		self::add_root( '--color_pale04', SWELL::get_editor( 'color_pale04' ) );

		// マーカー
		self::add_root( '--color_mark_blue', SWELL::get_editor( 'color_mark_blue' ) );
		self::add_root( '--color_mark_green', SWELL::get_editor( 'color_mark_green' ) );
		self::add_root( '--color_mark_yellow', SWELL::get_editor( 'color_mark_yellow' ) );
		self::add_root( '--color_mark_orange', SWELL::get_editor( 'color_mark_orange' ) );
		Style\Post::marker( SWELL::get_editor( 'marker_type' ), SWELL::get_setting( 'body_font_family' ) );

		// ボーダーセット
		self::add_root( '--border01', SWELL::get_editor( 'border01' ) );
		self::add_root( '--border02', SWELL::get_editor( 'border02' ) );
		self::add_root( '--border03', SWELL::get_editor( 'border03' ) );
		self::add_root( '--border04', SWELL::get_editor( 'border04' ) );

		// アイコンボックス
		Style\Post::iconbox( SWELL::get_editor( 'iconbox_s_type' ), SWELL::get_editor( 'iconbox_type' ) );

		// アイコンボックス
		Style\Post::balloon();

		// 投稿リストのサムネイル比率
		Style\Post_List::thumb_ratio(
			SWELL::get_setting( 'card_posts_thumb_ratio' ),
			SWELL::get_setting( 'list_posts_thumb_ratio' ),
			SWELL::get_setting( 'big_posts_thumb_ratio' ),
			SWELL::get_setting( 'thumb_posts_thumb_ratio' ),
			SWELL::get_setting( 'blogcard_thumb_ratio' )
		);

		// 投稿リストのREAD MORE
		Style\Post_List::read_more();

		// 投稿リストのカテゴリー部分
		$cat_bg_color = SWELL::get_setting( 'pl_cat_bg_color' ) ?: $color_main;
		Style\Post_List::category( SWELL::get_setting( 'pl_cat_bg_style' ), $cat_bg_color, SWELL::get_setting( 'pl_cat_txt_color' ) );

		// 見出し
		$color_htag = SWELL::get_setting( 'color_htag' ) ?: $color_main;
		Style\Post::h2( SWELL::get_setting( 'h2_type' ), $color_htag );
		Style\Post::h3( SWELL::get_setting( 'h3_type' ), $color_htag );
		Style\Post::h4( SWELL::get_setting( 'h4_type' ), $color_htag );
		Style\Post::h2_section( SWELL::get_setting( 'sec_h2_type' ), SWELL::get_setting( 'color_sec_htag' ) );

		// 太字
		if ( SWELL::get_setting( 'show_border_strong' ) ) {
			self::add_post_style( [ 'p > strong' ], 'padding: 0 4px 3px;border-bottom: 1px dashed #bbb' );
		}
	}


	/**
	 * エディター用CSSを取得
	 */
	public static function get_editor_css() {

		self::set_content_style();

		Style\Color::editor();
		Style\Editor::content_bg();
		Style\Editor::balloon();
		Style\Editor::css_block_width();

		self::add( [ '.editor-styles-wrapper p > a', '.mce-content-body p > a' ], 'color: var(--color_link)' );
		if ( ! SWELL::get_setting( 'show_link_underline' ) ) {
			self::add( [ '.editor-styles-wrapper p > a', '.mce-content-body p > a' ], 'text-decoration: none' );
		}

		// サイト全体の画像を丸くするかどうか
		if ( SWELL::get_setting( 'to_site_rounded' ) ) {
			self::add_module( 'site-radius' );
		}

		// サイト全体の立体設定
		if ( ! SWELL::get_setting( 'to_site_flat' ) ) {
			self::add_module( 'site-solid' );
		}

		$css  = self::generate_css();
		$css .= self::load_modules( 1 );

		return $css;
	}


	/**
	 * CSSを取得
	 */
	public static function get_front_css() {
		$css        = '';
		$common_css = '';
		$page_style = '';

		// キャッシュを使うかどうか
		$use_cache = ( SWELL::get_setting( 'cache_style' ) && ! is_customize_preview() );
		if ( $use_cache ) {

			// 全ページ共通
			$common_css = get_transient( 'swell_parts_style_common' ) ?: '';
			if ( ! $common_css ) {
				$common_css = self::get_front_common_style();
				set_transient( 'swell_parts_style_common', $common_css, 30 * DAY_IN_SECONDS );
			}

			// ページ種別ごと
			$cache_key  = 'swell_parts_style_' . SWELL::get_page_type_slug();
			$page_style = get_transient( $cache_key ) ?: '';
			if ( ! $page_style ) {
				$page_style = self::get_front_page_style();
				set_transient( $cache_key, $page_style, 30 * DAY_IN_SECONDS );
			}
		} else {
			$common_css = self::get_front_common_style(); // 全ページ共通
			$page_style = self::get_front_page_style(); // ページ種別ごと
		}

		$css .= $common_css;
		$css .= $page_style;

		// キャッシュさせないCSS
		$css .= self::get_nocache_css();

		return $css;
	}


	/**
	 * パーツ化したCSSファイルの読み込み(キャッシュ対象外)
	 */
	public static function get_nocache_css() {
		$style = '';

		$style .= self::get_nocache_inline_modules();
		$style .= self::get_nocache_modules();

		// タブ
		$is_android = SWELL::is_android();
		if ( $is_android ) {
			$style .= '.c-tabBody__item[aria-hidden="false"]{animation:none !important;display:block;}';
		}

		// Androidでは Noto-serif 以外はデフォルトフォントに指定。(游ゴシックでの太字バグがある & 6.0からデフォルトフォントが Noto-sans に。)
		$font = SWELL::get_setting( 'body_font_family' );
		if ( $is_android && 'serif' !== $font ) {
			$style .= 'body{font-weight:400;font-family:sans-serif}';
		}

		// ページごとのカスタムCSS
		if ( is_single() || is_page() || is_home() ) {
			if ( get_post_meta( get_queried_object_id(), 'swell_meta_no_mb', true ) === '1' ) {
				$style .= '#content{margin-bottom:0;}.w-beforeFooter{margin-top:0;}';
			};
		}

		return $style;
	}


	/**
	 * パーツ化したCSSファイルの読み込み(キャッシュ対象外・インライン出力)
	 */
	public static function get_nocache_inline_modules() {

		// 上部タイトルエリア
		if ( SWELL::is_show_ttltop() ) {
			self::add_module( 'parts/top-title-area' );
		}

		// ピックアップバナー
		if ( SWELL::is_show_pickup_banner() ) {
			if ( 'slide' === SWELL::get_setting( 'pickbnr_layout_sp' ) ) {
				self::add_module( 'parts/pickup-banner--slide' );
			} else {
				self::add_module( 'parts/pickup-banner' );
			}
		}

		// 目次
		if ( is_single() || is_page() || SWELL::is_term() || is_author() ) {
			self::add_module( 'parts/toc--' . SWELL::get_setting( 'index_style' ) );
		}

		if ( is_single() ) {
			if ( SWELL::is_show_page_links() ) {
				self::add_module( 'parts/pn-links--' . SWELL::get_setting( 'page_link_style' ) );
			}

			if ( SWELL::is_show_sns_cta() ) {
				self::add_module( 'parts/sns-cta' );
			}
		}

		return self::load_modules( 1 );
	}


	/**
	 * パーツ化したCSSファイルの読み込み(キャッシュ対象外)
	 */
	public static function get_nocache_modules() {

		// ページ表示時のアニメーション
		if ( ! SWELL::get_setting( 'remove_page_fade' ) ) {
			self::add_module( 'loaded-animation' );
		}

		// フッター
		self::add_module( 'parts/footer' );

		// pjax有効化どうかで処理を分岐
		if ( SWELL::is_use( 'pjax' ) ) {
			$mv = SWELL::site_data( 'mv' );
			if ( 'none' !== $mv ) {
				self::add_module( 'parts/main-visual--' . SWELL::site_data( 'mv' ) );
			}
			if ( 'on' === SWELL::get_setting( 'show_post_slide' ) ) {
				self::add_module( 'parts/post-slider' );
			}
			self::add_module( 'pages' );
		} else {
			// MV
			if ( SWELL::is_use( 'mv' ) ) {
				self::add_module( 'parts/main-visual--' . SWELL::site_data( 'mv' ) );
			};

			// 記事スライダー
			if ( SWELL::is_use( 'post_slider' ) ) {
				self::add_module( 'parts/post-slider' );
			}

			// ページ種別ごとのファイル
			if ( is_home() ) {
				self::add_module( 'page/home' );
			} elseif ( is_search() ) {
				self::add_module( 'page/search' );
			} elseif ( is_singular( 'lp' ) ) {
				self::add_module( 'page/lp' );
			} elseif ( is_single() ) {
				self::add_module( 'page/single' );
			} elseif ( is_page() ) {
				self::add_module( 'page/page' );
			} elseif ( SWELL::is_term() ) {
				self::add_module( 'page/term' );
			} elseif ( is_author() ) {
				self::add_module( 'page/author' );
			} elseif ( is_archive() ) {
				self::add_module( 'page/archive' );
			} elseif ( is_404() ) {
				self::add_module( 'page/404' );
			}
		}

		// コメント
		if ( is_single() || is_page() ) {
			$the_id = get_queried_object_id();
			if ( SWELL::is_show_comments( $the_id ) ) {
				self::add_module( 'parts/comments' );
			};
		}

		// カスタマイザープレビュー時
		if ( is_customize_preview() ) {
			self::add_module( 'customizer-preview' );
		}

		return self::load_modules( SWELL::is_load_css_inline() );
	}

}
