<?php
namespace SWELL_Theme;

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'after_setup_theme', __NAMESPACE__ . '\setup_theme', 9 );
add_action( 'after_setup_theme', __NAMESPACE__ . '\setup_theme_supports' );

/**
 * セットアップ
 */
function setup_theme() {

	// テキストドメイン読み込み
	load_theme_textdomain( 'swell', \SWELL_Theme::get_languages_dir() );

	// リストレイアウト
	\SWELL_Theme::$list_layouts = [
		'card'   => __( 'カード型', 'swell' ),
		'list'   => __( 'リスト型', 'swell' ),
		'list2'  => __( 'リスト型', 'swell' ) . __( '（左右交互）', 'swell' ),
		'thumb'  => __( 'サムネイル型', 'swell' ),
		'big'    => __( 'ブログ型', 'swell' ),
		'simple' => __( 'テキスト型', 'swell' ),
	];

	\SWELL_Theme::$thumb_ratios = [
		'square' => [
			'value' => '100%',
			'label' => __( '正方形', 'swell' ) . '(1:1)',
		],
		'golden' => [
			'value' => '61.805%',
			'label' => __( '黄金比率', 'swell' ) . '(1.618:1)',
		],
		'silver' => [
			'value' => '70.721%',
			'label' => __( '白銀比率', 'swell' ) . '(1.414:1)',
		],
		'slr'    => [
			'value' => '66.666%',
			'label' => __( '一眼', 'swell' ) . '(3:2)',
		],
		'wide'   => [
			'value' => '56.25%',
			'label' => __( 'ワイド', 'swell' ) . '(16:9)',
		],
		'ogp' => [
			'value' => '52.356%',
			'label' => __( 'OGP', 'swell' ) . '(1.91:1)',
		],
		'wide2'  => [
			'value' => '50%',
			'label' => __( '横長', 'swell' ) . '(2:1)',
		],
		'wide3'  => [
			'value' => '40%',
			'label' => __( '超横長', 'swell' ) . '(5:2)',
		],
	];
}



/**
 * テーマサポート
 */
function setup_theme_supports() {
	add_theme_support( 'menus' );
	add_theme_support( 'widgets' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_post_type_support( 'page', 'excerpt' ); // 固定ページでも抜粋文を使用可能にする

	// Gutenberg用
	add_theme_support( 'align-wide' ); // 画像の全幅表示などを可能に

	// 16:9で保つ...？
	// add_theme_support( 'responsive-embeds' );

	// コメントエリアをHTML5のタグで出力
	add_theme_support( 'html5', [
		'comment-form',
		'comment-list',
		// 'navigation-widgets',
	] );

	// 5.5からの機能
	add_theme_support( 'custom-line-height' );
	add_theme_support( 'custom-units', 'px', '%', 'em', 'rem', 'vw', 'vh' );

	// フォントサイズ
	add_theme_support(
		'editor-font-sizes',
		[
			[
				'name'      => _x( '極小', 'size', 'swell' ),
				'shortName' => 'XS',
				'size'      => '0.75em',
				'slug'      => 'xs',
			],
			[
				'name'      => _x( '小', 'size', 'swell' ),
				'shortName' => 'S',
				'size'      => '0.9em',
				'slug'      => 'small',
			],
			[
				'name'      => _x( '中', 'size', 'swell' ),
				'shortName' => 'M',
				'size'      => '1.1em',
				'slug'      => 'medium',
			],
			[
				'name'      => _x( '大', 'size', 'swell' ),
				'shortName' => 'L',
				'size'      => '1.25em',
				'slug'      => 'large',
			],
			[
				'name'      => _x( '特大', 'size', 'swell' ),
				'shortName' => 'XL',
				'size'      => '1.6em',
				'slug'      => 'huge',
			],
		]
	);

	$thin   = _x( '薄', 'color', 'swell' );
	$dark   = _x( '濃', 'color', 'swell' );
	$custom = __( 'カスタム', 'swell' );

	// slugはクラス名で使用されるので変更するとアウト
	$palette_colors = [
		[
			'name'  => __( 'メインカラー', 'swell' ),
			'slug'  => 'swl-main',
			'color' => 'var(--color_main)',
		],
		[
			'name'  => __( 'メインカラー', 'swell' ) . '(' . $thin . ')',
			'slug'  => 'swl-main-thin',
			'color' => 'var(--color_main_thin)',
		],
		[
			'name'  => __( 'Gray' ), // phpcs:ignore WordPress.WP.I18n.MissingArgDomain
			'slug'  => 'swl-gray',
			'color' => 'var(--color_gray)',
		],
		[
			'name'  => __( 'White' ), // phpcs:ignore WordPress.WP.I18n.MissingArgDomain
			'slug'  => 'white',
			'color' => '#fff',
		],
		[
			'name'  => __( 'Black' ), // phpcs:ignore WordPress.WP.I18n.MissingArgDomain
			'slug'  => 'black',
			'color' => '#000',
		],
		[
			'name'  => $custom . '(' . $dark . '-01)',
			'slug'  => 'swl-deep-01',
			'color' => 'var(--color_deep01)',
		],
		[
			'name'  => $custom . '(' . $dark . '-02)',
			'slug'  => 'swl-deep-02',
			'color' => 'var(--color_deep02)',
		],
		[
			'name'  => $custom . '(' . $dark . '-03)',
			'slug'  => 'swl-deep-03',
			'color' => 'var(--color_deep03)',
		],
		[
			'name'  => $custom . '(' . $dark . '-04)',
			'slug'  => 'swl-deep-04',
			'color' => 'var(--color_deep04)',
		],
		[
			'name'  => $custom . '(' . $thin . '-01)',
			'slug'  => 'swl-pale-01',
			'color' => 'var(--color_pale01)',
		],
		[
			'name'  => $custom . '(' . $thin . '-02)',
			'slug'  => 'swl-pale-02',
			'color' => 'var(--color_pale02)',
		],
		[
			'name'  => $custom . '(' . $thin . '-03)',
			'slug'  => 'swl-pale-03',
			'color' => 'var(--color_pale03)',
		],
		[
			'name'  => $custom . '(' . $thin . '-04)',
			'slug'  => 'swl-pale-04',
			'color' => 'var(--color_pale04)',
		],
	];

	// カラーパレット
	add_theme_support( 'editor-color-palette', $palette_colors );

	// コアのブロックパターンを全部削除
	remove_theme_support( 'core-block-patterns' );

	// ブロックウィジェット機能停止
	remove_theme_support( 'widgets-block-editor' );
}
