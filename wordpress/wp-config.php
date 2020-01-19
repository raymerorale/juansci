<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wp-db' );

/** MySQL database username */
define( 'DB_USER', 'raymer' );

/** MySQL database password */
define( 'DB_PASSWORD', '786214593' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '>^@r+xMn!/<O6sYO>D}OIufHk/Ob&UmUj|`g?/!^.@elz*T:hV:S7]0+{#DF8_4m' );
define( 'SECURE_AUTH_KEY',  'WzZ[yCR1E:&S/uYG%Rz70szN()mv3fuMS<+!5/!p3QrKhL/{<Rz]G}gdQ{L1-5_G' );
define( 'LOGGED_IN_KEY',    'slFL-H&(4J5>H>w42 X~Ct`A5Z0}> 7oNnm^R|s&PX;0Al]Zyt.=XQY%SY7^&1xb' );
define( 'NONCE_KEY',        'j~Djn{z8H93-foRM_6xkcP@z(fXs]F,x_jl5]558H[(UZ=SIptkdy)w|Obd{-p=F' );
define( 'AUTH_SALT',        'w_ku%6+RBe8/K`8%z~p$MTTKVzD)M~bFkToS},6E=-}d#c-9NiU=L]mxc@oH1JXF' );
define( 'SECURE_AUTH_SALT', 'i(i<cDmhrc/b5`zJxb2n~~nIxOxbKQEZ:N6mLO?_+33J )TqD+QB5j+be@5SZ[uk' );
define( 'LOGGED_IN_SALT',   'Wl.{^&qI~p-XL#QzetB~*qT-bP3Y/+CBkWH}0~,+tme8?#i5U5zUUCIf_Nshha>`' );
define( 'NONCE_SALT',       '1w(b#8JBd|e5qX^xYU?rcXWX,>bxxPAmWf|MyMj|*Bg3_)R&H/6[cP^zQt.Jf1gW' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
