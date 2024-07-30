<div>
    {{-- Stop trying to control. --}}
    {{-- modal tambah penerima manfaat perorangan --}}
    <div wire:ignore.self class="modal fade" id="tambah" data-backdrop="static" tabindex="-1" data-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Data Penerima Manfaat</h5>
                    <div class="col-auto float-right">

                        <span class="badge badge-success">Lazisnu</span>

                    </div>
                </div>

                <ul class="nav nav-tabs mt-1" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a wire:ignore.self class="nav-link active" id="home-tab" data-toggle="tab" href="#home"
                            role="tab" aria-controls="home" aria-selected="true">Detail Diri</a>
                    </li>
                    <li class="nav-item">
                        <a wire:ignore.self class="nav-link" id="profile-tab" data-toggle="tab" href="#profile"
                            role="tab" aria-controls="profile" aria-selected="false">Mustahik</a>
                    </li>
                </ul>

                <form wire:submit.prevent="create">
                    <div class="tab-content" id="myTabContent">
                        <div wire:ignore.self class="tab-pane fade show active" id="home" role="tabpanel"
                            aria-labelledby="home-tab">


                            <div class="modal-body mt-2">
                                <div id="form-baru">

                                    <div class="form-row">
                                        {{-- nama --}}
                                        <div class="form-group col-md-6">
                                            <label for="inputNama">NAMA &nbsp;</label>
                                            <sup class="badge badge-danger text-white mb-2"
                                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                                            <input type="text" wire:model.defer="nama"
                                                class="form-control @error('nama') is-invalid @enderror"
                                                placeholder="Masukan nama" onkeydown="return /[a-z ]/i.test(event.key)">
                                            @error('nama')
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
                                            <input type="text" wire:model.defer="nik"
                                                class="form-control @error('nik') is-invalid @enderror"
                                                placeholder="Masukan NIK"
                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                            @error('nik')
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
                                                class="form-control @error('tempat_lahir') is-invalid @enderror"
                                                wire:model.defer="tempat_lahir" placeholder="Masukan tempat lahir"
                                                onkeydown="return /[a-z]/i.test(event.key)">
                                            @error('tempat_lahir')
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
                                                class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                                wire:model.defer="tanggal_lahir">
                                            @error('tanggal_lahir')
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
                                                class="form-control @error('alamat') is-invalid @enderror"
                                                wire:model.defer="alamat" placeholder="Masukan alamat">
                                            @error('alamat')
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
                                                class="form-control @error('nohp') is-invalid @enderror"
                                                placeholder="Masukan no hp" wire:model.defer="nohp"
                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                        </div>
                                        @error('nohp')
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
                                            <select class="form-control @error('jenis_kelamin') is-invalid @enderror"
                                                wire:model.defer="jenis_kelamin">
                                                <option>Pilih jenis kelamin</option>
                                                <option value="laki-laki">Laki-laki</option>
                                                <option value="perempuan">Perempuan</option>
                                            </select>
                                            @error('jenis_kelamin')
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
                                                class="form-control @error('rt') is-invalid @enderror"
                                                placeholder="Contoh : 001" wire:model.defer="rt"
                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                            @error('rt')
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
                                                class="form-control @error('rw') is-invalid @enderror"
                                                placeholder="Contoh : 001" wire:model.defer="rw"
                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                            @error('rw')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>



                                    {{-- foto
                             <div class="form-group col-md-6 mb-0">
                                 <label for="foto" class="form-label">FOTO<label>
                             </div>
                             <div class="input-group mb-3">
                                 <input type="file" wire:model.defer="foto"
                                     class="form-control @error('foto') is-invalid @enderror"
                                     accept="image/png, image/gif, image/jpeg" id="foto">
                                 @error('foto')
                                     <div class="invalid-feedback">
                                         {{ $message }}
                                     </div>
                                 @enderror
                                 <div class="input-group-append">
                                     <label for="inputGroupFile" class="input-group-text">Upload</label>
                                 </div>
                             </div> --}}


                                </div>
                            </div>

                        </div>
                        <div wire:ignore.self class="tab-pane fade" id="profile" role="tabpanel"
                            aria-labelledby="profile-tab">


                            <div class="modal-body mt-2">
                                <div id="form-baru">

                                    <div class="form-row">
                                        {{-- jenis penerima --}}
                                        <div class="form-group col-md-6">
                                            <label for="inputNama">PILIH JENIS PENERIMA &nbsp;</label>
                                            <sup class="badge badge-danger text-white mb-2"
                                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                                            <select class="form-control @error('jenis') is-invalid @enderror"
                                                wire:model="jenis">
                                                <option value="">Pilih jenis penerima</option>
                                                <option value="Entitas">Entitas</option>
                                                <option value="Perorangan">Perorangan</option>
                                            </select>
                                            @error('jenis')
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
                                                class="form-control @error('id_kategori_penerima_manfaat') is-invalid @enderror"
                                                wire:model.defer="id_kategori_penerima_manfaat">
                                                <option value="">Pilih jenis penerima</option>
                                                @foreach ($kategori as $kategori)
                                                    <option value="{{ $kategori->id_kategori_penerima_manfaat }}">
                                                        {{ $kategori->kategori }}</option>
                                                @endforeach
                                            </select>
                                            @error('id_kategori_penerima_manfaat')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                    </div>


                                    @if ($jenis == 'Entitas')
                                        <div class="form-row">
                                            {{-- nomor registrasi --}}
                                            <div class="form-group col-md-6">
                                                <label for="inputTempat">NOMOR REGISTRASI &nbsp;</label>
                                                <sup class="badge badge-danger text-white mb-2"
                                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                <input type="text"
                                                    class="form-control @error('nomor_registrasi_entitas') is-invalid @enderror"
                                                    wire:model.defer="nomor_registrasi_entitas"
                                                    placeholder="Masukan nomor registrasi">
                                                @error('nomor_registrasi_entitas')
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
                                                    class="form-control @error('nomor_perijinan_entitas') is-invalid @enderror"
                                                    wire:model.defer="nomor_perijinan_entitas"
                                                    placeholder="Masukan nama lembaga">
                                                @error('nomor_perijinan_entitas')
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
                                                    class="form-control @error('nama_lembaga_entitas') is-invalid @enderror"
                                                    wire:model.defer="nama_lembaga_entitas"
                                                    placeholder="Masukan nama lembaga">
                                                @error('nama_lembaga_entitas')
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
                                                    class="form-control @error('nama_pimpinan_entitas') is-invalid @enderror"
                                                    placeholder="Masukan nama pimpinan"
                                                    wire:model.defer="nama_pimpinan_entitas"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                                @error('nama_pimpinan_entitas')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>


                                            {{-- alamat --}}
                                            <div class="form-group col-md-12">
                                                <label for="inputAlamat">ALAMAT LEMBAGA&nbsp;</label>
                                                <sup class="badge badge-danger text-white mb-2"
                                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                <textarea type="text" class="form-control @error('alamat_lembaga_entitas') is-invalid @enderror"
                                                    wire:model.defer="alamat_lembaga_entitas" placeholder="Masukan alamat lembaga" rows="4"> </textarea>
                                                @error('alamat_lembaga_entitas')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif




                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                class="fas fa-ban"></i>
                            Batal</button>
                        <button type="submit" name="submit" class="btn btn-success"><i class="fas fa-save"></i>
                            Simpan</button>
                    </div>
                </form>




            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">

            <div class="card">
                <!-- /.card-header -->
                <div class="card-body">

                    {{-- alert --}}
                    @if (session()->has('message_simpan'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="far fa-check-circle"></i> {{ session('message_simpan') }}
                        </div>
                    @endif
                    @if (session()->has('message_hapus'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="far fa-check-circle"></i> {{ session('message_hapus') }}
                        </div>
                    @endif

                    {{-- pencarian dengan tombol --}}
                    <form wire:submit.prevent="searching">
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col col-md-2 col-sm-12">
                                    <select class="form-control">
                                        <option>Kategori Penerima Manfaat</option>
                                    </select>
                                </div>
                                <div class="col col-md-2 col-sm-12">
                                    <select class="form-control">
                                        <option>Bentuk Program</option>
                                    </select>
                                </div>
                                <div class="col col-md-2 col-sm-12">
                                    <select class="form-control">
                                        <option>Sub-Program</option>
                                    </select>
                                </div>
                                <div class="col col-md-1 col-sm-12">
                                    <select class="form-control">
                                        <option>Status</option>
                                    </select>
                                </div>
                                <div class="col col-md-2 col-sm-12">
                                    <select class="form-control">
                                        <option>Bulan</option>
                                    </select>
                                </div>
                                <div class="col col-md-2 col-sm-12">
                                    <select class="form-control">
                                        <option>Tahun</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <button class="btn btn-primary btn-block" type="submit">Filter</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    {{-- tabel --}}
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px;">No</th>
                                    <th>Nama</th>
                                    <th>Jenis</th>
                                    <th>Kategori</th>
                                    <th>No HP</th>
                                    <th>Alamat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($data as $object)
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center"> Data tidak ditemukan</td>
                                    </tr>
                                @endforelse
                                @foreach ($data as $perorangan)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $perorangan->nama }}</td>
                                        <td>{{ $perorangan->jenis }}</td>
                                        <td>{{ $perorangan->id_kategori_penerima_manfaat }}</td>
                                        <td>{{ $perorangan->alamat }}</td>
                                        <td>{{ $perorangan->nohp }}</td>
                                        <td>
                                            <!-- Example split danger button -->
                                            <div class="btn-group">

                                                <button type="button" class="btn btn-success" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">Kelola</button>
                                                <button type="button"
                                                    class="btn btn-success dropdown-toggle dropdown-toggle-split"
                                                    data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu">

                                                    <a onMouseOver="this.style.color='green'"
                                                        onMouseOut="this.style.color='black'" class="dropdown-item"
                                                        wire:click="modal_edit('{{ $perorangan->id_pengguna }}')"
                                                        data-toggle="modal" data-target="#modal_edit"
                                                        type="button"><i class="far fa-eye"></i> Detail</a>



                                                    <a onMouseOver="this.style.color='red'"
                                                        onMouseOut="this.style.color='black'" class="dropdown-item"
                                                        wire:click="modal_delete('{{ $perorangan->id_pengguna }}')"
                                                        data-toggle="modal" data-target="#modal_delete"
                                                        type="button"><i class="fas fa-trash"></i>
                                                        Hapus</a>
                                                </div>
                                            </div>






                                            {{-- 
                                           <button class="btn btn-sm btn-info"
                                               wire:click="modal_edit('{{ $perorangan->id_pengguna }}')"
                                               data-toggle="modal" data-target="#modal_edit">Ubah</button>
                                           <button class="btn btn-sm btn-danger" class="btn btn-danger"
                                               wire:click="modal_delete('{{ $perorangan->id_pengguna }}')"
                                               data-toggle="modal" data-target="#modal_delete"><i
                                                   class="fas fa-trash"></i>
                                               Hapus</button> --}}
                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>

                        {{-- pagination --}}
                        {{ $data->links() }}
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
                        @if (session()->has('message_update'))
                            <span class="badge badge-success">{{ session('message_update') }}</span>
                        @endif
                    </div>

                </div>

                <ul class="nav nav-tabs mt-1" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a wire:ignore.self class="nav-link active" id="home-tab" data-toggle="tab"
                            href="#detail_diri_edit" role="tab" aria-controls="home" aria-selected="true">Detail
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
                        <div wire:ignore.self class="tab-pane fade show active" id="detail_diri_edit" role="tabpanel"
                            aria-labelledby="home-tab">

                            {{-- form detail diri --}}
                            <div class="modal-body mt-2">
                                <div id="form-baru">

                                    <div class="form-row">
                                        {{-- nama --}}
                                        <div class="form-group col-md-6">
                                            <label for="inputNama">NAMA &nbsp;</label>
                                            <sup class="badge badge-danger text-white mb-2"
                                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                                            <input type="text" id="inptNama" wire:model.defer="nama_edit"
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
                                                wire:model.defer="alamat_edit" placeholder="Masukan alamat">
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


                                            <select class="form-control @error('jenis_edit') is-invalid @enderror"
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

                                                @foreach ($kategori_edit as $kategori)
                                                    <option value="{{ $kategori->id_kategori_penerima_manfaat }}">
                                                        {{ $kategori->kategori }}</option>
                                                @endforeach
                                            </select>
                                            @error('id_kategori_penerima_manfaat_edit')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                    </div>


                                    @if ($jenis_edit == 'Entitas')
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
                                    @endif




                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- tombol footer --}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                class="fas fa-ban"></i>
                            Batal</button>
                        <button type="submit" name="submit" class="btn btn-success"><i class="fas fa-save"></i>
                            Simpan Perubahan</button>
                    </div>

                </form>
            </div>
        </div>
    </div>


    {{-- modal hapus --}}
    <div wire:ignore.self class="modal fade" id="modal_delete" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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
                    <button type="button" wire:click.prevent="delete()" class="btn btn-danger close-modal"
                        data-dismiss="modal"><i class="fas fa-trash"></i> Iya, Hapus</button>
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
