<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$wp_customize->add_panel( 'swell_panel_common', [
	'priority' => 3,
	'title'    => __( 'サイト全体設定', 'swell' ),
] );

// 基本カラー
require_once __DIR__ . '/common/color.php';

// 基本デザイン
require_once __DIR__ . '/common/base_design.php';

// NO IMAGE画像
require_once __DIR__ . '/common/noimg.php';

// タイトルデザイン
require_once __DIR__ . '/common/title.php';

// コンテンツヘッダー
require_once __DIR__ . '/common/content_header.php';

// お知らせバー
require_once __DIR__ . '/common/info_bar.php';

// パンくず
require_once __DIR__ . '/common/breadcrumb.php';

// ページャー
require_once __DIR__ . '/common/pager.php';

// スマホ開閉メニュー
require_once __DIR__ . '/common/sp_menu.php';

// 下部固定ボタン・メニュー
require_once __DIR__ . '/common/sp_bottom_menu.php';
