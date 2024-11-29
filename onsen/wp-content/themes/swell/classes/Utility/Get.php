<?php
namespace SWELL_Theme\Utility;

if ( ! defined( 'ABSPATH' ) ) exit;

use \SWELL_Theme as SWELL;

trait Get {

	/**
	 * languagesフォルダの取得
	 */
	public static function get_languages_dir() {
		// 子テーマ側から探す
		if ( file_exists( S_DIRE . '/languages' ) ) {
			return S_DIRE . '/languages';
		}

		// なければ親テーマ
		return T_DIRE . '/languages';
	}


	/**
	 * ブロックフォルダのパス
	 */
	public static function get_block_path( $root, $block_name, $file = '' ) {
		if ( $file ) {
			return "{$root}/build/gutenberg/blocks/{$block_name}/{$file}";
		}
		return "{$root}/build/gutenberg/blocks/{$block_name}";
	}


	/**
	 * $site_data の値を取得
	 */
	public static function site_data( $key ) {
		if ( ! isset( self::$site_data[ $key ] ) ) {
			return '';
		}
		return self::$site_data[ $key ];
	}


	/**
	 * $noimg の値を取得
	 */
	public static function get_noimg( $key ) {
		if ( ! isset( self::$noimg[ $key ] ) ) {
			return '';
		}
		return self::$noimg[ $key ];
	}


	/**
	 * フレーム設定を取得する
	 */
	public static function get_frame_class() {

		// キャッシュ取得
		$cached_class = wp_cache_get( 'frame_class', 'swell' );
		if ( $cached_class ) return $cached_class;

		$content_frame = self::get_setting( 'content_frame' );
		$frame_scope   = self::get_setting( 'frame_scope' );

		$frame_class = '';
		if ( 'frame_off' === $content_frame ) {
			$frame_class = '-frame-off';
		} else {
			$is_page = is_page() && ! is_front_page();

			if ( 'no_front' === $frame_scope && is_front_page() ) {
				$frame_class = '-frame-off';
			} elseif ( 'page' === $frame_scope && ! $is_page ) {
				$frame_class = '-frame-off';
			} elseif ( 'post' === $frame_scope && ! is_single() ) {
				$frame_class = '-frame-off';
			} elseif ( 'post_page' === $frame_scope && ! is_single() && ! $is_page ) {
				$frame_class = '-frame-off';
			} else {
				// フレーム オン
				$frame_class  = '-frame-on';
				$frame_class .= ( 'frame_on_main' === $content_frame ) ? ' -frame-off-sidebar' : ' -frame-on-sidebar';

				// さらに「線で囲む」がオンの場合
				if ( self::get_setting( 'on_frame_border' ) ) {
					$frame_class .= ' -frame-border';
				}
			}
		}

		$frame_class = apply_filters( 'swell_frame_class', $frame_class );
		wp_cache_set( 'frame_class', $frame_class, 'swell' );
		return $frame_class;
	}


	/**
	 * ヘッダーのクラス
	 */
	public static function get_header_class() {
		// キャッシュ取得
		$cached_class = wp_cache_get( 'header_class', 'swell' );
		if ( $cached_class ) return $cached_class;

		$header_layout = str_replace( '_', '-', self::get_setting( 'header_layout' ) );
		switch ( $header_layout ) {
			case 'parallel-top':
			case 'parallel-bottom':
				$header_class = '-parallel -' . $header_layout;
				break;
			case 'sidefix':
				$header_class = '-sidefix';
				break;
			default:
				$header_class = '-series -' . $header_layout;
				break;
		}

		// ヒーローヘッダーの時だけトップページに付与するクラス
		if ( self::is_use( 'top_header' ) ) {
			$header_transparent = str_replace( '_', '-', self::get_setting( 'header_transparent' ) ); // no | t-fff | t-000
			$header_class      .= ' -transparent -' . $header_transparent;
		}

		wp_cache_set( 'header_class', $header_class, 'swell' );
		return $header_class;
	}


	/**
	 * キャプションカラーデータ: パレットの表示に使用する
	 */
	public static function get_cap_colors_data() {
		return [
			[
				'value'  => 'col1',
				'label'  => __( 'カラーセット', 'swell' ) . '1',
				'border' => self::get_editor( 'color_cap_01' ),
				'bg'     => self::get_editor( 'color_cap_01_light' ),
			],
			[
				'value'  => 'col2',
				'label'  => __( 'カラーセット', 'swell' ) . '2',
				'border' => self::get_editor( 'color_cap_02' ),
				'bg'     => self::get_editor( 'color_cap_02_light' ),
			],
			[
				'value'  => 'col3',
				'label'  => __( 'カラーセット', 'swell' ) . '3',
				'border' => self::get_editor( 'color_cap_03' ),
				'bg'     => self::get_editor( 'color_cap_03_light' ),
			],
		];
	}


	/**
	 * ブログパーツデータ
	 */
	public static function get_blog_parts_data() {
		$return_data = [];
		$args        = [
			'post_type'              => 'blog_parts',
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'posts_per_page'         => -1,
		];
		$the_query   = new \WP_Query( $args );

		while ( $the_query->have_posts() ) :
			$the_query->the_post();
			$parts_id    = get_the_ID();
			$parts_title = get_the_title();
			$use_terms   = get_the_terms( $parts_id, 'parts_use' );

			$term_id = $use_terms ? $use_terms[0]->term_id : '';

			$return_data[ $parts_id ] = [
				'title'   => $parts_title,
				'term_id' => $term_id,
			];
		endwhile;
		wp_reset_postdata();

		return $return_data;
	}


	/**
	 * ブログパーツの用途を取得
	 */
	public static function get_blog_parts_uses() {
		$parts_uses = get_terms( 'parts_use', [
			'hide_empty' => false,
			'fields'     => 'id=>name',
		] );

		$return_data = [];
		foreach ( $parts_uses as $id => $name ) {
			$return_data[ $id ] = $name;
		}
		return $return_data;
	}



