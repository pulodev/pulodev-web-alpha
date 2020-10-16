@extends('layouts.app')

@section('title') Verifikasi email kamu di pulo.dev @endsection
@section('desc') Verifikasi email kamu di pulodev, komunitas online untuk programmer @endsection

@section('content')
<div class="container py-5">
    <div class="columns is-marginless is-centered">
        <div class="column is-5">
            <div class="card">
                <header class="card-header">
                    <p class="card-header-title">Verifikasi Email Kamu</p>
                </header>

                <div class="card-content">
                    @if (session('resent'))
                        <div class="notification is-success">
                            <button class="delete"></button>
                            Link verifikasi sudah dikirim ke email kamu
                        </div>
                    @endif

                    Sebelum melanjutkan, silahkan verifikasi email kamu dulu ya. 
                    Kalau kamu tidak menerima email,

                    <form action="/email/verification-notification" method="POST">
                        {{ csrf_field() }}
                        <input type="submit" class="button is-primary" value="Kirim Ulang">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection