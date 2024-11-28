<?php
use \SWELL_Theme\Customizer;
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'swell_section_breadcrumb';

/**
 * セクション追加
 */
$wp_customize->add_section( $section, [
	'title'    => __( 'パンくずリスト', 'swell' ),
	'priority' => 10,
	'panel'    => 'swell_panel_common',
] );

// パンくずリストの位置
Customizer::add( $section, 'pos_breadcrumb', [
	'label'   => __( 'パンくずリストの位置', 'swell' ),
	'type'    => 'radio',
	'choices' => [
		'top'    => __( 'ページ上部', 'swell' ),
		'bottom' => __( 'ページ下部', 'swell' ),
	],
] );

// 「ホーム」の文字列
Customizer::add( $section, 'breadcrumb_home_text', [
	'label' => __( '「ホーム」の文字列', 'swell' ),
	'type'  => 'text',
] );

// その他の設定
Customizer::sub_title( $section, 'breadcrumb_others', [
	'classname' => '',
	'label'     => __( 'その他の設定', 'swell' ),
] );

// カテゴリー・タグページで「投稿ページ」を親にセットする
Customizer::add( $section, 'breadcrumb_set_home', [
	'label'       => __( 'カテゴリー・タグの親に「投稿ページ」をセット', 'swell' ),
	'description' => __( '※ ホームページの表示設定で「投稿ページ」を設定している時のみ有効です。', 'swell' ),
	'type'        => 'checkbox',
] );


// パンくずリストの背景効果を無くす
Customizer::add( $section, 'hide_bg_breadcrumb', [
	'label'       => __( 'パンくずリストの背景効果を無くす', 'swell' ),
	'description' => __( '※ タイトル位置が「コンテンツ上」のページやコンテンツ背景の白設定がオンの場合は、自動的にオフになります。', 'swell' ),
	'type'        => 'checkbox',
	'partial'     => [
		'selector'            => '#breadcrumb',
		'container_inclusive' => true,
		'render_callback'     => ['\SWELL_Theme\Customizer\Partial', 'breadcrumb' ],
	],
] );
