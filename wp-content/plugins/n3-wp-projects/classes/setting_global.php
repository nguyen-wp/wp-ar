<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * Class made_io_settings
 */
if(isset($_POST['submit'])) {
    
    // Display Sidebar
    if(isset($_POST['nguyenprojectsidebar_archive'])) {
        update_option('nguyenprojectsidebar_archive', $_POST['nguyenprojectsidebar_archive']);
    } else {
        update_option('nguyenprojectsidebar_archive', '');
    }
    // Display Sidebar
    if(isset($_POST['nguyenprojectsidebar'])) {
        update_option('nguyenprojectsidebar', $_POST['nguyenprojectsidebar']);
    } else {
        update_option('nguyenprojectsidebar', '');
    }
    // Using `archive_template`
    if(isset($_POST['nguyen_project_archive_template'])) {
        update_option('nguyen_project_archive_template', $_POST['nguyen_project_archive_template']);
    } else {
        update_option('nguyen_project_archive_template', '');
    }
    // Using `single_template`
    if(isset($_POST['nguyen_project_single_template'])) {
        update_option('nguyen_project_single_template', $_POST['nguyen_project_single_template']);
    } else {
        update_option('nguyen_project_single_template', '');
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
                <h4><?php esc_html_e( 'Display Sidebar on Archive Page', 'made-theme-options' ); ?></h4>
                <div class="mb-3">
                    <select id="api-sidebar" name="nguyenprojectsidebar_archive">
                        <option value="yes" <?php echo (get_option( 'nguyenprojectsidebar_archive' ) == 'yes') ? 'selected' : ''; ?>>Yes</option>
                        <option value="no" <?php echo (get_option( 'nguyenprojectsidebar_archive' ) == 'no') ? 'selected' : ''; ?>>No</option>
                    </select>
                </div>
                <div class="small"></div>
            </div>
            <div class="form-field">
                <h4><?php esc_html_e( 'Display Sidebar on Single Page', 'made-theme-options' ); ?></h4>
                <div class="mb-3">
                    <select id="api-sidebar" name="nguyenprojectsidebar">
                        <option value="yes" <?php echo (get_option( 'nguyenprojectsidebar' ) == 'yes') ? 'selected' : ''; ?>>Yes</option>
                        <option value="no" <?php echo (get_option( 'nguyenprojectsidebar' ) == 'no') ? 'selected' : ''; ?>>No</option>
                    </select>
                </div>
                <div class="small"></div>
            </div>

            <div class="form-field">
                <h4><?php esc_html_e( 'Archive Template', 'made-theme-options' ); ?></h4>
                <div class="mb-3">
                    <select name="nguyen_project_archive_template">
                        <option value="no" <?php echo (get_option( 'nguyen_project_archive_template' ) == 'no') ? 'selected' : ''; ?>>No</option>
                        <option value="yes" <?php echo (get_option( 'nguyen_project_archive_template' ) == 'yes') ? 'selected' : ''; ?>>Yes</option>
                    </select>
                </div>
                <div class="small"></div>
            </div>

            <div class="form-field">
                <h4><?php esc_html_e( 'Single Template', 'made-theme-options' ); ?></h4>
                <div class="mb-3">
                    <select name="nguyen_project_single_template">
                        <option value="no" <?php echo (get_option( 'nguyen_project_single_template' ) == 'no') ? 'selected' : ''; ?>>No</option>
                        <option value="yes" <?php echo (get_option( 'nguyen_project_single_template' ) == 'yes') ? 'selected' : ''; ?>>Yes</option>
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