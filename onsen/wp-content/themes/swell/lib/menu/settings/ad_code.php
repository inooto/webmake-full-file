<?php
/**
 * タブ : 広告コード
 */
if ( ! defined( 'ABSPATH' ) ) exit;

use \SWELL_THEME\Admin_Menu;
use \SWELL_Theme\Menu\Setting_Field as Field;

// Pagge Name
$page_name = Admin_Menu::PAGE_NAMES['ad'];


Field::add_menu_section( [
	'title'      => __( '広告コードの設定', 'swell' ),
	'key'        => 'ad',
	'page_name'  => $page_name,
	'page_cb'    => function ( $args ) {

		Field::textarea( 'options', 'sc_ad_code', [
			'label'          => __( '記事内広告', 'swell' ) . '[ad]',
			'desc'           => __( 'ここで入力したコードは、ショートコード<code>[ad]</code>で簡単に呼び出せるようになります。', 'swell' ),
			'size_class'     => 'large-text',
		]);

		Field::textarea( 'options', 'before_h2_addcode', [
			'label'          => __( '目次広告', 'swell' ),
			'desc'           => __( '目次の直前または直後に挿入する広告コード。（目次が非表示の場合は最初のH2タグの直前に表示されます。', 'swell' ) .
				'<br>' . __( '目次の前後どちらに設置するかは、カスタマイザー >「投稿・固定ページ」>「目次」から設定できます。', 'swell' ),
			'size_class'     => 'large-text',
		]);

		Field::textarea( 'options', 'auto_ad_code', [
			'label'          => __( '自動広告 [ad]', 'swell' ),
			'desc'           => __( 'Google AdSenseの自動広告コード。ここで設定したコードは、ページごとに非表示にすることが可能です。', 'swell' ),
			'size_class'     => 'large-text',
		]);
	},
] );


Field::add_menu_section( [
	'title'      => __( 'インフィード広告の間隔', 'swell' ),
	'key'        => 'infeed_ad',
	'page_name'  => $page_name,
	'page_cb'    => function ( $args ) {

		Field::textarea( 'options', 'infeed_code_pc', [
			'label'      => __( 'PC・Tabサイズ用', 'swell' ),
			'size_class' => 'large-text',
		]);

		Field::textarea( 'options', 'infeed_code_sp', [
			'label'      => __( 'スマホサイズ用', 'swell' ),
			'size_class' => 'large-text',
		]);

		Field::input( 'options', 'infeed_interval', [
			'label' => __( 'インフィード広告の間隔', 'swell' ),
			'type'  => 'number',
		]);

	},
] );
