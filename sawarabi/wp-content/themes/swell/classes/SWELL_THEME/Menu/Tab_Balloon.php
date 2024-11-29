<?php
namespace SWELL_THEME\Menu;

if ( ! defined( 'ABSPATH' ) ) exit;

class Tab_Balloon {

	/**
	 * ふきだしカラー
	 */
	public static function balloon_settings( $page_name ) {

		$section_name = 'swell_section_balloon_color';

		// セクションの追加
		add_settings_section(
			$section_name,
			__( 'ふきだしカラー', 'swell' ),
			'',
			$page_name
		);

		$colors = [
			'gray'   => _x( 'グレー', 'color', 'swell' ),
			'green'  => _x( 'グリーン', 'color', 'swell' ),
			'blue'   => _x( 'ブルー', 'color', 'swell' ),
			'red'    => _x( 'レッド', 'color', 'swell' ),
			'yellow' => _x( 'イエロー', 'color', 'swell' ),
		];

		// 設定項目の追加
		foreach ( $colors as $col => $label ) {
			add_settings_field(
				'color_bln_' . $col, // フィールドID。何にも使わない
				__( 'カラーセット', 'swell' ) . ': ' . $label,
				[__CLASS__, 'callback' ],
				$page_name,
				$section_name,
				[
					'color' => $col,
					'class' => 'tr-balloon -' . $col,
				]
			);
		}
	}


	/**
	 * ふきだしカラー設定用の専用コールバック
	 */
	public static function callback( $args ) {

		$color     = $args['color'];
		$bg_id     = 'color_bln_' . $color . '_bg';
		$border_id = 'color_bln_' . $color . '_border';

		// 使用するデータベース
		$db = \SWELL_Theme::DB_NAME_EDITORS;

		// 現在の値
		$val_bg     = \SWELL_Theme::get_editor( $bg_id );
		$val_border = \SWELL_Theme::get_editor( $border_id );

		$dflt_bg     = \SWELL_Theme::get_default_editor( $bg_id );
		$dflt_border = \SWELL_Theme::get_default_editor( $border_id );

		// フォーム要素のname属性に渡す値。
		$name_bg     = \SWELL_Theme::DB_NAME_EDITORS . '[' . $bg_id . ']';
		$name_border = \SWELL_Theme::DB_NAME_EDITORS . '[' . $border_id . ']';

		?>
		<div class="swell-menu-balloon">

			<!-- 設定フィールド -->
			<div class="__settings">
				<div class="swell-menu-balloon__item">
					<span class="__label"><?=esc_html__( '背景', 'swell' )?></span>
					<input type="text" class="colorpicker -bg"
						id="<?=esc_attr( $bg_id )?>"
						name="<?=esc_attr( $name_bg )?>"
						value="<?=esc_attr( $val_bg )?>"
						data-default-color="<?=esc_attr( $dflt_bg )?>"
					/>
				</div>
				<div class="swell-menu-balloon__item">
					<span class="__label"><?=esc_html__( 'ボーダー', 'swell' )?></span>
					<input type="text" class="colorpicker -border"
						id="<?=esc_attr( $border_id )?>"
						name="<?=esc_attr( $name_border )?>"
						value="<?=esc_attr( $val_border )?>"
						data-default-color="<?=esc_attr( $dflt_border )?>"
					/>
				</div>
			</div>

			<!-- プレビュー -->
			<div class="__preview">
				<?php echo do_shortcode( '[ふきだし col="' . $color . '" border="on"]' . __( 'ここにコンテンツが入ります', 'swell' ) . '[/ふきだし]' ); ?>
				<div class="__previewLabel"><?=esc_html__( 'プレビュー', 'swell' )?></div>
			</div>
		</div>
	<?php

	}
}
