<div class="field">
<div class="label">{{$label}}</div>
<img src="{{getAvatar($object)}}" alt="" width="100" id="{{$name}}-preview">
<div id="upload_status" class="is-hidden">Uploading...</div>
<label class="file-label">
    <div class="control">
        <input class="file-input" type="file" name="{{$name}}" 
                    onchange="upload(this)" accept="image/*">
        <span class="file-cta">
        <span class="file-label"> Upload </span>
    </div>
    </span>
</label>
</div>

<script>
    function upload(el) {
         let avatar = el.files[0];
         axios.defaults.headers.common['Content-Type'] = 'multipart/form-data'


        if((avatar.size/1024) > 1024){
            swal.fire( 'Oops!', 'Ukuran avatar max 1 Mb', 'warning' );
            return;
        }

         const formData = new FormData();
               formData.append('image', avatar);
        
        $('#upload_status').classList.toggle('is-hidden')
        
        axios.post('/user/upload/avatar', formData)
            .then(function (response) {
                console.log(response.data.avatar)
                $('#{{$name}}-preview').src = 'https://kodingclub.s3.ap-southeast-1.amazonaws.com/avatar/' + response.data.avatar
                $('#upload_status').classList.toggle('is-hidden')
                //swal?
            })
            .catch(function (error) {
                console.log(error)
                $('#upload_status').classList.toggle('is-hidden')
            });
    }
</script>