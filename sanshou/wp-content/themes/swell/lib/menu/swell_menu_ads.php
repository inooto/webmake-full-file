<?php
use \SWELL_Theme as SWELL;
if ( ! defined( 'ABSPATH' ) ) exit;

// メッセージ用
$green_message = '';

// ads.txtのパス
$root_path     = $_SERVER['DOCUMENT_ROOT'] ?? '';
$ads_text_path = $root_path . '/ads.txt';

if ( isset( $_POST['ads_txt'] ) ) {

	// nonce チェック
	if ( ! SWELL::check_nonce( '_ads_txt' ) ) {
		esc_html__( '不正アクセスです。', 'swell' );
		exit;
	}


	// ファイル編集
	$new_text = trim( $_POST['ads_txt'] );

	// まだ ads.txt ファイルがなければ、空で作成
	if ( ! file_exists( $ads_text_path ) ) {
		file_put_contents( $ads_text_path, '' );
	}

	// 内容を更新
	file_put_contents( $ads_text_path, $new_text );

	$green_message = esc_html__( 'ads.txtファイルを編集しました', 'swell' );

}

// メッセージの表示
if ( $green_message ) {
	echo '<div class="notice updated is-dismissible"><p>' . esc_html( $green_message ) . '</p></div>';
}

$ads_content = file_exists( $ads_text_path ) ? file_get_contents( $ads_text_path ) : '';

?>
<div id="swell_setting_page" class="swl-setting">
	<h1 class="swl-setting__title"><?=esc_html__( 'ads.txt編集', 'swell' )?></h1>
	<hr class="wp-header-end">
	<div class="swl-setting__body">
		<form action="" method="post">
			<table class="form-table">
				<tbody>
					<tr>
					<th scope="row">
						<label for="ads_txt"><?=sprintf( esc_html__( '%sファイル', 'swell' ), '<code>ads.txt</code>' );?>: </label>
					</th>
					<td>
						<textarea name="ads_txt" id="ads_txt" cols="90" rows="10"><?=esc_html( $ads_content )?></textarea>
						<p class="description">
							<?=esc_html__( 'Google AdSenseの形式', 'swell' )?>
							: <code>google.com, pub-0000000000000000, DIRECT, f08c47fec0942fa0</code>
							<br>
							<a href="https://support.google.com/adsense/answer/7532444?hl=ja" target="_blank" rel="noopener"><?=esc_html__( '詳しくはこちら', 'swell' )?></a>
						</p>
					</td>
				</tr>
				</tbody>
			</table>
			<?php SWELL::set_nonce_field( '_ads_txt' ); ?>
			<p class="submit">
				<input type="submit" name="submit" id="ads_submit" class="button button-primary" value="<?=esc_attr__( 'ads.txtを変更する', 'swell' )?>">
			</p>
		</form>
	</div>
</div>
