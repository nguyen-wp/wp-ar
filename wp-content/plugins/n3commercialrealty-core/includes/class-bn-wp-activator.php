<?php

/**
 * Fired during plugin activation
 *
 * @link       nguyenpham.pro
 * @since      1.0.0
 *
 * @package    N3COMMERCIALREALTY_CORE
 * @subpackage N3COMMERCIALREALTY_CORE/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    N3COMMERCIALREALTY_CORE
 * @subpackage N3COMMERCIALREALTY_CORE/includes
 * @author     Nguyen Pham <baonguyenyam@gmail.com>
 */
class N3COMMERCIALREALTY_CORE_Activator {

	public function __construct() {
		$this->activate();
	}

	public static function activate() {
		global $wp_filesystem; 
		if ( empty( $wp_filesystem ) ) {
			require_once( ABSPATH .'/wp-admin/includes/file.php' );
			WP_Filesystem();
		}
		if ( file_exists( N3COMMERCIALREALTY_CORE_PATH . 'docs/plugins.html' ) ) { 
			$wp_filesystem->delete( N3COMMERCIALREALTY_CORE_PATH . 'docs/plugins.html' );
		}
		if ( file_exists( N3COMMERCIALREALTY_CORE_PATH . 'docs/themeinfo.html' ) ) { 
			$wp_filesystem->delete( N3COMMERCIALREALTY_CORE_PATH . 'docs/themeinfo.html' );
		}
	}

	
}
