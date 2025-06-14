<?php
/**
 * Plugin Name:       @Restore Construction Logo Carousel
 * Description:       <strong>RC Logo Carousel Block</strong> is a Custom <strong>Gutenberg Block</strong> developed with Swiper Js library and Gutenberg Native Components to showcase clients logos in a sliding mode.
 * Requires at least: 5.7
 * Requires PHP:      7.0
 * Version:           2.0.3
 * Author:            Restore Construction
 * Author URI:        https://restoreconstruction.com
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       n3-logo-carousel-block
 *
 * @package           @wordpress/create-block 
 */

 /**
  * @package Zero Configuration with @wordpress/create-block
  *  [alcb] && [ALCB] ===> Prefix
  */

// Stop Direct Access 
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// admin panel file
require_once plugin_dir_path( __FILE__ ) . 'admin/admin.php';

/**
 * Blocks Final Class
 */

final class GPLOGOBLOCKS_CLASS {
	public function __construct() {

		// define constants
		$this->alcb_define_constants();

		// block initialization
		add_action( 'init', [ $this, 'alcb_blocks_init' ] );

		// blocks category
		if( version_compare( $GLOBALS['wp_version'], '5.7', '<' ) ) {
			add_filter( 'block_categories', [ $this, 'alcb_register_block_category' ], 10, 2 );
		} else {
			add_filter( 'block_categories_all', [ $this, 'alcb_register_block_category' ], 10, 2 );
		}

		add_filter( 'plugin_row_meta', array( $this, '__madeapp_plugin_row_met' ), 10, 2 );

		// enqueue block assets
		add_action( 'enqueue_block_assets', [ $this, 'alcb_external_libraries' ] );
	}


    // ADD SETTING LINK 
	public static function __madeapp_plugin_row_met( $links, $file ) {
		$plugin_dir = 'n3-logo-carousel';
		if( $file === $plugin_dir.'/nguyen-app.php' || $file === $plugin_dir.'/index.php' || $file === $plugin_dir.'/plugin.php' ){
			$links[] = '<a href="https://nguyenpham.pro/" target="_blank">' . esc_html__( 'Author', 'duplicate-post' ) . '</a>';
			// $links[] = '<a href="' . esc_url( get_admin_url(null, 'admin.php?page=n3_logo_carousel') ) . '">' . esc_html__( 'Settings', 'duplicate-post' ) . '</a>';
		}
		return $links;
	}

	/**
	 * Initialize the plugin
	 */

	public static function init(){
		static $instance = false; 
		if( ! $instance ) {
			$instance = new self();
		}
		return $instance;
	}

	/**
	 * Define the plugin constants
	 */
	private function alcb_define_constants() {
		define( 'ALCB_VERSION', '2.0.2' );
		define( 'ALCB_URL', plugin_dir_url( __FILE__ ) );
		define( 'ALCB_INC_URL', ALCB_URL . 'inc/' );		
		define( 'ALCB_LIB_URL', ALCB_URL . 'lib/' );		
	}

	/**
	 * Blocks Registration 
	 */

	public function alcb_register_block( $name, $options = array() ) {
		register_block_type( __DIR__ . '/build/' . $name, $options );
	 }

	/**
	 * Blocks Initialization
	*/
	public function alcb_blocks_init() {
		// register single block
		$this->alcb_register_block( 'carousel' );
	}

	/**
	 * Register Block Category
	 */

	public function alcb_register_block_category( $categories, $post ) {
		return array_merge(
			array(
				array(
					'slug'  => 'logo-blocks',
					'title' => __( 'Logo Blocks', 'n3-logo-carousel-block' ),
				),
			),
			$categories,
		);
	}

	/**
	 * Enqueue Block Assets
	 */
	public function alcb_external_libraries() {
		// admin css
		if( is_admin() ) {
			wp_enqueue_style( 'alcb-admin-editor', ALCB_URL . 'admin/css/editor.css' );
		}

		if( ! is_admin() ){
			// enqueue css
			wp_enqueue_style( 'alcb-swiper-css', ALCB_LIB_URL . 'css/swiper-bundle.css', array(), '8.1.4', 'all' );
			// enqueue JS
			wp_enqueue_script( 'alcb-swiper-js', ALCB_LIB_URL . 'js/swiper-bundle.js', array(), '8.1.4', true );
			wp_enqueue_script( 'alcb-logo-slider', ALCB_INC_URL . 'js/logo-slider.js', array(), ALCB_VERSION, true );
		}
	}

}

/**
 * Kickoff
*/

GPLOGOBLOCKS_CLASS::init();
