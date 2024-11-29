<?php
use \SWELL_Theme as SWELL;

if ( ! defined( 'ABSPATH' ) ) exit;

// @codingStandardsIgnoreStart


/**
 * SWELL_FUNC は 名前空間なしでどのファイルからでも簡単に呼び出せるように。
 */
class SWELL_FUNC {

	/**
	 * 外部からのインタンス呼び出し無効
	 */
	private function __construct() {}

	/**
	 * 3.0で消す
	 */
	public static function get_setting( $key = null ) {
		return SWELL::get_setting( $key );
	}
	public static function get_option( $key = null ) {
		return SWELL::get_option( $key );
	}
	public static function get_editor( $key = null ) {
		return SWELL::get_editor( $key );
	}
	public static function root_attrs() {
		SWELL::root_attrs();
	}
	public static function body_attrs() {
		SWELL::body_attrs();
	}
	public static function content_attrs() {
		SWELL::content_attrs();
	}
	public static function lp_content_attrs() {
		SWELL::lp_content_attrs();
	}
	public static function get_frame_class() {
		return SWELL::get_frame_class();
	}
	public static function get_header_class() {
		return SWELL::get_header_class();
	}
	public static function get_archive_data() {
		return SWELL::get_archive_data();
	}
	public static function is_show_thumb( $post_id ) {
		return SWELL::is_show_thumb( $post_id );
	}
	public static function is_show_ttltop() {
		return SWELL::is_show_ttltop();
	}
	public static function is_show_index() {
		return SWELL::is_show_index();
	}
	public static function is_show_toc_ad( $in_shortcode = false ) {
		return SWELL::is_show_toc_ad( $in_shortcode );
	}
	public static function is_show_sidebar() {
		return SWELL::is_show_sidebar();
	}
	public static function is_show_comments( $post_id ) {
		return SWELL::is_show_comments( $post_id );
	}
	public static function is_show_pickup_banner() {
		return SWELL::is_show_pickup_banner();
	}
	public static function get_file_contents( $file ) {
		return SWELL::get_file_contents( $file );
	}
	public static function default_head_menu() {
		SWELL::default_head_menu();
	}
	public static function get_mv_text_style( $text_color, $shadow_color ) {
		return SWELL::get_mv_text_style( $text_color, $shadow_color );
	}
	public static function get_link_target( $url ) {
		return SWELL::get_link_target( $url );
	}
	public static function set_post_views( $post_id ) {
		SWELL::set_post_views( $post_id );
	}
	public static function get_author_data( $author_id ) {
		return SWELL::get_author_data($author_id);
	}
	public static function get_sns_settings(){
		return SWELL::get_sns_settings();
	}
	public static function get_thumbnail( $the_id, $args, $is_term = false ) {
		if ( $is_term ) {
			$args['term_id'] = $the_id;
			return SWELL::get_thumbnail( $args );
		}
		$args['post_id'] = $the_id;
		return SWELL::get_thumbnail( $args );
	}

	/**
	 * テンプレート読み込み 3.0で消す
	 */
	public static function get_parts( $path = '', $variable = null, $cache_key = '', $expiration = null ) {
		SWELL::get_parts( $path, $variable, $cache_key, $expiration );
	}

	/**
	 * カテゴリーを出力 3.0で消す
	 */
	public static function get_the_term_links( $post_id = '', $tax = '' ) {
		if ( $tax === 'cat' ) {
			$terms = get_the_category( $post_id );
			$link_class = 'c-categoryList__link hov-flash-up';
		} elseif ( $tax === 'tag' ) {
			$terms = get_the_tags( $post_id );
			$link_class = 'c-tagList__link hov-flash-up';
		} else {
			$terms = null;
			$link_class = '';
		}

		if ( empty( $terms ) ) return '';
		$thelist = '';
		foreach ( $terms as $term ) {
			$term_link = get_term_link( $term );
			$data_id = 'data-'. $tax .'-id="'. $term->term_id .'"';
			$thelist .= '<a class="'. $link_class .'" href="' . esc_url( $term_link ) . '" '. $data_id .'>'. esc_html( $term->name ) . '</a>';
		}

		return apply_filters( 'swell_get_the_term_links', $thelist, $post_id, $tax );
	}

}
