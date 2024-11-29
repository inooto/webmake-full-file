<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * SNSなどのアイコンリストを出力するパーツテンプレート。
 */

// 引数から受け取る情報
$list_data = isset( $variable['list_data'] ) ? $variable['list_data'] : [];
$ul_class  = isset( $variable['ul_class'] ) ? $variable['ul_class'] : '';
$fz_class  = isset( $variable['fz_class'] ) ? $variable['fz_class'] : 'u-fz-14';
$hov_class = isset( $variable['hov_class'] ) ? $variable['hov_class'] : 'hov-flash';

$util_class = $fz_class . ' ' . $hov_class;
?>
<ul class="<?=esc_attr( trim( 'c-iconList ' . $ul_class ) )?>">
	<?php
		foreach ( $list_data as $key => $href ) :
		if ( empty( $href ) ) continue;
		if ( $key === 'home' || $key === 'home2' ) $key = 'link';
		if ( $key !== 'search' ) :
			?>
					<li class="c-iconList__item -<?=esc_attr( $key )?>">
						<a href="<?=esc_url( $href )?>" target="_blank" rel="noopener" class="c-iconList__link <?=esc_attr( $util_class )?>" aria-label="<?=esc_attr( $key )?>">
							<i class="c-iconList__icon icon-<?=esc_attr( $key )?>" role="presentation"></i>
						</a>
					</li>
				<?php
			else :
				?>
					<li class="c-iconList__item -search">
						<button class="c-iconList__link c-plainBtn <?=esc_attr( $util_class )?>" data-onclick="toggleSearch" aria-label="<?=esc_attr__( '検索', 'swell' )?>">
							<i class="c-iconList__icon icon-search" role="presentation"></i>
						</button>
					</li>
				<?php
			endif;
		endforeach;
	?>
</ul>
