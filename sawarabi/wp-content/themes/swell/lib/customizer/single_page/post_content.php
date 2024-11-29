<?php
use \SWELL_Theme\Customizer;
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'swell_section_post_content';

/**
 * セクション追加
 */
$wp_customize->add_section( $section, [
	'title'       => __( 'コンテンツのデザイン', 'swell' ),
	'description' => sprintf( __( 'ボタンやマーカーなどの設定は、SWELL設定の<br>「<a href="%s">エディター設定</a>」へ移動しました。<br><br>', 'swell' ), admin_url( 'admin.php?page=swell_settings_editor' ) ),
	'priority'    => 10,
	'panel'       => 'swell_panel_single_page',
] );


// ■ 見出しのデザイン設定
Customizer::big_title( $section, 'headline', [
	'label' => __( '見出しのデザイン設定', 'swell' ),
] );

// 見出しのキーカラー
Customizer::add( $section, 'color_htag', [
	'label'   => __( '見出しのキーカラー', 'swell' ),
	'type'    => 'color',
] );

// 見出し2のデザイン
Customizer::add( $section, 'h2_type', [
	'label'   => __( '見出し2のデザイン', 'swell' ),
	'type'    => 'select',
	'choices' => [
		'band'        => __( '帯', 'swell' ),
		'block'       => __( '塗り潰し', 'swell' ),
		'b_left'      => __( '左に縦線', 'swell' ),
		'b_left2'     => __( '左に２色のブロック', 'swell' ),
		'tag_normal'  => __( '付箋風', 'swell' ),
		'tag'         => __( '付箋風（ストライプ）', 'swell' ),
		'stitch'      => __( 'ステッチ', 'swell' ),
		'stitch_thin' => __( 'ステッチ（薄）', 'swell' ),
		'balloon'     => __( 'ふきだし風', 'swell' ),
		'b_topbottom' => __( '上下に線', 'swell' ),
		'letter'      => __( '1文字目にアクセント', 'swell' ),
		''            => __( '装飾なし', 'swell' ),
	],
] );

// 見出し3のデザイン
Customizer::add( $section, 'h3_type', [
	'label'   => __( '見出し3のデザイン', 'swell' ),
	'type'    => 'select',
	'choices' => [
		'main_gray' => __( '２色の下線（メイン・グレー）', 'swell' ),
		'main_thin' => __( '２色の下線（メイン・薄メイン）', 'swell' ),
		'main_line' => __( '下線（メインカラー）', 'swell' ),
		'gradation' => __( '下線（グラデーション）', 'swell' ),
		'stripe'    => __( '下線（ストライプ）', 'swell' ),
		'l_border'  => __( '左に縦線', 'swell' ),
		'l_block'   => __( '左に２色のブロック', 'swell' ),
		''          => __( '装飾なし', 'swell' ),
	],
] );

// 見出し4のデザイン
Customizer::add( $section, 'h4_type', [
	'label'   => __( '見出し4のデザイン', 'swell' ),
	'type'    => 'select',
	'choices' => [
		'left_line' => __( '左に縦線', 'swell' ),
		'check'     => __( 'チェックアイコン', 'swell' ),
		''          => __( '装飾なし', 'swell' ),
	],
] );


// ■ セクション見出しのデザイン設定
Customizer::big_title( $section, 'sec_headline', [
	'label' => __( 'セクション見出しのデザイン設定', 'swell' ),
] );


// セクション見出しのキーカラー
Customizer::add( $section, 'color_sec_htag', [
	'label' => __( 'セクション見出しのキーカラー', 'swell' ),
	'type'  => 'color',
] );

// セクション用見出し2のデザイン
Customizer::add( $section, 'sec_h2_type', [
	'label'   => __( 'セクション用見出し2のデザイン', 'swell' ),
	'type'    => 'select',
	'choices' => [
		''         => __( '装飾なし', 'swell' ),
		'b_bottom' => __( '下に線', 'swell' ),
		'b_lr'     => __( '左右に線', 'swell' ),
	],
] );

// ■ 太字
Customizer::big_title( $section, 'bold', [
	'label' => __( '太字', 'swell' ),
] );

// 太字の下に点線をつける
Customizer::add( $section, 'show_border_strong', [
	'label'       => __( '太字の下に点線をつける', 'swell' ),
	'description' => __( '※ pタグ直下でのみ有効', 'swell' ),
	'type'        => 'checkbox',
] );


// ■ テキストリンク
Customizer::big_title( $section, 'link', [
	'label' => __( 'テキストリンク', 'swell' ),
] );

// テキストリンクにアンダーラインを付ける
Customizer::add( $section, 'show_link_underline', [
	'label' => __( 'テキストリンクにアンダーラインを付ける', 'swell' ),
	'type'  => 'checkbox',
] );
