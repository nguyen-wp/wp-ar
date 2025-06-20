<?php

namespace N3Block\Blocks;

class Section extends \N3Block\Blocks\AbstractBlock {

	protected static $blockName = 'n3custompost/section';
	private $assetsAlreadyEnqueued = false;

    public function __construct() {

		parent::__construct( self::$blockName );

        register_block_type(
            'n3custompost/section',
            array(
                'render_callback' => [ $this, 'render_callback' ]
            )
        );

		if ( $this->isEnabled() ) {

			add_filter( 'n3custompost/editor_blocks_js/dependencies', [ $this, 'block_editor_scripts'] );
			add_filter( 'n3custompost/blocks_style_css/dependencies', [ $this, 'block_frontend_styles' ] );

			//Register JS/CSS assets
			wp_register_script(
				'wow',
				n3custompost_get_plugin_url( 'vendors/wow.js/dist/wow.min.js' ),
				[ 'jquery' ],
				'1.2.1',
				true
			);

			wp_register_script(
				'slick',
				n3custompost_get_plugin_url( 'vendors/slick/slick/slick.min.js' ),
				[ 'jquery' ],
				'1.9.0',
				true
			);

			wp_register_script(
				'draggabilly',
				n3custompost_get_plugin_url( 'vendors/draggabilly/draggabilly.pkgd.min.js' ),
				[ 'jquery' ],
				'2.2.0',
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
		return __('Section', 'n3custompost');
	}

    public function block_frontend_styles($styles) {

		//fontawesome
		$styles = n3custompost()->fontIconsManager()->enqueueFonts( $styles );

        //animate.min.css
		if ( is_admin() && ! in_array( 'animate', $styles ) ) {
            array_push( $styles, 'animate' );
        }

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

        //wow.min.js
		if ( ! in_array( 'wow', $scripts ) ) {
            array_push( $scripts, 'wow' );
        }

        //wow.min.js
		if ( ! in_array( 'slick', $scripts ) ) {
            array_push( $scripts, 'slick' );
        }

		//draggabilly.pkgd.min.js
        if ( ! in_array( 'draggabilly', $scripts ) ) {
            array_push( $scripts, 'draggabilly' );
		}

        return $scripts;
    }

    public function block_frontend_assets( $attributes = [], $content = '' ) {

        if ( is_admin() ) {
            return;
        }

		if ( ! empty( $attributes['entranceAnimation'] ) ) {
			//wow.min.js
			if ( ! wp_script_is( 'wow', 'enqueued' ) ){
				wp_enqueue_script('wow');
			}

            //animate.min.css
			if ( ! wp_style_is( 'animate', 'enqueued' ) ) {
				wp_enqueue_style( 'animate' );
			}
        }

		//todo:
		$has_background_slider = false !== strpos( $content, 'wp-block-n3custompost-section__background-slider-item' );
        //slick.min.js
		if ( $has_background_slider && ! wp_script_is( 'slick', 'enqueued' ) ) {
            wp_enqueue_script('slick');
		}

		//imagesloaded.min.js
		if ( $has_background_slider && ! wp_script_is( 'imagesloaded', 'enqueued' ) ) {
			wp_enqueue_script('imagesloaded');
		}

		/* optimization */
		if ( FALSE == n3custompost()->assetsOptimization()->load_assets_on_demand() ) {
			return;
		}

		$deps_css = [
			'slick', 'slick-theme'
		];

		$deps_js = [ 'jquery', 'imagesloaded' ];

		if ( $has_background_slider && ! wp_script_is( 'slick', 'enqueued' ) ) {
            $deps_js[] = 'slick';
		}

		if ( ! empty( $attributes['entranceAnimation'] ) ) {
			$deps_css[] = 'animate';
			$deps_js[] = 'wow';
		}

		//fontawesome
		$deps_css = n3custompost()->fontIconsManager()->enqueueFonts( $deps_css );

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
			n3custompost_get_plugin_url( 'assets/blocks/section/style' . $rtl . '.css' ),
			$deps_css,
			n3custompost()->settings()->getVersion()
		);

		// ensure that inline styles are enqueued only once
		if ( !$this->assetsAlreadyEnqueued ) {
			wp_add_inline_style( self::$blockName, n3custompost_generate_section_content_width_css() . n3custompost_generate_smooth_animation_css() );
		}

		wp_enqueue_script(
            self::$blockName,
            n3custompost_get_plugin_url( 'assets/blocks/section/frontend.js' ),
            $deps_js,
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

		$this->block_frontend_assets( $attributes, $content );

        return $content;
    }
}

n3custompost()->blocksManager()->addBlock(
	new \N3Block\Blocks\Section()
);
