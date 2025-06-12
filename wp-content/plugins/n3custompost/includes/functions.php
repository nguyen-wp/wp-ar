<?php

/**
 * Gets plugin's absolute directory path.
 *
 * @param string $path Relative path
 *
 * @return string
 */
function n3custompost_get_plugin_path( $path = '' ) {
	return N3BLOCK_PLUGIN_DIR . trim( $path, '/' );
}


/**
 * Gets plugin's URL.
 *
 * @param string $path
 *
 * @return string
 */
function n3custompost_get_plugin_url( $path = '' ) {
	return plugins_url( $path, N3BLOCK_PLUGIN_FILE );
}


/**
* Get template part.
*
* @param string $slug
* @param string $name Optional. Default ''.
*/
function n3custompost_get_template_part( $slug, $attributes = array(), $extract = false, $extra_attr = array() ){

    $template = n3custompost_locate_template( $slug );

    // Allow 3rd party plugins to filter template file from their plugin.
    $template = apply_filters( 'n3custompost/core/get_template_part', $template, $slug, $attributes );

    if ( !empty( $template ) ) {
	    if ( $attributes && is_array( $attributes ) && $extract ) {
	        extract( $attributes, EXTR_SKIP );
	    }

	    require $template;
    }

	return $template;
}

/**
* Retrieve the name of the highest priority template file that exists.
*
* @param string $slug
* @param string $name Optional. Default ''.
*/
function n3custompost_locate_template( $slug ){

    $template = '';

    // Look in %theme_dir%/%template_path%/slug.php
    $template = locate_template( "n3custompost/{$slug}.php" );

    // Get default template from plugin
    if ( empty( $template ) && file_exists( n3custompost_get_plugin_path( "/includes/templates/{$slug}.php" ) ) ) {
        $template = n3custompost_get_plugin_path( "/includes/templates/{$slug}.php" );
    }

	return $template;
}

/*
 * Add the option if it doesn't exist
 *
 * @param string $option_name
 * @param mixed $option_value
 * @param bool $autoload
 *
 * @return bool True if the option was added, false otherwise.
 */
function n3custompost_maybe_add_option( $option_name, $option_value, $autoload ) {

	$result = false;

	if ( get_option( $option_name ) === false ) {

		/*
		 * If the option doesn't already exist in DB it was added to `notoptions` array on `get_option` call.
		 * If so, we can check this and call `add_option` to create an option with `autoload` property.
		 */
		$notoptions = wp_cache_get( 'notoptions', 'options' );
		if ( is_array( $notoptions ) && isset( $notoptions[ $option_name ] ) ) {
			$result = add_option( $option_name, $option_value, '', $autoload );
		}
	}

	return $result;
}


/**
 * Generate section content width css
 *
 * @return string
 */
function n3custompost_generate_section_content_width_css(){

	global $content_width;

    // Existent empty option value "" = non-existent option value
	$sectionContentWidth = get_option( 'n3custompost_section_content_width', '' );

	n3custompost_maybe_add_option( 'n3custompost_section_content_width', '', true );

    // We need to know exactly when the value "does not exist" and when to set the global value
    $sectionContentWidth = is_numeric($sectionContentWidth) ? floatval( $sectionContentWidth ) : $content_width;

    $section_css = '';
	if ( $sectionContentWidth ) {
		$section_css .= '.wp-block-n3custompost-section .wp-block-n3custompost-section__wrapper .wp-block-n3custompost-section__inner-wrapper{max-width: '
		. $sectionContentWidth . 'px;}';
	}

	return $section_css;
}

/**
 * Generate smooth animations css
 *
 * @return string
 */
function n3custompost_generate_smooth_animation_css(){

	$smoothAnimationsEnabled = get_option( 'n3custompost_smooth_animation', false );

	n3custompost_maybe_add_option( 'n3custompost_smooth_animation', false, true );

	$animation_css = '';
	if ( $smoothAnimationsEnabled ) {
		$animation_css .= 'body{overflow-x:hidden;}';
		$animation_css .= '.n3custompost-anim{visibility:hidden;}';
	}

	return $animation_css;
}

/**
 * Generate text color/background color style & class
 *
 * @return string
 */
