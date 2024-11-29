<?php
namespace SWELL_Theme\Style;

use \SWELL_Theme as SWELL;
use SWELL_Theme\Style as Style;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * フロント・エディター共通で出力したいCSS
 */
class Post {

	/**
	 * ボタン
	 */
	public static function btn() {

		$btn_red    = SWELL::get_editor( 'color_btn_red' );
		$btn_red2   = SWELL::get_editor( 'color_btn_red2' );
		$btn_blue   = SWELL::get_editor( 'color_btn_blue' );
		$btn_blue2  = SWELL::get_editor( 'color_btn_blue2' );
		$btn_green  = SWELL::get_editor( 'color_btn_green' );
		$btn_green2 = SWELL::get_editor( 'color_btn_green2' );

		Style::add( '.red_', [
			'--the-btn-color:' . $btn_red,
			'--the-btn-color2:' . $btn_red2,
			'--the-solid-shadow: ' . SWELL::get_rgba( $btn_red, 1, -.25 ),
		] );
		Style::add( '.blue_', [
			'--the-btn-color:' . $btn_blue,
			'--the-btn-color2:' . $btn_blue2,
			'--the-solid-shadow: ' . SWELL::get_rgba( $btn_blue, 1, -.25 ),
		] );
		Style::add( '.green_', [
			'--the-btn-color:' . $btn_green,
			'--the-btn-color2:' . $btn_green2,
			'--the-solid-shadow: ' . SWELL::get_rgba( $btn_green, 1, -.25 ),
		] );

		// グラデーション設定
		if ( SWELL::get_editor( 'is_btn_gradation' ) ) {
			Style::add(
				['.is-style-btn_normal', '.is-style-btn_shiny' ],
				'--the-btn-bg: linear-gradient(100deg,var(--the-btn-color) 0%,var(--the-btn-color2) 100%)'
			);
		}

		// ボタンの丸み
		Style::add( '.is-style-btn_normal', '--the-btn-radius:' . SWELL::get_editor( 'btn_radius_normal' ) );
		Style::add( '.is-style-btn_solid', '--the-btn-radius:' . SWELL::get_editor( 'btn_radius_solid' ) );
		Style::add( '.is-style-btn_shiny', '--the-btn-radius:' . SWELL::get_editor( 'btn_radius_shiny' ) );
		Style::add( '.is-style-btn_line', '--the-btn-radius:' . SWELL::get_editor( 'btn_radius_line' ) );

		// ブロックエディターのカラーパレット用
		if ( is_admin() ) {
				Style::add_root( '--swl--btn-color--red', $btn_red );
				Style::add_root( '--swl--btn-color2--red', $btn_red2 );
				// Style::add_root( '--swl-solid-shadow', SWELL::get_rgba( $btn_red, 1, -.25 ) );

				Style::add_root( '--swl--btn-color--blue', $btn_blue );
				Style::add_root( '--swl--btn-color2--blue', $btn_blue2 );
				// Style::add_root( '--swl-solid-shadow', SWELL::get_rgba( $btn_blue, 1, -.25 ) );

				Style::add_root( '--swl--btn-color--green', $btn_green );
				Style::add_root( '--swl--btn-color2--green', $btn_green2 );
				// Style::add_root( '--swl-solid-shadow', SWELL::get_rgba( $btn_green, 1, -.25 ) );
		}

	}


