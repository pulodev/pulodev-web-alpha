<script>
//if edit page show complete form automatically
@isset($link) showCompleteForm() @endif
@if(old('url')) showCompleteForm() @endif

function scrape() {
    let url = document.getElementById('url').value

    if(url.trim() == '') {
        $('#check-btn').innerText = 'Tidak boleh kosong'
        return
    }


    $('#check-btn').innerText = 'Sedang mengecek link...'
    
    axios.post('/scrape/', {url : url})
        .then(function (response) {
            if(response.status == 403)
                console.log(response.msg)

            addToInputBox('title', response.data.title)
            addToInputBox('body', response.data.description)
            addToInputBox('owner', response.data.author)
            addToInputBox('thumbnail', response.data.thumbnail)
            addToInputBox('original_published_at', response.data.original_published_at)

            showCompleteForm()
        })
        .catch(function (error) {
            if(error.status == 'EXISTS' || error.response.status == 403)
                $('#check-btn').innerText = 'oops.. Link ini sudah pernah disubmit'
            else
                $('#check-btn').innerText = 'Mohon maaf, ada masalah'
        })
}

function addToInputBox(id, text) {
    if(text != null || text != '') {
        $('#'+id).value =  `${text}`
        }   
}

function showCompleteForm() {
    $('#complete-form').classList.remove('is-hidden')
    $('#check-btn').remove()
}
</script>