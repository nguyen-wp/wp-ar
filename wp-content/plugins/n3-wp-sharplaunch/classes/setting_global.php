<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * Class made_io_settings
 */
if(isset($_POST['submit'])) {
    
    // Display Sidebar
    if(isset($_POST['nguyen_api'])) {
        update_option('nguyen_api', $_POST['nguyen_api']);
    } else {
        update_option('nguyen_api', '');
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
                <h4><?php esc_html_e( 'API Key', 'made-theme-options' ); ?></h4>
                <div class="mb-3">
                    <label for="nguyen_api"><?php esc_html_e( 'API Key', 'made-theme-options' ); ?></label>
                    <input type="password" name="nguyen_api" id="nguyen_api" value="<?php echo esc_attr( get_option('nguyen_api') ); ?>" class="form-control w-100" placeholder="8653570e6a8aa22abd76433011c763bb07379748">
                </div>
                <div class="small"></div>
            </div>

            <p class="small">
                DEV Docs: <a href="https://docs.sharplaunch.com/apidocs.html" target="_blank">https://docs.sharplaunch.com/apidocs.html</a>
            </p>

            <!-- Submit Button -->
            <div class="form-field">
                <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php esc_attr_e( 'Save Changes', 'made-theme-options' ); ?>">
            </div>


        </form>


    </div>

</div>