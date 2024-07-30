@extends('main')

@section($act, 'active')
@section('arsip_ac', 'active menu-open')
@section('arsip_mo', 'menu-open')
@section('arsip_keluar_ac', 'active menu-open')
@section('arsip_keluar_mo', 'menu-open')

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
                                        href="/{{ $role }}/arsip/surat_masuk_pc/pc">Surat Keluar</a> /
                                    <a>{{ $page }}</a>
                                @elseif($hal == 'upzis')
                                    <a href="/{{ $role }}/dashboard">Dashboard</a> / <a
                                        href="/{{ $role }}/arsip/surat_masuk_pc/upzis">Surat Keluar</a> /
                                    <a>{{ $page }}</a>
                                @endif
                            @elseif(Auth::user()->gocap_id_upzis_pengurus != null)
                                @if ($hal == 'pc')
                                    <a href="/{{ $role }}/dashboard">Dashboard</a> / <a
                                        href="/{{ $role }}/arsip/surat_masuk_upzis/pc">Surat Keluar</a> /
                                    <a>{{ $page }}</a>
                                @elseif($hal == 'upzis')
                                    <a href="/{{ $role }}/dashboard">Dashboard</a> / <a
                                        href="/{{ $role }}/arsip/surat_masuk_upzis/upzis">Surat Keluar</a> /
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
            {{-- stat 0 == pengarsipan --}}
            @if ($stat == '0')
                <form method="post" action="/{{ $role }}/aksi_tambah_surat_keluar" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{ $role }}" name="role">
                    <div class="card card-success ">

                        <div class="card-body ">
                            <!-- Surat Keluar  -->
                            <div class="card card-success ijo-atas intro-table-rincian-arsip-out">
                                <div class="row mt-4 ml-4 justify-content-between">
                                    <div>
                                        <h3 class="card-title "><b>Rincian Surat Keluar</b>
                                        </h3>


                                        &nbsp; <a href="#" class="sweet-tooltip"
                                            data-style-tooltip="tooltip-mini-slick"
                                            id="panduan-rincian-surat-tour-guid-surat-keluar"><i
                                                class="far fa-question-circle"></i></a>

                                    </div>

                                    <!-- Button trigger modal -->
                                    {{-- <input type="hidden" name="pelaksana_kegiatan"> --}}
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6 col-6">

                                            <div class="form-group row intro-tgl-arsip-out">
                                                <label class="col-sm-4 col-form-label">Tanggal
                                                    Surat</label>
                                                <div class="col-sm-8">
                                                    <input type="date"
                                                        class="form-control  @error('tanggal_arsip') is-invalid @enderror"
                                                        name="tanggal_arsip" placeholder="Tanggal Arsip"
                                                        value="{{ old('tanggal_arsip') }}">
                                                    @error('tanggal_arsip')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                            </div>

                                            <div class="form-group row intro-klasifikasi-out">
                                                <label class="col-sm-4 col-form-label">Klasifikasi
                                                    Surat</label>
                                                <div class="col-sm-8">
                                                    <select
                                                        class="form-control @error('klasifikasi_surat') is-invalid @enderror"
                                                        name="klasifikasi_surat"
                                                        data-placeholder="Masukan Klasifikasi Surat"
                                                        value="{{ old('klasifikasi_surat') }}"
                                                        style="appearance:none;
                                                    -webkit-appearance:none;
                                                    -moz-appearance:none;
                                                   ">

                                                        @if (old('klasifikasi_surat') == 'Biasa')
                                                            <option value="Biasa" selected>Biasa ( A.I )</option>
                                                            <option value="Khusus">Khusus ( A.II )</option>
                                                        @elseif (old('klasifikasi_surat') == 'Khusus')
                                                            <option value="Biasa">Biasa ( A.I )</option>
                                                            <option value="Khusus" selected>Khusus ( A.II )</option>
                                                        @else
                                                            <option value="" disabled selected hidden> Masukan
                                                                Klasifikasi Surat
                                                            </option>
                                                            <option value="Biasa">Biasa ( A.I )</option>
                                                            <option value="Khusus">Khusus ( A.II )</option>
                                                        @endif

                                                    </select>

                                                    @error('klasifikasi_surat')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row intro-nomor-out">
                                                <label class="col-sm-4 col-form-label">Nomor Surat</label>
                                                <div class="col-sm-8">
                                                    <input type="text" autocomplete="off"
                                                        class="form-control @error('nomor_surat') is-invalid @enderror"
                                                        name="nomor_surat" placeholder="Masukan Nomor Surat"
                                                        value="{{ old('nomor_surat') }}">
                                                    @error('nomor_surat')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <style>
                                                #radioBtn .notActive {
                                                    color: #3276b1;
                                                    background-color: #fff;
                                                }
                                            </style>

                                            <div class="form-group row intro-disposisi-out">
                                                <label class="col-sm-4 col-form-label">Disposisi / Tembusan</label>

                                                <div class="col-sm-8">
                                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                        <label class="btn btn-outline-primary active">
                                                            <input type="radio" name="disposisi_ya" id="tombol-disposisi1"
                                                                autocomplete="off"> Ya
                                                        </label>
                                                        <label class="btn btn-outline-primary ">
                                                            <input type="radio" name="disposisi_tidak"
                                                                id="tombol-disposisi2" autocomplete="off" checked>
                                                            Tidak
                                                        </label>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-6">


                                            <div class="form-group row intro-pengirim-out">
                                                <label class="col-sm-4 col-form-label">Pengirim
                                                    Surat</label>
                                                <div class="col-sm-8">
                                                    @if (Auth::user()->gocap_id_pc_pengurus != null)
                                                        <input type="text"
                                                            class="form-control @error('pengirim_sumber') is-invalid @enderror"
                                                            name="pengirim_sumber" value="PC Lazisnu Cilacap" readonly>
                                                    @elseif (Auth::user()->gocap_id_upzis_pengurus != null)
                                                        <input type="text"
                                                            class="form-control @error('pengirim_sumber') is-invalid @enderror"
                                                            name="pengirim_sumber" value="Upzis {{ $wilayah }}"
                                                            readonly>
                                                    @endif
                                                    @error('pengirim_sumber')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror

                                                </div>
                                            </div>



                                            <div class="form-group row intro-perihal-out">
                                                <label class="col-sm-4 col-form-label">Perihal Surat</label>
                                                <div class="col-sm-8">
                                                    <input
                                                        class="form-control  @error('perihal_isi_deskripsi') is-invalid @enderror"
                                                        name="perihal_isi_deskripsi" placeholder="Masukan Perihal Surat"
                                                        value="{{ old('perihal_isi_deskripsi') }}">
                                                    @error('perihal_isi_deskripsi')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row intro-penerima-out">
                                                <label class="col-sm-4 col-form-label">Penerima
                                                    Surat</label>
                                                <div class="col-sm-8">
                                                    @if (Auth::user()->gocap_id_pc_pengurus != null)
                                                        <input type="text"
                                                            class="form-control @error('tujuan_arsip') is-invalid @enderror"
                                                            name="tujuan_arsip" value="Ketua Upzis" readonly>
                                                    @else
                                                        <input type="text"
                                                            class="form-control @error('tujuan_arsip') is-invalid @enderror"
                                                            name="tujuan_arsip" value="Koordinator Ranting" readonly>
                                                    @endif

                                                    @error('tujuan_arsip')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>


                                        </div>
                                    </div>

                                    <div class="form-group intro-penerima-disposisi-out">
                                        @if (Auth::user()->gocap_id_pc_pengurus != null)
                                            <label>Ketua Upzis Penerima Surat</label>
                                            <select
                                                class="form-control select2 @error('akses_ketua_upzis') is-invalid @enderror"
                                                multiple="multiple" data-placeholder="Pilih Penerima Disposisi"
                                                style="width: 100%;" name="akses_ketua_upzis[]">

                                                @foreach ($ketua_upzis as $ketua_upzis2)
                                                    @php
                                                        $wily = DB::connection('siftnu')
                                                            ->table('wilayah')
                                                            ->where('id_wilayah', $ketua_upzis2->id_wilayah)
                                                            ->first();
                                                        
                                                        $nem = DB::connection('siftnu')
                                                            ->table('pengguna')
                                                            ->where('gocap_id_upzis_pengurus', $ketua_upzis2->id_upzis_pengurus)
                                                            ->first();
                                                    @endphp
                                                    @if ($wily && $nem)
                                                        <option value="{{ $ketua_upzis2->id_upzis_pengurus }}"
                                                            {{ in_array($ketua_upzis2->id_upzis_pengurus, old('akses_ketua_upzis') ?: []) ? 'selected' : '' }}>
                                                            {{ 'Ketua Upzis ' . $wily->nama . ' (' . $nem->nama . ')' }}
                                                        </option>
                                                    @endif

                                                    {{-- <option value="{{ $ketua_upzis2->id_upzis_pengurus }}"
                                                    {{ in_array($ketua_upzis2->id_upzis, old('akses_ketua_upzis') ?: []) ? 'selected' : '' }}>
                                                    {{ 'Ketua Upzis ' . $wily->nama }}
                                                </option> --}}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('akses_ketua_upzis')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        @else
                                            <label>Koordinator Ranting Penerima Surat</label>
                                            <select
                                                class="form-control select2 @error('akses_ketua_upzis') is-invalid @enderror"
                                                multiple="multiple" data-placeholder="Pilih Penerima Disposisi"
                                                style="width: 100%;" name="akses_ketua_upzis[]">

                                                @foreach ($koordinator_ranting as $koordinator)
                                                    @php
                                                        $wily = DB::connection('siftnu')
                                                            ->table('wilayah')
                                                            ->where('id_wilayah', $koordinator->id_wilayah)
                                                            ->first();
                                                        
                                                        $nem = DB::connection('siftnu')
                                                            ->table('pengguna')
                                                            ->where('gocap_id_ranting_pengurus', $koordinator->id_ranting_pengurus)
                                                            ->first();
                                                    @endphp
                                                    @if ($wily && $nem)
                                                        <option value="{{ $koordinator->id_ranting_pengurus }}"
                                                            {{ in_array($koordinator->id_ranting_pengurus, old('akses_ketua_upzis') ?: []) ? 'selected' : '' }}>
                                                            {{ 'Koordinator Ranting ' . $wily->nama . ' (' . $nem->nama . ')' }}
                                                        </option>
                                                    @endif

                                                    {{-- <option value="{{ $koordinator->id_ranting_pengurus }}"
                                                {{ in_array($koordinator->id_upzis, old('akses_ketua_upzis') ?: []) ? 'selected' : '' }}>
                                                {{ 'Ketua Upzis ' . $wily->nama }}
                                            </option> --}}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('akses_ketua_upzis')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        @endif
                                    </div>



                                </div>
                                <!-- /.card-body -->
                            </div>

                            {{-- Disposisi --}}
                            <div class="card card-success ijo-atas intro-table-disposisi-sk" id="disposisi-card">
                                <div class="row mt-4 ml-4 justify-content-between">
                                    <div>
                                        <br>
                                        <h3 class="card-title"><b>Disposisi / Tembusan</b>
                                        </h3>
                                        &nbsp; <a href="#" class="sweet-tooltip"
                                            data-style-tooltip="tooltip-mini-slick"
                                            id="panduan-disposisi-tour-guid-surat-keluar"><i
                                                class="far fa-question-circle"></i></a>
                                    </div>
                                    <!-- Button trigger modal -->

                                    {{-- <div class="col-auto mr-3">
                                        <br>
                                        <button type="submit" onclick="previewdisposisi(this.form)"
                                            class="btn btn-primary" name="submit">
                                            <i class="fas fa-eye"></i> Preview Disposisi
                                        </button>

                                        <script>
                                            function previewdisposisi(form) {
                                                form.target = '_blank';
                                                form.action = '/{{ $role }}/arsip/preview_disposisi';
                                                form.submit();
                                            }
                                        </script>
                                    </div> --}}

                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6 col-6">

                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label">Jenis Penerima</label>
                                                <div class="col-sm-8">
                                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                        <label
                                                            class="btn btn-outline-primary  active intro-satuan-jenis-disposisi">
                                                            <input type="radio" name="penerima_satuan"
                                                                id="tombol-jenis-disposisi1" autocomplete="off" checked>
                                                            Satuan
                                                        </label>
                                                        <label
                                                            class="btn btn-outline-primary intro-golongan-jenis-disposisi">
                                                            <input type="radio" name="penerima_golongan"
                                                                id="tombol-jenis-disposisi2" autocomplete="off">
                                                            Golongan
                                                        </label>

                                                        <label
                                                            class="btn btn-outline-primary intro-internal-pc-jenis-disposisi ">
                                                            <input type="radio" name="penerima_internal"
                                                                id="tombol-jenis-disposisi3" autocomplete="off">
                                                            Internal
                                                        </label>



                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group intro-golongan-jenis-select-disposisi" id="select2-golongan">
                                        <label>Golongan Penerima Disposisi</label>

                                        <select class="form-control @error('akses_golongan') is-invalid @enderror select2"
                                            multiple="multiple" data-placeholder="Pilih Golongan Penerima Disposisi"
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
                                            <label>MWCNU Penerima Disposisi</label>
                                            <select class="select2 @error('akses_satuan_upzis') is-invalid @enderror"
                                                multiple="multiple" data-placeholder="Pilih MWCNU Penerima Disposisi"
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
                                                    multiple="multiple" data-placeholder="Pilih PCNU Penerima Disposisi"
                                                    style="width: 100%;" name="akses_satuan_pc[]">

                                                    @foreach ($pc as $pc2)
                                                        <option value="{{ $pc2->id_pc }}"
                                                            {{ in_array($pc2->id_pc, old('akses_satuan_pc') ?: []) ? 'selected' : '' }}>
                                                            {{ $pc2->nama }}</option>
                                                        </option>
                                                    @endforeach


                                                </select>
                                                @error('akses_satuan_upzis')
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
                                                multiple="multiple" data-placeholder="Pilih Ranting Penerima Disposisi"
                                                style="width: 100%;" name="akses_satuan_ranting[]">

                                                @foreach ($ranting as $ranting2)
                                                    @php
                                                        $kec = DB::connection('gocap')
                                                            ->table('upzis')
                                                            ->where('id_upzis', $ranting2->id_upzis)
                                                            ->first();
                                                        $nama_kec = DB::connection('siftnu')
                                                            ->table('wilayah')
                                                            ->where('id_wilayah', $kec->id_wilayah)
                                                            ->first();
                                                    @endphp
                                                    <option value="{{ $ranting2->id_ranting }}"
                                                        {{ in_array($ranting2->id_ranting, old('akses_satuan_ranting') ?: []) ? 'selected' : '' }}>
                                                        {{ $ranting2->nama }} {{ '(Kec.' . $nama_kec->nama . ')' }}
                                                    </option>
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
                                                    multiple="multiple" data-placeholder="Pilih Pengurus Internal"
                                                    style="width: 100%;" name="akses_internal[]">


                                                    @foreach ($pengurus as $pengurus2)
                                                        @php
                                                            $jabatans = DB::connection('gocap')
                                                                ->table('pengurus_jabatan')
                                                                ->where('id_pengurus_jabatan', $pengurus2->id_pengurus_jabatan)
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
                                                <label>Pengurus Internal Penerima Disposisi</label>
                                                <input type="hidden" name="id_upzis"
                                                    value="{{ Auth::user()->UpzisPengurus->Upzis->id_upzis }}">

                                                <select class="select2 @error('akses_internal') is-invalid @enderror"
                                                    multiple="multiple" data-placeholder="Pilih Pengurus Internal"
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

                                    <div class="row">
                                        <div class="col-lg-6 col-6 intro-sifat-disposisi-sk">
                                            <div class="form-group row intro-sifat-disposisi-out">
                                                <label class="col-sm-4 col-form-label">Sifat</label>

                                                <div class="col-sm-8">

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

                                            <div class="form-group row intro-sppd-disposisi-sk">
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


                                            <div class="form-group row intro-perihal-disposisi-sk">
                                                <label class="col-sm-4 col-form-label">Perihal Disposisi</label>
                                                <div class="col-sm-8">
                                                    <input
                                                        class="form-control  @error('perihal_disposisi') is-invalid @enderror"
                                                        name="perihal_disposisi" placeholder="Masukan Perihal Disposisi"
                                                        value="{{ old('perihal_disposisi') }}">
                                                    @error('perihal_disposisi')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <br>


                                </div>
                                <!-- /.card-body -->
                            </div>

                            {{-- SPPD --}}
                            <div class="card card-success intro-table-sppd-out" id="sppd-card">
                                <div class="row mt-4 ml-4 justify-content-between">
                                    <div>
                                        <h3 class="card-title "><b>Rincian SPPD</b>
                                        </h3>
                                        &nbsp; <a href="#" class="sweet-tooltip"
                                            data-style-tooltip="tooltip-mini-slick"
                                            id="panduan-sppd-tour-guid-surat-keluar"><i
                                                class="far fa-question-circle"></i></a>
                                    </div>
                                    <!-- Button trigger modal -->

                                    {{-- <input type="hidden" name="pelaksana_kegiatan"> --}}
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6 col-6">


                                            <div class="form-group row intro-tgl-perintah-sppd-out">
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
                                            <div class="form-group row intro-tgl-pelaksana-sppd-out">
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

                                            <div class="form-group row intro-anggaran-sppd-out">
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


                                            <div class="form-group row intro-perihal-sppd-out">
                                                <label class="col-sm-4 col-form-label">Perihal SPPD</label>
                                                <div class="col-sm-8">
                                                    <input
                                                        class="form-control @error('perihal_sppd') is-invalid @enderror"
                                                        name="perihal_sppd" value="{{ old('perihal_sppd') }}"
                                                        placeholder="Masukan Perihal SPPD">
                                                    @error('perihal_sppd')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>


                                        </div>

                                    </div>
                                    <br>

                                </div>
                                <!-- /.card-body -->
                            </div>

                            {{-- Lampiran --}}
                            <div class="card card-success ijo-atas intro-scan-out">
                                <div class="row mt-4 ml-4 justify-content-between">
                                    <div>
                                        <h3 class="card-title "><b>Upload Lampiran</b>
                                        </h3>
                                        &nbsp; <a href="#" class="sweet-tooltip"
                                            data-style-tooltip="tooltip-mini-slick"
                                            id="panduan-lampiran-tour-guid-surat-keluar"><i
                                                class="far fa-question-circle"></i></a>

                                    </div>

                                    <div class="col-auto mr-3">

                                        <button id="addRow" type="button"
                                            class="intro-tambah-lampiran-out btn btn-primary"> <i
                                                class="fas fa-plus-circle" aria-hidden="true"></i> Tambah
                                            Lampiran</button>
                                    </div>

                                </div>

                                <div class="card-body mr-3 ml-3 intro-scan-sk">

                                    <div class="form-group row ">

                                        <label> Silahkan pilih lampiran surat keluar anda. Ukuran maksimal file 2
                                            MB. Jenis file yang diijinkan adalah: <b>jpg, doc, docx, pdf, jpeg,
                                                png</b></label><br>

                                    </div>

                                    <div class="form-group row ">
                                        <label class="text-danger">*Jika lampiran tidak ada maka tidak perlu
                                            dilampirkan</label>
                                    </div>

                                    <div class="form-group row ">

                                        <label class="col-sm-4 col-form-label">
                                            Scan Surat </label>
                                        <input style="width: 100%;" class="form-control m-input " type="text"
                                            id="formFileSm" name="nama_surat" placeholder="Masukan Judul Surat"
                                            autocomplete="off">
                                    </div>



                                    <div class="form-group row ">

                                        <input style="width: 100%;" class="form-control" class="form-control m-input"
                                            type="file" name="scan_surat" id="formFileSm"
                                            accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" autocomplete="off">
                                    </div>


                                    <div id="newRow"></div>


                                    <script type="text/javascript">
                                        // add row

                                        $("#addRow").click(function() {

                                            var html = '';

                                            html += '<div id="inputFormRow1">';
                                            html += '<label class="col-form-label">Lampiran</label > ';
                                            html += '<div class="form-group row">';
                                            html +=
                                                '<input type="text" name="nama[]" class="form-control " placeholder="Masukan Judul Lampiran" autocomplete="off" >';
                                            html += '</div>';
                                            html += '<div class="form-group row " >';
                                            html += '<div class="input-group" id="inputFormRow">';
                                            html +=
                                                '<input  type="file" name="lampiran[]" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="form-control " placeholder="Masukan Judul Lampiran" autocomplete="off" >' +
                                                '<div class="input-group-append" >' +
                                                '<button id="removeRow" type="button" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>' +
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
                        <div class="card-footer ">
                            <div class="col-auto float-right">
                                <!-- Button trigger modal -->
                                <a href=" javascript:history.back()" type="button"
                                    class="intro-batal-sk btn btn-secondary">
                                    <i class="fas fa-ban"></i> Batal
                                </a>
                                <button onclick="$('#cover-spin').show(0)" type="submit"
                                    class="btn btn-success intro-saves-out" name="submit">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                                {{-- <script>
                                    function simpan(form) {
                                        form.target = '';
                                        form.action = '/{{ $role }}/aksi_tambah_surat_keluar';
                                        form.submit();
                                    }
                                </script> --}}
                            </div>
                        </div>
                    </div>

                </form>
            @else
                {{-- stat 1 == baru --}}
                <form method="post" action="/{{ $role }}/aksi_tambah_surat_keluar_baru"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{ $role }}" name="role">
                    <div class="card card-success">

                        <div class="card-body">
                            <!-- Surat Keluar -->
                            <div class="card card-success ijo-atas intro-table-rincian-arsip-out">
                                <div class="row mt-4 ml-4 justify-content-between">
                                    <div>
                                        <h3 class="card-title "><b>Rincian Surat Keluar</b>
                                        </h3>


                                        &nbsp; <a href="#" class="sweet-tooltip"
                                            data-style-tooltip="tooltip-mini-slick"
                                            id="panduan-rincian-surat-tour-guid-surat-keluar"><i
                                                class="far fa-question-circle"></i></a>

                                    </div>

                                    <!-- Button trigger modal -->
                                    {{-- <input type="hidden" name="pelaksana_kegiatan"> --}}
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6 col-6">

                                            <div class="form-group row intro-tgl-arsip-out">
                                                <label class="col-sm-4 col-form-label">Tanggal
                                                    Surat</label>
                                                <div class="col-sm-8">
                                                    <input type="text"
                                                        class="form-control  @error('tanggal_arsip') is-invalid @enderror"
                                                        placeholder="Tanggal Arsip" disabled
                                                        value="{{ Carbon\Carbon::parse(now())->isoFormat('dddd, D MMMM Y') }}">
                                                    @error('tanggal_arsip')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                            </div>

                                            <input type="hidden" name="tanggal_arsip" value="{{ date('Y-m-d') }}">

                                            <livewire:nomor-surat />

                                            <style>
                                                #radioBtn .notActive {
                                                    color: #3276b1;
                                                    background-color: #fff;
                                                }
                                            </style>


                                        </div>

                                        <div class="col-lg-6 col-6">

                                            <div class="form-group row intro-pengirim-out">
                                                <label class="col-sm-4 col-form-label">Pengirim
                                                    Surat</label>
                                                <div class="col-sm-8">
                                                    @if (Auth::user()->gocap_id_pc_pengurus != null)
                                                        <input type="text"
                                                            class="form-control @error('pengirim_sumber') is-invalid @enderror"
                                                            name="pengirim_sumber" value="PC Lazisnu Cilacap" readonly>
                                                    @elseif (Auth::user()->gocap_id_upzis_pengurus != null)
                                                        <input type="text"
                                                            class="form-control @error('pengirim_sumber') is-invalid @enderror"
                                                            name="pengirim_sumber" value="Upzis {{ $wilayah }}"
                                                            readonly>
                                                    @endif
                                                    @error('pengirim_sumber')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror

                                                </div>
                                            </div>

                                            <div class="form-group row intro-perihal-out">
                                                <label class="col-sm-4 col-form-label">Perihal Surat</label>
                                                <div class="col-sm-8">
                                                    <input
                                                        class="form-control  @error('perihal_isi_deskripsi') is-invalid @enderror"
                                                        name="perihal_isi_deskripsi" placeholder="Masukan Perihal Surat"
                                                        value="{{ old('perihal_isi_deskripsi') }}">
                                                    @error('perihal_isi_deskripsi')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row intro-penerima-out">
                                                <label class="col-sm-4 col-form-label">Penerima Surat</label>
                                                <div class="col-sm-8">
                                                    @if (Auth::user()->gocap_id_pc_pengurus != null)
                                                        <input type="text"
                                                            class="form-control @error('tujuan_arsip') is-invalid @enderror"
                                                            name="tujuan_arsip" value="Ketua Upzis" readonly>
                                                    @else
                                                        <input type="text"
                                                            class="form-control @error('tujuan_arsip') is-invalid @enderror"
                                                            name="tujuan_arsip" value="Koordinator Ranting" readonly>
                                                    @endif


                                                    @error('tujuan_arsip')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- <div class="form-group row">
                                                <label class="col-sm-4 col-form-label">Yang Berandatangan</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control select2" multiple="multiple"
                                                        data-placeholder="Pilih Pengurus Yang Bertandatangan"
                                                        style="width: 100%;" name="yang_bertandatangan[]" id="ini">
                                                        @foreach ($yang_bertandatangan as $ttd)
                                                            @php
                                                                $jabatan = DB::connection('gocap')
                                                                    ->table('pengurus_jabatan')
                                                                    ->where('id_pengurus_jabatan', $ttd->id_pengurus_jabatan)
                                                                    ->first();
                                                            @endphp
                                                            <option value="{{ $ttd->id_pc_pengurus }}"
                                                                {{ in_array($ttd->id_pc_pengurus, old('yang_bertandatangan') ?: []) ? 'selected' : '' }}>
                                                                {{ $ttd->nama }}
                                                                ({{ $jabatan->jabatan }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div> --}}

                                            <div class="form-group row intro-disposisi-out">
                                                <label class="col-sm-4 col-form-label">Disposisi / Tembusan</label>

                                                <div class="col-sm-8">
                                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                        <label class="btn btn-outline-primary active">
                                                            <input type="radio" name="disposisi_ya"
                                                                id="tombol-disposisi1" autocomplete="off"> Ya
                                                        </label>
                                                        <label class="btn btn-outline-primary ">
                                                            <input type="radio" name="disposisi_tidak"
                                                                id="tombol-disposisi2" autocomplete="off" checked>
                                                            Tidak
                                                        </label>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="form-group intro-penerima-disposisi-out ">
                                        @if (Auth::user()->gocap_id_pc_pengurus != null)
                                            <label>Ketua Upzis Penerima Surat</label>
                                            <select class="select2 @error('akses_ketua_upzis') is-invalid @enderror"
                                                multiple="multiple" data-placeholder="Pilih Penerima Surat"
                                                style="width: 100%;" name="akses_ketua_upzis[]">

                                                @foreach ($ketua_upzis as $ketua_upzis2)
                                                    @php
                                                        $wily = DB::connection('siftnu')
                                                            ->table('wilayah')
                                                            ->where('id_wilayah', $ketua_upzis2->id_wilayah)
                                                            ->first();
                                                        
                                                        $nem = DB::connection('siftnu')
                                                            ->table('pengguna')
                                                            ->where('gocap_id_upzis_pengurus', $ketua_upzis2->id_upzis_pengurus)
                                                            ->first();
                                                    @endphp
                                                    @if ($wily && $nem)
                                                        <option value="{{ $ketua_upzis2->id_upzis_pengurus }}"
                                                            {{ in_array($ketua_upzis2->id_upzis_pengurus, old('akses_ketua_upzis') ?: []) ? 'selected' : '' }}>
                                                            {{ 'Ketua Upzis ' . $wily->nama . ' (' . $nem->nama . ')' }}
                                                        </option>
                                                    @endif

                                                    {{-- <option value="{{ $ketua_upzis2->id_upzis_pengurus }}"
                                                    {{ in_array($ketua_upzis2->id_upzis, old('akses_ketua_upzis') ?: []) ? 'selected' : '' }}>
                                                    {{ 'Ketua Upzis ' . $wily->nama }}
                                                </option> --}}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('akses_ketua_upzis')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        @else
                                            <label>Koordinator Ranting Penerima Surat</label>
                                            <select class="select2 @error('akses_ketua_upzis') is-invalid @enderror"
                                                multiple="multiple" data-placeholder="Pilih Penerima Surat"
                                                style="width: 100%;" name="akses_ketua_upzis[]">

                                                @foreach ($koordinator_ranting as $koordinator)
                                                    @php
                                                        $wily = DB::connection('siftnu')
                                                            ->table('wilayah')
                                                            ->where('id_wilayah', $koordinator->id_wilayah)
                                                            ->first();
                                                        
                                                        $nem = DB::connection('siftnu')
                                                            ->table('pengguna')
                                                            ->where('gocap_id_ranting_pengurus', $koordinator->id_ranting_pengurus)
                                                            ->first();
                                                    @endphp
                                                    @if ($wily && $nem)
                                                        <option value="{{ $koordinator->id_ranting_pengurus }}"
                                                            {{ in_array($koordinator->id_ranting_pengurus, old('akses_ketua_upzis') ?: []) ? 'selected' : '' }}>
                                                            {{ 'Koordinator Ranting ' . $wily->nama . ' (' . $nem->nama . ')' }}
                                                        </option>
                                                    @endif

                                                    {{-- <option value="{{ $koordinator->id_ranting_pengurus }}"
                                                    {{ in_array($koordinator->id_upzis, old('akses_ketua_upzis') ?: []) ? 'selected' : '' }}>
                                                    {{ 'Ketua Upzis ' . $wily->nama }}
                                                </option> --}}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('akses_ketua_upzis')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        @endif
                                    </div>

                                    {{-- disini --}}
                                    <div class="mb-3 intro-isi-surat-out">
                                        <label for="desc" class="form-label">Isi Surat</label>
                                        <textarea name="isi_surat" class="my-editor form-control" id="my-editor">
                                        @if (old('isi_surat'))
{{ old('isi_surat') }}
@else
Assalamualaikum Warahmatullahi Wabarakatuh<br>Salam silaturrahmi kami sampaikan, semoga kita senantiasa dalam lindungan Allah SWT. Amin, Ya
                                        Rabbal Alamiin. <br><br><br>Demikian surat ini kami sampaikan, atas perhatian dan kehadirannya disampaikan terima kasih.<br><br>Wallahul Muwafiq Ila Aqwamith Thariiq
                                        <br>Wassalamualaikum Warahmatullahi Wabarakatuh
