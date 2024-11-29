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
define( 'DB_NAME', 'inooto_jdav9' );

/** Database username */
define( 'DB_USER', 'inooto_p3p7w' );

/** Database password */
define( 'DB_PASSWORD', 'c5oathjrc8' );

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
define( 'AUTH_KEY',         '/iCh{4A]z MRjkbXh.1NR([h<oWl(!3wRXMVL`LrZ7n1N/;jV3S;bK+Xb(g&OUJ2' );
define( 'SECURE_AUTH_KEY',  '.jLEDEQmH}K3XHy-UvA|OB|q$,IW//|8H{-ASQ;dC#S22AcY:Q[TWqxz.x~L.gZQ' );
define( 'LOGGED_IN_KEY',    '0%4l92]^) i**[bDhKm%c]#v4{cm /1zFnpS5wG^:~Qnt#Rd<s8G1>x0@~/A|lGb' );
define( 'NONCE_KEY',        '0AoU+9%3Q(R5;Y0=BIj&Xf|);UL]K1xO17T8-3Tenw)>Ogahsc,Ad@A|;,|aed_m' );
define( 'AUTH_SALT',        ':!e4=T%fz#ac6F7Ushzg[`r[Xfkx~DCY%||&8<ahR{Sq@gjf0kWS/XqsY2WbwLmN' );
define( 'SECURE_AUTH_SALT', '3f#I[{Sj]K>49+l1Q63hEI{]b}m!85`.+*LyPW~9 {|e<^~V3~_uMOFcQ+SkXG~f' );
define( 'LOGGED_IN_SALT',   '(^C%KJ@,_M1NM|::T`L1KWRwwlW*Sv%a#cnpXGrqy.+%n]-x7,ieEL6Pk(w-)cCu' );
define( 'NONCE_SALT',       'addI$TNCG[4A/^xya+KF~EW=[`2!5qGL3{H($7(eR_4k9jF}We}u%$dkn=!T{E{d' );

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
