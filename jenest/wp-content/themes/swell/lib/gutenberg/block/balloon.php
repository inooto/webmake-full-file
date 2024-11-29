<?php
namespace SWELL_Theme\Block\Balloon;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * ふきだしブロック
 */
\SWELL_Theme::register_block( 'balloon', [
	'render_callback' => __NAMESPACE__ . '\cb',
] );

function cb( $attrs, $content = '' ) {

	$balloonID     = $attrs['balloonID'];
	$balloonIcon   = $attrs['balloonIcon'];
	$balloonName   = $attrs['balloonName'];
	$balloonCol    = $attrs['balloonCol'];
	$balloonType   = $attrs['balloonType'];
	$balloonAlign  = $attrs['balloonAlign'];
	$balloonBorder = $attrs['balloonBorder'];
	$balloonShape  = $attrs['balloonShape'];
	$spVertical    = $attrs['spVertical'];

	$props                          = '';
	if ($balloonID) $props         .= ' id="' . $balloonID . '"';
	if ($balloonIcon) $props       .= ' icon="' . $balloonIcon . '"';
	if ($balloonAlign) $props      .= ' align="' . $balloonAlign . '"';
	if ($balloonName) $props       .= ' name="' . $balloonName . '"';
	if ($balloonCol) $props        .= ' col="' . $balloonCol . '"';
	if ($balloonType) $props       .= ' type="' . $balloonType . '"';
	if ($balloonBorder) $props     .= ' border="' . $balloonBorder . '"';
	if ($balloonShape) $props      .= ' icon_shape="' . $balloonShape . '"';
	if ('' !== $spVertical) $props .= ' sp_vertical="' . $spVertical . '"';

	if ( false !== strpos( $content, '="c-balloon' ) ) {

		// ブログパーツから呼び出された時など、すでに展開済みのもの
		return $content;

	} elseif ( false !== strpos( $content, '[ふきだし' ) ) {

		// 古い状態のブロック
		return do_shortcode( $content );

	} else {

		// 新:  $content には p タグ でテキスト入っている
		$block_class = 'swell-block-balloon';
		if ( $attrs['className'] ) {
			$block_class .= ' ' . $attrs['className'];

			// $content の pタグにもクラスがついているのでそっちは消す
			$content = str_replace( 'p class="' . $attrs['className'] . '"', 'p', $content );
		}
		$content = '[speech_balloon' . $props . ']' . $content . '[/speech_balloon]';
		return '<div class="' . esc_attr( $block_class ) . '">' . do_shortcode( $content ) . '</div>';
	}
}
