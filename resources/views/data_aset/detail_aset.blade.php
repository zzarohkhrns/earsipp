@extends('main')


@section('detail_barang', 'active menu-open')
@section('barang', 'menu-open')

@section('css')
@section('content')

    <style>
        .nav-tabs .nav-link {
            border: 1px solid transparent;
            border-top-left-radius: .25rem;
            border-top-right-radius: .25rem;
            color: black;
            /* Warna teks tab tidak aktif */
        }

        .nav-tabs .nav-link.active {
            color: green !important;
            /* Warna teks tab aktif */
        }

        .nav-tabs {
            width: 100%;
        }

        .tab-content {
            width: 100%;
        }
    </style>


    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb m-0 pl-4">
                        <li class="breadcrumb-item active">
                            <a href="/{{ $role }}/dashboard">Dashboard</a> / <a
                                href="/{{ $role }}/arsip/aset/data">Data Aset</a> / <a>Detail Aset</a>
                        </li>
                    </ol>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">{{ Carbon\Carbon::parse(now())->isoFormat('dddd, D MMMM Y') }}
                        </li>
                    </ol>
                </div><!-- /.col -->
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card ijo-kiri">
                        <div class="card-body">
                            <div class="row card-detail-barang">
                                <div class="col-12">
                                    {{-- Data detail barang --}}
                                    <table id="example3" style="width:100%">

                                        {{-- Line 1 --}}
                                        <tr>
                                            <th style="width: 200px;"><b>Kode Aset</b></th>
                                            <th style="width: 200px;"></th>
                                            <th style="width: 200px;"></th>
                                            <th style="width: 100px;">
                                                <div class="btn-group btn-block mb-2 mb-xl-0 card_edit_barang">
                                                    <a class="btn btn-success intro-ubah-detail-aset ml-1 mr- edit-aset"
                                                        type="button" data-toggle="modal" data-target="#ubahasetModal"
                                                        style="border-radius:10px;" aria-expanded="false">
                                                        &nbsp;&nbsp;<i class="fas fa-edit"></i> Edit
                                                    </a>
                                                </div>
                                            </th>
                                            <th style="width: 100px;">
                                                <div class="btn-group btn-block mb-2 mb-xl-0 card_hapus_barang">
                                                    <div class="btn-group mb-2 mb-xl-0 btn-block">
                                                        <form
                                                            action="/{{ $role }}/aset/data/delete/{{ $aset->aset_id }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger btn-block"
                                                                style="display: block; border-radius:10px; width: 160px">
                                                                <i class="fas fa-trash"></i>
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th style="width: 200px;" class="text-success">
                                                <h4><b>{{ $aset->kode_aset ?? '0'}}</b></h4>
                                            </th>
                                            <th style="width: 200px;"></th>
                                            <th style="width: 200px;"></th>
                                            <th style="width: 100px;"></th>
                                            <th style="width: 100px;"></th>
                                        </tr>

                                        {{-- Line 2 --}}
                                        <tr>
                                            <th style="width: 200px;"><b>Nama Barang</b></th>
                                            <th style="width: 200px;"><b>Kategori</b></th>
                                            <th style="width: 200px;"></th>
                                            <th style="width: 100px;"></th>
                                            <th style="width: 100px;"></th>
                                        </tr>
                                        <tr>
                                            {{-- <td>{{ $barang->nama }}</td>
                                                <td>{{ $barang->satuan }}</td>
                                                <td>{{ $barang->lokasi_penyimpanan }}</td> --}}
                                            <td>{{ $aset->nama_aset ?? '0' }}</< /td>
                                            <td>{{ $aset->kategori_aset->kategori ?? '0'}}</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>

                                        {{-- Line 3 --}}
                                        <tr>
                                            <th style="width: 200px;"><b>Tanggal Pembelian</b></th>
                                            <th style="width: 200px;"><b>Satuan</b></th>
                                            <th style="width: 200px;"></th>
                                            <th style="width: 100px;"></th>
                                            <th style="width: 100px;"></th>
                                        </tr>
                                        <tr>
                                            <td>{{ $aset->tgl_perolehan ?? '0'}}</td>
                                            <td>{{ $aset->satuan ?? '0' }}</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>

                                        {{-- Line 4 --}}
                                        <tr>
                                            <th style="width: 200px;"><b>Asal Perolehan</b></th>
                                            <th style="width: 200px;"><b>Lokasi Penyimpanan</b></th>
                                            <th style="width: 200px;"></th>
                                            <th style="width: 100px;"></th>
                                            <th style="width: 100px;"></th>
                                        </tr>
                                        <tr>
                                            <td>{{ $aset->asal_perolehan ?? 'tidak ada asal perolehan' }}</td>
                                            <td>{{ $aset->lokasi_penyimpanan ?? '0'}}</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>

                                        {{-- Line 5 --}}
                                        <tr>
                                            <td><b>Spesifikasi</b></td>
                                        </tr>
                                        <tr>
                                            {{-- <td colspan="4">{{ $barang->spesifikasi }}</td> --}}
                                            <td colspan="2">{{ $aset->spesifikasi ?? '0' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- tab menu kontrol dan keluar masuk barang --}}
            <div class="row">
                <div class="col-12">
                    <div class="card ijo-kiri">
                        <div class="card-body">
                            <div class="row card-kontrol-barang">
                                <div class="col-12">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="kontrol-barang-tab" data-toggle="tab"
                                                href="#kontrol-barang" role="tab" aria-controls="kontrol-barang"
                                                aria-selected="true">DATA PEMERIKSAAN</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="keluar-masuk-barang-tab" data-toggle="tab"
                                                href="#keluar-masuk-barang" role="tab"
                                                aria-controls="keluar-masuk-barang" aria-selected="false">DATA KELUAR
                                                MASUK</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="penyusutan-nilai-tab" data-toggle="tab"
                                                href="#penyusutan-nilai" role="tab" aria-controls="penyusutan-nilai"
                                                aria-selected="false">DATA PENYUSUTAN NILAI</a>
                                        </li>
                                    </ul>

                                    {{-- tab pemeriksaan --}}
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="kontrol-barang" role="tabpanel"
                                            aria-labelledby="kontrol-barang-tab">
                                            <div class="card-body">
                                                <div class="row card-kontrol-barang">
                                                    <div class="col-12">
                                                        <table id="example3" class="table table-bordered"
                                                            style="width:100%;">
                                                            <thead class="table-secondary" style="text-align: center">
                                                                <tr>
                                                                    <th>NO</th>
                                                                    <th>Tgl Pemeriksaan</th>
                                                                    <th>Kondisi</th>
                                                                    <th>Status</th>
                                                                    <th>Masalah Teridentifikasi</th>
                                                                    <th>Tindakan Yang Diperlukan</th>
                                                                    <th style="width: 150px;">Aksi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if ($detailPemeriksaan->isNotEmpty())
                                                                @php
                                                                        $no = 1;
                                                                        @endphp
                                                                        @foreach ($detailPemeriksaan as $item)
                                                                        <tr>
                                                                            <td>{{ $no++ }}</td>
                                                                            <td>{{ $item->pemeriksaanAset->tanggal_pemeriksaan }}</td>
                                                                            <td>{{ $item->kondisi }}</td>
                                                                            @if ($item->status_aset == 'aktif')
                                                                            <td class="text-success">Aktif</td>
                                                                            @else
                                                                            <td class="text-danger">Non aktif</td>
                                                                            @endif
                                                                            <td>{{ $item->masalah_teridentifikasi }}</td>
                                                                            <td>{{ $item->tindakan_diperlukan }}</td>
                                                                            <td>
                                                                                <div class="d-flex flex-column align-items-center">
                                                                                    <div class="btn-group mb-2 mb-xl-0 btn-block">
                                                                                        <a onclick="$('#cover-spin').show(0)"
                                                                                            href="/{{ $role }}/arsip/aset/detail_pemeriksaan"
                                                                                            class="btn btn-outline-secondary"
                                                                                            style="display: block; border-radius: 10px; width: 150px; padding: 10px; margin: 5px 0;">
                                                                                            Detail
                                                                                        </a>
                                                                                    </div>
                                                                                    <div
                                                                                        class="btn-group mb-2 card_pemeriksaan btn-block">
                                                                                        <a href="/{{ $role }}/print-data"
                                                                                            class="btn btn-outline-secondary"
                                                                                            style="display: block; border-radius: 10px; width: 150px; padding: 10px; margin: 5px 0;">
                                                                                            <i class="fas fa-file-alt"></i> Export
                                                                                        </a>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        @endforeach
                                                                    @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- tab keluar masuk barang --}}
                                        <div class="tab-pane fade" id="keluar-masuk-barang" role="tabpanel"
                                            aria-labelledby="keluar-masuk-barang-tab">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <table id="example3" class="table table-bordered"
                                                            style="width:100%;">
                                                            <thead class="table-secondary" style="text-align: center">
                                                                <tr>
                                                                    <th>NO</th>
                                                                    <th>Tgl Pemeriksaan</th>
                                                                    <th>Kondisi</th>
                                                                    <th>Status</th>
                                                                    <th>Masalah Teridentifikasi</th>
                                                                    <th>Tindakan Yang Diperlukan</th>
                                                                    <th style="width: 150px;">Aksi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- tab penyusutan nilai --}}
                                        <div class="tab-pane fade" id="penyusutan-nilai" role="tabpanel"
                                            aria-labelledby="penyusutan-nilai-tab">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <table id="example3" class="table table-bordered"
                                                            style="width:100%;">
                                                            <thead class="table-secondary" style="text-align: center">
                                                                <tr>
                                                                    <th>NO</th>
                                                                    <th>Tgl Pemeriksaan</th>
                                                                    <th>Kondisi</th>
                                                                    <th>Status</th>
                                                                    <th>Masalah Teridentifikasi</th>
                                                                    <th>Tindakan Yang Diperlukan</th>
                                                                    <th style="width: 150px;">Aksi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- modal keluar masuk barang --}}
    <div class="modal fade" id="keluarModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Keluar Masuk Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="myForm">
                        <div class="form-group">
                            <label for="name">Nama :</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="form-group">
                            <label for="tanggal">Tanggal Input :</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal">
                        </div>
                        <div class="form-group">
                            <label for="totAwal">Total Awal :</label>
                            <input type="text" class="form-control" id="totAwal" name="totAwal">
                        </div>
                        <div class="form-group">
                            <label for="keluar">Keluar :</label>
                            <input type="text" class="form-control" id="keluar" name="keluar">
                        </div>
                        <div class="form-group">
                            <label for="masuk">Masuk :</label>
                            <input type="text" class="form-control" id="masuk" name="masuk">
                        </div>
                        <div class="form-group">
                            <label for="totAkhir">Total Akhir :</label>
                            <input type="text" class="form-control" id="totAkhir" name="totAkhir">
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan :</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan">
                        </div>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- modal tambah pemeriksaan -->
    <div class="modal fade" id="pemeriksaanModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Tambah Pemeriksaan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding-top: 0;">
                    <form>
                        <div class="form-group">
                            <label for="tgl_pemeriksaan" style="font-weight: bold; font-size: 14px;">Tgl
                                Pemeriksaan</label>
                            <input type="text" class="form-control" id="tgl_pemeriksaan"
                                style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;">
                        </div>
                        <div class="form-group">
                            <label for="manajemen_eksekutif" style="font-weight: bold; font-size: 14px;">Manajemen
                                Eksekutif</label>
                            <input type="text" class="form-control" id="manajemen_eksekutif"
                                style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;">
                        </div>
                        <div class="form-group">
                            <label for="pemeriksa" style="font-weight: bold; font-size: 14px;">Pemeriksa</label>
                            <input type="text" class="form-control" id="pemeriksa"
                                style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;">
                        </div>
                        <div class="form-group">
                            <label for="supervisor" style="font-weight: bold; font-size: 14px;">Supervisor</label>
                            <input type="text" class="form-control" id="supervisor"
                                style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;">
                        </div>
                        <div class="form-group">
                            <label for="kepala_cabang" style="font-weight: bold; font-size: 14px;">Kepala Cabang</label>
                            <input type="text" class="form-control" id="kepala_cabang"
                                style="font-size: 14px; padding: 8px 12px; margin-bottom: 10px;">
                        </div>
                        <div class="alert alert-info"
                            style="background-color: #d4edda; border-color: #c3e6cb; color: #155724; margin-top: 15px;">
                            <strong>INFORMASI</strong><br>Setelah berhasil menambahkan pemeriksaan, anda wajib melengkapi
                            data pemeriksaan aset.
                        </div>
                    </form>
                </div>
                <div class="modal-footer" style="border-top: none; padding-top: 0;">
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    {{-- modal ubah aset --}}
    <div class="modal fade" id="ubahasetModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Ubah Data Aset</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="myForm" method="POST" action="/{{ $role }}/aset/data/update/{{ $aset->aset_id ?? '0'}}">
                        @csrf
                        <div class="form-group">
                            <label for="kode">Kode Aset :</label>
                            <input type="text" value="{{ $aset->aset_id ?? '0' }}" class="form-control" id="aset_id"
                                name="aset_id" hidden>
                            <input type="text" value="{{ $aset->kode_aset ?? '0' }}" class="form-control" id="kode_aset"
                                name="kode_aset" readonly>
                        </div>
                        <div class="form-group">
                            <label for="tgl_beli">Tgl Perolehan :</label>
                            <input type="date" value="{{ $aset->tgl_perolehan ?? '-' }}" class="form-control"
                                id="tgl_perolehan" name="tgl_perolehan">
                        </div>
                        <div class="form-group">
                            <label for="asal">Asal Perolehan :</label>
                            <input type="text" class="form-control" value="{{ $aset->asal_perolehan ?? '-'}}"
                                id="asal_perolehan" name="asal_perolehan">
                        </div>
                        <div class="form-group">
                            <label for="name">Nama :</label>
                            <input type="text" class="form-control" value="{{ $aset->nama_aset ?? '-'}}" id="nama_aset"
                                name="nama_aset">
                        </div>
                        <div class="form-group">
                            <label for="kategori">Kategori :</label>
                            <select class="form-control" id="kategori" name="kategori"
                                onchange="toggleNewCategoryForm()">
                                @foreach ($kategori as $kat)
                                    <option value="{{ $kat->id_kategori ?? '-'}}"
                                        @if ($aset->id_kategori == $kat->id_kategori) selected @endif>
                                        {{ $kat->kategori ?? '-'}}</option>
                                @endforeach
                                <option value="others">Lainnya</option>
                            </select>
                            <div class="mt-2" id="newCategoryForm" style="display: none;">
                                <input type="text" id="newKategori" class="form-control"
                                    placeholder="Tambah kategori baru">
                                <button type="button" id="" class="btn btn-success mt-2"
                                    onclick="addCategory()">Tambah
                                    Kategori</button>
                            </div>
                        </div>
                        <div class="form-grPoup">
                            <label for="satuan">Satuan :</label>
                            <input type="text" class="form-control" value="{{ $aset->satuan ?? '-' }}" id="satuan"
                                name="satuan">
                        </div>
                        <div class="form-group">
                            <label for="lokasi">Lokasi Penyimpanan :</label>
                            <input type="text" class="form-control" id="lokasi"
                                value="{{ $aset->lokasi_penyimpanan ?? '-'}}" name="lokasi_penyimpanan">
                        </div>
                        <div class="form-group">
                            <label for="spesifikasi">Spesifikasi/Deskripsi :</label>
                            <input type="text" class="form-control" value="{{ $aset->spesifikasi ?? '-'}}"
                                id="spesifikasi" name="spesifikasi">
                        </div>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const editButtons = document.querySelectorAll('.edit-barang');

            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const namaBarang = this.getAttribute('data-nama-barang');
                    const satuanBarang = this.getAttribute('data-satuan');
                    const lokasiPenyimpanan = this.getAttribute('data-lokasi-penyimpanan');
                    const spesifikasi = this.getAttribute('data-spesifikasi');

                    document.querySelector('#edittambahModal input[name="nama"]').value =
                        namaBarang;
                    document.querySelector('#edittambahModal input[name="satuan"]').value =
                        satuanBarang;
                    document.querySelector('#edittambahModal input[name="lokasi_penyimpanan"]')
                        .value = lokasiPenyimpanan;
                    document.querySelector('#edittambahModal input[name="spesifikasi"]').value =
                        spesifikasi;
                })
            })
        })
    </script>

    {{-- script untuk menyimpan kategori --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Pasang event listener pada tombol "Tambah Kategori"
            document.getElementById('addCategoryButton').addEventListener('click', function() {
                addCategory();
            });

            // Menampilkan atau menyembunyikan form kategori baru berdasarkan pilihan
            toggleNewCategoryForm();
        });

        function toggleNewCategoryForm() {
            var select = document.getElementById('kategori');
            var newCategoryForm = document.getElementById('newCategoryForm');
            if (select.value === 'others') {
                newCategoryForm.style.display = 'block';
            } else {
                newCategoryForm.style.display = 'none';
            }
        }

        function addCategory() {
            var newCategory = document.getElementById('newKategori').value.trim();
            if (newCategory) {
                // Kirim kategori baru ke server
                $.ajax({
                    url: '{{ route('pc.kategori.store') }}',
                    type: 'POST',
                    data: {
                        nama: newCategory,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        if (data.id) {
                            var select = document.getElementById('kategori');
                            var option = document.createElement('option');
                            option.value = data.id; // Gunakan ID dari respons (id_kategori)
                            option.text = data.nama; // Gunakan nama dari respons (kategori)
                            select.add(option);
                            select.value = data.id; // Setel kategori baru sebagai yang dipilih
                            document.getElementById('newKategori').value = ''; // Kosongkan input
                            document.getElementById('newCategoryForm').style.display =
                                'none'; // Sembunyikan form setelah menambah
                        } else {
                            alert('Gagal menambahkan kategori.');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Gagal menyimpan kategori baru.');
                    }
                });
            } else {
                alert('Silakan masukkan nama kategori baru.');
            }
        }
    </script>

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
@endsection

@endsection
@endsection
