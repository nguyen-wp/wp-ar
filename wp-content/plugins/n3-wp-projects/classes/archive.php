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
            <main class="wp-block-group">
                <div class="wp-block-group has-global-padding is-layout-constrained wp-block-group-is-layout-constrained">
                    <div class="wp-block-group alignwide">
                        <div class="flex flex-col md:flex-row my-10 text-base">
                            <div class="w-full">
                                <h1 class="wp-block-heading text-3xl font-bold mb-10"><?php echo get_the_archive_title(); ?></h1>
                                <?php if (have_posts()) :?>
                                    <div class="grid gap-10">
                                        <?php while (have_posts()) : the_post(); 
                                            $fields = get_fields();
                                        ?>
                                            <div class="wp-block-post-content text-base">
                                                <h2 class="wp-block-heading text-xl font-bold mb-4">
                                                    <a href="<?php the_permalink(); ?>">
                                                        <?php the_title(); ?>
                                                    </a>
                                                </h2>
                                                <div class="wp-block-post-content text-base">
                                                    <?php the_excerpt(); ?>
                                                </div>
                                            </div>
                                        <?php endwhile; ?>
                                    </div>
                                <?php else : ?>
                                    <p>No posts found</p>
                                <?php endif; ?>
                            </div>
                            <?php if (get_option('nguyenprojectsidebar_archive') !== 'no') : ?>
                                <div clas="sidebar">
                                    <?php 
                                        // if (file_exists(get_template_directory() . '/patterns/sidebar-project.php')) {
                                        //     echo do_blocks( '<!-- wp:template-part {"slug":"sidebar-project"} /-->' );
                                        // } else {
                                            echo do_blocks( '<!-- wp:template-part {"slug":"sidebar"} /-->' );
                                        // }
                                    ?>
                                </div>
                            <?php endif; ?>
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