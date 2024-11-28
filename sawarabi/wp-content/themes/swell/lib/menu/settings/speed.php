<?php
/**
 * タブ : 高速化
 */
if ( ! defined( 'ABSPATH' ) ) exit;

use \SWELL_THEME\Admin_Menu;
use \SWELL_Theme\Menu\Setting_Field as Field;

// Pagge Name
$page_name = Admin_Menu::PAGE_NAMES['speed'];



/**
 * キャッシュ
 */
Field::add_menu_section( [
	'title'      => __( 'キャッシュ機能', 'swell' ),
	'key'        => 'cache',
	'page_name'  => $page_name,
	'page_cb'    => function ( $args ) {

		$settings = [
			'cache_style' => [
				'label' => __( '動的なCSSをキャッシュする', 'swell' ),
				'desc'  => '',
			],
			'cache_header' => [
				'label' => __( 'ヘッダーをキャッシュする', 'swell' ),
				'desc'  => '',
			],
			'cache_sidebar' => [
				'label' => __( 'サイドバーをキャッシュする', 'swell' ),
				'desc'  => '',
			],
			'cache_bottom_menu' => [
				'label' => __( '下部固定メニューをキャッシュする', 'swell' ),
				'desc'  => '',
			],
			'cache_spmenu' => [
				'label' => __( 'スマホ開閉メニューをキャッシュする', 'swell' ),
				'desc'  => __( 'ウィジェットのページ分岐は効かなくなります', 'swell' ),
			],
			'cache_top' => [
				'label' => __( 'トップページコンテンツをキャッシュする', 'swell' ),
				'desc'  => __( 'メインビジュアル・記事スライダー・ピックアップバナー・記事一覧リストがキャッシュされます', 'swell' ),
			],
			'cache_blogcard_in' => [
				'label' => __( '内部リンクのブログカードをキャッシュする', 'swell' ),
				'desc'  => '',
			],
			'cache_blogcard_ex' => [
				'label' => __( '外部リンクのブログカードをキャッシュする', 'swell' ),
				'desc'  => '',
			],
		];

		foreach ( $settings as $key => $data ) {
			Field::checkbox( 'options', $key, $data );
		}

		Field::input( 'options', 'cache_card_time', [
			'label'      => __( 'ブログカードのキャッシュ期間', 'swell' ),
			'type'       => 'number',
			'after'      => __( '日', 'swell' ),
		]);
	},
] );


/**
 * ファイルの読み込み
 */
Field::add_menu_section( [
	'title'      => __( 'ファイルの読み込み', 'swell' ),
	'key'        => 'file_load',
	'page_name'  => $page_name,
	'page_cb'    => function ( $args ) {

		$settings = [
			'load_style_inline' => [
				'label' => __( 'SWELLのCSSをインラインで読み込む', 'swell' ),
			],
			'separate_style'    => [
				'label' => __( 'コンテンツに合わせて必要なCSSだけを読み込む', 'swell' ),
				'desc'  => __( '使用されている機能やブロックを読み取り、そのページに不要なCSSはできる限り読み込まないように最適化します。', 'swell' ),
			],
			'load_style_async'  => [
				'label' => __( 'フッター付近のCSSを遅延読み込みさせる', 'swell' ),
				'desc'  => __( '「SWELLのCSSをインラインで読み込む」がオンの時は効果がありません。', 'swell' ),
			],
		];

		foreach ( $settings as $key => $data ) {
			Field::checkbox( 'options', $key, $data );
		}
	},
] );


/**
 * 遅延読み込み機能
 */
