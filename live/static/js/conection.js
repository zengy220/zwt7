!window.qcVideo && function(global) {
        function getMappingArgs(fn) {
            var args = fn.toString().split("{")[0].replace(/\s|function|\(|\)/g, "").split(","),
                i = 0;
            for (args[0] || (args = []); args[i];) args[i] = require(args[i]), i += 1;
            return args
        }

        function newInst(key, ifExist) {
            (ifExist ? ns.instances[key] : !ns.instances[key]) && ns.modules[key] && (ns.instances[key] = ns.modules[key].apply(window, getMappingArgs(ns.modules[key])))
        }

        function require(key) { return newInst(key, !1), ns.instances[key] || {} }

        function loadJs(url, onLoadCB, onErrorCB) {
            var el = document.createElement("script");
            el.setAttribute("type", "text/javascript"), el.setAttribute("src", url), el.setAttribute("async", !0), onLoadCB && (el.onload = onLoadCB), onErrorCB && (el.onerror = onErrorCB), document.getElementsByTagName("head")[0].appendChild(el)
        }

        function core(key, target) {
            if (!ns.modules[key] && (ns.modules[key] = target, newInst(key, !0), waiter[key])) {
                for (var i = 0; waiter[key][i];) waiter[key][i](require(key)), i += 1;
                delete waiter[key]
            }
        }
        var ns = { modules: {}, instances: {} },
            waiter = {};
        core.use = function(key, cb) {
            if (cb = cb || function() {}, ns.modules[key]) cb(require(key));
            else {
                var config = require("config");
                config[key] && (waiter[key] || (waiter[key] = [], loadJs(config[key])), waiter[key].push(cb))
            }
        }, core.get = function(key) { return require(key) }, core.loadJs = loadJs, global.qcVideo = core
    }(window), qcVideo("Base", function(util) {
        var unique = "base_" + +new Date,
            global = window,
            uuid = 1,
            Base = function() {},
            debug = !0,
            realConsole = global.console,
            console = realConsole || {},
            wrap = function(fn) { return function() { if (debug) try { fn.apply(realConsole, [this.__get_class_info__()].concat(arguments)) } catch (xe) {} } };
        Base.prototype.__get_class_info__ = function() { var now = new Date; return now.getHours() + ":" + now.getMinutes() + ":" + now.getSeconds() + ">" + (this.className || "BASE") + ">" }, Base.setDebug = function(open) { debug = !!open }, Base.filter_error = function(fn, name) { return "function" != util.type(fn) ? fn : function() { try { return fn.apply(this, arguments) } catch (xe) { var rep = qcVideo.get("BJ_REPORT"); throw rep && rep.push && (xe.stack && (xe.stack = (this.className || "") + "-" + (name || "constructor") + " " + xe.stack), rep.push(xe)), new Error(xe.message || "") } } }, Base.prototype.loop = Base.loop = function() {}, Base.extend = function(protoProps, staticProps) {
            protoProps = protoProps || {};
            var constructor = protoProps.hasOwnProperty("constructor") ? protoProps.constructor : function() { return sup.apply(this, arguments) };
            constructor = Base.filter_error(constructor);
            var kk, sup = this,
                Fn = function() { this.constructor = constructor };
            if (protoProps)
                for (kk in protoProps) protoProps[kk] = Base.filter_error(protoProps[kk], kk);
            return Fn.prototype = sup.prototype, constructor.prototype = new Fn, util.merge(constructor.prototype, protoProps), util.merge(constructor, sup, !0), util.merge(constructor, staticProps), util.merge(constructor, { __super__: sup.prototype }), constructor
        }, Base.prototype.log = wrap(console.log || Base.loop), Base.prototype.debug = wrap(console.debug || Base.loop), Base.prototype.error = wrap(console.error || Base.loop), Base.prototype.info = wrap(console.info || Base.loop);
        var eventCache = {},
            getUniqueId = function() { return this.__id || (this.__id = unique + ++uuid) },
            initEvent = function(ctx, event) {
                var id = getUniqueId.call(ctx);
                eventCache.hasOwnProperty(id) || (eventCache[id] = {}), event && (eventCache[id][event] || (eventCache[id][event] = []))
            };
        return Base.prototype.on = function(ctx, event, fn) { initEvent(ctx, event), eventCache[getUniqueId.call(ctx)][event].push(fn) }, Base.prototype.batchOn = function(ctx, ary) { for (var i = 0, j = ary.length; j > i; i++) this.on(ctx, ary[i].event, ary[i].fn) }, Base.prototype.fire = function(event, opt) {
            var cache = eventCache[getUniqueId.call(this)];
            cache && cache[event] && util.each(cache[event], function(fn) { fn.call(global, opt) })
        }, Base.prototype.off = function(ctx, event, fn) {
            initEvent(ctx);
            var find = -1,
                list = eventCache[getUniqueId.call(ctx)][event];
            util.each(list, function(handler, index) { return handler === fn ? (find = index, !1) : void 0 }), -1 !== find && list.splice(find, 1)
        }, Base.instance = function(opt, staticOpt) { return new(Base.extend(opt, staticOpt)) }, Base
    }), qcVideo("tlsPwd", function() {
        function Now() { return +new Date }

        function addTlsScript() {
            var a = document.createElement("script");
            a.src = "https://tls.qcloud.com/libs/encrypt.min.js", document.body.insertBefore(a, document.body.childNodes[0])
        }

        function getSigPwd() { try { return Encrypt.getRSAH1() } catch (e) {} return "" }

        function fetchSigPwd(cb, start) {
            var now = Now();
            if (start) getSigPwdStartTime = now, addTlsScript();
            else if (now - getSigPwdStartTime > 5e3) return void cb(null, "timeout");
            var pwd = getSigPwd();
            pwd && pwd.length > 0 ? cb(pwd) : setTimeout(function() { fetchSigPwd(cb) }, 1e3)
        }
        var getSigPwdStartTime;
        return function(cb) { fetchSigPwd(function(pwd) { cb(pwd) }, !0) }
    }), qcVideo("touristTlsLogin", function(tlsPwd) {
        function askJsonp(src) {
            var a = document.createElement("script");
            a.src = src, document.body.insertBefore(a, document.body.childNodes[0])
        }

        function tlsGetUserSig_JsonPCallback(info) {
            info = info || {};
            var ErrorCode = info.ErrorCode;
            clear_jsonP(), 0 == ErrorCode ? (_info.userSig = info.UserSig, _info.done(_info)) : _info.done(null, ErrorCode)
        }

        function clear_jsonP() { global.tlsAnoLogin = null, global.tlsGetUserSig = null }

        function tlsAnoLogin_JsonPCallback(info) {
            info = info || {};
            var ErrorCode = info.ErrorCode;
            0 == ErrorCode ? (_info.identifier = info.Identifier, _info.TmpSig = info.TmpSig, global.tlsGetUserSig = tlsGetUserSig_JsonPCallback, askJsonp("https://tls.qcloud.com/getusersig?tmpsig=" + _info.TmpSig + "&identifier=" + encodeURIComponent(_info.identifier) + "&accounttype=" + _info.accountType + "&sdkappid=" + _info.sdkAppID)) : (clear_jsonP(), _info.done(null, ErrorCode))
        }
        var global = window,
            _info = {};
        return function(sdkappid, accounttype, cb) { _info = { sdkAppID: sdkappid, appIDAt3rd: sdkappid, accountType: accounttype, identifier: "", userSig: "", done: cb }, clear_jsonP(), tlsPwd(function(pwd, error) { error && _info.done(null, error), askJsonp("https://tls.qcloud.com/anologin?sdkappid=" + _info.sdkAppID + "&accounttype=" + _info.accountType + "&url=&passwd=" + pwd), global.tlsAnoLogin = tlsAnoLogin_JsonPCallback }) }
    }), qcVideo("api", function() {
        var now = function() { return +new Date },
            uuid = 0,
            global = window,
            unique = "qcvideo_" + now(),
            overTime = 1e4,
            request = function(address, cbName, cb) { return function() { global[cbName] = function(data) { cb(data), delete global[cbName] }, setTimeout(function() { "undefined" != typeof global[cbName] && (delete global[cbName], cb({ retcode: 1e4, errmsg: "请求超时" })) }, overTime), qcVideo.loadJs(address + (address.indexOf("?") > 0 ? "&" : "?") + "callback=" + cbName, function(e) { "undefined" != typeof global[cbName] && (delete global[cbName], cb({ retcode: 10001, errmsg: "" })) }, function(e) { "undefined" != typeof global[cbName] && (delete global[cbName], cb({ retcode: 10002, errmsg: "" })) }) } },
            hiSender = function() { var img = new Image; return function(src) { img.onload = img.onerror = img.onabort = function() { img.onload = img.onerror = img.onabort = null, img = null }, img.src = src } },
            apdTime = function(url) { return url + (url.indexOf("?") > 0 ? "&" : "?") + "_=" + now() };
        return {
            request: function(address, cb) {
                var cbName = unique + "_callback" + ++uuid;
                request(apdTime(address), cbName, cb)()
            },
            report: function(address) { hiSender()(apdTime(address)) }
        }
    }), qcVideo("BJ_REPORT", function() {
        return function(global) {
            if (global.BJ_REPORT) return global.BJ_REPORT;
            var _error = [],
                _config = { id: 0, uin: 0, url: "", combo: 1, ext: {}, level: 4, ignore: [], random: 1, delay: 1e3, submit: null },
                _isOBJByType = function(o, type) { return Object.prototype.toString.call(o) === "[object " + (type || "Object") + "]" },
                _isOBJ = function(obj) { var type = typeof obj; return "object" === type && !!obj },
                _isEmpty = function(obj) { return null === obj ? !0 : _isOBJByType(obj, "Number") ? !1 : !obj },
                _processError = (global.onerror, function(errObj) {
                    try {
                        if (errObj.stack) {
                            var url = errObj.stack.match("https?://[^\n]+");
                            url = url ? url[0] : "";
                            var rowCols = url.match(":(\\d+):(\\d+)");
                            rowCols || (rowCols = [0, 0, 0]);
                            var stack = _processStackMsg(errObj);
                            return { msg: stack, rowNum: rowCols[1], colNum: rowCols[2], target: url.replace(rowCols[0], "") }
                        }
                        return errObj
                    } catch (err) { return errObj }
                }),
                _processStackMsg = function(error) {
                    var stack = error.stack.replace(/\n/gi, "").split(/\bat\b/).slice(0, 5).join("@").replace(/\?[^:]+/gi, ""),
                        msg = error.toString();
                    return stack.indexOf(msg) < 0 && (stack = msg + "@" + stack), stack
                },
                _error_tostring = function(error, index) {
                    var param = [],
                        params = [],
                        stringify = [];
                    if (_isOBJ(error)) {
                        error.level = error.level || _config.level;
                        for (var key in error) {
                            var value = error[key];
                            if (!_isEmpty(value)) {
                                if (_isOBJ(value)) try { value = JSON.stringify(value) } catch (err) { value = "[BJ_REPORT detect value stringify error] " + err.toString() }
                                stringify.push(key + ":" + value), param.push(key + "=" + encodeURIComponent(value)), params.push(key + "[" + index + "]=" + encodeURIComponent(value))
                            }
                        }
                    }
                    return [params.join("&"), stringify.join(","), param.join("&")]
                },
                _imgs = [],
                _submit = function(url) {
                    if (_config.submit) _config.submit(url);
                    else {
                        var _img = new Image;
                        _imgs.push(_img), _img.src = url
                    }
                },
                error_list = [],
                comboTimeout = 0,
                _send = function(isReoprtNow) {
                    if (_config.report) {
                        for (; _error.length;) {
                            var isIgnore = !1,
                                error = _error.shift(),
                                error_str = _error_tostring(error, error_list.length);
                            if (_isOBJByType(_config.ignore, "Array"))
                                for (var i = 0, l = _config.ignore.length; l > i; i++) { var rule = _config.ignore[i]; if (_isOBJByType(rule, "RegExp") && rule.test(error_str[1]) || _isOBJByType(rule, "Function") && rule(error, error_str[1])) { isIgnore = !0; break } }
                            isIgnore || (_config.combo ? error_list.push(error_str[0]) : _submit(_config.report + error_str[2] + "&_t=" + +new Date), _config.onReport && _config.onReport(_config.id, error))
                        }
                        var count = error_list.length;
                        if (count) {
                            var comboReport = function() { clearTimeout(comboTimeout), _submit(_config.report + error_list.join("&") + "&count=" + count + "&_t=" + +new Date), comboTimeout = 0, error_list = [] };
                            isReoprtNow ? comboReport() : comboTimeout || (comboTimeout = setTimeout(comboReport, _config.delay))
                        }
                    }
                },
                report = {
                    push: function(msg) { return Math.random() >= _config.random ? report : (_error.push(_isOBJ(msg) ? _processError(msg) : { msg: msg }), _send(), report) },
                    report: function(msg) { return msg && report.push(msg), _send(!0), report },
                    info: function(msg) { return msg ? (_isOBJ(msg) ? msg.level = 2 : msg = { msg: msg, level: 2 }, report.push(msg), report) : report },
                    debug: function(msg) { return msg ? (_isOBJ(msg) ? msg.level = 1 : msg = { msg: msg, level: 1 }, report.push(msg), report) : report },
                    init: function(config) {
                        if (_isOBJ(config))
                            for (var key in config) _config[key] = config[key];
                        var id = parseInt(_config.id, 10);
                        return id && (_config.report = (_config.url || "//badjs2.qq.com/badjs") + "?id=" + id + "&uin=" + parseInt(_config.uin || (document.cookie.match(/\buin=\D+(\d+)/) || [])[1], 10) + "&from=" + encodeURIComponent(location.href) + "&ext=" + JSON.stringify(_config.ext) + "&"), report
                    },
                    __onerror__: global.onerror
                };
            return "undefined" != typeof console && console.error && setTimeout(function() {
                var err = ((location.hash || "").match(/([#&])BJ_ERROR=([^&$]+)/) || [])[2];
                err && console.error("BJ_ERROR", decodeURIComponent(err).replace(/(:\d+:\d+)\s*/g, "$1\n"))
            }, 0), report
        }(window)
    }), qcVideo("codeReport", function(api, version) {
        function report(domain, cgi, type, code, time) {
            var obj = { domain: domain, cgi: cgi, type: type, code: code, time: time, appid: 20182, platform: version.IOS ? "ios" : version.ANDROID ? "android" : "pc", expansion1: "h5", expansion2: from },
                params = "";
            for (var k in obj) params += k + "=", params += encodeURIComponent(obj[k]), params += "&";
            params = params.substr(0, params.length - 1), api.report(("https:" == location.protocol ? REPORT_URL_HTTPS : REPORT_URL) + "?" + params)
        }
        var now = function() { return +(new Date).getTime() },
            REPORT_URL = "//report.huatuo.qq.com/code.cgi",
            REPORT_URL_HTTPS = "//report.huatuo.qq.com/code.cgi",
            url = "",
            cgiStartPoint = 0,
            cgiEndPoint = 0,
            from = "";
        return { reportStart: function(_url, _from) { cgiStartPoint = now(), url = _url, from = _from }, reportEnd: function(type, code) { cgiEndPoint = now(), url = url.substring(url.indexOf(":") + 3, url.indexOf("?")), report(url.substring(0, url.indexOf("/")), url.substring(url.indexOf("/"), url.length), type, code, cgiEndPoint - cgiStartPoint) }, reportParams: function(params) { api.report(("https:" == location.protocol ? REPORT_URL_HTTPS : REPORT_URL) + "?" + params) } }
    }), qcVideo("css", function() {
        var css = {};
        return document.defaultView && document.defaultView.getComputedStyle ? css.getComputedStyle = function(a, b) { var c, d, e; return b = b.replace(/([A-Z]|^ms)/g, "-$1").toLowerCase(), (d = a.ownerDocument.defaultView) && (e = d.getComputedStyle(a, null)) && (c = e.getPropertyValue(b)), c } : document.documentElement.currentStyle && (css.getComputedStyle = function(a, b) {
            var c, d = a.currentStyle && a.currentStyle[b],
                e = a.style;
            return null === d && e && (c = e[b]) && (d = c), d
        }), {
            getWidth: function(e) { return 0 | (css.getComputedStyle(e, "width") || "").toLowerCase().replace("px", "") },
            getHeight: function(e) { return 0 | (css.getComputedStyle(e, "height") || "").toLowerCase().replace("px", "") },
            textAlign: function(e) { e.style["text-align"] = "center" },
            getVisibleHeight: function() {
                var doc = document,
                    docE = doc.documentElement,
                    body = doc.body;
                return docE && docE.clientHeight || body && body.offsetHeight || window.innerHeight || 0
            },
            getVisibleWidth: function() {
                var doc = document,
                    docE = doc.documentElement,
                    body = doc.body;
                return docE && docE.clientWidth || body && body.offsetWidth || window.innerWidth || 0
            }
        }
    }), qcVideo("interval", function() {
        function each(cb) {
            for (var key in stack)
                if (!1 === cb.call(stack[key])) return
        }

        function tick() {
            var now = +new Date;
            each(function() { var me = this;!me.__time && (me.__time = now), me.__time + me._ftp <= now && 1 === me.status && (me.__time = now, me._cb.call()) })
        }

        function stop() {
            var start = 0;
            each(function() { 1 === this.status && (start += 1) }), 0 !== start && 0 !== length || (clearInterval(git), git = null)
        }

        function _start() { this.status = 1, !git && (git = setInterval(tick, gTime)) }

        function _pause() { this.status = 0, this.__time = +new Date, stop() }

        function _clear() { delete stack[this._id], length -= 1, stop() }
        var git, stack = {},
            length = 0,
            gTime = 16,
            uuid = 0;
        return function(callback, time) { return length += 1, uuid += 1, stack[uuid] = { _id: uuid, _cb: callback, _ftp: time || gTime, start: _start, pause: _pause, clear: _clear } }
    }), "object" != typeof JSON && (JSON = {}),
    function() {
        "use strict";

        function f(n) { return 10 > n ? "0" + n : n }

        function quote(string) { return escapable.lastIndex = 0, escapable.test(string) ? '"' + string.replace(escapable, function(a) { var c = meta[a]; return "string" == typeof c ? c : "\\u" + ("0000" + a.charCodeAt(0).toString(16)).slice(-4) }) + '"' : '"' + string + '"' }

        function str(key, holder) {
            var i, k, v, length, partial, mind = gap,
                value = holder[key];
            switch (value && "object" == typeof value && "function" == typeof value.toJSON && (value = value.toJSON(key)), "function" == typeof rep && (value = rep.call(holder, key, value)), typeof value) {
                case "string":
                    return quote(value);
                case "number":
                    return isFinite(value) ? String(value) : "null";
                case "boolean":
                case "null":
                    return String(value);
                case "object":
                    if (!value) return "null";
                    if (gap += indent, partial = [], "[object Array]" === Object.prototype.toString.apply(value)) { for (length = value.length, i = 0; length > i; i += 1) partial[i] = str(i, value) || "null"; return v = 0 === partial.length ? "[]" : gap ? "[\n" + gap + partial.join(",\n" + gap) + "\n" + mind + "]" : "[" + partial.join(",") + "]", gap = mind, v }
                    if (rep && "object" == typeof rep)
                        for (length = rep.length, i = 0; length > i; i += 1) "string" == typeof rep[i] && (k = rep[i], v = str(k, value), v && partial.push(quote(k) + (gap ? ": " : ":") + v));
                    else
                        for (k in value) Object.prototype.hasOwnProperty.call(value, k) && (v = str(k, value), v && partial.push(quote(k) + (gap ? ": " : ":") + v));
                    return v = 0 === partial.length ? "{}" : gap ? "{\n" + gap + partial.join(",\n" + gap) + "\n" + mind + "}" : "{" + partial.join(",") + "}", gap = mind, v
            }
        }
        "function" != typeof Date.prototype.toJSON && (Date.prototype.toJSON = function() { return isFinite(this.valueOf()) ? this.getUTCFullYear() + "-" + f(this.getUTCMonth() + 1) + "-" + f(this.getUTCDate()) + "T" + f(this.getUTCHours()) + ":" + f(this.getUTCMinutes()) + ":" + f(this.getUTCSeconds()) + "Z" : null }, String.prototype.toJSON = Number.prototype.toJSON = Boolean.prototype.toJSON = function() { return this.valueOf() });
        var cx, escapable, gap, indent, meta, rep;
        "function" != typeof JSON.stringify && (escapable = /[\\\"\x00-\x1f\x7f-\x9f\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g, meta = { "\b": "\\b", "	": "\\t", "\n": "\\n", "\f": "\\f", "\r": "\\r", '"': '\\"', "\\": "\\\\" }, JSON.stringify = function(value, replacer, space) {
            var i;
            if (gap = "", indent = "", "number" == typeof space)
                for (i = 0; space > i; i += 1) indent += " ";
            else "string" == typeof space && (indent = space);
            if (rep = replacer, replacer && "function" != typeof replacer && ("object" != typeof replacer || "number" != typeof replacer.length)) throw new Error("JSON.stringify");
            return str("", { "": value })
        }), "function" != typeof JSON.parse && (cx = /[\u0000\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g, JSON.parse = function(text, reviver) {
            function walk(holder, key) {
                var k, v, value = holder[key];
                if (value && "object" == typeof value)
                    for (k in value) Object.prototype.hasOwnProperty.call(value, k) && (v = walk(value, k), void 0 !== v ? value[k] = v : delete value[k]);
                return reviver.call(holder, key, value)
            }
            var j;
            if (text = String(text), cx.lastIndex = 0, cx.test(text) && (text = text.replace(cx, function(a) { return "\\u" + ("0000" + a.charCodeAt(0).toString(16)).slice(-4) })), /^[\],:{}\s]*$/.test(text.replace(/\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g, "@").replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, "]").replace(/(?:^|:|,)(?:\s*\[)+/g, ""))) return j = eval("(" + text + ")"), "function" == typeof reviver ? walk({ "": j }, "") : j;
            throw new SyntaxError("JSON.parse")
        })
    }(), qcVideo("JSON", function() { return JSON }), qcVideo("LinkIm", function(Base, touristTlsLogin) {
        return Base.extend({
            className: "LinkIm",
            checkLoginStatus: function(uniqueImVal) { var s = this.link.checkLoginBarrage(uniqueImVal); return "0" != s ? s : "uninit" },
            destroy: function() { delete this.link, delete this.im },
            constructor: function(link, im, uniqueImVal, done, fail) {
                var self = this;
                self.link = link, self.im = im;
                var roll = function() { var status = self.checkLoginStatus(uniqueImVal); "uninit" == status ? setTimeout(roll, 1e3) : "fail" == status ? touristTlsLogin(self.im.sdkAppID, self.im.accountType, function(info, error) { error ? fail && fail("tlsLogin:" + error) : (info.groupId = self.im.groupId, info.nickName = self.im.nickName, info.appId = uniqueImVal, delete info.done, delete info.TmpSig, self.link.loginBarrage(info), done && done()) }) : (self.link.loginBarrage({ appId: uniqueImVal, groupId: self.im.groupId, nickName: self.im.nickName }), done && done()) };
                roll()
            }
        })
    }), qcVideo("lStore", function() {
        function getStorage() { return storage ? storage : (storage = doc.body.appendChild(doc.createElement("div")), storage.style.display = "none", storage.setAttribute("data-store-js", ""), storage.addBehavior("#default#userData"), storage.load(localStorageName), storage) }
        var storage, get, set, remove, clear, win = window,
            doc = win.document,
            localStorageName = "localStorage",
            globalStorageName = "globalStorage",
            key_prefix = "qc_video_love_",
            ok = !1;
        set = get = remove = clear = function() {};
        try { localStorageName in win && win[localStorageName] && (storage = win[localStorageName], set = function(key, val) { storage.setItem(key, val) }, get = function(key) { return storage.getItem(key) }, remove = function(key) { storage.removeItem(key) }, clear = function() { storage.clear() }, ok = !0) } catch (e) {}
        try {!ok && globalStorageName in win && win[globalStorageName] && (storage = win[globalStorageName][win.location.hostname], set = function(key, val) { storage[key] = val }, get = function(key) { return storage[key] && storage[key].value }, remove = function(key) { delete storage[key] }, clear = function() { for (var key in storage) delete storage[key] }, ok = !0) } catch (e) {}
        return !ok && doc.documentElement.addBehavior && (set = function(key, val) {
            try {
                var storage = getStorage();
                storage.setAttribute(key, val), storage.save(localStorageName)
            } catch (e) {}
        }, get = function(key) { try { var storage = getStorage(); return storage.getAttribute(key) } catch (e) { return "" } }, remove = function(key) {
            try {
                var storage = getStorage();
                storage.removeAttribute(key), storage.save(localStorageName)
            } catch (e) {}
        }, clear = function() {
            try {
                var storage = getStorage(),
                    attributes = storage.XMLDocument.documentElement.attributes;
                storage.load(localStorageName);
                for (var attr, i = 0; attr = attributes[i]; i++) storage.removeAttribute(attr.name);
                storage.save(localStorageName)
            } catch (e) {}
        }), { get: function(key) { return get(key_prefix + key) }, set: function(key, val) { set(key_prefix + key, val) }, remove: function(key) { remove(key_prefix + key) }, clear: clear }
    }), qcVideo("util", function() {
        var util = {
                paramsToObject: function(link) {
                    var pairs, pair, query, key, value, result = {};
                    query = link || "", query = query.replace("?", ""), pairs = query.split("&");
                    for (var i = 0, j = pairs.length; j > i; i++) {
                        var keyVal = pairs[i];
                        pair = keyVal.split("="), key = pair[0], value = pair.slice(1).join("="), result[decodeURIComponent(key)] = decodeURIComponent(value)
                    }
                    return result
                },
                each: function(opt, cb) {
                    var i, j, key = 0;
                    if (this.isArray(opt))
                        for (i = 0, j = opt.length; j > i && !1 !== cb.call(opt[i], opt[i], i); i++);
                    else if (this.isPlainObject(opt))
                        for (key in opt)
                            if (!1 === cb.call(opt[key], opt[key], key)) break
                }
            },
            toString = Object.prototype.toString,
            hasOwn = Object.prototype.hasOwnProperty,
            class2type = { "[object Boolean]": "boolean", "[object Number]": "number", "[object String]": "string", "[object Function]": "function", "[object Array]": "array", "[object Date]": "date", "[object RegExp]": "regExp", "[object Object]": "object" },
            isWindow = function(obj) { return obj && "object" == typeof obj && "setInterval" in obj };
        return util.type = function(obj) { return null == obj ? String(obj) : class2type[toString.call(obj)] || "object" }, util.isArray = Array.isArray || function(obj) { return "array" === util.type(obj) }, util.isPlainObject = function(obj) { if (!obj || "object" !== util.type(obj) || obj.nodeType || isWindow(obj)) return !1; if (obj.constructor && !hasOwn.call(obj, "constructor") && !hasOwn.call(obj.constructor.prototype, "isPrototypeOf")) return !1; var key; for (key in obj); return void 0 === key || hasOwn.call(obj, key) }, util.merge = function(tar, sou, deep) { var name, src, copy, clone, copyIsArray; for (name in sou) src = tar[name], copy = sou[name], tar !== copy && (deep && copy && (util.isPlainObject(copy) || (copyIsArray = util.isArray(copy))) ? (copyIsArray ? (copyIsArray = !1, clone = src && util.isArray(src) ? src : []) : clone = src && util.isPlainObject(src) ? src : {}, tar[name] = util.merge(clone, copy, deep)) : void 0 !== copy && (tar[name] = copy)); return tar }, util.capitalize = function(str) { return str = str || "", str.charAt(0).toUpperCase() + str.slice(1) }, util.convertTime = function(s) {
            s = 0 | s;
            var h = 3600,
                m = 60,
                hours = s / h | 0,
                minutes = (s - hours * h) / m | 0,
                sec = s - hours * h - minutes * m;
            return hours = hours > 0 ? hours + ":" : "", minutes = minutes > 0 ? minutes + ":" : "00:", sec = sec > 0 ? sec + "" : hours.length > 0 || minutes.length > 0 ? "00" : "00:00:00", hours = 2 == hours.length ? "0" + hours : hours, minutes = 2 == minutes.length ? "0" + minutes : minutes, sec = 1 == sec.length ? "0" + sec : sec, hours + minutes + sec
        }, util.fix2 = function(num) { return num.toFixed(2) - 0 }, util.fileType = function(src) { return src.indexOf(".mp4") > 0 ? "mp4" : src.indexOf(".m3u8") > 0 ? "hls" : void 0 }, util.loadImg = function(url, ready) { var onReady, width, height, newWidth, newHeight, img = new Image; return img.src = url, img.complete ? void ready.call(img) : (width = img.width, height = img.height, img.onerror = function() { onReady.end = !0, img = img.onload = img.onerror = null }, onReady = function() { newWidth = img.width, newHeight = img.height, (newWidth !== width || newHeight !== height || newWidth * newHeight > 1024) && (ready.call(img), onReady.end = !0) }, onReady(), void(img.onload = function() {!onReady.end && onReady(), img = img.onload = img.onerror = null })) }, util.resize = function(max, sou) { var sRate = sou.width / sou.height; return max.width < sou.width && (sou.width = max.width, sou.height = sou.width / sRate), max.height < sou.height && (sou.height = max.height, sou.width = sou.height * sRate), sou }, util.toKeyValue = function(obj) { var retString = ""; for (var k in obj) retString += k + "=", retString += encodeURIComponent(obj[k]), retString += "&"; return retString.length > 0 && (retString = retString.substr(0, retString.length - 1)), retString }, util
    }), qcVideo("version", function() {
        var agent = navigator.userAgent,
            v = { IOS: !!agent.match(/iP(od|hone|ad)/i), ANDROID: !!/Android/i.test(agent) },
            dom = document.createElement("video"),
            h5Able = { probably: 1, maybe: 1 };
        // IOS 下
        dom = dom.canPlayType ? dom : null,
            v.IS_MAC = window.navigator && navigator.appVersion && navigator.appVersion.indexOf("Mac") > -1,
            v.ABLE_H5_MP4 = dom && dom.canPlayType("video/mp4") in h5Able,
            v.ABLE_H5_WEBM = dom && dom.canPlayType("video/webm") in h5Able,
            v.ABLE_H5_HLS = dom && dom.canPlayType("application/x-mpegURL") in h5Able,
            v.IS_MOBILE = v.IOS || v.ANDROID,
            v.ABLE_H5_APPLE_HLS = dom && dom.canPlayType("application/vnd.apple.mpegURL") in h5Able,
            v.FLASH_VERSION = -1,
            v.IS_IE = "ActiveXObject" in window,
            v.ABLE_FLASH = function() {
                var swf;
                if (document.all)
                    try {
                        if (swf = new ActiveXObject("ShockwaveFlash.ShockwaveFlash"))
                            return v.FLASH_VERSION = parseInt(swf.GetVariable("$version").split(" ")[1].split(",")[0]), !0
                    } catch (e) {
                        return !1
                    } else try {
                        if (navigator.plugins && navigator.plugins.length > 0 && (swf = navigator.plugins["Shockwave Flash"])) {
                            for (var words = swf.description.split(" "), i = 0; i < words.length; ++i)
                                isNaN(parseInt(words[i])) || (v.FLASH_VERSION = parseInt(words[i]));
                            return !0
                        }
                    } catch (e) { return !1 }
                return !1
            }(),
            v.getFlashAble = function() {
                return v.ABLE_FLASH ? v.FLASH_VERSION <= 10 ? "lowVersion" : "able" : ""
            };
        var ableHlsJs = !(!window.MediaSource || !window.MediaSource.isTypeSupported('video/mp4; codecs="avc1.42E01E,mp4a.40.2"')),
            forceCheckHLS = function() {
                return !!(v.ANDROID && !v.ABLE_H5_HLS && agent.substr(agent.indexOf("Android") + 8, 1) >= 4)
            };
        return v.REQUIRE_HLS_JS = ableHlsJs && !v.ABLE_H5_HLS && !v.ABLE_H5_APPLE_HLS,
            v.getLivePriority = function() {
                return v.IOS || v.ANDROID ? (forceCheckHLS() && (v.ABLE_H5_HLS = !0), "h5") : !v.ABLE_FLASH && v.ABLE_H5_MP4 ? "h5" : v.ABLE_FLASH ? "flash" : v.ABLE_H5_MP4 ? "h5" : ""
            },
            v.getVodPriority = function(inWhiteAppId) { return v.IOS || v.ANDROID ? "h5" : !v.ABLE_FLASH && v.ABLE_H5_MP4 ? "h5" : v.ABLE_FLASH ? "flash" : v.ABLE_H5_MP4 ? "h5" : "" },
            v.PROTOCOL = function() { try { var href = window.location.href; if (0 === href.indexOf("https")) return "https" } catch (xe) {} return "http" }(),
            v
    }), qcVideo("vodReporter", function(api, util) {
        function uuid(len, radix) {
            var i, chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz".split(""),
                uuid = [];
            if (radix = radix || chars.length, len)
                for (i = 0; len > i; i++) uuid[i] = chars[0 | Math.random() * radix];
            else { var r; for (uuid[8] = uuid[13] = uuid[18] = uuid[23] = "-", uuid[14] = "4", i = 0; 36 > i; i++) uuid[i] || (r = 0 | 16 * Math.random(), uuid[i] = chars[19 == i ? 3 & r | 8 : r]) }
            return uuid.join("")
        }

        function getPlatform() {
            var platform = "",
                exployer = "",
                UA = window.navigator.userAgent,
                isIE = detectIE();
            return UA ? (UA.indexOf("Android") > -1 ? platform = "android" : /iPhone|iPad|iPod/.test(UA) ? platform = "ios" : UA.indexOf("Mac") > -1 ? platform = "mac" : UA.indexOf("Windows") > -1 && (platform = "windows"), isIE ? exployer = isIE : UA.indexOf("Firefox") >= 0 ? exployer = "firefox" : UA.indexOf("Chrome") >= 0 ? exployer = "chrome" : UA.indexOf("Opera") >= 0 ? exployer = "opera" : UA.indexOf("Safari") >= 0 && (exployer = "safari")) : (platform = "unknown", exployer = "unknown"), { platform: platform, exployer: exployer }
        }

        function detectIE() {
            var ua = window.navigator.userAgent,
                msie = ua.indexOf("MSIE ");
            if (msie > 0) return parseInt(ua.substring(msie + 5, ua.indexOf(".", msie)), 10);
            var trident = ua.indexOf("Trident/");
            if (trident > 0) { var rv = ua.indexOf("rv:"); return parseInt(ua.substring(rv + 3, ua.indexOf(".", rv)), 10) }
            var edge = ua.indexOf("Edge/");
            return edge > 0 ? parseInt(ua.substring(edge + 5, ua.indexOf(".", edge)), 10) : !1
        }

        function report(params) { api.report(("https:" == location.protocol ? REPORT_URL_HTTPS : REPORT_URL) + "?" + params) }
        var REPORT_URL = "http://vodreport.qcloud.com/report.go",
            REPORT_URL_HTTPS = "https://vodreport.qcloud.com/report.go",
            seq = uuid(8, 10),
            ua = getPlatform();
        return {
            reportStart: function(_url, _from) {},
            reportEnd: function(type, code) {},
            reportParams: function(params) {
                var params = JSON.parse(params);
                params["interface"] = "Vod_Report", params.seq = seq, params.platform = ua.platform, params.exployer = ua.exployer, params.version = "1.0", report(util.toKeyValue(params))
            }
        }
    }), qcVideo("config", function(version) {
        var vod = version.PROTOCOL + "://imgcache.qq.com/open/qcloud/video/h5",
            live = version.PROTOCOL + "://imgcache.qq.com/open/qcloud/video/live",
            flash = version.PROTOCOL + "://imgcache.qq.com/open/qcloud/video/flash";
        return { $: vod + "/zepto-v1.1.3.min.js?max_age=20000000", h5css: vod + "/video.css?ver=0531&max_age=20000000", h5player: live + "/h5/h5_live_player.js", flash: flash + "/live.swf?v=1224", p2pflash: flash + "/live_do.swf?v=1224", set: function(key, url) { this[key] = url } }
    }), qcVideo("constants", function() { return { SERVER_API: "http://play.live.qcloud.com/index.php", SERVER_API_HTTPS: "https://playlive.qcloud.com/index.php", SERVER_API_PARAMS: { channel_id: 1, app_id: 1, refer: 1, passwd: !0 }, OK_CODE: "0", ERROR_CODE: { TIME_OUT: "10000", SCRIPT_ONLOAD: "10001", SCRIPT_ONERROR: "10002", ILLEGAL_APPID: "10008", ILLEGAL_CHANNEL_ID: "10008", REQUIRE_APPID: "11044", REQUIRE_CHANNEL_ID: "11045", REQUIRE_PWD: "11046", ILLEGAL_PWD: "20110", LIVE_NOT_EXSIT: "20113", ARGUMENTS_ILL_VALID: "1001", ADDRESS_ILLEGAL: "1009", MANIFEST_ILL_VALID: "3" }, ERROR_MSG: { 10000: "请求超时,请检查网络设置", 10001: "数据解析失败", 10002: "连接超时，请稍后再试", 1: "数据库错误", 2: "连接不到直播源,直播源没有推送视频内容(hls)", 3: "直播已经结束啦(hls)", 113: "连接超时，请稍后再试", 114: "连接超时，请稍后再试", 1000: "channelID或者APPID错误", 1001: "无效参数,获取bizid失败", 1009: "直播源已失效", 10008: "密码错误，请重新输入", 10020: "直播账户余额已不足，请及时充值", 11044: "无效请求", 11045: "请求参数缺少channelID", 11046: "密码错误，请重新输入", 20110: "密码错误，请重新输入", 20113: "直播已经结束啦,请稍后再来", 20201: "直播已经结束啦,请稍后再来", 20301: "直播频道不存在，请确认频道ID" }, TIP_MESSAGE: { TipReconnect: "重新连接中", TipRequireSafari: "当前浏览器不能支持视频播放,请使用safari打开观看", TipRequireFlash: "当前浏览器不能支持视频播放，可下载最新的QQ浏览器或者安装FLASH即可播放", TipVideoinfoResolveError: "视频信息解析错误，请检查参数是否正确", TipVideoinfoError: "视频信息错误，请检查参数是否正确", TipConnectError: "连接服务失败，请检查网络设置", TipConnectDeny: "连接服务被拒绝", TipLiveEnd: "直播已经结束啦,请稍后再来", TipStreamNotFound: "直播已经结束啦,请稍后再来" }, TAP: "tap", CLICK: "click", UNICODE_WORD: { TIP_REQUIRE_SAFARI: "当前浏览器不能支持视频播放,请使用safari打开观看", TIP_REQUIRE_FLASH: "当前浏览器不能支持视频播放，可下载最新的QQ浏览器或者安装FLASH即可播放" }, HIGH_DEFINITION: "high", NORMAL_DEFINITION: "normal", ORIGINAL_DEFINITION: "original", NAMES_DEFINITION: { original: "超清", high: "高清", normal: "普清" } } }), qcVideo("Barrage", function(Base, Barrage_tpl) {
        var uuid = 1e3,
            addEvent = function(el, name, fn) { return el.addEventListener ? el.addEventListener(name, fn, !1) : el.attachEvent("on" + name, fn) },
            $ = function(id) { return document.getElementById(id) };
        return Base.extend({
            className: "Barrage",
            option: null,
            constructor: function(targetId, context) {
                var id = targetId + "_" + ++uuid,
                    ids = { text: id + "text", send: id + "send" },
                    el = $(targetId),
                    div = document.createElement("div");
                div.className = "trump-editor", div.innerHTML = Barrage_tpl.html({ ids: ids }), el.parentNode.appendChild(div);
                var text = $(ids.text),
                    send = $(ids.send),
                    lastSendTime = +new Date;
                addEvent(send, "click", function() {
                    var now = +new Date;
                    if (now - lastSendTime > 3e3) {
                        var value = text.value;
                        if (value) {
                            var bb = [{ type: "content", content: value, time: "0.101" }];
                            context.addBarrage(bb), lastSendTime = now, text.value = ""
                        }
                    }
                })
            }
        })
    }), qcVideo("Barrage_tpl", function() {
        return {
            html: function(data) {
                var __p = [],
                    _p = function(s) { __p.push(s) };
                return _p('<div class="trump-mask"></div>\r\n<div class="trump-inner">\r\n<div class="trump-textarea">\r\n<textarea id="'),
                    _p(this.__escapeHtml(data.ids.text)),
                    _p('" class="trump-input" type="text" maxlength="50" placeholder="最多输入50个字符"></textarea>\r\n</div>\r\n</div>\r\n<a id="'),
                    _p(this.__escapeHtml(data.ids.send)), _p('" class="trump-submit" href="javascript:void;" onclick=";return false;">发&nbsp;送</a>\r\n<style>\r\n.trump-mask{display:none;width: 100%;height: 100%;position: absolute;z-index: 5;top: 0px;left: 0px;background-color: #000;opacity: 0.3;}\r\n			        .trump-editor {width: 100%;background: #eee;position: relative;}\r\n			        .trump-inner {padding: 10px;}\r\n			        .trump-textarea {position: relative;background: #fff;border: #ccc solid 1px;height: 42px;}\r\n			        .trump-input {border: 0;width: 80%;height: 32px;line-height: 22px;padding: 5px 10px;outline: none;overflow: hidden;color: #666;resize: none;background: transparent;}\r\n			        .trump-submit {\r\n			            position: absolute;right: 10px;top: 10px;width: 77px;height: 42px;line-height: 42px;text-decoration: none;\r\n			            cursor: pointer;overflow: hidden;text-align: center;color: #fff;border: #e87e00 solid 1px;font-size: 14px;background-color: #ff5a00;\r\n			            font-weight:bold;\r\n			        }\r\n			        .trump-submit:hover{background-color:#D6733D;}\r\n			    </style>'), __p.join("")
            },
            __escapeHtml: function() {
                var a = { "&": "&amp;", "<": "&lt;", ">": "&gt;", "'": "&#39;", '"': "&quot;", "/": "&#x2F;" },
                    b = /[&<>'"\/]/g;
                return function(c) { return "string" != typeof c ? c : c ? c.replace(b, function(b) { return a[b] || b }) : "" }
            }()
        }
    }), qcVideo("H5", function(constants, api, util, Base, config, H5_tpl, codeReport) {
        var $, verifyDone = function(data) {
            var me = this;
            if (util.merge(me.store, data, !0), util.merge(me.store, { parameter: me.option }), me.loading(!0), -1 === config.h5player.indexOf("?")) {
                var version = data.version && data.version.h5 || "beta";
                config.set("h5player", config.h5player + "?max_age=20000000&swfv=" + version)
            }
            qcVideo.use("h5player", function(mod) { me.loading(), mod.render(me.store) })
        };
        return Base.extend({
            askDoor: function(firstTime, pass) {
                var key, me = this,
                    store = me.store,
                    address = (me.store.https ? constants.SERVER_API_HTTPS : constants.SERVER_API) + "?t=" + +new Date;
                for (key in constants.SERVER_API_PARAMS) store.hasOwnProperty(key) && (address += "&" + key + "=" + store[key]);
                if (void 0 !== pass && (address += "&passwd=" + pass), me.option.live_url || me.option.live_url2) {
                    var d = {};
                    d.channel_info = {};
                    var theUrl = me.option.live_url.indexOf(".m3u8") > 0 ? me.option.live_url : me.option.live_url2.indexOf(".m3u8") ? me.option.live_url2 : "";
                    return d.channel_info.hls_downstream_address = theUrl, void verifyDone.call(me, d)
                }
                codeReport.reportStart(address, "live"), me.loading(!0), api.request(address, function(ret) {
                    me.loading();
                    var code = ret.retcode + "",
                        data = ret.data;
                    if (code != constants.ERROR_CODE.TIME_OUT && code != constants.ERROR_CODE.SCRIPT_ONLOAD && code != constants.SCRIPT_ONERROR) {
                        var logicErrorCode = [10008, 10020, 11045, 11046, 20110, 20301];
                        Array.prototype.indexOf ? codeReport.reportEnd("0" == code ? "1" : -1 != logicErrorCode.indexOf(code) ? "3" : "2", code) : codeReport.reportEnd("0" == code ? "1" : "3", code)
                    } else codeReport.reportEnd(2, code);
                    code == constants.OK_CODE ? data.channel_info && data.channel_info.hls_downstream_address ? "1" == data.channel_info.status ? verifyDone.call(me, data) : mui.toast((constants.TIP_MESSAGE.TipStreamNotFound), { duration: 1000, type: 'div' }) : mui.toast((constants.ERROR_MSG[constants.ERROR_CODE.LIVE_NOT_EXSIT + ""] + "_(" + constants.ERROR_CODE.LIVE_NOT_EXSIT + ")"), { duration: 1000, type: 'div' }) : code != constants.ERROR_CODE.REQUIRE_PWD && code != constants.ERROR_CODE.ILLEGAL_PWD || !firstTime ? mui.toast((constants.ERROR_MSG[code] + "_(" + code + ")" || "error code:(" + code + ") "), { duration: 1000, type: 'div' }) : me.renderPWDPanel()
                })
            },
            className: "PlayerH5",
            $pwd: null,
            $out: null,
            option: {},
            constructor: function(_$, targetId, opt, link) {
                $ = _$;
                var me = this,
                    node = document.createElement("link"),
                    defaultV = "20150508";
                me.option = opt, node.href = config.h5css, node.rel = "stylesheet", node.media = "screen", document.getElementsByTagName("head")[0].appendChild(node), me.store = util.merge({ $renderTo: $("#" + targetId), version: { h5: defaultV, flash: defaultV, android: defaultV, ios: defaultV }, link: link }, opt);
                var $out = me.$out = me.store.$renderTo.html(H5_tpl.main({ sure: "确定", errpass: "抱歉，密码错误", enterpass: "请输入密码", videlocked: "该视频已加密" }));
                $out.find('[data-area="main"]').css({ width: me.store.width, height: me.store.height }), me.$pwd = $out.find('[data-area="pwd"]'), me.askDoor(!0)
            },
            loading: function(visible) {},
            erTip: function(msg, pwdEr) { pwdEr && this.$pwd.find(".txt").text(msg).css("visibility", "visible") },
            sureHandler: function() {
                var me = this,
                    $pwd = me.$pwd,
                    pwd = $pwd.find('input[type="password"]').val() + "",
                    able = pwd.length > 0;
                $pwd.find(".txt").text(able ? "" : "抱歉，密码错误").css("visibility", able ? "hidden" : "visible"), able && me.askDoor(!1, pwd)
            },
            renderPWDPanel: function() {
                var me = this,
                    cw = me.store.width,
                    ch = me.store.height,
                    $pwd = me.$pwd,
                    $parent = $pwd.parent();
                $pwd.show().on("click", "[tx-act]", function(e) {
                    var act = $(this).attr("tx-act"),
                        handler = me[act + "Handler"];
                    return handler && handler.call(me), e.stopPropagation(), !1
                });
                var pw = $pwd.width(),
                    ph = $pwd.height(),
                    fW = $parent.width();
                fW && pw >= fW ? $pwd.css({ left: "0px", top: "0px" }).width(fW) : $pwd.css({ left: (cw - pw) / 2 + "px", top: (ch - ph) / 2 + "px" })
            }
        })
    }), qcVideo("H5_tpl", function() {
        return {
            main: function(data) {
                var __p = [],
                    _p = function(s) { __p.push(s) };
                return _p('<div data-area="main" style="position: relative;background-color: #000;">\r\n			        <div class="layer-password" data-area="pwd" style="display:none;">\r\n			            <span class="tip" style="border: none;background-color: #242424;border-bottom: 1px solid #0073d0;position: relative;">'), _p(data.videlocked), _p('</span>\r\n			            <input class="password" placeholder="'), _p(data.enterpass), _p('" type="password">\r\n			            <span class="txt">'), _p(data.errpass), _p('</span>\r\n			            <div class="bottom">\r\n			                <a class="btn ok" href="#" tx-act="sure">'), _p(data.sure), _p('</a>\r\n			            </div>\r\n			        </div>\r\n			        <div data-area="loading" style="display:none;">\r\n			            loading....\r\n			        </div>\r\n				</div>'), __p.join("")
            },
            __escapeHtml: function() {
                var a = { "&": "&amp;", "<": "&lt;", ">": "&gt;", "'": "&#39;", '"': "&quot;", "/": "&#x2F;" },
                    b = /[&<>'"\/]/g;
                return function(c) { return "string" != typeof c ? c : c ? c.replace(b, function(b) { return a[b] || b }) : "" }
            }()
        }
    }), qcVideo("Player", function(util, Base, version, css, H5, Swf, SwfJsLink, constants) {
        function tryIt(fn) { fn() }

        function getEid() { return "video_" + eidUuid++ }

        function setSuitableWH(opt, ele) {
            tryIt(function() { ele.innerHTML = "" });
            var rate = 0,
                width = css.getWidth(ele),
                height = css.getHeight(ele),
                minPix = 4;
            if (minPix > width && ele.parentNode)
                for (var pEle = ele.parentNode;;) {
                    if (!pEle || pEle === document.body) { width = css.getVisibleWidth(); break }
                    if (width = css.getWidth(pEle), width > minPix) break;
                    pEle = pEle.parentNode
                }
            var hasRate = opt.width > 0 && opt.height > 0;
            if (hasRate && (rate = opt.width / opt.height), width > minPix && minPix > height && hasRate) {
                tryIt(function() { ele.style.height = "auto" });
                var vh = css.getVisibleHeight() - 4,
                    th = width / rate;
                0 === vh || vh > th ? height = th : (height = vh, width = rate * vh), width > opt.width ? (width = opt.width, height = width / rate, height > opt.height && (height = opt.height, width = height * rate)) : height > opt.height && (height = opt.height, width = height * rate, width > opt.width && (width = opt.width, height *= rate))
            }
            opt.width = width, opt.height = height
        }
        var eidUuid = 1e7;
        // 返回对象 web 播放器
        return Base.extend({
            className: "Player",
            constructor: function(targetId, opt, listener) {
                if (util.isPlainObject(targetId)) {
                    var tmp = opt;
                    opt = targetId, targetId = tmp
                }
                if (opt && opt.wording) { var i, m; for (i in opt.wording) m = opt.wording[i], constants.ERROR_MSG[i] ? m && (constants.ERROR_MSG[i] = m) : constants.TIP_MESSAGE[i] ? m && (constants.TIP_MESSAGE[i] = m) : constants.UNICODE_WORD[i] && m && (constants.UNICODE_WORD[i] = m) }
                var verifyDone = function() {
                        this.targetId = targetId, setSuitableWH(opt, ele);
                        var ver = version.getLivePriority(),
                            eid = getEid(),
                            link = new SwfJsLink(eid, listener, targetId);
                        if ("h5" == ver && (version.ABLE_H5_HLS || version.ABLE_H5_APPLE_HLS)) qcVideo.use("$", function(mod) { new H5(mod, targetId, opt, link) });
                        else {
                            if ("flash" != ver) return version.IS_MAC ? ele.innerText = constants.TIP_MESSAGE.TipRequireSafari : ele.innerText = constants.TIP_MESSAGE.TipRequireFlash, void(listener && listener.playStatus && listener.playStatus("error", { code: -1, message: "env error" }));
                            new Swf(targetId, eid, opt, link)
                        }
                        return this.targetId = targetId, css.textAlign(ele), link
                    },
                    ele = document.getElementById(targetId);
                if (opt.refer = document.domain, targetId && ele) {
                    if (opt.live_url || opt.app_id && opt.channel_id) return verifyDone.call(this);
                    alert("缺少参数，请补齐app_id，channel_id")
                } else alert("没有指定有效播放器容器！")
            },
            remove: function() { this.targetId && (document.getElementById(this.targetId).innerHTML = "") }
        })
    }), qcVideo("Swf", function(Base, config) {
        var getHtmlCode = function(option, eid) {
            var __ = [],
                address = config.flash,
                _ = function(str) { __.push(str) },
                flashvars = (option.channel_id ? "&channel_id=" + option.channel_id : "") + (option.app_id ? "&app_id=" + option.app_id : "") + (option.https ? "&https=1" : "") + (option.hide_volume_tips ? "&hide_volume_tips=" + option.hide_volume_tips : "") + (option.volume > -1 && option.volume < 1.1 ? "&volume=" + option.volume : "") + (option.live_url ? "&live_url=" + encodeURIComponent(option.live_url) : "") + (option.live_url2 ? "&live_url2=" + encodeURIComponent(option.live_url2) : "") + (option.as3_trigger_core_event ? "&as3_trigger_core_event=" + option.as3_trigger_core_event : "") + "&refer=" + option.refer + "&jscbid=" + eid,
                VMode = option.VMode || option.WMode || "window";
            return flashvars += option.debug ? "&debug=1" : "", void 0 !== option.disable_full_screen && (flashvars += "&disable_full_screen=" + option.disable_full_screen), void 0 !== option.stretch_full && option.stretch_full && (flashvars += "&stretch_full=1"), void 0 !== option.cache_time && (flashvars += "&cache_time=" + option.cache_time), option.open_write_barrage && (flashvars += "&open_write_barrage=1"), option.wording && (flashvars += "&wording=1"), _('<object data="' + address + '" id="' + eid + '_object" width="' + option.width + 'px" height="' + option.height + 'px"  style="background-color:#000000;" '), _('align="middle" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://fpdownload.macromedia.com/get/flashplayer/current/swflash.cab#version=9,0,0,0">'), _('<param name="flashVars" value="' + flashvars + '"  />'), _('<param name="src" value="' + address + '"  />'), _('<param name="wmode" value="' + VMode + '"/>'), _('<param name="quality" value="High"/>'), _('<param name="allowScriptAccess" value="always"/>'), _('<param name="allowNetworking" value="all"/>'), _('<param name="allowFullScreen" value="true"/>'), _('<embed style="background-color:#000000;"  id="' + eid + '_embed" width="' + option.width + 'px" height="' + option.height + 'px" flashvars="' + flashvars + '"'), _('align="middle" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" allowfullscreen="true" bgcolor="#000000" quality="high"'), _('src="' + address + '"'), _('wmode="' + VMode + '" allowfullscreen="true" invokeurls="false" allownetworking="all" allowscriptaccess="always">'), _("</object>"), __.join("")
        };
        return Base.extend({
            _recoverySize: function(old) {
                var width = old.width,
                    height = old.height,
                    me = this;
                return (398 > width || 298 > height) && (setTimeout(function() { me.context.forceResize(width, height) }, 50), old.width = 398, old.height = 298), old
            },
            className: "PlayerSwf",
            option: null,
            constructor: function(targetId, eid, opt, context) { this.context = context, document.getElementById(this.targetId = targetId).innerHTML = getHtmlCode(this._recoverySize(opt), eid) },
            remove: function() {
                var node = document.getElementById(this.targetId) || {},
                    parent = node.parentNode;
                node.parentNode && "object" == (node.parentNode.tagName || "").toLowerCase() && (node = parent, parent = node.parentNode);
                try { parent.removeChild(node) } catch (xe) {}
            }
        })
    }), qcVideo("SwfJsLink", function(util, JSON, LinkIm, Barrage, codeReport, constants) {
        var global = window,
            pixesToInt = function(str) { return 0 | (str ? str + "" : "").replace("px", "") },
            SwfJsLink = function(id, listeners, targetId) {
                var me = this;
                me.id = id, me.tecGet = id + "_tecGet", me.operate = id + "_operate", me.barrage = id + "_barrage", me.close_barrage = id + "_close_barrage", me.login_barrage = id + "_login_barrage", me.check_login_barrage = id + "_check_login_barrage", me.__targetId = targetId, global[id + "_callback"] = function(cmd, data) {
                    var cmds = cmd.split(":"),
                        key = cmds[0];
                    if (me.listeners.hasOwnProperty(key)) switch (key) {
                        case "playStatus":
                            me.listeners[key](cmds[1], cmds[2] || data);
                            break;
                        case "netStatus":
                            me.listeners[key](cmds[1])
                    }
                }, global[id + "_call_js"] = function(cmd, data) {
                    if ("IM_LOGIN" == cmd) {
                        var im;
                        im = { sdkAppID: "1400002425", accountType: "1340", groupId: "@TGS#37OYPPAEG", nickName: "anderlu", channel_id: "16093425727656143421", open_write_barrage: !0 }, im && im.channel_id && (me.linkIm = new LinkIm(me, im, im.channel_id, function() { me.listeners.loginBarrageCallback(!0) }, function(msg) { me.listeners.loginBarrageCallback(!1, msg) }), im.open_write_barrage && (me.barrageObj = new Barrage(me.__targetId, me)))
                    }
                    if ("codeReport" == cmd && codeReport.reportParams(data), "wording" == cmd) { var msg = {}; return util.merge(msg, constants.ERROR_MSG), util.merge(msg, constants.TIP_MESSAGE), msg }
                }, me.listeners = { loginBarrageCallback: function(isDone, msg) { console.log("登录弹幕服务器:", isDone ? "成功" : "失败", msg) } }, "object" == util.type(listeners) && util.merge(me.listeners, listeners)
            },
            tryIt = function(fn) { return function() { try { return fn.apply(this, arguments) } catch (xe) { return "0" } } };
        return util.merge(SwfJsLink.prototype, {
            getSwf: function() {
                var me = this;
                if (!me.swf) try {
                    var ctx1 = document.getElementById(this.id + "_object"),
                        ctx2 = document.getElementById(this.id + "_embed");
                    ctx1 && ctx1[this.tecGet] ? this.swf = ctx1 : ctx2 && ctx2[this.tecGet] && (this.swf = ctx2)
                } catch (xe) { return {} }
                return this.swf
            },
            forceResize: function(w, h) { for (var ctx, r = [document.getElementById(this.id + "_object"), document.getElementById(this.id + "_embed")], i = 0; 2 > i; i++) try { ctx = r[i], ctx && (ctx.width = w, ctx.height = h) } catch (xe) {} },
            resize: function(w, h) {
                var swf = this.getSwf(),
                    numH = pixesToInt(h);
                if (swf) swf.width = pixesToInt(w), swf.height = numH;
                else {
                    var ele = document.querySelector("#" + this.__targetId).firstChild;
                    ele && (ele.style.width = w + "px", ele.style.height = h + "px")
                }
            },
            getWidth: function() { return pixesToInt(this.getSwf().width) },
            getHeight: function() { return pixesToInt(this.getSwf().height) },
            stop: tryIt(function() { return this.getSwf()[this.operate]("stop") }),
            pause: tryIt(function() { return this.getSwf()[this.operate]("pause") }),
            resume: tryIt(function() { return this.getSwf()[this.operate]("resume") }),
            play: tryIt(function() { return this.getSwf()[this.operate]("play") }),
            addBarrage: tryIt(function(ary) { return ary && ary.length > 0 ? this.getSwf()[this.barrage](JSON.stringify(ary)) : void 0 }),
            closeBarrage: tryIt(function() { return this.getSwf()[this.close_barrage]() }),
            loginBarrage: tryIt(function(info) { var m = info ? JSON.stringify(info) : ""; return console.log("登录弹幕服务器", info), this.getSwf()[this.login_barrage](m) }),
            checkLoginBarrage: tryIt(function(appid) { return this.getSwf()[this.check_login_barrage](appid) })
        }), SwfJsLink
    }), qcVideo.use("Player", function(mod) { qcVideo.Player = mod }), qcVideo("h5Drag", function($, Base) {
        return Base.extend({
            className: "Drag",
            constructor: function(ctx, $drag, $range, onStart, onMove, onEnd) {
                var me = this,
                    getTouchLeft = function(e) { return e.targetTouches[0].pageX },
                    getRate = function() { return ($drag.css("left").replace("px", "") - 0) / me.maxLeft };
                $(document.body).on("touchstart", function(e) {
                    if (e.target === $drag.get(0) && ctx.enable_tag) {
                        var range = $range.offset();
                        me.sourceL = getTouchLeft(e), me.maxLeft = range.width, me.initLeft = me.maxLeft * ($drag.css("left").replace("%", "") - 0) / 100, onStart && onStart()
                    } else me.sourceL = null
                }).on("touchmove", function(e) {
                    if (null !== me.sourceL) {
                        var diff = getTouchLeft(e) - me.sourceL,
                            newLeft = me.initLeft + diff;
                        if (newLeft >= me.maxLeft || 0 >= newLeft) return;
                        $drag.css("left", newLeft + "px"), onMove && onMove(getRate())
                    }
                }).on("touchend", function(e) { null !== me.sourceL && onEnd && onEnd(getRate()) })
            }
        })
    }), qcVideo("MediaPlayer", function($, Base, PlayerSystem, PlayerConst, MediaPlayer_tpl, constants) {
        return Base.extend({
            system: !1,
            control: !1,
            className: "MediaPlayer",
            destroy: function() { this.control && (this.control.destroy(), this.system.destroy(), delete this.control, delete this.system) },
            initVideo: function(video) {
                var me = this;
                video && me.system.setUrl(video.url)
            },
            init_rates: function(video, channel_info) {
                if (video.url && channel_info.rate_type && !(channel_info.rate_type.length < 1)) {
                    var toRateUrls = function(type) {
                        var tail = type == constants.ORIGINAL_DEFINITION ? "" : type == constants.NORMAL_DEFINITION ? "_550" : "_900",
                            rateName = constants.NAMES_DEFINITION[type],
                            dot = video.url.indexOf(".m3u8");
                        return { url: video.url.substr(0, dot) + tail + video.url.substr(dot), name: rateName, rate: type }
                    };
                    video.rate_type = { __length: 0 }, video.rate_type.__length += 1, video.rate_type[constants.ORIGINAL_DEFINITION] = toRateUrls(constants.ORIGINAL_DEFINITION);
                    for (var type, rate_type = channel_info.rate_type, i = 0, j = rate_type.length; j > i; i++)(type = rate_type[i]) && ("10" == type ? (video.rate_type.__length += 1, video.rate_type[constants.NORMAL_DEFINITION] = toRateUrls(constants.NORMAL_DEFINITION)) : "20" == type && (video.rate_type.__length += 1, video.rate_type[constants.HIGH_DEFINITION] = toRateUrls(constants.HIGH_DEFINITION)))
                }
            },
            constructor: function(setting) {
                var me = this,
                    $renderTo = setting.$renderTo,
                    video = { url: setting.channel_info.hls_downstream_address },
                    $container = $renderTo.html(MediaPlayer_tpl.main({ width: setting.width, height: setting.height })).find("div"),
                    system = me.system = new PlayerSystem($container, setting.link);
                video.url && (me.init_rates(video, setting.channel_info), video.rate_type && video.rate_type.high && video.url.indexOf("?") < 1 && (video.url = video.rate_type.high.url));
                var width = $renderTo.width() - 4;
                me.initVideo(video), $container.append(MediaPlayer_tpl.controller({ width: parseInt(width / 7), height: parseInt(width / 7), start_patch: setting.h5_start_patch })), $container.css("overflow", "hidden");
                var $play = $renderTo.find('[sub-component="play"]'),
                    $video = $renderTo.find("video"),
                    $startPatch = $renderTo.find('[ data-mode="start_patch"]'),
                    callPlayed = !1,
                    toPlay = function() { callPlayed = !0, $play.hide(), $startPatch.hide(), $video.css("top", "0"), system.play() };
                $play.on("click", function() { toPlay() }), setting.x5_type && $video.attr("x5-video-player-type", "h5"), setting.x5_fullscreen && $video.attr("x5-video-player-fullscreen", "true"), setting.h5_on_touch_play && $(document).one("touchstart", function() { callPlayed || toPlay() })
            }
        })
    }), qcVideo("MediaPlayer_tpl", function() {
        return {
            main: function(data) {
                var __p = [],
                    _p = function(s) { __p.push(s) };
                return _p('<div style="width:'), _p(data.width), _p("px;height:"), _p(data.height), _p('px;margin: 0px auto;position:relative;background-color: #000;"></div>'), __p.join("")
            },
            controller: function(data) {
                var __p = [],
                    _p = function(s) { __p.push(s) },
                    patch = data.start_patch;
                return patch && (patch.stretch ? (_p('            <img data-mode="start_patch" style="width:100%;height:100%" src="'), _p(this.__escapeHtml(patch.url)), _p('"/>')) : (_p('            <img data-mode="start_patch" src="'), _p(this.__escapeHtml(patch.url)), _p('"/>'))), _p('    <div style="position: absolute;left: 50%;top: 50%;z-index: 101;cursor: pointer;width: '), _p(this.__escapeHtml(data.width)), _p("px;height:"), _p(this.__escapeHtml(data.height)), _p("px;margin: -"), _p(this.__escapeHtml(data.width / 2)), _p("px 0 0 -"), _p(this.__escapeHtml(data.height / 2)), _p('px;" sub-component="play">\r\n			        <svg height="100%" version="1.1" viewBox="0 0 98 98" width="100%">\r\n			            <circle cx="49" cy="49" fill="#000" stroke="#fff" stroke-width="2" fill-opacity="0.5" r="48" data-opacity="true"></circle>\r\n			            <circle cx="-49" cy="49" fill-opacity="0" r="46.5" stroke="#fff"\r\n			                    stroke-dasharray="293" stroke-dashoffset="-293.0008789998712" stroke-width="4"\r\n			                    transform="rotate(-90)"></circle>\r\n			            <polygon fill="#fff" points="32,27 72,49 32,71"></polygon>\r\n			        </svg>\r\n			    </div>'), __p.join("")
            },
            definition_panel: function(data) {
                var __p = [],
                    _p = function(s) { __p.push(s) };
                _p('<ul class="distinct">');
                for (var i = 0, j = data.length; j > i; i++) {
                    var itm = data[i];
                    _p('                <li resolution="'), _p(itm.resolution), _p('"><a href="#">'), _p(itm.resolutionName), _p("</a></li>")
                }
                return _p("    </ul>"), __p.join("")
            },
            video: function(data) {
                var __p = [],
                    _p = function(s) { __p.push(s) };
                return _p('<video id="'), _p(data.vid), _p('" webkit-playsinline="" playsinline="" width="100%" height="100%" controls="true" src="'), _p(data.url), _p('" style="z-index: 1;position: absolute;top: -200%;left: 0px;"></video>'), __p.join("")
            },
            __escapeHtml: function() {
                var a = { "&": "&amp;", "<": "&lt;", ">": "&gt;", "'": "&#39;", '"': "&quot;", "/": "&#x2F;" },
                    b = /[&<>'"\/]/g;
                return function(c) { return "string" != typeof c ? c : c ? c.replace(b, function(b) { return a[b] || b }) : "" }
            }()
        }
    }), qcVideo("PlayerConst", function() { return { EVENT: { OS_TIME_UPDATE: "OS_TIME_UPDATE", OS_PROGRESS: "OS_PROGRESS", OS_LOADED_META_DATA: "OS_LOADED_META_DATA", OS_PLAYER_END: "OS_PLAYER_END", OS_VIDEO_LOADING: "OS_VIDEO_LOADING", OS_ERROR: "OS_ERROR", OS_BLOCK: "OS_BLOCK", UI_SET_VOLUME: "UI_SET_VOLUME", UI_SEEK_TIME: "UI_SEEK_TIME", UI_SWITCH_DEFINITION: "UI_SWITCH_DEFINITION", UI_PAUSE: "UI_PAUSE", UI_PLAY: "UI_PLAY", UI_CLICK_DEFINITION: "UI_CLICK_DEFINITION", UI_BACK: "UI_BACK", UI_SETTING: "UI_SETTING", UI_FULL_SCREEN: "UI_FULL_SCREEN" }, ERROR: { DISABLE_VISIT: "当前视频无法访问" } } }), qcVideo("PlayerStatus", function(Base, PlayerConst, interval) {
        var time = 1e3 / 60,
            blockTime = 300 * time,
            EVENT = PlayerConst.EVENT;
        return Base.extend({
            className: "PlayerStatus",
            clear: function() {
                var me = this;
                me.played = 0, me.duration = 0, me.loaded = 0, me.loaded_overtime = 0, me.errorCode = 0, me.equalRead(), me.timeTask.start()
            },
            equalRead: function() {
                var me = this;
                me.__read = { played: me.played, duration: me.duration, loaded: me.loaded }
            },
            constructor: function() {
                var me = this;
                me.timeTask = interval(function() {
                    var bool = !1;
                    if (me.__read.duration !== me.duration && (bool = !0, me.fire(EVENT.OS_LOADED_META_DATA)), me.__read.played !== me.played && (bool = !0, me.fire(EVENT.OS_PROGRESS)), me.__read.loaded !== me.loaded && (bool = !0, me.fire(EVENT.OS_TIME_UPDATE)), me.equalRead(), !bool && me.__isMaybeBlockStatus()) {
                        me.played >= me.duration && me.duration > 0 && me.fire(EVENT.OS_PLAYER_END);
                        var now = +new Date;
                        now - me.status_start > blockTime && me.__getStatusValue() === me.status_value ? me.fire(EVENT.OS_BLOCK) : me.fire(EVENT.OS_VIDEO_LOADING)
                    }
                }, time), me.clear()
            },
            destroy: function() { this.timeTask.clear() },
            __getStatusValue: function() { return this.played - 0 + ":" + (this.loaded - 0) + ":" + (this.duration - 0) },
            __isMaybeBlockStatus: function() { return "play" === this.status || "load" === this.status },
            setRunningStatus: function(status) { this.status = status, this.status_start = +new Date, this.status_value = this.__getStatusValue() },
            set_duration: function(num) { this.duration = num - 0 },
            set_loaded: function(num) { this.loaded = num - 0 },
            set_played: function(num) { this.played = num - 0 }
        })
    }), qcVideo("PlayerSystem", function($, Base, PlayerStatus, MediaPlayer_tpl, interval) {
        var getId = function() { return "video_id_" + +new Date },
            time = 1e3 / 60;
        return Base.extend({
            className: "PlayerSystem",
            constructor: function($renderTo, link) {
                var me = this;
                me.$renderTo = $renderTo, me.status = new PlayerStatus, me.link = link, me.timeTask = interval(function() {
                    if (me.video) {
                        var r = me.video.buffered,
                            loaded = 0;
                        if (r)
                            for (var i = 0; i < r.length; i++) loaded = r.end(i) - 0;
                        me.status.set_loaded(loaded), me.status.set_played(me.video.currentTime)
                    }
                }, time)
            },
            destroy: function() { this.timeTask.clear(), delete this.$renderTo, this.status.destroy(), delete this.status },
            getStatus: function() { return this.status },
            callMethod: function(mtd) { try { this.video[mtd](), this.status.setRunningStatus(mtd) } catch (xe) {} },
            _bind: function() {
                var me = this,
                    getHandler = function(event) {
                        return function(e) {
                            var video = me.video;
                            switch (event) {
                                case "loadedmetadata":
                                    me.metadatadone = !0, me.status.set_duration(video.duration), me.timeTask.start();
                                    break;
                                case "error":
                                    me.log(event, e), window[me.link.id + "_callback"]("playStatus:error");
                                    break;
                                case "playing":
                                    window[me.link.id + "_callback"]("playStatus:playing");
                                    break;
                                case "ended":
                                    window[me.link.id + "_callback"]("playStatus:playEnd")
                            }
                        }
                    },
                    EventAry = "loadstart,suspend,abort,error,emptied,stalled,loadedmetadata,loadeddata,canplay,canplaythrough,playing,waiting,seeking,seeked,ended,durationchange,timeupdate,progress,play,pause,ratechange,volumechange".split(",");
                $.each(EventAry, function(_, event) { me.$video.on(event, getHandler(event)) })
            },
            setUrl: function(src) {
                var me = this,
                    $renderTo = me.$renderTo,
                    tpl = me.tpl = { vid: getId(), width: $renderTo.width(), height: $renderTo.height(), url: src };
                me.metadatadone = !1, me.timeTask.pause(), me.status.clear(), me.$video && me.$video.remove(), $renderTo.prepend(MediaPlayer_tpl.video(tpl)), me.video = (me.$video = $("#" + tpl.vid)).get(0), me._bind()
            },
            play: function() {
                var me = this;
                me.video && me.callMethod("play")
            },
            setVolume: function(num) { this.video && (this.video.volume = num) }
        })
    }), qcVideo("h5player", function($, Base, constants, util, MediaPlayer) { return Base.instance({ className: "h5player", constructor: Base.loop, render: function(opt) { this.mediaPlayer = new MediaPlayer({ width: opt.width, height: opt.height, $renderTo: opt.$renderTo, channel_info: opt.channel_info, player_info: opt.player_info, h5_start_patch: opt.h5_start_patch || "", h5_on_touch_play: opt.h5_on_touch_play, x5_type: opt.x5_type, x5_fullscreen: opt.x5_fullscreen, link: opt.link }) }, destroy: function() { this.mediaPlayer.destroy() } }) });