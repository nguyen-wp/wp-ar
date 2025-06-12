<?php

namespace N3Block\Blocks;

class PriceBox extends \N3Block\Blocks\AbstractBlock {

	protected static $blockName = 'n3custompost/price-box';

	public function __construct() {

		parent::__construct( self::$blockName );

		register_block_type(
			'n3custompost/price-box',
			array(
				'render_callback' => [ $this, 'render_callback' ]
			)
		);

	}

	public function getLabel() {
		return __('Price Box', 'n3custompost');
	}

    public function block_frontend_assets() {

        if ( is_admin() ) {
            return;
        }

		if ( FALSE == n3custompost()->assetsOptimization()->load_assets_on_demand() ) {
			return;
		}

		$rtl = is_rtl() ? '.rtl' : '';

		wp_enqueue_style(
			self::$blockName,
			n3custompost_get_plugin_url( 'assets/blocks/price-box/style' . $rtl . '.css' ),
			[],
			n3custompost()->settings()->getVersion()
		);
    }

	public function render_callback( $attributes, $content ) {

        $this->block_frontend_assets();

        return $content;
    }

}

n3custompost()->blocksManager()->addBlock(
	new \N3Block\Blocks\PriceBox()
);
