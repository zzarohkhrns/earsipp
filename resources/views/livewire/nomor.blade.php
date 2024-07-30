<div>

    <div class="card card-success">

        <div class="card-body ">

            <!-- Memo -->
            <div class="card card-success ijo-atas card-input-table-memo">
                <div class="row mt-4 ml-4 justify-content-between">
                    <div>
                        <h3 class="card-title "><b>Rincian Memo Internal</b>
                        </h3>
                    </div>
                    <div class="col-auto mr-3">

                    </div>
                    <!-- Button trigger modal -->

                </div>
                <div class="card-body ">


                    <div class="row">
                        <div class="col-lg-6 col-6">


                            <div class="form-group row card-tgl-memos">
                                <label class="col-sm-4 col-form-label">Tanggal Memo</label>
                                <div class="col-sm-8">
                                    <input class="form-control" name="tanggal_memo" type="text"
                                        placeholder="Masukan Perihal Surat"
                                        value="{{ Carbon\Carbon::parse(now())->isoFormat('dddd, D MMMM Y') }}" readonly>

                                </div>
                            </div>

                            <div class="form-group row card-input-sifat-memos">
                                <label class="col-sm-4 col-form-label">Sifat Memo</label>

                                <div class="col-sm-8">

                                    <select wire:model="sifat" id="sifat"
                                        class="form-control @error('sifat') is-invalid @enderror" name="sifat">

                                        {{-- @if (old('sifat') == 'Segera')
                                            <option value="Segera" selected>(A.I) Segera</option>
                                            <option value="Sangat Segera">(A.II) Sangat Segera
                                            </option>
                                            <option value="Rahasia">(A.III)Rahasia</option>
                                        @elseif(old('sifat') == 'Sangat Segera')
                                            <option value="Segera">(A.I) Segera</option>
                                            <option value="Sangat Segera" selected>(A.II) Sangat
                                                Segera</option>
                                            <option value="Rahasia">(A.III) Rahasia</option>
                                        @elseif(old('sifat') == 'Rahasia')
                                            <option value="Segera">(A.I) Segera</option>
                                            <option value="Sangat Segera" selected>(A.II) Sangat
                                                Segera</option>
                                            <option value="Rahasia" selected>(A.III) Rahasia</option>
                                        @else --}}
                                        <option value="" disabled selected hidden>Pilih Sifat
                                            Memo
                                        </option>
                                        <option value="Segera">(A.I) Segera</option>
                                        <option value="Sangat Segera">(A.II) Sangat Segera
                                        </option>
                                        <option value="Rahasia">(A.III) Rahasia</option>
                                        {{-- @endif --}}



                                    </select>


                                    @if ($errors->has('hal') || $errors->has('akses_internal') || $errors->has('isi_memo'))
                                        <span style="color: #dc3545;font-weight: bolder;font-size: 100%;">
                                            Isi Ulang Sifat Memo</span>
                                    @endif
                                </div>
                            </div>


                            @php
                                $d = date('d');
                                $m = date('m');
                                $th = date('Y');
                                
                                $month = date('m');
                                
                                if ($month == '01') {
                                    $bulan = 'I';
                                } elseif ($month == '02') {
                                    $bulan = 'II';
                                } elseif ($month == '03') {
                                    $bulan = 'III';
                                } elseif ($month == '04') {
                                    $bulan = 'IV';
                                } elseif ($month == '05') {
                                    $bulan = 'V';
                                } elseif ($month == '06') {
                                    $bulan = 'VI';
                                } elseif ($month == '07') {
                                    $bulan = 'VII';
                                } elseif ($month == '08') {
                                    $bulan = 'VIII';
                                } elseif ($month == '09') {
                                    $bulan = 'IX';
                                } elseif ($month == '10') {
                                    $bulan = 'X';
                                } elseif ($month == '11') {
                                    $bulan = 'XI';
                                } elseif ($month == '12') {
                                    $bulan = 'XII';
                                }
                                
                                if ($si == 'Segera') {
                                    $sipat = 'A.I';
                                } elseif ($si == 'Sangat Segera') {
                                    $sipat = 'A.II';
                                } else {
                                    $sipat = 'A.III';
                                }
                                
                                if (Auth::user()->gocap_id_pc_pengurus != null) {
                                    $jaba = DB::connection('gocap')
                                        ->table('pengurus_jabatan')
                                        ->where('id_pengurus_jabatan', Auth::user()->PcPengurus->id_pengurus_jabatan)
                                        ->first();
                                
                                    if ($jaba->jabatan == 'Direktur') {
                                        $jabat = 'DIR';
                                    } elseif ($jaba->jabatan == 'Ketua') {
                                        $jabat = 'KET';
                                    }
                                }
                                
                                if (Auth::user()->gocap_id_upzis_pengurus != null) {
                                    $jaba = DB::connection('gocap')
                                        ->table('pengurus_jabatan')
                                        ->where('id_pengurus_jabatan', Auth::user()->UpzisPengurus->id_pengurus_jabatan)
                                        ->first();
                                
                                    if ($jaba->jabatan == 'Direktur') {
                                        $jabat = 'DIR';
                                    } elseif ($jaba->jabatan == 'Ketua') {
                                        $jabat = 'KET';
                                    }
                                }
                                
                                if (strlen($nomor_urut) == 1) {
                                    $nomor = '000' . $nomor_urut;
                                } elseif (strlen($nomor_urut) == 2) {
                                    $nomor = '00' . $nomor_urut;
                                } elseif (strlen($nomor_urut) == 3) {
                                    $nomor = '0' . $nomor_urut;
                                } elseif (strlen($nomor_urut) == 4) {
                                    $nomor = $nomor_urut;
                                } else {
                                    $nomor = $nomor_urut;
                                }
                            @endphp


                            <div class="form-group row card-input-nomor-memo ">
                                <label class="col-sm-4 col-form-label">Nomor Memo</label>
                                <div class="col-sm-8">


                                    @if ($sifat != null)
                                        <input type="text" autocomplete="off"
                                            class="form-control @error('nomor_memo') is-invalid @enderror"
                                            name="nomor_memo" placeholder="Masukan Nomor Memo"
                                            value="{{ $nomor . '/' . 'PC.11.34.10' . '/' . $sipat . '/' . 'MEMO' . '/' . $bulan . '/' . $th }}"
                                            readonly>
                                    @else
                                        <input type="text" autocomplete="off"
                                            class="form-control @error('nomor_memo') is-invalid @enderror "
                                            name="nomor_memo" placeholder="Masukan Nomor Memo" readonly>

                                        @error('nomor_memo')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    @endif
                                </div>
                            </div>

                            <input type="hidden" name="no_urut" value="{{ $nomor_urut }}">


                        </div>

                        <div class="col-lg-6 col-6">

                            <div class="form-group row card-input-dibuat-memo">
                                <label class="col-sm-4 col-form-label">Dibuat Oleh</label>
                                <div class="col-sm-8">

                                    @php
                                        if (Auth::user()->gocap_id_pc_pengurus != null) {
                                            $jaba = DB::connection('gocap')
                                                ->table('pengurus_jabatan')
                                                ->where('id_pengurus_jabatan', Auth::user()->PcPengurus->id_pengurus_jabatan)
                                                ->first();
                                        }
                                        
                                        if (Auth::user()->gocap_id_upzis_pengurus != null) {
                                            $jaba = DB::connection('gocap')
                                                ->table('pengurus_jabatan')
                                                ->where('id_pengurus_jabatan', Auth::user()->UpzisPengurus->id_pengurus_jabatan)
                                                ->first();
                                        }
                                    @endphp
                                    <input type="text" autocomplete="off" class="form-control" placeholder=""
                                        value="{{ Auth::user()->nama }} ({{ $jaba->jabatan }})" readonly required>

                                </div>
                            </div>

                            {{-- style="appearance:none;
    -webkit-appearance:none;
    -moz-appearance:none;
   " --}}

                            @if (Auth::user()->gocap_id_pc_pengurus != null)
                                <div class="form-group row card-input-ditujukan-memo" wire:ignore>
                                    <label class="col-sm-4 col-form-label">Ditujukan Kepada</label>
                                    <div class="col-sm-8 ">
                                        <input type="hidden" name="id_pc"
                                            value="{{ Auth::user()->PcPengurus->Pc->id_pc }}">

                                        <select class="select2 @error('akses_internal') is-invalid @enderror"
                                            multiple="multiple" data-placeholder="Pilih daftar penerima memo"
                                            style="width: 100%;" name="akses_internal[]">


                                            @foreach ($pengurus as $pengurus2)
                                                @php
                                                    $jabatans = DB::connection('gocap')
                                                        ->table('pengurus_jabatan')
                                                        ->where('id_pengurus_jabatan', $pengurus2->id_pengurus_jabatan)
                                                        ->select('jabatan')
                                                        ->get();
                                                @endphp
                                                <option value="{{ $pengurus2->id_pc_pengurus }}"
                                                    {{ in_array($pengurus2->id_pc_pengurus, old('akses_internal') ?: []) ? 'selected' : '' }}>
                                                    {{ $pengurus2->nama }}
                                                    @foreach ($jabatans as $item)
                                                        <span class="badge rounded-pill  bg-danger">
                                                            ({{ $item->jabatan }})
                                                        </span>
                                                    @endforeach
                                                </option>
                                                </option>
                                            @endforeach

                                        </select>

                                        @error('akses_internal')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            @endif


                            @if (Auth::user()->gocap_id_upzis_pengurus != null)
                                <div class="form-group row" wire:ignore>
                                    <label class="col-sm-4 col-form-label">Ditujukan Kepada</label>
                                    <div class="col-sm-8 ">
                                        <input type="hidden" name="id_upzis"
                                            value="{{ Auth::user()->UpzisPengurus->Upzis->id_upzis }}">

                                        <select class="select2 @error('akses_internal') is-invalid @enderror"
                                            multiple="multiple" data-placeholder="Masukan Hak Akses Arsip"
                                            style="width: 100%;" name="akses_internal[]">

                                            @foreach ($pengurus as $pengurus2)
                                                <option value="{{ $pengurus2->id_upzis_pengurus }}"
                                                    {{ in_array($pengurus2->id_upzis_pengurus, old('akses_internal') ?: []) ? 'selected' : '' }}>
                                                    {{ $pengurus2->nama }}</option>
                                                </option>
                                            @endforeach

                                        </select>

                                        @error('akses_internal')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                        @error('akses_internal')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>


                            @endif



                            <div class="form-group row card-input-hal-memo">
                                <label class="col-sm-4 col-form-label">Hal</label>
                                <div class="col-sm-8" wire:ignore>
                                    <input type="text" autocomplete="off"
                                        class="form-control @error('hal') is-invalid @enderror" name="hal"
                                        placeholder="Masukan Hal Memo" value="{{ old('hal') }}">
                                    @error('hal')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                            </div>





                        </div>




                    </div>

                    <div class="mb-3 card-input-isi-memo" wire:ignore>
                        <label for="desc" class="form-label">Isi Memo</label>
                        <textarea name="isi_memo" class="my-editor form-control @error('isi_memo') is-invalid @enderror" id="my-editor">{{ old('isi_memo') }}</textarea>
                        @error('isi_memo')
                            <span style="color: #dc3545;font-weight: bolder;
                            font-size: 100%;">
                                Isi Memo harus diisi</span>
                        @enderror
                    </div>

                </div>
                <!-- /.card-body -->
            </div>





            {{-- Lampiran --}}
            <div class="card card-success ijo-atas">
                <div class="row mt-4 ml-4 justify-content-between">
                    <div>
                        <h3 class="card-title "><b>Upload Lampiran Memo</b>
                        </h3>
                        &nbsp; <a href="#" class="sweet-tooltip" data-style-tooltip="tooltip-mini-slick"
                            data-text-tooltip=" Lorem ipsum, dolor sit amet  <br> consectetur  <br> adipisicing elit. Facere
, asperiores ullam  <br> esse quibusdam recusandae <br>  libero explicabo inventore  <br> sit dolore iure. "><i
                                class="far fa-question-circle"></i></a>
                    </div>

                    <div class="col-auto mr-3 card-input-lampiran-lainnya-memo">

                        <button id="addRow" type="button" class="btn btn-primary"><i class="fas fa-plus-circle"
                                aria-hidden="true"></i> Tambah
                            Lampiran</button>
                    </div>

                </div>

                <div class="card-body mr-3 ml-3 card-input-lampiran-memo">

                    <div class="form-group row ">

                        <label> Silahkan pilih Lampiran Memo anda. Ukuran maksimal file 2
                            MB. Jenis dokumen yang diijinkan adalah: <b>jpg, doc, docx, pdf, jpeg,
                                png</b></label><br>

                    </div>

                    <div class="form-group row ">
                        <label class="text-danger">*Jika lampiran tidak ada maka tidak perlu
                            dilampirkan</label>
                    </div>

                    <div class="form-group row " wire:ignore>

                        <label class="col-sm-4 col-form-label">
                            Lampiran Memo </label>
                        <input style="width: 100%;" class="form-control @error('nama_surat') is-invalid @enderror"
                            class="form-control m-input" type="text" id="formFileSm" name="nama_surat"
                            placeholder="Masukan Judul Memo" autocomplete="off" value="{{ old('nama_surat') }}">
                        @error('nama_surat')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>


                    <div class="form-group row ">

                        <input style="width: 100%;" class="form-control" class="form-control m-input" type="file"
                            name="file_memo" id="formFileSm" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.xlsx"
                            autocomplete="off">

                    </div>


                    <div id="newRow"></div>


                    <script type="text/javascript">
                        // add row

                        $("#addRow").click(function() {

                            var html = '';

                            html += '<div id="inputFormRow1">';
                            html += '<label class="col-form-label">Lampiran </label > ';
                            html += '<div class="form-group row">';
                            html +=
                                '<input type="text" name="nama[]" class="form-control " placeholder="Masukan Judul Memo" autocomplete="off">';
                            html += '</div>';
                            html += '<div class="form-group row " >';
                            html += '<div class="input-group" id="inputFormRow">';
                            html +=
                                '<input  type="file" name="lampiran[]" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.xlsx" class="form-control " placeholder="Masukan Judul Lampiran" autocomplete="off">' +
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



                <button onclick="$('#cover-spin').show(0)" type="submit"
                    class="btn btn-success card-button-simpan-memo" name="submit">
                    <i class="fas fa-save"></i> Simpan
                </button>

            </div>
        </div>
    </div>

    @push('intro_tambah_memo')
        <script>
            function klikkene(value) {
                introJs().setOptions({
                        steps: [{
                                element: document.querySelector('.card-input-table-memo'),
                                title: 'Rincian Memo',
                                intro: 'Berikut data Memo yang harus diisikan'
                            },

                            {
                                element: document.querySelector('.card-tgl-memos'),
                                title: 'Tanggal Memo',
                                intro: 'Tanggal Memo sudah diisikan secara otomatis berdasarkan hari Ini '
                            },
                            {
                                element: document.querySelector('.card-input-sifat-memos'),
                                title: 'Sifat Memo',
                                intro: 'Pilih Sifat Memo (A.I Segera / A.II Sangat Segera / A.II Rahasia) '
                            },
                            {
                                element: document.querySelector('.card-input-nomor-memo'),
                                title: 'Nomor Memo Otomatis',
                                intro: 'Nomor Memo akan generate secara otomatis hanya dengan mengisikkan Sifat Memo'
                            },
                            {
                                element: document.querySelector('.card-input-dibuat-memo'),
                                title: 'Dibuat Oleh',
                                intro: 'Pembuat memo sudah diisikan secara otomatis sesuai dengan user akun yang login'
                            },
                            {
                                element: document.querySelector('.card-input-ditujukan-memo'),
                                title: 'Ditujukan Kepada',
                                intro: 'Kolom Input Ini Menunjukan Daftar Penerima Memo Yang Akan Ditujukan'
                            },
                            {
                                element: document.querySelector('.card-input-hal-memo'),
                                title: 'Hal Memo',
                                intro: 'Masukkan hal memo pada kolom ini'
                            },
                            {
                                element: document.querySelector('.card-input-isi-memo'),
                                title: 'Isi Memo',
                                intro: 'Kolom Input Ini Merupakan Narasi / Isi Memo Internal yang dapat disampaikan'
                            },
                            {
                                element: document.querySelector('.card-input-lampiran-memo'),
                                title: 'Tambah Lampiran',
                                intro: 'Untuk Melakukan Tambah Lampiran Memo Internal Baru di PCNU Lazisnu Cilacap, Kolom Ini Tidak Wajib Diisi Jika Tidak Ada Lampiran Memo Yang Disertakan'
                            },
                            {
                                element: document.querySelector('.card-input-lampiran-lainnya-memo'),
                                title: 'Tambah Lampiran Lainnya',
                                intro: 'Jika lampiran > 1, Klik tombol ini untuk menampilkan form lampiran tambahan'
                            },
                            {
                                element: document.querySelector('.card-button-simpan-memo'),
                                title: 'Simpan Memo',
                                intro: 'Jika Sudah Dipastikan Semua Data Terisi Dengan Benar Maka Dapat Dilakukan Penyimpanan Data Dengan Menekan Tombol Simpan'
                            }
                        ]
                    }).setOption("dontShowAgain", value)
                    .setOption("skipLabel", "<p widht='100px' style='font-size:12px;color:blue;'><u>Lewati</u> </p>")
                    .setOption("dontShowAgainLabel", " Jangan Tampilkan Lagi")
                    .setOption("disableInteraction", true)
                    .setOption("nextLabel", "Lanjut")
                    .setOption("prevLabel", "Kembali")
                    .setOption("doneLabel", "Selesai")
                    .setOptions({
                        showProgress: true,
                    }).start();
            }

            $(document).ready(function() {
                klikkene(true);
                $("#panduan").click(function() {
                    klikkene(false);
                });
            });
        </script>
    @endpush

</div>
