<?php
use \SWELL_Theme as SWELL;
if ( ! defined( 'ABSPATH' ) ) exit;


// 保存済みアドレス
$saved_email = get_option( 'sweller_email' );

// ステータス
$licence_status = SWELL::$licence_status;
$help           = '';
$onsubmit       = '';
if ( 'ok' === $licence_status ) {

	$status_box = [
		'color' => '#18992d',
		'icon'  => 'yes',
		'text'  => __( '認証完了', 'swell' ),
	];
	$submit_btn = [
		'val'   => 'delete',
		'class' => 'secondary',
		'text'  => __( '認証解除', 'swell' ),
	];

	$onsubmit = 'return swl_conf_delete()';

} elseif ( 'waiting' === $licence_status ) {

	$status_box = [
		'color' => '#e17622',
		'icon'  => 'warning',
		'text'  => __( '認証URLをメールアドレスへ送信しました。5分以内にURLへアクセスしてください。<br>認証完了後、下の「アクティベートを完了」ボタンを押してください。', 'swell' ),
	];
	$submit_btn = [
		'val'   => 'check',
		'class' => 'primary',
		'text'  => __( 'アクティベートを完了', 'swell' ),
	];

	$help = '<p>' . __( '※ 5分を過ぎてリンクの期限が切れてしまった場合は、一度画面を更新して認証リクエストを再送信してください。', 'swell' ) . '</p>';

} elseif ( 'timeout' === $licence_status ) {

	$status_box = [
		'color' => '#e17622',
		'icon'  => 'warning',
		'text'  => __( '認証URLの期限が切れています。', 'swell' ),
	];
	$submit_btn = [
		'val'   => 'check',
		'class' => 'primary',
		'text'  => __( '認証URLを再送する', 'swell' ),
	];

} else {
	// ステータスが 'expired' or 'ng' の時

	$status_box = [
		'color' => '#f0001f',
		'icon'  => 'no',
		'text'  => __( '未認証', 'swell' ),
	];

	$submit_btn = [
		'val'   => 'check',
		'class' => 'primary',
		'text'  => __( '認証リクエストを送信', 'swell' ),
	];

	// キャッシュ期限切れのautoチェック時に認証失敗したケース(会員サイト上で手動削除したとき)
	// if ( 'expired' === $licence_status ) {}

	if ( 'ng' === $licence_status && $saved_email ) {
		$status_box['text'] .= ' <small>' . __( 'このアドレスは会員サイトに登録されていませんでした。', 'swell' ) . '</small>';
	}

	$help  = '<p><span class="dashicons dashicons-warning"></span> ' . __( 'メールアドレスの認証が完了するまで、最新版へのアップデートが制限されます。', 'swell' ) . '</p>';
	$help .= '<p class="u-mt-5">';
	$help .= '<span class="dashicons dashicons-info-outline"></span>' . __( '認証には<a href="https://users.swell-theme.com/signup/" target="_blank" rel="noopener">SWELL会員サイトへの登録</a>が必要です。', 'swell' );
	$help .= __( '( 詳しくは<a href="https://swell-theme.com/basic-setting/8974/" target="_blank" rel="noopener">ユーザー認証の手順解説</a>ページをご覧ください。）', 'swell' );
	$help .= '<br>　<span class="u-fz-s">' . __( '※ 旧会員サイトに登録済みの方も、新会員サイトへの再登録が必要となります。', 'swell' ) . '</span>';
	$help .= '</p>';
}

?>
<script>
	function swl_conf_delete(){
		if ( window.confirm( '<?=esc_html__( '本当に解除しますか？（会員サイト側でも認証が解除されます。）', 'swell' )?>' ) ) {
			return true;
		}
		return false;
	}
</script>
<style>
	.swlr-activate_help p{
		color: #646970;
		font-size: inherit !important;
	}
	.swlr-activate_help .dashicons{
		vertical-align: middle;
	}
	code.swlr-activated_email{
		padding: 6px 8px;
		border-radius: 2px;
		background-color: #f5f5f5;
	}
</style>
<div id="swell_setting_page" class="swl-setting">
	<h1 class="swl-setting__title"><?=esc_html__( 'SWELL アクティベート設定', 'swell' )?></h1>
	<hr class="wp-header-end">
	<div class="swl-setting__body">
		<div class="swl-form-div">
			<form action="" method="post" onsubmit="<?=esc_attr( $onsubmit )?>">
				<h3 style="margin:0 0 1em"><?=esc_html__( 'ユーザー認証', 'swell' )?></h3>
				<div class="u-mb-10">
					<label for="sweller_email"><?=esc_html__( 'メールアドレス', 'swell' )?></label>
					<?php if ( 'ok' === $licence_status ) : ?>
						<code class="swlr-activated_email"><?=esc_html( $saved_email )?></code>
						<input type="hidden" name="sweller_email" id="sweller_email" value="<?=esc_attr( $saved_email )?>">
					<?php else : ?>
						<input type="text" name="sweller_email" id="sweller_email" class="regular-text" size="40" value="<?=esc_attr( $saved_email )?>" placeholder="<?=esc_attr__( "SWELLERS' 会員アドレスを入力", 'swell' )?>">
					<?php endif; ?>
				</div>

				<?php // phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<div class="swlr-activate_status -<?=esc_attr( $licence_status )?>" style="color: <?=$status_box['color']?>;">
					<span class="dashicons dashicons-<?=$status_box['icon']?>"></span> <?=$status_box['text']?>
				</div>
				<div class="u-mt-10">
					<button type="submit" name="swlr_activate_submit" class="button button-<?=$submit_btn['class']?>" value="<?=$submit_btn['val']?>"><?=$submit_btn['text']?></button>
				</div>
				<?php if ( $help ) echo '<div class="swlr-activate_help u-mt-15 u-fz-s">' . $help . '</div>'; ?>
				<?php // phpcs:enable WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<?php SWELL::set_nonce_field( '_activate' ); ?>
			</form>
		</div>
	</div>
</div>
