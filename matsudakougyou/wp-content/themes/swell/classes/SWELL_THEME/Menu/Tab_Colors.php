<?php
namespace SWELL_THEME\Menu;

use SWELL as SWELL;

if ( ! defined( 'ABSPATH' ) ) exit;

class Tab_Colors {

	/**
	 * カラーパレットの設定
	 */
	public static function palette_settings( $page_name ) {
		$section_name = 'swell_section_palette_color';

		// セクションの追加
		add_settings_section(
			$section_name,
			__( 'カラーパレット設定', 'swell' ),
			'',
			$page_name
		);

		add_settings_field(
			'color_palette_dark', // フィールドID。何にも使わない
			__( 'カラーパレット', 'swell' ) . '【' . _x( '濃', 'color', 'swell' ) . '】',
			[__CLASS__, 'callback_for_palette' ],
			$page_name,
			$section_name,
			[
				'keys' => [
					'deep01' => __( '濃い色', 'swell' ) . '1',
					'deep02' => __( '濃い色', 'swell' ) . '2',
					'deep03' => __( '濃い色', 'swell' ) . '3',
					'deep04' => __( '濃い色', 'swell' ) . '4',
				],
			]
		);
		add_settings_field(
			'color_palette_thin', // フィールドID。何にも使わない
			__( 'カラーパレット', 'swell' ) . '【' . _x( '淡', 'color', 'swell' ) . '】',
			[__CLASS__, 'callback_for_palette' ],
			$page_name,
			$section_name,
			[
				'keys' => [
					'pale01' => __( '淡い色', 'swell' ) . '1',
					'pale02' => __( '淡い色', 'swell' ) . '2',
					'pale03' => __( '淡い色', 'swell' ) . '3',
					'pale04' => __( '淡い色', 'swell' ) . '4',
				],
			]
		);
	}


	/**
	 * カラーパレット設定用の専用コールバック
	 */
	public static function callback_for_palette( $args ) {

		$keys = $args['keys'];

		// 使用するデータベース
		$db = \SWELL_Theme::DB_NAME_EDITORS;

		foreach ( $keys as $key => $label ) :
			$key = 'color_' . $key;

			// 現在の値
			$val = \SWELL_Theme::get_editor( $key );
			// デフォルト値
			$dflt = \SWELL_Theme::get_default_editor( $key );
			// フォーム要素のname属性に渡す値。
			$name = \SWELL_Theme::DB_NAME_EDITORS . '[' . $key . ']';
			?>
				<div class="swl-menu -color-palette">
					<span class="__label"><?=esc_attr( $label )?></span>
					<input type="text" class="colorpicker"
						id="<?=esc_attr( $key )?>"
						name="<?=esc_attr( $name )?>"
						value="<?=esc_attr( $val )?>"
						data-default-color="<?=esc_attr( $dflt )?>"
					/>
				</div>
			<?php
		endforeach;
	}


	/**
	 * リスト
	 */
	public static function list_settings( $page_name ) {
		$section_name = 'swell_section_list_color';

		// セクションの追加
		add_settings_section(
			$section_name,
			__( 'リスト設定', 'swell' ),
			'',
			$page_name
		);

		$icons = [
			'check'    => _x( 'チェック', 'list-style', 'swell' ),
			'num'      => _x( '丸数字', 'list-style', 'swell' ),
			'good'     => _x( 'マル', 'list-style', 'swell' ),
			'triangle' => _x( '三角', 'list-style', 'swell' ),
			'bad'      => _x( 'バツ', 'list-style', 'swell' ),
		];
		foreach ( $icons as $key => $label ) {
			add_settings_field(
				'color_list_' . $key,
				$label,
				[__CLASS__, 'callback_for_list' ],
				$page_name,
				$section_name,
				[
					'class' => 'tr-list',
					'key'   => $key,
				]
			);
		}
	}


