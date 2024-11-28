<?php
use \SWELL_Theme\Customizer;
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'swell_section_noimg';

/**
 * セクション追加
 */
$wp_customize->add_section( $section, [
	'title'    => __( 'NO IMAGE画像', 'swell' ),
	'priority' => 10,
	'panel'    => 'swell_panel_common',
] );

// NO IMAGE画像
Customizer::add( $section, 'noimg_id', [
	'classname'   => '',
	'label'       => __( 'NO IMAGE画像', 'swell' ),
	'description' => __( '記事アイキャッチ用の NO IMAGE画像を設定してください。（推奨：横幅1600px以上）', 'swell' ),
	'type'        => 'media',
	'mime_type'   => 'image',
] );

$noimg_id = SWELL_Theme::get_setting( 'noimg_id' );
if ( Customizer::is_non_existent_media_id( $noimg_id ) ) {
	Customizer::add( $section, 'noimg_id_clear', [
		'type'      => 'clear-media',
		'target_id' => 'noimg_id',
	] );
}

// 古いデータ残っている場合
if ( ! $noimg_id && \SWELL_Theme::get_setting( 'no_image' ) ) {
	Customizer::add( $section, 'no_image', [
		'type'        => 'old-image',
		'label'       => __( 'NO IMAGE画像', 'swell' ),
	] );
}
