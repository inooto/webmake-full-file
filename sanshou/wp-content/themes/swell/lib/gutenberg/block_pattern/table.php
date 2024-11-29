<?php
namespace SWELL_Theme\Gutenberg;

if ( ! defined( 'ABSPATH' ) ) exit;


// パターンカテゴリーを登録
$pattern_category = 'swell-table-patterns';
register_block_pattern_category(
	$pattern_category,
	[ 'label' => '[SWELL] ' . __( 'テーブル', 'swell' ) ]
);


/**
 * メリット・デメリット
 */
$table01 = '<!-- wp:table {"hasFixedLayout":true,"className":"is-style-double is-thead-centered"} -->
<figure class="wp-block-table is-style-double is-thead-centered"><table class="has-fixed-layout"><thead><tr><th><span style="--the-cell-bg: #70c0a2" data-icon-size="l" data-icon-type="bg" data-text-color="white" aria-hidden="true" class="swl-cell-bg">&nbsp;</span>メリット</th><th><span style="--the-cell-bg: #f69f78" data-text-color="white" aria-hidden="true" class="swl-cell-bg">&nbsp;</span>デメリット</th></tr></thead><tbody><tr><td><span data-icon-size="l" data-icon-type="bg" style="--the-cell-bg: #fbfbfb" data-text-color="black" aria-hidden="true" class="swl-cell-bg">&nbsp;</span><span data-icon="circle" class="swl-inline-list">メリット</span><br><span data-icon="circle" class="swl-inline-list">メリット</span><br><span data-icon="circle" class="swl-inline-list">メリット</span><br><span data-icon="circle" class="swl-inline-list">メリット</span></td><td><span data-icon-size="l" data-icon-type="bg" style="--the-cell-bg: #fffbfa" data-text-color="black" aria-hidden="true" class="swl-cell-bg">&nbsp;</span><span data-icon="close" class="swl-inline-list">デメリット</span><br><span data-icon="close" class="swl-inline-list">デメリット</span><br><span data-icon="close" class="swl-inline-list">デメリット</span><br><span data-icon="close" class="swl-inline-list">デメリット</span></td></tr></tbody></table></figure>
<!-- /wp:table -->';

register_block_pattern(
	'swell-pattern/table-01',
	[
		'title'         => __( 'メリット・デメリット', 'swell' ),
		'content'       => $table01,
		'description'   => '',
		'viewportWidth' => 900,
		'categories'    => [ $pattern_category ],
		'keywords'      => [ 'table', 'テーブル', '表' ],
		// 'blockTypes'    => [ 'core/table' ],
	]
);



/**
 *
 */
$table02 = '<!-- wp:table {"hasFixedLayout":true,"className":"is-all-centered","swlTableWidth":"600px","swlScrollable":"sp","swlHeadColor":{"text":"black","slug":"swl-gray"}} -->
<figure class="wp-block-table is-all-centered"><table class="has-fixed-layout"><thead><tr><th> </th><th>フリープラン<br><small class="mininote">0円</small></th><th>プレミアムプラン<br><small class="mininote">1000円/月</small></th></tr></thead><tbody><tr><td>機能A</td><td><span data-icon-type="bg" data-icon="check" data-icon-size="m" aria-hidden="true" class="swl-cell-bg">&nbsp;</span></td><td><span data-icon="check" data-icon-size="m" data-icon-type="bg" aria-hidden="true" class="swl-cell-bg">&nbsp;</span></td></tr><tr><td>機能B</td><td><span data-icon="check" data-icon-size="m" data-icon-type="bg" aria-hidden="true" class="swl-cell-bg">&nbsp;</span></td><td><span data-icon="check" data-icon-size="m" data-icon-type="bg" aria-hidden="true" class="swl-cell-bg">&nbsp;</span></td></tr><tr><td>機能C</td><td><span data-icon-size="m" data-icon="triangle" data-icon-type="obj" aria-hidden="true" class="swl-cell-bg">&nbsp;</span><br><small class="mininote">制限あり</small></td><td><span data-icon="check" data-icon-size="m" data-icon-type="bg" aria-hidden="true" class="swl-cell-bg">&nbsp;</span></td></tr><tr><td>機能D</td><td><span data-icon-type="bg" data-icon="line" data-icon-size="m" aria-hidden="true" class="swl-cell-bg">&nbsp;</span></td><td><span data-icon="check" data-icon-size="m" data-icon-type="bg" aria-hidden="true" class="swl-cell-bg">&nbsp;</span></td></tr><tr><td>機能E</td><td><span data-icon-type="bg" data-icon="line" data-icon-size="m" aria-hidden="true" class="swl-cell-bg">&nbsp;</span></td><td><span data-icon="check" data-icon-size="m" data-icon-type="bg" aria-hidden="true" class="swl-cell-bg">&nbsp;</span></td></tr><tr><td>機能F</td><td><span data-icon-type="bg" data-icon="line" data-icon-size="m" aria-hidden="true" class="swl-cell-bg">&nbsp;</span></td><td><span data-icon="check" data-icon-size="m" data-icon-type="bg" aria-hidden="true" class="swl-cell-bg">&nbsp;</span></td></tr><tr><td></td><td><span class="swl-inline-btn is-style-btn_normal blue_"><a href="###">無料ではじめる</a></span></td><td><span class="swl-inline-btn is-style-btn_normal red_"><a href="###">購入はこちら</a></span></td></tr></tbody></table></figure>
<!-- /wp:table -->';

