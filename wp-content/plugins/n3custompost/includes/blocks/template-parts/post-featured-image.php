<?php

namespace N3Block\Blocks;

class PostFeaturedImage extends \N3Block\Blocks\AbstractBlock {

	protected static $blockName = 'n3custompost/template-post-featured-image';
	protected static $assetsHandle = 'n3custompost/template-parts';

    public function __construct() {

		parent::__construct( self::$blockName );

        register_block_type(
            self::$blockName,
            array(
                'attributes' => array(
                    'linkTo' => array(
                        'type' => 'string',
                        'default' => 'none'
                    ),
                    'align' => array(
                        'type' => 'string'
                    ),
                    'imageSize' => array(
                        'type' => 'string',
                        'default' => 'large'
                    ),

                    'className' => array(
                        'type' => 'string'
                    ),
                ),
                'render_callback' => [ $this, 'render_callback' ]
            )
        );
    }

    public function block_frontend_assets() {

        if ( is_admin() ) {
            return;
        }

		if ( FALSE == n3custompost()->assetsOptimization()->load_assets_on_demand() ) {
			return;
		}

		add_filter( 'n3custompost/optimize/assets',
			function ( $assets ) {
				$assets[] = self::$assetsHandle;

				return $assets;
			}
		);

		$rtl = is_rtl() ? '.rtl' : '';

		wp_enqueue_style(
			self::$assetsHandle,
			n3custompost_get_plugin_url( 'assets/blocks/template-parts/style' . $rtl . '.css' ),
			[],
			n3custompost()->settings()->getVersion()
		);
    }

    public function render_callback( $attributes, $content ) {

        //Not BackEnd render if we view from template page
        if ( ( get_post_type() == n3custompost()->postTemplatePart()->postType ) || ( get_post_type() == 'revision' ) ) {
            return $content;
        }

        $block_name = 'wp-block-n3custompost-template-post-featured-image';
        $wrapper_class = $block_name;

        if ( isset( $attributes[ 'className' ] ) ) {
            $wrapper_class .= ' ' . esc_attr( $attributes[ 'className' ] );
        }

        $wrapper_style = '';
        //Classes
        if ( isset( $attributes[ 'align' ] ) ) {
            $wrapper_class .= ' align' . esc_attr( $attributes[ 'align' ] );
        }

        $imageSize = ( ( isset( $attributes[ 'imageSize' ] ) && $attributes[ 'imageSize' ] ) ? $attributes[ 'imageSize' ] : 'post-thumbnail' );

        $result = '';

        $extra_attr = array(
            'wrapper_class' => $wrapper_class,
            'wrapper_style' => $wrapper_style,
            'imageSize' => $imageSize
        );

        if ( has_post_thumbnail() ) {
            ob_start();

            n3custompost_get_template_part( 'template-parts/post-featured-image', $attributes, false, $extra_attr );

            $result = ob_get_clean();
        }

		$this->block_frontend_assets();

        return $result;
    }
}

new \N3Block\Blocks\PostFeaturedImage();
