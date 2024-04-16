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
            font-size: 100%;
            color: white;
        }
    </style>
@endpush
@section('content')
    <div class="col-lg-1"></div>
    <div class="col-lg-10">
        <form>
            <div class="row">
                <div style="height: 34px;" class="col-12 p-1 mb-3 input-group">
                    <input id="q" style="height: 34px;" type="text" class="form-control" value="{{ Request('id') }}"
                        name="id" placeholder="Cari Post, atau gunakan tag tanpa # untuk mencari">
                    <button style="height: 34px;" class="bg-info text-white input-group-text" id="basic-addon2">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
        </form>
        <div class="row" id="postingan">
        </div>
    </div>
    <div class="col-lg-1"></div>
@endsection
@push('script')
    <script>
        // Initial load
        let currentPage = 1;
        let beforeq = ''
        loadItems(currentPage);

        function loadItems(page) {
            let q = document.getElementById('q').value
            const itemsDiv = document.getElementById('postingan');

            if (q != beforeq) {
                itemsDiv.innerHTML = '';
            }

            axios.get(`data-eksplor?q=${q}&page=${page}`)
                .then(response => {
                    const items = response.data;


                    items.data.forEach(item => {
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
                                        alt="${item.keterangan}">
                                </a>
                            `;
                        }

                        const div = document.createElement('div');
                        div.classList.add('col-4', 'p-1'); // Menambahkan kelas col-4 ke div utama
                        div.innerHTML = mediaElement

                        itemsDiv.appendChild(div);
                    });

                    currentPage++;
                    beforeq = q
                });
        }


        // Load more items when scroll reaches the bottom
        window.addEventListener('scroll', function() {
            console.log('innerHeight= ' + Math.round(window.innerHeight));
            console.log('scrollY= ' + Math.round(window.scrollY));
            console.log('innerHeight + scrollY= ' + Math.round(window.scrollY + window.innerHeight));
            console.log('scrollHeight= ' + document.documentElement.scrollHeight);
            if (Math.round(window.innerHeight + window.scrollY) >= document.documentElement.scrollHeight) {
                loadItems(currentPage);
            }
        });
    </script>
@endpush
