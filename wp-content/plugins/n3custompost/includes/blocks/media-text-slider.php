<?php

namespace N3Block\Blocks;

class MediaTextSlider extends \N3Block\Blocks\AbstractBlock {

	protected static $blockName = 'n3custompost/media-text-slider';
	private $assetsAlreadyEnqueued = false;

    public function __construct() {

		parent::__construct( self::$blockName );

        register_block_type(
            'n3custompost/media-text-slider',
            array(
                'render_callback' => [ $this, 'render_callback' ]
            )
        );

		if ( $this->isEnabled() ) {

			add_filter( 'n3custompost/editor_blocks_js/dependencies', [ $this, 'block_editor_scripts'] );
			add_filter( 'n3custompost/blocks_style_css/dependencies', [ $this, 'block_frontend_styles' ] );

			//Register JS/CSS assets
			wp_register_script(
				'slick',
				n3custompost_get_plugin_url( 'vendors/slick/slick/slick.min.js' ),
				[ 'jquery' ],
				'1.9.0',
				true
			);

			wp_register_style(
				'animate',
				n3custompost_get_plugin_url( 'vendors/animate.css/animate.min.css' ),
				[],
				'3.7.0'
			);

			wp_register_style(
				'slick',
				n3custompost_get_plugin_url( 'vendors/slick/slick/slick.min.css' ),
				[],
				'1.9.0'
			);

			wp_register_style(
				'slick-theme',
				n3custompost_get_plugin_url( 'vendors/slick/slick/slick-theme.min.css' ),
				[],
				'1.9.0'
			);
		}
    }

	public function getLabel() {
		return __('Media & Text Slider', 'n3custompost');
	}

    public function block_frontend_styles($styles) {

		//slick.min.css
        if ( ! in_array( 'slick', $styles ) ) {
            array_push( $styles, 'slick' );
        }

		//slick-theme.min.css
        if ( ! in_array( 'slick-theme', $styles ) ) {
            array_push( $styles, 'slick-theme' );
        }

        return $styles;
    }

    public function block_editor_scripts($scripts) {

		//slick.min.js
        if ( ! in_array( 'slick', $scripts ) ) {
            array_push( $scripts, 'slick' );
        }

        return $scripts;
    }

    public function block_frontend_assets() {

        if ( is_admin() ) {
            return;
        }

		//slick.min.js
        if ( ! wp_script_is( 'slick', 'enqueued' ) ) {
            wp_enqueue_script('slick');
        }

		//animate.min.css
		if ( ! wp_style_is( 'animate', 'enqueued' ) ) {
			wp_enqueue_style( 'animate' );
		}

		if ( FALSE == n3custompost()->assetsOptimization()->load_assets_on_demand() ) {
			return;
		}

		$deps = [
			'slick', 'slick-theme', 'animate'
		];

		add_filter( 'n3custompost/optimize/assets',
			function ( $assets ) {
				$assets[] = 'slick';
				$assets[] = 'slick-theme';
				$assets[] = n3custompost()->settings()->getPrefix() . '-blocks-common';

				return $assets;
			}
		);

		add_filter( 'n3custompost/optimize/should_load_common_css', '__return_true' );

		$rtl = is_rtl() ? '.rtl' : '';

		wp_enqueue_style(
			self::$blockName,
			n3custompost_get_plugin_url( 'assets/blocks/media-text-slider/style' . $rtl . '.css' ),
			$deps,
			n3custompost()->settings()->getVersion()
		);

		wp_enqueue_script(
            self::$blockName,
            n3custompost_get_plugin_url( 'assets/blocks/media-text-slider/frontend.js' ),
            [ 'jquery', 'slick' ],
            n3custompost()->settings()->getVersion(),
            true
        );

		if ( !$this->assetsAlreadyEnqueued ) {
			$inline_script =
				'var N3Block = N3Block || {};' .
				'N3Block["isRTL"] = ' . json_encode( is_rtl() ) . ';';

			wp_add_inline_script(
				self::$blockName,
				$inline_script,
				'before'
			);
		}

		$this->assetsAlreadyEnqueued = true;
    }

    public function render_callback( $attributes, $content ) {

        $this->block_frontend_assets();

        return $content;
    }
}

n3custompost()->blocksManager()->addBlock(
	new \N3Block\Blocks\MediaTextSlider()
);
