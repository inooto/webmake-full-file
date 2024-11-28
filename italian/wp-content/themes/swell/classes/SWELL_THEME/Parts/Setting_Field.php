<?php
namespace SWELL_THEME\Parts;

if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * 設定画面用のパーツ
 */
class Setting_Field {

	private function __construct() {}

	/**
	 * Switch Checkbox
	 */
	public static function switch_checkbox( $name, $val, $checked, $label_on = '', $label_off = '' ) {
		$label_on  = $label_on ?: __( '表示する', 'swell' );
		$label_off = $label_off ?: __( '表示しない', 'swell' );
		if ( null === $name ) return;
	?>
		<div class="swl-switchCheckbox">
			<span class="__label--Off"><?=esc_html( $label_off )?></span>
			<label class="__switchBtn" for="<?=esc_attr( $name )?>">
				<input type="checkbox" name="" id="<?=esc_attr( $name )?>" class="__checkbox"<?=esc_attr( $checked )?>>
				<span class="__slider"></span>
			</label>
			<span class="__label--On"><?=esc_html( $label_on )?></span>
			<input type="hidden" name="<?=esc_attr( $name )?>" value="<?=esc_attr( $val )?>" class="__hidden">
		</div>
	<?php
	}


	/**
	 * 画像アップロード
	 */
	public static function media_btns( $id, $val, $type = 'url' ) {
		if ( 'id' === $type ) {
			$src = wp_get_attachment_url( $val ) ?: $val;
		} else {
			$src = $val;
		}
	?>
		<input type="hidden" id="src_<?=esc_attr( $id )?>" name="<?=esc_attr( $id )?>" value="<?=esc_attr( $val )?>" data-type="<?=esc_attr( $type )?>" />
		<div id="preview_<?=esc_attr( $id )?>" class="media_preview">
			<?php if ( $src ) : ?>
				<img src="<?=esc_attr( $src )?>" alt="preview" style="max-width:100%;max-height:300px;">
			<?php endif; ?>
		</div>
		<div class="media_btns">
			<input class="button" type="button" name="media-upload-btn" data-id="<?=esc_attr( $id )?>" value="<?=esc_attr__( '画像を選択', 'swell' )?>" />
			<input class="button" type="button" name="media-clear" value="<?=esc_attr__( '画像を削除', 'swell' )?>" data-id="<?=esc_attr( $id )?>" />
		</div>
	<?php
	}


	/**
	 * 設定用の option タグ
	 */
	public static function parts_select( $term_slug = '', $target_id = '', $parts_id = '' ) {
		// if ( ! $term_slug ) return;
		$args = [
			'post_type'              => 'blog_parts',
			'no_found_rows'          => true,
			'posts_per_page'         => -1,
			// 'update_post_term_cache' => false,
			// 'update_post_meta_cache' => false,
		];
		if ( $term_slug ) {
			$args['tax_query'] = [
				[
					'taxonomy' => 'parts_use',
					'field'    => 'slug',
					'terms'    => $term_slug,
					'operator' => 'AND',
				],
			];
		} else {
			$args['tax_query'] = [
				[
					'taxonomy' => 'parts_use',
					'field'    => 'slug',
					'terms'    => [ 'cta', 'for_tag', 'for_cat', 'pattern' ],
					'operator' => 'NOT IN',
				],
			];
		}
		$the_query = new \WP_Query( $args );
		?>
			<select name="" class="swell_parts_select" data-for="<?=esc_attr( $target_id )?>">
				<option value="">-- <?=esc_html__( 'ブログパーツを選択する', 'swell' )?> --</option>
				<?php
					while ( $the_query->have_posts() ) :
						$the_query->the_post();
						$the_ID = (string) get_the_ID();
					?>
						<option value="<?=esc_attr( $the_ID )?>"<?=selected( $parts_id, $the_ID, false )?>>
							<?php the_title(); ?>
						</option>
					<?php endwhile; ?>
			</select>
			<?php if ( $parts_id ) : ?>
				<a href="<?=esc_url( admin_url( '/post.php?post=' . $parts_id . '&action=edit' ) )?>" style="margin-left:.5em;font-size:.9em">
					<?=esc_html__( '編集ページへ', 'swell' )?>
				</a>
			<?php endif; ?>
		<?php
		wp_reset_postdata();
	}


