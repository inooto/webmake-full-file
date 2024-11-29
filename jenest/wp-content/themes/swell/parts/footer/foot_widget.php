<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$foot_widget = '';
$widget_ct   = 0;

if ( IS_MOBILE && is_active_sidebar( 'footer_sp' ) ) {
	// スマホ用フッターウィジェット
	$foot_widget = \SWELL_Theme::outuput_widgets( 'footer_sp', [
		'before' => '<div class="w-footer__box">',
		'after'  => '</div>',
		'echo'   => false,
	] );
} else {
	// フッターウィジェット 1 ~ 3
	$widget_ct = 0;
	if ( is_active_sidebar( 'footer_box1' ) ) {
		$widget_ct++;
		$foot_widget .= \SWELL_Theme::outuput_widgets( 'footer_box1', [
			'before' => '<div class="w-footer__box">',
			'after'  => '</div>',
			'echo'   => false,
			'active' => true,
		] );
	}

	if ( is_active_sidebar( 'footer_box2' ) ) {
		$widget_ct++;
		$foot_widget .= \SWELL_Theme::outuput_widgets( 'footer_box2', [
			'before' => '<div class="w-footer__box">',
			'after'  => '</div>',
			'echo'   => false,
			'active' => true,
		] );
	}
	if ( is_active_sidebar( 'footer_box3' ) ) {
		$widget_ct++;
		$foot_widget .= \SWELL_Theme::outuput_widgets( 'footer_box3', [
			'before' => '<div class="w-footer__box">',
			'after'  => '</div>',
			'echo'   => false,
			'active' => true,
		] );
	}
}

?>
<?php if ( '' !== $foot_widget ) : ?>
<div class="l-footer__widgetArea">
	<div class="l-container w-footer <?=esc_attr( '-col' . $widget_ct )?>">
		<?php echo $foot_widget; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</div>
</div>
<?php endif; ?>
