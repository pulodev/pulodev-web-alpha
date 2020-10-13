<?php
$tags = explode(',', $tags);
?>

@foreach ($tags as $tag)
    @if(trim($tag) != '')
        @isset($asLink) 
            <a href='/tag/{{$tag}}' class="tag"> #{{$tag}}</span> </a>
        @else
            <span class="tag"> #{{$tag}}</span>
        @endisset
    @endif
@endforeach