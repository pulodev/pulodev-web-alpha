@extends('layouts.app')

@section('title')
  {{ $thread->title }}
@endsection

@section('desc')
    {{ cutText($thread->title, 150) }}
@endsection

@section('content')

<section class="hero is-info">
    <div class="hero-body">
        <div class="container">
            <h1 class="title">
                {{ $thread->title }}
            </h1>
        </div>
    </div>
</section>

<div class="columns is-marginless">
    <div class="column is-two-thirds">
        <div class="card">
            <div class="card-content">
                <div>{!! Purify::clean($thread->body) !!}</div>

                <footer class="mt-2">
                    <br>
                    <p>Ditulis oleh {{'@'. $thread->user->username}}</p>
                    <p class="is-size-7">Kategori: {{$thread->tags}}</p>
                </footer>
            </div>
        </div>
    </div>
</div>

@if (Auth::user())
    @if (Auth::user()->id === $thread->user->id)
        <div class="buttons">
             <a class="button is-primary is-light" href="/{{$thread->slug}}/edit">Edit</a>
        </div>
    @endif
@endif



<div class="columns  is-marginless">
    <div class="column is-two-thirds">
        <p>Komentar</p>

        <article class="media">
        <div class="media-content">
            <form action="/comment/{{$thread->id}}" method="POST">
                @csrf
                <div class="field">
                <p class="control">
                    <textarea class="textarea" name="body" placeholder="Add a comment..."></textarea>
                </p>
                </div>
                
                <input type="submit" class="button is-info">
            </form>
        </div>
        </article>


        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

        @foreach ($thread->comments as $comment)
            <article class="media">
            <figure class="media-left">
                <p class="image is-64x64">
                <img src="https://bulma.io/images/placeholders/128x128.png">
                </p>
            </figure>
                <div class="media-content">
                    <div class="content">
                    <div>
                        <strong>{{$comment->user->fullname}}</strong> <small>{{'@'.$comment->user->username}}</small> 
                        <br>
                        <div>{!! Purify::clean($comment->body) !!}</div>
                    </div>
                    </div>
                </div>

                @if (Auth::user()->id == $comment->user->id)
                    <div class="media-right">
                        <a href="/comment/{{$comment->id}}/edit"><span class="icon"><i class="fa fa-edit"></i></span></a>
                        <a href="/comment/{{$comment->id}}/delete"><span class="icon"><i class="fa fa-trash-o"></i></span></a>
                    </div>
                @endif

            </article>
        @endforeach    

    </div>
</div>

@endsection