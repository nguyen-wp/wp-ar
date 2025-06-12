<?php 
if (!class_exists('GPC_Core_FAQ')) {
    class GPC_Core_FAQ {
        function __construct()  {
            add_action( 'init', array($this, '___n3_faqs_categories') );
            add_action( 'init', array($this, '___n3_faqs') );
            
            add_action( 'manage_n3_faqs_posts_custom_column',  array($this,'___n3_faqs_columns'), 10, 2 );
            add_filter( 'manage_edit-n3_faqs_columns',  array($this,'___n3_faqs_edit_columns') ) ;
            add_action( 'admin_bar_menu', array( $this, '___addToAdminBar' ), 100 );
            // add_action('admin_init', array($this, 'allow_user_roles'));

            add_filter('pre_get_posts', array($this, '___n3_faqs_pre_get_posts'));

            // Add Archive and Single Templates
            // add_filter( 'archive_template', array($this, '___n3_faqs_archive_template') ) ;
            // add_filter( 'single_template', array($this, '___n3_faqs_single_template') ) ;
            add_filter( 'after_setup_theme', array($this, '___n3_faqs_ats') ) ;

            // updateSticky
            add_action( 'init', array($this, 'updateSticky') );

             // Shortcode 
             add_shortcode( 'n3_faq', array($this, 'n3_faq_shortcode') );
             add_shortcode( 'n3_faq_group', array($this, 'n3_faq_shortcode_group') );
             add_action('admin_menu', array($this, '__addSubmenu'));
        }
        function ___n3_faqs_pre_get_posts( $query ) {
            if ( is_admin() && $query->is_main_query() && is_post_type_archive( 'n3_faqs' ) ) {
                $query->set('orderby', 'id');
                $query->set('order', 'DESC');
            }
        }

        public function __addSubmenu() {
            add_submenu_page(
                'edit.php?post_type=n3_faqs',
                'Short Code',
                'Short Code',
                'manage_options',
                'n3_faqs_settings',
                array($this, '___settingsPage'),
                // 0
            );
        }

        public function ___settingsPage() {
            require_once( plugin_dir_path( __FILE__ ) . 'setting.php' );
        }

        function ___n3_faqs_ats() {
            add_theme_support( 'block-template-parts' );
        }

        public function ___n3_faqs_archive_template() {
            if ( is_post_type_archive ( 'n3_faqs' ) ) {
                $theme_files = array('archive.php');
                $exists_in_theme = locate_template($theme_files, false);
                if($exists_in_theme == '') {
                    return plugin_dir_path( __FILE__ ) . 'archive.php';
                }
            }
            return $archive_template;
        }

        public function ___n3_faqs_single_template( $single_template ) {
            if ( get_post_type() == 'n3_faqs' ) {
                $theme_files = array('single.php');
                $exists_in_theme = locate_template($theme_files, false);
                if($exists_in_theme == '') {
                    return plugin_dir_path( __FILE__ ) . 'single.php';
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
                'id'    => 'gp-faqs',
                'title' => esc_html__( 'N3 FAQs', 'gp-theme' ),
                'parent' => 'made_theme_options',
                'href'  => admin_url( 'edit.php?post_type=n3_faqs' ),
            ));
            // $wp_admin_bar->add_menu( array(
            //     'id'    => 'gp-reusable-faqs',
            //     'title' => esc_html__( 'GP Reusable blocks', 'gp-theme' ),
            //     'parent' => 'made_theme_options',
            //     'href'  => admin_url( 'edit.php?post_type=wp_block' ),
            // ));
        }

        public function updateSticky() {
            if ( isset( $_GET['sticky'] ) && $_GET['post_type'] == 'n3_faqs' ) {
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

        public function ___n3_faqs_categories () {
            $labels = array(
                'name'              => esc_html__( 'Categories', 'gp-theme' ),
                'singular_name'     => esc_html__( 'FAQ Category', 'gp-theme' ),
                'search_items'      => esc_html__( 'Search Categories', 'gp-theme' ),
                'all_items'         => esc_html__( 'All Categories', 'gp-theme' ),
                'parent_item'       => esc_html__( 'Parent FAQ Category', 'gp-theme' ),
                'parent_item_colon' => esc_html__( 'Parent FAQ Category:', 'gp-theme' ),
                'edit_item'         => esc_html__( 'Edit FAQ Category', 'gp-theme' ),
                'update_item'       => esc_html__( 'Update FAQ Category', 'gp-theme' ),
                'add_new_item'      => esc_html__( 'Add New FAQ Category', 'gp-theme' ),
                'new_item_name'     => esc_html__( 'New FAQ Category Name', 'gp-theme' ),
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
                    'slug' => 'faqs-category',
                    'with_front' => true,
                    'hierarchical' => true
                ),
            );
            register_taxonomy( 'n3_faqs_categories', array( 'n3_faqs' ), $args );
        }

        public function ___n3_faqs() {
            register_post_type('n3_faqs', 
                array(	
                    'label' => 'N3 FAQs',
                    'description' => 'Create a post of FAQs',
                    'public' => false, // it's not public, it shouldn't have it's own permalink
                    'show_ui' => true,
                    'menu_icon' => 'dashicons-editor-help',
                    'show_in_menu' => true,
                    'show_in_rest'       => true, // To use Gutenberg editor.
                    // 'template_lock' => 'all', // To use Gutenberg editor.
                    // 'template' => array(
                    //     array( 'core/columns', array(), array(
                    //         array( 'core/column', array(), array(
                    //             array( 'core/image', array() ),
                    //         ) ),
                    //         array( 'core/column', array(), array(
                    //             array( 'core/paragraph', array(
                    //                 'placeholder' => 'Add a inner paragraph'
                    //             ) ),
                    //         ) ),
                    //     ) )
                    // ),
                    'capability_type' => 'post',
                    'hierarchical' => true,
                    'rewrite' => array(
                        'slug' => 'faq-detail',
                        'post_type' => 'n3_faqs',
                        // 'with_front' => true,
                        // 'hierarchical' => true
                    ),
                    'query_var' => true,
                    'has_archive' => true,
                    // 'exclude_from_search' => true,
                    'menu_position' => 32,
                    'supports' => array(
                        'title',
                        'editor',
                        'custom-fields',
                        'revisions',
                        'author',
                        // 'thumbnail',
                        // Sticky posts.
                        'sticky',
                    ),
                    // Order by post ID
                    'orderby' => 'id',
                    // Order by post ID
                    'order' => 'desc',
                    'labels' => array (
                        'name' => 'N3 FAQs',
                        'singular_name' => 'N3 FAQs',
                        'menu_name' => 'N3 FAQs',
                        'add_new' => 'Add FAQ',
                        'add_new_item' => 'Add New FAQ',
                        'new_item' => 'New FAQ',
                        'edit' => 'Edit',
                        'edit_item' => 'Edit FAQ',
                        'view' => 'View FAQ',
                        'view_item' => 'View FAQ',
                        'search_items' => 'Search FAQs',
                        'not_found' => 'No FAQs Found',
                        'not_found_in_trash' => 'No FAQs Found in Trash',
                        'parent' => 'Parent FAQ'
                    ),
                    
                )
            );
        }

        // Hooking up our function to theme setup
        public function ___n3_faqs_columns( $column, $post_id ) {
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
                        echo '<a href="'.admin_url( 'edit.php?post_type=n3_faqs&sticky=no&post='.$post_id ).'"><span class="dashicons dashicons-star-filled"></span></a>';
                    } else {
                        echo '<a href="'.admin_url( 'edit.php?post_type=n3_faqs&sticky=yes&post='.$post_id ).'"><span class="dashicons dashicons-star-empty"></span></a>';
                    }
                break;
                case 'faqs_category' :
                    $terms = get_the_terms( $post_id, 'n3_faqs_categories' );
                    if ( !empty( $terms ) ) {
                        $out = array();
                        foreach ( $terms as $term ) {
                            $out[] = sprintf( '<a href="%s">%s</a>',
                                esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'n3_faqs_categories' => $term->slug ), 'edit.php' ) ),
                                esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'n3_faqs_categories', 'display' ) )
                            );
                        }
                        echo join( ', ', $out );
                    } else {
                        _e( '-', 'gp-theme' );
                    }
                break;
            }


        }
        public function ___n3_faqs_edit_columns( $columns ) {
        
            $columns = array(
                'cb' => '<input type="checkbox" />',
                // 'gpthumbnail' => '<span class="dashicons dashicons-format-image"></span>',
                'title' => __( 'Title' ),
                'faqs_category' => __( 'FAQ Category' ),
                'author' => __( 'Author' ),
                'sticky' => __( 'Sticky' ),
                'date' => __( 'Date' )
            );
        
            return $columns;
        }

        // Shortcode
        public function n3_faq_shortcode( $atts ) {
            $atts = shortcode_atts( array(
                'id' => '',
            ), $atts, 'n3_faq' );
            ob_start();
            $post_id = $atts['id'];
            $post = get_post( $post_id );
            if ( $post ) {
                ?>
                <div class="n3-faqs-single">
                    <h2 class="faq_title"><?php echo $post->post_title; ?></h2>
                    <!-- Display Advanced Custom Fields -->
                    <?php if ( function_exists('get_field') ) : ?>
                        <div class="faq_meta">
                            <h3>Faq Details</h3>
                            <ul>
                                <li><strong>Faq Type:</strong> <?php echo get_field('faq_type', $post_id); ?></li>
                                <li><strong>Position:</strong> <?php echo get_field('position', $post_id); ?></li>
                                <li><strong>City:</strong> <?php echo get_field('city', $post_id); ?></li>
                                <li><strong>State:</strong> <?php 
                                $state_arr = get_field('state', $post_id);
                                if ( !empty($state_arr) ) {
                                    $state = '';
                                    foreach ($state_arr as $key => $value) {
                                        $state .= $value['label'] . ', ';
                                    }
                                    echo rtrim($state, ', ');
                                }
                                ?></li>
                                <li><strong>Country:</strong> <?php echo get_field('country', $post_id); ?></li>
                                <li><strong>Create Date:</strong> <?php echo get_field('create_date', $post_id); ?></li>
                                <li><strong>Expire Date:</strong> <?php echo get_field('expire_date', $post_id); ?></li>
                            </ul>
                            <?php if ( get_field('file', $post_id) ) : 
                                $file_name = get_field('file', $post_id)["filename"];
                                $file_url = get_field('file', $post_id)["url"];
                                ?>
                                <div class="dl">
                                    <strong>Download:</strong> <a href="<?php echo $file_url; ?>" target="_blank" class="btn btn-primary"><?php echo $file_name; ?></a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <div class="faq_content">
                        <?php echo apply_filters('the_content', $post->post_content); ?>
                    </div>
                </div>
                <?php   
            }
            return ob_get_clean();
        }

        public function n3_faq_shortcode_group( $atts ) {
            $atts = shortcode_atts( array(
                'id' => null,
                'layout' => null,
                'limit' => null,
                'class' => null,
                'active_first' => null,
            ), $atts, 'n3_faq_group' );
            ob_start();
            $category_id = $atts['id'];
            $layout = $atts['layout'] ? $atts['layout'] : get_term_meta($category_id, 'n3_faq_layout', true) ?? 'accordion';
            $limit = $atts['limit'] ? $atts['limit'] : get_term_meta($category_id, 'n3_faq_limit', true) ?? 100;
            $class = $atts['class'] ? preg_replace('/{{(.*?)}}/', '[$1]', $atts['class']) : get_term_meta($category_id, 'n3_faq_class', true) ?? '';
            $active_first = $atts['active_first'] ? $atts['active_first'] : get_term_meta($category_id, 'n3_faq_active_first', true) ?? 'no';
            $args = array(
                'post_type' => 'n3_faqs',
                'posts_per_page' => $limit,
            );

            if ( $category_id ) {
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => 'n3_faqs_categories',
                        'field' => 'term_id',
                        'terms' => $category_id,
                    )
                );
            }

            $query = new WP_Query( $args );
            if ( $query->have_posts() ) {
                (new GPC_Core_FAQ)->___madelab_faqs_generate($query, $layout, $limit, $class, $active_first);
            }

            wp_reset_postdata();
            return ob_get_clean();
        }

        public function ___madelab_faqs_generate($query, $layout, $limit, $class, $active_first) {
            
            return include( dirname( __FILE__ ) . '/init.php' );

        }

    }
}

new GPC_Core_FAQ();
