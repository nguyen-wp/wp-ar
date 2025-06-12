"use strict";

!function (e) {
  function o(i) {
    if (t[i]) return t[i].exports;
    var s = t[i] = {
      i: i,
      l: !1,
      exports: {}
    };
    return e[i].call(s.exports, s, s.exports, o), s.l = !0, s.exports;
  }

  var t = {};
  o.m = e, o.c = t, o.d = function (e, t, i) {
    o.o(e, t) || Object.defineProperty(e, t, {
      configurable: !1,
      enumerable: !0,
      get: i
    });
  }, o.n = function (e) {
    var t = e && e.__esModule ? function () {
      return e["default"];
    } : function () {
      return e;
    };
    return o.d(t, "a", t), t;
  }, o.o = function (e, o) {
    return Object.prototype.hasOwnProperty.call(e, o);
  }, o.p = "", o(o.s = 21);
}({
  21: function _(e, o) {
    /*!
    * n3custompost-post-carousel
    */
    !function (e) {
      e(document).ready(function (o) {
        e(document.body).on("post-load", function (e) {
          t();
        });

        var t = function t() {
          var o = e(".wp-block-n3custompost-post-carousel:not(.n3custompost-init) .wp-block-n3custompost-post-carousel__wrapper");
          o.length && "undefined" != typeof imagesLoaded && o.each(function (o) {
            n3custompost_post_carousel = e(this);
            var t = n3custompost_post_carousel.data("slider-option"),
                i = t.sliderSlidesToShowDesktop,
                s = t.n3custompost_slidesToShowLaptop,
                n = t.n3custompost_slidesToShowTablet,
                d = t.n3custompost_slidesToShowMobile,
                r = t.n3custompost_slidesToScroll,
                a = t.n3custompost_autoplay,
                l = t.n3custompost_autoplay_speed,
                p = t.n3custompost_infinite,
                c = t.n3custompost_animation_speed,
                u = t.n3custompost_center_mode,
                w = t.n3custompost_pause_on_hover,
                g = t.n3custompost_arrows,
                _ = t.n3custompost_dots;
            w = !1, r = parseInt(r), i = parseInt(i), s = parseInt(s), d = parseInt(d), n = parseInt(n), g = "none" != g, _ = "none" != _, n3custompost_post_carousel.closest(".wp-block-n3custompost-post-carousel").addClass("n3custompost-init"), n3custompost_post_carousel.imagesLoaded().done(function (o) {
              e(o.elements[0]).slick({
                arrows: g,
                dots: _,
                rows: 0,
                slidesToShow: i,
                slidesToScroll: r,
                autoplay: a,
                autoplaySpeed: l,
                fade: !1,
                speed: c,
                infinite: p,
                centerMode: u,
                variableWidth: !1,
                pauseOnHover: w,
                adaptiveHeight: !0,
                rtl: !!N3Block.isRTL,
                responsive: [{
                  breakpoint: 991,
                  settings: {
                    slidesToShow: s,
                    slidesToScroll: 1
                  }
                }, {
                  breakpoint: 768,
                  settings: {
                    slidesToShow: n,
                    slidesToScroll: 1
                  }
                }, {
                  breakpoint: 468,
                  settings: {
                    slidesToShow: d,
                    slidesToScroll: 1
                  }
                }]
              });
            });
          });
        };

        t();
      });
    }(jQuery);
  }
});