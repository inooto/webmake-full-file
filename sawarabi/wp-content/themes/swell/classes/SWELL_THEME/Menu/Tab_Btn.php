<?php
namespace SWELL_THEME\Menu;

if ( ! defined( 'ABSPATH' ) ) exit;

class Tab_Btn {

	/**
	 * ボタン
	 */
	public static function btn_settings( $page_name ) {

		$section_name = 'swell_section_btns';

		add_settings_section(
			$section_name,
			__( 'SWELLボタンの設定', 'swell' ),
			'',
			$page_name
		);

		add_settings_field(
			'swell_btn_color', // フィールドID
			__( 'カラー設定', 'swell' ),
			[__CLASS__, 'callback_for_colors' ],
			$page_name,
			$section_name,
			[
				'class'  => 'btn_colors',
				'colors' => [
					'red'   => _x( '赤', 'color', 'swell' ),
					'blue'  => _x( '青', 'color', 'swell' ),
					'green' => _x( '緑', 'color', 'swell' ),
				],
			]
		);

		add_settings_field(
			'swell_btn_radius', // フィールドID
			__( 'ボタンの丸み', 'swell' ),
			[__CLASS__, 'callback_for_radius' ],
			$page_name,
			$section_name,
			[
				'class' => 'btn_radius',
			]
		);

		add_settings_field(
			'swell_btn_preview', // フィールドID
			'',
			[__CLASS__, 'callback_for_preview' ],
			$page_name,
			$section_name,
			[
				'class' => 'btn_preview',
			]
		);
	}


	/**
	 * コールバック
	 */
	public static function callback_for_gradation( $args ) {
		$key   = 'is_btn_gradation';
		$val   = \SWELL_Theme::get_editor( $key );
		$name  = \SWELL_Theme::DB_NAME_EDITORS . '[' . $key . ']';
		$label = __( 'ボタンのグラデーションをオンにする', 'swell' );

		echo '<input type="hidden" name="' . esc_attr( $name ) . '" value="">' .
			'<input type="checkbox" id="' . esc_attr( $key ) . '" name="' . esc_attr( $name ) . '" value="1" ' . checked( (string) $val, '1', false ) . ' class="__gradation"/>' .
			'<label for="' . esc_attr( $key ) . '">' . esc_html( $label ) . '</label>';
		echo '<p class="description">' . esc_html__( '※ ノーマルボタン・キラッとボタンでのみ有効', 'swell' ) . '</p>';
	}

	public static function callback_for_radius( $args ) {
		$btn_styles = [
			'normal' => _x( 'ノーマル', 'btn-style', 'swell' ),
			'solid'  => _x( '立体', 'btn-style', 'swell' ),
			'shiny'  => _x( 'キラッと', 'btn-style', 'swell' ),
			'line'   => _x( 'アウトライン', 'btn-style', 'swell' ),
		];
	?>
		<div class="swell-menu-btn">
			<div class="__settings">
				<?php
				foreach ( $btn_styles as $style => $btn_name ) :
					$key = 'btn_radius_' . $style;

					$name = \SWELL_Theme::DB_NAME_EDITORS . '[' . $key . ']';
					$val  = \SWELL_Theme::get_editor( $key );

					$choices = [
						'0px'  => __( '丸みなし', 'swell' ),
						'4px'  => __( '少し丸める', 'swell' ),
						'80px' => __( '丸める', 'swell' ),
					];
				?>
				<div class="__field">
					<div class="__btnName"><?=esc_html( $btn_name )?></div>
					<?php
					foreach ( $choices as $px => $label ) :
						$checked = checked( $val, $px, false );
					?>
						<label for="<?=esc_attr( $key . '_' . $px )?>" class="__radioLabel">
							<input type="radio" id="<?=esc_attr( $key . '_' . $px )?>" name="<?=esc_attr( $name )?>" value="<?=esc_attr( $px )?>"<?=checked( $val, $px, false )?> class="u-none">
							<span class="__btn __radius_<?=esc_attr( $px )?>"><?=esc_html( $label )?></span>
						</label>
					<?php endforeach; ?>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	<?php
	}

