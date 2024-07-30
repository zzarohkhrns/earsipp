<div>
    <div class="add-input">
        <div class="form-row">
            {{-- judul dokumentasi --}}
            <div class="form-group col-md-5">
                <label for="inputNama">JUDUL FOTO
                    &nbsp;</label>
                <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup>
                <input wire:model="judul_foto_kegiatan" type="text" class="form-control " placeholder="Nama Judul Foto"
                    name="judul_foto_kegiatan">
            </div>

            {{-- foto dokumentasi --}}
            <div class="form-group col-md-5">
                <label for="inputHP">FOTO KEGIATAN</label>
                <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB
                    (JPG/JPEG/PNG)</sup>
                <div wire:ignore class="custom-file custom-file-tambah-dokumentasi">
                    <input type="file" wire:model="file_foto_kegiatan" accept="image/png, image/jpg, image/jpeg"
                        class="custom-file-input" name="file_foto_kegiatan">
                    <label class="custom-file-label" for="customFile">Pilih
                        file</label>
                </div>
            </div>

            <div class="col-md-2 mt-2">
                <br>
                @if ($judul_foto_kegiatan != '' && $file_foto_kegiatan != '')
                    <button onclick="$('#cover-spin').show(0)" type="submit" name="submit"
                        class="btn btn-success btn-block tombol-tambah"><i class="fas fa-plus-circle"></i>
                        Tambah</button>
                @else
                    <button type="submit" name="submit" disabled class="btn btn-success btn-block tombol-tambah"><i
                            class="fas fa-plus-circle"></i>
                        Tambah</button>
                @endif
            </div>
        </div>

    </div>
</div>
