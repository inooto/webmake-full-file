<?php
namespace SWELL_THEME\Menu;

if ( ! defined( 'ABSPATH' ) ) exit;

class Tab_Custom {

	/**
	 * カスタム書式セット
	 */
	public static function custom_format_set_settings( $page_name ) {

		$section_name = 'swell_section_custom_format_set';

		// セクションの追加
		add_settings_section(
			$section_name,
			__( 'カスタム書式セット', 'swell' ),
			'',
			$page_name
		);

		// 設定項目の追加
		for ( $i = 1; $i < 3; $i++ ) {
			$label = __( 'カスタム書式セット', 'swell' ) . ' - ' . $i;
			add_settings_field(
				'custom_format_set_' . $i, // フィールドID。何にも使わない
				$label,
				[__CLASS__, 'cb_format_set' ],
				$page_name,
				$section_name,
				[
					'class'              => 'tr-custom-format-set',
					'i'                  => $i,
					// 文字色・背景色 カラーセット
					'base_colors'        => [
						[
							'name'  => __( 'メインカラー', 'swell' ),
							'slug'  => 'main',
							'color' => 'var(--color_main)',
						],
						[
							'name'  => __( 'メインカラー', 'swell' ) . '(' . _x( '薄', 'color', 'swell' ) . ')',
							'slug'  => 'main_thin',
							'color' => 'var(--color_main_thin)',
						],
						[
							'name'  => _x( 'グレー', 'color', 'swell' ),
							'slug'  => 'gray',
							'color' => 'var(--color_gray)',
						],
						[
							'name'  => _x( '白', 'color', 'swell' ),
							'slug'  => 'white',
							'color' => '#fff',
						],
						[
							'name'  => _x( '黒', 'color', 'swell' ),
							'slug'  => 'black',
							'color' => '#000',
						],
					],
					'custom_colors'      => [
						'deep-01' => __( '濃い色', 'swell' ) . '1',
						'deep-02' => __( '濃い色', 'swell' ) . '2',
						'deep-03' => __( '濃い色', 'swell' ) . '3',
						'deep-04' => __( '濃い色', 'swell' ) . '4',
						'pale-01' => __( '淡い色', 'swell' ) . '1',
						'pale-02' => __( '淡い色', 'swell' ) . '2',
						'pale-03' => __( '淡い色', 'swell' ) . '3',
						'pale-04' => __( '淡い色', 'swell' ) . '4',
					],
					// マーカー カラーセット
					'marker_colors'      => [
						'orange' => _x( 'オレンジ', 'color', 'swell' ),
						'yellow' => _x( 'イエロー', 'color', 'swell' ),
						'green'  => _x( 'グリーン', 'color', 'swell' ),
						'blue'   => _x( 'ブルー', 'color', 'swell' ),
					],
					// フォントサイズ バリエーション
					'font_sizes'         => [
						'xs' => 'XS',
						's'  => 'S',
						'l'  => 'L',
						'xl' => 'XL',
					],
				]
			);
		}
	}

