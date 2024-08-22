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
            <td style="width: 60%; text-align: center;">
                <p style="margin: 0;">Jl. Masjid No.09 Kelurahan Sidanegara, Kec. Cilacap Tengah, Kab. Cilacap</p>
                <p style="margin: 0;">Ijin Operasional Nomor: <span style="color: #008000;">062/SKA.II/LAZISNU-PBNU/IX/2022</span></p>
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
        <h2 style="margin: 0;">FORM PEMERIKSAAN ASET</h2>
        <p style="margin: 0;">MANAJEMEN EKSEKUTIF NU CARE LAZISNU CILACAP</p>
    </div>

    <div style="margin-top: 20px;">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="border: none; padding: 3px;">Nama Pemeriksa</td>
                <td style="border: none; padding: 3px;">
                    {{ $pemeriksaanAset->pcPengurus->pengguna->nama }}
                    {{-- {{ $inspections->inspector_name }} --}}
                </td>
            </tr>
            <tr>
                <td style="border: none; padding: 3px;">Jabatan</td>
                <td style="border: none; padding: 3px;">
                    {{ $pemeriksaanAset->pcPengurus->PengurusJabatan->jabatan }}
                    {{-- {{ $inspections->inspector_position }} --}}
                </td>
            </tr>
            <tr>
                <td style="border: none; padding: 3px;">Divisi</td>
                <td style="border: none; padding: 3px;">
                    {{ $pemeriksaanAset->pcPengurus->PengurusJabatan->divisi }}
                    {{-- {{ $inspections->inspector_division }} --}}
                </td>
            </tr>
            <tr>
                <td style="border: none; padding: 3px;">Hari, Tgl Pemeriksaan</td>
                <td style="border: none; padding: 3px;">
                    {{ $pemeriksaanAset->tanggal_pemeriksaan.', '.$pemeriksaanAset->tanggal_pemeriksaan }}
                    {{-- {{ $inspections->inspection_date }} --}}
                </td>
            </tr>
            <tr>
                <td style="border: none; padding: 3px;">Nama Supervisor</td>
                <td style="border: none; padding: 3px;">
                    {{ $pemeriksaanAset->supervisor->pengguna->nama }}
                    {{-- {{ $inspections->supervisor_name }} --}}
                </td>
            </tr>
        </table>
    </div>

    <h3 style="margin-top: 20px;">HASIL PEMERIKSAAN ASET</h3>

    <h4 style="margin-top: 10px;">A. ASET DENGAN KONDISI BAIK</h4>
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="border: 1px solid black; padding: 8px;">NO</th>
                <th style="border: 1px solid black; padding: 8px;">KODE ASET</th>
                <th style="border: 1px solid black; padding: 8px;">NAMA ASET</th>
                <th style="border: 1px solid black; padding: 8px;">KATEGORI</th>
                <th style="border: 1px solid black; padding: 8px;">LOKASI ASET</th>
                <th style="border: 1px solid black; padding: 8px;">KONDISI ASET</th>
                <th style="border: 1px solid black; padding: 8px;">STATUS ASET</th>
                <th style="border: 1px solid black; padding: 8px;">TGL PEMBELIAN</th>
                <th style="border: 1px solid black; padding: 8px;">TGL PEMERIKSAAN</th>
                <th style="border: 1px solid black; padding: 8px;">KETERANGAN</th>
            </tr>
        </thead>
        <tbody>
            {{-- @foreach ($inspections->where('condition', 'Baik') as $inspection) --}}
            <tr>
                <td style="border: 1px solid black; padding: 8px;">
                    {{-- {{ $loop->iteration }} --}}
                </td>
                <td style="border: 1px solid black; padding: 8px;">
                    {{-- {{ $inspection->asset_code }} --}}
                </td>
                <td style="border: 1px solid black; padding: 8px;">
                    {{-- {{ $inspection->asset_name }} --}}
                </td>
                <td style="border: 1px solid black; padding: 8px;">
                    {{-- {{ $inspection->category }} --}}
                </td>
                <td style="border: 1px solid black; padding: 8px;">
                    {{-- {{ $inspection->location }} --}}
                </td>
                <td style="border: 1px solid black; padding: 8px;">
                    {{-- {{ $inspection->condition }} --}}
                </td>
                <td style="border: 1px solid black; padding: 8px;">
                    {{-- {{ $inspection->status }} --}}
                </td>
                <td style="border: 1px solid black; padding: 8px;">
                    {{-- {{ $inspection->purchase_date }} --}}
                </td>
                <td style="border: 1px solid black; padding: 8px;">
                    {{-- {{ $inspection->inspection_date }} --}}
                </td>
                <td style="border: 1px solid black; padding: 8px;">
                    {{-- {{ $inspection->notes }} --}}
                </td>
            </tr>
            {{-- @endforeach --}}
        </tbody>
    </table>

    <h4 style="margin-top: 20px;">B. ASET DENGAN KONDISI TIDAK MEMADAI/RUSAK</h4>
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="border: 1px solid black; padding: 8px;">NO</th>
                <th style="border: 1px solid black; padding: 8px;">KODE ASET</th>
                <th style="border: 1px solid black; padding: 8px;">NAMA ASET</th>
                <th style="border: 1px solid black; padding: 8px;">KATEGORI</th>
                <th style="border: 1px solid black; padding: 8px;">LOKASI ASET</th>
                <th style="border: 1px solid black; padding: 8px;">KONDISI ASET</th>
                <th style="border: 1px solid black; padding: 8px;">STATUS ASET</th>
                <th style="border: 1px solid black; padding: 8px;">TGL PEMBELIAN</th>
                <th style="border: 1px solid black; padding: 8px;">TGL PEMERIKSAAN</th>
                <th style="border: 1px solid black; padding: 8px;">KETERANGAN</th>
            </tr>
        </thead>
        <tbody>
            {{-- @foreach ($inspections->where('condition', 'Rusak') as $inspection) --}}
            <tr>
                <td style="border: 1px solid black; padding: 8px;">
                    {{-- {{ $loop->iteration }} --}}
                </td>
                <td style="border: 1px solid black; padding: 8px;">
                    {{-- {{ $inspection->asset_code }} --}}
                </td>
                <td style="border: 1px solid black; padding: 8px;">
                    {{-- {{ $inspection->asset_name }} --}}
                </td>
                <td style="border: 1px solid black; padding: 8px;">
                    {{-- {{ $inspection->category }} --}}
                </td>
                <td style="border: 1px solid black; padding: 8px;">
                    {{-- {{ $inspection->location }} --}}
                </td>
                <td style="border: 1px solid black; padding: 8px;">
                    {{-- {{ $inspection->condition }} --}}
                </td>
                <td style="border: 1px solid black; padding: 8px;">
                    {{-- {{ $inspection->status }} --}}
                </td>
                <td style="border: 1px solid black; padding: 8px;">
                    {{-- {{ $inspection->purchase_date }} --}}
                </td>
                <td style="border: 1px solid black; padding: 8px;">
                    {{-- {{ $inspection->inspection_date }} --}}
                </td>
                <td style="border: 1px solid black; padding: 8px;">
                    {{-- {{ $inspection->notes }} --}}
                </td>
            </tr>
            {{-- @endforeach --}}
        </tbody>
    </table>

    <h4 style="margin-top: 20px;">C. ASET DENGAN KONDISI PERLU PERBAIKAN (2)</h4>
