<?php

namespace N3Block\Blocks;

class Banner extends \N3Block\Blocks\AbstractBlock {

	protected static $blockName = 'n3custompost/banner';

    public function __construct() {

		parent::__construct( self::$blockName );

        register_block_type(
            'n3custompost/banner',
			array(
				'render_callback' => [ $this, 'render_callback' ]
			)
        );
    }

	public function getLabel() {
		return __('Banner', 'n3custompost');
	}

    public function block_frontend_assets( $attributes = null ) {

        if ( is_admin() ) {
            return;
        }

		if ( FALSE == n3custompost()->assetsOptimization()->load_assets_on_demand() ) {
			return;
		}

		$rtl = is_rtl() ? '.rtl' : '';

		wp_enqueue_style(
			self::$blockName,
			n3custompost_get_plugin_url( 'assets/blocks/banner/style' . $rtl . '.css' ),
			[],
			n3custompost()->settings()->getVersion()
		);
    }

    public function render_callback( $attributes, $content ) {

        $this->block_frontend_assets( $attributes );

        return $content;
    }

}

n3custompost()->blocksManager()->addBlock(
	new \N3Block\Blocks\Banner()
);