@endif
                                        </textarea>
                                    </div>



                                </div>
                                <!-- /.card-body -->
                            </div>

                            {{-- Disposisi --}}
                            <div class="card card-success ijo-atas intro-table-disposisi-sk" id="disposisi-card">
                                <div class="row mt-4 ml-4 justify-content-between">
                                    <div>
                                        <br>
                                        <h3 class="card-title"><b>Disposisi / Tembusan</b>
                                        </h3>
                                        &nbsp; <a href="#" class="sweet-tooltip"
                                            data-style-tooltip="tooltip-mini-slick"
                                            id="panduan-disposisi-tour-guid-surat-keluar"><i
                                                class="far fa-question-circle"></i></a>
                                    </div>
                                    <!-- Button trigger modal -->
                                    {{-- 
                                    <div class="col-auto mr-3">
                                        <br>
                                        <button type="submit" onclick="previewdisposisi(this.form)"
                                            class="btn btn-primary" name="submit">
                                            <i class="fas fa-eye"></i> Preview Disposisi
                                        </button>

                                        <script>
                                            function previewdisposisi(form) {
                                                form.target = '_blank';
                                                form.action = '/{{ $role }}/arsip/preview_disposisi';
                                                form.submit();
                                            }
                                        </script>
                                    </div> --}}

                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6 col-6">

                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label">Jenis Penerima</label>
                                                <div class="col-sm-8">
                                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                        <label
                                                            class="btn btn-outline-primary  active intro-satuan-jenis-disposisi">
                                                            <input type="radio" name="penerima_satuan"
                                                                id="tombol-jenis-disposisi1" autocomplete="off" checked>
                                                            Satuan
                                                        </label>
                                                        <label
                                                            class="btn btn-outline-primary intro-golongan-jenis-disposisi">
                                                            <input type="radio" name="penerima_golongan"
                                                                id="tombol-jenis-disposisi2" autocomplete="off">
                                                            Golongan
                                                        </label>

                                                        <label
                                                            class="btn btn-outline-primary intro-internal-pc-jenis-disposisi ">
                                                            <input type="radio" name="penerima_internal"
                                                                id="tombol-jenis-disposisi3" autocomplete="off">
                                                            Internal
                                                        </label>



                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group intro-golongan-jenis-select-disposisi" id="select2-golongan">
                                        <label>Golongan Penerima Disposisi</label>

                                        <select class="form-control @error('akses_golongan') is-invalid @enderror select2"
                                            multiple="multiple" data-placeholder="Pilih Golongan Penerima Disposisi"
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
                                            <label>MWCNU Penerima Disposisi</label>
                                            <select class="select2 @error('akses_satuan_upzis') is-invalid @enderror"
                                                multiple="multiple" data-placeholder="Pilih MWCNU Penerima Disposisi"
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
                                                    multiple="multiple" data-placeholder="Pilih PCNU Penerima Disposisi"
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
                                            <select class="select2  @error('akses_satuan_ranting') is-invalid @enderror"
                                                multiple="multiple" data-placeholder="Pilih Ranting Penerima Disposisi"
                                                style="width: 100%;" name="akses_satuan_ranting[]">
                                                @foreach ($ranting as $ranting2)
                                                    @php
                                                        $kec = DB::connection('gocap')
                                                            ->table('upzis')
                                                            ->where('id_upzis', $ranting2->id_upzis)
                                                            ->first();
                                                        $nama_kec = DB::connection('siftnu')
                                                            ->table('wilayah')
                                                            ->where('id_wilayah', $kec->id_wilayah)
                                                            ->first();
                                                    @endphp
                                                    <option value="{{ $ranting2->id_ranting }}"
                                                        {{ in_array($ranting2->id_ranting, old('akses_satuan_ranting') ?: []) ? 'selected' : '' }}>
                                                        {{ $ranting2->nama }} {{ '(Kec.' . $nama_kec->nama . ')' }}
                                                    </option>
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
                                                    multiple="multiple" data-placeholder="Pilih Pengurus Internal"
                                                    style="width: 100%;" name="akses_internal[]">


                                                    @foreach ($pengurus as $pengurus2)
                                                        @php
                                                            $jabatans = DB::connection('gocap')
                                                                ->table('pengurus_jabatan')
                                                                ->where('id_pengurus_jabatan', $pengurus2->id_pengurus_jabatan)
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
                                                <label>Pengurus Internal Penerima Disposisi</label>
                                                <input type="hidden" name="id_upzis"
                                                    value="{{ Auth::user()->UpzisPengurus->Upzis->id_upzis }}">

                                                <select class="select2 @error('akses_internal') is-invalid @enderror"
                                                    multiple="multiple" data-placeholder="Pilih Pengurus Internal"
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


                                    <div class="row">
                                        <div class="col-lg-6 col-6 intro-sifat-disposisi-sk">
                                            <div class="form-group row intro-sifat-disposisi-out">
                                                <label class="col-sm-4 col-form-label">Sifat</label>

                                                <div class="col-sm-8">

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

                                            <div class="form-group row intro-sppd-disposisi-sk">
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


                                            <div class="form-group row intro-perihal-disposisi-sk">
                                                <label class="col-sm-4 col-form-label">Perihal Disposisi</label>
                                                <div class="col-sm-8">
                                                    <input
                                                        class="form-control  @error('perihal_disposisi') is-invalid @enderror"
                                                        name="perihal_disposisi" placeholder="Masukan Perihal Disposisi"
                                                        value="{{ old('perihal_disposisi') }}">
                                                    @error('perihal_disposisi')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <br>


                                </div>
                                <!-- /.card-body -->
                            </div>

                            {{-- SPPD --}}
                            <div class="card card-success intro-table-sppd-out" id="sppd-card">
                                <div class="row mt-4 ml-4 justify-content-between">
                                    <div>
                                        <h3 class="card-title "><b>Rincian SPPD</b>
                                        </h3>
                                        &nbsp; <a href="#" class="sweet-tooltip"
                                            data-style-tooltip="tooltip-mini-slick"
                                            id="panduan-sppd-tour-guid-surat-keluar"><i
                                                class="far fa-question-circle"></i></a>
                                    </div>
                                    <!-- Button trigger modal -->

                                    {{-- <input type="hidden" name="pelaksana_kegiatan"> --}}
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6 col-6">


                                            <div class="form-group row intro-tgl-perintah-sppd-out">
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
                                            <div class="form-group row intro-tgl-pelaksana-sppd-out">
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

                                            <div class="form-group row intro-anggaran-sppd-out">
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


                                            <div class="form-group row intro-perihal-sppd-out">
                                                <label class="col-sm-4 col-form-label">Perihal SPPD</label>
                                                <div class="col-sm-8">
                                                    <input
                                                        class="form-control @error('perihal_sppd') is-invalid @enderror"
                                                        name="perihal_sppd" value="{{ old('perihal_sppd') }}"
                                                        placeholder="Masukan Perihal SPPD">
                                                    @error('perihal_sppd')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>


                                        </div>

                                    </div>
                                    <br>

                                </div>
                                <!-- /.card-body -->
                            </div>

                            {{-- Lampiran --}}
                            <div class="card card-success ijo-atas intro-scan-out">
                                <div class="row mt-4 ml-4 justify-content-between">
                                    <div>
                                        <h3 class="card-title "><b>Upload Lampiran</b>
                                        </h3>
                                        &nbsp; <a href="#" class="sweet-tooltip"
                                            data-style-tooltip="tooltip-mini-slick"
                                            id="panduan-lampiran-tour-guid-surat-keluar"><i
                                                class="far fa-question-circle"></i></a>
                                    </div>

                                    <div class="col-auto mr-3">

                                        <button id="addRow" type="button"
                                            class="btn btn-primary intro-tambah-lampiran-out"> <i
                                                class="fas fa-plus-circle" aria-hidden="true"></i> Tambah
                                            Lampiran</button>
                                    </div>

                                </div>

                                <div class="card-body mr-3 ml-3 intro-scan-sk">

                                    <div class="form-group row ">

                                        <label> Silahkan pilih file dokumen anda. Ukuran maksimal file 2
                                            MB. Jenis dokumen yang diijinkan adalah: <b>jpg, doc, docx, pdf, jpeg,
                                                png</b></label><br>

                                    </div>

                                    <div class="form-group row ">
                                        <label class="text-danger">*Jika lampiran tidak ada maka tidak perlu
                                            dilampirkan</label>
                                    </div>

                                    <div class="form-group row ">

                                        <label class="col-sm-4 col-form-label">
                                            Scan Surat </label>
                                        <input style="width: 100%;" class="form-control" class="form-control m-input"
                                            type="text" id="formFileSm" name="nama_surat"
                                            placeholder="Masukan Judul Surat" autocomplete="off">
                                    </div>



                                    <div class="form-group row ">
                                        <input style="width: 100%;" class="form-control" class="form-control m-input"
                                            type="file" name="scan_surat" id="formFileSm"
                                            accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" autocomplete="off">
                                    </div>


                                    <div id="newRow"></div>


                                    <script type="text/javascript">
                                        // add row

                                        $("#addRow").click(function() {

                                            var html = '';

                                            html += '<div id="inputFormRow1">';
                                            html += '<label class="col-form-label">Lampiran  </label > ';
                                            html += '<div class="form-group row">';
                                            html +=
                                                '<input type="text" name="nama[]" class="form-control " placeholder="Masukan Judul Lampiran" autocomplete="off" >';
                                            html += '</div>';
                                            html += '<div class="form-group row " >';
                                            html += '<div class="input-group" id="inputFormRow">';
                                            html +=
                                                '<input  type="file" name="lampiran[]" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="form-control " placeholder="Masukan Judul Lampiran" autocomplete="off" >' +
                                                '<div class="input-group-append" >' +
                                                '<button id="removeRow" type="button" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>' +
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
                        <div class="card-footer ">
                            <div class="col-auto float-right">
                                <!-- Button trigger modal -->
                                <a href=" javascript:history.back()" type="button"
                                    class="intro-batal-sk btn btn-secondary">
                                    <i class="fas fa-ban"></i> Batal
                                </a>
                                <button onclick="$('#cover-spin').show(0)" type="submit"
                                    class=" btn btn-success intro-saves-out" name="submit">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                                {{-- <script>
                                    function simpan(form) {
                                        form.target = '';
                                        form.action = '/{{ $role }}/aksi_tambah_surat_keluar_baru';
                                        form.submit();
                                    }
                                </script> --}}
                            </div>
                        </div>
                    </div>

                </form>
            @endif

        </div>


    </section>

@endsection

@section('js')
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




@endsection

@push('custom-scripts')
    {{-- ada disposisi atau tidak --}}
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
            }
        });
    </script>
