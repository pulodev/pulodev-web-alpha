@extends('layouts.app')

@section('title') Profile {{ $user->username }} di pulo.dev @endsection
@section('desc') Profile {{ $user->username }} di pulodev, komunitas online untuk programmer @endsection

@section('content')

<section class="hero">
    <div class="hero-body">
        <div class="container has-text-centered">
            <x-avatar :user="$user"/>

            @isset($user->fullname) <h1 class="title">{{ $user->fullname }}</h1> @endisset
            <h2 class="subtitle">{{ '@'.$user->username }}</h2>

            @isset($user->bio) <p>{{$user->bio}}</p>@endisset
            <a rel="nofollow ugc" href="{{$user->website_url}}" class="has-text-white">Link: {{$user->website_url}} </a>

            @if (Auth::user())
                @if (Auth::user()->id === $user->id)
                    <div class="buttons is-centered">
                        <a class="button" href="/user/edit">Edit Profil</a>
                    </div>
                @endif
            @endif
        </div>
    </div>
</section>

<div class="columns is-marginless is-centered">
    <div class="column is-half">
        <div class="card">
            <div class="card-content">
                <ul>
                    <h2> <strong> Daftar RSS</strong></h2>
                    <br>
                    @foreach ($user->resources as $resource)
                            <li> {{$resource->title}} 
                            @if ($resource->draft) [Tunggu konfirmasi] @endif
                            </li> 
                    @endforeach
                </ul>
                <hr>
                <ul>
                    <h2> <strong> Daftar Link</strong></h2>
                    <br>
                    @foreach ($user->links as $link)
                        <a class="has-text-dark" href="/link/{{$link->slug}}"> 
                            <li> {{$link->title}} 
                            @if ($link->draft) [Tunggu konfirmasi] @endif
                            </li> <hr>
                        </a>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection