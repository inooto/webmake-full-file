<?php
/**
 * ページネーション出力関数
 */

// $the_paged : 現在のページ
if ( isset( $variable['paged'] ) ) {
	$the_paged = $variable['paged'] ?: 1;
} else {
	$the_paged = get_query_var( 'paged' ) ?: 1;
}

// $the_pages : 全ページ数
if ( isset( $variable['pages'] ) ) {
	$the_pages = (int) $variable['pages'] ?: 0;
} else {
	global $wp_query;
	$the_pages = (int) $wp_query->max_num_pages;
}

// 記事がない時
if ( 0 === $the_pages ) return;

// 表示テキスト
// $text_first = '1';  // "«";
$text_last = '' . $the_pages;  // "»";
$show_only = true; // 1ページしかない時に表示するかどうか
$range     = apply_filters( 'swell_pager_range', 2 ); // 左右に何ページ表示するか

// １ページのみで表示設定もない場合は 何も出力しない
if ( ! $show_only && 1 === $the_pages ) return '';

?>
<div class="c-pagination">
<?php
	// １ページのみで表示設定が true の時
	if ( 1 === $the_pages ) :
		echo '<span class="page-numbers current">1</span>';
	else :
		// 「最初へ」
		if ( $the_paged > $range + 1 ) :
			echo '<a href="' . esc_url( get_pagenum_link( 1 ) ) . '" class="page-numbers -to-first">1</a>';
			echo '<span class="c-pagination__dot">...</span>';
		endif;

		for ( $i = 1; $i <= $the_pages; $i++ ) :
			// 今のページからどれだけ離れた番号か
			$apart = $i - $the_paged;

			// 直前・直後のページへのリンクには専用のクラスを追加
			$add_class = '';
			if ( 1 === $apart ) {
				$add_class = ' -to-next';
			} elseif ( -1 === $apart ) {
				$add_class = ' -to-prev';
			}

			// 絶対値を取得
			$apart = abs( $i - $the_paged );

			if ( 0 === $apart ) :
				echo '<span class="page-numbers current">' . esc_html( $i ) . '</span>';
			elseif ( $apart <= $range ) :
				echo '<a href="' . esc_url( get_pagenum_link( $i ) ) . '" class="page-numbers' . esc_attr( $add_class ) . '" data-apart="' . esc_attr( $apart ) . '">' . esc_html( $i ) . '</a>';
			endif;
		endfor;

		// 「最後へ」
		if ( $the_paged + $range < $the_pages ) :
			echo '<span class="c-pagination__dot">...</span>';
			echo '<a href="' . esc_url( get_pagenum_link( $the_pages ) ) . '" class="page-numbers -to-last">' . esc_html( $the_pages ) . '</a>';
		endif;
	endif;
?>
</div>
