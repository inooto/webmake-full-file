<?php
if ( ! defined( 'ABSPATH' ) ) exit;

use \SWELL_Theme as SWELL;

require_once __DIR__ . '/pluggable_parts/header_parts.php';
require_once __DIR__ . '/pluggable_parts/page_parts.php';
require_once __DIR__ . '/pluggable_parts/list_parts.php';

// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped

/**
 * 公開日・更新日
 */
if ( ! function_exists( 'swl_parts__postdate' ) ) :
	function swl_parts__postdate( $args ) {
		$time = $args['time'] ?: null;
		$type = $args['type'] ?: 'posted'; // posted or modified

		if ( empty( $time ) ) return;

		$date_format = get_option( 'date_format' );
		$date_data   = $time->format( 'Y-m-d' );
		$date_text   = $time->format( $date_format );
		$classname   = "c-postTimes__{$type} icon-{$type}";
		$aria_label  = ( 'posted' === $type ) ? __( '公開日', 'swell' ) : __( '更新日', 'swell' );

		echo '<time class="' . esc_attr( $classname ) . '" datetime="' . esc_attr( $date_data ) . '" aria-label="' . $aria_label . '">' .
			esc_html( $date_text ) .
		'</time>';
	}
endif;


/**
 * 投稿タイトル横の日付
 */
if ( ! function_exists( 'swl_parts__title_date' ) ) :
	function swl_parts__title_date( $args ) {
		$time = $args['time'] ?: null;
		if ( empty( $time ) ) return;
	?>
		<time class="c-postTitle__date u-thin" datetime="<?=esc_attr( $time->format( 'Y-m-d' ) )?>" aria-hidden="true">
			<span class="__y"><?=esc_html( $time->format( 'Y' ) )?></span>
			<span class="__md"><?=esc_html( $time->format( 'n/d' ) )?></span>
		</time>
	<?php
	}
endif;



/**
 * プロモーションバナー
 */
if ( ! function_exists( 'swl_parts__pr_banner' ) ) :
	function swl_parts__pr_banner( $args ) {
		$href = $args['href'] ?: 'https://swell-theme.com';
	?>
		<div class="c-prBanner">
			<a class="c-prBanner__link" href="<?=esc_url( $href )?>" rel="nofollow" referrerpolicy="no-referrer-when-downgrade">
			<img src="<?=esc_url( T_DIRE_URI )?>/assets/img/swell_pr_banner_202111.jpg" class="c-prBanner__img" alt="<?=esc_attr__( 'シンプル美と機能性を両立させた、国内最高峰のWordPressテーマ『SWELL』', 'swell' )?>" width="900" height="750" loading="lazy">
			</a>
		</div>
	<?php
	}
endif;

/**
 * プロモーションバナー
 */
if ( ! function_exists( 'swl_parts__pr_banner' ) ) :
	function swl_parts__pr_banner( $args ) {
		$href = $args['href'] ?: 'https://swell-theme.com';
	?>
		<div class="c-prBanner">
			<a class="c-prBanner__link" href="<?=esc_url( $href )?>" rel="nofollow" referrerpolicy="no-referrer-when-downgrade">
			<img src="<?=esc_url( T_DIRE_URI )?>/assets/img/swell_pr_banner_202111.jpg" class="c-prBanner__img" alt="<?=esc_attr__( 'シンプル美と機能性を両立させた、国内最高峰のWordPressテーマ『SWELL』', 'swell' )?>" width="900" height="750" loading="lazy">
			</a>
		</div>
	<?php
	}
endif;


/**
 * 関連記事テキストリンク
 */
if ( ! function_exists( 'swl_parts__blog_link' ) ) :
	function swl_parts__blog_link( $args ) {
		$url          = $args['url'] ?? '';
		$title        = $args['title'] ?? '';
		$custom_title = $args['custom_title'] ?? '';
		$rel          = $args['rel'] ?? '';
		$is_blank     = $args['is_blank'] ?? '';
		$style        = $args['style'] ?? '';
		$add_class    = $args['add_class'] ?? '';
		$icon         = $args['icon'] ?? '';

		if ( ! $url ) return;

		if ( $custom_title ) {
			$title = $custom_title;
		}

		$link_class = 'c-blogLink';
		if ( $add_class ) {
			$link_class .= ' ' . $add_class;
		}

		$link_props = 'class="' . esc_attr( $link_class ) . '"';

		// data-style
		$link_props .= ' data-style="' . esc_attr( $style ) . '"';

		// target
		if ( $is_blank ) {
			$link_props .= ' target="_blank"';
		}

		// rel
		$rel = $rel ?: ( $is_blank ? 'noopener noreferrer' : '' );
		if ( $rel ) {
			$link_props .= ' rel="' . esc_attr( $rel ) . '"';
		}

		// icon
		if ( ! $icon ) {
			$icon = str_contains( $add_class, '-external' ) ? 'externalLink' : 'link';
		}
		?>
			<a href="<?=esc_url( $url )?>" <?=$link_props?>>
				<!-- <i class="c-blogLink__icon icon-link" role="presentation"></i> -->
				<span class="c-blogLink__icon">
					<?php \SWELL_Theme\SVG::the_svg( $icon, [ 'class' => '__svg' ] ); ?>
				</span>
				<span class="c-blogLink__text"><?=esc_html( wp_strip_all_tags( $title ) )?></span>
			</a>
		<?php
	}
