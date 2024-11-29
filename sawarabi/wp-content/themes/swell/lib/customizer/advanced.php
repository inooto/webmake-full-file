<?php
use \SWELL_Theme\Customizer;
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * セクション追加
 */
$section = 'swell_section_advanced';

$wp_customize->add_section( $section, [
	'title'    => __( '高度な設定', 'swell' ),
	'priority' => 10,
] );

Customizer::add( $section, 'head_code', [
	'label'       => __( 'headタグ終了直前に出力するコード', 'swell' ),
	'description' => __( '&lt;/head&gt;直前', 'swell' ),
	'type'        => 'textarea',
	'sanitize'    => '',
	'transport'   => 'postMessage',
] );

Customizer::add( $section, 'body_open_code', [
	'label'       => __( 'bodyタグ開始直後に出力するコード', 'swell' ),
	'description' => __( '&lt;body&gt;直後', 'swell' ),
	'type'        => 'textarea',
	'sanitize'    => '',
	'transport'   => 'postMessage',
] );

Customizer::add( $section, 'foot_code', [
	'label'       => __( 'bodyタグ終了直前に出力するコード', 'swell' ),
	'description' => __( '&lt;/body&gt;直前', 'swell' ),
	'type'        => 'textarea',
	'sanitize'    => '',
	'transport'   => 'postMessage',
] );