	/**
	 * リスト用コールバック
	 */
	public static function callback_for_list( $args ) {

		// 使用するデータベース
		$db = \SWELL_Theme::DB_NAME_EDITORS;

		// key
		$key       = $args['key'];
		$color_key = 'color_list_' . $key;

		// 現在の値
		$color_val = \SWELL_Theme::get_editor( $color_key );

		// デフォルト値
		$dflt_color = \SWELL_Theme::get_default_editor( $color_key );

		// フォーム要素のname属性に渡す値。
		$name = \SWELL_Theme::DB_NAME_EDITORS . '[' . $color_key . ']';

		$tag   = $key === 'num' ? 'ol' : 'ul';
		$class = $key === 'num' ? 'is-style-num_circle' : 'is-style-' . $key . '_list';

		$preview_list = '<' . $tag . ' class="' . esc_attr( $class ) . '"><li>リスト</li><li>リスト</li></' . $tag . '>';
		?>
			<div class="swl-menu -flex -list">
				<div class="__settings">
					<input type="text" class="colorpicker __list_color"
						id="<?=esc_attr( $color_key )?>"
						name="<?=esc_attr( $name )?>"
						value="<?=esc_attr( $color_val )?>"
						data-default-color="<?=esc_attr( $dflt_color )?>"
						data-key="<?=esc_attr( $color_key )?>"
					/>
					<?php if ( $key === 'check' || $key === 'num' ) : ?>
						<p class="__description" style="max-width:200px">※ <?=esc_html__( '色の指定がない場合は、メインカラーが適用されます。', 'swell' )?></p>
					<?php endif; ?>
				</div>
				<div class="__preview">
					<?php echo $preview_list; // phpcs:ignore WordPress.Security.EscapeOutput ?>
					<div class="__previewLabel"><?=esc_html__( 'プレビュー', 'swell' )?></div>
				</div>
			</div>
		<?php
	}


	/**
	 * キャプションブロック
	 */
	public static function capblock_settings( $page_name ) {
		$section_name = 'swell_section_capblock_color';

		// セクションの追加
		add_settings_section(
			$section_name,
			__( 'キャプションブロック設定', 'swell' ),
			'',
			$page_name
		);

		$sets = ['01', '02', '03' ];
		foreach ( $sets as $set ) {
			add_settings_field(
				'color_capblock_' . $set,
				__( 'カラーセット', 'swell' ) . ': ' . $set,
				[__CLASS__, 'callback_for_capblock' ],
				$page_name,
				$section_name,
				[
					'class' => 'tr-capbox',
					'key'   => 'cap_' . $set,
				]
			);
		}
	}


	/**
	 * キャプションブロック用コールバック
	 */
	public static function callback_for_capblock( $args ) {

		// 使用するデータベース
		$db = \SWELL_Theme::DB_NAME_EDITORS;

		// key
		$key       = $args['key'];
		$key_dark  = 'color_' . $key;
		$key_light = 'color_' . $key . '_light';

		// 現在の値
		$val_dark  = \SWELL_Theme::get_editor( $key_dark );
		$val_light = \SWELL_Theme::get_editor( $key_light );

		// デフォルト値
		$dflt_dark  = \SWELL_Theme::get_default_editor( $key_dark );
		$dflt_light = \SWELL_Theme::get_default_editor( $key_light );

		// フォーム要素のname属性に渡す値。
		$name_dark  = \SWELL_Theme::DB_NAME_EDITORS . '[' . $key_dark . ']';
		$name_light = \SWELL_Theme::DB_NAME_EDITORS . '[' . $key_light . ']';
		?>
			<div class="swl-menu -flex -capbox">
				<div class="__settings">
					<input type="text" class="colorpicker __dark"
						id="<?=esc_attr( $key_dark )?>"
						name="<?=esc_attr( $name_dark )?>"
						value="<?=esc_attr( $val_dark )?>"
						data-default-color="<?=esc_attr( $dflt_dark )?>"
					/>
					<input type="text" class="colorpicker __light"
						id="<?=esc_attr( $key_light )?>"
						name="<?=esc_attr( $name_light )?>"
						value="<?=esc_attr( $val_light )?>"
						data-default-color="<?=esc_attr( $dflt_light )?>"
					/>
				</div>
				<div class="__preview">
					<div class="swell-block-capbox cap_box" data-colset="<?=esc_attr( str_replace( 'cap_0', 'col', $key ) )?>">
						<div class="cap_box_ttl"><?=esc_html__( 'キャプション', 'swell' )?></div>
						<div class="cap_box_content">
							<p><?=esc_html__( 'ここにコンテンツが入ります', 'swell' )?></p>
						</div>
					</div>
					<div class="__previewLabel"><?=esc_html__( 'プレビュー', 'swell' )?></div>
				</div>
			</div>
		<?php
	}


