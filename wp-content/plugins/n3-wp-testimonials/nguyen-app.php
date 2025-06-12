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
 * @package           MADE_WP_TESTIMONIAL
 *
 * @wordpress-plugin
 * Plugin Name:       @Restore Construction Testimonials
 * Description:       @Restore Construction Testimonials will help you to create testimonials for your website. You can create testimonials for your team, your clients, your partners, etc.
 * Version:           2.3.0
 * Author:            Restore Construction
 * Author URI:        https://n3commercialrealty.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       n3-wp-testimonials
 * Domain Path:       /languages
 */


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'MADE_WP_TESTIMONIAL_NICENAME', 'GENERALPUBLIC - N3 Testimonials' );
define( 'MADE_WP_TESTIMONIAL_PREFIX', 'made_wp_testimonials' );
define( 'MADE_WP_TESTIMONIAL_VERSION', '2.3.0' );
define( 'GENERALPUBLIC_WP_TESTIMONIAL_CORE_URL', plugin_dir_url( __FILE__ ) ); // Return https://...
define( 'GENERALPUBLIC_WP_TESTIMONIAL_CORE_PATH', plugin_dir_path( __FILE__ ) ); // Return /path/to/...

require plugin_dir_path( __FILE__ ) . 'acf.php';
require plugin_dir_path( __FILE__ ) . 'classes/wp_testimonials_init.php';

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-bn-wp-activator.php
 */
function activate_made_wp_testimonials() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bn-wp-activator.php';
	MADE_WP_TESTIMONIAL_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-bn-wp-deactivator.php
 */
function deactivate_made_wp_testimonials() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bn-wp-deactivator.php';
	MADE_WP_TESTIMONIAL_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_made_wp_testimonials' );
register_deactivation_hook( __FILE__, 'deactivate_made_wp_testimonials' );

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
function run_made_wp_testimonials() {

	$plugin = new MADE_WP_TESTIMONIAL();
	$plugin->run();

}
run_made_wp_testimonials();
