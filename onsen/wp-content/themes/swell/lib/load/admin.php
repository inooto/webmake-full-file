<?php
namespace SWELL_Theme\Load_Files;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * 管理画面で読み込むファイル
 */
add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\hook_admin_enqueue_scripts' );
function hook_admin_enqueue_scripts( $hook_suffix ) {

	global $post_type;
	$build = T_DIRE_URI . '/build';

	// グーロバル変数はhead内で渡しておきたい
	\SWELL_Theme::enqueue_empty_script( 'swell_vars' );
	wp_localize_script( 'swell_vars', 'swellVars', global_vars_on_admin() );

	// icomoon
	wp_enqueue_style( 'swell-icons', $build . '/css/swell-icons.css', [], SWELL_VERSION );

	// 管理画面用CSS（共通）
	wp_enqueue_style( 'swell_admin/common', $build . '/css/admin/common.css', [], SWELL_VERSION );

	// 管理画面用JS（共通）
	wp_enqueue_script( 'swell_admin/script', $build . '/js/admin/admin_script.min.js', [], SWELL_VERSION, true );
	wp_localize_script( 'swell_admin/script', 'swlApiSettings', [
		'root'  => esc_url_raw( rest_url() ),
		'nonce' => wp_create_nonce( 'wp_rest' ),
	] );
	wp_localize_script( 'swell_admin/script', 'swellCommonText', [
		'cacheClearFailed' => __( 'キャッシュクリアに失敗しました。', 'swell' ),
	] );

	$use_color = false;
	$use_media = false;

	// ページの種類で分岐
	if ( is_customize_preview() ) {
		// memo: $hook_suffix では判定できない

		$use_color = true;
		$use_media = true;

		wp_enqueue_style( 'swell_admin/widgets', $build . '/css/admin/widgets.css', [], SWELL_VERSION );
		wp_enqueue_style( 'swell_admin/customizer', $build . '/css/admin/customizer.css', [], SWELL_VERSION );

	} elseif ( 'post.php' === $hook_suffix || 'post-new.php' === $hook_suffix ) {

		$use_media = true;

		wp_enqueue_style( 'swell_admin/post', $build . '/css/admin/post.css', [], SWELL_VERSION );

		// タイトルカウント
		wp_enqueue_script( 'swell_title_count', $build . '/js/admin/count_title.min.js', ['jquery' ], SWELL_VERSION, true );

	} elseif ( 'edit-tags.php' === $hook_suffix || 'term.php' === $hook_suffix ) {

		$use_media = true;

		wp_enqueue_style( 'swell_admin/term', $build . '/css/admin/term.css', [], SWELL_VERSION );

	} elseif ( 'widgets.php' === $hook_suffix ) {

		$use_color = true;
		$use_media = true;

		wp_enqueue_style( 'swell_admin/widgets', $build . '/css/admin/widgets.css', [], SWELL_VERSION );

		// クラシックウィジェットのみ
		// if ( ! \SWELL_Theme::use_widgets_block() ) {}

	} elseif ( 'profile.php' === $hook_suffix || 'user-edit.php' === $hook_suffix ) {

		$use_media = true;
		wp_enqueue_style( 'swell_admin/user', $build . '/css/admin/user.css', [], SWELL_VERSION );

	} elseif ( strpos( $hook_suffix, 'swell_settings' ) !== false ) {

		$use_color = true;
		$use_media = true;

		// 設定画面用ファイル
		wp_enqueue_style( 'swell_settings_css', $build . '/css/admin/settings.css', [], SWELL_VERSION );
		wp_enqueue_script( 'swell_settings_js', $build . '/js/admin/settings.min.js', [ 'jquery' ], SWELL_VERSION, false );
		wp_localize_script( 'swell_settings_js', 'swellText', [
			'updateFailed' => __( '更新に失敗しました。', 'swell' ),
			'resetConfirm' => __( '本当にリセットしてもいいですか？', 'swell' ),
			'resetFailed'  => __( 'リセットに失敗しました。', 'swell' ),
		] );

		// codemirror
		load_codemirror();

	} elseif ( strpos( $hook_suffix, 'swell_balloon' ) !== false ) {

		// <MediaUpload /> に必要
		wp_enqueue_media();

		// ふきだし管理画面
		// wp_enqueue_style( 'swell_settings_css', $build . '/css/admin/settings.css', [], SWELL_VERSION );
		wp_enqueue_style( 'swell_balloon_css', $build . '/css/admin/balloon.css', [ 'wp-components', 'wp-block-editor' ], SWELL_VERSION );

		$asset_file = include T_DIRE . '/build/menu/balloon/index.asset.php';
		wp_enqueue_script( 'swell_balloon_js', $build . '/menu/balloon/index.js', $asset_file['dependencies'], SWELL_VERSION, true );
		if ( function_exists( 'wp_set_script_translations' ) ) {
			wp_set_script_translations( 'swell_balloon_js', 'swell', \SWELL_Theme::get_languages_dir() );
		}
	}

	// メディアアップローダー
	if ( $use_media ) {
		wp_enqueue_media();
		wp_enqueue_script( 'mediauploader', $build . '/js/admin/mediauploader.min.js', [ 'jquery' ], SWELL_VERSION, true );
		wp_localize_script( 'mediauploader', 'swellTextForMedia', [
			'mediaSelect'    => __( '画像を選択', 'swell' ),
		] );
	}

	// カラーピッカー
	if ( $use_color ) {
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'swell_colorpicker', $build . '/js/admin/colorpicker.min.js', [ 'wp-color-picker' ], SWELL_VERSION, true );
	}

	// 投稿タイプで分岐
	if ( 'ad_tag' === $post_type ) {
		wp_enqueue_style( 'swell_ad_css', $build . '/css/admin/ad_tag.css', [], SWELL_VERSION );
		wp_enqueue_script( 'swell_ad_js', $build . '/js/admin/ad_tag.min.js', ['jquery' ], SWELL_VERSION, false );
		wp_localize_script( 'swell_ad_js', 'swellText', [
			'enterText'    => __( 'テキスト入力してね', 'swell' ),
			'resetConfirm' => __( '本当にリセットしてもいいですか？', 'swell' ),
			'resetFailed'  => __( 'リセットに失敗しました。', 'swell' ),
		] );
	}

	// TinyMCE用翻訳テキスト
	\SWELL_Theme::enqueue_empty_script( 'swell_tinymce' );
	wp_localize_script( 'swell_tinymce', 'swellTinyMceText', [
		// 共通
		'textPlaceholder'                     => __( 'ここにテキストを入力', 'swell' ),
		'contentPlaceholder'                  => __( 'ここにコンテンツを入力', 'swell' ),
		'menuTtl'                             => __( '特殊パーツ', 'swell' ),
		// ショートコード
		'shortcodeTtl'                        => __( 'ショートコード', 'swell' ),
		'shortcodeRelatedPost'                => __( '関連記事', 'swell' ),
		'shortcodeFullWide'                   => __( 'フルワイドコンテンツ', 'swell' ),
		'shortcodeBallooon'                   => __( 'ふきだし', 'swell' ),
		'shortcodeBallooonNormal'             => __( '標準', 'swell' ),
		'shortcodeBlogParts'                  => __( 'ブログパーツ', 'swell' ),
		'shortcodeAdTag'                      => __( '広告タグ', 'swell' ),
		'shortcodeAdTagBanner'                => __( 'バナー型', 'swell' ),
		'shortcodeAdTagAffiliate'             => __( 'アフィリエイト型', 'swell' ),
		'shortcodeAdTagAmazon'                => __( 'Amazon型', 'swell' ),
		'shortcodeAdTagRanking'               => __( 'ランキング型', 'swell' ),
		// テーブル
		'tableTtl'                            => __( 'テーブル', 'swell' ),
		'tableStyleNormal'                    => __( 'ノーマルテーブル', 'swell' ),
		'tableStyleHead'                      => __( 'ヘッド付きテーブル', 'swell' ),
		'tableStyleSimple'                    => __( 'シンプルテーブル', 'swell' ),
		'tableStyleSimpleHead'                => __( 'シンプルテーブル(ヘッド付き)', 'swell' ),
		'tableHeadThPlaceholder'              => __( '行の説明', 'swell' ),
		'tableBodyThPlaceholder'              => __( '項目', 'swell' ),
		// カラム
		'columnTwoTtl'                        => __( '2カラム', 'swell' ),
		'columnTwoStyleNormal'                => __( '通常', 'swell' ),
		'columnTwoStyleFirstBig'              => __( '幅2:1', 'swell' ),
		'columnTwoStyleLastBig'               => __( '幅1:2', 'swell' ),
		'columnTwoStyleSpColumnTwo'           => __( 'スマホも2列を維持', 'swell' ),
		'columnTwoStyleSpColumnTwoFirstBig'   => __( 'スマホも2列 - 幅2:1', 'swell' ),
		'columnTwoStyleSpColumnTwoLastBig'    => __( 'スマホも2列 - 幅1:2', 'swell' ),
		'columnThreeTtl'                      => __( '3カラム', 'swell' ),
		'columnThreeStyleNormal'              => __( '通常', 'swell' ),
		'columnThreeStyleFirstBig'            => __( '幅2:1:1', 'swell' ),
		'columnThreeStyleLastBig'             => __( '幅1:1:2', 'swell' ),
		'columnThreeStyleSpColumnTwo'         => __( 'スマホも2列を維持', 'swell' ),
		'columnThreeStyleSpColumnTwoFirstBig' => __( 'スマホ最大２列 - 幅2:1:1', 'swell' ),
		'columnThreeStyleSpColumnTwoLastBig'  => __( 'スマホ最大２列 - 幅1:1:2', 'swell' ),
		'columnText1'                         => __( 'カラム１', 'swell' ),
		'columnText2'                         => __( 'カラム２', 'swell' ),
		'columnText3'                         => __( 'カラム３', 'swell' ),
		// キャプション付きボックス
		'capboxTtl'                           => __( 'キャプション付きボックス', 'swell' ),
		'capboxBigTtl'                        => __( 'キャプション大', 'swell' ),
		'capboxSmallTtl'                      => __( 'キャプション小', 'swell' ),
		'capboxOnBorderTtl1'                  => __( 'キャプション枠上', 'swell' ),
		'capboxOnBorderTtl2'                  => __( 'キャプション枠上2', 'swell' ),
		'capboxTextTtl'                       => __( 'キャプション', 'swell' ),
		'capboxTextContent'                   => __( 'コンテンツ', 'swell' ),
	] );
}


