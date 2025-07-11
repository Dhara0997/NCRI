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
define( 'DB_NAME', 'ncri' );

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
define( 'ALLOW_UNFILTERED_UPLOADS', true );

// ini_set('memory_limit','512M');

define('WP_MEMORY_LIMIT', '256M');
define('WP_MAX_MEMORY_LIMIT', '512M');


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
define( 'AUTH_KEY',         '@.rOc*k`~*erVeq.NP76crw8Qaz/F/B}m^!>)?f?k3 >sDRdz#j<7LHL3IpxYU l' );
define( 'SECURE_AUTH_KEY',  '26]MU*ex7Tg_MCTu|}r@>*65Z-wW%#Ws*ij~y6^Ajs0h<QVG1$yo4k9Fndjfh#U<' );
define( 'LOGGED_IN_KEY',    ':EhSk!j,Kp!W|q17M%=MU*uw;Fx7>/$+#T^t,0h47`Y$y{G1<>ITH<<2`|RYJ.k-' );
define( 'NONCE_KEY',        '6:E`O6n/_p=rn!4ZS.[[}LlNDBeOb%@%W!GZHMzrX}jzMnA!%AvC0{=,n=OB3B}3' );
define( 'AUTH_SALT',        '^=vCu^1=8=]F@Bu&6&<B0w^.qH=G9,z3$OhWKq7lF>V>Ga_|qsy8(qPy@7rX;((W' );
define( 'SECURE_AUTH_SALT', 'ZNti1jC%Oq~S-^UkyNIZ*(vAIunICQTrwz[7+p1eMOKpCNOs2]m*Nil)xUgjoo_h' );
define( 'LOGGED_IN_SALT',   'h6:L)HyuT&W7^q[=&P<eYk`5.zNZmd{v0Ux?jmWVCkgrX?ZqN#r$`bHobV>P,)N$' );
define( 'NONCE_SALT',       '?m$A4/jd-b43}E:fL+O:otP;jM@`+$;rFm)3P=9o~y1NAC:T&C;x/WGekc+Pe]oX' );

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


define( 'FS_METHOD', 'direct' );
define('AUTOMATIC_UPDATER_DISABLED', true);
define('WP_AUTO_UPDATE_CORE', false);

// define('WP_HOME', 'http://localhost/modernlifafa_elementor/');
// define('WP_SITEURL', 'http://localhost/modernlifafa_elementor/');



/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
