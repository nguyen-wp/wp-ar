<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       nguyenpham.pro
 * @since      1.0.0
 *
 * @package    MADE_WP_TESTIMONIAL
 * @subpackage MADE_WP_TESTIMONIAL/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    MADE_WP_TESTIMONIAL
 * @subpackage MADE_WP_TESTIMONIAL/admin
 * @author     Nguyen Pham <baonguyenyam@gmail.com>
 */
class MADE_WP_TESTIMONIAL_Admin {

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
		add_filter( 'plugin_row_meta', array( $this, '__madeapp_plugin_row_meta' ), 10, 2 );

	}

	// ADD SETTING LINK 
	public function __madeapp_plugin_row_meta( $links, $file ) {
		$plugin_dir = 'n3-wp-testimonials';
		if( $file === $plugin_dir.'/nguyen-app.php' || $file === $plugin_dir.'/index.php' || $file === $plugin_dir.'/plugin.php' ){
			$links[] = '<a href="https://nguyenpham.pro/" target="_blank">' . esc_html__( 'Author', 'duplicate-post' ) . '</a>';
			$links[] = '<a href="' . esc_url( get_admin_url(null, 'edit.php?post_type=n3_testimonials&page=n3_testimonials_settings') ) . '">' . esc_html__( 'Short Code', 'duplicate-post' ) . '</a>';
		}
		return $links;
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
		 * defined in MADE_WP_TESTIMONIAL_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The MADE_WP_TESTIMONIAL_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_register_style( 'wp_testimonials_public_carousel_css',  plugin_dir_url(__DIR__) . 'public/css/owl.carousel.min.css', array() );
		wp_enqueue_style('wp_testimonials_public_carousel_css');
		wp_register_style( 'wp_testimonials_public_carousel_theme_css',  plugin_dir_url(__DIR__) . 'public/css/owl.theme.default.css', array() );
		wp_enqueue_style('wp_testimonials_public_carousel_theme_css');
		wp_register_style( 'wp_testimonials_admin_main_css',  plugin_dir_url( __FILE__ ) . 'assets/css/main.min.css', array() );
		wp_enqueue_style('wp_testimonials_admin_main_css');

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in MADE_WP_TESTIMONIAL_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The MADE_WP_TESTIMONIAL_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_register_script( 'wp_testimonials_public_vendor_carousel_js',  plugin_dir_url( __DIR__) . 'public/js/owl.carousel.min.js', array( 'jquery' ), '1.0.0', true );
		wp_enqueue_script('wp_testimonials_public_vendor_carousel_js');
		wp_register_script('wp_testimonials_admin_main_js', plugin_dir_url( __FILE__ ) . 'assets/js/main.prod.js', array('jquery'));
        wp_enqueue_script('wp_testimonials_admin_main_js');

	}
	

}
