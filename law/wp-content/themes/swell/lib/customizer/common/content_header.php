<?php
use \SWELL_Theme\Customizer;
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'swell_section_content_header';

/**
 * セクション追加
 */
$wp_customize->add_section( $section, [
	'title'       => __( 'コンテンツヘッダー', 'swell' ),
	'priority'    => 10,
	'panel'       => 'swell_panel_common',
	'description' => __( 'タイトルの表示位置が「コンテンツ上」の時に表示されるエリアの設定です。', 'swell' ),
] );

// タイトル背景用デフォルト画像
Customizer::add( $section, 'ttlbg_dflt_imgid', [
	'label'       => __( 'タイトル背景用デフォルト画像', 'swell' ),
	'description' => __( '投稿ページの「タイトル背景画像」でアイキャッチ画像よりも優先させたい画像がある場合に設定してください。', 'swell' ),
	'type'        => 'media',
	'mime_type'   => 'image',
] );

$ttlbg_dflt_imgid = SWELL_Theme::get_setting( 'ttlbg_dflt_imgid' );
if ( Customizer::is_non_existent_media_id( $ttlbg_dflt_imgid ) ) {
	Customizer::add( $section, 'ttlbg_dflt_imgid_clear', [
		'type'      => 'clear-media',
		'target_id' => 'ttlbg_dflt_imgid',
	] );
}

// 古いデータ残っている場合
if ( ! $ttlbg_dflt_imgid && \SWELL_Theme::get_setting( 'ttlbg_default_img' ) ) {
	Customizer::add( $section, 'ttlbg_default_img', [
		'type'        => 'old-image',
		'label'       => __( 'タイトル背景用デフォルト画像', 'swell' ),
	] );
}

// 画像フィルター
Customizer::add( $section, 'title_bg_filter', [
	'classname'   => '',
	'label'       => __( '画像フィルター', 'swell' ),
	'description' => __( 'タイトル表示位置が「コンテンツ上」の時の背景画像へのフィルター処理', 'swell' ),
	'type'        => 'select',
	'choices'     => [
		'nofilter'        => __( 'なし', 'swell' ),
		'filter-blur'     => __( 'ブラー', 'swell' ),
		'filter-glay'     => __( 'グレースケール', 'swell' ),
		'texture-dot'     => __( 'ドット', 'swell' ),
		'texture-brushed' => __( 'ブラシ', 'swell' ),
	],
] );

// カラーオーバーレイの設定
Customizer::add( $section, 'ttlbg_overlay_color', [
	'classname'   => '',
	'label'       => __( 'カラーオーバーレイの設定', 'swell' ),
	'description' => __( 'タイトル背景画像に被せるカラーレイヤーの色', 'swell' ),
	'type'        => 'color',
] );

// オーバレイカラーの不透明度
Customizer::add( $section, 'ttlbg_overlay_opacity', [
	'classname'   => '',
	'description' => __( 'オーバレイカラーの不透明度<br>（CSSの opacity プロパティの値）', 'swell' ),
	'type'        => 'number',
	'input_attrs' => [
		'step' => '0.1',
		'min'  => '0',
		'max'  => '1',
	],
] );
