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
                                                {{-- <td>{{ $barang->nama }}</td>
                                                <td>{{ $barang->satuan }}</td>
                                                <td>{{ $barang->lokasi_penyimpanan }}</td> --}}
                                                <td>Laptop Asus</td>
                                                <td>pcs</td>
                                                <td>Ruang Staff</td>
                                                <td>
                                                    <div class="btn-group btn-block mb-2 mb-xl-0 card_edit_barang">
                                                        <a class="btn btn-success intro-ubah-detail-barang ml-1 mr-0 edit-barang"
                                                            type="button" data-toggle="modal" data-target="#edittambahModal"
                                                            aria-expanded="false"
                                                            {{-- data-nama-barang="{{ $barang->nama }}" data-satuan="{{ $barang->satuan }}"
                                                            data-lokasi-penyimpanan="{{ $barang->lokasi_penyimpanan }}"
                                                            data-spesifikasi="{{ $barang->spesifikasi }}" --}}
                                                            >
                                                            &nbsp;&nbsp;<i class="fas fa-edit"></i> Edit
                                                        </a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-block mb-2 mb-xl-0 card_hapus_barang">
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
                                                {{-- <td colspan="4">{{ $barang->spesifikasi }}</td> --}}
                                                <td colspan="4">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsa rem optio labore cupiditate dolore corrupti soluta. Vel, illo, tempore aut assumenda laboriosam possimus non omnis maiores provident consequuntur iste. Aspernatur.</td>
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
                                                aria-controls="keluar-masuk-barang" aria-selected="false">DATA KELUAR MASUK BARANG</a>
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
                                                                    class="btn btn-outline-secondary">
                                                                    <i class="fi fi-ss-print"></i>Cetak PDF</a>
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
                                                                    {{-- @foreach ($barang->kontrolBarang as $data)
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>Halin Fajar Waskitho</td>
                                                                    <td>{{ $data->tanggal_kontrol }}</td>
                                                                    <td>{{ $data->berfungsi }}</td>
                                                                    <td>{{ $data->kondisi }}</td>
                                                                    <td>{{ $data->keterangan }}</td>
                                                                    <td>{{ $data->status_kc }}</td>
                                                                    <td>
                                                                        <div
                                                                            class="btn-group btn-block mb-2 mb-xl-0 card_detail_barang">
                                                                            <a class="btn btn-outline-secondary intro-ubah-detail-barang ml-1 mr-0"
                                                                                type="button" data-toggle="modal"
                                                                                data-target="#editkontrolModal"
                                                                                aria-expanded="false"
                                                                                data-nama>
                                                                                &nbsp;&nbsp;<i class="fas fa-edit"></i> Edit
                                                                            </a>
                                                                        </div>
                                                                        <div
                                                                            class="btn-group btn-block mb-2 mb-xl-0 card_detail_barang">
                                                                            <div class="btn-group mb-2 mb-xl-0 btn-block">
                                                                                <a onclick="$('#cover-spin').show(0)"
                                                                                    href="/{{ $role }}/aksi_hapus_barang"
                                                                                    class="btn btn-outline-secondary btn-block"
                                                                                    style="display: block;">
                                                                                    <i class="fas fa-trash"></i> Hapus
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    @endforeach --}}
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
                                                                    class="btn btn-outline-secondary">
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
                                                                    {{-- @foreach ($barang->keluarMasukBarang as $data)

                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>Halin Fajar Waskitho</td>
                                                                    <td>{{ $data->tanggal_keluar_masuk }}</td>
                                                                    <td>{{ $data->jumlah_keluar }}</td>
                                                                    <td>{{ $data->jumlah_masuk }}</td>
                                                                    <td>{{ $data->jumlah_sisa }}</td>
                                                                    <td>{{ $data->keterangan }}</td>
                                                                    <td>{{ $data->status_kc }}</td>
                                                                    <td>
                                                                        <div
                                                                            class="btn-group btn-block mb-2 mb-xl-0 card_detail_barang">
                                                                            <a class="btn btn-outline-secondary intro-ubah-detail-barang ml-1 mr-0"
                                                                                type="button" data-toggle="modal"
                                                                                data-target="#editkeluarModal"
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
                                                                                    class="btn btn-outline-secondary btn-block"
                                                                                    style="display: block;">
                                                                                    <i class="fas fa-trash"></i> Hapus
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    @endforeach --}}
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

    {{-- modal edit barang --}}
    <div class="modal fade" id="edittambahModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Edit Data Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="myForm">
                        <div class="form-group">
                            <label for="kode">Kode Aset :</label>
                            <input type="text" class="form-control" id="kode" name="kode">
                        </div>
                        <div class="form-group">
                            <label for="tgl_beli">Tgl Pembelian :</label>
                            <input type="text" class="form-control" id="tgl_beli" name="tgl_beli">
                        </div>
                        <div class="form-group">
                            <label for="name">Nama :</label>
                            <input type="text" class="form-control" id="name" name="nama">
                        </div>
                        <div class="form-group">
                            <label for="kategori">Kategori :</label>
                            <input type="text" class="form-control" id="kategori" name="kategori">
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
                            <label for="status">Status :</label>
                            <input type="text" class="form-control" id="status" name="status">
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const editButtons= document.querySelectorAll('.edit-barang');

            editButtons.forEach(button=>{
                button.addEventListener('click', function(){
                    const namaBarang = this.getAttribute('data-nama-barang');
                    const satuanBarang = this.getAttribute('data-satuan');
                    const lokasiPenyimpanan = this.getAttribute('data-lokasi-penyimpanan');
                    const spesifikasi = this.getAttribute('data-spesifikasi');

                    document.querySelector('#edittambahModal input[name="nama"]').value= namaBarang;
                    document.querySelector('#edittambahModal input[name="satuan"]').value= satuanBarang;
                    document.querySelector('#edittambahModal input[name="lokasi_penyimpanan"]').value= lokasiPenyimpanan;
                    document.querySelector('#edittambahModal input[name="spesifikasi"]').value= spesifikasi;
                })
            })
        })
    </script>

    {{-- modal edit kontrol barang --}}
    <div class="modal fade" id="editkontrolModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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

    {{-- modal edit keluar masuk barang --}}
    <div class="modal fade" id="editkeluarModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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
