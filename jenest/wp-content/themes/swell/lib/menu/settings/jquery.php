<?php
/**
 * タブ : jQuery
 */
if ( ! defined( 'ABSPATH' ) ) exit;

use \SWELL_THEME\Admin_Menu;
use \SWELL_Theme\Menu\Setting_Field as Field;

// Pagge Name
$page_name = Admin_Menu::PAGE_NAMES['jquery'];

/**
 * JSON-LD
 */
Field::add_menu_section( [
	'title'      => __( 'jQueryの読み込み', 'swell' ),
	'key'        => 'jquery',
	'page_name'  => $page_name,
	'page_cb'    => function ( $args ) {

		Field::checkbox( 'options', 'jquery_to_foot', [
			'label' => __( 'jQueryをwp_footerで登録する', 'swell' ),
		]);

		Field::checkbox( 'options', 'remove_jqmigrate', [
			'label' => __( 'jquery-migrateを読み込まない', 'swell' ),
		]);

		Field::checkbox( 'options', 'load_jquery', [
			'label' => __( 'jQueryを強制的に読み込む', 'swell' ),
			'desc'  => __( 'jQueryに依存したスクリプトを読み込んでいなくても、jQueryを読み込むことができます。', 'swell' ),
		]);

	},
] );
