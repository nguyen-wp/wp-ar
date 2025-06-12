<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package made Creations 
 * @subpackage Theme by Nguyen Pham
 * https://nguyenpham.pro/cv
 * @since 2021
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @since made Theme 1.0
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */

function made_body_classes( $classes ) {
	global $made_theme;

	// Helps detect if JS is enabled or not.
	$classes[] = 'no-js';

	// Adds `singular` to singular pages, and `hfeed` to all other pages.
	$classes[] = is_singular() ? 'singular' : 'hfeed';

	// Add a body class if main navigation is active.
	if ( has_nav_menu( 'primary' ) ) {
		$classes[] = 'has-main-navigation';
	}

	// Add a body class if there are no footer widgets.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-widgets';
	}
	// if (intval($made_theme['made-theme-global-dev-toolbar']) == 1) {
	// 	if(!is_admin() && current_user_can('administrator')){
	// 		$classes[] = 'admin-control';
	// 	}
	// }

	return $classes;
}
add_filter( 'body_class', 'made_body_classes' );


function ___madelab_remove_scripts() {
	global $made_theme;

	$get_fe = isset($made_theme['made-theme-core-tool-remove-style-script-frontend']) ? $made_theme['made-theme-core-tool-remove-style-script-frontend'] : array();
	if ($get_fe) {
		foreach ($get_fe as $key => $value) {
			if($value != '') {
				wp_dequeue_style($value);
				wp_deregister_style($value);
				wp_dequeue_script($value);
				wp_deregister_script($value);
			}
		}
	}

}
add_action( 'wp_enqueue_scripts', '___madelab_remove_scripts', 9999999999 );

// Admin REMOVE CLASS/SCRIPTS
function ___madelab_admin_remove_scripts() {
	global $made_theme;
	
	$get_be = isset($made_theme['made-theme-core-tool-remove-style-script-backend']) ? $made_theme['made-theme-core-tool-remove-style-script-backend'] : array();
	if ($get_be) {
		foreach ($get_be as $key => $value) {
			if($value != '') {
				wp_dequeue_style($value);
				wp_deregister_style($value);
				wp_dequeue_script($value);
				wp_deregister_script($value);
			}
		}
	}
}

add_action( 'admin_enqueue_scripts', '___madelab_admin_remove_scripts', 9999999999 );

// Add TailwindCSS to Gutenberg Editor
add_action( 'enqueue_block_editor_assets', '__fsd_enqueue_block_editor_assets');
add_action('init', '__fsd_register_assets');
add_action('admin_head', '__fsd_enqueue_block_editor_admin');

function __fsd_register_assets(){
	// Check if Redux Framework is enabled
    if ( !class_exists( 'Redux' ) ) {
        return;
    }
    // If TailwindCSS is disabled
    if ( !Redux::get_option('made_theme', 'made-theme-tailwindcss-enable') ) {
        return;
    }
    wp_register_script(
        'nguyen_editor',
        'https://cdn.tailwindcss.com',
        array( 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-i18n' ),
        '1.0',
        true
    );
}
function __fsd_enqueue_block_editor_assets() {
	// Check if Redux Framework is enabled
    if ( !class_exists( 'Redux' ) ) {
        return;
    }
    // If TailwindCSS is disabled
    if ( !Redux::get_option('made_theme', 'made-theme-tailwindcss-enable') ) {
        return;
    }
    wp_enqueue_script( 'nguyen_editor' );
}

function __fsd_enqueue_block_editor_admin() {
	// Check if Redux Framework is enabled
	if ( !class_exists( 'Redux' ) ) {
		return;
	}
	// If TailwindCSS is disabled
	if ( !Redux::get_option('made_theme', 'made-theme-tailwindcss-enable') ) {
		return;
	}
	echo '<script>'.Redux::get_option('made_theme', 'made-theme-tailwindcss-config').'</script>';
}

// Add TailwindCSS cdn to theme 
function ___addTailwindCSS() {
    // Check if Redux Framework is enabled
    if ( !class_exists( 'Redux' ) ) {
        return;
    }
    // If TailwindCSS is disabled
    if ( !Redux::get_option('made_theme', 'made-theme-tailwindcss-enable') ) {
        return;
    }
    echo '<script src="https://cdn.tailwindcss.com"></script>';
    echo '<script>'.Redux::get_option('made_theme', 'made-theme-tailwindcss-config').'</script>';
}
add_action('wp_head', '___addTailwindCSS');

function gutenberg_editorcss_admin() {
	add_theme_support( 'editor-styles' );
    add_editor_style( 'style-editor.css' );
}
add_action( 'after_setup_theme', 'gutenberg_editorcss_admin' );

// Add CSS/JS to FrontEnd
function ___addStyleScriptFrontEnd() {
    // Check if Redux Framework is enabled
    if ( !class_exists( 'Redux' ) ) {
        return;
    }
    $css = Redux::get_option('made_theme', 'made-theme-core-tool-add-style-css-frontend');
    $js = Redux::get_option('made_theme', 'made-theme-core-tool-add-style-script-frontend');
    foreach ($css as $style) {
        echo '<link rel="stylesheet" href="'.$style.'">';
    }
    foreach ($js as $script) {
        echo '<script src="'.$script.'"></script>';
    }
}
add_action('wp_head', '___addStyleScriptFrontEnd');

// Add CSS/JS to BackEnd
function ___addStyleScriptBackEnd() {
    // Check if Redux Framework is enabled
    if ( !class_exists( 'Redux' ) ) {
        return;
    }
    $css = Redux::get_option('made_theme', 'made-theme-core-tool-add-style-css-backend');
    $js = Redux::get_option('made_theme', 'made-theme-core-tool-add-style-script-backend');
    foreach ($css as $style) {
        echo '<link rel="stylesheet" href="'.$style.'">';
    }
    foreach ($js as $script) {
        echo '<script src="'.$script.'"></script>';
    }
}
add_action('admin_head', '___addStyleScriptBackEnd');

function __my_acf_init() {
	// Check if ACF is enabled
	if ( !class_exists( 'acf' ) ) {
		return;
	}
	$api_key = Redux::get_option('made_theme', 'google-map-api-key');
    acf_update_setting('google_api_key', $api_key);
}

add_action('acf/init', '__my_acf_init');
