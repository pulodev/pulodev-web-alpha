@extends('layouts.app')

@section('title') {{ $link->title }} @endsection

@section('desc') {{ cutText($link->title, 150) }} @endsection

@isset($link->thumbnail)
    @section('img') {{ $link->thumbnail }} @endsection
@endisset

@section('content')
<section class="hero">
    <div class="hero-body">
        <div class="container has-text-centered">
            <h1 class="title">{{ $link->title }} </h1>
            <h2 class="subtitle"> @if ($link->draft) [Status: draft - Tunggu konfirmasi] @endif </h2>
        </div>
    </div>
</section>

<div class="columns is-marginless is-centered">
    <div class="column is-half">
        <div class="card">
            <div class="card-content">
                <div>
                    <strong>Ringkasan:</strong> <br>
                    {!! Purify::clean($link->body) !!}
                </div>
                
                <p class="my-2">
                    <strong> Link: </strong> <br>
                    <a href="{{$link->url}}" target="_blank">{{$link->url}}</a>
                </p>

                <footer class="media mt-2">
                    <figure class="media-left">
                        <x-avatar :user="$link->user"/>
                    </figure>
                    <div>
                        <p class="is-size-7"><a class="has-text-dark" href="/{{'@'.$link->user->username}}">
                            {{$link->user->fullname .' @'.$link->user->username }}</a>
                            @isset($link->owner) <br>Milik {{$link->owner}} @endisset
                            <br>
                            {{$link->original_published_at->diffForHumans()}} 
                        </p>
                        <p class="is-size-7"><x-tags :tags="$link->tags" /> </p>
                    </div>
                </footer>

                @if (Auth::user())
                <div class="card-footer">
                    @if (Auth::user()->id === $link->user->id)
                        <div class="buttons">
                            <a class="button is-primary is-light" href="/link/{{$link->slug}}/edit">Edit</a>
                            <form method="POST" action="/link/{{$link->slug}}" onsubmit="confirmDelete(event)">
                                @csrf
                                @method('DELETE')
                                <input type="submit" class="button is-danger is-light" href="/link/{{$link->slug}}/delete" value="Hapus">
                            </form>

                            <script>
                                //warning before deletion
                                function confirmDelete(event){
                                    const form = event.target;
                                    event.preventDefault();

                                    swal.fire({
                                        title: 'Yaki mau menghapus?',
                                        text: "aksi ini tidak bisa dikembalikan.",
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#d33',
                                        confirmButtonText: 'Ya, hapus!'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                form.submit(); 
                                                swal.fire('Terhapus!', 'Link ini sudah dihapus.', 'success')
                                            }    
                                        })
                                }
                            </script>
                        </div>
                    @endif
                </div>
                @endif
            </div>
        </div>

    </div>
</div>

@endsection