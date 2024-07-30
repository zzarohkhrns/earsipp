@extends('main')
@if (Auth::user()->gocap_id_pc_pengurus)
    @section('pc_kegiatan', 'active')
@elseif(Auth::user()->gocap_id_upzis_pengurus)
    @section('upzis_kegiatan', 'active')
@endif
@section('kegiatan_ac', 'active menu-open')
@section('kegiatan_mo', 'menu-open')


@section('css')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb m-0 pl-4">
                        <li class="breadcrumb-item active">
                            @if (Auth::user()->gocap_id_pc_pengurus)
                                <a href="/{{ $role }}/dashboard">Dashboard</a> / <a
                                    href="/{{ $role }}/arsip/kegiatan_pc/{{ $hal }}">{{ $hals }}</a>
                                /
                                {{ $halaman }}
                            @elseif(Auth::user()->gocap_id_upzis_pengurus)
                                <a href="/{{ $role }}/dashboard">Dashboard</a> / <a
                                    href="">{{ $hals }}</a>
                                /
                                {{ $halaman }}
                            @endif

                        </li>
                    </ol>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">
                            {{ Carbon\Carbon::parse(now())->isoFormat('dddd, D MMMM Y') }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>


    <!-- Main content -->
    <section class="content">
        <div class="card card-outline card-success">

            <div class="card-header mb-0">
                <div class="container-fluid p-0">
                    <div class="row">

                        <div class="col-12">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active tab-details-kegiatan" id="nav-home-tab"
                                        data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home"
                                        aria-selected="true">Kegiatan</a>
                                    @if (Auth::user()->gocap_id_pc_pengurus)
                                        <a class="nav-item nav-link tab-notulen-kegiatan" onclick="$('#cover-spin').show(0)"
                                            href="/{{ $role }}/arsip/notulen_kegiatan/{{ $kegiatan->kegiatan_id }}/{{ $hal }}"
                                            aria-controls="nav-profile" aria-selected="false">Notulen</a>
                                    @elseif (Auth::user()->gocap_id_upzis_pengurus)
                                        <a class="nav-item nav-link tab-notulen-kegiatan" onclick="$('#cover-spin').show(0)"
                                            href="/{{ $role }}/arsip/notulen_kegiatan/{{ $kegiatan->kegiatan_id }}/"
                                            aria-controls="nav-profile" aria-selected="false">Notulen</a>
                                    @endif

                                </div>
                            </nav>

                            <div class="row text-success mt-1 mb-1">
                            </div>

                            <br>
                            <div class="invoice rounded p-3 mt-6 mb-7">

                                <div class="row mb-9">
                                    <div class="col-12 col-md-4 mb-9">
                                        <div class="d-flex justify-content-between">
                                            <h4>
                                                <i class="fas fa-users"></i> &nbsp; Foto
                                            </h4>

                                            <button
                                                class="card-ubah-dokumentasi-foto-kegiatan btn btn-secondary btn float-right"
                                                role="button" data-toggle="modal"
                                                data-target="#modal_upload_dokumentasi"><i class="fas fa-edit"></i>
                                                Ubah Dokumentasi</button>

                                        </div>
                                    </div>

                                    @if (Session::has('code'))
                                        <script>
                                            $(function() {
                                                $('#modal_upload_dokumentasi').modal('show');
                                            });
                                        </script>
                                    @endif

                                    <div class="modal fade" id="modal_upload_dokumentasi" data-backdrop="static"
                                        data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        {{-- jika ada foto --}}

                                        <div class="modal-dialog modal-lg">

                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="staticBackdropLabel">UPLOAD DOKUMENTASI</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body mt-2">
                                                    <div id="form-baru">


                                                        <form
                                                            action="{{ url('/' . $role . '/aksi_tambah_file_kegiatan/') }}"
                                                            method="post" enctype="multipart/form-data">
                                                            @csrf
                                                            <input type="hidden" name="kegiatan_id"
                                                                value="{{ $kegiatan->kegiatan_id }}">
                                                            @livewire('dokumentasi-kegiatan')

                                                        </form>



                                                        {{-- tabel dokumentasi --}}
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 40px;">No</th>
                                                                        <th style="width: 200px;">Judul</th>
                                                                        <th>File</th>
                                                                        <th style="width: 120px;">Opsi</th>
                                                                    </tr>
                                                                </thead>

                                                                <tbody>

                                                                    @foreach ($filekegiatan as $item)
                                                                        <tr>
                                                                            <td>{{ $loop->iteration }}</td>
                                                                            <td>{{ $item->judul_foto_kegiatan }}</td>
                                                                            <td><img src="{{ asset('file_foto_kegiatan/' . $item->file_foto_kegiatan . '') }}"
                                                                                    height="100px;" widht="100px;"> </td>
                                                                            <td>
                                                                                <div class="btn-group">

                                                                                    <button type="button"
                                                                                        class="btn btn-success"
                                                                                        data-toggle="dropdown"
                                                                                        aria-haspopup="true"
                                                                                        aria-expanded="false">Kelola</button>
                                                                                    <button type="button"
                                                                                        class="btn btn-success dropdown-toggle dropdown-toggle-split"
                                                                                        data-toggle="dropdown"
                                                                                        aria-haspopup="true"
                                                                                        aria-expanded="false">
                                                                                        <span class="sr-only">Toggle
                                                                                            Dropdown</span>
                                                                                    </button>
                                                                                    <div class="dropdown-menu">
                                                                                        {{-- <a onMouseOver="this.style.color='green'"
                                                                                        onMouseOut="this.style.color='black'"
                                                                                        class="dropdown-item modaldetailbutton noClick"
                                                                                        type="button"><i
                                                                                            class="fas fa-camera"></i>
                                                                                        Lihat
                                                                                    </a> --}}
                                                                                        <a onMouseOver="this.style.color='green'"
                                                                                            onMouseOut="this.style.color='black'"
                                                                                            class="dropdown-item modaldetailbutton"
                                                                                            data-toggle="modal"
                                                                                            data-target="#modal_edit_dokumentasi"
                                                                                            type="button"><i
                                                                                                class="far fa-eye"></i>
                                                                                            Ubah</a>

                                                                                        <a onMouseOver="this.style.color='red'"
                                                                                            onMouseOut="this.style.color='black'"
                                                                                            class="dropdown-item"
                                                                                            type="button"
                                                                                            data-target="#modal_hapus{{ $item->file_foto_kegiatan_id }}"
                                                                                            data-toggle="modal"><i
                                                                                                class="fas fa-trash"></i>
                                                                                            Hapus</a>
                                                                                    </div>
                                                                                </div>
                                                                            </td>

                                                                            {{-- modal hapus --}}
                                                                            <div class="modal fade"
                                                                                id="modal_hapus{{ $item->file_foto_kegiatan_id }}"
                                                                                role="dialog"
                                                                                aria-labelledby="exampleModalLabel"
                                                                                aria-hidden="true">
                                                                                <div class="modal-dialog" role="document">
                                                                                    <div class="modal-content">
                                                                                        <form
                                                                                            action="/{{ $role }}/aksi_hapus_file_kegiatan/{{ $item->file_foto_kegiatan_id }}"
                                                                                            method="post">
                                                                                            @csrf

                                                                                            <input type="hidden"
                                                                                                value="{{ $item->file_foto_kegiatan }}"
                                                                                                name="file_foto_kegiatan">
                                                                                            <div class="modal-header">

                                                                                                <h5 class="modal-title"
                                                                                                    id="exampleModalLabel">
                                                                                                    <b>Konfirmasi
                                                                                                        Hapus</b>
                                                                                                </h5>

                                                                                            </div>
                                                                                            <div class="modal-body">
                                                                                                <p>Yakin ingin menghapus
                                                                                                    data?
                                                                                                </p>
                                                                                            </div>
                                                                                            <div class="modal-footer">
                                                                                                <button type="button"
                                                                                                    class="btn btn-secondary close-btn"
                                                                                                    data-dismiss="modal"><i
                                                                                                        class="fas fa-ban"></i>
                                                                                                    Batal</button>
                                                                                                <button type="submit"
                                                                                                    onclick="$('#cover-spin').show(0)"
                                                                                                    class="btn btn-danger"><i
                                                                                                        class="fas fa-trash"></i>
                                                                                                    Iya,
                                                                                                    Hapus</button>
                                                                                            </div>
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            {{-- END modal hapus --}}
                                                                        </tr>

                                                                        {{-- modal edit dokumentasi --}}
                                                                        <div class="modal fade"
                                                                            id="modal_edit_dokumentasi"
                                                                            data-backdrop="static"
                                                                            aria-labelledby="exampleModalCenterTitle"
                                                                            data-keyboard="false"
                                                                            aria-labelledby="staticBackdropLabel"
                                                                            aria-hidden="true">
                                                                            {{-- jika ada foto --}}

                                                                            <div
                                                                                class="modal-dialog modal-md modal-dialog-centered">

                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title"
                                                                                            id="staticBackdropLabel">
                                                                                            UBAH DOKUMENTASI</h5>

                                                                                        <button type="button"
                                                                                            class="close tombol-batal"
                                                                                            data-dismiss="modal"
                                                                                            aria-label="Close">
                                                                                            <span
                                                                                                aria-hidden="true">&times;</span>
                                                                                        </button>
                                                                                    </div>

                                                                                    <form
                                                                                        action="/{{ $role }}/aksi_edit_file_kegiatan/{{ $item->file_foto_kegiatan_id }}"
                                                                                        method="post"
                                                                                        enctype="multipart/form-data">
                                                                                        @csrf
                                                                                        <div class="modal-body mt-2">
                                                                                            <div id="form-baru">
                                                                                                <div class="form-row">

                                                                                                    {{-- judul dokumentasi --}}
                                                                                                    <div
                                                                                                        class="form-group col-md-12">
                                                                                                        <label
                                                                                                            for="inputNama">JUDUL
                                                                                                            FOTO KEGIATAN
                                                                                                            &nbsp;</label>
                                                                                                        <sup class="badge badge-danger text-white mb-2"
                                                                                                            style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                                                                        <input
                                                                                                            type="text"
                                                                                                            class="form-control"
                                                                                                            name="judul_foto_kegiatan"
                                                                                                            placeholder="Nama Judul Dokumentasi"
                                                                                                            value="{{ $item->judul_foto_kegiatan }}">

                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-row">

                                                                                                    {{-- foto dokumentasi --}}
                                                                                                    <div
                                                                                                        class="form-group col-md-12">
                                                                                                        <label
                                                                                                            for="inputHP">FOTO
                                                                                                            KEGIATAN</label>
                                                                                                        <sup class="badge badge-danger text-white mb-2"
                                                                                                            style="background-color:rgb(82, 166, 230)">ABAIKAN
                                                                                                            JIKA TIDAK ADA
                                                                                                            PERUBAHAN
                                                                                                            (JPG/JPEG/PNG)
                                                                                                        </sup>
                                                                                                        <div
                                                                                                            class="custom-file custom-file-edit-dokumentasi">
                                                                                                            <input
                                                                                                                type="file"
                                                                                                                accept="image/png, image/jpg, image/jpeg"
                                                                                                                class="custom-file-input "name="file_foto_kegiatan">
                                                                                                            <label
                                                                                                                class="custom-file-label"
                                                                                                                for="customFile">Pilih
                                                                                                                file
                                                                                                            </label>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <input type="hidden"
                                                                                                        value="{{ $item->file_foto_kegiatan }}"
                                                                                                        name="file_foto_kegiatan_lama">


                                                                                                </div>
                                                                                            </div>
                                                                                        </div>


                                                                                        <div class="modal-footer">
                                                                                            <button type="button"
                                                                                                class="btn btn-secondary tombol-batal"
                                                                                                data-dismiss="modal"><i
                                                                                                    class="fas fa-ban"></i>
                                                                                                Batal</button>
                                                                                            <button
                                                                                                class="btn btn-success tombol-simpan"
                                                                                                type="submit"
                                                                                                onclick="$('#cover-spin').show(0)"
                                                                                                name="submit"><i
                                                                                                    class="fas fa-save"></i>
                                                                                                Simpan Perubahan</button>
                                                                                        </div>

                                                                                    </form>
                                                                                </div>

                                                                            </div>

                                                                        </div>
                                                                        {{-- END modal edit dokumentasi --}}
                                                                    @endforeach
                                                                </tbody>

                                                            </table>
                                                        </div>

                                                    </div>
                                                </div>


                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary "
                                                        data-dismiss="modal"><i class="fas fa-ban"></i>
                                                        Batal</button>
                                                </div>


                                            </div>

                                        </div>

                                    </div>

                                    <br><br>
                                    <div class="col-6 col-md-4 float-right">
                                        <h4>
                                            <i class="fas fa-money-check-alt"></i> &nbsp; Rincian Pelaksanaan Kegiatan
                                        </h4>

                                    </div>

                                    <div class="col-6 col-md-4 float-right">

                                        <button class=" card-ubah-data-kegiatan btn btn-success ml-1 mr-0 float-right"
                                            data-bs-toggle="modal" href="#exampleModalToggle" type="button">
                                            <i class="fas fa-plus-circle" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Ubah
                                            Kegiatan
                                        </button>

                                        <form
                                            action="/{{ $role }}/aksi_edit_kegiatan/{{ $kegiatan->kegiatan_id }}"
                                            method="post">
                                            @csrf
                                            <div class="modal fade bd-example-modal-lg" id="exampleModalToggle"
                                                aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
                                                tabindex="-1">
                                                <div class="modal-dialog modal-lg ">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-success">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">Ubah
                                                                Kegiatan</h5>
                                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                                aria-label="Close"><span
                                                                    aria-hidden="true">&times;</span></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <nav class="mb-4">
                                                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                                    <button class="nav-link text-success active"
                                                                        id="satu" data-toggle="tab"
                                                                        data-target="#nav-satu-tab" type="button"
                                                                        role="tab" aria-controls="nav-satu-tab"
                                                                        aria-selected="true">Kegiatan dan Notulen</button>
                                                                    <button class="nav-link text-success disabled"
                                                                        id="dua" data-toggle="tab"
                                                                        data-target="#nav-dua-tab" type="button"
                                                                        role="tab" aria-controls="nav-dua-tab"
                                                                        aria-selected="false">Detail Kegiatan dan
                                                                        Notulen</button>
                                                                </div>
                                                            </nav>

                                                            <div class="form-row">
                                                                <div class="form-group col-md-6">
                                                                    <label>TANGGAL KEGIATAN &nbsp;</label>
                                                                    <sup class="badge badge-danger text-white mb-2"
                                                                        style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                                    <input type="text" class="form-control"
                                                                        name="tgl_kegiatan" readonly
                                                                        value="{{ Carbon\Carbon::parse($kegiatan->tgl_kegiatan)->isoFormat('dddd, D MMMM Y') }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="cariPekerjaan">NAMA KEGIATAN &nbsp;</label>
                                                                    <sup class="badge badge-danger text-white mb-2"
                                                                        style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Masukan Nama Kegiatan"
                                                                        name="nama_kegiatan"
                                                                        value="{{ $kegiatan->nama_kegiatan }}">
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-md-6">
                                                                    <label>JENIS KEGIATAN &nbsp;</label>
                                                                    <sup class="badge badge-danger text-white mb-2"
                                                                        style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Masukan Jenis Kegiatan"
                                                                        name="jenis_kegiatan"
                                                                        value="{{ $kegiatan->jenis_kegiatan }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="cariPekerjaan">ESTIMASI BIAYA
                                                                        &nbsp;</label>
                                                                    <sup class="badge badge-danger text-white mb-2"
                                                                        style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control"
                                                                            placeholder="Masukan Estimasi Biaya Kegiatan"
                                                                            name="estimasi_biaya_kegiatan" id="anggaran"
                                                                            value="{{ number_format($kegiatan->estimasi_biaya_kegiatan, 0, ',', '.') }}">
                                                                        <p class="input-group-text"
                                                                            style=" width: 100px;height:37px;max-height:100%;">
                                                                            Rupiah</p>

                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-row">
                                                                <div class="form-group col-md-6">
                                                                    <label>PELAKSANA KEGIATAN &nbsp;</label>
                                                                    <sup class="badge badge-danger text-white mb-2"
                                                                        style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Masukan Pelaksana Kegiatan"
                                                                        name="pelaksana_kegiatan"
                                                                        value="{{ $kegiatan->pelaksana_kegiatan }}">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="cariPekerjaan">LOKASI KEGIATAN
                                                                        &nbsp;</label>
                                                                    <sup class="badge badge-danger text-white mb-2"
                                                                        style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Masukan Lokasi Kegiatan"
                                                                        name="lokasi_kegiatan"
                                                                        value="{{ $kegiatan->lokasi_kegiatan }}">
                                                                </div>
                                                            </div>

                                                            <div class="form-row">
                                                                <div class="form-group col-md-6">
                                                                    <label>PENANGGUNGJAWAB &nbsp;</label>
                                                                    <sup class="badge badge-danger text-white mb-2"
                                                                        style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Masukan Penanggungjawab Kegiatan"
                                                                        name="penanggungjawab_kegiatan"
                                                                        value="{{ $kegiatan->penanggungjawab_kegiatan }}">
                                                                </div>

                                                                <div class="form-group col-md-6">
                                                                    <label>TANGGAL INPUT DATA &nbsp;</label>
                                                                    <sup class="badge badge-danger text-white mb-2"
                                                                        style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                                    <input type="text" class="form-control" readonly
                                                                        value="{{ Carbon\Carbon::parse($kegiatan->created_at)->isoFormat('dddd, D MMMM Y') }}">
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="modal-footer">
                                                            <button id='button' type="button" class="btn btn-primary"
                                                                data-bs-target="#exampleModalToggle2"
                                                                data-bs-toggle="modal" data-bs-dismiss="modal"><i
                                                                    class="fas fa-forward"></i> Selanjutnya</button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade bd-example-modal-lg" id="exampleModalToggle2"
                                                aria-hidden="true" aria-labelledby="exampleModalToggleLabel2"
                                                tabindex="-1">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-success">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">Detail
                                                                Kegiatan
                                                                &
                                                                Notulen</h5>
                                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                                aria-label="Close"><span
                                                                    aria-hidden="true">&times;</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <nav class="mb-4">
                                                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                                    <button class="nav-link text-success disabled"
                                                                        id="satu" data-toggle="tab"
                                                                        data-target="#nav-satu-tab" type="button"
                                                                        role="tab" aria-controls="nav-satu-tab"
                                                                        aria-selected="true">Kegiatan dan Notulen</button>
                                                                    <button class="nav-link text-success active"
                                                                        id="dua" data-toggle="tab"
                                                                        data-target="#nav-dua-tab" type="button"
                                                                        role="tab" aria-controls="nav-dua-tab"
                                                                        aria-selected="false">Detail Kegiatan dan
                                                                        Notulen</button>
                                                                </div>
                                                            </nav>

                                                            <div class="form-row">
                                                                <div class="form-group col-md-6">
                                                                    <label>CAPAIAN KEGIATAN &nbsp;</label>

                                                                    <textarea type="text" class="form-control" name="capaian_kegiatan" placeholder="Masukan Capaian Kegiatan">{{ $kegiatan->capaian_kegiatan }}</textarea>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="cariPekerjaan">RINGKASAN JALANNYA KEGIATAN
                                                                        &nbsp;</label>

                                                                    <textarea type="text" class="form-control" name="ringkasan_kegiatan"
                                                                        placeholder="Masukan Ringkasan Jalannya Kegiatan">{{ $kegiatan->ringkasan_kegiatan }}</textarea>
                                                                </div>
                                                            </div>

                                                            <div class="form-row">
                                                                <div class="form-group col-md-6">
                                                                    <label>KENDALA KEGIATAN&nbsp;</label>

                                                                    <textarea type="text" class="form-control" name="kendala_kegiatan" placeholder="Masukan Kendala Kegiatan">{{ $kegiatan->kendala_kegiatan }}</textarea>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="cariPekerjaan">SOLUSI KEGIATAN
                                                                        &nbsp;</label>

                                                                    <textarea type="text" class="form-control" name="solusi_kegiatan" placeholder="Masukan Solusi Kegiatan">{{ $kegiatan->solusi_kegiatan }}</textarea>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-danger" type="button"
                                                                data-bs-target="#exampleModalToggle"
                                                                data-bs-toggle="modal" data-bs-dismiss="modal"><i
                                                                    class="fas fa-backward"></i>
                                                                Kembali</button>
                                                            <button onclick="$('#cover-spin').show(0)"
                                                                class="btn btn-success" type="submit"><i
                                                                    class="fas fa-save"></i> Simpan Perubahan
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>


                                    <div class="col-12">
                                        <div class="row mt-2 mb-2">
                                            <div class="col-12 col-md-4">
                                                <div class="table">
                                                    <tr>
                                                        <th style="width:50%" rowspan="5">

                                                            <div id="carouselExampleControls" class="carousel slide"
                                                                data-ride="carousel">
                                                                <div class="carousel-inner" style="height: 250px;">


                                                                    @forelse ($file_kegiatan as $f_k)
                                                                    @empty
                                                                        <div class="carousel-item active">
                                                                            <img class="d-block w-100"
                                                                                src="{{ asset('images/img_doc.jpeg') }}"
                                                                                alt="Second slide">
                                                                        </div>
                                                                    @endforelse
                                                                    @php
                                                                        $b = 1;
                                                                        $active = 'active';
                                                                    @endphp
                                                                    @foreach ($file_kegiatan as $f_k)
                                                                        @if ($b > 1)
                                                                            @php
                                                                                $active = '';
                                                                            @endphp
                                                                        @endif

                                                                        <div class="carousel-item {{ $active }}">
                                                                            <img class="d-block w-100"
                                                                                style="border-radius:10px; "
                                                                                src="{{ asset('file_foto_kegiatan/' . $f_k->file_foto_kegiatan . '') }}"
                                                                                alt="First slide">
                                                                            <p class="text-center mt-2">
                                                                                {{ $f_k->judul_foto_kegiatan }} </p>
                                                                        </div>

                                                                        @php
                                                                            $b++;
                                                                        @endphp
                                                                    @endforeach

                                                                </div>
                                                                <a class="carousel-control-prev"
                                                                    href="#carouselExampleControls" role="button"
                                                                    data-slide="prev">
                                                                    <span class="carousel-control-prev-icon"
                                                                        aria-hidden="true"></span>
                                                                    <span class="sr-only">Previous</span>
                                                                </a>
                                                                <a class="carousel-control-next"
                                                                    href="#carouselExampleControls" role="button"
                                                                    data-slide="next">
                                                                    <span class="carousel-control-next-icon"
                                                                        aria-hidden="true"></span>
                                                                    <span class="sr-only">Next</span>
                                                                </a>
                                                            </div>

                                                        </th>
                                                    </tr>
                                                </div>
                                            </div>

                                            <div class=" col-12 col-md-4">
                                                <div class="table-responsive">
                                                    <table id="datatable" class="table table-sm table-bordered"
                                                        height="250px">
                                                        <tr>
                                                            <th style="width:50%">Tanggal Kegiatan</th>
                                                            <td>{{ Carbon\Carbon::parse($kegiatan->tgl_kegiatan)->isoFormat('dddd, D MMMM Y') }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Pelaksanaan Kegiatan</th>
                                                            <td>{{ $kegiatan->pelaksana_kegiatan }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Nama Kegiatan</th>
                                                            <td>{{ $kegiatan->nama_kegiatan }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Lokasi Kegiatan</th>
                                                            <td>{{ $kegiatan->lokasi_kegiatan }}</td>
                                                        </tr>


                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <div class="table-responsive">
                                                    <table id="datatable" class="table table-sm table-bordered"
                                                        height="250px">
                                                        <tr>
                                                            <th>Jenis Kegiatan</th>

                                                            <td> {{ $kegiatan->jenis_kegiatan }}</td>

                                                        </tr>
                                                        <tr>
                                                            <th style="width:50%">PJ Kegiatan</th>
                                                            <td>
                                                                {{ $kegiatan->penanggungjawab_kegiatan }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Estimasi Kegiatan </th>
                                                            <td>{{ 'Rp ' . number_format($kegiatan->estimasi_biaya_kegiatan, 0, ',', '.') }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Tanggal Input Data </th>
                                                            <td>{{ Carbon\Carbon::parse($kegiatan->created_at)->isoFormat('dddd, D MMMM Y') }}
                                                            </td>
                                                        </tr>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <br>
                            <div class="invoice rounded p-3 mt-6 mb-7">
                                <div class="col-12">
                                    <div class="col-12 col-md-12 mb-9">
                                        <h4>
                                            <i class="fas fa-users"></i> &nbsp; Detail Kegiatan
                                        </h4>
                                    </div>

                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="capaian_kegiatan">CAPAIAN &nbsp;</label>

                                            <textarea disabled name="capaian_kegiatan" class="my-editor form-control" id="my-editor" cols="30"
                                                rows="3">{{ $kegiatan->capaian_kegiatan }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="kendala_kegiatan">KENDALA &nbsp;</label>

                                            <textarea disabled name="kendala_kegiatan" class="my-editor form-control" id="my-editor" cols="30"
                                                rows="3">{{ $kegiatan->kendala_kegiatan }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="ringkasan_kegiatan">RINGKASAN
                                                &nbsp;</label>

                                            <textarea disabled name="ringkasan_kegiatan" class="my-editor form-control" id="my-editor" cols="30"
                                                rows="3">{{ $kegiatan->ringkasan_kegiatan }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="solusi_kegiatan">SOLUSI &nbsp;</label>

                                            <textarea disabled name="solusi_kegiatan" class="my-editor form-control" id="my-editor" cols="30"
                                                rows="3">{{ $kegiatan->solusi_kegiatan }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

    </section>


    <!-- /.content-header -->
@endsection


@section('js')

    <script>
        var harga = document.getElementById('anggaran');
        harga.addEventListener('keyup', function(e) {
            harga.value = formatRupiah(this.value, '');
        });

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
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

    <!-- OPTIONAL SCRIPTS -->
    <script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>





    <script>
        $(function() {

            var areaChartDatas = {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                datasets: [{
                    label: 'Jumlah Pengunjung',
                    backgroundColor: 'rgba(40,167,69)',
                    borderColor: 'rgba(40,167,69)',
                    pointRadius: false,
                    pointColor: '#28A745',
                    pointStrokeColor: 'rgba(40,167,69)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(40,167,69)',
                    data: [28, 48, 40, 19, 86, 27, 90]
                }, ]
            }
            //-------------
            //- BAR CHART -
            //-------------
            var barChartCanvas = $('#barChart').get(0).getContext('2d')
            var barChartData = $.extend(true, {}, areaChartDatas)
            var temp0 = areaChartDatas.datasets[0]
            barChartData.datasets[0] = temp0

            var barChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                datasetFill: false
            }

            new Chart(barChartCanvas, {
                type: 'bar',
                data: barChartData,
                options: barChartOptions
            })

            //---------------------
            //- STACKED BAR CHART -
            //---------------------
            var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')


            var stackedBarChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        stacked: true,
                    }],
                    yAxes: [{
                        stacked: true
                    }]
                }
            }

            new Chart(stackedBarChartCanvas, {
                type: 'bar',
                data: stackedBarChartData,
                options: stackedBarChartOptions
            })
        })
    </script>

    @push('intro_detail_kegiatan')
        <script>
            function klikkene(value) {
                introJs().setOptions({
                        steps: [{
                                element: document.querySelector('.tab-details-kegiatan'),
                                title: 'Detail Kegiatan',
                                intro: 'Menampilkan Data Detail Kegiatan'
                            }, {
                                element: document.querySelector('.tab-notulen-kegiatan'),
                                title: 'Detail Notulen',
                                intro: 'Menampilkan Data Detail Notulen'
                            },
                            {
                                element: document.querySelector('.card-ubah-dokumentasi-foto-kegiatan'),
                                title: 'Ubah Dokumentasi',
                                intro: 'Mengelola Tambah, Ubah, Serta Hapus Foto Dokumentasi '
                            },
                            {
                                element: document.querySelector('.card-ubah-data-kegiatan'),
                                title: 'Ubah Kegiatan',
                                intro: 'Untuk Mengubah data Kegiatan Yang Telah Tersimpan'
                            }
                        ]
                    }).setOption("dontShowAgain", value)
                    .setOption("skipLabel", "<p widht='100px' style='font-size:12px;color:blue;'><u>Lewati</u> </p>")
                    .setOption("dontShowAgainLabel", " Jangan Tampilkan Lagi")
                    .setOption("disableInteraction", true)
                    .setOption("nextLabel", "Lanjut")
                    .setOption("prevLabel", "Kembali")
                    .setOption("doneLabel", "Selesai")
                    .setOptions({
                        showProgress: true,
                    }).start();
            }

            $(document).ready(function() {
                klikkene(true);
                $("#panduan").click(function() {
                    klikkene(false);
                });
            });
        </script>
    @endpush
@endsection
