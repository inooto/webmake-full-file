<?php
namespace SWELL_Theme\Shortcode;

use \SWELL_Theme as SWELL;

if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * [ad]
 */
if ( ! function_exists( __NAMESPACE__ . '\echo_ad' ) ) :
	function echo_ad( $args ) {
		$ad = \SWELL_Theme::get_setting( 'sc_ad_code' );
		return do_shortcode( $ad );
	}
endif;
add_shortcode( 'ad', __NAMESPACE__ . '\echo_ad' );


/**
 * [目次]
 */
if ( ! function_exists( __NAMESPACE__ . '\echo_toc' ) ) :
	function echo_toc( $args ) {
		$toc = '<div class="swell-toc-placeholder"></div>';
		return $toc;
	}
endif;
add_shortcode( 'swell_toc', __NAMESPACE__ . '\echo_toc' );


/**
 * [br系]
 */
if ( ! function_exists( __NAMESPACE__ . '\spbr' ) ) :
	function spbr( $args ) {
		return '<br class="sp_">';
	}
endif;
add_shortcode( 'spbr', __NAMESPACE__ . '\spbr' );

if ( ! function_exists( __NAMESPACE__ . '\pcbr' ) ) :
	function pcbr( $args ) {
		return '<br class="pc_">';
	}
endif;
add_shortcode( 'pcbr', __NAMESPACE__ . '\pcbr' );


/**
 * アイコン
 */
if ( ! function_exists( __NAMESPACE__ . '\echo_icon' ) ) :
	function echo_icon( $args ) {
		if ( empty( $args ) ) {
			return;
		}
		$iconname = isset( $args['class'] ) ? $args['class'] : $args[0];
		$iconname = str_replace( '&quot;', '', $iconname ); // ウィジェットタイトルでエスケープされてしまってるのを削除

		return '<i class="' . $iconname . '"></i>';
	}
endif;
add_shortcode( 'icon', __NAMESPACE__ . '\echo_icon' );
add_shortcode( 'アイコン', __NAMESPACE__ . '\echo_icon' );


/**
 * スターアイコン
 */
if ( ! function_exists( __NAMESPACE__ . '\review_stars' ) ) :
	function review_stars( $args ) {
		if ( ! isset( $args[0] ) ) return '';
		return '<span class="c-reviewStars">' . \SWELL_PARTS::review_stars( $args[0] ) . '</span>';
	}
endif;
add_shortcode( 'review_stars', __NAMESPACE__ . '\review_stars' );


/**
 * ブログカード
 */
if ( ! function_exists( __NAMESPACE__ . '\post_link' ) ) :
	function post_link( $args ) {

		$caption = ( isset( $args['cap'] ) ) ? $args['cap'] : ''; // 「あわせて読みたい」の内容
		$rel     = ( isset( $args['rel'] ) ) ? $args['rel'] : '';
		$noimg   = ( isset( $args['noimg'] ) && $args['noimg'] );

		$card_args = [
			'caption'   => $caption,
			'rel'       => $rel,
			'noimg'     => $noimg,
		];

		// 外部リンクの場合
		if ( isset( $args['url'] ) ) {
			return \SWELL_Theme::get_external_blog_card( $args['url'], $card_args );
		}

		// IDなければアウト
		if ( ! isset( $args['id'] ) ) return '';

		$target                = isset( $args['target'] ) ? $args['target'] : '';
		$card_args['is_blank'] = ( '_blank' === $target );

		return \SWELL_Theme::get_internal_blog_card( $args['id'], $card_args );

	}
endif;
add_shortcode( 'post_link', __NAMESPACE__ . '\post_link' );


/**
 * ブログパーツ
 */
