@extends('layouts.app')

@section('title', 'Login')
@section('desc', 'Login koding .club')
@section('content')

<section class="hero is-info">
    <div class="hero-body">
        <div class="container">
            <h1 class="title">
                Edit thread
            </h1>

            <div class="subtitle">
                 {{$thread->title}}
            </div>
        </div>
    </div>
</section>

<div class="columns is-marginless">
    <div class="column is-two-thirds">
        <div class="card">

            <div class="card-content">
                <form method="POST" action="/{{$thread->slug}}">
                    @csrf
                    @method('PUT')

                    <div class="field">
                        <label class="label">Judul</label>
                        <div class="control">
                            <input name="title" class="input" type="text" placeholder="Menulis di dunia programming" value="{{$thread->title}}">
                        </div>
                         @if ($errors->has('title'))
                            <p class="help is-danger">
                                {{ $errors->first('title') }}
                            </p>
                        @endif
                    </div>

                    <div class="field">
                        <label class="label">Tulisan</label>
                        <div class="control">
                            <textarea name="body" class="textarea" placeholder="write your content here">{{$thread->body}}</textarea>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Tag <span> (pisahkan dengan koma)</span></label> 
                        <div class="control">
                            <input name="tags" class="input" type="text" placeholder="php, javascript, html" value="{{$thread->tags}}">
                        </div>
                    </div>

                    <label class="checkbox">
                        <input type="checkbox" name="draft" @if($thread->draft) checked @endif> Draft
                    </label>

                    <div class="buttons">
                      <button class="button is-primary is-fullwidth"">Submit</button>
                    </div>
                </form>   
            </div>
        </div>
    </div>
</div>

@endsection