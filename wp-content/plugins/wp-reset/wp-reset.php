<?php
/*
  Plugin Name: WP Reset
  Plugin URI: https://wpreset.com/
  Description: Reset the entire site or just selected parts while reserving the option to undo by using snapshots.
  Version: 2.04
  Requires at least: 4.0
  Requires PHP: 5.2
  Tested up to: 6.8
  License: GPLv2 or later
  Author: WebFactory Ltd
  Author URI: https://www.webfactoryltd.com/
  Text Domain: wp-reset

  Copyright 2015 - 2025  WebFactory Ltd  (email: wpreset@webfactoryltd.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// include only file
if (!defined('ABSPATH')) {
    die('Do not open this file directly.');
}


define('WP_RESET_FILE', __FILE__);

require_once dirname(__FILE__) . '/wp-reset-utility.php';
require_once dirname(__FILE__) . '/wp-reset-licensing.php';

require_once dirname(__FILE__) . '/wf-flyout/wf-flyout.php';
new wf_flyout(__FILE__);

// load WP-CLI commands, if needed
if (defined('WP_CLI') && WP_CLI) {
    require_once dirname(__FILE__) . '/wp-reset-cli.php';
}


class WP_Reset
{
    protected static $instance = null;
    public $version = 0;
    public $plugin_url = '';
    public $plugin_dir = '';
    public $snapshots_folder = 'wp-reset-snapshots-export';
    protected $options = array();
    private $delete_count = 0;
    private $licensing_servers = array('https://dashboard.wpreset.com/api/');
    public $core_tables = array('commentmeta', 'comments', 'links', 'options', 'postmeta', 'posts', 'term_relationships', 'term_taxonomy', 'termmeta', 'terms', 'usermeta', 'users');
    private $license = null;
    public $filesystem_initialized = false;

    /**
     * Creates a new WP_Reset object and implements singleton
     *
     * @return WP_Reset
     */
    static function getInstance()
    {
        if (!is_a(self::$instance, 'WP_Reset')) {
            self::$instance = new WP_Reset();
        }

        return self::$instance;
    } // getInstance


    /**
     * Initialize properties, hook to filters and actions
     *
     * @return null
     */
    private function __construct()
    {
        $this->version = $this->get_plugin_version();
        $this->plugin_dir = plugin_dir_path(__FILE__);
        $this->plugin_url = plugin_dir_url(__FILE__);
        $this->load_options();

        $this->license = new WF_Licensing(array(
            'prefix' => 'wpr',
            'licensing_servers' => $this->licensing_servers,
            'version' => $this->version,
            'plugin_file' => __FILE__,
            'plugin_page' => 'tools_page_wp-reset',
            'skip_hooks' => false,
            'debug' => true,
            'js_folder' => plugin_dir_url(__FILE__) . '/js/'
        ));

        add_action('admin_menu', array($this, 'admin_menu'));
        add_action('admin_init', array($this, 'do_all_actions'));
        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
        add_action('admin_action_wpr_dismiss_notice', array($this, 'action_dismiss_notice'));
        add_action('wp_ajax_wp_reset_dismiss_notice', array($this, 'ajax_dismiss_notice'));
        add_action('wp_ajax_wp_reset_run_tool', array($this, 'ajax_run_tool'));
        add_action('admin_print_scripts', array($this, 'remove_admin_notices'));
        add_action('admin_action_wpr_install_wpfssl', array($this, 'install_wpfssl'));

        add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'plugin_action_links'));
        add_filter('plugin_row_meta', array($this, 'plugin_meta_links'), 10, 2);
        add_filter('admin_footer_text', array($this, 'admin_footer_text'));

        $this->core_tables = array_map(function ($tbl) {
            global $wpdb;
            return $wpdb->prefix . $tbl;
        }, $this->core_tables);
    } // __construct


    /**
     * Get plugin version from file header
     *
     * @return string
     */
    function get_plugin_version()
    {
        $plugin_data = get_file_data(__FILE__, array('version' => 'Version'), 'plugin');

        return $plugin_data['version'];
    } // get_plugin_version


    /**
     * Load and prepare the options array
     * If needed create a new DB entry
     *
     * @return array
     */
    private function load_options()
    {
        $options = get_option('wp-reset', array());
        $change = false;

        if (!isset($options['meta'])) {
            $options['meta'] = array('first_version' => $this->version, 'first_install' => current_time('timestamp', true), 'reset_count' => 0);
            $change = true;
        }
        if (!isset($options['dismissed_notices'])) {
            $options['dismissed_notices'] = array();
            $change = true;
        }
        if (!isset($options['last_run'])) {
            $options['last_run'] = array();
            $change = true;
        }
        if (!isset($options['options'])) {
            $options['options'] = array();
            $change = true;
        }
        if ($change) {
            update_option('wp-reset', $options, true);
        }

        $this->options = $options;
        return $options;
    } // load_options


    /**
     * Get meta part of plugin options
     *
     * @return array
     */
    function get_meta()
    {
        return $this->options['meta'];
    } // get_meta


    /**
     * Get all dismissed notices, or check for one specific notice
     *
     * @param string  $notice_name  Optional. Check if specified notice is dismissed.
     *
     * @return bool|array
     */
    function get_dismissed_notices($notice_name = '')
    {
        $notices = $this->options['dismissed_notices'];

        if (empty($notice_name)) {
            return $notices;
        } else {
            if (empty($notices[$notice_name])) {
                return false;
            } else {
                return true;
            }
        }
    } // get_dismissed_notices


    /**
     * Get options part of plugin options
     *
     * @param string  $key  Optional.
     *
     * @return array
     */
    function get_options()
    {
        return $this->options['options'];
    } // get_options


    /**
     * Update specified plugin options key
     *
     * @param string  $key   Data to save.
     * @param string  $data  Option key.
     *
     * @return bool
     */
    function update_options($key, $data)
    {
        if (false === in_array($key, array('meta', 'license', 'dismissed_notices', 'options'))) {
            user_error('Unknown options key.', E_USER_ERROR);
            return false;
        }

        $this->options[$key] = $data;
        $tmp = update_option('wp-reset', $this->options);

        return $tmp;
    } // update_options


    /**
     * Add plugin menu entry under Tools menu
     *
     * @return null
     */
    function admin_menu()
    {
        add_management_page(__('WP Reset', 'wp-reset'), __('WP Reset', 'wp-reset'), 'administrator', 'wp-reset', array($this, 'plugin_page'));
    } // admin_menu


    /**
     * Dismiss notice via AJAX call
     *
     * @return null
     */
    function ajax_dismiss_notice()
    {
        check_ajax_referer('wp-reset_dismiss_notice');

        if (!current_user_can('manage_options')) {
            wp_send_json_error(__('You are not allowed to run this action.', 'wp-reset'));
        }

        if (!isset($_GET['notice_name'])) {
            wp_send_json_error(__('Unknown Notice.', 'wp-reset'));
        }

        $notice_name = trim(sanitize_text_field(wp_unslash($_GET['notice_name'])));
        if (!$this->dismiss_notice($notice_name)) {
            wp_send_json_error(__('Notice is already dismissed.', 'wp-reset'));
        } else {
            wp_send_json_success();
        }
    } // ajax_dismiss_notice


    /**
     * Dismiss notice via admin action
     *
     * @return null
     */
    function action_dismiss_notice()
    {
        if (!isset($_GET['notice']) || !isset($_GET['_wpnonce']) || false == wp_verify_nonce(sanitize_text_field(wp_unslash($_GET['_wpnonce'])), 'wpr_dismiss_notice')) {
            wp_die('Please reload the page and try again.');
        }

        if (empty($_GET['notice'])) {
            wp_safe_redirect(admin_url());
            exit;
        }

        $notice_name = trim(sanitize_text_field(wp_unslash($_GET['notice'])));
        $this->dismiss_notice($notice_name);

        if (!empty($_GET['redirect'])) {
            wp_safe_redirect(sanitize_url(wp_unslash($_GET['redirect'])));
        } else {
            wp_safe_redirect(admin_url());
        }

        exit;
    } // action_dismiss_notice


    /**
     * Dismiss notice by adding it to dismissed_notices options array
     *
     * @param string  $notice_name  Notice to dismiss.
     *
     * @return bool
     */
    function dismiss_notice($notice_name)
    {
        if ($this->get_dismissed_notices($notice_name)) {
            return false;
        } else {
            $notices = $this->get_dismissed_notices();
            $notices[$notice_name] = true;
            $this->update_options('dismissed_notices', $notices);
            return true;
        }
    } // dismiss_notice


    /**
     * Returns all WP pointers
     *
     * @return array
     */
    function get_pointers()
    {
        $pointers = array();

        $pointers['welcome'] = array('target' => '#menu-tools', 'edge' => 'left', 'align' => 'right', 'content' => 'Thank you for installing the <b style="font-weight: 800;">WP Reset</b> plugin!<br>Open <a href="' . esc_url(admin_url('tools.php?page=wp-reset')) . '">Tools - WP Reset</a> to access resetting tools and start developing &amp; debugging faster.');

        return $pointers;
    } // get_pointers


    /**
     * Enqueue CSS and JS files
     *
     * @return null
     */
    function admin_enqueue_scripts($hook)
    {
        // welcome pointer is shown on all pages except WPR to admins, until dismissed
        $pointers = $this->get_pointers();
        $dismissed_notices = $this->get_dismissed_notices();

        foreach ($dismissed_notices as $notice_name => $tmp) {
            if ($tmp) {
                unset($pointers[$notice_name]);
            }
        } // foreach

        if (!empty($pointers) && !$this->is_plugin_page() && current_user_can('manage_options')) {
            $pointers['_nonce_dismiss_pointer'] = wp_create_nonce('wp-reset_dismiss_notice');

            wp_enqueue_style('wp-pointer');

            wp_enqueue_script('wp-reset-pointers', $this->plugin_url . 'js/wp-reset-pointers.js', array('jquery'), $this->version, true);
            wp_enqueue_script('wp-pointer');
            wp_localize_script('wp-pointer', 'wp_reset_pointers', $pointers);
        }

        // exit early if not on WP Reset page
        if (!$this->is_plugin_page()) {
            return;
        }

        $js_localize = array(
            'undocumented_error' => __('An undocumented error has occurred. Please refresh the page and try again.', 'wp-reset'),
            'documented_error' => __('An error has occurred.', 'wp-reset'),
            'plugin_name' => __('WP Reset', 'wp-reset'),
            'settings_url' => admin_url('tools.php?page=wp-reset'),
            'wpfssl_install_url' => add_query_arg(array('action' => 'wpr_install_wpfssl', '_wpnonce' => wp_create_nonce('install_wpfssl'), 'rnd' => wp_rand()), admin_url('admin.php')),
            'icon_url' => $this->plugin_url . 'img/wp-reset-icon.png',
            'invalid_confirmation' => __('Please type "reset" in the confirmation field.', 'wp-reset'),
            'invalid_confirmation_title' => __('Invalid confirmation', 'wp-reset'),
            'cancel_button' => __('Cancel', 'wp-reset'),
            'ok_button' => __('OK', 'wp-reset'),
            'confirm_button' => __('Reset WordPress', 'wp-reset'),
            'confirm_title' => __('Are you sure you want to proceed?', 'wp-reset'),
            'confirm_title_reset' => __('Are you sure you want to reset the site?', 'wp-reset'),
            'confirm1' => __('Clicking "Reset WordPress" will reset your site to default values. All content will be lost. Always <a href="#" class="create-new-snapshot" data-description="Before resetting the site">create a snapshot</a> if you want to be able to undo.</b>', 'wp-reset'),
            'confirm2' => __('Click "Cancel" to abort.', 'wp-reset'),
            'doing_reset' => __('Resetting in progress. Please wait.', 'wp-reset'),
            'snapshot_success' => __('Snapshot created', 'wp-reset'),
            'snapshot_wait' => __('Creating snapshot. Please wait.', 'wp-reset'),
            'snapshot_confirm' => __('Create snapshot', 'wp-reset'),
            'snapshot_placeholder' => __('Snapshot name or brief description, ie: before plugin install', 'wp-reset'),
            'snapshot_text' => __('Enter snapshot name or brief description', 'wp-reset'),
            'snapshot_title' => __('Create a new snapshot', 'wp-reset'),
            'nonce_dismiss_notice' => wp_create_nonce('wp-reset_dismiss_notice'),
            'activating' => __('Activating', 'wp-reset'),
            'deactivating' => __('Deactivating', 'wp-reset'),
            'deleting' => __('Deleting', 'wp-reset'),
            'installing' => __('Installing', 'wp-reset'),
            'activate_failed' => __('Could not activate', 'wp-reset'),
            'deactivate_failed' => __('Could not deactivate', 'wp-reset'),
            'delete_failed' => __('Could not delete', 'wp-reset'),
            'install_failed' => __('Could not install', 'wp-reset'),
            'install_failed_existing' => __('is already installed', 'wp-reset'),
            'nonce_run_tool' => wp_create_nonce('wp-reset_run_tool'),
            'nonce_do_reset' => wp_create_nonce('wp-reset_do_reset'),
        );

        wp_enqueue_style('plugin-install');
        wp_enqueue_style('wp-jquery-ui-dialog');
        wp_enqueue_style('wp-reset', $this->plugin_url . 'css/wp-reset.css', array(), $this->version);
        wp_enqueue_style('wp-reset-sweetalert2', $this->plugin_url . 'css/sweetalert2.min.css', array(), $this->version);
        wp_enqueue_style('wp-reset-tooltipster', $this->plugin_url . 'css/tooltipster.bundle.min.css', array(), $this->version);

        wp_enqueue_script('plugin-install');
        wp_enqueue_script('jquery-ui-tabs');
        wp_enqueue_script('jquery-ui-dialog');
        wp_enqueue_script('wp-reset-sweetalert2', $this->plugin_url . 'js/wp-reset-libs.min.js', array('jquery'), $this->version, true);
        wp_enqueue_script('wp-reset', $this->plugin_url . 'js/wp-reset.js', array('jquery'), $this->version, true);
        wp_localize_script('wp-reset', 'wp_reset', $js_localize);

        add_thickbox();

        // fix for aggressive plugins that include their CSS on all pages
        wp_dequeue_style('uiStyleSheet');
        wp_dequeue_style('wpcufpnAdmin');
        wp_dequeue_style('unifStyleSheet');
        wp_dequeue_style('wpcufpn_codemirror');
        wp_dequeue_style('wpcufpn_codemirrorTheme');
        wp_dequeue_style('collapse-admin-css');
        wp_dequeue_style('jquery-ui-css');
        wp_dequeue_style('tribe-common-admin');
        wp_dequeue_style('file-manager__jquery-ui-css');
        wp_dequeue_style('file-manager__jquery-ui-css-theme');
        wp_dequeue_style('wpmegmaps-jqueryui');
        wp_dequeue_style('wp-botwatch-css');
        wp_dequeue_style('uap_main_admin_style');
        wp_dequeue_style('uap_font_awesome');
        wp_dequeue_style('uap_jquery-ui.min.css');
    } // admin_enqueue_scripts


    /**
     * Remove all WP notices on WPR page
     *
     * @return null
     */
    function remove_admin_notices()
    {
        if (!$this->is_plugin_page()) {
            return false;
        }

        global $wp_filter;
        unset($wp_filter['user_admin_notices'], $wp_filter['admin_notices']);
    } // remove_admin_notices


    /**
     * Check if WP-CLI is available and running
     *
     * @return bool
     */
    static function is_cli_running()
    {
        if (!is_null($value = apply_filters('wp-reset-override-is-cli-running', null))) {
            return (bool) $value;
        }

        if (defined('WP_CLI') && WP_CLI) {
            return true;
        } else {
            return false;
        }
    } // is_cli_running


    /**
     * Check if given plugin is installed
     *
     * @param [string] $slug Plugin slug
     * @return boolean
     */
    function is_plugin_installed($slug)
    {
        if (!function_exists('get_plugins')) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }
        $all_plugins = get_plugins();

        if (!empty($all_plugins[$slug])) {
            return true;
        } else {
            return false;
        }
    } // is_plugin_installed


    /**
     * Deletes all transients.
     *
     * @return int  Number of deleted transient DB entries
     */
    function do_delete_transients()
    {
        global $wpdb;

        // phpcs:ignore db call warning as we are using uncommon queries
        $count = $wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE '\_transient\_%' OR option_name LIKE '\_site\_transient\_%'"); // phpcs:ignore

        wp_cache_flush();

        do_action('wp_reset_delete_transients', $count);

        return $count;
    } // do_delete_transients


    /**
     * Purge all cache for popular caching plugins
     *
     * @return bool true
     */
    function do_purge_cache()
    {
        global $wp_reset;

        wp_cache_flush();
        $wp_reset->do_delete_transients();

        if (function_exists('w3tc_flush_all')) {
            w3tc_flush_all();
        }
        if (function_exists('wp_cache_clear_cache')) {
            wp_cache_clear_cache();
        }
        if (method_exists('LiteSpeed_Cache_API', 'purge_all')) {
            LiteSpeed_Cache_API::purge_all();
        }
        if (class_exists('Endurance_Page_Cache')) {
            $epc = new Endurance_Page_Cache;
            $epc->purge_all();
        }
        if (class_exists('SG_CachePress_Supercacher') && method_exists('SG_CachePress_Supercacher', 'purge_cache')) {
            SG_CachePress_Supercacher::purge_cache(true);
        }
        if (class_exists('SiteGround_Optimizer\Supercacher\Supercacher')) {
            SiteGround_Optimizer\Supercacher\Supercacher::purge_cache();
        }
        if (isset($GLOBALS['wp_fastest_cache']) && method_exists($GLOBALS['wp_fastest_cache'], 'deleteCache')) {
            $GLOBALS['wp_fastest_cache']->deleteCache(true);
        }
        if (is_callable(array('Swift_Performance_Cache', 'clear_all_cache'))) {
            Swift_Performance_Cache::clear_all_cache();
        }
        if (is_callable(array('Hummingbird\WP_Hummingbird', 'flush_cache'))) {
            Hummingbird\WP_Hummingbird::flush_cache(true, false);
        }

        do_action('wp_reset_purge_cache');

        return true;
    } // do_purge_cache


    /**
     * Resets all theme options (mods).
     *
     * @param bool $all_themes Delete mods for all themes or just the current one
     *
     * @return int  Number of deleted mod DB entries
     */
    function do_reset_theme_options($all_themes = true)
    {
        global $wpdb;

        // phpcs:ignore db call warning as we are using uncommon queries
        $count = $wpdb->query($wpdb->prepare("DELETE FROM $wpdb->options WHERE option_name LIKE %s OR option_name LIKE %s", array('mods\_%', 'theme_mods\_%'))); // phpcs:ignore

        do_action('wp_reset_reset_theme_options', $count);

        return $count;
    } // do_reset_theme_options


    /**
     * Deletes all files in uploads folder.
     *
     * @return int  Number of deleted files and folders.
     */
    function do_delete_uploads()
    {
        global $wp_filesystem;
		$this->wp_init_filesystem();
        
        $upload_dir = wp_get_upload_dir();
        $this->delete_count = 0;

        if ( $wp_filesystem->is_dir( $upload_dir['basedir'] ) ) {

            // Get all files and directories in the folder.
            $files = $wp_filesystem->dirlist( $upload_dir['basedir'] );
        
            // Loop through the files and delete them.
            foreach ( $files as $file => $details ) {
                $file_path = trailingslashit( $upload_dir['basedir'] ) . $file;
                $wp_filesystem->delete( $file_path, true );
                $this->delete_count++;
            }
        }

        do_action('wp_reset_delete_uploads', $this->delete_count);

        return $this->delete_count;
    } // do_delete_uploads

    /**
     * Deactivate all plugins
     *
     * @param array  keep_wp_reset - Keep WP Reset active and installed, silent_deactivate - Skip individual plugin deactivation functions when deactivating
     *
     * @return int  Number of deactivated plugins.
     */
    function do_deactivate_plugins($params = array())
    {
        if (!function_exists('get_plugins')) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }
        if (!function_exists('request_filesystem_credentials')) {
            require_once ABSPATH . 'wp-admin/includes/file.php';
        }

        $wp_reset_basename = plugin_basename(WP_RESET_FILE);
        $params = shortcode_atts(array('keep_wp_reset' => true, 'silent_deactivate' => false), (array) $params);

        $active_plugins = (array) get_option('active_plugins', array());
        if ($params['keep_wp_reset']) {
            if (($key = array_search($wp_reset_basename, $active_plugins)) !== false) {
                unset($active_plugins[$key]);
            }
        }

        if (!empty($active_plugins)) {
            deactivate_plugins($active_plugins, $params['silent_deactivate'], false);
        }

        do_action('wp_reset_deactivate_plugins', $active_plugins, $params);

        return sizeof($active_plugins);
    } // do_deactivate_plugins


    /**
     * Delete all plugins
     *
     * @param array  keep_wp_reset - Keep WP Reset active and installed
     *
     * @return int  Number of deleted plugins.
     */
    function do_delete_plugins($params = array())
    {
        if (!function_exists('get_plugins')) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }
        if (!function_exists('request_filesystem_credentials')) {
            require_once ABSPATH . 'wp-admin/includes/file.php';
        }

        $wp_reset_basename = plugin_basename(WP_RESET_FILE);
        $params = shortcode_atts(array('keep_wp_reset' => true), (array) $params);

        $all_plugins = get_plugins();
        if ($params['keep_wp_reset']) {
            unset($all_plugins[$wp_reset_basename]);
        }

        if (!empty($all_plugins)) {
            delete_plugins(array_keys($all_plugins));
        }

        do_action('wp_reset_delete_plugins', $all_plugins, $params);

        return sizeof($all_plugins);
    } // do_delete_plugins


    /**
     * Delete all themes
     *
     * @param bool  $keep_default_theme  Keep default theme
     *
     * @return int  Number of deleted themes.
     */
    function do_delete_themes($keep_default_theme = true)
    {
        global $wp_version;

        if (!function_exists('delete_theme')) {
            require_once ABSPATH . 'wp-admin/includes/theme.php';
        }

        if (!function_exists('request_filesystem_credentials')) {
            require_once ABSPATH . 'wp-admin/includes/file.php';
        }

        if (version_compare($wp_version, '5.0', '<') === true) {
            $default_theme = 'twentyseventeen';
        } else {
            $default_theme = 'twentytwentyone';
        }

        $all_themes = wp_get_themes(array('errors' => null));

        if (true == $keep_default_theme) {
            unset($all_themes[$default_theme]);
        }

        foreach ($all_themes as $theme_slug => $theme_details) {
            $res = delete_theme($theme_slug);
        }

        if (false == $keep_default_theme) {
            update_option('template', '');
            update_option('stylesheet', '');
            update_option('current_theme', '');
        }

        do_action('wp_reset_delete_themes', $all_themes);

        return sizeof($all_themes);
    } // do_delete_themes


    /**
     * Truncate custom tables
     *
     * @return int  Number of truncated tables.
     */
    function do_truncate_custom_tables()
    {
        global $wpdb;
        $custom_tables = $this->get_custom_tables();

        foreach ($custom_tables as $tbl) {
            $wpdb->wpreset_custom_table = $tbl['name'];
            // phpcs:ignore db call warning as we are using uncommon queries
            $wpdb->query('SET foreign_key_checks = 0'); // phpcs:ignore
            $wpdb->query("TRUNCATE TABLE " . $wpdb->wpreset_custom_table); // phpcs:ignore
        } // foreach

        do_action('wp_reset_truncate_custom_tables', $custom_tables);

        return sizeof($custom_tables);
    } // do_truncate_custom_tables


    /**
     * Drop custom tables
     *
     * @return int  Number of dropped tables.
     */
    function do_drop_custom_tables()
    {
        global $wpdb;
        $custom_tables = $this->get_custom_tables();

        foreach ($custom_tables as $tbl) {
            $wpdb->wpreset_custom_table = $tbl['name'];
            // phpcs:ignore db call warning as we are using uncommon queries
            $wpdb->query('SET foreign_key_checks = 0'); // phpcs:ignore
            $wpdb->query("DROP TABLE IF EXISTS " . $wpdb->wpreset_custom_table); // phpcs:ignore
        } // foreach

        do_action('wp_reset_drop_custom_tables', $custom_tables);

        return sizeof($custom_tables);
    } // do_drop_custom_tables


    /**
     * Delete .htaccess file
     *
     * @return bool|WP_Error Action status.
     */
    function do_delete_htaccess()
    {
        global $wp_filesystem;

        if (empty($wp_filesystem)) {
            require_once ABSPATH . '/wp-admin/includes/file.php';
            WP_Filesystem();
        }

        $htaccess_path = $this->get_htaccess_path();
        clearstatcache();

        do_action('wp_reset_delete_htaccess', $htaccess_path);

        if (!$wp_filesystem->is_readable($htaccess_path)) {
            return new WP_Error(1, 'Htaccess file does not exist; there\'s nothing to delete.');
        }

        if (!$wp_filesystem->is_writable($htaccess_path)) {
            return new WP_Error(1, 'Htaccess file is not writable.');
        }

        if ($wp_filesystem->delete($htaccess_path, false, 'f')) {
            return true;
        } else {
            return new WP_Error(1, 'Unknown error. Unable to delete htaccess file.');
        }
    } // do_delete_htaccess


    /**
     * Get .htaccess file path.
     *
     * @return string
     */
    function get_htaccess_path()
    {
        if (!function_exists('get_home_path')) {
            require_once ABSPATH . 'wp-admin/includes/file.php';
        }

        if ($this->is_cli_running()) {
            $_SERVER['SCRIPT_FILENAME'] = ABSPATH;
        }

        $filepath = get_home_path() . '.htaccess';

        return $filepath;
    } // get_htaccess_path


    /**
     * Run one tool via AJAX call
     *
     * @return null
     */
    function ajax_run_tool()
    {
        check_ajax_referer('wp-reset_run_tool');

        if (!current_user_can('manage_options')) {
            wp_send_json_error(__('You are not allowed to run this action.', 'wp-reset'));
        }

        if(!isset($_GET['tool'])){
            wp_send_json_error(__('Unknown tool.', 'wp-reset'));
        }

        $tool = trim(sanitize_text_field(wp_unslash($_GET['tool'])));

        if(isset($_GET['extra_data'])){
            $extra_data = trim(sanitize_text_field(wp_unslash($_GET['extra_data'])));
        } else {
            $extra_data = '';
        }

        if ($tool == 'delete_transients') {
            $cnt = $this->do_delete_transients();
            wp_send_json_success($cnt);
        } elseif ($tool == 'reset_theme_options') {
            $cnt = $this->do_reset_theme_options(true);
            wp_send_json_success($cnt);
        } elseif ($tool == 'purge_cache') {
            $this->do_purge_cache();
            wp_send_json_success();
        } elseif ($tool == 'delete_wp_cookies') {
            wp_clear_auth_cookie();
            wp_send_json_success();
        } elseif ($tool == 'delete_themes') {
            $cnt = $this->do_delete_themes(false);
            wp_send_json_success($cnt);
        } elseif ($tool == 'deactivate_plugins') {
            $cnt = $this->do_deactivate_plugins($extra_data);
            wp_send_json_success($cnt);
        } elseif ($tool == 'delete_plugins') {
            $cnt = $this->do_delete_plugins($extra_data);
            wp_send_json_success($cnt);
        } elseif ($tool == 'delete_uploads') {
            $cnt = $this->do_delete_uploads();
            wp_send_json_success($cnt);
        } elseif ($tool == 'delete_htaccess') {
            $tmp = $this->do_delete_htaccess();
            if (is_wp_error($tmp)) {
                wp_send_json_error($tmp->get_error_message());
            } else {
                wp_send_json_success($tmp);
            }
        } elseif ($tool == 'drop_custom_tables') {
            $cnt = $this->do_drop_custom_tables();
            wp_send_json_success($cnt);
        } elseif ($tool == 'truncate_custom_tables') {
            $cnt = $this->do_truncate_custom_tables();
            wp_send_json_success($cnt);
        } elseif ($tool == 'delete_snapshot') {
            $res = $this->do_delete_snapshot($extra_data);
            if (is_wp_error($res)) {
                wp_send_json_error($res->get_error_message());
            } else {
                wp_send_json_success();
            }
        } elseif ($tool == 'download_snapshot') {
            $res = $this->do_export_snapshot($extra_data);
            if (is_wp_error($res)) {
                wp_send_json_error($res->get_error_message());
            } else {
                $url = content_url() . '/' . $this->snapshots_folder . '/' . $res;
                wp_send_json_success($url);
            }
        } elseif ($tool == 'restore_snapshot') {
            $res = $this->do_restore_snapshot($extra_data);
            if (is_wp_error($res)) {
                wp_send_json_error($res->get_error_message());
            } else {
                wp_send_json_success();
            }
        } elseif ($tool == 'compare_snapshots') {
            $res = $this->do_compare_snapshots($extra_data);
            if (is_wp_error($res)) {
                wp_send_json_error($res->get_error_message());
            } else {
                wp_send_json_success($res);
            }
        } elseif ($tool == 'create_snapshot') {
            $res = $this->do_create_snapshot($extra_data);
            if (is_wp_error($res)) {
                wp_send_json_error($res->get_error_message());
            } else {
                wp_send_json_success();
            }
        } elseif ($tool == 'get_table_details') {
            $res = WP_Reset_Utility::get_table_details();
            wp_send_json_success($res);
        } elseif (
            $tool == 'check_deactivate_plugin' ||
            $tool == 'check_delete_plugin' ||
            $tool == 'check_install_plugin' ||
            $tool == 'check_activate_plugin'
        ) {
            if(!isset($_GET['slug'])){
                wp_send_json_success('unknown plugin');
            }
            
            $slug = sanitize_text_field(wp_unslash($_GET['slug']));
            $path = $this->get_plugin_path($slug);

            if (false !== ($error = get_transient('wf_install_error_' . $slug))) {
                delete_transient('wf_install_error_' . $slug);
                wp_send_json_success($error);
            }

            if (false !== $path) {
                $active_plugins = (array) get_option('active_plugins', array());
                if (false !== array_search($path, $active_plugins)) {
                    wp_send_json_success('active');
                } else {
                    wp_send_json_success('inactive');
                }
            } else {
                wp_send_json_success('deleted');
            }
        } elseif ($tool == 'install_plugin') {
            if(!isset($_GET['slug'])){
                wp_send_json_success('unknown plugin');
            }
            
            $slug = sanitize_text_field(wp_unslash($_GET['slug']));

            @include_once ABSPATH . 'wp-admin/includes/plugin.php';
            @include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
            @include_once ABSPATH . 'wp-admin/includes/plugin-install.php';
            @include_once ABSPATH . 'wp-admin/includes/file.php';
            @include_once ABSPATH . 'wp-admin/includes/misc.php';

            wp_cache_flush();

            $path = $this->get_plugin_path($slug);

            if (false !== $path) {
                // Plugin is already installed
                wp_send_json_success();
            } else {
                // Install Plugin
                $skin      = new WP_Ajax_Upgrader_Skin();
                $upgrader = new Plugin_Upgrader($skin);
                $upgrader->install('https://downloads.wordpress.org/plugin/' . $slug . '.latest-stable.zip');
                wp_send_json_success();
            }
        } elseif ($tool == 'activate_plugin') {
            if(!isset($_GET['slug'])){
                wp_send_json_success('unknown plugin');
            }
            
            $slug = sanitize_text_field(wp_unslash($_GET['slug']));

            $path = $this->get_plugin_path($slug);
            activate_plugin($path);
            wp_send_json_success();
        } elseif ($tool == 'before_reset') {
            $active_plugins = get_option('active_plugins');
            set_transient('wpr_active_plugins', $active_plugins, 100);
            remove_all_actions('update_option_active_plugins');
            update_option('active_plugins', array(plugin_basename(__FILE__)));
            wp_send_json_success();
        } else {
            wp_send_json_error(__('Unknown tool.', 'wp-reset'));
        }
    } // ajax_run_tool


    /**
     * Get plugin path from slug
     *
     * @return string path
     */
    function get_plugin_path($slug)
    {
        $all_plugins = get_plugins();
        foreach ($all_plugins as $plugin_path => $plugin) {
            if (strpos($plugin_path, $slug . '/') === 0) {
                return $plugin_path;
            }
        }
        return false;
    } // get_plugin_path


    /**
     * Reinstall / reset the WP site
     * There are no failsafes in the function - it reinstalls when called
     * Redirects when done
     *
     * @param array  $params  Optional.
     *
     * @return null
     */
    function do_reinstall($params = array())
    {
        global $current_user, $wpdb;

        // only admins can reset; double-check
        if (!$this->is_cli_running() && !current_user_can('manage_options')) {
            return false;
        }

        // make sure the function is available to us
        if (!function_exists('wp_install')) {
            require ABSPATH . '/wp-admin/includes/upgrade.php';
        }

        // save values that need to be restored after reset
        $blogname = get_option('blogname');
        $blog_public = get_option('blog_public');
        $wplang = get_option('wplang');
        $siteurl = get_option('siteurl');
        $home = get_option('home');
        $snapshots = $this->get_snapshots();

        $active_plugins = get_transient('wpr_active_plugins');
        $active_theme = wp_get_theme();

        // for WP-CLI
        if (!$current_user->ID) {
            $tmp = get_users(array('role' => 'administrator', 'order' => 'ASC', 'order_by' => 'ID'));
            if (empty($tmp[0]->user_login)) {
                return new WP_Error(1, 'Reset failed. Unable to find any admin users in database.');
            }
            $current_user = $tmp[0];
        }

        // delete custom tables with WP's prefix
        $prefix = str_replace('_', '\_', $wpdb->prefix);

        // phpcs:ignore db call warning as we are using uncommon queries
        $tables = $wpdb->get_col($wpdb->prepare("SHOW TABLES LIKE %s", array($prefix . '%'))); // phpcs:ignore

        foreach ($tables as $table) {
            $wpdb->wpreset_table = $table;
            $wpdb->query("DROP TABLE " . $wpdb->wpreset_table); // phpcs:ignore
        }

        $old_user_pass = $current_user->user_pass;

        // suppress errors for WP_CLI
        $result = @wp_install($blogname, $current_user->user_login, $current_user->user_email, $blog_public, '', md5(wp_rand()), $wplang);
        $user_id = $result['user_id'];

        // restore user pass
        // phpcs:ignore db call warning as we are using uncommon queries
        $wpdb->query($wpdb->prepare("UPDATE {$wpdb->users} SET user_pass = %s, user_activation_key = %s WHERE ID = %d LIMIT 1", array($old_user_pass, '', $user_id))); // phpcs:ignore
        $current_user->user_pass = $old_user_pass;

        // restore rest of the settings including WP Reset's
        update_option('siteurl', $siteurl);
        update_option('home', $home);
        update_option('wp-reset', $this->options);
        update_option('wp-reset-snapshots', $snapshots);

        // remove password nag
        if (get_user_meta($user_id, 'default_password_nag')) {
            update_user_meta($user_id, 'default_password_nag', false);
        }
        if (get_user_meta($user_id, $wpdb->prefix . 'default_password_nag')) {
            update_user_meta($user_id, $wpdb->prefix . 'default_password_nag', false);
        }

        $meta = $this->get_meta();
        $meta['reset_count']++;
        $this->update_options('meta', $meta);

        // reactivate theme
        if (!empty($params['reactivate_theme'])) {
            switch_theme($active_theme->get_stylesheet());
        }

        // reactivate WP Reset
        if (!empty($params['reactivate_wpreset'])) {
            activate_plugin(plugin_basename(__FILE__));
        }

        // reactivate all plugins
        if (!empty($params['reactivate_plugins'])) {
            foreach ($active_plugins as $plugin_file) {
                activate_plugin($plugin_file);
            }
        }

        if (!$this->is_cli_running()) {
            // log out and log in the old/new user
            // since the password doesn't change this is potentially unnecessary
            wp_clear_auth_cookie();
            wp_set_auth_cookie($user_id);

            wp_safe_redirect(admin_url() . '?wp-reset=success');
            exit;
        }
    } // do_reinstall


    /**
     * Checks wp_reset post value and performs all actions
     *
     * @return null|bool
     */
    function do_all_actions()
    {
        // only admins can perform actions
        if (!current_user_can('manage_options')) {
            return;
        }

        if (!empty($_GET['wp-reset']) && sanitize_text_field(wp_unslash($_GET['wp-reset'])) == 'success') {
            add_action('admin_notices', array($this, 'notice_successful_reset'));
        }

        // check nonce
        if (true === isset($_POST['wp_reset_confirm']) && (!isset($_POST['_wpnonce']) || false === wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['_wpnonce'])), 'wp-reset'))) {
            add_settings_error('wp-reset', 'bad-nonce', __('Something went wrong. Please refresh the page and try again.', 'wp-reset'), 'error');
            return false;
        }

        // check confirmation code
        if (true === isset($_POST['wp_reset_confirm']) && 'reset' !== sanitize_text_field(wp_unslash($_POST['wp_reset_confirm']))) {
            add_settings_error('wp-reset', 'bad-confirm', __('<b>Invalid confirmation code.</b> Please type "reset" in the confirmation field.', 'wp-reset'), 'error');
            return false;
        }

        // only one action at the moment
        if (true === isset($_POST['wp_reset_confirm']) && 'reset' === sanitize_text_field(wp_unslash($_POST['wp_reset_confirm']))) {
            $params = array(
                'reactivate_theme' => '0',
                'reactivate_plugins' => '0',
                'reactivate_wpreset' => '0',
            );
            if (isset($_POST['wpr-post-reset']['reactivate_theme'])) {
                $params['reactivate_theme'] = true;
            }
            if (isset($_POST['wpr-post-reset']['reactivate_plugins'])) {
                $params['reactivate_plugins'] = true;
            }
            if (isset($_POST['wpr-post-reset']['reactivate_wpreset'])) {
                $params['reactivate_wpreset'] = true;
            }

            $this->do_reinstall($params);
        }
    } // do_all_actions


    /**
     * Add "Open WP Reset Tools" action link to plugins table, left part
     *
     * @param array  $links  Initial list of links.
     *
     * @return array
     */
    function plugin_action_links($links)
    {
        $settings_link = '<a href="' . esc_url(admin_url('tools.php?page=wp-reset')) . '" title="' . esc_attr(__('Open WP Reset Tools', 'wp-reset')) . '">' . esc_html(__('Open WP Reset Tools', 'wp-reset')) . '</a>';

        array_unshift($links, $settings_link);

        return $links;
    } // plugin_action_links


    /**
     * Add links to plugin's description in plugins table
     *
     * @param array  $links  Initial list of links.
     * @param string $file   Basename of current plugin.
     *
     * @return array
     */
    function plugin_meta_links($links, $file)
    {
        if ($file !== plugin_basename(__FILE__)) {
            return $links;
        }

        $support_link = '<a target="_blank" href="https://wordpress.org/support/plugin/wp-reset" title="' . __('Get help', 'wp-reset') . '">' . __('Support', 'wp-reset') . '</a>';
        $home_link = '<a target="_blank" href="' . esc_url($this->generate_web_link('plugins-table-right')) . '" title="' . __('Plugin Homepage', 'wp-reset') . '">' . __('Plugin Homepage', 'wp-reset') . '</a>';
        $rate_link = '<a target="_blank" href="https://wordpress.org/support/plugin/wp-reset/reviews/#new-post" title="' . __('Rate the plugin', 'wp-reset') . '">' . __('Rate the plugin ★★★★★', 'wp-reset') . '</a>';

        $links[] = $support_link;
        $links[] = $home_link;
        $links[] = $rate_link;

        return $links;
    } // plugin_meta_links


    /**
     * Test if we're on WPR's admin page
     *
     * @return bool
     */
    function is_plugin_page()
    {
        $current_screen = get_current_screen();

        if (!empty($current_screen->id) && $current_screen->id == 'tools_page_wp-reset') {
            return true;
        } else {
            return false;
        }
    } // is_plugin_page


    /**
     * Add powered by text in admin footer
     *
     * @param string  $text  Default footer text.
     *
     * @return string
     */
    function admin_footer_text($text)
    {
        if (!$this->is_plugin_page()) {
            return $text;
        }

        $text = '<i><a href="' . esc_url($this->generate_web_link('admin_footer')) . '" title="' . esc_attr(__('Visit WP Reset page for more info', 'wp-reset')) . '" target="_blank">WP Reset</a> v' . $this->version . '. Please <a target="_blank" href="https://wordpress.org/support/plugin/wp-reset/reviews/#new-post" title="Rate the plugin">rate the plugin <span>★★★★★</span></a> to help us spread the word. Thank you from the WP Reset team!</i>';

        return $text;
    } // admin_footer_text


    /**
     * Loads plugin's translated strings
     *
     * @return null
     */
    function load_textdomain()
    {
        load_plugin_textdomain('wp-reset');
    } // load_textdomain


    /**
     * Inform the user that WordPress has been successfully reset
     *
     * @return null
     */
    function notice_successful_reset()
    {
        global $current_user;
        /* translators: %1$s is replaced with the current user's username, %2$s is replaced with the URL to WP Reset settings page */
        WP_Reset_Utility::wp_kses_wf('<div style="padding: 15px; display: inline-block; font-size: 14px;" id="message" class="updated"><p style="font-size: 14px;">' . sprintf(__('<b>Site has been successfully reset to default settings.</b><br>User "%1$s" was restored with the password unchanged. Open <a href="%2$s">WP Reset</a> to do another reset.', 'wp-reset'), esc_html($current_user->user_login), esc_url(admin_url('tools.php?page=wp-reset'))) . '</p>');


        if (false == $this->get_dismissed_notices('rate')) {
            $request_url = isset($_SERVER['REQUEST_URI'])?sanitize_url(wp_unslash($_SERVER['REQUEST_URI'])):'';
            $dismiss_url = add_query_arg(array('action' => 'wpr_dismiss_notice', 'notice' => 'rate', 'redirect' => urlencode($request_url)), admin_url('admin.php'));
            $dismiss_url = wp_nonce_url($dismiss_url, 'wpr_dismiss_notice');

            echo '<p style="font-size: 14px;">';
            echo 'If WP Reset helped you please rate it so we can continue supporting it and helping others. Thank you!<br>';
            echo '<a style="margin-top: 5px;" class="button button-secondary" href="https://wordpress.org/support/plugin/wp-reset/reviews/#new-post" target="_blank">You deserve it, I\'ll rate it!</a> &nbsp; &nbsp; <a href="' . esc_url($dismiss_url) . '">I already rated it</a>';
            echo '</p>';
        }

        echo '</div>';
    } // notice_successful_reset


    /**
     * Generate a button that initiates snapshot creation
     *
     * @param string  $tool_id  Tool ID.
     * @param string  $description  Snapshot description.
     *
     * @return string
     */
    function get_snapshot_button($tool_id = '', $description = '')
    {
        $out = '';
        $out .= '<a data-tool-id="' . esc_attr($tool_id) . '" data-description="' . esc_attr($description) . '" class="button create-new-snapshot" href="#">Create snapshot</a>';

        return $out;
    } // get_snapshot_button


    /**
     * Generate card header including title and action buttons
     *
     * @param string  $title  Card title.
     * @param string  $card_id  Card element #ID.
     * @param array  $params  Individual icons arguments
     *
     * @return string
     */
    function get_card_header($title, $card_id, $params = array())
    {
        $params = shortcode_atts(array(
            'documentation_link' => false,
            'iot_button' => false,
            'collapse_button' => false,
            'create_snapshot' => false,
            'pro' => false
        ), (array) $params);

        if ($params['documentation_link'] === true) {
            $params['documentation_link'] = $card_id;
        }

        $out = '';
        $out .= '<h4 id="' . esc_attr($card_id) . '"><span class="card-name">' . esc_html($title);
        if ($params['pro']) {
            $out .= ' - <a data-feature="' . esc_attr($card_id) . '" class="pro-feature tooltip" title="WP Reset PRO tool" href="#"><span class="pro">PRO</span> tool</a>';
        }
        $out .= '</span>';
        $out .= '<div class="card-header-right">';
        if ($params['documentation_link']) {
            $out .= '<a class="documentation-link tooltip" href="' . esc_url($this->generate_web_link('documentation_link', '/documentation/')) . '" title="' . __('Open documentation for this tool', 'wp-reset') . '" target="blank"><span class="dashicons dashicons-editor-help"></span></a>';
        }
        if ($params['iot_button']) {
            $out .= '<a class="scrollto tooltip" href="#iot" title="Jump to Index of Tools"><span class="dashicons dashicons-screenoptions"></span></a>';
        }
        if ($params['create_snapshot']) {
            $out .= '<a id="create-new-snapshot-primary" title="Create a new snapshot" href="#" class="button button-primary create-new-snapshot tooltip">' . __('Create Snapshot', 'wp-reset') . '</a>';
        }
        if ($params['collapse_button']) {
            $out .= '<a class="toggle-card tooltip" href="#" title="' . __('Collapse / expand box', 'wp-reset') . '"><span class="dashicons dashicons-arrow-up-alt2"></span></a>';
        }
        $out .= '</div></h4>';

        return $out;
    } // get_card_header


    /**
     * Generate tool icons and description detailing what it modifies
     *
     * @param bool  $modify_files  Does the tool modify files?
     * @param bool  $modify_db  Does the tool modify the database?
     * @param bool  $plural  Is there more than one tool in the set?
     *
     * @return string
     */
    function get_tool_icons($modify_files = false, $modify_db = false, $plural = false)
    {
        $out = '';
        $modify_files = (bool) $modify_files;
        $modify_db = (bool) $modify_db;
        $plural = (bool) $plural;

        $out .= '<p class="tool-icons">';
        $out .= '<i class="icon-doc-text-inv' . ($modify_files ? ' red' : '') . '"></i> ';
        $out .= '<i class="icon-database' . ($modify_db ? ' red' : '') . '"></i> ';

        if ($plural) {
            if ($modify_files && $modify_db) {
                $out .= 'these tools <b>modify files &amp; the database</b>';
            } elseif (!$modify_files && $modify_db) {
                $out .= 'these tools <b>modify the database</b> but they don\'t modify any files</b>';
            } elseif ($modify_files && !$modify_db) {
                $out .= 'these tools <b>modify files</b> but they don\'t modify the database</b>';
            }
        } else {
            if ($modify_files && $modify_db) {
                $out .= 'this tool <b>modifies files &amp; the database</b>';
            } elseif (!$modify_files && $modify_db) {
                $out .= 'this tool <b>modifies the database</b> but it doesn\'t modify any files</b>';
            } elseif ($modify_files && !$modify_db) {
                $out .= 'this tool <b>modifies files</b> but it doesn\'t modify the database</b>';
            } else {
                $out .= 'this tool doesn\'t modify files or the database';
            }
        }
        $out .= '</p>';

        return $out;
    } // get_tool_icons


    /**
     * Outputs complete plugin's admin page
     *
     * @return null
     */
    function plugin_page()
    {
        // double check for admin privileges
        if (!current_user_can('manage_options')) {
            wp_die(esc_html__('Sorry, you are not allowed to access this page.', 'wp-reset'));
        }

        echo '<div class="wrap">';
        echo '<form id="wp_reset_form" action="' . esc_url(admin_url('tools.php?page=wp-reset')) . '" method="post" autocomplete="off">';

        echo '<header>';
        echo '<div class="wpr-container">';
        echo '<img id="logo-icon" src="' . esc_url($this->plugin_url) . 'img/wp-reset-logo.png" title="' . esc_html__('WP Reset', 'wp-reset') . '" alt="' . esc_html__('WP Reset', 'wp-reset') . '">';
        echo '</div>';
        echo '</header>';

        echo '<div id="loading-tabs"><img class="rotating" src="' . esc_url($this->plugin_url) . 'img/wp-reset-icon.png' . '" alt="Loading. Please wait." title="Loading. Please wait."></div>';

        echo '<div id="wp-reset-tabs" class="ui-tabs" style="display: none;">';

        echo '<nav>';
        echo '<div class="wpr-container">';
        echo '<ul class="wpr-main-tab">';
        echo '<li><a href="#tab-reset">' . esc_html(__('Reset', 'wp-reset')) . '</a></li>';
        echo '<li><a href="#tab-tools">' . esc_html(__('Tools', 'wp-reset')) . '</a></li>';
        echo '<li><a href="#tab-snapshots">' . esc_html(__('Snapshots', 'wp-reset')) . '</a></li>';
        echo '<li><a href="#tab-collections">' . esc_html(__('Collections', 'wp-reset')) . '</a></li>';
        echo '<li><a href="#tab-support">' . esc_html(__('Support', 'wp-reset')) . '</a></li>';
        echo '<li class="tab-pro"><a href="#tab-pro">' . esc_html(__('PRO', 'wp-reset')) . '</a></li>';
        echo '</ul>';
        echo '</div>'; // container
        echo '</nav>';

        echo '<div id="wpr-notifications">';
        echo '<div class="wpr-container">';
        $this->custom_notifications();
        echo '</div>';
        echo '</div>'; // wpr-notifications

        // tabs
        echo '<div class="wpr-container">';
        echo '<div id="wpr-content">';

        echo '<div style="display: none;" id="tab-reset">';
        $this->tab_reset();
        echo '</div>';

        echo '<div style="display: none;" id="tab-tools">';
        $this->tab_tools();
        echo '</div>';

        echo '<div style="display: none;" id="tab-snapshots">';
        $this->tab_snapshots();
        echo '</div>';

        echo '<div style="display: none;" id="tab-collections">';
        $this->tab_collections();
        echo '</div>';

        echo '<div style="display: none;" id="tab-support">';
        $this->tab_support();
        echo '</div>';

        echo '<div style="display: none;" id="tab-pro">';
        $this->tab_pro();
        echo '</div>';

        echo '</div>'; // content
        echo '</div>'; // container
        echo '</div>'; // wp-reset-tabs

        echo '</form>';

        echo '<div id="wpr-sidebar-ads">';
        echo '<div id="wpr-ad">';
        echo '<h3 class="textcenter"><b>Save time &amp; money with WP Reset PRO! First WP dev tool for non-devs.</b></h3>';
        echo '<p class="textcenter"><a href="#" data-feature="sidebar-logo" class="button-pro-feature textcenter"><img style="max-width: 90%;" src="' . esc_url($this->plugin_url) . '/img/wp-reset-logo.png" alt="WP Reset PRO" title="WP Reset PRO"></a></p>';
        echo '<ul class="plain-list">
    <li>25+ Reset Tools</li>
    <li>Plugins &amp; Themes Collections</li>
    <li>Automatic Snapshots</li>
    <li>WP Reset Cloud, Dropbox &amp; Google Drive support</li>
    <li>Emergency Recovery Script</li>
    <li>White-label Mode + Complete Plugin Rebranding</li>
    <li>Licenses &amp; Sites Manager (remote SaaS dashboard)</li>
    <li>Friendly email support from plugin developers</li>
  </ul>';
        echo '<p class="textcenter"><a href="#" data-feature="sidebar-button" class="button-pro-feature button button-primary">Get PRO now</a></p>';
        echo '</div>';

        if (!defined('WPFSSL_OPTIONS_KEY')) {
            echo '<div id="wpfssl-ad">';
            echo '<h3 class="textcenter"><b>Problems with SSL certificate?<br>Moving a site from HTTP to HTTPS?<br>Mixed content giving you troubles?<br><br><u>Fix all SSL problems with one plugin!</u></b></h3>';
            echo '<p class="textcenter"><a href="#" class="textcenter install-wpfssl"><img style="max-width: 90%;" src="' . esc_url($this->plugin_url) . '/img/wp-force-ssl-logo.png" alt="WP Force SSL" title="WP Force SSL"></a></p>';
            echo '<p class="textcenter"><br><a href="#" class="install-wpfssl button button-primary">Install &amp; activate the free WP Force SSL plugin</a></p><p><a href="https://wordpress.org/plugins/wp-force-ssl/" target="_blank">WP Force SSL</a> is a free WP plugin maintained by the same team as this Maintenance plugin. It has <b>+150,000 users, 5-star rating</b>, and is hosted on the official WP repository.</p>';
            echo '</div>';
        }
        echo '</div>';

        echo '</div>'; // wrap
    } // plugin_page


    /**
     * Echoes all custom plugin notitications
     *
     * @return null
     */
    private function custom_notifications()
    {
        $notice_shown = false;
        $meta = $this->get_meta();
        $snapshots = $this->get_snapshots();

        // update to PRO after activating the license
        if ($this->license->is_active()) {
            echo '<div class="card notice-wrapper notice-info">';
            echo '<h2>' . esc_html(__('Thank you for purchasing WP Reset PRO!', 'wp-reset')) . '</h2>';
            echo '<p>Your license has been verified &amp; activated.</b><br>To start using the PRO version, please follow these steps:';
            echo '<ol>';
            echo '<li><a href="https://dashboard.wpreset.com/pro-download/" target="_blank">Download</a> the latest version of the PRO plugin.</li>';
            echo '<li>Go to <a href="' . esc_url(admin_url('plugin-install.php')) . '">Plugins - Add New - Upload Plugin</a> and upload the ZIP you just downloaded.</li>';
            echo '<li>If asked to replace (overwrite) the free version - confirm it.</li>';
            echo '<li>Activate the plugin.</li>';
            echo '<li>That\'s it, no more steps.</li>';
            echo '</ol>';
            echo '</div>';
            $notice_shown = true;
        }

        // warn that WPR is not WPMU compatible
        if (false === $notice_shown && is_multisite()) {
            echo '<div class="card notice-wrapper notice-error">';
            echo '<h2>' . esc_html__('WP Reset is not compatible with multisite!', 'wp-reset') . '</h2>';
            WP_Reset_Utility::wp_kses_wf('<p>' . __('Please be careful when using WP Reset with multisite enabled. It\'s not recommended to reset the main site. Sub-sites should be OK. We\'re working on making it fully compatible with WP-MU. <b>Till then please be careful.</b> Thank you for understanding.', 'wp-reset') . '</p>');
            echo '</div>';
            $notice_shown = true;
        }

        // ask for review
        if ((!empty($meta['reset_count']) || !empty($snapshots) || current_time('timestamp', true) - $meta['first_install'] > DAY_IN_SECONDS)
            && false === $notice_shown
            && false == $this->get_dismissed_notices('rate')
        ) {
            echo '<div class="card notice-wrapper notice-info">';
            echo '<h2>' . esc_html__('Please help us spread the word &amp; keep the plugin up-to-date', 'wp-reset') . '</h2>';
            WP_Reset_Utility::wp_kses_wf('<p>' . __('If you use &amp; enjoy WP Reset, <b>please rate it on WordPress.org</b>. It only takes a second and helps us keep the plugin maintained. Thank you!', 'wp-reset') . '</p>');
            echo '<p><a class="button-primary button" title="' . esc_html__('Rate WP Reset', 'wp-reset') . '" target="_blank" href="https://wordpress.org/support/plugin/wp-reset/reviews/#new-post">' . esc_html__('Rate the plugin ★★★★★', 'wp-reset') . '</a>  <a href="#" class="wpr-dismiss-notice dismiss-notice-rate" data-notice="rate">' . esc_html__('I\'ve already rated it', 'wp-reset') . '</a></p>';
            echo '</div>';
            $notice_shown = true;
        }
    } // custom_notifications


    /**
     * Echoes content for reset tab
     *
     * @return null
     */
    private function tab_reset()
    {
        global $current_user, $wpdb;

        echo '<div class="card">';
        WP_Reset_Utility::wp_kses_wf($this->get_card_header(__('Please read carefully before proceeding', 'wp-reset'), 'reset-description', array('collapse_button' => true)));
        echo '<div class="card-body">';
        echo '<p>The following table details what data will be deleted (reset or destroyed) when a selected reset tool is run. Please read it! ';
        echo 'If something is not clear <a href="#" class="change-tab" data-tab="4">contact support</a> before running any tools. It\'s better to ask than to be sorry!';
        echo '</p>';
        echo '<p><i class="dashicons dashicons-trash red tooltip" title="Tool WILL delete, reset or destroy the noted data" style="vertical-align: bottom;"></i> - tool WILL delete, reset or destroy the noted data<br>';
        echo '<i class="dashicons dashicons-yes tooltip" title="Tool will NOT touch the noted data in any way" style="vertical-align: bottom;"></i> - tool will NOT touch the noted data in any way</p>';

        echo '<table id="reset-details" class="">';
        echo '<tr>';
        echo '<th>&nbsp;</th>';
        echo '<th>Options Reset<br><a data-feature="tool-options-reset" class="pro-feature" href="#"><span class="pro">PRO</span> tool</a></th>';
        echo '<th nowrap>Site Reset</th>';
        echo '<th>Nuclear Reset<br><a data-feature="tool-nuclear-reset" class="pro-feature" href="#"><span class="pro">PRO</span> tool</a></th>';
        echo '</tr>';

        $rows = array();
        $rows['Posts, pages & custom post types'] = array(0, 1, 1);
        $rows['Comments'] = array(0, 1, 1);
        $rows['Media'] = array(0, 1, 1);
        $rows['Media files'] = array(0, 0, 1);
        $rows['Users'] = array(0, 1, 1);
        $rows['User roles'] = array(1, 1, 1);
        $rows['Current user - ' . $current_user->user_login] = array(0, 0, 0);
        $rows['Widgets'] = array(1, 1, 1);
        $rows['Transients'] = array(1, 1, 1);
        $rows['Settings &amp; options (from WP, plugins & themes)'] = array(1, 1, 1);
        $rows['Site title, WP address, site address,' . PHP_EOL . 'search engine visibility, timezone'] = array(0, 0, 0);
        $rows['Site language'] = array(0, 0, 1);
        $rows['Data in all default WP tables'] = array(0, 1, 1);
        $rows['Custom database tables with prefix ' . $wpdb->prefix] = array(0, 1, 1);
        $rows['Other database tables'] = array(0, 0, 0);
        $rows['Plugin files'] = array(0, 0, 1);
        $rows['MU plugin files'] = array(0, 0, 1);
        $rows['Drop-in files'] = array(0, 0, 1);
        $rows['Theme files'] = array(0, 0, 1);
        $rows['All files in uploads'] = array(0, 0, 1);
        $rows['Custom folders in wp-content'] = array(0, 0, 1);

        foreach ($rows as $tool => $opt) {
            echo '<tr>';
            echo '<td>';
            WP_Reset_Utility::wp_kses_wf(nl2br(esc_html($tool)));
            echo '</td>';
            if (empty($opt[0])) {
                echo '<td><i class="dashicons dashicons-yes tooltip" title="Data will NOT be deleted, reset or modified"></i></td>';
            } else {
                echo '<td><i class="dashicons dashicons-trash red tooltip" title="Data WILL BE deleted, reset or modified"></i></td>';
            }
            if (empty($opt[1])) {
                echo '<td><i class="dashicons dashicons-yes tooltip" title="Data will NOT be deleted, reset or modified"></i></td>';
            } else {
                echo '<td><i class="dashicons dashicons-trash red tooltip" title="Data WILL BE deleted, reset or modified"></i></td>';
            }
            if (empty($opt[2])) {
                echo '<td><i class="dashicons dashicons-yes tooltip" title="Data will NOT be deleted, reset or modified"></i></td>';
            } else {
                echo '<td><i class="dashicons dashicons-trash red tooltip" title="Data WILL BE deleted, reset or modified"></i></td>';
            }
            echo '</tr>';
        } // foreach $rows
        echo '<tfoot>';
        echo '<tr>';
        echo '<th>&nbsp;</th>';
        echo '<th>Options Reset<br><a data-feature="tool-options-reset" class="pro-feature" href="#"><span class="pro">PRO</span> tool</a></th>';
        echo '<th nowrap>Site Reset</th>';
        echo '<th>Nuclear Reset<br><a data-feature="tool-nuclear-reset" class="pro-feature" href="#"><span class="pro">PRO</span> tool</a></th>';
        echo '</tr>';
        echo '</tfoot>';
        echo '</table>';

        echo '<p><b>' . esc_html__('What happens when I run any Reset tool?', 'wp-reset') . '</b></p>';
        echo '<ul class="plain-list">';
        WP_Reset_Utility::wp_kses_wf('<li>' . __('remember, always <b>make a backup first</b> or use <a href="#" class="change-tab" data-tab="2">snapshots</a>', 'wp-reset') . '</li>');
        echo '<li>' . esc_html__('you will have to confirm the action one more time', 'wp-reset') . '</li>';
        echo '<li>' . esc_html__('see the table above to find out what exactly will be reset or deleted', 'wp-reset') . '</li>';
        echo '<li>' . esc_html__('site title, WordPress URL, site URL, site language, search engine visibility and current user will always be restored', 'wp-reset') . '</li>';
        echo '<li>' . esc_html__('you will be logged out, automatically logged back in and taken to the admin dashboard', 'wp-reset') . '</li>';
        echo '<li>' . esc_html__('WP Reset plugin will be reactivated if that option is chosen', 'wp-reset') . '</li>';
        echo '</ul>';

        echo '<p><b>' . esc_html__('WP-CLI Support', 'wp-reset') . '</b><br>';
        /* translators: %s is replaced with the literal html "<code>wp help reset</code>" */
        echo '' . sprintf(esc_html__('All tools available via GUI are available in WP-CLI as well. To get the list of commands run %s. Instead of the active user, the first user with admin privileges found in the database will be restored. ', 'wp-reset'), '<code>wp help reset</code>');
        /* translators: %s is replaced with the literal html "<code>--yes</code>" */
        echo sprintf(esc_html__('All actions have to be confirmed. If you want to skip confirmation use the standard %s option. Please be careful and backup first.', 'wp-reset'), '<code>--yes</code>') . '</p>';

        echo '</div></div>'; // card description

        $theme =  wp_get_theme();
        $theme_name = $theme->get('Name');
        if (empty($theme_name)) {
            $theme_name = '<i>no active theme</i>';
        }
        $active_plugins = get_option('active_plugins');

        // options reset
        echo '<div class="card">';
        WP_Reset_Utility::wp_kses_wf($this->get_card_header(__('Options Reset', 'wp-reset'), 'tool-options-reset', array('collapse_button' => true, 'pro' => true)));
        echo '<div class="card-body">';
        echo '<p>Options table will be reset to default values meaning all WP core settings, widgets, theme settings and customizations, and plugin settings will be gone. Other content and files will not be touched including posts, pages, custom post types, comments and other data stored in separate tables. Site URL and name will be kept as well. Please see the <a href="#reset-details" class="scrollto">table above</a> for details.</p>';

        WP_Reset_Utility::wp_kses_wf($this->get_tool_icons(false, true));

        echo '<p><br><label for="reset-options-reactivate-theme"><input type="checkbox" id="reset-options-reactivate-theme" value="1"> ' . esc_html__('Reactivate current theme', 'wp-reset') . ' - ' . esc_html($theme_name) . '</label></p>';
        echo '<p><label for="reset-options-reactivate-plugins"><input type="checkbox" id="reset-options-reactivate-plugins" value="1"> Reactivate ' . esc_attr(sizeof($active_plugins)) . ' currently active plugin' . (sizeof($active_plugins) != 1 ? 's' : '') . ' (WP Reset will reactivate by default)</label></p>';

        echo '<p class="mb0"><a class="button button-delete button-pro-feature" href="#">Reset all options - <span data-feature="tool-options-reset" class="pro-feature"><span class="pro">PRO</span> tool</span></a></p>';
        echo '</div>';
        echo '</div>'; // options reset

        echo '<div class="card">';
        WP_Reset_Utility::wp_kses_wf($this->get_card_header(__('Site Reset', 'wp-reset'), 'tool-site-reset', array('collapse_button' => true)));
        echo '<div class="card-body">';
        echo '<p><label for="reactivate-theme"><input name="wpr-post-reset[reactivate_theme]" type="checkbox" id="reactivate-theme" value="1"> ' . esc_html__('Reactivate current theme', 'wp-reset') . ' - ' . esc_html($theme->get('Name')) . '</label></p>';
        echo '<p><label for="reactivate-wpreset"><input name="wpr-post-reset[reactivate_wpreset]" type="checkbox" id="reactivate-wpreset" value="1" checked> ' . esc_html__('Reactivate WP Reset plugin', 'wp-reset') . '</label></p>';

        echo '<p><label for="reactivate-plugins"><input name="wpr-post-reset[reactivate_plugins]" type="checkbox" id="reactivate-plugins" value="1"> ' . esc_html__('Reactivate all currently active plugins', 'wp-reset') . '</label></p>';
        WP_Reset_Utility::wp_kses_wf('<p>' . __('Type <b>reset</b> in the confirmation field to confirm the reset and then click the "Reset WordPress" button.<br>Always <a href="#" class="create-new-snapshot" data-description="Before resetting the site">create a snapshot</a> before resetting if you want to be able to undo.', 'wp-reset') . '</p>');

        wp_nonce_field('wp-reset');
        /* translators: %s is replaced with "reset"*/
        echo '<p class="mb0"><input id="wp_reset_confirm" type="text" name="wp_reset_confirm" placeholder="' . esc_attr(sprintf(__('Type in: %s', 'wp-reset'), '"reset"')) . '" value="" autocomplete="off"> &nbsp;';
        echo '<a id="wp_reset_submit" class="button button-delete">' . esc_html__('Reset Site', 'wp-reset') . '</a>';
        WP_Reset_Utility::wp_kses_wf($this->get_snapshot_button('reset-wordpress', 'Before resetting the site'));
        echo '</p>';
        echo '</div>';
        echo '</div>'; // card reset

        // nuclear reset
        echo '<div class="card">';
        WP_Reset_Utility::wp_kses_wf($this->get_card_header(__('Nuclear Site Reset', 'wp-reset'), 'tool-nuclear-reset', array('collapse_button' => true, 'pro' => true)));
        echo '<div class="card-body">';
        echo '<p>All data will be deleted or reset (see the <a href="#reset-details" class="scrollto">explanation table</a> for details). All data stored in the database including custom tables with <code>' . esc_html($wpdb->prefix) . '</code> prefix, as well as all files in wp-content, themes and plugins folders. The only thing restored after reset will be your user account so you can log in again, and the basic WP settings like site URL. Please see the <a href="#reset-details" class="scrollto">table above</a> for details.</p>';

        WP_Reset_Utility::wp_kses_wf($this->get_tool_icons(true, true));

        if (is_multisite()) {
            echo '<p class="mb0 wpmu-error">This tool is <b>not compatible</b> with WP multisite (WPMU). Using it would delete files shared by multiple sites in the WP network.</p>';
        } else {
            echo '<p><br><label for="nuclear-reset-reactivate-wpreset"><input type="checkbox" id="nuclear-reset-reactivate-wpreset" value="1" checked> ' . esc_html__('Reactivate WP Reset plugin', 'wp-reset') . '</label></p>';

            WP_Reset_Utility::wp_kses_wf('<p>' . __('Type <b>reset</b> in the confirmation field to confirm the reset and then click the "Reset WordPress &amp; Delete All Custom Files &amp; Data" button. <b>There is NO UNDO.', 'wp-reset') . '</b></p>');

            echo '<p class="mb0"><input id="nuclear_reset_confirm" type="text" placeholder="' . esc_html__('Type in "reset"', 'wp-reset') . '" value="" autocomplete="off"> &nbsp;';
            echo '<a class="button button-delete button-pro-feature" href="#">' . esc_html__('Reset WordPress &amp; Delete All Custom Files &amp; Data', 'wp-reset') . ' - <span data-feature="tool-nuclear-reset" class="pro-feature"><span class="pro">PRO</span> tool</span></a></p>';
        }
        echo '</div>';
        echo '</div>'; // nuclear reset
    } // tab_reset


    /**
     * Echoes content for tools tab
     *
     * @return null
     */
    private function tab_tools()
    {
        global $wpdb, $wp_version, $wp_filesystem;
		$this->wp_init_filesystem();

        $tools = array(
            'tool-reset-theme-options' => 'Reset Theme Options',
            '_tool-reset-user-roles' => 'Reset User Roles',
            'tool-delete-transients' => 'Delete Transients',
            'tool-purge-cache' => 'Purge Cache',
            'tool-delete-local-data' => 'Delete Local Data',
            '_tool-delete-content' => 'Delete Content',
            '_tool-delete-widgets' => 'Delete Widgets',
            'tool-delete-themes' => 'Delete Themes',
            'tool-delete-plugins' => 'Delete Plugins',
            '_tool-delete-mu-plugins-dropins' => 'Delete MU Plugins & Drop-ins',
            'tool-delete-uploads' => 'Clean uploads Folder',
            '_tool-delete-wp-content' => 'Clean wp-content Folder',
            'tool-empty-delete-custom-tables' => 'Empty or Delete Custom Tables',
            '_tool-switch-wp-version' => 'Switch WP Version',
            'tool-delete-htaccess' => 'Delete .htaccess File'
        );

        echo '<div class="card">';
        WP_Reset_Utility::wp_kses_wf($this->get_card_header(__('Index of Tools', 'wp-reset'), 'iot', array('collapse_button' => true)));
        echo '<div class="card-body">';
        $i = 0;
        $tools_nb = sizeof($tools);
        foreach ($tools as $tool_id => $tool_name) {
            if ($i == 0) {
                echo '<div class="third">';
                echo '<ul class="mb0 plain-list">';
            }
            if ($i == 5 || $i == 10) {
                echo '</div>';
                echo '<div class="third">';
                echo '<ul class="mb0 plain-list">';
            }

            if ($tool_id[0] == '_') {
                $tool_id = ltrim($tool_id, '_');
                echo '<li><a title="Jump to ' . esc_attr($tool_name) . ' tool" class="scrollto" href="#' . esc_attr($tool_id) . '">' . esc_html($tool_name) . '</a> <a class="pro-feature" href="#" data-feature="' . esc_attr($tool_id) . '"><span class="pro">PRO</span> tool</a></li>';
            } else {
                echo '<li><a title="Jump to ' . esc_attr($tool_name) . ' tool" class="scrollto" href="#' . esc_attr($tool_id) . '">' . esc_html($tool_name) . '</a></li>';
            }

            if ($i == $tools_nb - 1) {
                echo '</ul>';
                echo '</div>'; // third
            }
            $i++;
        } // foreach tools
        echo '</div>';
        echo '</div>';

        echo '<div class="card">';
        WP_Reset_Utility::wp_kses_wf($this->get_card_header(__('Reset Theme Options', 'wp-reset'), 'tool-reset-theme-options', array('iot_button' => true, 'collapse_button' => true)));
        echo '<div class="card-body">';
        WP_Reset_Utility::wp_kses_wf('<p>' . __('All options (mods) for all themes will be reset; not just for the active theme. The tool works only for themes that use the <a href="https://codex.wordpress.org/Theme_Modification_API" target="_blank">WordPress theme modification API</a>. If options are saved in some other, custom way they won\'t be reset.<br> Always <a href="#" class="create-new-snapshot" data-description="Before resetting theme options">create a snapshot</a> before using this tool if you want to be able to undo its actions.', 'wp-reset') . '</p>');
        WP_Reset_Utility::wp_kses_wf($this->get_tool_icons(false, true));
        echo '<p class="mb0"><a data-confirm-title="Are you sure you want to reset all theme options?" data-btn-confirm="Reset theme options" data-text-wait="Resetting theme options. Please wait." data-text-confirm="All options (mods) for all themes will be reset. Always ' . esc_attr('<a data-description="Before resetting theme options" href="#" class="create-new-snapshot">create a snapshot</a> if you want to be able to undo') . '." data-text-done="Options for %n themes have been reset." data-text-done-singular="Options for one theme have been reset." class="button button-delete" href="#" id="reset-theme-options">Reset theme options</a>';
        WP_Reset_Utility::wp_kses_wf($this->get_snapshot_button('reset-theme-options', 'Before resetting theme options') . '</p>');
        echo '</div>';
        echo '</div>'; // reset theme options

        echo '<div class="card default-collapsed">';
        WP_Reset_Utility::wp_kses_wf($this->get_card_header(__('Reset User Roles', 'wp-reset'), 'tool-reset-user-roles', array('collapse_button' => true, 'iot_button' => true, 'pro' => true)));
        echo '<div class="card-body">';
        echo '<p>Default user roles\' capatibilities will be reset to their default values. All custom roles will be deleted.<br>Users that had custom roles will not be assigned any default ones and might not be able to log in. Roles have to be (re)assigned to them manually.</p>';
        WP_Reset_Utility::wp_kses_wf($this->get_tool_icons(false, true));
        echo '<p class="mb0"><a class="button button-delete button-pro-feature" href="#">Reset user roles - <span data-feature="tool-reset-user-roles" class="pro-feature"><span class="pro">PRO</span> tool</span></a>';
        WP_Reset_Utility::wp_kses_wf($this->get_snapshot_button('reset-user-roles', 'Before resetting user roles') . '</p>');
        echo '</div>';
        echo '</div>'; // reset user roles

        echo '<div class="card">';
        WP_Reset_Utility::wp_kses_wf($this->get_card_header(__('Delete Transients', 'wp-reset'), 'tool-delete-transients', array('iot_button' => true, 'collapse_button' => true)));
        echo '<div class="card-body">';
        echo '<p>All transient related database entries will be deleted. Including expired and non-expired transients, and orphaned transient timeout entries.<br>Always <a href="#" data-description="Before deleting transients" class="create-new-snapshot">create a snapshot</a> before using this tool if you want to be able to undo its actions.</p>';
        WP_Reset_Utility::wp_kses_wf($this->get_tool_icons(false, true));
        echo '<p class="mb0"><a data-confirm-title="Are you sure you want to delete all transients?" data-btn-confirm="Delete all transients" data-text-wait="Deleting transients. Please wait." data-text-confirm="All database entries related to transients will be deleted. Always ' . esc_attr('<a data-description="Before deleting transients" href="#" class="create-new-snapshot">create a snapshot</a> if you want to be able to undo') . '." data-text-done="%n transient database entries have been deleted." data-text-done-singular="One transient database entry has been deleted." class="button button-delete" href="#" id="delete-transients">Delete all transients</a>';
        WP_Reset_Utility::wp_kses_wf($this->get_snapshot_button('delete-transients', 'Before deleting transients') . '</p>');
        echo '</div>';
        echo '</div>'; // delete transients

        echo '<div class="card">';
        WP_Reset_Utility::wp_kses_wf($this->get_card_header(__('Purge Cache', 'wp-reset'), 'tool-purge-cache', array('collapse_button' => true, 'iot_button' => true)));
        echo '<div class="card-body">';
        echo '<p>All cache objects stored in both files and the database will be deleted. Along with WP object cache and transients, cache from the following plugins will be purged: W3 Total Cache, WP Cache, LiteSpeed Cache, Endurance Page Cache, SiteGround Optimizer, WP Fastest Cache and Swift Performance.</p>';
        WP_Reset_Utility::wp_kses_wf($this->get_tool_icons(true, true));
        echo '<p class="mb0"><a data-confirm-title="Are you sure you want to purge all cache?" data-btn-confirm="Purge cache" data-text-wait="Purging cache. Please wait." data-text-confirm="All cache objects will be deleted. There is NO UNDO. WP Reset does not make any file backups." data-text-done="Cache has been purged." data-text-done-singular="Cache has been purged." class="button button-delete" href="#" id="purge-cache">Purge cache</a></p>';
        echo '</div>';
        echo '</div>'; // purge cache

        echo '<div class="card">';
        WP_Reset_Utility::wp_kses_wf($this->get_card_header(__('Delete Local Data', 'wp-reset'), 'tool-delete-local-data', array('collapse_button' => true, 'iot_button' => true)));
        echo '<div class="card-body">';
        echo '<p>All local storage and session storage data will be deleted. Cookies without a custom set path will be deleted as well. WP cookies are not touched, with Delete Local Data button.<br>Deleting all WordPress cookies (including authentication cookies) will delete all WP related cookies and user (you) will be logged out on the next page reload.
    </p>';
        WP_Reset_Utility::wp_kses_wf($this->get_tool_icons(false, false));
        echo '<p class="mb0"><a data-confirm-title="Are you sure you want to delete all local data?" data-btn-confirm="Delete local data" data-text-wait="Deleting local data. Please wait." data-text-confirm="All local data; cookies, local storage and local session will be deleted. There is NO UNDO. WP Reset does not make backups of local data." data-text-done="%n local data objects have been deleted." data-text-done-singular="One local data object has been deleted." class="button button-delete" href="#" id="delete-local-data">Delete local data</a><a data-confirm-title="Are you sure you want to delete all WP related cookies?" data-btn-confirm="Delete all WordPress cookies" data-text-wait="Deleting WP cookies. Please wait." data-text-confirm="All WP cookies including authentication ones will be deleted. You will have to log in again. There is NO UNDO. WP Reset does not make backups of cookies." data-text-done="All WP cookies have been deleted.  Reload the page to login again." data-text-done-singular="All WP cookies have been deleted. Reload the page to login again." class="button button-delete" href="#" id="delete-wp-cookies">Delete all WordPress cookies</a></p>';
        echo '</div>';
        echo '</div>'; // delete local data

        echo '<div class="card default-collapsed">';
        WP_Reset_Utility::wp_kses_wf($this->get_card_header(__('Delete Content', 'wp-reset'), 'tool-delete-content', array('collapse_button' => true, 'iot_button' => true, 'pro' => true)));
        echo '<div class="card-body">';
        echo '<p>Besides content, all linked or child records (for selected content) will be deleted to prevent creating orphaned rows in the database. For instance, for posts that\'s posts, post meta, and comments related to posts. Delete process does not call any WP hooks such as <i>before_delete_post</i>. Choosing a post type or taxonomy does not delete that parent object it deletes the child objects. Parent objects are defined in code. If you want to remove them, remove their code definition. When media is deleted, files are left in the uploads folder. To delete files use the <a class="scrollto" href="#tool-delete-uploads">Clean uploads Folder</a> tool. Deleting users does not affect the current, logged in user account. All orphaned objects will be reassigned to him.</p>';

        WP_Reset_Utility::wp_kses_wf($this->get_tool_icons(false, true));

        $post_types = get_post_types('', false, 'and');
        $taxonomies = get_taxonomies('', false, 'and');

        echo '<p><select size="6" multiple id="delete-content-types">';
        // phpcs:ignore db call warning as we are using uncommon queries
        echo '<option value="_comments">Comments (' . ((int) $wpdb->get_var("SELECT COUNT(comment_id) FROM $wpdb->comments")) . ')</option>'; // phpcs:ignore
        echo '<option value="_users">Users (' . ((int) $wpdb->get_var("SELECT COUNT(id) FROM $wpdb->users")) . ')</option>'; // phpcs:ignore
        foreach ($post_types as $type) {
            $count = wp_count_posts($type->name, 'readable');
            $tmp = 0;
            foreach ($count as $cnt) {
                $tmp += (int) $cnt;
            }
            echo '<option value="' . esc_attr($type->name) . '">Post type - ' . esc_html($type->label . ' (' . $tmp) . ')</option>';
        } // foreach post types
        foreach ($taxonomies as $tax) {
            echo '<option value="_tax_' . esc_attr($tax->name) . '">Taxonomy - ' . esc_html($tax->label . ' (' . wp_count_terms($tax->name)) . ')</option>';
        } // foreach post types

        echo '</select><br>';
        echo 'Select content object(s) you want to delete. Use ctrl + click to select multiple objects.</p>';

        echo '<p class="mb0"><a class="button button-delete button-pro-feature" href="#">Delete content - <span data-feature="tool-delete-content" class="pro-feature"><span class="pro">PRO</span> tool</span></a></p>';
        echo '</div>';
        echo '</div>'; // delete content

        echo '<div class="card default-collapsed">';
        WP_Reset_Utility::wp_kses_wf($this->get_card_header(__('Delete Widgets', 'wp-reset'), 'tool-delete-widgets', array('collapse_button' => true, 'iot_button' => true, 'pro' => true)));
        echo '<div class="card-body">';
        echo '<p>All widgets, orphaned, active and inactive ones, as well as widgets in active and inactive sidebars will be deleted including their settings. After deleting, WordPress will automatically recreate default, empty database entries related to widgets. So, no matter how many times users run the tool it will never return "no data deleted". That\'s expected and normal.</p>';

        WP_Reset_Utility::wp_kses_wf($this->get_tool_icons(false, true));

        echo '<p class="mb0"><a class="button button-delete button-pro-feature" href="#">Delete widgets - <span data-feature="tool-delete-widgets" class="pro-feature"><span class="pro">PRO</span> tool</span></a></p>';
        echo '</div>';
        echo '</div>'; // delete widgets

        $theme =  wp_get_theme();

        echo '<div class="card">';
        WP_Reset_Utility::wp_kses_wf($this->get_card_header(__('Delete Themes', 'wp-reset'), 'tool-delete-themes', array('iot_button' => true, 'collapse_button' => true)));
        echo '<div class="card-body">';
        /* translators: %s is replaced with the currently active theme name */
        WP_Reset_Utility::wp_kses_wf('<p>' . sprintf(__('All themes will be deleted. Including the currently active theme - %s.<br><b>There is NO UNDO. WP Reset does not make any file backups.</b>', 'wp-reset'), esc_html($theme->get('Name'))) . '</p>');
        WP_Reset_Utility::wp_kses_wf($this->get_tool_icons(true, true));
        echo '<p class="mb0"><a data-confirm-title="Are you sure you want to delete all themes?" data-btn-confirm="Delete all themes" data-text-wait="Deleting all themes. Please wait." data-text-confirm="All themes will be deleted. There is NO UNDO. WP Reset does not make any file backups." data-text-done="%n themes have been deleted." data-text-done-singular="One theme has been deleted." class="button button-delete" href="#" id="delete-themes">Delete all themes</a></p>';
        echo '</div>';
        echo '</div>'; // delete themes

        echo '<div class="card">';
        WP_Reset_Utility::wp_kses_wf($this->get_card_header(__('Delete Plugins', 'wp-reset'), 'tool-delete-plugins', array('iot_button' => true, 'collapse_button' => true)));
        echo '<div class="card-body">';
        WP_Reset_Utility::wp_kses_wf('<p>' . __('All plugins will be deleted except for WP Reset which will remain active.<br><b>There is NO UNDO. WP Reset does not make any file backups.</b>', 'wp-reset') . '</p>');
        WP_Reset_Utility::wp_kses_wf($this->get_tool_icons(true, true));
        echo '<p class="mb0"><a data-confirm-title="Are you sure you want to delete all plugins?" data-btn-confirm="Delete plugins" data-text-wait="Deleting plugins. Please wait." data-text-confirm="All plugins except WP Reset will be deleted. There is NO UNDO. WP Reset does not make any file backups." data-text-done="%n plugins have been deleted." data-text-done-singular="One plugin has been deleted." class="button button-delete" href="#" id="delete-plugins">Delete plugins</a></p>';
        echo '</div>';
        echo '</div>'; // delete plugins

        echo '<div class="card default-collapsed">';
        WP_Reset_Utility::wp_kses_wf($this->get_card_header(__('Delete MU Plugins & Drop-ins', 'wp-reset'), 'tool-delete-mu-plugins-dropins', array('collapse_button' => true, 'iot_button' => true, 'pro' => true)));
        echo '<div class="card-body">';
        echo '<p>MU Plugins are located in <code>/wp-content/mu-plugins/</code> and are, as the name suggests, must-use plugins that are automatically activated by WP and can\'t be deactiavated via the <a href="' . esc_url(admin_url('plugins.php?plugin_status=mustuse')) . '" target="_blank">plugins interface</a>, although if any are used, they are listed in the "Must Use" tab.<br>';
        echo 'Drop-ins are pieces of code found in <code>/wp-content/</code> that replace default, built-in WordPress functionality. Most often used are <code>db.php</code> and <code>advanced-cache.php</code> that implement custom DB and cache functionality. They can\'t be deactivated via the <a href="' . esc_url(admin_url('plugins.php?plugin_status=dropins')) . '" target="_blank">plugins interface</a> but if any are present are listed in the "Drop-in" tab.</p>';

        if (is_multisite()) {
            echo '<p class="mb0 wpmu-error">This tool is <b>not compatible</b> with WP multisite (WPMU). Using it would delete plugins for all sites in the network since they all share the same plugin files.</p>';
        } else {
            WP_Reset_Utility::wp_kses_wf($this->get_tool_icons(true, false, true));
            echo '<p class="mb0"><a class="button button-delete button-pro-feature" href="#">Delete must use plugins - <span data-feature="tool-delete-mu-plugins" class="pro-feature"><span class="pro">PRO</span> tool</span></a><a class="button button-delete button-pro-feature" href="#">Delete drop-ins - <span data-feature="tool-delete-dropins" class="pro-feature"><span class="pro">PRO</span> tool</span></a></p>';
        }
        echo '</div>';
        echo '</div>'; // delete MU plugins and dropins

        $upload_dir = wp_upload_dir(gmdate('Y/m'), true);
        $upload_dir['basedir'] = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $upload_dir['basedir']);

        echo '<div class="card">';
        WP_Reset_Utility::wp_kses_wf($this->get_card_header(__('Clean uploads Folder', 'wp-reset'), 'tool-delete-uploads', array('iot_button' => true, 'collapse_button' => true)));
        echo '<div class="card-body">';
        /* translators: %1$s is replaced with the uploads folder path, %2$s is replaced with the URL to WordPress Media upload page */
        WP_Reset_Utility::wp_kses_wf('<p>' . sprintf(__('All files in <code>%1$s</code> folder will be deleted. Including folders and subfolders, and files in subfolders. Files associated with <a href="%2$s">media</a> entries will be deleted too.<br><b>There is NO UNDO. WP Reset does not make any file backups.</b>', 'wp-reset'), esc_html($upload_dir['basedir']), esc_url(admin_url('upload.php'))) . '</p>');
        WP_Reset_Utility::wp_kses_wf($this->get_tool_icons(true, false));
        if (false != $upload_dir['error']) {
            echo '<p class="mb0"><span style="color:#dd3036;"><b>Tool is not available.</b></span> Folder is not writeable by WordPress. Please check file and folder access rights.</p>';
        } else {
            echo '<p class="mb0"><a data-confirm-title="Are you sure you want to delete all files &amp; folders in uploads folder?" data-btn-confirm="Delete everything in uploads folder" data-text-wait="Deleting uploads. Please wait." data-text-confirm="All files and folders in uploads will be deleted. There is NO UNDO. WP Reset does not make any file backups." data-text-done="%n files &amp; folders have been deleted." data-text-done-singular="One file or folder has been deleted." class="button button-delete" href="#" id="delete-uploads">Delete all files &amp; folders in uploads folder</a></p>';
        }
        echo '</div>';
        echo '</div>'; // clean uploads folder

        echo '<div class="card default-collapsed">';
        WP_Reset_Utility::wp_kses_wf($this->get_card_header(__('Clean wp-content Folder', 'wp-reset'), 'tool-delete-wp-content', array('collapse_button' => true, 'iot_button' => true, 'pro' => true)));
        echo '<div class="card-body">';
        echo '<p>All folders and their content in <code>wp-content</code> folder except the following ones will be deleted: <code>mu-plugins</code>, <code>plugins</code>, <code>themes</code>, <code>uploads</code>, <code>wp-reset-autosnapshots</code>, <code>wp-reset-snapshots-export</code>.</p>';
        WP_Reset_Utility::wp_kses_wf($this->get_tool_icons(true, false));
        if (false === $wp_filesystem->is_writable(trailingslashit(WP_CONTENT_DIR))) {
            echo '<p class="mb0"><span style="color:#dd3036;"><b>Tool is not available.</b></span> Folder is not writeable by WordPress. Please check file and folder access rights.</p>';
        } else {
            echo '<p class="mb0"><a class="button button-delete button-pro-feature" href="#">Clean wp-content folder - <span data-feature="tool-delete-wp-content" class="pro-feature"><span class="pro">PRO</span> tool</span></a></p>';
        }
        echo '</div>';
        echo '</div>'; // clean wp-content

        $custom_tables = $this->get_custom_tables();

        echo '<div class="card">';
        WP_Reset_Utility::wp_kses_wf($this->get_card_header(__('Empty or Delete Custom Tables', 'wp-reset'), 'tool-empty-delete-custom-tables', array('iot_button' => true, 'collapse_button' => true)));
        echo '<div class="card-body">';
        /* translators: %s is replaced with the table prefix */
        WP_Reset_Utility::wp_kses_wf('<p>' . sprintf(__('This action affects only custom tables with <code>%s</code> prefix. Core WP tables and other tables in the database that do not have that prefix will not be deleted/emptied. Deleting (dropping) tables completely removes them from the database. Emptying (truncating) removes all content from them, but keeps the structure intact.<br>Always <a href="#" class="create-new-snapshot" data-description="Before deleting custom tables">create a snapshot</a> before using this tool if you want to be able to undo its actions.</p>', 'wp-reset'), esc_html($wpdb->prefix)));
        if ($custom_tables) {
            /* translators: %d is replaced with the number of custom tables */
            WP_Reset_Utility::wp_kses_wf('<p>' . sprintf(__('The following %d custom tables are affected by this tool: ', 'wp-reset'), sizeof($custom_tables)));
            foreach ($custom_tables as $tbl) {
                echo '<code>' . esc_html($tbl['name']) . '</code>';
                if (next($custom_tables)) {
                    echo ', ';
                }
            } // foreach
            echo '.</p>';
            $custom_tables_btns = '';
        } else {
            echo '<p>' . esc_html__('There are no custom tables. There\'s nothing for this tool to empty or delete.', 'wp-reset') . '</p>';
            $custom_tables_btns = ' disabled';
        }
        WP_Reset_Utility::wp_kses_wf($this->get_tool_icons(false, true, true));
        echo '<p class="mb0"><a data-confirm-title="Are you sure you want to empty all custom tables?" data-btn-confirm="Empty custom tables" data-text-wait="Emptying custom tables. Please wait." data-text-confirm="All custom tables with prefix <code>' . esc_attr($wpdb->prefix) . '</code> will be emptied. Always ' . esc_attr('<a href="#" class="create-new-snapshot" data-description="Before emptying custom tables">create a snapshot</a> if you want to be able to undo') . '." data-text-done="%n custom tables have been emptied." data-text-done-singular="One custom table has been emptied." class="button button-delete' . esc_attr($custom_tables_btns) . '" href="#" id="truncate-custom-tables">Empty (truncate) custom tables</a>';
        echo '<a data-confirm-title="Are you sure you want to delete all custom tables?" data-btn-confirm="Delete custom tables" data-text-wait="Deleting custom tables. Please wait." data-text-confirm="All custom tables with prefix <code>' . esc_attr($wpdb->prefix) . '</code> will be deleted. Always ' . esc_attr('<a href="#" class="create-new-snapshot" data-description="Before deleting custom tables">create a snapshot</a> if you want to be able to undo') . '." data-text-done="%n custom tables have been deleted." data-text-done-singular="One custom table has been deleted." class="button button-delete' . esc_attr($custom_tables_btns) . '" href="#" id="drop-custom-tables">Delete (drop) custom tables</a>';
        WP_Reset_Utility::wp_kses_wf($this->get_snapshot_button('drop-custom-tables', 'Before deleting custom tables'));
        echo '</p>';
        echo '</div>';
        echo '</div>'; // empty custom tables

        echo '<div class="card default-collapsed">';
        WP_Reset_Utility::wp_kses_wf($this->get_card_header(__('Switch WP Version', 'wp-reset'), 'tool-switch-wp-version', array('collapse_button' => true, 'iot_button' => true, 'pro' => true)));
        echo '<div class="card-body">';
        if (is_multisite()) {
            echo '<p class="mb0 wpmu-error">This tool is <b>not compatible</b> with WP multisite (WPMU). Using it would change the WP version for all sites in the network since they all share the same core files.</p>';
        } else {
            echo '<p>Replace current WordPress version with the selected new version. Switching from a previous version, to a newer version is mostly supported and properly handled by the WP installer. Reverting WordPress, rolling back WordPress to a previous version is not supported. Results may vary!</p>';
            WP_Reset_Utility::wp_kses_wf($this->get_tool_icons(true, true));

            $wp_versions = WP_Reset_Utility::get_wordpress_versions();
            echo '<p><label for="select-wp-version">Select the WordPress version to switch to:</label> ';
            echo '<select id="select-wp-version">';
            echo '<option value="">select WordPress version</option>';
            foreach ($wp_versions as $version => $release_date) {
                if ($release_date == 'bleeding') {
                    echo '<option value="bleeding">WordPress v' . esc_html($version) . ' (Bleeding edge nightly)' . ($wp_version == $version ? ' - installed' : '') . '</option>';
                } elseif ($release_date == 'point') {
                    echo '<option value="point-' . esc_attr(substr($version, 0, 3)) . '">WordPress v' . esc_html($version) . ' (Point release nightly)' . ($wp_version == $version ? ' - installed' : '') . '</option>';
                } else {
                    echo '<option value="' . esc_attr($version) . '">WordPress v' . esc_html($version) . ' (' . esc_attr(gmdate('Y-m-d', $release_date)) . ')' . ($wp_version == $version ? ' - installed' : '') . '</option>';
                }
            }
            echo '</select></p>';

            echo '<p class="mb0">';
            echo '<a class="button button-delete button-pro-feature" href="#">Switch WordPress version - <span data-feature="tool-switch-wp-version" class="pro-feature"><span class="pro">PRO</span> tool</span></a>';
            echo '</p>';
        }
        echo '</div>';
        echo '</div>'; // switch WP version

        echo '<div class="card">';
        WP_Reset_Utility::wp_kses_wf($this->get_card_header(__('Delete .htaccess File', 'wp-reset'), 'tool-delete-htaccess', array('iot_button' => true, 'collapse_button' => true)));
        echo '<div class="card-body">';
        /* translators: %s is replaced with the .htaccess file path */
        WP_Reset_Utility::wp_kses_wf('<p>' . sprintf(__('This action deletes the .htaccess file located in <code>%s</code><br><b>There is NO UNDO. WP Reset does not make any file backups.</b></p>', 'wp-reset'), esc_html($this->get_htaccess_path())));

        echo '<p>If you need to edit .htaccess, install our free <a href="' . esc_url(admin_url('plugin-install.php?tab=plugin-information&plugin=wp-htaccess-editor&TB_iframe=true&width=600&height=550')) . '" class="thickbox open-plugin-details-modal">WP Htaccess Editor</a> plugin. It automatically creates backups when you edit .htaccess as well as checks for syntax errors. To create the default .htaccess file open <a href="' . esc_url(admin_url('options-permalink.php')) . '">Settings - Permalinks</a> and re-save settings. WordPress will recreate the file.</p>';
        WP_Reset_Utility::wp_kses_wf($this->get_tool_icons(true, false));
        echo '<p class="mb0"><a data-confirm-title="Are you sure you want to delete the .htaccess file?" data-btn-confirm="Delete .htaccess file" data-text-wait="Deleting .htaccess file. Please wait." data-text-confirm="Htaccess file will be deleted. There is NO UNDO. WP Reset does not make any file backups." data-text-done="Htaccess file has been deleted." data-text-done-singular="Htaccess file has been deleted." class="button button-delete" href="#" id="delete-htaccess">Delete .htaccess file</a></p>';

        echo '</div>';
        echo '</div>'; // delete htaccess
    } // tab_tools


    /**
     * Echoes content for collections tab
     *
     * @return null
     */
    private function tab_collections()
    {
        echo '<div class="card">';
        WP_Reset_Utility::wp_kses_wf($this->get_card_header('What are Plugin & Theme Collections?', 'collections-info', array('collapse_button' => false)));
        echo '<div class="card-body">';
        WP_Reset_Utility::wp_kses_wf('<p>' . __('Have a set of plugins (and themes) that you install and activate after every reset? Or on every fresh WordPress installation? Well, no more clicking install &amp; active for ten minutes! Build the collection once and install it with one click as many times as needed.</p><p>WP Reset stores collections in the cloud so they\'re accessible on every site you build. You can use free plugins and themes from the official repo, and PRO ones by uploading a ZIP file. We\'ll safely store your license keys too, so you have everything in one place.', 'wp-reset') . '</p>');
        echo '<p><a class="button button-secondary button-pro-feature" href="#">Add a new collection - <span data-feature="collections" class="pro-feature"><span class="pro">PRO</span> feature</span></a> &nbsp; <a class="button button-secondary button-pro-feature" href="#">Reload my saved collections from the cloud - <span data-feature="collections" class="pro-feature"><span class="pro">PRO</span> feature</span></a></p>';
        echo '</div>';
        echo '</div>'; // collections-info

        $plugins = array();
        $plugins['eps-301-redirects'] = array('name' => '301 Redirects', 'desc' => 'Easiest way to manage redirects');
        $plugins['classic-editor'] = array('name' => 'Classic Editor', 'desc' => 'Any easy fix for all your Gutenberg caused troubles');
        $plugins['simple-author-box'] = array('name' => 'Simple Author Box', 'desc' => 'Simplest way to add responsive, great looking author boxes');
        $plugins['sticky-menu-or-anything-on-scroll'] = array('name' => 'Sticky Menu (or Anything!) on Scroll', 'desc' => 'Make any element on the page sticky.');
        $plugins['under-construction-page'] = array('name' => 'UnderConstructionPage', 'desc' => 'Working on your site? Put it in the under construction mode.');
        $plugins['wp-external-links'] = array('name' => 'WP External Links', 'desc' => 'Manage all external & internal links. Control icons, nofollow, noopener, UGC, sponsored and if links open in new window or new tab.');

        echo '<div class="card" data-collection-id="1">';
        WP_Reset_Utility::wp_kses_wf($this->get_card_header('Must Have WordPress Plugins', 'collection-id-1', array('collapse_button' => false)));
        echo '<div class="card-body"><div class="thirdx2"><p class="_mb0"></p><div class="dropdown  dropdown-right">
    <a class="button dropdown-toggle" href="#">Install collection</a>
    <div class="dropdown-menu">
      <a class="dropdown-item install-collection" data-activate="true" href="#">Install &amp; activate collection</a>
      <a class="dropdown-item install-collection" href="#">Install collection</a>
      <a data-feature="collections" class="dropdown-item button-pro-feature" href="#">Delete installed plugins &amp; themes then install &amp; activate collection - <span class="pro-feature" data-feature="cloud-wpr"><span class="pro">PRO</span> Feature</span></a>
      <a data-feature="collections" class="dropdown-item button-pro-feature" href="#">Delete installed plugins &amp; themes then install collection - <span class="pro-feature" data-feature="cloud-wpr"><span class="pro">PRO</span> Feature</span></a>
    </div>
    </div><a class="button add-collection-item button-pro-feature" href="#">Add new plugin or theme - <span data-feature="collections" class="pro-feature"><span class="pro">PRO</span> feature</span></a></div><div class="third textright"><p class="_mb0"></p><div class="dropdown">
    <a class="button dropdown-toggle" href="#">Actions</a>
    <div class="dropdown-menu">
      <a class="dropdown-item button-pro-feature" href="#">Add new collection - <span class="pro-feature" data-feature="collections"><span class="pro">PRO</span> Feature</span></a>
      <a class="dropdown-item button-pro-feature" href="#">Rename collection - <span class="pro-feature" data-feature="collections"><span class="pro">PRO</span> Feature</span></a>
      <a class="dropdown-item button-delete button-pro-feature" href="#">Delete collection - <span class="pro-feature" data-feature="collections"><span class="pro">PRO</span> Feature</span></a>
    </div>
    </div><p></p></div><table class="collection-table"><tbody><tr><th>Type</th><th>Name &amp; Note</th><th class="actions">Actions</th></tr>';
        foreach ($plugins as $slug => $plugin) {
            echo '<tr data-slug="' . esc_attr($slug) . '"><td><span class="dashicons dashicons-admin-plugins tooltip" title="Plugin"></span><span class="dashicons dashicons-wordpress tooltip" title="Comes from the WordPress repository"></span></td><td class="collection-item-details"><span>' . esc_html($plugin['name']) . '</span><i>' . esc_html($plugin['desc']) . '</i></td><td class="textcenter"><div class="dropdown">
            <a class="button dropdown-toggle" href="#">Actions</a>
            <div class="dropdown-menu">
                <a href="#" class="dropdown-item install-collection-item button-pro-feature">Install - <span class="pro-feature" data-feature="collections"><span class="pro">PRO</span> Feature</span></a>
                <a href="#" class="dropdown-item install-collection-item button-pro-feature">Install &amp; Activate - <span class="pro-feature" data-feature="collections"><span class="pro">PRO</span> Feature</span></a>
                <a href="#" class="dropdown-item edit-collection-item button-pro-feature">Edit - <span class="pro-feature" data-feature="collections"><span class="pro">PRO</span> Feature</span></a>
                <a href="#" class="dropdown-item button-delete button-link-delete delete-collection-item button-pro-feature">Delete - <span class="pro-feature" data-feature="collections"><span class="pro">PRO</span> Feature</span></a>
            </div>
        </div></td></tr>';
        } // foreach plugin
        echo '</tbody></table></div></div>';
    } // tab_collections


    /**
     * Echoes content for support tab
     *
     * @return null
     */
    private function tab_support()
    {
        echo '<div class="card">';
        WP_Reset_Utility::wp_kses_wf($this->get_card_header(__('Documentation', 'wp-reset'), 'support-documentation', array('collapse_button' => false)));
        echo '<div class="card-body">';
        /* translators: %s is replaced with the link to the documentation page */
        WP_Reset_Utility::wp_kses_wf('<p class="mb0">' . sprintf(__('All tools and features are explained in detail in <a href="%s" target="_blank">the documentation</a>. We did our best to describe how things work on both the code level and an "average user" level.', 'wp-reset'), esc_url($this->generate_web_link('support-tab', '/documentation/'))) . '</p>');
        echo '</div>';
        echo '</div>'; // documentation

        echo '<div class="card">';
        WP_Reset_Utility::wp_kses_wf($this->get_card_header('Emergency Recovery Script', 'support-ers', array('collapse_button' => false, 'pro' => true)));
        echo '<div class="card-body">';
        echo '<p>Emergency Recovery Script is a standalone, single-file, WordPress independent PHP script created to <b>recover WordPress sites from the most difficult situations</b>. When access to the admin is not possible when core files are compromised (accidental delete or malware related situations), when you get the white screen of death, can\'t log in for whatever reason or a plugin has killed your site - emergency recovery script can fix the problem! Some of the things ERS can do;</p>';
        echo '<ul class="plain-list">';
        echo '<li>Test the integrity of all WP core files and reinstall them if needed</li>';
        echo '<li>Detect and remove all files in core folders that are not a part of WP</li>';
        echo '<li>Deactivate and activate plugins without logging in to WP admin</li>';
        echo '<li>Deactivate and activate themes without logging in to WP admin</li>';
        echo '<li>Reset user privileges and roles</li>';
        echo '<li>Create new WP admin accounts without logging in to WP admin or knowing the admin username/password</li>';
        echo '<li>Modify WordPress address and site address</li>';
        echo '</ul>';
        echo '<p class="mb0">You can install the script as a preventive measure, so it\'s always available in case of an emergency (don\'t worry, it\'s password protected), or upload it only when needed. On production sites, when big and potentially dangerous changes rarely happen, we suggest uploading it only when needed. On test sites, have it ready in advance because there\'s a higher probability that you\'ll need it. Emergency Recovery Script is a <span class="pro-feature pro-feature-text" data-feature="support-ers">WP Reset <span>PRO</span></span> tool.</p>';
        echo '</div>';
        echo '</div>'; // emergency recovery script

        echo '<div class="card">';
        WP_Reset_Utility::wp_kses_wf($this->get_card_header(__('Public Support Forum', 'wp-reset'), 'support-forum', array('collapse_button' => false)));
        echo '<div class="card-body">';
        WP_Reset_Utility::wp_kses_wf('<p>' . __('We are very active on the <a href="https://wordpress.org/support/plugin/wp-reset" target="_blank">official WP Reset support forum</a>. If you found a bug, have a feature idea or just want to say hi - please drop by. We love to hear back from our users.', 'wp-reset') . '</p>');
        echo '</div>';
        echo '</div>'; // forum

        echo '<div class="card">';
        WP_Reset_Utility::wp_kses_wf($this->get_card_header(__('Premium Email Support', 'wp-reset'), 'support-email', array('collapse_button' => false, 'pro' => true)));
        echo '<div class="card-body">';
        echo '<p class="mb0">Need urgent support? Have one of our devs personally help you with your issue. All PRO license holders have access to premium email support. Get <span class="pro-feature pro-feature-text" data-feature="support-email">WP Reset <span>PRO</span></span> now.</p>';
        echo '</div>';
        echo '</div>'; // email support

        echo '<div class="card">';
        WP_Reset_Utility::wp_kses_wf($this->get_card_header(__('Care to Help Out?', 'wp-reset'), 'support-help-out', array('collapse_button' => false)));
        echo '<div class="card-body">';
        WP_Reset_Utility::wp_kses_wf('<p class="mb0">' . __('No need for donations :) If you can give us a <a href="https://wordpress.org/support/plugin/wp-reset/reviews/#new-post" target="_blank">five star rating</a> you\'ll help out more than you can imagine. A public mention <a href="https://twitter.com/webfactoryltd" target="_blank">@webfactoryltd</a> also does wonders. Thank you!', 'wp-reset') . '</p>');
        echo '</div>';
        echo '</div>'; // help out
    } // tab_support


    /**
     * Echoes content for pro tab
     *
     * @return null
     */
    private function tab_pro()
    {
        $agency_lifetime = $this->generate_web_link('pricing-table', '/buy/', array('p' => 'wp-reset-pro-agency-ltd-launch'));
        $team_lifetime = $this->generate_web_link('pricing-table', '/', array(), 'pricing');
        $personal_lifetime = $this->generate_web_link('pricing-table', '/buy/', array('p' => 'wp-reset-pro-personal-ltd-launch'));

        echo '<div class="card">';
        WP_Reset_Utility::wp_kses_wf($this->get_card_header(__('WP Reset PRO', 'wp-reset'), 'pro-features', array('collapse_button' => false)));
        echo '<div class="card-body">';
        echo '<p>More ways to reset your site, more tools, automatic snapshots, collections, email support and the emergency recover script - that\'s WP Reset PRO in a nutshell. The same <b>quality and easy-of-use</b> you experienced in the free version is very much a part of the PRO one, but extended and upgraded with more tools that will save you even more time.</p>';
        echo '<p>WP Reset PRO is aimed towards <b>webmasters, agencies, and everyone who buildsa a lot of WordPress sites</b>. It\'s much, much more than a "reset" tool. It\'s an easy way to start a new site, to test changes and to get out of the thickest jams. And thanks to its cloud features and the Dashboard it\'ll give you access to collections and snapshots on all the sites you\'re working on - instantly, without dragging any files along.</p>';
        echo '<p>Give WP Reset PRO a go. <b>It\'ll pay itself out in hours saved within the first few days!</b></p>';
        echo '<p>If you already have a PRO license, activate it below.</p>';
        echo '<p class="textcenter"><a href="#" data-feature="purchase-pro" class="button-pro-feature button button-delete">Get PRO now</a></p>';
        echo '</div>';
        echo '</div>';

        echo '<div class="card">';
        WP_Reset_Utility::wp_kses_wf($this->get_card_header(__('Activate PRO License', 'wp-reset'), 'pro-activate', array('collapse_button' => false)));
        echo '<div class="card-body">';

        echo '<p>License key is visible on the confirmation screen, right after purchasing. You can also find it in the confirmation email sent to the email address provided on purchase. Or use keys created with the <a href="https://dashboard.wpreset.com/licenses/" target="_blank">license manager</a>.</p>
    <p>If you don\'t have a license - <a class="button-pro-feature" href="#" data-feature="purchase-pro2">purchase one now</a>. In case of problems with the license please <a href="' . esc_url($this->generate_web_link('pro-tab-license', '/contact/')) . '" target="_blank">contact support</a>.</p>';

        echo '<hr>';
        echo '<p><label for="wpr-license-key">License Key: </label><input class="regular-text" type="text" id="wpr-license-key" value="' . ($this->license->get_license('license_key') != 'keyless' ? esc_attr($this->license->get_license('license_key')) : '') . '" placeholder="12345678-12345678-12345678-12345678">';

        echo '<br><label>Status: </label>';
        if ($this->license->is_active()) {
            $license_formatted = $this->license->get_license_formatted();
            echo '<b style="color: #66b317;">Active</b><br>
      <label>Type: </label>' . esc_html($license_formatted['name_long']);
            echo '<br><label>Valid: </label>' . esc_html($license_formatted['valid_until']);

            echo '<p>Thank you for purchasing WP Reset PRO! <b>Your license has been verified and activated.</b>';
            echo '<br>To start using the PRO version, please follow these steps:</p>';
            echo '<ol>';
            echo '<li><a href="https://dashboard.wpreset.com/pro-download/" target="_blank">Download</a> the latest version of the PRO plugin.</li>';
            echo '<li>Go to <a href="' . esc_url(admin_url('plugin-install.php')) . '">Plugins - Add New - Upload Plugin</a> and upload the ZIP you just downloaded.</li>';
            echo '<li>If asked to replace (overwrite) the free version - confirm it.</li>';
            echo '<li>Activate the plugin.</li>';
            echo '<li>That\'s it, no more steps.</li>';
            echo '</ol>';
        } else { // not active
            echo '<strong style="color: #ea1919;">Inactive</strong>';
            if (!empty($this->license->get_license('error'))) {
                echo '<br><label>Error: </label>' . esc_html($this->license->get_license('error'));
            }
        }
        echo '</p>';

        echo '<p>';
        if ($this->license->is_active()) {
            echo '<a href="#" id="wpr-save-license" data-text-wait="Validating. Please wait." class="button button-secondary">Save &amp; Revalidate License</a>';
            echo '&nbsp; &nbsp;<a href="#" id="wpr-deactivate-license" data-text-wait="Deactivating. Please wait." class="button button-delete">Deactivate License</a>';
        } else {
            echo '<a href="#" id="wpr-save-license" data-text-wait="Activating. Please wait." class="button button-primary">Save &amp; Activate License</a>';
            echo '&nbsp; &nbsp;<a href="#" data-text-wait="Activating. Please wait." class="button button-secondary" id="wpr-keyless-activation">Keyless Activation</a>';
        }
        echo '</p>';
        echo '<p class="mb0"><i>By attempting to activate a license you agree to share the following data with <a target="_blank" href="https://www.webfactoryltd.com/">WebFactory Ltd</a>: license key, site URL, site title, site WP version, site IP, and WP Reset plugin (free) version.</i>';
        echo '</p>';

        echo '</div>';
        echo '</div>'; // activate PRO

        WP_Reset_Utility::wp_kses_wf($this->pro_dialog());
    } // tab_pro


    function pro_dialog()
    {
        $out = '';

        $out .= '<div id="wpreset-pro-dialog" style="display: none;" title="WP Reset PRO"><span class="ui-helper-hidden-accessible"><input type="text"/></span>';

        $out .= '<div class="center logo"><a href="https://wpreset.com/?ref=wpreset-free-pricing-table" target="_blank"><img src="' . $this->plugin_url . 'img/wp-reset-logo.png' . '" alt="WP Reset PRO" title="WP Reset PRO"></a><br>';

        $out .= '<span>Limited PRO Offer - <b>all prices are LIFETIME</b>! Pay once &amp; use forever!</span>';
        $out .= '</div>';

        $out .= '<table id="wpreset-pro-table">';
        $out .= '<tr>';
        $out .= '<td class="center">Lifetime Personal License</td>';
        $out .= '<td class="center">Lifetime Team License</td>';
        $out .= '<td class="center">Lifetime Agency License</td>';
        $out .= '</tr>';

        $out .= '<tr class="prices">';
        $out .= '<td class="center"><del>$39 /year</del><br><span>$59</span> <b>/lifetime</b></td>';
        $out .= '<td class="center"><del>$79 /year</del><br><span>$69</span> <b>/lifetime</b></td>';
        $out .= '<td class="center"><del>$119 /year</del><br><span>$149</span> <b>/lifetime</b></td>';
        $out .= '</tr>';

        $out .= '<tr>';
        $out .= '<td><span class="dashicons dashicons-yes"></span><b>1 Site License</b></td>';
        $out .= '<td><span class="dashicons dashicons-yes"></span><b>5 Sites License</b></td>';
        $out .= '<td><span class="dashicons dashicons-yes"></span><b>100 Sites License</b></td>';
        $out .= '</tr>';

        $out .= '<tr>';
        $out .= '<td><span class="dashicons dashicons-yes"></span>All Plugin Features &amp; Tools</td>';
        $out .= '<td><span class="dashicons dashicons-yes"></span>All Plugin Features &amp; Tools</td>';
        $out .= '<td><span class="dashicons dashicons-yes"></span>All Plugin Features &amp; Tools</td>';
        $out .= '</tr>';

        $out .= '<tr>';
        $out .= '<td><span class="dashicons dashicons-yes"></span>Lifetime Updates &amp; Support</td>';
        $out .= '<td><span class="dashicons dashicons-yes"></span>Lifetime Updates &amp; Support</td>';
        $out .= '<td><span class="dashicons dashicons-yes"></span>Lifetime Updates &amp; Support</td>';
        $out .= '</tr>';

        $out .= '<tr>';
        $out .= '<td><span class="dashicons dashicons-yes"></span>2 GB WP Reset Cloud Storage</td>';
        $out .= '<td><span class="dashicons dashicons-yes"></span>10 GB WP Reset Cloud Storage</td>';
        $out .= '<td><span class="dashicons dashicons-yes"></span>100 GB WP Reset Cloud Storage</td>';
        $out .= '</tr>';

        $out .= '<tr>';
        $out .= '<td><span class="dashicons dashicons-yes"></span>Dropbox &amp; Google Drive support</td>';
        $out .= '<td><span class="dashicons dashicons-yes"></span>Dropbox &amp; Google Drive support</td>';
        $out .= '<td><span class="dashicons dashicons-yes"></span>Dropbox &amp; Google Drive support</td>';
        $out .= '</tr>';

        $out .= '<tr>';
        $out .= '<td><span class="dashicons dashicons-yes"></span>Plugins & Themes Collections</td>';
        $out .= '<td><span class="dashicons dashicons-yes"></span>Plugins & Themes Collections</td>';
        $out .= '<td><span class="dashicons dashicons-yes"></span>Plugins & Themes Collections</td>';
        $out .= '</tr>';

        $out .= '<tr>';
        $out .= '<td><span class="dashicons dashicons-yes"></span>Automatic Snapshots</td>';
        $out .= '<td><span class="dashicons dashicons-yes"></span>Automatic Snapshots</td>';
        $out .= '<td><span class="dashicons dashicons-yes"></span>Automatic Snapshots</td>';
        $out .= '</tr>';

        $out .= '<tr>';
        $out .= '<td><span class="dashicons dashicons-yes"></span>Emergency Recovery Script</td>';
        $out .= '<td><span class="dashicons dashicons-yes"></span>Emergency Recovery Script</td>';
        $out .= '<td><span class="dashicons dashicons-yes"></span>Emergency Recovery Script</td>';
        $out .= '</tr>';

        $out .= '<tr>';
        $out .= '<td><span class="dashicons dashicons-no"></span>Licenses &amp; Sites Manager</td>';
        $out .= '<td><span class="dashicons dashicons-yes"></span>Licenses &amp; Sites Manager</td>';
        $out .= '<td><span class="dashicons dashicons-yes"></span>Licenses &amp; Sites Manager</td>';
        $out .= '</tr>';

        $out .= '<tr>';
        $out .= '<td><span class="dashicons dashicons-no"></span>White-label Mode</td>';
        $out .= '<td><span class="dashicons dashicons-yes"></span>White-label Mode</td>';
        $out .= '<td><span class="dashicons dashicons-yes"></span>White-label Mode</td>';
        $out .= '</tr>';

        $out .= '<tr>';
        $out .= '<td><span class="dashicons dashicons-no"></span>Full Plugin Rebranding</td>';
        $out .= '<td><span class="dashicons dashicons-no"></span>Full Plugin Rebranding</td>';
        $out .= '<td><span class="dashicons dashicons-yes"></span>Full Plugin Rebranding</td>';
        $out .= '</tr>';

        $out .= '<tr>';
        $out .= '<td><a class="button button-buy" data-href-org="https://wpreset.com/buy2/?product=personal-free&ref=pricing-table" href="https://wpreset.com/buy2/?product=personal-free&ref=pricing-table" target="_blank">Lifetime License<br>$59 -&gt; BUY NOW</a>
    <br>or <a class="button-buy" data-href-org="https://wpreset.com/buy2/?product=personal-monthly&ref=pricing-table" href="https://wpreset.com/buy2/?product=personal-monthly&ref=pricing-table" target="_blank">only $6.99 <small>/month</small></a></td>';
        $out .= '<td><a class="button button-buy" data-href-org="https://wpreset.com/buy2/?product=team-free&ref=pricing-table" href="https://wpreset.com/buy2/?product=team-free&ref=pricing-table" target="_blank">Lifetime License<br>$69 -&gt; BUY NOW</a></td>';
        $out .= '<td><a class="button button-buy" data-href-org="https://wpreset.com/buy2/?product=agency-free&ref=pricing-table" href="https://wpreset.com/buy2/?product=agency-free&ref=pricing-table" target="_blank">Lifetime License<br>$149 -&gt; BUY NOW</a></td>';
        $out .= '</tr>';

        $out .= '</table>';

        $out .= '<div class="center footer"><b>100% No-Risk Money Back Guarantee!</b> If you don\'t like the plugin over the next 7 days, we will happily refund 100% of your money. No questions asked! Payments are processed by our merchant of records - <a href="https://paddle.com/" target="_blank">Paddle</a>.</div></div>';

        return $out;
    } // pro_dialog


    /**
     * Echoes content for snapshots tab
     *
     * @return null
     */
    private function tab_snapshots()
    {
        global $wpdb;
        $tbl_core = $tbl_custom = $tbl_size = $tbl_rows = 0;

        echo '<div class="card" id="card-snapshots">';
        echo '<h4>';
        echo esc_html__('Snapshots', 'wp-reset');
        echo '<div class="card-header-right"><a class="toggle-card tooltip" href="#" title="' . esc_html__('Collapse / expand box', 'wp-reset') . '"><span class="dashicons dashicons-arrow-up-alt2"></span></a></div>';
        echo '</h4>';
        echo '<div class="card-body">';
        echo '<p>A snapshot is a copy of all WP database tables, standard and custom ones, saved in the site\'s database. <a href="https://www.youtube.com/watch?v=xBfMmS12vMY" target="_blank">Watch a short video</a> overview and tutorial about Snapshots.</p>';

        echo '<p>Snapshots are primarily a development tool. When using various reset tools we advise using our 1-click snapshot tool available in every tool\'s confirmation dialog. If a full backup that includes files is needed, use one of the <a href="' . esc_url(admin_url('plugin-install.php?s=backup&tab=search&type=term')) . '" target="_blank">backup plugins</a> from the repo.</p>';

        echo '<p>Use snapshots to find out what changes a plugin made to your database or to quickly restore the dev environment after testing database related changes. Restoring a snapshot does not affect other snapshots, or WP Reset settings.</p>';

        echo '<p>To automatically generate snapshots on plugin, theme, and core update, activate, deactivate and similar events enable automatic snapshots available in <span class="pro-feature pro-feature-text" data-feature="snapshots-auto">WP Reset <span>PRO</span></span>.</p>';

        // phpcs:ignore db call warning as we are using uncommon queries
        $tables = $wpdb->get_results('SHOW TABLES', ARRAY_N); // phpcs:ignore
        if (is_array($tables)) {
            foreach ($tables as $table) {
                if (0 !== stripos($table[0], $wpdb->prefix)) {
                    continue;
                }

                if (in_array($table[0], $this->core_tables)) {
                    $tbl_core++;
                } else {
                    $tbl_custom++;
                }
            } // foreach

            echo '<p class="mb0"><b>Currently used WordPress tables</b>, prefixed with <i>' . esc_html($wpdb->prefix) . '</i>, consist of ' . esc_html($tbl_core) . ' standard and ';
            if ($tbl_custom) {
                echo esc_attr($tbl_custom) . ' custom table' . ($tbl_custom == 1 ? '' : 's');
            } else {
                echo 'no custom tables';
            }
            echo ' <span id="wpr-table-details"><a href="#" id="show-table-details">(show details)</a></span>';
        } else {
            echo '<b>Tables information is not available.</b> Something is not working properly on your site. Snapshots won\'t work.';
        }

        echo '</div>';
        echo '</div>';

        echo '<div class="card">';
        WP_Reset_Utility::wp_kses_wf($this->get_card_header('User Created Snapshots', 'snapshots-user', array('collapse_button' => 1, 'create_snapshot' => true, 'snapshot_actions' => true)));
        echo '<div class="card-body">';
        if ($snapshots = $this->get_snapshots()) {
            $snapshots = array_reverse($snapshots);
            echo '<table id="wpr-snapshots">';
            echo '<tr><th>Date</th><th>Description</th><th class="ss-size">Size</th><th class="ss-actions">&nbsp;</th></tr>';
            foreach ($snapshots as $ss) {
                echo '<tr id="wpr-ss-' . esc_attr($ss['uid']) . '">';
                if (!empty($ss['name'])) {
                    $name = $ss['name'];
                } else {
                    $name = 'created on ' . gmdate(get_option('date_format'), strtotime($ss['timestamp'])) . ' @ ' . gmdate(get_option('time_format'), strtotime($ss['timestamp']));
                }

                echo '<td>';
                if (current_time('timestamp') - strtotime($ss['timestamp']) > 12 * HOUR_IN_SECONDS) {
                    echo esc_attr(gmdate(get_option('date_format'), strtotime($ss['timestamp']))) . '<br>@ ' . esc_attr(gmdate(get_option('time_format'), strtotime($ss['timestamp'])));
                } else {
                    echo esc_attr(human_time_diff(strtotime($ss['timestamp']), current_time('timestamp'))) . ' ago';
                }
                echo '</td>';

                echo '<td>';
                if (!empty($ss['name'])) {
                    echo '<b>' . esc_html($ss['name']) . '</b><br>';
                }
                echo esc_attr($ss['tbl_core']) . ' standard &amp; ';
                if ($ss['tbl_custom']) {
                    echo esc_attr($ss['tbl_custom']) . ' custom table' . ($ss['tbl_custom'] == 1 ? '' : 's');
                } else {
                    echo 'no custom tables';
                }
                echo ' totaling ' . esc_attr(number_format($ss['tbl_rows'])) . ' rows</td>';
                echo '<td class="ss-size">' . esc_attr(WP_Reset_Utility::format_size($ss['tbl_size'])) . '</td>';
                echo '<td>';
                echo '<div class="dropdown">
        <a class="button dropdown-toggle" href="#">Actions</a>
        <div class="dropdown-menu">';
                echo '<a data-title="Current DB tables compared to snapshot %s" data-wait-msg="Comparing. Please wait." data-name="' . esc_attr($name) . '" title="Compare snapshot to current database tables" href="#" class="ss-action compare-snapshot dropdown-item tooltip" data-ss-uid="' . esc_attr($ss['uid']) . '">Compare snapshot to current data</a>';
                echo '<a data-btn-confirm="Restore snapshot" data-text-wait="Restoring snapshot. Please wait." data-text-confirm="Are you sure you want to restore the selected snapshot? There is NO UNDO.<br>Restoring the snapshot will delete all current standard and custom tables and replace them with tables from the snapshot." data-text-done="Snapshot has been restored. Click OK to reload the page with new data." title="Restore snapshot by overwriting current database tables" href="#" class="ss-action restore-snapshot dropdown-item tooltip" data-ss-uid="' . esc_attr($ss['uid']) . '">Restore snapshot</a>';
                echo '<a data-success-msg="Snapshot export created!<br><a href=\'%s\'>Download it</a>" data-wait-msg="Exporting snapshot. Please wait." title="Download snapshot as gzipped SQL dump" href="#" class="ss-action download-snapshot dropdown-item tooltip" data-ss-uid="' . esc_attr($ss['uid']) . '">Download snapshot</a>';
                echo '<a data-btn-confirm="Delete snapshot" data-text-wait="Deleting snapshot. Please wait." data-text-confirm="Are you sure you want to delete the selected snapshot and all its data? There is NO UNDO.<br>Deleting the snapshot will not affect the active database tables in any way." data-text-done="Snapshot has been deleted." title="Permanently delete snapshot" href="#" class="ss-action delete-snapshot dropdown-item tooltip" data-ss-uid="' . esc_attr($ss['uid']) . '">Delete snapshot</a>';
                echo '<a href="#" title="WP Reset PRO feature" data-feature="cloud-wpr" class="ss-action dropdown-item button-pro-feature tooltip">Upload to WP Reset Cloud - <span class="pro-feature" data-feature="cloud-wpr"><span class="pro">PRO</span> Feature</span></a>';
                echo '<a href="#" title="WP Reset PRO feature" class="ss-action dropdown-item button-pro-feature tooltip" data-feature="cloud-general">Upload to Dropbox, Google Drive, or pCloud - <span class="pro-feature" data-feature="cloud-general"><span class="pro">PRO</span> Feature</span></a>';
                echo '</div></div></td>';
                echo '</tr>';
            } // foreach
            echo '</table>';
            echo '<p id="ss-no-snapshots" class="mb0 textcenter hidden">There are no user created snapshots. <a href="#" class="create-new-snapshot">Create a new snapshot.</a></p>';
        } else {
            echo '<p id="ss-no-snapshots" class="mb0 textcenter">There are no user created snapshots. <a href="#" class="create-new-snapshot">Create a new snapshot.</a></p>';
        }
        echo '</div>';
        echo '</div>';

        echo '<div class="card">';
        WP_Reset_Utility::wp_kses_wf($this->get_card_header('Automatic Snapshots', 'snapshots-auto', array('collapse_button' => false, 'pro' => true)));
        echo '<div class="card-body">';
        echo '<p><span class="pro-feature pro-feature-text" data-feature="snapshots-auto">WP Reset <span>PRO</span></span> creates automatic snapshots before significant events occur on your site that can cause it to stop working correctly. Plugin, theme and core updates, plugin and theme activations and deactivations all of those can happen in the background without your knowledge. With automatic snapshots, you can roll back any update with a single click. Snapshots can be uploaded to the WP Reset Cloud, Dropbox, Google Drive or pCloud, giving you an extra layer of security.<br>
    Upgrade to <span class="pro-feature pro-feature-text" data-feature="snapshots-auto">WP Reset <span>PRO</span></span> to enable automatic snapshots and give your site an extra layer of safety.</p>';
        echo '</div>';
        echo '</div>';
    } // tab_snapshots


    /**
     * Helper function for generating links
     *
     * @param string  $placement  Optional. UTM content param.
     * @param string  $page       Optional. Page to link to.
     * @param array   $params     Optional. Extra URL params.
     * @param string  $anchor     Optional. URL anchor part.
     *
     * @return string
     */
    function generate_web_link($placement = '', $page = '/', $params = array(), $anchor = '')
    {
        $base_url = 'https://wpreset.com';

        if ('/' != $page) {
            $page = '/' . trim($page, '/') . '/';
        }
        if ($page == '//') {
            $page = '/';
        }

        if ($placement) {
            $placement = trim($placement);
            $placement = '-' . $placement;
        }

        $parts = array_merge(array('ref' => 'wp-reset-free' . $placement), $params);

        if (!empty($anchor)) {
            $anchor = '#' . trim($anchor, '#');
        }

        $out = $base_url . $page . '?' . http_build_query($parts, '', '&amp;') . $anchor;

        return $out;
    } // generate_web_link


    /**
     * Returns all saved snapshots from DB
     *
     * @return array
     */
    function get_snapshots()
    {
        $snapshots = get_option('wp-reset-snapshots', array());

        return $snapshots;
    } // get_snapshots


    /**
     * Returns all custom table names, with prefix
     *
     * @return array
     */
    function get_custom_tables()
    {
        global $wpdb;
        $custom_tables = array();

        // phpcs:ignore db call warning as we are using uncommon queries
        $table_status = $wpdb->get_results('SHOW TABLE STATUS'); // phpcs:ignore
        if (is_array($table_status)) {
            foreach ($table_status as $index => $table) {
                if (0 !== stripos($table->Name, $wpdb->prefix)) {
                    continue;
                }
                if (empty($table->Engine)) {
                    continue;
                }

                if (false === in_array($table->Name, $this->core_tables)) {
                    $custom_tables[] = array('name' => $table->Name, 'rows' => $table->Rows, 'data_length' => $table->Data_length, 'index_length' => $table->Index_length);
                }
            } // foreach
        }

        return $custom_tables;
    } // get_custom tables


    /**
     * Creates snapshot of current tables by copying them in the DB and saving metadata.
     *
     * @param int  $name  Optional. Name for the new snapshot.
     *
     * @return array|WP_Error Snapshot details in array on success, or error object on fail.
     */
    function do_create_snapshot($name = '')
    {
        global $wpdb;
        $snapshots = $this->get_snapshots();
        $snapshot = array();
        $uid = $this->generate_snapshot_uid();
        $tbl_core = $tbl_custom = $tbl_size = $tbl_rows = 0;

        if (!$uid) {
            return new WP_Error(1, 'Unable to generate a valid snapshot UID.');
        }

        if ($name) {
            $snapshot['name'] = substr(trim($name), 0, 64);
        } else {
            $snapshot['name'] = '';
        }
        $snapshot['uid'] = $uid;
        $snapshot['timestamp'] = current_time('mysql');

        // phpcs:ignore db call warning as we are using uncommon queries
        $table_status = $wpdb->get_results('SHOW TABLE STATUS'); // phpcs:ignore
        if (is_array($table_status)) {
            foreach ($table_status as $index => $table) {
                if (0 !== stripos($table->Name, $wpdb->prefix)) {
                    continue;
                }
                if (empty($table->Engine)) {
                    continue;
                }

                $tbl_rows += $table->Rows;
                $tbl_size += $table->Data_length + $table->Index_length;
                if (in_array($table->Name, $this->core_tables)) {
                    $tbl_core++;
                } else {
                    $tbl_custom++;
                }

                $wpdb->wpreset_snapshot_table_name = $table->Name;
                $wpdb->wpreset_snapshot_table_copy_name = $uid . '_' . $table->Name;
                
                // phpcs:ignore db call warning as we are using uncommon queries
                $wpdb->query("OPTIMIZE TABLE " . $wpdb->wpreset_snapshot_table_name); // phpcs:ignore
                $wpdb->query("CREATE TABLE " . $wpdb->wpreset_snapshot_table_copy_name . " LIKE " . $wpdb->wpreset_snapshot_table_name); // phpcs:ignore
                $wpdb->query("INSERT " . $wpdb->wpreset_snapshot_table_copy_name . " SELECT * FROM " . $wpdb->wpreset_snapshot_table_name); // phpcs:ignore
            } // foreach
        } else {
            return new WP_Error(1, 'Can\'t get table status data.');
        }

        $snapshot['tbl_core']   = $tbl_core;
        $snapshot['tbl_custom'] = $tbl_custom;
        $snapshot['tbl_rows']   = $tbl_rows;
        $snapshot['tbl_size']   = $tbl_size;


        $snapshots[$uid] = $snapshot;
        update_option('wp-reset-snapshots', $snapshots);

        do_action('wp_reset_create_snapshot', $uid, $snapshot);

        return $snapshot;
    } // create_snapshot


    /**
     * Delete snapshot metadata and tables from DB
     *
     * @param string  $uid  Snapshot unique 6-char ID.
     *
     * @return bool|WP_Error True on success, or error object on fail.
     */
    function do_delete_snapshot($uid = '')
    {
        global $wpdb;
        $snapshots = $this->get_snapshots();

        if (strlen($uid) != 6) {
            return new WP_Error(1, 'Invalid UID format.');
        }

        if (!isset($snapshots[$uid])) {
            return new WP_Error(1, 'Unknown snapshot ID.');
        }

        // phpcs:ignore db call warning as we are using uncommon queries
        $tables = $wpdb->get_col($wpdb->prepare('SHOW TABLES LIKE %s', array($uid . '\_%'))); // phpcs:ignore
        foreach ($tables as $table) {
            $wpdb->wpreset_snapshot_table = $table;
            $wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->wpreset_snapshot_table); // phpcs:ignore
        }

        $snapshot_copy = $snapshots[$uid];
        unset($snapshots[$uid]);
        update_option('wp-reset-snapshots', $snapshots);

        do_action('wp_reset_delete_snapshot', $uid, $snapshot_copy);

        return true;
    } // delete_snapshot


    /**
     * Exports snapshot as SQL dump; saved in gzipped file in WP_CONTENT folder.
     *
     * @param string  $uid  Snapshot unique 6-char ID.
     *
     * @return string|WP_Error Export base filename, or error object on fail.
     */
    function do_export_snapshot($uid = '')
    {
        global $wp_filesystem;
		$this->wp_init_filesystem();
        
        $snapshots = $this->get_snapshots();

        if (strlen($uid) != 6) {
            return new WP_Error(1, 'Invalid snapshot ID format.');
        }

        if (!isset($snapshots[$uid])) {
            return new WP_Error(1, 'Unknown snapshot ID.');
        }

        require_once $this->plugin_dir . 'libs/dumper.php';

        $snapshot_file_uid = md5($this->generate_snapshot_uid(10));
        try {
            $world_dumper = WPR_Shuttle_Dumper::create(array(
                'host' =>     DB_HOST,
                'username' => DB_USER,
                'password' => DB_PASSWORD,
                'db_name' =>  DB_NAME,
            ));

            $folder = wp_mkdir_p(trailingslashit(WP_CONTENT_DIR) . $this->snapshots_folder);
            if (!$folder) {
                return new WP_Error(1, 'Unable to create wp-content/' . $this->snapshots_folder . '/ folder.');
            }

            $htaccess_content = 'AddType application/octet-stream .gz' . PHP_EOL;
            $htaccess_content .= 'Options -Indexes' . PHP_EOL;

            $wp_filesystem->put_contents(trailingslashit(WP_CONTENT_DIR) . $this->snapshots_folder . '/.htaccess', $htaccess_content);

            $world_dumper->dump(trailingslashit(WP_CONTENT_DIR) . $this->snapshots_folder . '/wp-reset-snapshot-' . $snapshot_file_uid . '.sql.gz', $uid . '_');
        } catch (Shuttle_Exception $e) {
            return new WP_Error(1, 'Couldn\'t create snapshot: ' . $e->getMessage());
        }

        do_action('wp_reset_export_snapshot', 'wp-reset-snapshot-' . $snapshot_file_uid . '.sql.gz');

        return 'wp-reset-snapshot-' . $snapshot_file_uid . '.sql.gz';
    } // export_snapshot


    /**
     * Replace current tables with ones in snapshot.
     *
     * @param string  $uid  Snapshot unique 6-char ID.
     *
     * @return bool|WP_Error True on success, or error object on fail.
     */
    function do_restore_snapshot($uid = '')
    {
        // phpcs:ignore db call warning as we are using uncommon queries
        global $wpdb;
        $new_tables = array();
        $snapshots = $this->get_snapshots();

        if (($res = $this->verify_snapshot_integrity($uid)) !== true) {
            return $res;
        }

        $table_status = $wpdb->get_results('SHOW TABLE STATUS'); // phpcs:ignore
        if (is_array($table_status)) {
            foreach ($table_status as $index => $table) {
                if (0 !== stripos($table->Name, $uid . '_')) {
                    continue;
                }
                if (empty($table->Engine)) {
                    continue;
                }

                $new_tables[] = $table->Name;
            } // foreach
        } else {
            return new WP_Error(1, 'Can\'t get table status data.');
        }

        foreach ($table_status as $index => $table) {
            if (0 !== stripos($table->Name, $wpdb->prefix)) {
                continue;
            }
            if (empty($table->Engine)) {
                continue;
            }

            $wpdb->wpreset_snapshot_table = $table->Name;
            $wpdb->query('DROP TABLE ' . $wpdb->wpreset_snapshot_table); // phpcs:ignore
        } // foreach

        // copy snapshot tables to original name
        foreach ($new_tables as $table) {
            $wpdb->wpreset_snapshot_table = $table;
            $wpdb->wpreset_snapshot_table_new = str_replace($uid . '_', '', $table);

            $wpdb->query("CREATE TABLE " . $wpdb->wpreset_snapshot_table_new . " LIKE " . $wpdb->wpreset_snapshot_table); // phpcs:ignore
            $wpdb->query("INSERT " . $wpdb->wpreset_snapshot_table_new . " SELECT * FROM " . $wpdb->wpreset_snapshot_table); // phpcs:ignore
        }

        wp_cache_flush();
        update_option('wp-reset', $this->options);
        update_option('wp-reset-snapshots', $snapshots);

        do_action('wp_reset_restore_snapshot', $uid);

        return true;
    } // restore_snapshot


    /**
     * Verifies snapshot integrity by comparing metadata and data in DB
     *
     * @param string  $uid  Snapshot unique 6-char ID.
     *
     * @return bool|WP_Error True on success, or error object on fail.
     */
    function verify_snapshot_integrity($uid)
    {
        // phpcs:ignore db call warning as we are using uncommon queries
        global $wpdb;
        $tbl_core = $tbl_custom = 0;
        $snapshots = $this->get_snapshots();

        if (strlen($uid) != 6) {
            return new WP_Error(1, 'Invalid snapshot ID format.');
        }

        if (!isset($snapshots[$uid])) {
            return new WP_Error(1, 'Unknown snapshot ID.');
        }

        $snapshot = $snapshots[$uid];

        $table_status = $wpdb->get_results('SHOW TABLE STATUS'); // phpcs:ignore
        if (is_array($table_status)) {
            foreach ($table_status as $index => $table) {
                if (0 !== stripos($table->Name, $uid . '_')) {
                    continue;
                }
                if (empty($table->Engine)) {
                    continue;
                }

                if (in_array(str_replace($uid . '_', '', $table->Name), $this->core_tables)) {
                    $tbl_core++;
                } else {
                    $tbl_custom++;
                }
            } // foreach

            if ($tbl_core != $snapshot['tbl_core'] || $tbl_custom != $snapshot['tbl_custom']) {
                return new WP_Error(1, 'Snapshot data has been compromised. Saved metadata does not match data in the DB. Contact WP Reset support if data is critical, or restore it via a MySQL GUI.');
            }
        } else {
            return new WP_Error(1, 'Can\'t get table status data.');
        }

        return true;
    } // verify_snapshot_integrity


    /**
     * Compares a selected snapshot with the current table set in DB
     *
     * @param string  $uid  Snapshot unique 6-char ID.
     *
     * @return string|WP_Error Formatted table with details on success, or error object on fail.
     */
    function do_compare_snapshots($uid)
    {
        // phpcs:ignore db call warning as we are using uncommon queries
        global $wpdb;
        $current = $snapshot = array();
        $out = $out2 = $out3 = '';

        if (($res = $this->verify_snapshot_integrity($uid)) !== true) {
            return $res;
        }

        $table_status = $wpdb->get_results('SHOW TABLE STATUS'); // phpcs:ignore
        foreach ($table_status as $index => $table) {
            if (empty($table->Engine)) {
                continue;
            }

            if (0 !== stripos($table->Name, $uid . '_') && 0 !== stripos($table->Name, $wpdb->prefix)) {
                continue;
            }

            $info = array();
            $info['rows'] = $table->Rows;
            $info['size_data'] = $table->Data_length;
            $info['size_index'] = $table->Index_length;
            $wpdb->wpreset_table_name = $table->Name;
            $schema = $wpdb->get_row('SHOW CREATE TABLE ' . $wpdb->wpreset_table_name, ARRAY_N); // phpcs:ignore
            $info['schema'] = $schema[1];
            $info['engine'] = $table->Engine;
            $info['fullname'] = $table->Name;
            $basename = str_replace(array($uid . '_'), array(''), $table->Name);
            $info['basename'] = $basename;
            $info['corename'] = str_replace(array($wpdb->prefix), array(''), $basename);
            $info['uid'] = $uid;

            if (0 === stripos($table->Name, $uid . '_')) {
                $snapshot[$basename] = $info;
            }

            if (0 === stripos($table->Name, $wpdb->prefix)) {
                $info['uid'] = '';
                $current[$basename] = $info;
            }
        } // foreach

        $in_both = array_keys(array_intersect_key($current, $snapshot));
        $in_current_only = array_diff_key($current, $snapshot);
        $in_snapshot_only = array_diff_key($snapshot, $current);

        $out .= '<br><br>';
        foreach ($in_current_only as $table) {
            $out .= '<div class="wpr-table-container in-current-only" data-table="' . esc_attr($table['basename']) . '">';
            $out .= '<table>';
            $out .= '<tr title="Click to show/hide more info" class="wpr-table-missing header-row">';
            $out .= '<td><b>' . $table['fullname'] . '</b></td>';
            $out .= '<td>table is not present in snapshot<span class="dashicons dashicons-arrow-down-alt2"></span></td>';
            $out .= '</tr>';
            $out .= '<tr class="hidden">';
            $out .= '<td>';
            $out .= '<p>' . number_format($table['rows']) . ' row' . ($table['rows'] == 1 ? '' : 's') . ' totaling ' . WP_Reset_Utility::format_size($table['size_data']) . ' in data and ' . WP_Reset_Utility::format_size($table['size_index']) . ' in index.</p>';
            $out .= '<pre>' . $table['schema'] . '</pre>';
            $out .= '</td>';
            $out .= '<td>&nbsp;</td>';
            $out .= '</tr>';
            $out .= '</table>';
            $out .= '</div>';
        } // foreach in current only

        foreach ($in_snapshot_only as $table) {
            $out .= '<div class="wpr-table-container in-snapshot-only" data-table="' . esc_attr($table['basename']) . '">';
            $out .= '<table>';
            $out .= '<tr title="Click to show/hide more info" class="wpr-table-missing header-row">';
            $out .= '<td>table is not present in current tables</td>';
            $out .= '<td><b>' . esc_html($table['fullname']) . '</b><span class="dashicons dashicons-arrow-down-alt2"></span></td>';
            $out .= '</tr>';
            $out .= '<tr class="hidden">';
            $out .= '<td>&nbsp;</td>';
            $out .= '<td>';
            $out .= '<p>' . number_format($table['rows']) . ' row' . ($table['rows'] == 1 ? '' : 's') . ' totaling ' . WP_Reset_Utility::format_size($table['size_data']) . ' in data and ' . WP_Reset_Utility::format_size($table['size_index']) . ' in index.</p>';
            $out .= '<pre>' . $table['schema'] . '</pre>';
            $out .= '</td>';
            $out .= '</tr>';
            $out .= '</table>';
            $out .= '</div>';
        } // foreach in snapshot only

        foreach ($in_both as $tablename) {
            $tbl_current = $current[$tablename];
            $tbl_snapshot = $snapshot[$tablename];

            $schema1 = preg_replace('/(auto_increment=)([0-9]*) /i', '${1}1 ', $tbl_current['schema'], 1);
            $schema2 = preg_replace('/(auto_increment=)([0-9]*) /i', '${1}1 ', $tbl_snapshot['schema'], 1);
            $tbl_snapshot['tmp_schema'] = str_replace($tbl_snapshot['uid'] . '_' . $tablename, $tablename, $tbl_snapshot['schema']);
            $schema2 = str_replace($tbl_snapshot['uid'] . '_' . $tablename, $tablename, $schema2);

            if ($tbl_current['rows'] == $tbl_snapshot['rows'] && $tbl_current['schema'] == $tbl_snapshot['tmp_schema']) {
                $out3 .= '<div class="wpr-table-container identical" data-table="' . esc_attr($tablename) . '">';
                $out3 .= '<table>';
                $out3 .= '<tr title="Click to show/hide more info" class="wpr-table-match header-row">';
                $out3 .= '<td><b>' . $tbl_current['fullname'] . '</b></td>';
                $out3 .= '<td><b>' . $tbl_snapshot['fullname'] . '</b><span class="dashicons dashicons-arrow-down-alt2"></span></td>';
                $out3 .= '</tr>';
                $out3 .= '<tr class="hidden">';
                $out3 .= '<td>';
                $out3 .= '<p>' . number_format($tbl_current['rows']) . ' rows totaling ' . WP_Reset_Utility::format_size($tbl_current['size_data']) . ' in data and ' . WP_Reset_Utility::format_size($tbl_current['size_index']) . ' in index.</p>';
                $out3 .= '<pre>' . $tbl_current['schema'] . '</pre>';
                $out3 .= '</td>';
                $out3 .= '<td>';
                $out3 .= '<p>' . number_format($tbl_snapshot['rows']) . ' rows totaling ' . WP_Reset_Utility::format_size($tbl_snapshot['size_data']) . ' in data and ' . WP_Reset_Utility::format_size($tbl_snapshot['size_index']) . ' in index.</p>';
                $out3 .= '<pre>' . $tbl_snapshot['schema'] . '</pre>';
                $out3 .= '</td>';
                $out3 .= '</tr>';
                $out3 .= '</table>';
                $out3 .= '</div>';
            } elseif ($schema1 != $schema2) {
                require_once $this->plugin_dir . 'libs/diff.php';
                require_once $this->plugin_dir . 'libs/diff/Renderer/Html/SideBySide.php';
                $diff = new WPR_Diff(explode("\n", $tbl_current['schema']), explode("\n", $tbl_snapshot['schema']), array('ignoreWhitespace' => false));
                $renderer = new WPR_Diff_Renderer_Html_SideBySide;

                $out2 .= '<div class="wpr-table-container" data-table="' . $tbl_current['basename'] . '">';
                $out2 .= '<table>';
                $out2 .= '<tr title="Click to show/hide more info" class="wpr-table-difference header-row">';
                $out2 .= '<td><b>' . $tbl_current['fullname'] . '</b> table schemas do not match</td>';
                $out2 .= '<td><b>' . $tbl_snapshot['fullname'] . '</b> table schemas do not match<span class="dashicons dashicons-arrow-down-alt2"></span></td>';
                $out2 .= '</tr>';
                $out2 .= '<tr class="hidden">';
                $out2 .= '<td>';
                $out2 .= '<p>' . number_format($tbl_current['rows']) . ' rows totaling ' . WP_Reset_Utility::format_size($tbl_current['size_data']) . ' in data and ' . WP_Reset_Utility::format_size($tbl_current['size_index']) . ' in index.</p>';
                $out2 .= '</td>';
                $out2 .= '<td>';
                $out2 .= '<p>' . number_format($tbl_snapshot['rows']) . ' rows totaling ' . WP_Reset_Utility::format_size($tbl_snapshot['size_data']) . ' in data and ' . WP_Reset_Utility::format_size($tbl_snapshot['size_index']) . ' in index.</p>';
                $out2 .= '</td>';
                $out2 .= '</tr>';
                $out2 .= '<tr class="hidden">';
                $out2 .= '<td colspan="2" class="no-padding">';
                $out2 .= $diff->Render($renderer);
                $out2 .= '</td>';
                $out2 .= '</tr>';
                $out2 .= '</table>';
                $out2 .= '</div>';
            } else {
                $out2 .= '<div class="wpr-table-container" data-table="' . $tbl_current['basename'] . '">';
                $out2 .= '<table>';
                $out2 .= '<tr title="Click to show/hide more info" class="wpr-table-difference header-row">';
                $out2 .= '<td><b>' . $tbl_current['fullname'] . '</b> data in tables does not match</td>';
                $out2 .= '<td><b>' . $tbl_snapshot['fullname'] . '</b> data in tables does not match<span class="dashicons dashicons-arrow-down-alt2"></span></td>';
                $out2 .= '</tr>';
                $out2 .= '<tr class="hidden">';
                $out2 .= '<td>';
                $out2 .= '<p>' . number_format($tbl_current['rows']) . ' rows totaling ' . WP_Reset_Utility::format_size($tbl_current['size_data']) . ' in data and ' . WP_Reset_Utility::format_size($tbl_current['size_index']) . ' in index.</p>';
                $out2 .= '</td>';
                $out2 .= '<td>';
                $out2 .= '<p>' . number_format($tbl_snapshot['rows']) . ' rows totaling ' . WP_Reset_Utility::format_size($tbl_snapshot['size_data']) . ' in data and ' . WP_Reset_Utility::format_size($tbl_snapshot['size_index']) . ' in index.</p>';
                $out2 .= '</td>';
                $out2 .= '</tr>';

                $out2 .= '<tr class="hidden">';
                $out2 .= '<td colspan="2">';
                if ($tbl_current['corename'] == 'options') {
                    $ss_prefix = $tbl_snapshot['uid'] . '_' . $wpdb->prefix;
                    //Due to the working with various table sets, not always prefixed with the WordPress Database Table prefix we need to use custom unprepared queries
                    $diff_rows = $wpdb->get_results("SELECT {$wpdb->prefix}options.option_name, {$wpdb->prefix}options.option_value AS current_value, {$ss_prefix}options.option_value AS snapshot_value FROM {$wpdb->prefix}options LEFT JOIN {$ss_prefix}options ON {$ss_prefix}options.option_name = {$wpdb->prefix}options.option_name WHERE {$wpdb->prefix}options.option_value != {$ss_prefix}options.option_value LIMIT 100;"); //phpcs:ignore
                    $only_current = $wpdb->get_results("SELECT {$wpdb->prefix}options.option_name, {$wpdb->prefix}options.option_value AS current_value, {$ss_prefix}options.option_value AS snapshot_value FROM {$wpdb->prefix}options LEFT JOIN {$ss_prefix}options ON {$ss_prefix}options.option_name = {$wpdb->prefix}options.option_name WHERE {$ss_prefix}options.option_value IS NULL LIMIT 100;"); //phpcs:ignore
                    $only_snapshot = $wpdb->get_results("SELECT {$wpdb->prefix}options.option_name, {$wpdb->prefix}options.option_value AS current_value, {$ss_prefix}options.option_value AS snapshot_value FROM {$wpdb->prefix}options LEFT JOIN {$ss_prefix}options ON {$ss_prefix}options.option_name = {$wpdb->prefix}options.option_name WHERE {$wpdb->prefix}options.option_value IS NULL LIMIT 100;"); //phpcs:ignore
                    $out2 .= '<table class="table_diff">';
                    $out2 .= '<tr><td style="width: 100px;"><b>Option Name</b></td><td><b>Current Value</b></td><td><b>Snapshot Value</b></td></tr>';
                    foreach ($diff_rows as $row) {
                        $out2 .= '<tr>';
                        $out2 .= '<td style="width: 100px;">' . $row->option_name . '</td>';
                        $out2 .= '<td>' . (empty($row->current_value) ? '<i>empty</i>' : $row->current_value) . '</td>';
                        $out2 .= '<td>' . (empty($row->snapshot_value) ? '<i>empty</i>' : $row->snapshot_value) . '</td>';
                        $out2 .= '</tr>';
                    } // foreach
                    foreach ($only_current as $row) {
                        $out2 .= '<tr>';
                        $out2 .= '<td style="width: 100px;">' . $row->option_name . '</td>';
                        $out2 .= '<td>' . (empty($row->current_value) ? '<i>empty</i>' : $row->current_value) . '</td>';
                        $out2 .= '<td><i>not found in snapshot</i></td>';
                        $out2 .= '</tr>';
                    } // foreach
                    foreach ($only_current as $row) {
                        $out2 .= '<tr>';
                        $out2 .= '<td style="width: 100px;">' . $row->option_name . '</td>';
                        $out2 .= '<td><i>not found in current tables</i></td>';
                        $out2 .= '<td>' . (empty($row->snapshot_value) ? '<i>empty</i>' : $row->snapshot_value) . '</td>';
                        $out2 .= '</tr>';
                    } // foreach
                    $out2 .= '</table>';
                } else {
                    $out2 .= '<p class="textcenter">Detailed data diff is not available for this table.</p>';
                }
                $out2 .= '</td>';
                $out2 .= '</tr>';

                $out2 .= '</table>';
                $out2 .= '</div>';
            }
        } // foreach in both

        return $out . $out2 . $out3;
    } // do_compare_snapshots


    /**
     * Generates a unique snapshot ID; verified non-existing
     *
     * @return string
     */
    function generate_snapshot_uid($length = 6)
    {
        global $wpdb;
        $snapshots = $this->get_snapshots();
        $cnt = 0;
        $uid = false;

        do {
            $cnt++;
            $uid = substr(str_shuffle(str_repeat('abcdefghijklmnopqrstuvwxyz', $length)), 0, $length);
            // phpcs:ignore db call warning as we are using uncommon queries
            $verify_db = $wpdb->get_col($wpdb->prepare('SHOW TABLES LIKE %s', array('%' . $uid . '%'))); // phpcs:ignore
        } while (!empty($verify_db) && isset($snapshots[$uid]) && $cnt < 30);

        if ($cnt == 30) {
            $uid = false;
        }

        return $uid;
    } // generate_snapshot_uid


    // auto download / install / activate WP Force SSL plugin
    function install_wpfssl()
    {
        check_ajax_referer('install_wpfssl');

        if (false === current_user_can('manage_options')) {
            wp_die('Sorry, you have to be an admin to run this action.');
        }

        $plugin_slug = 'wp-force-ssl/wp-force-ssl.php';
        $plugin_zip = 'https://downloads.wordpress.org/plugin/wp-force-ssl.latest-stable.zip';

        @include_once ABSPATH . 'wp-admin/includes/plugin.php';
        @include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
        @include_once ABSPATH . 'wp-admin/includes/plugin-install.php';
        @include_once ABSPATH . 'wp-admin/includes/file.php';
        @include_once ABSPATH . 'wp-admin/includes/misc.php';
        echo '<style>
		body{
			font-family: sans-serif;
			font-size: 14px;
			line-height: 1.5;
			color: #444;
		}
		</style>';

        echo '<div style="margin: 20px; color:#444;">';
        echo 'If things are not done in a minute <a target="_parent" href="' . esc_url(admin_url('plugin-install.php?s=force%20ssl%20webfactory&tab=search&type=term')) . '">install the plugin manually via Plugins page</a><br><br>';
        echo 'Starting ...<br><br>';

        wp_cache_flush();
        $upgrader = new Plugin_Upgrader();
        echo 'Check if WP Force SSL is already installed ... <br />';
        if ($this->is_plugin_installed($plugin_slug)) {
            echo 'WP Force SSL is already installed! <br /><br />Making sure it\'s the latest version.<br />';
            $upgrader->upgrade($plugin_slug);
            $installed = true;
        } else {
            echo 'Installing WP Force SSL.<br />';
            $installed = $upgrader->install($plugin_zip);
        }
        wp_cache_flush();

        if (!is_wp_error($installed) && $installed) {
            echo 'Activating WP Force SSL.<br />';
            $activate = activate_plugin($plugin_slug);

            if (is_null($activate)) {
                echo 'WP Force SSL Activated.<br />';

                echo '<script>setTimeout(function() { top.location = "tools.php?page=wp-reset"; }, 1000);</script>';
                echo '<br>If you are not redirected in a few seconds - <a href="tools.php?page=wp-reset" target="_parent">click here</a>.';
            }
        } else {
            echo 'Could not install WP Force SSL. You\'ll have to <a target="_parent" href="' . esc_url(admin_url('plugin-install.php?s=force%20ssl%20webfactory&tab=search&type=term')) . '">download and install manually</a>.';
        }

        echo '</div>';
    } // install_wpfssl

    /**
     * Initializes the WordPress filesystem.
     *
     * @return bool
     */
    function wp_init_filesystem()
    {
        if (! $this->filesystem_initialized) {
            if (! class_exists('WP_Filesystem')) {
                require_once ABSPATH . 'wp-admin/includes/file.php';
            }

            WP_Filesystem();
            $this->filesystem_initialized = true;
        }

        return true;
    }

    /**
     * Clean up on uninstall; no action on deactive at the moment
     *
     * @return null
     */
    static function uninstall()
    {
        delete_option('wp-reset');
        delete_option('wp-reset-snapshots');
    } // uninstall


    /**
     * Disabled; we use singleton pattern so magic functions need to be disabled
     *
     * @return null
     */
    function __clone() {}


    /**
     * Disabled; we use singleton pattern so magic functions need to be disabled
     *
     * @return null
     */
    function __sleep() {}


    /**
     * Disabled; we use singleton pattern so magic functions need to be disabled
     *
     * @return null
     */
    function __wakeup() {}
} // WP_Reset class


// Create plugin instance and hook things up
// Only if in admin - plugin has no frontend functionality
if (is_admin() || WP_Reset::is_cli_running()) {
    global $wp_reset;
    $wp_reset = WP_Reset::getInstance();
    add_action('plugins_loaded', array($wp_reset, 'load_textdomain'));
    register_uninstall_hook(__FILE__, array('WP_Reset', 'uninstall'));
}
