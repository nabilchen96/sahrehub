@extends('layouts.template')
@push('style')
    <style>
        video {
            max-height: 500px !important;
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
    <script src="{{ asset('js/views/up_post.js') }}"></script>
    <script src="{{ asset('js/views/bookmark.js') }}"></script>
    <script src="{{ asset('js/views/welcome-post.js') }}"></script>
    <script>
        // Initial load
        let currentPage = 1;
        loadItems(currentPage);
        loadPopular();
        let id_loggedin = {{ $id_user }} ?? 0
        let url = 'https://social.sahrebook.com'
    
        // Load more items when scroll reaches the bottom
        window.addEventListener('scroll', function() {
            if (Math.round(window.innerHeight + window.scrollY) >= document.documentElement.scrollHeight) {
                loadItems(currentPage);
            }
        });
    </script>
@endpush
