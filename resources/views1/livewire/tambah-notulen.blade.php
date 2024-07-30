<div>
    <!-- Modal -->
    <div wire:ignore.self class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Notulen
                        Kegiatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-row">
                        <div class="form col-md-9">
                            <label for="cariPekerjaan">PIC &nbsp;</label>
                            <sup class="badge badge-danger text-white mb-2"
                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                            <input wire:model="pic" type="text" class="form-control"
                                placeholder="Masukan PIC Kegiatan" name="pic[]">
                        </div>
                        <div class="form col-md-3">
                            <label><br></label>
                            <sup class="badge text-white mb-2"><br></sup>
                            <br>

                            <button id="addRow" type="button" class="btn btn-success btn-block"><i
                                    class="fas fa-plus-square"></i>
                                PIC</button>
                        </div>

                    </div>
                    <div wire:ignore id="newRow"></div>


                    <script type="text/javascript">
                        // add row

                        $("#addRow").click(function() {
                            var html = '';
                            html += '<div class="form-row">';
                            html += '<div id="inputFormRow1" class=" col-md-12">';
                            html += '<label class="col-form-label">PIC </label > ';
                            html += '<div class=" row " >';
                            html += '<div class="input-group" id="inputFormRow">';
                            html +=
                                '  <div class="form col-md-9"> <input type="text" required name="pic[]" class="form-control" placeholder="Masukan PIC Kegiatan" autocomplete="off"></div>' +
                                '   <div class="form col-md-3"><button id="removeRow" type="button" class="btn btn-danger btn-block"><i class="fas fa-trash"></i> Hapus</button></div>' +
                                '</div>';
                            html += '</div>';
                            html += '</div>';
                            html += '</div>';
                            html += '</div>';

                            $('#newRow').append(html);
                        });


                        // remove row
                        $(document).on('click', '#removeRow', function() {

                            $(this).closest('#inputFormRow1').remove();
                        });
                    </script>
                    <br>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Tanggal Rencana
                                Penyelesaian
                                &nbsp;</label>
                            <sup class="badge badge-danger text-white mb-2"
                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                            <input wire:model="tgl_rencana" type="date" class="form-control" name="tgl_rencana">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="cariPekerjaan">Tanggal Realisasi
                                Penyelesaian
                                &nbsp;</label>
                            <sup class="badge badge-danger text-white mb-2"
                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                            <input wire:model="tgl_realisasi" type="date" class="form-control"
                                placeholder="Masukan Nama Kegiatan" name="tgl_realisasi">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>PEMBAHASAN KEGIATAN/ KEPUTUSAN &nbsp;</label>
                            <sup class="badge badge-danger text-white mb-2"
                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                            <textarea wire:model="pembahasan" type="text" class="form-control" name="pembahasan" rows="4"> </textarea>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i>
                        Batal</button>

                    @if ($pembahasan != '' && $tgl_realisasi != '' && $pic != '' && $tgl_rencana != '')
                        <button 
                            class="btn btn-success text-white toastrDefaultSuccess" type="submit"><i
                                class="fas fa-save"></i>
                            Simpan
                        </button>
                    @else
                        <button class="btn btn-success text-white toastrDefaultSuccess" type="submit" disabled><i
                                class="fas fa-save"></i>
                            Simpan
                        </button>
                    @endif
                </div>

            </div>
        </div>
    </div>
    <!--END  Modal -->
</div>
