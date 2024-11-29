<?php
namespace SWELL_Theme\Widget;

if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * ウィジェットアイテムを読み込む
 */
new \SWELL_Theme\Legacy_Widget();


/**
 * ウィジェット登録
 */
add_action( 'widgets_init', __NAMESPACE__ . '\register_area' );
function register_area() {

	// ウィジェットエリアの登録
	register_sidebar([
		'name'          => __( 'ヘッダー内部', 'swell' ),
		'id'            => 'head_box',
		'description'   => __( 'ヘッダー内に表示するウィジェット。スマホでは表示されません。', 'swell' ),
		'before_widget' => '<div id="%1$s" class="w-header__item %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="w-header__title">',
		'after_title'   => '</div>',
	]);
	register_sidebar([
		'name'          => __( '共通サイドバー', 'swell' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'サイドバーに表示されます。', 'swell' ),
		'before_widget' => '<div id="%1$s" class="c-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="c-widget__title -side">',
		'after_title'   => '</div>',
	]);
	register_sidebar([
		'name'          => __( '共通サイドバー【スマホ版】', 'swell' ),
		'id'            => 'sidebar_sp',
		'description'   => __( 'ここにウィジェットをセットすると、「共通サイドバー」がスマホでのみ上書きされます。', 'swell' ),
		'before_widget' => '<div id="%1$s" class="c-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="c-widget__title -side">',
		'after_title'   => '</div>',
	]);
	register_sidebar([
		'name'          => __( 'トップページ専用サイドバー', 'swell' ),
		'id'            => 'sidebar_top',
		'description'   => __( 'トップページにのみ表示されるサイドバー。「共通サイドバー」の<b>上部</b>に表示されます。', 'swell' ),
		'before_widget' => '<div id="%1$s" class="c-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="c-widget__title -side">',
		'after_title'   => '</div>',
	]);
	register_sidebar([
		'name'          => __( '追尾サイドバー', 'swell' ),
		'id'            => 'fix_sidebar',
		'description'   => __( 'スクロールに合わせて固定表示させるサイドバー。PC表示でのみ表示されます。', 'swell' ),
		'before_widget' => '<div id="%1$s" class="c-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="c-widget__title -side">',
		'after_title'   => '</div>',
	]);
	register_sidebar([
		'name'          => __( 'スマホ開閉メニュー下', 'swell' ),
		'id'            => 'sp_menu_bottom',
		'description'   => __( 'スマホメニューの下部に表示されます。', 'swell' ),
		'before_widget' => '<div id="%1$s" class="c-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="c-widget__title -spmenu">',
		'after_title'   => '</div>',
	]);
	register_sidebar([
		'name'          => __( 'トップページ上部', 'swell' ),
		'id'            => 'front_top',
		'description'   => __( 'トップページのコンテンツ上部に表示されます。', 'swell' ),
		'before_widget' => '<div id="%1$s" class="c-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="c-secTitle -widget"><span>',
		'after_title'   => '</span></h2>',
	]);
	register_sidebar([
		'name'          => __( 'トップページ下部', 'swell' ),
		'id'            => 'front_bottom',
		'description'   => __( 'トップページのコンテンツ下部に表示されます。', 'swell' ),
		'before_widget' => '<div id="%1$s" class="c-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="c-secTitle -widget"><span>',
		'after_title'   => '</span></h2>',
	]);
	register_sidebar([
		'name'          => __( '固定ページ上部', 'swell' ),
		'id'            => 'page_top',
		'description'   => __( '固定ページのコンテンツ上部に表示されます。', 'swell' ),
		'before_widget' => '<div id="%1$s" class="c-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="c-secTitle -widget"><span>',
		'after_title'   => '</span></h2>',
	]);
	register_sidebar([
		'name'          => __( '固定ページ下部', 'swell' ),
		'id'            => 'page_bottom',
		'description'   => __( '固定ページのコンテンツ下部に表示されます。', 'swell' ),
		'before_widget' => '<div id="%1$s" class="c-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="c-secTitle -widget"><span>',
		'after_title'   => '</span></h2>',
	]);
	register_sidebar([
		'name'          => __( '記事上部', 'swell' ),
		'id'            => 'single_top',
		'description'   => __( '投稿ページのコンテンツ上部に表示されます。', 'swell' ),
		'before_widget' => '<div id="%1$s" class="c-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="c-secTitle -widget">',
		'after_title'   => '</h2>',
	]);
	register_sidebar([
		'name'          => __( '記事下部', 'swell' ),
		'id'            => 'single_bottom',
		'description'   => __( '投稿ページのコンテンツ下部に表示されます。', 'swell' ),
		'before_widget' => '<div id="%1$s" class="c-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="c-secTitle -widget">',
		'after_title'   => '</h2>',
	]);
	register_sidebar([
		'name'          => __( 'CTAウィジェット', 'swell' ),
		'id'            => 'single_cta',
		'description'   => __( '投稿ページのコンテンツ下部に表示されるCTAウィジェット', 'swell' ),
		'before_widget' => '<div id="%1$s" class="c-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="c-secTitle -widget">',
		'after_title'   => '</h2>',
	]);
	register_sidebar([
		'name'          => __( '関連記事上', 'swell' ),
		'id'            => 'before_related',
		'description'   => __( '投稿ページの関連記事エリアの上に表示されるウィジェットエリア', 'swell' ),
		'before_widget' => '<div id="%1$s" class="c-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="l-articleBottom__title c-secTitle">',
		'after_title'   => '</h2>',
	]);
	register_sidebar([
		'name'          => __( '関連記事下', 'swell' ),
		'id'            => 'after_related',
		'description'   => __( '投稿ページの関連記事エリアの下に表示されるウィジェットエリア', 'swell' ),
		'before_widget' => '<div id="%1$s" class="c-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="l-articleBottom__title c-secTitle">',
		'after_title'   => '</h2>',
	]);
	register_sidebar([
		'name'          => __( 'フッター直前', 'swell' ),
		'id'            => 'before_footer',
		'description'   => __( 'フッター直前に挿入されるウィジェットエリア。', 'swell' ),
		'before_widget' => '<div id="%1$s" class="c-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="c-widget__title -footer">',
		'after_title'   => '</div>',
	]);
	register_sidebar([
		'name'          => __( 'フッター（ PC ）1', 'swell' ),
		'id'            => 'footer_box1',
		'before_widget' => '<div id="%1$s" class="c-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="c-widget__title -footer">',
		'after_title'   => '</div>',
	]);
	register_sidebar([
		'name'          => __( 'フッター（ PC ）2', 'swell' ),
		'id'            => 'footer_box2',
		'before_widget' => '<div id="%1$s" class="c-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="c-widget__title -footer">',
		'after_title'   => '</div>',
	]);
	register_sidebar([
		'name'          => __( 'フッター（ PC ）3', 'swell' ),
		'id'            => 'footer_box3',
		'before_widget' => '<div id="%1$s" class="c-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="c-widget__title -footer">',
		'after_title'   => '</div>',
	]);
	register_sidebar([
		'name'          => __( 'フッター（スマホ）', 'swell' ),
		'id'            => 'footer_sp',
		'description'   => __( 'スマホで優先的に表示するフッターウィジェット。このウィジェットが使用されている時、「フッター（ PC )１〜３」は非表示となります。', 'swell' ),
		'before_widget' => '<div id="%1$s" class="c-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="c-widget__title -footer">',
		'after_title'   => '</div>',
	]);
}
