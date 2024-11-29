<?php
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<div class="l-footer__inner">
	<?php
		SWELL_Theme::get_parts( 'parts/footer/foot_widget' );
	?>
		<div class="l-footer__foot">
			<div class="l-container">
			<?php
				if ( SWELL_Theme::get_setting( 'show_foot_icon_list' ) ) :
					$sns_settings = SWELL_Theme::get_sns_settings();
					if ( ! empty( $sns_settings ) ) :
						$list_data = [
							'list_data' => $sns_settings,
							'fz_class'  => 'u-fz-14',
						];
						SWELL_Theme::get_parts( 'parts/icon_list', $list_data );
					endif;
				endif;
				wp_nav_menu([
					'container'       => false,
					'fallback_cb'     => '',
					'theme_location'  => 'footer_menu',
					'items_wrap'      => '<ul class="l-footer__nav">%3$s</ul>',
					'link_before'     => '',
					'link_after'      => '',
				]);
			?>
			<p class="copyright">
				<span lang="en">&copy;</span>
				<?=wp_kses( SWELL_Theme::get_setting( 'copyright' ), SWELL_Theme::$allowed_text_html )?>
			</p>
			<?php do_action( 'swell_after_copyright' ); ?>
		</div>
	</div>
</div>
