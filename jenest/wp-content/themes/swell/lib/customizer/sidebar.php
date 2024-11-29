<?php
use \SWELL_Theme\Customizer;
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * セクション追加
 */
$section = 'swell_section_sidebar';

$wp_customize->add_section( $section, [
	'title'    => __( 'サイドバー', 'swell' ),
	'priority' => 3,
] );


// サイドバーを表示するかどうか
Customizer::sub_title( $section, 'is_show_sidebar', [
	'label' => __( 'サイドバーを表示するかどうか', 'swell' ),
] );

// トップページにサイドバーを表示する
Customizer::add( $section, 'show_sidebar_top', [
	'label' => __( 'トップページにサイドバーを表示する', 'swell' ),
	'type'  => 'checkbox',
] );

// 投稿ページにサイドバーを表示する
Customizer::add( $section, 'show_sidebar_post', [
	'label' => __( '投稿ページにサイドバーを表示する', 'swell' ),
	'type'  => 'checkbox',
] );

// 固定ページにサイドバーを表示する
Customizer::add( $section, 'show_sidebar_page', [
	'label' => __( '固定ページにサイドバーを表示する', 'swell' ),
	'type'  => 'checkbox',
] );

// アーカイブページにサイドバーを表示する
Customizer::add( $section, 'show_sidebar_archive', [
	'label' => __( 'アーカイブページにサイドバーを表示する', 'swell' ),
	'type'  => 'checkbox',
] );

// サイドバーの位置
Customizer::add( $section, 'sidebar_pos', [
	'classname' => '-radio-button',
	'label'     => __( 'サイドバーの位置', 'swell' ),
	'type'      => 'radio',
	'choices'   => [
		'left'  => __( '左', 'swell' ),
		'right' => __( '右', 'swell' ),
	],
] );
