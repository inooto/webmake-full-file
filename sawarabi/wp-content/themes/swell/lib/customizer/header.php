<?php
use \SWELL_Theme\Customizer;

if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'swell_section_header';

/**
 * セクション追加
 */
$wp_customize->add_section( $section, [
	'title'    => __( 'ヘッダー', 'swell' ),
	'priority' => 3,
] );


// ■ カラー設定
Customizer::big_title( $section, 'header_color', [
	'label' => __( 'カラー設定', 'swell' ),
] );

// ヘッダー背景色
Customizer::add( $section, 'color_header_bg', [
	'label' => __( 'ヘッダー背景色', 'swell' ),
	'type'  => 'color',
] );

// ヘッダー文字色
Customizer::add( $section, 'color_header_text', [
	'label' => __( 'ヘッダー文字色', 'swell' ),
	'type'  => 'color',
] );


// ■ ヘッダーロゴの設定
Customizer::big_title( $section, 'header_logo', [
	'label' => __( 'ヘッダーロゴの設定', 'swell' ),
] );

// ロゴ画像の設定
Customizer::add( $section, 'logo_id', [
	'label'     => __( 'ロゴ画像の設定', 'swell' ),
	'type'      => 'media',
	'mime_type' => 'image',
	'partial'   => [
		'selector'            => '.c-headLogo',
		'container_inclusive' => true,
		'render_callback'     => [ '\SWELL_Theme\Customizer\Partial', 'head_logo' ],
	],
] );

$logo_id = \SWELL_Theme::get_setting( 'logo_id' );

// デモデータインポート時など、無効なロゴIDを持つ場合はテキストフォームで削除できるようにする
if ( Customizer::is_non_existent_media_id( $logo_id ) ) {
	Customizer::add( $section, 'logo_id_clear', [
		'type'      => 'clear-media',
		'target_id' => 'logo_id',
	] );
}

// 古いデータ残っている場合
if ( ! $logo_id && \SWELL_Theme::get_setting( 'logo' ) ) {
	Customizer::add( $section, 'logo', [
		'type'        => 'old-image',
		'label'       => __( 'ロゴ画像', 'swell' ),
	] );
}

// 画像サイズ（PC）
$logo_size_label = __( '画像サイズ', 'swell' );
Customizer::add( $section, 'logo_size_pc', [
	'label'       => $logo_size_label,
	'description' => $logo_size_label . '(PC): 32~120px',
	'type'        => 'number',
	'input_attrs' => [
		'step'    => '1',
		'min'     => '32',
		'max'     => '120',
	],
	'sanitize'    => [ '\SWELL_Theme\Customizer\Sanitize', 'int' ],
] );

// 画像サイズ（PC追従ヘッダー）
Customizer::add( $section, 'logo_size_pcfix', [
	'description' => $logo_size_label . '(PC追従ヘッダー内) : 24~48px',
	'type'        => 'number',
	'input_attrs' => [
		'step'    => '1',
		'min'     => '24',
		'max'     => '48',
	],
	'sanitize'    => [ '\SWELL_Theme\Customizer\Sanitize', 'int' ],
] );

// 画像サイズ（SP）
Customizer::add( $section, 'logo_size_sp', [
	// 'label' => '画像サイズ（SP）',
	'description' => $logo_size_label . '(sp): 40~80px',
	'type'        => 'number',
	'input_attrs' => [
		'step'    => '1',
		'min'     => '40',
		'max'     => '80',
	],
	'sanitize'    => [ '\SWELL_Theme\Customizer\Sanitize', 'int' ],
] );


// ■ レイアウト・デザイン設定
Customizer::big_title( $section, 'header_layout', [
	'label' => __( 'レイアウト・デザイン設定', 'swell' ),
] );

// ヘッダーのレイアウト(PC)
Customizer::add( $section, 'header_layout', [
	'label'       => __( 'ヘッダーのレイアウト', 'swell' ) . '(PC)',
	'type'        => 'select',
	'choices'     => [
		'series_right'    => __( 'ヘッダーナビをロゴの横に（右寄せ）', 'swell' ),
		'series_left'     => __( 'ヘッダーナビをロゴの横に（左寄せ）', 'swell' ),
		'parallel_bottom' => __( 'ヘッダーナビを下に', 'swell' ),
		'parallel_top'    => __( 'ヘッダーナビを上に', 'swell' ),
	],
] );

