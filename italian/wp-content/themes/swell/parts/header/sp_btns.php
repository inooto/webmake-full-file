<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$SETTING    = SWELL_Theme::get_setting();
$menu_label = $SETTING['menu_btn_label'] ?: '';
$btn2_icon  = $SETTING['custom_btn_icon'] ?: 'icon-search';
$btn2_label = $SETTING['custom_btn_label'] ?: '';
?>
<div class="l-header__customBtn sp_">
	<?php if ( $SETTING['search_pos_sp'] === 'header' ) : ?>
		<button class="c-iconBtn c-plainBtn" data-onclick="toggleSearch" aria-label="<?=esc_attr__( '検索ボタン', 'swell' )?>">
			<i class="c-iconBtn__icon <?=esc_attr( $btn2_icon )?>"></i>
			<?php if ( $btn2_label !== '' ) : ?>
				<span class="c-iconBtn__label"><?=esc_html( $btn2_label )?></span>
			<?php endif; ?>
		</button>
	<?php elseif ( $SETTING['custom_btn_url'] !== '' ) : ?>
		<a href="<?=esc_url( $SETTING['custom_btn_url'] )?>" class="c-iconBtn">
			<i class="c-iconBtn__icon <?=esc_attr( $btn2_icon )?>"></i>
			<?php if ( $btn2_label !== '' ) : ?>
				<span class="c-iconBtn__label"><?=esc_html( $btn2_label )?></span>
			<?php endif; ?>
		</a>
	<?php endif; ?>
</div>
<div class="l-header__menuBtn sp_">
	<button class="c-iconBtn -menuBtn c-plainBtn" data-onclick="toggleMenu" aria-label="<?=esc_attr__( 'メニューボタン', 'swell' )?>">
		<i class="c-iconBtn__icon icon-menu-thin"></i>
		<?php if ( $menu_label ) : ?>
			<span class="c-iconBtn__label"><?=esc_html( $menu_label )?></span>
		<?php endif; ?>
	</button>
</div>
