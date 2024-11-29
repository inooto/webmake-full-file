<?php
use \SWELL_Theme\Customizer;
if ( ! defined( 'ABSPATH' ) ) exit;

// ■ 画像スライダー設定
Customizer::big_title( $section, 'mv_slider', [
	'classname'   => 'swell-mv-slider -slider-area-bigttl',
	'label'       => __( '画像スライダー設定', 'swell' ),
	'description' => __( '※ スライド画像を<b>２枚以上設定すると</b>、追加の設定が出現します。', 'swell' ),
] );



// スライドの切り替えアニメーション
Customizer::add( $section, 'mv_slide_effect', [
	'classname' => 'swell-mv-slider -mv-slider-setting -radio-button',
	'label'     => __( 'スライドの切り替えアニメーション', 'swell' ),
	'type'      => 'radio',
	'choices'   => [
		'fade'  => __( 'フェード', 'swell' ),
		'slide' => __( 'スライド', 'swell' ),
	],
] );

// スライドの表示中アニメーション
Customizer::add( $section, 'mv_slide_animation', [
	'classname' => 'swell-mv-slider -mv-slider-setting -radio-button',
	'label'     => __( 'スライドの表示中アニメーション', 'swell' ),
	'type'      => 'radio',
	'choices'   => [
		'no'          => __( 'なし', 'swell' ),
		'zoomUp'      => __( 'ズームイン', 'swell' ),
		'leftToRight' => __( '左から右へ', 'swell' ),
	],
] );

// スライドの切り替わり速度
Customizer::add( $section, 'mv_slide_speed', [
	'classname'   => 'swell-mv-slider -mv-slider-setting',
	'label'       => __( 'スライドの切り替わり速度', 'swell' ),
	'type'        => 'number',
	'sanitize'    => 'absint',
	'input_attrs' => [
		'step'     => '100',
	],
] );

// スライドが切り替わる間隔
Customizer::add( $section, 'mv_slide_delay', [
	'classname'   => 'swell-mv-slider -mv-slider-setting',
	'label'       => __( 'スライドが切り替わる間隔', 'swell' ),
	'type'        => 'number',
	'sanitize'    => 'absint',
	'input_attrs' => [
		'step'     => '100',
	],
] );

// スライドの表示枚数
Customizer::add( $section, 'mv_slide_num', [
	'classname'   => 'swell-mv-slider -mv-slider-setting',
	'label'       => __( 'スライドの表示枚数', 'swell' ),
	'description' => '<small>' . __( '(1より大きい時、スライドの切り替えは「スライド」となります)', 'swell' ) . '</>',
	'type'        => 'number',
	'input_attrs' => [
		'step'     => '0.1',
		'min'      => '1',
		'max'      => '3',
	],
] );

// スライドの表示枚数（SP）
Customizer::add( $section, 'mv_slide_num_sp', [
	'classname'   => 'swell-mv-slider -mv-slider-setting',
	'label'       => __( 'スライドの表示枚数（SP）', 'swell' ),
	'description' => '<small>' . __( '(1より大きい時、スライドの切り替えは「スライド」となります)', 'swell' ) . '</>',
	'type'        => 'number',
	'input_attrs' => [
		'step'     => '0.1',
		'min'      => '1',
		'max'      => '3',
	],
] );

// ナビゲーションの表示設定
Customizer::sub_title( $section, 'mv_slider_nav', [
	'classname' => 'swell-mv-slider -mv-slider-setting',
	'label'     => __( 'ナビゲーションの表示設定', 'swell' ),
] );

// 矢印ナビゲーションを表示する
Customizer::add( $section, 'mv_on_nav', [
	'classname' => 'swell-mv-slider -mv-slider-setting',
	'label'     => __( '矢印ナビゲーションを表示する', 'swell' ),
	'type'      => 'checkbox',
] );

// ページネーションを表示する
Customizer::add( $section, 'mv_on_pagination', [
	'classname' => 'swell-mv-slider -mv-slider-setting',
	'label'     => __( 'ページネーションを表示する', 'swell' ),
	'type'      => 'checkbox',
] );

// テキストの固定表示設定
Customizer::sub_title( $section, 'mv_fix_text', [
	'classname' => 'swell-mv-slider -mv-slider-setting',
	'label'     => __( 'テキストの固定表示設定', 'swell' ),
] );

// テキストの固定表示
Customizer::add( $section, 'mv_fix_text', [
	'classname' => 'swell-mv-slider -mv-slider-setting',
	'label'     => __( 'スライド１枚目のテキストを常に表示する', 'swell' ),
	'type'      => 'checkbox',
] );

// ■ 各スライドの設定
Customizer::big_title( $section, 'mv_per_slide', [
	'classname' => 'swell-mv-slider',
	'label'     => __( '各スライドの設定', 'swell' ),
] );

