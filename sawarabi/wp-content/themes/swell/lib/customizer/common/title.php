<?php
use \SWELL_Theme\Customizer;
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'swell_section_title_style';

/**
 * セクション追加
 */
$wp_customize->add_section( $section, [
	'title'    => __( 'タイトルデザイン', 'swell' ),
	'priority' => 10,
	'panel'    => 'swell_panel_common',
] );

// サブコンテンツのタイトルデザイン
Customizer::add( $section, 'sec_title_style', [
	'label'       => __( 'サブコンテンツのタイトルデザイン', 'swell' ),
	'description' => __( '記事下コンテンツやウィジェットで追加されたコンテンツ上に表示されるタイトルのデザインを選択してください。', 'swell' ),
	'type'        => 'select',
	'choices'     => [
		''         => __( '装飾なし', 'swell' ),
		'b_bottom' => __( '下線', 'swell' ),
		'b_left'   => __( '左に縦線', 'swell' ),
		'b_lr'     => __( '左右に横線', 'swell' ),
	],
] );


// ■ ウィジェットタイトル
Customizer::big_title( $section, 'widget', [
	'label' => __( 'ウィジェットタイトル', 'swell' ),
] );

// サイドバーのタイトルデザイン（PC）
Customizer::add( $section, 'sidettl_type', [
	'label'   => __( 'サイドバーのタイトルデザイン', 'swell' ) . '（PC）',
	'type'    => 'select',
	'choices' => [
		'b_bottom' => __( '下線', 'swell' ),
		'b_left'   => __( '左に縦線', 'swell' ),
		'b_lr'     => __( '左右に横線', 'swell' ),
		'fill'     => __( '塗り', 'swell' ),
	],
] );

// サイドバーのタイトルデザイン（SP）
Customizer::add( $section, 'sidettl_type_sp', [
	'label'   => __( 'サイドバーのタイトルデザイン', 'swell' ) . '（SP）',
	'type'    => 'select',
	'choices' => [
		''         => __( '- PC表示に合わせる -', 'swell' ),
		'b_bottom' => __( '下線', 'swell' ),
		'b_left'   => __( '左に縦線', 'swell' ),
		'b_lr'     => __( '左右に横線', 'swell' ),
		'fill'     => __( '塗り', 'swell' ),
	],
] );


// フッターのタイトルデザイン
Customizer::add( $section, 'footer_title_type', [
	'label'   => __( 'フッターのタイトルデザイン', 'swell' ),
	'type'    => 'select',
	'choices' => [
		''         => __( '装飾なし', 'swell' ),
		'b_bottom' => __( '下線', 'swell' ),
		'b_lr'     => __( '左右に線', 'swell' ),
		// 'fill' => __( '塗り', 'swell' ),
	],
] );


// スマホメニュー内のタイトルデザイン
Customizer::add( $section, 'spmenu_title_type', [
	'label'   => __( 'スマホメニュー内のタイトルデザイン', 'swell' ),
	'type'    => 'select',
	'choices' => [
		'b_bottom' => __( '下線', 'swell' ),
		'b_left'   => __( '左に縦線', 'swell' ),
		'b_lr'     => __( '左右に横線', 'swell' ),
		'fill'     => __( '塗り', 'swell' ),
	],
] );
