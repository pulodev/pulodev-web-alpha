@extends('layouts.app')

@section('title')
  {{ $link->title }}
@endsection

@section('desc')
    {{ cutText($link->title, 150) }}
@endsection

@section('content')

<section class="hero is-info">
    <div class="hero-body">
        <div class="container">
            <h1 class="title">
                {{ $link->title }}
            </h1>
            <div class="subtitle">
                @if ($link->draft) [Status: draft - Tunggu konfirmasi] @endif
            </div>
        </div>
    </div>
</section>

<div class="columns is-marginless">
    <div class="column is-two-thirds">
        <div class="card">
            <div class="card-content">
                <div>{!! Purify::clean($link->body) !!}</div>
                
                <p class="my-2">Source: <a href="{{$link->url}}">{{$link->url}}</a></p>

                <footer class="media mt-2">
                    <figure class="media-left">
                        <p class="image">
                        <img src="{{ getAvatar($link->user) }}" alt="foto profil {{$link->user->username}}" width="50">
                        </p>
                    </figure>
                    <div>
                        <p><a href="/{{'@'.$link->user->username}}"> Dimasukkan oleh {{'@'. $link->user->username}}</a>
                            @isset($link->twitter_owner), milik {{$link->twitter_owner}} @endisset
                        </p>
                        <p class="is-size-7">Kategori: {{$link->tags}}</p>
                    </div>
                </footer>
            </div>
        </div>
    </div>
</div>

@if (Auth::user())
    @if (Auth::user()->id === $link->user->id)
        <div class="buttons">
             <a class="button is-primary is-light" href="/link/{{$link->slug}}/edit">Edit</a>
             <form method="POST" action="/link/{{$link->slug}}">
                @csrf
                @method('DELETE')
                <input type="submit" class="button is-danger is-light" href="/link/{{$link->slug}}/delete" value="Hapus">
             </form>
        </div>
    @endif
@endif

@endsection