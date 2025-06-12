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
        $gpc_core_map = new GPC_Core_MAP();
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
                            <div class="job-description">
                                <div class="wp-block-post-content text-base">
                                    <h2 class="wp-block-heading text-xl font-bold mb-4">Location</h2>
                                    <div class="grid lg:grid-cols-5 gap-10">
                                        <div class="wp-block-post-content lg:col-span-3 2xl:col-span-4 mb-5">
                                            <?php if ($fields['map']['latitude'] && $fields['map']['longitude']) : ?>
                                            <div class="gmap mb-10">
                                                <?php echo do_shortcode('[n3_google_map address="' . $fields['map']['address'] . ' ' . $fields['map']['city'] . ' ' . $gpc_core_map->displayArrayState($fields['map']['state']) . ' ' . $fields['map']['zip_code'] . ' ' . $fields['map']['country'] . '" latitude="' . $fields['map']['latitude'] . '" longitude="' . $fields['map']['longitude'] . '" height="400" zoom="17"]'); ?>
                                            </div>
                                            <?php endif; ?>
                                            <div class="mb-10">
                                                <?php the_content(); ?>
                                            </div>
                                        </div>
                                        <?php
                                            $data = array(
                                                // Address
                                                array(
                                                    'name' => 'Address',
                                                    'value' => $fields['map']['address']
                                                ),
                                                array(
                                                    'name' => 'City',
                                                    'value' => $fields['map']['city']
                                                ),
                                                array(
                                                    'name' => 'State',
                                                    'value' => $gpc_core_map->displayArrayState($fields['map']['state'])
                                                ),
                                                // Postal Code
                                                array(
                                                    'name' => 'Postal Code',
                                                    'value' => $fields['map']['zip_code']
                                                ),
                                                array(
                                                    'name' => 'Country',
                                                    'value' => $fields['map']['country']
                                                ),
                                                // Latitude
                                                array(
                                                    'name' => 'Latitude',
                                                    'value' => $fields['map']['latitude']
                                                ),
                                                // Longitude
                                                array(
                                                    'name' => 'Longitude',
                                                    'value' => $fields['map']['longitude']
                                                ),
                                                // Phone
                                                array(
                                                    'name' => 'Phone',
                                                    'value' => $fields['map']['phone']
                                                ),
                                                // Email
                                                array(
                                                    'name' => 'Email',
                                                    'value' => $fields['map']['email']
                                                ),
                                            );
                                        ?>
                                        <div class="mb-5 lg:col-span-2 2xl:col-span-1">
                                            <?php foreach ($data as $item) : ?>
                                                <?php if($item['value'] && strlen($item['value'])>0) : ?>
                                                    <dl class="text-sm flex flex-col sm:flex-row border-b border-gray-200 py-2">
                                                        <dt class="font-medium text-gray-900 whitespace-nowrap pr-2"><?php echo $item['name']; ?>:</dt>
                                                        <dd class="text-gray-700 sm:col-span-3"><?php echo $item['value']; ?></dd>
                                                    </dl>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                            <?php if ($fields['map']['url']) : ?>
                                                <dl class="text-sm flex flex-col sm:flex-row border-b border-gray-200 py-2">
                                                    <dt class="font-medium text-gray-900 whitespace-nowrap pr-2">Website:</dt>
                                                    <dd class="text-gray-700 sm:col-span-3">
                                                        <a href="<?php echo $fields['map']['url']['url']; ?>" target="_blank" rel="noopener noreferrer">
                                                            <?php echo $fields['map']['url']['title']; ?>
                                                        </a>
                                                    </dd>
                                                </dl>
                                            <?php endif; ?>
                                            <?php if (get_option('nguyenmapasidebar') !== 'no') : ?>
                                                <div clas="sidebar">
                                                    <?php 
                                                        // if (file_exists(get_template_directory() . '/patterns/sidebar-map.php')) {
                                                        //     echo do_blocks( '<!-- wp:template-part {"slug":"sidebar-map"} /-->' );
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