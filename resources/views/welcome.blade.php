@extends('layouts.template')
@push('style')
    <style>
        video {
            max-height: 450px !important;
            background: black;
        }
    </style>
@endpush
@section('content')
    <div class="col-lg-1"></div>
    <div class="col-lg-7">
        <div class="row">
            {{-- <div class="col-lg-12 p-0 px-lg-3">
                <div class="pl-2">
                    <button class="btn btn-info btn-sm mb-2">Terbaru</button>
                    <button class="btn btn-info btn-sm mb-2">Terlama</button>
                    <button class="btn btn-info btn-sm mb-2">Sering Disukai</button>
                    <button class="btn btn-info btn-sm mb-2">Sering Dikomentari</button>
                </div>
            </div> --}}
            <div id="postingan"></div>
        </div>
    </div>
    <div class="col-lg-4 d-none d-lg-block">
        <div class="d-flex justify-content-center">
            <div>
                <p style="font-size: 18px;" class="mb-3 mt-1"><b>Populer 🔥</b></p>
                <div id="tagPopular"></div>
                @php
                    $id_user = Auth::id() ?? 0;
                @endphp
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{ asset('js/views/like.js') }}"></script>
    <script src="{{ asset('js/views/popular.js') }}"></script>
    <script src="{{ asset('js/views/timeformat.js') }}"></script>
    <script src="{{ asset('js/views/bookmark.js') }}"></script>
    <script>
        // Initial load
        let currentPage = 1;
        loadItems(currentPage);
        loadPopular();

        function loadItems(page) {
            axios.get(`data-post?page=${page}`)
                .then(response => {
                    const items = response.data.data;
                    const itemsDiv = document.getElementById('postingan');
                    let mediaElement = ``

                    items.forEach(item => {

                        let liked = '';
                        let bookmarked = '';
                        if ({{ $id_user }} != 0) {
                            if ({{ $id_user }} == item.id_user_like) {
                                liked = `
                                    <a style="color: black; text-decoration: none;" href="javascript:void(0)" onclick="likePost('${item.id}')">
                                        <i id="like${item.id}" style="font-size: 1.3rem;" class="bi bi-heart-fill text-danger"></i> <br>
                                        <span style="font-size: 12px;" id="totalLikeValue${item.id}">${item.total_like}</span>
                                    </a>
                                `;
                            } else {
                                liked = `
                                    <a style="color: black; text-decoration: none;" href="javascript:void(0)" onclick="likePost('${item.id}')">
                                        <i id="like${item.id}" style="font-size: 1.3rem;" class="bi bi-heart text-danger"></i> <br>
                                        <span style="font-size: 12px;" id="totalLikeValue${item.id}">${item.total_like}</span>
                                    </a>
                                `;
                            }

                            if ({{ $id_user }} == item.id_user_bookmark) {
                                bookmarked = `
                                    <a style="color: black; text-decoration: none;" href="javascript:void(0)" onclick="bookmarkPost('${item.id}')">
                                        <i id="bookmark${item.id}" style="font-size: 1.3rem;" class="bi bi-bookmark-fill text-warning"></i> <br>
                                    </a>
                                `;
                            } else {
                                bookmarked = `
                                    <a style="color: black; text-decoration: none;" href="javascript:void(0)" onclick="bookmarkPost('${item.id}')">
                                        <i id="bookmark${item.id}" style="font-size: 1.3rem;" class="bi bi-bookmark text-warning"></i> <br>
                                    </a>
                                `;
                            }
                        } else {
                            liked = `
                                <a style="color: black; text-decoration: none;" href="javascript:void(0)">
                                    <i id="like${item.id}" style="font-size: 1.3rem;" class="bi bi-heart text-danger"></i> <br>
                                    <span style="font-size: 12px;" id="totalLikeValue${item.id}">${item.total_like}</span>
                                </a>
                            `;

                            bookmarked = `
                                <a style="color: black; text-decoration: none;" href="javascript:void(0)">
                                    <i id="bookmark${item.id}" style="font-size: 1.3rem;" class="bi bi-bookmark text-warning"></i> <br>
                                </a>
                            `;
                        }

                        // Memeriksa tipe media
                        if (item.media.endsWith('.mp4')) {

                            mediaElement = `
                            <video controls loop style="border-radius: 10px;" class="rounded-3 w-100">
                                <source src="/media/${item.media}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                            `

                        } else {

                            mediaElement = `
                            <a href="/detail-post?id=${item.id}" style="text-decoration: none; color: black;">
                                <img style="border-radius: 10px;" 
                                src="/media/${item.media}"
                                class="rounded-3 w-100" alt="Image">
                            </a>
                            `
                        }

                        const div = document.createElement('div');
                        div.innerHTML = `
                        <div class="col-lg-12 mb-4 p-0 px-lg-3">
                            <div class="p-2">
                                ${mediaElement}
                                <div class="p-2 d-flex justify-content-between mt-3 mt-lg-2 align-items-center">
                                    <!-- avatar -->
                                    <a style="color: black; text-decoration: none;" href="/profil?id=${item.id_user}" class="d-flex align-items-center">
                                        <div>
                                            <img style="object-fit: cover;" src="/profile/${item.photo}"
                                                alt="Image" class="mr-3 avatar avatar-md rounded-circle">
                                        </div>
                                        
                                        <div class="ms-3">
                                            <h5 class="mb-0">${item.name}</h5>
                                            <p class="mb-0">${timeAgo(item.created_at)}</p>
                                        </div>
                                    </a>
                                    <div class="d-flex justify-content-end">
                                        <div class="mr-4 text-center">
                                            ${liked}
                                        </div>
                                        <div class="mr-4 text-center">
                                            <a href="/detail-post?id=${item.id}" style="text-decoration: none; color: black;">
                                                <i style="font-size: 1.3rem;" class="bi bi-chat-right-text text-info"></i> <br>
                                                <span style="font-size: 12px;">${item.total_comment}</span>
                                            </a>
                                        </div>
                                        <div class="text-center"> <!-- Tambahkan kelas text-center di sini -->
                                            ${bookmarked}
                                        </div>
                                    </div>
                                </div>
                                <div class="pr-2 pl-2">

                                    <hr>
                                    <p>
                                        ${item.keterangan}
                                        <br>
                                        <div class="text-info mt-1">
                                            ${item.tag.split(',').map(tag => `<a href="eksplor?id=${tag.trim()}">#${tag.trim()}</a>`).join(' ')}
                                        </div>
                                    </p>

                                </div>
                            </div>
                        </div> 
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