<table style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr>
            <th style="border: 1px solid black; padding: 8px;">NO</th>
            <th style="border: 1px solid black; padding: 8px;">KODE ASET</th>
            <th style="border: 1px solid black; padding: 8px;">NAMA ASET</th>
            <th style="border: 1px solid black; padding: 8px;">KATEGORI</th>
            <th style="border: 1px solid black; padding: 8px;">LOKASI ASET</th>
            <th style="border: 1px solid black; padding: 8px;">KONDISI ASET</th>
            <th style="border: 1px solid black; padding: 8px;">STATUS ASET</th>
            <th style="border: 1px solid black; padding: 8px;">TGL PEMBELIAN</th>
            <th style="border: 1px solid black; padding: 8px;">TGL PEMERIKSAAN</th>
            <th style="border: 1px solid black; padding: 8px;">KETERANGAN</th>
        </tr>
    </thead>
    <tbody>
        {{-- @foreach ($inspections->where('condition', 'Rusak') as $inspection) --}}
        <tr>
            <td style="border: 1px solid black; padding: 8px;">
                {{-- {{ $loop->iteration }} --}}
            </td>
            <td style="border: 1px solid black; padding: 8px;">
                {{-- {{ $inspection->asset_code }} --}}
            </td>
            <td style="border: 1px solid black; padding: 8px;">
                {{-- {{ $inspection->asset_name }} --}}
            </td>
            <td style="border: 1px solid black; padding: 8px;">
                {{-- {{ $inspection->category }} --}}
            </td>
            <td style="border: 1px solid black; padding: 8px;">
                {{-- {{ $inspection->location }} --}}
            </td>
            <td style="border: 1px solid black; padding: 8px;">
                {{-- {{ $inspection->condition }} --}}
            </td>
            <td style="border: 1px solid black; padding: 8px;">
                {{-- {{ $inspection->status }} --}}
            </td>
            <td style="border: 1px solid black; padding: 8px;">
                {{-- {{ $inspection->purchase_date }} --}}
            </td>
            <td style="border: 1px solid black; padding: 8px;">
                {{-- {{ $inspection->inspection_date }} --}}
            </td>
            <td style="border: 1px solid black; padding: 8px;">
                {{-- {{ $inspection->notes }} --}}
            </td>
        </tr>
        {{-- @endforeach --}}
    </tbody>
