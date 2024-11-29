<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$author_id = $variable ?: '';

// データ取得
$author_data        = SWELL_Theme::get_author_data( $author_id );
$author_name        = $author_data['name'] ?? '';
$author_description = $author_data['description'] ?? '';
$author_position    = $author_data['position'] ?? '';
$author_sns_list    = $author_data['sns_list'] ?? [];
$author_url         = get_author_posts_url( $author_id );
?>
<section class="l-articleBottom__section -author">
	<h2 class="l-articleBottom__title c-secTitle">
		<?php echo wp_kses( SWELL_Theme::get_setting( 'post_author_title' ), SWELL_Theme::$allowed_text_html ); ?>
	</h2>
	<div class="p-authorBox">
		<div class="p-authorBox__l">
			<?php echo get_avatar( $author_id, 100, '', sprintf( __( '%sのアバター', 'swell' ), $author_name ) ); ?>
			<a href="<?=esc_url( $author_url )?>" class="p-authorBox__name hov-col-main u-fz-m">
				<?=esc_html( $author_name )?>
			</a>
			<?php if ( $author_position ) : ?>
				<span class="p-authorBox__position u-fz-s u-thin">
					<?=esc_html( $author_position )?>
				</span>
			<?php endif; ?>
		</div>
		<div class="p-authorBox__r">
			<?php if ( $author_description ) : ?>
				<p class="p-authorBox__desc u-thin">
					<?=wp_kses( nl2br( $author_description ), SWELL_Theme::$allowed_text_html )?>
				</p>
			<?php endif; ?>
			<?php
				// SNS情報があればアイコン表示
				if ( ! empty( $author_sns_list ) ) :
					$list_data = [
						'list_data' => $author_sns_list,
						'ul_class'  => 'is-style-circle p-authorBox__iconList',
						'hov_class' => 'hov-flash-up',
					];
					SWELL_Theme::get_parts( 'parts/icon_list', $list_data );
				endif;
			?>
			<?php if ( SWELL_Theme::get_setting( 'show_author_link' ) ) : ?>
				<div class="p-authorBox__more">
					<a href="<?=esc_url( $author_url )?>" class="p-authorBox__moreLink hov-bg-main u-fz-s">
						<?=esc_html__( 'この著者の記事一覧へ', 'swell' )?>
					</a>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
