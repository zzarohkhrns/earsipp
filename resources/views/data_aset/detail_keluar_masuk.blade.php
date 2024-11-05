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
            flex: 40%;
        }

        .flex-container .card:last-child {
            flex: 60%;
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
                                                                                style="font-size: 19px">{{ $keluar_masuk_aset->pencatat->pengguna->nama }}</b>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th><b style="font-size: 16px;">Jabatan</b></th>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <h6>{{ $keluar_masuk_aset->pencatat->pengurusJabatan->jabatan }}
                                                                            </h6>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th><b style="font-size: 16px;">Tgl
                                                                                Pencatatan</b></th>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <h6>{{ $keluar_masuk_aset->tanggal_pencatatan }}
                                                                            </h6>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th><b style="font-size: 16px;">Status</b></th>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            {{ $keluar_masuk_aset->status_pencatatan }}
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
                                                                                <h6>{{ $keluar_masuk_aset->masuk_tgl_masuk ?? '-' }}
                                                                                </h6>
                                                                            </th>
                                                                        </tr>
                                                                        <tr>
                                                                            <th style="width:50%">
                                                                                <h6>Nama Pemasok</h6>
                                                                            </th>
                                                                            <th style="width:50%">
                                                                                <h6>
                                                                                    {{ $keluar_masuk_aset->masuk_nama_pemasok ?? '-' }}
                                                                                </h6>
                                                                            </th>
                                                                        </tr>
                                                                        <tr>
                                                                            <th style="width:50%">
                                                                                <h6>No Faktur/Nota</h6>
                                                                            </th>
                                                                            <th style="width:50%">
                                                                                <h6>
                                                                                    {{ $keluar_masuk_aset->masuk_no_faktur ?? '-' }}
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
                                                                                    {{ $keluar_masuk_aset->masuk_keterangan ?? '-' }}
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
                                                                                <h6>{{ $keluar_masuk_aset->keluar_tgl_keluar ?? '-' }}
                                                                                </h6>
                                                                            </th>
                                                                        </tr>
                                                                        <tr>
                                                                            <th style="width:50%">
                                                                                <h6>Nama Penerima</h6>
                                                                            </th>
                                                                            <th style="width:50%">
                                                                                <h6>
                                                                                    {{ $keluar_masuk_aset->keluar_nama_penerima ?? '-' }}
                                                                                </h6>
                                                                            </th>
                                                                        </tr>
                                                                        <tr>
                                                                            <th style="width:50%">
                                                                                <h6>No Faktur/Nota</h6>
                                                                            </th>
                                                                            <th style="width:50%">
                                                                                <h6>
                                                                                    {{ $keluar_masuk_aset->keluar_no_faktur ?? '-' }}
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
                                                                                    {{ $keluar_masuk_aset->keluar_keterangan ?? '-' }}
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
                                    <div class="flex justify-content-between mb-3">
                                        <h3 class="card-title text-success" style="font-size: 16px;"><b>Data Pencatatan
                                                Keluar Masuk Aset</b></h3>
                                        <button type="button" class="btn btn-success" data-toggle="modal"
                                            data-target="#TambahPencatatanModal"
                                            style="border-radius: 10px; padding: 5px; margin-left: 5px; width: 150px; font-size:12px;">
                                            <i class="fas fa-plus-circle"></i>
                                            <span>Tambah</span>
                                        </button>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="pencatatanTable" class="table table-bordered" style="width:100%;">
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
                                                @if ($keluar_masuk_aset->detail_keluar_masuk)
                                                @foreach ($keluar_masuk_aset->detail_keluar_masuk as $index=>$detail)
                                                    {{-- @foreach ($keluar_masuk->detail_keluar_masuk as $detail) --}}
                                                    {{-- @php
                                                        dd($detail->aset);
                                                    @endphp --}}
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                                <td>{{ $detail->aset->kode_aset }}</td>
                                                                <td>{{ $detail->aset->nama_aset }}</td>
                                                                <td>{{ $detail->aset->kategori_aset->kategori }}</td>
                                                                <td>{{ $detail->aset->lokasi_penyimpanan }}</td>
                                                                <td>{{ $detail->keluar_kuantitas }}</td>
                                                                <td>{{ $detail->aset->satuan }}</td>
                                                                <td>{{ $detail->keluar_kondisi }}</td>
                                                                <td>{{ $detail->keluar_tindak_lanjut }}</td>
                                                                <td>Lihat</td>
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
                                                    @endforeach
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
    </section>
    


    <!-- Modal Tambah Pencatatan Keluar Masuk -->
    <div class="modal fade" id="TambahPencatatanModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Tambah Pencatatan Keluar Masuk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <form id="pencatatanForm" method="POST" action="">
                        @csrf
                        <!-- Jenis Radio Button -->
                        <div class="form-group mb-2">
                            <label class="font-weight-bold">Jenis</label>
                            <div class="d-flex mt-1">
                                <div class="form-check mr-3">
                                    <input class="form-check-input" type="radio" name="jenis" id="asetMasuk" checked>
                                    <label class="form-check-label" for="asetMasuk">Aset Masuk</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jenis" id="asetKeluar">
                                    <label class="form-check-label" for="asetKeluar">Aset Keluar</label>
                                </div>
                            </div>
                        </div>

                        <!-- Input Fields -->
                        <div class="form-group mb-2">
                            <label class="font-weight-bold" for="nama_aset">Nama Aset</label>
                            <select name="aset" class="form-control" id="nama_aset">
                                <option value="">Pilih Aset</option>
                                {{-- @foreach ($aset as $data)
                                    <option value="{{ $data->aset_id }}">{{ $data->nama_aset }}</option>
                                @endforeach --}}
                            </select>
                        </div>

                        <div class="form-group mb-2">
                            <label class="font-weight-bold" for="kategori">Kategori</label>
                            <input type="text" class="form-control" id="kategori" name="kategori" readonly>
                        </div>

                        <div class="form-group mb-2">
                            <label class="font-weight-bold" for="lokasi_aset">Lokasi Aset</label>
                            <input type="text" class="form-control" id="lokasi_aset" name="lokasi_aset" readonly>
                        </div>

                        <div class="form-group mb-2">
                            <label class="font-weight-bold" for="kuantitas">Kuantitas Masuk (Jika jenis aset keluar maka kuantitas keluar)</label>
                            <input type="text" class="form-control" id="kuantitas" name="kuantitas">
                        </div>

                        <div class="form-group mb-2">
                            <label class="font-weight-bold" for="kondisi">Kondisi</label>
                            <input type="text" class="form-control" id="kondisi" name="kondisi">
                        </div>

                        <div class="form-group mb-2">
                            <label class="font-weight-bold" for="dokumentasi">Dokumentasi</label>
                            <input type="file" class="form-control" id="dokumentasi" name="dokumentasi" accept="image/*">
                        </div>

                        <div class="form-group mb-2">
                            <label class="font-weight-bold" for="tindak_lanjut">Tindak Lanjut</label>
                            <textarea class="form-control" id="tindak_lanjut" name="tindak_lanjut" rows="3"></textarea>
                        </div>

                        <!-- Information Box -->
                        <div class="alert alert-info mt-3" style="background-color: #d4edda; border-color: #c3e6cb; color: #155724;">
                            <strong>INFORMASI</strong><br>Jika aset yang dimaksud tidak ada, tambahkan dahutu data aset pada menu data aset.
                        </div>

                        <!-- Modal Footer -->
                        <div class="mt-3">
                            <button type="submit" class="btn btn-success w-100" style="padding: 8px 0; font-weight: bold;">Simpan</button>
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
