<?php
namespace SWELL_THEME\Menu;

if ( ! defined( 'ABSPATH' ) ) exit;

class Tab_Iconbox {

	/**
	 * アイコンボックス設定
	 */
	public static function small_settings( $page_name ) {
		$section_name = 'swell_section_iconbox_small';

		// セクションの追加
		add_settings_section(
			$section_name,
			__( 'アイコンボックス', 'swell' ) . __( '（小）', 'swell' ),
			'',
			$page_name
		);

		add_settings_field(
			'iconbox_small_style',
			__( 'スタイル', 'swell' ),
			[__CLASS__, 'callback_for_iconbox_type' ],
			$page_name,
			$section_name,
			[
				'key'     => 'iconbox_s_type',
				'type'    => 'small',
				'class'   => 'tr-iconbox',
				'choices' => [
					'fill-flat'   => _x( '塗り（フラット）', 'box-style', 'swell' ),
					'fill-solid'  => _x( '塗り（浮き出し）', 'box-style', 'swell' ),
					'border-flat' => _x( 'ボーダー', 'box-style', 'swell' ),
				],
			]
		);

		$icons = [
			'good'     => _x( 'グッド', 'box-style', 'swell' ),
			'bad'      => _x( 'バッド', 'box-style', 'swell' ),
			'info'     => _x( 'インフォ', 'box-style', 'swell' ),
			'announce' => _x( 'アナウンス', 'box-style', 'swell' ),
			'pen'      => _x( 'ペン', 'box-style', 'swell' ),
			'book'     => _x( '本', 'box-style', 'swell' ),
		];
		foreach ( $icons as $key => $label ) {
			add_settings_field(
				'color_iconbox_small_' . $key,
				$label,
				[__CLASS__, 'callback_for_iconbox_small_color' ],
				$page_name,
				$section_name,
				[
					'class'     => 'tr-iconbox',
					'icon_name' => $key,
					'type'      => 'small',
				]
			);
		}
	}


	/**
	 * アイコンボックスの設定
	 */
	public static function big_settings( $page_name ) {
		$section_name = 'swell_section_iconbox_big';

		// セクションの追加
		add_settings_section(
			$section_name,
			__( 'アイコンボックス', 'swell' ) . __( '（大）', 'swell' ),
			'',
			$page_name
		);

		add_settings_field(
			'iconbox_big_style',
			__( 'スタイル', 'swell' ),
			[__CLASS__, 'callback_for_iconbox_type' ],
			$page_name,
			$section_name,
			[
				'key'     => 'iconbox_type',
				'type'    => 'big',
				'class'   => 'tr-iconbox',
				'choices' => [
					'flat'   => _x( 'フラット', 'box-style', 'swell' ),
					'solid'  => _x( '立体', 'box-style', 'swell' ),
				],
			]
		);

		$icons = [
			'point'   => _x( 'ポイント', 'box-style', 'swell' ),
			'check'   => _x( 'チェック', 'box-style', 'swell' ),
			'batsu'   => _x( 'バツ', 'box-style', 'swell' ),
			'hatena'  => _x( 'はてな', 'box-style', 'swell' ),
			'caution' => _x( 'アラート', 'box-style', 'swell' ),
			'memo'    => _x( 'メモ', 'box-style', 'swell' ),
		];
		foreach ( $icons as $key => $label ) {
			add_settings_field(
				'color_iconbox_big_' . $key,
				$label,
				[__CLASS__, 'callback_for_iconbox_big_color' ],
				$page_name,
				$section_name,
				[
					'class'     => 'tr-iconbox',
					'icon_name' => $key,
					'type'      => 'big',
				]
			);
		}
	}


	/**
	 * アイコンボックス設定用のコールバック
	 */
	public static function callback_for_iconbox_type( $args ) {

		$key = $args['key'];

		// 使用するデータベース
		$db = \SWELL_Theme::DB_NAME_EDITORS;

		$val  = \SWELL_Theme::get_editor( $key );
		$name = \SWELL_Theme::DB_NAME_EDITORS . '[' . $key . ']';

		$options = $args['choices'];

		$type = $args['type'];
		?>
			<div class="swell-menu-iconbox">
				<div class="__settings">
					<select name="<?=esc_attr( $name )?>" class="__icon_<?=esc_attr( $type )?>_type">
						<?php
						foreach ( $options as $key => $text ) :
							$slected                       = selected( $key, $val, false );
							if ( $slected ) $isCustomColor = false;
							echo '<option value="' . esc_attr( $key ) . '"' . esc_attr( $slected ) . '>' . esc_html( $text ) . '</option>';
						endforeach;
						?>
					</select>
				</div>
			</div>
		<?php
	}


