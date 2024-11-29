<?php
use \SWELL_Theme\Customizer;
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'swell_section_share_btn';

/**
 * セクション追加
 */
$wp_customize->add_section( $section, [
	'title'    => __( 'SNSシェアボタン', 'swell' ),
	'priority' => 10,
	'panel'    => 'swell_panel_single_page',
] );

// ■ 表示設定
Customizer::big_title( $section, 'sns_share_btn', [
	'label' => __( '表示設定', 'swell' ),
] );

// シェアボタンを表示する位置
Customizer::sub_title( $section, 'is_show_sahre_btn', [
	'label' => __( 'シェアボタンを表示する位置', 'swell' ),
] );

// 記事上部に表示する
Customizer::add( $section, 'show_share_btn_top', [
	'label' => __( '記事上部に表示する', 'swell' ),
	'type'  => 'checkbox',
] );

// 記事下部に表示する
Customizer::add( $section, 'show_share_btn_bottom', [
	'label' => __( '記事下部に表示する', 'swell' ),
	'type'  => 'checkbox',
] );

// 画面端に固定表示する
Customizer::add( $section, 'show_share_btn_fix', [
	'label' => __( '画面端に固定表示する', 'swell' ),
	'type'  => 'checkbox',
] );

// 表示するボタンの種類
Customizer::sub_title( $section, 'select_sns', [
	'label' => __( '表示するボタンの種類', 'swell' ),
] );

// Facebook
Customizer::add( $section, 'show_share_btn_fb', [
	'label' => __( 'Facebook', 'swell' ),
	'type'  => 'checkbox',
] );

// Twitter
Customizer::add( $section, 'show_share_btn_tw', [
	'label' => __( 'Twitter', 'swell' ),
	'type'  => 'checkbox',
] );

// はてブ
Customizer::add( $section, 'show_share_btn_hatebu', [
	'label' => __( 'はてブ', 'swell' ),
	'type'  => 'checkbox',
] );

// Pocket
Customizer::add( $section, 'show_share_btn_pocket', [
	'label' => __( 'Pocket', 'swell' ),
	'type'  => 'checkbox',
] );

// Pinterest
Customizer::add( $section, 'show_share_btn_pin', [
	'label' => __( 'Pinterest', 'swell' ),
	'type'  => 'checkbox',
] );

// LINE
Customizer::add( $section, 'show_share_btn_line', [
	'label' => __( 'LINE', 'swell' ),
	'type'  => 'checkbox',
] );

// シェアボタンのデザイン
Customizer::add( $section, 'share_btn_style', [
	'label'   => __( 'シェアボタンのデザイン', 'swell' ),
	'type'    => 'select',
	'choices' => [
		'block'     => __( 'ブロック', 'swell' ),
		'btn'       => __( 'ボタン', 'swell' ),
		'btn-small' => __( 'ボタン', 'swell' ) . '(' . __( '小', 'swell' ) . ')',
		'icon'      => __( 'アイコン', 'swell' ),
		'box'       => __( 'ボックス', 'swell' ),
	],
] );

// URLコピーボタン
Customizer::add( $section, 'urlcopy_btn_pos', [
	'label'   => __( 'URLコピーボタン', 'swell' ),
	'type'    => 'select',
	'choices' => [
		'none'     => __( '表示しない', 'swell' ),
		'in'       => __( '小さく表示', 'swell' ),
		'out'      => __( '大きく表示', 'swell' ),
	],
] );

// 「シェアしてね」
Customizer::add( $section, 'share_message', [
	'label' => __( '「記事下部シェアボタン」の上に表示するメッセージ', 'swell' ),
	'type'  => 'text',
] );

// ■ Twitter用の追加設定
Customizer::big_title( $section, 'sns_share_add_setting', [
	'label' => __( 'Twitter用の追加設定', 'swell' ),
] );

// シェアされた時のハッシュタグ
Customizer::add( $section, 'share_hashtags', [
	'label'       => __( 'シェアされた時のハッシュタグ', 'swell' ),
	'description' => __( '「#」は含めずに入力し、複数の時は「,」区切りで入力してください。', 'swell' ),
	'type'        => 'text',
] );

// via設定（メンション先）
Customizer::add( $section, 'share_via', [
	'label'       => __( 'via設定（メンション先）', 'swell' ),
	'description' => __( '「@◯◯さんから」をつけることができます。@を除いたID名を入力してください。', 'swell' ),
	'type'        => 'text',
] );
