<?php

namespace N3Block\Blocks;

class PostCategories extends \N3Block\Blocks\AbstractBlock {

	protected static $blockName = 'n3custompost/template-post-categories';
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
                    'backgroundColor' => array(
                        'type' => 'string'
                    ),
                    'customBackgroundColor' => array(
                        'type' => 'string'
                    ),

                    //Colors
                    'icon' => array(
                        'type' => 'string',
                        'default' => 'fas fa-folder-open'
                    ),
                    'iconColor' => array(
                        'type' => 'string'
                    ),
                    'customIconColor' => array(
                        'type' => 'string'
                    ),
                    'fontSize' => array(
                        'type' => 'string'
                    ),
                    'customFontSize' => array(
                        'type' => 'string'
                    ),
                    'divider' => array(
                        'type' => 'string',
                        'default' => ','
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

        $block_name = 'wp-block-n3custompost-template-post-categories';
        $wrapper_class = $block_name;

        if ( isset( $attributes[ 'className' ] ) ) {
            $wrapper_class .= ' '.esc_attr( $attributes[ 'className' ] );
        }

        if ( isset( $attributes[ 'divider' ] ) && $attributes[ 'divider' ] != '' ) {
            $wrapper_class .= ' has-divider';
        }

        $wrapper_style = '';
        //Classes
        if ( isset( $attributes[ 'textAlignment' ] ) ) {
            $wrapper_style .= 'text-align: ' . esc_attr( $attributes[ 'textAlignment' ] ) . ';';
        }

        if ( isset( $attributes[ 'customFontSize' ] ) ) {
			$font_size = is_numeric( $attributes['customFontSize'] ) ? $attributes['customFontSize'] . 'px' : $attributes['customFontSize'];
            $wrapper_style .= 'font-size: ' . esc_attr( $font_size ) . ';';
        }

        if ( isset( $attributes[ 'fontSize' ] ) ) {
            $wrapper_class .= ' has-' . esc_attr( $attributes[ 'fontSize' ] ) . '-font-size';
        }

        $divider = isset( $attributes[ 'divider' ] ) && $attributes[ 'divider' ] != '' ? $attributes[ 'divider' ] : '';

        $is_back_end = n3custompost_is_block_editor();

        n3custompost_custom_color_style_and_class( $wrapper_style, $wrapper_class, $attributes, 'color', $is_back_end );

        $categories_list = get_the_category_list( $divider . ' ' );
        
        $getPost_ID = get_the_ID();
        $getposttype = get_post_type( $getPost_ID );
        if($getposttype == 'n3_projects'){
            $terms = get_the_terms( $getPost_ID, 'n3_project_categories' );
        } else if($getposttype == 'n3_services'){
            $terms = get_the_terms( $getPost_ID, 'n3_service_categories' );
        } else if($getposttype == 'n3_teams'){
            $terms = get_the_terms( $getPost_ID, 'n3_team_categories' );
        } else if($getposttype == 'gp_sports'){
            $terms = get_the_terms( $getPost_ID, 'gp_sport_categories' );
        } else if($getposttype == 'gp_surfaces'){
            $terms = get_the_terms( $getPost_ID, 'gp_surface_categories' );
        } else if($getposttype == 'gp_cases'){
            $terms = get_the_terms( $getPost_ID, 'gp_case_categories' );
        } else if($getposttype == 'n3_careers'){
            $terms = get_the_terms( $getPost_ID, 'n3_career_categories' );
        } else {
            $terms = get_the_terms( $getPost_ID, 'category' );
        }
        // $terms = get_the_terms( $getPost_ID, 'n3_project_categories' );

        if ( $terms && ! is_wp_error( $terms ) )  {
            $categories = array();
            foreach ( $terms as $term ) {
                $categories[] = $term->name;
            }
            $categories_list = join( ' // ', $categories );
        }

        $icon_class = '';
        $icon_style = '';
        n3custompost_custom_color_style_and_class( $icon_style, $icon_class, $attributes, 'color', $is_back_end, [ 'color' => 'iconColor', 'custom' => 'customIconColor' ] );

        $result = '';

        $extra_attr = array(
            'wrapper_class'   => $wrapper_class,
            'wrapper_style'   => $wrapper_style,
            'categories_list' => $categories_list,

            'icon_class' => $icon_class,
            'icon_style' => $icon_style
        );

        if ( $categories_list ) {
            ob_start();

            n3custompost_get_template_part( 'template-parts/post-categories', $attributes, false, $extra_attr );

            $result = ob_get_clean();
        }

		$this->block_frontend_assets();

        return $result;
    }
}

new \N3Block\Blocks\PostCategories();
