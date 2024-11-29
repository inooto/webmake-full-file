<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$SETTING = SWELL_Theme::get_setting();

// タブリスト
$tab_list = [];

// 各種タブを表示するかどうか
$show_new_tab     = $SETTING['show_new_tab'];
$show_ranking_tab = $SETTING['show_ranking_tab'];

// タブに表示するタームの処理
$tab_terms_id   = ( ! empty( $SETTING['top_tab_terms'] ) ) ? explode( ',', $SETTING['top_tab_terms'] ) : [];
$tab_terms_data = [];
foreach ( $tab_terms_id as $term_id ) :
	$term_id   = (int) $term_id;
	$term_data = get_term( $term_id );
	if ( ! empty( $term_data ) && ! is_wp_error( $term_data ) ) :
		$tab_terms_data[] = [
			'id'    => $term_id,
			'name'  => $term_data->name,
			'tax'   => $term_data->taxonomy,
			'count' => $term_data->count,
		];
	endif;
endforeach;

// 除外タグ
$exc_tag = explode( ',', $SETTING['exc_tag_id'] );

// タブリスト
$tabIndex     = 0;
$newTabIndex  = 0;
$rankTabIndex = 0;
if ( $show_new_tab ) {
	$tab_list[]  = $SETTING['new_tab_title'];
	$newTabIndex = ++$tabIndex;
}
if ( $show_ranking_tab ) {
	$tab_list[]   = $SETTING['ranking_tab_title'];
	$rankTabIndex = ++$tabIndex;
}
if ( ! empty( $tab_terms_data ) ) {
	foreach ( $tab_terms_data as $the_term ) {
		$tab_list[] = $the_term['name'];
	}
}
if ( count( $tab_list ) > 1 ) {
	// @codingStandardsIgnoreStart
	echo SWELL_PARTS::tab_list(
		$tab_list,
		$SETTING['top_tab_style'],
		'post_list_tab_'
	);
	// @codingStandardsIgnoreEnd
}
?>
<div class="c-tabBody p-postListTabBody">
<?php
	// 新着記事一覧
	if ( $show_new_tab ) :
		$is_hidden = 1 === $newTabIndex ? 'false' : 'true';
?>
		<div id="post_list_tab_<?=esc_attr( (string) $newTabIndex )?>" class="c-tabBody__item" aria-hidden="<?=esc_attr( $is_hidden )?>">
		<?php
			SWELL_Theme::get_parts( 'parts/post_list/loop_main' );
			SWELL_Theme::get_parts( 'parts/post_list/item/pagination' );
		?>
		</div>
<?php endif; ?>
<?php
	// 人気記事一覧
	if ( $show_ranking_tab ) :
		$is_hidden = 1 === $rankTabIndex ? 'false' : 'true';
	?>
		<div id="post_list_tab_<?=esc_attr( (string) $rankTabIndex )?>" class="c-tabBody__item" aria-hidden="<?=esc_attr( $is_hidden )?>">
		<?php
			// 人気記事一覧
			$q_args = [
				'post_type'           => 'post',
				'post_status'         => 'publish', // 非公開時期の投稿がキャッシュされないように
				'no_found_rows'       => true,
				'ignore_sticky_posts' => 1,
				'meta_key'            => SWELL_CT_KEY,
				'orderby'             => 'meta_value_num',
				'order'               => 'DESC',
			];
			if ( ! empty( $exc_tag ) ) {
				$q_args['tag__not_in'] = $exc_tag;
			}
			SWELL_Theme::get_parts( 'parts/post_list/loop_sub', [ 'query_args' => $q_args ] );
		?>
		</div>
<?php endif; ?>
<?php
	// カテゴリーごとのリスト
	if ( ! empty( $tab_terms_data ) ) :
	foreach ( $tab_terms_data as $t ) :
		$termTabIndex = ++$tabIndex;
		$is_hidden    = 1 === $termTabIndex ? 'false' : 'true';
	?>
		<div id="post_list_tab_<?=esc_attr( (string) $termTabIndex )?>" class="c-tabBody__item" aria-hidden="<?=esc_attr( $is_hidden ) ?>">
		<?php
			$q_args = [
				'post_type'           => 'post',
				'post_status'         => 'publish', // 非公開時期の投稿がキャッシュされないように
				'no_found_rows'       => true,
				'ignore_sticky_posts' => 1,
				'tax_query'           => [
					[
						'taxonomy'         => $t['tax'],
						'field'            => 'id',
						'terms'            => [ $t['id'] ],
						'operator'         => 'IN',
						'include_children' => true,
					],
				],
			];
			if ( ! empty( $exc_tag ) ) {
				$q_args['tag__not_in'] = $exc_tag;
			}

			// 投稿数を取得したいので、ここでWP_Query生成
			$the_query       = new WP_Query( $q_args );
			$the_query_count = $the_query->post_count;

			// 投稿リスト
			SWELL_Theme::get_parts( 'parts/post_list/loop_sub', [ 'query' => $the_query ] );

			// MORE ボタン
			$cat_url        = get_term_link( $t['id'], $t['tax'] );
			$has_more_posts = get_option( 'posts_per_page' ) < $t['count'];
			if ( $has_more_posts && $cat_url ) :
				$page2_url = false === strpos( $cat_url, '/?' ) ? $cat_url . '/page/2/' : $cat_url . '&paged=2';
				$page2_url = str_replace( '//page', '/page', $page2_url );
			?>
				<div class="c-pagination c-tabBody__pager">
					<a href="<?=esc_url( $page2_url )?>" class="page-numbers">
						<span class="c-tabBody__moreText"><?=esc_html__( 'MORE', 'swell' )?></span>&#155
					</a>
				</div>
			<?php endif; ?>
		</div>
	<?php
	endforeach;
	endif;
?>
</div>
