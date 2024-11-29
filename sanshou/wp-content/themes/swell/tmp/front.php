<?php
if ( ! defined( 'ABSPATH' ) ) exit;
while ( have_posts() ) :
the_post();
?>
<main id="main_content" class="l-mainContent l-article">
	<div class="l-mainContent__inner">
		<?php
			\SWELL_Theme::outuput_widgets( 'front_top', [
				'before' => '<div class="w-frontTop">',
				'after'  => '</div>',
			] );
		?>
		<div class="<?=esc_attr( apply_filters( 'swell_post_content_class', 'post_content' ) )?>">
			<?php the_content(); ?>
		</div>
		<?php
			// 改ページナビゲーション
			$defaults = [
				'before'           => '<div class="c-pagination -post">',
				'after'            => '</div>',
				'next_or_number'   => 'number',
				// 'pagelink'      => '<span>%</span>',
			];
			wp_link_pages( $defaults );

			\SWELL_Theme::outuput_widgets( 'front_bottom', [
				'before' => '<div class="w-frontBottom">',
				'after'  => '</div>',
			] );
		?>
	</div>
</main>
<?php endwhile; ?>