	/**
	 * 広告タグのデータ
	 */
	public static function get_ad_tag_data() {
		$return_data = [];
		$args        = [
			'post_type'              => 'ad_tag',
			'no_found_rows'          => true,
			'update_post_term_cache' => false,
			'posts_per_page'         => -1,
			// 'update_post_meta_cache' => false,
		];

		$the_query = new \WP_Query( $args );
		while ( $the_query->have_posts() ) :
			$the_query->the_post();
			$adTag_id    = get_the_ID();
			$adTag_title = get_the_title();
			$adTag_type  = get_post_meta( $adTag_id, 'ad_type', true );

			$return_data[] = [
				'id'    => $adTag_id,
				'title' => $adTag_title,
				'type'  => $adTag_type,
			];
		endwhile;
		wp_reset_postdata();

		return $return_data;
	}


	/**
	 * 抜粋文を取得
	 */
	public static function get_excerpt( $post_data, $length = null ) {
		$length = null === $length ? (int) self::$excerpt_length : (int) $length;

		// 抜粋非表示の時
		if ( $length === 0 ) {
			return '';
		}

		// 抜粋文 作成
		if ( ! empty( $post_data->post_excerpt ) ) {

			// 「抜粋」の入力内容を優先
			$excerpt = strip_tags( $post_data->post_excerpt, '<br><i>' );
			$excerpt = do_shortcode( $excerpt );

		} elseif ( ! empty( $post_data->post_password ) ) {

			// パスワード保護の記事の場合
			$excerpt = __( 'この記事はパスワードで保護されています', 'swell' );

		} else {
			// 通常
			$excerpt = strip_shortcodes( $post_data->post_content );
			$excerpt = preg_replace( '/<h2.*>(.*?)<\/h2>/i', '【$1】', $excerpt );
			$excerpt = preg_replace( '/<rt.*>.*<\/rt>/i', '', $excerpt ); // ルビのふりがな削除
			$excerpt = wp_strip_all_tags( $excerpt, true );
			// $excerpt = mb_substr( $excerpt, 0, $length )." ... ";
			if ( mb_strwidth( $excerpt, 'UTF-8' ) > $length * 2 ) {
				$excerpt = mb_strimwidth( $excerpt, 0, $length * 2, '...', 'UTF-8' );
			}
		}
		return $excerpt;
	}


	/**
	 * 著者情報を取得
	 */
	public static function get_author_icon_data( $author_id ) {
		if ( ! $author_id ) return null;

		$cache_key = "post_author_icon_{$author_id}";

		// キャッシュ取得
		$cached_data = wp_cache_get( $cache_key, 'swell' );
		if ( $cached_data ) return $cached_data;

		$author_data = get_userdata( $author_id );
		if ( false === $author_data ) {
			return null;
		}

		$data = [
			'name'   => $author_data->display_name,
			'avatar' => get_avatar( $author_id, 100, '', '' ),
			'url'    => get_author_posts_url( $author_id ),
		];

		wp_cache_set( $cache_key, $data, 'swell' );
		return $data;
	}


	/**
	 * アイキャッチ画像を取得
	 * memo : image_downsize( $img_id, 'medium' );
	 */
	public static function get_thumbnail( $args ) {
		$post_id   = $args['post_id'] ?? 0;
		$term_id   = $args['term_id'] ?? 0;
		$class     = $args['class'] ?? '';
		$lazy_type = $args['lazy_type'] ?? self::$lazy_type;
		$decoding  = $args['decoding'] ?? false;
		$use_noimg = $args['use_noimg'] ?? true;
		$echo      = $args['echo'] ?? false;
		// $placeholder = $args['placeholder'] ?? ''; // 後方互換用

		$thumb_id  = 0;
		$thumb_url = '';

		if ( $term_id ) {

			$thumb_id = self::get_term_thumb_id( $term_id );
			if ( is_string( $thumb_id ) ) {
				$thumb_url = $thumb_id; // 昔はURLデータを保存してた
			}
		} elseif ( has_post_thumbnail( $post_id ) ) {

			$thumb_id = get_post_thumbnail_id( $post_id );

		} elseif ( $use_noimg ) {

			$thumb_id = self::get_noimg( 'id' );
			if ( ! $thumb_id ) {
				$thumb_url = self::get_noimg( 'url' );
			}
		}

		// ソース置換
		if ( $thumb_id ) {

			$thumb = self::get_image( $thumb_id, [
				'class'    => $class,
				'size'     => $args['size'] ?? 'full',
				'sizes'    => $args['sizes'] ?? false,
				'srcset'   => $args['srcset'] ?? false,
				'decoding' => $decoding,
				'loading'  => $lazy_type,
			]);

		} elseif ( $thumb_url ) {

			$thumb = '<img src="' . esc_url( $thumb_url ) . '" alt="" class="' . esc_attr( $class ) . '">';
			$thumb = self::set_lazyload( $thumb, self::$lazy_type );

		} else {
			return '';
		}

		if ( $echo ) {
			echo $thumb; // phpcs:ignore
		}
		return $thumb;
	}


	/**
	 * attachment_url_to_postid のキャッシュあり版
	 */
	public static function get_imgid_from_url( $img_url ) {
		$cache_key = 'swell_imgid_' . md5( $img_url );

		// キャッシュチェック
		$cached_id = get_transient( $cache_key );
		if ( $cached_id ) return $cached_id;

		$img_id = attachment_url_to_postid( $img_url ) ?: 0;

		set_transient( $cache_key, $img_id, DAY_IN_SECONDS * 30 );
		return $img_id;
	}


