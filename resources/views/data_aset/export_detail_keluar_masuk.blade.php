<!DOCTYPE html>
<html lang="en">

<head>
    <title>Laporan Keluar Masuk Aset</title>
</head>

<body style="font-family: Arial, sans-serif; font-size: 12px;">
    <table style="width: 100%; border: none;">
        <tr>
            <!-- Logo Kiri -->
            <td style="width: 20%; text-align: left;">
                <img style="width: 100px;" src="{{ public_path('/images/lazisnulogo1.png') }}">
            </td>

            <!-- Informasi Kontak -->
            <td style="width: 60%; text-align: left;">
                <p style="margin: 0;">Jl. Masjid No.09 Kelurahan Sidanegara, Kec. Cilacap Tengah, Kab. Cilacap</p>
                <p style="margin: 0;">Ijin Operasional Nomor: <span
                        style="color: #008000;">062/SKA.II/LAZISNU-PBNU/IX/2022</span></p>
                <p style="margin: 0;">Email: nucarelazisnukabupatencilacap@gmail.com</p>
                <p style="margin: 0;">Call Center: 08128221010 Telp. (0282) 539 5195</p>
                <p style="margin: 0;">Website: lazisnucilacap.com</p>
            </td>

            <!-- Logo Kanan -->
            <td style="width: 20%; text-align: right;">
                <img style="width: 120px;" src="{{ public_path('/images/siftnu.png') }}">
            </td>
        </tr>
    </table>

    <!-- Garis Tebal -->
    <div style="border-bottom: 4px solid black; margin: 10px 0;"></div>

    <div style="text-align: center; margin-bottom: 20px; margin-top: 20px">
        <h4 style="margin: 0;">FORM PENCATATAN KELUAR MASUK ASET</h4>
        <h4 style="margin: 0;">MANAJEMEN EKSEKUTIF NU CARE LAZISNU CILACAP</h4>
    </div>

    <div style="margin-top: 20px;">
        <table style="width: 60%; border-collapse: collapse;">
            <tr>
                <td style="border: none; padding: 3px; width:25%;">Diinput Oleh</td>
                <td style="border: none; padding: 3px; width:4%;">:</td>
                <td style="border: none; padding: 3px;">
                    {{-- {{ $detailPemeriksaan->first()->aset->nama_aset }} --}}
                </td>
            </tr>
            <tr>
                <td style="border: none; padding: 3px; width:25%;">Jabatan</td>
                <td style="border: none; padding: 3px; width:4%;">:</td>
                <td style="border: none; padding: 3px;">
                    {{-- {{ $detailPemeriksaan->first()->aset->spesifikasi }} --}}
                </td>
            </tr>
            <tr>
                <td style="border: none; padding: 3px; width:25%;">Divisi</td>
                <td style="border: none; padding: 3px; width:4%;">:</td>
                <td style="border: none; padding: 3px;">
                    {{-- {{ $detailPemeriksaan->first()->aset->kategori_aset->kategori }} --}}
                </td>
            </tr>
            <tr>
                <td style="border: none; padding: 3px; width:25%;">Hari, Tgl Submit</td>
                <td style="border: none; padding: 3px; width:4%;">:</td>
                <td style="border: none; padding: 3px;">
                    {{-- {{ $detailPemeriksaan->first()->aset->lokasi_penyimpanan }} --}}
                </td>
            </tr>
        </table>
    </div>

    <div style="text-align: left; margin-bottom: 10px; margin-top: 20px">
        <h4 style="margin: 0;">HASIL PENCATATAN KELUAR MASUK ASET</h4>
    </div>

    <div style="text-align: left; margin-bottom: 10px;">
        <h4 style="margin: 0;">A. ASET MASUK</h4>
    </div>

    <div style="text-align: left; margin-bottom: 10px;">
        <table style="width: 60%; border-collapse: collapse;">
            <tr>
                <td style="border: none; padding: 3px; width:25%;">No. Transaksi Masuk</td>
                <td style="border: none; padding: 3px; width:4%;">:</td>
                <td style="border: none; padding: 3px;">
                    {{-- {{ $detailPemeriksaan->first()->aset->nama_aset }} --}}
                </td>
            </tr>
            <tr>
                <td style="border: none; padding: 3px; width:25%;">Hari, Tgl Masuk</td>
                <td style="border: none; padding: 3px; width:4%;">:</td>
                <td style="border: none; padding: 3px;">
                    {{-- {{ $detailPemeriksaan->first()->aset->spesifikasi }} --}}
                </td>
            </tr>
            <tr>
                <td style="border: none; padding: 3px; width:25%;">Nama Pemasok</td>
                <td style="border: none; padding: 3px; width:4%;">:</td>
                <td style="border: none; padding: 3px;">
                    {{-- {{ $detailPemeriksaan->first()->aset->kategori_aset->kategori }} --}}
                </td>
            </tr>
            <tr>
                <td style="border: none; padding: 3px; width:25%;">No. Faktur/Nota</td>
                <td style="border: none; padding: 3px; width:4%;">:</td>
                <td style="border: none; padding: 3px;">
                    {{-- {{ $detailPemeriksaan->first()->aset->lokasi_penyimpanan }} --}}
                </td>
            </tr>
            <tr>
                <td style="border: none; padding: 3px; width:25%;">Total Kuantitas</td>
                <td style="border: none; padding: 3px; width:4%;">:</td>
                <td style="border: none; padding: 3px;">
                    {{-- {{ $detailPemeriksaan->first()->aset->lokasi_penyimpanan }} --}}
                </td>
            </tr>
            <tr>
                <td style="border: none; padding: 3px; width:25%;">Keterangan</td>
                <td style="border: none; padding: 3px; width:4%;">:</td>
                <td style="border: none; padding: 3px;">
                    {{-- {{ $detailPemeriksaan->first()->aset->lokasi_penyimpanan }} --}}
                </td>
            </tr>
        </table>
    </div>

    <table class="table table-bordered"
        style="width: 100%; border-collapse: collapse; table-layout: fixed; font-size: 10px; margin-top: 10px;">
        <thead style="text-align: center; font-size:13px;">
            <tr>
                <th style="border: 1px solid black; padding: 4px;">No.</th>
                <th style="border: 1px solid black; padding: 4px;">Kode Aset</th>
                <th style="border: 1px solid black; padding: 4px;">Nama Aset</th>
                <th style="border: 1px solid black; padding: 4px;">Kategori</th>
                <th style="border: 1px solid black; padding: 4px;">Lokasi</th>
                <th style="border: 1px solid black; padding: 4px;">Kuantitas</th>
                <th style="border: 1px solid black; padding: 4px;">Satuan</th>
                <th style="border: 1px solid black; padding: 4px;">Kondisi</th>
                <th style="border: 1px solid black; padding: 4px;">Tindak Lanjut</th>
            </tr>
        </thead>
        <tbody style="font-size: 13px;">
            <tr>
                <td style="border: 1px solid black; padding: 4px;"></td>
                <td style="border: 1px solid black; padding: 4px;"></td>
                <td style="border: 1px solid black; padding: 4px;"></td>
                <td style="border: 1px solid black; padding: 4px;"></td>
                <td style="border: 1px solid black; padding: 4px;"></td>
                <td style="border: 1px solid black; padding: 4px;"></td>
                <td style="border: 1px solid black; padding: 4px;"></td>
                <td style="border: 1px solid black; padding: 4px;"></td>
                <td style="border: 1px solid black; padding: 4px;"></td>
            </tr>
        </tbody>
    </table>

    <div style="text-align: left; margin-bottom: 10px; margin-top: 20px">
        <h4 style="margin: 0;">B. ASET KELUAR</h4>
    </div>

    <div style="text-align: left; margin-bottom: 10px;">
        <table style="width: 60%; border-collapse: collapse;">
            <tr>
                <td style="border: none; padding: 3px; width:25%;">No. Transaksi Masuk</td>
                <td style="border: none; padding: 3px; width:4%;">:</td>
                <td style="border: none; padding: 3px;">
                    {{-- {{ $detailPemeriksaan->first()->aset->nama_aset }} --}}
                </td>
            </tr>
            <tr>
                <td style="border: none; padding: 3px; width:25%;">Hari, Tgl Masuk</td>
                <td style="border: none; padding: 3px; width:4%;">:</td>
                <td style="border: none; padding: 3px;">
                    {{-- {{ $detailPemeriksaan->first()->aset->spesifikasi }} --}}
                </td>
            </tr>
            <tr>
                <td style="border: none; padding: 3px; width:25%;">Nama Pemasok</td>
                <td style="border: none; padding: 3px; width:4%;">:</td>
                <td style="border: none; padding: 3px;">
                    {{-- {{ $detailPemeriksaan->first()->aset->kategori_aset->kategori }} --}}
                </td>
            </tr>
            <tr>
                <td style="border: none; padding: 3px; width:25%;">No. Faktur/Nota</td>
                <td style="border: none; padding: 3px; width:4%;">:</td>
                <td style="border: none; padding: 3px;">
                    {{-- {{ $detailPemeriksaan->first()->aset->lokasi_penyimpanan }} --}}
                </td>
            </tr>
            <tr>
                <td style="border: none; padding: 3px; width:25%;">Total Kuantitas</td>
                <td style="border: none; padding: 3px; width:4%;">:</td>
                <td style="border: none; padding: 3px;">
                    {{-- {{ $detailPemeriksaan->first()->aset->lokasi_penyimpanan }} --}}
                </td>
            </tr>
            <tr>
                <td style="border: none; padding: 3px; width:25%;">Keterangan</td>
                <td style="border: none; padding: 3px; width:4%;">:</td>
                <td style="border: none; padding: 3px;">
                    {{-- {{ $detailPemeriksaan->first()->aset->lokasi_penyimpanan }} --}}
                </td>
            </tr>
        </table>
    </div>

    <table class="table table-bordered"
        style="width: 100%; border-collapse: collapse; table-layout: fixed; font-size: 10px; margin-top: 10px;">
        <thead style="text-align: center; font-size:13px;">
            <tr>
                <th style="border: 1px solid black; padding: 4px;">No.</th>
                <th style="border: 1px solid black; padding: 4px;">Kode Aset</th>
                <th style="border: 1px solid black; padding: 4px;">Nama Aset</th>
                <th style="border: 1px solid black; padding: 4px;">Kategori</th>
                <th style="border: 1px solid black; padding: 4px;">Lokasi</th>
                <th style="border: 1px solid black; padding: 4px;">Kuantitas</th>
                <th style="border: 1px solid black; padding: 4px;">Satuan</th>
                <th style="border: 1px solid black; padding: 4px;">Kondisi</th>
                <th style="border: 1px solid black; padding: 4px;">Tindak Lanjut</th>
            </tr>
        </thead>
        <tbody style="font-size: 13px;">
            <tr>
                <td style="border: 1px solid black; padding: 4px;"></td>
                <td style="border: 1px solid black; padding: 4px;"></td>
                <td style="border: 1px solid black; padding: 4px;"></td>
                <td style="border: 1px solid black; padding: 4px;"></td>
                <td style="border: 1px solid black; padding: 4px;"></td>
                <td style="border: 1px solid black; padding: 4px;"></td>
                <td style="border: 1px solid black; padding: 4px;"></td>
                <td style="border: 1px solid black; padding: 4px;"></td>
                <td style="border: 1px solid black; padding: 4px;"></td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 10px;">
        <p style="margin: 0; padding: 0;">Catatan Supervisor :
            {{-- @if ($pemeriksaanAset->catatan_spv)
                {{ $pemeriksaanAset->catatan_spv }}
            @else
                -
            @endif --}}
        </p>
        <p style="margin: 0; padding: 0;">Catatan Kepala Cabang :
            {{-- @if ($pemeriksaanAset->catatan_kc)
                {{ $pemeriksaanAset->catatan_kc }}
            @else
                -
            @endif --}}
        </p>
    </div>

    <div style="margin-top: 10px; text-align: center;">
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <tr>
                <td style="text-align: center; width: 30%;">
                    <p>Pencatat</p>
                </td>
                <td style="text-align: center; width: 30%;">
                    <p>Supervisor</p>
                </td>
                <td style="text-align: center; width: 30%;">
                    <p>Mengetahui</p>
                </td>
            </tr>
            <tr>
                <td style="text-align: center; width: 30%;">
                    {{-- @if ($pemeriksaanAset->status_pemeriksaan == 'selesai') --}}
                        <img src="https://gocapv2.nucarecilacap.id/uploads/user/Halin%20Fajar%20Waskitho__1722238260.jpg"
                            alt="ttd"
                            style="height: 150px; margin-top: -30px;margin-bottom: -15px;padding: 0;" />
                    {{-- @endif --}}
                </td>
                <td style="text-align: center; width: 30%;">
                    {{-- @if ($pemeriksaanAset->status_spv == 'mengetahui') --}}
                        <img src="https://gocapv2.nucarecilacap.id/uploads/user/Farahdiba%20Nadya%20Natakanestri__1722397013.jpg"
                            alt="ttd"
                            style="height: 200px; margin-top: -72px;margin-bottom: -25px;padding: 0;" />
                    {{-- @endif --}}
                </td>
                <td style="text-align: center; width: 30%;">
                    {{-- @if ($pemeriksaanAset->status_kc == 'mengetahui') --}}
                        <img src="https://gocapv2.nucarecilacap.id/uploads/user/Ahmad%20Fauzi,%20S.Pd.I__1722238190.jpg"
                            alt="ttd" style="height: 100px; margin-top : -20px;padding: 0;" />
                    {{-- @endif --}}
                </td>
            </tr>
            <tr>
                <td style="text-align: center; width: 30%;">
                    <b style="padding: 0;">
                        {{-- {{ $pemeriksaanAset->pcPengurus->pengguna->nama }} --}}
                        nama
                    </b>
                </td>
                <td style="text-align: center; width: 30%;">
                    <b style="padding: 0;">
                        {{-- {{ $pemeriksaanAset->supervisor->pengguna->nama }} --}}
                        nama
                    </b>
                </td>
                <td style="text-align: center; width: 30%;">
                    <b style="padding: 0;">
                        {{-- {{ $pemeriksaanAset->kc->pengguna->nama }} --}}
                        nama
                    </b>
                </td>
            </tr>
            <tr>
                <td style="text-align: center; width: 30%;">
                    <p style="margin: 0; padding: 0;">
                        {{-- {{ $pemeriksaanAset->pcPengurus->PengurusJabatan->jabatan }} --}}
                        jabatan
                    </p>
                </td>
                <td style="text-align: center; width: 30%;">
                    <p style="margin: 0; padding: 0;">
                        {{-- {{ $pemeriksaanAset->supervisor->PengurusJabatan->jabatan }} --}}
                        jabatan
                    </p>
                </td>
                <td style="text-align: center; width: 30%;">
                    <p style="margin: 0; padding: 0;">
                        {{-- {{ $pemeriksaanAset->kc->PengurusJabatan->jabatan }} --}}
                        jabatan
                    </p>
                </td>
            </tr>
            <tr>
                <td style="text-align: center; width: 30%;">
                    <p style="margin: 0; padding: 0;">
                        {{-- {{ $pemeriksaanAset->pcPengurus->PengurusJabatan->divisi }} --}}
                        divisi
                    </p>
                </td>
                <td style="text-align: center; width: 30%;">
                    <p style="margin: 0; padding: 0;">
                        {{-- {{ $pemeriksaanAset->supervisor->PengurusJabatan->divisi }} --}}
                        divisi
                    </p>
                </td>
                <td style="text-align: center; width: 30%;">
                    <p style="margin: 0; padding: 0;">NU Care Lazisnu Cilacap</p>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