Field::add_menu_section( [
	'title'      => __( '遅延読み込み機能', 'swell' ),
	'key'        => 'lazyload',
	'page_name'  => $page_name,
	'page_cb'    => function ( $args ) {

		Field::h3( __( 'コンテンツの遅延読み込み', 'swell' ) );

		$settings = [
			'ajax_after_post' => [
				'label' => __( '記事下コンテンツを遅延読み込みさせる', 'swell' ),
				'desc'  => '',
			],
			'ajax_footer' => [
				'label' => __( 'フッターを遅延読み込みさせる', 'swell' ),
				'desc'  => __( 'ウィジェットのページ分岐は効かなくなります。', 'swell' ),
			],
		];
		foreach ( $settings as $key => $data ) {
			Field::checkbox( 'options', $key, $data );
		}

		Field::h3( __( '画像等のLazyload', 'swell' ) );

		Field::radio( 'options', 'lazy_type', [
			'choices' => [
				'none'      => __( '使用しない', 'swell' ),
				'lazy'      => __( '<code>loading="lazy"</code>を使用する', 'swell' ),
				'lazysizes' => __( 'スクリプト(<code>lazysizes.js</code>)を使って遅延読み込みさせる', 'swell' ),
			],
			'desc'    => __( 'スクリプトを使うと、<code>img</code>, <code>video</code>, <code>iframe</code>タグに遅延読み込みが適用できます。', 'swell' ),
		]);

		Field::h3( __( 'スクリプトの遅延読み込み', 'swell' ) );

		Field::toggle_control( 'options', 'use_delay_js', [
			'label' => __( 'スクリプトを遅延読み込みさせる', 'swell' ),
		] );

		$disable = ( ! \SWELL_Theme::get_option( 'use_delay_js' ) ) ? ' -disable' : '';

		// phpcs:ignore WordPress.Security.EscapeOutput
		echo '<div class="swl-setting__field -delay-js' . $disable . ' ">';

		Field::textarea( 'options', 'delay_js_list', [
			'label'  => __( '遅延読み込み対象にするスクリプトのキーワード', 'swell' ),
			'rows'   => 12,
			'desc'   => __( '指定されたキーワードが含まれる script タグを遅延読み込みします。', 'swell' ) .
				'<br>' . __( '複数の場合は「,（+改行）」で区切ってください。', 'swell' ) .
				'<br><a class="swl-helpLink" href="https://swell-theme.com/basic-setting/8864/" target="_blank">' . __( 'キーワードの書き方の例はこちら', 'swell' ) . '</a>',
		]);

		Field::textarea( 'options', 'delay_js_prevent_pages', [
			'label'  => __( 'スクリプトの遅延読み込み機能をオフにするページ', 'swell' ),
			'rows'   => 6,
			'desc'   => __( '指定されたキーワードが含まれるページでは、スクリプトの遅延読み込み機能がオフになります。', 'swell' ) .
				'<br>' . __( '複数の場合は「,（+改行）」で区切ってください。', 'swell' ),
		]);

		Field::select( 'options', 'delay_js_time', [
			'label'   => __( '遅延させる秒数', 'swell' ),
			'choices' => array_map( function( $i ) {
				return sprintf( __( '%s秒', 'swell' ), $i );
			}, [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15 ] ),
		]);

		echo '</div>';
	},
] );


/**
 * ページ遷移高速化
 */
Field::add_menu_section( [
	'title'      => __( 'ページ遷移高速化', 'swell' ),
	'key'        => 'pjax',
	'page_name'  => $page_name,
	'page_cb'    => function ( $args ) {

		$help = sprintf(
			__( '%sをご一読ください。', 'swell' ),
			'<a href="https://swell-theme.com/function/5978/" target="_blank">' . __( 'こちらのページ', 'swell' ) . '</a>'
		);
		Field::radio( 'options', 'use_pjax', [
			'label'   => __( '高速化の種類', 'swell' ),
			'choices' => [
				'off'      => __( '使用しない', 'swell' ),
				'prefetch' => __( 'Prefetch', 'swell' ),
				'pjax'     => __( 'Pjaxによる遷移（非推奨）', 'swell' ),
			],
			'desc'    => __( 'Pjax機能についてはいくつか注意点がございます。', 'swell' ) . $help,
		]);

		$pjax_type = \SWELL_Theme::get_option( 'use_pjax' );

		Field::textarea( 'options', 'prefetch_prevent_keys', [
			'label' => __( 'Prefetchさせないページのキーワード', 'swell' ),
			'desc'  => __( '複数の場合は「,（+改行）」で区切ってください。', 'swell' ) . __( '指定した文字列を含む全ページが対象となります。', 'swell' ),
			'class' => ( 'prefetch' !== $pjax_type ) ? '-disable' : '',
		]);

		Field::textarea( 'options', 'pjax_prevent_pages', [
			'label' => __( 'Pjaxで遷移させないページのURL', 'swell' ),
			'desc'  => __( '複数の場合は「,（+改行）」で区切ってください。', 'swell' ) . __( 'また、「http(s)://」から指定しない場合は、その文字列を含む全ページが対象となります。', 'swell' ),
			'class' => ( 'pjax' !== $pjax_type ) ? '-disable' : '',
		]);

	},
] );
