<?php
use \SWELL_Theme\Customizer;
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * セクション追加
 */
$section = 'swell_section_post_list';

$wp_customize->add_section( $section, [
	'title'    => __( '記事一覧リスト', 'swell' ),
	'priority' => 4,
] );


// ■ リストのレイアウト設定
Customizer::big_title( $section, 'post_list_layout', [
	'label' => __( 'リストのレイアウト設定', 'swell' ),
] );

// リストレイアウト（PC/Tab）
Customizer::add( $section, 'post_list_layout', [
	'label'   => __( 'リストレイアウト', 'swell' ) . ' (PC/Tab)',
	'type'    => 'select',
	'choices' => \SWELL_Theme::$list_layouts,
] );

// リストレイアウト（Mobile）
Customizer::add( $section, 'post_list_layout_sp', [
	'label'   => __( 'リストレイアウト', 'swell' ) . '(SP)',
	'type'    => 'select',
	'choices' => \SWELL_Theme::$list_layouts,
] );

// 最大カラム数（PC/Tab）
Customizer::add( $section, 'max_column', [
	'classname'   => '-radio-button',
	'label'       => __( '最大カラム数', 'swell' ) . '(PC/Tab)',
	'description' => __( '※ カード型・サムネイル型でのみ有効です。', 'swell' ),
	'type'        => 'radio',
	'choices'     => [
		'1' => sprintf( __( '%dカラム', 'swell' ), 1 ),
		'2' => sprintf( __( '%dカラム', 'swell' ), 2 ),
		'3' => sprintf( __( '%dカラム', 'swell' ), 3 ),
	],
] );

// 最大カラム数（Mobile）
Customizer::add( $section, 'max_column_sp', [
	'classname'   => '-radio-button',
	'label'       => __( '最大カラム数', 'swell' ) . '(Mobile)',
	'description' => __( '※ カード型・サムネイル型でのみ有効です。', 'swell' ),
	'type'        => 'radio',
	'choices'     => [
		'1' => sprintf( __( '%dカラム', 'swell' ), 1 ),
		'2' => sprintf( __( '%dカラム', 'swell' ), 2 ),
	],
] );

// 「READ MORE」のテキスト
Customizer::add( $section, 'post_list_read_more', [
	'classname'   => '-radio-button',
	'label'       => __( '「READ MORE」のテキスト', 'swell' ),
	'description' => __( 'ブログ型・リスト型（左右交互）で表示される「READ MORE」の表示を変更します', 'swell' ),
	'type'        => 'text',
] );


// ■ 投稿情報の表示設定
Customizer::big_title( $section, 'post_list_design', [
	'label' => __( '投稿情報の表示設定', 'swell' ),
] );

// タイトルを隠す
Customizer::add( $section, 'hide_post_ttl', [
	'label'       => __( 'タイトルを隠す', 'swell' ),
	'description' => __( '※ 「サムネイル型」のリストにのみ有効です。', 'swell' ),
	'type'        => 'checkbox',
] );

// 公開日を表示する
Customizer::add( $section, 'show_list_date', [
	'label' => sprintf( __( '%sを表示する', 'swell' ), __( '公開日', 'swell' ) ),
	'type'  => 'checkbox',
] );

// 更新日を表示する
Customizer::add( $section, 'show_list_mod', [
	'label' => sprintf( __( '%sを表示する', 'swell' ), __( '更新日', 'swell' ) ),
	'type'  => 'checkbox',
] );

// 著者を表示する
Customizer::add( $section, 'show_list_author', [
	'label' => sprintf( __( '%sを表示する', 'swell' ), __( '著者', 'swell' ) ),
	'type'  => 'checkbox',
] );

