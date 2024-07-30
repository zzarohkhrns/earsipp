@extends('main')

@section('berita', 'active')
@section('berita_ac', 'active menu-open')
@section('berita_mo', 'menu-open')


@section('css')
@section('content')



    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb m-0 pl-4">
                        <li class="breadcrumb-item active">
                            <a href="/{{ $role }}/dashboard">Dashboard</a> / <a
                                href="/{{ $role }}/arsip/berita">Berita Umum</a> / <a>{{ $page }}</a>
                        </li>
                    </ol>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">{{ Carbon\Carbon::parse(now())->isoFormat('dddd, D MMMM Y') }}
                        </li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    {{-- <section class="content">
        <div class="container-fluid">
            <div class="card ijo-atas">
                <div class="p-3   rounded vekap">
                    <div class="container-fluid py-3 ">
                        <div class="row">
                            <div class="col">
                                <h3 class=" fw-bold ">{{ $page }}</h3>
                                <p class=""> Data {{ $page }} LAZISNU CILACAP</p>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid ">
            <!-- Form Element sizes -->
            @php
                $rul = strtolower($role);
            @endphp

            <div class="card card-success ">
                {{-- <div class="card-header ">
                     <h3 class="card-title" style="padding-bottom: 10px;padding-top:10px;">Detail Berita Umum</h3>
                    <br>
                </div> --}}

                <div class="card-body ">
                    <!-- Form Element sizes -->
                    <div class="invoice rounded p-3 mt-6 mb-7 ijo-atas">
                        <style>
                            .nav-pills .nav-link.active,
                            .nav-pills .show>.nav-link {
                                background-color: green;
                            }
                        </style>
                        <ul class="nav nav-stacked nav-pills" id="tabMenu">
                            <li class="nav-item card-tab-berita-umum">
                                <a class="nav-link active" data-toggle="tab" href="#berita_umum">Berita
                                    Umum</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link card-tab-lampiran-berita" data-toggle="tab"
                                    href="#lampiran_berita">Lampiran
                                    Berita</a>
                            </li>

                        </ul>
                        <div class="tab-content">
                            <div class="active tab-pane" id="berita_umum">
                                <div class="row mb-9">
                                    <div class="col-12 mb-9 "><br>
                                        <div class="d-flex justify-content-between ">
                                            <h4>
                                                &nbsp;Berita Umum
                                            </h4>

                                            {{-- modal berita --}}
                                            <div class="modal fade" id="staticTambah" data-backdrop="static"
                                                data-keyboard="false" aria-labelledby="staticBackdropLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title edit" id="staticBackdropLabel">Ubah
                                                                Berita
                                                                Umum</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>

                                                        <form method="post" id="editForm" enctype="multipart/form-data"
                                                            action="/{{ $role }}/arsip/aksi_edit_berita/{{ $berita->id_berita_umum }}">
                                                            @csrf
                                                            @method('PUT')

                                                            <div class="modal-body mt-2">



                                                                <div class="form-row mt-4">
                                                                    <div class="form-group col-md-6">
                                                                        <label for="tgl_berita">TANGGAL TERBIT
                                                                            &nbsp;</label>
                                                                        <sup class="badge badge-danger text-white mb-2"
                                                                            style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                                        <input type="text" id="tanggalTerbit"
                                                                            name="tanggal_terbit" class="form-control"
                                                                            value="  {{ Carbon\Carbon::parse($berita->tanggal_terbit)->isoFormat('dddd, D MMMM Y') }}
                                                                            "
                                                                            readonly>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="inputPawarta">KATEGORI&nbsp;</label>
                                                                        <sup class="badge badge-danger text-white mb-2"
                                                                            style="background-color:rgba(230,82,82)">WAJIB</sup>

                                                                        <select
                                                                            class="form-control @error('kategori') is-invalid @enderror"
                                                                            name="kategori_berita"
                                                                            data-placeholder="Masukan Kategori Aset"
                                                                            style="appearance:none;
                                                                -webkit-appearance:none;
                                                                -moz-appearance:none; ">

                                                                            <option value="{{ $berita->kategori_berita }}"
                                                                                selected hidden>
                                                                                {{ $berita->kategori_berita }}
                                                                            </option>

                                                                            @foreach ($kategori_berita as $kategori)
                                                                                @if ($kategori->nama_kategori != $berita->kategori_berita)
                                                                                    <option
                                                                                        value="{{ $kategori->nama_kategori }}">
                                                                                        {{ $kategori->nama_kategori }}
                                                                                    </option>
                                                                                @endif
                                                                            @endforeach



                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="jdl_berita">HASTAG BERITA &nbsp;</label>
                                                                    <sup class="badge badge-danger text-white mb-2"
                                                                        style="background-color:rgba(230,82,82)">WAJIB</sup>

                                                                    <input
                                                                        type="text"class="form-control  @error('hastag_berita') is-invalid @enderror"
                                                                        name="hastag_berita[]" id="tags"
                                                                        placeholder="Masukan Tag Berita"
                                                                        data-role="tagsinput"
                                                                        value="{{ $berita->hastag_berita }}">

                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="jdl_berita">JUDUL BERITA &nbsp;</label>
                                                                    <sup class="badge badge-danger text-white mb-2"
                                                                        style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                                    <input type="text" class="form-control"
                                                                        id="judulBerita" name="judul_berita"
                                                                        placeholder="Masukan judul berita"
                                                                        value=" {{ $berita->judul_berita }}" required>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="inputNarasi">NARASI BERITA &nbsp;</label>
                                                                    <sup class="badge badge-danger text-white mb-2"
                                                                        style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                                    <textarea name="narasi_berita" class="my-editor form-control" id="my-editor" cols="30" rows="10">
                                                                            {{ $berita->narasi_berita }}
                                                                        </textarea>
                                                                </div>

                                                                <div class="float-right mb-3 mt-2 bd-highlight">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal"><i class="fas fa-ban"></i>
                                                                        Batal</button>

                                                                    <button
                                                                        class="btn btn-success text-white toastrDefaultSuccess"
                                                                        id="buttonSimpan" type="submit"
                                                                        onclick="$('#cover-spin').show(0)"><i
                                                                            class="fas fa-save"></i> Simpan
                                                                        Perubahan</button>
                                                                </div>


                                                            </div>

                                                        </form>


                                                    </div>
                                                </div>
                                            </div>

                                            @if (Auth::user()->PcPengurus->PengurusJabatan->jabatan == 'Divisi IT dan Media')
                                                <button class="btn btn-secondary  ml-1 mr-0 card-ubah-berita-umum"
                                                    type="button" data-toggle="modal" data-target="#staticTambah"
                                                    aria-expanded="false">
                                                    <i class="fas fa-edit"></i>&nbsp;&nbsp;Ubah
                                                    Berita
                                                </button>
                                            @else
                                            @endif




                                        </div>
                                    </div><br>
                                    <br><br>

                                    <div class="col-12">
                                        <div class="row">


                                            <!-- Modal -->
                                            @if (DB::table('file_berita')->where('id_berita_umum', $id_berita_umum)->where('foto_background_berita', '!=', null)->exists())
                                                <div class="modal fade bd-example-modal-lg"
                                                    id="exampleModal{{ $foto_bg->id_file_berita }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="exampleModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Foto
                                                                    {{ $foto_bg->judul_file }}
                                                                </h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <img src="{{ asset('foto_background_berita/' . $foto_bg->foto_background_berita) }}"
                                                                    style="display:block; margin:auto;max-height:400px;max-widht:250px;">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal"><i class="fas fa-ban"></i>
                                                                    Tutup</button>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table id="datatable" class="table table-sm table-bordered"
                                                        style="border: 1px solid;">
                                                        <tr class="card-view-foto-background-berita">
                                                            <th style="width:40%">Foto</th>
                                                            <td>
                                                                @if (DB::table('file_berita')->where('id_berita_umum', $id_berita_umum)->where('foto_background_berita', '!=', null)->exists())
                                                                    <a href="#" type="button" data-toggle="modal"
                                                                        data-target="#exampleModal{{ $foto_bg->id_file_berita }}">
                                                                        {{ $foto_bg->judul_file }}
                                                                    </a>
                                                                @else
                                                                    <a href="#" type="button">Belum Memiliki Foto
                                                                    </a>
                                                                @endif


                                                            </td>
                                                            <!-- Button trigger modal -->

                                                            {{-- <img src="https://cdn-2.tstatic.net/tribunnews/foto/bank/images/nu-care-berbagi.jpg"
                                                            class="d-block w-100" style="max-height:300px"> --}}
                                                        </tr>
                                                        <tr>
                                                            <th style="width:40%">Kategori</th>
                                                            <td>{{ $berita->kategori_berita }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Tanggal Terbit</th>

                                                            <td>{{ Carbon\Carbon::parse($berita->tanggal_terbit)->isoFormat('dddd, D MMMM Y') }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Hastag</th>

                                                            <td>{{ $berita->hastag_berita }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center" colspan="2">Judul Berita</th>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-justify" colspan="2">
                                                                {{ $berita->judul_berita }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center" colspan="2">Narasi Berita</th>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-justify" colspan="2"
                                                                style="font-size:15px;">
                                                                @php
                                                                    
                                                                    echo $a = $berita->narasi_berita;
                                                                @endphp
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                </div>
                            </div>
                            <div class="tab-pane" id="lampiran_berita">
                                <!-- Post -->
                                <div class="row mb-9">
                                    <div class="col-12 mb-9 "><br>
                                        <div class="d-flex justify-content-between ">
                                            <h4>
                                                &nbsp;Lampiran Dokumentasi Berita
                                            </h4>
                                            <!-- Modal -->
                                            <div class="modal fade" id="unggah" tabindex="-1" role="dialog"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">
                                                                Unggah File Arsip Berita</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>

                                                        <form
                                                            action="/{{ $role }}/arsip/aksi_tambah_file_berita/{{ $id_berita_umum }}"
                                                            method="post" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="form-group">

                                                                    <input type="hidden" name="arsip_digital_id"
                                                                        value="">
                                                                    <label>Judul File </label>
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Masukan Judul" name="judul_file"
                                                                        id="judul_file">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="col-4 col-form-label">Jenis
                                                                        Foto </label>

                                                                    @if (DB::table('file_berita')->where('id_berita_umum', $id_berita_umum)->where('foto_background_berita', '!=', null)->select('foto_background_berita')->exists())
                                                                        <select class="form-control" name="jenis"
                                                                            id="jenis"
                                                                            data-placeholder="Masukan Jenis File">
                                                                            <option value="" selected hidden>
                                                                                Pilih
                                                                                Jenis
                                                                                Foto</option>
                                                                            <option value="dokumentasi">Foto
                                                                                Dokumentasi
                                                                            </option>
                                                                        </select>
                                                                    @else
                                                                        <select class="form-control" name="jenis"
                                                                            id="jenis"
                                                                            data-placeholder="Masukan Jenis File">
                                                                            <option value="" selected hidden>
                                                                                Pilih
                                                                                Jenis
                                                                                Foto</option>

                                                                            <option value="background">Foto Background
                                                                            </option>
                                                                            <option value="dokumentasi">Foto
                                                                                Dokumentasi
                                                                            </option>
                                                                        </select>
                                                                    @endif
                                                                </div>

                                                                <div class="form-group">
                                                                    <label>File</label>
                                                                    <input type="file" accept=".jpg,.jpeg,.png"
                                                                        class="form-control" name="file"
                                                                        id="file">
                                                                </div>




                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal"><i class="fas fa-ban"></i>
                                                                    Batal</button>
                                                                <button type="submit" id="submits"
                                                                    class="btn btn-success"
                                                                    onclick="$('#cover-spin').show(0)"
                                                                    disabled="disabled"><i class="fas fa-save"></i>
                                                                    Simpan Lampiran</button>
                                                            </div>

                                                            <script type="text/javascript">
                                                                var judul_file = true;
                                                                var jenis = true;
                                                                var file = true;

                                                                (function() {

                                                                    $('#judul_file').keyup(function() {
                                                                        console.log($('#judul_file').val());
                                                                        $('#judul_file').each(function() {
                                                                            if ($(this).val() != '') {
                                                                                judul_file = false;
                                                                            } else {
                                                                                judul_file = true;
                                                                            }
                                                                            myfung();
                                                                        });
                                                                    });

                                                                    $('#jenis').on('change', function() {
                                                                        console.log($('#jenis').val());
                                                                        if ($('#jenis').val() != '') {
                                                                            jenis = false;
                                                                        } else {
                                                                            jenis = true;
                                                                        }
                                                                        myfung();
                                                                        // console.log()
                                                                    });

                                                                    $('#file').on('change', function() {
                                                                        console.log($('#file').val());
                                                                        if ($('#file').val() != '') {
                                                                            file = false;
                                                                        } else {
                                                                            file = true;
                                                                        }
                                                                        myfung();
                                                                        // console.log()
                                                                    });

                                                                })()

                                                                function myfung() {
                                                                    if (judul_file == true || jenis == true || file == true) {
                                                                        $('#submits').attr('disabled', 'disabled');
                                                                    } else {
                                                                        $('#submits').removeAttr('disabled');
                                                                    }
                                                                }
                                                            </script>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            @if (Auth::user()->PcPengurus->PengurusJabatan->jabatan == 'Divisi IT dan Media')
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-success ml-1 mr-0"
                                                    data-toggle="modal" data-target="#unggah">
                                                    <i class="fas fa-plus-circle" aria-hidden="true"></i> Tambah Lampiran
                                                </button>
                                            @else
                                            @endif



                                        </div>
                                    </div><br>
                                    <br><br>
                                </div>


                                <div class="table-responsive">
                                    <table id="examplezz" class="table table-bordered " style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Judul</th>
                                                <th>Jenis Foto</th>
                                                <th>Waktu Upload</th>
                                                <th>Aksi</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($lampiran as $lam)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $lam->judul_file }}</td>
                                                    @if ($lam->foto_background_berita != null)
                                                        <td>Foto Background</td>
                                                    @else
                                                        <td>Foto Dokumentasi</td>
                                                    @endif
                                                    <td>{{ $lam->created_at }}</td>
                                                    <td>
                                                        <!-- Example split danger button -->
                                                        <div class="btn-group">

                                                            <button type="button" class="btn btn-success"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">Kelola</button>
                                                            <button type="button"
                                                                class="btn btn-success dropdown-toggle dropdown-toggle-split"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">
                                                                <span class="sr-only">Toggle
                                                                    Dropdown</span>
                                                            </button>



                                                            <div class="dropdown-menu">
                                                                @if (Auth::user()->PcPengurus->PengurusJabatan->jabatan == 'Divisi IT dan Media')
                                                                    @if (DB::table('file_berita')->where('id_berita_umum', $id_berita_umum)->exists())
                                                                        <a onMouseOver="this.style.color='red'"
                                                                            onMouseOut="this.style.color='black'"
                                                                            class="dropdown-item" type="button"
                                                                            data-target="#edit_lampiran{{ $lam->id_file_berita }}"
                                                                            data-toggle="modal">
                                                                            <i class="fas fa-edit"></i> Ubah</a>
                                                                        <!-- Modal -->
                                                                    @endif
                                                                @else
                                                                @endif


                                                                @if ($lam->foto_background_berita != null)
                                                                    <a onMouseOver="this.style.color='red'"
                                                                        onMouseOut="this.style.color='black'"
                                                                        class="dropdown-item"
                                                                        href="{{ asset('foto_background_berita/' . $lam->foto_background_berita . '') }}"
                                                                        type="button" target="_blank">
                                                                        <i class="fas fa-print"></i> Cetak</a>
                                                                @else
                                                                    <a onMouseOver="this.style.color='red'"
                                                                        onMouseOut="this.style.color='black'"
                                                                        class="dropdown-item"
                                                                        href="{{ asset('foto_dokumentasi_berita/' . $lam->foto_dokumentasi_berita . '') }}"
                                                                        type="button" target="_blank">
                                                                        <i class="fas fa-print"></i> Cetak</a>
                                                                @endif

                                                                @if (Auth::user()->PcPengurus->PengurusJabatan->jabatan == 'Divisi IT dan Media')
                                                                    @if (DB::table('file_berita')->where('id_berita_umum', $id_berita_umum)->exists())
                                                                        <button onMouseOver="this.style.color='red'"
                                                                            onMouseOut="this.style.color='black'"
                                                                            class="dropdown-item" type="button"
                                                                            data-target="#modal_hapus{{ $lam->id_file_berita }}"
                                                                            data-toggle="modal"><i
                                                                                class="fas fa-trash"></i>
                                                                            Hapus</button>
                                                                    @endif
                                                                @else
                                                                @endif






                                                            </div>

                                                    </td>

                                                    {{-- modal hapus --}}
                                                    <div class="modal fade" id="modal_hapus{{ $lam->id_file_berita }}"
                                                        role="dialog" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <form
                                                                    action="/{{ $role }}/arsip/aksi_hapus_file_berita/{{ $lam->id_file_berita }}"
                                                                    method="post" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="modal-header">

                                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                                            Konfirmasi
                                                                                Hapus
                                                                        </h5>

                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p>Yakin ingin menghapus data?</p>
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
                                                @if (DB::table('file_berita')->where('id_berita_umum', $id_berita_umum)->exists())
                                                    <div class="modal fade" id="edit_lampiran{{ $lam->id_file_berita }}"
                                                        role="dialog" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                                        Ubah Lampiran File</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form
                                                                    action="/{{ $role }}/arsip/aksi_edit_file_berita/{{ $lam->id_file_berita }}"
                                                                    method="post" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="modal-body">
                                                                        <div class="form-group">

                                                                            <input type="hidden" name="arsip_digital_id"
                                                                                value="{{ $id_berita_umum }}">
                                                                            <label>Nama</label>
                                                                            <input value="{{ $lam->judul_file }}"
                                                                                type="text" class="form-control"
                                                                                placeholder="Masukan Judul"
                                                                                name="judul_file" required>
                                                                        </div>

                                                                        @if ($lam->foto_background_berita != null)
                                                                            <input type="hidden" value="background"
                                                                                name="jenis">
                                                                            <input type="hidden" name="file_lama"
                                                                                value="{{ $lam->foto_background_berita }}">
                                                                        @else
                                                                            <input type="hidden" value="dokumentasi"
                                                                                name="jenis">
                                                                            <input type="hidden" name="file_lama"
                                                                                value="{{ $lam->foto_dokumentasi_berita }}">
                                                                        @endif


                                                                        <div class="form-group">
                                                                            <label>File</label> <sup
                                                                                class="badge badge-danger text-white mb-2"
                                                                                style="background-color:rgb(82, 166, 230)">ABAIKAN
                                                                                JIKA TIDAK ADA
                                                                                PERUBAHAN (JPG/JPEG/PNG)</sup>
                                                                            <input type="file" class="form-control"
                                                                                name="file">
                                                                        </div>


                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal"><i
                                                                                class="fas fa-ban"></i>
                                                                            Batal</button>
                                                                        <button type="submit" name="submit"
                                                                            onclick="$('#cover-spin').show(0)"
                                                                            class="btn btn-success"><i
                                                                                class="fas fa-save"></i>
                                                                            Simpan Perubahan</button>
                                                                    </div>

                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach

                                        </tbody>


                                    </table>
                                </div>
                            </div>

                        </div>

                    </div>


                </div>


            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <!-- Form Element sizes -->


        </div>
        <!-- /.tab-content -->

    </section>

@endsection

@section('js')

    <script>
        $(document).ready(function() {
            $("#examplezz").DataTable({
                "responsive": true,

                "autoWidth": false,
                "bJQueryUI": true,

                "bDestroy": true,
                "aoColumnDefs": [{
                    'bSortable': false,
                    'aTargets': [0, 1]
                }],
                "aLengthMenu": [
                    [5, 10, 25, 50, 100, -1],
                    [5, 10, 25, 50, 100, "All"]
                ],
                "iDisplayLength": 5,
            }).buttons().container().appendTo('#examplezz_wrapper .col-md-6:eq(0)');


        });
    </script>

    <script>
        //redirect to specific tab
        $(document).ready(function() {
            $('#tabMenu a[href="#{{ old('tab') }}"]').tab('show')
        });
    </script>

    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script>
        var options = {
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
        };
    </script>
    <script>
        CKEDITOR.replace('my-editor', options);
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


    @push('intro_detail_berita')
        @if (Auth::user()->PcPengurus->PengurusJabatan->jabatan == 'Divisi IT dan Media')
            <script>
                function klikkene(value) {
                    introJs().setOptions({
                            steps: [{
                                    element: document.querySelector('.card-tab-berita-umum'),
                                    title: 'Tab Berita Umum',
                                    intro: 'Untuk Menampilkan Detail Dari Data Berita Umum Yang Sudah Diterbitkan Dan Dipilih'
                                },
                                {
                                    element: document.querySelector('.card-tab-lampiran-berita'),
                                    title: 'Lampiran Berita',
                                    intro: 'Untuk Melihat Foto Dokumentasi Dari Berita Umum Yang Sudah Diterbitkan, Serta Dapat Melakukan Pengelolahan Seperti Menambah Dokumentasi Foto Baru , Merubah Dan Menghapus Data'
                                },
                                {
                                    element: document.querySelector('.card-view-foto-background-berita'),
                                    title: 'Foto Background Berita',
                                    intro: 'Untuk Menampilkan Foto Background Berita Sebaga Foto Utama Berita Umum Yang Nantinya Akan Ditampilkan di Website Berita Umum PCNU Cilacap'
                                },
                                {
                                    element: document.querySelector('.card-ubah-berita-umum'),
                                    title: 'Ubah Berita Umum',
                                    intro: 'Untuk Merubah Data Berita Yang Sudah Diterbitkan'
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
        @else
            <script>
                function klikkene(value) {
                    introJs().setOptions({
                            steps: [{
                                    element: document.querySelector('.card-tab-berita-umum'),
                                    title: 'Tab Berita Umum',
                                    intro: 'Untuk Menampilkan Detail Dari Data Berita Umum Yang Sudah Diterbitkan Dan Dipilih'
                                },
                                {
                                    element: document.querySelector('.card-tab-lampiran-berita'),
                                    title: 'Lampiran Berita',
                                    intro: 'Untuk Melihat Foto Dokumentasi Dari Berita Umum Yang Sudah Diterbitkan, Serta Dapat Melakukan Pengelolahan Seperti Menambah Dokumentasi Foto Baru , Merubah Dan Menghapus Data'
                                },
                                {
                                    element: document.querySelector('.card-view-foto-background-berita'),
                                    title: 'Foto Background Berita',
                                    intro: 'Untuk Menampilkan Foto Background Berita Sebaga Foto Utama Berita Umum Yang Nantinya Akan Ditampilkan di Website Berita Umum PCNU Cilacap'
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
        @endif
    @endpush

@endsection
