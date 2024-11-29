<?php
use \SWELL_Theme\Customizer;
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'swell_section_pickup_banner';

/**
 * セクション追加
 */
$wp_customize->add_section( $section, [
	'title'       => __( 'ピックアップバナー', 'swell' ),
	'description' => __( '位置設定を「ピックアップバナー」に設定しているメニューがある場合にのみ有効です。', 'swell' ),
	'priority'    => 10,
	'panel'       => 'swell_panel_top',
] );


// ■ バナーレイアウト
Customizer::big_title( $section, 'pickup_layout', [
	'label' => __( 'バナーレイアウト', 'swell' ),
] );

// バナーレイアウト（PC）
Customizer::add( $section, 'pickbnr_layout_pc', [
	'label'   => __( 'バナーレイアウト', 'swell' ) . '（PC）',
	'type'    => 'select',
	'choices' => [
		'fix_col4' => __( '固定幅 4列', 'swell' ),
		'fix_col3' => __( '固定幅 3列', 'swell' ),
		'fix_col2' => __( '固定幅 2列', 'swell' ),
		'flex'     => __( 'フレックス（横一列に全て並べる）', 'swell' ),
	],
] );

// バナーレイアウト（SP）
Customizer::add( $section, 'pickbnr_layout_sp', [
	'label'   => __( 'バナーレイアウト', 'swell' ) . '（SP）',
	'type'    => 'select',
	'choices' => [
		'fix_col2' => __( '固定幅 2列', 'swell' ),
		'fix_col1' => __( '固定幅 1列', 'swell' ),
		'slide'    => __( 'スライド（横スクロール可能に）', 'swell' ),
	],
] );


// ■ バナーデザイン
Customizer::big_title( $section, 'pickup_style', [
	'label' => __( 'バナーデザイン', 'swell' ),
] );

// バナータイトルのデザイン
Customizer::add( $section, 'pickbnr_style', [
	'label'   => __( 'バナータイトルのデザイン', 'swell' ),
	'type'    => 'select',
	'choices' => [
		'none'       => __( '表示しない', 'swell' ),
		'top_left'   => __( '左上に表示', 'swell' ),
		'btm_right'  => __( '右下に表示', 'swell' ),
		'ctr_simple' => __( '中央（シンプル）', 'swell' ),
		'ctr_button' => __( '中央（ボタン風）', 'swell' ),
		'btm_wide'   => __( '下にワイド表示', 'swell' ),
	],
] );

// 内側に白線を
Customizer::add( $section, 'pickbnr_border', [
	'label'   => __( '内側に白線を', 'swell' ),
	'type'    => 'radio',
	'choices' => [
		'off' => __( 'つけない', 'swell' ),
		'on'  => __( 'つける', 'swell' ),
	],
] );

// バナー画像を少し暗く
Customizer::add( $section, 'pickbnr_bgblack', [
	'label'   => __( 'バナー画像を少し暗く', 'swell' ),
	'type'    => 'radio',
	'choices' => [
		'off' => __( 'しない', 'swell' ),
		'on'  => __( 'する', 'swell' ),
	],
] );


// その他
Customizer::big_title( $section, 'pickup_others', [
	'label' => __( 'その他', 'swell' ),
] );

// トップページ以外の下層ページにも表示する
Customizer::add( $section, 'pickbnr_show_under', [
	'label' => __( 'トップページ以外の下層ページにも表示する', 'swell' ),
	'type'  => 'checkbox',
] );

Customizer::add( $section, 'pickbnr_lazy_off', [
	'label'       => __( 'Lazyloadを強制オフにする', 'swell' ),
	'type'        => 'checkbox',
	'description' => __( 'チェックを外すと、サイト全体（「SWELL設定」→「画像等のLazyload」）の設定に従います。', 'swell' ),
] );
