<div class="n3-careers-group layout-<?php echo $layout; ?> <?php echo $layout; ?> <?php echo $class; ?>">
    <?php while ( $query->have_posts() ) : $query->the_post(); ?>

        <div class="wp-block-post-content text-base">
            <h2 class="wp-block-heading text-xl font-bold mb-4">
                <a href="<?php the_permalink(); ?>">
                    <?php the_title(); ?>
                </a>
            </h2>
            <div class="mb-5 leading-none space-x-3">
                <?php
                    $fields = get_fields();
                    $data = array(
                        array(
                            'name' => 'City',
                            'value' => $fields['city']
                        ),
                        array(
                            'name' => 'State',
                            'value' => $this->displayArrayState($fields['state'])
                        ),
                    );
                    foreach ($data as $item) : ?>
                    <?php if($item['value'] && strlen($item['value'])>0) : ?>
                        <span class="leading-none text-sm">
                            <span class="font-medium text-gray-900 whitespace-nowrap"><?php echo $item['name']; ?>:</span>
                            <span class="text-gray-700"><?php echo $item['value']; ?></span>
                        </span>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <div class="wp-block-post-content text-base">
                <?php the_excerpt(); ?>
            </div>
            <p>
                <a href="<?php the_permalink(); ?>">Read More</a>
            </p>
        </div>

    <?php endwhile; ?>
</div>