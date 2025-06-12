<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       nguyenpham.pro
 * @since      1.0.0
 *
 * @package    MADE_WP_MAPS
 * @subpackage MADE_WP_MAPS/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    MADE_WP_MAPS
 * @subpackage MADE_WP_MAPS/includes
 * @author     Nguyen Pham <baonguyenyam@gmail.com>
 */
class MADE_WP_MAPS_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'n3-wp-maps',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
