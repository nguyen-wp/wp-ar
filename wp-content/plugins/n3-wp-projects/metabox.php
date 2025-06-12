<?php
// function hide_meta_boxes_n3_projects() {
//     remove_meta_box( 'wpseo_meta', 'n3_projects', 'normal' );
// }

// add_action( 'add_meta_boxes', 'hide_meta_boxes_n3_projects',11 );

function add_custom_meta_box_n3_projects() {
    // IF EDIT 
    global $pagenow;
    if ( $pagenow == 'post.php' ) {
        add_meta_box(
            'n3_projects_meta_box', // $id
            'Shortcode', // $title
            'display_custom_meta_box_n3_projects', // $callback
            'n3_projects', // $page
            'side', // $context
            'high'); // $priority
    }
}
add_action('add_meta_boxes', 'add_custom_meta_box_n3_projects');

function display_custom_meta_box_n3_projects() {
    global $post;
    $post_data = get_post(get_the_ID(), ARRAY_A);
    $slug = isset($post_data['post_name'] ) ? $post_data['post_name'] : '';
    ?>
    <p>
        <input type="text" class="sm" name="shortcode" value='[n3_project id="<?php echo $slug; ?>"]' readonly='readonly' style="width:100%" />
    </p>
    <?php
}