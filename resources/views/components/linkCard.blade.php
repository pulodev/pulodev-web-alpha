<div class="box">
    <article class="media">
        <div class="media-left">
            <x-avatar :user="$link->user"/>
        </div>
        
        <div class="media-content">
            <div class="content">
                <small class="is-size-7">
                    @if(!empty($link->owner) && $link->owner != '-')  {{$link->owner}} - @endif
                    {{$link->original_published_at->diffForHumans()}} 
                </small> 

                <h2 class="mt-1 is-size-4"> <a href="{{$link->url}}" target="_blank"> {{$link->title}} </a></h2>
                <p>{{cutText($link->body, 150)}}</p>
                
                @switch($link->media)
                    @case('tulisan')
                        @if ($link->thumbnail != '') 
                            <img src="{{$link->thumbnail}}" alt="thumbnail {{$link->title}}">  
                        @endif
                        @break
                    @case('podcast')
                        @if((strpos($link->url, 'https://anchor.fm') !== false) || (strpos($link->url, 'https://www.anchor.fm') !== false))
                            @php $anchorLink = str_replace('episodes', 'embed/episodes', $link->url) @endphp
                            <iframe src="{{$anchorLink}}" height="102px" width="100%" frameborder="0" scrolling="no"></iframe>
                        @endif
                        @break
                    @case('video')
                        @if((strpos($link->url, 'https://youtube.com') !== false) || (strpos($link->url, 'https://www.youtube.com') !== false))
                            @php $youtubeLink = str_replace('watch?v=', 'embed/', $link->url) @endphp
                            <iframe width="100%" height="315" src="{{$youtubeLink}}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        @endif
                        @break    
                    @default
                @endswitch


                <p class="is-size-7">
                    <span>Dimasukkan oleh: {{$link->user->fullname .' @'.$link->user->username }}</span>
                        <br><br>
                    <span class="tag is-info is-light"> {{$link->media}} </span>
                    <x-tags :tags="$link->tags" /> 
                </p>
            </div>
        </div>
    </article>
</div>