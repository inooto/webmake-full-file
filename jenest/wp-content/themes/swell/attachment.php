<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
while ( have_posts() ) :
	the_post();
	$post_data = get_post();
	$img_id    = $post_data->ID;
	$img_cap   = $post_data->post_excerpt;
	$img_data  = wp_get_attachment_image_src( $img_id, 'full' );
	$img_src   = ( false !== $img_data ) ? $img_data[0] : '';
	// $url       = get_permalink( $img_id );
?>
<main id="main_content" class="l-mainContent l-article">
	<div class="l-mainContent__inner">
		<?php SWELL_Theme::get_parts( 'parts/single/post_head' ); ?>

		<?php if ( '' !== $img_src ) : ?>
			<figure class="p-articleThumb">
				<img src="<?=esc_url( $img_src )?>" alt="<?=esc_attr( get_the_title() )?>" class="p-articleThumb__img">
				<figcaption class="p-articleThumb__figcaption"><?=wp_kses_post( $img_cap )?></figcaption>
			</figure>
		<?php endif; ?>

		<div class="post_content">
			<?php the_content(); ?>
		</div>
	</div>
</main>
<?php endwhile; ?>
<?php get_footer(); ?>
