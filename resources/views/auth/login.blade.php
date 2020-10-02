@extends('layouts.app')

@section('title', 'Login')
@section('desc', 'Login koding .club')
@section('content')

<section class="hero is-primary">
    <div class="hero-body">
        <div class="container">
            <h1 class="title">
                Login
            </h1>
        </div>
    </div>
</section>

<div class="columns is-marginless is-centered">
    <div class="column is-5">
        <div class="card">
            <header class="card-header">
                <p class="card-header-title">Login</p>
            </header>

            <div class="card-content">
                {{-- Social Media Auth --}}
                <div class="buttons">
                    <a href='/login/twitter' class="button is-info">Masuk dengan Twitter</a>
                    <a href='/login/github' class="button is-dark">Masuk dengan Github</a>
                </div>  
                
                <form class="login-form" method="POST" action="{{ route('login') }}">
                    @csrf
                    <x-form.input label="Username" name="username" required/>
                    <x-form.input label="Password" name="password" type="password" required/>

                  <label class="checkbox">
                    <input type="checkbox"
                            name="remember" {{ old('remember') ? 'checked' : '' }}> Ingat Saya
                   </label>

                    <div class="buttons">
                        <button class="button is-primary is-fullwidth">Masuk</button>
                    </div>

                     <div class="control">
                        <a href="{{ route('password.request') }}"> Lupa Password Kamu? </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection