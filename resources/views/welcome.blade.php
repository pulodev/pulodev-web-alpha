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
        </div>
    </div>
</section>

<div class="container">
    <div class="columns mt-1">
        <div class="column is-four-fifths">
           
            @forelse ($links as $link)
                <x-linkCard :link="$link" />
            @empty
                <p>Oops. Mohon maaf konten ini masih kosong</p>    
            @endforelse

            <div>
                {{ $links->links('pagination.default') }}
            </div>
        </div>

        <div class="column">
            @isset($type) <p>Filter {{$type}} : {{$query}} </p> @endisset
            
            <br>
            <form class="" action="/search" method="GET">
                <input type="search" class="input" name="query" placeholder="berdasrakan judul">
                <input type="submit" value="Cari" class="button is-small">
            </form>

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