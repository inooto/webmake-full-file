<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * 公開日・更新日情報
 */
$show_date     = $variable['show_date'] ?? false;
$show_modified = $variable['show_modified'] ?? false;

if ( ! $show_date && ! $show_modified ) return;

// 投稿日と更新日を取得
$the_id        = get_the_ID();
$date_time     = get_post_datetime( $the_id, 'date' );
$modified_time = get_post_datetime( $the_id, 'modified' );

// 両方表示する設定の場合、更新日は公開日より遅い場合だけ表示
if ( $show_date && $show_modified && false !== $date_time && false !== $modified_time ) {
	$show_modified = ( $date_time->format( 'Ymd' ) < $modified_time->format( 'Ymd' ) ) ? $show_modified : false;
}
?>
<div class="p-postList__times c-postTimes u-thin">
	<?php
		if ( $show_date ) {
			\SWELL_Theme::pluggable_parts( 'postdate', [
				'time' => $date_time,
				'type' => 'posted',
			] );
		}
		if ( $show_modified ) {
			\SWELL_Theme::pluggable_parts( 'postdate', [
				'time' => $modified_time,
				'type' => 'modified',
			] );
		}
	?>
</div>
