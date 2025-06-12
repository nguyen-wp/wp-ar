<?php
/**
 * Enqueue scripts.
 *
 * @since MADE 2021
 *
 * @return void
 */
function made_scripts() {
	// Note, the is_IE global variable is defined by WordPress and is used
	// to detect if the current browser is internet explorer.
	global $is_IE, $wp_scripts, $made_theme;;
	
	wp_enqueue_script(
		'made-assets-theme-script',
		N3COMMERCIALREALTY_CORE_URL . 'dist/js/theme.js',
		wp_get_theme()->get( 'Version' ),
		true,
		true
	);

	// if (!is_admin() && current_user_can('administrator') && intval($made_theme['made-theme-global-dev-toogle-tag']) == 1) {
	// 	wp_enqueue_script(
	// 		'made-assets-admin-tool',
	// 		N3COMMERCIALREALTY_CORE_URL . 'dist/js/admin-tool.js',
	// 		wp_get_theme()->get( 'Version' ),
	// 		true,
	// 		true
	// 	);
	// }

}
add_action( 'wp_enqueue_scripts', 'made_scripts' );


function made_admin_scripts() {

	wp_enqueue_script(
		'made-admin-main-script',
		N3COMMERCIALREALTY_CORE_URL . 'admin/dist/js/admin.dev.js',
		wp_get_theme()->get( 'Version' ),
		true
	);
	wp_enqueue_script(
		'made-admin-prism-script',
		N3COMMERCIALREALTY_CORE_URL . 'admin/vendor/prism.js',
		wp_get_theme()->get( 'Version' ),
		true
	);
}

add_action( 'admin_enqueue_scripts', 'made_admin_scripts' );
