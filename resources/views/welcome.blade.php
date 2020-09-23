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
            
            <form class="" action="/search" method="GET">
                <input type="search" class="input" name="query" placeholder="cari...">
            </form>

        </div>
    </div>
</section>

<div class="container">
        <h3 class="is-size-3">Link</h3>
        @foreach ($links as $link)
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
                            Dibuat {{$link->created_at->diffForHumans()}} <br>
                            Kategori: {{$link->tags}}
                        </p>
                    </div>
                    </div>
                </article>
            </a>
        @endforeach

        <div>
            {{ $links->links('pagination.default') }}
        </div>
</div>
</div>

@endsection