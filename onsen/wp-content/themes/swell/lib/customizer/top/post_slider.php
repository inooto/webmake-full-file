<?php
use \SWELL_Theme\Customizer;
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'swell_section_post_slider';

/**
 * セクション追加
 */
$wp_customize->add_section( $section, [
	'title'    => __( '記事スライダー', 'swell' ),
	'priority' => 10,
	'panel'    => 'swell_panel_top',
] );


$ps_partial = [
	'selector'            => '#post_slider',
	'container_inclusive' => true,
	'render_callback'     => [ '\SWELL_Theme\Customizer\Partial', 'post_slider' ],
];


// 記事スライダーを設置するかどうか
Customizer::add( $section, 'show_post_slide', [
	'label'   => __( '記事スライダーを設置するかどうか', 'swell' ),
	'type'    => 'radio',
	'choices' => [
		'off' => __( '設置しない', 'swell' ),
		'on'  => __( '設置する', 'swell' ),
	],
	'partial' => $ps_partial,
] );


// ■ 記事のピックアップ方法
Customizer::big_title( $section, 'ps_pickup_tag', [
	'classname' => '',
	'label'     => __( '記事のピックアップ方法', 'swell' ),
] );

// ピックアップ対象
Customizer::add( $section, 'ps_pickup_type', [
	'classname' => '-radio-button -pickup-post',
	'label'     => __( 'ピックアップ対象', 'swell' ),
	'type'      => 'radio',
	'choices'   => [
		'category' => __( 'カテゴリー', 'swell' ),
		'tag'      => __( 'タグ', 'swell' ),
	],

] );

// ピックアップ対象のタグ名
Customizer::add( $section, 'pickup_tag', [
	'classname'   => '-pickup-tag',
	'label'       => __( 'ピックアップ対象のタグ名', 'swell' ),
	'description' => __( '※ 空白の場合、全記事の中から表示します。', 'swell' ),
	'type'        => 'text',
	'sanitize'    => 'wp_filter_nohtml_kses',

] );

// ピックアップ対象のカテゴリーID
Customizer::add( $section, 'pickup_cat', [
	'classname'   => '-pickup-cat',
	'label'       => __( 'ピックアップ対象のカテゴリーID', 'swell' ),
	'description' => __( '※ 空白の場合、全記事の中から表示します。', 'swell' ),
	'type'        => 'number',
	'sanitize'    => [ '\SWELL_Theme\Customizer\Sanitize', 'int' ],

] );

// 並び順
Customizer::add( $section, 'ps_orderby', [
	'label'   => __( '並び順', 'swell' ),
	'type'    => 'select',
	'choices' => [
		'rand'           => __( 'ランダム', 'swell' ),
		'date'           => __( '投稿日', 'swell' ),
		'modified'       => __( '更新日', 'swell' ),
		'meta_value_num' => __( '人気順', 'swell' ),
	],

] );


// ■ 記事の表示設定
Customizer::big_title( $section, 'ps_per_post', [
	'label' => __( '記事の表示設定', 'swell' ),
] );


// タイトルや日付などの表示位置
Customizer::add( $section, 'ps_style', [
	'label'   => __( 'タイトルや日付などの表示位置', 'swell' ),
	'type'    => 'select',
	'choices' => [
		'normal' => __( '画像の下側', 'swell' ),
		'on_img' => __( '画像の上に被せる', 'swell' ),
	],

] );

// カテゴリー表示位置
Customizer::add( $section, 'pickup_cat_pos', [
	'label'   => __( 'カテゴリー表示位置', 'swell' ),
	'type'    => 'select',
	'choices' => [
		'none'     => __( '表示しない', 'swell' ),
		'on_thumb' => __( 'サムネイル画像の上', 'swell' ),
		'on_title' => __( 'タイトルの下', 'swell' ),
	],

] );

// 日付の表示設定
Customizer::sub_title( $section, 'ps_date', [
	'classname' => '',
	'label'     => __( '日付の表示設定', 'swell' ),

] );

// 公開日を表示する
Customizer::add( $section, 'ps_show_date', [
	'label'   => __( '公開日を表示する', 'swell' ),
	'type'    => 'checkbox',

] );

// 更新日を表示する
Customizer::add( $section, 'ps_show_modified', [
	'label'     => __( '更新日を表示する', 'swell' ),
	'type'      => 'checkbox',


] );

// 著者の表示設定
Customizer::sub_title( $section, 'ps_author', [
	'label'   => __( '著者の表示設定', 'swell' ),

] );

// 著者を表示する
Customizer::add( $section, 'ps_show_author', [
	'label'   => __( '著者を表示する', 'swell' ),
	'type'    => 'checkbox',

] );


// ■ スライド設定
Customizer::big_title( $section, 'ps_slider', [
	'label' => __( 'スライド設定', 'swell' ),
] );

// スライダーの枚数設定（PC）
Customizer::add( $section, 'ps_num', [
	'label'       => __( 'スライダーの枚数設定', 'swell' ) . '（PC）',
	'type'        => 'number',
	'input_attrs' => [
		'step'     => '1',
		'min'      => '1',
		'max'      => '6',
	],

] );

