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
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
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
                <div class="col-12 col-sm-6 co">
                    <div class="card ijo-kiri h-card">
                        <div class="container pl-2">
                            <div class="d-flex align-items-start">
                                <div class="info-box-content pt-1">
                                    <span class="info-box-text">{{ $a1 }}</span>
                                    <span class="info-box-text"><b>
                                            <h3>{{ $b1 }}</h3>
                                        </b></span>
                                    <p class="info-box-text">
                                        @if ($id == 'pc')
                                            <b class="text-success">{{ $c1 }}</b>{{ $c }}
                                        @else
                                            <b class="text-success"></b>⠀
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>

                <div class="col-12 col-sm-6 co">
                    <div class="card ijo-kiri h-card">
                        <div class="container pl-2">

                            <div class="d-flex align-items-start">
                                <div class="info-box-content pt-1">
                                    <span class="info-box-text">{{ $a2 }}</span>
                                    <span class="info-box-text"><b>
                                            <h3>{{ $b2 }}</h3>
                                        </b></span>
                                    <p class="info-box-text">
                                        @if ($id == 'pc')
                                            <b class="text-success">{{ $c2 }}</b>{{ $c }}
                                        @else
                                            <b class="text-success"></b>⠀
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>
                <div class="col-12 col-sm-6 co">
                    <div class="card ijo-kiri h-card">
                        <div class="container pl-2">
                            <div class="d-flex align-items-start">
                                <div class="info-box-content pt-1">
                                    <span class="info-box-text">{{ $a3 }}</span>
                                    <span class="info-box-text"><b>
                                            <h3>{{ $b3 }}</h3>
                                        </b></span>
                                    <p class="info-box-text">
                                        <b class="text-success">{{ $c3 }}</b> {{ $c }}
                                    </p>
                                </div>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 co">

                    <div class="card ijo-kiri h-card">
                        <div class="container pl-2">
                            <div class="d-flex align-items-start">
                                <div class="info-box-content pt-1">
                                    <span class="info-box-text">{{ $a4 }}</span>
                                    <span class="info-box-text"><b>
                                            <h3>{{ $b4 }}</h3>
                                        </b></span>
                                    <p class="info-box-text">
                                        <b class="text-success">{{ $c3 }}</b> {{ $c }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>
                <div class="col-12 col-sm-6 co">

                    <div class="card ijo-kiri h-card">
                        <div class="container pl-2">
                            <div class="d-flex align-items-start">
                                <div class="info-box-content pt-1">
                                    <span class="info-box-text">{{ $a5 }}</span>
                                    <span class="info-box-text"><b>
                                            <h3>{{ $b5 }}</h3>
                                        </b></span>
                                    <p class="info-box-text">
                                        <b class="text-success"></b>⠀
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>

                <div class="col-md-8">

                    <div class="card ijo-atas">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <strong>
                                    Grafik Jumlah Pengunjung
                                </strong>
                                <div>

                                    <p class="badge badge-success align-items-center">PERIODE - AGUSTUS 2022</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mt-2">
                                        <span class="info-box-text">Jumlah Pengunjung Bulan Ini</span>
                                        <p class="mb-0 mt-0"><b>1566</b></p>
                                        <small class="mb-6 mt-0">+10% dari bulan lalu</small>
                                    </div>

                                </div>
                                <div class="col-md-9">
                                    <canvas id="barChart"
                                        style="min-height: 200px; height: 250px; max-height: 300px; max-width: 100%;"
                                        class="chartjs-render-monitor"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-4">
                    <div class="card ijo-atas">
                        <div class="card-body">
                            <strong>
                                Statistik Pengunjung
                            </strong>
                            <p>Notifikasi whatsapp: <span class="text-success">39.832</span> terkirim &
                                <span class="text-danger">9.832</span> gagal
                            </p>

                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th style="width:50%">Hari ini</th>
                                        <td>67</td>
                                    </tr>
                                    <tr>
                                        <th>Minggu Ini</th>
                                        <td>167</td>
                                    </tr>
                                    <tr>
                                        <th>Bulan Ini</th>
                                        <td>789</td>
                                    </tr>
                                    <tr>
                                        <th>Tahun Ini</th>
                                        <td>1276</td>
                                    </tr>
                                </table>
                            </div>

                        </div>
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




@endsection
