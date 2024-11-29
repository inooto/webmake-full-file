<?php
if ( ! defined( 'ABSPATH' ) ) exit;

use \SWELL_Theme as SWELL;


/**
 * 投稿ページのタイトル部分
 */
$the_id        = get_the_ID();
$posted_time   = get_post_datetime( $the_id, 'date' );
$modified_time = get_post_datetime( $the_id, 'modified' );

$pr_notation_size = SWELL::get_pr_notation_size( $the_id );

?>
<div class="p-articleHead c-postTitle">
	<h1 class="c-postTitle__ttl"><?php the_title(); ?></h1>
	<?php
		// タイトル横に表示する日付
		SWELL::pluggable_parts( 'title_date', [
			'time' => 'modified' === SWELL::get_setting( 'title_date_type' ) ? $modified_time : $posted_time,
		] );
	?>
</div>
<div class="p-articleMetas -top">

	<?php if ( 's' === $pr_notation_size ) : ?>
		<div data-nosnippet class="c-prNotation" data-style="small">
			<i class="icon-info"></i>
			<span><?=wp_kses( SWELL::get_setting( 'pr_notation_s_text' ), SWELL::$allowed_text_html )?></span>
		</div>
	<?php endif; ?>

	<?php
		// ターム
		SWELL::get_parts( 'parts/single/item/term_list', [
			'show_cat' => SWELL::get_setting( 'show_meta_cat' ),
			'show_tag' => SWELL::get_setting( 'show_meta_tag' ),
			'show_tax' => SWELL::get_setting( 'show_meta_tax' ),
		] );

		// 公開日・更新日
		SWELL::get_parts( 'parts/single/item/times', [
			'posted_time'   => SWELL::get_setting( 'show_meta_posted' ) ? $posted_time : null,
			'modified_time' => SWELL::get_setting( 'show_meta_modified' ) ? $modified_time : null,
		] );

		// 著者
		if ( SWELL::get_setting( 'show_meta_author' ) ) :
			$post_data = get_post( $the_id );
			SWELL::pluggable_parts( 'the_post_author', [ 'author_id' => $post_data->post_author ] );
		endif;
	?>
</div>


<?php if ( 'l' === $pr_notation_size ) : ?>
	<?php SWELL::pluggable_parts( 'pr_notation' ); ?>
<?php endif; ?>
