@extends('layouts.app')

@section('content')


    <section class="hero is-primary">
        <div class="hero-body">
            <div class="container">
                <h1 class="title">
                    Lupa Password
                </h1>
            </div>
        </div>
    </section>

    <div class="columns is-marginless is-centered">
        <div class="column is-5">
            <div class="card">
                <header class="card-header">
                    <p class="card-header-title">Lupa Password</p>
                </header>

                <div class="card-content">
                    @if (session('status'))
                        <div class="notification">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="forgot-password-form" method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <x-form.input label="Email" name="email" type="email" required/>

                        <div class="buttons">
                            <button class="button is-primary is-fullwidth">Kirim Link Reset Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection