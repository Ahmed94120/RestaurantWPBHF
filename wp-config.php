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
define( 'DB_NAME', 'RestaurantWPBHF' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         '1tgo{_,l&aSO*;7!IsIYR-QTs`S$.G. tEpbGs>oc<Yo9I,zxFLDqYQS>2}|i*%&' );
define( 'SECURE_AUTH_KEY',  '12s]`=;F4At77>/ 2~uN)ll9u;$pIha!aWXb<qu@P/0Fn]1a{)b7f|wlGgS+{D&,' );
define( 'LOGGED_IN_KEY',    '{xOL$q@^^EB$!jx4-rOP@cIVkhK@r^yX|,BQI2n;a6Po=X+w8-|M_YU.UG-u|-ar' );
define( 'NONCE_KEY',        '<R&x~TDCQYz]}{PraA$`5EMAoMtsox(C8a7Y!]JQ16xJMb,.?#JnpUWfw*0-//6<' );
define( 'AUTH_SALT',        '{WWg#8G=)SLpkxZGe{NGX/I)sst$pEVtzhT|WXD~$>_8C$nIOdQ!}R}/n iV}aZL' );
define( 'SECURE_AUTH_SALT', 'h>kNUap39,zYLmVvNU{GZ27d>A0sq07rpljr8>B6tGU@I9XO>xTBS*:IUD]12_U]' );
define( 'LOGGED_IN_SALT',   'Xad4PEE?^!)+Mn!:;b^w<#cZ4M<5-aRepgw eLp-2%M_W/VZd0AKc&B/KI`hc%~r' );
define( 'NONCE_SALT',       '*q(2YHuNbj*^?Tw PU6i&/=K+iXQ@U1TzD(l[`sE0O]c3hcLw,,q%;3PT(PPlX-h' );

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
