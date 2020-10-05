@extends('layouts.app')

@section('title', 'Login')
@section('desc', 'Login koding .club')
@section('content')

<section class="hero">
    <div class="hero-body">
        <div class="container has-text-centered">
            <h1 class="title"> Masuk Ke Pulo </h1>
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
                
                <form class="login-form" method="POST" action="{{ route('login') }}">
                    @csrf
                    <x-form.input label="Username" name="username" required/>
                    <x-form.input label="Password" name="password" type="password" required/>

                  <label class="checkbox">
                    <input type="checkbox"
                            name="remember" {{ old('remember') ? 'checked' : '' }}> Ingat Saya
                   </label>
                   <br><br>

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