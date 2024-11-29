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
define( 'DB_NAME', 'inooto_wp5' );

/** Database username */
define( 'DB_USER', 'inooto_wp7' );

/** Database password */
define( 'DB_PASSWORD', 'bsvqweecsn' );

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
define( 'AUTH_KEY',         '~m=iO)sT$hnXqH}3rw )RL6sGppV,kwp@Lc#f= Dt!?dZ${UFwhML)qcUIlDD)x~' );
define( 'SECURE_AUTH_KEY',  'Hq9(+]=%+a^rYb)_ZrM;8GKIjK?%Kc3zhu4zu8>A(8imgM-M]40utk9c`W,6HL]p' );
define( 'LOGGED_IN_KEY',    'QoHEVuN5hPIZjCrwj `cML{bCkk&[HTE+K9JVwn^.rq%A6B<}aX)y;qA?*:K{G=q' );
define( 'NONCE_KEY',        'RYnHk2k59L?G!#?:kSM,+&O6cv-#^lis4&cgT&b]vxK=&`YVa@JyzK#t61kh)Pu2' );
define( 'AUTH_SALT',        'u#szbAd<;sV$$DG*@;|8d.2o6q[+D!|R)h,.g7D`*OVbgAd7>&*bRB#u/YJ)^>t+' );
define( 'SECURE_AUTH_SALT', ':nXJ^QKv)kVRpaS<#0!m,*,b_Q!q3nOTAfQoI y,VR:R~t#STC]a)]WCIf9ibp{=' );
define( 'LOGGED_IN_SALT',   'M^vwsz@{#Siu1RZV#iu~@QvZv06l~e^s4g>[<e$y1nRr&);>6(5toz,F4yfyuL!f' );
define( 'NONCE_SALT',       ' t Yu(x7RC$-TBVHpE Dx(usxdKG_drU`EUh7E#W5L)^TFo$MD(qWt*F%j;0MyWM' );

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
