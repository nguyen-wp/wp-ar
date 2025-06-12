<?php 
if (!class_exists('MADE_LabCore_Core_Init')) {
    class MADE_LabCore_Core_Init {
        function __construct()  {
            // Add actions to init.
            add_action('init', array($this, 'init'));
            // add_action('admin_init', array($this, 'allow_user_roles'));
            // WooECommerce
            add_action( 'admin_init', array($this,'enable_instructor_to_create_coupons'));
            add_filter( 'screen_layout_columns',  array($this,'madelab_dashboard_single_column'), 10, 2 );
            add_action( 'wp_dashboard_setup',  array($this,'madelab_add_dashboard_widgets'));
            add_filter( 'get_user_option_screen_layout_dashboard',  array($this,'madelab_dashboard_single_dashboard'));
            // Add Shortcode
            add_shortcode( 'made_add_to_calendar', array($this,'madelab_shortcode_made_add_to_calendar'));
            add_shortcode( 'gp_tagline', array($this,'madelab_shortcode_gptagline'));
            add_shortcode( 'gp_title', array($this,'madelab_shortcode_gptitle'));
            add_shortcode( 'gp_icon', array($this,'madelab_shortcode_gpicon'));
            add_shortcode( 'gp_job', array($this,'madelab_shortcode_gpjob'));

        }

        public function madelab_shortcode_gpjob( $atts) {
            extract( shortcode_atts( array(
                'title'  => null,
            ), $atts ) );
            $file = get_field('job');
            $title = isset($title) ? $title : null;
            $output = '';
            if ($file) {
                $output .= '<div class="wp-block-button is-style-outline button-gp">';
                if (isset($title) && $title !== '') {
                $output .= '<a class="wp-block-button__link wp-element-button" href="'.$file.'" target="_blank">'.$title.'</a>';
                } else {
                    $output .= '<a class="wp-block-button__link wp-element-button" href="'.$file.'" target="_blank">Download</a>';
                }
                $output .='</div>';
            }
            return $output;
        }

        public function madelab_shortcode_gpicon( $atts) {
            extract( shortcode_atts( array(
                'size'  => null,
            ), $atts ) );
            $output = get_field('icon');
            if (isset($size) && $size !== '') {
                $output = '<img src="'.$output.'" alt="icon" width="'.$size.'" height="'.$size.'" />';
            } else {
                $output = '<img src="'.$output.'" alt="icon" />';
            }
            return $output;
        }

        public function madelab_shortcode_gptitle( $atts) {
            extract( shortcode_atts( array(

            ), $atts ) );
            $output = get_the_title();
            return $output;
        }
        public function madelab_shortcode_gptagline( $atts) {
            extract( shortcode_atts( array(

            ), $atts ) );
            $output = get_field('tagline');
            return $output;
        }


        function init() {
            // WooECommerce
            global $wp_roles;

            // https://github.com/woocommerce/woocommerce/blob/ee01d4219282387c2975ef4594677453c1dd7a0e/includes/class-wc-install.php#L1052
            $wp_roles->add_cap( 'editor', 'view_woocommerce_reports' );

            $wp_roles->remove_cap( 'editor', 'manage_woocommerce' );
            $wp_roles->remove_cap( 'editor', 'publish_pages' );
            $wp_roles->remove_cap( 'editor', 'read_private_pages' );
            $wp_roles->remove_cap( 'editor', 'edit_pages' );
            $wp_roles->remove_cap( 'editor', 'edit_private_pages' );
            $wp_roles->remove_cap( 'editor', 'edit_published_pages' );
            $wp_roles->remove_cap( 'editor', 'edit_others_pages' );
            $wp_roles->remove_cap( 'editor', 'delete_pages' );
            $wp_roles->remove_cap( 'editor', 'delete_private_pages' );
            $wp_roles->remove_cap( 'editor', 'delete_published_pages' );
            $wp_roles->remove_cap( 'editor', 'delete_others_pages' );
            $wp_roles->remove_cap( 'editor', 'export' );

            // $wp_roles->remove_cap( 'editor', 'edit_product' );
            // $wp_roles->remove_cap( 'editor', 'read_product' );
            // $wp_roles->remove_cap( 'editor', 'delete_product' );
            // $wp_roles->remove_cap( 'editor', 'edit_products' );
            // $wp_roles->remove_cap( 'editor', 'edit_others_products' );
            // $wp_roles->remove_cap( 'editor', 'edit_published_products' );
            // $wp_roles->remove_cap( 'editor', 'delete_products' );
            // $wp_roles->remove_cap( 'editor', 'delete_private_products' );
            // $wp_roles->remove_cap( 'editor', 'delete_published_products' );
            // $wp_roles->remove_cap( 'editor', 'delete_others_products' );
            // $wp_roles->remove_cap( 'editor', 'edit_product_terms' );
            // $wp_roles->remove_cap( 'editor', 'edit_product_categories' );
            // $wp_roles->remove_cap( 'editor', 'edit_product_tags' );
            // $wp_roles->remove_cap( 'editor', 'edit_product_link' );
            // $wp_roles->remove_cap( 'editor', 'delete_product_terms' );
            // $wp_roles->remove_cap( 'editor', 'delete_product_categories' );
            // $wp_roles->remove_cap( 'editor', 'delete_product_tags' );
            // $wp_roles->remove_cap( 'editor', 'delete_product_link' );
            // $wp_roles->remove_cap( 'editor', 'manage_product_terms' );
            // $wp_roles->remove_cap( 'editor', 'manage_product_categories' );
            // $wp_roles->remove_cap( 'editor', 'manage_product_tags' );
            // $wp_roles->remove_cap( 'editor', 'manage_product_link' );


        }

        function enable_instructor_to_create_coupons(){
            // WooECommerce
            $role = get_role( 'editor' );
            $capabilities = $this->made_get_woocommerce_core_capabilities();
                foreach ( $capabilities as $cap_group ) {
                    foreach ( $cap_group as $cap ) {
                        $role->add_cap( $cap );
                    }
                }
        }
        function made_get_woocommerce_core_capabilities() {
            // WooECommerce
            $capabilities = array();
            // $capability_types = array('product', 'shop_order', 'shop_coupon');
            $capability_types = array('shop_coupon');

            foreach ( $capability_types as $capability_type ) {
                $capabilities[ $capability_type ] = array(
                    // Post type
                    "edit_{$capability_type}",
                    "read_{$capability_type}",
                    "delete_{$capability_type}",
                    "edit_{$capability_type}s",
                    "publish_{$capability_type}s",
                    "read_private_{$capability_type}s",
                    "delete_{$capability_type}s",
                    "delete_private_{$capability_type}s",
                    "delete_published_{$capability_type}s",
                    "edit_private_{$capability_type}s",
                    "edit_published_{$capability_type}s",
                );
            }
            return $capabilities;
        }

        public function madelab_shortcode_made_add_to_calendar( $atts) {
            extract( shortcode_atts( array(
                'title_1' => isset($atts['title_1']) ? $atts['title_1'] : null,
                'title_2' => isset($atts['title_2']) ? $atts['title_1'] : null,
                'title_3' => isset($atts['title_3']) ? $atts['title_1'] : null,
                'description_1' => isset($atts['description_1']) ? $atts['description_1'] : null,
                'description_2' => isset($atts['description_2']) ? $atts['description_1'] : null,
                'description_3' => isset($atts['description_3']) ? $atts['description_1'] : null,
                'location_1' => isset($atts['location_1']) ? $atts['location_1'] : null,
                'location_2' => isset($atts['location_2']) ? $atts['location_1'] : null,
                'location_3' => isset($atts['location_3']) ? $atts['location_1'] : null,
                'date_1' => isset($atts['date_1']) ? $atts['date_1'] : null,
                'date_2' => isset($atts['date_2']) ? $atts['date_2'] : null,
                'date_3' => isset($atts['date_3']) ? $atts['date_3'] : null,
                'time_start_1' => isset($atts['time_start_1']) ? $atts['time_start_1'] : null,
                'time_start_2' => isset($atts['time_start_2']) ? $atts['time_start_1'] : null,
                'time_start_3' => isset($atts['time_start_3']) ? $atts['time_start_1'] : null,
                'time_end_1' => isset($atts['time_end_1']) ? $atts['time_end_1'] : null,
                'time_end_2' => isset($atts['time_end_2']) ? $atts['time_end_1'] : null,
                'time_end_3' => isset($atts['time_end_3']) ? $atts['time_end_1'] : null,
                'url' => isset($atts['url']) ? $atts['url'] : null,
                'label' => isset($atts['label']) ? $atts['label'] : 'Add to Calendar',
            ), $atts ) );

            // $description = ''; 
            // if (isset($description_1) && $description_1 != '') {
            //     $description .= $description_1;
            // }

            // if( isset($atts['url'])) {
            //     $desc = $description . PHP_EOL . '→ [url]' . $url . '[/url]';
            // } else {
            //     $desc = $description;
            // }
            // get Timezone by IP

            $buildData = array();
            if (isset($date_1) && $date_1 != '') {
                array_push($buildData, [
                    "name" => $title_1,
                    "description" => $description_1 .'<br>'. $location_1 . (isset($url) ? '<br>[url]'.$url.'[/url]' : ''),
                    "location" => $location_1,
                    "startDate" => $date_1,
                    "startTime" => $time_start_1,
                    "endTime" => $time_end_1
                ]);
            }
            if (isset($date_2) && $date_2 != '') {
                array_push($buildData, [
                    "name" => $title_2,
                    "description" => $description_2  .'<br>'. $location_2 . (isset($url) ? '<br>[url]'.$url.'[/url]' : ''),
                    "location" => $location_2,
                    "startDate" => $date_2,
                    "startTime" => $time_start_2,
                    "endTime" => $time_end_2
                ]);
            }
            if (isset($date_3) && $date_3 != '') {
                array_push($buildData, [
                    "name" => $title_3,
                    "description" => $description_3 .'<br>'. $location_3 . (isset($url) ? '<br>[url]'.$url.'[/url]' : ''),
                    "location" => $location_3,
                    "startDate" => $date_3,
                    "startTime" => $time_start_3,
                    "endTime" => $time_end_3
                ]);
            }
            $json = json_encode($buildData);

            $output = '';
            $output .= '<div class="made-add-to-calendar">';
            $output .= '<div class="atcb" style="display:none;">
            {
                "name": "' . $title_1 . '",
                "dates": ' . $json . ',
                "label": "' . $label . '",
                "options":[
                    "Google",
                    "Apple",
                    "Outlook.com",
                    "Microsoft365",
                    "MicrosoftTeams",
                    "iCal",
                    "Yahoo"
                ],
                "iCalFileName": "' . $label . '",
                "inline": true,
                "trigger": "click"
            }
            </div>';
            $output .= '</div>';

            return $output;

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
            wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'made-theme-options' ) );
        }

        public function madelab_add_dashboard_widgets() {
            global $made_theme;
			if($made_theme['made-theme-dashboard-widgets-enable'] == '1') {
                wp_add_dashboard_widget( 'dashboard_widget', 'Restore Construction Widget', array( $this, 'madelab_dashboard_widget_function' ) );
            } else {
                wp_add_dashboard_widget( 'dashboard_widget_basic', 'Restore Construction Widget', array( $this, 'madelab_dashboard_widget_function_basic' ), 'normal', 'high' );
            }
        }

        public function madelab_dashboard_widget_function_basic( $post, $callback_args ) {
            require_once( N3COMMERCIALREALTY_CORE_PATH . '/classes/dashboard-basic-widget.php' );
        }
        
        public function madelab_dashboard_widget_function( $post, $callback_args ) {
            require_once( N3COMMERCIALREALTY_CORE_PATH . '/classes/dashboard-widget.php' );
        }

        public  function madelab_dashboard_single_column( $columns ) {
            global $made_theme;
			if($made_theme['made-theme-dashboard-widgets-enable'] == '1') {
                $columns['dashboard'] = 1;
                return $columns;
            }
        }

        function madelab_dashboard_single_dashboard(){
            return 1;
        }
        
    }
}

new MADE_LabCore_Core_Init();