@extends('layouts.template')
@push('style')
    <style>
        .gambar-eksplor {
            aspect-ratio: 1/1;
            width: 100%;
            object-fit: cover;
        }
    </style>
@endpush
@section('content')
    <div class="col-lg-1"></div>
    <div class="col-lg-10">
        <div class="row">
            <div class="col-lg-12 p-1">
                <a href="{{ url('like-activity') }}" class="btn btn-sm mb-2 btn-info">Like</a>
                <a href="{{ url('comment-activity') }}" class="btn btn-sm btn-warning text-white mb-2">Komentar</button>
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

            axios.get(`data-comment-activity?page=${page}`)
                .then(response => {
                    const items = response.data;

                    items.data.forEach(item => {
                        const div = document.createElement('div');
                        div.classList.add('col-12', 'p-1'); // Menambahkan kelas col-4 ke div utama
                        div.innerHTML = `
                        <p>
                            <h5>${item.keterangan}</h5>
                            <div class="ml-3">
                                <i class="bi bi-arrow-return-right"></i> ${item.komentar} <br>
                                <i class="bi bi-clock"></i> ${item.waktu_komentar}<br>
                                <a href="/detail-post?id=${item.id}">
                                    <i class="bi bi-folder-symlink"></i> <b> See Post</b>
                                </a>
                            </div>
                        </p>
                        <hr>
                    `;

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
