<?php
namespace SWELL_Theme;

use \SWELL_Theme as SWELL;

if ( ! defined( 'ABSPATH' ) ) exit;

class Json_Ld {

	// public function __construct() {}

	/**
	 * SSP有効化どうか
	 */
	public static function is_ssp_available() {
		return class_exists( '\SSP_Output' ) && method_exists( '\SSP_Output', 'get_meta_data' );
	}

	/**
	 * サイトのタイトルを取得
	 */
	public static function get_the_site_title() {
		$title = '';
		if ( self::is_ssp_available() && method_exists( '\SSP_Output', 'get_front_data' ) ) {
			$title = \SSP_Output::get_front_data( 'title' ) ?: '';
		} else {
			$title = get_option( 'blogname' );
		}

		return $title;
	}

	/**
	 * サイトの説明を取得
	 */
	public static function get_the_site_description() {
		$description = '';
		if ( self::is_ssp_available() && method_exists( '\SSP_Output', 'get_front_data' ) ) {
			$description = \SSP_Output::get_front_data( 'description' ) ?: '';
		} else {
			$description = get_option( 'blogdescription' );
		}
		return $description;
	}

	/**
	 * 現在のページのタイトルを取得
	 */
	public static function get_the_page_title() {
		$title = '';
		if ( self::is_ssp_available() ) {
			$title = \SSP_Output::get_meta_data( 'title' ) ?: '';
		} elseif ( is_singular() ) {
			$title = wp_strip_all_tags( get_the_title() );
		}

		return $title;
	}

	/**
	 * 現在のページのURLを取得
	 */
	public static function get_the_page_url() {
		$url = '';

		switch ( true ) {
			case self::is_ssp_available():
				$url = \SSP_Output::get_meta_data( 'canonical' ) ?: '';
				break;
			case is_front_page():
				$url = home_url( '/' );
				break;
			case is_home():
				if ( ! get_queried_object_id() ) {
					$url = home_url( '/' );
				} else {
					$url = get_permalink( get_queried_object_id() ) ?: '';
				}
				break;
			case is_singular():
				$url = get_permalink();
				break;
			case is_tax() || is_tag() || is_category():
				$term = get_queried_object();
				if ( ! isset( $term->taxonomy ) ) break;
				$url = get_term_link( $term, $term->taxonomy );
				break;
			case is_author():
				$url = get_author_posts_url( get_query_var( 'author' ), get_query_var( 'author_name' ) );
				break;
			default:
				break;
		}

		if ( is_wp_error( $url ) ) {
			$url = '';
		}

		return $url;
	}

	/**
	 * 現在のページのアイキャッチを取得
	 */
	public static function get_the_page_thumb() {
		$thumb = '';
		if ( self::is_ssp_available() ) {
			$thumb = \SSP_Output::get_meta_data( 'og_image' ) ?: SWELL::get_noimg( 'url' );
		} elseif ( is_singular() ) {
			$thumb = get_the_post_thumbnail_url( get_the_ID(), 'full' ) ?: SWELL::get_noimg( 'url' );
		}

		return $thumb;
	}

	/**
	 * 現在のページの説明を取得
	 */
	public static function get_the_page_description() {
		$description = '';
		if ( self::is_ssp_available() ) {
			$description = \SSP_Output::get_meta_data( 'description' ) ?: '';
		} elseif ( is_singular() ) {
			$post_data = get_queried_object();
			if ( ! empty( $post_data ) ) {
				$description = $post_data->post_content ?? '';
				$description = wp_strip_all_tags( strip_shortcodes( $description ), true );
				$description = mb_substr( $description, 0, 300 );
			}
		}
		return $description;
	}


	/**
	 * 現在のページの説明を取得
	 */
	public static function get_the_logo_data( $logo_id ) {
		if ( ! $logo_id ) return null;

		$image = wp_get_attachment_image_src( $logo_id, 'full', false );
		if ( empty( $image ) ) return null;

		list( $src, $width, $height ) = $image;
		return [
			'@type'  => 'ImageObject',
			'url'    => $src,
			'width'  => $width,
			'height' => $height,
		];
	}


