<?php

namespace N3Block\Blocks;

class Accordion extends \N3Block\Blocks\AbstractBlock {

	protected static $blockName = 'n3custompost/accordion';

    public function __construct() {

		parent::__construct( self::$blockName );

		register_block_type(
			'n3custompost/accordion',
			array(
				'render_callback' => [ $this, 'render_callback' ]
			)
		);

		if ( $this->isEnabled() ) {

			add_filter( 'n3custompost/editor_blocks_js/dependencies', [ $this, 'block_editor_scripts'] );
			add_filter( 'n3custompost/blocks_style_css/dependencies', [ $this, 'block_frontend_styles' ] );
		}
    }

	public function getLabel() {
		return __('Accordion', 'n3custompost');
	}

    public function block_editor_scripts($scripts) {

		//jquery-ui-accordion.min.js
        if ( ! in_array( 'jquery-ui-accordion', $scripts ) ) {
            array_push( $scripts, 'jquery-ui-accordion' );
        }

        return $scripts;
    }

	public function block_frontend_styles($styles) {

		//fontawesome
		$styles = n3custompost()->fontIconsManager()->enqueueFonts( $styles );

        return $styles;
    }

    public function block_frontend_assets() {

        if ( is_admin() ) {
            return;
        }

		//jquery-ui-accordion.min.js
        if ( ! wp_script_is( 'jquery-ui-accordion', 'enqueued' ) ) {
            wp_enqueue_script('jquery-ui-accordion');
        }

		if ( FALSE == n3custompost()->assetsOptimization()->load_assets_on_demand() ) {
			return;
		}

		//fontawesome
		$deps = n3custompost()->fontIconsManager()->enqueueFonts( [] );

		$rtl = is_rtl() ? '.rtl' : '';

		wp_enqueue_style(
			self::$blockName,
			n3custompost_get_plugin_url( 'assets/blocks/accordion/style' . $rtl . '.css' ),
			$deps,
			n3custompost()->settings()->getVersion()
		);

		wp_enqueue_script(
            self::$blockName,
            n3custompost_get_plugin_url( 'assets/blocks/accordion/frontend.js' ),
            [ 'jquery', 'jquery-ui-accordion' ],
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
	new \N3Block\Blocks\Accordion()
);
