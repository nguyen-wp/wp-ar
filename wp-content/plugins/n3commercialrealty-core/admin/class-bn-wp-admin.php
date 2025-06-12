<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       nguyenpham.pro
 * @since      1.0.0
 *
 * @package    N3COMMERCIALREALTY_CORE
 * @subpackage N3COMMERCIALREALTY_CORE/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    N3COMMERCIALREALTY_CORE
 * @subpackage N3COMMERCIALREALTY_CORE/admin
 * @author     Nguyen Pham <baonguyenyam@gmail.com>
 */
class N3COMMERCIALREALTY_CORE_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		// CHECK LICENSE
		if(wp_get_theme()->get( 'TextDomain' ) === 'madelab-theme-options') {
			$madelab_license = [];
			$legacy_options  = get_option( 'madelab_theme' );
			$madelab_license['domain'] = isset($legacy_options['madelab-theme-license-code-domain']) ? $legacy_options['madelab-theme-license-code-domain'] : '';
			$madelab_license['email'] = isset($legacy_options['madelab-theme-license-code-email']) ? $legacy_options['madelab-theme-license-code-email'] : '';
			$madelab_license['package'] = isset($legacy_options['madelab-theme-license-code-package']) ? $legacy_options['madelab-theme-license-code-package'] : '';
			$madelab_license['key'] = isset($legacy_options['madelab-theme-license-code-key']) ? $legacy_options['madelab-theme-license-code-key'] : '';
			$madelab_license['license'] = isset($legacy_options['madelab-theme-license-code-license']) ? $legacy_options['madelab-theme-license-code-license'] : '';
			$password = trim($madelab_license['key'].$madelab_license['domain'].$madelab_license['email'].$madelab_license['package']);
			$LicenseVerify = true;
			if (!password_verify($password, $madelab_license['license'])) {
				$LicenseVerify = false;
			} else {
				if($madelab_license['domain'] !== $_SERVER['SERVER_NAME']) {
					$LicenseVerify = false;
				} else {
					date_default_timezone_set('America/Chicago'); 
					$time1 = strtotime($madelab_license['package']);
					$time2 = strtotime(date('m/d/Y'));
					if($time1<$time2){
						$LicenseVerify = false;
					}
				}
			}
			if(!$LicenseVerify){
				add_action( 'admin_menu', array( $this, '___addPluginAdminMenu' ));   
			}
		}

		add_filter( 'plugin_action_links',  array( $this, '__madeapp_setting_link') , 10, 2 );
		add_filter( 'plugin_row_meta', array( $this, '__madeapp_plugin_row_meta' ), 10, 2 );

		// Add Hidden Menu for Theme Options
		add_action( 'admin_menu', array( $this, '___addPluginHiddenAdminMenu' ));

		// AJAX 
		add_action("wp_ajax_made_core_backup_fullsite", array( $this, "made_core_backup_fullsite") );
		add_action("wp_ajax_nopriv_made_core_backup_fullsite", array( $this, "made_core_backup_fullsite_must_login"));

	}

	// AJAX Function 
	public function made_core_backup_fullsite() {

		// verify nonce
		if ( !isset( $_POST['nonce'] ) || !wp_verify_nonce( $_POST['nonce'], 'made_core_backup_fullsite_nonce' ) ) {
			die( 'Busted!' );
		}
		
		$result = ""; // error

		// Report all errors
		error_reporting(E_ALL);
		set_time_limit(900); // 15 minutes

		$plugin_name = 'general_public_backup';
		$upload_path = ABSPATH;
		// Create Folder 
		$folder = $upload_path . $plugin_name . '/files';

		// Full site compress files and directories 
		$zip = new ZipArchive();
		$zip_name = $folder . '/ml-' . date('YmdHis') . '.zip';
		if ($zip->open($zip_name, ZIPARCHIVE::CREATE) !== TRUE) {
			// opening zip file to load data
			$error .= "* Sorry ZIP creation failed at this time";
		} else {
			$ignoreFolder = array(
				'node_modules', 
				'bower_components', 
				'.git'
			);
			// Scan all files and directories to compress
			$files = new RecursiveIteratorIterator(
				new RecursiveDirectoryIterator($upload_path),
				RecursiveIteratorIterator::LEAVES_ONLY
			);
			foreach ($files as $name => $file) {
				// Skip directories (they would be added automatically)
				if (!$file->isDir()) {

					
					if (in_array($file->getFilename(), $ignoreFolder)) {
						continue;
					}
					// Display the process to box 
					// $result = 'Adding file ' . $file->getRealPath() . ' with name ' .  substr($file->getRealPath(), strlen($upload_path) + 1) .  '<br>';

					// WP AJAX Send 
					if (php_sapi_name() != "cli") {
						$lineBreak = "<br />";
					} else {
						$lineBreak = "\n";
					}
					$result .= 'Adding file ' . $file->getRealPath() .  '<br>';
					$result .= $lineBreak;

					// Get real and relative path for current file
					$filePath = $file->getRealPath();
					$relativePath = substr($filePath, strlen($upload_path) + 1);

					// Add current file to archive
					$zip->addFile($filePath, $relativePath);
				}
			}
			$zip->close();
		}

		// echo $result;

		if (php_sapi_name() != "cli") {
            if( ob_get_level() > 0 ) {
                ob_flush();
            }
        }

        flush();

		// Display percentage of the process

		// if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		// 	echo $result;
		// }
		// else {
		// 	header("Location: ".$_SERVER["HTTP_REFERER"]);
		// }
		
		// die();
		
	}
		
	public function made_core_backup_fullsite_must_login() {
		echo "You must log in to use this function";
		die();
	}


	// ADD SETTING LINK 

	public function __madeapp_setting_link( $links, $file ) {
		if( $file === 'n3commercialrealty-core/nguyen-app.php' ||  $file === 'madelab/nguyen-app.php' ){
			$link = '<a href="'.admin_url('admin.php?page=made_theme_options').'">'.esc_html__('Settings', 'made-theme-options' ).'</a>';
			array_unshift( $links, $link ); 
		}
		return $links;
	}

	public function __madeapp_plugin_row_meta( $links, $file ) {
		if( $file === 'n3commercialrealty-core/nguyen-app.php' ||  $file === 'madelab/nguyen-app.php' ){
			$links[] = '<a href="https://nguyenpham.pro/" target="_blank">' . esc_html__( 'Author', 'duplicate-post' ) . '</a>';
		}
		return $links;
	}
	
	public function ___addPluginHiddenAdminMenu() {
		add_submenu_page( 'MADE Backup', 'MADE Backup', 'MADE Backup', 'manage_options', 'madelab-core-backup', array( $this, '___renderPluginHiddenAdminPageBackup' ) );
		add_submenu_page( 'MADE Restore', 'MADE Restore', 'MADE Restore', 'manage_options', 'madelab-core-restore', array( $this, '___renderPluginHiddenAdminPageRestore' ) );
		add_submenu_page( 'MADE Rebuild', 'MADE Rebuild', 'MADE Rebuild', 'manage_options', 'madelab-core-rebuild', array( $this, '___renderPluginHiddenAdminPageRebuild' ) );
		add_submenu_page( 'MADE Compress', 'MADE Compress', 'MADE Compress', 'manage_options', 'madelab-core-compress', array( $this, '___renderPluginHiddenAdminPageCompress' ) );
	}

	public function ___renderPluginHiddenAdminPageBackup() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'backup.php';
	}

	public function ___renderPluginHiddenAdminPageRestore() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'restore.php';
	}

	public function ___renderPluginHiddenAdminPageRebuild() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'rebuild.php';
	}

	public function ___renderPluginHiddenAdminPageCompress() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'compress.php';
	}

	public function ___addPluginAdminMenu() {
		add_menu_page( 
			esc_html__('MADE License Key', 'made-theme-options' ),
			esc_html__('MADE License Key', 'made-theme-options' ),
			'manage_options',
			'madelab_core_key_generator',
			array( $this, '___madelab_core_key_generator' ),
			'dashicons-admin-network',
			0
		);
		add_submenu_page(
			'made_theme_options',
			esc_html__('MADE License Key', 'made-theme-options' ),
			esc_html__('MADE License Key', 'made-theme-options' ),
			'manage_options',
			'madelab_core_key_generator',
			array( $this, '___madelab_core_key_generator' )
		);
		
	}

	public function ___madelab_core_key_generator() {
		require_once plugin_dir_path( __FILE__ ) . 'license.php';
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in N3COMMERCIALREALTY_CORE_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The N3COMMERCIALREALTY_CORE_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_register_style( 'wp_core_bt_admin_main_css',  plugin_dir_url( __FILE__ ) . 'vendor/bootstrap.min.css', array() );
		wp_enqueue_style('wp_core_bt_admin_main_css');
		wp_register_style( 'wp_core_admin_main_css',  plugin_dir_url( __FILE__ ) . 'assets/css/main.min.css', array() );
		wp_enqueue_style('wp_core_admin_main_css');
		wp_register_style( 'wp_core_admin_select2_css',  plugin_dir_url( __FILE__ ) . 'vendor/select2.min.css', array() );
		wp_enqueue_style('wp_core_admin_select2_css');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in N3COMMERCIALREALTY_CORE_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The N3COMMERCIALREALTY_CORE_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_register_script('wp_core_bt_admin_main_js', plugin_dir_url( __FILE__ ) . 'vendor/bootstrap.bundle.min.js', array('jquery'));
        wp_enqueue_script('wp_core_bt_admin_main_js');
		wp_register_script('wp_core_admin_main_js', plugin_dir_url( __FILE__ ) . 'assets/js/main.prod.js', array('jquery'));
        wp_enqueue_script('wp_core_admin_main_js');
		wp_register_script('wp_core_admin_select2_js', plugin_dir_url( __FILE__ ) . 'vendor/select2.min.js', array('jquery'));
		wp_enqueue_script('wp_core_admin_select2_js');

	}

	// public function enquere_admin_script_footer () {
	// 	wp_register_script('wp_core_admin_main_js_footer', plugin_dir_url( __FILE__ ) . 'assets/js/footer.prod.js', array('jquery'), '1.0.0', 'in_footer');
	// 	wp_enqueue_script('wp_core_admin_main_js_footer');
	// }
	

}
