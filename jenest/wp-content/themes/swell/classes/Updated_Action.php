<?php
namespace SWELL_Theme;

if ( ! defined( 'ABSPATH' ) ) exit;

class Updated_Action {

	private static $customizer_data       = '';
	private static $options_data          = '';
	private static $editors_data          = '';
	private static $is_changed_customizer = false;
	private static $is_changed_options    = false;
	private static $is_changed_editors    = false;

	public static function set_data() {
		self::$customizer_data = get_option( \SWELL_Theme::DB_NAME_CUSTOMIZER ) ?: [];
		self::$options_data    = get_option( \SWELL_Theme::DB_NAME_OPTIONS ) ?: [];
		self::$editors_data    = get_option( \SWELL_Theme::DB_NAME_EDITORS ) ?: [];
	}

	public static function db_update() {
		self::set_data();

		self::change_key_at_customizer();

		// 2.0.3
		self::moving_db_to_options();

		// 2.0.5
		self::moving_db_to_editors();

		// optionsのデータを変更
		self::change_db_in_options();

		// 2.4.2 : 画像のURL -> ID
		self::media_url_to_id();

		// 変更があれば、設定を更新
		if ( self::$is_changed_customizer ) {
			update_option( \SWELL_Theme::DB_NAME_CUSTOMIZER, self::$customizer_data );
		}
		if ( self::$is_changed_options ) {
			update_option( \SWELL_Theme::DB_NAME_OPTIONS, self::$options_data );
		}
		if ( self::$is_changed_editors ) {
			update_option( \SWELL_Theme::DB_NAME_EDITORS, self::$editors_data );
		}
	}



	/**
	 * キーの変更
	 */
	public static function change_key_at_customizer() {

		$SETTINGS  = self::$customizer_data;
		$is_change = false;

		// 完全にキーを切り替えるパターン
		$change_keys = [
			'pos_info_bar'      => 'info_bar_pos',
			'notice_bar_effect' => 'info_bar_effect',
			'flow_info_bar'     => 'info_flowing',
			'color_notice_text' => 'color_info_text',
			'color_notice_bg'   => 'color_info_bg',
			'color_notice_bg2'  => 'color_info_bg2',
			'color_notice_btn'  => 'color_info_btn',
		];
		foreach ( $change_keys as $old_key => $new_key ) {
			// 新しいキーがまだなく、古いキーでデータを持つ時。
			if ( ! isset( $SETTINGS[ $new_key ] ) && isset( $SETTINGS[ $old_key ] ) ) {
				$SETTINGS[ $new_key ] = $SETTINGS[ $old_key ];
				unset( $SETTINGS[ $old_key ] );
				$is_change = true;
			}
		}

		// １つの設定を2つに切り分けるパターン
		$change_keys = [
			'page_title_style' => 'archive_title_style',
		];
		foreach ( $change_keys as $old_key => $new_key ) {
			// 新しいキーがまだなく、古いキーでデータを持つ時。 (unsetはしない)
			if ( ! isset( $SETTINGS[ $new_key ] ) && isset( $SETTINGS[ $old_key ] ) ) {
				$SETTINGS[ $new_key ] = $SETTINGS[ $old_key ];
				$is_change            = true;
			}
		}

		// 2.3.9
		if ( isset( $SETTINGS['frame_only_post'] ) && $SETTINGS['frame_only_post'] ) {
			$SETTINGS['frame_scope'] = 'post_page';
			unset( $SETTINGS['frame_only_post'] );
			$is_change = true;
		}

		if ( $is_change ) {
			self::$customizer_data       = $SETTINGS;
			self::$is_changed_customizer = true;
		}
	}


	/**
	 * カスタマイザーデータの一部を options へ
	 */
	public static function moving_db_to_options() {

		$is_change = false;
		$SETTINGS  = self::$customizer_data;
		$OPTIONS   = self::$options_data;

		// 移動させたいキー
		$move_keys = \SWELL_Theme::get_default_option();

		// カスタマイザーで既に設定している場合、それを options へ移動。
		foreach ( $move_keys as $key => $value ) {

			// $OPTIONS にはまだデータがなくて、かつ $SETTINGS に残っている時
			if ( isset( $SETTINGS[ $key ] ) && ! isset( $OPTIONS[ $key ] ) ) {
				$OPTIONS[ $key ] = $SETTINGS[ $key ];
				unset( $SETTINGS[ $key ] );
				$is_change = true;
			}
		}

		// 2.1.9
		if ( isset( $SETTINGS['use_luminous'] ) && ! isset( $OPTIONS['remove_luminous'] ) ) {
			if ( $SETTINGS['use_luminous'] ) {
				$OPTIONS['remove_luminous'] = '';
			} else {
				$OPTIONS['remove_luminous'] = '1';
			}
			unset( $SETTINGS['use_luminous'] );
			$is_change = true;
		}

		if ( $is_change ) {
			self::$customizer_data       = $SETTINGS;
			self::$options_data          = $OPTIONS;
			self::$is_changed_customizer = true;
			self::$is_changed_options    = true;
		}
	}


