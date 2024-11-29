<?php
namespace SWELL_Theme;

use \SWELL_THEME\Parts\Setting_Field as Field;

if ( ! defined( 'ABSPATH' ) ) exit;

// see : https://developers.google.com/search/docs/advanced/structured-data/article?hl=en#author-bp
// Person: https://schema.org/Person
// Organization: https://schema.org/Person

class Meta_User {

	public static $user_metas   = [];
	public static $schema_metas = [];


	/**
	 * コンストラクタ
	 */
	public function __construct() {

		add_action( 'init', [ __CLASS__, 'set_user_meta_list' ] );

		add_action( 'show_user_profile', [ __CLASS__, 'add_user_meta' ], 1 );
		if ( current_user_can( 'administrator' ) ) {
			add_action( 'edit_user_profile', [ __CLASS__, 'add_user_meta' ], 1 ); // 他のユーザーのプロフィール編集ページにも表示
		}

		add_action( 'profile_update', [ __CLASS__, 'hook_profile_update' ], 10, 2 );
	}

	/**
	 * ユーザーメタ追加
	 */
	public static function set_user_meta_list() {
		self::$user_metas = [
			'position'      => [
				'label'    => __( '役職・肩書き', 'swell' ),
				'type'     => 'text',
			],
			'site2'         => [
				'label'    => __( 'サイト2', 'swell' ),
				'type'     => 'url',
			],
			'facebook_url'  => [
				'label'    => __( 'Facebook URL', 'swell' ),
				'type'     => 'url',
			],
			'twitter_url'   => [
				'label'    => __( 'Twitter URL', 'swell' ),
				'type'     => 'url',
			],
			'instagram_url' => [
				'label'    => __( 'Instagram URL', 'swell' ),
				'type'     => 'url',
			],
			'tiktok_url'    => [
				'label'    => __( 'TikTok URL', 'swell' ),
				'type'     => 'url',
			],
			'room_url'      => [
				'label'    => __( '楽天ROOM URL', 'swell' ),
				'type'     => 'url',
			],
			'pinterest_url' => [
				'label'    => __( 'Pinterest URL', 'swell' ),
				'type'     => 'url',
			],
			'github_url'    => [
				'label'    => __( 'Github URL', 'swell' ),
				'type'     => 'url',
			],
			'youtube_url'   => [
				'label'    => __( 'YouTube URL', 'swell' ),
				'type'     => 'url',
			],
			'amazon_url'    => [
				'label'    => __( 'Amazon欲しいものリストURL', 'swell' ),
				'type'     => 'url',
			],
			'blog_parts_id' => [
				'label'    => __( '呼び出すブログパーツのID', 'swell' ),
				'type'     => 'text',
			],
			'custom_avatar' => [
				'label'    => __( 'カスタムアバター', 'swell' ),
				'type'     => 'media',
			],
		];

		self::$schema_metas = [
			'schema_type' => [
				'label'   => '@type',
				'type'    => 'radio',
				'default' => 'Person',
				'choices' => [
					'Person'       => 'Person',
					'Organization' => 'Organization',
				],
			],
			'schema_name' => [
				'label' => 'name',
			],
			'schema_url' => [
				'label' => 'url',
			],
			'schema_alternateName' => [
				'label' => 'alternateName',
				'help'  => __( '別名', 'swell' ),
			],
			'schema_sameAs' => [
				'label'  => 'sameAs',
				'type'   => 'textarea',
				'help'   => __( '複数の場合は「,（+改行）」で区切ってください。', 'swell' ),
			],
			'schema_jobTitle' => [
				'label' => 'jobTitle',
				'help'  => __( '肩書き', 'swell' ),
			],
			'schema_honorificPrefix' => [
				'label' => 'honorificPrefix',
				'help'  => __( '敬称の接頭辞', 'swell' ),
			],
			'schema_honorificSuffix' => [
				'label' => 'honorificSuffix',
				'help'  => __( '敬称の接尾辞', 'swell' ),
			],
			'schema_logo' => [
				'label' => 'logo',
				'type'  => 'media',
			],

		];
	}

