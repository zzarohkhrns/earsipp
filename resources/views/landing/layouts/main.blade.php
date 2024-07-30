<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Lazisnu</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo_lazisnu.jpg') }}">
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('landing/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('landing/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Raleway:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('landing/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('landing/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('landing/vendor/aos/aos.css" rel="stylesheet') }}">
    <link href="{{ asset('landing/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('landing/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('landing/css/main.css') }}" rel="stylesheet">

    <!-- =======================================================
  * Template Name: Impact - v1.1.0
  * Template URL: https://bootstrapmade.com/impact-bootstrap-business-website-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
    {{-- header --}}
    @include('landing.layouts.header')

    @yield('container')


    {{-- footer --}}
    @include('landing.layouts.footer')


    <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ 'landing/vendor/bootstrap/js/bootstrap.bundle.min.js' }}"></script>
    <script src="{{ 'landing/vendor/aos/aos.js' }}"></script>
    <script src="{{ 'landing/vendor/glightbox/js/glightbox.min.js' }}"></script>
    <script src="{{ 'landing/vendor/purecounter/purecounter_vanilla.js' }}"></script>
    <script src="{{ 'landing/vendor/swiper/swiper-bundle.min.js' }}"></script>
    <script src="{{ 'landing/vendor/isotope-layout/isotope.pkgd.min.js' }}"></script>
    <script src="{{ 'landing/vendor/php-email-form/validate.js' }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ 'landing/js/main.js' }}"></script>

</body>

</html>
