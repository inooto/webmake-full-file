<?php
/**
 * Template Name:人気記事一覧
 */
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
while ( have_posts() ) :
	the_post();
	$the_id = get_the_ID();
?>
<main id="main_content" class="l-mainContent l-article">
	<div class="l-mainContent__inner">
		<?php SWELL_Theme::get_parts( 'parts/page_head' ); ?>
		<div class="<?=esc_attr( apply_filters( 'swell_post_content_class', 'post_content' ) )?>">
			<?php the_content(); ?>
		</div>
		<div class="p-pupularContent u-mt-40">
			<?php
				$the_paged = get_query_var( 'paged' ) ?: 1;
				$args      = [
					'paged'               => $the_paged,
					'post_type'           => 'post',
					'ignore_sticky_posts' => 1,
					'meta_key'            => SWELL_CT_KEY,
					'orderby'             => 'meta_value_num',
					'order'               => 'DESC',
				];
				$the_query = new WP_Query( $args );

				// 新着投稿一覧 ( Sub loop )
				SWELL_Theme::get_parts( 'parts/post_list/loop_sub', [
					'query'     => $the_query,
					'list_args' => ['show_pv' => true ],
				] );
				SWELL_Theme::get_parts( 'parts/post_list/item/pagination', [
					'pages' => $the_query->max_num_pages,
					'paged' => $the_paged,
				] );
			?>
		</div>
		<?php
			// ウィジェット
			SWELL_Theme::outuput_content_widget( 'page', 'bottom' );
		?>
	</div>
</main>
<?php
endwhile;  // End loop
get_footer();
