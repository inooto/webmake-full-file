<?php
if ( ! defined( 'ABSPATH' ) ) exit;

spl_autoload_register(
	function( $classname ) {

		//  v3用: 名前に SWELL_Theme がなければオートロードしない。
		if ( strpos( $classname, 'SWELL_Theme' ) !== false ) {
			$classname = str_replace( '\\', '/', $classname );
			$classname = str_replace( 'SWELL_Theme/', '', $classname );
			$file      = T_DIRE . '/classes/' . $classname . '.php';

			if ( file_exists( $file ) ) require $file;
		} else {

			// SWELL_もLOOS_もなければオートロードしない。
			if ( strpos( $classname, 'SWELL_' ) === false && strpos( $classname, 'LOOS_' ) === false) return;

			$classname = str_replace( '\\', '/', $classname );
			$file      = T_DIRE . '/classes/' . $classname . '.php';

			if ( file_exists( $file ) ) require $file;
		}

	}
);
