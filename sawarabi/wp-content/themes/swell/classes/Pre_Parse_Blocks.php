<?php
namespace SWELL_Theme;

use \SWELL_Theme as SWELL;

if ( ! defined( 'ABSPATH' ) ) exit;

class Pre_Parse_Blocks {

	public static $sidebar_blocks = [];
	public static $dump           = [];

	/**
	 * check blocks
	 */
	public static function init() {

		// if ( ! ( is_singular( 'post' ) || is_page() ) ) return;

		// ブロックチェック用フィルター追加
		add_filter( 'render_block', [ __CLASS__, 'render_check' ], 10, 2 );

		// メインコンテンツをパースしてチェック
		if ( is_single() || is_page() || ( is_home() && ! is_front_page() ) ) {
			$post = get_post( get_queried_object_id() );
			if ( $post ) {
				self::parse_content( $post->post_content );
			}
		} elseif ( \SWELL_Theme::is_term() ) {
			$parts_id = get_term_meta( get_queried_object_id(), 'swell_term_meta_display_parts', 1 );
			$parts    = $parts_id ? get_post( $parts_id ) : '';
			if ( $parts ) {
				self::parse_content( $parts->post_content );
			}
		}

		// ウィジェットのチェック
		self::parse_widgets();

		// ブロックチェック用フィルター削除
		remove_filter( 'render_block', [ __CLASS__, 'render_check' ], 10 );

		// その他ページ種別等によってセットするもの
		if ( \SWELL_Theme::is_show_pickup_banner() ) {
			\SWELL_Theme::$used_blocks['loos/banner-link'] = true;
		}
		if ( is_home() || is_archive() ) {
			\SWELL_Theme::$used_blocks['loos/tab'] = true;
			// \SWELL_Theme::$used_blocks['loos/post-list'] = true;
		}
	}

	/**
	 * check parse_content
	 */
	public static function parse_content( $content ) {

		// $start = microtime( true );

		// do_shortcodeでブログパーツなどを展開させ、'rende_block' フックでチェック。
		foreach ( parse_blocks( do_shortcode( $content ) ) as $block ) {
			self::check_parsed_block( $block );
		}

		// $end = microtime( true );
		// var_dump( $end - $start );

		// コンテンツの文字列を直接チェック
		self::check_content_str( $content );
	}

	/**
	 * render_checkフック時にブロックを記録する
	 */
	public static function render_check( $block_content, $block ) {
		$block_name = $block['blockName'] ?? '';
		if ( ! $block_name ) return $block_content;

		self::push_used_blocks( $block_name, \SWELL_Theme::$used_blocks );
		return $block_content;
	}


	/**
	 * サイドバー内のrender_checkフック時にブロックを記録する
	 * memo: キャッシュもできるように別処理にしている
	 */
	public static function siderbar_render_check( $block_content, $block ) {
		$block_name = $block['blockName'] ?? '';
		if ( ! $block_name ) return $block_content;

		self::push_used_blocks( $block_name, self::$sidebar_blocks );
		return $block_content;
	}


	/**
	 * 使用されたブロックをリストに追加
	 */
	public static function check_parsed_block( $block ) {
		$block_name = $block['blockName'] ?? '';
		if ( ! $block_name ) return;

		self::push_used_blocks( $block_name, \SWELL_Theme::$used_blocks );

		// インナーブロックにも同じ処理を。
		if ( ! empty( $block['innerBlocks'] ) ) {
			foreach ( $block['innerBlocks'] as $innerBlock ) {
				self::check_parsed_block( $innerBlock );
			}
		}

		// ブログパーツ・同期パターンは展開して中身チェック
		$parts_id = 0;
		if ( 'loos/blog-parts' === $block_name ) {
			$parts_id = $block['attrs']['partsID'] ?? 0;
		} elseif ( 'core/block' === $block_name ) {
			$parts_id = $block['attrs']['ref'] ?? 0;
		}

		$parts = $parts_id ? get_post( $parts_id ) : '';
		if ( $parts ) {
			self::parse_content( $parts->post_content );
		}
	}



	/**
	 * 使用されたブロックをリストに追加
	 */
	public static function push_used_blocks( $block_name, &$list ) {

		// すでにリストに追加されていればreturn
		if ( isset( $list[ $block_name ] ) ) return;

		$list[ $block_name ] = true;

		// parse_blocks() だけだと separate なコアCSSはフッターで読み込まれてしまうのでここでキューに追加
		if ( false !== strpos( $block_name, 'core/' ) ) {
			$core_name = str_replace( 'core/', '', $block_name );
			wp_enqueue_style( "wp-block-{$core_name}" );
			// wp_deregister_style で特定のコアブロックCSSの読み込み解除も可

			// その他、共通パーツ等
			if ( 'categories' !== $core_name || 'archives' !== $core_name ) {
				$list['widget/dropdown'] = true;
				$list['widget/list']     = true;
			}
		}
	}


