<?php

// Require Advanced Custom Fields plugin. If not installed, show a notice and can not activate the plugin.
if ( !function_exists('get_field') ) {
    add_action('admin_notices', function() {
        echo '<div class="notice notice-error is-dismissible">
            <p>Advanced Custom Fields plugin is required for this theme. Please install and activate the plugin.</p>
        </div>';
    });
    return;
}

// Remove admin bar
function restrict_admin_bar($content) {
    return false;
}
add_filter('show_admin_bar', 'restrict_admin_bar');

// Remove Admin WP logo
function remove_admin_logo() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo');
}
add_action('wp_before_admin_bar_render', 'remove_admin_logo');

// Change WP Login Screen Logo
function custom_login_logo() {
    echo '<style type="text/css">
        body.login,body.login #login>*{box-sizing:border-box}body.login #login>*{width:100%}body.login #login form{border-radius:5px}body.login #login #nav{text-align:center}@media only screen and (min-width:1000px){body.login { display: flex;flex-direction: column; justify-content: center; align-items: center; }body.login #login{border-radius: 2rem;padding:2rem 2rem 0 2rem;display:flex;flex-direction:column;justify-content:flex-start;align-items:center;background:rgba(255,255,255,1);box-shadow:0 0 8px 3px rgba(0,0,0,.15)}body.login #login form{background:0 0;border:0;padding:1rem 0;box-shadow:none}#login h1 a, .login h1 a {padding-bottom: 0; margin-bottom: 0; }}
        body.login #backtoblog { display: none; }
        body.login .wp-login-lost-password { display: block; margin-bottom: 1rem; }
        h1 a { 
            background-image:url('.get_bloginfo('template_directory').'/assets/images/logon3cr.png) !important;
            background-size: contain !important;
            width: 250px !important;
        }
    </style>';
}
add_action('login_head', 'custom_login_logo');

// Change WP Favicon
function custom_favicon() {
    if ( ! has_site_icon() ) {
        echo '<link rel="shortcut icon" href="'.get_bloginfo('template_directory').'/assets/images/logon3cr.png" />';
    } else {
        echo '<style type="text/css">
            .edit-post-fullscreen-mode-close.components-button .edit-post-fullscreen-mode-close_site-icon {
                display: none;
            }
        </style>';
    }
}
add_action('login_head', 'custom_favicon');
add_action('admin_head', 'custom_favicon');

// Remove WP version & comments
function ___wp_lightweight_disable_comments() {
    add_action('admin_init', function () {
        global $pagenow;
        if ($pagenow === 'edit-comments.php') {
            wp_redirect(admin_url());
            exit;
        }
        remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
        foreach (get_post_types() as $post_type) {
            if (post_type_supports($post_type, 'comments')) {
                remove_post_type_support($post_type, 'comments');
                remove_post_type_support($post_type, 'trackbacks');
            }
        }
    });
    add_filter('comments_open', '__return_false', 20, 2);
    add_filter('pings_open', '__return_false', 20, 2);
    add_filter('comments_array', '__return_empty_array', 10, 2);
    add_action('admin_menu', function () {
        remove_menu_page('edit-comments.php');
    });
    add_action('init', function () {
        if (is_admin_bar_showing()) {
            remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
        }
    });
    add_action('wp_before_admin_bar_render', function() {
        global $wp_admin_bar;
        $wp_admin_bar->remove_menu('comments');
    });
}
add_action('init', '___wp_lightweight_disable_comments');


// Remove WP Gutenberg
// function prefix_disable_gutenberg($current_status, $post_type)
// {
//     if ($post_type === 'n3_careers' || $post_type === 'n3_maps' || $post_type === 'n3_testimonials' || $post_type === 'n3_properties') return false;
//     return $current_status;
// }
// add_filter('use_block_editor_for_post_type', 'prefix_disable_gutenberg', 10, 2);

// Remove WP Dashboard Widgets
function disable_default_dashboard_widgets() {
    remove_meta_box('dashboard_primary', 'dashboard', 'side');
}
add_action('wp_dashboard_setup', 'disable_default_dashboard_widgets', 999);

// Add admin bar menu
function ___addToAdminBar() {
    global $wp_admin_bar;
    $wp_admin_bar->add_menu( array(
        'id'    => 'gp-reusable-projects',
        'title' => esc_html__( 'CR Custom Block', 'gp-theme' ),
        'parent' => 'made_theme_options',
        'href'  => admin_url( 'edit.php?post_type=wp_block' ),
    ));
}

add_action( 'admin_bar_menu', '___addToAdminBar', 100 );

