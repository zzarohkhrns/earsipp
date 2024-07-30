@extends('main')

@section('memo', 'active')

@section('css')
@section('content')


    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb m-0 pl-4">
                        <li class="breadcrumb-item active">
                            <a href="/{{ $role }}/dashboard">Dashboard</a> / <a
                                href="/{{ $role }}/arsip/memo">Memo Internal</a> /
                            <a>{{ $page }}</a>
                        </li>
                    </ol>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">{{ Carbon\Carbon::parse(now())->isoFormat('dddd, D MMMM Y') }}
                        </li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->



    <!-- Main content -->
    <!-- /.content-header -->
    <section class="content">
        <div class="container-fluid ">
            <!-- Form Element sizes -->
            @php
                $rul = strtolower($role);
            @endphp

            <form method="post" action="{{ url('/' . $role . '/aksi_tambah_memo') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" value="{{ $role }}" name="role">

                <livewire:nomor></livewire:nomor>

            </form>
        </div>


    </section>

@endsection

@section('js')

    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script>
        var options = {
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
        };
    </script>
    <script>
        CKEDITOR.replace('my-editor', options);
    </script>

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

@push('custom-scripts')
    {{-- ada disposisi atau tidak --}}
    <script>
        $(document).ready(function() {
            document.getElementById('disposisi-card').style.display = 'none';
            document.getElementById('sppd-card').style.display = 'none';
        });
        document.getElementById('tombol-disposisi1').addEventListener('change', function() {
            console.log(this.value);
            if (this.checked) {
                document.getElementById('tombol-disposisi2').checked = false;
                document.getElementById('disposisi-card').style.display = 'block';

            }
        });
        document.getElementById('tombol-disposisi2').addEventListener('change', function() {
            console.log(this.value);
            if (this.checked) {
                document.getElementById('tombol-disposisi1').checked = false;
                // document.getElementById('tombol-sppd2').checked = true;
                // document.getElementById('tombol-sppd1').checked = false;
                document.getElementById('sppd1actv1').classList.remove('active');
                document.getElementById('sppd1actv2').classList.add('active');
                document.getElementById('sppd-card').style.display = 'none';
                document.getElementById('disposisi-card').style.display = 'none';
                document.getElementById('sppd-card').style.display = 'none';
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            document.getElementById('sppd-card').style.display = 'none';
        });
        document.getElementById('tombol-sppd1').addEventListener('change', function() {
            console.log(this.value);
            if (this.checked) {
                document.getElementById('tombol-sppd2').checked = false;

                document.getElementById('sppd-card').style.display = 'block';
            }
        });
        document.getElementById('tombol-sppd2').addEventListener('change', function() {
            console.log(this.value);
            if (this.checked) {
                document.getElementById('tombol-sppd1').checked = false;

                document.getElementById('sppd-card').style.display = 'none';
            }
        });
    </script>

    <script>
        var harga = document.getElementById('anggaran');
        harga.addEventListener('keyup', function(e) {
            harga.value = formatRupiah(this.value, '');
        });

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
        }
    </script>


    {{-- golongan atau satuan --}}
    <script>
        $(document).ready(function() {
            document.getElementById('select2-golongan').style.display = 'none';
            document.getElementById('select2-internal').style.display = 'none';


        });
        document.getElementById('tombol-jenis-disposisi1').addEventListener('change', function() {
            console.log(this.value);
            if (this.checked) {
                document.getElementById('tombol-jenis-disposisi3').checked = false;
                document.getElementById('tombol-jenis-disposisi2').checked = false;
                document.getElementById('select2-satuan_upzis').style.display = 'block';
                document.getElementById('select2-satuan_pcnu').style.display = 'block';
                document.getElementById('select2-satuan_ranting').style.display = 'block';
                document.getElementById('select2-internal').style.display = 'none';
                document.getElementById('select2-golongan').style.display = 'none';
            }
        });
        document.getElementById('tombol-jenis-disposisi2').addEventListener('change', function() {
            console.log(this.value);
            if (this.checked) {
                document.getElementById('tombol-jenis-disposisi1').checked = false;
                document.getElementById('tombol-jenis-disposisi3').checked = false;
                document.getElementById('select2-satuan_upzis').style.display = 'none';
                document.getElementById('select2-satuan_pcnu').style.display = 'none';
                document.getElementById('select2-satuan_ranting').style.display = 'none';
                document.getElementById('select2-internal').style.display = 'none';
                document.getElementById('select2-golongan').style.display = 'block';
            }
        });
        document.getElementById('tombol-jenis-disposisi3').addEventListener('change', function() {
            console.log(this.value);
            if (this.checked) {
                document.getElementById('tombol-jenis-disposisi1').checked = false;
                document.getElementById('tombol-jenis-disposisi2').checked = false;
                document.getElementById('select2-satuan_pcnu').style.display = 'none';
                document.getElementById('select2-satuan_ranting').style.display = 'none';
                document.getElementById('select2-satuan_upzis').style.display = 'none';
                document.getElementById('select2-golongan').style.display = 'none';
                document.getElementById('select2-internal').style.display = 'block';
            }
        });
    </script>
@endpush
