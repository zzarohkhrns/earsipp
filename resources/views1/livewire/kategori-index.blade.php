<div>

    <div class="row ">
        <div class="col-8 pr-0 d-highlight pr-0 mr-0 ">
            <span>Data Zakat Fitrah</span> <br>
            <small>Pilih periode dan bentuk zakat pada filter untuk melanjutkan pencarian
                data
            </small>

        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col">

                            <button class="btn btn-sm btn-success btn-block" type="submit">Tambah</button>

                        </div>
                        <div class="col">

                            <button class="btn btn-sm btn-success btn-block" type="submit">Cetak</button>

                        </div>


                    </div>

                </div>
            </div>
        </div>
    </div>




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


    <form wire:submit.prevent="create">
        <div class="form-group">
            <div class="form-row">
                <div class="col col-md-6 col-sm-12">
                    <input wire:model.defer="kategori" type="text"
                        class="form-control   @error('kategori') is-invalid @enderror" placeholder="Nama Kategori">
                    @error('kategori')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col col-md-2 col-sm-12">
                    <input wire:model.defer="kode" type="number"
                        class="form-control   @error('kode') is-invalid @enderror" placeholder="Kode Kategori">
                    @error('kode')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col">
                    <button type="submit" class="btn btn-block  btn-success"><i class="fas fa-plus"></i>
                        Tambah</button>
                </div>
            </div>
        </div>
    </form>

    <nav class="navbar navbar-expand-sm">
        <div class="collapse navbar-collapse" id="navbarScroll">
            <ul class="navbar-nav mr-auto my-2 my-sm-0 navbar-nav-scroll" style="max-height: 50px;">
                <div class="row">
                    <small class="align-self-center">Show &nbsp;</small>
                    <li class="nav-item mx-1 p-0">
                        <div class="dataTables_length" id="example_length">
                            <select wire:model="page_number" name="example_length" aria-controls="example_length"
                                class="custom-select custom-select-sm form-control form-control-sm">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="200">200</option>
                            </select>
                        </div>
                    </li>
                    <small class="align-self-center">&nbsp;entries</small>
                </div>

            </ul>

            {{-- pencarian dengan tombol --}}
            <form wire:submit.prevent="searching">
                <div class="input-group mr-12">

                    <input wire:model.defer="search" type="search" class="form-control form-control-sm"
                        placeholder="Search" value="" name="cari" id="cari">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-sm btn-default">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </nav>




    <table class="table table-bordered" style="width:100%">
        <thead>
            <tr>
                <th style="width: 10px;">No</th>
                <th>Nama Kategori</th>
                <th>Kode</th>
                <th>Opsi</th>

            </tr>


        </thead>



        <tbody>
            @forelse($data as $object)
            @empty
                <tr>
                    <td colspan="4" class="text-center"> Data tidak ditemukan</td>
                </tr>
            @endforelse
            @foreach ($data as $kategori)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $kategori->kategori }}</td>
                    <td>{{ $kategori->kode }}</td>
                    <td style="width: 10%;">

                        <!-- Example split danger button -->
                        <div class="btn-group">

                            <button type="button" class="btn btn-success" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">Kelola</button>
                            <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu">
                                <a onMouseOver="this.style.color='blue'" onMouseOut="this.style.color='black'"
                                    class="dropdown-item"
                                    wire:click="modal_update('{{ $kategori->id_kategori_penerima_manfaat }}', '{{ $kategori->kategori }}', '{{ $kategori->kode }}')"
                                    data-toggle="modal" data-target="#modal_edit" type="button"><i
                                        class="fas fa-edit"></i> Ubah</a>
                                <a onMouseOver="this.style.color='red'" onMouseOut="this.style.color='black'"
                                    class="dropdown-item"
                                    wire:click="modal_delete('{{ $kategori->id_kategori_penerima_manfaat }}')"
                                    data-toggle="modal" data-target="#modal_delete" type="button"><i
                                        class="fas fa-trash"></i>
                                    Hapus</a>
                            </div>
                        </div>

                    </td>

                </tr>
            @endforeach

        </tbody>

    </table>
    {{-- pagination --}}
    {{ $data->links() }}

    {{-- modal edit --}}
    <div wire:ignore.self class="modal fade" id="modal_edit" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">Ubah Data
                    </h5>
                    <div class="col-auto float-right">
                        @if (session()->has('message_update'))
                            <span class="badge badge-success">{{ session('message_update') }}</span>
                        @endif
                    </div>



                </div>
                <div class="modal-body">

                    <form wire:submit.prevent="update">

                        <div class="form-row">
                            {{-- nama --}}
                            <div class="form-group col-md-8">
                                <label for="inputNama">NAMA KATEGORI &nbsp;</label>
                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                <input wire:model.defer="kategori_edit" type="text" class="form-control"
                                    placeholder="Nama Kategori">
                                @error('kategori_edit')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group  col-md-4">
                                <label for="inputNama">KODE KATEGORI &nbsp;</label>
                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                <input wire:model.defer="kode_edit" type="number" class="form-control"
                                    placeholder="Kode Kategori">
                                @error('kode_edit')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i>
                        Batal</button>
                    <button type="submit" name="submit" class="btn btn-success"><i class="fas fa-save"></i>
                        Simpan Perubahan</button>
                </div>
            </div>

            </form>
        </div>
    </div>

    {{-- modal hapus --}}
    <div wire:ignore.self class="modal fade" id="modal_delete" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus</h5>

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

</div>
