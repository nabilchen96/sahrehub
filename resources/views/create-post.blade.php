@extends('layouts.template')
@push('style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">
    <style>
        .tags-input {
            display: inline-block;
            position: relative;
            border-radius: 4px;
            width: 100%;
        }

        .tags-input ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .tags-input li {
            display: inline-block;
            background-color: #f2f2f2;
            color: #333;
            border-radius: 8px;
            padding: 5px 10px;
            margin-right: 5px;
            margin-bottom: 5px;
        }

        .tags-input .delete-button {
            background-color: transparent;
            border: none;
            color: #999;
            cursor: pointer;
            margin-left: 5px;
        }
        .summer > .card{
            border-radius: 4px !important;
        }

        .note-btn{
            border-radius: 0 !important;
        }
    </style>
@endpush
@section('content')
    <div class="col-lg-1"></div>
    <div class="col-lg-10 p-0">
        <h4><b><i class="bi bi-arrow-left"></i> Kembali</b></h4>
        <div class="card">
            <div class="card-body">
                <form id="form">
                    <div class="summer mb-3">
                        <label><b>Keterangan<sup class="text-danger">*</sup></b></label>
                        <textarea required name="keterangan" id="keterangan" class="form-control" cols="30" rows="5"
                            placeholder="Keterangan"></textarea>
                    </div>
                    <div class="mb-3">
                        <label><b>Jenis Post</b></label>
                        <select name="jenis_post" class="form-control" onchange="pilihJenisPost()" id="jenis_post">
                            <option value="">PILIH JENIS POST</option>
                            <option value="1">Foto</option>
                            <option value="2">Video</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <div id="pilihanPost">
                    </div>
                    <div class="mb-3 tags-input">
                        <label><b>Tagar</b></label>
                        <ul id="tags"></ul>
                        <input class="form-control form-control-sm" type="text" name="tagar" id="input-tag"
                            placeholder="Enter tag name" />
                    </div>
                    <div class="mb-3">
                        <button id="tombol_kirim" class="btn btn-sm btn-info" style="border-radius: 4px;">
                            Posting!
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-1"></div>
@endsection
@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#keterangan').summernote({
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['insert', ['link', 'hr', 'emoji']]
                ]
            });
        });

        function pilihJenisPost(){
            let jenis = document.getElementById('jenis_post').value
            let postPilihan = ''

            if(jenis == 1){
                postPilihan = `
                    <label><b>Foto<sup class="text-danger">*</sup></b></label>
                    <input required type="file" class="form-control form-control-sm" id="media" name="media[]" multiple>
                    <span style="font-size: 12px;"><i>*you can upload more than one</i></span><br><br>
                `
            }else{
                postPilihan = `
                    <label><b>Video<sup class="text-danger">*</sup></b></label>
                    <input required type="file" class="form-control form-control-sm" id="media" name="media[]">
                    <br><br>
                `
            }

            document.getElementById('pilihanPost').innerHTML = postPilihan
        }

        form.onsubmit = (e) => {

            let formData = new FormData(form);

            // Ambil nilai dari inputan tagar
            let tagValues = Array.from(tags.getElementsByTagName('li')).map(tag => tag.textContent.trim());
            formData.append('tagar', JSON.stringify(tagValues));

            e.preventDefault();

            document.getElementById("tombol_kirim").disabled = true;

            axios({
                    method: 'post',
                    url: '/store-post',
                    data: formData,
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(function(res) {
                    //handle success         
                    if (res.data.responCode == 1) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: res.data.respon,
                            timer: 3000,
                            showConfirmButton: false
                        })

                        location.reload()

                    }

                    document.getElementById("tombol_kirim").disabled = false;
                })
                .catch(function(res) {
                    //handle error
                    console.log(res);
                    document.getElementById("tombol_kirim").disabled = false;
                });
        }
    </script>
    <script>
        // Get the tags and input elements from the DOM 
        const tags = document.getElementById('tags');
        const input = document.getElementById('input-tag');

        // Add an event listener for keydown on the input element 
        input.addEventListener('keydown', function(event) {

            // Check if the key pressed is 'Enter' 
            if (event.key === 'Enter') {

                // Prevent the default action of the keypress 
                // event (submitting the form) 
                event.preventDefault();

                // Create a new list item element for the tag 
                const tag = document.createElement('li');

                // Get the trimmed value of the input element 
                const tagContent = input.value.trim();

                // If the trimmed value is not an empty string 
                if (tagContent !== '') {

                    // Set the text content of the tag to  
                    // the trimmed value 
                    tag.innerText = tagContent;

                    // Add a delete button to the tag 
                    tag.innerHTML += '<button class="delete-button">X</button>';

                    // Append the tag to the tags list 
                    tags.appendChild(tag);

                    // Clear the input element's value 
                    input.value = '';
                }
            }
        });

        // Add an event listener for click on the tags list 
        tags.addEventListener('click', function(event) {

            // If the clicked element has the class 'delete-button' 
            if (event.target.classList.contains('delete-button')) {

                // Remove the parent element (the tag) 
                event.target.parentNode.remove();
            }
        });
    </script>
@endpush
