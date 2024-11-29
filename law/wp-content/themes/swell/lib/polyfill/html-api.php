<?php


// WP_HTML_Tag_Processor を6.2未満でも使えるように
if ( ! class_exists( 'WP_HTML_Tag_Processor' ) ) {
	require_once __DIR__ . '/html-api/class-wp-html-attribute-token.php';
	require_once __DIR__ . '/html-api/class-wp-html-span.php';
	require_once __DIR__ . '/html-api/class-wp-html-tag-processor.php';
	require_once __DIR__ . '/html-api/class-wp-html-text-replacement.php';
}
