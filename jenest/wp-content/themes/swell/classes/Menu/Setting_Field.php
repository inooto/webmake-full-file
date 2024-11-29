<?php
namespace SWELL_Theme\Menu;

use \SWELL_THEME\Admin_Menu;

if ( ! defined( 'ABSPATH' ) ) exit;

class Setting_Field extends Admin_Menu {

	/**
	 * 設定メニューの項目を追加
	 */
	public static function add_menu_section( $args ) {

		// phpcs:ignore WordPress.PHP.DontExtract.extract_extract
		extract( array_merge( [
			'title'      => '',
			'key'        => '',
			'section_cb' => '', // h2下の出力
			'page_name'  => '',
			'page_cb'    => '', // 設定エリアの出力
		], $args ) );

		$section_name = 'swell_' . $key . '_section';

		add_settings_section( $section_name, $title, $section_cb, $page_name );
		add_settings_field( $section_name . '_fields', '', $page_cb, $page_name, $section_name, [
			'class' => $section_name,
		] );
	}


	/**
	 * h3
	 */
	public static function h3( $text ) {
		echo '<h3 class="h3">' . wp_kses( $text, \SWELL_Theme::$allowed_text_html ) . '</h3>';
	}
	/**
	 * h4
	 */
	public static function h4( $text ) {
		echo '<h4 class="h4">' . wp_kses( $text, \SWELL_Theme::$allowed_text_html ) . '</h4>';
	}


	/**
	 * .swl-setting__field__title
	 */
	public static function field_title( $text, $tag = 'div' ) {
		if ( ! $text ) return;
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo '<' . $tag . ' class="swl-setting__field__title">' . wp_kses( $text, \SWELL_Theme::$allowed_text_html ) . '</' . $tag . '>';
	}


	/**
	 * p.description
	 */
	public static function description( $text ) {
		if ( ! $text ) return;
		echo '<p class="description">' . wp_kses( $text, \SWELL_Theme::$allowed_text_html ) . '</p>';
	}


	/**
	 * input : for "text" | "number" | "email" | ...]
	 */
	public static function input( $db_name, $key, $args = [] ) {
		$args = array_merge( [
			'label'       => '',
			'type'        => 'text',
			'class'       => '',
			'step'        => '1',
			'after'       => '',
			'desc'        => '',
			'size'        => '40',
			'placeholder' => '',
		], $args );

		$name        = \SWELL_Theme::DB_NAMES[ $db_name ] . '[' . $key . ']';
		$value       = \SWELL_Theme::get_data( $db_name, $key );
		$field_class = trim( '-input ' . $args['class'] );

		$props = [
			'type'        => $args['type'],
			'id'          => $name,
			'name'        => $name,
			'value'       => $value,
			'size'        => $args['size'],
			'placeholder' => $args['placeholder'],
		];

		if ( 'number' === $args['type'] ) {
			$props['step'] = $args['step'];
		}

		echo '<div class="swl-setting__field ' . esc_attr( $field_class ) . '" data-key="' . esc_attr( $key ) . '">';
		self::field_title( $args['label'], 'label' );

		// phpcs:ignore WordPress.Security.EscapeOutput
		echo '<input ' . \SWELL_Theme::array_to_html_attrs( $props ) . ' />';
		if ( $args['after'] ) echo wp_kses( $args['after'], \SWELL_Theme::$allowed_text_html );

		self::description( $args['desc'] );
		echo '</div>';
	}


	/**
	 * checkbox
	 */
	public static function checkbox( $db_name, $key, $args = [] ) {

		$args = array_merge( [
			'label' => '',
			'class' => '',
			'desc'  => '',
		], $args );

		$name        = \SWELL_Theme::DB_NAMES[ $db_name ] . '[' . $key . ']';
		$value       = \SWELL_Theme::get_data( $db_name, $key );
		$field_class = trim( '-checkbox ' . $args['class'] );

		$check_props = [
			'id'      => $name,
			'name'    => $name,
			'checked' => '1' === (string) $value,
		];

		echo '<div class="swl-setting__field ' . esc_attr( $field_class ) . '" data-key="' . esc_attr( $key ) . '">';

		echo '<div class="swl-checkboxWrapper">';
		echo '<input type="hidden" name="' . esc_attr( $name ) . '" value="">';
		echo '<input type="checkbox" value="1" ' . \SWELL_Theme::array_to_html_attrs( $check_props ) . ' />'; // phpcs:ignore WordPress.Security
		echo '<label for="' . esc_attr( $name ) . '">' . wp_kses( $args['label'], \SWELL_Theme::$allowed_text_html ) . '</label>';
		echo '</div>';

		self::description( $args['desc'] );
		echo '</div>';
	}


