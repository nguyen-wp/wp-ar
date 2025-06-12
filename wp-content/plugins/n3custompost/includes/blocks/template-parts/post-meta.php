<?php

namespace N3Block\Blocks;

class PostMeta extends \N3Block\Blocks\AbstractBlock {

	protected static $blockName = 'n3custompost/template-post-meta';
	protected static $assetsHandle = 'n3custompost/template-parts';

    public function __construct() {

		parent::__construct( self::$blockName );

        register_block_type(
            self::$blockName,
            array(
                'attributes' => array(
                    'blockDivider' => array(
                        'type' => 'string'
                    ),

                    //Colors
                    'textColor' => array(
                        'type' => 'string'
                    ),
                    'customTextColor' => array(
                        'type' => 'string'
                    ),

                    //Colors
                    'direction' => array(
                        'type' => 'string',
                        'default' => 'row'
                    ),
                    'textAlignment' => array(
                        'type' => 'string'
                    ),

                    'className' => array(
                        'type' => 'string'
                    )
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

        $block_name = 'wp-block-n3custompost-template-post-meta';
        $wrapper_class = $block_name;

        $wrapper_style = '';
        //Classes
        if ( isset( $attributes[ 'className' ] ) ) {
            $wrapper_class .= ' '.esc_attr( $attributes[ 'className' ] );
        }

        if ( isset( $attributes[ 'direction' ] ) ) {
            $wrapper_class .= ' has-direction-' . esc_attr( $attributes[ 'direction' ] );
        }
        if ( isset( $attributes[ 'textAlignment' ] ) ) {
            if ( $attributes[ 'direction' ] == 'row' ) {
                $wrapper_class .= ' has-alignment-' . esc_attr( $attributes[ 'textAlignment' ] );
            } else {
                $wrapper_style .= 'text-align: ' . esc_attr( $attributes[ 'textAlignment' ] ) . ';';
            }
        }

        $is_back_end = n3custompost_is_block_editor();

        n3custompost_custom_color_style_and_class( $wrapper_style, $wrapper_class, $attributes, 'color', $is_back_end );

        $result = '';

        $extra_attr = array(
            'wrapper_class' => $wrapper_class,
            'wrapper_style' => $wrapper_style,
            'content' => $content
        );

        if ( strlen( $content ) ) {
            ob_start();

            n3custompost_get_template_part( 'template-parts/post-meta', $attributes, false, $extra_attr );

            $result = ob_get_clean();
        }

		$this->block_frontend_assets();

        return $result;
    }
}

new \N3Block\Blocks\PostMeta();
