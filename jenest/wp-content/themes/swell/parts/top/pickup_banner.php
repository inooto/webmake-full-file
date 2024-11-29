<?php if ( ! defined( 'ABSPATH' ) ) exit;
$SETTING = SWELL_Theme::get_setting();

// 追加クラス
$pb_add_class = '-cap-' . $SETTING['pickbnr_style'] . ' -pc-' . $SETTING['pickbnr_layout_pc'] . ' -sp-' . $SETTING['pickbnr_layout_sp'];
if ( $SETTING['pickbnr_bgblack'] === 'on') $pb_add_class .= ' -darken';
if ( $SETTING['pickbnr_border'] === 'on' ) $pb_add_class .= ' -border-inside';
?>
<div id="pickup_banner" class="p-pickupBanners <?=esc_attr( $pb_add_class )?>">
	<ul class="p-pickupBanners__list">
		<?php
			wp_nav_menu([
				'container'       => '',
				'fallback_cb'     => '',
				'theme_location'  => 'pickup_banner',
				'items_wrap'      => '%3$s',
			]);
		?>
	</ul>
</div>
