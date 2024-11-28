<?php
namespace SWELL_Theme\Gutenberg;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * グループとカラムで wp-container- が出力されないようにする。
 */
add_action( 'init', function() {
	if ( ! function_exists( 'wp_render_layout_support_flag' ) ) return;

	// remove_filter( 'render_block', 'gutenberg_render_layout_support_flag' );
	remove_filter( 'render_block', 'wp_render_layout_support_flag' );
	add_filter( 'render_block', function( $block_content, $block ) {
		// カラムブロックに wp-container- つけない
		if ( $block['blockName'] === 'core/columns' || $block['blockName'] === 'core/column' ) {
			return $block_content;
		}

		// ギャラリーブロックに wp-container- つけない
		// if ( $block['blockName'] === 'core/gallery' ) {
		// 	return $block_content;
		// }

		if ( $block['blockName'] === 'core/group' ) {

			// layout設定なければ wp-container- つけない
			if ( ! isset( $block['attrs']['layout']['type'] ) ) return $block_content;
			if ( 'default' === $block['attrs']['layout']['type'] ) return $block_content;

			// グループバリエーションに応じてクラスを付ける
			if ( 'flex' === $block['attrs']['layout']['type'] ) {
				$orientation = $block['attrs']['layout']['orientation'] ?? '';
				if ( 'vertical' === $orientation ) {
					$add_class = 'is-stack';
				} else {
					$add_class = 'is-row';
				}
				$block_content = str_replace( 'class="wp-block-group', 'class="wp-block-group ' . $add_class, $block_content );
				// $block_content = str_replace( 'class="wp-container-', 'class="' . $add_class . ' wp-container-', $block_content );
			}

			return wp_render_layout_support_flag( $block_content, $block );
		}

		return wp_render_layout_support_flag( $block_content, $block );
	}, 10, 2 );
});



/**
 * render_hook
 */
require __DIR__ . '/gutenberg/render_hook.php';


/**
 * SWELLブロックの登録
 */
require __DIR__ . '/gutenberg/register_blocks.php';


/**
 * init: ブロックパターン
 */
if ( function_exists( 'register_block_pattern' ) ) {
		require __DIR__ . '/gutenberg/block_patterns.php';
}


/**
 * ブロック制御
 */
require __DIR__ . '/gutenberg/block_control.php';



/**
 * 5.8~ に初期配置されているウィジェットのタイトル（h2 タグ）
 */
add_action( 'dynamic_sidebar', function() {
	add_filter( 'render_block_core/group', __NAMESPACE__ . '\render_core_group_in_widget', 10, 2 );
} );
function render_core_group_in_widget( $block_content, $block ) {
	$title_class = 'c-widget__title';
	if ( str_contains( \SWELL_Theme::$widget_area_in_output, 'sidebar' ) ) {
		$title_class .= ' -side';
	} elseif ( str_contains( \SWELL_Theme::$widget_area_in_output, 'footer' ) ) {
		$title_class .= ' -footer';
	} elseif ( str_contains( \SWELL_Theme::$widget_area_in_output, 'sp_menu' ) ) {
		$title_class .= ' -spmenu';
	}

	// 5.8のころの初期実装
	$block_content = preg_replace( '/<h2>(.*?)<\/h2>/i', '<div class="' . $title_class . '">$1</div>', $block_content );
	return $block_content;
}
