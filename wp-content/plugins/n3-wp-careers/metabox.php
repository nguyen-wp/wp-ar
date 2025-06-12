<?php
// function hide_meta_boxes_n3_careers() {
//     remove_meta_box( 'wpseo_meta', 'n3_careers', 'normal' );
// }

// add_action( 'add_meta_boxes', 'hide_meta_boxes_n3_careers',11 );

function add_custom_meta_box_n3_careers() {
    // IF EDIT 
    global $pagenow;
    if ( $pagenow == 'post.php' ) {
        add_meta_box(
            'n3_careers_meta_box', // $id
            'Shortcode', // $title
            'display_custom_meta_box_n3_careers', // $callback
            'n3_careers', // $page
            'side', // $context
            'high'); // $priority
    }
}
add_action('add_meta_boxes', 'add_custom_meta_box_n3_careers');

function display_custom_meta_box_n3_careers() {
    global $post;
    $post_data = get_post(get_the_ID(), ARRAY_A);
    $slug = isset($post_data['post_name'] ) ? $post_data['post_name'] : '';
    ?>
    <p>
        <input type="text" class="sm" name="shortcode" value='[gp_career id="<?php echo $slug; ?>"]' readonly='readonly' style="width:100%" />
    </p>
    <?php
}