<?php
namespace SWELL_Theme;

use \SWELL_Theme as SWELL;

if ( ! defined( 'ABSPATH' ) ) exit;

class License {

	public static $status_transient_key  = 'swlr_user_status';
	public static $waiting_transient_key = 'swlr_is_waiting_activate';


	/**
	 * ステータスキャッシュ削除
	 */
	public static function delete_status_cache() {
		delete_transient( self::$status_transient_key );
	}


	/**
	 * ユーザー照合
	 */
	public static function check_swlr( $email = '', $action_type = '' ) {

		// キャッシュをチェック
		$cached_data = get_transient( self::$status_transient_key );
		if ( false !== $cached_data ) {
			SWELL::$licence_status  = $cached_data['status'] ?? '';
			SWELL::$update_dir_path = $cached_data['path'] ?? '';

			// waitingの時間から３分経過した場合
			if ( 'waiting' === SWELL::$licence_status && ! get_transient( self::$waiting_transient_key ) ) {
				SWELL::$licence_status = 'timeout';
			}
		} elseif ( $email ) {
			// キャッシュがなく、email設定がある → 認証リクエスト開始

			// API接続
			$response = wp_remote_post(
				'https://users.swell-theme.com/?swlr-api=activation',
				[
					'timeout'     => 3,
					'redirection' => 5,
					'sslverify'   => false,
					'headers'     => [ 'Content-Type: application/json' ],
					'body'        => [
						'email'       => $email,
						'domain'      => str_replace( [ 'http://', 'https://' ], '', home_url() ),
						'action_type' => $action_type,
					],
				]
			);

			if ( ! is_wp_error( $response ) ) {
				$response_data = json_decode( $response['body'], true );

				SWELL::$licence_status  = $response_data['status'] ?? '';
				SWELL::$update_dir_path = $response_data['path'] ?? '';

				// ワンタイム認証待ちの時
				if ( 'waiting' === SWELL::$licence_status ) {
					// まだ有効期間中は上書きしない
					if ( ! get_transient( self::$waiting_transient_key ) ) {
						set_transient( self::$waiting_transient_key, 1, 3 * MINUTE_IN_SECONDS );
					}
				}
				set_transient( self::$status_transient_key, $response_data, 30 * DAY_IN_SECONDS );
			}
		} else {

			// email空の時
			SWELL::$licence_status  = '';
			SWELL::$update_dir_path = '';
		}

		// SWELL::$update_dir_path セットした上で、パス変更をチェック
		if ( self::is_change_update_dir() ) {
			delete_transient( self::$status_transient_key );
		}
	}


	/**
	 * update pathに変更がないかチェック
	 */
	public static function is_change_update_dir() {

		$dir_ver = \SWELL_Theme::get_swl_json_dir();
		// 未認証でパスが取得できていない場合
		if ( ! SWELL::$update_dir_path ) return false;

		$dir_ver = \SWELL_Theme::get_swl_json_dir();

		// /v1-hoge → /v2-foo などに変わってるかどうか
		if ( $dir_ver && false === strpos( SWELL::$update_dir_path, "/{$dir_ver}" ) ) {
			return true;
		}

		return false;
	}


	/**
	 * 認証削除
	 */
	public static function delete_swlr( $email = '' ) {
		update_option( 'sweller_email', '' );
		self::delete_status_cache();

		SWELL::$licence_status  = '';
		SWELL::$update_dir_path = '';

		// SWELLERS側でも削除
		if ( $email ) {
			$response = wp_remote_post(
				'https://users.swell-theme.com/?swlr-api=deactivate',
				[
					'timeout'     => 3,
					'redirection' => 5,
					'sslverify'   => false,
					'headers'     => [ 'Content-Type: application/json' ],
					'body'        => [
						'email' => $email,
						'url'   => str_replace( [ 'http://', 'https://' ], '', home_url() ),
					],
				]
			);
		}
	}
}
