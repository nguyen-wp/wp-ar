<?php 
if (!class_exists('GPC_Core_PROPRETIE')) {
    class GPC_Core_PROPRETIE {
        function __construct()  {
            add_action( 'init', array($this, '___n3_property_categories') );
            add_action( 'init', array($this, '___n3_properties') );
            
            add_action( 'manage_n3_properties_posts_custom_column',  array($this,'___n3_properties_columns'), 10, 2 );
            add_filter( 'manage_edit-n3_properties_columns',  array($this,'___n3_properties_edit_columns') ) ;
            add_action( 'admin_bar_menu', array( $this, '___addToAdminBar' ), 100 );
            // add_action('admin_init', array($this, 'allow_user_roles'));

            add_filter('pre_get_posts', array($this, '___n3_properties_pre_get_posts'));

            // Add Archive and Single Templates
            add_filter( 'archive_template', array($this, '___n3_properties_archive_template') ) ;
            add_filter( 'single_template', array($this, '___n3_properties_single_template') ) ;
            add_filter( 'after_setup_theme', array($this, '___n3_properties_ats') ) ;

            // updateSticky
            add_action( 'init', array($this, 'updateSticky') );
            add_action('admin_menu', array($this, '__addSubmenu'));

            // Shortcode 
            add_shortcode('n3_property_field', array($this, '_buildShortcode'));
            add_shortcode( 'n3_property_map', array($this, 'shortcode') );

            // ACF 
            add_action('acf/init', array($this, 'register_acf_block'));

        }

        public function register_acf_block() {
            if( function_exists('acf_register_block_type') ) {
                $arr = array(
                    array(
                        'key' => 'availabilities',
                        'title' => 'Property Availabilities',
                    ),
                    array(
                        'key' => 'property_status',
                        'title' => 'Property Status',
                    ),
                    array(
                        'key' => 'brokers',
                        'title' => 'Property Brokers',
                    ),
                    array(
                        'key' => 'brochure',
                        'title' => 'Property File',
                    ),
                    array(
                        'key' => 'gallery',
                        'title' => 'Property Gallery',
                    ),
                    array(
                        'key' => 'map',
                        'title' => 'Property Map',
                    ),
                    // GROUP: general
                    array(
                        'key' => 'property_type',
                        'title' => 'Property Type',
                    ),
                    array(
                        'key' => 'offering_type',
                        'title' => 'Property Offering Type',
                    ),
                    array(
                        'key' => 'year_built',
                        'title' => 'Property Year Built',
                    ),
                    array(
                        'key' => 'surface',
                        'title' => 'Property Surface',
                    ),
                    array(
                        'key' => 'surface_unit',
                        'title' => 'Property Surface Unit',
                    ),
                    array(
                        'key' => 'units_count',
                        'title' => 'Property Units Count',
                    ),
                    array(
                        'key' => 'price',
                        'title' => 'Property Price',
                    ),
                    array(
                        'key' => 'price_postfix',
                        'title' => 'Property Price Postfix',
                    ),
                    array(
                        'key' => 'active_date',
                        'title' => 'Property Active Date',
                    ),
                    // GROUP: location_information
                    array(
                        'key' => 'address',
                        'title' => 'Property Address',
                    ),
                    array(
                        'key' => 'latitude',
                        'title' => 'Property Latitude',
                    ),
                    array(
                        'key' => 'longitude',
                        'title' => 'Property Longitude',
                    ),
                    array(
                        'key' => 'city',
                        'title' => 'Property City',
                    ),
                    array(
                        'key' => 'state',
                        'title' => 'Property State',
                    ),
                    array(
                        'key' => 'County',
                        'title' => 'Property County',
                    ),
                    array(
                        'key' => 'neighborhood',
                        'title' => 'Property Neighborhood',
                    ),
                    array(
                        'key' => 'zip_code',
                        'title' => 'Property Zip Code',
                    ),
                );
                foreach ($arr as $key => $value) {
                    // https://developer.wordpress.org/block-editor/reference-guides/block-api/block-supports/
                    acf_register_block_type(array(
                        'name'              => 'property_' . $value['key'],
                        'title'             => $value['title'],
                        'key'               => $value['key'],
                        'description'       => __('A custom block to display the field (ACF field) inside the Query Loop block.'),
                        'render_callback'   => array($this, '__acf_function'),
                        'category'          => 'formatting',
                        'icon'              => 'feedback',
                        'keywords'          => array( 'property', 'acf', $value['key'] ),
                        'mode'				  => 'preview',
                        'supports'          => array( 
                            // 'align'  => false,
                            'anchor' => true,
                            'mode' => false,
                            'jsx' => true,
                            'ariaLabel' => true,
                            'align' => true,
                            'color' => array(
                                'gradient' => true,
                                'text' => true,
                                'background' => true,
                            ),
                            'dimensions' => true,
                            // 'spacing' => array(
                            //     'padding' => true,
                            //     'margin' => true,
                            //     'blockGap' => true,
                            // ),
                            'typography' => array(
                                'fontSize'=> true,
                                'lineHeight'=> true,
                                'textAlign'=> true,
                                'fontFamily'=> true,
                                'fontWeight'=> true,
                                'textTransform'=> true,
                                'letterSpacing'=> true,
                            )
                        ),
                    ));
                }
                
            }
        }

        public function __acf_function( $block, $content = '', $is_preview = false, $post_id = 0, $wp_block = false, $context = false ) {
            $id = 'n3_' . $block['id'];
            if( !empty($block['anchor']) ) {
                $id = $block['anchor'];
            }
            $className = '';
            if( !empty($block['className']) ) {
                $className .= ' ' . $block['className'];
            }
            if( !empty($block['align']) ) {
                $className .= ' align' . $block['align'];
            }
            if( !empty($block['textColor']) ) {
                $className .= ' has-' . $block['textColor'] . '-color';
            }
            if( !empty($block['fontSize']) ) {
                $className .= ' has-' . $block['fontSize'] . '-font-size';
            }
            if( !empty($block['backgroundColor']) ) {
                $className .= ' has-' . $block['backgroundColor'] . '-background-color';
            }
            if( !empty($block['style']['typography']['lineHeight']) ) {
                $className .= ' has-line-height-' . $block['style']['typography']['lineHeight'];
            }
            $key = $block['key'];
            $fileds = get_field($key, get_the_ID()) ?? null;
            $field_general = get_field('general', get_the_ID())[$key] ?? null;
            $field_location_information = get_field('location_information', get_the_ID()) ?? null;
            if ( $key == 'state' || $key == 'city' || $key == 'address' || $key == 'latitude' || $key == 'longitude' || $key == 'zip_code' || $key == 'neighborhood' || $key == 'county' ) {
                if ( $key == 'state' ) {
                    $check_length = $this->displayArrayState($field_location_information[$key]);
                } else {
                    $check_length = $field_location_information[$key];
                }
            } else if ( $key == 'year_built' || $key == 'surface' || $key == 'surface_unit' || $key == 'units_count' || $key == 'price' || $key == 'price_postfix' || $key == 'active_date' ) {
                $check_length = strlen($field_general) > 0 ? $field_general : (is_admin() ? 'N/A' : '');
            } else if ( $key == 'map' ) {
                if ( !empty($field_location_information['longitude']) ) {
                    $check_length = do_shortcode('[n3_property_map address="'.$field_location_information['address'].'" latitude="'.$field_location_information['latitude'].'" longitude="'.$field_location_information['longitude'].'"]');
                } else {
                    $check_length = is_admin() ? 'N/A' : '';
                }
            } else if ( $key == 'property_type' || $key == 'offering_type' ) {
                if ( !empty($field_general) ) {
                    $check_length = $this->displayTag($field_general);
                } else {
                    $check_length = is_admin() ? 'N/A' : '';
                }
            } else if ( $key == 'brochure' ) {
                if ( isset($fileds['filename']) ) {
                    $check_length = '<div class="wp-block-buttons is-layout-flex wp-block-buttons-is-layout-flex"> <div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="'.$fileds['url'].'" target="_blank">'.$fileds['title'].'</a></div> </div>';
                } else {
                    $check_length = 'N/A';
                }
            } else if ( $key == 'property_status' ) {
                if ( !empty($fileds) ) {
                    if ( $fileds == 'pending' ) {
                        $check_length = '<span class="bg-yellow-400 text-white px-2 py-1 rounded">Pending</span>';
                    } else if ( $fileds == 'escrow' ) {
                        $check_length = '<span class="bg-purple-400 text-white px-2 py-1 rounded">Escrow</span>';
                    } else if ( $fileds == 'sold' ) {
                        $check_length = '<span class="bg-green-400 text-white px-2 py-1 rounded">Sold</span>';
                    } else if ( $fileds == 'active' ) {
                        $check_length = '<span class="bg-blue-400 text-white px-2 py-1 rounded">Active</span>';
                    } else {
                        $check_length = '<span class="bg-gray-400 text-white px-2 py-1 rounded">Closed</span>';
                    }
                } else {
                    $check_length = is_admin() ? 'N/A' : '';
                }
            } else if ( $key == 'availabilities' ) {
                if ( !empty($fileds) ) {
                    $tmp = '';
                    foreach ($fileds as $key => $value) {
                        $tmp .= '<h3 class="wp-block-heading has-large-font-size mb-2"><strong>'.$value['name'].'</strong></h3>';
                        $tmp .= '<div class="wp-block-columns wp-block-columns-3 is-style-stacked-on-mobile has-medium-font-size"> <div class="wp-block-column"> <div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-6 wp-block-group-is-layout-flex"><strong class="has-accent-4-color has-small-font-size">Lease Type:</strong> '.$this->formatText($value['lease_type']).'</div></div><div class="wp-block-column"><div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-6 wp-block-group-is-layout-flex"><strong class="has-accent-4-color has-small-font-size">Price:</strong> '.$value['price'].' '.$value['price_postfix'].'</div> </div> <div class="wp-block-column"> <div class="wp-block-group is-nowrap is-layout-flex wp-container-core-group-is-layout-6 wp-block-group-is-layout-flex"><strong class="has-accent-4-color has-small-font-size">Surface:</strong> '.$value['surface'].' '.$value['surface_unit'].'</div></div> </div>';
                    }
                    $check_length = $tmp;
                } else {
                    $check_length = is_admin() ? 'N/A' : '';
                }
            } else if ( $key == 'brokers' ) {
                if ( !empty($fileds) ) {
                    $tmp = '<div class="space-y-3">';
                    foreach ($fileds as $key => $value) {
                        $getPost_acf = get_fields($value->ID)['details'] ?? null;
                        $thumbnail_url_by_id = get_the_post_thumbnail_url($value->ID);
                        $tmp .= '<div class="flex flex-row items-center gap-4"><img width="64" height="64" src="'.$thumbnail_url_by_id.'" class="border border-gray-200"></figure><div class="wp-block-media-text__content"> <h3 class="wp-block-heading font-semibold has-medium-font-size">'.$value->post_title.'</h3><p class="has-accent-4-color has-small-font-size">'.$getPost_acf['title'].'</p></div></div>';
                    }
                    $tmp .= '</div>';
                    $check_length = $tmp;
                } else {
                    $check_length = is_admin() ? 'N/A' : '';
                }

            } else if ( $key == 'gallery' ) {
                if ( !empty($fileds) ) {
                    $tmp = '<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">';
                    foreach ($fileds as $key => $value) {
                        $tmp .= '<figure class="blocks-gallery-item"><a href="'.$value['url'].'" data-fancybox="gallery" data-caption="'.$value['alt'].'"><img src="'.$value['url'].'" class="border border-gray-300 object-cover w-full h-full" /></a></figure>';
                    }   
                    $tmp .= '</div>';
                    $check_length = $tmp;
                } else {
                    $check_length = 'N/A';
                }
            } else {
                $check_length = strlen($fileds) > 0 ? $fileds : (is_admin() ? 'N/A' : '');
            }
            ?>
            <div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
                <?php is_admin() ? $key. ':' : ''; ?>
                <?php echo $check_length; ?>
            </div>
            <style type="text/css">#<?php echo $id; ?> {
                <?php if( !empty($block['style']['typography']['lineHeight']) ) : ?>
                    line-height: <?php echo $block['style']['typography']['lineHeight']; ?>;
                <?php endif; ?>
                <?php if( !empty($block['style']['typography']['textAlign']) ) : ?>
                    text-align: <?php echo $block['style']['typography']['textAlign']; ?>;
                <?php endif; ?>
            }</style><?php
        }

        public function addScript() {
            $key = get_option('nguyenmapapikey') ? get_option('nguyenmapapikey') : Redux::get_option('made_theme', 'google-map-api-key');
            $js = 'https://maps.googleapis.com/maps/api/js?key='.$key;
            echo '<script src="https://maps.googleapis.com/maps/api/js?key='.$key.'&callback=initMap" async defer></script>';
        }
        public function addScriptHeader($latitude, $longitude, $address, $zoom) {
            echo '<script>
            function initMap() {                
                var icon = {
                    url: \''.plugin_dir_url( __FILE__ ) . '../public/pin.svg\',
                    scaledSize: new google.maps.Size(30, 30), // scaled size
                    origin: new google.maps.Point(0,0), // origin
                    anchor: new google.maps.Point(0, 0) // anchor
                };
                var myLatLng = new google.maps.LatLng('.$latitude.', '.$longitude.');
                var options = {
                    zoom: '.$zoom.',
                    center: myLatLng,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                var map = new google.maps.Map(document.getElementById(\'pro_nguyenmapinit\'), options);
                var marker = new google.maps.Marker({
                    position: myLatLng,
                    icon: icon,
                    map: map,
                    title: \''.$address.'\'
                });
                var html = \'<div class="gp-info-window">\';
                html += \'<div style="margin-bottom:5px"><b>Address: </b>\' + \''.$address.'\' + \'</div>\';
                html += \'</div>\';

                var infoWindow = new google.maps.InfoWindow({
                    content: html
                });

                marker.addListener(\'click\', function() {
                    infoWindow.open(map, marker);
                });
            }
            </script>';
        }

        public function shortcode($atts) {
            add_action('wp_footer', array($this, 'addScript'), -1000);
            $atts = shortcode_atts( array(
                'address' => '',
                'latitude' => '',
                'longitude' => '',
                'height' => '400',
                'zoom' => '17',
            ), $atts, 'n3_property_map' );
            $address = $atts['address'];
            $latitude = $atts['latitude'];
            $longitude = $atts['longitude'];
            $height = $atts['height'] ? $atts['height'] : '400';
            $zoom = $atts['zoom'] ? $atts['zoom'] : '17';
            $html = '';
            $html .= '<div class="gp-maps" id="pro_nguyenmapinit" style="height: '.$height.'px;">No Maps Found, Please add some maps.</div>';
            $this->addScriptHeader($latitude, $longitude, $address, $zoom);
            return $html;
        }

        public function formatText($text) {
            // single_net to Single Net
            $text = str_replace('_', ' ', $text);
            $text = ucwords($text);
            return $text;
        }

        public function _buildShortcode( $atts ) {
            $atts = shortcode_atts( array(
                'field' => '',
            ), $atts, 'n3_property_field' );
            ob_start();
            $field = $atts['field'];

            // Get post ACF field
            $fields = get_fields(get_the_ID()) ?? null;
            $field_details = get_field($field, get_the_ID()) ?? null;
            $field_general = get_field('general', get_the_ID())[$field] ?? null;
            $field_location_information = get_field('location_information', get_the_ID())[ $field ] ?? null;
            $field_rank = get_field('url', get_the_ID()) ?? null;
            if ( $field == 'brochure_name' ) {
                if ( !isset($fields['brochure']) ) {
                    return is_admin() ? 'N/A' : '';
                }
                echo $fields['brochure']['filename'] ?? '';
            } else if ( $field == 'brochure_url' ) {
                if ( !isset($fields['brochure']) ) {
                    return is_admin() ? 'N/A' : '';
                }
                echo $fields['brochure']['url'] ?? '';
            } else if ( $field == 'property_status' ) {
                if ( $field_details == 'pending' ) {
                    $check_length = '<span class="bg-yellow-400 text-white px-2 py-1 rounded">Pending</span>';
                } else if ( $field_details == 'escrow' ) {
                    $check_length = '<span class="bg-purple-400 text-white px-2 py-1 rounded">Escrow</span>';
                } else if ( $field_details == 'sold' ) {
                    $check_length = '<span class="bg-green-400 text-white px-2 py-1 rounded">Sold</span>';
                } else if ( $field_details == 'active' ) {
                    $check_length = '<span class="bg-blue-400 text-white px-2 py-1 rounded">Active</span>';
                } else {
                    $check_length = '<span class="bg-gray-400 text-white px-2 py-1 rounded">Closed</span>';
                }
                echo $check_length;
            } else if ( $field == 'property_type' || $field == 'offering_type' || $field == 'year_built' || $field == 'surface' || $field == 'surface_unit' || $field == 'units_count' || $field == 'price' || $field == 'price_postfix' || $field == 'active_date' ) {
                if ( $field == 'property_type' || $field == 'offering_type' ) {
                    $check_length = $this->displayTag($field_general);
                } else {
                    $check_length = strlen($field_general) > 0 ? $field_general : (is_admin() ? 'N/A' : '');
                }
                echo $check_length;
            } else if ( $field == 'state' || $field == 'city' || $field == 'country' || $field == 'county' || $field == 'neighborhood' || $field == 'zip_code' || $field == 'address' || $field == 'latitude' || $field == 'longitude' ) {
                if ( $field == 'state' ) {
                    $state_arr = $field_location_information;
                    $getState = $this->displayArrayState($state_arr);
                    echo $getState ?? '';
                } else {
                    echo $field_location_information ?? '';
                }
            } else if ( $field == 'rank_url' ) {
                if ( !isset($field_rank) ) {
                    return is_admin() ? 'N/A' : '';
                }
                $rank_url = $field_rank['url'] ?? '';
                echo $rank_url;
            } else if ( $field == 'rank_title' ) {
                if ( !isset($field_rank) ) {
                    return is_admin() ? 'N/A' : '';
                }
                $rank_title = $field_rank['title'] ?? '';
                echo $rank_title;
            } else if ( $field == 'rank_target' ) {
                if ( !isset($field_rank) ) {
                    return is_admin() ? 'N/A' : '';
                }
                $rank_target = $field_rank['target'] ?? '';
                echo $rank_target;
            } else {
                if ( !isset($field_details) ) {
                    return is_admin() ? 'N/A' : '';
                }
                echo $field_details ?? '';
            }
            return ob_get_clean();
        }

        function ___n3_properties_pre_get_posts( $query ) {
            if ( is_admin() && $query->is_main_query() && is_post_type_archive( 'n3_properties' ) ) {
                $query->set('orderby', 'id');
                $query->set('order', 'DESC');
            }
        }

         // Display Array State 
         public function displayArrayState($state_arr) {
            $state = is_admin() ? 'N/A' : '';
            if ( !empty($state_arr) && is_array($state_arr) ) {
                $state = '';
                if ( isset($state_arr['value']) && isset($state_arr['label']) ) {
                    return $state_arr['label'];
                } else {
                    foreach ($state_arr as $key => $value) {
                        $state .= $value['label'] . ', ';
                    }
                    return rtrim($state, ', ');
                }
            } else if ( !empty($state_arr) && is_string($state_arr) ) {
                return $state_arr;
            }
            return $state;
        }

        // Display Tag 
        public function displayTag($tag_arr) {
            $tag = is_admin() ? 'N/A' : '';
            if ( !empty($tag_arr) && is_array($tag_arr) ) {
                $tag = '';
                foreach ($tag_arr as $key => $value) {
                    // $tag .= $value . ', ';
                    // Capitalize the first letter of each word.
                    $tag .= ucwords($value) . ', ';
                }
                return rtrim($tag, ', ');
            } else if ( !empty($tag_arr) && is_string($tag_arr) ) {
                return $tag_arr;
            }
            return $tag;
        }

        function ___n3_properties_ats() {
            add_theme_support( 'block-template-parts' );
        }

        public function ___n3_properties_archive_template($archive_template) {
            $nguyen_property_archive_template = get_option('nguyen_property_archive_template');
            if ( $nguyen_property_archive_template === 'yes' ) {
                if ( is_post_type_archive ( 'n3_properties' ) ) {
                    $theme_files = array('archive.php');
                    $exists_in_theme = locate_template($theme_files, false);
                    if($exists_in_theme == '') {
                        return plugin_dir_path( __FILE__ ) . 'archive.php';
                    }
                }
            }
            return $archive_template;
        }

        public function ___n3_properties_single_template($single_template) {
            $nguyen_property_single_template = get_option('nguyen_property_single_template');
            if ( $nguyen_property_single_template === 'yes' ) {
                if ( get_post_type() == 'n3_properties' ) {
                    $theme_files = array('single.php');
                    $exists_in_theme = locate_template($theme_files, false);
                    if($exists_in_theme == '') {
                        return plugin_dir_path( __FILE__ ) . 'single.php';
                    }
                }
            }
            return $single_template;
        }

        public function allow_user_roles() {
            $user = wp_get_current_user();
            if ( in_array( 'administrator', (array) $user->roles ) ||  in_array( 'editor', (array) $user->roles ) ||   in_array( 'shop_manager', (array) $user->roles ) ) {
                return;
            }
            $allowed_roles = array('author', 'contributor', 'subscriber');
            $user_roles = array_intersect( $allowed_roles, (array) $user->roles );
            if ( !empty( $user_roles ) ) {
                return;
            }
            wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'gp-theme' ) );
        }

        public function __addSubmenu() {
            add_submenu_page(
                'edit.php?post_type=n3_properties',
                'Settings',
                'Settings',
                'manage_options',
                'n3_properties_settings',
                array($this, '___settingsPage'),
                // 0
            );

        }

        public function ___settingsPage() {
            require_once( plugin_dir_path( __FILE__ ) . 'setting_global.php' );
        }

        public function ___addToAdminBar() {
            global $wp_admin_bar;
            $wp_admin_bar->add_menu( array(
                'id'    => 'gp-properties',
                'title' => esc_html__( 'N3 Properties', 'gp-theme' ),
                'parent' => 'made_theme_options',
                'href'  => admin_url( 'edit.php?post_type=n3_properties' ),
            ));
            // $wp_admin_bar->add_menu( array(
            //     'id'    => 'gp-reusable-properties',
            //     'title' => esc_html__( 'GP Reusable blocks', 'gp-theme' ),
            //     'parent' => 'made_theme_options',
            //     'href'  => admin_url( 'edit.php?post_type=wp_block' ),
            // ));
        }

        public function updateSticky() {
            if ( isset( $_GET['sticky'] ) && $_GET['post_type'] == 'n3_properties' ) {
                $sticky = $_GET['sticky'];
                $post_id = $_GET['post'];
                $sticky = get_option( 'sticky_posts' );
                if ( $sticky ) {
                    if ( in_array( $post_id, $sticky ) ) {
                        $sticky = array_diff( $sticky, array( $post_id ) );
                    } else {
                        $sticky[] = $post_id;
                    }
                } else {
                    $sticky = array( $post_id );
                }
                update_option( 'sticky_posts', $sticky );
            }
        }

        public function ___n3_property_categories () {
            $labels = array(
                'name'              => esc_html__( 'Categories', 'gp-theme' ),
                'singular_name'     => esc_html__( 'Property Category', 'gp-theme' ),
                'search_items'      => esc_html__( 'Search Categories', 'gp-theme' ),
                'all_items'         => esc_html__( 'All Categories', 'gp-theme' ),
                'parent_item'       => esc_html__( 'Parent Property Category', 'gp-theme' ),
                'parent_item_colon' => esc_html__( 'Parent Property Category:', 'gp-theme' ),
                'edit_item'         => esc_html__( 'Edit Property Category', 'gp-theme' ),
                'update_item'       => esc_html__( 'Update Property Category', 'gp-theme' ),
                'add_new_item'      => esc_html__( 'Add New Property Category', 'gp-theme' ),
                'new_item_name'     => esc_html__( 'New Property Category Name', 'gp-theme' ),
                'menu_name'         => esc_html__( 'Categories', 'gp-theme' ),
            );
            $args = array(
                'labels' => $labels,
                'hierarchical' => true,
                'public' => true,
                'show_ui' => true,
                'show_admin_column' => true,
                'show_in_nav_menus' => true,
                'show_tagcloud' => true,
                'show_in_rest'       => true, // To use Gutenberg editor.
                // 'template_lock' => 'all', // To use Gutenberg editor.
                'rewrite' => array(
                    'slug' => 'property-category',
                    'with_front' => true,
                    'hierarchical' => true
                ),
            );
            register_taxonomy( 'n3_property_categories', array( 'n3_properties' ), $args );
        }

        public function ___n3_properties() {
            register_post_type('n3_properties', 
                array(	
                    'label' => 'N3 Properties',
                    'description' => 'Create a post of Properties',
                    'public' => true,
                    'show_ui' => true,
                    'menu_icon' => 'dashicons-location-alt',
                    'show_in_menu' => true,
                    'show_in_rest'       => true, // To use Gutenberg editor.
                    // 'template_lock' => 'all', // To use Gutenberg editor.
                    'template' => array(
                        array( 'core/columns', array(), array(
                            array( 'core/column', array(), array(
                                array( 'core/image', array() ),
                            ) ),
                            array( 'core/column', array(), array(
                                array( 'core/paragraph', array(
                                    'placeholder' => 'Add a inner paragraph'
                                ) ),
                            ) ),
                        ) )
                    ),
                    'capability_type' => 'post',
                    'hierarchical' => true,
                    'rewrite' => array(
                        'slug' => 'properties',
                        'post_type' => 'n3_properties',
                        // 'with_front' => true,
                        // 'hierarchical' => true
                    ),
                    'query_var' => true,
                    'has_archive' => true,
                    // 'exclude_from_search' => true,
                    'menu_position' => 35,
                    'supports' => array(
                        'title',
                        'editor',
                        'custom-fields',
                        'revisions',
                        'author',
                        'thumbnail',
                        // Sticky posts.
                        'sticky',
                    ),
                    // Order by post ID
                    'orderby' => 'id',
                    // Order by post ID
                    'order' => 'desc',
                    'labels' => array (
                        'name' => 'N3 Properties',
                        'singular_name' => 'N3 Properties',
                        'menu_name' => 'N3 Properties',
                        'add_new' => 'Add Property',
                        'add_new_item' => 'Add New Property',
                        'new_item' => 'New Property',
                        'edit' => 'Edit',
                        'edit_item' => 'Edit Property',
                        'view' => 'View Property',
                        'view_item' => 'View Property',
                        'search_items' => 'Search Properties',
                        'not_found' => 'No Properties Found',
                        'not_found_in_trash' => 'No Properties Found in Trash',
                        'parent' => 'Parent Property'
                    ),
                    
                )
            );
        }

        // Hooking up our function to theme setup
        public function ___n3_properties_columns( $column, $post_id ) {
            global $post;
            $post_data = get_post($post_id, ARRAY_A);
            $slug = isset($post_data['post_name'] ) ? $post_data['post_name'] : '';
        
            switch( $column ) {
                // case 'gpthumbnail' :
                //     echo get_the_post_thumbnail( $post_id, array(60,60) );
                // break;
                case 'sticky' :
                    // Check Post Sticky
                    $sticky = get_option( 'sticky_posts' );
                    $sticky = in_array( $post_id, $sticky ) ? 'yes' : 'no';
                    if ( $sticky == 'yes' ) {
                        echo '<a href="'.admin_url( 'edit.php?post_type=n3_properties&sticky=no&post='.$post_id ).'"><span class="dashicons dashicons-star-filled"></span></a>';
                    } else {
                        echo '<a href="'.admin_url( 'edit.php?post_type=n3_properties&sticky=yes&post='.$post_id ).'"><span class="dashicons dashicons-star-empty"></span></a>';
                    }
                break;
                case 'property_category' :
                    $terms = get_the_terms( $post_id, 'n3_property_categories' );
                    if ( !empty( $terms ) ) {
                        $out = array();
                        foreach ( $terms as $term ) {
                            $out[] = sprintf( '<a href="%s">%s</a>',
                                esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'n3_property_categories' => $term->slug ), 'edit.php' ) ),
                                esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'n3_property_categories', 'display' ) )
                            );
                        }
                        echo join( ', ', $out );
                    } else {
                        _e( '-', 'gp-theme' );
                    }
                break;
                case 'info' :
                    $db = get_fields($post_id);
                    $stt = $db['property_status'];
                    $location = $db['location_information'];
                    if ( $stt ) {
                        if ( $stt == 'pending' ) {
                            echo '<span class="badge text-bg-warning">Pending</span>';
                        } else if ( $stt == 'escrow' ) {
                            echo '<span class="badge text-bg-info">Escrow</span>';
                        } else if ( $stt == 'sold' ) {
                            echo '<span class="badge text-bg-success">Sold</span>';
                        } else if ( $stt == 'active' ) {
                            echo '<span class="badge text-bg-primary">Active</span>';
                        } else {
                            echo '<span class="badge text-bg-secondary">Unknown</span>';
                        }
                    }
                    if ( $location ) {
                        echo " ";
                        echo ''.$location['city'].' - ';
                        $state_arr = $location['state'];
                        echo $state_arr['label'];
                    }
                break;
                case 'sharplaunch' :
                    $sharplaunch = get_field('sharplaunch', $post_id) ?? null;
                    if ( $sharplaunch ) {
                        // https://admin.sharplaunch.com/#/48779/cms/sections/building/
                        echo '<a href="https://admin.sharplaunch.com/#/'.$sharplaunch.'/cms/sections/building/" target="_blank">Go App<span class="dashicons dashicons-external"></span></a>';
                    }
                break;
            }


        }
        public function ___n3_properties_edit_columns( $columns ) {
        
            $columns = array(
                'cb' => '<input type="checkbox" />',
                'gpthumbnail' => '<span class="dashicons dashicons-format-image"></span>',
                'title' => __( 'Title' ),
                'info' => __( 'Info' ),
                'property_category' => __( 'Property Category' ),
                'sharplaunch' => __( 'Sharplaunch' ),
                // 'author' => __( 'Author' ),
                // 'sticky' => __( 'Sticky' ),
                'date' => __( 'Date' )
            );
        
            return $columns;
        }

    }
}

new GPC_Core_PROPRETIE();