function n3custompost_custom_color_style_and_class(&$style, &$class, $attributes, $process = 'color', $is_back_end = false, $custom_color = false){

    if ($custom_color == false){
        if ($process == 'color'){
            //Color
            $Color = isset($attributes['textColor']) ? $attributes['textColor'] : null;
            $customColor = isset($attributes['customTextColor']) ? $attributes['customTextColor'] : null;
        } elseif ($process == 'background'){
            //Background
            $Color = isset($attributes['backgroundColor']) ? $attributes['backgroundColor'] : null;
            $customColor = isset($attributes['customBackgroundColor']) ? $attributes['customBackgroundColor'] : null;
        }
    } elseif (is_array($custom_color)){
        $Color = isset($custom_color['color']) && isset($attributes[$custom_color['color']]) ? $attributes[$custom_color['color']] : null;
        $customColor = isset($custom_color['custom']) && isset($attributes[$custom_color['custom']]) ? $attributes[$custom_color['custom']] : null;
    }

    if (isset( $Color) || isset( $customColor )){
        if (isset( $Color)){
            preg_match('/^#/', $Color, $matches);
            //HEX
            $ColorHEX = '';
            if (isset($matches[0])){
                $ColorHEX = $Color;
            }
            //String
            else {
				$editorColorPalette = get_theme_support('editor-color-palette');
				if ( $editorColorPalette && isset($editorColorPalette[0]) ) {
					$get_colors = $editorColorPalette[0];
					if ( !empty($get_colors) ) {
						foreach ($get_colors as $key => $value) {
							if ($value['slug'] == $Color){
								$ColorHEX =  $value['color'];
							}
						}
					}
				}
            }
        }

        $class .= ($process == 'color') ? ' has-text-color' : ' has-background';

        if ($is_back_end){
            $style .= (($process == 'color') ? 'color:' : 'background-color:').(isset( $customColor ) ? $customColor : $ColorHEX).';';
        } else {
            if (isset($customColor)){
                $style .= (($process == 'color') ? 'color:' : 'background-color:'). esc_attr($customColor) .';';
            } else {
                $class .= ' has-'. esc_attr($Color) .(($process == 'color') ? '-color' : '-background-color');
            }
        }
    }

    $style = trim($style);
    $class = trim($class);
}

/**
 * Generate custom paddings style & class
 *
 * @return string
 */
