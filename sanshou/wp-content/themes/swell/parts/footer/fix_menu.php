<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$SETTING = SWELL_Theme::get_setting();
?>
<div id="fix_bottom_menu">
	<ul class="menu_list">
		<?php if ( $SETTING['show_fbm_menu'] ) : ?>
			<li class="menu-item menu_btn" data-onclick="toggleMenu">
				<i class="icon-menu-thin open_btn"></i>
				<span><?=esc_html( $SETTING['fbm_menu_label'] )?></span>
			</li>
		<?php endif; ?>
		<?php
			wp_nav_menu([
				'container'       => '',
				'fallback_cb'     => '',
				'theme_location'  => 'fix_bottom_menu',
				'items_wrap'      => '%3$s',
				'link_before'     => '',
				'link_after'      => '',
			]);
		?>
		<?php if ( $SETTING['show_fbm_search'] ) : ?>
			<li class="menu-item" data-onclick="toggleSearch">
				<i class="icon-search"></i>
				<span><?=esc_html( $SETTING['fbm_search_label'] )?></span>
			</li>
		<?php endif; ?>
		<?php if ( $SETTING['show_fbm_index'] ) : ?>
			<li class="menu-item" data-onclick="toggleIndex">
				<i class="icon-index"></i>
				<span><?=esc_html( $SETTING['fbm_index_label'] )?></span>
			</li>
		<?php endif; ?>
		<?php if ( $SETTING['show_fbm_pagetop'] ) : ?>
			<li class="menu-item pagetop_btn" data-onclick="pageTop">
				<i class="icon-chevron-up"></i>
				<span><?=esc_html( $SETTING['fbm_pagetop_label'] )?></span>
			</li>
		<?php endif; ?>
	</ul>
</div>