endif;


/**
 * 関連記事ブログカード
 */
if ( ! function_exists( 'swl_parts__blog_card' ) ) :
	function swl_parts__blog_card( $args ) {

		// 初期値とマージ
		$args = array_merge([
			'url'          => '',
			'site_name'    => '',
			'caption'      => '',
			'title'        => '',
			'custom_title' => '',
			'thumb'        => '',
			'excerpt'      => '',
			'is_blank'     => false,
			'add_class'    => '',
			'rel'          => '',
			'noimg'        => false,
			'nodesc'       => false,
			'type'         => 'type1',
			// 'style'        => '',
		], $args );

		// 変数化
		extract( $args ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract

		if ( ! $url ) return;

		if ( $custom_title ) {
			$title = $custom_title;
		}

		$caption    = $caption ?: $site_name ?: __( 'あわせて読みたい', 'swell' );
		$card_class = 'p-blogCard';
		if ( $add_class ) {
			$card_class .= ' ' . $add_class;
		}

		// 画像を表示するか
		$card_thumb = '';
		if ( '' === $thumb || $noimg ) {
			$card_class .= ' -noimg';
		} else {
			$card_img   = '<img src="' . esc_url( $thumb ) . '" alt="" class="c-postThumb__img u-obf-cover" width="320" height="180">';
			$card_thumb = '<div class="p-blogCard__thumb c-postThumb"><figure class="c-postThumb__figure">' .
			$card_img . '</figure></div>';
		}

		$card_excerpt = $nodesc ? '' : '<span class="p-blogCard__excerpt">' . $excerpt . '</span>';

		// target, rel
		$link_props = ( $is_blank ) ? ' target="_blank"' : '';
		$rel        = $rel ?: ( $is_blank ? 'noopener noreferrer' : '' );
		if ( $rel ) {
			$link_props .= ' rel="' . esc_attr( $rel ) . '"';
		}

		?>
			<div class="<?=esc_attr( $card_class )?>" data-type="<?=esc_attr( $type )?>" data-onclick="clickLink">
				<div class="p-blogCard__inner">
					<span class="p-blogCard__caption"><?=esc_html( $caption )?></span>
					<?=$card_thumb?>
					<div class="p-blogCard__body">
						<a class="p-blogCard__title" href="<?=esc_url( $url )?>"<?=$link_props?>><?=wp_kses( $title, SWELL::$allowed_text_html )?></a>
						<?=$card_excerpt?>
					</div>
				</div>
			</div>
		<?php
	}
endif;


/**
 * MVボタン
 */
if ( ! function_exists( 'swl_parts__mv_btn' ) ) :
	function swl_parts__mv_btn( $args ) {
		$href     = $args['href'] ?? '';
		$text     = $args['text'] ?? '';
		$btn_col  = $args['btn_col'] ?? '';
		$btn_type = $args['btn_type'] ?? 'n';

		$props = '';
		if ( strpos( $href, '#' ) !== 0 && strpos( $href, home_url( '/' ) ) === false ) {
			$props .= ' rel="noopener" target="_blank"';
		}

		if ( 'n' === $btn_type ) {
			// -btn-n の メインカラー追従は CSS で
			if ( $btn_col ) {
				$props .= ' style="background-color:' . esc_attr( $btn_col ) . '"';
			}
		} elseif ( 'b' === $btn_type ) {
			$btn_col = $btn_col ?: SWELL::get_setting( 'color_main' );
			if ( $btn_col ) {
				$props .= ' style="color:' . esc_attr( $btn_col ) . '"';
			}
		}
	?>
		<div class="p-mainVisual__slideBtn c-mvBtn -btn-<?=esc_attr( $btn_type )?>">
			<a href="<?=esc_url( $href )?>" class="c-mvBtn__btn"<?=$props?>><?=esc_html( $text )?></a>
		</div>
	<?php
	}
endif;


/**
 * MV用スクロールアイコン
 */
if ( ! function_exists( 'swl_parts__scroll_arrow' ) ) :
	function swl_parts__scroll_arrow( $args ) {
		$color = $args['color'] ?? '';
	?>
		<button class="p-mainVisual__scroll c-plainBtn" data-onclick="scrollToContent" style="color:<?=esc_attr( $color )?>">
			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 80 80" class="p-mainVisual__scrollArrow">
				<path d="M5.9,14.4l-2.9,5C3,19.5,3,19.6,3,19.8c0,0.1,0.1,0.2,0.2,0.3l36.4,21c0.1,0,0.2,0.1,0.3,0.1c0.1,0,0.2,0,0.3-0.1l36.4-21 c0.1-0.1,0.2-0.2,0.2-0.3c0-0.1,0-0.3-0.1-0.4l-2.9-5c-0.1-0.1-0.2-0.2-0.3-0.2c-0.1,0-0.3,0-0.4,0.1L40,33.5L6.7,14.2 c-0.1,0-0.2-0.1-0.3-0.1c0,0-0.1,0-0.1,0C6.1,14.2,6,14.3,5.9,14.4z"/>
				<path d="M5.9,39.1l-2.9,5c-0.1,0.3-0.1,0.6,0.2,0.7l36.4,21c0.1,0,0.2,0.1,0.3,0.1c0.1,0,0.2,0,0.3-0.1l36.4-21 c0.2-0.1,0.2-0.2,0.2-0.3s0-0.2-0.1-0.4l-2.9-5c-0.1-0.1-0.2-0.2-0.3-0.2l0,0c-0.1,0-0.3,0-0.4,0.1L40,58.1L6.7,38.9 c-0.1,0-0.2-0.1-0.3-0.1c0,0-0.1,0-0.1,0C6.1,38.8,6,38.9,5.9,39.1z"/>
			</svg>
			<span class="p-mainVisual__scrollLabel"><?=esc_html__( 'Scroll', 'swell' )?></span>
		</button>
		<?php
	}
endif;


/**
 * ピックアップバナー
 */
if ( ! function_exists( 'swl_parts__pickup_banner' ) ) :
	function swl_parts__pickup_banner( $args ) {
		$item       = $args['item'] ?? null;
		$menu_count = $args['menu_count'] ?? 1;
		if ( ! $item ) return;

		// aタグの属性値
		$a_props = 'href="' . $item->url . '"';
		if ( $item->target === '_blank' ) {
			$a_props .= ' target="_blank" rel="noopener noreferrer"';
		}

		// レイアウトに合わせてsizes取得
		$sizes = SWELL::get_pickup_banner_sizes( $menu_count );

		// lazyloadタイプ
		$lazy_type = SWELL::get_setting( 'pickbnr_lazy_off' ) ? 'none' : SWELL::$lazy_type;

		$img_class = 'c-bannerLink__img';

		// 説明欄に直接画像URLがある場合 (タームの説明文が入ってくることに注意。)
		$img_url = trim( $item->description );

		if ( $img_url && 0 === strpos( $img_url, 'http' ) ) {
			$img_id = SWELL::get_imgid_from_url( $img_url );
			$thumb  = SWELL::get_image( $img_id, [
				'class'    => $img_class,
				'sizes'    => $sizes,
				'loading'  => $lazy_type,
				'decoding' => 'async',
			]);

		} elseif ( $item->type === 'post_type' ) {

			$post_id = $item->object_id;
			$thumb   = SWELL::get_thumbnail( [
				'post_id'   => $post_id,
				'sizes'     => $sizes,
				'class'     => $img_class,
				'lazy_type' => $lazy_type,
				'decoding'  => 'async',
			] );

		} elseif ( $item->type === 'taxonomy' ) {
			$thumb = SWELL::get_thumbnail( [
				'term_id'   => $item->object_id,
				'sizes'     => $sizes,
				'class'     => $img_class,
				'lazy_type' => $lazy_type,
				'decoding'  => 'async',
			] );
		}

		// 画像なければ NO IMAGE
		if ( ! $thumb ) {
			$thumb = '<img src="' . esc_url( SWELL::get_noimg( 'url' ) ) . '" alt="" class="' . esc_attr( $img_class ) . '" decoding="async">';
		}

	?>
		<a <?=$a_props?> class="c-bannerLink">
			<figure class="c-bannerLink__figure"><?=$thumb?></figure>
			<span class="c-bannerLink__label"><?=wp_kses( $item->title, SWELL::$allowed_text_html )?></span>
		</a>
	<?php
	}
endif;


/**
 * PR表記
 */
if ( ! function_exists( 'swl_parts__pr_notation' ) ) :
	function swl_parts__pr_notation( $args ) {
		?>
			<div data-nosnippet class="c-prNotation is-style-bg_stripe" data-style="big">
				<i class="icon-info"></i>
				<span><?=wp_kses( SWELL::get_setting( 'pr_notation_l_text' ), SWELL::$allowed_text_html )?></span>
			</div>
		<?php
	}
endif;
