<?php
use \SWELL_THEME\Parts\Post_List;
if ( ! defined( 'ABSPATH' ) ) exit;

// 引数受け取り
$the_id = $variable['post_id'] ?? 0;

// 投稿情報を取得 （ループ中 or ID直接指定でループ外からの呼び出しの２パターンがあることに注意）
$post_data     = $the_id ? get_post( $the_id ) : get_post();
$the_id        = $the_id ?: $post_data->ID;
$the_title     = get_the_title( $the_id );
$show_date     = \SWELL_Theme::get_setting( 'show_related_date' ) ?? true;
$show_modified = \SWELL_Theme::get_setting( 'show_related_mod' ) ?? false;
?>
<li class="p-postList__item">
	<a href="<?php the_permalink( $the_id ); ?>" class="p-postList__link">
		<div class="p-postList__thumb c-postThumb">
			<figure class="c-postThumb__figure">
			<?php
				\SWELL_Theme::get_thumbnail( [
					'post_id' => $the_id,
					'size'    => 'medium',
					'sizes'   => '(min-width: 600px) 320px, 50vw',
					'class'   => 'c-postThumb__img u-obf-cover',
					'echo'    => true,
				] );
			?>
			</figure>
		</div>
		<div class="p-postList__body">
			<div class="p-postList__title"><?=wp_kses( $the_title, \SWELL_Theme::$allowed_text_html )?></div>
				<?php
					if ( $show_date || $show_modified ) {
						echo '<div class="p-postList__meta">';
						\SWELL_Theme::get_parts( 'parts/post_list/item/date', [
							'show_date'     => $show_date,
							'show_modified' => $show_modified,
						] );
						echo '</div>';
					}
				?>
		</div>
	</a>
</li>