// 抜粋文の文字数（PC・Tab）
Customizer::add( $section, 'excerpt_length_pc', [
	'label'   => __( '抜粋文の文字数', 'swell' ) . ' (PC/Tab)',
	'type'    => 'select',
	'choices' => [
		'0'    => __( '非表示', 'swell' ),
		'40'   => sprintf( __( '%d字', 'swell' ), 40 ),
		'80'   => sprintf( __( '%d字', 'swell' ), 80 ),
		'120'  => sprintf( __( '%d字', 'swell' ), 120 ),
		'160'  => sprintf( __( '%d字', 'swell' ), 160 ),
		'240'  => sprintf( __( '%d字', 'swell' ), 240 ),
		'320'  => sprintf( __( '%d字', 'swell' ), 320 ),
	],
] );

// 抜粋文の文字数（Mobile）
Customizer::add( $section, 'excerpt_length_sp', [
	'label'   => __( '抜粋文の文字数', 'swell' ) . ' (Mobile)',
	'type'    => 'select',
	'choices' => [
		'0'    => __( '非表示', 'swell' ),
		'40'   => sprintf( __( '%d字', 'swell' ), 40 ),
		'80'   => sprintf( __( '%d字', 'swell' ), 80 ),
		'120'  => sprintf( __( '%d字', 'swell' ), 120 ),
		'160'  => sprintf( __( '%d字', 'swell' ), 160 ),
		'240'  => sprintf( __( '%d字', 'swell' ), 240 ),
		'320'  => sprintf( __( '%d字', 'swell' ), 320 ),
	],
] );


// カテゴリーの表示設定
Customizer::big_title( $section, 'post_list_cat', [
	'label'     => __( 'カテゴリーの表示設定', 'swell' ),
] );

// 投稿のカテゴリー表示位置
Customizer::add( $section, 'category_pos', [
	'label'       => __( 'カテゴリー表示位置', 'swell' ),
	'description' => __( '※ テキスト型リストでは表示位置は固定です。', 'swell' ),
	'type'        => 'select',
	'choices'     => [
		'none'        => __( '表示しない', 'swell' ),
		'on_thumb'    => __( 'サムネイル画像の上に表示', 'swell' ),
		'beside_date' => __( '投稿日時の横に表示', 'swell' ),
	],
] );

// サムネイル画像上に表示される時の追加設定
Customizer::sub_title( $section, 'cat_on_thmb', [
	'classname' => '-cat-on-thumb',
	'label'     => __( 'サムネイル画像上に表示される時の追加設定', 'swell' ),
] );

// カテゴリーの文字色
Customizer::add( $section, 'pl_cat_txt_color', [
	'classname'   => '-cat-on-thumb',
	'description' => __( 'カテゴリーの文字色', 'swell' ),
	'type'        => 'color',
] );

// カテゴリーの背景色
Customizer::add( $section, 'pl_cat_bg_color', [
	'classname'   => '-cat-on-thumb',
	'description' => __( 'カテゴリーの背景色<br><small>※ 指定がない場合はメインカラーと同じ色になります</small>', 'swell' ),
	'type'        => 'color',
] );

// カテゴリーの背景効果
Customizer::add( $section, 'pl_cat_bg_style', [
	'classname'   => '-cat-on-thumb',
	'description' => __( 'カテゴリーの背景効果', 'swell' ),
	'type'        => 'select',
	'choices'     => [
		'no'        => __( 'なし', 'swell' ),
		'stripe'    => __( 'ストライプ', 'swell' ),
		'gradation' => __( 'グラデーション', 'swell' ),
	],
] );

Customizer::add( $section, 'pl_cat_target', [
	'label'   => __( '親子カテゴリーの表示優先度', 'swell' ),
	'type'    => 'select',
	'choices' => [
		''       => __( '指定しない', 'swell' ),
		'parent' => __( '親カテゴリーを優先的に表示', 'swell' ),
		'child'  => __( '子カテゴリーを優先的に表示', 'swell' ),
	],
] );

