@extends('layouts.app')

@section('title')
  Profile {{ $user->username }} di Koding.club
@endsection

@section('desc')
    Profile {{ $user->username }} di Koding.club, komunitas online untuk programmer
@endsection

@section('content')

<section class="hero is-info">
    <div class="hero-body">
        <div class="container">

            <img src="{{ getAvatar($user) }}" alt="foto profil {{$user->username}}" width="100">

            <h1 class="title">{{ $user->fullname }}</h1>
            <h2 class="subtitle">{{ '@'.$user->username }}</h2>

            <p>{{$user->bio}}</p>
            <a rel="nofollow ugc" href="{{$user->website_url}}" class="has-text-white">Link: {{$user->website_url}} </a>

            @if (Auth::user())
                @if (Auth::user()->id === $user->id)
                    <div class="buttons">
                        <a class="button" href="/user/edit">Edit Profil</a>
                    </div>
                @endif
            @endif
        </div>
    </div>
</section>

<div class="columns is-marginless">
    <div class="column is-two-thirds">
        <div class="card">
            <div class="card-content">
                <ul>
                    <h2>Daftar Link</h2>
                    @foreach ($user->links as $link)
                        <a href="/link/{{$link->slug}}"> 
                            <li> {{$link->title}} 
                            @if ($link->draft) [draft - Tunggu konfirmasi] @endif
                            </li>
                        </a>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection