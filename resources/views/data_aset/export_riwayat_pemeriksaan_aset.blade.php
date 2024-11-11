<!DOCTYPE html>
<html>

<head>
    <title>Laporan Pemeriksaan Aset</title>
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
        <h4 style="margin: 0;">RIWAYAT PEMERIKSAAN ASET</h4>
        <h4 style="margin: 0;">MANAJEMEN EKSEKUTIF NU CARE LAZISNU CILACAP</h4>
    </div>

    <div style="margin-top: 20px;">
        <table style="width: 50%; border-collapse: collapse;">
            <tr>
                <td style="border: none; padding: 3px; width:25%;">Nama Aset</td>
                <td style="border: none; padding: 3px; width:4%;">:</td>
                <td style="border: none; padding: 3px;">
                    {{ $detailPemeriksaan->first()->aset->nama_aset }}
                </td>
            </tr>
            <tr>
                <td style="border: none; padding: 3px; width:25%;">Spesifikasi</td>
                <td style="border: none; padding: 3px; width:4%;">:</td>
                <td style="border: none; padding: 3px;">
                    {{ $detailPemeriksaan->first()->aset->spesifikasi }}
                </td>
            </tr>
            <tr>
                <td style="border: none; padding: 3px; width:25%;">Kategori</td>
                <td style="border: none; padding: 3px; width:4%;">:</td>
                <td style="border: none; padding: 3px;">
                    {{ $detailPemeriksaan->first()->aset->kategori_aset->kategori }}
                </td>
            </tr>
            <tr>
                <td style="border: none; padding: 3px; width:25%;">Lokasi Penyimpanan</td>
                <td style="border: none; padding: 3px; width:4%;">:</td>
                <td style="border: none; padding: 3px;">
                    {{ $detailPemeriksaan->first()->aset->lokasi_penyimpanan }}
                </td>
            </tr>
        </table>
    </div>

    <table class="table table-bordered"
        style="width: 100%; border-collapse: collapse; table-layout: fixed; font-size: 10px; margin-top: 10px;">
        <thead>
            <tr>
                <th style="border: 1px solid black; padding: 4px;">No.</th>
                <th style="border: 1px solid black; padding: 4px;">Kode Aset</th>
                <th style="border: 1px solid black; padding: 4px;">Tanggal</th>
                <th style="border: 1px solid black; padding: 4px;">Kondisi</th>
                <th style="border: 1px solid black; padding: 4px;">Status</th>
                <th style="border: 1px solid black; padding: 4px;">Keterangan</th>
                <th style="border: 1px solid black; padding: 4px;">Status SPV</th>
                <th style="border: 1px solid black; padding: 4px;">Status KC</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
            @endphp
            @foreach ($detailPemeriksaan as $data)
                <tr>
                    <td
                        style="border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden; text-align: left; vertical-align: top;">
                        {{ $no++ }}</td>
                    <td
                        style="border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden; text-align: left; vertical-align: top;">
                        {{ $data->aset->kode_aset}}</td>
                    <td
                        style="border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden; text-align: left; vertical-align: top;">
                        {{ $data->pemeriksaanAset->tanggal_pemeriksaan}}</td>
                    <td
                        style="border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden; text-align: left; vertical-align: top;">
                        {{ $data->kondisi }}</td>
                    <td
                        style="border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden; text-align: left; vertical-align: top;">
                        {{ $data->status_aset }}</td>
                    <td
                        style="border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden; text-align: left; vertical-align: top;">
                        <b>Masalah :</b> <br>{{ $data->masalah_teridentifikasi }} <br> <b>Tindakan :</b> <br> {{ $data->tindakan_diperlukan }}</td>
                    <td
                        style="border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden; text-align: left; vertical-align: top;">
                        <b>Mengetahui :</b> <br> {{ $data->pemeriksaanAset->tgl_mengetahui_spv ?? '-' }} <br> <b>Catatan :</b> <br> {{ $data->pemeriksaanAset->catatan_spv }}</td>
                    <td
                        style="border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden; text-align: left; vertical-align: top;">
                        <b>Mengetahui :</b> <br> {{ $data->pemeriksaanAset->tgl_mengetahui_kc ?? '-' }} <br> <b>Catatan :</b> <br> {{ $data->pemeriksaanAset->catatan_kc }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
