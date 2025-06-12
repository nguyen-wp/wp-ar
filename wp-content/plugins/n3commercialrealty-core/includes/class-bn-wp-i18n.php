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
 * @package    N3COMMERCIALREALTY_CORE
 * @subpackage N3COMMERCIALREALTY_CORE/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    N3COMMERCIALREALTY_CORE
 * @subpackage N3COMMERCIALREALTY_CORE/includes
 * @author     Nguyen Pham <baonguyenyam@gmail.com>
 */
class N3COMMERCIALREALTY_CORE_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'madelab-core',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
