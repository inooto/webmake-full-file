<?php
namespace SWELL_Theme\Gutenberg;

if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * FAQブロック
 */
add_filter( 'render_block_loos/faq', __NAMESPACE__ . '\render_faq', 10, 2 );
function render_faq( $block_content, $block ) {

	$atts         = $block['attrs'] ?? [];
	$outputJsonLd = $atts['outputJsonLd'] ?? false;

	// 構造化データの出力設定が無効ならそのまま返す
	if ( ! $outputJsonLd ) return $block_content;

	$Q_tag = $atts['titleTag'] ?? 'dt' ?: 'dt';
	$A_tag = $Q_tag === 'dt' ? 'dd' : 'div';

	// Q の中身を取得
	$is_matched = preg_match_all( '/<' . $Q_tag . ' class="faq_q">.+?<\/' . $Q_tag . '>/s', $block_content, $questions );
	if ( ! $is_matched ) return $block_content;

	// 続いて、A の中身を取得していく（divの入れ子の可能性があるため、正規表現では難しい）
	$answers       = [];
	$block_content = mb_convert_encoding( $block_content, 'HTML-ENTITIES', 'auto' );
	$dom           = new \DOMDocument();
	libxml_use_internal_errors( true );
	$dom->loadHTML( $block_content );
	libxml_clear_errors();
	$xpath = new \DOMXpath( $dom );

	$A_doms = $xpath->query( '//' . $A_tag . '[@class="faq_a"]' );
	foreach ( $A_doms as $A_dom ) {

		$A_content = '';
		foreach ( $A_dom->childNodes as $node ) {
			$A_content .= $dom->saveHTML( $node );
		}

		// 構造化データに不要なタグなどを削除
		// Answerは一部HTMLが許可されている: https://developers.google.com/search/docs/data-types/faqpage?hl=ja#answer
		$A_content = strip_tags(
			do_shortcode( $A_content ),
			'<h1><h2><h3><h4><h5><h6><br><ol><ul><li><a><p><div><b><strong><em>' // <i>は除外
		);
		$A_content = str_replace( "\n", '', $A_content );
		$answers[] = $A_content;
	}

	$faqs = [];
	foreach ( $questions[0] as $i => $question ) {

		if ( ! isset( $answers[0][ $i ] ) ) break;
		$question = wp_strip_all_tags( do_shortcode( $question ), true );
		$answer   = $answers[ $i ];

		$faqs[] = [
			'@type'           => 'Question',
			'name'            => $question,
			'acceptedAnswer'  => [
				'@type' => 'Answer',
				'text'  => $answer,
			],
		];
	}

	$json_ld_data = [
		'@context'   => 'https://schema.org',
		'@id'        => '#FAQContents',
		'@type'      => 'FAQPage',
		'mainEntity' => $faqs,
	];

	$block_content .= '<script type="application/ld+json">' . wp_json_encode( $json_ld_data, JSON_UNESCAPED_UNICODE ) . '</script>' . PHP_EOL;

	return $block_content;
}
