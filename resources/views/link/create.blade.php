@extends('layouts.app')

@section('title', 'Link baru')
@section('desc', 'Link baru koding .club')
@section('content')

<section class="hero is-info">
    <div class="hero-body">
        <div class="container">
            <h1 class="title">
                Link Baru
            </h1>
            <h2 class="subtitle">
                Rekomendasikan link menarik seputar programming
            </h2>
        </div>
    </div>
</section>

<div class="columns is-marginless">
    <div class="column is-two-thirds">
        <div class="card">

            <div class="card-content">
                <form method="POST" action="/link">
                    @csrf
                   
                    <x-form.input label="URL" name="url" type="url" placeholder="Masukkan URL di sini" required/>
                    <a class="button is-info is-light" onclick="scrape()" id="check-btn">Cek</a>

                    <div class="is-hidden" id="complete-form">
                        <p class="my-2">*Boleh memodifikasi data di bawah</p>
                    
                        <x-form.input label="Judul" name="title" required/>

                        <x-form.textarea label="Ringkasan" name="body"/>

                        <x-form.input label="Tag" name="tags" placeholder="php, javascript, html" required/>
                        
                        <x-form.media-choice />
                        
                        <p class="my-2">*Informasi opsional</p>
                        <x-form.input label="Pemilik Konten" name="owner" placeholder="Akun Twitter atau Nama"/>
                        <x-form.input label="Waktu publish konten" name="original_published_at" type="date" />

                        <div class="buttons">
                        <button class="button is-primary is-fullwidth"">Submit</button>
                        </div>
                    </div>

                    @include('components.script.scrape')
                </form>   
            </div>
        </div>
    </div>
</div>

@endsection