// スライダーの枚数設定（SP）
Customizer::add( $section, 'ps_num_sp', [
	'label'       => __( 'スライダーの枚数設定', 'swell' ) . '（SP）',
	'type'        => 'number',
	'input_attrs' => [
		'step' => '0.1',
		'min'  => '1',
		'max'  => '3',
	],

] );

// スライドのアニメーション速度
Customizer::add( $section, 'ps_speed', [
	'label'       => __( 'スライドのアニメーション速度', 'swell' ),
	'type'        => 'number',
	'input_attrs' => [
		'step' => '100',
	],
	'sanitize'    => 'absint',

] );


// スライドが切り替わる間隔
Customizer::add( $section, 'ps_delay', [
	'label'       => __( 'スライドが切り替わる間隔', 'swell' ),
	'type'        => 'number',
	'input_attrs' => [
		'step' => '100',
	],
	'sanitize'    => 'absint',

] );


// その他の設定
Customizer::sub_title( $section, 'ps_other', [
	'label' => __( 'その他の設定', 'swell' ),
] );

// 矢印ナビゲーションを表示する
Customizer::add( $section, 'ps_on_nav', [
	'label'   => __( '矢印ナビゲーションを表示する', 'swell' ),
	'type'    => 'checkbox',

] );

// ページネーションを表示する
Customizer::add( $section, 'ps_on_pagination', [
	'label'   => __( 'ページネーションを表示する', 'swell' ),
	'type'    => 'checkbox',

] );

// スライド間の余白をなくす
Customizer::add( $section, 'ps_no_space', [
	'label'   => __( 'スライド間の余白をなくす', 'swell' ),
	'type'    => 'checkbox',

] );


// ■ その他の表示設定
Customizer::big_title( $section, 'ps_others', [
	'label' => __( 'その他の表示設定', 'swell' ),
] );

// 記事スライダーエリアのタイトル
Customizer::add( $section, 'pickup_title', [
	'label'       => __( '記事スライダーエリアのタイトル', 'swell' ),
	'description' => __( '空白の場合は出力されません。', 'swell' ),
	'type'        => 'text',

] );

// 上下の余白量
Customizer::add( $section, 'pickup_pad_tb', [
	'classname' => '-radio-button',
	'label'     => __( '上下の余白量', 'swell' ),
	'type'      => 'radio',
	'choices'   => [
		'none'   => __( 'なし', 'swell' ),
		'small'  => __( '小', 'swell' ),
		'middle' => __( '中', 'swell' ),
		'wide'   => __( '大', 'swell' ),
	],

] );

// 左右の幅
Customizer::add( $section, 'pickup_pad_lr', [
	'label'       => __( '左右の幅', 'swell' ),
	'description' => __( '※ PCサイズで表示時のみ有効', 'swell' ),
	'type'        => 'select',
	'choices'     => [
		'no'    => __( 'フルワイド', 'swell' ),
		'small' => __( '左右に少し余白あり', 'swell' ),
		'wide'  => __( 'コンテンツ幅に収める', 'swell' ),
	],

] );

// 記事スライダーエリアの文字色
Customizer::add( $section, 'pickup_font_color', [
	'label'       => __( '記事スライダーエリアの文字色', 'swell' ),
	'description' => __( '※ 投稿タイトルや日付情報の位置が「画像の上に被せる」設定の場合は、投稿情報は白色ので表示されます。', 'swell' ),
	'type'        => 'color',

] );

// 記事スライダーエリアの背景色
Customizer::add( $section, 'ps_bg_color', [
	'label'   => __( '記事スライダーエリアの背景色', 'swell' ),
	'type'    => 'color',

] );

// 記事スライダーエリアの背景画像
Customizer::add( $section, 'ps_bgimg_id', [
	'label'     => __( '記事スライダーエリアの背景画像', 'swell' ),
	'type'      => 'media',
	'mime_type' => 'image',

] );

$ps_bgimg_id = SWELL_Theme::get_setting( 'ps_bgimg_id' );
if ( Customizer::is_non_existent_media_id( $ps_bgimg_id ) ) {
	Customizer::add( $section, 'ps_bgimg_id_clear', [
		'type'      => 'clear-media',
		'target_id' => 'ps_bgimg_id',
	] );
}

// 古いデータ残っている場合
if ( ! $ps_bgimg_id && \SWELL_Theme::get_setting( 'bg_pickup' ) ) {
	Customizer::add( $section, 'bg_pickup', [
		'type'        => 'old-image',
		'label'       => __( '記事スライダーエリアの背景画像', 'swell' ),
	] );
}


// 背景画像の透過設定
Customizer::add( $section, 'ps_img_opacity', [
	'label'       => __( '背景画像の透過設定', 'swell' ),
	'description' => __( '不透明度を指定（CSSのopacityプロパティの値）', 'swell' ),
	'type'        => 'number',
	'input_attrs' => [
		'step' => '0.1',
		'min'  => '0',
		'max'  => '1',
	],

] );
