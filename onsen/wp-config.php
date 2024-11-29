<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
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
define( 'DB_NAME', 'inooto_wp6' );

/** Database username */
define( 'DB_USER', 'inooto_wp8' );

/** Database password */
define( 'DB_PASSWORD', 'pylyim3r16' );

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
define( 'AUTH_KEY',         '`Sx%VwR`;3/lw2;sAz~OM}VvP:URgPYvI0YD3_7u{fSN;bg]rDmoc?/iF^L,*}>:' );
define( 'SECURE_AUTH_KEY',  'WkYOA9Wp+%4;k[|bSgE8DS9&o+,XGR?EnM2rC$,Fr]*E=Dm_^g4d^_3{KZqTi3oS' );
define( 'LOGGED_IN_KEY',    'ym,]D`HqjS/R&:6y-yVA[LO!Hkt]t%7J.;%S{k47@}f7; T/Qpt^T~Vms-,~ql:W' );
define( 'NONCE_KEY',        'Rt&NHQwSfY+i,_^IH6jCs}k3$_`%+HT.*+}7CgNo;$y1k8,p4oayMiF;0`$K[dm.' );
define( 'AUTH_SALT',        '=d@X[x#S[666c4idYkq<$1Xq8~T9$PT s`NGdQ%Ct_Sfb|t Cd#;.0~^%&f/w.oB' );
define( 'SECURE_AUTH_SALT', 'l.!ag2t(30?<if8FP=})]?l}%yYP4OX6x1;js2>(l6XY{F`LK/(X~4PtEnGv2G$L' );
define( 'LOGGED_IN_SALT',   'X(v[!Zv9K/hHC&$>FR,*F(`&Ts*;aIwu[u[Uon-v1+RyLGk7o(5O9`Qr]z?$(0sp' );
define( 'NONCE_SALT',       'y?G*tt[[My-[yX=8X>z^o4 }E1X|22>4Kv1lQ[r_c[w9rA/ws}v[w;d!d1kJe^$a' );

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
