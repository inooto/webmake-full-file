<?php
namespace SWELL_Theme;

if ( ! defined( 'ABSPATH' ) ) exit;

// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped

class Legacy_Widget {

	public function __construct() {
		add_action( 'widgets_init', [ __CLASS__, 'init_legacy_widget' ] );
	}

	public static function init_legacy_widget() {

		// ウィジェットアイテムを読み込む ( 後方互換を考え、名前空間は指定していないことに注意。 )
		require_once __DIR__ . '/Legacy_Widget/SWELL_Ad_Widget.php';
		require_once __DIR__ . '/Legacy_Widget/SWELL_New_Posts.php';
		require_once __DIR__ . '/Legacy_Widget/SWELL_Prof_Widget.php';
		require_once __DIR__ . '/Legacy_Widget/SWELL_Popular_Posts.php';
		require_once __DIR__ . '/Legacy_Widget/SWELL_Index.php';
		require_once __DIR__ . '/Legacy_Widget/SWELL_Promotion_Banner.php';
		require_once __DIR__ . '/Legacy_Widget/SWELL_SNS_Links.php';
		require_once __DIR__ . '/Legacy_Widget/Custom_WP_Widget_Recent_Posts.php';

		// タイトルでアイコン使えるようにする
		add_filter( 'widget_title', 'do_shortcode' );

		// 標準の「最新の投稿」ウィジェットを削除
		unregister_widget( 'wp_widget_recent_posts' );

		// 自作ウィジェットアイテムの登録
		register_widget( 'SWELL_Ad_Widget' );
		register_widget( 'SWELL_New_Posts' );
		register_widget( 'SWELL_Popular_Posts' );
		register_widget( 'SWELL_Prof_Widget' );
		register_widget( 'SWELL_Index' );
		register_widget( 'SWELL_Promotion_Banner' );
		register_widget( 'SWELL_SNS_Links' );
		register_widget( 'Custom_WP_Widget_Recent_Posts' );
	}


	/**
	 * テキストフィールド出力
	 */
	public static function text_field( $args ) {
		$label       = $args['label'] ?? '';
		$id          = $args['id'] ?? '';
		$name        = $args['name'] ?? '';
		$value       = $args['value'] ?? '';
		$field_class = $args['field_class'] ?? '';
		$placeholder = $args['placeholder'] ?? '';
		$help        = $args['help'] ?? '';

	?>
		<div class="swl-widgetField -text <?=esc_attr( $field_class )?>">
			<label for="<?=esc_attr( $id )?>"><?=esc_html( $label )?> : </label>
			<input type="text" id="<?=esc_attr( $id )?>" name="<?=esc_attr( $name )?>" class="widefat" value="<?=esc_attr( $value )?>" placeholder="<?=esc_attr( $placeholder )?>">
			<?php if ( $help ) : ?>
				<br><small><?=esc_html( $help )?></small>
			<?php endif; ?>
		</div>
	<?php
	}


	/**
	 * テキストエリア
	 */
	public static function textarea_field( $args ) {
		$label       = $args['label'] ?? '';
		$id          = $args['id'] ?? '';
		$name        = $args['name'] ?? '';
		$value       = $args['value'] ?? '';
		$field_class = $args['field_class'] ?? '';
		$rows        = $args['rows'] ?? '4';
	?>
		<div class="swl-widgetField -textarea <?=esc_attr( $field_class )?>">
			<label for="<?=esc_attr( $id )?>"><?=esc_html( $label )?> : </label>
			<textarea id="<?=esc_attr( $id )?>" name="<?=esc_attr( $name )?>" rows="<?=esc_attr( $rows )?>" class="widefat"><?=esc_textarea( $value )?></textarea>
		</div>
		<?php
	}


	/**
	 * 数字フィールド出力
	 */
	public static function num_field( $args ) {
		$label       = $args['label'] ?? '';
		$id          = $args['id'] ?? '';
		$name        = $args['name'] ?? '';
		$value       = $args['value'] ?? '';
		$field_class = $args['field_class'] ?? '';
		$step        = $args['step'] ?? '1';
		$min         = $args['min'] ?? '';
		$max         = $args['max'] ?? '';
		$size        = $args['size'] ?? '';

		$props = 'step="' . esc_attr( $step ) . '" min="' . esc_attr( $min ) . '" max="' . esc_attr( $max ) . '" size="' . esc_attr( $size ) . '"';

	?>
		<div class="swl-widgetField -num <?=esc_attr( $field_class )?>">
			<label for="<?=esc_attr( $id )?>"><?=esc_html( $label )?> : </label>
			<input type="number" class="tiny-text" id="<?=esc_attr( $id )?>" name="<?=esc_attr( $name )?>" value="<?=esc_attr( $value )?>" <?=$props?>>
		</div>
	<?php
	}