	/**
	 * アイコンボックス（小）設定用の専用コールバック
	 */
	public static function callback_for_iconbox_small_color( $args ) {

		// 使用するデータベース
		$db = \SWELL_Theme::DB_NAME_EDITORS;

		// key
		$icon_name      = $args['icon_name'];
		$color_key_icon = 'color_icon_' . $icon_name;
		$color_key_bg   = 'color_icon_' . $icon_name . '_bg';

		// 現在の値
		$color_val_icon = \SWELL_Theme::get_editor( $color_key_icon );
		$color_val_bg   = \SWELL_Theme::get_editor( $color_key_bg );

		// デフォルト値
		$dflt_col_icon = \SWELL_Theme::get_default_editor( $color_key_icon );
		$dflt_col_bg   = \SWELL_Theme::get_default_editor( $color_key_bg );

		// フォーム要素のname属性に渡す値。
		$name_icon = \SWELL_Theme::DB_NAME_EDITORS . '[' . $color_key_icon . ']';
		$name_bg   = \SWELL_Theme::DB_NAME_EDITORS . '[' . $color_key_bg . ']';

		$iconbox_class = ( $args['type'] === 'small' ) ? 'is-style-icon_' . $icon_name : 'is-style-big_icon_' . $icon_name;
		?>
			<div class="swell-menu-iconbox">
				<div class="__settings">
					<input type="text" class="colorpicker __icon_color"
						id="<?=esc_attr( $color_key_icon )?>"
						name="<?=esc_attr( $name_icon )?>"
						value="<?=esc_attr( $color_val_icon )?>"
						data-default-color="<?=esc_attr( $dflt_col_icon )?>"
						data-key="<?=esc_attr( $color_key_icon )?>"
					/>
					<input type="text" class="colorpicker __icon_color"
						id="<?=esc_attr( $color_key_bg )?>"
						name="<?=esc_attr( $name_bg )?>"
						value="<?=esc_attr( $color_val_bg )?>"
						data-default-color="<?=esc_attr( $dflt_col_bg )?>"
						data-key="<?=esc_attr( $color_key_bg )?>"
					/>
				</div>
				<div class="__preview">
					<div class="<?=esc_attr( $iconbox_class )?> __iconbox-small">
						<p><?=esc_html__( 'ここにコンテンツが入ります', 'swell' )?></p>
					</div>
					<div class="__previewLabel"><?=esc_html__( 'プレビュー', 'swell' )?></div>
				</div>
			</div>
		<?php
	}


	/**
	 * アイコンボックス（大）設定用の専用コールバック
	 */
	public static function callback_for_iconbox_big_color( $args ) {

		// 使用するデータベース
		$db = \SWELL_Theme::DB_NAME_EDITORS;

		// key
		$icon_name      = $args['icon_name'];
		$color_key_icon = 'color_icon_' . $icon_name;

		// 現在の値
		$color_val_icon = \SWELL_Theme::get_editor( $color_key_icon );
		// デフォルト値
		$dflt_col_icon = \SWELL_Theme::get_default_editor( $color_key_icon );

		// フォーム要素のname属性に渡す値。
		$name_dark = \SWELL_Theme::DB_NAME_EDITORS . '[' . $color_key_icon . ']';

		$iconbox_class = ( $args['type'] === 'small' ) ? 'is-style-icon_' . $icon_name : 'is-style-big_icon_' . $icon_name;
		?>
			<div class="swell-menu-iconbox">
				<div class="__settings">
					<input type="text" class="colorpicker __icon_color"
						id="<?=esc_attr( $color_key_icon )?>"
						name="<?=esc_attr( $name_dark )?>"
						value="<?=esc_attr( $color_val_icon )?>"
						data-default-color="<?=esc_attr( $dflt_col_icon )?>"
						data-key="<?=esc_attr( $color_key_icon )?>"
					/>
				</div>
				<div class="__preview">
					<div class="<?=esc_attr( $iconbox_class )?> __iconbox-big">
						<p><?=esc_html__( 'ここにコンテンツが入ります', 'swell' )?></p>
					</div>
					<div class="__previewLabel"><?=esc_html__( 'プレビュー', 'swell' )?></div>
				</div>
			</div>
		<?php
	}
}
