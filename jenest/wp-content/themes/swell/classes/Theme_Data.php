<?php
/**
 * テーマ内で利用するデータを定義する
 *
 * @package swell
 */
namespace SWELL_Theme;

/**
 * テーマで使用するデータ
 */
class Theme_Data {

	use \SWELL_Theme\Data\Default_Settings;

	// DB名
	const DB_NAME_CUSTOMIZER = 'loos_customizer';
	const DB_NAME_OPTIONS    = 'swell_options';
	const DB_NAME_EDITORS    = 'swell_editors';

	// new
	const DB_NAMES = [
		'customize'  => 'loos_customizer',
		'options'    => 'swell_options',
		'editors'    => 'swell_editors',
		'others'     => 'swell_others',
	];

	const MENU_SLUGS = [
		'basic'  => 'swell_settings',
		'editor' => 'swell_settings_editor',
	];

	// 独自テーブル
	const DB_TABLES = [
		'balloon'  => 'swell_balloon',
	];


	// カスタマイザー＆管理画面マージ用
	public static $setting = '';

	// カスタマイザー用
	public static $customize            = '';
	protected static $default_customize = '';

	// 設定画面用
	public static $options            = '';
	protected static $default_options = '';

	// エディター設定
	public static $editors            = '';
	protected static $default_editors = '';

	// version
	public static $swell_version = '';

	// ユーザー認証
	public static $licence_status = '';

	// update json path
	public static $update_dir_path = '';

	// ユーザーエージェント
	public static $user_agent = '';

	// サイトデータ
	public static $site_data = [];

	// NO IMG
	public static $noimg = [];

	// NONCE
	public static $nonce = [
		'name'   => 'swl_nonce',
		'action' => 'swl_nonce_action',
	];

	// リストレイアウト
	public static $list_layouts = [];

	// ぱんくずのJSONデータ保持用
	public static $bread_json_data = [];

	// PVカウント機能を利用する投稿タイプ
	public static $post_types_for_pvct = [ 'post' ];

	// 投稿リストのレイアウトタイプ
	public static $list_type = 'card';

	// EXCERPT_LENGTH
	public static $excerpt_length = 120;

	// プレースホルダー
	public static $placeholder = 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';
	// 6:2 data:image/gif;base64,R0lGODlhBgACAPAAAP///wAAACH5BAEAAAAALAAAAAAGAAIAAAIDhI9WADs=

	// lazyloadの種類
	public static $lazy_type = 'none';

	// 目次の生成フックがすでに処理されたかどうか
	public static $added_toc = false;

	// JSの読み込みを制御する変数
	public static $use = [];

	// そのページに使われているブロック
	public static $used_blocks = [];

	// キャッシュキー
	public static $cache_keys = [
		'style' => [ // スタイルに関わるキャッシュキー
			'style_common',
			'style_top',
			'style_single',
			'style_page',
			'style_archive',
			'style_other',
		],
		'header' => [ // ヘッダーに関わるキャッシュキー
			'header_top',
			'header_notop',
		],
		'post' => [ // 投稿に関わるキャッシュキー
			'home_posts',
			'home_posts_sp',
			'post_slider',
			'pickup_banner',
		],
		'widget' => [ // ウィジェット系キャッシュキー（「ヘッダー内部」を除く）
			'spmenu',
			'sidebar_top',
			'sidebar_top_sp',
			'sidebar_single',
			'sidebar_single_sp',
			'sidebar_page',
			'sidebar_page_sp',
			'sidebar_archive',
			'sidebar_archive_sp',
		],
		'others' => [
			'mv',
			'mv_info',
			'fix_bottom_menu',
			'sidebars_widgets',
		],
	];

	// サムネイル比率
	public static $thumb_ratios = [];


	/**
	 * 画像HTMLを許可する時にwp_ksesに渡す配列
	 */
	public static $allowed_img_html = [
		'img' => [
			'alt'     => true,
			'src'     => true,
			'secset'  => true,
			'class'   => true,
			'seizes'  => true,
			'width'   => true,
			'height'  => true,
			'loading' => true,
		],
	];


