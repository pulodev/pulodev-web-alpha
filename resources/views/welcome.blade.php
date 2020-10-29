@extends('layouts.app')

@push('scripts')
    <script src="/js/timeline.js" type="module"></script>
@endpush

@section('title')
PuloDev -@if($type != '') {{$type}} {{$query}}@else Selamat Datang @endif
@endsection

@section('desc')
PuloDev @if($type != ''){{$type}} {{$query}}@endif adalah kumpulan konten @if($type != ''){{$type}} {{$query}}@endif developer Indonesia. Tempat berkumpul terlepas dari bahasa program atau asal kota kamu, komunitas programmer Indonesia
@endsection

@section('content')

@if (Auth::user())
    @if (Auth::user()->email_verified_at == NULL)
    <div class="notification is-warning has-text-centered">
        Kamu belum verifikasi email. Silahkan cek email dan verifikasi untuk bisa mulai memposting konten
    </div>
    @endif
@endif

<section class="hero">
    <div class="hero-body">
        <div class="container has-text-centered">
            <h1 class="title"> @if (Auth::check()) Halo {{Auth::user()->username}}, @endif 
                Kenalkan PuloDev! </h1>
            <h2 class="subtitle">Kumpulan konten developer Indonesia. Baca <a href="/info/about"> tentang kami</a></h2>
            
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
    <div class="columns mt-1">
        <div class="column is-two-thirds">
            
            @if($type != 'tag' && $type != 'media')
            <p> 
                Urut berdasarkan:
                <a href="/order/original-time">waktu asli konten</a> |
                <a href="/">waktu submit</a>
            </p> <br>
            @endif
            <ul id="timeline">
            @forelse ($links as $link)
                <li class="box"><x-linkCard :link="$link" /></li>
            @empty
                <li>Oops. Mohon maaf konten ini masih kosong</li>    
            @endforelse
            </ul>
            <div id="loading-bar">
                <svg xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.0" width="128px" height="16px" viewBox="0 0 128 16" xml:space="preserve">
                <path fill="#949494" fill-opacity="0.42" d="M6.4,4.8A3.2,3.2,0,1,1,3.2,8,3.2,3.2,0,0,1,6.4,4.8Zm12.8,0A3.2,3.2,0,1,1,16,8,3.2,3.2,0,0,1,19.2,4.8ZM32,4.8A3.2,3.2,0,1,1,28.8,8,3.2,3.2,0,0,1,32,4.8Zm12.8,0A3.2,3.2,0,1,1,41.6,8,3.2,3.2,0,0,1,44.8,4.8Zm12.8,0A3.2,3.2,0,1,1,54.4,8,3.2,3.2,0,0,1,57.6,4.8Zm12.8,0A3.2,3.2,0,1,1,67.2,8,3.2,3.2,0,0,1,70.4,4.8Zm12.8,0A3.2,3.2,0,1,1,80,8,3.2,3.2,0,0,1,83.2,4.8ZM96,4.8A3.2,3.2,0,1,1,92.8,8,3.2,3.2,0,0,1,96,4.8Zm12.8,0A3.2,3.2,0,1,1,105.6,8,3.2,3.2,0,0,1,108.8,4.8Zm12.8,0A3.2,3.2,0,1,1,118.4,8,3.2,3.2,0,0,1,121.6,4.8Z"/><g>
                <path fill="#000000" fill-opacity="1" d="M-42.7,3.84A4.16,4.16,0,0,1-38.54,8a4.16,4.16,0,0,1-4.16,4.16A4.16,4.16,0,0,1-46.86,8,4.16,4.16,0,0,1-42.7,3.84Zm12.8-.64A4.8,4.8,0,0,1-25.1,8a4.8,4.8,0,0,1-4.8,4.8A4.8,4.8,0,0,1-34.7,8,4.8,4.8,0,0,1-29.9,3.2Zm12.8-.64A5.44,5.44,0,0,1-11.66,8a5.44,5.44,0,0,1-5.44,5.44A5.44,5.44,0,0,1-22.54,8,5.44,5.44,0,0,1-17.1,2.56Z"/><animateTransform attributeName="transform" type="translate" values="23 0;36 0;49 0;62 0;74.5 0;87.5 0;100 0;113 0;125.5 0;138.5 0;151.5 0;164.5 0;178 0" calcMode="discrete" dur="1170ms" repeatCount="indefinite"/></g></svg>
            </div>
            <noscript>
            <div>
                {{ $links->links('pagination.default') }}
            </div>
            </noscript>
        </div>

        <div class="column">
            @if($type != '') <p>Filter {{$type}} : {{$query}} </p> @endisset

            <br>

            <p>Pilih Tag/Kategori</p>
            <input type="search" class="input" id="tag-query" placeholder="contoh: javascript">
            <div class="button is-small" id="filterTag">Submit</div>

            <br><br>

            <p>Pilih Media</p>
            <a href='/' class="tag">Semua</a>
            <a href='/media/tulisan' class="tag">Tulisan</a>
            <a href='/media/video' class="tag">Video</a> <br>
            <a href='/media/web' class="tag">Web</a>
            <a href='/media/podcast' class="tag">Podcast</a>

            <script type="module">
                document.getElementById('filterTag').addEventListener('click', function(){
                    window.location.href = "/tag/" + document.getElementById('tag-query').value
                })
            </script>
        </div>
    </div>    
</div>

@endsection