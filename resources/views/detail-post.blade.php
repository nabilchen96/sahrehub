@extends('layouts.template')
@push('style')
    <style>
        .teks {
            /* font-size: 12px; */
        }

        @media (min-width: 768px) {
            .scroll-container {
                overflow: auto;
                height: 335px
            }

        }

        .tag-title {
            display: none;
        }

        .pembungkus {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 450px;
            /* Minimal tinggi pembungkus */
            background-color: black;
        }

        video {
            max-height: 450px;
        }
    </style>
@endpush
@section('content')
    <div class="col-lg-1"></div>
    <div class="col-lg-10 p-0">
        <div class="row">
            <div class="col-lg-6">
                <div class="pembungkus">
                    @if (pathinfo($data->media, PATHINFO_EXTENSION) === 'mp4')
                        <video controls loop autoplay class="rounded-3 w-100">
                            <source src="{{ asset('media') }}/{{ $data->media }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    @else
                        <img src="{{ asset('media') }}/{{ $data->media }}" class="rounded-3 w-100" alt="Image">
                    @endif
                </div>
            </div>
            <div class="col-lg-6">
                <div class="pl-2 p-lg-0 d-flex justify-content-between mb-2 mt-3 mt-lg-0 align-items-center">
                    <!-- avatar -->
                    <a style="color: black; text-decoration: none;" href="{{ url('profil') }}?id={{ $data->id_user }}">
                        <div class="d-flex align-items-center">
                            <div>
                                <img style="object-fit: cover;" src="{{ asset('profile') }}/{{ $data->photo }}"
                                    alt="Image" class="mr-3 avatar avatar-md rounded-circle">
                            </div>
                            <div class="ms-3">
                                <h5 class="mb-0 ">{{ $data->name }}

                                </h5>
                                <p class="teks mb-0">
                                    {{ \Carbon\Carbon::parse($data->created_at)->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    </a>
                    <div class="d-flex justify-content-end">
                        <div class="text-center">
                            <i onclick="likePost('{{ $data->id }}')" id="like{{ $data->id }}"
                                style="font-size: 1.5rem;" class="bi bi-heart text-danger"></i> <br>
                            <span id="totalLikeValue{{ $data->id }}"
                                style="font-size: 12px;">{{ $data->total_like }}</span>
                        </div>
                        {{-- <div class="text-center"> <!-- Tambahkan kelas text-center di sini -->
                            <i style="font-size: 1.5rem;" class="text-warning bi bi-cash-coin"></i> <br>
                            <span style="font-size: 12px;">Saweria</span>
                        </div> --}}
                    </div>

                </div>
                <div class="scroll-container mb-3 pr-2 pl-2 pr-lg-0 pl-lg-0">

                    <p class="teks mt-3 pr-4">

                        @php echo htmlspecialchars_decode($data->keterangan); @endphp
                        <br>
                        <span class="text-info">
                            @php
                                // String input
                                $string = $data->tag;

                                // Pecah string menjadi array berdasarkan tanda koma
                                $words = explode(', ', $string);

                                // Lakukan perulangan pada setiap elemen array
                                foreach ($words as $word) {
                                    // Tambahkan tanda # di depan kata
                                    $word_with_hash = '#' . $word;

                                    // Membungkus setiap kata dengan tag <a href></a>
                                    $word_with_link =
                                        '<a href="' . url('eksplor') . '?id=' . $word . '">' . $word_with_hash . '</a>';

                                    // Cetak hasilnya
                                    echo $word_with_link . ' ';
                                }

                                $id_user = Auth::id() ?? 0;
                            @endphp
                        </span>


                        <hr class="mr-4">
                    <div id="komentar">

                    </div>
                    </p>
                </div>
                <form id="form">
                    @if (Auth::id())
                        <div style="height: 34px;" class="mt-3 input-group">
                            <input style="height: 34px;" type="text" class="form-control" placeholder="Komentar..."
                                name="keterangan" id="keterangan">
                            <button style="height: 34px; border-top-right-radius: 4px; border-bottom-right-radius: 4px;"
                                class="bg-info text-white input-group-text" id="tombol_kirim">
                                <i class="bi bi-send"></i>
                            </button>
                        </div>
                    @else
                        <a href="{{ url('login') }}" style="border-radius: 4px;" class="w-100 btn btn-sm btn-info">
                            Silahkan login untuk mulai berkomentar
                        </a>
                    @endif
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-1"></div>
@endsection
@push('script')
    <script src="{{ asset('js/views/comment.js') }}"></script>
    <script src="{{ asset('js/views/like.js') }}"></script>
    <script>
        loadComment()

        function loadComment() {

            let urlParams = new URLSearchParams(window.location.search);
            let id = urlParams.get('id');

            axios.get(`data-comment?id=${id}`).then(response => {
                let items = response.data;
                let tags = '';

                items.forEach(item => {
                    let trashButton = '';
                    if ({{ $id_user }} == item.id_user) {
                        trashButton = `
                            <a href="javascript:void(0)" onclick="hapusData(` + (item.id) + `)">
                                <i style="font-size: 9px;" class="bi bi-trash text-danger"></i>
                            </a>
                        `;
                    }
                    tags += `
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <img style="height: 25px; width: 25px;" src="/profile/${item.photo}" alt="Image" class="mr-2 avatar avatar-md rounded-circle">
                        </div>
                        <div class="ms-3 flex-grow-1">
                            <p class="teks mb-0" style="width: 95%;">
                                <b>${item.name}</b>
                                ${item.keterangan}
                            </p>
                        </div>
                        <div>
                            ${trashButton}
                        </div>
                    </div>
                    `;
                });


                document.getElementById('komentar').innerHTML = tags;
            });
        }
    </script>
@endpush
