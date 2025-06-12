<?php

namespace N3Block\Blocks;

class ContentTimeline extends \N3Block\Blocks\AbstractBlock {

	protected static $blockName = 'n3custompost/content-timeline';

	public function __construct() {

		parent::__construct( self::$blockName );

		register_block_type(
			'n3custompost/content-timeline',
			 array(
                'render_callback' => [ $this, 'render_callback' ]
            )
		);

	}

	public function getLabel() {
		return __('Content Timeline', 'n3custompost');
	}

    public function block_frontend_assets() {

		if ( is_admin() ) {
			return;
		}

		if ( FALSE == n3custompost()->assetsOptimization()->load_assets_on_demand() ) {
			return;
		}

		add_filter( 'n3custompost/optimize/assets',
			function ( $assets ) {
				$assets[] = n3custompost()->settings()->getPrefix() . '-blocks-common';

				return $assets;
			}
		);

		add_filter( 'n3custompost/optimize/should_load_common_css', '__return_true' );

		$rtl = is_rtl() ? '.rtl' : '';

		wp_enqueue_style(
			self::$blockName,
			n3custompost_get_plugin_url( 'assets/blocks/content-timeline/style' . $rtl . '.css' ),
			[],
			n3custompost()->settings()->getVersion()
		);

		wp_enqueue_script(
            self::$blockName,
            n3custompost_get_plugin_url( 'assets/blocks/content-timeline/frontend.js' ),
            [ 'jquery' ],
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
	new \N3Block\Blocks\ContentTimeline()
);
