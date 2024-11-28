<?php
namespace SWELL_Theme\Taxonomy;

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'init', __NAMESPACE__ . '\add_parts_tax' );
add_action( 'current_screen', __NAMESPACE__ . '\set_parts_tax_terms' );


/**
 * 投稿タイプの登録
 */
function add_parts_tax() {
	$tax = __( '用途', 'swell' );
	register_taxonomy(
		'parts_use',
		[ 'blog_parts' ],
		[
			'public'             => false,
			'hierarchical'       => true,
			'labels'             => [
				'name'                => $tax,
				'singular_name'       => $tax,
				'search_items'        => sprintf( __( '%sを検索', 'swell' ), $tax ),
				'all_items'           => sprintf( __( '全%s', 'swell' ), $tax ),
				'parent_item'         => sprintf( __( '親%s', 'swell' ), $tax ),
				'parent_item_colon'   => sprintf( __( '親%s', 'swell' ), $tax ) . ':',
				'edit_item'           => sprintf( __( '%sを編集', 'swell' ), $tax ),
				'update_item'         => sprintf( __( '%sを更新', 'swell' ), $tax ),
				'add_new_item'        => sprintf( __( '%sを追加', 'swell' ), $tax ),
				'new_item_name'       => sprintf( __( '新しい%s', 'swell' ), $tax ),
				'menu_name'           => $tax,
			],
			'show_ui'            => true,
			// 'show_in_nav_menus'  => false,
			// 'show_in_quick_edit' => false,
			'capabilities'       => [
				// 'manage_terms' => false,
				'edit_terms'   => 'manage_options',
				'delete_terms' => 'manage_options',
				// 'assign_terms' => false, // 投稿画面で設定できる権限
			],
			'show_admin_column'  => true,
			'query_var'          => true,
			'show_in_rest'       => true,
			'rewrite'            => [ 'slug' => 'parts_use' ],
		]
	);
}


/**
 * パーツタグのタームを登録
 */
function set_parts_tax_terms( $current_screen ) {

	if ( 'blog_parts' !== $current_screen->post_type ) return;

	$tags = [
		'pattern'   => __( 'ブロックパターン', 'swell' ),
		'for_cat'   => __( 'カテゴリー用', 'swell' ),
		'for_tag'   => __( 'タグ用', 'swell' ),
		'cta'       => 'CTA',
	];

	foreach ( $tags as $slug => $name ) {
		$the_term = get_term_by( 'slug', $slug, 'parts_use' );
		if ( false === $the_term ) {
			// なければ追加
			wp_insert_term( $name, 'parts_use', ['slug' => $slug ] );
		} elseif ( $name !== $the_term->name ) {
			// サイト言語変更時に更新
			$new_data = [
				'slug' => $slug,
				'name' => $name,
			];
			wp_update_term( $the_term->term_id, 'parts_use', $new_data );
		}
	}
}
