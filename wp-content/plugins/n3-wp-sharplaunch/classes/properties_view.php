<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
$get_id = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;
if ( ! $get_id ) {
    wp_die( 'Invalid ID' );
}

$property = new GPC_Core_SHARPLAUNCH();
$getproperty = $property->SL_GetPropertiesByID( $get_id );
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
$hero = $getproperty->sections->hero;
$building = $getproperty->sections->building;
$highlights = $getproperty->sections->highlights;
$files = $getproperty->sections->files;
$gallery = $getproperty->sections->gallery;
$parcels = $getproperty->sections->parcels;
$contact = $getproperty->sections->contact;
$getLatLong = $property->get_lat_long( $building->address . ', ' . $building->city . ', ' . $building->state . ', ' . $building->country );
$lat = explode( ',', $getLatLong )[0];
$long = explode( ',', $getLatLong )[1];
$options = $getproperty->options;
// $img_cover = $property->SL_DownloadImage( $building->hero_image );
// Download Image from URL
// var_dump($getproperty); 
// var_dump($options);

// Submit Data
if ( isset( $_POST['submit'] ) ) {
    // Secure Form 
    if ( ! isset( $_POST['n3_sharplaunch_nonce'] ) || ! wp_verify_nonce( $_POST['n3_sharplaunch_nonce'], 'n3_sharplaunch_nonce' ) ) {
        return;
    }
    $sharplaunch_id = isset( $_POST['sharplaunch_id'] ) ? intval( $_POST['sharplaunch_id'] ) : 0;
    $sharplaunch_name = isset( $_POST['sharplaunch_name'] ) ? sanitize_text_field( $_POST['sharplaunch_name'] ) : '';
    $sharplaunch_status = isset( $_POST['sharplaunch_status'] ) ? sanitize_text_field( $_POST['sharplaunch_status'] ) : '';
    // Hero Section
    $hero_title = isset( $_POST['hero_title'] ) ? sanitize_text_field( $_POST['hero_title'] ) : '';
    $hero_subtitle = isset( $_POST['hero_subtitle'] ) ? sanitize_text_field( $_POST['hero_subtitle'] ) : '';
    $hero_cta = isset( $_POST['hero_cta'] ) ? sanitize_text_field( $_POST['hero_cta'] ) : '';
    // Building Section
    $building_description = isset( $_POST['building_description'] ) ? sanitize_text_field( $_POST['building_description'] ) : '';
    $building_state = isset( $_POST['building_state'] ) ? sanitize_text_field( $_POST['building_state'] ) : '';
    $building_city = isset( $_POST['building_city'] ) ? sanitize_text_field( $_POST['building_city'] ) : '';
    $building_address = isset( $_POST['building_address'] ) ? sanitize_text_field( $_POST['building_address'] ) : '';

    // Content = hero_title + hero_subtitle + hero_cta + building_description 
    $content = '<h2>' . $hero_title . '</h2><p>' . $hero_subtitle . '</p><a href="#" class="btn btn-primary">' . $hero_cta . '</a><p>' . $building_description . '</p>';

    // Create a new post
    $post = array(
        'post_title' => $sharplaunch_name,
        'post_content' => $content,
        'post_status' => 'publish',
        'post_type' => 'n3_properties',
    );
    $get_post_id = wp_insert_post( $post );
    $template = 'default';

    // Add ACF Fields
    // Property Status
    update_field( 'field_vg632c8c04e627c', 'active', $get_post_id ); 
    // General
    update_field( 'field_lll891427c3443', 
        array(
            'year_built' => $options->yearbuilt,
            'units_count' => $options->units,
            'surface' => $options->building_total_sqf,
            'surface_unit' => $options->building_total_unit,
            'price' => $options->sale_price,
            'price_postfix' => $options->sale_currency,
    ), $get_post_id ); 
    // Location Information
    update_field( 'field_zzz891427c3443', 
        array(
            'state' => array(
                'value' => $building_state,
                'label' => $property->getStateNameByCode( $building_state ),
            ),
            'city' => $building_city,
            'address' => $building_address,
            'latitude' => $lat,
            'longitude' => $long,
    ), $get_post_id ); 

    // Update post meta ID
    update_post_meta( $get_post_id, 'sharplaunch', $sharplaunch_id );

    // Redirect to edit post
    // wp_redirect( get_edit_post_link( $get_post_id ) );

    // Show Success Message
    echo '<div class="updated notice is-dismissible"><p>Updated Successfully</p></div>';
}