for ( $i = 1; $i < 6; $i++ ) {  // Setting
	Customizer::sub_title( $section, "mv_subttl_slider{$i}", [
		'classname' => "swell-mv-slider -on-border -slide-num-{$i}",
		'label'     => "スライド[{$i}]",
	] );

	// スライド画像 PC
	Customizer::add( $section, "slider{$i}_imgid", [
		'classname' => "swell-mv-slider -ttl-mt-small -slide-num-{$i}",
		'label'     => __( 'スライド画像', 'swell' ) . '[' . $i . ']（PC）',
		'type'      => 'media',
		'mime_type' => 'image',
	] );

	$slider_imgid = SWELL_Theme::get_setting( "slider{$i}_imgid" );
	if ( Customizer::is_non_existent_media_id( $slider_imgid ) ) {
		Customizer::add( $section, "slider{$i}_imgid_clear", [
			'type'      => 'clear-media',
			'target_id' => "slider{$i}_imgid",
		] );
	}

	// 古いデータ残っている場合
	if ( ! $slider_imgid && \SWELL_Theme::get_setting( "slider{$i}_img" ) ) {
		Customizer::add( $section, "slider{$i}_img", [
			'type'        => 'old-image',
			'label'       => __( 'スライド画像', 'swell' ) . '[' . $i . ']（PC）',
		] );
	}


	// スライド画像 SP
	Customizer::add( $section, "slider{$i}_imgid_sp", [
		'classname' => "swell-mv-slider -ttl-mt-small -slide-num-{$i}",
		'label'     => __( 'スライド画像', 'swell' ) . '[' . $i . ']（SP）',
		'type'      => 'media',
		'mime_type' => 'image',
	] );

	$slider_imgid_sp = SWELL_Theme::get_setting( "slider{$i}_imgid_sp" );
	if ( Customizer::is_non_existent_media_id( $slider_imgid_sp ) ) {
		Customizer::add( $section, "slider{$i}_imgid_sp_clear", [
			'type'      => 'clear-media',
			'target_id' => "slider{$i}_imgid_sp",
		] );
	}

	// 古いデータ残っている場合
	if ( ! $slider_imgid_sp && \SWELL_Theme::get_setting( "slider{$i}_img_sp" ) ) {
		Customizer::add( $section, "slider{$i}_img_sp", [
			'type'        => 'old-image',
			'label'       => __( 'スライド画像', 'swell' ) . '[' . $i . ']（SP）',
		] );
	}


	// メインテキスト
	Customizer::add( $section, "slider{$i}_title", [
		'classname' => "swell-mv-slider -ttl-mt-small -slide-num-{$i}",
		'label'     => __( 'メインテキスト', 'swell' ) . '[' . $i . ']',
		'type'      => 'text',
	] );

	// サブテキスト
	Customizer::add( $section, "slider{$i}_text", [
		'classname' => "swell-mv-slider -ttl-mt-small -slide-num-{$i}",
		'label'     => __( 'サブテキスト', 'swell' ) . '[' . $i . ']',
		'type'      => 'textarea',
	] );

	// ブログパーツID
	Customizer::add( $section, "slider{$i}_parts_id", [
		'classname' => "swell-mv-slider -ttl-mt-small -slide-num-{$i}",
		'label'     => __( 'ブログパーツID', 'swell' ) . '[' . $i . ']',
		'type'      => 'text',
	] );

	// スライドalt
	Customizer::add( $section, "slider{$i}_alt", [
		'classname' => "swell-mv-slider -ttl-mt-small -slide-num-{$i}",
		'label'     => __( 'alt属性値', 'swell' ) . '[' . $i . ']',
		'type'      => 'text',
		'sanitize'  => 'sanitize_text_field',
	] );

	// リンク先URL
	Customizer::add( $section, "slider{$i}_url", [
		'classname' => "swell-mv-slider -ttl-mt-small -slide-num-{$i}",
		'label'     => __( 'リンク先URL', 'swell' ) . '[' . $i . ']',
		'type'      => 'text',
		'sanitize'  => 'esc_url_raw',
	] );

	// ボタンテキスト
	Customizer::add( $section, "slider{$i}_btn_text", [
		'classname' => "swell-mv-slider -ttl-mt-small -slide-num-{$i}",
		'label'     => __( 'ボタンテキスト', 'swell' ) . '[' . $i . ']',
		'type'      => 'text',
	] );

	// テキストの位置
	Customizer::add( $section, "slider{$i}_txtpos", [
		'classname'   => "swell-mv-slider -radio-button -ttl-mt-small -slide-num-{$i}",
		'label'       => "テキストの位置 [{$i}]",
		'description' => __( '※ ブログパーツの中には適用されません。', 'swell' ),
		'type'        => 'radio',
		'choices'     => [
			'l' => __( '左', 'swell' ),
			'c' => __( '中央', 'swell' ),
			'r' => __( '右', 'swell' ),
		],
	] );

	// テキストカラー
	Customizer::add( $section, "slider{$i}_txtcol", [
		'classname' => "swell-mv-slider -ttl-mt-small -slide-num-{$i}",
		'label'     => __( 'テキストカラー', 'swell' ) . '[' . $i . ']',
		'type'      => 'color',
	] );

	// テキストシャドウカラー
	Customizer::add( $section, "slider{$i}_shadowcol", [
		'classname' => "swell-mv-slider -ttl-mt-small -slide-num-{$i}",
		'label'     => __( 'テキストシャドウカラー', 'swell' ) . '[' . $i . ']',
		'type'      => 'color',
	] );

	// ボタンカラー
	Customizer::add( $section, "slider{$i}_btncol", [
		'classname' => "swell-mv-slider -ttl-mt-small -slide-num-{$i}",
		'label'     => __( 'ボタンカラー', 'swell' ) . '[' . $i . ']',
		'type'      => 'color',
	] );

	// ボタンタイプ
	Customizer::add( $section, "slider{$i}_btntype", [
		'classname' => "swell-mv-slider -radio-button -ttl-mt-small -slide-num-{$i}",
		'label'     => __( 'ボタンタイプ', 'swell' ) . '[' . $i . ']',
		'type'      => 'radio',
		'choices'   => [
			'n' => __( '白抜き', 'swell' ),
			'b' => __( 'ボーダー', 'swell' ),
		],
	] );
}
