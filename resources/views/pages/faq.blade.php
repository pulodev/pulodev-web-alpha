@extends('layouts.app')

@section('title', 'Faq PuloDev')
@section('desc', 'Faq PuloDev')
@section('content')

<section class="hero is-primary">
    <div class="hero-body">
        <div class="container">
            <h1 class="title">Pertanyaan seputar PuloDev</h1>
        </div>
    </div>
</section>

<div class="columns is-marginless is-centered">
    <div class="column is-5">
        <div class="card">
            <div class="card-content">
              <p><strong>Apa itu PuloDev</strong></p>
              <p>Singkatnya, tempat berkumpul orang yang senang programming. Lengkapnya baca <a href="/info/about"> tentang kami</a></p>

              <br>

              <p><strong>Apa tujuan PuloDev</strong></p>
              <p>Menjadi tempat yang nyaman untuk berkumpulnya para peminat programming/IT di Indonesia.</p>

              <br>

              <p><strong>Apa yang bisa dilakukan di PuloDev</strong></p>
              <p>Saat ini kami mengumpulkan konten konten berbahasa Indonesia, ada tulisan, podcast, video dan lainnya. Kamu juga bisa memasukkan RSS konten kamu sendiri atau link ketika kamu menemukan konten berbahasa Indonesia menarik</p>


            </div>
        </div>
    </div>
</div>

@endsection