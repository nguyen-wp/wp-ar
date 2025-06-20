"use strict";

!function (e) {
  function t(s) {
    if (a[s]) return a[s].exports;
    var o = a[s] = {
      i: s,
      l: !1,
      exports: {}
    };
    return e[s].call(o.exports, o, o.exports, t), o.l = !0, o.exports;
  }

  var a = {};
  t.m = e, t.c = a, t.d = function (e, a, s) {
    t.o(e, a) || Object.defineProperty(e, a, {
      configurable: !1,
      enumerable: !0,
      get: s
    });
  }, t.n = function (e) {
    var a = e && e.__esModule ? function () {
      return e["default"];
    } : function () {
      return e;
    };
    return t.d(a, "a", a), a;
  }, t.o = function (e, t) {
    return Object.prototype.hasOwnProperty.call(e, t);
  }, t.p = "", t(t.s = 16);
}({
  16: function _(e, t) {
    /*!
    * n3custompost-images-slider
    */
    !function (e) {
      e(document).ready(function (t) {
        e(document.body).on("post-load", function (e) {
          a();
        });

        var a = function a() {
          var t,
              a,
              s,
              o,
              d,
              i,
              n,
              l,
              r,
              p,
              c,
              u,
              f,
              w,
              h,
              b,
              g,
              m,
              v,
              y = e(".wp-block-n3custompost-images-slider:not(.n3custompost-init) .wp-block-n3custompost-images-slider__wrapper");
          y.length && "undefined" != typeof imagesLoaded && y.each(function (y) {
            t = e(this), t.closest(".wp-block-n3custompost-images-slider").addClass("n3custompost-init"), t.imagesLoaded().done(function (t) {
              var y = e(t.elements[0]);
              a = "fade" == y.data("effect"), s = y.data("slides-show") && "slide" == y.data("effect") ? parseInt(y.data("slides-show")) : 1, o = y.data("slides-show-laptop") ? parseInt(y.data("slides-show-laptop")) : 1, d = y.data("slides-show-tablet") ? parseInt(y.data("slides-show-tablet")) : 1, i = y.data("slides-show-mobile") ? parseInt(y.data("slides-show-mobile")) : 1, n = y.data("slides-scroll") ? parseInt(y.data("slides-scroll")) : 1, l = 1 == y.data("autoplay"), r = parseInt(y.data("autoplay-speed")) ? parseInt(y.data("autoplay-speed")) : 2e3, p = 1 == y.data("infinite"), c = parseInt(y.data("animation-speed")), u = 1 == y.data("center-mode"), f = 1 == y.data("variable-width"), w = 1 == y.data("pause-hover"), h = "none" != y.data("arrows"), b = "none" != y.data("dots"), g = y.data("height") ? y.data("height") : void 0, m = !!y.data("reset-on-tablet"), v = !!y.data("reset-on-mobile"), e(t.elements[0]).slick({
                arrows: h,
                dots: b,
                rows: 0,
                slidesToShow: s,
                slidesToScroll: n,
                autoplay: l,
                autoplaySpeed: r,
                fade: a,
                speed: c,
                infinite: p,
                centerMode: u,
                variableWidth: f,
                pauseOnHover: w,
                adaptiveHeight: !0,
                rtl: !!N3Block.isRTL,
                responsive: [{
                  breakpoint: 991,
                  settings: {
                    slidesToShow: o,
                    slidesToScroll: 1
                  }
                }, {
                  breakpoint: 768,
                  settings: {
                    slidesToShow: d,
                    slidesToScroll: 1
                  }
                }, {
                  breakpoint: 468,
                  settings: {
                    slidesToShow: i,
                    slidesToScroll: 1
                  }
                }]
              });
            });
          });
        };

        a();
      });
    }(jQuery);
  }
});