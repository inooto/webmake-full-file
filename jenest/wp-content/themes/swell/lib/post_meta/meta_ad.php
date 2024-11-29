<?php
namespace SWELL_Theme\Meta\Ad;

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
		'swell_post_meta__ad_tag',
		__( '広告設定', 'swell' ),
		__NAMESPACE__ . '\ad_meta_cb',
		[ 'ad_tag' ],
		'normal',
		'default',
		null
	);
}


/**
 * 広告
 */
function ad_meta_cb( $post ) {
	$the_id = $post->ID;

	// メタ情報
	$ad_type     = get_post_meta( $the_id, 'ad_type', true ) ?: 'normal';
	$meta_border = get_post_meta( $the_id, 'ad_border', true ) ?: 'off';
	$meta_rank   = get_post_meta( $the_id, 'ad_rank', true ) ?: 'rank0';
	$meta_name   = get_post_meta( $the_id, 'ad_name', true );
	$meta_price  = get_post_meta( $the_id, 'ad_price', true );
	$meta_price  = get_post_meta( $the_id, 'ad_price', true );
	$meta_desc   = get_post_meta( $the_id, 'ad_desc', true );
	$meta_star   = get_post_meta( $the_id, 'ad_star', true );

	$meta_btn1_text = get_post_meta( $the_id, 'ad_btn1_text', true ) ?: __( '詳しくみる', 'swell' );
	$meta_btn2_text = get_post_meta( $the_id, 'ad_btn2_text', true ) ?: __( '購入する', 'swell' );
	$meta_btn1_url  = get_post_meta( $the_id, 'ad_btn1_url', true );
	$meta_btn2_url  = get_post_meta( $the_id, 'ad_btn2_url', true );

	$btn1_hidden = $meta_btn1_url ? '' : ' u-none';
	$btn2_hidden = $meta_btn2_url ? '' : ' u-none';

	$ad_title = $meta_name ?: get_the_title( $the_id );
	// if ( empty( $meta_border ) ) $meta_border = 'off';

	SWELL::set_nonce_field( '_meta_ad' );
	?>
	<div class="swl-meta">
		<div class="swl-meta--ad" data-adtype="<?=$ad_type ?: 'normal' ?>">
			<div class="swl-meta--ad__preview">
				<div class="p-adBox -border-<?=esc_attr( $meta_border )?>" data-ad="<?=esc_attr( $ad_type ) ?: 'normal' ?>"">
					<div class="p-adBox__title -<?=esc_attr( $meta_rank )?>"><?=esc_html( $ad_title )?></div>
					<div class="p-adBox__body">
						<div class="p-adBox__img">
							<span class="p-adBox__dammyImage"><?=esc_html__( '広告', 'swell' )?></span>
						</div>
						<div class="p-adBox__details">
							<div class="p-adBox__name"><?=esc_html( $ad_title )?></div>
							<div class="p-adBox__star c-reviewStars"><?=wp_kses_post( \SWELL_PARTS::review_stars( $meta_star ) )?></div>
							<div class="p-adBox__price u-thin u-fz-s"><?=esc_html( $meta_price )?></div>
							<div class="p-adBox__desc"><?=wp_kses_post( $meta_desc )?></div>
							<div class="p-adBox__btns">
								<a href="###" class="p-adBox__btn -btn1<?=esc_attr( $btn1_hidden )?>"><?=esc_html( $meta_btn1_text )?></a>
								<a href="###" class="p-adBox__btn -btn2<?=esc_attr( $btn2_hidden )?>"><?=esc_html( $meta_btn2_text )?></a>
							</div>
						</div>
					</div>
					<div class="p-adBox__btns">
						<a href="###" class="p-adBox__btn -btn1<?=esc_attr( $btn1_hidden )?>"><?=esc_html( $meta_btn1_text )?></a>
						<a href="###" class="p-adBox__btn -btn2<?=esc_attr( $btn2_hidden )?>"><?=esc_html( $meta_btn2_text )?></a>
					</div>
				</div>
			</div>
			<div class="swl-meta--ad__inner -left">
				<div class="swl-meta__item">
					<div class="swl-meta__subttl"><?=esc_html__( '広告タイプ', 'swell' )?><small><?=esc_html__( '（レイアウトが変化します）', 'swell' )?></small></div>
					<?php
						$choices = [
							'text'      => __( 'テキスト型', 'swell' ),
							'normal'    => __( 'バナー型', 'swell' ),
							'affiliate' => __( 'アフィリエイト型', 'swell' ),
							'amazon'    => __( 'Amazon型', 'swell' ),
							'ranking'   => __( 'ランキング型', 'swell' ),
						];
						Field::meta_radiobox( 'ad_type', $choices, $ad_type, false );
					?>
					<p class="swl-meta--ad__description">
						<small><?=wp_kses_post( __( '※「テキスト型」は広告タグブロックで呼び出すことはできませんが、<br>　ショートコードで文中に呼び出すことができます。', 'swell' ) )?></small>
					</p>
				</div>

				<div class="swl-meta__item -border">
					<div class="swl-meta__subttl"><?=esc_html__( '広告ボックスの枠', 'swell' )?></div>
						<?php
						$choices = [
							'off' => __( 'なし', 'swell' ),
							'on'  => __( 'あり', 'swell' ),
						];
						Field::meta_radiobox( 'ad_border', $choices, $meta_border, false );
					?>
				</div>

				<div class="swl-meta__subttl"><?=esc_html__( '広告タグ', 'swell' )?></div>
				<?php $meta_val = get_post_meta( $the_id, 'ad_img', true ); ?>
				<textarea name="ad_img" id="ad_img" cols="60" rows="10"><?=esc_textarea( $meta_val )?></textarea>

			</div>
			<div class="swl-meta--ad__inner -right">
				<div class="swl-meta__item swl-meta--ad__ranking">
					<div class="swl-meta__subttl"><?=esc_html__( '順位', 'swell' )?></div>
					<?php
						$choices = [
							'rank1' => __( '１位', 'swell' ),
							'rank2' => __( '２位', 'swell' ),
							'rank3' => __( '３位', 'swell' ),
							'rank0' => __( '順位なし', 'swell' ),
						];
						Field::meta_radiobox( 'ad_rank', $choices, $meta_rank, false );
					?>
				</div>
				<div class="swl-meta__item">
					<div class="swl-meta__subttl"><?=esc_html__( '評価', 'swell' )?></div>
					<?php
						$stars = [
							'0.5' => __( '星', 'swell' ) . ' : 0.5',
							'1'   => __( '星', 'swell' ) . ' : 1',
							'1.5' => __( '星', 'swell' ) . ' : 1.5',
							'2'   => __( '星', 'swell' ) . ' : 2',
							'2.5' => __( '星', 'swell' ) . ' : 2.5',
							'3'   => __( '星', 'swell' ) . ' : 3',
							'3.5' => __( '星', 'swell' ) . ' : 3.5',
							'4'   => __( '星', 'swell' ) . ' : 4',
							'4.5' => __( '星', 'swell' ) . ' : 4.5',
							'5'   => __( '星', 'swell' ) . ' : 5',
						];
						Field::meta_select( 'ad_star', $stars, $meta_star, __( '評価を選択', 'swell' ) );
					?>
				</div>
				<div class="swl-meta__item">
					<div class="swl-meta__subttl"><?=esc_html__( '表示名', 'swell' )?><small> <?=esc_html__( '（空の場合はタイトルが出力されます）', 'swell' )?></small></div>
					<input type="text" id="ad_name" name="ad_name" size="40" value="<?=esc_attr( $meta_name )?>">
				</div>
				<div class="swl-meta__item">
					<div class="swl-meta__subttl"><?=esc_html__( '価格', 'swell' )?></div>
					<input type="text" id="ad_price" name="ad_price" size="40" value="<?=esc_attr( $meta_price )?>">
				</div>

				<div class="swl-meta__item meta_ad_desc">
					<div class="swl-meta__subttl"><?=esc_html__( '説明文', 'swell' )?></div>
					<textarea name="ad_desc" id="ad_desc" cols="60" rows="5"><?=wp_kses_post( $meta_desc )?></textarea>
				</div>
				<div class="swl-meta__item">
					<div class="swl-meta__subttl"><?=esc_html__( 'ボタン1リンク先', 'swell' )?></div>
					<input type="text" id="ad_btn1_url" name="ad_btn1_url" size="40" value="<?=esc_attr( $meta_btn1_url )?>">
				</div>
				<div class="swl-meta__item">
					<div class="swl-meta__subttl"><?=esc_html__( 'ボタン1テキスト', 'swell' )?></div>
					<input type="text" id="ad_btn1_text" name="ad_btn1_text" size="40" value="<?=esc_attr( $meta_btn1_text )?>">
				</div>
				<div class="swl-meta__item">
					<div class="swl-meta__subttl"><?=esc_html__( 'ボタン2リンク先', 'swell' )?></div>
					<input type="text" id="ad_btn2_url" name="ad_btn2_url" size="40" value="<?=esc_attr( $meta_btn2_url )?>">
				</div>
				<div class="swl-meta__item">
					<div class="swl-meta__subttl"><?=esc_html__( 'ボタン2テキスト', 'swell' )?></div>
					<input type="text" id="ad_btn2_text" name="ad_btn2_text" size="40" value="<?=esc_attr( $meta_btn2_text )?>">
				</div>
			</div>
		</div>
	</div>
<?php
}

