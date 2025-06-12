<?php 
if (!class_exists('MADE_LabCore_Core_TESTIMONIAL')) {
    class MADE_LabCore_Core_TESTIMONIAL {
        function __construct()  {
            add_action( 'init', array($this, '___madelab_testimonial_categories') );
            add_action( 'init', array($this, '___madelab_testimonials') );
            
            add_action( 'manage_n3_testimonials_posts_custom_column',  array($this,'___madelab_testimonials_columns'), 10, 2 );
            add_filter( 'manage_edit-n3_testimonials_columns',  array($this,'___madelab_testimonials_edit_columns') ) ;
            add_shortcode('n3_testimonial',  array($this,'___madelab_testimonials_shortcode') );
            
            add_action( 'admin_bar_menu', array( $this, '___addToAdminBar' ), 100 );
            // add_action('admin_init', array($this, 'allow_user_roles'));
            add_action('admin_menu', array($this, '__addSubmenu'));
            add_filter('single_template', array($this, '___single_template'));
        }

        public function __addSubmenu() {
            add_submenu_page(
                'edit.php?post_type=n3_testimonials',
                'Short Code',
                'Short Code',
                'manage_options',
                'n3_testimonials_settings',
                array($this, '___settingsPage'),
                // 0
            );
        }

        public function ___settingsPage() {
            require_once( plugin_dir_path( __FILE__ ) . 'n3_testimonials_setting.php' );
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

        public function ___addToAdminBar() {
            global $wp_admin_bar;
            $wp_admin_bar->add_menu( array(
                'id'    => 'madelab-testimonials',
                'title' => esc_html__( 'RC Testimonials', 'made-theme-options' ),
                'parent' => 'made_theme_options',
                'href'  => admin_url( 'edit.php?post_type=n3_testimonials' ),
            ));
        }

        public function ___madelab_testimonial_categories () {
            $labels = array(
                'name'              => esc_html__( 'Categories', 'made-theme-options' ),
                'singular_name'     => esc_html__( 'Testimonial Category', 'made-theme-options' ),
                'search_items'      => esc_html__( 'Search Categories', 'made-theme-options' ),
                'all_items'         => esc_html__( 'All Categories', 'made-theme-options' ),
                'parent_item'       => esc_html__( 'Parent Testimonial Category', 'made-theme-options' ),
                'parent_item_colon' => esc_html__( 'Parent Testimonial Category:', 'made-theme-options' ),
                'edit_item'         => esc_html__( 'Edit Testimonial Category', 'made-theme-options' ),
                'update_item'       => esc_html__( 'Update Testimonial Category', 'made-theme-options' ),
                'add_new_item'      => esc_html__( 'Add New Testimonial Category', 'made-theme-options' ),
                'new_item_name'     => esc_html__( 'New Testimonial Category Name', 'made-theme-options' ),
                'menu_name'         => esc_html__( 'Categories', 'made-theme-options' ),
            );
            $args = array(
                'labels' => $labels,
                'hierarchical' => true,
                'public' => true,
                'show_ui' => true,
                'show_admin_column' => true,
                'show_in_nav_menus' => true,
                'show_tagcloud' => true,
                'show_in_rest' => true,
            );
            register_taxonomy( 'n3_testimonial_categories', array( 'n3_testimonials' ), $args );
        }


        public function ___madelab_testimonials() {
            register_post_type('n3_testimonials', 
                array(	
                    'label' => 'RC Testimonials',
                    'description' => 'Create a post of Testimonials',
                    'public' => false, // it's not public, it shouldn't have it's own permalink
                    'show_ui' => true,
                    'menu_icon' => 'dashicons-format-chat',
                    'show_in_menu' => true,
                    'capability_type' => 'post',
                    'hierarchical' => true,
                    'show_in_rest' => true,
                    'rewrite' => array(
                        'slug' => 'testimonials',
                        'post_type' => 'n3_testimonials',
                    ),
                    'taxonomies' => array(
                        'testimonial_category'
                    ),
                    'query_var' => true,
                    'has_archive' => true,
                    'exclude_from_search' => true,
                    'menu_position' => 38,
                    // Support Block Editor
                    'supports' => array(
                        'title',
                        'editor',
                        'custom-fields',
                        'revisions',
                        'author'
                        ),
                    'labels' => array (
                        'name' => 'RC Testimonials',
                        'singular_name' => 'Testimonials',
                        'menu_name' => 'RC Testimonials',
                        'add_new' => 'Add Testimonial',
                        'add_new_item' => 'Add New Testimonial',
                        'new_item' => 'New Testimonial',
                        'edit' => 'Edit',
                        'edit_item' => 'Edit Testimonial',
                        'view' => 'View Testimonial',
                        'view_item' => 'View Testimonial',
                        'search_items' => 'Search Testimonials',
                        'not_found' => 'No Testimonials Found',
                        'not_found_in_trash' => 'No Testimonials Found in Trash',
                        'parent' => 'Parent Testimonial'
                    ),
                    
                )
            );
        }

        public function ___single_template($single_template) {
            global $post;
            if ($post->post_type == 'n3_testimonials') {
                $single_template = dirname( __FILE__ ) . '/single-n3_testimonials.php';
            }
            return $single_template;
        }

        // Hooking up our function to theme setup
        public function ___madelab_testimonials_columns( $column, $post_id ) {
            global $post;
            $post_data = get_post($post_id, ARRAY_A);
        
            switch( $column ) {
                case 'testimonial_category' :
                    $terms = get_the_terms( $post_id, 'n3_testimonial_categories' );
                    if ( !empty( $terms ) ) {
                        $out = array();
                        foreach ( $terms as $term ) {
                            $out[] = sprintf( '<a href="%s">%s</a>',
                                esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'n3_testimonial_categories' => $term->slug ), 'edit.php' ) ),
                                esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'n3_testimonial_categories', 'display' ) )
                            );
                        }
                        echo join( ', ', $out );
                    } else {
                        _e( 'No Categories', 'made-theme-options' );
                    }
                break;
                case 'short_description' :
                    echo wp_trim_words( $post_data['post_content'], 20, '...' );
                break;
            }
        }
        public function ___madelab_testimonials_edit_columns( $columns ) {
        
            $columns = array(
                'cb' => '<input type="checkbox" />',
                'title' => __( 'Title' ),
                'short_description' => __( 'Short Description' ),
                'testimonial_category' => __( 'Testimonial Category' ),
                'author' => __( 'Author' ),
                'date' => __( 'Date' )
            );
        
            return $columns;
        }

        public function ___madelab_testimonials_shortcode($atts) {	
            // [n3_testimonial id="3" layout="default" limit="10" speed="5000" autoplay="false" infinite="false" arrows="true" dots="true" autoheight="false"]
            $atts = shortcode_atts( array(
                'id' => null,
                'layout' => null,
                'limit' => null,
                'speed' => null,
                'autoplay' => null,
                'infinite' => null,
                'arrows' => null,
                'dots' => null,
                'autoheight' => null,
            ), $atts, 'n3_testimonial' );
            ob_start();
            $id = $atts['id'];
            $layout = $atts['layout'] ? $atts['layout'] : get_term_meta($id, 'n3_testimonial_layout', true) ?? 'default';
            $limit = $atts['limit'] ? $atts['limit'] : get_term_meta($id, 'n3_testimonial_limit', true) ?? 10;
            $speed = $atts['speed'] ? $atts['speed'] : get_term_meta($id, 'n3_testimonial_speed', true) ?? 5000;
            $autoplay = $atts['autoplay'] ? $atts['autoplay'] : get_term_meta($id, 'n3_testimonial_autoplay', true) ?? 'false';
            $infinite = $atts['infinite'] ? $atts['infinite'] : get_term_meta($id, 'n3_testimonial_infinite', true) ?? 'false';
            $arrows = $atts['arrows'] ? $atts['arrows'] : get_term_meta($id, 'n3_testimonial_arrows', true) ?? 'true';
            $dots = $atts['dots'] ? $atts['dots'] : get_term_meta($id, 'n3_testimonial_dots', true) ?? 'true';
            $autoheight = $atts['autoheight'] ? $atts['autoheight'] : get_term_meta($id, 'n3_testimonial_autoheight', true) ?? 'false';

            $args = array(
                'post_type' => 'n3_testimonials',
                'posts_per_page' => $limit,
                'orderby' => 'date',
                'order' => 'DESC',
                'post_status' => 'publish',
            );

            if ($id) {
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => 'n3_testimonial_categories',
                        'field' => 'term_id',
                        'terms' => $id,
                    )
                );
            }

            $query = new WP_Query($args);

            if ($query->have_posts()) {
                (new MADE_LabCore_Core_TESTIMONIAL)->___madelab_testimonials_generate($query, $id, $layout, $speed, $autoplay, $infinite, $arrows, $dots, $autoheight);
            }

            wp_reset_postdata();
            return ob_get_clean();
        }

        public function ___madelab_testimonials_generate($query, $id, $layout, $speed, $autoplay, $infinite, $arrows, $dots, $autoheight) {
            
            return include( dirname( __FILE__ ) . '/n3_testimonials.php' );

        }

        
    }
}

new MADE_LabCore_Core_TESTIMONIAL();

