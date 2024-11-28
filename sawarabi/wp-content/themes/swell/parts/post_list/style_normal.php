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
$h_tag          = $variable['h_tag'] ?? 'h2';


// サムネイル型用
$show_post_text = ( $show_title || $show_date || $show_modified || 'beside_date' === $cat_pos );

// 投稿情報
$post_data = get_post();
$the_id    = $post_data->ID;

// 抜粋文
$excerpt = SWELL_Theme::get_excerpt( $post_data, $excerpt_length );

?>
<li class="p-postList__item">
	<a href="<?php the_permalink( $the_id ); ?>" class="p-postList__link">
		<?php
			// サムネイル
			SWELL_Theme::get_parts(
				'parts/post_list/item/thumb',
				[
					'post_id'  => $the_id,
					'cat_pos'  => $cat_pos,
					'size'     => 'large',
					'sizes'    => $thumb_sizes,
				]
			);
		?>
		<?php if ( $show_post_text ) : ?>
			<div class="p-postList__body">
				<?php
					if ( $show_title ) :
					echo '<' . esc_attr( $h_tag ) . ' class="p-postList__title">';
					the_title();
					echo '</' . esc_attr( $h_tag ) . '>';
					endif;
				?>
				<?php if ( ! empty( $excerpt ) ) : ?>
					<div class="p-postList__excerpt">
						<?php echo $excerpt; // phpcs:ignore WordPress.Security.EscapeOutput ?>
					</div>
				<?php endif; ?>
				<div class="p-postList__meta">
					<?php
						// 日付
						SWELL_Theme::get_parts( 'parts/post_list/item/date', [
							'show_date'     => $show_date,
							'show_modified' => $show_modified,
						] );

						if ( 'beside_date' === $cat_pos ) :
							SWELL_Theme::pluggable_parts( 'post_list_category', [ 'post_id' => $the_id ] );
						endif;

						if ( $show_pv ) :
							SWELL_Theme::pluggable_parts( 'post_list_pv', [ 'post_id' => $the_id ] );
						endif;

						if ( $show_author ) :
							SWELL_Theme::pluggable_parts( 'post_list_author', [ 'author_id' => $post_data->post_author ] );
						endif;
					?>
				</div>
			</div>
		<?php endif; ?>
	</a>
</li>
