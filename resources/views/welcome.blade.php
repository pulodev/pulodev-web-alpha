@extends('layouts.app')

@section('title', 'PuloDev - Selamat Datang!')
@section('desc', 'PuloDev adalah komunitas online programmer Indonesia. Tempat berkumpul terlepas dari bahasa program atau asal kota kamu.')
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
            <h2 class="subtitle">Tempat berkumpul programmer Indonesia. Baca <a href="/info/about"> tentang kami</a></h2>
        </div>
    </div>
</section>

<div class="container">
    <div class="columns mt-1">
        <div class="column is-four-fifths">
            @forelse ($links as $link)
                <a class="box" href='/link/{{$link->slug}}'>
                    <article class="media">
                        <div class="media-left">
                            <x-avatar :user="$link->user"/>
                        </div>
                        
                        <div class="media-content">
                            <div class="content">
                                <small> {{$link->user->fullname .' @'.$link->user->username }}
                                        - {{$link->original_published_at->diffForHumans()}}
                                </small> 
                                <br>
                                
                                <p><strong> {{$link->title}}</strong></p>

                                <p class="is-size-7">
                                    <span class="tag is-info is-light"> {{$link->media}} </span>
                                    <x-tags :tags="$link->tags" /> 
                                </p>
                            </div>
                        </div>
                    </article>
                </a>
            @empty
                <p>Oops. Mohon maaf konten ini masih kosong</p>    
            @endforelse

            <div>
                {{ $links->links('pagination.default') }}
            </div>
        </div>

        <div class="column">
            @isset($type) <p>Filter {{$type}} : {{$query}} </p> @endisset
            
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