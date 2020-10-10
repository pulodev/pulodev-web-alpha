<div class="control">
    <div class="label">Media</div>
    <label class="radio"> <input type="radio" name="media" id="media-tulisan" value="tulisan" checked> Tulisan </label>
    <label class="radio"> <input type="radio" name="media" id="media-video" value="video"> Video </label>
    <label class="radio"> <input type="radio" name="media" id="media-podcast" value="podcast"> Podcast </label>
    <label class="radio"> <input type="radio" name="media" id="media-web" value="web"> Web </label>
</div>

{{-- check media from db --}}
@isset($object)
    <script> $('#media-{{$object->media}}').checked = true </script>    
@endisset
