<?php
// -> START Information
if ( file_exists( N3COMMERCIALREALTY_CORE_PATH . 'docs/plugins.html' ) ) {
    Redux_Functions::init_wp_filesystem();
    global $wp_filesystem;
    $output = $wp_filesystem->get_contents( N3COMMERCIALREALTY_CORE_PATH . 'docs/plugins.html' );
    echo $output;
}
?>