<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$SETTING = SWELL_Theme::get_setting();
$mv_type = $SETTING['main_visual_type'];

?>

<div class="p-mvInfo">
	<div class="p-mvInfo__inner l-container">
		<div class="p-mvInfo__badge">
			<?=esc_html__( 'お知らせ', 'swell' )?>
		</div>
		<div class="p-mvInfo__text">
			<?=esc_html__( 'SWELL2.0、やっとリリースしました〜！', 'swell' )?>
		</div>
		<a class="p-mvInfo__btn">
			<?=esc_html__( '詳細はこちら', 'swell' )?>
		</a>
	</div>
</div>
