@extends('layouts.app')

@section('title', 'Link edit')
@section('desc', 'Link edit pulo.dev')
@section('metaextra') <meta name="robots" content="noindex" /> @endsection

@section('content')

<section class="hero">
    <div class="hero-body">
        <div class="container has-text-centered">
            <h1 class="title"> Link Edit </h1>
            <h2 class="subtitle"> {{$link->title}} </h2>
        </div>
    </div>
</section>

<div class="columns is-marginless is-centered">
    <div class="column is-half">
        <div class="card">

            <div class="card-content">
                <form method="POST" action="/link/{{$link->slug}}">
                    @csrf
                    @method('PUT')
                   
                <x-form.input :object="$link" label="URL" name="url" type="url" placeholder="Masukkan URL di sini" required/>
                    <a class="button is-info is-light" onclick="scrape()" id="check-btn">Cek</a>

                    <div class="is-hidden" id="complete-form">
                        <p class="my-2">*Boleh memodifikasi data di bawah</p>
                    
                        <x-form.input :object="$link" label="Judul" name="title" required/>

                        <x-form.textarea :object="$link" label="Ringkasan" name="body"/>

                        <x-form.input :object="$link" label="Waktu publish konten" name="original_published_at" type="date" />
                        <script>
                            $('#original_published_at').value = "{{ \Carbon\Carbon::parse($link->original_published_at)->format('Y-m-d') }}"
                        </script>

                        <x-form.input :object="$link" label="Tag" name="tags" placeholder="php, javascript, html" required/>
                        
                         <x-form.media-choice :object="$link" />
                        
                        <p class="my-2">*Informasi opsional</p>
                        <x-form.input :object="$link" label="Pemilik Konten" name="owner" placeholder="Akun Twitter atau Nama"/>
                         
                        @if (Auth::user()->isAdmin())
                            <label class="checkbox">
                                <input type="checkbox" name="draft" @if($link->draft) checked @endif> Draft
                            </label>
                        @endif

                        <div class="buttons">
                        <button class="button is-primary is-fullwidth">Update</button>
                        </div>
                    </div>

                    @include('components.script.scrape')
                </form>   
            </div>
        </div>
    </div>
</div>

@endsection