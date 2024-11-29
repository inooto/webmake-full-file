<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<aside id="sidebar" class="l-sidebar">
	<?php
		$cache_key = '';
		if ( SWELL_Theme::get_setting( 'cache_sidebar' ) ) :
			if ( SWELL_Theme::is_top() ) :
				$cache_key = 'sidebar_top';
			elseif ( is_single() ) :
				$cache_key = 'sidebar_single';
			elseif ( is_page() || is_home() ) :
				$cache_key = 'sidebar_page';
			elseif ( is_archive() ) :
				$cache_key = 'sidebar_archive';
			endif;

			if ( '' !== $cache_key && IS_MOBILE ) :
				$cache_key .= '_sp';
			endif;
		endif;
		SWELL_Theme::get_parts( 'parts/sidebar_content', '', $cache_key, 24 * HOUR_IN_SECONDS ); // キャッシュは24時間だけ
	?>
</aside>
