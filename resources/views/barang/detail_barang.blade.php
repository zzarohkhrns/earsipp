@extends('main')


@section('detail_barang', 'active menu-open')
@section('barang', 'menu-open')

@section('css')
@section('content')

    <style>
        .nav-tabs .nav-link {
            border: 1px solid transparent;
            border-top-left-radius: .25rem;
            border-top-right-radius: .25rem;
            color: green;
            /* Warna teks tab tidak aktif */
        }

        .nav-tabs .nav-link.active {
            color: black !important;
            /* Warna teks tab aktif */
        }

        .nav-tabs {
            width: 100%;
        }

        .tab-content {
            width: 100%;
        }
    </style>


    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb m-0 pl-4">
                        <li class="breadcrumb-item active">
                            <a href="/{{ $role }}/dashboard">Dashboard</a> / <a
                                href="/{{ $role }}/arsip/barang/data">Data Barang</a> / <a>Detail Barang</a>
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
                    <div class="card ijo-kiri">
                        <div class="card-body">
                            <div class="row card-detail-barang">
                                <div class="col-12">
                                    <table id="example3" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th style="width: 200px;"><b>Nama Barang</b></th>
                                                <th style="width: 200px;"><b>Satuan</b></th>
                                                <th style="width: 200px;"><b>Lokasi Barang</b></th>
                                                <th style="width: 100px;"></th>
                                                <th style="width: 100px;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>botol</td>
                                                <td>pcs</td>
                                                <td>gedung A lantai 2</td>
                                                <td>
                                                    <div class="btn-group btn-block mb-2 mb-xl-0 card_detail_barang">
                                                        <a class="btn btn-success intro-ubah-detail-barang ml-1 mr-0"
                                                            type="button" data-toggle="modal" data-target="#staticTambah"
                                                            aria-expanded="false">
                                                            &nbsp;&nbsp;<i class="fas fa-edit"></i> Edit
                                                        </a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-block mb-2 mb-xl-0 card_detail_barang">
                                                        <div class="btn-group mb-2 mb-xl-0 btn-block">
                                                            <a onclick="$('#cover-spin').show(0)"
                                                                href="/{{ $role }}/aksi_hapus_barang"
                                                                class="btn btn-danger btn-block" style="display: block;">
                                                                <i class="fas fa-trash"></i>
                                                                Hapus
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>Spesifikasi</b></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                    Dolore, deserunt? Minus dolores architecto nobis minima enim error fuga
                                                    ut quia!</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- tab menu kontrol dan keluar masuk barang --}}
            <div class="row">
                <div class="col-12">
                    <div class="card ijo-kiri">
                        <div class="card-body">
                            <div class="row card-kontrol-barang">
                                <div class="col-12">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="kontrol-barang-tab" data-toggle="tab"
                                                href="#kontrol-barang" role="tab" aria-controls="kontrol-barang"
                                                aria-selected="true">DATA KONTROL BARANG</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="keluar-masuk-barang-tab" data-toggle="tab"
                                                href="#keluar-masuk-barang" role="tab"
                                                aria-controls="keluar-masuk-barang" aria-selected="false">DATA KELUAR MASUK
                                                BARANG</a>
                                        </li>
                                    </ul>

                                    {{-- tab kontrol barang --}}
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="kontrol-barang" role="tabpanel"
                                            aria-labelledby="kontrol-barang-tab">
                                            <div class="card-body">
                                                <div class="row card-kontrol-barang">
                                                    <div class="col-12">
                                                        <div class="btn-group btn-block mb-2 mb-xl-3 card-tambah-kontrol"
                                                            style="width:150px">
                                                            <div class="btn-group mb-2 mb-xl-0 btn-block">
                                                                <button type="button" class="btn btn-success"
                                                                    data-toggle="modal" href="#kontrolModal">
                                                                    <i class="fas fa-plus-circle"></i>
                                                                    <span>Tambah</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="btn-group btn-block mb-2 mb-xl-4 card-tambah-kontrol"
                                                            style="width:150px">
                                                            <div class="btn-group mb-2 mb-xl-0 btn-block">
                                                                <a href="/{{ $role }}/print-kontrol"
                                                                    class="btn btn-primary">
                                                                    <i class="fi fi-rs-print"></i>Cetak PDF</a>
                                                            </div>
                                                        </div>
                                                        <table id="example3" class="table table-bordered"
                                                            style="width:100%">
                                                            <thead>
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
                                                                    <td>1</td>
                                                                    <td>Halin Fajar Waskitho</td>
                                                                    <td>12-07-2024</td>
                                                                    <td>Ya</td>
                                                                    <td>Baik</td>
                                                                    <td>Ini keterangan kontrol</td>
                                                                    <td>Mengetahui</td>
                                                                    <td>
                                                                        <div
                                                                            class="btn-group btn-block mb-2 mb-xl-0 card_detail_barang">
                                                                            <a class="btn btn-secondary intro-ubah-detail-barang ml-1 mr-0"
                                                                                type="button" data-toggle="modal"
                                                                                data-target="#staticTambah"
                                                                                aria-expanded="false">
                                                                                &nbsp;&nbsp;<i class="fas fa-edit"></i> Edit
                                                                            </a>
                                                                        </div>
                                                                        <div
                                                                            class="btn-group btn-block mb-2 mb-xl-0 card_detail_barang">
                                                                            <div class="btn-group mb-2 mb-xl-0 btn-block">
                                                                                <a onclick="$('#cover-spin').show(0)"
                                                                                    href="/{{ $role }}/aksi_hapus_barang"
                                                                                    class="btn btn-secondary btn-block"
                                                                                    style="display: block;">
                                                                                    <i class="fas fa-trash"></i> Hapus
                                                                                </a>
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

                                        {{-- tab keluar masuk barang --}}
                                        <div class="tab-pane fade" id="keluar-masuk-barang" role="tabpanel"
                                            aria-labelledby="keluar-masuk-barang-tab">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="btn-group btn-block mb-2 mb-xl-3 card-tambah-kontrol"
                                                            style="width:150px">
                                                            <div class="btn-group mb-2 mb-xl-0 btn-block">
                                                                <button type="button" class="btn btn-success"
                                                                    data-toggle="modal" href="#keluarModal">
                                                                    <i class="fas fa-plus-circle"></i>
                                                                    <span>Tambah</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="btn-group btn-block mb-2 mb-xl-4 card-tambah-kontrol"
                                                            style="width:150px">
                                                            <div class="btn-group mb-2 mb-xl-0 btn-block">
                                                                <a href="/{{ $role }}/print-keluar"
                                                                    class="btn btn-primary">
                                                                    <i class="fi fi-rs-print"></i>Cetak PDF</a>
                                                            </div>
                                                        </div>
                                                        <table id="example3" class="table table-bordered"
                                                            style="width:100%">
                                                            <thead>
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
                                                                    <td>1</td>
                                                                    <td>Halin Fajar Waskitho</td>
                                                                    <td>12-07-2024</td>
                                                                    <td>100</td>
                                                                    <td>0</td>
                                                                    <td>110</td>
                                                                    <td>Ini keterangan kontrol</td>
                                                                    <td>Mengetahui</td>
                                                                    <td>
                                                                        <div
                                                                            class="btn-group btn-block mb-2 mb-xl-0 card_detail_barang">
                                                                            <a class="btn btn-secondary intro-ubah-detail-barang ml-1 mr-0"
                                                                                type="button" data-toggle="modal"
                                                                                data-target="#staticTambah"
                                                                                aria-expanded="false">
                                                                                &nbsp;&nbsp;<i class="fas fa-edit"></i>
                                                                                Edit
                                                                            </a>
                                                                        </div>
                                                                        <div
                                                                            class="btn-group btn-block mb-2 mb-xl-0 card_detail_barang">
                                                                            <div class="btn-group mb-2 mb-xl-0 btn-block">
                                                                                <a onclick="$('#cover-spin').show(0)"
                                                                                    href="/{{ $role }}/aksi_hapus_barang"
                                                                                    class="btn btn-secondary btn-block"
                                                                                    style="display: block;">
                                                                                    <i class="fas fa-trash"></i> Hapus
                                                                                </a>
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

@endsection
@endsection