// ヘッダーのレイアウト(SP)
Customizer::add( $section, 'header_layout_sp', [
	'label'   => __( 'ヘッダーのレイアウト', 'swell' ) . '(SP)',
	'type'    => 'select',
	'choices' => [
		'left_right'    => __( 'ロゴ：左 / メニュー：右', 'swell' ),
		'center_right'  => __( 'ロゴ:中央 / メニュー：右', 'swell' ),
		'center_left'   => __( 'ロゴ:中央 / メニュー：左', 'swell' ),
	],
] );

// ヘッダー境界線
Customizer::add( $section, 'header_border', [
	'label'   => __( 'ヘッダー境界線', 'swell' ),
	'type'    => 'select',
	'choices' => [
		''       => __( 'なし', 'swell' ),
		'border' => __( '線', 'swell' ),
		'shadow' => __( '影', 'swell' ),
	],
] );


// ■ トップページでの特別設定
Customizer::big_title( $section, 'top_header', [
	'label'       => __( 'トップページでの特別設定', 'swell' ),
	'description' => __( '※ この設定を使う場合、PCのヘッダーレイアウトは横並びにしてください。', 'swell' ),
] );

// ヘッダーの背景を透明にするかどうか
Customizer::add( $section, 'header_transparent', [
	'label'   => __( 'ヘッダーの背景を透明にするかどうか', 'swell' ),
	'type'    => 'select',
	'choices' => [
		'no'     => __( 'しない', 'swell' ),
		't_fff'  => __( 'する(文字色：白)', 'swell' ),
		't_000'  => __( 'する(文字色：黒)', 'swell' ),
	],
] );

// 透過時のロゴ画像
Customizer::add( $section, 'logo_top_id', [
	'classname' => '-top-header-setting',
	'label'     => __( '透過時のロゴ画像', 'swell' ),
	'type'      => 'media',
	'mime_type' => 'image',
	'partial'   => [
		'selector'            => '.c-headLogo',
		'container_inclusive' => true,
		'render_callback'     => [ '\SWELL_Theme\Customizer\Partial', 'head_logo' ],
	],
] );

$logo_top_id = SWELL_Theme::get_setting( 'logo_top_id' );
if ( Customizer::is_non_existent_media_id( $logo_top_id ) ) {
	Customizer::add( $section, 'logo_top_id_clear', [
		'type'      => 'clear-media',
		'target_id' => 'logo_top_id',
	] );
}

// 古いデータ残っている場合
if ( ! $logo_top_id && \SWELL_Theme::get_setting( 'logo_top' ) ) {
	Customizer::add( $section, 'logo_top', [
		'type'        => 'old-image',
		'label'       => __( '透過時のロゴ画像', 'swell' ),
	] );
}



// ■ ヘッダーの追従設定
Customizer::big_title( $section, 'fix_head', [
	'label' => __( 'ヘッダーの追従設定', 'swell' ),
] );

// ヘッダーを追従させる（PC）
Customizer::add( $section, 'fix_header', [
	'label'   => __( 'ヘッダーを追従させる', 'swell' ) . '（PC）',
	'type'    => 'checkbox',
] );

// ヘッダーを追従させる（SP）
Customizer::add( $section, 'fix_header_sp', [
	'label'   => __( 'ヘッダーを追従させる', 'swell' ) . '（SP）',
	'type'    => 'checkbox',
] );

// 追従ヘッダー（PC）の背景不透明度
Customizer::add( $section, 'fix_header_opacity', [
	'classname'   => '-fixhead-pc-setting',
	'label'       => __( '追従ヘッダー（PC）の背景不透明度', 'swell' ),
	'description' => __( '（CSSのopacityプロパティの値を指定してください）', 'swell' ),
	'type'        => 'number',
	'input_attrs' => [
		'step' => '0.1',
		'min'  => '0',
		'max'  => '1',
	],
] );


// ■ ヘッダーバー設定
Customizer::big_title( $section, 'headbar', [
	'label'       => __( 'ヘッダーバー設定', 'swell' ),
	'description' => __( '※ 「ヘッダーバー」はPC表示中にのみ表示されます。', 'swell' ),
] );

