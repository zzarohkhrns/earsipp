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
        <h4 style="margin: 0;">FORM PEMERIKSAAN ASET</h4>
        <h4 style="margin: 0;">MANAJEMEN EKSEKUTIF NU CARE LAZISNU CILACAP</h4>
    </div>

    <div style="margin-top: 20px;">
        <table class="table table-bordered"
            style="width: 100%; border-collapse: collapse; table-layout: fixed; font-size: 10px;">
            <thead>
                <tr>
                    <th style="border: 1px solid black; padding: 4px; width: 5%;">No.</th>
                    <th style="border: 1px solid black; padding: 4px; width: 10%;">Tgl Pemeriksaan</th>
                    <th style="border: 1px solid black; padding: 4px; width: 15%;">Pemeriksa</th>
                    <th style="border: 1px solid black; padding: 4px; width: 10%;">Aset Diperiksa</th>
                    <th style="border: 1px solid black; padding: 4px; width: 15%;">Berdasarkan Kondisi</th>
                    <th style="border: 1px solid black; padding: 4px; width: 15%;">Berdasarkan Status</th>
                    <th style="border: 1px solid black; padding: 4px; width: 15%;">Status SPV</th>
                    <th style="border: 1px solid black; padding: 4px; width: 15%;">Status KC</th>
                </tr>
            </thead>
            <tbody>
                @if (($pemeriksaanQuery->count() ?? 0) > 0)
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($pemeriksaanGrouped as $groupKey => $details)
                        @php
                            // Memisahkan nama pemeriksa dan tanggal pemeriksaan
                            [$namaPemeriksa, $tanggalPemeriksaan] = explode('-', $groupKey);
                        @endphp
                        @foreach ($details as $key => $detail)
                            <tr>
                                <td
                                    style=" text-align: left; vertical-align: top;border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden;">
                                    {{ $no++ }}</td>
                                <td
                                    style=" text-align: left; vertical-align: top;border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden;">
                                    <b>{{ $detail->tanggal_pemeriksaan }}</b>
                                </td>
                                <td
                                    style=" text-align: left; vertical-align: top;border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden;">
                                    <b>
                                        {{ $namaPemeriksa }}
                                    </b>
                                    <br>
                                    {{ $detail->pcPengurus->pengurusJabatan->jabatan }}
                                </td>
                                <td
                                    style=" text-align: left; vertical-align: top;border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden;">
                                    @if ($detail->detailPemeriksaanAset->isNotEmpty())
                                        {{ $totalDetailPemeriksaan = $detail->detailPemeriksaanAset->count() }}
                                        Aset
                                    @else
                                        0 Aset
                                    @endif
                                </td>
                                <td
                                    style=" text-align: left; vertical-align: top;border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden;">
                                    @if ($detail->detailPemeriksaanAset->isNotEmpty())
                                        <table id="example"
                                            style="border-collapse: collapse; width: 100%; margin: 0;">
                                            <tbody>
                                                <tr>
                                                    <td style="font-size: 10px; line-height: 1.2; padding: 4px;">
                                                        baik</td>
                                                    <td style="font-size: 10px; line-height: 1.2; padding: 4px;">
                                                        {{ $baikCount = $detail->detailPemeriksaanAset->where('kondisi', 'baik')->count() }}
                                                    </td>
                                                    <td
                                                        style="text-align: right; font-size: 10px; line-height: 1.2; padding: 4px;">
                                                        {{ $totalDetailPemeriksaan > 0 ? round(($baikCount / $totalDetailPemeriksaan) * 100, 2) : 0 }}%
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 10px; line-height: 1.2; padding: 4px;">
                                                        rusak</td>
                                                    <td style="font-size: 10px; line-height: 1.2; padding: 4px;color: blue;"
                                                        class="text-primary">
                                                        {{ $rusakCount = $detail->detailPemeriksaanAset->where('kondisi', 'rusak')->count() }}
                                                    </td>
                                                    <td style="text-align: right; font-size: 10px; line-height: 1.2; padding: 4px;color: blue;"
                                                        class="text-primary">
                                                        {{ $totalDetailPemeriksaan > 0 ? round(($rusakCount / $totalDetailPemeriksaan) * 100, 2) : 0 }}%
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 10px; line-height: 1.2; padding: 4px;">
                                                        perlu perbaikan</td>
                                                    <td style="font-size: 10px; line-height: 1.2; padding: 4px;color: #ffc107;"
                                                        class="text-warning">
                                                        {{ $serviceCount = $detail->detailPemeriksaanAset->where('kondisi', 'perlu service')->count() }}
                                                    </td>
                                                    <td style="text-align: right; font-size: 10px; line-height: 1.2; padding: 4px;color: #ffc107;"
                                                        class="text-warning">
                                                        {{ $totalDetailPemeriksaan > 0 ? round(($serviceCount / $totalDetailPemeriksaan) * 100, 2) : 0 }}%
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 10px; line-height: 1.2; padding: 4px;">
                                                        hilang</td>
                                                    <td style="font-size: 10px; line-height: 1.2; padding: 4px;color: red;"
                                                        class="text-danger">
                                                        {{ $hilangCount = $detail->detailPemeriksaanAset->where('kondisi', 'hilang')->count() }}
                                                    </td>
                                                    <td style="text-align: right; font-size: 10px; line-height: 1.2; padding: 4px;color: red;"
                                                        class="text-danger">
                                                        {{ $totalDetailPemeriksaan > 0 ? round(($hilangCount / $totalDetailPemeriksaan) * 100, 2) : 0 }}%
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    @else
                                        <table id="example"
                                            style="border-collapse: collapse; width: 100%; margin: 0;">
                                            <tbody>
                                                <tr>
                                                    <td
                                                        style="font-size: 10px; line-height: 1.2; padding: 4px;width:40%;">
                                                        baik</td>
                                                    <td
                                                        style="font-size: 10px; line-height: 1.2; padding: 4px;width:30%;text-align:center;">
                                                        -</td>
                                                    <td
                                                        style="text-align: center; font-size: 10px; line-height: 1.2; padding: 4px;width:30%;">
                                                        -</td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        style="font-size: 10px; line-height: 1.2; padding: 4px;width:40%;">
                                                        rusak</td>
                                                    <td style="font-size: 10px; line-height: 1.2; padding: 4px;width:30%;text-align:center;color: blue;"
                                                        class="text-primary">-</td>
                                                    <td style="text-align:center; font-size: 10px; line-height: 1.2; padding: 4px;width:30%;color: blue;"
                                                        class="text-primary">-</td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        style="font-size: 10px; line-height: 1.2; padding: 4px;width:40%;">
                                                        perlu perbaikan</td>
                                                    <td style="font-size: 10px; line-height: 1.2; padding: 4px;width:30%;text-align:center;color: #ffc107;"
                                                        class="text-warning">-</td>
                                                    <td style="text-align:center; font-size: 10px; line-height: 1.2; padding: 4px;width:30%;color: #ffc107;"
                                                        class="text-warning">-</td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        style="font-size: 10px; line-height: 1.2; padding: 4px;width:40%;">
                                                        hilang</td>
                                                    <td style="font-size: 10px; line-height: 1.2; padding: 4px;width:30%;text-align:center;color: red;"
                                                        class="text-danger">-</td>
                                                    <td style="ttext-align:center; font-size: 10px; line-height: 1.2; padding: 4px;width:30%;color: red;"
                                                        class="text-danger">-</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    @endif
                                </td>
                                <td
                                    style=" text-align: left; vertical-align: top;border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden;">
                                    @if ($detail->detailPemeriksaanAset->isNotEmpty())
                                        <table id="example"
                                            style="border-collapse: collapse; width: 100%; margin: 0;">
                                            <tbody>
                                                <tr>
                                                    <td style="font-size: 10px; line-height: 1.2; padding: 4px;">
                                                        Aktif</td>
                                                    <td style="font-size: 10px; line-height: 1.2; padding: 4px;color: green;"
                                                        class="text-success">
                                                        {{ $aktifCount = $detail->detailPemeriksaanAset->where('status_aset', 'aktif')->count() ?? '-' }}
                                                    </td>
                                                    <td style="text-align: right; font-size: 10px; line-height: 1.2; padding: 4px;color: green;"
                                                        class="text-success">
                                                        {{ $totalDetailPemeriksaan > 0 ? round(($aktifCount / $totalDetailPemeriksaan) * 100, 2) : 0 }}%
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 10px; line-height: 1.2; padding: 4px;">
                                                        Non Aktif</td>
                                                    <td style="font-size: 10px; line-height: 1.2; padding: 4px;color: red;"
                                                        class="text-danger">
                                                        {{ $nonAktifCount = $detail->detailPemeriksaanAset->where('status_aset', 'non aktif')->count() ?? '-' }}
                                                    </td>
                                                    <td style="text-align: right; font-size: 10px; line-height: 1.2; padding: 4px;color: red;"
                                                        class="text-danger">
                                                        {{ $totalDetailPemeriksaan > 0 ? round(($nonAktifCount / $totalDetailPemeriksaan) * 100, 2) : 0 }}%
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    @else
                                        <table id="example"
                                            style="border-collapse: collapse; width: 100%; margin: 0;">
                                            <tbody>
                                                <tr>
                                                    <td style="font-size: 10px; line-height: 1.2; padding: 4px;">
                                                        Aktif</td>
                                                    <td style="font-size: 10px; line-height: 1.2; padding: 4px;color: green;"
                                                        class="text-success">-</td>
                                                    <td style="text-align: right; font-size: 10px; line-height: 1.2; padding: 4px;color: green;"
                                                        class="text-success">-</td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 10px; line-height: 1.2; padding: 4px;">
                                                        Non Aktif</td>
                                                    <td style="font-size: 10px; line-height: 1.2; padding: 4px;color: red;"
                                                        class="text-danger">-</td>
                                                    <td style="text-align: right; font-size: 10px; line-height: 1.2; padding: 4px;color: red;"
                                                        class="text-danger">-</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    @endif
                                </td>
                                <td
                                    style=" text-align: left; vertical-align: top;border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden;">
                                    <div>
                                        @if ($detail->status_spv == 'mengetahui')
                                            <div class="text-success" style="color: green;">Mengetahui</div>
                                        @else
                                            <div class="text-danger" style="color: red;">Belum Mengetahui
                                            </div>
                                        @endif
                                        <div>
                                            <b>{{ $detail->supervisor->pengguna->nama }}</b>
                                        </div>
                                        <div>
                                            {{ $detail->supervisor->pengurusJabatan->jabatan }}
                                        </div>
                                    </div>
                                </td>
                                <td
                                    style=" text-align: left; vertical-align: top;border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden;">
                                    <div>
                                        @if ($detail->status_kc == 'mengetahui')
                                            <div class="text-success" style="color: green;">Mengetahui</div>
                                        @else
                                            <div class="text-danger" style="color: red;">Belum Mengetahui
                                            </div>
                                        @endif
                                        <div><b>{{ $detail->kc->pengguna->nama }}</b>
                                        </div>
                                        <div>
                                            {{ $detail->kc->pengurusJabatan->jabatan }}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                @else
                    <tr>
                        <td colspan="10"
                            style="text-align:center; border: 1px solid black; padding: 4px; line-height: 1.2;">
                            Tidak ada data
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</body>

</html>
