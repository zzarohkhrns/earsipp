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
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="border: none; padding: 3px;">Nama Pemeriksa</td>
                <td style="border: none; padding: 3px;">:</td>
                <td style="border: none; padding: 3px;">
                    {{ $pemeriksaanAset->pcPengurus->pengguna->nama }}
                </td>
            </tr>
            <tr>
                <td style="border: none; padding: 3px;">Jabatan</td>
                <td style="border: none; padding: 3px;">:</td>
                <td style="border: none; padding: 3px;">
                    {{ $pemeriksaanAset->pcPengurus->PengurusJabatan->jabatan }}
                </td>
            </tr>
            <tr>
                <td style="border: none; padding: 3px;">Divisi</td>
                <td style="border: none; padding: 3px;">:</td>
                <td style="border: none; padding: 3px;">
                    {{ $pemeriksaanAset->pcPengurus->PengurusJabatan->divisi }}
                </td>
            </tr>
            @php
                use Carbon\Carbon;
                use Illuminate\Support\Facades\App;
                // Set locale ke bahasa Indonesia
                Carbon::setLocale('id');
                // Parse tanggal pemeriksaan menjadi objek Carbon
                $tanggalPemeriksaan = Carbon::parse($pemeriksaanAset->tanggal_pemeriksaan);
                // Format tanggal dalam bahasa Indonesia
                $hari = $tanggalPemeriksaan->translatedFormat('l'); // Nama hari dalam bahasa Indonesia
                $tanggal = $tanggalPemeriksaan->translatedFormat('d F Y'); // Format tanggal dalam bahasa Indonesia
                $formattedDate = "$hari, $tanggal";
            @endphp
            <tr>
                <td style="border: none; padding: 3px;">Hari, Tgl Pemeriksaan</td>
                <td style="border: none; padding: 3px;">:</td>
                <td style="border: none; padding: 3px;">
                    {{ $formattedDate }}
                </td>
            </tr>
            <tr>
                <td style="border: none; padding: 3px;">Nama Supervisor</td>
                <td style="border: none; padding: 3px;">:</td>
                <td style="border: none; padding: 3px;">
                    {{ $pemeriksaanAset->supervisor->pengguna->nama }}
                </td>
            </tr>
        </table>
    </div>

    <h4 style="margin-top: 10px;">HASIL PEMERIKSAAN ASET</h4>

    <h4 style="margin-top: 10px;">A. ASET DENGAN KONDISI BAIK
        ({{ $detailPemeriksaan->where('kondisi', 'baik')->count() ?? 0 }})</h4>
    <table class="table table-bordered"
        style="width: 100%; border-collapse: collapse; table-layout: fixed; font-size: 10px;">
        <thead>
            <tr>
                <th style="border: 1px solid black; padding: 4px; width: 5%;">No.</th>
                <th style="border: 1px solid black; padding: 4px; width: 15%;">Kode Aset</th>
                <th style="border: 1px solid black; padding: 4px; width: 20%;">Nama Aset</th>
                <th style="border: 1px solid black; padding: 4px; width: 15%;">Kategori</th>
                <th style="border: 1px solid black; padding: 4px; width: 15%;">Lokasi</th>
                <th style="border: 1px solid black; padding: 4px; width: 10%;">Kondisi</th>
                <th style="border: 1px solid black; padding: 4px; width: 10%;">Status</th>
                <th style="border: 1px solid black; padding: 4px; width: 10%;">Tgl Pembelian</th>
                <th style="border: 1px solid black; padding: 4px; width: 15%;">Masalah Teridentifikasi</th>
                <th style="border: 1px solid black; padding: 4px; width: 15%;">Tindakan Yang Diperlukan</th>
            </tr>
        </thead>
        <tbody>
            @if (($detailPemeriksaan->where('kondisi', 'baik')->count() ?? 0) > 0)
                @php
                    $no = 1;
                @endphp
                @foreach ($detailPemeriksaan as $data)
                    @if ($data->kondisi == 'baik')
                        <tr>
                            <td
                                style="border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden; text-align: left; vertical-align: top;">
                                {{ $no++ }}</td>
                            <td
                                style="border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden; text-align: left; vertical-align: top;">
                                {{ $data->aset->kode_aset }}</td>
                            <td
                                style="border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden; text-align: left; vertical-align: top;">
                                {{ $data->aset->nama_aset }}</td>
                            <td
                                style="border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden; text-align: left; vertical-align: top;">
                                {{ $data->aset->kategori_aset->kategori }}</td>
                            <td
                                style="border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden; text-align: left; vertical-align: top;">
                                {{ $data->aset->lokasi_penyimpanan }}</td>
                            <td
                                style="border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden; text-align: left; vertical-align: top;">
                                {{ $data->kondisi }}</td>
                            <td
                                style="border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden; text-align: left; vertical-align: top;">
                                {{ $data->status_aset }}</td>
                            <td
                                style="border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden; text-align: left; vertical-align: top;">
                                {{ $data->aset->tgl_perolehan }}</td>
                            <td
                                style="border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden; text-align: left; vertical-align: top;">
                                {{ $data->masalah_teridentifikasi }}</td>
                            <td
                                style="border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden; text-align: left; vertical-align: top;">
                                {{ $data->tindakan_diperlukan }}</td>
                        </tr>
                    @endif
                @endforeach
            @else
                <tr>
                    <td colspan="10"
                        style="text-align: center; border: 1px solid black; padding: 4px; line-height: 1.2; text-align: center;">
                        Tidak ada data
                    </td>
                </tr>
            @endif
        </tbody>
    </table>


    <h4 style="margin-top: 10px;">B. ASET DENGAN KONDISI TIDAK MEMADAI/RUSAK
        ({{ $detailPemeriksaan->where('kondisi', 'rusak')->count() ?? 0 }})</h4>
    <table class="table table-bordered"
        style="width: 100%; border-collapse: collapse; table-layout: fixed; font-size: 10px;">
        <thead>
            <tr>
                <th style="border: 1px solid black; padding: 4px; width: 5%;">No.</th>
                <th style="border: 1px solid black; padding: 4px; width: 15%;">Kode Aset</th>
                <th style="border: 1px solid black; padding: 4px; width: 20%;">Nama Aset</th>
                <th style="border: 1px solid black; padding: 4px; width: 15%;">Kategori</th>
                <th style="border: 1px solid black; padding: 4px; width: 15%;">Lokasi</th>
                <th style="border: 1px solid black; padding: 4px; width: 10%;">Kondisi</th>
                <th style="border: 1px solid black; padding: 4px; width: 10%;">Status</th>
                <th style="border: 1px solid black; padding: 4px; width: 10%;">Tgl Pembelian</th>
                <th style="border: 1px solid black; padding: 4px; width: 15%;">Masalah Teridentifikasi</th>
                <th style="border: 1px solid black; padding: 4px; width: 15%;">Tindakan Yang Diperlukan</th>
            </tr>
        </thead>
        <tbody>
            @if (($detailPemeriksaan->where('kondisi', 'rusak')->count() ?? 0) > 0)
                @php
                    $no = 1;
                @endphp
                @foreach ($detailPemeriksaan as $data)
                    @if ($data->kondisi == 'rusak')
                        <tr>
                            <td
                                style="border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden; text-align: left; vertical-align: top;">
                                {{ $no++ }}</td>
                            <td
                                style="border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden; text-align: left; vertical-align: top;">
                                {{ $data->aset->kode_aset }}</td>
                            <td
                                style="border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden; text-align: left; vertical-align: top;">
                                {{ $data->aset->nama_aset }}</td>
                            <td
                                style="border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden; text-align: left; vertical-align: top;">
                                {{ $data->aset->kategori_aset->kategori }}</td>
                            <td
                                style="border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden; text-align: left; vertical-align: top;">
                                {{ $data->aset->lokasi_penyimpanan }}</td>
                            <td
                                style="border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden; text-align: left; vertical-align: top;">
                                {{ $data->kondisi }}</td>
                            <td
                                style="border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden; text-align: left; vertical-align: top;">
                                {{ $data->status_aset }}</td>
                            <td
                                style="border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden; text-align: left; vertical-align: top;">
                                {{ $data->aset->tgl_perolehan }}</td>
                            <td
                                style="border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden; text-align: left; vertical-align: top;">
                                {{ $data->masalah_teridentifikasi }}</td>
                            <td
                                style="border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden; text-align: left; vertical-align: top;">
                                {{ $data->tindakan_diperlukan }}</td>
                        </tr>
                    @endif
                @endforeach
            @else
                <tr>
                    <td colspan="10"
                        style="text-align: center; border: 1px solid black; padding: 4px; line-height: 1.2;">
                        Tidak ada data
                    </td>
                </tr>
            @endif
        </tbody>
    </table>

    <h4 style="margin-top: 10px;">C. ASET DENGAN KONDISI PERLU PERBAIKAN
        ({{ $detailPemeriksaan->where('kondisi', 'perlu service')->count() ?? 0 }})</h4>
    <table class="table table-bordered"
        style="width: 100%; border-collapse: collapse; table-layout: fixed; font-size: 10px;">
        <thead>
            <tr>
                <th style="border: 1px solid black; padding: 4px; width: 5%;">No.</th>
                <th style="border: 1px solid black; padding: 4px; width: 15%;">Kode Aset</th>
                <th style="border: 1px solid black; padding: 4px; width: 20%;">Nama Aset</th>
                <th style="border: 1px solid black; padding: 4px; width: 15%;">Kategori</th>
                <th style="border: 1px solid black; padding: 4px; width: 15%;">Lokasi</th>
                <th style="border: 1px solid black; padding: 4px; width: 10%;">Kondisi</th>
                <th style="border: 1px solid black; padding: 4px; width: 10%;">Status</th>
                <th style="border: 1px solid black; padding: 4px; width: 10%;">Tgl Pembelian</th>
                <th style="border: 1px solid black; padding: 4px; width: 15%;">Masalah Teridentifikasi</th>
                <th style="border: 1px solid black; padding: 4px; width: 15%;">Tindakan Yang Diperlukan</th>
            </tr>
        </thead>
        <tbody>
            @if (($detailPemeriksaan->where('kondisi', 'perlu service')->count() ?? 0) > 0)
                @php
                    $no = 1;
                @endphp
                @foreach ($detailPemeriksaan as $data)
                    @if ($data->kondisi == 'perlu service')
                        <tr>
                            <td
                                style="text-align: left; vertical-align: top; border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden;">
                                {{ $no++ }}</td>
                            <td
                                style="text-align: left; vertical-align: top; border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden;">
                                {{ $data->aset->kode_aset }}</td>
                            <td
                                style="text-align: left; vertical-align: top; border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden;">
                                {{ $data->aset->nama_aset }}</td>
                            <td
                                style="text-align: left; vertical-align: top; border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden;">
                                {{ $data->aset->kategori_aset->kategori }}</td>
                            <td
                                style="text-align: left; vertical-align: top; border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden;">
                                {{ $data->aset->lokasi_penyimpanan }}</td>
                            <td
                                style="text-align: left; vertical-align: top; border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden;">
                                {{ $data->kondisi }}</td>
                            <td
                                style="text-align: left; vertical-align: top; border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden;">
                                {{ $data->status_aset }}</td>
                            <td
                                style="text-align: left; vertical-align: top; border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden;">
                                {{ $data->aset->tgl_perolehan }}</td>
                            <td
                                style="text-align: left; vertical-align: top; border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden;">
                                {{ $data->masalah_teridentifikasi }}</td>
                            <td
                                style="text-align: left; vertical-align: top; border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden;">
                                {{ $data->tindakan_diperlukan }}</td>
                        </tr>
                    @endif
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

    <h4 style="margin-top: 10px;">D. ASET HILANG ({{ $detailPemeriksaan->where('kondisi', 'hilang')->count() ?? 0 }})
    </h4>
    <table class="table table-bordered"
        style="width: 100%; border-collapse: collapse; table-layout: fixed; font-size: 10px;">
        <thead>
            <tr>
                <th style="border: 1px solid black; padding: 4px; width: 5%;">No.</th>
                <th style="border: 1px solid black; padding: 4px; width: 15%;">Kode Aset</th>
                <th style="border: 1px solid black; padding: 4px; width: 20%;">Nama Aset</th>
                <th style="border: 1px solid black; padding: 4px; width: 15%;">Kategori</th>
                <th style="border: 1px solid black; padding: 4px; width: 15%;">Lokasi</th>
                <th style="border: 1px solid black; padding: 4px; width: 10%;">Kondisi</th>
                <th style="border: 1px solid black; padding: 4px; width: 10%;">Status</th>
                <th style="border: 1px solid black; padding: 4px; width: 10%;">Tgl Pembelian</th>
                <th style="border: 1px solid black; padding: 4px; width: 15%;">Masalah Teridentifikasi</th>
                <th style="border: 1px solid black; padding: 4px; width: 15%;">Tindakan Yang Diperlukan</th>
            </tr>
        </thead>
        <tbody>
            @if (($detailPemeriksaan->where('kondisi', 'hilang')->count() ?? 0) > 0)
                @php
                    $no = 1;
                @endphp
                @foreach ($detailPemeriksaan as $data)
                    @if ($data->kondisi == 'hilang')
                        <tr>
                            <td
                                style="text-align: left; vertical-align: top; border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden;">
                                {{ $no++ }}</td>
                            <td
                                style="text-align: left; vertical-align: top; border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden;">
                                {{ $data->aset->kode_aset }}</td>
                            <td
                                style="text-align: left; vertical-align: top; border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden;">
                                {{ $data->aset->nama_aset }}</td>
                            <td
                                style="text-align: left; vertical-align: top; border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden;">
                                {{ $data->aset->kategori_aset->kategori }}</td>
                            <td
                                style="border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden;">
                                {{ $data->aset->lokasi_penyimpanan }}</td>
                            <td
                                style="text-align: left; vertical-align: top; border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden;">
                                {{ $data->kondisi }}</td>
                            <td
                                style="text-align: left; vertical-align: top; border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden;">
                                {{ $data->status_aset }}</td>
                            <td
                                style="text-align: left; vertical-align: top; border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden;">
                                {{ $data->aset->tgl_perolehan }}</td>
                            <td
                                style="text-align: left; vertical-align: top; border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden;">
                                {{ $data->masalah_teridentifikasi }}</td>
                            <td
                                style="text-align: left; vertical-align: top; border: 1px solid black; padding: 4px; line-height: 1.2; word-wrap: break-word; overflow: hidden;">
                                {{ $data->tindakan_diperlukan }}</td>
                        </tr>
                    @endif
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

    <div style="margin-top: 10px;">
        <p style="margin: 0; padding: 0;">Catatan Supervisor: @if ($pemeriksaanAset->catatan_spv)
                {{ $pemeriksaanAset->catatan_spv }}
            @else
                -
            @endif
        </p>
        <p style="margin: 0; padding: 0;">Catatan Kepala Cabang: @if ($pemeriksaanAset->catatan_kc)
                {{ $pemeriksaanAset->catatan_kc }}
            @else
                -
            @endif
        </p>
    </div>

    <div style="margin-top: 10px; text-align: center;">
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <tr>
                <td style="text-align: center; width: 30%;">
                    <p>Pemeriksa</p>
                    {{-- <img src="https://gocapv2.nucarecilacap.id/uploads/user/Halin%20Fajar%20Waskitho__1722238260.jpg" alt="ttd" style="height: 150px; margin-top: -40px;margin-bottom: -15px;padding: 0;"/>
                    <p style="padding: 0;">{{ $pemeriksaanAset->pcPengurus->pengguna->nama }}</p>
                    <p style="margin: 0; padding: 0;">{{ $pemeriksaanAset->pcPengurus->PengurusJabatan->jabatan }}</p>
                    <p style="margin: 0; padding: 0;">{{ $pemeriksaanAset->pcPengurus->PengurusJabatan->divisi }}</p> --}}
                </td>
                <td style="text-align: center; width: 30%;">
                    <p>Supervisor</p>
                    {{-- <img src="https://gocapv2.nucarecilacap.id/uploads/user/Farahdiba%20Nadya%20Natakanestri__1722397013.jpg" alt="ttd" style="height: 200px; margin-top: -65px;margin-bottom: -20px;padding: 0;"/>
                    <p style="margin: 0; padding: 0;">{{ $pemeriksaanAset->supervisor->pengguna->nama }}</p>
                    <p style="margin: 0; padding: 0;">{{ $pemeriksaanAset->supervisor->PengurusJabatan->jabatan }}</p>
                    <p style="margin: 0; padding: 0;">{{ $pemeriksaanAset->supervisor->PengurusJabatan->divisi }}</p> --}}
                </td>
                <td style="text-align: center; width: 30%;">
                    <p>Mengetahui</p>
                    {{-- <img src="https://gocapv2.nucarecilacap.id/uploads/user/Ahmad%20Fauzi,%20S.Pd.I__1722238190.jpg" alt="ttd" style="margin-bottom: 15px;height: 100px;padding: 0;"/>
                    <p style="margin: 0; padding: 0;">{{ $pemeriksaanAset->kc->pengguna->nama }}</p>
                    <p style="margin: 0; padding: 0;">{{ $pemeriksaanAset->kc->Pengurusjabatan->jabatan }}</p>
                    <p style="margin: 0; padding: 0;">NU Care Lazisnu Cilacap</p> --}}
                </td>
            </tr>
            <tr>
                <td style="text-align: center; width: 30%;">
                    @if ($pemeriksaanAset->status_pemeriksaan == 'selesai')
                        <img src="https://gocapv2.nucarecilacap.id/uploads/user/Halin%20Fajar%20Waskitho__1722238260.jpg"
                            alt="ttd"
                            style="height: 150px; margin-top: -30px;margin-bottom: -15px;padding: 0;" />
                    @endif
                </td>
                <td style="text-align: center; width: 30%;">
                    @if ($pemeriksaanAset->status_spv == 'mengetahui')
                        <img src="https://gocapv2.nucarecilacap.id/uploads/user/Farahdiba%20Nadya%20Natakanestri__1722397013.jpg"
                            alt="ttd"
                            style="height: 200px; margin-top: -72px;margin-bottom: -25px;padding: 0;" />
                    @endif
                </td>
                <td style="text-align: center; width: 30%;">
                    @if ($pemeriksaanAset->status_kc == 'mengetahui')
                        <img src="https://gocapv2.nucarecilacap.id/uploads/user/Ahmad%20Fauzi,%20S.Pd.I__1722238190.jpg"
                            alt="ttd" style="height: 100px; margin-top : -20px;padding: 0;" />
                    @endif
                </td>
            </tr>
            <tr>
                <td style="text-align: center; width: 30%;">
                    <b style="padding: 0;">{{ $pemeriksaanAset->pcPengurus->pengguna->nama }}</b>
                </td>
                <td style="text-align: center; width: 30%;">
                    <b style="padding: 0;">{{ $pemeriksaanAset->supervisor->pengguna->nama }}</b>
                </td>
                <td style="text-align: center; width: 30%;">
                    <b style="padding: 0;">{{ $pemeriksaanAset->kc->pengguna->nama }}</b>
                </td>
            </tr>
            <tr>
                <td style="text-align: center; width: 30%;">
                    <p style="margin: 0; padding: 0;">{{ $pemeriksaanAset->pcPengurus->PengurusJabatan->jabatan }}</p>
                </td>
                <td style="text-align: center; width: 30%;">
                    <p style="margin: 0; padding: 0;">{{ $pemeriksaanAset->supervisor->PengurusJabatan->jabatan }}</p>
                </td>
                <td style="text-align: center; width: 30%;">
                    <p style="margin: 0; padding: 0;">{{ $pemeriksaanAset->kc->PengurusJabatan->jabatan }}</p>
                </td>
            </tr>
            <tr>
                <td style="text-align: center; width: 30%;">
                    <p style="margin: 0; padding: 0;">{{ $pemeriksaanAset->pcPengurus->PengurusJabatan->divisi }}</p>
                </td>
                <td style="text-align: center; width: 30%;">
                    <p style="margin: 0; padding: 0;">{{ $pemeriksaanAset->supervisor->PengurusJabatan->divisi }}</p>
                </td>
                <td style="text-align: center; width: 30%;">
                    <p style="margin: 0; padding: 0;">NU Care Lazisnu Cilacap</p>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
