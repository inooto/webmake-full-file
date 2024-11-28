<?php
use \SWELL_Theme\Customizer;
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'swell_section_sp_bottom_menu';

/**
 * セクション追加
 */
$wp_customize->add_section( $section, [
	'title'    => __( '下部固定ボタン・メニュー', 'swell' ),
	'priority' => 10,
	'panel'    => 'swell_panel_common',
] );

// ■ 右下固定ボタン
Customizer::big_title( $section, 'foot_btns', [
	'label' => __( '右下固定ボタン', 'swell' ),
] );


// 目次ボタンの表示設定
Customizer::add( $section, 'index_btn_style', [
	'label'       => __( '目次ボタンの表示設定', 'swell' ),
	'description' => __( '※ 目次を設置しているページにのみ表示されます。', 'swell' ),
	'type'        => 'select',
	'choices'     => [
		'none'    => __( '非表示', 'swell' ),
		'square'  => __( '表示する（四角形）', 'swell' ),
		'circle'  => __( '表示する（円形）', 'swell' ),
	],
] );

Customizer::add( $section, 'tocbtn_label', [
	'label'    => __( '目次ボタン下のテキスト', 'swell' ),
	'type'     => 'text',
] );

// ページトップボタンの表示設定
Customizer::add( $section, 'pagetop_style', [
	'label'   => __( 'ページトップボタンの表示設定', 'swell' ),
	'type'    => 'select',
	'choices' => [
		'none'       => __( '非表示', 'swell' ),
		'fix_square' => __( '表示する（四角形）', 'swell' ),
		'fix_circle' => __( '表示する（円形）', 'swell' ),
	],
] );
Customizer::add( $section, 'pagetop_label', [
	'label'    => __( 'ページトップボタン下のテキスト', 'swell' ),
	'type'     => 'text',
] );


// ■ スマホ用固定フッターメニューの設定
Customizer::big_title( $section, 'foot_fix_menu', [
	'label'       => __( 'スマホ用固定フッターメニューの設定', 'swell' ),
	'description' => __( '「外観」>「メニュー」にて、「固定フッターメニュー」が設定されている場合に表示されます。', 'swell' ),
] );

// 特殊メニューボタンの表示設定
Customizer::sub_title( $section, 'foot_fix_menu_btns', [
	'label' => __( '特殊メニューボタンの表示設定', 'swell' ),
] );

// メニュー開閉ボタンを表示する
Customizer::add( $section, 'show_fbm_menu', [
	'label' => __( 'メニュー開閉ボタンを表示する', 'swell' ),
	'type'  => 'checkbox',
] );

// 検索ボタンを表示する
Customizer::add( $section, 'show_fbm_search', [
	'label' => __( '検索ボタンを表示する', 'swell' ),
	'type'  => 'checkbox',
] );

// ページトップボタンを表示する
Customizer::add( $section, 'show_fbm_pagetop', [
	'label' => __( 'ページトップボタンを表示する', 'swell' ),
	'type'  => 'checkbox',
] );

// 目次メニューを表示する
Customizer::add( $section, 'show_fbm_index', [
	'label' => __( '目次メニューを表示する', 'swell' ),
	'type'  => 'checkbox',
] );

// 開閉メニューのラベルテキスト
Customizer::add( $section, 'fbm_menu_label', [
	'label'    => __( '開閉メニューのラベルテキスト', 'swell' ),
	'type'     => 'text',
	'sanitize' => 'wp_filter_nohtml_kses',
] );

// 検索ボタンのラベルテキスト
Customizer::add( $section, 'fbm_search_label', [
	'label'    => __( '検索ボタンのラベルテキスト', 'swell' ),
	'type'     => 'text',
	'sanitize' => 'wp_filter_nohtml_kses',
] );

// ページトップのラベルテキスト
Customizer::add( $section, 'fbm_pagetop_label', [
	'label'    => __( 'ページトップのラベルテキスト', 'swell' ),
	'type'     => 'text',
	'sanitize' => 'wp_filter_nohtml_kses',
] );

// 目次メニューのラベルテキスト
Customizer::add( $section, 'fbm_index_label', [
	'label'    => __( '目次メニューのラベルテキスト', 'swell' ),
	'type'     => 'text',
	'sanitize' => 'wp_filter_nohtml_kses',
] );

// 固定フッターメニューの背景色
Customizer::add( $section, 'color_fbm_bg', [
	'label' => __( '固定フッターメニューの背景色', 'swell' ),
	'type'  => 'color',
] );

// 固定フッターメニューの文字色
Customizer::add( $section, 'color_fbm_text', [
	'label' => __( '固定フッターメニューの文字色', 'swell' ),
	'type'  => 'color',
] );

// 固定フッターメニューの背景不透明度
Customizer::add( $section, 'fbm_opacity', [
	'label'       => __( '固定フッターメニューの背景不透明度', 'swell' ),
	'type'        => 'number',
	'input_attrs' => [
		'step' => '0.1',
		'min'  => '0',
		'max'  => '1',
	],
] );