register_block_pattern(
	'swell-pattern/table-02',
	[
		'title'         => __( '料金プラン比較表', 'swell' ),
		'content'       => $table02,
		'description'   => '',
		'viewportWidth' => 900,
		'categories'    => [ $pattern_category ],
		'keywords'      => [ 'table', 'テーブル', '表' ],
		// 'blockTypes'    => [ 'core/table' ],
	]
);



/**
 *
 */
$table03 = '<!-- wp:table {"className":"is-all-centered td_to_th_ is-style-simple","swlScrollable":"sp"} -->
<figure class="wp-block-table is-all-centered td_to_th_ is-style-simple"><table><thead><tr><th> </th><th><img class="wp-image-1308" style="width: 80px;" src="' . $noimg . '" alt=""><br><span class="swl-fz u-fz-xs">商品A</span></th><th><img class="wp-image-1308" style="width: 80px;" src="' . $noimg . '" alt=""><br><span class="swl-fz u-fz-xs">商品B</span></th><th><img class="wp-image-1308" style="width: 80px;" src="' . $noimg . '" alt=""><br><span class="swl-fz u-fz-xs">商品C</span></th></tr></thead><tbody><tr><td>機能A</td><td><span data-icon="triangle" data-icon-size="l" data-icon-type="bg" aria-hidden="true" class="swl-cell-bg">&nbsp;</span>少し古い</td><td>普通</td><td><span data-icon="doubleCircle" data-icon-size="l" data-icon-type="bg" aria-hidden="true" class="swl-cell-bg">&nbsp;</span>最新機能</td></tr><tr><td>機能B</td><td><span data-icon="close" data-icon-size="l" data-icon-type="bg" aria-hidden="true" class="swl-cell-bg">&nbsp;</span>非対応</td><td><span data-icon="triangle" data-icon-size="l" data-icon-type="bg" aria-hidden="true" class="swl-cell-bg">&nbsp;</span>制限付き</td><td><span data-icon="circle" data-icon-size="l" data-icon-type="bg" aria-hidden="true" class="swl-cell-bg">&nbsp;</span>使用可</td></tr><tr><td>性能A</td><td><span data-icon="triangle" data-icon-size="l" data-icon-type="bg" aria-hidden="true" class="swl-cell-bg">&nbsp;</span>200<span class="swl-fz u-fz-xs">[単位]</span></td><td>500<span class="swl-fz u-fz-xs">[単位]</span></td><td><span data-icon="doubleCircle" data-icon-size="l" data-icon-type="bg" aria-hidden="true" class="swl-cell-bg">&nbsp;</span>1000<span class="swl-fz u-fz-xs">[単位]</span></td></tr><tr><td>性能B</td><td>500<span class="swl-fz u-fz-xs">[単位]</span></td><td><span data-icon="doubleCircle" data-icon-size="l" data-icon-type="bg" aria-hidden="true" class="swl-cell-bg">&nbsp;</span>1000<span class="swl-fz u-fz-xs">[単位]</span></td><td><span data-icon="circle" data-icon-size="l" data-icon-type="bg" aria-hidden="true" class="swl-cell-bg">&nbsp;</span>800<span class="swl-fz u-fz-xs">[単位]</span></td></tr><tr><td>デザイン</td><td>普通</td><td><span data-icon="circle" data-icon-size="l" data-icon-type="bg" aria-hidden="true" class="swl-cell-bg">&nbsp;</span>良い</td><td><span data-icon="triangle" data-icon-size="l" data-icon-type="bg" aria-hidden="true" class="swl-cell-bg">&nbsp;</span>微妙</td></tr><tr><td>価格</td><td>5,000円</td><td>10,000円</td><td>15,000円</td></tr><tr><td></td><td><span class="swl-inline-btn is-style-btn_solid red_"><a href="###">購入する</a></span></td><td><span class="swl-inline-btn is-style-btn_solid red_"><a href="###">購入する</a></span></td><td><span class="swl-inline-btn is-style-btn_solid red_"><a href="###">購入する</a></span></td></tr></tbody></table><figcaption>各製品の比較</figcaption></figure>
<!-- /wp:table -->';

