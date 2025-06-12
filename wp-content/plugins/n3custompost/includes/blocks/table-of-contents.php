<?php

namespace N3Block\Blocks;

class TableOfContents extends \N3Block\Blocks\AbstractBlock {

	protected static $blockName = 'n3custompost/table-of-contents';

	public function __construct() {

		parent::__construct( self::$blockName );

		register_block_type(
			'n3custompost/table-of-contents',
			array(
				'render_callback' => [ $this, 'render_callback' ]
			)
		);

		/**
		 * Rank Math ToC Plugins List.
		 */
		add_filter( 'rank_math/researches/toc_plugins', function( $toc_plugins ) {
			$toc_plugins['n3custompost/n3custompost.php'] = 'N3Block';
			return $toc_plugins;
		});

	}

	public function getLabel() {
		return __('Table of Contents', 'n3custompost');
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
			n3custompost_get_plugin_url( 'assets/blocks/table-of-contents/style' . $rtl . '.css' ),
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
	new \N3Block\Blocks\TableOfContents()
);
