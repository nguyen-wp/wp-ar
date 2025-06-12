<?php

namespace N3Block\Blocks;

class Anchor extends \N3Block\Blocks\AbstractBlock {

	protected static $blockName = 'n3custompost/anchor';

	public function __construct() {

		parent::__construct( self::$blockName );

		register_block_type(
			'n3custompost/anchor'
		);

	}

	public function getLabel() {
		return __('Anchor', 'n3custompost');
	}
}

n3custompost()->blocksManager()->addBlock(
	new \N3Block\Blocks\Anchor()
);