register_block_pattern(
	'swell-pattern/table-03',
	[
		'title'         => __( '商品比較表', 'swell' ),
		'content'       => $table03,
		'description'   => '',
		'viewportWidth' => 900,
		'categories'    => [ $pattern_category ],
		'keywords'      => [ 'table', 'テーブル', '表' ],
		// 'blockTypes'    => [ 'core/table' ],
	]
);


/**
 *
 */
$table04 = '<!-- wp:table {"className":"is-all-centered td_to_th_","swlScrollable":"sp","swlHeadColor":{"text":"black","slug":"swl-gray"},"swlBodyThColor":{"text":"black","slug":"swl-gray"}} -->
<figure class="wp-block-table is-all-centered td_to_th_"><table><thead><tr><th> </th><th><img class="wp-image-1308" style="width: 80px;" src="' . $noimg . '" alt=""><br><span class="swl-fz u-fz-xs">商品A</span></th><th><img class="wp-image-1308" style="width: 80px;" src="' . $noimg . '" alt=""><br><span class="swl-fz u-fz-xs">商品B</span></th><th><img class="wp-image-1308" style="width: 80px;" src="' . $noimg . '" alt=""><br><span class="swl-fz u-fz-xs">商品C</span></th></tr></thead><tbody><tr><td>機能A</td><td><span data-icon-type="bg" data-icon="triangle" data-icon-size="s" aria-hidden="true" class="swl-cell-bg">&nbsp;</span>少し古い</td><td>普通</td><td><span data-icon-size="s" data-icon-type="bg" data-icon="doubleCircle" style="--the-cell-bg: #fffbf8" data-text-color="black" aria-hidden="true" class="swl-cell-bg">&nbsp;</span>最新版</td></tr><tr><td>機能B</td><td><span data-icon-size="s" data-icon-type="bg" data-icon="close" style="--the-cell-bg: #fff6f6" data-text-color="black" aria-hidden="true" class="swl-cell-bg">&nbsp;</span>非対応</td><td><span data-icon-type="bg" data-icon="triangle" data-icon-size="s" aria-hidden="true" class="swl-cell-bg">&nbsp;</span>制限付き</td><td><span data-icon-size="s" data-icon-type="bg" data-icon="circle" aria-hidden="true" class="swl-cell-bg">&nbsp;</span>使用可</td></tr><tr><td>性能A</td><td><span data-icon-type="bg" data-icon="triangle" data-icon-size="s" aria-hidden="true" class="swl-cell-bg">&nbsp;</span>200<span class="swl-fz u-fz-xs">[単位]</span></td><td>500<span class="swl-fz u-fz-xs">[単位]</span></td><td><span data-icon-size="s" data-icon-type="bg" data-icon="doubleCircle" style="--the-cell-bg: #fffbf8" data-text-color="black" aria-hidden="true" class="swl-cell-bg">&nbsp;</span>1000<span class="swl-fz u-fz-xs">[単位]</span></td></tr><tr><td>性能B</td><td>500<span class="swl-fz u-fz-xs">[単位]</span></td><td><span data-icon-size="s" data-icon-type="bg" data-icon="doubleCircle" style="--the-cell-bg: #fffbf8" data-text-color="black" aria-hidden="true" class="swl-cell-bg">&nbsp;</span>1000<span class="swl-fz u-fz-xs">[単位]</span></td><td><span data-icon-type="bg" data-icon="circle" data-icon-size="s" aria-hidden="true" class="swl-cell-bg">&nbsp;</span>800<span class="swl-fz u-fz-xs">[単位]</span></td></tr><tr><td>デザイン</td><td>普通</td><td><span data-icon-type="bg" data-icon="circle" data-icon-size="s" aria-hidden="true" class="swl-cell-bg">&nbsp;</span>良い</td><td><span data-icon="triangle" data-icon-size="s" data-icon-type="bg" aria-hidden="true" class="swl-cell-bg">&nbsp;</span>微妙</td></tr><tr><td>価格</td><td>5,000円</td><td>10,000円</td><td>15,000円</td></tr><tr><td></td><td><span class="swl-inline-btn is-style-btn_line blue_"><a href="###">購入する</a></span></td><td><span class="swl-inline-btn is-style-btn_line blue_"><a href="###">購入する</a></span></td><td><span class="swl-inline-btn is-style-btn_line blue_"><a href="###">購入する</a></span></td></tr></tbody></table><figcaption>各製品の比較</figcaption></figure>
<!-- /wp:table -->';

