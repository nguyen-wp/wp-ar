<?php
// -> START Information
if ( file_exists( N3COMMERCIALREALTY_CORE_PATH . 'docs/themeinfo.html' ) ) {
    Redux_Functions::init_wp_filesystem();
    global $wp_filesystem;
    $output = $wp_filesystem->get_contents( N3COMMERCIALREALTY_CORE_PATH . 'docs/themeinfo.html' );
    echo $output;
}
?>