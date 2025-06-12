<div class="wrap madetable">
    <div class="form-wrap">

        <?php
            if (isset($_POST['rebuild'])) {
                global $wp_filesystem; 
                if ( ! function_exists( 'get_plugins' ) ) {
                    require_once ABSPATH . 'wp-admin/includes/plugin.php';
                }
                $get_plugins = get_plugins();
                if ( empty( $wp_filesystem ) ) {
                    require_once( ABSPATH .'/wp-admin/includes/file.php' );
                    WP_Filesystem();
                }

                if ( file_exists( N3COMMERCIALREALTY_CORE_PATH . 'docs/plugins.html' ) ) {
                    unlink( N3COMMERCIALREALTY_CORE_PATH . 'docs/plugins.html' );
                }
                if ( file_exists( N3COMMERCIALREALTY_CORE_PATH . 'docs/themeinfo.html' ) ) {
                    unlink( N3COMMERCIALREALTY_CORE_PATH . 'docs/themeinfo.html' );
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

                echo '<div class="alert alert-success" role="alert">Rebuild success!</div>';

            }
        ?>
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

        <p>Rebuild Plugins/Theme Information</p>
        <!-- Warning box -->
        <div style="margin: 1rem 0; display: block; background: #ffcfcf; border: 1px solid #d28585; padding: 1rem; border-radius: 5px;">
            <h3 style="margin: 0 0 .5rem 0; font-size: 1.2rem; font-weight: 600; color: #8b4545;">Warning</h3>
            <p style="margin: 0; font-size: 1rem; color: #8b4545;">This action will rebuild your plugins/theme information. All data currently in the database will be lost.</p>
            <hr style="margin: 1rem 0; border: 1px solid #d28585;">
            <form method="post" action="">
                <div class="mb-1">
                    <label for="">Plugins Info: <strong><code><?php echo N3COMMERCIALREALTY_CORE_PATH . 'docs/plugins.html' ?></code></strong></label> 
                </div>
                <div class="mb-2">
                    <label for="">Theme Info: <strong><code><?php echo N3COMMERCIALREALTY_CORE_PATH . 'docs/themeinfo.html' ?></code></strong></label>
                </div>
                <button type="submit" name="rebuild" class="button button-primary">Rebuild now</button>
            </form>
        </div>
    </div>
</div>