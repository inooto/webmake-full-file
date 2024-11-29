<?php
if ( ! defined( 'ABSPATH' ) ) exit;

use \SWELL_Theme as SWELL;

/**
 * $categories = get_the_category()のデータ
 */
if ( ! function_exists( 'swl_get__a_catgory' ) ) :
	function swl_get__a_catgory( $categories ) {
		if ( empty( $categories ) ) {
			return null;
		}

		// １つしかなければそれを返す
		if ( 1 === count( $categories ) ) {
			return $categories[0];
		}

		// 現在のページがカテゴリーアーカイブの時にそのカテゴリー名で表示するかどうか。
		if ( is_category() ) {
			$pickup_self = SWELL::get_setting( 'pl_cat_on_cat_page' );
			// 強制的に表示名を現在のアーカイブに合わせる時
			if ( 'forced' === $pickup_self ) {
				return get_queried_object();
			}

			// 表示カテゴリーと一致するものがあればそれを優先的に返す
			if ( 'if_have' === $pickup_self ) {
				$now_id = get_queried_object_id();
				foreach ( $categories as $the_cat ) {
					if ( $now_id === $the_cat->term_id ) {
						return $the_cat;
					}
				}
			}
		}

		// 一番親を返すか、子を返すか
		$p_or_c = SWELL::get_setting( 'pl_cat_target' );
		if ( 'parent' === $p_or_c ) {
			$_cat     = null;
			$_acts_ct = 0;
			foreach ( $categories as $the_cat ) {
				// 一番親のカテゴリーであればすぐにそれを返す
				if ( 0 === $the_cat->parent ) {
					return $the_cat;
				}

				$ancestors = get_ancestors( $the_cat->term_id, 'category' );

				// 親カテゴリー自身と紐付いてなくても親のカテゴリー名で表示する
				// if ( 1 ) {
				// 	return get_category( $ancestors[ count( $ancestors ) - 1 ] );
				// }

				// まだ1度もセットされていない時はまず記憶させる
				if ( 0 === $_acts_ct ) {
					$_cat     = $the_cat;
					$_acts_ct = count( $ancestors );
					continue;
				}

				// 親の数がより少なければ上書き
				if ( $_acts_ct > count( $ancestors ) ) {
					$_cat = $the_cat;
				}
			}
			return $_cat;

		} elseif ( 'child' === $p_or_c ) {
			$_cat     = null;
			$_acts_ct = 0;
			foreach ( $categories as $the_cat ) {
				$ancestors = get_ancestors( $the_cat->term_id, 'category' );

				// まだ1度もセットされていない時はまず記憶させる
				if ( 0 === $_acts_ct ) {
					$_cat     = $the_cat;
					$_acts_ct = count( $ancestors );
					continue;
				}

				// 親の数がより「多ければ」上書き
				if ( $_acts_ct < count( $ancestors ) ) {
					$_cat = $the_cat;
				}
			}
			return $_cat;
		}

		// 特に条件のヒットがなければ最初のカテゴリーを返す
		return $categories[0];

	}
endif;
