@extends('main')

@section('dashboard', 'active')
@section('title', $title)

@section('css')

@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">

                    @php
                        if (Auth::user()->gocap_id_pc_pengurus != null) {
                            $log = 'Arsip PC NU Care Lazisnu Cilacap';
                        } else {
                            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
                            $log = 'Upzis ' . $wilayah;
                        }
                    @endphp
                    @if (Auth::user()->gocap_id_pc_pengurus != null)
                        <h1 class="m-0">{{ $log }}</h1>
                    @else
                        <h1 class="m-0">{{ $log }}</h1>
                    @endif
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">
                                {{ Carbon\Carbon::parse(now())->isoFormat('dddd, D MMMM Y') }}</a></li>
                        {{-- <li class="breadcrumb-item active">Dashboard</li> --}}
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">

                @php
                    if (Auth::user()->gocap_id_pc_pengurus) {
                        $display = '';
                    } else {
                        $display = 'display:none;';
                    }
                @endphp
                <div class="col-12 col-sm-3 " style="{{ $display }}">
                    <div class="card ijo-kiri h-card">
                        <div class="container pl-2">
                            <div class="d-flex align-items-start">
                                <div class="info-box-content pt-1">
                                    <span class="info-box-text">Memo Internal</span>
                                    <span class="info-box-text"><b>

                                            <h3>{{ $jumlah_memo }}</h3>

                                        </b></span>
                                    <p class="info-box-text">

                                        <a href="/{{ $role }}/arsip/memo" class="text-success"
                                            style="font-size: 16px;"><i>
                                                << Lihat Detail>>
                                            </i> </a>

                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>
                <div class="col-12 col-sm-3 " style="{{ $display }}">
                    <div class="card ijo-kiri h-card">
                        <div class="container pl-2">

                            <div class="d-flex align-items-start">
                                <div class="info-box-content pt-1">
                                    <span class="info-box-text">Berita Umum</span>
                                    <span class="info-box-text"><b>
                                            <h3>{{ $jumlah_berita }}</h3>
                                        </b></span>
                                    <p class="info-box-text">

                                        <a href="/{{ $role }}/arsip/berita" class="text-success"
                                            style="font-size: 16px;"><i>
                                                << Lihat Detail>>
                                            </i> </a>

                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>
                <div class="col-12 col-sm-3 ">
                    <div class="card ijo-kiri h-card">
                        <div class="container pl-2">
                            <div class="d-flex align-items-start">
                                <div class="info-box-content pt-1">
                                    <span class="info-box-text">Kegiatan & Notulen</span>
                                    <span class="info-box-text"><b>
                                            <h3>{{ $jumlah_kegiatan }}</h3>
                                        </b></span>
                                    <p class="info-box-text">
                                        @if (Auth::user()->gocap_id_pc_pengurus)
                                            <a href="/{{ $role }}/arsip/kegiatan_pc/{hal}" class="text-success"
                                                style="font-size: 16px;"><i>
                                                    << Lihat Detail>>
                                                </i> </a>
                                        @else
                                            <a href="/{{ $role }}/arsip/kegiatan_upzis/" class="text-success"
                                                style="font-size: 16px;"><i>
                                                    << Lihat Detail>>
                                                </i> </a>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-3 ">

                    <div class="card ijo-kiri h-card">
                        <div class="container pl-2">
                            <div class="d-flex align-items-start">
                                <div class="info-box-content pt-1">
                                    <span class="info-box-text">Arsip Dokumen</span>
                                    <span class="info-box-text"><b>
                                            <h3>{{ $jumlah_dokumen }}</h3>
                                        </b></span>

                                    <p class="info-box-text">
                                        @if (Auth::user()->gocap_id_pc_pengurus)
                                            <a href="/{{ $role }}/arsip/dokumen_digital_pc/pc" class="text-success"
                                                style="font-size: 16px;"><i>
                                                    << Lihat Detail>>
                                                </i> </a>
                                        @else
                                            <a href="/{{ $role }}/arsip/dokumen_digital_upzis/pc"
                                                class="text-success" style="font-size: 16px;"><i>
                                                    << Lihat Detail>>
                                                </i> </a>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>


                <div class="col-12 col-sm-3 ">

                    <div class="card ijo-kiri h-card">
                        <div class="container pl-2">
                            <div class="d-flex align-items-start">
                                <div class="info-box-content pt-1">
                                    <span class="info-box-text">Surat Masuk</span>
                                    <span class="info-box-text"><b>
                                            <h3>{{ $jumlah_surat_masuk }}</h3>
                                        </b></span>
                                    <p class="info-box-text">
                                        @if (Auth::user()->gocap_id_pc_pengurus)
                                            <a href="/{{ $role }}/arsip/surat_masuk_pc/pc" class="text-success"
                                                style="font-size: 16px;"><i>
                                                    << Lihat Detail>>
                                                </i> </a>
                                        @else
                                            <a href="/{{ $role }}/arsip/surat_masuk_upzis/pc" class="text-success"
                                                style="font-size: 16px;"><i>
                                                    << Lihat Detail>>
                                                </i> </a>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>

                <br>

                <div class="col-12 col-sm-3 ">

                    <div class="card ijo-kiri h-card">
                        <div class="container pl-2">
                            <div class="d-flex align-items-start">
                                <div class="info-box-content pt-1">
                                    <span class="info-box-text">Surat Keluar</span>
                                    <span class="info-box-text"><b>
                                            <h3>{{ $jumlah_surat_keluar }}</h3>
                                        </b></span>

                                    <p class="info-box-text">
                                        @if (Auth::user()->gocap_id_pc_pengurus)
                                            <a href="/{{ $role }}/arsip/surat_keluar_pc/pc" class="text-success"
                                                style="font-size: 16px;"><i>
                                                    << Lihat Detail>>
                                                </i> </a>
                                        @else
                                            <a href="/{{ $role }}/arsip/surat_keluar_upzis/pc" class="text-success"
                                                style="font-size: 16px;"><i>
                                                    << Lihat Detail>>
                                                </i> </a>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>
                <div class="col-12 col-sm-3 " style="{{ $display }}">
                    <div class="card ijo-kiri h-card">
                        <div class="container pl-2">

                            <div class="d-flex align-items-start">
                                <div class="info-box-content pt-1">
                                    <span class="info-box-text">Data Aset</span>
                                    <span class="info-box-text"><b>
                                            {{-- <h3>{{ $jumlah_aset }}</h3> --}}
                                            <h3>{{ $jumlah_aset }}</h3>
                                        </b></span>
                                    <p class="info-box-text">

                                        <a href="/{{ $role }}/arsip/aset/data" class="text-success"
                                            style="font-size: 16px;"><i>
                                                << Lihat Detail>>
                                            </i> </a>

                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>





            </div>
        </div>



    </section>

@endsection

@section('js')

    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <!-- AdminLTE -->
    <script src="{{ asset('assets/dist/js/adminlte.js') }}"></script>

    <!-- OPTIONAL SCRIPTS -->
    <script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>



    <script>
        $(function() {
            $('#example2').DataTable({
                "pageLength": 6,
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });

        $('#example3').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    </script>

    <script>
        $(function() {

            var areaChartDatas = {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                datasets: [{
                    label: 'Jumlah Pengunjung',
                    backgroundColor: 'rgba(40,167,69)',
                    borderColor: 'rgba(40,167,69)',
                    pointRadius: false,
                    pointColor: '#28A745',
                    pointStrokeColor: 'rgba(40,167,69)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(40,167,69)',
                    data: [28, 48, 40, 19, 86, 27, 90]
                }, ]
            }
            //-------------
            //- BAR CHART -
            //-------------
            var barChartCanvas = $('#barChart').get(0).getContext('2d')
            var barChartData = $.extend(true, {}, areaChartDatas)
            var temp0 = areaChartDatas.datasets[0]
            barChartData.datasets[0] = temp0

            var barChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                datasetFill: false
            }

            new Chart(barChartCanvas, {
                type: 'bar',
                data: barChartData,
                options: barChartOptions
            })

            //---------------------
            //- STACKED BAR CHART -
            //---------------------
            var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')


            var stackedBarChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        stacked: true,
                    }],
                    yAxes: [{
                        stacked: true
                    }]
                }
            }

            new Chart(stackedBarChartCanvas, {
                type: 'bar',
                data: stackedBarChartData,
                options: stackedBarChartOptions
            })
        })
    </script>


    @push('intro_sidebar')
        {{-- <script>
            var yeso = document.getElementById("panduan");
        </script> --}}
        @if (Auth::user()->gocap_id_pc_pengurus != null)
            <script>
                function klikkene(value) {
                    introJs().setOptions({
                            steps: [{
                                    element: document.querySelector('.card-zero'),
                                    title: 'Tour Guide',
                                    intro: 'Untuk Menampilkan Panduan Penggunaan Sistem Pada Setiap Halaman'
                                },
                                {
                                    element: document.querySelector('.card-first'),
                                    title: 'Dashboard',
                                    intro: 'Untuk Menampilkan Statistik Data Arsip'
                                },
                                {
                                    element: document.querySelector('.card-second'),
                                    title: 'Memo Internal',
                                    intro: 'Manajemen Arsip Memo Internal Direktur Eksekutif dan Ketua Pengurus'
                                },
                                {
                                    element: document.querySelector('.card-third'),
                                    title: 'Berita Umum',
                                    intro: 'Manajemen Arsip Berita Umum Yang Tersinkronasi Dengan Aplikasi GOCAP'
                                },
                                {
                                    element: document.querySelector('.card-four'),
                                    title: 'Kegiatan & Notulen',
                                    intro: 'Manajemen Arsip Kegiatan dan Notulen Pembahasan'
                                },
                                {
                                    element: document.querySelector('.card-five'),
                                    title: 'Manajemen Arsip Surat',
                                    intro: 'Membuat Surat Keluar, Menerima Surat Masuk & Mendisposisikan Surat (Penerima Disposisi Mendapatkan Notifikasi WA)'
                                },
                                {
                                    element: document.querySelector('.card-six'),
                                    title: 'Arsip Dokumen',
                                    intro: 'Manajemen Arsip Dokumen, Klasifikasi Dokumen Dan Mendisposisikan Dokumen'
                                }
                            ]
                        }).setOption("dontShowAgain", value)
                        .setOption("skipLabel", "<p widht='100px' style='font-size:12px;color:blue;'><u>Lewati</u> </p>")
                        .setOption("dontShowAgainLabel", " Jangan Tampilkan Lagi")
                        .setOption("disableInteraction", true)
                        .setOption("nextLabel", "Lanjut")
                        .setOption("prevLabel", "Kembali")
                        .setOption("doneLabel", "Selesai")
                        .setOptions({
                            showProgress: true,
                        }).start();
                }

                $(document).ready(function() {
                    klikkene(true);
                    $("#panduan").click(function() {
                        klikkene(false);
                    });
                });
            </script>
        @else
            <script>
                function klikkene(value) {
                    introJs().setOptions({
                            steps: [{
                                    element: document.querySelector('.card-zero'),
                                    title: 'Tour Guide',
                                    intro: 'Untuk Menampilkan Panduan Penggunaan Sistem Pada Setiap Halaman'
                                },
                                {
                                    element: document.querySelector('.card-first'),
                                    title: 'Dashboard',
                                    intro: 'Untuk Menampilkan Statistik Data Pada Sistem Pengelolaan E-Arsip'
                                },

                                {
                                    element: document.querySelector('.card-four'),
                                    title: 'Kegiatan & Notulen',
                                    intro: 'Untuk Mengelola Data Kegiatan dan Notulen Pada Sistem Informasi E-ARSIP'
                                },
                                {
                                    element: document.querySelector('.card-five'),
                                    title: 'Arsip Surat',
                                    intro: 'Untuk Mengelola Data Surat Keluar dan Surat Masuk, Dapat Melakukan Disposisi, Pencatatan SPPD, Serta Mengirimkan Notifikasi Via WhatsApp Kepada Penerima Surat Keluar Baru'
                                },
                                {
                                    element: document.querySelector('.card-six'),
                                    title: 'Dokumen',
                                    intro: 'Untuk Mengelola Data Dokumen Digital , dapat dilakukan Disposisi Dokumen Serta Pencatatan SPPD Dokumen'
                                }
                            ]
                        }).setOption("dontShowAgain", value)
                        .setOption("skipLabel", "<p widht='100px' style='font-size:12px;color:blue;'><u>Lewati</u> </p>")
                        .setOption("dontShowAgainLabel", " Jangan Tampilkan Lagi")
                        .setOption("disableInteraction", true)
                        .setOption("nextLabel", "Lanjut")
                        .setOption("prevLabel", "Kembali")
                        .setOption("doneLabel", "Selesai")
                        .setOptions({
                            showProgress: true,
                        }).start();
                }

                $(document).ready(function() {
                    klikkene(true);
                    $("#panduan").click(function() {
                        klikkene(false);
                    });
                });
            </script>
        @endif
    @endpush

@endsection