	/**
	 * FAQ
	 */
	public static function faq_settings( $page_name ) {
		$section_name = 'swell_section_faq_color';

		// セクションの追加
		add_settings_section(
			$section_name,
			__( 'Q&A設定', 'swell' ),
			'',
			$page_name
		);

		add_settings_field(
			'color_faq',
			__( 'カラー', 'swell' ),
			[__CLASS__, 'callback_for_faq' ],
			$page_name,
			$section_name,
			[
				'class' => 'tr-faq',
			]
		);
	}


	/**
	 * FAQ用コールバック
	 */
	public static function callback_for_faq( $args ) {

		// 使用するデータベース
		$db = \SWELL_Theme::DB_NAME_EDITORS;

		// key
		// $key = $args['key'];
		$color_key_q = 'color_faq_q';
		$color_key_a = 'color_faq_a';

		// 現在の値
		$color_val_q = \SWELL_Theme::get_editor( $color_key_q );
		$color_val_a = \SWELL_Theme::get_editor( $color_key_a );

		// デフォルト値
		$dflt_color_q = \SWELL_Theme::get_default_editor( $color_key_q );
		$dflt_color_a = \SWELL_Theme::get_default_editor( $color_key_a );

		// フォーム要素のname属性に渡す値。
		$name_q = \SWELL_Theme::DB_NAME_EDITORS . '[' . $color_key_q . ']';
		$name_a = \SWELL_Theme::DB_NAME_EDITORS . '[' . $color_key_a . ']';

		?>
			<div class="swl-menu -flex -faq">
				<div class="__settings">
					<div class="__q">
						<label for="<?=esc_attr( $color_key_q )?>">Q : </label>
						<input type="text" class="colorpicker __faq_color"
							id="<?=esc_attr( $color_key_q )?>"
							name="<?=esc_attr( $name_q )?>"
							value="<?=esc_attr( $color_val_q )?>"
							data-default-color="<?=esc_attr( $dflt_color_q )?>"
							data-key="<?=esc_attr( $color_key_q )?>"
						/>
					</div>
					<div class="__a">
						<label for="<?=esc_attr( $color_key_a )?>">A : </label>
						<input type="text" class="colorpicker __faq_color"
							id="<?=esc_attr( $color_key_a )?>"
							name="<?=esc_attr( $name_a )?>"
							value="<?=esc_attr( $color_val_a )?>"
							data-default-color="<?=esc_attr( $dflt_color_a )?>"
							data-key="<?=esc_attr( $color_key_a )?>"
						/>
					</div>
				</div>
				<div class="__preview">
					<div class="swell-block-faq" data-q="fill-custom" data-a="fill-custom">
						<div class="swell-block-faq__item">
							<dt class="faq_q"><?=esc_html__( '質問', 'swell' )?></dt>
							<dd class="faq_a"><p><?=esc_html__( '回答', 'swell' )?></p></dd>
						</div>
					</div>
					<div class="swell-block-faq" data-q="col-custom" data-a="col-custom">
						<div class="swell-block-faq__item">
							<dt class="faq_q"><?=esc_html__( '質問', 'swell' )?></dt>
							<dd class="faq_a"><p><?=esc_html__( '回答', 'swell' )?></p></dd>
						</div>
					</div>
					<div class="__previewLabel"><?=esc_html__( 'プレビュー', 'swell' )?></div>
				</div>
			</div>
		<?php
	}


	/**
	 * テーブル
	 */
	public static function table_settings( $page_name ) {
		$section_name = 'swell_section_table';

		// セクションの追加
		add_settings_section(
			$section_name,
			__( 'テーブル設定', 'swell' ),
			'',
			$page_name
		);

		add_settings_field(
			'color_cell_icon',
			__( 'アイコンカラー', 'swell' ),
			[__CLASS__, 'callback_for_cell_icon' ],
			$page_name,
			$section_name,
			[
				'class' => 'tr-cell_icon',
			]
		);
	}


