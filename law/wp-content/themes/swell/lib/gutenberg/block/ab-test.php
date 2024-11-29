<?php
namespace SWELL_Theme\Block\Ab_Test;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * ABテストブロック
 */
\SWELL_Theme::register_block( 'ab-test', [
	'render_callback' => __NAMESPACE__ . '\cb',
] );

function cb( $attrs, $content, $block ) {
	static $AB_sync_ids = [];

	$flag_num         = rand( 1, 100 ); // phpcs:ignore WordPress.WP.AlternativeFunctions.rand_rand
	$rate_A           = $attrs['rate'] ?? 50; // 0 ~ 100
	$show_block_index = $rate_A >= $flag_num ? 0 : 1;
	$is_sync_mode     = $attrs['syncMode'] ?? false;
	$sync_id          = $attrs['syncId'] ?? '';
	$is_reverse       = $attrs['isReverse'] ?? false;

	if ( $is_sync_mode && $sync_id ) {
		if ( isset( $AB_sync_ids[ $sync_id ] ) ) {
			// 同じIDをもつブロックが既にレンダリングされていれば、その表示結果に合わせる
			$show_block_index = $AB_sync_ids[ $sync_id ];
		} else {
			// 同じIDを持つブロックがまだレンダリングされてなければ、その表示結果を保存しておく
			$AB_sync_ids[ $sync_id ] = $show_block_index;
		}
	}

	// 最低二つのブロックがちゃんとあるか、または対象のブロックがあるかチェック。なければ1つ目のブロックを表示
	if ( count( $block->parsed_block['innerBlocks'] ) < 2 || ! isset( $block->parsed_block['innerBlocks'][ $show_block_index ] ) ) {
		$show_block_index = 0;
	}

	// 逆の結果を表示する場合
	// ※今後ブロックの数が増える場合(AB→ABCD)、逆にした時にどのブロックを表示するかを決定するロジックが必要
	// if ( $is_reverse ) {
	// 	$show_block_index = $show_block_index === 0 ? 1 : 0;
	// }

	$blocks = $block->parsed_block['innerBlocks'][ $show_block_index ]['innerBlocks'];

	return do_blocks( serialize_blocks( $blocks ) );
}
