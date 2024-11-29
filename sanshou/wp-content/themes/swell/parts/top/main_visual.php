<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$mv_class = 'p-mainVisual';
$mv_type  = SWELL_Theme::site_data( 'mv' );

// スライド / １枚画像 / 動画 で処理を分ける
if ( 'single' === $mv_type ) {
	$mv_class  .= ' -type-single';
	$parts_name = 'parts/top/main_visual-single';

} elseif ( 'slider' === $mv_type ) {

	$mv_class  .= ' -type-slider -motion-' . SWELL_Theme::get_setting( 'mv_slide_animation' );
	$parts_name = 'parts/top/main_visual-slider';

} elseif ( 'movie' === $mv_type ) {

	$mv_class  .= ' -type-movie';
	$parts_name = 'parts/top/main_visual-movie';

}

// スライダーの高さ
$slide_size = SWELL_Theme::get_setting( 'mv_slide_size' );
$mv_class  .= ' -height-' . $slide_size;


// 余白ありかどうか
if ( SWELL_Theme::get_setting( 'mv_on_margin' ) ) {
	$mv_class .= ' -margin-on';
}

?>
<div id="main_visual" class="<?=esc_attr( $mv_class )?>">
<?php
	SWELL_Theme::get_parts( $parts_name );
	do_action( 'swell_inner_main_visual' );
?>
</div>
