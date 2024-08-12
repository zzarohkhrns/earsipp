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
            border-radius: 10px;
        }

        .input-group-prepend .input-group-text {
            border-radius: 10px;
            /* Hilangkan border-radius untuk keseragaman */
        }

        .filter-container {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-start;
            /* Align items at the start of the container */
            justify-content: space-between;
        }

        .filter-item {
            flex: 1;
            margin: 10px 15px;
            min-width: 250px;
            /* Minimum width to make filters wider */
        }

        .filter-buttons {
            display: flex;
            flex-direction: column;
            /* Stack buttons vertically */
            align-items: center;
            margin: 10px 15px;
        }

        .filter-buttons .btn {
            width: 150px;
            margin-bottom: 10px;
        }

        .info-section {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }

        .filter-date,
        .filter-kategori,
        .filter-status {
            display: flex;
            align-items: center;
        }

        /* Mengatur style tabel */
        #example {
            width: 250px;
            /* Menyesuaikan lebar tabel dengan konten */
            border-collapse: collapse;
            /* Menghapus ruang antar border */
            margin: 20px 0;
            /* Menambahkan margin atas dan bawah tabel */
        }

        /* Menghapus border pada sel tabel */
        #example td {
            border: none;
            /* Menghapus border */
            padding: 8px 12px;
            /* Menambahkan padding pada sel */
            font-size: 16px;
            /* Mengatur ukuran font */
            /* Menyelaraskan teks ke tengah */
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

                                        {{-- menu filter --}}
                                        <div
                                            style="border: 1px solid #e0e0e0; border-radius: 10px; background-color: #f9f9f9; padding: 10px; margin-bottom: 10px;">
                                            <!-- Bagian Filter dan Tombol Aksi -->
                                            <div
                                                style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                                                <div style="display: flex; align-items: center; max-width: 67%;">
                                                    <!-- Filter Tanggal Pembelian -->
                                                    <div class="col-12 col-md-6 col-sm-12 mb-3 mt-3">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend" style="border-radius: 10px;">
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

                                                    <!-- Filter Kategori -->
                                                    <div class="col-12 col-md-4 col-sm-12 mb-2 mb-xl-0 mt-2">
                                                        <div class="input-group mb-2 mr-sm-2">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">Kategori</div>
                                                            </div>
                                                            <select class="form-control" name="kategori"
                                                                onchange="javascript:this.form.submit();"
                                                                style="border-top-right-radius: 10px; border-bottom-right-radius:10px;">
                                                                <option value="">Semua</option>
                                                                @foreach ($kategori as $kat)
                                                                    <option value="{{ $kat->id_kategori }}">
                                                                        {{ $kat->kategori }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <!-- Filter Status -->
                                                    <div class="col-12 col-md-4 col-sm-12 mb-2 mb-xl-0 mt-2">
                                                        <div class="input-group mb-2 mr-sm-2">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">Status</div>
                                                            </div>
                                                            <select class="form-control" name="status"
                                                                onchange="javascript:this.form.submit();"
                                                                style="border-top-right-radius: 10px; border-bottom-right-radius:10px;">
                                                                <option value="">Semua</option>
                                                                <option value="aktif">Aktif</option>
                                                                <option value="non aktif">Non Aktif</option>

                                                            </select>
                                                        </div>
                                                    </div>

                                                    <!-- Tombol Refresh -->
                                                    <div>
                                                        <button class="btn btn-outline-secondary"
                                                            style="width: 100px; border-radius:10px;">
                                                            <i class="fas fa-sync-alt"></i>
                                                        </button>
                                                    </div>
                                                </div>

                                                <!-- Tombol Aksi -->
                                                <div
                                                    style="display: flex; flex-direction: column; align-items: center; margin-left: 0px;">
                                                    <div class="btn-group btn-block mb-2 mb-xl-0 mt-1 card-tambah-periksa"
                                                        style="width: 150px; margin-bottom: 10px;">
                                                        <div class="btn-group mb-2 mb-xl-0 btn-block">
                                                            <button type="button" class="btn btn-success"
                                                                data-toggle="modal" data-target="#tambahModal"
                                                                style="background-color:  rgb(0, 177, 0); color: white; border-radius:10px;">
                                                                <i class="fas fa-plus-circle"></i>
                                                                <span>Tambah </span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="btn-group btn-block mb-2 mb-xl-0 card-tambah-kontrol"
                                                        style="width: 150px;">
                                                        <div class="btn-group mb-2 mb-xl-0 btn-block">
                                                            <a href="/{{ $role }}/print-data"
                                                                style=" border-radius:10px;"
                                                                class="btn btn-outline-secondary">
                                                                <i class="fas fa-file-alt"
                                                                    style="margin-right:2px;"></i>Export
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
                                                            Data Aset PC Lazisnu Cilacap. Dapat ditambahkan oleh
                                                            Staff
                                                            Logistik dan Perlengkapan.
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Table barang -->
                                        <table id="example3" class="table table-bordered" style="width:100%;">
                                            <thead class="table-secondary" style="text-align: center">
                                                <tr>
                                                    <th>NO</th>
                                                    <th>Kode Aset</th>
                                                    <th>Nama Aset</th>
                                                    <th>Kategori</th>
                                                    <th>Lokasi Penyimpanan</th>
                                                    <th>Satuan</th>
                                                    <th>Pemeriksaan</th>
                                                    <th>Keluar Masuk</th>
                                                    <th style="width: 150px;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($aset as $data)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>
                                                            <table id="example3"
                                                                style="width:100%; border:none; border-collapse: collapse; font-size: 14px;">
                                                                <tr>
                                                                    <td style="border: none; padding: 4px;">
                                                                        <b>{{ $data->kode_aset }}</b>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="border: none; padding: 4px;">
                                                                        Tgl Pembelian
                                                                    </td>
                                                                    <td style="border: none; padding: 4px;">
                                                                        <b>{{ $data->tgl_perolehan ?? 'data tidak tersedia' }}</b>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                // Ambil status dari data, default ke 'null' jika tidak ada
                                                                $status = $data->latestDetailPemeriksaanAset->status_aset ?? 'null';

                                                                // Tentukan warna tombol dan teks berdasarkan status
                                                                if ($status === 'null') {
                                                                    $warnaTombol = 'background-color: #a9a9a9; border-color: #a9a9a9;'; // Abu-abu untuk data tidak tersedia
                                                                    $teksTombol = 'Data tidak tersedia';
                                                                } else {
                                                                    $warnaTombol = $status === 'aktif' ? 'background-color: #55CE71; border-color: #55CE71;' : 'background-color: rgb(255, 18, 18); border-color: rgb(255, 18, 18);';
                                                                    $teksTombol = $status === 'aktif' ? 'Aktif' : 'Non Aktif';
                                                                }

                                                                // HTML untuk tombol
                                                                $konten = "<button type='button' class='btn' style='border-radius: 10px; $warnaTombol; color:white; padding: 4px 8px; font-size: 14px;'>$teksTombol</button>";
                                                                ?>
                                                                <tr>
                                                                    <td style="border: none; padding: 4px;">
                                                                        <?= $konten ?>
                                                                    </td>
                                                                </tr>

                                                            </table>
                                                        </td>
                                                        <td>{{ $data->nama_aset }}</td>
                                                        <td>{{ $data->kategori_aset->kategori ?? 'Tidak Ada Kategori' }}
                                                        </td>
                                                        <td>{{ $data->lokasi_penyimpanan }}</td>
                                                        <td>{{ $data->satuan }}</td>
                                                        <td>
                                                            <table id="example3"
                                                                style="width:100%; border:none; border-collapse: collapse;">
                                                                <tr>
                                                                    <td style="border: none; padding: 8px;">
                                                                        Tgl Pemeriksaan
                                                                    </td>
                                                                    <td
                                                                        style="border: none; padding: 8px; text-align: right;">
                                                                        <b> {{ $data->latestDetailPemeriksaanAset->pemeriksaanAset->tanggal_pemeriksaan ?? 'data tidak tersedia' }}
                                                                        </b>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="border: none; padding: 8px;">
                                                                        Kondisi</td>
                                                                    <td
                                                                        style="text-align: right; border: none; padding: 8px; color:{{ $data->latestDetailPemeriksaanAset
                                                                            ? ($data->latestDetailPemeriksaanAset->kondisi == 'baik'
                                                                                ? '#55CE71'
                                                                                : ($data->latestDetailPemeriksaanAset->kondisi == 'rusak'
                                                                                    ? 'rgb(255, 18, 18)'
                                                                                    : 'inherit'))
                                                                            : 'inherit' }}">
                                                                        {{ $data->latestDetailPemeriksaanAset->kondisi ?? 'data tidak tersedia' }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="border: none; padding: 8px;">
                                                                        Status</td>
                                                                    <td
                                                                        style="border: none; padding: 8px; text-align: right;color:{{ $data->latestDetailPemeriksaanAset
                                                                            ? ($data->latestDetailPemeriksaanAset->status_aset == 'aktif'
                                                                                ? '#55CE71'
                                                                                : ($data->latestDetailPemeriksaanAset->status_aset == 'non aktif'
                                                                                    ? 'rgb(255, 18, 18)'
                                                                                    : 'inherit'))
                                                                            : 'inherit' }}">
                                                                        {{ $data->latestDetailPemeriksaanAset->status_aset ?? 'data tidak tersedia' }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="border: none; padding: 8px;">
                                                                        Keterangan</td>
                                                                    <td
                                                                        style="border: none; padding: 8px; text-align: right;">
                                                                        {{ $data->latestDetailPemeriksaanAset->keterangan ?? 'data tidak tersedia' }}
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td>
                                                            <table id="example3"
                                                                style="width:100%; border:none; border-collapse: collapse;">
                                                                <tr>
                                                                    <td style="border: none; padding: 8px;">
                                                                        Tgl Input</td>
                                                                    <td style="border: none; padding: 8px;">
                                                                        <b>Tgl
                                                                            Input</b>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="border: none; padding: 8px;">
                                                                        Jml Masuk</td>
                                                                    <td style="border: none; padding: 8px;"
                                                                        class="text-success">
                                                                        Jml Masuk</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="border: none; padding: 8px;">
                                                                        Jml Keluar</td>
                                                                    <td style="border: none; padding: 8px;"
                                                                        class="text-warning">
                                                                        Jml Keluar</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="border: none; padding: 8px;">
                                                                        Sisa</td>
                                                                    <td style="border: none; padding: 8px;">
                                                                        Sisa</td>
                                                                </tr>
                                                            </table>
                                                        </td>

                                                        <td>
                                                            <div
                                                                class="btn-group btn-block mb-2 mb-xl-0 card_detail_barang">
                                                                <div class="btn-group mb-2 mb-xl-0 btn-block">
                                                                    <a onclick="$('#cover-spin').show(0)"
                                                                        href="/{{ $role }}/arsip/aset/detail/{{ $data->aset_id }}"
                                                                        {{-- /{{ $data->id_barang }}" --}}
                                                                        class="btn btn-outline-secondary btn-block"
                                                                        style="display: block;border-radius:10px;">
                                                                        Detail Aset
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- tab pemeriksaan -->
                                    <div id="pemeriksaan" class="tab-content" style="width: 99%; padding:10px; mt-1">

                                        <!-- Menu untuk filter -->
                                        <div
                                            style="border: 1px solid #e0e0e0; border-radius: 10px; background-color: #f9f9f9; padding: 10px; margin-bottom: 10px;">
                                            <!-- Bagian Filter dan Tombol Aksi -->
                                            <div
                                                style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                                                <div style="display: flex; align-items: center; max-width: 67%;">
                                                    <!-- Filter Tanggal Pembelian -->
                                                    <div class="col-12 col-md-6 col-sm-12 mb-3 mt-3">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend" style="border-radius: 10px;">
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
                                                                name="tgl-pembelian-end"
                                                                class="form-control custom-input">
                                                        </div>
                                                    </div>

                                                    <!-- Filter Kategori -->
                                                    <div class="col-12 col-md-4 col-sm-12 mb-2 mb-xl-0 mt-2">
                                                        <div class="input-group mb-2 mr-sm-2">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">Status SPV</div>
                                                            </div>
                                                            <select class="form-control" name="kategori"
                                                                onchange="javascript:this.form.submit();"
                                                                style="border-top-right-radius: 10px; border-bottom-right-radius:10px;">
                                                                <option value="">Semua</option>
                                                                <option value="mengetahui">Mengetahui</option>
                                                                <option value="belum mengetahui">Belum Mengetahui</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <!-- Filter Status -->
                                                    <div class="col-12 col-md-4 col-sm-12 mb-2 mb-xl-0 mt-2">
                                                        <div class="input-group mb-2 mr-sm-2">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">Status KC</div>
                                                            </div>
                                                            <select class="form-control" name="status"
                                                                onchange="javascript:this.form.submit();"
                                                                style="border-top-right-radius: 10px; border-bottom-right-radius:10px;">
                                                                <option value="">Semua</option>
                                                                <option value="mengetahui">Mengetahui</option>
                                                                <option value="belum mengetahui">Belum Mengetahui</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <!-- Tombol Refresh -->
                                                    <div>
                                                        <button class="btn btn-outline-secondary"
                                                            style="width: 100px; border-radius:10px;">
                                                            <i class="fas fa-sync-alt"></i>
                                                        </button>
                                                    </div>
                                                </div>

                                                <!-- Tombol Aksi -->
                                                <div
                                                    style="display: flex; flex-direction: column; align-items: center; margin-left: 0px;">
                                                    <div class="btn-group btn-block mb-2 mb-xl-0 mt-1 card-tambah-periksa"
                                                        style="width: 150px; margin-bottom: 10px;">
                                                        <div class="btn-group mb-2 mb-xl-0 btn-block">
                                                            <button type="button" class="btn btn-success"
                                                                data-toggle="modal" data-target="#pemeriksaanModal"
                                                                style="background-color:  rgb(0, 177, 0); color: white; border-radius:10px;">
                                                                <i class="fas fa-plus-circle"></i>
                                                                <span>Tambah </span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="btn-group btn-block mb-2 mb-xl-0 card-tambah-kontrol"
                                                        style="width: 150px;">
                                                        <div class="btn-group mb-2 mb-xl-0 btn-block">
                                                            <a href="/{{ $role }}/print-data"
                                                                style=" border-radius:10px;"
                                                                class="btn btn-outline-secondary">
                                                                <i class="fas fa-file-alt"
                                                                    style="margin-right:2px;"></i>Export
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
                                                            Data Aset PC Lazisnu Cilacap. Dapat ditambahkan oleh
                                                            Staff
                                                            Logistik dan Perlengkapan.
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- tabel pemeriksaan --}}
                                        <table id="example3" class="table table-bordered" style="width:100%">
                                            <thead class="table-secondary">
                                                <tr>
                                                    <th>NO</th>
                                                    <th>Tgl Pemeriksaan</th>
                                                    <th>Pemeriksa</th>
                                                    <th>Aset Diperiksa</th>
                                                    <th>Berdasarkan Kondisi</th>
                                                    <th>Berdasarkan Status</th>
                                                    <th>Status SPV</th>
                                                    <th>Status KC</th>
                                                    <th style="width: 150px;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $no = 1;
                                                @endphp
                                                @foreach ($pemeriksaanGrouped as $groupKey => $details)
                                                    @php
                                                        // Memisahkan nama pemeriksa dan tanggal pemeriksaan
                                                        [$namaPemeriksa, $tanggalPemeriksaan] = explode('-', $groupKey);
                                                    @endphp
                                                    @foreach ($details as $key => $detail)
                                                        <tr>
                                                            @if ($key == 0)
                                                                <td>{{ $no++ }}</td>
                                                                <td>{{ $detail->tanggal_pemeriksaan }}</td>
                                                                <td><b>
                                                                        {{ $namaPemeriksa }}
                                                                    </b>
                                                                    <br>
                                                                    {{ $detail->pcPengurus->pengurusJabatan->jabatan }}
                                                                </td>
                                                                <td>
                                                                    @if ($detail->detailPemeriksaanAset->isNotEmpty())
                                                                        {{ $totalDetailPemeriksaan = $detail->detailPemeriksaanAset->count() }}
                                                                        Aset
                                                                    @else
                                                                        -
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($detail->detailPemeriksaanAset->isNotEmpty())
                                                                        <div>
                                                                            <table id="example">
                                                                                <tr>
                                                                                    <td>baik</td>
                                                                                    <td>{{ $baikCount = $detail->detailPemeriksaanAset->where('kondisi', 'baik')->count() }}
                                                                                    </td>
                                                                                    <td>{{ $totalDetailPemeriksaan > 0 ? round(($baikCount / $totalDetailPemeriksaan) * 100, 2) : 0 }}%
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>rusak</td>
                                                                                    <td class="text-primary">
                                                                                        {{ $rusakCount = $detail->detailPemeriksaanAset->where('kondisi', 'rusak')->count() }}
                                                                                    </td>
                                                                                    <td class="text-primary">
                                                                                        {{ $totalDetailPemeriksaan > 0 ? round(($rusakCount / $totalDetailPemeriksaan) * 100, 2) : 0 }}%
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>perlu perbaikan</td>
                                                                                    <td class="text-warning">
                                                                                        {{ $serviceCount = $detail->detailPemeriksaanAset->where('kondisi', 'perlu service')->count() }}
                                                                                    </td>
                                                                                    <td class="text-warning">
                                                                                        {{ $totalDetailPemeriksaan > 0 ? round(($serviceCount / $totalDetailPemeriksaan) * 100, 2) : 0 }}%
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>hilang</td>
                                                                                    <td class="text-danger">
                                                                                        {{ $hilangCount = $detail->detailPemeriksaanAset->where('kondisi', 'hilang')->count() }}
                                                                                    </td>
                                                                                    <td class="text-danger">
                                                                                        {{ $totalDetailPemeriksaan > 0 ? round(($hilangCount / $totalDetailPemeriksaan) * 100, 2) : 0 }}%
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                    @else
                                                                        -
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if ($detail->detailPemeriksaanAset->isNotEmpty())
                                                                        <div>
                                                                            <table id="example">
                                                                                <tr>
                                                                                    <td>Aktif</td>
                                                                                    <td class="text-success">
                                                                                        {{ $aktifCount = $detail->detailPemeriksaanAset->where('status_aset', 'aktif')->count() }}
                                                                                    </td>
                                                                                    <td class="text-success">
                                                                                        {{ $totalDetailPemeriksaan > 0 ? round(($aktifCount / $totalDetailPemeriksaan) * 100, 2) : 0 }}%
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Non Aktif</td>
                                                                                    <td class="text-danger">
                                                                                        {{ $nonAktifCount = $detail->detailPemeriksaanAset->where('status_aset', 'non aktif')->count() }}
                                                                                    </td>
                                                                                    <td class="text-danger">
                                                                                        {{ $totalDetailPemeriksaan > 0 ? round(($nonAktifCount / $totalDetailPemeriksaan) * 100, 2) : 0 }}%
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                    @else
                                                                        -
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <div>
                                                                        @if ($detail->status_spv == 'mengetahui')
                                                                            <div class="text-success">Mengetahui</div>
                                                                        @else
                                                                            <div class="text-danger">Belum Mengetahui</div>
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
                                                                            <div class="text-danger">Belum Mengetahui</div>
                                                                        @endif
                                                                        <div><b>{{ $detail->kc->pengguna->nama }}</b></div>
                                                                        <div>{{ $detail->kc->pengurusJabatan->jabatan }}
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div
                                                                        class="btn-group btn-block mb-2 mb-xl-0 card_detail_barang">
                                                                        <div class="btn-group mb-2 mb-xl-0 btn-block">
                                                                            <a onclick="$('#cover-spin').show(0)"
                                                                                href="/{{ $role }}/arsip/aset/detail_pemeriksaan/{{ $detail->id_pemeriksaan_aset }}/{{ $detail->tanggal_pemeriksaan }}"
                                                                                class="btn btn-outline-secondary btn-block"
                                                                                style="display: block;border-radius:10px;">
                                                                                Detail
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="btn-group btn-block mb-2 mb-xl-0 card-tambah-kontrol"
                                                                        style="width: 150px;">
                                                                        <div class="btn-group mb-2 mb-xl-0 btn-block">
                                                                            <a href="/{{ $role }}/print-pemeriksaan-byid"
                                                                                style="border-radius:10px;"
                                                                                class="btn btn-outline-secondary">
                                                                                <i class="fi fi-sr-file"></i>Cetak PDF </a>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                        </table>
                                    </div>

                                    {{-- tab keluar masuk --}}
                                    <div id="keluarMasuk" class="tab-content" style="width: 99%; padding:10px; mt-1">
                                        <h5 class="text-success"><b>Keluar Masuk</b></h5>
                                        <div class="btn-group btn-block mb-2 mb-xl-3 card-tambah-kontrol"
                                            style="width:150px">
                                            <div class="btn-group mb-2 mb-xl-0 btn-block">
                                                <button type="button" class="btn btn-success" data-toggle="modal"
                                                    href="#keluarModal"
                                                    style="background-color: rgb(0, 177, 0); color: white;">
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
                            <input type="text" class="form-control" id="kode_aset" name="kode_aset" readonly>
                        </div>
                        <div class="form-group">
                            <label for="tgl_beli">Tgl Perolehan :</label>
                            <input type="date" class="form-control" id="tgl_beli" name="tgl_perolehan">
                        </div>
                        <div class="form-group">
                            <label for="asal">Asal Perolehan :</label>
                            <input type="text" class="form-control" id="asal" name="asal">
                        </div>
                        <div class="form-group">
                            <label for="name">Nama :</label>
                            <input type="text" class="form-control" id="name" name="nama_aset">
                        </div>
                        <div class="form-group">
                            <label for="kategori">Kategori :</label>
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
                            <label for="satuan">Satuan :</label>
                            <input type="text" class="form-control" id="satuan" name="satuan">
                        </div>
                        <div class="form-group">
                            <label for="lokasi">Lokasi Penyimpanan :</label>
                            <input type="text" class="form-control" id="lokasi" name="lokasi_penyimpanan">
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

    {{-- script menambah kode aset --}}
    <script>
        $(document).ready(function() {
            $('#tambahModal').on('show.bs.modal', function() {
                $.ajax({
                    url: "{{ route('pc.aset.nextKodeAset') }}",
                    method: 'GET',
                    success: function(data) {
                        console.log(data);
                        $('#kode_aset').val(data.kode_aset);
                    },
                    error: function() {
                        alert('Gagal mendapatkan kode aset baru');
                    }
                })
            })
        })
    </script>

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
                    <form id="myForm" method="POST" action="{{ route('pc.pemeriksaan.store') }}">
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
                            <div class="modal-footer" style="border-top: none; padding-top: 0;">
                                <button type="submit" class="btn btn-success">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


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
@endsection

@endsection
@endsection
