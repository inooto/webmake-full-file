<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$wp_customize->add_panel( 'swl_panel_wordpress', [
	'title'    => __( 'WordPress設定', 'swell' ),
	'priority' => 1,
] );
$wp_customize->add_section( 'title_tagline', [
	'title'    => __( 'Site Identity' ), // phpcs:disable WordPress.WP.I18n.MissingArgDomain
	'priority' => 1,
	'panel'    => 'swl_panel_wordpress',
] );
$wp_customize->add_section( 'static_front_page', [
	'title'    => __( 'Homepage Settings' ), // phpcs:disable WordPress.WP.I18n.MissingArgDomain
	'priority' => 1,
	'panel'    => 'swl_panel_wordpress',
] );