if ( ! function_exists( __NAMESPACE__ . '\blog_parts' ) ) :
	function blog_parts( $args ) {

		$parts_id = isset( $args['id'] ) ? $args['id'] : '0';

		$bp_class = '';
		if ( isset( $args['class'] ) && $args['class'] ) {
			$bp_class .= ' ' . $args['class'];
		}

		$content = \SWELL_Theme::get_blog_parts_content( $args );

		$edit_link = '';
		// if ( current_user_can( 'edit_others_posts' ) ) {
		// 	$edit_url  = admin_url( '/post.php?post=' . $parts_id . '&action=edit' );
		// 	$edit_link = '<a href="' . $edit_url . '" class="p-blogParts__edit" target="_blank" rel="noopener nofollow">' .
		// 		'<i class="icon-pen" role="presentation"></i>' .
		// 		'このブログパーツを編集</a>';
		// }

		return '<div class="p-blogParts post_content' . esc_attr( $bp_class ) . '" data-partsID="' . esc_attr( $parts_id ) . '">' .
			$edit_link .
			\SWELL_Theme::do_blog_parts( $content ) .
		'</div>';
	}
endif;
add_shortcode( 'blog_parts', __NAMESPACE__ . '\blog_parts' );
add_shortcode( 'ブログパーツ', __NAMESPACE__ . '\blog_parts' );


/**
 * 広告タグ
 */
if ( ! function_exists( __NAMESPACE__ . '\ad_tag' ) ) :
	function ad_tag( $args, $content = null ) {

		if ( ! isset( $args['id'] ) ) {
			return esc_html__( '※ IDが指定されていません。', 'swell' );
		}
		$ad_id = (int) $args['id'];
		if (0 === $ad_id ) return esc_html__( '※ IDを指定してください。', 'swell' );

		$ad_type      = '';
		$ad_img       = '';
		$ad_border    = '';
		$ad_name      = '';
		$ad_desc      = '';
		$ad_rank      = '';
		$ad_star      = '';
		$ad_price     = '';
		$ad_btn1_text = '';
		$ad_btn2_text = '';
		$ad_btn1_url  = '';
		$ad_btn2_url  = '';

		$q_args    = [
			'post_type'      => 'ad_tag',
			'p'              => $ad_id,
			'no_found_rows'  => true,
			'posts_per_page' => 1,
		];
		$the_query = new \WP_Query( $q_args );

		while ( $the_query->have_posts() ) :
		$the_query->the_post();
			$ad_id   = get_the_ID();
			$ad_type = get_post_meta( $ad_id, 'ad_type', true );
			$ad_img  = get_post_meta( $ad_id, 'ad_img', true );

			if ( 'text' === $ad_type ) break;
			$ad_border = get_post_meta( $ad_id, 'ad_border', true );

			if ( 'normal' === $ad_type ) break;
			$ad_name      = get_post_meta( $ad_id, 'ad_name', true ) ?: get_the_title();
			$ad_desc      = get_post_meta( $ad_id, 'ad_desc', true );
			$ad_rank      = get_post_meta( $ad_id, 'ad_rank', true );
			$ad_star      = get_post_meta( $ad_id, 'ad_star', true );
			$ad_price     = get_post_meta( $ad_id, 'ad_price', true );
			$ad_btn1_text = get_post_meta( $ad_id, 'ad_btn1_text', true );
			$ad_btn2_text = get_post_meta( $ad_id, 'ad_btn2_text', true );
			$ad_btn1_url  = get_post_meta( $ad_id, 'ad_btn1_url', true );
			$ad_btn2_url  = get_post_meta( $ad_id, 'ad_btn2_url', true );

		endwhile;
		wp_reset_postdata();

		if ( 'text' === $ad_type ) {
			return '<span class="p-adBox" data-id="' . $ad_id . '" data-ad="text">' . $ad_img . '</span>';
		}

		// 出力するHTML
		$ad_details = '';
		$ad_head    = '';
		$ad_foot    = '';

		// タイトル
		if ( 'ranking' === $ad_type ) {
			if ( $ad_name ) {
				$ad_head .= '<div class="p-adBox__title -' . $ad_rank . '">' . $ad_name . '</div>';
			}
		} elseif ( 'normal' !== $ad_type ) {
			if ( $ad_name ) {
				$ad_details .= '<div class="p-adBox__name">' . $ad_name . '</div>';
			}
		}

		// detail本文
		if ( $ad_star ) {
			$ad_star     = \SWELL_PARTS::review_stars( $ad_star );
			$ad_details .= '<div class="p-adBox__star c-reviewStars">' . $ad_star . '</div>';
		}
		if ( $ad_price ) {
			$ad_details .= '<div class="p-adBox__price u-thin u-fz-s">' . $ad_price . '</div>';
		}
		if ( $ad_desc ) {
			$ad_details .= '<div class="p-adBox__desc">' . $ad_desc . '</div>';
		}

		// ボタン
		$ad_btns = '';
		if ( $ad_btn1_url ) {
			$ad_btns .= '<a href="' . $ad_btn1_url . '" class="p-adBox__btn -btn1" target="_blank" rel="noopener nofollow">' . $ad_btn1_text . '</a>';
		}
		if ( $ad_btn2_url ) {
			$ad_btns .= '<a href="' . $ad_btn2_url . '" class="p-adBox__btn -btn2" target="_blank" rel="noopener nofollow">' . $ad_btn2_text . '</a>';
		}

		// ボタンを detail または foot につける
		if ( 'ranking' === $ad_type ) {
			if ( $ad_btns ) $ad_foot .= '<div class="p-adBox__btns">' . $ad_btns . '</div>';
		} else {
			if ( $ad_btns ) $ad_details .= '<div class="p-adBox__btns">' . $ad_btns . '</div>';
		}

		// detail あれば表示
		if ( $ad_details ) $ad_details = '<div class="p-adBox__details">' . $ad_details . '</div>';

		// ブロッックでセットしたクラスを受け取れるように
		$ad_box_class = '-' . $ad_type . ' -border-' . $ad_border;
		if ( isset( $args['class'] ) && $args['class'] ) $ad_box_class .= ' ' . $args['class'];

		return '<div class="p-adBox ' . $ad_box_class . '" data-id="' . $ad_id . '" data-ad="' . $ad_type . '">' .
			$ad_head .
			'<div class="p-adBox__body">' .
				'<div class="p-adBox__img">' . $ad_img . '</div>' .
				$ad_details .
			'</div>' .
			$ad_foot .
		'</div>';
	}
