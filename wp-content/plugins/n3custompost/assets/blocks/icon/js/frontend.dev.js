"use strict";

!function (n) {
  function t(o) {
    if (i[o]) return i[o].exports;
    var e = i[o] = {
      i: o,
      l: !1,
      exports: {}
    };
    return n[o].call(e.exports, e, e.exports, t), e.l = !0, e.exports;
  }

  var i = {};
  t.m = n, t.c = i, t.d = function (n, i, o) {
    t.o(n, i) || Object.defineProperty(n, i, {
      configurable: !1,
      enumerable: !0,
      get: o
    });
  }, t.n = function (n) {
    var i = n && n.__esModule ? function () {
      return n["default"];
    } : function () {
      return n;
    };
    return t.d(i, "a", i), i;
  }, t.o = function (n, t) {
    return Object.prototype.hasOwnProperty.call(n, t);
  }, t.p = "", t(t.s = 13);
}({
  0: function _(n, t, i) {
    "use strict";

    function o(n, t, i) {
      var o = function (n) {
        var t = {
          animation: "animationend",
          OAnimation: "oAnimationEnd",
          MozAnimation: "mozAnimationEnd",
          WebkitAnimation: "webkitAnimationEnd"
        };

        for (var i in t) {
          if (void 0 !== n.style[i]) return t[i];
        }
      }(document.createElement("div")),
          e = void 0 !== t.animation ? t.animation : "",
          a = void 0 !== t.duration ? t.duration : "1s",
          r = void 0 !== t.delay ? t.delay : "0s";

      return n.css({
        "animation-duration": a,
        "animation-delay": r,
        "-webkit-animation-delay": r
      }), n.addClass("animated " + e).one(o, function () {
        jQuery(this).removeClass("animated " + e), "function" == typeof i && i();
      }), this;
    }

    t.a = o;
  },
  13: function _(n, t, i) {
    "use strict";

    Object.defineProperty(t, "__esModule", {
      value: !0
    });
    var o = i(0);
    /*!
    * n3custompost-icon
    */

    !function (n) {
      n(document).ready(function (t) {
        n(document.body).on("post-load", function (n) {
          i();
        });

        var i = function i() {
          n(".wp-block-n3custompost-icon:not(.n3custompost-init)").each(function (t, i) {
            n(i).addClass("n3custompost-init"), n(".n3custompost-animation.wp-block-n3custompost-icon__wrapper").on("mouseenter", function () {
              Object(o.a)(n(this), {
                animation: n(this).attr("data-animation")
              });
            });
          });
        };

        i();
      });
    }(jQuery);
  }
});