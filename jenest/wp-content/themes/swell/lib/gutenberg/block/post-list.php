<?php
namespace SWELL_Theme\Block\Post_List;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * 投稿リストブロック
 */
\SWELL_Theme::register_block( 'post-list', [
	'render_callback' => __NAMESPACE__ . '\cb',
] );

function cb( $attrs, $content ) {
	$args = [
		'post_type'      => $attrs['postType'],
		'type'           => $attrs['listType'],
		'count'          => $attrs['listCount'],
		'ignore_sticky'  => ! $attrs['addSticky'],
		'order'          => $attrs['order'],
		'orderby'        => $attrs['orderby'],
		'max_col'        => $attrs['pcCol'],
		'max_col_sp'     => $attrs['spCol'],
		'more'           => $attrs['moreText'],
		'more_url'       => $attrs['moreUrl'],
		'excerpt_length' => 0,
		'cat_pos'        => $attrs['catPos'],
		'show_title'     => $attrs['showTitle'],
		'show_date'      => $attrs['showDate'],
		'show_modified'  => $attrs['showModified'],
		'show_author'    => $attrs['showAuthor'],
		'show_pv'        => $attrs['showPV'],
		'h_tag'          => $attrs['hTag'],
	];

	// 取得条件
	$args['post_id']        = $attrs['postID'];
	$args['cat_id']         = $attrs['catID'];
	$args['cat_relation']   = $attrs['catRelation'];
	$args['tag_id']         = $attrs['tagID'];
	$args['tag_relation']   = $attrs['tagRelation'];
	$args['taxonomy']       = $attrs['taxName'];
	$args['term_id']        = $attrs['termID'];
	$args['term_relation']  = $attrs['termRelation'];
	$args['query_relation'] = $attrs['queryRelation'];
	$args['inc_children']   = ! $attrs['exCatChildren'];
	$args['author_id']      = $attrs['authorID'];

	// 除外指定
	$args['exc_id'] = $attrs['excID'];

	// 抜粋文の文字数
	$args['excerpt_length'] = ( IS_MOBILE ) ? $attrs['spExcerptLength'] : $attrs['pcExcerptLength'];

	// 最後の投稿を非表示にする設定
	if ( $attrs['pcHideLast'] ) {
		$args['pc_hide_last'] = $attrs['pcHideLast'];
		}
	if ( $attrs['spHideLast'] ) {
		$args['sp_hide_last'] = $attrs['spHideLast'];
		}
	$class_name = $attrs['className'] ?: '';

	ob_start();
	echo '<div class="' . esc_attr( trim( "p-postListWrap $class_name" ) ) . '">';
	\SWELL_THEME\Parts\Post_List::list_on_block( $args );
	echo '</div>';
	return ob_get_clean();
}
