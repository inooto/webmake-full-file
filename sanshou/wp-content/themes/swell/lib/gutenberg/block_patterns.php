<?php
namespace SWELL_Theme\Gutenberg\Patterns;

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'init', __NAMESPACE__ . '\register_block_patterns' );
add_action( 'init', __NAMESPACE__ . '\register_custom_block_patterns' );

/**
 * ブロックパターンの登録
 */
function register_block_patterns() {

	if ( \SWELL_Theme::get_option( 'remove_patterns' ) ) return;

	// 改行
	$n     = "\n";
	$noimg = T_DIRE_URI . '/assets/img/noimage-inline.png';

	// 共通項目
	$paragraph = '<!-- wp:paragraph -->' . $n . '<p>' . __( 'ここは段落ブロックです。文章をここに入力してください。', 'swell' ) . '</p>' . $n . '<!-- /wp:paragraph -->';

	require __DIR__ . '/block_pattern/common.php';
	require __DIR__ . '/block_pattern/table.php';
	require __DIR__ . '/block_pattern/page.php';
}

/**
 * ブロックパターンの登録
 */
function register_custom_block_patterns() {

	// SWELLのカスタムパターンカテゴリーを登録
	register_block_pattern_category(
		'swell-custom-patterns',
		[ 'label' => '[SWELL] ' . __( 'カスタムパターン', 'swell' ) ]
	);

	$args = [
		'post_type'              => 'blog_parts',
		'no_found_rows'          => true,
		'update_post_term_cache' => false,
		'update_post_meta_cache' => false,
		'posts_per_page'         => -1,
		'tax_query'              => [
			[
				'taxonomy' => 'parts_use',
				'field'    => 'slug',
				'terms'    => 'pattern',
				'operator' => 'AND',
			],
		],
	];

	$the_query = new \WP_Query( $args );
	foreach ( $the_query->posts as $parts ) :
		register_block_pattern( 'swell-patterns/parts-' . $parts->ID, [
			'title'       => $parts->post_title,
			'content'     => $parts->post_content,
			'categories'  => [ 'swell-custom-patterns' ],
		] );
	endforeach;
	wp_reset_postdata();
}
