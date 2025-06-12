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
    'title' => __( 'Tools', 'madelab' ),
    'id'    => 'made-theme-core-tool',
    'icon'  => 'bi bi-hdd-stack',
) );

Redux::setSection( $opt_name, array(
    'title'      => __( 'Database', 'madelab' ),
    'id'         => 'made-theme-core-tool-backup',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'made-theme-core-tool-backup-action',
            'type'     => 'js_button',
            'title'    => __( 'Backup Database', 'madelab' ),
            'script'        => array(
                    'url'       => plugin_dir_url( __DIR__ ) . '../admin/dist/js/js_button.dev.js',
                    'dep'       => array('jquery'),
                    'ver'       => time(),
                    'in_footer' => true
                ),
            'buttons'       => array(
                // array(
                //     'text'      => 'Add Date',
                //     'class'     => 'button-primary',
                //     'function'  => 'redux_add_date'
                // ),
                array(
                    'text'      => 'Backup mySQL',
                    'class'     => 'button-secondary',
                    'function'  => 'made_core_backup_db'
                ),
            ),
        ),
        array(
            'id'       => 'made-theme-core-tool-restore-action',
            'type'     => 'js_button',
            'title'    => __( 'Restore Database', 'madelab' ),
            'script'        => array(
                    'url'       => plugin_dir_url( __DIR__ ) . '../admin/dist/js/js_button.dev.js',
                    'dep'       => array('jquery'),
                    'ver'       => time(),
                    'in_footer' => true
                ),
            'buttons'       => array(
                array(
                    'text'      => 'Restore mySQL',
                    'class'     => 'button-secondary',
                    'function'  => 'made_core_restore_db'
                ),
            ),
        ),
    )
) );
Redux::setSection( $opt_name, array(
    'title'      => __( 'Site Backup', 'madelab' ),
    'id'         => 'made-theme-core-tool-compress',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'made-theme-core-tool-compress-action',
            'type'     => 'js_button',
            'title'    => __( 'Full Backup', 'madelab' ),
            'script'        => array(
                    'url'       => plugin_dir_url( __DIR__ ) . '../admin/dist/js/js_button.dev.js',
                    'dep'       => array('jquery'),
                    'ver'       => time(),
                    'in_footer' => true
                ),
            'buttons'       => array(
                array(
                    'text'      => 'Site Backup',
                    'class'     => 'button-secondary',
                    'function'  => 'made_core_compress'
                ),
            ),
        ),
    )
) );
Redux::setSection( $opt_name, array(
    'title'      => __( 'Rebuild Info', 'madelab' ),
    'id'         => 'made-theme-core-tool-rebuild',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'made-theme-core-tool-rebuild-action',
            'type'     => 'js_button',
            'title'    => __( 'Rebuild Dashboard Plugins/Theme Info', 'madelab' ),
            'script'        => array(
                    'url'       => plugin_dir_url( __DIR__ ) . '../admin/dist/js/js_button.dev.js',
                    'dep'       => array('jquery'),
                    'ver'       => time(),
                    'in_footer' => true
                ),
            'buttons'       => array(
                array(
                    'text'      => 'Rebuild',
                    'class'     => 'button-secondary',
                    'function'  => 'made_core_rebuild_db'
                ),
            ),
        ),
    )
) );
Redux::setSection( $opt_name, array(
    'title'      => __( 'Deregister CSS/JS', 'madelab' ),
    'id'         => 'made-theme-core-tool-remove-style-script',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'made-theme-core-tool-remove-style-script-frontend',
            'type'     => 'multi_text',
            'title'    => __( 'Remove CSS/JS on  FrontEnd', 'madelab' ),
            'subtitle' => __( 'Remove CSS/JS by handle ID', 'madelab' ),
            'desc'     => __( 'Make sure remove "-css", "-js" end of handle ID', 'madelab' ),
        ),
        array(
            'id'       => 'made-theme-core-tool-remove-style-script-backend',
            'type'     => 'multi_text',
            'title'    => __( 'Remove CSS/JS on  BackEnd', 'madelab' ),
            'subtitle' => __( 'Remove CSS/JS by handle ID', 'madelab' ),
            'desc'     => __( 'Make sure remove "-css", "-js" end of handle ID', 'madelab' ),
        ),
    )
) );