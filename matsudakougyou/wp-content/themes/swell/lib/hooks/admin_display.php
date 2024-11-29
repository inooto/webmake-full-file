<?php
namespace SWELL_Theme\Hooks;

use \SWELL_THEME\Parts\Setting_Field as Field;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * 投稿一覧テーブルに アイキャッチ画像などの列を追加。
 */
add_filter( 'manage_posts_columns', __NAMESPACE__ . '\add_custom_post_columns' ); // 投稿 & カスタム投稿
add_filter( 'manage_pages_columns', __NAMESPACE__ . '\add_custom_post_columns' ); // 固定ページ
function add_custom_post_columns( $columns ) {
	global $post_type;

	// 投稿タイプごとに分岐
	if ( in_array( $post_type, ['post', 'page' ], true ) ) {

		$columns['thumbnail']   = _x( 'アイキャッチ', 'table', 'swell' );
		$columns['pr_notation'] = 'PR表記';
		$columns['post_id']     = 'ID';

	} elseif ( $post_type === 'speech_balloon' ) {

		unset( $columns['date'] );
		$columns['balloon_code']    = __( '呼び出しコード', 'swell' );
		$columns['balloon_preview'] = __( 'プレビュー', 'swell' );

	} elseif ( $post_type === 'ad_tag' ) {

		unset( $columns['date'] );
		$columns['ad_type'] = __( '広告タイプ', 'swell' );
		$columns['ad_code'] = __( '呼び出しコード', 'swell' );

		// 計測データ
		if ( \SWELL_Theme::is_administrator() ) {
			$columns['ad_ctr']        = _x( 'クリック数', 'count', 'swell' ) . ' / ' . _x( '表示回数', 'count', 'swell' );
			$columns['ad_pv']         = _x( '表示回数', 'count', 'swell' ) . ' / ' . _x( 'PV数', 'count', 'swell' );
			$columns['ad_data_reset'] = __( '計測リセット', 'swell' );
		}
	} elseif ( $post_type === 'blog_parts' ) {
		unset( $columns['date'] );
		$columns['parts_code']    = __( '呼び出しコード', 'swell' );
		$columns['parts_used_at'] = __( '使用ページ', 'swell' );
	}

	// PV数表示
	if ( \SWELL_Theme::is_administrator() && in_array( $post_type, \SWELL_Theme::$post_types_for_pvct, true ) ) {
		$columns['swell_pv_ct'] = __( 'PV', 'swell' );
	}
	return $columns;
}


/**
 * 表示内容
 */