	/**
	 * ウィジェットのチェック
	 */
	public static function parse_widgets() {
		// ウィジェットごと
		add_action( 'dynamic_sidebar', [ __CLASS__, 'check_dynamic_sidebar' ] );

		// add_filter( 'pre_do_shortcode_tag', [ __CLASS__, 'pre_check_do_shortcode' ], 10, 2 );
		add_filter( 'widget_text', [ __CLASS__, 'check_widget_content_str' ], 1 );
		add_filter( 'widget_text_content', [ __CLASS__, 'check_widget_content_str' ], 1 );

		// サイドバーのチェック
		if ( \SWELL_Theme::is_show_sidebar() ) {
			self::parse_sidebar();
		}

		// ページ種別ごとのウィジェットチェック
		if ( \SWELL_Theme::is_top() ) {
			self::parse_front_widget();
		} elseif ( is_page() || is_home() ) {
			self::parse_page_widget();
		} elseif ( is_single() ) {
			self::parse_single_widget();
		}

		// その他のウィジェットチェック
		self::parse_other_area();

		// remove_filter( 'pre_do_shortcode_tag', [ __CLASS__, 'pre_check_do_shortcode' ], 10, 2 );
		remove_filter( 'widget_text', [ __CLASS__, 'check_widget_content_str' ], 1 );
		remove_filter( 'widget_text_content', [ __CLASS__, 'check_widget_content_str' ], 1 );
	}


	/**
	 * サイドバーのチェック
	 */
	public static function parse_sidebar() {

		// キャッシュ
		// $chached_data = '';
		// if ( $chached_data && is_array( $chached_data ) ) {
		// 	\SWELL_Theme::$used_blocks = array_merge( \SWELL_Theme::$used_blocks, $chached_data );
		// 	return;
		// }

		// 共通のチェック処理とは別に登録
		remove_filter( 'render_block', [ __CLASS__, 'render_check' ], 10 );
		add_filter( 'render_block', [ __CLASS__, 'siderbar_render_check' ], 10, 2 );

		ob_start();
		if ( \SWELL_Theme::is_show_sidebar() ) {
			\SWELL_Theme::get_parts( 'parts/sidebar_content' );
		}
		ob_clean();
		// $sidebar = ob_get_clean();

		// 共通のチェック処理を再登録
		remove_filter( 'render_block', [ __CLASS__, 'siderbar_render_check' ], 10, 2 );
		add_filter( 'render_block', [ __CLASS__, 'render_check' ], 10, 2 );

		// echo '<pre style="background:#e8f3ea;margin:20px;padding:20px;">';
		// var_dump( self::$sidebar_blocks );
		// echo '</pre>';

		// マージ
		\SWELL_Theme::$used_blocks = array_merge( \SWELL_Theme::$used_blocks, self::$sidebar_blocks );
	}


	/**
	 *  フロントページ専用ウィジェットのブロックチェック
	 */
	public static function parse_front_widget() {
		ob_start();
		\SWELL_Theme::outuput_widgets( 'front_top' );
		\SWELL_Theme::outuput_widgets( 'front_bottom' );
		ob_clean();
	}


	/**
	 * 投稿ページ専用ウィジェットのブロックチェック
	 */
	public static function parse_single_widget() {
		ob_start();
		\SWELL_Theme::outuput_cta();
		\SWELL_Theme::outuput_content_widget( 'single', 'top' );
		\SWELL_Theme::outuput_content_widget( 'single', 'bottom' );
		\SWELL_Theme::outuput_widgets( 'before_related' );
		\SWELL_Theme::outuput_widgets( 'after_related' );
		ob_clean();
	}


	/**
	 * 固定ページ専用ウィジェットのブロックチェック
	 */
	public static function parse_page_widget() {
		ob_start();
		\SWELL_Theme::outuput_content_widget( 'page', 'top' );
		\SWELL_Theme::outuput_content_widget( 'page', 'bottom' );
		ob_clean();
	}

	/**
	 * その他のウィジェットのチェック
	 */
	public static function parse_other_area() {
		ob_start();
		\SWELL_Theme::outuput_widgets( 'footer_sp' );
		\SWELL_Theme::outuput_widgets( 'footer_box1' );
		\SWELL_Theme::outuput_widgets( 'footer_box2' );
		\SWELL_Theme::outuput_widgets( 'footer_box3' );
		\SWELL_Theme::outuput_widgets( 'before_footer' );
		\SWELL_Theme::outuput_widgets( 'sp_menu_bottom' );
		\SWELL_Theme::outuput_widgets( 'head_box' );
		ob_clean();
	}