	/**
	 * テーブル用コールバック
	 */
	public static function callback_for_cell_icon( $args ) {

		// 使用するデータベース
		$db = \SWELL_Theme::DB_NAME_EDITORS;

	?>
		<div class="swl-menu -flex -cell">
			<div class="__settings">
			<?php
				$icons = [
					'doubleCircle'         => _x( '二重丸', 'table-icon', 'swell' ),
					'circle'               => _x( '丸', 'table-icon', 'swell' ),
					'triangle'             => _x( '三角', 'table-icon', 'swell' ),
					'close'                => _x( 'バツ', 'table-icon', 'swell' ),
					'hatena'               => _x( 'はてな', 'table-icon', 'swell' ),
					'check'                => _x( 'チェック', 'table-icon', 'swell' ),
					'line'                 => _x( 'ライン', 'table-icon', 'swell' ),
				];
				foreach ( $icons as $key => $label ) {
					$color_key = 'color_cell_icon_' . $key;

					// 現在の値
					$color_val = \SWELL_Theme::get_editor( $color_key );

					// デフォルト値
					$dflt_color = \SWELL_Theme::get_default_editor( $color_key );

					// フォーム要素のname属性に渡す値。
					$name = \SWELL_Theme::DB_NAME_EDITORS . '[' . $color_key . ']';

					?>
					<div class="__row">
						<label for="<?=esc_attr( $color_key )?>"><?=esc_html( $label )?> : </label>
						<input type="text" class="colorpicker __cellIcon"
							id="<?=esc_attr( $color_key )?>"
							name="<?=esc_attr( $name )?>"
							value="<?=esc_attr( $color_val )?>"
							data-default-color="<?=esc_attr( $dflt_color )?>"
							data-target="<?=esc_attr( $key )?>"
						/>
					</div>
					<?php
				}
			?>
			</div>
			<div class="__preview">
				<figure class="wp-block-table" style="margin:0 auto">
					<table>
						<tbody>
							<tr>
								<td data-has-cell-bg="1" data-has-cell-icon="l-bg">
									<span data-icon="doubleCircle" data-icon-size="l" data-icon-type="obj" aria-hidden="true" class="swl-cell-bg">&nbsp;</span>
								</td>
								<td data-has-cell-bg="1" data-has-cell-icon="l-bg">
									<span data-icon="circle" data-icon-size="l" data-icon-type="obj" aria-hidden="true" class="swl-cell-bg">&nbsp;</span>
								</td>
								<td data-has-cell-bg="1" data-has-cell-icon="l-bg">
									<span data-icon="triangle" data-icon-size="l" data-icon-type="obj" aria-hidden="true" class="swl-cell-bg">&nbsp;</span>
								</td>
								<td data-has-cell-bg="1" data-has-cell-icon="l-bg">
									<span data-icon="close" data-icon-size="l" data-icon-type="obj" aria-hidden="true" class="swl-cell-bg">&nbsp;</span>
								</td>
							</tr>
							<tr>
								<td data-has-cell-bg="1" data-has-cell-icon="l-bg">
									<span data-icon="hatena" data-icon-size="l" data-icon-type="obj" aria-hidden="true" class="swl-cell-bg">&nbsp;</span>
								</td>
								<td data-has-cell-bg="1" data-has-cell-icon="l-bg">
									<span data-icon="check" data-icon-size="l" data-icon-type="obj" aria-hidden="true" class="swl-cell-bg">&nbsp;</span>
								</td>
								<td data-has-cell-bg="1" data-has-cell-icon="l-bg">
									<span data-icon="line" data-icon-size="l" data-icon-type="obj" aria-hidden="true" class="swl-cell-bg">&nbsp;</span>
								</td>
								<td></td>
							</tr>
						</tbody>
				</table>
				</figure>

				<div class="__previewLabel"><?=esc_html__( 'プレビュー', 'swell' )?></div>
			</div>
		</div>
	<?php
	}
}
