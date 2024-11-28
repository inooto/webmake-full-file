<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$wp_customize->add_panel( 'swell_panel_single_page', [
	'priority' => 4,
	'title'    => __( '投稿・固定ページ', 'swell' ),
]);

// タイトル
require_once __DIR__ . '/single_page/post_title.php';

// 広告表示
require_once __DIR__ . '/single_page/pr_notation.php';

// アイキャッチ画像
require_once __DIR__ . '/single_page/thumbnail.php';

// コンテンツのデザイン
require_once __DIR__ . '/single_page/post_content.php';

// 目次
require_once __DIR__ . '/single_page/toc.php';

// SNSシェアボタン
require_once __DIR__ . '/single_page/share_btn.php';

// 記事下エリア
require_once __DIR__ . '/single_page/after_article.php';
