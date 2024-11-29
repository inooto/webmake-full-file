<?php
namespace SWELL_Theme\Gutenberg;

if ( ! defined( 'ABSPATH' ) ) exit;

function swl_get_text_color_var( $color ) {
	if ( $color === '#000' ) {
		$color = 'black';
	} elseif ( $color === '#fff' ) {
		$color = 'white';
	}
	return "var(--swl-text_color--{$color})";
};

/**
 * テーブルブロック
 */
add_filter( 'render_block_core/table', __NAMESPACE__ . '\render_table', 10, 2 );
function render_table( $block_content, $block ) {
	$attrs     = $block['attrs'] ?? [];
	$innerHTML = $block['innerHTML'] ?? '';
	$className = $attrs['className'] ?? '';

	$props       = '';
	$thead_props = '';
	$tbody_props = '';
	$table_style = '';

	// theadカラー
	if ( isset( $attrs['swlHeadColor'] ) ) {
		$swlHeadColor = array_merge([
			'bg'   => '',
			'text' => '',
			'slug' => '',
		], $attrs['swlHeadColor']);

		$thead_bg = '';
		if ( $swlHeadColor['slug'] ) {
			$thead_bg = \SWELL_Theme::get_palette_color( $swlHeadColor['slug'] );
		} elseif ( $swlHeadColor['bg'] ) {
			$thead_bg = $swlHeadColor['bg'];
		}
		if ( $thead_bg ) {
			$thead_style = '--thead-color--bg:' . $thead_bg . ';';
			if ( $swlHeadColor['text'] ) {
				$thead_style .= '--thead-color--txt:' . swl_get_text_color_var( $swlHeadColor['text'] );
			}
			$thead_props .= ' style="' . esc_attr( $thead_style ) . '"';
		}
	}

	// tbody th カラー
	if ( isset( $attrs['swlBodyThColor'] ) ) {
		$swlBodyThColor = array_merge([
			'bg'   => '',
			'text' => '',
			'slug' => '',
		], $attrs['swlBodyThColor']);

		$body_th_bg = '';
		if ( $swlBodyThColor['slug'] ) {
			$body_th_bg = \SWELL_Theme::get_palette_color( $swlBodyThColor['slug'] );
		} elseif ( $swlBodyThColor['bg'] ) {
			$body_th_bg = $swlBodyThColor['bg'];
		}

		if ( $body_th_bg ) {
			$tbody_style = '--tbody-th-color--bg:' . $body_th_bg . ';';
			if ( $swlBodyThColor['text'] ) {
				$tbody_style .= '--tbody-th-color--txt:' . swl_get_text_color_var( $swlBodyThColor['text'] );
			}
			$tbody_props .= ' style="' . esc_attr( $tbody_style ) . '"';
		}
	}

	// 横スクロール
	$scrollable = '';
	if ( isset( $attrs['swlScrollable'] ) ) {
		$scrollable = $attrs['swlScrollable'];
	} elseif ( false !== strpos( $className, 'sp_scroll_' ) ) {
		$scrollable = 'sp';
	}

	if ( $scrollable ) {
		$props .= ' data-table-scrollable="' . esc_attr( $scrollable ) . '"';

		// 一列目の固定表示
		$swlIsFixedLeft = $attrs['swlIsFixedLeft'] ?? false;
		if ( $swlIsFixedLeft ) {
			$props .= ' data-cell1-fixed="' . esc_attr( $scrollable ) . '"';
		}

		// スクロールヒント
		$hint_class = 'both' !== $scrollable ? " {$scrollable}_" : '';
		if ( str_contains( $className, 'sp_only' ) ) {
			$hint_class .= ' sp_only';
		} elseif ( str_contains( $className, 'pc_only' ) ) {
			$hint_class .= ' pc_only';
		}
		$hint_src      = '<div class="c-scrollHint' . esc_attr( $hint_class ) . '"><span>' . esc_html__( 'スクロールできます', 'swell' ) . ' <i class="icon-more_arrow"></i></span></div>';
		$block_content = apply_filters( 'swell_table_scroll_hint', $hint_src ) . $block_content;

		// tableの幅
		$max_width = '1200px';
		// 古いattrと新しいattrで処理分岐
		if ( isset( $attrs['swlTableWidth'] ) ) {
			$max_width = $attrs['swlTableWidth'];
		} elseif ( isset( $attrs['swlMaxWidth'] ) ) {
			$max_width = $attrs['swlMaxWidth'] . 'px';
		}
		$table_style .= "--table-width:{$max_width};";

	}

	if ( isset( $attrs['swlCell1Width'] ) ) {
		$table_style .= '--swl-cell1-width:' . $attrs['swlCell1Width'] . ';';
	}

	if ( isset( $attrs['swlFz'] ) ) {
		$table_style .= 'font-size:' . $attrs['swlFz'] . ';';
	}

	// <table> に style 属性を追加
	if ( $table_style ) {
		// 他にstyleを持つかどうかで処理分岐
		$table_has_style = preg_match( '/<table[^>]*style="([^"]*)"[^>]*>/', $innerHTML, $style_matches );
		if ( $table_has_style ) {
			$table_style = $table_style . ';' . $style_matches[1];
		}
		$block_content = str_replace( '<table', '<table style="' . esc_attr( $table_style ) . '"', $block_content );
	}

	// ヘッダー固定
	$theadfix = '';
	if ( isset( $attrs['swlFixedHead'] ) ) {
		$theadfix = $attrs['swlFixedHead'];
	} elseif ( false !== strpos( $className, 'sp_fix_thead_' ) ) {
		$theadfix = 'sp';
	}
	if ( $theadfix ) {
		$props .= ' data-theadfix="' . esc_attr( $theadfix ) . '"';
		\SWELL_Theme::set_use( 'fix_thead', true );
	}

	if ( $props ) {
		// ※ セル内自由になればpreg_replaceで回数指定が必要になるかも
		$block_content = str_replace( '<figure', '<figure' . $props, $block_content );
	}

	if ( $thead_props ) {
		$block_content = str_replace( '<thead', '<thead' . $thead_props, $block_content );
	}
	if ( $tbody_props ) {
		$block_content = str_replace( '<tbody', '<tbody' . $tbody_props, $block_content );
	}

	if ( false !== strpos( $block_content, 'class="swl-cell-bg' ) ) {
		$block_content = set_inlin_cell_bg( $block_content );
	}
	return $block_content;
}

