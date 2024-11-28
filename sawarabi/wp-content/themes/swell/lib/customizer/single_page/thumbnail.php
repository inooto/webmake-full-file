<?php
use \SWELL_Theme\Customizer;
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'swell_section_thumbnail';

/**
 * セクション追加
 */
$wp_customize->add_section( $section, [
	'title'    => __( 'アイキャッチ画像', 'swell' ),
	'priority' => 10,
	'panel'    => 'swell_panel_single_page',
] );

// ■ 固定ページ
Customizer::big_title( $section, 'page_thumb', [
	'label' => __( '固定ページ', 'swell' ),
] );

// 本文の始めにアイキャッチ画像を表示
Customizer::add( $section, 'show_page_thumb', [
	'label' => __( '本文の始めにアイキャッチ画像を表示', 'swell' ),
	'type'  => 'checkbox',
] );


// ■ 投稿ページ
Customizer::big_title( $section, 'post_thumb', [
	'label' => __( '投稿ページ', 'swell' ),
] );

// 本文の始めにアイキャッチ画像を表示
Customizer::add( $section, 'show_post_thumb', [
	'label' => __( '本文の始めにアイキャッチ画像を表示', 'swell' ),
	'type'  => 'checkbox',
] );

// 上記がチェックされている時、アイキャッチ画像がない場合に
Customizer::add( $section, 'show_noimg_thumb', [
	'classname' => '-show-noimg-thumb',
	'label'     => __( 'アイキャッチ画像なければ「NO IMAGE画像」を代わりに表示する', 'swell' ),
	'type'      => 'checkbox',
] );
