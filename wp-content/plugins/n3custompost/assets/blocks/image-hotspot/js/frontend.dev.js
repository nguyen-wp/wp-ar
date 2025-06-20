"use strict";

!function (t) {
  function i(o) {
    if (n[o]) return n[o].exports;
    var e = n[o] = {
      i: o,
      l: !1,
      exports: {}
    };
    return t[o].call(e.exports, e, e.exports, i), e.l = !0, e.exports;
  }

  var n = {};
  i.m = t, i.c = n, i.d = function (t, n, o) {
    i.o(t, n) || Object.defineProperty(t, n, {
      configurable: !1,
      enumerable: !0,
      get: o
    });
  }, i.n = function (t) {
    var n = t && t.__esModule ? function () {
      return t["default"];
    } : function () {
      return t;
    };
    return i.d(n, "a", n), n;
  }, i.o = function (t, i) {
    return Object.prototype.hasOwnProperty.call(t, i);
  }, i.p = "", i(i.s = 15);
}({
  0: function _(t, i, n) {
    "use strict";

    function o(t, i, n) {
      var o = function (t) {
        var i = {
          animation: "animationend",
          OAnimation: "oAnimationEnd",
          MozAnimation: "mozAnimationEnd",
          WebkitAnimation: "webkitAnimationEnd"
        };

        for (var n in i) {
          if (void 0 !== t.style[n]) return i[n];
        }
      }(document.createElement("div")),
          e = void 0 !== i.animation ? i.animation : "",
          a = void 0 !== i.duration ? i.duration : "1s",
          d = void 0 !== i.delay ? i.delay : "0s";

      return t.css({
        "animation-duration": a,
        "animation-delay": d,
        "-webkit-animation-delay": d
      }), t.addClass("animated " + e).one(o, function () {
        jQuery(this).removeClass("animated " + e), "function" == typeof n && n();
      }), this;
    }

    i.a = o;
  },
  15: function _(t, i, n) {
    "use strict";

    Object.defineProperty(i, "__esModule", {
      value: !0
    });
    var o = n(0);
    /*!
    * n3custompost-image-hotspot
    */

    !function (t) {
      t(document).ready(function (i) {
        t(document.body).on("post-load", function (t) {
          n();
        });

        var n = function n() {
          t(".wp-block-n3custompost-image-hotspot:not(.n3custompost-init)").each(function (i, n) {
            t(this).addClass("n3custompost-init");
            var e = t(n).data("trigger"),
                a = t(n).data("theme"),
                d = t(n).data("tooltip-animation"),
                r = t(n).data("arrow"),
                c = t(n).data("image-points");
            t(".n3custompost-animation .wp-block-n3custompost-image-hotspot__dot").on("mouseenter", function () {
              Object(o.a)(t(this), {
                animation: t(this).closest(".n3custompost-animation").attr("data-animation")
              });
            }), t(n).find(".wp-block-n3custompost-image-hotspot__dot").each(function (i, n) {
              var o = t(n),
                  s = o.data("point-id"),
                  l = _unescape(o.find(".wp-block-n3custompost-image-hotspot__dot-title").html()),
                  m = _unescape(c[s].content),
                  p = c[s].popUpOpen,
                  u = c[s].placement,
                  f = c[s].popUpWidth,
                  g = tippy(n, {
                maxWidth: parseInt(f, 10),
                hideOnClick: "multiple" != e || "toggle",
                theme: a,
                animation: d,
                animateFill: !1,
                interactive: !0,
                trigger: "hover" == e ? "mouseenter" : "click",
                arrow: r,
                placement: u,
                allowHTML: !0,
                content: '<div class="wp-block-n3custompost-image-hotspot__tooltip"><div class="wp-block-n3custompost-image-hotspot__tooltip-title">'.concat(l, '</div><div class="wp-block-n3custompost-image-hotspot__tooltip-content">').concat(m, "</div></div>")
              });

              p && setTimeout(function () {
                g.show();
              }, 1e3), o.find(".wp-block-n3custompost-image-hotspot__dot-description").remove(), new Waypoint({
                element: n,
                handler: function handler(i) {
                  t(this.element).addClass("is-visible");
                },
                offset: "100%"
              });
            });
          });
        };

        n();
      });
    }(jQuery);
  }
});