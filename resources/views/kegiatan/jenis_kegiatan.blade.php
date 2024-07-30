@extends('main')
@if (Auth::user()->gocap_id_pc_pengurus)
    @section('pc_kegiatan', 'active')
@elseif(Auth::user()->gocap_id_upzis_pengurus)
    @section('upzis_kegiatan', 'active')
@endif
@section('kegiatan_ac', 'active menu-open')
@section('kegiatan_mo', 'menu-open')


@section('css')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb m-0 pl-4">
                        <li class="breadcrumb-item active">
                            @if (Auth::user()->gocap_id_pc_pengurus != null)
                                <a href="/{{ $role }}/dashboard">Dashboard</a> / <a
                                    href="/{{ $role }}/arsip/kegiatan_pc/pc">Kegiatan LAZISNU</a> /
                                {{ $page }}
                            @elseif (Auth::user()->gocap_id_upzis_pengurus != null)
                                <a href="/{{ $role }}/dashboard">Dashboard</a> / <a
                                    href="/{{ $role }}/arsip/kegiatan_upzis/">Kegiatan UPZIS</a> /
                                {{ $page }}
                            @endif

                        </li>
                    </ol>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">
                            {{ Carbon\Carbon::parse(now())->isoFormat('dddd, D MMMM Y') }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content ">
        <div class="container-fluid">
            {{-- livewire permohonan --}}
            <div>
                <div>
                    {{-- Stop trying to control. --}}


                    <div class="row">
                        <div class="col-12">

                            <div class="card ijo-atas card-table-jenis-kegiatan">

                                <!-- /.card-header -->
                                <div class="card-body">

                                    {{-- head --}}
                                    <div class="row">

                                        <div class="col-6 ">
                                            <h5>Data Jenis Kegiatan</h5>
                                            Menampilkan Data Jenis Kegiatan
                                        </div>
                                        <div class="col-2"></div>
                                        <div class="col-2"></div>


                                        <div class="col-2 col-sm-2 mb-0 ">
                                            <div class="small-box bg-white ">
                                                <div class="inner p-2  text-right ">

                                                    <button type="button"
                                                        class="btn btn-success btn-block card-tambah-jenis-kegiatan"
                                                        data-toggle="modal" data-target="#tambahkategori">
                                                        <i class="fas fa-plus"></i>
                                                        Tambah</a>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- Modal -->
                                    <div class="modal fade bd-example" id="tambahkategori" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog " role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                        Tambah Jenis Kegiatan
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <form action="{{ url('/' . $role . '/aksi_tambah_jenis_kegiatan/') }}"
                                                    method="post">
                                                    @csrf

                                                    <div class="modal-body">
                                                        <div class="card-body">


                                                            <div class="form-group">

                                                                <label style="float: left;">Nama Jenis
                                                                    Kegiatan</label>&nbsp;
                                                                <sup class="badge badge-danger text-white mb-2"
                                                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                                <input type="text" class="form-control" placeholder=""
                                                                    name="jenis_kegiatan" id="jenis">
                                                            </div>

                                                        </div>
                                                        <!-- /.card-body -->

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal"><i class="fas fa-ban"></i>
                                                            Batal</button>

                                                        <button type="submit" id='button' class="btn btn-success"
                                                            onclick="$('#cover-spin').show(0)" disabled><i
                                                                class="fas fa-save"></i>
                                                            Simpan </button>

                                                    </div>
                                                    <script>
                                                        let inputElt = document.getElementById('jenis');
                                                        let btn = document.getElementById('button');

                                                        inputElt.addEventListener("input", function() {
                                                            btn.disabled = (this.value === '');
                                                        })
                                                    </script>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!--End Modal -->

                                    {{-- tabel --}}
                                    <div class="table-responsive mt-0">

                                        <table id="example1" class="table table-bordered " style="width:100%">
                                            <thead>
                                                <tr style="font-size: 15px;">
                                                    <th>No</th>
                                                    <th>Nama Kegiatan</th>
                                                    <th>
                                                        Aksi</th>
                                                </tr>


                                            </thead>
                                            <tbody>

                                                @foreach ($jenis_kegiatan as $jenis_kegiatan)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $jenis_kegiatan->jenis_kegiatan }}</td>
                                                        <td>

                                                            <!-- Example split danger button -->
                                                            <div class="btn-group">

                                                                <button type="button" class="btn btn-success"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">Kelola</button>
                                                                <button type="button"
                                                                    class="btn btn-success dropdown-toggle dropdown-toggle-split"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">
                                                                    <span class="sr-only">Toggle
                                                                        Dropdown</span>
                                                                </button>
                                                                <div class="dropdown-menu">

                                                                    <button type="button"
                                                                        onMouseOver="this.style.color='red'"
                                                                        onMouseOut="this.style.color='black'"
                                                                        class="dropdown-item" data-toggle="modal"
                                                                        data-target="#exampleModals{{ $jenis_kegiatan->jenis_kegiatan_id }}">
                                                                        <i class="fas fa-edit"></i>
                                                                        Ubah</a>
                                                                    </button>

                                                                    <a onMouseOver="this.style.color='red'"
                                                                        onMouseOut="this.style.color='black'"
                                                                        class="dropdown-item" type="button"
                                                                        data-target="#modal_hapus{{ $jenis_kegiatan->jenis_kegiatan_id }}"
                                                                        data-toggle="modal"><i class="fas fa-trash"></i>
                                                                        Hapus</a>

                                                                </div>
                                                            </div>

                                                            <!-- Modal -->
                                                            <div class="modal fade bd-example"
                                                                id="exampleModals{{ $jenis_kegiatan->jenis_kegiatan_id }}"
                                                                tabindex="-1" role="dialog"
                                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog " role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"
                                                                                id="exampleModalLabel">
                                                                                Edit Kategori Berita
                                                                            </h5>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <form
                                                                            action="/{{ $role }}/aksi_edit_jenis_kegiatan/{{ $jenis_kegiatan->jenis_kegiatan_id }}"
                                                                            method="post">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <div class="modal-body">
                                                                                <div class="card-body">


                                                                                    <div class="form-group">
                                                                                        <label>Nama Kategori Berita</label>
                                                                                        &nbsp;
                                                                                        <sup class="badge badge-danger text-white mb-2"
                                                                                            style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                                                        <input type="text"
                                                                                            class="form-control"
                                                                                            placeholder=""
                                                                                            name="jenis_kegiatan"
                                                                                            id="jenis_kegiatan"
                                                                                            value="{{ $jenis_kegiatan->jenis_kegiatan }}">
                                                                                    </div>

                                                                                </div>
                                                                                <!-- /.card-body -->

                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-dismiss="modal"><i
                                                                                        class="fas fa-ban"></i>
                                                                                    Batal</button>
                                                                                <button type="submit" name="submit"
                                                                                    onclick="$('#cover-spin').show(0)"
                                                                                    class="btn btn-success"><i
                                                                                        class="fas fa-save"></i>
                                                                                    Simpan Perubahan</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!--End Modal -->
                                                        </td>
                                                        {{-- modal hapus --}}
                                                        <div class="modal fade"
                                                            id="modal_hapus{{ $jenis_kegiatan->jenis_kegiatan_id }}"
                                                            role="dialog" aria-labelledby="exampleModalLabel"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <form
                                                                        action="/{{ $role }}/aksi_hapus_jenis_kegiatan/{{ $jenis_kegiatan->jenis_kegiatan_id }}"
                                                                        method="post">
                                                                        @csrf
                                                                        <div class="modal-header">

                                                                            <h5 class="modal-title"
                                                                                id="exampleModalLabel">
                                                                                Konfirmasi
                                                                                    Hapus
                                                                            </h5>

                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <p>Yakin ingin menghapus data?</p>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-secondary close-btn"
                                                                                data-dismiss="modal"><i
                                                                                    class="fas fa-ban"></i>
                                                                                Batal</button>
                                                                            <button type="submit"
                                                                                onclick="$('#cover-spin').show(0)"
                                                                                class="btn btn-danger"><i
                                                                                    class="fas fa-trash"></i>
                                                                                Iya,
                                                                                Hapus</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- END modal hapus --}}

                                                    </tr>
                                                @endforeach
                                            </tbody>


                                        </table>
                                    </div>


                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->

                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <script>
                            window.addEventListener('closeModal', event => {
                                $('#tambah').modal('hide')
                            });
                        </script>
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

    @push('intro_jenis_kegiatan')
        <script>
            function klikkene(value) {
                introJs().setOptions({
                        steps: [{
                                element: document.querySelector('.card-table-jenis-kegiatan'),
                                title: 'Jenis Kegiatan',
                                intro: 'Menampilkan Data Jenis Kegiatan yang nantinya akan dipakai pada data kegiatan'
                            },
                            {
                                element: document.querySelector('.card-tambah-jenis-kegiatan'),
                                title: 'Tambah Jenis Kegiatan',
                                intro: 'Untuk Melakukan Tambah Data Jenis Kegiatan yang nantinya akan dipakai pada data kegiatan'
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
    @endpush
@endsection
