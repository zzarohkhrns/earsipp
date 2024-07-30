<div>
    <div class="form-row">
        <div class="form-group col-md-12">
            <label>Coba1 &nbsp;</label>
            <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup>
            <input wire:model="coba1" type="text" class="form-control" placeholder="Masukan Penanggungjawab Kegiatan"
                name="penanggungjawab_kegiatan">
        </div>

    </div>

    <div class="form-row">
        <div class="form-group col-md-12">
            <label>Coba2 &nbsp;</label>
            <sup class="badge badge-danger text-white mb-2" style="background-color:rgba(230,82,82)">WAJIB</sup>
            <input wire:model="coba2" type="text" class="form-control" placeholder="Masukan Penanggungjawab Kegiatan"
                name="penanggungjawab_kegiatan">
        </div>

    </div>


    <div class="modal-footer">
        @if ($coba1 != '' and $coba2 != '')
            <button type="button" class="btn btn-primary" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal"
                data-bs-dismiss="modal"><i class="fas fa-forward"></i> Selanjutnya</button>
        @else
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal" disabled><i
                    class="fas fa-forward"></i> Selanjutnya</button>
        @endif
    </div>
</div>
