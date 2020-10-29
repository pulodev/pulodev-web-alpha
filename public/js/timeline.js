(function () {
    'use strict';

    class InfiniteScroll {
        constructor(rootElement,containerElement){
            this.rootElement = rootElement;
            this.containerElement = containerElement;
            this.triggerElement = containerElement.lastElementChild;
            this.getItems = () =>{};
            this.isLoading = false;
            this.observer = null;
            this.observing = false;
        }

        loadPolyfillIfNeeded(callback){
            if ('IntersectionObserver' in window &&
                'IntersectionObserverEntry' in window &&
                'intersectionRatio' in window.IntersectionObserverEntry.prototype) {
                 callback();
            } else {
                const polyfill = document.createElement('script');
                polyfill.src = '/js/intersection-observer.js';
                polyfill.onload = callback;
                document.head.appendChild(polyfill);
            }
        }


        start(){
            this.loadPolyfillIfNeeded(() =>{
                const options = {
                    root: this.rootElement,
                    rootMargin: '0px',
                    threshold: 1.0
                  };
                  
                  this.observer = new IntersectionObserver((entries, observer) =>{
                      this.trigger(entries,observer);
                  }, options);
                  this.observer.observe(this.triggerElement);
                  this.observing = true;
                  console.log('infinite scroll ready...');
            });
        }

        async trigger(entries,observer){
            for (let i = 0; i < entries.length; i++) {
                const entry = entries[i];
                if (this.isLoading === false && entry.isIntersecting && entry.intersectionRatio >= 0.75) {
                    //load the next page to container
                    this.isLoading = true;
                    this.observer.unobserve(this.triggerElement);
                    this.containerElement.append(await this.getItems());
                    this.triggerElement = this.containerElement.lastElementChild;
                    if(this.observing)
                        this.observer.observe(this.triggerElement);
                    this.isLoading = false;
                }
            }
                
              
        }
    }

    const headers ={
        'Content-Type': 'application/json',
        'X-XSRF-TOKEN': getCookie('XSRF-TOKEN'),
        'X-Requested-With' : 'XMLHttpRequest'
        };
        
    function $(el) {
        return (el.charAt(0) == "#")
            ? document.querySelector(el)
            : document.querySelectorAll(el)
    }

    function getCookie(name) {
        var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
        if (match) return match[2];
    }

    window.addEventListener('load', () =>{
        initInfiniteScroll();
    });

    function initInfiniteScroll(){
        let page = 1;
        let lastPage = 999;
        const container = $('#timeline');
        const root = $('#main-container');

        const infScroll = new InfiniteScroll(root,container);
        infScroll.getItems = async function(){
            const loadingBar=document.querySelector('#loading-bar');
            
            const fragment = document.createDocumentFragment();
            
            if(lastPage<=page){
                console.log('Observer stop');
                infScroll.observing = false;
            } else {
                loadingBar.className='loading';
                page++;
                const contents = await getContents(page);
                if(contents.data){
                    lastPage = parseInt(contents.meta.last_page);
                    for (let i = 0; i < contents.data.length; i++) {
                        const link = contents.data[i];
                        const item = renderItem(link.slug,link.title,link.user.username,link.user.avatar_url,link.published_diff,link.user.fullname,link.media);
                        fragment.appendChild(item);
                    }
                }
                loadingBar.className='';
            }
            
            return fragment;
        };

        infScroll.start();
    }

    function renderItem(slug,title,username,avatarUrl,timeAgo,fullName,type){
        const item = document.createElement('li');
            item.innerHTML=`
            <a href="/link/${slug}">
                <article class="media">
                    <div class="media-left">
                        <figure class="image is-64x64 is-inline-block">
                            <img class="is-rounded" alt="foto profil ${username}" loading="lazy" src="${avatarUrl}">
                        </figure> 
                    </div>
                    
                    <div class="media-content">
                        <div class="content">
                            <small class="is-size-7">
                                ${timeAgo}
                            </small> 

                            <p class="is-size-4 mb-1"><strong>${title}</strong></p>

                            <p class="is-size-7">
                                <span>Dimasukkan oleh: ${fullName} @${username}</span>
                                    <br><br>
                                <span class="tag is-info is-light"> ${type} </span>
                                
                            </p>
                        </div>
                    </div>
                </article>
            </a>`;
            item.className = 'box';
            return item;
    }


    async function getContents(page){
        const url = new URL(window.location.href);
        const params = {page:page,type:'json'}; 

        url.search = new URLSearchParams(params).toString();
        const resp = await fetch(url,{
            credentials: 'same-origin',
            headers: {
            'Content-Type': 'application/json',
            'X-XSRF-TOKEN': getCookie$1('XSRF-TOKEN')
            }
        });

        return await resp.json();
    }

    function getCookie$1(name) {
        var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
        if (match) return match[2];
      }

}());
