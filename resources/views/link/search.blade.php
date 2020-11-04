@extends('layouts.app')

@section('title', 'Cari di PuloDev')
@section('desc', 'Mencari konten di PuloDev')
@section('content')

@push('scripts')
    <script src="/js/timeline.js" type="module"></script>
    <script>
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
            player = '';
        }

        setTimeout(function(){ item.parentElement.innerHTML = player; }, 1000);
    }
    </script>
@endpush

<section class="hero">
    <div class="hero-body">
        <div class="container has-text-centered">
            <h1 class="title"> Mencari "{{$querySearch}}" </h1>
            
             <div class="columns is-centered">
                <div class="column is-half">
                <form class="columns is-mobile is-gapless" action="/search" method="GET">
                    <div class="column is-four-fifths">
                        <input class="input" type="text" placeholder="Cari Konten.." name="query">
                    </div>
                    <div class="column is-one-fifth">
                        <input type="submit" class="button is-info is-fullwidth" value="Cari">
                    </div>
                </form>
                </div>
            </div>      
        </div>
    </div>
</section>

<div class="container">
    @forelse ($links as $link)
        <x-linkCard :link="$link" />
    @empty
        <p>Oops. Mohon maaf pencarian ini tidak ditemukan</p>    
    @endforelse
</div>

@endsection