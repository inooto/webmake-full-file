<?php
/**
 * RSSリストの出力テンプレート
 *   $args['rss_items'] : 各記事の情報
 *   $args['list_args'] : リストの表示に関する設定値
 */
$args      = $variable;
$rss_items = isset( $args['rss_items'] ) ? $args['rss_items'] : [];
$list_args = isset( $args['list_args'] ) ? $args['list_args'] : [];

if ( empty( $rss_items ) ) return;

// リストタイプ
$list_type = isset( $list_args['list_type'] ) ? $list_args['list_type'] : \SWELL_Theme::$list_type;

// リストスタイルによって読み込むファイル名を振り分ける
$file_name = ( 'simple' === $list_type ) ? 'simple' : 'normal';

$ul_class = 'is-rss -type-' . $list_type;
// 最大カラム数
if ( 'card' === $list_type ) {
	$ul_class .= ' -pc-col' . $list_args['pc_col'];
	$ul_class .= ' -sp-col' . $list_args['sp_col'];
}

// ループのカウント用変数
$loop_count = 0;

$list_count_pc = $list_args['list_count_pc'];
$list_count_sp = $list_args['list_count_sp'];

$min        = min( $list_count_pc, $list_count_sp );
$max        = max( $list_count_pc, $list_count_sp );
$list_class = $min === $list_count_pc ? 'sp_only' : 'pc_only';

?>
<ul class="p-postList <?=esc_attr( $ul_class )?>">
	<?php
	foreach ( $rss_items as $feed_data ) {
		$loop_count++;

		if ( $max < $loop_count ) {
			break;
		} elseif ( $min < $loop_count ) {
			$list_args['list_class'] = $list_class;
		}

		$list_args['count'] = $loop_count;

		\SWELL_Theme::get_parts( 'parts/post_list/style/rss_' . $file_name, [
			'list_args' => $list_args,
			'feed_data' => $feed_data,
		] );
	}
?>
</ul>
