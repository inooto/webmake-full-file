<?php
use \SWELL_Theme\Customizer;
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'swell_section_sp_menu';

/**
 * セクション追加
 */
$wp_customize->add_section( $section, [
	'title'    => __( 'スマホ開閉メニュー', 'swell' ),
	'priority' => 10,
	'panel'    => 'swell_panel_common',
] );

// ■ カラー設定
Customizer::big_title( $section, 'sp_menu_colors', [
	'label' => __( 'カラー設定', 'swell' ),
] );

// 文字色
Customizer::add( $section, 'color_spmenu_text', [
	'label' => __( '文字色', 'swell' ),
	'type'  => 'color',
] );

// 背景色
Customizer::add( $section, 'color_spmenu_bg', [
	'label' => __( '背景色', 'swell' ),
	'type'  => 'color',
] );


// 背景の不透明度
Customizer::add( $section, 'spmenu_opacity', [
	'label'       => __( '背景の不透明度', 'swell' ),
	'type'        => 'number',
	'input_attrs' => [
		'step' => '0.1',
		'min'  => '0',
		'max'  => '1',
	],
] );


// メニュー展開時のオーバーレイカラー
Customizer::add( $section, 'color_menulayer_bg', [
	'label' => __( 'メニュー展開時のオーバーレイカラー', 'swell' ),
	'type'  => 'color',
] );


// メニュー展開時のオーバーレイカラーの不透明度
Customizer::add( $section, 'menulayer_opacity', [
	'label'       => __( 'メニュー展開時のオーバーレイカラーの不透明度', 'swell' ),
	'type'        => 'number',
	'input_attrs' => [
		'step' => '0.1',
		'min'  => '0',
		'max'  => '1',
	],
] );


// ■ 表示設定
Customizer::big_title( $section, 'sp_menu_settings', [
	'label' => __( '表示設定', 'swell' ),
] );

// メインメニュー上に表示するタイトル
Customizer::add( $section, 'spmenu_main_title', [
	'label' => __( 'メインメニュー上に表示するタイトル', 'swell' ),
	'type'  => 'text',
] );


// サブメニューをアコーディオン化する
Customizer::sub_title( $section, 'acc_sp_submenu', [
	'label'       => __( 'サブメニューをアコーディオン化', 'swell' ),
	'description' => __( '「サイト全体設定」→「基本デザイン」→「■ サブメニューの表示形式」から、サブメニューを開閉式にすることができます。', 'swell' ),
] );
