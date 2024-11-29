<?php
if ( ! defined( 'ABSPATH' ) ) exit;

\SWELL_Theme::outuput_widgets( 'before_footer', [
	'before' => '<div class="l-container">',
	'after'  => '</div>',
	'active' => true,
] );