add_action( 'manage_posts_custom_column', __NAMESPACE__ . '\output_custom_post_columns', 10, 2 );  // 投稿 & カスタム投稿
add_action( 'manage_pages_custom_column', __NAMESPACE__ . '\output_custom_post_columns', 10, 2 );  // 固定ページ
function output_custom_post_columns( $column_name, $post_id ) {
	if ( 'thumbnail' === $column_name ) {
		$thumb_id = get_post_thumbnail_id( $post_id );
		$ttlbg    = get_post_meta( $post_id, 'swell_meta_ttlbg', true );
		if ( $thumb_id ) {
			$thumb_img = wp_get_attachment_image_src( $thumb_id, 'medium' );
			echo '<img src="' . esc_url( $thumb_img[0] ) . '" width="160px">';
		} else {
			echo '—';  // em dash
		}
		echo '<br>';
		if ( $ttlbg ) {
			$ttlbg_id = attachment_url_to_postid( $ttlbg );
			$ttlbg_s  = $ttlbg_id ? wp_get_attachment_image_url( $ttlbg_id, 'medium' ) : '';
			echo '<img src="' . esc_url( $ttlbg_s ) . '" width="160px" style="margin-top:8px;">';
		} else {
			echo '—';  // em dash
		}
	} elseif ( 'pr_notation' === $column_name ) {

		$show_or_hide_options = [
			'show' => _x( '表示', 'show', 'swell' ),
			'hide' => _x( '非表示', 'show', 'swell' ),
		];

		$val = get_post_meta( $post_id, 'swell_meta_show_pr_notation', 1 );
		echo '<span data-meta-val=' . esc_attr( $val ) . '>' .
				esc_html( $show_or_hide_options[ $val ] ?? '---' ) .
			'</span>';

	} elseif ( 'post_id' === $column_name ) {

		echo esc_html( $post_id );

	} elseif ( 'swell_pv_ct' === $column_name ) {
		$pv = \SWELL_Theme::get_post_views( $post_id );
		echo esc_html( $pv );
	} elseif ( 'balloon_code' === $column_name ) {

		$balcode = _x( 'speech_balloon', 'code', 'swell' );
		// $tag = '['. $balcode . ' set="' . esc_attr( get_the_title( $post_id ) ) . '"]'. __( 'Your text...', 'swell' ) . '[/'. $balcode .']';
		$tag = '[' . $balcode . ' id="' . esc_attr( $post_id ) . '"]' . __( 'Your text...', 'swell' ) . '[/' . $balcode . ']';
		echo '<input class="swl-codeCopyBox" type="text" onClick="this.select();" value="' . esc_attr( $tag ) . '" readonly />';

	} elseif ( 'balloon_preview' === $column_name ) {

		$balloon = do_shortcode( '[ふきだし id="' . $post_id . '"]' . __( 'Your text...', 'swell' ) . '[/ふきだし]' );

		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo preg_replace( '/\ssrc="([^"]*)"\sdata-src=/', ' src=', $balloon );

	} elseif ( 'ad_type' === $column_name ) {

		$types     = [
			'text'      => __( 'テキスト型', 'swell' ),
			'normal'    => __( 'バナー型', 'swell' ),
			'affiliate' => __( 'アフィリエイト型', 'swell' ),
			'amazon'    => __( 'Amazon型', 'swell' ),
			'ranking'   => __( 'ランキング型', 'swell' ),
		];
		$type_key  = get_post_meta( $post_id, 'ad_type', true );
		$type_name = isset( $types[ $type_key ] ) ? $types[ $type_key ] : $type_key;

		echo esc_html( $type_name );

	} elseif ( 'ad_code' === $column_name ) {

		$tag = '[ad_tag id="' . $post_id . '"]';
		echo '<input class="swl-codeCopyBox" type="text" onClick="this.select();" value="' . esc_attr( $tag ) . '" readonly />';

	} elseif ( 'parts_code' === $column_name ) {

		$tag = '[blog_parts id="' . $post_id . '"]';
		echo '<input class="swl-codeCopyBox" type="text" onClick="this.select();" value="' . esc_attr( $tag ) . '" readonly />';

	} elseif ( 'parts_used_at' === $column_name ) {

		// キャッシュを取得
		$used_cache_key = 'swell_parts_used__' . $post_id;
		$used_posts     = get_transient( $used_cache_key );

		if ( false === $used_posts ) {
			// ブロックの検索
			$args       = [
				'post_type'              => [ 'post', 'page' ],
				'posts_per_page'         => -1,
				'no_found_rows'          => true,
				'update_post_term_cache' => false,
				'update_post_meta_cache' => false,
				'fields'                 => 'ids',
				's'                      => 'wp:loos/blog-parts "partsID":"' . $post_id . '"',
			];
			$the_query  = new \WP_Query( $args );
			$used_posts = $the_query->posts;
			wp_reset_postdata();

			// ショートコードの検索
			$args       = [
				'post_type'              => [ 'post', 'page' ],
				'posts_per_page'         => -1,
				'no_found_rows'          => true,
				'update_post_term_cache' => false,
				'update_post_meta_cache' => false,
				'post__not_in'           => $used_posts,
				'fields'                 => 'ids',
				's'                      => '[blog_parts id="' . $post_id . '"',
			];
			$the_query  = new \WP_Query( $args );
			$used_posts = array_merge( $used_posts, $the_query->posts );

			// var_dump( $used_posts );
			wp_reset_postdata();

			set_transient( $used_cache_key, $used_posts, 7 * DAY_IN_SECONDS );
		}

		if ( ! empty( $used_posts ) ) {
			foreach ( $used_posts  as $the_id ) {
				$edit_link = admin_url( 'post.php?post=' . $the_id . '&action=edit' );
				echo '<a href="' . esc_url( $edit_link ) . '" class="swl-usedLink">' .
					esc_html( $the_id )
				. '</a>';
			}
		}

		if ( \SWELL_Theme::is_administrator() ) {
			echo '<br><button type="button" class="swl-clearPartsUsedCacheBtn" value="' . esc_attr( $used_cache_key ) . '" >' .
				esc_html__( '手動更新', 'swell' ) .
			'</button>';
		}
	} elseif ( 'ad_ctr' === $column_name ) {

		$ad_type = get_post_meta( $post_id, 'ad_type', true );

		// imp数
		$imp_ct = (int) get_post_meta( $post_id, 'imp_count', true );

		// 広告タグ部分
		$tag_clicked_ct = (int) get_post_meta( $post_id, 'tag_clicked_ct', true );
		$tag_ctr        = ( $imp_ct !== 0 ) ? round( $tag_clicked_ct / $imp_ct * 100, 2 ) : '0';
		$rate_data      = $tag_clicked_ct . ' / ' . $imp_ct . ' = ' . $tag_ctr . '%';
		echo '<div><span class="swl-adCtrLabel -tag">' . esc_html__( 'タグ', 'swell' ) . '</span>' . esc_html( $rate_data ) . '</div>';

		// ボタンの計測結果
		if ( $ad_type !== 'normal' ) {

			// ボタン1
			if ( get_post_meta( $post_id, 'ad_btn1_url', true ) ) {
				$btn1_clicked_ct = (int) get_post_meta( $post_id, 'btn1_clicked_ct', true );
				$btn1_ctr        = ( $imp_ct !== 0 ) ? round( $btn1_clicked_ct / $imp_ct * 100, 2 ) : '0';

				$btn1_data = $btn1_clicked_ct . ' / ' . $imp_ct . ' = ' . $btn1_ctr . '%';
				echo '<div><span class="swl-adCtrLabel -btn1">' . esc_html__( 'ボタン1', 'swell' ) . '</span>' . esc_html( $btn1_data ) . '</div>';
			}

			// ボタン2
			if ( get_post_meta( $post_id, 'ad_btn2_url', true ) ) {
				$btn2_clicked_ct = (int) get_post_meta( $post_id, 'btn2_clicked_ct', true );
				$btn2_ctr        = ( $imp_ct !== 0 ) ? round( $btn2_clicked_ct / $imp_ct * 100, 2 ) : '0';
				$btn2_data       = $btn2_clicked_ct . ' / ' . $imp_ct . ' = ' . $btn2_ctr . '%';
				echo '<div><span class="swl-adCtrLabel -btn2">' . esc_html__( 'ボタン2', 'swell' ) . '</span>' . esc_html( $btn2_data ) . '</div>';
			}
		}
	} elseif ( 'ad_pv' === $column_name ) {
		// imp数
		$imp_ct = (int) get_post_meta( $post_id, 'imp_count', true );

		// pv数
		$pv_ct   = (int) get_post_meta( $post_id, 'pv_count', true );
		$rate    = ( $pv_ct !== 0 ) ? round( $imp_ct / $pv_ct * 100, 2 ) : '0';
		$pv_data = $imp_ct . ' / ' . $pv_ct . ' = ' . $rate . '%';

		echo '<div>' . esc_html( $pv_data ) . '</div>';

	} elseif ( 'ad_data_reset' === $column_name ) {

		echo '<button type="button" class="swl-adDataResetBtn" data-id="' . esc_attr( $post_id ) . '">' .
			esc_html__( 'リセット', 'swell' ) .
		'</button>';
	}
}


