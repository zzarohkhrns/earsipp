@extends('main')

@section($part, 'active')

@section('dokumen_ac', 'active menu-open')
@section('dokumen_mo', 'menu-open')

@section('css')
@section('content')



    {{-- @php
        dd(Auth::user()->id_pengguna);
    @endphp --}}
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $page }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">{{ $page }}</li>
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

                            <div class="card">

                                <!-- /.card-header -->
                                <div class="card-body">



                                    <!-- Header -->
                                    <!-- /.card-header -->
                                    <div class="card-body">

                                        {{-- alert --}}
                                        @if (session()->has('alert_tambah'))
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <i class="far fa-check-circle"></i> {{ session('alert_tambah') }}
                                            </div>
                                        @endif
                                        @if (session()->has('alert_hapus'))
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <i class="far fa-check-circle"></i> {{ session('alert_hapus') }}
                                            </div>
                                        @endif

                                        {{-- head --}}
                                        <div class="row ">
                                            <div
                                                class="col-5 col-12 col-md-3 col-sm-12 mb-2 mb-xl-0 pr-0 d-highlight pr-0 mr-0 ">
                                                <h5>Data Dokumen Digital</h5>
                                                Menampilkan Data Dokumen Digital {{ $role }}
                                            </div>
                                            <div class="col-12  col-md-9 col-sm-12 mb-2 mb-xl-0">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <form method="post">
                                                            @csrf
                                                            <input type="hidden" name="jenis" value="Dokumen Digital">

                                                            <div class="row">
                                                                {{-- filter kategori --}}
                                                                <div class="col-12 col-md-4 col-sm-12 mb-2 mb-xl-0">
                                                                    <select class="form-control " id="select-kegiatan"
                                                                        name="klasifikasi">


                                                                        @if ($klasifikasi == '')
                                                                            <option value="" selected hidden>Pilih
                                                                                Klasifikasi
                                                                            </option>
                                                                        @else
                                                                            <option value="{{ $klasifikasi }}" selected
                                                                                hidden>
                                                                                {{ $klasifikasi }}
                                                                            </option>
                                                                        @endif


                                                                        <option value="">Semua
                                                                        </option>
                                                                        <option value="Laporan Tahunan">Laporan Tahunan
                                                                        </option>
                                                                        <option value="Produk Hukum Organisasi NU">Produk
                                                                            Hukum Organisasi NU
                                                                        </option>
                                                                        <option value="Produk Hukum Organisasi Banom">Produk
                                                                            Hukum Organisasi
                                                                            Banom
                                                                        </option>
                                                                        <option value="Hasil Bahtsul Masail">Hasil Bahtsul
                                                                            Masail
                                                                        </option>


                                                                    </select>
                                                                </div>

                                                                {{-- filter kondisi --}}
                                                                <div class="col-12 col-md-3 col-sm-12 mb-2 mb-xl-0">
                                                                    <select class="col form-control" name="bulan">

                                                                        @php
                                                                            if ($bulan == '01') {
                                                                                $bulans = 'Januari';
                                                                            } elseif ($bulan == '02') {
                                                                                $bulans = 'Februari';
                                                                            } elseif ($bulan == '03') {
                                                                                $bulans = 'Maret';
                                                                            } elseif ($bulan == '04') {
                                                                                $bulans = 'April';
                                                                            } elseif ($bulan == '05') {
                                                                                $bulans = 'Mei';
                                                                            } elseif ($bulan == '06') {
                                                                                $bulans = 'Juni';
                                                                            } elseif ($bulan == '07') {
                                                                                $bulans = 'Juli';
                                                                            } elseif ($bulan == '08') {
                                                                                $bulans = 'Agustus';
                                                                            } elseif ($bulan == '09') {
                                                                                $bulans = 'September';
                                                                            } elseif ($bulan == '10') {
                                                                                $bulans = 'Oktober';
                                                                            } elseif ($bulan == '11') {
                                                                                $bulans = 'November';
                                                                            } elseif ($bulan == '12') {
                                                                                $bulans = 'Desember';
                                                                            }
                                                                        @endphp

                                                                        @if ($bulan == '')
                                                                            <option value="" selected hidden>Pilih
                                                                                Tahun
                                                                            </option>
                                                                        @else
                                                                            <option value="{{ $bulan }}" selected
                                                                                hidden>
                                                                                {{ $bulans }}
                                                                            </option>
                                                                        @endif


                                                                        <option value="">Semua
                                                                        </option>
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
                                                                {{-- filter tahun --}}
                                                                <div class="col-12 col-md-3 col-sm-12 mb-2 mb-xl-0 ">
                                                                    <select class="custom-select" name="tahun">


                                                                        @if ($tahuns == '')
                                                                            <option value="" selected hidden>Pilih
                                                                                Tahun
                                                                            </option>
                                                                        @else
                                                                            <option value="{{ $tahuns }}" selected
                                                                                hidden>
                                                                                {{ Carbon\Carbon::parse($tahuns)->isoFormat('Y') }}
                                                                            </option>
                                                                        @endif


                                                                        <option value="">Semua
                                                                        </option>

                                                                        @foreach ($tahun as $thn)
                                                                            <option value="{{ $thn->tanggal_arsip }}">
                                                                                {{ Carbon\Carbon::parse($thn->tanggal_arsip)->isoFormat('Y') }}
                                                                            </option>
                                                                        @endforeach


                                                                    </select>
                                                                </div>
                                                                {{-- tombol filter --}}
                                                                <div class="col-12 col-md-2 col-sm-12 mb-2 mb-xl-0">
                                                                    <div class="btn-group btn-block mb-2 mb-xl-0">
                                                                        <button type="submit"
                                                                            class="btn btn-primary btn-block"
                                                                            formaction="/{{ $role }}/filter/dokumen/{{ $part }}"><i
                                                                                class="fas fa-sort"></i> Filter</button>

                                                                    </div>

                                                                </div>




                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>




                                    {{-- tabel --}}
                                    <div class="table-responsive mt-0">

                                        <table id="example1" class="table table-bordered " style="width:100%">
                                            <thead>
                                                <tr style="font-size: 15px;">
                                                    <th>No</th>
                                                    <th>Tanggal Dokumen</th>
                                                    <th>Nama Dokumen </th>
                                                    <th>Klasifikasi Dokumen</th>
                                                    <th>Sumber Dokumen</th>
                                                    <th>Deskripsi Dokumen</th>
                                                    <th>Aksi</th>
                                                </tr>


                                            </thead>
                                            <tbody>

                                                @foreach ($dokumen as $data)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ Carbon\Carbon::parse($data->tanggal_arsip)->isoFormat('dddd, D MMMM Y') }}
                                                        </td>
                                                        <td>{{ $data->nama_dokumen }}</td>
                                                        {{-- <td>Keterangan Data Aset</td> --}}
                                                        @if ($data->klasifikasi_dokumen == 'Produk Hukum Organisasi NU')
                                                            <td style="font-size:18px;text-align:center;"><span
                                                                    class="badge rounded-pill  bg-primary">{{ $data->klasifikasi_dokumen }}</span>
                                                            </td>
                                                        @elseif ($data->klasifikasi_dokumen == 'Hasil Bahtsul Masail')
                                                            <td style="font-size:18px;text-align:center;"><span
                                                                    class="badge rounded-pill  bg-warning">{{ $data->klasifikasi_dokumen }}</span>
                                                            </td>
                                                        @elseif ($data->klasifikasi_dokumen == 'Laporan Tahunan')
                                                            <td style="font-size:18px;text-align:center;"><span
                                                                    class="badge rounded-pill  bg-success ">{{ $data->klasifikasi_dokumen }}</span>
                                                            </td>
                                                        @elseif ($data->klasifikasi_dokumen == 'Produk Hukum Organisasi Banom')
                                                            <td style="font-size:18px;text-align:center;"><span
                                                                    class="badge rounded-pill  bg-secondary ">{{ $data->klasifikasi_dokumen }}</span>
                                                            </td>
                                                        @endif

                                                        <td>{{ $data->pengirim_sumber }}</td>
                                                        <td>{{ $data->perihal_isi_deskripsi }}</td>


                                                        <td>

                                                            <!-- Example split danger button -->
                                                            <div class="btn-group dropdown">

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
                                                                        href="/{{ $role }}/arsip/detail_dokumen_digital/{{ $data->arsip_digital_id }}"
                                                                        type="button"><i class="far fa-eye"></i>
                                                                        Detail</a>

                                                                    <a onMouseOver="this.style.color='red'" style=""
                                                                        onMouseOut="this.style.color='black'"
                                                                        class="dropdown-item "
                                                                        href="/{{ $role }}/arsip/hapus_dokumen_digital/{{ $data->arsip_digital_id }}"
                                                                        type="button"><i class="fas fa-trash"></i>
                                                                        Hapus</a>


                                                                </div>
                                                            </div>


                                                        </td>
                                                    </tr>
                                                @endforeach



                                            </tbody>


                                        </table>

                                    </div>


                                    <!-- /.card-body -->
                                </div>
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
                                                                    placeholder="Masukan no hp"
                                                                    wire:model.defer="nohp_edit"
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
                                            <div wire:ignore.self class="tab-pane fade" id="mustahik_edit"
                                                role="tabpanel" aria-labelledby="profile-tab">

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
                                        <button type="button" class="btn btn-secondary close-btn"
                                            data-dismiss="modal"><i class="fas fa-ban"></i> Batal</button>
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




@endsection
