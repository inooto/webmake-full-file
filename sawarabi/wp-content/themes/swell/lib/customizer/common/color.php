<?php
use \SWELL_Theme\Customizer;
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'swell_section_color';

/**
 * セクション追加
 */
$wp_customize->add_section( $section, [
	'title'    => __( '基本カラー', 'swell' ),
	'priority' => 10,
	'panel'    => 'swell_panel_common',
] );

// メインカラー
Customizer::add( $section, 'color_main', [
	'classname' => '',
	'label'     => __( 'メインカラー', 'swell' ),
	'type'      => 'color',
] );

// テキストカラー
Customizer::add( $section, 'color_text', [
	'classname' => '',
	'label'     => __( 'テキストカラー', 'swell' ),
	'type'      => 'color',
] );

// リンクの色
Customizer::add( $section, 'color_link', [
	'classname' => '',
	'label'     => __( 'リンクカラー', 'swell' ),
	'type'      => 'color',
] );

// 背景色
Customizer::add( $section, 'color_bg', [
	'classname' => '',
	'label'     => __( '背景色', 'swell' ),
	'type'      => 'color',
] );