// Add custom block to admin menu
function ___addN3CustomBlockToMenu() {
    add_menu_page(
        'RC Patterns',
        'RC Patterns',
        'manage_options',
        'edit.php?post_type=wp_block',
        '',
        'dashicons-category',
        38
    );
}
add_action('admin_menu', '___addN3CustomBlockToMenu');

// Add separator to admin menu
function add_admin_menu_separator($position) {
    global $menu;
    $index = 0;
    foreach($menu as $offset => $section) {
        if (substr($section[2],0,9)=='separator')
        $index++;
        if ($offset>=$position) {
        $menu[$position] = array('','read',"separator{$index}",'','wp-menu-separator');
        break;
        }
    }
    ksort( $menu );
}

add_action('admin_menu', function() {  add_admin_menu_separator(29); });

// Format states
function displayArrayState($state_arr) {
    $state = 'N/A';
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

// Format category
function displayArrayCategory($cat_arr) {
    $cat = 'N/A';
    if ( !empty($cat_arr)  && is_array($cat_arr) ) {
        $cat = '';
        if ( isset($cat_arr['value']) && isset($cat_arr['label']) ) {
            return $cat_arr['label'];
        } else {
            foreach ($cat_arr as $key => $value) {
                $cat .= $value['label'] . ', ';
            }
            return rtrim($cat, ', ');
        }
    } else if ( !empty($cat_arr) && is_string($cat_arr) ) {
        return $cat_arr;
    }
    return $cat;
}

// function n3_careers_archive_template($archive_template) {
//     global $post;
//     if ($post && $post->post_type === 'n3_careers') {
//         $archive_template = dirname( __FILE__ ) . '/archive_n3_careers.php';
//     }
//     return $archive_template;
// }
// add_filter( 'archive_template', 'n3_careers_archive_template' );


// wp block add editor style 
function n3_block_editor_styles() {
    add_theme_support( 'wp-block-styles' );
    add_editor_style('style.css' );
}
add_action( 'after_setup_theme', 'n3_block_editor_styles' );

// Add main.js to the theme
function n3_enqueue_scripts() {
    wp_enqueue_script('main-js', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'n3_enqueue_scripts');


// Add column `template to page list
function n3_page_columns($columns) {
    $columns = array(
        'cb' => '<input type="checkbox" />',
        'gpthumbnail' => '<span class="dashicons dashicons-format-image"></span>',
        'title' => __( 'Title' ),
        'template' => __( 'Template' ),
        'author' => __( 'Author' ),
        'date' => __( 'Date' )
    );

    return $columns;
}

function n3_page_column_content($column_name, $post_id) {
    global $post;
    $post_data = get_post($post_id, ARRAY_A);

    switch ($column_name) {
        case 'gpthumbnail' :
            echo get_the_post_thumbnail( $post_id, array(60,60) );
        break;
        case 'template':
            $template_file = get_post_meta($post_id, '_wp_page_template', true);
            if ($template_file) {
                echo ucwords(str_replace('-', ' ', str_replace('.php', '', $template_file)));
            } else {
                echo 'Default';
            }
        break;
    }
}

add_filter('manage_pages_columns', 'n3_page_columns');
add_action('manage_pages_custom_column', 'n3_page_column_content', 10, 2);


// Add column `template to post list
function n3_post_columns($columns) {
    $columns = array(
        'cb' => '<input type="checkbox" />',
        'gpthumbnail' => '<span class="dashicons dashicons-format-image"></span>',
        'title' => __( 'Title' ),
        'category' => __( 'Category' ),
        'tags' => __( 'Tags' ),
        'author' => __( 'Author' ),
        'date' => __( 'Date' )
    );

    return $columns;
}

function n3_post_column_content($column_name, $post_id) {
    global $post;
    $post_data = get_post($post_id, ARRAY_A);

    switch ($column_name) {
        case 'gpthumbnail' :
            echo get_the_post_thumbnail( $post_id, array(60,60) );
        break;
        case 'category':
            $categories = get_the_category($post_id);
            if ($categories) {
                $output = array();
                foreach ($categories as $category) {
                    $output[] = sprintf( '<a href="%s">%s</a>', esc_url( add_query_arg( 'cat', $category->term_id, 'edit.php' ) ), esc_html( $category->name ) );
                }
                echo implode(', ', $output);
            } else {
                echo 'N/A';
            }
        break;
        case 'tags':
            $tags = get_the_tags($post_id);
            if ($tags) {
                $output = array();
                foreach ($tags as $tag) {
                    $output[] = $tag->name;
                }
                echo implode(', ', $output);
            } else {
                echo 'N/A';
            }
        break;
    }
}

add_filter('manage_posts_columns', 'n3_post_columns');
add_action('manage_posts_custom_column', 'n3_post_column_content', 10, 2);