<?php
namespace SWELL_Theme\Utility;

if ( ! defined( 'ABSPATH' ) ) exit;

trait Balloon {

	/**
	 * テーブルデータの全取得
	 */
	public static function db_get_table_rows( $table_name ) {
		global $wpdb;
		$sql  = "SELECT * FROM {$table_name}";
		$rows = $wpdb->get_results( $sql, ARRAY_A );

		return $rows;
	}


	/**
	 * ふきだし用テーブルの作成処理
	 */
	public static function db_create_table( $table_name ) {
		global $wpdb;
		$collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE {$table_name} (
			id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			title text NOT NULL,
			data text DEFAULT NULL,
			order_no bigint(20) unsigned NOT NULL,
			PRIMARY KEY (id)
		) {$collate};";

		// テーブル作成関数の読み込み・実行
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );
	}

	/**
	 * 古いデータが残っているかどうか
	 */
	public static function has_old_balloon_data() {
		$the_query = new \WP_Query( [
			'post_type'      => 'speech_balloon',
			'no_found_rows'  => true,
			'posts_per_page' => 1,
			'fields'         => 'ids',
		] );

		return (bool) $the_query->post_count;
	}


	/**
	 * ふきだし用テーブル作成
	 */
	public static function create_balloon_table() {
		global $wpdb;
		$table_name = $wpdb->prefix . self::DB_TABLES['balloon'];

		if ( \SWELL_Theme::check_table_exists( $table_name ) ) return;

		\SWELL_Theme::db_create_table( $table_name );
	}


	/**
	 * ふきだし用テーブルの移行
	 */
	public static function migrate_balloon_table() {
		global $wpdb;
		$old_table_name = \SWELL_Theme::DB_TABLES['balloon'];
		$new_table_name = $wpdb->prefix . \SWELL_Theme::DB_TABLES['balloon'];

		// 旧テーブル（プレフィックスなしのswell_balloonテーブル）があるかどうか
		$old_table_exists = \SWELL_Theme::check_table_exists( $old_table_name );

		// 新テーブル（プレフィックスありのswell_balloonテーブル）があるかどうか
		$new_table_exists = \SWELL_Theme::check_table_exists( $new_table_name );

		// 旧テーブルが無い、または新テーブルが既にある場合は何もしない
		if ( ! $old_table_exists || $new_table_exists ) return;

		// 新テーブルの作成
		\SWELL_Theme::db_create_table( $new_table_name );

		// 旧テーブルから全吹き出しデータを取得
		$rows = \SWELL_Theme::db_get_table_rows( $old_table_name );

		if ( empty( $rows ) ) return;

		foreach ( $rows as $row ) {

			// レコード挿入
			$wpdb->insert(
				$new_table_name,
				[
					'id'       => $row['id'],
					'title'    => $row['title'],
					'data'     => $row['data'],
					'order_no' => $row['order_no'],
				],
				[ '%d', '%s', '%s', '%d' ]
			);
		}
	}


	/**
	 * ふきだしデータ
	 */
	public static function get_all_balloons() {
		global $wpdb;
		$table_name = $wpdb->prefix . self::DB_TABLES['balloon'];

		if ( \SWELL_Theme::check_table_exists( $table_name ) ) {
			return self::get_all_balloons__new();
		} else {
			return self::get_all_balloons__old();
		}
	}


	/**
	 * 新ふきだしデータをorder_no順で全取得
	 */
	public static function get_all_balloons__new() {
		global $wpdb;
		$table_name = $wpdb->prefix . self::DB_TABLES['balloon'];
		$sql        = "SELECT * FROM {$table_name} ORDER BY order_no DESC";
		$rows       = $wpdb->get_results( $sql, ARRAY_A );

		if ( empty( $rows ) ) return [];

		$return_data = [];
		foreach ( $rows as $row ) {
			$bln_data = json_decode( $row['data'], true );

			$return_data[ "id:{$row['id']}" ] = [
				'id'         => $row['id'],
				'title'      => $row['title'],
				'icon'       => $bln_data['icon'] ?? '',
				'name'       => $bln_data['name'] ?? '',
				'col'        => $bln_data['col'] ?? 'gray',
				'type'       => $bln_data['type'] ?? 'speaking',
				'align'      => $bln_data['align'] ?? 'left',
				'border'     => $bln_data['border'] ?? 'none',
				'shape'      => $bln_data['shape'] ?? 'circle',
				'spVertical' => $bln_data['spVertical'] ?? '',
				// 'order'  => $row['order_no'],
			];
		}

		return $return_data;
	}


	/**
	 * 全ふきだしデータ取得 - 旧
	 */
	public static function get_all_balloons__old() {
		$return_data = [];
		$the_query   = new \WP_Query( [
			'post_type'      => 'speech_balloon',
			'no_found_rows'  => true,
			'posts_per_page' => -1,
		] );

		while ( $the_query->have_posts() ) :
			$the_query->the_post();
			$balloon_id         = get_the_ID();
			$balloon_title      = get_the_title();
			$balloon_icon       = get_post_meta( $balloon_id, 'balloon_icon', true );
			$balloon_name       = get_post_meta( $balloon_id, 'balloon_icon_name', true ) ?: get_the_title();
			$balloon_col        = get_post_meta( $balloon_id, 'balloon_col', true );
			$balloon_type       = get_post_meta( $balloon_id, 'balloon_type', true );
			$balloon_align      = get_post_meta( $balloon_id, 'balloon_align', true );
			$balloon_border     = get_post_meta( $balloon_id, 'balloon_border', true );
			$balloon_icon_shape = get_post_meta( $balloon_id, 'balloon_icon_shape', true );

			$return_data[ "id:{$balloon_id}" ] = [
				'id'     => $balloon_id,
				'title'  => $balloon_title,
				'icon'   => $balloon_icon,
				'name'   => $balloon_name,
				'col'    => $balloon_col,
				'type'   => $balloon_type,
				'align'  => $balloon_align,
				'border' => $balloon_border,
				'shape'  => $balloon_icon_shape,
			];
		endwhile;
		wp_reset_postdata();

		return $return_data;
	}


	/**
	 * ふきだしデータ取得
	 */
	public static function get_balloon_data( $getby, $val ) {
		if ( ! $getby || ! $val ) return [];

		// キャッシュ取得
		$cache_key   = "balloon_{$getby}_{$val}";
		$cached_data = wp_cache_get( $cache_key, 'swell' );
		if ( $cached_data ) return $cached_data;

		global $wpdb;
		$table_name = $wpdb->prefix . self::DB_TABLES['balloon'];

		if ( \SWELL_Theme::check_table_exists( $table_name ) ) {
			$balloon_data = self::get_balloon_data__new( $getby, $val );
		} else {
			$balloon_data = self::get_balloon_data__old( $getby, $val );
		}

		wp_cache_set( $cache_key, $balloon_data, 'swell' );
		return $balloon_data;
	}


	/**
	 * ふきだしデータ取得 - 新
	 */
	public static function get_balloon_data__new( $getby, $val, $return_row = false ) {
		global $wpdb;

		$table_name = $wpdb->prefix . self::DB_TABLES['balloon'];
		if ( 'id' === $getby ) {
			$sql = "SELECT * FROM {$table_name} WHERE id = %d"; // IDでデータ取得
		} elseif ( 'title' === $getby ) {
			$sql = "SELECT * FROM {$table_name} WHERE title = %s";// タイトルでデータ取得
		}

		if ( ! $sql ) return [];

		$query   = $wpdb->prepare( $sql, $val );
		$results = $wpdb->get_row( $query, ARRAY_A );

		// 結果をそのまま返す場合はここで返す
		if ( $return_row ) return $results;

		if ( ! $results ) return [];

		return json_decode( $results['data'], true );
	}


	/**
	 * ふきだしデータ取得 - 旧
	 */
	public static function get_balloon_data__old( $getby, $val ) {
		$q_args = [
			'post_type'      => 'speech_balloon',
			'no_found_rows'  => true,
			'posts_per_page' => 1,
			'fields'         => 'ids',
		];

		if ( 'id' === $getby ) {
			$q_args['p'] = $val; // IDでデータ取得
		} elseif ( 'title' === $getby ) {
			$q_args['title'] = $val; // タイトルでデータ取得
		} else {
			return [];
		}

		// ふきだしセットの指定があれば取得
		$the_query = new \WP_Query( $q_args );
		if ( ! $the_query->have_posts() ) return [];

		$bln_id = $the_query->posts[0];
		wp_reset_postdata();

		if ( ! $bln_id ) return [];

		return [
			'icon'   => get_post_meta( $bln_id, 'balloon_icon', true ),
			'name'   => get_post_meta( $bln_id, 'balloon_icon_name', true ),
			'col'    => get_post_meta( $bln_id, 'balloon_col', true ),
			'type'   => get_post_meta( $bln_id, 'balloon_type', true ),
			'align'  => get_post_meta( $bln_id, 'balloon_align', true ),
			'border' => get_post_meta( $bln_id, 'balloon_border', true ),
			'shape'  => get_post_meta( $bln_id, 'balloon_icon_shape', true ),
		];
	}


	/**
	 * v2.5.7 → v.2.5.8で正常に移行できなかったデータのサルベージ
	 */
	public static function salvage_balloon_table() {

		global $wpdb;

		$old_table_name = \SWELL_Theme::DB_TABLES['balloon'];
		$new_table_name = $wpdb->prefix . \SWELL_Theme::DB_TABLES['balloon'];

		$old_rows = \SWELL_Theme::db_get_table_rows( $old_table_name );
		$new_rows = \SWELL_Theme::db_get_table_rows( $new_table_name );

		// 配列で取得できなかった場合
		if ( ! is_array( $old_rows ) || ! is_array( $new_rows ) ) {
			echo '<p>' . esc_html__( 'エラー: 配列データではありません。', 'swell' ) . '</p>';
		};

		// データ数が少なくなっている場合のみ続ける
		// if ( count( $old_rows ) <= count( $new_rows ) ) {
		// 	echo '<p>' . esc_html__( 'データの復旧は必要ありません。', 'swell' ) . '</p>';
		// };

		$message = '';

		foreach ( $old_rows  as $old_row ) {

			$is_migrated_row = false; // 移行できているレコードかどうかのフラグ

			foreach ( $new_rows as $new_row ) {
				if ( $new_row['id'] === $old_row['id'] ) {
					$is_migrated_row = true;
					break;
				}
			}

			// 正常に移行できていなかったものだけ処理
			if ( ! $is_migrated_row ) {

				// レコードを移行する
				$wpdb->insert(
					$new_table_name,
					[
						'id'       => $old_row['id'],
						'title'    => $old_row['title'],
						'data'     => $old_row['data'],
						'order_no' => $old_row['order_no'],
					],
					[ '%d', '%s', '%s', '%d' ]
				);

				$message .= '<p style="color: green;">' . sprintf( __( 'データ%sを復旧しました', 'swell' ), esc_html( $old_row['id'] ) . '-' . esc_html( $old_row['title'] ) ) . '</p>';
			}
		}

		if ( $message ) {
			echo $message; // phpcs:ignore WordPress.Security.EscapeOutput
		} else {
			echo '<p>' . esc_html__( '復旧が必要なデータは見つかりませんでした。', 'swell' ) . '</p>';
		}

	}

	/**
	 * 並び順の最大値を取得する
	 */
	public static function get_balloon_max_order( $table_name ) {
		global $wpdb;
		$sql   = "SELECT MAX(order_no) AS order_no FROM {$table_name}";
		$order = $wpdb->get_row( $sql, ARRAY_A );

		$order_no = $order ? $order['order_no'] : 1;
		return $order_no;
	}

}
