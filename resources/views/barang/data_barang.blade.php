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
                            <a href="/{{ $role }}/dashboard">Dashboard</a> / <a>Data barang</a>
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
                                    <h5 class="d-flex">
                                        <b class="text-success pl-2">Data Barang<br>Logistik dan Perlengkapan</b>
                                    </h5>
                                    <div class="btn-group btn-block mb-2 mb-xl-3 card-tambah-barang" style="width:150px">
                                        <div class="btn-group  mb-2 mb-xl-0 btn-block">
                                            <button type="button" class="btn btn-success" data-toggle="modal"
                                                href="#tambahModal">
                                                <i class="fas fa-plus-circle"></i>
                                                <span>Tambah Barang</span>
                                            </button>
                                        </div>
                                    </div>
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
                                                <td>1</td>
                                                <td>Botol</td>
                                                <td>Pcs</td>
                                                <td>Gudang</td>
                                                <td>Baru</td>
                                                <td>Tanggal</td>
                                                <td>Tanggal</td>
                                                <td>210 pcs</td>
                                                <td>
                                                    <div class="btn-group btn-block mb-2 mb-xl-0 card_detail_barang">
                                                        <div class="btn-group mb-2 mb-xl-0 btn-block">
                                                            <a onclick="$('#cover-spin').show(0)"
                                                                href="/{{ $role }}/arsip/barang/detail"
                                                                class="btn btn-secondary btn-block" style="display: block;">
                                                                Detail Barang
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <div class="btn-group btn-block mb-2 mb-xl-0 card_kontrol_barang">
                                                        <div class="btn-group mb-2 mb-xl-0 btn-block">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-toggle="modal" href="#kontrolModal">
                                                                <span>Input Kontrol</span>
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <div class="btn-group btn-block mb-2 mb-xl-0 card_keluar_masuk_barang">
                                                        <div class="btn-group mb-2 mb-xl-0 btn-block">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-toggle="modal" href="#keluarModal">
                                                                <span>Input Keluar Masuk</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </td>
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
                    <form id="myForm">
                        <div class="form-group">
                            <label for="name">Nama :</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="form-group">
                            <label for="satuan">Satuan :</label>
                            <input type="text" class="form-control" id="satuan" name="satuan">
                        </div>
                        <div class="form-group">
                            <label for="lokasi">Lokasi Penyimpanan :</label>
                            <input type="text" class="form-control" id="lokasi" name="lokasi">
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
                    <form id="myForm">
                        <div class="form-group">
                            <label for="name">Nama :</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="form-group">
                            <label for="tanggal">Tanggal Kontrol :</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal">
                        </div>
                        <div class="form-group">
                            <label>Berfungsi :</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="berfungsiYa" name="totAwal"
                                    value="Ya">
                                <label class="form-check-label" for="berfungsiYa">Ya</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="berfungsiTidak" name="totAwal"
                                    value="Tidak">
                                <label class="form-check-label" for="berfungsiTidak">Tidak</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Kondisi :</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="kondisiBaik" name="keluar"
                                    value="Baik">
                                <label class="form-check-label" for="kondisiBaik">Baik</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="kondisiRusak" name="keluar"
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

@endsection
@endsection
