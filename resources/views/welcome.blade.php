@extends('layouts.app')

@section('title', 'Welcome')
@section('desc', 'Welcome koding .club')
@section('content')

@if (Auth::user())
    @if (Auth::user()->email_verified_at == NULL)
    <div class="notification is-warning">
        Kamu belum verifikasi email. Silahkan cek email dan verifikasi untuk bisa mulai memposting konten
    </div>
    @endif
@endif

<section class="hero is-primary">
    <div class="hero-body">
        <div class="container">
            <h1 class="title">
                Komunitas programmer Indonesia
            </h1>

            @if (Auth::check())
                <p class="subtitle">Halo {{Auth::user()->username}} </p>
            @endif

            @isset($type) <p>Filter {{$type}} : {{$query}} </p> @endisset
            
            
            <form class="" action="/search" method="GET">
                <input type="search" class="input" name="query" placeholder="cari...">
            </form>

        </div>
    </div>
</section>

<div class="container">
    <div class="columns mt-1">
        <div class="column is-two-thirds">
            @forelse ($links as $link)
                <a class="box" href='/link/{{$link->slug}}'>
                    <article class="media">
                        <div class="media-left">
                        <figure class="image is-64x64">
                            <img src="{{ getAvatar($link->user) }}" alt="foto profil {{$link->user->username}}" width="100">
                        </figure>
                        </div>
                        <div class="media-content">
                        <div class="content">
                            <p>Dimasukkan oleh {{$link->user->fullname .' @'.$link->user->username }}</small> 
                            <br>
                            <strong> {{$link->title}}</strong>
                            </p>
                            <p class="is-size-7">
                                Dipublish {{$link->original_published_at->diffForHumans()}} <br>
                                Tag: {{$link->tags}}, Media: {{$link->media}}
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
            <p>Filter Media</p>
            <a href='/' class="button">Semua</a>
            <a href='/media/tulisan' class="button">Tulisan</a>
            <a href='/media/video' class="button">Video</a>
            <a href='/media/web' class="button">Web</a>
            <a href='/media/podcast' class="button">Podcast</a>
            <a href='/media/komunitas' class="button">Komunitas</a> 

            <br><br>

            <p>Filter Tag</p>
            <input type="search" class="input" id="tag-query" placeholder="contoh: javascript">
            <div class="button" onclick="filterTag()">Submit</div>

            <script>
                function filterTag() { window.location.href = "/tag/" + $('#tag-query').value  }
            </script>
        </div>
    </div>    
</div>

@endsection