	/**
	 * ショートコードのチェック
	 */
	// public static function pre_check_do_shortcode( $return, $tag ) {
	// 	if ( 'ふきだし' === $tag || 'speech_balloon' === $tag ) {
	// 		\SWELL_Theme::$used_blocks['loos/balloon'] = true;
	// 	}
	// 	return $return;
	// }


	/**
	 * 文字列チェック
	 */
	public static function check_content_str( $content ) {

		if ( ! isset( \SWELL_Theme::$used_blocks['loos/ad-tag'] ) ) {
			if ( false !== strpos( $content, '[ad_tag' ) ) {
				\SWELL_Theme::$used_blocks['loos/ad-tag'] = true;
			}
		}

		if ( ! isset( \SWELL_Theme::$used_blocks['loos/balloon'] ) ) {
			if ( false !== strpos( $content, '[ふきだし' ) || false !== strpos( $content, '[speech_balloon' ) ) {
				\SWELL_Theme::$used_blocks['loos/balloon'] = true;
			}
		}
		if ( ! isset( \SWELL_Theme::$used_blocks['loos/cap-block'] ) ) {
			if ( false !== strpos( $content, 'cap_box' ) ) {
				\SWELL_Theme::$used_blocks['loos/cap-block'] = true;
			}
		}
		if ( ! isset( \SWELL_Theme::$used_blocks['loos/full-wide'] ) ) {
			if ( false !== strpos( $content, '[full_wide_content' ) ) {
				\SWELL_Theme::$used_blocks['loos/full-wide'] = true;
			}
		}
		if ( ! isset( \SWELL_Theme::$used_blocks['loos/banner-link'] ) ) {
			if ( false !== strpos( $content, '[カスタムバナー' ) || false !== strpos( $content, '[custom_banner' ) ) {
				\SWELL_Theme::$used_blocks['loos/banner-link'] = true;
			}
		}
		// if ( ! isset( \SWELL_Theme::$used_blocks['loos/post-list'] ) ) {
		// 	if ( false !== strpos( $content, '[post_list' ) ) {
		// 		\SWELL_Theme::$used_blocks['loos/post-list'] = true;
		// 	}
		// }
		if ( ! isset( \SWELL_Theme::$used_blocks['loos/table'] ) ) {
			if ( false !== strpos( $content, '<table' ) ) {
				\SWELL_Theme::$used_blocks['core/table'] = true;
			}
		}

	}


	/**
	 * 文字列チェック
	 */
	public static function check_widget_content_str( $content ) {
		self::check_content_str( $content );
		return $content;
	}


	/**
	 * check_dynamic_sidebar
	 */
	public static function check_dynamic_sidebar( $widget ) {
		$classname = $widget['classname'] ?? '';
		// var_dump( $classname );
		// widget_categories / widget_archive

		if ( 'widget_calendar' === $classname ) {
			\SWELL_Theme::$used_blocks['core/calendar'] = true;
		} elseif ( 'widget_tag_cloud' === $classname ) {
			\SWELL_Theme::$used_blocks['core/tag-cloud'] = true;
		} elseif ( 'widget_recent_entries' === $classname ) {
			\SWELL_Theme::$used_blocks['core/latest-posts'] = true;
		} elseif ( 'widget_categories' === $classname ) {
			\SWELL_Theme::$used_blocks['core/categories'] = true;
			\SWELL_Theme::$used_blocks['widget/dropdown'] = true;
			\SWELL_Theme::$used_blocks['widget/list']     = true;
		} elseif ( 'widget_archive' === $classname ) {
			\SWELL_Theme::$used_blocks['core/archives']   = true;
			\SWELL_Theme::$used_blocks['widget/dropdown'] = true;
			\SWELL_Theme::$used_blocks['widget/list']     = true;
		} elseif ( 'widget_rss' === $classname ) {
			\SWELL_Theme::$used_blocks['widget/list'] = true;
			\SWELL_Theme::$used_blocks['widget/rss']  = true;
		} elseif ( 'widget_pages' === $classname || 'widget_nav_menu' === $classname ) {
			\SWELL_Theme::$used_blocks['widget/list'] = true;
		} elseif ( 'widget_swell_prof_widget' === $classname ) {
			\SWELL_Theme::$used_blocks['widget/profile-box'] = true;
		}

		// elseif ( 'widget_swell_new_posts' === $classname || 'widget_swell_popular_posts' === $classname ) {
		// 	\SWELL_Theme::$used_blocks['loos/post-list'] = true;
		// }

		// elseif ( 'widget_search' === $classname ) {
		// 	\SWELL_Theme::$used_blocks['widget/search'] = true;
		// }
		// widget_meta
	}


}
