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

    </style>


    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb m-0 pl-4">
                        <li class="breadcrumb-item active">
                            <a href="/{{ $role }}/dashboard">Dashboard</a> / <a
                                href="/{{ $role }}/arsip/aset/data">Data Aset</a> / <a>Detail Keluar Masuk</a>
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
                                                    <!-- Tombol untuk status pencatatan -->
                                                    @if ($keluar_masuk_aset->status_pencatatan == 'selesai')
                                                        <button class="btn btn-success"
                                                            style="border-radius: 10px;font-size: 12px; padding:4px; color: white;">Selesai Input
                                                        </button>

                                                        <!-- Tombol untuk status SPV -->
                                                        @if ($keluar_masuk_aset->status_spv == 'belum')
                                                            <button class="btn btn-warning"
                                                                style="border-radius: 10px;font-size: 12px; padding:4px; color: white;">Diteruskan
                                                                ke SPV, SPV belum mengetahui
                                                            </button>
                                                        @else
                                                            <button class="btn btn-success"
                                                                style="border-radius: 10px;font-size: 12px; padding:4px; color: white;">Diteruskan
                                                                ke SPV, SPV mengetahui
                                                            </button>
                                                        @endif
                                                    @else
                                                        <button class="btn btn-warning"
                                                            style="border-radius: 10px;font-size: 12px; padding:4px; color: white;">Belum Selesai Input
                                                        </button>
                                                    @endif
                                                </div>

                                                <div class="flex-container" style="display: flex;">
                                                    <div class="card" style="flex: 40%;">
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
                                                                    <form method="POST" action="{{ route($role . '.keluar_masuk_aset.update', $keluar_masuk_aset->id_keluar_masuk_aset) }}">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <div class="dropdown">
                                                                            <select id="dropdownButton"
                                                                                name="status_pencatatan"
                                                                                onchange="this.form.submit()"
                                                                                style="border-radius: 10px; padding: 6px; margin: 0; width: 150px; font-size:12px; margin-right:5px;">
                                                                                <option value="belum" @selected($keluar_masuk_aset->status_pencatatan == 'belum')>
                                                                                    <i class="bi bi-ban"></i>Belum
                                                                                    Selesai Diinput
                                                                                </option>
                                                                                <option value="selesai" @selected($keluar_masuk_aset->status_pencatatan == 'selesai')>
                                                                                    <i class="bi bi-check-circle-fill"></i>Selesai
                                                                                    Diinput
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                    </form>
                                                                </div>

                                                                <div
                                                                    class="btn-group btn-block mb-2 mr-2 mb-xl-0 card_hapus_barang">
                                                                    <form method="POST" action="{{ route($role.'.keluar_masuk_aset.delete', $keluar_masuk_aset->id_keluar_masuk_aset) }}"
                                                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            @disabled($keluar_masuk_aset->status_pencatatan == 'selesai')
                                                                            class="btn btn-danger btn-block"
                                                                            style="border-radius: 10px; padding: 5px; width: 150px; font-size:12px; margin-right:5px;">
                                                                            <i class="fas fa-trash"></i> Hapus
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card" style="flex: 60%;">
                                                        <div class="flex-container"
                                                            style="display: flex; justify-content: space-between;">
                                                            <div style="width: 50%;">
                                                                <b style="font-size: 16px;">No Faktur Keluar Masuk Aset</b>
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
                                                                    @disabled($keluar_masuk_aset->status_pencatatan == 'selesai')
                                                                    data-target="#TambahFakturModal"
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
                                                                                <a href="{{ $keluar_masuk_aset->masuk_dokumentasi }}" target="_blank">Lihat</a>
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
                                                                                <a href="{{ $keluar_masuk_aset->keluar_dokumentasi }}" target="_blank">Lihat</a>
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
                                            <div class="col-12 mt-3 mb-3">
                                                <div class="status-buttons">
                                                    {{-- @if ($pemeriksaanAset->status_pemeriksaan == 'selesai') --}}

                                                        @if ($keluar_masuk_aset->status_pencatatan == 'belum')
                                                            <button class="btn btn-warning"
                                                            style="border-radius: 10px; font-size: 12px; padding:4px; color: white;">Belum selesai input pemeriksaan</button>
                                                        @else
                                                            <button class="btn btn-success"
                                                            style="border-radius: 10px; font-size: 12px; padding:4px; color: white;">Selesai input pemeriksaan</button>
                                                        @endif

                                                        @if ($keluar_masuk_aset->status_spv == 'belum')
                                                            <button class="btn btn-warning"
                                                            style="border-radius: 10px; font-size: 12px; padding:4px; color: white;">SPV
                                                            belum mengetahui</button>
                                                        @else
                                                            <button class="btn btn-success"
                                                            style="border-radius: 10px; font-size: 12px; padding:4px; color: white;">SPV
                                                            Mengetahui</button>
                                                        @endif

                                                        @if ($keluar_masuk_aset->status_kc == 'belum')
                                                            <button class="btn btn-warning"
                                                            style="border-radius: 10px; font-size: 12px; padding:4px; color: white;">Diteruskan
                                                            ke KC, KC
                                                            belum mengetahui</button>
                                                        @else
                                                            <button class="btn btn-success"
                                                            style="border-radius: 10px; font-size: 12px; padding:4px; color: white;">Diteruskan
                                                            ke KC, KC
                                                            mengetahui</button>
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
                                                                {{-- @if (Auth::user()->gocap_id_pc_pengurus == $supervisor) --}}
                                                                    <div class="btn-group mb-2 card_edit_pemeriksaan">
                                                                        <button
                                                                            @disabled($keluar_masuk_aset->status_pencatatan == 'belum')
                                                                            class="btn btn-secondary btn-block intro-respon-spv respon-spv"
                                                                            type="button" data-toggle="modal"
                                                                            data-target="#responspvModal"
                                                                            style="border-radius:10px; width: 150px; max-width: 150px; padding: 5px; margin: 0; font-size:12px;"
                                                                            aria-expanded="false">
                                                                            &nbsp;&nbsp;<i class="fas fa-edit"></i>
                                                                            Respon
                                                                        </button>
                                                                    </div>
                                                                {{-- @endif --}}
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <b class="text-success" style="font-size: 19px;">
                                                                    {{ $keluar_masuk_aset->supervisor->pengguna->nama }}
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
                                                                {{ $keluar_masuk_aset->supervisor->pengurusJabatan->jabatan }}
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
                                                                @if ($keluar_masuk_aset->tgl_mengetahui_spv)
                                                                    {{ $keluar_masuk_aset->tgl_mengetahui_spv }}
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
                                                                @if ($keluar_masuk_aset->status_spv == 'mengetahui')
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
                                                                @if ($keluar_masuk_aset->catatan_spv)
                                                                    {{ $keluar_masuk_aset->catatan_spv }}
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
                                                                {{-- @if (Auth::user()->gocap_id_pc_pengurus == $kc) --}}
                                                                    <div class="btn-group mb-2 card_edit_pemeriksaan">
                                                                        <button
                                                                            class="btn btn-secondary btn-block intro-respon-kc respon-kc"
                                                                            type="button" data-toggle="modal"
                                                                            data-target="#responkcModal"
                                                                            @disabled($keluar_masuk_aset->status_spv == 'belum' || $keluar_masuk_aset->status_pencatatan == 'belum')
                                                                            style="border-radius:10px; width: 150px; max-width: 150px; padding: 5px; margin: 0;font-size:12px;"
                                                                            aria-expanded="false">
                                                                            &nbsp;&nbsp;<i class="fas fa-edit"></i>
                                                                            Respon
                                                                        </button>
                                                                    </div>
                                                                {{-- @endif --}}
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <b style="font-size:19px;" class="text-success">
                                                                    {{ $keluar_masuk_aset->kc->pengguna->nama }}
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
                                                                {{ $keluar_masuk_aset->kc->pengurusJabatan->jabatan }}
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
                                                                @if ($keluar_masuk_aset->tgl_mengetahui_kc)
                                                                    {{ $keluar_masuk_aset->tgl_mengetahui_kc }}
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
                                                                @if ($keluar_masuk_aset->status_kc == 'mengetahui')
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
                                                                @if ($keluar_masuk_aset->catatan_kc)
                                                                    {{ $keluar_masuk_aset->catatan_kc }}
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                            <td></td>
                                                        </tr>
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
                                            data-target="#TambahPencatatanModal" @disabled($keluar_masuk_aset->status_pencatatan == 'selesai')
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
                                                @php
                                                    $no = 0;
                                                @endphp
                                                    @foreach ($keluar_masuk_aset->detail_keluar_masuk as $index=>$detail)
                                                        @if ($detail->masuk_kuantitas)
                                                            <tr>
                                                                <td>{{ $no = $no + 1 }}</td>
                                                                    <td>{{ $detail->aset->kode_aset }}</td>
                                                                    <td>{{ $detail->aset->nama_aset }}</td>
                                                                    <td>{{ $detail->aset->kategori_aset->kategori }}</td>
                                                                    <td>{{ $detail->aset->lokasi_penyimpanan }}</td>
                                                                    <td>{{ $detail->masuk_kuantitas }}</td>
                                                                    <td>{{ $detail->aset->satuan }}</td>
                                                                    <td>{{ $detail->masuk_kondisi }}</td>
                                                                    <td>{{ $detail->masuk_tindak_lanjut }}</td>
                                                                    <td><a href="{{ $detail->masuk_dokumentasi }}" target="_blank">Lihat</a></td>
                                                                <td>
                                                                    <div
                                                                        class="d-flex flex-column align-items-center">
                                                                        <div
                                                                            class="btn-group mb-2 card_edit_pemeriksaan">
                                                                            <button
                                                                                @disabled($keluar_masuk_aset->status_pencatatan == 'selesai')
                                                                                class="btn btn-outline-secondary btn-block intro-ubah-detail-pemeriksaan edit-detail-keluar-masuk"
                                                                                type="button"
                                                                                data-toggle="modal"
                                                                                data-target="#EditPencatatanModal"
                                                                                data-jenis = "masuk"
                                                                                data-id-detail-keluar_masuk-aset = {{ $detail->id_detail_keluar_masuk_aset }}
                                                                                data-kuantitas = {{ $detail->masuk_kuantitas }}
                                                                                data-kondisi = {{ $detail->masuk_kondisi }}
                                                                                data-tindak-lanjut = {{ $detail->masuk_tindak_lanjut }}
                                                                                data-aset-id = {{ $detail->aset_id }}
                                                                                data-kategori-aset = {{ $detail->aset->kategori_aset->kategori }}
                                                                                data-lokasi-penyimpanan ={{ $detail->aset->lokasi_penyimpanan }}
                                                                                data-dokumentasi = {{ $detail->keluar_dokumentasi }}
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
                                                                                 action="{{ route($role . '.detail_keluar_masuk_aset.delete', ['id' => $detail->id_detail_keluar_masuk_aset,'jenis' => 'masuk']) }}"                                                                                    method="POST"
                                                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                    <button type="submit"
                                                                                        @disabled($keluar_masuk_aset->status_pencatatan == 'selesai')
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
                                                        @endif
                                                    @endforeach
                                                @endif
                                                <tr>
                                                    <td colspan="11" style="background-color: #CBF2D6;">
                                                        <b style="font-size: 16px;">2. Aset Keluar</b>
                                                    </td>
                                                </tr>
                                                @if ($keluar_masuk_aset->detail_keluar_masuk)
                                                @php
                                                    $no = 0;
                                                @endphp
                                                  @foreach ($keluar_masuk_aset->detail_keluar_masuk as $index=>$detail)
                                                        @if ($detail->keluar_kuantitas)
                                                            <tr>
                                                                <td>{{ $no = $no + 1 }}</td>
                                                                    <td>{{ $detail->aset->kode_aset }}</td>
                                                                    <td>{{ $detail->aset->nama_aset }}</td>
                                                                    <td>{{ $detail->aset->kategori_aset->kategori }}</td>
                                                                    <td>{{ $detail->aset->lokasi_penyimpanan }}</td>
                                                                    <td>{{ $detail->keluar_kuantitas }}</td>
                                                                    <td>{{ $detail->aset->satuan }}</td>
                                                                    <td>{{ $detail->keluar_kondisi }}</td>
                                                                    <td>{{ $detail->keluar_tindak_lanjut }}</td>
                                                                    <td><a href="{{ $detail->keluar_dokumentasi }}" target="_blank">Lihat</a></td>
                                                                <td>
                                                                    <div
                                                                        class="d-flex flex-column align-items-center">
                                                                        <div
                                                                            class="btn-group mb-2 card_edit_keluar_masuk">
                                                                            <button
                                                                                @disabled($keluar_masuk_aset->status_pencatatan == 'selesai')
                                                                                class="btn btn-outline-secondary btn-block intro-ubah-detail-keluar-masuk edit-detail-keluar-masuk"
                                                                                type="button"
                                                                                data-toggle="modal"
                                                                                data-target="#EditPencatatanModal"
                                                                                data-jenis = "keluar"
                                                                                data-id-detail-keluar_masuk-aset = {{ $detail->id_detail_keluar_masuk_aset }}
                                                                                data-kuantitas = {{ $detail->keluar_kuantitas }}
                                                                                data-kondisi = {{ $detail->keluar_kondisi }}
                                                                                data-tindak-lanjut = {{ $detail->keluar_tindak_lanjut }}
                                                                                data-aset-id = {{ $detail->aset_id }}
                                                                                data-kategori-aset = {{ $detail->aset->kategori_aset->kategori }}
                                                                                data-lokasi-penyimpanan ={{ $detail->aset->lokasi_penyimpanan }}
                                                                                data-dokumentasi = {{ $detail->keluar_dokumentasi }}
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
                                                                                    action="{{ route($role . '.detail_keluar_masuk_aset.delete', ['id' => $detail->id_detail_keluar_masuk_aset,'jenis' => 'keluar']) }}"
                                                                                    method="POST"
                                                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                    <button type="submit"
                                                                                        @disabled($keluar_masuk_aset->status_pencatatan == 'selesai')
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
                                                        @endif
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
                    <form id="pencatatanForm" enctype="multipart/form-data" method="POST" action="{{ route($role.'.detail_keluar_masuk_aset.store', $keluar_masuk_aset->id_keluar_masuk_aset) }}">
                        @csrf
                        <!-- Jenis Radio Button -->
                        <div class="form-group mb-2">
                            <label class="font-weight-bold">Jenis</label>
                            <div class="d-flex mt-1">
                                <div class="form-check mr-3">
                                    <input class="form-check-input" type="radio" name="jenis" value="masuk" id="asetMasuk" checked>
                                    <label class="form-check-label" for="asetMasuk">Aset Masuk</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jenis" value="keluar" id="asetKeluar">
                                    <label class="form-check-label" for="asetKeluar">Aset Keluar</label>
                                </div>
                            </div>
                        </div>

                        <!-- Input Fields -->
                        <div class="form-group mb-2">
                            <label class="font-weight-bold" for="nama_aset">Nama Aset</label>
                            <select name="aset" class="form-control" id="aset">
                                <option value="">Pilih Aset</option>
                                @foreach ($aset as $data)
                                    <option value="{{ $data->aset_id }}">{{ $data->nama_aset }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-2">
                            <label class="font-weight-bold" for="kategori_aset">Kategori</label>
                            <input type="text" class="form-control" id="kategori_aset" name="kategori_aset" readonly>
                        </div>

                        <div class="form-group mb-2">
                            <label class="font-weight-bold" for="lokasi_penyimpanan">Lokasi Aset</label>
                            <input type="text" class="form-control" id="lokasi_penyimpanan" name="lokasi_penyimpanan" readonly>
                        </div>

                        <div class="form-group mb-2">
                            <label class="font-weight-bold" for="kuantitas">Kuantitas</label>
                            <input type="number" class="form-control" id="kuantitas" name="kuantitas">
                        </div>

                        <div class="form-group mb-2">
                            <label class="font-weight-bold" for="kondisi">Kondisi</label>
                            <input type="text" class="form-control" id="kondisi" name="kondisi">
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold" for="dokumentasi">Dokumentasi</label>
                            <input type="file" class="form-control" id="dokumentasi" name="dokumentasi" accept="image/*" style="padding: 4px; align-items: center;">
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


    <script>
        $(document).on('click', '.edit-detail-keluar-masuk', function() {
            var id_detail_keluar_masuk_aset = $(this).data('id-detail-keluar_masuk-aset');
            var aset_id = $(this).data('aset-id');
            var kuantitas = $(this).data('kuantitas');
            var kondisi = $(this).data('kondisi');
            var tindak_lanjut = $(this).data('tindak-lanjut');
            var jenis = $(this).data('jenis');
            var dokumentasi = $(this).data('dokumentasi');
            var kategori_aset = $(this).data('kategori-aset');
            var lokasi_penyimpanan = $(this).data('lokasi-penyimpanan');

            // Jika dokumentasi adalah URL Google Drive, pastikan formatnya sesuai
            var formattedDokumentasi = dokumentasi.replace("/view", "/uc");

            //Isi form di dalam modal dengan data yang diterima
            $('#edit_id_detail_keluar_masuk_aset').val(id_detail_keluar_masuk_aset);
            $('#edit_aset').val(aset_id);
            $('#edit_kategori_aset').val(kategori_aset);
            $('#edit_lokasi_penyimpanan').val(lokasi_penyimpanan);
            $('#edit_kuantitas').val(kuantitas);
            $('#edit_kondisi').val(kondisi);
            $('#edit_tindak_lanjut').val(tindak_lanjut);
            $('input[name="edit_jenis"][value="'+ jenis +'"]').prop('checked', true);
            // Menampilkan gambar dokumentasi
             $('#old_dokumentasi').attr('src', formattedDokumentasi);

            // Jika ada dokumentasi sebelumnya, set di input file
            $('#old_dokumentasi').val(dokumentasi);
        })
    </script>

    <!-- Modal edit Pencatatan Keluar Masuk -->
    <div class="modal fade" id="EditPencatatanModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Ubah Pencatatan Keluar Masuk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <form id="pencatatanForm" enctype="multipart/form-data" method="POST" action="{{ route('pc.detail_keluar_masuk_aset.update') }}">
                        @csrf
                        @method('PUT')
                        <!-- Jenis Radio Button -->
                        <input type="text" name="edit_id_detail_keluar_masuk_aset" hidden id="edit_id_detail_keluar_masuk_aset">
                        <div class="form-group mb-2">
                            <label class="font-weight-bold">Jenis</label>
                            <div class="d-flex mt-1">
                                <div class="form-check mr-3">
                                    <input class="form-check-input" type="radio" name="edit_jenis" value="masuk" id="edit_jenis">
                                    <label class="form-check-label" for="asetMasuk">Aset Masuk</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="edit_jenis" value="keluar" id="edit_jenis">
                                    <label class="form-check-label" for="asetKeluar">Aset Keluar</label>
                                </div>
                            </div>
                        </div>

                        <!-- Input Fields -->
                        <div class="form-group mb-2">
                            <label class="font-weight-bold" for="nama_aset">Nama Aset</label>
                            <select name="edit_aset" class="form-control" id="edit_aset">
                                <option value="">Pilih Aset</option>
                                @foreach ($aset as $data)
                                    <option value="{{ $data->aset_id }}">{{ $data->nama_aset }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-2">
                            <label class="font-weight-bold" for="kategori_aset">Kategori</label>
                            <input type="text" class="form-control" id="edit_kategori_aset" name="edit_kategori_aset" readonly>
                        </div>

                        <div class="form-group mb-2">
                            <label class="font-weight-bold" for="lokasi_penyimpanan">Lokasi Aset</label>
                            <input type="text" class="form-control" id="edit_lokasi_penyimpanan" name="edit_lokasi_penyimpanan" readonly>
                        </div>

                        <div class="form-group mb-2">
                            <label class="font-weight-bold" for="kuantitas">Kuantitas</label>
                            <input type="number" class="form-control" id="edit_kuantitas" name="edit_kuantitas">
                        </div>

                        <div class="form-group mb-2">
                            <label class="font-weight-bold" for="kondisi">Kondisi</label>
                            <input type="text" class="form-control" id="edit_kondisi" name="edit_kondisi">
                        </div>

                        {{-- <div class="form-group mb-3">
                            <!-- Menampilkan gambar dokumentasi dengan ID yang sesuai -->
                            <img id="old_dokumentasi" src="https://drive.google.com/uc?id=15Fb8Vz2hIb1rPSTOfVeNtaGahkiu92ZF" alt="dokumentasi aset" style="max-width: 100%; height: auto;">
                        </div> --}}
                        <div class="form-group mb-3">
                            <label class="font-weight-bold" for="dokumentasi">Ubah Dokumentasi</label>
                            <input type="file" class="form-control" id="edit_dokumentasi" name="edit_dokumentasi" accept="image/*" style="padding: 4px; align-items: center;">
                        </div>

                        <div class="form-group mb-2">
                            <label class="font-weight-bold" for="tindak_lanjut">Tindak Lanjut</label>
                            <textarea class="form-control" id="edit_tindak_lanjut" name="edit_tindak_lanjut" rows="3"></textarea>
                        </div>

                        <!-- Information Box -->
                        <div class="alert alert-info mt-3" style="background-color: #d4edda; border-color: #c3e6cb; color: #155724;">
                            <strong>INFORMASI</strong><br>Jika aset yang dimaksud tidak ada, tambahkan dahulu data aset pada menu data aset.
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
                            // $('#tgl_perolehan').val(aset.tgl_perolehan);
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
                // $('#tgl_perolehan').val('');
            }
        });
    </script>

    {{-- untuk edit keluar masuk --}}
    <script>
        $('#edit_aset').change(function() {
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
                            $('#edit_kategori_aset').val(aset.kategori_aset.kategori);
                            $('#edit_lokasi_penyimpanan').val(aset.lokasi_penyimpanan);
                            // $('#tgl_perolehan').val(aset.tgl_perolehan);
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
                $('#edit_kategori_aset').val('');
                $('#edit_lokasi_penyimpanan').val('');
                // $('#tgl_perolehan').val('');
            }
        });
    </script>

    <!-- Modal Tambah Pencatatan Faktur -->
    <div class="modal fade" id="TambahFakturModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Tambah Faktur</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <form id="fakturForm" enctype="multipart/form-data" method="POST" action="{{ route($role.'.keluar_masuk_aset.update', $keluar_masuk_aset->id_keluar_masuk_aset) }}">
                        @csrf
                        @method('PUT')

                        <!-- Jenis Radio Button -->
                        <div class="form-group mb-2">
                            <label ="font-weight-bold">Jenis</label>
                            <div class="d-flex mt-1">
                                <div class="form-check mr-3">
                                    <input class="form-check-input" type="radio" name="jenis" value="masuk" id="asetMasuk">
                                    <label class="form-check-label" for="asetMasuk">Aset Masuk</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jenis" value="keluar" id="asetKeluar" checked>
                                    <label class="form-check-label" for="asetKeluar">Aset Keluar</label>
                                </div>
                            </div>
                        </div>

                        <!-- Input Fields -->
                        <div class="form-group mb-2">
                            <label class="font-weight-bold" for="tgl">Tanggal</label>
                            <input type="date" class="form-control" id="tgl" name="tgl">
                        </div>

                        <div class="form-group mb-2" id="pemasok">
                            <label class="font-weight-bold" for="nama">Nama Pemasok</label>
                            <input type="text" class="form-control" id="nama" name="nama">
                        </div>

                        {{-- <div class="form-group mb-2" id="penerima">
                            <label class="font-weight-bold" for="keluar_nama_penerima">Nama Penerima</label>
                            <input type="text" class="form-control" id="keluar_nama_penerima" name="keluar_nama_penerima">
                        </div> --}}

                        <div class="form-group mb-2">
                            <label class="font-weight-bold" for="no_faktur">Nomor Faktur</label>
                            <input type="text" class="form-control" id="no_faktur" name="no_faktur">
                        </div>

                        <div class="form-group mb-2">
                            <label class="font-weight-bold" for="keterangan">Keterangan</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan">
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold" for="dokumentasi">Dokumentasi</label>
                            <input type="file" class="form-control" id="dokumentasi" name="dokumentasi" style="padding: 4px; align-items: center;">
                        </div>

                        <!-- Modal Footer -->
                        <div class="mt-3">
                            <button type="submit" class="btn btn-success w-100" style="padding: 8px 0; font-weight: bold;">Simpan</button>
                        </div>
                    </form>
                </div>
                {{-- script untuk mengubah tampilan berdasarkan radio button jenis pencatatan yang dipilih
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const asetMasuk = document.getElementById('asetMasuk');
                        const asetKeluar = document.getElementById('asetKeluar');
                        const pemasok = document.getElementById('pemasok');
                        const penerima = document.getElementById('penerima');

                        // Fungsi untuk mengatur tampilan berdasarkan radio button yang dipilih
                        function toggleInputFields() {
                            if (asetKeluar.checked) {
                                pemasok.hidden = true;
                                penerima.hidden = false;
                            } else if (asetMasuk.checked) {
                                pemasok.hidden = false;
                                penerima.hidden = true;
                            }
                        }
                        // Event listener untuk perubahan radio button
                        asetMasuk.addEventListener('change', toggleInputFields);
                        asetKeluar.addEventListener('change', toggleInputFields);

                        // Panggil fungsi saat halaman pertama kali dimuat untuk kondisi awal
                        toggleInputFields();

                    });
                </script> --}}
            </div>
        </div>
    </div>

    <!-- modal respon spv -->
    <div class="modal fade" id="responspvModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Respon SPV - Pencatatan Aset</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding-top: 0;">
                    <form id="responspvForm" method="POST"
                        action="{{ route($role . '.keluar_masuk_aset.update', $keluar_masuk_aset->id_keluar_masuk_aset) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="tanggal_pencatatan" style="font-weight: bold; font-size: 14px;">Tgl
                                Pencatatan</label>
                            <input type="date" class="form-control" id="tanggal_pencatatan"
                                name="tanggal_pencatatan" value="{{ $keluar_masuk_aset->tanggal_pencatatan }}"
                                style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;" readonly>
                        </div>
                        <div class="form-group">
                            <label for="kategori">Status SPV</label>
                            <select class="form-control" id="status_spv" name="status_spv"
                                onchange="toggleNewCategoryForm()">
                                <option value="">Pilih Status</option>
                                <option value="mengetahui" @if ($keluar_masuk_aset->status_spv == 'mengetahui') selected @endif>Mengetahui
                                </option>
                                <option value="belum" @if ($keluar_masuk_aset->status_spv == 'belum') selected @endif>Belum Mengetahui
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
                    <h5 class="modal-title" id="myModalLabel">Respon KC - Pencatatan Aset</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding-top: 0;">
                    <form method="POST"
                        action="{{ route($role . '.keluar_masuk_aset.update', $keluar_masuk_aset->id_keluar_masuk_aset) }}">
                    @csrf
                    @method('PUT')
                        <div class="form-group">
                            <label for="tgl_pencatatan" style="font-weight: bold; font-size: 14px;">Tgl
                                Pemeriksaan</label>
                            <input type="date" class="form-control" id="tgl_pencatatan"
                                value="{{ $keluar_masuk_aset->tgl_pencatatan }}"
                                style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;" readonly>
                        </div>
                        <div class="form-group">
                            <label for="tgl_respon" style="font-weight: bold; font-size: 14px;">Tgl Respon SPV</label>
                            <input type="date" class="form-control" id="tgl_mengetahui_spv" name="tgl_mengetahui_spv"
                                value="{{ $keluar_masuk_aset->tgl_mengetahui_spv }}"
                                style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;" readonly>
                        </div>
                        <div class="form-group">
                            <label for="catatan_spv" style="font-weight: bold; font-size: 14px;">Catatan SPV</label>
                            <input type="text" class="form-control" id="catatan_spv" name="catatan_spv"
                                value="{{ $keluar_masuk_aset->catatan_spv }}"
                                style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;" readonly>
                        </div>
                        <div class="form-group">
                            <label for="kategori">Status KC</label>
                            <select class="form-control" id="status_kc" name="status_kc" required
                                onchange="toggleNewCategoryForm()">
                                <option value="">Pilih Status</option>
                                <option value="mengetahui" @if ($keluar_masuk_aset->status_kc == 'mengetahui') selected @endif>Mengetahui
                                </option>
                                <option value="belum" @if ($keluar_masuk_aset->status_kc == 'belum') selected @endif>Belum Mengetahui
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
