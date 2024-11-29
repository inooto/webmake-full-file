<?php
namespace SWELL_Theme;

use \SWELL_THEME\Menu as Menu;

if ( ! defined( 'ABSPATH' ) ) exit;

class Admin_Menu {

	private static $instance;

	// ページスラッグ
	const PAGE_SLUG = [
		'settings' => 'swell_settings',
		'balloon'  => 'swell_balloon',
	];

	const SUB_PAGE_SLUG = [
		'editor'   => 'swell_settings_editor',
		'ads'      => 'swell_settings_ads',
		'swellers' => 'swell_settings_swellers',
	];

	// グループ名
	const SETTING_GROUPS = [
		'options' => 'swell_setting_group_options',
		'editors' => 'swell_setting_group_editors',
	];

	// settings_field() と settings_section() で使う $page
	const PAGE_NAMES = [
		// basic
		'speed'     => 'swell_settings_speed',
		'structure' => 'swell_settings_structure',
		'jquery'    => 'swell_settings_jquery',
		'fa'        => 'swell_settings_fa',
		'remove'    => 'swell_settings_remove',
		'ad'        => 'swell_settings_ad',

		// editor
		'colors'    => 'swell_settings_block_colors',
		'border'    => 'swell_settings_block_border',
		'btn'       => 'swell_settings_block_btn',
		'marker'    => 'swell_settings_block_marker',
		'iconbox'   => 'swell_settings_block_iconbox',
		'balloon'   => 'swell_settings_block_balloon',
		'others'    => 'swell_settings_block_others',
		'custom'    => 'swell_settings_block_custom',

	];

	/**
	 * コンストラクタ
	 */
	public function __construct() {

		add_action( 'admin_menu', [ __CLASS__, 'hook_admin_menu' ] );
		add_action( 'admin_init', [ __CLASS__, 'hook_admin_init' ] );
	}


	/**
	 * 管理画面に独自メニューを追加
	 */
	public static function hook_admin_menu() {

		// 「SWELL設定」を追加
		add_menu_page(
			__( 'SWELL設定', 'swell' ), // ページタイトルタグ
			__( 'SWELL設定', 'swell' ), // メニュータイトル
			'manage_options', // 必要な権限
			self::PAGE_SLUG['settings'], // このメニューを参照するスラッグ名
			[__CLASS__, 'swell_setting' ], // 表示内容
			'', // アイコン
			29 // 管理画面での表示位置
		);

		// 「ふきだし」を追加
		if ( ! \SWELL_Theme::get_option( 'remove_balloon' ) ) {
			add_menu_page(
				__( 'ふきだし', 'swell' ), // ページタイトルタグ
				__( 'ふきだし', 'swell' ), // メニュータイトル
				'edit_posts', // 必要な権限
				self::PAGE_SLUG['balloon'], // このメニューを参照するスラッグ名
				[__CLASS__, 'balloon_setting' ], // 表示内容
				'', //'dashicons-format-chat', // アイコン
				28 // 管理画面での表示位置
			);
		}

		// トップメニュー複製
		add_submenu_page(
			self::PAGE_SLUG['settings'],
			__( 'SWELL設定', 'swell' ),
			__( 'SWELL設定', 'swell' ), // サブ側の名前
			'manage_options',
			self::PAGE_SLUG['settings'], // 親と同じに
			[__CLASS__, 'swell_setting' ]
		);
		// サブメニュー
		add_submenu_page(
			self::PAGE_SLUG['settings'],
			__( 'エディター設定', 'swell' ),
			__( 'エディター設定', 'swell' ),
			'manage_options',
			self::SUB_PAGE_SLUG['editor'],
			[__CLASS__, 'editor_setting' ]
		);

		$adstxt_title = sprintf( __( '%sを編集', 'swell' ), 'ads.txt' );

		// サブメニュー
		add_submenu_page(
			self::PAGE_SLUG['settings'],
			$adstxt_title,
			$adstxt_title,
			'manage_options',
			self::SUB_PAGE_SLUG['ads'],
			[__CLASS__, 'ads_txt_setting' ]
		);
		add_submenu_page(
			self::PAGE_SLUG['settings'],
			__( 'アクティベート', 'swell' ),
			__( 'アクティベート', 'swell' ),
			'manage_options',
			self::SUB_PAGE_SLUG['swellers'],
			[__CLASS__, 'swellers_id_setting' ]
		);

		// 「パターン」を追加
		$reuse_block_name = \SWELL_Theme::wpver_is_above( '6.3' ) ? __( 'パターン', 'swell' ) : __( '再利用ブロック', 'swell' );
		add_menu_page(
			$reuse_block_name,
			$reuse_block_name,
			'manage_options',
			'edit.php?post_type=wp_block',
			'',
			'dashicons-image-rotate',
			81 // 「設定」 の下
		);
	}