	public static function callback_for_colors( $args ) {

		$db     = \SWELL_Theme::DB_NAME_EDITORS;
		$colors = $args['colors'];

		$is_gradation = \SWELL_Theme::get_editor( 'is_btn_gradation' );
	?>

		<div class="swell-menu-btn" data-is-grad="<?=esc_attr( $is_gradation )?>">
			<div class="__settings">
				<?php
				foreach ( $colors as $color => $color_name ) :
					$color2 = $color . '2';

					$key  = 'color_btn_' . $color;
					$val  = \SWELL_Theme::get_editor( $key );
					$dflt = \SWELL_Theme::get_default_editor( $key );
					$name = $db . '[' . $key . ']';

					$key2  = 'color_btn_' . $color2;
					$val2  = \SWELL_Theme::get_editor( $key2 );
					$dflt2 = \SWELL_Theme::get_default_editor( $key2 );
					$name2 = $db . '[' . $key2 . ']';
				?>
				<div class="__field -btnColor">
					<span class="__colorName"><?=esc_html( $color_name )?> : </span>
					<input type="text" class="colorpicker __<?=esc_attr( $color )?>"
						id="<?=esc_attr( $key )?>"
						name="<?=esc_attr( $name )?>"
						value="<?=esc_attr( $val )?>"
						data-default-color="<?=esc_attr( $dflt )?>"
					/>
					<input type="text" class="colorpicker __<?=esc_attr( $color2 )?> -for-gradation"
						id="<?=esc_attr( $key2 )?>"
						name="<?=esc_attr( $name2 )?>"
						value="<?=esc_attr( $val2 )?>"
						data-default-color="<?=esc_attr( $dflt2 )?>"
					/>
					</div>
				<?php endforeach; ?>

				<?php
				// グラデーション設定
				$key   = 'is_btn_gradation';
				$val   = $is_gradation;
				$name  = \SWELL_Theme::DB_NAME_EDITORS . '[' . $key . ']';
				$label = __( 'ボタンのグラデーションをオンにする', 'swell' );
			?>
			<div class="__field -gradation  u-mt-10">
				<input type="hidden" name="<?=esc_attr( $name )?>" value="">
				<input type="checkbox" id="<?=esc_attr( $key )?>" name="<?=esc_attr( $name )?>" value="1" <?=checked( (string) $val, '1', false )?> class="__gradation"/>
				<label for="<?=esc_attr( $key )?>"><?=esc_html( $label )?></label>
				<p class="description"><?=esc_html__( '※ ノーマルボタン・キラッとボタンでのみ有効', 'swell' )?></p>
			</div>
			</div>
		</div>
	<?php
	}

	public static function callback_for_preview( $args ) {
		$is_gradation = \SWELL_Theme::get_editor( 'is_btn_gradation' );

		?>
			<div class="swell-menu-btn -preview" data-is-grad="<?=esc_attr( $is_gradation )?>">
				<div class="__preview">
					<div class="__previewLabel"><?=esc_html__( 'プレビュー', 'swell' ) . ':' . esc_html_x( 'ノーマル', 'btn-style', 'swell' )?></div>
					<div class="__prevRow">
						<div class="swell-block-button red_ is-style-btn_normal -size-s">
							<a class="swell-block-button__link" href="javascript:void(0)">BUTTON</a>
						</div>
						<div class="swell-block-button blue_ is-style-btn_normal -size-s">
							<a class="swell-block-button__link" href="javascript:void(0)">BUTTON</a>
						</div>
						<div class="swell-block-button green_ is-style-btn_normal -size-s">
							<a class="swell-block-button__link" href="javascript:void(0)">BUTTON</a>
						</div>
					</div>
				</div>
				<div class="__preview">
					<div class="__previewLabel"><?=esc_html__( 'プレビュー', 'swell' ) . ':' . esc_html_x( '立体', 'btn-style', 'swell' )?></div>
					<div class="__prevRow">
						<div class="swell-block-button red_ is-style-btn_solid -size-s">
							<a class="swell-block-button__link" href="javascript:void(0)">BUTTON</a>
						</div>
						<div class="swell-block-button blue_ is-style-btn_solid -size-s">
							<a class="swell-block-button__link" href="javascript:void(0)">BUTTON</a>
						</div>
						<div class="swell-block-button green_ is-style-btn_solid -size-s">
							<a class="swell-block-button__link" href="javascript:void(0)">BUTTON</a>
						</div>
					</div>
				</div>
				<div class="__preview">
					<div class="__previewLabel"><?=esc_html__( 'プレビュー', 'swell' ) . ':' . esc_html_x( 'キラッと', 'btn-style', 'swell' )?></div>
					<div class="__prevRow">
						<div class="swell-block-button red_ is-style-btn_shiny -size-s">
							<a class="swell-block-button__link" href="javascript:void(0)">BUTTON</a>
						</div>
						<div class="swell-block-button blue_ is-style-btn_shiny -size-s">
							<a class="swell-block-button__link" href="javascript:void(0)">BUTTON</a>
						</div>
						<div class="swell-block-button green_ is-style-btn_shiny -size-s">
							<a class="swell-block-button__link" href="javascript:void(0)">BUTTON</a>
						</div>
					</div>
				</div>
				<div class="__preview">
					<div class="__previewLabel"><?=esc_html__( 'プレビュー', 'swell' ) . ':' . esc_html_x( 'アウトライン', 'btn-style', 'swell' )?></div>
					<div class="__prevRow">
						<div class="swell-block-button red_ is-style-btn_line -size-s">
							<a class="swell-block-button__link" href="javascript:void(0)">BUTTON</a>
						</div>
						<div class="swell-block-button blue_ is-style-btn_line -size-s">
							<a class="swell-block-button__link" href="javascript:void(0)">BUTTON</a>
						</div>
						<div class="swell-block-button green_ is-style-btn_line -size-s">
							<a class="swell-block-button__link" href="javascript:void(0)">BUTTON</a>
						</div>
					</div>
				</div>
			</div>
		<?php
	}


}
