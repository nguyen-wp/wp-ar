<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * Class made_io_settings
 */
if(isset($_POST['submit'])) {
    if(isset($_POST['nguyenmapapikey'])) {
        update_option('nguyenmapapikey', $_POST['nguyenmapapikey']);
    } else {
        update_option('nguyenmapapikey', '');
    }
    if(isset($_POST['nguyenmapalatitude'])) {
        update_option('nguyenmapalatitude', $_POST['nguyenmapalatitude']);
    } else {
        update_option('nguyenmapalatitude', '');
    }
    if(isset($_POST['nguyenmapalongitude'])) {
        update_option('nguyenmapalongitude', $_POST['nguyenmapalongitude']);
    } else {
        update_option('nguyenmapalongitude', '');
    }
    
    if(isset($_POST['nguyenmapazoom'])) {
        update_option('nguyenmapazoom', $_POST['nguyenmapazoom']);
    } else {
        update_option('nguyenmapazoom', '');
    }
    // Map Height
    if(isset($_POST['nguyenmapaheight'])) {
        update_option('nguyenmapaheight', $_POST['nguyenmapaheight']);
    } else {
        update_option('nguyenmapaheight', '');
    }
    // Custom Marker
    if(isset($_POST['nguyenmapamarker'])) {
        update_option('nguyenmapamarker', $_POST['nguyenmapamarker']);
    } else {
        update_option('nguyenmapamarker', '');
    }
    // Info Window Class Name
    if(isset($_POST['nguyenmapainfowindow'])) {
        update_option('nguyenmapainfowindow', $_POST['nguyenmapainfowindow']);
    } else {
        update_option('nguyenmapainfowindow', '');
    }
    // Filter type
    if(isset($_POST['nguyenmapafilter'])) {
        update_option('nguyenmapafilter', $_POST['nguyenmapafilter']);
    } else {
        update_option('nguyenmapafilter', '');
    }
    // Display Sidebar
    if(isset($_POST['nguyenmapasidebar_archive'])) {
        update_option('nguyenmapasidebar_archive', $_POST['nguyenmapasidebar_archive']);
    } else {
        update_option('nguyenmapasidebar_archive', '');
    }
    // Display Sidebar
    if(isset($_POST['nguyenmapasidebar'])) {
        update_option('nguyenmapasidebar', $_POST['nguyenmapasidebar']);
    } else {
        update_option('nguyenmapasidebar', '');
    }
     // Using `archive_template`
     if(isset($_POST['nguyen_map_archive_template'])) {
        update_option('nguyen_map_archive_template', $_POST['nguyen_map_archive_template']);
    } else {
        update_option('nguyen_map_archive_template', '');
    }
    // Using `single_template`
    if(isset($_POST['nguyen_map_single_template'])) {
        update_option('nguyen_map_single_template', $_POST['nguyen_map_single_template']);
    } else {
        update_option('nguyen_map_single_template', '');
    }
    // Only display item on the map
    if(isset($_POST['nguyen_map_only_display_items'])) {
        update_option('nguyen_map_only_display_items', $_POST['nguyen_map_only_display_items']);
    } else {
        update_option('nguyen_map_only_display_items', '');
    }

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

        <form action="" method="post">

            <div class="form-field">
                <h4><?php esc_html_e( 'Google Map API Key', 'made-theme-options' ); ?></h4>
                <div class="mb-3">
                    <input type="text" id="api-event" value="<?php echo get_option( 'nguyenmapapikey' ); ?>" name="nguyenmapapikey" placeholder="AIzaSyBM8LFkdq9fISqWRWFt1u-rqsALyptk1g4">
                </div>
                <div class="small"></div>
            </div>
            <div class="form-field">
                <h4><?php esc_html_e( 'Default Latitude', 'made-theme-options' ); ?></h4>
                <div class="mb-3">
                    <input type="text" id="api-latitude" value="<?php echo get_option( 'nguyenmapalatitude' ); ?>" name="nguyenmapalatitude" placeholder="35.414722">
                </div>
                <div class="small"></div>
            </div>
            <div class="form-field">
                <h4><?php esc_html_e( 'Default Longitude', 'made-theme-options' ); ?></h4>
                <div class="mb-3">
                    <input type="text" id="api-longitude" value="<?php echo get_option( 'nguyenmapalongitude' ); ?>" name="nguyenmapalongitude" placeholder="-97.386667">
                </div>
                <div class="small"></div>
            </div>
            <div class="form-field">
                <h4><?php esc_html_e( 'Default Zoom', 'made-theme-options' ); ?></h4>
                <div class="mb-3">
                    <input type="number" id="api-zoom" value="<?php echo get_option( 'nguyenmapazoom' ); ?>" name="nguyenmapazoom" placeholder="9" min="1" max="20">
                </div>
                <div class="small"></div>
            </div>
            <div class="form-field">
                <h4><?php esc_html_e( 'Map Height', 'made-theme-options' ); ?></h4>
                <div class="mb-3">
                    <input type="number" id="api-height" value="<?php echo get_option( 'nguyenmapaheight' ); ?>" name="nguyenmapaheight" placeholder="500" min="1">
                </div>
                <div class="small"></div>
            </div>
            <div class="form-field">
                <h4><?php esc_html_e( 'Custom Marker', 'made-theme-options' ); ?></h4>
                <div class="mb-3">
                    <input type="text" id="api-marker" value="<?php echo get_option( 'nguyenmapamarker' ); ?>" name="nguyenmapamarker" placeholder="https://maps.google.com/mapfiles/kml/paddle/red-circle.png">
                </div>
                <div class="small"></div>
            </div>
            <div class="form-field">
                <h4><?php esc_html_e( 'Info Window Class Name', 'made-theme-options' ); ?></h4>
                <div class="mb-3">
                    <input type="text" id="api-infowindow" value="<?php echo get_option( 'nguyenmapainfowindow' ); ?>" name="nguyenmapainfowindow" placeholder="info-window">
                </div>
                <div class="small"></div>
            </div>
            <div class="form-field">
                <h4><?php esc_html_e( 'Filter Type', 'made-theme-options' ); ?></h4>
                <div class="mb-3">
                    <select id="api-filter" name="nguyenmapafilter">
                        <option value="select" <?php echo (get_option( 'nguyenmapafilter' ) == 'select') ? 'selected' : ''; ?>>Select</option>
                        <option value="list" <?php echo (get_option( 'nguyenmapafilter' ) == 'list') ? 'selected' : ''; ?>>List</option>
                    </select>
                </div>
                <div class="small"></div>
            </div>

            <div class="form-field">
                <h4><?php esc_html_e( 'Display Sidebar on Archive Page', 'made-theme-options' ); ?></h4>
                <div class="mb-3">
                    <select id="api-sidebar" name="nguyenmapasidebar_archive">
                        <option value="yes" <?php echo (get_option( 'nguyenmapasidebar_archive' ) == 'yes') ? 'selected' : ''; ?>>Yes</option>
                        <option value="no" <?php echo (get_option( 'nguyenmapasidebar_archive' ) == 'no') ? 'selected' : ''; ?>>No</option>
                    </select>
                </div>
                <div class="small"></div>
            </div>
            <div class="form-field">
                <h4><?php esc_html_e( 'Display Sidebar on Single Page', 'made-theme-options' ); ?></h4>
                <div class="mb-3">
                    <select id="api-sidebar" name="nguyenmapasidebar">
                        <option value="yes" <?php echo (get_option( 'nguyenmapasidebar' ) == 'yes') ? 'selected' : ''; ?>>Yes</option>
                        <option value="no" <?php echo (get_option( 'nguyenmapasidebar' ) == 'no') ? 'selected' : ''; ?>>No</option>
                    </select>
                </div>
                <div class="small"></div>
            </div>

            <div class="form-field">
                <h4><?php esc_html_e( 'Archive Template', 'made-theme-options' ); ?></h4>
                <div class="mb-3">
                    <select name="nguyen_map_archive_template">
                        <option value="no" <?php echo (get_option( 'nguyen_map_archive_template' ) == 'no') ? 'selected' : ''; ?>>No</option>
                        <option value="yes" <?php echo (get_option( 'nguyen_map_archive_template' ) == 'yes') ? 'selected' : ''; ?>>Yes</option>
                    </select>
                </div>
                <div class="small"></div>
            </div>

            <div class="form-field">
                <h4><?php esc_html_e( 'Single Template', 'made-theme-options' ); ?></h4>
                <div class="mb-3">
                    <select name="nguyen_map_single_template">
                        <option value="no" <?php echo (get_option( 'nguyen_map_single_template' ) == 'no') ? 'selected' : ''; ?>>No</option>
                        <option value="yes" <?php echo (get_option( 'nguyen_map_single_template' ) == 'yes') ? 'selected' : ''; ?>>Yes</option>
                    </select>
                </div>
                <div class="small"></div>
            </div>

            <div class="form-field">
                <h4><?php esc_html_e( 'The list will only appear when the map shows the locations', 'made-theme-options' ); ?></h4>
                <div class="mb-3">
                    <select name="nguyen_map_only_display_items">
                        <option value="no" <?php echo (get_option( 'nguyen_map_only_display_items' ) == 'no') ? 'selected' : ''; ?>>No</option>
                        <option value="yes" <?php echo (get_option( 'nguyen_map_only_display_items' ) == 'yes') ? 'selected' : ''; ?>>Yes</option>
                    </select>
                </div>
                <div class="small"></div>
            </div>

            <!-- Submit Button -->
            <div class="form-field">
                <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php esc_attr_e( 'Save Changes', 'made-theme-options' ); ?>">
            </div>


        </form>


    </div>

</div>