endif;
add_shortcode( 'ad_tag', __NAMESPACE__ . '\ad_tag' );


/**
 * ふきだし
 */
if ( ! function_exists( __NAMESPACE__ . '\balloon' ) ) :
	function balloon( $args, $content = null ) {

		// ふきだしセットの指定があればデータを取得
		$bln_data = [];
		if ( isset( $args['id'] ) ) {
			$bln_data = \SWELL_Theme::get_balloon_data( 'id', $args['id'] );
		} elseif ( isset( $args['set'] ) ) {
			$bln_data = \SWELL_Theme::get_balloon_data( 'title', $args['set'] );
		}

		if ( ! is_array( $bln_data ) ) {
			$bln_data = [];
		}

		// ふきだしセットのデータ > デフォルト値
		$bln_icon       = $bln_data['icon'] ?? '';
		$bln_name       = $bln_data['name'] ?? '';
		$bln_col        = $bln_data['col'] ?? 'gray';
		$bln_type       = $bln_data['type'] ?? 'speaking';
		$bln_align      = $bln_data['align'] ?? 'left';
		$bln_border     = $bln_data['border'] ?? 'none';
		$bln_icon_shape = $bln_data['shape'] ?? 'circle';
		$bln_icon_shape = $bln_data['shape'] ?? 'circle';
		$sp_vertical    = $bln_data['spVertical'] ?? '';

		// ショートコードにプロパティが指定されていればさらに上書き。
		if ( isset( $args['icon'] ) ) $bln_icon             = $args['icon'];
		if ( isset( $args['name'] ) ) $bln_name             = $args['name'];
		if ( isset( $args['col'] ) ) $bln_col               = $args['col'];
		if ( isset( $args['type'] ) ) $bln_type             = $args['type'];
		if ( isset( $args['align'] ) ) $bln_align           = $args['align'];
		if ( isset( $args['border'] ) ) $bln_border         = $args['border'];
		if ( isset( $args['icon_shape'] ) ) $bln_icon_shape = $args['icon_shape'];
		if ( isset( $args['sp_vertical'] ) ) $sp_vertical   = $args['sp_vertical'];

		// ふきだしのクラス
		$bln_class = 'c-balloon -bln-' . $bln_align;
		if ( '1' === $sp_vertical ) {
			$bln_class .= ' -sp-vrtcl';
		}

		$name_src = $bln_name ? '<span class="c-balloon__iconName">' . esc_html( $bln_name ) . '</span>' : '';

		$icon_src = '';
		if ( ! empty( $bln_icon ) ) {
			$icon_img = '<img src="' . esc_url( $bln_icon ) . '" alt="" class="c-balloon__iconImg" width="80px" height="80px">';
			$icon_img = SWELL::set_lazyload( $icon_img, SWELL::$lazy_type );
			$icon_src = '<div class="c-balloon__icon -' . esc_attr( $bln_icon_shape ) . '">' .
				$icon_img .
				$name_src .
			'</div>';
		}

		return '<div class="' . esc_attr( $bln_class ) . '" data-col="' . esc_attr( $bln_col ?: 'gray' ) . '">' .
				$icon_src .
				'<div class="c-balloon__body -' . esc_attr( $bln_type ) . ' -border-' . esc_attr( $bln_border ) . '">' .
					'<div class="c-balloon__text">' . do_shortcode( $content ) .
						'<span class="c-balloon__shapes">' .
							'<span class="c-balloon__before"></span>' .
							'<span class="c-balloon__after"></span>' .
						'</span>' .
					'</div>' .
				'</div>' .
			'</div>';
	}
