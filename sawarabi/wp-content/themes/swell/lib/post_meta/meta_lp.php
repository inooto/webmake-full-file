<?php
namespace SWELL_Theme\Meta\LP;

use \SWELL_Theme as SWELL;
use \SWELL_THEME\Parts\Setting_Field as Field;

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'add_meta_boxes', __NAMESPACE__ . '\hook_add_meta_box', 1 );
add_action( 'save_post', __NAMESPACE__ . '\hook_save_post' );


/**
 * メタボックスの追加
 */
function hook_add_meta_box() {
	add_meta_box(
		'swell_post_meta__lp',
		__( 'LP設定', 'swell' ),
		__NAMESPACE__ . '\lp_meta_cb',
		['lp' ],
		'side',
		'default',
		null
	);
}


/**
 * 【LP設定】
 */
function lp_meta_cb( $post ) {
	$the_id = $post->ID;

	SWELL::set_nonce_field( '_meta_lp' );
?>
	<div id="swell_metabox_lp" class="swl-meta -lp -side">

		<div class="swl-meta__item">
			<?php
				$field_args = [
					'id'          => 'lp_content_width',
					'title'       => __( 'コンテンツの最大幅', 'swell' ),
					'meta'        => get_post_meta( $the_id, 'lp_content_width', true ) ?: '900px',
				];
				Field::meta_text_input( $field_args );
			?>
		</div>
		<div class="swl-meta__item">
			<div class="swl-meta__subttl"><?=esc_html__( 'コンテンツの囲み枠', 'swell' )?></div>
			<?php
				$meta_val = get_post_meta( $the_id, 'lp_body_style', true ) ?: 'no';
				$choices  = [
					'no'     => __( 'なし', 'swell' ),
					'border' => __( '線で囲む', 'swell' ),
					'shadow' => __( '影をつける', 'swell' ),
				];
				Field::meta_radiobox( 'lp_body_style', $choices, $meta_val );
			?>
		</div>
		<div class="swl-meta__item">
			<label class="swl-meta__subttl"><?=esc_html__( 'アイキャッチ画像の表示設定', 'swell' )?></label>
			<?php
				$meta_val = get_post_meta( $the_id, 'lp_thumb_pos', true ) ?: 'no';
				$choices  = [
					'no'    => _x( '非表示', 'show', 'swell' ),
					'top'   => __( 'フルワイドで表示', 'swell' ),
					'inner' => __( 'コンテンツに収めて表示', 'swell' ),
				];
				Field::meta_radiobox( 'lp_thumb_pos', $choices, $meta_val );
			?>
		</div>
		<div class="swl-meta__item">
			<label class="swl-meta__subttl"><?=esc_html__( 'タイトルの表示設定', 'swell' )?></label>
			<?php
				$meta_val = get_post_meta( $the_id, 'lp_title_pos', true ) ?: 'no';
				$choices  = [
					'no'    => _x( '非表示', 'show', 'swell' ),
					'inner' => _x( '表示', 'show', 'swell' ),
				];
				Field::meta_radiobox( 'lp_title_pos', $choices, $meta_val );
			?>
		</div>
		<div class="swl-meta__item">
			<label class="swl-meta__subttl"><?=esc_html__( 'SWELLのスタイルを適用するか', 'swell' )?></label>
			<?php
				$meta_val = get_post_meta( $the_id, 'lp_use_swell_style', true ) ?: 'on';
				$choices  = [
					'on'  => __( '適用する', 'swell' ),
					'off' => __( '適用しない', 'swell' ),
				];
				Field::meta_radiobox( 'lp_use_swell_style', $choices, $meta_val );
			?>
			<p class="description">
				<?=esc_html__( '通常の投稿ページのように、記事のコンテンツにSWELLのスタイルを適用するかどうか。', 'swell' )?>
			</p>
		</div>

		<div class="swl-meta__item">
			<label class="swl-meta__subttl"><?=esc_html__( 'ヘッダー・フッター設定', 'swell' )?></label>
			<?php
				$meta_checkboxes = [
					'lp_use_swell_header' => __( 'SWELLのヘッダーを使用する', 'swell' ),
					'lp_use_swell_footer' => __( 'SWELLのフッターを使用する', 'swell' ),
				];
				foreach ( $meta_checkboxes as $key => $label ) :
					$meta_val = get_post_meta( $the_id, $key, true );
				?>
					<div class="swl-meta__field">
						<?php Field::meta_checkbox( $key, $label, $meta_val ); ?>
					</div>
				<?php
				endforeach;
			?>
		</div>
	</div>
	<?php
}


/**
 * 保存処理
 */
function hook_save_post( $post_id ) {

	// nonce チェック
	if ( ! SWELL::check_nonce( '_meta_lp' ) ) {
		return;
	}

	SWELL::save_post_metas( $post_id, [
		'lp_content_width'    => 'str',
		'lp_body_style'       => 'str',
		'lp_thumb_pos'        => 'str',
		'lp_title_pos'        => 'str',
		'lp_use_swell_style'  => 'str',
		'lp_use_swell_header' => 'check',
		'lp_use_swell_footer' => 'check',
	]);

}