/**
 * 管理画面用のJSグローバル変数 ( swellVars にセットする)
 */
function global_vars_on_admin() {

	$global_vars = [
		// 'homeUrl' => home_url( '/' ),
		'restUrl'   => rest_url() . 'wp/v2/',
		'adminUrl'  => admin_url(),
		'direUri'   => T_DIRE_URI,
		'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
		'ajaxNonce' => wp_create_nonce( 'swell-ajax-nonce' ),
	];

	// カスタム書式
	$custom_formats = [];
	for ( $i = 1; $i < 3; $i++ ) {
		$format_title = \SWELL_Theme::get_editor( 'format_title_' . $i );
		if ( $format_title ) {
			$custom_formats[] = [
				'name'      => 'loos/custom-format' . $i,
				'title'     => $format_title,
				'tagName'   => 'span',
				'className' => 'swl-format-' . $i,
			];
		}
	}

	if ( $custom_formats ) {
		$global_vars['customFormats'] = apply_filters( 'swell_custom_formats', $custom_formats );
	}

	// カスタム書式セット
	$custom_format_sets = [];
	$editor             = \SWELL_Theme::get_editor();

	for ( $i = 1; $i < 3; $i++ ) {
		$format_set = [];

		$format_bold      = $editor[ 'format_set_bold_' . $i ];
		$format_italic    = $editor[ 'format_set_italic_' . $i ];
		$format_color     = $editor[ 'format_set_color_' . $i ];
		$format_bg        = $editor[ 'format_set_bg_' . $i ];
		$format_marker    = $editor[ 'format_set_marker_' . $i ];
		$format_font_size = $editor[ 'format_set_font_size_' . $i ];

		if ( $format_bg ) {
			if ( $format_bg === 'white' || $format_bg === 'black' ) {
				$color_slug = $format_bg;
			} else {
				$color_slug = 'swl-' . $format_bg;
			}

			$format_set[] = [
				'type'       => 'loos/bg-color',
				'attributes' => [
					'class' => "swl-bg-color has-{$color_slug}-background-color",
				],
			];
		}

		if ( $format_marker ) {
			$format_set[] = [
				'type'       => 'loos/marker',
				'attributes' => [
					'class' => "mark_{$format_marker}",
				],
			];
		}

		if ( $format_color ) {
			if ( $format_color === 'white' || $format_color === 'black' ) {
				$color_slug = $format_bg;
			} else {
				$color_slug = 'swl-' . $format_color;
			}

			$format_set[] = [
				'type'       => 'loos/text-color',
				'attributes' => [
					'class' => "has-{$color_slug}-color",
				],
			];
		}

		if ( $format_font_size ) {
			$format_set[] = [
				'type'       => 'loos/font-size',
				'attributes' => [
					'class' => "u-fz-{$format_font_size}",
				],
			];
		}

		if ( $format_bold ) {
			$format_set[] = [
				'type'      => 'core/bold',
			];
		}

		if ( $format_italic ) {
			$format_set[] = [
				'type'      => 'core/italic',
			];
		}

		if ( $format_set ) {
			$custom_format_sets[] = $format_set;
		}
	}

	if ( $custom_format_sets ) {
		$global_vars['customFormatSets'] = apply_filters( 'swell_custom_format_sets', $custom_format_sets );
	}

	return $global_vars;
}



/**
 * see: https://codemirror.net/doc/manual.html#config
 */
function load_codemirror() {

	$codemirror = [
		'tabSize'           => 4,
		'indentUnit'        => 4,
		'indentWithTabs'    => true,
		'inputStyle'        => 'contenteditable',
		'lineNumbers'       => true,
		'smartIndent'       => true,
		'lineWrapping'      => true, // 横長のコードを折り返すかどうか
		'autoCloseBrackets' => true,
		'styleActiveLine'   => true,
		'continueComments'  => true,
		// 'extraKeys'         => [],
	];

	$settings = wp_enqueue_code_editor( [
		'type'       => 'text/css',
		'codemirror' => $codemirror,
	] );

	wp_localize_script( 'wp-theme-plugin-editor', 'codeEditorSettings', $settings );
	wp_enqueue_script( 'wp-theme-plugin-editor' );
	wp_add_inline_script(
		'wp-theme-plugin-editor',
		'jQuery(document).ready(function($) {
			var swellCssEditor = $(".swell-css-editor");
			if(swellCssEditor.length < 1) return;
			wp.codeEditor.initialize($(".swell-css-editor"), codeEditorSettings );
		})'
	);
	wp_enqueue_style( 'wp-codemirror' );
}