function set_inlin_cell_bg( $content ) {
	// theeadも考慮して (\s[^>]+)? で属性部分をマッチ
	$content = preg_replace_callback( '/<(th|td)(\s[^>]+)?>(.*?)<\/(th|td)>/s', __NAMESPACE__ . '\set_inlin_cell_bg_cb', $content );
	return $content;
}

function set_inlin_cell_bg_cb( $matches ) {
	// echo '<pre style="margin-left: 100px;">';
	// var_dump( $matches );
	// echo '</pre>';
	// return $matches[0];

	$cell_content = $matches[3];
	if ( false === strpos( $cell_content, 'class="swl-cell-bg' ) ) {
		return $matches[0];
	}

	$tag         = $matches[1];
	$cell_props  = $matches[2];
	$cell_props .= ' data-has-cell-bg="1"';

	// span.swl-cell-bg が data-icon を持つか調べる
	if ( preg_match( '/<span[^>]*class="swl-cell-bg[^>]*>/', $cell_content, $matched ) ) {
		$cellbg_tag = $matched[0];
		if ( false !== strpos( $cellbg_tag, 'data-icon=' ) ) {

			// サイズの取得
			$icon_size = '';
			if ( preg_match( '/data-icon-size="([^"]*)"/', $cellbg_tag, $matched_size ) ) {
				$icon_size = $matched_size[1];
			};

			// タイプの取得
			$icon_type = '';
			if ( preg_match( '/data-icon-type="([^"]*)"/', $cellbg_tag, $matched_type ) ) {
				$icon_type = $matched_type[1];
			};

			$cell_props .= ' data-has-cell-icon="' . $icon_size . '-' . $icon_type . '"';
		}

		// 初期のコードを置換
		$cellbg_tag = str_replace( 'text-color="#000"', 'text-color="black"', $cellbg_tag );
		$cellbg_tag = str_replace( 'text-color="#fff"', 'text-color="white"', $cellbg_tag );

		// テキストカラーを親に伝える
		if ( false !== strpos( $cellbg_tag, 'data-text-color="black"' ) ) {
			$cell_props .= ' data-text-color="black"';
		} elseif ( false !== strpos( $cellbg_tag, 'data-text-color="white"' ) ) {
			$cell_props .= ' data-text-color="white"';
		}
	};

	return '<' . $tag . $cell_props . '>' . $cell_content . '</' . $tag . '>';
}
