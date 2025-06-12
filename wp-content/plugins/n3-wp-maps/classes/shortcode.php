<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<div class="wrap settingfp">
    <div id="wp-content-editor-tools" class="wp-heading">
        <h1 style="padding: 0">
            <?php echo esc_html( get_admin_page_title() ); ?>

        </h1>
        <div class="clear"></div>
        <hr>
    </div>
    <div class="form-wrap">

        <p>
            Shortcode: <code>[n3_maps_menu], [n3_maps], [n3_maps_filter], [n3_maps_filter_city], [n3_maps_filter_size], [n3_maps_filter_type], [n3_google_map address="?" latitude="?" longitude="?" height="400" zoom="17"]</code>
        </p>

        <h2>
            <?php _e( 'Google Map List', 'n3_wp_maps' ); ?>
        </h2>

        <div class="container-fluid" style="box-sizing: border-box;">
            <div class="row border">
                <div class="col ps-5 pb-2 pe-5 pt-2 bg-primary text-white">[n3_maps_filter]</div>
            </div>
        </div>
        <div class="container-fluid" style="box-sizing: border-box;">
            <div class="row border">
                <div class="col-8 p-5 bg-info" style="box-sizing: border-box;">[n3_maps]</div>
                <div class="col-4 p-5 bg-secondary text-white" style="box-sizing: border-box;">[n3_maps_menu]</div>
            </div>
        </div>

        <h2>
            <?php _e( 'Google Map Display', 'n3_wp_maps' ); ?>
        </h2>

        <div class="container-fluid" style="box-sizing: border-box;">
            <div class="row border">
                <div class="col ps-5 pb-2 pe-5 pt-2 bg-primary text-white">[n3_google_map address="?" latitude="?" longitude="?" height="400" zoom="17"]</div>
            </div>
        </div>

    </div>

</div>