	/**
	 * ラジオフィールド出力
	 */
	public static function radio_field( $args ) {
		// $label       = $args['label'] ?? '';
		$id          = $args['id'] ?? '';
		$name        = $args['name'] ?? '';
		$value       = $args['value'] ?? '';
		$field_class = $args['field_class'] ?? '';
		$choices     = $args['choices'] ?? [];
	?>
		<div class="swl-widgetField -radio <?=esc_attr( $field_class )?>">
		<?php foreach ( $choices as $choice ) : ?>
			<p class="__choice">
			<input type="radio" id="<?=esc_attr( $id . '-' . $choice['key'] )?>" name="<?=$name?>" value="<?=esc_html( $choice['value'] )?>" <?php checked( $value, $choice['value'] ); ?>>
			<label for="<?=esc_attr( $id . '-' . $choice['key'] )?>"><?=esc_html( $choice['label'] )?></label>
			</p>
		<?php endforeach; ?>
		</div>
	<?php
	}


	/**
	 * チェックフィールド出力
	 */
	public static function check_field( $args ) {
		$label       = $args['label'] ?? '';
		$id          = $args['id'] ?? '';
		$name        = $args['name'] ?? '';
		$checked     = $args['checked'] ?? false;
		$field_class = $args['field_class'] ?? '';

		$props = $checked ? 'checked' : '';
	?>
		<div class="swl-widgetField -checkbox <?=esc_attr( $field_class )?>">
			<input type="checkbox" class="checkbox" id="<?=esc_attr( $id )?>" name="<?=esc_attr( $name )?>" value="1" <?=$props?>>
			<label for="<?=esc_attr( $id )?>"><?=esc_html( $label )?></label>
		</div>
	<?php
	}


	/**
	 * カラーフィールド出力
	 */
	public static function color_field( $args ) {
		$label       = $args['label'] ?? '';
		$id          = $args['id'] ?? '';
		$name        = $args['name'] ?? '';
		$value       = $args['value'] ?? '';
		$field_class = $args['field_class'] ?? '';
		$placeholder = $args['placeholder'] ?? '';

	?>
		<div class="swl-widgetField -color <?=esc_attr( $field_class )?>">
			<label for="<?=esc_attr( $id )?>"><?=esc_html( $label )?> : </label>
			<input type="text" id="<?=esc_attr( $id )?>" name="<?=esc_attr( $name )?>" class="widget_colorpicker" value="<?=esc_attr( $value )?>" placeholder="<?=esc_attr( $placeholder )?>">
		</div>
	<?php
	}


	/**
	 * メディアアップロード
	 */
	public static function media_field( $args ) {
		$label       = $args['label'] ?? '';
		$id          = $args['id'] ?? '';
		$name        = $args['name'] ?? '';
		$value       = $args['value'] ?? '';
		$field_class = $args['field_class'] ?? '';
		$width       = $args['width'] ?? '';
		$height      = $args['height'] ?? '';

		$props                 = '';
		if ( $width ) $props  .= ' width="' . esc_attr( $width ) . '"';
		if ( $height ) $props .= ' height="' . esc_attr( $height ) . '"';
	?>
		<div class="swl-widgetField -media <?=esc_attr( $field_class )?>">
			<label for="<?=esc_attr( $id )?>"><?=esc_html( $label )?> : </label>
			<input type="hidden" id="src_<?=esc_attr( $id )?>" name="<?=esc_attr( $name )?>" value="<?=esc_attr( $value )?>">
			<div id="preview_<?=esc_attr( $id )?>" class="media_preview">
				<?php if ( $value ) : ?>
					<img src="<?=esc_url( $value )?>" loading="lazy" alt="" <?=$props?>>
				<?php endif; ?>
			</div>
			<div class="media_btns">
				<input class="button" type="button" name="media-upload-btn" data-id="<?=esc_attr( $id )?>" value="<?=esc_attr__( '画像を選択', 'swell' )?>" />
				<input class="button" type="button" name="media-clear" value="<?=esc_attr__( '画像を削除', 'swell' )?>" data-id="<?=esc_attr( $id )?>" />
			</div>
		</div>
		<?php
	}
}
