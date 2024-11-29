<?php
if ( ! defined( 'ABSPATH' ) ) exit;

// show_を親から引き継ぐのは、post_foot では全表示するため。
$show_cat = $variable['show_cat'] ?? true;
$show_tag = $variable['show_tag'] ?? true;
$show_tax = $variable['show_tax'] ?? true;

$the_id   = get_the_ID();
$the_type = get_post_type();
$cat_data = $show_cat ? SWELL_Theme::get_the_terms_data( $the_id, 'category' ) : null;
$tag_data = $show_tag ? SWELL_Theme::get_the_terms_data( $the_id, 'post_tag' ) : null;

// カスタム投稿用
$has_tax = false;
if ( 'post' !== $the_type ) {
	$tax_slug = $show_tax ? SWELL_Theme::get_tax_of_post_type( $the_type ) : '';
	$tax_data = $tax_slug ? SWELL_Theme::get_the_terms_data( $the_id, $tax_slug ) : null;
}

?>
<?php if ( ! empty( $cat_data ) ) : ?>
	<div class="p-articleMetas__termList c-categoryList">
		<?php foreach ( $cat_data as $data ) : ?>
			<a class="c-categoryList__link hov-flash-up" href="<?=esc_url( $data['url'] )?>" data-cat-id="<?=esc_attr( $data['id'] )?>">
				<?=esc_html( $data['name'] )?>
			</a>
		<?php endforeach; ?>
	</div>
<?php endif; ?>
<?php if ( ! empty( $tag_data ) ) : ?>
	<div class="p-articleMetas__termList c-tagList">
		<?php foreach ( $tag_data as $data ) : ?>
			<a class="c-tagList__link hov-flash-up" href="<?=esc_url( $data['url'] )?>" data-tag-id="<?=esc_attr( $data['id'] )?>">
				<?=esc_html( $data['name'] )?>
			</a>
		<?php endforeach; ?>
	</div>
<?php endif; ?>
<?php if ( ! empty( $tax_data ) ) : ?>
	<div class="p-articleMetas__termList c-taxList">
		<?php foreach ( $tax_data as $data ) : ?>
			<a class="c-taxList__link hov-flash-up" href="<?php echo esc_url( $data['url'] ); ?>" data-term-id="<?php echo esc_attr( $data['id'] ); ?>">
				<?php echo esc_html( $data['name'] ); ?>
			</a>
		<?php endforeach; ?>
	</div>
<?php endif; ?>
