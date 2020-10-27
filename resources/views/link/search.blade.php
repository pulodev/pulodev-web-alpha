@extends('layouts.app')

@section('title', 'Cari di PuloDev')
@section('desc', 'Mencari konten di PuloDev')
@section('content')

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
            @foreach ($links['aggregations'] as $media)
            <a class="tag {{ $filter === $media ? 'is-primary' : '' }} " onclick="onClickFilterBy('{{ $media }}')">{{ $media }}</a>   
            @endforeach
        </div>
    </div>
</div>

<script>
    function onClickFilterBy(media) {
        const url = window.location.href.split('?')[0];
        let currentFilterVal = getUrlParamValue('filter');
        let query = getUrlParamValue('query');
        let urlParams = `query=${query}`;

        if(currentFilterVal !== media) {
            urlParams += `&filter=${media}`;
        }
        
        window.location = `${url}?${urlParams}`;
    }

    function getUrlParamValue(param) {
        let urlParams = window.location.href.split('?')[1];

        if(urlParams) {
            let keyValue = urlParams.split('&').filter(key => key.includes(param));
            
            if (keyValue.length > 0) {
                return keyValue[0].split('=')[1];
            }
        }

        return null;
    }
</script>

@endsection