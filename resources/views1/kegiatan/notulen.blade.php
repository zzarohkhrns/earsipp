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
                            @if (Auth::user()->gocap_id_pc_pengurus)
                                <a href="/{{ $role }}/dashboard">Dashboard</a> / <a
                                    href="/{{ $role }}/arsip/kegiatan_pc/{{ $hal }}">{{ $hals }}</a>
                                /
                                {{ $halaman }}
                            @elseif(Auth::user()->gocap_id_upzis_pengurus)
                                <a href="/{{ $role }}/dashboard">Dashboard</a> / <a
                                    href="">{{ $hals }}</a>
                                /
                                {{ $halaman }}
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

    <!-- Main content -->
    <section class="content">
        <div class="card card-outline card-success">

            <div class="card-header mb-0">
                <div class="container-fluid p-0">
                    <div class="row">

                        <div class="col-12">
                            <nav>

                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    @if (Auth::user()->gocap_id_pc_pengurus)
                                        <a class="nav-item nav-link" id="nav-home-tab" onclick="$('#cover-spin').show(0)"
                                            href="/{{ $role }}/arsip/detail_kegiatan/{{ $kegiatan->kegiatan_id }}/{{ $hal }}"
                                            aria-controls="nav-home" aria-selected="true">Kegiatan</a>
                                    @elseif (Auth::user()->gocap_id_upzis_pengurus)
                                        <a class="nav-item nav-link" id="nav-home-tab" onclick="$('#cover-spin').show(0)"
                                            href="/{{ $role }}/arsip/detail_kegiatan_upzis/{{ $kegiatan->kegiatan_id }}/"
                                            aria-controls="nav-home" aria-selected="true">Kegiatan</a>
                                    @endif
                                    <a class="nav-item nav-link active" href="#" aria-controls="nav-profile"
                                        aria-selected="false">Notulen</a>

                                </div>
                            </nav>

                            <br>

                            <div class="card" style="padding: 15px; padding-left:100px;">
                                <div class="row">
                                    <div class="col-9"></div>
                                    <div class="col-3">

                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-secondary daftar-hadir-notulen float-right"
                                            data-toggle="modal" data-target="#daftarhadir">
                                            <i class="fas fa-users"></i> Daftar Hadir </button>

                                        <!-- Modal -->
                                        <div class="modal fade bd-example" id="daftarhadir" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog " role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Ubah Daftar Hadir
                                                            Kegiatan</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form
                                                            action="/{{ $role }}/aksi_ubah_kehadiran/{{ $ids }}"
                                                            method="POST">
                                                            @csrf
                                                            <div class="form-group col-md-12">
                                                                <label for="cariPekerjaan">JUMLAH KEHADIRAN
                                                                    &nbsp;</label>
                                                                <sup class="badge badge-danger text-white mb-2"
                                                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                                <div class="input-group">
                                                                    <input type="number" class="form-control"
                                                                        placeholder="Masukan Jumlah Kehadiran Kegiatan"
                                                                        name="hadir" value="{{ $kegiatan->hadir }}">
                                                                    <p class="input-group-text"
                                                                        style=" width: 100px;height:37px;max-height:100%;">
                                                                        Hadir</p>
                                                                </div>
                                                            </div>


                                                            <div class="form-group col-md-12">
                                                                <label for="cariPekerjaan">JUMLAH KETIDAKHADIRAN
                                                                    &nbsp;</label>
                                                                <sup class="badge badge-danger text-white mb-2"
                                                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                                <div class="input-group">
                                                                    <input type="number" class="form-control"
                                                                        placeholder="Masukan Jumlah Ketidakhadiran Kegiatan"
                                                                        name="tidak_hadir"
                                                                        value="{{ $kegiatan->tidak_hadir }}">
                                                                    <p class="input-group-text"
                                                                        style=" width: 100px;height:37px;max-height:100%;">
                                                                        Tidak Hadir</p>

                                                                </div>
                                                            </div>

                                                            <div class="form-group col-md-12">
                                                                <label for="cariPekerjaan">DISTRIBUSI UNDANGAN
                                                                    &nbsp;</label>
                                                                <sup class="badge badge-danger text-white mb-2"
                                                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                                <div class="input-group">
                                                                    <input type="number" class="form-control"
                                                                        placeholder="Masukan Distribusi Undangan Kegiatan"
                                                                        name="distribusi"
                                                                        value="{{ $kegiatan->distribusi }}">
                                                                    <p class="input-group-text"
                                                                        style=" width: 100px;height:37px;max-height:100%;">
                                                                        Distribusi</p>

                                                                </div>
                                                            </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal"><i class="fas fa-ban"></i>
                                                            Batal</button>
                                                        <button class="btn btn-success text-white toastrDefaultSuccess"
                                                            onclick="$('#cover-spin').show(0)" type="submit"><i
                                                                class="fas fa-save"></i> Simpan Perubahan
                                                        </button>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!--END  Modal -->

                                    </div>

                                </div>

                                <div class="row invoice-info">
                                    <div class="col-sm-4 invoice-col">
                                        <b>Nama Kegiatan</b>
                                        <address>
                                            {{ $kegiatan->nama_kegiatan }}<br>
                                            Lokasi : {{ $kegiatan->lokasi_kegiatan }}<br>
                                        </address>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4 invoice-col">
                                        <b> Penanggung Jawab</b>
                                        <address>
                                            {{ $kegiatan->penanggungjawab_kegiatan }}<br>
                                            <br>
                                        </address>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4 invoice-col">
                                        <b>Daftar Hadir</b>
                                        <address>
                                            {{ $kegiatan->hadir }} Hadir<br>
                                            {{ $kegiatan->tidak_hadir }} Tidak Hadir <br>
                                            {{ $kegiatan->distribusi }} Distribusi Undangan
                                        </address>


                                    </div>
                                    <!-- /.col -->
                                </div>

                            </div>
                            <div class="invoice rounded p-3 mt-6 mb-7">
                                <div class="row mt-2 ml-1 justify-content-between">
                                    <div>
                                        <h3 class="card-title "><b> <i class="fas fa-clipboard"></i> Notulen Kegiatan</b>
                                        </h3>
                                    </div>
                                    <div class="col-auto mr-3">

                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-success tambah-data-notulen-kegiatan"
                                            data-toggle="modal" data-target="#exampleModal">
                                            <i class="fas fa-plus-square"></i> Tambah Notulen
                                        </button>

                                        @if (count($notulen) > 0)
                                            <a href="/{{ $role }}/print_notulen/{{ $ids }}"
                                                type="button" class="btn btn-danger print-notulen-kegiatans"
                                                target="_blank"> <i class="fas fa-print"></i> Cetak
                                                Notulen</a>
                                        @else
                                            <button type="button" disabled
                                                class="btn btn-danger print-notulen-kegiatans"> <i
                                                    class="fas fa-print"></i> Cetak
                                                Notulen</button>
                                        @endif

                                        <form action="/{{ $role }}/aksi_tambah_notulen/{{ $ids }}"
                                            method="POST">
                                            @csrf


                                            @livewire('tambah-notulen')

                                        </form>

                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    {{-- tabel --}}
                                    <div class="table-responsive mt-0">

                                        <table id="example1" class="table table-bordered " style="width:100%">
                                            <thead>
                                                <tr style="font-size: 15px;">
                                                    <th style="width: 30px;">No</th>
                                                    <th>Pembahasan Kegiatan/Keputusan </th>
                                                    <th>PIC</th>
                                                    <th>Tanggal
                                                    </th>
                                                    <th class="aksi-kelola-notulen-kegiatan">
                                                        Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>


                                                @foreach ($notulen as $note)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td style="width: 400px;">
                                                            {{ $note->pembahasan }}
                                                        </td>
                                                        <td>
                                                            @php
                                                                $arr = explode(',', $note->pic);
                                                                $hitung = count($arr);
                                                                for ($x = 0; $x < $hitung; $x++) {
                                                                    echo '<p style="font-size:13px;line-height:normal; margin:0;"><b>' . $x + 1 . '. ' . $arr[$x] . '</b></p>';
                                                                }
                                                                
                                                            @endphp

                                                        </td>
                                                        <td>
                                                            Rencana Penyelesaian :
                                                            {{ Carbon\Carbon::parse($note->tgl_rencana)->isoFormat('dddd, D MMMM Y') }}
                                                            <br>
                                                            Realisasi Penyelesaian :
                                                            {{ Carbon\Carbon::parse($note->tgl_realisasi)->isoFormat('dddd, D MMMM Y') }}
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

                                                                    <a onMouseOver="this.style.color='red'"
                                                                        onMouseOut="this.style.color='black'"
                                                                        class="dropdown-item" href="#"
                                                                        type="button" data-toggle="modal"
                                                                        data-target="#ubahnotulen{{ $note->notulen_id }}"><i
                                                                            class="fas fa-edit"></i>
                                                                        Ubah</a>


                                                                    <a onMouseOver="this.style.color='red'" style=""
                                                                        onMouseOut="this.style.color='black'"
                                                                        class="dropdown-item" type="button"
                                                                        data-target="#modal_hapus{{ $note->notulen_id }}"
                                                                        data-toggle="modal"><i class="fas fa-trash"></i>
                                                                        Hapus</a>

                                                                </div>

                                                                {{-- modal hapus --}}
                                                                <div class="modal fade"
                                                                    id="modal_hapus{{ $note->notulen_id }}"
                                                                    role="dialog" aria-labelledby="exampleModalLabel"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <form
                                                                                action="/{{ $role }}/aksi_hapus_notulen/{{ $note->notulen_id }}"
                                                                                method="post">
                                                                                @csrf
                                                                                <div class="modal-header">

                                                                                    <h5 class="modal-title"
                                                                                        id="exampleModalLabel">
                                                                                        <b>Konfirmasi
                                                                                            Hapus</b>
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

                                                                <!-- Modal -->
                                                                <div class="modal fade bd-example-modal-lg"
                                                                    id="ubahnotulen{{ $note->notulen_id }}"
                                                                    tabindex="-1" role="dialog"
                                                                    aria-labelledby="exampleModalLabel"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog modal-lg" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title"
                                                                                    id="exampleModalLabel">Tambah
                                                                                    Notulen
                                                                                    Kegiatan</h5>
                                                                                <button type="button" class="close"
                                                                                    data-dismiss="modal"
                                                                                    aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <form
                                                                                    action="/{{ $role }}/aksi_edit_notulen/{{ $ids }}/{{ $note->notulen_id }}"
                                                                                    method="POST">
                                                                                    @csrf
                                                                                    <div class="form-row">
                                                                                        <div class="form col-md-9">
                                                                                            <label for="cariPekerjaan">PIC
                                                                                                &nbsp;</label>
                                                                                            <sup class="badge badge-danger text-white mb-2"
                                                                                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                                                            <input type="text"
                                                                                                class="form-control"
                                                                                                placeholder="Masukan PIC Kegiatan"
                                                                                                name="pic[]"
                                                                                                value="{{ $note->pic }}"
                                                                                                readonly>
                                                                                        </div>
                                                                                        <div class="form col-md-3">
                                                                                            <label><br></label>
                                                                                            <sup
                                                                                                class="badge text-white mb-2"><br></sup>
                                                                                            <br>

                                                                                            <button
                                                                                                id="addRowz{{ $note->notulen_id }}"
                                                                                                type="button"
                                                                                                class="btn btn-success btn-block"><i
                                                                                                    class="fas fa-plus-square"></i>
                                                                                                PIC</button>
                                                                                        </div>

                                                                                    </div>
                                                                                    <div
                                                                                        id="newRowz{{ $note->notulen_id }}">
                                                                                    </div>


                                                                                    <script type="text/javascript">
                                                                                        // add row

                                                                                        $("#addRowz{{ $note->notulen_id }}").click(function() {
                                                                                            var html = '';
                                                                                            html += '<div class="form-row">';
                                                                                            html += '<div id="inputFormRow1z" class=" col-md-12">';
                                                                                            html += '<label class="col-form-label">PIC </label > ';
                                                                                            html += '<div class=" row " >';
                                                                                            html += '<div class="input-group" id="inputFormRow">';
                                                                                            html +=
                                                                                                '  <div class="form col-md-9"> <input type="text" required name="pic[]" class="form-control" placeholder="Masukan PIC Kegiatan" autocomplete="off"></div>' +
                                                                                                '   <div class="form col-md-3"><button id="removeRowz" type="button" class="btn btn-danger btn-block"><i class="fas fa-trash"></i> Hapus</button></div>' +
                                                                                                '</div>';
                                                                                            html += '</div>';
                                                                                            html += '</div>';
                                                                                            html += '</div>';
                                                                                            html += '</div>';

                                                                                            $('#newRowz{{ $note->notulen_id }}').append(html);
                                                                                        });


                                                                                        // remove row
                                                                                        $(document).on('click', '#removeRowz', function() {

                                                                                            $(this).closest('#inputFormRow1z').remove();
                                                                                        });
                                                                                    </script>
                                                                                    <br>
                                                                                    <div class="form-row">
                                                                                        <div class="form-group col-md-6">
                                                                                            <label>Tanggal Rencana
                                                                                                Penyelesaian
                                                                                                &nbsp;</label>
                                                                                            <sup class="badge badge-danger text-white mb-2"
                                                                                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                                                            <input type="date"
                                                                                                class="form-control"
                                                                                                name="tgl_rencana"
                                                                                                value="{{ $note->tgl_rencana }}">
                                                                                        </div>
                                                                                        <div class="form-group col-md-6">
                                                                                            <label
                                                                                                for="cariPekerjaan">Tanggal
                                                                                                Realisasi
                                                                                                Penyelesaian
                                                                                                &nbsp;</label>
                                                                                            <sup class="badge badge-danger text-white mb-2"
                                                                                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                                                            <input type="date"
                                                                                                class="form-control"
                                                                                                placeholder="Masukan Nama Kegiatan"
                                                                                                name="tgl_realisasi"
                                                                                                value="{{ $note->tgl_realisasi }}">
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="form-row">
                                                                                        <div class="form-group col-md-12">
                                                                                            <label>PEMBAHASAN KEGIATAN/
                                                                                                KEPUTUSAN &nbsp;</label>
                                                                                            <sup class="badge badge-danger text-white mb-2"
                                                                                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                                                            <textarea type="text" class="form-control" name="pembahasan" rows="4">{{ $note->pembahasan }}</textarea>
                                                                                        </div>

                                                                                    </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-dismiss="modal"><i
                                                                                        class="fas fa-ban"></i>
                                                                                    Batal</button>
                                                                                <button
                                                                                    class="btn btn-success text-white toastrDefaultSuccess"
                                                                                    type="submit"><i
                                                                                        class="fas fa-save"></i> Simpan
                                                                                    Perubahan</button>
                                                                            </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                        </td>
                                                    </tr>
                                                @endforeach

                                            </tbody>


                                        </table>
                                    </div>


                                    <!-- /.card-body -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

    </section>

    <!-- /.content-header -->
