<?php 
if (!class_exists('GPC_Core_SERVICE')) {
    class GPC_Core_SERVICE {
        function __construct()  {
            add_action( 'init', array($this, '___n3_service_categories') );
            add_action( 'init', array($this, '___n3_services') );
            
            add_action( 'manage_n3_services_posts_custom_column',  array($this,'___n3_services_columns'), 10, 2 );
            add_filter( 'manage_edit-n3_services_columns',  array($this,'___n3_services_edit_columns') ) ;
            add_action( 'admin_bar_menu', array( $this, '___addToAdminBar' ), 100 );
            // add_action('admin_init', array($this, 'allow_user_roles'));

            add_filter('pre_get_posts', array($this, '___n3_services_pre_get_posts'));

            // Add Archive and Single Templates
            add_filter( 'archive_template', array($this, '___n3_services_archive_template') ) ;
            add_filter( 'single_template', array($this, '___n3_services_single_template') ) ;
            add_filter( 'after_setup_theme', array($this, '___n3_services_ats') ) ;

            // updateSticky
            add_action( 'init', array($this, 'updateSticky') );
            add_action('admin_menu', array($this, '__addSubmenu'));

        }
        function ___n3_services_pre_get_posts( $query ) {
            if ( is_admin() && $query->is_main_query() && is_post_type_archive( 'n3_services' ) ) {
                $query->set('orderby', 'id');
                $query->set('order', 'DESC');
            }
        }

        public function __addSubmenu() {
            add_submenu_page(
                'edit.php?post_type=n3_services',
                'Settings',
                'Settings',
                'manage_options',
                'n3_services_settings',
                array($this, '___settingsPage'),
                // 0
            );

        }

        public function ___settingsPage() {
            require_once( plugin_dir_path( __FILE__ ) . 'setting_global.php' );
        }

        function ___n3_services_ats() {
            add_theme_support( 'block-template-parts' );
        }

        public function ___n3_services_archive_template($archive_template) {
            $nguyen_service_archive_template = get_option('nguyen_service_archive_template');
            if ( $nguyen_service_archive_template === 'yes' ) {
                if ( is_post_type_archive ( 'n3_services' ) ) {
                    $theme_files = array('archive.php');
                    $exists_in_theme = locate_template($theme_files, false);
                    if($exists_in_theme == '') {
                        return plugin_dir_path( __FILE__ ) . 'archive.php';
                    }
                }
            }
            return $archive_template;
        }

        public function ___n3_services_single_template($single_template) {
            $nguyen_service_single_template = get_option('nguyen_service_single_template');
            if ( $nguyen_service_single_template === 'yes' ) {
                if ( get_post_type() == 'n3_services' ) {
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

        public function ___addToAdminBar() {
            global $wp_admin_bar;
            $wp_admin_bar->add_menu( array(
                'id'    => 'gp-services',
                'title' => esc_html__( 'RC Services', 'gp-theme' ),
                'parent' => 'made_theme_options',
                'href'  => admin_url( 'edit.php?post_type=n3_services' ),
            ));
            // $wp_admin_bar->add_menu( array(
            //     'id'    => 'gp-reusable-services',
            //     'title' => esc_html__( 'GP Reusable blocks', 'gp-theme' ),
            //     'parent' => 'made_theme_options',
            //     'href'  => admin_url( 'edit.php?post_type=wp_block' ),
            // ));
        }

        public function updateSticky() {
            if ( isset( $_GET['sticky'] ) && $_GET['post_type'] == 'n3_services' ) {
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

        public function ___n3_service_categories () {
            $labels = array(
                'name'              => esc_html__( 'Categories', 'gp-theme' ),
                'singular_name'     => esc_html__( 'Service Category', 'gp-theme' ),
                'search_items'      => esc_html__( 'Search Categories', 'gp-theme' ),
                'all_items'         => esc_html__( 'All Categories', 'gp-theme' ),
                'parent_item'       => esc_html__( 'Parent Service Category', 'gp-theme' ),
                'parent_item_colon' => esc_html__( 'Parent Service Category:', 'gp-theme' ),
                'edit_item'         => esc_html__( 'Edit Service Category', 'gp-theme' ),
                'update_item'       => esc_html__( 'Update Service Category', 'gp-theme' ),
                'add_new_item'      => esc_html__( 'Add New Service Category', 'gp-theme' ),
                'new_item_name'     => esc_html__( 'New Service Category Name', 'gp-theme' ),
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
                    'slug' => 'service-category',
                    'with_front' => true,
                    'hierarchical' => true
                ),
            );
            register_taxonomy( 'n3_service_categories', array( 'n3_services' ), $args );
        }

        public function ___n3_services() {
            register_post_type('n3_services', 
                array(	
                    'label' => 'RC Services',
                    'description' => 'Create a post of Services',
                    'public' => true,
                    'show_ui' => true,
                    'menu_icon' => 'dashicons-awards',
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
                        'slug' => 'services',
                        'post_type' => 'n3_services',
                        // 'with_front' => true,
                        // 'hierarchical' => true
                    ),
                    'query_var' => true,
                    'has_archive' => true,
                    // 'exclude_from_search' => true,
                    'menu_position' => 36,
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
                        'name' => 'RC Services',
                        'singular_name' => 'RC Services',
                        'menu_name' => 'RC Services',
                        'add_new' => 'Add Service',
                        'add_new_item' => 'Add New Service',
                        'new_item' => 'New Service',
                        'edit' => 'Edit',
                        'edit_item' => 'Edit Service',
                        'view' => 'View Service',
                        'view_item' => 'View Service',
                        'search_items' => 'Search Services',
                        'not_found' => 'No Services Found',
                        'not_found_in_trash' => 'No Services Found in Trash',
                        'parent' => 'Parent Service'
                    ),
                    
                )
            );
        }

        // Hooking up our function to theme setup
        public function ___n3_services_columns( $column, $post_id ) {
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
                        echo '<a href="'.admin_url( 'edit.php?post_type=n3_services&sticky=no&post='.$post_id ).'"><span class="dashicons dashicons-star-filled"></span></a>';
                    } else {
                        echo '<a href="'.admin_url( 'edit.php?post_type=n3_services&sticky=yes&post='.$post_id ).'"><span class="dashicons dashicons-star-empty"></span></a>';
                    }
                break;
                case 'service_category' :
                    $terms = get_the_terms( $post_id, 'n3_service_categories' );
                    if ( !empty( $terms ) ) {
                        $out = array();
                        foreach ( $terms as $term ) {
                            $out[] = sprintf( '<a href="%s">%s</a>',
                                esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'n3_service_categories' => $term->slug ), 'edit.php' ) ),
                                esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'n3_service_categories', 'display' ) )
                            );
                        }
                        echo join( ', ', $out );
                    } else {
                        _e( '-', 'gp-theme' );
                    }
                break;
            }


        }
        public function ___n3_services_edit_columns( $columns ) {
        
            $columns = array(
                'cb' => '<input type="checkbox" />',
                'gpthumbnail' => '<span class="dashicons dashicons-format-image"></span>',
                'title' => __( 'Title' ),
                'service_category' => __( 'Service Category' ),
                // 'author' => __( 'Author' ),
                // 'sticky' => __( 'Sticky' ),
                'date' => __( 'Date' )
            );
        
            return $columns;
        }

    }
}

new GPC_Core_SERVICE();
