<?php
namespace SWELL_THEME\Menu;

if ( ! defined( 'ABSPATH' ) ) exit;

class Tab_Others {


	/**
	 * ブログカードの設定
	 */
	public static function blogcard_settings( $page_name ) {
		$section_name = 'swell_section_blogcard';

		// セクションの追加
		add_settings_section(
			$section_name,
			__( 'ブログカード', 'swell' ),
			'',
			$page_name
		);

		$cb = [__CLASS__, 'callback_for_blogcard' ];
		add_settings_field(
			'blocg_card_in', // フィールドID。何にも使わない
			__( 'ブログカード（内部）', 'swell' ),
			$cb,
			$page_name,
			$section_name,
			[
				'key'   => 'blog_card_type',
				'type'  => 'internal',
				'class' => 'tr-design',
			]
		);

		add_settings_field(
			'blocg_card_ex', // フィールドID。何にも使わない
			__( 'ブログカード（外部）', 'swell' ),
			$cb,
			$page_name,
			$section_name,
			[
				'key'   => 'blog_card_type_ex',
				'type'  => 'external',
				'class' => 'tr-design',
			]
		);
	}


	/**
	 * ブログカード設定用のコールバック
	 */
	public static function callback_for_blogcard( $args ) {

		$key = $args['key'];

		// 使用するデータベース
		$db = \SWELL_Theme::DB_NAME_EDITORS;

		$val  = \SWELL_Theme::get_editor( $key );
		$name = \SWELL_Theme::DB_NAME_EDITORS . '[' . $key . ']';

		$options = [
			'type1' => __( 'タイプ1', 'swell' ),
			'type2' => __( 'タイプ2', 'swell' ),
			'type3' => __( 'タイプ3', 'swell' ),
		];
		?>
			<div class="swell-menu-blogcard">
				<div class="__settings">
					<select name="<?=esc_attr( $name )?>" class="__blogcard">
						<?php
						foreach ( $options as $key => $text ) :
							if ( selected( $key, $val, false ) ) $isCustomColor = false;
							echo '<option value="' . esc_attr( $key ) . '"' . selected( $key, $val, false ) . '>' . esc_html( $text ) . '</option>';
						endforeach;
						?>
					</select>
				</div>
				<div class="__preview">
					<div class="__previewLabel"><?=esc_html__( 'プレビュー', 'swell' )?></div>
					<div class="swell-block-postLink">
						<div class="p-blogCard -<?=esc_attr( $args['type'] )?>" data-type="<?=esc_attr( $val )?>">
							<div class="p-blogCard__inner">
								<span class="p-blogCard__caption">
									<?php $args['type'] === 'internal' ? printf( esc_html__( 'あわせて読みたい', 'swell' ) ) : printf( esc_html__( 'サイトのタイトル', 'swell' ) ); ?>
								</span>
								<div class="p-blogCard__thumb c-postThumb">
									<figure class="c-postThumb__figure">
										<span class="__thumb"><?=esc_html__( 'サムネイル画像', 'swell' )?></span>
									</figure>
								</div>
								<div class="p-blogCard__body">
									<span class="p-blogCard__title"><?=esc_html__( '記事のタイトル', 'swell' )?></span>
									<span class="p-blogCard__excerpt"><?=esc_html__( '記事の抜粋文がここに入ります。記事の抜粋文がここに入ります。記事の抜粋文がここに入ります。', 'swell' )?></span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php
	}


	/**
	 * その他
	 */
	public static function blockquote_settings( $page_name ) {
		$section_name = 'swell_section_blockquote';

		// セクションの追加
		add_settings_section(
			$section_name,
			__( '引用', 'swell' ),
			'', // function() {echo '<p>' . esc_html__( '段落ブロック・グループブロックで利用できるボックススタイルのデザインを選択できます。', 'swell' ) . '</p>';},
			$page_name
		);

		add_settings_field(
			'blockquote_style', // フィールドID。何にも使わない
			__( 'スタイル', 'swell' ),
			[__CLASS__, 'callback_for_blockquote' ],
			$page_name,
			$section_name,
			[
				'item'    => 'blockquote',
				'key'     => 'blockquote_type',
				'class'   => 'tr-design',
				'choices' => [
					'simple'    => __( 'シンプル', 'swell' ),
					'quotation' => __( 'クオーテーションマーク表示', 'swell' ),
				],
			]
		);
	}


	/**
	 * その他のコールバック
	 */
	public static function callback_for_blockquote( $args ) {

		$key = $args['key'];

		// 使用するデータベース
		$db = \SWELL_Theme::DB_NAME_EDITORS;

		$val  = \SWELL_Theme::get_editor( $key );
		$name = \SWELL_Theme::DB_NAME_EDITORS . '[' . $key . ']';

		$options = $args['choices'];

		$item = $args['item'];
		?>
			<div class="swell-menu-<?=esc_attr( $item )?>">
				<div class="__settings">
					<select name="<?=esc_attr( $name )?>" class="__<?=esc_attr( $item )?>">
						<?php
						foreach ( $options as $key => $text ) :
							if ( selected( $key, $val, false ) ) $isCustomColor = false;
							echo '<option value="' . esc_attr( $key ) . '"' . selected( $key, $val, false ) . '>' . esc_html( $text ) . '</option>';
						endforeach;
						?>
					</select>
				</div>
				<div class="__preview">
					<div class="__previewLabel"><?=esc_html__( 'プレビュー', 'swell' )?></div>
						<blockquote class="wp-block-quote __blockquote" data-type="<?=esc_attr( $val )?>">
							<p><?=esc_html__( '引用するテキストがここに入ります。', 'swell' )?></p>
							<cite><?=esc_html__( '引用元', 'swell' )?></cite>
						</blockquote>
				</div>
			</div>
		<?php
	}

}
