<?php
    /**
* @package N3COMMERCIALREALTY 
* @subpackage Theme by Nguyen Pham
* https://nguyenpham.pro/cv
* @since 2021
*/

// -> START layout
    Redux::setSection( $opt_name, array(
        'title' => __( 'Global configuration', 'made-theme-options' ),
        'icon'  => 'bi bi-sliders',
        'id'         => 'made-theme-global',
	));

    Redux::setSection( $opt_name, array(
		'title' => __( 'Develop Tool', 'made-theme-options' ),
        'id'         => 'made-theme-global-dev',
        'subsection' => true,
		'fields'     => array(
			array(
				'id'       => 'made-theme-global-dev-toolbar',
                'type'     => 'switch',
                'title'    => __( 'FrontEnd Admin Toolbar', 'made-theme-options' ),
                'default'  => 1,
                'on'       => 'On',
                'off'      => 'Off',
            ),
            array(
				'id'       => 'made-theme-global-dev-toogle-tag',
                'type'     => 'switch',
                'title'    => __( 'FrontEnd Tag Viewer', 'made-theme-options' ),
                'default'  => 1,
                'on'       => 'On',
                'off'      => 'Off',
            ),
		),
    ) );