endif;
add_shortcode( 'speech_balloon', __NAMESPACE__ . '\balloon' );
add_shortcode( 'ふきだし', __NAMESPACE__ . '\balloon' );

/**
 * フルワイドコンテンツ
 */
if ( ! function_exists( __NAMESPACE__ . '\full_wide_content' ) ) :
	function full_wide_content( $args, $content = null ) {

		// $content = do_shortcode( shortcode_unautop( $content ) );
		$content = do_shortcode( $content );

		$add_style = '';
		$add_attr  = '';
		$class     = 'swell-block-fullWide alignfull';
		if ( isset( $args['bgimg'] ) ) {

			$class    .= ' lazyload';
			$add_attr .= 'data-bg="' . $args['bgimg'] . '"';

		} elseif ( isset( $args['bg'] ) ) {

			$add_style .= 'background-color:' . $args['bg'] . ';';

		}

		if ( isset( $args['color'] ) ) {
			$add_style .= 'color:' . $args['color'] . ';';
		}
		if ( isset( $args['class'] ) ) {
			$class .= ' ' . $args['class'];
		}

		$text_color = ( isset( $args['color'] ) ) ? $args['color'] : '';

		// $content = do_shortcode( shortcode_unautop( $content ) );
		if ( $add_style ) $add_attr .= ' style="' . $add_style . '"';

		return '<div class="' . $class . '"' . $add_attr . '><div class="swell-block-fullWide__inner l-article">' . $content . '</div></div>';

	}
endif;
add_shortcode( 'full_wide_content', __NAMESPACE__ . '\full_wide_content' );


/**
 * カスタムバナー
 */
