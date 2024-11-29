<?php
namespace SWELL_Theme\Load_Files;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Gutenberg用スクリプト
 */
add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\hook_enqueue_block_editor_assets', 20 );
function hook_enqueue_block_editor_assets() {

	// ブロックエディター用CSS
	wp_enqueue_style( 'swell_editor_style', T_DIRE_URI . '/build/css/editor/editor_style.css', [], SWELL_VERSION );
	wp_enqueue_style( 'swell_editor_gutenberg', T_DIRE_URI . '/build/css/editor/gutenberg.css', [], SWELL_VERSION );
	wp_enqueue_style( 'swell_blocks', T_DIRE_URI . '/build/css/blocks.css', [], SWELL_VERSION );

	// googleフォント memo: @import使うので inline_style の中で一番先頭になるようにする。
	$google_font = \SWELL_Theme::get_google_font();
	if ( $google_font ) {
		wp_add_inline_style( 'swell_editor_style', "@import url('$google_font');" );
	}

	// 動的CSS
	wp_add_inline_style( 'swell_editor_style', \SWELL_Theme\Style::get_editor_css() );

	// カスタムフォーマット用CSS
	$custom_format_css = \SWELL_Theme::get_editor( 'custom_format_css' );
	if ( $custom_format_css ) {
		wp_add_inline_style( 'swell_editor_style', $custom_format_css );
	}

	// icons
	wp_enqueue_script( 'swell_icon_ls', T_DIRE_URI . '/build/icons/index.js', [], SWELL_VERSION, true );
	wp_enqueue_script( 'swell_icon_ph', T_DIRE_URI . '/build/icons/ph.js', [], SWELL_VERSION, true );
	wp_enqueue_script( 'swell_icon_fi', T_DIRE_URI . '/build/icons/fi.js', [], SWELL_VERSION, true );
	wp_enqueue_script( 'swell_icon_io', T_DIRE_URI . '/build/icons/io.js', [], SWELL_VERSION, true );
	wp_enqueue_script( 'swell_icon_fa', T_DIRE_URI . '/build/icons/fa.js', [], SWELL_VERSION, true );

	// エディター用の基本スクリプト
	$asset = include T_DIRE . '/build/gutenberg/index.asset.php';
	wp_enqueue_script( 'swell_blocks', T_DIRE_URI . '/build/gutenberg/index.js', $asset['dependencies'], $asset['version'], true );

	global $hook_suffix;
	if ( 'post.php' === $hook_suffix || 'post-new.php' === $hook_suffix ) {
		// $asset = include T_DIRE . 'build/gutenberg/post_editor.asset.php';
		wp_enqueue_script( 'swell_post_editor', T_DIRE_URI . '/build/gutenberg/post_editor.js', [], SWELL_VERSION, true );
	}
	// elseif ( 'widgets.php' === $hook_suffix || 'customize.php' === $hook_suffix ) {
	// 	wp_enqueue_script( 'swell_widget_editor', T_DIRE_URI . '/build/gutenberg/widget_editor.js', [], SWELL_VERSION, true );
	// }

	// fse関連ブロックの非表示
	if ( apply_filters( 'swell_hide_fse_blocks', true ) ) {
		wp_enqueue_script( 'swell_hide_fse_blocks', T_DIRE_URI . '/build/gutenberg/hide_fse_blocks.js', [], SWELL_VERSION, true );
	}

	// JS用翻訳ファイルの読み込み
	if ( function_exists( 'wp_set_script_translations' ) ) {
		wp_set_script_translations( 'swell_blocks', 'swell', \SWELL_Theme::get_languages_dir() );
	}

	/**
	 * 旧ブロック
	 */
	wp_enqueue_script( 'swell-old-blocks', \SWELL_Theme::get_block_path( T_DIRE_URI, 'old-blocks', 'index.js' ), [ 'swell_blocks' ], SWELL_VERSION, true );
}


// ブロックに必要なデータを admin_footer で出力(TinyMceでも利用することに注意。)
add_action( 'admin_footer', __NAMESPACE__ . '\output_content_data', 20 );


/**
 * エディターに渡すデータ
 */
function output_content_data() {

	// エディター画面でのみ出力
	global $hook_suffix;
	$has_editor = 'post.php' === $hook_suffix || 'post-new.php' === $hook_suffix || 'widgets.php' === $hook_suffix || 'customize.php' === $hook_suffix;
	if ( ! $has_editor ) return;

	echo '<script id="swell_content_data">';

	// キャプションブロックのカラーセット
	echo 'window.capBlockColors = ' . wp_json_encode( \SWELL_Theme::get_cap_colors_data(), JSON_UNESCAPED_UNICODE ) . ';';

	// ふきだし
	echo 'window.swellBalloons = ' . wp_json_encode( \SWELL_Theme::get_all_balloons(), JSON_UNESCAPED_UNICODE ) . ';';

	// ブログパーツ
	echo 'window.swellBlogParts = ' . wp_json_encode( \SWELL_Theme::get_blog_parts_data(), JSON_UNESCAPED_UNICODE ) . ';';
	echo 'window.swellPartsUses = ' . wp_json_encode( \SWELL_Theme::get_blog_parts_uses(), JSON_UNESCAPED_UNICODE ) . ';';

	// 広告
	echo 'window.swellAdTags = ' . wp_json_encode( \SWELL_Theme::get_ad_tag_data(), JSON_UNESCAPED_UNICODE ) . ';';

	echo '</script>' . PHP_EOL;
}
