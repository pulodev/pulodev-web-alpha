import InfiniteScroll from './infinite-scroll.js';

window.$ = function $(el) {
    return (el.charAt(0) == "#")
        ? document.querySelector(el)
        : document.querySelectorAll(el)
}

//axios
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.onload = () =>{
    initInfiniteScroll();
}

function initInfiniteScroll(){
    let page = 1;
    let lastPage = 999;
    const container = $('#timeline');
    const root = $('#main-container');

    const infScroll = new InfiniteScroll(root,container);
    infScroll.getItems = async function(){
        const fragment = document.createDocumentFragment();
        
        if(lastPage<=page){
            infScroll.stop();
        } else {
            page++;
            const contents = await getContents(page);
            if(contents.data){
                lastPage = parseInt(contents.meta.last_page);
                for (let i = 0; i < contents.data.length; i++) {
                    const link = contents.data[i];
                    const item = renderItem(link.url,link.title,link.user.username,link.user.avatar_url,link.published_diff,link.user.fullname,link.media);
                    fragment.appendChild(item);
                }
            }
        }
        return fragment;
    }

    infScroll.start();
}

function renderItem(url,title,username,avatarUrl,timeAgo,fullName,type){
    const item = document.createElement('li');
        item.innerHTML=`
            <a href="${url}">
                <article class="media">
                    <div class="media-left">
                        <figure class="image is-64x64 is-inline-block">
                            <img class="is-rounded" alt="foto profil ${username}" src="${avatarUrl}">
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
    const url = new URL(window.location.href)
    const params = {page:page,type:'json'} 

    url.search = new URLSearchParams(params).toString();
    const resp = await fetch(url,{
        credentials: 'same-origin',
        headers: {
        'Content-Type': 'application/json',
        'X-XSRF-TOKEN': getCookie('XSRF-TOKEN')
        }
    });

    return await resp.json();
}

function getCookie(name) {
    var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
    if (match) return match[2];
  }
