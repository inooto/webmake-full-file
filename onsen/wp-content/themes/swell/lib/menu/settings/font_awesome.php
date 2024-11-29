<?php
/**
 * タブ : Font Awesome
 */
if ( ! defined( 'ABSPATH' ) ) exit;

use \SWELL_THEME\Admin_Menu;
use \SWELL_Theme\Menu\Setting_Field as Field;

// Pagge Name
$page_name = Admin_Menu::PAGE_NAMES['fa'];

/**
 *  Font Awesome
 */
Field::add_menu_section( [
	'title'      => __( 'Font Awesomeの読み込み', 'swell' ),
	'key'        => 'fa',
	'page_name'  => $page_name,
	'page_cb'    => function ( $args ) {

		Field::radio( 'options', 'load_font_awesome', [
			'label'   => __( '読み込み方', 'swell' ),
			'choices' => [
				''    => __( '読み込まない', 'swell' ),
				'css' => __( 'CSSで読み込む', 'swell' ),
				'js'  => __( 'JSで読み込む', 'swell' ),
			],
		]);

		Field::radio( 'options', 'fa_version', [
			'label'   => __( 'バージョン', 'swell' ),
			'choices' => [
				'v6' => 'v6',
				'v5' => 'v5',
			],
		]);
	},
] );
