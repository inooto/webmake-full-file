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
define( 'DB_NAME', 'inooto_xl83w' );

/** Database username */
define( 'DB_USER', 'inooto_lx42c' );

/** Database password */
define( 'DB_PASSWORD', '68slaj7i9s' );

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
define( 'AUTH_KEY',         'e:w>tp:CJ(Ban@lBM`2HpK|g+FQVigerM2@WV7+48*.#?G8~]oX05% SelRv.Ga@' );
define( 'SECURE_AUTH_KEY',  'G;}jw;y.?Pp?1Qz73r1/S%ue^B]rR-HdoT>iq%g#Gm[!a#iP!zkk]ZFRj<&v)]]9' );
define( 'LOGGED_IN_KEY',    '>uCRtc<hUG-+o:.42)8E]Y(lO+uC0TjyyOl<.&wKOL&6Z{2HpMr:GU>`bYZ,lP$)' );
define( 'NONCE_KEY',        'DqA&%(^>YYQs5JVrX:R=ipcxr9flJ9$(;yXCGy bCv&AFDzlpA!I.${%nX;ij*;Y' );
define( 'AUTH_SALT',        '!|cViBc m# mh1eKo6|t01CU+0/FT:.=[7=CC@>&FAuyOBnjX#4EY[}k~xx9ks%;' );
define( 'SECURE_AUTH_SALT', 'CAp;pd..rR,Tb7z@1G9s.kCo#Zd @Ntan3,-rU7nCp8t_lkMb2Kg(O>~s>eESAd:' );
define( 'LOGGED_IN_SALT',   ')EObjl6)I ~v,p^^8t@+^ &O8gQ_Y>PvDJ.+spu8j(ynCE9#:#FA+3wLPs16o@VR' );
define( 'NONCE_SALT',       '[W2b%&;(ywOOcMi|zsjm]ud=0_y.r%q,zFX+x>H53huRaSx8]rTsI[[_nL6ApRp@' );

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