	/**
	 * アーカイブページのデータを取得
	 */
	public static function get_archive_data() {
		if ( ! is_archive() ) return false;

		$data = [
			'type'  => 'Archives',
			'title' => 'title',
		];

		if ( is_post_type_archive() ) {
			// 投稿タイプのアーカイブページなら

			$data['title'] = post_type_archive_title( '', false );
			$data['type']  = 'pt_archive';

		} elseif ( is_category() ) {

			$data['title'] = single_term_title( '', false );
			$data['type']  = 'category';

		} elseif ( is_tag() ) {

			$data['title'] = single_term_title( '', false );
			$data['type']  = 'tag';

		} elseif ( is_tax() ) {

			$data['title'] = single_term_title( '', false );
			$data['type']  = 'tax';

		} elseif ( is_author() ) {
			$obj = get_queried_object();
			if ( isset( $wp_obj->display_name ) ) {
				$data['title'] = $wp_obj->display_name;
				$data['type']  = 'author';
			}
		} elseif ( is_date() ) {
			// 日付アーカイブなら
			$ymd_title = '';

			// see:get_the_archive_title();
			// https://core.trac.wordpress.org/browser/tags/6.0.2/src/wp-includes/general-template.php#L1694
			// phpcs:disable WordPress.WP.I18n.MissingArgDomain
			if ( is_year() ) {
				$ymd_title = get_the_date( _x( 'Y', 'yearly archives date format' ) );
			} elseif ( is_month() ) {
				$ymd_title = get_the_date( _x( 'F Y', 'monthly archives date format' ) );
			} elseif ( is_day() ) {
				$ymd_title = get_the_date( _x( 'F j, Y', 'daily archives date format' ) );
			}
			// phpcs:enable WordPress.WP.I18n.MissingArgDomain

			$data['title'] = $ymd_title;
			$data['type']  = 'date';

		}

		$data = apply_filters( 'swell_get_archive_data', $data );
		return $data;
	}


	/**
	 * アイキャッチ画像のURLを取得
	 */
	public static function get_thumb_url_for_blogcard( $type, $id ) {
		$thumb = '';
		if ( 'post' === $type && has_post_thumbnail( $id ) ) {
			$thumb_id   = get_post_thumbnail_id( $id );
			$thumb_data = wp_get_attachment_image_src( $thumb_id, 'medium' );
			$thumb      = $thumb_data[0];
		} elseif ( 'term' === $type ) {
			$thumb_id = self::get_term_thumb_id( $id );
			if ( $thumb_id ) {
				$thumb_data = wp_get_attachment_image_src( $thumb_id, 'medium' );
				$thumb      = $thumb_data[0];
			} else {
				$thumb = self::get_noimg( 'small' );
			}
		} else {
			$thumb = self::get_noimg( 'small' );
		}

		return $thumb ?: '';
	}


	/**
	 * 内部リンクのブログカード化
	 */
	public static function get_internal_blog_card( $id, $card_args = [] ) {
		return self::get_internal_blog_card_v2([
			'link_id'   => $id,
			'card_args' => $card_args,
		]);
	}


	/**
	 * 内部リンクのブログカード化
	 */
	public static function get_internal_blog_card_v2( $args ) {
		$link_id   = $args['link_id'] ?? '';
		$kind      = $args['kind'] ?? 'post-type';
		$type      = $args['type'] ?? '';
		$card_args = $args['card_args'] ?? [];

		// $caption = '', $is_blank = false, $rel = '', $noimg = false;
		$is_post_link = 'post-type' === $kind;

		if ( $is_post_link ) {
			$cache_key = 'swell_card_id' . $link_id;
		} else {
			$cache_key = "swell_card_id_{$kind}_{$link_id}";
		}

		// キャッシュがあるか調べる
		$card_data = false; //self::is_use( 'card_cache__in' ) ? get_transient( $cache_key ) : null;

		// キャッシュがなければ
		if ( ! $card_data ) {

			$card_data = [];
			if ( $is_post_link ) {
				$post_data = get_post( $link_id );
				if ( ! $post_data ) {
					return __( '投稿が見つかりません。', 'swell' );
				}

				$title   = get_the_title( $link_id );
				$url     = get_permalink( $link_id );
				$excerpt = self::get_excerpt( $post_data, 80 );

				if ( mb_strwidth( $title, 'UTF-8' ) > 100 ) {
					$title = mb_strimwidth( $title, 0, 100, '...', 'UTF-8' );
				}
				$card_data = [
					'url'     => $url,
					'title'   => $title,
					'thumb'   => self::get_thumb_url_for_blogcard( 'post', $link_id ),
					'excerpt' => $excerpt,
				];
			} elseif ( 'taxonomy' === $kind ) {

				$the_term = get_term( $link_id, $type );

				if ( empty( $the_term ) || is_wp_error( $the_term ) ) {
					$card_data = [
						'url'     => '###',
						'title'   => 'Error: Failed to get term',
					];
				} else {
					$card_data = [
						'url'     => get_term_link( $the_term ),
						'title'   => $the_term->name ?? '',
						'excerpt' => $the_term->description ?? '',
						'thumb'   => self::get_thumb_url_for_blogcard( 'term', $link_id ),
					];
				}
			}

			if ( self::is_use( 'card_cache__in' ) ) {
				$day = self::get_setting( 'cache_card_time' ) ?: 30;
				set_transient( $cache_key, $card_data, DAY_IN_SECONDS * intval( $day ) );
			}
		}

		$card_data              = array_merge( $card_data, $card_args );
		$card_data['add_class'] = '-internal';
		$card_data['type']      = self::get_editor( 'blog_card_type' ) ?: 'type1';

		// カードスタイルで分岐
		$card_style = $card_data['style'] ?? '';
		if ( 'text' === $card_style || 'slim' === $card_style ) {
			return self::get_pluggable_parts( 'blog_link', $card_data );
		}
		return self::get_pluggable_parts( 'blog_card', $card_data );
	}


