<?php
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

if ( SWELL_Theme::is_term() ) :
	SWELL_Theme::get_parts( 'archive-term' );
else :
	$archive_data     = SWELL_Theme::get_archive_data();
	$archive_title    = $archive_data['title'];
	$archive_subtitle = str_replace( 'pt_archive', 'archive', $archive_data['type'] );

	// リストタイプ
	$list_type = apply_filters( 'swell_post_list_type_on_archive', SWELL_Theme::$list_type, $archive_data );
?>
<main id="main_content" class="l-mainContent l-article">
	<div class="l-mainContent__inner">
		<?php
			SWELL_Theme::pluggable_parts( 'page_title', [
				'title'     => $archive_title,
				'subtitle'  => $archive_subtitle,
				'has_inner' => true,
			] );
		?>
		<div class="p-archiveContent u-mt-40">
			<?php
				// 新着投稿一覧 ( Main loop )
				SWELL_Theme::get_parts( 'parts/post_list/loop_main', ['type' => $list_type ] );
				SWELL_Theme::get_parts( 'parts/post_list/item/pagination' );
			?>
		</div>
	</div>
</main>
<?php endif;
get_footer(); ?>
