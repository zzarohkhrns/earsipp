@extends('main')

@section('memo', 'active')


@section('css')
@section('content')


    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb m-0 pl-4">
                        <li class="breadcrumb-item active">
                            <a href="/{{ $role }}/dashboard">Dashboard</a> / <a
                                href="/{{ $role }}/arsip/memo">Memo Internal</a> / <a>{{ $page }}</a>
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


    <section class="content">
        <div class="container-fluid ">
            <!-- Form Element sizes -->
            @php
                $rul = strtolower($role);
            @endphp

            <div class="card card-success ">


                <div class="card-body ">
                    <!-- Form Element sizes -->
                    {{-- <form action="/{{ $role }}/arsip/proses_edit_surat_masuk/{{ $memo->id_memo }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT') --}}
                    <div class="card card-success ijo-atas">
                        <div class="row mt-4 ml-4 justify-content-between">
                            <div>
                                @if ($info == 'Diteruskan')
                                    <h3 class="card-title "><b>Rincian Memo Internal (Pembuat Memo)</b>
                                    </h3>
                                @else
                                    <h3 class="card-title "><b>Rincian Memo Internal (Penerima Memo)</b>
                                    </h3>
                                @endif


                            </div>
                            <div class="col-auto mr-3">

                                {{-- modal berita --}}
                                <div class="modal fade" id="staticTambah" data-backdrop="static" data-keyboard="false"
                                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title edit" id="staticBackdropLabel">Edit
                                                    Memo Internal</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <form method="post" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')

                                                <div class="modal-body mt-2">

                                                    <div class="form-row mt-4">
                                                        <div class="form-group col-md-6">
                                                            <label for="kepada">KEPADA
                                                                &nbsp;</label>
                                                            <sup class="badge badge-danger text-white mb-2"
                                                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                            <select class="select2 @error('kepada') is-invalid @enderror"
                                                                multiple="multiple"
                                                                data-placeholder="Masukan Hak Akses Arsip"
                                                                style="width: 100%;" name="kepada[]">


                                                                @foreach ($pengurus as $pengurus2)
                                                                    @php
                                                                        $jabatans = DB::connection('gocap')
                                                                            ->table('pengurus_jabatan')
                                                                            ->where('id_pengurus_jabatan', $pengurus2->id_pengurus_jabatan)
                                                                            ->select('jabatan')
                                                                            ->get();
                                                                    @endphp
                                                                    <option value="{{ $pengurus2->id_pc_pengurus }}"
                                                                        {{ in_array($pengurus2->id_pc_pengurus, $initPermissions) ? 'selected' : '' }}>
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
                                                        </div>

                                                        @php
                                                            $sifaz = DB::table('disposisi')
                                                                ->where('id_memo', $memo->id_memo)
                                                                ->first();
                                                            
                                                        @endphp

                                                        @if ($sifaz)
                                                            @php
                                                                $sifat = $sifaz->sifat;
                                                            @endphp

                                                            <input type="hidden" name="sifat"
                                                                value="{{ $sifat }}">
                                                        @endif
                                                        <div class="form-group col-md-6">
                                                            <label>HAL&nbsp;</label>
                                                            <sup class="badge badge-danger text-white mb-2"
                                                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                            <input type="text"class="form-control " name="hal"
                                                                placeholder="Masukan HAL Berita"
                                                                value="{{ $memo->hal }}">
                                                        </div>

                                                    </div>

                                                    <div class="form-group">
                                                        <label for="isi_memo">ISI MEMO &nbsp;</label>
                                                        <sup class="badge badge-danger text-white mb-2"
                                                            style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                        <textarea name="isi_memo" class="my-editor form-control" id="my-editor" cols="30" rows="10">
                                                                  {{ $memo->isi_memo }}
                                                              </textarea>
                                                    </div>


                                                    <div class="float-right mb-3 mt-2 bd-highlight">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal"><i class="fas fa-ban"></i>
                                                            Batal</button>

                                                        <button onclick="$('#cover-spin').show(0)"
                                                            formaction="/{{ $role }}/arsip/aksi_edit_memo/{{ $memo->id_memo }}"
                                                            class="btn btn-success text-white toastrDefaultSuccess"
                                                            type="submit"><i class="fas fa-save"></i> Simpan
                                                            Perubahan</button>
                                                    </div>
                                                </div>
                                            </form>


                                        </div>
                                    </div>
                                </div>

                                @if ($info == 'Diteruskan')
                                    <a class="btn btn-secondary  ml-1 mr-0 card-ubah-memo" type="button"
                                        data-toggle="modal" data-target="#staticTambah" aria-expanded="false">
                                        &nbsp;&nbsp;<i class="fas fa-edit"></i> Ubah
                                        Memo Internal
                                    </a>
                                @endif

                                <a href="/{{ $role }}/arsip/memo/{{ $memo->id_memo }}" type="button"
                                    class="btn btn-danger card-cetak-memo" target="_blank"> <i class="fas fa-print"></i>
                                    Cetak
                                    Memo Internal</a>
                            </div>
                            <!-- Button trigger modal -->

                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-6">

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Tanggal
                                            Memo</label>
                                        <div class="col-sm-8">
                                            <input type="date"
                                                class="form-control @error('tanggal_memo') is-invalid @enderror"
                                                name="tanggal_memo" placeholder="Tanggal Arsip"
                                                value="{{ $memo->tanggal_memo }}" readonly>
                                            @error('tanggal_memo')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                        </div>
                                    </div>




                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Nomor Memo</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="nomor_memo"
                                                placeholder="Masukan Nomor Memo" value="{{ $memo->nomor_memo }}"
                                                readonly>

                                        </div>
                                    </div>

                                    @if ($sifaz)
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Sifat Memo</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="sifat"
                                                    placeholder="Masukan Sifat Memo" value="{{ $disposisi->sifat }}"
                                                    readonly>

                                            </div>
                                        </div>
                                    @endif



                                    {{-- <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Sifat Disposisi</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" name="sifat"
                                                    data-placeholder="Masukan Klasifikasi Surat" required>
                                                    <option value="{{ $disposisi->sifat }}">Sifat Disposisi
                                                        {{ $disposisi->sifat }}
                                                    </option>
                                                    <option value="Segera">Segera</option>
                                                    <option value="Sangat Segera">Sangat Segera</option>
                                                    <option value="Rahasia">Rahasia</option>
                                                </select>

                                            </div>
                                        </div> --}}



                                </div>

                                <div class="col-lg-6 col-6">



                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Dibuat Oleh</label>
                                        <div class="col-sm-8">
                                            @php
                                                $jaba = DB::connection('gocap')
                                                    ->table('pengurus_jabatan')
                                                    ->where('id_pengurus_jabatan', $jabatan->id_pengurus_jabatan)
                                                    ->first();
                                            @endphp
                                            <input type="text"
                                                class="form-control @error('id_pengguna') is-invalid @enderror"
                                                name="id_pengguna"
                                                value="{{ $nama_pengurus->nama }} ({{ $jaba->jabatan }})" readonly>
                                            @error('id_pengguna')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                        </div>
                                    </div>


                                    {{-- <div class="form-group
                                                    row">
                                            <label class="col-sm-4 col-form-label">Lampiran</label>
                                            <div class="input-group col-sm-8">
                                                <input type="text" name="pengeluaran_kegiatan" id="pengeluaran_kegiatan"
                                                    class="form-control " placeholder="" value="{{ $lampiran_file }}"
                                                    disabled>
                                                <p class="input-group-text"
                                                    style=" width: 100px;height:37px;max-height:100%;">File</p>
                                            </div>

                                        </div> --}}

                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Hal</label>
                                        <div class="col-sm-8">
                                            <input class="form-control" type="text"
                                                name="hal"value="{{ $memo->hal }}" readonly>
                                        </div>
                                    </div>



                                    <div class="form-group row card-lihat-diajukan-memo">
                                        <label class="col-sm-4 col-form-label">Ditujukan Kepada</label>
                                        <div class="input-group col-sm-8 ">
                                            <input type="text" class="form-control"
                                                value="{{ $baca_internal_jumlah }} Orang" readonly>

                                            @if (DB::table('memo')->where('id_pengguna', Auth::user()->id_pengguna)->where('id_memo', $memo->id_memo)->first())
                                                {{-- pengirim --}}
                                                <div class="form-group row">

                                                    <div class="col-sm-8">

                                                        <button class="input-group btn btn-primary"
                                                            style=" width: 100px;height:37px;max-height:100%;"
                                                            data-toggle="modal" data-target="#statusbaca" type="button">
                                                            Lihat
                                                            Detail Status
                                                            Baca Disposisi
                                                        </button>
                                                    </div>
                                                </div>
                                            @else
                                                @php
                                                    
                                                    if (Auth::user()->gocap_id_upzis_pengurus != null) {
                                                        if ($disposisi->status_baca == '0') {
                                                            DB::table('disposisi')
                                                                ->where('id_memo', $id_memo)
                                                                ->where('id_pengurus_internal', Auth::user()->gocap_id_upzis_pengurus)
                                                                ->update([
                                                                    'status_baca' => '1',
                                                                ]);
                                                        }
                                                    } elseif (Auth::user()->gocap_id_pc_pengurus != null) {
                                                        if ($disposisi->status_baca == '0') {
                                                            DB::table('disposisi')
                                                                ->where('id_memo', $id_memo)
                                                                ->where('id_pengurus_internal', Auth::user()->gocap_id_pc_pengurus)
                                                                ->update([
                                                                    'status_baca' => '1',
                                                                ]);
                                                        }
                                                    }
                                                @endphp
                                                {{-- sudah dibaca --}}
                                                <div class="form-group row">

                                                    <div class="col-sm-8">
                                                        <a href="#" type="button" class="btn btn-success">
                                                            Dibaca</a>
                                                    </div>
                                                </div>
                                            @endif
                                            <!-- Modal -->
                                            <div class="modal fade bd-example-modal-lg" id="statusbaca" tabindex="-1"
                                                role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">
                                                                Status
                                                                Baca Memo</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <table id="example1" class="table table-bordered "
                                                                style="width:100%">
                                                                <thead>
                                                                    <tr>

                                                                        <th>Disposisi Surat</th>
                                                                        <th>Status Baca</th>
                                                                        <th>Notifikasi</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>


                                                                    @foreach ($baca_internal as $baca_internal)
                                                                        @php
                                                                            $jabatans = DB::connection('gocap')
                                                                                ->table('pengurus_jabatan')
                                                                                ->where('id_pengurus_jabatan', $baca_internal->id_pengurus_jabatan)
                                                                                ->select('jabatan')
                                                                                ->get();
                                                                        @endphp


                                                                        <tr>


                                                                            <td>{{ $baca_internal->nama }}
                                                                                @foreach ($jabatans as $item)
                                                                                    <span
                                                                                        class="badge rounded-pill  bg-danger">
                                                                                        {{ $item->jabatan }}
                                                                                    </span>
                                                                                @endforeach



                                                                            </td>

                                                                            {{-- <td>{{ $baca_internal->nama_jabatan }}
                                                                                                    </td> --}}

                                                                            @if ($baca_internal->status_baca == '0')
                                                                                @php
                                                                                    $stat = 'Belum Dibaca';
                                                                                    $warna = 'warning';
                                                                                    
                                                                                @endphp
                                                                            @else
                                                                                @php
                                                                                    $stat = 'Sudah Dibaca';
                                                                                    $warna = 'success';
                                                                                    
                                                                                @endphp
                                                                            @endif

                                                                            <td class="text-center"
                                                                                style="font-size:20px;">
                                                                                <span
                                                                                    class="badge badge-{{ $warna }} ">{{ $stat }}</span>
                                                                            </td>

                                                                            <td class="text-center">
                                                                                <form
                                                                                    action="{{ url('/' . $role . '/kirim_notifikasi_memo') }}"
                                                                                    method="post">

                                                                                    @csrf
                                                                                    <input type="hidden" name="nohp"
                                                                                        value="{{ $baca_internal->nohp }}">

                                                                                    <input type="hidden" name="nama"
                                                                                        value="{{ $baca_internal->nama }}">

                                                                                    <input type="hidden"
                                                                                        name="nomor_memo"
                                                                                        value="{{ $memo->nomor_memo }}">

                                                                                    <input type="hidden"
                                                                                        name="tanggal_memo"
                                                                                        value="{{ Carbon\Carbon::parse($memo->tanggal_memo)->isoFormat('D MMMM Y') }}">

                                                                                    <input type="hidden"
                                                                                        name="nama_pengirim"
                                                                                        value="{{ Auth::user()->nama }}">

                                                                                    <input type="hidden" name="hal"
                                                                                        value="{{ $memo->hal }}">

                                                                                    <button
                                                                                        onclick="$('#cover-spin').show(0)"
                                                                                        class="bg-success btn btn-success">
                                                                                        <i class="fab fa-whatsapp"></i>
                                                                                        Kirim</button>
                                                                                </form>

                                                                            </td>

                                                                        </tr>
                                                                    @endforeach



                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="modal-footer">
                                                            {{-- <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Tutup</button> --}}

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>




                                        </div>
                                    </div>



                                </div>


                            </div>

                            <div class="mb-3">
                                <label class="form-label">Isi Memo</label>
                                <table class="table table-sm table-bordered">
                                    <tr>
                                        <td class="text-justify" colspan="2" style="font-size:15px;">
                                            @php
                                                echo $memo->isi_memo;
                                            @endphp
                                        </td>

                                    </tr>
                                </table>

                            </div>



                            {{-- </form> --}}

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <!-- Form Element sizes -->


                    <!-- Form Element sizes -->
                    <div class="card ">

                        <style>
                            .nav-pills .nav-link.active,
                            .nav-pills .show>.nav-link {
                                background-color: green;
                            }
                        </style>


                        <div class="card ijo-atas">
                            <div class="tab-content">


                                <div class="active tab-pane" id="file">
                                    <!-- Post -->
                                    <div class="col-md-12 ">
                                        <!-- general form elements -->

                                        <div class="row mt-4 ml-4 justify-content-between">
                                            <div>
                                                <h3 class="card-title "><b>Lampiran Memo Internal</b>
                                                </h3>
                                            </div>
                                            <div class="col-auto mr-3">


                                                @if ($info == 'Diteruskan')
                                                    <button type="button"
                                                        class="btn btn-success card-tambah-lampiran-memo"
                                                        data-toggle="modal" data-target="#unggah">
                                                        <i class="fas fa-plus-circle" aria-hidden="true"></i> Tambah
                                                        Lampiran
                                                    </button>
                                                @endif
                                            </div>
                                            <!-- Button trigger modal -->

                                            {{-- <input type="hidden" name="pelaksana_kegiatan"> --}}
                                        </div>

                                        <div class="row  ml-4 justify-content-between">
                                            <div>

                                            </div>
                                            <div class="col-auto mr-3">
                                                <div class="col-auto">
                                                    <!-- Button trigger modal -->


                                                    <!-- Modal -->
                                                    <div class="modal fade" id="unggah" tabindex="-1" role="dialog"
                                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                                        Unggah File Lainnya</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form
                                                                    action="/{{ $role }}/arsip/aksi_tambah_file_memo/{{ $memo->id_memo }}"
                                                                    method="post" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="modal-body">
                                                                        <div class="form-group">

                                                                            <input type="hidden" name="arsip_digital_id"
                                                                                value="{{ $id_memo }}">

                                                                            <label>Nama</label>
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Masukan Judul" name="nama"
                                                                                id="nama">
                                                                        </div>



                                                                        <div class="form-group">
                                                                            <label>File</label>
                                                                            <input type="file"
                                                                                accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.xlsx"
                                                                                class="form-control" name="file_memo"
                                                                                id="file_memo">
                                                                        </div>


                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal"><i
                                                                                class="fas fa-ban"></i>
                                                                            Batal</button>
                                                                        <button type="submit" id="submits"
                                                                            class="btn btn-success"
                                                                            onclick="$('#cover-spin').show(0)"
                                                                            disabled="disabled"><i
                                                                                class="fas fa-save"></i>
                                                                            Simpan Lampiran</button>

                                                                        <script type="text/javascript">
                                                                            var file_memo = true;
                                                                            var nama = true;

                                                                            (function() {

                                                                                $('#nama').keyup(function() {
                                                                                    console.log($('#nama').val());
                                                                                    $('#nama').each(function() {
                                                                                        if ($(this).val() != '') {
                                                                                            nama = false;
                                                                                        } else {
                                                                                            nama = true;
                                                                                        }
                                                                                        myfung();
                                                                                    });
                                                                                });


                                                                                $('#file_memo').on('change', function() {
                                                                                    console.log($('#file_memo').val());
                                                                                    if ($('#file_memo').val() != '') {
                                                                                        file_memo = false;
                                                                                    } else {
                                                                                        file_memo = true;
                                                                                    }
                                                                                    myfung();
                                                                                    // console.log()
                                                                                });

                                                                            })()

                                                                            function myfung() {
                                                                                if (nama == true || file_memo == true) {
                                                                                    $('#submits').attr('disabled', 'disabled');
                                                                                } else {
                                                                                    $('#submits').removeAttr('disabled');
                                                                                }
                                                                            }
                                                                        </script>
                                                                    </div>


                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>


                                        <div class="card-body">

                                            <table id="example3" class="table table-bordered " style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Judul</th>

                                                        <th>Waktu Upload</th>
                                                        <th>Aksi</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($lampiran as $lam)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $lam->nama }}</td>

                                                            <td>{{ $lam->created_at }}</td>
                                                            <td>
                                                                <!-- Example split danger button -->
                                                                <div class="btn-group">

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

                                                                        @if ($info == 'Diteruskan')
                                                                            <a onMouseOver="this.style.color='red'"
                                                                                onMouseOut="this.style.color='black'"
                                                                                class="dropdown-item" type="button"
                                                                                data-target="#edit_lampiran{{ $lam->id_file_memo }}"
                                                                                data-toggle="modal">
                                                                                <i class="fas fa-edit"></i> Ubah</a>
                                                                            <!-- Modal -->
                                                                        @endif

                                                                        <a onMouseOver="this.style.color='red'"
                                                                            onMouseOut="this.style.color='black'"
                                                                            class="dropdown-item"
                                                                            href="{{ asset('file_memo/' . $lam->file . '') }}"
                                                                            type="button" target="_blank">
                                                                            <i class="fas fa-print"></i> Cetak</a>

                                                                        @if ($info == 'Diteruskan')
                                                                            <a onMouseOver="this.style.color='red'"
                                                                                style=""
                                                                                onMouseOut="this.style.color='black'"
                                                                                class="dropdown-item" type="button"
                                                                                data-target="#modal_hapus{{ $lam->id_file_memo }}"
                                                                                data-toggle="modal"><i
                                                                                    class="fas fa-trash"></i>
                                                                                Hapus</a>
                                                                        @endif


                                                                    </div>

                                                            </td>

                                                            {{-- modal hapus --}}
                                                            <div class="modal fade"
                                                                id="modal_hapus{{ $lam->id_file_memo }}" role="dialog"
                                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <form
                                                                            action="/{{ $role }}/arsip/aksi_hapus_file_memo/{{ $lam->id_file_memo }}"
                                                                            method="post">
                                                                            @csrf
                                                                            <div class="modal-header">

                                                                                <h5 class="modal-title"
                                                                                    id="exampleModalLabel">
                                                                                    Konfirmasi
                                                                                    Hapus
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

                                                        <div class="modal fade"
                                                            id="edit_lampiran{{ $lam->id_file_memo }}" role="dialog"
                                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                                            Edit File Memo Internal</h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <form
                                                                        action="/{{ $role }}/arsip/aksi_edit_file_memo/{{ $lam->id_file_memo }}"
                                                                        method="post" enctype="multipart/form-data">
                                                                        @csrf
                                                                        <div class="modal-body">
                                                                            <div class="form-group">

                                                                                <label>Nama</label>
                                                                                <input value="{{ $lam->nama }}"
                                                                                    type="text" class="form-control"
                                                                                    placeholder="Masukan Judul"
                                                                                    name="nama" required>
                                                                            </div>

                                                                            <input type="hidden" name="file_lama"
                                                                                value="{{ $lam->file }}">


                                                                            <div class="form-group">
                                                                                <label>File</label> &nbsp;<sup
                                                                                    class="badge badge-danger text-white mb-2"
                                                                                    style="background-color:rgb(82, 166, 230)">ABAIKAN
                                                                                    JIKA TIDAK ADA
                                                                                    PERUBAHAN (JPG/JPEG/PNG)</sup>
                                                                                <input type="file" class="form-control"
                                                                                    name="file_memo">
                                                                            </div>


                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-dismiss="modal"><i
                                                                                    class="fas fa-ban"></i>
                                                                                Batal</button>
                                                                            <button type="submit" name="submit"
                                                                                onclick="$('#cover-spin').show(0)"
                                                                                class="btn btn-success"><i
                                                                                    class="fas fa-save"></i>
                                                                                Simpan Lampiran </button>
                                                                        </div>

                                                                    </form>

                                                                </div>
                                                            </div>
                                                        </div>


                                        </div>
                                        @endforeach

                                        </thead>



                                        </table>

                                    </div>



                                </div>



                            </div>
                        </div>

                        <!-- ---------------------- -->


                        <!-- /Post -->

                    </div>

                </div>
                <!-- /.tab-content -->

    </section>