	/**
	 * パブリッシャー（type: Organization）情報
	 */
	public static function get_organization_data() {
		$data = [
			'@type'         => 'Organization',
			'@id'           => home_url( '/#organization' ),
		];

		$custom_name = SWELL::get_option( 'ld_org_name' );
		$custom_url  = SWELL::get_option( 'ld_org_url' );

		// 組織情報の入力がある場合
		if ( $custom_url && $custom_name ) {

			$data = [
				'@type'         => 'Organization',
				'@id'           => home_url( '/#organization' ),
				'name'          => $custom_name,
				'url'           => $custom_url,
				'logo'          => self::get_the_logo_data( SWELL::get_option( 'ld_org_logo' ) ),
				// 'image'         => '',
				'alternateName' => SWELL::str_to_array( SWELL::get_option( 'ld_org_alternateName' ) ),
				'sameAs'        => SWELL::str_to_array( SWELL::get_option( 'ld_org_sameAs' ) ),
			];

			$founder = [
				'name'          => SWELL::get_option( 'ld_org_founder_name' ),
				'url'           => SWELL::get_option( 'ld_org_founder_url' ),
				'alternateName' => SWELL::str_to_array( SWELL::get_option( 'ld_org_founder_alternateName' ) ),
				'sameAs'        => SWELL::str_to_array( SWELL::get_option( 'ld_org_founder_sameAs' ) ),
			];
			$founder = array_filter( $founder );
			if ( $founder ) {
				$data['founder'] = array_merge( [ '@type' => 'Person' ], $founder );
			}
		} else {
			// 指定がない場合はサイト情報を使う
			$data = [
				'@type'         => 'Organization',
				'@id'           => home_url( '/#organization' ),
				'name'          => SWELL::site_data( 'title' ),
				'url'           => home_url( '/' ),
				'logo'          => self::get_the_logo_data( SWELL::site_data( 'logo_id' ) ),
			];

			$data['name'] = SWELL::site_data( 'title' );
			$data['url']  = home_url( '/' );
			$logo_id      = SWELL::site_data( 'logo_id' );
			if ( $logo_id ) {
				$data['logo'] = self::get_the_logo_data( $logo_id );
			}
		}

		// 空の値を削除して返す
		$data = array_filter( $data );
		return apply_filters( 'swell_json_ld__organization', $data );
	}



	/**
	 * @type: WebSite を生成
	 */
	public static function get_website_data() {
		// memo : SearchAction{s}は検索フォームのnameに合わせる
		$data = [
			'@type'           => 'WebSite',
			'@id'             => home_url( '/#website' ),
			'url'             => home_url( '/' ),
			'name'            => self::get_the_site_title(),
			'description'     => self::get_the_site_description(),
			// ↓ フロントページでは組織データが入力されている場合はつける？
			// 'publisher'       => [
			// 	'@id' => 'https://yoast.com/#organization',
			// ],
		];

		if ( is_front_page() ) {
			$data['potentialAction'] = [
				'@type'       => 'SearchAction',
				'target'      => home_url( '/?s={s}' ),
				'query-input' => 'name=s required',
			];
		}

		// 空の値を削除して返す
		$data = array_filter( $data );
		return apply_filters( 'swell_json_ld__website', $data );
	}

	/**
	 * @type: WebPage を生成
	 */
	public static function get_webpage_data( $has_publisher = true ) {
		$data = [];
		$url  = self::get_the_page_url();
		if ( $url ) {
			$data = [
				// '@context'        => 'http://schema.org',
				'@type'           => 'WebPage',
				'@id'             => $url,
				'url'             => $url,
				'name'            => self::get_the_page_title(),
				'description'     => self::get_the_page_description(),
				'isPartOf'        => [
					'@id' => home_url( '/#website' ),
				],
			];
			if ( $has_publisher ) {
				$data['publisher'] = [
					'@id' => home_url( '/#organization' ),
				];
			}
			$data = array_filter( $data ); // 空の値を削除
		}
		return apply_filters( 'swell_json_ld__webpage', $data );
	}

	/**
	 * @type: WebPage を生成
	 */
	public static function get_collectionpage_data() {

		$data = [];
		$url  = self::get_the_page_url();
		if ( $url ) {
			$data = [
				'@type'           => 'CollectionPage',
				'@id'             => $url,
				'url'             => $url,
				'name'            => self::get_the_page_title(),
				'description'     => self::get_the_page_description(),
				'isPartOf'        => [
					'@id' => home_url( '/#website' ),
				],
				'publisher'       => [
					'@id' => home_url( '/#organization' ),
				],
			];
			$data = array_filter( $data ); // 空の値を削除
		}
		return apply_filters( 'swell_json_ld__collectionpage', $data );
	}


	/**
	 * 投稿・固定ページの JSON-LD
	 * See: https://developers.google.com/search/docs/advanced/structured-data/article
	 */
	public static function get_article_data() {

		$post_data = get_queried_object();
		if ( empty( $post_data ) ) return [];

		$the_id   = $post_data->ID;
		$headline = wp_strip_all_tags( get_the_title( $the_id ) );
		$url      = self::get_the_page_url(); //get_permalink( $the_id );
		$thumb    = self::get_the_page_thumb();

		$data = [
			// '@id'               => $url . '#article' ),
			'@type'            => 'Article',
			'mainEntityOfPage' => [
				'@type' => 'WebPage',
				'@id'   => $url,
			],
			'headline'         => $headline,
			'image'            => [
				'@type' => 'ImageObject',
				'url'   => $thumb,
			],
			'datePublished'    => get_the_date( DATE_ISO8601 ),
			'dateModified'     => get_the_modified_date( DATE_ISO8601 ),
			'author'           => self::get_author_data( $post_data->post_author, $url ),
			'publisher'        => [
				'@id' => home_url( '/#organization' ),
			],

			// → #website 側に記載
			// 'description'       => self::get_the_page_description(),
			// 'isPartOf'        => [
			// 	'@id' => home_url( '/#website' ),
			// ],
		];

		return apply_filters( 'swell_json_ld__article', $data, $the_id );
	}


