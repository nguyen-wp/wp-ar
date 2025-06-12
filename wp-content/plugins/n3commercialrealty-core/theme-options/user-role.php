<?php

class nguyen_Customize_User_Role {

    public function __construct() {
        var_dump(__FILE__);
        register_activation_hook( __FILE__, array( $this, 'activate' ) );
    }

    public static function activate() {
        // get the Editor role's object from WP_Role class
        $editor = get_role( 'editor' );

        // a list of plugin-related capabilities to add to the Editor role
        $caps = array(
                'install_plugins',
                'activate_plugins',
                'edit_plugins',
                'delete_plugins' 
        ); 

        // add all the capabilities by looping through them
        foreach ( $caps as $cap ) {
            $editor->add_cap( $cap );
        }
    }
}
