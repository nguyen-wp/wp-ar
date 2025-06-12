<?php
/**
* @package N3COMMERCIALREALTY 
* @subpackage Theme by Nguyen Pham
* https://nguyenpham.pro/cv
* @since 2021
*/

    $tabs = array(
        array(
            'id'      => 'made-help-tab-1',
            'title'   => __( 'Visit us on GitHub', 'made-theme-options' ),
            'content' => __( '<p>Visit us on GitHub: <a href="//github.com/baonguyenyam/" target="_blank">github.com/baonguyenyam/</a></p>', 'made-theme-options' )
        ),
        // array(
        //     'id'      => 'made-help-tab-2',
        //     'title'   => __( 'Documentation', 'made-theme-options' ),
        //     'content' => __( '<p>For full documentation on this field, visit: <a href="//github.com/baonguyenyam/" target="_blank">github.com/baonguyenyam/</a></p>', 'made-theme-options' )
        // )
    );
    Redux::set_help_tab( $opt_name, $tabs );

    // Set the help sidebar
    $content = __( '<p>The MADE WordPress theme for your website is easy to use to install. This WordPress theme made for the Restore Construction.</p>', 'made-theme-options' );
    Redux::set_help_sidebar( $opt_name, $content );

