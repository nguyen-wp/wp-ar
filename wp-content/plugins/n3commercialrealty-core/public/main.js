jQuery(document).ready(function() {
    if(jQuery(window).width() <= 990) {
        jQuery('.project-block .wp-block-n3custompost-custom-post-type__wrapper.n3custompost-columns').addClass('owl-carousel owl-theme');
        jQuery('.project-block .wp-block-n3custompost-custom-post-type__wrapper.n3custompost-columns .wp-block-n3custompost-custom-post-type__post').each(function() {
            jQuery(this).addClass('item');
        });
        jQuery('.project-block .wp-block-n3custompost-custom-post-type__wrapper.n3custompost-columns').owlCarousel({
            items: 1,
            // loop:true,
            // center:true,
            autoplay:false,
            margin: 30,
            padding: 0,
            dots: true,
            responsive:{
                991:{
                    items:3
                }
            }
        })
    }
});