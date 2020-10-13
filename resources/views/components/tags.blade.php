@php
$tags = explode(',', $tags);
@endphp

@foreach ($tags as $tag)
    @php
        $tag = strtolower(str_replace(' ', '-', preg_replace('!\s+!', ' ', trim($tag)))); //normalize tag 
    @endphp
 
    @if(trim($tag) != '')
        @isset($asLink) 
            <a href='/tag/{{$tag}}' class="tag"> #{{$tag}}</span> </a>
        @else
            <span class="tag"> #{{$tag}}</span>
        @endisset
    @endif
@endforeach