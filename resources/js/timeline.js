import InfiniteScroll from './infinite-scroll.js';
import {$} from './helper.js';
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
    }

    infScroll.start();
}

function getLinkPlayer(link) {
    console.log('thumbnail : ' + link.title + ' - ' +  link.thumbnail);
    switch (link.media) {
        case 'tulisan':
            if (link.thumbnail != null) {
                console.log('there')
                return `<img src="${link.thumbnail}" alt="thumbnail ${link.title}" width="100%" height="auto">`  
            }  else {
                console.log('thumbnail not null, but: ' + typeof link.thumbnail)
            } 
            break;
        case 'podcast':
            if ((link.url.indexOf('https://anchor.fm') != -1) || (link.url.indexOf('https://anchor.fm') != -1)) {
                const anchorLink = link.url.replace('episodes', 'embed/episodes') 
                return `<iframe loading="lazy" src="${anchorLink}" height="102px" width="100%" frameborder="0" scrolling="no"></iframe>`
            }
            break;
        case 'video':
            if ((link.url.indexOf('https://youtube.com') != -1) || (link.url.indexOf('https://www.youtube.com') != -1)) {
                const youtubeLink = link.url.replace('watch?v=', 'embed/')
                return `<iframe loading="lazy" width="100%" height = "315" src = "${youtubeLink}" frameborder = "0" allow = "accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe >`
            }
            break;    
        default:
            return '';
            break;
    }
}


function renderItem(link){

    const linkPlayer = getLinkPlayer(link);

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

                        ${(linkPlayer != undefined) ? linkPlayer : ''}

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