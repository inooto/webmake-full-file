<?php
namespace SWELL_Theme\Updated_Action;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * バージョン更新時の処理
 */
add_action( 'init', '\SWELL_Theme\Updated_Action\updated_hook', 1 );
function updated_hook() {

	$now_ver  = \SWELL_Theme::$swell_version;
	$old_ver  = get_option( 'swell_version' ); // データベースに保存されているバージョン
	$free_ver = get_option( 'swell_free_version' );

	if ( $free_ver ) {
		// 無料版からの移行であれば
		delete_option( 'swell_free_version' );
		$old_ver = $free_ver;
	}

	// まだバージョン情報が記憶されていなければ(初回インストール時)
	if ( false === $old_ver ) {

		update_option( 'swell_version', $now_ver ); // 現在のバージョンをDBに記憶
		all_cache_delete();

		// どの時点の規約に同意して購入したか
		$today        = (int) wp_date( 'Ymd' );
		$last_changed = (int) \SWELL_Theme::get_term_changed_date();
		if ( $today > $last_changed ) {
			\SWELL_Theme::set_others_data( 'checked_terms_' . $last_changed, true );
		}
	} elseif ( $old_ver !== $now_ver ) {
		// バージョンが更新されていれば、アップデート時に一度だけ処理

		update_option( 'swell_version', $now_ver ); // 現在のバージョンをDBに記憶

		// バージョンアップ時の処理
		all_cache_delete();
		\SWELL_Theme\Updated_Action::db_update();

		// 特定のバージョンより古いとこからアップデートされた時に処理する
		if ( version_compare( $old_ver, '2.5.6.5', '<=' ) ) {
			\SWELL_Theme::clean_post_metas();
			\SWELL_Theme::clean_term_metas();
		} elseif ( version_compare( $old_ver, '2.5.7', '=' ) ) {
			\SWELL_Theme::clean_term_metas( '2.5.7' );
			\SWELL_Theme::migrate_balloon_table(); // ふきだしセットのテーブル修正処理
		}
	}
}


/**
 * SWELL用 transientキャッシュをすべて削除
 */
function all_cache_delete() {
	\SWELL_Theme::clear_cache();
	\SWELL_Theme::clear_all_parts_cache_by_wpdb(); // 念のため、query回して削除
}
