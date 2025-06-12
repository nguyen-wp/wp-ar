<div class="n3-faqs-group <?php echo $layout; ?>-list <?php echo $layout; ?> <?php echo $class; ?>">
    <?php 
    $i = 0;
    while ( $query->have_posts() ) : $query->the_post();
    ?>
        <div class="n3-faqs-item accordion-item<?php echo ($active_first == 'yes' & $i == 0) ? ' is-active' : ''; ?>">
            <h2 class="faq_title accordion-title">
                <?php the_title(); ?>
            </h2>
            <div class="faq_content accordion-panel">
                <?php the_content(); ?>
            </div>
        </div>
    <?php 
$i++;
endwhile; ?>
</div>