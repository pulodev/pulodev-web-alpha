<script>
//if edit page show complete form automatically
@isset($link) showCompleteForm() @endif
@if(old('url')) showCompleteForm() @endif

function scrape() {
    let url = document.getElementById('url').value
    $('#check-btn').innerText = 'Sedang mengecek link...'
    
    axios.post('/scrape/', {url : url})
        .then(function (response) {

            if(response.status == 403)
                console.log(response.msg)

            addToInputBox('title', response.data.title)
            addToInputBox('body', response.data.description)
            addToInputBox('owner', response.data.author)

            showCompleteForm()
        })
        .catch(function (error) {
            console.log(error);
            if(error.status = 'EXISTS')
                $('#check-btn').innerText = 'Halo.. Link ini sudah pernah disubmit'
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