<?php
namespace SWELL_Theme\Block\Review;

defined( 'ABSPATH' ) || exit;

/**
 * 商品レビュー
 * see: https://developers.google.com/search/docs/advanced/structured-data/product, https://developers.google.com/search/docs/advanced/structured-data/review-snippet
 */
\SWELL_Theme::register_block( 'review', [
	'render_callback' => __NAMESPACE__ . '\cb',
] );

function cb( $attrs ) {
	$useType = $attrs['useType'] ?? '';
	$useBox  = $useType !== 'json';
	$useJson = $useType !== 'box';

	$content = '';
	if ( $useBox ) {
		$content .= swl_render_review_box( $attrs );
	}
	if ( $useJson ) {
		$content .= swl_get_product_json( $attrs );
	}
	return $content;
}

/**
 * レビューボックス
 */
function swl_render_review_box( $attrs ) {
	$className = $attrs['className'] ?? '';
	$name      = $attrs['name'] ?? '';
	$image     = $attrs['image'] ?? [];
	$rating    = $attrs['rating'] ?? 0;
	$merits    = $attrs['merits'] ?? [];
	$demerits  = $attrs['demerits'] ?? [];
	// $author   = $attrs['author'];

	$img_src = '';
	$img_url = $image['url'] ?? '';
	if ( $img_url ) {
		$img_id = $image['id'] ?? '';
		$width  = $image['width'] ?? '';
		$height = $image['height'] ?? '';

		$img_class = '__img';
		if ( $img_id ) {
			$img_class .= " wp-image-{$img_id}";
		}

		$img_props = 'class="' . $img_class . '" src="' . $img_url . '" alt=""';

		if ( $width ) $img_props  .= ' width="' . $width . '"';
		if ( $height ) $img_props .= ' height="' . $height . '"';

		$img_src = '<figure class="swell-block-review__image">' .
				'<img ' . $img_props . '>' .
			'</figure>';
	}

	// phpcs:disable WordPress.Security.EscapeOutput
	ob_start();
	?>
	<div class="<?=rtrim( "swell-block-review $className" )?>">
		<div class='swell-block-review__inner'>
			<?php if ( $name ) : ?>
				<div class='swell-block-review__title'>
					<span><?=$name?></span>
				</div>
			<?php endif; ?>
			<?=$img_src?>
			<?php if ( $rating ) : ?>
				<div class='swell-block-review__rating'>
					<span class='__label'><?=__( '総合評価', 'swell' )?></span>
					<div class='__value'>
						<div class='__stars c-reviewStars'>
							<?=\SWELL_PARTS::review_stars( $rating )?>
						</div>
						<small class='__str'>( <?=$rating?> )</small>
					</div>
				</div>
			<?php endif; ?>
			<?php if ( ! empty( $merits ) ) : ?>
				<div class='swell-block-review__merits'>
					<div class='__label'><?=__( 'メリット', 'swell' )?></div>
					<ul class='__list is-style-good_list'>
						<?php render_list( $merits ); ?>
					</ul>
				</div>
			<?php endif; ?>
			<?php if ( ! empty( $demerits ) ) : ?>
				<div class='swell-block-review__demerits'>
					<div class='__label'><?=__( 'デメリット', 'swell' )?></div>
					<ul class='__list is-style-bad_list'>
						<?php render_list( $demerits ); ?>
					</ul>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<?php
	return ob_get_clean();
	// phpcs:enable WordPress.Security.EscapeOutput
}

function render_list( $data ) {
	foreach ( $data as $val ) {
		if ( ! $val ) continue;
		echo '<li>' . $val . '</li>'; // phpcs:ignore WordPress.Security.EscapeOutput
	}
}

/**
 * 商品の構造化データを取得
 */
