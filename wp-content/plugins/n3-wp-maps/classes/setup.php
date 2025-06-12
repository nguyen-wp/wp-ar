<?php 
if (!class_exists('GPC_Core_MAP')) {
    class GPC_Core_MAP {
        function __construct()  {
            add_action( 'init', array($this, '___n3_map_categories') );
            add_action( 'init', array($this, '___n3_map_categories_2') );
            add_action( 'init', array($this, '___n3_map_categories_3') );
            add_action( 'init', array($this, '___n3_map_categories_4') );
            add_action( 'init', array($this, '___n3_maps') );
            
            add_action( 'manage_n3_maps_posts_custom_column',  array($this,'___n3_maps_columns'), 10, 2 );
            add_filter( 'manage_edit-n3_maps_columns',  array($this,'___n3_maps_edit_columns') ) ;
            add_action( 'admin_bar_menu', array( $this, '___addToAdminBar' ), 100 );
            // add_action('admin_init', array($this, 'allow_user_roles'));

            add_filter('pre_get_posts', array($this, '___n3_maps_pre_get_posts'));

            // Add Archive and Single Templates
            add_filter( 'archive_template', array($this, '___n3_maps_archive_template') ) ;
            add_filter( 'single_template', array($this, '___n3_maps_single_template') ) ;
            add_filter( 'after_setup_theme', array($this, '___n3_maps_ats') ) ;

            // updateSticky
            add_action( 'init', array($this, 'updateSticky') );

            // Add Shortcode
            add_shortcode( 'n3_maps_menu', array($this, 'shortcode_menu') );
            add_shortcode( 'n3_maps', array($this, 'shortcode') );
            add_shortcode( 'n3_maps_filter', array($this, 'shortcode_filter') );
            add_shortcode( 'n3_maps_filter_city', array($this, 'shortcode_filter_city') );
            add_shortcode( 'n3_maps_filter_size', array($this, 'shortcode_filter_size') );
            add_shortcode( 'n3_maps_filter_type', array($this, 'shortcode_filter_type') );
            add_shortcode( 'n3_map_map', array($this, 'shortcode_n3_map_map') );

            // [n3_google_map]
            add_shortcode( 'n3_google_map', array($this, 'shortcode_map') );

            // Add Setting Page 
            add_action('admin_menu', array($this, '__addSubmenu'));

            // ACF 
            add_action('acf/init', array($this, 'register_acf_block'));
        }

        public function register_acf_block() {
            if( function_exists('acf_register_block_type') ) {
                $arr = array(
                    // description
                    array(
                        'key' => 'description',
                        'title' => 'Map Description',
                    ),
                    array(
                        'key' => 'mapget',
                        'title' => 'Map Details',
                    ),
                    // GROUP: map
                    array(
                        'key' => 'address',
                        'title' => 'Map Address',
                    ),
                    array(
                        'key' => 'latitude',
                        'title' => 'Map Latitude',
                    ),
                    array(
                        'key' => 'longitude',
                        'title' => 'Map Longitude',
                    ),
                    array(
                        'key' => 'city',
                        'title' => 'Map City',
                    ),
                    array(
                        'key' => 'state',
                        'title' => 'Map State',
                    ),
                    array(
                        'key' => 'country',
                        'title' => 'Map Country',
                    ),
                    array(
                        'key' => 'zip_code',
                        'title' => 'Map Zip Code',
                    ),
                    array(
                        'key' => 'phone',
                        'title' => 'Map Phone',
                    ),
                    array(
                        'key' => 'email',
                        'title' => 'Map Email',
                    ),
                    array(
                        'key' => 'url',
                        'title' => 'Map URL',
                    )
                );
                foreach ($arr as $key => $value) {
                    // https://developer.wordpress.org/block-editor/reference-guides/block-api/block-supports/
                    acf_register_block_type(array(
                        'name'              => 'map_' . $value['key'],
                        'title'             => $value['title'],
                        'key'               => $value['key'],
                        'description'       => __('A custom block to display the field (ACF field) inside the Query Loop block.'),
                        'render_callback'   => array($this, '__acf_function'),
                        'category'          => 'formatting',
                        'icon'              => 'feedback',
                        'keywords'          => array( 'map', 'acf', $value['key'] ),
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
            $field_location_information = get_field('map', get_the_ID()) ?? null;
            if ( $key == 'state' || $key == 'city' || $key == 'address' || $key == 'latitude' || $key == 'longitude' || $key == 'zip_code' || $key == 'phone' || $key == 'country' || $key == 'email' || $key == 'url' ) {
                if ( $key == 'state' ) {
                    $check_length = $this->displayArrayState($field_location_information[$key]);
                } else {
                    if ( $field_location_information[$key] == 'url' ) {
                        $check_length = '<a href="'.$field_location_information[$key].'" target="_blank">'.$field_location_information[$key].'</a>';
                    } else {
                        $check_length = $field_location_information[$key];
                    }
                }
            } else if ( $key == 'mapget' ) {
                $check_length = do_shortcode('[n3_map_map address="'.$field_location_information['address'].'" latitude="'.$field_location_information['latitude'].'" longitude="'.$field_location_information['longitude'].'" height="400" zoom="17"]');
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


        public function shortcode_n3_map_map($atts) {
            $post_id = get_the_ID();
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
            $html .= '<div class="gp-maps" id="map_nguyenmapinit_'.$post_id.'" style="height: '.$height.'px;">No Maps Found, Please add some maps.</div>';
            $this->addScriptHeaderID($latitude, $longitude, $address, $zoom, $post_id);
            return $html;
        }

        public function addScriptHeaderID($latitude, $longitude, $address, $zoom, $post_id) {
            echo '<script>
            function initMap_'.$post_id.'() {
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
                map = new google.maps.Map(document.getElementById(\'map_nguyenmapinit_'.$post_id.'\'), options);
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
            $key = get_option('nguyenmapapikey') ? get_option('nguyenmapapikey') : Redux::get_option('made_theme', 'google-map-api-key');
            echo '<script src="https://maps.googleapis.com/maps/api/js?key='.$key.'&callback=initMap_'.$post_id.'" async defer></script>';
        }

        public function shortcode_map($atts) {
            add_action('wp_footer', array($this, 'addScript'), -1000);
            $atts = shortcode_atts( array(
                'address' => '',
                'latitude' => '',
                'longitude' => '',
                'height' => '400',
                'zoom' => '17',
            ), $atts, 'n3_google_map' );
            $address = $atts['address'];
            $latitude = $atts['latitude'];
            $longitude = $atts['longitude'];
            $height = $atts['height'] ? $atts['height'] : '400';
            $zoom = $atts['zoom'] ? $atts['zoom'] : '17';
            $html = '';
            $html .= '<div class="gp-maps" id="map_nguyenmapinit" style="height: '.$height.'px;">No Maps Found, Please add some maps.</div>';
            $this->addScriptHeader($latitude, $longitude, $address, $zoom);
            return $html;
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
                map = new google.maps.Map(document.getElementById(\'map_nguyenmapinit\'), options);
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

        public function ___n3_maps_wp_head() {
            $args = array(
                'post_type' => 'n3_maps',
                'posts_per_page' => 1,
                'orderby' => 'name',
                'order' => 'DESC',
            );
            $query = new WP_Query( $args );
            $plugind_pin_icon = plugin_dir_url( __FILE__ ) . '../public/pin.svg';
            $custom_pin_icon = get_option('nguyenmapamarker') ? get_option('nguyenmapamarker') : $plugind_pin_icon;
            $info_window_class = get_option('nguyenmapainfowindow') ? get_option('nguyenmapainfowindow') : 'gp-info-window';


            $argsall = array(
                'post_type' => 'n3_maps',
                'posts_per_page' => -1,
                'orderby' => 'name',
                'order' => 'DESC',
            );
            $queryAll = new WP_Query( $argsall );
            $html = '';
            if ( $queryAll->have_posts() ) {
                $html .= '<script>var nguyenmaps = [';
                while ( $queryAll->have_posts() ) {
                    $queryAll->the_post();
                    $post = get_post();
                    $fields = get_fields(get_the_ID()) ?? null;
                    if( $fields['map']['latitude'] &&  $fields['map']['longitude']) {
                        $cats = get_the_terms(get_the_ID(), 'n3_map_categories');
                        $all_cats = array();
                        if ( !empty( $cats ) ) {
                            foreach ( $cats as $cat ) {
                                $all_cats[] = $cat->slug;
                            }
                        }
                        $cats_2 = get_the_terms(get_the_ID(), 'n3_map_categories_2');
                        $all_cats_2 = array();
                        if ( !empty( $cats_2 ) ) {
                            foreach ( $cats_2 as $cat_2 ) {
                                $all_cats_2[] = $cat_2->slug;
                            }
                        }
                        $cats_3 = get_the_terms(get_the_ID(), 'n3_map_categories_3');
                        $all_cats_3 = array();
                        if ( !empty( $cats_3 ) ) {
                            foreach ( $cats_3 as $cat_3 ) {
                                $all_cats_3[] = $cat_3->slug;
                            }
                        }
                        $cats_4 = get_the_terms(get_the_ID(), 'n3_map_categories_4');
                        $all_cats_4 = array();
                        if ( !empty( $cats_4 ) ) {
                            foreach ( $cats_4 as $cat_4 ) {
                                $all_cats_4[] = $cat_4->slug;
                            }
                        }
                        $html .= "{
                            'Code': '" . $post->post_name . "',
                            'Name': '" . $this->removeSpecialChars(get_the_title()) . "',
                            'City': '" . $this->removeSpecialChars($fields['map']['city']) . "',
                            'State': '" . $this->removeSpecialChars($fields['map']['state']['label']) . "',
                            'Country': '" . $this->removeSpecialChars($fields['map']['country']) . "',
                            'Location': { 'Latitude': " . $fields['map']['latitude'] . ", 'Longitude': " . $fields['map']['longitude'] . " },
                            'Address': '" . $this->removeSpecialChars($fields['map']['address']) . "',
                            'URL': '" . $this->removeSpecialChars($fields['map']['url']) . "',
                            'Phone': '" . $this->removeSpecialChars($fields['map']['phone']) . "',
                            'icon': '" . $this->removeSpecialChars($fields['map']['icon']) . "',
                            'Photo': '" . get_the_post_thumbnail_url(get_the_ID() , 'full') . "',
                            'Description': '" . wp_strip_all_tags($this->removeSpecialChars($fields['description'])) . "',
                            'Category': '" . implode(',', $all_cats) . "',
                            'Cat2': '" . implode(',', $all_cats_2) . "',
                            'Cat3': '" . implode(',', $all_cats_3) . "',
                            'Cat4': '" . implode(',', $all_cats_4) . "'
                        },";
                    }
                }
                $html .= '];</script>';
                wp_reset_postdata();
            } 
            echo $html;

            echo '<script>
            var map;
            var Data = [];
            var viewportMarkers = [];
            var infoWindow;
            var markerCount = 0; 
            function initMap() {
            ';
            if( get_option('nguyenmapalatitude') && get_option('nguyenmapalongitude') ) {
                echo "  var lat = '" . get_option('nguyenmapalatitude') . "';";
                echo "  var lng = '" . get_option('nguyenmapalongitude') . "';";
            } else {
                if ( $query->have_posts() ) {
                    while ( $query->have_posts() ) {
                        $query->the_post();
                        $fields = get_fields(get_the_ID()) ?? null;
                        echo "  var lat = '" . $fields['map']['latitude'] . "';
                        ";
                        echo "  var lng = '" . $fields['map']['longitude'] . "';";
                    }
                    wp_reset_postdata();
                }
            }
            $defaultzoom = get_option('nguyenmapazoom') ? get_option('nguyenmapazoom') : 9;
            echo '
                var iniZoom = ' . $defaultzoom . ';
                var myLatLng = new google.maps.LatLng(lat, lng);
                var options = {
                    zoom: iniZoom,
                    center: myLatLng,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                map = new google.maps.Map(document.getElementById(\'map_nguyenmapinit\'), options); 
                google.maps.event.addListener(map, \'dragend\', function () {
                    showMarkersInViewport();
                });
                google.maps.event.addListener(map, \'idle\', function () {
                    showMarkersInViewport();
                });
            } 
            
            function showMarkersInViewport() {
                if (viewportMarkers != null) {
                    for (i = 0; i < viewportMarkers.length; i++) {
                        viewportMarkers[i].setMap(null);
                    }
                    viewportMarkers = []; 
                    google.maps.event.addListener(map, "click", function () {
                        infoWindow.close();
                    }); 
                    google.maps.event.addListener(map, \'click\', function selectDataRow(code) {
                        var table = document.getElementById("tbl");
                    
                        for (var i = 1, row; row = table.rows[i]; i++) {
                            row.style.backgroundColor = "#ffffff";
                        }
                    });
                } 
                var divTable = \'<div class="maplist">\'; 
                var nguyenmapsInViewport = getAirports(map.getBounds());
                
                if (nguyenmapsInViewport == null) return; 
                    for (i = 0; i < nguyenmapsInViewport.length; i++) {
                        var icon = {
                            url: nguyenmapsInViewport[i].icon ? nguyenmapsInViewport[i].icon : \''.$custom_pin_icon.'\',
                            scaledSize: new google.maps.Size(30, 30), // scaled size
                            origin: new google.maps.Point(0,0), // origin
                            anchor: new google.maps.Point(0, 0) // anchor
                        };
                    
                        var marker = new google.maps.Marker({
                            position: new google.maps.LatLng(nguyenmapsInViewport[i].Location.Latitude, nguyenmapsInViewport[i].Location.Longitude),
                            icon: icon,
                            title: nguyenmapsInViewport[i].Name
                        });

                        var html = \'\';
                        html += \'<div class="\' + \''.$info_window_class.'\' + \'">\';
                        // if (nguyenmapsInViewport[i].Photo !== null && nguyenmapsInViewport[i].Photo !== \'\') {
                        //     html += \'<div style="margin-bottom:5px"><img style="max-width:100%;max-height: 80px" src="\' + nguyenmapsInViewport[i].Photo + \'" /></div>\';
                        // }

                        if (nguyenmapsInViewport[i].URL !== null && nguyenmapsInViewport[i].URL !== \'\') {
                            html += \'<div style="margin-bottom:5px; font-size: 1.3rem"><a href="\' + nguyenmapsInViewport[i].URL + \'" target="_blank"><b>Name: </b>\' + nguyenmapsInViewport[i].Name + \'</a></div>\';
                        } else {
                            html += \'<div style="margin-bottom:5px"><b>Name: </b>\' + nguyenmapsInViewport[i].Name + \'</div>\';
                        }
                            
                        if (nguyenmapsInViewport[i].Address !== null && nguyenmapsInViewport[i].Address !== \'\') {
                            html += \'<div style="margin-bottom:5px"><b>Address: </b>\' + nguyenmapsInViewport[i].Address + \'</div>\';
                        }
                    
                        if (nguyenmapsInViewport[i].City !== null && nguyenmapsInViewport[i].City !== \'\') {
                            html += \'<div style="margin-bottom:5px"><b>City: </b>\' + nguyenmapsInViewport[i].City + \'</div>\';
                        }
                    
                        if (nguyenmapsInViewport[i].State !== null && nguyenmapsInViewport[i].State !== \'\') {
                            html += \'<div style="margin-bottom:5px"><b>State: </b>\' + nguyenmapsInViewport[i].State + \'</div>\';
                        }
                    
                        if (nguyenmapsInViewport[i].Country !== null && nguyenmapsInViewport[i].Country !== \'\') {
                            html += \'<div style="margin-bottom:5px"><b>Country: </b>\' + nguyenmapsInViewport[i].Country + \'</div>\';
                        }

                        // Open in Google Maps
                        html += \'<div style="margin-bottom:5px"><a href="https://www.google.com/maps/search/?api=1&query=\' + nguyenmapsInViewport[i].Name +\'+\'+ nguyenmapsInViewport[i].Address +\'+\'+ nguyenmapsInViewport[i].City +\'+\'+ nguyenmapsInViewport[i].State + \'" target="_blank">Open in Google Maps</a></div>\';
                        html += \'</div>\';

                        marker.objInfo = html; 
                        (function (index, selectedMarker) {
                            google.maps.event.addListener(selectedMarker, \'click\', function () {
                                if (infoWindow != null) infoWindow.setMap(null);
                                infoWindow = new google.maps.InfoWindow();
                                infoWindow.setContent(selectedMarker.objInfo);
                                infoWindow.open(map, selectedMarker);
                                selectDataRow(nguyenmapsInViewport[index].Code);
                            });
                        })(i, marker); 
                        marker.setMap(map); 
                        viewportMarkers.push(marker); 
                        var currentIndex = viewportMarkers.length - 1; 

                        if(nguyenmapsInViewport[i].Photo) {
                            divTable += \'<div class="item" cat4-id="\' + nguyenmapsInViewport[i].Cat4 + \'" cat3-id="\' + nguyenmapsInViewport[i].Cat3 + \'" cat2-id="\' + nguyenmapsInViewport[i].Cat2 + \'" cat-id="\' + nguyenmapsInViewport[i].Category + \'" id="mapid\' + nguyenmapsInViewport[i].Code + \'" onclick="highlightMarker(\' + currentIndex + \',\'+nguyenmapsInViewport[i].Location.Latitude+\',\'+nguyenmapsInViewport[i].Location.Longitude+\')">\' + \'<div class="mapgroup"><div class="mapthumb"><img src="\' + nguyenmapsInViewport[i].Photo + \'" class="object-cover"></div><div class="maptitle"><h4 class="maphead">\' + \'<a href="javascript:highlightMarker(\' + currentIndex + \',\'+nguyenmapsInViewport[i].Location.Latitude+\',\'+nguyenmapsInViewport[i].Location.Longitude+\')">\' + nguyenmapsInViewport[i].Name + \'</a></h4>\' + \'<div class="maplocation">\' + nguyenmapsInViewport[i].City + \' - \' + nguyenmapsInViewport[i].State + \'</div></div></div><div class="mapdescription">\' + nguyenmapsInViewport[i].Description + \'</div></div>\';
                        } else {
                            divTable += \'<div class="item" cat4-id="\' + nguyenmapsInViewport[i].Cat4 + \'" cat3-id="\' + nguyenmapsInViewport[i].Cat3 + \'" cat2-id="\' + nguyenmapsInViewport[i].City + \'" cat-id="\' + nguyenmapsInViewport[i].Category + \'" id="mapid\' + nguyenmapsInViewport[i].Code + \'" onclick="highlightMarker(\' + currentIndex + \',\'+nguyenmapsInViewport[i].Location.Latitude+\',\'+nguyenmapsInViewport[i].Location.Longitude+\')">\' + \'<div class="mapgroup"><div class="maptitle"><h4 class="maphead">\' + \'<a href="javascript:highlightMarker(\' + currentIndex + \',\'+nguyenmapsInViewport[i].Location.Latitude+\',\'+nguyenmapsInViewport[i].Location.Longitude+\')">\' + nguyenmapsInViewport[i].Name + \'</a></h4>\' + \'<div class="maplocation">\' + nguyenmapsInViewport[i].City + \' - \' + nguyenmapsInViewport[i].State + \'</div></div></div><div class="mapdescription">\' + nguyenmapsInViewport[i].Description + \'</div></div>\';
                            }

                        markerCount++;
                    }
                divTable += \'</div>\';';
            if (get_option('nguyen_map_only_display_items') == 'yes') {
                echo 'document.getElementById(\'nguyenmapmenu\').innerHTML = divTable;';
            } 
            echo '}            
            function selectDataRow(code) {
                var table = document.getElementById("nguyenmapmenu");
                table.querySelectorAll(\'.item\').forEach(function (item) {
                    if (item.id == \'mapid\' + code) {
                        item.classList.add(\'active\');
                    } else {
                        item.classList.remove(\'active\');
                    }
                });
            }
            
            function getAirports(a) {
                if (a == null || a == undefined) return null;
                    var selected = [];
                    for (i = 0; i < nguyenmaps.length; i++) {
                    if (a.contains(new google.maps.LatLng(nguyenmaps[i].Location.Latitude, nguyenmaps[i].Location.Longitude))) {
                        selected.push(nguyenmaps[i]);
                    }
                }
                return selected;
            } 
            
            function highlightMarker(index, lat, lng) {
                var location = new google.maps.LatLng(lat, lng);
                map.panTo(location);
                selectDataRow(nguyenmaps[index].Code);
                // if (infoWindow != null) infoWindow.setMap(null);
                // infoWindow = new google.maps.InfoWindow();
                // infoWindow.setContent(viewportMarkers[index].objInfo);
                // infoWindow.open(map, viewportMarkers[index]); 
                // viewportMarkers[index].setAnimation(google.maps.Animation.BOUNCE);
                // setTimeout(function () {
                //     viewportMarkers[index].setAnimation(null);
                // }, 1250); 
            } 

            function zoomMarker(index) {
                map.panTo(viewportMarkers[index].getPosition());
            }
            </script>';
        }

        public function __addSubmenu() {
            add_submenu_page(
                'edit.php?post_type=n3_maps',
                'Settings',
                'Settings',
                'manage_options',
                'n3_maps_settings',
                array($this, '___settingsPage')
            );
            add_submenu_page(
                'edit.php?post_type=n3_maps',
                'Shortcode',
                'Shortcode',
                'manage_options',
                'n3_maps_shortcode',
                array($this, '___shortcodePage')
            );
        }

        public function ___settingsPage() {
            require_once( plugin_dir_path( __FILE__ ) . 'setting.php' );
        }

        public function ___shortcodePage() {
            require_once( plugin_dir_path( __FILE__ ) . 'shortcode.php' );
        }

        public function shortcode() {
            add_action('wp_head', array($this, '___n3_maps_wp_head'));
            $key = get_option('nguyenmapapikey') ? get_option('nguyenmapapikey') : Redux::get_option('made_theme', 'google-map-api-key');
            // mapheight 
            $map_height = get_option('nguyenmapaheight') ? get_option('nguyenmapaheight') : '400';
            $html = '';
            $html .= '<div class="gp-maps" id="map_nguyenmapinit" style="height: '.$map_height.'px;">No Maps Found, Please add some maps.</div>';
            return $html;
        }

        public function addScript() {
            $key = get_option('nguyenmapapikey') ? get_option('nguyenmapapikey') : Redux::get_option('made_theme', 'google-map-api-key');
            $js = 'https://maps.googleapis.com/maps/api/js?key='.$key;
            echo '<script src="https://maps.googleapis.com/maps/api/js?key='.$key.'&callback=initMap" async defer></script>';
        }

        public function shortcode_menu() {
            add_action('wp_footer', array($this, 'addScript'), -1000);
            add_action('admin_footer', array($this, 'addScript'), -1000);
            $args = array(
                'post_type' => 'n3_maps',
                'posts_per_page' => -1,
                'orderby' => 'name',
                'order' => 'DESC',
            );
            $query = new WP_Query( $args );
            $html = '';
            if ( $query->have_posts() ) {
                $html .= '<div class="gp-maps-menu 123" id="nguyenmapmenu"></div>';
                if (get_option('nguyen_map_only_display_items') !== 'yes') {
                    $html .= '<script>';
                    $html .= 'var _dataMap = [';
                    while ( $query->have_posts() ) {
                        $query->the_post();
                        $post = get_post();
                        $fields = get_fields(get_the_ID()) ?? null;
                        $cats = get_the_terms(get_the_ID(), 'n3_map_categories');
                        $all_cats = array();
                        if ( !empty( $cats ) ) {
                            foreach ( $cats as $cat ) {
                                $all_cats[] = $cat->slug;
                            }
                        }
                        $cats_2 = get_the_terms(get_the_ID(), 'n3_map_categories_2');
                        $all_cats_2 = array();
                        if ( !empty( $cats_2 ) ) {
                            foreach ( $cats_2 as $cat_2 ) {
                                $all_cats_2[] = $cat_2->slug;
                            }
                        }
                        $cats_3 = get_the_terms(get_the_ID(), 'n3_map_categories_3');
                        $all_cats_3 = array();
                        if ( !empty( $cats_3 ) ) {
                            foreach ( $cats_3 as $cat_3 ) {
                                $all_cats_3[] = $cat_3->slug;
                            }
                        }
                        $cats_4 = get_the_terms(get_the_ID(), 'n3_map_categories_4');
                        $all_cats_4 = array();
                        if ( !empty( $cats_4 ) ) {
                            foreach ( $cats_4 as $cat_4 ) {
                                $all_cats_4[] = $cat_4->slug;
                            }
                        }
                        $html .= "{
                            'Code': '" . $post->post_name . "',
                            'Name': '" . $this->removeSpecialChars(get_the_title()) . "',
                            'City': '" . $this->removeSpecialChars($fields['map']['city']) . "',
                            'State': '" . $this->removeSpecialChars($fields['map']['state']['label']) . "',
                            'Country': '" . $this->removeSpecialChars($fields['map']['country']) . "',
                            'Location': { 'Latitude': " . $fields['map']['latitude'] . ", 'Longitude': " . $fields['map']['longitude'] . " },
                            'Address': '" . $this->removeSpecialChars($fields['map']['address']) . "',
                            'URL': '" . $this->removeSpecialChars($fields['map']['url']) . "',
                            'Phone': '" . $this->removeSpecialChars($fields['map']['phone']) . "',
                            'icon': '" . $this->removeSpecialChars($fields['map']['icon']) . "',
                            'Photo': '" . get_the_post_thumbnail_url(get_the_ID() , 'full') . "',
                            'Description': '" . wp_strip_all_tags($this->removeSpecialChars($fields['description'])) . "',
                            'Category': '" . implode(',', $all_cats) . "',
                            'Cat2': '" . implode(',', $all_cats_2) . "',
                            'Cat3': '" . implode(',', $all_cats_3) . "',
                            'Cat4': '" . implode(',', $all_cats_4) . "'
                        },";
                    }
                    $html .= '];';
                    $html .= 'function buildMenu(nguyenmaps){
                        var selected = [];
                        var divTable = \'<div class="maplist">\';
                        for (i = 0; i < nguyenmaps.length; i++) {
                            if(nguyenmaps[i].Photo) {
                                divTable += \'<div class="item" cat4-id="\' + nguyenmaps[i].Cat4 + \'" cat3-id="\' + nguyenmaps[i].Cat3 + \'" cat2-id="\' + nguyenmaps[i].Cat2 + \'" cat-id="\' + nguyenmaps[i].Category + \'" id="mapid\' + nguyenmaps[i].Code + \'" onclick="highlightMarker(\' + i + \',\'+nguyenmaps[i].Location.Latitude+\',\'+nguyenmaps[i].Location.Longitude+\')">\' + \'<div class="mapgroup"><div class="mapthumb"><img src="\' + nguyenmaps[i].Photo + \'" class="object-cover"></div><div class="maptitle"><h4 class="maphead">\' + \'<a href="javascript:highlightMarker(\' + i + \',\'+nguyenmaps[i].Location.Latitude+\',\'+nguyenmaps[i].Location.Longitude+\')">\' + nguyenmaps[i].Name + \'</a></h4>\' + \'<div class="maplocation">\' + nguyenmaps[i].City + \' - \' + nguyenmaps[i].State + \'</div></div></div><div class="mapdescription">\' + nguyenmaps[i].Description + \'</div></div>\';
                            } else {
                                divTable += \'<div class="item" cat4-id="\' + nguyenmaps[i].Cat4 + \'" cat3-id="\' + nguyenmaps[i].Cat3 + \'" cat2-id="\' + nguyenmaps[i].City + \'" cat-id="\' + nguyenmaps[i].Category + \'" id="mapid\' + nguyenmaps[i].Code + \'" onclick="highlightMarker(\' + i + \',\'+nguyenmaps[i].Location.Latitude+\',\'+nguyenmaps[i].Location.Longitude+\')">\' + \'<div class="mapgroup"><div class="maptitle"><h4 class="maphead">\' + \'<a href="javascript:highlightMarker(\' + i + \',\'+nguyenmaps[i].Location.Latitude+\',\'+nguyenmaps[i].Location.Longitude+\')">\' + nguyenmaps[i].Name + \'</a></h4>\' + \'<div class="maplocation">\' + nguyenmaps[i].City + \' - \' + nguyenmaps[i].State + \'</div></div></div><div class="mapdescription">\' + nguyenmaps[i].Description + \'</div></div>\';
                            }
                        }
                        divTable += \'</div>\';
                        if(document.getElementById(\'nguyenmapmenu\')) {
                            document.getElementById(\'nguyenmapmenu\').innerHTML = divTable;
                        }
                    }
                    buildMenu(_dataMap)
                    </script>';
                }
            } else {
                $html .= '<p>No Maps Found, Please add some maps.</p>';
            }
            wp_reset_postdata();
            return $html;
        }

        public function removeSpecialChars($string) {
            // Remove , . - _ / \ : ; " ' ` ~ ! @ # $ % ^ & * ( ) + = | { } [ ] < > ? from string
            return preg_replace('/[^A-Za-z0-9 ]/', '', $string);
        }

        // shortcode_filter
        public function shortcode_filter() {
            // By Category
            $args = array(
                'taxonomy' => 'n3_map_categories',
                'orderby' => 'name',
                'order' => 'ASC',
                'hide_empty' => true,
            );
            $terms = get_terms($args);
            $nguyenmapafilter = get_option('nguyenmapafilter') ? get_option('nguyenmapafilter') : 'select';
            $html = '';
            $html .= '<div class="gp-maps-filter gp-maps-filter-state">';
            if ($nguyenmapafilter == 'select') {
                $html .= '<select id="filter_by_category" onchange="filterByCategory(this.value)">';
                $html .= '<option value="">All State</option>';
                foreach ($terms as $term) {
                    $html .= '<option value="'.$term->slug.'">'.$term->name.'</option>';
                }
                $html .= '</select>';
            } else {
                $html .= '<ul>';
                $html .= '<li><a href="javascript:filterByCategory(\'\')">All State</a></li>';
                foreach ($terms as $term) {
                    $html .= '<li><a href="javascript:filterByCategory(\''.$term->slug.'\')">'.$term->name.'</a></li>';
                }
                $html .= '</ul>';
            }
            $html .= '</div>';
            $html .= '<script>
            function filterByCategory(cat) {
                var items = document.querySelectorAll("#nguyenmapmenu .item");
                items.forEach(function(item) {
                    if (cat == "") {
                        item.style.display = "block";
                    } else {
                        if (item.getAttribute("cat-id").indexOf(cat) > -1) {
                            item.style.display = "block";
                        } else {
                            item.style.display = "none";
                        }
                    }
                });
                // Add active class
                var links = document.querySelectorAll(".gp-maps-filter-state a");
                links.forEach(function(link) {
                    if (link.getAttribute("href") == "javascript:filterByCategory(\'" + cat + "\')") {
                        link.classList.add("active");
                    } else {
                        link.classList.remove("active");
                    }
                });
            }
            </script>';
            return $html;
        }

        // shortcode_filter_city
        public function shortcode_filter_city() {
             // All Category
            $args = array(
                'taxonomy' => 'n3_map_categories_2',
                'orderby' => 'name',
                'order' => 'ASC',
                'hide_empty' => true,
            );
            $terms = get_terms($args);
            $nguyenmapafilter = get_option('nguyenmapafilter') ? get_option('nguyenmapafilter') : 'select';
            $html = '';
            $html .= '<div class="gp-maps-filter gp-maps-filter-city">';
            if ($nguyenmapafilter == 'select') {
                $html .= '<select id="filter_by_city" onchange="filterByCity(this.value)">';
                $html .= '<option value="">All City</option>';
                foreach ($terms as $term) {
                    $html .= '<option value="'.$term->slug.'">'.$term->name.'</option>';
                }
                $html .= '</select>';
            } else {
                $html .= '<ul>';
                $html .= '<li><a href="javascript:filterByCity(\'\')">All City</a></li>';
                foreach ($terms as $term) {
                    $html .= '<li><a href="javascript:filterByCity(\''.$term->slug.'\')">'.$term->name.'</a></li>';
                }
                $html .= '</ul>';
            }
            $html .= '</div>';
            $html .= '<script>
            function filterByCity(cat) {
                var items = document.querySelectorAll("#nguyenmapmenu .item");
                items.forEach(function(item) {
                    if (cat == "") {
                        item.style.display = "block";
                    } else {
                        if (item.getAttribute("cat2-id").indexOf(cat) > -1) {
                            item.style.display = "block";
                        } else {
                            item.style.display = "none";
                        }
                    }
                });
                // Add active class
                var links = document.querySelectorAll(".gp-maps-filter-city a");
                links.forEach(function(link) {
                    if (link.getAttribute("href") == "javascript:filterByCity(\'" + cat + "\')") {
                        link.classList.add("active");
                    } else {
                        link.classList.remove("active");
                    }
                });
            }
            </script>';
            return $html;
        }

        // shortcode_filter_size
        public function shortcode_filter_size() {
             // All Category
            $args = array(
                'taxonomy' => 'n3_map_categories_3',
                'orderby' => 'name',
                'order' => 'ASC',
                'hide_empty' => true,
            );
            $terms = get_terms($args);
            $nguyenmapafilter = get_option('nguyenmapafilter') ? get_option('nguyenmapafilter') : 'select';
            $html = '';
            $html .= '<div class="gp-maps-filter gp-maps-filter-size">';
            if ($nguyenmapafilter == 'select') {
                $html .= '<select id="filter_by_size" onchange="filterBySize(this.value)">';
                $html .= '<option value="">All Size</option>';
                foreach ($terms as $term) {
                    $html .= '<option value="'.$term->slug.'">'.$term->name.'</option>';
                }
                $html .= '</select>';
            } else {
                $html .= '<ul>';
                $html .= '<li><a href="javascript:filterBySize(\'\')">All Size</a></li>';
                foreach ($terms as $term) {
                    $html .= '<li><a href="javascript:filterBySize(\''.$term->slug.'\')">'.$term->name.'</a></li>';
                }
                $html .= '</ul>';
            }
            $html .= '</div>';
            $html .= '<script>
            function filterBySize(cat) {
                var items = document.querySelectorAll("#nguyenmapmenu .item");
                items.forEach(function(item) {
                    if (cat == "") {
                        item.style.display = "block";
                    } else {
                        if (item.getAttribute("cat3-id").indexOf(cat) > -1) {
                            item.style.display = "block";
                        } else {
                            item.style.display = "none";
                        }
                    }
                });
                // Add active class
                var links = document.querySelectorAll(".gp-maps-filter-size a");
                links.forEach(function(link) {
                    if (link.getAttribute("href") == "javascript:filterBySize(\'" + cat + "\')") {
                        link.classList.add("active");
                    } else {
                        link.classList.remove("active");
                    }
                });
            }
            </script>';
            return $html;
        }

        // shortcode_filter_type
        public function shortcode_filter_type() {
             // All Category
            $args = array(
                'taxonomy' => 'n3_map_categories_4',
                'orderby' => 'name',
                'order' => 'ASC',
                'hide_empty' => true,
            );
            $terms = get_terms($args);
            $nguyenmapafilter = get_option('nguyenmapafilter') ? get_option('nguyenmapafilter') : 'select';
            $html = '';
            $html .= '<div class="gp-maps-filter gp-maps-filter-type">';
            if ($nguyenmapafilter == 'select') {
                $html .= '<select id="filter_by_type" onchange="filterByType(this.value)">';
                $html .= '<option value="">All Type</option>';
                foreach ($terms as $term) {
                    $html .= '<option value="'.$term->slug.'">'.$term->name.'</option>';
                }
                $html .= '</select>';
            } else {
                $html .= '<ul>';
                $html .= '<li><a href="javascript:filterByType(\'\')">All Type</a></li>';
                foreach ($terms as $term) {
                    $html .= '<li><a href="javascript:filterByType(\''.$term->slug.'\')">'.$term->name.'</a></li>';
                }
                $html .= '</ul>';
            }
            $html .= '</div>';
            $html .= '<script>
            function filterByType(cat) {
                var items = document.querySelectorAll("#nguyenmapmenu .item");
                items.forEach(function(item) {
                    if (cat == "") {
                        item.style.display = "block";
                    } else {
                        if (item.getAttribute("cat4-id").indexOf(cat) > -1) {
                            item.style.display = "block";
                        } else {
                            item.style.display = "none";
                        }
                    }
                });
                // Add active class
                var links = document.querySelectorAll(".gp-maps-filter-type a");
                links.forEach(function(link) {
                    if (link.getAttribute("href") == "javascript:filterByType(\'" + cat + "\')") {
                        link.classList.add("active");
                    } else {
                        link.classList.remove("active");
                    }
                });
            }
            </script>';
            return $html;
        }


        public function ___n3_maps_pre_get_posts( $query ) {
            if ( is_admin() && $query->is_main_query() && is_post_type_archive( 'n3_maps' ) ) {
                $query->set('orderby', 'id');
                $query->set('order', 'DESC');
            }
        }

        public function ___n3_maps_ats() {
            add_theme_support( 'block-template-parts' );
        }

        public function ___n3_maps_archive_template( $archive_template) {
            $nguyen_map_archive_template = get_option('nguyen_map_archive_template');
            if ( $nguyen_map_archive_template === 'yes' ) {
                if ( is_post_type_archive ( 'n3_maps' ) ) {
                    $theme_files = array('archive.php');
                    $exists_in_theme = locate_template($theme_files, false);
                    if($exists_in_theme == '') {
                        return plugin_dir_path( __FILE__ ) . 'archive.php';
                    }
                }
            }
            return $archive_template;
        }

        public function ___n3_maps_single_template( $single_template ) {
            $nguyen_map_single_template = get_option('nguyen_map_single_template');
            if ( $nguyen_map_single_template === 'yes' ) {
                if ( is_singular( 'n3_maps' ) ) {
                    $theme_files = array('single.php');
                    $exists_in_theme = locate_template($theme_files, false);
                    if($exists_in_theme == '') {
                        return plugin_dir_path( __FILE__ ) . 'single.php';
                    }
                }
            }
            return $single_template;
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

        public function ___addToAdminBar() {
            global $wp_admin_bar;
            $wp_admin_bar->add_menu( array(
                'id'    => 'gp-maps',
                'title' => esc_html__( 'N3 Maps', 'gp-theme' ),
                'parent' => 'made_theme_options',
                'href'  => admin_url( 'edit.php?post_type=n3_maps' ),
            ));
            // $wp_admin_bar->add_menu( array(
            //     'id'    => 'gp-reusable-maps',
            //     'title' => esc_html__( 'GP Reusable blocks', 'gp-theme' ),
            //     'parent' => 'made_theme_options',
            //     'href'  => admin_url( 'edit.php?post_type=wp_block' ),
            // ));
        }

        public function updateSticky() {
            if ( isset( $_GET['sticky'] ) && $_GET['post_type'] == 'n3_maps' ) {
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

        public function ___n3_map_categories () {
            $labels = array(
                'name'              => esc_html__( 'State', 'gp-theme' ),
                'singular_name'     => esc_html__( 'Map Option', 'gp-theme' ),
                'search_items'      => esc_html__( 'Search Option', 'gp-theme' ),
                'all_items'         => esc_html__( 'All Option', 'gp-theme' ),
                'parent_item'       => esc_html__( 'Parent Map Option', 'gp-theme' ),
                'parent_item_colon' => esc_html__( 'Parent Map Option:', 'gp-theme' ),
                'edit_item'         => esc_html__( 'Edit Map Option', 'gp-theme' ),
                'update_item'       => esc_html__( 'Update Map Option', 'gp-theme' ),
                'add_new_item'      => esc_html__( 'Add New Map Option', 'gp-theme' ),
                'new_item_name'     => esc_html__( 'New Map Option Name', 'gp-theme' ),
                'menu_name'         => esc_html__( 'State', 'gp-theme' ),
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
                    'slug' => 'map-category',
                    'with_front' => true,
                    'hierarchical' => true
                ),
            );
            register_taxonomy( 'n3_map_categories', array( 'n3_maps' ), $args );
        }

        // ___n3_map_categories_2
        public function ___n3_map_categories_2 () {
            $labels = array(
                'name'              => esc_html__( 'City', 'gp-theme' ),
                'singular_name'     => esc_html__( 'Map Option', 'gp-theme' ),
                'search_items'      => esc_html__( 'Search Option', 'gp-theme' ),
                'all_items'         => esc_html__( 'All Option', 'gp-theme' ),
                'parent_item'       => esc_html__( 'Parent Map Option', 'gp-theme' ),
                'parent_item_colon' => esc_html__( 'Parent Map Option:', 'gp-theme' ),
                'edit_item'         => esc_html__( 'Edit Map Option', 'gp-theme' ),
                'update_item'       => esc_html__( 'Update Map Option', 'gp-theme' ),
                'add_new_item'      => esc_html__( 'Add New Map Option', 'gp-theme' ),
                'new_item_name'     => esc_html__( 'New Map Option Name', 'gp-theme' ),
                'menu_name'         => esc_html__( 'City', 'gp-theme' ),
            );
            $args = array(
                'labels' => $labels,
                'hierarchical' => false,
                'public' => true,
                'show_ui' => true,
                'show_admin_column' => true,
                'show_in_nav_menus' => true,
                'show_tagcloud' => true,
                'show_in_rest'       => true, // To use Gutenberg editor.
                // 'template_lock' => 'all', // To use Gutenberg editor.
                'rewrite' => array(
                    'slug' => 'map-tag',
                    'with_front' => true,
                    'hierarchical' => false
                ),
            );
            register_taxonomy( 'n3_map_categories_2', array( 'n3_maps' ), $args );
        }

        // ___n3_map_categories_3
        public function ___n3_map_categories_3 () {
            $labels = array(
                'name'              => esc_html__( 'Size', 'gp-theme' ),
                'singular_name'     => esc_html__( 'Map Option', 'gp-theme' ),
                'search_items'      => esc_html__( 'Search Option', 'gp-theme' ),
                'all_items'         => esc_html__( 'All Option', 'gp-theme' ),
                'parent_item'       => esc_html__( 'Parent Map Option', 'gp-theme' ),
                'parent_item_colon' => esc_html__( 'Parent Map Option:', 'gp-theme' ),
                'edit_item'         => esc_html__( 'Edit Map Option', 'gp-theme' ),
                'update_item'       => esc_html__( 'Update Map Option', 'gp-theme' ),
                'add_new_item'      => esc_html__( 'Add New Map Option', 'gp-theme' ),
                'new_item_name'     => esc_html__( 'New Map Option Name', 'gp-theme' ),
                'menu_name'         => esc_html__( 'Size', 'gp-theme' ),
            );
            $args = array(
                'labels' => $labels,
                'hierarchical' => false,
                'public' => true,
                'show_ui' => true,
                'show_admin_column' => true,
                'show_in_nav_menus' => true,
                'show_tagcloud' => true,
                'show_in_rest'       => true, // To use Gutenberg editor.
                // 'template_lock' => 'all', // To use Gutenberg editor.
                'rewrite' => array(
                    'slug' => 'map-tag',
                    'with_front' => true,
                    'hierarchical' => false
                ),
            );
            register_taxonomy( 'n3_map_categories_3', array( 'n3_maps' ), $args );
        }

        // ___n3_map_categories_4
        public function ___n3_map_categories_4 () {
            $labels = array(
                'name'              => esc_html__( 'Type', 'gp-theme' ),
                'singular_name'     => esc_html__( 'Map Option', 'gp-theme' ),
                'search_items'      => esc_html__( 'Search Option', 'gp-theme' ),
                'all_items'         => esc_html__( 'All Option', 'gp-theme' ),
                'parent_item'       => esc_html__( 'Parent Map Option', 'gp-theme' ),
                'parent_item_colon' => esc_html__( 'Parent Map Option:', 'gp-theme' ),
                'edit_item'         => esc_html__( 'Edit Map Option', 'gp-theme' ),
                'update_item'       => esc_html__( 'Update Map Option', 'gp-theme' ),
                'add_new_item'      => esc_html__( 'Add New Map Option', 'gp-theme' ),
                'new_item_name'     => esc_html__( 'New Map Option Name', 'gp-theme' ),
                'menu_name'         => esc_html__( 'Type', 'gp-theme' ),
            );
            $args = array(
                'labels' => $labels,
                'hierarchical' => false,
                'public' => true,
                'show_ui' => true,
                'show_admin_column' => true,
                'show_in_nav_menus' => true,
                'show_tagcloud' => true,
                'show_in_rest'       => true, // To use Gutenberg editor.
                // 'template_lock' => 'all', // To use Gutenberg editor.
                'rewrite' => array(
                    'slug' => 'map-tag',
                    'with_front' => true,
                    'hierarchical' => false
                ),
            );
            register_taxonomy( 'n3_map_categories_4', array( 'n3_maps' ), $args );
        }

        public function ___n3_maps() {
            register_post_type('n3_maps', 
                array(	
                    'label' => 'N3 Maps',
                    'description' => 'Create a post of Maps',
                    'public' => true,
                    'show_ui' => true,
                    'menu_icon' => 'dashicons-location',
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
                        'slug' => 'maps',
                        'post_type' => 'n3_maps',
                        // 'with_front' => true,
                        // 'hierarchical' => true
                    ),
                    'query_var' => true,
                    'has_archive' => true,
                    // 'exclude_from_search' => true,
                    'menu_position' => 33,
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
                        'name' => 'N3 Maps',
                        'singular_name' => 'N3 Maps',
                        'menu_name' => 'N3 Maps',
                        'add_new' => 'Add Map',
                        'add_new_item' => 'Add New Map',
                        'new_item' => 'New Map',
                        'edit' => 'Edit',
                        'edit_item' => 'Edit Map',
                        'view' => 'View Map',
                        'view_item' => 'View Map',
                        'search_items' => 'Search Maps',
                        'not_found' => 'No Maps Found',
                        'not_found_in_trash' => 'No Maps Found in Trash',
                        'parent' => 'Parent Map'
                    ),
                    
                )
            );
        }

        // Hooking up our function to theme setup
        public function ___n3_maps_columns( $column, $post_id ) {
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
                        echo '<a href="'.admin_url( 'edit.php?post_type=n3_maps&sticky=no&post='.$post_id ).'"><span class="dashicons dashicons-star-filled"></span></a>';
                    } else {
                        echo '<a href="'.admin_url( 'edit.php?post_type=n3_maps&sticky=yes&post='.$post_id ).'"><span class="dashicons dashicons-star-empty"></span></a>';
                    }
                break;
                case 'map_category' :
                    $terms = get_the_terms( $post_id, 'n3_map_categories' );
                    if ( !empty( $terms ) ) {
                        $out = array();
                        foreach ( $terms as $term ) {
                            $out[] = sprintf( '<a href="%s">%s</a>',
                                esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'n3_map_categories' => $term->slug ), 'edit.php' ) ),
                                esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'n3_map_categories', 'display' ) )
                            );
                        }
                        echo join( ', ', $out );
                    } else {
                        _e( '-', 'gp-theme' );
                    }
                break;
                case 'map_category_2' :
                    // Display the tags
                    $terms = get_the_terms( $post_id, 'n3_map_categories_2' );
                    if ( !empty( $terms ) ) {
                        $out = array();
                        foreach ( $terms as $term ) {
                            $out[] = sprintf( '<a href="%s">%s</a>',
                                esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'n3_map_categories_2' => $term->slug ), 'edit.php' ) ),
                                esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'n3_map_categories_2', 'display' ) )
                            );
                        }
                        echo join( ', ', $out );
                    } else {
                        _e( '-', 'gp-theme' );
                    }
                break;
                case 'map_category_3' :
                    // Display the tags
                    $terms = get_the_terms( $post_id, 'n3_map_categories_3' );
                    if ( !empty( $terms ) ) {
                        $out = array();
                        foreach ( $terms as $term ) {
                            $out[] = sprintf( '<a href="%s">%s</a>',
                                esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'n3_map_categories_3' => $term->slug ), 'edit.php' ) ),
                                esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'n3_map_categories_3', 'display' ) )
                            );
                        }
                        echo join( ', ', $out );
                    } else {
                        _e( '-', 'gp-theme' );
                    }
                break;
                case 'map_category_4' :
                    // Display the tags
                    $terms = get_the_terms( $post_id, 'n3_map_categories_4' );
                    if ( !empty( $terms ) ) {
                        $out = array();
                        foreach ( $terms as $term ) {
                            $out[] = sprintf( '<a href="%s">%s</a>',
                                esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'n3_map_categories_4' => $term->slug ), 'edit.php' ) ),
                                esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'n3_map_categories_4', 'display' ) )
                            );
                        }
                        echo join( ', ', $out );
                    } else {
                        _e( '-', 'gp-theme' );
                    }
                break;
                case 'address_c' :
                    $db = get_fields($post_id);
                    echo $db['map']['address'];
                break;
            }


        }
        public function ___n3_maps_edit_columns( $columns ) {
        
            $columns = array(
                'cb' => '<input type="checkbox" />',
                'gpthumbnail' => '<span class="dashicons dashicons-format-image"></span>',
                'title' => __( 'Title' ),
                'address_c' => __( 'Address' ),
                'map_category' => __( 'State' ),
                'map_category_2' => __( 'City' ),
                'map_category_3' => __( 'Size' ),
                'map_category_4' => __( 'Type' ),
                'date' => __( 'Date' )
            );
        
            return $columns;
        }

    }
}

new GPC_Core_MAP();
