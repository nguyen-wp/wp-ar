<?php
/**
* @package N3COMMERCIALREALTY 
* @subpackage Theme by Nguyen Pham
* https://nguyenpham.pro/cv
* @since 2021
*/

use ScssPhp\ScssPhp\Compiler;

add_action('redux/options/' . $opt_name . '/saved',  "made_compiler_sass"  );
add_action('redux/options/' . $opt_name . '/saved',  "made_save_css"  );
add_action('redux/options/' . $opt_name . '/saved',  "made_save_js"  );
add_filter('redux/options/' . $opt_name . '/compiler', 'made_compiler_css', 10, 3);

	if ( ! function_exists( 'made_compiler_css' ) ) {
		function made_compiler_css( $options, $css, $changed_values) {
			global $wp_filesystem;
			global $made_theme;

			$filename = N3COMMERCIALREALTY_CORE_PATH . 'dist/css/export.css';
		
			if( empty( $wp_filesystem ) ) {
				require_once( ABSPATH .'/wp-admin/includes/file.php' );
				WP_Filesystem();
			}

			// OUTPUT
			$tmp = '/*!
* Coding by Nguyen Pham
*/';
		
			if( $wp_filesystem ) {
				$wp_filesystem->put_contents(
					$filename,
					$tmp.$css,
					FS_CHMOD_FILE // predefined mode settings for WP files
				);
			}
		}
	}

	if ( ! function_exists( 'made_compiler_sass' ) ) {
		function made_compiler_sass($values) {
			global $wp_filesystem;
			global $made_theme;
		
			$filename = N3COMMERCIALREALTY_CORE_PATH . '/dist/css/style.css';

			if( empty( $wp_filesystem ) ) {
				require_once( ABSPATH .'/wp-admin/includes/file.php' );
				WP_Filesystem();
			}
		
			if( $wp_filesystem ) {

				$tmp = '/*!
* Coding by Nguyen Pham
*/';

				try {
					$scss = new Compiler();
					$css = $scss->compileString($made_theme['made-theme-cssjs-scss-code'])->getCss();
			
					$wp_filesystem->put_contents(
						$filename,
						$tmp.$css,
						FS_CHMOD_FILE // predefined mode settings for WP files
					);
				} catch (\Exception $e) {
					echo '<div style="margin: 1rem; display: block; background: #ffcfcf; border: 1px solid #d28585; padding: 1rem; border-radius: 5px;">'.$e->getMessage().'</div>';
				}

			}
		}
	}	

	if ( ! function_exists( 'made_save_css' ) ) {
		function made_save_css($values) {
			global $wp_filesystem;
			global $made_theme;

			$filename = N3COMMERCIALREALTY_CORE_PATH . 'dist/css/theme.css';
		
			if( empty( $wp_filesystem ) ) {
				require_once( ABSPATH .'/wp-admin/includes/file.php' );
				WP_Filesystem();
			}

			$tmp = '/*!
* Coding by Nguyen Pham
*/';
		
			if( $wp_filesystem ) {
				$css = $tmp.$made_theme['made-theme-cssjs-css-code'];
				$wp_filesystem->put_contents(
					$filename,
					$css,
					FS_CHMOD_FILE // predefined mode settings for WP files
				);
			}
		}
	}

	if ( ! function_exists( 'made_save_js' ) ) {
		function made_save_js($values) {
			global $wp_filesystem;
			global $made_theme;

			$filename = N3COMMERCIALREALTY_CORE_PATH . 'dist/js/theme.js';
		
			if( empty( $wp_filesystem ) ) {
				require_once( ABSPATH .'/wp-admin/includes/file.php' );
				WP_Filesystem();
			}

			$tmp = '/*!
* Coding by Nguyen Pham
*/';
		
			if( $wp_filesystem ) {
				$js = $tmp.$made_theme['made-theme-cssjs-js-code'];
				$wp_filesystem->put_contents(
					$filename,
					$js,
					FS_CHMOD_FILE // predefined mode settings for WP files
				);
			}
		}
	}


	if( ! function_exists( 'made_admin_dashboard_widgets_disable')) {
		function made_admin_dashboard_widgets_disable() {
			global $made_theme;
			if($made_theme['made-theme-dashboard-widgets-enable'] == '1') {
				echo '<style>
					#wpbody #wpbody-content #dashboard-widgets .postbox-container {
						width: 100% !important
					} 
					#wpbody #wpbody-content #dashboard-widgets .postbox-container .meta-box-sortables > *:not(#dashboard_widget){
						display:none !important
					} 
				</style>';
			}
		}
		add_action('admin_head', 'made_admin_dashboard_widgets_disable');
	}
