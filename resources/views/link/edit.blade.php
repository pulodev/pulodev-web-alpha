@extends('layouts.app')

@section('title', 'Link edit')
@section('desc', 'Link edit koding .club')
@section('content')

<section class="hero is-info">
    <div class="hero-body">
        <div class="container">
            <h1 class="title">
                Link Edit
            </h1>
            <h2 class="subtitle">
                {{$link->title}}
            </h2>
        </div>
    </div>
</section>

<div class="columns is-marginless">
    <div class="column is-two-thirds">
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

                        <x-form.input :object="$link" label="Tag" name="tags" placeholder="php, javascript, html" required/>
                        
                        <div class="control">
                            <div class="label">Media</div>
                            <label class="radio"> <input id="media-tulisan" type="radio" name="media" value="tulisan"> Tulisan </label>
                            <label class="radio"> <input id="media-video" type="radio" name="media" value="video"> Video </label>
                            <label class="radio"> <input id="media-podcast" type="radio" name="media" value="podcast"> Podcast </label>
                        </div>
                        {{-- check media from db --}}
                        <script> $('#media-{{$link->media}}').checked = true </script>
                        
                        <p class="my-2">*Informasi opsional</p>
                        <x-form.input :object="$link" label="Pemilik Konten" name="owner" placeholder="Akun Twitter atau Nama"/>
                        <x-form.input :object="$link" label="Waktu publish konten" name="original_published_at" type="date" />
                         
                        @if (Auth::user()->isAdmin())
                            <label class="checkbox">
                                <input type="checkbox" name="draft" @if($link->draft) checked @endif> Draft
                            </label>
                        @endif

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