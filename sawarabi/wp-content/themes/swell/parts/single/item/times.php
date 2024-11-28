<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$posted_time   = $variable['posted_time'] ?? null;
$modified_time = $variable['modified_time'] ?? null;

// どちらも表示しない場合は終了
if ( ! $posted_time && ! $modified_time ) return;

// 両方表示する場合、更新日は公開日より遅い場合だけ表示
if ( $posted_time && $modified_time && ( $posted_time->format( 'Ymd' ) >= $modified_time->format( 'Ymd' ) ) ) {
	$modified_time = null;
}

?>
<div class="p-articleMetas__times c-postTimes u-thin">
	<?php
		if ( $posted_time ) {
			\SWELL_Theme::pluggable_parts( 'postdate', [
				'time' => $posted_time,
				'type' => 'posted',
			] );
		}
		if ( $modified_time ) {
			\SWELL_Theme::pluggable_parts( 'postdate', [
				'time' => $modified_time,
				'type' => 'modified',
			] );
		}
	?>
</div>
