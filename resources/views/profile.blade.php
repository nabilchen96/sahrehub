@extends('layouts.template')
@push('style')
    <style>
        .gambar-eksplor,
        video {
            aspect-ratio: 1/1;
            width: 100%;
            object-fit: cover;
        }

        .video-icon {
            margin: 15px;
            font-size: 30px;
            color: white;
        }

        .profile-photo {
            aspect-ratio: 1/1;
            background-position: center;
            background-size: cover;
            width: 23%;
            border-radius: 100%;
            /* border: 3px solid black; */
        }

        .item-center {
            margin-left: auto;
            margin-right: auto;
        }

        .background-profile {
            background-image: linear-gradient(45deg, grey, transparent), url('https://cdn.pixabay.com/photo/2022/01/11/17/04/city-6931092_1280.jpg');
            height: 200px;
            background-position: center;
            background-size: cover;
            width: 100%;
        }
    </style>
@endpush
@section('content')
    <div class="col-lg-1"></div>
    <div class="col-lg-10">
        <div class="row mb-3">
            <div class="col-12 p-1">
                <div id="profile-photo"></div>
                <div id="profile-name"></div>
                <div id="profile-keterangan"></div>
                <div id="profile-website"></div>
                <div id="profile-created"></div>
            </div>
        </div>
        <div class="row" id="postingan"></div>
    </div>
    <div class="col-lg-1"></div>
    <!-- Modal -->
    @if (Auth::id())
        <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <form id="form">
                            <input type="hidden" name="id" id="id">
                            <div class="mb-3">
                                <label><b>Nama<sup class="text-danger">*</sup></b></label>
                                <input type="text" placeholder="Nama" class="form-control" name="name" id="name"
                                    required>
                            </div>
                            <div class="mb-4">
                                <label><b>Password</b></label>
                                <input placeholder="Password" type="password" class="form-control form-control-sm"
                                    id="media" name="media">
                            </div>
                            <div class="mb-4">
                                <label><b>Keterangan</b></label>
                                <textarea name="keterangan" id="keterangan" cols="30" rows="5" placeholder="Keterangan" class="form-control"></textarea>
                            </div>
                            <div class="mb-4">
                                <label><b>Website</b></label>
                                <input type="text" class="form-control" name="website" id="website"
                                    placeholder="Website">
                            </div>
                            <div class="mb-4">
                                <label><b>Foto Profil</b></label>
                                <input placeholder="Foto Profil" type="file" class="form-control form-control-sm"
                                    id="photo" name="photo">
                            </div>
                            <div>
                                <button id="tombol_kirim" class="btn btn-sm btn-info"
                                    style="height: 38px; border-radius: 4px;">
                                    Simpan!
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
@push('script')
    <script src="{{ asset('js/views/timeformat.js') }}"></script>
    <script>
        // Initial load
        let currentPage = 1;
        let name
        let id_user
        let keterangan
        let website

        loadItems(currentPage);
        loadProfile()

        function loadProfile() {
            let urlParams = new URLSearchParams(window.location.search);
            let id = urlParams.get('id');

            axios.get(`data-profil?id=${id}`).then(res => {
                let data = res.data

                name = data.name
                id_user = data.id
                keterangan = data.keterangan
                website = data.website

                //profile photo
                document.getElementById('profile-photo').innerHTML = `
                    <div style="z-index: 1; background-image: url('/profile/${data.photo}');" 
                    class="profile-photo item-center">
                        <sup>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#modal">
                                <i class="bi bi-gear text-right" style="z-index: 9; font-size: 1.5rem;"></i>
                            </a>
                        </sup>
                    </div>
                `

                //profile name
                document.getElementById('profile-name').innerHTML = `
                    <h3 class="text-center mt-4">${data.name}</h3>
                `

                //profile created
                document.getElementById('profile-created').innerHTML = `
                    <p class="text-center text-muted mb-2">Bergabung Sejak ${timeAgo(data.created_at)}</p>
                `

                //profile keterangan
                document.getElementById('profile-keterangan').innerHTML = `
                    <p class="text-center mb-2">${data.keterangan}</p>
                `

                //profile keterangan
                document.getElementById('profile-website').innerHTML = `
                    <a href="${data.website}" class="text-center mb-2">
                        <p>
                            <i class="bi bi-globe"></i> ${data.website}
                        </p>
                    </a>
                `
            })
        }

        function loadItems(page) {
            axios.get(`data-profil-post?id={{ Request('id') }}&page=${page}`)
                .then(response => {
                    const items = response.data.data;
                    const itemsDiv = document.getElementById('postingan');

                    items.forEach(item => {

                        let mediaElement = ``

                        // Memeriksa tipe media
                        if (item.media.endsWith('.mp4')) {
                            mediaElement = `
                                <a href="/detail-post?id=${item.id}">
                                    <video src="/media/${item.media}" class="video__player"></video>
                                    <i class="video-icon bi bi-camera-reels" style="position: absolute; top: 0; right: 0;"></i>
                                </a>
                            `
                        } else {

                            mediaElement = `
                                <a href="/detail-post?id=${item.id}">
                                    <img class="gambar-eksplor" src="/media/${item.media}"
                                        alt="${item.tag}">
                                </a>
                            `;
                        }

                        const div = document.createElement('div');
                        div.classList.add('col-4', 'p-1'); // Menambahkan kelas col-4 ke div utama
                        div.innerHTML = mediaElement
                        itemsDiv.appendChild(div);
                    });

                    currentPage++;
                });
        }

        let modal = document.getElementById('modal')
        modal.addEventListener('show.bs.modal', function(event) {
            document.getElementById('name').value = name
            document.getElementById('id').value = id_user
            document.getElementById('keterangan').value = keterangan ?? ''
            document.getElementById('website').value = website ?? ''
        })

        //store
        form.onsubmit = (e) => {

            let formData = new FormData(form);

            e.preventDefault();

            document.getElementById("tombol_kirim").disabled = true;

            axios({
                    method: 'post',
                    url: '/update-profil',
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
                });
        }

        // Load more items when scroll reaches the bottom
        window.addEventListener('scroll', function() {
            if (Math.round(window.innerHeight + window.scrollY) >= document.documentElement.scrollHeight) {
                loadItems(currentPage);
            }
        });
    </script>
@endpush
