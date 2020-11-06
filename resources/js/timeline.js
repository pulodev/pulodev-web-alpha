import InfiniteScroll from './infinite-scroll.js';

import {$} from './helper.js';
window.addEventListener('load', () =>{
    initInfiniteScroll();

    document.querySelectorAll('article .content a.media').forEach(el =>{
        el.addEventListener('click',e =>{
            e.preventDefault();
            const href = el.getAttribute('href');
            playMedia(href,el);
        });
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
            return `<a class="button is-large is-rounded is-success"
                        onclick="playMedia('${link.url}', this)"> Dengar Podcast </a>`
        break;
        case ('video'):
            return `<a class="button is-large is-rounded is-danger"
                        onclick="playMedia('${link.url}', this)"> Nonton Video </a>`
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
            <content-card
                username="${link.user.username}"
                fullname="${link.user.fullname}"
                avatar_url="${link.user.avatar_url}"
                owner="${link.owner}"
                published_diff="${link.published_diff}"
                url="${link.url}"
                title="${link.title}"
                body="${link.body}"
                thumbnail="${link.thumbnail!==null?link.thumbnail:''}"
                media="${link.media}"
            ></content-card>
            `;
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