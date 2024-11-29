<?php
namespace SWELL_Theme\Hooks;

if ( ! defined( 'ABSPATH' ) ) exit;

add_filter( 'admin_bar_menu', __NAMESPACE__ . '\hook_admin_bar_menu', 99 );
function hook_admin_bar_menu( $wp_admin_bar ) {
	// 「カスタマイズ」
	if ( is_admin() ) {
		$wp_admin_bar->add_menu(
			[
				'id'    => 'customize',
				'title' => '<span class="ab-icon"></span><span class="ab-label">' . __( 'カスタマイズ', 'swell' ) . '</span>',
				'href'  => admin_url( 'customize.php' ),
			]
		);
	}

	// 親メニュー
	$wp_admin_bar->add_menu(
		[
			'id'    => 'swell_settings',
			'title' => '<span class="ab-icon icon-swell u-fz-16"></span><span class="ab-label">' . __( 'SWELL設定', 'swell' ) . '</span>',
			'href'  => admin_url( 'admin.php?page=swell_settings' ),
			'meta'  => [
				'class' => 'swell-menu',
			],
		]
	);
	$wp_admin_bar->add_menu(
		[
			'parent' => 'swell_settings',
			'id'     => 'swell_settings_menu',
			'meta'   => [],
			'title'  => __( '設定ページへ', 'swell' ),
			'href'   => admin_url( 'admin.php?page=swell_settings' ),
		]
	);
	$wp_admin_bar->add_menu(
		[
			'parent' => 'swell_settings',
			'id'     => 'swell_settings_editor_menu',
			'meta'   => [],
			'title'  => __( 'エディター設定', 'swell' ),
			'href'   => admin_url( 'admin.php?page=swell_settings_editor' ),
		]
	);
	$wp_admin_bar->add_menu(
		[
			'parent' => 'swell_settings',
			'id'     => 'swell_settings_manual_link',
			'meta'   => ['target' => '_blank' ],
			'title'  => __( 'マニュアル', 'swell' ),
			'href'   => 'https://swell-theme.com/manual/',
		]
	);
	$wp_admin_bar->add_menu(
		[
			'parent' => 'swell_settings',
			'id'     => 'swell_settings_forum_link',
			'meta'   => ['target' => '_blank' ],
			'title'  => __( 'フォーラム', 'swell' ),
			'href'   => 'https://users.swell-theme.com/forum/',
		]
	);
	$wp_admin_bar->add_menu(
		[
			'parent' => 'swell_settings',
			'id'     => 'swell_settings_icon_demo',
			'meta'   => ['target' => '_blank' ],
			'title'  => __( 'アイコン一覧', 'swell' ),
			'href'   => 'https://swell-theme.com/icon-demo/',
		]
	);
	$wp_admin_bar->add_menu(
		[
			'parent' => 'swell_settings',
			'id'     => 'swell_settings__clear_cache',
			'meta'   => [],
			'title'  => __( 'キャッシュクリア', 'swell' ) . ' (' . __( 'コンテンツ', 'swell' ) . ')',
			'href'   => '###',
		]
	);
	$wp_admin_bar->add_menu(
		[
			'parent' => 'swell_settings',
			'id'     => 'swell_settings__clear_card_cache',
			'meta'   => [],
			'title'  => __( 'キャッシュクリア', 'swell' ) . ' (' . __( 'ブログカード', 'swell' ) . ')',
			'href'   => '###',
		]
	);
	$wp_admin_bar->add_menu(
		[
			'parent' => 'swell_settings',
			'id'     => 'swell_settings_activate',
			'meta'   => [],
			'title'  => __( 'アクティベート', 'swell' ),
			'href'   => admin_url( 'admin.php?page=swell_settings_swellers' ),
		]
	);
}
