import InfiniteScroll from './infinite-scroll.js';
import {$} from './helper.js';
window.addEventListener('load', () =>{
    initInfiniteScroll();

    document.querySelectorAll('article .content a.media').forEach(el =>{
        el.addEventListener('click',e =>{
            e.preventDefault();
            const href = el.getAttribute('href');
            playMedia(href,el);
        })
    });
    document.getElementById('filterTag').addEventListener('click', function(){
        window.location.href = "/tag/" + document.getElementById('tag-query').value;
    })
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

function getMediaPlayer(link) {
    switch (link.media) {
        case('tulisan'):
            return `<a class="button my-2" href="${link.url}"> Baca Artikel</a>`
        break;
        case ('podcast'):
            return `<a class="button is-large is-rounded is-success media"
                        href="${link.url}"> Dengar Podcast </a>`
        break;
        case ('video'):
            return `<a class="button is-large is-rounded is-danger media" 
                        href="${link.url}"> Nonton Video </a>`
        break;
        default:
            return '';
            break;
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

function playMedia(url, item) {
    item.classList.add('is-loading')
    let player = '';

    if ((url.indexOf('https://anchor.fm') != -1) || (url.indexOf('https://anchor.fm') != -1)) {
        const anchorLink = url.replace('episodes', 'embed/episodes');
        player = `<iframe src="${anchorLink}" height="102px" width="100%" frameborder="0" scrolling="no"></iframe>`;
    }
    else if ((url.indexOf('https://youtube.com/playlist') != -1) || url.indexOf('https://www.youtube.com/playlist') != -1) {
        let youtubeLink = url.replace('/playlist?list=', '/embed/videoseries?list=');
        player = `<iframe width="100%" height="315" src="${youtubeLink}" frameborder = "0" allow = "accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`;
    } else if ((url.indexOf('https://youtube.com') != -1) || url.indexOf('https://www.youtube.com') != -1) {
        let youtubeLink = url.replace('watch?v=', 'embed/');
        player = `<iframe width="100%" height="315" src="${youtubeLink}" frameborder = "0" allow = "accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`;
    } else {
        //for now just redirect to original source
        window.location.href = url;
    }

    setTimeout(function(){ item.parentElement.innerHTML = player; }, 1000);
}