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
define( 'DB_NAME', 'inooto_wp7' );

/** Database username */
define( 'DB_USER', 'inooto_wp9' );

/** Database password */
define( 'DB_PASSWORD', 'zy7w37arfa' );

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
define( 'AUTH_KEY',         '/Q={ZJ|aQA2EsEUz z{P34),1J3}?+Oe}u)*omRp:>t7~,%|1i{fqvXf7)]Z}.I.' );
define( 'SECURE_AUTH_KEY',  ';_WWaWQ?E7RYo6]u49=5Ds[aL~4S0BksMcK4TVICS9ggL^2V9`pJO4II[t6AN@B;' );
define( 'LOGGED_IN_KEY',    'r=.}5W8]h!4P+S_WDo]D),KDi*sMMk}^37MdRh,f)<#p-+~zWuo7[VOerO8 ty*H' );
define( 'NONCE_KEY',        'm2I.4W6-R/:MxGbQ=Cs6_G>MJQl#4%fDA7M2|9|s&8(+U2?WB5c|Z>vO(>G9^ira' );
define( 'AUTH_SALT',        '<34j bCs*!, 93#c3].3&~aq~}D>-m}v|ddU>>t.<I:aOC/)q*V34+vwM}K|_|c/' );
define( 'SECURE_AUTH_SALT', 'c.9D.B-uEM7)li$q!@.r<HYM(~Hb3t>h`+O`KB3%3W@<yVPGQ^:{o;&p50)9ls6 ' );
define( 'LOGGED_IN_SALT',   'uGDxsS90(?XY%j3 @gu)fzE5sLN5T&956dtR;N)mpU$|_RAU3Vi2VE|;`W4WHyRH' );
define( 'NONCE_SALT',       'ou&a^I_uD!U]~8w.DSW5Y^/~8MvOM#ccqYc1_Q._G IJPj:R:De<[uJ`2)H81@4z' );

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
