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
            
            @switch($link->media)
                @case('tulisan')
                    @if ($link->thumbnail != '') 
                        <img src="{{$link->thumbnail}}" alt="thumbnail {{$link->title}}" width="100%" height="auto">  
                    @endif
                    @break
                @case('podcast')
                    @if((strpos($link->url, 'https://anchor.fm') !== false) || (strpos($link->url, 'https://www.anchor.fm') !== false))
                        @php $anchorLink = str_replace('episodes', 'embed/episodes', $link->url) @endphp
                        <iframe loading="lazy" src="{{$anchorLink}}" height="102px" width="100%" frameborder="0" scrolling="no"></iframe>
                    @endif
                    @break
                @case('video')
                    @if((strpos($link->url, 'https://youtube.com/playlist') !== false) || (strpos($link->url, 'https://www.youtube.com/playlist') !== false))    
                        @php $youtubeLink = str_replace('/playlist?list=', '/embed/videoseries?list=', $link->url) @endphp
                        <iframe loading="lazy" width="100%" height="315" src="{{$youtubeLink}}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    @elseif((strpos($link->url, 'https://youtube.com') !== false) || (strpos($link->url, 'https://www.youtube.com') !== false))
                        @php $youtubeLink = str_replace('watch?v=', 'embed/', $link->url) @endphp
                        <iframe loading="lazy" width="100%" height="315" src="{{$youtubeLink}}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    @endif
                    
                    @break    
                @default
            @endswitch


            <p class="is-size-7">
                <span class="tag is-info is-light"> {{$link->media}} </span>
                <x-tags :tags="$link->tags" /> 
            </p>
        </div>
    </div>
</article>