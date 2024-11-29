<?php
use \SWELL_Theme as SWELL;
use \SWELL_THEME\Admin_Menu;
if ( ! defined( 'ABSPATH' ) ) exit;

// データ復旧
if ( ! empty( $_POST ) && isset( $_POST['salvage_balloon_table'] ) ) {
	if ( ! \SWELL_Theme::check_nonce( '_balloon' ) ) {
		wp_die( esc_html__( '不正アクセスです。', 'swell' ) );
	}

	SWELL::salvage_balloon_table();
}

global $wpdb;
$table_exists     = SWELL::check_table_exists( $wpdb->prefix . SWELL::DB_TABLES['balloon'] );
$old_table_exists = SWELL::check_table_exists( SWELL::DB_TABLES['balloon'] );
$has_old_data     = SWELL::has_old_balloon_data();

// 古いデータもなく、新しいテーブルもない場合はアクセス時に作成
if ( ! $has_old_data && ! $old_table_exists && ! $table_exists ) {
	SWELL::create_balloon_table();
} elseif ( $old_table_exists && ! $table_exists ) {
	// 古いテーブルがあって新しいテーブルがない時（テーマ更新時に何かしらの理由で自動移行処理がうまくいかなった時）
	SWELL::migrate_balloon_table();
}

// タイトル
$is_list_page = false;
if ( isset( $_GET['post_new'] ) ) {
	$page_title = __( 'ふきだしセットを新規登録', 'swell' );
} elseif ( isset( $_GET['id'] ) ) {
	$page_title = __( 'ふきだしセットを編集', 'swell' );
} else {
	$is_list_page = true;
	$page_title   = __( 'ふきだしセット一覧', 'swell' );
}

$user_cap = current_user_can( 'edit_speech_balloons' ) ? 'edit' : 'read';
?>
<div id="swell_setting_page" class="swl-setting -balloon" data-cap="<?=esc_attr( $user_cap )?>">
	<h1 class='swl-setting__title'><?=esc_html( $page_title )?></h1>
	<hr class='wp-header-end' />
	<div id="swell_setting_page_content" data-is-old="<?=esc_attr( $has_old_data )?>"></div>

	<?php if ( $is_list_page && $old_table_exists ) : ?>
		<div class="swl-setting__foot u-mt-40">
			<form action="" method="post">
				<button name='salvage_balloon_table' class="components-button is-secondary"><?=esc_html__( 'データの復旧を試みる', 'swell' )?></button>
				<?php wp_nonce_field( SWELL::$nonce['action'] . '_balloon', SWELL::$nonce['name'] . '_balloon' ); ?>
			</form>
			<p>
				<?=wp_kses_post( __( 'SWELL <b>v.2.5.7 から v.2.5.8へアップデート時</b>にふきだしセットの数が減ってしまった場合にご利用ください。', 'swell' ) )?>
			</p>
		</div>
	<?php endif; ?>
</div>
