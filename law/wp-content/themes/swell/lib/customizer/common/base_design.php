<?php
use \SWELL_Theme\Customizer;
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * セクション追加
 */
$section = 'swell_section_base_design';

$wp_customize->add_section( $section, [
	'title'    => __( '基本デザイン', 'swell' ),
	'priority' => 10,
	'panel'    => 'swell_panel_common',
] );


// サイト全体の見た目
Customizer::big_title( $section, 'base_display', [
	'label' => __( 'サイト全体の見た目', 'swell' ),
] );

// 全体の質感
Customizer::sub_title( $section, 'base_material', [
	'label' => __( '全体の質感', 'swell' ),
] );

// 全体をフラットにする
Customizer::add( $section, 'to_site_flat', [
	'label' => __( '全体をフラットにする', 'swell' ),
	'type'  => 'checkbox',
] );

// 全体に丸みをもたせる
Customizer::add( $section, 'to_site_rounded', [
	'label' => __( '全体に丸みをもたせる', 'swell' ),
	'type'  => 'checkbox',
] );

// コンテンツの背景を白にする
Customizer::add( $section, 'content_frame', [
	'label'   => __( 'コンテンツの背景を白にする', 'swell' ),
	'type'    => 'radio',
	'choices' => [
		'frame_off'     => __( 'オフ', 'swell' ),
		'frame_on'      => __( 'オン', 'swell' ),
		'frame_on_main' => __( 'オン（メインエリアのみ）', 'swell' ),
	],
] );

Customizer::add( $section, 'frame_scope', [
	'classname' => '-frame-setting',
	'label'     => __( 'どのページに適用するか', 'swell' ),
	'type'      => 'select',
	'choices'   => [
		''          => __( '全てのページ', 'swell' ),
		'post'      => __( '投稿ページのみ', 'swell' ),
		'page'      => __( '固定ページのみ', 'swell' ),
		'post_page' => __( '投稿・固定ページ', 'swell' ),
		'no_front'  => __( 'フロントページ以外', 'swell' ),
	],
] );

Customizer::add( $section, 'on_frame_border', [
	'classname' => '-frame-setting',
	'label'     => __( 'さらに、コンテンツを線で囲む', 'swell' ),
	'type'      => 'checkbox',
] );


// ■ フォント設定
Customizer::big_title( $section, 'body_font', [
	'label' => __( 'フォント設定', 'swell' ),
] );

// ベースとなるフォント
Customizer::add( $section, 'body_font_family', [
	'classname'   => '',
	'label'       => __( 'ベースとなるフォント', 'swell' ),
	'description' => __( '実際に出力されるfont-familyについて詳しくは<a href="https://swell-theme.com/basic-setting/3114/" target="_blank" rel="noopener">こちら</a>', 'swell' ),
	'type'        => 'select',
	'choices'     => [
		'yugo'     => __( '游ゴシック', 'swell' ),
		'hirago'   => __( 'ヒラギノゴシック > メイリオ', 'swell' ),
		'notosans' => __( 'Noto Sans JP', 'swell' ),
		'serif'    => __( '明朝体 (Noto Serif JP)', 'swell' ),
	],
] );

// フォントサイズ(PC・Tab)
Customizer::add( $section, 'post_font_size_pc', [
	'label'     => __( 'フォントサイズ', 'swell' ) . '(PC・Tab)',
	'type'      => 'select',
	'choices'   => [
		'14px' => _x( '極小', 'size', 'swell' ) . '(14px)',
		'15px' => _x( '小', 'size', 'swell' ) . '(15px)',
		'16px' => _x( '中', 'size', 'swell' ) . '(16px)',
		'17px' => _x( '大', 'size', 'swell' ) . '(17px)',
		'18px' => _x( '極大', 'size', 'swell' ) . '(18px)',
	],
] );

// フォントサイズ(SP)
Customizer::add( $section, 'post_font_size_sp', [
	'label'     => __( 'フォントサイズ', 'swell' ) . '(Mobile)',
	'type'      => 'select',
	'choices'   => [
		'14px'  => __( '固定サイズ', 'swell' ) . ': ' . _x( '小', 'size', 'swell' ),
		'15px'  => __( '固定サイズ', 'swell' ) . ': ' . _x( '中', 'size', 'swell' ),
		'16px'  => __( '固定サイズ', 'swell' ) . ': ' . _x( '大', 'size', 'swell' ),
		'3.8vw' => __( 'デバイス可変', 'swell' ) . ': ' . _x( '小', 'size', 'swell' ),
		'4vw'   => __( 'デバイス可変', 'swell' ) . ': ' . _x( '中', 'size', 'swell' ),
		'4.2vw' => __( 'デバイス可変', 'swell' ) . ': ' . _x( '大', 'size', 'swell' ),
	],
] );


