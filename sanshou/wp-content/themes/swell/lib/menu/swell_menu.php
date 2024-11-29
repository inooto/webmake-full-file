<?php

use \SWELL_THEME\Admin_Menu;
if ( ! defined( 'ABSPATH' ) ) exit;

$setting_tabs = [
	'speed'     => __( '高速化', 'swell' ),
	'structure' => __( '構造化データ', 'swell' ),
	'jquery'    => __( 'jQuery', 'swell' ),
	'fa'        => __( 'Font Awesome', 'swell' ),
	'remove'    => __( '機能停止', 'swell' ),
	'ad'        => __( '広告コード', 'swell' ),
	'reset'     => __( 'リセット', 'swell' ),
];

// メッセージ
$green_message = '';

// Settings API は $_REQUEST でデータが渡ってくる
if ( isset( $_REQUEST['settings-updated'] ) && $_REQUEST['settings-updated'] ) {
	$green_message = __( '設定を保存しました。', 'swell' );

	// CSSキャッシュ削除
	\SWELL_Theme::clear_cache( \SWELL_Theme::$cache_keys['style'] );
}

if ( $green_message ) {
	echo '<div class="notice updated is-dismissible"><p>' . esc_html( $green_message ) . '</p></div>';
}

// 現在のタブを取得
$now_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'speed'; //phpcs:ignore
// $now_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : array_key_first( $setting_tabs ); // v3.0~

?>

<div id="swell_setting_page" class="swl-setting">
	<h1 class="swl-setting__title"><?=esc_html__( 'SWELL設定', 'swell' )?></h1>
	<p class="swl-setting__page_desc">
		<?php
			echo sprintf(
				esc_html__( 'デザインやカラーの設定は「%s」ページから可能です。', 'swell' ),
				'<a href="' . esc_url( admin_url( 'admin.php?page=swell_settings_editor' ) ) . '">' . esc_html__( 'エディター設定', 'swell' ) . '</a>'
			);
		?>
	</p>
	<hr class="wp-header-end">
	<div class="swl-setting__navTab">
		<div class="nav-tab-wrapper">
			<?php
				foreach ( $setting_tabs as $key => $val ) :

				$tab_url   = admin_url( 'admin.php?page=' . \SWELL_Theme::MENU_SLUGS['basic'] ) . '&tab=' . $key;
				$nav_class = ( $now_tab === $key ) ? 'nav-tab act_' : 'nav-tab';
				echo '<a href="' . esc_url( $tab_url ) . '" class="' . esc_attr( $nav_class ) . '">' . esc_html( $val ) . '</a>';

				// $nav_class = ( reset( $setting_tabs ) === $val ) ? 'nav-tab act_' : 'nav-tab';
				// echo '<a href="#' . $key . '" class="' . $nav_class . '">' . $val . '</a>';

				endforeach;
			?>
		</div>
	</div>
	<div class="swl-setting__body">
		<form method="POST" action="options.php">
		<?php
			foreach ( $setting_tabs as $key => $val ) {
				$tab_class = 'swl-setting__tabBody';
				if ( $now_tab === $key ) {
					$tab_class .= ' -active';
				}

				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo '<div id="' . $key . '" class="' . $tab_class . '">';

				// タブコンテンツの読み込み
				if ( file_exists( T_DIRE . '/lib/menu/tabs/' . $key . '.php' ) ) {
					include_once T_DIRE . '/lib/menu/tabs/' . $key . '.php';
				} else {
					// ファイルなければ単純に do_settings_sections
					do_settings_sections( Admin_Menu::PAGE_NAMES[ $key ] );
					submit_button( '', 'primary large', 'submit_' . $key );
				}

				echo '</div>';
			}

			settings_fields( Admin_Menu::SETTING_GROUPS['options'] ); // settings_fieldsがnonceなどを出力するだけ
		?>
		</form>
	</div>
</div>