function n3custompost_custom_paddings_style_and_class(&$style, &$class, $attributes){

    $class .= (isset($attributes['paddingTop']) && $attributes['paddingTop'] !='' && $attributes['paddingTop'] != 'custom') ? " n3custompost-padding-top-".esc_attr($attributes['paddingTop']) : '';
    $class .= (isset($attributes['paddingBottom']) && $attributes['paddingBottom'] !='' && $attributes['paddingBottom'] != 'custom') ? " n3custompost-padding-bottom-".esc_attr($attributes['paddingBottom']) : '';
    $class .= (isset($attributes['paddingLeft']) && $attributes['paddingLeft'] !='' && $attributes['paddingLeft'] != 'custom') ? " n3custompost-padding-left-".esc_attr($attributes['paddingLeft']) : '';
    $class .= (isset($attributes['paddingRight']) && $attributes['paddingRight'] !='' && $attributes['paddingRight'] != 'custom') ? " n3custompost-padding-right-".esc_attr($attributes['paddingRight']) : '';

    $class .= (isset($attributes['paddingTopTablet']) && $attributes['paddingTopTablet'] !='') ? " n3custompost-padding-tablet-top-".esc_attr($attributes['paddingTopTablet']) : '';
    $class .= (isset($attributes['paddingBottomTablet']) && $attributes['paddingBottomTablet'] !='') ? " n3custompost-padding-tablet-bottom-".esc_attr($attributes['paddingBottomTablet']) : '';
    $class .= (isset($attributes['paddingLeftTablet']) && $attributes['paddingLeftTablet'] !='') ? " n3custompost-padding-tablet-left-".esc_attr($attributes['paddingLeftTablet']) : '';
    $class .= (isset($attributes['paddingRightTablet']) && $attributes['paddingRightTablet'] !='') ? " n3custompost-padding-tablet-right-".esc_attr($attributes['paddingRightTablet']) : '';

    $class .= (isset($attributes['paddingTopMobile']) && $attributes['paddingTopMobile'] !='') ? " n3custompost-padding-mobile-top-".esc_attr($attributes['paddingTopMobile']) : '';
    $class .= (isset($attributes['paddingBottomMobile']) && $attributes['paddingBottomMobile'] !='') ? " n3custompost-padding-mobile-bottom-".esc_attr($attributes['paddingBottomMobile']) : '';
    $class .= (isset($attributes['paddingLeftMobile']) && $attributes['paddingLeftMobile'] !='') ? " n3custompost-padding-mobile-left-".esc_attr($attributes['paddingLeftMobile']) : '';
    $class .= (isset($attributes['paddingRightMobile']) && $attributes['paddingRightMobile'] !='') ? " n3custompost-padding-mobile-right-".esc_attr($attributes['paddingRightMobile']) : '';

    $style .= (isset($attributes['paddingTop']) && $attributes['paddingTop'] !='' && $attributes['paddingTop'] == 'custom') ? "padding-top:".esc_attr($attributes['paddingTopValue']).";" : '';
    $style .= (isset($attributes['paddingBottom']) && $attributes['paddingBottom'] !='' && $attributes['paddingBottom'] == 'custom') ? "padding-bottom:".esc_attr($attributes['paddingBottomValue']).";" : '';
    $style .= (isset($attributes['paddingLeft']) && $attributes['paddingLeft'] !='' && $attributes['paddingLeft'] == 'custom') ? "padding-left:".esc_attr($attributes['paddingLeftValue']).";" : '';
    $style .= (isset($attributes['paddingRight']) && $attributes['paddingRight'] !='' && $attributes['paddingRight'] == 'custom') ? "padding-right:".esc_attr($attributes['paddingRightValue']).";" : '';
}

/**
 * Generate custom alignment classes
 *
 * @return string
 */
function n3custompost_custom_alignment_classes(&$class, $attributes){
    $class .= (isset($attributes['verticalAlign']) && $attributes['verticalAlign'] !='center') ? " n3custompost-align-items-".esc_attr($attributes['verticalAlign']) : '';
    $class .= (isset($attributes['verticalAlignTablet']) && $attributes['verticalAlignTablet'] !='') ? " n3custompost-align-items-tablet".esc_attr($attributes['verticalAlignTablet']) : '';
    $class .= (isset($attributes['verticalAlignMobile']) && $attributes['verticalAlignMobile'] !='') ? " n3custompost-align-items-mobile-".esc_attr($attributes['verticalAlignMobile']) : '';

    $class .= (isset($attributes['horizontalAlign']) && $attributes['horizontalAlign'] !='center') ? " n3custompost-justify-content-".esc_attr($attributes['horizontalAlign']) : '';
    $class .= (isset($attributes['horizontalAlignTablet']) && $attributes['horizontalAlignTablet'] !='') ? " n3custompost-justify-content-tablet-".esc_attr($attributes['horizontalAlignTablet']) : '';
    $class .= (isset($attributes['horizontalAlignMobile']) && $attributes['horizontalAlignMobile'] !='') ? " n3custompost-justify-content-mobile-".esc_attr($attributes['horizontalAlignMobile']) : '';
}

/**
 * Generate custom gradient styles
 *
 * @return string
 */
function n3custompost_custom_gradient_styles($prefix, &$style, $attributes){
    $type = isset($attributes[$prefix.'GradientType']) ? esc_attr($attributes[$prefix.'GradientType']) : 'linear';
    $angle = isset($attributes[$prefix.'GradientAngle']) ? esc_attr($attributes[$prefix.'GradientAngle']).'deg' : '180deg';
    $firstColor = isset($attributes[$prefix.'GradientFirstColor']) ? esc_attr($attributes[$prefix.'GradientFirstColor']) : 'rgba(0,0,0,0)';
    $secondColor = isset($attributes[$prefix.'GradientSecondColor']) ? esc_attr($attributes[$prefix.'GradientSecondColor']) : 'rgba(0,0,0,0)';
    $firstLocation = isset($attributes[$prefix.'GradientFirstColorLocation']) ? esc_attr($attributes[$prefix.'GradientFirstColorLocation']).'%' : '0%';
    $secondLocation = isset($attributes[$prefix.'GradientSecondColorLocation']) ? esc_attr($attributes[$prefix.'GradientSecondColorLocation']).'%' : '100%';

    if ($type == 'linear'){
        $style .= 'background-image: linear-gradient('.esc_attr($angle).', '.esc_attr($firstColor).' '.esc_attr($firstLocation).', '.esc_attr($secondColor).' '.esc_attr($secondLocation).');';
    } elseif ($type == 'radial'){
        $style .= 'background-image: radial-gradient('.esc_attr($firstColor).' '.esc_attr($firstLocation).', '.esc_attr($secondColor).' '.esc_attr($secondLocation).');';
    }
}

/**
 * Build WP Query
 *
 * @return array
 */
function n3custompost_build_custom_post_type_query( $attributes ) {

	$query_args = array();

    if ( (isset($attributes['filterById']) && $attributes['filterById'] != '') ||
         (isset($attributes['parentPageId']) && $attributes['parentPageId'] != '' ) ||
          isset($attributes['postType']) ) {

        $query_args = array(
            'posts_per_page'   => $attributes['postsToShow'],
            'ignore_sticky_posts' => 0,
            'post_status'      => 'publish',
			'post__in'         => get_option( 'sticky_posts' ),
            'order'            => $attributes['order'],
			'orderby'          => $attributes['orderBy'],
		);

        if (isset($attributes['ignoreSticky']) && $attributes['ignoreSticky'] == true){
			$query_args['ignore_sticky_posts'] = 1;
			$query_args['post__in'] = array();
		} 

        $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
        if ( isset($attributes['pagination']) && $attributes['pagination'] ){
            $query_args['paged'] = $paged;
		}

		if ($attributes['offset'] != 0){
			$offset = ( $paged - 1 ) * $attributes['postsToShow'] + $attributes['offset'];
			$query_args['offset'] = $offset;
		}
    }

	 //Exclude by IDs && Current Post ID
	if ( (isset($attributes['excludeById']) && $attributes['excludeById'] != '') || $attributes['excludeCurrentPost'] ) {

		$ids_arr = [];
		if ((isset($attributes['excludeById']) && $attributes['excludeById'] != '')){
			$ids_arr = array_map( 'intval', explode(',', $attributes['excludeById']) );
		}

		if ($attributes['excludeCurrentPost']){
			$ids_arr[] = get_the_ID();
		}

        $query_args['post__not_in'] = $ids_arr;
    }

    //Filter by IDs
    if ( isset($attributes['filterById']) && $attributes['filterById'] != '' ) {

        $ids_arr = array_map( 'intval', explode(',', $attributes['filterById']) );
        $query_args['post__in'] = $ids_arr;

    } else if ( (isset($attributes['parentPageId']) && $attributes['parentPageId'] !='') || $attributes['childPagesCurrentPage'] ) {

        $query_args['post_type'] = 'page';
        if ($attributes['postType'] == 'page'){
			$query_args['post_parent'] = $attributes['childPagesCurrentPage'] ? get_the_ID() : intval($attributes['parentPageId']);
        }

    }

    //Set postType
    if ( isset( $attributes['postType'] )) {

        $query_args['post_type'] = $attributes['postType'];

        if ( isset($attributes['taxonomy']) && isset($attributes['terms']) ){

            $query_args['tax_query'] = array(
                'relation' => $attributes['relation'],
            );

            $taxonomy_arr = [];
            //Get terms from taxonomy (Make arr)
            foreach ($attributes['terms'] as $key => $value) {
                preg_match('/(^.*)\[(\d*)\]/', $value, $find_arr);

                if (isset($find_arr[1]) && isset($find_arr[2])){
                    $taxonomy = $find_arr[1];
                    $term = $find_arr[2];

                    $taxonomy_arr[$taxonomy][] = $term;
                }
			}

            //Add array to query
            if (!empty($taxonomy_arr)){
                foreach ($taxonomy_arr as $taxonomy_name => $terms_arr) {

					foreach ($terms_arr as $term_index => $term_id) {

						$query_args['tax_query'][] = array(
							'taxonomy' => $taxonomy_name,
							'field' => 'term_id',
							'terms' => $term_id
						);
					}
				}
			}
		}
	}

	if ( ! empty( $attributes[ 'metaQuery' ] ) ) {

		$query_args[ 'meta_query' ] = n3custompost_build_meta_query( $attributes[ 'metaQuery' ] );
	}

	return $query_args;
}

