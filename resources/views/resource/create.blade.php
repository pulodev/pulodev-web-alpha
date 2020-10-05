@extends('layouts.app')

@section('title', 'Link baru')
@section('desc', 'Link baru koding .club')
@section('content')

<section class="hero">
    <div class="hero-body">
        <div class="container has-text-centered">
            <h1 class="title">Resource Baru</h1>
            <h2 class="subtitle">Masukkan RSS untuk menambakan konten seacara otomatis</h2>
        </div>
    </div>
</section>

<div class="columns is-marginless is-centered">
    <div class="column is-half">
        <div class="card">

            <div class="card-content">
                <form method="POST" action="/resource">
                    @csrf
                   
                    <x-form.input label="URL RSS" name="url" type="url" placeholder="Masukkan URL di sini" required/>
                    
                    <x-form.input label="Judul" name="title" required/>
                    
                    <x-form.media-choice />

                    <div class="buttons">
                    <button class="button is-primary is-fullwidth">Submit</button>
                    </div>
                </form>   
            </div>
        </div>
    </div>
</div>

@endsection