	/**
	 * 外部サイトのブログカード
	 */
	public static function get_external_blog_card( $url, $card_args = [] ) {

		$card_data = '';
		$cache_key = '';

		// キャッシュがあるか調べる
		if ( self::is_use( 'card_cache__ex' ) ) {
			$url_hash  = md5( $url );
			$cache_key = 'swell_card_' . $url_hash;
			$card_data = get_transient( $cache_key );

			if ( ! isset( $card_data['site_name'] ) ) {
				// キャプション不具合修正時のコード変更に対応
				delete_transient( $cache_key );
				$card_data = '';
			}
		}

		if ( ! $card_data ) {

			// Get_OGP_InWP の読み込み
			require_once T_DIRE . '/classes/plugins/get_ogp_inwp.php';

			$ogps = \Get_OGP_InWP::get( $url );
			if ( empty( $ogps ) ) return $url;

			// 必要なデータを抽出
			$card_data = \Get_OGP_InWP::extract_card_data( $ogps );

			$title       = $card_data['title'];
			$description = $card_data['description'];
			$site_name   = $card_data['site_name'];
			$thumb_url   = $card_data['thumbnail'];
			// $icon        = $card_data['icon'];

			// 文字数で切り取り
			if ( mb_strwidth( $title, 'UTF-8' ) > 100 ) {
				$title = mb_strimwidth( $title, 0, 100 ) . '...';
			}
			if ( mb_strwidth( $description, 'UTF-8' ) > 160 ) {
				$description = mb_strimwidth( $description, 0, 160 ) . '...';
			}
			if ( mb_strwidth( $site_name, 'UTF-8' ) > 32 ) {
				$site_name = mb_strimwidth( $site_name, 0, 32 ) . '...';
			}

			$card_data = [
				'url'       => $url,
				'site_name' => $site_name,
				'title'     => $title,
				'thumb'     => $thumb_url,
				'excerpt'   => $description,
			];

			if ( self::is_use( 'card_cache__ex' ) ) {
				$day = self::get_setting( 'cache_card_time' ) ?: 30;
				set_transient( $cache_key, $card_data, DAY_IN_SECONDS * intval( $day ) );
			}
		}

		// デフォルトでは別窓（後方互換用・URL自動変換用）
		$card_data['is_blank'] = true;

		$card_data              = array_merge( $card_data, $card_args );
		$card_data['add_class'] = '-external';
		$card_data['type']      = self::get_editor( 'blog_card_type_ex' ) ?: 'type3';

		// カードスタイルで分岐
		$card_style = $card_data['style'] ?? '';
		if ( 'text' === $card_style || 'slim' === $card_style ) {
			return self::get_pluggable_parts( 'blog_link', $card_data );
		}
		return self::get_pluggable_parts( 'blog_card', $card_data );
	}


	/**
	 * 著者情報を取得
	 */
	public static function get_author_data( $author_id ) {
		if ( ! $author_id ) return [];

		$return_data = [];
		$author_data = get_userdata( $author_id );

		$return_data['name']          = $author_data->display_name;
		$return_data['description']   = $author_data->description;
		$return_data['position']      = get_the_author_meta( 'position', $author_id );
		$return_data['blog_parts_id'] = get_the_author_meta( 'blog_parts_id', $author_id );

		$sns_list              = [];
		$sns_list['home']      = $author_data->user_url ?: '';
		$sns_list['home2']     = get_the_author_meta( 'site2', $author_id ) ?: '';
		$sns_list['facebook']  = get_the_author_meta( 'facebook_url', $author_id ) ?: '';
		$sns_list['twitter']   = get_the_author_meta( 'twitter_url', $author_id ) ?: '';
		$sns_list['instagram'] = get_the_author_meta( 'instagram_url', $author_id ) ?: '';
		$sns_list['tiktok']    = get_the_author_meta( 'tiktok_url', $author_id ) ?: '';
		$sns_list['room']      = get_the_author_meta( 'room_url', $author_id ) ?: '';
		$sns_list['pinterest'] = get_the_author_meta( 'pinterest_url', $author_id ) ?: '';
		$sns_list['github']    = get_the_author_meta( 'github_url', $author_id ) ?: '';
		$sns_list['youtube']   = get_the_author_meta( 'youtube_url', $author_id ) ?: '';
		$sns_list['amazon']    = get_the_author_meta( 'amazon_url', $author_id ) ?: '';

		// 空の要素を排除
		$return_data['sns_list'] = array_filter( $sns_list );

		return $return_data;
	}


	/**
	 * カスタマイザーのSNS設定情報を取得
	 *
	 * @return $key => $url の配列データ
	 */
	public static function get_sns_settings() {
		$sns_settings = [
			'facebook',
			'twitter',
			'instagram',
			'tiktok',
			'room',
			'line',
			'pinterest',
			'github',
			'youtube',
			'amazon',
			'feedly',
			'rss',
			'contact',
		];

		$sns_data = [];
		foreach ( $sns_settings as $key ) {
			$url = self::get_setting( $key . '_url' );
			if ( $url ) {
				$sns_data[ $key ] = $url;
			}
		}
		return $sns_data;
	}


	/**
	 * ブログパーツのコンテンツを取得
	 */
	public static function get_blog_parts_content( $args ) {
		$q_args = [
			'post_type'              => 'blog_parts',
			'no_found_rows'          => true,
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false,
			'posts_per_page'         => 1,
			// 'post_status'            => 'publish',
		];

		$parts_id    = isset( $args['id'] ) ? (int) $args['id'] : 0;
		$parts_title = isset( $args['title'] ) ? $args['title'] : '';

		if ( $parts_id ) {
			$q_args['p'] = $parts_id;
		} elseif ( $parts_title ) {
			$q_args['title'] = $parts_title;
		} else {
			return '';
		}

		$the_query  = new \WP_Query( $q_args );
		$parts_data = $the_query->posts;
		wp_reset_postdata();

		if ( empty( $parts_data ) ) {
			return '';
		}

		$parts_data = $parts_data[0]; // 一つしかないはず
		$parts_id   = $parts_data->ID;
		$content    = $parts_data->post_content;
		$status     = get_post_status( $parts_id );
		if ( 'publish' !== $status && is_user_logged_in() ) {
			return __( '公開状態ではないブログパーツが呼び出されています。', 'swell' );
		};

		// 無限ループ回避
		if ( false !== strpos( $content, 'blog_parts id="' . $parts_id ) || false !== strpos( $content, '"partsID":"' . $parts_id ) ) {
			return __( 'ブログパーツ内で自身を呼び出すことはできません。', 'swell' );
		}

		return $content;
	}


