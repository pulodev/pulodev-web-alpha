@extends('layouts.app')

@section('title', 'Admin')
@section('desc', 'Admin pulodev')
@section('metaextra') <meta name="robots" content="noindex" /> @endsection

@section('content')

<section class="hero">
    <div class="hero-body">
        <div class="container  has-text-centered">
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