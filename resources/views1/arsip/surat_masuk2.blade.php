@extends('main')

@section($part, 'active')
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
                            @if ($hal == 'pc')
                                <a href="/{{ $role }}/dashboard">Dashboard</a> / <a>Surat Masuk Kepada LAZISNU</a>
                            @else
                                <a href="/{{ $role }}/dashboard">Dashboard</a> / <a>Surat Masuk Kepada UPZIS</a>
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
    <!-- Header -->

    {{-- head --}}
    @if (Auth::user()->gocap_id_pc_pengurus != null)
        @if ($hal == 'pc')
            @php
                $display = '';
                $col = 'col-md-3';
                $col2 = 'col-md-1';
                $sizecol = 'max-width: 225px;';
            @endphp
        @else
            @php
                $display = 'display: none;';
                $col = 'col-md-3';
                $col2 = 'col-md-2';
                $sizecol = 'max-width: 255px;';
            @endphp
        @endif
    @endif

    @if (Auth::user()->gocap_id_upzis_pengurus != null)
        @if ($hal == 'pc')
            @php
                $display = 'display: none;';
                $col = 'col-md-3';
                $col2 = 'col-md-2';
                $sizecol = 'max-width: 255px;';
            @endphp
        @else
            @php
                $display = '';
                $col = 'col-md-3';
                $col2 = 'col-md-1';
                $sizecol = 'max-width: 225px;';
            @endphp
        @endif
    @endif
    <!-- Main content -->
    <section class="content ">
        <div class="container-fluid">
            {{-- livewire permohonan --}}
            <div>
                <div>
                    {{-- Stop trying to control. --}}


                    <div class="row">
                        <div class="col-12">

                            <div class="card ijo-atas">

                                <div class="card-body ">
                                    <div class="col-12">
                                        <h5 class="d-flex ">
                                            <b class="text-success pl-2">SURAT MASUK</b>
                                        </h5>
                                    </div>
                                    @if ($hal == 'pc')
                                    @elseif ($hal == 'upzis')
                                        <ul class="nav nav-tabs mt-2 pl-3" data-toggle="" id="tabMenu" role="tablist">
                                            @if (Auth::user()->gocap_id_pc_pengurus != null and $hal == 'upzis')
                                                <li class="nav-item"><a class="nav-link"
                                                        href="/{{ $role }}/arsip/surat_masuk_pc/upzis">Semua
                                                        Arsip</a>
                                                </li>
                                                <li class="nav-item"><a class="nav-link active" href="#">Arsip Yang
                                                        Didisposisikan Kepada Anda</a>
                                                </li>
                                            @endif
                                            @if (Auth::user()->gocap_id_upzis_pengurus != null and $hal == 'upzis')
                                                <li class="nav-item"><a class="nav-link"
                                                        href="/{{ $role }}/arsip/surat_masuk_upzis/upzis"> Arsip
                                                        Yang Anda Buat</a>
                                                </li>
                                                <li class="nav-item"><a class="nav-link active" href="#">Arsip Yang
                                                        Didisposisikan Kepada Anda</a>
                                                </li>
                                            @endif
                                        </ul>
                                    @endif

                                    <div class="card">
                                        <div class="card-body">

                                            {{-- baris 1 --}}
                                            <form method="post"
                                                action="/{{ $role }}/filter/surat_masuk/{{ $part }}/{{ $hal }}">
                                                @csrf
                                                <input type="hidden" name="jenis" value="Surat Masuk">
                                                <input type="hidden" name="filephp" value="surat_masuk2">


                                                <div class="row">


                                                    {{-- tanggal mulai --}}
                                                    <div class="col-12 col-md-3 col-sm-12 mb-2 mb-xl-0">
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">Klasifikasi</div>
                                                            </div>
                                                            <select class="form-control " id="select-kegiatan"
                                                                onchange="javascript:this.form.submit();"
                                                                name="klasifikasi">

                                                                @if ($klasifikasis == '')
                                                                    <option value="" selected hidden>
                                                                        klasifikasi
                                                                    </option>
                                                                @else
                                                                    <option value="{{ $klasifikasis }}" selected hidden>
                                                                        {{ $klasifikasis }}
                                                                    </option>
                                                                @endif
                                                                <option value="" onclick="$('#cover-spin').show(0)">
                                                                    Semua
                                                                </option>
                                                                <option value="Biasa" onclick="$('#cover-spin').show(0)">
                                                                    Biasa
                                                                </option>
                                                                <option value="Khusus" onclick="$('#cover-spin').show(0)">
                                                                    Khusus
                                                                </option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                    {{-- end tanggal mulai --}}

                                                    {{-- tanggal selesai --}}
                                                    <div class="col-12 col-md-3 col-sm-12 mb-2 mb-xl-0">
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">Disposisi</div>
                                                            </div>
                                                            <select class="form-control " name="disposisi"
                                                                onchange="javascript:this.form.submit();">
                                                                @if ($disposisis == '')
                                                                    <option value="" selected hidden>
                                                                        Disposisi
                                                                    </option>
                                                                @else
                                                                    <option value="{{ $disposisis }}" selected hidden>
                                                                        {{ $disposisis }}
                                                                    </option>
                                                                @endif
                                                                <option value="">Semua</option>
                                                                <option value="Golongan">Golongan</option>
                                                                <option value="Satuan">Satuan</option>
                                                                <option value="Internal">Internal</option>
                                                                <option value="Tidak Ada">Tidak Ada
                                                                    Disposisi</option>
                                                            </select>
                                                        </div>

                                                    </div>
                                                    {{-- end tanggal selesai --}}

                                                    {{-- penggunaan dana  --}}
                                                    <div class="col-12 col-md-3 col-sm-12 mb-2 mb-xl-0">
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">Bulan</div>
                                                            </div>
                                                            <select class="col mr-2 form-control" name="bulan"
                                                                onchange="javascript:this.form.submit();">
                                                                @if ($bulans == '')
                                                                    <option value="" selected hidden>Pilih
                                                                        Bulan
                                                                    </option>
                                                                @else
                                                                    @php
                                                                        if ($bulans == '01') {
                                                                            $nama_bulan = 'Januari';
                                                                        } elseif ($bulans == '02') {
                                                                            $nama_bulan = 'Februari';
                                                                        } elseif ($bulans == '03') {
                                                                            $nama_bulan = 'Maret';
                                                                        } elseif ($bulans == '04') {
                                                                            $nama_bulan = 'April';
                                                                        } elseif ($bulans == '05') {
                                                                            $nama_bulan = 'Mei';
                                                                        } elseif ($bulans == '06') {
                                                                            $nama_bulan = 'Juni';
                                                                        } elseif ($bulans == '07') {
                                                                            $nama_bulan = 'Juli';
                                                                        } elseif ($bulans == '08') {
                                                                            $nama_bulan = 'Agustus';
                                                                        } elseif ($bulans == '09') {
                                                                            $nama_bulan = 'September';
                                                                        } elseif ($bulans == '10') {
                                                                            $nama_bulan = 'Oktober';
                                                                        } elseif ($bulans == '11') {
                                                                            $nama_bulan = 'November';
                                                                        } elseif ($bulans == '12') {
                                                                            $nama_bulan = 'Desember';
                                                                        }
                                                                    @endphp
                                                                    <option value="{{ $bulans }}" selected hidden>
                                                                        {{ $nama_bulan }}
                                                                    </option>
                                                                @endif
                                                                <option value="">Semua</option>
                                                                <option value="01">Januari</option>
                                                                <option value="02">Februari</option>
                                                                <option value="03">Maret</option>
                                                                <option value="04">April</option>
                                                                <option value="05">Mei</option>
                                                                <option value="06">Juni</option>
                                                                <option value="07">Juli</option>
                                                                <option value="08">Agustus</option>
                                                                <option value="09">September</option>
                                                                <option value="10">Oktober</option>
                                                                <option value="11">November</option>
                                                                <option value="12">Desember</option>



                                                            </select>
                                                        </div>
                                                    </div>
                                                    {{-- end penggunaan dana --}}

                                                    {{-- tombol tambah --}}
                                                    <div class="col-12 col-md-3 col-sm-12 mb-2 mb-xl-0">
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">Tahun</div>
                                                            </div>
                                                            <select class="form-control " name="tahun"
                                                                onchange="javascript:this.form.submit();">
                                                                @if ($tahuns == '')
                                                                    <option value="" selected hidden>
                                                                        Pilih
                                                                        Tahun
                                                                    </option>
                                                                @else
                                                                    <option value="{{ $tahuns }}" selected hidden>
                                                                        {{ $tahuns }}
                                                                    </option>
                                                                @endif
                                                                <option value="">Semua</option>
                                                                @foreach ($tahun_arsip as $tahun_m)
                                                                    <option value="{{ $tahun_m->year }}">
                                                                        {{ $tahun_m->year }}
                                                                    </option>
                                                                @endforeach


                                                            </select>
                                                        </div>

                                                    </div>
                                                    {{-- end tombol tambah --}}

                                                </div>
                                                {{-- end baris 1 --}}

                                                {{-- baris 2 --}}
                                                <div class="form-row mt-2">

                                                    {{-- info --}}
                                                    <div class="col-12 col-md-10 col-sm-12 mb-2 mb-xl-0">
                                                        <div class="d-flex flex-row bd-highlight align-items-center">
                                                            <div class="p-2 bd-highlight">
                                                                <i class="fas fa-info-circle"></i>
                                                            </div>
                                                            <div class="p-1 bd-highlight">
                                                                <span>
                                                                    @if (Auth::user()->gocap_id_pc_pengurus != null)
                                                                        @if ($hal == 'pc')
                                                                            <span class="text-bold">INTERNAL PC NU Care
                                                                                Cilacap
                                                                            </span>
                                                                        @else
                                                                            Arsip Surat Masuk yang dibuat oleh

                                                                            <span class="text-bold">UPZIS MWC NU
                                                                            </span> & Ditujukan Kepada Anda
                                                                        @endif
                                                                    @elseif(Auth::user()->gocap_id_upzis_pengurus != null)
                                                                        @if ($hal == 'pc')
                                                                            <span class="text-bold">INTERNAL PC NU Care
                                                                                Cilacap
                                                                            </span>
                                                                        @else
                                                                            <span class="">Arsip Surat Masuk Yang
                                                                                Ditujukan kepada <span
                                                                                    class="text-bold">UPZIS MWC NU Lain

                                                                                </span>&
                                                                                Didisposisikan Kepada Anda
                                                                            </span>
                                                                        @endif
                                                                    @endif
                                                                </span>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- end info --}}


                                                    {{-- tombol reset --}}
                                                    {{-- <div class="col-12 col-md-2 col-sm-12 mb-2 mb-xl-0">

                                                    <div class="btn-group btn-block mb-2 mb-xl-0">
                                                        <button type="submit" class="btn btn-primary btn-block"><i
                                                                class="fas fa-sort"></i> Filter</button>

                                                    </div>

                                                </div> --}}


                                                    {{-- tombol ekspor --}}
                                                    {{-- <div class="col-12 col-md-2 col-sm-12 mb-2 mb-xl-0">
                                                        @if ($hal == 'pc')
                                                            <div class="btn-group btn-block mb-2 mb-xl-0"
                                                                style=" {{ $display }}">
                                                                <div class="btn-group  mb-2 mb-xl-0 btn-block">
                                                                    <a href="/{{ $role }}/arsip/tambah_surat_masuk/pc"
                                                                        class="btn btn-success  btn-block"><i
                                                                            class="fas fa-plus-circle"></i>
                                                                        Tambah</a>
                                                                </div>

                                                            </div>
                                                        @elseif($hal == 'upzis')
                                                            <div class="btn-group btn-block mb-2 mb-xl-0"
                                                                style=" {{ $display }}">
                                                                <div class="btn-group  mb-2 mb-xl-0 btn-block">
                                                                    <a href="/{{ $role }}/arsip/tambah_surat_masuk/upzis"
                                                                        class="btn btn-success  btn-block"><i
                                                                            class="fas fa-plus-circle"></i>
                                                                        Tambah</a>
                                                                </div>

                                                            </div>
                                                        @endif

                                                    </div> --}}

                                                    {{-- end tombol ekspor --}}

                                                </div>
                                                {{-- end baris 2 --}}

                                        </div>
                                    </div>
                                    </form>
                                    {{-- end filter --}}
                                    <div class="tab-content">
                                        <div class="tab-pane" id="semua">


                                            <!-- Isi Tabel -->
                                            <section class="content">
                                                <div class="container-fluid">
                                                    <div class="row">
                                                        <div class="col-12">

                                                            {{-- Judul --}}
                                                            <!-- /.card-header -->
                                                            <table id="example3" class="table table-bordered "
                                                                style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>No</th>
                                                                        <th>Tujuan Surat</th>
                                                                        <th>Pengirim</th>
                                                                        <th>Nomor Surat</th>
                                                                        <th>Jenis Disposisi</th>
                                                                        <th>Rincian Surat</th>
                                                                        <th style="width:200px;">Perihal/Isi</th>
                                                                        <th>Aksi</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                    @foreach ($arsip_dikirim as $arsip_dikir)
                                                                        <tr>
                                                                            @php
                                                                                $jumlah_internal = DB::table('arsip_digital')
                                                                                    ->join('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                                                                                    ->where('disposisi.arsip_digital_id', $arsip_dikir->arsip_digital_id)
                                                                                    ->where('arsip_digital.jenis_disposisi', 'Internal')
                                                                                    ->count();
                                                                                
                                                                                $jumlah_satuan = DB::table('arsip_digital')
                                                                                    ->join('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                                                                                    ->where('disposisi.arsip_digital_id', $arsip_dikir->arsip_digital_id)
                                                                                    ->where('arsip_digital.jenis_disposisi', 'Satuan')
                                                                                    ->count();
                                                                                
                                                                                if (
                                                                                    DB::table('arsip_digital')
                                                                                        ->join('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                                                                                        ->where('disposisi.arsip_digital_id', $arsip_dikir->arsip_digital_id)
                                                                                        ->where('id_pengurus_internal', '!=', null)
                                                                                        ->exists()
                                                                                ) {
                                                                                    $internal = 'Internal, ';
                                                                                } else {
                                                                                    $internal = '';
                                                                                }
                                                                                
                                                                                if (
                                                                                    DB::table('arsip_digital')
                                                                                        ->join('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                                                                                        ->where('disposisi.arsip_digital_id', $arsip_dikir->arsip_digital_id)
                                                                                        ->where('id_upzis', '!=', null)
                                                                                        ->exists()
                                                                                ) {
                                                                                    $upzis = 'Upzis, ';
                                                                                } else {
                                                                                    $upzis = '';
                                                                                }
                                                                                if (
                                                                                    DB::table('arsip_digital')
                                                                                        ->join('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                                                                                        ->where('disposisi.arsip_digital_id', $arsip_dikir->arsip_digital_id)
                                                                                        ->where('id_ranting', '!=', null)
                                                                                        ->exists()
                                                                                ) {
                                                                                    $ranting = 'Ranting ';
                                                                                } else {
                                                                                    $ranting = '';
                                                                                }
                                                                            @endphp

                                                                            <td>{{ $loop->iteration }}</td>
                                                                            <td>{{ $arsip_dikir->tujuan_arsip }}

                                                                            </td>
                                                                            <td>
                                                                                {{ $arsip_dikir->pengirim_sumber }}
                                                                            </td>
                                                                            <td> {{ $arsip_dikir->nomor_surat }}
                                                                            </td>
                                                                            <td>
                                                                                @if ($arsip_dikir->jenis_disposisi == 'Golongan')
                                                                                    {{ $arsip_dikir->jenis_disposisi }}
                                                                                    <br>
                                                                                    {{ $internal }}
                                                                                    {{ $upzis }}
                                                                                    {{ $ranting }}
                                                                                @elseif($arsip_dikir->jenis_disposisi == 'Satuan')
                                                                                    {{ $arsip_dikir->jenis_disposisi }}
                                                                                    <br>
                                                                                    ({{ $jumlah_satuan }}
                                                                                    satuan)
                                                                                @elseif($arsip_dikir->jenis_disposisi == 'Internal')
                                                                                    {{ $arsip_dikir->jenis_disposisi }}
                                                                                    <br>
                                                                                    ({{ $jumlah_internal }}
                                                                                    pengurus)
                                                                                @else
                                                                                    Tidak Ada Disposisi
                                                                                @endif
                                                                            </td>


                                                                            @if ($arsip_dikir->klasifikasi_surat == 'Biasa')
                                                                                <td>
                                                                                    <span style="font-size:16px;"
                                                                                        class="badge rounded-pill  bg-success">
                                                                                        Klasifikasi: Biasa
                                                                                    </span><br>

                                                                                    {{ Carbon\Carbon::parse($arsip_dikir->tanggal_arsip)->isoFormat('dddd, D MMMM Y') }}


                                                                                </td>
                                                                            @elseif($arsip_dikir->klasifikasi_surat == 'Khusus')
                                                                                <td>
                                                                                    <span style="font-size:16px;"
                                                                                        class="badge rounded-pill  bg-primary">
                                                                                        Klasifikasi: Khusus
                                                                                    </span>
                                                                                    <br>

                                                                                    {{ Carbon\Carbon::parse($arsip_dikir->tanggal_arsip)->isoFormat('dddd, D MMMM Y') }}

                                                                                </td>
                                                                            @endif


                                                                            <td style="width:200px;">
                                                                                @php
                                                                                    $jumlah_lampiran = DB::table('lampiran_arsip')
                                                                                        ->where('arsip_digital_id', $arsip_dikir->arsip_digital_id)
                                                                                        ->count();
                                                                                @endphp

                                                                                <span style="font-size:16px;"
                                                                                    class="badge rounded-pill  bg-secondary">

                                                                                    Lampiran : {{ $jumlah_lampiran }}
                                                                                    File
                                                                                </span>
                                                                                <br>

                                                                                {{ Str::limit($arsip_dikir->perihal_isi_deskripsi, 40) }}...
                                                                            </td>






                                                                            <td>

                                                                                <!-- Example split danger button -->
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

                                                                                    @if (Auth::user()->gocap_id_pc_pengurus != null and $hal == 'upzis')
                                                                                        @php
                                                                                            $hide = 'display:none';
                                                                                        @endphp
                                                                                    @endif

                                                                                    @if (Auth::user()->gocap_id_pc_pengurus != null and $hal == 'pc')
                                                                                        @php
                                                                                            $hide = '';
                                                                                        @endphp
                                                                                    @endif

                                                                                    @if (Auth::user()->gocap_id_upzis_pengurus != null and $hal == 'pc')
                                                                                        @php
                                                                                            $hide = 'display:none';
                                                                                        @endphp
                                                                                    @endif

                                                                                    @if (Auth::user()->gocap_id_upzis_pengurus != null and $hal == 'upzis')
                                                                                        @php
                                                                                            $hide = '';
                                                                                        @endphp
                                                                                    @endif

                                                                                    <div class="dropdown-menu">



                                                                                        @if ($hal == 'pc')
                                                                                            <a onMouseOver="this.style.color='red'"
                                                                                                onMouseOut="this.style.color='black'"
                                                                                                class="dropdown-item"
                                                                                                href="/{{ $role }}/arsip/detail_surat_masuk/{{ $arsip_dikir->arsip_digital_id }}/pc"
                                                                                                type="button"><i
                                                                                                    class="far fa-eye"></i>
                                                                                                Detail</a>
                                                                                        @else
                                                                                            <a onMouseOver="this.style.color='red'"
                                                                                                onMouseOut="this.style.color='black'"
                                                                                                class="dropdown-item"
                                                                                                href="/{{ $role }}/arsip/detail_surat_masuk/{{ $arsip_dikir->arsip_digital_id }}/upzis"
                                                                                                type="button"><i
                                                                                                    class="far fa-eye"></i>
                                                                                                Detail</a>
                                                                                        @endif

                                                                                        @if ($arsip_dikir->id_pengguna == Auth::user()->id_pengguna)
                                                                                            <a style="{{ $hide }}"
                                                                                                onMouseOver="this.style.color='red'"
                                                                                                style=""
                                                                                                onMouseOut="this.style.color='black'"
                                                                                                class="dropdown-item "
                                                                                                href="/{{ $role }}/arsip/hapus_surat_masuk/{{ $arsip_dikir->arsip_digital_id }}"
                                                                                                type="button"><i
                                                                                                    class="fas fa-trash"></i>
                                                                                                Hapus</a>
                                                                                        @endif


                                                                                    </div>
                                                                                </div>


                                                                            </td>

                                                                        </tr>
                                                                    @endforeach

                                                                    </thead>



                                                            </table>

                                                            <!-- /.card-body -->

                                                            <!-- /.card -->
                                                        </div>
                                                        <!-- /.col -->
                                                    </div>
                                                    <!-- /.row -->
                                                </div>
                                                <!-- /.container-fluid -->
                                            </section>
                                        </div>

                                        <div class="active tab-pane" id="dirisendiri">

                                            <!-- Isi Tabel -->
                                            <section class="content">
                                                <div class="container-fluid">
                                                    <div class="row">
                                                        <div class="col-12">

                                                            {{-- Judul --}}
                                                            <!-- /.card-header -->
                                                            <table id="example1" class="table table-bordered "
                                                                style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>No</th>
                                                                        <th>Tujuan Surat</th>
                                                                        <th>Pengirim</th>
                                                                        <th>Nomor Surat</th>
                                                                        <th>Jenis Disposisi</th>
                                                                        <th>Rincian Surat</th>
                                                                        <th style="width:200px;">Perihal/Isi</th>
                                                                        <th>Aksi</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                    @foreach ($arsip_diterima as $arsip_terim)
                                                                        <tr>
                                                                            @php
                                                                                $jumlah_internal = DB::table('arsip_digital')
                                                                                    ->join('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                                                                                    ->where('disposisi.arsip_digital_id', $arsip_terim->arsip_digital_id)
                                                                                    ->where('arsip_digital.jenis_disposisi', 'Internal')
                                                                                    ->count();
                                                                                
                                                                                $jumlah_satuan = DB::table('arsip_digital')
                                                                                    ->join('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                                                                                    ->where('disposisi.arsip_digital_id', $arsip_terim->arsip_digital_id)
                                                                                    ->where('arsip_digital.jenis_disposisi', 'Satuan')
                                                                                    ->count();
                                                                                
                                                                                if (
                                                                                    DB::table('arsip_digital')
                                                                                        ->join('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                                                                                        ->where('disposisi.arsip_digital_id', $arsip_terim->arsip_digital_id)
                                                                                        ->where('id_pengurus_internal', '!=', null)
                                                                                        ->exists()
                                                                                ) {
                                                                                    $internal = 'Internal, ';
                                                                                } else {
                                                                                    $internal = '';
                                                                                }
                                                                                
                                                                                if (
                                                                                    DB::table('arsip_digital')
                                                                                        ->join('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                                                                                        ->where('disposisi.arsip_digital_id', $arsip_terim->arsip_digital_id)
                                                                                        ->where('id_upzis', '!=', null)
                                                                                        ->exists()
                                                                                ) {
                                                                                    $upzis = 'Upzis, ';
                                                                                } else {
                                                                                    $upzis = '';
                                                                                }
                                                                                if (
                                                                                    DB::table('arsip_digital')
                                                                                        ->join('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                                                                                        ->where('disposisi.arsip_digital_id', $arsip_terim->arsip_digital_id)
                                                                                        ->where('id_ranting', '!=', null)
                                                                                        ->exists()
                                                                                ) {
                                                                                    $ranting = 'Ranting ';
                                                                                } else {
                                                                                    $ranting = '';
                                                                                }
                                                                            @endphp

                                                                            <td>{{ $loop->iteration }}</td>
                                                                            <td>{{ $arsip_terim->tujuan_arsip }}

                                                                            </td>
                                                                            <td>
                                                                                {{ $arsip_terim->pengirim_sumber }}
                                                                            </td>
                                                                            <td> {{ $arsip_terim->nomor_surat }}
                                                                            </td>
                                                                            <td>
                                                                                @if ($arsip_terim->jenis_disposisi == 'Golongan')
                                                                                    {{ $arsip_terim->jenis_disposisi }}
                                                                                    <br>
                                                                                    {{ $internal }}
                                                                                    {{ $upzis }}
                                                                                    {{ $ranting }}
                                                                                @elseif($arsip_terim->jenis_disposisi == 'Satuan')
                                                                                    {{ $arsip_terim->jenis_disposisi }}
                                                                                    <br>
                                                                                    ({{ $jumlah_satuan }}
                                                                                    satuan)
                                                                                @elseif($arsip_terim->jenis_disposisi == 'Internal')
                                                                                    {{ $arsip_terim->jenis_disposisi }}
                                                                                    <br>
                                                                                    ({{ $jumlah_internal }}
                                                                                    pengurus)
                                                                                @else
                                                                                    Tidak Ada Disposisi
                                                                                @endif
                                                                            </td>

                                                                            @if ($arsip_terim->klasifikasi_surat == 'Biasa')
                                                                                <td>
                                                                                    <span style="font-size:16px;"
                                                                                        class="badge rounded-pill  bg-success">
                                                                                        Klasifikasi: Biasa
                                                                                    </span><br>

                                                                                    {{ Carbon\Carbon::parse($arsip_terim->tanggal_arsip)->isoFormat('dddd, D MMMM Y') }}


                                                                                </td>
                                                                            @elseif($arsip_terim->klasifikasi_surat == 'Khusus')
                                                                                <td>
                                                                                    <span style="font-size:16px;"
                                                                                        class="badge rounded-pill  bg-primary">
                                                                                        Klasifikasi: Khusus
                                                                                    </span>
                                                                                    <br>

                                                                                    {{ Carbon\Carbon::parse($arsip_terim->tanggal_arsip)->isoFormat('dddd, D MMMM Y') }}

                                                                                </td>
                                                                            @endif


                                                                            <td style="width:200px;">
                                                                                @php
                                                                                    $jumlah_lampiran = DB::table('lampiran_arsip')
                                                                                        ->where('arsip_digital_id', $arsip_terim->arsip_digital_id)
                                                                                        ->count();
                                                                                @endphp
                                                                                <span style="font-size:16px;"
                                                                                    class="badge rounded-pill  bg-secondary">
                                                                                    Lampiran : {{ $jumlah_lampiran }}
                                                                                    File
                                                                                </span>
                                                                                <br>


                                                                                {{ Str::limit($arsip_terim->perihal_isi_deskripsi, 40) }}...
                                                                            </td>






                                                                            <td>

                                                                                <!-- Example split danger button -->
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

                                                                                        <a onMouseOver="this.style.color='red'"
                                                                                            onMouseOut="this.style.color='black'"
                                                                                            class="dropdown-item"
                                                                                            href="/{{ $role }}/arsip/detail_surat_masuk/{{ $arsip_terim->arsip_digital_id }}/upzis"
                                                                                            type="button"><i
                                                                                                class="far fa-eye"></i>
                                                                                            Detail</a>

                                                                                        {{-- <a onMouseOver="this.style.color='red'"
                                                                                            style=""
                                                                                            onMouseOut="this.style.color='black'"
                                                                                            class="dropdown-item "
                                                                                            href="/{{ $role }}/arsip/hapus_surat_masuk/{{ $arsip_terim->arsip_digital_id }}"
                                                                                            type="button"><i
                                                                                                class="fas fa-trash"></i>
                                                                                            Hapus</a> --}}


                                                                                    </div>
                                                                                </div>


                                                                            </td>

                                                                        </tr>
                                                                    @endforeach

                                                                    </thead>



                                                            </table>

                                                            <!-- /.card-body -->

                                                            <!-- /.card -->
                                                        </div>
                                                        <!-- /.col -->
                                                    </div>
                                                    <!-- /.row -->
                                                </div>
                                                <!-- /.container-fluid -->
                                            </section>
                                        </div>
                                        <!-- /.card -->

                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->





                            </div>

                        </div>

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