	/**
	 * テキスト系HTMLを許可する時にwp_ksesに渡す配列
	 */
	public static $allowed_text_html = [
		'a'      => [
			'href'   => true,
			'rel'    => true,
			'target' => true,
			'class'  => true,
		],
		'span'   => [
			'class' => true,
			'style' => true,
		],
		'b'      => [ 'class' => true ],
		'br'     => [ 'class' => true ],
		'i'      => [ 'class' => true ],
		'em'     => [ 'class' => true ],
		'code'   => [ 'class' => true ],
		'small'  => [ 'class' => true ],
		'strong' => [ 'class' => true ],
		'ul'     => [ 'class' => true ],
		'ol'     => [ 'class' => true ],
		'li'     => [ 'class' => true ],
		'p'      => [ 'class' => true ],
		'div'    => [ 'class' => true ],
		'img'    => [
			'alt'     => true,
			'src'     => true,
			'secset'  => true,
			'class'   => true,
			'seizes'  => true,
			'width'   => true,
			'height'  => true,
			'loading' => true,
		],
	];

	// 有効化中のプラグイン
	public static $active_plugins = [];

	// ウィジェットエリアの記録用
	public static $widget_area_in_output = '';


	/**
	 * data_init
	 */
	public static function data_init() {
		add_action( 'after_setup_theme', '\SWELL_Theme::set_variables', 1 );
		add_action( 'after_setup_theme', '\SWELL_Theme::set_default', 10 ); // setup.phpでの翻訳読み込みよりあと
		add_action( 'init', '\SWELL_Theme::set_options', 5 ); // set_customize よりも前。かつ、init8,9でこのデータ使うことに注意。
		add_action( 'init', '\SWELL_Theme::set_editors', 5 ); // set_customize よりも前で。
		add_action( 'init', '\SWELL_Theme::set_customize', 5 );
		add_action( 'init', '\SWELL_Theme::set_settings', 5 );
		add_action( 'admin_init', '\SWELL_Theme::set_admin_init', 1 );

		// memo: initだとまだタイミングが早くカスタマイザーの変更を即時反映できないので、改めてデータ取得
		if ( is_customize_preview() ) {
			add_action( 'wp_loaded', '\SWELL_Theme::set_customize', 10 );
			add_action( 'wp_loaded', '\SWELL_Theme::set_settings', 10 );
		}
	}

	/**
	 * 動的な変数をセット
	 */
	public static function set_variables() {

		// SWELLバージョンをセット
		self::$swell_version = wp_get_theme( 'swell' )->Version;

		// ユーザーエージョントを小文字化して取得 @codingStandardsIgnoreStart
		$user_agent       = isset( $_SERVER['HTTP_USER_AGENT'] ) ? $_SERVER['HTTP_USER_AGENT'] : '';
		self::$user_agent = mb_strtolower( $user_agent ); // @codingStandardsIgnoreEnd

		// IS_MOBILE （ユーザーエージョントで判定）
		define( 'IS_MOBILE', \SWELL_Theme::get_is_mobile() );

		self::$site_data = [
			'home'  => home_url( '/' ),
			'title' => get_option( 'blogname' ),
		];

		// 後方互換用
		define( 'HOME', home_url( '/' ) );
		define( 'TITLE', \SWELL_Theme::site_data( 'title' ) );
	}


	/**
	 * デフォルト値をセット
	 */
	public static function set_default() {

		// 設定データ
		self::$default_options = self::set_default_options();

		// エディター設定のデータ
		self::$default_editors = self::set_default_editor_options();

		// カスタマイザー デフォルト値のセット
		self::$default_customize = self::set_default_customizer();
	}


	/**
	 * $default_customize 取得
	 */
	public static function get_default_customize( $key = null ) {

		if ( null !== $key ) {
			return self::$default_customize[ $key ] ?? '';
		}
		return self::$default_customize;
	}


	/**
	 * $default_options 取得
	 */
	public static function get_default_option( $key = null ) {

		if ( null !== $key ) {
			return self::$default_options[ $key ];
		}
		return self::$default_options;
	}