	/**
	 * 投稿のタームデータから必要なものを取得
	 */
	public static function get_the_terms_data( $post_id, $tax ) {

		$cache_key = "the_terms_data_{$post_id}_{$tax}";

		// キャッシュ取得
		$cache_data = wp_cache_get( $cache_key, 'swell' );
		if ( $cache_data ) return $cache_data;

		$return_data = [];
		$terms       = get_the_terms( $post_id, $tax ) ?: [];

		if ( ! $terms ) return null;

		// 階層を保つ場合は親から順に並べる
		if ( is_taxonomy_hierarchical( $tax ) ) {
			$term_tree = [];
			foreach ( $terms as $term ) {
				$self_id   = $term->term_id;
				$parent_id = $term->parent;

				$term_data = [
					'id'   => $term->term_id,
					'slug' => $term->slug,
					'name' => $term->name,
					'url'  => get_term_link( $term ),
				];

				$acts_ct    = 0;
				$top_act_id = $self_id;
				if ( $parent_id ) {
					// 先祖リストを取得
					$ancestors  = array_reverse( get_ancestors( $term->term_id, 'category' ) );
					$acts_ct    = count( $ancestors );
					$top_act_id = $ancestors[0];
				}

				// 必要な配列を用意
				if ( ! isset( $term_tree[ $top_act_id ] ) ) {
					$term_tree[ $top_act_id ] = [];
				}
				if ( ! isset( $term_tree[ $top_act_id ] ) ) {
					$term_tree[ $top_act_id ][ $acts_ct ] = [];
				}

				// treeに格納
				$term_tree[ $top_act_id ][ $acts_ct ][] = $term_data;
			}

			if ( ! empty( $term_tree ) ) {
				foreach ( $term_tree as $tree ) {
					ksort( $tree );
					foreach ( $tree as $terms_data ) {
						$return_data = array_merge( $return_data, $terms_data );
					}
				}
			}
		} elseif ( ! empty( $terms ) ) {
			// 階層のないタグなどのタクソノミー
			foreach ( $terms as $term ) {
				$return_data[] = [
					'id'   => $term->term_id,
					'slug' => $term->slug,
					'name' => $term->name,
					'url'  => get_term_link( $term ),
				];
			}
		}

		$return_data = apply_filters( 'swell_get_the_terms_data', $return_data );
		wp_cache_set( $cache_key, $return_data, 'swell' );
		return $return_data;
	}



	/**
	 * メインビジュアルのスタイルを生成する
	 */
	public static function get_mv_text_style( $text_color, $shadow_color ) {
		$return = 'color:' . $text_color . ';';
		if ( '' !== $shadow_color ) {
			$return .= 'text-shadow:1px 1px 0px ' . self::get_rgba( $shadow_color, .2 );
		}
		return $return;
	}


	/**
	 * リンク先URLからtarget属性を判定する
	 */
	public static function get_link_target( $url ) {
		// スムースリンクさせたいリンクは _blank にしない
		if ( strpos( $url, '#' ) !== 0 && strpos( $url, home_url( '/' ) ) === false ) {
			return ' rel="noopener" target="_blank"';
		}
		return '';
	}


	/**
	 * ファイルURLからサイズを取得
	 */
	public static function get_file_size( $file_url ) {

		// ファイル名にサイズがあればそれを返す
		preg_match( '/-([0-9]*)x([0-9]*)\./', $file_url, $matches );
		if ( ! empty( $matches ) ) {
			return [
				'width'  => $matches[1],
				'height' => $matches[2],
			];
		}

		return false;

		// memo: attachment_url_to_postidは処理が重いので停止

		// $file_id   = attachment_url_to_postid( $file_url );
		// $file_data = wp_get_attachment_metadata( $file_id );
		// if ( ! empty( $file_data ) ) {
		// 	return [
		// 		'width'  => $file_data['width'],
		// 		'height' => $file_data['height'],
		// 	];
		// }

		// return false;
	}


	/**
	 * ピックアップバナーの画像sizesを取得
	 */
	public static function get_pickup_banner_sizes( $menu_count = 1 ) {

		// キャッシュ取得
		$cached_data = wp_cache_get( 'pickup_banner_sizes', 'swell' );
		if ( $cached_data ) return $cached_data;

		// レイアウトに合わせてsizes取得
		$layout_pc = self::get_setting( 'pickbnr_layout_pc' );
		$layout_sp = self::get_setting( 'pickbnr_layout_sp' );

		// pcサイズ
		$sizes_pc = '320px';
		if ( $layout_pc === 'fix_col3' || $layout_pc === 'flex' && $menu_count === 3 ) {
			$sizes_pc = '400px';
		} elseif ( $layout_pc === 'fix_col2' || $layout_pc === 'flex' && $menu_count === 2 ) {
			$sizes_pc = '600px';
		} elseif ( $layout_pc === 'flex' && $menu_count === 1 ) {
			$sizes_pc = '960px';
		}

		// spサイズ
		$sizes_sp = $layout_sp === 'fix_col2' ? '50vw' : '100vw';
		$sizes    = "(min-width: 960px) {$sizes_pc}, {$sizes_sp}";

		wp_cache_set( 'pickup_banner_sizes', $sizes, 'swell' );
		return $sizes;
	}


