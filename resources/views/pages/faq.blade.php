@extends('layouts.app')

@section('title', 'FAQ PuloDev')
@section('desc', 'Kumpulan pertanyaan tentang PuloDev')

@section('content')

<section class="hero">
    <div class="hero-body">
        <div class="container has-text-centered">
            <h1 class="title">Pertanyaan seputar PuloDev</h1>
        </div>
    </div>
</section>

<div class="columns is-centered">
    <div class="column is-half">
        <div class="card">
            <div class="card-content">
              <p><strong>Apa itu PuloDev</strong></p>
              <p>Kumpulan konten developer Indonesia. Selengkapnya baca <a class="has-text-info" href="/info/about"> tentang kami</a></p>

              <br>

              <p><strong>Apa tujuan PuloDev</strong></p>
              <p>Menjadi tempat yang nyaman untuk berkumpulnya para peminat programming/IT di Indonesia.</p>

              <br>

              <p><strong>Apa yang bisa dilakukan di PuloDev</strong></p>
              <p>Saat ini kami mengumpulkan konten-konten berbahasa Indonesia atau dari orang Indonesia, ada tulisan, podcast, video dan lainnya. Kamu juga bisa memasukkan RSS konten kamu sendiri atau link ketika menemukan konten berbahasa Indonesia menarik</p>

              <br>

              <p><strong>Cara mengklaim konten yang sudah dimasukkan</strong></p>
              <p>Siapapun bisa memasukkan konten yang dirasa menarik dengan menyertakan sumber link aslinya.
                Kalau kamu ingin mengklaim konten tersebut. Silahkan kontak kami di twitter <a href="https://twitter.com/pulodev" target="_blank"> @pulodev</a>
              </p>

            </div>
        </div>
    </div>
</div>

@endsection