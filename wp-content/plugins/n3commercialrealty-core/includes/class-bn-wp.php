<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       nguyenpham.pro
 * @since      1.0.0
 *
 * @package    N3COMMERCIALREALTY_CORE
 * @subpackage N3COMMERCIALREALTY_CORE/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    N3COMMERCIALREALTY_CORE
 * @subpackage N3COMMERCIALREALTY_CORE/includes
 * @author     Nguyen Pham <baonguyenyam@gmail.com>
 */
class N3COMMERCIALREALTY_CORE {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      N3COMMERCIALREALTY_CORE_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $MADE_LabCore;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->MADE_LabCore['nicename'] = N3COMMERCIALREALTY_CORE_NICENAME;
		$this->MADE_LabCore['prefix'] = N3COMMERCIALREALTY_CORE_PREFIX;
		$this->MADE_LabCore['version'] = N3COMMERCIALREALTY_CORE_VERSION;

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - N3COMMERCIALREALTY_CORE_Loader. Orchestrates the hooks of the plugin.
	 * - N3COMMERCIALREALTY_CORE_i18n. Defines internationalization functionality.
	 * - N3COMMERCIALREALTY_CORE_Admin. Defines all hooks for the admin area.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-bn-wp-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-bn-wp-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-bn-wp-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-bn-wp-public.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		$this->loader = new N3COMMERCIALREALTY_CORE_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the N3COMMERCIALREALTY_CORE_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new N3COMMERCIALREALTY_CORE_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new N3COMMERCIALREALTY_CORE_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles', 9999 );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts', 9999 );
		// $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enquere_admin_script_footer', 9999 );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {
		
		$plugin_public = new MADE_CORE_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles', 9999 );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts', 9999 );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->MADE_LabCore;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    N3COMMERCIALREALTY_CORE_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->MADE_LabCore['version'];
	}

}
