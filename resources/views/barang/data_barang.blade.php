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
                                                <th>Aksi</th>
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
                                                <td>Ubah</td>
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

@endsection
@endsection
