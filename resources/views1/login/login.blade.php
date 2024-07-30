<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Lazisnu</title>
    <link rel="shortcut icon" href="{{ asset('images/logo_lazisnu.jpg') }}">

    <link href='https://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet'>


    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <link href='https://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet'>
    <style>
        /* set form background colour*/


        body {

            background-color: #1bb66e;

        }

        /*waves****************************/


        .box {
            position: fixed;
            top: 0;
            transform: rotate(80deg);
            left: 0;
        }

        .wave {
            position: fixed;
            top: 0;
            left: 0;
            opacity: .4;
            position: absolute;
            top: 3%;
            left: 10%;
            background: #0f9255;
            width: 1500px;
            height: 1300px;
            margin-left: -150px;
            margin-top: -250px;
            transform-origin: 50% 48%;
            border-radius: 43%;
            animation: drift 7000ms infinite linear;
        }

        .wave.-three {
            animation: drift 7500ms infinite linear;
            position: fixed;
            background-color: #109c5b;
        }

        .wave.-two {
            animation: drift 3000ms infinite linear;
            opacity: .1;
            background: black;
            position: fixed;
        }

        .box:after {
            content: '';
            display: block;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            z-index: 11;
            transform: translate3d(0, 0, 0);
        }

        @keyframes drift {
            from {
                transform: rotate(0deg);
            }

            from {
                transform: rotate(360deg);
            }
        }

        /*LOADING SPACE*/

        .contain {
            animation-delay: 4s;
            z-index: 1000;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-flow: row nowrap;
            flex-flow: row nowrap;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;

            background: #25a7d7;
            background: -webkit-linear-gradient(#25a7d7, #2962FF);
            background: linear-gradient(#25a7d7, #25a7d7);
        }

        .icon {
            width: 100px;
            height: 100px;
            margin: 0 5px;
        }

        /*Animation*/
        .icon:nth-child(2) img {
            -webkit-animation-delay: 0.2s;
            animation-delay: 0.2s
        }

        .icon:nth-child(3) img {
            -webkit-animation-delay: 0.3s;
            animation-delay: 0.3s
        }

        .icon:nth-child(4) img {
            -webkit-animation-delay: 0.4s;
            animation-delay: 0.4s
        }

        .icon img {
            -webkit-animation: anim 2s ease infinite;
            animation: anim 2s ease infinite;
            -webkit-transform: scale(0, 0) rotateZ(180deg);
            transform: scale(0, 0) rotateZ(180deg);
        }

        @-webkit-keyframes anim {
            0% {
                -webkit-transform: scale(0, 0) rotateZ(-90deg);
                transform: scale(0, 0) rotateZ(-90deg);
                opacity: 0
            }

            30% {
                -webkit-transform: scale(1, 1) rotateZ(0deg);
                transform: scale(1, 1) rotateZ(0deg);
                opacity: 1
            }

            50% {
                -webkit-transform: scale(1, 1) rotateZ(0deg);
                transform: scale(1, 1) rotateZ(0deg);
                opacity: 1
            }

            80% {
                -webkit-transform: scale(0, 0) rotateZ(90deg);
                transform: scale(0, 0) rotateZ(90deg);
                opacity: 0
            }
        }

        @keyframes anim {
            0% {
                -webkit-transform: scale(0, 0) rotateZ(-90deg);
                transform: scale(0, 0) rotateZ(-90deg);
                opacity: 0
            }

            30% {
                -webkit-transform: scale(1, 1) rotateZ(0deg);
                transform: scale(1, 1) rotateZ(0deg);
                opacity: 1
            }

            50% {
                -webkit-transform: scale(1, 1) rotateZ(0deg);
                transform: scale(1, 1) rotateZ(0deg);
                opacity: 1
            }

            80% {
                -webkit-transform: scale(0, 0) rotateZ(90deg);
                transform: scale(0, 0) rotateZ(90deg);
                opacity: 0
            }
        }
    </style>
    <style>
        label {
            font-weight: normal !important;
        }
    </style>

</head>
<div class='box'>
    <div class='wave -one'></div>
    <div class='wave -two'></div>
    <div class='wave -three'></div>
</div>

<body class="hold-transition register-page area" style="  background-color:  #1bb66e;font-family: 'Comfortaa' ;">

    <!-- Login form creation starts-->


    <div class="register-box">
        <div class="card card-outline " style=" border-radius:10px; ">


            <div class="card-body">


                <form class="form-container" action="{{ route('login.action') }}" method="post" class="login-form">
                    @csrf
                    <div class="form-group">

                        <img src="{{ asset('images/logo_lazisnu.jpg') }}"
                            style="display: block;
                        margin-left: auto;
                        margin-right: auto;
                        width: 70%;
                        height: auto;">

                        {{-- menampilkan error validasi --}}
                        @if (count($errors) > 0)
                            <div class="alert alert-danger" role="alert">
                                <div class="text-center">
                                    Username atau password salah!
                                </div>
                            </div>
                        @endif

                        <label>Nohp</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="InputEmail1" aria-describeby="emailHelp"
                                name="nohp" required>
                            {{-- <div class="input-group-append">
                                <div class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="InputPassword1">Password</label>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" id="InputPassword1" name="password" required>
                            {{-- <div class="input-group-append">
                                <div class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    <br>

                    <button type="submit" class="btn btn-success btn-block btn-lg">Login</button>

                </form>

            </div>
        </div>

    </div>
    <!-- /.form-box -->
    <div class="text-light
    text-center mt-2">
        <p style="font-family: 'Comfortaa' ;
font-size:12px; ">
            {{ Carbon\Carbon::now()->isoFormat('Y') }} | <i>NU Care Lazisnu Cilacap</i></p>
    </div>



    <!-- jQuery -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>

    <!-- Login form creation ends -->
    <script>
        $(".alert").delay(4000).slideUp(200, function() {
            $(this).alert('close');
        });
    </script>
</body>

</html>
