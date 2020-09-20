@extends('layouts.app')

@section('title', 'Login')
@section('desc', 'Login koding .club')
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
                    <div class="field">
                        <label class="label">URL</label>
                        <div class="control">
                            <input name="url" id="url" class="input" type="url" placeholder="url">
                        </div>
                         @if ($errors->has('url'))
                            <p class="help is-danger">
                                {{ $errors->first('url') }}
                            </p>
                        @endif
                    </div>

                    <script>
                        function scrape() {
                            let url = document.getElementById('url').value
                            axios.post('/scrape/', {url : url})
                                .then(function (response) {
                                    addToInputBox('title', response.data.title)
                                    addToInputBox('body', response.data.description)
                                    addToInputBox('twitter_owner', response.data.author)
                                })
                                .catch(function (error) {
                                    console.log(error);
                                })
                        }

                        function addToInputBox(id, text) {
                            if(text != '') {
                                $('#'+id).value =  `${text}`
                             }   
                        }
                    </script>

                    <a class="button is-info is-light" onclick="scrape()">Scrape</a>



                    <div class="field">
                        <label class="label">Judul</label>
                        <div class="control">
                            <input name="title" id="title" class="input" type="text" placeholder="Menulis di dunia programming">
                        </div>
                         @if ($errors->has('title'))
                            <p class="help is-danger">
                                {{ $errors->first('title') }}
                            </p>
                        @endif
                    </div>

                    <div class="field">
                        <label class="label">Tulisan</label>
                        <div class="control">
                            <textarea name="body" id="body"  class="textarea" placeholder="write your content here"></textarea>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Tag <span> (pisahkan dengan koma)</span></label> 
                        <div class="control">
                            <input name="tags" class="input" type="text" placeholder="php, javascript, html">
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Twitter Owner <span> (jika ada)</span></label> 
                        <div class="control">
                            <input name="twitter_owner" id="twitter_owner" class="input" type="text" placeholder="sekolahkoding">
                        </div>
                    </div>


                    <div class="buttons">
                      <button class="button is-primary is-fullwidth"">Submit</button>
                    </div>
                </form>   
            </div>
        </div>
    </div>
</div>

@endsection