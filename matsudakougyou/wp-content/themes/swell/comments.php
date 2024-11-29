<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<section id="comments" class="l-articleBottom__section -comment">
	<h2 class="l-articleBottom__title c-secTitle">
		<?=esc_html( SWELL_Theme::get_setting( 'comments_title' ) )?>
	</h2>
	<div class="p-commentArea">
		<?php if ( have_comments() ) : ?>
			<h3 class="p-commentArea__title -for-list">
				<i class="icon-bubbles"></i> <?=esc_html( __( 'コメント一覧', 'swell' ) )?>
				<span>（<?php comments_number( '0', '1', '%' ); ?><?php if ( 'ja' === get_locale() ) echo '件'; ?>）</span>
			</h3>
			<ul class="c-commentList">
				<?php wp_list_comments( 'avatar_size=48' ); ?>
			</ul>
		<?php endif; ?>
		<?php if ( get_comment_pages_count() > 1 ) : ?>
			<div class="c-pagination p-commentArea__pager">
			<?php
				paginate_comments_links( [
					'prev_text' => '&#139',
					'next_text' => '&#155',
					'mid_size'  => 0,
				] );
			?>
			</div>
		<?php endif; ?>
		<?php
			// コメントフォーム呼び出し
			comment_form( [
				'title_reply'          => __( 'コメントする', 'swell' ),
				'label_submit'         => __( 'コメントを送信', 'swell' ),
				'comment_notes_before' => '',
				'comment_notes_after'  => '',
				'title_reply_before'   => '<h3 class="p-commentArea__title -for-write"><i class="icon-pen"></i> ',
				'title_reply_after'    => '</h3>',
			] );
		?>
	</div>
</section>