</table>

<h4 style="margin-top: 20px;">D. ASET HILANG (2)</h4>
<table style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr>
            <th style="border: 1px solid black; padding: 8px;">NO</th>
            <th style="border: 1px solid black; padding: 8px;">KODE ASET</th>
            <th style="border: 1px solid black; padding: 8px;">NAMA ASET</th>
            <th style="border: 1px solid black; padding: 8px;">KATEGORI</th>
            <th style="border: 1px solid black; padding: 8px;">LOKASI ASET</th>
            <th style="border: 1px solid black; padding: 8px;">KONDISI ASET</th>
            <th style="border: 1px solid black; padding: 8px;">STATUS ASET</th>
            <th style="border: 1px solid black; padding: 8px;">TGL PEMBELIAN</th>
            <th style="border: 1px solid black; padding: 8px;">TGL PEMERIKSAAN</th>
            <th style="border: 1px solid black; padding: 8px;">KETERANGAN</th>
        </tr>
    </thead>
    <tbody>
        {{-- @foreach ($inspections->where('condition', 'Rusak') as $inspection) --}}
        <tr>
            <td style="border: 1px solid black; padding: 8px;">
                {{-- {{ $loop->iteration }} --}}
            </td>
            <td style="border: 1px solid black; padding: 8px;">
                {{-- {{ $inspection->asset_code }} --}}
            </td>
            <td style="border: 1px solid black; padding: 8px;">
                {{-- {{ $inspection->asset_name }} --}}
            </td>
            <td style="border: 1px solid black; padding: 8px;">
                {{-- {{ $inspection->category }} --}}
            </td>
            <td style="border: 1px solid black; padding: 8px;">
                {{-- {{ $inspection->location }} --}}
            </td>
            <td style="border: 1px solid black; padding: 8px;">
                {{-- {{ $inspection->condition }} --}}
            </td>
            <td style="border: 1px solid black; padding: 8px;">
                {{-- {{ $inspection->status }} --}}
            </td>
            <td style="border: 1px solid black; padding: 8px;">
                {{-- {{ $inspection->purchase_date }} --}}
            </td>
            <td style="border: 1px solid black; padding: 8px;">
                {{-- {{ $inspection->inspection_date }} --}}
            </td>
            <td style="border: 1px solid black; padding: 8px;">
                {{-- {{ $inspection->notes }} --}}
            </td>
        </tr>
        {{-- @endforeach --}}
    </tbody>
</table>

<div style="margin-top: 20px;">
    <p>Catatan Supervisor: -</p>
    <p>Catatan Kepala Cabang: -</p>
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
</div>

</body>

</html>
