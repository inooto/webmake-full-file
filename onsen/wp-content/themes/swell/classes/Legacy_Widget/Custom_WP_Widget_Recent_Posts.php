<?php
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * 「最新の投稿」ウィジェットのフォーマット編集（投稿日をaタグの中へ）
 */
class Custom_WP_Widget_Recent_Posts extends wp_widget_recent_posts {

	// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( '最近の投稿', 'swell' ) : $instance['title'], $instance, $this->id_base );

		if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) ) {
			$number = 10;
		}
		$q = new WP_Query( apply_filters( 'widget_posts_args', [
			'posts_per_page'      => $number,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
		] ) );

		if ( $q->have_posts() ) :
			echo $args['before_widget'];
			if ( $title ) {
				echo $args['before_title'], $title, $args['after_title'];
			}
			echo '<ul>';
			while ( $q->have_posts() ) :
				$q->the_post();
		?>
				<li>
					<a href="<?php the_permalink(); ?>">
						<?php the_title(); ?>
						<?php if ( ! empty( $instance['show_date'] ) ) : ?>
							<span class="recent_entries_date u-thin u-fz-s"><?php the_time( get_option( 'date_format' ) ); ?></span>
						<?php endif; ?>
					</a>
				</li>
			<?php
		endwhile;
			echo '</ul>';
			echo $args['after_widget'];
			wp_reset_postdata();
		endif;
	}
}