	/**
	 * wp_get_attachment_image から必要な部分だけ抜き取った関数
	 */
	public static function get_image( $img_id, $args = [] ) {

		$echo = $args['echo'] ?? false;
		$size = $args['size'] ?? 'full';

		$html     = '';
		$noscript = '';
		$image    = wp_get_attachment_image_src( $img_id, $size, false );

		if ( ! $image ) return '';

		list( $src, $width, $height ) = $image;
		$size_array                   = [ absint( $width ), absint( $height ) ];

		$width  = $args['width'] ?? $width;
		$height = $args['height'] ?? $height;

		// imgタグのattrs
		$attrs = [
			'src'         => $src,
			'alt'         => $args['alt'] ?? wp_strip_all_tags( get_post_meta( $img_id, '_wp_attachment_image_alt', true ) ),
			'class'       => $args['class'] ?? '',
			'srcset'      => $args['srcset'] ?? false,
			'sizes'       => $args['sizes'] ?? false,
			'style'       => $args['style'] ?? false,
			'decoding'    => $args['decoding'] ?? false,
			'aria-hidden' => $args['aria-hidden'] ?? false,
		];

		// 'srcset' と 'sizes' を生成
		if ( '' === $attrs['srcset'] ) {
			$attrs['srcset'] = false;
		} else {
			$image_meta = wp_get_attachment_metadata( $img_id );

			if ( is_array( $image_meta ) ) {
				// srcset の指定がなければ
				if ( ! $attrs['srcset'] ) {
					$attrs['srcset'] = wp_calculate_image_srcset( $size_array, $src, $image_meta, $img_id );
				}

				// sizes の指定がなければ (かつ、srcset があれば)
				if ( $attrs['srcset'] && ! $attrs['sizes'] ) {
					$attrs['sizes'] = wp_calculate_image_sizes( $size_array, $src, $image_meta, $img_id );
				}
			}
		}

		// lazyload
		$loading = $args['loading'] ?? \SWELL_Theme::$lazy_type;
		if ( 'lazy' === $loading || 'eager' === $loading ) {
			$attrs['loading'] = $loading;

		} elseif ( self::is_rest() || self::is_iframe() ) {
			$attrs['loading'] = 'lazy';

		} elseif ( 'lazysizes' === $loading || 'swiper' === $loading ) {
			$attrs['data-src'] = $attrs['src'];
			$attrs['src']      = $args['placeholder'] ?? self::$placeholder;
			if ( isset( $attrs['srcset'] ) ) {
				$attrs['data-srcset'] = $attrs['srcset'];
				unset( $attrs['srcset'] );
			}

			if ( 'lazysizes' === $loading ) {
				// noscript画像
				$noscript = '<noscript><img src="' . esc_attr( $src ) . '" class="' . esc_attr( $attrs['class'] ) . '" alt=""></noscript>';

				// lazyloadクラス追加はnoscript画像生成後に。
				$attrs['class'] .= ' lazyload';
				if ( $width && $height ) {
					$attrs['data-aspectratio'] = $width . '/' . $height;
				}
			} elseif ( 'swiper' === $loading ) {
				$attrs['class'] .= ' swiper-lazy';
			}
		}

		$img_props = image_hwstring( $width, $height );

		foreach ( $attrs as $name => $val ) {
			if ( false === $val ) continue;
			$img_props .= ' ' . $name . '="' . esc_attr( $val ) . '"';
		}

		$img = "<img $img_props >" . $noscript;

		if ( $echo ) {
			echo $img; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
		return $img;
	}


	/**
	 * 画像IDからsourceタグを生成
	 */
	public static function get_img_source( $img_id, $args = [] ) {
		$size = $args['size'] ?? 'full';

		$img_data = wp_get_attachment_image_src( $img_id, $size );
		if ( ! $img_data) return '';

		$src    = $img_data[0];
		$width  = $img_data[1];
		$height = $img_data[2];
		$srcset = wp_get_attachment_image_srcset( $img_id, $size );

		$attrs = [
			'media' => $args['media'] ?? '(max-width: 959px)',
		];
		if ( $srcset ) {
			$attrs['sizes'] = $args['sizes'] ?? '100vw';
		}

		$loading = $args['loading'] ?? 'none';
		if ( 'lazysizes' === $loading || 'swiper' === $loading ) {
			$attrs['srcset']      = $args['placeholder'] ?? self::$placeholder;
			$attrs['data-srcset'] = $srcset ?: $src;
			if ( 'swiper' === $loading ) {
				$attrs['class'] = 'swiper-lazy';
			}
		} else {
			$attrs['srcset'] = $srcset ?: $src;

			if ( 'lazy' === $loading ) {
				$attrs['loading'] = 'lazy';
			}
		}

		$source_props = image_hwstring( $width, $height );
		foreach ( $attrs as $name => $val ) {
			if ( false === $val ) continue;
			$source_props .= ' ' . $name . '="' . esc_attr( $val ) . '"';
		}
		return "<source $source_props >";
	}


	/**
	 * メインビジュアルのスライダー画像データ
	 */
	public static function get_mv_slide_imgs() {

		$cached_data = wp_cache_get( 'mv_slide_imgs', 'swell' );
		if ( $cached_data ) return $cached_data;

		$data = [];
		for ( $i = 1; $i < 6; $i++ ) {
			$imgid  = self::get_setting( "slider{$i}_imgid" );
			$imgurl = self::get_setting( "slider{$i}_img" ); // 古いデータ
			if ( 1 === $i && ! $imgid && ! $imgurl ) {
				$imgurl = 'https://picsum.photos/1600/1200';
			}
			if ( $imgid || $imgurl ) {
				$data[ $i ] = [
					'id'     => $imgid,
					'url'    => $imgurl,
					'id_sp'  => self::get_setting( "slider{$i}_imgid_sp" ),
					'url_sp' => self::get_setting( "slider{$i}_img_sp" ), // 古いデータ
				];
			}
		}

		wp_cache_set( 'mv_slide_imgs', $data, 'swell' );
		return $data;
	}


	/**
	 * メインビジュアルのスライダー画像
	 */
	public static function get_mv_slide_img( $i, $lazy_type = 'none' ) {
		$slide_imgs = self::get_mv_slide_imgs();
		$img_data   = $slide_imgs[ $i ] ?? [];

		// PC画像
		$picture_img = '';
		$pc_imgid    = $img_data['id'] ?? self::get_setting( "slider{$i}_imgid" );
		$pc_imgurl   = $img_data['url'] ?? self::get_setting( "slider{$i}_img" );
		$sp_imgid    = $img_data['id_sp'] ?? self::get_setting( "slider{$i}_imgid_sp" );
		$sp_imgurl   = $img_data['url_sp'] ?? self::get_setting( "slider{$i}_img_sp" );
		$img_alt     = self::get_setting( "slider{$i}_alt" );
		$img_class   = 'img' === self::get_setting( 'mv_slide_size' ) ? 'p-mainVisual__img' : 'p-mainVisual__img u-obf-cover';

		if ( 1 !== $i ) {
			// $lazy_type = 'swiper';
			$lazy_type = self::$lazy_type;
		}

		if ( $pc_imgid ) {
			$picture_img = self::get_image( $pc_imgid, [
				'class'    => $img_class,
				'alt'      => $img_alt,
				'loading'  => $lazy_type,
				'decoding' => 'async',
			] );
		} elseif ( $pc_imgurl ) {
			$picture_img = '<img src="' . esc_url( $pc_imgurl ) . '" alt="" class="' . $img_class . '" decoding="async">';
		}

		// idあるけどimg生成できなかった時 (データインポート時を考慮)
		if ( $pc_imgid && ! $picture_img ) $picture_img = '<img src="https://picsum.photos/1600/1200?i=' . $i . '" alt="" class="' . $img_class . '" decoding="async">';

		// SP用画像
		$picture_source = '';
		if ( $sp_imgid ) {
			$picture_source = self::get_img_source( $sp_imgid, [
				'loading' => $lazy_type,
			] );
		} elseif ( $sp_imgurl ) {
			$picture_source = '<source media="(max-width: 959px)" data-srcset="' . esc_url( $sp_imgurl ) . '" class="swiper-lazy">';
		}

		return $picture_source . $picture_img;
	}


	/**
	 * 投稿の背景画像IDを取得
	 * rerurn: idあれば intで返す　URLあれば文字列で返す
	 */
	public static function get_post_ttlbg_id( $post_id ) {
		$meta = get_post_meta( $post_id, 'swell_meta_ttlbg', true );
		if ( false !== strpos( $meta, 'http' ) ) {
			// まだ画像のとき
			$id = attachment_url_to_postid( $meta );

			// idに変換できなければURLのまま返す
			if ( ! $id ) return $meta;

			// IDで再保存
			$updated = update_post_meta( $post_id, 'swell_meta_ttlbg', (string) $id );
			if ( ! $updated ) return $meta;

		} else {
			$id = $meta;
		}

		if ($id ) return absint( $id );

		// デフォルト画像
		$id = self::get_setting( 'ttlbg_dflt_imgid' );
		if ($id ) return absint( $id );

		// デフォルト画像 URLでのデータだけ残ってしまっている場合
		$url = self::get_setting( 'ttlbg_default_img' );
		if ( $url ) return $url;

		// アイキャッチ
		$id = get_post_thumbnail_id( $post_id );
		if ($id ) return absint( $id );

		// NOIMAGE
		return self::get_noimg( 'id' ) ?: self::get_noimg( 'url' );
	}


	/**
	 * タームの背景画像IDを取得
	 */
	public static function get_term_ttlbg_id( $term_id ) {
		$meta = get_term_meta( $term_id, 'swell_term_meta_ttlbg', 1 );

		if ( false !== strpos( $meta, 'http' ) ) {
			$id = attachment_url_to_postid( $meta );
			// idに変換できなければURLのまま返す
			if ( ! $id ) return $meta;

			$updated = update_term_meta( $term_id, 'swell_term_meta_image', (string) $id );
			if ( ! $updated ) return $meta;
		} else {
			$id = $meta;
		}

		if ($id ) return absint( $id );

		// デフォルト画像
		$id = self::get_setting( 'ttlbg_dflt_imgid' );
		if ($id ) return absint( $id );

		// デフォルト画像 URLでのデータだけ残ってしまっている場合
		$url = self::get_setting( 'ttlbg_default_img' );
		if ( $url ) return $url;

		// アイキャッチ
		$id = self::get_term_thumb_id( $term_id );
		if ($id ) return absint( $id );

		// NOIMAGE
		return self::get_noimg( 'id' ) ?: self::get_noimg( 'url' );
	}


	/**
	 * タームのアイキャッチ画像IDを取得
	 */
	public static function get_term_thumb_id( $term_id ) {
		$meta = get_term_meta( $term_id, 'swell_term_meta_image', 1 );

		if ( false !== strpos( $meta, 'http' ) ) {
			$id = attachment_url_to_postid( $meta );
			// idに変換できなければURLのまま返す
			if ( ! $id ) return $meta;

			$updated = update_term_meta( $term_id, 'swell_term_meta_image', (string) $id );
			if ( ! $updated ) return $meta;

		}
		return absint( $meta );
	}


	/**
	 * SNS CTAのデータ
	 */
	public static function get_sns_cta_data() {
		$cached_data = wp_cache_get( 'sns_cta_data', 'swell' );
		if ( $cached_data ) return $cached_data;

		$data = apply_filters( 'swell_get_sns_cta_data', [
			'tw_id'    => self::get_setting( 'show_tw_follow_btn' ) ? self::get_setting( 'tw_follow_id' ) : '',
			'fb_url'   => self::get_setting( 'show_fb_like_box' ) ? self::get_setting( 'fb_like_url' ) : '',
			'insta_id' => self::get_setting( 'show_insta_follow_btn' ) ? self::get_setting( 'insta_follow_id' ) : '',
		] );

		wp_cache_set( 'sns_cta_data', $data, 'swell' );
		return $data;
	}


	/**
	 * ページ種別スラッグ（キャッシュ用）
	 */
	public static function get_page_type_slug() {
		if ( self::is_top() && ! is_paged() ) {
			return 'top';
		} elseif ( is_single() ) {
			return 'single';
		} elseif ( is_page() ) {
			return 'page';
		} elseif ( is_archive() || is_home() ) {
			return 'archive';
		} else {
			return 'other';
		}
	}


	/**
	 * Google font
	 */
	public static function get_google_font() {
		$google_font = '';
		$body_font   = self::get_setting( 'body_font_family' );

		if ( ! self::is_android() && 'notosans' === $body_font ) {
			$google_font = 'https://fonts.googleapis.com/css?family=Noto+Sans+JP:400,700&display=swap';
		} elseif ( 'serif' === $body_font ) {
			$google_font = 'https://fonts.googleapis.com/css?family=Noto+Serif+JP:400,700&display=swap';
		}

		return $google_font;
	}


	/**
	 * SWELL最新版のバージョンを取得
	 */
	public static function get_swl_latest_version() {
		$latest_version = get_transient( 'swl_latest_version' );
		if ( false === $latest_version ) {
			$latest_version = \SWELL_Theme::remote_get( 'https://loos-cdn.com/swell-theme/api/?action=get_latest_version', [], true );
			set_transient( 'swl_latest_version', $latest_version, DAY_IN_SECONDS * 7 );
		}

		if ( ! is_array( $latest_version ) ) {
			return '';
		}

		return $latest_version['ver'] ?? '';
	}


	/**
	 * 利用規約の最終変更日を取得
	 */
	public static function get_term_changed_date() {

		// キャッシュ確認
		$term_changed_date = get_transient( 'swl_term_changed_date' );
		if ( false === $term_changed_date ) {
			$term_changed_date = \SWELL_Theme::remote_get( 'https://loos-cdn.com/swell-theme/api/?action=get_term_changed', [], true );
			set_transient( 'swl_term_changed_date', $term_changed_date, DAY_IN_SECONDS * 7 );
		}

		if ( ! is_array( $term_changed_date ) ) {
			return '';
		}

		return end( $term_changed_date );
	}


	/**
	 * SWELL JSON ディレクトリ取得
	 */
	public static function get_swl_json_dir() {
		$json_dir = get_transient( 'swl_json_dir_ver' );
		if ( false === $json_dir ) {
			$json_dir = \SWELL_Theme::remote_get( 'https://loos-cdn.com/swell-theme/api/?action=get_json_dir', [] );
			set_transient( 'swl_json_dir_ver', $json_dir, DAY_IN_SECONDS * 5 );
		}

		if ( ! $json_dir ) {
			return '';
		}

		return $json_dir;
	}


	/**
	 * 検索結果ページのタイトル
	 */
	public static function get_search_title() {
		// 検索されたテキスト
		$s_query = get_search_query();
		$s_title = $s_query ? sprintf( __( '「%s」の検索結果', 'swell' ), $s_query ) : __( '検索結果', 'swell' );

		return apply_filters( 'swell_get_search_title', $s_title );
	}


	/**
	 * カスタム投稿タイプに紐付いたタクソノミーを一つだけ取得する
	 */
	public static function get_tax_of_post_type( $the_post_type = '' ) {
		$the_post_type = $the_post_type ?: get_post_type();
		$the_tax       = 'category';

		// カスタム投稿タイプの場合
		if ( 'post' !== $the_post_type ) {

			// キャッシュ取得
			$cache_key = 'tax_of_' . $the_post_type;
			$the_tax   = wp_cache_get( $cache_key, 'swell' ) ?: '';

			if ( ! $the_tax ) {
				// 投稿タイプに紐づいたタクソノミーを取得
				$tax_array = get_object_taxonomies( $the_post_type, 'names' );
				$core_tax  = [ 'category', 'post_tag', 'post_format' ];
				foreach ( $tax_array as $tax_name ) {
					// コアの標準タクソノミーを除いて1つ目を取得
					if ( ! in_array( $tax_name, $core_tax, true ) ) {
						$the_tax = $tax_name;
						break;
					}
				}
				wp_cache_set( $cache_key, $the_tax, 'swell' );
			}
		}

		return apply_filters( 'swell_get_tax_of_post_type', $the_tax, $the_post_type );
	}


	/**
	 * PR表記
	 */
	public static function get_pr_notation_size( $the_id = '', $setting_key = 'show_pr_notation' ) {
		$show_pr_notation = SWELL::get_setting( $setting_key ) ?? 'off';
		$pr_notation_type = SWELL::get_setting( 'pr_notation_type' ) ?? 's';
		$meta_show_pr     = get_post_meta( $the_id, 'swell_meta_show_pr_notation', true ) ?: '';

		// 投稿ごとの上書き指定
		if ( 'hide' === $meta_show_pr ) {
			return false;
		}
		if ( 'show' === $meta_show_pr ) {
			return $pr_notation_type;
		}

		// ベース設定
		if ( 'off' === $show_pr_notation ) {
			return false;
		}

		if ( 'off' !== $show_pr_notation ) {
			return $pr_notation_type;
		}
	}


	/**
	 * 検索の絞り込み状況を取得
	 * ... 製作途中 ...
	 * see: https://github.com/loos/SWELL/issues/128
	 */

	/*
	public static function get_searched_status() {

		$s_status = [];

		// カテゴリー指定があれば
		if ( isset( $_GET['cat'] ) ) {
			$catid    = get_query_var( 'cat', 0 );
			$cat_data = get_term_by( 'id', $catid, 'category' );
			if ( ! $cat_data ) {
				$s_status['category'] = sprintf( __( '不明なカテゴリーID: %s', 'swell' ), $catid );
			} else {
				$s_status['category'] = $cat_data->name ?? '';
			}
		} elseif ( isset( $_GET['category_name'] ) ) {
			$cat_slug = get_query_var( 'category_name', '' );
			$cat_data = get_term_by( 'slug', $cat_slug, 'category' );
			if ( ! $cat_data ) {
				$s_status['category'] = sprintf( __( '不明なカテゴリー: %s', 'swell' ), $cat_slug );
			} else {
				$s_status['category'] = $cat_data->name ?? '';
			}
		}

		// タグの指定があれば
		if ( isset( $_GET['tag'] ) ) {
			$tag_slug = get_query_var( 'tag', '' );
			$tag_data = get_term_by( 'slug', $tag_slug, 'post_tag' );
			if ( ! $tag_data ) {
				$s_status['post_tag'] = sprintf( __( '不明なカテゴリー: %s', 'swell' ), $tag_slug );
			} else {
				$s_status['post_tag'] = $tag_data->name ?? '';
			}
		}

		$return_text = '';
		foreach ( $s_status as $key => $value ) {
			$tax = get_taxonomy( $key );
			if ( ! $tax ) continue;

			$return_text .= '<div>' . $tax->label . ' : ' . $value . '</div>';
		}

		// 検索結果タイトル
		return apply_filters( 'swell_get_search_terms_status', $return_text );
	}
	*/
}
