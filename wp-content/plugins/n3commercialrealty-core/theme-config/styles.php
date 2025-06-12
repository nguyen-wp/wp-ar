<?php
/**
 * Enqueue styles.
 *
 * @since MADE 2021
 *
 * @return void
 */
function made_styles() {
	// Note, the is_IE global variable is defined by WordPress and is used
	// to detect if the current browser is internet explorer.
	global $is_IE, $wp_scripts, $made_theme;

	wp_enqueue_style(
		'made-assets-theme-style', 
		N3COMMERCIALREALTY_CORE_URL . 'dist/css/theme.css', 
		array(), 
		wp_get_theme()->get( 'Version' ), 'all' 
	);
	wp_enqueue_style(
		'made-assets-style-style', 
		N3COMMERCIALREALTY_CORE_URL . 'dist/css/style.css', 
		array(), 
		wp_get_theme()->get( 'Version' ), 'all' 
	);

	// Print.
	wp_enqueue_style(
		'made-assets-print-style', 
		N3COMMERCIALREALTY_CORE_URL . 'dist/css/print.css', 
		array(), 
		wp_get_theme()->get( 'Version' ), 'print' 
	);

	// Threaded comment reply styles.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// if (!is_admin() && current_user_can('administrator') && intval($made_theme['made-theme-global-dev-toogle-tag']) == 1) {
	// 	wp_enqueue_style(
	// 		'made-assets-style-admin-tool', 
	// 		N3COMMERCIALREALTY_CORE_URL . 'dist/css/admin-tool.css', 
	// 		array(), 
	// 		wp_get_theme()->get( 'Version' ), 'all' 
	// 	);
	// }
}
add_action( 'wp_enqueue_scripts', 'made_styles' , 999999 );

function made_admin_styles() {
	// Styles.
	wp_enqueue_style(
		'made-assets-icon-style', 
		N3COMMERCIALREALTY_CORE_URL . 'admin/vendor/bootstrap-icons.css', 
		array(), 
		wp_get_theme()->get( 'Version' ), 'all' 
	);
	wp_enqueue_style(
		'made-assets-main-style', 
		N3COMMERCIALREALTY_CORE_URL . 'admin/dist/css/admin.css', 
		array(), 
		wp_get_theme()->get( 'Version' ), 'all' 
	);
	wp_enqueue_style(
		'made-assets-monokai-style', 
		N3COMMERCIALREALTY_CORE_URL . 'admin/dist/css/monokai.css', 
		array(), 
		wp_get_theme()->get( 'Version' ), 'all' 
	);
	// wp_enqueue_style(
	// 	'made-assets-made-style', 
	// 	N3COMMERCIALREALTY_CORE_URL . 'admin/dist/css/made.css', 
	// 	array(), 
	// 	wp_get_theme()->get( 'Version' ), 'all' 
	// );
	wp_enqueue_style(
		'made-assets-prism-style', 
		N3COMMERCIALREALTY_CORE_URL . 'admin/vendor/prism.css', 
		array(), 
		wp_get_theme()->get( 'Version' ), 'all' 
	);
}

add_action( 'admin_enqueue_scripts', 'made_admin_styles' );