Customizer::add( $section, 'pl_cat_on_cat_page', [
	'label'   => __( 'カテゴリーアーカイブでの表示設定', 'swell' ),
	'type'    => 'select',
	'choices' => [
		''        => __( '指定しない', 'swell' ),
		'if_have' => __( '該当カテゴリーを含んでいれば優先的に表示', 'swell' ),
		'forced'  => __( '該当カテゴリーを強制的に表示', 'swell' ),
	],
] );


// カテゴリーアイコンを表示するかどうか

// ■ サムネイル画像の比率設定
Customizer::big_title( $section, 'thumb_ratio', [
	'label' => __( 'サムネイル画像の比率設定', 'swell' ),
] );

$thumb_ratio_choices = array_map( function( $ratio ) {
	return $ratio['label'];
}, \SWELL_Theme::$thumb_ratios );

// カード型リストでの画像比率
Customizer::add( $section, 'card_posts_thumb_ratio', [
	'label'   => sprintf( __( '%sでの画像比率', 'swell' ), __( 'カード型リスト', 'swell' ) ),
	'type'    => 'select',
	'choices' => $thumb_ratio_choices,
] );

// リスト型リストでの画像比率
Customizer::add( $section, 'list_posts_thumb_ratio', [
	'label'   => sprintf( __( '%sでの画像比率', 'swell' ), __( 'リスト型リスト', 'swell' ) ),
	'type'    => 'select',
	'choices' => $thumb_ratio_choices,
] );

// サムネイル型リストでの画像比率
Customizer::add( $section, 'thumb_posts_thumb_ratio', [
	'label'   => sprintf( __( '%sでの画像比率', 'swell' ), __( 'サムネイル型リスト', 'swell' ) ),
	'type'    => 'select',
	'choices' => $thumb_ratio_choices,
] );

// ブログ型での画像比率
Customizer::add( $section, 'big_posts_thumb_ratio', [
	'label'   => sprintf( __( '%sでの画像比率', 'swell' ), __( 'ブログ型', 'swell' ) ),
	'type'    => 'select',
	'choices' => $thumb_ratio_choices,
] );


// ブログカードでの画像比率
Customizer::add( $section, 'blogcard_thumb_ratio', [
	'label'   => sprintf( __( '%sでの画像比率', 'swell' ), __( 'ブログカード', 'swell' ) ),
	'type'    => 'select',
	'choices' => $thumb_ratio_choices,
] );




// ■ マウスホバー時の設定
Customizer::big_title( $section, 'post_list_hover', [
	'label' => __( 'マウスホバー時の設定', 'swell' ),
] );

// グラデーション色１
Customizer::add( $section, 'color_gradient1', [
	'label'       => __( 'グラデーション色', 'swell' ) . '1',
	'description' => __( '画像に着色されるグラデーション色の左側', 'swell' ),
	'type'        => 'color',
] );

// グラデーション色2
Customizer::add( $section, 'color_gradient2', [
	'label'       => __( 'グラデーション色', 'swell' ) . '2',
	'description' => __( '画像に着色されるグラデーション色の右側', 'swell' ),
	'type'        => 'color',
] );


// ■ タブ切り替え設定（トップページ）
Customizer::big_title( $section, 'post_list_tab', [
	'label'       => __( 'タブ切り替え設定（トップページ）', 'swell' ),
	'description' => __( 'トップページまたはホームページ設定で「投稿ページ」に指定した固定ページに表示される記事一覧リストの上に表示できる、切り替えタブの設定。', 'swell' ),
] );

// 表示するタブの設定
Customizer::sub_title( $section, 'pop_tab', [
	'label' => __( '表示するタブの設定', 'swell' ),
] );

// 「新着記事タブ」を追加する
Customizer::add( $section, 'show_new_tab', [
	'label' => sprintf( __( '「%s」を追加する', 'swell' ), __( '新着記事タブ', 'swell' ) ),
	'type'  => 'checkbox',
] );

// 「人気記事タブ」を追加する
Customizer::add( $section, 'show_ranking_tab', [
	'label' => sprintf( __( '「%s」を追加する', 'swell' ), __( '人気記事タブ', 'swell' ) ),
	'type'  => 'checkbox',
] );

