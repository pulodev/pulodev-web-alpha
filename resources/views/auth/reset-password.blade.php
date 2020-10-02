@extends('layouts.app')

@section('content')

    <section class="hero is-primary">
        <div class="hero-body">
            <div class="container">
                <h1 class="title">
                    Reset Password
                </h1>
            </div>
        </div>
    </section>


    <div class="columns is-marginless is-centered">
        <div class="column is-5">
            <div class="card">
                <header class="card-header">
                    <p class="card-header-title">Reset Password</p>
                </header>

                <div class="card-content">
                    @if (session('status'))
                        <div class="notification is-info">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="password-reset-form" method="POST" action="/reset-password">
                        @csrf
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <x-form.input label="Email" name="email" type="email" required/>
                        <x-form.input label="Password" name="password" type="password" required/>

                        <div class="buttons">
                            <button class="button is-primary is-fullwidth">Reset Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection