<?php

namespace N3Block\Blocks;

class Counter extends \N3Block\Blocks\AbstractBlock {

	protected static $blockName = 'n3custompost/counter';

    public function __construct() {

        parent::__construct( self::$blockName );

        register_block_type(
            'n3custompost/counter',
            array(
                'render_callback' => [ $this, 'render_callback' ]
            )
		);

		if ( $this->isEnabled() ) {

			add_filter( 'n3custompost/editor_blocks_js/dependencies', [ $this, 'block_editor_scripts'] );

			//Register JS/CSS assets
			wp_register_script(
				'countup',
				n3custompost_get_plugin_url( 'vendors/countup.js/dist/countUp.min.js' ),
				[],
				'2.0.4',
				true
			);

			wp_register_script(
				'waypoints',
				n3custompost_get_plugin_url( 'vendors/waypoints/lib/jquery.waypoints.min.js' ),
				[ 'jquery' ],
				'4.0.1',
				true
			);
		}
    }

	public function getLabel() {
		return __('Counter', 'n3custompost');
	}

    public function block_editor_scripts( $scripts ) {

		//countUp.min.js
		if ( ! in_array( 'countup', $scripts ) ) {
            array_push( $scripts, 'countup' );
        }

        return $scripts;
    }

    public function block_frontend_assets() {

		if ( is_admin() ) {
			return;
		}

		//jquery.waypoints.min.js
		if ( ! wp_script_is( 'waypoints', 'enqueued' ) ) {
			wp_enqueue_script('waypoints');
		}

		//countUp.min.js
		if ( ! wp_script_is( 'countup', 'enqueued' ) ) {
			wp_enqueue_script('countup');
		}

		if ( FALSE == n3custompost()->assetsOptimization()->load_assets_on_demand() ) {
			return;
		}

		$rtl = is_rtl() ? '.rtl' : '';

		wp_enqueue_style(
			self::$blockName,
			n3custompost_get_plugin_url( 'assets/blocks/counter/style' . $rtl . '.css' ),
			[],
			n3custompost()->settings()->getVersion()
		);

		wp_enqueue_script(
            self::$blockName,
            n3custompost_get_plugin_url( 'assets/blocks/counter/frontend.js' ),
            [ 'jquery', 'waypoints', 'countup' ],
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
	new \N3Block\Blocks\Counter()
);
