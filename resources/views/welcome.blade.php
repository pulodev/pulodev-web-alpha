@extends('layouts.app')

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
        <div class="column is-four-fifths">
            
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
            <div class="button is-small" onclick="filterTag()">Submit</div>

            <br><br>

            <p>Pilih Media</p>
            <a href='/' class="tag">Semua</a>
            <a href='/media/tulisan' class="tag">Tulisan</a>
            <a href='/media/video' class="tag">Video</a> <br>
            <a href='/media/web' class="tag">Web</a>
            <a href='/media/podcast' class="tag">Podcast</a>

            <script>
                function filterTag() { window.location.href = "/tag/" + $('#tag-query').value  }
            </script>
        </div>
    </div>    
</div>

@endsection