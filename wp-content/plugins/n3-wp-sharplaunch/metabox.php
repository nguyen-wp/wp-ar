<?php

function add_custom_meta_box_n3_sharplaunchs() {
    // IF EDIT 
    global $pagenow;
    if ( $pagenow == 'post.php'  || $pagenow == 'post-new.php' ) {
        add_meta_box(
            'n3_sharplaunc_meta_box', // $id
            'Sharplaunch', // $title
            'display_custom_meta_box_n3_sharplaunchs', // $callback
            'n3_properties', // $page
            'side', // $context
            'high'); // $priority
    }
}
add_action('add_meta_boxes', 'add_custom_meta_box_n3_sharplaunchs');

function display_custom_meta_box_n3_sharplaunchs() {
    global $post;
    $post_data = get_post(get_the_ID(), ARRAY_A);
    $slug = isset($_GET['sharplaunch']) ? $_GET['sharplaunch'] : get_post_meta($post->ID, 'sharplaunch', true) ?? null;
    if ( ! $slug ) {
        echo '<div class=""><p>Sharplaunch unavailable</p></div>';
        return;
    }
    $property = new GPC_Core_SHARPLAUNCH();
    $getproperty = $property->SL_GetPropertiesByID( $slug );
    $key = array( 
        // 'header' => 'Header',
        'hero' => 'Hero Section',
        'building' => 'Property Summary',
        'files' => 'Downloads',
        'gallery' => 'Gallery',
        'parcels' => 'Parcels',
        'team' => 'Team',
        'contact' => 'Contact',
    );
    $building = $getproperty->sections->building;
    ?>
    <div class="flex flex-row items-center space-x-2">
        Sharplaunch ID: <a href="https://admin.sharplaunch.com/#/<?php echo $slug; ?>/cms/sections/building/" class="button button-primary" target="_blank"><?php echo $slug; ?></a>
    </div>
    <?php
}