// ヘッダーバー背景色
Customizer::add( $section, 'color_head_bar_bg', [
	'label'       => __( 'ヘッダーバー背景色', 'swell' ),
	'description' => __( '※ 色を指定しない場合はメインカラーが適用されます。', 'swell' ),
	'type'        => 'color',
] );

// ヘッダーバー文字色
Customizer::add( $section, 'color_head_bar_text', [
	'label'   => __( 'ヘッダーバー文字色', 'swell' ),
	'type'    => 'color',
] );


// 表示設定
Customizer::sub_title( $section, 'headbar_content', [
	'classname' => '',
	'label'     => __( '表示設定', 'swell' ),
] );

// SNSアイコンリストを表示する
Customizer::add( $section, 'show_icon_list', [
	'label'   => __( 'SNSアイコンリストを表示する', 'swell' ),
	'type'    => 'checkbox',
] );

// コンテンツが空でもボーダーとして表示する
Customizer::add( $section, 'show_head_border', [
	'label'   => __( 'コンテンツが空でもボーダーとして表示する', 'swell' ),
	'type'    => 'checkbox',
] );


// ■ キャッチフレーズ設定
Customizer::big_title( $section, 'phrase', [
	'label' => __( 'キャッチフレーズ設定', 'swell' ),
] );

// キャッチフレーズの表示位置
Customizer::add( $section, 'phrase_pos', [
	'label'   => __( 'キャッチフレーズの表示位置', 'swell' ),
	'type'    => 'select',
	'choices' => [
		'none'      => __( '表示しない', 'swell' ),
		'head_bar'  => __( 'ヘッダーバーに表示', 'swell' ),
		'head_wrap' => __( 'ヘッダーロゴの近くに表示', 'swell' ),
	],
] );

// キャッチフレーズにタイトル表示
Customizer::add( $section, 'show_title', [
	'label' => sprintf( __( 'キャッチフレーズに「| %s」を表示する', 'swell' ), \SWELL_Theme::site_data( 'title' ) ),
	'type'  => 'checkbox',
] );


// ■ ヘッダーメニュー（グローバルナビ）設定
Customizer::big_title( $section, 'head_menu_pc', [
	'label' => __( 'ヘッダーメニュー（グローバルナビ）設定', 'swell' ),
] );

// マウスホバーエフェクト
Customizer::add( $section, 'headmenu_effect', [
	'label'   => __( 'マウスホバーエフェクト', 'swell' ),
	'type'    => 'select',
	'choices' => [
		'line_center' => __( 'ラインの出現（中央から）', 'swell' ),
		'line_left'   => __( 'ラインの出現（左から）', 'swell' ),
		'block'       => __( 'ブロックの出現', 'swell' ),
		'bg_gray'     => __( '背景グレー', 'swell' ),
		'bg_light'    => __( '背景明るく', 'swell' ),
	],
] );

// ホバー時に出てくるラインの色
Customizer::add( $section, 'color_head_hov', [
	'classname'   => '-radio-button -gnav-line-setting',
	'label'       => __( 'ホバー時に出てくるラインの色', 'swell' ),
	'description' => __( '※ 背景色が設定されている場合は白色になります。', 'swell' ),
	'type'        => 'radio',
	'choices'     => [
		'main'  => __( 'メインカラー', 'swell' ),
		'text'  => __( 'テキストカラー', 'swell' ),
	],
] );

// ヘッダーメニューの背景色
Customizer::add( $section, 'gnav_bg_type', [
	'classname'   => '-gnav-bg-type',
	'label'       => __( 'ヘッダーメニューの背景色', 'swell' ),
	'description' => __( '※ PCではヘッダーのレイアウトが縦並びの時に有効です。', 'swell' ),
	'type'        => 'radio',
	'choices'     => [
		'default'    => __( '背景色は設定しない', 'swell' ),
		'overwrite'  => __( '色を指定する', 'swell' ),
	],
] );

// ヘッダーメニュー背景色
Customizer::add( $section, 'color_gnav_bg', [
	'classname'   => '-gnav-bg-setting',
	// 'label'   => __( 'ヘッダーメニュー背景色', 'swell' ),
	'description' => __( '色指定が空の時はメインカラーと同じ色になります。', 'swell' ),
	'type'        => 'color',
] );

