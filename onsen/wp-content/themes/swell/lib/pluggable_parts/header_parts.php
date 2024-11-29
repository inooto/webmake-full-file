<?php
if ( ! defined( 'ABSPATH' ) ) exit;

use \SWELL_Theme as SWELL;

/**
 * ヘッダーロゴ
 */
if ( ! function_exists( 'swl_parts__head_logo' ) ) :
	function swl_parts__head_logo() {

		$logo_id = SWELL::site_data( 'logo_id' );

		// トップページのヒーロヘッダーを利用するかどうか。
		$use_overlay_header = SWELL::is_use( 'top_header' );

		// 後方互換用。ロゴURLが直接指定されている場合。
		if ( has_filter( 'swell_head_logo' ) || ! $logo_id ) {
			$logo     = apply_filters( 'swell_head_logo', SWELL::site_data( 'logo_url' ) );
			$logo_top = apply_filters( 'swell_head_logo_top', SWELL::site_data( 'logo_top_url' ) ) ?: $logo;

			if ( $use_overlay_header ) {
				echo '<img src="' . esc_url( $logo_top ) . '" alt="' . esc_attr( SWELL::site_data( 'title' ) ) . '" class="c-headLogo__img -top" decoding="async">' .
					'<img src="' . esc_url( $logo ) . '" alt="" class="c-headLogo__img -common" loading="lazy" aria-hidden="true">';
			} else {
				// 通常時
				echo '<img src="' . esc_url( $logo ) . '" alt="' . esc_attr( SWELL::site_data( 'title' ) ) . '" class="c-headLogo__img" decoding="async">';
			}

			return;
		}

		$logo_top_id = SWELL::site_data( 'logo_top_id' ) ?: $logo_id;
		$logo_sizes  = apply_filters( 'swell_head_logo_sizes', '(max-width: 959px) 50vw, 800px' );

		if ( ! $use_overlay_header ) {
			// 通常時

			$return = SWELL::get_image( $logo_id, [
				'class'    => 'c-headLogo__img',
				'sizes'    => $logo_sizes,
				'alt'      => SWELL::site_data( 'title' ),
				'loading'  => 'eager',
				'decoding' => 'async',
			] );

		} else {
			// ヘッダーオーバーレイ有効時
			$logo_top = SWELL::get_image( $logo_top_id, [
				'class'    => 'c-headLogo__img -top',
				'sizes'    => $logo_sizes,
				'alt'      => SWELL::site_data( 'title' ),
				'loading'  => 'eager',
				'decoding' => 'async',
			] );

			$common_logo = SWELL::get_image( $logo_id, [
				'class'   => 'c-headLogo__img -common',
				'sizes'   => $logo_sizes,
				'alt'     => '',
				'loading' => 'lazy',
			] );
			$common_logo = str_replace( '<img ', '<img aria-hidden="true" ', $common_logo );

			$return = $logo_top . $common_logo;
		}

		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $return;
	}
endif;


/**
 * グローバルナビ
 */
if ( ! function_exists( 'swl_parts__gnav' ) ) :
	function swl_parts__gnav( $args ) {
		$use_search = $args['use_search'] ?? false;
	?>
		<ul class="c-gnav">
			<?php
				wp_nav_menu([
					'container'       => '',
					'fallback_cb'     => ['SWELL_Theme', 'default_head_menu' ],
					'theme_location'  => 'header_menu',
					'items_wrap'      => '%3$s',
					'link_before'     => '<span class="ttl">',
					'link_after'      => '</span>',
				]);
			?>
			<?php if ( $use_search ) : ?>
				<li class="menu-item c-gnav__s">
					<button class="c-gnav__sBtn c-plainBtn" data-onclick="toggleSearch" aria-label="<?=esc_attr__( '検索ボタン', 'swell' )?>">
						<i class="icon-search"></i>
					</button>
				</li>
			<?php endif; ?>
		</ul>
	<?php
	}
endif;
