<?php
use \SWELL_Theme\Customizer;
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * セクション追加
 */
$section = 'swell_section_sns';

$wp_customize->add_section( $section, [
	'title'    => __( 'SNS情報', 'swell' ),
	'priority' => 9,
] );

// SNSリンク設定
Customizer::sub_title( $section, 'sns_link', [
	'label' => __( 'SNSリンク設定', 'swell' ),
] );

$sns_array = [
	'facebook'  => __( 'Facebook', 'swell' ),
	'twitter'   => __( 'Twitter', 'swell' ),
	'instagram' => __( 'Instagram', 'swell' ),
	'tiktok'    => __( 'TikTok', 'swell' ),
	'room'      => __( '楽天ROOM', 'swell' ),
	'line'      => __( 'LINE', 'swell' ),
	'pinterest' => __( 'Pinterest', 'swell' ),
	'github'    => __( 'Github', 'swell' ),
	'youtube'   => __( 'YouTube', 'swell' ),
	'amazon'    => __( 'Amazon欲しいものリスト', 'swell' ),
	'feedly'    => __( 'Feedly', 'swell' ),
	'rss'       => __( 'RSS', 'swell' ),
	'contact'   => __( 'お問い合わせページ', 'swell' ),
];
foreach ( $sns_array as $sns_key => $sns_name ) {
	Customizer::add( $section, $sns_key . '_url', [
		'description' => sprintf( __( '%s ページURL', 'swell' ), $sns_name ),
		'type'        => 'text',
		'sanitize'    => 'wp_filter_nohtml_kses',
	] );
}
