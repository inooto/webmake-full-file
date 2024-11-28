<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * SWELL_Theme::is_show_ttltop()が true の時のみ呼び出される。
 * タームアーカイブ / 固定ページ / 投稿ページの３種類で呼び出される可能性があることに注意。
 */
$SETTING = SWELL_Theme::get_setting();

// タイトル・背景画像を取得
if ( SWELL_Theme::is_term() ) {
	// タームアーカイブの場合
	$term_id   = get_queried_object_id();
	$ttlbg_id  = SWELL_Theme::get_term_ttlbg_id( $term_id );
	$ttlbg_url = '';
	if ( is_string( $ttlbg_id ) ) {
		$ttlbg_url = $ttlbg_id; // 昔はURLデータを保存してた
	}
} else {
	// 投稿ページ・固定ページの場合
	$the_id    = get_queried_object_id();  // ※ get_the_ID() は is_home でアウト
	$ttlbg_id  = SWELL_Theme::get_post_ttlbg_id( $the_id );
	$ttlbg_url = '';
	if ( is_string( $ttlbg_id ) ) {
		$ttlbg_url = $ttlbg_id; // 昔はURLデータを保存してた
	}
}

// 背景画像へのフィルター
$filter_name  = $SETTING['title_bg_filter'];
$filter_class = ( 'nofilter' === $filter_name ) ? '' : "c-filterLayer -$filter_name";
?>
<div id="top_title_area" class="l-topTitleArea <?=esc_attr( $filter_class )?>">
	<?php
		if ( $ttlbg_url ) {
			echo '<img src="' . esc_attr( $ttlbg_url ) . '" class="l-topTitleArea__img c-filterLayer__img u-obf-cover" decoding="async">';
		} elseif ( $ttlbg_id ) {
			SWELL_Theme::get_image( $ttlbg_id, [
				'class'       => 'l-topTitleArea__img c-filterLayer__img u-obf-cover',
				'alt'         => '',
				'loading'     => apply_filters( 'swell_top_area_lazy_off', true ) ? 'none' : SWELL_Theme::$lazy_type,
				'aria-hidden' => 'true',
				'decoding'    => 'async',
				'echo'        => true,
			]);
		}
	?>
	<div class="l-topTitleArea__body l-container">
		<?php
			if ( SWELL_Theme::is_term() ) {

				SWELL_Theme::pluggable_parts( 'term_title', [
					'term_id'   => $term_id,
					'has_inner' => false,
				] );

				SWELL_PARTS::the_term_navigation( $term_id );

			} elseif ( is_single() ) {

				SWELL_Theme::get_parts( 'parts/single/post_head' );

			} elseif ( is_page() || is_home() ) {

				// タイトル
				SWELL_Theme::pluggable_parts( 'page_title', [
					'title'     => get_the_title( $the_id ),
					'subtitle'  => get_post_meta( $the_id, 'swell_meta_subttl', true ),
					'has_inner' => false,
				] );

				// 抜粋文
				$post_data = get_post( $the_id );
				$excerpt   = $post_data->post_excerpt;
				if ( $excerpt ) {
					echo '<div class="c-pageExcerpt">' . wp_kses( $excerpt, SWELL_Theme::$allowed_text_html ) . '</div>';
				}
			}
		?>
	</div>
</div>
