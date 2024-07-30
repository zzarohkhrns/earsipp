@extends('main')

@section('berita', 'active')

@section('css')
@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb m-0 pl-4">
                        <li class="breadcrumb-item active">
                            <a href="/{{ $role }}/dashboard">Dashboard</a> / {{ $page }}
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

    @if (Auth::user()->PcPengurus->PengurusJabatan->jabatan == 'Divisi IT dan Media')
        @php
            $co = 'col-md-1';
        @endphp
    @else
        @php
            // $co = 'col-md-3';
            $co = 'col-md-1';
        @endphp
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

                                <!-- Header -->
                                <!-- /.card-header -->
                                <div class="card-body">



                                    {{-- head --}}
                                    <div class="row card-berita">
                                        <div class="col-12">
                                            <h5 class="d-flex ">
                                                <b class="text-success pl-2">BERITA UMUM</b>
                                            </h5>

                                        </div>
                                        <div class="col-12  col-md-12 col-sm-12 mb-2 mb-xl-0 mt-2">
                                            <div class="card">
                                                <div class="card-body">
                                                    <form method="post" action="/{{ $role }}/filter/berita">
                                                        @csrf


                                                        <div class="row card-filter-berita">
                                                            {{-- filter kategori --}}
                                                            <div class="col-12 col-md-4 col-sm-12 mb-2 mb-xl-0">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">Kategori</div>
                                                                    </div>
                                                                    <select class="form-control " name="kategori"
                                                                        onchange="javascript:this.form.submit();">

                                                                        @if ($kategoris == '')
                                                                            <option value="" selected hidden>
                                                                                Pilih Kategori
                                                                            </option>
                                                                        @else
                                                                            <option value="{{ $kategoris }}" selected
                                                                                hidden>
                                                                                {{ $kategoris }}
                                                                            </option>
                                                                        @endif
                                                                        <option value="">Semua</option>
                                                                        @foreach ($kategori_berita as $kategori)
                                                                            <option value="{{ $kategori->nama_kategori }}">
                                                                                {{ $kategori->nama_kategori }}</option>
                                                                        @endforeach

                                                                    </select>
                                                                </div>


                                                            </div>
                                                            {{-- filter kondisi --}}
                                                            <div class="col-12 col-md-4 col-sm-12 mb-2 mb-xl-0">
                                                                <div class="input-group">
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
                                                            <div class="col-12 col-md-4 col-sm-12 mb-2 mb-xl-0 ">

                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text">Tahun</div>
                                                                    </div>
                                                                    <select class="form-control " name="tahun"
                                                                        onchange="javascript:this.form.submit();">

                                                                        @if ($tahuns == '')
                                                                            <option value="" selected hidden>Pilih
                                                                                Tahun
                                                                            </option>
                                                                        @else
                                                                            <option value="{{ $tahuns }}" selected
                                                                                hidden>
                                                                                {{ $tahuns }}
                                                                            </option>
                                                                        @endif
                                                                        <option value="">Semua</option>


                                                                        @foreach ($tahun_berita as $tahun_m)
                                                                            <option value="{{ $tahun_m->year }}">
                                                                                {{ $tahun_m->year }}
                                                                            </option>
                                                                        @endforeach


                                                                    </select>
                                                                </div>


                                                            </div>

                                                            {{-- tombol filter --}}
                                                            {{-- <div class="col-12 {{ $co }} col-sm-12 mb-2 mb-xl-0">
                                                                <div class="btn-group btn-block mb-2 mb-xl-0">
                                                                    <button type="submit"
                                                                        onclick="$('#cover-spin').show(0)"
                                                                        class="btn btn-primary btn-block"
                                                                        formaction="/{{ $role }}/filter/berita"><i
                                                                            class="fas fa-sort"></i>
                                                                        Filter</button>
                                                                </div>
                                                            </div> --}}


                                                    </form>
                                                </div>


                                                <div class="form-row mt-2">

                                                    {{-- info --}}
                                                    <div class="col-12 col-md-10 col-sm-12 mb-2 mb-xl-0">
                                                        <div class="d-flex flex-row bd-highlight align-items-center">
                                                            <div class="p-2 bd-highlight">
                                                                <i class="fas fa-info-circle"></i>
                                                            </div>
                                                            <div class="p-1 bd-highlight">
                                                                <span>Dikelola Oleh:
                                                                    <span class="text-bold">Divisi IT & Media
                                                                    </span>

                                                                </span>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- tombol tambah --}}
                                                    @if (Auth::user()->PcPengurus->PengurusJabatan->jabatan == 'Divisi IT dan Media')
                                                        <div
                                                            class="btn-group col-12 col-md-2 col-sm-12 mb-2 mb-xl-0 card-tambah-berita">
                                                            <button type="button" class="btn btn-success"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false"><i class="fas fa-plus-circle"></i>
                                                                Tambah</button>

                                                            <div
                                                                class="dropdown-menu col-12 col-md-12 col-sm-12 mb-2 mb-xl-0">

                                                                @if (DB::table('kategori_berita')->exists())
                                                                    <a onclick="$('#cover-spin').show(0)"
                                                                        onMouseOver="this.style.color='red'"
                                                                        onMouseOut="this.style.color='black'"
                                                                        class="dropdown-item"
                                                                        href="/{{ $role }}/arsip/tambah_berita"
                                                                        type="button"><i class="fas fa-plus-circle"></i>
                                                                        Tambah Berita</a>
                                                                @endif
                                                                <a onclick="$('#cover-spin').show(0)"
                                                                    onMouseOver="this.style.color='red'" style=""
                                                                    onMouseOut="this.style.color='black'"
                                                                    class="dropdown-item "
                                                                    href="/{{ $role }}/arsip/kategori_berita"
                                                                    type="button"><i class="fas fa-plus-circle"></i>
                                                                    Tambah Kategori</a>


                                                            </div>
                                                        </div>
                                                    @else
                                                    @endif
                                                </div>


                                            </div>

                                        </div>
                                    </div>

                                </div>




                                {{-- tabel --}}
                                <div class="table-responsive mt-0 card-table-berita">

                                    <table id="example1" class="table table-bordered " style="width:100%">
                                        <thead>
                                            <tr style="font-size: 15px;">
                                                <th>No</th>
                                                <th>Berita Dibuat</th>
                                                <th>Kategori Berita </th>
                                                <th>Tag Berita</th>
                                                <th style="width: 300px;">Isi Berita</th>
                                                <th>Aksi</th>
                                            </tr>


                                        </thead>
                                        <tbody>
                                            @foreach ($berita as $data_berita)
                                                @php
                                                    $users = DB::connection('siftnu')
                                                        ->table('pengguna')
                                                        ->where('id_pengguna', $data_berita->id_pengguna)
                                                        ->first();
                                                    
                                                    if (Auth::user()->gocap_id_pc_pengurus != null) {
                                                        $a = DB::connection('gocap')
                                                            ->table('pc_pengurus')
                                                            ->where('id_pc_pengurus', $users->gocap_id_pc_pengurus)
                                                            ->first();
                                                    } else {
                                                        $a = DB::connection('gocap')
                                                            ->table('upzis_pengurus')
                                                            ->where('id_upzis_pengurus', $users->gocap_id_upzis_pengurus)
                                                            ->first();
                                                    }
                                                    
                                                    if ($a != null) {
                                                        $jabatan = DB::connection('gocap')
                                                            ->table('pengurus_jabatan')
                                                            ->where('id_pengurus_jabatan', $a->id_pengurus_jabatan)
                                                            ->first();
                                                    }
                                                @endphp
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td><b
                                                            style="font-size: 16px;">{{ \Carbon\Carbon::parse($data_berita->tanggal_terbit)->isoFormat('dddd, D MMMM Y') }}</b>
                                                        <br>
                                                        {{ $users->nama }} @if ($a != null)
                                                            {{ '(' . $jabatan->jabatan . ')' }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $data_berita->kategori_berita }}</td>
                                                    <td>
                                                        @php
                                                            $arr = explode(',', $data_berita->hastag_berita);
                                                            $hitung = count($arr);
                                                            for ($x = 0; $x < $hitung; $x++) {
                                                                echo '<span style="font-size:13px;" class="badge badge-success rounded-pill">' . '#' . $arr[$x] . '</span>' . '&nbsp;';
                                                            }
                                                            
                                                        @endphp

                                                    </td>
                                                    <td style="width: 300px;"><b style="font-size: 16px;">
                                                            {{ $data_berita->judul_berita }}</b>
                                                        <br>


                                                        {{-- <p style="  font-weight:normal">
                                                                {!! Str::limit($data_berita->narasi_berita, 60) !!}</p> --}}
                                                        @php
                                                            // $b = Str::limit($data_berita->narasi_berita, 60);
                                                            echo strip_tags(Str::limit($data_berita->narasi_berita, 100));
                                                        @endphp

                                                    </td>



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

                                                                <a onMouseOver="this.style.color='red'"
                                                                    onMouseOut="this.style.color='black'"
                                                                    class="dropdown-item"
                                                                    onclick="$('#cover-spin').show(0)"
                                                                    href="/{{ $role }}/arsip/detail_berita/{{ $data_berita->id_berita_umum }}"
                                                                    type="button"><i class="far fa-eye"></i>
                                                                    Detail</a>

                                                                @if (Auth::user()->PcPengurus->PengurusJabatan->jabatan == 'Divisi IT dan Media')
                                                                    <a onMouseOver="this.style.color='red'" style=""
                                                                        onMouseOut="this.style.color='black'"
                                                                        class="dropdown-item" type="button"
                                                                        data-target="#modal_hapus{{ $data_berita->id_berita_umum }}"
                                                                        data-toggle="modal"><i class="fas fa-trash"></i>
                                                                        Hapus</a>
                                                                @else
                                                                @endif




                                                            </div>
                                                        </div>


                                                    </td>

                                                    {{-- modal hapus --}}
                                                    <div class="modal fade"
                                                        id="modal_hapus{{ $data_berita->id_berita_umum }}" role="dialog"
                                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <form
                                                                    action="/{{ $role }}/aksi_hapus_berita/{{ $data_berita->id_berita_umum }}"
                                                                    method="post">
                                                                    @csrf
                                                                    <div class="modal-header">

                                                                        <h5 class="modal-title" id="exampleModalLabel">
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

                                                </tr>
                                            @endforeach


                                        </tbody>


                                    </table>
                                </div>

                            </div>


                            <!-- /.card-body -->

                            <!-- /.card -->

                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->


                    {{-- modal tambah penerima manfaat perorangan --}}
                    <div wire:ignore.self class="modal fade" id="modal_edit" data-backdrop="static" tabindex="-1"
                        data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Detail Penerima Manfaat</h5>
                                    <div class="col-auto float-right">
                                        {{-- @if (session()->has('message_update'))
                                            <span class="badge badge-success">{{ session('message_update') }}</span>
                        @endif --}}
                                    </div>

                                </div>

                                <ul class="nav nav-tabs mt-1" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a wire:ignore.self class="nav-link active" id="home-tab" data-toggle="tab"
                                            href="#detail_diri_edit" role="tab" aria-controls="home"
                                            aria-selected="true">Detail
                                            Diri</a>
                                    </li>
                                    <li class="nav-item">
                                        <a wire:ignore.self class="nav-link" id="profile-tab" data-toggle="tab"
                                            href="#mustahik_edit" role="tab" aria-controls="profile"
                                            aria-selected="false">Mustahik</a>
                                    </li>
                                </ul>

                                {{-- form edit --}}
                                <form wire:submit.prevent="edit">

                                    <div class="tab-content" id="myTabContent">
                                        {{-- header tabbed detail diri --}}
                                        <div wire:ignore.self class="tab-pane fade show active" id="detail_diri_edit"
                                            role="tabpanel" aria-labelledby="home-tab">

                                            {{-- form detail diri --}}
                                            <div class="modal-body mt-2">
                                                <div id="form-baru">

                                                    <div class="form-row">
                                                        {{-- nama --}}
                                                        <div class="form-group col-md-6">
                                                            <label for="inputNama">NAMA &nbsp;</label>
                                                            <sup class="badge badge-danger text-white mb-2"
                                                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                            <input type="text" id="inptNama"
                                                                wire:model.defer="nama_edit"
                                                                class="form-control @error('nama_edit') is-invalid @enderror"
                                                                placeholder="Masukan nama"
                                                                onkeydown="return /[a-z]/i.test(event.key   )">
                                                            @error('nama_edit')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        {{-- nik --}}
                                                        <div class="form-group col-md-6">
                                                            <label for="inputNik">NIK &nbsp;</label>
                                                            <sup class="badge badge-danger text-white mb-2"
                                                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                            <input type="text" wire:model.defer="nik_edit"
                                                                class="form-control @error('nik_edit') is-invalid @enderror"
                                                                id="inptNik" placeholder="Masukan NIK"
                                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                                            @error('nik_edit')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="form-row">
                                                        {{-- tempat lahir --}}
                                                        <div class="form-group col-md-6">
                                                            <label for="inputTempat">TEMPAT LAHIR &nbsp;</label>
                                                            <sup class="badge badge-danger text-white mb-2"
                                                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                            <input type="text"
                                                                class="form-control @error('tempat_lahir_edit') is-invalid @enderror"
                                                                wire:model.defer="tempat_lahir_edit"
                                                                placeholder="Masukan tempat lahir"
                                                                onkeydown="return /[a-z]/i.test(event.key)">
                                                            @error('tempat_lahir_edit')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        {{-- tanggal lahir --}}
                                                        <div class="form-group col-md-6">
                                                            <label for="inputTanggal">TANGGAL LAHIR &nbsp;</label>
                                                            <sup class="badge badge-danger text-white mb-2"
                                                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                            <input type="date"
                                                                class="form-control @error('tanggal_lahir_edit') is-invalid @enderror"
                                                                wire:model.defer="tanggal_lahir_edit">
                                                            @error('tanggal_lahir_edit')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="form-row">
                                                        {{-- alamat --}}
                                                        <div class="form-group col-md-6">
                                                            <label for="inputAlamat">ALAMAT &nbsp;</label>
                                                            <sup class="badge badge-danger text-white mb-2"
                                                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                            <input type="text"
                                                                class="form-control @error('alamat_edit') is-invalid @enderror"
                                                                wire:model.defer="alamat_edit"
                                                                placeholder="Masukan alamat">
                                                            @error('alamat_edit')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        {{-- nohp --}}
                                                        <div class="form-group col-md-6">
                                                            <label for="inputHP">NO HP &nbsp;</label>
                                                            <sup class="badge badge-danger text-white mb-2"
                                                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                            <input type="text"
                                                                class="form-control @error('nohp_edit') is-invalid @enderror"
                                                                placeholder="Masukan no hp" wire:model.defer="nohp_edit"
                                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                                        </div>
                                                        @error('nohp_edit')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>

                                                    <div class="form-row">
                                                        {{-- jenis kelamin --}}
                                                        <div class="form-group col-md-6">
                                                            <label for="inputJK">JENIS KELAMIN &nbsp;</label>
                                                            <sup class="badge badge-danger text-white mb-2"
                                                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                            <select
                                                                class="form-control @error('jenis_kelamin_edit') is-invalid @enderror"
                                                                wire:model.defer="jenis_kelamin_edit">
                                                                <option>Pilih jenis kelamin</option>
                                                                <option value="laki-laki">Laki-laki</option>
                                                                <option value="perempuan">Perempuan</option>
                                                            </select>
                                                            @error('jenis_kelamin_edit')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        {{-- rt --}}
                                                        <div class="form-group col-md-3">
                                                            <label for="inputRT">RT &nbsp;</label>
                                                            <sup class="badge badge-danger text-white mb-2"
                                                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                            <input type="text"
                                                                class="form-control @error('rt_edit') is-invalid @enderror"
                                                                placeholder="Contoh : 001" wire:model.defer="rt_edit"
                                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                                            @error('rt_edit')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            {{-- rw --}}
                                                            <label for="inputRW">RW &nbsp;</label>
                                                            <sup class="badge badge-danger text-white mb-2"
                                                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                            <input type="text"
                                                                class="form-control @error('rw_edit') is-invalid @enderror"
                                                                placeholder="Contoh : 001" wire:model.defer="rw_edit"
                                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                                            @error('rw_edit')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                        {{-- header tabbed mustahik --}}
                                        <div wire:ignore.self class="tab-pane fade" id="mustahik_edit" role="tabpanel"
                                            aria-labelledby="profile-tab">

                                            {{-- form mustahik --}}
                                            <div class="modal-body mt-2">
                                                <div id="form-baru">

                                                    <div class="form-row">
                                                        {{-- jenis penerima --}}
                                                        <div class="form-group col-md-6">
                                                            <label for="inputNama">PILIH JENIS PENERIMA &nbsp;</label>
                                                            <sup class="badge badge-danger text-white mb-2"
                                                                style="background-color:rgba(230,82,82)">WAJIB</sup>


                                                            <select
                                                                class="form-control @error('jenis_edit') is-invalid @enderror"
                                                                wire:model="jenis_edit">

                                                                <option value="Entitas">Entitas</option>
                                                                <option value="Perorangan">Perorangan</option>
                                                            </select>

                                                            @error('jenis_edit')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror

                                                        </div>


                                                        {{-- kategori penerima --}}
                                                        <div class="form-group col-md-6">
                                                            <label for="inputNama">PILIH KATEGORI PENERIMA
                                                                &nbsp;</label>
                                                            <sup class="badge badge-danger text-white mb-2"
                                                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                            <select
                                                                class="form-control @error('id_kategori_penerima_manfaat_edit') is-invalid @enderror"
                                                                wire:model.defer="id_kategori_penerima_manfaat_edit">


                                                            </select>
                                                            @error('id_kategori_penerima_manfaat_edit')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>

                                                    </div>



                                                    <div class="form-row">
                                                        {{-- nomor registrasi --}}
                                                        <div class="form-group col-md-6">
                                                            <label for="inputTempat">NOMOR REGISTRASI &nbsp;</label>
                                                            <sup class="badge badge-danger text-white mb-2"
                                                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                            <input type="text"
                                                                class="form-control @error('nomor_registrasi_entitas_edit') is-invalid @enderror"
                                                                wire:model.defer="nomor_registrasi_entitas_edit"
                                                                placeholder="Masukan nomor registrasi">
                                                            @error('nomor_registrasi_entitas_edit')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        {{-- nomor perijinan --}}
                                                        <div class="form-group col-md-6">
                                                            <label for="inputTanggal">NOMOR PERIJINAN &nbsp;</label>
                                                            <sup class="badge badge-danger text-white mb-2"
                                                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                            <input type="text"
                                                                class="form-control @error('nomor_perijinan_entitas_edit') is-invalid @enderror"
                                                                wire:model.defer="nomor_perijinan_entitas_edit"
                                                                placeholder="Masukan nama lembaga">
                                                            @error('nomor_perijinan_entitas_edit')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="form-row">
                                                        {{-- nama lembaga --}}
                                                        <div class="form-group col-md-6">
                                                            <label for="inputAlamat">NAMA LEMBAGA &nbsp;</label>
                                                            <sup class="badge badge-danger text-white mb-2"
                                                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                            <input type="text"
                                                                class="form-control @error('nama_lembaga_entitas_edit') is-invalid @enderror"
                                                                wire:model.defer="nama_lembaga_entitas_edit"
                                                                placeholder="Masukan nama lembaga">
                                                            @error('nama_lembaga_entitas_edit')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        {{-- nama pimpinan --}}
                                                        <div class="form-group col-md-6">
                                                            <label for="inputHP">NAMA PIMPINAN&nbsp;</label>
                                                            <sup class="badge badge-danger text-white mb-2"
                                                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                            <input type="text"
                                                                class="form-control @error('nama_pimpinan_entitas_edit') is-invalid @enderror"
                                                                placeholder="Masukan nama pimpinan"
                                                                wire:model.defer="nama_pimpinan_entitas_edit"
                                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                                            @error('nama_pimpinan_entitas_edit')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>


                                                        {{-- alamat --}}
                                                        <div class="form-group col-md-12">
                                                            <label for="inputAlamat">ALAMAT &nbsp;</label>
                                                            <sup class="badge badge-danger text-white mb-2"
                                                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                            <textarea type="text" class="form-control @error('alamat_lembaga_entitas_edit') is-invalid @enderror"
                                                                wire:model.defer="alamat_lembaga_entitas_edit" placeholder="Masukan alamat" rows="4"> </textarea>
                                                            @error('alamat_lembaga_entitas_edit')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    {{-- @endif --}}




                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    {{-- tombol footer --}}
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                                class="fas fa-ban"></i>
                                            Batal</button>
                                        <button type="submit" name="submit" class="btn btn-success"><i
                                                class="fas fa-save"></i>
                                            Simpan Perubahan</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>


                    {{-- modal hapus --}}
                    <div wire:ignore.self class="modal fade" id="modal_delete" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"><b>Konfirmasi Hapus</b></h5>

                                </div>
                                <div class="modal-body">
                                    <p>Yakin ingin menghapus data?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal"><i
                                            class="fas fa-ban"></i> Batal</button>
                                    <button type="button" wire:click.prevent="delete()"
                                        class="btn btn-danger close-modal" data-dismiss="modal"><i
                                            class="fas fa-trash"></i> Iya, Hapus</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <script>
                        window.addEventListener('closeModal', event => {
                            $('#tambah').modal('hide')
                        });
                    </script>
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

    @push('intro_berita')
        @if (Auth::user()->PcPengurus->PengurusJabatan->jabatan == 'Divisi IT dan Media')
            <script>
                function klikkene(value) {
                    introJs().setOptions({
                            steps: [{
                                    element: document.querySelector('.card-berita'),
                                    title: 'Berita Umum',
                                    intro: 'Berita Umum dapat dibuat oleh Divisi IT & Media'
                                },
                                {
                                    element: document.querySelector('.card-filter-berita'),
                                    title: 'Filter Berita',
                                    intro: 'Untuk Menampilkan arsip berita umum secara spesifik, gunakan filter data'
                                },
                                {
                                    element: document.querySelector('.card-tambah-berita'),
                                    title: 'Tambah Berita',
                                    intro: 'Klik disini untuk membuat Berita Umum baru'
                                },

                                {
                                    element: document.querySelector('.card-table-berita'),
                                    title: 'Data Berita Umum',
                                    intro: 'Arsip Berita Umum akan tampil pada tabel & Tersinkronasi dengan Aplikasi GOCAP'
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
                                    element: document.querySelector('.card-berita'),
                                    title: 'Berita Umum',
                                    intro: 'Berita Umum dapat dibuat oleh Divisi IT & Media'
                                },
                                {
                                    element: document.querySelector('.card-filter-berita'),
                                    title: 'Filter Berita',
                                    intro: 'Untuk Menampilkan arsip berita umum secara spesifik, gunakan filter data'
                                },
                                {
                                    element: document.querySelector('.card-table-berita'),
                                    title: 'Data Berita Umum',
                                    intro: 'Arsip Berita Umum akan tampil pada tabel & Tersinkronasi dengan Aplikasi GOCAP'
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
