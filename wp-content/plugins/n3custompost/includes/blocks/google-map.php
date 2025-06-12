<?php

namespace N3Block\Blocks;

class GoogleMap extends \N3Block\Blocks\AbstractBlock {

	protected static $blockName = 'n3custompost/map';

    public function __construct() {

        parent::__construct( self::$blockName );

        register_block_type(
            'n3custompost/map',
            array(
                'render_callback' => [ $this, 'render_callback' ]
            )
        );

		add_action( 'wp_ajax_get_google_api_key', [ $this, 'get_google_api_key'] );

		n3custompost_maybe_add_option( 'n3custompost_google_api_key', '', true );

		if ( $this->isEnabled() ) {

			add_filter( 'n3custompost/editor_blocks_js/dependencies', [ $this, 'block_editor_scripts'] );

			wp_register_script(
				'unescape',
				n3custompost_get_plugin_url( 'vendors/lodash.unescape/unescape.min.js' ),
				[],
				'4.0.1',
				true
			);

			wp_register_script(
				'n3custompost-map-styles',
				n3custompost_get_plugin_url( 'vendors/n3custompost/map-styles.min.js' ),
				[],
				'1.0.0',
				true
			);
		}
    }

	public function getLabel() {
		return __('Google Maps', 'n3custompost');
	}

    public function block_editor_scripts($scripts) {

		//map-styles.min.js
        if ( ! in_array( 'n3custompost-map-styles', $scripts ) ) {
            array_push( $scripts, 'n3custompost-map-styles' );
        }

        return $scripts;
	}

    public function get_google_api_key() {

		$nonce = sanitize_key( $_POST['nonce'] );
        $action = sanitize_text_field( wp_unslash( $_POST['option'] ) );
        $data = sanitize_text_field( wp_unslash( $_POST['data'] ) );

        if ( ! wp_verify_nonce( $nonce, 'n3custompost_nonce_google_api_key' ) ) {
            wp_send_json_error();
        }

        $response = false;
        if ($action == 'get') {
            $response = get_option( 'n3custompost_google_api_key', '');
        } elseif ($action == 'set') {
            $response = update_option( 'n3custompost_google_api_key', $data );
        } elseif ($action == 'delete') {
            $response = delete_option( 'n3custompost_google_api_key' );
        }

        wp_send_json_success( $response );
    }

    public function block_frontend_assets( $attributes = [], $content = '' ) {

        if ( is_admin() ) {
            return;
        }

		/**
		 * data-map-style="custom"
		 * data-map-style="default"
		 * data-map-style="ultra_light"
		 */
		$has_custom_style = (
			false === strpos( $content, 'data-map-style="default"' ) &&
			false === strpos( $content, 'data-map-style="custom"' )
		);
		//map-styles.js
        if ( $has_custom_style && ! wp_script_is( 'n3custompost-map-styles', 'enqueued' ) ) {
            wp_enqueue_script( 'n3custompost-map-styles' );
        }

        $api_key = get_option( 'n3custompost_google_api_key', '' );

        if ( $api_key ) {
            wp_enqueue_script( 'google_api_key_js', "https://maps.googleapis.com/maps/api/js?key={$api_key}", [], null );
		}

		//unescape.min.js
		if ( ! wp_script_is( 'unescape', 'enqueued' ) ) {
			wp_enqueue_script( 'unescape' );
		}

		if ( FALSE == n3custompost()->assetsOptimization()->load_assets_on_demand() ) {
			return;
		}

		$rtl = is_rtl() ? '.rtl' : '';

		wp_enqueue_style(
			self::$blockName,
			n3custompost_get_plugin_url( 'assets/blocks/map/style' . $rtl . '.css' ),
			[],
			n3custompost()->settings()->getVersion()
		);

		wp_enqueue_script(
            self::$blockName,
            n3custompost_get_plugin_url( 'assets/blocks/map/frontend.js' ),
            [ 'jquery', 'unescape' ],
            n3custompost()->settings()->getVersion(),
            true
        );
    }

    public function render_callback( $attributes, $content ) {

        $this->block_frontend_assets( $attributes, $content );

        return $content;
    }
}

n3custompost()->blocksManager()->addBlock(
	new \N3Block\Blocks\GoogleMap()
);
