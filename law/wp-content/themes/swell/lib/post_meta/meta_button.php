<?php
namespace SWELL_Theme\Meta\Button;

use \SWELL_Theme as SWELL;

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'save_post', __NAMESPACE__ . '\hook_save_post', 10, 2 );


/**
 * 計測IDを持つSWELLボタンのみ検索して、IDの配列を返す
 */
function get_btn_ids( $parsed_content ) {
	$btns = [];
	foreach ( $parsed_content as $block ) {
		$block_name = $block['blockName'];

		if ( $block_name === 'loos/button' ) {
			preg_match( '/\sdata-id="([^"]*)"/', $block['innerHTML'], $id_matches );
			if ( $id_matches ) {
				$btns[] = $id_matches[1];
			}
		} elseif ( ! empty( $block['innerBlocks'] ) ) {
			// インナーブロックにも同じ処理を。
			$inner_btns = get_btn_ids( $block['innerBlocks'] );
			$btns       = array_merge( $btns, $inner_btns );
		}
	}

	return $btns;
}

/**
 * 保存処理
 */
function hook_save_post( $post_id, $post ) {
	// リビジョンの投稿IDが渡ってきたときは何もしない
	if ( wp_is_post_revision( $post_id ) ) return;

	// 自動保存時には保存しないように
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// 権限確認
	// if ( ! SWELL::check_user_can_edit( $post_id ) ) return;

	// 保存済のボタンクリックデータを取得
	$btn_cv_metas = get_post_meta( $post_id, 'swell_btn_cv_data', true ) ?: [];

	if ( $btn_cv_metas ) $btn_cv_metas = json_decode( $btn_cv_metas, true );
	if ( ! is_array( $btn_cv_metas ) ) wp_die( json_encode( [] ) );

	// 新しいボタンID一覧
	$new_btn_ids = [];

	// コンテンツをパースしてSWELLボタンを抽出
	$parsed_content = parse_blocks( $post->post_content );
	$new_btn_ids    = get_btn_ids( $parsed_content );

	// 計測対象のボタンが一つもなければ
	if ( empty( $new_btn_ids ) ) {
		delete_post_meta( $post_id, 'swell_btn_cv_data' );
		return;
	}

	// コンテンツ内のボタンIDがメタフィールドのキーに無ければ削除
	$new_btn_cv_metas = $btn_cv_metas;
	foreach ( $btn_cv_metas as $key => $value ) {
		if ( ! in_array( $key, $new_btn_ids, true ) ) {
			unset( $new_btn_cv_metas[ $key ] );
		}
	}

	// DBアップデート
	if ( empty( $new_btn_cv_metas ) ) {
		delete_post_meta( $post_id, 'swell_btn_cv_data' );
	} else {
		$new_btn_cv_metas = json_encode( $new_btn_cv_metas );
		update_post_meta( $post_id, 'swell_btn_cv_data', $new_btn_cv_metas );
	}
}
