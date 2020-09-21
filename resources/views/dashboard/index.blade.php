@extends('layouts.app')

@section('title', 'Welcome')
@section('desc', 'Welcome koding .club')
@section('content')

<section class="hero is-primary">
    <div class="hero-body">
        <div class="container">
            <h1 class="title">
                Dashboard Admin
            </h1>

            @if (Auth::check())
                <p class="subtitle">Halo {{Auth::user()->username}} </p>
            @endif
        </div>
    </div>
</section>

<div class="container">
        <h3 class="is-size-3">Link Masih Draft</h3>
        @foreach ($links as $link)
            <a class="box" href='/link/{{$link->slug}}/edit'>
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
            {{ $links->links() }}
        </div>
</div>
</div>

@endsection