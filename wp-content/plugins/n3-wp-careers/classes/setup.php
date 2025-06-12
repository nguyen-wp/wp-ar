<?php 
if (!class_exists('GPC_Core_CAREER')) {
    class GPC_Core_CAREER {
        function __construct()  {
            add_action( 'init', array($this, '___n3_career_categories') );
            add_action( 'init', array($this, '___n3_careers') );
            
            add_action( 'manage_n3_careers_posts_custom_column',  array($this,'___n3_careers_columns'), 10, 2 );
            add_filter( 'manage_edit-n3_careers_columns',  array($this,'___n3_careers_edit_columns') ) ;
            add_action( 'admin_bar_menu', array( $this, '___addToAdminBar' ), 100 );
            // add_action('admin_init', array($this, 'allow_user_roles'));

            add_filter('pre_get_posts', array($this, '___n3_careers_pre_get_posts'));

            // Add Archive and Single Templates
            add_filter( 'archive_template', array($this, '___n3_careers_archive_template') ) ;
            add_filter( 'single_template', array($this, '___n3_careers_single_template') ) ;
            add_filter( 'after_setup_theme', array($this, '___n3_careers_ats') ) ;

            // updateSticky
            add_action( 'init', array($this, 'updateSticky') );

            // Shortcode 
            add_shortcode( 'n3_career', array($this, 'n3_career_shortcode') );
            add_shortcode( 'n3_career_group', array($this, 'n3_career_shortcode_group') );
            add_shortcode('n3_career_field', array($this, '_buildShortcode'));
            add_action('admin_menu', array($this, '__addSubmenu'));

            // ACF 
            add_action('acf/init', array($this, 'register_acf_block'));

        }

        public function register_acf_block() {
            if( function_exists('acf_register_block_type') ) {
                $arr = array(
                    array(
                        'key' => 'type',
                        'title' => 'Carrer Type',
                    ),
                    array(
                        'key' => 'position',
                        'title' => 'Carrer Position',
                    ),
                    array(
                        'key' => 'city',
                        'title' => 'Carrer City',
                    ),
                    array(
                        'key' => 'state',
                        'title' => 'Carrer State',
                    ),
                    array(
                        'key' => 'create_date',
                        'title' => 'Carrer Create Date',
                    ),
                    array(
                        'key' => 'expire_date',
                        'title' => 'Carrer Expire Date',
                    ),
                    array(
                        'key' => 'country',
                        'title' => 'Carrer Country',
                    ),
                    array(
                        'key' => 'file',
                        'title' => 'Carrer File',
                    ),
                );
                foreach ($arr as $key => $value) {
                    // https://developer.wordpress.org/block-editor/reference-guides/block-api/block-supports/
                    acf_register_block_type(array(
                        'name'              => 'career_' . $value['key'],
                        'title'             => $value['title'],
                        'key'               => $value['key'],
                        'description'       => __('A custom block to display the field (ACF field) inside the Query Loop block.'),
                        'render_callback'   => array($this, '__acf_function'),
                        'category'          => 'formatting',
                        'icon'              => 'feedback',
                        'keywords'          => array( 'career', 'acf', $value['key'] ),
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
            $field = get_field($key, get_the_ID()) ?? null;
            if ( $key == 'state' ) {
                $check_length = $this->displayArrayState($field);
            } else if ( $key == 'file' ) {
                if ( isset($field['filename']) ) {
                    $check_length = '<div class="wp-block-buttons is-layout-flex wp-block-buttons-is-layout-flex"> <div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="'.$field['url'].'" target="_blank">'.$field['title'].'</a></div> </div>';
                } else {
                    $check_length = is_admin() ? 'N/A' : '';
                }
            } else {
                $check_length = strlen($field) > 0 ? $field : (is_admin() ? 'N/A' : '');
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

        public function _buildShortcode( $atts ) {
            $atts = shortcode_atts( array(
                'field' => '',
            ), $atts, 'n3_career_field' );
            ob_start();
            $field = $atts['field'];

            // Get post ACF field
            $fields = get_fields(get_the_ID()) ?? null;
            if ( $field == 'file_name' ) {
                if ( !isset($fields['file']) ) {
                    return is_admin() ? 'N/A' : '';
                }
                echo $fields['file']['filename'] ?? '';
            } else if ( $field == 'file_url' ) {
                if ( !isset($fields['file']) ) {
                    return is_admin() ? 'N/A' : '';
                }
                echo $fields['file']['url'] ?? '';
            } else if ( $field == 'state' ) {
                $state_arr = $fields['state'];
                $getState = $this->displayArrayState($state_arr);
                echo $getState ?? '';
            } else if ( $field == 'rank_url' ) {
                if ( !isset($fields['url']) ) {
                    return is_admin() ? 'N/A' : '';
                }
                $rank_url = $fields['url']['url'] ?? '';
                echo $rank_url;
            } else if ( $field == 'rank_title' ) {
                if ( !isset($fields['url']) ) {
                    return is_admin() ? 'N/A' : '';
                }
                $rank_title = $fields['url']['title'] ?? '';
                echo $rank_title;
            } else if ( $field == 'rank_target' ) {
                if ( !isset($fields['url']) ) {
                    return is_admin() ? 'N/A' : '';
                }
                $rank_target = $fields['url']['target'] ?? '';
                echo $rank_target;
            } else {
                if ( !isset($fields[$field]) ) {
                    return is_admin() ? 'N/A' : '';
                }
                echo $fields[$field] ?? '';
            }
            return ob_get_clean();
        }

        public function ___n3_careers_pre_get_posts( $query ) {
            if ( is_admin() && $query->is_main_query() && is_post_type_archive( 'n3_careers' ) ) {
                $query->set('orderby', 'id');
                $query->set('order', 'DESC');
            }
        }

        public function __addSubmenu() {
            add_submenu_page(
                'edit.php?post_type=n3_careers',
                'Settings',
                'Settings',
                'manage_options',
                'n3_careers_settings',
                array($this, '___settingsPage'),
                // 0
            );

            add_submenu_page(
                'edit.php?post_type=n3_careers',
                'Short Code',
                'Short Code',
                'manage_options',
                'n3_careers_shortcodes',
                array($this, '___shortcodesPage'),
                // 0
            );
            
        }

        public function ___settingsPage() {
            require_once( plugin_dir_path( __FILE__ ) . 'setting_global.php' );
        }

        public function ___shortcodesPage() {
            require_once( plugin_dir_path( __FILE__ ) . 'setting.php' );
        }

        function ___n3_careers_ats() {
            add_theme_support( 'block-template-parts' );
        }

        public function ___n3_careers_archive_template($archive_template) {
            // nguyen_carrer_archive_template
            $nguyen_carrer_archive_template = get_option('nguyen_carrer_archive_template');
            if ( $nguyen_carrer_archive_template === 'yes' ) {
                if ( is_post_type_archive ( 'n3_careers' ) ) {
                    $theme_files = array('archive.php');
                    $exists_in_theme = locate_template($theme_files, false);
                    if($exists_in_theme == '') {
                        return plugin_dir_path( __FILE__ ) . 'archive.php';
                    }
                }
            }
            return $archive_template;
        }

        public function ___n3_careers_single_template( $single_template ) {
            $nguyen_carrer_single_template = get_option('nguyen_carrer_single_template');
            if ( $nguyen_carrer_single_template === 'yes' ) {
                if ( get_post_type() == 'n3_careers' ) {
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
                'id'    => 'gp-careers',
                'title' => esc_html__( 'RC Careers', 'gp-theme' ),
                'parent' => 'made_theme_options',
                'href'  => admin_url( 'edit.php?post_type=n3_careers' ),
            ));
            // $wp_admin_bar->add_menu( array(
            //     'id'    => 'gp-reusable-careers',
            //     'title' => esc_html__( 'GP Reusable blocks', 'gp-theme' ),
            //     'parent' => 'made_theme_options',
            //     'href'  => admin_url( 'edit.php?post_type=wp_block' ),
            // ));
        }

        public function updateSticky() {
            if ( isset( $_GET['sticky'] ) && $_GET['post_type'] == 'n3_careers' ) {
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

        public function ___n3_career_categories () {
            $labels = array(
                'name'              => esc_html__( 'Categories', 'gp-theme' ),
                'singular_name'     => esc_html__( 'Career Category', 'gp-theme' ),
                'search_items'      => esc_html__( 'Search Categories', 'gp-theme' ),
                'all_items'         => esc_html__( 'All Categories', 'gp-theme' ),
                'parent_item'       => esc_html__( 'Parent Career Category', 'gp-theme' ),
                'parent_item_colon' => esc_html__( 'Parent Career Category:', 'gp-theme' ),
                'edit_item'         => esc_html__( 'Edit Career Category', 'gp-theme' ),
                'update_item'       => esc_html__( 'Update Career Category', 'gp-theme' ),
                'add_new_item'      => esc_html__( 'Add New Career Category', 'gp-theme' ),
                'new_item_name'     => esc_html__( 'New Career Category Name', 'gp-theme' ),
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
                    'slug' => 'career-category',
                    'with_front' => true,
                    'hierarchical' => true
                ),
            );
            register_taxonomy( 'n3_career_categories', array( 'n3_careers' ), $args );
        }

        public function ___n3_careers() {
            register_post_type('n3_careers', 
                array(	
                    'label' => 'RC Careers',
                    'description' => 'Create a post of Careers',
                    'public' => true,
                    'show_ui' => true,
                    'menu_icon' => 'dashicons-welcome-learn-more',
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
                        'slug' => 'careers',
                        'post_type' => 'n3_careers',
                        // 'with_front' => true,
                        // 'hierarchical' => true
                    ),
                    'query_var' => true,
                    'has_archive' => true,
                    // 'exclude_from_search' => true,
                    'menu_position' => 31,
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
                        'name' => 'RC Careers',
                        'singular_name' => 'RC Careers',
                        'menu_name' => 'RC Careers',
                        'add_new' => 'Add Career',
                        'add_new_item' => 'Add New Career',
                        'new_item' => 'New Career',
                        'edit' => 'Edit',
                        'edit_item' => 'Edit Career',
                        'view' => 'View Career',
                        'view_item' => 'View Career',
                        'search_items' => 'Search Careers',
                        'not_found' => 'No Careers Found',
                        'not_found_in_trash' => 'No Careers Found in Trash',
                        'parent' => 'Parent Career'
                    ),
                    
                )
            );
        }

        // Hooking up our function to theme setup
        public function ___n3_careers_columns( $column, $post_id ) {
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
                        echo '<a href="'.admin_url( 'edit.php?post_type=n3_careers&sticky=no&post='.$post_id ).'"><span class="dashicons dashicons-star-filled"></span></a>';
                    } else {
                        echo '<a href="'.admin_url( 'edit.php?post_type=n3_careers&sticky=yes&post='.$post_id ).'"><span class="dashicons dashicons-star-empty"></span></a>';
                    }
                break;
                case 'career_category' :
                    $terms = get_the_terms( $post_id, 'n3_career_categories' );
                    if ( !empty( $terms ) ) {
                        $out = array();
                        foreach ( $terms as $term ) {
                            $out[] = sprintf( '<a href="%s">%s</a>',
                                esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'n3_career_categories' => $term->slug ), 'edit.php' ) ),
                                esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'n3_career_categories', 'display' ) )
                            );
                        }
                        echo join( ', ', $out );
                    } else {
                        _e( '-', 'gp-theme' );
                    }
                break;
                case 'short_code' :
                    echo '[n3_career id="'.$post_id.'"]';
                    // echo '<input type="text" value="[n3_career id='.$post_id.']" readonly>';
                break;
                case 'info' :
                    echo '<strong>Position:</strong> '.get_field('position', $post_id).'<br>';
                    echo ''.get_field('city', $post_id).' - ';
                    echo '';
                    $state_arr = get_field('state', $post_id) ?? '';
                    if ( !empty($state_arr) ) {
                        $state = '';
                        foreach ($state_arr as $key => $value) {
                            $state .= $value['label'] . ', ';
                        }
                        echo rtrim($state, ', ');
                    }
                    echo '<br>';
                break;

            }


        }
        public function ___n3_careers_edit_columns( $columns ) {
        
            $columns = array(
                'cb' => '<input type="checkbox" />',
                'gpthumbnail' => '<span class="dashicons dashicons-format-image"></span>',
                'title' => __( 'Title' ),
                'info' => __( 'Info' ),
                // 'short_code' => __( 'Short Code' ),
                'career_category' => __( 'Career Category' ),
                'author' => __( 'Author' ),
                // 'sticky' => __( 'Sticky' ),
                'date' => __( 'Date' )
            );
        
            return $columns;
        }

        // Shortcode
        public function n3_career_shortcode( $atts ) {
            $atts = shortcode_atts( array(
                'id' => '',
            ), $atts, 'n3_career' );
            ob_start();
            $post_id = $atts['id'];
            $post = get_post( $post_id );
            if ( $post ) {
                ?>
                <div class="n3-careers-single">
                    <h2 class="job_title"><?php echo $post->post_title; ?></h2>
                    <!-- Display Advanced Custom Fields -->
                    <?php if ( function_exists('get_field') ) : ?>
                        <div class="job_meta">
                            <h3>Job Details</h3>
                            <ul>
                                <li><strong>Job Type:</strong> <?php echo get_field('type', $post_id); ?></li>
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
                    <div class="job_content">
                        <?php echo apply_filters('the_content', $post->post_content); ?>
                    </div>
                </div>
                <?php   
            }
            return ob_get_clean();
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

        public function n3_career_shortcode_group( $atts ) {
            $atts = shortcode_atts( array(
                'id' => null,
                'layout' => null,
                'limit' => null,
                'class' => null,
            ), $atts, 'n3_career_group' );
            ob_start();
            $category_id = $atts['id'];
            $layout = $atts['layout'] ? $atts['layout'] : get_term_meta($category_id, 'n3_career_layout', true) ?? 'list';
            $limit = $atts['limit'] ? $atts['limit'] : get_term_meta($category_id, 'n3_career_limit', true) ?? 10;
            $class = $atts['class'] ? preg_replace('/{{(.*?)}}/', '[$1]', $atts['class']) : get_term_meta($category_id, 'n3_career_class', true) ?? '';
            $args = array(
                'post_type' => 'n3_careers',
                'posts_per_page' => $limit,
            );

            if ( $category_id ) {
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => 'n3_career_categories',
                        'field' => 'term_id',
                        'terms' => $category_id
                    )
                );
            }

            $query = new WP_Query( $args );
            
            if ( $query->have_posts() ) {
                (new GPC_Core_CAREER)->___madelab_careers_generate($query, $layout, $limit, $class);
            }

            wp_reset_postdata();
            return ob_get_clean();
        }

        public function ___madelab_careers_generate($query, $layout, $limit, $class) {
            
            return include( dirname( __FILE__ ) . '/init.php' );

        }

    }
}

new GPC_Core_CAREER();
