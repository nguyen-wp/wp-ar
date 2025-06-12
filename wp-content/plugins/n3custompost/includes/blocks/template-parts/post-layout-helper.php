<?php

namespace N3Block\Blocks;

class TemplatePostLayoutHelper extends \N3Block\Blocks\AbstractBlock {

	protected static $blockName = 'n3custompost/template-post-layout-helper';

	public function __construct() {

		parent::__construct( self::$blockName );

		register_block_type(
			self::$blockName
		);

	}

	public function isDisabled() {

		return apply_filters( 'n3custompost/blocks/is_disabled', false, self::$blockName );
	}

}

new \N3Block\Blocks\TemplatePostLayoutHelper();