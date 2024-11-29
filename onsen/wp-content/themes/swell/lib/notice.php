<?php
/**
 * 管理画面での通知系
 * ( 管理者権限でのみインクルードされる。)
 *
 * @package swell
 */
namespace SWELL_Theme\Hooks;

if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * notice追加
 */
add_action( 'admin_notices', function() {
	if ( ! empty( \SWELL_Theme::$active_plugins ) ) {
		if ( in_array( 'gutenberg/gutenberg.php', array_keys( \SWELL_Theme::$active_plugins ), true ) ) {
			echo ( '<div class="notice notice-error notce--swl-use-guten">' .
				'<p>' . wp_kses_post( __( 'SWELL: <b>Gutenberg</b>プラグインが有効化されています。基本的には必要ありませんので、無効化してください。', 'swell' ) ) . '</p>' .
			'</div>' );
		}
	}

	if ( 'ok' === \SWELL_Theme::$licence_status ) return;
	$licence_check_url = admin_url( 'admin.php?page=swell_settings_swellers' );
	$latest_version    = \SWELL_Theme::get_swl_latest_version();

	$text = sprintf(
		__( '%sが完了していません。', 'swell' ),
		'<a href="' . esc_url( $licence_check_url ) . '" target="_blank" rel="noopener">' . __( 'SWELLのユーザー認証', 'swell' ) . '</a>'
	) . '<br>' . __( 'そのため、バージョンアップデート機能が制限されてます。', 'swell' );

	if ( $latest_version ) {
		$text .= '' . sprintf(
			__( '（現在の最新バージョンは <b>ver.%s</b> です。）', 'swell' ),
			$latest_version
		);
	}

	echo '<div class="notice notice-error notce--swlr-no-activated">' .
			'<p><i class="__notice_icon icon-alert"></i>' . wp_kses( $text, \SWELL_Theme::$allowed_text_html ) . '</p>' .
		'</div>';
} );


/**
 * 利用規約の変更時の同意
 */
add_action( 'admin_notices', function() {
	// 通知のボタンチェック処理
	if ( empty( $_POST )) return;

	if ( isset( $_POST['swl_check_new_term'] ) ) {
		\SWELL_Theme::set_others_data( 'checked_terms_v2', true );
	}
}, 0);



/**
 * 利用規約の変更時の同意
 */
add_action( 'admin_notices', function() {

	$last_changed = \SWELL_Theme::get_term_changed_date();
	$data_key     = 'checked_terms_' . $last_changed;

	// 通知のボタンチェック処理
	if ( ! empty( $_POST ) && isset( $_POST['swl_check_new_term'] ) ) {
		\SWELL_Theme::set_others_data( $data_key, true );
	}

	// \SWELL_Theme::set_others_data( $data_key, '' );
	$checked_terms = \SWELL_Theme::get_others_data( $data_key );
	if ( $checked_terms ) return;

	$text = sprintf(
		__( '%sが変更されました。', 'swell' ),
		'<a href="https://swell-theme.com/terms/" target="_blank" rel="noopener">' . __( 'SWELLの利用規約', 'swell' ) . '</a>'
	) . '<small>(' . wp_date( 'Y.m.d', strtotime( $last_changed ) ) . ')</small>';

	?>
	<div class="notice notice-warning notce--swl-new-term-check">
		<p><?=wp_kses( $text, \SWELL_Theme::$allowed_text_html )?></p>
		<form action="" method="POST" style="padding:0 0 1em">
			<button type="submit" class="button button-primary" name="swl_check_new_term" value="1">利用規約に同意します</button>
		</form>
	</div>
	<?php
}, 5);

/**
 * ダッシュボードに追加
 */
add_action( 'wp_dashboard_setup', function() {

		wp_add_dashboard_widget(
			'swell-update-info',
			'<i class="icon-swell"></i>' . __( 'SWELLアップデート情報', 'swell' ),
			__NAMESPACE__ . '\dashboard_update_info',
			null,
			null,
			'normal',
			'high'
		);

		if ( current_user_can( 'manage_options' ) ) {
			wp_add_dashboard_widget(
				'swell-site-status',
				'<i class="icon-swell"></i>' . __( 'サイト情報', 'swell' ),
				__NAMESPACE__ . '\dashboard_site_status',
				null,
				null,
				'normal',
				'high'
			);
		}
} );


function dashboard_update_info() {

	$update_posts = get_transient( 'swell-upate-posts' );

	// キャッシュなければ
	if ( ! $update_posts ) {
		$update_posts = \SWELL_Theme::remote_get( 'https://swell-theme.com/wp-json/wp/v2/posts?categories=2&per_page=5' );
		set_transient( 'swell-upate-posts', $update_posts, 4 * HOUR_IN_SECONDS );
	}

	if ( empty( $update_posts ) ) return;

	?>
	<div class="wordpress-news hide-if-no-js">
		<div class="rss-widget">
			<ul>
				<?php foreach ( $update_posts as $item ) : ?>
					<li><a href="<?php echo esc_url( $item->link ); ?>" target="_blank" rel="noreferrer"><?php echo esc_html( $item->title->rendered ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
	<?php
}


function dashboard_site_status() {

	echo '<h3>' . esc_html__( 'バージョン情報', 'swell' ) . '</h3>';
	echo '<div class="__row"><span>WordPress</span>: <b>' . esc_html( get_bloginfo( 'version' ) ) . '</b></div>';
	echo '<div class="__row"><span>SWELL</span>: <b>' . esc_html( \SWELL_Theme::$swell_version ) . '</b></div>';
	echo '<div class="__row"><span>PHP</span>: <b>' . esc_html( phpversion() ) . '</b></div>';

	echo '<hr>';
	echo '<h3>' . esc_html__( '有効化中のプラグイン一覧', 'swell' ) . '</h3>';
	if ( empty( \SWELL_Theme::$active_plugins ) ) {
		echo esc_html__( '有効なプラグインはありません。', 'swell' );
	} else {
		$all = '';
		foreach ( \SWELL_Theme::$active_plugins as $path => $plugin ) {
			$all .= '<div class="__plugin">' . $plugin['name'] . ' <small>(v.' . $plugin['ver'] . ')</small></div>';
		}

		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $all;
	}
}