	// @codingStandardsIgnoreStart
	/**
	 * 設定用の select
	 */
	public static function meta_select( $id = '', $options = [], $meta = '', $default = '----' ) {
		$id = esc_attr( $id );
	?>
		<select name="<?=$id?>" id="<?=$id?>">
			<option value=""><?=esc_html( $default )?></option>
			<?php foreach ( $options as $key => $label ) :
				$selected = (string) $key === $meta ? ' selected' : '';
			?>
				<option value="<?=esc_attr( $key )?>"<?=$selected?>>
					<?=esc_html( $label )?>
				</option>
			<?php endforeach; ?>
		</select>
	<?php
	}


	/**
	 * 設定用の checkbox
	 */
	public static function meta_checkbox( $id = '', $label = '', $meta = '' ) {
		$checked = '1' === $meta ? ' checked' : '';
		$id      = esc_attr( $id );
	?>
		<input type="hidden" name="<?=$id?>" value="0" />
		<input type="checkbox" name="<?=$id?>" id="<?=$id?>" value="1"<?=$checked?>>
		<label for="<?=$id?>"><?=esc_html( $label )?></label>
	<?php
	}


	/**
	 * 設定用の text input （swell_meta_subttl付き
	 */
	public static function meta_text_input( $args = [] ) {
		$default = [
			'id' => '',
			'title' => '',
			'meta' => '',
			'type' => 'text',
			'placeholder' => '',
			'size' => '40',
		];
		$args = array_merge( $default, $args );
		$id = esc_attr( $args['id'] );
		$subtitle = esc_html( $args['title'] );
	?>
	<?php if ( $subtitle ) : ?>
			<label for="<?=$id?>" class="swl-meta__subttl"><?=$subtitle?></label>
		<?php endif; ?>

		<div class="swl-meta__field">
			<input type="<?=esc_attr( $args['type'] )?>" id="<?=$id?>" name="<?=$id?>" value="<?=esc_attr( $args['meta'] )?>" size="<?=esc_attr( $args['size'] )?>" placeholder="<?=esc_attr( $args['placeholder'] )?>" />
		</div>
	<?php
	}

	/**
	 * 設定用の radiobox
	 */
	public static function meta_radiobox( $name = '', $choices = '', $meta = '', $is_block = true ) {
		$u_block = $is_block ? ' u-block' : '';
	?>
		<div class="swl-meta__field -radio">
			<?php
				foreach ( $choices as $key => $label ) :
				$checked = ( $meta === $key ) ? ' checked' : '';
				$name = esc_attr( $name );
				$key  = esc_attr( $key );
				$radio_id = $name . '_' . $key;
				?>
					<label for="<?=$radio_id?>" class="swl-meta__radio<?=$u_block?>">
						<input type="radio" id="<?=$radio_id?>" name="<?=$name?>" value="<?=$key?>"<?=$checked?> />
						<?=esc_html( $label )?>
					</label>
				<?php
				endforeach;
			?>
		</div>
	<?php
	}


	/**
	 * textarea
	 */
	public static function meta_textarea( $name, $value, $args = [] ) {

		$placeholder = $args['placeholder'] ?? '';
		$rows        = $args['rows'] ?? 4;

		echo '<textarea id="' . esc_attr( $name ) . '" name="' . esc_attr( $name ) . '" class="regular-text" rows="' . esc_attr( $rows ) . '" placeholder="' . esc_attr( $placeholder ) . '">' . esc_textarea( $value ) . '</textarea>';

	}
	// @codingStandardsIgnoreEnd

	/**
	 * 設定用の option タグ
	 */
	// public static function select_option( $key = '', $label = '', $selected = false ) {
	// 	// $selected は esc_ 通さない。
	// 	echo '<option value="' . esc_attr( $key ) . '"' . $selected . '>' . esc_html( $label ) . '</option>';
	// }

}
