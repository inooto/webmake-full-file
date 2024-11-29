<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<h2><?=esc_html__( 'キャッシュのクリア', 'swell' )?></h2>
	<div class="swell_reset_btn">
		<button id="swell_settings_btn___clear_cache" type="button" name="submit" class="button button-primary"><?=esc_html__( 'キャッシュを削除する', 'swell' )?></button>
	</div>
	<p class="description">
		<?=esc_html__( 'SWELLのキャッシュ機能で保持しているキャッシュデータを全て削除します。', 'swell' )?>
		<br><?=esc_html__( '※ブログカードのキャッシュを除く', 'swell' )?>
	</p>
<br>
<hr>
<br>

<h2><?=esc_html__( 'キャッシュのクリア（ブログカード）', 'swell' )?></h2>

	<div class="swell_reset_btn">
		<button id="swell_settings_btn___clear_card_cache" type="button" name="submit" class="button button-primary"><?=esc_html__( 'キャッシュを削除する', 'swell' )?></button>
	</div>
	<p class="description">
		<?=esc_html__( 'SWELLで保持しているブログカードのキャッシュデータを全て削除します。', 'swell' )?>
	</p>
<br>
<hr>
<br>

<h2><?=esc_html__( '古いデータを更新する', 'swell' )?></h2>

	<div class="swell_reset_btn">
		<button id="swell_settings_btn___do_update_action" type="button" name="submit" class="button button-primary"><?=esc_html__( 'データを更新する', 'swell' )?></button>
	</div>
	<p class="description">
		<?=esc_html__( '旧バージョン用のデータを最新バージョンに合わせたものに変換します。', 'swell' )?>
		<br><?=esc_html__( '本来はバージョンアップデート時に自動で処理されていますが、稀に処理が完了せず表示がおかしくなることがあります。その場合はこちらのボタンから再度データの変換処理を行ってください。', 'swell' )?>
	</p>
<br>
<hr>
<br>

<h2><?=esc_html__( 'カスタマイザーのリセット', 'swell' )?></h2>

	<div class="swell_reset_btn">
		<button id="swell_settings_btn___reset_settings" type="button" name="submit" class="button button-primary"><?=esc_html__( 'デフォルトに戻す', 'swell' )?></button>
	</div>
	<p class="description">
		<?=esc_html__( 'テーマカスタマイザーで設定されたデータを全て削除し、初期状態に戻します。', 'swell' )?>
		<br><?=wp_kses_post( __( '※ <b>復元はできません</b>のでご注意ください。', 'swell' ) )?>
	</p>
<br>
<hr>
<br>

<h2><?=esc_html__( 'PVのリセット', 'swell' )?></h2>
	<div class="swell_reset_btn">
		<button id="swell_settings_btn___reset_pv" type="button" name="submit" class="button button-primary"><?=esc_html__( 'PVをリセットする', 'swell' )?></button>
	</div>
	<p class="description">
		<?=esc_html__( 'SWELLで計測中のPVデータを全て削除し、初期状態に戻します。', 'swell' )?>
		<br><?=wp_kses_post( __( '※ <b>復元はできません</b>のでご注意ください。', 'swell' ) )?>
	</p>
<br>