function swl_get_product_json( $attrs ) {

	$name  = $attrs['name'] ?? '';
	$image = $attrs['image'] ?? [];
	$price = $attrs['price'] ?? '';
	$data  = $attrs['data'] ?? [];

	if ( ! $name ) return '';

	// 'sku' brand description imgae
	// gtin | gtin8 | gtin13 | gtin14 | mpn | isbn(Book専用)

	// ブランド
	$brandName = $data['brandName'] ?? '';
	$brand     = $brandName ? [
		'@type' => 'Brand',
		'name'  => $brandName,
	] : '';

	// Offers
	$offers = [];
	if ( $price ) {
		$offers = [
			'@type'         => 'Offer',
			'price'         => strval( $price ),
			'priceCurrency' => $attrs['priceCurrency'] ?? 'JPY',
		];
	}

	// @type Review
	$review = swl_get_review_json( [
		'rating'        => $attrs['rating'] ?? 0,
		'merits'        => $attrs['merits'] ?? [],
		'demerits'      => $attrs['demerits'] ?? [],
		'author'        => $attrs['author'] ?? '',
		'usePostAuthor' => $attrs['usePostAuthor'] ?? false,
	] );

	$product_data = [
		'@type'            => 'Product',
		'name'             => $name,
		'description'      => $attrs['description'] ?? '',
		'brand'            => $brand,
		'sku'              => $data['sku'] ?? '',
		'image'            => $image['url'] ?? '',
		'offers'           => $offers,
		'review'           => $review,
	];

	$product_data = array_filter( $product_data );

	if ( empty( $product_data ) ) return '';

	$json = wp_json_encode( $product_data, JSON_UNESCAPED_UNICODE );
	// $json = wp_json_encode( $product_data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT ); // json 整形して確認

	$json_ld = '<script type="application/ld+json">{"@context":"https://schema.org","@graph": [' . $json . ']}</script>';
	return $json_ld;

	// $json_ld = str_replace( '<', '&lt;', $json_ld );
	// $json_ld = str_replace( '>', '&gt;', $json_ld );
	// return '<pre class="u-fz-xs">' . $json_ld . '</pre>';
}



/**
 * @type:Review データを取得
 */
function swl_get_review_json( $attrs ) {
	$rating        = $attrs['rating'];
	$merits        = $attrs['merits'];
	$demerits      = $attrs['demerits'];
	$author        = $attrs['author'];
	$usePostAuthor = $attrs['usePostAuthor'];

	// 評価
	$reviewRating = $rating ? [
		'@type'       => 'Rating',
		'ratingValue' => strval( $rating ),
	] : '';

	// メリット
	$positiveNotes = [];
	if ( ! empty( $merits ) ) {
		$meritList = [];
		$ct        = 1;
		foreach ( $merits as $merit ) {
			$meritList[] = [
				'@type'     => 'ListItem',
				'position'  => $ct,
				'name'      => $merit,
			];
			$ct++;
		}

		$positiveNotes = [
			'@type'           => 'ItemList',
			'itemListElement' => $meritList,
		];
	}

	// デメリット
	$negativeNotes = [];
	if ( ! empty( $demerits ) ) {
		$demeritList = [];
		$ct          = 1;
		foreach ( $demerits as $demerit ) {
			$demeritList[] = [
				'@type'     => 'ListItem',
				'position'  => $ct,
				'name'      => $demerit,
			];
			$ct++;
		}

		$negativeNotes = [
			'@type'           => 'ItemList',
			'itemListElement' => $demeritList,
		];
	}

	// 著者
	$authorData = '';
	if ( $usePostAuthor && is_singular() ) {
		$authorData = [
			'@id' => rtrim( \SWELL_Theme\Json_Ld::get_the_page_url(), '/' ) . '/#author',
		];
	} else {
		$authorData = [
			'@type' => 'Person',
			'name'  => $author,
		];
	}

	// @type Review
	$reviewData = [
		'@type'          => 'Review',
		'reviewRating'   => $reviewRating,
		'positiveNotes'  => $positiveNotes,
		'negativeNotes'  => $negativeNotes,
		'author'         => $authorData,
		'publisher'      => [
			'@id'  => home_url( '/#organization' ),
		],
		'datePublished'  => get_the_date( DATE_ISO8601 ),
	];

	// Review から 空要素削除
	$reviewData = array_filter( $reviewData );

	return $reviewData;
}