	/**
	 * ユーザーメタ追加
	 */
	public static function add_user_meta( $profileuser ) {
		$schema_type_value = $profileuser->schema_type ?? 'Person';
		?>
		<h2 class="u-mt-30"><i class="icon-swell"></i> <?=esc_html__( 'SWELL追加データ', 'swell' )?></h2>
		<div class="swl-userMetas">
			<table class="form-table">
				<tbody>
					<?php self::output_meta_field( $profileuser ); ?>
				</tbody>
			</table>
			<h2 class="u-mt-20"><?=esc_html__( 'author構造化データ', 'swell' )?></h2>
			<table class="form-table">
				<tbody data-scheme-type="<?=esc_attr( $schema_type_value )?>">
					<?php self::output_schema_field( $profileuser ); ?>
				</tbody>
			</table>
		</div>
		<script>
			var typeRadio = document.querySelectorAll('[name="schema_type"]');
			for (let i = 0; i < typeRadio.length; i++) {
				var element = typeRadio[i];
				element.addEventListener('change', function(e) {
					var type = e.target.value;
					var trs = document.querySelector('[data-scheme-type]');
					trs.setAttribute('data-scheme-type', type);
				});
			}
		</script>
		<?php
		wp_nonce_field( 'swl_nonce__user_edit', 'swl_nonce__user_edit' );
	}

	/**
	 * メタフィールド追加
	 */
	public static function output_meta_field( $profileuser ) {
		foreach ( self::$user_metas as $meta_name => $meta_data ) :
			$value = $profileuser->$meta_name ?? '';
		?>
			<tr>
				<th scope="row"><?=esc_html( $meta_data['label'] )?></th>
				<td>
				<?php
					if ( 'blog_parts_id' === $meta_name ) {

						echo '<input type="text" name="' . esc_attr( $meta_name ) . '" id="' . esc_attr( $meta_name ) . '" size="20" value="' . esc_attr( $value ) . '" style="width: 6em">';

						Field::parts_select( '', $meta_name, $value );
						echo '<p class="description">' . esc_html__( '※ アーカイブページにコンテンツが表示されます。', 'swell' ) . '</p>';

					} elseif ( 'media' === $meta_data['type'] ) {
						Field::media_btns( $meta_name, $value, 'id' );

					} else {
						Field::meta_text_input( [
							'id'   => $meta_name,
							'meta' => $value,
							'type' => $meta_data['type'],
						] );
					}
				?>
				</td>
			</tr>
		<?php
		endforeach;
	}


	/**
	 * ユーザーメタ追加
	 */
	public static function output_schema_field( $profileuser ) {

		foreach ( self::$schema_metas as $meta_name => $meta_data ) :
			$value      = $profileuser->$meta_name ?? $meta_data['default'] ?? '';
			$field_type = $meta_data['type'] ?? 'text';
			$label      = $meta_data['label'] ?? '';
			$help       = $meta_data['help'] ?? '';
		?>
			<tr data-name="<?=esc_attr( $meta_name )?>">
				<th scope="row"><code><?=esc_html( $label )?></code></th>
				<td>
				<?php
					if ( 'media' === $field_type ) {
						Field::media_btns( $meta_name, $value, 'id' );

					} elseif ( 'radio' === $field_type ) {
						Field::meta_radiobox( $meta_name, $meta_data['choices'], $value );

					} elseif ( 'textarea' === $field_type ) {
						Field::meta_textarea( $meta_name, $value );

					} else {
						Field::meta_text_input( [
							'id'   => $meta_name,
							'meta' => $value,
							'type' => $field_type,
						] );
					}

					if ( $help ) echo '<p class="description">' . esc_html( $help ) . '</p>';
				?>
				</td>
			</tr>
		<?php
		endforeach;
	}


	/**
	 * ユーザーメタ保存処理
	 */
	public static function hook_profile_update( $user_id, $old_user_data ) {

		// nonceキーチェック
		if ( ! isset( $_POST['swl_nonce__user_edit'] ) ) return;
		if ( ! wp_verify_nonce( $_POST['swl_nonce__user_edit'], 'swl_nonce__user_edit' ) ) return;

		$meta_list = array_merge( self::$user_metas, self::$schema_metas );
		foreach ( $meta_list as $meta_name => $meta_data ) {
			$new_value = $_POST[ $meta_name ] ?? '';
			$old_value = $old_user_data->$meta_name ?? null;
			$type      = $meta_data['type'] ?? 'text';

			if ( $old_value !== $new_value ) {
				if ( 'url' === $type ) {
					$new_value = esc_url_raw( $new_value );
				} elseif ( 'textarea' === $type ) {
					$new_value = sanitize_textarea_field( $new_value );
				} else {
					$new_value = sanitize_text_field( $new_value );
				}

				if ( $new_value ) {
					update_user_meta( $user_id, $meta_name, $new_value );
				} else {
					delete_user_meta( $user_id, $meta_name );
				}
			}

			if ( '' === $new_value && '' === $old_value ) {
				delete_user_meta( $user_id, $meta_name );
			}
		}
	}

}
