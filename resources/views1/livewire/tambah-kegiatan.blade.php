<div>

    <div wire:ignore.self class="modal fade bd-example-modal-lg " id="exampleModalToggle" aria-hidden="true"
        aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-lg intro-form-modal-tambah-kegiatan-js">
            <div class="modal-content">
                <div class="modal-header ">
                    <h5 class="modal-title" id="exampleModalLongTitle">Tambah Kegiatan
                        &
                        Notulen</h5>
                    <button id="tutup-modal" type="button" class="close" data-bs-dismiss="modal"
                        aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form method="POST">
                    @csrf
                    <div class="modal-body">
                        <nav class="mb-4">
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <button class="nav-link  active intro-tab-kegiatan-notulen-js" id="satu"
                                    data-toggle="tab" data-target="#nav-satu-tab" type="button" role="tab"
                                    aria-controls="nav-satu-tab" aria-selected="true">1. Kegiatan dan Notulen</button>
                                <button class="nav-link  disabled intro-tab-detail-kegiatan-notulen-js" id="dua"
                                    data-toggle="tab" data-target="#nav-dua-tab" type="button" role="tab"
                                    aria-controls="nav-dua-tab" aria-selected="false">2. Detail Kegiatan dan
                                    Notulen</button>
                            </div>
                        </nav>

                        <div class="form-row">
                            <div class="form-group col-md-6 ">
                                <label>TANGGAL KEGIATAN &nbsp;</label>
                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                <input wire:model="tgl_kegiatan" type="date" class="form-control"
                                    name="tgl_kegiatan">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="cariPekerjaan">NAMA KEGIATAN &nbsp;</label>
                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                <input wire:model="nama_kegiatan" type="text" class="form-control"
                                    placeholder="Masukan Nama Kegiatan" name="nama_kegiatan">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>JENIS KEGIATAN &nbsp;</label>
                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                <select wire:model="jenis_kegiatan" name="jenis_kegiatan" class="form-control">
                                    <option selected hidden>Pilih Jenis Kegiatan</option>
                                    @foreach ($jenis_kegiatan as $jk)
                                        <option value="{{ $jk->jenis_kegiatan }}">
                                            {{ $jk->jenis_kegiatan }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="cariPekerjaan">ESTIMASI BIAYA &nbsp;</label>
                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                <div class="input-group">
                                    <input wire:model="estimasi_biaya_kegiatan" type="text" class="form-control"
                                        placeholder="Masukan Estimasi Biaya Kegiatan" name="estimasi_biaya_kegiatan"
                                        id="anggaran">
                                    <p class="input-group-text" style=" width: 100px;height:37px;max-height:100%;">
                                        Rupiah</p>

                                </div>
                            </div>

                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>PELAKSANA KEGIATAN &nbsp;</label>
                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                <input wire:model="pelaksana_kegiatan" type="text" class="form-control"
                                    placeholder="Masukan Pelaksana Kegiatan" name="pelaksana_kegiatan">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="cariPekerjaan">LOKASI KEGIATAN &nbsp;</label>
                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                <input wire:model="lokasi_kegiatan" type="text" class="form-control"
                                    placeholder="Masukan Lokasi Kegiatan" name="lokasi_kegiatan" id="message">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>PENANGGUNGJAWAB &nbsp;</label>
                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                <input wire:model="penanggungjawab_kegiatan" type="text" class="form-control"
                                    placeholder="Masukan Penanggungjawab Kegiatan" name="penanggungjawab_kegiatan"
                                    id="message">
                            </div>
                            <div class="form-group col-md-6">
                                <label>TANGGAL INPUT DATA &nbsp;</label>
                                <sup class="badge badge-danger text-white mb-2"
                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                <input type="text" class="form-control" readonly
                                    value="{{ Carbon\Carbon::parse(now())->isoFormat('dddd, D MMMM Y') }}">
                            </div>
                        </div>

                    </div>


                    <div class="modal-footer">
                        @if (
                            $tgl_kegiatan != '' and
                                $nama_kegiatan != '' and
                                $jenis_kegiatan != '' and
                                $estimasi_biaya_kegiatan != '' and
                                $pelaksana_kegiatan != '' and
                                $lokasi_kegiatan != '' and
                                $penanggungjawab_kegiatan)
                            <button type="button" class="btn btn-primary" data-bs-target="#exampleModalToggle2"
                                data-bs-toggle="modal" data-bs-dismiss="modal"><i class="fas fa-forward"></i>
                                Selanjutnya</button>
                        @else
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal" disabled><i
                                    class="fas fa-forward"></i> Selanjutnya</button>
                        @endif
                    </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade bd-example-modal-lg" id="exampleModalToggle2" aria-hidden="true"
        aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Detail Kegiatan
                        &
                        Notulen</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <nav class="mb-4">
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link  disabled" id="satu" data-toggle="tab"
                                data-target="#nav-satu-tab" type="button" role="tab"
                                aria-controls="nav-satu-tab" aria-selected="true">1. Kegiatan dan Notulen</button>
                            <button class="nav-link  active" id="dua" data-toggle="tab"
                                data-target="#nav-dua-tab" type="button" role="tab" aria-controls="nav-dua-tab"
                                aria-selected="false">2. Detail Kegiatan dan
                                Notulen</button>
                        </div>
                    </nav>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>CAPAIAN KEGIATAN &nbsp;</label>
                            <textarea wire:model="capaian_kegiatan" type="text" class="form-control" name="capaian_kegiatan"
                                placeholder="Masukan Capaian Kegiatan"></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="cariPekerjaan">RINGKASAN JALANNYA KEGIATAN
                                &nbsp;</label>
                            <textarea wire:model="ringkasan_kegiatan" type="text" class="form-control" name="ringkasan_kegiatan"
                                placeholder="Masukan Ringkasan Jalannya Kegiatan"></textarea>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>KENDALA KEGIATAN&nbsp;</label>
                            <textarea wire:model="kendala_kegiatan" type="text" class="form-control" name="kendala_kegiatan"
                                placeholder="Masukan Kendala Kegiatan"></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="cariPekerjaan">SOLUSI KEGIATAN &nbsp;</label>
                            <textarea wire:model="solusi_kegiatan" type="text" class="form-control" name="solusi_kegiatan"
                                placeholder="Masukan Solusi Kegiatan"></textarea>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="button" data-bs-target="#exampleModalToggle"
                        data-bs-toggle="modal" data-bs-dismiss="modal"><i class="fas fa-backward"></i>
                        Kembali</button>

                    {{-- @if ($capaian_kegiatan != '' and $ringkasan_kegiatan != '' and $kendala_kegiatan != '' and $solusi_kegiatan != '')
                        <button onclick="$('#cover-spin').show(0)" class="btn btn-success" type="submit"><i
                                class="fas fa-save"></i> Simpan
                        </button>
                    @else
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal" disabled><i
                                class="fas fa-forward"></i> Simpan</button>
                    @endif --}}

                    <button formaction="/{{ $role }}/aksi_tambah_kegiatan" onclick="$('#cover-spin').show(0)"
                        class="btn btn-success" type="submit"><i class="fas fa-save"></i> Simpan
                    </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