/**
 * 保存処理
 */
function hook_save_post( $the_id ) {

	// nonce チェック
	if ( ! SWELL::check_nonce( '_meta_ad' ) ) {
		return;
	}

	SWELL::save_post_metas( $the_id, [
		'ad_type'             => 'str',
		'ad_rank'             => 'str',
		'ad_img'              => 'code',
		'ad_border'           => 'str',
		'ad_name'             => 'html',
		'ad_star'             => 'str',
		'ad_desc'             => 'html',
		'ad_price'            => 'str',
		'ad_btn1_url'         => 'url',
		'ad_btn1_text'        => 'str',
		'ad_btn2_url'         => 'url',
		'ad_btn2_text'        => 'str',
	]);

	// $METAKEYS = [
	// 	'ad_type',
	// 	'ad_rank',
	// 	'ad_img',
	// 	'ad_border',
	// 	'ad_name',
	// 	'ad_star',
	// 	'ad_desc',
	// 	'ad_price',
	// 	'ad_btn1_url',
	// 	'ad_btn1_text',
	// 	'ad_btn2_url',
	// 	'ad_btn2_text',
	// ];

	// <a href="###" referrerpolicy="no-referrer-when-downgrade">aaa</a>

	// foreach ( $METAKEYS as $key ) {
	// 	// 保存したい情報が渡ってきていれば更新作業に入る
	// 	if ( isset( $_POST[ $key ] ) ) {

	// 		$meta_val = $_POST[ $key ];
	// 		// scriptも通すので、ad はサニタイズなし

	// 		// DBアップデート
	// 		update_post_meta( $the_id, $key, $meta_val );
	// 	}
	// }
}