/**
 * カテゴリー・タグ一覧テーブルに IDのカラム 追加
 */
add_filter( 'manage_edit-category_columns', __NAMESPACE__ . '\add_term_columns' );
add_filter( 'manage_edit-post_tag_columns', __NAMESPACE__ . '\add_term_columns' );
function add_term_columns( $columns ) {
	return array_merge(
		array_slice( $columns, 0, 2 ),
		['id' => 'ID' ],
		array_slice( $columns, 2 )
	);
}


/**
 * IDカラムの出力
 */
add_filter( 'manage_category_custom_column', __NAMESPACE__ . '\output_term_custom_columns', 10, 3 );
add_filter( 'manage_post_tag_custom_column', __NAMESPACE__ . '\output_term_custom_columns', 10, 3 );
function output_term_custom_columns( $content, $column_name, $term_id ) {
	if ( 'id' === $column_name ) {
		$content = $term_id;
	}
	return $content;
}


/**
 * カテゴリー・タグ一覧：IDでソート可能に
 */
add_filter( 'manage_edit-category_sortable_columns', __NAMESPACE__ . '\add_term_sortable_columns' );
add_filter( 'manage_edit-post_tag_sortable_columns', __NAMESPACE__ . '\add_term_sortable_columns' );
function add_term_sortable_columns( $columns ) {
	$columns['id'] = 'ID';
	return $columns;
}


