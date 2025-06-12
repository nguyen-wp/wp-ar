<?php

function madelab_add_mce_button() {
    if ( !current_user_can( 'edit_posts' ) &&  !current_user_can( 'edit_pages' ) ) {
        return;
    }
    if ( 'true' == get_user_option( 'rich_editing' ) ) {
        add_filter( 'mce_external_plugins', 'madelab_add_tinymce_plugin' );
        add_filter( 'mce_buttons', 'madelab_register_mce_button' );
        if ( class_exists( 'WooCommerce' ) ) {
            add_filter( 'mce_external_plugins', 'madelab_add_tinymcewoocomerce_plugin' );
            add_filter( 'mce_buttons', 'madelab_register_mcewoocomerce_button' );
        }
        add_filter( 'mce_external_plugins', 'madelab_add_tinymceshortcodes_plugin' );
        add_filter( 'mce_buttons', 'madelab_register_mceshortcodes_button' );
    }
}
add_action('admin_head', 'madelab_add_mce_button');

function madelab_register_mce_button( $buttons ) {
    array_push( $buttons, 'madelab_mce_dropbutton' );
    array_push( $buttons, 'madelab_mce_dropbutton2' );
    return $buttons;
}
function madelab_register_mcewoocomerce_button( $buttons ) {
    array_push( $buttons, 'madelab_mce_dropbuttonwoocomerce' );
    return $buttons;
}
function madelab_register_mceshortcodes_button( $buttons ) {
    array_push( $buttons, 'madelab_mce_dropbuttonshortcodes' );
    return $buttons;
}
function madelab_add_tinymce_plugin( $plugin_array ) {
    $plugin_array['madelab_mce_dropbutton'] = N3COMMERCIALREALTY_CORE_URL .'/admin/assets/js/tinymce.prod.js';
    return $plugin_array;
}

function madelab_add_tinymcewoocomerce_plugin( $plugin_array ) {
$plugin_array['madelab_mce_dropbuttonwoocomerce'] = N3COMMERCIALREALTY_CORE_URL .'/admin/assets/js/tinymce-woocomerce.prod.js';
    return $plugin_array;
}
function madelab_add_tinymceshortcodes_plugin( $plugin_array ) {
$plugin_array['madelab_mce_dropbuttonshortcodes'] = N3COMMERCIALREALTY_CORE_URL .'/admin/assets/js/tinymce-shortcodes.prod.js';
    return $plugin_array;
}