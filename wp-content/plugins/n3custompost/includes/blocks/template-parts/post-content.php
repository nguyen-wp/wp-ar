<?php

namespace N3Block\Blocks;

class PostContent extends \N3Block\Blocks\AbstractBlock {

	protected static $blockName = 'n3custompost/template-post-content';
	protected static $assetsHandle = 'n3custompost/template-parts';

    public function __construct() {

		parent::__construct( self::$blockName );

        register_block_type(
            self::$blockName,
            array(
                'attributes' => array(
                    //Colors
                    'textColor' => array(
                        'type' => 'string'
                    ),
                    'customTextColor' => array(
                        'type' => 'string'
                    ),

                    //Colors
                    'fontSize' => array(
                        'type' => 'string'
                    ),
                    'customFontSize' => array(
                        'type' => 'string'
                    ),
                    'textAlignment' => array(
                        'type' => 'string'
                    ),
                    'showContent' => array(
                        'type' => 'string',
                        'default' => 'excerpt'
                    ),
                    'contentLength' => array(
                        'type' => 'number',
                        'default' => apply_filters( 'excerpt_length', 55 )
                    ),
                    'className' => array(
                        'type' => 'string'
                    )
                ),
                'render_callback' => [ $this, 'render_callback' ],
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

        $block_name = 'wp-block-n3custompost-template-post-content';
        $wrapper_class = $block_name;

        if ( isset( $attributes[ 'className' ] ) ) {
            $wrapper_class .= ' '.esc_attr( $attributes[ 'className' ] );
        }

        if ( isset( $attributes[ 'showContent' ] ) ) {
            $wrapper_class .= ' is-'.esc_attr( $attributes[ 'showContent' ] );
        }

        $wrapper_style = '';
        //Classes
        if ( isset( $attributes[ 'textAlignment' ] ) ) {
            $wrapper_style .= 'text-align: ' . esc_attr( $attributes[ 'textAlignment' ] ) . ';';
        }

        if ( isset( $attributes[ 'customFontSize' ] ) ) {
			$font_size = is_numeric( $attributes['customFontSize'] ) ? $attributes['customFontSize'] . 'px' : $attributes['customFontSize'];
            $wrapper_style .= 'font-size: '.esc_attr( $font_size ) . ';';
        }

        if ( isset( $attributes[ 'fontSize' ] ) ) {
            $wrapper_class .= ' has-' . esc_attr( $attributes[ 'fontSize' ] ) . '-font-size';
        }

        $contentLength = isset( $attributes['contentLength'] ) ? $attributes[ 'contentLength' ] : false;

        $current_post = get_post( get_the_ID() );

        $is_back_end = n3custompost_is_block_editor();

        //Link style & class
        n3custompost_custom_color_style_and_class( $wrapper_style, $wrapper_class, $attributes, 'color', $is_back_end );

        $extra_attr = array(
            'wrapper_class' => $wrapper_class,
            'wrapper_style' => $wrapper_style,
            'contentLength' => $contentLength,
            'current_post' => $current_post
        );

        ob_start();

        n3custompost_get_template_part( 'template-parts/post-content', $attributes, false, $extra_attr );

        $result = ob_get_clean();

		$this->block_frontend_assets();

        return $result;
    }
}

new \N3Block\Blocks\PostContent();
