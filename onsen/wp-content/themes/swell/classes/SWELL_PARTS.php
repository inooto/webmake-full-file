<?php
if ( ! defined( 'ABSPATH' ) ) exit;

// @codingStandardsIgnoreStart
class SWELL_PARTS{

	private function __construct() {}

	/**
	 * 3.0で消す
	 */
	public static function catchphrase() {
		return apply_filters( 'swell_parts_catchphrase', \SWELL_Theme::site_data( 'catchphrase' ) );
	}

	/**
	 * 3.0で消す
	 */
	public static function head_logo_img() {
		return \SWELL_Theme::get_pluggable_parts( 'head_logo' );
	}


	/**
	 * ヘッダーロゴ
	 */
	public static function head_logo( $is_fixbar = false ) {
		
		$logo = '';
		$logo_class = '';
		if ( \SWELL_Theme::site_data( 'logo_id' ) || \SWELL_Theme::site_data( 'logo_url' ) ) {
			$logo = \SWELL_Theme::get_pluggable_parts( 'head_logo' );
			$logo_class = '-img';
		}
		
		// ロゴがない場合 (idがあってもメディアに存在しないケースも考慮)
		if ( ! $logo ) {
			$logo = \SWELL_Theme::site_data( 'title' );
			$logo_class = '-txt';
		}

		$tag = ( \SWELL_Theme::is_top() && ! $is_fixbar ) ?  'h1' : 'div';

		$return = '<'. $tag .' class="c-headLogo '. $logo_class .'">'.
					'<a href="'. home_url( '/' ) .'" title="'. \SWELL_Theme::site_data( 'title' ) .'" class="c-headLogo__link" rel="home">'. $logo .'</a>'.
				'</'. $tag .'>';

		return apply_filters( 'swell_parts_head_logo', $return, $is_fixbar  );
	}


	/**
	 * 3.0で消す
	 */
	public static function page_title( $page_id ) {
		$title = \SWELL_Theme::get_pluggable_parts( 'page_title', [
			'title'    => get_the_title( $page_id ),
			'subtitle' => get_post_meta( $page_id, 'swell_meta_subttl', true ),
			'nowrap'   => true,
		] );
		return apply_filters( 'swell_parts_page_title', $title, $post_id );
	}


	/**
	 * 3.0で消す
	 */
	public static function term_title( $term_id ) {
		$archive_data = \SWELL_Theme::get_archive_data();

		$title = \SWELL_Theme::get_pluggable_parts( 'page_title', [
			'title'    => get_term_meta( $term_id, 'swell_term_meta_ttl', 1 ) ?: $archive_data['title'],
			'subtitle' => get_term_meta( $term_id, 'swell_term_meta_subttl', 1 ) ?: $archive_data['type'],
			'nowrap'   => true,
		] );
		return apply_filters( 'swell_parts_term_title', $title, $term_id );
	}


	/**
	 * アイキャッチ画像を取得する（single）
	 */
	public static function post_thumbnail( $post_id = null ) {
		$post_id   = $post_id ?: get_the_ID();
		$post_data = get_post( $post_id );

		if ( $post_data === null ) return '';


		$return     = '';
		$is_youtube = false;
		$youtube_id = get_post_meta( $post_id, 'swell_meta_youtube', true ) ?: '';
		$caption    = get_post_meta( $post_id, 'swell_meta_thumb_caption', true ) ?: '';

		if ( $caption ) {
			$caption = '<figcaption class="p-articleThumb__caption">' . wp_kses( $caption, \SWELL_Theme::$allowed_text_html ) . '</figcaption>';
		}

		//YouTubeの指定があれば動画を返す
		if ( $youtube_id ) {

			$is_youtube = true;
			$youtube_url = 'https://www.youtube.com/embed/' . esc_attr( $youtube_id );
			$iframe_props = 'frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen';

			if ( 'lazy' === \SWELL_Theme::$lazy_type ) {
				$iframe_props .= ' src="' . $youtube_url . '" loading="lazy"';
			} elseif ( 'lazysizes' === \SWELL_Theme::$lazy_type ) {
				$iframe_props .= ' class="lazyload" data-src="' . $youtube_url . '"';
			} else {
				$iframe_props .= ' src="' . $youtube_url . '"';
			}

			$return = '<figure class="p-articleThumb -youtube">' .
				'<div class="p-articleThumb__youtube"><iframe ' . $iframe_props . '></iframe></div>' . $caption .
			'</figure>';

		} else {

			// $sizes     = $variable['sizes'] ?? '(min-width: 960px) 960px, 100vw';

			$thumb = \SWELL_Theme::get_thumbnail( [
				'post_id'   => $post_id,
				'class'     => 'p-articleThumb__img',
				'lazy_type' => apply_filters( 'swell_post_thumbnail_lazy_off', true ) ? 'none' : \SWELL_Theme::$lazy_type,
				'use_noimg' => is_single() && \SWELL_Theme::get_setting('show_noimg_thumb'),
				'sizes'     => '(min-width: 960px) 960px, 100vw',
			] );

			if ( $thumb ) {
				$return = '<figure class="p-articleThumb">' . $thumb . $caption . '</figure>';
			}
		}

		return apply_filters( 'swell_parts_post_thumbnail', $return, $post_id, $is_youtube );

	}


	/**
	 * 3.0で消す
	 */
	public static function post_excerpt( $post_data, $length = null ) {
		return \SWELL_Theme::get_excerpt( $post_data, $length );
	}


