@extends('main')

@section($page, 'active')
@section('kegiatan_ac', 'active menu-open')
@section('kegiatan_mo', 'menu-open')


@section('css')
@section('content')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb m-0 pl-4">
                        <li class="breadcrumb-item active">
                            <a href="/{{ $role }}/dashboard">Dashboard</a> / {{ $halaman }}
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

                            <div class="card ijo-atas">
                                <!-- Header -->
                                <!-- /.card-header -->
                                <div class="card-body">

                                    @php
                                        
                                        if (Auth::user()->gocap_id_pc_pengurus != null) {
                                            if ($hal == 'pc') {
                                                $display = '';
                                                $col = 'col-md-3';
                                                $card = 'col-md-12';
                                                $col3 = 'col-md-1';
                                                $col2 = 'col-md-3';
                                                $baris = 'col-12';
                                                $filter = 'col-md-1';
                                                $wilayahz = $wilayah;
                                            } else {
                                                // $display = 'none';
                                                // $col = 'col-md-3';
                                                // $card = 'col-md-10';
                                                // $col3 = 'col-md-1';
                                                // $col2 = 'col-md-3';
                                                // $filter = 'col-md-3';
                                                // $wilayahz = 'Seluruh UPZIS';
                                                // $baris = 'col-5 col-12 col-md-2 col-sm-12 mb-2 mb-xl-0 pr-0 d-highlight pr-0 mr-0 ';
                                                $display = 'none';
                                                $col = 'col-md-3';
                                                $card = 'col-md-12';
                                                $col3 = 'col-md-1';
                                                $col2 = 'col-md-3';
                                                $baris = 'col-12';
                                                $filter = 'col-md-1';
                                                $wilayahz = $wilayah;
                                            }
                                        }
                                    @endphp

                                    @if (Auth::user()->gocap_id_upzis_pengurus != null)
                                        @php
                                            $display = '';
                                            $col = 'col-md-3';
                                            $card = 'col-md-12';
                                            $col3 = 'col-md-1';
                                            $baris = 'col-12';
                                            $filter = 'col-md-1';
                                            $col2 = 'col-md-3';
                                            $wilayahz = $wilayah;
                                        @endphp
                                    @endif


                                    {{-- head --}}
                                    <div class="row card-kegiatan">
                                        <div class=" {{ $baris }} mt-2">
                                            <h5 class="d-flex ">
                                                <b class="text-success pl-2">KEGIATAN & NOTULEN</b>
                                            </h5>
                                            {{-- Menampilkan Data Kegiatan Dan Notulen Di {{ $wilayahz }} --}}
                                        </div>
                                        <div class="col-12  {{ $card }} col-sm-12 mb-2 mb-xl-0">
                                            <div class="card">
                                                <div class="card-body">
                                                    @php
                                                        if (Auth::user()->gocap_id_pc_pengurus != null) {
                                                            $uu = '/' . $role . '/filter/kegiatan/' . $hal;
                                                        } else {
                                                            $uu = '/' . $role . '/filter/kegiatan_upzis/';
                                                        }
                                                        
                                                    @endphp
                                                    <form method="post" action="{{ $uu }}">
                                                        @csrf
                                                        <div class="row card-filter-kegiatan">
                                                            {{-- filter kategori --}}
                                                            <div class="col-12 col-md-4 col-sm-12 mb-2 mb-xl-0">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">Kegiatan</div>
                                                                    </div>
                                                                    <select name="jenis_kegiatan" class="form-control"
                                                                        onchange="javascript:this.form.submit();">

                                                                        @if ($jenis_kegiatans == '')
                                                                            <option value="" selected hidden>
                                                                                Jenis Kegiatan
                                                                            </option>
                                                                        @else
                                                                            <option value="{{ $jenis_kegiatans }}" selected
                                                                                hidden>
                                                                                {{ $jenis_kegiatans }}
                                                                            </option>
                                                                        @endif
                                                                        <option value="">Semua
                                                                        </option>
                                                                        @foreach ($jenis_kegiatan as $jk)
                                                                            <option value="{{ $jk->jenis_kegiatan }}">
                                                                                {{ $jk->jenis_kegiatan }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>


                                                            </div>
                                                            {{-- filter kondisi --}}
                                                            <div class="col-12 col-md-4 col-sm-12 mb-2 mb-xl-0">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">Bulan</div>
                                                                    </div>
                                                                    <select class="col mr-2 form-control" name="bulan"
                                                                        onchange="javascript:this.form.submit();">
                                                                        @if ($bulans == '')
                                                                            <option value="" selected hidden>Pilih
                                                                                Bulan
                                                                            </option>
                                                                        @else
                                                                            @php
                                                                                if ($bulans == '01') {
                                                                                    $nama_bulan = 'Januari';
                                                                                } elseif ($bulans == '02') {
                                                                                    $nama_bulan = 'Februari';
                                                                                } elseif ($bulans == '03') {
                                                                                    $nama_bulan = 'Maret';
                                                                                } elseif ($bulans == '04') {
                                                                                    $nama_bulan = 'April';
                                                                                } elseif ($bulans == '05') {
                                                                                    $nama_bulan = 'Mei';
                                                                                } elseif ($bulans == '06') {
                                                                                    $nama_bulan = 'Juni';
                                                                                } elseif ($bulans == '07') {
                                                                                    $nama_bulan = 'Juli';
                                                                                } elseif ($bulans == '08') {
                                                                                    $nama_bulan = 'Agustus';
                                                                                } elseif ($bulans == '09') {
                                                                                    $nama_bulan = 'September';
                                                                                } elseif ($bulans == '10') {
                                                                                    $nama_bulan = 'Oktober';
                                                                                } elseif ($bulans == '11') {
                                                                                    $nama_bulan = 'November';
                                                                                } elseif ($bulans == '12') {
                                                                                    $nama_bulan = 'Desember';
                                                                                }
                                                                            @endphp
                                                                            <option value="{{ $bulans }}" selected
                                                                                hidden>
                                                                                {{ $nama_bulan }}
                                                                            </option>
                                                                        @endif
                                                                        <option value="">Semua</option>
                                                                        <option value="01">Januari</option>
                                                                        <option value="02">Februari</option>
                                                                        <option value="03">Maret</option>
                                                                        <option value="04">April</option>
                                                                        <option value="05">Mei</option>
                                                                        <option value="06">Juni</option>
                                                                        <option value="07">Juli</option>
                                                                        <option value="08">Agustus</option>
                                                                        <option value="09">September</option>
                                                                        <option value="10">Oktober</option>
                                                                        <option value="11">November</option>
                                                                        <option value="12">Desember</option>



                                                                    </select>
                                                                </div>

                                                            </div>
                                                            {{-- filter tahun --}}
                                                            <div class="col-12 col-md-4 col-sm-12 mb-2 mb-xl-0 ">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">Tahun</div>
                                                                    </div>
                                                                    <select class="form-control " name="tahun"
                                                                        onchange="javascript:this.form.submit();">

                                                                        @if ($tahuns == '')
                                                                            <option value="" selected hidden>Pilih
                                                                                Tahun
                                                                            </option>
                                                                        @else
                                                                            <option value="{{ $tahuns }}" selected
                                                                                hidden>
                                                                                {{ $tahuns }}
                                                                            </option>
                                                                        @endif
                                                                        <option value="">Semua</option>
                                                                        @foreach ($tahun_kegiatan as $tahun_m)
                                                                            <option value="{{ $tahun_m->year }}">
                                                                                {{ $tahun_m->year }}
                                                                            </option>
                                                                        @endforeach

                                                                    </select>
                                                                </div>

                                                            </div>


                                                            {{-- tombol filter --}}
                                                            {{-- @if (Auth::user()->gocap_id_pc_pengurus != null)
                                                                <div
                                                                    class="col-12 {{ $filter }} col-sm-12 mb-2 mb-xl-0">
                                                                    <div class="btn-group btn-block mb-2 mb-xl-0">
                                                                        <button type="submit"
                                                                            onclick="$('#cover-spin').show(0)"
                                                                            class="btn btn-primary btn-block"
                                                                            formaction="/{{ $role }}/filter/kegiatan/{{ $hal }}"><i
                                                                                class="fas fa-sort"></i>
                                                                            Filter</button>

                                                                    </div>

                                                                </div>
                                                            @elseif (Auth::user()->gocap_id_upzis_pengurus != null)
                                                                <div
                                                                    class="col-12 {{ $filter }} col-sm-12 mb-2 mb-xl-0">
                                                                    <div class="btn-group btn-block mb-2 mb-xl-0">
                                                                        <button type="submit"
                                                                            class="btn btn-primary btn-block"
                                                                            formaction="/{{ $role }}/filter/kegiatan_upzis/"><i
                                                                                class="fas fa-sort"></i>
                                                                            Filter</button>

                                                                    </div>

                                                                </div>
                                                            @endif --}}


                                                    </form>


                                                </div>



                                                <div class="form-row mt-2">

                                                    {{-- info --}}
                                                    <div class="col-12 col-md-10 col-sm-12 mb-2 mb-xl-0">
                                                        <div class="d-flex flex-row bd-highlight align-items-center">
                                                            <div class="p-2 bd-highlight">
                                                                <i class="fas fa-info-circle"></i>
                                                            </div>
                                                            <div class="p-1 bd-highlight">
                                                                <span>Dikelola Oleh
                                                                    @if (Auth::user()->gocap_id_pc_pengurus != null)
                                                                        @if ($hal == 'pc')
                                                                            <span class="text-bold">INTERNAL PC NU Care
                                                                                Cilacap
                                                                            </span>
                                                                        @else
                                                                            <span class="text-bold">Seluruh UPZIS KABUPATEN
                                                                                CILACAP
                                                                            </span>
                                                                        @endif
                                                                    @else
                                                                        <span class="text-bold">UPZIS {{ $wilayah }}
                                                                        </span>
                                                                    @endif
                                                                </span>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- tombol tambah --}}
                                                    <div class="btn-group col-12 col-md-2 col-sm-12 mb-2 mb-xl-0 "
                                                        id="tutup-botton-dropdown">
                                                        @if ($display == '')
                                                            <button style="display:{{ $display }}" type="button"
                                                                class="btn btn-success card-tambah_kegiatan"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false"><i class="fas fa-plus-circle"></i>
                                                                <span>Tambah</span></button>
                                                        @endif
                                                        <div class="dropdown-menu col-12 col-md-12 col-sm-12 mb-2 mb-xl-0 card-tambah_kegiatan-opsi"
                                                            id="keluar-dropdown">

                                                            @if (DB::table('jenis_kegiatan')->select('jenis_kegiatan_id')->exists())
                                                                <a onMouseOver="this.style.color='red'"
                                                                    onMouseOut="this.style.color='black'"
                                                                    class="dropdown-item card-open-modal-tambah_kegiatan-opsi"
                                                                    data-bs-toggle="modal" href="#exampleModalToggle"
                                                                    type="button" id="klikwoy"><i
                                                                        class="fas fa-plus-circle"></i>
                                                                    <span>Tambah Kegiatan</span> </a>
                                                            @endif



                                                            @if (Auth::user()->gocap_id_pc_pengurus != null)
                                                                <a onMouseOver="this.style.color='red'"
                                                                    onclick="$('#cover-spin').show(0)"
                                                                    onMouseOut="this.style.color='black'"
                                                                    class="dropdown-item "
                                                                    href="/{{ $role }}/kegiatan/jenis_kegiatan/{{ $hal }}"
                                                                    type="button"><i class="fas fa-plus-circle"></i>
                                                                    Tambah Jenis Kegiatan</a>
                                                            @elseif (Auth::user()->gocap_id_upzis_pengurus != null)
                                                                <a onMouseOver="this.style.color='red'"
                                                                    onclick="$('#cover-spin').show(0)"
                                                                    onMouseOut="this.style.color='black'"
                                                                    class="dropdown-item "
                                                                    href="/{{ $role }}/kegiatan/jenis_kegiatan_upzis/"
                                                                    type="button"><i class="fas fa-plus-circle"></i>
                                                                    Tambah Jenis Kegiatan</a>
                                                            @endif

                                                        </div>
                                                    </div>
                                                    {{-- tombol tambah end --}}

                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @livewire('tambah-kegiatan')

                                {{-- tabel --}}
                                <div class="table-responsive mt-0 card-table-kegiatan">

                                    <table id="example1" class="table table-bordered " style="width:100%">
                                        <thead>
                                            <tr style="font-size: 15px;">
                                                <th>No</th>
                                                <th>Nama Kegiatan</th>
                                                <th>Lokasi Kegiatan</th>
                                                <th>Jenis Kegiatan</th>
                                                <th>Estimasi Biaya</th>
                                                <th>
                                                    Aksi</th>
                                            </tr>


                                        </thead>
                                        <tbody>
                                            @if ($kegiatan)
                                                @foreach ($kegiatan as $kegiatan)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td><b
                                                                style="font-size: 16px;">{{ Carbon\Carbon::parse($kegiatan->tgl_kegiatan)->isoFormat('dddd, D MMMM Y') }}</b>
                                                            <br>
                                                            {{ $kegiatan->nama_kegiatan }}
                                                        </td>

                                                        <td><b style="font-size: 16px;">
                                                                {{ 'PJ : ' . $kegiatan->penanggungjawab_kegiatan }}</b>
                                                            <br>
                                                            {{ 'Pelaksana : ' . $kegiatan->pelaksana_kegiatan }}
                                                            <br> {{ 'Lokasi : ' . $kegiatan->lokasi_kegiatan }}
                                                        </td>
                                                        <td>{{ $kegiatan->jenis_kegiatan }}</td>
                                                        <td>{{ 'Rp ' . number_format($kegiatan->estimasi_biaya_kegiatan, 0, ',', '.') }}
                                                        </td>
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

                                                                    @if (Auth::user()->gocap_id_pc_pengurus != null)
                                                                        <a onMouseOver="this.style.color='red'"
                                                                            onMouseOut="this.style.color='black'"
                                                                            class="dropdown-item"
                                                                            onclick="$('#cover-spin').show(0)"
                                                                            href="/{{ $role }}/arsip/detail_kegiatan/{{ $kegiatan->kegiatan_id }}/{{ $hal }}"
                                                                            type="button"><i class="far fa-eye"></i>
                                                                            Detail</a>

                                                                        @if ($hal == 'pc')
                                                                            <a onMouseOver="this.style.color='red'"
                                                                                onMouseOut="this.style.color='black'"
                                                                                class="dropdown-item" type="button"
                                                                                data-target="#modal_hapus{{ $kegiatan->kegiatan_id }}"
                                                                                data-toggle="modal"><i
                                                                                    class="fas fa-trash"></i>
                                                                                Hapus</a>
                                                                        @endif
                                                                    @elseif (Auth::user()->gocap_id_upzis_pengurus != null)
                                                                        <a onMouseOver="this.style.color='red'"
                                                                            onMouseOut="this.style.color='black'"
                                                                            class="dropdown-item"
                                                                            onclick="$('#cover-spin').show(0)"
                                                                            href="/{{ $role }}/arsip/detail_kegiatan_upzis/{{ $kegiatan->kegiatan_id }}/"
                                                                            type="button"><i class="far fa-eye"></i>
                                                                            Detail</a>

                                                                        <a onMouseOver="this.style.color='red'"
                                                                            onMouseOut="this.style.color='black'"
                                                                            class="dropdown-item" type="button"
                                                                            data-target="#modal_hapus{{ $kegiatan->kegiatan_id }}"
                                                                            data-toggle="modal"><i
                                                                                class="fas fa-trash"></i>
                                                                            Hapus</a>
                                                                    @endif







                                                                </div>
                                                            </div>


                                                        </td>


                                                        {{-- modal hapus --}}
                                                        <div class="modal fade"
                                                            id="modal_hapus{{ $kegiatan->kegiatan_id }}" role="dialog"
                                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <form
                                                                        action="/{{ $role }}/aksi_hapus_kegiatan/{{ $kegiatan->kegiatan_id }}"
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
                                            @endif
                                        </tbody>


                                    </table>
                                </div>


                                <!-- /.card-body -->

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
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
    {{-- @push('intro_kegiatan')
        <script>
            introJs().setOptions({
                showProgress: true,
            }).setDontShowAgain(true).start();

            introJs().setOptions({
                showProgress: true,
            }).onbeforeexit(function() {
                return confirm("Apakah Anda yakin Sudah Paham?");
            }).start();
        </script>
    @endpush --}}

    @push('intro_kegiatan')
        @if ($display == '')
            <script>
                function klikkene(value) {
                    introJs().setOptions({
                            steps: [{
                                    element: document.querySelector('.card-kegiatan'),
                                    title: 'Kegiatan Dan Notulen',
                                    intro: 'Kegiatan Dan Notulen dapat dibuat oleh siapa saja dan dapat diubah oleh pembuat serta akan ditujukan kepada semua pengurus pada Wilayah tersebut'
                                },
                                {
                                    element: document.querySelector('.card-filter-kegiatan'),
                                    title: 'Filter Kegiatan',
                                    intro: 'Untuk menampilkan arsip Kegiatan & Notulen secara spesifik, gunakan filter data'
                                },
                                {
                                    element: document.querySelector('.card-tambah_kegiatan'),
                                    title: 'Tambah Kegiatan',
                                    intro: 'Klik disini untuk tambah data kegiatan'
                                },
                                {
                                    element: document.querySelector('.card-tambah_kegiatan-opsi'),
                                    title: 'Opsi Tambah Kegiatan',
                                    intro: 'Klik disini untuk memilih opsi tambah kegiatan atau tambah jenis kegiatan'
                                },
                                {
                                    element: document.querySelector('.card-open-modal-tambah_kegiatan-opsi'),
                                    title: 'Buka Form Kegiatan',
                                    intro: 'Klik disini untuk membuka modal form tambah kegiatan'
                                },
                                {
                                    element: document.querySelector('.card-table-kegiatan'),
                                    title: 'Data Kegiatan Dan Noulen',
                                    intro: 'Menampilkan Data Kegiatan Dan Notulen '
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
                        }).onbeforechange(function() {
                            if (this._currentStep === 3 || this._currentStep === 4) {
                                $("#keluar-dropdown").attr('class',
                                    'dropdown-menu col-12 col-md-12 col-sm-12 mb-2 mb-xl-0 show')
                                $("#keluar-dropdown").attr('style',
                                    'position: absolute; transform: translate3d(5px, 38px, 0px); top: 0px; left: 0px; will-change: transform;'
                                )
                                $("#keluar-dropdown").attr('aria-expanded', 'true');
                                $("#keluar-dropdown").attr('x-placement', 'bottom-start');

                                return true;
                            }
                            if (this._currentStep === 5) {

                                // $('#klikwoy').find('span').trigger('click');
                                // return true;

                                $("#keluar-dropdown").attr('class',
                                    'dropdown-menu col-12 col-md-12 col-sm-12 mb-2 mb-xl-0 ')
                                $("#keluar-dropdown").attr('style', '')
                                $("#keluar-dropdown").attr('aria-expanded', 'false');
                                $("#keluar-dropdown").attr('x-placement', '');
                                return true;

                            }

                        }).onafterchange(function() {
                            if (this._currentStep === 6) {
                                $("#keluar-dropdown").attr('class',
                                    'dropdown-menu col-12 col-md-12 col-sm-12 mb-2 mb-xl-0')
                                $("#keluar-dropdown").attr('style', '')
                                $("#keluar-dropdown").attr('aria-expanded', 'false');
                                $("#keluar-dropdown").attr('x-placement', '');

                                return true;
                            }
                            // if (this._currentStep === 8) {
                            //     $('#tutup-modal').find('span').trigger('click');
                            //     return true;
                            // }
                        }).oncomplete(function() {
                            location.reload();
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
                                    element: document.querySelector('.card-kegiatan'),
                                    title: 'Kegiatan Dan Notulen',
                                    intro: 'Kegiatan Dan Notulen dapat dibuat oleh siapa saja dan dapat diubah oleh pembuat serta akan ditujukan kepada semua pengurus pada Wilayah tersebut'
                                },
                                {
                                    element: document.querySelector('.card-filter-kegiatan'),
                                    title: 'Filter Kegiatan',
                                    intro: 'Untuk menampilkan arsip Kegiatan & Notulen secara spesifik, gunakan filter data'
                                },
                                {
                                    element: document.querySelector('.card-table-kegiatan'),
                                    title: 'Data Kegiatan Dan Noulen',
                                    intro: 'Menampilkan Data Kegiatan Dan Notulen '
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
