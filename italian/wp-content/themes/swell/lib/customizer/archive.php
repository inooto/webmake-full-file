<?php
use \SWELL_Theme\Customizer;
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * セクション追加
 */
$section = 'swell_section_archive';

$wp_customize->add_section( $section, [
	'title'    => __( 'アーカイブページ', 'swell' ),
	'priority' => 4,
] );


// ■ タイトル設定
Customizer::big_title( $section, 'archive_title', [
	'label' => __( 'タイトル設定', 'swell' ),
] );

// 表示位置
Customizer::add( $section, 'term_title_pos', [
	'label'       => __( '表示位置', 'swell' ),
	'description' => __( '※ タームアーカイブページでのみ有効です。', 'swell' ),
	'type'        => 'select',
	'choices'     => [
		'top'    => __( 'コンテンツ上', 'swell' ),
		'inner'  => __( 'コンテンツ内', 'swell' ),
	],
] );



// タイトルのデザイン
Customizer::add( $section, 'archive_title_style', [
	'label'       => __( 'コンテンツ内タイトルデザイン', 'swell' ),
	'description' => __( 'タイトルが「コンテンツ内」に表示される場合のデザイン', 'swell' ),
	'type'        => 'select',
	'choices'     => [
		''         => __( '装飾なし', 'swell' ),
		'b_bottom' => __( '下線', 'swell' ),
	],
] );


// タームナビゲーション
Customizer::sub_title( $section, 'term_navigation', [
	'label'       => __( 'タームナビゲーション', 'swell' ),
	'description' => __( '親ターム・子タームへの導線を設置するかどうか。', 'swell' ),
] );

// カテゴリーページに表示する
Customizer::add( $section, 'show_category_nav', [
	'label' => __( 'カテゴリーページに表示する', 'swell' ),
	'type'  => 'checkbox',
] );