	/**
	 * ふきだし
	 */
	public static function balloon() {

		$colors = [
			'gray' => [
				'bg'     => SWELL::get_editor( 'color_bln_gray_bg' ),
				'border' => SWELL::get_editor( 'color_bln_gray_border' ),
			],
			'green' => [
				'bg'     => SWELL::get_editor( 'color_bln_green_bg' ),
				'border' => SWELL::get_editor( 'color_bln_green_border' ),
			],
			'blue' => [
				'bg'     => SWELL::get_editor( 'color_bln_blue_bg' ),
				'border' => SWELL::get_editor( 'color_bln_blue_border' ),
			],
			'red' => [
				'bg'     => SWELL::get_editor( 'color_bln_red_bg' ),
				'border' => SWELL::get_editor( 'color_bln_red_border' ),
			],
			'yellow' => [
				'bg'     => SWELL::get_editor( 'color_bln_yellow_bg' ),
				'border' => SWELL::get_editor( 'color_bln_yellow_border' ),
			],
		];

		foreach ( $colors as $key => $color ) {
			Style::add(
				'[data-col="' . $key . '"] .c-balloon__text',
				[
					'background:' . $color['bg'],
					'border-color:' . $color['border'],
				]
			);
			Style::add(
				'[data-col="' . $key . '"] .c-balloon__before',
				'border-right-color:' . $color['bg']
			);

			// ブロックエディターのカラーパレット用
			if ( is_admin() ) {
				Style::add_root( '--color_bln_' . $key, $color['bg'] );
				Style::add_root( "--color_bln_{$key}_border", $color['border'] );
			}
		}
	}


	/**
	 * マーカー
	 */
	public static function marker( $marker_type, $body_font_family ) {

		$mark_blue   = [];
		$mark_green  = [];
		$mark_yellow = [];
		$mark_orange = [];

		switch ( $marker_type ) {
			case 'thin':
				$mark_blue[] = 'background:-webkit-linear-gradient(transparent 64%,var(--color_mark_blue) 0%)';
				$mark_blue[] = 'background:linear-gradient(transparent 64%,var(--color_mark_blue) 0%)';

				$mark_green[] = 'background:-webkit-linear-gradient(transparent 64%,var(--color_mark_green) 0%)';
				$mark_green[] = 'background:linear-gradient(transparent 64%,var(--color_mark_green) 0%)';

				$mark_yellow[] = 'background:-webkit-linear-gradient(transparent 64%,var(--color_mark_yellow) 0%)';
				$mark_yellow[] = 'background:linear-gradient(transparent 64%,var(--color_mark_yellow) 0%)';

				$mark_orange[] = 'background:-webkit-linear-gradient(transparent 64%,var(--color_mark_orange) 0%)';
				$mark_orange[] = 'background:linear-gradient(transparent 64%,var(--color_mark_orange) 0%)';
				break;
			case 'stripe':
				$mark_blue[] = 'background:repeating-linear-gradient(-45deg,var(--color_mark_blue),var(--color_mark_blue) 2px,transparent 2px,transparent 4px)';

				$mark_green[] = 'background:repeating-linear-gradient(-45deg,var(--color_mark_green),var(--color_mark_green) 2px,transparent 2px,transparent 4px)';

				$mark_yellow[] = 'background:repeating-linear-gradient(-45deg,var(--color_mark_yellow),var(--color_mark_yellow) 2px,transparent 2px,transparent 4px)';

				$mark_orange[] = 'background:repeating-linear-gradient(-45deg,var(--color_mark_orange),var(--color_mark_orange) 2px,transparent 2px,transparent 4px)';
				break;
			case 'thin-stripe':
				$mark_offsetY = ( $body_font_family === 'notosans' || $body_font_family === 'serif' ) ? '1em' : '.75em';

				$mark_blue[] = 'background:repeating-linear-gradient(-45deg,var(--color_mark_blue),var(--color_mark_blue) 2px,transparent 2px,transparent 4px) no-repeat 0 ' . $mark_offsetY;

				$mark_green[] = 'background:repeating-linear-gradient(-45deg,var(--color_mark_green),var(--color_mark_green) 2px,transparent 2px,transparent 4px) no-repeat 0 ' . $mark_offsetY;

				$mark_yellow[] = 'background:repeating-linear-gradient(-45deg,var(--color_mark_yellow),var(--color_mark_yellow) 2px,transparent 2px,transparent 4px) no-repeat 0 ' . $mark_offsetY;

				$mark_orange[] = 'background:repeating-linear-gradient(-45deg,var(--color_mark_orange),var(--color_mark_orange) 2px,transparent 2px,transparent 4px) no-repeat 0 ' . $mark_offsetY;
				break;
			default:
				// 'bold'
				$mark_blue[]   = 'background:var(--color_mark_blue)';
				$mark_green[]  = 'background:var(--color_mark_green)';
				$mark_yellow[] = 'background:var(--color_mark_yellow)';
				$mark_orange[] = 'background:var(--color_mark_orange)';
				break;
		}

		Style::add( '.mark_blue', $mark_blue );
		Style::add( '.mark_green', $mark_green );
		Style::add( '.mark_yellow', $mark_yellow );
		Style::add( '.mark_orange', $mark_orange );

	}

