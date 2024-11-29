<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * 投稿一覧リスト（ シンプル型 ）の出力テンプレート
 */
$cat_pos       = $variable['cat_pos'] ?? 'none';
$show_date     = $variable['show_date'] ?? true;
$show_modified = $variable['show_modified'] ?? false;
$show_author   = $variable['show_author'] ?? false;
$h_tag         = $variable['h_tag'] ?? 'h2';

// 投稿情報
$post_data = get_post();
$the_id    = $post_data->ID;
?>
<li class="p-postList__item">
	<a href="<?php the_permalink( $the_id ); ?>" class="p-postList__link">
		<div class="p-postList__body">
			<div class="p-postList__meta">
				<?php
					// 日付
					SWELL_Theme::get_parts( 'parts/post_list/item/date', [
						'show_date'     => $show_date,
						'show_modified' => $show_modified,
					] );

					if ( 'none' !== $cat_pos ) :
						SWELL_Theme::pluggable_parts( 'post_list_category', [
							'post_id' => $the_id,
						] );
					endif;

					// if ( $show_pv ) :
					// 	SWELL_Theme::pluggable_parts( 'post_list_pv', [
					// 		'post_id' => $the_id,
					// 	] );
					// endif;

					if ( $show_author ) :
						SWELL_Theme::pluggable_parts( 'post_list_author', [
							'author_id' => $post_data->post_author,
						] );
					endif;
				?>
			</div>
			<?php
				echo '<' . esc_attr( $h_tag ) . ' class="p-postList__title">';
				the_title();
				echo '</' . esc_attr( $h_tag ) . '>';
			?>
		</div>
	</a>
</li>
