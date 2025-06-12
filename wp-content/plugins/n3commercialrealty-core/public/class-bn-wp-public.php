<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       nguyenpham.pro
 * @since      1.0.0
 *
 * @package    MADE_CORE
 * @subpackage MADE_CORE/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    MADE_CORE
 * @subpackage MADE_CORE/admin
 * @author     Nguyen Pham <baonguyenyam@gmail.com>
 */
class MADE_CORE_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in MADE_CORE_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The MADE_CORE_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_register_style( 'madecore_public',  plugin_dir_url( __FILE__ ) . 'css/swiper-bundle.min.css', array() );
		wp_enqueue_style('madecore_public');
		// wp_register_style( 'madecore_publicmi',  plugin_dir_url( __FILE__ ) . 'css/main.min.css', array() );
		// wp_enqueue_style('madecore_publicmi');

	}

	/**
	 * Register the JavaScript for the public area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in MADE_CORE_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The MADE_CORE_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_register_script('madecore_public', plugin_dir_url( __FILE__ ) . 'js/swiper-bundle.min.js', array('jquery'));
        wp_enqueue_script('madecore_public');
		wp_register_script('madecore_publicmi', plugin_dir_url( __FILE__ ) . 'js/main.dev.js', array('jquery'));
        wp_enqueue_script('madecore_publicmi');

	}
	

}
