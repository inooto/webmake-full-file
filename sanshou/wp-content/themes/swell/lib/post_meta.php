<?php
// namespace SWELL_Theme\Meta;
if ( ! defined( 'ABSPATH' ) ) exit;

require_once T_DIRE . '/lib/post_meta/meta_code.php';
require_once T_DIRE . '/lib/post_meta/meta_side.php';
require_once T_DIRE . '/lib/post_meta/meta_lp.php';
require_once T_DIRE . '/lib/post_meta/meta_ad.php';
require_once T_DIRE . '/lib/post_meta/meta_button.php';

/**
 * カスタムフィールド登録
 */
add_action( 'init', __NAMESPACE__ . '\register_rest_metas' );
function register_rest_metas() {
	register_meta( 'post', 'swell_btn_cv_data', [
		'show_in_rest' => true,
		'single'       => true,
		'type'         => 'string',
		// 'object_subtype' => 'post'
	] );
}
