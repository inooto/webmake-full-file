<?php
namespace SWELL_Theme\Post_Type;

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'init', __NAMESPACE__ . '\hook_init' );
add_action( 'admin_init', __NAMESPACE__ . '\hook_admin_init' );


/**
 * 投稿タイプの登録
 */
function hook_init() {
	$OPTION = \SWELL_Theme::get_option();

	/**
	 * LPを追加
	 */
	if ( ! $OPTION['remove_lp'] ) {
		register_post_type(
			'lp', // 投稿タイプ名の定義
			[
				'labels'              => [
					'name'          => __( 'LP', 'swell' ),
					'singular_name' => __( 'LP', 'swell' ),
				],
				'public'              => true,
				'exclude_from_search' => true,
				// 'menu_position' => 6,
				'show_ui'             => true,
				'show_in_menu'        => true,
				// 'capability_type'     => 'page', // 固定ページと同じ権限レベルにする
				'capability_type'     => [ 'lp', 'lps' ],
				'map_meta_cap'        => true, // capability_type を使用するために必要
				'has_archive'         => false,
				'menu_icon'           => 'dashicons-media-default',
				'show_in_rest'        => true,  // ブロックエディターに対応させる
				'supports'            => [ 'title', 'editor', 'thumbnail', 'author', 'revisions', 'custom-fields' ],
			]
		);
	}

	/**
	 * ブログパーツを追加
	 * 寄稿者(contributor) には新規追加の権限をなくしておく（変に増やされないように）
	 */
	if ( ! $OPTION['remove_blog_parts'] ) {
		$parts_name = __( 'ブログパーツ', 'swell' );
		register_post_type(
			'blog_parts', // 投稿タイプ名の定義
			[
				'labels'          => [
					'name'          => $parts_name,
					'singular_name' => $parts_name,
				],
				'public'          => false,
				// 'menu_position' => 6,
				'show_ui'         => true,
				'show_in_menu'    => true,
				// 'capabilities'  => ['create_posts' => 'create_blog_parts' ],
				'capability_type' => [ 'blog_part', 'blog_parts' ],
				'map_meta_cap'    => true, // capabilities を使用するために必要
				'has_archive'     => false,
				// 'menu_icon'     => 'dashicons-welcome-widgets-menus',
				'show_in_rest'    => true,  // ブロックエディターに対応させる
				'supports'        => [ 'title', 'editor' ],
			]
		);
	}

	/**
	 * 広告タグを追加
	 * 寄稿者(contributor) には新規追加の権限をなくしておく（変に増やされないように）
	 */
	if ( ! $OPTION['remove_ad_tag'] ) {
		$ad_name = __( '広告タグ', 'swell' );
		register_post_type(
			'ad_tag', // 投稿タイプ名の定義
			[
				'labels'          => [
					'name'          => $ad_name,
					'singular_name' => $ad_name,
				],
				'public'          => false,
				// 'menu_position' => 6,
				'show_ui'         => true,
				'show_in_menu'    => true,
				// 'capabilities'    => [ 'create_posts' => 'create_ad_tag' ],
				'capability_type' => [ 'ad_tag', 'ad_tags' ],
				'map_meta_cap'    => true, // capabilities を使用するために必要
				'has_archive'     => false,
				'show_in_rest'    => false,  // ブロックエディターに対応させる
				'supports'        => [ 'title' ],
			]
		);
	}

	/**
	 * ふきだしを追加
	 * 寄稿者(contributor) は画像を扱えないので、新規追加の権限をなくしておく
	 */
	// if ( ! $OPTION['remove_balloon'] ) {
		// $balloon_name = __( 'ふきだし' 'swell' );
		// register_post_type(
		// 	'speech_balloon', // 投稿タイプ名の定義
		// 	[
		// 		'labels'        => [
		// 			'name'          => $balloon_name,
		// 			'singular_name' => $balloon_name,
		// 		],
		// 		'public'        => false,
		// 		// 'menu_position' => 6,
		// 		'show_ui'       => true,
		// 		'show_in_menu'  => true,
		// 		'capabilities'  => ['create_posts' => 'create_speech_balloon' ],
		// 		'map_meta_cap'  => true, // capabilities を使用するために必要
		// 		'has_archive'   => false,
		// 		'menu_icon'     => 'dashicons-format-chat',
		// 		'show_in_rest'  => false,
		// 		'supports'      => [ 'title' ],
		// 	]
		// );
	// }
}


/**
 * 独自権限を各権限グループに付与する
 * add_cap() は remove_cap() するまで永続的に権限が付与されることに注意。
 */
function hook_admin_init() {

	$setted_custom_caps = \SWELL_Theme::get_others_data( 'setted_custom_caps' );

	if ( $setted_custom_caps ) return;

	$caps_level_all  = [
		'delete_others_',
		'delete_',
		'delete_private_',
		'delete_published_',
		'edit_others_',
		'edit_',
		'edit_private_',
		'edit_published_',
		'publish_',
		'read_private_',
	];
	$caps_level_self = [
		'delete_',
		// 'delete_private_',
		'delete_published_',
		'edit_',
		'edit_published_',
		'publish_',
	];

	$arrowed_roles = [
		'administrator' => [
			'lps'             => $caps_level_all,
			'ad_tags'         => $caps_level_all,
			'blog_parts'      => $caps_level_all,
			'speech_balloons' => [ 'edit_', 'read_' ],
		],
		'editor' => [
			'lps'             => $caps_level_all,
			'ad_tags'         => $caps_level_all,
			'blog_parts'      => $caps_level_all,
			'speech_balloons' => [ 'edit_', 'read_' ],
		],
		'author' => [
			// 'lps' => $caps_level_all,
			'ad_tags'         => $caps_level_self,
			'blog_parts'      => $caps_level_self,
			'speech_balloons' => [ 'read_' ],
		],
	];

	foreach ( $arrowed_roles as $role => $capabilities ) {
		$roles = get_role( $role );
		foreach ( $capabilities as $pt_slug => $cap_prefixies ) {
			foreach ( $cap_prefixies as $cap_prefix ) {
				$cap = $cap_prefix . $pt_slug;
				$roles->add_cap( $cap );
				// if ( ! isset( $roles->capabilities[ $cap ] ) ) {}
			}
		}
	}

	delete_old_roles();

	\SWELL_Theme::set_others_data( 'setted_custom_caps', true );
}


/**
 * 過去に使用していたカスタムロールを削除
 */
function delete_old_roles() {
	$roles    = [ 'administrator', 'editor', 'author' ];
	$old_caps = [ 'create_blog_parts', 'create_ad_tag', 'create_speech_balloon' ];
	foreach ( $roles as $role ) {
		$roles = get_role( $role );
		foreach ( $old_caps as $cap ) {
			if ( $roles->has_cap( $cap ) ) {
				$roles->remove_cap( $cap );
			}
		}
	}
}
