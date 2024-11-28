<?php
use \SWELL_THEME\Parts\Post_List;
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * サブループでの投稿リスト出力テンプレート
 */
if ( isset( $variable['query'] ) ) {
	// すでにクエリが生成済みの場合
	$the_query = $variable['query'];

} elseif ( isset( $variable['query_args'] ) ) {
	// クエリ生成
	$the_query = new \WP_Query( $variable['query_args'] );
} else {
	// クエリに関する情報がない時
	return;
}

// リストの設定情報
$list_args = isset( $variable['list_args'] ) ? $variable['list_args'] : [];

// リストデータ整理
$list_data = Post_List::get_list_data( $list_args );

$li_args         = $list_data['li_args'];
$ul_class        = $list_data['ul_class'];
$parts_name      = $list_data['parts_name'];
$infeed_interval = $list_data['infeed_interval'];


// 記事がなかった場合
if ( ! $the_query->have_posts() ) :
	$not_founded_text = __( '記事が見つかりませんでした。', 'swell' );
	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo apply_filters( 'swell_posts_404_text', '<p>' . $not_founded_text . '</p>' );
	return;
endif;

// ループ
$loop_ct = 0;
echo '<ul class="' . esc_attr( $ul_class ) . '">';
while ( $the_query->have_posts() ) :
	$the_query->the_post();

	// インフィード
	if ( $infeed_interval && $loop_ct && ( 0 === $loop_ct % $infeed_interval ) ) :
		SWELL_Theme::get_parts( 'parts/post_list/infeed_ad', $loop_ct );
		endif;

	SWELL_Theme::get_parts( 'parts/post_list/' . $parts_name, $li_args );

	$loop_ct++;
endwhile;
echo '</ul>';

wp_reset_postdata();
