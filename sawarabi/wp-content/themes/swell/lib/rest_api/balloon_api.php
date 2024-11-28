<?php
namespace SWELL_Theme\REST_API;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * エンドポイントを追加
 * callback では、returnで返すとそのままのデータを渡せる。wp_dieを使うと {code: 'wp_die', message: 'wp_dieで出力した文字列', ...}
 */
register_rest_route('wp/v2', '/swell-balloon', [
	// データの取得
	[
		'methods'             => 'GET',
		'permission_callback' => function( $request ) {
			return current_user_can( 'read_speech_balloons' );
		},
		'callback'            => function( $request ) {

			global $wpdb;
			$table_name = $wpdb->prefix . \SWELL_Theme::DB_TABLES['balloon'];
			if ( ! \SWELL_Theme::check_table_exists( $table_name ) ) wp_die( esc_html__( 'テーブルがありません。', 'swell' ) );

			// データ取得
			if ( isset( $request['id'] ) ) {
				// 1件取得
				$row = \SWELL_Theme::get_balloon_data__new( 'id', $request['id'], true );
				return [
					'id'    => $row['id'],
					'title' => $row['title'],
					'data'  => json_decode( $row['data'], true ),
					'order' => $row['order_no'],
				];
			} else {
				// 全件取得
				$sql  = "SELECT * FROM {$table_name} ORDER BY order_no DESC";
				$rows = $wpdb->get_results( $sql, ARRAY_A );

				if ( ! $rows ) return [];

				$results = [];
				foreach ( $rows as $row ) {
					$results[] = [
						'id'    => $row['id'],
						'title' => $row['title'],
						'data'  => json_decode( $row['data'], true ),
						'order' => $row['order_no'],
					];
				}

				return $results;
			}
		},
	],
	// データの登録・更新
	[
		'methods'             => 'POST',
		'permission_callback' => function( $request ) {
			return current_user_can( 'edit_speech_balloons' );
		},
		'callback'            => function( $request ) {

			global $wpdb;
			$table_name = $wpdb->prefix . \SWELL_Theme::DB_TABLES['balloon'];
			if ( ! \SWELL_Theme::check_table_exists( $table_name ) ) wp_die( esc_html__( 'テーブルがありません。', 'swell' ) );

			$id    = isset( $request['id'] ) ? $request['id'] : null;
			$data  = isset( $request['data'] ) ? json_encode( $request['data'] ) : null;
			$title = isset( $request['title'] ) ? trim( $request['title'] ) : null;

			// タイトルは必須
			if ( ! $title ) wp_die( esc_html__( 'タイトルがありません。', 'swell' ) );

			if ( $id ) {
				// 更新
				$result = $wpdb->update(
					$table_name,
					[
						'title' => $title,
						'data'  => $data,
					],
					[ 'id' => $id ],
					[ '%s', '%s' ],
					[ '%d' ]
				);
				if ( $result !== false ) {
					return [
						'message'  => esc_html__( 'ふきだしセットを更新しました。', 'swell' ),
					];
				}
			} else {
				// 新規登録

				// 並び順の最大値を取得
				$max_order = \SWELL_Theme::get_balloon_max_order( $table_name );

				$result = $wpdb->insert(
					$table_name,
					[
						'title'    => $title,
						'data'     => $data,
						'order_no' => $max_order + 1,
					],
					[
						'%s',
						'%s',
						'%d',
					]
				);
				if ( $result ) {
					return [
						'insertId' => $wpdb->insert_id,
						'message'  => esc_html__( 'ふきだしセットを登録しました。', 'swell' ),
					];
				}
			}

			wp_die( esc_html__( 'データの更新に失敗しました。', 'swell' ) );
		},
	],
	// データの削除
	[
		'methods'             => 'DELETE',
		'permission_callback' => function( $request ) {
			return current_user_can( 'edit_speech_balloons' );
		},
		'callback'            => function( $request ) {
			global $wpdb;
			$table_name = $wpdb->prefix . \SWELL_Theme::DB_TABLES['balloon'];
			if ( ! \SWELL_Theme::check_table_exists( $table_name ) ) wp_die( esc_html__( 'テーブルがありません。', 'swell' ) );

			// IDが渡ってきていない場合は終了
			$id = isset( $request['id'] ) ? $request['id'] : null;
			if ( ! $id ) wp_die( esc_html__( 'IDがありません。', 'swell' ) );

			$result = $wpdb->delete(
				$table_name,
				[ 'id' => $id ],
				[ '%d' ]
			);

			if ( $result ) {
				return [ 'status' => 'ok' ];
			}

			wp_die( esc_html__( '削除に失敗しました。', 'swell' ) );
		},
	],
	// データの移行
	[
		'methods'             => 'PATCH',
		'permission_callback' => function( $request ) {
			return current_user_can( 'edit_speech_balloons' );
		},
		'callback'            => function( $request ) {

			global $wpdb;
			$table_name = $wpdb->prefix . \SWELL_Theme::DB_TABLES['balloon'];

			// テーブル作成
			if ( ! \SWELL_Theme::check_table_exists( $table_name ) ) {
				\SWELL_Theme::create_balloon_table();
			}

			// 旧データ全部取得
			$the_query = new \WP_Query( [
				'post_type'      => 'speech_balloon',
				// 全てのステータスの記事を取得
				'post_status'    => [ 'publish', 'future', 'draft', 'pending', 'private', 'trash', 'auto-draft' ],
				'posts_per_page' => -1,
				// 一覧ページでの並び順を保持する
				'orderby'        => 'menu_order',
			] );

			$i = $the_query->found_posts;

			while ( $the_query->have_posts() ) {
				$the_query->the_post();

				// ステータスが「ゴミ箱」「自動保存（リビジョン）」以外の場合のみ移行する
				if ( ! in_array( get_post_status(), [ 'trash', 'auto-draft' ], true ) ) {
					// データ移行処理
					$bln_id = get_the_ID();
					$title  = the_title_attribute( 'echo=0' );

					if ( ! $title ) {
						$title = sprintf( __( 'ふきだし_%s', 'swell' ), $bln_id );
					}

					$bln_data = [
						'icon'   => get_post_meta( $bln_id, 'balloon_icon', true ),
						'name'   => get_post_meta( $bln_id, 'balloon_icon_name', true ),
						'col'    => get_post_meta( $bln_id, 'balloon_col', true ) ?: 'gray',
						'type'   => get_post_meta( $bln_id, 'balloon_type', true ) ?: 'speaking',
						'align'  => get_post_meta( $bln_id, 'balloon_align', true ) ?: 'left',
						'border' => get_post_meta( $bln_id, 'balloon_border', true ) ?: 'none',
						'shape'  => get_post_meta( $bln_id, 'balloon_icon_shape', true ) ?: 'circle',
					];

					$wpdb->insert(
						$table_name,
						[
							'id'       => $bln_id,
							'title'    => $title,
							'data'     => json_encode( $bln_data ),
							'order_no' => $i,
						],
						[
							'%d',
							'%s',
							'%s',
							'%d',
						]
					);

					// 旧データの削除
					wp_delete_post( $bln_id, true );

					delete_post_meta( $bln_id, 'balloon_icon' );
					delete_post_meta( $bln_id, 'balloon_icon_name' );
					delete_post_meta( $bln_id, 'balloon_col' );
					delete_post_meta( $bln_id, 'balloon_type' );
					delete_post_meta( $bln_id, 'balloon_align' );
					delete_post_meta( $bln_id, 'balloon_border' );
					delete_post_meta( $bln_id, 'balloon_icon_shape' );
				}

				$i--;
			}

			return [ 'status' => 'ok' ];
		},
	],
]);

