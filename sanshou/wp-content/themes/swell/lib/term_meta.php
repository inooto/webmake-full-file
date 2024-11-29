<?php
namespace SWELL_Theme\Term_Meta;

use \SWELL_Theme as SWELL;
use \SWELL_THEME\Parts\Setting_Field as Field;

if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * ターム「新規追加」画面にフィールド追加
 */
add_action( 'category_add_form_fields', __NAMESPACE__ . '\add_term_fields' );
add_action( 'post_tag_add_form_fields', __NAMESPACE__ . '\add_term_fields' );
function add_term_fields() {
	SWELL::set_nonce_field( '_meta_term' );
?>
	<div class="form-field">
		<label><?=esc_html__( 'アイキャッチ画像', 'swell' )?></label>
		<?php Field::media_btns( 'swell_term_meta_image', '', 'id' ); ?>
	</div>
<?php
}



/*
 * ターム「編集」画面にフィールド追加
 */
add_action( 'init', function() {
	$custom_taxonomies = get_taxonomies( [
		'public'   => true,
		'_builtin' => false,
	]) ?: [];

	$term_meta_screens = array_merge( [ 'category', 'post_tag' ], array_keys( $custom_taxonomies ) );
	$term_meta_screens = apply_filters( 'swell_term_meta_screens', $term_meta_screens );
	foreach ( $term_meta_screens as $tax_slug ) {
		add_action( "{$tax_slug}_edit_form_fields", __NAMESPACE__ . '\add_term_edit_fields' );
	}

}, 99 );
function add_term_edit_fields( $term ) {

	$the_term_id = $term->term_id;
	$the_tax     = $term->taxonomy;

	$term_ttl      = get_term_meta( $the_term_id, 'swell_term_meta_ttl', 1 );
	$term_subttl   = get_term_meta( $the_term_id, 'swell_term_meta_subttl', 1 );
	$term_image    = get_term_meta( $the_term_id, 'swell_term_meta_image', 1 );
	$term_ttlbg    = get_term_meta( $the_term_id, 'swell_term_meta_ttlbg', 1 );
	$is_show_pr    = get_term_meta( $the_term_id, 'swell_term_meta_show_pr_notation', 1 );
	$is_show_thumb = get_term_meta( $the_term_id, 'swell_term_meta_show_thumb', 1 );
	$is_show_desc  = get_term_meta( $the_term_id, 'swell_term_meta_show_desc', 1 );
	$is_show_list  = get_term_meta( $the_term_id, 'swell_term_meta_show_list', 1 );
	$parts_id      = get_term_meta( $the_term_id, 'swell_term_meta_display_parts', 1 );
	$cta_id        = get_term_meta( $the_term_id, 'swell_term_meta_cta_parts', 1 );

	SWELL::set_nonce_field( '_meta_term' );
?>
	<tr class="swell_term_meta_title">
		<th colspan="2">
			<h2><i class="icon-swell"></i> <?=esc_html__( 'SWELL設定', 'swell' )?></h2>
		</th>
	</tr>
	<tr class="form-field">
		<th><?=esc_html__( 'ページに表示するタイトル', 'swell' )?></th>
		<td>
			<input type="text" name="swell_term_meta_ttl" id="swell_term_meta_ttl" size="40" value="<?=esc_attr( $term_ttl )?>">
			<p class="description">
				<?=esc_html__( '空白の場合、ターム名がそのまま出力されます。', 'swell' )?>
			</p>
		</td>
	</tr>
	<tr class="form-field">
		<th><?=esc_html__( 'ページに表示するサブタイトル', 'swell' )?></th>
		<td>
			<input type="text" name="swell_term_meta_subttl" id="swell_term_meta_subttl" size="40" value="<?=esc_attr( $term_subttl )?>">
			<p class="description">
				<?=esc_html__( '空白の場合、「category」または「tag」が出力されます。', 'swell' )?>
			</p>
		</td>
	</tr>
	<tr class="form-field">
		<th><?=esc_html__( 'リストレイアウト', 'swell' )?></th>
		<td>
			<?php
				$default  = '-- ' . esc_html__( 'ベース設定に従う', 'swell' ) . ' --';
				$meta_val = get_term_meta( $the_term_id, 'swell_term_meta_list_type', 1 );
				// $options  = [
				// 	'card' => esc_html__( 'カード型', 'swell' ),
				// 	'list' => esc_html__( 'リスト型', 'swell' ),
				// ];
				Field::meta_select( 'swell_term_meta_list_type', \SWELL_Theme::$list_layouts, $meta_val, $default );
			?>
		</td>
	</tr>
	<tr class="form-field">
		<th><?=esc_html__( '新着順 / 人気順 でタブを分けるかどうか', 'swell' )?></th>
		<td>
			<?php
				$default  = '-- ' . esc_html__( 'ベース設定に従う', 'swell' ) . ' --';
				$meta_val = get_term_meta( $the_term_id, 'swell_term_meta_show_rank', 1 );
				$options  = [
					'1'    => _x( 'する', 'do', 'swell' ), // '1' なのは過去の設定（チェックボックスだった頃）を引き継ぐため
					'none' => _x( 'しない', 'do', 'swell' ),
				];
				Field::meta_select( 'swell_term_meta_show_rank', $options, $meta_val, $default );
			?>
		</td>
	</tr>
	<tr class="form-field">
		<th><?=esc_html__( 'タイトル位置', 'swell' )?></th>
		<td>
			<?php
				$default  = '-- ' . esc_html__( 'ベース設定に従う', 'swell' ) . ' --';
				$meta_val = get_term_meta( $the_term_id, 'swell_term_meta_ttlpos', 1 );
				$options  = [
					'top'   => esc_html__( 'コンテンツ上', 'swell' ),
					'inner' => esc_html__( 'コンテンツ内', 'swell' ),
				];
				Field::meta_select( 'swell_term_meta_ttlpos', $options, $meta_val, $default );
			?>
		</td>
	</tr>
	<tr class="form-field">
		<th><?=esc_html__( 'サイドバー', 'swell' )?></th>
		<td>
			<?php
				$default  = '-- ' . esc_html__( 'ベース設定に従う', 'swell' ) . ' --';
				$meta_val = get_term_meta( $the_term_id, 'swell_term_meta_show_sidebar', 1 );
				$options  = [
					'show' => _x( '表示', 'show', 'swell' ),
					'hide' => _x( '非表示', 'show', 'swell' ),
				];
				Field::meta_select( 'swell_term_meta_show_sidebar', $options, $meta_val, $default );
			?>
		</td>
	</tr>
	<?php if ( 'category' === $the_tax ) : ?>
		<tr class="form-field">
			<th>
				<?=esc_html__( 'タームナビゲーション', 'swell' )?>
			</th>
			<td>
				<?php
					$default  = '-- ' . __( 'ベース設定に従う', 'swell' ) . ' --';
					$meta_val = get_term_meta( $the_term_id, 'swell_term_meta_show_nav', 1 );
					$options  = [
						'show' => _x( '表示', 'show', 'swell' ),
						'hide' => _x( '非表示', 'show', 'swell' ),
					];
					Field::meta_select( 'swell_term_meta_show_nav', $options, $meta_val, $default );
				?>
			</td>
		</tr>
	<?php endif; ?>
	<tr class="form-field">
		<th><label for="swell_term_meta_ttlbg"><?=esc_html__( 'タイトルの背景画像', 'swell' )?></label></th>
		<td>
			<?php Field::media_btns( 'swell_term_meta_ttlbg', $term_ttlbg, 'id' ); ?>
		</td>
	</tr>
	<tr class="form-field">
		<th><label for="swell_term_meta_image"><?=esc_html__( 'アイキャッチ画像', 'swell' )?></label></th>
		<td>
			<?php Field::media_btns( 'swell_term_meta_image', $term_image, 'id' ); ?>
		</td>
	</tr>
	<tr class="form-field">
		<th><?=esc_html__( '「PR表記」をページに表示するかどうか', 'swell' )?></th>
		<td>
			<?php
				$checked = ( $is_show_pr === '1' ) ? ' checked' : ''; // 標準：オフ
				Field::switch_checkbox( 'swell_term_meta_show_pr_notation', $is_show_pr, $checked );
			?>
		</td>
	</tr>
	<tr class="form-field">
		<th><?=esc_html__( '「アイキャッチ画像」をページに表示するかどうか', 'swell' )?></th>
		<td>
			<?php
				$checked = ( $is_show_thumb === '1' ) ? ' checked' : ''; // 標準：オフ
				Field::switch_checkbox( 'swell_term_meta_show_thumb', $is_show_thumb, $checked );
			?>
		</td>
	</tr>
	<tr class="form-field">
		<th><?=esc_html__( '「説明」の内容をページに表示するかどうか', 'swell' )?></th>
		<td>
			<?php
				$checked = ( $is_show_desc !== '0' ) ? ' checked' : ''; // 標準：オン
				Field::switch_checkbox( 'swell_term_meta_show_desc', $is_show_desc, $checked );
			?>
		</td>
	</tr>
	<tr class="form-field">
		<th><?=esc_html__( '記事一覧リストを表示するかどうか', 'swell' )?></th>
		<td>
			<?php
				$checked = ( $is_show_list !== '0' ) ? ' checked' : ''; // 標準：オン
				Field::switch_checkbox( 'swell_term_meta_show_list', $is_show_list, $checked );
			?>
		</td>
	</tr>
	<tr class="form-field">
		<th><?=esc_html__( 'ページで呼び出すブログパーツ', 'swell' )?></th>
		<td>
			<input type="text" name="swell_term_meta_display_parts" id="swell_term_meta_display_parts" size="20" value="<?=esc_attr( $parts_id )?>" style="width: 6em">
			<?php
				if ( 'category' === $the_tax ) {
				Field::parts_select( 'for_cat', 'swell_term_meta_display_parts', $parts_id );
				} elseif ( 'post_tag' === $the_tax ) {
				Field::parts_select( 'for_tag', 'swell_term_meta_display_parts', $parts_id );
				}
			?>
			<p class="description">
				<?=esc_html__( '※ ブログパーツのIDを半角で入力してください。', 'swell' )?><br>
				<?=esc_html__( '※ アーカイブページにコンテンツが表示されます。', 'swell' )?>
			</p>
			<p class="u-mt-10">
			<?php
				$is_hide_parts_paged = get_term_meta( $the_term_id, 'swell_term_meta_hide_parts_paged', 1 );
				Field::meta_checkbox( 'swell_term_meta_hide_parts_paged', __( '２ページ目以降は表示しない', 'swell' ), $is_hide_parts_paged );
			?>
			</p>
		</td>
	</tr>
	<?php if ( 'category' === $the_tax ) : ?>
	<tr class="form-field">
		<th><?=esc_html__( 'このカテゴリーのCTA', 'swell' )?></th>
		<td>
			<input type="text" name="swell_term_meta_cta_parts" id="swell_term_meta_cta_parts" size="20" value="<?=esc_attr( $cta_id )?>" style="width: 6em">
			<?php Field::parts_select( 'cta', 'swell_term_meta_cta_parts', $cta_id ); ?>
			<p class="description">
				<?=esc_html__( '※ ブログパーツのIDを半角で入力してください。', 'swell' )?><br>
				<?=esc_html__( '※ 投稿ページのCTAエリアにコンテンツが表示されます。', 'swell' )?>
			</p>
		</td>
	</tr>
	<?php endif; ?>
<?php
}

