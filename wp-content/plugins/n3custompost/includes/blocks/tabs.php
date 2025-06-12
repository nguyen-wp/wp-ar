<?php

namespace N3Block\Blocks;

class Tabs extends \N3Block\Blocks\AbstractBlock {

	protected static $blockName = 'n3custompost/tabs';

    public function __construct() {

		parent::__construct( self::$blockName );

        register_block_type(
            'n3custompost/tabs',
            array(
                'render_callback' => [ $this, 'render_callback' ]
            )
        );

		if ( $this->isEnabled() ) {

			add_filter( 'n3custompost/editor_blocks_js/dependencies', [ $this, 'block_editor_scripts'] );
		}
    }

	public function getLabel() {
		return __('Tabs', 'n3custompost');
	}

    public function block_editor_scripts($scripts) {

        //jquery-ui-tabs.min.js
		if ( ! in_array( 'jquery-ui-tabs', $scripts ) ) {
            array_push( $scripts, 'jquery-ui-tabs' );
        }

        return $scripts;
    }

    public function block_frontend_assets() {

        if ( is_admin() ) {
            return;
        }

		//jquery-ui-tabs.min.js
        if ( ! wp_script_is( 'jquery-ui-tabs', 'enqueued' ) ) {
            wp_enqueue_script('jquery-ui-tabs');
        }

		if ( FALSE == n3custompost()->assetsOptimization()->load_assets_on_demand() ) {
			return;
		}

		$rtl = is_rtl() ? '.rtl' : '';

		wp_enqueue_style(
			self::$blockName,
			n3custompost_get_plugin_url( 'assets/blocks/tabs/style' . $rtl . '.css' ),
			[],
			n3custompost()->settings()->getVersion()
		);

		wp_enqueue_script(
            self::$blockName,
            n3custompost_get_plugin_url( 'assets/blocks/tabs/frontend.js' ),
            [ 'jquery', 'jquery-ui-tabs' ],
            n3custompost()->settings()->getVersion(),
            true
        );

    }

    public function render_callback( $attributes, $content ) {

        $this->block_frontend_assets();

        return $content;
    }
}

n3custompost()->blocksManager()->addBlock(
	new \N3Block\Blocks\Tabs()
);