// 字間
Customizer::add( $section, 'site_letter_space', [
	'label'     => __( '字間', 'swell' ) . '(letter-spacing)',
	'type'      => 'select',
	'choices'   => [
		'normal' => __( '標準', 'swell' ) . ' (normal)',
		'.025em' => '.025em',
		'.05em'  => '.05em',
		'.1em'   => '.1em',
	],
] );


// ■ コンテンツ幅の設定
Customizer::big_title( $section, 'content_width', [
	'label' => __( 'コンテンツ幅の設定', 'swell' ),
] );

// サイト幅の最大値
Customizer::add( $section, 'container_size', [
	'classname'   => '',
	'label'       => __( 'サイト幅', 'swell' ),
	'description' => __( '※ 左右に48pxずつpaddingがつきます。', 'swell' ),
	'type'        => 'number',
	'input_attrs' => [
		'step' => '20',
		'min'  => '400',
	],
	'sanitize'    => 'absint',
] );

// 記事コンテンツ幅の最大値
Customizer::add( $section, 'article_size', [
	'classname'   => '',
	'label'       => __( '１カラム時の記事コンテンツ幅', 'swell' ),
	'description' => __( '※ 左右に32pxずつpaddingがつきます。', 'swell' ),
	'type'        => 'number',
	'input_attrs' => [
		'step' => '20',
		'min'  => '400',
	],
	'sanitize'    => 'absint',
] );



// ■ サブメニューの表示形式
Customizer::big_title( $section, 'submenu_type', [
	'label' => __( 'サブメニューの表示形式', 'swell' ),
] );


// サブメニューをアコーディオン化する
Customizer::add( $section, 'acc_submenu', [
	'classname'   => '',
	'label'       => __( 'サブメニューをアコーディオン化する', 'swell' ),
	'type'        => 'checkbox',
	'description' => __( '※ グローバルナビ・スマホメニュー・ウィジェット内のサブメニューがアコーディンオン式になります。', 'swell' ),

] );


// ■ ページ背景
Customizer::big_title( $section, 'body_bg', [
	'label' => __( 'ページ背景', 'swell' ),
] );

// ページ背景画像(PC)
Customizer::add( $section, 'body_bg', [
	'label' => __( 'ページ背景画像', 'swell' ) . '(PC)',
	'type'  => 'image',
] );

// ページ背景画像(SP)
Customizer::add( $section, 'body_bg_sp', [
	'label' => __( 'ページ背景画像', 'swell' ) . '(SP)',
	'type'  => 'image',
] );

// 画像サイズ(backgrond-sizeの値)
Customizer::add( $section, 'body_bg_size', [
	'classname' => '-bodybg-setting',
	'label'     => __( '画像サイズ(backgrond-sizeの値)', 'swell' ),
	'type'      => 'select',
	'choices'   => [
		''          => __( '設定なし', 'swell' ),
		'100% auto' => __( '横100%', 'swell' ),
		'auto 100%' => __( '縦100%', 'swell' ),
		'contain'   => __( 'contain', 'swell' ),
		'cover'     => __( 'cover', 'swell' ),
	],
] );

// 画像位置(X方向)
Customizer::add( $section, 'body_bg_pos_x', [
	'classname' => '-bodybg-setting -radio-button',
	'label'     => __( '画像位置(X方向)', 'swell' ),
	'type'      => 'radio',
	'choices'   => [
		'left'   => __( '左', 'swell' ),
		'center' => __( '中央', 'swell' ),
		'right'  => __( '右', 'swell' ),
	],
] );

// 画像位置(Y方向)
Customizer::add( $section, 'body_bg_pos_y', [
	'classname' => '-bodybg-setting -radio-button',
	'label'     => __( '画像位置(Y方向)', 'swell' ),
	'type'      => 'radio',
	'choices'   => [
		'top'    => __( '上', 'swell' ),
		'center' => __( '中央', 'swell' ),
		'bottom' => __( '下', 'swell' ),
	],
] );

// その他の設定
Customizer::sub_title( $section, 'body_bg_others', [
	'classname' => '-bodybg-setting',
	'label'     => __( 'その他の設定', 'swell' ),
] );

// 画像ループを無効にする
Customizer::add( $section, 'noloop_body_bg', [
	'classname' => '-bodybg-setting',
	'label'     => __( '画像ループを無効にする', 'swell' ),
	'type'      => 'checkbox',
] );

// 固定表示する（スクロールで動かないようにする）
Customizer::add( $section, 'fix_body_bg', [
	'classname' => '-bodybg-setting',
	'label'     => __( '固定表示する（スクロールで動かないようにする）', 'swell' ),
	'type'      => 'checkbox',
] );
