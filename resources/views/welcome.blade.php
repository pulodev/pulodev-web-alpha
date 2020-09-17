@extends('layouts.app')

@section('title', 'Welcome')
@section('desc', 'Welcome koding .club')
@section('content')

<section class="hero is-primary">
    <div class="hero-body">
        <div class="container">
            <h1 class="title">
                Welcome
            </h1>

            @if (Auth::check())
                <p>Halo {{Auth::user()->username}} </p>
            @endif
        </div>
    </div>
</section>

<div class="container mt-2">
    @foreach ($threads as $thread)
        <a class="box" href='/{{$thread->slug}}'>
            <article class="media">
                <div class="media-left">
                <figure class="image is-64x64">
                    <img src="https://bulma.io/images/placeholders/128x128.png" alt="Image">
                </figure>
                </div>
                <div class="media-content">
                <div class="content">
                    <p>
                    <strong>{{$thread->user->fullname}}</strong> <small>{{'@'.$thread->user->username}}</small> 
                    <br>
                    {{$thread->title}}
                    </p>
                    <p class="is-size-7">Kategori: {{$thread->tags}}</p>
                </div>
                </div>
            </article>
        </a>
    @endforeach

    <div>
        {{ $threads->links() }}
    </div>
</div>

@endsection