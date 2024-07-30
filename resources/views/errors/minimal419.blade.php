<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" href="<?= url('assets/images/favicon.png') ?>" type="image/x-icon">
        <link rel="shortcut icon" href="<?= url('assets/images/favicon.png') ?>" type="image/x-icon">
        <title>@yield('title')</title>

        

        <link href="{{ asset('bstrp/bootstrap.min.css') }}" rel="stylesheet"  >
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="{{ asset ('assets/plugins/fontawesome-free/css/all.min.css')}}">
        <style>
       /* body {
  display: flex;
  flex-flow: row wrap;
  align-content: center;
  justify-content: center;
} */

div {
  width: 100%;
  /* text-align: center; */
}

.number {
  background: #fff;
  position: relative;
  font: 900 8vmin "Consolas";
  letter-spacing: 0.5vmin;
  text-shadow: 3px -2px 0px #0a0a0a;
  /* text-shadow: 1px -1px 0 #000, 4px -2px 0 #0a0a0a, 1px -3px 0 #0f0f0f, 8px -4px 0 #141414, 6px -5px 0 #1a1a1a, 12px -1px 0 #1f1f1f, 14px -7px 0 #242424, 8px -8px 0 #292929; */
}
.number::before {
  background-color: #026435;
  background-image: radial-gradient(closest-side at 50% 50%, #28a745 100%, rgba(0, 0, 0, 0)), radial-gradient(closest-side at 50% 50%, #28a745 100%, rgba(0, 0, 0, 0));
  background-repeat: repeat-x;
  background-size: 8vmin 8vmin;
  background-position: -5vmin 5vmin, 1vmin -5vmin;
  width: 100%;
  height: 100%;
  mix-blend-mode: screen;
  -webkit-animation: moving 10s linear infinite both;
          animation: moving 10s linear infinite both;
  display: block;
  position: absolute;
  content: "";
}
@-webkit-keyframes moving {
  to {
    background-position: 10vmin 5vmin, -10vmin -5vmin;
  }
}
@keyframes moving {
  to {
    background-position: 10vmin 5vmin, -10vmin -5vmin;
  }
}

.text {
  font: 400 5vmin "Courgette";
}
.text span {
  font-size: 6vmin;
}

.text-hover{
  color:#41B548;
  text-decoration: none;
}

.text-hover:hover {
  color: black;
  background-color: transparent;
  text-decoration: underline;
}
.width-logo{
  width: 50%;
}
.width-logo-100{
  width: 100%;
}
@media only screen and (max-width: 600px) {
  .width-logo{
  width: 200px;
}

.number {
  background: #fff;
  position: relative;
  font: 900 18vmin "Consolas";
  letter-spacing: 0.5vmin;
  text-shadow: 3px -2px 0px #0a0a0a;
  /* text-shadow: 1px -1px 0 #000, 4px -2px 0 #0a0a0a, 1px -3px 0 #0f0f0f, 8px -4px 0 #141414, 6px -5px 0 #1a1a1a, 12px -1px 0 #1f1f1f, 14px -7px 0 #242424, 8px -8px 0 #292929; */
}

.number::before {
  background-color: #026435;
  background-image: radial-gradient(closest-side at 50% 50%, #28a745 100%, rgba(0, 0, 0, 0)), radial-gradient(closest-side at 50% 50%, #28a745 100%, rgba(0, 0, 0, 0));
  background-repeat: repeat-x;
  background-size: 18vmin 18vmin;
  background-position: -15vmin 15vmin, 11vmin -15vmin;
  width: 100%;
  height: 100%;
  mix-blend-mode: screen;
  -webkit-animation: moving 10s linear infinite both;
          animation: moving 10s linear infinite both;
  display: block;
  position: absolute;
  content: "";
}
@-webkit-keyframes moving {
  to {
    background-position: 20vmin 15vmin, -20vmin -15vmin;
  }
}
@keyframes moving {
  to {
    background-position: 20vmin 15vmin, -20vmin -15vmin;
  }
}

}
@media only screen and (max-width: 960px) {
  .width-logo{
  width: 300px;
}

.number {
  background: #fff;
  position: relative;
  font: 900 18vmin "Consolas";
  letter-spacing: 0.5vmin;
  text-shadow: 3px -2px 0px #0a0a0a;
  /* text-shadow: 1px -1px 0 #000, 4px -2px 0 #0a0a0a, 1px -3px 0 #0f0f0f, 8px -4px 0 #141414, 6px -5px 0 #1a1a1a, 12px -1px 0 #1f1f1f, 14px -7px 0 #242424, 8px -8px 0 #292929; */
}

.number::before {
  background-color: #026435;
  background-image: radial-gradient(closest-side at 50% 50%, #28a745 100%, rgba(0, 0, 0, 0)), radial-gradient(closest-side at 50% 50%, #28a745 100%, rgba(0, 0, 0, 0));
  background-repeat: repeat-x;
  background-size: 18vmin 18vmin;
  background-position: -15vmin 15vmin, 11vmin -15vmin;
  width: 100%;
  height: 100%;
  mix-blend-mode: screen;
  -webkit-animation: moving 10s linear infinite both;
          animation: moving 10s linear infinite both;
  display: block;
  position: absolute;
  content: "";
}
@-webkit-keyframes moving {
  to {
    background-position: 20vmin 15vmin, -20vmin -15vmin;
  }
}
@keyframes moving {
  to {
    background-position: 20vmin 15vmin, -20vmin -15vmin;
  }
}
}
        </style>
    </head>
    <body >
        
      <nav class="navbar navbar-expand-lg mt-5">
        <div class="container">
          <a class="navbar-brand" href="#"><img src="{{ asset('logo/lazisnu2.png') }}" alt="" srcset="" class="width-logo"></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              {{-- <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Features</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Pricing</a>
              </li> --}}
            </ul>
            <a class="navbar-text" style="font-size:25px;color:#28a745;">
              <i class="fab fa-whatsapp me-1"></i> <a href="" style="font-size:20px;color:#28a745;text-decoration: underline;">Kontak Admin</a> 
            </a>
          </div>
        </div>
      </nav>

<div class="container " style="margin-top:15vh;">
  <div class="row justify-content-center">
    {{-- <div class="row"> --}}
      <div class="col-12 col-md-12 col-lg-4 d-none d-lg-inline">
        <div class="container-fluid">
          <div class="mt-5"></div>
          <img src="{{ asset('logo/siftnu2.png') }}" alt="" srcset="" class="width-logo-100">
        </div>
      </div>
      <div class="col-12 col-md-12 col-lg-5 ps-5">
        <div class="number">@yield('code')</div>
        <div style="font-size: 20px;">
          <h3><b>@yield('title')</b></h3>
        </div>
        <div style="font-size: 25px;">
          @yield('message')
        </div>
        <div style="font-size: 25px;" class="mt-3">
          @yield('bottom')
        </div>
        <div class="mt-2" style="font-size: 20px">
        @hasSection('btn')
        <a href="{{ url()->previous() }}" class="btn text-white pe-4 ps-4" style="background-color:#28a745;font-size: 25px">
          @yield('btn')
        </a>
        @endif

        @hasSection('login')
        <a href="{{ route('login') }}" class="btn text-white pe-4 ps-4" style="background-color:#28a745;font-size: 25px">
          @yield('login')
        </a>
        @endif

        @hasSection('refresh')
        <a href="{{ url()->current() }}" class="btn text-white pe-4 ps-4" style="background-color:#28a745;font-size: 25px">
          @yield('refresh')
        </a>
        @endif
        </div>
      </div>
    {{-- </div> --}}
  </div>
</div>
{{-- <div class="text"><span>Sesi Anda Berakhir</span><br>Sesi anda berakhir karena tidak ada aktivitas penggunaan sistem selama 2 jam.<br> Silahkan login kembali dengan klik <a class="text-hover" href="{{ route('home') }}">SIFTNU</a>.<br>
<img src="{{ asset('logo/siftnu2.png') }}" alt="" srcset="" class="width-logo" class="me-2"><img src="{{ asset('logo/lazisnu2.png') }}" alt="" srcset="" class="width-logo"> --}}
{{-- </div> --}}
<nav class="navbar fixed-bottom navbar-dark "  style="background-color:#28a745">
  <div class="container-fluid">
    <div class="text-center pt-2 pb-2">

      <a class="navbar-brand" href="#">Copyright © 2023 NU Care Lazisnu Cilacap. All rights reserved.</a>
      <br>
      <a class="navbar-brand" href="#">Devoloped By PT. GOlet Digital Solusi</a>
    </div>
  </div>
</nav>
<script src="{{ asset('bstrp/bootstrap.bundle.min.js') }}" ></script>
    </body>
</html>
