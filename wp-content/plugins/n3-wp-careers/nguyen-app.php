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
 * @package           MADE_WP_CAREERS
 *
 * @wordpress-plugin
 * Plugin Name:       @Restore Construction Careers
 * Description:       @Restore Construction Careers is a simple WordPress plugin that allows you to create a Careers page for your website.
 * Version:           2.5.1
 * Author:            Restore Construction  
 * Author URI:        https://restoreconstruction.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       n3-wp-careers
 * Domain Path:       /languages
 */


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'MADE_WP_CAREERS_NICENAME', 'Restore Construction Careers' );
define( 'MADE_WP_CAREERS_PREFIX', 'n3_wp_careers' );
define( 'MADE_WP_CAREERS_VERSION', '2.5.1' );
define( 'GENERALPUBLIC_WP_CAREERS_CORE_URL', plugin_dir_url( __FILE__ ) ); // Return https://...
define( 'GENERALPUBLIC_WP_CAREERS_CORE_PATH', plugin_dir_path( __FILE__ ) ); // Return /path/to/...

require plugin_dir_path( __FILE__ ) . 'acf.php';
// require plugin_dir_path( __FILE__ ) . 'metabox.php';
require plugin_dir_path( __FILE__ ) . 'classes/setup.php';

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-bn-wp-activator.php
 */
function activate_n3_wp_careers() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bn-wp-activator.php';
	new MADE_WP_CAREERS_Activator();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-bn-wp-deactivator.php
 */
function deactivate_n3_wp_careers() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bn-wp-deactivator.php';
	new MADE_WP_CAREERS_Deactivator();
}

register_activation_hook( __FILE__, 'activate_n3_wp_careers' );
register_deactivation_hook( __FILE__, 'deactivate_n3_wp_careers' );

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
function run_n3_wp_careers() {

	$plugin = new MADE_WP_CAREERS();
	$plugin->run();

}
run_n3_wp_careers();
