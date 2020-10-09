@extends('layouts.app')

@section('title', 'Welcome')
@section('desc', 'Welcome koding .club')
@section('content')

<section class="hero">
    <div class="hero-body">
        <div class="container  has-text-centered">
            <h1 class="title"> Dashboard Admin </h1>
            @if (Auth::check()) <p class="subtitle">Halo {{Auth::user()->username}} </p> @endif
            <a href="/admin/dashboard" class="button"> << Kembali ke Admin </a>
        </div>
    </div>
</section>

<div class="container">
        <h3 class="is-size-3">Masih Draft({{count($draftResources)}})</h3>

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

        @foreach ($draftResources as $draftResource)
        <div class="columns mt-1">
            <div class="box column" href='#'>
                <a href="#" onclick="accept({{$draftResource->id}})" class="button">Terima RSS</a>
                <article class="media">
                    <div class="media-left">
                    <figure class="image is-64x64">
                        <img src="{{ getAvatar($draftResource->user) }}" alt="foto profil {{$draftResource->user->username}}" width="100">
                    </figure>
                    </div>
                    <div class="media-content">
                     <div class="content">
                        <p>Dimasukkan oleh {{$draftResource->user->fullname .' @'.$draftResource->user->username }}</small> 
                        <br>
                        <strong> {{$draftResource->title}}</strong>
                        <strong> {{$draftResource->url}}</strong>
                        </p>
                        <p class="is-size-7"> Media: {{$draftResource->media}}</p>
                    </div>
                    </div>
                </article>
            </div>
        </div>    
        @endforeach

        <div>
            {{ $draftResources->links() }}
        </div>

        {{-- Daftar Semua Resource --}}

        <div>
            <h3 class="is-size-3">Daftar RSS ({{count($resources)}})</h3>
                <table class="table">
                    <tbody>
                        <tr>
                            <th>Title</th>
                            <th>URL</th>
                            <th>Last Update</th>
                        </tr>
                        @foreach ($resources as $resource)
                        <tr>
                            <td> {{$resource->title }} </td>
                            <td> {{$resource->url }} </td>
                            <td> {{$resource->last_checked_at }} </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
         <div>
            {{ $resources->links() }}
        </div>

</div>
</div>

@endsection