<?php

namespace N3Block\Blocks;

class PostFeaturedBackgroundImage extends \N3Block\Blocks\AbstractBlock {

	protected static $blockName = 'n3custompost/template-post-featured-background-image';
	protected static $assetsHandle = 'n3custompost/template-parts';

    public function __construct() {

		parent::__construct( self::$blockName );

        register_block_type(
            self::$blockName,
            array(
                'attributes' => array(
                    'imageSize' => array(
                        'type' => 'string',
                        'default' => 'large'
                    ),
					'linkTo' => array(
						'type' => 'string',
						'default' => 'none'
					),

                    //Content
                    'minHeight' => array(
                        'type' => 'string'
                    ),
                    'contentMaxWidth' => array(
                        'type' => 'number'
                    ),

                    // Padding
                    'paddingTopValue' => array(
                        'type' => 'string'
                    ),
                    'paddingBottomValue' => array(
                        'type' => 'string'
                    ),
                    'paddingLeftValue' => array(
                        'type' => 'string'
                    ),
                    'paddingRightValue' => array(
                        'type' => 'string'
                    ),
                    'paddingTop' => array(
                        'type' => 'string',
                        'default' => ''
                    ),
                    'paddingBottom' => array(
                        'type' => 'string',
                        'default' => ''
                    ),
                    'paddingLeft' => array(
                        'type' => 'string',
                        'default' => ''
                    ),
                    'paddingRight' => array(
                        'type' => 'string',
                        'default' => ''
                    ),
                    'paddingTopTablet' => array(
                        'type' => 'string',
                        'default' => ''
                    ),
                    'paddingBottomTablet' => array(
                        'type' => 'string',
                        'default' => ''
                    ),
                    'paddingLeftTablet' => array(
                        'type' => 'string',
                        'default' => ''
                    ),
                    'paddingRightTablet' => array(
                        'type' => 'string',
                        'default' => ''
                    ),
                    'paddingTopMobile' => array(
                        'type' => 'string',
                        'default' => ''
                    ),
                    'paddingBottomMobile' => array(
                        'type' => 'string',
                        'default' => ''
                    ),
                    'paddingLeftMobile' => array(
                        'type' => 'string',
                        'default' => ''
                    ),
                    'paddingRightMobile' => array(
                        'type' => 'string',
                        'default' => ''
                    ),

                    //Alignment
                    'verticalAlign' => array(
                        'type' => 'string',
                        'default' => 'center'
                    ),
                    'verticalAlignTablet' => array(
                        'type' => 'string',
                        'default' => ''
                    ),
                    'verticalAlignMobile' => array(
                        'type' => 'string',
                        'default' => ''
                    ),
                    'horizontalAlign' => array(
                        'type' => 'string',
                        'default' => 'center'
                    ),
                    'horizontalAlignTablet' => array(
                        'type' => 'string',
                        'default' => ''
                    ),
                    'horizontalAlignMobile' => array(
                        'type' => 'string',
                        'default' => ''
                    ),

                    //foreground
                    'foregroundOpacity' => array(
                        'type' => 'number',
                        'default' => 35
                    ),
                    'foregroundColor' => array(
                        'type' => 'string'
                    ),
                    'foregroundFilter' => array(
                        'type' => 'string'
                    ),
                    'foregroundGradientType' => array(
                        'type' => 'string'
                    ),
                    'foregroundGradientFirstColor' => array(
                        'type' => 'string'
                    ),
                    'foregroundGradientFirstColorLocation' => array(
                        'type' => 'number',
                        'default' => 0
                    ),
                    'foregroundGradientSecondColor' => array(
                        'type' => 'string'
                    ),
                    'foregroundGradientSecondColorLocation' => array(
                        'type' => 'number',
                        'default' => 100
                    ),
                    'foregroundGradientAngle' => array(
                        'type' => 'number',
                        'default' => 180
                    ),
                    'className' => array(
                        'type' => 'string'
                    ),
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
				$assets[] = n3custompost()->settings()->getPrefix() . '-blocks-common';

				return $assets;
			}
		);

		add_filter( 'n3custompost/optimize/should_load_common_css', '__return_true' );

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

        $block_name = 'wp-block-n3custompost-template-post-featured-background-image';
        $wrapper_class = $block_name;

        if ( isset( $attributes[ 'className' ] ) ) {
            $wrapper_class .= ' ' . esc_attr( $attributes[ 'className' ] );
        }

		if ( isset( $attributes[ 'linkTo' ] ) && $attributes[ 'linkTo' ] != 'none' ) {
			$wrapper_class .= ' has-link has-link-to-' . $attributes[ 'linkTo' ];
		}

        $wrapper_style = '';
        //Classes
        if ( isset( $attributes[ 'minHeight' ] ) ) {
            $wrapper_style .= 'min-height: ' . esc_attr( $attributes[ 'minHeight' ] ) . ';';
        }

        $imageSize = ( ( isset( $attributes[ 'imageSize' ] ) && $attributes[ 'imageSize' ] ) ? $attributes[ 'imageSize' ] : 'post-thumbnail' );

        $current_post = get_post( get_the_ID() );

        //Content Slide style
        $content_container_style = '';

        if ( isset( $attributes[ 'contentMaxWidth' ] ) ) {
            $content_container_style .= 'max-width: '.esc_attr( $attributes[ 'contentMaxWidth' ] ) . 'px;';
        }

        //Padding
        $content_container_class = $block_name.'__content';

        n3custompost_custom_paddings_style_and_class( $wrapper_style, $wrapper_class, $attributes );

        n3custompost_custom_alignment_classes( $wrapper_class, $attributes );


        //Foreground style
        $foreground_style = '';
        $foreground_class = $block_name.'__foreground';

        if ( isset( $attributes[ 'foregroundGradientType' ] ) ) {
            n3custompost_custom_gradient_styles( 'foreground', $foreground_style, $attributes );
        }

        if ( isset( $attributes[ 'foregroundOpacity' ] ) && $attributes[ 'foregroundOpacity' ] != 35 ) {
            $foreground_class .= ' n3custompost-opacity-' . esc_attr( $attributes[ 'foregroundOpacity' ] );
        }

        if ( isset( $attributes[ 'foregroundColor' ] ) ) {
            $foreground_style .= 'background-color: ' . esc_attr( $attributes[ 'foregroundColor' ] ) . ';';
        }

        if ( isset( $attributes[ 'foregroundFilter' ] ) ) {
            $foreground_style .= 'mix-blend-mode: ' . esc_attr( $attributes[ 'foregroundFilter' ] ) . ';';
        }

        $result = '';

        $extra_attr = array(
            'block_name'    => $block_name,
            'wrapper_class' => $wrapper_class,
            'wrapper_style' => $wrapper_style,
            'current_post'  => $current_post,
            'imageSize'     => $imageSize,

            'content_container_style' => $content_container_style,
            'content_container_class' => $content_container_class,

            'foreground_style' => $foreground_style,
            'foreground_class' => $foreground_class,
            'content'          => $content
        );

        if ( ( has_post_thumbnail() ) || strlen( $content ) ) {
            ob_start();

            n3custompost_get_template_part( 'template-parts/post-featured-background-image', $attributes, false, $extra_attr );

            $result = ob_get_clean();
        }

		$this->block_frontend_assets();

        return $result;
    }
}

new \N3Block\Blocks\PostFeaturedBackgroundImage();
