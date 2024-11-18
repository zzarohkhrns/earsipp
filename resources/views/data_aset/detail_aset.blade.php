@extends('main')


@section('data_barang', 'active menu-open')
@section('barang', 'menu-open')

@section('css')
@section('content')

    <style>
        .dropdown select {
            border-radius: 5px;
            width: 100px;
            padding: 10px;
            margin: 5px 0;
            font-size: 12px;
            background-color: white;
            border: 1px solid gray;
        }

        .nav-tabs .nav-link {
            border: 1px solid transparent;
            border-top-left-radius: .25rem;
            border-top-right-radius: .25rem;
            color: black;
            font-size: 16px;
            /* Warna teks tab tidak aktif */
        }

        .nav-tabs .nav-link.active {
            color: green !important;
            /* Warna teks tab aktif */
        }

        .nav-tabs {
            width: 100%;
        }

        .tab-content {
            width: 100%;
        }

        @media (max-width: 768px) {
            .table-responsive.d-flex {
                flex-direction: column;
            }

            .d-flex.justify-content-end {
                margin-top: 10px;
            }
        }
    </style>


    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb m-0 pl-4">
                        <li class="breadcrumb-item active">
                            <a href="/{{ $role }}/dashboard">Dashboard</a> / <a
                                href="/{{ $role }}/arsip/aset/data">Data Aset</a> / <a>Detail Aset</a>
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
                            <div class="row card-detail-barang">
                                <div class="table-responsive d-flex justify-content-between align-items-start">
                                    <!-- Div tabel -->
                                    <div class="table-responsive" style="flex-grow: 1;">
                                        <table id="example3" style="width:100%">
                                            {{-- Line 1 --}}
                                            <tr>
                                                <th style="width: 200px;"><b style="font-size:16px;">Kode Aset</b></th>
                                                <th style="width: 200px;"></th>
                                                <th style="width: 200px;"></th>
                                            </tr>
                                            <tr>
                                                <th style="width: 200px;" class="text-success">
                                                    <b style="font-size:19px;">{{ $aset->kode_aset ?? '0' }}</b>
                                                </th>
                                                <th style="width: 200px;"></th>
                                                <th style="width: 200px;"></th>
                                            </tr>

                                            {{-- Line 2 --}}
                                            <tr>
                                                <th style="width: 200px;"><b style="font-size:16px;">Nama Barang</b></th>
                                                <th style="width: 200px;"><b style="font-size:16px;">Kategori</b></th>
                                                <th style="width: 200px;"></th>
                                            </tr>
                                            <tr>
                                                <td>{{ $aset->nama_aset ?? '0' }}</td>
                                                <td>{{ $aset->kategori_aset->kategori ?? '0' }}</td>
                                                <td></td>
                                            </tr>

                                            {{-- Line 3 --}}
                                            <tr>
                                                <th style="width: 200px;"><b style="font-size:16px;">Tanggal Pembelian</b>
                                                </th>
                                                <th style="width: 200px;"><b style="font-size:16px;">Satuan</b></th>
                                                <th style="width: 200px;"></th>
                                            </tr>
                                            <tr>
                                                <td>{{ $aset->tgl_perolehan ?? '0' }}</td>
                                                <td>{{ $aset->satuan ?? '0' }}</td>
                                                <td></td>
                                            </tr>

                                            {{-- Line 4 --}}
                                            <tr>
                                                <th style="width: 200px;"><b style="font-size:16px;">Asal Perolehan</b></th>
                                                <th style="width: 200px;"><b style="font-size:16px;">Lokasi Penyimpanan</b>
                                                </th>
                                                <th style="width: 200px;"></th>
                                            </tr>
                                            <tr>
                                                <td>{{ $aset->asal_perolehan ?? 'tidak ada asal perolehan' }}</td>
                                                <td>{{ $aset->lokasi_penyimpanan ?? '0' }}</td>
                                                <td></td>
                                            </tr>

                                            {{-- Line 5 --}}
                                            <tr>
                                                <td><b style="font-size:16px;">Spesifikasi</b></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">{{ $aset->spesifikasi ?? '0' }}</td>
                                            </tr>
                                        </table>
                                    </div>

                                    <!-- Div tombol -->
                                    <div class="d-flex justify-content-end mb-2 mb-xl-0">
                                        <div class="btn-group">
                                            <button class="btn btn-success intro-ubah-detail-aset ml-1 mr-2 edit-aset"
                                                type="button" data-toggle="modal" data-target="#ubahasetModal"
                                                style="width: 160px; border-radius:10px; font-size:12px;background-color: #28a745;color: white;"
                                                aria-expanded="false">
                                                &nbsp;&nbsp;<i class="fas fa-edit"></i> Edit
                                            </button>
                                            <form action="/{{ $role }}/aset/data/delete/{{ $aset->aset_id }}"
                                                method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                @csrf
                                                <button type="submit" class="btn btn-danger"
                                                    style="display: block; border-radius:10px; width: 160px;font-size:12px;">
                                                    <i class="fas fa-trash"></i>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- tab menu pemeriksaan, keluar masuk barang, dan penyusutan nilai --}}
            <div class="row">
                <div class="col-12">
                    <div class="card ijo-atas">
                        <div class="card-body">
                            <div class="row card-kontrol-barang">
                                <div class="col-12">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="kontrol-aset-tab" data-toggle="tab"
                                                href="#kontrol-aset" role="tab" aria-controls="kontrol-aset"
                                                aria-selected="true">Riwayat Pemeriksaan</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="keluar-masuk-tab" data-toggle="tab" href="#keluar-masuk"
                                                role="tab" aria-controls="keluar-masuk" aria-selected="false">Riwayat
                                                Keluar Masuk</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="penyusutan-nilai-tab" data-toggle="tab"
                                                href="#penyusutan-nilai" role="tab" aria-controls="penyusutan-nilai"
                                                aria-selected="false">Penyusutan Nilai</a>
                                        </li>
                                    </ul>

                                    {{-- tab pemeriksaan --}}
                                    <div class="tab-content" id="TabContent">
                                        <div class="tab-pane fade show active" id="kontrol-aset" role="tabpanel"
                                            aria-labelledby="kontrol-aset-tab">
                                            <div class="card-body">
                                                <div class="row card-kontrol-aset">
                                                    @if ($aset->detailPemeriksaanAset->isNotEmpty())
                                                        <div
                                                            style="display: flex; justify-content: end; width: 100%; margin-bottom: 10px">
                                                            <a target="_blank"
                                                                href="{{ route($role . '.export-detail-aset', $aset->aset_id) }}">
                                                                <button class="btn btn-warning"
                                                                    id="exportRiwayatPemeriksaan"
                                                                    style="width: 150px;padding: 5px; color: white;rounded: 10px; font-size: 13px;"
                                                                    {{-- onClick="window.location.href='/{{ $role }}/print-riwayat-pemeriksaan/{{ $aset->aset_id }}'"> --}}>
                                                                    Export
                                                                </button>
                                                            </a>
                                                        </div>
                                                    @endif

                                                    <div class="table-responsive">
                                                        <table id="kontrolAset" class="table table-bordered"
                                                            style="width:100%; font-size: 13px;">
                                                            <thead style="text-align: center; font-size: 16px;">
                                                                <tr>
                                                                    <th>No.</th>
                                                                    <th>Tanggal</th>
                                                                    <th>Kondisi</th>
                                                                    <th>Status</th>
                                                                    <th>Keterangan</th>
                                                                    <th>Status SPV</th>
                                                                    <th>Status KC</th>
                                                                    {{-- <th style="width: 100px;">Aksi</th> --}}
                                                                </tr>
                                                            </thead>
                                                            <tbody style="font-size: 13px;">
                                                                @if ($detailPemeriksaan->isNotEmpty())
                                                                    @php
                                                                        $no = 1;
                                                                    @endphp
                                                                    @foreach ($detailPemeriksaan as $item)
                                                                        <tr>
                                                                            <td>{{ $no++ }}</td>
                                                                            <td>{{ $item->pemeriksaanAset->tanggal_pemeriksaan }}
                                                                            </td>
                                                                            <td>{{ $item->kondisi }}</td>
                                                                            @if ($item->status_aset == 'aktif')
                                                                                <td class="text-success">Aktif</td>
                                                                            @else
                                                                                <td class="text-danger">Non aktif</td>
                                                                            @endif
                                                                            <td><b>Masalah :</b>
                                                                                <br>{{ $item->masalah_teridentifikasi }}
                                                                                <br> <b>Tindakan :</b> <br>
                                                                                {{ $item->tindakan_diperlukan }}</td>
                                                                            <td><b>Mengetahui :</b> <br>
                                                                                {{ $item->pemeriksaanAset->tgl_mengetahui_spv ?? '-' }}
                                                                                <br> <b>Catatan :</b> <br>
                                                                                {{ $item->pemeriksaanAset->catatan_spv }}
                                                                            </td>
                                                                            <td><b>Mengetahui :</b> <br>
                                                                                {{ $item->pemeriksaanAset->tgl_mengetahui_kc ?? '-' }}
                                                                                <br> <b>Catatan :</b> <br>
                                                                                {{ $item->pemeriksaanAset->catatan_kc }}
                                                                            </td>
                                                                            {{-- <td>
                                                                                <div
                                                                                    class="d-flex flex-column align-items-center">
                                                                                    <div class="dropdown">
                                                                                        <select id="options"
                                                                                            name="options"
                                                                                            style="padding: 2px 2px; height: auto; font-size: 12px; line-height: 1.2;">
                                                                                            <option hidden="true"
                                                                                                style="background-color: white;"
                                                                                                value="">Kelola
                                                                                            </option>
                                                                                            <option
                                                                                                style="background-color: white;"
                                                                                                value="/{{ $role }}/arsip/aset/detail_pemeriksaan/{{ $item->pemeriksaanAset->id_pemeriksaan_aset }}/{{ $item->pemeriksaanAset->tanggal_pemeriksaan }}">
                                                                                                Detail</option>
                                                                                            <option
                                                                                                style="background-color: white;"
                                                                                                value="/{{ $role }}/print-data">
                                                                                                Export</option>
                                                                                        </select>
                                                                                    </div>

                                                                                    <script>
                                                                                        document.getElementById('options').addEventListener('change', function() {
                                                                                            var value = this.value;
                                                                                            if (value) {
                                                                                                window.location.href = value;
                                                                                            }
                                                                                        });
                                                                                    </script>
                                                                                </div>
                                                                            </td> --}}
                                                                        </tr>
                                                                    @endforeach
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- tab keluar masuk barang --}}
                                        <div class="tab-pane fade" id="keluar-masuk" role="tabpanel"
                                            aria-labelledby="keluar-masuk-tab">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="table-responsive">
                                                        <table id="keluarMasuk" class="table table-bordered"
                                                            style="width:100%; font-size: 13px;">
                                                            <thead style="text-align: center; font-size: 16px;">
                                                                <tr>
                                                                    <th style="width: 5%;">No</th>
                                                                    <th style="width: 15%;">Tgl Pencatatan</th>
                                                                    <th style="width: 20%;">Aset Masuk</th>
                                                                    <th style="width: 20%;">Aset Keluar</th>
                                                                    <th style="width: 15%;">Status SPV</th>
                                                                    <th style="width: 15%;">Status KC</th>
                                                                    {{-- <th style="width: 10%;">Aksi</th> --}}
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($keluar_masuk_aset as $keluar_masuk)
                                                                    <tr>
                                                                        <td>
                                                                            {{ $loop->iteration }}
                                                                        </td>
                                                                        <td>
                                                                            <table
                                                                                style="border-collapse: collapse; width: 100%; margin: 0;">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td
                                                                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 2px;">
                                                                                            <b>{{ $keluar_masuk->tanggal_pencatatan }}</b>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td
                                                                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 2px;">
                                                                                            <b>{{ $keluar_masuk->pencatat->pengguna->nama ?? '' }}</b>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td
                                                                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 2px;">
                                                                                            {{ $keluar_masuk->pencatat->PengurusJabatan->jabatan ?? '' }}
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                        <td>
                                                                            <table
                                                                                style="border-collapse: collapse; width: 100%; margin: 0;">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td
                                                                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 2px;width: 50%;">
                                                                                            No Faktur</td>
                                                                                        <td
                                                                                            style="text-align: right;border: none;font-size: 13px; line-height: 1.2; padding: 2px;width: 50%;">
                                                                                            <b>{{ !empty($keluar_masuk->masuk_no_faktur) ? $keluar_masuk->masuk_no_faktur : '-' }}</b>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td
                                                                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 2px;width: 50%;">
                                                                                            Pemasok</td>
                                                                                        <td
                                                                                            style="text-align: right;border: none;font-size: 13px; line-height: 1.2; padding: 2px;width: 50%;">
                                                                                            <b>{{ !empty($keluar_masuk->masuk_nama_pemasok) ? $keluar_masuk->masuk_nama_pemasok : '-' }}</b>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td
                                                                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 2px;width: 50%;">
                                                                                            Total Kuantitas</td>
                                                                                        <td
                                                                                            style="text-align: right;border: none;font-size: 13px; line-height: 1.2; padding: 2px;width: 50%;">
                                                                                            <b>Total Kuantitas</b>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td colspan="2"
                                                                                            style="border: none; font-size: 13px; line-height: 1.2; padding: 2px;">
                                                                                            {{ $keluar_masuk->masuk_keterangan }}
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                        <td>
                                                                            <table
                                                                                style="border-collapse: collapse; width: 100%; margin: 0;">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td
                                                                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 2px;width: 50%;">
                                                                                            No Faktur</td>
                                                                                        <td
                                                                                            style="text-align: right;border: none;font-size: 13px; line-height: 1.2; padding: 2px;width: 50%;">
                                                                                            <b>{{ !empty($keluar_masuk->keluar_no_faktur) ? $keluar_masuk->keluar_no_faktur : '-' }}</b>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td
                                                                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 2px;width: 50%;">
                                                                                            Penerima</td>
                                                                                        <td
                                                                                            style="text-align: right;border: none;font-size: 13px; line-height: 1.2; padding: 2px;width: 50%;">
                                                                                            <b>{{ !empty($keluar_masuk->keluar_nama_penerima) ? $keluar_masuk->keluar_nama_penerima : '-' }}</b>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td
                                                                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 2px;width: 50%;">
                                                                                            Total Kuantitas</td>
                                                                                        <td
                                                                                            style="text-align: right;border: none;font-size: 13px; line-height: 1.2; padding: 2px;width: 50%;">
                                                                                            <b>Total Kuantitas</b>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td colspan="2"
                                                                                            style="border: none; font-size: 13px; line-height: 1.2; padding: 2px;">
                                                                                            {{ $keluar_masuk->keluar_keterangan }}
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                        <td>
                                                                            <table
                                                                                style="border-collapse: collapse; width: 100%; margin: 0;">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td
                                                                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 2px;">
                                                                                            @if ($keluar_masuk->status_spv == 'mengetahui')
                                                                                                <div class="text-success">Mengetahui
                                                                                                </div>
                                                                                            @else
                                                                                                <div class="text-danger">Belum
                                                                                                    Mengetahui
                                                                                                </div>
                                                                                            @endif
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td
                                                                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 2px;">
                                                                                            {{ !empty($keluar_masuk->catatan_spv) ? $keluar_masuk->catatan_spv : '-' }}
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td
                                                                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 2px;">
                                                                                            <b>{{ $keluar_masuk->supervisor->pengguna->nama }}</b>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td
                                                                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 2px;">
                                                                                            {{ $keluar_masuk->supervisor->pengurusJabatan->jabatan }}
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                        <td>
                                                                            <table
                                                                                style="border-collapse: collapse; width: 100%; margin: 0;">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td
                                                                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 2px;">
                                                                                            @if ($keluar_masuk->status_kc == 'mengetahui')
                                                                                                <div class="text-success">Mengetahui
                                                                                                </div>
                                                                                            @else
                                                                                                <div class="text-danger">Belum
                                                                                                    Mengetahui
                                                                                                </div>
                                                                                            @endif
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td
                                                                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 2px;">
                                                                                            {{ !empty($keluar_masuk->catatan_kc) ? $keluar_masuk->catatan_kc : '-' }}
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td
                                                                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 2px;">
                                                                                            <b>{{ $keluar_masuk->kc->pengguna->nama }}</b>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td
                                                                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 2px;">
                                                                                            {{ $keluar_masuk->kc->pengurusJabatan->jabatan }}
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                        {{-- <td>
                                                                            <div>
                                                                                <a href="{{ route($role . '.detail_keluar_masuk_aset', $keluar_masuk->id_keluar_masuk_aset) }}"
                                                                                    style="display: inline-block; width: 100px; padding: 8px; border: 1px solid #ccc; text-align: center; text-decoration: none; color: #333; font-weight: bold; margin-bottom: 8px; border-radius: 4px;">
                                                                                    Detail
                                                                                </a>
                                                                                <a href="{{ route($role . '.exportPdfDetailKeluarMasuk') }}"
                                                                                    style="display: inline-block; width: 100px; padding: 8px; border: 1px solid #ccc; text-align: center; text-decoration: none; color: #333; font-weight: bold; border-radius: 4px;">
                                                                                    Cetak PDF
                                                                                </a>
                                                                            </div>
                                                                        </td> --}}
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- tab penyusutan nilai --}}
                                        <div class="tab-pane fade" id="penyusutan-nilai" role="tabpanel"
                                            aria-labelledby="penyusutan-nilai-tab">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="table-responsive">
                                                        <table id="penyusutanNilai" class="table table-bordered"
                                                            style="width:100%; font-size: 13px;">
                                                            <thead style="text-align: center; font-size: 16px;">
                                                                <tr>
                                                                    <th>No</th>
                                                                    <th>Tgl Pemeriksaan</th>
                                                                    <th>Kondisi</th>
                                                                    <th>Status</th>
                                                                    <th>Masalah Teridentifikasi</th>
                                                                    <th>Tindakan Yang Diperlukan</th>
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
                                                                </tr>
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
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="form-group">
                            <label for="tanggal">Tanggal Input :</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal">
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

    {{-- modal ubah aset --}}
    <div class="modal fade" id="ubahasetModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Ubah Data Aset</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="myForm" method="POST"
                        action="/{{ $role }}/aset/data/update/{{ $aset->aset_id ?? '0' }}">
                        @csrf
                        <div class="form-group">
                            <label for="kode">Kode Aset :</label>
                            <input type="text" value="{{ $aset->aset_id ?? '0' }}" class="form-control"
                                id="aset_id" name="aset_id" hidden>
                            <input type="text" value="{{ $aset->kode_aset ?? '0' }}" class="form-control"
                                id="kode_aset" name="kode_aset" readonly>
                        </div>
                        <div class="form-group">
                            <label for="tgl_beli">Tgl Perolehan :</label>
                            <input type="date" value="{{ $aset->tgl_perolehan ?? '-' }}" class="form-control"
                                id="tgl_perolehan" name="tgl_perolehan">
                        </div>
                        <div class="form-group">
                            <label for="asal">Asal Perolehan :</label>
                            <input type="text" class="form-control" value="{{ $aset->asal_perolehan ?? '-' }}"
                                id="asal_perolehan" name="asal_perolehan">
                        </div>
                        <div class="form-group">
                            <label for="name">Nama :</label>
                            <input type="text" class="form-control" value="{{ $aset->nama_aset ?? '-' }}"
                                id="nama_aset" name="nama_aset">
                        </div>
                        <div class="form-group">
                            <label for="kategori">Kategori :</label>
                            <select class="form-control" id="kategori" name="kategori"
                                onchange="toggleNewCategoryForm()">
                                @foreach ($kategori as $kat)
                                    <option value="{{ $kat->id_kategori ?? '-' }}"
                                        @if ($aset->id_kategori == $kat->id_kategori) selected @endif>
                                        {{ $kat->kategori ?? '-' }}</option>
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
                            <input type="text" class="form-control" value="{{ $aset->satuan ?? '-' }}"
                                id="satuan" name="satuan">
                        </div>
                        <div class="form-group">
                            <label for="lokasi">Lokasi Penyimpanan :</label>
                            <input type="text" class="form-control" id="lokasi"
                                value="{{ $aset->lokasi_penyimpanan ?? '-' }}" name="lokasi_penyimpanan">
                        </div>
                        <div class="form-group">
                            <label for="spesifikasi">Spesifikasi/Deskripsi :</label>
                            <input type="text" class="form-control" value="{{ $aset->spesifikasi ?? '-' }}"
                                id="spesifikasi" name="spesifikasi">
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const editButtons = document.querySelectorAll('.edit-barang');

            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const namaBarang = this.getAttribute('data-nama-barang');
                    const satuanBarang = this.getAttribute('data-satuan');
                    const lokasiPenyimpanan = this.getAttribute('data-lokasi-penyimpanan');
                    const spesifikasi = this.getAttribute('data-spesifikasi');

                    document.querySelector('#edittambahModal input[name="nama"]').value =
                        namaBarang;
                    document.querySelector('#edittambahModal input[name="satuan"]').value =
                        satuanBarang;
                    document.querySelector('#edittambahModal input[name="lokasi_penyimpanan"]')
                        .value = lokasiPenyimpanan;
                    document.querySelector('#edittambahModal input[name="spesifikasi"]').value =
                        spesifikasi;
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
        $(document).ready(function() {
            // Inisialisasi DataTables untuk setiap tabel
            function initDataTables() {
                $('#kontrolAset').DataTable();
                $('#keluarMasuk').DataTable();
                $('#penyusutanNilai').DataTable();
            }

            // Fungsi untuk membuka tab dan menginisialisasi DataTables
            function openTab(tabId) {
                // Sembunyikan semua konten tab
                var contents = document.getElementsByClassName('tab-pane');
                for (var i = 0; i < contents.length; i++) {
                    contents[i].classList.remove('show', 'active');
                }

                // Tampilkan konten tab yang dipilih
                document.getElementById(tabId).classList.add('show', 'active');

                // Inisialisasi DataTables jika tab adalah 'kontrol-aset'
                if (tabId === 'kontrol-aset') {
                    $('#kontrolAset').DataTable();
                }
                if (tabId === 'keluar-masuk') {
                    $('#keluarMasuk').DataTable();
                }
                if (tabId === 'penyusutan-nilai') {
                    $('#penyusutanNilai').DataTable();
                }
            }

            // Inisialisasi tab pertama atau tab yang diatur oleh query parameter
            window.onload = function() {
                const urlParams = new URLSearchParams(window.location.search);
                const activeTab = urlParams.get('tab') || 'kontrol-aset'; // Default tab is kontrol-aset
                openTab(activeTab);
            }

            // Event listener untuk tab change
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var target = $(e.target).attr("href").substr(1);
                openTab(target);
            });

            // Inisialisasi DataTables pada halaman load
            initDataTables();
        });
    </script>
@endsection

@endsection
@endsection
