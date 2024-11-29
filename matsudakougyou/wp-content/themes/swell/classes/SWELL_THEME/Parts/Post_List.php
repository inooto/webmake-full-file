<?php
namespace SWELL_THEME\Parts;

if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * 投稿リスト生成用クラス
 * ・通常の呼び出し
 * ・ブロック|ショートコードからの呼び出し
 * ・ウィジェットからの呼び出し
 */
class Post_List {

	private function __construct() {}

	/**
	 * 投稿リスト生成に必要な設定を取得する
	 */
	public static function set_list_args( $args = [] ) {

		$SETTING  = \SWELL_Theme::get_setting();
		$defaults = [
			'type'           => \SWELL_Theme::$list_type,
			'max_col'        => $SETTING['max_column'],
			'max_col_sp'     => $SETTING['max_column_sp'],
			'ul_add_class'   => '',
			'show_infeed'    => true,
			'cat_pos'        => $SETTING['category_pos'],
			'show_title'     => ! $SETTING['hide_post_ttl'],
			'show_date'      => $SETTING['show_list_date'],
			'show_modified'  => $SETTING['show_list_mod'],
			'show_author'    => $SETTING['show_list_author'],
			'show_pv'        => '',
			'excerpt_length' => \SWELL_Theme::$excerpt_length,
			'h_tag'          => 'h2',
			// 'show_pager'     => false,
		];
		$return = array_merge( $defaults, $args );

		// キャスト -> マージした後に明示的に変換しておく。
		$return['show_title']    = (bool) $return['show_title'];
		$return['show_date']     = (bool) $return['show_date'];
		$return['show_modified'] = (bool) $return['show_modified'];
		$return['show_author']   = (bool) $return['show_author'];

		// リストタイプによる強制セット
		if ( 'thumb' === $return['type'] ) {

			$return['excerpt_length'] = 0; // サムネイル型では抜粋文非表示

		} else {

			$return['show_title'] = true; // サムネイル型以外ではタイトルは必ず表示させる

		}
		return $return;
	}


	/**
	 * 投稿リストにセットするクラスを生成
	 */
	public static function get_list_class( $list_type = '', $max_col = '', $max_col_sp = '' ) {

		$class = 'p-postList';

		switch ( $list_type ) {
			case 'card':
			case 'thumb':
				$class .= ' -type-' . $list_type . ' -pc-col' . $max_col . ' -sp-col' . $max_col_sp;
				break;
			case 'big':
			case 'big2':
				$class .= ' -type-big';
				break;
			default:
				$class .= ' -type-' . $list_type;
				break;
		}
		return $class;
	}


	/**
	 * 読み込むテンプレートファイル名を取得
	 */
	public static function get_parts_name( $list_type = '' ) {

		switch ( $list_type ) {
			case 'big':
			case 'big2':
				$parts_name = 'style_big';
				break;
			case 'simple':
				$parts_name = 'style_simple';
				break;
			default:
				$parts_name = 'style_normal';
				break;
		}
		return $parts_name;
	}


	/**
	 * サムネイルサイズを決める
	 */
	public static function get_thumb_sizes( $list_type, $max_col, $max_col_sp ) {

		switch ( $list_type ) {
			case 'card':
			case 'thumb':
				$pc_size = ( '1' === $max_col ) ? '960px' : '400px';
				$sp_size = ( '1' === $max_col_sp ) ? '100vw' : '50vw';
				$size    = '(min-width: 960px) ' . $pc_size . ', ' . $sp_size;
				break;
			case 'list':
			case 'list2':
				$size = '(min-width: 960px) 400px, 36vw';
				break;
			default:
				$size = '(min-width: 960px) 960px, 100vw';
				break;
		}
		return $size;
	}


