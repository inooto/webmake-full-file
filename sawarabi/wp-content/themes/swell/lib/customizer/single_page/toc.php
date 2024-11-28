<?php
use \SWELL_Theme\Customizer;
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'swell_section_toc';

/**
 * セクション追加
 */
$wp_customize->add_section( $section, [
	'title'    => __( '目次', 'swell' ),
	'priority' => 10,
	'panel'    => 'swell_panel_single_page',
] );

// 目次を表示するかどうか
Customizer::sub_title( $section, 'is_show_index', [
	'label'       => __( '目次を表示するかどうか', 'swell' ),
	'description' => __( '目次を最初のH2タグの直前に自動生成することができます。', 'swell' ),
] );

// 投稿ページに目次を表示
Customizer::add( $section, 'show_index', [
	'label' => __( '投稿ページに目次を表示', 'swell' ),
	'type'  => 'checkbox',
] );

// 固定ページに目次を表示
Customizer::add( $section, 'show_index_page', [
	'label' => __( '固定ページに目次を表示', 'swell' ),
	'type'  => 'checkbox',
] );

// 目次のタイトル
Customizer::add( $section, 'toc_title', [
	'label' => __( '目次のタイトル', 'swell' ),
	'type'  => 'text',
] );

// 目次のデザイン
Customizer::add( $section, 'index_style', [
	'label'   => __( '目次のデザイン', 'swell' ),
	'type'    => 'select',
	'choices' => [
		'simple'  => __( 'シンプル', 'swell' ),
		'capbox'  => __( 'ボックス', 'swell' ),
		'border'  => __( '上下ボーダー', 'swell' ),
		'double'  => __( 'ストライプ背景', 'swell' ),
	],
] );

// 目次のリストタグ
Customizer::add( $section, 'index_list_tag', [
	'classname' => '-radio-button',
	'label'     => __( '目次のリストタグ', 'swell' ),
	'type'      => 'radio',
	'choices'   => [
		'ol' => __( 'olタグ', 'swell' ),
		'ul' => __( 'ulタグ', 'swell' ),
	],
] );

// 擬似要素(ドット・数字部分)のカラー
Customizer::add( $section, 'toc_before_color', [
	'label'   => __( '擬似要素(ドット・数字部分)のカラー', 'swell' ),
	'type'    => 'select',
	'choices' => [
		'text'   => __( 'テキストカラー', 'swell' ),
		'main'   => __( 'メインカラー', 'swell' ),
		'custom' => __( 'カスタムカラー', 'swell' ),
	],
] );

Customizer::add( $section, 'toc_before_custom_color', [
	'classname' => '-toc-custom-color',
	'type'      => 'color',
] );


// どの階層の見出しまで抽出するか
Customizer::add( $section, 'toc_target', [
	'label'   => __( 'どの階層の見出しまで抽出するか', 'swell' ),
	'type'    => 'select',
	'choices' => [
		'h2' => 'h2',
		'h3' => 'h3',
		'h4' => 'h4',
		'h5' => 'h5',
	],
] );


// 見出しが何個以あれば表示するか
Customizer::add( $section, 'toc_minnum', [
	'label'       => __( '見出し何個以上で表示するか', 'swell' ),
	'type'        => 'number',
	'input_attrs' => [
		'step'    => '1',
		'min'     => '1',
		'max'     => '10',
	],
	'sanitize'    => [ '\SWELL_Theme\Customizer\Sanitize', 'int' ],
] );


Customizer::add( $section, 'toc_omit_type', [
	'label'   => __( '目次の省略表示', 'swell' ),
	'type'    => 'select',
	'choices' => [
		''        => __( '省略しない', 'swell' ),
		'ct'      => __( '指定の数を超えた分を省略する', 'swell' ),
		'nest'    => __( 'h3以下を省略する', 'swell' ),
		'both'    => __( '指定の数を超えた分 + h3以下を省略する', 'swell' ),
	],
] );


Customizer::add( $section, 'toc_omit_num', [
	'label'       => __( '項目が何個を超えると省略するか', 'swell' ),
	'type'        => 'number',
	'input_attrs' => [
		'step'    => '1',
		'min'     => '1',
		'max'     => '99',
	],
	'description' => __( '※ 目次の項目数が「指定した数 + 1」個の時は省略されません。', 'swell' ),
	'sanitize'    => [ '\SWELL_Theme\Customizer\Sanitize', 'int' ],
] );


Customizer::add( $section, 'toc_open_text', [
	'label' => __( '開くボタンのテキスト', 'swell' ),
	'type'  => 'text',
] );

Customizer::add( $section, 'toc_close_text', [
	'label' => __( '閉じるボタンのテキスト', 'swell' ),
	'type'  => 'text',
] );

// ■ 目次広告の表示設定
Customizer::big_title( $section, 'toc_ad', [
	'label'       => __( '目次広告の表示設定', 'swell' ),
	'description' => sprintf( __( '<a href="%s" target="_blank">「SWELL設定」</a>から広告コードを設定すると表示されます。', 'swell' ), admin_url( 'admin.php?page=swell_settings#ad' ) ),
] );


// 目次広告の位置
Customizer::add( $section, 'toc_ad_position', [
	'label'   => __( '目次広告の位置', 'swell' ),
	'type'    => 'select',
	'choices' => [
		'before' => __( '目次の前に設置する', 'swell' ),
		'after'  => __( '目次の後に設置する', 'swell' ),
	],
] );

Customizer::sub_title( $section, 'toc_ad_code', [
	'label'       => __( '目次がなくても広告を表示するかどうか', 'swell' ),
	'description' => __( '※ 1つ目のh2タグの前に表示されます。', 'swell' ),
] );

Customizer::add( $section, 'show_toc_ad_alone_post', [
	'label' => __( '投稿ページで表示する', 'swell' ),
	'type'  => 'checkbox',
] );

Customizer::add( $section, 'show_toc_ad_alone_page', [
	'label' => __( '固定ページで表示する', 'swell' ),
	'type'  => 'checkbox',
] );
