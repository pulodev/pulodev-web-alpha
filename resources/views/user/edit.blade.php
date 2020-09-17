@extends('layouts.app')

@section('title')
  Edit Profile {{ $user->username }} 
@endsection

@section('desc')
    Edit Profile {{ $user->username }} di Koding.club, komunitas online untuk programmer
@endsection

@section('content')

<section class="hero is-info">
    <div class="hero-body">
        <div class="container">
            <h1 class="title">Edit profile {{ '@'.$user->username }}</h1>
        </div>
    </div>
</section>

<div class="columns is-marginless">
    <div class="column is-two-thirds">
        <div class="card">
            <div class="card-content">
                    <form method="POST" action="/user/update">
                    @csrf
                    @method('PUT')
                    <div class="field">
                        <label class="label">Username</label>
                        <div class="control">
                            <input name="username" class="input" type="text" placeholder="" value={{$user->username}}>
                        </div>
                         @if ($errors->has('username'))
                            <p class="help is-danger">
                                {{ $errors->first('username') }}
                            </p>
                        @endif
                    </div>

                    <div class="field">
                        <label class="label">Fullname</label>
                        <div class="control">
                            <input name="fullname" class="input" type="text" value="{{$user->fullname}}">
                        </div>
                         @if ($errors->has('fullname'))
                            <p class="help is-danger">
                                {{ $errors->first('fullname') }}
                            </p>
                        @endif
                    </div>

                    <div class="field">
                        <label class="label">Bio</label>
                        <div class="control">
                            <textarea name="bio" class="textarea" placeholder="biodata singkat">{{$user->bio}}</textarea>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Link websitemu</label> 
                        <div class="control">
                            <input name="website_url" class="input" type="url" placeholder="https://web.kamu" value="{{$user->website_url}}">
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