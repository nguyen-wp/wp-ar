"use strict";

!function (n) {
  function t(e) {
    if (o[e]) return o[e].exports;
    var i = o[e] = {
      i: e,
      l: !1,
      exports: {}
    };
    return n[e].call(i.exports, i, i.exports, t), i.l = !0, i.exports;
  }

  var o = {};
  t.m = n, t.c = o, t.d = function (n, o, e) {
    t.o(n, o) || Object.defineProperty(n, o, {
      configurable: !1,
      enumerable: !0,
      get: e
    });
  }, t.n = function (n) {
    var o = n && n.__esModule ? function () {
      return n["default"];
    } : function () {
      return n;
    };
    return t.d(o, "a", o), o;
  }, t.o = function (n, t) {
    return Object.prototype.hasOwnProperty.call(n, t);
  }, t.p = "", t(t.s = 27);
}({
  27: function _(n, t) {
    /*!
    * n3custompost-video-popup
    */
    !function (n) {
      n(document).ready(function (t) {
        n(document.body).on("post-load", function (n) {
          o();
        });

        var o = function o() {
          n(".wp-block-n3custompost-video-popup:not(.n3custompost-init)").each(function (t) {
            n(this).addClass("n3custompost-init"), n(this).find(".wp-block-n3custompost-video-popup__link").fancybox({
              baseClass: "n3custompost-video-popup"
            });
          });
        };

        o();
      });
    }(jQuery);
  }
});