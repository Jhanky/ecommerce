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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

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
define( 'AUTH_KEY',         's?5I0@j4+~&U7ff~[>^p[aY!XMz+fZ8 ^!S[Wcn.alia:cwh]c8mNKUR83H4V1;J' );
define( 'SECURE_AUTH_KEY',  'pmWpG(I=2$IC$UrAK,vh5]2A*+TG?*VLwJ/J{+Fa0Hp7xCwmj:4,_En iXBZSB9B' );
define( 'LOGGED_IN_KEY',    ')B9klnu1&3h)&V3LC8S-?B|hT)4V1uPN$eh2iBA[tKOzNtjI-,/)#_>>Y&%g+2Fw' );
define( 'NONCE_KEY',        '+:V6jQ%,wnMB NG%Ap29a;wtd$+sa=4r}<gtg)JT(&_.^hze#+q98^:O60DoZIN!' );
define( 'AUTH_SALT',        ')Yslj)9#:Y+q9JB#?BeT^V#-6zX[TDO:F_h6Hqj<>P% pRiOIQf@Y4@T.u~P$~Xs' );
define( 'SECURE_AUTH_SALT', 'vR+@~ +mxDx]3;x1O)OO;(U2S,+e%2YRR#5Giq>{*oGzY.03Y1&h>m7wM8xCB+Uk' );
define( 'LOGGED_IN_SALT',   ' 6W:q96DX7jz(BBcq8;)dG| ZGfEM[2L7l`??%0eAuH)m_:W/H?eWrI<fd[aU*#_' );
define( 'NONCE_SALT',       '=hB_Ek1eQ*~z=N2w;<[W6.hz&/c7~]==0KhzS%oO;rv[|<a!weWZY)&aY5IwLL)t' );

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
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
