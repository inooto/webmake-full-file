<?php
use \SWELL_THEME\Admin_Menu;

if ( ! defined( 'ABSPATH' ) ) exit;

$setting_tabs = [
	'colors'  => __( 'カラーセット', 'swell' ),
	'border'  => __( 'ボーダーセット', 'swell' ),
	'marker'  => __( 'マーカー', 'swell' ),
	'btn'     => __( 'ボタン', 'swell' ),
	'iconbox' => __( 'アイコンボックス', 'swell' ),
	'balloon' => __( 'ふきだし', 'swell' ),
	'custom'  => __( 'カスタム書式', 'swell' ),
	'others'  => __( 'その他', 'swell' ),
];

// メッセージ用
$green_message = '';

// Settings API は $_REQUEST でデータが渡ってくる
if ( isset( $_REQUEST['settings-updated'] ) && $_REQUEST['settings-updated'] ) {
	$green_message = __( '設定を保存しました。', 'swell' );

	// CSSキャッシュ削除
	\SWELL_Theme::clear_cache( \SWELL_Theme::$cache_keys['style'] );
}

// メッセージの表示
if ( $green_message ) {
	echo '<div class="notice updated is-dismissible"><p>' . esc_html( $green_message ) . '</p></div>';
}

// 現在のタブを取得
$now_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'colors'; //phpcs:ignore
// $now_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : array_key_first( $setting_tabs ); // v3.0~
?>

<div id="swell_setting_page" class="swl-setting">

	<h1 class="swl-setting__title"><?=esc_html__( 'エディター設定', 'swell' )?></h1>
	<p class="swl-setting__page_desc">
		<?=wp_kses_post( __( '見出し・ボタン・マーカーなどに関しては、カスタマイザーの「<b>投稿・固定ページ</b>」 > 「<b>コンテンツのデザイン</b>」メニューから設定できます。', 'swell' ) )?>
		<!-- <?=esc_html__( '各設定のプレビューエリアは、サイトのテキストカラーと記事コンテンツ部分の背景色が反映されます。', 'swell' )?><br>
		<small><?=esc_html__( '(※ ふきだしのテキストカラーは #333 です)', 'swell' )?></small> -->
	</p>
	<hr class="wp-header-end">
	<div class="swl-setting__navTab">
		<div class="nav-tab-wrapper">
			<?php
				foreach ( $setting_tabs as $key => $val ) :
					$tab_url   = admin_url( 'admin.php?page=' . \SWELL_Theme::MENU_SLUGS['editor'] ) . '&tab=' . $key;
					$nav_class = ( $now_tab === $key ) ? 'nav-tab act_' : 'nav-tab';
					echo '<a href="' . esc_url( $tab_url ) . '" class="' . esc_attr( $nav_class ) . '">' . esc_html( $val ) . '</a>';
				endforeach;
			?>
		</div>
	</div>
	<div class="swl-setting__body"
		data-type-big="<?=esc_attr( \SWELL_Theme::get_editor( 'iconbox_type' ) )?>"
		data-type-small="<?=esc_attr( \SWELL_Theme::get_editor( 'iconbox_s_type' ) )?>"
	>
		<form method="POST" action="options.php">
		<?php
			foreach ( $setting_tabs as $key => $val ) {
				$tab_class = 'swl-setting__tabBody';
				if ( $now_tab === $key ) {
					$tab_class .= ' -active';
				}

				echo '<div id="' . esc_attr( $key ) . '" class="' . esc_attr( $tab_class ) . '">';

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

			settings_fields( Admin_Menu::SETTING_GROUPS['editors'] ); // settings_fieldsがnonceなどを出力するだけ
		?>
		</form>
	</div>
</div>
