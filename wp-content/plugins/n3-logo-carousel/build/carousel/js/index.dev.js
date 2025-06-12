"use strict";

function _objectWithoutProperties(source, excluded) { if (source == null) return {}; var target = _objectWithoutPropertiesLoose(source, excluded); var key, i; if (Object.getOwnPropertySymbols) { var sourceSymbolKeys = Object.getOwnPropertySymbols(source); for (i = 0; i < sourceSymbolKeys.length; i++) { key = sourceSymbolKeys[i]; if (excluded.indexOf(key) >= 0) continue; if (!Object.prototype.propertyIsEnumerable.call(source, key)) continue; target[key] = source[key]; } } return target; }

function _objectWithoutPropertiesLoose(source, excluded) { if (source == null) return {}; var target = {}; var sourceKeys = Object.keys(source); var key, i; for (i = 0; i < sourceKeys.length; i++) { key = sourceKeys[i]; if (excluded.indexOf(key) >= 0) continue; target[key] = source[key]; } return target; }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance"); }

function _iterableToArrayLimit(arr, i) { if (!(Symbol.iterator in Object(arr) || Object.prototype.toString.call(arr) === "[object Arguments]")) { return; } var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance"); }

function _iterableToArray(iter) { if (Symbol.iterator in Object(iter) || Object.prototype.toString.call(iter) === "[object Arguments]") return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _wrapNativeSuper(Class) { var _cache = typeof Map === "function" ? new Map() : undefined; _wrapNativeSuper = function _wrapNativeSuper(Class) { if (Class === null || !_isNativeFunction(Class)) return Class; if (typeof Class !== "function") { throw new TypeError("Super expression must either be null or a function"); } if (typeof _cache !== "undefined") { if (_cache.has(Class)) return _cache.get(Class); _cache.set(Class, Wrapper); } function Wrapper() { return _construct(Class, arguments, _getPrototypeOf(this).constructor); } Wrapper.prototype = Object.create(Class.prototype, { constructor: { value: Wrapper, enumerable: false, writable: true, configurable: true } }); return _setPrototypeOf(Wrapper, Class); }; return _wrapNativeSuper(Class); }

function isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Date.prototype.toString.call(Reflect.construct(Date, [], function () {})); return true; } catch (e) { return false; } }

function _construct(Parent, args, Class) { if (isNativeReflectConstruct()) { _construct = Reflect.construct; } else { _construct = function _construct(Parent, args, Class) { var a = [null]; a.push.apply(a, args); var Constructor = Function.bind.apply(Parent, a); var instance = new Constructor(); if (Class) _setPrototypeOf(instance, Class.prototype); return instance; }; } return _construct.apply(null, arguments); }

function _isNativeFunction(fn) { return Function.toString.call(fn).indexOf("[native code]") !== -1; }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

