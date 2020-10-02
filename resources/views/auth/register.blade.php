@extends('layouts.app')

@section('title', 'Register')
@section('desc', 'Register koding .club')
@section('content')
<section class="hero is-primary">
    <div class="hero-body">
        <div class="container">
            <h1 class="title"> Daftar </h1>
        </div>
    </div>
</section>

<div class="columns is-marginless is-centered">
    <div class="column is-5">
        <div class="card">
            <header class="card-header">
                <p class="card-header-title">Daftar</p>
            </header>

            <div class="card-content">

                {{-- Social Media Auth --}}
                <div class="buttons">
                    <a href='/login/twitter' class="button is-info">Masuk dengan Twitter</a>
                    <a href='/login/github' class="button is-dark">Masuk dengan Github</a>
                </div>  

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