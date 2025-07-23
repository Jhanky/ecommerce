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
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wp578' );

/** Database username */
define( 'DB_USER', 'wp578' );

/** Database password */
define( 'DB_PASSWORD', '[3FmC6p2x.[6]6S)' );

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
define( 'AUTH_KEY',         '2ur79wc7olpuwdqxiihebpc3j6tvcoyfty0p1lk1m0vyrlceijvtxkiaj5vahtmz' );
define( 'SECURE_AUTH_KEY',  'o0w4z6jursmr9zty2yuys7qxfprz3bps5xnr2omo02rfgfox1men0qz5kr0dxgbd' );
define( 'LOGGED_IN_KEY',    '3mxhlffrb2dl22hoxjwapq1xlsfhonflvbwpzqd4liohwzkeby9exwm1igunjvdw' );
define( 'NONCE_KEY',        '5wcoj2zqmawcjsj9kdtje6pq09mgidsqmlvkdatykmymwpnhqqtvlkykxltz4pna' );
define( 'AUTH_SALT',        'hxfrkhiza8uegi5kbucqry7gg0mgvudedc4b6uh0mjwrqsyhzjj14z3t4brlqj2u' );
define( 'SECURE_AUTH_SALT', '9hvgonfhhembdh8jcnj1g8gkk25zuxuvdlntaie1tymtrklsgs173xdo0r240ebk' );
define( 'LOGGED_IN_SALT',   'yxkt5adfpsgbixozjp4uppcq1egzsg7zebmymzz4lsslebkvfsririppctqeraai' );
define( 'NONCE_SALT',       'iq6kazdcu4ttdhvpdsot1c8l9wrjaanxnhvwtivkzxx8y4mrgz5uprum5rhsd0vh' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp1f_';

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
