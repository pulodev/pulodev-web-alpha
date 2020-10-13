@extends('layouts.app')

@section('title', 'Welcome')
@section('desc', 'Welcome koding .club')
@section('content')

<section class="hero">
    <div class="hero-body">
        <div class="container has-text-centered">
            <h1 class="title"> Dashboard Admin </h1>

            @if (Auth::check())
                <p class="subtitle">Halo {{Auth::user()->username}} </p>
            @endif

            <a href="/admin/dashboard" class="button"> << Kembali ke Admin </a>
        </div>
    </div>
</section>

<div class="container">
        <h3 class="is-size-3">Masih Draft({{count($links)}})</h3>

        <hr>
        <div class=" my-3">
            <h3>Bulk Update</h3>
            <br>
            <div class="columns">
                <div class="button" onclick="toggleSelectAll()">Select All (in this page)</div>
                <div class="button is-light is-danger" onclick="deleteContent()">Delete</div>
                <div class="button is-light is-info" onclick="publishDraft()">Publish Draft</div>
            </div>

            <script>
                //===================================================
                //=========== SELECT CONTENT =======================
                //===================================================

                let activeItem = [];

                function toggleItem(el) {
                    if(el.checked == true)
                        addItem(el)
                     else
                        removeItem(el)   
                }

                let status = false
                function toggleSelectAll() {
                    var checkboxes = $("input[type=checkbox]");
                    status = !status;

                    for(var i = 0; i < checkboxes.length; i++) {
                        checkboxes[i].checked = status;
                        if(status == true)
                            addItem(checkboxes[i])
                        else
                            removeItem(checkboxes[i])
                    }                            
                }

                function addItem(el){
                    activeItem.push(el.getAttribute('data-id'))
                }

                function removeItem(el){
                    activeItem = activeItem.filter(item => item !== el.getAttribute('data-id'))
                }

                //===================================================
                //=========== BULK UPDATE ===========================
                //===================================================
                function deleteContent() {
                    swal.fire({
                        title: 'Are you sure?',
                        text: "Kamu akan menghapus " + activeItem.length + " item" ,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                activeItem = [...new Set(activeItem)]; //get unique array

                                axios.delete('/admin/link/bulk/', {data: {'items' : activeItem}})
                                    .then(function (response) {
                                        console.log(response);
                                        window.location.reload();
                                    })
                                    .catch(function (error) { console.log(error) })
                            }
                        })
                }

                 function publishDraft() {
                    swal.fire({
                        title: 'Are you sure?',
                        text: "Kamu akan mempublish " + activeItem.length + " item" ,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, publish it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                items = [...new Set(activeItem)]; //get unique array
                                console.log(items)
                                axios.put('/admin/link/bulk/publish', {items})
                                    .then(function (response) {
                                        console.log(response);
                                        window.location.reload();
                                    })
                                    .catch(function (error) { console.log(error) })
                            }
                        })
                }
            </script>
        </div>
        <hr>

        @foreach ($links as $link)
        <div class="columns mt-1">
            <input type="checkbox" class="column is-1" data-id="{{$link->id}}" onclick="toggleItem(this)">
            <x-linkCard :link="$link" />
        </div>    
        @endforeach

        <div>
            {{ $links->links('pagination.default') }}
        </div>
</div>
</div>

@endsection