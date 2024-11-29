<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'inooto_tfq73' );

/** Database username */
define( 'DB_USER', 'inooto_9c3hs' );

/** Database password */
define( 'DB_PASSWORD', 'f0cfjbsqa4' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'UFi!&&d[7cyGWi7~|-ta3S):h{{tQj9nnFcD18T-WEkfM4eKW=GD.K.sC4g pw=|' );
define( 'SECURE_AUTH_KEY',  'tj_F8poRYNq3)-[R2K?mv(x!8:V73BHq6!M|rEwt>(%o`#xorS/@kRh]e5w`GhXZ' );
define( 'LOGGED_IN_KEY',    'q&e!zObXP.0M^9?Ibc%4O%?_%Fdw>F1sKNMA0&EVbx-LC>bB<_&Mw`,7u=fjl,Fc' );
define( 'NONCE_KEY',        '%c2xTv+F}Sf/2EH$gR<=^|HQ2L5.GpE^VZc9At?&*F#[E*KPCH+eG}E>V2VFu}W;' );
define( 'AUTH_SALT',        'Jy,~^RuO(`mOvoV8VN1&<rs{?){}qSI{_@DhCJTSW.t&%(V,d=_jV+cL^ObJ1B X' );
define( 'SECURE_AUTH_SALT', '!w?9u6/V<}{sF@N}E]K5WjNGfkER v6j`CxsL|{rfYchPseb0~.!V6P^,g,G)A#s' );
define( 'LOGGED_IN_SALT',   'd@7Ic3{Vivq[_QE;8jAUL,`Q>iabWM:8uWR/dVc&/j6B3piBm60]Y`1iPx$KuJpo' );
define( 'NONCE_SALT',       'V-b `@/EzBet;Eay9z{86@(]*;+.bK?;@AtEC8{u6(CZ`&[$etwI;LpW2P3t;Q Z' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
