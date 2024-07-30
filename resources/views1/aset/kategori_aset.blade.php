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
                            <a href="/{{ $role }}/dashboard">Dashboard</a> / <a>{{ $page }}</a>
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

    <!-- Modal -->
    <div class="modal fade bd-example" id="tambahkategori" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <b>Tambah Kategori Aset</b>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('/' . $role . '/aksi_tambah_kategori_aset/') }}" method="post">
                    @csrf

                    <div class="modal-body">
                        <div class="card-body">


                            <div class="form-group">

                                <label style="float: left;">Nama Kategori Aset</label>&nbsp;
                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                <input type="text" class="form-control" placeholder="" name="nama_kategori"
                                    id="nama_kategori">
                            </div>

                        </div>
                        <!-- /.card-body -->

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i>
                            Batal</button>
                        <button type="submit" id='button' class="btn btn-success" onclick="$('#cover-spin').show(0)"
                            disabled><i class="fas fa-save"></i>
                            Simpan </button>

                        <script>
                            let inputElt = document.getElementById('nama_kategori');
                            let btn = document.getElementById('button');

                            inputElt.addEventListener("input", function() {
                                btn.disabled = (this.value === '');
                            })
                        </script>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End Modal -->


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

                                <!-- /.card-header -->
                                <div class="card-body">



                                    <!-- Header -->
                                    <div class="row">

                                        <div class="col-6 ">
                                            <h5>Data Kategori Aset</h5>
                                            Menampilkan Data Kategori Aset
                                        </div>
                                        <div class="col-2"></div>
                                        <div class="col-2"></div>


                                        <div class="col-2 col-sm-2 mb-0">
                                            <div class="small-box bg-white">
                                                <div class="inner p-2  text-right">

                                                    <button type="button" class="btn btn-success btn-block"
                                                        data-toggle="modal" data-target="#tambahkategori">
                                                        <i class="fas fa-plus"></i>
                                                        Tambah</a>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>





                                    {{-- tabel --}}
                                    <div class="table-responsive mt-0">

                                        <table id="example1" class="table table-bordered " style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Kategori</th>
                                                    <th>Tanggal dibuat</th>
                                                    <th>Aksi</th>
                                                </tr>


                                            </thead>
                                            <tbody>
                                                @foreach ($kategori_aset as $kategori)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $kategori->nama_kategori }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($kategori->created_at)->isoFormat('dddd, D MMMM Y') }}
                                                        </td>
                                                        <td>
                                                            <div class="btn-group   ">

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


                                                                    <button type="button"
                                                                        onMouseOver="this.style.color='red'"
                                                                        onMouseOut="this.style.color='black'"
                                                                        class="dropdown-item" data-toggle="modal"
                                                                        data-target="#exampleModals{{ $kategori->kategori_aset_id }}">
                                                                        <i class="fas fa-edit"></i>
                                                                        Ubah</a>
                                                                    </button>

                                                                    <a onMouseOver="this.style.color='red'" style=""
                                                                        onMouseOut="this.style.color='black'"
                                                                        class="dropdown-item" type="button"
                                                                        data-target="#modal_hapus{{ $kategori->kategori_aset_id }}"
                                                                        data-toggle="modal"><i class="fas fa-trash"></i>
                                                                        Hapus</a>

                                                                </div>
                                                            </div>
                                                        </td>

                                                        {{-- modal hapus --}}
                                                        <div class="modal fade"
                                                            id="modal_hapus{{ $kategori->kategori_aset_id }}"
                                                            role="dialog" aria-labelledby="exampleModalLabel"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <form
                                                                        action="/{{ $role }}/aksi_hapus_kategori_aset/{{ $kategori->kategori_aset_id }}"
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

                                                    </tr>
                                                    <!-- Modal -->
                                                    <div class="modal fade bd-example"
                                                        id="exampleModals{{ $kategori->kategori_aset_id }}"
                                                        tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog " role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                                        <b>Edit Kategori Aset</b>
                                                                    </h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form
                                                                    action="/{{ $role }}/aksi_edit_kategori_aset/{{ $kategori->kategori_aset_id }}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="modal-body">
                                                                        <div class="card-body">


                                                                            <div class="form-group">
                                                                                <label>Nama Kategori Aset</label>
                                                                                &nbsp;
                                                                                <sup class="badge badge-danger text-white mb-2"
                                                                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                                                <input type="text" class="form-control"
                                                                                    placeholder="" name="nama_kategori"
                                                                                    id="nama_kategori"
                                                                                    value="{{ $kategori->nama_kategori }}">
                                                                            </div>

                                                                        </div>
                                                                        <!-- /.card-body -->

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal"><i
                                                                                class="fas fa-ban"></i>
                                                                            Batal</button>
                                                                        <button type="submit" name="submit"
                                                                            onclick="$('#cover-spin').show(0)"
                                                                            class="btn btn-success"><i
                                                                                class="fas fa-save"></i>
                                                                            Simpan</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--End Modal -->
                                                @endforeach



                                            </tbody>


                                        </table>
                                    </div>

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
                                                            <label for="inputNama">PILIH KATEGORI PENERIMA &nbsp;</label>
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
                                            Simpan</button>
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




@endsection
