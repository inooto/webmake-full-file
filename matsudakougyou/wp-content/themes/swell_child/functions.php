<?php

/* 子テーマのfunctions.phpは、親テーマのfunctions.phpより先に読み込まれることに注意してください。 */


/**
 * 親テーマのfunctions.phpのあとで読み込みたいコードはこの中に。
 */
// add_filter('after_setup_theme', function(){
// }, 11);


/**
 * 子テーマでのファイルの読み込み
 */
add_action('wp_enqueue_scripts', function() {
	
	$timestamp = date( 'Ymdgis', filemtime( get_stylesheet_directory() . '/style.css' ) );
	wp_enqueue_style( 'child_style', get_stylesheet_directory_uri() .'/style.css', [], $timestamp );

	/* その他の読み込みファイルはこの下に記述 */
}, 11);


function add_file_ver_to_css_js( $src ) {
	return $src;
} 

//</body>前にjQueryと自作jsを追加
add_action('wp_footer', function() {
	//デフォルトjquery削除
	wp_deregister_script('jquery');
	//GoogleCDNから読み込む
	wp_enqueue_script('jquery-js', '//ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js' );

	$timestamp = date( 'Ymdgis', filemtime( get_stylesheet_directory() . '/myscript.js' ) );
	wp_enqueue_script( 'js', get_stylesheet_directory_uri() .'/myscript.js', [], $timestamp, true);
}, 11);
