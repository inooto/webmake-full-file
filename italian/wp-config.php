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
define( 'DB_NAME', 'inooto_wp4' );

/** Database username */
define( 'DB_USER', 'inooto_wp4' );

/** Database password */
define( 'DB_PASSWORD', '6jab26zo4j' );

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
define( 'AUTH_KEY',         '{0)?-eu1^P_h?:aaCyuKP]3tE*JA)>TluaUiJ/TU-50eX9yq%eqN2`TSy*S%@398' );
define( 'SECURE_AUTH_KEY',  'sIN267;d<?(Y)Ty_,Ku4gst?-`r5_v<*h`5)E%luXWkp 6Js;74R:5:[,`3!SIO>' );
define( 'LOGGED_IN_KEY',    '79aq j=O6ul{WZgw:h+sI@tkm7P!,h!`L|Sx}LK7bD[7RV9}Y}~yf1 &tddE,}Lf' );
define( 'NONCE_KEY',        'QE8WfUm3=;`V?iJqKW|Yd7g1w`61s.rus2aEG!; 4r@i|{6)P14`FJZXC~X6-clz' );
define( 'AUTH_SALT',        '-PV ;Y<SvB(rbx/69A#q^8Y=Y-1wUYwAKcAm_NUspm1DT.Au6v/6tsq7`mp[KP9K' );
define( 'SECURE_AUTH_SALT', 'v/EbgjsQ}io6;ni&~`b1|pZCrI$ 1o4/7zV1]{G&s75Z0 ~+CYE| )9fgc@;_1K9' );
define( 'LOGGED_IN_SALT',   '[<[[hV3EOKS7gh6ge-?D&PU{x>C240rq[_!HpKupr)H~kH[g.MACKV/ccRZ GFLb' );
define( 'NONCE_SALT',       ']cW^K&=/861!2[qGfJ^7!w#r^*@<vhXgEe@Dr+M$h&kN1z(gQ2J7pgK,K@D!<]H)' );

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