@endsection

@section('js')

    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script>
        var options = {
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
        };
    </script>
    <script>
        CKEDITOR.replace('my-editor', options);
    </script>

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

    @push('intro_detail_memo')
        @if ($info == 'Diteruskan')
            <script>
                function klikkene(value) {
                    introJs().setOptions({
                            steps: [{
                                    element: document.querySelector('.card-ubah-memo'),
                                    title: 'Ubah Memo Internal',
                                    intro: 'Klik disini untuk mengubah Memo Internal '
                                },
                                {
                                    element: document.querySelector('.card-cetak-memo'),
                                    title: 'Cetak Memo Internal',
                                    intro: 'Klik disini untuk mencetak PDF Memo Internal '
                                },
                                {
                                    element: document.querySelector('.card-lihat-diajukan-memo'),
                                    title: 'Ditujukan Kepada',
                                    intro: 'Untuk Melihat Detail Penerima Memo Internal Dapat Dilihat Dengan Menekan Tombol Lihat'
                                },
                                {
                                    element: document.querySelector('.card-tambah-lampiran-memo'),
                                    title: 'Tambah Lampiran',
                                    intro: 'Klik disini untuk menambah lampiran memo internal'
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
        @else
            <script>
                function klikkene(value) {
                    introJs().setOptions({
                            steps: [{
                                    element: document.querySelector('.card-cetak-memo'),
                                    title: 'Cetak Memo Internal',
                                    intro: 'Klik disini untuk mencetak PPDF Memo Internal'
                                },
                                {
                                    element: document.querySelector('.card-lihat-diajukan-memo'),
                                    title: 'Ditujukan Kepada',
                                    intro: 'Untuk Melihat Detail Penerima Memo Internal Dapat Dilihat Dengan Menekan Tombol Lihat'
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
        @endif
    @endpush


@endsection
