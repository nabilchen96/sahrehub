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
        <div class="row">
            <div class="col-lg-12 p-1">
                <a href="{{ url('like-activity') }}" class="btn btn-sm mb-2 btn-warning text-white">Like</a>
                <a href="{{ url('up-activity') }}" class="btn btn-sm mb-2 btn-info">Up</a>
                <a href="{{ url('comment-activity') }}" class="btn btn-sm btn-info mb-2">Komentar</a>
                <a href="{{ url('bookmark-activity') }}" class="btn btn-sm btn-info mb-2">Bookmark</a>
                <a href="{{ url('post-activity') }}" class="btn btn-sm btn-info mb-2">Post</a>
            </div>
        </div>
        <div class="row" id="postingan">
        </div>
    </div>
    <div class="col-lg-1"></div>
@endsection
@push('script')
    <script>
        // Initial load
        let currentPage = 1;
        loadItems(currentPage);

        function loadItems(page) {
            const itemsDiv = document.getElementById('postingan');

            axios.get(`data-like-activity?page=${page}`)
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
                            
                            const imageArray = item.media.split(', ');

                            mediaElement = `
                                <a href="/detail-post?id=${item.id}">
                                    <img class="gambar-eksplor" src="/media/${imageArray[0]}"
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


        // Load more items when scroll reaches the bottom
        window.addEventListener('scroll', function() {
            if (Math.round(window.innerHeight + window.scrollY) >= document.documentElement.scrollHeight) {
                loadItems(currentPage);
            }
        });
    </script>
@endpush
