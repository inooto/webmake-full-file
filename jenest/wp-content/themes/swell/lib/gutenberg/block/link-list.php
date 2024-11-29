<?php
namespace SWELL_Theme\Block\Link_List;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * 投稿リストブロック
 */
\SWELL_Theme::register_block( 'link-list', [
	'render_callback' => function ( $attrs, $content ) {
		$icon    = $attrs['icon'] ?? '';
		$iconPos = $attrs['iconPos'] ?? 'left';

		if ( $icon ) {
			$icon    = str_replace( 'swl-svg-', '', $icon );
			$content = str_replace(
				'<!-- icon-placeholder -->',
				\SWELL_Theme\SVG::get_svg( $icon, [ 'class' => "swell-block-linkList__icon -{$iconPos}" ] ),
				$content
			);
		} else {
			$content = str_replace( '<!-- icon-placeholder -->', '', $content );
		}

		return $content;
	},
] );