if ( ! function_exists( __NAMESPACE__ . '\custom_banner' ) ) :
	function custom_banner( $args, $content = null ) {

		$id           = 0;
		$img          = SWELL::get_noimg( 'url' );
		$title        = '';
		$sub_text     = '';
		$link         = '';
		$caption      = '';
		$icon         = '';
		$banner_class = '';
		$banner_style = '';

		$is_term = false;

		// バナーc-bannerLinkに付与するスタイル
		if ( isset( $args['width'] ) ) $banner_style  .= 'width:' . $args['width'] . ';';
		if ( isset( $args['radius'] ) ) $banner_style .= 'border-radius:' . $args['radius'] . ';';

		// クラスの追加
		if ( isset( $args['shadow'] ) && 'on' === $args['shadow'] ) $banner_class .= ' -shadow-on';
		if ( isset( $args['blur'] ) && 'on' === $args['blur'] ) $banner_class     .= ' -blur-on';

		if ( isset( $args['post_id'] ) ) {

			$id    = (int) $args['post_id'];
			$title = get_the_title( $id );
			$link  = get_permalink( $id );

		} elseif ( isset( $args['cat_id'] ) ) {

			$id      = (int) $args['cat_id'];
			$term    = get_term( $id );
			$title   = $term->name;
			$link    = get_term_link( $term );
			$is_term = true;

		} elseif ( isset( $args['tag_id'] ) ) {

			$id      = (int) $args['tag_id'];
			$term    = get_term( $id );
			$title   = $term->name;
			$link    = get_term_link( $term );
			$is_term = true;

		}

		$img_class = 'c-bannerLink__img u-obf-cover';

		// 画像の直接指定
		if ( isset( $args['img_id'] ) ) {

			$img_id = $args['img_id'];
			$thumb  = \SWELL_Theme::get_image( $img_id, [
				'class' => $img_class,
				'alt'   => '',
			] );

		} elseif ( isset( $args['img_url'] ) ) {

			$img   = $args['img_url'];
			$thumb = '<img src="' . $img . '" class="' . $img_class . '" alt="">';

		} elseif ( $id ) {
			if ( $is_term ) {
				$thumb = \SWELL_Theme::get_thumbnail( [
					'term_id' => $id,
					'class'   => $img_class,
				] );
			} else {
				$thumb = \SWELL_Theme::get_thumbnail( [
					'post_id' => $id,
					'class'   => $img_class,
				] );
			}
		}

		// テキストの上書き
		if ( isset( $args['title'] ) ) {
			$title = $args['title'];
		}

		if ( isset( $args['link'] ) ) {
			$link = $args['link'];
		}

		if ( isset( $args['icon'] ) ) {
			$icon = $args['icon'];
		}

		// サブテキスト（説明文）
		if ( isset( $args['text'] ) ) {
			$sub_text = '<div class="c-bannerLink__description">' . $args['text'] . '</div>';
		}

		// __figureに付与するスタイル（高さ）
		$figure_style      = '';
		$data_tab_style    = '';
		$data_mobile_style = '';
		if ( isset( $args['height_sp'] ) && isset( $args['height'] ) ) {
			// spの高さも指定がある場合
			$data_mobile_style .= 'height:' . $args['height_sp'] . ';';
			$data_tab_style    .= 'height:' . $args['height'] . ';';
		} elseif ( isset( $args['height'] ) ) {
			// height指定だけある場合
			$figure_style .= 'height:' . $args['height'] . ';';
		}

		// style / data-styleとなる文字列を生成
		if ( '' !== $figure_style ) {
			$figure_style = ' style="' . $figure_style . '"';
		}
		if ( '' !== $data_mobile_style ) {
			$figure_style .= 'data-mobile-style="' . $data_mobile_style . '"';
		}
		if ( '' !== $data_tab_style ) {
			$figure_style .= 'data-tab-style="' . $data_tab_style . '"';
		}

		$target = ( strpos( $link, home_url( '/' ) ) !== false ) ? '' : ' rel="noopener" target="_blank"';

		if ( ! $link ) {
			$banner_start = 'div';
			$banner_end   = 'div';
		} else {
			$banner_start = 'a href="' . esc_url( $link ) . '"' . $target;
			$banner_end   = 'a';
		}

		$banner = '<div class="p-customBanner">' .
			'<' . $banner_start . ' class="c-bannerLink' . $banner_class . '" style="' . $banner_style . '">' .
				'<figure class="c-bannerLink__figure"' . $figure_style . '>' . $thumb . '</figure>' .
				'<div class="c-bannerLink__text">' .
					'<div class="c-bannerLink__title ' . $icon . '">' . $title . '</div>' . $sub_text .
				'</div>' .
			'</' . $banner_end . '>' .
		'</div>';

		return $banner;
	}
