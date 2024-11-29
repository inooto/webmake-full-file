<?php
namespace SWELL_Theme\Block\Rss;

defined( 'ABSPATH' ) || exit;

/**
 * RSSブロック
 */
\SWELL_Theme::register_block( 'rss', [
	'render_callback' => __NAMESPACE__ . '\cb',
] );

function cb( $attrs, $content ) {

	$rss_url       = $attrs['rssUrl'];
	$use_cache     = $attrs['useCache'];
	$list_count_pc = $attrs['listCountPC'];
	$list_count_sp = $attrs['listCountSP'];

	if ( ! $rss_url ) {
		return '<p>' . __( 'RSSフィードのURLを入力してください。', 'swell' ) . '</p>';
	}

	$chache_key = 'swell_rss_' . md5( $rss_url );

	$rss_data = null;
	if ( $use_cache ) {
		$rss_data = get_transient( $chache_key );
	} else {
		delete_transient( $chache_key );
	}

	if ( empty( $rss_data ) ) {
		// 取得可能な最大件数の10件を予め取得してキャッシュしておく。
		$rss_data = get_rss( $attrs['rssUrl'] );

		$chache_time = apply_filters( 'swell_blocks_rss_cache_time', 1 * DAY_IN_SECONDS, $rss_url );
		if ( $use_cache ) set_transient( $chache_key, $rss_data, $chache_time );
	}

	if ( isset( $rss_data['error'] ) ) {
		return '<p>' . $rss_data['message'] . '</p>';
	}

	if ( ! isset( $rss_data['items'] ) ) {
		return '<p>' . __( 'RSSフィードが見つかりませんでした。', 'swell' ) . '</p>';
	}

	// リスト表示用データ
	$list_args = [
		'list_type'      => $attrs['listType'],
		'show_site'      => $attrs['showSite'],
		'show_date'      => $attrs['showDate'],
		'show_author'    => $attrs['showAuthor'],
		'show_thumb'     => $attrs['showThumb'],
		'pc_col'         => $attrs['pcCol'],
		'sp_col'         => $attrs['spCol'],
		'h_tag'          => $attrs['hTag'],
		'list_count_pc'  => $list_count_pc,
		'list_count_sp'  => $list_count_sp,
		'site_title'     => $attrs['pageName'] ?: $rss_data['title'],
		'favicon'        => $rss_data['favicon'],
	];

	// リストを囲むクラス名
	$list_wrapper_class = 'swell-block-rss';
	if ( $attrs['className'] ) {
		$list_wrapper_class .= ' ' . $attrs['className'];
	}

	ob_start();
	echo '<div class="' . esc_attr( $list_wrapper_class ) . '">';

	// 投稿リスト
	\SWELL_Theme::get_parts( 'parts/post_list/rss', [
		'rss_items' => $rss_data['items'],
		'list_args' => $list_args,
	] );

	echo '</div>';
	return ob_get_clean();
}


/**
 * RSS取得
 */
function get_rss( $rss_url = '' ) {

	// RSS取得
	$rss = fetch_feed( $rss_url );

	if ( is_wp_error( $rss ) ) {
		return [
			'error'   => 1,
			'message' => __( 'RSSフィードのURLが正しくありません。', 'swell' ),
		];
	}

	$maxitems = 0;

	// すべてのフィードから最新10件を出力します。
	$maxitems = $rss->get_item_quantity( 10 );

	// 0件から始めて指定した件数までの配列を生成します。
	$rss_items = $rss->get_items( 0, $maxitems );

	if ( 0 === $maxitems ) {
		return [
			'error'   => 1,
			'message' => __( 'フィードに記事が見つかりませんでした。', 'swell' ),
		];
	}

	$rss_item_data = [];
	foreach ( $rss_items as $item ) {

		$item_link = $item->get_permalink(); // $item->get_link() も同じ？

		// サムネイル
		$thumbnail = '';

		// まずはget_thumbnail() で取得
		$thumbnail = $item->get_thumbnail() ?: '';

		// 次に enclosure から取得
		if ( '' === $thumbnail ) {
			$enclosure = $item->get_enclosure();
			if ( $enclosure && is_array( $enclosure->thumbnails ) ) {
				$thumbnail = $enclosure->thumbnails[0];
			}
		}

		// それでもなければ、最初に出現するimgを取得する
		if ( preg_match( '/<img.+?src=[\'"]([^\'"]+?)[\'"].*?>/msi', $item->get_content(), $matches ) ) {
			$thumbnail = $matches[1];
		}

		// さらにそれでもなければ、OGP読みにいく
		if ( '' === $thumbnail ) {
			$thumbnail = get_remote_thumb( $item_link );
		}

		// 著者名
		$author = '';
		if ( is_object( $item->get_author() ) ) {
			$author = wp_strip_all_tags( $item->get_author()->get_name() );
		}

		$rss_item_data[] = [
			'title'     => $item->get_title(),
			'link'      => $item->get_permalink(),
			'date'      => $item->get_date( get_option( 'date_format' ) ),
			'author'    => $author,
			'thumbnail' => $thumbnail,
		];

	}

	return [
		'title'   => $rss->get_title() ?: '',
		'favicon' => $rss->get_image_url() ?: '',
		'items'   => $rss_item_data,
	];
}

/**
 * RSS記事のサムネイル取得
 */
function get_remote_thumb( $url = '' ) {
	$response = wp_remote_get( $url );

	if ( is_wp_error( $response ) ) return '';

	$response_code = wp_remote_retrieve_response_code( $response );
	if ( $response_code !== 200 ) return '';

	$body = wp_remote_retrieve_body( $response );

	// og:image から探す
	$pattern = '/<meta\s+property=["\']og:image["\'][^\/>]*?content=["\']([^"\']+?)["\'].*?>/is';
	if ( preg_match( $pattern, $body, $matches ) ) {
		if ( isset( $matches[1] ) ) {
			return $matches[1];
		}
	}

	// なければ twitter:image
	$pattern = '/<meta\s+name=["\']twitter:image["\'][^\/>]*?content=["\']([^"\']+?)["\'].*?>/is';
	if ( preg_match( $pattern, $body, $matches ) ) {
		if ( isset( $matches[1] ) ) {
			return $matches[1];
		}
	}

	return '';
}
