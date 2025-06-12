<!-- OWL Carousel -->
<div class="n3_testimonial layout-<?php echo $layout;?>" id="made_owl-<?php echo $id; ?>">
    <div class="testimonial-main owl-carousel owl-theme">
        <?php 
        $index = 0;
        while ( $query->have_posts() ) : $query->the_post();
            $post = get_post();
            $acf = get_fields($post->ID);
            $acf_image = isset($acf['photo']) ? $acf['photo'] : '';
            $acf_author = isset($acf['author']) ? $acf['author'] : '';
            $acf_company = isset($acf['company']) ? $acf['company'] : '';
            $acf_position = isset($acf['position']) ? $acf['position'] : '';
            $acf_rank = isset($acf['rank']) ? (int)$acf['rank'] : 0;
            $acf_date = isset($acf['date']) ? $acf['date'] : '';
            $acf_url = isset($acf['url']) ? $acf['url'] : '';
            $acf_facebook = isset($acf['facebook']) ? $acf['facebook'] : '';
            $acf_twitter = isset($acf['twitter']) ? $acf['twitter'] : '';
            $acf_linkedin = isset($acf['linkedin']) ? $acf['linkedin'] : '';
            $acf_instagram = isset($acf['instagram']) ? $acf['instagram'] : '';
            $acf_youtube = isset($acf['youtube']) ? $acf['youtube'] : '';
            $acf_whatsapp = isset($acf['whatsapp']) ? $acf['whatsapp'] : '';
            $acf_tiktok = isset($acf['tiktok']) ? $acf['tiktok'] : '';
            $index = 1;
        ?>
        <div class="item item-<?php echo $post->ID; ?>">
            <div class="testimonial">
                <?php if($layout == 'quote') { ?>
                    <div class="row">
                        <div class="col-md-auto">
                            <?php if($acf_image) { ?>
                                <div class="testimonial-image">
                                    <img src="<?php echo $acf_image['url']; ?>" alt="<?php echo $acf_image['alt']; ?>" />
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-md">
                            <div class="quote">
                                <i class="fas start fa-quote-left"></i>
                                <div class="testimonial-content">
                                    <div>
                                        <?php echo do_shortcode(wpautop($post->post_content)); ?>
                                    </div>
                                    <footer>
                                        <?php if($acf_rank) { ?>
                                            <div class="testimonial-rank">
                                                <?php if($acf_rank > 0) { ?>
                                                    <span class="rank rank-<?php echo $acf_rank; ?>">
                                                        <?php for($i = 1; $i <= $acf_rank; $i++) { ?>
                                                            <i class="fas fa-star"></i>
                                                        <?php } ?>
                                                    </span>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
                                        <?php if($acf_author) { ?>
                                        <div class="testimonial-author">
                                            <strong><?php echo $acf_author; ?></strong>
                                        </div>
                                        <?php } ?>
                                        <?php if($acf_company) { ?>
                                            <div class="testimonial-company">
                                                <i>
                                                    <?php echo $acf_company; ?>
                                                </i>
                                            </div>
                                        <?php } ?>
                                    </footer>
                                </div>
                                <i class="fas end fa-quote-right"></i>
                            </div>
                        </div>
                    </div>
                <?php } else if($layout == 'modern') { ?>
                    <?php if($acf_image) { ?>
                        <div class="testimonial-image">
                            <img src="<?php echo $acf_image['url']; ?>" alt="<?php echo $acf_image['alt']; ?>" />
                        </div>
                    <?php } ?>
                    <?php if($acf_rank) { ?>
                        <div class="testimonial-rank">
                            <?php if($acf_rank > 0) { ?>
                                <span class="rank rank-<?php echo $acf_rank; ?>">
                                    <?php for($i = 1; $i <= $acf_rank; $i++) { ?>
                                        <i class="fas fa-star"></i>
                                    <?php } ?>
                                </span>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <div class="testimonial-content">
                        <?php echo do_shortcode(wpautop($post->post_content)); ?>
                    </div>
                    <?php if($acf_author) { ?>
                        <div class="testimonial-author">
                            <strong><?php echo $acf_author; ?></strong>
                        </div>
                    <?php } ?>
                    <?php if($acf_company) { ?>
                        <div class="testimonial-company">
                            <i>
                                <?php echo $acf_company; ?>
                            </i>
                        </div>
                    <?php } ?>
                <?php } else if($layout == 'azure') { ?>
                    <blockquote>
                        <?php echo do_shortcode(wpautop($post->post_content)); ?>
                        <footer>
                            <?php if($acf_author) { ?>
                            <div class="testimonial-author">
                                <strong><?php echo $acf_author; ?></strong>
                            </div>
                            <?php } ?>
                            <?php if($acf_company) { ?>
                                <div class="testimonial-company">
                                    <i>
                                        - <?php echo $acf_company; ?>
                                    </i>
                                </div>
                            <?php } ?>
                        </footer>
                    </blockquote>
                <?php } else if($layout == 'minimal') { ?>
                    <div class="testimonial-content">
                        <?php echo do_shortcode(wpautop($post->post_content)); ?>
                    </div>
                    <?php if($acf_rank) { ?>
                        <div class="testimonial-rank">
                            <?php if($acf_rank > 0) { ?>
                                <span class="rank rank-<?php echo $acf_rank; ?>">
                                    <?php for($i = 1; $i <= $acf_rank; $i++) { ?>
                                        <i class="fas fa-star"></i>
                                    <?php } ?>
                                </span>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <?php if($acf_author) { ?>
                        <div class="testimonial-author">
                            <strong><?php echo $acf_author; ?></strong>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <div class="testimonial-content">
                        <?php echo do_shortcode(wpautop($post->post_content)); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php 
            $index++;
            endwhile;
        ?>
    </div>
</div>
<script>
jQuery(document).ready(function() {
    var myowl<?php echo $id; ?> = jQuery('#made_owl-<?php echo $id; ?> .testimonial-main').owlCarousel({
        items: 1,
        margin: 10,
        loop: <?php echo $infinite; ?>,
        autoplay: <?php echo $autoplay; ?>,
        autoplayTimeout: <?php echo $speed; ?>,
        autoplayHoverPause: true,
        nav: <?php echo $arrows; ?>,
        dots: <?php echo $dots; ?>,
        autoHeight: <?php echo $autoheight; ?>,
        navText: ['<i class="fa-solid fa-arrow-left"></i>',
            '<i class="fa-solid fa-arrow-right"></i>'
        ],
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    }).on('changed.owl.carousel', function(event) {
        var current = event.item.index;
        jQuery('#made_owl-<?php echo $id; ?> .total .ix').text(current + 1);
    });
    jQuery('#made_owl-<?php echo $id; ?> .nleft').click(function() {
        myowl<?php echo $id; ?>.trigger('prev.owl.carousel');
    })
    // Go to the previous item
    jQuery('#made_owl-<?php echo $id; ?> .nright').click(function() {
        myowl<?php echo $id; ?>.trigger('next.owl.carousel');
    })
});
</script>