!function(){"use strict";class e{constructor(e,t){this.rootElement=e,this.containerElement=t,this.triggerElement=t.lastElementChild,this.getItems=()=>{},this.isLoading=!1,this.observer=null,this.observing=!1}loadPolyfillIfNeeded(e){if("IntersectionObserver"in window&&"IntersectionObserverEntry"in window&&"intersectionRatio"in window.IntersectionObserverEntry.prototype)e();else{const t=document.createElement("script");t.src="/js/intersection-observer.js",t.onload=e,document.head.appendChild(t)}}start(){this.loadPolyfillIfNeeded((()=>{const e={root:this.rootElement,rootMargin:"0px",threshold:1};this.observer=new IntersectionObserver(((e,t)=>{this.trigger(e,t)}),e),this.observer.observe(this.triggerElement),this.observing=!0,console.log("infinite scroll ready...")}))}async trigger(e,t){for(let t=0;t<e.length;t++){const n=e[t];!1===this.isLoading&&n.isIntersecting&&n.intersectionRatio>=.75&&(this.isLoading=!0,this.observer.unobserve(this.triggerElement),this.containerElement.append(await this.getItems()),this.triggerElement=this.containerElement.lastElementChild,this.observing&&this.observer.observe(this.triggerElement),this.isLoading=!1)}}}!function(e){var t=document.cookie.match(new RegExp("(^| )"+e+"=([^;]+)"));if(t)t[2]}("XSRF-TOKEN");function t(e){return"#"==e.charAt(0)?document.querySelector(e):document.querySelectorAll(e)}function n(e){const t=function(e){switch(e.media){case"tulisan":if(null!=e.thumbnail)return`<img src="${e.thumbnail}" alt="thumbnail ${e.title}" width="100%" height="auto">`;break;case"podcast":if(-1!=e.url.indexOf("https://anchor.fm")||-1!=e.url.indexOf("https://anchor.fm"))return`<iframe loading="lazy" src="${e.url.replace("episodes","embed/episodes")}" height="102px" width="100%" frameborder="0" scrolling="no"></iframe>`;break;case"video":if(-1!=e.url.indexOf("https://youtube.com/playlist")||-1!=e.url.indexOf("https://www.youtube.com/playlist"))return`<iframe loading="lazy" width="100%" height="315" src="${e.url.replace("/playlist?list=","/embed/videoseries?list=")}" frameborder = "0" allow = "accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe >`;if(-1!=e.url.indexOf("https://youtube.com")||-1!=e.url.indexOf("https://www.youtube.com"))return`<iframe loading="lazy" width="100%" height="315" src="${e.url.replace("watch?v=","embed/")}" frameborder = "0" allow = "accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe >`;break;default:return""}}(e),n=document.createElement("li");return n.innerHTML=`\n            <article class="media">\n                <div class="media-content">\n                    <div class="level is-mobile mb-2">\n                        <div class="level-left">\n                            <figure class="image is-32x32 is-inline-block">\n                            <img class="is-rounded" alt="foto profil ${e.user.username}" loading="lazy" src="${e.user.avatar_url}">\n                            </figure> \n                            <small class="is-size-7 ml-2">\n                                <strong> ${null!=e.owner?e.owner:""} · </strong>  ${e.published_diff} <br>\n                                <span>Dimasukkan oleh: ${e.user.fullname} @${e.user.username}</span>\n                            </small>  \n                        </div>\n                    </div>\n\n                    <div class="content">\n                        <h2 class="is-size-4 mb-1"> <a href="${e.url}" target="_blank"> ${e.title} </a></h2>\n                        <p>${e.body.substring(0,150)}</p>\n\n                        ${null!=t?t:""}\n\n                        <p class="is-size-7">\n                            <span class="tag is-info is-light"> ${e.media} </span>\n                        </p>\n                    </div>\n                </div>\n            </article>`,n.className="box",n}function i(e){var t=document.cookie.match(new RegExp("(^| )"+e+"=([^;]+)"));if(t)return t[2]}window.addEventListener("load",(()=>{!function(){let r=1,s=999;const a=t("#timeline"),o=t("#main-container"),l=new e(o,a);l.getItems=async function(){const e=document.querySelector("#loading-bar"),t=document.createDocumentFragment();if(s<=r)console.log("Observer stop"),l.observing=!1;else{e.className="loading",r++;const a=await async function(e){const t=new URL(window.location.href),n={page:e,type:"json"};t.search=new URLSearchParams(n).toString();const r=await fetch(t,{credentials:"same-origin",headers:{"Content-Type":"application/json","X-XSRF-TOKEN":i("XSRF-TOKEN")}});return await r.json()}(r);if(a.data){s=parseInt(a.meta.last_page);for(let e=0;e<a.data.length;e++){const i=n(a.data[e]);t.appendChild(i)}}e.className=""}return t},l.start()}()}))}();