	public static function cb_format_set( $args ) {
		$i  = $args['i'];
		$db = \SWELL_Theme::DB_NAME_EDITORS;

		$bold_key      = 'format_set_bold_' . $i;
		$italic_key    = 'format_set_italic_' . $i;
		$color_key     = 'format_set_color_' . $i;
		$bg_key        = 'format_set_bg_' . $i;
		$marker_key    = 'format_set_marker_' . $i;
		$font_size_key = 'format_set_font_size_' . $i;

		$bold_name      = $db . '[' . $bold_key . ']';
		$italic_name    = $db . '[' . $italic_key . ']';
		$color_name     = $db . '[' . $color_key . ']';
		$bg_name        = $db . '[' . $bg_key . ']';
		$marker_name    = $db . '[' . $marker_key . ']';
		$font_size_name = $db . '[' . $font_size_key . ']';

		// 文字色・背景色 カラーセット
		$base_colors   = $args['base_colors'];
		$custom_colors = $args['custom_colors'];
		// マーカー カラーセット
		$marker_colors = $args['marker_colors'];

		// フォントサイズ バリエーション
		$font_sizes = $args['font_sizes'];

		$editor = \SWELL_Theme::get_editor();

		// 各チェックボックスのオン/オフの状態
		$enable_color     = $editor[ $color_key ] !== '' ? 1 : 0;
		$enable_bg        = $editor[ $bg_key ] !== '' ? 1 : 0;
		$enable_marker    = $editor[ $marker_key ] !== '' ? 1 : 0;
		$enable_font_size = $editor[ $font_size_key ] !== '' ? 1 : 0;

		// プレビューテキスト用クラス
		$bg_class = 'swl-bg-color';
		if ( $editor[ $bg_key ] ) {
			if ( $editor[ $bg_key ] === 'white' || $editor[ $bg_key ] === 'black' ) {
				$bg_class .= ' has-' . $editor[ $bg_key ] . '-background-color';
			} else {
				$bg_class .= ' has-swl-' . $editor[ $bg_key ] . '-background-color';
			}
		}

		$marker_class = 'swl-marker';
		if ( $editor[ $marker_key ] ) {
			$marker_class .= ' mark_' . $editor[ $marker_key ];
		}

		$color_class = 'swl-inline-color';
		if ( $editor[ $color_key ] ) {
			if ( $editor[ $color_key ] === 'white' || $editor[ $color_key ] === 'black' ) {
				$color_class .= ' has-' . $editor[ $color_key ] . '-color';
			} else {
				$color_class .= ' has-swl-' . $editor[ $color_key ] . '-color';
			}
		}

		$font_size_class = 'swl-fz';
		if ( $editor[ $font_size_key ] ) {
			$font_size_class .= ' u-fz-' . $editor[ $font_size_key ];
		}

		$text_class = [ 'swl-txt' ];
		if ( $editor[ $bold_key ] ) {
			$text_class[] = 'u-fw-bold';
		}
		if ( $editor[ $italic_key ] ) {
			$text_class[] = 'u-fs-italic';
		}

		$text_class = implode( ' ', $text_class );
		?>
		<div class="swell-menu-set">
				<div class="__settings">
					<div class="__field -single">
						<div class="__btn">
							<input type="hidden" name="<?=esc_attr( $bold_name )?>" value="">
							<input
								type="checkbox"
								id="<?=esc_attr( $bold_key )?>"
								name="<?=esc_attr( $bold_name )?>"
								value="1"
								class="__toggle-bold"
								<?=checked( (string) $editor[ $bold_key ], '1', false )?>
							/>
							<label for="<?=esc_attr( $bold_key )?>"><?=esc_html__( '太字', 'swell' )?></label>
						</div>
						<div class="__btn">
							<input type="hidden" name="<?=esc_attr( $italic_name )?>" value="">
							<input
								type="checkbox"
								id="<?=esc_attr( $italic_key )?>"
								name="<?=esc_attr( $italic_name )?>"
								value="1"
								class="__toggle-italic"
								<?=checked( (string) $editor[ $italic_key ], '1', false )?>
							/>
							<label for="<?=esc_attr( $italic_key )?>"><?=esc_html__( '斜体', 'swell' )?></label>
						</div>
					</div>
					<div class="__field -acc" data-is-enable=<?=esc_attr( $enable_color );?>>
						<div class="__ttl">
							<input
								type="checkbox"
								id="<?=esc_attr( $color_key )?>"
								class="__toggle-color"
								<?=checked( (string) $enable_color, '1', false )?>
							/>
							<label for="<?=esc_attr( $color_key )?>"><?=esc_html__( '文字色', 'swell' )?></label>
						</div>
						<div class="__choices">
							<input type="hidden" name="<?=esc_attr( $color_name )?>" value="">
							<?php
								foreach ( $base_colors as $color ) :
								self::color_palette(
									'__color',
									$color_key,
									$color_name,
									$color['slug'],
									$color['name'],
									$color['color'],
									(string) $editor[ $color_key ]
								);
								endforeach;
								foreach ( $custom_colors as $slug => $label ) :
								$val = $editor[ 'color_' . str_replace( '-', '', $slug ) ];
								self::color_palette(
									'__color',
									$color_key,
									$color_name,
									$slug,
									$label,
									$val,
									(string) $editor[ $color_key ]
								);
								endforeach;

								self::clear_btn( '-color' );
							?>
						</div>
					</div>
					<div class="__field -acc" data-is-enable=<?=esc_attr( $enable_bg );?>>
						<div class="__ttl">
							<input
								type="checkbox"
								id="<?=esc_attr( $bg_key )?>"
								class="__toggle-bg"
								<?=checked( (string) $enable_bg, '1', false )?>
							/>
							<label for="<?=esc_attr( $bg_key )?>"><?=esc_html__( '背景色', 'swell' )?></label>
						</div>
						<div class="__choices">
							<input type="hidden" name="<?=esc_attr( $bg_name )?>" value="">
							<?php
								foreach ( $base_colors as $color ) :
								self::color_palette(
									'__bg',
									$bg_key,
									$bg_name,
									$color['slug'],
									$color['name'],
									$color['color'],
									(string) $editor[ $bg_key ]
								);
								endforeach;
								foreach ( $custom_colors as $slug => $label ) :
								$val = $editor[ 'color_' . str_replace( '-', '', $slug ) ];
								self::color_palette(
									'__bg',
									$bg_key,
									$bg_name,
									$slug,
									$label,
									$val,
									(string) $editor[ $bg_key ]
								);
								endforeach;

								self::clear_btn( '-bg' );
							?>
						</div>
					</div>
					<div class="__field -acc" data-is-enable=<?=esc_attr( $enable_marker );?>>
						<div class="__ttl">
							<input
								type="checkbox"
								id="<?=esc_attr( $marker_key )?>"
								class="__toggle-marker"
								<?=checked( (string) $enable_marker, '1', false )?>
							/>
							<label for="<?=esc_attr( $marker_key )?>"><?=esc_html_x( 'マーカー', 'format', 'swell' )?></label>
						</div>
						<div class="__choices">
							<input type="hidden" name="<?=esc_attr( $marker_name )?>" value="">
							<?php
								foreach ( $marker_colors as $slug => $label ) :
								$val = \SWELL_Theme::get_editor( 'color_mark_' . $slug );
								self::color_palette(
									'__marker',
									$marker_key,
									$marker_name,
									$slug,
									$label,
									$val,
									(string) $editor[ $marker_key ]
								);
								endforeach;

								self::clear_btn( '-marker' );
							?>
						</div>
					</div>
					<div class="__field -acc" data-is-enable=<?=esc_attr( $enable_font_size );?>>
						<div class="__ttl">
							<input
								type="checkbox"
								id="<?=esc_attr( $font_size_key )?>"
								class="__toggle-font-size"
								<?=checked( (string) $enable_font_size, '1', false )?>
							/>
							<label for="<?=esc_attr( $font_size_key )?>"><?=esc_html__( 'フォントサイズ', 'swell' )?></label>
						</div>
						<div class="__choices">
							<input type="hidden" name="<?=esc_attr( $font_size_name )?>" value="">
							<?php foreach ( $font_sizes as $slug => $name ) : ?>
								<div class="__font-size">
									<input
										type="radio"
										id="<?=esc_attr( $font_size_key . '_' . $slug )?>"
										name="<?=esc_attr( $font_size_name )?>"
										value="<?=esc_attr( $slug )?>"
										<?=checked( (string) $editor[ $font_size_key ], $slug, false )?>
									/>
									<label for="<?=esc_attr( $font_size_key . '_' . $slug )?>"><?=esc_html( $name )?></label>
							</div>
							<?php endforeach; ?>
							<?php self::clear_btn( '-fz' ); ?>
						</div>
					</div>
				</div>
				<div class="__preview" data-marker-type="<?=esc_attr( $editor['marker_type'] );?>">
					<span class="<?=esc_attr( $bg_class );?>">
						<span class="<?=esc_attr( $marker_class );?>">
							<span class="<?=esc_attr( $color_class );?>">
								<span class="<?=esc_attr( $font_size_class );?>">
									<span class="<?=esc_attr( $text_class );?>"><?=esc_html__( 'ここにテキストが入ります。', 'swell' )?></span>
								</span>
							</span>
						</span>
					</span>
					<div class="__previewLabel"><?=esc_html__( 'プレビュー', 'swell' )?></div>
				</div>
			</div>
		<?php

		if ( 2 === $i ) {
			echo '<br><small>' . esc_html__( '※ チェックが一つも入っていない場合はエディター上で表示されません', 'swell' ) . '</small>';
		}
	}

