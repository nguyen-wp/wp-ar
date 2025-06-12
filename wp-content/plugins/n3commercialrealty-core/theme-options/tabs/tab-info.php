<?php
/**
* @package N3COMMERCIALREALTY 
* @subpackage Theme by Nguyen Pham
* https://nguyenpham.pro/cv
* @since 2021
*/

$output = '';
$themeinforesult = '';
if ( file_exists( N3COMMERCIALREALTY_CORE_PATH . 'docs/plugins.html' ) ) {
    Redux_Functions::init_wp_filesystem();
    global $wp_filesystem;
    $output = $wp_filesystem->get_contents( N3COMMERCIALREALTY_CORE_PATH . 'docs/plugins.html' );
}
if ( file_exists( N3COMMERCIALREALTY_CORE_PATH . 'docs/themeinfo.html' ) ) {
    Redux_Functions::init_wp_filesystem();
    global $wp_filesystem;
    $themeinforesult = $wp_filesystem->get_contents( N3COMMERCIALREALTY_CORE_PATH . 'docs/themeinfo.html' );
}

// -> START Information
Redux::setSection( $opt_name, array(
    'title' => __( 'System Information', 'madelab' ),
    'id'    => 'made-theme-core-info',
    'icon'  => 'bi bi-exclamation-circle',
) );

Redux::setSection( $opt_name, array(
    'title'      => __( 'Plugins Information', 'madelab' ),
    'id'         => 'made-theme-core-info-plugins',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'made-theme-core-info-plugins-info',
            'full_width' => true,
            'type'     => 'raw',
            'content'  =>  $output,
        ),
    )
) );
Redux::setSection( $opt_name, array(
    'title'      => __( 'Theme Information', 'madelab' ),
    'id'         => 'made-theme-core-info-theme',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'made-theme-core-info-theme-info',
            'full_width' => true,
            'type'     => 'raw',
            'content'  =>  $themeinforesult,
        ),
    )
) );