// Find post by meta 
$find_post_by_meta = get_posts(array(
    'post_type' => 'n3_properties',
    'meta_key' => 'sharplaunch',
    'meta_value' => $get_id,
));
?>
<div class="wrap settingfp">
    <?php
    if ( $find_post_by_meta ) {
        echo '<div id="wp-content-editor-tools" class="wp-heading"> <h1 style="padding: 0"> Property Found! </h1> <div class="clear"></div> <hr> </div>';
        echo '<div class="py-2"><strong style="font-size: 20px;">' . $find_post_by_meta[0]->post_title . ' is already in the system</strong></div>';
        echo '<div class="p"><a href="' . get_edit_post_link( $find_post_by_meta[0]->ID ) . '" class="button button-primary">View Property</a></div>';
    } else {
    ?>
    <div id="wp-content-editor-tools" class="wp-heading">
        <h1 style="padding: 0">
            Create Property
        </h1>
        <div class="clear"></div>
        <hr>
    </div>
    <div class="form-wrap">
        <table class="wp-list-table widefat fixed striped table-view-list pages">
            <thead>
                <tr>
                    <th scope="col" id="id" class="manage-column column-name column-primary">ID</th>
                    <th scope="col" id="name" class="manage-column column-email">Name</th>
                    <th scope="col" id="status" class="manage-column column-title">Status</th>
                    <th scope="col" id="goapp" class="manage-column column-goapp" style="width: 80px;">Go App</th>
                </tr>
            </thead>
            <tbody id="the-list">
        <tr class="hentry">
            <td>
                <?php echo $getproperty->id; ?>
            </td>
            <td>
                <?php echo $getproperty->name; ?>
            </td>
            <td>
                <?php echo $getproperty->status ? 'Active' : 'Inactive'; ?>
            </td>
            <td>
                <a href="https://admin.sharplaunch.com/#/<?php echo $getproperty->id; ?>/cms/sections/building/" class="button button-primary" target="_blank">Go App</a>
            </td>
        </tr>
        </tbody>
        </table>

        <form method="post" action="">
            <?php wp_nonce_field( 'n3_sharplaunch_nonce', 'n3_sharplaunch_nonce' ); ?>

            <input type="hidden" name="sharplaunch_id" value="<?php echo $getproperty->id; ?>"> <!-- Done -->
            <input type="hidden" name="sharplaunch_name" value="<?php echo $getproperty->name; ?>"> <!-- Done -->
            <input type="hidden" name="sharplaunch_status" value="<?php echo $getproperty->status; ?>"> <!-- Done -->
            
            <input type="hidden" name="hero_title" value="<?php echo $hero->title; ?>"> <!-- Done -->
            <input type="hidden" name="hero_subtitle" value="<?php echo $hero->subtitle; ?>"> <!-- Done -->
            <input type="hidden" name="hero_cta" value="<?php echo $hero->cta; ?>"> <!-- Done -->

            <input type="hidden" name="building_menu_title" value="<?php echo $building->menu_title; ?>">
            <input type="hidden" name="building_hero_image" value="<?php echo $building->hero_image; ?>">
            <input type="hidden" name="building_title" value="<?php echo $building->title; ?>">
            <input type="hidden" name="building_address" value="<?php echo $building->address; ?>"> <!-- Done -->
            <input type="hidden" name="building_description" value="<?php echo $building->overview; ?>"> <!-- Done -->
            <input type="hidden" name="building_state" value="<?php echo $building->state; ?>"> <!-- Done -->
            <input type="hidden" name="building_city" value="<?php echo $building->city; ?>"> <!-- Done -->
            <input type="hidden" name="building_country" value="<?php echo $building->country; ?>">
            
            <input type="hidden" name="highlights_sub_title" value="<?php echo $highlights->sub_title; ?>">

            <div class="mt-3">
                <input type="submit" name="submit" id="submit" class="button button-primary" value="Submit">
            </div>
        </form>


    </div>
    <?php } ?>

</div>