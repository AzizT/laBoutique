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
define( 'DB_NAME', 'jadeboutique' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'roE;y9n}}Z61SDxa4-fvQVUiD@/%TTHQ!po+Mc]%_?idz>Zl:7R^8qq,0Z2J2wa`' );
define( 'SECURE_AUTH_KEY',  '7C*I|Md3aXnAGo3l_*mpJ+Rov=}1P&4tZ(3h.0>GPAb,jIOqxiku#^:U0Cn+8+QB' );
define( 'LOGGED_IN_KEY',    'U^+,[H4>R6+@)vl,1s9Ug<HQ _!e}#-q)UfOX$wOq2Ft@RBDeT<.9>cS3I$s^pxA' );
define( 'NONCE_KEY',        'g4N<&X&=0wy8Yk$:X/](CbrAJD|`iRlpqrbYBcf:P5@GK/8:q3|=FTX]3;`BaA<O' );
define( 'AUTH_SALT',        'Z9:R@%b(+T6fD@Y~J^-huk$(WH6fUf2&xSVn.P40v.nFsRu.n5KTpVUImRH/q:Td' );
define( 'SECURE_AUTH_SALT', '^8J=#oTA|+O2.a_X.+goWF:y*WS:TLoK9XxPI||p&ommt0cwQullfQV0eXx}IF2H' );
define( 'LOGGED_IN_SALT',   's]8A`t|Bv[}_}9g%9M!#Dzp7)8HC/]ASf&8fm8{=z;|bB8?,O0 q[^2@$x:2@d&[' );
define( 'NONCE_SALT',       'ke|<yqFYrWgwzh/_}gH-Dm4KC&/|-#FTkM4)[1+n>DK8}DQc8p2/tE_K b[TbjIO' );

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