	/**
	 * 投稿リスト用の設定値を取得して返す
	 * ・liループに渡す情報
	 * ・ulへ追加するクラス
	 * ・読み込むパーツ名
	 * ・インフィード間隔
	 */
	public static function get_list_data( $args = [] ) {

		// デフォルト値とマージ
		$args = self::set_list_args( $args );

		// リストタイプを取得
		$list_type = $args['type'];

		// ulタグに付与するクラス
		$ul_class = self::get_list_class( $list_type, $args['max_col'], $args['max_col_sp'] );
		if ( $args['ul_add_class'] ) {
			$ul_class .= ' ' . trim( $args['ul_add_class'] );
		}

		// サムネイルサイズを取得
		$thumb_sizes = self::get_thumb_sizes( $list_type, $args['max_col'], $args['max_col_sp'] );

		// 読み込むテンプレートファイル名を取得
		$parts_name = self::get_parts_name( $list_type );

		// インフィード広告の間隔
		$infeed_interval = $args['show_infeed'] ? (int) \SWELL_Theme::get_setting( 'infeed_interval' ) : 0;

		// liループに渡す情報を絞る
		$li_args = [
			'list_type'      => $list_type,
			'thumb_sizes'    => $thumb_sizes,
			'cat_pos'        => $args['cat_pos'],
			'show_title'     => $args['show_title'],
			'show_date'      => $args['show_date'],
			'show_modified'  => $args['show_modified'],
			'show_author'    => $args['show_author'],
			'show_pv'        => $args['show_pv'],
			'excerpt_length' => $args['excerpt_length'],
			'h_tag'          => $args['h_tag'],
		];

		return [
			'ul_class'        => $ul_class,
			'li_args'         => $li_args,
			'parts_name'      => $parts_name,
			'infeed_interval' => $infeed_interval,
		];
	}

	/**
	 * ウィジェット用の設定値を取得して返す
	 */
	public static function get_widget_list_data( $args = [] ) {
		$defaults = [
			'widget_type' => '',
			'list_type'   => '',
			'show_date'   => false,
			'show_cat'    => false,
			'show_views'  => false,
			'show_big'    => false,
		];
		$args     = array_merge( $defaults, $args );

		// partsへ渡す情報
		$li_args = [
			'show_date'  => $args['show_date'],
			'show_cat'   => $args['show_cat'],
			'show_views' => $args['show_views'],
		];

		// ulに付与するクラス
		$ul_class  = ( 'list_style' === $args['list_type'] ) ? '-type-list' : '-type-card';
		$ul_class .= ' -w-' . $args['widget_type'];
		if ( $args['show_big'] ) {
			$ul_class .= ' is-first-big';
		}

		return [
			'ul_class'        => $ul_class,
			'li_args'         => $li_args,
		];
	}


