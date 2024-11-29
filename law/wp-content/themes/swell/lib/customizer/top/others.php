<?php
use \SWELL_Theme\Customizer;
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'swell_section_other';

/**
 * セクション追加
 */
$wp_customize->add_section( $section, [
	'title'    => __( 'その他', 'swell' ),
	'priority' => 10,
	'panel'    => 'swell_panel_top',
] );


// コンテンツ上の余白量
Customizer::add( $section, 'top_content_mt', [
	'classname'   => '-radio-button',
	'label'       => __( 'コンテンツ上の余白量', 'swell' ),
	'description' => __( 'メインビジュアル・記事スライダーの部分と、その下のコンテンツ部分との間の余白量を設定できます。', 'swell' ),
	'type'        => 'radio',
	'choices'     => [
		'0'   => __( 'なし', 'swell' ),
		'2em' => __( '狭め', 'swell' ),
		'4em' => __( '標準', 'swell' ),
		'6em' => __( '広め', 'swell' ),
	],
] );
