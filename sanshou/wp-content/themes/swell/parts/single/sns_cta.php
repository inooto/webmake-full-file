<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$sns_cta_data = SWELL_Theme::get_sns_cta_data();
$tw_id        = $sns_cta_data['tw_id'];
$fb_url       = $sns_cta_data['fb_url'];
$insta_id     = $sns_cta_data['insta_id'];

$has_follow_btn = ( $tw_id || $insta_id );

$action_text = '';
if ( $has_follow_btn && $fb_url ) {
	$action_text = __( 'いいね または フォロー', 'swell' );
} elseif ( $fb_url ) {
	$action_text = __( 'いいね', 'swell' );
} elseif ( $has_follow_btn ) {
	$action_text = __( 'フォロー', 'swell' );
}

// この記事が気に入ったら%sしてね！
$cta_message = sprintf(
	__( 'この記事が気に入ったら%sしてね！', 'swell' ),
	'<br><i class="icon-thumb_up"></i> ' . $action_text
);

$lang    = get_bloginfo( 'language' );
$fb_lang = ( 'ja' === $lang ) ? 'ja_JP' : 'en'; // _x( 'en', 'fb', 'swell' );
$tw_lang = ( 'ja' === $lang ) ? 'ja' : 'en'; // _x( 'en', 'tw', 'swell' );

// @codingStandardsIgnoreStart
?>
<div class="p-snsCta">
	<?php
	if ( $fb_url ) : // FBのscript
		$fb_appID       = SWELL_Theme::get_setting( 'fb_like_appID' ) ?: '';
		$fb_appID_query = $fb_appID ? '&appId=' . $fb_appID . '&autoLogAppEvents=1' : '';
	?>
	<div id="fb-root"></div>
	<script class="fb_like_script">
		(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.async = true;
			js.src = "https://connect.facebook.net/<?=$fb_lang?>/sdk.js#xfbml=1&version=v4.0<?=esc_js( $fb_appID_query )?>";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	</script>
	<?php endif; ?>
	<figure class="p-snsCta__figure">
		<?php
			\SWELL_Theme::get_thumbnail( [
				'post_id' => get_the_ID(),
				'size'    => 'medium',
				'srcset'  => '',
				'class'   => 'p-snsCta__img u-obf-cover',
				'echo'    => true,
			] );
		?>
	</figure>
	<div class="p-snsCta__body">
		<p class="p-snsCta__message u-lh-15">
			<?=wp_kses_post( apply_filters( 'swell_sns_cta_message', $cta_message ) );?>
		</p>
		<div class="p-snsCta__btns">
			<?php if ( $fb_url ) : ?>
				<div class="fb-like" data-href="<?=esc_url( $fb_url )?>" data-layout="button" data-action="like" data-show-faces="false" data-share="false"></div>
			<?php endif; ?>
			<?php if ( $tw_id ) : ?>
				<a href="https://twitter.com/<?=esc_attr( $tw_id )?>?ref_src=twsrc%5Etfw" class="twitter-follow-button" data-show-screen-name="false" data-lang="<?=$tw_lang?>" data-show-count="false"><?=esc_html__( 'Follow @', 'swell' )?><?=esc_html( $tw_id )?></a>
				<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
			<?php endif; ?>
			<?php if ( $insta_id ) : ?>
				<a href="https://www.instagram.com/<?=esc_attr( $insta_id )?>/" class="c-instaFollowLink" target="_blank" rel="noopener noreferrer"><i class="c-iconList__icon icon-instagram" role="presentation"></i><span><?=esc_html__( 'Follow Me', 'swell' )?></span></a>
			<?php endif; ?>
		</div>
	</div>
</div>
