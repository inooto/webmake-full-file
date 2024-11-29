<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * プロフィールウィジェット
 */

// 引数から受け取る情報
$user_name      = $variable['user_name'];
$user_job       = $variable['user_job'];
$user_profile   = $variable['user_profile'];
$user_icon      = $variable['user_icon'];
$user_bg        = $variable['user_bg'];
$btn_link       = $variable['btn_link'];
$btn_text       = $variable['btn_text'];
$btn_color      = $variable['btn_color'];
$show_user_sns  = $variable['show_user_sns'];
$is_icon_circle = $variable['is_icon_circle'];
?>
<div class="p-profileBox">
	<?php if ( $user_bg ) : ?>
		<figure class="p-profileBox__bg">
			<?php
				$bg_img_id = SWELL_Theme::get_imgid_from_url( $user_bg );
				SWELL_Theme::get_image( $bg_img_id, [
					'class'   => 'p-profileBox__bgImg',
					'sizes'   => '(max-width: 959px) 100vw, 320px',
					'alt'     => '',
					'echo'    => true,
				]);
			?>
		</figure>
	<?php endif; ?>
	<?php if ( $user_icon ) : ?>
		<figure class="p-profileBox__icon">
			<?php
				$icon_img_id = SWELL_Theme::get_imgid_from_url( $user_icon );
				SWELL_Theme::get_image( $icon_img_id, [
					'size'    => 'medium',
					'class'   => 'p-profileBox__iconImg',
					'width'   => '120',
					'height'  => '120',
					'sizes'   => '(max-width: 120px) 100vw, 120px',
					'alt'     => '',
					'echo'    => true,
				]);
			?>
		</figure>
	<?php endif; ?>
	<div class="p-profileBox__name u-fz-m">
		<?=esc_html( $user_name )?>
	</div>
	<?php if ( $user_job ) : ?>
		<div class="p-profileBox__job u-thin">
			<?=esc_html( $user_job )?>
		</div>
	<?php endif; ?>
	<?php if ( $user_profile ) : ?>
		<div class="p-profileBox__text">
			<?=wp_kses( nl2br( do_shortcode( $user_profile ) ), SWELL_Theme::$allowed_text_html )?>
			<?php if ( $btn_link ) : ?>
				<div class="p-profileBox__btn is-style-btn_normal">
					<a href="<?=esc_url( $btn_link )?>" style="background:<?=esc_attr( $btn_color )?>" class="p-profileBox__btnLink">
						<?=wp_kses( do_shortcode( $btn_text ), SWELL_Theme::$allowed_text_html )?>
					</a>
				</div>
			<?php endif; ?>
		</div>
	<?php endif; ?>
	<?php
		if ( $show_user_sns ) : // SNSアイコンリスト
		$sns_settings = SWELL_Theme::get_sns_settings();

		if ( ! empty( $sns_settings ) ) :
			$list_data = [
				'list_data' => $sns_settings,
			];
			if ( false === $is_icon_circle ) :
				$list_data['fz_class'] = 'u-fz-16';
				$list_data['ul_class'] = 'p-profileBox__iconList';
				else :
					$list_data['ul_class']  = 'p-profileBox__iconList is-style-circle';
					$list_data['fz_class']  = 'u-fz-14';
					$list_data['hov_class'] = 'hov-flash-up';
				endif;

				SWELL_Theme::get_parts( 'parts/icon_list', $list_data );
			endif;
		endif;
	?>
</div>
