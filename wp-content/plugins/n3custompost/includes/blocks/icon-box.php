<?php

namespace N3Block\Blocks;

class IconBox extends \N3Block\Blocks\AbstractBlock {

	protected static $blockName = 'n3custompost/icon-box';

    public function __construct() {

		parent::__construct( self::$blockName );

        register_block_type(
            'n3custompost/icon-box',
			array(
				'render_callback' => [ $this, 'render_callback' ]
			)
        );

		if ( $this->isEnabled() ) {

			add_filter( 'n3custompost/blocks_style_css/dependencies', [ $this, 'block_frontend_styles' ] );

			wp_register_style(
				'animate',
				n3custompost_get_plugin_url( 'vendors/animate.css/animate.min.css' ),
				[],
				'3.7.0'
			);
		}
    }

	public function getLabel() {
		return __('Icon Box', 'n3custompost');
	}

    public function block_frontend_styles($styles) {

		//fontawesome
		$styles = n3custompost()->fontIconsManager()->enqueueFonts( $styles );

		//animate.min.css
        if ( is_admin() && ! in_array( 'animate', $styles ) ) {
            array_push( $styles, 'animate' );
        }

        return $styles;
    }

	public function block_frontend_assets() {

		if ( is_admin() ) {
			return;
		}

		if ( ! wp_style_is( 'animate', 'enqueued' ) ) {
			wp_enqueue_style('animate');
		}

		if ( FALSE == n3custompost()->assetsOptimization()->load_assets_on_demand() ) {
			return;
		}

		$deps = [
			'animate'
		];

		add_filter( 'n3custompost/optimize/assets',
			function ( $assets ) {
				$assets[] = n3custompost()->settings()->getPrefix() . '-blocks-common';

				return $assets;
			}
		);

		add_filter( 'n3custompost/optimize/should_load_common_css', '__return_true' );

		//fontawesome
		$deps = n3custompost()->fontIconsManager()->enqueueFonts( $deps );

		$rtl = is_rtl() ? '.rtl' : '';

		wp_enqueue_style(
			self::$blockName,
			n3custompost_get_plugin_url( 'assets/blocks/icon-box/style' . $rtl . '.css' ),
			$deps,
			n3custompost()->settings()->getVersion()
		);

		wp_enqueue_script(
            self::$blockName,
            n3custompost_get_plugin_url( 'assets/blocks/icon-box/frontend.js' ),
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
	new \N3Block\Blocks\IconBox()
);