@endsection


@section('js')

    <!-- bs-custom-file-input -->
    <script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.js') }}"></script>
    <script>
        $(function() {
            bsCustomFileInput.init();
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

    {{-- <script>
        // introJs().setOptions({
        //     showProgress: true,
        // }).setDontShowAgain(true).start();

        introJs().refresh().setOptions({
            showProgress: true,
        }).onbeforeexit(function() {
            return confirm("Apakah Anda yakin Sudah Paham?");
        }).start();
    </script> --}}

    @push('intro_notulen')
        <script>
            function klikkene(value) {
                introJs().setOptions({
                        steps: [{
                                element: document.querySelector('.daftar-hadir-notulen'),
                                title: 'Daftar Hadir',
                                intro: 'Untuk Melakukan Pencatatan Data Kehadiran'
                            }, {
                                element: document.querySelector('.tambah-data-notulen-kegiatan'),
                                title: 'Tambah Notulen',
                                intro: 'Untuk Melakukan Pencatatan Notulensi Kegiatan'
                            },
                            {
                                element: document.querySelector('.print-notulen-kegiatans'),
                                title: 'Cetak Notulen',
                                intro: 'Untuk Melakukan Cetak Keseluruhan Notulensi Berupa File PDF'
                            },
                            {
                                element: document.querySelector('.aksi-kelola-notulen-kegiatan'),
                                title: 'Aksi',
                                intro: 'Untuk Mengubah Data Notulen atau Untuk Menghapus Data Notulen'
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
