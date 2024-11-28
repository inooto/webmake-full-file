<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$the_id = get_the_ID();
$not_in = [ $the_id ];
$maxnum = apply_filters( 'swell_related_post_maxnum', 8 );

/**
 * 指定された記事を優先的に表示する
 */
$priority_posts = get_post_meta( $the_id, 'swell_meta_related_posts', true ) ?: '';
$priority_list  = '';

if ( $priority_posts ) {
	$priority_posts = explode( ',', $priority_posts );
	$priority_posts = array_map( 'intval', $priority_posts );

	ob_start();
	foreach ( $priority_posts as $the_id ) {
		SWELL_Theme::get_parts( 'parts/post_list/related', [ 'post_id' => $the_id ] );
	}
	$priority_list = ob_get_clean();
	wp_reset_postdata();

	// 続きの処理の準備
	$not_in = array_merge( $not_in, $priority_posts );
	$maxnum = $maxnum - count( $priority_posts );
	$maxnum = $maxnum > 0 ? $maxnum : 0;
}


/**
 * ここから普通に関連記事を取得
 */
$args = [
	'post__not_in'        => $not_in,
	'post_type'           => get_post_type(),
	'post_status'         => 'publish',
	'no_found_rows'       => true,
	'ignore_sticky_posts' => true,
	'orderby'             => SWELL_Theme::get_setting( 'related_post_orderby' ),
];

if ( 'category' === SWELL_Theme::get_setting( 'post_relation_type' ) ) {

	// カテゴリ情報から関連記事をランダムに呼び出す
	$categories = get_the_category( $the_id );
	$cat_array  = [];

	foreach ( $categories as $the_cat ) {
		array_push( $cat_array, $the_cat->cat_ID );
	}
	if ( ! empty( $cat_array ) ) {
		$args['category__in'] = $cat_array;
	}
} else {

	// タグ情報から関連記事をランダムに呼び出す
	$tags      = wp_get_post_tags( $the_id );
	$tag_array = [];

	foreach ( $tags as $the_tag ) {
		array_push( $tag_array, $the_tag->term_id );
	}

	if ( ! empty( $tag_array ) ) {
		$args['tag__in'] = $tag_array;
	}
}

?>
<section class="l-articleBottom__section -related">
	<?php
		echo '<h2 class="l-articleBottom__title c-secTitle">' .
			wp_kses( SWELL_Theme::get_setting( 'related_post_title' ), SWELL_Theme::$allowed_text_html ) .
		'</h2>';

		$list_class = 'p-postList p-relatedPosts -type-' . SWELL_Theme::get_setting( 'related_post_style' );

		// 優先記事だけで一杯の場合
		if ( 0 === $maxnum ) :

		echo '<ul class="' . esc_attr( $list_class ) . '">';

		// 優先的に表示する関連記事
		echo $priority_list; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		echo '</ul>';

		else :

			// クエリ引数はフィルターでカスタマイズ可能
			$args = apply_filters( 'swell_related_post_args', $args );

			// posts_per_page は 優先表示設定によって変わってくるので、swell_related_post_maxnum で調節してください。
			$args['posts_per_page'] = $maxnum; // 0以下にはならないように調節

			// クエリ生成
			$q = new WP_Query( $args );

			if ( '' === $priority_list && ! $q->have_posts() ) :
				// 表示する記事が１つもない時

				$not_founded_text = __( '関連する記事はまだ見つかりませんでした。', 'swell' );
				echo apply_filters( 'swell_related_post_404_text', '<p>' . $not_founded_text . '</p>' ); // phpcs:ignore

			elseif ( $q->have_posts() ) :
				// 表示する記事がある時

				echo '<ul class="' . esc_attr( $list_class ) . '">';

				// 優先的に表示する関連記事
				echo $priority_list; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

				while ( $q->have_posts() ) :
					$q->the_post();
					SWELL_Theme::get_parts( 'parts/post_list/related' );
				endwhile;

				echo '</ul>';

			endif;
			wp_reset_postdata();
		endif;
	?>
</section>
