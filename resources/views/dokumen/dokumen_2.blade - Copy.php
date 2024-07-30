@extends('main')

@section($part, 'active')

@section('dokumen_ac', 'active menu-open')
@section('dokumen_mo', 'menu-open')

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
                                <a href="/{{ $role }}/dashboard">Dashboard</a> / <a>Dokumen Digital OLEH LAZISNU</a>
                            @else
                                <a href="/{{ $role }}/dashboard">Dashboard</a> / <a>Dokumen Digital OLEH UPZIS</a>
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


    <!-- Main content -->
    <section class="content ">
        <div class="container-fluid">
            {{-- livewire permohonan --}}
            <div>
                <div>
                    {{-- Stop trying to control. --}}


                    <div class="row">
                        <div class="col-12">


                            <!-- /.card-header -->
                            <div class="card ijo-atas">


                                <ul class="nav nav-tabs  mt-2 pl-3" data-toggle="" id="tabMenu" role="tablist">
                                    @if (Auth::user()->gocap_id_pc_pengurus != null and $hal == 'upzis')
                                        <li class="nav-item"><a class="nav-link"
                                                href="/{{ $role }}/arsip/dokumen_digital_pc/upzis">Semua</a>
                                        </li>
                                        <li class="nav-item"><a class="nav-link active" href="#">Kepada PC
                                                {{ $wilayah }}</a>
                                        </li>
                                    @endif
                                    @if (Auth::user()->gocap_id_upzis_pengurus != null and $hal == 'upzis')
                                        <li class="nav-item"><a class="nav-link"
                                                href="/{{ $role }}/arsip/dokumen_digital_upzis/upzis">Oleh
                                                Upzis {{ $wilayah }}</a>
                                        </li>
                                        <li class="nav-item"><a class="nav-link active" href="#">Kepada Upzis
                                                {{ $wilayah }}</a>
                                        </li>
                                    @endif
                                </ul>

                                <!-- Header -->
                                <!-- /.card-header -->
                                <div class="card-body ">
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

                                    <div class="row ">
                                        <div class="col-12">
                                            <h5><b class="text-success pl-2">DOKUMEN DIGITAL</b></h5>
                                            {{-- Menampilkan Data Dokumen Digital {{ strtoupper($head) }} --}}
                                        </div>
                                        <div class="col-12  col-md-12 col-sm-12 mb-2 mb-xl-0 mt-3">
                                            <div class="card">
                                                <div class="card-body">
                                                    <form method="post">
                                                        @csrf
                                                        <input type="hidden" name="jenis" value="Dokumen Digital">
                                                        <input type="hidden" name="filephp" value="dokumen2">

                                                        <div class="row">
                                                            {{-- filter kategori --}}
                                                            <div class="col-12 {{ $col }} col-sm-12 mb-2 mb-xl-0"
                                                                style="{{ $sizecol }}">
                                                                <div class="input-group mb-2">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">Klasifikasi</div>
                                                                    </div>
                                                                    <select class="form-control " id="select-kegiatan"
                                                                        name="klasifikasi">

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
                                                                        <option value="Laporan Tahunan">Laporan Tahunan
                                                                        </option>
                                                                        <option value="Produk Hukum Organisasi NU">
                                                                            Produk
                                                                            Hukum Organisasi NU
                                                                        </option>
                                                                        <option value="Produk Hukum Organisasi Banom">
                                                                            Produk
                                                                            Hukum Organisasi
                                                                            Banom
                                                                        </option>
                                                                        <option value="Hasil Bahtsul Masail">Hasil
                                                                            Bahtsul
                                                                            Masail
                                                                        </option>
                                                                    </select>
                                                                </div>


                                                            </div>

                                                            <div class="col-12 {{ $col }} col-sm-12 mb-2 mb-xl-0 "
                                                                style="max-width: 225px;">
                                                                <div class="input-group mb-2">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">Disposisi</div>
                                                                    </div>
                                                                    <select class="form-control " name="disposisi">
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
                                                            <div class="col-12 {{ $col }} col-sm-12 mb-2 mb-xl-0 "
                                                                style="max-width: 225px;">
                                                                <div class="input-group mb-2">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">Bulan</div>
                                                                    </div>
                                                                    <select class="col mr-2 form-control" name="bulan">
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
                                                            <div class="col-12 {{ $col }} col-sm-12 mb-2 mb-xl-0 "
                                                                style="max-width: 225px;">
                                                                <div class="input-group mb-2">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">Tahun</div>
                                                                    </div>
                                                                    <select class="form-control " name="tahun">
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
                                                                        @foreach ($tahun_arsip as $tahun_doc)
                                                                            <option
                                                                                value="{{ substr($tahun_doc, 8, 4) }}">
                                                                                {{ substr($tahun_doc, 8, 4) }}
                                                                            </option>
                                                                        @endforeach


                                                                    </select>
                                                                </div>


                                                            </div>


                                                            {{-- tombol filter --}}

                                                            <div class="col-12  {{ $col2 }} mb-2 mb-xl-0">
                                                                <div class="btn-group btn-block mb-2 mb-xl-0">
                                                                    <button type="submit"
                                                                        class="btn btn-primary btn-block"
                                                                        formaction="/{{ $role }}/filter/dokumen/{{ $part }}/{{ $hal }}"><i
                                                                            class="fas fa-sort"></i> Filter</button>

                                                                </div>

                                                            </div>

                                                            @if ($hal == 'pc')
                                                                <div class="col-12  col-md-2 col-sm-12 mb-2 mb-xl-0 btn-block "
                                                                    style="max-width: 130px; {{ $display }}">
                                                                    <div class="btn-group  mb-2 mb-xl-0 btn-block">
                                                                        <a href="/{{ $role }}/arsip/tambah_dokumen_digital/{{ $hal }}"
                                                                            class="btn btn-success  btn-block"><i
                                                                                class="fas fa-plus-circle"></i>
                                                                            Tambah</a>
                                                                    </div>

                                                                </div>
                                                            @elseif($hal == 'upzis')
                                                                <div class="col-12  col-md-2 col-sm-12 mb-2 mb-xl-0 btn-block"
                                                                    style="max-width: 130px;{{ $display }}">
                                                                    <div class="btn-group  mb-2 mb-xl-0">
                                                                        <a href="/{{ $role }}/arsip/tambah_dokumen_digital/{{ $hal }}"
                                                                            class="btn btn-success "><i
                                                                                class="fas fa-plus-circle"></i>
                                                                            Tambah</a>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                    </form>

                                                    <div class="col-12 col-md-12 col-sm-12 mb-2 mb-xl-0">
                                                        <div class="d-flex flex-row bd-highlight align-items-center">
                                                            <div class="p-2 bd-highlight">
                                                                <i class="fas fa-info-circle"></i>
                                                            </div>
                                                            <div class="p-1 bd-highlight">
                                                                <span>Dikelola Oleh:
                                                                    <span class="text-bold">Seluruh Internal PC LAZISNU
                                                                    </span>

                                                                </span>
                                                                {{-- pada rentang waktu dan tujuan terpilih --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    {{-- END  head --}}
                                </div>

                                <div class="tab-content">
                                    <div class="tab-pane" id="semua">
                                        <!-- Isi Tabel -->
                                        <section class="content">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-12">

                                                        <div class="table-responsive mt-0">

                                                            <table id="example1" class="table table-bordered "
                                                                style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>No</th>
                                                                        <th>Pengirim Sumber</th>
                                                                        <th>Nama Dokumen</th>
                                                                        <th>Jenis Disposisi</th>
                                                                        <th>Rincian Surat</th>
                                                                        <th style="width:200px;">Perihal/Isi</th>
                                                                        <th>Aksi</th>
                                                                    </tr>


                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($dokumen_dikirim as $dokumen_dikir)
                                                                        <tr>
                                                                            @php
                                                                                $jumlah_internal = DB::table('arsip_digital')
                                                                                    ->join('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                                                                                    ->where('disposisi.arsip_digital_id', $dokumen_dikir->arsip_digital_id)
                                                                                    ->where('arsip_digital.jenis_disposisi', 'Internal')
                                                                                    ->count();
                                                                                
                                                                                $jumlah_satuan = DB::table('arsip_digital')
                                                                                    ->join('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                                                                                    ->where('disposisi.arsip_digital_id', $dokumen_dikir->arsip_digital_id)
                                                                                    ->where('arsip_digital.jenis_disposisi', 'Satuan')
                                                                                    ->count();
                                                                                
                                                                                if (
                                                                                    DB::table('arsip_digital')
                                                                                        ->join('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                                                                                        ->where('disposisi.arsip_digital_id', $dokumen_dikir->arsip_digital_id)
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
                                                                                        ->where('disposisi.arsip_digital_id', $dokumen_dikir->arsip_digital_id)
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
                                                                                        ->where('disposisi.arsip_digital_id', $dokumen_dikir->arsip_digital_id)
                                                                                        ->where('id_ranting', '!=', null)
                                                                                        ->exists()
                                                                                ) {
                                                                                    $ranting = 'Ranting ';
                                                                                } else {
                                                                                    $ranting = '';
                                                                                }
                                                                            @endphp


                                                                            <td>{{ $loop->iteration }}</td>
                                                                            <td>
                                                                                {{ $dokumen_dikir->pengirim_sumber }}
                                                                            </td>
                                                                            <td> {{ $dokumen_dikir->nama_dokumen }}
                                                                            </td>
                                                                            <td>
                                                                                @if ($dokumen_dikir->jenis_disposisi == 'Golongan')
                                                                                    {{ $dokumen_dikir->jenis_disposisi }}
                                                                                    <br>
                                                                                    {{ $internal }}
                                                                                    {{ $upzis }}
                                                                                    {{ $ranting }}
                                                                                @elseif($dokumen_dikir->jenis_disposisi == 'Satuan')
                                                                                    {{ $dokumen_dikir->jenis_disposisi }}
                                                                                    <br>
                                                                                    ({{ $jumlah_satuan }}
                                                                                    satuan)
                                                                                @elseif($dokumen_dikir->jenis_disposisi == 'Internal')
                                                                                    {{ $dokumen_dikir->jenis_disposisi }}
                                                                                    <br>
                                                                                    ({{ $jumlah_internal }}
                                                                                    pengurus)
                                                                                @else
                                                                                    Tidak Ada Disposisi
                                                                                @endif
                                                                            </td>

                                                                            @if ($dokumen_dikir->klasifikasi_dokumen == 'Produk Hukum Organisasi NU')
                                                                                <td style="text-align:center;">
                                                                                    <span style="font-size:15px;"
                                                                                        class="badge rounded-pill  bg-primary">{{ $dokumen_dikir->klasifikasi_dokumen }}</span><br>
                                                                                    {{ Carbon\Carbon::parse($dokumen_dikir->tanggal_arsip)->isoFormat('dddd, D MMMM Y') }}
                                                                                </td>
                                                                            @elseif ($dokumen_dikir->klasifikasi_dokumen == 'Hasil Bahtsul Masail')
                                                                                <td style="text-align:center;">
                                                                                    <span style="font-size:15px;"
                                                                                        class="badge rounded-pill  bg-warning">{{ $dokumen_dikir->klasifikasi_dokumen }}</span><br>
                                                                                    {{ Carbon\Carbon::parse($dokumen_dikir->tanggal_arsip)->isoFormat('dddd, D MMMM Y') }}
                                                                                </td>
                                                                            @elseif ($dokumen_dikir->klasifikasi_dokumen == 'Laporan Tahunan')
                                                                                <td style="text-align:center;">
                                                                                    <span style="font-size:15px;"
                                                                                        class="badge rounded-pill  bg-success ">{{ $dokumen_dikir->klasifikasi_dokumen }}</span><br>
                                                                                    {{ Carbon\Carbon::parse($dokumen_dikir->tanggal_arsip)->isoFormat('dddd, D MMMM Y') }}
                                                                                </td>
                                                                            @elseif ($dokumen_dikir->klasifikasi_dokumen == 'Produk Hukum Organisasi Banom')
                                                                                <td style="text-align:center;">
                                                                                    <span style="font-size:15px;"
                                                                                        class="badge rounded-pill  bg-secondary ">{{ $dokumen_dikir->klasifikasi_dokumen }}</span><br>
                                                                                    {{ Carbon\Carbon::parse($dokumen_dikir->tanggal_arsip)->isoFormat('dddd, D MMMM Y') }}
                                                                                </td>
                                                                            @endif
                                                                            <td style="text-align:center;">
                                                                                @php
                                                                                    $jumlah_lampiran = DB::table('lampiran_arsip')
                                                                                        ->where('arsip_digital_id', $dokumen_dikir->arsip_digital_id)
                                                                                        ->count();
                                                                                @endphp

                                                                                <span
                                                                                    class="badge rounded-pill  bg-secondary"
                                                                                    style="font-size:15px;">
                                                                                    {{ $jumlah_lampiran }} File
                                                                                    Lampiran</span>
                                                                                <br>


                                                                                {{ Str::limit($dokumen_dikir->perihal_isi_deskripsi, 40) }}...
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


                                                                                        @if (Auth::user()->gocap_id_pc_pengurus != null)
                                                                                            @if ($part == 'pc_dokumen')
                                                                                                @if ($hal == 'pc')
                                                                                                    <a onMouseOver="this.style.color='red'"
                                                                                                        onMouseOut="this.style.color='black'"
                                                                                                        class="dropdown-item"
                                                                                                        href="/{{ $role }}/arsip/detail_dokumen_digital/{{ $dokumen_dikir->arsip_digital_id }}/pc"
                                                                                                        type="button"><i
                                                                                                            class="far fa-eye"></i>
                                                                                                        Detail</a>
                                                                                                @else
                                                                                                    <a onMouseOver="this.style.color='red'"
                                                                                                        onMouseOut="this.style.color='black'"
                                                                                                        class="dropdown-item"
                                                                                                        href="/{{ $role }}/arsip/detail_dokumen_digital/{{ $dokumen_dikir->arsip_digital_id }}/upzis"
                                                                                                        type="button"><i
                                                                                                            class="far fa-eye"></i>
                                                                                                        Detail</a>
                                                                                                @endif


                                                                                                <a onMouseOver="this.style.color='red'"
                                                                                                    style=""
                                                                                                    onMouseOut="this.style.color='black'"
                                                                                                    class="dropdown-item "
                                                                                                    href="/{{ $role }}/arsip/hapus_dokumen_digital/{{ $dokumen_dikir->arsip_digital_id }}"
                                                                                                    type="button"><i
                                                                                                        class="fas fa-trash"></i>
                                                                                                    Hapus</a>
                                                                                            @else
                                                                                                @if ($hal == 'pc')
                                                                                                    <a onMouseOver="this.style.color='red'"
                                                                                                        onMouseOut="this.style.color='black'"
                                                                                                        class="dropdown-item"
                                                                                                        href="/{{ $role }}/arsip/detail_dokumen_digital/{{ $dokumen_dikir->arsip_digital_id }}/pc"
                                                                                                        type="button"><i
                                                                                                            class="far fa-eye"></i>
                                                                                                        Detail</a>
                                                                                                @else
                                                                                                    <a onMouseOver="this.style.color='red'"
                                                                                                        onMouseOut="this.style.color='black'"
                                                                                                        class="dropdown-item"
                                                                                                        href="/{{ $role }}/arsip/detail_dokumen_digital/{{ $dokumen_dikir->arsip_digital_id }}/upzis"
                                                                                                        type="button"><i
                                                                                                            class="far fa-eye"></i>
                                                                                                        Detail</a>
                                                                                                @endif
                                                                                            @endif
                                                                                        @elseif(Auth::user()->gocap_id_upzis_pengurus != null)
                                                                                            @if ($part == 'pc_dokumen')
                                                                                                <a onMouseOver="this.style.color='red'"
                                                                                                    onMouseOut="this.style.color='black'"
                                                                                                    class="dropdown-item"
                                                                                                    href="/{{ $role }}/arsip/detail_dokumen_digital/{{ $dokumen_dikir->arsip_digital_id }}"
                                                                                                    type="button"><i
                                                                                                        class="far fa-eye"></i>
                                                                                                    Detail</a>
                                                                                            @else
                                                                                                <a onMouseOver="this.style.color='red'"
                                                                                                    onMouseOut="this.style.color='black'"
                                                                                                    class="dropdown-item"
                                                                                                    href="/{{ $role }}/arsip/detail_dokumen_digital/{{ $dokumen_dikir->arsip_digital_id }}"
                                                                                                    type="button"><i
                                                                                                        class="far fa-eye"></i>
                                                                                                    Detail</a>


                                                                                                <a onMouseOver="this.style.color='red'"
                                                                                                    style=""
                                                                                                    onMouseOut="this.style.color='black'"
                                                                                                    class="dropdown-item "
                                                                                                    href="/{{ $role }}/arsip/hapus_dokumen_digital/{{ $dokumen_dikir->arsip_digital_id }}"
                                                                                                    type="button"><i
                                                                                                        class="fas fa-trash"></i>
                                                                                                    Hapus</a>
                                                                                            @endif
                                                                                        @endif



                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                    </thead>
                                                            </table>

                                                        </div>
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

                                    <div class=" active tab-pane" id="dirisendiri">
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
                                                                    <th>Pengirim Sumber</th>
                                                                    <th>Nama Dokumen</th>
                                                                    <th>Jenis Disposisi</th>
                                                                    <th>Rincian Surat</th>
                                                                    <th style="width:200px;">Perihal/Isi</th>
                                                                    <th>Aksi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($dokumen_diterima as $dokumen_terim)
                                                                    <tr>
                                                                        @php
                                                                            $jumlah_internal = DB::table('arsip_digital')
                                                                                ->join('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                                                                                ->where('disposisi.arsip_digital_id', $dokumen_terim->arsip_digital_id)
                                                                                ->where('arsip_digital.jenis_disposisi', 'Internal')
                                                                                ->count();
                                                                            
                                                                            $jumlah_satuan = DB::table('arsip_digital')
                                                                                ->join('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                                                                                ->where('disposisi.arsip_digital_id', $dokumen_terim->arsip_digital_id)
                                                                                ->where('arsip_digital.jenis_disposisi', 'Satuan')
                                                                                ->count();
                                                                            
                                                                            if (
                                                                                DB::table('arsip_digital')
                                                                                    ->join('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                                                                                    ->where('disposisi.arsip_digital_id', $dokumen_terim->arsip_digital_id)
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
                                                                                    ->where('disposisi.arsip_digital_id', $dokumen_terim->arsip_digital_id)
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
                                                                                    ->where('disposisi.arsip_digital_id', $dokumen_terim->arsip_digital_id)
                                                                                    ->where('id_ranting', '!=', null)
                                                                                    ->exists()
                                                                            ) {
                                                                                $ranting = 'Ranting ';
                                                                            } else {
                                                                                $ranting = '';
                                                                            }
                                                                        @endphp

                                                                        <td>{{ $loop->iteration }}</td>

                                                                        <td>
                                                                            {{ $dokumen_terim->pengirim_sumber }}
                                                                        </td>
                                                                        <td> {{ $dokumen_terim->nama_dokumen }}
                                                                        </td>
                                                                        <td>
                                                                            @if ($dokumen_terim->jenis_disposisi == 'Golongan')
                                                                                {{ $dokumen_terim->jenis_disposisi }}
                                                                                <br>
                                                                                {{ $internal }}
                                                                                {{ $upzis }}
                                                                                {{ $ranting }}
                                                                            @elseif($dokumen_terim->jenis_disposisi == 'Satuan')
                                                                                {{ $dokumen_terim->jenis_disposisi }}
                                                                                <br>
                                                                                ({{ $jumlah_satuan }}
                                                                                satuan)
                                                                            @elseif($dokumen_terim->jenis_disposisi == 'Internal')
                                                                                {{ $dokumen_terim->jenis_disposisi }}
                                                                                <br>
                                                                                ({{ $jumlah_internal }}
                                                                                pengurus)
                                                                            @else
                                                                                Tidak Ada Disposisi
                                                                            @endif
                                                                        </td>

                                                                        @if ($dokumen_terim->klasifikasi_dokumen == 'Produk Hukum Organisasi NU')
                                                                            <td style="text-align:center;">
                                                                                <span style="font-size:15px;"
                                                                                    class="badge rounded-pill  bg-primary">{{ $dokumen_terim->klasifikasi_dokumen }}</span><br>
                                                                                {{ Carbon\Carbon::parse($dokumen_terim->tanggal_arsip)->isoFormat('dddd, D MMMM Y') }}
                                                                            </td>
                                                                        @elseif ($dokumen_terim->klasifikasi_dokumen == 'Hasil Bahtsul Masail')
                                                                            <td style="text-align:center;">
                                                                                <span style="font-size:15px;"
                                                                                    class="badge rounded-pill  bg-warning">{{ $dokumen_terim->klasifikasi_dokumen }}</span><br>
                                                                                {{ Carbon\Carbon::parse($dokumen_terim->tanggal_arsip)->isoFormat('dddd, D MMMM Y') }}
                                                                            </td>
                                                                        @elseif ($dokumen_terim->klasifikasi_dokumen == 'Laporan Tahunan')
                                                                            <td style="text-align:center;">
                                                                                <span style="font-size:15px;"
                                                                                    class="badge rounded-pill  bg-success ">{{ $dokumen_terim->klasifikasi_dokumen }}</span><br>
                                                                                {{ Carbon\Carbon::parse($dokumen_terim->tanggal_arsip)->isoFormat('dddd, D MMMM Y') }}
                                                                            </td>
                                                                        @elseif ($dokumen_terim->klasifikasi_dokumen == 'Produk Hukum Organisasi Banom')
                                                                            <td style="text-align:center;">
                                                                                <span style="font-size:15px;"
                                                                                    class="badge rounded-pill  bg-secondary ">{{ $dokumen_terim->klasifikasi_dokumen }}</span><br>
                                                                                {{ Carbon\Carbon::parse($dokumen_terim->tanggal_arsip)->isoFormat('dddd, D MMMM Y') }}
                                                                            </td>
                                                                        @endif
                                                                        <td style="text-align:center;">
                                                                            @php
                                                                                $jumlah_lampiran = DB::table('lampiran_arsip')
                                                                                    ->where('arsip_digital_id', $dokumen_terim->arsip_digital_id)
                                                                                    ->count();
                                                                            @endphp

                                                                            <span class="badge rounded-pill  bg-secondary"
                                                                                style="font-size:15px;">
                                                                                {{ $jumlah_lampiran }} File
                                                                                Lampiran</span>
                                                                            <br>
                                                                            {{ Str::limit($dokumen_terim->perihal_isi_deskripsi, 40) }}...
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


                                                                                    @if (Auth::user()->gocap_id_pc_pengurus != null)
                                                                                        @if ($part == 'pc_dokumen')
                                                                                            @if ($hal == 'pc')
                                                                                                <a onMouseOver="this.style.color='red'"
                                                                                                    onMouseOut="this.style.color='black'"
                                                                                                    class="dropdown-item"
                                                                                                    href="/{{ $role }}/arsip/detail_dokumen_digital/{{ $dokumen_dikir->arsip_digital_id }}/pc"
                                                                                                    type="button"><i
                                                                                                        class="far fa-eye"></i>
                                                                                                    Detail</a>
                                                                                            @else
                                                                                                <a onMouseOver="this.style.color='red'"
                                                                                                    onMouseOut="this.style.color='black'"
                                                                                                    class="dropdown-item"
                                                                                                    href="/{{ $role }}/arsip/detail_dokumen_digital/{{ $dokumen_dikir->arsip_digital_id }}/upzis"
                                                                                                    type="button"><i
                                                                                                        class="far fa-eye"></i>
                                                                                                    Detail</a>
                                                                                            @endif


                                                                                            <a onMouseOver="this.style.color='red'"
                                                                                                style=""
                                                                                                onMouseOut="this.style.color='black'"
                                                                                                class="dropdown-item "
                                                                                                href="/{{ $role }}/arsip/hapus_dokumen_digital/{{ $dokumen_dikir->arsip_digital_id }}"
                                                                                                type="button"><i
                                                                                                    class="fas fa-trash"></i>
                                                                                                Hapus</a>
                                                                                        @else
                                                                                            @if ($hal == 'pc')
                                                                                                <a onMouseOver="this.style.color='red'"
                                                                                                    onMouseOut="this.style.color='black'"
                                                                                                    class="dropdown-item"
                                                                                                    href="/{{ $role }}/arsip/detail_dokumen_digital/{{ $dokumen_dikir->arsip_digital_id }}/pc"
                                                                                                    type="button"><i
                                                                                                        class="far fa-eye"></i>
                                                                                                    Detail</a>
                                                                                            @else
                                                                                                <a onMouseOver="this.style.color='red'"
                                                                                                    onMouseOut="this.style.color='black'"
                                                                                                    class="dropdown-item"
                                                                                                    href="/{{ $role }}/arsip/detail_dokumen_digital/{{ $dokumen_dikir->arsip_digital_id }}/upzis"
                                                                                                    type="button"><i
                                                                                                        class="far fa-eye"></i>
                                                                                                    Detail</a>
                                                                                            @endif
                                                                                        @endif
                                                                                    @elseif(Auth::user()->gocap_id_upzis_pengurus != null)
                                                                                        @if ($part == 'pc_dokumen')
                                                                                            <a onMouseOver="this.style.color='red'"
                                                                                                onMouseOut="this.style.color='black'"
                                                                                                class="dropdown-item"
                                                                                                href="/{{ $role }}/arsip/detail_dokumen_digital/{{ $dokumen_dikir->arsip_digital_id }}"
                                                                                                type="button"><i
                                                                                                    class="far fa-eye"></i>
                                                                                                Detail</a>
                                                                                        @else
                                                                                            <a onMouseOver="this.style.color='red'"
                                                                                                onMouseOut="this.style.color='black'"
                                                                                                class="dropdown-item"
                                                                                                href="/{{ $role }}/arsip/detail_dokumen_digital/{{ $dokumen_dikir->arsip_digital_id }}"
                                                                                                type="button"><i
                                                                                                    class="far fa-eye"></i>
                                                                                                Detail</a>


                                                                                            <a onMouseOver="this.style.color='red'"
                                                                                                style=""
                                                                                                onMouseOut="this.style.color='black'"
                                                                                                class="dropdown-item "
                                                                                                href="/{{ $role }}/arsip/hapus_dokumen_digital/{{ $dokumen_dikir->arsip_digital_id }}"
                                                                                                type="button"><i
                                                                                                    class="fas fa-trash"></i>
                                                                                                Hapus</a>
                                                                                        @endif
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
                                    <!-- /.card -->

                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->






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
