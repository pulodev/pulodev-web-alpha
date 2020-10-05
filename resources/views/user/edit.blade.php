@extends('layouts.app')

@section('title') Edit Profil {{ $user->username }}  @endsection
@section('desc') Edit Profil {{ $user->username }} di Koding.club, komunitas online untuk programmer @endsection
@section('metaextra') <meta name="robots" content="noindex" /> @endsection

@section('content')

<section class="hero">
    <div class="hero-body">
        <div class="container has-text-centered">
            <h1 class="title">Edit profil {{ '@'.$user->username }}</h1>
        </div>
    </div>
</section>

<div class="columns is-marginless is-centered">
    <div class="column is-half">
        <div class="card">
            <div class="card-content">
                    <form method="POST" action="/user/update">
                    @csrf
                    @method('PUT')

                    <x-form.input-image :object="$user" label="Avatar" type="file" name="avatar"/>
                    
                    <x-form.input :object="$user" label="Username" name="username" required/>

                    <x-form.input :object="$user" label="Nama Lengkap" name="fullname" />

                    <x-form.textarea :object="$user" label="Bio singkat" name="bio"/>

                    <x-form.input :object="$user" label="Website kamu" name="website_url" placeholder="contoh:https://webkamu.com" />

                    <div class="buttons">
                      <button class="button is-primary is-fullwidth"">Update</button>
                    </div>
                </form>  
            </div>
        </div>
    </div>
</div>

@endsection