	/**
	 * radio
	 */
	public static function radio( $db_name, $key, $args = [] ) {

		$args = array_merge( [
			'label'   => '',
			'choices' => [],
			'class'   => '',
			'desc'    => '',
		], $args );

		$name        = \SWELL_Theme::DB_NAMES[ $db_name ] . '[' . $key . ']';
		$value       = \SWELL_Theme::get_data( $db_name, $key );
		$field_class = trim( '-radio ' . $args['class'] );

		echo '<div class="swl-setting__field ' . esc_attr( $field_class ) . '" data-key="' . esc_attr( $key ) . '">';
		self::field_title( $args['label'], 'label' );

		foreach ( $args['choices'] as $radio_val => $radio_label ) {
			$radio_id = $key . '_' . $radio_val;

			$radio_props = [
				'id'      => $radio_id,
				'name'    => $name,
				'value'   => $radio_val,
				'checked' => $value === $radio_val,
			];

			echo '<div class="swl-radioWrapper">' .
				'<label for="' . esc_attr( $radio_id ) . '">' .
					'<input type="radio" ' . \SWELL_Theme::array_to_html_attrs( $radio_props ) . ' />' . // phpcs:ignore WordPress.Security
					'<span>' . wp_kses( $radio_label, \SWELL_Theme::$allowed_text_html ) . '</span>' .
				'</label>' .
			'</div>';
		}

		self::description( $args['desc'] );
		echo '</div>';

	}


	/**
	 * select
	 */
	public static function select( $db_name, $key, $args = [] ) {

		$args = array_merge( [
			'label'   => '',
			'choices' => [],
			'class'   => '',
			'desc'    => '',
		], $args );

		$name        = \SWELL_Theme::DB_NAMES[ $db_name ] . '[' . $key . ']';
		$value       = \SWELL_Theme::get_data( $db_name, $key );
		$field_class = trim( '-select ' . $args['class'] );

		echo '<div class="swl-setting__field ' . esc_attr( $field_class ) . '" data-key="' . esc_attr( $key ) . '">';
		self::field_title( $args['label'], 'label' );

		echo '<select id="' . esc_attr( $name ) . '" name="' . esc_attr( $name ) . '">';
		foreach ( $args['choices'] as $option_val => $option_label ) {
			echo '<option value="' . esc_attr( $option_val ) . '"' . selected( $value, $option_val, false ) . '>' . wp_kses_post( $option_label ) . '</option>';
		}
		echo '</select>';
		// echo wp_kses_post( $after );

		self::description( $args['desc'] );
		echo '</div>';
	}


	/**
	 * textarea
	 */
	public static function textarea( $db_name, $key, $args = [] ) {

		$args = array_merge( [
			'label'       => '',
			'class'       => '',
			'placeholder' => '',
			'rows'        => 8,
			'before'      => '',
			'after'       => '',
			'size_class'  => 'regular-text',
			'desc'        => '',
		], $args );

		$name  = \SWELL_Theme::DB_NAMES[ $db_name ] . '[' . $key . ']';
		$value = \SWELL_Theme::get_data( $db_name, $key );

		$textarea_props = [
			'id'          => $name,
			'name'        => $name,
			'class'       => $args['size_class'],
			'rows'        => $args['rows'],
			'placeholder' => $args['placeholder'],
		];
		$field_class    = trim( '-textarea ' . $args['class'] );

		echo '<div class="swl-setting__field ' . esc_attr( $field_class ) . '" data-key="' . esc_attr( $key ) . '">';
		self::field_title( $args['label'], 'label' );

		// phpcs:ignore WordPress.Security
		echo '<textarea ' . \SWELL_Theme::array_to_html_attrs( $textarea_props ) . '>' . esc_textarea( $value ) . '</textarea>';

		self::description( $args['desc'] );
		echo '</div>';
	}


