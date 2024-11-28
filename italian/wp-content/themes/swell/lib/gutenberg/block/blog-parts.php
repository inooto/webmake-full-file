<?php
namespace SWELL_Theme\Block\Blog_Parts;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * ブログパーツブロック
 */
\SWELL_Theme::register_block( 'blog-parts', [
	'render_callback' => function ( $attrs ) {
		$parts_id = $attrs['partsID'] ?: 0;
		$content  = \SWELL_Theme::get_blog_parts_content( [ 'id' => $parts_id ] );

		$bp_class = 'p-blogParts post_content';
		if ( $attrs['className'] ) {
			$bp_class .= ' ' . $attrs['className'];
		}

		$edit_link = '';
		// if ( current_user_can( 'edit_others_posts' ) ) {
		// 	$edit_url  = admin_url( '/post.php?post=' . $parts_id . '&action=edit' );
		// 	$edit_link = '<a href="' . $edit_url . '" class="p-blogParts__edit" target="_blank" rel="noopener nofollow">' .
		// 		'<i class="icon-pen" role="presentation"></i>' .
		// 		'このブログパーツを編集</a>';
		// }

		$content = \SWELL_Theme::do_blog_parts( $content );
		return '<div class="' . esc_attr( $bp_class ) . '" data-partsID="' . esc_attr( $parts_id ) . '">' . $edit_link . $content . '</div>';
	},
] );