	/**
	 * カスタマイザーデータの一部を editors へ
	 */
	public static function moving_db_to_editors() {

		$is_change = false;
		$SETTINGS  = self::$customizer_data;
		$EDITORS   = self::$editors_data;

		$switch_keys = [
			'color_font_red'     => 'color_deep01',
			'color_font_blue'    => 'color_deep02',
			'color_font_green'   => 'color_deep03',
			'color_cap_01'       => '',
			'color_cap_01_light' => '',
			'color_cap_02'       => '',
			'color_cap_02_light' => '',
			'color_cap_03'       => '',
			'color_cap_03_light' => '',
			'iconbox_type'       => '',
			'iconbox_s_type'     => '',
			'blockquote_type'    => '',

			// 2.0.7
			'marker_type'        => '',
			'color_mark_blue'    => '',
			'color_mark_green'   => '',
			'color_mark_yellow'  => '',
			'color_mark_orange'  => '',

			'color_btn_red'      => '',
			'color_btn_red2'     => '',
			'color_btn_blue'     => '',
			'color_btn_blue2'    => '',
			'color_btn_green'    => '',
			'color_btn_green2'   => '',
			'btn_radius_normal'  => '',
			'btn_radius_solid'   => '',
			'btn_radius_shiny'   => '',
			'btn_radius_flat'    => 'btn_radius_line',
			'is_btn_gradation'   => '',
		];

		foreach ( $switch_keys as $old_key => $new_key ) {

			$new_key = $new_key ?: $old_key; // new key の指定がなければ同じキーで移動させる

			// $EDITORS にはまだデータがなくて、かつ $SETTINGS に残っている時
			if ( isset( $SETTINGS[ $old_key ] ) && ! isset( $EDITORS[ $new_key ] ) ) {
				$is_change           = true;
				$EDITORS[ $new_key ] = $SETTINGS[ $old_key ];
				unset( $SETTINGS[ $old_key ] );
			}
		}

		if ( $is_change ) {
			self::$customizer_data       = $SETTINGS;
			self::$editors_data          = $EDITORS;
			self::$is_changed_customizer = true;
			self::$is_changed_editors    = true;
		}
	}


	/**
	 * options のデータを変更する
	 */
	public static function change_db_in_options() {
		$is_change = 0;
		$OPTIONS   = self::$options_data;

		// 2.5.0
		if ( isset( $OPTIONS['use_lazyload'] ) ) {
			$now_option = $OPTIONS['use_lazyload'];
			if ( 'swell' === $now_option || '1' === $now_option ) {
				$OPTIONS['lazy_type'] = 'lazysizes';

			} elseif ( 'core' === $now_option || '' === $now_option ) {
				$OPTIONS['lazy_type'] = 'lazy';

			} else {
				$OPTIONS['lazy_type'] = 'none';

			}
			unset( $OPTIONS['use_lazyload'] );
			$is_change = 1;
		}

		if ( $is_change ) {
			self::$options_data       = $OPTIONS;
			self::$is_changed_options = true;
		}
	}


	/**
	 * 画像URLで保存してたものをIDに変換
	 */
	public static function media_url_to_id() {
		$SETTINGS   = self::$customizer_data;
		$is_changed = 0;

		// デモサイトのロゴを削除
		if ( isset( $SETTINGS['logo'] ) && false !== strpos( $SETTINGS['logo'], 'demo.swell-theme.com' ) ) {
			unset( $SETTINGS['logo'] );
			$is_changed = 1;
		}
		if ( isset( $SETTINGS['logo_top'] ) && false !== strpos( $SETTINGS['logo_top'], 'demo.swell-theme.com' ) ) {
			unset( $SETTINGS['logo_top'] );
			$is_changed = 1;
		}

		$switch_keys = [
			'logo'              => 'logo_id',
			'logo_top'          => 'logo_top_id',
			'no_image'          => 'noimg_id',
			'ttlbg_default_img' => 'ttlbg_dflt_imgid',
			'slider1_img'       => 'slider1_imgid',
			'slider1_img_sp'    => 'slider1_imgid_sp',
			'slider2_img'       => 'slider2_imgid',
			'slider2_img_sp'    => 'slider2_imgid_sp',
			'slider3_img'       => 'slider3_imgid',
			'slider3_img_sp'    => 'slider3_imgid_sp',
			'slider4_img'       => 'slider4_imgid',
			'slider4_img_sp'    => 'slider4_imgid_sp',
			'slider5_img'       => 'slider5_imgid',
			'slider5_img_sp'    => 'slider5_imgid_sp',
			'bg_pickup'         => 'ps_bgimg_id',

		];
		foreach ( $switch_keys as $url_key => $id_key ) {
			if ( isset( $SETTINGS[ $url_key ] ) ) {
				$img_url = $SETTINGS[ $url_key ];

				$img_id = attachment_url_to_postid( $img_url ) ?: 0;

				if ( $img_id ) {
					unset( $SETTINGS[ $url_key ] );
					$SETTINGS[ $id_key ] = $img_id;
					$is_changed          = 1;
				}
			}
		}

		if ( $is_changed ) {
			self::$customizer_data       = $SETTINGS;
			self::$is_changed_customizer = true;
		}
	}

}
