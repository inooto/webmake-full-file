<?php
namespace SWELL_Theme\TinyMCE;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * TinyMCEのエディタ内CSS
 */
add_action( 'admin_init', __NAMESPACE__ . '\hook_admin_init' );
function hook_admin_init() {
	$editor_style_path = [
		T_DIRE_URI . '/build/css/editor/editor_style.css?v=' . SWELL_VERSION,
		T_DIRE_URI . '/build/css/blocks.css?v=' . SWELL_VERSION,
		T_DIRE_URI . '/build/css/swell-icons.css?v=' . SWELL_VERSION,
	];
	add_editor_style( $editor_style_path );
}


/**
 * TinyMCE設定
 */
add_action( 'tiny_mce_before_init', __NAMESPACE__ . '\hook_tiny_mce_before_init' );
function hook_tiny_mce_before_init( $mceInit ) {

	// 見出し4まで
	$mceInit['block_formats'] = sprintf(
		'%1$s=p; %2$s=h2; %3$s=h3; %4$s=h4',
		__( '段落', 'swell' ),
		__( '見出し 2', 'swell' ),
		__( '見出し 3', 'swell' ),
		__( '見出し 4', 'swell' )
	);

	// id など消させない
	$mceInit['valid_elements']          = '*[*]';
	$mceInit['extended_valid_elements'] = '*[*]';

	// styleや、divの中のdiv,span、spanの中のspanを消させない
	$mceInit['valid_children'] = '+body[style],+div[div|span],+span[span],+td[style]';

	// 空タグや、属性なしのタグとか消そうとしたりするのを停止。
	$mceInit['verify_html'] = false;

	// テキストエディタがぐしゃっとなるのを防ぐ
	$mceInit['indent'] = true;

	// テーブルリサイズの制御
	$mceInit['table_resize_bars'] = false;
	$mceInit['object_resizing']   = 'img';

	$mceInit = set_content_style( $mceInit );
	$mceInit = set_body_class( $mceInit );
	$mceInit = set_style_formats( $mceInit );

	return $mceInit;
}


/**
 * 拡張機能スクリプトの読み込み
 */
add_filter( 'mce_external_plugins', __NAMESPACE__ . '\add_mce_external_plugins' );

function add_mce_external_plugins( $plugins ) {
	$plugins['table']        = T_DIRE_URI . '/assets/js/tinymce/table_plugin.min.js';
	$plugins['swellButtons'] = T_DIRE_URI . '/build/js/admin/tinymce.min.js?v=' . SWELL_VERSION;
	return $plugins;
}

/**
 * 拡張機能スクリプトの読み込み
 */
add_filter( 'mce_buttons_2', __NAMESPACE__ . '\add_mce_buttons_2' );
function add_mce_buttons_2( $buttons ) {
	array_unshift( $buttons, 'shortcode_select' );
	array_unshift( $buttons, 'styleselect' );
	$buttons[] = 'table';
	return $buttons;
}

/**
 * インラインスタイルをセット
 */
function set_content_style( $mceInit ) {

	// $current_screen  = get_current_screen();
	global $current_screen;
	if ( ! isset( $current_screen ) ) {
		return $mceInit;
	}
	$is_block_editor = $current_screen && method_exists( $current_screen, 'is_block_editor' ) && $current_screen->is_block_editor();

	if ( $is_block_editor ) {
		return $mceInit;
	}

	// content_styleがまだなければ空でセット
	if ( ! isset( $mceInit['content_style'] ) ) {
		$mceInit['content_style'] = '';
	}

	// editor用インラインスタイル取得
	$add_styles = \SWELL_Theme\Style::get_editor_css();
	$add_styles = str_replace( '\\', '', $add_styles );  // contentのバックスラッシュで変になってしまうのでtinymceは別途指定
	$add_styles = preg_replace( '/(?:\n|\r|\r\n)/su', '', $add_styles );
	$add_styles = str_replace( '"', "'", $add_styles );

	$mceInit['content_style'] .= $add_styles;

	return $mceInit;
}


