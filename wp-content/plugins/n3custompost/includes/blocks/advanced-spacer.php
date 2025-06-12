<?php

namespace N3Block\Blocks;

class AdvancedSpacer extends \N3Block\Blocks\AbstractBlock {

	protected static $blockName = 'n3custompost/advanced-spacer';

	public function __construct() {

		parent::__construct( self::$blockName );

		register_block_type(
			'n3custompost/advanced-spacer',
			array(
				'render_callback' => [ $this, 'render_callback' ]
			)
		);

	}

	public function getLabel() {
		return __('Advanced Spacer', 'n3custompost');
	}

    public function block_frontend_assets( $attributes = null ) {

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
    }

    public function render_callback( $attributes, $content ) {

        $this->block_frontend_assets( $attributes );

        return $content;
    }

}

n3custompost()->blocksManager()->addBlock(
	new \N3Block\Blocks\AdvancedSpacer()
);