/**
 * PV順でソート可能に
 */
add_filter( 'manage_edit-post_sortable_columns', __NAMESPACE__ . '\add_post_sortable_columns' );
function add_post_sortable_columns( $columns ) {
	$columns['swell_pv_ct'] = 'swell_pv_ct';
	return $columns;
}


/**
 * 投稿一覧：PV順でソート可能に
 */
add_filter( 'request', __NAMESPACE__ . '\hook_request' );
function hook_request( $vars ) {
	if ( isset( $vars['orderby'] ) && 'swell_pv_ct' === $vars['orderby'] ) {
		$vars = array_merge(
			$vars,
			[
				'meta_key' => SWELL_CT_KEY,
				'orderby'  => 'meta_value_num',
			]
		);
	}
	return $vars;
}


/**
 * ブログパーツに絞り込みのセレクトボックスを追加
 */
add_filter( 'restrict_manage_posts', __NAMESPACE__ . '\add_search_parts_use' );
function add_search_parts_use( $post_type ) {
	if ( 'blog_parts' !== $post_type ) return;

	$options = '<option value="">' . esc_html__( '用途で検索', 'swell' ) . '</option>';
	$terms   = get_terms( 'parts_use' );
	foreach ( $terms as $term ) {
		$selected = ( $term->slug === get_query_var( 'parts_use' ) ) ? ' selected' : '';
		$options .= '<option value="' . esc_attr( $term->slug ) . '"' . $selected . '>' . esc_html( $term->name ) . ' </option>';
	}

	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo '<select name="parts_use">' . $options . '</select>';
}


/**
 * 広告タイプで絞り込みのセレクトボックスを追加
 */
add_filter( 'restrict_manage_posts', __NAMESPACE__ . '\add_search_ad_type' );
function add_search_ad_type( $post_type ) {
	if ( 'ad_tag' !== $post_type ) return;

	$options = '<option value="">- ' . __( '広告タイプで検索', 'swell' ) . ' -</option>';
	$types   = [
		'text'      => __( 'テキスト型', 'swell' ),
		'normal'    => __( 'バナー型', 'swell' ),
		'affiliate' => __( 'アフィリエイト型', 'swell' ),
		'amazon'    => __( 'Amazon型', 'swell' ),
		'ranking'   => __( 'ランキング型', 'swell' ),
	];
	foreach ( $types as $key => $value ) {
		$selected = ( $key === get_query_var( 'ad_type' ) ) ? ' selected' : '';
		$options .= '<option value="' . esc_attr( $key ) . '"' . $selected . '>' . esc_html( $value ) . ' </option>';
	}

	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo '<select name="ad_type">' . $options . '</select>';
}


/**
 * query_vars に ad_type を追加
 */
add_filter( 'query_vars', __NAMESPACE__ . '\add_query_vars' );
function add_query_vars( $vars ) {
	$vars[] = 'ad_type';
	return $vars;
}

/**
 * 検索条件にカスタムフィールド「ad_type」の値を追加
 */
