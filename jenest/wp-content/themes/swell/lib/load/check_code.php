<?php
namespace SWELL_Theme\Load_Files;

if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * スクリプトが必要なショートコードがあるかどうか
 */
add_filter( 'do_shortcode_tag', function ( $output, $tag, $attr, $m ) {
	if ( 'ad_tag' === $tag ) {
		\SWELL_Theme::set_use( 'count_CTR', true );
	} elseif ( 'full_wide_content' === $tag ) {
		if ( isset( $args['bgimg'] ) ) {
			\SWELL_Theme::set_use( 'lazysizes', true );
		}
	}
	return $output;
}, 10, 4 );


/**
 * start付きのolタグがあるかどうか
 */
add_filter( 'render_block_core/list', __NAMESPACE__ . '\render_core_list', 10, 2 );
function render_core_list( $block_content, $block ) {
	$ordered = $block['attrs']['ordered'] ?? false;
	if ( $ordered || isset( $block['attrs']['start'] ) ) {
		\SWELL_Theme::set_use( 'ol_start', true );
		remove_filter( 'render_block_core/list', __NAMESPACE__ . '\render_core_list', 10 );
	}
	return $block_content;
}


/**
 * luminousが有効かどうか
 */
add_action('init', function () {

	// 投稿内の画像を自動的に有効にする場合
	if ( ! \SWELL_Theme::get_setting( 'remove_luminous' ) ) {
		add_filter( 'render_block_core/image', __NAMESPACE__ . '\check_luminous_from_block', 10, 2 );
		add_filter( 'render_block_core/gallery', __NAMESPACE__ . '\check_luminous_from_block', 10, 2 );
	}

	// 強制オンのクラスがあるかどうか探す。（ブロック使わなくてもオンにできるように html から判定）
	add_filter( 'the_content', __NAMESPACE__ . '\check_luminous_from_html' );
	add_filter( 'swell_do_blog_parts', __NAMESPACE__ . '\check_luminous_from_html' );
});


// ブロックでのチェック
// memo: サイトのLuminous機能がオンの時にのみ実行されるものなので、「off指定されていないものが1つでも存在する」時点で読み込みが必要なことをセットする。
function check_luminous_from_block( $block_content, $block ) {

	$classname = $block['attrs']['className'] ?? '';

	// .u-lb-off を持つ場合は true にセットせずスキップ
	if ( $classname && false !== strpos( $classname, 'u-lb-off' ) ) {
		return $block_content;
	}

	// .u-lb-off を持たない場合は true にセット。
	\SWELL_Theme::set_use( 'luminous', true );

	// 無駄なチェックを繰り返さないようにフィルター削除
	remove_filter( 'render_block_core/image', __NAMESPACE__ . '\check_luminous_from_block', 10 );
	remove_filter( 'render_block_core/gallery', __NAMESPACE__ . '\check_luminous_from_block', 10 );

	return $block_content;
}

// コンテンツのHTMLからチェック
function check_luminous_from_html( $content ) {

	// すでに有効の場合は何もしない（check_luminous_at_blockの方が先）
	if ( \SWELL_Theme::is_use( 'luminous' ) ) return $content;

	// クラスの中身を調べる
	$is_matched = preg_match_all( '/class="([^"]*)"/', $content, $matches );
	if ( ! $is_matched ) return $content;

	if ( ! empty( $matches ) ) {
		foreach ( $matches[1] as $classnames ) {

			if ( false !== strpos( $classnames, 'u-lb-on' ) ) {
				\SWELL_Theme::set_use( 'luminous', true );
			}
		}
	}
	return $content;
}


/**
 * 計測対象のボタンがあるかどうか
 */
add_filter( 'render_block_loos/button', __NAMESPACE__ . '\render_swell_button', 10, 2 );
function render_swell_button( $block_content, $block ) {
	if ( isset( $block['attrs']['isCount'] ) && $block['attrs']['isCount'] ) {
		\SWELL_Theme::set_use( 'count_CTR', true );
		remove_filter( 'render_block_loos/button', __NAMESPACE__ . '\render_swell_button', 10 );
	}
	return $block_content;
}


/**
 * スクリプトが必要なフルワイドかどうか
 */
add_filter( 'render_block_loos/full-wide', __NAMESPACE__ . '\render_full_wide', 10, 2 );
function render_full_wide( $block_content, $block ) {
	if ( ! \SWELL_Theme::is_use( 'rellax' ) ) {
		if ( isset( $block['attrs']['isParallax'] ) && $block['attrs']['isParallax'] ) {
			\SWELL_Theme::set_use( 'rellax', true );
			// remove_filter( 'render_block_loos/full-wide', __NAMESPACE__ . '\render_full_wide', 10 );
		}
	}

	if ( ! \SWELL_Theme::is_use( 'lazysizes' ) ) {
		if ( isset( $block['attrs']['bgImageUrl'] ) && $block['attrs']['bgImageUrl'] ) {
			\SWELL_Theme::set_use( 'lazysizes', true );
			// remove_filter( 'render_block_loos/full-wide', __NAMESPACE__ . '\render_full_wide', 10 );
		}
	}

	return $block_content;
}
