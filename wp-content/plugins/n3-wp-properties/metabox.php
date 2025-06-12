<?php
// function hide_meta_boxes_n3_properties() {
//     remove_meta_box( 'wpseo_meta', 'n3_properties', 'normal' );
// }

// add_action( 'add_meta_boxes', 'hide_meta_boxes_n3_properties',11 );

function add_custom_meta_box_n3_properties() {
    // IF EDIT 
    global $pagenow;
    if ( $pagenow == 'post.php' ) {
        add_meta_box(
            'n3_properties_meta_box', // $id
            'Shortcode', // $title
            'display_custom_meta_box_n3_properties', // $callback
            'n3_properties', // $page
            'side', // $context
            'high'); // $priority
    }
}
add_action('add_meta_boxes', 'add_custom_meta_box_n3_properties');

function display_custom_meta_box_n3_properties() {
    global $post;
    $post_data = get_post(get_the_ID(), ARRAY_A);
    $slug = isset($post_data['post_name'] ) ? $post_data['post_name'] : '';
    ?>
    <p>
        <input type="text" class="sm" name="shortcode" value='[gp_property id="<?php echo $slug; ?>"]' readonly='readonly' style="width:100%" />
    </p>
    <?php
}