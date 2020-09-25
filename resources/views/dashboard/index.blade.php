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

            <a href="/admin/dashboard/link" class="button">Link</a>
            <a href="/admin/dashboard/rss" class="button">RSS</a>
        </div>
    </div>
</section>
</div>

@endsection