add_filter( 'posts_where', __NAMESPACE__ . '\add_posts_where' );
function add_posts_where( $where ) {

	if ( ! is_admin() ) return $where;

	global $wpdb;
	$value = get_query_var( 'ad_type' );
	if ( ! empty( $value ) ) {
		$where .= $wpdb->prepare(
			" AND EXISTS ( SELECT * FROM {$wpdb->postmeta} as m
		WHERE m.post_id = {$wpdb->posts}.ID AND m.meta_key = 'ad_type' AND m.meta_value like %s )",
			"%{$value}%"
		);
	}

	return $where;
}


/**
 * プラグインの自動更新の表示
 */
// 自動更新系
add_filter( 'plugin_auto_update_setting_html', __NAMESPACE__ . '\customize_plugin_auto_update_html', 10, 3 );
function customize_plugin_auto_update_html( $html, $plugin_file, $plugin_data ) {
	if ( strpos( $html, 'data-wp-action=' ) === false ) {
		return $html;
	}

	$html = str_replace( '自動更新を有効化', '自動更新を有効化する', $html );
	$html = str_replace( '自動更新を無効化', '自動更新を無効化する', $html );

	ob_start();
	?>
	<div class="swl-auto-updates-wraper">
		<?php echo $html; // phpcs:ignore WordPress.Security ?>
		<div class="__now-status">
			<span class="__status __off"><?=esc_html__( '自動更新は停止中です', 'swell' )?></span>
			<span class="__status __on"><?=esc_html__( '自動更新は有効中です', 'swell' )?></span>
		</div>
	</div>
	<?php

	return ob_get_clean();

}

/**
 * テーマの自動更新の表示
 */
// add_filter( 'theme_auto_update_setting_html', __NAMESPACE__ . '\customize_theme_auto_update_html', 10, 3 );
// function customize_theme_auto_update_html( $html, $stylesheet, $theme ) {}


/**
 * クイック編集
 */
function quickedit_add_custom_field( $column_name, $post_type ) {
	if ($column_name !== 'pr_notation') return;
	$meta_key = 'swell_meta_show_pr_notation';

	$show_or_hide_options = [
		'show' => _x( '表示', 'show', 'swell' ),
		'hide' => _x( '非表示', 'show', 'swell' ),
	];
	\SWELL_Theme::set_nonce_field( '_meta_pr_quick' );
	?>
		<div class="swl-quick-edit">
			<label for="<?=esc_attr( $meta_key )?>" class="swl-meta__label">
				<span class="title">PR表記</span>
			</label>
			<?php Field::meta_select( $meta_key, $show_or_hide_options, '' ); ?>
		</div>
	<?php
}
add_action( 'quick_edit_custom_box', __NAMESPACE__ . '\quickedit_add_custom_field', 10, 2 );



/**
 * 保存処理
 */
function hook_save_post_for_quick_edit( $post_id ) {

	// nonce チェック
	if ( ! \SWELL_Theme::check_nonce( '_meta_pr_quick' ) ) {
		return;
	}

	\SWELL_Theme::save_post_metas( $post_id, [
		'swell_meta_show_pr_notation'   => 'str',
	] );
}
add_action( 'save_post', __NAMESPACE__ . '\hook_save_post_for_quick_edit' );


function quickedit_set_custom_field_value_js() {
	?>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			// var metaPR = $('#swell_meta_show_pr_notation');
			// 「クイック編集」押下時に、テーブルから値を取得してセット
			$(document).on('click', '#the-list .editinline', function() {

				var closestTr = $(this).closest('tr');
				var post_id = closestTr.attr('id');
				post_id = post_id.replace("post-", "");

				// console.log('post_id',post_id);

				// Get the value
				var metaVal = closestTr.find('td.pr_notation > span[data-meta-val]').data('meta-val');
				// console.log('metaVal', metaVal);

				// Set the value to the input
				$('.inline-edit-wrapper select#swell_meta_show_pr_notation').val(metaVal);
			});
		});
	</script>
	<?php
}
add_action( 'admin_footer-edit.php', __NAMESPACE__ . '\quickedit_set_custom_field_value_js', 99 );
