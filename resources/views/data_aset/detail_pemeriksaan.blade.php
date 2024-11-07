@extends('main')

@section('data_barang', 'active menu-open')
@section('barang', 'menu-open')

@section('css')

@section('content')
    <style>
        .breadcrumb {
            background-color: transparent;
        }

        .nav-tabs .nav-item.show .nav-link,
        .nav-tabs .nav-link.active {
            color: #28a745;
            font-weight: bold;
        }

        .nav-tabs .nav-link {
            color: #6c757d;
        }

        .status-buttons {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .card-detail-barang .card {
            margin-bottom: 20px;
        }

        .flex-container {
            display: flex;
            gap: 20px;
        }

        .flex-container .card {
            flex: 1;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            padding: 1rem;
        }

        a.disabled {
            pointer-events: none;
            cursor: default;
        }

        #dropdownButton {
            background-color: #757575;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
        }

        #dropdownButton option {
            color: black;
            background-color: white;
            border: none;
        }

        /* Atur agar tabel dan tombol sejajar di desktop */
        .table-button-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
        }

        /* Saat tampilan mobile (maksimum lebar 768px), tombol akan bergeser ke bawah tabel */
        @media (max-width: 768px) {
            .table-button-container {
                flex-direction: column;
            }

            .btn-responsive {
                margin-top: 15px;
                /* Jarak antara tabel dan tombol di layar kecil */
                /* width: 100%; */
                /* Membuat tombol memenuhi lebar layar di perangkat mobile */
            }

            .container {
                flex-direction: column;
                align-items: center;
            }

            /* .card {
                            width: 100%;
                            max-width: 600px;
                        } */

            .card-wrapper {
                flex-direction: column;
            }

            /* CSS untuk responsif */

            .responsive-flex {
                flex-direction: column;
            }

            .responsive-card {
                width: 100% !important;
                margin-bottom: 20px !important;
            }

            .flex-container {
                flex-direction: column;
                align-items: flex-start;
                /* Jika Anda ingin tombol berada di kiri */
            }

            .btn-group {
                margin-left: 0;
                /* Sesuaikan margin sesuai kebutuhan */
                margin-top: 10px;
                /* Tambahkan margin atas untuk jarak dari tabel */
            }
        }

        .card-wrapper {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            padding: 0 15px;
        }

        /* Setelan dasar untuk card */
        .card {
            /* background-color: #fff;
                        border: 1px solid #ddd; */
            /* border-radius: 5px; */
            padding: 20px;
            margin: 10px;
            flex: 1;
            /* Flex item agar sama tinggi */
            /* min-width: 300px; */
            /* Mengatur lebar minimum card */
        }
    </style>



    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb m-0 pl-4">
                        <li class="breadcrumb-item active">
                            <a href="/{{ $role }}/dashboard">Dashboard</a> / <a
                                href="/{{ $role }}/arsip/aset/data">Data Aset</a> / <a>Detail Pemeriksaan</a>
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
    <!-- success jika berhasil menambah data -->
    <div style="margin-left: 20px; margin-right: 20px">
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
    </div>

    {{-- script untuk close --}}
    <script>
        $(document).ready(function() {
            $('.alert .close').on('click', function() {
                $(this).parent('.alert').hide();
            });
        });
    </script>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card ijo-atas">
                        <div class="card-body">
                            <div class="row card-kontrol-barang">
                                <div class="col-12">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="detail-pemeriksaan-tab" data-toggle="tab"
                                                href="#pemeriksaan" role="tab" aria-controls="pemeriksaan"
                                                onclick="openTab('detail-pemeriksaan')" aria-selected="true"
                                                style="font-size: 16px;">1. Pemeriksaan</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="status-spv-kc-tab" data-toggle="tab"
                                                href="#status-spv-kc" role="tab" aria-controls="status-spv-kc"
                                                onclick="openTab('status-spv-kc')" aria-selected="false"
                                                style="font-size: 16px;">2. Status SPV &
                                                KC</a>
                                        </li>
                                    </ul>

                                    <div class="tab-content" id="myTabContent">
                                        {{-- tab pemeriksaaan --}}
                                        <div class="tab-pane fade show active" id="pemeriksaan" role="tabpanel"
                                            aria-labelledby="detail-pemeriksaan-tab">
                                            <div class="col-12 mt-3">
                                                <div class="status-buttons">
                                                    @if ($pemeriksaanAset->status_pemeriksaan == 'selesai')
                                                        <button class="btn btn-success"
                                                            style="border-radius: 10px;font-size: 12px; padding:4px; color: white;">Selesai
                                                            Input
                                                            Pemeriksaan</button>
                                                    @else
                                                        <button class="btn btn-warning"
                                                            style="border-radius: 10px;font-size: 12px; padding:4px; color: white;">Belum
                                                            Selesai Input
                                                            Pemeriksaan</button>
                                                    @endif
                                                    @if ($pemeriksaanAset->status_spv == 'mengetahui')
                                                        <button class="btn btn-success"
                                                            style="border-radius: 10px;font-size: 12px; padding:4px; color: white;">Diteruskan
                                                            Ke SPV, SPV
                                                            Mengetahui</button>
                                                    @else
                                                        <button class="btn btn-warning"
                                                            style="border-radius: 10px;font-size: 12px; padding:4px; color: white;">Diteruskan
                                                            Ke SPV, SPV Belum
                                                            Mengetahui</button>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="flex-container">
                                                <div class="card">
                                                    <div class="table-button-container">
                                                        <!-- Tabel Pemeriksaan -->
                                                        <div>
                                                            <table id="example"
                                                                style="width: 100%; border-collapse: collapse;">
                                                                <tr>
                                                                    <th><b style="font-size: 16px;">Pemeriksa</b>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <td><b class="text-success"
                                                                            style="font-size: 19px">{{ $pemeriksaanAset->pcPengurus->pengguna->nama }}</b>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th><b style="font-size: 16px;">Jabatan</b></th>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <h6>{{ $pemeriksaanAset->pcPengurus->pengurusJabatan->jabatan }}
                                                                        </h6>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th><b style="font-size: 16px;">Tgl
                                                                            Pemeriksaan</b></th>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <h6>{{ $pemeriksaanAset->tanggal_pemeriksaan }}
                                                                        </h6>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th><b style="font-size: 16px;">Status</b></th>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        @if ($pemeriksaanAset->status_pemeriksaan == 'selesai')
                                                                            <h6 class="text-success">Selesai Diinput
                                                                            </h6>
                                                                        @else
                                                                            <h6 class="text-danger">Belum Selesai
                                                                                Diinput</h6>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>

                                                        <!-- Tombol (Dropdown dan Hapus) -->
                                                        @if (Auth::user()->gocap_id_pc_pengurus != $supervisor || Auth::user()->gocap_id_pc_pemeriksa != $kc)
                                                            <div class="btn-responsive">
                                                                {{-- Dropdown Button --}}
                                                                <div class="dropdown mb-2 mr-2">
                                                                    <form
                                                                        action="{{ route($role . '.updateStatusPemeriksaan') }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="id_pemeriksaan_aset"
                                                                            value="{{ $pemeriksaanAset->id_pemeriksaan_aset }}">
                                                                        <div class="dropdown">
                                                                            <select id="dropdownButton"
                                                                                name="status_pemeriksaan"
                                                                                onchange="this.form.submit()"
                                                                                style="border-radius: 10px; padding: 6px; margin: 0; width: 150px; font-size:12px; margin-right:5px;">
                                                                                <option value="selesai"
                                                                                    {{ $pemeriksaanAset->status_pemeriksaan == 'selesai' ? 'selected' : '' }}>
                                                                                    <i
                                                                                        class="bi bi-check-circle-fill"></i>Selesai
                                                                                    Diinput
                                                                                </option>
                                                                                <option value="belum"
                                                                                    {{ $pemeriksaanAset->status_pemeriksaan == 'belum' ? 'selected' : '' }}>
                                                                                    <i class="bi bi-ban"></i>Belum
                                                                                    Selesai Diinput
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                    </form>
                                                                </div>

                                                                {{-- Hapus Button --}}
                                                                <div
                                                                    class="btn-group btn-block mb-2 mr-2 mb-xl-0 card_hapus_barang">
                                                                    <form
                                                                        action="{{ route($role . '.delete_pemeriksaan', $pemeriksaanAset->id_pemeriksaan_aset) }}"
                                                                        method="POST"
                                                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="btn btn-danger btn-block"
                                                                            @if ($pemeriksaanAset->status_pemeriksaan == 'selesai') disabled @endif
                                                                            style="border-radius: 10px; padding: 5px; width: 150px; font-size:12px; margin-right:5px;">
                                                                            <i class="fas fa-trash"></i> Hapus
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="flex-container"
                                                        style="display: flex; align-items: center; justify-content: space-between; padding: 0;">
                                                        <table id="example"
                                                            style="width: 100%; border-collapse: collapse;">
                                                            <tr>
                                                                <th style="width: 65%">
                                                                    <b style="font-size: 16px;">Hasil Pemeriksaan
                                                                        Aset</b>
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <td style="width: 75%">
                                                                    <b class="text-success"
                                                                        style="font-size: 19px;">{{ $jumlahAset }}
                                                                        aset diperiksa</b>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <div class="btn-group btn-block mb-2 mb-xl-0 card-tambah-kontrol"
                                                            style="margin: 0 20px 0 20px">
                                                            <a href="/{{ $role }}/print-detail/{{ $pemeriksaanAset->id_pemeriksaan_aset }}/{{ $pemeriksaanAset->tanggal_pemeriksaan }}"
                                                                style="border-radius: 10px; padding: 5px; width: 150px; font-size: 12px;"
                                                                class="btn btn-success" target="_blank">
                                                                <i class="fas fa-file-alt"></i> Export
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <div style="display: flex; flex-wrap: wrap; justify-content: space-between; padding: 0 15px; margin: 0;"
                                                        class="responsive-flex">
                                                        <div style="width: 48%; margin-bottom: 20px;"
                                                            class="responsive-card" id="card1">
                                                            <b style="font-size: 16px;">Berdasarkan Kondisi</b>
                                                            <div
                                                                style="width: 100%; border: 1px solid #ddd; padding: 10px;">
                                                                <table id="example"
                                                                    style="width: 100%; border-collapse: collapse; font-size:16px;">
                                                                    <tr>
                                                                        <th style="width:60%">
                                                                            <h6>Baik</h6>
                                                                        </th>
                                                                        <th style="width:20%">
                                                                            @if ($detailPemeriksaan->isNotEmpty())
                                                                                <h6>{{ $detailPemeriksaan->where('kondisi', 'baik')->count() }}
                                                                                </h6>
                                                                            @else
                                                                                <h6 class="text-">0</h6>
                                                                            @endif
                                                                        </th>
                                                                        <th style="width:20%">
                                                                            @if ($detailPemeriksaan->isNotEmpty())
                                                                                <h6>{{ round(($detailPemeriksaan->where('kondisi', 'baik')->count() / $jumlahAset) * 100, 2) }}%
                                                                                </h6>
                                                                            @else
                                                                                <h6 class="text-">0</h6>
                                                                            @endif
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th style="width:50%">
                                                                            <h6>Tidak Memadai (rusak)</h6>
                                                                        </th>
                                                                        <th style="width:20%">
                                                                            @if ($detailPemeriksaan->isNotEmpty())
                                                                                <h6 class="text-primary">
                                                                                    {{ $detailPemeriksaan->where('kondisi', 'rusak')->count() }}
                                                                                </h6>
                                                                            @else
                                                                                <h6 class="text-primary">0</h6>
                                                                            @endif
                                                                        </th>
                                                                        <th style="width:20%">
                                                                            @if ($detailPemeriksaan->isNotEmpty())
                                                                                <h6 class="text-primary">
                                                                                    {{ round(($detailPemeriksaan->where('kondisi', 'rusak')->count() / $jumlahAset) * 100, 2) }}%
                                                                                </h6>
                                                                            @else
                                                                                <h6 class="text-primary">0</h6>
                                                                            @endif
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th style="width:50%">
                                                                            <h6>Perlu Perbaikan</h6>
                                                                        </th>
                                                                        <th style="width:20%">
                                                                            @if ($detailPemeriksaan->isNotEmpty())
                                                                                <h6 class="text-warning">
                                                                                    {{ $detailPemeriksaan->where('kondisi', 'perlu service')->count() }}
                                                                                </h6>
                                                                            @else
                                                                                <h6 class="text-warning">0</h6>
                                                                            @endif
                                                                        </th>
                                                                        <th style="width:20%">
                                                                            @if ($detailPemeriksaan->isNotEmpty())
                                                                                <h6 class="text-warning">
                                                                                    {{ round(($detailPemeriksaan->where('kondisi', 'perlu service')->count() / $jumlahAset) * 100, 2) }}%
                                                                                </h6>
                                                                            @else
                                                                                <h6 class="text-warning">0</h6>
                                                                            @endif
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th style="width:50%">
                                                                            <h6>Hilang</h6>
                                                                        </th>
                                                                        <th style="width:20%">
                                                                            @if ($detailPemeriksaan->isNotEmpty())
                                                                                <h6 class="text-danger">
                                                                                    {{ $detailPemeriksaan->where('kondisi', 'hilang')->count() }}
                                                                                </h6>
                                                                            @else
                                                                                <h6 class="text-danger">0</h6>
                                                                            @endif
                                                                        </th>
                                                                        <th style="width:20%">
                                                                            @if ($detailPemeriksaan->isNotEmpty())
                                                                                <h6 class="text-danger">
                                                                                    {{ round(($detailPemeriksaan->where('kondisi', 'hilang')->count() / $jumlahAset) * 100, 2) }}%
                                                                                </h6>
                                                                            @else
                                                                                <h6 class="text-danger">0</h6>
                                                                            @endif
                                                                        </th>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>

                                                        <div style="width: 48%; margin-bottom: 20px;"
                                                            class="responsive-card" id="card2">
                                                            <b style="font-size: 16px;">Berdasarkan Status</b>
                                                            <div
                                                                style="width: 100%; border: 1px solid #ddd; padding: 10px;">
                                                                <table id="example"
                                                                    style="width: 100%; border-collapse: collapse; font-size: 16px;">
                                                                    <tr>
                                                                        <th style="width:50%">
                                                                            <h6>Aktif</h6>
                                                                        </th>
                                                                        <th style="width:25%">
                                                                            @if ($detailPemeriksaan->isNotEmpty())
                                                                                <h6>{{ $detailPemeriksaan->where('status_aset', 'aktif')->count() }}
                                                                                </h6>
                                                                            @else
                                                                                <h6 class="text-">0</h6>
                                                                            @endif
                                                                        </th>
                                                                        <th style="width:25%">
                                                                            @if ($detailPemeriksaan->isNotEmpty())
                                                                                <h6>{{ round(($detailPemeriksaan->where('status_aset', 'aktif')->count() / $jumlahAset) * 100, 2) }}%
                                                                                </h6>
                                                                            @else
                                                                                <h6 class="text-">0</h6>
                                                                            @endif
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th style="width:50%">
                                                                            <h6>Non Aktif</h6>
                                                                        </th>
                                                                        <th style="width:25%">
                                                                            @if ($detailPemeriksaan->isNotEmpty())
                                                                                <h6 class="text-danger">
                                                                                    {{ $detailPemeriksaan->where('status_aset', 'non aktif')->count() }}
                                                                                </h6>
                                                                            @else
                                                                                <h6 class="text-danger">0</h6>
                                                                            @endif
                                                                        </th>
                                                                        <th style="width:25%">
                                                                            @if ($detailPemeriksaan->isNotEmpty())
                                                                                <h6 class="text-danger">
                                                                                    {{ round(($detailPemeriksaan->where('status_aset', 'non aktif')->count() / $jumlahAset) * 100, 2) }}%
                                                                                </h6>
                                                                            @else
                                                                                <h6 class="text-danger">0</h6>
                                                                            @endif
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th style="width:50%">
                                                                            <br>
                                                                        </th>
                                                                        <th style="width:25%">
                                                                            <br>
                                                                        </th>
                                                                        <th style="width:25%">
                                                                            <br>
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th style="width:50%">
                                                                            <br>
                                                                        </th>
                                                                        <th style="width:25%">
                                                                            <br>
                                                                        </th>
                                                                        <th style="width:25%">
                                                                            <br>
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th style="width:50%">
                                                                            <br>
                                                                        </th>
                                                                        <th style="width:25%">
                                                                            <br>
                                                                        </th>
                                                                        <th style="width:25%">
                                                                            <br>
                                                                        </th>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row card-kontrol-barang">
                                                <div class="col-12">
                                                    <div class="table-responsive">
                                                        <div
                                                            class="d-flex justify-content-between align-items-center mb-3">
                                                            <b style="font-size: 16px;">Hasil Pemeriksaan
                                                                Berdasarkan Kondisi</b>
                                                            @if (Auth::user()->gocap_id_pc_pengurus != $supervisor || Auth::user()->gocap_id_pc_pemeriksa != $kc)
                                                                <button type="button" class="btn btn-success"
                                                                    data-toggle="modal"
                                                                    data-target="#TambahPemeriksaanModal"
                                                                    @if ($pemeriksaanAset->status_pemeriksaan == 'selesai') disabled @endif
                                                                    style="border-radius: 10px; padding: 5px; margin: 0; width: 150px; font-size:12px;">
                                                                    <i class="fas fa-plus-circle"></i>
                                                                    <span>Tambah</span>
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table id="pemeriksaanTable" class="table table-bordered"
                                                            style="width:100%;">
                                                            <thead style="text-align: center; font-size:16;">
                                                                <tr>
                                                                    <th>No.</th>
                                                                    <th>Kode Aset</th>
                                                                    <th>Nama Aset</th>
                                                                    <th>Kategori</th>
                                                                    <th>Lokasi</th>
                                                                    <th>Kondisi</th>
                                                                    <th>Status</th>
                                                                    <th>Tgl Pembelian</th>
                                                                    <th>Masalah
                                                                        Teridentifikasi</th>
                                                                    <th>Tindakan Yang
                                                                        Diperlukan</th>
                                                                    <th style="width: 100px;">
                                                                        Aksi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody style="font-size: 13px;">
                                                                <tr>
                                                                    <td colspan="11" style="background-color: #CBF2D6;">
                                                                        <b style="font-size: 16px;">1. Aset
                                                                            Dengan
                                                                            Kondisi Baik
                                                                            ({{ $detailPemeriksaan->where('kondisi', 'baik')->count() ?? 0 }})</b>
                                                                    </td>
                                                                </tr>

                                                                @if (($detailPemeriksaan->where('kondisi', 'baik')->count() ?? 0) > 0)
                                                                    @php
                                                                        $no = 1;
                                                                    @endphp
                                                                    @foreach ($detailPemeriksaan as $data)
                                                                        @php
                                                                            // Mendapatkan tanggal pemeriksaan yang terkait dengan data
                                                                            $tanggal_pemeriksaan =
                                                                                $data->pemeriksaanAset
                                                                                    ->tanggal_pemeriksaan;
                                                                            // Membandingkan tanggal pemeriksaan dengan tanggal sekarang
                                                                            $canEdit = \Carbon\Carbon::parse(
                                                                                $tanggal_pemeriksaan,
                                                                            )->isToday();
                                                                        @endphp
                                                                        @if ($data->kondisi == 'baik')
                                                                            <tr>
                                                                                <td>{{ $no++ }}</td>
                                                                                <td>{{ $data->aset->kode_aset }}
                                                                                </td>
                                                                                <td>{{ $data->aset->nama_aset }}
                                                                                </td>
                                                                                <td>{{ $data->aset->kategori_aset->kategori }}
                                                                                </td>
                                                                                <td>{{ $data->aset->lokasi_penyimpanan }}
                                                                                </td>
                                                                                <td>{{ $data->kondisi }}</td>
                                                                                <td>{{ $data->status_aset }}
                                                                                </td>
                                                                                <td>{{ $data->aset->tgl_perolehan }}
                                                                                </td>
                                                                                <td>{{ $data->masalah_teridentifikasi }}
                                                                                </td>
                                                                                <td>{{ $data->tindakan_diperlukan }}
                                                                                </td>
                                                                                <td>
                                                                                    <div
                                                                                        class="d-flex flex-column align-items-center">
                                                                                        <div
                                                                                            class="btn-group mb-2 card_edit_pemeriksaan">
                                                                                            <button
                                                                                                class="btn btn-outline-secondary btn-block intro-ubah-detail-pemeriksaan edit-pemeriksaan
                                                                                                    {{-- @if (!$canEdit) disabled @endif --}}
                                                                                                    "
                                                                                                type="button"
                                                                                                data-toggle="modal"
                                                                                                data-target="#UbahPemeriksaanModal"
                                                                                                data-aset-id="{{ $data->aset_id }}"
                                                                                                data-kategori-aset="{{ $data->aset->kategori_aset->kategori }}"
                                                                                                data-lokasi-penyimpanan="{{ $data->aset->lokasi_penyimpanan }}"
                                                                                                data-tgl-perolehan="{{ $data->aset->tgl_perolehan }}"
                                                                                                data-kondisi="{{ $data->kondisi }}"
                                                                                                data-masalah-teridentifikasi="{{ $data->masalah_teridentifikasi }}"
                                                                                                data-tindakan-diperlukan="{{ $data->tindakan_diperlukan }}"
                                                                                                data-status-aset="{{ $data->status_aset }}"
                                                                                                data-id-detail="{{ $data->id_detail_pemeriksaan_aset }}"
                                                                                                @if ($pemeriksaanAset->status_pemeriksaan == 'selesai') disabled @endif
                                                                                                style="border-radius:10px; width: 100px; max-width: 100px; padding: 5px; font-size:12px;">
                                                                                                <i class="fas fa-edit"></i>
                                                                                                Ubah
                                                                                            </button>
                                                                                        </div>
                                                                                        <div
                                                                                            class="btn-group mb-2 mb-xl-0 card_hapus_detail">
                                                                                            <div
                                                                                                class="btn-group mb-2 mb-xl-0 btn-block">
                                                                                                {{-- @foreach ($detailPemeriksaan as $item) --}}
                                                                                                <form
                                                                                                    action="{{ route($role . '.delete_detail_pemeriksaan', $data->id_detail_pemeriksaan_aset) }}"
                                                                                                    method="POST"
                                                                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                                                                    @csrf
                                                                                                    @method('DELETE')
                                                                                                    <button type="submit"
                                                                                                        class="btn btn-outline-secondary btn-block
                                                                                                                "
                                                                                                        @if ($pemeriksaanAset->status_pemeriksaan == 'selesai') disabled @endif
                                                                                                        style="border-radius:10px; width: 100px; max-width: 100px; padding: 5px; margin-bottom: 10px; font-size:12px;"
                                                                                                        {{-- @if (!$canEdit) disabled @endif> --}}>
                                                                                                        <i
                                                                                                            class="fas fa-trash"></i>
                                                                                                        Hapus
                                                                                                    </button>
                                                                                                </form>
                                                                                                {{-- @endforeach --}}
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                </td>
                                                                            </tr>
                                                                        @endif
                                                                    @endforeach
                                                                @else
                                                                    <tr>
                                                                        <td colspan="11" style="text-align:center">
                                                                            Tidak ada data
                                                                        </td>
                                                                    </tr>
                                                                @endif

                                                                <tr>
                                                                    <td colspan="11" style="background-color: #CBF2D6;">
                                                                        <b style="font-size: 16px;">2. Aset
                                                                            Dengan
                                                                            Kondisi
                                                                            Tidak
                                                                            Memadai /
                                                                            Rusak
                                                                            ({{ $detailPemeriksaan->where('kondisi', 'rusak')->count() ?? 0 }})</b>
                                                                    </td>
                                                                </tr>

                                                                @if (($detailPemeriksaan->where('kondisi', 'rusak')->count() ?? 0) > 0)
                                                                    @php
                                                                        $no = 1;
                                                                    @endphp


                                                                    @foreach ($detailPemeriksaan as $data)
                                                                        @php
                                                                            // Mendapatkan tanggal pemeriksaan yang terkait dengan data
                                                                            $tanggal_pemeriksaan =
                                                                                $data->pemeriksaanAset
                                                                                    ->tanggal_pemeriksaan;
                                                                            // Membandingkan tanggal pemeriksaan dengan tanggal sekarang
                                                                            $canEdit = \Carbon\Carbon::parse(
                                                                                $tanggal_pemeriksaan,
                                                                            )->isToday();
                                                                        @endphp
                                                                        @if ($data->kondisi == 'rusak')
                                                                            <tr>
                                                                                <td>{{ $no++ }}</td>
                                                                                <td>{{ $data->aset->kode_aset }}
                                                                                </td>
                                                                                <td>{{ $data->aset->nama_aset }}
                                                                                </td>
                                                                                <td>{{ $data->aset->kategori_aset->kategori }}
                                                                                </td>
                                                                                <td>{{ $data->aset->lokasi_penyimpanan }}
                                                                                </td>
                                                                                <td>{{ $data->kondisi }}</td>
                                                                                <td>{{ $data->status_aset }}
                                                                                </td>
                                                                                <td>{{ $data->aset->tgl_perolehan }}
                                                                                </td>
                                                                                <td>{{ $data->masalah_teridentifikasi }}
                                                                                </td>
                                                                                <td>{{ $data->tindakan_diperlukan }}
                                                                                </td>
                                                                                <td>
                                                                                    <div
                                                                                        class="d-flex flex-column align-items-center">
                                                                                        <div
                                                                                            class="btn-group mb-2 card_edit_pemeriksaan">
                                                                                            <button
                                                                                                class="btn btn-outline-secondary btn-block intro-ubah-detail-pemeriksaan edit-pemeriksaan
                                                                                                        {{-- @if (!$canEdit) disabled @endif --}}
                                                                                                        "
                                                                                                type="button"
                                                                                                data-toggle="modal"
                                                                                                data-target="#UbahPemeriksaanModal"
                                                                                                data-aset-id="{{ $data->aset_id }}"
                                                                                                data-kategori-aset="{{ $data->aset->kategori_aset->kategori }}"
                                                                                                data-lokasi-penyimpanan="{{ $data->aset->lokasi_penyimpanan }}"
                                                                                                data-tgl-perolehan="{{ $data->aset->tgl_perolehan }}"
                                                                                                data-kondisi="{{ $data->kondisi }}"
                                                                                                data-masalah-teridentifikasi="{{ $data->masalah_teridentifikasi }}"
                                                                                                data-tindakan-diperlukan="{{ $data->tindakan_diperlukan }}"
                                                                                                data-status-aset="{{ $data->status_aset }}"
                                                                                                data-id-detail="{{ $data->id_detail_pemeriksaan_aset }}"
                                                                                                @if ($pemeriksaanAset->status_pemeriksaan == 'selesai') disabled @endif
                                                                                                style="border-radius:10px; width: 100px; max-width: 100px; padding: 5px; margin: 0; font-size:12px;"
                                                                                                aria-expanded="false">
                                                                                                &nbsp;&nbsp;<i
                                                                                                    class="fas fa-edit"></i>
                                                                                                Ubah
                                                                                            </button>
                                                                                        </div>
                                                                                        <div
                                                                                            class="btn-group mb-2 mb-xl-0 card_hapus_detail">
                                                                                            <div
                                                                                                class="btn-group mb-2 mb-xl-0 btn-block">
                                                                                                {{-- @foreach ($detailPemeriksaan as $item) --}}
                                                                                                <form
                                                                                                    action="{{ route($role . '.delete_detail_pemeriksaan', $data->id_detail_pemeriksaan_aset) }}"
                                                                                                    method="POST"
                                                                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                                                                    @csrf
                                                                                                    @method('DELETE')
                                                                                                    <button type="submit"
                                                                                                        class="btn btn-outline-secondary btn-block
                                                                                                                "
                                                                                                        @if ($pemeriksaanAset->status_pemeriksaan == 'selesai') disabled @endif
                                                                                                        style="border-radius:10px; width: 100px; max-width: 100px; padding: 5px; margin-bottom: 10px; font-size:12px;"
                                                                                                        {{-- @if (!$canEdit) disabled @endif> --}}>
                                                                                                        <i
                                                                                                            class="fas fa-trash"></i>
                                                                                                        Hapus
                                                                                                    </button>
                                                                                                </form>
                                                                                                {{-- @endforeach --}}
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        @endif
                                                                    @endforeach
                                                                @else
                                                                    <tr>
                                                                        <td colspan="11" style="text-align:center">
                                                                            Tidak ada data
                                                                        </td>
                                                                    </tr>
                                                                @endif

                                                                <tr>
                                                                    <td colspan="11" style="background-color: #CBF2D6;">
                                                                        <b style="font-size: 16px;">3. Aset
                                                                            Dengan
                                                                            Kondisi
                                                                            Perlu
                                                                            Perbaikan
                                                                            ({{ $detailPemeriksaan->where('kondisi', 'perlu service')->count() ?? 0 }})</b>
                                                                    </td>
                                                                </tr>


                                                                @if (($detailPemeriksaan->where('kondisi', 'perlu service')->count() ?? 0) > 0)
                                                                    @php
                                                                        $no = 1;
                                                                    @endphp

                                                                    @foreach ($detailPemeriksaan as $data)
                                                                        @php
                                                                            // Mendapatkan tanggal pemeriksaan yang terkait dengan data
                                                                            $tanggal_pemeriksaan =
                                                                                $data->pemeriksaanAset
                                                                                    ->tanggal_pemeriksaan;
                                                                            // Membandingkan tanggal pemeriksaan dengan tanggal sekarang
                                                                            $canEdit = \Carbon\Carbon::parse(
                                                                                $tanggal_pemeriksaan,
                                                                            )->isToday();
                                                                        @endphp
                                                                        @if ($data->kondisi == 'perlu service')
                                                                            <tr>
                                                                                <td>{{ $no++ }}</td>
                                                                                <td>{{ $data->aset->kode_aset }}
                                                                                </td>
                                                                                <td>{{ $data->aset->nama_aset }}
                                                                                </td>
                                                                                <td>{{ $data->aset->kategori_aset->kategori }}
                                                                                </td>
                                                                                <td>{{ $data->aset->lokasi_penyimpanan }}
                                                                                </td>
                                                                                <td>{{ $data->kondisi }}</td>
                                                                                <td>{{ $data->status_aset }}
                                                                                </td>
                                                                                <td>{{ $data->aset->tgl_perolehan }}
                                                                                </td>
                                                                                <td>{{ $data->masalah_teridentifikasi }}
                                                                                </td>
                                                                                <td>{{ $data->tindakan_diperlukan }}
                                                                                </td>
                                                                                <td>
                                                                                    <div
                                                                                        class="d-flex flex-column align-items-center">
                                                                                        <div
                                                                                            class="btn-group mb-2 card_edit_pemeriksaan">
                                                                                            <button
                                                                                                class="btn btn-outline-secondary btn-block intro-ubah-detail-pemeriksaan edit-pemeriksaan
                                                                                                    {{-- @if (!$canEdit) disabled @endif --}}
                                                                                                    "
                                                                                                type="button"
                                                                                                data-toggle="modal"
                                                                                                data-target="#UbahPemeriksaanModal"
                                                                                                data-aset-id="{{ $data->aset_id }}"
                                                                                                data-kategori-aset="{{ $data->aset->kategori_aset->kategori }}"
                                                                                                data-lokasi-penyimpanan="{{ $data->aset->lokasi_penyimpanan }}"
                                                                                                data-tgl-perolehan="{{ $data->aset->tgl_perolehan }}"
                                                                                                data-kondisi="{{ $data->kondisi }}"
                                                                                                data-masalah-teridentifikasi="{{ $data->masalah_teridentifikasi }}"
                                                                                                data-tindakan-diperlukan="{{ $data->tindakan_diperlukan }}"
                                                                                                data-status-aset="{{ $data->status_aset }}"
                                                                                                data-id-detail="{{ $data->id_detail_pemeriksaan_aset }}"
                                                                                                @if ($pemeriksaanAset->status_pemeriksaan == 'selesai') disabled @endif
                                                                                                style="border-radius:10px; width: 100px; max-width: 100px; padding: 5px; margin: 0; font-size:12px;"
                                                                                                aria-expanded="false">
                                                                                                &nbsp;&nbsp;<i
                                                                                                    class="fas fa-edit"></i>
                                                                                                Ubah
                                                                                            </button>
                                                                                        </div>
                                                                                        <div
                                                                                            class="btn-group mb-2 mb-xl-0 card_hapus_detail">
                                                                                            <div
                                                                                                class="btn-group mb-2 mb-xl-0 btn-block">
                                                                                                {{-- @foreach ($detailPemeriksaan as $item) --}}
                                                                                                <form
                                                                                                    action="{{ route($role . '.delete_detail_pemeriksaan', $data->id_detail_pemeriksaan_aset) }}"
                                                                                                    method="POST"
                                                                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                                                                    @csrf
                                                                                                    @method('DELETE')
                                                                                                    <button type="submit"
                                                                                                        class="btn btn-outline-secondary btn-block
                                                                                                                "
                                                                                                        @if ($pemeriksaanAset->status_pemeriksaan == 'selesai') disabled @endif
                                                                                                        style="border-radius:10px; width: 100px; max-width: 100px; padding: 5px; margin-bottom: 10px; font-size:12px;">
                                                                                                        {{-- @if (!$canEdit) disabled @endif> --}}
                                                                                                        <i
                                                                                                            class="fas fa-trash"></i>
                                                                                                        Hapus
                                                                                                    </button>
                                                                                                </form>
                                                                                                {{-- @endforeach --}}
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        @endif
                                                                    @endforeach
                                                                @else
                                                                    <tr>
                                                                        <td colspan="11" style="text-align:center">
                                                                            Tidak ada data
                                                                        </td>
                                                                    </tr>
                                                                @endif

                                                                <tr>
                                                                    <td colspan="11" style="background-color: #CBF2D6;">
                                                                        <b style="font-size: 16px;">4. Aset
                                                                            Dengan
                                                                            Kondisi
                                                                            Hilang
                                                                            ({{ $detailPemeriksaan->where('kondisi', 'hilang')->count() ?? 0 }})</b>
                                                                    </td>
                                                                </tr>

                                                                @if (($detailPemeriksaan->where('kondisi', 'hilang')->count() ?? 0) > 0)
                                                                    @php
                                                                        $no = 1;
                                                                    @endphp
                                                                    @foreach ($detailPemeriksaan as $data)
                                                                        @php
                                                                            // Mendapatkan tanggal pemeriksaan yang terkait dengan data
                                                                            $tanggal_pemeriksaan =
                                                                                $data->pemeriksaanAset
                                                                                    ->tanggal_pemeriksaan;
                                                                            // Membandingkan tanggal pemeriksaan dengan tanggal sekarang
                                                                            $canEdit = \Carbon\Carbon::parse(
                                                                                $tanggal_pemeriksaan,
                                                                            )->isToday();
                                                                        @endphp
                                                                        @if ($data->kondisi == 'hilang')
                                                                            <tr>
                                                                                <td>{{ $no++ }}</td>
                                                                                <td>{{ $data->aset->kode_aset }}
                                                                                </td>
                                                                                <td>{{ $data->aset->nama_aset }}
                                                                                </td>
                                                                                <td>{{ $data->aset->kategori_aset->kategori }}
                                                                                </td>
                                                                                <td>{{ $data->aset->lokasi_penyimpanan }}
                                                                                </td>
                                                                                <td>{{ $data->kondisi }}</td>
                                                                                <td>{{ $data->status_aset }}
                                                                                </td>
                                                                                <td>{{ $data->aset->tgl_perolehan }}
                                                                                </td>
                                                                                <td>{{ $data->masalah_teridentifikasi }}
                                                                                </td>
                                                                                <td>{{ $data->tindakan_diperlukan }}
                                                                                </td>
                                                                                <td>
                                                                                    <div
                                                                                        class="d-flex flex-column align-items-center">
                                                                                        <div
                                                                                            class="btn-group mb-2 card_edit_pemeriksaan">
                                                                                            <button
                                                                                                class="btn btn-outline-secondary btn-block intro-ubah-detail-pemeriksaan edit-pemeriksaan
                                                                                                {{-- @if (!$canEdit) disabled @endif --}}
                                                                                                "
                                                                                                type="button"
                                                                                                data-toggle="modal"
                                                                                                data-target="#UbahPemeriksaanModal"
                                                                                                data-aset-id="{{ $data->aset_id }}"
                                                                                                data-kategori-aset="{{ $data->aset->kategori_aset->kategori }}"
                                                                                                data-lokasi-penyimpanan="{{ $data->aset->lokasi_penyimpanan }}"
                                                                                                data-tgl-perolehan="{{ $data->aset->tgl_perolehan }}"
                                                                                                data-kondisi="{{ $data->kondisi }}"
                                                                                                data-masalah-teridentifikasi="{{ $data->masalah_teridentifikasi }}"
                                                                                                data-tindakan-diperlukan="{{ $data->tindakan_diperlukan }}"
                                                                                                data-status-aset="{{ $data->status_aset }}"
                                                                                                data-id-detail="{{ $data->id_detail_pemeriksaan_aset }}"
                                                                                                @if ($pemeriksaanAset->status_pemeriksaan == 'selesai') disabled @endif
                                                                                                style="border-radius:10px; width: 100px; max-width: 100px; padding: 5px; margin: 0; font-size:12px;"
                                                                                                aria-expanded="false">
                                                                                                &nbsp;&nbsp;<i
                                                                                                    class="fas fa-edit"></i>
                                                                                                Ubah
                                                                                            </button>
                                                                                        </div>
                                                                                        <div
                                                                                            class="btn-group mb-2 mb-xl-0 card_hapus_detail">
                                                                                            <div
                                                                                                class="btn-group mb-2 mb-xl-0 btn-block">
                                                                                                {{-- @foreach ($detailPemeriksaan as $item) --}}
                                                                                                <form
                                                                                                    action="{{ route($role . '.delete_detail_pemeriksaan', $data->id_detail_pemeriksaan_aset) }}"
                                                                                                    method="POST"
                                                                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                                                                    @csrf
                                                                                                    @method('DELETE')
                                                                                                    <button type="submit"
                                                                                                        class="btn btn-outline-secondary btn-block"
                                                                                                        @if ($pemeriksaanAset->status_pemeriksaan == 'selesai') disabled @endif
                                                                                                        style="border-radius:10px; width: 100px; max-width: 100px; padding: 5px; margin-bottom: 10px; font-size:12px;">
                                                                                                        {{-- @if (!$canEdit) disabled @endif> --}}
                                                                                                        <i
                                                                                                            class="fas fa-trash"></i>
                                                                                                        Hapus
                                                                                                    </button>
                                                                                                </form>
                                                                                                {{-- @endforeach --}}
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        @endif
                                                                    @endforeach
                                                                @else
                                                                    <tr>
                                                                        <td colspan="11" style="text-align:center">
                                                                            Tidak ada data
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- tab status spv & kc --}}
                                        <div class="tab-pane fade" id="status-spv-kc" role="tabpanel"
                                            aria-labelledby="status-spv-kc-tab">
                                            <div class="col-12 mt-3 mb-3">
                                                <div class="status-buttons">
                                                    @if ($pemeriksaanAset->status_pemeriksaan == 'selesai')
                                                        <button class="btn btn-success"
                                                            style="border-radius: 10px; font-size: 12px; padding:4px; color: white;">Selesai
                                                            Input
                                                            Pemeriksaan</button>
                                                    @else
                                                        <button class="btn btn-warning"
                                                            style="border-radius: 10px; font-size: 12px; padding:4px; color: white;">Belum
                                                            Selesai Input
                                                            Pemeriksaan</button>
                                                    @endif
                                                    @if ($pemeriksaanAset->status_spv == 'mengetahui')
                                                        <button class="btn btn-success"
                                                            style="border-radius: 10px; font-size: 12px; padding:4px; color: white;">SPV
                                                            Mengetahui</button>
                                                    @else
                                                        <button class="btn btn-warning"
                                                            style="border-radius: 10px; font-size: 12px; padding:4px; color: white;">SPV
                                                            Belum
                                                            Mengetahui</button>
                                                    @endif
                                                    @if ($pemeriksaanAset->status_kc == 'mengetahui')
                                                        <button class="btn btn-success"
                                                            style="border-radius: 10px; font-size: 12px; padding:4px; color: white;">Diteruskan
                                                            Ke KC, KC
                                                            Mengetahui</button>
                                                    @else
                                                        <button class="btn btn-warning"
                                                            style="border-radius: 10px; font-size: 12px; padding:4px; color: white;">Diteruskan
                                                            Ke KC, KC Belum
                                                            Mengetahui</button>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="flex-container">
                                                <div class="card">

                                                    {{-- detail respon --}}
                                                    <table id="example" style="width: 100%; border-collapse: collapse;">

                                                        {{-- line 1 --}}
                                                        <tr>
                                                            <th style="width: 75%;">
                                                                <b style="font-size:16px;">Supervisor</b>
                                                            </th>
                                                            <th style="width: 25%">
                                                                @if (Auth::user()->gocap_id_pc_pengurus == $supervisor)
                                                                    <div class="btn-group mb-2 card_edit_pemeriksaan">
                                                                        <button
                                                                            class="btn btn-secondary btn-block intro-respon-spv respon-spv"
                                                                            type="button" data-toggle="modal"
                                                                            data-target="#responspvModal"
                                                                            @if ($pemeriksaanAset->status_pemeriksaan == 'belum') disabled @endif
                                                                            style="border-radius:10px; width: 150px; max-width: 150px; padding: 5px; margin: 0; font-size:12px;"
                                                                            aria-expanded="false">
                                                                            &nbsp;&nbsp;<i class="fas fa-edit"></i>
                                                                            Respon
                                                                        </button>
                                                                    </div>
                                                                @endif
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <b class="text-success" style="font-size: 19px;">
                                                                    {{ $pemeriksaanAset->supervisor->pengguna->nama }}
                                                                </b>
                                                            </td>
                                                            <td></td>
                                                        </tr>

                                                        {{-- line 2 --}}
                                                        <tr>
                                                            <th style="width: 75%">
                                                                <b style="font-size:16px;">Jabatan</b>
                                                            </th>
                                                            <th style="width: 25%"></th>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                {{ $pemeriksaanAset->supervisor->pengurusJabatan->jabatan }}
                                                            </td>
                                                            <td></td>
                                                        </tr>

                                                        {{-- line 3 --}}
                                                        <tr>
                                                            <th style="width: 75%">
                                                                <b style="font-size:16px;">Tgl Respon</b>
                                                            </th>
                                                            <th style="width: 25%"></th>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                @if ($pemeriksaanAset->tgl_mengetahui_spv)
                                                                    {{ $pemeriksaanAset->tgl_mengetahui_spv }}
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                            <td></td>
                                                        </tr>

                                                        {{-- line 4 --}}
                                                        <tr>
                                                            <th style="width: 75%">
                                                                <b style="font-size:16px;">Status</b>
                                                            </th>
                                                            <th style="width: 25%"></th>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                @if ($pemeriksaanAset->status_spv == 'mengetahui')
                                                                    <text class="text-success">Mengetahui</text>
                                                                @else
                                                                    <text class="text-warning">Belum
                                                                        Mengetahui</text>
                                                                @endif
                                                            </td>
                                                            <td></td>
                                                        </tr>

                                                        {{-- line 5 --}}
                                                        <tr>
                                                            <th style="width: 75%">
                                                                <b style="font-size:16px;">Catatan SPV</b>
                                                            </th>
                                                            <th style="width: 25%"></th>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                @if ($pemeriksaanAset->catatan_spv)
                                                                    {{ $pemeriksaanAset->catatan_spv }}
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="card">
                                                    {{-- detail Pemeriksaan --}}
                                                    <table id="example" style="width: 100%; border-collapse: collapse;">

                                                        {{-- line 1 --}}
                                                        <tr>
                                                            <th style="width: 75%">
                                                                <b style="font-size:16px;">Kepala Cabang</b>
                                                            </th>
                                                            <th style="width: 25%">
                                                                @if (Auth::user()->gocap_id_pc_pengurus == $kc)
                                                                    <div class="btn-group mb-2 card_edit_pemeriksaan">
                                                                        <button {{-- @disable($pemeriksaanAset->status_pemeriksaan == 'belum') --}}
                                                                            class="btn btn-secondary btn-block intro-respon-kc respon-kc"
                                                                            type="button" data-toggle="modal"
                                                                            data-target="#responkcModal"
                                                                            @if ($pemeriksaanAset->status_pemeriksaan == 'belum' || $pemeriksaanAset->status_spv == 'belum') disabled @endif
                                                                            {{-- @if ($pemeriksaanAset->status_spv == 'belum') disabled @endif --}}
                                                                            style="border-radius:10px; width: 150px; max-width: 150px; padding: 5px; margin: 0;font-size:12px;"
                                                                            aria-expanded="false">
                                                                            &nbsp;&nbsp;<i class="fas fa-edit"></i>
                                                                            Respon
                                                                        </button>
                                                                    </div>
                                                                @endif
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <b style="font-size:19px;" class="text-success">
                                                                    {{ $pemeriksaanAset->kc->pengguna->nama }}
                                                                </b>
                                                            </td>
                                                            <td></td>
                                                        </tr>

                                                        {{-- line 2 --}}
                                                        <tr>
                                                            <th style="width: 75%">
                                                                <b style="font-size:16px;">Jabatan</b>
                                                            </th>
                                                            <th style="width: 25%"></th>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                {{ $pemeriksaanAset->kc->pengurusJabatan->jabatan }}
                                                            </td>
                                                            <td></td>
                                                        </tr>

                                                        {{-- line 3 --}}
                                                        <tr>
                                                            <th style="width: 75%">
                                                                <b style="font-size:16px;">Tgl Respon</b>
                                                            </th>
                                                            <th style="width: 25%"></th>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                @if ($pemeriksaanAset->tgl_mengetahui_kc)
                                                                    {{ $pemeriksaanAset->tgl_mengetahui_kc }}
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                            <td></td>
                                                        </tr>

                                                        {{-- line 4 --}}
                                                        <tr>
                                                            <th style="width: 75%">
                                                                <b style="font-size:16px;">Status</b>
                                                            </th>
                                                            <th style="width: 25%"></th>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                @if ($pemeriksaanAset->status_kc == 'mengetahui')
                                                                    <text class="text-success">Mengetahui</text>
                                                                @else
                                                                    <text class="text-warning">Belum</text>
                                                                @endif
                                                            </td>
                                                            <td></td>
                                                        </tr>

                                                        {{-- line 5 --}}
                                                        <tr>
                                                            <th style="width: 75%">
                                                                <b style="font-size:16px;">Catatan KC</b>
                                                            </th>
                                                            <th style="width: 25%"></th>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                @if ($pemeriksaanAset->catatan_kc)
                                                                    {{ $pemeriksaanAset->catatan_kc }}
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row card-ontrol-barang">
                                                <div class="col-12">
                                                    <div class="table-responsive">
                                                        <div
                                                            class="d-flex justify-content-between align-items-center mb-3">
                                                            <b style="font-size: 16px;">Hasil Pemeriksaan
                                                                Aset</b>
                                                            <a href="/{{ $role }}/print-detail/{{ $pemeriksaanAset->id_pemeriksaan_aset }}/{{ $pemeriksaanAset->tanggal_pemeriksaan }}"
                                                                class="btn btn-success"
                                                                style="border-radius: 10px; padding: 5px; margin: 0; width: 150px; font-size:12px;"
                                                                target="_blank">
                                                                <i class="fas fa-file-alt"
                                                                    style="margin-right: 5px;"></i>Export
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <div class="table-responsive">
                                                        <table id="statusSpvKcTable" class="table table-bordered"
                                                            style="width:100%;">
                                                            <thead style="text-align: center; font-size:16;">
                                                                <tr>
                                                                    <th>No.</th>
                                                                    <th>Kode Aset</th>
                                                                    <th>Nama Aset</th>
                                                                    <th>Kategori</th>
                                                                    <th>Lokasi</th>
                                                                    <th>Kondisi</th>
                                                                    <th>Status</th>
                                                                    <th>Tgl Pembelian</th>
                                                                    <th>Masalah
                                                                        Teridentifikasi</th>
                                                                    <th>Tindakan Yang
                                                                        Diperlukan</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody style="font-size: 13px;">
                                                                <tr>
                                                                    <td colspan="11" style="background-color: #CBF2D6;">
                                                                        <b style="font-size: 16px;">1. Aset
                                                                            Dengan
                                                                            Kondisi Baik
                                                                            ({{ $detailPemeriksaan->where('kondisi', 'baik')->count() ?? 0 }})</b>
                                                                    </td>
                                                                </tr>

                                                                @if (($detailPemeriksaan->where('kondisi', 'baik')->count() ?? 0) > 0)
                                                                    @php
                                                                        $no = 1;
                                                                    @endphp
                                                                    @foreach ($detailPemeriksaan as $data)
                                                                        @php
                                                                            // Mendapatkan tanggal pemeriksaan yang terkait dengan data
                                                                            $tanggal_pemeriksaan =
                                                                                $data->pemeriksaanAset
                                                                                    ->tanggal_pemeriksaan;
                                                                            // Membandingkan tanggal pemeriksaan dengan tanggal sekarang
                                                                            $canEdit = \Carbon\Carbon::parse(
                                                                                $tanggal_pemeriksaan,
                                                                            )->isToday();
                                                                        @endphp
                                                                        @if ($data->kondisi == 'baik')
                                                                            <tr>
                                                                                <td>{{ $no++ }}</td>
                                                                                <td>{{ $data->aset->kode_aset }}</td>
                                                                                <td>{{ $data->aset->nama_aset }}</td>
                                                                                <td>{{ $data->aset->kategori_aset->kategori }}
                                                                                </td>
                                                                                <td>{{ $data->aset->lokasi_penyimpanan }}
                                                                                </td>
                                                                                <td>{{ $data->kondisi }}</td>
                                                                                <td>{{ $data->status_aset }}</td>
                                                                                <td>{{ $data->aset->tgl_perolehan }}
                                                                                </td>
                                                                                <td>{{ $data->masalah_teridentifikasi }}
                                                                                </td>
                                                                                <td>{{ $data->tindakan_diperlukan }}
                                                                                </td>
                                                                            </tr>
                                                                        @endif
                                                                    @endforeach
                                                                @else
                                                                    <tr>
                                                                        <td colspan="11" style="text-align:center">
                                                                            Tidak ada data
                                                                        </td>
                                                                    </tr>
                                                                @endif

                                                                <tr>
                                                                    <td colspan="11" style="background-color: #CBF2D6;">
                                                                        <b style="font-size: 16px;">2. Aset
                                                                            Dengan
                                                                            Kondisi
                                                                            Tidak
                                                                            Memadai /
                                                                            Rusak
                                                                            ({{ $detailPemeriksaan->where('kondisi', 'rusak')->count() ?? 0 }})</b>
                                                                    </td>
                                                                </tr>

                                                                @if (($detailPemeriksaan->where('kondisi', 'rusak')->count() ?? 0) > 0)
                                                                    @php
                                                                        $no = 1;
                                                                    @endphp


                                                                    @foreach ($detailPemeriksaan as $data)
                                                                        @php
                                                                            // Mendapatkan tanggal pemeriksaan yang terkait dengan data
                                                                            $tanggal_pemeriksaan =
                                                                                $data->pemeriksaanAset
                                                                                    ->tanggal_pemeriksaan;
                                                                            // Membandingkan tanggal pemeriksaan dengan tanggal sekarang
                                                                            $canEdit = \Carbon\Carbon::parse(
                                                                                $tanggal_pemeriksaan,
                                                                            )->isToday();
                                                                        @endphp
                                                                        @if ($data->kondisi == 'rusak')
                                                                            <tr>
                                                                                <td>{{ $no++ }}</td>
                                                                                <td>{{ $data->aset->kode_aset }}</td>
                                                                                <td>{{ $data->aset->nama_aset }}</td>
                                                                                <td>{{ $data->aset->kategori_aset->kategori }}
                                                                                </td>
                                                                                <td>{{ $data->aset->lokasi_penyimpanan }}
                                                                                </td>
                                                                                <td>{{ $data->kondisi }}</td>
                                                                                <td>{{ $data->status_aset }}</td>
                                                                                <td>{{ $data->aset->tgl_perolehan }}
                                                                                </td>
                                                                                <td>{{ $data->masalah_teridentifikasi }}
                                                                                </td>
                                                                                <td>{{ $data->tindakan_diperlukan }}
                                                                                </td>
                                                                            </tr>
                                                                        @endif
                                                                    @endforeach
                                                                @else
                                                                    <tr>
                                                                        <td colspan="11" style="text-align:center">
                                                                            Tidak ada data
                                                                        </td>
                                                                    </tr>
                                                                @endif

                                                                <tr>
                                                                    <td colspan="11" style="background-color: #CBF2D6;">
                                                                        <b style="font-size: 16px;">3. Aset
                                                                            Dengan
                                                                            Kondisi
                                                                            Perlu
                                                                            Perbaikan
                                                                            ({{ $detailPemeriksaan->where('kondisi', 'perlu service')->count() ?? 0 }})</b>
                                                                    </td>
                                                                </tr>


                                                                @if (($detailPemeriksaan->where('kondisi', 'perlu service')->count() ?? 0) > 0)
                                                                    @php
                                                                        $no = 1;
                                                                    @endphp

                                                                    @foreach ($detailPemeriksaan as $data)
                                                                        @php
                                                                            // Mendapatkan tanggal pemeriksaan yang terkait dengan data
                                                                            $tanggal_pemeriksaan =
                                                                                $data->pemeriksaanAset
                                                                                    ->tanggal_pemeriksaan;
                                                                            // Membandingkan tanggal pemeriksaan dengan tanggal sekarang
                                                                            $canEdit = \Carbon\Carbon::parse(
                                                                                $tanggal_pemeriksaan,
                                                                            )->isToday();
                                                                        @endphp
                                                                        @if ($data->kondisi == 'perlu service')
                                                                            <tr>
                                                                                <td>{{ $no++ }}</td>
                                                                                <td>{{ $data->aset->kode_aset }}</td>
                                                                                <td>{{ $data->aset->nama_aset }}</td>
                                                                                <td>{{ $data->aset->kategori_aset->kategori }}
                                                                                </td>
                                                                                <td>{{ $data->aset->lokasi_penyimpanan }}
                                                                                </td>
                                                                                <td>{{ $data->kondisi }}</td>
                                                                                <td>{{ $data->status_aset }}</td>
                                                                                <td>{{ $data->aset->tgl_perolehan }}
                                                                                </td>
                                                                                <td>{{ $data->masalah_teridentifikasi }}
                                                                                </td>
                                                                                <td>{{ $data->tindakan_diperlukan }}
                                                                                </td>
                                                                            </tr>
                                                                        @endif
                                                                    @endforeach
                                                                @else
                                                                    <tr>
                                                                        <td colspan="11" style="text-align:center">
                                                                            Tidak ada data
                                                                        </td>
                                                                    </tr>
                                                                @endif

                                                                <tr>
                                                                    <td colspan="11" style="background-color: #CBF2D6;">
                                                                        <b style="font-size: 16px;">4. Aset
                                                                            Dengan
                                                                            Kondisi
                                                                            Hilang
                                                                            ({{ $detailPemeriksaan->where('kondisi', 'hilang')->count() ?? 0 }})</b>
                                                                    </td>
                                                                </tr>

                                                                @if (($detailPemeriksaan->where('kondisi', 'hilang')->count() ?? 0) > 0)
                                                                    @php
                                                                        $no = 1;
                                                                    @endphp
                                                                    @foreach ($detailPemeriksaan as $data)
                                                                        @php
                                                                            // Mendapatkan tanggal pemeriksaan yang terkait dengan data
                                                                            $tanggal_pemeriksaan =
                                                                                $data->pemeriksaanAset
                                                                                    ->tanggal_pemeriksaan;
                                                                            // Membandingkan tanggal pemeriksaan dengan tanggal sekarang
                                                                            $canEdit = \Carbon\Carbon::parse(
                                                                                $tanggal_pemeriksaan,
                                                                            )->isToday();
                                                                        @endphp
                                                                        @if ($data->kondisi == 'hilang')
                                                                            <tr>
                                                                                <td>{{ $no++ }}</td>
                                                                                <td>{{ $data->aset->kode_aset }}</td>
                                                                                <td>{{ $data->aset->nama_aset }}</td>
                                                                                <td>{{ $data->aset->kategori_aset->kategori }}
                                                                                </td>
                                                                                <td>{{ $data->aset->lokasi_penyimpanan }}
                                                                                </td>
                                                                                <td>{{ $data->kondisi }}</td>
                                                                                <td>{{ $data->status_aset }}</td>
                                                                                <td>{{ $data->aset->tgl_perolehan }}
                                                                                </td>
                                                                                <td>{{ $data->masalah_teridentifikasi }}
                                                                                </td>
                                                                                <td>{{ $data->tindakan_diperlukan }}
                                                                                </td>
                                                                            </tr>
                                                                        @endif
                                                                    @endforeach
                                                                @else
                                                                    <tr>
                                                                        <td colspan="11" style="text-align:center">
                                                                            Tidak ada data
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(document).on('click', '.edit-pemeriksaan', function() {
            var id_detail = $(this).data('id-detail');
            var aset_id = $(this).data('aset-id');
            var kategori_aset = $(this).data('kategori-aset');
            var lokasi_penyimpanan = $(this).data('lokasi-penyimpanan');
            var tgl_perolehan = $(this).data('tgl-perolehan');
            var kondisi = $(this).data('kondisi');
            var masalah_teridentifikasi = $(this).data('masalah-teridentifikasi');
            var tindakan_diperlukan = $(this).data('tindakan-diperlukan');
            var status_aset = $(this).data('status-aset');

            // Isi form di dalam modal dengan data yang diterima
            $('#edit_id_detail_pemeriksaan').val(id_detail); // Set value untuk select
            $('#edit_aset').val(aset_id); // Set value untuk select
            $('#edit_kategori_aset').val(kategori_aset);
            $('#edit_lokasi_penyimpanan').val(lokasi_penyimpanan);
            $('#edit_tgl_perolehan').val(tgl_perolehan);
            $('#edit_kondisi').val(kondisi);
            $('#edit_masalah_teridentifikasi').val(masalah_teridentifikasi);
            $('#edit_tindakan_diperlukan').val(tindakan_diperlukan);
            $('input[name="edit_status"][value="' + status_aset + '"]').prop('checked', true);

            // Set action URL untuk form edit
            //$('#editPemeriksaanForm').attr('action', 'pc/detail_pemeriksaan/update/' + id_detail);
        })
    </script>

    {{-- modal ubah data pemeriksaan barang --}}
    <div class="modal fade" id="UbahPemeriksaanModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Ubah Data Pemeriksaan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding: 1rem;">
                    <form id="editPemeriksaanForm" method="POST"
                        action="/{{ $role }}/detail_pemeriksaan/update/">
                        @csrf
                        <div class="form-group">
                            <input type="text" class="form-control" id="edit_id_detail_pemeriksaan"
                                name="edit_id_detail_pemeriksaan"
                                style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;" hidden>
                            <label for="nama_aset" style="font-weight: bold; font-size: 14px;">Nama Aset</label>
                            <select class="form-control" id="edit_aset" name="edit_aset"
                                onchange="toggleNewCategoryForm()" required>
                                <option value="">Pilih Aset</option>
                                @foreach ($aset as $data)
                                    <option value="{{ $data->aset_id }}">{{ $data->nama_aset }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_kategori_aset">Kategori :</label>
                            <input type="text" class="form-control" id="edit_kategori_aset"
                                style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;" readonly>
                        </div>
                        <div class="form-group">
                            <label for="edit_lokasi_penyimpanan" style="font-weight: bold; font-size: 14px;">Lokasi
                                Aset</label>
                            <input type="text" class="form-control" id="edit_lokasi_penyimpanan"
                                style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;" readonly>
                        </div>
                        <div class="form-group">
                            <label for="edit_tgl_perolehan" style="font-weight: bold; font-size: 14px;">Tgl
                                Pembelian</label>
                            <input type="date" class="form-control" id="edit_tgl_perolehan"
                                style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;" readonly>
                        </div>
                        <div class="form-group">
                            <label style="font-weight: bold; font-size: 14px;">Status</label><br>
                            <div style="display: flex; align-items: center;">
                                <input type="radio" id="edit_status_aset_aktif" name="edit_status" value="aktif"
                                    checked style="margin-right: 5px;">
                                <label for="edit_status_aset_aktif" style="margin-right: 20px;">Aktif</label>
                                <input type="radio" id="status_aset_nonaktif" name="edit_status" value="non aktif"
                                    style="margin-right: 5px;">
                                <label for="status_aset_nonaktif">Non Aktif</label>
                            </div>
                        </div>

                        <label for="kondisi">Kondisi</label>
                        <select class="form-control" id="edit_kondisi" name="edit_kondisi"
                            onchange="toggleNewCategoryForm()" required>
                            <option value="">Pilih Kondisi</option>
                            <option value="baik">Baik</option>
                            <option value="rusak">Tidak Memadai (Rusak)</option>
                            <option value="perlu service">Perlu Perbaikan</option>
                            <option value="hilang">Hilang</option>
                        </select>
                        <div class="form-group">
                            <label for="edit_masalah_teridentifikasi" style="font-weight: bold; font-size: 14px;">Masalah
                                Teridentifikasi</label>
                            <textarea class="form-control" id="edit_masalah_teridentifikasi" name="edit_masalah_teridentifikasi" rows="3"
                                style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit_tindakan_diperlukan" style="font-weight: bold; font-size: 14px;">Tindakan
                                Yang
                                Diperlukan</label>
                            <textarea class="form-control" id="edit_tindakan_diperlukan" name="edit_tindakan_diperlukan" rows="3"
                                style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success"
                            style="width: 100%; padding: 8px 0; font-weight: bold;">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- modal tambah data pemeriksaan barang --}}
    <div class="modal fade" id="TambahPemeriksaanModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Tambah Data Pemeriksaan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding: 1rem;">
                    <form method="POST"
                        action="{{ route('pc.detail_pemeriksaan.store', $pemeriksaanAset->id_pemeriksaan_aset) }}">
                        @csrf
                        <div class="form-group">
                            <label for="nama_aset" style="font-weight: bold; font-size: 14px;">Nama Aset</label>
                            <select class="form-control" id="aset" name="aset"
                                onchange="toggleNewCategoryForm()" required>
                                <option value="">Pilih Aset</option>
                                @foreach ($aset as $data)
                                    <option value="{{ $data->aset_id }}">{{ $data->nama_aset }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kategori">Kategori :</label>
                            <input type="text" class="form-control" id="kategori_aset" name="kategori_aset"
                                style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;" readonly>
                        </div>
                        <div class="form-group">
                            <label for="lokasi_aset" style="font-weight: bold; font-size: 14px;">Lokasi Aset</label>
                            <input type="text" class="form-control" id="lokasi_penyimpanan" name="lokasi_penyimpanan"
                                style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;" readonly>
                        </div>
                        <div class="form-group">
                            <label for="tgl_pembelian" style="font-weight: bold; font-size: 14px;">Tgl Pembelian</label>
                            <input type="date" class="form-control" id="tgl_perolehan" name="tgl_perolehan"
                                style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;" readonly>
                        </div>
                        <div class="form-group">
                            <label style="font-weight: bold; font-size: 14px;">Status</label><br>
                            <div style="display: flex; align-items: center;">
                                <input type="radio" id="status_aset" name="status_aset" value="aktif" checked
                                    style="margin-right: 5px;">
                                <label for="aktif" style="margin-right: 20px;">Aktif</label>
                                <input type="radio" id="status_aset" name="status_aset" value="non aktif"
                                    style="margin-right: 5px;">
                                <label for="nonaktif">Non Aktif</label>
                            </div>
                        </div>
                        <label for="kategori">Kondisi</label>
                        <select class="form-control" id="kondisi" name="kondisi" onchange="toggleNewCategoryForm()"
                            required>
                            <option value="">Pilih Kondisi</option>
                            <option value="baik">Baik</option>
                            <option value="rusak">Tidak Memadai (Rusak)</option>
                            <option value="perlu service">Perlu Perbaikan</option>
                            <option value="hilang">Hilang</option>
                        </select>
                        <div class="form-group">
                            <label for="masalah" style="font-weight: bold; font-size: 14px;">Masalah
                                Teridentifikasi</label>
                            <textarea class="form-control" id="masalah_teridentifikasi" rows="3" name="masalah_teridentifikasi"
                                style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="tindakan" style="font-weight: bold; font-size: 14px;">Tindakan Yang
                                Diperlukan</label>
                            <textarea class="form-control" id="tindakan_diperlukan" rows="3" name="tindakan_diperlukan"
                                style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success"
                            style="width: 100%; padding: 8px 0; font-weight: bold;">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{-- script untuk otomatisasi data aset pada tambah pemeriksaan --}}
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script>
        $('#aset').change(function() {
            var asetId = $(this).val(); // Mendapatkan nilai id aset yang dipilih
            console.log(asetId); // Log id aset untuk memastikan onchange berfungsi
            if (asetId) {
                $.ajax({
                    url: '/pc/aset/data/' + asetId, // URL endpoint sesuai dengan route yang telah diatur
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content') // Mengambil csrf_token dari meta tag
                    },
                    success: function(data) {
                        if (data.length > 0) {
                            var aset = data[0];
                            // Mengisi field yang sesuai dengan data yang diterima dari server
                            $('#kategori_aset').val(aset.kategori_aset.kategori);
                            $('#lokasi_penyimpanan').val(aset.lokasi_penyimpanan);
                            $('#tgl_perolehan').val(aset.tgl_perolehan);
                        } else {
                            alert('Aset tidak ditemukan');
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            } else {
                // Mengosongkan field jika tidak ada aset yang dipilih
                $('#kategori_aset').val('');
                $('#lokasi_penyimpanan').val('');
                $('#tgl_perolehan').val('');
            }
        });
    </script>

    <!-- modal respon spv -->
    <div class="modal fade" id="responspvModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Respon SPV - Pemeriksaan Aset</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding-top: 0;">
                    <form id="responspvForm" method="POST"
                        action="{{ route($role . '.respon_spv.update', $pemeriksaanAset->id_pemeriksaan_aset) }}">
                        @csrf
                        <div class="form-group">
                            <label for="tgl_pemeriksaan" style="font-weight: bold; font-size: 14px;">Tgl
                                Pemeriksaan</label>
                            <input type="date" class="form-control" id="tanggal_pemeriksaan"
                                name="tanggal_pemeriksaan" value="{{ $pemeriksaanAset->tanggal_pemeriksaan }}"
                                style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;" readonly>
                        </div>
                        <div class="form-group">
                            <label for="kategori">Status SPV</label>
                            <select class="form-control" id="status_spv" name="status_spv"
                                onchange="toggleNewCategoryForm()">
                                <option value="">Pilih Status</option>
                                <option value="mengetahui" @if ($pemeriksaanAset->status_spv == 'mengetahui') selected @endif>Mengetahui
                                </option>
                                <option value="belum" @if ($pemeriksaanAset->status_spv == 'belum') selected @endif>Belum Mengetahui
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tgl_respon" style="font-weight: bold; font-size: 14px;">Tgl Respon SPV</label>
                            <input type="date" class="form-control" id="tgl_mengetahui_spv" name="tgl_mengetahui_spv"
                                style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;">
                        </div>
                        <div class="form-group">
                            <label for="catatan_spv" style="font-weight: bold; font-size: 14px;">Catatan SPV</label>
                            <input type="text" class="form-control" id="catatan_spv" name="catatan_spv"
                                style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;">
                        </div>
                        <div class="alert alert-info"
                            style="background-color: #CBF2D6; border-color: #CBF2D6; color: #155724; margin-top: 15px;">
                            <strong>INFORMASI</strong><br>Dengan klik tombol simpan, SPV mengetahui hasil pemeriksaan aset
                            dan meneruskannya ke Kepala Cabang.
                        </div>
                        <button type="submit" class="btn btn-success"
                            style="width: 100%; padding: 8px 0; font-weight: bold;">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- modal respon kc -->
    <div class="modal fade" id="responkcModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Respon KC - Pemeriksaan Aset</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding-top: 0;">
                    <form method="POST"
                        action="{{ route($role . '.respon_kc.update', $pemeriksaanAset->id_pemeriksaan_aset) }}">
                        @csrf
                        <div class="form-group">
                            <label for="tgl_pemeriksaan" style="font-weight: bold; font-size: 14px;">Tgl
                                Pemeriksaan</label>
                            <input type="date" class="form-control" id="tgl_pemeriksaan"
                                value="{{ $pemeriksaanAset->tanggal_pemeriksaan }}"
                                style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;" readonly>
                        </div>
                        <div class="form-group">
                            <label for="tgl_respon" style="font-weight: bold; font-size: 14px;">Tgl Respon SPV</label>
                            <input type="date" class="form-control" id="tgl_mengetahui_spv" name="tgl_mengetahui_spv"
                                value="{{ $pemeriksaanAset->tgl_mengetahui_spv }}"
                                style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;" readonly>
                        </div>
                        <div class="form-group">
                            <label for="catatan_spv" style="font-weight: bold; font-size: 14px;">Catatan SPV</label>
                            <input type="text" class="form-control" id="catatan_spv" name="catatan_spv"
                                value="{{ $pemeriksaanAset->catatan_spv }}"
                                style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;" readonly>
                        </div>
                        <div class="form-group">
                            <label for="kategori">Status KC</label>
                            <select class="form-control" id="status_kc" name="status_kc" required
                                onchange="toggleNewCategoryForm()">
                                <option value="">Pilih Status</option>
                                <option value="mengetahui" @if ($pemeriksaanAset->status_kc == 'mengetahui') selected @endif>Mengetahui
                                </option>
                                <option value="belum" @if ($pemeriksaanAset->status_kc == 'belum') selected @endif>Belum Mengetahui
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tgl_respon_kc" style="font-weight: bold; font-size: 14px;">Tgl Respon KC</label>
                            <input type="date" class="form-control" id="tgl_mengetahui_kc" name="tgl_mengetahui_kc"
                                style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;" required>
                        </div>
                        <div class="form-group">
                            <label for="catatan_kc" style="font-weight: bold; font-size: 14px;">Catatan KC</label>
                            <input type="text" class="form-control" id="catatan_kc" name="catatan_kc"
                                style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;" required>
                        </div>
                        <div class="alert alert-info"
                            style="background-color: #CBF2D6; border-color: #CBF2D6; color: #155724; margin-top: 15px;">
                            <strong>INFORMASI</strong><br>Dengan klik tombol simpan, KC mengetahui hasil pemeriksaan aset.
                            Hasil pemeriksaan aset dapat digunakan sebagai lampiran pengajuan internal.
                        </div>
                        <button type="submit" class="btn btn-success"
                            style="width: 100%; padding: 8px 0; font-weight: bold;">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            function initDataTables() {
                // Hancurkan DataTables yang sudah ada sebelum inisialisasi ulang
                if ($.fn.DataTable.isDataTable('#pemeriksaanTable')) {
                    $('#pemeriksaanTable').DataTable().destroy();
                }
                if ($.fn.DataTable.isDataTable('#statusSpvKcTable')) {
                    $('#statusSpvKcTable').DataTable().destroy();
                }

                // Inisialisasi ulang DataTables
                $('#pemeriksaanTable').DataTable({
                    responsive: true,
                    autoWidth: false,
                    lengthChange: true, // Mengaktifkan fitur show entries
                    searching: true, // Mengaktifkan fitur pencarian
                    pageLength: 10 // Jumlah baris default
                });

                $('#statusSpvKcTable').DataTable({
                    responsive: true,
                    autoWidth: false,
                    lengthChange: true, // Mengaktifkan fitur show entries
                    searching: true, // Mengaktifkan fitur pencarian
                    pageLength: 10 // Jumlah baris default
                });
            }

            function handleTabChange() {
                $('#myTab a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                    setTimeout(function() {
                        initDataTables(); // Inisialisasi DataTables ketika tab berubah
                    }, 300);
                });
            }

            // Inisialisasi DataTables pada halaman load
            initDataTables();
            handleTabChange();
        });



        // // $(document).ready(function() {
        // // Fungsi untuk membuka tab dan menginisialisasi DataTables
        // $(document).ready(function() {
        //     // Fungsi untuk inisialisasi DataTables
        //     function initDataTable(tableId) {
        //         if (!$.fn.DataTable.isDataTable(tableId)) {
        //             $(tableId).DataTable({
        //                 responsive: true, // Membuat tabel responsif
        //                 autoWidth: false, // Menonaktifkan auto width
        //                 lengthChange: true, // Menampilkan dropdown "Show entries"
        //                 searching: true, // Mengaktifkan fitur pencarian
        //                 paging: true, // Mengaktifkan pagination
        //                 pageLength: 10, // Default jumlah baris per halaman
        //                 language: {
        //                     search: "Cari:", // Mengubah label pencarian
        //                     lengthMenu: "Tampilkan _MENU_ entri", // Label untuk "Show entries"
        //                     paginate: {
        //                         next: "Berikutnya",
        //                         previous: "Sebelumnya"
        //                     }
        //                 }
        //             });
        //         }
        //     }

        //     // Inisialisasi DataTables untuk tabel Pemeriksaan
        //     initDataTable('#pemeriksaanTable');

        //     // Inisialisasi DataTables untuk tabel Status SPV & KC
        //     initDataTable('#statusSpvKcTable');

        //     // Fungsi untuk membuka tab dan inisialisasi DataTables
        //     function openTab(tabId) {
        //         if (tabId === 'pemeriksaan') {
        //             initDataTable('#pemeriksaanTable');
        //         } else if (tabId === 'status-spv-kc') {
        //             initDataTable('#statusSpvKcTable');
        //         }
        //     }

        //     // Inisialisasi tab pertama atau tab yang diatur oleh query parameter saat halaman dimuat
        //     window.onload = function() {
        //         const urlParams = new URLSearchParams(window.location.search);
        //         const activeTab = urlParams.get('tab') || 'pemeriksaan'; // Default tab 'pemeriksaan'
        //         openTab(activeTab); // Inisialisasi tabel untuk tab yang pertama dibuka
        //     }

        //     // Event listener untuk perubahan tab, inisialisasi DataTables ketika tab aktif berubah
        //     $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        //         var targetTabId = $(e.target).attr("href").substr(
        //         1); // Mendapatkan id tab dari href tanpa '#'
        //         openTab(targetTabId); // Panggil fungsi untuk menginisialisasi tabel pada tab yang aktif
        //     });
        // });
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

    {{-- script untuk dropdown status pemeriksaan --}}
    <script>
        function handleDropdownChange(selectElement) {
            var selectedValue = selectElement.value;
            var idPemeriksaanAset = document.getElementById("idPemeriksaanAset").value;

            $.ajax({
                url: '{{ route($role . '.updateStatusPemeriksaan') }}', // Pastikan ini sesuai dengan rute yang kamu definisikan
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id_pemeriksaan_aset: idPemeriksaanAset,
                    status_pemeriksaan: selectedValue
                },
                success: function(response) {
                    alert(response.message);
                },
                error: function(xhr) {
                    console.log(xhr.responseText); // Tampilkan respons error dari server
                    alert('Gagal mengubah status pemeriksaan');
                }
            });
        }
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


@endsection
@endsection
@endsection