	/**
	 * 3.0で消す
	 */
	public static function post_author( $author_id, $add_class = '', $is_link = false ) {

		if ( $is_link ) {
			return \SWELL_Theme::get_pluggable_parts( 'the_post_author', [
				'author_id' => $author_id,
			] );
		} else {
			return \SWELL_Theme::get_pluggable_parts( 'post_list_author', [
				'author_id' => $author_id,
			] );
		}
	}


	/** 
	 * タブ生成
	 * $tab_list : タブのラベルが保存された添字配列。
	 * $tab_style : 'タブスタイル名
	 * $ctrl_prefix : aria-selected にセットするID名の接頭辞
	*/
	public static function tab_list( $tab_list = [], $tab_style = 'balloon', $ctrl_prefix = 'tab-' ) {

		// タブブロックとの兼ね合いで、 'default' は 'balloon' へ。
		if ( $tab_style === 'default' ) $tab_style = 'balloon';

		ob_start();
	?>
		<div class="p-postListTab is-style-<?=$tab_style?>" data-width-pc="25" data-width-sp="50">
			<ul class="c-tabList" role="tablist">
				<?php 
					foreach ($tab_list as $num => $label) :
					// 最初のタブを選択状態に。
					$selected = ( $num === 0 ) ? 'true' : 'false';
					$num ++;
				?>
						<li class="c-tabList__item" role="presentation">
							<button 
								class="c-tabList__button"
								role="tab"
								aria-controls="<?=$ctrl_prefix . $num?>"
								aria-selected="<?=$selected?>"
								data-onclick="tabControl"
							>
								<?=$label?>
							</button>
						</li>
				<?php 
					endforeach;
				?>
			</ul>
		</div>
	<?php
		return ob_get_clean();
	}


	/**
	 * 3.0で消す
	 */
	public static function mv_btn( $args ) {
		return \SWELL_Theme::get_pluggable_parts( 'mv_btn', $args );
	}


	/**
	 * 3.0で消す
	 */
	public static function get_scroll_arrow( $type = 'slide' ) {
		$color = ( 'video' === $type ) ? \SWELL_Theme::get_setting( 'movie_txtcol' ) : \SWELL_Theme::get_setting( 'slider1_txtcol' );
		$return = \SWELL_Theme::get_pluggable_parts( 'scroll_arrow', ['color' => $color ] ); 
		return apply_filters( 'swell_parts_scroll_arrow', $return );
	}


	/**
	 * ランキングの星を作成
	 */
	public static function review_stars( $score = '' ) {

		$score = explode( '/', $score );
		$point = (double) $score[0];
		$denominator = isset( $score[1] ) ? (int) $score[1] : 5;

		$star = '';
		for ( $i = 0; $i < $denominator; $i++ ) { 
			$point = $point - 1;
			if ( $point === -0.5) {
				$star .= '<i class="icon-star-half"></i>';
			} elseif ( $point < 0) {
				$star .= '<i class="icon-star-empty"></i>';
			} else {
				$star .= '<i class="icon-star-full"></i>';
			}
		}
		return $star;
	}


	/**
	 * 目次広告
	 */
	public static function toc_ad() {
		$toc_adcode = \SWELL_Theme::get_setting( 'before_h2_addcode' );
		if ( empty( $toc_adcode ) ) return '';

		// apply_filters( 'swell_parts_toc_ad' );
		return '<div class="w-beforeToc"><div class="widget_swell_ad_widget">' . do_shortcode( $toc_adcode ) . '</div></div>';
	}


	/**
	 * カテゴリーの階層リストを出力
	 * 一つ上・一つ下の階層のみ取得。
	 */
	public static function the_term_navigation( $the_id = '' ) {

		$term = get_queried_object();
		if ( ! $term ) {
			return;
		}

		// tax名
		$taxonomy = $term->taxonomy;
		$show_term_navigation = 'category' === $taxonomy && \SWELL_Theme::get_setting( 'show_category_nav' );
		if ( ! apply_filters( 'swell_show_term_navigation', $show_term_navigation, $taxonomy, $the_id  ) ) {
			return;
		}

		// 親ターム
		$parent_nav = '';
		$parent_id = $term->parent;
		if ( 0 !== $parent_id ) {
			$parent_data = get_term( $parent_id, $taxonomy );
			$data_id     = 'data-' . $taxonomy . '-id="' . $parent_id . '"';
			$parent_nav .= '<a class="c-categoryList__link hov-flash-up" href="' . esc_url( get_term_link( $parent_data ) ) . '" ' . $data_id . '>' . $parent_data->name . '</a>';

			$parent_nav .= '<span class="c-categoryList__separation"></span>';
		}

		// 子ターム
		$child_nav = '';
		$child_terms = get_term_children( $the_id, $taxonomy );

		if ( ! empty( $child_terms ) ) {
			$child_nav .= '<span class="c-categoryList__separation"></span>';
			foreach ( $child_terms as $child_id ) {
				$child_data  = get_term( $child_id, $taxonomy );
				if ( $the_id !== $child_data-> parent ) continue; // 自身の子カテゴリのみ取得する

				$data_id     = 'data-' . $taxonomy . '-id="' . $child_id . '"';
				$child_nav .= '<a class="c-categoryList__link hov-flash-up" href="' . esc_url( get_term_link( $child_data ) ) . '" ' . $data_id . '>' . $child_data->name . '</a>';
			}
		};

		if ( '' !== $parent_nav || '' !== $child_nav ) {
			echo '<div class="p-termNavigation c-categoryList">' .
				$parent_nav .
				'<span class="c-categoryList__link -current">' . $term->name . '</span>' .
				$child_nav .
			'</div>';
		}
	}

}
