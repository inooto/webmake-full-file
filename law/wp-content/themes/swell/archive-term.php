<?php
if ( ! defined( 'ABSPATH' ) ) exit;
// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped

/**
 * ターム系アーカイブ用の独自テンプレートファイル
 */
$SETTING = SWELL_Theme::get_setting();
$wp_obj  = get_queried_object();
$term_id = $wp_obj->term_id;

// 記事リストを表示するか
$is_show_list = get_term_meta( $term_id, 'swell_term_meta_show_list', 1 );
$is_show_list = ( '0' !== $is_show_list );   // 標準：オン

// タブ分けするかどうか
$is_show_tab    = $SETTING['show_tab_on_term'];
$meta_show_rank = get_term_meta( $term_id, 'swell_term_meta_show_rank', 1 );
if ( '1' === $meta_show_rank ) { // '1' なのは過去の設定を引き継ぐため
	$is_show_tab = true;
} elseif ( 'none' === $meta_show_rank ) {
	$is_show_tab = false;
}

// リストタイプ
$list_type = get_term_meta( $term_id, 'swell_term_meta_list_type', 1 ) ?: \SWELL_Theme::$list_type;
$list_type = apply_filters( 'swell_post_list_type_on_term', $list_type, $term_id );

?>
<main id="main_content" class="l-mainContent l-article">
	<div class="l-mainContent__inner">
		<?php
			if ( ! SWELL_Theme::is_show_ttltop() ) :
				\SWELL_Theme::pluggable_parts( 'term_title', [
					'term_id'   => $term_id,
					'has_inner' => true,
				] );
				SWELL_PARTS::the_term_navigation( $term_id );
			endif;

			// PR表記
			if ( get_term_meta( $term_id, 'swell_term_meta_show_pr_notation', 1 ) ) {
				SWELL_Theme::pluggable_parts( 'pr_notation' );
			}

			// 説明文・アイキャッチ
			SWELL_Theme::get_parts( 'parts/archive/term_head', [
				'term_id'     => $term_id,
				'description' => $wp_obj->description,
			] );
		?>
		<div class="p-termContent l-parent">
		<?php
			// ブログパーツ
			$parts_id = get_term_meta( $term_id, 'swell_term_meta_display_parts', 1 );
			if ( ! empty( $parts_id ) ) :
				$is_hide_parts_paged = get_term_meta( $term_id, 'swell_term_meta_hide_parts_paged', 1 );
				if ( ! ( $is_hide_parts_paged && is_paged() ) ) :
					echo apply_filters( 'the_content', '[blog_parts id="' . $parts_id . '"]' );
				endif;
			endif;

			// 記事一覧
			if ( $is_show_list ) :

				// タブ切り替えリスト
				if ( $is_show_tab ) :
					$tab_list = [
						$SETTING['new_tab_title'], // 新着記事一覧のタイトル
						$SETTING['ranking_tab_title'], // 人気記事一覧のタイトル
					];
					// @codingStandardsIgnoreStart
					echo SWELL_PARTS::tab_list(
						$tab_list,
						$SETTING['top_tab_style'],
						'post_list_tab_'
					);
					// @codingStandardsIgnoreEnd
				endif;
		?>
			<div class="c-tabBody p-postListTabBody">
				<div id="post_list_tab_1" class="c-tabBody__item" aria-hidden="false">
				<?php
				// 新着投稿一覧 ( Main loop )
				SWELL_Theme::get_parts( 'parts/post_list/loop_main', ['type' => $list_type ] );
				SWELL_Theme::get_parts( 'parts/post_list/item/pagination' );
				?>
				</div>
				<?php if ( $is_show_tab ) : // 人気記事一覧タブ ?>
					<div id="post_list_tab_2" class="c-tabBody__item" aria-hidden="true">
						<?php
							$q_args = [
								'post_type'           => 'post',
								'no_found_rows'       => true,
								'ignore_sticky_posts' => 1,
								'meta_key'            => SWELL_CT_KEY,
								'orderby'             => 'meta_value_num',
								'order'               => 'DESC',
							];

							if ( isset( $wp_obj->cat_ID ) ) {
								$q_args['cat'] = $term_id;
							} else {
								$tax_query           = [
									'relation' => 'AND',
									[
										'taxonomy' => $wp_obj->taxonomy,
										'field'    => 'id',
										'terms'    => $term_id,
										'operator' => 'IN',
									],
								];
								$q_args['tax_query'] = $tax_query;
							}

							// 新着投稿一覧 ( Sub loop )
							$parts_args = [
								'query_args' => $q_args,
								'list_args'  => ['type' => $list_type ],
							];
							SWELL_Theme::get_parts( 'parts/post_list/loop_sub', $parts_args );
						?>
					</div>
				<?php endif; ?>
				</div>
			<?php endif; // is_show_list ?>
		</div>
	</div>
</main>
