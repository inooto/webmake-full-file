<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$SETTING = SWELL_Theme::get_setting();

// 動画
$pc_poster    = $SETTING['mv_video_poster'];
$pc_video_id  = $SETTING['mv_video'];
$pc_video_url = wp_get_attachment_url( $pc_video_id );

$sp_poster    = $SETTING['mv_video_poster_sp'] ?: $pc_poster;
$sp_video_id  = $SETTING['mv_video_sp'] ?: $SETTING['mv_video'];
$sp_video_url = wp_get_attachment_url( $sp_video_id );

// テキストやボタン
$slide_title = $SETTING['movie_title'];
$slide_text  = $SETTING['movie_text'];
$slide_url   = $SETTING['movie_url'];
$btn_text    = $SETTING['movie_btn_text'];
$txtpos      = $SETTING['movie_txtpos'];
$txtcol      = $SETTING['movie_txtcol'];
$text_style  = SWELL_Theme::get_mv_text_style( $txtcol, $SETTING['movie_shadowcol'] );

// パーツID
$parts_id = (int) $SETTING['movie_parts_id'];

$video_props = 'playsinline autoplay loop muted';
if ( $pc_poster ) {
	$video_props .= ' data-poster-pc="' . esc_url( $pc_poster ) . '"';
}
if ( $sp_poster ) {
	$video_props .= ' data-poster-sp="' . esc_url( $sp_poster ) . '"';
}

?>
<div class="p-mainVisual__inner c-filterLayer -<?=esc_attr( $SETTING['mv_img_filter'] )?>">
	<div class="p-mainVisual__imgLayer c-filterLayer__img">
		<video class="p-mainVisual__video" <?php echo $video_props; // phpcs:ignore?>>
			<source data-src-sp="<?=esc_url( $sp_video_url )?>" data-src-pc="<?=esc_url( $pc_video_url )?>">
		</video>
	</div>
	<div class="p-mainVisual__textLayer l-container l-parent u-ta-<?=esc_attr( $txtpos )?>" style="<?=esc_attr( $text_style )?>">
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
		if ( $parts_id ) {
			echo do_shortcode( '[blog_parts id="' . $parts_id . '"]' );
		}

		// ボタン
		if ( '' !== $slide_url && '' !== $btn_text ) :
			$btn_args = [
				'href'     => $slide_url,
				'text'     => $btn_text,
				'btn_type' => $SETTING['movie_btntype'],
				'btn_col'  => $SETTING['movie_btncol'],
			];
			\SWELL_Theme::pluggable_parts( 'mv_btn', $btn_args );
		endif;
	?>
	</div>
	<?php if ( $SETTING['mv_on_scroll'] ) \SWELL_Theme::pluggable_parts( 'scroll_arrow', [ 'color' => $txtcol ] ); ?>
</div>
