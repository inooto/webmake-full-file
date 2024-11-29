<?php
namespace SWELL_THEME\Menu;

if ( ! defined( 'ABSPATH' ) ) exit;

class Tab_Marker {

	/**
	 * マーカー
	 */
	public static function marker_settings( $page_name ) {
		$section_name = 'swell_section_marker_color';

		// セクションの追加
		add_settings_section(
			$section_name,
			__( 'マーカー設定', 'swell' ),
			'',
			$page_name
		);

		add_settings_field(
			'marker_type',
			__( 'スタイル', 'swell' ),
			[__CLASS__, 'callback_for_marker_type' ],
			$page_name,
			$section_name,
			[
				'class' => 'marker_type',
			]
		);
		add_settings_field(
			'marker_color',
			__( 'カラー', 'swell' ),
			[__CLASS__, 'callback_for_marker_color' ],
			$page_name,
			$section_name,
			[
				'class'  => 'marker_color',
				'colors' => [
					'orange',
					'yellow',
					'green',
					'blue',
				],
			]
		);
	}


	/**
	 * マーカー設定用の専用コールバック
	 */
	public static function callback_for_marker_type( $args ) {

		$type_key  = 'marker_type';
		$type_val  = \SWELL_Theme::get_editor( $type_key );
		$type_name = \SWELL_Theme::DB_NAME_EDITORS . '[' . $type_key . ']';

		$marker_types = [
			'thin'        => __( '細線', 'swell' ),
			'bold'        => __( '太線', 'swell' ),
			'stripe'      => __( 'ストライプ', 'swell' ),
			'thin-stripe' => __( '細ストライプ', 'swell' ),
		];

		?>
			<div class="swell-menu-marker">
				<div class="__settings">
					<select name="<?=esc_attr( $type_name )?>" class="__type">
						<?php
						foreach ( $marker_types as $key => $text ) :
							if ( selected( $key, $type_val, false ) ) $isCustomColor = false;
							echo '<option value="' . esc_attr( $key ) . '"' . selected( $key, $type_val, false ) . '>' . esc_html( $text ) . '</option>';
						endforeach;
						?>
					</select>
				</div>
			</div>
		<?php
	}
	public static function callback_for_marker_color( $args ) {
		$colors = $args['colors'];
		?>
			<div class="swell-menu-marker">
				<div class="__settings">
					<?php
					foreach ( $colors as $color ) :
						$key  = 'color_mark_' . $color;
						$val  = \SWELL_Theme::get_editor( $key );
						$dflt = \SWELL_Theme::get_default_editor( $key );
						$name = \SWELL_Theme::DB_NAME_EDITORS . '[' . $key . ']';
					?>
						<input type="text" class="colorpicker __<?=esc_attr( $color )?>"
							id="<?=esc_attr( $key )?>"
							name="<?=esc_attr( $name )?>"
							value="<?=esc_attr( $val )?>"
							data-default-color="<?=esc_attr( $dflt )?>"
						/>
					<?php endforeach; ?>
				</div>
				<div class="__preview">
					<div class="">
						<span class="swl-marker mark_orange"><?=esc_html_x( 'マーカー', 'format', 'swell' )?> 01</span>
						&nbsp;
						<span class="swl-marker mark_yellow"><?=esc_html_x( 'マーカー', 'format', 'swell' )?> 02</span>
						&nbsp;
						<span class="swl-marker mark_green"><?=esc_html_x( 'マーカー', 'format', 'swell' )?> 03</span>
						&nbsp;
						<span class="swl-marker mark_blue"><?=esc_html_x( 'マーカー', 'format', 'swell' )?> 04</span>
					</div>
					<div class="__previewLabel"><?=esc_html__( 'プレビュー', 'swell' )?></div>
				</div>
			</div>
		<?php
	}

}
