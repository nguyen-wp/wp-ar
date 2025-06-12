"use strict";
jQuery(document).ready(function () {
    jQuery(".accordion-list").each(function () {
        jQuery(this).find(".accordion-item.is-active").children(".accordion-panel").slideDown();
        jQuery(this).find(".accordion-item .accordion-title").click(function () {
            jQuery(this).parent().siblings(".accordion-item").removeClass("is-active").children(".accordion-panel").slideUp();
            jQuery(this).parent().toggleClass("is-active").children(".accordion-panel").slideToggle("ease-out");
        });
    })
});