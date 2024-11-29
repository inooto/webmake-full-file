<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * 記事スライダーの投稿リスト出力テンプレート
 */
$query_args  = $variable['query_args'] ?? [];
$thumb_sizes = $variable['thumb_sizes'] ?? '';

// 表示設定
$show_date     = SWELL_Theme::get_setting( 'ps_show_date' );
$show_modified = SWELL_Theme::get_setting( 'ps_show_modified' );
$show_author   = SWELL_Theme::get_setting( 'ps_show_author' );
$cat_pos       = SWELL_Theme::get_setting( 'pickup_cat_pos' );

// クエリの取得
$the_query = new WP_Query( apply_filters( 'swell_pickup_post_args', $query_args ) );

// 表示枚数
$ps_num_sp = SWELL_Theme::get_setting( 'ps_num_sp' );

?>
<ul class="p-postSlider__postList p-postList swiper-wrapper">
<?php
	$ct = 0;
	while ( $the_query->have_posts() ) :
		$ct++;
		$the_query->the_post();

		$post_data = get_post();
		$the_id    = $post_data->ID;
		$the_title = get_the_title();

		if ( mb_strwidth( $the_title, 'UTF-8' ) > 120 ) :
			$the_title = mb_strimwidth( $the_title, 0, 120, '...', 'UTF-8' );
		endif;
?>
	<li class="p-postList__item swiper-slide">
		<a href="<?php the_permalink( $the_id ); ?>" class="p-postList__link">
			<?php
				SWELL_Theme::get_parts(
					'parts/post_list/item/thumb',
					[
						'post_id'   => $the_id,
						'cat_pos'   => $cat_pos,
						'size'      => 'large',
						'sizes'     => $thumb_sizes,
						'decoding'  => 'async',
						'lazy_type' => $ct > $ps_num_sp ? SWELL_Theme::$lazy_type : 'none',
					]
				);
			?>
			<div class="p-postList__body">
				<h2 class="p-postList__title">
					<?=wp_kses( $the_title, SWELL_Theme::$allowed_text_html )?>
				</h2>
				<div class="p-postList__meta">
					<?php
						// 日付
						SWELL_Theme::get_parts( 'parts/post_list/item/date', [
							'show_date'     => $show_date,
							'show_modified' => $show_modified,
						] );
						if ( 'on_title' === $cat_pos ) :
							SWELL_Theme::pluggable_parts( 'post_list_category', [
								'post_id' => $the_id,
							] );
						endif;

						if ( $show_author ) :
							SWELL_Theme::pluggable_parts( 'post_list_author', [
								'author_id' => $post_data->post_author,
							] );
						endif;
					?>
				</div>
			</div>
		</a>
	</li>
<?php
	endwhile;
	wp_reset_postdata();
?>
</ul>
