<?php
namespace SWELL_Theme\Utility;

if ( ! defined( 'ABSPATH' ) ) exit;
use \SWELL_Theme as SWELL;

trait Others {


	/**
	 * ブロックの登録
	 * $block_name:プレフィックスなしのブロック名 ( 'accordion', 'tab', ... )
	 */
	public static function register_block( $block_name, $args = [] ) {

		// 配列のデフォルト値とマージさせる
		$args = array_merge( [
			'render_callback'   => '',
		], $args );

		$block_dir = SWELL::get_block_path( '', $block_name );
		$handle    = 'swell/' . $block_name;

		// ブロックJSの登録
		$asset = include T_DIRE . $block_dir . '/index.asset.php';
		wp_register_script( $handle, T_DIRE_URI . "{$block_dir}/index.js", array_merge( $asset['dependencies'], [ 'swell_blocks' ] ), $asset['version'], true );

		// 登録データ
		$block_data = [
			'editor_script'   => $handle,
			'render_callback' => $args['render_callback'],
		];

		// エディター用スタイル
		if ( file_exists( T_DIRE . "{$block_dir}/index.css" ) ) {
			wp_register_style( "{$handle}--editor", T_DIRE_URI . "{$block_dir}/index.css", [], SWELL_VERSION );
			$block_data['editor_style'] = "{$handle}--editor";
		};

		// // ブロックスタイルを個別読み込み
		// if ( SWELL::is_separate_css() ) {
		// 	if ( file_exists( T_DIRE . "{$block_dir}/style-index.css" ) ) {
		// 		$deps = [ 'main_style' ]; // フロントだけで読ませたい → エディタ側 は modlue/content のCSSなどもあるので blocks.css で一括読み込み
		// 		wp_register_style( $handle, T_DIRE_URI . "{$block_dir}/style-index.css", $deps, SWELL_VERSION );
		// 		$block_data['style'] = $handle;
		// 	};
		// }

		// ブロック登録
		register_block_type_from_metadata( SWELL::get_block_path( T_DIRE, $block_name ), $block_data );
	}


	/**
	 * wp_nonce_fieldを設置する
	 */
	public static function set_nonce_field( $key = '' ) {
		wp_nonce_field( self::$nonce['action'] . $key, self::$nonce['name'] . $key );
	}


	/**
	 * NONCE チェック
	 */
	public static function check_nonce( $key = '' ) {

		$nonce_name   = self::$nonce['name'] . $key;
		$nonce_action = self::$nonce['action'] . $key;

		if ( ! isset( $_POST[ $nonce_name ] ) ) {
			return false;
		}

		return wp_verify_nonce( $_POST[ $nonce_name ], $nonce_action );
	}


	/**
	 * 編集権限のチェック
	 */
	public static function check_user_can_edit( $post_id ) {

		// 現在のユーザーに投稿の編集権限があるかのチェック （投稿 : 'edit_post' / 固定ページ & LP : 'edit_page')
		$check_can = ( isset( $_POST['post_type'] ) && 'post' === $_POST['post_type'] ) ? 'edit_post' : 'edit_page';
		if ( ! current_user_can( $check_can, $post_id ) ) {
			return false;
		}

		return true;
	}


	/**
	 * カラーコードをrgbaに変換
	 * $brightness : -1 ~ 1
	 */
	public static function get_rgba( $color_code, $alpha = 1, $brightness = 0 ) {

		$color_code = str_replace( '#', '', $color_code );

		$rgba_code          = [];
		$rgba_code['red']   = hexdec( substr( $color_code, 0, 2 ) );
		$rgba_code['green'] = hexdec( substr( $color_code, 2, 2 ) );
		$rgba_code['blue']  = hexdec( substr( $color_code, 4, 2 ) );

		if ( 0 !== $brightness ) {
			foreach ( $rgba_code as $key => $val ) {
				$val               = (int) $val;
				$result            = $val + ( $val * $brightness );
				$rgba_code[ $key ] = max( 0, min( 255, round( $result ) ) );
			}
		}

		$rgba_code['alpha'] = $alpha;

		return 'rgba(' . implode( ', ', $rgba_code ) . ' )';
	}


