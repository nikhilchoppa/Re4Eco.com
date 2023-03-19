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
define( 'DB_NAME', 'i6070597_wp1' );

/** MySQL database username */
define( 'DB_USER', 'i6070597_wp1' );

/** MySQL database password */
define( 'DB_PASSWORD', 'N.1u0md1bnhcfLG3YrS73' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define('AUTH_KEY',         'h1g6camOWtTJllJcpTEtiqqrWGG03E3fGANphyplSApOKqf5khsZrQfulVXgGAVL');
define('SECURE_AUTH_KEY',  'jOZwFe1cosSUq1WfU3LBqBWrX23CqeyVgmP3logxh4S8mwkkPuO8y1cBcVt5QGSQ');
define('LOGGED_IN_KEY',    '3vtRtPmn4Frbb0qMR4nlCcKlACrR0odq5aO0E56s29ZahtouLg4NckOJ61qXYrfH');
define('NONCE_KEY',        'oggREa67sjsZdhYRiUZAPU60pKXdPD6PlXjRBbeV8fLSBJbXI3UFWNw5gPe1Y1Jg');
define('AUTH_SALT',        'ocmEoqQBWQNKZYOnML1hc4grjmCVHoBSfo18jFPj4NE0oqiTt2kYZszj7BM9DGhp');
define('SECURE_AUTH_SALT', 'DzItudAFJMvleYZeEq4AciggoyOFvZDXUVOaUZFWUTvHiqFVJ2ImByjbfgVhvPgP');
define('LOGGED_IN_SALT',   'q8gMk4KFuEVSgPz1BO6NCy2RKKEyqYOR04rRno9lXClGFFG3stRKRtGi9wnj7vEe');
define('NONCE_SALT',       '4X6P6qH98CAQ5yTUwk0Y29rtWs0Z3bN2vvJtOyEd2e1Vu56mZ65G9HKL5crOPUzI');

/**
 * Other customizations.
 */
define('FS_METHOD','direct');
define('FS_CHMOD_DIR',0755);
define('FS_CHMOD_FILE',0644);
define('WP_TEMP_DIR',dirname(__FILE__).'/wp-content/uploads');

/**
 * Turn off automatic updates since these are managed externally by Installatron.
 * If you remove this define() to re-enable WordPress's automatic background updating
 * then it's advised to disable auto-updating in Installatron.
 */
define('AUTOMATIC_UPDATER_DISABLED', true);


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
define( 'WP_DEBUG', true );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );

/** define( 'WP_MAX_MEMORY_LIMIT', '256M' ); */
