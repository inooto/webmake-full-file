<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$wp_customize->add_panel( 'swell_panel_top', [
	'priority' => 4,
	'title'    => __( 'トップページ', 'swell' ),
]);

// メインビジュアル設定
require_once __DIR__ . '/top/main_visual.php';

// 記事スライダー設定
require_once __DIR__ . '/top/post_slider.php';

// ピックアップバナー
require_once __DIR__ . '/top/pickup_banner.php';

// その他
require_once __DIR__ . '/top/others.php';