	/**
	 * 「SWELL設定」の内容
	 */
	public static function swell_setting() {
		require_once T_DIRE . '/lib/menu/swell_menu.php';
	}

	/**
	 * 「ふきだし」の内容
	 */
	public static function balloon_setting() {
		require_once T_DIRE . '/lib/menu/swell_menu_balloon.php';
	}

	/**
	 * サブメニューの表示内容
	 */
	public static function editor_setting() {
		require_once T_DIRE . '/lib/menu/swell_menu_editor.php';
	}

	public static function ads_txt_setting() {
		require_once T_DIRE . '/lib/menu/swell_menu_ads.php';
	}
	public static function swellers_id_setting() {
		require_once T_DIRE . '/lib/menu/swell_menu_swellers.php';
	}


	/**
	 * 設定の追加
	 */
	public static function hook_admin_init() {

		// 同じオプションに配列で値を保存するので、register_setting()は１つだけ
		register_setting( self::SETTING_GROUPS['options'], \SWELL_Theme::DB_NAME_OPTIONS );
		register_setting( self::SETTING_GROUPS['editors'], \SWELL_Theme::DB_NAME_EDITORS );

		// SWELL設定
		include_once T_DIRE . '/lib/menu/settings/speed.php';
		include_once T_DIRE . '/lib/menu/settings/structure_data.php';
		include_once T_DIRE . '/lib/menu/settings/jquery.php';
		include_once T_DIRE . '/lib/menu/settings/font_awesome.php';
		include_once T_DIRE . '/lib/menu/settings/remove.php';
		include_once T_DIRE . '/lib/menu/settings/ad_code.php';

		// エディター設定
		Menu\Tab_Colors::palette_settings( self::PAGE_NAMES['colors'] );
		Menu\Tab_Colors::list_settings( self::PAGE_NAMES['colors'] );
		Menu\Tab_Colors::capblock_settings( self::PAGE_NAMES['colors'] );
		Menu\Tab_Colors::faq_settings( self::PAGE_NAMES['colors'] );
		Menu\Tab_Colors::table_settings( self::PAGE_NAMES['colors'] );

		Menu\Tab_Border::border_settings( self::PAGE_NAMES['border'] );
		Menu\Tab_Marker::marker_settings( self::PAGE_NAMES['marker'] );
		Menu\Tab_Btn::btn_settings( self::PAGE_NAMES['btn'] );
		Menu\Tab_Iconbox::small_settings( self::PAGE_NAMES['iconbox'] );
		Menu\Tab_Iconbox::big_settings( self::PAGE_NAMES['iconbox'] );
		Menu\Tab_Balloon::balloon_settings( self::PAGE_NAMES['balloon'] );
		Menu\Tab_Others::blogcard_settings( self::PAGE_NAMES['others'] );
		Menu\Tab_Others::blockquote_settings( self::PAGE_NAMES['others'] );
		Menu\Tab_Custom::custom_format_set_settings( self::PAGE_NAMES['custom'] );
		Menu\Tab_Custom::custom_format_settings( self::PAGE_NAMES['custom'] );
		Menu\Tab_Custom::custom_format_css_editor( self::PAGE_NAMES['custom'] );
	}

}
