"use strict";

!function (n) {
  function t(a) {
    if (r[a]) return r[a].exports;
    var e = r[a] = {
      i: a,
      l: !1,
      exports: {}
    };
    return n[a].call(e.exports, e, e.exports, t), e.l = !0, e.exports;
  }

  var r = {};
  t.m = n, t.c = r, t.d = function (n, r, a) {
    t.o(n, r) || Object.defineProperty(n, r, {
      configurable: !1,
      enumerable: !0,
      get: a
    });
  }, t.n = function (n) {
    var r = n && n.__esModule ? function () {
      return n["default"];
    } : function () {
      return n;
    };
    return t.d(r, "a", r), r;
  }, t.o = function (n, t) {
    return Object.prototype.hasOwnProperty.call(n, t);
  }, t.p = "", t(t.s = 11);
}({
  11: function _(n, t) {
    /*!
    * n3custompost-counter
    */
    !function (n) {
      n(document).ready(function (t) {
        n(document.body).on("post-load", function (n) {
          r();
        });

        var r = function r() {
          n(".wp-block-n3custompost-counter:not(.n3custompost-init)").each(function (t) {
            function r() {
              if (!d) return null;

              switch (l) {
                case "outExpo":
                  return function (n, t, r, a) {
                    return r * (1 - Math.pow(2, -10 * n / a)) * 1024 / 1023 + t;
                  };

                case "outQuintic":
                  return function (n, t, r, a) {
                    var e = (n /= a) * n,
                        c = e * n;
                    return t + r * (c * e + -5 * e * e + 10 * c + -10 * e + 5 * n);
                  };

                case "outCubic":
                  return function (n, t, r, a) {
                    var e = (n /= a) * n;
                    return t + r * (e * n + -3 * e + 3 * n);
                  };
              }
            }

            function a() {
              switch (_) {
                case "eastern_arabic":
                  return ["٠", "١", "٢", "٣", "٤", "٥", "٦", "٧", "٨", "٩"];

                case "farsi":
                  return ["۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹"];

                default:
                  return null;
              }
            }

            function e() {
              return {
                startVal: c,
                decimalPlaces: i,
                duration: u,
                useEasing: d,
                useGrouping: p,
                separator: f,
                decimal: s,
                easingFn: r(),
                numerals: a()
              };
            }

            n(this).addClass("n3custompost-init");

            var c,
                o,
                i,
                u,
                d,
                p,
                f,
                s,
                l,
                _,
                w = ".wp-block-n3custompost-counter",
                g = n(this);

            c = g.find("".concat(w, "__wrapper")).data("start"), o = g.find("".concat(w, "__wrapper")).data("end"), i = g.find("".concat(w, "__wrapper")).data("decimal-places"), u = g.find("".concat(w, "__wrapper")).data("duration"), d = g.find("".concat(w, "__wrapper")).data("use-easing"), p = g.find("".concat(w, "__wrapper")).data("use-grouping"), f = g.find("".concat(w, "__wrapper")).data("separator"), s = g.find("".concat(w, "__wrapper")).data("decimal"), l = g.find("".concat(w, "__wrapper")).data("easing-fn"), _ = g.find("".concat(w, "__wrapper")).data("numerals");
            var m = g.find("".concat(w, "__number")),
                b = new Waypoint({
              element: m.get(0),
              handler: function handler() {
                new CountUp(m.get(0), o, e()).start(), b.destroy();
              },
              offset: "100%"
            });
          });
        };

        r();
      });
    }(jQuery);
  }
});