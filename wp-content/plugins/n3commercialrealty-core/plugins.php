<?php
/**
* @package LIFT Creations 
* @subpackage Theme by Nguyen Pham
* https://nguyenpham.pro/cv
* @since 2021
*/

add_action( 'tgmpa_register', 'made_theme_options_register_required_plugins' );

function made_theme_options_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		// This is an example of how to include a plugin bundled with a theme.
		
		// This is an example of how to include a plugin from an arbitrary external source in your theme.
		array(
			'name'         => 'Jetpack', // The plugin name.
			'slug'         => 'jetpack', // The plugin slug (typically the folder name).
			'required'     => false, // If false, the plugin is only 'recommended' instead of required.
		),
		array(
			'name'         => 'Wordfence Security', // The plugin name.
			'slug'         => 'wordfence', // The plugin slug (typically the folder name).
			'required'     => false, // If false, the plugin is only 'recommended' instead of required.
		),
		array(
			'name'         => 'AMP', // The plugin name.
			'slug'         => 'amp', // The plugin slug (typically the folder name).
			'required'     => false, // If false, the plugin is only 'recommended' instead of required.
		),
		array(
			'name'         => 'Autoptimize', // The plugin name.
			'slug'         => 'autoptimize', // The plugin slug (typically the folder name).
			'required'     => false, // If false, the plugin is only 'recommended' instead of required.
		),
		// array(
		// 	'name'         => 'Contact Form 7', // The plugin name.
		// 	'slug'         => 'contact-form-7', // The plugin slug (typically the folder name).
		// 	'required'     => false, // If false, the plugin is only 'recommended' instead of required.
		// ),
		array(
			'name'         => 'Really Simple SSL', // The plugin name.
			'slug'         => 'really-simple-ssl', // The plugin slug (typically the folder name).
			'required'     => false, // If false, the plugin is only 'recommended' instead of required.
		),
		array(
			'name'         => 'UpdraftPlus', // The plugin name.
			'slug'         => 'updraftplus', // The plugin slug (typically the folder name).
			'required'     => false, // If false, the plugin is only 'recommended' instead of required.
		),
		array(
			'name'         => 'Smush', // The plugin name.
			'slug'         => 'wp-smushit', // The plugin slug (typically the folder name).
			'required'     => false, // If false, the plugin is only 'recommended' instead of required.
		),
		

		// This is an example of how to include a plugin from a GitHub repository in your theme.
		// This presumes that the plugin code is based in the root of the GitHub repository
		// and not in a subdirectory ('/src') of the repository.
		// array(
		// 	'name'      => 'Adminbar Link Comments to Pending',
		// 	'slug'      => 'adminbar-link-comments-to-pending',
		// 	'source'    => 'https://github.com/jrfnl/WP-adminbar-comments-to-pending/archive/master.zip',
		// ),

		// This is an example of how to include a plugin from the WordPress Plugin Repository.
		// array(
		// 	'name'      => 'BuddyPress',
		// 	'slug'      => 'buddypress',
		// 	'required'  => false,
		// ),

		// This is an example of the use of 'is_callable' functionality. A user could - for instance -
		// have WPSEO installed *or* WPSEO Premium. The slug would in that last case be different, i.e.
		// 'wordpress-seo-premium'.
		// By setting 'is_callable' to either a function from that plugin or a class method
		// `array( 'class', 'method' )` similar to how you hook in to actions and filters, TGMPA can still
		// recognize the plugin as being installed.
		array(
			'name'        => 'WordPress SEO by Yoast',
			'slug'        => 'wordpress-seo',
			'is_callable' => 'wpseo_init',
			'required'     => false,
		),

	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'made-theme-options',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.

		/*
		'strings'      => array(
			'page_title'                      => __( 'Install Required Plugins', 'made-theme-options' ),
			'menu_title'                      => __( 'Install Plugins', 'made-theme-options' ),
			/* translators: %s: plugin name. * /
			'installing'                      => __( 'Installing Plugin: %s', 'made-theme-options' ),
			/* translators: %s: plugin name. * /
			'updating'                        => __( 'Updating Plugin: %s', 'made-theme-options' ),
			'oops'                            => __( 'Something went wrong with the plugin API.', 'made-theme-options' ),
			'notice_can_install_required'     => _n_noop(
				/* translators: 1: plugin name(s). * /
				'MADE requires the following plugin: %1$s.',
				'MADE requires the following plugins: %1$s.',
				'made-theme-options'
			),
			'notice_can_install_recommended'  => _n_noop(
				/* translators: 1: plugin name(s). * /
				'MADE recommends the following plugin: %1$s.',
				'MADE recommends the following plugins: %1$s.',
				'made-theme-options'
			),
			'notice_ask_to_update'            => _n_noop(
				/* translators: 1: plugin name(s). * /
				'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
				'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
				'made-theme-options'
			),
			'notice_ask_to_update_maybe'      => _n_noop(
				/* translators: 1: plugin name(s). * /
				'There is an update available for: %1$s.',
				'There are updates available for the following plugins: %1$s.',
				'made-theme-options'
			),
			'notice_can_activate_required'    => _n_noop(
				/* translators: 1: plugin name(s). * /
				'The following required plugin is currently inactive: %1$s.',
				'The following required plugins are currently inactive: %1$s.',
				'made-theme-options'
			),
			'notice_can_activate_recommended' => _n_noop(
				/* translators: 1: plugin name(s). * /
				'The following recommended plugin is currently inactive: %1$s.',
				'The following recommended plugins are currently inactive: %1$s.',
				'made-theme-options'
			),
			'install_link'                    => _n_noop(
				'Begin installing plugin',
				'Begin installing plugins',
				'made-theme-options'
			),
			'update_link' 					  => _n_noop(
				'Begin updating plugin',
				'Begin updating plugins',
				'made-theme-options'
			),
			'activate_link'                   => _n_noop(
				'Begin activating plugin',
				'Begin activating plugins',
				'made-theme-options'
			),
			'return'                          => __( 'Return to Required Plugins Installer', 'made-theme-options' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'made-theme-options' ),
			'activated_successfully'          => __( 'The following plugin was activated successfully:', 'made-theme-options' ),
			/* translators: 1: plugin name. * /
			'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'made-theme-options' ),
			/* translators: 1: plugin name. * /
			'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'made-theme-options' ),
			/* translators: 1: dashboard link. * /
			'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'made-theme-options' ),
			'dismiss'                         => __( 'Dismiss this notice', 'made-theme-options' ),
			'notice_cannot_install_activate'  => __( 'There are one or more required or recommended plugins to install, update or activate.', 'made-theme-options' ),
			'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'made-theme-options' ),

			'nag_type'                        => '', // Determines admin notice type - can only be one of the typical WP notice classes, such as 'updated', 'update-nag', 'notice-warning', 'notice-info' or 'error'. Some of which may not work as expected in older WP versions.
		),
		*/
	);

	tgmpa( $plugins, $config );
}
