<?php
namespace SWELL_THEME\Menu;

if ( ! defined( 'ABSPATH' ) ) exit;

class Tab_Border {

	/**
	 * ボーダー
	 */
	public static function border_settings( $page_name ) {

		$section_name = 'swell_section_border_set';

		add_settings_section(
			$section_name,
			__( 'ボーダーセットの登録', 'swell' ),
			'',
			$page_name
		);

		for ( $i = 1; $i < 5; $i++ ) {
			add_settings_field(
				'border_set_0' . $i, // フィールドID。何にも使わない
				__( 'ボーダーセット', 'swell' ) . ': 0' . $i,
				[__CLASS__, 'callback' ],
				$page_name,
				$section_name,
				[
					'num' => '0' . $i,
				]
			);
		}
	}


	/**
	 * ボーダー設定専用
	 */
	public static function callback( $args ) {

		$num = $args['num'];

		$field_id = 'border' . $num;
		$name     = \SWELL_Theme::DB_NAME_EDITORS . "[$field_id]";
		$val      = \SWELL_Theme::get_editor( $field_id );

		$borderData = explode( ' ', $val );
		$style      = $borderData[0];
		$width      = absint( $borderData[1] );
		$color      = $borderData[2];

		$border_styles = [
			'solid',
			'double',
			'groove',
			'ridge',
			'inset',
			'outset',
			'dashed',
			'dotted',
		];

		$border_colors = [
			'var(--color_main)'   => __( 'メインカラー', 'swell' ),
			'var(--color_border)' => _x( 'グレー', 'color', 'swell' ),
			'var(--color_gray)'   => _x( '薄いグレー', 'color', 'swell' ),
		];
		// カスタムカラーかどうか
		$isCustomColor = true;
	?>

		<div class="swell-menu-border">
			<div class="__settings">
				<div class="__item">
					<select name="" class="__style">
						<?php
						foreach ( $border_styles as $s ) :
							echo '<option value="' . esc_attr( $s ) . '"' . selected( $s, $style, false ) . '>' . esc_html( $s ) . '</option>';
						endforeach;
						?>
					</select>
				</div>
				<div class="__item">
					<input type="number" class="__width" id="<?=esc_attr( $field_id )?>" min="1" size="4" name="" value="<?=esc_attr( $width )?>">px
				</div>
				<div class="__item">
					<select name="" class="__color">
						<?php
						foreach ( $border_colors as $key => $text ) :
							if ( selected( $key, $color, false ) ) $isCustomColor = false;
							echo '<option value="' . esc_attr( $key ) . '"' . selected( $key, $color, false ) . '>' . esc_html( $text ) . '</option>';
						endforeach;
						?>
						<?php $selected = $isCustomColor ? ' selected' : ''; ?>
						<option value="custom"<?=esc_attr( $selected )?>><?=esc_html__( 'カスタム', 'swell' )?></option>
					</select>
					<div class="-customColor<?php echo $isCustomColor ? '' : ' u-none'; ?>">
						<input type="text" class="colorpicker __customColor" name="" value="<?=esc_attr( $color )?>" />
					</div>
				</div>
			</div>
			<div class="__preview">
				<div class="__previewLabel"><?=esc_html__( 'プレビュー', 'swell' )?></div>
				<div class="__previwBox" style="border:<?=esc_attr( $val )?>">
					<span><?=esc_html__( 'ここにコンテンツが入ります', 'swell' )?></span>
				</div>
			</div>
			<input type="hidden" id="<?=esc_attr( $field_id )?>" size="40" name="<?=esc_attr( $name )?>" value="<?=esc_attr( $val )?>" class="__hidden">
		</div>
	<?php
	}

}