	/**
	 * 投稿リスト（ショートコード & ブロックからの呼び出し）
	 * WP_Query用の args と、リスト用の args が入り混じって渡ってくる。
	 */
	public static function list_on_block( $block_args = [] ) {

		if ( ! is_array( $block_args ) ) $block_args = [];

		$defaults = [
			'post_type'           => 'post',
			'type'                => 'simple',
			'count'               => 5,
			'ignore_sticky'       => true,
			'order'               => 'DESC',
			'orderby'             => 'date',
			'post_id'             => '',
			'cat_id'              => 0,
			'tag_id'              => 0,
			'term_id'             => 0,
			'taxonomy'            => '',
			'max_col'             => '',
			'max_col_sp'          => '',
			'more'                => '',
			'more_url'            => '',
			'exc_id'              => '',
			'exc_cat'             => '',
			'exc_tag'             => '',
			'inc_children'        => true,
			'cat_relation'        => 'IN',
			'tag_relation'        => 'IN',
			'term_relation'       => 'IN',
			'query_relation'      => 'AND',
			'query_relation'      => 'AND',
			'author_id'           => 0,
			// 'h_tag'         => 'h2'
		];
		$block_args = array_merge( $defaults, $block_args );

		$more_url  = $block_args['more_url'];
		$more_text = $block_args['more'];

		$count         = (int) $block_args['count'];
		$ignore_sticky = $block_args['ignore_sticky'];

		// if ( ! $ignore_sticky ) {
		// 	$sticky       = get_option( 'sticky_posts' ) ?: 0;
		// 	$sticky_count = count( $sticky );
		// 	$count        = $count - $sticky_count;
		// }

		$q_args = [
			'post_type'           => $block_args['post_type'],
			'posts_per_page'      => $count,
			'post_status'         => 'publish',
			'no_found_rows'       => true,
			'ignore_sticky_posts' => $ignore_sticky, // true,
			'order'               => $block_args['order'],
		];

		// 投稿IDで指定されていればそれを優先
		$post_id = $block_args['post_id'];
		if ( $post_id ) {

			$post_array         = array_map( 'intval', explode( ',', $post_id ) );
			$q_args['post__in'] = $post_array;
			$q_args['orderby']  = 'post__in';

		} else {

			// 並び順
			$orderby = $block_args['orderby'];
			if ( 'pv' === $orderby ) {
				$q_args['meta_key'] = SWELL_CT_KEY;
				$q_args['orderby']  = 'meta_value_num';
			} elseif ( 'rand' === $orderby ) {
				$q_args['orderby'] = 'rand';
			} else {
				$q_args['orderby'] = $orderby;
			}

			$tax_query = [];

			// カテゴリーの指定
			$cat_id = $block_args['cat_id'];
			if ( $cat_id ) {
				// arrayにしてint化
				$cat_array = array_map( 'intval', explode( ',', $cat_id ) );

				// tax_query追加
				$tax_query[] = [
					'taxonomy'         => 'category',
					'field'            => 'id',
					'terms'            => $cat_array,
					'operator'         => $block_args['cat_relation'],
					'include_children' => $block_args['inc_children'],
				];

				$more_url = $more_url ?: get_category_link( $cat_array[0] ); // moreURLなければ自動取得
			}

			// タグの指定
			$tag_id = $block_args['tag_id'];
			if ( $tag_id ) {
				// arrayにしてint化
				$tag_array = array_map( 'intval', explode( ',', $tag_id ) );

				// tax_query追加
				$tax_query[] = [
					'taxonomy'         => 'post_tag',
					'field'            => 'id',
					'terms'            => $tag_array,
					'operator'         => $block_args['tag_relation'],
					'include_children' => false,
				];

				$more_url = $more_url ?: get_tag_link( $tag_array[0] ); // moreURLなければ自動取得
			}

			// タクソノミーの指定
			$taxonomy = $block_args['taxonomy'];
			$term_id  = $block_args['term_id'];
			if ( $taxonomy && $term_id ) {
				// arrayにしてint化
				$term_array = array_map( 'intval', explode( ',', $term_id ) );

				// tax_query追加
				$tax_query[] = [
					'taxonomy' => $taxonomy,
					'field'    => 'id',
					'terms'    => $term_array,
					'operator' => $block_args['term_relation'],
				];

				$more_url = $more_url ?: get_term_link( $term_array[0], $taxonomy ); // moreURLなければ自動取得
			}

			// tax_queryあれば追加
			if ( ! empty( $tax_query ) ) {
				$tax_query['relation'] = $block_args['query_relation'];
				$q_args['tax_query']   = $tax_query;
			}
		}

		// 除外ID
		$exc_id = $block_args['exc_id'];
		if ( $exc_id ) {
			$q_args['post__not_in'] = array_map( 'intval', explode( ',', $exc_id ) );
		}

		// 著者での絞り込み
		$author_id = $block_args['author_id'];
		if ( $author_id ) {
			$q_args['author'] = $author_id;
		}

		// 投稿リストブロックにはインフィード広告を出さない。
		$block_args['show_infeed'] = false;

		// 最後の要素を非表示にするかどうか
		$ul_add_class = '';
		if ( isset( $block_args['sp_hide_last'] ) ) $ul_add_class .= ' is-hide-last--sp';
		if ( isset( $block_args['pc_hide_last'] ) ) $ul_add_class .= ' is-hide-last--pc';

		$block_args['ul_add_class'] = $ul_add_class;

		// WP_Query
		\SWELL_Theme::get_parts( 'parts/post_list/loop_sub', [
			'query_args' => $q_args,
			'list_args'  => $block_args,
		] );

		// MOREボタン (テキストがあれば表示)
		if ( '' !== $more_text ) {

			if ( '' === $more_url ) {
				// more_urlがまだ空なら : 「投稿ページ」のURLを取得 > home_url( '/' )
				$more_url = get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/' );
			} elseif ( strpos( $more_url, '://' ) === false ) {
				$more_url = home_url( '/' ) . $more_url;  // 相対URLの時
			}

			echo '<div class="is-style-more_btn">' .
				'<a href="' . esc_url( $more_url ) . '" class="btn_text">' . esc_html( $more_text ) . '</a>' .
			'</div>';
		}
	}


	/**
	 * カテゴリー情報を返す
	 * 3.0で削除
	 */
	public static function cat_data( $post_id ) {

		$cat_data = get_the_category( $post_id );

		if ( empty( $cat_data ) ) {
			$return = [];
		} else {
			$return = [
				'id'   => $cat_data[0]->term_id,
				'name' => $cat_data[0]->name,
			];
		}

		return apply_filters( 'swell_post_list_cat_data', $return, $post_id );
	}
}
