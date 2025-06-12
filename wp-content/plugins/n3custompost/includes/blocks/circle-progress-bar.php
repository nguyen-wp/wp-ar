<?php

namespace N3Block\Blocks;

class CircleProgressBar extends \N3Block\Blocks\AbstractBlock {

	protected static $blockName = 'n3custompost/circle-progress-bar';

    public function __construct() {

        parent::__construct( self::$blockName );

		register_block_type(
            'n3custompost/circle-progress-bar',
            array(
                'render_callback' => [ $this, 'render_callback' ]
            )
        );

        //Register JS/CSS assets
        wp_register_script(
            'waypoints',
            n3custompost_get_plugin_url( 'vendors/waypoints/lib/jquery.waypoints.min.js' ),
            [ 'jquery' ],
            '4.0.1',
            true
        );
    }

	public function getLabel() {
		return __('Circular Progress Bar', 'n3custompost');
	}

    public function block_frontend_assets( $attributes = null ) {

        if ( is_admin() ) {
            return;
        }

        //jquery.waypoints.min.js
		if ( ! wp_script_is( 'waypoints', 'enqueued' ) ) {
            wp_enqueue_script('waypoints');
        }

		if ( FALSE == n3custompost()->assetsOptimization()->load_assets_on_demand() ) {
			return;
		}

		$rtl = is_rtl() ? '.rtl' : '';

		wp_enqueue_style(
			self::$blockName,
			n3custompost_get_plugin_url( 'assets/blocks/circle-progress-bar/style' . $rtl . '.css' ),
			[],
			n3custompost()->settings()->getVersion()
		);

		wp_enqueue_script(
            self::$blockName,
            n3custompost_get_plugin_url( 'assets/blocks/circle-progress-bar/frontend.js' ),
            [ 'jquery', 'waypoints' ],
            n3custompost()->settings()->getVersion(),
            true
        );
    }

    public function render_callback( $attributes, $content ) {

        $this->block_frontend_assets( $attributes );

        return $content;
    }
}

n3custompost()->blocksManager()->addBlock(
	new \N3Block\Blocks\CircleProgressBar()
);
