<?php
use \SWELL_Theme\Customizer;
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'swell_section_main_visual';

/**
 * セクション追加
 */
$wp_customize->add_section( $section, [
	'title'    => __( 'メインビジュアル', 'swell' ),
	'priority' => 10,
	'panel'    => 'swell_panel_top',
] );


// メインビジュアルの表示内容
Customizer::add( $section, 'main_visual_type', [
	'classname'   => '-swell-mv',
	'label'       => __( 'メインビジュアルの表示内容', 'swell' ),
	'type'        => 'radio',
	'description' => __( '画像が複数ある場合はスライダーになります。', 'swell' ),
	'choices'     => [
		'none'    => __( '表示しない', 'swell' ),
		'slider'  => __( '画像', 'swell' ),
		'movie'   => __( '動画', 'swell' ),
	],
] );

// ■ 表示設定
Customizer::big_title( $section, 'mv_common', [
	'classname'   => 'swell-mv-common',
	'label'       => __( '表示設定', 'swell' ),
	'description' => __( '※ 画像・動画のどちらでも有効な設定項目群です。', 'swell' ),
] );

// 周りに余白をつける
Customizer::add( $section, 'mv_on_margin', [
	'classname' => 'swell-mv-common',
	'label'     => __( '周りに余白をつける', 'swell' ),
	'type'      => 'checkbox',
] );

// Scrollボタンを表示する
Customizer::add( $section, 'mv_on_scroll', [
	'classname' => 'swell-mv-common',
	'label'     => __( 'Scrollボタンを表示する', 'swell' ),
	'type'      => 'checkbox',
] );

// メインビジュアルの高さ設定
Customizer::add( $section, 'mv_slide_size', [
	'classname' => 'swell-mv-common',
	'label'     => __( 'メインビジュアルの高さ設定', 'swell' ),
	'type'      => 'select',
	'choices'   => [
		'img'  => __( '画像・動画サイズのまま', 'swell' ),
		'auto' => __( 'コンテンツに応じる', 'swell' ),
		'set'  => __( '数値で指定する', 'swell' ),
		'full' => __( 'ウィンドウサイズにフィットさせる', 'swell' ),
	],
] );

// メインビジュアルの高さ（PC）
Customizer::add( $section, 'mv_slide_height_pc', [
	'classname'   => 'swell-mv-common swell-mv-height',
	'description' => __( 'メインビジュアルの高さ', 'swell' ) . '（PC）',
	'type'        => 'text',
	'sanitize'    => 'wp_filter_nohtml_kses',
] );

// メインビジュアルの高さ（SP）
Customizer::add( $section, 'mv_slide_height_sp', [
	'classname'   => 'swell-mv-common swell-mv-height',
	'description' => __( 'メインビジュアルの高さ', 'swell' ) . '（SP）',
	'type'        => 'text',
	'sanitize'    => 'wp_filter_nohtml_kses',
] );

// 画像（動画）の上に表示されるボタンの丸み
Customizer::add( $section, 'mv_btn_radius', [
	'classname' => 'swell-mv-common -radio-button',
	'label'     => __( '画像（動画）の上に表示されるボタンの丸み', 'swell' ),
	'type'      => 'radio',
	'choices'   => [
		'0'  => __( 'なし', 'swell' ),
		'4'  => __( '少し丸める', 'swell' ),
		'40' => __( '丸める', 'swell' ),
	],
] );


// フィルター処理
Customizer::add( $section, 'mv_img_filter', [
	'classname'   => 'swell-mv-common',
	'label'       => __( 'フィルター処理', 'swell' ),
	'description' => __( 'メインビジュアルに適用するフィルター処理', 'swell' ),
	'type'        => 'select',
	'choices'     => [
		'nofilter'        => __( 'なし', 'swell' ),
		'filter-blur'     => __( 'ブラー', 'swell' ),
		'filter-glay'     => __( 'グレースケール', 'swell' ),
		'texture-dot'     => __( 'ドット', 'swell' ),
		'texture-brushed' => __( 'ブラシ', 'swell' ),
	],
] );

// オーバーレイカラー
Customizer::add( $section, 'mv_overlay_color', [
	'classname'   => 'swell-mv-common',
	'label'       => __( 'オーバーレイカラー', 'swell' ),
	'description' => __( 'メインビジュアルの画像・動画に被せるカラーレイヤー', 'swell' ),
	'type'        => 'color',
] );

// オーバレイカラーの不透明度
Customizer::add( $section, 'mv_overlay_opacity', [
	'classname'   => 'swell-mv-common',
	'description' => __( 'オーバレイカラーの不透明度（CSSの opacity プロパティの値）', 'swell' ),
	'type'        => 'number',
	'input_attrs' => [
		'step' => '0.1',
		'min'  => '0',
		'max'  => '1',
	],
] );

// 画像スライダー
require_once __DIR__ . '/mv/slider.php';

// 動画
require_once __DIR__ . '/mv/movie.php';