	/**
	 * 著者情報
	 * See: https://developers.google.com/search/docs/advanced/structured-data/article
	 */
	public static function get_author_data( $author_id, $url ) {
		if ( ! $author_id ) return [];

		$author_data   = get_userdata( $author_id );
		$author_type   = get_user_meta( $author_id, 'schema_type', 1 ) ?: 'Person';
		$sameAs        = get_user_meta( $author_id, 'schema_sameAs', 1 );
		$alternateName = get_user_meta( $author_id, 'schema_alternateName', 1 );

		$data = [
			'@type'         => $author_type,
			'@id'           => rtrim( $url, '/' ) . '/#author',
			'name'          => get_user_meta( $author_id, 'schema_name', 1 ) ?: $author_data->display_name,
			'url'           => get_user_meta( $author_id, 'schema_url', 1 ) ?: $author_data->user_url ?: home_url( '/' ),
			'sameAs'        => SWELL::str_to_array( $sameAs ),
			'alternateName' => SWELL::str_to_array( $alternateName ),
		];

		if ( 'Person' === $author_type ) {
			$data['jobTitle']        = get_user_meta( $author_id, 'schema_jobTitle', 1 ) ?: get_user_meta( $author_id, 'position', 1 );
			$data['honorificPrefix'] = get_user_meta( $author_id, 'schema_honorificPrefix', 1 );
			$data['honorificSuffix'] = get_user_meta( $author_id, 'schema_honorificSuffix', 1 );
		} else {
			$data['logo'] = get_user_meta( $author_id, 'schema_logo_url', 1 );
		}

		// 空の値を削除
		$data = array_filter( $data );

		return apply_filters( 'swell_json_ld__author', $data, $author_id );
	}


	/**
	 * パンくずリストの JSON-LD
	 */
	public static function get_bread_data( $bread_json_data ) {
		if ( empty( $bread_json_data ) ) return [];

		$pos       = 1;
		$item_json = [];
		foreach ( $bread_json_data as $data ) :
			$item_json[] = [
				'@type'    => 'ListItem',
				'position' => $pos,
				'item'     => [
					'@id'  => $data['url'],
					'name' => wp_strip_all_tags( $data['name'] ),
				],
			];
			++$pos;
		endforeach;

		$bread_json = [
			'@type'           => 'BreadcrumbList',
			'@id'             => home_url( '/#breadcrumb' ),
			'itemListElement' => $item_json,
		];

		return $bread_json;
	}


	/**
	 * 全体を生成
	 */
	public static function get_ld_data() {
		$json_lds = [];

		$json_lds['Organization'] = self::get_organization_data();

		if ( SWELL::is_top() ) {

			$json_lds['WebSite'] = self::get_website_data();

		} elseif ( is_archive() || is_home() ) {

			$json_lds['WebSite']        = self::get_website_data();
			$json_lds['Collectionpage'] = self::get_collectionpage_data();

		} elseif ( is_singular() ) {

			$json_lds['WebSite'] = self::get_website_data();
			$json_lds['WebPage'] = self::get_webpage_data( false );
			$json_lds['Article'] = self::get_article_data();

		} else {

			$json_lds['WebSite'] = self::get_website_data();
			$json_lds['WebPage'] = self::get_webpage_data();

		}

		// パンくずリスト（BreadcrumbList）
		$bread_json = self::get_bread_data( SWELL::$bread_json_data );
		if ( ! empty( $bread_json ) ) {
			$json_lds['BreadcrumbList'] = $bread_json;
		}

		return apply_filters( 'swell_json_ld', $json_lds );
	}


	/**
	 * JSON-LD 生成
	 */
	public static function generate() {
		$json_lds = self::get_ld_data();
		if ( ! is_array( $json_lds ) || empty( $json_lds ) ) return '';

		// @graph 使わない書き方
		// $json_ld = wp_json_encode( array_values( $json_lds ), JSON_UNESCAPED_UNICODE );

		// @graph 使う書き方
		$output_lds = [];
		foreach ( $json_lds as $data ) {
			if ( empty( $data ) ) continue;
			$output_lds[] = wp_json_encode( $data, JSON_UNESCAPED_UNICODE );
		}

		if ( empty( $output_lds ) ) return '';

		return '{"@context": "https://schema.org","@graph": [' . implode( ',', $output_lds ) . ']}';
	}

}
