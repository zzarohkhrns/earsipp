<!DOCTYPE html>
<html lang="en">

<head>
    <title>Laporan Keluar Masuk Aset</title>
</head>

<body>
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

    <table class="table table-bordered"
        style="width: 100%; border-collapse: collapse; table-layout: fixed; font-size: 10px; margin-top: 10px;">
        <thead style="text-align: center; font-size:13px;">
            <tr>
                <th style="border: 1px solid black; padding: 4px;">No</th>
                <th style="border: 1px solid black; padding: 4px;">Tgl Pencatatan</th>
                <th style="border: 1px solid black; padding: 4px;">Aset Masuk</th>
                <th style="border: 1px solid black; padding: 4px;">Aset Keluar</th>
                <th style="border: 1px solid black; padding: 4px;">Status SPV</th>
                <th style="border: 1px solid black; padding: 4px;">Status KC</th>
            </tr>
        </thead>
        <tbody>
            @if($keluar_masuk_aset)
                @foreach($keluar_masuk_aset as $keluar_masuk)
                    <tr>
                        <td style="border: 1px solid black; padding: 4px;">{{ $loop->iteration }}</td>
                        <td style="border: 1px solid black; padding: 4px;">
                            <table
                                style="border-collapse: collapse; width: 100%; margin: 0;">
                                <tbody>
                                    <tr>
                                        <td
                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 2px;">
                                            <b>{{ $keluar_masuk->tanggal_pencatatan }}</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 2px;">
                                            <b>{{ $keluar_masuk->pencatat->pengguna->nama ?? '' }}</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 2px;">
                                            {{ $keluar_masuk->pencatat->PengurusJabatan->jabatan ?? '' }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td style="border: 1px solid black; padding: 4px;">
                            <table
                                style="border-collapse: collapse; width: 100%; margin: 0;">
                                <tbody>
                                    <tr>
                                        <td
                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 2px;width: 50%;">
                                            No Faktur</td>
                                        <td
                                            style="text-align: right;border: none;font-size: 13px; line-height: 1.2; padding: 2px;width: 50%;">
                                            <b>{{ !empty($keluar_masuk->masuk_no_faktur) ? $keluar_masuk->masuk_no_faktur : '-' }}</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 2px;width: 50%;">
                                            Pemasok</td>
                                        <td
                                            style="text-align: right;border: none;font-size: 13px; line-height: 1.2; padding: 2px;width: 50%;">
                                            <b>{{ !empty($keluar_masuk->masuk_nama_pemasok) ? $keluar_masuk->masuk_nama_pemasok : '-' }}</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 2px;width: 50%;">
                                            Total Kuantitas</td>
                                        <td
                                            style="text-align: right;border: none;font-size: 13px; line-height: 1.2; padding: 2px;width: 50%;">
                                            <b>{{ $keluar_masuk->detail_keluar_masuk_aset()->sum('masuk_kuantitas') }}</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"
                                            style="border: none; font-size: 13px; line-height: 1.2; padding: 2px;">
                                            {{ $keluar_masuk->masuk_keterangan }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td style="border: 1px solid black; padding: 4px;">
                            <table
                                style="border-collapse: collapse; width: 100%; margin: 0;">
                                <tbody>
                                    <tr>
                                        <td
                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 2px;width: 50%;">
                                            No Faktur</td>
                                        <td
                                            style="text-align: right;border: none;font-size: 13px; line-height: 1.2; padding: 2px;width: 50%;">
                                            <b>{{ !empty($keluar_masuk->keluar_no_faktur) ? $keluar_masuk->keluar_no_faktur : '-' }}</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 2px;width: 50%;">
                                            Penerima</td>
                                        <td
                                            style="text-align: right;border: none;font-size: 13px; line-height: 1.2; padding: 2px;width: 50%;">
                                            <b>{{ !empty($keluar_masuk->keluar_nama_penerima) ? $keluar_masuk->keluar_nama_penerima : '-' }}</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 2px;width: 50%;">
                                            Total Kuantitas</td>
                                        <td
                                            style="text-align: right;border: none;font-size: 13px; line-height: 1.2; padding: 2px;width: 50%;">
                                            <b>{{ $keluar_masuk->detail_keluar_masuk_aset()->sum('keluar_kuantitas') }}</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"
                                            style="border: none; font-size: 13px; line-height: 1.2; padding: 2px;">
                                            {{ $keluar_masuk->keluar_keterangan }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td style="border: 1px solid black; padding: 4px;">
                            <table
                                style="border-collapse: collapse; width: 100%; margin: 0;">
                                <tbody>
                                    <tr>
                                        <td
                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 2px;">
                                            @if ($keluar_masuk->status_spv == 'mengetahui')
                                                <div class="text-success">Mengetahui
                                                </div>
                                            @else
                                                <div class="text-danger">Belum
                                                    Mengetahui
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 2px;">
                                            {{ !empty($keluar_masuk->catatan_spv) ? $keluar_masuk->catatan_spv : '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 2px;">
                                            <b>{{ $keluar_masuk->supervisor->pengguna->nama }}</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 2px;">
                                            {{ $keluar_masuk->supervisor->pengurusJabatan->jabatan }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td style="border: 1px solid black; padding: 4px;">
                            <table
                                style="border-collapse: collapse; width: 100%; margin: 0;">
                                <tbody>
                                    <tr>
                                        <td
                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 2px;">
                                            @if ($keluar_masuk->status_kc == 'mengetahui')
                                                <div class="text-success">Mengetahui
                                                </div>
                                            @else
                                                <div class="text-danger">Belum
                                                    Mengetahui
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 2px;">
                                            {{ !empty($keluar_masuk->catatan_kc) ? $keluar_masuk->catatan_kc : '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 2px;">
                                            <b>{{ $keluar_masuk->kc->pengguna->nama }}</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="border: none;font-size: 13px; line-height: 1.2; padding: 2px;">
                                            {{ $keluar_masuk->kc->pengurusJabatan->jabatan }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

</body>

</html>
