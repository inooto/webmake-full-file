<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * 投稿一覧リストの出力テンプレート
 */
$list_type      = $variable['list_type'] ?? SWELL_Theme::$list_type;
$thumb_sizes    = $variable['thumb_sizes'] ?? '';
$cat_pos        = $variable['cat_pos'] ?? 'none';
$show_title     = $variable['show_title'] ?? true;
$show_date      = $variable['show_date'] ?? true;
$show_modified  = $variable['show_modified'] ?? false;
$show_pv        = $variable['show_pv'] ?? false;
$show_author    = $variable['show_author'] ?? false;
$excerpt_length = $variable['excerpt_length'] ?? 0;

// 投稿情報
$post_data     = get_post();
$the_id        = $post_data->ID;
$date_time     = get_post_datetime( $the_id, 'date' );
$modified_time = get_post_datetime( $the_id, 'modified' );

// 両方表示する設定の場合、更新日は公開日より遅い場合だけ表示
if ( $show_date && $show_modified && false !== $date_time && false !== $modified_time ) {
	$show_modified = ( $date_time->format( 'Ymd' ) < $modified_time->format( 'Ymd' ) ) ? $show_modified : false;
}

// 抜粋文
$excerpt = SWELL_Theme::get_excerpt( $post_data );

?>
<li class="p-postList__item">
	<a href="<?php the_permalink( $the_id ); ?>" class="p-postList__link">
		<div class="c-postTitle">
			<h2 class="c-postTitle__ttl"><?php the_title(); ?></h2>
			<?php if ( $show_date ) \SWELL_Theme::pluggable_parts( 'title_date', [ 'time' => $date_time ] ); ?>
		</div>
		<?php
			SWELL_Theme::get_parts( 'parts/post_list/item/thumb', [
				'post_id'  => $the_id,
				'cat_pos'  => $cat_pos,
				'size'     => 'full',
				'sizes'    => $thumb_sizes,
			] );
		?>
		<div class="p-postList__body">
			<div class="p-postList__meta">
				<?php
					if ( $show_modified ) {
						\SWELL_Theme::pluggable_parts( 'postdate', [
							'time' => $modified_time,
							'type' => 'modified',
						] );
					}

					if ( 'beside_date' === $cat_pos ) {
						SWELL_Theme::pluggable_parts( 'post_list_category', [ 'post_id' => $the_id ] );
					}

					if ( $show_pv ) {
						SWELL_Theme::pluggable_parts( 'post_list_pv', [ 'post_id' => $the_id ] );
					}

					if ( $show_author ) {
						SWELL_Theme::pluggable_parts( 'post_list_author', [ 'author_id' => $post_data->post_author ] );
					}
				?>
			</div>
			<?php if ( ! empty( $excerpt ) ) : ?>
				<div class="p-postList__excerpt">
					<?php echo $excerpt; // phpcs:ignore WordPress.Security.EscapeOutput ?>
				</div>
			<?php endif; ?>
		</div>
	</a>
</li>