	/**
	 * アイコンボックス
	 */
	public static function iconbox( $icon_box_type, $icon_bigbox_type ) {

		// Normal
		$icon_box_css = [];
		switch ( $icon_box_type ) {
			case 'fill-flat':
				$icon_box_css[] = 'color:#333;border-width:0';
				break;
			case 'fill-solid':
				$icon_box_css[] = 'color:#333;border-width:0';
				$icon_box_css[] = 'box-shadow:0 2px 2px rgba(0, 0, 0, .05), 0 4px 4px -4px rgba(0, 0, 0, .1)';
				break;
			case 'border-flat':
				$icon_box_css[] = 'border-style:solid;border-width:1px;background:none';
				// Style::add( '[class*="is-style-icon_"]::after', '-webkit-transform:scaleX(.5);transform:scaleX(.5);border-right-width: 2px;border-right-style: dashed;' );
				break;
			default:
				break;
		}
		Style::add( '[class*="is-style-icon_"]', $icon_box_css );

		// Big
		$big_box_css = [];
		switch ( $icon_bigbox_type ) {
			case 'solid':
				$big_box_css[] = 'background:#fff;color:#333;border-top-width:2px;border-top-style:solid;box-shadow:0 2px 2px rgba(0, 0, 0, .05),0 4px 4px -4px rgba(0, 0, 0, .1)';
				Style::add( '[class*="is-style-big_icon_"]::after', 'border-color:#fff' );
				break;
			default:
				// flat
				$big_box_css[] = 'border-width:2px;border-style:solid';
				break;
		}
		Style::add( '[class*="is-style-big_icon_"]', $big_box_css );
	}

	/**
	 * 引用
	 */
	public static function blockquote( $blockquote_type ) {
		$blockquote         = [];
		$blockquote__ba     = [];
		$blockquote__before = [];
		$blockquote__after  = [];
		switch ( $blockquote_type ) {
			case 'quotation':
				$blockquote[]         = 'padding:1.5em 3em';
				$blockquote__ba[]     = 'content:"\00201c";display:inline-block;position:absolute;font-size:6em;color:rgba(200, 200, 200, .4)';
				$blockquote__before[] = 'font-family:Arial,Helvetica,sans-serif;top:4px;left:8px';
				$blockquote__after[]  = 'transform:rotate(180deg);font-family:Arial,Helvetica,sans-serif;bottom:4px;right:8px';
				break;
			default:
				// simple
				$border               = 'solid 1px rgba(180,180,180,.75)';
				$blockquote[]         = 'padding:1.5em 2em 1.5em 3em';
				$blockquote__before[] = 'content:"";display:block;width:5px;height:calc(100% - 3em);top:1.5em;left:1.5em;' .
					'border-left:' . $border . ';border-right:' . $border . ';';
				break;
		}
		Style::add_post_style( ['blockquote' ], $blockquote );
		Style::add_post_style( ['blockquote::before', 'blockquote::after' ], $blockquote__ba );
		Style::add_post_style( ['blockquote::before' ], $blockquote__before );
		Style::add_post_style( ['blockquote::after' ], $blockquote__after );
	}