register_block_pattern(
	'swell-pattern/table-04',
	[
		'title'         => __( '商品比較表2', 'swell' ),
		'content'       => $table04,
		'description'   => '',
		'viewportWidth' => 900,
		'categories'    => [ $pattern_category ],
		'keywords'      => [ 'table', 'テーブル', '表' ],
		// 'blockTypes'    => [ 'core/table' ],
	]
);


/**
 *
 */
$table05 = '<!-- wp:table {"className":"is-thead-centered is-all-centered--va","swlScrollable":"sp","swlHeadColor":{"text":"black","slug":"swl-gray"}} -->
<figure class="wp-block-table is-thead-centered is-all-centered--va"><table><thead><tr><th class="has-text-align-center" data-align="center">商品</th><th>特徴</th><th class="has-text-align-center" data-align="center">価格</th><th>評価</th></tr></thead><tbody><tr><td class="has-text-align-center" data-align="center"><img class="wp-image-1308" style="width: 80px;" src="' . $noimg . '" alt=""><br>商品A</td><td><span data-icon="circle" class="swl-inline-list">xxxが便利</span><br><span data-icon="circle" class="swl-inline-list">xxxもできる</span><br><span data-icon="close" class="swl-inline-list">xxxはできない</span></td><td class="has-text-align-center" data-align="center">1000円</td><td><span data-icon-size="m" data-icon="doubleCircle" data-icon-type="obj" aria-hidden="true" class="swl-cell-bg">&nbsp;</span><br>[review_stars 4.5/5]</td></tr><tr><td class="has-text-align-center" data-align="center"><img class="wp-image-1308" style="width: 80px;" src="' . $noimg . '" alt=""><br>商品B</td><td><span data-icon="circle" class="swl-inline-list">xxxが便利</span><br><span data-icon="circle" class="swl-inline-list">xxxもできる</span><br><span data-icon="close" class="swl-inline-list">xxxはできない</span></td><td class="has-text-align-center" data-align="center">1000円</td><td><span data-icon="circle" data-icon-size="m" data-icon-type="obj" aria-hidden="true" class="swl-cell-bg">&nbsp;</span><br>[review_stars 4/5]</td></tr><tr><td class="has-text-align-center" data-align="center"><img class="wp-image-1308" style="width: 80px;" src="' . $noimg . '" alt=""><br>商品C</td><td><span data-icon="circle" class="swl-inline-list">xxxが便利</span><br><span data-icon="circle" class="swl-inline-list">xxxもできる</span><br><span data-icon="close" class="swl-inline-list">xxxはできない</span></td><td class="has-text-align-center" data-align="center">1000円</td><td><span data-icon="triangle" data-icon-size="m" data-icon-type="obj" aria-hidden="true" class="swl-cell-bg">&nbsp;</span><br>[review_stars 3/5]</td></tr></tbody></table><figcaption>各製品の比較</figcaption></figure>
<!-- /wp:table -->';

register_block_pattern(
	'swell-pattern/table-05',
	[
		'title'         => __( '商品比較表3', 'swell' ),
		'content'       => $table05,
		'description'   => '',
		'viewportWidth' => 900,
		'categories'    => [ $pattern_category ],
		'keywords'      => [ 'table', 'テーブル', '表' ],
		// 'blockTypes'    => [ 'core/table' ],
	]
);
