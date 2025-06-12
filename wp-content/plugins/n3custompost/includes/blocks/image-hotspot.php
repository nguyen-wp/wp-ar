<?php

namespace N3Block\Blocks;

class ImageHotspot extends \N3Block\Blocks\AbstractBlock {

	protected static $blockName = 'n3custompost/image-hotspot';

    public function __construct() {

		parent::__construct( self::$blockName );

        register_block_type(
            'n3custompost/image-hotspot',
            array(
                'render_callback' => [ $this, 'render_callback' ]
            )
		);

		if ( $this->isEnabled() ) {

			add_filter( 'n3custompost/editor_blocks_js/dependencies', [ $this, 'block_editor_scripts'] );
			add_filter( 'n3custompost/blocks_style_css/dependencies', [ $this, 'block_frontend_styles' ] );

			//Register JS/CSS assets
			wp_register_script(
				'draggabilly',
				n3custompost_get_plugin_url( 'vendors/draggabilly/draggabilly.pkgd.min.js' ),
				[ 'jquery' ],
				'2.2.0',
				true
			);

			wp_register_script(
				'popper',
				n3custompost_get_plugin_url( 'vendors/tippy.js/popper.min.js' ),
				[ 'jquery' ],
				'2.4.0',
				true
			);

			wp_register_script(
				'tippy',
				n3custompost_get_plugin_url( 'vendors/tippy.js/tippy-bundle.umd.min.js' ),
				[ 'jquery', 'popper' ],
				'6.2.3',
				true
			);

			wp_register_script(
				'waypoints',
				n3custompost_get_plugin_url( 'vendors/waypoints/lib/jquery.waypoints.min.js' ),
				[ 'jquery' ],
				'4.0.1',
				true
			);

			wp_register_script(
				'unescape',
				n3custompost_get_plugin_url( 'vendors/lodash.unescape/unescape.min.js' ),
				[],
				'4.0.1',
				true
			);

			wp_register_style(
				'tippy-themes',
				n3custompost_get_plugin_url( 'vendors/tippy.js/themes.css' ),
				[],
				'6.2.3'
			);

			wp_register_style(
				'tippy-animation',
				n3custompost_get_plugin_url( 'vendors/tippy.js/animations.css' ),
				[],
				'6.2.3'
			);
		}
    }

	public function getLabel() {
		return __('Image Hotspot', 'n3custompost');
	}

    public function block_frontend_styles($styles) {

		//fontawesome
		$styles = n3custompost()->fontIconsManager()->enqueueFonts( $styles );

		//themes.css
        if ( is_admin() && ! in_array( 'tippy-themes', $styles ) ) {
            array_push( $styles, 'tippy-themes' );
		}

		//animation.css
		if ( is_admin() && ! in_array( 'tippy-animation', $styles ) ) {
			array_push( $styles, 'tippy-animation' );
		}

        return $styles;
    }

    public function block_editor_scripts($scripts) {

        //imagesloaded.min.js
		if ( ! in_array( 'imagesloaded', $scripts ) ) {
            array_push( $scripts, 'imagesloaded' );
		}

		//draggabilly.pkgd.min.js
        if ( ! in_array( 'draggabilly', $scripts ) ) {
            array_push( $scripts, 'draggabilly' );
		}

		//popper.min.js
        if ( ! in_array( 'popper', $scripts ) ) {
            array_push( $scripts, 'popper' );
		}

		//tippy-bundle.umd.min.js
        if ( ! in_array( 'tippy', $scripts ) ) {
            array_push( $scripts, 'tippy' );
		}

        return $scripts;
    }

    public function block_frontend_assets() {

		if ( is_admin() ) {
			return;
		}

		//popper.min.js
		if ( ! wp_script_is( 'popper', 'enqueued' ) ) {
			wp_enqueue_script('popper');
		}

		//tippy-bundle.umd.min.js
		if ( ! wp_script_is( 'tippy', 'enqueued' ) ) {
			wp_enqueue_script('tippy');
		}

		//jquery.waypoints.min.js
		if ( ! wp_script_is( 'waypoints', 'enqueued' ) ) {
			wp_enqueue_script('waypoints');
		}

		//unescape.min.js
		if ( ! wp_script_is( 'unescape', 'enqueued' ) ) {
			wp_enqueue_script( 'unescape' );
		}

		//themes.css
		if ( ! wp_style_is( 'tippy-themes', 'enqueued' ) ) {
			wp_enqueue_style( 'tippy-themes' );
		}

		//animation.css
		if ( ! wp_style_is( 'tippy-animation', 'enqueued' ) ) {
			wp_enqueue_style( 'tippy-animation' );
		}

		if ( FALSE == n3custompost()->assetsOptimization()->load_assets_on_demand() ) {
			return;
		}

		$deps_css = [
			'tippy-themes', 'tippy-animation'
		];

		$deps_js = [ 'jquery', 'popper', 'tippy', 'waypoints', 'unescape' ];

		//fontawesome
		$deps_css = n3custompost()->fontIconsManager()->enqueueFonts( $deps_css );

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
			n3custompost_get_plugin_url( 'assets/blocks/image-hotspot/style' . $rtl . '.css' ),
			$deps_css,
			n3custompost()->settings()->getVersion()
		);

		wp_enqueue_script(
            self::$blockName,
            n3custompost_get_plugin_url( 'assets/blocks/image-hotspot/frontend.js' ),
            $deps_js,
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
	new \N3Block\Blocks\ImageHotspot()
);
