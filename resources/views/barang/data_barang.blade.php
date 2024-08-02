@extends('main')


@section('data_barang', 'active menu-open')
@section('barang', 'menu-open')

@section('css')
@section('content')

    <style>
        .tab-content {
            display: none;
            /* Sembunyikan semua konten tab */
        }

        .tab-content.active {
            display: block;
            /* Tampilkan konten tab yang aktif */
        }

        .btn-group .btn {
            cursor: pointer;
        }

        .custom-input,
        .custom-text {
            height: 38px;
            /* Set tinggi yang konsisten */
            font-size: 1rem;
            /* Ukuran font yang sama */
            line-height: 1.5;
            /* Garis tengah yang seragam */
        }

        .input-group-prepend .input-group-text {
            border-radius: 0;
            /* Hilangkan border-radius untuk keseragaman */
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
                </div><!-- /.col -->
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
                                    <div class="d-flex align-items-center mb-2">
                                        <h5 class="d-flex mb-0">
                                            <b class="text-success pl-2">Data Barang<br>Logistik dan Perlengkapan</b>
                                        </h5>
                                        <div class="btn-group ml-5">
                                            <a class="btn btn-success btn-block mt-2" style="width:150px;"
                                                onclick="openTab('dataAset')">Data Aset</a>
                                            <a class="btn btn-light btn-block ml-2" style="width:150px;"
                                                onclick="openTab('pemeriksaan')">Pemeriksaan</a>
                                            <a class="btn btn-light btn-block ml-2" style="width:150px;"
                                                onclick="openTab('keluarMasuk')">Keluar Masuk</a>
                                            <a class="btn btn-light btn-block ml-2" style="width:150px;"
                                                onclick="openTab('penyusutanNilai')">Penyusutan Nilai</a>
                                        </div>

                                        <script>
                                            function openTab(tabId) {
                                                // Sembunyikan semua konten tab
                                                var contents = document.getElementsByClassName('tab-content');
                                                for (var i = 0; i < contents.length; i++) {
                                                    contents[i].classList.remove('active');
                                                }

                                                // Tampilkan konten tab yang dipilih
                                                document.getElementById(tabId).classList.add('active');

                                                // Ubah warna tombol tab yang aktif
                                                var buttons = document.querySelectorAll('.btn-group .btn');
                                                buttons.forEach(button => {
                                                    button.classList.remove('btn-success');
                                                    button.classList.add('btn-light');
                                                });

                                                // Tambahkan kelas 'btn-success' ke tombol yang aktif
                                                event.target.classList.add('btn-success');
                                                event.target.classList.remove('btn-light');
                                            }

                                            // Inisialisasi tab pertama sebagai aktif
                                            document.getElementById('dataAset').classList.add('active');
                                        </script>
                                    </div>

                                    <!-- success jika berhasil menambah data -->
                                    @if (session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                    @if (session('error'))
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                    @endif

                                    <!-- tab data aset -->
                                    <div id="dataAset" class="tab-content active" style="width: 99%; padding:10px; mt-1">
                                        <h5 class="text-success"><b>Data Aset</b></h5>

                                        <!-- Menu untuk filter -->
                                        <div
                                            style="border: 1px solid #e0e0e0; border-radius: 5px; background-color: #f9f9f9; padding: 10px; margin-bottom: 10px;">
                                            <!-- Bagian Filter dan Tombol Aksi -->
                                            <div
                                                style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                                                <div style="display: flex; align-items: center;  max-width: 100%;">
                                                    <!-- Filter Tanggal Pembelian -->
                                                    <div class="col-12 col-md-6 col-sm-12 mb-3 mt-3">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text custom-text">Tgl
                                                                    Pembelian</span>
                                                            </div>
                                                            <input type="date" id="tgl-pembelian-start"
                                                                name="tgl-pembelian-start"
                                                                class="form-control custom-input">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text custom-text">-</span>
                                                            </div>
                                                            <input type="date" id="tgl-pembelian-end"
                                                                name="tgl-pembelian-end" class="form-control custom-input">
                                                        </div>
                                                    </div>

                                                    {{-- filter kategori --}}
                                                    <div class="col-12 col-md-4 col-sm-12 mb-2 mb-xl-0 mt-2">
                                                        <div class="input-group mb-2 mr-sm-2">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">Kategori</div>
                                                            </div>

                                                            <select class="form-control " name="kategori"
                                                                onchange="javascript:this.form.submit();">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    {{-- filter status --}}
                                                    <div class="col-12 col-md-4 col-sm-12 mb-2 mb-xl-0 mt-2">
                                                        <div class="input-group mb-2 mr-sm-2">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">Status</div>
                                                            </div>

                                                            <select class="form-control " name="status"
                                                                onchange="javascript:this.form.submit();">
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <!-- Tombol Refresh -->
                                                    <div>
                                                        <button class="btn btn-outline-secondary" style="width: 100px;"><i
                                                                class="fas fa-sync-alt"></i></button>
                                                    </div>
                                                </div>

                                                <!-- Tombol Aksi -->
                                                <div
                                                    style="display: flex; flex-direction: column; align-items: center; margin-left: 0px;">
                                                    <div class="btn-group btn-block mb-2 mb-xl-0 mt-1card-tambah-barang"
                                                        style="width:150px; margin-bottom: 10px;">
                                                        <div class="btn-group mb-2 mb-xl-0 btn-block">
                                                            <button type="button" class="btn btn-success"
                                                                data-toggle="modal" data-target="#tambahModal">
                                                                <i class="fas fa-plus-circle"></i>
                                                                <span>Tambah </span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="btn-group btn-block mb-2 mb-xl-0 card-tambah-kontrol"
                                                        style="width:150px;">
                                                        <div class="btn-group mb-2 mb-xl-0 btn-block">
                                                            <a href="/{{ $role }}/print-data"
                                                                class="btn btn-outline-secondary">
                                                                <i class="fi fi-sr-file"></i>Export
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Keterangan Data -->
                                            <div class="col-12 col-md-10 col-sm-12 mb-2 mb-xl-0">
                                                <div class="d-flex flex-row bd-highlight align-items-center">
                                                    <div class="p-2 bd-highlight">
                                                        <i class="fas fa-info-circle"></i>
                                                    </div>
                                                    <div class="p-1 bd-highlight">
                                                        <span>
                                                            Data Aset PC Lazisnu Cilacap. Dapat ditambahkan oleh Staff
                                                            Logistik dan Perlengkapan.
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- script untuk filter data --}}
                                        <script>
                                            // Fungsi untuk memfilter data berdasarkan input
                                            function filterData() {
                                                var tglStart = document.getElementById('tgl-pembelian-start').value;
                                                var tglEnd = document.getElementById('tgl-pembelian-end').value;
                                                var kategori = document.getElementById('kategori').value;
                                                var status = document.getElementById('status').value;

                                                var filteredData = dataAset.filter(function(item) {
                                                    // Filter berdasarkan tanggal
                                                    var itemDate = new Date(item.tanggal);
                                                    var startDate = new Date(tglStart);
                                                    var endDate = new Date(tglEnd);
                                                    var dateCondition = (!tglStart || itemDate >= startDate) && (!tglEnd || itemDate <= endDate);

                                                    // Filter berdasarkan kategori
                                                    var kategoriCondition = kategori === 'semua' || item.kategori === kategori;

                                                    // Filter berdasarkan status
                                                    var statusCondition = status === 'semua' || item.status === status;

                                                    return dateCondition && kategoriCondition && statusCondition;
                                                });

                                                // Implementasikan logika untuk menampilkan filteredData di tabel
                                                console.log(filteredData);
                                            }

                                            // Fungsi untuk mereset filter dan menampilkan data asli
                                            function resetFilters() {
                                                document.getElementById('tgl-pembelian-start').value = '';
                                                document.getElementById('tgl-pembelian-end').value = '';
                                                document.getElementById('kategori').value = 'semua';
                                                document.getElementById('status').value = 'semua';

                                                // Tampilkan data asli tanpa filter
                                                console.log(dataAset);
                                                // Tampilkan data asli di sini
                                            }

                                            // Event listeners untuk elemen filter
                                            document.getElementById('tgl-pembelian-start').addEventListener('change', filterData);
                                            document.getElementById('tgl-pembelian-end').addEventListener('change', filterData);
                                            document.getElementById('kategori').addEventListener('change', filterData);
                                            document.getElementById('status').addEventListener('change', filterData);
                                            document.querySelector('.btn-refresh').addEventListener('click', filterData);

                                            // Event listener untuk tombol refresh
                                            document.querySelector('.btn-refresh').addEventListener('click', resetFilters);
                                        </script>

                                        <!-- Table barang -->
                                        <table id="example3" class="table table-bordered" style="width:100%;">
                                            <thead class="table-secondary">
                                                <tr>
                                                    <th>NO</th>
                                                    <th>Kode Aset</th>
                                                    <th>Nama Aset</th>
                                                    <th>Kategori</th>
                                                    <th>Lokasi Penyimpanan</th>
                                                    <th>Satuan</th>
                                                    <th>Pemeriksaan</th>
                                                    <th>Keluar Masuk</th>
                                                    <th style="width: 200px;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>pc-1</td>
                                                    <td>Laptop Asus</td>
                                                    <td>Elektronik</td>
                                                    <td>Ruang Staf</td>
                                                    <td>pcs</td>
                                                    <td>tanggal</td>
                                                    <td>tangal</td>
                                                    <td>
                                                        <div class="btn-group btn-block mb-2 mb-xl-0 card_detail_barang">
                                                            <div class="btn-group mb-2 mb-xl-0 btn-block">
                                                                <a onclick="$('#cover-spin').show(0)"
                                                                    href="/{{ $role }}/arsip/aset/detail"
                                                                    {{-- /{{ $data->id_barang }}" --}}
                                                                    class="btn btn-outline-secondary btn-block"
                                                                    style="display: block;">
                                                                    Detail Barang
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="btn-group btn-block mb-2 mb-xl-0 card_kontrol_barang">
                                                            <div class="btn-group mb-2 mb-xl-0 btn-block">
                                                                <button type="button"
                                                                    class="btn btn-outline-secondary input-kontrol"
                                                                    {{-- data-id-barang="{{ $data->id_barang }}"
                                                                    data-nama-barang="{{ $data->nama }}" --}}
                                                                    data-toggle="modal" data-target="#kontrolModal">
                                                                    <span>Input Kontrol</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="btn-group btn-block mb-2 mb-xl-0 card_keluar_masuk_barang">
                                                            <div class="btn-group mb-2 mb-xl-0 btn-block">
                                                                <button type="button" class="btn btn-outline-secondary"
                                                                    data-toggle="modal" data-target="#keluarModal"
                                                                    {{-- data-id-barang="{{ $data->id_barang }}"
                                                                    data-nama-barang="{{ $data->nama }}"> --}}>
                                                                    <span>Input Keluar Masuk</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                {{-- @foreach ($barang as $data)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td name="brg_id" hidden>{{ $data->id_barang }}</td>
                                                    <td></td>
                                                    <td name='brg_nama'>{{ $data->nama }}</td>
                                                    <td></td>
                                                    <td>{{ $data->lokasi_penyimpanan }}</td>
                                                    <td>{{ $data->satuan }}</td>
                                                    <td>
                                                        @if ($data->latestKontrolBarang)
                                                            <div>
                                                                Tgl Kontrol:
                                                                <b>{{ $data->latestKontrolBarang->tanggal_kontrol }}</b><br>
                                                                Berfungsi: {{ $data->latestKontrolBarang->berfungsi }} <br>
                                                                Kondisi: {{ $data->latestKontrolBarang->kondisi }} <br>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($data->latestKeluarMasukBarang)
                                                            <div>
                                                                Tgl Input:
                                                                <b>{{ $data->latestKeluarMasukBarang->tanggal_keluar_masuk }}</b><br>
                                                                Jml Masuk:
                                                                {{ $data->latestKeluarMasukBarang->jumlah_masuk }}<br>
                                                                Jml Keluar:
                                                                {{ $data->latestKeluarMasukBarang->jumlah_keluar }}<br>
                                                            </div>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach --}}
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- tab pemeriksaan -->
                                    <div id="pemeriksaan" class="tab-content" style="width: 99%; padding:10px; mt-1">
                                        <h5 class="text-success"><b>Pemeriksaan</b></h5>
                                        <div class="btn-group btn-block mb-2 mb-xl-3 card-tambah-kontrol"
                                            style="width:150px">
                                            <div class="btn-group mb-2 mb-xl-0 btn-block">
                                                <button type="button" class="btn btn-success" data-toggle="modal"
                                                    style="background-color: green; color: white;">
                                                    <i class="fas fa-plus-circle"></i>
                                                    <span>Tambah</span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="btn-group btn-block mb-2 mb-xl-4 card-tambah-kontrol"
                                            style="width:150px">
                                            <div class="btn-group mb-2 mb-xl-0 btn-block">
                                                <a href="/{{ $role }}/print-kontrol"
                                                    class="btn btn-outline-secondary">
                                                    <i class="fi fi-ss-print"></i>Cetak PDF</a>
                                            </div>
                                        </div>
                                        <table id="example3" class="table table-bordered" style="width:100%">
                                            <thead class="table-secondary">
                                                <tr>
                                                    <th>NO</th>
                                                    <th>Diinput Oleh</th>
                                                    <th>Tanggal Kontrol</th>
                                                    <th>Berfungsi</th>
                                                    <th>Kondisi</th>
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
                                                    <td></td>
                                                    {{-- @foreach ($barang->kontrolBarang as $data)
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>Halin Fajar Waskitho</td>
                                                    <td>{{ $data->tanggal_kontrol }}</td>
                                                    <td>{{ $data->berfungsi }}</td>
                                                    <td>{{ $data->kondisi }}</td>
                                                    <td>{{ $data->keterangan }}</td>
                                                    <td>{{ $data->status_kc }}</td>
                                                    <td>
                                                        <div class="btn-group btn-block mb-2 mb-xl-0 card_detail_barang">
                                                            <a class="btn btn-outline-secondary intro-ubah-detail-barang ml-1 mr-0"
                                                                type="button" data-toggle="modal"
                                                                data-target="#editkontrolModal" aria-expanded="false"
                                                                data-nama>
                                                                &nbsp;&nbsp;<i class="fas fa-edit"></i> Edit
                                                            </a>
                                                        </div>
                                                        <div class="btn-group btn-block mb-2 mb-xl-0 card_detail_barang">
                                                            <div class="btn-group mb-2 mb-xl-0 btn-block">
                                                                <a onclick="$('#cover-spin').show(0)"
                                                                    href="/{{ $role }}/aksi_hapus_barang"
                                                                    class="btn btn-outline-secondary btn-block"
                                                                    style="display: block;">
                                                                    <i class="fas fa-trash"></i> Hapus
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                @endforeach
                                            </tr> --}}
                                            </tbody>
                                        </table>
                                    </div>

                                    {{-- tab keluar masuk --}}
                                    <div id="keluarMasuk" class="tab-content" style="width: 99%; padding:10px; mt-1">
                                        <h5 class="text-success"><b>Keluar Masuk</b></h5>
                                        <div class="btn-group btn-block mb-2 mb-xl-3 card-tambah-kontrol"
                                            style="width:150px">
                                            <div class="btn-group mb-2 mb-xl-0 btn-block">
                                                <button type="button" class="btn btn-success" data-toggle="modal"
                                                    href="#keluarModal" style="background-color: green; color: white;">
                                                    <i class="fas fa-plus-circle"></i>
                                                    <span>Tambah</span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="btn-group btn-block mb-2 mb-xl-4 card-tambah-kontrol"
                                            style="width:150px">
                                            <div class="btn-group mb-2 mb-xl-0 btn-block">
                                                <a href="/{{ $role }}/print-keluar"
                                                    class="btn btn-outline-secondary">
                                                    <i class="fi fi-rs-print"></i>Cetak PDF</a>
                                            </div>
                                        </div>
                                        <table id="example3" class="table table-bordered" style="width:100%">
                                            <thead class="table-secondary">
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
                                                    <td></td>
                                                    {{-- @foreach ($barang->keluarMasukBarang as $data)
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>Halin Fajar Waskitho</td>
                                                        <td>{{ $data->tanggal_keluar_masuk }}</td>
                                                        <td>{{ $data->jumlah_keluar }}</td>
                                                        <td>{{ $data->jumlah_masuk }}</td>
                                                        <td>{{ $data->jumlah_sisa }}</td>
                                                        <td>{{ $data->keterangan }}</td>
                                                        <td>{{ $data->status_kc }}</td>
                                                        <td>
                                                            <div
                                                                class="btn-group btn-block mb-2 mb-xl-0 card_detail_barang">
                                                                <a class="btn btn-outline-secondary intro-ubah-detail-barang ml-1 mr-0"
                                                                    type="button" data-toggle="modal"
                                                                    data-target="#editkeluarModal" aria-expanded="false">
                                                                    &nbsp;&nbsp;<i class="fas fa-edit"></i>
                                                                    Edit
                                                                </a>
                                                            </div>
                                                            <div
                                                                class="btn-group btn-block mb-2 mb-xl-0 card_detail_barang">
                                                                <div class="btn-group mb-2 mb-xl-0 btn-block">
                                                                    <a onclick="$('#cover-spin').show(0)"
                                                                        href="/{{ $role }}/aksi_hapus_barang"
                                                                        class="btn btn-outline-secondary btn-block"
                                                                        style="display: block;">
                                                                        <i class="fas fa-trash"></i> Hapus
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    @endforeach --}}
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
    </section>

    {{-- modal tambah barang --}}
    <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Tambah Data Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="myForm" method="POST" action="{{ route('pc.aset.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="kode">Kode Aset :</label>
                            <input type="text" class="form-control" id="kode" name="kode">
                        </div>
                        <div class="form-group">
                            <label for="tgl_beli">Tgl Pembelian :</label>
                            <input type="text" class="form-control" id="tgl_beli" name="tgl_beli">
                        </div>
                        <div class="form-group">
                            <label for="name">Nama :</label>
                            <input type="text" class="form-control" id="name" name="nama">
                        </div>
                        <div class="form-group">
                            <label for="kategori">Kategori :</label>
                            <input type="text" class="form-control" id="kategori" name="kategori">
                        </div>
                        <div class="form-group">
                            <label for="satuan">Satuan :</label>
                            <input type="text" class="form-control" id="satuan" name="satuan">
                        </div>
                        <div class="form-group">
                            <label for="lokasi">Lokasi Penyimpanan :</label>
                            <input type="text" class="form-control" id="lokasi" name="lokasi_penyimpanan">
                        </div>
                        <div class="form-group">
                            <label for="status">Status :</label>
                            <input type="text" class="form-control" id="status" name="status">
                        </div>
                        <div class="form-group">
                            <label for="spesifikasi">Spesifikasi/Deskripsi :</label>
                            <input type="text" class="form-control" id="spesifikasi" name="spesifikasi">
                        </div>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- modal kontrol barang --}}
    <div class="modal fade" id="kontrolModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Kontrol Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="myForm" method="POST" action="    {{ route('pc.kontrol.store') }}">
                        <div class="form-group">
                            <label for="name">Nama :</label>
                            <input type="text" class="form-control" id="name" name="nama" disabled>
                        </div>
                        <div class="form-group">
                            <label for="id">ID :</label>
                            <input type="text" class="form-control" id="id_barang" name="id_barang" disabled>
                        </div>
                        <div class="form-group">
                            <label for="tanggal">Tanggal Kontrol :</label>
                            <input type="date" class="form-control" id="tanggal_kontrol" name="tanggal_kontrol">
                        </div>
                        <div class="form-group">
                            <label>Berfungsi :</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="berfungsiYa" name="berfungsi"
                                    value="Ya">
                                <label class="form-check-label" for="berfungsiYa">Ya</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="berfungsiTidak" name="berfungsi"
                                    value="Tidak">
                                <label class="form-check-label" for="berfungsiTidak">Tidak</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Kondisi :</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="kondisiBaik" name="kondisi"
                                    value="Baik">
                                <label class="form-check-label" for="kondisiBaik">Baik</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="kondisiRusak" name="kondisi"
                                    value="Rusak">
                                <label class="form-check-label" for="kondisiRusak">Rusak</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan :</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan">
                        </div>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{-- modal keluar masuk barang --}}
    <div class="modal fade" id="keluarModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Keluar Masuk Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="myForm">
                        <div class="form-group">
                            <label for="name">Nama :</label>
                            <input type="text" class="form-control" id="name" name="nama">
                        </div>
                        <div class="form-group">
                            <label for="name">ID :</label>
                            <input type="text" class="form-control" id="id_barang" name="id_barang">
                        </div>
                        <div class="form-group">
                            <label for="tanggal">Tanggal Input :</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal_input">
                        </div>
                        <div class="form-group">
                            <label for="totAwal">Total Awal :</label>
                            <input type="text" class="form-control" id="totAwal" name="totAwal">
                        </div>
                        <div class="form-group">
                            <label for="keluar">Keluar :</label>
                            <input type="text" class="form-control" id="keluar" name="keluar">
                        </div>
                        <div class="form-group">
                            <label for="masuk">Masuk :</label>
                            <input type="text" class="form-control" id="masuk" name="masuk">
                        </div>
                        <div class="form-group">
                            <label for="totAkhir">Total Akhir :</label>
                            <input type="text" class="form-control" id="totAkhir" name="totAkhir">
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan :</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan">
                        </div>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const kontrolButtons = document.querySelectorAll('.input-kontrol');

            kontrolButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const namaBarang = this.getAttribute('data-nama-barang');
                    const idBarang = this.getAttribute('data-id-barang');
                    document.querySelector('#kontrolModal input[name="nama"]').value = namaBarang;
                    document.querySelector('#kontrolModal input[name="id_barang"]').value =
                        idBarang;
                });
            });
        });

        document.querySelector('.btn-refresh').addEventListener('click', function() {
            // Implementasikan logika penyegaran data di sini
            console.log('Data disegarkan!');
        });

        document.querySelector('.btn-success').addEventListener('click', function() {
            // Implementasikan logika untuk menambahkan data baru
            console.log('Tambah item baru!');
        });

        document.querySelector('.btn-outline-success').addEventListener('click', function() {
            // Implementasikan logika ekspor data di sini
            console.log('Ekspor data!');
        });
    </script>

@endsection
@endsection
