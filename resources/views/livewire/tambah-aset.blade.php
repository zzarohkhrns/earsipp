<div>
    {{-- Do your work, then step back. --}}
    <div class="card card-success ">

        <div class="card-body ">
            <!-- Aset Umum -->
            <div class="card card-success ijo-atas">
                <div class="row mt-4 ml-4 justify-content-between">
                    <div>
                        <p class="card-title "><b>Rincian {{ $page }} </b>
                        </p>
                    </div>

                    <!-- Button trigger modal -->
                    {{-- <input type="hidden" name="pelaksana_kegiatan"> --}}
                </div>


                <div class="card-body">
                    <div class="row">

                        <div class="col-lg-6 col-6">

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"> Kategori Aset</label>
                                <div class="col-sm-8">
                                    <select wire:model="kategoris"
                                        class="form-control @error('kategori') is-invalid @enderror" name="kategori"
                                        data-placeholder="Masukan Kategori Aset"
                                        style="appearance:none;
                            -webkit-appearance:none;
                            -moz-appearance:none; "
                                        required>
                                        <option value="" selected hidden>Pilih Kategori Aset
                                        </option>
                                        @foreach ($kategori_aset_lv as $kategori_s)
                                            <option value="{{ $kategori_s->nama_kategori }}">
                                                {{ $kategori_s->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                    @error('kategori')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Nama Aset</label>
                                <div class="col-sm-8">
                                    <input type="text" autocomplete="off" wire:model="nama"
                                        class="form-control @error('nama') is-invalid @enderror" name="nama"
                                        placeholder="Masukan Nama Aset  " value="{{ old('nama') }}">
                                    @error('nama')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Asal Aset</label>
                                <div class="col-sm-8">
                                    <input type="text" autocomplete="off" wire:model="asal"
                                        class="form-control @error('asal') is-invalid @enderror" name="asal"
                                        placeholder="Masukan Asal Aset  " value="{{ old('asal') }}">
                                    @error('asal')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Lokasi Aset</label>
                                <div class="col-sm-8">
                                    <input type="text" autocomplete="off" wire:model="lokasi"
                                        class="form-control @error('lokasi') is-invalid @enderror" name="lokasi"
                                        placeholder="Masukan Lokasi Aset  " value="{{ old('lokasi') }}">
                                    @error('lokasi')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Tahun Perolehan Aset</label>
                                <div class="col-sm-8">
                                    <input type="number" wire:model="tahun_perolehan"
                                        class="form-control @error('tahun_perolehan') is-invalid @enderror"
                                        name="tahun_perolehan" placeholder="Masukan Tahun Perolehan Aset"
                                        value="">
                                    @error('tahun_perolehan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-6">



                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Jumlah Unit Aset</label>
                                <div class="col-sm-8">
                                    <input type="number" autocomplete="off" wire:model="jumlah_unit"
                                        class="form-control @error('jumlah_unit') is-invalid @enderror"
                                        name="jumlah_unit" placeholder="Masukan Jumlah Unit Aset"
                                        value="{{ old('jumlah_unit') }}">
                                    @error('jumlah_unit')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Nominal Aset</label>
                                <div class="input-group col-sm-8">

                                    <input type="text" autocomplete="off" wire:model="nominal"
                                        class="form-control @error('nominal') is-invalid @enderror" name="nominal"
                                        placeholder="Masukan Nominal Aset" value="{{ old('nominal') }}" id="nominal">
                                    <p class="input-group-text" style=" width: 100px;height:37px;max-height:100%;">
                                        Rupiah</p>

                                    @error('nominal')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Kondisi Aset</label>
                                <div class="col-sm-8">
                                    <select wire:model="kondisi"
                                        class="form-control 
                                        @error('kondisi') is-invalid @enderror"
                                        name="kondisi" data-placeholder="Masukan Klasifikasi Surat"
                                        style="appearance:none;
                            -webkit-appearance:none;
                            -moz-appearance:none; "
                                        required>
                                        <option value=""selected hidden>Pilih Kondisi Aset
                                        </option>
                                        <option value="Baik">Baik
                                        </option>
                                        <option value="Kurang">Kurang
                                        </option>
                                        <option value="Rusak">Rusak
                                        </option>
                                    </select>
                                    @error('kondisi')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>



                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Keterangan Aset</label>
                                <div class="col-sm-8">
                                    <textarea wire:model="keterangan" class="form-control  @error('keterangan') is-invalid @enderror" name="keterangan"
                                        id="" cols="50" rows="4" placeholder="Masukan Keterangan Data Aset">{{ old('keterangan') }}</textarea>
                                    @error('keterangan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>




                        </div>

                    </div>



                </div>
                <!-- /.card-body -->
            </div>


            {{-- File ASET --}}
            <div class="card card-success ijo-atas">
                <div class="row mt-4 ml-4 justify-content-between">
                    <div>
                        <h4 class="card-title "><b>Upload File Aset</b>
                        </h4>

                    </div>

                    <div class="col-auto mr-3">

                        <button id="addRow" type="button" class="btn btn-success"><i class="fas fa-plus-circle"
                                aria-hidden="true"></i> Tambah
                            File Lainnya</button>
                    </div>

                </div>

                <div class="card-body mr-3 ml-3">

                    <div class="form-group row ">

                        <label style="font-size: 19px;"> Silahkan pilih file anda. Ukuran maksimal file 2 MB
                            dengan format jpg, doc,
                            docx, pdf, jpeg,
                            png.</label>
                    </div>


                    <div class="form-group row ">

                        <label class="col-sm-4 col-form-label">
                            File Aset </label>
                        <input style="width: 100%;" class="form-control" class="form-control m-input" type="text"
                            id="formFileSm" name="nama_file" wire:model="nama_file"
                            placeholder="Masukan Judul File " autocomplete="off">



                    </div>



                    <div class="form-group row ">

                        <input style="width: 100%;" class="form-control" class="form-control m-input" type="file"
                            name="file_aset" wire:model="file_aset" id="formFileSm"
                            accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.xlsx" autocomplete="off">
                    </div>


                    {{-- <link rel="stylesheet"
                        href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
                    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> --}}


                    <div wire:ignore id="newRow"></div>


                    <script type="text/javascript">
                        // add row

                        $("#addRow").click(function() {

                            var html = '';

                            html += '<div id="inputFormRow1">';
                            html += '<label class="col-form-label">File Aset </label > ';
                            html += '<div class="form-group row">';
                            html +=
                                '<input type="text" name="nama_file_baru[]" class="form-control " placeholder="Masukan Judul File" autocomplete="off" >';
                            html += '</div>';
                            html += '<div class="form-group row " >';
                            html += '<div class="input-group" id="inputFormRow">';
                            html +=
                                '<input type="file" name="file_aset_baru[]" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.xlsx" class="form-control " placeholder="Masukan Judul File" autocomplete="off">' +
                                '<div class="input-group-append" >' +
                                '<button id="removeRow" type="button" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>' +
                                '</div>';
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
                </div>

            </div>
            <!-- /.card -->
        </div>
        <!-- /.card-body -->
        <!-- /.card-body -->

        <div class="card-footer ">
            <div class="col-auto float-right">
                <!-- Button trigger modal -->
                <a href=" javascript:history.back()" type="button" class="btn btn-secondary">
                    <i class="fas fa-ban"></i> Batal
                </a>
                {{-- <button onclick="$('#cover-spin').show(0)" type="submit" class="btn btn-success"
                    name="submit" onclick="simpan(this.form)">
                    <i class="fas fa-save"></i> Simpan
                </button> --}}


                @if (
                    $kategoris != null &&
                        $nama != null &&
                        $asal != null &&
                        $lokasi != null &&
                        $tahun_perolehan != null &&
                        $jumlah_unit != null &&
                        $nominal != null &&
                        $kondisi != null &&
                        $keterangan != null &&
                        $nama_file != null &&
                        $file_aset != null)
                    <button onclick="$('#cover-spin').show(0)" type="submit" class="btn btn-success"
                        name="submit">
                        <i class="fas fa-save"></i> Simpan

                    </button>
                @else
                    <button onclick="$('#cover-spin').show(0)" type="submit" class="btn btn-success" name="submit"
                        disabled>
                        <i class="fas fa-save"></i> Simpan

                    </button>
                @endif
                {{-- <script>
                    function simpan(form) {
                        form.target = '';
                        form.action = '/{{ $role }}/aksi_tambah_aset/{{ $link }}';
                        form.submit();
                    }
                </script> --}}
            </div>
        </div>

    </div>

</div>
