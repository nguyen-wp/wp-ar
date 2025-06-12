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
        $gpc_core_pro = new GPC_Core_PROPRETIE();
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
                            <div class="team-description">
                                <div class="wp-block-post-content text-base">
                                    <h2 class="wp-block-heading text-xl font-bold mb-4">Description</h2>
                                    
                                    <div class="grid lg:grid-cols-5 gap-10">
                                        <div class="wp-block-post-content lg:col-span-3 2xl:col-span-3 mb-5">
                                            <?php 
                                            echo do_blocks(the_content());
                                            ?>
                                            <?php if ($fields['availabilities']) : ?>
                                                <hr class="my-10">
                                                <h3 class="wp-block-heading text-lg font-bold mb-4">Availabilities</h3>
                                                <?php 
                                                $loop = $fields['availabilities'];
                                                foreach ($loop as $item) : ?>
                                                    <div class="grid lg:grid-cols-3 gap-10">
                                                        <div class="wp-block-post-content lg:col-span-1 2xl:col-span-1 mb-5">
                                                            <h4 class="wp-block-heading text-base font-bold mb-2"><?php echo $item['name']; ?></h4>
                                                            <?php 
                                                                if ( $item['lease_type'] == 'gross' ) {
                                                                    echo '<span class="text-sm font-semibold py-[0.5] px-2 rounded uppercase border border-yellow-300 bg-yellow-400">Gross</span>';
                                                                } else if ( $item['lease_type'] == 'modified_gross' ) {
                                                                    echo '<span class="text-sm font-semibold py-[0.5] px-2 rounded uppercase border border-yellow-300 bg-yellow-400">Modified Gross</span>';
                                                                } else if ( $item['lease_type'] == 'modified_gross' ) {
                                                                    echo '<span class="text-sm font-semibold py-[0.5] px-2 rounded uppercase border border-cyan-300 bg-cyan-400">Escrow</span>';
                                                                } else if ( $item['lease_type'] == 'net_lease' || $item['lease_type'] == 'single_net'  || $item['lease_type'] == 'double_net'  || $item['lease_type'] == 'triple_net' || $item['lease_type'] == 'absolute_net' ) {
                                                                    echo '<span class="text-sm font-semibold py-[0.5] px-2 rounded uppercase border border-green-300 bg-green-400">' . ucwords($item['lease_type']) . '</span>';
                                                                } else if ( $item['lease_type'] == 'percentage_lease' ) {
                                                                    echo '<span class="text-sm font-semibold py-[0.5] px-2 rounded uppercase border border-blue-300 bg-blue-400">Percentage Lease</span>';
                                                                } else if ( $item['lease_type'] == 'negotiable' ) {
                                                                    echo '<span class="text-sm font-semibold py-[0.5] px-2 rounded uppercase border border-blue-300 bg-blue-400">Negotiable</span>';
                                                                } else {
                                                                    echo '<span class="text-sm font-semibold py-[0.5] px-2 rounded uppercase border border-gray-300 bg-gray-400">N/A</span>';
                                                                }
                                                            ?>
                                                        </div>
                                                        <div class="wp-block-post-content lg:col-span-2 2xl:col-span-2 mb-5">
                                                            <div class="grid grid-cols-2 gap-2">
                                                                <div class="wp-block-post-content">
                                                                    <h4 class="wp-block-heading text-base font-bold mb-2">Size</h4>
                                                                    <p class="text-gray-600"><?php echo $item['surface']; ?> <?php echo $item['surface_unit']; ?></p>
                                                                </div>
                                                                <div class="wp-block-post-content">
                                                                    <h4 class="wp-block-heading text-base font-bold mb-2">Price</h4>
                                                                    <p class="text-gray-600"><?php echo $item['price']; ?> <?php echo $item['price_postfix']; ?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            <?php 
                                            $file = $fields['brochure'];
                                            if ($file) : ?>
                                                <hr class="my-10">
                                                <div class="block mt-10">
                                                    <a href="<?php echo $file['url']; ?>" class="inline-block wp-block-button__link" target="_blank">
                                                        Download
                                                    </a>
                                                </div>
                                            <?php 
                                            endif;
                                            ?>
                                            <?php
                                            $gallery = $fields['gallery'];
                                            if ($gallery) : ?>
                                                <hr class="my-10">
                                                <h3 class="wp-block-heading text-lg font-bold mb-4">Gallery</h3>
                                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2">
                                                    <?php foreach ($gallery as $item) : ?>
                                                        <a href="<?php echo $item['url']; ?>" data-fancybox="gallery">
                                                            <img src="<?php echo $item['sizes']['thumbnail']; ?>" alt="<?php echo $item['alt']; ?>" class="w-full h-auto">
                                                        </a>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <?php
                                            $data = array(
                                                // Address
                                                array(
                                                    'name' => 'Status',
                                                    'value' => $fields['property_status']
                                                ),
                                                array(
                                                    'name' => 'Type',
                                                    'value' => $gpc_core_pro->displayTag($fields['general']['property_type'])
                                                ),
                                                array(
                                                    'name' => 'Offering Type',
                                                    'value' => $gpc_core_pro->displayTag($fields['general']['offering_type'])
                                                ),
                                                array(
                                                    'name' => 'Year Built',
                                                    'value' => $fields['general']['year_built']
                                                ),
                                                array(
                                                    'name' => 'Active Date',
                                                    'value' => $fields['general']['active_date']
                                                ),
                                                array(
                                                    'name' => 'Surface',
                                                    'value' => ($fields['general']['surface'] . ' ' . $fields['general']['surface_unit'])
                                                ),
                                                // Units Count
                                                array(
                                                    'name' => 'Units Count',
                                                    'value' => $fields['general']['units_count']
                                                ),
                                                // Price
                                                array(
                                                    'name' => 'Price',
                                                    'value' => ($fields['general']['price'] . ' ' . $fields['general']['price_postfix'])
                                                ),
                                                array(
                                                    'name' => 'Address',
                                                    'value' => ($fields['location_information']['address'] . ', ' . $fields['location_information']['city'] . ', ' . $fields['location_information']['state'] . ' ' . $fields['location_information']['zip_code'])
                                                ),
                                                array(
                                                    'name' => 'County',
                                                    'value' => $fields['location_information']['county']
                                                ),
                                                array(
                                                    'name' => 'State',
                                                    'value' => $gpc_core_pro->displayArrayState($fields['location_information']['state'])
                                                ),
                                                array(
                                                    'name' => 'Neighborhood',
                                                    'value' => $fields['location_information']['neighborhood']
                                                ),
                                            );
                                            $brokers = $fields['brokers'];
                                        ?>
                                        <div class="mb-5 lg:col-span-2 2xl:col-span-2">
                                            <?php if ($brokers) : ?>
                                                <dl class="text-sm flex flex-col sm:flex-row border-b border-gray-200 py-2">
                                                    <dt class="font-medium text-gray-900 whitespace-nowrap my-2 pr-2">Brokers:</dt>
                                                    <dd class="text-gray-700 sm:col-span-3">
                                                        <ul class="flex flex-col my-2 space-y-2">
                                                            <?php foreach ($brokers as $item) : 
                                                                $get_thumbnailByPostId = get_the_post_thumbnail_url($item->ID);
                                                                ?>
                                                                <li class="flex items-center">
                                                                    <?php if ( $get_thumbnailByPostId ) : ?>
                                                                        <img src="<?php echo $get_thumbnailByPostId; ?>" alt="<?php echo $item->post_title; ?>" class="w-6 h-6 rounded inline-block mr-1">
                                                                    <?php endif; ?>
                                                                    <?php echo $item->post_title; ?>
                                                                </li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </dd>
                                                </dl>
                                            <?php endif; ?>
                                            <?php foreach ($data as $item) : ?>
                                                <?php if($item['value'] && strlen($item['value'])>0) : ?>
                                                    <dl class="text-sm flex flex-col sm:flex-row border-b border-gray-200 py-2">
                                                        <dt class="font-medium text-gray-900 whitespace-nowrap pr-2"><?php echo $item['name']; ?>:</dt>
                                                        <dd class="text-gray-700 sm:col-span-3">
                                                            <?php 
                                                            if ($item['name'] == 'Status') {
                                                                if ( $item['value'] == 'pending' ) {
                                                                    echo '<span class="text-sm font-semibold py-[0.5] px-2 rounded uppercase border border-yellow-300 bg-yellow-400">Pending</span>';
                                                                } else if ( $item['value'] == 'escrow' ) {
                                                                    echo '<span class="text-sm font-semibold py-[0.5] px-2 rounded uppercase border border-cyan-300 bg-cyan-400">Escrow</span>';
                                                                } else if ( $item['value'] == 'sold' ) {
                                                                    echo '<span class="text-sm font-semibold py-[0.5] px-2 rounded uppercase border border-green-300 bg-green-400">Sold</span>';
                                                                } else if ( $item['value'] == 'active' ) {
                                                                    echo '<span class="text-sm font-semibold py-[0.5] px-2 rounded uppercase border border-blue-300 bg-blue-400">Active</span>';
                                                                } else {
                                                                    echo '<span class="text-sm font-semibold py-[0.5] px-2 rounded uppercase border border-gray-300 bg-gray-400">Unknown</span>';
                                                                }
                                                            } else {
                                                                echo $item['value']; 
                                                            }
                                                            ?>
                                                        </dd>
                                                    </dl>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                            
                                            <?php if ($fields['location_information']['latitude'] && $fields['location_information']['longitude']) : ?>
                                            <div class="flex flex-col sm:flex-row py-2">
                                                <?php echo do_shortcode('[n3_google_map address="' . $fields['location_information']['address'] . ' ' . $fields['location_information']['city'] . ' ' . $gpc_core_pro->displayArrayState($fields['location_information']['state']) . ' ' . $fields['location_information']['zip_code'] . ' ' . $fields['location_information']['country'] . '" latitude="' . $fields['location_information']['latitude'] . '" longitude="' . $fields['location_information']['longitude'] . '" height="300" zoom="17"]'); ?>
                                            </div>
                                            <?php endif; ?>
                                            <?php if (get_option('nguyenpropertiesidebar') !== 'no') : ?>
                                                <div clas="sidebar">
                                                    <?php 
                                                        // if (file_exists(get_template_directory() . '/patterns/sidebar-propertie.php')) {
                                                        //     echo do_blocks( '<!-- wp:template-part {"slug":"sidebar-propertie"} /-->' );
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