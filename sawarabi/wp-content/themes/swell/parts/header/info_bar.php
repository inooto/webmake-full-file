<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$SETTING = SWELL_Theme::get_setting();

$flowing_class = ( 'flow' === $SETTING['info_flowing'] ) ? '-flow-on' : '-flow-off';

$info_data = [
	'url'      => $SETTING['info_url'],
	'text'     => $SETTING['info_text'],
	'btn_text' => $SETTING['info_btn_text'],
];
$info_data = apply_filters( 'swell_infobar_data', $info_data );

// 外部リンクかどうか
$target = ( strpos( $info_data['url'], home_url( '/' ) ) !== false ) ? '' : ' rel="noopener" target="_blank"';


// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
?>
<div class="c-infoBar -bg-<?=esc_attr( $SETTING['info_bar_effect'] )?>">
	<?php if ( 'btn' === $SETTING['info_flowing'] ) : // ボタン設置する場合 ?>
		<span class="c-infoBar__text <?=esc_attr( $flowing_class )?>">
			<?=wp_kses( $info_data['text'], SWELL_Theme::$allowed_text_html )?>
			<a href="<?=esc_url( $info_data['url'] )?>" class="c-infoBar__btn"<?=$target?>>
				<?=wp_kses( $info_data['btn_text'], SWELL_Theme::$allowed_text_html )?>
			</a>
		</span>
	<?php elseif ( empty( $info_data['url'] ) ) : // リンクがない場合はaタグなし ?>
		<span class="c-infoBar__text <?=esc_attr( $flowing_class )?>"><?=wp_kses( $info_data['text'], SWELL_Theme::$allowed_text_html )?></span>
	<?php else : ?>
		<a href="<?=esc_url( $info_data['url'] )?>" class="c-infoBar__link"<?=$target?>>
			<span class="c-infoBar__text <?=esc_attr( $flowing_class )?>"><?=wp_kses( $info_data['text'], SWELL_Theme::$allowed_text_html )?></span>
		</a>
	<?php endif; ?>
</div>
