<?php
/**
 * タブ : 機能停止
 */
if ( ! defined( 'ABSPATH' ) ) exit;

use \SWELL_THEME\Admin_Menu;
use \SWELL_Theme\Menu\Setting_Field as Field;

// Pagge Name
$page_name = Admin_Menu::PAGE_NAMES['remove'];


Field::add_menu_section( [
	'title'      => __( 'SWELLの機能', 'swell' ),
	'key'        => 'remove_swell',
	'page_name'  => $page_name,
	'page_cb'    => function ( $args ) {

		$remove_settings = [
			'remove_page_fade'    => __( '「ページ表示時のアニメーション」を停止する', 'swell' ),
			'remove_somooth_sc'   => __( '「スムーススクロール」を停止する', 'swell' ),
			'remove_url2card'     => __( '「URLの自動カード化」を停止する', 'swell' ),
			'remove_delete_empp'  => __( '「空のpタグを自動削除する機能」を停止する', 'swell' ),
			'remove_luminous'     => __( '「投稿画像をクリックで拡大表示する機能」を停止する', 'swell' ),
			'remove_pv_count'     => __( '「PV計測機能」を停止する', 'swell' ),
			'remove_patterns'     => __( '「SWELLが用意しているブロックパターン」を非表示にする', 'swell' ),
		];
		foreach ( $remove_settings as $key => $label ) {
			Field::checkbox( 'options', $key, [
				'label' => $label,
			]);
		}

		Field::h3( __( 'カスタム投稿タイプ', 'swell' ) );

		$remove_settings = [
			'remove_lp'         => __( '「LP」を停止', 'swell' ),
			'remove_blog_parts' => __( '「ブログパーツ」を停止', 'swell' ),
			'remove_ad_tag'     => __( '「広告タグ管理」を停止', 'swell' ),
			'remove_balloon'    => __( '「ふきだし管理」を停止', 'swell' ),
		];
		foreach ( $remove_settings as $key => $label ) {
			Field::checkbox( 'options', $key, [
				'label' => $label,
			]);
		}

		echo '<br>';
		Field::description( __( '※ すでに設定済みのデータはデータベースに残り、ブロックからも引き続き呼び出すことが可能です。', 'swell' ) );
	},
] );


Field::add_menu_section( [
	'title'      => __( 'WordPressの機能', 'swell' ),
	'key'        => 'remove_core',
	'page_name'  => $page_name,
	'page_cb'    => function ( $args ) {

		$remove_settings = [
			'remove_wpver'           => __( 'WordPressのバージョン情報を出力しない', 'swell' ),
			'remove_rel_link'        => __( '<code>rel="prev/next"</code>を出力しない', 'swell' ),
			'remove_rsd_link'        => __( 'EditURI(RSD Link)を停止する', 'swell' ),
			'remove_emoji'           => __( '絵文字用のスクリプトの読み込みをしない', 'swell' ),
			'remove_self_pingbacks'  => __( 'セルフピンバックを停止する', 'swell' ),
			'remove_sitemap'         => __( 'コアのサイトマップ機能を停止する', 'swell' ),
			'remove_media_inf_scrll' => __( 'メディアライブラリの無限スクロールを停止する', 'swell' ),
			'remove_robots_image'    => __( '<code>meta="robots" content="max-image-preview:large"</code>を出力しない', 'swell' ),
			'remove_rest_link'       => __( 'REST API用のlinkタグを出力しない', 'swell' ),
			'remove_img_srcset'      => __( '画像のsrcsetを出力しない', 'swell' ),
			'remove_wptexturize'     => __( '記号の自動変換を停止する(wptexturize無効化)', 'swell' ),
			'remove_feed_link'       => __( 'RSSフィードを停止する', 'swell' ),
		];
		foreach ( $remove_settings as $key => $label ) {
			Field::checkbox( 'options', $key, [
				'label' => $label,
			]);
		}
	},
] );
