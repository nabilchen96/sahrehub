<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('login-form-02/fonts/icomoon/style.css') }}">

    <link rel="stylesheet" href="{{ asset('login-form-02/css/owl.carousel.min.css') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('login-form-02/css/bootstrap.min.css') }}">

    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('login-form-02/css/style.css') }}">
    <link rel="shortcut icon" href="https://poltekbangplg.ac.id/wp-content/uploads/2020/06/favicon.ico"
        type="image/x-icon" />
    <title>Sahrehub Register Area</title>
</head>

<body>


    <div class="d-lg-flex half">
        <div class="bg order-1 order-md-2" style="background-image: url('mountain.png');"></div>
        <div class="contents order-2 order-md-1">

            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-7">
                        <h3>Register to <br><strong>Sahrehub</strong></h3>
                        <br>
                        <form id="formLogin">
                            <div class="form-group">
                                <label for="">Alamat Email</label>
                                <input type="email" name="email" class="form-control" id="email"
                                    placeholder="email" required>
                            </div>
                            <div class="form-group">
                                <label for="">Nama</label>
                                <input type="text" name="name" class="form-control" id="name"
                                    placeholder="Name" required>
                            </div>
                            <div class="form-group">
                                <label for="">Password Minimal 8 Karakter</label>
                                <input type="password" name="password" class="form-control" id="password"
                                    placeholder="Password" required>
                            </div>
                            <div class="mt-3">
                                {!! NoCaptcha::display() !!} 
                                {!! NoCaptcha::renderJs() !!}
                                <button id="btnLogin" 
                                class="mt-3 btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                                REGISTER

                                    <button style="display: none; background: #0d6efd;" id="btnLoginLoading"
                                        class="btn btn-info btn-moodle text-white btn-lg btn-block" type="button"
                                        disabled>
                                        <span class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span>
                                    </button>
                            </div>
                            <br>
                            Have an account? <a href="{{ url('login') }}" class="text-primary">Login</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <script src="{{ asset('js/axios/dist/axios.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.7/dist/sweetalert2.all.min.js"></script>

    <script>
        formLogin.onsubmit = (e) => {

            e.preventDefault();

            const formData = new FormData(formLogin);
            document.getElementById(`btnLogin`).style.display = "none";
            document.getElementById(`btnLoginLoading`).style.display = "block";

            axios({
                    method: 'post',
                    url: '/registerProses',
                    data: formData,
                })
                .then(function(res) {
                    //handle success
                    if (res.data.responCode == 1) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil Login',
                            timer: 1000,
                            text: 'Anda akan diarahkan ke halaman dashboard',
                            showConfirmButton: false,
                            // text: res.data.respon
                        })

                        setTimeout(() => {
                            location.replace('/');
                        }, 1500);

                    } else {

                        Swal.fire({
                            icon: 'warning',
                            title: 'Ada kesalahan',
                            text: `${res.data.respon}`,
                        })
                    }
                })
                .catch(function(res) {
                    //handle error
                    console.log(res);
                }).then(function() {
                    // always executed              
                    document.getElementById(`btnLogin`).style.display = "block";
                    document.getElementById(`btnLoginLoading`).style.display = "none";

                });

        }
    </script>

</body>

</html>
