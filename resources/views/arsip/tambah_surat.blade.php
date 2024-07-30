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
                                        href="/{{ $role }}/arsip/surat_masuk_pc/pc">Surat Masuk</a> /
                                    <a>{{ $page }}</a>
                                @elseif($hal == 'upzis')
                                    <a href="/{{ $role }}/dashboard">Dashboard</a> / <a
                                        href="/{{ $role }}/arsip/surat_masuk_pc/upzis">Surat Masuk</a> /
                                    <a>{{ $page }}</a>
                                @endif
                            @elseif(Auth::user()->gocap_id_upzis_pengurus != null)
                                @if ($hal == 'pc')
                                    <a href="/{{ $role }}/dashboard">Dashboard</a> / <a
                                        href="/{{ $role }}/arsip/surat_masuk_upzis/pc">Surat Masuk</a> /
                                    <a>{{ $page }}</a>
                                @elseif($hal == 'upzis')
                                    <a href="/{{ $role }}/dashboard">Dashboard</a> / <a
                                        href="/{{ $role }}/arsip/surat_masuk_upzis/upzis">Surat Masuk</a> /
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
    <!-- /.content-header -->



    <!-- Main content -->
    <!-- /.content-header -->
    <section class="content">
        <div class="container-fluid ">
            <!-- Form Element sizes -->
            @php
                $rul = strtolower($role);
            @endphp
            <form method="post" action="/{{ $role }}/aksi_tambah_surat_masuk" enctype="multipart/form-data">
                @csrf
                <input type="hidden" value="{{ $role }}" name="role">
                <div class="card card-success">
                    <div class="card-body">
                        <!-- Surat Masuk -->
                        <div class="card card-success ijo-atas intro-table-rincian-arsip-sm">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12 col-12 mb-3 justify-content-between">
                                        <div>
                                            <h3 class="card-title "><b>Rincian Surat Masuk</b>
                                            </h3>


                                            &nbsp; <a class="sweet-tooltip" data-style-tooltip="tooltip-mini-slick"
                                                id="panduan-tambah-surat-masuk"><i class="far fa-question-circle"></i></a>

                                        </div>
                                    </div>


                                    <div class="col-lg-6 col-6">

                                        <div class="form-group row intro-tgl-arsip-sm">
                                            <label class="col-sm-4 col-form-label">Tanggal
                                                Index</label>
                                            <div class="col-sm-8">
                                                <input type="date"
                                                    class=" form-control  @error('tanggal_index') is-invalid @enderror"
                                                    name="tanggal_index" placeholder=" Tanggal Index"
                                                    value="{{ old('created_at') }}">
                                                @error('tanggal_index')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="form-group row intro-tgl-arsip-sm">
                                            <label class="col-sm-4 col-form-label">Tanggal
                                                Surat</label>
                                            <div class="col-sm-8">
                                                <input type="date"
                                                    class=" form-control  @error('tanggal_arsip') is-invalid @enderror"
                                                    name="tanggal_arsip" placeholder=" Tanggal Arsip"
                                                    value="{{ old('tanggal_arsip') }}">
                                                @error('tanggal_arsip')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                        </div>

                                        <div class="form-group row intro-nomor-sm">
                                            <label class="col-sm-4 col-form-label">Nomor Surat</label>
                                            <div class="col-sm-8">
                                                <input type="text" autocomplete="off"
                                                    class="form-control @error('nomor_surat') is-invalid @enderror"
                                                    name="nomor_surat" placeholder=" Masukan Nomor Surat"
                                                    value="{{ old('nomor_surat') }}">
                                                @error('nomor_surat')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row intro-klasifikasi-sm">
                                            <label class="col-sm-4 col-form-label">Klasifikasi Surat</label>
                                            <div class="col-sm-8">
                                                <select
                                                    class="form-control @error('klasifikasi_surat') is-invalid @enderror"
                                                    name="klasifikasi_surat">
                                                    <option value="" disabled selected hidden>Masukan Klasifikasi
                                                        Surat</option>
                                                    <option value="Biasa"
                                                        {{ old('klasifikasi_surat') == 'Biasa' ? 'selected' : '' }}>Biasa (
                                                        A.I )</option>
                                                    <option value="Khusus"
                                                        {{ old('klasifikasi_surat') == 'Khusus' ? 'selected' : '' }}>Khusus
                                                        ( A.II )</option>
                                                </select>
                                                @error('klasifikasi_surat')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="form-group row intro-bentuk-sm">
                                            <label class="col-sm-4 col-form-label">Bentuk Surat</label>
                                            <div class="col-sm-8">
                                                <select class="form-control @error('bentuk_surat') is-invalid @enderror"
                                                    name="bentuk_surat">
                                                    <option value="" disabled selected>Masukan Bentuk Surat</option>
                                                    <option value="Surat Asli"
                                                        {{ old('bentuk_surat') == 'Surat Asli' ? 'selected' : '' }}>Surat
                                                        Asli</option>
                                                    <option value="Surat via Email"
                                                        {{ old('bentuk_surat') == 'Surat via Email' ? 'selected' : '' }}>
                                                        Surat via Email</option>
                                                    <option value="Surat via Whatsapp"
                                                        {{ old('bentuk_surat') == 'Surat via Whatsapp' ? 'selected' : '' }}>
                                                        Surat via Whatsapp</option>
                                                </select>
                                                @error('bentuk_surat')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row intro-tujuan-sm">
                                            <label class="col-sm-4 col-form-label">Tujuan Surat</label>
                                            <div class="col-sm-8">
                                                <select class="form-control @error('tujuan_surat') is-invalid @enderror"
                                                    name="tujuan_surat">
                                                    <option value="" disabled selected hidden>Masukan Tujuan Surat
                                                    </option>
                                                    <option value="Undangan"
                                                        {{ old('tujuan_surat') == 'Undangan' ? 'selected' : '' }}>Undangan
                                                    </option>
                                                    <option value="Permohonan"
                                                        {{ old('tujuan_surat') == 'Permohonan' ? 'selected' : '' }}>
                                                        Permohonan</option>
                                                    <option value="Laporan"
                                                        {{ old('tujuan_surat') == 'Laporan' ? 'selected' : '' }}>Laporan
                                                    </option>
                                                    <option value="Lainnya"
                                                        {{ old('tujuan_surat') == 'Lainnya' ? 'selected' : '' }}>Lainnya
                                                    </option>
                                                </select>
                                                @error('tujuan_surat')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- <style>
                                            #radioBtn .notActive {
                                                color: #3276b1;
                                                background-color: #fff;
                                            }
                                        </style>

                                        

                                        <div class="form-group row intro-disposisi-sm">
                                            <label class="col-sm-4 col-form-label">Disposisi / Tembusan</label>

                                            <div class="col-sm-8">
                                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                    <label class="btn btn-outline-primary active"
                                                        id="tombol-disposisi1_label">
                                                        <input type="radio" name="disposisi_ya" id="tombol-disposisi1"
                                                            autocomplete="off"> Ya
                                                    </label>
                                                    <label class="btn btn-outline-primary " id="tombol-disposisi2_label">
                                                        <input type="radio" name="disposisi_tidak" id="tombol-disposisi2"
                                                            autocomplete="off" checked>
                                                        Tidak
                                                    </label>

                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>

                                    <div class="col-lg-6 col-6">

                                        {{-- <div class="form-group row intro-tujuan-sm">
                                            <label class="col-sm-4 col-form-label">Ditujukan Kepada</label>
                                            <div class="col-sm-8">
                                                @if (Auth::user()->gocap_id_pc_pengurus != null)
                                                    <input type="text"
                                                        class="form-control @error('tujuan_arsip') is-invalid @enderror"
                                                        name="tujuan_arsip" placeholder="Masukan Tujuan Surat"
                                                        value="PC Lazisnu Cilacap" readonly>
                                                @elseif (Auth::user()->gocap_id_upzis_pengurus != null)
                                                    <input type="text"
                                                        class="form-control @error('tujuan_arsip') is-invalid @enderror"
                                                        name="tujuan_arsip" placeholder="Masukan Tujuan Surat"
                                                        value="Upzis {{ $wilayah }}" readonly>
                                                @endif

                                                @error('tujuan_arsip')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div> --}}

                                        @if (Auth::user()->gocap_id_pc_pengurus != null)
                                            <input type="hidden" name="tujuan_arsip" value="PC Lazisnu Cilacap">
                                        @elseif (Auth::user()->gocap_id_upzis_pengurus != null)
                                            <input type="hidden" name="tujuan_arsip" value="Upzis {{ $wilayah }}">
                                        @endif


                                        {{-- <div class="form-group row intro-diinput-sm">
                                            <label class="col-sm-4 col-form-label">Diinput Oleh</label>
                                            <div class="col-sm-8">
                                                @if (Auth::user()->gocap_id_pc_pengurus != null)
                                                    <input type="text"
                                                        class="form-control @error('diinput_oleh') is-invalid @enderror"
                                                        name="diinput_oleh" value="{{ Auth::user()->nama }}" readonly>
                                                @elseif (Auth::user()->gocap_id_upzis_pengurus != null)
                                                    <input type="text"
                                                        class="form-control @error('diinput_oleh') is-invalid @enderror"
                                                        name="diinput_oleh" value="Upzis {{ $wilayah }}" readonly>
                                                @endif

                                                @error('diinput_oleh')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div> --}}

                                        <div class="form-group row intro-pengirim-sm">
                                            <label class="col-sm-4 col-form-label">Pengirim
                                                Surat</label>
                                            <div class="col-sm-8">
                                                <input type="text" autocomplete="off"
                                                    class="form-control @error('pengirim_sumber') is-invalid @enderror"
                                                    name="pengirim_sumber" placeholder="Masukan Pengirim Surat"
                                                    value="{{ old('pengirim_sumber') }}">
                                                @error('pengirim_sumber')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                            </div>
                                        </div>

                                        <style>
                                            /* Aturan CSS untuk tampilan desktop */
                                            @media (min-width: 768px) {
                                                .form-control-alamat {
                                                    min-height: 92px;
                                                    /* Atur sesuai kebutuhan Anda */
                                                }

                                                .form-control-pokok-isi {
                                                    min-height: 92px;
                                                    /* Atur sesuai kebutuhan Anda */
                                                }
                                            }
                                        </style>

                                        <div class="form-group row intro-alamat-sm">
                                            <label class="col-sm-4 col-form-label">Alamat Pengirim</label>
                                            <div class="col-sm-8">
                                                <textarea class="form-control form-control-alamat @error('alamat_pengirim') is-invalid @enderror"
                                                    name="alamat_pengirim" placeholder="Masukan Alamat Pengirim">{{ old('alamat_pengirim') }}</textarea>
                                                @error('alamat_pengirim')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- <div class="form-group row">
                                            <label  class="col-sm-4 col-form-label">Lampiran</label>
                                            <div class="input-group col-sm-8">
                                                <input type="text" name="pengeluaran_kegiatan"
                                                    id="pengeluaran_kegiatan" class="form-control " placeholder="">
                                                <p class="input-group-text"
                                                    style=" width: 100px;height:37px;max-height:100%;">File</p>
                                            </div>
                                        </div> --}}

                                        <div class="form-group row intro-perihal-sm">
                                            <label class="col-sm-4 col-form-label">Perihal Surat</label>
                                            <div class="col-sm-8">
                                                <input
                                                    class="form-control @error('perihal_isi_deskripsi') is-invalid @enderror"
                                                    name="perihal_isi_deskripsi" placeholder="Masukan Perihal Surat"
                                                    value="{{ old('perihal_isi_deskripsi') }}">
                                                @error('perihal_isi_deskripsi')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row intro-keterangan-sm">
                                            <label class="col-sm-4 col-form-label">Pokok Isi Surat</label>
                                            <div class="col-sm-8">
                                                <textarea class="form-control form-control-pokok-isi @error('keterangan_surat_masuk') is-invalid @enderror"
                                                    name="keterangan_surat_masuk" placeholder="Masukan Pokok Isi Surat">{{ old('keterangan_surat_masuk') }}</textarea>
                                                @error('keterangan_surat_masuk')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                </div>



                            </div>
                            <!-- /.card-body -->
                        </div>

                        {{-- Disposisi --}}
                        <div class="card card-success ijo-atas intro-table-disposisi-sm">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12 col-12 mb-3 justify-content-between">
                                        <div>
                                            <h3 class="card-title"><b>Disposisi / Tembusan</b>
                                            </h3>
                                            &nbsp; <a id="panduan-tambah-disposisi-surat-masuk" class="sweet-tooltip"
                                                data-style-tooltip="tooltip-mini-slick"><i
                                                    class="far fa-question-circle"></i></a>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-12 intro-disposisi-sm">
                                        <div class="form-group row ">
                                            <label class="col-sm-2 col-form-label">Disposisi / Tembusan</label>
                                            <div class="col-sm-10">
                                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                    <label class="btn btn-outline-primary active"
                                                        id="tombol-disposisi1_label">
                                                        <input type="radio" name="disposisi_ya" id="tombol-disposisi1"
                                                            autocomplete="off"> Ya
                                                    </label>
                                                    <label class="btn btn-outline-primary " id="tombol-disposisi2_label">
                                                        <input type="radio" name="disposisi_tidak"
                                                            id="tombol-disposisi2" autocomplete="off" checked>
                                                        Tidak
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="disposisi-line" style="display: none;">
                                    <div class="row">
                                        <div class="col-lg-6 col-6 intro-kumpulan-jenis-disposisi">

                                            <div class="form-group row ">
                                                <label class="col-sm-4 col-form-label">Jenis Penerima</label>
                                                <div class="col-sm-8 ">
                                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                        <label
                                                            class="btn btn-outline-primary  active intro-select-satuan-sm intro-satuan-jenis-disposisi ">
                                                            <input type="radio" name="penerima_satuan"
                                                                id="tombol-jenis-disposisi1" autocomplete="off" checked>
                                                            <span>Satuan</span>
                                                        </label>
                                                        <label
                                                            class="btn btn-outline-primary intro-select-golongan-sm intro-golongan-jenis-disposisi">
                                                            <input type="radio" name="penerima_golongan"
                                                                id="tombol-jenis-disposisi2" autocomplete="off">
                                                            <span>Golongan</span>
                                                        </label>

                                                        <label
                                                            class="btn btn-outline-primary intro-select-internal-sm intro-internal-pc-jenis-disposisi">
                                                            <input type="radio" name="penerima_internal"
                                                                id="tombol-jenis-disposisi3" autocomplete="off">
                                                            <span>Internal</span>
                                                        </label>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group intro-golongan-jenis-select-disposisi" id="select2-golongan">
                                        <label>Golongan Penerima Disposisi</label>

                                        <select class="form-control @error('akses_golongan') is-invalid @enderror select2"
                                            multiple="multiple" data-placeholder="Masukan Golongan Penerima Disposisi"
                                            style="width: 100%;" name="akses_golongan[]">
                                            @foreach ($akses as $akses)
                                                <option value="{{ $akses }}"
                                                    {{ in_array($akses, old('akses_golongan') ?: []) ? 'selected' : '' }}>
                                                    {{ $akses }}</option>
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('akses_golongan')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="intro-satuan-jenis-select-disposisi">
                                        <div class="form-group" id="select2-satuan_upzis">
                                            <label>Upzis Penerima Disposisi</label>
                                            <select class="select2 @error('akses_satuan_upzis') is-invalid @enderror"
                                                multiple="multiple" data-placeholder="Masukan Upzis Penerima Disposisi"
                                                style="width: 100%;" name="akses_satuan_upzis[]">

                                                @foreach ($upzis as $upzis2)
                                                    <option value="{{ $upzis2->id_upzis }}"
                                                        {{ in_array($upzis2->id_upzis, old('akses_satuan_upzis') ?: []) ? 'selected' : '' }}>
                                                        {{ $upzis2->nama }}</option>
                                                    </option>
                                                @endforeach


                                            </select>

                                            @error('akses_satuan_upzis')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        

                                        @if (Auth::user()->gocap_id_upzis_pengurus != null)
                                            <div class="form-group" id="select2-satuan_pcnu">
                                                <label>PCNU Penerima Disposisi</label>
                                                <select class="select2 @error('akses_satuan_pc') is-invalid @enderror"
                                                    multiple="multiple" data-placeholder="Masukan PCNU Penerima Disposisi"
                                                    style="width: 100%;" name="akses_satuan_pc[]">

                                                    @foreach ($pc as $pc2)
                                                        <option value="{{ $pc2->id_pc }}"
                                                            {{ in_array($pc2->id_pc, old('akses_satuan_pc') ?: []) ? 'selected' : '' }}>
                                                            {{ $pc2->nama }}</option>
                                                        </option>
                                                    @endforeach


                                                </select>
                                                @error('akses_satuan_pc')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                            </div>
                                        @elseif (Auth::user()->gocap_id_pc_pengurus != null)
                                            <div class="form-group" id="select2-satuan_pcnu">
                                            </div>
                                        @endif

                                        <div class="form-group" id="select2-satuan_ranting">
                                            <label>Ranting Penerima Disposisi</label>
                                            <select class="select2 @error('akses_satuan_ranting') is-invalid @enderror"
                                                multiple="multiple" data-placeholder="Masukan Ranting Penerima Disposisi"
                                                style="width: 100%;" name="akses_satuan_ranting[]">

                                                @foreach ($ranting as $ranting2)
                                                    <option value="{{ $ranting2->id_ranting }}"
                                                        {{ in_array($ranting2->id_ranting, old('akses_satuan_ranting') ?: []) ? 'selected' : '' }}>
                                                        {{ $ranting2->nama }}</option>
                                                    </option>
                                                @endforeach

                                            </select>
                                            @error('akses_satuan_ranting')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    


                                    <div class="intro-internal-pc-select-jenis-disposisi">
                                        @if (Auth::user()->gocap_id_pc_pengurus != null)
                                            <div class="form-group" id="select2-internal">
                                                <label>Pengurus Internal Penerima Disposisi</label>
                                                <input type="hidden" name="id_pc"
                                                    value="{{ Auth::user()->PcPengurus->Pc->id_pc }}">

                                                <select class="select2 @error('akses_internal') is-invalid @enderror"
                                                    multiple="multiple"
                                                    data-placeholder="Masukan Pengurus Internal Penerima Disposisi"
                                                    style="width: 100%;" name="akses_internal[]">


                                                    @foreach ($pengurus as $pengurus2)
                                                        @php
                                                            $jabatans = DB::connection('gocap')
                                                                ->table('pengurus_jabatan')
                                                                ->where(
                                                                    'id_pengurus_jabatan',
                                                                    $pengurus2->id_pengurus_jabatan,
                                                                )
                                                                ->select('jabatan')
                                                                ->get();
                                                        @endphp
                                                        <option value="{{ $pengurus2->id_pc_pengurus }}"
                                                            {{ in_array($pengurus2->id_pc_pengurus, old('akses_internal') ?: []) ? 'selected' : '' }}>
                                                            {{ $pengurus2->nama }}
                                                            @foreach ($jabatans as $item)
                                                                <span class="badge rounded-pill  bg-danger">
                                                                    ({{ $item->jabatan }})
                                                                </span>
                                                            @endforeach
                                                        </option>
                                                        </option>
                                                    @endforeach

                                                </select>

                                                @error('akses_internal')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        @endif


                                        @if (Auth::user()->gocap_id_upzis_pengurus != null)
                                            <div class="form-group" id="select2-internal">
                                                <label>Hak Akses Internal</label>
                                                <input type="hidden" name="id_upzis"
                                                    value="{{ Auth::user()->UpzisPengurus->Upzis->id_upzis }}">

                                                <select class="select2 @error('akses_internal') is-invalid @enderror"
                                                    multiple="multiple" data-placeholder="Masukan Hak Akses Arsip"
                                                    style="width: 100%;" name="akses_internal[]">

                                                    @foreach ($pengurus as $pengurus2)
                                                        <option value="{{ $pengurus2->id_upzis_pengurus }}"
                                                            {{ in_array($pengurus2->id_upzis_pengurus, old('akses_internal') ?: []) ? 'selected' : '' }}>
                                                            {{ $pengurus2->nama }}</option>
                                                        </option>
                                                    @endforeach

                                                </select>

                                                @error('akses_internal')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        @endif
                                    </div>

                                    <div class="form-group" id="select2-catatan">
                                        <label>Catatan</label>
                                        <select class="select2 @error('catatan_disposisi') is-invalid @enderror" multiple="multiple" data-placeholder="Masukan Catatan Disposisi" style="width: 100%;" name="catatan_disposisi[]">
                                            <option value="Dijawab dengan surat" {{ in_array('Dijawab dengan surat', old('catatan_disposisi', $catatan_disposisi ?? [])) ? 'selected' : '' }}>Dijawab dengan surat</option>
                                            <option value="Untuk diketahui" {{ in_array('Untuk diketahui', old('catatan_disposisi', $catatan_disposisi ?? [])) ? 'selected' : '' }}>Untuk diketahui</option>
                                            <option value="Untuk bahan rapat" {{ in_array('Untuk bahan rapat', old('catatan_disposisi', $catatan_disposisi ?? [])) ? 'selected' : '' }}>Untuk bahan rapat</option>
                                            <option value="Minta persetujuan" {{ in_array('Minta persetujuan', old('catatan_disposisi', $catatan_disposisi ?? [])) ? 'selected' : '' }}>Minta persetujuan</option>
                                            <option value="Masuk Arsip" {{ in_array('Masuk Arsip', old('catatan_disposisi', $catatan_disposisi ?? [])) ? 'selected' : '' }}>Masuk Arsip</option>
                                            <option value="Dijawab sesuai disposisi" {{ in_array('Dijawab sesuai disposisi', old('catatan_disposisi', $catatan_disposisi ?? [])) ? 'selected' : '' }}>Dijawab sesuai disposisi</option>
                                            <option value="Selesaikan sesuai disposisi" {{ in_array('Selesaikan sesuai disposisi', old('catatan_disposisi', $catatan_disposisi ?? [])) ? 'selected' : '' }}>Selesaikan sesuai disposisi</option>
                                            <option value="Lainnya" {{ in_array('Lainnya', old('catatan_disposisi', $catatan_disposisi ?? [])) ? 'selected' : '' }}>Lainnya</option>
                                        </select>
                                        
                                        @error('catatan_disposisi')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-lg-6 col-6 ">
                                            <div class="form-group row intro-sifat-disposisi-sm">
                                                <label class="col-sm-4 col-form-label">Sifat</label>

                                                <div class="col-sm-8 ">

                                                    <select class="form-control @error('sifat') is-invalid @enderror"
                                                        name="sifat" data-placeholder="Masukan Klasifikasi Surat"
                                                        style="appearance:none;
                                                    -webkit-appearance:none;
                                                    -moz-appearance:none;
                                                   ">

                                                        @if (old('sifat') == 'Segera')
                                                            <option value="Segera" selected>Segera</option>
                                                            <option value="Sangat Segera">Sangat Segera
                                                            </option>
                                                            <option value="Rahasia">Rahasia</option>
                                                        @elseif(old('sifat') == 'Sangat Segera')
                                                            <option value="Segera">Segera</option>
                                                            <option value="Sangat Segera" selected>Sangat
                                                                Segera</option>
                                                            <option value="Rahasia">Rahasia</option>
                                                        @elseif(old('sifat') == 'Rahasia')
                                                            <option value="Segera">Segera</option>
                                                            <option value="Sangat Segera" selected>Sangat
                                                                Segera</option>
                                                            <option value="Rahasia" selected>Rahasia</option>
                                                        @else
                                                            <option value="" disabled selected hidden>Pilih Sifat
                                                                Disposisi
                                                            </option>
                                                            <option value="Segera">Segera</option>
                                                            <option value="Sangat Segera">Sangat Segera
                                                            </option>
                                                            <option value="Rahasia">Rahasia</option>
                                                        @endif



                                                    </select>
                                                    @error('sifat')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row intro-sppd-sm intro-sppd-disposisi-sm">
                                                <label class="col-sm-4 col-form-label">SPPD</label>
                                                <div class="col-sm-8">
                                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                        <label class="btn btn-outline-primary  active" id="sppd1actv1">
                                                            <input type="radio" name="sppd_ya" id="tombol-sppd1"
                                                                autocomplete="off"> Ya
                                                        </label>
                                                        <label class="btn btn-outline-primary " id="sppd1actv2">
                                                            <input type="radio" name="sppd_tidak" id="tombol-sppd2"
                                                                autocomplete="off" checked>
                                                            Tidak
                                                        </label>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-6">
                                            <div
                                                class="form-group row intro-perihal-disposisi-sm intro-perihal-disposisi-sm">
                                                <label class="col-sm-4 col-form-label">Isi Disposisi</label>
                                                <div class="col-sm-8">
                                                    <textarea class="form-control @error('perihal_disposisi') is-invalid @enderror" name="perihal_disposisi"
                                                        placeholder="Masukan Isi Disposisi" rows="3">{{ old('perihal_disposisi') }}</textarea>
                                                    @error('perihal_disposisi')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>

                        {{-- SPPD --}}
                        <div class="card card-success ijo-atas intro-table-sppds-sm" id="sppd-card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12 col-12 mb-3 justify-content-between">
                                        <div>
                                            <h3 class="card-title "><b>Rincian SPPD</b>
                                            </h3>
                                            &nbsp; <a href="#" class="sweet-tooltip"
                                                data-style-tooltip="tooltip-mini-slick"
                                                id="panduan-tambah-sppd-surat-masuk"><i
                                                    class="far fa-question-circle"></i></a>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-6">


                                        <div class="form-group row intro-sppd-tgl_perintah-sm">
                                            <label class="col-sm-4 col-form-label">Tgl
                                                Perintah</label>
                                            <div class="col-sm-8">
                                                <input type="date"
                                                    class="form-control  @error('tgl_perintah') is-invalid @enderror"
                                                    name="tgl_perintah" placeholder="Tanggal Perintah"
                                                    value="{{ old('tgl_perintah') }}">
                                                @error('tgl_perintah')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                            </div>
                                        </div>
                                        <div class="form-group row intro-sppd-tgl-pelaksanaan-sm">
                                            <label class="col-sm-4 col-form-label">Tgl
                                                Pelaksanaan</label>
                                            <div class="col-sm-8">
                                                <input type="date"
                                                    class="form-control @error('tgl_pelaksanaan') is-invalid @enderror"
                                                    name="tgl_pelaksanaan" placeholder="Tanggal Pelaksanaan"
                                                    value="{{ old('tgl_pelaksanaan') }}">
                                                @error('tgl_pelaksanaan')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-lg-6 col-6">
                                        <div class="form-group row intro-sppd-anggaran-sm">
                                            <label class="col-sm-4 col-form-label">Anggaran
                                            </label>
                                            <div class="input-group col-sm-8">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bor-abu">Rp</span>
                                                </div>
                                                <input type="text" name="anggaran" id="anggaran"
                                                    class="form-control @error('anggaran') is-invalid @enderror"
                                                    value="{{ old('anggaran') }}" placeholder="Estimasi Biaya">

                                                @error('anggaran')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row intro-sppd-perihal-sm">
                                            <label class="col-sm-4 col-form-label">Perihal SPPD
                                            </label>
                                            <div class="input-group col-sm-8">
                                                <input type="text" name="perihal_sppd" id="perihal_sppd"
                                                    class="form-control @error('perihal_sppd') is-invalid @enderror"
                                                    value="{{ old('perihal_sppd') }}" placeholder="Estimasi Biaya">
                                                @error('perihal_sppd')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Perihal SPPD</label>
                                            <div class="col-sm-8">
                                                <input class="form-control @error('perihal_sppd') is-invalid @enderror"
                                                    name="perihal_sppd" value="{{ old('perihal_sppd') }}"
                                                    placeholder="Masukan Perihal SPPD">
                                                @error('perihal_sppd')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div> --}}

                                    </div>

                                </div>
                                <br>

                            </div>
                            <!-- /.card-body -->
                        </div>

                        {{-- Lampiran --}}
                        <div class="card card-success ijo-atas intro-scan-masuk">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-lg-9 col-9">
                                        <h3 class="card-title">
                                            <b>Upload Lampiran</b>
                                        </h3>
                                        &nbsp; <a href="#" class="sweet-tooltip"
                                            data-style-tooltip="tooltip-mini-slick" id="panduan-tambah-files-surat-masuk">
                                            <i class="far fa-question-circle"></i>
                                        </a>
                                    </div>

                                    <div class="col-lg-3 col-3 text-lg-right">
                                        <button id="addRow" type="button"
                                            class="btn btn-primary intro-tambah-lampiran-sm ">
                                            <i class="fas fa-plus-circle" aria-hidden="true"></i> Tambah Lampiran
                                        </button>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-12">
                                        <label> Silahkan pilih file surat masuk anda. Ukuran maksimal file 2
                                            MB. Jenis dokumen yang diijinkan adalah: <b>jpg, doc, docx, pdf, jpeg,
                                                png</b></label><br>
                                    </div>

                                    <div class="form-group col-lg-12 col-12">
                                        <label>Scan Surat </label>
                                        <input style="width: 100%;"
                                            class="form-control @error('scan_surat') is-invalid @enderror"
                                            value="{{ old('nama_surat') }}" type="text" name="nama_surat"
                                            placeholder="Masukan Judul Surat" autocomplete="off">
                                        @error('nama_surat')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-lg-12 col-12">
                                        <input style="width: 100%;"
                                            class="form-control @error('scan_surat') is-invalid @enderror"
                                            value="{{ old('scan_surat') }}" class="form-control m-input" type="file"
                                            name="scan_surat" id="formFileSm"
                                            accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.xlsx" autocomplete="off">
                                        @error('scan_surat')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div id="newRow"></div>


                                <script type="text/javascript">
                                    // add row

                                    $("#addRow").click(function() {

                                        var html = '';

                                        html += '<div id="inputFormRow1">';
                                        html += '<label class="col-form-label">Lampiran</label > ';
                                        html += '<div class="form-group col-lg-12 col-12 p-0">';
                                        html +=
                                            '<input type="text" name="nama[]" class="form-control" placeholder="Masukan Judul Lampiran" autocomplete="off">';
                                        html += '</div>';
                                        html += '<div class="form-group col-lg-12 col-12 p-0">';
                                        html += '<div class="input-group" id="inputFormRow">';
                                        html +=
                                            '<input  type="file" name="lampiran[]" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.xlsx" class="form-control " placeholder="Masukan Judul Lampiran" autocomplete="off">' +
                                            '<div class="input-group-append" >' +
                                            '<button id="removeRow" type="button" class="btn btn-danger"> <i class="fas fa-trash"></i> Hapus</button>' +
                                            '</div>';
                                        html += '</div>';
                                        html += '</div>';
                                        html += '</div>';

                                        $('#newRow').append(html);
                                    });


                                    // remove row
                                    $(document).on('click', '#removeRow', function() {

                                        $(this).closest('#inputFormRow1').remove();
                                    });
                                </script>
                            </div>

                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.card-body -->
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <div class="col-auto float-right">
                            <!-- Button trigger modal -->
                            <a href=" javascript:location.reload();" type="button"
                                class="intro-batal-sm btn btn-secondary">
                                <i class="fas fa-ban"></i> Batal
                            </a>
                            <button onclick="$('#cover-spin').show(0)" type="submit"
                                class="btn btn-success intro-saves-sm" name="submit">
                                <i class="fas fa-save"></i> Simpan
                            </button>

                        </div>
                    </div>
                </div>

            </form>
        </div>


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

@push('custom-scripts')
    {{-- ada disposisi atau tidak --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tombolDisposisi1 = document.getElementById('tombol-disposisi1');
            var tombolDisposisi2 = document.getElementById('tombol-disposisi2');
            var jenisPenerimaSection = document.getElementById('disposisi-line');

            function toggleJenisPenerimaSection() {
                if (tombolDisposisi1.checked) {
                    jenisPenerimaSection.style.display = 'block';
                } else {
                    jenisPenerimaSection.style.display = 'none';
                }
            }

            tombolDisposisi1.addEventListener('change', toggleJenisPenerimaSection);
            tombolDisposisi2.addEventListener('change', toggleJenisPenerimaSection);

            // Set initial visibility based on the initial state of the radio buttons
            toggleJenisPenerimaSection();
        });
    </script>
    <script>
        $(document).ready(function() {
            document.getElementById('disposisi-card').style.display = 'none';
            document.getElementById('sppd-card').style.display = 'none';
        });
        document.getElementById('tombol-disposisi1').addEventListener('change', function() {
            console.log(this.value);
            if (this.checked) {
                document.getElementById('tombol-disposisi2').checked = false;
                document.getElementById('disposisi-card').style.display = 'block';

            }
        });
        document.getElementById('tombol-disposisi2').addEventListener('change', function() {
            console.log(this.value);
            if (this.checked) {
                document.getElementById('tombol-disposisi1').checked = false;
                // document.getElementById('tombol-sppd2').checked = true;
                // document.getElementById('tombol-sppd1').checked = false;
                document.getElementById('sppd1actv1').classList.remove('active');
                document.getElementById('sppd1actv2').classList.add('active');
                document.getElementById('sppd-card').style.display = 'none';
                document.getElementById('disposisi-card').style.display = 'none';
                document.getElementById('sppd-card').style.display = 'none';
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            document.getElementById('sppd-card').style.display = 'none';
        });
        document.getElementById('tombol-sppd1').addEventListener('change', function() {
            console.log(this.value);
            if (this.checked) {
                document.getElementById('tombol-sppd2').checked = false;

                document.getElementById('sppd-card').style.display = 'block';
            }
        });
        document.getElementById('tombol-sppd2').addEventListener('change', function() {
            console.log(this.value);
            if (this.checked) {
                document.getElementById('tombol-sppd1').checked = false;

                document.getElementById('sppd-card').style.display = 'none';
            }
        });
    </script>

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


    {{-- golongan atau satuan --}}
    <script>
        $(document).ready(function() {
            document.getElementById('select2-golongan').style.display = 'none';
            document.getElementById('select2-internal').style.display = 'none';


        });
        document.getElementById('tombol-jenis-disposisi1').addEventListener('change', function() {
            console.log(this.value);
            if (this.checked) {
                document.getElementById('tombol-jenis-disposisi3').checked = false;
                document.getElementById('tombol-jenis-disposisi2').checked = false;
                document.getElementById('select2-satuan_upzis').style.display = 'block';
                document.getElementById('select2-satuan_pcnu').style.display = 'block';
                document.getElementById('select2-satuan_ranting').style.display = 'block';
                document.getElementById('select2-internal').style.display = 'none';
                document.getElementById('select2-golongan').style.display = 'none';
                document.getElementById('select2-catatan').style.display = 'block';
            }
        });
        document.getElementById('tombol-jenis-disposisi2').addEventListener('change', function() {
            console.log(this.value);
            if (this.checked) {
                document.getElementById('tombol-jenis-disposisi1').checked = false;
                document.getElementById('tombol-jenis-disposisi3').checked = false;
                document.getElementById('select2-satuan_upzis').style.display = 'none';
                document.getElementById('select2-satuan_pcnu').style.display = 'none';
                document.getElementById('select2-satuan_ranting').style.display = 'none';
                document.getElementById('select2-internal').style.display = 'none';
                document.getElementById('select2-golongan').style.display = 'block';
                document.getElementById('select2-catatan').style.display = 'block';
            }
        });
        document.getElementById('tombol-jenis-disposisi3').addEventListener('change', function() {
            console.log(this.value);
            if (this.checked) {
                document.getElementById('tombol-jenis-disposisi1').checked = false;
                document.getElementById('tombol-jenis-disposisi2').checked = false;
                document.getElementById('select2-satuan_pcnu').style.display = 'none';
                document.getElementById('select2-satuan_ranting').style.display = 'none';
                document.getElementById('select2-satuan_upzis').style.display = 'none';
                document.getElementById('select2-golongan').style.display = 'none';
                document.getElementById('select2-internal').style.display = 'block';
                document.getElementById('select2-catatan').style.display = 'block';
            }
        });
    </script>
@endpush

@push('tambah_surat_masuk')
    {{-- <script>
        function klikkene(value) {
            introJs().setOptions({
                    steps: [{
                            element: document.querySelector('.intro-table-rincian-arsip-sm'),
                            title: 'Form Rincian Surat Masuk',
                            intro: 'Form Isian Surat Masuk'
                        },
                        {
                            element: document.querySelector('.intro-tgl-arsip-sm'),
                            title: 'Tanggal Surat',
                            intro: 'Masukkan Tanggal Surat Dibuat Pada Kolom Ini'
                        },
                        {
                            element: document.querySelector('.intro-klasifikasi-sm'),
                            title: 'Klasifikasi Surat',
                            intro: 'Pilih Klasifikasi Surat Pada Kolom Ini'
                        },
                        {
                            element: document.querySelector('.intro-nomor-sm'),
                            title: 'Nomor Surat',
                            intro: 'Masukkan Nomor Surat Pada Kolom Ini'
                        },
                        {
                            element: document.querySelector('.intro-disposisi-sm'),
                            title: 'Disposisi Surat',
                            intro: 'Jika surat akan didisposisikan, pilih YA'
                        },
                        {
                            element: document.querySelector('.intro-tujuan-sm'),
                            title: 'Tujuan Surat',
                            intro: 'Tujuan Surat otomatis (PC LAZISNU CILACAP)'
                        },
                        {
                            element: document.querySelector('.intro-pengirim-sm'),
                            title: 'Pengirim Surat',
                            intro: 'Masukkan Pengirim Surat Pada Kolom Ini'
                        },

                        {
                            element: document.querySelector('.intro-perihal-sm'),
                            title: 'Perihal Surat',
                            intro: 'Masukkan Perihal Surat Pada Kolom ini'
                        },
                        {
                            element: document.querySelector('.intro-kumpulan-jenis-disposisi'),
                            title: 'Jenis Penerima',
                            intro: 'Pilih Jenis Penerima Disposisi '
                        },
                        {
                            element: document.querySelector('.intro-satuan-jenis-disposisi'),
                            title: 'Penerima Satuan',
                            intro: 'Ditunjukan Kepada Satuan PCNU, UPZIS , PRNU Tertentu '
                        },
                        {
                            element: document.querySelector('.intro-satuan-jenis-select-disposisi'),
                            title: 'satuan Penerima Disposisi',
                            intro: 'Pilih Penerima Satuan Disposisi'
                        },
                        {
                            element: document.querySelector('.intro-golongan-jenis-disposisi'),
                            title: 'Penerima Golongan',
                            intro: 'Ditunjukan Kepada Keseluruhan Pengurus Internal , UPZIS MWCNU atau PRNU'
                        },
                        {
                            element: document.querySelector('.intro-golongan-jenis-select-disposisi'),
                            title: 'Golongan Penerima Disposisi',
                            intro: 'Pilih Penerima Golongan Disposisi'
                        },
                        {
                            element: document.querySelector('.intro-internal-pc-jenis-disposisi'),
                            title: 'Penerima Internal',
                            intro: 'Menunjukan Pilihan Disposisi Surat Pengurus Internal'
                        },
                        {
                            element: document.querySelector('.intro-internal-pc-select-jenis-disposisi'),
                            title: 'Penerima Disposisi Internal',
                            intro: 'Pilih Penerima Pengurus Internal yang Akan Menerima Disposisi'
                        },
                        {
                            element: document.querySelector('.intro-sifat-disposisi-sm'),
                            title: 'Sifat Disposisi',
                            intro: 'Pilih Sifat Disposisi Pada Kolom Ini'
                        },
                        {
                            element: document.querySelector('.intro-perihal-disposisi-sm'),
                            title: 'Perihal Disposisi',
                            intro: 'Masukkan Perihal Disposisi Pada Kolom Ini'
                        },
                        {
                            element: document.querySelector('.intro-sppd-disposisi-sm'),
                            title: 'SPPD',
                            intro: 'Jika surat akan di SPPD, pilih YA'
                        },
                        {
                            element: document.querySelector('.intro-sppd-tgl_perintah-sm'),
                            title: 'Tanggal Perintah',
                            intro: 'Masukkan Tanggal Perintah SPPD Pada Kolom Ini'
                        },
                        {
                            element: document.querySelector('.intro-sppd-anggaran-sm'),
                            title: 'Anggaran ',
                            intro: 'Masukkan Anggaran SPPD Pada Kolom Ini'
                        },
                        {
                            element: document.querySelector('.intro-sppd-tgl-pelaksanaan-sm'),
                            title: 'Tanggal Pelaksanaan',
                            intro: 'Masukkan Tanggal Pelaksanaan SPPD Pada Kolom Ini'
                        },
                        {
                            element: document.querySelector('.intro-sppd-perihal-sm'),
                            title: 'Perihal ',
                            intro: 'Masukkan Perihal SPPD Pada Kolom Ini '
                        },
                        {
                            element: document.querySelector('.intro-tambah-lampiran-sm'),
                            title: 'Tambah Lampiran Lainnya',
                            intro: 'Menampilkan Lampiran Baru Jika Dibutuhkan untuk melakukan Tambah Data Lampiran'
                        },
                        {
                            element: document.querySelector('.intro-scan-sm'),
                            title: 'Scan Surat',
                            intro: 'Kolom Input Untuk isian file dan nama file yang akan disimpan '
                        },
                        {
                            element: document.querySelector('.intro-batal-sm'),
                            title: 'Simpan',
                            intro: 'Klik Disini Untuk Menyimpan Arsip Surat Masuk'
                        },
                        {
                            element: document.querySelector('.intro-saves-sm'),
                            title: 'Simpan',
                            intro: 'Klik Disini Untuk Menyimpan Arsip Surat Masuk'
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
                }).onbeforechange(function() {
                    if (this._currentStep === 8 || this._currentStep === 10) {
                        $("#tombol-disposisi1_label").attr('class', 'btn btn-outline-primary active focus')
                        $("#tombol-disposisi2_label").attr('class', 'btn btn-outline-primary')
                        $("#disposisi-card").attr('style', 'display:block');


                        $("#tombol-jenis-disposisi1").attr('class',
                            'btn btn-outline-primary intro-select-satuan-sm intro-satuan-jenis-disposisi active')
                        $("#tombol-jenis-disposisi2").attr('class',
                            'btn btn-outline-primary intro-select-golongan-sm intro-golongan-jenis-disposisi '
                        )
                        $("#tombol-jenis-disposisi3").attr('class',
                            'btn btn-outline-primary intro-select-internal-sm ');

                        $("#select2-golongan").attr('style',
                            'display: none;');
                        $("#select2-satuan_upzis").attr('style',
                            'display: block;');
                        $("#select2-satuan_ranting").attr('style',
                            'display: block;');
                        $("#select2-satuan_pcnu").attr('style',
                            'display: block;');

                        $("#select2-internal").attr('style',
                            'display: none;');


                        return true;
                    }

                    if (this._currentStep === 11 || this._currentStep === 12) {
                        $("#tombol-jenis-disposisi1").attr('class',
                            'btn btn-outline-primary intro-select-satuan-sm intro-satuan-jenis-disposisi ')
                        $("#tombol-jenis-disposisi2").attr('class',
                            'btn btn-outline-primary intro-select-golongan-sm intro-golongan-jenis-disposisi active focus'
                        )
                        $("#tombol-jenis-disposisi3").attr('class',
                            'btn btn-outline-primary intro-select-internal-sm ');

                        $("#select2-golongan").attr('style',
                            'display: block;');
                        $("#select2-satuan_upzis").attr('style',
                            'display: none;');
                        $("#select2-satuan_ranting").attr('style',
                            'display: none;');
                        $("#select2-satuan_pcnu").attr('style',
                            'display: none;');

                        $("#select2-internal").attr('style',
                            'display: none;');


                        return true;
                    }

                    if (this._currentStep === 13) {
                        $("#tombol-jenis-disposisi1").attr('class',
                            'btn btn-outline-primary intro-select-satuan-sm intro-satuan-jenis-disposisi ')
                        $("#tombol-jenis-disposisi2").attr('class',
                            'btn btn-outline-primary intro-select-golongan-sm intro-golongan-jenis-disposisi '
                        )
                        $("#tombol-jenis-disposisi3").attr('class',
                            'btn btn-outline-primary intro-select-internal-sm active focus ');

                        $("#select2-golongan").attr('style',
                            'display: none;');
                        $("#select2-satuan_upzis").attr('style',
                            'display: none;');
                        $("#select2-satuan_ranting").attr('style',
                            'display: none;');
                        $("#select2-satuan_pcnu").attr('style',
                            'display: none;');

                        $("#select2-internal").attr('style',
                            'display: block;');

                        return true;
                    }

                    if (this._currentStep === 18) {
                        $("#sppd1actv1").attr('class', 'btn btn-outline-primary active')
                        $("#sppd1actv2").attr('class', 'btn btn-outline-primary active')
                        $("#sppd-card").attr('style', 'display: block;');
                        return true;
                    }


                }).oncomplete(function() {
                    location.reload();
                }).start();
        }

        $(document).ready(function() {
            klikkene(true);
            $("#panduan").click(function() {
                klikkene(false);
            });
        });
    </script> --}}

    <script>
        function klikkene(value) {
            introJs().setOptions({
                    steps: [{
                        title: 'Panduan',
                        intro: 'Tekan Icon <i  class="sweet-tooltip far fa-question-circle" style="color:blue;"></i> untuk mengaktifkan Panduan'
                    }]
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

    <script>
        var yeso = document.getElementById("panduan-tambah-surat-masuk");
        yeso.onclick = function() {
            introJs().setOptions({
                steps: [{
                        element: document.querySelector('.intro-table-rincian-arsip-sm'),
                        title: 'Form Rincian Surat Masuk',
                        intro: 'Form Isian Surat Masuk'
                    },
                    {
                        element: document.querySelector('.intro-tgl-arsip-sm'),
                        title: 'Tanggal Surat',
                        intro: 'Masukkan Tanggal Surat Dibuat Pada Kolom Ini'
                    },
                    {
                        element: document.querySelector('.intro-klasifikasi-sm'),
                        title: 'Klasifikasi Surat',
                        intro: 'Pilih Klasifikasi Surat Pada Kolom Ini'
                    },
                    {
                        element: document.querySelector('.intro-nomor-sm'),
                        title: 'Nomor Surat',
                        intro: 'Masukkan Nomor Surat Pada Kolom Ini'
                    },
                    {
                        element: document.querySelector('.intro-disposisi-sm'),
                        title: 'Disposisi Surat',
                        intro: 'Jika surat akan didisposisikan, pilih YA'
                    },
                    {
                        element: document.querySelector('.intro-tujuan-sm'),
                        title: 'Tujuan Surat',
                        intro: 'Tujuan Surat otomatis (PC LAZISNU CILACAP)'
                    },
                    {
                        element: document.querySelector('.intro-pengirim-sm'),
                        title: 'Pengirim Surat',
                        intro: 'Masukkan Pengirim Surat Pada Kolom Ini'
                    },
                    {
                        element: document.querySelector('.intro-perihal-sm'),
                        title: 'Perihal Surat',
                        intro: 'Masukkan Perihal Surat Pada Kolom ini'
                    },
                    {
                        element: document.querySelector('.intro-diinput-sm'),
                        title: 'Diinput Oleh',
                        intro: 'Diinput oleh otomatis (PC LAZISNU CILACAP)'
                    },
                    {
                        element: document.querySelector('.intro-perihal-alamat-sm'),
                        title: 'Alamat Pengirim',
                        intro: 'Masukkan Alamat Pengirim Pada Kolom Ini'
                    },
                    {
                        element: document.querySelector('.intro-perihal-keterangan-sm'),
                        title: 'Keterangan',
                        intro: 'Masukkan Keterangan Pada Kolom Ini'
                    },
                ]
            }).start();
        }
    </script>

    <script>
        var yeso = document.getElementById("panduan-tambah-disposisi-surat-masuk");
        yeso.onclick = function() {
            introJs().setOptions({
                steps: [{
                        element: document.querySelector('.intro-table-disposisi-sm'),
                        title: 'Disposisi',
                        intro: 'Form Disposisi Surat Masuk '
                    },
                    {
                        element: document.querySelector('.intro-satuan-jenis-disposisi'),
                        title: 'Penerima Satuan',
                        intro: 'Ditunjukan Kepada Satuan PCNU, UPZIS , PRNU Tertentu '
                    },
                    {
                        element: document.querySelector('.intro-satuan-jenis-select-disposisi'),
                        title: 'satuan Penerima Disposisi',
                        intro: 'Pilih Penerima Satuan Disposisi'
                    },
                    {
                        element: document.querySelector('.intro-golongan-jenis-disposisi'),
                        title: 'Penerima Golongan',
                        intro: 'Ditunjukan Kepada Keseluruhan Pengurus Internal , UPZIS MWCNU atau PRNU'
                    },
                    {
                        element: document.querySelector('.intro-golongan-jenis-select-disposisi'),
                        title: 'Golongan Penerima Disposisi',
                        intro: 'Pilih Penerima Golongan Disposisi'
                    },
                    {
                        element: document.querySelector('.intro-internal-pc-jenis-disposisi'),
                        title: 'Penerima Internal',
                        intro: 'Menunjukan Pilihan Disposisi Surat Pengurus Internal'
                    },
                    {
                        element: document.querySelector('.intro-internal-pc-select-jenis-disposisi'),
                        title: 'Penerima Disposisi Internal',
                        intro: 'Pilih Penerima Pengurus Internal yang Akan Menerima Disposisi'
                    },
                    {
                        element: document.querySelector('.intro-sifat-disposisi-sm'),
                        title: 'Sifat Disposisi',
                        intro: 'Pilih Sifat Disposisi Pada Kolom Ini'
                    },
                    {
                        element: document.querySelector('.intro-perihal-disposisi-sm'),
                        title: 'Perihal Disposisi',
                        intro: 'Masukkan Perihal Disposisi Pada Kolom Ini'
                    },
                    {
                        element: document.querySelector('.intro-sppd-disposisi-sm'),
                        title: 'SPPD',
                        intro: 'Jika surat akan di SPPD, pilih YA'
                    }
                ]
            }).onbeforechange(function() {
                if (this._currentStep === 0 || this._currentStep === 2) {
                    $("#tombol-disposisi1_label").attr('class', 'btn btn-outline-primary active focus')
                    $("#tombol-disposisi2_label").attr('class', 'btn btn-outline-primary')
                    $("#disposisi-card").attr('style', 'display:block');


                    $("#tombol-jenis-disposisi1").attr('class',
                        'btn btn-outline-primary intro-select-satuan-sm intro-satuan-jenis-disposisi active'
                    )
                    $("#tombol-jenis-disposisi2").attr('class',
                        'btn btn-outline-primary intro-select-golongan-sm intro-golongan-jenis-disposisi '
                    )
                    $("#tombol-jenis-disposisi3").attr('class',
                        'btn btn-outline-primary intro-select-internal-sm ');

                    $("#select2-golongan").attr('style',
                        'display: none;');
                    $("#select2-satuan_upzis").attr('style',
                        'display: block;');
                    $("#select2-satuan_ranting").attr('style',
                        'display: block;');
                    $("#select2-catatan").attr('style',
                        'display: block;');
                    $("#select2-satuan_pcnu").attr('style',
                        'display: block;');

                    $("#select2-internal").attr('style',
                        'display: none;');


                    return true;
                }

                if (this._currentStep === 3 || this._currentStep === 4) {
                    $("#tombol-jenis-disposisi1").attr('class',
                        'btn btn-outline-primary intro-select-satuan-sm intro-satuan-jenis-disposisi ')
                    $("#tombol-jenis-disposisi2").attr('class',
                        'btn btn-outline-primary intro-select-golongan-sm intro-golongan-jenis-disposisi active focus'
                    )
                    $("#tombol-jenis-disposisi3").attr('class',
                        'btn btn-outline-primary intro-select-internal-sm ');

                    $("#select2-golongan").attr('style',
                        'display: block;');
                    $("#select2-satuan_upzis").attr('style',
                        'display: none;');
                    $("#select2-satuan_ranting").attr('style',
                        'display: none;');
                    $("#select2-catatan").attr('style',
                        'display: none;');
                    $("#select2-satuan_pcnu").attr('style',
                        'display: none;');

                    $("#select2-internal").attr('style',
                        'display: none;');


                    return true;
                }

                if (this._currentStep === 5) {
                    $("#tombol-jenis-disposisi1").attr('class',
                        'btn btn-outline-primary intro-select-satuan-sm intro-satuan-jenis-disposisi ')
                    $("#tombol-jenis-disposisi2").attr('class',
                        'btn btn-outline-primary intro-select-golongan-sm intro-golongan-jenis-disposisi '
                    )
                    $("#tombol-jenis-disposisi3").attr('class',
                        'btn btn-outline-primary intro-select-internal-sm active focus ');

                    $("#select2-golongan").attr('style',
                        'display: none;');
                    $("#select2-satuan_upzis").attr('style',
                        'display: none;');
                    $("#select2-satuan_ranting").attr('style',
                        'display: none;');
                    $("#select2-catatan").attr('style',
                        'display: none;');
                    $("#select2-satuan_pcnu").attr('style',
                        'display: none;');

                    $("#select2-internal").attr('style',
                        'display: block;');

                    return true;
                }

            }).start();
        }
    </script>

    <script>
        var yeso = document.getElementById("panduan-tambah-sppd-surat-masuk");
        yeso.onclick = function() {
            introJs().setOptions({
                steps: [{
                        element: document.querySelector('.intro-sppd-tgl_perintah-sm'),
                        title: 'Tanggal Perintah',
                        intro: 'Masukkan Tanggal Perintah SPPD Pada Kolom Ini'
                    },
                    {
                        element: document.querySelector('.intro-sppd-anggaran-sm'),
                        title: 'Anggaran ',
                        intro: 'Masukkan Anggaran SPPD Pada Kolom Ini'
                    },
                    {
                        element: document.querySelector('.intro-sppd-tgl-pelaksanaan-sm'),
                        title: 'Tanggal Pelaksanaan',
                        intro: 'Masukkan Tanggal Pelaksanaan SPPD Pada Kolom Ini'
                    },
                    {
                        element: document.querySelector('.intro-sppd-perihal-sm'),
                        title: 'Perihal ',
                        intro: 'Masukkan Perihal SPPD Pada Kolom Ini '
                    }
                ]
            }).start();
        }
    </script>

    <script>
        var yeso = document.getElementById("panduan-tambah-files-surat-masuk");
        yeso.onclick = function() {
            introJs().setOptions({
                steps: [{
                        element: document.querySelector('.intro-scan-masuk'),
                        title: 'Scan Surat',
                        intro: 'Kolom Input Untuk isian file dan nama file yang akan disimpan '
                    },
                    {
                        element: document.querySelector('.intro-tambah-lampiran-sm'),
                        title: 'Tambah Lampiran Lainnya',
                        intro: 'Menampilkan Lampiran Baru Jika Dibutuhkan untuk melakukan Tambah Data Lampiran'
                    },
                    {
                        element: document.querySelector('.intro-scan-sm'),
                        title: 'Scan Surat',
                        intro: 'Kolom Input Untuk isian file dan nama file yang akan disimpan '
                    },
                    {
                        element: document.querySelector('.intro-batal-sm'),
                        title: 'Batal',
                        intro: 'Klik Disini Untuk Membatalkan Penyimpanan Arsip Surat Masuk'
                    },
                    {
                        element: document.querySelector('.intro-saves-sm'),
                        title: 'Simpan',
                        intro: 'Klik Disini Untuk Menyimpan Arsip Surat Masuk'
                    }
                ]
            }).start();
        }
    </script>
@endpush
