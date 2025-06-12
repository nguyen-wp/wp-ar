<?php
/**
* @package N3COMMERCIALREALTY 
* @subpackage Theme by Nguyen Pham
* https://nguyenpham.pro/cv
* @since 2021
*/

// BACKUP DB

// -> START Backup Tab
Redux::setSection( $opt_name, array(
    'title' => __( 'CDN Library', 'made-theme-options' ),
    'id'    => 'made-theme-core-cdn',
    'icon'  => 'bi bi-cloud-fog2',
) );

Redux::setSection( $opt_name, array(
    'title'      => __( 'Register CSS/JS FrontEnd', 'madelab' ),
    'id'         => 'made-theme-core-tool-add-style-frontend',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'made-theme-core-tool-add-style-script-frontend',
            'type'     => 'multi_text',
            'title'    => __( 'Add JS on FrontEnd', 'madelab' ),
            'default'  => array(
                'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js',
                'https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js',
            ),
        ),
        array(
            'id'       => 'made-theme-core-tool-add-style-css-frontend',
            'type'     => 'multi_text',
            'title'    => __( 'Add CSS on FrontEnd', 'madelab' ),
            'default'  => array(
                'https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css',
                'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css',
                'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css',
            ),
        ),
    )
) );
Redux::setSection( $opt_name, array(
    'title'      => __( 'Register CSS/JS BackEnd', 'madelab' ),
    'id'         => 'made-theme-core-tool-add-style-backend',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'made-theme-core-tool-add-style-script-backend',
            'type'     => 'multi_text',
            'title'    => __( 'Add JS on BackEnd', 'madelab' ),
            'default'  => array(
                'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js',
            ),
        ),
        array(
            'id'       => 'made-theme-core-tool-add-style-css-backend',
            'type'     => 'multi_text',
            'title'    => __( 'Add CSS on BackEnd', 'madelab' ),
            'default'  => array(
                'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css',
                'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css',
            ),
        ),
    )
) );