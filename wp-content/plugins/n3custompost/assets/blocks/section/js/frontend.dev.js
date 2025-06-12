"use strict";

!function (e) {
  function i(o) {
    if (t[o]) return t[o].exports;
    var n = t[o] = {
      i: o,
      l: !1,
      exports: {}
    };
    return e[o].call(n.exports, n, n.exports, i), n.l = !0, n.exports;
  }

  var t = {};
  i.m = e, i.c = t, i.d = function (e, t, o) {
    i.o(e, t) || Object.defineProperty(e, t, {
      configurable: !1,
      enumerable: !0,
      get: o
    });
  }, i.n = function (e) {
    var t = e && e.__esModule ? function () {
      return e["default"];
    } : function () {
      return e;
    };
    return i.d(t, "a", t), t;
  }, i.o = function (e, i) {
    return Object.prototype.hasOwnProperty.call(e, i);
  }, i.p = "", i(i.s = 24);
}({
  24: function _(e, i) {
    /*!
    * n3custompost-section
    */
    !function (e) {
      e(document).ready(function (i) {
        function t() {
          var e = document.createElement("script");
          e.type = "text/javascript", e.src = "https://www.youtube.com/iframe_api", e.id = "youtube_video_api_js";
          var i = !1;
          document.getElementsByTagName("head")[0].appendChild(e), e.onload = e.onreadystatechange = function () {
            i || this.readyState && "loaded" !== this.readyState && "complete" !== this.readyState || (i = !0, e.onload = e.onreadystatechange = null);
          };
        }

        function o(e) {
          var i = /(?:https?:\/\/)?(?:www\.)?(?:youtube(?:-nocookie)?\.com\/\S*(?:(?:\/e(?:mbed))?\/v?|(?:watch\?)?(?:\S*?&?vi?\=))|youtu\.be\/)([a-zA-Z0-9_-]{6,11})/;
          return !!e.match(i) && RegExp.$1;
        }

        function n() {
          void 0 === window.onYouTubeIframeAPIReady ? window.onYouTubeIframeAPIReady = function () {
            n3custompostYT.init();
          } : d = setInterval(function () {
            void 0 !== window.YT && window.YT.loaded && (n3custompostYT.ready || n3custompostYT.init());
          });
        }

        var a,
            d = !1,
            c = e(".wp-block-n3custompost-section__background-video.source-youtube .wp-block-n3custompost-section__background-video-youtube");
        window.n3custompostYT = {
          data: {
            ready: !1
          },
          init: function init() {
            n3custompostYT.data.ready = !0, clearInterval(d), c.each(function (i) {
              var t = e(this).attr("id"),
                  o = e(this).parent().attr("youtube-video-autoplay"),
                  n = e(this).parent().attr("youtube-video-loop"),
                  a = e(this).parent().attr("youtube-video-muted"),
                  d = e(this).closest(".wp-block-n3custompost-section__wrapper").find(".n3custompost-background-video-controls .n3custompost-background-video-play"),
                  u = e(this).closest(".wp-block-n3custompost-section__wrapper").find(".n3custompost-background-video-controls .n3custompost-background-video-mute");
              window.YT.ready(function () {
                var s = {
                  playsinline: 1,
                  autoplay: "true" == o ? 1 : 0,
                  controls: 0,
                  disablekb: 1,
                  fs: 0,
                  cc_load_policy: 0,
                  iv_load_policy: 3,
                  loop: "true" == n ? 1 : 0,
                  modestbranding: 1,
                  rel: 0,
                  showinfo: 0,
                  enablejsapi: 1,
                  mute: "true" == a ? 1 : 0,
                  autohide: 1
                };
                "true" == n && (s.playlist = t);
                new YT.Player(c[i], {
                  playerVars: s,
                  height: "100%",
                  width: "100%",
                  videoId: t,
                  events: {
                    onReady: function onReady(i) {
                      var t = i.target;
                      "true" == o ? d.html('<i class="n3custompost-icon n3custompost-icon-pause"></i>') : "false" == o && d.html('<i class="n3custompost-icon n3custompost-icon-play"></i>'), "true" == a ? u.html('<i class="n3custompost-icon n3custompost-icon-mute"></i>') : "false" == a && u.html('<i class="n3custompost-icon n3custompost-icon-volume-up"></i>'), e(d).on("click", function (e) {
                        "true" == o ? (t.pauseVideo(), d.html('<i class="n3custompost-icon n3custompost-icon-play"></i>'), o = "false") : "false" == o && (t.playVideo(), d.html('<i class="n3custompost-icon n3custompost-icon-pause"></i>'), o = "true");
                      }), e(u).on("click", function (e) {
                        "true" == a ? (t.unMute(), u.html('<i class="n3custompost-icon n3custompost-icon-volume-up"></i>'), a = "false") : "false" == a && (t.mute(), u.html('<i class="n3custompost-icon n3custompost-icon-mute"></i>'), a = "true");
                      }), "true" == o && t.playVideo();
                    },
                    onStateChange: function onStateChange(e) {
                      -1 == e.data && (d.html('<i class="n3custompost-icon n3custompost-icon-play"></i>'), o = "false"), 1 == e.data && (d.html('<i class="n3custompost-icon n3custompost-icon-pause"></i>'), o = "true"), 2 == e.data && (d.html('<i class="n3custompost-icon n3custompost-icon-play"></i>'), o = "false"), 3 == e.data && (d.html('<i class="n3custompost-icon n3custompost-icon-pause"></i>'), o = "true"), 0 == e.data && "false" == n && (e.target.stopVideo(), d.html('<i class="n3custompost-icon n3custompost-icon-play"></i>'), o = "false");
                    }
                  }
                });
              });
            });
          }
        }, e(document.body).on("post-load", function (e) {
          u(), s(), l(), r();
        });

        var u = function u() {
          a = e(".wp-block-n3custompost-section__background-video.source-youtube .wp-block-n3custompost-section__background-video-youtube:not(.n3custompost-init)"), a.each(function (i) {
            e(this).addClass("n3custompost-init");
            var t = o(e(this).parent().attr("youtube-video-url"));
            e(this).attr("id", t);
          }), a.length && (e("#youtube_video_api_js").length || (t(), n()));
        },
            s = function s() {
          var i,
              t,
              o,
              n,
              a,
              d,
              c = e(".wp-block-n3custompost-section__background-slider:not(.n3custompost-init)");
          c.length && "undefined" != typeof imagesLoaded && c.each(function (c) {
            d = e(this), i = 1 == d.data("autoplay"), t = parseInt(d.data("autoplay-speed")), o = "fade" == d.data("slide-effect"), n = parseInt(d.data("slide-speed")), a = 1 == d.data("infinite"), e(this).addClass("n3custompost-init"), d.imagesLoaded().done(function (d) {
              e(d.elements[0]).slick({
                arrows: !1,
                dots: !1,
                rows: 0,
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: i,
                autoplaySpeed: t,
                fade: o,
                speed: n,
                infinite: a,
                rtl: !!N3Block.isRTL
              });
            });
          });
        },
            l = function l() {
          if ("undefined" != typeof WOW) {
            new WOW({
              boxClass: "n3custompost-anim",
              mobile: !1
            }).init();
          }
        },
            r = function r() {
          e(".wp-block-n3custompost-section:not(.n3custompost-init)").each(function (i) {
            e(this).addClass("n3custompost-init");
            var t = e(this),
                o = t.find(".wp-block-n3custompost-section__background-video.source-media-library").get(0),
                n = t.find(".n3custompost-background-video-play"),
                a = t.find(".n3custompost-background-video-mute");
            t.find(".wp-block-n3custompost-section__background-video.source-media-library").on("play", function (e) {
              n.html('<i class="n3custompost-icon n3custompost-icon-pause"></i>');
            }).on("pause", function (e) {
              n.html('<i class="n3custompost-icon n3custompost-icon-play"></i>');
            }), t.on("click", ".n3custompost-background-video-play", function (e) {
              e.preventDefault(), o && (o.paused ? o.play() : o.pause());
            }), t.ready(function () {
              o && (o.paused ? n.html('<i class="n3custompost-icon n3custompost-icon-play"></i>') : n.html('<i class="n3custompost-icon n3custompost-icon-pause"></i>'), o.muted ? a.html('<i class="n3custompost-icon n3custompost-icon-mute"></i>') : a.html('<i class="n3custompost-icon n3custompost-icon-volume-up"></i>'));
            }), t.on("click", ".n3custompost-background-video-mute", function (e) {
              e.preventDefault(), o && (o.muted = !o.muted, o.muted ? a.html('<i class="n3custompost-icon n3custompost-icon-mute"></i>') : a.html('<i class="n3custompost-icon n3custompost-icon-volume-up"></i>'));
            });
          });
        };

        u(), s(), l(), r();
      });
    }(jQuery);
  }
});