	/**
	 * カスタム書式
	 */
	public static function custom_format_settings( $page_name ) {

		$section_name = 'swell_section_custom_format';

		// セクションの追加
		add_settings_section(
			$section_name,
			__( 'カスタム書式', 'swell' ),
			'',
			$page_name
		);

		// 設定項目の追加
		for ( $i = 1; $i < 3; $i++ ) {
			$label = __( 'カスタム書式', 'swell' ) . ' - ' . $i;
			add_settings_field(
				'custom_format_' . $i, // フィールドID。何にも使わない
				$label,
				[__CLASS__, 'cb_format' ],
				$page_name,
				$section_name,
				[
					'class' => 'tr-custom-format',
					'i'     => $i,
				]
			);
		}
	}

	public static function cb_format( $args ) {
		$i    = $args['i'];
		$db   = \SWELL_Theme::DB_NAME_EDITORS;
		$key  = 'format_title_' . $i;
		$name = $db . '[' . $key . ']';
		$val  = \SWELL_Theme::get_editor( $key );
		?>
			<div class="__settings">
				<div class="__tr">
					<span><?=esc_html__( 'クラス名 : ', 'swell' )?></span><code>swl-format-<?=esc_html( $i )?></code>
				</div>
				<div class="__tr">
					<span><?=esc_html__( '表示名 : ', 'swell' )?></span><input type="text" name="<?=esc_attr( $name )?>" value="<?=esc_attr( $val )?>">
				</div>
			</div>
		<?php

		if ( 2 === $i ) {
			echo '<br><small>' . esc_html__( '※ 表示名が空の場合はエディター上で表示されません。', 'swell' ) . '</small>';
		}
	}