// 保存処理
add_action( 'created_term', __NAMESPACE__ . '\save_term_filds' );  // 新規追加用フック
add_action( 'edited_terms', __NAMESPACE__ . '\save_term_filds' );  // 編集ページ用フック
function save_term_filds( $term_id ) {

	// nonce チェック
	if ( ! SWELL::check_nonce( '_meta_term' ) ) {
		return;
	}

	SWELL::save_term_metas( $term_id, [
		'swell_term_meta_ttl'              => 'html',
		'swell_term_meta_subttl'           => 'html',
		'swell_term_meta_list_type'        => 'str',
		'swell_term_meta_show_rank'        => 'str',
		'swell_term_meta_ttlpos'           => 'str',
		'swell_term_meta_show_sidebar'     => 'str',
		'swell_term_meta_show_nav'         => 'str',
		'swell_term_meta_image'            => 'str',
		'swell_term_meta_ttlbg'            => 'str',
		'swell_term_meta_show_pr_notation' => 'switch',
		'swell_term_meta_show_thumb'       => 'switch',
		'swell_term_meta_show_desc'        => 'switch',
		'swell_term_meta_show_list'        => 'switch',
		'swell_term_meta_display_parts'    => 'str',
		'swell_term_meta_cta_parts'        => 'str',
		'swell_term_meta_hide_parts_paged' => 'check',
	] );
}
