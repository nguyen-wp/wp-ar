<?php
//  Exit if accessed directly.
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load translations from the MO file.
 */
function n3custompost_load_textdomain() {
    load_plugin_textdomain( 'n3custompost', false, plugin_basename( N3BLOCK_PLUGIN_DIR ) . '/languages/' );
}

add_action( 'plugins_loaded', 'n3custompost_load_textdomain' );