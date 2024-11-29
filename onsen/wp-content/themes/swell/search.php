<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

// リストタイプ
$list_type = apply_filters( 'swell_post_list_type_on_search', SWELL_Theme::$list_type );
?>
<main id="main_content" class="l-mainContent l-article">
	<div class="l-mainContent__inner">
		<?php
			SWELL_Theme::pluggable_parts( 'page_title', [
				'title'     => SWELL_Theme::get_search_title(),
				'has_inner' => true,
			] );
		?>
		<div class="p-searchContent u-mt-40">
			<?php
				// 新着投稿一覧 ( Main loop )
				SWELL_Theme::get_parts( 'parts/post_list/loop_main', ['type' => $list_type ] );
				SWELL_Theme::get_parts( 'parts/post_list/item/pagination' );
			?>
		</div>
	</div>
</main>
<?php get_footer(); ?>
