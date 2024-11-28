<?php
/**
 * 画面右下に固定表示するボタン
 *
 * @package swell
 */

$has_tocbtn_text  = ! ! SWELL_Theme::get_setting( 'tocbtn_label' );
$has_pagetop_text = ! ! SWELL_Theme::get_setting( 'pagetop_label' );
?>
<div class="p-fixBtnWrap">
	<?php if ( SWELL_Theme::is_show_index() && SWELL_Theme::get_setting( 'index_btn_style' ) !== 'none' ) : ?>
		<button id="fix_tocbtn" class="c-fixBtn c-plainBtn hov-bg-main" data-onclick="toggleIndex" aria-label="<?=esc_attr__( '目次ボタン', 'swell' )?>" data-has-text="<?=esc_html( $has_tocbtn_text )?>">
			<i class="icon-index c-fixBtn__icon" role="presentation"></i>
			<?php if ( $has_tocbtn_text ) : ?>
				<span class="c-fixBtn__label"><?=esc_html( SWELL_Theme::get_setting( 'tocbtn_label' ) )?></span>
			<?php endif; ?>
		</button>
	<?php endif; ?>

	<?php if ( SWELL_Theme::get_setting( 'pagetop_style' ) !== 'none' ) : ?>
		<button id="pagetop" class="c-fixBtn c-plainBtn hov-bg-main" data-onclick="pageTop" aria-label="<?=esc_attr__( 'ページトップボタン', 'swell' )?>" data-has-text="<?=esc_html( $has_pagetop_text )?>">
			<i class="c-fixBtn__icon icon-chevron-up" role="presentation"></i>
			<?php if ( $has_pagetop_text ) : ?>
				<span class="c-fixBtn__label"><?=esc_html( SWELL_Theme::get_setting( 'pagetop_label' ) )?></span>
			<?php endif; ?>
		</button>
	<?php endif; ?>
</div>
