<?php
use \SWELL_THEME\Parts\Post_List;
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * ウィジェットでの投稿リスト出力テンプレート
 */
if ( isset( $variable['query_args'] ) ) {
	// クエリ生成
	$the_query = new \WP_Query( $variable['query_args'] );
} else {
	// クエリに関する情報がない時
	return;
}

// リストの設定情報
$list_args = isset( $variable['list_args'] ) ? $variable['list_args'] : [];

// リストデータ整理
$list_data = Post_List::get_widget_list_data( $list_args );

$li_args  = $list_data['li_args'];
$ul_class = $list_data['ul_class'];


// 表示設定
$show_date  = $li_args['show_date'] ?: false;
$show_cat   = $li_args['show_cat'] ?: false;
$show_views = $li_args['show_views'] ?: false;

// 記事がなかった場合
if ( ! $the_query->have_posts() ) :
	echo '<p>' . esc_html__( '記事が見つかりませんでした。', 'swell' ) . '</p>';
	return;
endif;

// ループ
echo '<ul class="p-postList ' . esc_attr( $ul_class ) . '">';
while ( $the_query->have_posts() ) :
	$the_query->the_post();

	// 投稿データ
	$post_data = get_post();
	$the_id    = $post_data->ID;
	$date      = ( false !== $show_date ) ? mysql2date( get_option( 'date_format' ), $post_data->post_date ) : '';
	?>
	<li class="p-postList__item">
		<a href="<?php the_permalink( $the_id ); ?>" class="p-postList__link">
			<div class="p-postList__thumb c-postThumb">
				<figure class="c-postThumb__figure">
					<?php
						\SWELL_Theme::get_thumbnail( [
							'post_id' => $the_id,
							'sizes'   => '(min-width: 600px) 320px, 50vw',
							'class'   => 'c-postThumb__img u-obf-cover',
							'echo'    => true,
						] );
					?>
				</figure>
			</div>
			<div class="p-postList__body">
				<div class="p-postList__title"><?php the_title(); ?></div>
				<div class="p-postList__meta">
					<?php if ( '' !== $date ) : ?>
						<div class="p-postList__times c-postTimes u-thin">
							<span class="c-postTimes__posted icon-posted"><?=esc_html( $date )?></span>
						</div>
					<?php endif; ?>
					<?php
						if ( false !== $show_cat ) :
							\SWELL_Theme::pluggable_parts( 'post_list_category', [
								'post_id' => $the_id,
							] );
						endif;

						if ( false !== $show_views ) :
							\SWELL_Theme::pluggable_parts( 'post_list_pv', [
								'post_id' => $the_id,
							] );
						endif;
					?>
				</div>
			</div>
		</a>
	</li>
<?php
endwhile;
echo '</ul>';

wp_reset_postdata();
