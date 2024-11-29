<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * メインビジュアル (画像１枚の時)
 */
$SETTING = SWELL_Theme::get_setting();

// altテキスト
$img_alt = $SETTING['slider1_alt'] ?: '';

// lazy_type
$lazy_type = apply_filters( 'swell_mv_single_lazy_off', true ) ? 'none' : SWELL_Theme::$lazy_type;
$slide_img = SWELL_Theme::get_mv_slide_img( 1, $lazy_type );

// テキストやボタン
$slide_title = $SETTING['slider1_title'];
$slide_text  = $SETTING['slider1_text'];
$btn_text    = $SETTING['slider1_btn_text'];
$slide_url   = $SETTING['slider1_url'];
$txtpos      = $SETTING['slider1_txtpos'];
$text_style  = SWELL_Theme::get_mv_text_style( $SETTING['slider1_txtcol'], $SETTING['slider1_shadowcol'] );

// パーツID
$parts_id = (int) $SETTING['slider1_parts_id'];

?>
<div class="p-mainVisual__inner">

	<div class="p-mainVisual__slide c-filterLayer -<?=esc_attr( $SETTING['mv_img_filter'] )?>">
		<picture class="p-mainVisual__imgLayer c-filterLayer__img">
			<?php echo $slide_img; //phpcs:ignore ?>
		</picture>
		<div class="p-mainVisual__textLayer l-parent l-container u-ta-<?=esc_attr( $txtpos )?>" style="<?=esc_attr( $text_style )?>">
		<?php
			// キャッチコピー
			if ( '' !== $slide_title ) {
				echo '<div class="p-mainVisual__slideTitle">' . wp_kses( $slide_title, SWELL_Theme::$allowed_text_html ) . '</div>';
			}

			// サブコピー
			if ( '' !== $slide_text ) {
				echo '<div class="p-mainVisual__slideText">' . wp_kses( nl2br( $slide_text ), SWELL_Theme::$allowed_text_html ) . '</div>';
			}

			// ブログパーツ
			if ( $parts_id ) echo do_shortcode( '[blog_parts id="' . $parts_id . '"]' );

			// ボタン or スライド全体をリンク
			if ( '' !== $slide_url && '' !== $btn_text ) :
			$btn_args = [
				'href'     => $slide_url,
				'text'     => $btn_text,
				'btn_type' => $SETTING['slider1_btntype'],
				'btn_col'  => $SETTING['slider1_btncol'],
			];
			\SWELL_Theme::pluggable_parts( 'mv_btn', $btn_args );

			elseif ( $slide_url ) :
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo '<a href="' . esc_url( $slide_url ) . '" class="p-mainVisual__slideLink"' . SWELL_Theme::get_link_target( $slide_url ) . '></a>';
			endif;
		?>
		</div>
	</div>
	<?php if ( $SETTING['mv_on_scroll'] ) \SWELL_Theme::pluggable_parts( 'scroll_arrow', ['color' => $SETTING['slider1_txtcol'] ] ); ?>
</div>
