<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * sns_btns
 */

$position    = $variable['position'];
$the_id      = get_the_ID();
$share_url   = get_permalink( $the_id );
$share_title = html_entity_decode( get_the_title( $the_id ) );

$SETTEING      = SWELL_Theme::get_setting();
$style         = $SETTEING['share_btn_style'];
$hashtags      = $SETTEING['share_hashtags'];
$via           = $SETTEING['share_via'];
$urlcopy_pos   = $SETTEING['urlcopy_btn_pos'];
$share_message = $SETTEING['share_message'];

$is_fix = '-fix' === $position;

$share_btns_class = $position . ' -style-' . $style;
$hov_class        = ( 'icon' === $style ) ? '' : 'hov-flash-up';

$share_btns = [
	'facebook' => [
		'check_key'   => 'show_share_btn_fb',
		'title'       => __( 'Facebookでシェア', 'swell' ),
		'href'        => 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode( $share_url ),
		'window_size' => 'height=800,width=600',
	],
	'twitter' => [
		'check_key'   => 'show_share_btn_tw',
		'title'       => __( 'X(Twitter)でシェア', 'swell' ),
		'href'        => 'https://twitter.com/intent/tweet?',
		'window_size' => 'height=400,width=600',
		'querys'      => [
			'url'  => $share_url,
			'text' => $share_title,
		],
	],
	'hatebu' => [
		'check_key'   => 'show_share_btn_hatebu',
		'title'       => __( 'はてなブックマークに登録', 'swell' ),
		'href'        => '//b.hatena.ne.jp/add?mode=confirm&url=' . urlencode( $share_url ),
		'window_size' => 'height=600,width=1000',
	],
	'pocket' => [
		'check_key' => 'show_share_btn_pocket',
		'title'     => __( 'Pocketに保存', 'swell' ),
		'href'      => 'https://getpocket.com/edit?',
		'querys'    => [
			'url'   => $share_url,
			'title' => $share_title,
		],
	],
	'pinterest' => [
		'check_key' => 'show_share_btn_pin',
		'title'     => __( 'ピンを保存', 'swell' ),
		'href'      => 'https://jp.pinterest.com/pin/create/button/',
		'attrs'     => 'data-pin-do="buttonBookmark" data-pin-custom="true" data-pin-lang="ja"',
	],
	'line' => [
		'check_key' => 'show_share_btn_line',
		'title'     => __( 'LINEに送る', 'swell' ),
		'href'      => 'https://social-plugins.line.me/lineit/share?',
		'querys'    => [
			'url'   => $share_url,
			'text'  => $share_title,
		],
	],
];

if ( 'out' === $urlcopy_pos ) $share_btns_class .= ' has-big-copybtn';
?>
<div class="c-shareBtns <?=esc_attr( $share_btns_class )?>">
	<?php if ( '-bottom' === $position && $share_message ) : ?>
		<div class="c-shareBtns__message">
			<span class="__text">
				<?=esc_html( $share_message )?>
			</span>
		</div>
	<?php endif; ?>
	<ul class="c-shareBtns__list">
		<?php foreach ( $share_btns as $key => $data ) : ?>
		<?php
			if ( ! $SETTEING[ $data['check_key'] ] ) continue;

			// twitter → X

			if ( 'twitter' === $key && apply_filters( 'swell_twitter_to_x', 1 ) ) {
				$key = 'twitter-x';
			}
			if ( 'pinterest' === $key ) {
				SWELL_Theme::set_use( 'pinterest', true );
			}

			if ( isset( $data['querys'] ) ) :
				$querys = $data['querys'];

				// Twitterだけ追加設定あり
				if ( 'twitter' === $key || 'twitter-x' === $key ) :
					if ( $hashtags ) $querys['hashtags'] = $hashtags;
					if ( $via ) $querys['via']           = $via;
				endif;
				$href = $data['href'] . http_build_query( $querys, '', '&' );
			else :
				$href = $data['href'];
			endif;

			$btn_attrs  = 'href="' . esc_url( $href ) . '"';
			$btn_attrs .= ' title="' . $data['title'] . '"';

			// onclick
			if ( isset( $data['window_size'] ) ) :
				$window_size = $data['window_size'];

				$onclick = "javascript:window.open(this.href, '_blank', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,{$window_size}');return false;";

				$btn_attrs .= ' onclick="' . $onclick . '"';
			endif;


			$btn_attrs .= ' target="_blank" role="button" tabindex="0"';

			// 追加の属性があれば
			if ( isset( $data['attrs'] ) ) $btn_attrs .= ' ' . $data['attrs'];

			// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
			?>
			<li class="c-shareBtns__item -<?=esc_attr( $key )?>">
				<a class="c-shareBtns__btn <?=esc_attr( $hov_class )?>" <?=$btn_attrs?>>
					<i class="snsicon c-shareBtns__icon icon-<?=esc_attr( $key )?>" aria-hidden="true"></i>
				</a>
			</li>
		<?php endforeach; ?>
		<?php // phpcs:enable WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		<?php if ( ( ! $is_fix && 'in' === $urlcopy_pos ) || ( $is_fix && 'none' !== $urlcopy_pos ) ) : ?>
			<?php SWELL_Theme::set_use( 'clipboard', true ); ?>
			<li class="c-shareBtns__item -copy">
				<button class="c-urlcopy c-plainBtn c-shareBtns__btn <?=esc_attr( $hov_class )?>" data-clipboard-text="<?=esc_url( $share_url )?>" title="<?=esc_attr__( 'URLをコピーする', 'swell' )?>">
					<span class="c-urlcopy__content">
						<?php \SWELL_Theme\SVG::the_svg( 'copy', [ 'class' => 'c-shareBtns__icon -to-copy' ] ); ?>
						<?php \SWELL_Theme\SVG::the_svg( 'copied', [ 'class' => 'c-shareBtns__icon -copied' ] ); ?>
					</span>
				</button>
				<div class="c-copyedPoppup"><?=esc_html__( 'URLをコピーしました！', 'swell' )?></div>
			</li>
		<?php endif; ?>
	</ul>

	<?php if ( ! $is_fix && 'out' === $urlcopy_pos ) : ?>
		<?php SWELL_Theme::set_use( 'clipboard', true ); ?>
		<div class="c-shareBtns__item -copy c-big-urlcopy">
			<button class="c-urlcopy c-plainBtn c-shareBtns__btn <?=esc_attr( $hov_class )?>" data-clipboard-text="<?=esc_url( $share_url )?>" title="<?=esc_attr__( 'URLをコピーする', 'swell' )?>">
				<span class="c-urlcopy__content">
					<span class="c-shareBtns__icon -to-copy">
						<i class="icon-clipboard-copy"></i>
						<span class="c-urlcopy__text"><?=esc_html__( 'URLをコピーする', 'swell' )?></span>
					</span>
					<span class="c-shareBtns__icon -copied">
						<i class="icon-clipboard-copied"></i>
						<span class="c-urlcopy__text"><?=esc_html__( 'URLをコピーしました！', 'swell' )?></span>
					</span>
				</span>
			</button>
		</div>
	<?php endif; ?>
</div>
