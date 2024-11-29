<?php
namespace SWELL_Theme\Utility;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * テンプレートパーツ取得メソッド
 */
trait Parts {

	/**
	 * 関数で呼び出すパーツ
	 */
	public static function pluggable_parts( $name, $args = [] ) {
		$func = 'swl_parts__' . $name;
		if ( function_exists( $func ) ) {
			$func( $args );
		}
	}

	/**
	 * pluggable_parts 取得版
	 */
	public static function get_pluggable_parts( $name, $args = [] ) {
		ob_start();
		self::pluggable_parts( $name, $args );
		return ob_get_clean();
	}


	/**
	 * テンプレート読み込み
	 * $path       : 読み込むファイルのパス
	 * $variable   : 引数として利用できるようにする変数
	 * $cache_key  : Transientキー
	 * $expiration : キャッシュ有効期限(default : 30日)
	 */
	public static function get_parts( $path, $variable = null, $cache_key = '', $expiration = null ) {
		// if ( $path === '' ) return 'not found '.$path;

		// まず子テーマ側から探す
		$include_path = S_DIRE . '/' . $path . '.php';
		// var_dump( $include_path);
		if ( ! file_exists( $include_path ) ) {

			// 小テーマにファイルがなければ 親テーマから探す
			$include_path = T_DIRE . '/' . $path . '.php';
			if ( ! file_exists( $include_path ) ) {

				// 親テーマにもファイルが無ければ
				if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
					echo esc_html( sprintf( __( '読み込みエラー！ : ', 'swell' ), esc_html( $path ) ) );
				}
				return;

			}
		}

		if ( $cache_key !== '' && is_customize_preview() ) {
			// キャッシュキーありだけどカスタマイザーで表示中はキャッシュ削除
			delete_transient( 'swell_' . $cache_key ); // ~ 2.0.2を考慮
			delete_transient( 'swell_parts_' . $cache_key );

		} elseif ( $cache_key !== '' ) {
			// キャッシュキーの指定があれば、キャッシュを読み込む

			$data = get_transient( 'swell_parts_' . $cache_key ); // キャッシュの取得
			if ( empty( $data ) ) {

				ob_start();
				include $include_path;
				$data = ob_get_clean();
				$data = self::minify_html_code( $data );

				// キャッシュ保存期間
				$expiration = $expiration ?: 30 * DAY_IN_SECONDS;

				// キャッシュデータの生成
				set_transient( 'swell_parts_' . $cache_key, $data, $expiration );
			}

			// キャッシュデータを出力して return
			echo $data; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			return;

		}

		// 普通に読み込み
		include $include_path;
	}


	/*
	 * ブログパーツの出力処理
	 */
	public static function do_blog_parts( $content ) {
		// do_shortcode > do_blocks の順番を逆にすると　パーツ内の再利用ブロック内のショートコードが展開されないので注意
		$content = do_shortcode( do_blocks( $content ) );

		if ( 'the_content' !== current_filter() ) {
			// lodaing属性の追加処理を通す
			$content = wp_filter_content_tags( $content );
		}
		return apply_filters( 'swell_do_blog_parts', $content );
	}


	/**
	 * キャッシュ機能付きのサイドバー呼び出し
	 */
	public static function outuput_widgets( $key, $args = [] ) {

		// 出力中のエリア
		self::$widget_area_in_output = $key;

		$is_active = $args['active'] ?? is_active_sidebar( $key );
		if ( ! $is_active ) {
			return '';
		}

		$before  = $args['before'] ?? '';
		$after   = $args['after'] ?? '';
		$is_echo = $args['echo'] ?? true;

		// キャッシュ取得
		$html = wp_cache_get( "widget_{$key}", 'swell' );
		if ( ! $html ) {
			ob_start();
			dynamic_sidebar( $key );
			$html = ob_get_clean();

			// dynamic_sidebarの出力をキャッシュ
			wp_cache_set( "widget_{$key}", $html, 'swell' );
		}

		// 前後にHTMLあれば付ける
		$html = $before . $html . $after;

		// リセット
		self::$widget_area_in_output = '';

		if ( ! $is_echo ) {
			return $html;
		}
		echo $html; // phpcs:ignore
	}


	/**
	 * コンテンツ上下のウィジェット
	 */
	public static function outuput_content_widget( $type, $position ) {

		// 3.0: show_ → hide_ に修正。
		$is_hide = '1' === get_post_meta( get_queried_object_id(), "swell_meta_show_widget_{$position}", true );
		if ( $is_hide ) return;

		$classname = 'w-' . $type . ucfirst( $position );
		\SWELL_Theme::outuput_widgets( "{$type}_{$position}", [
			'before' => '<div class="' . esc_attr( $classname ) . '">',
			'after'  => '</div>',
		] );
	}


	/**
	 * CTAエリア
	 */
	public static function outuput_cta() {
		$the_id    = get_the_ID();
		$hide_meta = get_post_meta( $the_id, 'swell_meta_hide_widget_cta', true );
		if ( '1' === $hide_meta ) return;

		// カテゴリー用のCTAがあるかどうか
		$cta_id     = 0;
		$categories = get_the_category( $the_id ) ?: [];
		foreach ( $categories as $the_cat ) :
			$cta_id = get_term_meta( $the_cat->term_id, 'swell_term_meta_cta_parts', 1 );
			if ( $cta_id ) break; // CTAが取得できればループ終了。(先に取得できるカテゴリーを優先)
		endforeach;

		if ( $cta_id ) {
			echo '<div class="w-cta">' . do_shortcode( '[blog_parts id=' . $cta_id . ']' ) . '</div>';
			return;
		}

		\SWELL_Theme::outuput_widgets( 'single_cta', [
			'before' => '<div class="w-cta">',
			'after'  => '</div>',
		] );
	}

}
