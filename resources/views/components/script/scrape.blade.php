<script>

let scraped = false

//if edit page show complete form automatically
@if(isset($link) || old('url')) 
    showCompleteForm() 
    scraped = true
@endif

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
            scraped = true
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


$('form')[0].addEventListener('submit', function(evt){
    evt.preventDefault()

    if (scraped == false)
        scrape()
    else
        $('form')[0].submit()
})
</script>