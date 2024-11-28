<?php
if ( ! defined( 'ABSPATH' ) ) exit;

use \SWELL_Theme as SWELL;

if ( ! function_exists( 'swl_parts__page_title' ) ) :
	function swl_parts__page_title( $args ) {
		$title     = $args['title'] ?? '';
		$subtitle  = $args['subtitle'] ?? '';
		$has_inner = $args['has_inner'] ?? false;
		$nowrap    = $args['nowrap'] ?? false; // 後方互換用

		// サブタイトル
		if ( $subtitle ) {
			$title .= '<small class="c-pageTitle__subTitle u-fz-14">– ' . $subtitle . ' –</small>';
		}

		// 旧バージョンではh1の中だけ出力してた
		if ( $nowrap ) {
			echo wp_kses( $title, SWELL::$allowed_text_html );
			return;
		}

		// 先にエスケープ
		$title = wp_kses( $title, SWELL::$allowed_text_html );

		$title_style = '';
		if ( $has_inner ) {
			$title       = '<span class="c-pageTitle__inner">' . $title . '</span>';
			$title_style = is_archive() ? SWELL::get_setting( 'archive_title_style' ) : SWELL::get_setting( 'page_title_style' );
		}

		if ( $title_style ) {
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo '<h1 class="c-pageTitle" data-style="' . esc_attr( $title_style ) . '">' . $title . '</h1>';
		} else {
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo '<h1 class="c-pageTitle">' . $title . '</h1>';
		}

	}
endif;


/**
 * タームアーカイブページのタイトルを取得
 */
if ( ! function_exists( 'swl_parts__term_title' ) ) :
	function swl_parts__term_title( $args ) {
		$term_id   = $args['term_id'] ?? 0;
		$has_inner = $args['has_inner'] ?? false;
		if ( ! $term_id ) return;

		$archive_data = SWELL::get_archive_data();
		SWELL::pluggable_parts( 'page_title', [
			'title'     => get_term_meta( $term_id, 'swell_term_meta_ttl', 1 ) ?: $archive_data['title'],
			'subtitle'  => get_term_meta( $term_id, 'swell_term_meta_subttl', 1 ) ?: $archive_data['type'],
			'has_inner' => $has_inner,
		] );
	}
endif;


/**
 * 著者アイコンを取得する
 */
if ( ! function_exists( 'swl_parts__the_post_author' ) ) :
	function swl_parts__the_post_author( $args ) {

		$author_id   = $args['author_id'] ?? 0;
		$author_data = SWELL::get_author_icon_data( $author_id );
		if ( empty( $author_data ) ) return;

		// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
		?>
			<a href="<?=esc_url( $author_data['url'] )?>" class="c-postAuthor is-link p-articleMetas__author">
				<figure class="c-postAuthor__figure"><?=$author_data['avatar']?></figure>
				<span class="c-postAuthor__name u-thin"><?=esc_html( $author_data['name'] )?></span>
			</a>
		<?php
		// phpcs:enable WordPress.Security.EscapeOutput.OutputNotEscaped
	}
endif;


/**
 * 前後記事へのリンク
 */
if ( ! function_exists( 'swl_parts__pnlink' ) ) :
function swl_parts__pnlink( $args ) {
	$post_id = $args['id'];
	?>
	<a href="<?=esc_url( get_permalink( $post_id ) )?>" rel="<?=esc_attr( $args['type'] )?>" class="p-pnLinks__link">
		<?php
			if ( $args['show_thumb'] ) :
				SWELL::get_image( get_post_thumbnail_id( $post_id ), [
					'size'   => 'medium',
					'class'  => 'p-pnLinks__thumb',
					'width'  => '160',
					'height' => '90',
					'srcset' => '',
					'alt'    => '',
					'echo'   => true,
				]);
			endif;
		?>
		<span class="p-pnLinks__title"><?=wp_kses( $args['title'], SWELL::$allowed_text_html )?></span>
	</a>
	<?php
}
endif;