/**
 * @param array $metaQuery
 * @return array
 *
 * https://developer.wordpress.org/reference/classes/wp_meta_query/
 */
function n3custompost_build_meta_query( $meta_query ) {

	for ( $i = 0; $i < count( $meta_query ); $i++ ) {

		$query = $meta_query[$i];

		if ( is_array( $query ) && array_key_exists( 'children', $query ) && count( $query[ 'children' ] ) ) {

			$children = &$query[ 'children' ];

			for ( $j = 0; $j < count( $children ); $j++ ) {

				$object = &$children[$j];

				// Remove empty `type`
				if ( array_key_exists( 'type', $object ) && empty ( $object['type'] ) ) {
					unset ( $object['type'] );
				}

				if ( array_key_exists( 'compare', $object ) ) {

					// Remove empty `compare`
					if ( empty ( $object['compare'] ) ) {

						unset ( $object['compare'] );

						/*
						 * Default `compare` is `=`, so normalize `value`
						 */
						if ( array_key_exists( 'value', $object ) ) {
							if ( is_array( $object['value'] ) && ! empty( $object['value'] ) ) {
								$object['value'] = array_shift( $object['value'] );
							}
						}

					} else {

						// Normalize `value`
						switch ( $object['compare'] ) {

							case 'IN':
							case 'NOT IN':
							case 'BETWEEN':
							case 'NOT BETWEEN':
								/*
								 * It can be an array only when compare is 'IN', 'NOT IN', 'BETWEEN', or 'NOT BETWEEN'
								 */
								break;

							case 'EXISTS':
							case 'NOTEXISTS':

								/*
								 * You don't have to specify a value when using the 'EXISTS' or 'NOT EXISTS' comparisons in WordPress 3.9 and up.
								 */
								unset( $object['value'], $object['type'] );
								break;

							default :

								if ( is_array( $object['value'] ) && ! empty( $object['value'] ) ) {
									$object['value'] = array_shift( $object['value'] );
								}
								break;
						}
					}
				}

				// Remove empty `value`
				if ( array_key_exists( 'value', $object ) ) {
					if ( is_array( $object['value'] ) && empty( implode( '', $object['value'] ) ) ) {
						unset ( $object['value'] );
					}
				}
			}

			// Recursion
			$query = array_merge( $query, n3custompost_build_meta_query( $query[ 'children' ] ) );

			unset( $query[ 'children' ] );
			$children = null;

			$meta_query[$i] = $query;
		}
	}

	return  $meta_query;
}

/**
 * Determine whether a post or content string has N3Block "nested" blocks.
 * @since 1.5.3
 */
function has_n3custompost_nested_blocks() {
	return n3custompost()->blocksManager()->hasN3BlockNestedBlocks();
}

/*
 * Check if the ACF plugin active.
 */
function n3custompost_acf_is_active() {
	$acf = class_exists( 'ACF' );
	return $acf;
}

/**
 * Determines whether the block editor is loaded.
 * @since 1.7.6
 */
function n3custompost_is_block_editor() {

	return \defined( 'REST_REQUEST' )
		&& REST_REQUEST
		&& ! empty( $_REQUEST[ 'context' ] )
		&& 'edit' === sanitize_text_field( wp_unslash( $_REQUEST[ 'context' ] ) );
}

/**
 * Recursive sanitation for an array
 *
 * @since 1.7.7
 *
 * @param $array
 *
 * @return mixed
 */
function n3custompost_recursive_sanitize_array( $array ) {

	foreach ( $array as $key => &$value ) {
		if ( is_array( $value ) ) {
			$value = n3custompost_recursive_sanitize_array( $value );
		}
		else {
			$value = sanitize_text_field( $value );
		}
	}

	return $array;
}