	/**
	 * HTMLソースのminify化
	 */
	public static function minify_html_code( $src ) {
		$search  = [
			'/\>[^\S ]+/s',  // strip whitespaces after tags, except space
			'/[^\S ]+\</s',  // strip whitespaces before tags, except space
			'/(\s)+/s',       // shorten multiple whitespace sequences
			'/<!--[\s\S]*?-->/s', // コメントを削除
		];
		$replace = [
			'>',
			'<',
			'\\1',
			'',
		];
		return preg_replace( $search, $replace, $src );
	}


	/**
	 * ファイル読み込み
	 */
	public static function get_file_contents( $file ) {
		if ( file_exists( $file ) ) {
			$file_content = file_get_contents( $file );
			return $file_content;
		}
		return '';
	}


	/**
	 * CSS読み込み
	 */
	public static function get_css_from_file( $path, $replace_path = '' ) {
		$css = SWELL::get_file_contents( $path );

		// @charset は消す
		$css = str_replace( '@charset "UTF-8";', '', $css );

		// 相対パスを /assets/ までの絶対パスへ置換
		if ( $replace_path ) {
			$css = str_replace( $replace_path, T_DIRE_URI . '/assets/', $css );
		}

		return $css;
	}


	/**
	 * 空エンキュー
	 */
	public static function enqueue_empty_script( $handle_name ) {
		wp_register_script( $handle_name, false ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters
		wp_enqueue_script( $handle_name );
	}
	public static function enqueue_empty_style( $handle_name ) {
		wp_register_style( $handle_name, false ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters
		wp_enqueue_style( $handle_name );
	}


	/**
	 * 画像にlazyloadを適用
	 */
	public static function set_lazyload( $image, $lazy_type, $placeholder = '' ) {

		if ( $lazy_type === 'eager' ) {

			$image = str_replace( ' src="', ' loading="eager" src="', $image );

		} elseif ( $lazy_type === 'lazy' || self::is_rest() || self::is_iframe() ) {

			$image = str_replace( ' src="', ' loading="lazy" src="', $image );

		} elseif ( $lazy_type === 'lazysizes' ) {

			$noscript = '<noscript>' . $image . '</noscript>';

			$placeholder = $placeholder ?: self::$placeholder;
			$image       = str_replace( ' src="', ' src="' . esc_url( $placeholder, ['http', 'https', 'data' ] ) . '" data-src="', $image );
			$image       = str_replace( ' srcset="', ' data-srcset="', $image );
			$image       = str_replace( ' class="', ' class="lazyload ', $image );

			$image = preg_replace_callback( '/<img([^>]*)>/', function( $matches ) {
				$props = rtrim( $matches[1], '/' );
				$props = self::set_aspectratio( $props );
				return '<img' . $props . '>';
			}, $image );

			$image .= $noscript;
		}

		return $image;
	}


	/**
	 * width,height から aspectratio を指定
	 */
	public static function set_aspectratio( $props, $src = '' ) {

		// width , height指定を取得
		preg_match( '/\swidth=["\']([0-9]*)["\']/', $props, $width_matches );
		preg_match( '/\sheight=["\']([0-9]*)["\']/', $props, $height_matches );
		$width  = ( $width_matches ) ? $width_matches[1] : '';
		$height = ( $height_matches ) ? $height_matches[1] : '';

		if ( $width && $height ) {
			// widthもheightもある時
			$props .= ' data-aspectratio="' . $width . '/' . $height . '"';
		} elseif ( $width ) {
			// widthしかない時
			$img_size = self::get_file_size( $src );
			if ( $img_size ) {
				$props .= ' data-aspectratio="' . $img_size['width'] . '/' . $img_size['height'] . '"';
			}
		} else {
			// widthすら指定されていない時
			$img_size = self::get_file_size( $src );
			if ( $img_size ) {
				$props .= ' width="' . $img_size['width'] . '" data-aspectratio="' . $img_size['width'] . '/' . $img_size['height'] . '"';
			}
		}
		return $props;
	}


	/**
	 * ヘッダーメニューが空の時のデフォルト呼び出し関数
	 */
	public static function default_head_menu() {
		$args      = [
			'post_type'      => 'page',
			'no_found_rows'  => true,
			'posts_per_page' => 5,
		];
		$the_query = new \WP_Query( $args );
		if ( $the_query->have_posts() ) :
			while ( $the_query->have_posts() ) :
				$the_query->the_post();
			?>
				<li class="menu-item">
					<a href="<?=esc_url( get_permalink() )?>">
						<span class="ttl"><?php the_title(); ?></span>
					</a>
				</li>
			<?php
			endwhile;
		endif;
		wp_reset_postdata();
	}


	/**
	 * 記事のビュー数を更新させる
	 */
	public static function set_post_views( $post_id ) {
		if ( ! $post_id ) return;

		$count = (int) self::get_post_views( $post_id );
		++$count;
		update_post_meta( $post_id, SWELL_CT_KEY, $count );
	}


	/**
	 * 記事のビュー数を取得
	 */
	public static function get_post_views( $post_id ) {
		return get_post_meta( $post_id, SWELL_CT_KEY, true ) ?: '0';
	}


	/**
	 * キャッシュクリア
	 */
	public static function clear_cache( $cache_keys = [] ) {

		// キーの指定がなければ全キャッシュキーを取得
		if ( $cache_keys === [] ) {
			foreach ( self::$cache_keys as $keys ) {
				$cache_keys = array_merge( $cache_keys, $keys );
			}
		}
		foreach ( $cache_keys as $key ) {
			delete_transient( 'swell_parts_' . $key );
		}
	}


	/**
	 * DBクエリ回してパーツキャッシュをクリア
	 */
	public static function clear_all_parts_cache_by_wpdb() {
		global $wpdb;
		$option_table = $wpdb->prefix . 'options';
		// @codingStandardsIgnoreStart
		$wpdb->query(
			"DELETE FROM $option_table WHERE (`option_name` LIKE '%_transient_swell_parts_%') OR (`option_name` LIKE '%_transient_timeout_swell_parts_%')"
		);
		// @codingStandardsIgnoreEnd
	}


	/**
	 * ブログカードのキャッシュクリア
	 */
	public static function clear_card_cache() {
		global $wpdb;
		$option_table = $wpdb->prefix . 'options';
		// @codingStandardsIgnoreStart
		$wpdb->query(
			"DELETE FROM $option_table WHERE (`option_name` LIKE '%_transient_swell_card_%') OR (`option_name` LIKE '%_transient_timeout_swell_card_%')"
		);
		// @codingStandardsIgnoreEnd
	}


	/**
	 * 文字列を配列へ
	 */
	public static function str_to_array( $str, $key = ',' ) {
		$array = array_filter( array_map( 'trim', explode( $key, $str ) ) );
		return array_values( $array );
	}


	/**
	 * アップデートjsonパス取得
	 */
	public static function get_update_json_path() {
		$dir_path = 'ok' === self::$licence_status ? self::$update_dir_path : 'https://loos.co.jp/products/swell/';
		return $dir_path . apply_filters( 'swell_update_json_name', 'update.json' );
	}


	/**
	 * post meta 保存処理
	 */
	public static function save_post_metas( $post_id, $metas ) {

		// 自動保存時には保存しないように
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

		// 権限確認
		// if ( ! self::check_user_can_edit( $post_id ) ) return;

		if ( ! is_array( $metas ) ) return;

		foreach ( $metas as $key => $type ) {

			$meta_val = $_POST[ $key ] ?? '';

			// error_log( "$key start : $meta_val / $type" . PHP_EOL, 3, ABSPATH . 'my.log' );

			// 保存したい情報が渡ってきていれば更新作業に入る
			if ( ! $key || ! isset( $_POST[ $key ] ) ) continue;

			$is_null = false;

			// サニタイズとnullチェック
			if ( 'check' === $type ) {
				$meta_val = sanitize_text_field( $meta_val );
				$is_null  = '0' === $meta_val;
			} elseif ( 'html' === $type ) {
				$meta_val = wp_kses_post( $meta_val );
				$is_null  = '' === $meta_val;
			} elseif ( 'url' === $type ) {
				$meta_val = esc_url_raw( $meta_val );
				$is_null  = '' === $meta_val;
			} elseif ( 'code' === $type ) {
				// $meta_val = $meta_val;
				$is_null = '' === $meta_val;
			} else {
				$meta_val = sanitize_text_field( $meta_val );
				$is_null  = '' === $meta_val;
			}

			// error_log( " $key / $meta_val / $is_null" . PHP_EOL, 3, ABSPATH . 'my.log' );

			if ( $is_null ) {
				delete_post_meta( $post_id, $key );
			} else {
				update_post_meta( $post_id, $key, $meta_val );
			}
		}
	}


	/**
	 * term meta 保存処理
	 */
	public static function save_term_metas( $term_id, $metas ) {

		// 自動保存時には保存しないように
		// if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

		if ( ! is_array( $metas ) ) return;

		foreach ( $metas as $key => $type ) {

			$meta_val = $_POST[ $key ] ?? '';

			// error_log( "$key start : $meta_val / $type" . PHP_EOL, 3, ABSPATH . 'my.log' );

			// 保存したい情報が渡ってきていれば更新作業に入る
			if ( ! $key || ! isset( $_POST[ $key ] ) ) continue;

			$is_null = false;

			// サニタイズとnullチェック
			if ( 'check' === $type ) {
				$meta_val = sanitize_text_field( $meta_val );
				$is_null  = '0' === $meta_val;
			} elseif ( 'html' === $type ) {
				$meta_val = wp_kses_post( $meta_val );
				$is_null  = '' === $meta_val;
			} elseif ( 'switch' === $type ) {
				$meta_val = sanitize_text_field( $meta_val );
				$is_null  = '' === $meta_val;
			} else {
				$meta_val = sanitize_text_field( $meta_val );
				$is_null  = '' === $meta_val;
			}

			// error_log( " $key / $meta_val / $is_null" . PHP_EOL, 3, ABSPATH . 'my.log' );

			if ( $is_null ) {
				delete_term_meta( $term_id, $key );
			} else {
				update_term_meta( $term_id, $key, $meta_val );
			}
		}
	}


	/**
	 * 不要な post meta を削除
	 */
	public static function clean_post_metas() {
		// 値が空文字として保存されている不要なカスタムフィールド
		$META_KEYS_NULL = [
			// サイドバーのカスタムフィールド
			'swell_meta_related_posts',
			'swell_meta_youtube',
			'swell_meta_thumb_caption',
			'swell_meta_ttlbg',
			'swell_meta_ttl_pos',
			'swell_meta_show_pickbnr',
			'swell_meta_show_sidebar',
			'swell_meta_show_index',
			'swell_meta_show_thumb',
			'swell_meta_show_related',
			'swell_meta_show_author',
			'swell_meta_show_comments',
			'swell_meta_subttl',

			// コードのカスタムフィールド
			'swell_meta_css',
			'swell_meta_js',

			// LP
			'lp_use_swell_header',
			'lp_use_swell_footer',
		];

		// 値が"0"として保存されている不要なカスタムフィールド
		$META_KEYS_ZERO = [
			// サイドバーのカスタムフィールド
			'swell_meta_show_widget_top',
			'swell_meta_show_widget_bottom',
			'swell_meta_hide_widget_cta',
			'swell_meta_hide_before_index',
			'swell_meta_hide_autoad',
			'swell_meta_hide_sharebtn',
			'swell_meta_no_mb',
		];

		// カスタムフィールドの削除
		global $wpdb;
		foreach ( $META_KEYS_NULL as $key ) {
			// @codingStandardsIgnoreStart
			$wpdb->delete( $wpdb->postmeta, [
				'meta_key'   => $key,
				'meta_value' => '',
			] );
			// @codingStandardsIgnoreEnd
		}
		foreach ( $META_KEYS_ZERO as $key ) {
			// @codingStandardsIgnoreStart
			$wpdb->delete( $wpdb->postmeta, [
				'meta_key'   => $key,
				'meta_value' => '0',
			] );
			// @codingStandardsIgnoreEnd
		}
	}


	/**
	 * 不要な term meta を削除
	 */
	public static function clean_term_metas( $ver_from = '' ) {

		if ( '2.5.7' === $ver_from ) {
			// 2.5.7で漏れていたもの
			$META_KEYS_NULL = [
				'swell_term_meta_newttl', // 旧バージョンでのデータ
				'swell_term_meta_rankttl', // 旧バージョンでのデータ
			];
			$META_KEYS_ZERO = [];
		} else {
			// 値が空文字として保存されている不要なカスタムフィールド
			$META_KEYS_NULL = [
				'swell_term_meta_ttl',
				'swell_term_meta_subttl',
				'swell_term_meta_list_type',
				'swell_term_meta_show_rank',
				'swell_term_meta_ttlpos',
				'swell_term_meta_show_sidebar',
				'swell_term_meta_show_nav',
				'swell_term_meta_image',
				'swell_term_meta_ttlbg',
				'swell_term_meta_show_thumb',
				'swell_term_meta_show_desc',
				'swell_term_meta_show_list',
				'swell_term_meta_display_parts',
				'swell_term_meta_cta_parts',
				'swell_term_meta_newttl', // 旧バージョンでのデータ
				'swell_term_meta_rankttl', // 旧バージョンでのデータ
			];

			// 値が"0"として保存されている不要なカスタムフィールド
			$META_KEYS_ZERO = [
				'swell_term_meta_hide_parts_paged',
			];

		}

		// カスタムフィールドの削除
		global $wpdb;
		foreach ( $META_KEYS_NULL as $key ) {
			// @codingStandardsIgnoreStart
			$wpdb->delete( $wpdb->termmeta, [
				'meta_key'   => $key,
				'meta_value' => '',
			] );
			// @codingStandardsIgnoreEnd
		}
		foreach ( $META_KEYS_ZERO as $key ) {
			// @codingStandardsIgnoreStart
			$wpdb->delete( $wpdb->termmeta, [
				'meta_key'   => $key,
				'meta_value' => '0',
			] );
			// @codingStandardsIgnoreEnd
		}
	}


	/**
	 * DB上のテーブルの存在チェック
	 */
	public static function check_table_exists( $table_name ) {
		$cache_key = 'table_' . $table_name . '_exists';

		// キャッシュ取得
		$cached_data = wp_cache_get( $cache_key, 'swell' );
		if ( $cached_data ) return $cached_data;

		global $wpdb;
		$sql     = "SHOW TABLES LIKE '{$table_name}'";
		$results = $wpdb->get_results( $sql );
		$return  = ! empty( $results );

		wp_cache_set( $cache_key, $return, 'swell' );
		return $return;
	}


	/**
	 * テーブルの全レコード取得
	 */
	public static function get_select_all_rows( $table_name, $orderby = '' ) {
		global $wpdb;
		if ( ! $orderby ) {
			$sql = "SELECT * FROM {$table_name}";
		} else {
			$sql = "SELECT * FROM {$table_name} ORDER BY {$orderby} DESC";
		}
		return $wpdb->get_results( $sql, ARRAY_A );
	}


	/**
	 * wp_nonce_fieldを設置する
	 */
	public static function get_palette_color( $color_slug ) {
		if ( ! $color_slug ) return '';

		$palette_data = get_theme_support( 'editor-color-palette' );
		if ( empty( $palette_data ) ) return '';

		$palette_data = $palette_data[0];
		if ( empty( $palette_data ) ) return '';

		$palette_slugs = array_column( $palette_data, 'slug' );

		$searched_index = array_search( $color_slug, $palette_slugs, true );
		if ( false === $searched_index ) return '';

		return $palette_data[ $searched_index ]['color'];
	}



	/**
	 * remote get
	 */
	public static function remote_get( $url, $options = [], $is_array = false ) {

		$default = [
			'sslverify'   => false,
			// 'headers'     => [ 'Content-Type: application/json' ],
			// 'body'        => [],
		];
		$options  = array_merge( $default, $options );
		$response = wp_remote_get( $url, $options );

		if ( is_wp_error( $response ) ) {
			return '';
			// return $response->get_error_code() . ' : ' . $response->get_error_message();
		}

		$response_code = wp_remote_retrieve_response_code( $response );
		if ( $response_code !== 200 ) return '';

		return json_decode( wp_remote_retrieve_body( $response ), $is_array );
	}

}
