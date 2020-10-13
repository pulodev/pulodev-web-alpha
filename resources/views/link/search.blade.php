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
        <x-linkCard :link="$link" />
    @empty
        <p>Oops. Mohon maaf pencarian ini tidak ditemukan</p>    
    @endforelse
</div>

@endsection