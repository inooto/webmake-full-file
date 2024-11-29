<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$is_loop   = SWELL_Theme::get_setting( 'sp_head_nav_loop' );
$nav_class = 'l-header__spNav';
$ul_class  = 'p-spHeadMenu';
$data_loop = '0';
if ( $is_loop ) {
	$nav_class .= ' swiper';
	$ul_class  .= ' swiper-wrapper';
	$data_loop  = '1';
}
// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
?>
<div class="<?=$nav_class?>" data-loop="<?=$data_loop?>">
	<ul class="<?=$ul_class?>">
		<?php
			wp_nav_menu( [
				'container'       => '',
				'fallback_cb'     => '',
				'theme_location'  => 'sp_head_menu',
				'items_wrap'      => '%3$s',
				'link_before'     => '<span>',
				'link_after'      => '</span>',
				'depth'           => 1,
			] );
		?>
	</ul>
</div>
