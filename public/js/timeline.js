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
                        const item = renderItem(link);
                        fragment.appendChild(item);
                    }
                }
                loadingBar.className='';
            }
            
            return fragment;
        };

        infScroll.start();
    }

    function getMediaPlayer(link) {
        switch (link.media) {
            case('tulisan'):
                return `<a class="button my-2" href="${link.url}"> Baca Artikel</a>`
            case ('podcast'):
                return `<div class="button is-large is-rounded is-success"
                        onclick="playMedia('${link.url}', this)"> Dengar Podcast </div>`
            case ('video'):
                return `<div class="button is-large is-rounded is-danger"
                        onclick="playMedia('${link.url}', this)"> Nonton Video </div>`
            default:
                return '';
        }
    }


    function renderItem(link){
        const mediaPlayer = getMediaPlayer(link);

        const item = document.createElement('li');
            item.innerHTML=`
            <article class="media">
                <div class="media-content">
                    <div class="level is-mobile mb-2">
                        <div class="level-left">
                            <figure class="image is-32x32 is-inline-block">
                            <img class="is-rounded" alt="foto profil ${link.user.username}" loading="lazy" src="${link.user.avatar_url}">
                            </figure> 
                            <small class="is-size-7 ml-2">
                                <strong> ${(link.owner != null) ? link.owner : ''} · </strong>  ${link.published_diff} <br>
                                <span>Dimasukkan oleh: ${link.user.fullname} @${link.user.username}</span>
                            </small>  
                        </div>
                    </div>

                    <div class="content">
                        <h2 class="is-size-4 mb-1"> <a href="${link.url}" target="_blank"> ${link.title} </a></h2>
                        <p>${link.body.substring(0, 150)}</p>

                        <div class="media-player is-${link.media} ${(link.thumbnail) ? 'has-thumbnail' : 'no-thumbnail'}">
                           ${(link.thumbnail != null) 
                                 ? `<img lazy="loading" src="${link.thumbnail}" alt="thumbnail ${link.title}" width="100%" height="auto">`  
                                 : ''
                            }
                        
                            ${(mediaPlayer != undefined) ? mediaPlayer : ''}
                        </div>

                        <p class="is-size-7">
                            <span class="tag is-info is-light"> ${link.media} </span>
                        </p>
                    </div>
                </div>
            </article>`;
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