	/**
	 * H2
	 */
	public static function h2( $h2_type, $color_htag ) {
		$h2         = [];
		$h2__before = ['position:absolute;display:block;pointer-events:none' ];
		// $h2__after  = [];
		$is_col_fff = false;

		$colH = 'var(--color_htag)';
		switch ( $h2_type ) {
			case 'b_left':
				$h2[] = 'border-left:solid 6px ' . $colH . ';padding:.5em 0 .5em 16px';
				break;
			case 'b_left2':
				$colH_thin    = SWELL::get_rgba( $color_htag, 0.15 );
				$h2[]         = 'padding:.5em 0px .5em 24px';
				$h2__before[] = 'content:"";left:0;top:0;width:8px;height:100%;' .
				"background: repeating-linear-gradient({$colH} 0%, {$colH} 50%, {$colH_thin} 50%, {$colH_thin} 100%);";
				break;
			case 'band':
				$h2[]         = 'background:' . $colH . ';padding:.75em 1em;color:#fff';
				$h2__before[] = 'content:"";top:-4px;left:0;width:100%;height:calc(100% + 4px);box-sizing:content-box;border-top:solid 2px ' . $colH . ';border-bottom:solid 2px ' . $colH;
				$is_col_fff   = true;
				break;
			case 'block':
				$h2[]       = 'background:' . $colH . ';padding:.75em 1em;color:#fff;border-radius:var(--swl-radius--2, 0px)';
				$is_col_fff = true;
				break;
			case 'tag_normal':
				$h2[] = 'border-left:solid 8px ' . $colH . ';padding:.75em 1em';
				$h2[] = 'background:' . SWELL::get_rgba( $color_htag, 0.03 );
				break;
			case 'tag':
				$col_thin = SWELL::get_rgba( $color_htag, 0.05, 0.25 );
				$bg       = 'linear-gradient(135deg, transparent 25%, ' . $col_thin . ' 25%, ' . $col_thin . ' 50%, transparent 50%, transparent 75%, ' . $col_thin . ' 75%, ' . $col_thin . ')';

				$h2[] = 'border-left:solid 8px ' . $colH . ';padding:.75em 1em';
				$h2[] = 'background:-webkit-' . $bg . ';background:' . $bg;
				$h2[] = 'background-size:4px 4px';
				// $branch_css['h2:before'] = "content:'';z-index:-1;top:0;left:0;width:100%;height:100%;opacity:0.1";
				break;
			case 'balloon':
				$h2[]         = 'color:#fff;padding:.75em 1em;border-radius:2px;background:' . $colH;
				$h2__before[] = 'content:"";bottom:calc(2px - 1.5em);left:1.5em;width:0;height:0;visibility:visible;border:.75em solid transparent;border-top-color:' . $colH;
				$is_col_fff   = true;
				break;
			case 'stitch_thin':
			case 'stitch':
				$h2[]         = 'padding:1em;border-radius:2px';
				$h2__before[] = 'content:"";width:calc(100% - 8px);height:calc(100% - 8px);top:4px;left:4px;right:auto;bottom:auto';

				if ( $h2_type === 'stitch' ) {
					$h2[]        .= 'color:#fff;background:' . $colH;
					$h2__before[] = 'border:dashed 1px #fff';
					$is_col_fff   = true;
				} else {
					$h2[]        .= 'background:' . SWELL::get_rgba( $color_htag, 0.05, 0.25 );
					$h2__before[] = 'border:dashed 1px ' . SWELL::get_rgba( $color_htag, 0.5 );
				}
				break;
			case 'letter':
				// Gutenbergで:first-letterあるとバグるのでフロントのみしっかり。
				Style::add(
					['.post_content > h2:not(.is-style-section_ttl):first-letter' ],
					'font-size:1.5em;padding:0 2px 4px 2px;border-bottom:solid 2px;color:' . $colH,
					'all',
					'front'
				);

				// エディター側はちょろっと変えるだけ
				if ( is_admin() ) {
					$h2[]         = 'padding:0 1em';
					$h2__before[] = 'content:"";width:1em;height:2px;left:1em;bottom:0;background-color:' . $colH;
				}
				break;
			case 'b_topbottom':
				$h2[] = 'border-top:solid 2px ' . $colH . ';border-bottom:solid 2px ' . $colH . ';padding:1em .75em';
				break;
			default:
				break;
		}

		Style::add_post_style( ['h2:where(:not([class^="swell-block-"]):not(.faq_q):not(.p-postList__title))' ], $h2 );
		Style::add_post_style( ['h2:where(:not([class^="swell-block-"]):not(.faq_q):not(.p-postList__title))::before' ], $h2__before );
		// Style::add_post_style( ['h2::after' ], $h2__after );

		// エディターにだけ追加したいスタイル
		if ( $is_col_fff ) {
			Style::add(
				[
					'.editor-styles-wrapper [data-type="core/heading"] h2', // ~ 5.4
					'.editor-styles-wrapper h2[data-type="core/heading"]', // 5.5 ~
					'.mce-content-body h2',
				],
				'color:#fff',
				'all',
				'editor'
			);
		}
	}