// ふきだし設定ページ（複製）
register_rest_route('wp/v2', '/swell-balloon-copy', [
	'methods'             => 'POST',
	'permission_callback' => function( $request ) {
		return current_user_can( 'edit_speech_balloons' );
	},
	'callback'            => function( $request ) {
		global $wpdb;
		$table_name = $wpdb->prefix . \SWELL_Theme::DB_TABLES['balloon'];
		if ( ! \SWELL_Theme::check_table_exists( $table_name ) ) wp_die( esc_html__( 'テーブルがありません。', 'swell' ) );

		// IDが渡ってきていない場合は終了
		$id = isset( $request['id'] ) ? $request['id'] : null;
		if ( ! $id ) wp_die( esc_html__( 'IDがありません。', 'swell' ) );

		// 複製元の吹き出しを取得
		$results = \SWELL_Theme::get_balloon_data__new( 'id', $id, true );
		if ( ! $results ) wp_die( esc_html__( '複製元のデータ取得に失敗しました。', 'swell' ) );

		// 並び順の最大値を取得
		$sql   = "SELECT MAX(order_no) AS order_no FROM {$table_name}";
		$order = $wpdb->get_row( $sql, ARRAY_A );

		// 並び順を決定
		$order_no = $order ? $order['order_no'] + 1 : 1;

		// 複製したふきだしの登録
		$wpdb->insert(
			$table_name,
			[
				'title'    => sprintf( __( '%s_copy', 'swell' ), $results['title'] ),
				'data'     => $results['data'],
				'order_no' => $order_no,
			],
			[
				'%s',
				'%s',
				'%d',
			]
		);

		// 複製したふきだしデータの取得
		$new_balloon = \SWELL_Theme::get_balloon_data__new( 'id', $wpdb->insert_id, true );
		return [
			'id'    => $new_balloon['id'],
			'title' => $new_balloon['title'],
			'data'  => json_decode( $new_balloon['data'], true ),
			'order' => $new_balloon['order_no'],
		];
	},
]);