	/**
	 * カスタム書式用CSSエディター
	 */
	public static function custom_format_css_editor( $page_name ) {

		$section_name = 'swell_section_custom_format_css';

		// セクションの追加
		add_settings_section(
			$section_name,
			__( 'カスタム書式用CSS', 'swell' ),
			'',
			$page_name
		);

		// 設定項目の追加
		add_settings_field(
			'custom_format_css', // フィールドID。何にも使わない
			'',
			[__CLASS__, 'cb_format_css' ],
			$page_name,
			$section_name,
			[
				'class' => 'tr-custom-format-css',
			]
		);
	}

	public static function cb_format_css( $args ) {
		$key  = 'custom_format_css';
		$name = \SWELL_Theme::DB_NAME_EDITORS . '[' . $key . ']';
		$val  = \SWELL_Theme::get_editor( $key );
		?>
			<p class="description u-mb-10"><?=esc_html__( 'ここに書いたCSSは、フロント側とエディター側の両方で読み込まれます。', 'swell' )?></p>
			<div class="__settings -codemirror">
				<textarea id="<?=esc_attr( $key )?>" cols="60" rows="30" name="<?=esc_attr( $name )?>" id="<?=esc_attr( $name )?>" class="swell-css-editor" ><?php echo esc_textarea( $val ); ?></textarea>
			</div>
		<?php
	}


	/**
	 * カラーパレット出力
	 */
	public static function color_palette( $class, $id_key, $name, $slug, $label, $val, $saved_val ) {
		?>
		<label for="<?=esc_attr( $id_key . '_' . $slug )?>" class="__label">
			<input
				type="radio"
				id="<?=esc_attr( $id_key . '_' . $slug )?>"
				name="<?=esc_attr( $name )?>"
				value="<?=esc_attr( $slug );?>"
				class="<?=esc_attr( $class )?> u-none"
				<?=checked( $saved_val, $slug, false )?>
			/>
			<span style="background:<?=esc_attr( $val );?>"><?=esc_html( $label )?></span>
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="#ffffff" role="img" aria-hidden="true" focusable="false"><path d="M18.3 5.6L9.9 16.9l-4.6-3.4-.9 1.2 5.8 4.3 9.3-12.6z"></path></svg>
		</label>
		<?php
	}


	/**
	 * クリアボタン
	 */
	public static function clear_btn( $class ) {
		?>
			<button class="__clear <?=esc_attr( $class )?>" type="button">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="12" height="12" role="img" aria-hidden="true" focusable="false"><path d="M13 11.8l6.1-6.3-1-1-6.1 6.2-6.1-6.2-1 1 6.1 6.3-6.5 6.7 1 1 6.5-6.6 6.5 6.6 1-1z"></path></svg>
				<?=esc_html__( 'クリア', 'swell' )?>
			</button>
		<?php
	}
}
