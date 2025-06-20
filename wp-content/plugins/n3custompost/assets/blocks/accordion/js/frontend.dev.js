"use strict";

!function (t) {
  function e(o) {
    if (n[o]) return n[o].exports;
    var i = n[o] = {
      i: o,
      l: !1,
      exports: {}
    };
    return t[o].call(i.exports, i, i.exports, e), i.l = !0, i.exports;
  }

  var n = {};
  e.m = t, e.c = n, e.d = function (t, n, o) {
    e.o(t, n) || Object.defineProperty(t, n, {
      configurable: !1,
      enumerable: !0,
      get: o
    });
  }, e.n = function (t) {
    var n = t && t.__esModule ? function () {
      return t["default"];
    } : function () {
      return t;
    };
    return e.d(n, "a", n), n;
  }, e.o = function (t, e) {
    return Object.prototype.hasOwnProperty.call(t, e);
  }, e.p = "", e(e.s = 1);
}([, function (t, e) {
  /*!
  * n3custompost-accordion
  */
  !function (t) {
    t(document).ready(function (e) {
      t(document.body).on("post-load", function (t) {
        n();
      });

      var n = function n() {
        var e = t(".wp-block-n3custompost-accordion:not(.n3custompost-init)"),
            n = 0;
        e.each(function (e, o) {
          t(this).addClass("n3custompost-init"), n = "none" != t(this).data("active-element") && parseInt(t(this).data("active-element"), 10), t(o).accordion({
            icons: !1,
            animate: !1,
            collapsible: !0,
            active: n,
            heightStyle: "content",
            create: function create(t, e) {},
            activate: function activate(e, n) {
              if (n.newPanel.length) {
                var o = n.newPanel.find(".wp-block-n3custompost-accordion__content").outerHeight(!0);
                o && t(n.newPanel).animate({
                  height: o
                }, {
                  queue: !1,
                  duration: 500,
                  complete: function complete() {
                    t(this).css("height", "");
                  }
                });
              }

              if (n.oldPanel.length) {
                var i = n.oldPanel.find(".wp-block-n3custompost-accordion__content").outerHeight(!0);
                i && (t(n.oldPanel).css("height", i), t(n.oldPanel).animate({
                  height: 0
                }, {
                  queue: !1,
                  duration: 500,
                  complete: function complete() {
                    t(this).css("height", "");
                  }
                }));
              }
            }
          });
        });
      };

      n();
    });
  }(jQuery);
}]);