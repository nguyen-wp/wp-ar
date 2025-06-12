<?php
/**
* @package N3COMMERCIALREALTY 
* @subpackage Theme by Nguyen Pham
* https://nguyenpham.pro/cv
* @since 2021
*/

// Register Widgets
// add_action( 'widgets_init', 'made_register_widget_theme' );
 
// function made_register_widget_theme() {
//     register_widget( 'made_Social_Widget' );
// }

function get_made_theme_options() {

	$legacy_options  = get_option( 'made_theme' );
	$current_options = get_option( 'made_theme_redux' );

	if ( ! empty( $current_options ) ) {
		return $current_options;
	} elseif ( ! empty( $legacy_options ) ) {
		return $legacy_options;
	} else {
		return $current_options;
	}
}

$made_options = get_made_theme_options();

// Remove Redux Menu 
function remove_redux_fw_submenu() {
    remove_submenu_page( 'tools.php', 'redux-about' );
}
add_action( 'admin_menu', 'remove_redux_fw_submenu', 999 );

function madelab_remove_footer_admin () 
{
    echo 'Restore Construction';
}
 
add_filter('admin_footer_text', 'madelab_remove_footer_admin');

// Add Menu URL Class
function __add_header_menu_item_class($atts) {
	$atts['class'] = "nav-link";
	return $atts;
}
add_filter('nav_menu_link_attributes', '__add_header_menu_item_class');

// Add Bootstrap 
function made_custom_css_classes_for_vc_row_and_vc_column( $class_string, $tag ) {
	if ( $tag == 'vc_row' || $tag == 'vc_row_inner' ) {
		//   $class_string = str_replace( 'vc_row-fluid', 'my_row-fluid', $class_string ); 
		$class_string = str_replace( 'vc_row', 'row', $class_string ); 
	}
	// var_dump($class_string);
	// if ( $class_string == 'row wpb_row vc_inner row-fluid' ) {
	// 	$class_string = str_replace( $class_string, 'row wpb_row vc_inner row-fluid container', $class_string ); 
	// }
	if ( $tag == 'vc_column' || $tag == 'vc_column_inner' ) {
		// $class_string = preg_replace( '/vc_col-sm-(\d{1,2})/', 'my_col-sm-$1', $class_string );
		$class_string = preg_replace( '/vc_column_container/', '', $class_string );
		$class_string = preg_replace( '/vc_col-(xs|sm|md|lg|xl|xxl)-(\d{1,2})/', 'col-$1-$2', $class_string );
		$class_string = preg_replace( '/vc_col-(xs|sm|md|lg|xl|xxl)-offset-(\d{1,2})/', 'offset-$1-$2', $class_string );
	}
	return $class_string; 
}
add_filter( 'vc_shortcodes_css_class', 'made_custom_css_classes_for_vc_row_and_vc_column', 10, 2 );


// Check License
function _____MADEcheckLicense() {

	$made_options = get_made_theme_options();

	$made_license['domain'] = $made_options['made-theme-license-code-domain'];
	$made_license['email'] = $made_options['made-theme-license-code-email'];
	$made_license['package'] = $made_options['made-theme-license-code-package'];
	$made_license['key'] = $made_options['made-theme-license-code-key'];
	$made_license['license'] = $made_options['made-theme-license-code-license'];
	$password = trim($made_license['key'].$made_license['domain'].$made_license['email'].$made_license['package']);
	$LicenseVerify = true;
	if (!password_verify($password, $made_license['license'])) {
		$LicenseVerify = false;
	} else {
		if($made_license['domain'] !== $_SERVER['SERVER_NAME']) {
			$LicenseVerify = false;
		} else {
			date_default_timezone_set('America/Chicago'); 
			$time1 = strtotime($made_license['package']);
			$time2 = strtotime(date('m/d/Y'));
			if($time1<$time2){
				$LicenseVerify = false;
			}
		}
	}
	if(!$LicenseVerify){
		echo '<div class="wrap"><div style="margin: 1rem 0; display: block; background: #ffcfcf; border: 1px solid #d28585; padding: 1rem; border-radius: 5px;">Your license is expired. Please renew the license to get the latest update of MADE Lab Theme. In order to receive all benefits of MADE Lab Theme, you need to activate your copy of the plugin. By activating MADE Lab Theme license you will unlock premium options - direct plugin updates, access to template library and official support. Don\'t have direct license yet? <a href="//n3commercialrealty.com" target="_blank">Purchase MADE Lab Theme license.</a></div></div>';
	}

}
// add_action( 'admin_notices', '_____MADEcheckLicense' );



