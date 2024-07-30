@extends('main')

@section('surat_masuk', 'active')
@section('arsip_ac', 'active menu-open')
@section('arsip_mo', 'menu-open')
@section('arsip_masuk_ac', 'active menu-open')
@section('arsip_masuk_mo', 'menu-open')

@section('css')
@section('content')


    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb m-0 pl-4">
                        <li class="breadcrumb-item active">
                            <a href="javascript:history.go(-1)">Surat Masuk</a> / <a>{{ $title }}</a>
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


    <section class="content">
        <div class="container-fluid ">
            <!-- Form Element sizes -->
            @php
                $rul = strtolower($role);
            @endphp

            <div class="card card-success">

                <div class="card-body">
                    <!-- Form Element sizes -->
                    <form action="/{{ $role }}/arsip/proses_edit_surat_masuk/{{ $arsip->arsip_digital_id }}"
                        method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card card-success ijo-atas">
                            <div class="row mt-4 ml-4 justify-content-between">
                                <div>
                                    <h3 class="card-title "><b>Rincian Surat Masuk</b>
                                    </h3>
                                </div>
                                <div class="col-auto mr-3">
                                    <a href="/{{ $role }}/arsip/print_disposisi/{{ $arsip->arsip_digital_id }}"
                                        type="button" class="btn btn-danger" target="_blank">Print Disposisi</a>
                                    @if ($stat == 'Diteruskan')
                                        <button type="submit" class="btn btn-primary">Edit Surat
                                            Masuk</button>
                                    @endif
                                </div>
                                <!-- Button trigger modal -->

                                {{-- <input type="hidden" name="pelaksana_kegiatan"> --}}
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6 col-6">

                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Tanggal
                                                Surat</label>
                                            <div class="col-sm-8">
                                                <input type="date"
                                                    class="form-control @error('tanggal_arsip') is-invalid @enderror"
                                                    name="tanggal_arsip" placeholder="Tanggal Arsip"
                                                    value="{{ $arsip->tanggal_arsip }}" required>
                                                @error('tanggal_arsip')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                            </div>
                                        </div>

                                        <div class="form-group
                                                    row">
                                            <label class="col-sm-4 col-form-label">Tanggal
                                                Index</label>
                                            <div class="col-sm-8">
                                                <input type="date" class="form-control"
                                                    value="{{ \Carbon\Carbon::parse($arsip->created_at)->format('Y-m-d') }}"
                                                    disabled>

                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Nomor Surat</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="nomor_surat"
                                                    placeholder="Masukan Nomor Surat" value="{{ $arsip->nomor_surat }}"
                                                    required>

                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Klasifikasi
                                                Surat</label>

                                            <div class="col-sm-8">
                                                <select class="form-control" name="klasifikasi_surat"
                                                    data-placeholder="Masukan Klasifikasi Surat" required>
                                                    <option value="{{ $arsip->klasifikasi_surat }}">Klasifikasi
                                                        Surat
                                                        {{ $arsip->klasifikasi_surat }}
                                                    </option>
                                                    <option value="Biasa">Biasa</option>
                                                    <option value="Khusus">Khusus</option>
                                                </select>
                                            </div>
                                        </div>





                                    </div>

                                    <div class="col-lg-6 col-6">

                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Tujuan
                                                Surat</label>
                                            <div class="col-sm-8">
                                                <input type="text"
                                                    class="form-control @error('tujuan_arsip') is-invalid @enderror"
                                                    name="tujuan_arsip" placeholder="Masukan Tujuan Surat"
                                                    value="{{ $arsip->tujuan_arsip }}" readonly>
                                                @error('tujuan_arsip')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Pengirim
                                                Surat</label>
                                            <div class="col-sm-8">
                                                <input type="text"
                                                    class="form-control @error('pengirim_sumber') is-invalid @enderror"
                                                    name="pengirim_sumber" placeholder="Masukan Pengirim Surat"
                                                    value="{{ $arsip->pengirim_sumber }}">
                                                @error('pengirim_sumber')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                            </div>
                                        </div>


                                        <div class="form-group
                                                    row">
                                            <label class="col-sm-4 col-form-label">Lampiran</label>
                                            <div class="input-group col-sm-8">
                                                <input type="text" name="pengeluaran_kegiatan" id="pengeluaran_kegiatan"
                                                    class="form-control " placeholder="" value="{{ $lampiran_file }}"
                                                    disabled>
                                                <p class="input-group-text"
                                                    style=" width: 100px;height:37px;max-height:100%;">File</p>
                                            </div>

                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Perihal</label>
                                            <div class="col-sm-8">
                                                <textarea class="form-control" name="perihal_isi_deskripsi" id="" cols="30" rows="4">{{ $arsip->perihal_isi_deskripsi }}</textarea>

                                            </div>
                                        </div>

                                    </div>

                                </div>

                    </form>

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <!-- Form Element sizes -->


            <!-- Form Element sizes -->
            <div class="card ijo-atas ">

                <style>
                    .nav-pills .nav-link.active,
                    .nav-pills .show>.nav-link {
                        background-color: green;
                    }
                </style>
                <div class="card-header ">
                    <ul class="nav nav-pills" id="tabMenu">
                        @if ($disposisi)
                            @php
                                $active = '';
                            @endphp
                            @if ($disposisi)
                                <li class="nav-item"><a class="nav-link active" href="#disposisi"
                                        data-toggle="tab">Disposisi</a></li>
                            @endif
                            @if ($sppd)
                                <li class="nav-item"><a class="nav-link" href="#sppd" data-toggle="tab">SPPD</a>
                                </li>
                            @endif
                            <li class="nav-item"><a class="nav-link" href="#file" data-toggle="tab">File</a>
                            @else
                                @php
                                    $active = 'active';
                                @endphp
                            <li class="nav-item"><a class="nav-link active" href="#file" data-toggle="tab">File</a>
                        @endif
                        </li>
                    </ul>
                </div>

                <div class="card-body">
                    <div class="tab-content">

                        @if ($stat == 'Diteruskan')
                            @php
                                $hilang = '';
                            @endphp
                        @else
                            @php
                                $hilang = 'display:none;';
                            @endphp
                        @endif

                        @if ($disposisi)
                            <div class="active tab-pane" id="disposisi">
                                {{-- post --}}
                                <form
                                    action="/{{ $role }}/arsip/proses_edit_disposisi/{{ $disposisi->disposisi_id }}"
                                    method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')


                                    <div class="float-right " style="{{ $hilang }}">
                                        <button type="submit" class="btn btn-primary">Edit Data
                                            Disposisi</button>
                                    </div>


                                    <br><br>
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col-lg-6 col-6">

                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Sifat Disposisi</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" name="sifat"
                                                            data-placeholder="Masukan Klasifikasi Surat" required>
                                                            <option value="{{ $disposisi->sifat }}">Sifat Disposisi
                                                                {{ $disposisi->sifat }}
                                                            </option>
                                                            <option value="Segera">Segera</option>
                                                            <option value="Sangat Segera">Sangat Segera</option>
                                                            <option value="Rahasia">Rahasia</option>
                                                        </select>

                                                    </div>
                                                </div>

                                                {{-- <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Tanggal
                                                        Pelaksanaan</label>
                                                    <div class="col-sm-8">
                                                        <input type="date" class="form-control"
                                                            name="tanggal_arsip" placeholder="Tanggal Arsip">

                                                    </div>
                                                </div> --}}

                                                @if (DB::table('arsip_digital')->where('jenis_arsip', 'Surat Masuk')->where('id_pengguna', Auth::user()->id_pengguna)->where('arsip_digital_id', $arsip->arsip_digital_id)->first())
                                                    {{-- pengirim --}}
                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Status Baca</label>
                                                        <div class="col-sm-8">

                                                            <button type="button" style="width: 100%"
                                                                class="btn btn-success" data-toggle="modal"
                                                                data-target="#statusbaca">
                                                                Lihat
                                                                Detail Status
                                                                Baca Disposisi
                                                            </button>
                                                        </div>
                                                    </div>
                                                @else
                                                    @php
                                                        
                                                    @endphp
                                                    @php
                                                        
                                                        if (Auth::user()->gocap_id_upzis_pengurus != null) {
                                                            if ($disposisi->status_baca == '0') {
                                                                DB::table('disposisi')
                                                                    ->join('arsip_digital', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                                                                    ->where('arsip_digital.arsip_digital_id', $id_arsip)
                                                                    ->where('id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                                                                    ->update([
                                                                        'status_baca' => '1',
                                                                    ]);
                                                            }
                                                        } elseif (Auth::user()->gocap_id_pc_pengurus != null) {
                                                            if ($disposisi->status_baca == '0') {
                                                                DB::table('disposisi')
                                                                    ->join('arsip_digital', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                                                                    ->where('arsip_digital.arsip_digital_id', $id_arsip)
                                                                    ->where('id_pc', Auth::user()->PcPengurus->Pc->id_pc)
                                                                    ->update([
                                                                        'status_baca' => '1',
                                                                    ]);
                                                            }
                                                        }
                                                    @endphp
                                                    {{-- sudah dibaca --}}
                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Status Baca</label>
                                                        <div class="col-sm-8">

                                                            <a href="#" type="button"
                                                                class="btn btn-success">Sudah
                                                                Dibaca</a>
                                                        </div>
                                                    </div>
                                                @endif

                                                <!-- Modal -->
                                                <div class="modal fade bd-example-modal-lg" id="statusbaca"
                                                    tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">
                                                                    Status
                                                                    Baca Disposisi</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <table id="example1" class="table table-bordered "
                                                                    style="width:100%">
                                                                    <thead>
                                                                        <tr>

                                                                            <th>Disposisi Surat</th>
                                                                            <th>Status Baca</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($baca_pc as $pc)
                                                                            <tr>

                                                                                <td>{{ $pc->nama }} <span
                                                                                        class="badge rounded-pill  bg-primary">
                                                                                        Pc </span>

                                                                                </td>
                                                                                @if ($pc->status_baca == '0')
                                                                                    @php
                                                                                        $stat = 'Belum Dibaca';
                                                                                        $warna = 'warning';
                                                                                        
                                                                                    @endphp
                                                                                @else
                                                                                    @php
                                                                                        $stat = 'Sudah Dibaca';
                                                                                        $warna = 'success';
                                                                                        
                                                                                    @endphp
                                                                                @endif

                                                                                <td class="text-center"
                                                                                    style="font-size:20px;"><span
                                                                                        class="badge badge-{{ $warna }} ">{{ $stat }}</span>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach

                                                                        @foreach ($baca_upzis as $baca_upzis)
                                                                            <tr>

                                                                                <td>{{ $baca_upzis->nama }} <span
                                                                                        class="badge rounded-pill  bg-success">
                                                                                        Upzis </span>

                                                                                </td>
                                                                                @if ($baca_upzis->status_baca == '0')
                                                                                    @php
                                                                                        $stat = 'Belum Dibaca';
                                                                                        $warna = 'warning';
                                                                                        
                                                                                    @endphp
                                                                                @else
                                                                                    @php
                                                                                        $stat = 'Sudah Dibaca';
                                                                                        $warna = 'success';
                                                                                        
                                                                                    @endphp
                                                                                @endif

                                                                                <td class="text-center"
                                                                                    style="font-size:20px;"><span
                                                                                        class="badge badge-{{ $warna }} ">{{ $stat }}</span>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach



                                                                        @foreach ($baca_internal as $baca_internal)
                                                                            @php
                                                                                $jabatans = DB::connection('gocap')
                                                                                    ->table('pengurus_jabatan')
                                                                                    ->where('id_pengurus_jabatan', $baca_internal->id_pengurus_jabatan)
                                                                                    ->select('jabatan')
                                                                                    ->get();
                                                                            @endphp


                                                                            <tr>


                                                                                <td>{{ $baca_internal->nama }}
                                                                                    @foreach ($jabatans as $item)
                                                                                        <span
                                                                                            class="badge rounded-pill  bg-danger">
                                                                                            {{ $item->jabatan }} </span>
                                                                                    @endforeach



                                                                                </td>

                                                                                {{-- <td>{{ $baca_internal->nama_jabatan }}
                                                                                </td> --}}

                                                                                @if ($baca_internal->status_baca == '0')
                                                                                    @php
                                                                                        $stat = 'Belum Dibaca';
                                                                                        $warna = 'warning';
                                                                                        
                                                                                    @endphp
                                                                                @else
                                                                                    @php
                                                                                        $stat = 'Sudah Dibaca';
                                                                                        $warna = 'success';
                                                                                        
                                                                                    @endphp
                                                                                @endif

                                                                                <td class="text-center"
                                                                                    style="font-size:20px;"><span
                                                                                        class="badge badge-{{ $warna }} ">{{ $stat }}</span>
                                                                                </td>


                                                                            </tr>
                                                                        @endforeach

                                                                        {{-- @foreach ($baca_ranting as $ranting)
                                                                            <tr>

                                                                                <td>{{ $ranting->nama }} <span
                                                                                        class="badge rounded-pill  bg-warning">
                                                                                        Ranting</span>

                                                                                </td>
                                                                                @if ($ranting->status_baca == '0')
                                                                                    @php
                                                                                        $stat = 'Belum Dibaca';
                                                                                        $warna = 'warning';
                                                                                        
                                                                                    @endphp
                                                                                @else
                                                                                    @php
                                                                                        $stat = 'Sudah Dibaca';
                                                                                        $warna = 'success';
                                                                                        
                                                                                    @endphp
                                                                                @endif

                                                                                <td class="text-center"
                                                                                    style="font-size:20px;"><span
                                                                                        class="badge badge-{{ $warna }} ">{{ $stat }}</span>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach --}}


                                                                    </tbody>
                                                                </table>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Tutup</button>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-lg-6 col-6">


                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Perihal Surat</label>
                                                    <div class="col-sm-8">
                                                        <textarea name="perihal" style="width: 100%" rows="4" class="form-control">{{ $disposisi->perihal }}</textarea>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>


                                    </div>

                                </form>
                                {{-- end post --}}
                            </div>
                        @endif


                        @if ($sppd)
                            <div class="tab-pane" id="sppd">
                                <!-- Post -->

                                <form action="/{{ $role }}/arsip/proses_edit_sppd/{{ $sppd->sppd_id }}"
                                    method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')


                                    <div class="float-right " style="{{ $hilang }}">
                                        <button type="submit" class="btn btn-primary">Edit Data SPPD</button>
                                    </div>


                                    <br><br>

                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col-lg-6 col-6">

                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Tanggal
                                                        Perintah</label>
                                                    <div class="col-sm-8">
                                                        <input type="date" class="form-control"
                                                            value="{{ \Carbon\Carbon::parse($sppd->created_at)->format('Y-m-d') }}"
                                                            disabled>

                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Tanggal
                                                        Pelaksanaan</label>
                                                    <div class="col-sm-8">
                                                        <input type="date" class="form-control" name="tgl_pelaksanaan"
                                                            placeholder="Tanggal Pelaksanaan"
                                                            value="{{ $sppd->tgl_pelaksanaan }}">
                                                    </div>
                                                </div>



                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Anggaran</label>
                                                    <div class="input-group col-sm-8">
                                                        <input type="text" name="anggaran" id="anggaran"
                                                            class="form-control "
                                                            value="{{ number_format($sppd->anggaran, 0, ',', '.') }}">
                                                        <p class="input-group-text"
                                                            style=" width: 100px;height:37px;max-height:100%;">Rupiah
                                                        </p>
                                                    </div>

                                                </div>

                                            </div>


                                            <div class="col-lg-6 col-6">


                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Perihal Surat</label>
                                                    <div class="col-sm-8">
                                                        <textarea class="form-control" class="form-control" name="perihal" style="width: 100%" rows="6">{{ $sppd->perihal }}</textarea>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </form>

                            </div>
                        @endif

                        <div class="{{ $active }}tab-pane" id="file">
                            <!-- Post -->
                            <div class="col-md-12 ">
                                <!-- general form elements -->

                                <div class="row  ml-4 justify-content-between">
                                    <div>

                                        <button type="button" class="btn btn-success" data-toggle="modal"
                                            data-target="#unggah" style="{{ $hilang }}">
                                            Tambah File Lampiran
                                        </button>

                                    </div>
                                    <div class="col-auto mr-3">
                                        <div class="col-auto">
                                            <!-- Button trigger modal -->


                                            <!-- Modal -->
                                            <div class="modal fade" id="unggah" tabindex="-1" role="dialog"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">
                                                                Unggah File</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="/{{ $role }}/arsip/aksi_tambah_lampiran"
                                                            method="post" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="form-group">

                                                                    <input type="hidden" name="arsip_digital_id"
                                                                        value="{{ $id_arsip }}">
                                                                    <label>Nama</label>
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Masukan Judul" name="nama"
                                                                        required>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="col-4 col-form-label">Jenis
                                                                        File</label>


                                                                    <select class="form-control" name="jenis"
                                                                        data-placeholder="Masukan Jenis File" required>
                                                                        <option value="">Pilih Jenis
                                                                            File</option>
                                                                        <option value="Scan Surat">Scan
                                                                            Surat</option>
                                                                        <option value="Lampiran">Lampiran
                                                                        </option>
                                                                    </select>

                                                                </div>

                                                                <div class="form-group">
                                                                    <label>File</label>
                                                                    <input type="file"
                                                                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                                                        class="form-control" name="file" required>
                                                                </div>




                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal"><i class="fas fa-ban"></i>
                                                                    Batal</button>
                                                                <button type="submit" name="submit"
                                                                    class="btn btn-success"><i class="fas fa-save"></i>
                                                                    Simpan </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                                <div class="card-body">

                                    <table id="example3" class="table table-bordered " style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Judul</th>
                                                <th>Jenis</th>
                                                <th>Waktu Upload</th>
                                                <th>Aksi</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($lampiran as $lam)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $lam->nama }}</td>
                                                    <td>{{ $lam->jenis }}</td>
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

                                                                @if ($stat == 'Diteruskan')
                                                                    <a onMouseOver="this.style.color='red'"
                                                                        onMouseOut="this.style.color='black'"
                                                                        class="dropdown-item" type="button"
                                                                        data-target="#edit_lampiran{{ $lam->lampiran_arsip_id }}"
                                                                        data-toggle="modal">
                                                                        Ganti</a>
                                                                    <!-- Modal -->
                                                                @endif

                                                                <a onMouseOver="this.style.color='red'"
                                                                    onMouseOut="this.style.color='black'"
                                                                    class="dropdown-item"
                                                                    href="{{ asset('lampiran/' . $lam->file . '') }}"
                                                                    type="button" target="_blank">
                                                                    Cetak</a>

                                                                @if ($stat == 'Diteruskan')
                                                                    <form
                                                                        action="/{{ $role }}/arsip/aksi_hapus_lampiran/{{ $lam->lampiran_arsip_id }}"
                                                                        method="post" enctype="multipart/form-data">
                                                                        @csrf
                                                                        <button onMouseOver="this.style.color='red'"
                                                                            onMouseOut="this.style.color='black'"
                                                                            class="dropdown-item " type="submit">
                                                                            Hapus</button>
                                                                    </form>
                                                                @endif


                                                            </div>

                                                    </td>

                                                </tr>

                                                <div class="modal fade" id="edit_lampiran{{ $lam->lampiran_arsip_id }}"
                                                    role="dialog" aria-labelledby="exampleModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">
                                                                    Edit File</h5>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form
                                                                action="/{{ $role }}/arsip/aksi_edit_lampiran/{{ $lam->lampiran_arsip_id }}"
                                                                method="post" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="form-group">

                                                                        <input type="hidden" name="arsip_digital_id"
                                                                            value="{{ $id_arsip }}">
                                                                        <label>Nama</label>
                                                                        <input value="{{ $lam->nama }}" type="text"
                                                                            class="form-control"
                                                                            placeholder="Masukan Judul" name="nama"
                                                                            required>
                                                                    </div>

                                                                    <input type="hidden" name="file_lama"
                                                                        value="{{ $lam->file }}">

                                                                    <div class="form-group">
                                                                        <label class="col-4 col-form-label">Jenis
                                                                            File</label>


                                                                        <select class="form-control" name="jenis"
                                                                            data-placeholder="Masukan Jenis File" required>
                                                                            <option value="{{ $lam->jenis }}">
                                                                                {{ $lam->jenis }}
                                                                            </option>
                                                                            <option value="Scan Surat">
                                                                                Scan Surat
                                                                            </option>
                                                                            <option value="Lampiran">
                                                                                Lampiran
                                                                            </option>
                                                                        </select>

                                                                    </div>

                                                                    <input type="hidden" name="lam_lama"
                                                                        value="{{ $lam->file }}">
                                                                    <div class="form-group">
                                                                        <label>File</label>
                                                                        <input type="file" class="form-control"
                                                                            name="file">
                                                                    </div>


                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Tutup</button>
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Simpan</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>


                                </div>
                                @endforeach

                                </thead>



                                </table>

                            </div>



                        </div>



                    </div>
                </div>

                <!-- ---------------------- -->


                <!-- /Post -->

            </div>

        </div>
        <!-- /.tab-content -->

    </section>

@endsection

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
