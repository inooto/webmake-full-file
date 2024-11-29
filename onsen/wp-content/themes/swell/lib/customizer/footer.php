<?php
use \SWELL_Theme\Customizer;
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * セクション追加
 */
$section = 'swell_section_footer';

$wp_customize->add_section( $section, [
	'title'    => __( 'フッター', 'swell' ),
	'priority' => 3,
] );


// ■ カラー設定
Customizer::big_title( $section, 'foot_color', [
	'label' => __( 'カラー設定', 'swell' ),
] );

// フッター背景色
Customizer::add( $section, 'color_footer_bg', [
	'label' => __( 'フッター背景色', 'swell' ),
	'type'  => 'color',
] );

// フッター文字色
Customizer::add( $section, 'color_footer_text', [
	'label' => __( 'フッター文字色', 'swell' ),
	'type'  => 'color',
] );


// ウィジェットエリアの背景色
Customizer::add( $section, 'color_footwdgt_bg', [
	'label' => __( 'ウィジェットエリアの背景色', 'swell' ),
	'type'  => 'color',
] );

// ウィジェットエリアの文字色
Customizer::add( $section, 'color_footwdgt_text', [
	'label' => __( 'ウィジェットエリアの文字色', 'swell' ),
	'type'  => 'color',
] );


// ■ コピーライト設定
Customizer::big_title( $section, 'foot_copy', [
	'label' => __( 'コピーライト設定', 'swell' ),
] );

// コピーライト
Customizer::add( $section, 'copyright', [
	'label' => __( 'コピーライトのテキスト', 'swell' ),
	'type'  => 'text',
] );


// その他の設定
Customizer::big_title( $section, 'foot_other', [
	'label' => __( 'その他の設定', 'swell' ),
] );

// フッターとフッター直前ウィジェットの間の余白をなく
Customizer::add( $section, 'footer_no_mt', [
	'label' => __( '「フッター」と「フッター直前ウィジェット」の間の余白をなくす', 'swell' ),
	'type'  => 'checkbox',
] );

// フッターにSNSアイコンリストを表示する
Customizer::add( $section, 'show_foot_icon_list', [
	'label' => __( 'フッターにSNSアイコンリストを表示する', 'swell' ),
	'type'  => 'checkbox',
] );
