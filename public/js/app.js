try{self["workbox:window:5.1.4"]&&_()}catch(e){}function e(e,t){return new Promise((function(n){var r=new MessageChannel;r.port1.onmessage=function(e){n(e.data)},e.postMessage(t,[r.port2])}))}function t(e,t){(null==t||t>e.length)&&(t=e.length);for(var n=0,r=new Array(t);n<t;n++)r[n]=e[n];return r}function n(e,n){var r;if("undefined"==typeof Symbol||null==e[Symbol.iterator]){if(Array.isArray(e)||(r=function(e,n){if(e){if("string"==typeof e)return t(e,n);var r=Object.prototype.toString.call(e).slice(8,-1);return"Object"===r&&e.constructor&&(r=e.constructor.name),"Map"===r||"Set"===r?Array.from(e):"Arguments"===r||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(r)?t(e,n):void 0}}(e))||n&&e&&"number"==typeof e.length){r&&(e=r);var i=0;return function(){return i>=e.length?{done:!0}:{done:!1,value:e[i++]}}}throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}return(r=e[Symbol.iterator]()).next.bind(r)}try{self["workbox:core:5.1.4"]&&_()}catch(e){}var r=function(){var e=this;this.promise=new Promise((function(t,n){e.resolve=t,e.reject=n}))};function i(e,t){var n=location.href;return new URL(e,n).href===new URL(t,n).href}var o=function(e,t){this.type=e,Object.assign(this,t)};function a(e,t,n){return n?t?t(e):e:(e&&e.then||(e=Promise.resolve(e)),t?e.then(t):e)}function c(){}var s=function(t){var n,c;function s(e,n){var c,s;return void 0===n&&(n={}),(c=t.call(this)||this).t={},c.i=0,c.o=new r,c.u=new r,c.s=new r,c.v=0,c.h=new Set,c.l=function(){var e=c.m,t=e.installing;c.i>0||!i(t.scriptURL,c.g)||performance.now()>c.v+6e4?(c.p=t,e.removeEventListener("updatefound",c.l)):(c.P=t,c.h.add(t),c.o.resolve(t)),++c.i,t.addEventListener("statechange",c.S)},c.S=function(e){var t=c.m,n=e.target,r=n.state,i=n===c.p,a=i?"external":"",s={sw:n,originalEvent:e};!i&&c.j&&(s.isUpdate=!0),c.dispatchEvent(new o(a+r,s)),"installed"===r?c.A=self.setTimeout((function(){"installed"===r&&t.waiting===n&&c.dispatchEvent(new o(a+"waiting",s))}),200):"activating"===r&&(clearTimeout(c.A),i||c.u.resolve(n))},c.O=function(e){var t=c.P;t===navigator.serviceWorker.controller&&(c.dispatchEvent(new o("controlling",{sw:t,originalEvent:e,isUpdate:c.j})),c.s.resolve(t))},c.U=(s=function(e){var t=e.data,n=e.source;return a(c.getSW(),(function(){c.h.has(n)&&c.dispatchEvent(new o("message",{data:t,sw:n,originalEvent:e}))}))},function(){for(var e=[],t=0;t<arguments.length;t++)e[t]=arguments[t];try{return Promise.resolve(s.apply(this,e))}catch(e){return Promise.reject(e)}}),c.g=e,c.t=n,navigator.serviceWorker.addEventListener("message",c.U),c}c=t,(n=s).prototype=Object.create(c.prototype),n.prototype.constructor=n,n.__proto__=c;var v,l=s.prototype;return l.register=function(e){var t=(void 0===e?{}:e).immediate,n=void 0!==t&&t;try{var r=this;return function(e,t){var n=e();return n&&n.then?n.then(t):t()}((function(){if(!n&&"complete"!==document.readyState)return u(new Promise((function(e){return window.addEventListener("load",e)})))}),(function(){return r.j=Boolean(navigator.serviceWorker.controller),r.I=r.M(),a(r.R(),(function(e){r.m=e,r.I&&(r.P=r.I,r.u.resolve(r.I),r.s.resolve(r.I),r.I.addEventListener("statechange",r.S,{once:!0}));var t=r.m.waiting;return t&&i(t.scriptURL,r.g)&&(r.P=t,Promise.resolve().then((function(){r.dispatchEvent(new o("waiting",{sw:t,wasWaitingBeforeRegister:!0}))})).then((function(){}))),r.P&&(r.o.resolve(r.P),r.h.add(r.P)),r.m.addEventListener("updatefound",r.l),navigator.serviceWorker.addEventListener("controllerchange",r.O,{once:!0}),r.m}))}))}catch(e){return Promise.reject(e)}},l.update=function(){try{return this.m?u(this.m.update()):void 0}catch(e){return Promise.reject(e)}},l.getSW=function(){try{return void 0!==this.P?this.P:this.o.promise}catch(e){return Promise.reject(e)}},l.messageSW=function(t){try{return a(this.getSW(),(function(n){return e(n,t)}))}catch(e){return Promise.reject(e)}},l.M=function(){var e=navigator.serviceWorker.controller;return e&&i(e.scriptURL,this.g)?e:void 0},l.R=function(){try{var e=this;return function(e,t){try{var n=e()}catch(e){return t(e)}return n&&n.then?n.then(void 0,t):n}((function(){return a(navigator.serviceWorker.register(e.g,e.t),(function(t){return e.v=performance.now(),t}))}),(function(e){throw e}))}catch(e){return Promise.reject(e)}},(v=[{key:"active",get:function(){return this.u.promise}},{key:"controlling",get:function(){return this.s.promise}}])&&function(e,t){for(var n=0;n<t.length;n++){var r=t[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(e,r.key,r)}}(s.prototype,v),s}(function(){function e(){this.k=new Map}var t=e.prototype;return t.addEventListener=function(e,t){this.B(e).add(t)},t.removeEventListener=function(e,t){this.B(e).delete(t)},t.dispatchEvent=function(e){e.target=this;for(var t,r=n(this.B(e.type));!(t=r()).done;)(0,t.value)(e)},t.B=function(e){return this.k.has(e)||this.k.set(e,new Set),this.k.get(e)},e}());function u(e,t){if(!t)return e&&e.then?e.then(c):Promise.resolve()}!function(e){var t=document.cookie.match(new RegExp("(^| )"+e+"=([^;]+)"));if(t)t[2]}("XSRF-TOKEN");function v(e){return"#"==e.charAt(0)?document.querySelector(e):document.querySelectorAll(e)}if("serviceWorker"in navigator){let t;const n=new s("/service-worker.js"),r=r=>{n.addEventListener("controlling",(e=>{window.location.reload()})),t&&t.waiting&&e(t.waiting,{type:"SKIP_WAITING"})};n.addEventListener("waiting",r),n.addEventListener("externalwaiting",r),n.register().then((e=>t=e))}window.addEventListener("load",(()=>{const e=v(".navbar-burger")[0];e.addEventListener("click",(function(){e.classList.toggle("is-active"),v("#nav-menu").classList.toggle("is-active")}))}));
