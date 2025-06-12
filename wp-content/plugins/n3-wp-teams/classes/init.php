<div class="n3-teams-group <?php echo $layout; ?>-list <?php echo $layout; ?> <?php echo $class; ?>">
    <?php 
    $i = 0;
    while ( $query->have_posts() ) : $query->the_post();
    ?>
        <div class="n3-teams-item">
            <?php if ( has_post_thumbnail() ) : ?>
                <div class="team_thumbnail object-cover">
                    <?php the_post_thumbnail(); ?>
                </div>
            <?php endif; ?> 
            <h2 class="team_title">
                <?php the_title(); ?>
            </h2>
            <p>
                <button data-fancybox data-src="#dialog-content-<?php echo get_the_ID(); ?>">Read More</button>
            </p>
            <div class="team_content <?php echo $item_class;?>" id="dialog-content-<?php echo get_the_ID(); ?>" style="display: none;">
                <?php the_content(); ?>
            </div>
        </div>
    <?php 
    $i++;
    endwhile; 
    ?>
</div>