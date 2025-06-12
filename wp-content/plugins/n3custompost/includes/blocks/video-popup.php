<?php

namespace N3Block\Blocks;

class VideoPopup extends \N3Block\Blocks\AbstractBlock {

	protected static $blockName = 'n3custompost/video-popup';

    public function __construct() {

		parent::__construct( self::$blockName );

        register_block_type(
            'n3custompost/video-popup',
            array(
                'render_callback' => [ $this, 'render_callback' ]
            )
        );

		if ( $this->isEnabled() ) {

			add_filter( 'n3custompost/blocks_style_css/dependencies', [ $this, 'block_frontend_styles' ] );

			//Register JS/CSS assets
			wp_register_script(
				'fancybox',
				n3custompost_get_plugin_url( 'vendors/fancybox/jquery.fancybox.min.js' ),
				[ 'jquery' ],
				'3.5.7',
				true
			);

			wp_register_style(
				'fancybox',
				n3custompost_get_plugin_url( 'vendors/fancybox/jquery.fancybox.min.css' ),
				[],
				'3.5.7'
			);
		}
    }

	public function getLabel() {
		return __('Video Popup', 'n3custompost');
	}

    public function block_frontend_styles($styles) {

		//fontawesome
		$styles = n3custompost()->fontIconsManager()->enqueueFonts( $styles );

        //jquery.fancybox.min.css
		if ( ! is_admin() && ! in_array( 'fancybox', $styles ) ) {
            array_push( $styles, 'fancybox' );
        }

        return $styles;
    }

    public function block_frontend_assets() {

        if ( is_admin() ) {
            return;
        }

        //jquery.fancybox.min.js
		if ( ! wp_script_is( 'fancybox', 'enqueued' ) ) {
            wp_enqueue_script('fancybox');
        }

		if ( FALSE == n3custompost()->assetsOptimization()->load_assets_on_demand() ) {
			return;
		}

		$deps = [
			'fancybox'
		];

		add_filter( 'n3custompost/optimize/assets',
			function ( $assets ) {
				$assets[] = 'fancybox';
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
			n3custompost_get_plugin_url( 'assets/blocks/video-popup/style' . $rtl . '.css' ),
			$deps,
			n3custompost()->settings()->getVersion()
		);

		wp_enqueue_script(
            self::$blockName,
            n3custompost_get_plugin_url( 'assets/blocks/video-popup/frontend.js' ),
            [ 'jquery', 'fancybox' ],
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
	new \N3Block\Blocks\VideoPopup()
);
