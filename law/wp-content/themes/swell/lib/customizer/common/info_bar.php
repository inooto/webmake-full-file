<?php
use \SWELL_Theme\Customizer;
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'swell_section_info_bar';

/**
 * セクション追加
 */
$wp_customize->add_section( $section, [
	'title'    => __( 'お知らせバー', 'swell' ),
	'priority' => 10,
	'panel'    => 'swell_panel_common',
] );

// お知らせバーの表示位置
Customizer::add( $section, 'info_bar_pos', [
	'label'   => __( 'お知らせバーの表示位置', 'swell' ),
	'type'    => 'radio',
	'choices' => [
		'none'        => __( '表示しない', 'swell' ),
		'head_top'    => __( 'ヘッダー上部に表示', 'swell' ),
		'head_bottom' => __( 'ヘッダー下部に表示', 'swell' ),
	],
] );

// ■ 表示内容の設定
Customizer::big_title( $section, 'notice_bar_content', [
	'classname' => '-swell-info-bar',
	'label'     => __( '表示内容の設定', 'swell' ),
] );

// お知らせバーの文字の大きさ
Customizer::add( $section, 'info_bar_size', [
	'classname' => '-swell-info-bar -radio-button',
	'label'     => __( 'お知らせバーの文字の大きさ', 'swell' ),
	'type'      => 'radio',
	'choices'   => [
		'small'  => __( '小さく', 'swell' ),
		'normal' => __( '普通', 'swell' ),
		'big'    => __( '大きく', 'swell' ),
	],
] );

// 表示タイプ
Customizer::add( $section, 'info_flowing', [
	'classname' => '-swell-info-bar',
	'label'     => __( '表示タイプ', 'swell' ),
	'type'      => 'select',
	'choices'   => [
		'no_flow' => __( 'テキスト位置固定（バー全体がリンク）', 'swell' ),
		'btn'     => __( 'テキスト位置固定（ボタンを設置）', 'swell' ),
		'flow'    => __( 'テキストを横に流す', 'swell' ),
	],
] );

// お知らせ内容
Customizer::add( $section, 'info_text', [
	'classname' => '-swell-info-bar',
	'label'     => __( 'お知らせ内容', 'swell' ),
	'type'      => 'text',
] );

// リンク先のURL
Customizer::add( $section, 'info_url', [
	'classname' => '-swell-info-bar',
	'label'     => __( 'リンク先のURL', 'swell' ),
	'type'      => 'text',
	'sanitize'  => 'wp_filter_nohtml_kses',
] );

// ボタンテキスト
Customizer::add( $section, 'info_btn_text', [
	'classname' => '-swell-info-bar -info-btn',
	'label'     => __( 'ボタンテキスト', 'swell' ),
	'type'      => 'text',
] );


// ■ 背景効果
Customizer::big_title( $section, 'info_bar_bg', [
	'classname' => '-swell-info-bar',
	'label'     => __( '背景効果', 'swell' ),
] );

// お知らせバーの背景効果
Customizer::add( $section, 'info_bar_effect', [
	'classname' => '-swell-info-bar',
	'label'     => __( 'お知らせバーの背景効果', 'swell' ),
	'type'      => 'radio',
	'choices'   => [
		'no_effect' => __( 'なし', 'swell' ),
		'gradation' => __( 'グラデーション', 'swell' ),
		'stripe'    => __( '斜めストライプ', 'swell' ),
	],
] );


// ■ カラー設定
Customizer::big_title( $section, 'notice_bar_colors', [
	'classname' => '-swell-info-bar',
	'label'     => __( 'カラー設定', 'swell' ),
] );

// お知らせバー文字色
Customizer::add( $section, 'color_info_text', [
	'classname' => '-swell-info-bar',
	'label'     => __( 'お知らせバー文字色', 'swell' ),
	'type'      => 'color',
] );

// ボタン背景色
Customizer::add( $section, 'color_info_btn', [
	'classname' => '-swell-info-bar -info-btn',
	'label'     => __( 'ボタン背景色', 'swell' ),
	'type'      => 'color',
] );

// お知らせバー背景色
Customizer::add( $section, 'color_info_bg', [
	'classname' => '-swell-info-bar',
	'label'     => __( 'お知らせバー背景色', 'swell' ),
	'type'      => 'color',
] );

// グラデーション用の追加背景色
Customizer::add( $section, 'color_info_bg2', [
	'classname' => '-swell-info-bar -info-col2',
	'label'     => __( 'グラデーション用の追加背景色', 'swell' ),
	'type'      => 'color',
] );
