<?php
if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! SWELL_Theme::is_use( 'head_bar' )  ) return; // 後方互換用
?>
<div class="l-header__bar pc_">
	<div class="l-header__barInner l-container">
		<?php
			if ( 'head_bar' === SWELL_Theme::get_setting( 'phrase_pos' ) ) :
				echo '<div class="c-catchphrase">' . esc_html( SWELL_Theme::site_data( 'catchphrase' ) ) . '</div>';
			endif;

			if ( SWELL_Theme::get_setting( 'show_icon_list' ) ) :
				$sns_settings = SWELL_Theme::get_sns_settings();
				if ( 'head_bar' === SWELL_Theme::get_setting( 'search_pos' ) ) :
					$sns_settings['search'] = 1;
				endif;
				if ( ! empty( $sns_settings ) ) :
					$list_data = [
						'list_data' => $sns_settings,
						'ul_class'  => '',
						'fz_class'  => 'u-fz-14',
					];
					SWELL_Theme::get_parts( 'parts/icon_list', $list_data );
				endif;
			endif;
		?>
	</div>
</div>
