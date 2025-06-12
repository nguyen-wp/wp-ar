<?php
/**
 * Plugin Name: @Restore Construction Templates
 * Description: Extra Gutenberg blocks for building seamless and aesthetic websites in the WordPress block editor.
 * Version: 1.8.3
 * Author:            Restore Construction
 * Author URI:        https://restoreconstruction.com
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: n3custompost
 * Domain Path: /languages
 */

//  Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'N3Block\N3Block' ) ) {

	if ( ! defined( 'N3BLOCK_PLUGIN_FILE' ) ) {
		define( 'N3BLOCK_PLUGIN_FILE', __FILE__ );
	}
	if ( ! defined( 'N3BLOCK_PLUGIN_DIR' ) ) {
		define( 'N3BLOCK_PLUGIN_DIR', plugin_dir_path( __FILE__ ) ); // The path with trailing slash
	}
	if ( ! defined( 'N3BLOCK_PLUGIN_BASENAME' ) ) {
		define( 'N3BLOCK_PLUGIN_BASENAME', plugin_basename( N3BLOCK_PLUGIN_FILE ) );
	}
	if ( ! defined( 'N3BLOCK_DEBUG' ) ) {
		define( 'N3BLOCK_DEBUG', false );
	}

	include_once N3BLOCK_PLUGIN_DIR . 'includes/n3custompost.php';

    function n3custompost() {
        return \N3Block\N3Block::getInstance();
    }

	// Init N3Block
    n3custompost();

}
