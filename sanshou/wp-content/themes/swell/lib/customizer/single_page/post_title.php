<?php
use \SWELL_Theme\Customizer;
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'swell_section_post_title';

/**
 * セクション追加
 */
$wp_customize->add_section( $section, [
	'title'    => __( 'タイトル', 'swell' ),
	'priority' => 10,
	'panel'    => 'swell_panel_single_page',
] );

// ■ 投稿ページ
Customizer::big_title( $section, 'post_title', [
	'label' => __( '投稿ページ', 'swell' ),
] );

// タイトルの表示位置
Customizer::add( $section, 'post_title_pos', [
	'label'   => __( 'タイトルの表示位置', 'swell' ),
	'type'    => 'select',
	'choices' => [
		'top'    => __( 'コンテンツ上', 'swell' ),
		'inner'  => __( 'コンテンツ内', 'swell' ),
	],
] );

// 表示する日付
Customizer::add( $section, 'title_date_type', [
	'label'   => __( 'タイトル横に表示する日付', 'swell' ),
	'type'    => 'radio',
	'choices' => [
		'date'     => __( '公開日', 'swell' ),
		'modified' => __( '更新日', 'swell' ),
	],
] );

// タイトル横に日付を表示する（PC）
Customizer::add( $section, 'show_title_date', [
	'label' => __( 'タイトル横に日付を表示する', 'swell' ) . '（PC）',
	'type'  => 'checkbox',
] );

// タイトル横に日付を表示する（SP）
Customizer::add( $section, 'show_title_date_sp', [
	'label' => __( 'タイトル横に日付を表示する', 'swell' ) . '（SP）',
	'type'  => 'checkbox',
] );

// タイトル下に表示する情報
Customizer::sub_title( $section, 'post_title_terms', [
	'label' => __( 'タイトル下に表示する情報', 'swell' ),
] );

// タイトル下にカテゴリーを表示する
Customizer::add( $section, 'show_meta_cat', [
	'label' => __( 'タイトル下にカテゴリーを表示する', 'swell' ),
	'type'  => 'checkbox',
] );

// タイトル下にタグを表示する
Customizer::add( $section, 'show_meta_tag', [
	'label' => __( 'タイトル下にタグを表示する', 'swell' ),
	'type'  => 'checkbox',
] );

// カスタム投稿タイプの時、タクソノミーを表示する
Customizer::add( $section, 'show_meta_tax', [
	'label' => __( 'カスタム投稿タイプの時、タクソノミーを表示する', 'swell' ),
	'type'  => 'checkbox',
]);

// タイトル下に公開日を表示する
Customizer::add( $section, 'show_meta_posted', [
	'label' => __( 'タイトル下に公開日を表示する', 'swell' ),
	'type'  => 'checkbox',
] );

// タイトル下に更新日を表示する
Customizer::add( $section, 'show_meta_modified', [
	'label' => __( 'タイトル下に更新日を表示する', 'swell' ),
	'type'  => 'checkbox',
] );


// タイトル下に著者を表示する
Customizer::add( $section, 'show_meta_author', [
	'label' => __( 'タイトル下に著者を表示する', 'swell' ),
	'type'  => 'checkbox',
] );


// ■ 固定ページ
Customizer::big_title( $section, 'page_title', [
	'label' => __( '固定ページ', 'swell' ),
] );

// タイトルの表示位置
Customizer::add( $section, 'page_title_pos', [
	'label'   => __( 'タイトルの表示位置', 'swell' ),
	'type'    => 'select',
	'choices' => [
		'top'    => __( 'コンテンツ上', 'swell' ),
		'inner'  => __( 'コンテンツ内', 'swell' ),
	],
] );


// ページタイトルのデザイン
Customizer::add( $section, 'page_title_style', [
	'label'       => __( 'コンテンツ内タイトルデザイン', 'swell' ),
	'description' => __( 'タイトルが「コンテンツ内」に表示される場合のデザイン', 'swell' ),
	'type'        => 'select',
	'choices'     => [
		''         => __( '装飾なし', 'swell' ),
		'b_bottom' => __( '下線', 'swell' ),
	],
] );
