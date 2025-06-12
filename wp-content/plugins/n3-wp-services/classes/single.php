<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
    	<meta charset="<?php bloginfo( 'charset' ); ?>">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
    	<?php
    	$title = get_the_title();
    	$site_name = get_bloginfo('name');
    	$page_title = $title . ' - ' . $site_name;
        ob_start();
        block_header_area();
        $str = ob_get_clean();
        $block_header = do_blocks($str);
        ob_start();
        block_footer_area();
        $str = ob_get_clean();
        $block_footer = do_blocks($str);
        $fields = get_fields();
    	?>
    	<title><?php echo $page_title; ?> - </title>
    	<?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
        <?php wp_body_open(); ?>
        <div class="wp-site-blocks-null">
            <header class="wp-block-template-part">
                <?php echo $block_header; ?>
            </header>
            <?php if (has_post_thumbnail()) : ?>
                <style>
                    .n3-cover {
                        background-image: url('<?php echo get_the_post_thumbnail_url(); ?>');
                        background-position: center center;
                        background-size: cover;
                        min-height: 250px;
                        margin-bottom: 2rem;
                        @media (min-width: 768px) {
                            min-height: 400px;
                        }
                        @media (min-width: 1024px) {
                            min-height: 500px;
                        }
                    }
                </style>
                <div class="wp-block-cover has-background-dim n3-cover">
                    <div class="wp-block-cover__inner-container"></div>
                </div>
            <?php endif; ?>
            <main class="wp-block-group">
                <div class="wp-block-group has-global-padding is-layout-constrained wp-block-group-is-layout-constrained">
                    <div class="wp-block-group alignwide">
                        <div class="my-10">
                            <h1 class="wp-block-heading text-3xl font-bold mb-10">
                                <?php echo $title; ?>
                            </h1>
                            <div class="description">
                                <div class="wp-block-post-content text-base">
                                    <h2 class="wp-block-heading text-xl font-bold mb-4">Description</h2>
                                    <div class="grid lg:grid-cols-5 gap-10">
                                        <div class="wp-block-post-content lg:col-span-3 2xl:col-span-4 mb-5">
                                            <?php the_content(); ?>
                                        </div>
                                        <div class="wp-block-post-content lg:col-span-2 2xl:col-span-1">
                                            <?php if (get_option('nguyenservicesidebar') !== 'no') : ?>
                                                <div clas="sidebar">
                                                    <?php 
                                                        // if (file_exists(get_template_directory() . '/patterns/sidebar-service.php')) {
                                                        //     echo do_blocks( '<!-- wp:template-part {"slug":"sidebar-service"} /-->' );
                                                        // } else {
                                                            echo do_blocks( '<!-- wp:template-part {"slug":"sidebar"} /-->' );
                                                        // }
                                                    ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="wp-block-template-part site-footer">
                <?php echo $block_footer; ?>
            </footer>
        </div>
        <?php wp_footer(); ?>
    </body>
</html>