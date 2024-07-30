@extends('main')

@section($link, 'active')
@section('aset_ac', 'active menu-open')
@section('aset_mo', 'menu-open')

@section('css')
@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb m-0 pl-4">
                        <li class="breadcrumb-item active">
                            @if ($page == 'Aset Wakaf')
                                <a href="/{{ $role }}/dashboard">Dashboard</a> / <a
                                    href="/{{ $role }}/aset_wakaf">{{ $page }}</a>/
                                <a>{{ $page2 }}</a>
                            @elseif ($page == 'Aset Umum')
                                <a href="/{{ $role }}/dashboard">Dashboard</a> / <a
                                    href="/{{ $role }}/aset_umum">{{ $page }}</a>/
                                <a>{{ $page2 }}</a>
                            @endif
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
    <section class="content ">
        <div class="container-fluid ">
            <!-- Form Element sizes -->
            @php
                $rul = strtolower($role);
            @endphp

            <div class="card card-success">

                <div class="card-body">
                    <!-- Form Element sizes -->

                    <div class="card card-success ijo-atas">
                        <div class="row mt-4 ml-4 justify-content-between">
                            <div>
                                <h3 class="card-title "><b>Rincian Data Aset {{ ucfirst($link) }}</b>
                                </h3>
                            </div>
                            <div class="col-auto mr-3">

                                {{-- modal berita --}}
                                <div class="modal fade" id="staticTambah" data-backdrop="static" data-keyboard="false"
                                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header ">
                                                <h5 class="modal-title edit" id="staticBackdropLabel">Edit
                                                    Arsip Dokumen</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <form action="/{{ $role }}/aksi_edit_aset/{{ $aset->aset_id }}"
                                                method="post" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')

                                                <div class="modal-body mt-2">

                                                    <div class="form-row mt-4">

                                                        <div class="form-group col-md-6">
                                                            <label>Kategori Aset&nbsp;</label>
                                                            <sup class="badge badge-danger text-white mb-2"
                                                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                            <select
                                                                class="form-control @error('kategori') is-invalid @enderror"
                                                                name="kategori" data-placeholder="Masukan Kategori Aset"
                                                                style="appearance:none;
                                                                -webkit-appearance:none;
                                                                -moz-appearance:none; ">

                                                                <option value="{{ $kategori_detail->kategori }}" selected
                                                                    hidden>
                                                                    {{ $kategori_detail->kategori }}
                                                                </option>

                                                                @foreach ($kategori_aset as $kategori)
                                                                    @if ($kategori->nama_kategori != $kategori_detail->kategori)
                                                                        <option value="{{ $kategori->nama_kategori }}">
                                                                            {{ $kategori->nama_kategori }}
                                                                        </option>
                                                                    @endif
                                                                @endforeach


                                                            </select>
                                                            @error('kategori')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>


                                                        <div class="form-group col-md-6">
                                                            <label>Nama Aset&nbsp;</label>
                                                            <sup class="badge badge-danger text-white mb-2"
                                                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                            <input type="text" autocomplete="off"
                                                                class="form-control @error('nama') is-invalid @enderror"
                                                                name="nama" placeholder="Masukan Nama Aset  "
                                                                value="{{ $aset->nama }}">
                                                            @error('nama')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <label>Asal Aset&nbsp;</label>
                                                            <sup class="badge badge-danger text-white mb-2"
                                                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                            <input type="text" autocomplete="off"
                                                                class="form-control @error('asal') is-invalid @enderror"
                                                                name="asal" placeholder="Masukan Asal Aset  "
                                                                value="{{ $aset->asal }}">
                                                            @error('asal')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <label>Lokasi Aset&nbsp;</label>
                                                            <sup class="badge badge-danger text-white mb-2"
                                                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                            <input type="text" autocomplete="off"
                                                                class="form-control @error('lokasi') is-invalid @enderror"
                                                                name="lokasi" placeholder="Masukan Lokasi Aset  "
                                                                value="{{ $aset->lokasi }}">
                                                            @error('lokasi')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <label>Tahun Perolehan Aset&nbsp;</label>
                                                            <sup class="badge badge-danger text-white mb-2"
                                                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                            <input type="number"
                                                                class="form-control @error('tahun_perolehan') is-invalid @enderror"
                                                                name="tahun_perolehan"
                                                                placeholder="Masukan Tahun Perolehan Aset"
                                                                value="{{ $aset->tahun_perolehan }}">
                                                            @error('tahun_perolehan')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <label class="form-label">Jumlah Aset</label>
                                                            <sup class="badge badge-danger text-white mb-2"
                                                                style="background-color:rgba(230,82,82)"> WAJIB</sup>
                                                            <div class="input-group ">
                                                                <input type="number" autocomplete="off"
                                                                    class="form-control @error('jumlah_unit') is-invalid @enderror"
                                                                    name="jumlah_unit"
                                                                    placeholder="Masukan Jumlah Unit Aset"
                                                                    value="{{ $aset->jumlah_unit }}">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text"
                                                                        id="basic-addon2">Unit</span>
                                                                </div>
                                                                @error('jumlah_unit')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>



                                                        <div class="form-group col-md-6">
                                                            <label class="form-label">Nominal Aset</label>
                                                            <sup class="badge badge-danger text-white mb-2"
                                                                style="background-color:rgba(230,82,82)"> WAJIB</sup>
                                                            <div class="input-group ">
                                                                <input type="text" autocomplete="off"
                                                                    class="form-control @error('nominal') is-invalid @enderror"
                                                                    name="nominal" placeholder="Masukan Nominal Aset"
                                                                    id="anggaran"
                                                                    value="{{ number_format($aset->nominal, 0, ',', '.') }}">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text"
                                                                        id="basic-addon2">Rupiah</span>
                                                                </div>
                                                                @error('nominal')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <label>Kondisi Aset&nbsp;</label>
                                                            <sup class="badge badge-danger text-white mb-2"
                                                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                            <select
                                                                class="form-control @error('kondisi') is-invalid @enderror"
                                                                name="kondisi"
                                                                data-placeholder="Masukan Klasifikasi Surat"
                                                                style="appearance:none;
                                                                -webkit-appearance:none;
                                                                -moz-appearance:none; "
                                                                required>
                                                                @if ($aset->kondisi == 'Baik')
                                                                    <option value="Baik" selected>Baik
                                                                    </option>
                                                                    <option value="Kurang">Kurang
                                                                    </option>
                                                                    <option value="Rusak">Rusak
                                                                    </option>
                                                                @elseif ($aset->kondisi == 'Kurang')
                                                                    <option value="Baik">Baik
                                                                    </option>
                                                                    <option value="Kurang" selected>Kurang
                                                                    </option>
                                                                    <option value="Rusak">Rusak
                                                                    </option>
                                                                @elseif ($aset->kondisi == 'Rusak')
                                                                    <option value="Baik">Baik
                                                                    </option>
                                                                    <option value="Kurang">Kurang
                                                                    </option>
                                                                    <option value="Rusak" selected>Rusak
                                                                    </option>
                                                                @endif

                                                            </select>
                                                            @error('kondisi')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>






                                                    </div>

                                                    <div class="form-group">
                                                        <label for="isi_memo">Keterangan Aset&nbsp;</label>
                                                        <sup class="badge badge-danger text-white mb-2"
                                                            style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                        <textarea class="form-control  @error('keterangan') is-invalid @enderror" name="keterangan" id=""
                                                            cols="50" rows="4" placeholder="Masukan Keterangan Data Aset">{{ $aset->keterangan }}</textarea>
                                                        @error('keterangan')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="float-right mb-3 mt-2 bd-highlight">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal"><i class="fas fa-ban"></i>
                                                            Batal</button>

                                                        <button class="btn btn-success text-white toastrDefaultSuccess"
                                                            type="submit" onclick="$('#cover-spin').show(0)"><i
                                                                class="fas fa-save"></i> Simpan
                                                            Perubahan</button>
                                                    </div>
                                                </div>
                                            </form>


                                        </div>
                                    </div>
                                </div>

                                @if ($info == 'Diteruskan')
                                    @php
                                        $hilang = '';
                                    @endphp
                                @else
                                    @php
                                        $hilang = 'display:none;';
                                    @endphp
                                @endif

                                <a class="btn btn-secondary  ml-1 mr-0" type="button" data-toggle="modal"
                                    data-target="#staticTambah" aria-expanded="false" style="{{ $hilang }}">
                                    &nbsp;&nbsp;<i class="fas fa-edit"></i> Ubah Data {{ $page }}
                                </a>


                            </div>
                            <!-- Button trigger modal -->

                            {{-- <input type="hidden" name="pelaksana_kegiatan"> --}}
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-6">
                                    {{-- <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Kategori Aset</label>
                                            <div class="col-sm-8">
                                                <input type="text"
                                                    class="form-control @error('kategori') is-invalid @enderror"
                                                    name="kategori" placeholder="Kategori Aset"
                                                    value="{{ $aset->kategori }}" required>
                                                @error('kategori')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                            </div>
                                        </div> --}}

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Kategori Aset</label>
                                        <div class="col-sm-8">
                                            <input type="text" autocomplete="off"
                                                class="form-control @error('nama') is-invalid @enderror"
                                                placeholder="Masukan Nama Aset  " value="{{ $aset->kategori }}" readonly>
                                        </div>
                                    </div>




                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Nama Aset</label>
                                        <div class="col-sm-8">
                                            <input type="text" autocomplete="off"
                                                class="form-control @error('nama') is-invalid @enderror"
                                                placeholder="Masukan Nama Aset  " value="{{ $aset->nama }}" readonly>
                                            @error('nama')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Asal Aset</label>
                                        <div class="col-sm-8">
                                            <input type="text" autocomplete="off"
                                                class="form-control @error('asal') is-invalid @enderror" readonly
                                                placeholder="Masukan Asal Aset  " value="{{ $aset->asal }}">
                                            @error('asal')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Lokasi Aset</label>
                                        <div class="col-sm-8">
                                            <input type="text" autocomplete="off"
                                                class="form-control @error('lokasi') is-invalid @enderror" readonly
                                                placeholder="Masukan Lokasi Aset  " value="{{ $aset->lokasi }}">
                                            @error('lokasi')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Tahun Perolehan Aset</label>
                                        <div class="col-sm-8">
                                            <input type="number"
                                                class="form-control @error('tahun_perolehan') is-invalid @enderror"
                                                readonly placeholder="Masukan Tahun Perolehan Aset"
                                                value="{{ $aset->tahun_perolehan }}">
                                            @error('tahun_perolehan')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>


                                </div>

                                <div class="col-lg-6 col-6">


                                    <div class="form-group
                                                    row">
                                        <label class="col-sm-4 col-form-label">Tanggal
                                            Input</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control"
                                                value="{{ \Carbon\Carbon::parse($aset->created_at)->isoFormat('dddd, D MMMM Y') }}"
                                                readonly>

                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Jumlah Aset</label>
                                        <div class="input-group col-sm-8">
                                            <input type="number" autocomplete="off" class="form-control "
                                                name="jumlah_unit" placeholder="Masukan Jumlah Unit Aset"
                                                value="{{ $aset->jumlah_unit }}" readonly>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2">Unit</span>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Nominal Aset</label>
                                        <div class="input-group col-sm-8">
                                            <input type="text" autocomplete="off" readonly class="form-control "
                                                name="nominal" placeholder="Masukan Nominal Aset" id="anggaran"
                                                value="{{ number_format($aset->nominal, 0, ',', '.') }}">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2">Rupiah</span>
                                            </div>

                                        </div>
                                    </div>



                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Kondisi Aset</label>
                                        <div class="input-group col-sm-8">
                                            <input type="text" autocomplete="off" readonly class="form-control "
                                                placeholder="Masukan Kondisi Aset" id="anggaran"
                                                value="{{ $aset->kondisi }}">
                                        </div>
                                    </div>





                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Keterangan Aset</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" readonly rows="2" placeholder="Masukan Keterangan Data Aset">{{ $aset->keterangan }}</textarea>
                                        </div>
                                    </div>




                                </div>

                            </div>


                            {{-- <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Jenis Penerima </label>
                                &nbsp;&nbsp;
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-light active">
                                        <input type="radio" name="options" id="tombol-jenis-disposisi1"
                                            autocomplete="off" checked>
                                        Satuan
                                    </label>
                                    <label class="btn btn-light">
                                        <input type="radio" name="options" id="tombol-jenis-disposisi2"
                                            autocomplete="off">
                                        Golongan
                                    </label>
                                </div>

                            </div>

                            <div class="form-group" id="select2-golongan">
                                <label>Hak Akses Golongan</label>
                                <select class="select2" multiple="multiple"
                                    data-placeholder="Masukan Hak Akses Arsip" style="width: 100%;" name="akses[]">
                                    <option value="akses_lembaga">Akses Lembaga</option>
                                    <option value="akses_mwcnu">Akses MWCNU</option>
                                    <option value="akses_ranting">Akses Ranting</option>
                                </select>
                            </div> --}}

                            {{-- <div class="form-group" id="select2-satuan">
                                <label>Hak Akses Satuan</label>
                                <select class="select2" multiple="multiple" data-placeholder="Masukan Hak Akses Arsip"
                                    style="width: 100%;" name="akses[]">
                                    @foreach ($mwcnu as $mwcnu)
                                        <option value="{{ $mwcnu->mwcnu_id }}">{{ $mwcnu->nama_mwcnu }}</option>
                                    @endforeach
                                    @foreach ($lembaga as $lembaga)
                                        <option value="{{ $lembaga->lembaga_id }}">{{ $lembaga->nama_lembaga }}
                                        </option>
                                    @endforeach
                                </select>
                            </div> --}}

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <!-- Form Element sizes -->


                    <!-- Form Element sizes -->
                    <div class="card ijo-atas ">

                        <div class="col-md-12 ">
                            <!-- general form elements -->

                            <div class="row mt-4 ml-4 justify-content-between">
                                <div>
                                    <h3 class="card-title "><b>Uplaod File Aset {{ ucfirst($link) }}</b>
                                    </h3>
                                </div>
                                <div class="col-auto mr-3">

                                    <button type="button" class="btn btn-success" data-toggle="modal"
                                        data-target="#unggah">
                                        <i class="fas fa-plus-circle" aria-hidden="true"></i> Tambah File
                                        Lampiran
                                    </button>


                                </div>
                                <!-- Button trigger modal -->

                                {{-- <input type="hidden" name="pelaksana_kegiatan"> --}}
                            </div>
                            <div class="col-auto mr-3">
                                <div class="col-auto">
                                    <!-- Button trigger modal -->


                                    <!-- Modal -->
                                    <div class="modal fade" id="unggah" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header ">
                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                        Unggah File {{ $page }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form
                                                    action="/{{ $role }}/aksi_tambah_file_aset/{{ $aset->aset_id }}"
                                                    method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="form-group">

                                                            <input type="hidden" name="arsip_digital_id" value="">
                                                            <label>Nama</label>
                                                            <input type="text" class="form-control"
                                                                placeholder="Masukan Judul" name="nama_file" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>File</label>
                                                            <input type="file"
                                                                accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.xlsx"
                                                                class="form-control" name="file_aset" required>
                                                        </div>




                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal"><i class="fas fa-ban"></i>
                                                            Batal</button>
                                                        <button type="submit" name="submit" class="btn btn-success"
                                                            onclick="$('#cover-spin').show(0)"><i class="fas fa-save"></i>
                                                            Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="card-body">

                            <table id="example1" class="table table-bordered " style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Waktu Upload</th>
                                        <th>Aksi</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($file_aset as $file)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $file->nama_file }}</td>
                                            <td>{{ \Carbon\Carbon::parse($file->created_at)->isoFormat('dddd, D MMMM Y') }}
                                            </td>
                                            <td>
                                                <!-- Example split danger button -->
                                                <div class="btn-group">

                                                    <button type="button" class="btn btn-success" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">Kelola</button>
                                                    <button type="button"
                                                        class="btn btn-success dropdown-toggle dropdown-toggle-split"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <span class="sr-only">Toggle
                                                            Dropdown</span>
                                                    </button>



                                                    <div class="dropdown-menu">




                                                        <a onMouseOver="this.style.color='red'"
                                                            onMouseOut="this.style.color='black'" class="dropdown-item"
                                                            type="button"
                                                            data-target="#edit_file_aset{{ $file->file_aset_id }}"
                                                            data-toggle="modal"><i class="fas fa-edit"></i>
                                                            Ubah</a>



                                                        <a onMouseOver="this.style.color='red'"
                                                            onMouseOut="this.style.color='black'" class="dropdown-item"
                                                            href="{{ asset('file_aset/' . $file->file_aset) }}"
                                                            type="button" target="_blank"><i
                                                                class="far fa-file-alt"></i>
                                                            &nbsp;Cetak</a>



                                                        <button onMouseOver="this.style.color='red'"
                                                            onMouseOut="this.style.color='black'" class="dropdown-item"
                                                            type="button"
                                                            data-target="#modal_hapus{{ $file->file_aset_id }}"
                                                            data-toggle="modal"><i class="fas fa-trash"></i>
                                                            Hapus</a>




                                                    </div>

                                                    {{-- modal hapus --}}
                                                    <div class="modal fade" id="modal_hapus{{ $file->file_aset_id }}"
                                                        role="dialog" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <form
                                                                    action="/{{ $role }}/aksi_hapus_file_aset/{{ $file->file_aset_id }}"
                                                                    method="post">
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

                                            </td>
                                            <!-- Modal -->
                                            <div class="modal fade" id="edit_file_aset{{ $file->file_aset_id }}"
                                                role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header ">
                                                            <h5 class="modal-title" id="exampleModalLabel">
                                                                Edit File {{ $page }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form
                                                            action="/{{ $role }}/aksi_edit_file_aset/{{ $file->file_aset_id }}"
                                                            method="post" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label>Nama</label>
                                                                    <input value="{{ $file->nama_file }}" type="text"
                                                                        class="form-control" placeholder="Masukan Judul"
                                                                        name="nama_file" required>
                                                                </div>

                                                                <input type="hidden" name="file_lama"
                                                                    value="{{ $file->file_aset }}">

                                                                <div class="form-group">
                                                                    <label>File</label>
                                                                    <input type="file" class="form-control"
                                                                        name="file_aset">
                                                                </div>


                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal"><i class="fas fa-ban"></i>
                                                                    Batal</button>
                                                                <button type="submit" name="submit"
                                                                    onclick="$('#cover-spin').show(0)"
                                                                    class="btn btn-success"><i class="fas fa-save"></i>
                                                                    Simpan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end Modal -->
                                        </tr>
                        </div>
                        @endforeach

                        </thead>



                        </table>

                    </div>

                </div>

            </div>
    </section>

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




@endsection
