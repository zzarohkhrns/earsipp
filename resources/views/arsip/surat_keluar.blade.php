@extends('main')

@section($part, 'active')
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
                            @if ($hal == 'pc')
                                <a href="/{{ $role }}/dashboard">Dashboard</a> / <a>Surat Keluar Oleh LAZISNU</a>
                            @else
                                <a href="/{{ $role }}/dashboard">Dashboard</a> / <a>Surat Keluar Oleh UPZIS</a>
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
                                    <div class="row card-surat-keluar">
                                        <div class="col-12">
                                            <h5 class="d-flex ">
                                                <b class="text-success pl-2">SURAT KELUAR</b>
                                            </h5>
                                        </div>
                                        @if ($hal == 'pc')
                                        @elseif ($hal == 'upzis')
                                            <ul class="nav nav-tabs mt-2 pl-3" data-toggle="" id="tabMenu" role="tablist">
                                                @if (Auth::user()->gocap_id_pc_pengurus != null and $hal == 'upzis')
                                                    <li class="nav-item"><a class="nav-link active" href="#semua"
                                                            data-toggle="tab">Semua Arsip</a>
                                                    </li>
                                                    <li class="nav-item"><a class="nav-link"
                                                            href="/{{ $role }}/arsip/surat_keluar_pc2/upzis">Arsip
                                                            Yang
                                                            Didisposisikan Kepada Anda</a>
                                                    </li>
                                                @endif
                                                @if (Auth::user()->gocap_id_upzis_pengurus != null and $hal == 'upzis')
                                                    <li class="nav-item"><a class="nav-link active" href="#semua"
                                                            data-toggle="tab">Arsip Yang Anda Buat</a>
                                                    </li>
                                                    <li class="nav-item"><a class="nav-link"
                                                            href="/{{ $role }}/arsip/surat_keluar_upzis2/upzis">Arsip
                                                            Yang
                                                            Didisposisikan Kepada Anda</a>
                                                    </li>
                                                @endif
                                            </ul>
                                        @endif


                                        <div class="col-12  col-md-12 col-sm-12 mb-2 mb-xl-0 mt-2">
                                            <div class="card ">
                                                <div class="card-body ">

                                                    <form method="post"
                                                        action="/{{ $role }}/filter/surat_keluar/{{ $part }}/{{ $hal }}">
                                                        @csrf
                                                        <input type="hidden" name="jenis" value="Surat Keluar">
                                                        <input type="hidden" name="filephp" value="surat_keluar">


                                                        <div class="row card-filter-surat_keluar">
                                                            {{-- filter kategori --}}
                                                            <div class="col-12 col-md-3 col-sm-12 mb-2 mb-xl-0">
                                                                <div class="input-group mb-2">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">Klasifikasi
                                                                        </div>
                                                                    </div>
                                                                    <select class="form-control " id="select-kegiatan"
                                                                        name="klasifikasi"
                                                                        onchange="javascript:this.form.submit();">

                                                                        @if ($klasifikasis == '')
                                                                            <option value="" selected hidden>
                                                                                klasifikasi
                                                                            </option>
                                                                        @else
                                                                            <option value="{{ $klasifikasis }}" selected
                                                                                hidden>
                                                                                {{ $klasifikasis }}
                                                                            </option>
                                                                        @endif
                                                                        <option value="">Semua
                                                                        </option>
                                                                        <option value="Biasa">Biasa
                                                                        </option>
                                                                        <option value="Khusus">
                                                                            Khusus
                                                                        </option>

                                                                    </select>
                                                                </div>


                                                            </div>

                                                            <div class="col-12 col-md-3 col-sm-12 mb-2 mb-xl-0 ">
                                                                <div class="input-group mb-2">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">Disposisi
                                                                        </div>
                                                                    </div>
                                                                    <select class="form-control " name="disposisi"
                                                                        onchange="javascript:this.form.submit();">
                                                                        @if ($disposisis == '')
                                                                            <option value="" selected hidden>
                                                                                Disposisi
                                                                            </option>
                                                                        @else
                                                                            <option value="{{ $disposisis }}" selected
                                                                                hidden>
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

                                                            {{-- filter kondisi --}}
                                                            <div class="col-12 col-md-3 col-sm-12 mb-2 mb-xl-0 ">
                                                                <div class="input-group mb-2">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">Bulan</div>
                                                                    </div>
                                                                    <select class="col mr-2 form-control" name="bulan"
                                                                        onchange="javascript:this.form.submit();">
                                                                        @if ($bulans == '')
                                                                            <option value="" selected hidden>
                                                                                Pilih
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
                                                                            <option value="{{ $bulans }}" selected
                                                                                hidden>
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
                                                            {{-- filter tahun --}}
                                                            <div class="col-12 col-md-3 col-sm-12 mb-2 mb-xl-0 ">
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
                                                                            <option value="{{ $tahuns }}" selected
                                                                                hidden>
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

                                                        </div>

                                                        <div class="form-row mt-2">

                                                            {{-- info --}}
                                                            <div class="col-12 col-md-10 col-sm-12 mb-2 mb-xl-0">
                                                                <div
                                                                    class="d-flex flex-row bd-highlight align-items-center">
                                                                    <div class="p-2 bd-highlight">
                                                                        <i class="fas fa-info-circle"></i>
                                                                    </div>
                                                                    <div class="p-1 bd-highlight">
                                                                        <span>
                                                                            @if (Auth::user()->gocap_id_pc_pengurus != null)
                                                                                @if ($hal == 'pc')
                                                                                    <span class="">Arsip Surat Keluar
                                                                                        Yang
                                                                                        Dibuat Oleh <span
                                                                                            class="text-bold">PC
                                                                                            LAZISNU CILACAP
                                                                                        </span>
                                                                                    </span>
                                                                                @else
                                                                                    Arsip Surat Keluar yang dibuat &
                                                                                    ditujukan oleh

                                                                                    <span class="text-bold">UPZIS MWC NU
                                                                                    </span>
                                                                                @endif
                                                                            @elseif(Auth::user()->gocap_id_upzis_pengurus != null)
                                                                                @if ($hal == 'pc')
                                                                                    <span class="">Arsip Surat Keluar
                                                                                        Yang
                                                                                        Dibuat Oleh <span
                                                                                            class="text-bold">PC
                                                                                            LAZISNU CILACAP </span> &
                                                                                        Ditujukan
                                                                                        Kepada Anda

                                                                                    </span>
                                                                                @else
                                                                                    Arsip Surat Keluar dibuat oleh
                                                                                    <span class="text-bold">UPZIS MWC NU
                                                                                        {{ $wilayah }}
                                                                                    </span>
                                                                                @endif
                                                                            @endif
                                                                        </span>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{-- tombol ekspor --}}
                                                            <div class="col-12 col-md-2 col-sm-12 mb-2 mb-xl-0">
                                                                @if ($hal == 'pc')
                                                                    <div class="btn-group btn-block mb-2 mb-xl-0 card-tambah-surat_keluar"
                                                                        style=" {{ $display }}">

                                                                        <button type="button"
                                                                            class="btn btn-success btn-block"
                                                                            data-toggle="dropdown" aria-haspopup="true"
                                                                            aria-expanded="false"><i
                                                                                class="fas fa-plus-circle"></i>
                                                                            Tambah</button>

                                                                        <div
                                                                            class="dropdown-menu col-12 col-md-12 col-sm-12 mb-2 mb-xl-0">

                                                                            <a onMouseOver="this.style.color='red'"
                                                                                onMouseOut="this.style.color='black'"
                                                                                class="dropdown-item btn btn-success btn-block"
                                                                                data-toggle="modal"
                                                                                data-target="#exampleModalkeluar">
                                                                                <i class="fas fa-plus-circle"></i>
                                                                                Tambah Surat</a>

                                                                            <a onMouseOver="this.style.color='red'"
                                                                                style=""
                                                                                onMouseOut="this.style.color='black'"
                                                                                class="dropdown-item "
                                                                                href="/{{ $role }}/arsip/jenis_arsip"
                                                                                type="button"><i
                                                                                    class="fas fa-plus-circle"></i>
                                                                                Jenis Surat</a>


                                                                        </div>

                                                                    </div>
                                                                @elseif($hal == 'upzis')
                                                                    <div class="btn-group btn-block mb-2 mb-xl-0 card-tambah-surat_keluar"
                                                                        style=" {{ $display }}">
                                                                        <div class="btn-group  mb-2 mb-xl-0 btn-block">

                                                                            <button type="button" class="btn btn-success"
                                                                                data-toggle="dropdown"
                                                                                aria-haspopup="true"
                                                                                aria-expanded="false"><i
                                                                                    class="fas fa-plus-circle"></i>
                                                                                Tambah</button>

                                                                            <div
                                                                                class="dropdown-menu col-12 col-md-12 col-sm-12 mb-2 mb-xl-0">

                                                                                <a onMouseOver="this.style.color='red'"
                                                                                    onMouseOut="this.style.color='black'"
                                                                                    class="dropdown-item btn btn-success btn-block"
                                                                                    data-toggle="modal"
                                                                                    data-target="#exampleModalkeluar">
                                                                                    <i class="fas fa-plus-circle"></i>
                                                                                    Tambah Surat</a>

                                                                                <a onMouseOver="this.style.color='red'"
                                                                                    style=""
                                                                                    onMouseOut="this.style.color='black'"
                                                                                    class="dropdown-item "
                                                                                    href="/{{ $role }}/arsip/jenis_arsip"
                                                                                    type="button"><i
                                                                                        class="fas fa-plus-circle"></i>
                                                                                    Tambah Jenis Surat</a>


                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                @endif

                                                            </div>
                                                        </div>
                                                        {{-- tombol filter --}}

                                                        {{-- <div class="col-12  {{ $col2 }} mb-2 mb-xl-0">
                                                        <div class="btn-group btn-block mb-2 mb-xl-0">
                                                            <button type="submit" class="btn btn-primary btn-block"
                                                                formaction="/{{ $role }}/filter/surat_keluar/{{ $part }}/{{ $hal }}"><i
                                                                    class="fas fa-sort"></i>
                                                                Filter</button>

                                                        </div>

                                                    </div> --}}


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </form>

                                    {{-- END  head --}}






                                    <div class="tab-content">
                                        <div class="active tab-pane" id="semua">


                                            <!-- Isi Tabel -->
                                            <section class="content">
                                                <div class="container-fluid">
                                                    <div class="row card-table-surat-keluar">
                                                        <div class="col-12 ">

                                                            {{-- Judul --}}
                                                            <!-- /.card-header -->
                                                            <table id="example3" class="table table-bordered "
                                                                style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>No</th>
                                                                        <th>Penerima Surat</th>
                                                                        <th>Pengirim</th>
                                                                        <th>Nomor Surat</th>
                                                                        <th>Jenis Disposisi</th>
                                                                        <th>Rincian Surat</th>
                                                                        <th style="width:200px;">Perihal/Isi</th>
                                                                        <th>Aksi</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                    @if (Auth::user()->gocap_id_upzis_pengurus != null)
                                                                        @foreach ($penerima as $penerima_surat)
                                                                            <tr>
                                                                                @php
                                                                                    $jumlah_internal = DB::table('arsip_digital')
                                                                                        ->join('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                                                                                        ->where('disposisi.arsip_digital_id', $penerima_surat->arsip_digital_id)
                                                                                        ->where('arsip_digital.jenis_disposisi', 'Internal')
                                                                                        ->count();
                                                                                    
                                                                                    $jumlah_satuan = DB::table('arsip_digital')
                                                                                        ->join('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                                                                                        ->where('disposisi.arsip_digital_id', $penerima_surat->arsip_digital_id)
                                                                                        ->where('arsip_digital.jenis_disposisi', 'Satuan')
                                                                                        ->count();
                                                                                    
                                                                                    if (
                                                                                        DB::table('arsip_digital')
                                                                                            ->join('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                                                                                            ->where('disposisi.arsip_digital_id', $penerima_surat->arsip_digital_id)
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
                                                                                            ->where('disposisi.arsip_digital_id', $penerima_surat->arsip_digital_id)
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
                                                                                            ->where('disposisi.arsip_digital_id', $penerima_surat->arsip_digital_id)
                                                                                            ->where('id_ranting', '!=', null)
                                                                                            ->exists()
                                                                                    ) {
                                                                                        $ranting = 'Ranting ';
                                                                                    } else {
                                                                                        $ranting = '';
                                                                                    }
                                                                                @endphp

                                                                                <td>{{ $jumlah++ }}</td>
                                                                                <td>{{ $penerima_surat->tujuan_arsip }}

                                                                                </td>
                                                                                <td>
                                                                                    {{ $penerima_surat->pengirim_sumber }}
                                                                                </td>
                                                                                <td> {{ $penerima_surat->nomor_surat }}
                                                                                </td>
                                                                                <td>
                                                                                    @if ($penerima_surat->jenis_disposisi == 'Golongan')
                                                                                        {{ $penerima_surat->jenis_disposisi }}
                                                                                        <br>
                                                                                        {{ $internal }}
                                                                                        {{ $upzis }}
                                                                                        {{ $ranting }}
                                                                                    @elseif($penerima_surat->jenis_disposisi == 'Satuan')
                                                                                        {{ $penerima_surat->jenis_disposisi }}
                                                                                        <br>
                                                                                        ({{ $jumlah_satuan }}
                                                                                        satuan)
                                                                                    @elseif($penerima_surat->jenis_disposisi == 'Internal')
                                                                                        {{ $penerima_surat->jenis_disposisi }}
                                                                                        <br>
                                                                                        ({{ $jumlah_internal }}
                                                                                        pengurus)
                                                                                    @else
                                                                                        Tidak Ada Disposisi
                                                                                    @endif
                                                                                </td>


                                                                                @if ($penerima_surat->klasifikasi_surat == 'Biasa')
                                                                                    <td>
                                                                                        <span style="font-size:16px;"
                                                                                            class="badge rounded-pill  bg-success">
                                                                                            Klasifikasi: Biasa
                                                                                        </span><br>

                                                                                        {{ Carbon\Carbon::parse($penerima_surat->tanggal_arsip)->isoFormat('dddd, D MMMM Y') }}


                                                                                    </td>
                                                                                @elseif($penerima_surat->klasifikasi_surat == 'Khusus')
                                                                                    <td>
                                                                                        <span style="font-size:16px;"
                                                                                            class="badge rounded-pill  bg-primary">
                                                                                            Klasifikasi: Khusus
                                                                                        </span>
                                                                                        <br>

                                                                                        {{ Carbon\Carbon::parse($penerima_surat->tanggal_arsip)->isoFormat('dddd, D MMMM Y') }}

                                                                                    </td>
                                                                                @endif


                                                                                <td style="width:200px;">
                                                                                    @php
                                                                                        $jumlah_lampiran = DB::table('lampiran_arsip')
                                                                                            ->where('arsip_digital_id', $penerima_surat->arsip_digital_id)
                                                                                            ->count();
                                                                                    @endphp
                                                                                    <span style="font-size:16px;"
                                                                                        class="badge rounded-pill  bg-secondary">
                                                                                        Lampiran :
                                                                                        {{ $jumlah_lampiran }}
                                                                                        File
                                                                                    </span>
                                                                                    <br>

                                                                                    {{ Str::limit($penerima_surat->perihal_isi_deskripsi, 40) }}...
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
                                                                                                    href="/{{ $role }}/arsip/detail_surat_keluar/{{ $penerima_surat->arsip_digital_id }}/pc"
                                                                                                    type="button"><i
                                                                                                        class="far fa-eye"></i>
                                                                                                    Detail</a>
                                                                                            @else
                                                                                                <a onMouseOver="this.style.color='red'"
                                                                                                    onMouseOut="this.style.color='black'"
                                                                                                    class="dropdown-item"
                                                                                                    href="/{{ $role }}/arsip/detail_surat_keluar/{{ $penerima_surat->arsip_digital_id }}/upzis"
                                                                                                    type="button"><i
                                                                                                        class="far fa-eye"></i>
                                                                                                    Detail</a>
                                                                                            @endif

                                                                                            @if ($penerima_surat->id_pengguna == Auth::user()->id_pengguna)
                                                                                                <a onMouseOver="this.style.color='red'"
                                                                                                    style="{{ $hide }}"
                                                                                                    onMouseOut="this.style.color='black'"
                                                                                                    class="dropdown-item"
                                                                                                    type="button"
                                                                                                    data-target="#modal_hapus{{ $penerima_surat->arsip_digital_id }}"
                                                                                                    data-toggle="modal"><i
                                                                                                        class="fas fa-trash"></i>
                                                                                                    Hapus</a>
                                                                                            @endif

                                                                                        </div>
                                                                                    </div>


                                                                                </td>
                                                                                {{-- modal hapus --}}
                                                                                <div class="modal fade"
                                                                                    id="modal_hapus{{ $penerima_surat->arsip_digital_id }}"
                                                                                    role="dialog"
                                                                                    aria-labelledby="exampleModalLabel"
                                                                                    aria-hidden="true">
                                                                                    <div class="modal-dialog"
                                                                                        role="document">
                                                                                        <div class="modal-content">
                                                                                            <form
                                                                                                action="/{{ $role }}/arsip/hapus_surat_keluar/{{ $penerima_surat->arsip_digital_id }}"
                                                                                                method="post">
                                                                                                @csrf
                                                                                                <div class="modal-header">

                                                                                                    <h5 class="modal-title"
                                                                                                        id="exampleModalLabel">
                                                                                                        Konfirmasi
                                                                                                            Hapus
                                                                                                    </h5>

                                                                                                </div>
                                                                                                <div class="modal-body">
                                                                                                    <p>Yakin ingin
                                                                                                        menghapus
                                                                                                        data?</p>
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
                                                                        @endforeach
                                                                    @endif

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
                                                                                    Lampiran :
                                                                                    {{ $jumlah_lampiran }} File
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
                                                                                                href="/{{ $role }}/arsip/detail_surat_keluar/{{ $arsip_dikir->arsip_digital_id }}/pc"
                                                                                                type="button"><i
                                                                                                    class="far fa-eye"></i>
                                                                                                Detail</a>
                                                                                        @else
                                                                                            <a onMouseOver="this.style.color='red'"
                                                                                                onMouseOut="this.style.color='black'"
                                                                                                class="dropdown-item"
                                                                                                href="/{{ $role }}/arsip/detail_surat_keluar/{{ $arsip_dikir->arsip_digital_id }}/upzis"
                                                                                                type="button"><i
                                                                                                    class="far fa-eye"></i>
                                                                                                Detail</a>
                                                                                        @endif

                                                                                        @if ($arsip_dikir->id_pengguna == Auth::user()->id_pengguna)
                                                                                            <a onMouseOver="this.style.color='red'"
                                                                                                style="{{ $hide }}"
                                                                                                onMouseOut="this.style.color='black'"
                                                                                                class="dropdown-item"
                                                                                                type="button"
                                                                                                data-target="#modal_hapus{{ $arsip_dikir->arsip_digital_id }}"
                                                                                                data-toggle="modal"><i
                                                                                                    class="fas fa-trash"></i>
                                                                                                Hapus</a>
                                                                                        @endif

                                                                                    </div>
                                                                                </div>


                                                                            </td>
                                                                            {{-- modal hapus --}}
                                                                            <div class="modal fade"
                                                                                id="modal_hapus{{ $arsip_dikir->arsip_digital_id }}"
                                                                                role="dialog"
                                                                                aria-labelledby="exampleModalLabel"
                                                                                aria-hidden="true">
                                                                                <div class="modal-dialog" role="document">
                                                                                    <div class="modal-content">
                                                                                        <form
                                                                                            action="/{{ $role }}/arsip/hapus_surat_keluar/{{ $arsip_dikir->arsip_digital_id }}"
                                                                                            method="post">
                                                                                            @csrf
                                                                                            <div class="modal-header">

                                                                                                <h5 class="modal-title"
                                                                                                    id="exampleModalLabel">
                                                                                                   Konfirmasi
                                                                                                        Hapus
                                                                                                </h5>

                                                                                            </div>
                                                                                            <div class="modal-body">
                                                                                                <p>Yakin ingin
                                                                                                    menghapus
                                                                                                    data?</p>
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
                                                                    @endforeach

                                                                </tbody>


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

                                        <div class="tab-pane" id="dirisendiri">


                                            <!-- Isi Tabel -->
                                            <section class="content">
                                                <div class="container-fluid">
                                                    <div class="row">
                                                        <div class="col-12">

                                                            {{-- Judul --}}
                                                            <!-- /.card-header -->
                                                            {{-- <table id="example1" class="table table-bordered "
                                                                style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Nwdwdwdwdo</th>
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
                                                                                    Lampiran : {{ $jumlah_lampiran }} File
                                                                                </span>
                                                                                <br>

                                                                                {{ Str::limit($arsip_terim->perihal_isi_deskripsi, 40) }}...
                                                                            </td>






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

                                                                                    

                                                                                        @if ($hal == 'pc')
                                                                                            <a onMouseOver="this.style.color='red'"
                                                                                                onMouseOut="this.style.color='black'"
                                                                                                class="dropdown-item"
                                                                                                href="/{{ $role }}/arsip/detail_surat_keluar/{{ $arsip_terim->arsip_digital_id }}/pc"
                                                                                                type="button"><i
                                                                                                    class="far fa-eye"></i>
                                                                                                Detail</a>
                                                                                        @else
                                                                                            <a onMouseOver="this.style.color='red'"
                                                                                                onMouseOut="this.style.color='black'"
                                                                                                class="dropdown-item"
                                                                                                href="/{{ $role }}/arsip/detail_surat_keluar/{{ $arsip_terim->arsip_digital_id }}/upzis"
                                                                                                type="button"><i
                                                                                                    class="far fa-eye"></i>
                                                                                                Detail</a>
                                                                                        @endif

                                                                                      

                                                                                    </div>
                                                                                </div>


                                                                            </td>

                                                                        </tr>
                                                                    @endforeach

                                                                    </thead>



                                                            </table> --}}

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

                                    <!-- /.row -->





                                </div>

                            </div>

                        </div>
    </section>


@endsection
@push('modal_tambah')
    <!-- The Modal -->
    <div class="modal fade bd-example-modal-lg" id="exampleModalkeluar" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pilih Jenis Tambah Surat
                        Keluar :
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">

                    <div class="row">
                        <div class="col-6">
                            <div class="btn btn-outline-dark btn-block" data-aos="zoom-in" data-aos-delay="300"
                                onclick="arsip()">
                                <br>
                                <div class="icon-box iconbox-pink">

                                    <div class="icon">

                                        <img style="z-index: 910;" src="{{ asset('landing_assets/img/arsip.png') }}"
                                            width="45" height="45">
                                    </div><br>
                                    <h4>Arsip Surat</h4>
                                    <p>Tambah Surat Keluar yang sudah tersedia
                                    </p>
                                </div>

                            </div>

                            <script>
                                function arsip() {
                                    location.href = "/{{ $role }}/arsip/tambah_surat_keluar/{{ $hal }}";
                                }
                            </script>
                        </div>

                        <div class="col-6">
                            <div class="btn btn-outline-dark btn-block" data-aos="zoom-in" data-aos-delay="300"
                                onclick="baru()">
                                <br>
                                <div class="icon-box iconbox-pink">

                                    <div class="icon">

                                        <img style="z-index: 910;" src="{{ asset('landing_assets/img/arsip.png') }}"
                                            width="45" height="45">
                                    </div><br>
                                    <h4>Surat Baru</h4>
                                    <p>Tambah Surat Keluar yang baru akan dibuat
                                    </p>
                                </div>

                            </div>
                            <script>
                                function baru() {
                                    location.href = "/{{ $role }}/arsip/tambah_surat_keluar/baru/{{ $hal }}";
                                }
                            </script>
                        </div>
                    </div>


                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-ban"></i>
                        Tutup</button>
                </div>

            </div>
        </div>
    </div>
@endpush

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


    @push('intro_surat_keluar')

        @if ($display == '')
            <script>
                function klikkene(value) {
                    introJs().setOptions({
                            steps: [{
                                    element: document.querySelector('.card-surat-keluar'),
                                    title: 'Surat Keluar',
                                    intro: 'Surat Keluar dapat dibuat oleh siapa saja dan dapat diubah oleh pembuat serta akan ditujukan kepada semua pengurus pada Wilayah tersebut'
                                },
                                {
                                    element: document.querySelector('.card-filter-surat_keluar'),
                                    title: 'Filter Surat Keluar',
                                    intro: 'Untuk menampilkan arsip surat keluar secara spesifik, gunakan filter data'
                                },
                                {
                                    element: document.querySelector('.card-tambah-surat_keluar'),
                                    title: 'Tambah Surat Keluar',
                                    intro: 'Klik disini untuk membuat surat keluar baru'
                                },
                                {
                                    element: document.querySelector('.card-table-surat-keluar'),
                                    title: 'Data Arsip Surat Keluar',
                                    intro: 'Menampilkan Data Surat Keluar'
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
                                    element: document.querySelector('.card-surat-keluar'),
                                    title: 'Surat Keluar',
                                    intro: 'Surat Keluar dapat dibuat oleh siapa saja dan dapat diubah oleh pembuat serta akan ditujukan kepada semua pengurus pada Wilayah tersebut'
                                },
                                {
                                    element: document.querySelector('.card-filter-surat_keluar'),
                                    title: 'Filter Surat Keluar',
                                    intro: 'Untuk menampilkan arsip surat keluar secara spesifik, gunakan filter data'
                                },
                                {
                                    element: document.querySelector('.card-table-surat-keluar'),
                                    title: 'Data Arsip Surat Keluar',
                                    intro: 'Menampilkan Data Surat Keluar'
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
