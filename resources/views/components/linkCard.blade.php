<a href='/link/{{$link->slug}}'>
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

                <p class="is-size-4 mb-1"><strong> {{$link->title}}</strong></p>

                <p class="is-size-7">
                    <span>Dimasukkan oleh: {{$link->user->fullname .' @'.$link->user->username }}</span>
                        <br><br>
                    <span class="tag is-info is-light"> {{$link->media}} </span>
                    <x-tags :tags="$link->tags" /> 
                </p>
            </div>
        </div>
    </article>
</a>