// 「タームタブ」の設定
Customizer::add( $section, 'top_tab_terms', [
	'label'       => __( '「タームタブ」の設定', 'swell' ),
	'description' => __( 'カテゴリーやタグのIDを,区切りで指定してください（例: 「2,6,8」）', 'swell' ),
	'type'        => 'text',
	'sanitize'    => 'wp_filter_nohtml_kses',
] );

// 「新着記事タブ」の表示名
Customizer::add( $section, 'new_tab_title', [
	'label' => sprintf( __( '「%s」の表示名', 'swell' ), __( '新着記事タブ', 'swell' ) ),
	'type'  => 'text',
] );

// 「人気記事タブ」の表示名
Customizer::add( $section, 'ranking_tab_title', [
	'label' => sprintf( __( '「%s」の表示名', 'swell' ), __( '人気記事タブ', 'swell' ) ),
	'type'  => 'text',
] );

// タブデザイン
Customizer::add( $section, 'top_tab_style', [
	'classname' => '-radio-button',
	'label'     => __( 'タブデザイン', 'swell' ),
	'type'      => 'radio',
	'choices'   => [
		'default' => __( '標準', 'swell' ),
		'simple'  => __( 'グレーボックス', 'swell' ),
		'bb'      => __( '下線', 'swell' ),
	],
] );


// ■ タブ切り替え設定（その他のページ）
Customizer::big_title( $section, 'post_list_tab_other', [
	'label' => __( 'タブ切り替え設定（その他のページ）', 'swell' ),
	// 'description' => __( 'トップページまたはホームページ設定で「投稿ページ」に指定した固定ページに表示される記事一覧リストの上に表示できる、切り替えタブの設定。', 'swell' )
] );

// タームアーカイブに「人気記事タブ」を追加
Customizer::add( $section, 'show_tab_on_term', [
	'label' => sprintf( __( '%1$sに「%2$s」を追加', 'swell' ), __( 'タームアーカイブ', 'swell' ), __( '人気記事タブ', 'swell' ) ),
	'type'  => 'checkbox',
] );

// 著者アーカイブに「人気記事タブ」を追加
Customizer::add( $section, 'show_tab_on_author', [
	'label' => sprintf( __( '%1$sに「%2$s」を追加', 'swell' ), __( '著者アーカイブ', 'swell' ), __( '人気記事タブ', 'swell' ) ),
	'type'  => 'checkbox',
] );


// ■ 投稿一覧から除外するカテゴリー・タグ
Customizer::big_title( $section, 'exc_posts', [
	'label'       => __( '投稿一覧から除外するカテゴリー・タグ', 'swell' ),
	'description' => __( 'トップページまたはホームページ設定で「投稿ページ」に指定した固定ページに表示される記事一覧リスト、およびウィジェットでの記事一覧リストでのみ有効です。', 'swell' ),
] );

// 除外したいカテゴリーのID
Customizer::add( $section, 'exc_cat_id', [
	'label'       => sprintf( __( '除外したい%sのID', 'swell' ), __( 'カテゴリー', 'swell' ) ),
	'description' => sprintf( __( '複数の場合は<code>,</code>区切りで指定してください。<br><small>※ 「%s」のリストから除外されます。</small>', 'swell' ), __( '新着記事一覧', 'swell' ) ),
	'type'        => 'text',
	'sanitize'    => 'wp_filter_nohtml_kses',
] );

// 除外したいタグのID
Customizer::add( $section, 'exc_tag_id', [
	'label'       => sprintf( __( '除外したい%sのID', 'swell' ), __( 'タグ', 'swell' ) ),
	'description' => __( '複数の場合は<code>,</code>区切りで指定してください。<br><small>※ 「新着記事一覧・人気記事一覧」のリストから除外されます。</small>', 'swell' ),
	'type'        => 'text',
	'sanitize'    => 'wp_filter_nohtml_kses',
] );
