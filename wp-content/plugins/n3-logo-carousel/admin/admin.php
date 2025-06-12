<?php
/**
 * Admin Support Page
*/

class GPLC_Admin_Page {
    /**
     * Contructor 
    */
    public function __construct(){
        // add_action( 'admin_menu', [ $this, 'aclb_plugin_admin_page' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'aclb_admin_page_assets' ] );
    }

    // Admin Assets
    public function aclb_admin_page_assets($screen) {
        if( 'tools_page_aclb-carousel' == $screen ) {
            wp_enqueue_style( 'admin-asset', plugins_url('css/admin-page.css', __FILE__ ) );
        }
    }


    // Admin Page
    public function aclb_plugin_admin_page(){
        add_submenu_page( 'tools.php', __('N3 Logo Carousel Block','n3-logo-carousel-block'), __('N3 Logo Carousel Block','n3-logo-carousel-block'), 'manage_options', 'aclb-carousel', [ $this, 'aclb_admin_page_content_callback' ] );
    }
    public function aclb_admin_page_content_callback(){
        ?>
            <div class="admin_page_container">
                <div class="plugin_head">
                    <div class="head_container">
                        <h1 class="plugin_title"><?php echo esc_html__('N3 Logo Carousel Block','n3-logo-carousel-block'); ?></h1>
                        <h4 class="plugin_subtitle"><?php echo esc_html__('A Custom Gutenberg Block to Create an excellent clients N3 Logo Carousel in your Gutenberg Editor', 'n3-logo-carousel-block'); ?></h4>
                        <div class="support_btn">
                            <a href="https://makegutenblock.com/contact" target="_blank" style="background: #D37F00"><?php echo esc_html__('Contact Me','n3-logo-carousel-block'); ?></a>
                            <a href="https://wordpress.org/plugins/n3-logo-carousel-block/#reviews" target="_blank" style="background: #0174A2"><?php echo esc_html__('Rate Plugin','n3-logo-carousel-block'); ?></a>
                        </div>
                    </div>
                </div>
                <div class="plugin_body">
                    <div class="doc_video_area">
                        <div class="doc_video">
                            <iframe width="100%" height="350" src="https://www.youtube.com/embed/YteoGr18R_Y" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    </div>
                    <div class="support_area">
                        <div class="single_support">
                            <h4 class="support_title"> <?php echo esc_html__('Freelance Work','n3-logo-carousel-block'); ?></h4>
                            <div class="support_btn">
                                <a href="https://www.fiverr.com/users/devs_zak/" target="_blank" style="background: #1DBF73"><?php echo esc_html__('Fiverr','n3-logo-carousel-block'); ?></a>
                                <a href="https://www.upwork.com/freelancers/~010af183b3205dc627" target="_blank" style="background: #14A800"><?php echo esc_html__('UpWork','n3-logo-carousel-block'); ?></a>
                            </div>
                        </div>
                        <div class="single_support">
                            <h4 class="support_title"><?php echo esc_html__('Get Support','n3-logo-carousel-block'); ?></h4>
                            <div class="support_btn">
                                <a href="https://makegutenblock.com/contact" target="_blank" style="background: #002B42"><?php echo esc_html__('Contact','n3-logo-carousel-block'); ?></a>
                                <a href="mailto:zbinsaifullah@gmail.com" style="background: #EA4335">
                                <?php echo esc_html__('Send Mail','n3-logo-carousel-block'); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php 
    }
}
 new GPLC_Admin_Page();