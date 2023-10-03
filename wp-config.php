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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', "RestaurantWPBHF" );

/** Database username */
define( 'DB_USER', "root" );

/** Database password */
define( 'DB_PASSWORD', "" );

/** Database hostname */
define( 'DB_HOST', "localhost" );

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


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}


define('AUTH_KEY',         'YqsEVDZSPN4iq66YuWHdtpc4W5HxbXAs6E7QeoDakPRiERnljEdSD6gsT094knwZtPShpsD1cTwO9iS8xZ1+NA==');
define('SECURE_AUTH_KEY',  'bCVQgry2YfAEbucKRVxdSjRbfdp2ayqT2AfKzGFKpxDe5kRH/fksp3Ejr0QDr7UGJJpButxvpwAX0f8eZzMYAQ==');
define('LOGGED_IN_KEY',    'fHB9hX8qc4b8WGOUGUZ6vQRm984qN2Qv/fUajUfU6rNns3ScUqP5kgldqbXOXxoxVqv/AuqCisdW829UW5bIeg==');
define('NONCE_KEY',        'rPSAXvaB7Ak5blT69PYhAG1ctI3QLbPfc/Fx8NjgHly2VoFgSKq01pHDjslKatQGiVgNIZS/U8a5PZcuWOwTqw==');
define('AUTH_SALT',        'jbE6thywqzUZpK9yayy8wX+3zxw58HtVWHt43DqPl1xGFc2fn9NVgf38MRmSQWsm0AGIN7LfDZPi2qKFoPSsmQ==');
define('SECURE_AUTH_SALT', 'aSHPtR9V7D086DPWJgSmycpLJsaZCTUMdwAjuAdKflK772qu+PhxbzrcRweFlfkeo3WI1N5fAHCUKXf10HSCWA==');
define('LOGGED_IN_SALT',   'rWsT+4ZUSsZNyl0AIMt+QzsKpojLMvuA6EJvpn6L+5PKiJyXuYAiL+98FxoTAOy/DrqK1uD0wXQw/riPeyAv+w==');
define('NONCE_SALT',       'LDtKQVU+w/7DTCj2ZnjJFt4Qa6DbDbhPyX5h6+oPhuLJVipSxmntDra/S6PnMwoghbnNMA90CCdH2qsdFW1XSg==');
define( 'WP_ENVIRONMENT_TYPE', 'local' );
define( 'WP_SITEURL', 'http://localhost/RestaurantWPBHF/' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname(__FILE__) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
