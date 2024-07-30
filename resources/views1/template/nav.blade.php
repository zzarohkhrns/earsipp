<style>
    @media (max-width: 550px) {
        .hidden {
            display: none !important;
        }
    }
</style>
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i>
            </a>
        </li>
        <div class="d-flex align-items-center hidden">
            {{ $title }}
        </div>
    </ul>
    <ul class="navbar-nav ml-auto align-self-center mr-0">
        <li class="nav-item align-self-center mr-0">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item align-self-center mr-0">
            <a class="nav-link card-zero" data-widget="kontak" id="panduan" type="button">PANDUAN</a>
        </li>
        <li>
            <a href="https://siftnu.nucarecilacap.id/dashboard" class="mr-1">
                <img width="70px" src="{{ asset('images/siftnu.png') }}" alt="">
            </a>
            {{-- <a class="btn btn-logout m-0">
        <button class="btn btn-block btn-danger btn-sm">SIFNU  <i class="fa fa-sign-out-alt"></i></button>
      </a> --}}
        </li>
    </ul>
</nav>
