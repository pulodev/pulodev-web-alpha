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

<div class="columns is-marginless is-centered">
    <p>Timeline konten</p>
</div>

@endsection