<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'anvelocom3');

/** MySQL database username */
define('DB_USER', 'anvelocom3');

/** MySQL database password */
define('DB_PASSWORD', 'almafa');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'A>(=QKvK^;HL8 TP#RiW^):n*1UE@)wF=+9A|n_T*4gtWtGHx=6fX;`P%>|d%t{Z');
define('SECURE_AUTH_KEY',  'xF5LWb@ KL]*^<iG:%;~Td|q~?&4|qCI6qR&Vvzsn@krL83W}*4;:Yaz< j.Em^L');
define('LOGGED_IN_KEY',    '9o*bPPO6gP0^|)q,b+p?D%8%j`U<OQShW+$9!o5W~LE96B?Ad10y=I$L{/*{q 3T');
define('NONCE_KEY',        'H;$P?-#ii.p]!02j5d*OOhfi ?2hk(><I]Va3FeeI-i9j`]lEU-=bSN;i8u5n_RL');
define('AUTH_SALT',        'U$+|a[JzBEvVd90hG>:]UZS>+xIiIMU$/m0N`8~@_gojk_Mtp1A-,c?J`:L}0fed');
define('SECURE_AUTH_SALT', 'IA{Vm8Af{H-? i^e;%N0;r)[@XMZqs(|~D],~p`.|eskngY.Ze3xr$erKool&h^ ');
define('LOGGED_IN_SALT',   'NbZJmRczg0~w5H=k8hR|u-2k$<6&sQQ0s>jCNl-9,pY5G<}ueU0=i&]?#u_kmb!]');
define('NONCE_SALT',       'h/Xgh1)P)?%#|ax!x*a)hs1#Ju`78H>2l={>Fo+F|p{)dwx~G91-Lod<2ew|B$!o');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
