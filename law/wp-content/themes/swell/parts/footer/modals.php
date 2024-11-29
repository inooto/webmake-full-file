<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<div id="search_modal" class="c-modal p-searchModal">
	<div class="c-overlay" data-onclick="toggleSearch"></div>
	<div class="p-searchModal__inner">
		<?php echo get_search_form(); ?>
		<button class="c-modal__close c-plainBtn" data-onclick="toggleSearch">
			<i class="icon-batsu"></i> <?=esc_html__( '閉じる', 'swell' )?>
		</button>
	</div>
</div>
<?php if ( ! SWELL_Theme::is_show_index() ) return; ?>
<div id="index_modal" class="c-modal p-indexModal">
	<div class="c-overlay" data-onclick="toggleIndex"></div>
	<div class="p-indexModal__inner">
		<div class="p-toc post_content -modal"><span class="p-toc__ttl"><?=esc_html( SWELL_Theme::get_setting( 'toc_title' ) )?></span></div>
		<button class="c-modal__close c-plainBtn" data-onclick="toggleIndex">
			<i class="icon-batsu"></i> <?=esc_html__( '閉じる', 'swell' )?>
		</button>
	</div>
</div>
