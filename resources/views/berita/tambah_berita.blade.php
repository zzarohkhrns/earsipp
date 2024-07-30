@extends('main')

@section('berita', 'active')
@section('berita_ac', 'active menu-open')
@section('berita_mo', 'menu-open')


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
                                href="/{{ $role }}/arsip/berita">Berita Umum</a> / <a>{{ $page }}</a>
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
    <!-- /.content-header -->

    <section class="content">
        <div class="container-fluid ">
            <!-- Form Element sizes -->
            @php
                $rul = strtolower($role);
            @endphp


            <form method="post" action="/{{ $role }}/aksi_tambah_berita" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="role" value="{{ $role }}">

                <div class="card card-success ">

                    <div class="card-body">
                        <!-- Form Element sizes -->
                        <div class="card card-success ijo-atas">
                            <div class="row mt-4 ml-4 justify-content-between">
                                <div>
                                    <h3 class="card-title "><b>Rincian Berita Umum</b> &nbsp;
                                    </h3> <span class="information-content">
                                        <a href="#" class="sweet-tooltip" data-style-tooltip="tooltip-mini-slick"
                                            data-text-tooltip=" Lorem ipsum, dolor sit amet  <br> consectetur  <br> adipisicing elit. Facere
                                               , asperiores ullam  <br> esse quibusdam recusandae <br>  libero explicabo inventore  <br> sit dolore iure. "><i
                                                class="far fa-question-circle"></i></a>
                                    </span>
                                </div>
                                <!-- Button trigger modal -->
                                <div class="col-auto mr-3">
                                </div>
                                <input type="hidden" name="pelaksana_kegiatan">
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6 col-6">

                                        <div class="form-group row input-tgl-terbit-berita-umum">
                                            <label class="col-sm-4 col-form-label">Tanggal
                                                Terbit</label>
                                            <div class="col-sm-8 ">
                                                <input type="date" wire:model="tanggal_terbit"
                                                    class="form-control  @error('tanggal_terbit') is-invalid @enderror"
                                                    name="tanggal_terbit" placeholder="Tanggal Arsip"
                                                    value="{{ old('tanggal_terbit') }}">
                                                @error('tanggal_terbit')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row input-kategori-berita-umum">
                                            <label class="col-sm-4 col-form-label">Kategori Berita</label>
                                            <div class="col-sm-8 ">

                                                <select class="form-control @error('kategori_berita') is-invalid @enderror"
                                                    name="kategori_berita" data-placeholder="Masukan Klasifikasi Surat"
                                                    value="{{ old('kategori_berita') }}">
                                                    @if (old('kategori_berita'))
                                                        <option value="{{ old('kategori_berita') }}" selected hidden>
                                                            {{ old('kategori_berita') }}
                                                        </option>
                                                    @else
                                                        <option value="" selected hidden>Pilih Kategori Berita
                                                        </option>
                                                    @endif
                                                    @foreach ($kategori_berita as $kategoris)
                                                        <option value="{{ $kategoris->nama_kategori }}">
                                                            {{ $kategoris->nama_kategori }}</option>
                                                    @endforeach
                                                </select>

                                                @error('kategori_berita')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>


                                    </div>




                                    <div class="col-lg-6 col-6">



                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Judul Berita</label>
                                            <div class="col-sm-8">
                                                <input type="text" wire:model="judul_berita"
                                                    class="form-control @error('judul_berita') is-invalid @enderror"
                                                    name="judul_berita" placeholder="Masukan Judul Berita"
                                                    value="{{ old('judul_berita') }}">
                                                @error('judul_berita')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                            </div>
                                        </div>

                                        <div class="form-group row input-tag-berita-umum" wire:ignore>
                                            <label class="col-sm-4 col-form-label">Hastag Berita</label>
                                            <div class="col-sm-8 ">
                                                <input
                                                    type="text"class="form-control  @error('hastag_berita') is-invalid @enderror"
                                                    name="hastag_berita[]" id="tags" placeholder="Masukan Tag Berita"
                                                    data-role="tagsinput">

                                                @error('hastag_berita')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                {{-- disini --}}
                                <div class="mb-3 input-isi-berita-umum" wire:ignore>
                                    <label for="desc" class="form-label">Isi Berita</label>
                                    <textarea name="narasi_berita" class="my-editor form-control @error('narasi_berita') is-invalid @enderror"
                                        id="my-editor" cols="30" rows="10">{{ old('narasi_berita') }}</textarea>
                                    @error('narasi_berita')
                                        <span
                                            style="color: #dc3545;font-weight: bolder;
                                        font-size: 100%;">
                                            Narasi Berita harus diisi</span>
                                    @enderror
                                </div>





                            </div>
                        </div>




                        <!-- /.card -->
                        {{-- LAMPIRAN --}}
                        <div class="card card-success ijo-atas card-upload-file-berita-umum">
                            <div class="row mt-4 ml-4 justify-content-between">
                                <div>
                                    <h3 class="card-title "><b>Upload Foto Berita</b>
                                    </h3>
                                    &nbsp; <a href="#" class="sweet-tooltip" data-style-tooltip="tooltip-mini-slick"
                                        data-text-tooltip=" Lorem ipsum, dolor sit amet  <br> consectetur  <br> adipisicing elit. Facere
                               , asperiores ullam  <br> esse quibusdam recusandae <br>  libero explicabo inventore  <br> sit dolore iure. "><i
                                            class="far fa-question-circle"></i></a>
                                </div>

                                <div class="col-auto mr-3">

                                    <button id="addRow" type="button"
                                        class="btn btn-primary card-tambah-lampiran-berita-umum"> <i
                                            class="fas fa-plus-circle" aria-hidden="true"></i> Tambah
                                        Lampiran</button>
                                </div>

                            </div>

                            <div class="card-body mr-3 ml-3">

                                <div class="form-group row ">

                                    <label> Silahkan pilih Background Berita UMUM ,
                                        Jenis File yang diijinkan adalah: <b> jpg, png, jpeg,
                                            png</b></label>
                                </div>

                                <div class="form-group row ">
                                    <label class="text-danger">*Jika Foto Dokumentasi tidak ada maka tidak perlu
                                        dilampirkan</label>
                                </div>

                                <div class="form-group row ">

                                    <label class="col-sm-4 col-form-label">
                                        File Foto Background </label>
                                    <input style="width: 100%;" class="form-control" class="form-control m-input"
                                        type="text" name="judul_file_bg" placeholder="Masukan Judul File Background">



                                </div>
                                <div class="form-group row ">

                                    <input style="width: 100%;" class="form-control" class="form-control m-input"
                                        type="file" name="foto_background_berita" accept=".jpg,.jpeg,.png">
                                </div>

                                <div class="form-group row ">

                                    <label class="col-sm-4 col-form-label">
                                        File Foto Dokumentasi </label>
                                    <input style="width: 100%;" class="form-control" class="form-control m-input"
                                        type="text" name="judul_file_doc"
                                        placeholder="Masukan Judul File Dokumentasi">



                                </div>



                                <div class="form-group row ">

                                    <input style="width: 100%;" class="form-control" class="form-control m-input"
                                        type="file" name="foto_dokumentasi_berita" accept=".jpg,.jpeg,.png">
                                </div>




                                {{-- <link rel="stylesheet"
                                        href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
                                    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> --}}


                                <div id="newRow"></div>


                                <script type="text/javascript">
                                    // add row

                                    $("#addRow").click(function() {

                                        var html = '';

                                        html += '<div id="inputFormRow1">';
                                        html += '<label class="col-form-label">File Foto Dokumentasi</label > ';
                                        html += '<div class="form-group row">';
                                        html +=
                                            '<input type="text" name="judul_files[]" class="form-control " placeholder="Masukan Judul Lampiran" autocomplete="off">';

                                        html += '</div>';
                                        html += '<div class="form-group row " >';
                                        html += '<div class="input-group" id="inputFormRow">';
                                        html +=
                                            '<input  type="file" name="foto_dokumentasi_beritas[]" accept=".jpg,.jpeg,.png" class="form-control " placeholder="Masukan Judul Lampiran" autocomplete="off">' +
                                            '<div class="input-group-append">' +
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
                        <!-- /.LAMPIRAN -->
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



                            <button onclick="$('#cover-spin').show(0)" type="submit"
                                class="btn btn-success card-simpan-berita-umum" name="submit">
                                <i class="fas fa-save"></i> Simpan

                            </button>





                        </div>
                    </div>
                </div>
            </form>


    </section>


    @push('custom-scripts')
        {{-- ada disposisi atau tidak --}}
        <script>
            $(document).ready(function() {
                document.getElementById('disposisi-card').style.display = 'none';
                document.getElementById('sppd-card').style.display = 'none';
            });
            document.getElementById('tombol-disposisi1').addEventListener('change', function() {
                console.log(this.value);
                if (this.checked) {
                    document.getElementById('tombol-disposisi2').checked = false;
                    document.getElementById('disposisi-card').style.display = 'block';

                }
            });
            document.getElementById('tombol-disposisi2').addEventListener('change', function() {
                console.log(this.value);
                if (this.checked) {
                    document.getElementById('tombol-disposisi1').checked = false;
                    // document.getElementById('tombol-sppd2').checked = true;
                    // document.getElementById('tombol-sppd1').checked = false;
                    document.getElementById('sppd1actv1').classList.remove('active');
                    document.getElementById('sppd1actv2').classList.add('active');
                    document.getElementById('sppd-card').style.display = 'none';
                    document.getElementById('disposisi-card').style.display = 'none';
                    document.getElementById('sppd-card').style.display = 'none';
                }
            });
        </script>
        <script>
            $(document).ready(function() {
                document.getElementById('sppd-card').style.display = 'none';
            });
            document.getElementById('tombol-sppd1').addEventListener('change', function() {
                console.log(this.value);
                if (this.checked) {
                    document.getElementById('tombol-sppd2').checked = false;

                    document.getElementById('sppd-card').style.display = 'block';
                }
            });
            document.getElementById('tombol-sppd2').addEventListener('change', function() {
                console.log(this.value);
                if (this.checked) {
                    document.getElementById('tombol-sppd1').checked = false;

                    document.getElementById('sppd-card').style.display = 'none';
                }
            });
        </script>

        <script>
            var harga = document.getElementById('anggaran');
            harga.addEventListener('keyup', function(e) {
                harga.value = formatRupiah(this.value, '');
            });

            function formatRupiah(angka, prefix) {
                var number_string = angka.replace(/[^,\d]/g, '').toString(),
                    split = number_string.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
            }
        </script>

        {{-- <script>
        $(document).ready(function() {
            $("#pilihan").change(function() {
                if ($(this).val() == "Biasa") {
                    $('#uji').val(
                        '{{ $s->nama_pembuat_surat_pcnu }}' + "/A.I/" +
                        '{{ $s->kode_pembuat_surat_pcnu }}' +
                        "/" +
                        '{{ $bulan }}' + "/" + '{{ $year }}');
                } else if ($(this).val() == "Khusus") {
                    $('#uji').val(
                        '{{ $s->nama_pembuat_surat_pcnu }}' + "/A.II/" +
                        '{{ $s->kode_pembuat_surat_pcnu }}' +
                        "/" +
                        '{{ $bulan }}' + "/" + '{{ $year }}');
                }

            });

        });
    </script> --}}


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






        {{-- golongan atau satuan --}}
        <script>
            $(document).ready(function() {
                document.getElementById('select2-golongan').style.display = 'none';
                document.getElementById('select2-internal').style.display = 'none';


            });
            document.getElementById('tombol-jenis-disposisi1').addEventListener('change', function() {
                console.log(this.value);
                if (this.checked) {
                    document.getElementById('tombol-jenis-disposisi3').checked = false;
                    document.getElementById('tombol-jenis-disposisi2').checked = false;
                    document.getElementById('select2-satuan_mwcnu').style.display = 'block';
                    document.getElementById('select2-satuan_lembaga').style.display = 'block';
                    document.getElementById('select2-internal').style.display = 'none';
                    document.getElementById('select2-golongan').style.display = 'none';
                }
            });
            document.getElementById('tombol-jenis-disposisi2').addEventListener('change', function() {
                console.log(this.value);
                if (this.checked) {
                    document.getElementById('tombol-jenis-disposisi1').checked = false;
                    document.getElementById('tombol-jenis-disposisi3').checked = false;
                    document.getElementById('select2-satuan_mwcnu').style.display = 'none';
                    document.getElementById('select2-satuan_lembaga').style.display = 'none';
                    document.getElementById('select2-internal').style.display = 'none';
                    document.getElementById('select2-golongan').style.display = 'block';
                }
            });
            document.getElementById('tombol-jenis-disposisi3').addEventListener('change', function() {
                console.log(this.value);
                if (this.checked) {
                    document.getElementById('tombol-jenis-disposisi1').checked = false;
                    document.getElementById('tombol-jenis-disposisi2').checked = false;
                    document.getElementById('select2-satuan_lembaga').style.display = 'none';
                    document.getElementById('select2-satuan_mwcnu').style.display = 'none';
                    document.getElementById('select2-golongan').style.display = 'none';
                    document.getElementById('select2-internal').style.display = 'block';
                }
            });
        </script>
    @endpush

@endsection

@section('js')


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




@endsection


@push('custom-scripts')
    {{-- ada disposisi atau tidak --}}


    <script>
        $(document).ready(function() {
            document.getElementById('disposisi-card').style.display = 'none';
            document.getElementById('sppd-card').style.display = 'none';
        });
        document.getElementById('tombol-disposisi1').addEventListener('change', function() {
            console.log(this.value);
            if (this.checked) {
                document.getElementById('tombol-disposisi2').checked = false;
                document.getElementById('disposisi-card').style.display = 'block';

            }
        });
        document.getElementById('tombol-disposisi2').addEventListener('change', function() {
            console.log(this.value);
            if (this.checked) {
                document.getElementById('tombol-disposisi1').checked = false;
                // document.getElementById('tombol-sppd2').checked = true;
                // document.getElementById('tombol-sppd1').checked = false;
                document.getElementById('sppd1actv1').classList.remove('active');
                document.getElementById('sppd1actv2').classList.add('active');
                document.getElementById('sppd-card').style.display = 'none';
                document.getElementById('disposisi-card').style.display = 'none';
                document.getElementById('sppd-card').style.display = 'none';
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            document.getElementById('sppd-card').style.display = 'none';
        });
        document.getElementById('tombol-sppd1').addEventListener('change', function() {
            console.log(this.value);
            if (this.checked) {
                document.getElementById('tombol-sppd2').checked = false;

                document.getElementById('sppd-card').style.display = 'block';
            }
        });
        document.getElementById('tombol-sppd2').addEventListener('change', function() {
            console.log(this.value);
            if (this.checked) {
                document.getElementById('tombol-sppd1').checked = false;

                document.getElementById('sppd-card').style.display = 'none';
            }
        });
    </script>

    <script>
        var harga = document.getElementById('anggaran');
        harga.addEventListener('keyup', function(e) {
            harga.value = formatRupiah(this.value, '');
        });

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
        }
    </script>


    {{-- golongan atau satuan --}}
    <script>
        $(document).ready(function() {
            document.getElementById('select2-golongan').style.display = 'none';
            document.getElementById('select2-internal').style.display = 'none';


        });
        document.getElementById('tombol-jenis-disposisi1').addEventListener('change', function() {
            console.log(this.value);
            if (this.checked) {
                document.getElementById('tombol-jenis-disposisi3').checked = false;
                document.getElementById('tombol-jenis-disposisi2').checked = false;
                document.getElementById('select2-satuan_upzis').style.display = 'block';

                document.getElementById('select2-internal').style.display = 'none';
                document.getElementById('select2-golongan').style.display = 'none';
            }
        });
        document.getElementById('tombol-jenis-disposisi2').addEventListener('change', function() {
            console.log(this.value);
            if (this.checked) {
                document.getElementById('tombol-jenis-disposisi1').checked = false;
                document.getElementById('tombol-jenis-disposisi3').checked = false;
                document.getElementById('select2-satuan_upzis').style.display = 'none';

                document.getElementById('select2-internal').style.display = 'none';
                document.getElementById('select2-golongan').style.display = 'block';
            }
        });
        document.getElementById('tombol-jenis-disposisi3').addEventListener('change', function() {
            console.log(this.value);
            if (this.checked) {
                document.getElementById('tombol-jenis-disposisi1').checked = false;
                document.getElementById('tombol-jenis-disposisi2').checked = false;

                document.getElementById('select2-satuan_upzis').style.display = 'none';
                document.getElementById('select2-golongan').style.display = 'none';
                document.getElementById('select2-internal').style.display = 'block';
            }
        });
    </script>

    @push('intro_tambah_berita')
        <script>
            function klikkene(value) {
                introJs().setOptions({
                        steps: [{
                                element: document.querySelector('.input-tgl-terbit-berita-umum'),
                                title: 'Tanggal Terbit Berita',
                                intro: 'Berfungsi untuk mengisikan Tanggal Terbit Berita Umum'
                            },
                            {
                                element: document.querySelector('.input-kategori-berita-umum'),
                                title: 'Kategori Berita',
                                intro: 'Untuk Menunjukan Kategori Berita Yang Akan Diterbitkan, Kategori Berita Bisa di Isikan Pada Form Kategori Berita '
                            },
                            {
                                element: document.querySelector('.input-tag-berita-umum'),
                                title: 'Tag Berita',
                                intro: 'Untuk Memberikan Tagar Pada Berita Umum, Kolom Input Ini Tidak Wajib Diisikan'
                            },
                            {
                                element: document.querySelector('.input-isi-berita-umum'),
                                title: 'Isi Berita',
                                intro: 'Untuk Mengisikan Narasi Berita Yang Akan Dibuat'
                            },
                            {
                                element: document.querySelector('.card-tambah-lampiran-berita-umum'),
                                title: 'Tambah Lampiran Berita',
                                intro: 'Untuk Melakukan Penambahan File Dokumentasi Berita Yang Dibutuhkan'
                            },
                            {
                                element: document.querySelector('.card-upload-file-berita-umum'),
                                title: 'Upload File Berita',
                                intro: 'Upload Foto File Berita Umum tidak Wajib Diisikan Bila Tidak Ada, Upload File Foto Berita ini Nantinya Akan Dimunculkan Di Background Berita Umum Yang Sudah Terbit'
                            },
                            {
                                element: document.querySelector('.card-simpan-berita-umum'),
                                title: 'Simpan Berita',
                                intro: 'Jika Isian Form Berita Sudah Lengkap , Maka Tekan Tombol Simpan Untuk Menyimpan Berita, Berita Yang Telah Tersimpan Akan Otomatis Diterbitkan Dan Bisa Dilihat Oleh Pengurus PCNU Lazisnu Cilacap'
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
@endpush