endif;
add_shortcode( 'カスタムバナー', __NAMESPACE__ . '\custom_banner' );
add_shortcode( 'custom_banner', __NAMESPACE__ . '\custom_banner' );


/**
 * 投稿リスト
 */
if ( ! function_exists( __NAMESPACE__ . '\post_list' ) ) :
	function post_list( $args ) {

		if ( ! $args ) $args = [];

		// ショートコード用だけにある設定の処理
		if ( ! isset( $args['excerpt'] ) && ! isset( $args['excerpt_length'] ) ) {
			$args['excerpt_length'] = 0;
		}

		// パラメーター名の違いを合わせる
		if ( isset( $args['col'] ) ) {
			$args['max_col'] = $args['col'];
			unset( $args['col'] );
		}
		if ( isset( $args['col_sp'] ) ) {
			$args['max_col_sp'] = $args['col_sp'];
			unset( $args['col_sp'] );
		}

		ob_start();
		echo '<div class="p-postListWrap">';
		\SWELL_THEME\Parts\Post_List::list_on_block( $args );
		echo '</div>';
		return ob_get_clean();
	}
endif;
add_shortcode( 'post_list', __NAMESPACE__ . '\post_list' );


/**
 * ログイン中だけの表示
 */
if ( ! function_exists( __NAMESPACE__ . '\only_login' ) ) :
function only_login( $args, $content = null ) {
		if ( is_user_logged_in() ) {
			return do_shortcode( shortcode_unautop( $content ) );
			}
		return '';
}
endif;
add_shortcode( 'only_login', __NAMESPACE__ . '\only_login' );


/**
 * ログアウト中だけの表示
 */
if ( ! function_exists( __NAMESPACE__ . '\only_logout' ) ) :
function only_logout( $args, $content = null ) {
		if ( ! is_user_logged_in() ) {
			return do_shortcode( shortcode_unautop( $content ) );
			}
		return '';
}
endif;
add_shortcode( 'only_logout', __NAMESPACE__ . '\only_logout' );


/**
 * HTMLタグをそのまま表示
 */
function do_html_sc( $atts, $content = null ) {

	// html_entity_decode のほうが多くの文字をデコードできるが、重要な"と'に関してはどちらもHTMLとして正しくデコードできないのでwp関数を使う。
	// see : https://developer.wordpress.org/reference/functions/wp_specialchars_decode/
	$content = wp_specialchars_decode( $content, ENT_NOQUOTES );

	// 開始タグの中の属性値を取得
	$pattern   = '/<[a-zA-Z]+\s+([^>]*)>/ms';
	$has_props = preg_match_all( $pattern, $content, $matches, PREG_SET_ORDER );
	if ( ! $has_props ) return $content;

	foreach ( $matches as $i => $m ) {
		$props = $m[1];

		// クオート系もデコード
		$props = wp_specialchars_decode( $props, ENT_QUOTES );

		// " が &#8221;、 ' が &#8217; になっていて属性値がバグるので変換しておく。
		// see: https://developer.wordpress.org/reference/functions/convert_invalid_entities/
		$props = str_replace( [ '&#8221;', '&#8217;' ], [ '"', "'" ], $props );

		$content = str_replace( $m[1], $props, $content );
	}

	return $content;
}
if ( ! shortcode_exists( 'html' ) ) add_shortcode( 'html', __NAMESPACE__ . '\do_html_sc' );


/**
 * PR表記
 */
if ( ! function_exists( __NAMESPACE__ . '\echo_pr_notation' ) ) :
	function echo_pr_notation( $atts ) {
		return SWELL::get_pluggable_parts( 'pr_notation' );
	}
endif;
add_shortcode( 'pr_notation', __NAMESPACE__ . '\echo_pr_notation' );
