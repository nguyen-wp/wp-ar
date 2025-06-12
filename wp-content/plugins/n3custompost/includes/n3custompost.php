<?php

namespace N3Block;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class N3Block {
	/**
	 * @var N3Block
	 */
	private static $instance = null;

	/**
	 * @var Settings
	 */
	private $settings;

	/**
	 * @var ScriptsManager
	 */
	private $scriptsManager;

	/**
	 * @var FontIconsManager
	 */
	private $fontIconsManager;

	/**
	 * @var BlocksManager
	 */
	private $blocksManager;

	/**
	 * @var InstagramTokenManager
	 */
	private $instagramTokenManager;

	/**
	 * @var VersionControl
	 */
	private $versionControl;

	/**
	 * @var SettingsPage
	 */
	private $settingsPage;

	/**
	 * @var RestAPI
	 */
	private $restAPI;

	/**
	 * @var PostTemplatePart
	 */
	private $postTemplatePart;

	/**
	 * @var AllowedCssTags
	 */
	private $allowedCssTags;

	/**
	 * @var Mailer
	 */
	private $mailer;

	/**
	 * @var AssetsOptimization
	 */
	private $assetsOptimization;

	private function __construct() {

		require_once N3BLOCK_PLUGIN_DIR . 'includes/load.php';

		$this->assetsOptimization = AssetsOptimization::getInstance();

		add_action( 'init', array( $this, 'init' ), 0 );

		// add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 2 );
		add_filter( 'plugin_action_links_' . N3BLOCK_PLUGIN_BASENAME, array( $this, 'plugin_action_links' ) );

		add_filter( 'plugin_row_meta', array( $this, '__madeapp_plugin_row_meta' ), 10, 2 );
	}

	// ADD SETTING LINK 
	public static function __madeapp_plugin_row_meta( $links, $file ) {
		if( $file === 'n3custompost/n3custompost.php' ||  $file === 'madelab-testimonials/nguyen-app.php' ){
			$links[] = '<a href="https://nguyenpham.pro/" target="_blank">' . esc_html__( 'Author', 'duplicate-post' ) . '</a>';
		}
		return $links;
	}

	/**
	 * Init N3Block when WordPress Initialises.
	 */
	public function init() {
		$this->settings = new Settings();
		$this->versionControl = new VersionControl();
		$this->scriptsManager = new ScriptsManager();
		$this->fontIconsManager = new FontIconsManager();
		$this->blocksManager = new BlocksManager();
		$this->instagramTokenManager = new InstagramTokenManager();
		$this->settingsPage = new SettingsPage();
		$this->restAPI = new RestAPI();
		$this->postTemplatePart = new PostTemplatePart();
		$this->allowedCssTags = new AllowedCssTags();
		$this->mailer = new Mailer();
	}

    /**
     * @return ScriptsManager
     */
    public function scriptsManager(){
        return $this->scriptsManager;
    }

    /**
     * @return FontIconsManager
     */
    public function fontIconsManager(){
        return $this->fontIconsManager;
    }

    /**
     * @return BlocksManager
     */
    public function blocksManager(){
        return $this->blocksManager;
    }

    /**
     * @return InstagramTokenManager
     */
    public function instagramTokenManager(){
        return $this->instagramTokenManager;
    }

    /**
     * @return VersionControl
     */
    public function versionControl(){
        return $this->versionControl;
    }

    /**
     * @return SettingsPage
     */
    public function settingsPage(){
        return $this->settingsPage;
    }

    /**
     * @return RestAPI
     */
    public function restAPI(){
        return $this->restAPI;
    }

    /**
     * @return PostTemplatePart
     */
    public function postTemplatePart(){
        return $this->postTemplatePart;
    }

    /**
     * @return AllowedCssTags
     */
    public function allowedCssTags(){
        return $this->allowedCssTags;
    }

    /**
     * @return Mailer
     */
    public function mailer(){
        return $this->mailer;
    }

	/**
     * @return Settings
     */
    public function settings(){
        return $this->settings;
    }

	/**
     * @return AssetsOptimization
     */
    public function assetsOptimization(){
        return $this->assetsOptimization;
    }

    /**
     * @return N3Block
     */
    public static function getInstance(){
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

	public function is_rest_api_request() {

		if ( empty( $_SERVER['REQUEST_URI'] ) ) {
			return false;
		}

		$rest_prefix         = trailingslashit( rest_get_url_prefix() );
		$is_rest_api_request = ( false !== strpos( $_SERVER['REQUEST_URI'], $rest_prefix ) );

		return apply_filters( 'n3custompost/is_rest_api_request', $is_rest_api_request );
	}

	/**
	 * Show row meta on the plugin screen.
	 *
	 * @return array
	 */
	public function plugin_row_meta( $links, $file ) {

		if ( N3BLOCK_PLUGIN_BASENAME === $file ) {

			$row_meta = array(
				'support' => '<a href="' . esc_url( 'https://wordpress.org/support/plugin/n3custompost/' ) . '" aria-label="' .
					esc_attr__( 'Support', 'n3custompost' ) . '">' . esc_html__( 'Support', 'n3custompost' ) . '</a>',
				'review' => '<a href="' . esc_url( 'https://wordpress.org/support/plugin/n3custompost/reviews/' ) . '" aria-label="' .
					esc_attr__( 'Write a Review', 'n3custompost' ) . '">' . esc_html__( 'Write a Review', 'n3custompost' ) . '</a>',
			);

			return array_merge( $links, $row_meta );
		}

		return (array) $links;
	}

	public function plugin_action_links( $actions ) {

		if ( current_user_can( 'manage_options' ) ) {

			$settings_url = $this->settingsPage->getTabUrl('general');

			return array_merge(
				$actions,
				array( 'settings' => sprintf( '<a href="%s">%s</a>', $settings_url, __( 'Settings', 'n3custompost' ) ) )
			);
		}

		return $actions;
	}

}
