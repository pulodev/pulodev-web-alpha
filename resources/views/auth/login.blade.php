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
                    {{ csrf_field() }}

                    <div class="field is-horizontal">
                        <div class="field-label">
                            <label>Username</label>
                        </div>

                        <div class="field-body">
                            <div class="field">
                                <p class="control">
                                    <input class="input" id="username" type="text" name="username"
                                           value="{{ old('username') }}" required autofocus>
                                </p>

                                @if ($errors->has('username'))
                                    <p class="help is-danger">
                                        {{ $errors->first('username') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="field is-horizontal">
                        <div class="field-label">
                            <label>Password</label>
                        </div>

                        <div class="field-body">
                            <div class="field">
                                <p class="control">
                                    <input class="input" id="password" type="password" name="password" required>
                                </p>

                                @if ($errors->has('password'))
                                    <p class="help is-danger">
                                        {{ $errors->first('password') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="field is-horizontal">
                        <div class="field-label"></div>

                        <div class="field-body">
                            <div class="field">
                                <p class="control">
                                    <label class="checkbox">
                                        <input type="checkbox"
                                               name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="field is-horizontal">
                        <div class="field-label"></div>

                        <div class="field-body">
                            <div class="field is-grouped">
                                <div class="control">
                                    <button type="submit" class="button is-primary">Login</button>
                                </div>

                                <div class="control">
                                    <a href="{{ route('password.request') }}">
                                        Forgot Your Password?
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection