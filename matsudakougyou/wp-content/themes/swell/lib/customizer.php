<?php
namespace SWELL_Theme\Customizer;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * プレビュー画面でTab / Mobileのデバイス情報を取得できるようにする
 */
add_action( 'customize_controls_init', __NAMESPACE__ . '\add_device_query' );
function add_device_query() {
	global $wp_customize;
	$previewed_device_name = null;

	// デバイス情報の取得
	$previewed_devices = $wp_customize->get_previewable_devices();
	foreach ( $previewed_devices as $device => $params ) {
		if ( isset( $params['default'] ) && true === $params['default'] ) {
			$previewed_device_name = $device;
			break;
		}
	}
	if ( $previewed_device_name ) {
		$wp_customize->set_preview_url(
			add_query_arg( 'customize_previewed_device', $previewed_device_name, $wp_customize->get_preview_url() )
		);
	}
}


/**
 * カスタマイザー画面で読み込むファイル
 */
add_action( 'customize_controls_enqueue_scripts', __NAMESPACE__ . '\load_scripts' );
function load_scripts() {
	// プレビュー画面の更新 & デバイス情報の受け渡し
	$prev_handle = 'customizer-responsive-device-preview';
	wp_enqueue_script(
		$prev_handle,
		T_DIRE_URI . '/build/js/customizer/responsive-device-preview.min.js',
		[ 'customize-controls' ],
		SWELL_VERSION,
		false
	);
	wp_add_inline_script( $prev_handle, 'CustomizerResponsiveDevicePreview.init( wp.customize );', 'after' );

	// 設定項目の表示・非表示を切り替える処理
	wp_enqueue_script(
		'swell-customizer-controls',
		T_DIRE_URI . '/build/js/customizer/customizer-controls.min.js',
		[],
		SWELL_VERSION,
		false
	);
}


/**
 * カスタマイザー 登録
 */
add_action( 'customize_register', __NAMESPACE__ . '\register_customize_settings', 99 );
function register_customize_settings( $wp_customize ) {

	\SWELL_Theme::$setting = get_option( \SWELL_Theme::DB_NAME_CUSTOMIZER ) ?: [];

	// デフォルトカスタマイザーの削除
	$wp_customize->remove_section( 'background_image' ); // 背景画像
	$wp_customize->remove_section( 'header_image' ); // ヘッダーメディア

	// サイト共通設定
	include_once T_DIRE . '/lib/customizer/wp_setting.php';

	// サイト共通設定
	include_once T_DIRE . '/lib/customizer/common.php';

	// ヘッダー設定
	include_once T_DIRE . '/lib/customizer/header.php';

	// フッター設定
	include_once T_DIRE . '/lib/customizer/footer.php';

	// サイドバー
	include_once T_DIRE . '/lib/customizer/sidebar.php';

	// トップページ
	include_once T_DIRE . '/lib/customizer/top.php';

	// 投稿・固定ページ
	include_once T_DIRE . '/lib/customizer/post_page.php';

	// アーカイブページ
	include_once T_DIRE . '/lib/customizer/archive.php';

	// 記事一覧リスト
	include_once T_DIRE . '/lib/customizer/post_list.php';

	// SNS情報
	include_once T_DIRE . '/lib/customizer/sns.php';

	// 高度な設定
	include_once T_DIRE . '/lib/customizer/advanced.php';

}