@endpush


@push('tambah_surat_keluar')

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

    @if ($stat == '0')
        <script>
            var yeso = document.getElementById("panduan-rincian-surat-tour-guid-surat-keluar");
            yeso.onclick = function() {
                introJs().setOptions({
                    steps: [{
                            element: document.querySelector('.intro-table-rincian-arsip-out'),
                            title: 'Form Rincian Surat Keluar',
                            intro: 'Form Isian Surat Keluar'
                        },
                        {
                            element: document.querySelector('.intro-tgl-arsip-out'),
                            title: 'Tanggal Surat',
                            intro: 'Kolom Input Untuk Kapan Surat Ini Dibuat'
                        },
                        {
                            element: document.querySelector('.intro-klasifikasi-out'),
                            title: 'Klasifikasi Surat',
                            intro: 'Kolom Input Untuk Klasifikasi Surat yang Dibuat'
                        },
                        {
                            element: document.querySelector('.intro-nomor-out'),
                            title: 'Nomor Surat',
                            intro: 'Kolom Input Untuk Nomor Surat yang Dibuat'
                        },
                        {
                            element: document.querySelector('.intro-disposisi-out'),
                            title: 'Disposisi Surat',
                            intro: 'Memunculkan Isian Data Disposisi Surat Yang Dibutuhkan'
                        },
                        {
                            element: document.querySelector('.intro-pengirim-out'),
                            title: 'Pengirim Surat',
                            intro: 'Kolom Input Untuk Pengirim Surat Dibuat'
                        },
                        {
                            element: document.querySelector('.intro-perihal-out'),
                            title: 'Perihal Surat',
                            intro: 'Kolom Input Untuk Perihal Surat Dibuat'
                        },
                        {
                            element: document.querySelector('.intro-penerima-out'),
                            title: 'Penerima Surat',
                            intro: 'Kolom Input Untuk Penerima Surat Dibuat'
                        },
                        {
                            element: document.querySelector('.intro-penerima-disposisi-out'),
                            title: 'Penerima Surat',
                            intro: 'Kolom Input Untuk Penerima Surat Dibuat'
                        },
                    ]
                }).start();
            }
        </script>
    @else
        <script>
            var yeso = document.getElementById("panduan-rincian-surat-tour-guid-surat-keluar");
            yeso.onclick = function() {
                introJs().setOptions({
                    steps: [{
                            element: document.querySelector('.intro-table-rincian-arsip-out'),
                            title: 'Form Rincian Surat Keluar',
                            intro: 'Form Isian Surat Keluar'
                        },
                        {
                            element: document.querySelector('.intro-tgl-arsip-out'),
                            title: 'Tanggal Surat',
                            intro: 'Kolom Input Untuk Kapan Surat Ini Dibuat'
                        },
                        {
                            element: document.querySelector('.intro-klasifikasi-out'),
                            title: 'Klasifikasi Surat',
                            intro: 'Kolom Input Untuk Klasifikasi Surat yang Dibuat'
                        },
                        {
                            element: document.querySelector('.intro-jenis-surat-out'),
                            title: 'Jenis Surat',
                            intro: 'Kolom Input Untuk Jenis Surat yang Dibuat'
                        },
                        {
                            element: document.querySelector('.intro-nomor-out'),
                            title: 'Nomor Surat',
                            intro: 'Kolom Input Untuk Nomor Surat yang Dibuat'
                        },

                        {
                            element: document.querySelector('.intro-pengirim-out'),
                            title: 'Pengirim Surat',
                            intro: 'Kolom Input Untuk Pengirim Surat'
                        },
                        {
                            element: document.querySelector('.intro-perihal-out'),
                            title: 'Perihal Surat',
                            intro: 'Kolom Input Untuk Perihal Surat Dibuat'
                        },
                        {
                            element: document.querySelector('.intro-penerima-out'),
                            title: 'Penerima Surat',
                            intro: 'Kolom Input Untuk Penerima Surat Dibuat'
                        },
                        {
                            element: document.querySelector('.intro-disposisi-out'),
                            title: 'Disposisi Surat',
                            intro: 'Memunculkan Isian Data Disposisi Surat Yang Dibutuhkan'
                        },
                        {
                            element: document.querySelector('.intro-penerima-disposisi-out'),
                            title: 'Penerima Surat',
                            intro: 'Kolom Input Untuk Penerima Surat Dibuat'
                        },
                        {
                            element: document.querySelector('.intro-isi-surat-out'),
                            title: 'Isi Surat Keluar',
                            intro: 'Kolom Input Untuk Isi Surat Surat Dibuat'
                        },

                    ]
                }).start();
            }
        </script>
        {{-- <script>
            function klikkene(value) {
                introJs().setOptions({
                        steps: [{
                                element: document.querySelector('.intro-table-rincian-arsip-out'),
                                title: 'Form Rincian Surat Keluar',
                                intro: 'Form Isian Surat Keluar'
                            },
                            {
                                element: document.querySelector('.intro-tgl-arsip-out'),
                                title: 'Tanggal Surat',
                                intro: 'Kolom Input Untuk Kapan Surat Ini Dibuat'
                            },
                            {
                                element: document.querySelector('.intro-klasifikasi-out'),
                                title: 'Klasifikasi Surat',
                                intro: 'Kolom Input Untuk Klasifikasi Surat yang Dibuat'
                            },
                            {
                                element: document.querySelector('.intro-jenis-surat-out'),
                                title: 'Jenis Surat',
                                intro: 'Kolom Input Untuk Jenis Surat yang Dibuat'
                            },
                            {
                                element: document.querySelector('.intro-nomor-out'),
                                title: 'Nomor Surat',
                                intro: 'Kolom Input Untuk Nomor Surat yang Dibuat'
                            },

                            {
                                element: document.querySelector('.intro-pengirim-out'),
                                title: 'Pengirim Surat',
                                intro: 'Kolom Input Untuk Pengirim Surat'
                            },
                            {
                                element: document.querySelector('.intro-perihal-out'),
                                title: 'Perihal Surat',
                                intro: 'Kolom Input Untuk Perihal Surat Dibuat'
                            },
                            {
                                element: document.querySelector('.intro-penerima-out'),
                                title: 'Penerima Surat',
                                intro: 'Kolom Input Untuk Penerima Surat Dibuat'
                            },
                            {
                                element: document.querySelector('.intro-disposisi-out'),
                                title: 'Disposisi Surat',
                                intro: 'Memunculkan Isian Data Disposisi Surat Yang Dibutuhkan'
                            },
                            {
                                element: document.querySelector('.intro-penerima-disposisi-out'),
                                title: 'Penerima Surat',
                                intro: 'Kolom Input Untuk Penerima Surat Dibuat'
                            },
                            {
                                element: document.querySelector('.intro-isi-surat-out'),
                                title: 'Isi Surat Keluar',
                                intro: 'Kolom Input Untuk Isi Surat Surat Dibuat'
                            },


                            {
                                element: document.querySelector('.intro-tambah-lampiran-out'),
                                title: 'Tambah Lampiran Lainnya',
                                intro: 'Menampilkan Lampiran Baru Jika Dibutuhkan untuk melakukan Tambah Data Lampiran'
                            },
                            {
                                element: document.querySelector('.intro-scan-out'),
                                title: 'Scan Surat',
                                intro: 'Kolom Input Untuk isian file dan nama file yang akan disimpan '
                            },
                            {
                                element: document.querySelector('.intro-saves-out'),
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
                    }).start();
            }

            $(document).ready(function() {
                klikkene(true);
                $("#panduan").click(function() {
                    klikkene(false);
                });
            });
        </script> --}}
    @endif

    {{-- <script>
        var yes = document.getElementById("tombol-disposisi1");
        yes.onclick = function() {
            introJs().setOptions({
                    steps: [{
                            element: document.querySelector('.intro-table-disposisi-out'),
                            title: 'Disposisi Surat ',
                            intro: 'Menampilkan Data Pilihan Disposisi'
                        },
                        {
                            element: document.querySelector('.intro-satuan-jenis-disposisi'),
                            title: 'Penerima Satuan ',
                            intro: 'Menampilkan Data Satuan Penerima Disposisi Surat'
                        },
                        {
                            element: document.querySelector('.intro-golongan-jenis-disposisi'),
                            title: 'Penerima Golongan',
                            intro: 'Menampilkan Data Golongan Penerima Disposisi Surat '
                        },
                        {
                            element: document.querySelector('.intro-internal-pc-jenis-disposisi'),
                            title: 'Penerima Intenal',
                            intro: 'Menampilkan Data Internal Pengurus Penerima Disposisi Surat'
                        },
                        {
                            element: document.querySelector('.intro-sifat-disposisi-out'),
                            title: 'Sifat Disposisi',
                            intro: 'Menunjukan Pilihan Disposisi Surat '
                        },
                        {
                            element: document.querySelector('.intro-perihal-disposisi-sk'),
                            title: 'Perihal Disposisi',
                            intro: 'Kolom Input Untuk perihal Disposisi Surat'
                        },
                        {
                            element: document.querySelector('.intro-sppd-disposisi-sk'),
                            title: 'SPPD',
                            intro: 'Memunculkan data SPPD yang Dibutuhkan'
                        }
                    ]
                }).setOption("dontShowAgain", true)
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
    </script> --}}

    <script>
        var yeso = document.getElementById("panduan-sppd-tour-guid-surat-keluar");
        yeso.onclick = function() {
            introJs().setOptions({
                steps: [{
                        element: document.querySelector('.intro-table-sppd-out'),
                        title: 'SPPD Surat Keluar ',
                        intro: 'Menampilkan Data SPPD Surat Keluar'
                    },
                    {
                        element: document.querySelector('.intro-tgl-perintah-sppd-out'),
                        title: 'Tanggal Perintah SPPD',
                        intro: 'Menunjukan Tanggal Perintah SPPD'
                    },
                    {
                        element: document.querySelector('.intro-tgl-pelaksana-sppd-out'),
                        title: 'Tanggal Pelaksana SPPD',
                        intro: 'Menunjukan Tanggal Pelaksanaan SPPD'
                    },
                    {
                        element: document.querySelector('.intro-anggaran-sppd-out'),
                        title: 'Anggaran SPPD',
                        intro: 'Menunjukan Jumlah Anggaran SPPD'
                    },
                    {
                        element: document.querySelector('.intro-perihal-sppd-out'),
                        title: 'Perihal SPPD',
                        intro: 'Menunjukan Perihal SPPD'
                    }
                ]
            }).start();
        }
    </script>

    <script>
        var yeso = document.getElementById("panduan-lampiran-tour-guid-surat-keluar");
        yeso.onclick = function() {
            introJs().setOptions({
                steps: [{
                        element: document.querySelector('.intro-scan-out'),
                        title: 'Scan Surat',
                        intro: 'Kolom Input Untuk isian file dan nama file yang akan disimpan '
                    },
                    {
                        element: document.querySelector('.intro-tambah-lampiran-out'),
                        title: 'Tambah Lampiran Lainnya',
                        intro: 'Menampilkan Lampiran Baru Jika Dibutuhkan untuk melakukan Tambah Data Lampiran'
                    },
                    {
                        element: document.querySelector('.intro-scan-sk'),
                        title: 'Lampiran Dokumen',
                        intro: 'Kolom Input Untuk isian file dan nama file yang akan disimpan '
                    },
                    {
                        element: document.querySelector('.intro-batal-sk'),
                        title: 'Batal',
                        intro: 'Klik Disini Untuk Membatalkan Penyimpanan Arsip Dokumen'
                    },
                    {
                        element: document.querySelector('.intro-saves-out'),
                        title: 'Simpan',
                        intro: 'Klik Disini Untuk Menyimpan Arsip Surat Masuk'
                    }
                ]
            }).start();
        }
    </script>


    <script>
        var yeso = document.getElementById("panduan-disposisi-tour-guid-surat-keluar");
        yeso.onclick = function() {
            introJs().setOptions({
                steps: [{
                        element: document.querySelector('.intro-table-disposisi-sk'),
                        title: 'Disposisi',
                        intro: 'Form Disposisi Surat Keluar '
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
                        element: document.querySelector('.intro-sifat-disposisi-sk'),
                        title: 'Sifat Disposisi',
                        intro: 'Pilih Sifat Disposisi Pada Kolom Ini'
                    },
                    {
                        element: document.querySelector('.intro-perihal-disposisi-sk'),
                        title: 'Perihal Disposisi',
                        intro: 'Masukkan Perihal Disposisi Pada Kolom Ini'
                    },
                    {
                        element: document.querySelector('.intro-sppd-disposisi-sk'),
                        title: 'SPPD',
                        intro: 'Jika surat akan di SPPD, pilih YA'
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
                    $("#select2-satuan_pcnu").attr('style',
                        'display: none;');

                    $("#select2-internal").attr('style',
                        'display: block;');

                    return true;
                }

            }).start();
        }
    </script>
@endpush
