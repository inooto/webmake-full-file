<?php
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<div id="fix_header" class="l-fixHeader <?=esc_attr( SWELL_Theme::get_header_class() )?>">
	<div class="l-fixHeader__inner l-container">
		<div class="l-fixHeader__logo">
			<?php echo SWELL_PARTS::head_logo( true ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
		<div class="l-fixHeader__gnav c-gnavWrap">
			<?php
				\SWELL_Theme::pluggable_parts( 'gnav', [
					'use_search' => 'head_menu' === \SWELL_Theme::get_setting( 'search_pos' ),
				] );
			?>
		</div>
	</div>
</div>
