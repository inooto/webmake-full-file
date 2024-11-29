<?php
namespace SWELL_Theme\Meta\Side;

use \SWELL_Theme as SWELL;
use \SWELL_THEME\Parts\Setting_Field as Field;

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'add_meta_boxes', __NAMESPACE__ . '\hook_add_meta_box', 1 );
add_action( 'save_post', __NAMESPACE__ . '\hook_save_post' );


/**
 * add_meta_box()
 */
function hook_add_meta_box() {
	$custom_post_types = get_post_types( [
		'public'   => true,
		'_builtin' => false,
	] );
	unset( $custom_post_types['lp'] ); // LP には表示しない

	$screens = array_merge( [ 'post', 'page' ], array_keys( $custom_post_types ) );

	add_meta_box(
		'swell_post_meta__side',
		__( 'SWELL設定', 'swell' ),
		__NAMESPACE__ . '\side_meta_cb',
		$screens = apply_filters( 'swell_side_meta_screens', $screens ),
		'side',
		'default',
		null
	);
}


/**
 * 【SWELL設定】
 */
function side_meta_cb( $post ) {
	global $post_type;
	$the_id  = $post->ID;
	$is_page = 'page' === $post_type;

	SWELL::set_nonce_field( '_meta_side' );
?>
	<div id="swell_metabox_side" class="swl-meta -side">
		<?php if ( $is_page ) : ?>
			<div class="swl-meta__item">
			<?php
				$field_args = [
					'id'          => 'swell_meta_subttl',
					'title'       => __( 'サブタイトル', 'swell' ),
					'meta'        => get_post_meta( $the_id, 'swell_meta_subttl', true ),
				];
				Field::meta_text_input( $field_args );
			?>
			</div>
		<?php else : ?>

			<div class="swl-meta__item">
				<?php
					$field_args = [
						'id'          => 'swell_meta_related_posts',
						'title'       => __( '優先的に表示する関連記事', 'swell' ),
						'meta'        => get_post_meta( $the_id, 'swell_meta_related_posts', true ),
						'placeholder' => __( '投稿IDを入力', 'swell' ),
					];
					Field::meta_text_input( $field_args );
				?>
				<p class="swl-meta__desc">
					<?=esc_html__( '複数の場合は「,」区切りで指定してください。', 'swell' )?>
				</p>
			</div>

			<div class="swl-meta__item">
			<?php
				$field_args = [
					'id'          => 'swell_meta_youtube',
					'title'       => __( 'アイキャッチ用のYouTube動画', 'swell' ),
					'meta'        => get_post_meta( $the_id, 'swell_meta_youtube', true ),
					'placeholder' => __( 'YouTubeの動画IDを入力', 'swell' ),
				];
				Field::meta_text_input( $field_args );
			?>
			<p class="swl-meta__desc">
				<?=esc_html__( 'YouTubeのURLから、ID部分のみを入力してください。', 'swell' )?>
			</p>
			</div>
		<?php endif; ?>

		<div class="swl-meta__item">
			<?php
				$field_args = [
					'id'          => 'swell_meta_thumb_caption',
					'title'       => __( 'アイキャッチ画像の注釈', 'swell' ),
					'meta'        => get_post_meta( $the_id, 'swell_meta_thumb_caption', true ),
				];
				Field::meta_text_input( $field_args );
			?>
		</div>

		<div class="swl-meta__item">
			<?php $meta_val = get_post_meta( $the_id, 'swell_meta_ttlbg', true ); ?>
			<label for="swell_meta_ttlbg" class="swl-meta__subttl">
				<?=esc_html__( 'タイトルの背景画像', 'swell' )?>
			</label>
			<div class="swl-meta__field">
				<?php Field::media_btns( 'swell_meta_ttlbg', $meta_val, 'id' ); ?>
			</div>
			<p class="swl-meta__desc">
				<?=esc_html__( 'タイトル表示位置が「コンテンツ上」の場合の背景画像を指定します。', 'swell' )?>
			</p>
		</div>

		<div class="swl-meta__item">
			<div class="swl-meta__subttl">
				<?=esc_html__( '表示の上書き設定', 'swell' )?>
			</div>
			<?php
				$show_or_hide_options = [
					'show' => _x( '表示', 'show', 'swell' ),
					'hide' => _x( '非表示', 'show', 'swell' ),
				];

				$meta_items = [
					'swell_meta_ttl_pos' => [
						'title'   => __( 'タイトル位置', 'swell' ),
						'options' => [
							'top'   => __( 'コンテンツ上', 'swell' ),
							'inner' => __( 'コンテンツ内', 'swell' ),
						],
					],
					'swell_meta_show_pickbnr' => [
						'title'   => __( 'ピックアップバナー', 'swell' ),
						'options' => $show_or_hide_options,
					],
					'swell_meta_show_sidebar' => [
						'title'   => __( 'サイドバー', 'swell' ),
						'options' => $show_or_hide_options,
					],
					'swell_meta_show_thumb' => [
						'title'   => __( 'アイキャッチ画像', 'swell' ),
						'options' => $show_or_hide_options,
					],
					'swell_meta_show_pr_notation' => [
						'title'   => __( 'PR表記', 'swell' ),
						'options' => $show_or_hide_options,
					],
					'swell_meta_show_index' => [
						'title'   => __( '目次', 'swell' ),
						'options' => $show_or_hide_options,
					],
					'swell_meta_toc_target' => [
						'title'   => __( '目次抽出対象', 'swell' ),
						'options' => [
							'h2'   => sprintf( __( '%sまで表示', 'swell' ), 'H2' ),
							'h3'   => sprintf( __( '%sまで表示', 'swell' ), 'H3' ),
							'h4'   => sprintf( __( '%sまで表示', 'swell' ), 'H4' ),
							'h5'   => sprintf( __( '%sまで表示', 'swell' ), 'H5' ),
						],
					],
				];

				if ( ! $is_page ) :
					$meta_items['swell_meta_show_related']  = [
						'title'   => __( '関連記事', 'swell' ),
						'options' => $show_or_hide_options,
					];
					$meta_items['swell_meta_show_author']   = [
						'title'   => __( '著者情報', 'swell' ),
						'options' => $show_or_hide_options,
					];
					$meta_items['swell_meta_show_comments'] = [
						'title'   => __( 'コメント', 'swell' ),
						'options' => $show_or_hide_options,
					];
				endif;

				foreach ( $meta_items as $key => $data ) :
					$meta_val = get_post_meta( $the_id, $key, true );
			?>
					<div class="swl-meta__field -select">
						<label for="<?=esc_attr( $key )?>" class="swl-meta__label">
							<?=esc_html( $data['title'] )?>
						</label>
						<?php Field::meta_select( $key, $data['options'], $meta_val ); ?>
					</div>
			<?php
				endforeach;

				$meta_checkboxes = [
					'swell_meta_show_widget_top'    => __( '上部ウィジェットを隠す', 'swell' ),
					'swell_meta_show_widget_bottom' => __( '下部ウィジェットを隠す', 'swell' ),
					'swell_meta_hide_before_index'  => __( '目次広告を隠す', 'swell' ),
					'swell_meta_hide_autoad'        => __( '自動広告を停止する', 'swell' ),
				];

				if ( $is_page ) :
					$meta_checkboxes['swell_meta_no_mb'] = __( 'コンテンツ下の余白をなくす', 'swell' );
				else :
					$meta_checkboxes['swell_meta_hide_sharebtn']   = __( 'シェアボタンを隠す', 'swell' );
					$meta_checkboxes['swell_meta_hide_widget_cta'] = __( 'CTAウィジェットを隠す', 'swell' );
				endif;

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
	if ( ! SWELL::check_nonce( '_meta_side' ) ) {
		return;
	}

	SWELL::save_post_metas( $post_id, [
		'swell_meta_subttl'             => 'str',
		'swell_meta_related_posts'      => 'str',
		'swell_meta_youtube'            => 'str',
		'swell_meta_thumb_caption'      => 'html',
		'swell_meta_ttlbg'              => 'str',
		'swell_meta_ttl_pos'            => 'str',
		'swell_meta_show_pickbnr'       => 'str',
		'swell_meta_show_sidebar'       => 'str',
		'swell_meta_show_pr_notation'   => 'str',
		'swell_meta_show_index'         => 'str',
		'swell_meta_toc_target'         => 'str',
		'swell_meta_show_thumb'         => 'str',
		'swell_meta_show_related'       => 'str',
		'swell_meta_show_author'        => 'str',
		'swell_meta_show_comments'      => 'str',
		'swell_meta_show_widget_top'    => 'check',
		'swell_meta_show_widget_bottom' => 'check',
		'swell_meta_hide_widget_cta'    => 'check',
		'swell_meta_hide_before_index'  => 'check',
		'swell_meta_hide_autoad'        => 'check',
		'swell_meta_hide_sharebtn'      => 'check',
		'swell_meta_no_mb'              => 'check',
	] );
}