	/**
	 * 画像アップロード
	 */
	public static function media( $db_name, $key, $args = [] ) {

		$args = array_merge( [
			'label'       => '',
			'class'       => '',
			'type'        => 'id',
			'desc'        => '',
		], $args );

		$name        = \SWELL_Theme::DB_NAMES[ $db_name ] . '[' . $key . ']';
		$value       = \SWELL_Theme::get_data( $db_name, $key );
		$type        = $args['type'];
		$field_class = trim( '-media ' . $args['class'] );

		if ( 'id' === $type ) {
			$src = wp_get_attachment_url( $value ) ?: $value;
		} else {
			$src = $value;
		}
	?>
		<div class="swl-setting__field <?=esc_attr( $field_class )?>" data-key="<?=esc_attr( $key )?>">
			<?php self::field_title( $args['label'], 'label' ); ?>

			<input type="hidden" id="src_<?=esc_attr( $key )?>" name="<?=esc_attr( $name )?>" value="<?=esc_attr( $value )?>" data-type="<?=esc_attr( $type )?>" />
			<div id="preview_<?=esc_attr( $key )?>" class="media_preview">
				<?php if ( $src ) : ?>
					<img src="<?=esc_attr( $src )?>" alt="preview" style="max-width:100%;max-height:300px;">
				<?php endif; ?>
			</div>

			<div class="media_btns">
				<input class="button button-primary" type="button" name="media-upload-btn" data-id="<?=esc_attr( $key )?>" value="<?=esc_attr__( '画像を選択', 'swell' )?>" />
				<input class="button" type="button" name="media-clear" value="<?=esc_attr__( '画像を削除', 'swell' )?>" data-id="<?=esc_attr( $key )?>" />
			</div>

			<?php self::description( $args['desc'] ); ?>
		</div>
	<?php
	}


	/**
	 * Switch Checkbox
	 */
	public static function toggle_control( $db_name, $key, $args = [] ) {

		$args = array_merge( [
			'label'       => '',
			'class'       => '',
			'desc'        => '',
		], $args );

		$name        = \SWELL_Theme::DB_NAMES[ $db_name ] . '[' . $key . ']';
		$value       = \SWELL_Theme::get_data( $db_name, $key );
		$field_class = trim( '-toggle ' . $args['class'] );

		$check_props = [
			'value'   => '1',
			'id'      => $name,
			'name'    => $name,
			'checked' => '1' === (string) $value,
		];

	?>
		<div class="swl-setting__field <?=esc_attr( $field_class )?>" data-key="<?=esc_attr( $key )?>">
			<div class="swl-toggleControl">
				<label class="__inner" for="<?=esc_attr( $name )?>">
					<input type="hidden" name="<?=esc_attr( $name )?>" value="">
					<input type="checkbox" <?php echo \SWELL_Theme::array_to_html_attrs( $check_props ); // phpcs:ignore WordPress.Security ?>>
					<span class="__trackWrap"><span class="__track"><span class="__dot"></span></span></span>
					<span class="__text"><?=wp_kses( $args['label'], \SWELL_Theme::$allowed_text_html )?></span>
				</label>
			</div>
			<?php self::description( $args['desc'] ); ?>
		</div>
	<?php
	}


	/**
	 * color
	 */
	public static function color( $field_id, $name, $val, $label = '' ) {
		// echo '<div>';
		// if ( $label ) {
		// 	echo '<label for="' . esc_attr( $field_id ) . '">' . wp_kses_post( $label ) . '</label>';
		// }
		// echo '<input type="text" id="' . esc_attr( $field_id ) . '" name="' . esc_attr( $name ) . '" class="colorpicker" value="' . esc_attr( $val ) . '">';
		// echo '</div>';
	}

}
