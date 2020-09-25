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
        </div>
    </div>
</section>

<div class="container">
        <h3 class="is-size-3">Masih Draft({{count($resources)}})</h3>

        <hr>
        <script>
            function accept(res_id) {
                axios.get('/admin/rss/verify/' + res_id)
                .then(function (response) {
                    console.log(response)
                    window.location.reload()
                }).catch(function (error) { console.log(error) })
            }
        </script>

        @foreach ($resources as $resource)
        <div class="columns mt-1">
            <div class="box column" href='#'>
                <a href="#" onclick="accept({{$resource->id}})" class="button">Terima RSS</a>
                <article class="media">
                    <div class="media-left">
                    <figure class="image is-64x64">
                        <img src="{{ getAvatar($resource->user) }}" alt="foto profil {{$resource->user->username}}" width="100">
                    </figure>
                    </div>
                    <div class="media-content">
                     <div class="content">
                        <p>Dimasukkan oleh {{$resource->user->fullname .' @'.$resource->user->username }}</small> 
                        <br>
                        <strong> {{$resource->title}}</strong>
                        <strong> {{$resource->url}}</strong>
                        </p>
                        <p class="is-size-7"> Media: {{$resource->media}}</p>
                    </div>
                    </div>
                </article>
            </div>
        </div>    
        @endforeach

        <div>
            {{ $resources->links() }}
        </div>
</div>
</div>

@endsection