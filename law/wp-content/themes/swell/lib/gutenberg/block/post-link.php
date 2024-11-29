<?php
namespace SWELL_Theme\Block\Post_Link;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * 関連記事ブロック
 */
\SWELL_Theme::register_block( 'post-link', [
	'render_callback' => __NAMESPACE__ . '\cb',
] );

function cb( $attrs ) {
	$className = $attrs['className'];

	$style       = $attrs['style'] ?? '';
	$cardTitle   = $attrs['cardTitle'] ?? '';
	$cardCaption = $attrs['cardCaption'];
	$isNewTab    = $attrs['isNewTab'];
	$rel         = $attrs['rel'];
	$hideImage   = $attrs['hideImage'];
	$hideExcerpt = $attrs['hideExcerpt'];
	$isText      = $attrs['isText'];
	$linkData    = $attrs['linkData'] ?? [];
	$icon        = $attrs['icon'] ?? '';

	//////////////
	if ( ! empty( $linkData ) ) {
		// v2以降は、linkDataを使う
		$link_id = $linkData['id'] ?? 0;
		$url     = $linkData['url'] ?? '';
		$kind    = $linkData['kind'] ?? ''; // "taxonomy" or "post-type" (多分この２つだけ)
		$type    = $linkData['type'] ?? ''; // 投稿タイプ or タクソノミー名
	} else {
		// v1
		$link_id = $attrs['postId'] ?? 0;
		$url     = $attrs['externalUrl'] ?? '';
		$kind    = $link_id ? 'post-type' : '';
		$type    = ''; // 投稿タイプは判断できない
	}
	//////////////

	$card_style = $style ?: 'card';
	if ( $isText ) {
		$card_style = 'text';
	}

	// 上書き用データ
	$card_args = [
		'custom_title' => $cardTitle,
		'caption'      => $cardCaption,
		'is_blank'     => $isNewTab,
		'rel'          => $rel,
		'noimg'        => $hideImage,
		'nodesc'       => $hideExcerpt,
		'style'        => $card_style,
		'icon'         => $icon,
	];

	$block_class = 'swell-block-postLink';
	if ( $className ) {
		$block_class .= ' ' . $className;
	}

	// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
	ob_start();
	echo '<div class="' . esc_attr( $block_class ) . '">';
	if ( ! $link_id && $url ) {
		echo \SWELL_Theme::get_external_blog_card( $url, $card_args );
	} elseif ( $link_id ) {
		echo \SWELL_Theme::get_internal_blog_card_v2( [
			'link_id'   => $link_id,
			'kind'      => $kind,
			'type'      => $type,
			'card_args' => $card_args,
		] );
	}
	//  else { echo 'idまたはurlの指定がありません'; }
	echo '</div>';
	return ob_get_clean();
}
