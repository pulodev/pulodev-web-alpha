import {$, postJSON} from './helper.js';

let scraped = false;

function scrape() {
    const url = $('#url').value;

    if(url.trim() == '') {
        $('#check-btn').innerText = 'Tidak boleh kosong';
    }
    

    $('#check-btn').innerText = 'Sedang mengecek link...'
    
    postJSON('/scrape/', {url : url})
        .then(function (response) {
            if(response.status == 'EXISTS')
                $('#check-btn').innerText = 'oops.. Link ini sudah pernah disubmit';
            else{
                addToInputBox('title', response.title);
                addToInputBox('body', response.description);
                addToInputBox('owner', response.author);
                addToInputBox('thumbnail', response.thumbnail);
                addToInputBox('original_published_at', response.original_published_at);
                showCompleteForm();
                scraped = true;
            }
        })
        .catch(function (error) {
            console.error(error);
            if(scraped)
                document.querySelector('button.is-primary').innerText = 'Mohon maaf, ada masalah';
            else 
                $('#check-btn').innerText = 'Mohon maaf, ada masalah';

        })
}

function addToInputBox(id, text) {
    if(text != null || text != '') {
        $('#'+id).value =  `${text}`;
    }   
}

function showCompleteForm() {
    $('#complete-form').classList.remove('is-hidden');
    $('#check-btn').remove();
}


$('form')[0].addEventListener('submit', function(evt){
    evt.preventDefault()

    if (scraped == true)
        $('form')[0].submit();
})

window.onload = () =>{
    const linkUrl = $('#url');
    if(linkUrl.value !==''){
        showCompleteForm() ;
        scraped = true;
    } else{
        $('#check-btn').addEventListener('click',(e)=>{
            scrape();
        });
    }
};