!function () {
  "use strict";

  var e,
      t = {
    550: function _() {
      var e = window.wp.blocks,
          t = JSON.parse('{"apiVersion":2,"name":"lcb/logo-carousel","version":"0.1.0","title":"N3 Logo Carousel","category":"logo-blocks","description":"Shows clients logos in a carousel","supports":{"html":false},"keywords":["logo","carousel","logo carousel","logo slider"],"attributes":{"sliderId":{"type":"string"},"images":{"type":"array"},"loop":{"type":"boolean","default":true},"autoplay":{"type":"boolean","default":true},"reverseAutoplayDirection":{"type":"boolean","default":false},"speed":{"type":"number","default":400},"autoplayDelay":{"type":"number","default":2000},"pauseOnHover":{"type":"boolean","default":true},"keyboard":{"type":"boolean","default":false},"mousewheel":{"type":"boolean","default":false},"autoHeight":{"type":"boolean","default":false},"slideDirection":{"type":"string","default":"ltr"},"showNav":{"type":"boolean","default":true},"showPagination":{"type":"boolean","default":true},"itemDevice":{"type":"string","default":"desktop"},"deskItemsPerView":{"type":"number","default":4},"tabItemsPerView":{"type":"number","default":2},"phoneItemsPerView":{"type":"number","default":1},"spaceDevice":{"type":"string","default":"desktop"},"deskSpace":{"type":"number","default":30},"tabSpace":{"type":"number","default":20},"phoneSpace":{"type":"number","default":10},"showCaption":{"type":"boolean","default":false},"captionVisibility":{"type":"string","default":"caption__hover"},"captionBg":{"type":"string","default":"#333333"},"captionColor":{"type":"string","default":"#ffffff"},"borderWidth":{"type":"string","default":"0"},"borderColor":{"type":"string","default":"#333333"},"borderStyle":{"type":"string","default":"solid"},"borderRadius":{"type":"number","default":0},"logoHoverStyle":{"type":"string","default":"none"}},"textdomain":"n3-logo-carousel-block","editorScript":"file:./index.js","editorStyle":"file:./index.css","style":"file:./style-index.css"}'),
          s = window.wp.element,
          a = window.wp.i18n,
          n = window.React;

      function i(e) {
        return null !== e && "object" == _typeof(e) && "constructor" in e && e.constructor === Object;
      }

      function r() {
        var e = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
        var t = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
        Object.keys(t).forEach(function (s) {
          void 0 === e[s] ? e[s] = t[s] : i(t[s]) && i(e[s]) && Object.keys(t[s]).length > 0 && r(e[s], t[s]);
        });
      }

      var l = {
        body: {},
        addEventListener: function addEventListener() {},
        removeEventListener: function removeEventListener() {},
        activeElement: {
          blur: function blur() {},
          nodeName: ""
        },
        querySelector: function querySelector() {
          return null;
        },
        querySelectorAll: function querySelectorAll() {
          return [];
        },
        getElementById: function getElementById() {
          return null;
        },
        createEvent: function createEvent() {
          return {
            initEvent: function initEvent() {}
          };
        },
        createElement: function createElement() {
          return {
            children: [],
            childNodes: [],
            style: {},
            setAttribute: function setAttribute() {},
            getElementsByTagName: function getElementsByTagName() {
              return [];
            }
          };
        },
        createElementNS: function createElementNS() {
          return {};
        },
        importNode: function importNode() {
          return null;
        },
        location: {
          hash: "",
          host: "",
          hostname: "",
          href: "",
          origin: "",
          pathname: "",
          protocol: "",
          search: ""
        }
      };

      function o() {
        var e = "undefined" != typeof document ? document : {};
        return r(e, l), e;
      }

      var d = {
        document: l,
        navigator: {
          userAgent: ""
        },
        location: {
          hash: "",
          host: "",
          hostname: "",
          href: "",
          origin: "",
          pathname: "",
          protocol: "",
          search: ""
        },
        history: {
          replaceState: function replaceState() {},
          pushState: function pushState() {},
          go: function go() {},
          back: function back() {}
        },
        CustomEvent: function CustomEvent() {
          return this;
        },
        addEventListener: function addEventListener() {},
        removeEventListener: function removeEventListener() {},
        getComputedStyle: function getComputedStyle() {
          return {
            getPropertyValue: function getPropertyValue() {
              return "";
            }
          };
        },
        Image: function Image() {},
        Date: function Date() {},
        screen: {},
        setTimeout: function setTimeout() {},
        clearTimeout: function clearTimeout() {},
        matchMedia: function matchMedia() {
          return {};
        },
        requestAnimationFrame: function requestAnimationFrame(e) {
          return "undefined" == typeof setTimeout ? (e(), null) : setTimeout(e, 0);
        },
        cancelAnimationFrame: function cancelAnimationFrame(e) {
          "undefined" != typeof setTimeout && clearTimeout(e);
        }
      };

      function c() {
        var e = "undefined" != typeof window ? window : {};
        return r(e, d), e;
      }

      var p =
      /*#__PURE__*/
      function (_Array) {
        _inherits(p, _Array);

        function p(e) {
          var _getPrototypeOf2;

          var _this;

          _classCallCheck(this, p);

          "number" == typeof e ? _this = _possibleConstructorReturn(this, _getPrototypeOf(p).call(this, e)) : (_this = _possibleConstructorReturn(this, (_getPrototypeOf2 = _getPrototypeOf(p)).call.apply(_getPrototypeOf2, [this].concat(_toConsumableArray(e || [])))), function (e) {
            var t = e.__proto__;
            Object.defineProperty(e, "__proto__", {
              get: function get() {
                return t;
              },
              set: function set(e) {
                t.__proto__ = e;
              }
            });
          }(_assertThisInitialized(_this)));
          return _possibleConstructorReturn(_this);
        }

        return p;
      }(_wrapNativeSuper(Array));

      function u() {
        var e = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : [];
        var t = [];
        return e.forEach(function (e) {
          Array.isArray(e) ? t.push.apply(t, _toConsumableArray(u(e))) : t.push(e);
        }), t;
      }

      function m(e, t) {
        return Array.prototype.filter.call(e, t);
      }

      function h(e, t) {
        var s = c(),
            a = o();
        var n = [];
        if (!t && e instanceof p) return e;
        if (!e) return new p(n);

        if ("string" == typeof e) {
          var _s = e.trim();

          if (_s.indexOf("<") >= 0 && _s.indexOf(">") >= 0) {
            var _e2 = "div";
            0 === _s.indexOf("<li") && (_e2 = "ul"), 0 === _s.indexOf("<tr") && (_e2 = "tbody"), 0 !== _s.indexOf("<td") && 0 !== _s.indexOf("<th") || (_e2 = "tr"), 0 === _s.indexOf("<tbody") && (_e2 = "table"), 0 === _s.indexOf("<option") && (_e2 = "select");

            var _t = a.createElement(_e2);

            _t.innerHTML = _s;

            for (var _e3 = 0; _e3 < _t.childNodes.length; _e3 += 1) {
              n.push(_t.childNodes[_e3]);
            }
          } else n = function (e, t) {
            if ("string" != typeof e) return [e];
            var s = [],
                a = t.querySelectorAll(e);

            for (var _e4 = 0; _e4 < a.length; _e4 += 1) {
              s.push(a[_e4]);
            }

            return s;
          }(e.trim(), t || a);
        } else if (e.nodeType || e === s || e === a) n.push(e);else if (Array.isArray(e)) {
          if (e instanceof p) return e;
          n = e;
        }

        return new p(function (e) {
          var t = [];

          for (var _s2 = 0; _s2 < e.length; _s2 += 1) {
            -1 === t.indexOf(e[_s2]) && t.push(e[_s2]);
          }

          return t;
        }(n));
      }

      h.fn = p.prototype;
      var f = "resize scroll".split(" ");

      function g(e) {
        return function () {
          for (var _len = arguments.length, t = new Array(_len), _key = 0; _key < _len; _key++) {
            t[_key] = arguments[_key];
          }

          if (void 0 === t[0]) {
            for (var _t2 = 0; _t2 < this.length; _t2 += 1) {
              f.indexOf(e) < 0 && (e in this[_t2] ? this[_t2][e]() : h(this[_t2]).trigger(e));
            }

            return this;
          }

          return this.on.apply(this, [e].concat(t));
        };
      }

      g("click"), g("blur"), g("focus"), g("focusin"), g("focusout"), g("keyup"), g("keydown"), g("keypress"), g("submit"), g("change"), g("mousedown"), g("mousemove"), g("mouseup"), g("mouseenter"), g("mouseleave"), g("mouseout"), g("mouseover"), g("touchstart"), g("touchend"), g("touchmove"), g("resize"), g("scroll");
      var v = {
        addClass: function addClass() {
          for (var _len2 = arguments.length, e = new Array(_len2), _key2 = 0; _key2 < _len2; _key2++) {
            e[_key2] = arguments[_key2];
          }

          var t = u(e.map(function (e) {
            return e.split(" ");
          }));
          return this.forEach(function (e) {
            var _e$classList;

            (_e$classList = e.classList).add.apply(_e$classList, _toConsumableArray(t));
          }), this;
        },
        removeClass: function removeClass() {
          for (var _len3 = arguments.length, e = new Array(_len3), _key3 = 0; _key3 < _len3; _key3++) {
            e[_key3] = arguments[_key3];
          }

          var t = u(e.map(function (e) {
            return e.split(" ");
          }));
          return this.forEach(function (e) {
            var _e$classList2;

            (_e$classList2 = e.classList).remove.apply(_e$classList2, _toConsumableArray(t));
          }), this;
        },
        hasClass: function hasClass() {
          for (var _len4 = arguments.length, e = new Array(_len4), _key4 = 0; _key4 < _len4; _key4++) {
            e[_key4] = arguments[_key4];
          }

          var t = u(e.map(function (e) {
            return e.split(" ");
          }));
          return m(this, function (e) {
            return t.filter(function (t) {
              return e.classList.contains(t);
            }).length > 0;
          }).length > 0;
        },
        toggleClass: function toggleClass() {
          for (var _len5 = arguments.length, e = new Array(_len5), _key5 = 0; _key5 < _len5; _key5++) {
            e[_key5] = arguments[_key5];
          }

          var t = u(e.map(function (e) {
            return e.split(" ");
          }));
          this.forEach(function (e) {
            t.forEach(function (t) {
              e.classList.toggle(t);
            });
          });
        },
        attr: function attr(e, t) {
          if (1 === arguments.length && "string" == typeof e) return this[0] ? this[0].getAttribute(e) : void 0;

          for (var _s3 = 0; _s3 < this.length; _s3 += 1) {
            if (2 === arguments.length) this[_s3].setAttribute(e, t);else for (var _t3 in e) {
              this[_s3][_t3] = e[_t3], this[_s3].setAttribute(_t3, e[_t3]);
            }
          }

          return this;
        },
        removeAttr: function removeAttr(e) {
          for (var _t4 = 0; _t4 < this.length; _t4 += 1) {
            this[_t4].removeAttribute(e);
          }

          return this;
        },
        transform: function transform(e) {
          for (var _t5 = 0; _t5 < this.length; _t5 += 1) {
            this[_t5].style.transform = e;
          }

          return this;
        },
        transition: function transition(e) {
          for (var _t6 = 0; _t6 < this.length; _t6 += 1) {
            this[_t6].style.transitionDuration = "string" != typeof e ? "".concat(e, "ms") : e;
          }

          return this;
        },
        on: function on() {
          var _e6, _e7;

          for (var _len6 = arguments.length, e = new Array(_len6), _key6 = 0; _key6 < _len6; _key6++) {
            e[_key6] = arguments[_key6];
          }

          var t = e[0],
              s = e[1],
              a = e[2],
              n = e[3];

          function i(e) {
            var t = e.target;
            if (!t) return;
            var n = e.target.dom7EventData || [];
            if (n.indexOf(e) < 0 && n.unshift(e), h(t).is(s)) a.apply(t, n);else {
              var _e5 = h(t).parents();

              for (var _t7 = 0; _t7 < _e5.length; _t7 += 1) {
                h(_e5[_t7]).is(s) && a.apply(_e5[_t7], n);
              }
            }
          }

          function r(e) {
            var t = e && e.target && e.target.dom7EventData || [];
            t.indexOf(e) < 0 && t.unshift(e), a.apply(this, t);
          }

          "function" == typeof e[1] && ((_e6 = e, _e7 = _slicedToArray(_e6, 3), t = _e7[0], a = _e7[1], n = _e7[2], _e6), s = void 0), n || (n = !1);
          var l = t.split(" ");
          var o;

          for (var _e8 = 0; _e8 < this.length; _e8 += 1) {
            var _t8 = this[_e8];
            if (s) for (o = 0; o < l.length; o += 1) {
              var _e9 = l[o];
              _t8.dom7LiveListeners || (_t8.dom7LiveListeners = {}), _t8.dom7LiveListeners[_e9] || (_t8.dom7LiveListeners[_e9] = []), _t8.dom7LiveListeners[_e9].push({
                listener: a,
                proxyListener: i
              }), _t8.addEventListener(_e9, i, n);
            } else for (o = 0; o < l.length; o += 1) {
              var _e10 = l[o];
              _t8.dom7Listeners || (_t8.dom7Listeners = {}), _t8.dom7Listeners[_e10] || (_t8.dom7Listeners[_e10] = []), _t8.dom7Listeners[_e10].push({
                listener: a,
                proxyListener: r
              }), _t8.addEventListener(_e10, r, n);
            }
          }

          return this;
        },
        off: function off() {
          var _e11, _e12;

          for (var _len7 = arguments.length, e = new Array(_len7), _key7 = 0; _key7 < _len7; _key7++) {
            e[_key7] = arguments[_key7];
          }

          var t = e[0],
              s = e[1],
              a = e[2],
              n = e[3];
          "function" == typeof e[1] && ((_e11 = e, _e12 = _slicedToArray(_e11, 3), t = _e12[0], a = _e12[1], n = _e12[2], _e11), s = void 0), n || (n = !1);
          var i = t.split(" ");

          for (var _e13 = 0; _e13 < i.length; _e13 += 1) {
            var _t9 = i[_e13];

            for (var _e14 = 0; _e14 < this.length; _e14 += 1) {
              var _i2 = this[_e14];

              var _r = void 0;

              if (!s && _i2.dom7Listeners ? _r = _i2.dom7Listeners[_t9] : s && _i2.dom7LiveListeners && (_r = _i2.dom7LiveListeners[_t9]), _r && _r.length) for (var _e15 = _r.length - 1; _e15 >= 0; _e15 -= 1) {
                var _s4 = _r[_e15];
                a && _s4.listener === a || a && _s4.listener && _s4.listener.dom7proxy && _s4.listener.dom7proxy === a ? (_i2.removeEventListener(_t9, _s4.proxyListener, n), _r.splice(_e15, 1)) : a || (_i2.removeEventListener(_t9, _s4.proxyListener, n), _r.splice(_e15, 1));
              }
            }
          }

          return this;
        },
        trigger: function trigger() {
          for (var _len8 = arguments.length, e = new Array(_len8), _key8 = 0; _key8 < _len8; _key8++) {
            e[_key8] = arguments[_key8];
          }

          var t = c(),
              s = e[0].split(" "),
              a = e[1];

          for (var _n2 = 0; _n2 < s.length; _n2 += 1) {
            var _i3 = s[_n2];

            for (var _s5 = 0; _s5 < this.length; _s5 += 1) {
              var _n3 = this[_s5];

              if (t.CustomEvent) {
                var _s6 = new t.CustomEvent(_i3, {
                  detail: a,
                  bubbles: !0,
                  cancelable: !0
                });

                _n3.dom7EventData = e.filter(function (e, t) {
                  return t > 0;
                }), _n3.dispatchEvent(_s6), _n3.dom7EventData = [], delete _n3.dom7EventData;
              }
            }
          }

          return this;
        },
        transitionEnd: function transitionEnd(e) {
          var t = this;
          return e && t.on("transitionend", function s(a) {
            a.target === this && (e.call(this, a), t.off("transitionend", s));
          }), this;
        },
        outerWidth: function outerWidth(e) {
          if (this.length > 0) {
            if (e) {
              var _e16 = this.styles();

              return this[0].offsetWidth + parseFloat(_e16.getPropertyValue("margin-right")) + parseFloat(_e16.getPropertyValue("margin-left"));
            }

            return this[0].offsetWidth;
          }

          return null;
        },
        outerHeight: function outerHeight(e) {
          if (this.length > 0) {
            if (e) {
              var _e17 = this.styles();

              return this[0].offsetHeight + parseFloat(_e17.getPropertyValue("margin-top")) + parseFloat(_e17.getPropertyValue("margin-bottom"));
            }

            return this[0].offsetHeight;
          }

          return null;
        },
        styles: function styles() {
          var e = c();
          return this[0] ? e.getComputedStyle(this[0], null) : {};
        },
        offset: function offset() {
          if (this.length > 0) {
            var _e18 = c(),
                _t10 = o(),
                _s7 = this[0],
                _a = _s7.getBoundingClientRect(),
                _n4 = _t10.body,
                _i4 = _s7.clientTop || _n4.clientTop || 0,
                _r2 = _s7.clientLeft || _n4.clientLeft || 0,
                _l = _s7 === _e18 ? _e18.scrollY : _s7.scrollTop,
                _d2 = _s7 === _e18 ? _e18.scrollX : _s7.scrollLeft;

            return {
              top: _a.top + _l - _i4,
              left: _a.left + _d2 - _r2
            };
          }

          return null;
        },
        css: function css(e, t) {
          var s = c();
          var a;

          if (1 === arguments.length) {
            if ("string" != typeof e) {
              for (a = 0; a < this.length; a += 1) {
                for (var _t11 in e) {
                  this[a].style[_t11] = e[_t11];
                }
              }

              return this;
            }

            if (this[0]) return s.getComputedStyle(this[0], null).getPropertyValue(e);
          }

          if (2 === arguments.length && "string" == typeof e) {
            for (a = 0; a < this.length; a += 1) {
              this[a].style[e] = t;
            }

            return this;
          }

          return this;
        },
        each: function each(e) {
          return e ? (this.forEach(function (t, s) {
            e.apply(t, [t, s]);
          }), this) : this;
        },
        html: function html(e) {
          if (void 0 === e) return this[0] ? this[0].innerHTML : null;

          for (var _t12 = 0; _t12 < this.length; _t12 += 1) {
            this[_t12].innerHTML = e;
          }

          return this;
        },
        text: function text(e) {
          if (void 0 === e) return this[0] ? this[0].textContent.trim() : null;

          for (var _t13 = 0; _t13 < this.length; _t13 += 1) {
            this[_t13].textContent = e;
          }

          return this;
        },
        is: function is(e) {
          var t = c(),
              s = o(),
              a = this[0];
          var n, i;
          if (!a || void 0 === e) return !1;

          if ("string" == typeof e) {
            if (a.matches) return a.matches(e);
            if (a.webkitMatchesSelector) return a.webkitMatchesSelector(e);
            if (a.msMatchesSelector) return a.msMatchesSelector(e);

            for (n = h(e), i = 0; i < n.length; i += 1) {
              if (n[i] === a) return !0;
            }

            return !1;
          }

          if (e === s) return a === s;
          if (e === t) return a === t;

          if (e.nodeType || e instanceof p) {
            for (n = e.nodeType ? [e] : e, i = 0; i < n.length; i += 1) {
              if (n[i] === a) return !0;
            }

            return !1;
          }

          return !1;
        },
        index: function index() {
          var e,
              t = this[0];

          if (t) {
            for (e = 0; null !== (t = t.previousSibling);) {
              1 === t.nodeType && (e += 1);
            }

            return e;
          }
        },
        eq: function eq(e) {
          if (void 0 === e) return this;
          var t = this.length;
          if (e > t - 1) return h([]);

          if (e < 0) {
            var _s8 = t + e;

            return h(_s8 < 0 ? [] : [this[_s8]]);
          }

          return h([this[e]]);
        },
        append: function append() {
          var t;
          var s = o();

          for (var _a2 = 0; _a2 < arguments.length; _a2 += 1) {
            t = _a2 < 0 || arguments.length <= _a2 ? undefined : arguments[_a2];

            for (var _e19 = 0; _e19 < this.length; _e19 += 1) {
              if ("string" == typeof t) {
                var _a3 = s.createElement("div");

                for (_a3.innerHTML = t; _a3.firstChild;) {
                  this[_e19].appendChild(_a3.firstChild);
                }
              } else if (t instanceof p) for (var _s9 = 0; _s9 < t.length; _s9 += 1) {
                this[_e19].appendChild(t[_s9]);
              } else this[_e19].appendChild(t);
            }
          }

          return this;
        },
        prepend: function prepend(e) {
          var t = o();
          var s, a;

          for (s = 0; s < this.length; s += 1) {
            if ("string" == typeof e) {
              var _n5 = t.createElement("div");

              for (_n5.innerHTML = e, a = _n5.childNodes.length - 1; a >= 0; a -= 1) {
                this[s].insertBefore(_n5.childNodes[a], this[s].childNodes[0]);
              }
            } else if (e instanceof p) for (a = 0; a < e.length; a += 1) {
              this[s].insertBefore(e[a], this[s].childNodes[0]);
            } else this[s].insertBefore(e, this[s].childNodes[0]);
          }

          return this;
        },
        next: function next(e) {
          return this.length > 0 ? e ? this[0].nextElementSibling && h(this[0].nextElementSibling).is(e) ? h([this[0].nextElementSibling]) : h([]) : this[0].nextElementSibling ? h([this[0].nextElementSibling]) : h([]) : h([]);
        },
        nextAll: function nextAll(e) {
          var t = [];
          var s = this[0];
          if (!s) return h([]);

          for (; s.nextElementSibling;) {
            var _a4 = s.nextElementSibling;
            e ? h(_a4).is(e) && t.push(_a4) : t.push(_a4), s = _a4;
          }

          return h(t);
        },
        prev: function prev(e) {
          if (this.length > 0) {
            var _t14 = this[0];
            return e ? _t14.previousElementSibling && h(_t14.previousElementSibling).is(e) ? h([_t14.previousElementSibling]) : h([]) : _t14.previousElementSibling ? h([_t14.previousElementSibling]) : h([]);
          }

          return h([]);
        },
        prevAll: function prevAll(e) {
          var t = [];
          var s = this[0];
          if (!s) return h([]);

          for (; s.previousElementSibling;) {
            var _a5 = s.previousElementSibling;
            e ? h(_a5).is(e) && t.push(_a5) : t.push(_a5), s = _a5;
          }

          return h(t);
        },
        parent: function parent(e) {
          var t = [];

          for (var _s10 = 0; _s10 < this.length; _s10 += 1) {
            null !== this[_s10].parentNode && (e ? h(this[_s10].parentNode).is(e) && t.push(this[_s10].parentNode) : t.push(this[_s10].parentNode));
          }

          return h(t);
        },
        parents: function parents(e) {
          var t = [];

          for (var _s11 = 0; _s11 < this.length; _s11 += 1) {
            var _a6 = this[_s11].parentNode;

            for (; _a6;) {
              e ? h(_a6).is(e) && t.push(_a6) : t.push(_a6), _a6 = _a6.parentNode;
            }
          }

          return h(t);
        },
        closest: function closest(e) {
          var t = this;
          return void 0 === e ? h([]) : (t.is(e) || (t = t.parents(e).eq(0)), t);
        },
        find: function find(e) {
          var t = [];

          for (var _s12 = 0; _s12 < this.length; _s12 += 1) {
            var _a7 = this[_s12].querySelectorAll(e);

            for (var _e20 = 0; _e20 < _a7.length; _e20 += 1) {
              t.push(_a7[_e20]);
            }
          }

          return h(t);
        },
        children: function children(e) {
          var t = [];

          for (var _s13 = 0; _s13 < this.length; _s13 += 1) {
            var _a8 = this[_s13].children;

            for (var _s14 = 0; _s14 < _a8.length; _s14 += 1) {
              e && !h(_a8[_s14]).is(e) || t.push(_a8[_s14]);
            }
          }

          return h(t);
        },
        filter: function filter(e) {
          return h(m(this, e));
        },
        remove: function remove() {
          for (var _e21 = 0; _e21 < this.length; _e21 += 1) {
            this[_e21].parentNode && this[_e21].parentNode.removeChild(this[_e21]);
          }

          return this;
        }
      };
      Object.keys(v).forEach(function (e) {
        Object.defineProperty(h.fn, e, {
          value: v[e],
          writable: !0
        });
      });
      var b = h;

      function w(e, t) {
        return void 0 === t && (t = 0), setTimeout(e, t);
      }

      function y() {
        return Date.now();
      }

      function C(e) {
        return "object" == _typeof(e) && null !== e && e.constructor && "Object" === Object.prototype.toString.call(e).slice(8, -1);
      }

      function E(e) {
        return "undefined" != typeof window && void 0 !== window.HTMLElement ? e instanceof HTMLElement : e && (1 === e.nodeType || 11 === e.nodeType);
      }

      function S() {
        var e = Object(arguments.length <= 0 ? void 0 : arguments[0]),
            t = ["__proto__", "constructor", "prototype"];

        for (var _s15 = 1; _s15 < arguments.length; _s15 += 1) {
          var _a9 = _s15 < 0 || arguments.length <= _s15 ? void 0 : arguments[_s15];

          if (null != _a9 && !E(_a9)) {
            var _s16 = Object.keys(Object(_a9)).filter(function (e) {
              return t.indexOf(e) < 0;
            });

            for (var _t15 = 0, _n6 = _s16.length; _t15 < _n6; _t15 += 1) {
              var _n7 = _s16[_t15],
                  _i5 = Object.getOwnPropertyDescriptor(_a9, _n7);

              void 0 !== _i5 && _i5.enumerable && (C(e[_n7]) && C(_a9[_n7]) ? _a9[_n7].__swiper__ ? e[_n7] = _a9[_n7] : S(e[_n7], _a9[_n7]) : !C(e[_n7]) && C(_a9[_n7]) ? (e[_n7] = {}, _a9[_n7].__swiper__ ? e[_n7] = _a9[_n7] : S(e[_n7], _a9[_n7])) : e[_n7] = _a9[_n7]);
            }
          }
        }

        return e;
      }

      function T(e, t, s) {
        e.style.setProperty(t, s);
      }

      function x(e) {
        var t = e.swiper,
            s = e.targetPosition,
            a = e.side;
        var n = c(),
            i = -t.translate;
        var r,
            l = null;
        var o = t.params.speed;
        t.wrapperEl.style.scrollSnapType = "none", n.cancelAnimationFrame(t.cssModeFrameID);

        var d = s > i ? "next" : "prev",
            p = function p(e, t) {
          return "next" === d && e >= t || "prev" === d && e <= t;
        },
            u = function u() {
          r = new Date().getTime(), null === l && (l = r);
          var e = Math.max(Math.min((r - l) / o, 1), 0),
              d = .5 - Math.cos(e * Math.PI) / 2;
          var c = i + d * (s - i);
          if (p(c, s) && (c = s), t.wrapperEl.scrollTo(_defineProperty({}, a, c)), p(c, s)) return t.wrapperEl.style.overflow = "hidden", t.wrapperEl.style.scrollSnapType = "", setTimeout(function () {
            t.wrapperEl.style.overflow = "", t.wrapperEl.scrollTo(_defineProperty({}, a, c));
          }), void n.cancelAnimationFrame(t.cssModeFrameID);
          t.cssModeFrameID = n.requestAnimationFrame(u);
        };

        u();
      }

      var k, _, P;

      function M() {
        return k || (k = function () {
          var e = c(),
              t = o();
          return {
            smoothScroll: t.documentElement && "scrollBehavior" in t.documentElement.style,
            touch: !!("ontouchstart" in e || e.DocumentTouch && t instanceof e.DocumentTouch),
            passiveListener: function () {
              var t = !1;

              try {
                var _s17 = Object.defineProperty({}, "passive", {
                  get: function get() {
                    t = !0;
                  }
                });

                e.addEventListener("testPassiveListener", null, _s17);
              } catch (e) {}

              return t;
            }(),
            gestures: "ongesturestart" in e
          };
        }()), k;
      }

      var $ = {
        on: function on(e, t, s) {
          var a = this;
          if (!a.eventsListeners || a.destroyed) return a;
          if ("function" != typeof t) return a;
          var n = s ? "unshift" : "push";
          return e.split(" ").forEach(function (e) {
            a.eventsListeners[e] || (a.eventsListeners[e] = []), a.eventsListeners[e][n](t);
          }), a;
        },
        once: function once(e, t, s) {
          var a = this;
          if (!a.eventsListeners || a.destroyed) return a;
          if ("function" != typeof t) return a;

          function n() {
            a.off(e, n), n.__emitterProxy && delete n.__emitterProxy;

            for (var s = arguments.length, i = new Array(s), r = 0; r < s; r++) {
              i[r] = arguments[r];
            }

            t.apply(a, i);
          }

          return n.__emitterProxy = t, a.on(e, n, s);
        },
        onAny: function onAny(e, t) {
          var s = this;
          if (!s.eventsListeners || s.destroyed) return s;
          if ("function" != typeof e) return s;
          var a = t ? "unshift" : "push";
          return s.eventsAnyListeners.indexOf(e) < 0 && s.eventsAnyListeners[a](e), s;
        },
        offAny: function offAny(e) {
          var t = this;
          if (!t.eventsListeners || t.destroyed) return t;
          if (!t.eventsAnyListeners) return t;
          var s = t.eventsAnyListeners.indexOf(e);
          return s >= 0 && t.eventsAnyListeners.splice(s, 1), t;
        },
        off: function off(e, t) {
          var s = this;
          return !s.eventsListeners || s.destroyed ? s : s.eventsListeners ? (e.split(" ").forEach(function (e) {
            void 0 === t ? s.eventsListeners[e] = [] : s.eventsListeners[e] && s.eventsListeners[e].forEach(function (a, n) {
              (a === t || a.__emitterProxy && a.__emitterProxy === t) && s.eventsListeners[e].splice(n, 1);
            });
          }), s) : s;
        },
        emit: function emit() {
          var e = this;
          if (!e.eventsListeners || e.destroyed) return e;
          if (!e.eventsListeners) return e;
          var t, s, a;

          for (var n = arguments.length, i = new Array(n), r = 0; r < n; r++) {
            i[r] = arguments[r];
          }

          return "string" == typeof i[0] || Array.isArray(i[0]) ? (t = i[0], s = i.slice(1, i.length), a = e) : (t = i[0].events, s = i[0].data, a = i[0].context || e), s.unshift(a), (Array.isArray(t) ? t : t.split(" ")).forEach(function (t) {
            e.eventsAnyListeners && e.eventsAnyListeners.length && e.eventsAnyListeners.forEach(function (e) {
              e.apply(a, [t].concat(_toConsumableArray(s)));
            }), e.eventsListeners && e.eventsListeners[t] && e.eventsListeners[t].forEach(function (e) {
              e.apply(a, s);
            });
          }), e;
        }
      },
          O = {
        updateSize: function updateSize() {
          var e = this;
          var t, s;
          var a = e.$el;
          t = void 0 !== e.params.width && null !== e.params.width ? e.params.width : a[0].clientWidth, s = void 0 !== e.params.height && null !== e.params.height ? e.params.height : a[0].clientHeight, 0 === t && e.isHorizontal() || 0 === s && e.isVertical() || (t = t - parseInt(a.css("padding-left") || 0, 10) - parseInt(a.css("padding-right") || 0, 10), s = s - parseInt(a.css("padding-top") || 0, 10) - parseInt(a.css("padding-bottom") || 0, 10), Number.isNaN(t) && (t = 0), Number.isNaN(s) && (s = 0), Object.assign(e, {
            width: t,
            height: s,
            size: e.isHorizontal() ? t : s
          }));
        },
        updateSlides: function updateSlides() {
          var e = this;

          function t(t) {
            return e.isHorizontal() ? t : {
              width: "height",
              "margin-top": "margin-left",
              "margin-bottom ": "margin-right",
              "margin-left": "margin-top",
              "margin-right": "margin-bottom",
              "padding-left": "padding-top",
              "padding-right": "padding-bottom",
              marginRight: "marginBottom"
            }[t];
          }

          function s(e, s) {
            return parseFloat(e.getPropertyValue(t(s)) || 0);
          }

          var a = e.params,
              n = e.$wrapperEl,
              i = e.size,
              r = e.rtlTranslate,
              l = e.wrongRTL,
              o = e.virtual && a.virtual.enabled,
              d = o ? e.virtual.slides.length : e.slides.length,
              c = n.children(".".concat(e.params.slideClass)),
              p = o ? e.virtual.slides.length : c.length;
          var u = [];
          var m = [],
              h = [];
          var f = a.slidesOffsetBefore;
          "function" == typeof f && (f = a.slidesOffsetBefore.call(e));
          var g = a.slidesOffsetAfter;
          "function" == typeof g && (g = a.slidesOffsetAfter.call(e));
          var v = e.snapGrid.length,
              b = e.slidesGrid.length;
          var w = a.spaceBetween,
              y = -f,
              C = 0,
              E = 0;
          if (void 0 === i) return;
          "string" == typeof w && w.indexOf("%") >= 0 && (w = parseFloat(w.replace("%", "")) / 100 * i), e.virtualSize = -w, r ? c.css({
            marginLeft: "",
            marginBottom: "",
            marginTop: ""
          }) : c.css({
            marginRight: "",
            marginBottom: "",
            marginTop: ""
          }), a.centeredSlides && a.cssMode && (T(e.wrapperEl, "--swiper-centered-offset-before", ""), T(e.wrapperEl, "--swiper-centered-offset-after", ""));
          var S = a.grid && a.grid.rows > 1 && e.grid;
          var x;
          S && e.grid.initSlides(p);
          var k = "auto" === a.slidesPerView && a.breakpoints && Object.keys(a.breakpoints).filter(function (e) {
            return void 0 !== a.breakpoints[e].slidesPerView;
          }).length > 0;

          for (var _n8 = 0; _n8 < p; _n8 += 1) {
            x = 0;

            var _r3 = c.eq(_n8);

            if (S && e.grid.updateSlide(_n8, _r3, p, t), "none" !== _r3.css("display")) {
              if ("auto" === a.slidesPerView) {
                k && (c[_n8].style[t("width")] = "");

                var _i6 = getComputedStyle(_r3[0]),
                    _l2 = _r3[0].style.transform,
                    _o = _r3[0].style.webkitTransform;

                if (_l2 && (_r3[0].style.transform = "none"), _o && (_r3[0].style.webkitTransform = "none"), a.roundLengths) x = e.isHorizontal() ? _r3.outerWidth(!0) : _r3.outerHeight(!0);else {
                  var _e22 = s(_i6, "width"),
                      _t16 = s(_i6, "padding-left"),
                      _a10 = s(_i6, "padding-right"),
                      _n9 = s(_i6, "margin-left"),
                      _l3 = s(_i6, "margin-right"),
                      _o2 = _i6.getPropertyValue("box-sizing");

                  if (_o2 && "border-box" === _o2) x = _e22 + _n9 + _l3;else {
                    var _r3$ = _r3[0],
                        _s18 = _r3$.clientWidth,
                        _i7 = _r3$.offsetWidth;
                    x = _e22 + _t16 + _a10 + _n9 + _l3 + (_i7 - _s18);
                  }
                }
                _l2 && (_r3[0].style.transform = _l2), _o && (_r3[0].style.webkitTransform = _o), a.roundLengths && (x = Math.floor(x));
              } else x = (i - (a.slidesPerView - 1) * w) / a.slidesPerView, a.roundLengths && (x = Math.floor(x)), c[_n8] && (c[_n8].style[t("width")] = "".concat(x, "px"));

              c[_n8] && (c[_n8].swiperSlideSize = x), h.push(x), a.centeredSlides ? (y = y + x / 2 + C / 2 + w, 0 === C && 0 !== _n8 && (y = y - i / 2 - w), 0 === _n8 && (y = y - i / 2 - w), Math.abs(y) < .001 && (y = 0), a.roundLengths && (y = Math.floor(y)), E % a.slidesPerGroup == 0 && u.push(y), m.push(y)) : (a.roundLengths && (y = Math.floor(y)), (E - Math.min(e.params.slidesPerGroupSkip, E)) % e.params.slidesPerGroup == 0 && u.push(y), m.push(y), y = y + x + w), e.virtualSize += x + w, C = x, E += 1;
            }
          }

          if (e.virtualSize = Math.max(e.virtualSize, i) + g, r && l && ("slide" === a.effect || "coverflow" === a.effect) && n.css({
            width: "".concat(e.virtualSize + a.spaceBetween, "px")
          }), a.setWrapperSize && n.css(_defineProperty({}, t("width"), "".concat(e.virtualSize + a.spaceBetween, "px"))), S && e.grid.updateWrapperSize(x, u, t), !a.centeredSlides) {
            var _t17 = [];

            for (var _s19 = 0; _s19 < u.length; _s19 += 1) {
              var _n10 = u[_s19];
              a.roundLengths && (_n10 = Math.floor(_n10)), u[_s19] <= e.virtualSize - i && _t17.push(_n10);
            }

            u = _t17, Math.floor(e.virtualSize - i) - Math.floor(u[u.length - 1]) > 1 && u.push(e.virtualSize - i);
          }

          if (0 === u.length && (u = [0]), 0 !== a.spaceBetween) {
            var _s20 = e.isHorizontal() && r ? "marginLeft" : t("marginRight");

            c.filter(function (e, t) {
              return !a.cssMode || t !== c.length - 1;
            }).css(_defineProperty({}, _s20, "".concat(w, "px")));
          }

          if (a.centeredSlides && a.centeredSlidesBounds) {
            var _e23 = 0;
            h.forEach(function (t) {
              _e23 += t + (a.spaceBetween ? a.spaceBetween : 0);
            }), _e23 -= a.spaceBetween;

            var _t18 = _e23 - i;

            u = u.map(function (e) {
              return e < 0 ? -f : e > _t18 ? _t18 + g : e;
            });
          }

          if (a.centerInsufficientSlides) {
            var _e24 = 0;

            if (h.forEach(function (t) {
              _e24 += t + (a.spaceBetween ? a.spaceBetween : 0);
            }), _e24 -= a.spaceBetween, _e24 < i) {
              var _t19 = (i - _e24) / 2;

              u.forEach(function (e, s) {
                u[s] = e - _t19;
              }), m.forEach(function (e, s) {
                m[s] = e + _t19;
              });
            }
          }

          if (Object.assign(e, {
            slides: c,
            snapGrid: u,
            slidesGrid: m,
            slidesSizesGrid: h
          }), a.centeredSlides && a.cssMode && !a.centeredSlidesBounds) {
            T(e.wrapperEl, "--swiper-centered-offset-before", -u[0] + "px"), T(e.wrapperEl, "--swiper-centered-offset-after", e.size / 2 - h[h.length - 1] / 2 + "px");

            var _t20 = -e.snapGrid[0],
                _s21 = -e.slidesGrid[0];

            e.snapGrid = e.snapGrid.map(function (e) {
              return e + _t20;
            }), e.slidesGrid = e.slidesGrid.map(function (e) {
              return e + _s21;
            });
          }

          if (p !== d && e.emit("slidesLengthChange"), u.length !== v && (e.params.watchOverflow && e.checkOverflow(), e.emit("snapGridLengthChange")), m.length !== b && e.emit("slidesGridLengthChange"), a.watchSlidesProgress && e.updateSlidesOffset(), !(o || a.cssMode || "slide" !== a.effect && "fade" !== a.effect)) {
            var _t21 = "".concat(a.containerModifierClass, "backface-hidden"),
                _s22 = e.$el.hasClass(_t21);

            p <= a.maxBackfaceHiddenSlides ? _s22 || e.$el.addClass(_t21) : _s22 && e.$el.removeClass(_t21);
          }
        },
        updateAutoHeight: function updateAutoHeight(e) {
          var t = this,
              s = [],
              a = t.virtual && t.params.virtual.enabled;
          var n,
              i = 0;
          "number" == typeof e ? t.setTransition(e) : !0 === e && t.setTransition(t.params.speed);

          var r = function r(e) {
            return a ? t.slides.filter(function (t) {
              return parseInt(t.getAttribute("data-swiper-slide-index"), 10) === e;
            })[0] : t.slides.eq(e)[0];
          };

          if ("auto" !== t.params.slidesPerView && t.params.slidesPerView > 1) {
            if (t.params.centeredSlides) t.visibleSlides.each(function (e) {
              s.push(e);
            });else for (n = 0; n < Math.ceil(t.params.slidesPerView); n += 1) {
              var _e25 = t.activeIndex + n;

              if (_e25 > t.slides.length && !a) break;
              s.push(r(_e25));
            }
          } else s.push(r(t.activeIndex));

          for (n = 0; n < s.length; n += 1) {
            if (void 0 !== s[n]) {
              var _e26 = s[n].offsetHeight;
              i = _e26 > i ? _e26 : i;
            }
          }

          (i || 0 === i) && t.$wrapperEl.css("height", "".concat(i, "px"));
        },
        updateSlidesOffset: function updateSlidesOffset() {
          var e = this,
              t = e.slides;

          for (var _s23 = 0; _s23 < t.length; _s23 += 1) {
            t[_s23].swiperSlideOffset = e.isHorizontal() ? t[_s23].offsetLeft : t[_s23].offsetTop;
          }
        },
        updateSlidesProgress: function updateSlidesProgress(e) {
          void 0 === e && (e = this && this.translate || 0);
          var t = this,
              s = t.params,
              a = t.slides,
              n = t.rtlTranslate,
              i = t.snapGrid;
          if (0 === a.length) return;
          void 0 === a[0].swiperSlideOffset && t.updateSlidesOffset();
          var r = -e;
          n && (r = e), a.removeClass(s.slideVisibleClass), t.visibleSlidesIndexes = [], t.visibleSlides = [];

          for (var _e27 = 0; _e27 < a.length; _e27 += 1) {
            var _l4 = a[_e27];
            var _o3 = _l4.swiperSlideOffset;
            s.cssMode && s.centeredSlides && (_o3 -= a[0].swiperSlideOffset);

            var _d3 = (r + (s.centeredSlides ? t.minTranslate() : 0) - _o3) / (_l4.swiperSlideSize + s.spaceBetween),
                _c = (r - i[0] + (s.centeredSlides ? t.minTranslate() : 0) - _o3) / (_l4.swiperSlideSize + s.spaceBetween),
                _p = -(r - _o3),
                _u = _p + t.slidesSizesGrid[_e27];

            (_p >= 0 && _p < t.size - 1 || _u > 1 && _u <= t.size || _p <= 0 && _u >= t.size) && (t.visibleSlides.push(_l4), t.visibleSlidesIndexes.push(_e27), a.eq(_e27).addClass(s.slideVisibleClass)), _l4.progress = n ? -_d3 : _d3, _l4.originalProgress = n ? -_c : _c;
          }

          t.visibleSlides = b(t.visibleSlides);
        },
        updateProgress: function updateProgress(e) {
          var t = this;

          if (void 0 === e) {
            var _s24 = t.rtlTranslate ? -1 : 1;

            e = t && t.translate && t.translate * _s24 || 0;
          }

          var s = t.params,
              a = t.maxTranslate() - t.minTranslate();
          var n = t.progress,
              i = t.isBeginning,
              r = t.isEnd;
          var l = i,
              o = r;
          0 === a ? (n = 0, i = !0, r = !0) : (n = (e - t.minTranslate()) / a, i = n <= 0, r = n >= 1), Object.assign(t, {
            progress: n,
            isBeginning: i,
            isEnd: r
          }), (s.watchSlidesProgress || s.centeredSlides && s.autoHeight) && t.updateSlidesProgress(e), i && !l && t.emit("reachBeginning toEdge"), r && !o && t.emit("reachEnd toEdge"), (l && !i || o && !r) && t.emit("fromEdge"), t.emit("progress", n);
        },
        updateSlidesClasses: function updateSlidesClasses() {
          var e = this,
              t = e.slides,
              s = e.params,
              a = e.$wrapperEl,
              n = e.activeIndex,
              i = e.realIndex,
              r = e.virtual && s.virtual.enabled;
          var l;
          t.removeClass("".concat(s.slideActiveClass, " ").concat(s.slideNextClass, " ").concat(s.slidePrevClass, " ").concat(s.slideDuplicateActiveClass, " ").concat(s.slideDuplicateNextClass, " ").concat(s.slideDuplicatePrevClass)), l = r ? e.$wrapperEl.find(".".concat(s.slideClass, "[data-swiper-slide-index=\"").concat(n, "\"]")) : t.eq(n), l.addClass(s.slideActiveClass), s.loop && (l.hasClass(s.slideDuplicateClass) ? a.children(".".concat(s.slideClass, ":not(.").concat(s.slideDuplicateClass, ")[data-swiper-slide-index=\"").concat(i, "\"]")).addClass(s.slideDuplicateActiveClass) : a.children(".".concat(s.slideClass, ".").concat(s.slideDuplicateClass, "[data-swiper-slide-index=\"").concat(i, "\"]")).addClass(s.slideDuplicateActiveClass));
          var o = l.nextAll(".".concat(s.slideClass)).eq(0).addClass(s.slideNextClass);
          s.loop && 0 === o.length && (o = t.eq(0), o.addClass(s.slideNextClass));
          var d = l.prevAll(".".concat(s.slideClass)).eq(0).addClass(s.slidePrevClass);
          s.loop && 0 === d.length && (d = t.eq(-1), d.addClass(s.slidePrevClass)), s.loop && (o.hasClass(s.slideDuplicateClass) ? a.children(".".concat(s.slideClass, ":not(.").concat(s.slideDuplicateClass, ")[data-swiper-slide-index=\"").concat(o.attr("data-swiper-slide-index"), "\"]")).addClass(s.slideDuplicateNextClass) : a.children(".".concat(s.slideClass, ".").concat(s.slideDuplicateClass, "[data-swiper-slide-index=\"").concat(o.attr("data-swiper-slide-index"), "\"]")).addClass(s.slideDuplicateNextClass), d.hasClass(s.slideDuplicateClass) ? a.children(".".concat(s.slideClass, ":not(.").concat(s.slideDuplicateClass, ")[data-swiper-slide-index=\"").concat(d.attr("data-swiper-slide-index"), "\"]")).addClass(s.slideDuplicatePrevClass) : a.children(".".concat(s.slideClass, ".").concat(s.slideDuplicateClass, "[data-swiper-slide-index=\"").concat(d.attr("data-swiper-slide-index"), "\"]")).addClass(s.slideDuplicatePrevClass)), e.emitSlidesClasses();
        },
        updateActiveIndex: function updateActiveIndex(e) {
          var t = this,
              s = t.rtlTranslate ? t.translate : -t.translate,
              a = t.slidesGrid,
              n = t.snapGrid,
              i = t.params,
              r = t.activeIndex,
              l = t.realIndex,
              o = t.snapIndex;
          var d,
              c = e;

          if (void 0 === c) {
            for (var _e28 = 0; _e28 < a.length; _e28 += 1) {
              void 0 !== a[_e28 + 1] ? s >= a[_e28] && s < a[_e28 + 1] - (a[_e28 + 1] - a[_e28]) / 2 ? c = _e28 : s >= a[_e28] && s < a[_e28 + 1] && (c = _e28 + 1) : s >= a[_e28] && (c = _e28);
            }

            i.normalizeSlideIndex && (c < 0 || void 0 === c) && (c = 0);
          }

          if (n.indexOf(s) >= 0) d = n.indexOf(s);else {
            var _e29 = Math.min(i.slidesPerGroupSkip, c);

            d = _e29 + Math.floor((c - _e29) / i.slidesPerGroup);
          }
          if (d >= n.length && (d = n.length - 1), c === r) return void (d !== o && (t.snapIndex = d, t.emit("snapIndexChange")));
          var p = parseInt(t.slides.eq(c).attr("data-swiper-slide-index") || c, 10);
          Object.assign(t, {
            snapIndex: d,
            realIndex: p,
            previousIndex: r,
            activeIndex: c
          }), t.emit("activeIndexChange"), t.emit("snapIndexChange"), l !== p && t.emit("realIndexChange"), (t.initialized || t.params.runCallbacksOnInit) && t.emit("slideChange");
        },
        updateClickedSlide: function updateClickedSlide(e) {
          var t = this,
              s = t.params,
              a = b(e).closest(".".concat(s.slideClass))[0];
          var n,
              i = !1;
          if (a) for (var _e30 = 0; _e30 < t.slides.length; _e30 += 1) {
            if (t.slides[_e30] === a) {
              i = !0, n = _e30;
              break;
            }
          }
          if (!a || !i) return t.clickedSlide = void 0, void (t.clickedIndex = void 0);
          t.clickedSlide = a, t.virtual && t.params.virtual.enabled ? t.clickedIndex = parseInt(b(a).attr("data-swiper-slide-index"), 10) : t.clickedIndex = n, s.slideToClickedSlide && void 0 !== t.clickedIndex && t.clickedIndex !== t.activeIndex && t.slideToClickedSlide();
        }
      };

      function L(e) {
        var t = e.swiper,
            s = e.runCallbacks,
            a = e.direction,
            n = e.step;
        var i = t.activeIndex,
            r = t.previousIndex;
        var l = a;

        if (l || (l = i > r ? "next" : i < r ? "prev" : "reset"), t.emit("transition".concat(n)), s && i !== r) {
          if ("reset" === l) return void t.emit("slideResetTransition".concat(n));
          t.emit("slideChangeTransition".concat(n)), "next" === l ? t.emit("slideNextTransition".concat(n)) : t.emit("slidePrevTransition".concat(n));
        }
      }

      var D = {
        slideTo: function slideTo(e, t, s, a, n) {
          if (void 0 === e && (e = 0), void 0 === t && (t = this.params.speed), void 0 === s && (s = !0), "number" != typeof e && "string" != typeof e) throw new Error("The 'index' argument cannot have type other than 'number' or 'string'. [".concat(_typeof(e), "] given."));

          if ("string" == typeof e) {
            var _t22 = parseInt(e, 10);

            if (!isFinite(_t22)) throw new Error("The passed-in 'index' (string) couldn't be converted to 'number'. [".concat(e, "] given."));
            e = _t22;
          }

          var i = this;
          var r = e;
          r < 0 && (r = 0);
          var l = i.params,
              o = i.snapGrid,
              d = i.slidesGrid,
              c = i.previousIndex,
              p = i.activeIndex,
              u = i.rtlTranslate,
              m = i.wrapperEl,
              h = i.enabled;
          if (i.animating && l.preventInteractionOnTransition || !h && !a && !n) return !1;
          var f = Math.min(i.params.slidesPerGroupSkip, r);
          var g = f + Math.floor((r - f) / i.params.slidesPerGroup);
          g >= o.length && (g = o.length - 1), (p || l.initialSlide || 0) === (c || 0) && s && i.emit("beforeSlideChangeStart");
          var v = -o[g];
          if (i.updateProgress(v), l.normalizeSlideIndex) for (var _e31 = 0; _e31 < d.length; _e31 += 1) {
            var _t23 = -Math.floor(100 * v),
                _s25 = Math.floor(100 * d[_e31]),
                _a11 = Math.floor(100 * d[_e31 + 1]);

            void 0 !== d[_e31 + 1] ? _t23 >= _s25 && _t23 < _a11 - (_a11 - _s25) / 2 ? r = _e31 : _t23 >= _s25 && _t23 < _a11 && (r = _e31 + 1) : _t23 >= _s25 && (r = _e31);
          }

          if (i.initialized && r !== p) {
            if (!i.allowSlideNext && v < i.translate && v < i.minTranslate()) return !1;
            if (!i.allowSlidePrev && v > i.translate && v > i.maxTranslate() && (p || 0) !== r) return !1;
          }

          var b;
          if (b = r > p ? "next" : r < p ? "prev" : "reset", u && -v === i.translate || !u && v === i.translate) return i.updateActiveIndex(r), l.autoHeight && i.updateAutoHeight(), i.updateSlidesClasses(), "slide" !== l.effect && i.setTranslate(v), "reset" !== b && (i.transitionStart(s, b), i.transitionEnd(s, b)), !1;

          if (l.cssMode) {
            var _e32 = i.isHorizontal(),
                _s26 = u ? v : -v;

            if (0 === t) {
              var _t24 = i.virtual && i.params.virtual.enabled;

              _t24 && (i.wrapperEl.style.scrollSnapType = "none", i._immediateVirtual = !0), m[_e32 ? "scrollLeft" : "scrollTop"] = _s26, _t24 && requestAnimationFrame(function () {
                i.wrapperEl.style.scrollSnapType = "", i._swiperImmediateVirtual = !1;
              });
            } else {
              var _m$scrollTo;

              if (!i.support.smoothScroll) return x({
                swiper: i,
                targetPosition: _s26,
                side: _e32 ? "left" : "top"
              }), !0;
              m.scrollTo((_m$scrollTo = {}, _defineProperty(_m$scrollTo, _e32 ? "left" : "top", _s26), _defineProperty(_m$scrollTo, "behavior", "smooth"), _m$scrollTo));
            }

            return !0;
          }

          return i.setTransition(t), i.setTranslate(v), i.updateActiveIndex(r), i.updateSlidesClasses(), i.emit("beforeTransitionStart", t, a), i.transitionStart(s, b), 0 === t ? i.transitionEnd(s, b) : i.animating || (i.animating = !0, i.onSlideToWrapperTransitionEnd || (i.onSlideToWrapperTransitionEnd = function (e) {
            i && !i.destroyed && e.target === this && (i.$wrapperEl[0].removeEventListener("transitionend", i.onSlideToWrapperTransitionEnd), i.$wrapperEl[0].removeEventListener("webkitTransitionEnd", i.onSlideToWrapperTransitionEnd), i.onSlideToWrapperTransitionEnd = null, delete i.onSlideToWrapperTransitionEnd, i.transitionEnd(s, b));
          }), i.$wrapperEl[0].addEventListener("transitionend", i.onSlideToWrapperTransitionEnd), i.$wrapperEl[0].addEventListener("webkitTransitionEnd", i.onSlideToWrapperTransitionEnd)), !0;
        },
        slideToLoop: function slideToLoop(e, t, s, a) {
          void 0 === e && (e = 0), void 0 === t && (t = this.params.speed), void 0 === s && (s = !0);
          var n = this;
          var i = e;
          return n.params.loop && (i += n.loopedSlides), n.slideTo(i, t, s, a);
        },
        slideNext: function slideNext(e, t, s) {
          void 0 === e && (e = this.params.speed), void 0 === t && (t = !0);
          var a = this,
              n = a.animating,
              i = a.enabled,
              r = a.params;
          if (!i) return a;
          var l = r.slidesPerGroup;
          "auto" === r.slidesPerView && 1 === r.slidesPerGroup && r.slidesPerGroupAuto && (l = Math.max(a.slidesPerViewDynamic("current", !0), 1));
          var o = a.activeIndex < r.slidesPerGroupSkip ? 1 : l;

          if (r.loop) {
            if (n && r.loopPreventsSlide) return !1;
            a.loopFix(), a._clientLeft = a.$wrapperEl[0].clientLeft;
          }

          return r.rewind && a.isEnd ? a.slideTo(0, e, t, s) : a.slideTo(a.activeIndex + o, e, t, s);
        },
        slidePrev: function slidePrev(e, t, s) {
          void 0 === e && (e = this.params.speed), void 0 === t && (t = !0);
          var a = this,
              n = a.params,
              i = a.animating,
              r = a.snapGrid,
              l = a.slidesGrid,
              o = a.rtlTranslate,
              d = a.enabled;
          if (!d) return a;

          if (n.loop) {
            if (i && n.loopPreventsSlide) return !1;
            a.loopFix(), a._clientLeft = a.$wrapperEl[0].clientLeft;
          }

          function c(e) {
            return e < 0 ? -Math.floor(Math.abs(e)) : Math.floor(e);
          }

          var p = c(o ? a.translate : -a.translate),
              u = r.map(function (e) {
            return c(e);
          });
          var m = r[u.indexOf(p) - 1];

          if (void 0 === m && n.cssMode) {
            var _e33;

            r.forEach(function (t, s) {
              p >= t && (_e33 = s);
            }), void 0 !== _e33 && (m = r[_e33 > 0 ? _e33 - 1 : _e33]);
          }

          var h = 0;

          if (void 0 !== m && (h = l.indexOf(m), h < 0 && (h = a.activeIndex - 1), "auto" === n.slidesPerView && 1 === n.slidesPerGroup && n.slidesPerGroupAuto && (h = h - a.slidesPerViewDynamic("previous", !0) + 1, h = Math.max(h, 0))), n.rewind && a.isBeginning) {
            var _n11 = a.params.virtual && a.params.virtual.enabled && a.virtual ? a.virtual.slides.length - 1 : a.slides.length - 1;

            return a.slideTo(_n11, e, t, s);
          }

          return a.slideTo(h, e, t, s);
        },
        slideReset: function slideReset(e, t, s) {
          return void 0 === e && (e = this.params.speed), void 0 === t && (t = !0), this.slideTo(this.activeIndex, e, t, s);
        },
        slideToClosest: function slideToClosest(e, t, s, a) {
          void 0 === e && (e = this.params.speed), void 0 === t && (t = !0), void 0 === a && (a = .5);
          var n = this;
          var i = n.activeIndex;
          var r = Math.min(n.params.slidesPerGroupSkip, i),
              l = r + Math.floor((i - r) / n.params.slidesPerGroup),
              o = n.rtlTranslate ? n.translate : -n.translate;

          if (o >= n.snapGrid[l]) {
            var _e34 = n.snapGrid[l];
            o - _e34 > (n.snapGrid[l + 1] - _e34) * a && (i += n.params.slidesPerGroup);
          } else {
            var _e35 = n.snapGrid[l - 1];
            o - _e35 <= (n.snapGrid[l] - _e35) * a && (i -= n.params.slidesPerGroup);
          }

          return i = Math.max(i, 0), i = Math.min(i, n.slidesGrid.length - 1), n.slideTo(i, e, t, s);
        },
        slideToClickedSlide: function slideToClickedSlide() {
          var e = this,
              t = e.params,
              s = e.$wrapperEl,
              a = "auto" === t.slidesPerView ? e.slidesPerViewDynamic() : t.slidesPerView;
          var n,
              i = e.clickedIndex;

          if (t.loop) {
            if (e.animating) return;
            n = parseInt(b(e.clickedSlide).attr("data-swiper-slide-index"), 10), t.centeredSlides ? i < e.loopedSlides - a / 2 || i > e.slides.length - e.loopedSlides + a / 2 ? (e.loopFix(), i = s.children(".".concat(t.slideClass, "[data-swiper-slide-index=\"").concat(n, "\"]:not(.").concat(t.slideDuplicateClass, ")")).eq(0).index(), w(function () {
              e.slideTo(i);
            })) : e.slideTo(i) : i > e.slides.length - a ? (e.loopFix(), i = s.children(".".concat(t.slideClass, "[data-swiper-slide-index=\"").concat(n, "\"]:not(.").concat(t.slideDuplicateClass, ")")).eq(0).index(), w(function () {
              e.slideTo(i);
            })) : e.slideTo(i);
          } else e.slideTo(i);
        }
      },
          N = {
        loopCreate: function loopCreate() {
          var e = this,
              t = o(),
              s = e.params,
              a = e.$wrapperEl,
              n = a.children().length > 0 ? b(a.children()[0].parentNode) : a;
          n.children(".".concat(s.slideClass, ".").concat(s.slideDuplicateClass)).remove();
          var i = n.children(".".concat(s.slideClass));

          if (s.loopFillGroupWithBlank) {
            var _e36 = s.slidesPerGroup - i.length % s.slidesPerGroup;

            if (_e36 !== s.slidesPerGroup) {
              for (var _a12 = 0; _a12 < _e36; _a12 += 1) {
                var _e37 = b(t.createElement("div")).addClass("".concat(s.slideClass, " ").concat(s.slideBlankClass));

                n.append(_e37);
              }

              i = n.children(".".concat(s.slideClass));
            }
          }

          "auto" !== s.slidesPerView || s.loopedSlides || (s.loopedSlides = i.length), e.loopedSlides = Math.ceil(parseFloat(s.loopedSlides || s.slidesPerView, 10)), e.loopedSlides += s.loopAdditionalSlides, e.loopedSlides > i.length && (e.loopedSlides = i.length);
          var r = [],
              l = [];
          i.each(function (t, s) {
            var a = b(t);
            s < e.loopedSlides && l.push(t), s < i.length && s >= i.length - e.loopedSlides && r.push(t), a.attr("data-swiper-slide-index", s);
          });

          for (var _e38 = 0; _e38 < l.length; _e38 += 1) {
            n.append(b(l[_e38].cloneNode(!0)).addClass(s.slideDuplicateClass));
          }

          for (var _e39 = r.length - 1; _e39 >= 0; _e39 -= 1) {
            n.prepend(b(r[_e39].cloneNode(!0)).addClass(s.slideDuplicateClass));
          }
        },
        loopFix: function loopFix() {
          var e = this;
          e.emit("beforeLoopFix");
          var t = e.activeIndex,
              s = e.slides,
              a = e.loopedSlides,
              n = e.allowSlidePrev,
              i = e.allowSlideNext,
              r = e.snapGrid,
              l = e.rtlTranslate;
          var o;
          e.allowSlidePrev = !0, e.allowSlideNext = !0;
          var d = -r[t] - e.getTranslate();
          t < a ? (o = s.length - 3 * a + t, o += a, e.slideTo(o, 0, !1, !0) && 0 !== d && e.setTranslate((l ? -e.translate : e.translate) - d)) : t >= s.length - a && (o = -s.length + t + a, o += a, e.slideTo(o, 0, !1, !0) && 0 !== d && e.setTranslate((l ? -e.translate : e.translate) - d)), e.allowSlidePrev = n, e.allowSlideNext = i, e.emit("loopFix");
        },
        loopDestroy: function loopDestroy() {
          var e = this.$wrapperEl,
              t = this.params,
              s = this.slides;
          e.children(".".concat(t.slideClass, ".").concat(t.slideDuplicateClass, ",.").concat(t.slideClass, ".").concat(t.slideBlankClass)).remove(), s.removeAttr("data-swiper-slide-index");
        }
      };

      function A(e) {
        var t = this,
            s = o(),
            a = c(),
            n = t.touchEventsData,
            i = t.params,
            r = t.touches,
            l = t.enabled;
        if (!l) return;
        if (t.animating && i.preventInteractionOnTransition) return;
        !t.animating && i.cssMode && i.loop && t.loopFix();
        var d = e;
        d.originalEvent && (d = d.originalEvent);
        var p = b(d.target);
        if ("wrapper" === i.touchEventsTarget && !p.closest(t.wrapperEl).length) return;
        if (n.isTouchEvent = "touchstart" === d.type, !n.isTouchEvent && "which" in d && 3 === d.which) return;
        if (!n.isTouchEvent && "button" in d && d.button > 0) return;
        if (n.isTouched && n.isMoved) return;
        i.noSwipingClass && "" !== i.noSwipingClass && d.target && d.target.shadowRoot && e.path && e.path[0] && (p = b(e.path[0]));
        var u = i.noSwipingSelector ? i.noSwipingSelector : ".".concat(i.noSwipingClass),
            m = !(!d.target || !d.target.shadowRoot);
        if (i.noSwiping && (m ? function (e, t) {
          return void 0 === t && (t = this), function t(s) {
            return s && s !== o() && s !== c() ? (s.assignedSlot && (s = s.assignedSlot), s.closest(e) || t(s.getRootNode().host)) : null;
          }(t);
        }(u, d.target) : p.closest(u)[0])) return void (t.allowClick = !0);
        if (i.swipeHandler && !p.closest(i.swipeHandler)[0]) return;
        r.currentX = "touchstart" === d.type ? d.targetTouches[0].pageX : d.pageX, r.currentY = "touchstart" === d.type ? d.targetTouches[0].pageY : d.pageY;
        var h = r.currentX,
            f = r.currentY,
            g = i.edgeSwipeDetection || i.iOSEdgeSwipeDetection,
            v = i.edgeSwipeThreshold || i.iOSEdgeSwipeThreshold;

        if (g && (h <= v || h >= a.innerWidth - v)) {
          if ("prevent" !== g) return;
          e.preventDefault();
        }

        if (Object.assign(n, {
          isTouched: !0,
          isMoved: !1,
          allowTouchCallbacks: !0,
          isScrolling: void 0,
          startMoving: void 0
        }), r.startX = h, r.startY = f, n.touchStartTime = y(), t.allowClick = !0, t.updateSize(), t.swipeDirection = void 0, i.threshold > 0 && (n.allowThresholdMove = !1), "touchstart" !== d.type) {
          var _e40 = !0;

          p.is(n.focusableElements) && (_e40 = !1, "SELECT" === p[0].nodeName && (n.isTouched = !1)), s.activeElement && b(s.activeElement).is(n.focusableElements) && s.activeElement !== p[0] && s.activeElement.blur();

          var _a13 = _e40 && t.allowTouchMove && i.touchStartPreventDefault;

          !i.touchStartForcePreventDefault && !_a13 || p[0].isContentEditable || d.preventDefault();
        }

        t.params.freeMode && t.params.freeMode.enabled && t.freeMode && t.animating && !i.cssMode && t.freeMode.onTouchStart(), t.emit("touchStart", d);
      }

      function I(e) {
        var t = o(),
            s = this,
            a = s.touchEventsData,
            n = s.params,
            i = s.touches,
            r = s.rtlTranslate,
            l = s.enabled;
        if (!l) return;
        var d = e;
        if (d.originalEvent && (d = d.originalEvent), !a.isTouched) return void (a.startMoving && a.isScrolling && s.emit("touchMoveOpposite", d));
        if (a.isTouchEvent && "touchmove" !== d.type) return;
        var c = "touchmove" === d.type && d.targetTouches && (d.targetTouches[0] || d.changedTouches[0]),
            p = "touchmove" === d.type ? c.pageX : d.pageX,
            u = "touchmove" === d.type ? c.pageY : d.pageY;
        if (d.preventedByNestedSwiper) return i.startX = p, void (i.startY = u);
        if (!s.allowTouchMove) return b(d.target).is(a.focusableElements) || (s.allowClick = !1), void (a.isTouched && (Object.assign(i, {
          startX: p,
          startY: u,
          currentX: p,
          currentY: u
        }), a.touchStartTime = y()));
        if (a.isTouchEvent && n.touchReleaseOnEdges && !n.loop) if (s.isVertical()) {
          if (u < i.startY && s.translate <= s.maxTranslate() || u > i.startY && s.translate >= s.minTranslate()) return a.isTouched = !1, void (a.isMoved = !1);
        } else if (p < i.startX && s.translate <= s.maxTranslate() || p > i.startX && s.translate >= s.minTranslate()) return;
        if (a.isTouchEvent && t.activeElement && d.target === t.activeElement && b(d.target).is(a.focusableElements)) return a.isMoved = !0, void (s.allowClick = !1);
        if (a.allowTouchCallbacks && s.emit("touchMove", d), d.targetTouches && d.targetTouches.length > 1) return;
        i.currentX = p, i.currentY = u;
        var m = i.currentX - i.startX,
            h = i.currentY - i.startY;
        if (s.params.threshold && Math.sqrt(Math.pow(m, 2) + Math.pow(h, 2)) < s.params.threshold) return;

        if (void 0 === a.isScrolling) {
          var _e41;

          s.isHorizontal() && i.currentY === i.startY || s.isVertical() && i.currentX === i.startX ? a.isScrolling = !1 : m * m + h * h >= 25 && (_e41 = 180 * Math.atan2(Math.abs(h), Math.abs(m)) / Math.PI, a.isScrolling = s.isHorizontal() ? _e41 > n.touchAngle : 90 - _e41 > n.touchAngle);
        }

        if (a.isScrolling && s.emit("touchMoveOpposite", d), void 0 === a.startMoving && (i.currentX === i.startX && i.currentY === i.startY || (a.startMoving = !0)), a.isScrolling) return void (a.isTouched = !1);
        if (!a.startMoving) return;
        s.allowClick = !1, !n.cssMode && d.cancelable && d.preventDefault(), n.touchMoveStopPropagation && !n.nested && d.stopPropagation(), a.isMoved || (n.loop && !n.cssMode && s.loopFix(), a.startTranslate = s.getTranslate(), s.setTransition(0), s.animating && s.$wrapperEl.trigger("webkitTransitionEnd transitionend"), a.allowMomentumBounce = !1, !n.grabCursor || !0 !== s.allowSlideNext && !0 !== s.allowSlidePrev || s.setGrabCursor(!0), s.emit("sliderFirstMove", d)), s.emit("sliderMove", d), a.isMoved = !0;
        var f = s.isHorizontal() ? m : h;
        i.diff = f, f *= n.touchRatio, r && (f = -f), s.swipeDirection = f > 0 ? "prev" : "next", a.currentTranslate = f + a.startTranslate;
        var g = !0,
            v = n.resistanceRatio;

        if (n.touchReleaseOnEdges && (v = 0), f > 0 && a.currentTranslate > s.minTranslate() ? (g = !1, n.resistance && (a.currentTranslate = s.minTranslate() - 1 + Math.pow(-s.minTranslate() + a.startTranslate + f, v))) : f < 0 && a.currentTranslate < s.maxTranslate() && (g = !1, n.resistance && (a.currentTranslate = s.maxTranslate() + 1 - Math.pow(s.maxTranslate() - a.startTranslate - f, v))), g && (d.preventedByNestedSwiper = !0), !s.allowSlideNext && "next" === s.swipeDirection && a.currentTranslate < a.startTranslate && (a.currentTranslate = a.startTranslate), !s.allowSlidePrev && "prev" === s.swipeDirection && a.currentTranslate > a.startTranslate && (a.currentTranslate = a.startTranslate), s.allowSlidePrev || s.allowSlideNext || (a.currentTranslate = a.startTranslate), n.threshold > 0) {
          if (!(Math.abs(f) > n.threshold || a.allowThresholdMove)) return void (a.currentTranslate = a.startTranslate);
          if (!a.allowThresholdMove) return a.allowThresholdMove = !0, i.startX = i.currentX, i.startY = i.currentY, a.currentTranslate = a.startTranslate, void (i.diff = s.isHorizontal() ? i.currentX - i.startX : i.currentY - i.startY);
        }

        n.followFinger && !n.cssMode && ((n.freeMode && n.freeMode.enabled && s.freeMode || n.watchSlidesProgress) && (s.updateActiveIndex(), s.updateSlidesClasses()), s.params.freeMode && n.freeMode.enabled && s.freeMode && s.freeMode.onTouchMove(), s.updateProgress(a.currentTranslate), s.setTranslate(a.currentTranslate));
      }

      function z(e) {
        var t = this,
            s = t.touchEventsData,
            a = t.params,
            n = t.touches,
            i = t.rtlTranslate,
            r = t.slidesGrid,
            l = t.enabled;
        if (!l) return;
        var o = e;
        if (o.originalEvent && (o = o.originalEvent), s.allowTouchCallbacks && t.emit("touchEnd", o), s.allowTouchCallbacks = !1, !s.isTouched) return s.isMoved && a.grabCursor && t.setGrabCursor(!1), s.isMoved = !1, void (s.startMoving = !1);
        a.grabCursor && s.isMoved && s.isTouched && (!0 === t.allowSlideNext || !0 === t.allowSlidePrev) && t.setGrabCursor(!1);
        var d = y(),
            c = d - s.touchStartTime;

        if (t.allowClick) {
          var _e42 = o.path || o.composedPath && o.composedPath();

          t.updateClickedSlide(_e42 && _e42[0] || o.target), t.emit("tap click", o), c < 300 && d - s.lastClickTime < 300 && t.emit("doubleTap doubleClick", o);
        }

        if (s.lastClickTime = y(), w(function () {
          t.destroyed || (t.allowClick = !0);
        }), !s.isTouched || !s.isMoved || !t.swipeDirection || 0 === n.diff || s.currentTranslate === s.startTranslate) return s.isTouched = !1, s.isMoved = !1, void (s.startMoving = !1);
        var p;
        if (s.isTouched = !1, s.isMoved = !1, s.startMoving = !1, p = a.followFinger ? i ? t.translate : -t.translate : -s.currentTranslate, a.cssMode) return;
        if (t.params.freeMode && a.freeMode.enabled) return void t.freeMode.onTouchEnd({
          currentPos: p
        });
        var u = 0,
            m = t.slidesSizesGrid[0];

        for (var _e43 = 0; _e43 < r.length; _e43 += _e43 < a.slidesPerGroupSkip ? 1 : a.slidesPerGroup) {
          var _t25 = _e43 < a.slidesPerGroupSkip - 1 ? 1 : a.slidesPerGroup;

          void 0 !== r[_e43 + _t25] ? p >= r[_e43] && p < r[_e43 + _t25] && (u = _e43, m = r[_e43 + _t25] - r[_e43]) : p >= r[_e43] && (u = _e43, m = r[r.length - 1] - r[r.length - 2]);
        }

        var h = null,
            f = null;
        a.rewind && (t.isBeginning ? f = t.params.virtual && t.params.virtual.enabled && t.virtual ? t.virtual.slides.length - 1 : t.slides.length - 1 : t.isEnd && (h = 0));
        var g = (p - r[u]) / m,
            v = u < a.slidesPerGroupSkip - 1 ? 1 : a.slidesPerGroup;

        if (c > a.longSwipesMs) {
          if (!a.longSwipes) return void t.slideTo(t.activeIndex);
          "next" === t.swipeDirection && (g >= a.longSwipesRatio ? t.slideTo(a.rewind && t.isEnd ? h : u + v) : t.slideTo(u)), "prev" === t.swipeDirection && (g > 1 - a.longSwipesRatio ? t.slideTo(u + v) : null !== f && g < 0 && Math.abs(g) > a.longSwipesRatio ? t.slideTo(f) : t.slideTo(u));
        } else {
          if (!a.shortSwipes) return void t.slideTo(t.activeIndex);
          !t.navigation || o.target !== t.navigation.nextEl && o.target !== t.navigation.prevEl ? ("next" === t.swipeDirection && t.slideTo(null !== h ? h : u + v), "prev" === t.swipeDirection && t.slideTo(null !== f ? f : u)) : o.target === t.navigation.nextEl ? t.slideTo(u + v) : t.slideTo(u);
        }
      }

      function B() {
        var e = this,
            t = e.params,
            s = e.el;
        if (s && 0 === s.offsetWidth) return;
        t.breakpoints && e.setBreakpoint();
        var a = e.allowSlideNext,
            n = e.allowSlidePrev,
            i = e.snapGrid;
        e.allowSlideNext = !0, e.allowSlidePrev = !0, e.updateSize(), e.updateSlides(), e.updateSlidesClasses(), ("auto" === t.slidesPerView || t.slidesPerView > 1) && e.isEnd && !e.isBeginning && !e.params.centeredSlides ? e.slideTo(e.slides.length - 1, 0, !1, !0) : e.slideTo(e.activeIndex, 0, !1, !0), e.autoplay && e.autoplay.running && e.autoplay.paused && e.autoplay.run(), e.allowSlidePrev = n, e.allowSlideNext = a, e.params.watchOverflow && i !== e.snapGrid && e.checkOverflow();
      }

      function G(e) {
        var t = this;
        t.enabled && (t.allowClick || (t.params.preventClicks && e.preventDefault(), t.params.preventClicksPropagation && t.animating && (e.stopPropagation(), e.stopImmediatePropagation())));
      }

      function H() {
        var e = this,
            t = e.wrapperEl,
            s = e.rtlTranslate,
            a = e.enabled;
        if (!a) return;
        var n;
        e.previousTranslate = e.translate, e.isHorizontal() ? e.translate = -t.scrollLeft : e.translate = -t.scrollTop, 0 === e.translate && (e.translate = 0), e.updateActiveIndex(), e.updateSlidesClasses();
        var i = e.maxTranslate() - e.minTranslate();
        n = 0 === i ? 0 : (e.translate - e.minTranslate()) / i, n !== e.progress && e.updateProgress(s ? -e.translate : e.translate), e.emit("setTranslate", e.translate, !1);
      }

      var V = !1;

      function F() {}

      var j = function j(e, t) {
        var s = o(),
            a = e.params,
            n = e.touchEvents,
            i = e.el,
            r = e.wrapperEl,
            l = e.device,
            d = e.support,
            c = !!a.nested,
            p = "on" === t ? "addEventListener" : "removeEventListener",
            u = t;

        if (d.touch) {
          var _t26 = !("touchstart" !== n.start || !d.passiveListener || !a.passiveListeners) && {
            passive: !0,
            capture: !1
          };

          i[p](n.start, e.onTouchStart, _t26), i[p](n.move, e.onTouchMove, d.passiveListener ? {
            passive: !1,
            capture: c
          } : c), i[p](n.end, e.onTouchEnd, _t26), n.cancel && i[p](n.cancel, e.onTouchEnd, _t26);
        } else i[p](n.start, e.onTouchStart, !1), s[p](n.move, e.onTouchMove, c), s[p](n.end, e.onTouchEnd, !1);

        (a.preventClicks || a.preventClicksPropagation) && i[p]("click", e.onClick, !0), a.cssMode && r[p]("scroll", e.onScroll), a.updateOnWindowResize ? e[u](l.ios || l.android ? "resize orientationchange observerUpdate" : "resize observerUpdate", B, !0) : e[u]("observerUpdate", B, !0);
      };

      var R = {
        attachEvents: function attachEvents() {
          var e = this,
              t = o(),
              s = e.params,
              a = e.support;
          e.onTouchStart = A.bind(e), e.onTouchMove = I.bind(e), e.onTouchEnd = z.bind(e), s.cssMode && (e.onScroll = H.bind(e)), e.onClick = G.bind(e), a.touch && !V && (t.addEventListener("touchstart", F), V = !0), j(e, "on");
        },
        detachEvents: function detachEvents() {
          j(this, "off");
        }
      };

      var W = function W(e, t) {
        return e.grid && t.grid && t.grid.rows > 1;
      };

      var X = {
        addClasses: function addClasses() {
          var e = this,
              t = e.classNames,
              s = e.params,
              a = e.rtl,
              n = e.$el,
              i = e.device,
              r = e.support,
              l = function (e, t) {
            var s = [];
            return e.forEach(function (e) {
              "object" == _typeof(e) ? Object.keys(e).forEach(function (a) {
                e[a] && s.push(t + a);
              }) : "string" == typeof e && s.push(t + e);
            }), s;
          }(["initialized", s.direction, {
            "pointer-events": !r.touch
          }, {
            "free-mode": e.params.freeMode && s.freeMode.enabled
          }, {
            autoheight: s.autoHeight
          }, {
            rtl: a
          }, {
            grid: s.grid && s.grid.rows > 1
          }, {
            "grid-column": s.grid && s.grid.rows > 1 && "column" === s.grid.fill
          }, {
            android: i.android
          }, {
            ios: i.ios
          }, {
            "css-mode": s.cssMode
          }, {
            centered: s.cssMode && s.centeredSlides
          }, {
            "watch-progress": s.watchSlidesProgress
          }], s.containerModifierClass);

          t.push.apply(t, _toConsumableArray(l)), n.addClass(_toConsumableArray(t).join(" ")), e.emitContainerClasses();
        },
        removeClasses: function removeClasses() {
          var e = this.$el,
              t = this.classNames;
          e.removeClass(t.join(" ")), this.emitContainerClasses();
        }
      },
          q = {
        init: !0,
        direction: "horizontal",
        touchEventsTarget: "wrapper",
        initialSlide: 0,
        speed: 300,
        cssMode: !1,
        updateOnWindowResize: !0,
        resizeObserver: !0,
        nested: !1,
        createElements: !1,
        enabled: !0,
        focusableElements: "input, select, option, textarea, button, video, label",
        width: null,
        height: null,
        preventInteractionOnTransition: !1,
        userAgent: null,
        url: null,
        edgeSwipeDetection: !1,
        edgeSwipeThreshold: 20,
        autoHeight: !1,
        setWrapperSize: !1,
        virtualTranslate: !1,
        effect: "slide",
        breakpoints: void 0,
        breakpointsBase: "window",
        spaceBetween: 0,
        slidesPerView: 1,
        slidesPerGroup: 1,
        slidesPerGroupSkip: 0,
        slidesPerGroupAuto: !1,
        centeredSlides: !1,
        centeredSlidesBounds: !1,
        slidesOffsetBefore: 0,
        slidesOffsetAfter: 0,
        normalizeSlideIndex: !0,
        centerInsufficientSlides: !1,
        watchOverflow: !0,
        roundLengths: !1,
        touchRatio: 1,
        touchAngle: 45,
        simulateTouch: !0,
        shortSwipes: !0,
        longSwipes: !0,
        longSwipesRatio: .5,
        longSwipesMs: 300,
        followFinger: !0,
        allowTouchMove: !0,
        threshold: 0,
        touchMoveStopPropagation: !1,
        touchStartPreventDefault: !0,
        touchStartForcePreventDefault: !1,
        touchReleaseOnEdges: !1,
        uniqueNavElements: !0,
        resistance: !0,
        resistanceRatio: .85,
        watchSlidesProgress: !1,
        grabCursor: !1,
        preventClicks: !0,
        preventClicksPropagation: !0,
        slideToClickedSlide: !1,
        preloadImages: !0,
        updateOnImagesReady: !0,
        loop: !1,
        loopAdditionalSlides: 0,
        loopedSlides: null,
        loopFillGroupWithBlank: !1,
        loopPreventsSlide: !0,
        rewind: !1,
        allowSlidePrev: !0,
        allowSlideNext: !0,
        swipeHandler: null,
        noSwiping: !0,
        noSwipingClass: "swiper-no-swiping",
        noSwipingSelector: null,
        passiveListeners: !0,
        maxBackfaceHiddenSlides: 10,
        containerModifierClass: "swiper-",
        slideClass: "swiper-slide",
        slideBlankClass: "swiper-slide-invisible-blank",
        slideActiveClass: "swiper-slide-active",
        slideDuplicateActiveClass: "swiper-slide-duplicate-active",
        slideVisibleClass: "swiper-slide-visible",
        slideDuplicateClass: "swiper-slide-duplicate",
        slideNextClass: "swiper-slide-next",
        slideDuplicateNextClass: "swiper-slide-duplicate-next",
        slidePrevClass: "swiper-slide-prev",
        slideDuplicatePrevClass: "swiper-slide-duplicate-prev",
        wrapperClass: "swiper-wrapper",
        runCallbacksOnInit: !0,
        _emitClasses: !1
      };

      function Y(e, t) {
        return function (s) {
          void 0 === s && (s = {});
          var a = Object.keys(s)[0],
              n = s[a];
          "object" == _typeof(n) && null !== n ? (["navigation", "pagination", "scrollbar"].indexOf(a) >= 0 && !0 === e[a] && (e[a] = {
            auto: !0
          }), a in e && "enabled" in n ? (!0 === e[a] && (e[a] = {
            enabled: !0
          }), "object" != _typeof(e[a]) || "enabled" in e[a] || (e[a].enabled = !0), e[a] || (e[a] = {
            enabled: !1
          }), S(t, s)) : S(t, s)) : S(t, s);
        };
      }

      var U = {
        eventsEmitter: $,
        update: O,
        translate: {
          getTranslate: function getTranslate(e) {
            void 0 === e && (e = this.isHorizontal() ? "x" : "y");
            var t = this.params,
                s = this.rtlTranslate,
                a = this.translate,
                n = this.$wrapperEl;
            if (t.virtualTranslate) return s ? -a : a;
            if (t.cssMode) return a;

            var i = function (e, t) {
              void 0 === t && (t = "x");
              var s = c();
              var a, n, i;

              var r = function (e) {
                var t = c();
                var s;
                return t.getComputedStyle && (s = t.getComputedStyle(e, null)), !s && e.currentStyle && (s = e.currentStyle), s || (s = e.style), s;
              }(e);

              return s.WebKitCSSMatrix ? (n = r.transform || r.webkitTransform, n.split(",").length > 6 && (n = n.split(", ").map(function (e) {
                return e.replace(",", ".");
              }).join(", ")), i = new s.WebKitCSSMatrix("none" === n ? "" : n)) : (i = r.MozTransform || r.OTransform || r.MsTransform || r.msTransform || r.transform || r.getPropertyValue("transform").replace("translate(", "matrix(1, 0, 0, 1,"), a = i.toString().split(",")), "x" === t && (n = s.WebKitCSSMatrix ? i.m41 : 16 === a.length ? parseFloat(a[12]) : parseFloat(a[4])), "y" === t && (n = s.WebKitCSSMatrix ? i.m42 : 16 === a.length ? parseFloat(a[13]) : parseFloat(a[5])), n || 0;
            }(n[0], e);

            return s && (i = -i), i || 0;
          },
          setTranslate: function setTranslate(e, t) {
            var s = this,
                a = s.rtlTranslate,
                n = s.params,
                i = s.$wrapperEl,
                r = s.wrapperEl,
                l = s.progress;
            var o,
                d = 0,
                c = 0;
            s.isHorizontal() ? d = a ? -e : e : c = e, n.roundLengths && (d = Math.floor(d), c = Math.floor(c)), n.cssMode ? r[s.isHorizontal() ? "scrollLeft" : "scrollTop"] = s.isHorizontal() ? -d : -c : n.virtualTranslate || i.transform("translate3d(".concat(d, "px, ").concat(c, "px, 0px)")), s.previousTranslate = s.translate, s.translate = s.isHorizontal() ? d : c;
            var p = s.maxTranslate() - s.minTranslate();
            o = 0 === p ? 0 : (e - s.minTranslate()) / p, o !== l && s.updateProgress(e), s.emit("setTranslate", s.translate, t);
          },
          minTranslate: function minTranslate() {
            return -this.snapGrid[0];
          },
          maxTranslate: function maxTranslate() {
            return -this.snapGrid[this.snapGrid.length - 1];
          },
          translateTo: function translateTo(e, t, s, a, n) {
            void 0 === e && (e = 0), void 0 === t && (t = this.params.speed), void 0 === s && (s = !0), void 0 === a && (a = !0);
            var i = this,
                r = i.params,
                l = i.wrapperEl;
            if (i.animating && r.preventInteractionOnTransition) return !1;
            var o = i.minTranslate(),
                d = i.maxTranslate();
            var c;

            if (c = a && e > o ? o : a && e < d ? d : e, i.updateProgress(c), r.cssMode) {
              var _e44 = i.isHorizontal();

              if (0 === t) l[_e44 ? "scrollLeft" : "scrollTop"] = -c;else {
                var _l$scrollTo;

                if (!i.support.smoothScroll) return x({
                  swiper: i,
                  targetPosition: -c,
                  side: _e44 ? "left" : "top"
                }), !0;
                l.scrollTo((_l$scrollTo = {}, _defineProperty(_l$scrollTo, _e44 ? "left" : "top", -c), _defineProperty(_l$scrollTo, "behavior", "smooth"), _l$scrollTo));
              }
              return !0;
            }

            return 0 === t ? (i.setTransition(0), i.setTranslate(c), s && (i.emit("beforeTransitionStart", t, n), i.emit("transitionEnd"))) : (i.setTransition(t), i.setTranslate(c), s && (i.emit("beforeTransitionStart", t, n), i.emit("transitionStart")), i.animating || (i.animating = !0, i.onTranslateToWrapperTransitionEnd || (i.onTranslateToWrapperTransitionEnd = function (e) {
              i && !i.destroyed && e.target === this && (i.$wrapperEl[0].removeEventListener("transitionend", i.onTranslateToWrapperTransitionEnd), i.$wrapperEl[0].removeEventListener("webkitTransitionEnd", i.onTranslateToWrapperTransitionEnd), i.onTranslateToWrapperTransitionEnd = null, delete i.onTranslateToWrapperTransitionEnd, s && i.emit("transitionEnd"));
            }), i.$wrapperEl[0].addEventListener("transitionend", i.onTranslateToWrapperTransitionEnd), i.$wrapperEl[0].addEventListener("webkitTransitionEnd", i.onTranslateToWrapperTransitionEnd))), !0;
          }
        },
        transition: {
          setTransition: function setTransition(e, t) {
            var s = this;
            s.params.cssMode || s.$wrapperEl.transition(e), s.emit("setTransition", e, t);
          },
          transitionStart: function transitionStart(e, t) {
            void 0 === e && (e = !0);
            var s = this,
                a = s.params;
            a.cssMode || (a.autoHeight && s.updateAutoHeight(), L({
              swiper: s,
              runCallbacks: e,
              direction: t,
              step: "Start"
            }));
          },
          transitionEnd: function transitionEnd(e, t) {
            void 0 === e && (e = !0);
            var s = this,
                a = s.params;
            s.animating = !1, a.cssMode || (s.setTransition(0), L({
              swiper: s,
              runCallbacks: e,
              direction: t,
              step: "End"
            }));
          }
        },
        slide: D,
        loop: N,
        grabCursor: {
          setGrabCursor: function setGrabCursor(e) {
            var t = this;
            if (t.support.touch || !t.params.simulateTouch || t.params.watchOverflow && t.isLocked || t.params.cssMode) return;
            var s = "container" === t.params.touchEventsTarget ? t.el : t.wrapperEl;
            s.style.cursor = "move", s.style.cursor = e ? "grabbing" : "grab";
          },
          unsetGrabCursor: function unsetGrabCursor() {
            var e = this;
            e.support.touch || e.params.watchOverflow && e.isLocked || e.params.cssMode || (e["container" === e.params.touchEventsTarget ? "el" : "wrapperEl"].style.cursor = "");
          }
        },
        events: R,
        breakpoints: {
          setBreakpoint: function setBreakpoint() {
            var e = this,
                t = e.activeIndex,
                s = e.initialized,
                _e$loopedSlides = e.loopedSlides,
                a = _e$loopedSlides === void 0 ? 0 : _e$loopedSlides,
                n = e.params,
                i = e.$el,
                r = n.breakpoints;
            if (!r || r && 0 === Object.keys(r).length) return;
            var l = e.getBreakpoint(r, e.params.breakpointsBase, e.el);
            if (!l || e.currentBreakpoint === l) return;
            var o = (l in r ? r[l] : void 0) || e.originalParams,
                d = W(e, n),
                c = W(e, o),
                p = n.enabled;
            d && !c ? (i.removeClass("".concat(n.containerModifierClass, "grid ").concat(n.containerModifierClass, "grid-column")), e.emitContainerClasses()) : !d && c && (i.addClass("".concat(n.containerModifierClass, "grid")), (o.grid.fill && "column" === o.grid.fill || !o.grid.fill && "column" === n.grid.fill) && i.addClass("".concat(n.containerModifierClass, "grid-column")), e.emitContainerClasses());
            var u = o.direction && o.direction !== n.direction,
                m = n.loop && (o.slidesPerView !== n.slidesPerView || u);
            u && s && e.changeDirection(), S(e.params, o);
            var h = e.params.enabled;
            Object.assign(e, {
              allowTouchMove: e.params.allowTouchMove,
              allowSlideNext: e.params.allowSlideNext,
              allowSlidePrev: e.params.allowSlidePrev
            }), p && !h ? e.disable() : !p && h && e.enable(), e.currentBreakpoint = l, e.emit("_beforeBreakpoint", o), m && s && (e.loopDestroy(), e.loopCreate(), e.updateSlides(), e.slideTo(t - a + e.loopedSlides, 0, !1)), e.emit("breakpoint", o);
          },
          getBreakpoint: function getBreakpoint(e, t, s) {
            if (void 0 === t && (t = "window"), !e || "container" === t && !s) return;
            var a = !1;
            var n = c(),
                i = "window" === t ? n.innerHeight : s.clientHeight,
                r = Object.keys(e).map(function (e) {
              if ("string" == typeof e && 0 === e.indexOf("@")) {
                var _t27 = parseFloat(e.substr(1));

                return {
                  value: i * _t27,
                  point: e
                };
              }

              return {
                value: e,
                point: e
              };
            });
            r.sort(function (e, t) {
              return parseInt(e.value, 10) - parseInt(t.value, 10);
            });

            for (var _e45 = 0; _e45 < r.length; _e45 += 1) {
              var _r$_e = r[_e45],
                  _i8 = _r$_e.point,
                  _l5 = _r$_e.value;
              "window" === t ? n.matchMedia("(min-width: ".concat(_l5, "px)")).matches && (a = _i8) : _l5 <= s.clientWidth && (a = _i8);
            }

            return a || "max";
          }
        },
        checkOverflow: {
          checkOverflow: function checkOverflow() {
            var e = this,
                t = e.isLocked,
                s = e.params,
                a = s.slidesOffsetBefore;

            if (a) {
              var _t28 = e.slides.length - 1,
                  _s27 = e.slidesGrid[_t28] + e.slidesSizesGrid[_t28] + 2 * a;

              e.isLocked = e.size > _s27;
            } else e.isLocked = 1 === e.snapGrid.length;

            !0 === s.allowSlideNext && (e.allowSlideNext = !e.isLocked), !0 === s.allowSlidePrev && (e.allowSlidePrev = !e.isLocked), t && t !== e.isLocked && (e.isEnd = !1), t !== e.isLocked && e.emit(e.isLocked ? "lock" : "unlock");
          }
        },
        classes: X,
        images: {
          loadImage: function loadImage(e, t, s, a, n, i) {
            var r = c();
            var l;

            function o() {
              i && i();
            }

            b(e).parent("picture")[0] || e.complete && n ? o() : t ? (l = new r.Image(), l.onload = o, l.onerror = o, a && (l.sizes = a), s && (l.srcset = s), t && (l.src = t)) : o();
          },
          preloadImages: function preloadImages() {
            var e = this;

            function t() {
              null != e && e && !e.destroyed && (void 0 !== e.imagesLoaded && (e.imagesLoaded += 1), e.imagesLoaded === e.imagesToLoad.length && (e.params.updateOnImagesReady && e.update(), e.emit("imagesReady")));
            }

            e.imagesToLoad = e.$el.find("img");

            for (var _s28 = 0; _s28 < e.imagesToLoad.length; _s28 += 1) {
              var _a14 = e.imagesToLoad[_s28];
              e.loadImage(_a14, _a14.currentSrc || _a14.getAttribute("src"), _a14.srcset || _a14.getAttribute("srcset"), _a14.sizes || _a14.getAttribute("sizes"), !0, t);
            }
          }
        }
      },
          K = {};

      var Z =
      /*#__PURE__*/
      function () {
        function Z() {
          var _a15, _a16, _i$modules;

          _classCallCheck(this, Z);

          var e, t;

          for (var s = arguments.length, a = new Array(s), n = 0; n < s; n++) {
            a[n] = arguments[n];
          }

          if (1 === a.length && a[0].constructor && "Object" === Object.prototype.toString.call(a[0]).slice(8, -1) ? t = a[0] : (_a15 = a, _a16 = _slicedToArray(_a15, 2), e = _a16[0], t = _a16[1], _a15), t || (t = {}), t = S({}, t), e && !t.el && (t.el = e), t.el && b(t.el).length > 1) {
            var _e46 = [];
            return b(t.el).each(function (s) {
              var a = S({}, t, {
                el: s
              });

              _e46.push(new Z(a));
            }), _e46;
          }

          var i = this;
          var r;
          i.__swiper__ = !0, i.support = M(), i.device = (void 0 === (r = {
            userAgent: t.userAgent
          }) && (r = {}), _ || (_ = function (e) {
            var _ref = void 0 === e ? {} : e,
                t = _ref.userAgent;

            var s = M(),
                a = c(),
                n = a.navigator.platform,
                i = t || a.navigator.userAgent,
                r = {
              ios: !1,
              android: !1
            },
                l = a.screen.width,
                o = a.screen.height,
                d = i.match(/(Android);?[\s\/]+([\d.]+)?/);
            var p = i.match(/(iPad).*OS\s([\d_]+)/);
            var u = i.match(/(iPod)(.*OS\s([\d_]+))?/),
                m = !p && i.match(/(iPhone\sOS|iOS)\s([\d_]+)/),
                h = "Win32" === n;
            var f = "MacIntel" === n;
            return !p && f && s.touch && ["1024x1366", "1366x1024", "834x1194", "1194x834", "834x1112", "1112x834", "768x1024", "1024x768", "820x1180", "1180x820", "810x1080", "1080x810"].indexOf("".concat(l, "x").concat(o)) >= 0 && (p = i.match(/(Version)\/([\d.]+)/), p || (p = [0, 1, "13_0_0"]), f = !1), d && !h && (r.os = "android", r.android = !0), (p || m || u) && (r.os = "ios", r.ios = !0), r;
          }(r)), _), i.browser = (P || (P = function () {
            var e = c();
            return {
              isSafari: function () {
                var t = e.navigator.userAgent.toLowerCase();
                return t.indexOf("safari") >= 0 && t.indexOf("chrome") < 0 && t.indexOf("android") < 0;
              }(),
              isWebView: /(iPhone|iPod|iPad).*AppleWebKit(?!.*Safari)/i.test(e.navigator.userAgent)
            };
          }()), P), i.eventsListeners = {}, i.eventsAnyListeners = [], i.modules = _toConsumableArray(i.__modules__), t.modules && Array.isArray(t.modules) && (_i$modules = i.modules).push.apply(_i$modules, _toConsumableArray(t.modules));
          var l = {};
          i.modules.forEach(function (e) {
            e({
              swiper: i,
              extendParams: Y(t, l),
              on: i.on.bind(i),
              once: i.once.bind(i),
              off: i.off.bind(i),
              emit: i.emit.bind(i)
            });
          });
          var o = S({}, q, l);
          return i.params = S({}, o, K, t), i.originalParams = S({}, i.params), i.passedParams = S({}, t), i.params && i.params.on && Object.keys(i.params.on).forEach(function (e) {
            i.on(e, i.params.on[e]);
          }), i.params && i.params.onAny && i.onAny(i.params.onAny), i.$ = b, Object.assign(i, {
            enabled: i.params.enabled,
            el: e,
            classNames: [],
            slides: b(),
            slidesGrid: [],
            snapGrid: [],
            slidesSizesGrid: [],
            isHorizontal: function isHorizontal() {
              return "horizontal" === i.params.direction;
            },
            isVertical: function isVertical() {
              return "vertical" === i.params.direction;
            },
            activeIndex: 0,
            realIndex: 0,
            isBeginning: !0,
            isEnd: !1,
            translate: 0,
            previousTranslate: 0,
            progress: 0,
            velocity: 0,
            animating: !1,
            allowSlideNext: i.params.allowSlideNext,
            allowSlidePrev: i.params.allowSlidePrev,
            touchEvents: function () {
              var e = ["touchstart", "touchmove", "touchend", "touchcancel"],
                  t = ["pointerdown", "pointermove", "pointerup"];
              return i.touchEventsTouch = {
                start: e[0],
                move: e[1],
                end: e[2],
                cancel: e[3]
              }, i.touchEventsDesktop = {
                start: t[0],
                move: t[1],
                end: t[2]
              }, i.support.touch || !i.params.simulateTouch ? i.touchEventsTouch : i.touchEventsDesktop;
            }(),
            touchEventsData: {
              isTouched: void 0,
              isMoved: void 0,
              allowTouchCallbacks: void 0,
              touchStartTime: void 0,
              isScrolling: void 0,
              currentTranslate: void 0,
              startTranslate: void 0,
              allowThresholdMove: void 0,
              focusableElements: i.params.focusableElements,
              lastClickTime: y(),
              clickTimeout: void 0,
              velocities: [],
              allowMomentumBounce: void 0,
              isTouchEvent: void 0,
              startMoving: void 0
            },
            allowClick: !0,
            allowTouchMove: i.params.allowTouchMove,
            touches: {
              startX: 0,
              startY: 0,
              currentX: 0,
              currentY: 0,
              diff: 0
            },
            imagesToLoad: [],
            imagesLoaded: 0
          }), i.emit("_swiper"), i.params.init && i.init(), i;
        }

        _createClass(Z, [{
          key: "enable",
          value: function enable() {
            var e = this;
            e.enabled || (e.enabled = !0, e.params.grabCursor && e.setGrabCursor(), e.emit("enable"));
          }
        }, {
          key: "disable",
          value: function disable() {
            var e = this;
            e.enabled && (e.enabled = !1, e.params.grabCursor && e.unsetGrabCursor(), e.emit("disable"));
          }
        }, {
          key: "setProgress",
          value: function setProgress(e, t) {
            var s = this;
            e = Math.min(Math.max(e, 0), 1);
            var a = s.minTranslate(),
                n = (s.maxTranslate() - a) * e + a;
            s.translateTo(n, void 0 === t ? 0 : t), s.updateActiveIndex(), s.updateSlidesClasses();
          }
        }, {
          key: "emitContainerClasses",
          value: function emitContainerClasses() {
            var e = this;
            if (!e.params._emitClasses || !e.el) return;
            var t = e.el.className.split(" ").filter(function (t) {
              return 0 === t.indexOf("swiper") || 0 === t.indexOf(e.params.containerModifierClass);
            });
            e.emit("_containerClasses", t.join(" "));
          }
        }, {
          key: "getSlideClasses",
          value: function getSlideClasses(e) {
            var t = this;
            return t.destroyed ? "" : e.className.split(" ").filter(function (e) {
              return 0 === e.indexOf("swiper-slide") || 0 === e.indexOf(t.params.slideClass);
            }).join(" ");
          }
        }, {
          key: "emitSlidesClasses",
          value: function emitSlidesClasses() {
            var e = this;
            if (!e.params._emitClasses || !e.el) return;
            var t = [];
            e.slides.each(function (s) {
              var a = e.getSlideClasses(s);
              t.push({
                slideEl: s,
                classNames: a
              }), e.emit("_slideClass", s, a);
            }), e.emit("_slideClasses", t);
          }
        }, {
          key: "slidesPerViewDynamic",
          value: function slidesPerViewDynamic(e, t) {
            void 0 === e && (e = "current"), void 0 === t && (t = !1);
            var s = this.params,
                a = this.slides,
                n = this.slidesGrid,
                i = this.slidesSizesGrid,
                r = this.size,
                l = this.activeIndex;
            var o = 1;

            if (s.centeredSlides) {
              var _e47,
                  _t29 = a[l].swiperSlideSize;

              for (var _s29 = l + 1; _s29 < a.length; _s29 += 1) {
                a[_s29] && !_e47 && (_t29 += a[_s29].swiperSlideSize, o += 1, _t29 > r && (_e47 = !0));
              }

              for (var _s30 = l - 1; _s30 >= 0; _s30 -= 1) {
                a[_s30] && !_e47 && (_t29 += a[_s30].swiperSlideSize, o += 1, _t29 > r && (_e47 = !0));
              }
            } else if ("current" === e) for (var _e48 = l + 1; _e48 < a.length; _e48 += 1) {
              (t ? n[_e48] + i[_e48] - n[l] < r : n[_e48] - n[l] < r) && (o += 1);
            } else for (var _e49 = l - 1; _e49 >= 0; _e49 -= 1) {
              n[l] - n[_e49] < r && (o += 1);
            }

            return o;
          }
        }, {
          key: "update",
          value: function update() {
            var e = this;
            if (!e || e.destroyed) return;
            var t = e.snapGrid,
                s = e.params;

            function a() {
              var t = e.rtlTranslate ? -1 * e.translate : e.translate,
                  s = Math.min(Math.max(t, e.maxTranslate()), e.minTranslate());
              e.setTranslate(s), e.updateActiveIndex(), e.updateSlidesClasses();
            }

            var n;
            s.breakpoints && e.setBreakpoint(), e.updateSize(), e.updateSlides(), e.updateProgress(), e.updateSlidesClasses(), e.params.freeMode && e.params.freeMode.enabled ? (a(), e.params.autoHeight && e.updateAutoHeight()) : (n = ("auto" === e.params.slidesPerView || e.params.slidesPerView > 1) && e.isEnd && !e.params.centeredSlides ? e.slideTo(e.slides.length - 1, 0, !1, !0) : e.slideTo(e.activeIndex, 0, !1, !0), n || a()), s.watchOverflow && t !== e.snapGrid && e.checkOverflow(), e.emit("update");
          }
        }, {
          key: "changeDirection",
          value: function changeDirection(e, t) {
            void 0 === t && (t = !0);
            var s = this,
                a = s.params.direction;
            return e || (e = "horizontal" === a ? "vertical" : "horizontal"), e === a || "horizontal" !== e && "vertical" !== e || (s.$el.removeClass("".concat(s.params.containerModifierClass).concat(a)).addClass("".concat(s.params.containerModifierClass).concat(e)), s.emitContainerClasses(), s.params.direction = e, s.slides.each(function (t) {
              "vertical" === e ? t.style.width = "" : t.style.height = "";
            }), s.emit("changeDirection"), t && s.update()), s;
          }
        }, {
          key: "mount",
          value: function mount(e) {
            var t = this;
            if (t.mounted) return !0;
            var s = b(e || t.params.el);
            if (!(e = s[0])) return !1;
            e.swiper = t;

            var a = function a() {
              return ".".concat((t.params.wrapperClass || "").trim().split(" ").join("."));
            };

            var n = function () {
              if (e && e.shadowRoot && e.shadowRoot.querySelector) {
                var _t30 = b(e.shadowRoot.querySelector(a()));

                return _t30.children = function (e) {
                  return s.children(e);
                }, _t30;
              }

              return s.children(a());
            }();

            if (0 === n.length && t.params.createElements) {
              var _e50 = o().createElement("div");

              n = b(_e50), _e50.className = t.params.wrapperClass, s.append(_e50), s.children(".".concat(t.params.slideClass)).each(function (e) {
                n.append(e);
              });
            }

            return Object.assign(t, {
              $el: s,
              el: e,
              $wrapperEl: n,
              wrapperEl: n[0],
              mounted: !0,
              rtl: "rtl" === e.dir.toLowerCase() || "rtl" === s.css("direction"),
              rtlTranslate: "horizontal" === t.params.direction && ("rtl" === e.dir.toLowerCase() || "rtl" === s.css("direction")),
              wrongRTL: "-webkit-box" === n.css("display")
            }), !0;
          }
        }, {
          key: "init",
          value: function init(e) {
            var t = this;
            return t.initialized || !1 === t.mount(e) || (t.emit("beforeInit"), t.params.breakpoints && t.setBreakpoint(), t.addClasses(), t.params.loop && t.loopCreate(), t.updateSize(), t.updateSlides(), t.params.watchOverflow && t.checkOverflow(), t.params.grabCursor && t.enabled && t.setGrabCursor(), t.params.preloadImages && t.preloadImages(), t.params.loop ? t.slideTo(t.params.initialSlide + t.loopedSlides, 0, t.params.runCallbacksOnInit, !1, !0) : t.slideTo(t.params.initialSlide, 0, t.params.runCallbacksOnInit, !1, !0), t.attachEvents(), t.initialized = !0, t.emit("init"), t.emit("afterInit")), t;
          }
        }, {
          key: "destroy",
          value: function destroy(e, t) {
            void 0 === e && (e = !0), void 0 === t && (t = !0);
            var s = this,
                a = s.params,
                n = s.$el,
                i = s.$wrapperEl,
                r = s.slides;
            return void 0 === s.params || s.destroyed || (s.emit("beforeDestroy"), s.initialized = !1, s.detachEvents(), a.loop && s.loopDestroy(), t && (s.removeClasses(), n.removeAttr("style"), i.removeAttr("style"), r && r.length && r.removeClass([a.slideVisibleClass, a.slideActiveClass, a.slideNextClass, a.slidePrevClass].join(" ")).removeAttr("style").removeAttr("data-swiper-slide-index")), s.emit("destroy"), Object.keys(s.eventsListeners).forEach(function (e) {
              s.off(e);
            }), !1 !== e && (s.$el[0].swiper = null, function (e) {
              var t = e;
              Object.keys(t).forEach(function (e) {
                try {
                  t[e] = null;
                } catch (e) {}

                try {
                  delete t[e];
                } catch (e) {}
              });
            }(s)), s.destroyed = !0), null;
          }
        }], [{
          key: "extendDefaults",
          value: function extendDefaults(e) {
            S(K, e);
          }
        }, {
          key: "installModule",
          value: function installModule(e) {
            Z.prototype.__modules__ || (Z.prototype.__modules__ = []);
            var t = Z.prototype.__modules__;
            "function" == typeof e && t.indexOf(e) < 0 && t.push(e);
          }
        }, {
          key: "use",
          value: function use(e) {
            return Array.isArray(e) ? (e.forEach(function (e) {
              return Z.installModule(e);
            }), Z) : (Z.installModule(e), Z);
          }
        }, {
          key: "extendedDefaults",
          get: function get() {
            return K;
          }
        }, {
          key: "defaults",
          get: function get() {
            return q;
          }
        }]);

        return Z;
      }();

      Object.keys(U).forEach(function (e) {
        Object.keys(U[e]).forEach(function (t) {
          Z.prototype[t] = U[e][t];
        });
      }), Z.use([function (e) {
        var t = e.swiper,
            s = e.on,
            a = e.emit;
        var n = c();
        var i = null,
            r = null;

        var l = function l() {
          t && !t.destroyed && t.initialized && (a("beforeResize"), a("resize"));
        },
            o = function o() {
          t && !t.destroyed && t.initialized && a("orientationchange");
        };

        s("init", function () {
          t.params.resizeObserver && void 0 !== n.ResizeObserver ? t && !t.destroyed && t.initialized && (i = new ResizeObserver(function (e) {
            r = n.requestAnimationFrame(function () {
              var s = t.width,
                  a = t.height;
              var n = s,
                  i = a;
              e.forEach(function (e) {
                var s = e.contentBoxSize,
                    a = e.contentRect,
                    r = e.target;
                r && r !== t.el || (n = a ? a.width : (s[0] || s).inlineSize, i = a ? a.height : (s[0] || s).blockSize);
              }), n === s && i === a || l();
            });
          }), i.observe(t.el)) : (n.addEventListener("resize", l), n.addEventListener("orientationchange", o));
        }), s("destroy", function () {
          r && n.cancelAnimationFrame(r), i && i.unobserve && t.el && (i.unobserve(t.el), i = null), n.removeEventListener("resize", l), n.removeEventListener("orientationchange", o);
        });
      }, function (e) {
        var t = e.swiper,
            s = e.extendParams,
            a = e.on,
            n = e.emit;

        var i = [],
            r = c(),
            l = function l(e, t) {
          void 0 === t && (t = {});
          var s = new (r.MutationObserver || r.WebkitMutationObserver)(function (e) {
            if (1 === e.length) return void n("observerUpdate", e[0]);

            var t = function t() {
              n("observerUpdate", e[0]);
            };

            r.requestAnimationFrame ? r.requestAnimationFrame(t) : r.setTimeout(t, 0);
          });
          s.observe(e, {
            attributes: void 0 === t.attributes || t.attributes,
            childList: void 0 === t.childList || t.childList,
            characterData: void 0 === t.characterData || t.characterData
          }), i.push(s);
        };

        s({
          observer: !1,
          observeParents: !1,
          observeSlideChildren: !1
        }), a("init", function () {
          if (t.params.observer) {
            if (t.params.observeParents) {
              var _e51 = t.$el.parents();

              for (var _t31 = 0; _t31 < _e51.length; _t31 += 1) {
                l(_e51[_t31]);
              }
            }

            l(t.$el[0], {
              childList: t.params.observeSlideChildren
            }), l(t.$wrapperEl[0], {
              attributes: !1
            });
          }
        }), a("destroy", function () {
          i.forEach(function (e) {
            e.disconnect();
          }), i.splice(0, i.length);
        });
      }]);
      var J = Z;

      function Q(e) {
        var t = e.swiper,
            s = e.extendParams,
            a = e.on,
            n = e.emit;
        var i = o(),
            r = c();

        function l(e) {
          if (!t.enabled) return;
          var s = t.rtlTranslate;
          var a = e;
          a.originalEvent && (a = a.originalEvent);
          var l = a.keyCode || a.charCode,
              o = t.params.keyboard.pageUpDown,
              d = o && 33 === l,
              c = o && 34 === l,
              p = 37 === l,
              u = 39 === l,
              m = 38 === l,
              h = 40 === l;
          if (!t.allowSlideNext && (t.isHorizontal() && u || t.isVertical() && h || c)) return !1;
          if (!t.allowSlidePrev && (t.isHorizontal() && p || t.isVertical() && m || d)) return !1;

          if (!(a.shiftKey || a.altKey || a.ctrlKey || a.metaKey || i.activeElement && i.activeElement.nodeName && ("input" === i.activeElement.nodeName.toLowerCase() || "textarea" === i.activeElement.nodeName.toLowerCase()))) {
            if (t.params.keyboard.onlyInViewport && (d || c || p || u || m || h)) {
              var _e52 = !1;

              if (t.$el.parents(".".concat(t.params.slideClass)).length > 0 && 0 === t.$el.parents(".".concat(t.params.slideActiveClass)).length) return;

              var _a17 = t.$el,
                  _n12 = _a17[0].clientWidth,
                  _i9 = _a17[0].clientHeight,
                  _l6 = r.innerWidth,
                  _o4 = r.innerHeight,
                  _d4 = t.$el.offset();

              s && (_d4.left -= t.$el[0].scrollLeft);
              var _c2 = [[_d4.left, _d4.top], [_d4.left + _n12, _d4.top], [_d4.left, _d4.top + _i9], [_d4.left + _n12, _d4.top + _i9]];

              for (var _t32 = 0; _t32 < _c2.length; _t32 += 1) {
                var _s31 = _c2[_t32];

                if (_s31[0] >= 0 && _s31[0] <= _l6 && _s31[1] >= 0 && _s31[1] <= _o4) {
                  if (0 === _s31[0] && 0 === _s31[1]) continue;
                  _e52 = !0;
                }
              }

              if (!_e52) return;
            }

            t.isHorizontal() ? ((d || c || p || u) && (a.preventDefault ? a.preventDefault() : a.returnValue = !1), ((c || u) && !s || (d || p) && s) && t.slideNext(), ((d || p) && !s || (c || u) && s) && t.slidePrev()) : ((d || c || m || h) && (a.preventDefault ? a.preventDefault() : a.returnValue = !1), (c || h) && t.slideNext(), (d || m) && t.slidePrev()), n("keyPress", l);
          }
        }

        function d() {
          t.keyboard.enabled || (b(i).on("keydown", l), t.keyboard.enabled = !0);
        }

        function p() {
          t.keyboard.enabled && (b(i).off("keydown", l), t.keyboard.enabled = !1);
        }

        t.keyboard = {
          enabled: !1
        }, s({
          keyboard: {
            enabled: !1,
            onlyInViewport: !0,
            pageUpDown: !0
          }
        }), a("init", function () {
          t.params.keyboard.enabled && d();
        }), a("destroy", function () {
          t.keyboard.enabled && p();
        }), Object.assign(t.keyboard, {
          enable: d,
          disable: p
        });
      }

      function ee(e) {
        var t = e.swiper,
            s = e.extendParams,
            a = e.on,
            n = e.emit;
        var i = c();
        var r;
        s({
          mousewheel: {
            enabled: !1,
            releaseOnEdges: !1,
            invert: !1,
            forceToAxis: !1,
            sensitivity: 1,
            eventsTarget: "container",
            thresholdDelta: null,
            thresholdTime: null
          }
        }), t.mousewheel = {
          enabled: !1
        };
        var l,
            o = y();
        var d = [];

        function p() {
          t.enabled && (t.mouseEntered = !0);
        }

        function u() {
          t.enabled && (t.mouseEntered = !1);
        }

        function m(e) {
          return !(t.params.mousewheel.thresholdDelta && e.delta < t.params.mousewheel.thresholdDelta || t.params.mousewheel.thresholdTime && y() - o < t.params.mousewheel.thresholdTime || !(e.delta >= 6 && y() - o < 60) && (e.direction < 0 ? t.isEnd && !t.params.loop || t.animating || (t.slideNext(), n("scroll", e.raw)) : t.isBeginning && !t.params.loop || t.animating || (t.slidePrev(), n("scroll", e.raw)), o = new i.Date().getTime(), 1));
        }

        function h(e) {
          var s = e,
              a = !0;
          if (!t.enabled) return;
          var i = t.params.mousewheel;
          t.params.cssMode && s.preventDefault();
          var o = t.$el;
          if ("container" !== t.params.mousewheel.eventsTarget && (o = b(t.params.mousewheel.eventsTarget)), !t.mouseEntered && !o[0].contains(s.target) && !i.releaseOnEdges) return !0;
          s.originalEvent && (s = s.originalEvent);
          var c = 0;

          var p = t.rtlTranslate ? -1 : 1,
              u = function (e) {
            var t = 0,
                s = 0,
                a = 0,
                n = 0;
            return "detail" in e && (s = e.detail), "wheelDelta" in e && (s = -e.wheelDelta / 120), "wheelDeltaY" in e && (s = -e.wheelDeltaY / 120), "wheelDeltaX" in e && (t = -e.wheelDeltaX / 120), "axis" in e && e.axis === e.HORIZONTAL_AXIS && (t = s, s = 0), a = 10 * t, n = 10 * s, "deltaY" in e && (n = e.deltaY), "deltaX" in e && (a = e.deltaX), e.shiftKey && !a && (a = n, n = 0), (a || n) && e.deltaMode && (1 === e.deltaMode ? (a *= 40, n *= 40) : (a *= 800, n *= 800)), a && !t && (t = a < 1 ? -1 : 1), n && !s && (s = n < 1 ? -1 : 1), {
              spinX: t,
              spinY: s,
              pixelX: a,
              pixelY: n
            };
          }(s);

          if (i.forceToAxis) {
            if (t.isHorizontal()) {
              if (!(Math.abs(u.pixelX) > Math.abs(u.pixelY))) return !0;
              c = -u.pixelX * p;
            } else {
              if (!(Math.abs(u.pixelY) > Math.abs(u.pixelX))) return !0;
              c = -u.pixelY;
            }
          } else c = Math.abs(u.pixelX) > Math.abs(u.pixelY) ? -u.pixelX * p : -u.pixelY;
          if (0 === c) return !0;
          i.invert && (c = -c);
          var h = t.getTranslate() + c * i.sensitivity;

          if (h >= t.minTranslate() && (h = t.minTranslate()), h <= t.maxTranslate() && (h = t.maxTranslate()), a = !!t.params.loop || !(h === t.minTranslate() || h === t.maxTranslate()), a && t.params.nested && s.stopPropagation(), t.params.freeMode && t.params.freeMode.enabled) {
            var _e53 = {
              time: y(),
              delta: Math.abs(c),
              direction: Math.sign(c)
            },
                _a18 = l && _e53.time < l.time + 500 && _e53.delta <= l.delta && _e53.direction === l.direction;

            if (!_a18) {
              l = void 0, t.params.loop && t.loopFix();

              var _o5 = t.getTranslate() + c * i.sensitivity;

              var _p2 = t.isBeginning,
                  _u2 = t.isEnd;

              if (_o5 >= t.minTranslate() && (_o5 = t.minTranslate()), _o5 <= t.maxTranslate() && (_o5 = t.maxTranslate()), t.setTransition(0), t.setTranslate(_o5), t.updateProgress(), t.updateActiveIndex(), t.updateSlidesClasses(), (!_p2 && t.isBeginning || !_u2 && t.isEnd) && t.updateSlidesClasses(), t.params.freeMode.sticky) {
                clearTimeout(r), r = void 0, d.length >= 15 && d.shift();

                var _s32 = d.length ? d[d.length - 1] : void 0,
                    _a19 = d[0];

                if (d.push(_e53), _s32 && (_e53.delta > _s32.delta || _e53.direction !== _s32.direction)) d.splice(0);else if (d.length >= 15 && _e53.time - _a19.time < 500 && _a19.delta - _e53.delta >= 1 && _e53.delta <= 6) {
                  var _s33 = c > 0 ? .8 : .2;

                  l = _e53, d.splice(0), r = w(function () {
                    t.slideToClosest(t.params.speed, !0, void 0, _s33);
                  }, 0);
                }
                r || (r = w(function () {
                  l = _e53, d.splice(0), t.slideToClosest(t.params.speed, !0, void 0, .5);
                }, 500));
              }

              if (_a18 || n("scroll", s), t.params.autoplay && t.params.autoplayDisableOnInteraction && t.autoplay.stop(), _o5 === t.minTranslate() || _o5 === t.maxTranslate()) return !0;
            }
          } else {
            var _s34 = {
              time: y(),
              delta: Math.abs(c),
              direction: Math.sign(c),
              raw: e
            };
            d.length >= 2 && d.shift();

            var _a20 = d.length ? d[d.length - 1] : void 0;

            if (d.push(_s34), _a20 ? (_s34.direction !== _a20.direction || _s34.delta > _a20.delta || _s34.time > _a20.time + 150) && m(_s34) : m(_s34), function (e) {
              var s = t.params.mousewheel;

              if (e.direction < 0) {
                if (t.isEnd && !t.params.loop && s.releaseOnEdges) return !0;
              } else if (t.isBeginning && !t.params.loop && s.releaseOnEdges) return !0;

              return !1;
            }(_s34)) return !0;
          }

          return s.preventDefault ? s.preventDefault() : s.returnValue = !1, !1;
        }

        function f(e) {
          var s = t.$el;
          "container" !== t.params.mousewheel.eventsTarget && (s = b(t.params.mousewheel.eventsTarget)), s[e]("mouseenter", p), s[e]("mouseleave", u), s[e]("wheel", h);
        }

        function g() {
          return t.params.cssMode ? (t.wrapperEl.removeEventListener("wheel", h), !0) : !t.mousewheel.enabled && (f("on"), t.mousewheel.enabled = !0, !0);
        }

        function v() {
          return t.params.cssMode ? (t.wrapperEl.addEventListener(event, h), !0) : !!t.mousewheel.enabled && (f("off"), t.mousewheel.enabled = !1, !0);
        }

        a("init", function () {
          !t.params.mousewheel.enabled && t.params.cssMode && v(), t.params.mousewheel.enabled && g();
        }), a("destroy", function () {
          t.params.cssMode && g(), t.mousewheel.enabled && v();
        }), Object.assign(t.mousewheel, {
          enable: g,
          disable: v
        });
      }

      function te(e, t, s, a) {
        var n = o();
        return e.params.createElements && Object.keys(a).forEach(function (i) {
          if (!s[i] && !0 === s.auto) {
            var _r4 = e.$el.children(".".concat(a[i]))[0];
            _r4 || (_r4 = n.createElement("div"), _r4.className = a[i], e.$el.append(_r4)), s[i] = _r4, t[i] = _r4;
          }
        }), s;
      }

      function se(e) {
        var t = e.swiper,
            s = e.extendParams,
            a = e.on,
            n = e.emit;

        function i(e) {
          var s;
          return e && (s = b(e), t.params.uniqueNavElements && "string" == typeof e && s.length > 1 && 1 === t.$el.find(e).length && (s = t.$el.find(e))), s;
        }

        function r(e, s) {
          var a = t.params.navigation;
          e && e.length > 0 && (e[s ? "addClass" : "removeClass"](a.disabledClass), e[0] && "BUTTON" === e[0].tagName && (e[0].disabled = s), t.params.watchOverflow && t.enabled && e[t.isLocked ? "addClass" : "removeClass"](a.lockClass));
        }

        function l() {
          if (t.params.loop) return;
          var _t$navigation = t.navigation,
              e = _t$navigation.$nextEl,
              s = _t$navigation.$prevEl;
          r(s, t.isBeginning && !t.params.rewind), r(e, t.isEnd && !t.params.rewind);
        }

        function o(e) {
          e.preventDefault(), (!t.isBeginning || t.params.loop || t.params.rewind) && t.slidePrev();
        }

        function d(e) {
          e.preventDefault(), (!t.isEnd || t.params.loop || t.params.rewind) && t.slideNext();
        }

        function c() {
          var e = t.params.navigation;
          if (t.params.navigation = te(t, t.originalParams.navigation, t.params.navigation, {
            nextEl: "swiper-button-next",
            prevEl: "swiper-button-prev"
          }), !e.nextEl && !e.prevEl) return;
          var s = i(e.nextEl),
              a = i(e.prevEl);
          s && s.length > 0 && s.on("click", d), a && a.length > 0 && a.on("click", o), Object.assign(t.navigation, {
            $nextEl: s,
            nextEl: s && s[0],
            $prevEl: a,
            prevEl: a && a[0]
          }), t.enabled || (s && s.addClass(e.lockClass), a && a.addClass(e.lockClass));
        }

        function p() {
          var _t$navigation2 = t.navigation,
              e = _t$navigation2.$nextEl,
              s = _t$navigation2.$prevEl;
          e && e.length && (e.off("click", d), e.removeClass(t.params.navigation.disabledClass)), s && s.length && (s.off("click", o), s.removeClass(t.params.navigation.disabledClass));
        }

        s({
          navigation: {
            nextEl: null,
            prevEl: null,
            hideOnClick: !1,
            disabledClass: "swiper-button-disabled",
            hiddenClass: "swiper-button-hidden",
            lockClass: "swiper-button-lock"
          }
        }), t.navigation = {
          nextEl: null,
          $nextEl: null,
          prevEl: null,
          $prevEl: null
        }, a("init", function () {
          c(), l();
        }), a("toEdge fromEdge lock unlock", function () {
          l();
        }), a("destroy", function () {
          p();
        }), a("enable disable", function () {
          var _t$navigation3 = t.navigation,
              e = _t$navigation3.$nextEl,
              s = _t$navigation3.$prevEl;
          e && e[t.enabled ? "removeClass" : "addClass"](t.params.navigation.lockClass), s && s[t.enabled ? "removeClass" : "addClass"](t.params.navigation.lockClass);
        }), a("click", function (e, s) {
          var _t$navigation4 = t.navigation,
              a = _t$navigation4.$nextEl,
              i = _t$navigation4.$prevEl,
              r = s.target;

          if (t.params.navigation.hideOnClick && !b(r).is(i) && !b(r).is(a)) {
            if (t.pagination && t.params.pagination && t.params.pagination.clickable && (t.pagination.el === r || t.pagination.el.contains(r))) return;

            var _e54;

            a ? _e54 = a.hasClass(t.params.navigation.hiddenClass) : i && (_e54 = i.hasClass(t.params.navigation.hiddenClass)), n(!0 === _e54 ? "navigationShow" : "navigationHide"), a && a.toggleClass(t.params.navigation.hiddenClass), i && i.toggleClass(t.params.navigation.hiddenClass);
          }
        }), Object.assign(t.navigation, {
          update: l,
          init: c,
          destroy: p
        });
      }

      function ae(e) {
        return void 0 === e && (e = ""), ".".concat(e.trim().replace(/([\.:!\/])/g, "\\$1").replace(/ /g, "."));
      }

      function ne(e) {
        var t = e.swiper,
            s = e.extendParams,
            a = e.on,
            n = e.emit;
        var i = "swiper-pagination";
        var r;
        s({
          pagination: {
            el: null,
            bulletElement: "span",
            clickable: !1,
            hideOnClick: !1,
            renderBullet: null,
            renderProgressbar: null,
            renderFraction: null,
            renderCustom: null,
            progressbarOpposite: !1,
            type: "bullets",
            dynamicBullets: !1,
            dynamicMainBullets: 1,
            formatFractionCurrent: function formatFractionCurrent(e) {
              return e;
            },
            formatFractionTotal: function formatFractionTotal(e) {
              return e;
            },
            bulletClass: "".concat(i, "-bullet"),
            bulletActiveClass: "".concat(i, "-bullet-active"),
            modifierClass: "".concat(i, "-"),
            currentClass: "".concat(i, "-current"),
            totalClass: "".concat(i, "-total"),
            hiddenClass: "".concat(i, "-hidden"),
            progressbarFillClass: "".concat(i, "-progressbar-fill"),
            progressbarOppositeClass: "".concat(i, "-progressbar-opposite"),
            clickableClass: "".concat(i, "-clickable"),
            lockClass: "".concat(i, "-lock"),
            horizontalClass: "".concat(i, "-horizontal"),
            verticalClass: "".concat(i, "-vertical")
          }
        }), t.pagination = {
          el: null,
          $el: null,
          bullets: []
        };
        var l = 0;

        function o() {
          return !t.params.pagination.el || !t.pagination.el || !t.pagination.$el || 0 === t.pagination.$el.length;
        }

        function d(e, s) {
          var a = t.params.pagination.bulletActiveClass;
          e[s]().addClass("".concat(a, "-").concat(s))[s]().addClass("".concat(a, "-").concat(s, "-").concat(s));
        }

        function c() {
          var e = t.rtl,
              s = t.params.pagination;
          if (o()) return;
          var a = t.virtual && t.params.virtual.enabled ? t.virtual.slides.length : t.slides.length,
              i = t.pagination.$el;
          var c;
          var p = t.params.loop ? Math.ceil((a - 2 * t.loopedSlides) / t.params.slidesPerGroup) : t.snapGrid.length;

          if (t.params.loop ? (c = Math.ceil((t.activeIndex - t.loopedSlides) / t.params.slidesPerGroup), c > a - 1 - 2 * t.loopedSlides && (c -= a - 2 * t.loopedSlides), c > p - 1 && (c -= p), c < 0 && "bullets" !== t.params.paginationType && (c = p + c)) : c = void 0 !== t.snapIndex ? t.snapIndex : t.activeIndex || 0, "bullets" === s.type && t.pagination.bullets && t.pagination.bullets.length > 0) {
            var _a21 = t.pagination.bullets;

            var _n13, _o6, _p3;

            if (s.dynamicBullets && (r = _a21.eq(0)[t.isHorizontal() ? "outerWidth" : "outerHeight"](!0), i.css(t.isHorizontal() ? "width" : "height", r * (s.dynamicMainBullets + 4) + "px"), s.dynamicMainBullets > 1 && void 0 !== t.previousIndex && (l += c - (t.previousIndex - t.loopedSlides || 0), l > s.dynamicMainBullets - 1 ? l = s.dynamicMainBullets - 1 : l < 0 && (l = 0)), _n13 = Math.max(c - l, 0), _o6 = _n13 + (Math.min(_a21.length, s.dynamicMainBullets) - 1), _p3 = (_o6 + _n13) / 2), _a21.removeClass(["", "-next", "-next-next", "-prev", "-prev-prev", "-main"].map(function (e) {
              return "".concat(s.bulletActiveClass).concat(e);
            }).join(" ")), i.length > 1) _a21.each(function (e) {
              var t = b(e),
                  a = t.index();
              a === c && t.addClass(s.bulletActiveClass), s.dynamicBullets && (a >= _n13 && a <= _o6 && t.addClass("".concat(s.bulletActiveClass, "-main")), a === _n13 && d(t, "prev"), a === _o6 && d(t, "next"));
            });else {
              var _e55 = _a21.eq(c),
                  _i10 = _e55.index();

              if (_e55.addClass(s.bulletActiveClass), s.dynamicBullets) {
                var _e56 = _a21.eq(_n13),
                    _r5 = _a21.eq(_o6);

                for (var _e57 = _n13; _e57 <= _o6; _e57 += 1) {
                  _a21.eq(_e57).addClass("".concat(s.bulletActiveClass, "-main"));
                }

                if (t.params.loop) {
                  if (_i10 >= _a21.length) {
                    for (var _e58 = s.dynamicMainBullets; _e58 >= 0; _e58 -= 1) {
                      _a21.eq(_a21.length - _e58).addClass("".concat(s.bulletActiveClass, "-main"));
                    }

                    _a21.eq(_a21.length - s.dynamicMainBullets - 1).addClass("".concat(s.bulletActiveClass, "-prev"));
                  } else d(_e56, "prev"), d(_r5, "next");
                } else d(_e56, "prev"), d(_r5, "next");
              }
            }

            if (s.dynamicBullets) {
              var _n14 = Math.min(_a21.length, s.dynamicMainBullets + 4),
                  _i11 = (r * _n14 - r) / 2 - _p3 * r,
                  _l7 = e ? "right" : "left";

              _a21.css(t.isHorizontal() ? _l7 : "top", "".concat(_i11, "px"));
            }
          }

          if ("fraction" === s.type && (i.find(ae(s.currentClass)).text(s.formatFractionCurrent(c + 1)), i.find(ae(s.totalClass)).text(s.formatFractionTotal(p))), "progressbar" === s.type) {
            var _e59;

            _e59 = s.progressbarOpposite ? t.isHorizontal() ? "vertical" : "horizontal" : t.isHorizontal() ? "horizontal" : "vertical";

            var _a22 = (c + 1) / p;

            var _n15 = 1,
                _r6 = 1;
            "horizontal" === _e59 ? _n15 = _a22 : _r6 = _a22, i.find(ae(s.progressbarFillClass)).transform("translate3d(0,0,0) scaleX(".concat(_n15, ") scaleY(").concat(_r6, ")")).transition(t.params.speed);
          }

          "custom" === s.type && s.renderCustom ? (i.html(s.renderCustom(t, c + 1, p)), n("paginationRender", i[0])) : n("paginationUpdate", i[0]), t.params.watchOverflow && t.enabled && i[t.isLocked ? "addClass" : "removeClass"](s.lockClass);
        }

        function p() {
          var e = t.params.pagination;
          if (o()) return;
          var s = t.virtual && t.params.virtual.enabled ? t.virtual.slides.length : t.slides.length,
              a = t.pagination.$el;
          var i = "";

          if ("bullets" === e.type) {
            var _n16 = t.params.loop ? Math.ceil((s - 2 * t.loopedSlides) / t.params.slidesPerGroup) : t.snapGrid.length;

            t.params.freeMode && t.params.freeMode.enabled && !t.params.loop && _n16 > s && (_n16 = s);

            for (var _s35 = 0; _s35 < _n16; _s35 += 1) {
              e.renderBullet ? i += e.renderBullet.call(t, _s35, e.bulletClass) : i += "<".concat(e.bulletElement, " class=\"").concat(e.bulletClass, "\"></").concat(e.bulletElement, ">");
            }

            a.html(i), t.pagination.bullets = a.find(ae(e.bulletClass));
          }

          "fraction" === e.type && (i = e.renderFraction ? e.renderFraction.call(t, e.currentClass, e.totalClass) : "<span class=\"".concat(e.currentClass, "\"></span> / <span class=\"").concat(e.totalClass, "\"></span>"), a.html(i)), "progressbar" === e.type && (i = e.renderProgressbar ? e.renderProgressbar.call(t, e.progressbarFillClass) : "<span class=\"".concat(e.progressbarFillClass, "\"></span>"), a.html(i)), "custom" !== e.type && n("paginationRender", t.pagination.$el[0]);
        }

        function u() {
          t.params.pagination = te(t, t.originalParams.pagination, t.params.pagination, {
            el: "swiper-pagination"
          });
          var e = t.params.pagination;
          if (!e.el) return;
          var s = b(e.el);
          0 !== s.length && (t.params.uniqueNavElements && "string" == typeof e.el && s.length > 1 && (s = t.$el.find(e.el), s.length > 1 && (s = s.filter(function (e) {
            return b(e).parents(".swiper")[0] === t.el;
          }))), "bullets" === e.type && e.clickable && s.addClass(e.clickableClass), s.addClass(e.modifierClass + e.type), s.addClass(t.isHorizontal() ? e.horizontalClass : e.verticalClass), "bullets" === e.type && e.dynamicBullets && (s.addClass("".concat(e.modifierClass).concat(e.type, "-dynamic")), l = 0, e.dynamicMainBullets < 1 && (e.dynamicMainBullets = 1)), "progressbar" === e.type && e.progressbarOpposite && s.addClass(e.progressbarOppositeClass), e.clickable && s.on("click", ae(e.bulletClass), function (e) {
            e.preventDefault();
            var s = b(this).index() * t.params.slidesPerGroup;
            t.params.loop && (s += t.loopedSlides), t.slideTo(s);
          }), Object.assign(t.pagination, {
            $el: s,
            el: s[0]
          }), t.enabled || s.addClass(e.lockClass));
        }

        function m() {
          var e = t.params.pagination;
          if (o()) return;
          var s = t.pagination.$el;
          s.removeClass(e.hiddenClass), s.removeClass(e.modifierClass + e.type), s.removeClass(t.isHorizontal() ? e.horizontalClass : e.verticalClass), t.pagination.bullets && t.pagination.bullets.removeClass && t.pagination.bullets.removeClass(e.bulletActiveClass), e.clickable && s.off("click", ae(e.bulletClass));
        }

        a("init", function () {
          u(), p(), c();
        }), a("activeIndexChange", function () {
          (t.params.loop || void 0 === t.snapIndex) && c();
        }), a("snapIndexChange", function () {
          t.params.loop || c();
        }), a("slidesLengthChange", function () {
          t.params.loop && (p(), c());
        }), a("snapGridLengthChange", function () {
          t.params.loop || (p(), c());
        }), a("destroy", function () {
          m();
        }), a("enable disable", function () {
          var e = t.pagination.$el;
          e && e[t.enabled ? "removeClass" : "addClass"](t.params.pagination.lockClass);
        }), a("lock unlock", function () {
          c();
        }), a("click", function (e, s) {
          var a = s.target,
              i = t.pagination.$el;

          if (t.params.pagination.el && t.params.pagination.hideOnClick && i.length > 0 && !b(a).hasClass(t.params.pagination.bulletClass)) {
            if (t.navigation && (t.navigation.nextEl && a === t.navigation.nextEl || t.navigation.prevEl && a === t.navigation.prevEl)) return;

            var _e60 = i.hasClass(t.params.pagination.hiddenClass);

            n(!0 === _e60 ? "paginationShow" : "paginationHide"), i.toggleClass(t.params.pagination.hiddenClass);
          }
        }), Object.assign(t.pagination, {
          render: p,
          update: c,
          init: u,
          destroy: m
        });
      }

      function ie(e) {
        var t,
            s = e.swiper,
            a = e.extendParams,
            n = e.on,
            i = e.emit;

        function r() {
          var e = s.slides.eq(s.activeIndex);
          var a = s.params.autoplay.delay;
          e.attr("data-swiper-autoplay") && (a = e.attr("data-swiper-autoplay") || s.params.autoplay.delay), clearTimeout(t), t = w(function () {
            var e;
            s.params.autoplay.reverseDirection ? s.params.loop ? (s.loopFix(), e = s.slidePrev(s.params.speed, !0, !0), i("autoplay")) : s.isBeginning ? s.params.autoplay.stopOnLastSlide ? d() : (e = s.slideTo(s.slides.length - 1, s.params.speed, !0, !0), i("autoplay")) : (e = s.slidePrev(s.params.speed, !0, !0), i("autoplay")) : s.params.loop ? (s.loopFix(), e = s.slideNext(s.params.speed, !0, !0), i("autoplay")) : s.isEnd ? s.params.autoplay.stopOnLastSlide ? d() : (e = s.slideTo(0, s.params.speed, !0, !0), i("autoplay")) : (e = s.slideNext(s.params.speed, !0, !0), i("autoplay")), (s.params.cssMode && s.autoplay.running || !1 === e) && r();
          }, a);
        }

        function l() {
          return void 0 === t && !s.autoplay.running && (s.autoplay.running = !0, i("autoplayStart"), r(), !0);
        }

        function d() {
          return !!s.autoplay.running && void 0 !== t && (t && (clearTimeout(t), t = void 0), s.autoplay.running = !1, i("autoplayStop"), !0);
        }

        function c(e) {
          s.autoplay.running && (s.autoplay.paused || (t && clearTimeout(t), s.autoplay.paused = !0, 0 !== e && s.params.autoplay.waitForTransition ? ["transitionend", "webkitTransitionEnd"].forEach(function (e) {
            s.$wrapperEl[0].addEventListener(e, u);
          }) : (s.autoplay.paused = !1, r())));
        }

        function p() {
          var e = o();
          "hidden" === e.visibilityState && s.autoplay.running && c(), "visible" === e.visibilityState && s.autoplay.paused && (r(), s.autoplay.paused = !1);
        }

        function u(e) {
          s && !s.destroyed && s.$wrapperEl && e.target === s.$wrapperEl[0] && (["transitionend", "webkitTransitionEnd"].forEach(function (e) {
            s.$wrapperEl[0].removeEventListener(e, u);
          }), s.autoplay.paused = !1, s.autoplay.running ? r() : d());
        }

        function m() {
          s.params.autoplay.disableOnInteraction ? d() : (i("autoplayPause"), c()), ["transitionend", "webkitTransitionEnd"].forEach(function (e) {
            s.$wrapperEl[0].removeEventListener(e, u);
          });
        }

        function h() {
          s.params.autoplay.disableOnInteraction || (s.autoplay.paused = !1, i("autoplayResume"), r());
        }

        s.autoplay = {
          running: !1,
          paused: !1
        }, a({
          autoplay: {
            enabled: !1,
            delay: 3e3,
            waitForTransition: !0,
            disableOnInteraction: !0,
            stopOnLastSlide: !1,
            reverseDirection: !1,
            pauseOnMouseEnter: !1
          }
        }), n("init", function () {
          s.params.autoplay.enabled && (l(), o().addEventListener("visibilitychange", p), s.params.autoplay.pauseOnMouseEnter && (s.$el.on("mouseenter", m), s.$el.on("mouseleave", h)));
        }), n("beforeTransitionStart", function (e, t, a) {
          s.autoplay.running && (a || !s.params.autoplay.disableOnInteraction ? s.autoplay.pause(t) : d());
        }), n("sliderFirstMove", function () {
          s.autoplay.running && (s.params.autoplay.disableOnInteraction ? d() : c());
        }), n("touchEnd", function () {
          s.params.cssMode && s.autoplay.paused && !s.params.autoplay.disableOnInteraction && r();
        }), n("destroy", function () {
          s.$el.off("mouseenter", m), s.$el.off("mouseleave", h), s.autoplay.running && d(), o().removeEventListener("visibilitychange", p);
        }), Object.assign(s.autoplay, {
          pause: c,
          run: r,
          start: l,
          stop: d
        });
      }

      function re(e) {
        return "object" == _typeof(e) && null !== e && e.constructor && "Object" === Object.prototype.toString.call(e).slice(8, -1);
      }

      function le(e, t) {
        var s = ["__proto__", "constructor", "prototype"];
        Object.keys(t).filter(function (e) {
          return s.indexOf(e) < 0;
        }).forEach(function (s) {
          void 0 === e[s] ? e[s] = t[s] : re(t[s]) && re(e[s]) && Object.keys(t[s]).length > 0 ? t[s].__swiper__ ? e[s] = t[s] : le(e[s], t[s]) : e[s] = t[s];
        });
      }

      function oe(e) {
        return void 0 === e && (e = {}), e.navigation && void 0 === e.navigation.nextEl && void 0 === e.navigation.prevEl;
      }

      function de(e) {
        return void 0 === e && (e = {}), e.pagination && void 0 === e.pagination.el;
      }

      function ce(e) {
        return void 0 === e && (e = {}), e.scrollbar && void 0 === e.scrollbar.el;
      }

      function pe(e) {
        void 0 === e && (e = "");
        var t = e.split(" ").map(function (e) {
          return e.trim();
        }).filter(function (e) {
          return !!e;
        }),
            s = [];
        return t.forEach(function (e) {
          s.indexOf(e) < 0 && s.push(e);
        }), s.join(" ");
      }

      var ue = ["modules", "init", "_direction", "touchEventsTarget", "initialSlide", "_speed", "cssMode", "updateOnWindowResize", "resizeObserver", "nested", "focusableElements", "_enabled", "_width", "_height", "preventInteractionOnTransition", "userAgent", "url", "_edgeSwipeDetection", "_edgeSwipeThreshold", "_freeMode", "_autoHeight", "setWrapperSize", "virtualTranslate", "_effect", "breakpoints", "_spaceBetween", "_slidesPerView", "maxBackfaceHiddenSlides", "_grid", "_slidesPerGroup", "_slidesPerGroupSkip", "_slidesPerGroupAuto", "_centeredSlides", "_centeredSlidesBounds", "_slidesOffsetBefore", "_slidesOffsetAfter", "normalizeSlideIndex", "_centerInsufficientSlides", "_watchOverflow", "roundLengths", "touchRatio", "touchAngle", "simulateTouch", "_shortSwipes", "_longSwipes", "longSwipesRatio", "longSwipesMs", "_followFinger", "allowTouchMove", "_threshold", "touchMoveStopPropagation", "touchStartPreventDefault", "touchStartForcePreventDefault", "touchReleaseOnEdges", "uniqueNavElements", "_resistance", "_resistanceRatio", "_watchSlidesProgress", "_grabCursor", "preventClicks", "preventClicksPropagation", "_slideToClickedSlide", "_preloadImages", "updateOnImagesReady", "_loop", "_loopAdditionalSlides", "_loopedSlides", "_loopFillGroupWithBlank", "loopPreventsSlide", "_rewind", "_allowSlidePrev", "_allowSlideNext", "_swipeHandler", "_noSwiping", "noSwipingClass", "noSwipingSelector", "passiveListeners", "containerModifierClass", "slideClass", "slideBlankClass", "slideActiveClass", "slideDuplicateActiveClass", "slideVisibleClass", "slideDuplicateClass", "slideNextClass", "slideDuplicateNextClass", "slidePrevClass", "slideDuplicatePrevClass", "wrapperClass", "runCallbacksOnInit", "observer", "observeParents", "observeSlideChildren", "a11y", "_autoplay", "_controller", "coverflowEffect", "cubeEffect", "fadeEffect", "flipEffect", "creativeEffect", "cardsEffect", "hashNavigation", "history", "keyboard", "lazy", "mousewheel", "_navigation", "_pagination", "parallax", "_scrollbar", "_thumbs", "virtual", "zoom"];

      function me(e, t) {
        var s = t.slidesPerView;

        if (t.breakpoints) {
          var _e61 = J.prototype.getBreakpoint(t.breakpoints),
              _a23 = _e61 in t.breakpoints ? t.breakpoints[_e61] : void 0;

          _a23 && _a23.slidesPerView && (s = _a23.slidesPerView);
        }

        var a = Math.ceil(parseFloat(t.loopedSlides || s, 10));
        return a += t.loopAdditionalSlides, a > e.length && (a = e.length), a;
      }

      function he(e) {
        var t = [];
        return n.Children.toArray(e).forEach(function (e) {
          e.type && "SwiperSlide" === e.type.displayName ? t.push(e) : e.props && e.props.children && he(e.props.children).forEach(function (e) {
            return t.push(e);
          });
        }), t;
      }

      function fe(e) {
        var t = [],
            s = {
          "container-start": [],
          "container-end": [],
          "wrapper-start": [],
          "wrapper-end": []
        };
        return n.Children.toArray(e).forEach(function (e) {
          if (e.type && "SwiperSlide" === e.type.displayName) t.push(e);else if (e.props && e.props.slot && s[e.props.slot]) s[e.props.slot].push(e);else if (e.props && e.props.children) {
            var _a24 = he(e.props.children);

            _a24.length > 0 ? _a24.forEach(function (e) {
              return t.push(e);
            }) : s["container-end"].push(e);
          } else s["container-end"].push(e);
        }), {
          slides: t,
          slots: s
        };
      }

      function ge(e, t) {
        return "undefined" == typeof window ? (0, n.useEffect)(e, t) : (0, n.useLayoutEffect)(e, t);
      }

      var ve = (0, n.createContext)(null),
          be = (0, n.createContext)(null);

      function we() {
        return we = Object.assign || function (e) {
          for (var t = 1; t < arguments.length; t++) {
            var s = arguments[t];

            for (var a in s) {
              Object.prototype.hasOwnProperty.call(s, a) && (e[a] = s[a]);
            }
          }

          return e;
        }, we.apply(this, arguments);
      }

      var ye = (0, n.forwardRef)(function (e, t) {
        var _ref2 = void 0 === e ? {} : e,
            s = _ref2.className,
            _ref2$tag = _ref2.tag,
            a = _ref2$tag === void 0 ? "div" : _ref2$tag,
            _ref2$wrapperTag = _ref2.wrapperTag,
            i = _ref2$wrapperTag === void 0 ? "div" : _ref2$wrapperTag,
            r = _ref2.children,
            l = _ref2.onSwiper,
            o = _objectWithoutProperties(_ref2, ["className", "tag", "wrapperTag", "children", "onSwiper"]),
            d = !1;

        var _ref3 = (0, n.useState)("swiper"),
            _ref4 = _slicedToArray(_ref3, 2),
            c = _ref4[0],
            p = _ref4[1],
            _ref5 = (0, n.useState)(null),
            _ref6 = _slicedToArray(_ref5, 2),
            u = _ref6[0],
            m = _ref6[1],
            _ref7 = (0, n.useState)(!1),
            _ref8 = _slicedToArray(_ref7, 2),
            h = _ref8[0],
            f = _ref8[1],
            g = (0, n.useRef)(!1),
            v = (0, n.useRef)(null),
            b = (0, n.useRef)(null),
            w = (0, n.useRef)(null),
            y = (0, n.useRef)(null),
            C = (0, n.useRef)(null),
            E = (0, n.useRef)(null),
            S = (0, n.useRef)(null),
            T = (0, n.useRef)(null),
            _ref9 = function (e) {
          void 0 === e && (e = {});
          var t = {
            on: {}
          },
              s = {},
              a = {};
          le(t, J.defaults), le(t, J.extendedDefaults), t._emitClasses = !0, t.init = !1;
          var n = {},
              i = ue.map(function (e) {
            return e.replace(/_/, "");
          });
          return Object.keys(e).forEach(function (r) {
            i.indexOf(r) >= 0 ? re(e[r]) ? (t[r] = {}, a[r] = {}, le(t[r], e[r]), le(a[r], e[r])) : (t[r] = e[r], a[r] = e[r]) : 0 === r.search(/on[A-Z]/) && "function" == typeof e[r] ? s["".concat(r[2].toLowerCase()).concat(r.substr(3))] = e[r] : n[r] = e[r];
          }), ["navigation", "pagination", "scrollbar"].forEach(function (e) {
            !0 === t[e] && (t[e] = {}), !1 === t[e] && delete t[e];
          }), {
            params: t,
            passedParams: a,
            rest: n,
            events: s
          };
        }(o),
            x = _ref9.params,
            k = _ref9.passedParams,
            _ = _ref9.rest,
            P = _ref9.events,
            _fe = fe(r),
            M = _fe.slides,
            $ = _fe.slots,
            O = function O() {
          f(!h);
        };

        Object.assign(x.on, {
          _containerClasses: function _containerClasses(e, t) {
            p(t);
          }
        });

        var L = function L() {
          if (Object.assign(x.on, P), d = !0, b.current = new J(x), b.current.loopCreate = function () {}, b.current.loopDestroy = function () {}, x.loop && (b.current.loopedSlides = me(M, x)), b.current.virtual && b.current.params.virtual.enabled) {
            b.current.virtual.slides = M;
            var _e62 = {
              cache: !1,
              slides: M,
              renderExternal: m,
              renderExternalUpdate: !1
            };
            le(b.current.params.virtual, _e62), le(b.current.originalParams.virtual, _e62);
          }
        };

        return v.current || L(), b.current && b.current.on("_beforeBreakpoint", O), (0, n.useEffect)(function () {
          return function () {
            b.current && b.current.off("_beforeBreakpoint", O);
          };
        }), (0, n.useEffect)(function () {
          !g.current && b.current && (b.current.emitSlidesClasses(), g.current = !0);
        }), ge(function () {
          if (t && (t.current = v.current), v.current) return b.current.destroyed && L(), function (e, t) {
            var s = e.el,
                a = e.nextEl,
                n = e.prevEl,
                i = e.paginationEl,
                r = e.scrollbarEl,
                l = e.swiper;
            oe(t) && a && n && (l.params.navigation.nextEl = a, l.originalParams.navigation.nextEl = a, l.params.navigation.prevEl = n, l.originalParams.navigation.prevEl = n), de(t) && i && (l.params.pagination.el = i, l.originalParams.pagination.el = i), ce(t) && r && (l.params.scrollbar.el = r, l.originalParams.scrollbar.el = r), l.init(s);
          }({
            el: v.current,
            nextEl: C.current,
            prevEl: E.current,
            paginationEl: S.current,
            scrollbarEl: T.current,
            swiper: b.current
          }, x), l && l(b.current), function () {
            b.current && !b.current.destroyed && b.current.destroy(!0, !1);
          };
        }, []), ge(function () {
          !d && P && b.current && Object.keys(P).forEach(function (e) {
            b.current.on(e, P[e]);
          });

          var e = function (e, t, s, a) {
            var n = [];
            if (!t) return n;

            var i = function i(e) {
              n.indexOf(e) < 0 && n.push(e);
            },
                r = a.map(function (e) {
              return e.key;
            }),
                l = s.map(function (e) {
              return e.key;
            });

            return r.join("") !== l.join("") && i("children"), a.length !== s.length && i("children"), ue.filter(function (e) {
              return "_" === e[0];
            }).map(function (e) {
              return e.replace(/_/, "");
            }).forEach(function (s) {
              if (s in e && s in t) if (re(e[s]) && re(t[s])) {
                var _a25 = Object.keys(e[s]),
                    _n17 = Object.keys(t[s]);

                _a25.length !== _n17.length ? i(s) : (_a25.forEach(function (a) {
                  e[s][a] !== t[s][a] && i(s);
                }), _n17.forEach(function (a) {
                  e[s][a] !== t[s][a] && i(s);
                }));
              } else e[s] !== t[s] && i(s);
            }), n;
          }(k, w.current, M, y.current);

          return w.current = k, y.current = M, e.length && b.current && !b.current.destroyed && function (e) {
            var t = e.swiper,
                s = e.slides,
                a = e.passedParams,
                n = e.changedParams,
                i = e.nextEl,
                r = e.prevEl,
                l = e.scrollbarEl,
                o = e.paginationEl;
            var d = n.filter(function (e) {
              return "children" !== e && "direction" !== e;
            }),
                c = t.params,
                p = t.pagination,
                u = t.navigation,
                m = t.scrollbar,
                h = t.virtual,
                f = t.thumbs;
            var g, v, b, w, y;
            n.includes("thumbs") && a.thumbs && a.thumbs.swiper && c.thumbs && !c.thumbs.swiper && (g = !0), n.includes("controller") && a.controller && a.controller.control && c.controller && !c.controller.control && (v = !0), n.includes("pagination") && a.pagination && (a.pagination.el || o) && (c.pagination || !1 === c.pagination) && p && !p.el && (b = !0), n.includes("scrollbar") && a.scrollbar && (a.scrollbar.el || l) && (c.scrollbar || !1 === c.scrollbar) && m && !m.el && (w = !0), n.includes("navigation") && a.navigation && (a.navigation.prevEl || r) && (a.navigation.nextEl || i) && (c.navigation || !1 === c.navigation) && u && !u.prevEl && !u.nextEl && (y = !0), d.forEach(function (e) {
              if (re(c[e]) && re(a[e])) le(c[e], a[e]);else {
                var _n18 = a[e];
                !0 !== _n18 && !1 !== _n18 || "navigation" !== e && "pagination" !== e && "scrollbar" !== e ? c[e] = a[e] : !1 === _n18 && t[s = e] && (t[s].destroy(), "navigation" === s ? (c[s].prevEl = void 0, c[s].nextEl = void 0, t[s].prevEl = void 0, t[s].nextEl = void 0) : (c[s].el = void 0, t[s].el = void 0));
              }
              var s;
            }), d.includes("controller") && !v && t.controller && t.controller.control && c.controller && c.controller.control && (t.controller.control = c.controller.control), n.includes("children") && h && c.virtual.enabled ? (h.slides = s, h.update(!0)) : n.includes("children") && t.lazy && t.params.lazy.enabled && t.lazy.load(), g && f.init() && f.update(!0), v && (t.controller.control = c.controller.control), b && (o && (c.pagination.el = o), p.init(), p.render(), p.update()), w && (l && (c.scrollbar.el = l), m.init(), m.updateSize(), m.setTranslate()), y && (i && (c.navigation.nextEl = i), r && (c.navigation.prevEl = r), u.init(), u.update()), n.includes("allowSlideNext") && (t.allowSlideNext = a.allowSlideNext), n.includes("allowSlidePrev") && (t.allowSlidePrev = a.allowSlidePrev), n.includes("direction") && t.changeDirection(a.direction, !1), t.update();
          }({
            swiper: b.current,
            slides: M,
            passedParams: k,
            changedParams: e,
            nextEl: C.current,
            prevEl: E.current,
            scrollbarEl: T.current,
            paginationEl: S.current
          }), function () {
            P && b.current && Object.keys(P).forEach(function (e) {
              b.current.off(e, P[e]);
            });
          };
        }), ge(function () {
          var e;
          !(e = b.current) || e.destroyed || !e.params.virtual || e.params.virtual && !e.params.virtual.enabled || (e.updateSlides(), e.updateProgress(), e.updateSlidesClasses(), e.lazy && e.params.lazy.enabled && e.lazy.load(), e.parallax && e.params.parallax && e.params.parallax.enabled && e.parallax.setTranslate());
        }, [u]), n.createElement(a, we({
          ref: v,
          className: pe("".concat(c).concat(s ? " ".concat(s) : ""))
        }, _), n.createElement(be.Provider, {
          value: b.current
        }, $["container-start"], oe(x) && n.createElement(n.Fragment, null, n.createElement("div", {
          ref: E,
          className: "swiper-button-prev"
        }), n.createElement("div", {
          ref: C,
          className: "swiper-button-next"
        })), ce(x) && n.createElement("div", {
          ref: T,
          className: "swiper-scrollbar"
        }), de(x) && n.createElement("div", {
          ref: S,
          className: "swiper-pagination"
        }), n.createElement(i, {
          className: "swiper-wrapper"
        }, $["wrapper-start"], x.virtual ? function (e, t, s) {
          if (!s) return null;
          var a = e.isHorizontal() ? _defineProperty({}, e.rtlTranslate ? "right" : "left", "".concat(s.offset, "px")) : {
            top: "".concat(s.offset, "px")
          };
          return t.filter(function (e, t) {
            return t >= s.from && t <= s.to;
          }).map(function (t) {
            return n.cloneElement(t, {
              swiper: e,
              style: a
            });
          });
        }(b.current, M, u) : !x.loop || b.current && b.current.destroyed ? M.map(function (e) {
          return n.cloneElement(e, {
            swiper: b.current
          });
        }) : function (e, t, s) {
          var a = t.map(function (t, s) {
            return n.cloneElement(t, {
              swiper: e,
              "data-swiper-slide-index": s
            });
          });

          function i(e, t, a) {
            return n.cloneElement(e, {
              key: "".concat(e.key, "-duplicate-").concat(t, "-").concat(a),
              className: "".concat(e.props.className || "", " ").concat(s.slideDuplicateClass)
            });
          }

          if (s.loopFillGroupWithBlank) {
            var _e63 = s.slidesPerGroup - a.length % s.slidesPerGroup;

            if (_e63 !== s.slidesPerGroup) for (var _t33 = 0; _t33 < _e63; _t33 += 1) {
              var _e64 = n.createElement("div", {
                className: "".concat(s.slideClass, " ").concat(s.slideBlankClass)
              });

              a.push(_e64);
            }
          }

          "auto" !== s.slidesPerView || s.loopedSlides || (s.loopedSlides = a.length);
          var r = me(a, s),
              l = [],
              o = [];
          return a.forEach(function (e, t) {
            t < r && o.push(i(e, t, "prepend")), t < a.length && t >= a.length - r && l.push(i(e, t, "append"));
          }), e && (e.loopedSlides = r), [].concat(l, _toConsumableArray(a), o);
        }(b.current, M, x), $["wrapper-end"]), $["container-end"]));
      });

      function Ce() {
        return Ce = Object.assign || function (e) {
          for (var t = 1; t < arguments.length; t++) {
            var s = arguments[t];

            for (var a in s) {
              Object.prototype.hasOwnProperty.call(s, a) && (e[a] = s[a]);
            }
          }

          return e;
        }, Ce.apply(this, arguments);
      }

      ye.displayName = "Swiper";
      var Ee = (0, n.forwardRef)(function (e, t) {
        var _ref11 = void 0 === e ? {} : e,
            _ref11$tag = _ref11.tag,
            s = _ref11$tag === void 0 ? "div" : _ref11$tag,
            a = _ref11.children,
            _ref11$className = _ref11.className,
            i = _ref11$className === void 0 ? "" : _ref11$className,
            r = _ref11.swiper,
            l = _ref11.zoom,
            o = _ref11.virtualIndex,
            d = _objectWithoutProperties(_ref11, ["tag", "children", "className", "swiper", "zoom", "virtualIndex"]);

        var c = (0, n.useRef)(null),
            _ref12 = (0, n.useState)("swiper-slide"),
            _ref13 = _slicedToArray(_ref12, 2),
            p = _ref13[0],
            u = _ref13[1];

        function m(e, t, s) {
          t === c.current && u(s);
        }

        ge(function () {
          if (t && (t.current = c.current), c.current && r) {
            if (!r.destroyed) return r.on("_slideClass", m), function () {
              r && r.off("_slideClass", m);
            };
            "swiper-slide" !== p && u("swiper-slide");
          }
        }), ge(function () {
          r && c.current && !r.destroyed && u(r.getSlideClasses(c.current));
        }, [r]);

        var h = {
          isActive: p.indexOf("swiper-slide-active") >= 0 || p.indexOf("swiper-slide-duplicate-active") >= 0,
          isVisible: p.indexOf("swiper-slide-visible") >= 0,
          isDuplicate: p.indexOf("swiper-slide-duplicate") >= 0,
          isPrev: p.indexOf("swiper-slide-prev") >= 0 || p.indexOf("swiper-slide-duplicate-prev") >= 0,
          isNext: p.indexOf("swiper-slide-next") >= 0 || p.indexOf("swiper-slide-duplicate-next") >= 0
        },
            f = function f() {
          return "function" == typeof a ? a(h) : a;
        };

        return n.createElement(s, Ce({
          ref: c,
          className: pe("".concat(p).concat(i ? " ".concat(i) : "")),
          "data-swiper-slide-index": o
        }, d), n.createElement(ve.Provider, {
          value: h
        }, l ? n.createElement("div", {
          className: "swiper-zoom-container",
          "data-swiper-zoom": "number" == typeof l ? l : void 0
        }, f()) : f()));
      });
      Ee.displayName = "SwiperSlide";
      var Se = window.wp.blockEditor,
          Te = window.wp.components;
      var __ = wp.i18n.__;

      var xe = [{
        name: __("Light Green", "n3-logo-carousel-block"),
        color: "#E4EFE7"
      }, {
        name: __("Orange", "n3-logo-carousel-block"),
        color: "#FEA82F"
      }, {
        name: __("Light Red", "n3-logo-carousel-block"),
        color: "#FF7171"
      }, {
        name: __("Light Black", "n3-logo-carousel-block"),
        color: "#4B6587"
      }, {
        name: __("Gray", "n3-logo-carousel-block"),
        color: "#F6F6F6"
      }, {
        name: __("Black", "n3-logo-carousel-block"),
        color: "#333333"
      }],
          ke = function ke(e) {
        var t = e.title,
            a = e.device,
            n = e.renderFunction;
        return (0, s.createElement)("div", {
          className: "res__devices"
        }, (0, s.createElement)("div", {
          className: "res__label"
        }, t), (0, s.createElement)("div", {
          className: "res__btns"
        }, (0, s.createElement)(Te.Button, {
          onClick: function onClick() {
            return n("desktop");
          },
          isSmall: !0,
          isPressed: "desktop" === a
        }, (0, s.createElement)("span", {
          className: "dashicons dashicons-desktop"
        })), (0, s.createElement)(Te.Button, {
          onClick: function onClick() {
            return n("tablet");
          },
          isSmall: !0,
          isPressed: "tablet" === a
        }, (0, s.createElement)("span", {
          className: "dashicons dashicons-tablet"
        })), (0, s.createElement)(Te.Button, {
          onClick: function onClick() {
            return n("smartphone");
          },
          isSmall: !0,
          isPressed: "smartphone" === a
        }, (0, s.createElement)("span", {
          className: "dashicons dashicons-smartphone"
        }))));
      };

      var _e = wp.element.Fragment;
      var Pe = (0, s.createElement)("svg", {
        width: "24px",
        height: "24px",
        viewBox: "0 0 24 24"
      }, (0, s.createElement)("path", {
        d: "M4 19h2c0 1.103.897 2 2 2h8c1.103 0 2-.897 2-2h2c1.103 0 2-.897 2-2V7c0-1.103-.897-2-2-2h-2c0-1.103-.897-2-2-2H8c-1.103 0-2 .897-2 2H4c-1.103 0-2 .897-2 2v10c0 1.103.897 2 2 2zM20 7v10h-2V7h2zM8 5h8l.001 14H8V5zM4 7h2v10H4V7z"
      }));
      (0, e.registerBlockType)(t, {
        icon: {
          src: Pe,
          foreground: "#ffffff",
          background: "#000000"
        },
        edit: function edit(e) {
          var t = e.attributes,
              n = e.setAttributes,
              i = e.clientId;
          var r = t.sliderId,
              l = t.images,
              o = t.loop,
              d = t.speed,
              c = t.autoplay,
              p = t.reverseAutoplayDirection,
              u = t.autoplayDelay,
              m = t.pauseOnHover,
              h = t.keyboard,
              f = t.mousewheel,
              g = t.autoHeight,
              v = t.slideDirection,
              b = t.showNav,
              w = t.showPagination,
              y = t.itemDevice,
              C = t.deskItemsPerView,
              E = t.tabItemsPerView,
              S = t.phoneItemsPerView,
              T = t.spaceDevice,
              x = t.deskSpace,
              k = t.tabSpace,
              _ = t.phoneSpace,
              P = t.showCaption,
              M = t.captionVisibility,
              $ = t.captionBg,
              O = t.captionColor,
              L = t.borderWidth,
              D = t.borderColor,
              N = t.borderStyle,
              A = t.borderRadius,
              I = t.logoHoverStyle;
          return n({
            sliderId: "alcb__".concat(i.slice(0, 8))
          }), (0, s.createElement)(_e, null, l && (0, s.createElement)(Se.BlockControls, null, (0, s.createElement)(Te.ToolbarGroup, null, (0, s.createElement)(Se.MediaUploadCheck, null, (0, s.createElement)(Se.MediaUpload, {
            multiple: !0,
            onSelect: function onSelect(e) {
              return n({
                images: e
              });
            },
            gallery: !0,
            allowedTypes: ["image"],
            value: l.map(function (e) {
              return e.id;
            }),
            render: function render(e) {
              var t = e.open;
              return (0, s.createElement)(Te.ToolbarButton, {
                label: (0, a.__)("Edit Logos", "n3-logo-carousel-block"),
                onClick: t,
                icon: "edit"
              });
            }
          })))), (0, s.createElement)(Se.InspectorControls, null, (0, s.createElement)(Te.PanelBody, {
            title: (0, a.__)("Carousel Settings", "n3-logo-carousel-block"),
            initialOpen: !0
          }, (0, s.createElement)(Te.ToggleControl, {
            label: (0, a.__)("Enable Autoplay", "n3-logo-carousel-block"),
            checked: c,
            onChange: function onChange() {
              return n({
                autoplay: !c
              });
            }
          }), c && (0, s.createElement)(_e, null, (0, s.createElement)(Te.RangeControl, {
            label: (0, a.__)("Autoplay Delay", "n3-logo-carousel-block"),
            value: u,
            onChange: function onChange(e) {
              return n({
                autoplayDelay: e
              });
            },
            min: 100,
            max: 1e4,
            step: 100
          }), (0, s.createElement)(Te.ToggleControl, {
            label: (0, a.__)("Pause Autoplay On Hover", "n3-logo-carousel-block"),
            checked: m,
            onChange: function onChange() {
              return n({
                pauseOnHover: !m
              });
            }
          }), (0, s.createElement)(Te.ToggleControl, {
            label: (0, a.__)("Reserve Autoplay Direction", "n3-logo-carousel-block"),
            checked: p,
            onChange: function onChange() {
              return n({
                reverseAutoplayDirection: !p
              });
            }
          })), (0, s.createElement)(Te.SelectControl, {
            label: (0, a.__)("Slide Direction", "n3-logo-carousel-block"),
            value: v,
            options: [{
              label: (0, a.__)("Left to Right", "n3-logo-carousel-block"),
              value: "ltr"
            }, {
              label: (0, a.__)("Right to Left", "n3-logo-carousel-block"),
              value: "rtl"
            }],
            onChange: function onChange(e) {
              n({
                slideDirection: e
              });
            }
          }), (0, s.createElement)(Te.RangeControl, {
            label: (0, a.__)("Carousel Speed", "n3-logo-carousel-block"),
            value: d,
            onChange: function onChange(e) {
              return n({
                speed: e
              });
            },
            min: 100,
            max: 2e3,
            step: 100
          }), (0, s.createElement)(Te.ToggleControl, {
            label: (0, a.__)("Enable Infinite Loop", "n3-logo-carousel-block"),
            checked: o,
            onChange: function onChange() {
              return n({
                loop: !o
              });
            }
          }), (0, s.createElement)(Te.ToggleControl, {
            label: (0, a.__)("Enable Auto Height", "n3-logo-carousel-block"),
            checked: g,
            onChange: function onChange() {
              return n({
                autoHeight: !g
              });
            }
          }), (0, s.createElement)(Te.ToggleControl, {
            label: (0, a.__)("Enable Keyboard Control", "n3-logo-carousel-block"),
            checked: h,
            onChange: function onChange() {
              return n({
                keyboard: !h
              });
            }
          }), (0, s.createElement)(Te.ToggleControl, {
            label: (0, a.__)("Enable Mouse Control", "n3-logo-carousel-block"),
            checked: f,
            onChange: function onChange() {
              return n({
                mousewheel: !f
              });
            }
          }), (0, s.createElement)(ke, {
            device: y,
            title: (0, a.__)("Logos Per View", "n3-logo-carousel-block"),
            renderFunction: function renderFunction(e) {
              return n({
                itemDevice: e
              });
            }
          }), "desktop" === y && (0, s.createElement)(Te.RangeControl, {
            value: C,
            onChange: function onChange(e) {
              return n({
                deskItemsPerView: e
              });
            },
            min: 1,
            max: 10
          }), "tablet" === y && (0, s.createElement)(Te.RangeControl, {
            value: E,
            onChange: function onChange(e) {
              return n({
                tabItemsPerView: e
              });
            },
            min: 1,
            max: 10
          }), "smartphone" === y && (0, s.createElement)(Te.RangeControl, {
            value: S,
            onChange: function onChange(e) {
              return n({
                phoneItemsPerView: e
              });
            },
            min: 1,
            max: 10
          }), (0, s.createElement)(ke, {
            title: (0, a.__)("Space Between Logos", "n3-logo-carousel-block"),
            device: T,
            renderFunction: function renderFunction(e) {
              return n({
                spaceDevice: e
              });
            }
          }), "desktop" === T && (0, s.createElement)(Te.RangeControl, {
            value: x,
            onChange: function onChange(e) {
              return n({
                deskSpace: e
              });
            },
            min: 0,
            max: 100
          }), "tablet" === T && (0, s.createElement)(Te.RangeControl, {
            value: k,
            onChange: function onChange(e) {
              return n({
                tabSpace: e
              });
            },
            min: 0,
            max: 100
          }), "smartphone" === T && (0, s.createElement)(Te.RangeControl, {
            value: _,
            onChange: function onChange(e) {
              return n({
                phoneSpace: e
              });
            },
            min: 0,
            max: 100
          })), (0, s.createElement)(Te.PanelBody, {
            title: (0, a.__)("Navigation", "n3-logo-carousel-block"),
            initialOpen: !1
          }, (0, s.createElement)(Te.ToggleControl, {
            label: (0, a.__)("Show Navigation", "n3-logo-carousel-block"),
            help: b ? (0, a.__)("Navigation is Visible", "n3-logo-carousel-block") : (0, a.__)("Navigation is invisible", "n3-logo-carousel-block"),
            checked: b,
            onChange: function onChange() {
              return n({
                showNav: !b
              });
            }
          })), (0, s.createElement)(Te.PanelBody, {
            title: (0, a.__)("Pagination", "n3-logo-carousel-block"),
            initialOpen: !1
          }, (0, s.createElement)(Te.ToggleControl, {
            label: (0, a.__)("Show Pagination", "n3-logo-carousel-block"),
            help: w ? (0, a.__)("Pagination is Visible", "n3-logo-carousel-block") : (0, a.__)("Pagination is invisible", "n3-logo-carousel-block"),
            checked: w,
            onChange: function onChange() {
              return n({
                showPagination: !w
              });
            }
          })), (0, s.createElement)(Te.PanelBody, {
            title: (0, a.__)("Logo Caption", "n3-logo-carousel-block"),
            initialOpen: !1
          }, (0, s.createElement)(Te.ToggleControl, {
            label: (0, a.__)("Show Logo Caption", "n3-logo-carousel-block"),
            checked: P,
            onChange: function onChange() {
              return n({
                showCaption: !P
              });
            }
          }), P && (0, s.createElement)(_e, null, (0, s.createElement)(Te.SelectControl, {
            label: (0, a.__)("Caption Visibility", "n3-logo-carousel-block"),
            value: M,
            options: [{
              label: (0, a.__)("Always Visible", "n3-logo-carousel-block"),
              value: "caption__always"
            }, {
              label: (0, a.__)("Visible on Hover", "n3-logo-carousel-block"),
              value: "caption__hover"
            }],
            onChange: function onChange(e) {
              n({
                captionVisibility: e
              });
            }
          }), (0, s.createElement)("p", {
            className: "alcb__label"
          }, (0, a.__)("Color", "n3-logo-carousel-block")), (0, s.createElement)(Te.ColorPalette, {
            colors: xe,
            value: O,
            onChange: function onChange(e) {
              return n({
                captionColor: e
              });
            }
          }), (0, s.createElement)("p", {
            className: "alcb__label"
          }, (0, a.__)("Background", "n3-logo-carousel-block")), (0, s.createElement)(Te.ColorPalette, {
            colors: xe,
            value: $,
            onChange: function onChange(e) {
              return n({
                captionBg: e
              });
            }
          }))), (0, s.createElement)(Te.PanelBody, {
            title: (0, a.__)("Logo Style", "n3-logo-carousel-block"),
            initialOpen: !1
          }, (0, s.createElement)(Te.SelectControl, {
            label: (0, a.__)("Logo Hover Style", "n3-logo-carousel-block"),
            value: I,
            options: [{
              label: (0, a.__)("None", "n3-logo-carousel-block"),
              value: "none"
            }, {
              label: (0, a.__)("GrayScale", "n3-logo-carousel-block"),
              value: "normal_to_gray"
            }, {
              label: (0, a.__)("Zoom In", "n3-logo-carousel-block"),
              value: "zoom_in"
            }, {
              label: (0, a.__)("Zoom Out", "n3-logo-carousel-block"),
              value: "zoom_out"
            }],
            onChange: function onChange(e) {
              n({
                logoHoverStyle: e
              });
            }
          }), (0, s.createElement)(Te.__experimentalUnitControl, {
            label: (0, a.__)("Border Width", "n3-logo-carousel-block"),
            units: [],
            onChange: function onChange(e) {
              return n({
                borderWidth: e
              });
            },
            value: L,
            min: 0
          }), (0, s.createElement)("br", null), "0px" !== L && (0, s.createElement)(_e, null, (0, s.createElement)(Te.SelectControl, {
            label: (0, a.__)("Border Style", "n3-logo-carousel-block"),
            value: N,
            options: [{
              label: (0, a.__)("Solid", "n3-logo-carousel-block"),
              value: "solid"
            }, {
              label: (0, a.__)("Dotted", "n3-logo-carousel-block"),
              value: "dotted"
            }, {
              label: (0, a.__)("Dashed", "n3-logo-carousel-block"),
              value: "dashed"
            }, {
              label: (0, a.__)("Double", "n3-logo-carousel-block"),
              value: "double"
            }],
            onChange: function onChange(e) {
              n({
                borderStyle: e
              });
            }
          }), (0, s.createElement)("p", {
            className: "alcb__label"
          }, (0, a.__)("Border Color", "n3-logo-carousel-block")), (0, s.createElement)(Te.ColorPalette, {
            colors: xe,
            value: D,
            onChange: function onChange(e) {
              return n({
                borderColor: e
              });
            }
          })), (0, s.createElement)(Te.RangeControl, {
            label: (0, a.__)("Border Radius", "n3-logo-carousel-block"),
            value: A,
            onChange: function onChange(e) {
              return n({
                borderRadius: e
              });
            },
            min: 0,
            max: 50
          }))), (0, s.createElement)("div", (0, Se.useBlockProps)({
            className: w ? "alcb__active_pagination" : ""
          }), (0, s.createElement)(ye, {
            modules: [se, ne, ie, Q, ee],
            spaceBetween: x,
            slidesPerView: C,
            navigation: b,
            pagination: !!w && {
              clickable: !0
            },
            loop: o,
            dir: v,
            autoplay: !!c && {
              delay: u,
              disableOnInteraction: !1,
              reverseDirection: !!p,
              pauseOnMouseEnter: !!m
            },
            speed: d,
            autoHeight: g,
            keyboard: !!h && {
              enabled: !0
            },
            mousewheel: f
          }, l ? l.map(function (e) {
            return (0, s.createElement)(Ee, null, (0, s.createElement)("div", {
              className: "alcb__logo-item",
              style: {
                border: " ".concat(L, " ").concat(N, " ").concat(D),
                borderRadius: "".concat(A, "px")
              }
            }, (0, s.createElement)("div", {
              className: "alcb__logo-image  alcb__".concat(I)
            }, (0, s.createElement)("img", {
              src: e.url,
              alt: e.alt,
              id: e.id
            })), P && (0, s.createElement)("div", {
              className: "alcb__logo-caption ".concat(M),
              style: {
                color: O,
                backgroundColor: $
              }
            }, e.caption ? e.caption : (0, a.__)("No Caption Available", "n3-logo-carousel-block"))));
          }) : (0, s.createElement)(Se.MediaPlaceholder, {
            multiple: !0,
            onSelect: function onSelect(e) {
              return n({
                images: e
              });
            },
            onFilesPreUpload: function onFilesPreUpload(e) {
              return n({
                images: e
              });
            },
            onSelectURL: !1,
            allowedTypes: ["image"],
            labels: {
              title: (0, a.__)("Add Logos", "n3-logo-carousel-block")
            }
          }))));
        },
        save: function save(e) {
          var t = e.attributes;
          var n = t.sliderId,
              i = t.images,
              r = t.loop,
              l = t.speed,
              o = t.autoplay,
              d = t.reverseAutoplayDirection,
              c = t.autoplayDelay,
              p = t.pauseOnHover,
              u = t.keyboard,
              m = t.mousewheel,
              h = t.autoHeight,
              f = t.slideDirection,
              g = t.showNav,
              v = t.showPagination,
              b = t.deskItemsPerView,
              w = t.tabItemsPerView,
              y = t.phoneItemsPerView,
              C = t.deskSpace,
              E = t.tabSpace,
              S = t.phoneSpace,
              T = t.showCaption,
              x = t.captionVisibility,
              k = t.captionBg,
              _ = t.captionColor,
              P = t.borderWidth,
              M = t.borderColor,
              $ = t.borderStyle,
              O = t.borderRadius,
              L = t.logoHoverStyle;
          return (0, s.createElement)("div", Se.useBlockProps.save({
            className: v ? "alcb__active_pagination" : ""
          }), (0, s.createElement)("div", {
            dir: f,
            className: "alcb__carousel_container swiper",
            "data-desktop": b,
            "data-tablet": w,
            "data-mobile": y,
            "data-autoplay": o,
            "data-autoplayDelay": c,
            "data-autoplayDirection": d,
            "data-speed": l,
            "data-loop": r,
            "data-pauseonhover": p,
            "data-keyboard": u,
            "data-mousewheel": m,
            "data-autoheight": h,
            "data-deskSpace": C,
            "data-tabSpace": E,
            "data-phoneSpace": S,
            "data-id": n,
            "data-pagination": v,
            "data-navigation": g,
            id: n
          }, (0, s.createElement)("div", {
            className: "swiper-wrapper"
          }, i && i.map(function (e) {
            return (0, s.createElement)("div", {
              className: "swiper-slide alcb__logo-item",
              style: {
                border: " ".concat(P, " ").concat($, " ").concat(M),
                borderRadius: "".concat(O, "px")
              },
              key: e.id
            }, (0, s.createElement)("div", {
              className: "alcb__logo-image  alcb__".concat(L)
            }, (0, s.createElement)("img", {
              src: e.url,
              alt: e.alt,
              id: e.id
            })), T && (0, s.createElement)("div", {
              className: "alcb__logo-caption ".concat(x),
              style: {
                color: _,
                backgroundColor: k
              }
            }, e.caption ? e.caption : (0, a.__)("No Caption Available", "n3-logo-carousel-block")));
          }))), v && (0, s.createElement)("div", {
            className: "alcb__pag swiper-pagination"
          }), g && (0, s.createElement)("div", {
            className: "navigation"
          }, (0, s.createElement)("div", {
            className: "alcb__prev swiper-button-prev"
          }), (0, s.createElement)("div", {
            className: "alcb__next swiper-button-next"
          })));
        }
      });
    }
  },
      s = {};

  function a(e) {
    var n = s[e];
    if (void 0 !== n) return n.exports;
    var i = s[e] = {
      exports: {}
    };
    return t[e](i, i.exports, a), i.exports;
  }

  a.m = t, e = [], a.O = function (t, s, n, i) {
    if (!s) {
      var r = 1 / 0;

      for (c = 0; c < e.length; c++) {
        s = e[c][0], n = e[c][1], i = e[c][2];

        for (var l = !0, o = 0; o < s.length; o++) {
          (!1 & i || r >= i) && Object.keys(a.O).every(function (e) {
            return a.O[e](s[o]);
          }) ? s.splice(o--, 1) : (l = !1, i < r && (r = i));
        }

        if (l) {
          e.splice(c--, 1);
          var d = n();
          void 0 !== d && (t = d);
        }
      }

      return t;
    }

    i = i || 0;

    for (var c = e.length; c > 0 && e[c - 1][2] > i; c--) {
      e[c] = e[c - 1];
    }

    e[c] = [s, n, i];
  }, a.o = function (e, t) {
    return Object.prototype.hasOwnProperty.call(e, t);
  }, function () {
    var e = {
      670: 0,
      448: 0
    };

    a.O.j = function (t) {
      return 0 === e[t];
    };

    var t = function t(_t34, s) {
      var n,
          i,
          r = s[0],
          l = s[1],
          o = s[2],
          d = 0;

      if (r.some(function (t) {
        return 0 !== e[t];
      })) {
        for (n in l) {
          a.o(l, n) && (a.m[n] = l[n]);
        }

        if (o) var c = o(a);
      }

      for (_t34 && _t34(s); d < r.length; d++) {
        i = r[d], a.o(e, i) && e[i] && e[i][0](), e[i] = 0;
      }

      return a.O(c);
    },
        s = self.webpackChunklogo_carousel = self.webpackChunklogo_carousel || [];

    s.forEach(t.bind(null, 0)), s.push = t.bind(null, s.push.bind(s));
  }();
  var n = a.O(void 0, [448], function () {
    return a(550);
  });
  n = a.O(n);
}();