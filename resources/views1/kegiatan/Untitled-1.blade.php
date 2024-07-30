<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
            @if ($page == 'zakatfitrah')
                @include('chart.ChartZakatFitrah')
            @elseif ($page == 'zakatmal')
                @include('chart.ChartZakatMal')
            @elseif ($page == 'infaq')
                @include('chart.ChartInfaq')
            @elseif ($page == 'wakaf')
                @include('chart.ChartWakaf')
            @elseif ($page == 'qurban')
                @include('chart.ChartQurban')
            @endif
        </div>
</section>


<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                {{-- <div class="card card-outline card-success mb-0 pb-0"> --}}
                <div class="card card-outline card-success mb-0 pb-0">
                    <div class="card-body">
                        <div class="row mb-0 pb-0 pl-0">
                            <strong class="col-3 pr-0 d-highlight pr-0 mr-0 mb-3">
                                <b class="text-success">DATA PENERIMAAN <br></b>
                            </strong>
                            <div class="col">
                                <div class="card  mb-0 pt-0">
                                    <div class="card-body">
                                        {{-- <form action="{{ route('filter') }}" method="GET"> --}}
                                        <div class="filter row ">
                                            {{-- <div class="col-10  mr-4 "> --}}
                                            @if ($page == 'zakatfitrah')
                                                <select class="col mx-1 form-control mr-2" name=""
                                                    id="kategori-select">
                                                    <option value="" disabled selected hidden>Pilih periode
                                                        tahun
                                                    </option>
                                                    {{-- <option value="{{ $data->tahun_masehi }} / {{ $data->tahun_hijriah }}">{{ $data->tahun_masehi }} / {{ $data->tahun_hijriah }}</option>
                                                        <option value="{{ $data->tahun_masehi }} / {{ $data->tahun_hijriah }}">{{ $data->tahun_masehi }} / {{ $data->tahun_hijriah }}</option> --}}
                                                    {{-- @foreach ($get_hrg_brs as $item)
                                                            <option value="{{ $item->id }}">{{ $item->tahun_masehi }} /
                                                                {{ $item->tahun_hijriah }}</option>
                                                        @endforeach --}}
                                                </select>
                                                <select class="col mx-1 form-control mr-2" name=""
                                                    id="kategori-zakat">
                                                    <option value="" disabled selected hidden>Pilih bentuk
                                                        zakat
                                                    </option>
                                                    <option value="">Semua data</option>
                                                    <option value="Beras">Beras</option>
                                                    <option value="Uang">Uang</option>
                                                </select>
                                            @endif

                                            <div class="col-sm-0 mt-0  ml-1 mb-2 mb-xl-0">
                                                <a class="btn btn btn-block btn-success text-sm" href=""
                                                    role="button"><i class="fas fa-search"></i></a>
                                            </div>

                                            <div class="col col-md-2 col-sm-12 mt-0 pr-0 bt-lg mb-2 mb-xl-0">
                                                <a class="btn btn btn-success btn-block text-sm font-weight-bold left-icon-holder"
                                                    data-toggle="dropdown" aria-expanded="false"><i
                                                        class="fas fa-plus-circle" href=""
                                                        aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;Tambah</a>
                                                <div class="dropdown-menu">


                                                    <a class="dropdown-item" data-toggle="modal"
                                                        data-target="#tambahModal" href="#"><i
                                                            class="fas fa-plus-circle"
                                                            aria-hidden="true"></i>&nbsp;&nbsp;Tambah Data</a>
                                                    <div role="separator" class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="/hargaBeras"><i
                                                            class="fas fa-cog"></i>&nbsp;&nbsp; Pengaturan
                                                    </a>

                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                        <nav class="navbar navbar-expand-sm">
                            <div class="collapse navbar-collapse" id="navbarScroll">
                                <ul class="navbar-nav mr-auto my-2 my-sm-0 navbar-nav-scroll" style="max-height: 50px;">
                                    <div class="row">
                                        <small class="align-self-center">Show &nbsp;</small>
                                        <li class="nav-item mx-1 p-0">
                                            <div class="dataTables_length" id="example_length">
                                                <select name="example_length" aria-controls="example_length"
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
                                <form class="d-flex">
                                    <div class="input-group mr-12">
                                        <form class="form" method="GET" action="">
                                            <input type="search" class="form-control form-control-sm"
                                                placeholder="Search" value="" name="cari" id="cari">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-sm btn-default">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </form>
                            </div>
                        </nav>

                        <div class="modal fade" id="tambahModal" data-backdrop="static" data-keyboard="false"
                            aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">

                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <form action="" method="post" enctype="multipart/form-data"
                                        id="zakat">
                                        {{ csrf_field() }}
                                        <div class="modal-body">
                                            <nav>
                                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                    <button class="nav-link text-success active" id="satu"
                                                        data-toggle="tab" data-target="#nav-satu-tab" type="button"
                                                        role="tab" aria-controls="nav-satu-tab"
                                                        aria-selected="true">Data
                                                        Penyetor</button>
                                                    <button class="nav-link text-success disabled" id="dua"
                                                        data-toggle="tab" data-target="#nav-dua-tab" type="button"
                                                        role="tab" aria-controls="nav-dua-tab"
                                                        aria-selected="false">Data
                                                        Zakat Fitrah</button>
                                                </div>
                                            </nav>

                                            <div class="tab-content mt-1">
                                                <div class="tab-pane fade show active" id="nav-satu-tab"
                                                    role="tabpanel" aria-labelledby="nav-satu-tab">

                                                    <span class="mt-4 mb-3 d-flex justify-content-center">
                                                        1. Cari dan Pilih Data Penyetor
                                                    </span>

                                                    <div id="form-lama">
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label for="cariNPWZ">NPWZ &nbsp;</label>
                                                                <sup class="badge badge-danger text-white mb-2"
                                                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                                <input type="text" class="form-control d-none"
                                                                    id="crNPWZ1" name="npwz"
                                                                    placeholder="Cari muzaki lama berdasarkan npwz"
                                                                    value=""
                                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..?)\../g, '$1');">
                                                                <select id="crNPWZ" class="form-control"></select>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="cariPekerjaan">NAMA &nbsp;</label>
                                                                <sup class="badge badge-danger text-white mb-2"
                                                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                                <input type="text" class="form-control d-none"
                                                                    id="crNama1" name="nama"
                                                                    placeholder="Cari muzaki lama berdasarkan nama"
                                                                    value="">
                                                                <select id="crNama" class="form-control"></select>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label for="cariHP">NO HP &nbsp;</label>
                                                                <sup class="badge badge-danger text-white mb-2"
                                                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                                <input type="text" class="form-control d-none"
                                                                    id="crNoHP1" name="no_hp"
                                                                    placeholder="Cari muzaki lama berdasarkan no hp"
                                                                    value=""
                                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..?)\../g, '$1');">
                                                                <select id="crNoHP" class="form-control"
                                                                    value=""></select>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="cariAlamat">ALAMAT &nbsp;</label>
                                                                <input type="text" class="form-control"
                                                                    id="crAlamat" name="alamat" value=""
                                                                    readonly>
                                                            </div>
                                                        </div>

                                                        <div class="d-flex bd-highlight justify-content-end mt-3 mb-3">
                                                            <div class="p-2 bd-highlight">
                                                                <button type="button"
                                                                    class="btn btn-primary text-white"
                                                                    style="background-color: #3F8EFC" id="sl1"
                                                                    onclick="validasiForm()">Selanjutnya</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Data Zakat/Infaq/Shodaqoh --}}
                                                <div class="tab-pane fade" id="nav-dua-tab" role="tabpanel"
                                                    aria-labelledby="nav-dua-tab">
                                                    {{-- Form --}}
                                                    <div>
                                                        <div class="mt-4">
                                                            <span class="mt-4 mb-3 d-flex justify-content-center">
                                                                2. Isi Data Penerimaan Zakat Fitrah
                                                            </span>
                                                            <div class="form-row">
                                                                <div class="form-group col-md-6 mb-0">
                                                                    <label for="inputFitrah">BENTUK ZAKAT
                                                                        &nbsp;</label>
                                                                    <sup class="badge badge-danger text-white mb-2"
                                                                        style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                                    <select class="form-control"
                                                                        name="fitrah_bentuk_zakat" id="jenisFitrah">

                                                                        <option value="">Pilih bentuk zakat
                                                                        </option>
                                                                        <option value="Beras">Beras</option>
                                                                        <option value="Uang">Uang</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-6 mb-0">
                                                                    <label for="inputtanggungan">JUMLAH MUZAKI
                                                                        &nbsp;</label>
                                                                    <sup class="badge badge-danger text-white mb-2"
                                                                        style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                                    <div class="input-group mb-3">
                                                                        <input type="text" class="form-control"
                                                                            id="fitrah_jumlah_muzaki"
                                                                            name="fitrah_jumlah_muzaki"
                                                                            placeholder="Isi dengan jumlah orang yang berzakat"
                                                                            value=""
                                                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..?)\../g, '$1');">
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text"><i
                                                                                    class="nav-icon fas fa-users"></i></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-row">
                                                            <div class="form-group col-md-6 mb-0">
                                                                <label for="cariHarga">HARGA BERAS &nbsp;</label>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Rp</span>
                                                                    </div>
                                                                    <input type="text" class="form-control"
                                                                        id="hargaBeras" name="harga_beras"
                                                                        value="" readonly>
                                                                </div>
                                                            </div>

                                                            <div class="form-group col-md-6 mb-0">
                                                                <label for="inputTotal">TOTAL ZAKAT &nbsp;</label>
                                                                <div class="input-group mb-3">
                                                                    <input type="text" class="form-control"
                                                                        id="fitrah_total_zakat"
                                                                        name="fitrah_total_zakat" value=""
                                                                        readonly>
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text">Kg</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6 mb-0">
                                                                <label for="inputNominal">TOTAL NOMINAL &nbsp;</label>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Rp</span>
                                                                    </div>
                                                                    <input type="text" class="form-control"
                                                                        id="ziswaf_nominal_rupiah"
                                                                        name="ziswaf_nominal_rupiah"
                                                                        value="
                                                                        {{-- {{ number_format($number_string, 2, ',', '.') }} --}}
                                                                        "readonly>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-6 mb-0">
                                                                <label for="inputPembayaran">PEMBAYARAN &nbsp;</label>
                                                                <sup class="badge badge-danger text-white mb-2"
                                                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                                <select class="form-control ziswaf_metode_bayar"
                                                                    name="ziswaf_metode_bayar"
                                                                    id="ziswaf_metode_bayar">
                                                                    <option value="">Pilih jenis pembayaran
                                                                    </option>
                                                                    <option value="Langsung FO">Langsung FO</option>
                                                                    <option value="Transfer">Transfer</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-row" id='harus-langsung'>
                                                            <div class="form-group col-md-6 mb-3">
                                                                <label for="inputNominal">NAMA BANK &nbsp;</label>
                                                                <sup class="badge badge-danger text-white mb-2"
                                                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                                <select class=" select2 form-control"
                                                                    name="ziswaf_nama_bank" id="ziswaf_nama_bank">
                                                                    <option value="">Pilih nama bank</option>
                                                                    <option value="Bank BNI">Bank BNI</option>
                                                                    <option value="Bank BRI">Bank BRI</option>
                                                                    <option value="Bank MANDIRI">Bank MANDIRI</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-6 mb-3">
                                                                <label for="inputPembayaran">NOMOR REKENING
                                                                    &nbsp;</label>
                                                                <sup class="badge badge-danger text-white mb-2"
                                                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                                <input type="text" class="form-control"
                                                                    id="ziswaf_nomor_rekening"
                                                                    name="ziswaf_nomor_rekening" value="">
                                                            </div>
                                                        </div>


                                                        <div class="form-row nama_rekeningdiv">
                                                            <div class="form-group col-md-6 mb-0">
                                                                <label for="inputPembayaran">REKENING TUJUAN
                                                                    &nbsp;</label>
                                                                <sup class="badge badge-danger text-white mb-2"
                                                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                                <select class=" select2 nama_rekening form-control"
                                                                    name="nama_rekening" id="nama_rekening">
                                                                    <option value="">Pilih rekening tujuan
                                                                    </option>

                                                                </select>
                                                            </div>


                                                            <div class="form-group col-md-6 mb-0">
                                                                <label for="inputBukti">BUKTI TRANSFER &nbsp;</label>
                                                                <sup class="badge badge-danger text-white mb-2"
                                                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                                <div class="input-group mb-3">
                                                                    <div class="custom-file">
                                                                        <input type="file"
                                                                            class="custom-file-input ziswaf_bukti_transfer"
                                                                            id="customFileInput"
                                                                            accept="images/png, images/gif, images/jpeg, images/pdf"
                                                                            aria-describedby="customFileInput"
                                                                            name="ziswaf_bukti_transfer">
                                                                        <label class="custom-file-label"
                                                                            for="customFileInput"
                                                                            aria-describedby="customFileInput">Pilih
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        {{-- <div class="form-group">
                                                                <label for="inputKeterangan">DAFTAR NAMA MUZAKI&nbsp;</label>
                                                                <sup class="badge badge-danger text-white mb-2"
                                                                    style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                                <textarea name="ziswaf_keterangan" id="inptketerangan" class="form-control" cols="30" rows="5"
                                                                    placeholder="Isi dengan catatan atau daftar nama orang yang berzakat&#10;Contoh :&#10;1. Zaroh Khoerunisa&#10;2. Nurul Annisa&#10;"></textarea>
                                                                <input type="text" class="select2 form-control" id="inptketerangan"
                                                                    name="ziswaf_keterangan" value="">
                                                                    <input type="text" class="inptAtasnama form-control" name="fitrah_atas_nama"
                                                                    id="inptAtasnama" placeholder="Masukan data nama orang yang berzakat"
                                                                    data-role="tagsinput" value="">
                                                            </div> --}}

                                                        <div class="form-group">
                                                            <label for="inputKeterangan">DAFTAR NAMA
                                                                MUZAKI&nbsp;</label>
                                                            <sup class="badge badge-danger text-white"
                                                                style="background-color:rgba(230,82,82)">WAJIB</sup>
                                                            @csrf
                                                            <input type="text" class="inptNamaMuzaki form-control"
                                                                name="fitrah_atas_nama" id="inptNamaMuzaki"
                                                                placeholder="Masukan data nama orang yang berzakat"
                                                                data-role="tagsinput" value="">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="inputKeterangan">KETERANGAN &nbsp;</label>
                                                            <textarea type="text" class="form-control" name="ziswaf_keterangan" id="inptketerangan"
                                                                placeholder="Silahkan diisi jika ada catatan" value=""></textarea>
                                                        </div>

                                                        <div class="d-flex bd-highlight justify-content-end mt-3 mb-3">
                                                            <div class="p-2 bd-highlight">
                                                                <button type="button" class="btn text-white"
                                                                    onclick="document.getElementById('nav-satu-tab').click()"
                                                                    style="background-color: #7F828D"
                                                                    id="sbl">Sebelumnya</button>
                                                            </div>
                                                            <div class="p-2 bd-highlight">
                                                                <button type="submit"
                                                                    class="btn btn-primary text-white toastrDefaultSuccess"
                                                                    value="submit" id="btn_simpan"
                                                                    style="background-color: #3F8EFC">Simpan</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>




                                </div>
                            </div>
                        </div>

                        
                        <table id="example2" class="table table-bordered table-hover dataTable dtr-inline">
                            <thead>
                                <tr>

                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
                {{-- </div> --}}
            </div>
        </div>
    </div>
</section>
