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
define( 'DB_NAME', 'wp_ardevcc_db' );

/** Database username */
define( 'DB_USER', 'wp_ardevcc_user' );

/** Database password */
define( 'DB_PASSWORD', 'wp_ardevcc_pw' );

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
define( 'AUTH_KEY',          '[9!sY{3F4Q@o;Z(WMK]@`Y8A|d8CAs4A*2QTU0aTrGdhJjwF5|jscl#|Zzw|0_3[' );
define( 'SECURE_AUTH_KEY',   'V6UC}) *8bUF}J{8p0!c%BvLZDt`8zeZT-6QL lW7s(_2 mZc{prqQ*L){NkFuFU' );
define( 'LOGGED_IN_KEY',     'xX4VC.zd/X-+s?AIi #EEe,cHp EGuUIyeoWXVYe&9f@BMBcY8#pI79)V43SJy?{' );
define( 'NONCE_KEY',         'sl[tVtu$eEgaf;OzEcMEv7}[H vD{2KF#e/Iw;_ YNNf4b]^F9E]n1 1GCB=iUsy' );
define( 'AUTH_SALT',         'mi)*rpFW,JwlWUJFIZdP*9e2ggvW5-l^jKvI~KCy+MC{(qMSag?:)Y9RAc_OAc(I' );
define( 'SECURE_AUTH_SALT',  'keP#4MF#[E_hBpJ+{`%0G]k`gH[Jgf?@?y!{@xU:Y}.m/=:5p7F@k!bQweZwRSaR' );
define( 'LOGGED_IN_SALT',    '!=S<}FwipR4A3X~otyvDp2 r?(NWSomS;FfQ|Khf*V9uij78P$N}$#nupcXA$9f.' );
define( 'NONCE_SALT',        '?fFkVqa}P][8{pYVCv0r9O,z2eZZ[jp&D1f@y8$^xXF904k4CrvJVe#+R6ypug y' );
define( 'WP_CACHE_KEY_SALT', '-Th6OJh+^2a+KfUpBIZkF#I>?2)FY=k~KbZYtm2=7Ez$Ygy.iKk1=A8a*YT0k|sE' );


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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
