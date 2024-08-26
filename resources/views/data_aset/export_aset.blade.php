<!DOCTYPE html>
<html>

<style>

#table {
border:1px;
}

</style>

<head>
    <title>Laporan Data Aset</title>
</head>

<body style="font-family: Arial, sans-serif; font-size: 12px;">

    <table style="width: 100%; border: none;">
        <tr>
            <!-- Logo Kiri -->
            <td style="width: 20%; text-align: left;">
                <img style="width: 100px;" src="{{ public_path('/images/lazisnulogo1.png') }}">
            </td>

            <!-- Informasi Kontak -->
            <td style="width: 60%; text-align: center;">
                <p style="margin: 0;">Jl. Masjid No.09 Kelurahan Sidanegara, Kec. Cilacap Tengah, Kab. Cilacap</p>
                <p style="margin: 0;">Ijin Operasional Nomor: <span
                        style="color: #008000;">062/SKA.II/LAZISNU-PBNU/IX/2022</span></p>
                <p style="margin: 0;">Email: nucarelazisnukabupatencilacap@gmail.com</p>
                <p style="margin: 0;">Call Center: 08128221010 Telp. (0282) 539 5195</p>
                <p style="margin: 0;">Website: lazisnucilacap.com</p>
            </td>

            <!-- Logo Kanan -->
            <td style="width: 20%; text-align: right;">
                <img style="width: 100px;" src="{{ public_path('/images/siftnu.png') }}">
            </td>
        </tr>
    </table>

    <!-- Garis Tebal -->
    <div style="border-bottom: 4px solid black; margin: 10px 0;"></div>

    <div style="text-align: center; margin-bottom: 20px; margin-top: 20px">
        <h2 style="margin: 0;">FORM DATA ASET</h2>
        <p style="margin: 0;">MANAJEMEN EKSEKUTIF NU CARE LAZISNU CILACAP</p>
    </div>

    <table class="table table-bordered"
    style="width: 100%; border-collapse: collapse; table-layout: fixed; font-size: 10px;">
        <thead
            style="text-align: center; font-size: 7; background-color:white">
            <tr>
                <th style="border: 1px solid black; padding: 4px; width: 5%;">No</th>
                <th style="border: 1px solid black; padding: 4px; width: 20%;">Kode Aset</th>
                <th style="border: 1px solid black; padding: 4px; width: 10%;">Nama Aset</th>
                <th style="border: 1px solid black; padding: 4px; width: 10%;">Kategori</th>
                <th style="border: 1px solid black; padding: 4px; width: 10% ">Lokasi Penyimpanan</th>
                <th style="border: 1px solid black; padding: 4px; width: 7% ">Satuan</th>
                <th style="border: 1px solid black; padding: 4px; width: 19%;">Pemeriksaan</th>
                <th style="border: 1px solid black; padding: 4px; width: 19%;">Keluar Masuk</th>
            </tr>
        </thead>
        <tbody class="hover-pointer">
            @foreach ($aset as $data)
                <tr>
                    <td style="border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden;">{{ $loop->iteration }}</td>
                    <td style="border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden;">
                        <table
                            style="width: 100%;border: none;">
                            <tr>
                                <td style="border: none; padding: 2px; font-size: 11px; text-align:left" colspan="2">
                                    <b>{{ $data->kode_aset }}</b>
                                </td>
                            </tr>
                            <tr>
                                <td style="border: none; padding: 4px; font-size: 8px">Tgl Pembelian</td>
                                <td style="border: none;padding: 2px; flex: 2; font-size: 8px;text-align:right;">{{ $data->tgl_perolehan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td
                                    style="border: none; padding: 2px; font-size: 7px;">
                                    @php
                                        $status =
                                            $data->latestDetailPemeriksaanAset
                                                ->status_aset ?? 'null';
                                        $warnaTombol =
                                            $status === 'null'
                                                ? 'background-color: #a9a9a9;'
                                                : ($status === 'aktif'
                                                    ? 'background-color: #55CE71;'
                                                    : 'background-color: rgb(255, 18, 18);');
                                        $teksTombol =
                                            $status === 'null'
                                                ? 'Belum ada pemeriksaan'
                                                : ($status === 'aktif'
                                                    ? 'Aktif'
                                                    : 'Non Aktif');
                                    @endphp
                                    <button type="button"
                                        style="border-radius: 10px; border: none; {{ $warnaTombol }} color: white; padding: 2px 6px; font-size: 7px; line-height: 1;">
                                        {{ $teksTombol }}
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td style="border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden;text-align:center;"><b>{{ $data->nama_aset }}</b></td>
                    <td style="border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden;text-align:center;">
                        {{ $data->kategori_aset->kategori ?? 'Tidak Ada Kategori' }}
                    </td>
                    <td style="border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden;text-align:center;">{{ $data->lokasi_penyimpanan }}
                    </td>
                    <td style="border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden;text-align:center;">{{ $data->satuan }}</td>
                    <td style="border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden;text-align:center;">
                        <table
                            style="width:100%; border:none; border-collapse: collapse;">
                            <tr>
                                <td
                                    style="border: none; padding: 4px; line-height: 1.2;">
                                    Tgl
                                </td>
                                <td
                                    style="border: none; padding: 4px; text-align: right; font-size: 11px; line-height: 1.2;">
                                    <b>{{ $data->latestDetailPemeriksaanAset->pemeriksaanAset->tanggal_pemeriksaan ?? '-' }}</b>
                                </td>
                            </tr>
                            <tr>
                                <td
                                    style="border: none; padding: 4px; line-height: 1.2;">
                                    Kondisi
                                </td>
                                <td
                                    style="text-align: right; border: none; padding: 4px; color:
                                    {{ isset($data->latestDetailPemeriksaanAset) ? ($data->latestDetailPemeriksaanAset->kondisi == 'baik' ? '#55CE71' : ($data->latestDetailPemeriksaanAset->kondisi == 'rusak' ? 'rgb(255, 18, 18)' : 'inherit')) : '' }}; line-height: 1.2;">
                                    {{ $data->latestDetailPemeriksaanAset->kondisi ?? '-' }}
                                </td>
                            </tr>
                            <tr>
                                <td
                                    style="border: none; padding: 4px; line-height: 1.2;">
                                    Status
                                </td>
                                <td
                                    style="border: none; padding: 4px; text-align: right; color:
                                    {{ isset($data->latestDetailPemeriksaanAset) ? ($data->latestDetailPemeriksaanAset->status_aset == 'aktif' ? '#55CE71' : ($data->latestDetailPemeriksaanAset->status_aset == 'non aktif' ? 'rgb(255, 18, 18)' : 'inherit')) : '' }}; line-height: 1.2;">
                                    {{ $data->latestDetailPemeriksaanAset->status_aset ?? '-' }}
                                </td>
                            </tr>
                            <tr>
                                <td
                                    style="border: none; padding: 4px; line-height: 1.2;">
                                    Keterangan
                                </td>
                                <td
                                    style="border: none; padding: 4px; text-align: right; line-height: 1.2;">
                                    {{ $data->latestDetailPemeriksaanAset->masalah_teridentifikasi ?? '-' }}
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td style="border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden;text-align:center;">
                        <table
                            style="width:100%; border:none; border-collapse: collapse; font-size:13px;">
                            <tr>
                                <td
                                    style="border: none; padding: 4px; line-height: 1.2;">
                                    Tgl Input
                                </td>
                                <td
                                    style="border: none; padding: 4px; font-size:12px; line-height: 1.2; text-align:right;">
                                    <b>Tgl Input</b>
                                </td>
                            </tr>
                            <tr>
                                <td
                                    style="border: none; padding: 4px; line-height: 1.2;">
                                    Jml Masuk
                                </td>
                                <td style="border: none; padding: 4px; line-height: 1.2; text-align:right;"
                                    class="text-success">
                                    Jml Masuk
                                </td>
                            </tr>
                            <tr>
                                <td
                                    style="border: none; padding: 4px; line-height: 1.2;">
                                    Jml Keluar
                                </td>
                                <td style="border: none; padding: 4px; line-height: 1.2; text-align:right;"
                                    class="text-warning">
                                    Jml Keluar
                                </td>
                            </tr>
                            <tr>
                                <td
                                    style="border: none; padding: 4px; line-height: 1.2;">
                                    Sisa
                                </td>
                                <td
                                    style="border: none; padding: 4px; line-height: 1.2; text-align:right;">
                                    Sisa
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- <div style="margin-top: 20px;">
        <p>Catatan Supervisor: @if ($pemeriksaanAset->catatan_spv)
                {{ $pemeriksaanAset->catatan_spv }}
            @else
                -
            @endif
        </p>
        <p>Catatan Kepala Cabang: @if ($pemeriksaanAset->catatan_kc)
                {{ $pemeriksaanAset->catatan_kc }}
            @else
                -
            @endif
        </p>
    </div>

    <div style="margin-top: 40px; text-align: center;">
        <table style="width: 100%; border-collapse: collapse; margin-top: 30px;">
            <tr>
                <td style="text-align: center;">
                    <p>Pemeriksa</p>
                    <p style="margin-top: 60px;">Halin Fajar Waskitho</p>
                    <p>Staff Logistik dan Perlengkapan</p>
                    <p>Bidang Pendistribusian dan Pemberdayaan</p>
                </td>
                <td style="text-align: center;">
                    <p>Supervisor</p>
                    <p style="margin-top: 60px;">Farahdiba Nadya Natakanestri, S.Hum.</p>
                    <p>Supervisor Cabang</p>
                    <p>Bidang Pendistribusian dan Pemberdayaan</p>
                </td>
                <td style="text-align: center;">
                    <p>Mengetahui</p>
                    <p style="margin-top: 60px;">Ahmad Fauzi, S.Pd.I.</p>
                    <p>Kepala Cabang</p>
                    <p>NU Care Lazisnu Cilacap</p>
                </td>
            </tr>
        </table>
    </div> --}}

</body>

</html>
