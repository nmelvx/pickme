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
define('DB_NAME', 'pickme');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'uwYlGHQiw%JM92 G`-9kkNx-`e4d:_DXRQ-Mw4$Jly_EdV*]C%Ss~CBL#KJHSb]u');
define('SECURE_AUTH_KEY',  'Xx*Jp{4Y2gN}5w^mef~/%:MbthqTU2QZ.8?zFR3|hR@fq!aWN_oskubEw.M52ZJ-');
define('LOGGED_IN_KEY',    'GD#[ZH=O(vaNBUEBuz}5H9:R8*~l&{I lM$r:eEV#;rnH^&|/ar0J3OVg]lE9O[ ');
define('NONCE_KEY',        '=Q.~+K/|HO?7n#0TZ%^;[x[S0*jid1GIZtVJ1Ra9Fig[w1h]zS`2gs&mR.h>C`y6');
define('AUTH_SALT',        'NJP|{Y=#|wd+P8tHNre#]1I;.3d5p^_asZe}dlMv~Rw|a~_>A)Jz[;/p4IN`?JSb');
define('SECURE_AUTH_SALT', '}10mNi;a&H?<T,X-`r^64;t!DTGp-T0uZ*/K{SG@))7Xa(W@yCY%;l#Zu:<`4]$W');
define('LOGGED_IN_SALT',   'iD$dtqX1-tLeZ8i5-TT5A#XydZik/`!#BQS/qDmaZ1g2hGtUP6dmq=YpxJ0Vk!f0');
define('NONCE_SALT',       'j_6X%rNliRVF#=e2{ru<].k ~ndZ=](qf-w8Wgm`+*1C]<oPB:%*M1a[/DH<]}@b');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'pma_';

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
