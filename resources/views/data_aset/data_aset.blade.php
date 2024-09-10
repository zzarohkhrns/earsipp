@extends('main')


@section('data_barang', 'active menu-open')
@section('barang', 'menu-open')

@section('css')
@section('content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .container .d-flex {
            display: flex;
            align-items: flex-start;
            padding: 0;
            margin: 0;
        }

        .btn-success {
            background-color: #28a745;
            color: white;
            border: none;
        }

        .btn-light {
            background-color: #f8f9fa;
            color: #495057;
            border: none;
            /* border: 1px solid #495057; */
        }

        .btn-group {
            display: flex;
            flex-wrap: wrap;
        }

        .hover-pointer tr {
            cursor: pointer;
        }

        .hover-pointer tr:hover {
            background-color: #d4d2d2;
        }

        .btn-custom {
            max-width: 150px;
            flex: 1;
        }
    </style>


    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb m-0 pl-4">
                        <li class="breadcrumb-item active">
                            <a href="/{{ $role }}/dashboard">Dashboard</a> / <a>Data Aset</a>
                        </li>
                    </ol>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">{{ Carbon\Carbon::parse(now())->isoFormat('dddd, D MMMM Y') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card ijo-atas">
                        <div class="card-body">
                            <div class="row card-data-barang">
                                <div class="col-12">
                                    <div class="container d-flex flex-wrap ustify-content-center ml-3 mr-3"
                                        style="padding: 0; width:100%;">
                                        <div>
                                            <h5 class="mb-0 mr-3">
                                                <b class="text-success">Data Aset<br>Logistik dan Perlengkapan</b>
                                            </h5>
                                        </div>
                                        <div class="btn-group d-flex flex-wrap ustify-content-center" style="width: 100%;">
                                            <button id="tab-dataAset" class="btn btn-light btn-block mt-2 mr-3"
                                                style="width: 150px; font-size: 16px;" onclick="openTab('dataAset')">Data
                                                Aset</button>
                                            <button id="tab-pemeriksaan" class="btn btn-light btn-block mt-2 mr-3"
                                                style="width: 150px; font-size: 16px;"
                                                onclick="openTab('pemeriksaan')">Pemeriksaan</button>
                                            <button id="tab-keluarMasuk" class="btn btn-light btn-block mt-2 mr-3"
                                                style="width: 150px; font-size: 16px;"
                                                onclick="openTab('keluarMasuk')">Keluar Masuk</button>
                                            <button id="tab-penyusutanNilai" class="btn btn-light btn-block mt-2 mr-3"
                                                style="width: 150px; font-size: 16px;"
                                                onclick="openTab('penyusutanNilai')">Penyusutan Nilai</button>
                                        </div>
                                    </div>

                                    <!-- success jika berhasil menambah data -->
                                    @if (session('success'))
                                        <div class="alert alert-success alert-dismissible fade show">
                                            {{ session('success') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif
                                    @if (session('error'))
                                        <div class="alert alert-danger alert-dismissible fade show">
                                            {{ session('error') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif

                                    {{-- script untuk close --}}
                                    <script>
                                        $(document).ready(function() {
                                            $('.alert .close').on('click', function() {
                                                $(this).parent('.alert').hide();
                                            });
                                        });
                                    </script>

                                    <!-- tab data aset -->
                                    <div id="dataAset" class="tab-content active" style="width: 99%; padding:10px; mt-1">
                                        <div class="col-12 col-sm-12 mb-2 mb-xl-0">
                                            <div class="card">
                                                <div class="card-body">
                                                    {{-- menu filter --}}
                                                    <form method="GET" action="{{ url($role . '/arsip/aset/data') }}">
                                                        @csrf
                                                        {{-- filter Tgl Pembelian --}}
                                                        <div class="row card-filter-barang">
                                                            <div class="col-12 col-md-4 col-sm-12 mb-2 mb-xl-0">
                                                                <div class="input-group">
                                                                    <div class="input-group" style="flex: 1;">
                                                                        <div class="input-group-prepend"
                                                                            style="border-radius: 10px;">
                                                                            <span class="input-group-text custom-text">Tgl
                                                                                Pembelian</span>
                                                                        </div>
                                                                        <div id="tgl-pembelian"
                                                                            class="form-control custom-input"
                                                                            style="align-items:stretch; background: #fff; cursor: pointer; border-top-right-radius: 10px; border-bottom-right-radius:10px; min-width: 100px;">
                                                                            <span style="align-content:center"></span>
                                                                        </div>
                                                                    </div>

                                                                    <input type="hidden" onchange="this.form.submit()"
                                                                        id="tgl-pembelian-start" name="tgl-pembelian-start"
                                                                        value="{{ request('tgl-pembelian-start') }}">
                                                                    <input type="hidden" onchange="this.form.submit()"
                                                                        id="tgl-pembelian-end" name="tgl-pembelian-end"
                                                                        value="{{ request('tgl-pembelian-end') }}">

                                                                    <script type="text/javascript">
                                                                        $(function() {
                                                                            // Set moment.js ke bahasa Indonesia
                                                                            moment.locale('id');

                                                                            // Inisialisasi nilai tanggal dari input hidden atau gunakan default jika kosong
                                                                            var start = moment($('#tgl-pembelian-start').val(), 'YYYY/MM/DD').isValid() ? moment($(
                                                                                '#tgl-pembelian-start').val(), 'YYYY/MM/DD') : moment().subtract(29, 'days');
                                                                            var end = moment($('#tgl-pembelian-end').val(), 'YYYY/MM/DD').isValid() ? moment($('#tgl-pembelian-end')
                                                                                .val(), 'YYYY/MM/DD') : moment();

                                                                            function cb(start, end) {
                                                                                let displayDate;

                                                                                // Cek apakah tahun sama
                                                                                if (start.year() === end.year()) {
                                                                                    // Jika bulan dan tahun sama, hanya tampilkan tanggal dan bulan
                                                                                    if (start.month() === end.month()) {
                                                                                        displayDate = start.format('DD') + ' - ' + end.format('DD/MM/YYYY');
                                                                                    } else {
                                                                                        displayDate = start.format('DD/MM') + ' - ' + end.format('DD/MM/YYYY');
                                                                                    }
                                                                                } else {
                                                                                    // Jika tahun berbeda, tampilkan tanggal lengkap
                                                                                    displayDate = start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY');
                                                                                }

                                                                                $('#tgl-pembelian span').html(displayDate); // Tampilkan tanggal yang diformat
                                                                                $('#tgl-pembelian-start').val(start.format('YYYY/MM/DD')); // Tetap format YYYY-MM-DD untuk server
                                                                                $('#tgl-pembelian-end').val(end.format('YYYY/MM/DD'));
                                                                            }

                                                                            $('#tgl-pembelian').daterangepicker({
                                                                                startDate: start,
                                                                                endDate: end,
                                                                                ranges: {
                                                                                    'Hari ini': [moment(), moment()],
                                                                                    'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                                                                                    '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
                                                                                    '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
                                                                                    'Bulan ini': [moment().startOf('month'), moment().endOf('month')],
                                                                                    'Bulan Terakhir': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                                                                                        'month').endOf('month')]
                                                                                },
                                                                                locale: {
                                                                                    format: 'DD/MM/YYYY', // Format tanggal menjadi angka
                                                                                    applyLabel: 'Terapkan',
                                                                                    cancelLabel: 'Batal',
                                                                                    customRangeLabel: 'Pilih Tanggal',
                                                                                    daysOfWeek: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                                                                                    monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus',
                                                                                        'September', 'Oktober', 'November', 'Desember'
                                                                                    ],
                                                                                    firstDay: 1 // Set Senin sebagai hari pertama dalam seminggu
                                                                                }
                                                                            }, cb);

                                                                            // Menangani tanggal saat apply pada daterangepicker
                                                                            $('#tgl-pembelian').on('apply.daterangepicker', function(ev, picker) {
                                                                                $('#tgl-pembelian-start').val(picker.startDate.format(
                                                                                    'YYYY/MM/DD')); // Tetap format YYYY-MM-DD untuk server
                                                                                $('#tgl-pembelian-end').val(picker.endDate.format('YYYY/MM/DD'));
                                                                                // Submit form secara otomatis setelah rentang tanggal dipilih
                                                                                $(this).closest('form').submit();
                                                                            });

                                                                            // Panggil callback untuk menampilkan range tanggal yang sudah di-set
                                                                            cb(start, end);
                                                                        });
                                                                    </script>

                                                                </div>
                                                            </div>
                                                            {{-- filter kondisi --}}
                                                            <div class="col-12 col-md-4 col-sm-12 mb-2 mb-xl-0">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">Kategori</div>
                                                                    </div>
                                                                    <select class="form-control" name="kategori"
                                                                        onchange="this.form.submit()"
                                                                        style="border-top-right-radius: 10px; border-bottom-right-radius:10px; min-width: 120px;">
                                                                        <option value="all"
                                                                            @if (request('kategori') == 'all') selected @endif>
                                                                            Semua
                                                                        </option>
                                                                        @foreach ($kategori as $kat)
                                                                            <option value="{{ $kat->id_kategori }}"
                                                                                @if (request('kategori') == $kat->id_kategori) selected @endif>
                                                                                {{ $kat->kategori }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                            </div>
                                                            {{-- filter tahun --}}
                                                            <div class="col-12 col-md-4 col-sm-12 mb-2 mb-xl-0 ">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">Status</div>
                                                                    </div>
                                                                    <select class="form-control" name="status"
                                                                        onchange="this.form.submit()"
                                                                        style="border-top-right-radius: 10px; border-bottom-right-radius:10px; min-width: 120px;">
                                                                        <option value="all"
                                                                            @if (request('status') == 'all') selected @endif>
                                                                            Semua
                                                                        </option>
                                                                        <option value="aktif"
                                                                            @if (request('status') == 'aktif') selected @endif>
                                                                            Aktif
                                                                        </option>
                                                                        <option value="non aktif"
                                                                            @if (request('status') == 'non aktif') selected @endif>
                                                                            Non
                                                                            Aktif</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="container" style="padding: 0;margin:0;">
                                                                <div class="col-12 col-md-10 mb-2 mb-xl-0">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="p-2">
                                                                            <i class="fas fa-info-circle"></i>
                                                                        </div>
                                                                        <div class="p-2">
                                                                            <span>
                                                                                Data Aset PC Lazisnu Cilacap. Dapat
                                                                                ditambahkan oleh Staff Logistik dan
                                                                                Perlengkapan.
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="container" style="padding: 0;">
                                                                    <div class="btn-group justify-content-end">
                                                                        <button type="button"
                                                                            class="btn btn-outline-secondary btn-sm btn-custom"
                                                                            onclick="resetFilters()"
                                                                            style="border: 1px solid #495057;">
                                                                            <i class="fas fa-sync-alt"></i>
                                                                        </button>
                                                                        <a href="/{{ $role }}/print-aset"
                                                                            target="_blank"
                                                                            class="btn btn-outline-secondary btn-sm btn-custom ml-2"
                                                                            style="border: 1px solid #495057;">
                                                                            <i class="fas fa-file-alt"
                                                                                style="margin-right: 5px;"></i> Export
                                                                        </a>
                                                                        <button type="button"
                                                                            class="btn btn-success btn-sm btn-custom ml-2"
                                                                            data-toggle="modal" data-target="#tambahModal"
                                                                            style="background-color: #28a745; color: white;">
                                                                            <i class="fas fa-plus-circle"></i> Tambah
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <script>
                                                                function resetFilters() {
                                                                    // Dapatkan URL saat ini tanpa query string
                                                                    const baseUrl = window.location.origin + window.location.pathname;
                                                                    // Arahkan ke URL dasar (tanpa filter) dan tambahkan parameter tab
                                                                    window.location.href = `${baseUrl}?tab=dataAset`;
                                                                }

                                                                // Deteksi tab pemeriksaan dari URL dan otomatis membuka tab tersebut
                                                                document.addEventListener("DOMContentLoaded", function() {
                                                                    const urlParams = new URLSearchParams(window.location.search);
                                                                    const tabParam = urlParams.get('tab');
                                                                    if (tabParam === 'dataAset') {
                                                                        openTab(tabParam); // Sesuaikan 'dataAset' dengan ID tab pemeriksaan
                                                                    }
                                                                });
                                                            </script>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Table aset -->
                                        <div class="table-responsive mt-0 card-table-berita">
                                            <table id="tableDataAset" class="table table-bordered"
                                                style="width:100%; font-size: 13px;">
                                                <thead style="text-align: center; font-size: 16px; background-color:white">
                                                    <tr>
                                                        <th style="width:5%;">No</th>
                                                        <th style="width:17%;">Kode Aset</th>
                                                        <th style="width:10%;">Nama Aset</th>
                                                        <th style="width:10%;">Kategori</th>
                                                        <th style="width:10%;">Lokasi Penyimpanan</th>
                                                        <th>Satuan</th>
                                                        <th style="width:19%;">Pemeriksaan</th>
                                                        <th style="width:19%;">Keluar Masuk</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="hover-pointer">
                                                    @foreach ($aset as $data)
                                                        <tr
                                                            data-url="/{{ $role }}/arsip/aset/detail/{{ $data->aset_id }}">
                                                            <td style="text-align: center;">{{ $loop->iteration }}</td>
                                                            <td>
                                                                <table
                                                                    style="width: 100%; border: none; border-collapse: collapse; font-size: 13px;">
                                                                    <tr>
                                                                        <td style="border: none; padding: 4px;">
                                                                            <b>{{ $data->kode_aset }}</b>
                                                                        </td>
                                                                    </tr>
                                                                    <tr
                                                                        style="display: flex; justify-content: space-between;">
                                                                        <td style="border: none;padding: 4px; flex: 2;">
                                                                            Tgl Pembelian
                                                                        </td>
                                                                        <td
                                                                            style="border: none;padding: 4px; flex: 2; font-size: 12px;text-align:left;">
                                                                            <b>{{ $data->tgl_perolehan ?? 'Data tidak tersedia' }}</b>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td
                                                                            style="border: none; padding: 4px; font-size: 12px;">
                                                                            @php
                                                                                $status =
                                                                                    $data->latestDetailPemeriksaanAset
                                                                                        ->status_aset ?? 'null';
                                                                                $warnaTombol =
                                                                                    $status === 'null'
                                                                                        ? 'background-color: #a9a9a9;'
                                                                                        : ($status === 'aktif'
                                                                                            ? 'background-color: #55CE71;'
                                                                                            : 'background-color: rgb(255, 18, 18);');
                                                                                $teksTombol =
                                                                                    $status === 'null'
                                                                                        ? 'Belum ada pemeriksaan'
                                                                                        : ($status === 'aktif'
                                                                                            ? 'Aktif'
                                                                                            : 'Non Aktif');
                                                                            @endphp
                                                                            <button type="button" class="btn"
                                                                                style="border-radius: 10px; {{ $warnaTombol }} color: white; padding: 2px 6px; font-size: 12px; line-height: 1;">
                                                                                {{ $teksTombol }}
                                                                            </button>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                            <td style="text-align:center;"><b>{{ $data->nama_aset }}</b>
                                                            </td>
                                                            <td style="text-align:center;">
                                                                {{ $data->kategori_aset->kategori ?? 'Tidak Ada Kategori' }}
                                                            </td>
                                                            <td style="text-align:center;">{{ $data->lokasi_penyimpanan }}
                                                            </td>
                                                            <td style="text-align:center;">{{ $data->satuan }}</td>
                                                            <td>
                                                                <table
                                                                    style="width:100%; border:none; border-collapse: collapse;">
                                                                    <tr>
                                                                        <td
                                                                            style="border: none; padding: 4px; line-height: 1.2;">
                                                                            Tgl
                                                                        </td>
                                                                        <td
                                                                            style="border: none; padding: 4px; text-align: right; font-size: 12px; line-height: 1.2;">
                                                                            <b>{{ $data->latestDetailPemeriksaanAset->pemeriksaanAset->tanggal_pemeriksaan ?? '-' }}</b>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td
                                                                            style="border: none; padding: 4px; line-height: 1.2;">
                                                                            Kondisi
                                                                        </td>
                                                                        <td
                                                                            style="text-align: right; border: none; padding: 4px; color:
                                                                            {{ isset($data->latestDetailPemeriksaanAset) ? ($data->latestDetailPemeriksaanAset->kondisi == 'baik' ? '#55CE71' : ($data->latestDetailPemeriksaanAset->kondisi == 'rusak' ? 'rgb(255, 18, 18)' : 'inherit')) : '' }}; line-height: 1.2;">
                                                                            {{ $data->latestDetailPemeriksaanAset->kondisi ?? '-' }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td
                                                                            style="border: none; padding: 4px; line-height: 1.2;">
                                                                            Status
                                                                        </td>
                                                                        <td
                                                                            style="border: none; padding: 4px; text-align: right; color:
                                                                            {{ isset($data->latestDetailPemeriksaanAset) ? ($data->latestDetailPemeriksaanAset->status_aset == 'aktif' ? '#55CE71' : ($data->latestDetailPemeriksaanAset->status_aset == 'non aktif' ? 'rgb(255, 18, 18)' : 'inherit')) : '' }}; line-height: 1.2;">
                                                                            {{ $data->latestDetailPemeriksaanAset->status_aset ?? '-' }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td
                                                                            style="border: none; padding: 4px; line-height: 1.2;">
                                                                            Keterangan
                                                                        </td>
                                                                        <td
                                                                            style="border: none; padding: 4px; text-align: right; line-height: 1.2;">
                                                                            {{ $data->latestDetailPemeriksaanAset->masalah_teridentifikasi ?? '-' }}
                                                                        </td>
                                                                    </tr>
                                                                </table>

                                                            </td>
                                                            <td>
                                                                <table
                                                                    style="width:100%; border:none; border-collapse: collapse; font-size:13px;">
                                                                    <tr>
                                                                        <td
                                                                            style="border: none; padding: 4px; line-height: 1.2;">
                                                                            Tgl Input
                                                                        </td>
                                                                        <td
                                                                            style="border: none; padding: 4px; font-size:12px; line-height: 1.2; text-align:right;">
                                                                            <b>Tgl Input</b>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td
                                                                            style="border: none; padding: 4px; line-height: 1.2;">
                                                                            Jml Masuk
                                                                        </td>
                                                                        <td style="border: none; padding: 4px; line-height: 1.2; text-align:right;"
                                                                            class="text-success">
                                                                            Jml Masuk
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td
                                                                            style="border: none; padding: 4px; line-height: 1.2;">
                                                                            Jml Keluar
                                                                        </td>
                                                                        <td style="border: none; padding: 4px; line-height: 1.2; text-align:right;"
                                                                            class="text-warning">
                                                                            Jml Keluar
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td
                                                                            style="border: none; padding: 4px; line-height: 1.2;">
                                                                            Sisa
                                                                        </td>
                                                                        <td
                                                                            style="border: none; padding: 4px; line-height: 1.2; text-align:right;">
                                                                            Sisa
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- tab pemeriksaan -->
                                    <div id="pemeriksaan" class="tab-content" style="width: 99%; padding:10px; mt-1">

                                        <div class="col-12 col-sm-12 mb-2 mb-xl-0">
                                            <div class="card">
                                                <div class="card-body">
                                                    {{-- menu filter --}}
                                                    <form method="GET" action="{{ url($role . '/arsip/aset/data') }}">
                                                        @csrf
                                                        {{-- filter Tgl Pembelian --}}
                                                        <div class="row card-filter-barang">
                                                            <div class="col-12 col-md-4 col-sm-12 mb-2 mb-xl-0">
                                                                <div class="input-group">
                                                                    <div class="input-group" style="flex: 1;">
                                                                        <div class="input-group-prepend"
                                                                            style="border-radius: 10px;">
                                                                            <span class="input-group-text custom-text">Tgl
                                                                                Pemeriksaan</span>
                                                                        </div>
                                                                        <div id="tgl-pemeriksaan"
                                                                            class="form-control custom-input"
                                                                            style="align-items:stretch; background: #fff; cursor: pointer; border-top-right-radius: 10px; border-bottom-right-radius:10px; min-width: 100px;">
                                                                            <span style="align-content:center"></span>
                                                                        </div>
                                                                    </div>

                                                                    <input type="hidden" onchange="this.form.submit()"
                                                                        id="tgl-pemeriksaan-start"
                                                                        name="tgl-pemeriksaan-start"
                                                                        value="{{ request('tgl-pemeriksaan-start') }}">
                                                                    <input type="hidden" onchange="this.form.submit()"
                                                                        id="tgl-pemeriksaan-end"
                                                                        name="tgl-pemeriksaan-end"
                                                                        value="{{ request('tgl-pemeriksaan-end') }}">

                                                                    <script type="text/javascript">
                                                                        $(function() {
                                                                            // Set moment.js ke bahasa Indonesia
                                                                            moment.locale('id');

                                                                            // Inisialisasi nilai tanggal dari input hidden atau gunakan default jika kosong
                                                                            var start = moment($('#tgl-pemeriksaan-start').val(), 'YYYY/MM/DD').isValid() ? moment($(
                                                                                '#tgl-pemeriksaan-start').val(), 'YYYY/MM/DD') : moment().subtract(29, 'days');
                                                                            var end = moment($('#tgl-pemeriksaan-end').val(), 'YYYY/MM/DD').isValid() ? moment($(
                                                                                    '#tgl-pemeriksaan-end')
                                                                                .val(), 'YYYY/MM/DD') : moment();

                                                                            function cb(start, end) {
                                                                                let displayDate;

                                                                                // Cek apakah tahun sama
                                                                                if (start.year() === end.year()) {
                                                                                    // Jika bulan dan tahun sama, hanya tampilkan tanggal dan bulan
                                                                                    if (start.month() === end.month()) {
                                                                                        displayDate = start.format('DD') + ' - ' + end.format('DD/MM/YYYY');
                                                                                    } else {
                                                                                        displayDate = start.format('DD/MM') + ' - ' + end.format('DD/MM/YYYY');
                                                                                    }
                                                                                } else {
                                                                                    // Jika tahun berbeda, tampilkan tanggal lengkap
                                                                                    displayDate = start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY');
                                                                                }

                                                                                $('#tgl-pemeriksaan span').html(displayDate); // Tampilkan tanggal yang diformat
                                                                                $('#tgl-pemeriksaan-start').val(start.format('YYYY/MM/DD')); // Tetap format YYYY-MM-DD untuk server
                                                                                $('#tgl-pemeriksaan-end').val(end.format('YYYY/MM/DD'));
                                                                            }

                                                                            $('#tgl-pemeriksaan').daterangepicker({
                                                                                startDate: start,
                                                                                endDate: end,
                                                                                ranges: {
                                                                                    'Hari ini': [moment(), moment()],
                                                                                    'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                                                                                    '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
                                                                                    '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
                                                                                    'Bulan ini': [moment().startOf('month'), moment().endOf('month')],
                                                                                    'Bulan Terakhir': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                                                                                        'month').endOf('month')]
                                                                                },
                                                                                locale: {
                                                                                    format: 'DD/MM/YYYY', // Format tanggal menjadi angka
                                                                                    applyLabel: 'Terapkan',
                                                                                    cancelLabel: 'Batal',
                                                                                    customRangeLabel: 'Pilih Tanggal',
                                                                                    daysOfWeek: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                                                                                    monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus',
                                                                                        'September', 'Oktober', 'November', 'Desember'
                                                                                    ],
                                                                                    firstDay: 1 // Set Senin sebagai hari pertama dalam seminggu
                                                                                }
                                                                            }, cb);

                                                                            // Menangani tanggal saat apply pada daterangepicker
                                                                            $('#tgl-pemeriksaan').on('apply.daterangepicker', function(ev, picker) {
                                                                                $('#tgl-pemeriksaan-start').val(picker.startDate.format(
                                                                                    'YYYY/MM/DD')); // Tetap format YYYY-MM-DD untuk server
                                                                                $('#tgl-pemeriksaan-end').val(picker.endDate.format('YYYY/MM/DD'));
                                                                                // Submit form secara otomatis setelah rentang tanggal dipilih
                                                                                $(this).closest('form').submit();
                                                                            });

                                                                            // Panggil callback untuk menampilkan range tanggal yang sudah di-set
                                                                            cb(start, end);
                                                                        });
                                                                    </script>

                                                                </div>
                                                            </div>
                                                            {{-- filter kondisi --}}
                                                            <div class="col-12 col-md-4 col-sm-12 mb-2 mb-xl-0">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">Status SPV</div>
                                                                    </div>
                                                                    <select class="form-control" name="filter_status_spv"
                                                                        onchange="this.form.submit();"
                                                                        style="border-top-right-radius: 10px; border-bottom-right-radius:10px;">
                                                                        <option value="all"
                                                                            {{ request('filter_status_spv', 'all') == 'all' ? 'selected' : '' }}>
                                                                            Semua
                                                                        </option>
                                                                        <option value="mengetahui"
                                                                            {{ request('filter_status_spv') == 'mengetahui' ? 'selected' : '' }}>
                                                                            Mengetahui
                                                                        </option>
                                                                        <option value="belum"
                                                                            {{ request('filter_status_spv') == 'belum' ? 'selected' : '' }}>
                                                                            Belum Mengetahui
                                                                        </option>
                                                                    </select>
                                                                </div>

                                                            </div>
                                                            {{-- filter tahun --}}
                                                            <div class="col-12 col-md-4 col-sm-12 mb-2 mb-xl-0 ">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">Status KC</div>
                                                                    </div>
                                                                    <select class="form-control" name="filter_status_kc"
                                                                        onchange="this.form.submit();"
                                                                        style="border-top-right-radius: 10px; border-bottom-right-radius:10px;">
                                                                        <option value="all"
                                                                            {{ request('filter_status_kc', 'all') == 'all' ? 'selected' : '' }}>
                                                                            Semua
                                                                        </option>
                                                                        <option value="mengetahui"
                                                                            {{ request('filter_status_kc') == 'mengetahui' ? 'selected' : '' }}>
                                                                            Mengetahui
                                                                        </option>
                                                                        <option value="belum"
                                                                            {{ request('filter_status_kc') == 'belum' ? 'selected' : '' }}>
                                                                            Belum Mengetahui
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="container" style="padding: 0;margin:0;">
                                                                <div class="col-12 col-md-10 mb-2 mb-xl-0">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="p-2">
                                                                            <i class="fas fa-info-circle"></i>
                                                                        </div>
                                                                        <div class="p-2">
                                                                            <span>
                                                                                Data Aset PC Lazisnu Cilacap. Dapat
                                                                                ditambahkan oleh Staff Logistik dan
                                                                                Perlengkapan.
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="container" style="padding: 0;">
                                                                    <div class="btn-group justify-content-end">
                                                                        <button type="button"
                                                                            class="btn btn-outline-secondary btn-sm btn-custom"
                                                                            onclick="resetFiltersPemeriksaan()"
                                                                            style="border: 1px solid #495057;">
                                                                            <i class="fas fa-sync-alt"></i>
                                                                        </button>
                                                                        <a href="/{{ $role }}/print-data-pemeriksaan"
                                                                            target="_blank"
                                                                            class="btn btn-outline-secondary btn-sm btn-custom ml-2"
                                                                            style="border: 1px solid #495057;">
                                                                            <i class="fas fa-file-alt"
                                                                                style="margin-right: 5px;"></i> Export
                                                                        </a>
                                                                        <button type="button"
                                                                            class="btn btn-success btn-sm btn-custom ml-2"
                                                                            data-toggle="modal" data-target="#pemeriksaanModal"
                                                                            style="background-color: #28a745; color: white;">
                                                                            <i class="fas fa-plus-circle"></i> Tambah
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <script>
                                                                function resetFiltersPemeriksaan() {
                                                                    // Dapatkan URL saat ini tanpa query string
                                                                    const baseUrl = window.location.origin + window.location.pathname;
                                                                    // Arahkan ke URL dasar (tanpa filter) dan tambahkan parameter tab
                                                                    window.location.href = `${baseUrl}?tab=pemeriksaan`;
                                                                }
            
                                                                // Deteksi tab pemeriksaan dari URL dan otomatis membuka tab tersebut
                                                                document.addEventListener("DOMContentLoaded", function() {
                                                                    const urlParams = new URLSearchParams(window.location.search);
                                                                    const tabParam = urlParams.get('tab');
                                                                    if (tabParam === 'pemeriksaan') {
                                                                        openTab(tabParam); // Sesuaikan 'dataAset' dengan ID tab pemeriksaan
                                                                    }
                                                                });
                                                            </script>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- tabel pemeriksaan --}}
                                        <div class="table-responsive mt-0 card-table-berita">
                                            <table id="tablePemeriksaan" class="table table-bordered"
                                                style="width:100%; font-size:13px;">
                                                <thead style="text-align: center; font-size: 16px;background-color:white">
                                                    <tr>
                                                        <th>No</th>
                                                        <th style="width: 10%;">Tgl Pemeriksaan</th>
                                                        <th style="width: 17%;">Pemeriksa</th>
                                                        <th>Aset Diperiksa</th>
                                                        <th style="width: 20%;">Berdasarkan Kondisi</th>
                                                        <th style="width: 17%;">Berdasarkan Status</th>
                                                        <th style="width: 17%;">Status SPV</th>
                                                        <th style="width: 17%;">Status KC</th>
                                                    </tr>
                                                </thead>
                                                <tbody style="font-size:13px;" class="hover-pointer">
                                                    @php
                                                        $no = 1;
                                                    @endphp
                                                    @foreach ($pemeriksaanGrouped as $groupKey => $details)
                                                        @php
                                                            // Memisahkan nama pemeriksa dan tanggal pemeriksaan
                                                            [$namaPemeriksa, $tanggalPemeriksaan] = explode(
                                                                '-',
                                                                $groupKey,
                                                            );
                                                        @endphp
                                                        @foreach ($details as $key => $detail)
                                                            <tr
                                                                data-url="/{{ $role }}/arsip/aset/detail_pemeriksaan/{{ $detail->id_pemeriksaan_aset }}/{{ $detail->tanggal_pemeriksaan }}">
                                                                @if ($key == 0)
                                                                    <td style="text-align: center;">{{ $no++ }}
                                                                    </td>
                                                                    <td style="text-align: center;">
                                                                        <b>{{ $detail->tanggal_pemeriksaan }}</b>
                                                                    </td>
                                                                    <td><b>
                                                                            {{ $namaPemeriksa }}
                                                                        </b>
                                                                        <br>
                                                                        {{ $detail->pcPengurus->pengurusJabatan->jabatan }}
                                                                    </td>
                                                                    <td style="text-align: center;">
                                                                        @if ($detail->detailPemeriksaanAset->isNotEmpty())
                                                                            {{ $totalDetailPemeriksaan = $detail->detailPemeriksaanAset->count() }}
                                                                            Aset
                                                                        @else
                                                                            0 Aset
                                                                        @endif
                                                                    </td>
                                                                    <td style="padding: 5px;">
                                                                        @if ($detail->detailPemeriksaanAset->isNotEmpty())
                                                                            <table id="example"
                                                                                style="border-collapse: collapse; width: 100%; margin: 0;">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td
                                                                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 4px; width:50%;">
                                                                                            baik</td>
                                                                                        <td
                                                                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 4px; width:25%; text-align:center;">
                                                                                            {{ $baikCount = $detail->detailPemeriksaanAset->where('kondisi', 'baik')->count() }}
                                                                                        </td>
                                                                                        <td
                                                                                            style="border: none;text-align: right; font-size: 13px; line-height: 1.2; padding: 4px; width:25%;">
                                                                                            {{ $totalDetailPemeriksaan > 0 ? round(($baikCount / $totalDetailPemeriksaan) * 100, 2) : 0 }}%
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td
                                                                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 4px;">
                                                                                            rusak</td>
                                                                                        <td style="border: none;font-size: 13px; line-height: 1.2; padding: 4px; text-align:center;"
                                                                                            class="text-primary">
                                                                                            {{ $rusakCount = $detail->detailPemeriksaanAset->where('kondisi', 'rusak')->count() }}
                                                                                        </td>
                                                                                        <td style="border: none;text-align: right; font-size: 13px; line-height: 1.2; padding: 4px;"
                                                                                            class="text-primary">
                                                                                            {{ $totalDetailPemeriksaan > 0 ? round(($rusakCount / $totalDetailPemeriksaan) * 100, 2) : 0 }}%
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td
                                                                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 4px;">
                                                                                            perlu perbaikan</td>
                                                                                        <td style="border: none;font-size: 13px; line-height: 1.2; padding: 4px; text-align:center;"
                                                                                            class="text-warning">
                                                                                            {{ $serviceCount = $detail->detailPemeriksaanAset->where('kondisi', 'perlu service')->count() }}
                                                                                        </td>
                                                                                        <td style="border: none;text-align: right; font-size: 13px; line-height: 1.2; padding: 4px;"
                                                                                            class="text-warning">
                                                                                            {{ $totalDetailPemeriksaan > 0 ? round(($serviceCount / $totalDetailPemeriksaan) * 100, 2) : 0 }}%
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td
                                                                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 4px;">
                                                                                            hilang</td>
                                                                                        <td style="border: none;font-size: 13px; line-height: 1.2; padding: 4px; text-align:center;"
                                                                                            class="text-danger">
                                                                                            {{ $hilangCount = $detail->detailPemeriksaanAset->where('kondisi', 'hilang')->count() }}
                                                                                        </td>
                                                                                        <td style="border: none;text-align: right; font-size: 13px; line-height: 1.2; padding: 4px;"
                                                                                            class="text-danger">
                                                                                            {{ $totalDetailPemeriksaan > 0 ? round(($hilangCount / $totalDetailPemeriksaan) * 100, 2) : 0 }}%
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        @else
                                                                            <table id="example"
                                                                                style="border-collapse: collapse; width: 100%; margin: 0;">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td
                                                                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 4px;width:50%;">
                                                                                            baik</td>
                                                                                        <td
                                                                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 4px;width:25%;text-align:center;">
                                                                                            -</td>
                                                                                        <td
                                                                                            style="border: none;text-align: center; font-size: 13px; line-height: 1.2; padding: 4px;width:25%;">
                                                                                            -</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td
                                                                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 4px;width:50%;">
                                                                                            rusak</td>
                                                                                        <td style="border: none;font-size: 13px; line-height: 1.2; padding: 4px;width:25%;text-align:center;"
                                                                                            class="text-primary">-</td>
                                                                                        <td style="border: none;text-align:center; font-size: 13px; line-height: 1.2; padding: 4px;width:25%;"
                                                                                            class="text-primary">-</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td
                                                                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 4px;width:50%;">
                                                                                            perlu perbaikan</td>
                                                                                        <td style="border: none;font-size: 13px; line-height: 1.2; padding: 4px;width:25%;text-align:center;"
                                                                                            class="text-warning">-</td>
                                                                                        <td style="border: none;text-align:center; font-size: 13px; line-height: 1.2; padding: 4px;width:25%;"
                                                                                            class="text-warning">-</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td
                                                                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 4px;width:50%;">
                                                                                            hilang</td>
                                                                                        <td style="border: none;font-size: 13px; line-height: 1.2; padding: 4px;width:25%;text-align:center;"
                                                                                            class="text-danger">-</td>
                                                                                        <td style="border: none;text-align:center; font-size: 13px; line-height: 1.2; padding: 4px;width:25%;"
                                                                                            class="text-danger">-</td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        @endif
                                                                    </td>
                                                                    <td style="padding: 10px;">
                                                                        @if ($detail->detailPemeriksaanAset->isNotEmpty())
                                                                            <table id="example"
                                                                                style="border-collapse: collapse; width: 100%; margin: 0;">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td
                                                                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 4px; width:50%;">
                                                                                            Aktif</td>
                                                                                        <td style="border: none;font-size: 13px; line-height: 1.2; padding: 4px; width:25%;text-align: center;"
                                                                                            class="text-success">
                                                                                            {{ $aktifCount = $detail->detailPemeriksaanAset->where('status_aset', 'aktif')->count() ?? '-' }}
                                                                                        </td>
                                                                                        <td style="border: none;text-align: right; font-size: 13px; line-height: 1.2; padding: 4px; width:25%;"
                                                                                            class="text-success">
                                                                                            {{ $totalDetailPemeriksaan > 0 ? round(($aktifCount / $totalDetailPemeriksaan) * 100, 2) : 0 }}%
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td
                                                                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 4px; width:50%;">
                                                                                            Non Aktif</td>
                                                                                        <td style="border: none;font-size: 13px; line-height: 1.2; padding: 4px; width:25%;text-align:center;"
                                                                                            class="text-danger">
                                                                                            {{ $nonAktifCount = $detail->detailPemeriksaanAset->where('status_aset', 'non aktif')->count() ?? '-' }}
                                                                                        </td>
                                                                                        <td style="border: none;text-align: right; font-size: 13px; line-height: 1.2; padding: 4px; width:25%;"
                                                                                            class="text-danger">
                                                                                            {{ $totalDetailPemeriksaan > 0 ? round(($nonAktifCount / $totalDetailPemeriksaan) * 100, 2) : 0 }}%
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        @else
                                                                            <table id="example"
                                                                                style="border-collapse: collapse; width: 100%; margin: 0;">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td
                                                                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 4px; width:50%;">
                                                                                            Aktif</td>
                                                                                        <td style="border: none;font-size: 13px; line-height: 1.2; padding: 4px; width:25%; text-align: center;"
                                                                                            class="text-success">-</td>
                                                                                        <td style="border: none;text-align: right; font-size: 13px; line-height: 1.2; padding: 4px; width:25%;"
                                                                                            class="text-success">-</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td
                                                                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 4px; width:50%;">
                                                                                            Non Aktif</td>
                                                                                        <td style="border: none;font-size: 13px; line-height: 1.2; padding: 4px; width:25%; text-align:center"
                                                                                            class="text-danger">-</td>
                                                                                        <td style="border: none;text-align: right; font-size: 13px; line-height: 1.2; padding: 4px; width:25%;"
                                                                                            class="text-danger">-</td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <div>
                                                                            @if ($detail->status_spv == 'mengetahui')
                                                                                <div class="text-success">Mengetahui</div>
                                                                            @else
                                                                                <div class="text-danger">Belum Mengetahui
                                                                                </div>
                                                                            @endif
                                                                            <div>
                                                                                <b>{{ $detail->supervisor->pengguna->nama }}</b>
                                                                            </div>
                                                                            <div>
                                                                                {{ $detail->supervisor->pengurusJabatan->jabatan }}
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div>
                                                                            @if ($detail->status_kc == 'mengetahui')
                                                                                <div class="text-success">Mengetahui</div>
                                                                            @else
                                                                                <div class="text-danger">Belum Mengetahui
                                                                                </div>
                                                                            @endif
                                                                            <div><b>{{ $detail->kc->pengguna->nama }}</b>
                                                                            </div>
                                                                            <div>
                                                                                {{ $detail->kc->pengurusJabatan->jabatan }}
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                @endif
                                                            </tr>
                                                        @endforeach
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    {{-- tab keluar masuk --}}
                                    <div id="keluarMasuk" class="tab-content" style="width: 99%; padding:10px; mt-1">
                                        <table id="tableKeluarMasuk" class="table-responsive mt-0 card-table-berita"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>NO</th>
                                                    <th>Diinput Oleh</th>
                                                    <th>Tanggal Input</th>
                                                    <th>Keluar</th>
                                                    <th>Masuk</th>
                                                    <th>Sisa</th>
                                                    <th>Keterangan</th>
                                                    <th>Respon KC</th>
                                                    <th style="width: 150px;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="penyusutanNilai" class="tab-content">
                                        <h2>Penyusutan Nilai</h2>
                                        <p>Konten untuk Penyusutan Nilai.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- modal tambah barang --}}
    <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Tambah Data Aset</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="myForm" method="POST" action="{{ route($role . '.aset.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="kode">Kode Aset </label>
                            <input type="text" value="{{ $kodeAset }}" class="form-control" id="kode_aset"
                                name="kode_aset" readonly>
                        </div>
                        <div class="form-group">
                            <label for="tgl_beli">Tgl Perolehan </label>
                            <input type="date" class="form-control" id="tgl_beli" name="tgl_perolehan">
                        </div>
                        <div class="form-group">
                            <label for="asal">Asal Perolehan </label>
                            <input type="text" class="form-control" id="asal_perolehan" name="asal_perolehan">
                        </div>
                        <div class="form-group">
                            <label for="name">Nama </label>
                            <input type="text" class="form-control" id="name" name="nama_aset">
                        </div>
                        <div class="form-group">
                            <label for="kategori">Kategori </label>
                            <select class="form-control" id="kategori" name="kategori"
                                onchange="toggleNewCategoryForm()">
                                <option value="">Pilih Kategori</option>
                                @foreach ($kategori as $kat)
                                    <option value="{{ $kat->id_kategori }}">
                                        {{ $kat->kategori }}</option>
                                @endforeach
                                <option value="others">Lainnya</option>
                            </select>
                            <div class="mt-2" id="newCategoryForm" style="display: none;">
                                <input type="text" id="newKategori" class="form-control"
                                    placeholder="Tambah kategori baru">
                                <button type="button" id="" class="btn btn-success mt-2"
                                    onclick="addCategory()">Tambah
                                    Kategori</button>
                            </div>
                        </div>
                        <div class="form-grPoup">
                            <label for="satuan">Satuan </label>
                            <input type="text" class="form-control" id="satuan" name="satuan">
                        </div>
                        <div class="form-group">
                            <label for="lokasi">Lokasi Penyimpanan </label>
                            <input type="text" class="form-control" id="lokasi" name="lokasi_penyimpanan">
                        </div>
                        <div class="form-group">
                            <label for="spesifikasi">Spesifikasi/Deskripsi </label>
                            <input type="text" class="form-control" id="spesifikasi" name="spesifikasi">
                        </div>
                        <div>
                            <button type="submit" class="btn btn-success"
                                style="width: 100%; padding: 8px 0; font-weight: bold;">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- script untuk menyimpan kategori --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Pasang event listener pada tombol "Tambah Kategori"
            document.getElementById('addCategoryButton').addEventListener('click', function() {
                addCategory();
            });

            // Menampilkan atau menyembunyikan form kategori baru berdasarkan pilihan
            toggleNewCategoryForm();
        });

        function toggleNewCategoryForm() {
            var select = document.getElementById('kategori');
            var newCategoryForm = document.getElementById('newCategoryForm');
            if (select.value === 'others') {
                newCategoryForm.style.display = 'block';
            } else {
                newCategoryForm.style.display = 'none';
            }
        }

        function addCategory() {
            var newCategory = document.getElementById('newKategori').value.trim();
            if (newCategory) {
                // Kirim kategori baru ke server
                $.ajax({
                    url: '{{ route('pc.kategori.store') }}',
                    type: 'POST',
                    data: {
                        nama: newCategory,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        if (data.id) {
                            var select = document.getElementById('kategori');
                            var option = document.createElement('option');
                            option.value = data.id; // Gunakan ID dari respons (id_kategori)
                            option.text = data.nama; // Gunakan nama dari respons (kategori)
                            select.add(option);
                            select.value = data.id; // Setel kategori baru sebagai yang dipilih
                            document.getElementById('newKategori').value = ''; // Kosongkan input
                            document.getElementById('newCategoryForm').style.display =
                                'none'; // Sembunyikan form setelah menambah
                        } else {
                            alert('Gagal menambahkan kategori.');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Gagal menyimpan kategori baru.');
                    }
                });
            } else {
                alert('Silakan masukkan nama kategori baru.');
            }
        }
    </script>

    <!-- modal tambah pemeriksaan -->
    <div class="modal fade" id="pemeriksaanModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Tambah Pemeriksaan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding-top: 0;">
                    <form id="myForm" method="POST"
                        action="{{ route($role . '.pemeriksaan.store', ['tab' => 'pemeriksaan']) }}">
                        @csrf
                        <div class="form-group">
                            <label for="tgl_pemeriksaan" style="font-weight: bold; font-size: 14px;">Tgl
                                Pemeriksaan</label>
                            <input type="date" id="tanggal_pemeriksaan" name="tanggal_pemeriksaan"
                                class="form-control custom-input" required>
                            <div class="form-group">
                                <label for="manajemen_eksekutif" style="font-weight: bold; font-size: 14px;">Manajemen
                                    Eksekutif</label>
                                <input type="text" class="form-control" id="manajemen_eksekutif"
                                    style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;"
                                    value="Nu-Care Lazisnu Cilacap" readonly>
                            </div>
                            <div class="form-group">
                                <label for="pemeriksa" style="font-weight: bold; font-size: 14px;">Pemeriksa</label>
                                <input type="text" class="form-control" id="pemeriksa" name="nama_pemeriksa"
                                    style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;"
                                    value="{{ Auth::user()->nama }}" readonly>
                                <input type="text" class="form-control" id="pemeriksa" name="id_pemeriksa"
                                    style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;" name="id_pemeriksa"
                                    value="{{ Auth::user()->gocap_id_pc_pengurus }}" hidden>
                            </div>
                            <div class="form-group">
                                <label for="supervisor" style="font-weight: bold; font-size: 14px;">Supervisor</label>
                                <input type="text" class="form-control" id="supervisor" name="nama"
                                    style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;"
                                    value="{{ $supervisor->nama_supervisor }}" readonly>
                                <input type="text" class="form-control" id="supervisor" name="id_supervisor"
                                    style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;" name="id_supervisor"
                                    value="{{ $supervisor->id_supervisor }}" hidden>
                            </div>
                            <div class="form-group">
                                <label for="kepala_cabang" style="font-weight: bold; font-size: 14px;">Kepala
                                    Cabang</label>
                                <input type="text" class="form-control" id="kepala_cabang"
                                    style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;"
                                    value="{{ $kc->nama_kc }}" readonly>
                                <input type="text" class="form-control" id="kepala_cabang"
                                    style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;" name="id_kc"
                                    value="{{ $kc->id_kc }}" hidden>
                            </div>
                            <div class="alert alert-info"
                                style="background-color: #d4edda; border-color: #c3e6cb; color: #155724; margin-top: 15px;">
                                <strong>INFORMASI</strong><br>Setelah berhasil menambahkan pemeriksaan, anda wajib
                                melengkapi
                                data pemeriksaan aset.
                            </div>
                            <div>
                                <button type="submit" class="btn btn-success"
                                    style="width: 100%; padding: 8px 0; font-weight: bold;">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- script untuk rows click --}}
    <script>
        $(document).ready(function() {
            $('table tbody tr').click(function() {
                window.location = $(this).data('url');
            });
        });
    </script>

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

    <script>
        function openTab(tabId) {
            // Sembunyikan semua konten tab
            var contents = document.getElementsByClassName('tab-content');
            for (var i = 0; i < contents.length; i++) {
                contents[i].style.display = "none"; // Menyembunyikan semua tab
            }

            // Tampilkan konten tab yang dipilih
            document.getElementById(tabId).style.display = "block"; // Menampilkan tab yang dipilih

            // Inisialisasi DataTables hanya setelah tab aktif dan jika belum diinisialisasi
            if (tabId === 'dataAset' && !$.fn.DataTable.isDataTable('#tableDataAset')) {
                setTimeout(function() {
                    $('#tableDataAset').DataTable();
                }, 100);
            }
            if (tabId === 'pemeriksaan' && !$.fn.DataTable.isDataTable('#tablePemeriksaan')) {
                setTimeout(function() {
                    $('#tablePemeriksaan').DataTable();
                }, 100);
            }
            if (tabId === 'keluarMasuk' && !$.fn.DataTable.isDataTable('#tableKeluarMasuk')) {
                setTimeout(function() {
                    $('#tableKeluarMasuk').DataTable();
                }, 100);
            }
            if (tabId === 'penyusutanNilai' && !$.fn.DataTable.isDataTable('#tablePenyusutanNilai')) {
                setTimeout(function() {
                    $('#tablePenyusutanNilai').DataTable();
                }, 100);
            }

            // Ubah warna tombol tab yang aktif
            var buttons = document.querySelectorAll('.btn-group .btn');
            buttons.forEach(button => {
                button.classList.remove('btn-success'); // Hilangkan 'btn-success' dari semua tombol
                button.classList.add('btn-light'); // Tambahkan 'btn-light' ke semua tombol
            });

            // Tambahkan kelas 'btn-success' ke tombol yang aktif
            document.getElementById('tab-' + tabId).classList.add(
                'btn-success'); // Tambahkan 'btn-success' ke tombol yang dipilih
            document.getElementById('tab-' + tabId).classList.remove(
                'btn-light'); // Hilangkan 'btn-light' dari tombol yang dipilih
        }

        // Inisialisasi tab pertama atau tab pemeriksaan jika query param tab=pemeriksaan
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            const activeTab = urlParams.get('tab') || 'dataAset'; // Default tab is dataAset
            openTab(activeTab);
        }
    </script>
@endsection

@endsection
@endsection
Z
