<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$placeholder = apply_filters( 'swell_searchform_placeholder', __( '検索', 'swell' ) );
?>
<form role="search" method="get" class="c-searchForm" action="<?=esc_url( home_url( '/' ) )?>" role="search">
	<input type="text" value="" name="s" class="c-searchForm__s s" placeholder="<?=esc_attr( $placeholder )?>" aria-label="<?=esc_attr__( '検索ワード', 'swell' )?>">
	<button type="submit" class="c-searchForm__submit icon-search hov-opacity u-bg-main" value="search" aria-label="<?=esc_attr__( '検索を実行する', 'swell' )?>"></button>
</form>
