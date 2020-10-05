@extends('layouts.app')

@section('title', 'Register')
@section('desc', 'Register koding .club')
@section('content')

<section class="hero">
    <div class="hero-body">
        <div class="container  has-text-centered">
            <h1 class="title"> Daftar Masuk Pulo </h1>
        </div>
    </div>
</section>

<div class="columns is-marginless is-centered">
    <div class="column is-5">
        <div class="card">

            <div class="card-content">

                {{-- Social Media Auth --}}
                <div class="buttons is-centered">
                    <a href='/login/twitter' class="button is-info">Masuk dengan Twitter</a>
                    <a href='/login/github' class="button is-dark">Masuk dengan Github</a>
                </div>  

                <p class="has-text-centered"> atau dengan username dan password </p>
                <br>

                <form class="register-form" method="POST" action="{{ route('register') }}">
                    @csrf

                    <x-form.input label="Username" name="username" required/>

                    <x-form.input label="Email" name="email" type="email" required/>

                    <x-form.input label="Password" name="password" type="password" required/>

                    <x-form.input label="Konfirmasi Password" name="password_confirmation" type="password" required/>

                    <div class="buttons">
                        <button class="button is-primary is-fullwidth">Daftar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection