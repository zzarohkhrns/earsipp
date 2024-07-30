<div>
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


    <form wire:submit.prevent="simpan">
        <div class="form-group">
            <div class="form-row">
                <div class="col col-md-4 col-sm-12">
                    <input wire:model.defer="nama" type="text" class="form-control   @error('nama') is-invalid @enderror" placeholder="Kategori">
                    @error('nama')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="col col-md-4 col-sm-12">
                    <input wire:model.defer="tanggal" type="date" class="form-control   @error('tanggal') is-invalid @enderror" placeholder="Tanggal">
                    @error('tanggal')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="col">
                    <button type="submit" class="btn btn-block  btn-primary">Tambah</button>
                </div>
            </div>
        </div>
    </form>

    {{ $nama }}



    {{-- pencarian tanpa tombol --}}
    <div class="form-group">
        <div class="form-row">
            <div class="col col-md-2 col-sm-12">
                Pencarian Tanpa Tombol
            </div>
            <div class="col">
                <input type="text" class="form-control" wire:model="search">
            </div>
        </div>
    </div>


    {{-- pencarian dengan tombol --}}
    <form wire:submit.prevent="searching">


        <div class="form-group">
            <div class="form-row">
                <div class="col col-md-2 col-sm-12">

                    <input wire:model="search_tanggal_awal" name="tanggal_awal" type="date" class="form-control">
                </div>

                <div class="col col-md-2 col-sm-12">
                    <input wire:model="search_tanggal_akhir" type="date" class="form-control" min="{{ $search_tanggal_awal }}">
                </div>

                <div class="col col-2">

                </div>
                <div class="col col-md-4 col-sm-12">

                    <input wire:model.defer="search" type="text" class="form-control" placeholder="Cari Kategori">

                </div>


                <div class="col">
                    <button class="btn btn-primary btn-block" type="submit">Cari</button>
                </div>
            </div>
        </div>
    </form>



    <table class="table table-bordered" style="width:100%">
        <thead>
            <tr>
                <th style="width: 10px;">No</th>
                <th>Nama Kategori</th>
                <th>Tanggal</th>
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
                <td>{{ $kategori->nama }}</td>
                <td>{{ $kategori->tanggal }}</td>
                <td>
                    <button class="btn btn-sm btn-info" wire:click="modal_update({{ $kategori->id }}, '{{ $kategori->nama }}')" data-toggle="modal" data-target="#exampleModal">Ubah</button>
                    <button wire:click="modal_delete({{ $kategori->id }})" class="btn btn-sm btn-danger" class="btn btn-danger" data-toggle="modal" data-target="#modal_delete">Hapus</button>
                </td>

            </tr>
            @endforeach

        </tbody>

    </table>
    {{-- pagination --}}
    {{ $data->links() }}

    {{-- modal edit --}}
    <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
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
                        <div class="form-group">


                            <input wire:model.defer="namaedit" type="text" class="form-control" placeholder="Kategori">
                            @error('namaedit')
                            <span class="error">{{ $message }}</span>
                            @enderror

                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </div>

            </form>
        </div>
    </div>

    {{-- modal hapus --}}
    <div wire:ignore.self class="modal fade" id="modal_delete" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus</h5>

                </div>
                <div class="modal-body">
                    <p>Yakin ingin menghapus data?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Tutup</button>
                    <button type="button" wire:click.prevent="delete()" class="btn btn-danger close-modal" data-dismiss="modal">Iya, Hapus</button>
                </div>
            </div>
        </div>
    </div>

</div>