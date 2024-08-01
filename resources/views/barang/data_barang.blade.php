@extends('main')


@section('data_barang', 'active menu-open')
@section('barang', 'menu-open')

@section('css')
@section('content')


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
                                            <a onclick="$('#cover-spin').show(0)"
                                                href="/{{ $role }}/arsip/barang/data"
                                                class="btn btn-success btn-block mt-2" style="width:150px;">Data Aset</a>
                                            <a onclick="$('#cover-spin').show(0)"
                                                href="/{{ $role }}/arsip/barang/data"
                                                class="btn btn-light btn-block ml-2" style="width:150px;">Pemeriksaan</a>
                                            <a onclick="$('#cover-spin').show(0)"
                                                href="/{{ $role }}/arsip/barang/data"
                                                class="btn btn-light btn-block ml-2" style="width:150px;">Keluar Masuk</a>
                                            <a onclick="$('#cover-spin').show(0)"
                                                href="/{{ $role }}/arsip/barang/data"
                                                class="btn btn-light btn-block ml-2" style="width:150px;">Penyusutan
                                                Nilai</a>
                                        </div>
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


                                    <!-- Menu untuk filter -->
                                    <div
                                        style="border: 1px solid #e0e0e0; border-radius: 5px; background-color: #f9f9f9; padding: 10px; margin-bottom: 10px;">
                                        <!-- Bagian Filter dan Tombol Aksi -->
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <div
                                                style="display: flex; align-items: center; flex-wrap: wrap; max-width: 70%;">
                                                <!-- Filter Tanggal Pembelian -->
                                                <div style="display: flex; align-items: center; margin-right: 15px;">
                                                    <label for="tgl-pembelian"
                                                        style="font-size: 0.9em; margin-right: 5px;">Tgl Pembelian:</label>
                                                    <input type="date" id="tgl-pembelian-start"
                                                        name="tgl-pembelian-start"
                                                        style="padding: 5px; border: 1px solid #ced4da; border-radius: 5px; outline: none; width: 150px; margin-right: 5px;">
                                                    <span style="margin: 0 5px;">-</span>
                                                    <input type="date" id="tgl-pembelian-end" name="tgl-pembelian-end"
                                                        style="padding: 5px; border: 1px solid #ced4da; border-radius: 5px; outline: none; width: 150px;">
                                                </div>

                                                <!-- Filter Kategori -->
                                                <div style="display: flex; align-items: center; margin-right: 15px;">
                                                    <label for="kategori"
                                                        style="font-size: 0.9em; margin-right: 5px;">Kategori:</label>
                                                    <select id="kategori" name="kategori"
                                                        style="padding: 5px; border: 1px solid #ced4da; border-radius: 5px; outline: none; width: 150px;">
                                                        <option value="semua">Semua</option>
                                                        <option value="kategori1">Kategori 1</option>
                                                        <option value="kategori2">Kategori 2</option>
                                                        <!-- Tambahkan lebih banyak opsi sesuai kebutuhan -->
                                                    </select>
                                                </div>

                                                <!-- Filter Status -->
                                                <div style="display: flex; align-items: center; margin-right: 15px;">
                                                    <label for="status"
                                                        style="font-size: 0.9em; margin-right: 5px;">Status:</label>
                                                    <select id="status" name="status"
                                                        style="padding: 5px; border: 1px solid #ced4da; border-radius: 5px; outline: none; width: 150px;">
                                                        <option value="semua">Semua</option>
                                                        <option value="status1">Status 1</option>
                                                        <option value="status2">Status 2</option>
                                                        <!-- Tambahkan lebih banyak opsi sesuai kebutuhan -->
                                                    </select>
                                                </div>

                                                <!-- Tombol Refresh -->
                                                <div>
                                                    <button class="btn btn-outline-secondary" ><i class="fas fa-sync-alt"></i></button>
                                                </div>
                                            </div>

                                            <!-- Tombol Aksi -->
                                            <div
                                                style="display: flex; flex-direction: column; align-items: center; margin-left: 20px;">
                                                <div class="btn-group btn-block mb-2 mb-xl-0 mt-1card-tambah-barang"
                                                    style="width:150px; margin-bottom: 10px;">
                                                    <div class="btn-group mb-2 mb-xl-0 btn-block">
                                                        <button type="button" class="btn btn-success" data-toggle="modal"
                                                            href="#tambahModal">
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
                                        <div>
                                            <p style="margin: 0;"><b>&#9432</b> Data Aset PC Lazarus Cilacap. Dapat
                                                ditambahkan oleh Staff Logistik dan Perlengkapan.</p>
                                        </div>
                                    </div>

                                </div>

                                <!-- Table barang -->
                                <table id="example3" class="table table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>Nama Barang</th>
                                            <th>Satuan</th>
                                            <th>Lokasi Penyimpanan</th>
                                            <th>Spesifikasi</th>
                                            <th>Kontrol Barang</th>
                                            <th>Keluar Masuk</th>
                                            <th>Sisa Barang</th>
                                            <th style="width: 200px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            @foreach ($barang as $data)
                                                <td>{{ $loop->iteration }}</td>
                                                <td name="brg_id" hidden>{{ $data->id_barang }}</td>
                                                <td name='brg_nama'>{{ $data->nama }}</td>
                                                <td>{{ $data->satuan }}</td>
                                                <td>{{ $data->lokasi_penyimpanan }}</td>
                                                <td>{{ $data->spesifikasi }}</td>
                                                <td style="">
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
                                                <td>
                                                    @if ($data->latestKeluarMasukBarang)
                                                        {{ $data->latestKeluarMasukBarang->jumlah_sisa }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-block mb-2 mb-xl-0 card_detail_barang">
                                                        <div class="btn-group mb-2 mb-xl-0 btn-block">
                                                            <a onclick="$('#cover-spin').show(0)"
                                                                href="/{{ $role }}/arsip/barang/detail/{{ $data->id_barang }}"
                                                                class="btn btn-outline-secondary btn-block"
                                                                style="display: block;">
                                                                Detail Barang
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <div class="btn-group btn-block mb-2 mb-xl-0 card_kontrol_barang">
                                                        <div class="btn-group mb-2 mb-xl-0 btn-block">
                                                            <button type="button" class="btn btn-outline-secondary input-kontrol"
                                                                data-id-barang="{{ $data->id_barang }}"
                                                                data-nama-barang="{{ $data->nama }}"
                                                                data-toggle="modal" data-target="#kontrolModal">
                                                                <span>Input Kontrol</span>
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <div class="btn-group btn-block mb-2 mb-xl-0 card_keluar_masuk_barang">
                                                        <div class="btn-group mb-2 mb-xl-0 btn-block">
                                                            <button type="button" class="btn btn-outline-secondary"
                                                                data-toggle="modal" data-target="#keluarModal"
                                                                data-id-barang="{{ $data->id_barang }}"
                                                                data-nama-barang="{{ $data->nama }}">
                                                                <span>Input Keluar Masuk</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
                    <form id="myForm" method="POST" action="{{ route('pc.barang.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama :</label>
                            <input type="text" class="form-control" id="name" name="nama">
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
                    <form id="myForm" method="POST" action="{{ route('pc.kontrol.store') }}">
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
                    document.querySelector('#kontrolModal input[name="id_barang"]').value =idBarang;
                });
            });
        });
    </script>

@endsection
@endsection
