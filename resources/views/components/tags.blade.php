<?php
$tags = explode(',', $tags);
?>

@foreach ($tags as $tag)
    @if(trim($tag) != '')
    <span class="tag"> #{{$tag}}</span>
    @endif
@endforeach