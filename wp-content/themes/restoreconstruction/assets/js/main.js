function startCounter() {
    var $window = jQuery(window);
    var $elem = jQuery('.countup');
    if ($elem.length == 0) {
        return;
    }
    var $offset = $elem.offset().top;
    var $height = $elem.outerHeight();
    var $top = $offset + $height;
    var $view = $window.height();
    var $scroll = $window.scrollTop();
    if ($scroll + $view > $top) {
        jQuery('.countup').each(function () {
            var $this = jQuery(this);
            var duration = $this.attr('data-duration') ? $this.attr('data-duration') : 2000;
            if ($this.text() == '0') {
                jQuery({
                    Counter: 0
                }).animate({
                    Counter: $this.attr('data-count')
                }, {
                    duration: duration,
                    easing: 'swing',
                    step: function () {
                        // $this.text(Math.ceil(this.Counter));
                        // Format number with commas
                        $this.text(Math.ceil(this.Counter).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                    }
                }); 
            }
        });
    }
}

function fixedHeader() {
    var $header = jQuery('#header');
    var $topbar = jQuery('#topbar');
    var body = jQuery('main');

   // add class .active to header when scroll top is greater than header height
    if ($header.length > 0) {
        // Add Root CSS variable for header height
        var $window = jQuery(window);
        var $scroll = $window.scrollTop();
        var $headerHeight = $header.outerHeight();
        if ($scroll > $topbar.outerHeight()) {
            $header.addClass('active');
            body.css('padding-top', $headerHeight + 'px');
        } else {
            $header.removeClass('active');
            body.css('padding-top', '0px');
        }
    }
}

jQuery(document).ready(function ($) {
    jQuery('.countup').each(function () {
        var $this = jQuery(this);
        $this.attr('data-count', $this.text());
        $this.text('0');
    })
    startCounter();
    fixedHeader();
})

// Window Scroll Event
jQuery(window).scroll(function () {
    startCounter();
    fixedHeader();
});