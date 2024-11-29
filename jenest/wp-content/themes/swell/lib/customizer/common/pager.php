<?php
use \SWELL_Theme\Customizer;
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'swell_section_pager';

/**
 * セクション追加
 */
$wp_customize->add_section( $section, [
	'title'    => __( 'ページャー', 'swell' ),
	'priority' => 10,
	'panel'    => 'swell_panel_common',
] );

// ページャーの形
Customizer::add( $section, 'pager_shape', [
	'classname' => '-radio-button',
	'label'     => __( 'ページャーの形', 'swell' ),
	'type'      => 'radio',
	'choices'   => [
		'square' => __( '四角', 'swell' ),
		'circle' => __( '丸', 'swell' ),
	],
	'partial'   => [
		'selector' => '.pagination',
	],
] );

// ページャーのデザイン
Customizer::add( $section, 'pager_style', [
	'classname' => '',
	'label'     => __( 'ページャーのデザイン', 'swell' ),
	'type'      => 'radio',
	'choices'   => [
		'border' => __( '枠線付き', 'swell' ),
		'bg'     => __( '背景グレー', 'swell' ),
	],
] );
