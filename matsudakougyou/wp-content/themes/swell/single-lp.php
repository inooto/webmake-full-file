<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * LP用のファイルがあればそれを表示する。
 */
$lp_slug = get_queried_object()->post_name;

// まず子テーマ側から探す
$include_path_php  = S_DIRE . '/lp/' . $lp_slug . '.php';
$include_path_html = S_DIRE . '/lp/' . $lp_slug . '.html';

if ( file_exists( $include_path_php ) ) {
	include $include_path_php;
	exit;
} elseif ( file_exists( $include_path_html ) ) {
	include $include_path_html;
	exit;
}

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php SWELL_Theme::root_attrs(); ?>>
<head>
<meta charset="utf-8">
<meta name="format-detection" content="telephone=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width">
<?php
	wp_head();
	$SETTING          = SWELL_Theme::get_setting();
	$the_id           = get_queried_object_id();
	$body_style       = get_post_meta( $the_id, 'lp_body_style', true );
	$thumb_pos        = get_post_meta( $the_id, 'lp_thumb_pos', true );
	$title_pos        = get_post_meta( $the_id, 'lp_title_pos', true );
	$use_swell_style  = get_post_meta( $the_id, 'lp_use_swell_style', true );
	$use_swell_header = get_post_meta( $the_id, 'lp_use_swell_header', true );
	$use_swell_footer = get_post_meta( $the_id, 'lp_use_swell_footer', true );
	$content_width    = get_post_meta( $the_id, 'lp_content_width', true ) ?: '900px';
?>
<style>:root{--swl-lp_content_width:<?=esc_attr( $content_width )?>}</style>
</head>
<body>
<?php if ( function_exists( 'wp_body_open' ) ) wp_body_open(); ?>
<div id="body_wrap" <?php body_class(); ?>>
<?php

// ヘッダー
if ( '1' === $use_swell_header ) {
	SWELL_Theme::get_parts( 'parts/header/sp_menu' );
	SWELL_Theme::get_parts( 'parts/header/header_contents' );
}

while ( have_posts() ) :
the_post();
	// 投稿データ取得
	$post_data = get_post();
?>
	<?php if ( 'top' === $thumb_pos ) : ?>
		<div class="lp-headContent">
			<figure class="lp-thumb">
				<?php
					SWELL_Theme::get_thumbnail( [
						'post_id'   => $the_id,
						'sizes'     => '100vw',
						'class'     => 'lp-thumb__img',
						'lazy_type' => 'none',
						'echo'      => true,
					] );
				?>
			</figure>
		</div>
	<?php endif; ?>

	<div id="lp-content" class="lp-content -style-<?=esc_attr( $body_style )?>" <?php SWELL_Theme::lp_content_attrs(); ?>>
		<main class="lp-content__inner">
			<?php if ( 'inner' === $thumb_pos ) : ?>
				<figure class="lp-thumb">
				<?php
					SWELL_Theme::get_thumbnail( [
						'post_id'   => $the_id,
						'class'     => 'lp-thumb__img',
						'lazy_type' => 'none',
						'echo'      => true,
					] );
				?>
				</figure>
			<?php endif; ?>

			<?php if ( 'inner' === $title_pos ) : ?>
				<h1 class="lp-content__title"><?php the_title(); ?></h1>
			<?php endif; ?>

			<div class="lp-content__postContent<?php echo 'off' !== $use_swell_style ? ' post_content' : ''; ?>">
				<?php the_content(); // 本文 ?>
			</div>

		</main>
	</div>

<?php endwhile; ?>

<?php if ( '1' === $use_swell_footer ) : ?>
	<footer id="footer" class="l-footer">
		<?php if ( ! SWELL_Theme::is_use( 'ajax_footer' ) ) SWELL_Theme::get_parts( 'parts/footer/footer_contents' ); ?>
	</footer>
	<?php
		// 固定フッターメニュー
		if ( has_nav_menu( 'fix_bottom_menu' ) ) :
		SWELL_Theme::get_parts( 'parts/footer/fix_menu' );
		endif;

		// 固定ボタン
		SWELL_Theme::get_parts( 'parts/footer/fix_btns' );

		// モーダル
		SWELL_Theme::get_parts( 'parts/footer/modals' );
	?>
<?php endif; ?>

</div><!--/ #all_wrapp-->
<?php
wp_footer();
echo $SETTING['foot_code']; // phpcs:ignore
?>
</body></html>