/**
 * TinyMCEのbodyクラス
 */
function set_body_class( $mceInit ) {

	$SETTING = \SWELL_Theme::get_setting();
	$EDITOR  = \SWELL_Theme::get_editor();

	$body_class = '';

	if ( 'quotation' === $EDITOR['blockquote_type'] ) {
		$body_class .= ' blockquote_quotation';
	}
	if ( 'check' === $SETTING['h4_type'] ) {
		$body_class .= ' h4_check';
	}

	if ( ! isset( $mceInit['body_class'] ) ) {
		// body_class がまだなければそのままセット
		$mceInit['body_class'] = $body_class;
	} else {
		// body_class がすでにあれば追記
		$mceInit['body_class'] .= $body_class;
	}

	return $mceInit;
}


/**
 * スタイルフォーマットのセット
 */
function set_style_formats( $mceInit ) {

	$mark_ttl = _x( 'マーカー', 'format', 'swell' );
	$fz_ttl   = _x( 'フォントサイズ', 'format', 'swell' );

	$style_formats = [
		[
			'title' => __( 'テキスト装飾', 'swell' ),
			'items' => [
				[
					'title'   => $mark_ttl . ': ' . _x( 'オレンジ', 'color', 'swell' ),
					'inline'  => 'span',
					'classes' => 'mark_orange',
				],
				[
					'title'   => $mark_ttl . ': ' . _x( 'イエロー', 'color', 'swell' ),
					'inline'  => 'span',
					'classes' => 'mark_yellow',
				],
				[
					'title'   => $mark_ttl . ': ' . _x( 'グリーン', 'color', 'swell' ),
					'inline'  => 'span',
					'classes' => 'mark_green',
				],
				[
					'title'   => $mark_ttl . ': ' . _x( 'ブルー', 'color', 'swell' ),
					'inline'  => 'span',
					'classes' => 'mark_blue',
				],
				[
					'title'  => _x( '注釈', 'format', 'swell' ),
					'inline' => 'small',
				],
				[
					'title'  => _x( 'インラインコード', 'format', 'swell' ),
					'inline' => 'code',
				],
				[
					'title'   => $fz_ttl . ': ' . _x( '極小', 'size', 'swell' ),
					'inline'  => 'span',
					'classes' => 'u-fz-xs',
				],
				[
					'title'   => $fz_ttl . ': ' . _x( '小', 'size', 'swell' ),
					'inline'  => 'span',
					'classes' => 'u-fz-s',
				],
				[
					'title'   => $fz_ttl . ': ' . _x( '大', 'size', 'swell' ),
					'inline'  => 'span',
					'classes' => 'u-fz-l',
				],
				[
					'title'   => $fz_ttl . ': ' . _x( '特大', 'size', 'swell' ),
					'inline'  => 'span',
					'classes' => 'u-fz-xl',
				],
			],
		],
		[
			'title' => __( '画像スタイル', 'swell' ),
			'items' => [
				[
					'title'    => _x( '枠あり', 'media-style', 'swell' ),
					'selector' => 'img',
					'classes'  => 'border',
				],
				[
					'title'    => _x( '影あり', 'media-style', 'swell' ),
					'selector' => 'img',
					'classes'  => 'shadow',
				],
				[
					'title'    => _x( 'フォトフレーム', 'media-style', 'swell' ),
					'selector' => 'img',
					'classes'  => 'photo_frame',
				],
				[
					'title'    => _x( '少し小さく表示', 'media-style', 'swell' ),
					'selector' => 'img',
					'classes'  => 'size_s',
				],
				[
					'title'    => _x( '小さく表示', 'media-style', 'swell' ),
					'selector' => 'img',
					'classes'  => 'size_xs',
				],
			],
		],
		[
			'title' => __( 'シンプルボックス', 'swell' ),
			'items' => [
				[
					'title'   => __( '線枠', 'swell' ) . ': ' . _x( 'グレー', 'color', 'swell' ),
					'block'   => 'div',
					'classes' => 'is-style-border_sg',
					'wrapper' => true,
				],
				[
					'title'   => __( '点線枠', 'swell' ) . ': ' . _x( 'グレー', 'color', 'swell' ),
					'block'   => 'div',
					'classes' => 'is-style-border_dg',
					'wrapper' => true,
				],
				[
					'title'   => __( '線枠', 'swell' ) . ': ' . __( 'メインカラー', 'swell' ),
					'block'   => 'div',
					'classes' => 'is-style-border_sm',
					'wrapper' => true,
				],
				[
					'title'   => __( '点線枠', 'swell' ) . ': ' . __( 'メインカラー', 'swell' ),
					'block'   => 'div',
					'classes' => 'is-style-border_dm',
					'wrapper' => true,
				],
				[
					'title'   => __( '背景', 'swell' ) . ': ' . __( 'メインカラー', 'swell' ),
					'block'   => 'div',
					'classes' => 'is-style-bg_main',
					'wrapper' => true,
				],
				[
					'title'   => __( '背景', 'swell' ) . ': ' . _x( '薄メイン色', 'color', 'swell' ),
					'block'   => 'div',
					'classes' => 'is-style-bg_main_thin',
					'wrapper' => true,
				],
				[
					'title'   => __( '背景', 'swell' ) . ': ' . _x( 'グレー', 'color', 'swell' ),
					'block'   => 'div',
					'classes' => 'is-style-bg_gray',
					'wrapper' => true,
				],
			],
		],
		[
			'title' => __( '効果付きボックス', 'swell' ),
			'items' => [

				[
					'title'   => _x( 'ストライプ', 'box-style', 'swell' ),
					'block'   => 'div',
					'classes' => 'is-style-bg_stripe',
					'wrapper' => true,
				],
				[
					'title'   => _x( '方眼', 'box-style', 'swell' ),
					'block'   => 'div',
					'classes' => 'is-style-bg_grid',
					'wrapper' => true,
				],
				[
					'title'   => _x( '角に折り目', 'box-style', 'swell' ),
					'block'   => 'div',
					'classes' => 'is-style-crease',
					'wrapper' => true,
				],
				[
					'title'   => _x( 'スティッチ', 'box-style', 'swell' ),
					'block'   => 'div',
					'classes' => 'is-style-stitch',
					'wrapper' => true,
				],
				[
					'title'   => _x( 'かぎ括弧', 'box-style', 'swell' ),
					'block'   => 'div',
					'classes' => 'is-style-kakko_box',
					'wrapper' => true,
				],
				[
					'title'   => _x( 'かぎ括弧', 'box-style', 'swell' ) . __( '（大）', 'swell' ),
					'block'   => 'div',
					'classes' => 'is-style-big_kakko_box',
					'wrapper' => true,
				],
				[
					'title'   => _x( '窪み', 'box-style', 'swell' ),
					'block'   => 'div',
					'classes' => 'is-style-dent_box',
					'wrapper' => true,
				],
				[
					'title'   => _x( '浮き出し', 'box-style', 'swell' ),
					'block'   => 'div',
					'classes' => 'is-style-emboss_box',
					'wrapper' => true,
				],
				[
					'title'   => _x( '左に縦線', 'box-style', 'swell' ),
					'block'   => 'p',
					'classes' => 'is-style-border_left',
				],
				[
					'title'   => _x( '付箋', 'box-style', 'swell' ),
					'block'   => 'p',
					'classes' => 'is-style-sticky_box',
				],
				[
					'title'   => _x( '吹き出し', 'box-style', 'swell' ),
					'block'   => 'p',
					'classes' => 'is-style-balloon_box',
				],
				[
					'title'   => _x( '吹き出し', 'box-style', 'swell' ) . '2',
					'block'   => 'p',
					'classes' => 'is-style-balloon_box2',
				],

			],
		],
		[
			'title' => __( 'アイコンボックス', 'swell' ) . __( '（小）', 'swell' ),
			'items' => [
				[
					'title'   => _x( 'グッド', 'box-style', 'swell' ),
					'block'   => 'p',
					'classes' => 'is-style-icon_good',
				],
				[
					'title'   => _x( 'バッド', 'box-style', 'swell' ),
					'block'   => 'p',
					'classes' => 'is-style-icon_bad',
				],
				[
					'title'   => _x( 'インフォ', 'box-style', 'swell' ),
					'block'   => 'p',
					'classes' => 'is-style-icon_info',
				],
				[
					'title'   => _x( 'アナウンス', 'box-style', 'swell' ),
					'block'   => 'p',
					'classes' => 'is-style-icon_announce',
				],
				[
					'title'   => _x( 'ペン', 'box-style', 'swell' ),
					'block'   => 'p',
					'classes' => 'is-style-icon_pen',
				],
				[
					'title'   => _x( '本', 'box-style', 'swell' ),
					'block'   => 'p',
					'classes' => 'is-style-icon_book',
				],
			],
		],
		[
			'title' => __( 'アイコンボックス', 'swell' ) . __( '（大）', 'swell' ),
			'items' => [
				[
					'title'   => _x( 'ポイント', 'box-style', 'swell' ),
					'block'   => 'div',
					'classes' => 'is-style-big_icon_point',
					'wrapper' => true,
				],
				[
					'title'   => _x( 'チェック', 'box-style', 'swell' ),
					'block'   => 'div',
					'classes' => 'is-style-big_icon_good',
					'wrapper' => true,
				],
				[
					'title'   => _x( 'バツ印', 'box-style', 'swell' ),
					'block'   => 'div',
					'classes' => 'is-style-big_icon_bad',
					'wrapper' => true,
				],
				[
					'title'   => _x( 'はてな', 'box-style', 'swell' ),
					'block'   => 'div',
					'classes' => 'is-style-big_icon_hatena',
					'wrapper' => true,
				],
				[
					'title'   => _x( 'アラート', 'box-style', 'swell' ),
					'block'   => 'div',
					'classes' => 'is-style-big_icon_caution',
					'wrapper' => true,
				],
				[
					'title'   => _x( 'メモ', 'box-style', 'swell' ),
					'block'   => 'div',
					'classes' => 'is-style-big_icon_memo',
					'wrapper' => true,
				],
			],
		],
		[
			'title' => __( 'リスト装飾', 'swell' ),
			'items' => [
				[
					'title'    => '【ul】' . _x( 'チェック', 'list-style', 'swell' ),
					'selector' => 'ul',
					'classes'  => 'is-style-check_list',
				],
				[
					'title'    => '【ul】' . _x( '注釈', 'list-style', 'swell' ),
					'selector' => 'ul',
					'classes'  => 'is-style-note_list',
				],
				[
					'title'    => '【ul】' . _x( 'マル', 'list-style', 'swell' ),
					'selector' => 'ul',
					'classes'  => 'is-style-good_list',
				],
				[
					'title'    => '【ul】' . _x( 'バツ', 'list-style', 'swell' ),
					'selector' => 'ul',
					'classes'  => 'is-style-bad_list',
				],
				[
					'title'    => '【ol】' . _x( '丸数字', 'list-style', 'swell' ),
					'selector' => 'ol',
					'classes'  => 'is-style-num_circle',
				],
				[
					'title'    => '【ul&ol】' . _x( '下線を付ける', 'list-style', 'swell' ),
					'selector' => 'ul,ol',
					'classes'  => 'border_bottom',
				],
			],
		],
		[
			'title' => __( 'ボタン装飾', 'swell' ),
			'items' => [
				[
					'title'   => _x( 'ノーマル', 'btn-style', 'swell' ) . ': ' . _x( '赤', 'color', 'swell' ),
					'block'   => 'div',
					'classes' => ['is-style-btn_normal', 'red_' ],
					'wrapper' => true,
				],
				[
					'title'   => _x( 'ノーマル', 'btn-style', 'swell' ) . ': ' . _x( '青', 'color', 'swell' ),
					'block'   => 'div',
					'classes' => ['is-style-btn_normal', 'blue_' ],
					'wrapper' => true,
				],
				[
					'title'   => _x( 'ノーマル', 'btn-style', 'swell' ) . ': ' . _x( '緑', 'color', 'swell' ),
					'block'   => 'div',
					'classes' => ['is-style-btn_normal', 'green_' ],
					'wrapper' => true,
				],
				[
					'title'   => _x( '立体', 'btn-style', 'swell' ) . ': ' . _x( '赤', 'color', 'swell' ),
					'block'   => 'div',
					'classes' => ['is-style-btn_solid', 'red_' ],
					'wrapper' => true,
				],
				[
					'title'   => _x( '立体', 'btn-style', 'swell' ) . ': ' . _x( '青', 'color', 'swell' ),
					'block'   => 'div',
					'classes' => ['is-style-btn_solid', 'blue_' ],
					'wrapper' => true,
				],
				[
					'title'   => _x( '立体', 'btn-style', 'swell' ) . ': ' . _x( '緑', 'color', 'swell' ),
					'block'   => 'div',
					'classes' => ['is-style-btn_solid', 'green_' ],
					'wrapper' => true,
				],
				[
					'title'   => _x( 'キラッと', 'btn-style', 'swell' ) . ': ' . _x( '赤', 'color', 'swell' ),
					'block'   => 'div',
					'classes' => ['is-style-btn_shiny', 'red_' ],
					'wrapper' => true,
				],
				[
					'title'   => _x( 'キラッと', 'btn-style', 'swell' ) . ': ' . _x( '青', 'color', 'swell' ),
					'block'   => 'div',
					'classes' => ['is-style-btn_shiny', 'blue_' ],
					'wrapper' => true,
				],
				[
					'title'   => _x( 'キラッと', 'btn-style', 'swell' ) . ': ' . _x( '緑', 'color', 'swell' ),
					'block'   => 'div',
					'classes' => ['is-style-btn_shiny', 'green_' ],
					'wrapper' => true,
				],

			],
		],
		[
			'title' => __( 'レイアウト', 'swell' ),
			'items' => [
				[
					'title'   => _x( '中央寄せボックス', 'box-style', 'swell' ),
					'block'   => 'div',
					'classes' => ['swell-styleBox', 'u-ta-c' ],
					'wrapper' => true,
				],
				[
					'title'   => _x( 'SPのみ表示', 'box-style', 'swell' ),
					'block'   => 'div',
					'classes' => ['swell-styleBox', 'sp_only' ],
					'wrapper' => true,
				],
				[
					'title'   => _x( 'PCのみ表示', 'box-style', 'swell' ),
					'block'   => 'div',
					'classes' => ['swell-styleBox', 'pc_only' ],
					'wrapper' => true,
				],
			],
		],
		// [
		// 	'title' => 'セクション用見出し',
		// 	'items' => [
		// 		[
		// 			'title'   => '見出し2',
		// 			'block'   => 'h2',
		// 			'classes' => 'is-style-section_ttl',
		// 		],
		// 		[
		// 			'title'   => '見出し3',
		// 			'block'   => 'h3',
		// 			'classes' => 'is-style-section_ttl',
		// 		],
		// 		[
		// 			'title'   => '見出し4',
		// 			'block'   => 'h4',
		// 			'classes' => 'is-style-section_ttl',
		// 		],
		// 	],
		// ],

	];

	// すでにスタイルセレクトが設定されている場合はまとめて最後に追加
	if ( isset( $mceInit['style_formats'] ) ) {
		$old_style_json = $mceInit['style_formats'];

		$old_style_array = json_decode( $old_style_json, true );

		$old_style_array = [
			'title' => __( 'ユーザーカスタム', 'swell' ),
			'items' => $old_style_array,
		];
		$style_formats[] = $old_style_array;
	}
	$mceInit['style_formats'] = json_encode( $style_formats );
	return $mceInit;
}
