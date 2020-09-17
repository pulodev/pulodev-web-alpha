@extends('layouts.app')

@section('title', 'edit komentar')
@section('desc', 'edit komentar koding .club')
@section('content')

<section class="hero is-info">
    <div class="hero-body">
        <div class="container">
            <h1 class="title">
                Edit Komentar
            </h1>

            <div class="subtitle">
                 {{$comment->thread->title}}
            </div>
        </div>
    </div>
</section>

<div class="columns is-marginless">
    <div class="column is-two-thirds">
        <div class="card">

            <div class="card-content">
                <form method="POST" action="/comment/{{$comment->id}}">
                    @csrf
                    @method('PUT')

                    <div class="field">
                        <label class="label">Komentar</label>
                        <div class="control">
                            <textarea name="body" class="textarea" placeholder="write your content here">{{$comment->body}}</textarea>
                        </div>
                    </div>

                    <div class="buttons">
                      <button class="button is-primary is-fullwidth"">Update</button>
                    </div>
                </form>   
            </div>
        </div>
    </div>
</div>

@endsection