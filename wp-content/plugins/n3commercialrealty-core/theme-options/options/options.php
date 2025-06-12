<?php
/**
* @package N3COMMERCIALREALTY 
* @subpackage Theme by Nguyen Pham
* https://nguyenpham.pro/cv
* @since 2021
*/
    /**
     * ---> SET ARGUMENTS
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */
	$opt_name = "made_theme";
    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $args = array(
		'dev_mode' => false,
		'class' => 'made-theme-admin',
        // TYPICAL -> Change these values as you need/desire
        'opt_name'             => $opt_name,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'         => 'N3 System',
        // Name that appears at the top of your panel
        'display_version'      => '2.0.1',
        // Version that appears at the top of your panel
        'menu_type'            => 'menu',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => true,
        // Show the sections below the admin menu item or not
		'menu_title'           => esc_html__( 'N3 System', 'made-theme-options' ),
		'page_title'           => esc_html__( 'N3 System', 'made-theme-options' ),
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key'       => '',
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => false,
        // Must be defined to add google fonts to the typography module
        'async_typography'     => false,
        // Use a asynchronous font on the front end or font string
        //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
        'admin_bar'            => true,
        // Show the panel pages on the admin bar
        'admin_bar_icon'       => 'bi bi-award',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 0,
        // Choose an priority for the admin bar menu
        'global_variable'      => '',
        // Set a different name for your global variable other than the opt_name
        // Show the time the page took to load, etc
        'update_notice'        => true,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer'           => true,
        // Enable basic customizer support
        // 'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
        //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field
		'system_info' => true,
        // OPTIONAL -> Give you extra features
        'page_priority'        => 39,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent'          => 'themes.php',
        // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'manage_options',
        // 'page_permissions'     => 'editor',
        // Permissions needed to access the options panel.
        'menu_icon'            => 'dashicons-admin-generic',
        // Specify a custom URL to an icon
        // 'menu_position'        => 1,
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => 'icon-themes',
        // Icon displayed in the admin panel next to your menu_title
        'page_slug'            => 'made_theme_options',
        // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
        'save_defaults'        => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => false,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export'   => true,
        // Shows the Import/Export panel when not used as a field.

        // CAREFUL -> These options are for advanced use only
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => true,
        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
        'footer_credit'             => ' - Built v'.N3COMMERCIALREALTY_CORE_VERSION,

        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database'             => '',
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
        'use_cdn'              => true,
        // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'red',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        )
    );

////////////////////////////////////////////////////////////////////////
// MORE OPTION 
////////////////////////////////////////////////////////////////////////

// ADMIN BAR LINKS -> Setup custom links in the admin bar menu as external items.
$args['admin_bar_links'][] = array(
	'id'    => 'made-theme',
	'href'  => '//github.com/baonguyenyam/',
	'title' => __( 'Documentation', 'made-theme-options' ),
);
$args['admin_bar_links'][] = array(
	'id'    => 'made-about',
	'href'  => '//nguyenpham.pro',
	'title' => __( 'About Author', 'made-theme-options' ),
);
$args['share_icons'][] = array(
	'url'   => '//github.com/baonguyenyam/',
	'title' => __('Visit us on GitHub', 'made-theme-options' ),
	'icon'  => 'el el-github',
);
$args['share_icons'][] = array(
	'url'   => '//linkedin.com/in/baonguyenyam/',
    'title' => __('Connect with me on LinkedIn', 'made-theme-options' ),
    'icon'  => 'el el-linkedin',
);
$args['share_icons'][] = array(
	'url'   => 'mailto:baonguyenyam@gmail.com',
    'title' => __('Email me', 'made-theme-options' ),
    'icon'  => 'el el-envelope',
);

// Panel Intro text -> before the form
if ( ! isset( $args['global_variable'] ) || $args['global_variable'] !== false ) {
	if ( ! empty( $args['global_variable'] ) ) {
		$v = $args['global_variable'];
	} else {
		$v = str_replace( '-', '_', $args['opt_name'] );
	}
	// $args['intro_text'] = sprintf( __( '<p>As of WP 4.3, the favicon setting is now available in the default WordPress customizer (Appearance > Customize).</p>', 'made-theme-options' ), $v );
} else {
	$args['intro_text'] = __( '<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'made-theme-options' );
}

// Add content after the form.
$args['footer_text'] = __( '<p>© Copyright by Restore Construction. All rights reserved.</p>', 'made-theme-options' );

////////////////////////////////////////////////////////////////////////
// INIT APP
////////////////////////////////////////////////////////////////////////

Redux::set_args( $opt_name, $args );


