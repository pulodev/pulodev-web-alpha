@extends('layouts.app')

@section('content')
<div class="container">
    <div class="columns is-marginless is-centered">
        <div class="column is-5">
            <div class="card">
                <header class="card-header">
                    <p class="card-header-title">{{ __('Verify Your Email Address') }}</p>
                </header>

                <div class="card-content">
                    @if (session('resent'))
                        <div class="notification is-success">
                            <button class="delete"></button>
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }}, 

                    <form action="/email/verification-notification" method="POST">
                        {{ csrf_field() }}
                        <input type="submit" value="Kirim Ulang">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection