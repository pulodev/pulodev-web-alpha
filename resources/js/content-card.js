export default class ContentCard extends HTMLElement{
    static get observedAttributes() {
        return [
            'username', 
            'fullname', 
            'avatar_url', 
            'owner',
            'published_diff',
            'url',
            'title',
            'body',
            'thumbnail',
            'media'
        ];
      }

    constructor(){
        super();
        this.username = '';
        this.fullname = '';
        this.avatar_url = '';
        this.owner = '';
        this.published_diff = '';
        this.url = '';
        this.title = '';
        this.body = '';
        this.thumbnail = '';
        this.media = '';

    }

    attributeChangedCallback(attrName, oldValue, newValue) {
        if(oldValue!=newValue){
            this[attrName] = newValue;
        }
        
      }

    connectedCallback() {
        this.innerHTML = this.renderItem();
        console.log(this.innerHTML);
        if(['tulisan','podcast','video'].includes(this.media))
            this.querySelector('a.media').addEventListener('click', this.playMedia);
    }
  
    disconnectedCallback() {
        this.querySelector('button').removeEventListener('click', this.close);
        this.querySelector('.overlay').removeEventListener('click', this.close);
    }  

    playMedia(e) {
        e.preventDefault();
        const item = e.srcElement;
        const href = item.getAttribute('href');
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

    renderItem(){
        let mediaPlayer = '';
        switch (this.media) {
            case('tulisan'):
                mediaPlayer = `<a class="media button my-2" href="${this.url}"> Baca Artikel</a>`;
                break;
            case ('podcast'):
                mediaPlayer = `<a class="media button is-large is-rounded is-success" onclick="playMedia('${this.url}', this)"> Dengar Podcast </a>`;
                break;
            case ('video'):
                mediaPlayer = `<a class="media button is-large is-rounded is-danger" onclick="playMedia('${this.url}', this)"> Nonton Video </a>`;
                break;
            default:
                mediaPlayer = '';
                break;
        }

        return `
                <article class="media">
                    <div class="media-content">
                        <div class="level is-mobile mb-2">
                            <div class="level-left">
                                <figure class="image is-32x32 is-inline-block">
                                <img class="is-rounded" alt="foto profil ${this.username}" loading="lazy" src="${this.avatar_url}">
                                </figure> 
                                <small class="is-size-7 ml-2">
                                ${(this.owner != '' && this.owner != '-')?
                                    `<strong> ${this.owner} · </strong>  ${this.published_diff} <br>`:''
                                }
                                    <span>Dimasukkan oleh: ${this.fullname} @${this.username}</span>
                                </small>  
                            </div>
                        </div>
    
                        <div class="content">
                            <h2 class="is-size-4 mb-1"> <a href="${this.url}" target="_blank"> ${this.title} </a></h2>
                            <p>${this.body.substring(0, 150)}</p>
    
                            <div class="media-player is-${this.media} ${(this.thumbnail) ? 'has-thumbnail' : 'no-thumbnail'}">
                               ${(this.thumbnail != '') 
                                     ? `<img lazy="loading" src="${this.thumbnail}" alt="thumbnail ${this.title}" width="100%" height="auto">`  
                                     : ''
                                }
                            
                                ${(mediaPlayer != undefined) ? mediaPlayer : ''}
                            </div>
    
                            <p class="is-size-7">
                                <span class="tag is-info is-light"> ${this.media} </span>
                            </p>
                        </div>
                    </div>
                </article>`;
    }
}

customElements.define('content-card', ContentCard);