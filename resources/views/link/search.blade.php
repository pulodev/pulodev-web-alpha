@extends('layouts.app')

@section('title', 'Cari di PuloDev')
@section('desc', 'Mencari konten di PuloDev')
@section('content')

@push('scripts')
    <script src="/js/search-filter.js" type="module"></script>
@endpush

@php $isAggregationsExist = count($links['aggregations']) > 0; @endphp

<section class="hero">
    <div class="hero-body">
        <div class="container has-text-centered">
            <h1 class="title"> Mencari "{{$querySearch}}" </h1>
            
             <div class="columns is-centered">
                <div class="column is-half">
                <form class="columns is-mobile is-gapless" action="/search" method="GET">
                    <div class="column is-four-fifths">
                        <input class="input" type="text" placeholder="Cari Konten.." name="query">
                    </div>
                    <div class="column is-one-fifth">
                        <input type="submit" class="button is-info is-fullwidth" value="Cari">
                    </div>
                </form>
                </div>
            </div>      
        </div>
    </div>
</section>

<div class="container">
    <div class="columns mt-1">
        <div class="column {{ $isAggregationsExist ? 'is-four-fifths' : '' }}">
            @forelse ($links['content'] as $link)
            <x-linkCard :link="$link" />
            @empty
                <p>Oops. Mohon maaf pencarian ini tidak ditemukan</p>    
            @endforelse
        </div>
        <div class="{{ $isAggregationsExist ? 'column' : 'is-hidden' }}">
            <h3>Pilih media</h3>
            <section id="search-filter-media">
            @foreach ($links['aggregations'] as $media)
            <a class="tag {{ $filter === $media ? 'is-primary' : '' }}" media="{{ $media }}">{{ $media }}</a>   
            @endforeach
            </section>
        </div>
    </div>
</div>

@endsection