	/**
	 * $default_editors 取得
	 */
	public static function get_default_editor( $key = null ) {

		if ( null !== $key ) {
			return self::$default_editors[ $key ];
		}
		return self::$default_editors;
	}


	/**
	 * エディター設定をセット
	 */
	public static function set_editors() {
		$editors       = get_option( self::DB_NAME_EDITORS ) ?: [];
		self::$editors = array_merge( self::$default_editors, $editors );
	}


	/**
	 * 管理画面での設定をセット
	 */
	public static function set_options() {
		$options       = get_option( self::DB_NAME_OPTIONS ) ?: [];
		self::$options = array_merge( self::$default_options, $options );
	}


	/**
	 * カスタマイザー の設定項目をセット
	 */
	public static function set_customize() {
		$customize       = get_option( self::DB_NAME_CUSTOMIZER ) ?: [];
		self::$customize = array_merge( self::$default_customize, $customize );
	}


	/**
	 * 設定データのマージ(互換性を保つために $SETTING に全部まとめる )
	 * ※ $editorsは独立済み
	 */
	public static function set_settings() {
		self::$setting = array_merge( self::$customize, self::$options );
	}


	/**
	 * settingsデータを個別でセット
	 */
	public static function set_setting( $key = null, $val = '' ) {
		if ( null === $key ) return;
		self::$setting[ $key ] = $val;
	}


	/**
	 * get_setting
	 */
	public static function get_setting( $key = null ) {

		if ( null !== $key ) {
			if ( ! isset( self::$setting[ $key ] ) ) return '';
			return self::$setting[ $key ];
		}
		return self::$setting;
	}


	/**
	 * get_customize
	 */
	public static function get_customize( $key = null ) {

		if ( null !== $key ) {
			if ( ! isset( self::$customize[ $key ] ) ) return '';
			return self::$customize[ $key ];
		}
		return self::$customize;
	}


	/**
	 * get_option
	 */
	public static function get_option( $key = null ) {

		if ( null !== $key ) {
			if ( ! isset( \SWELL_Theme::$options[ $key ] ) ) return '';
			return \SWELL_Theme::$options[ $key ];
		}
		return \SWELL_Theme::$options;
	}


	/**
	 * get_editor
	 */
	public static function get_editor( $key = null ) {

		if ( null !== $key ) {
			if ( ! isset( \SWELL_Theme::$editors[ $key ] ) ) return '';
			return \SWELL_Theme::$editors[ $key ];
		}
		return \SWELL_Theme::$editors;
	}


	/**
	 * get_data
	 *  $customize or $option or $editor から取得
	 */
	public static function get_data( $db_name, $key = null ) {

		$db_data = \SWELL_Theme::$$db_name ?? null;
		if ( ! $db_data ) return '';

		if ( null !== $key ) {
			if ( ! isset( $db_data[ $key ] ) ) return '';
			return $db_data[ $key ];
		}
		return $db_data;
	}

	/**
	 * admin_init
	 */
	public static function set_admin_init() {
		\SWELL_Theme\License::check_swlr( get_option( 'sweller_email' ), 'auto' );

		// 以下、管理者のみ
		if ( ! current_user_can( 'manage_options' ) ) return;

		// require_once ABSPATH . 'wp-admin/includes/plugin.php';
		if ( ! function_exists( 'get_plugins' ) ) return;

		$plugins = get_plugins();
		foreach ( $plugins as $path => $plugin ) {
			if ( is_plugin_active( $path ) ) {
				\SWELL_Theme::$active_plugins[ $path ] = [
					'name' => $plugin['Name'],
					'ver'  => $plugin['Version'],
				];
			}
		}
	}

	/**
	 * get_others_data
	 */
	public static function get_others_data( $key = null ) {

		$others_data = get_option( self::DB_NAMES['others'] ) ?: [];

		if ( null !== $key ) {
			return $others_data[ $key ] ?? '';
		}
		return $others_data;
	}

	/**
	 * set_others_data
	 */
	public static function set_others_data( $key, $value ) {
		$others_data         = (array) self::get_others_data();
		$others_data[ $key ] = $value;
		\update_option( self::DB_NAMES['others'], $others_data );
	}
}
