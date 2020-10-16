@extends('layouts.app')

@section('title', 'Stats')
@section('desc', 'Stats PuloDev')
@section('content')

<section class="hero">
    <div class="hero-body">
        <div class="container has-text-centered">
            <h1 class="title"> Dashboard Admin </h1>

            @if (Auth::check())
                <p class="subtitle">Halo {{Auth::user()->username}} </p>
            @endif

            <a href="/admin/dashboard" class="button"> << Kembali ke Admin </a>
        </div>
    </div>
</section>

<div class="container">
      <div class="subtitle">Stats</div>
      <p> Total Link : {{$linksCount}} </p>
      <p> Total User : {{$usersCount}} </p>

      <hr>
      <div class="subtitle">Daftar User (order by: last register)</div>
      @foreach ($users as $user)
          <a href="/{{'@'.$user->username}}">{{'@'.$user->username}}</a> ||
      @endforeach
         <div>
            {{ $users->links('pagination.default') }}
        </div>
</div>

@endsection