	/**
	 * H3
	 */
	public static function h3( $h3_type, $color_htag ) {
		$h3         = [];
		$h3__before = [];
		// $h3__after = [];

		$colH = 'var(--color_htag)';
		switch ( $h3_type ) {
			case 'main_line':
				$h3[]         = 'padding:0 .5em .5em';
				$h3__before[] = 'content:"";width:100%;height:2px;background-color:' . $colH . '';
				break;
			case 'main_gray':
			case 'main_thin':
				$col = ( $h3_type === 'main_gray' ) ? 'rgba(150,150,150,.2)' : SWELL::get_rgba( $color_htag, 0.2, 0.25 );

				$h3[]         = 'padding:0 .5em .5em';
				$h3__before[] = 'content:"";width:100%;height:2px';
				$h3__before[] = "background: repeating-linear-gradient(90deg, {$colH} 0%, {$colH} 29.3%, {$col} 29.3%, {$col} 100%)";
				break;
			case 'gradation':
				$col          = SWELL::get_rgba( $color_htag, 0.2, 0.5 );
				$h3[]         = 'padding:0 .5em .5em';
				$h3__before[] = 'content:"";width:100%;height:2px';
				$h3__before[] = "background: repeating-linear-gradient(90deg, {$colH} 0%, {$colH} 20%, {$col} 90%, {$col} 100%)";
				break;
			case 'stripe':
				$bg = 'linear-gradient(' .
					'135deg, transparent 25%,' .
					$colH . ' 25%,' .
					$colH . ' 50%,' .
					'transparent 50%,' .
					'transparent 75%,' .
					$colH . ' 75%,' .
					$colH .
				')';

				$h3[]         = 'padding:0 .5em .5em';
				$h3__before[] = 'content:"";width:100%;height:4px';
				$h3__before[] = 'background:-webkit-' . $bg;
				$h3__before[] = 'background:' . $bg;
				$h3__before[] = 'background-size:4px 4px;opacity:0.5';
				break;
			case 'l_border':
				$h3[] = 'border-left:solid 4px ' . $colH . ';padding:.25em 0 .25em 16px';
				break;
			case 'l_block':
				$colH_thin    = SWELL::get_rgba( $color_htag, 0.15 );
				$h3[]         = 'padding:.25em 1em';
				$h3__before[] = 'content:"";width:4px;height:100%;' .
				"background: repeating-linear-gradient({$colH} 0%, {$colH} 50%, {$colH_thin} 50%, {$colH_thin} 100%);";
				break;
			default:
				break;
		}
		Style::add_post_style( [ 'h3:where(:not([class^="swell-block-"]):not(.faq_q):not(.p-postList__title))' ], $h3 );
		Style::add_post_style( ['h3:where(:not([class^="swell-block-"]):not(.faq_q):not(.p-postList__title))::before' ], $h3__before );
		// Style::add_post_style( ['h3::after'], $h3__after );
	}


