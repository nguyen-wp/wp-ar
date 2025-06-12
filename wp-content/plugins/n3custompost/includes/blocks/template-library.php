<?php

namespace N3Block\Blocks;

class TemplateLibrary extends \N3Block\Blocks\AbstractBlock {

	protected static $blockName = 'n3custompost/template-library';

    public function __construct() {

        parent::__construct( self::$blockName );

		register_block_type(
			'n3custompost/template-library'
		);
	}

	public function getLabel() {
		return __('Template Library', 'n3custompost');
	}
}

n3custompost()->blocksManager()->addBlock(
	new \N3Block\Blocks\TemplateLibrary()
);
