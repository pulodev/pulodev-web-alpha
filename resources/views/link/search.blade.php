@extends('layouts.app')

@section('title', 'Welcome')
@section('desc', 'Welcome koding .club')
@section('content')

<section class="hero">
    <div class="hero-body">
        <div class="container has-text-centered">
            <h1 class="title"> Mencari "{{$querySearch}}" </h1>
            
            <form class="" action="/search" method="GET">
                <input type="search" class="input" name="query" placeholder="cari...">
            </form>
        </div>
    </div>
</section>

<div class="container">
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
</div>

@endsection