@extends('main')

@section($act, 'active')
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
                            @if (Auth::user()->gocap_id_pc_pengurus != null)
                                @if ($hal == 'pc')
                                    <a href="/{{ $role }}/dashboard">Dashboard</a> / <a
                                        href="/{{ $role }}/arsip/surat_masuk_pc/{{ $hal }}"> Surat Masuk
                                        Kepada
                                        LAZISNU</a> /
                                    <a>{{ $page }}</a>
                                @else
                                    <a href="/{{ $role }}/dashboard">Dashboard</a> / <a
                                        href="/{{ $role }}/arsip/surat_masuk_pc/{{ $hal }}"> Surat Masuk
                                        Kepada UPZIS</a>
                                    /
                                    <a>{{ $page }}</a>
                                @endif
                            @elseif(Auth::user()->gocap_id_upzis_pengurus != null)
                                @if ($hal == 'pc')
                                    <a href="/{{ $role }}/dashboard">Dashboard</a> / <a
                                        href="/{{ $role }}/arsip/surat_masuk_upzis/{{ $hal }}"> Surat
                                        Masuk
                                        Kepada
                                        LAZISNU</a> /
                                    <a>{{ $page }}</a>
                                @else
                                    <a href="/{{ $role }}/dashboard">Dashboard</a> / <a
                                        href="/{{ $role }}/arsip/surat_masuk_upzis/{{ $hal }}"> Surat
                                        Masuk
                                        Kepada UPZIS</a>
                                    /
                                    <a>{{ $page }}</a>
                                @endif
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


    <section class="content">
        <div class="container-fluid ">
            <!-- Form Element sizes -->
            @php
                $rul = strtolower($role);
            @endphp

            <div class="card card-success">

                <div class="card-body">

                    <div class="card card-success ijo-atas intro-table-detail-rincian-arsip-sm">
                        <div class="row mt-4 ml-4 justify-content-between">
                            <div>
                                <h3 class="card-title "><b>Rincian Surat Masuk</b>
                                </h3>
                            </div>
                            <div class="col-auto mr-3">
                                {{-- <a href="/{{ $role }}/arsip/print_disposisi/{{ $arsip->arsip_digital_id }}"
                                        type="button" class="btn btn-danger" target="_blank"><i class="fas fa-print"></i>
                                        Cetak Disposisi</a> --}}



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

                                            <!-- Form Element sizes -->
                                            <form
                                                action="/{{ $role }}/arsip/proses_edit_surat_masuk/{{ $arsip->arsip_digital_id }}"
                                                method="post" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')

                                                <div class="modal-body mt-2">

                                                    <div class="form-row mt-4">

                                                        <div class="form-group col-md-6">
                                                            <label>Nomor Surat&nbsp;</label>
                                                            <sup class="badge badge-danger text-white mb-2"
                                                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                            <input type="text" class="form-control" name="nomor_surat"
                                                                placeholder="Masukan Nomor Surat"
                                                                value="{{ $arsip->nomor_surat }}" required>
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <label>Klasifikasi Surat&nbsp;</label>
                                                            <sup class="badge badge-danger text-white mb-2"
                                                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                            <select class="form-control" name="klasifikasi_surat"
                                                                data-placeholder="Masukan Klasifikasi Surat" required>
                                                                <option value="{{ $arsip->klasifikasi_surat }}">
                                                                    {{ $arsip->klasifikasi_surat }}
                                                                </option>
                                                                <option value="Biasa">Biasa</option>
                                                                <option value="Khusus">Khusus</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <label>Perihal Surat&nbsp;</label>
                                                            <sup class="badge badge-danger text-white mb-2"
                                                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                            <input type="text" class="form-control"
                                                                name="perihal_isi_deskripsi"
                                                                placeholder="Masukan Perihal Surat"
                                                                value="{{ $arsip->perihal_isi_deskripsi }}" required>
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <label>Pengirim Surat&nbsp;</label>
                                                            <sup class="badge badge-danger text-white mb-2"
                                                                style="background-color:rgba(230,82,82)">WAJIB</sup>
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


                                                    <div class="float-right mb-3 mt-2 bd-highlight">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal"><i class="fas fa-ban"></i>
                                                            Batal</button>

                                                        <button onclick="$('#cover-spin').show(0)"
                                                            class="btn btn-success text-white toastrDefaultSuccess"
                                                            type="submit"><i class="fas fa-save"></i> Simpan
                                                            Perubahan</button>
                                                    </div>
                                                </div>
                                            </form>


                                        </div>
                                    </div>
                                </div>


                                @if ($info == 'Diteruskan')
                                    <a class="btn btn-secondary intro-ubah-arsip-surat-masukz ml-1 mr-0" type="button"
                                        data-toggle="modal" data-target="#staticTambah" aria-expanded="false">
                                        &nbsp;&nbsp;<i class="fas fa-edit"></i> Ubah Arsip Surat Masuk
                                    </a>
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
                                            <input type="date" class="form-control " name="tanggal_arsip"
                                                placeholder="Tanggal Arsip" value="{{ $arsip->tanggal_arsip }}" disabled>
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
                                                disabled>

                                        </div>
                                    </div>



                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Klasifikasi Surat</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="klasifikasi_surat"
                                                value=" {{ $arsip->klasifikasi_surat }}" disabled>

                                        </div>
                                    </div>

                                </div>

                                <div class="col-lg-6 col-6">

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Tujuan
                                            Surat</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control " name="tujuan_arsip"
                                                placeholder="Masukan Tujuan Surat" value="{{ $arsip->tujuan_arsip }}"
                                                disabled>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Pengirim
                                            Surat</label>
                                        <div class="col-sm-8">
                                            <input type="text" disabled class="form-control" name="pengirim_sumber"
                                                placeholder="Masukan Pengirim Surat"
                                                value="{{ $arsip->pengirim_sumber }}">
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
                                        <label class="col-sm-4 col-form-label">Perihal Surat</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="perihal_isi_deskripsi"
                                                disabled value="{{ $arsip->perihal_isi_deskripsi }}">

                                        </div>
                                    </div>

                                </div>

                            </div>



                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <!-- Form Element sizes -->


                    <!-- Form Element sizes -->
                    <div class="card  intro-detail-isi-arsip-sm">
                        <style>
                            .nav-pills .nav-link.active,
                            .nav-pills .show>.nav-link {
                                background-color: green;
                            }
                        </style>
                        <div class="card-header ijo-atas ">
                            <ul class="nav nav-pills" id="tabMenu">
                                @if ($disposisi)
                                    @php
                                        $active = '';
                                    @endphp
                                    @if ($disposisi)
                                        <li class="nav-item"><a class="nav-link active" id="tombol-disposisi-sm"
                                                href="#disposisi" data-toggle="tab">Disposisi</a></li>
                                    @endif
                                    @if ($sppd)
                                        <li class="nav-item"><a class="nav-link" href="#sppd" id="tombol-sppd-sm"
                                                data-toggle="tab">SPPD</a>
                                        </li>
                                    @endif
                                    <li class="nav-item"><a class="nav-link" href="#file" data-toggle="tab"
                                            id="tombol-disposisiZ-file">File</a>
                                    @else
                                        @php
                                            $active = 'active';
                                        @endphp
                                    <li class="nav-item"><a class="nav-link active" href="#file"
                                            data-toggle="tab">File</a>
                                @endif
                                </li>
                            </ul>
                        </div>

                        <div class="card-body">
                            <div class="tab-content">

                                @if ($info == 'Diteruskan')
                                    @php
                                        $hilang = '';
                                    @endphp
                                @else
                                    @php
                                        $hilang = 'display:none;';
                                    @endphp
                                @endif

                                @if ($disposisi)
                                    <div class="active tab-pane intro-table-disposisiz-sm" id="disposisi">

                                        <div class="row mt-0 ml-0 justify-content-between ">
                                            <div>
                                                <h3 class="card-title "><b>Disposisi Arsip Surat Masuk</b>
                                                </h3>
                                            </div>
                                            <div class="col-auto mr-3">
                                                @if ($info == 'Diteruskan')
                                                    <div class="float-right " style="{{ $hilang }}">
                                                        <button type="button"
                                                            class="btn btn-secondary intro-ubah-disposisiz-sm"
                                                            data-toggle="modal" data-target="#edit_disposisi"
                                                            style="{{ $hilang }}">
                                                            <i class="fas fa-edit"></i> Ubah Disposisi Arsip
                                                            Surat Masuk</button>
                                                    </div>


                                                    <!-- Modal -->
                                                    <div class="modal fade" id="edit_disposisi" tabindex="-1"
                                                        role="dialog" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header ">
                                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                                        Ubah Disposisi Arsip Surat Masuk</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form
                                                                    action="/{{ $role }}/arsip/proses_edit_disposisi/{{ $disposisi->disposisi_id }}"
                                                                    method="post" enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="modal-body">
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">Sifat
                                                                                Disposisi</label>
                                                                            <div class="col-sm-8">
                                                                                <select class="form-control"
                                                                                    name="sifat"
                                                                                    data-placeholder="Masukan Klasifikasi Surat"
                                                                                    required>
                                                                                    <option
                                                                                        value="{{ $disposisi->sifat }}">
                                                                                        Sifat
                                                                                        Disposisi
                                                                                        {{ $disposisi->sifat }}
                                                                                    </option>
                                                                                    <option value="Segera">Segera
                                                                                    </option>
                                                                                    <option value="Sangat Segera">
                                                                                        Sangat
                                                                                        Segera
                                                                                    </option>
                                                                                    <option value="Rahasia">Rahasia
                                                                                    </option>
                                                                                </select>

                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">Perihal
                                                                                Disposisi</label>
                                                                            <div class="col-sm-8">
                                                                                <input name="perihal" style="width: 100%"
                                                                                    value="{{ $disposisi->perihal }}"
                                                                                    class="form-control">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal"><i
                                                                                class="fas fa-ban"></i>
                                                                            Batal</button>
                                                                        <button onclick="$('#cover-spin').show(0)"
                                                                            type="submit" name="submit"
                                                                            class="btn btn-success"><i
                                                                                class="fas fa-save"></i>
                                                                            Simpan Perubahan </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- END Modal -->
                                                @endif


                                            </div>
                                            <!-- Button trigger modal -->
                                        </div>

                                        {{-- post --}}


                                        <br>
                                        <div class="card-body">

                                            <div class="row">
                                                <div class="col-lg-6 col-6">

                                                    {{-- <div class="form-group row">
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
                                        </div> --}}

                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Sifat Disposisi</label>
                                                        <div class="col-sm-8">
                                                            <input value="{{ $disposisi->sifat }}" class="form-control"
                                                                readonly>
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
                                                                    class="intro-status-baca-disposisiz-sm btn btn-success"
                                                                    data-toggle="modal" data-target="#statusbaca">
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
                                                                                        style="font-size:20px;">
                                                                                        <span
                                                                                            class="badge badge-{{ $warna }} ">{{ $stat }}</span>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach

                                                                            @foreach ($baca_upzis as $baca_upzis)
                                                                                <tr>

                                                                                    <td>{{ $baca_upzis->nama }} <span
                                                                                            class="badge rounded-pill  ">
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
                                                                                        style="font-size:20px;">
                                                                                        <span
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
                                                                                                {{ $item->jabatan }}
                                                                                            </span>
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
                                                                                        style="font-size:20px;">
                                                                                        <span
                                                                                            class="badge badge-{{ $warna }} ">{{ $stat }}</span>
                                                                                    </td>


                                                                                </tr>
                                                                            @endforeach




                                                                        </tbody>
                                                                    </table>

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal"><i class="fas fa-ban"></i>
                                                                        Tutup</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="col-lg-6 col-6">


                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Perihal Disposisi</label>
                                                        <div class="col-sm-8">
                                                            <input readonly name="perihal" style="width: 100%"
                                                                class="form-control" value="{{ $disposisi->perihal }}">
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>


                                        </div>


                                        {{-- end post --}}
                                    </div>
                                @endif


                                @if ($sppd)
                                    <div class="tab-pane intro-table-sppdz-sm" id="sppd">
                                        <!-- Post -->

                                        <div class="row mt-0 ml-0 justify-content-between">
                                            <div>
                                                <h3 class="card-title "><b>SPPD Arsip Surat Masuk</b>
                                                </h3>
                                            </div>
                                            <div class="col-auto mr-3">
                                                @if ($info == 'Diteruskan')
                                                    <button type="button"
                                                        class="intro-ubah-sppd-sm btn btn-secondary float-right"
                                                        data-toggle="modal" data-target="#edit_sppd"
                                                        style="{{ $hilang }}">
                                                        <i class="fas fa-edit"></i> Ubah SPPD Arsip Surat
                                                        Masuk</button>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="edit_sppd" tabindex="-1" role="dialog"
                                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header ">
                                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                                        Ubah SPPD Arsip Surat Masuk</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form
                                                                    action="/{{ $role }}/arsip/proses_edit_sppd/{{ $sppd->sppd_id }}"
                                                                    method="post" enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="modal-body">
                                                                        <div class="form-group row">
                                                                            <label
                                                                                class="col-sm-4 col-form-label">Anggaran</label>
                                                                            <div class="input-group col-sm-8">
                                                                                <div class="input-group-prepend">
                                                                                    <span
                                                                                        class="input-group-text bor-abu">Rp</span>
                                                                                </div>
                                                                                <input type="text" name="anggaran"
                                                                                    id="anggaran" class="form-control "
                                                                                    value="{{ number_format($sppd->anggaran, 0, ',', '.') }}">

                                                                            </div>

                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">Perihal
                                                                                SPPD</label>
                                                                            <div class="col-sm-8">
                                                                                <input class="form-control"
                                                                                    class="form-control" name="perihal"
                                                                                    style="width: 100%"
                                                                                    value="{{ $sppd->perihal }}">

                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal"><i
                                                                                class="fas fa-ban"></i>
                                                                            Batal</button>
                                                                        <button onclick="$('#cover-spin').show(0)"
                                                                            type="submit" name="submit"
                                                                            class="btn btn-success"><i
                                                                                class="fas fa-save"></i>
                                                                            Simpan Perubahan </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- END Modal -->
                                                @endif
                                            </div>
                                            <!-- Button trigger modal -->
                                        </div>
                                        <br>
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
                                                            <input type="date" class="form-control"
                                                                name="tgl_pelaksanaan" placeholder="Tanggal Pelaksanaan"
                                                                value="{{ $sppd->tgl_pelaksanaan }}" readonly>
                                                        </div>
                                                    </div>




                                                </div>


                                                <div class="col-lg-6 col-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Anggaran</label>
                                                        <div class="input-group col-sm-8">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text bor-abu">Rp</span>
                                                            </div>
                                                            <input type="text" name="anggaran" id="anggaran"
                                                                class="form-control " readonly
                                                                value="{{ number_format($sppd->anggaran, 0, ',', '.') }}">

                                                        </div>

                                                    </div>



                                                    <div class="form-group row">
                                                        <label class="col-sm-4 col-form-label">Perihal SPPD</label>
                                                        <div class="col-sm-8">
                                                            <input readonly class="form-control" class="form-control"
                                                                name="perihal" style="width: 100%"
                                                                value="{{ $sppd->perihal }}">

                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>



                                    </div>
                                @endif

                                <div class="{{ $active }}tab-pane intro-table-filez-sm" id="file">
                                    <!-- Post -->

                                    <!-- general form elements -->

                                    <div class="row mt-0 ml-0 justify-content-between">
                                        <div>
                                            <h3 class="card-title "><b>Lampiran Arsip Surat Masuk</b>
                                            </h3>
                                        </div>
                                        <div class="col-auto mr-3">
                                            @if ($info == 'Diteruskan')
                                                <button type="button" class="btn btn-success intro-ubah-filez-sm"
                                                    data-toggle="modal" data-target="#unggah"
                                                    style="{{ $hilang }}">
                                                    <i class="fas fa-plus-circle" aria-hidden="true"></i> Tambah File
                                                    Lampiran
                                                </button>
                                            @endif
                                        </div>
                                        <!-- Button trigger modal -->
                                    </div>

                                    <!-- Modal -->
                                    <div class="modal fade" id="unggah" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header ">
                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                        Unggah Lampiran File Surat Masuk</h5>
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
                                                            <input type="text" class="form-control" id="namas"
                                                                placeholder="Masukan Judul" name="nama">
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-4 col-form-label">Jenis
                                                                File</label>


                                                            <select class="form-control" name="jenis" id="jeniss"
                                                                data-placeholder="Masukan Jenis File">
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
                                                            <input type="file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                                                class="form-control" name="file" id="files">
                                                        </div>




                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal"><i class="fas fa-ban"></i>
                                                            Batal</button>
                                                        <button type="submit" id="submits" class="btn btn-success"
                                                            onclick="$('#cover-spin').show(0)" disabled="disabled"><i
                                                                class="fas fa-save"></i>
                                                            Simpan Lampiran</button>

                                                        <script type="text/javascript">
                                                            var namas = true;
                                                            var jeniss = true;
                                                            var files = true;

                                                            (function() {

                                                                $('#namas').keyup(function() {
                                                                    console.log($('#namas').val());
                                                                    $('#namas').each(function() {
                                                                        if ($(this).val() != '') {
                                                                            namas = false;
                                                                        } else {
                                                                            namas = true;
                                                                        }
                                                                        myfung();
                                                                    });
                                                                });

                                                                $('#jeniss').on('change', function() {
                                                                    console.log($('#jeniss').val());
                                                                    if ($('#jeniss').val() != '') {
                                                                        jeniss = false;
                                                                    } else {
                                                                        jeniss = true;
                                                                    }
                                                                    myfung();
                                                                    // console.log()
                                                                });

                                                                $('#files').on('change', function() {
                                                                    console.log($('#files').val());
                                                                    if ($('#files').val() != '') {
                                                                        files = false;
                                                                    } else {
                                                                        files = true;
                                                                    }
                                                                    myfung();
                                                                    // console.log()
                                                                });

                                                            })()

                                                            function myfung() {
                                                                if (namas == true || jeniss == true || files == true) {
                                                                    $('#submits').attr('disabled', 'disabled');
                                                                } else {
                                                                    $('#submits').removeAttr('disabled');
                                                                }
                                                            }
                                                        </script>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END Modal -->

                                    <div class="card-body">
                                        <div class="table-responsive">
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

                                                                        @if ($info == 'Diteruskan')
                                                                            <a onMouseOver="this.style.color='red'"
                                                                                onMouseOut="this.style.color='black'"
                                                                                class="dropdown-item" type="button"
                                                                                data-target="#edit_lampiran{{ $lam->lampiran_arsip_id }}"
                                                                                data-toggle="modal">
                                                                                <i class="fas fa-edit"></i> Ubah</a>
                                                                            <!-- Modal -->
                                                                        @endif

                                                                        <a onMouseOver="this.style.color='red'"
                                                                            onMouseOut="this.style.color='black'"
                                                                            class="dropdown-item"
                                                                            href="{{ asset('lampiran/' . $lam->file . '') }}"
                                                                            type="button" target="_blank">
                                                                            <i class="fas fa-print"></i> Cetak</a>

                                                                        @if ($info == 'Diteruskan')
                                                                            <a onMouseOver="this.style.color='red'"
                                                                                style=""
                                                                                onMouseOut="this.style.color='black'"
                                                                                class="dropdown-item" type="button"
                                                                                data-target="#modal_hapus{{ $lam->lampiran_arsip_id }}"
                                                                                data-toggle="modal"><i
                                                                                    class="fas fa-trash"></i>
                                                                                Hapus</a>
                                                                        @endif


                                                                    </div>

                                                                    {{-- modal hapus --}}
                                                                    <div class="modal fade"
                                                                        id="modal_hapus{{ $lam->lampiran_arsip_id }}"
                                                                        role="dialog" aria-labelledby="exampleModalLabel"
                                                                        aria-hidden="true">
                                                                        <div class="modal-dialog" role="document">
                                                                            <div class="modal-content">
                                                                                <form
                                                                                    action="/{{ $role }}/arsip/aksi_hapus_lampiran/{{ $lam->lampiran_arsip_id }}"
                                                                                    method="post">
                                                                                    @csrf
                                                                                    <div class="modal-header">

                                                                                        <h5 class="modal-title"
                                                                                            id="exampleModalLabel">
                                                                                            <b>Konfirmasi
                                                                                                Hapus</b>
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

                                                        </tr>

                                                        <div class="modal fade"
                                                            id="edit_lampiran{{ $lam->lampiran_arsip_id }}"
                                                            role="dialog" aria-labelledby="exampleModalLabel"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header ">
                                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                                            Edit File Arsip Dokumen</h5>
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

                                                                                <input type="hidden"
                                                                                    name="arsip_digital_id"
                                                                                    value="{{ $id_arsip }}">
                                                                                <label>Nama</label>
                                                                                <input value="{{ $lam->nama }}"
                                                                                    type="text" class="form-control"
                                                                                    placeholder="Masukan Judul"
                                                                                    name="nama" required>
                                                                            </div>

                                                                            <input type="hidden" name="file_lama"
                                                                                value="{{ $lam->file }}">

                                                                            <div class="form-group">
                                                                                <label class="col-4 col-form-label">Jenis
                                                                                    File</label>


                                                                                <select class="form-control"
                                                                                    name="jenis"
                                                                                    data-placeholder="Masukan Jenis File"
                                                                                    required>
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
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-dismiss="modal"><i
                                                                                    class="fas fa-ban"></i>
                                                                                Batal</button>

                                                                            <button onclick="$('#cover-spin').show(0)"
                                                                                class="btn btn-success text-white toastrDefaultSuccess"
                                                                                type="submit"><i class="fas fa-save"></i>
                                                                                Simpan
                                                                                Perubahan</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
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

                <!-- ---------------------- -->


                <!-- /Post -->

            </div>

        </div>
        <!-- /.tab-content -->

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

    @push('intro_detail_surat_masuk')
    <script>
        function klikkene(value) {
            introJs().setOptions({
                    steps: [{
                            element: document.querySelector('.intro-table-detail-rincian-arsip-sm'),
                            title: 'Detail Rincian Surat Masuk',
                            intro: 'Menampilkan Seluruh Data Rincian Surat Masuk '
                        },
                        @if ($info == 'Diteruskan')
                            {
                                element: document.querySelector('.intro-ubah-arsip-surat-masukz'),
                                title: 'Ubah Surat Masuk',
                                intro: 'Klik Disini Untuk Melakukan Ubah Rincian Surat Masuk'
                            },
                        @endif {
                            element: document.querySelector('.intro-detail-isi-arsip-sm'),
                            title: 'Detail Surat Masuk',
                            intro: 'Menampilkan Disposisi, SPPD, Serta File Arsip Jika Ada'
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

        {{-- <script>
            var yes = document.getElementById("tombol-disposisi-sm");
            yes.onclick = function() {
                introJs().setOptions({
                        steps: [{
                                element: document.querySelector('.intro-table-disposisiz-sm'),
                                title: 'Disposisi / Tembusan ',
                                intro: 'Menampilkan Data Disposisi Surat'
                            },
                            {
                                element: document.querySelector('.intro-ubah-disposisiz-sm'),
                                title: 'Ubah Disposisi',
                                intro: 'Klik Disini Untuk Mengubah Disposisi'
                            },
                            {
                                element: document.querySelector('.intro-status-baca-disposisiz-sm'),
                                title: 'Lihat Status Baca',
                                intro: 'Klik Disini Untuk Melihat Status Surat Yang Sudah Dibaca Maupun Belum'
                            }
                        ]
                    }).setOption("dontShowAgainLabel", " Jangan Tampilkan Lagi")
                    .setOption("nextLabel", "Lanjut")
                    .setOption("prevLabel", "Kembali")
                    .setOption("doneLabel", "Selesai")
                    .setOptions({
                        showProgress: true,
                    }).start();
            }
        </script>

        <script>
            var yes = document.getElementById("tombol-sppd-sm");
            yes.onclick = function() {
                introJs().setOptions({
                        steps: [{
                                element: document.querySelector('.intro-table-sppdz-sm'),
                                title: 'SPPD ',
                                intro: 'Menampilkan Detail Data SPPD Surat'
                            },
                            {
                                element: document.querySelector('.intro-ubah-sppd-sm'),
                                title: 'Ubah SPPD',
                                intro: 'Klik Disinii Untuk Mengubah SPPD'
                            }
                        ]
                    }).setOption("dontShowAgainLabel", " Jangan Tampilkan Lagi")
                    .setOption("nextLabel", "Lanjut")
                    .setOption("prevLabel", "Kembali")
                    .setOption("doneLabel", "Selesai")
                    .setOptions({
                        showProgress: true,
                    }).start();
            }
        </script>

        <script>
            var yes = document.getElementById("tombol-disposisiZ-file");
            yes.onclick = function() {
                introJs().setOptions({
                        steps: [{
                                element: document.querySelector('.intro-table-filez-sm'),
                                title: 'File Arsip Surat Masuk',
                                intro: 'Menampilkan File Lampiran Surat Masuk'
                            },
                            {
                                element: document.querySelector('.intro-ubah-filez-sm'),
                                title: 'Ubah File Surat Masuk',
                                intro: 'Klik Disini Untuk Mengubah File Surat Masuk'
                            }
                        ]
                    }).setOption("dontShowAgainLabel", " Jangan Tampilkan Lagi")
                    .setOption("nextLabel", "Lanjut")
                    .setOption("prevLabel", "Kembali")
                    .setOption("doneLabel", "Selesai")
                    .setOptions({
                        showProgress: true,
                    }).start();
            }
        </script> --}}
    @endpush


@endsection
