<?php
use \SWELL_Theme\Customizer;
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'swell_section_pr_notation';

/**
 * セクション追加
 */
$wp_customize->add_section( $section, [
	'title'    => __( 'PR表記', 'swell' ),
	'priority' => 10,
	'panel'    => 'swell_panel_single_page',
] );


Customizer::add( $section, 'show_pr_notation', [
	'label'       => __( 'PR表記の自動挿入', 'swell' ) . '(' . __( '投稿', 'swell' ) . ')',
	'type'        => 'select',
	'choices'     => [
		'off'  => __( 'しない', 'swell' ),
		'on'   => __( '全記事に表示', 'swell' ),
	],
] );


Customizer::add( $section, 'pr_notation_type', [
	'label'       => __( '表示タイプ', 'swell' ),
	'type'        => 'select',
	'choices'     => [
		's' => __( '小', 'swell' ),
		'l' => __( '大', 'swell' ),
	],
] );


Customizer::add( $section, 'show_pr_notation_page', [
	'label'       => __( 'PR表記の自動挿入', 'swell' ) . '(' . __( '固定ページ', 'swell' ) . ')',
	'type'        => 'select',
	'choices'     => [
		'off'  => __( 'しない', 'swell' ),
		'on'   => __( '全ページに表示', 'swell' ),
	],
] );


Customizer::sub_title( $section, 'pr_notation_help', [
	'description' => '各投稿・固定ページごとにも、PR表記を表示するかどうかを指定できます。',
] );


Customizer::big_title( $section, 'pr_notation_texts', [
	'label' => '表示するテキスト',
] );

Customizer::add( $section, 'pr_notation_s_text', [
	'label' => __( 'テキスト(小)', 'swell' ),
	'type'  => 'text',
] );

Customizer::add( $section, 'pr_notation_l_text', [
	'label' => __( 'テキスト(大)', 'swell' ),
	'type'  => 'text',
] );