	/**
	 * H4
	 */
	public static function h4( $h4_type, $color_htag ) {
		$h4         = [];
		$h4__before = [];
		// $h4__after = [];

		$colH = 'var(--color_htag)';
		switch ( $h4_type ) {
			case 'left_line':
				$h4[] = 'padding:0 0 0 16px;border-left:solid 2px ' . $colH;
				break;
			case 'check':
				$h4__before[] = 'content:"\e923";display:inline-block;font-family:"icomoon";margin-right:.5em;color:' . $colH;
				break;
			default:
				break;
		}
		Style::add_post_style( ['h4:where(:not([class^="swell-block-"]):not(.faq_q):not(.p-postList__title))' ], $h4 );
		Style::add_post_style( ['h4:where(:not([class^="swell-block-"]):not(.faq_q):not(.p-postList__title))::before' ], $h4__before );
		// Style::add_post_style( ['h4::after'], $h4__after );
	}


	/**
	 * H2 セクション用
	 */
	public static function h2_section( $secH2_type, $color_sec_htag ) {
		$secH2    = 'h2.is-style-section_ttl';
		$secH2__b = 'h2.is-style-section_ttl::before';
		$secH2__a = 'h2.is-style-section_ttl::after';

		switch ( $secH2_type ) {
			case 'b_bottom':
				$a_styles = [
					'position:absolute',
					'top:auto',
					'bottom:0',
					'left:calc(50% - 1.25em)',
					'right:auto',
					'display:block',
					'width:2.5em',
					'height:1px',
					'border-radius:2px',
					'pointer-events:none',
					'background:currentColor',
					'content:""',
				];

				if ( $color_sec_htag ) {
					$a_styles[] = 'background:' . $color_sec_htag;
				} else {
					$ba_styles[] = 'background:currentColor';
				};

				Style::add_post_style( [ $secH2 ], 'padding-bottom:.75em' );
				Style::add_post_style( [ $secH2__a ], $a_styles );

				Style::add_post_style( [ $secH2 . '.has-text-align-left::after' ], 'left:0px;right:auto' );
				Style::add_post_style( [ $secH2 . '.has-text-align-right::after' ], 'left:auto;right:0' );
				// has-text-align-left
				break;
			case 'b_lr':
				$ba_styles = [
					'position:absolute',
					'top:50%',
					'bottom:auto',
					'display:block',
					'width:3em',
					'height:1px',
					'pointer-events:none',
					'content:""',
				];

				if ( $color_sec_htag ) {
					$ba_styles[] = 'background:' . $color_sec_htag;
				} else {
					$ba_styles[] = 'background:currentColor';
				}

				Style::add_post_style( [ $secH2 ], 'padding:0 5.5em' );
				Style::add_post_style( [ $secH2__b, $secH2__a ], $ba_styles );

				// 通常の h2 に対して leftがすでに当てられている可能性を考慮して auto つける
				Style::add_post_style( [ $secH2__b ], 'left:2em;right:auto' );
				Style::add_post_style( [ $secH2__a ], 'left:auto;right:2em' );

				// mobile
				Style::add_post_style( [ $secH2 ], 'padding:0 3.5em', 'mobile' );
				Style::add_post_style( [ $secH2__b ], 'width:2em;left:1em', 'mobile' );
				Style::add_post_style( [ $secH2__a ], 'width:2em;right:1em', 'mobile' );

				// 左寄せ
				Style::add_post_style( [ $secH2 . '.has-text-align-left' ], 'padding-left:1.75em;padding-right:0' );
				Style::add_post_style( [ $secH2 . '.has-text-align-left::before' ], 'width:1em; left:0' );
				Style::add_post_style( [ $secH2 . '.has-text-align-left::after' ], 'content:none' );

				// 右寄せ
				Style::add_post_style( [ $secH2 . '.has-text-align-right' ], 'padding-left:0;padding-right:1.75em' );
				Style::add_post_style( [ $secH2 . '.has-text-align-right::before' ], 'content:none' );
				Style::add_post_style( [ $secH2 . '.has-text-align-right::after' ], 'width:1em; right:0' );
				break;
			default:
				break;
		}
	}

}
