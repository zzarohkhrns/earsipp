@extends('main')

@section('detail_barang', 'active menu-open')
@section('barang', 'menu-open')

@section('css')
@endsection

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

        .dropdown {
            position: relative;
            display: block;
        }

        .dropdown-menu {
            color: black display: none;
            position: absolute;
            background-color: #ffffff;
            /* Warna sekunder */
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-menu button {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            width: 100%;
            border: none;
            background: none;
            text-align: left;
        }

        .dropdown-menu button:hover {
            background-color: #d6d6d6;
            /* Warna saat hover */
        }

        .dropdown-button {
            display: block;
            gap: 10px;
            margin-bottom: 20px;
            justify-content: space-between;
            align-items: center;
            background-color: #6c757d;
            /* Warna sekunder */
            color: white;
            border: none;
            width: 200px;
        }

        .dropdown-button:hover {
            background-color: #5a6268;
            /* Warna saat hover */
        }

        .dropdown-button .icon {
            color: white;
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

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card ijo-kiri">
                        <div class="card-body">
                            <div class="row card-detail-barang">
                                <div class="col-12">
                                    <div class="row card-kontrol-barang">
                                        <div class="col-12">
                                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="pemeriksaan-tab" data-toggle="tab"
                                                        href="#pemeriksaan" role="tab" aria-controls="pemeriksaan"
                                                        aria-selected="true">1. Pemeriksaan</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="status-spv-kc-tab" data-toggle="tab"
                                                        href="#status-spv-kc" role="tab" aria-controls="status-spv-kc"
                                                        aria-selected="false">2. Status SPV & KC</a>
                                                </li>
                                            </ul>

                                            <div class="tab-content" id="myTabContent">

                                                {{-- tab pemeriksaaan --}}
                                                <div class="tab-pane fade show active" id="pemeriksaan" role="tabpanel"
                                                    aria-labelledby="pemeriksaan-tab">
                                                    <div class="col-12 mt-3 mb-3">
                                                        <div class="status-buttons">
                                                            <button class="btn btn-success"
                                                                style="border-radius: 10px">Selesai Input
                                                                Pemeriksaan</button>
                                                            <button class="btn btn-warning"
                                                                style="border-radius: 10px">Diteruskan Ke SPV, SPV Belum
                                                                Mengetahui</button>
                                                        </div>
                                                    </div>
                                                    <div class="flex-container">
                                                        <div class="card">

                                                            {{-- detail Pemeriksaan --}}
                                                            <table id="example"
                                                                style="width: 100%; border-collapse: collapse;">

                                                                {{-- line 1 --}}
                                                                <tr>
                                                                    <th style="width: 50%">
                                                                        <h6><b>Pemeriksa</b></h6>
                                                                    </th>
                                                                    <th style="width: 50%">
                                                                        <div class="dropdown">
                                                                            <button id="dropdownButton"
                                                                                class="dropdown-button"
                                                                                style="border-radius:10px; width: 100%; max-width: 100%; padding: 10px; margin: 0;"
                                                                                onclick="toggleDropdown()">
                                                                                <span id="buttonText">Belum Selesai
                                                                                    Diinput</span>
                                                                                <i class="fas fa-chevron-down icon"></i>
                                                                            </button>
                                                                            <div id="myDropdown" class="dropdown-menu">
                                                                                <button
                                                                                    onclick="handleSelection('Selesai Diinput')">Selesai
                                                                                    Diinput</button>
                                                                                <button
                                                                                    onclick="handleSelection('Belum Selesai Diinput')">Belum
                                                                                    Selesai Diinput</button>
                                                                            </div>
                                                                        </div>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <h5 class="text-success">
                                                                            <b>{{ $detailPemeriksaan->pemeriksaanAset->pcPengurus->pengguna->nama }}</b>
                                                                        </h5>
                                                                    </td>
                                                                    <td></td>
                                                                </tr>

                                                                {{-- line 2 --}}
                                                                <tr>
                                                                    <th style="width: 75%">
                                                                        <h6><b>Jabatan</b></h6>
                                                                    </th>
                                                                    <th style="width: 25%"></th>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <h6>{{ $detailPemeriksaan->pemeriksaanAset->pcPengurus->pengurusJabatan->jabatan }}
                                                                        </h6>
                                                                    </td>
                                                                    <td></td>
                                                                </tr>

                                                                {{-- line 3 --}}
                                                                <tr>
                                                                    <th style="width: 75%">
                                                                        <h6><b>Tgl Pemeriksaan</b></h6>
                                                                    </th>
                                                                    <th style="width: 25%"></th>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <h6>{{ $detailPemeriksaan->pemeriksaanAset->tanggal_pemeriksaan }}
                                                                        </h6>
                                                                    </td>
                                                                    <td></td>
                                                                </tr>

                                                                {{-- line 4 --}}
                                                                <tr>
                                                                    <th style="width: 75%">
                                                                        <h6><b>Status</b></h6>
                                                                    </th>
                                                                    <th style="width: 25%"></th>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        @if ($detailPemeriksaan->pemeriksaanAset->status_pemeriksaan == 'selesai')
                                                                            <h6 class="text-success"> Selesai Diinput </h6>
                                                                        @else
                                                                            <h6 class="text-danger">Belum Selesai Diinput
                                                                            </h6>
                                                                        @endif
                                                                    </td>
                                                                    <td></td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <div class="card">
                                                            <table id="example"
                                                                style="width: 100%; border-collapse: collapse;">
                                                                <tr>
                                                                    <th style="width: 75%">
                                                                        <h6><b>Hasil Pemeriksaan Aset</b></h6>
                                                                    </th>
                                                                    <th style="width: 25%">
                                                                        <div class="btn-group btn-block mb-2 mb-xl-0 card-tambah-kontrol"
                                                                            style="width: 100%;">
                                                                            <div class="btn-group mb-2 mb-xl-0 btn-block">
                                                                                <a href="/{{ $role }}/print-data"
                                                                                    style="border-radius:10px;"
                                                                                    class="btn btn-success">
                                                                                    <i class="fas fa-file-alt"></i> Export
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width: 75%">
                                                                        <h5 class="text-success"><b>{{ $jumlahAset }} aset
                                                                                diperiksa</b>
                                                                        </h5>
                                                                    </td>
                                                                    <td style="width: 25%"></td>
                                                                </tr>
                                                            </table>
                                                            <table id="example"
                                                                style="width: 100%; border-collapse: collapse;">
                                                                <tr>
                                                                    <th style="width: 60%">
                                                                        <h6><b>Berdasarkan Kondisi</b></h6>
                                                                    </th>
                                                                    <th style="width: 40%">
                                                                        <h6><b>Berdasarkan Status</b></h6>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <div class="card" style="width: 97%">
                                                                            <table id="example"
                                                                                style="width: 100%; border-collapse: collapse;">
                                                                                <tr>
                                                                                    <th style="width:60%">
                                                                                        <h6>Baik</h6>
                                                                                    </th>
                                                                                    <th style="width:20%">
                                                                                        <h6>{{ $pemeriksaan->where('kondisi', 'baik')->count() }}
                                                                                        </h6>
                                                                                    </th>
                                                                                    <th style="width:20%">
                                                                                        <h6>
                                                                                            {{ ($pemeriksaan->where('kondisi', 'baik')->count() / $jumlahAset) * 100 }}%
                                                                                        </h6>
                                                                                    </th>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th style="width:50%">
                                                                                        <h6>Tidak Memadai (rusak)</h6>
                                                                                    </th>
                                                                                    <th style="width:25%">
                                                                                        <h6 class="text-primary">
                                                                                            {{ $pemeriksaan->where('kondisi', 'rusak')->count() }}
                                                                                        </h6>
                                                                                    </th>
                                                                                    <th style="width:25%">
                                                                                        <h6 class="text-primary">
                                                                                            {{ ($pemeriksaan->where('kondisi', 'rusak')->count() / $jumlahAset) * 100 }}%
                                                                                        </h6>
                                                                                    </th>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th style="width:50%">
                                                                                        <h6>Perlu Perbaikan</h6>
                                                                                    </th>
                                                                                    <th style="width:25%">
                                                                                        <h6 class="text-warning">
                                                                                            {{ $pemeriksaan->where('kondisi', 'perlu service')->count() }}
                                                                                        </h6>
                                                                                    </th>
                                                                                    <th style="width:25%">
                                                                                        <h6 class="text-warning">
                                                                                            {{ ($pemeriksaan->where('kondisi', 'perlu service')->count() / $jumlahAset) * 100 }}%
                                                                                        </h6>
                                                                                    </th>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th style="width:50%">
                                                                                        <h6>Hilang</h6>
                                                                                    </th>
                                                                                    <th style="width:25%">
                                                                                        <h6 class="text-danger">
                                                                                            {{ $pemeriksaan->where('kondisi', 'hilang')->count() }}
                                                                                        </h6>
                                                                                    </th>
                                                                                    <th style="width:25%">
                                                                                        <h6 class="text-danger">
                                                                                            {{ ($pemeriksaan->where('kondisi', 'hilang')->count() / $jumlahAset) * 100 }}%
                                                                                        </h6>
                                                                                    </th>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="card" style="width: 97%">
                                                                            <table id="example"
                                                                                style="width: 100%; border-collapse: collapse;">
                                                                                <tr>
                                                                                    <th style="width:50%">
                                                                                        <h6>Aktif</h6>
                                                                                    </th>
                                                                                    <th style="width:25%">
                                                                                        <h6>{{ $pemeriksaan->where('status_aset', 'aktif')->count() }}
                                                                                        </h6>
                                                                                    </th>
                                                                                    <th style="width:25%">
                                                                                        <h6>{{ ($pemeriksaan->where('status_aset', 'aktif')->count() / $jumlahAset) * 100 }}%
                                                                                        </h6>
                                                                                    </th>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th style="width:50%">
                                                                                        <h6>Non Aktif</h6>
                                                                                    </th>
                                                                                    <th style="width:25%">
                                                                                        <h6 class="text-danger">
                                                                                            {{ $pemeriksaan->where('status_aset', 'non aktif')->count() }}
                                                                                        </h6>
                                                                                    </th>
                                                                                    <th style="width:25%">
                                                                                        <h6 class="text-danger">
                                                                                            {{ ($pemeriksaan->where('status_aset', 'non aktif')->count() / $jumlahAset) * 100 }}%
                                                                                        </h6>
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
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="row card-kontrol-barang">
                                                        <div class="col-12">
                                                            <div
                                                                class="d-flex justify-content-between align-items-center mb-3">
                                                                <h6><b>Hasil Pemeriksaan
                                                                        Berdasarkan Kondisi</b>
                                                                </h6>
                                                                <button type="button" class="btn btn-success"
                                                                    data-toggle="modal"
                                                                    data-target="#TambahPemeriksaanModal"
                                                                    style="background-color: rgb(0, 177, 0); color:white; border-radius:10px; width:150px;">
                                                                    <i class="fas fa-plus-circle"></i>
                                                                    <span>Tambah</span>
                                                                </button>
                                                            </div>
                                                            <table id="example3" class="table table-bordered"
                                                                style="width:100%;">
                                                                <thead class="table-secondary" style="text-align: center">
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
                                                                        <th style="width: 150px;">
                                                                            Aksi</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td colspan="11"
                                                                            style="background-color: #CBF2D6">
                                                                            <h6><b>1. Aset
                                                                                    Dengan
                                                                                    Kondisi Baik
                                                                                    ({{ $pemeriksaan->where('kondisi', 'baik')->count() }})</b>
                                                                            </h6>
                                                                        </td>
                                                                    </tr>

                                                                    @if ($pemeriksaan->where('kondisi', 'baik')->count() > 0)
                                                                        @php
                                                                            $no = 1;
                                                                        @endphp
                                                                        @foreach ($pemeriksaan as $data)
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
                                                                                    <td>
                                                                                        <div
                                                                                            class="d-flex flex-column align-items-center">
                                                                                            <div
                                                                                                class="btn-group mb-2 card_edit_pemeriksaan">
                                                                                                <a class="btn btn-outline-secondary btn-block intro-ubah-detail-pemeriksaan edit-pemeriksaan"
                                                                                                    type="button"
                                                                                                    data-toggle="modal"
                                                                                                    data-target="#UbahPemeriksaanModal"
                                                                                                    style="border-radius:10px; width: 150px; max-width: 150px; padding: 10px; margin: 0;"
                                                                                                    aria-expanded="false">
                                                                                                    &nbsp;&nbsp;<i
                                                                                                        class="fas fa-edit"></i>
                                                                                                    Ubah
                                                                                                </a>
                                                                                            </div>
                                                                                            <div
                                                                                                class="btn-group mb-2 card_hapus_barang">
                                                                                                <div
                                                                                                    class="btn-group btn-block">
                                                                                                    <a onclick="$('#cover-spin').show(0)"
                                                                                                        href="/{{ $role }}/aksi_hapus_barang"
                                                                                                        class="btn btn-outline-secondary btn-block"
                                                                                                        style="border-radius:10px; width: 150px; max-width: 150px; padding: 10px; margin: 0;">
                                                                                                        <i
                                                                                                            class="fas fa-trash"></i>
                                                                                                        Hapus
                                                                                                    </a>
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
                                                                        <td colspan="11"
                                                                            style="background-color: #CBF2D6">
                                                                            <h6><b>2. Aset
                                                                                    Dengan
                                                                                    Kondisi
                                                                                    Tidak
                                                                                    Memadai /
                                                                                    Rusak
                                                                                    ({{ $pemeriksaan->where('kondisi', 'rusak')->count() }})</b>
                                                                            </h6>
                                                                        </td>
                                                                    </tr>

                                                                    @if ($pemeriksaan->where('kondisi', 'rusak')->count() > 0)
                                                                        @php
                                                                            $no = 1;
                                                                        @endphp

                                                                        @foreach ($pemeriksaan as $data)
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
                                                                                    <td>
                                                                                        <div
                                                                                            class="d-flex flex-column align-items-center">
                                                                                            <div
                                                                                                class="btn-group mb-2 card_edit_pemeriksaan">
                                                                                                <a class="btn btn-outline-secondary btn-block intro-ubah-detail-pemeriksaan edit-pemeriksaan"
                                                                                                    type="button"
                                                                                                    data-toggle="modal"
                                                                                                    data-target="#UbahPemeriksaanModal"
                                                                                                    style="border-radius:10px; width: 150px; max-width: 150px; padding: 10px; margin: 0;"
                                                                                                    aria-expanded="false">
                                                                                                    &nbsp;&nbsp;<i
                                                                                                        class="fas fa-edit"></i>
                                                                                                    Ubah
                                                                                                </a>
                                                                                            </div>
                                                                                            <div
                                                                                                class="btn-group mb-2 card_hapus_barang">
                                                                                                <div
                                                                                                    class="btn-group btn-block">
                                                                                                    <a onclick="$('#cover-spin').show(0)"
                                                                                                        href="/{{ $role }}/aksi_hapus_barang"
                                                                                                        class="btn btn-outline-secondary btn-block"
                                                                                                        style="border-radius:10px; width: 150px; max-width: 150px; padding: 10px; margin: 0;">
                                                                                                        <i
                                                                                                            class="fas fa-trash"></i>
                                                                                                        Hapus
                                                                                                    </a>
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
                                                                        <td colspan="11"
                                                                            style="background-color: #CBF2D6">
                                                                            <h6><b>3. Aset
                                                                                    Dengan
                                                                                    Kondisi
                                                                                    Perlu
                                                                                    Perbaikan
                                                                                    ({{ $pemeriksaan->where('kondisi', 'perlu service')->count() }})</b>
                                                                            </h6>
                                                                        </td>
                                                                    </tr>


                                                                    @if ($pemeriksaan->where('kondisi', 'perlu service')->count() > 0)
                                                                        @php
                                                                            $no = 1;
                                                                        @endphp
                                                                        @foreach ($pemeriksaan as $data)
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
                                                                                    <td>
                                                                                        <div
                                                                                            class="d-flex flex-column align-items-center">
                                                                                            <div
                                                                                                class="btn-group mb-2 card_edit_pemeriksaan">
                                                                                                <a class="btn btn-outline-secondary btn-block intro-ubah-detail-pemeriksaan edit-pemeriksaan"
                                                                                                    type="button"
                                                                                                    data-toggle="modal"
                                                                                                    data-target="#UbahPemeriksaanModal"
                                                                                                    style="border-radius:10px; width: 150px; max-width: 150px; padding: 10px; margin: 0;"
                                                                                                    aria-expanded="false">
                                                                                                    &nbsp;&nbsp;<i
                                                                                                        class="fas fa-edit"></i>
                                                                                                    Ubah
                                                                                                </a>
                                                                                            </div>
                                                                                            <div
                                                                                                class="btn-group mb-2 card_hapus_barang">
                                                                                                <div
                                                                                                    class="btn-group btn-block">
                                                                                                    <a onclick="$('#cover-spin').show(0)"
                                                                                                        href="/{{ $role }}/aksi_hapus_barang"
                                                                                                        class="btn btn-outline-secondary btn-block"
                                                                                                        style="border-radius:10px; width: 150px; max-width: 150px; padding: 10px; margin: 0;">
                                                                                                        <i
                                                                                                            class="fas fa-trash"></i>
                                                                                                        Hapus
                                                                                                    </a>
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
                                                                        <td colspan="11"
                                                                            style="background-color: #CBF2D6">
                                                                            <h6><b>4. Aset
                                                                                    Dengan
                                                                                    Kondisi
                                                                                    Hilang
                                                                                    ({{ $pemeriksaan->where('kondisi', 'hilang')->count() }})</b>
                                                                            </h6>
                                                                        </td>
                                                                    </tr>

                                                                    @if ($pemeriksaan->where('kondisi', 'hilang')->count() > 0)
                                                                        <tr>
                                                                            <td>{{ $no++ }}</td>
                                                                            <td>{{ $data->aset->kode_aset }}</td>
                                                                            <td>{{ $data->aset->nama_aset }}</td>
                                                                            <td>{{ $data->aset->kategori_aset->kategori }}
                                                                            </td>
                                                                            <td>{{ $data->aset->lokasi_penyimpanan }}</td>
                                                                            <td>{{ $data->kondisi }}</td>
                                                                            <td>{{ $data->status_aset }}</td>
                                                                            <td>{{ $data->aset->tgl_perolehan }}</td>
                                                                            <td>{{ $data->masalah_teridentifikasi }}</td>
                                                                            <td>{{ $data->tindakan_diperlukan }}</td>
                                                                            <td>
                                                                                <div
                                                                                    class="d-flex flex-column align-items-center">
                                                                                    <div
                                                                                        class="btn-group mb-2 card_edit_pemeriksaan">
                                                                                        <a class="btn btn-outline-secondary btn-block intro-ubah-detail-pemeriksaan edit-pemeriksaan"
                                                                                            type="button"
                                                                                            data-toggle="modal"
                                                                                            data-target="#UbahPemeriksaanModal"
                                                                                            style="border-radius:10px; width: 150px; max-width: 150px; padding: 10px; margin: 0;"
                                                                                            aria-expanded="false">
                                                                                            &nbsp;&nbsp;<i
                                                                                                class="fas fa-edit"></i>
                                                                                            Ubah
                                                                                        </a>
                                                                                    </div>
                                                                                    <div
                                                                                        class="btn-group mb-2 card_hapus_barang">
                                                                                        <div class="btn-group btn-block">
                                                                                            <a onclick="$('#cover-spin').show(0)"
                                                                                                href="/{{ $role }}/aksi_hapus_barang"
                                                                                                class="btn btn-outline-secondary btn-block"
                                                                                                style="border-radius:10px; width: 150px; max-width: 150px; padding: 10px; margin: 0;">
                                                                                                <i
                                                                                                    class="fas fa-trash"></i>
                                                                                                Hapus
                                                                                            </a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
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

                                                {{-- tab status spv & kc --}}
                                                <div class="tab-pane fade" id="status-spv-kc" role="tabpanel"
                                                    aria-labelledby="status-spv-kc-tab">
                                                    <div class="col-12 mt-3 mb-3">
                                                        <div class="status-buttons">
                                                            <button class="btn btn-success"
                                                                style="border-radius: 10px">Selesai Input
                                                                Pemeriksaan</button>
                                                            <button class="btn btn-success"
                                                                style="border-radius: 10px">SPV Mengetahui</button>
                                                            <button class="btn btn-warning"
                                                                style="border-radius: 10px">Diteruskan Ke KC, KC Belum
                                                                Mengetahui</button>
                                                        </div>
                                                    </div>
                                                    <div class="flex-container">
                                                        <div class="card">

                                                            {{-- detail Pemeriksaan --}}
                                                            <table id="example"
                                                                style="width: 100%; border-collapse: collapse;">

                                                                {{-- line 1 --}}
                                                                <tr>
                                                                    <th style="width: 75%">
                                                                        <h6><b>Supervisor</b></h6>
                                                                    </th>
                                                                    <th style="width: 25%">
                                                                        <div class="btn-group mb-2 card_edit_pemeriksaan">
                                                                            <a class="btn btn-secondary btn-block intro-respon-spv respon-spv"
                                                                                type="button" data-toggle="modal"
                                                                                data-target="#responspvModal"
                                                                                style="border-radius:10px; width: 150px; max-width: 150px; padding: 10px; margin: 0;"
                                                                                aria-expanded="false">
                                                                                &nbsp;&nbsp;<i class="fas fa-edit"></i>
                                                                                Respon
                                                                            </a>
                                                                        </div>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <h5 class="text-success"><b>
                                                                                {{ $detailPemeriksaan->pemeriksaanAset->supervisor->pengguna->nama }}
                                                                            </b>
                                                                        </h5>
                                                                    </td>
                                                                    <td></td>
                                                                </tr>

                                                                {{-- line 2 --}}
                                                                <tr>
                                                                    <th style="width: 75%">
                                                                        <h6><b>Jabatan</b></h6>
                                                                    </th>
                                                                    <th style="width: 25%"></th>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <h6>
                                                                            {{ $detailPemeriksaan->pemeriksaanAset->supervisor->pengurusJabatan->jabatan }}
                                                                        </h6>
                                                                    </td>
                                                                    <td></td>
                                                                </tr>

                                                                {{-- line 3 --}}
                                                                <tr>
                                                                    <th style="width: 75%">
                                                                        <h6><b>Tgl Respon</b></h6>
                                                                    </th>
                                                                    <th style="width: 25%"></th>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        @if ($detailPemeriksaan->pemeriksaanAset->tgl_mengetahui_spv)
                                                                            <h6>{{ $detailPemeriksaan->pemeriksaanAset->tgl_mengetahui_spv }}
                                                                            </h6>
                                                                        @else
                                                                            <h6>-</h6>
                                                                        @endif
                                                                    </td>
                                                                    <td></td>
                                                                </tr>

                                                                {{-- line 4 --}}
                                                                <tr>
                                                                    <th style="width: 75%">
                                                                        <h6><b>Status</b></h6>
                                                                    </th>
                                                                    <th style="width: 25%"></th>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <h6 class="text-success">
                                                                            {{ $detailPemeriksaan->pemeriksaanAset->status_spv }}
                                                                        </h6>
                                                                    </td>
                                                                    <td></td>
                                                                </tr>

                                                                {{-- line 5 --}}
                                                                <tr>
                                                                    <th style="width: 75%">
                                                                        <h6><b>Catatan SPV</b></h6>
                                                                    </th>
                                                                    <th style="width: 25%"></th>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <h6 class="text-success">
                                                                            {{ $detailPemeriksaan->pemeriksaanAset->catatan_spv }}
                                                                        </h6>
                                                                    </td>
                                                                    <td></td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <div class="card">
                                                            {{-- detail Pemeriksaan --}}
                                                            <table id="example"
                                                                style="width: 100%; border-collapse: collapse;">

                                                                {{-- line 1 --}}
                                                                <tr>
                                                                    <th style="width: 75%">
                                                                        <h6><b>Kepala Cabang</b></h6>
                                                                    </th>
                                                                    <th style="width: 25%">
                                                                        <div class="btn-group mb-2 card_edit_pemeriksaan">
                                                                            <a class="btn btn-secondary btn-block intro-respon-kc respon-kc"
                                                                                type="button" data-toggle="modal"
                                                                                data-target="#responkcModal"
                                                                                style="border-radius:10px; width: 150px; max-width: 150px; padding: 10px; margin: 0;"
                                                                                aria-expanded="false">
                                                                                &nbsp;&nbsp;<i class="fas fa-edit"></i>
                                                                                Respon
                                                                            </a>
                                                                        </div>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <h5 class="text-success"><b>
                                                                                {{ $detailPemeriksaan->pemeriksaanAset->kc->pengguna->nama }}
                                                                            </b>
                                                                        </h5>
                                                                    </td>
                                                                    <td></td>
                                                                </tr>

                                                                {{-- line 2 --}}
                                                                <tr>
                                                                    <th style="width: 75%">
                                                                        <h6><b>Jabatan</b></h6>
                                                                    </th>
                                                                    <th style="width: 25%"></th>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <h6>
                                                                            {{ $detailPemeriksaan->pemeriksaanAset->kc->pengurusJabatan->jabatan }}
                                                                        </h6>
                                                                    </td>
                                                                    <td></td>
                                                                </tr>

                                                                {{-- line 3 --}}
                                                                <tr>
                                                                    <th style="width: 75%">
                                                                        <h6><b>Tgl Respon</b></h6>
                                                                    </th>
                                                                    <th style="width: 25%"></th>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        @if ($detailPemeriksaan->pemeriksaanAset->tanggal_mengetahui_kc)
                                                                            <h6>
                                                                                {{ $detailPemeriksaan->pemeriksaanAset->tanggal_mengetahui_kc }}
                                                                            </h6>
                                                                        @else
                                                                            <h6>-</h6>
                                                                        @endif

                                                                    </td>
                                                                    <td></td>
                                                                </tr>

                                                                {{-- line 4 --}}
                                                                <tr>
                                                                    <th style="width: 75%">
                                                                        <h6><b>Status</b></h6>
                                                                    </th>
                                                                    <th style="width: 25%"></th>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        @if ($detailPemeriksaan->pemeriksaanAset->status_kc == 'mengetahui')
                                                                            <h6 class="text-success">Mengetahui</h6>
                                                                        @else
                                                                            <h6 class="text-warning">Belum</h6>
                                                                        @endif
                                                                    </td>
                                                                    <td></td>
                                                                </tr>

                                                                {{-- line 5 --}}
                                                                <tr>
                                                                    <th style="width: 75%">
                                                                        <h6><b>Catatan KC</b></h6>
                                                                    </th>
                                                                    <th style="width: 25%"></th>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        @if ($detailPemeriksaan->pemeriksaanAset->catatan_kc)
                                                                            <h6 class="text-success">
                                                                                {{ $detailPemeriksaan->pemeriksaanAset->catatan_kc }}
                                                                            </h6>
                                                                        @else
                                                                            <h6>-</h6>
                                                                        @endif
                                                                    </td>
                                                                    <td></td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="row card-ontrol-barang">
                                                        <div class="col-12">
                                                            <div
                                                                class="d-flex justify-content-between align-items-center mb-3">
                                                                <h6><b>Hasil Pemeriksaan
                                                                        Berdasarkan Kondisi</b>
                                                                </h6>

                                                                <a href="/{{ $role }}/print-data"
                                                                    style="background-color: rgb(0, 177, 0); color:white; border-radius:10px; width:150px;"
                                                                    class="btn btn-success">
                                                                    <i class="fas fa-file-alt"></i>Export
                                                                </a>
                                                            </div>
                                                            <table id="example3" class="table table-bordered"
                                                                style="width:100%;">
                                                                <thead class="table-secondary" style="text-align: center">
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
                                                                <tbody>
                                                                    <tr>
                                                                        <td colspan="11"
                                                                            style="background-color: #CBF2D6">
                                                                            <h6><b>1. Aset
                                                                                    Dengan
                                                                                    Kondisi Baik
                                                                                    ({{ $pemeriksaan->where('kondisi', 'baik')->count() }})</b>
                                                                            </h6>
                                                                        </td>
                                                                    </tr>


                                                                    @if ($pemeriksaan->where('kondisi', 'baik')->count() > 0)
                                                                        @php
                                                                            $no = 1;
                                                                        @endphp
                                                                        @foreach ($pemeriksaan as $data)
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
                                                                        <td colspan="11"
                                                                            style="background-color: #CBF2D6">
                                                                            <h6><b>2. Aset
                                                                                    Dengan
                                                                                    Kondisi
                                                                                    Tidak
                                                                                    Memadai /
                                                                                    Rusak
                                                                                    ({{ $pemeriksaan->where('kondisi', 'rusak')->count() }})</b>
                                                                            </h6>
                                                                        </td>
                                                                    </tr>


                                                                    @if ($pemeriksaan->where('kondisi', 'rusak')->count() > 0)
                                                                        @php
                                                                            $no = 1;
                                                                        @endphp

                                                                        @foreach ($pemeriksaan as $data)
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
                                                                        <td colspan="11"
                                                                            style="background-color: #CBF2D6">
                                                                            <h6><b>3. Aset
                                                                                    Dengan
                                                                                    Kondisi
                                                                                    Perlu
                                                                                    Perbaikan
                                                                                    ({{ $pemeriksaan->where('kondisi', 'perlu service')->count() }})</b>
                                                                            </h6>
                                                                        </td>
                                                                    </tr>


                                                                    @if ($pemeriksaan->where('kondisi', 'perlu service')->count() > 0)
                                                                        @php
                                                                            $no = 1;
                                                                        @endphp
                                                                        @foreach ($pemeriksaan as $data)
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
                                                                        <td colspan="11"
                                                                            style="background-color: #CBF2D6">
                                                                            <h6><b>4. Aset
                                                                                    Dengan
                                                                                    Kondisi
                                                                                    Hilang
                                                                                    ({{ $pemeriksaan->where('kondisi', 'hilang')->count() }})</b>
                                                                            </h6>
                                                                        </td>
                                                                    </tr>

                                                                    @if ($pemeriksaan->where('kondisi', 'hilang')->count() > 0)
                                                                        <tr>
                                                                            <td>{{ $no++ }}</td>
                                                                            <td>{{ $data->aset->kode_aset }}</td>
                                                                            <td>{{ $data->aset->nama_aset }}</td>
                                                                            <td>{{ $data->aset->kategori_aset->kategori }}
                                                                            </td>
                                                                            <td>{{ $data->aset->lokasi_penyimpanan }}</td>
                                                                            <td>{{ $data->kondisi }}</td>
                                                                            <td>{{ $data->status_aset }}</td>
                                                                            <td>{{ $data->aset->tgl_perolehan }}</td>
                                                                            <td>{{ $data->masalah_teridentifikasi }}</td>
                                                                            <td>{{ $data->tindakan_diperlukan }}</td>
                                                                        </tr>
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

</section>

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
                <form>
                    <div class="form-group">
                        <label for="nama_aset" style="font-weight: bold; font-size: 14px;">Nama Aset</label>
                        <input type="text" class="form-control" id="nama_aset"
                            style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;">
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
                    <div class="form-group">
                        <label for="lokasi_aset" style="font-weight: bold; font-size: 14px;">Lokasi Aset</label>
                        <input type="text" class="form-control" id="lokasi_aset"
                            style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;">
                    </div>
                    <div class="form-group">
                        <label for="tgl_pembelian" style="font-weight: bold; font-size: 14px;">Tgl Pembelian</label>
                        <input type="date" class="form-control" id="tgl_pembelian"
                            style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;">
                    </div>
                    <div class="form-group">
                        <label style="font-weight: bold; font-size: 14px;">Status</label><br>
                        <div style="display: flex; align-items: center;">
                            <input type="radio" id="aktif" name="status" value="aktif" checked
                                style="margin-right: 5px;">
                            <label for="aktif" style="margin-right: 20px;">Aktif</label>
                            <input type="radio" id="nonaktif" name="status" value="nonaktif"
                                style="margin-right: 5px;">
                            <label for="nonaktif">Non Aktif</label>
                        </div>
                    </div>

                    <label for="kategori">Kondisi</label>
                    <select class="form-control" id="kategori" name="kategori" onchange="toggleNewCategoryForm()">
                        <option value="">Pilih Kondisi</option>
                        <option value="Baik">Baik</option>
                        <option value="Tidak Memadai (Rusak)">Tidak Memadai (Rusak)</option>
                        <option value="Perlu Perbaikan">Perlu Perbaikan</option>
                        <option value="Hilang">Hilang</option>
                    </select>
                    <div class="form-group">
                        <label for="masalah" style="font-weight: bold; font-size: 14px;">Masalah
                            Teridentifikasi</label>
                        <textarea class="form-control" id="masalah" rows="3"
                            style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="tindakan" style="font-weight: bold; font-size: 14px;">Tindakan Yang
                            Diperlukan</label>
                        <textarea class="form-control" id="tindakan" rows="3"
                            style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;"></textarea>
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
                <form>
                    <div class="form-group">
                        <label for="nama_aset" style="font-weight: bold; font-size: 14px;">Nama Aset</label>
                        <input type="text" class="form-control" id="nama_aset"
                            style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;">
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
                    <div class="form-group">
                        <label for="lokasi_aset" style="font-weight: bold; font-size: 14px;">Lokasi Aset</label>
                        <input type="text" class="form-control" id="lokasi_aset"
                            style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;">
                    </div>
                    <div class="form-group">
                        <label for="tgl_pembelian" style="font-weight: bold; font-size: 14px;">Tgl Pembelian</label>
                        <input type="date" class="form-control" id="tgl_pembelian"
                            style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;">
                    </div>
                    <div class="form-group">
                        <label style="font-weight: bold; font-size: 14px;">Status</label><br>
                        <div style="display: flex; align-items: center;">
                            <input type="radio" id="aktif" name="status" value="aktif" checked
                                style="margin-right: 5px;">
                            <label for="aktif" style="margin-right: 20px;">Aktif</label>
                            <input type="radio" id="nonaktif" name="status" value="nonaktif"
                                style="margin-right: 5px;">
                            <label for="nonaktif">Non Aktif</label>
                        </div>
                    </div>
                    <label for="kategori">Kondisi</label>
                    <select class="form-control" id="kategori" name="kategori" onchange="toggleNewCategoryForm()">
                        <option value="">Pilih Kondisi</option>
                        <option value="Baik">Baik</option>
                        <option value="Tidak Memadai (Rusak)">Tidak Memadai (Rusak)</option>
                        <option value="Perlu Perbaikan">Perlu Perbaikan</option>
                        <option value="Hilang">Hilang</option>
                    </select>
                    <div class="form-group">
                        <label for="masalah" style="font-weight: bold; font-size: 14px;">Masalah
                            Teridentifikasi</label>
                        <textarea class="form-control" id="masalah" rows="3"
                            style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="tindakan" style="font-weight: bold; font-size: 14px;">Tindakan Yang
                            Diperlukan</label>
                        <textarea class="form-control" id="tindakan" rows="3"
                            style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success"
                        style="width: 100%; padding: 8px 0; font-weight: bold;">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

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
                <form>
                    <div class="form-group">
                        <label for="tgl_pemeriksaan" style="font-weight: bold; font-size: 14px;">Tgl
                            Pemeriksaan</label>
                        <input type="date" class="form-control" id="tgl_pemeriksaan"
                            style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;">
                    </div>
                    <div class="form-group">
                        <label for="status_spv" style="font-weight: bold; font-size: 14px;">Status SPV</label>
                        <input type="text" class="form-control" id="status_spv"
                            style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;">
                    </div>
                    <div class="form-group">
                        <label for="tgl_respon" style="font-weight: bold; font-size: 14px;">Tgl Respon SPV</label>
                        <input type="date" class="form-control" id="tgl_respon"
                            style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;">
                    </div>
                    <div class="form-group">
                        <label for="catatan_spv" style="font-weight: bold; font-size: 14px;">Catatan SPV</label>
                        <input type="text" class="form-control" id="catatan_spv"
                            style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;">
                    </div>
                    <div class="alert alert-info"
                        style="background-color: #d4edda; border-color: #c3e6cb; color: #155724; margin-top: 15px;">
                        <strong>INFORMASI</strong><br>Dengan klik tombol simpan, SPV mengetahui hasil pemeriksaan aset
                        dan meneruskannya ke Kepala Cabang.
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="border-top: none; padding-top: 0;">
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- modal respon spv -->
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
                <form>
                    <div class="form-group">
                        <label for="tgl_pemeriksaan" style="font-weight: bold; font-size: 14px;">Tgl
                            Pemeriksaan</label>
                        <input type="date" class="form-control" id="tgl_pemeriksaan"
                            style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;">
                    </div>
                    <div class="form-group">
                        <label for="tgl_respon" style="font-weight: bold; font-size: 14px;">Tgl Respon SPV</label>
                        <input type="date" class="form-control" id="tgl_respon"
                            style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;">
                    </div>
                    <div class="form-group">
                        <label for="catatan_spv" style="font-weight: bold; font-size: 14px;">Catatan SPV</label>
                        <input type="text" class="form-control" id="catatan_spv"
                            style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;">
                    </div>
                    <div class="form-group">
                        <label for="tgl_respon_kc" style="font-weight: bold; font-size: 14px;">Tgl Respon KC</label>
                        <input type="date" class="form-control" id="tgl_respon_kc"
                            style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;">
                    </div>
                    <div class="form-group">
                        <label for="catatan_kc" style="font-weight: bold; font-size: 14px;">Catatan SPV</label>
                        <input type="text" class="form-control" id="catatan_kc"
                            style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;">
                    </div>
                    <div class="alert alert-info"
                        style="background-color: #d4edda; border-color: #c3e6cb; color: #155724; margin-top: 15px;">
                        <strong>INFORMASI</strong><br>Dengan klik tombol simpan, KC mengetahui hasil pemeriksaan aset.
                        Hasil pemeriksaan aset dapat digunakan sebagai lampiran pengajuan internal.
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="border-top: none; padding-top: 0;">
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </div>
    </div>
</div>

{{-- script --}}
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

{{-- script berpindah tab --}}
<script>
    $(document).ready(function() {
        $('#myTab a').on('click', function(e) {
            e.preventDefault();
            $('#myTab a').css('color', '#6c757d');
            $('#myTab a').css('font-weight', 'normal');
            $(this).css('color', '#28a745');
            $(this).css('font-weight', 'bold');
            $(this).tab('show');
        });
    });
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


{{-- script untuk dropdown --}}
<script>
    var status = 'Belum Selesai Diinput';

    function toggleDropdown() {
        var dropdown = document.getElementById("myDropdown");
        dropdown.classList.toggle("show");
    }

    function handleSelection(selection) {
        status = selection;
        document.getElementById("buttonText").textContent = status;
        document.getElementById("myDropdown").classList.remove("show");
    }

    window.onclick = function(event) {
        if (!event.target.matches('#dropdownButton') && !event.target.closest('.dropdown-menu')) {
            var dropdowns = document.getElementsByClassName("dropdown-menu");
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
</script>
@endsection
