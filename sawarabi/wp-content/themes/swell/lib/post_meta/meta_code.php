<?php
namespace SWELL_Theme\Meta\Code;

use \SWELL_Theme as SWELL;
use \SWELL_THEME\Parts\Setting_Field as Field;

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'add_meta_boxes', __NAMESPACE__ . '\hook_add_meta_box', 1 );
add_action( 'save_post', __NAMESPACE__ . '\hook_save_post' );


/**
 * メタボックス追加
 */
function hook_add_meta_box() {
	$custom_post_types = get_post_types( [
		'public'   => true,
		'_builtin' => false,
	] );

	$screens = array_merge( [ 'post', 'page' ], array_keys( $custom_post_types ) );

	add_meta_box(
		'swell_post_meta__code',
		__( 'カスタムCSS & JS', 'swell' ),
		__NAMESPACE__ . '\code_meta_cb',
		$screens = apply_filters( 'swell_code_meta_screens', $screens ),
		'normal',
		'high',
		null
	);
}


/**
 * 【SWELL】カスタムCSS & JS
 */
function code_meta_cb( $post ) {
	$code_metas = [
		'swell_meta_css' => [
			'label'       => __( 'CSS用コード', 'swell' ),
			'check-label' => __( 'コードを &lt;style&gt; ~ &lt;/style&gt; で囲まずそのまま出力する', 'swell' ),
			'desc'        => __( 'wp_head(&lt;head&gt;内)で出力されます。', 'swell' ),
			'type'        => 'textarea',
		],
		'swell_meta_js' => [
			'label'       => __( 'JS用コード', 'swell' ),
			'check-label' => __( 'コードを &lt;script> ~ &lt;/script&gt; で囲まずそのまま出力する', 'swell' ),
			'desc'        => __( 'wp_footer(&lt;/body&gt;前)で出力されます。', 'swell' ),
			'type'        => 'textarea',
		],
	];

	SWELL::set_nonce_field( '_meta_code' );

	// @codingStandardsIgnoreStart
	?>
	<div id="swell_metabox_css" class="swl-meta -code">
	<?php
		foreach ( $code_metas as $key => $data ) :
			$desc      = $data['desc'];
			$code_val  = get_post_meta( $post->ID, $key, true );
			$check_val = get_post_meta( $post->ID, $key . '_plane', true );
		?>
			<div class="swl-meta__item">
				<div class="swl-meta__subttl"><?=$data['label']?></div>
				<div class="swl-meta__field">
					<textarea id="<?=$key?>" name="<?=$key?>" rows="8"><?=esc_textarea($code_val)?></textarea>
					<?php if ( $desc ) : ?>
						<p class="swl-meta__desc">
							<?=esc_html($desc)?>
						</p>
					<?php endif; ?>
				</div>
				<div class="swl-meta__field">
					<?php Field::meta_checkbox( $key . '_plane', $data['check-label'], $check_val ); ?>
					<br><small><?=esc_html__( '※ Pjaxがオンの時はコードが正常に動作しないので使用しないで下さい。', 'swell' )?></small>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
<?php
}


/**
 * 保存処理
 */
function hook_save_post( $post_id ) {

	// nonce チェック
	if ( ! SWELL::check_nonce( '_meta_code' ) ) {
		return;
	}

	SWELL::save_post_metas( $post_id, [
		'swell_meta_css'       => 'code',
		'swell_meta_js'        => 'code',
		'swell_meta_css_plane' => 'check',
		'swell_meta_js_plane'  => 'check',
	] );

}
