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

        .table-button-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
        }

        @media (max-width: 768px) {
            .table-button-container {
                flex-direction: column;
            }

            .btn-responsive {
                margin-top: 15px;
            }

            .container {
                flex-direction: column;
                align-items: center;
            }

            .card-wrapper {
                flex-direction: column;
            }

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
            }

            .btn-group {
                margin-left: 0;
                margin-top: 10px;
            }
        }

        .card-wrapper {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            padding: 0 15px;
        }

        .card {
            padding: 20px;
            margin: 10px;
        }

        .flex-container .card:first-child {
            flex:40%;
        }

        .flex-container .card:last-child {
            flex:60%;
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
                                            <a class="nav-link active" id="detail-pencatatan-tab" data-toggle="tab"
                                                href="#pencatatan" role="tab" aria-controls="pencatatan"
                                                onclick="openTab('detail-pencatatan')" aria-selected="true"
                                                style="font-size: 16px;">1. Pencatatan</a>
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
                                        {{-- tab pencatatan --}}
                                        <div class="tab-pane fade show active" id="pencatatan" role="tabpanel"
                                            aria-labelledby="detail-pencatatan-tab">
                                            <div class="col-12 mt-3">
                                                <div class="status-buttons">
                                                    <button class="btn btn-success"
                                                        style="border-radius: 10px;font-size: 12px; padding:4px; color: white;">Selesai
                                                        Input
                                                        Pemeriksaan</button>
                                                    <button class="btn btn-success"
                                                        style="border-radius: 10px;font-size: 12px; padding:4px; color: white;">Diteruskan
                                                        Ke SPV, SPV
                                                        Mengetahui</button>
                                                </div>

                                                <div class="flex-container" style="display: flex;">
                                                    <div class="card" style="width: 40%;">
                                                        <div class="table-button-container">
                                                            <div>
                                                                <table id="example"
                                                                    style="width: 100%; border-collapse: collapse;">
                                                                    <tr>
                                                                        <th><b style="font-size: 16px;">Pencatat</b>
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><b class="text-success"
                                                                                style="font-size: 19px">nama</b>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th><b style="font-size: 16px;">Jabatan</b></th>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <h6>jabatan
                                                                            </h6>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th><b style="font-size: 16px;">Tgl
                                                                                Pencatatan</b></th>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <h6>tgl
                                                                            </h6>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th><b style="font-size: 16px;">Status</b></th>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            status
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>

                                                            <!-- Tombol (Dropdown dan Hapus) -->
                                                            <div class="btn-responsive">
                                                                <div class="dropdown mb-2">
                                                                    <form method="POST">
                                                                        @csrf
                                                                        <div class="dropdown">
                                                                            <select id="dropdownButton"
                                                                                name="status_pemeriksaan"
                                                                                onchange="this.form.submit()"
                                                                                style="border-radius: 10px; padding: 6px; margin: 0; width: 150px; font-size:12px; margin-right:5px;">
                                                                                <option value="selesai">
                                                                                    <i
                                                                                        class="bi bi-check-circle-fill"></i>Selesai
                                                                                    Diinput
                                                                                </option>
                                                                                <option value="belum">
                                                                                    <i class="bi bi-ban"></i>Belum
                                                                                    Selesai Diinput
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                    </form>
                                                                </div>

                                                                <div
                                                                    class="btn-group btn-block mb-2 mr-2 mb-xl-0 card_hapus_barang">
                                                                    <form method="POST"
                                                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="btn btn-danger btn-block"
                                                                            style="border-radius: 10px; padding: 5px; width: 150px; font-size:12px; margin-right:5px;">
                                                                            <i class="fas fa-trash"></i> Hapus
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card" style="width: 60%;">
                                                        <div class="flex-container"
                                                            style="display: flex; align-items: center; justify-content: space-between;">
                                                            <div style="width: 50%;">
                                                                <b style="font-size: 16px;">No faktur keluar masuk</b>
                                                            </div>
                                                            <div class="btn-group btn-block mb-xl-0 card-tambah-kontrol"
                                                                style="width: 50%;">
                                                                <a href=""
                                                                    style="border-radius: 10px; padding: 5px; width: 150px; font-size: 12px;"
                                                                    class="btn btn-outline-success" target="_blank">
                                                                    <i class="fas fa-file-alt"></i> Export
                                                                </a>
                                                                <button type="button" class="btn btn-success"
                                                                    data-toggle="modal"
                                                                    data-target="#TambahPemeriksaanModal"
                                                                    style="border-radius: 10px; padding: 5px; margin-left: 5px; width: 150px; font-size:12px;">
                                                                    <i class="fas fa-plus-circle"></i>
                                                                    <span>Tambah</span>
                                                                </button>
                                                            </div>
                                                        </div>

                                                        <div style="display: flex; flex-wrap: wrap; justify-content: space-between; margin-top: 10px;"
                                                            class="responsive-flex">
                                                            <div style="width: 48%; margin-bottom: 20px;"
                                                                class="responsive-card" id="card1">
                                                                <b style="font-size: 16px;">Aset Masuk</b>
                                                                <div
                                                                    style="width: 100%; border: 1px solid #ddd; padding: 10px;">
                                                                    <table id="example"
                                                                        style="width: 100%; border-collapse: collapse; font-size:16px;">
                                                                        <tr>
                                                                            <th style="width:50%">
                                                                                <h6>Hari, Tgl Masuk</h6>
                                                                            </th>
                                                                            <th style="width:50%">
                                                                                <h6>tgl
                                                                                </h6>
                                                                            </th>
                                                                        </tr>
                                                                        <tr>
                                                                            <th style="width:50%">
                                                                                <h6>Nama Pemasok</h6>
                                                                            </th>
                                                                            <th style="width:50%">
                                                                                <h6>
                                                                                    nama
                                                                                </h6>
                                                                            </th>
                                                                        </tr>
                                                                        <tr>
                                                                            <th style="width:50%">
                                                                                <h6>No Faktur/Nota</h6>
                                                                            </th>
                                                                            <th style="width:50%">
                                                                                <h6>
                                                                                    no faktur
                                                                                </h6>
                                                                            </th>
                                                                        </tr>
                                                                        <tr>
                                                                            <th style="width:50%">
                                                                                <h6>Total Kuantitas</h6>
                                                                            </th>
                                                                            <th style="width:50%">
                                                                                <h6>
                                                                                    total
                                                                                </h6>
                                                                            </th>
                                                                        </tr>
                                                                        <tr>
                                                                            <th style="width:50%">
                                                                                <h6>Keterangan</h6>
                                                                            </th>
                                                                            <th style="width:50%">
                                                                                <h6>
                                                                                    keterangan
                                                                                </h6>
                                                                            </th>
                                                                        </tr>
                                                                        <tr>
                                                                            <th style="width:50%">
                                                                                <h6>Dokumentasi</h6>
                                                                            </th>
                                                                            <th style="width:50%">
                                                                                <a href="#">Lihat</a>
                                                                            </th>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                            </div>

                                                            <div style="width: 48%; margin-bottom: 20px;"
                                                                class="responsive-card" id="card1">
                                                                <b style="font-size: 16px;">Aset Keluar</b>
                                                                <div
                                                                    style="width: 100%; border: 1px solid #ddd; padding: 10px;">
                                                                    <table id="example"
                                                                        style="width: 100%; border-collapse: collapse; font-size:16px;">
                                                                        <tr>
                                                                            <th style="width:50%">
                                                                                <h6>Hari, Tgl Keluar</h6>
                                                                            </th>
                                                                            <th style="width:50%">
                                                                                <h6>tgl
                                                                                </h6>
                                                                            </th>
                                                                        </tr>
                                                                        <tr>
                                                                            <th style="width:50%">
                                                                                <h6>Nama Penerima</h6>
                                                                            </th>
                                                                            <th style="width:50%">
                                                                                <h6>
                                                                                    nama
                                                                                </h6>
                                                                            </th>
                                                                        </tr>
                                                                        <tr>
                                                                            <th style="width:50%">
                                                                                <h6>No Faktur/Nota</h6>
                                                                            </th>
                                                                            <th style="width:50%">
                                                                                <h6>
                                                                                    no faktur
                                                                                </h6>
                                                                            </th>
                                                                        </tr>
                                                                        <tr>
                                                                            <th style="width:50%">
                                                                                <h6>Total Kuantitas</h6>
                                                                            </th>
                                                                            <th style="width:50%">
                                                                                <h6>
                                                                                    total
                                                                                </h6>
                                                                            </th>
                                                                        </tr>
                                                                        <tr>
                                                                            <th style="width:50%">
                                                                                <h6>Keterangan</h6>
                                                                            </th>
                                                                            <th style="width:50%">
                                                                                <h6>
                                                                                    keterangan
                                                                                </h6>
                                                                            </th>
                                                                        </tr>
                                                                        <tr>
                                                                            <th style="width:50%">
                                                                                <h6>Dokumentasi</h6>
                                                                            </th>
                                                                            <th style="width:50%">
                                                                                <a href="#">Lihat</a>
                                                                            </th>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- tab status spv & kc --}}
                                        <div class="tab-pane fade" id="status-spv-kc" role="tabpanel"
                                            aria-labelledby="status-spv-kc-tab">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card ijo-atas">
                        <div class="card-body">
                            <div class="row card-kontrol-barang">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table id="pencatatanTable" class="table table-bordered"
                                            style="width:100%;">
                                            <thead style="text-align: center; font-size:16;">
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Kode Aset</th>
                                                    <th>Nama Aset</th>
                                                    <th>Kategori</th>
                                                    <th>Lokasi</th>
                                                    <th>Kuantitas</th>
                                                    <th>Satuan</th>
                                                    <th>Kondisi</th>
                                                    <th>Tindak Lanjut</th>
                                                    <th>Dokumentasi</th>
                                                    <th style="width: 100px;">
                                                        Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody style="font-size: 13px;">
                                                <tr>
                                                    <td colspan="11" style="background-color: #CBF2D6;">
                                                        <b style="font-size: 16px;">1. Aset Masuk</b>
                                                    </td>
                                                </tr>

                                                {{-- @if (($detailPemeriksaan->where('kondisi', 'baik')->count() ?? 0) > 0)
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
                                                        @if ($data->kondisi == 'baik') --}}
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
                                                                <td>
                                                                    <div
                                                                        class="d-flex flex-column align-items-center">
                                                                        <div
                                                                            class="btn-group mb-2 card_edit_pemeriksaan">
                                                                            <button
                                                                                class="btn btn-outline-secondary btn-block intro-ubah-detail-pemeriksaan edit-pemeriksaan"
                                                                                type="button"
                                                                                data-toggle="modal"
                                                                                {{-- data-target="#UbahPemeriksaanModal"
                                                                                data-aset-id="{{ $data->aset_id }}"
                                                                                data-kategori-aset="{{ $data->aset->kategori_aset->kategori }}"
                                                                                data-lokasi-penyimpanan="{{ $data->aset->lokasi_penyimpanan }}"
                                                                                data-tgl-perolehan="{{ $data->aset->tgl_perolehan }}"
                                                                                data-kondisi="{{ $data->kondisi }}"
                                                                                data-masalah-teridentifikasi="{{ $data->masalah_teridentifikasi }}"
                                                                                data-tindakan-diperlukan="{{ $data->tindakan_diperlukan }}"
                                                                                data-status-aset="{{ $data->status_aset }}"
                                                                                data-id-detail="{{ $data->id_detail_pemeriksaan_aset }}"
                                                                                @if ($pemeriksaanAset->status_pemeriksaan == 'selesai') disabled @endif --}}
                                                                                style="border-radius:10px; width: 100px; max-width: 100px; padding: 5px; font-size:12px;">
                                                                                <i class="fas fa-edit"></i>
                                                                                Ubah
                                                                            </button>
                                                                        </div>
                                                                        <div
                                                                            class="btn-group mb-2 mb-xl-0 card_hapus_detail">
                                                                            <div
                                                                                class="btn-group mb-2 mb-xl-0 btn-block">
                                                                                <form
                                                                                    {{-- action="{{ route($role . '.delete_detail_pemeriksaan', $data->id_detail_pemeriksaan_aset) }}" --}}
                                                                                    method="POST"
                                                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                    <button type="submit"
                                                                                        class="btn btn-outline-secondary btn-block"
                                                                                        {{-- @if ($pemeriksaanAset->status_pemeriksaan == 'selesai') disabled @endif --}}
                                                                                        style="border-radius:10px; width: 100px; max-width: 100px; padding: 5px; margin-bottom: 10px; font-size:12px;">
                                                                                        <i
                                                                                            class="fas fa-trash"></i>
                                                                                        Hapus
                                                                                    </button>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        {{-- @endif
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="11" style="text-align:center">
                                                            Tidak ada data
                                                        </td>
                                                    </tr>
                                                @endif --}}

                                                <tr>
                                                    <td colspan="11" style="background-color: #CBF2D6;">
                                                        <b style="font-size: 16px;">2. Aset Keluar</b>
                                                    </td>
                                                </tr>

                                                {{-- @if (($detailPemeriksaan->where('kondisi', 'rusak')->count() ?? 0) > 0)
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
                                                        @if ($data->kondisi == 'rusak') --}}
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
                                                                <td>
                                                                    <div
                                                                        class="d-flex flex-column align-items-center">
                                                                        <div
                                                                            class="btn-group mb-2 card_edit_pemeriksaan">
                                                                            <button
                                                                                class="btn btn-outline-secondary btn-block intro-ubah-detail-pemeriksaan edit-pemeriksaan"
                                                                                type="button"
                                                                                data-toggle="modal"
                                                                                {{-- data-target="#UbahPemeriksaanModal"
                                                                                data-aset-id="{{ $data->aset_id }}"
                                                                                data-kategori-aset="{{ $data->aset->kategori_aset->kategori }}"
                                                                                data-lokasi-penyimpanan="{{ $data->aset->lokasi_penyimpanan }}"
                                                                                data-tgl-perolehan="{{ $data->aset->tgl_perolehan }}"
                                                                                data-kondisi="{{ $data->kondisi }}"
                                                                                data-masalah-teridentifikasi="{{ $data->masalah_teridentifikasi }}"
                                                                                data-tindakan-diperlukan="{{ $data->tindakan_diperlukan }}"
                                                                                data-status-aset="{{ $data->status_aset }}"
                                                                                data-id-detail="{{ $data->id_detail_pemeriksaan_aset }}"
                                                                                @if ($pemeriksaanAset->status_pemeriksaan == 'selesai') disabled @endif --}}
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
                                                                                <form
                                                                                    {{-- action="{{ route($role . '.delete_detail_pemeriksaan', $data->id_detail_pemeriksaan_aset) }}" --}}
                                                                                    method="POST"
                                                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                    <button type="submit"
                                                                                        class="btn btn-outline-secondary btn-block "
                                                                                        {{-- @if ($pemeriksaanAset->status_pemeriksaan == 'selesai') disabled @endif --}}
                                                                                        style="border-radius:10px; width: 100px; max-width: 100px; padding: 5px; margin-bottom: 10px; font-size:12px;">
                                                                                        <i
                                                                                            class="fas fa-trash"></i>
                                                                                        Hapus
                                                                                    </button>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        {{-- @endif
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="11" style="text-align:center">
                                                            Tidak ada data
                                                        </td>
                                                    </tr>
                                                @endif --}}
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
    </section>

@endsection
@endsection