// サブメニューの背景色
Customizer::add( $section, 'head_submenu_bg', [
	'classname' => '-radio-button',
	'label'     => __( 'サブメニューの背景色', 'swell' ),
	'type'      => 'radio',
	'choices'   => [
		'white' => __( 'ホワイト', 'swell' ),
		'main'  => __( 'メインカラー', 'swell' ),
	],
] );


// ■ ヘッダーメニュー（SP）設定
Customizer::big_title( $section, 'sp_head_menu', [
	'label' => __( 'ヘッダーメニュー（SP）設定', 'swell' ),
] );

// スマホ表示時のループ設定
Customizer::sub_title( $section, 'sp_headmenu_loop', [
	'label' => __( 'スマホ表示時のループ設定', 'swell' ),
] );

// ヘッダーメニューをループさせる
Customizer::add( $section, 'sp_head_nav_loop', [
	'label' => __( 'ヘッダーメニューをループさせる', 'swell' ),
	'type'  => 'checkbox',
] );


// ■ 検索ボタン設定
Customizer::big_title( $section, 'head_search_btn', [
	'label' => __( '検索ボタン設定', 'swell' ),
] );

// 検索ボタンの表示位置（PC）
Customizer::add( $section, 'search_pos', [
	'label'   => __( '検索ボタンの表示位置', 'swell' ) . '（PC）',
	'type'    => 'select',
	'choices' => [
		'none'      => __( '表示しない', 'swell' ),
		'head_bar'  => __( 'ヘッダーバー内のアイコンリストに表示', 'swell' ),
		'head_menu' => __( 'ヘッダーメニューに表示', 'swell' ),
	],
] );

// 検索ボタンの表示設定（SP）
Customizer::add( $section, 'search_pos_sp', [
	'label'   => __( '検索ボタンの表示設定', 'swell' ) . '（SP）',
	'type'    => 'select',
	'choices' => [
		'none'   => __( '表示しない', 'swell' ),
		'header' => __( 'カスタムボタンにセット', 'swell' ),
	],
] );


// ■ メニューボタン設定
Customizer::big_title( $section, 'menu_btn', [
	'label'       => __( 'メニューボタン設定', 'swell' ),
	'description' => __( 'スマホで表示される <code><i class="icon icon-menu-thin"></i></code> ボタンに関する設定', 'swell' ),
] );

// アイコン下に表示するテキスト
Customizer::add( $section, 'menu_btn_label', [
	'label' => __( 'アイコン下に表示するテキスト', 'swell' ),
	'type'  => 'text',
] );

// メニューボタン背景色
Customizer::add( $section, 'menu_btn_bg', [
	'label' => __( 'メニューボタン背景色', 'swell' ),
	'type'  => 'color',
] );


// ■ カスタムボタン設定
Customizer::big_title( $section, 'custom_btn', [
	'label'       => __( 'カスタムボタン設定', 'swell' ),
	'description' => __( '※ デフォルトでは検索ボタンがセットされています。', 'swell' ),
] );

// アイコンクラス名
Customizer::add( $section, 'custom_btn_icon', [
	'label'       => __( 'アイコンクラス名', 'swell' ),
	'description' => '<small>' . __( '（<a href="https://swell-theme.com/icon-demo/" target="_blank">アイコン一覧はこちら</a>）', 'swell' ) . '</small>',
	'type'        => 'text',
	'sanitize'    => 'wp_filter_nohtml_kses',
] );

// アイコン下に表示するテキスト
Customizer::add( $section, 'custom_btn_label', [
	'label' => __( 'アイコン下に表示するテキスト', 'swell' ),
	'type'  => 'text',
] );

// カスタムボタン背景色
Customizer::add( $section, 'custom_btn_bg', [
	'label' => __( 'カスタムボタン背景色', 'swell' ),
	'type'  => 'color',
] );

// リンク先URL
Customizer::add( $section, 'custom_btn_url', [
	'label'       => __( 'リンク先URL', 'swell' ),
	'description' => '<small>' . __( '※検索ボタンがカスタムボタンにセットされている場合は無効', 'swell' ) . '</small>',
	'type'        => 'text',
	'sanitize'    => 'wp_filter_nohtml_kses',
] );
