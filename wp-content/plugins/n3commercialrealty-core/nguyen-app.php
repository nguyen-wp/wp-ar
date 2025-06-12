<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://nguyenpham.pro/
 * @since             1.0.0
 * @package           N3COMMERCIALREALTY_CORE
 *
 * @wordpress-plugin
 * Plugin Name:       @Restore Construction System
 * Description:       @Restore Construction System is a collection of useful functions and classes for your website.
 * Version:           4.0.1
 * Author:            Restore Construction
 * Author URI:        https://restoreconstruction.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       madelab-core
 * Domain Path:       /languages
 */


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'N3COMMERCIALREALTY_CORE_NICENAME', 'N3C Realty' );
define( 'N3COMMERCIALREALTY_CORE_PREFIX', 'general_public' );
define( 'N3COMMERCIALREALTY_CORE_VERSION', '4.0.1' );
define( 'N3COMMERCIALREALTY_CORE_URL', plugin_dir_url( __FILE__ ) ); // Return https://...
define( 'N3COMMERCIALREALTY_CORE_PATH', plugin_dir_path( __FILE__ ) ); // Return /path/to/...

require plugin_dir_path( __FILE__ ) . 'build-data.php';

require plugin_dir_path( __FILE__ ) . 'framework.php';
require plugin_dir_path( __FILE__ ) . 'theme-config/scripts.php';
require plugin_dir_path( __FILE__ ) . 'theme-config/styles.php';
require plugin_dir_path( __FILE__ ) . 'template-functions.php';

// require plugin_dir_path( __FILE__ ) . 'classes/class-tgm-plugin-activation.php';
require plugin_dir_path( __FILE__ ) . 'classes/made_core_init.php';
require plugin_dir_path( __FILE__ ) . 'plugins.php';

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-bn-wp-activator.php
 */
function activate_general_public_core() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bn-wp-activator.php';
	new N3COMMERCIALREALTY_CORE_Activator();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-bn-wp-deactivator.php
 */
function deactivate_general_public_core() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bn-wp-deactivator.php';
	new N3COMMERCIALREALTY_CORE_Deactivator();
}

register_activation_hook( __FILE__, 'activate_general_public_core' );
register_deactivation_hook( __FILE__, 'deactivate_general_public_core' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-bn-wp.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_general_public_core() {

	$plugin = new N3COMMERCIALREALTY_CORE();
	$plugin->run();

}
run_general_public_core();
