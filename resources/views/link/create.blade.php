@extends('layouts.app')

@section('title', 'Link baru')
@section('desc', 'Link baru pulo.dev')
@section('metaextra') <meta name="robots" content="noindex" /> @endsection

@section('content')

@push('scripts')
    <script src="/js/create-link.js" type="module"></script>
@endpush

<section class="hero">
    <div class="hero-body">
        <div class="container has-text-centered">
            <h1 class="title"> Link Baru </h1>
            <h2 class="subtitle"> Rekomendasikan link bahasa Indonesia menarik seputar programming </h2>
        </div>
    </div>
</section>

<div class="columns is-marginless is-centered">
    <div class="column is-half">
        <div class="card">

            <div class="card-content">
                <form method="POST" action="/link">
                    @csrf
                   
                    <x-form.input id="url" label="URL" name="url" type="url" placeholder="Masukkan URL di sini" required/>
                    <a class="button is-info is-light" id="check-btn">Cek</a>

                    <div class="is-hidden" id="complete-form">
                        <p class="my-2">*Boleh memodifikasi data di bawah</p>
                    
                        <x-form.input label="Judul" name="title" required/>

                        <x-form.textarea label="Ringkasan" name="body"/>
                        
                        <x-form.input label="Waktu publish konten" name="original_published_at" type="date" />

                        <x-form.input label="Tag" name="tags" placeholder="php, javascript, html" required/>
                        
                        <x-form.media-choice />
                        
                        <p class="my-2">*Informasi opsional</p>
                        <x-form.input label="Pemilik Konten" name="owner" placeholder="Akun Twitter atau Nama"/>

                        <input type="hidden" name="thumbnail" id="thumbnail">

                        <div class="buttons">
                        <button class="button is-primary is-fullwidth">Masukkan</button>
                        </div>
                    </div>
                </form>   
            </div>
        </div>
    </div>
</div>

@endsection