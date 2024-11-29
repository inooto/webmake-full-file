<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * タームアーカイブのheadコンテンツ
 */
$term_id     = $variable['term_id'] ?? 0;
$description = $variable['description'] ?? '';


// タームメタ
$is_show_thumb = get_term_meta( $term_id, 'swell_term_meta_show_thumb', 1 );
$is_show_desc  = get_term_meta( $term_id, 'swell_term_meta_show_desc', 1 );
$is_show_thumb = ( '1' === $is_show_thumb );  // 標準：オフ
$is_show_desc  = ( '0' !== $is_show_desc );   // 標準：オン

$term_thumb_id  = $is_show_thumb ? \SWELL_Theme::get_term_thumb_id( $term_id ) : 0;
$term_thumb_url = '';
if ( is_string( $term_thumb_id ) ) {
	$term_thumb_url = $term_thumb_id; // 昔はURLデータを保存してた
}
$description = $is_show_desc ? $description : '';

if ( ! $term_thumb_id && ! $description ) return '';
$lazy_type = apply_filters( 'swell_mv_single_lazy_off', true ) ? 'none' : SWELL_Theme::$lazy_type;
?>
<div class="p-termHead">
	<?php if ( $term_thumb_url || $term_thumb_id ) : ?>
		<figure class="p-termHead__thumbWrap">
			<?php
				if ( $term_thumb_url ) :
					echo '<img src="' . esc_attr( $term_thumb_url ) . '" class="p-termHead__thumbImg u-obf-cover">';
				elseif ( $term_thumb_id ) :
					\SWELL_Theme::get_image( $term_thumb_id, [
						'class'   => 'p-termHead__thumbImg u-obf-cover', // obfはdescription長い時用
						'alt'     => '',
						'loading' => apply_filters( 'swell_term_thumbnail_lazy_off', true ) ? 'none' : SWELL_Theme::$lazy_type,
						'echo'    => true,
					]);
				endif;
			?>
		</figure>
	<?php endif; ?>
	<?php if ( $description ) : ?>
		<p class="p-termHead__desc">
			<?=wp_kses( do_shortcode( nl2br( $description ) ), SWELL_Theme::$allowed_text_html )?>
		</p>
	<?php endif; ?>
</div>
