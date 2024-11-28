<?php
use \SWELL_Theme\Customizer;
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'swell_section_after_article';

/**
 * セクション追加
 */
$wp_customize->add_section( $section, [
	'title'    => __( '記事下エリア', 'swell' ),
	'priority' => 10,
	'panel'    => 'swell_panel_single_page',
] );

// ■ SNSアクションエリア設定
Customizer::big_title( $section, 'sns_cta', [
	'label' => __( 'SNSアクションエリア設定', 'swell' ),
] );

// 表示するボタン
Customizer::sub_title( $section, 'sns_cta_check', [
	'label' => __( '表示するボタン', 'swell' ),
] );

// Twitterフォローボタン
Customizer::add( $section, 'show_tw_follow_btn', [
	'label' => __( 'Twitterフォローボタン', 'swell' ),
	'type'  => 'checkbox',
] );

// Instagramフォローボタン
Customizer::add( $section, 'show_insta_follow_btn', [
	'label' => __( 'Instagramフォローボタン', 'swell' ),
	'type'  => 'checkbox',
] );

// Facebookいいねボタン
Customizer::add( $section, 'show_fb_like_box', [
	'label' => __( 'Facebookいいねボタン', 'swell' ),
	'type'  => 'checkbox',
] );

// TwitterのユーザーID
Customizer::add( $section, 'tw_follow_id', [
	'classname'   => '-twitter-setting',
	'label'       => __( 'TwitterのユーザーID', 'swell' ),
	'description' => __( '@は含めずに入力してください。', 'swell' ),
	'type'        => 'text',
	'sanitize'    => 'wp_filter_nohtml_kses',
] );


// InstagramのユーザーID
Customizer::add( $section, 'insta_follow_id', [
	'classname'   => '-insta-setting',
	'label'       => __( 'InstagramのユーザーID', 'swell' ),
	'description' => __( '@は含めずに入力してください。', 'swell' ),
	'type'        => 'text',
	'sanitize'    => 'wp_filter_nohtml_kses',
] );


// Facebookいいねボタンの対象URL
Customizer::add( $section, 'fb_like_url', [
	'classname'   => '-fb-setting',
	'label'       => __( 'Facebookいいねボタンの対象URL', 'swell' ),
	'type'        => 'text',
	'sanitize'    => 'wp_filter_nohtml_kses',
] );

// Facebookいいねボタンに使用するappID
Customizer::add( $section, 'fb_like_appID', [
	'classname'   => '-fb-setting',
	'label'       => __( 'Facebookいいねボタンに使用するappID', 'swell' ),
	'type'        => 'text',
	'sanitize'    => 'wp_filter_nohtml_kses',
] );


// ■ 前後記事へのページリンク設定
Customizer::big_title( $section, 'pn_links', [
	'label' => __( '前後記事へのページリンク設定', 'swell' ),
] );

// 前後記事へのページリンクを表示
Customizer::add( $section, 'show_page_links', [
	'label' => __( '前後記事へのページリンクを表示', 'swell' ),
	'type'  => 'checkbox',
] );

// ページリンクにサムネイル画像を表示する
Customizer::add( $section, 'show_page_link_thumb', [
	'label' => __( 'ページリンクにサムネイル画像を表示する', 'swell' ),
	'type'  => 'checkbox',
] );

// 同じカテゴリーの記事を取得する
Customizer::add( $section, 'pn_link_is_same_term', [
	'label' => __( '同じカテゴリーの記事を取得する', 'swell' ),
	'type'  => 'checkbox',
] );

// 前後記事へのページリンクのデザイン
Customizer::add( $section, 'page_link_style', [
	'label'   => __( '前後記事へのページリンクのデザイン', 'swell' ),
	'type'    => 'select',
	'choices' => [
		'normal' => __( '標準', 'swell' ),
		'simple' => __( 'シンプル', 'swell' ),
	],
] );


// ■ 著者情報エリアの設定
Customizer::big_title( $section, 'post_author', [
	'label' => __( '著者情報エリアの設定', 'swell' ),
] );

// 著者情報を表示
Customizer::add( $section, 'show_author', [
	'label' => __( '著者情報を表示', 'swell' ),
	'type'  => 'checkbox',
] );

// 著者ページへのリンクを表示する
Customizer::add( $section, 'show_author_link', [
	'label' => __( '著者ページへのリンクを表示する', 'swell' ),
	'type'  => 'checkbox',
] );

// 著者情報エリアのタイトル
Customizer::add( $section, 'post_author_title', [
	'label' => __( '著者情報エリアのタイトル', 'swell' ),
	'type'  => 'text',
] );


// ■ 関連記事エリアの設定
Customizer::big_title( $section, 'related_posts', [
	'label' => __( '関連記事エリアの設定', 'swell' ),
] );

Customizer::add( $section, 'show_related_posts', [
	'label' => __( '関連記事を表示', 'swell' ),
	'type'  => 'checkbox',
] );

Customizer::add( $section, 'show_related_date', [
	'label' => sprintf( __( '%sを表示する', 'swell' ), __( '公開日', 'swell' ) ),
	'type'  => 'checkbox',
] );

Customizer::add( $section, 'show_related_mod', [
	'label' => sprintf( __( '%sを表示する', 'swell' ), __( '更新日', 'swell' ) ),
	'type'  => 'checkbox',
] );

Customizer::add( $section, 'related_post_title', [
	'label' => __( '関連記事エリアのタイトル', 'swell' ),
	'type'  => 'text',
] );

Customizer::add( $section, 'related_post_style', [
	'label'   => __( '関連記事のレイアウト', 'swell' ),
	'type'    => 'select',
	'choices' => [
		'card' => __( 'カード型', 'swell' ),
		'list' => __( 'リスト型', 'swell' ),
	],
] );

Customizer::add( $section, 'related_post_orderby', [
	'label'   => __( '並び順', 'swell' ),
	'type'    => 'select',
	'choices' => [
		'date'     => __( '新着順', 'swell' ),
		'modified' => __( '更新順', 'swell' ),
		'rand'     => __( 'ランダム', 'swell' ),
	],
] );

Customizer::add( $section, 'post_relation_type', [
	'classname'   => '-radio-button -related-post',
	'label'       => __( '関連記事の取得方法', 'swell' ),
	'description' => __( 'どの情報から関連記事を取得するかどうか', 'swell' ),
	'type'        => 'radio',
	'choices'     => [
		'category' => __( 'カテゴリー', 'swell' ),
		'tag'      => __( 'タグ', 'swell' ),
	],
] );


// ■ コメントエリアの設定
Customizer::big_title( $section, 'comment_area', [
	'label' => __( 'コメントエリアの設定', 'swell' ),
] );

// コメントエリアを表示
Customizer::add( $section, 'show_comments', [
	'label' => __( 'コメントエリアを表示', 'swell' ),
	'type'  => 'checkbox',
] );


Customizer::add( $section, 'comments_title', [
	'label' => __( 'コメントエリアのタイトル', 'swell' ),
	'type'  => 'text',
] );
