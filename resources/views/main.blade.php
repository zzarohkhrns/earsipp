<!DOCTYPE html>
<html lang="en">
<!DOCTYPE html>

<head>
@notifyCss
    <!-- Tagsinput CSS -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">

    <style>
        .hidden {
            display: none;
        }
    </style>
    <!-- into js -->
    {{-- @include('template.introjs') --}}
    <!-- intro js end -->

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
    
        body {
            overflow-x: hidden;
        }


        /*
        .select2-selection {
            height: 38px !important;
        }
        
        .select2-selection__arrow {
            height: 38px !important;
        } */

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #007bff !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: white !important;
            cursor: pointer;
            display: inline-block;
            font-weight: bold;
            margin-right: 2px;
        }


        label {
            font-weight: normal !important;
        }
        
    #laravel-notify{
        z-index: 9999 !important;
    }
    </style>
    <title>E-ARSIP</title>

    <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>

    <link rel="icon" href="{!! asset('images/ear.png') !!}" />
    @include('template.css')

    @yield('css')
    @livewireStyles
    

    <style>
        #cover-spin {
            position: fixed;
            width: 100%;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            background-color: black;
            z-index: 9999;
            display: none;
            opacity: 0.5;
        }

        @-webkit-keyframes spin {
            from {
                -webkit-transform: rotate(0deg);
            }

            to {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        #cover-spin::after {
            content: '';
            display: block;
            position: absolute;
            left: 48%;
            top: 40%;
            width: 60px;
            height: 60px;
            border-style: solid;
            border-color: white;
            border-top-color: transparent;
            border-width: 9px;
            border-radius: 50%;
            -webkit-animation: spin .8s linear infinite;
            animation: spin .8s linear infinite;
        }
    </style>
</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">

    <div class="wrapper">

        <div id="cover-spin"></div>
        <!-- Navbar -->
        @include('template.nav')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('template.side')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @include('sweetalert::alert')
            @yield('content')

        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        @include('template.footer')
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    @include('template.js')

    @yield('js')
    @livewireScripts


    @stack('intro_sidebar')

    @stack('intro_memo')
    @stack('intro_detail_memo')
    @stack('intro_tambah_memo')

    @stack('intro_berita')
    @stack('intro_detail_berita')
    @stack('intro_tambah_berita')

    @stack('intro_kategori_berita')

    @stack('intro_kegiatan')
    @stack('intro_detail_kegiatan')

    @stack('intro_notulen')

    @stack('intro_jenis_kegiatan')

    @stack('intro_surat_masuk')
    @stack('tambah_surat_masuk')
    @stack('intro_detail_surat_masuk')

    @stack('intro_surat_keluar')
    @stack('tambah_surat_keluar')
    @stack('intro_detail_surat_keluar')

    @stack('jenis_kode_surat_keluar')

    @stack('intro_dokumen')
    @stack('tambah_dokumen')
    @stack('intro_detail_dokumen')
    @stack('autofill_penerima_surat')

 <x-notify::notify />
        @notifyJs
</body>

{{-- <script>
    (document).ready(function() {
        $("#ini").select2({ maximumSelectionLength: 1 });
    });
</script> --}}

@stack('custom-scripts')


<script>
    //redirect to specific tab
    $(document).ready(function() {
        $('#tabMenu a[href="#{{ old('tab') }}"]').tab('show')
    });
</script>

<!-- bs-custom-file-input -->
<script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.js') }}"></script>
<script>
    $(function() {
        bsCustomFileInput.init();
    });
</script>



<script src="{{ asset('sweet/sweetalert2@11.js') }}"></script>

@if (Auth::check())
    <script>
        var timeout = ({{ config('session.lifetime') }} * 60000) - 10;
        setTimeout(function() {
            Swal.fire({
                title: 'Sesi Login Berakhir',
                text: 'Silahkan Login Lagi!',
                icon: 'info',
                confirmButtonText: 'Login'
            }).then((result) => {
                if (result) {
                    // Do Stuff here for success
                    location.reload();
                }

            });
            // alert('Sesi Login Anda Berakhir')? '': location.reload();
        }, timeout);
    </script>
@endif


</html>

@stack('modal_tambah')
@stack('disable_send')
