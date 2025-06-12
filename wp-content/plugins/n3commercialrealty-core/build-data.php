<?php 
// BUILD DATA HTML
if ( !file_exists( N3COMMERCIALREALTY_CORE_PATH . 'docs/plugins.html' ) ) {
    global $wp_filesystem; 
    if ( ! function_exists( 'get_plugins' ) ) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }
    $get_plugins = get_plugins();
    if ( empty( $wp_filesystem ) ) {
        require_once( ABSPATH .'/wp-admin/includes/file.php' );
        WP_Filesystem();
    }
    $output = '';
    $output .= '<ul class="list-group">';
    foreach ($get_plugins as $key => $value) {
        if (strpos($key, 'madelab-') !== false || strpos($key, 'nguyen-app') !== false) {
            $plugin_data = get_plugin_data(WP_PLUGIN_DIR . '/' . $key);
            $output .= '<li class="list-group-item list-group-item-action m-0">';
            $output .= '<div class="d-flex w-100 justify-content-between align-items-start"><div class="text-dark fw-bold">'.$plugin_data['Name'].'</div><small class="badge bg-light text-muted">'.$plugin_data['Version'].'</small></div>';
            $output .= '<p class="mt-1 text-muted mb-0">'.$plugin_data['Description'].'</p>';
            $output .= '<p class="mt-1 mb-0"><a href="'.$plugin_data['PluginURI'].'">'.$plugin_data['PluginURI'].'</a></p>';
            $output .= '</li>';
        }
    }
    $output .= '</ul>';
    $wp_filesystem->put_contents( N3COMMERCIALREALTY_CORE_PATH . 'docs/plugins.html', $output, FS_CHMOD_FILE );
}
if ( !file_exists( N3COMMERCIALREALTY_CORE_PATH . 'docs/themeinfo.html' ) ) { 
    global $wp_filesystem; 
    if ( empty( $wp_filesystem ) ) {
        require_once( ABSPATH .'/wp-admin/includes/file.php' );
        WP_Filesystem();
    }
    $themeinfo = '';
    $themeinfo .= '<ul class="list-group">';
    $themeinfo .= '<li class="list-group-item list-group-item-action list-group-item-primary m-0">';
    $themeinfo .= '<div class="d-flex w-100 justify-content-between align-items-start"><div class="text-dark fw-bold">'.wp_get_theme()->get('Name').'</div><small class="badge bg-light text-muted">'.wp_get_theme()->get('Version').'</small></div>';
    $themeinfo .= '<p class="mt-1 text-muted mb-0">'.wp_get_theme()->get('Description').'</p>';
    $themeinfo .= '<p class="mt-1 mb-0"><a href="'.wp_get_theme()->get('ThemeURI').'">'.wp_get_theme()->get('ThemeURI').'</a></p>';
    $themeinfo .= '<p class="mt-1 mb-0"><strong>Author:</strong> <code>'.wp_get_theme()->get('Author').'</code></p>';
    $themeinfo .= '<p class="mt-1 mb-0"><strong>TextDomain:</strong> <code>'.wp_get_theme()->get('TextDomain').'</code></p>';
    $themeinfo .= '</li>';
    $themeinfo .= '<li class="list-group-item list-group-item-action m-0"><strong>Upload Path:</strong> <code>'.wp_get_upload_dir()['baseurl'].'</code></li>';
    $themeinfo .= '<li class="list-group-item list-group-item-action m-0"><strong>Them Folder:</strong> <code>'.get_stylesheet().'</code></li>';
    $themeinfo .= '<li class="list-group-item list-group-item-action m-0"><strong>HTTP Version:</strong> <code>'.$_SERVER['SERVER_PROTOCOL'].'</code></li>';
    $themeinfo .= '<li class="list-group-item list-group-item-action m-0"><strong>PHP Version:</strong> <code>'.phpversion().'</code></li>';
    $themeinfo .= '<li class="list-group-item list-group-item-action m-0"><strong>Server Information:</strong> <code>'.$_SERVER['SERVER_SOFTWARE'].'</code></li>';
    $themeinfo .= '</ul>';
    $wp_filesystem->put_contents( N3COMMERCIALREALTY_CORE_PATH . 'docs/themeinfo.html', $themeinfo, FS_CHMOD_FILE );
}