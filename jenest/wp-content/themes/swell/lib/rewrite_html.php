<?php
/**
 * JS遅延読み込み
 *
 * @package swell
 */
namespace SWELL_Theme\Rewrite_Html;

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! is_admin() ) {
	add_action( 'wp', function() {
		if ( \SWELL_Theme::is_use( 'delay_js' ) ) {
			add_action( 'wp_print_footer_scripts', __NAMESPACE__ . '\scripts_inject' );
			ob_start( __NAMESPACE__ . '\rewrite_lazyload_scripts' );
		}
	} );
}

function is_keyword_included( $content, $keywords ) {
	foreach ( $keywords as $keyword ) {
		if ( ! $keyword ) continue;
		if ( strpos( $content, $keyword ) !== false ) {
			return true;
		}
	}
	return false;
}

function rewrite_lazyload_scripts( $html ) {
	try {
		// Process only GET requests
		if ( ! isset( $_SERVER['REQUEST_METHOD'] ) || $_SERVER['REQUEST_METHOD'] !== 'GET' ) return false;

		$html = trim( $html );

		// Detect non-HTML
		if ( ! isset( $html ) || $html === '' || strcasecmp( substr( $html, 0, 5 ), '<?xml' ) === 0 || $html[0] !== '<' ) {
			return false;
		}

		// error_log( PHP_EOL . '---' . PHP_EOL, 3, ABSPATH . 'my.log' );

		// Exclude on pages
		$prevent_pages = \SWELL_Theme::str_to_array( \SWELL_Theme::get_option( 'delay_js_prevent_pages' ) );
		$prevent_pages = apply_filters( 'swell_delay_js_prevent_pages', $prevent_pages );
		$current_url   = isset( $_SERVER['REQUEST_URI'] ) ? home_url( $_SERVER['REQUEST_URI'] ) : '';
		if ( is_keyword_included( $current_url, $prevent_pages ) ) {
			return false;
		}

		$new_html = preg_replace_callback(
			'/<script([^>]*?)?>(.*?)?<\/script>/ims',
			__NAMESPACE__ . '\replace_scripts',
			$html
		);

		// error_log( PHP_EOL, 3, ABSPATH . 'my.log' );

		return $new_html;

	} catch ( Exception $e ) {
		return $html;
	}
}

function replace_scripts( $matches ) {

	$script = $matches[0];
	$attrs  = $matches[1];
	$code   = trim( $matches[2] );

	// 遅延読み込み対象のキーワード
	$delay_js_list = \SWELL_Theme::str_to_array( \SWELL_Theme::get_option( 'delay_js_list' ) );
	$delay_js_list = apply_filters( 'swell_delay_js_list', $delay_js_list );

	// JSON-LDは強制的に対象から外す
	if ( str_contains( $attrs, 'application/ld+json' ) ) {
		return $script;
	}

	if ( $code ) {
		// error_log( $code, 3, ABSPATH . 'my.log' );
		if ( is_keyword_included( $code, $delay_js_list ) ) {
			// phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_encode
			$attrs .= ' data-swldelayedjs="data:text/javascript;base64,' . base64_encode( $code ) . '"';
			$script = '<script ' . $attrs . '></script>';
		}
	} elseif ( ! empty( $attrs ) ) {

		// error_log( $attrs . PHP_EOL, 3, ABSPATH . 'my.log' );
		preg_match( '/\ssrc=[\'"](.*?)[\'"]/', $attrs, $matched_src );
		$src = ( $matched_src ) ? $matched_src[1] : '';
		// error_log( $src . PHP_EOL, 3, ABSPATH . 'my.log' );

		if ( $src ) {
			if ( is_keyword_included( $src, $delay_js_list ) ) {
				// src を data-srcへ
				$new_attrs = str_replace( ' src=', ' data-swldelayedjs=', $attrs );

				// attrs入れ替え
				$script = str_replace( $attrs, $new_attrs, $script );
			}
		}
	}

	// log
	// error_log( $script, 3, ABSPATH . 'my.log' );

	return $script;
}

function scripts_inject() {
	$timeout = \SWELL_Theme::get_option( 'delay_js_time' ) ?: 0;
	?>
<script type="text/javascript" id="swell-lazyloadscripts">
(function () {
	const timeout = <?php echo esc_attr( intval( $timeout ) * 1000 ); ?>;
	const loadTimer = timeout ? setTimeout(loadJs,timeout) : null;
	const userEvents = ["mouseover","keydown","wheel","touchmove touchend","touchstart touchend"];
	userEvents.forEach(function(e){
		window.addEventListener(e,eTrigger,{passive:!0})
	});
	function eTrigger(){
		loadJs();
		if(null !== loadTimer) clearTimeout(loadTimer);
		userEvents.forEach(function(e){
			window.removeEventListener(e,eTrigger,{passive:!0});
		});
	}
	function loadJs(){
		document.querySelectorAll("script[data-swldelayedjs]").forEach(function(el){
			el.setAttribute("src",el.getAttribute("data-swldelayedjs"));
		});
	}
})();
</script>
	<?php
}