// ふきだし設定ページ（並び替え）
register_rest_route('wp/v2', '/swell-balloon-sort', [
	'methods'             => 'POST',
	'permission_callback' => function( $request ) {
		return current_user_can( 'edit_speech_balloons' );
	},
	'callback'            => function( $request ) {
		$balloon1 = isset( $request['balloon1'] ) ? $request['balloon1'] : null;
		$balloon2 = isset( $request['balloon2'] ) ? $request['balloon2'] : null;

		// 不正なパラメータの場合は修了
		if ( ! $balloon1 || ! $balloon2 ) wp_die( esc_html__( '入れ替え対象が正常に取得できませんでした。', 'swell' ) );

		// テーブルが存在しない場合は終了
		global $wpdb;
		$table_name = $wpdb->prefix . \SWELL_Theme::DB_TABLES['balloon'];
		if ( ! \SWELL_Theme::check_table_exists( $table_name ) ) wp_die( esc_html__( 'テーブルがありません。', 'swell' ) );

		// 二つのレコードの並び順を入れ替え
		$result1 = $wpdb->update(
			$table_name,
			[ 'order_no' => $balloon2['order'] ],
			['id' => $balloon1['id'] ],
			[ '%d' ]
		);

		$result2 = $wpdb->update(
			$table_name,
			[ 'order_no' => $balloon1['order'] ],
			[ 'id' => $balloon2['id'] ],
			[ '%d' ]
		);

		// アップデート失敗の場合は終了
		if ( $result1 === false || $result2 === false ) wp_die( esc_html__( '順序の更新に失敗しました。', 'swell' ) );

		$sql  = "SELECT * FROM {$table_name} ORDER BY order_no DESC";
		$rows = $wpdb->get_results( $sql, ARRAY_A );

		if ( empty( $rows ) ) return [];

		$results = [];
		foreach ( $rows as $row ) {
			$results[] = [
				'id'    => $row['id'],
				'title' => $row['title'],
				'data'  => json_decode( $row['data'], true ),
				'order' => $row['order_no'],
			];
		}

		return $results;
	},
]);

// ふきだしブロック IDからふきだし作成
register_rest_route('wp/v2', '/swell-balloon-recover', [
	'methods'             => 'POST',
	'permission_callback' => function( $request ) {
		return current_user_can( 'edit_speech_balloons' );
	},
	'callback'            => function( $request ) {

		// IDが渡ってきていない場合は終了
		$id = isset( $request['id'] ) ? $request['id'] : null;
		if ( ! $id ) wp_die( [] );

		global $wpdb;
		$table_name = $wpdb->prefix . \SWELL_Theme::DB_TABLES['balloon'];

		// テーブルが存在しない場合は終了
		if ( ! \SWELL_Theme::check_table_exists( $table_name ) ) wp_die( esc_html__( 'テーブルがありません。', 'swell' ) );

		// ふきだしセットが作成済かどうかをチェックする
		$results = \SWELL_Theme::get_balloon_data__new( 'id', $id, true );
		if ( $results ) wp_die( esc_html__( 'ふきだしセットは登録済です。ブラウザをリロードしてください。', 'swell' ) );

		// 並び順の最大値を取得
		$max_order = \SWELL_Theme::get_balloon_max_order( $table_name );

		// デフォルト設定でふきだしデータを登録
		$result = $wpdb->insert(
			$table_name,
			[
				'id'       => $id,
				'title'    => sprintf( __( 'ふきだし_%s', 'swell' ), $id ),
				'data'     => json_encode( [
					'shape'  => 'square',
					'type'   => 'speaking',
					'align'  => 'left',
					'border' => 'none',
					'col'    => 'gray',
				] ),
				'order_no' => $max_order + 1,
			],
			[ '%d', '%s', '%s', '%d' ]
		);

		if ( $result ) {
			return [ 'status' => 'ok' ];
		} else {
			wp_die( esc_html__( '挿入に失敗しました。', 'swell' ) );
		}
	},
]);
