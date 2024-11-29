<?php
use \SWELL_Theme\Customizer;
if ( ! defined( 'ABSPATH' ) ) exit;

// ■ 動画の設定
Customizer::big_title( $section, 'mv_movie', [
	'classname' => 'swell-mv-movie',
	'label'     => __( '動画の設定', 'swell' ),
] );

// 動画(PC)
Customizer::add( $section, 'mv_video', [
	'classname' => 'swell-mv-movie -video',
	'label'     => __( '動画', 'swell' ) . ' (PC)',
	'type'      => 'media',
	'mime_type' => 'video',
] );

// ポスター画像(PC)
Customizer::add( $section, 'mv_video_poster', [
	'classname'   => 'swell-mv-movie -image',
	'label'       => __( 'ポスター画像', 'swell' ) . ' (PC)',
	'description' => __( '動画が読み込まれるまで表示される画像', 'swell' ),
	'type'        => 'image',
] );

// 動画(SP)
Customizer::add( $section, 'mv_video_sp', [
	'classname' => 'swell-mv-movie -video',
	'label'     => __( '動画', 'swell' ) . ' (SP)',
	'type'      => 'media',
	'mime_type' => 'video',
] );

// ポスター画像(SP)
Customizer::add( $section, 'mv_video_poster_sp', [
	'classname'   => 'swell-mv-movie -image',
	'label'       => __( 'ポスター画像', 'swell' ) . ' (SP)',
	'description' => __( '動画が読み込まれるまで表示される画像', 'swell' ),
	'type'        => 'image',
] );

// メインテキスト
Customizer::add( $section, 'movie_title', [
	'classname' => 'swell-mv-movie',
	'label'     => __( 'メインテキスト', 'swell' ),
	'type'      => 'text',
] );

// サブテキスト
Customizer::add( $section, 'movie_text', [
	'classname' => 'swell-mv-movie',
	'label'     => __( 'サブテキスト', 'swell' ),
	'type'      => 'textarea',
] );

// ブログパーツID
Customizer::add( $section, 'movie_parts_id', [
	'classname' => 'swell-mv-movie',
	'label'     => __( 'ブログパーツID', 'swell' ),
	'type'      => 'text',
] );

// ボタンのリンク先URL
Customizer::add( $section, 'movie_url', [
	'classname' => 'swell-mv-movie',
	'label'     => __( 'ボタンのリンク先URL', 'swell' ),
	'type'      => 'text',
	'sanitize'  => 'esc_url_raw',
] );

// ボタンテキスト
Customizer::add( $section, 'movie_btn_text', [
	'classname' => 'swell-mv-movie',
	'label'     => __( 'ボタンテキスト', 'swell' ),
	'type'      => 'text',
] );

// テキストの位置
Customizer::add( $section, 'movie_txtpos', [
	'classname' => 'swell-mv-movie -radio-button',
	'label'     => __( 'テキストの位置', 'swell' ),
	'type'      => 'radio',
	'choices'   => [
		'l' => __( '左', 'swell' ),
		'c' => __( '中央', 'swell' ),
		'r' => __( '右', 'swell' ),
	],
] );

// テキストカラー
Customizer::add( $section, 'movie_txtcol', [
	'classname' => 'swell-mv-movie',
	'label'     => __( 'テキストカラー', 'swell' ),
	'type'      => 'color',
] );

// テキストのシャドウカラー
Customizer::add( $section, 'movie_shadowcol', [
	'classname' => 'swell-mv-movie',
	'label'     => __( 'テキストのシャドウカラー', 'swell' ),
	'type'      => 'color',
] );

// ボタンカラー
Customizer::add( $section, 'movie_btncol', [
	'classname' => 'swell-mv-movie',
	'label'     => __( 'ボタンカラー', 'swell' ),
	'type'      => 'color',
] );

// ボタンタイプ
Customizer::add( $section, 'movie_btntype', [
	'classname' => 'swell-mv-movie -radio-button',
	'label'     => __( 'ボタンタイプ', 'swell' ),
	'type'      => 'radio',
	'choices'   => [
		'n' => __( '白抜き', 'swell' ),
		'b' => __( 'ボーダー', 'swell' ),
	],
] );
