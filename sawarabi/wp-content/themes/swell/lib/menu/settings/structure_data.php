<?php
/**
 * タブ : 構造化データ
 */
if ( ! defined( 'ABSPATH' ) ) exit;

use \SWELL_THEME\Admin_Menu;
use \SWELL_Theme\Menu\Setting_Field as Field;

// Pagge Name
$page_name = Admin_Menu::PAGE_NAMES['structure'];

/**
 * JSON-LD
 */
Field::add_menu_section( [
	'title'      => __( 'JSON-LD', 'swell' ),
	'key'        => 'jsonld',
	'page_name'  => $page_name,
	'page_cb'    => function ( $args ) {

		Field::toggle_control( 'options', 'use_json_ld', [
			'label' => __( 'JSON-LDを自動生成する', 'swell' ),
		]);

		$disable = ( ! \SWELL_Theme::get_option( 'use_json_ld' ) ) ? ' -disable' : '';

		// phpcs:ignore WordPress.Security.EscapeOutput
		echo '<div class="u-mt-25 -json_ld' . $disable . ' ">';

		Field::h3( __( '運営組織の情報', 'swell' ) . ' (<code>publisher</code>)' );
		Field::description( '※ ' . __( '<b>必須項目が入力されていない場合</b>は、<b>サイト情報</b>を利用します。', 'swell' ) );

		$required = '<span class="required">' . __( '必須', 'swell' ) . '</span>';
		Field::input( 'options', 'ld_org_name', [
			'label' => 'name',
			'label' => __( '運営組織の名前', 'swell' ) . ' <code class="u-fz-s">name</code>' . $required,
			'size'  => 30,
		] );

		Field::input( 'options', 'ld_org_url', [
			'type'        => 'url',
			'label'       => __( '運営組織のURL', 'swell' ) . ' <code class="u-fz-s">url</code>' . $required,
			'placeholder' => 'https://example.com',
			'size'        => 60,
		] );

		Field::input( 'options', 'ld_org_alternateName', [
			'label' => __( '運営組織の別名', 'swell' ) . ' <code class="u-fz-s">alternateName</code>',
			'desc'  => __( '複数の場合は「,」で区切ってください。', 'swell' ),
			'size'  => 60,
		] );

		Field::textarea( 'options', 'ld_org_sameAs', [
			'label' => __( '運営組織の関連URL', 'swell' ) . '<code class="u-fz-s">sameAs</code>',
			'rows'  => 4,
			'desc'  => __( '複数の場合は「,（+改行）」で区切ってください。', 'swell' ),
		] );

		Field::media( 'options', 'ld_org_logo', [
			'label' => __( '運営組織のロゴ', 'swell' ) . '<code class="u-fz-s">logo</code>',
			// 'rows'  => 4,
			// 'desc'  => __( '複数の場合は「,（+改行）」で区切ってください。', 'swell' ),
		] );

		Field::h4( __( '運営組織の設立者', 'swell' ) . ' (<code>founder</code>)' );
		echo '<div class="swl-setting__field" style="padding-left:1.5em">';
			Field::input( 'options', 'ld_org_founder_name', [
				'label' => 'name',
				'label' => __( '設立者の名前', 'swell' ) . ' <code class="u-fz-s">name</code>',
				'size'  => 30,
			] );

			Field::input( 'options', 'ld_org_founder_url', [
				'type'        => 'url',
				'label'       => __( '設立者のURL', 'swell' ) . ' <code class="u-fz-s">url</code>',
				'placeholder' => 'https://example.com',
				'size'        => 60,
			] );

			Field::input( 'options', 'ld_org_founder_alternateName', [
				'label' => __( '設立者の別名', 'swell' ) . ' <code class="u-fz-s">alternateName</code>',
				'desc'  => __( '複数の場合は「,」で区切ってください。', 'swell' ),
				'size'  => 60,
			] );

			Field::textarea( 'options', 'ld_org_founder_sameAs', [
				'label' => __( '設立者の関連URL', 'swell' ) . '<code class="u-fz-s">sameAs</code>',
				'rows'  => 4,
				'desc'  => __( '複数の場合は「,（+改行）」で区切ってください。', 'swell' ),
			] );

		echo '</div>';

		echo '</div>';

		// echo '<br>';
		// Field::description( __( '(設定がない場合はサイトデータが使用されます。)', 'swell' ) );
	},
] );

// 非AMPでも必要になったら実装する
// add_settings_field(
// 	'publisher_logo_url',
// 	'',
// 	$cb,
// 	$page_name,
// 	$section_name,
// 	[
// 		'id'     => 'publisher_logo_url',
// 		'type'   => 'input',
// 		'before' => '<p>' . __( 'Articleのpublisher.logo.url', 'swell' ) . '</p>',
// 	]
// );
// }
