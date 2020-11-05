<article class="media">
    <div class="media-content">
        <div class="level is-mobile mb-2">
            <div class="level-left">
                <x-avatar :user="$link->user"/> 
                <small class="is-size-7 ml-2">
                    @if(!empty($link->owner) && $link->owner != '-') <strong> {{$link->owner}} </strong> · @endif
                    {{$link->original_published_at->diffForHumans()}}  <br>
                    <span>Dimasukkan oleh {{$link->user->fullname .' @'.$link->user->username }}</span>
                </small>  
                </div>
        </div>

        <div class="content">
            <h2 class="is-size-4 mb-1"> <a href="{{$link->url}}" target="_blank"> {{$link->title}} </a></h2>
            <p>{{cutText($link->body, 150)}}</p>
            
            
            <div class="media-player is-{{$link->media}} {{$link->thumbnail ? 'has-thumbnail' : 'no-thumbnail'}}">
                @if ($link->thumbnail != '') 
                    <img lazy="loading" src="{{$link->thumbnail}}" alt="thumbnail {{$link->title}}" width="100%" height="auto">  
                @endif

                @switch($link->media)
                    @case('tulisan')
                        <a class="button my-2" href="{{$link->url}}">Baca Artikel</a>
                        @break
                    @case('podcast')
                        <a class="button is-large is-rounded is-success media" 
                        href="{{$link->url}}">Dengar Podcast</a>
                        @break
                    @case('video')
                        <a class="button is-large is-rounded is-danger media"
                        href="{{$link->url}}">Nonton Video</a>
                        @break
                    @default                    
                @endswitch
            </div>

            <p class="is-size-7">
                <span class="tag is-info is-light"> {{$link->media}} </span>
                <x-tags :tags="$link->tags" /> 
            </p>
        </div>
    </div>
</article>