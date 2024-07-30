<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous" />
    <title>LEMBAR DISPOSISI SURAT KELUAR</title>
</head>

<body>
    <div>
        <div style="clear:both;">
            <table cellspacing="0" cellpadding="0" style="width:500pt; border-collapse:collapse; margin:4pt">
                <tbody>
                    <tr style="height:63.55pt;">
                        <p style="margin-top:0pt; margin-bottom:0pt; line-height:normal;"><span
                                style="height:0pt; display:block; position:absolute; z-index:-65536;"><img
                                    src="{{ public_path('/images/lazisnuclp.png') }}" width="122" height="80"
                                    alt="" style="margin: 0 0 0 auto; display: block; "></span><span
                                style="font-family:Arial;">&nbsp;</span>
                        </p>
                        <td
                            style="width:80pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.4pt; vertical-align:top;">
                            <p style="margin-top:0pt; margin-bottom:2pt; font-size:11pt;"><span
                                    style="font-family:Arial;">&nbsp;</span></p>
                        </td>
                        <td
                            style="width:410pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.4pt; padding-left:5.03pt; vertical-align:top;">
                            <p style="margin-top:0pt; margin-bottom:2pt; font-size:17pt;"><span
                                    style="font-family:Arial;">LEMBAR DISPOSISI SURAT</span></p>
                            <p style="margin-top:0pt; margin-bottom:2pt; font-size:16pt;"><span
                                    style="font-family:Arial;">NU CARE LAZISNU CILACAP</span></p>
                            <p style="margin-top:0pt; margin-bottom:2pt; font-size:14pt;"><span
                                    style="font-family:Arial;">JL. Masjid No.9 Sidanegara Cilacap Tengah
                                    Cilacap&nbsp;</span></p>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>
        <table cellspacing="0" cellpadding="0" style="width:500pt; border-collapse:collapse; margin:5pt">
            <tbody>
                <tr style="height:30pt;">
                    <td
                        style="width:63.35pt; height:15pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span
                                style="font-family:Arial;">No.
                                Surat</span></p>
                    </td>
                    <td style="width:3.1pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span
                                style="font-family:Arial;">:</span></p>
                    </td>
                    <td style="width:120pt; padding-right:3pt; padding-left:5.4pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span
                                style="font-family:Arial;">{{ $arsip->nomor_surat }}</span></p>
                    </td>
                    <td style="width:88.4pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span
                                style="font-family:Arial;">Tanggal diterima</span></p>
                    </td>
                    <td style="width:3.1pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span
                                style="font-family:Arial;">:</span></p>
                    </td>
                    <td style="width:81.6pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span style="font-family:Arial;">
                                {{ \Carbon\Carbon::parse($arsip->created_at)->translatedFormat('j F Y') }}
                            </span></p>
                    </td>

                </tr>
                <tr style="height:22.2pt;">
                    <td
                        style="width:63.35pt; height:15pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span
                                style="font-family:Arial;">Perihal</span></p>
                    </td>
                    <td style="width:3.1pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span
                                style="font-family:Arial;">:</span></p>
                    </td>
                    <td style="width:120pt; padding-right:3pt; padding-left:5.4pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span
                                style="font-family:Arial;">{{ $arsip->perihal_isi_deskripsi }}</span></p>
                    </td>
                    <td style="width:88.4pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span
                                style="font-family:Arial;">Tanggal surat</span></p>
                    </td>
                    <td style="width:3.1pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span
                                style="font-family:Arial;">:</span></p>
                    </td>
                    <td style="width:81.6pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span
                                style="font-family:Arial;">{{ \Carbon\Carbon::parse($arsip->tanggal_arsip)->translatedFormat('j F Y') }}</span>
                        </p>
                    </td>
                </tr>
                <tr style="height:22.2pt;">
                    <td style="width:30pt; height:15pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span
                                style="font-family:Arial;">Pengirim</span></p>
                    </td>
                    <td style="width:3.1pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span
                                style="font-family:Arial;">:</span></p>
                    </td>
                    <td style="width:120pt; padding-right:3pt; padding-left:5.4pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span
                                style="font-family:Arial;">{{ $arsip->pengirim_sumber }}</span></p>
                    </td>
                    <td style="width:88.4pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span
                                style="font-family:Arial;">Diinput Oleh</span></p>
                    </td>
                    <td style="width:3.1pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span
                                style="font-family:Arial;">:</span></p>
                    </td>
                    <td style="width:81.6pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span
                                style="font-family:Arial;">{{ App\Http\Controllers\ArsipDigitalController::nama_pengurus_pc($arsip->diinput_oleh) ?? '-' }}</span>
                        </p>
                    </td>
                </tr>
                <tr style="height:22.2pt;">
                    <td
                        style="width:63.35pt; height:15pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span
                                style="font-family:Arial;">Alamat</span></p>
                    </td>
                    <td style="width:3.1pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span
                                style="font-family:Arial;">:</span></p>
                    </td>
                    <td style="width:120pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span
                                style="font-family:Arial;">{{ $arsip->alamat_pengirim ?? '-' }}</span></p>
                    </td>
                    <td style="width:88.4pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span
                                style="font-family:Arial;">&nbsp;</span></p>
                    </td>
                    <td style="width:3.1pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span
                                style="font-family:Arial;">&nbsp;</span></p>
                    </td>
                    <td style="width:81.6pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span
                                style="font-family:Arial;">&nbsp;</span></p>
                    </td>
                </tr>
                <tr style="height:22.2pt;">
                    <td
                        style="width:63.35pt; height:15pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span
                                style="font-family:Arial;">Keterangan</span></p>
                    </td>
                    <td style="width:3.1pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span
                                style="font-family:Arial;">:</span></p>
                    </td>
                    <td style="width:120pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span
                                style="font-family:Arial;">{{ $arsip->keterangan_surat_keluar ?? '-' }}</span></p>
                    </td>
                    <td style="width:88.4pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span
                                style="font-family:Arial;">&nbsp;</span></p>
                    </td>
                    <td style="width:3.1pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span
                                style="font-family:Arial;">&nbsp;</span></p>
                    </td>
                    <td style="width:81.6pt; padding-right:5.4pt; padding-left:5.4pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span
                                style="font-family:Arial;">&nbsp;</span></p>
                    </td>
                </tr>
            </tbody>
        </table>
        <p style="margin-top:0pt; margin-bottom:8pt;"><span style="font-family:Arial;">&nbsp;</span></p>
        <table cellspacing="0" cellpadding="0"
            style="width:515pt; border:0.75pt solid #000000; border-collapse:collapse; margin:5pt">
            <tbody>
                <tr style="height:15.8pt;">
                    <td
                        style="width:214.6pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt;"><strong><span
                                    style="font-family:Arial;">ISI DISPOSISI</span></strong></p>
                    </td>
                    <td
                        style="width:231.35pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt;"><strong><span
                                    style="font-family:Arial;">Diteruskan Kepada:</span></strong></p>
                    </td>
                </tr>
                <tr style="height:100pt;">
                    <td rowspan="auto"
                        style="width:231.35pt; height:100pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <ol type="1" style="margin:0pt; padding-left:0pt;">
                            <li style="margin-left:32.17pt; padding-left:3.83pt; font-family:Arial; font-size:11pt;">
                                {{ $disposisi->perihal }}
                            </li>
                        </ol>
                    </td>
                    <td
                        style="width:231.35pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <ol type="1" style="margin:0pt; padding-left:0pt;">
                            @foreach ($baca_pc as $pc)
                                <li
                                    style="margin-left:32.17pt; padding-left:3.83pt; font-family:Arial; font-size:11pt;">
                                    {{ $pc->nama }}
                                </li>
                            @endforeach
                            @foreach ($baca_upzis as $baca_upzi)
                                <li
                                    style="margin-left:32.17pt; padding-left:3.83pt; font-family:Arial; font-size:11pt;">
                                    {{ $baca_upzi->nama }}
                                </li>
                            @endforeach
                            @foreach ($baca_internal as $baca_int)
                                <li
                                    style="margin-left:32.17pt; padding-left:3.83pt; font-family:Arial; font-size:11pt;">
                                    {{ $baca_int->nama }}
                                </li>
                            @endforeach
                        </ol>
                    </td>
                </tr>

                {{-- <tr>
                <td rowspan="{{ count($baca_pc) + count($baca_upzis) + count($baca_internal) }}"
                    style="width:231.35pt; border: 0.75pt solid; padding: 5.03pt; vertical-align: top;">
                    <ol type="1" style="margin:0pt; padding-left:0pt;">
                        <li style="margin-left:32.17pt; padding-left:3.83pt; font-family:Arial; font-size:11pt;">
                            {{ $disposisi->perihal }}
                        </li>
                    </ol>
                </td>
                <td style="width:231.35pt; border: 0.75pt solid; padding: 5.03pt; vertical-align: top;">
                    <ol type="1" style="margin:0pt; padding-left:0pt;">
                        @foreach ($baca_pc as $pc)
                        <li style="margin-left:32.17pt; padding-left:3.83pt; font-family:Arial; font-size:11pt;">
                            {{ $pc->nama }}
                        </li>
                        @endforeach
                        @foreach ($baca_upzis as $baca_upzi)
                        <li style="margin-left:32.17pt; padding-left:3.83pt; font-family:Arial; font-size:11pt;">
                            {{ $baca_upzi->nama }}
                        </li>
                        @endforeach
                        @foreach ($baca_internal as $baca_int)
                        <li style="margin-left:32.17pt; padding-left:3.83pt; font-family:Arial; font-size:11pt;">
                            {{ $baca_int->nama }}
                        </li>
                        @endforeach
                    </ol>
                </td>
            </tr> --}}
                <tr style="height:15.8pt;">
                    <td
                        style="width:width:231.35pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt;"><span
                                style="font-family:Arial;">Tgl.
                                {{ \Carbon\Carbon::parse($arsip->tanggal_arsip)->translatedFormat('j F Y') }}</span>
                        </p>
                    </td>
                    <td
                        style="width:231.35pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span
                                style="font-family:Arial;"></span></p>
                    </td>
                </tr>
            </tbody>
        </table>
        <p style="margin-top:0pt; margin-bottom:8pt;"><span style="font-family:Arial;">&nbsp;</span></p>
        <table cellspacing="0" cellpadding="0"
            style="width:515pt; border:0.75pt solid #000000; border-collapse:collapse; margin:5pt">
            <tbody>
                <tr style="height:15.95pt;">
                    <td
                        style="width:139.45pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt;"><strong><span
                                    style="font-family:Arial;">Diterima Oleh:</span></strong></p>
                    </td>
                    <td colspan="2"
                        style="width:306.5pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt;"><strong><span
                                    style="font-family:Arial;">Mengetahui / Menyetujui:</span></strong></p>
                    </td>
                </tr>
                <tr style="height:15.95pt;">
                    <td
                        style="width:139.45pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt;"><span
                                style="font-family:Arial;">Front Office </span></p>
                    </td>
                    <td rowspan="2"
                        style="width:150pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt;"><span
                                style="font-family:Arial;">Direktur <br> Manajemen Eksekutif</span></p>
                    </td>
                    <td rowspan="2"
                        style="width:150pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt;"><span
                                style="font-family:Arial;">Ketua <br> Nu Care Lazisnu Cilacap</span></p>
                    </td>
                </tr>
                <tr style="height:15.95pt;">
                    <td
                        style="width:139.45pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt;"><span
                                style="font-family:Arial;">Nu Care Lazisnu Cilacap</span></p>
                    </td>
                </tr>
                <tr style="height:61pt;">
                    <td
                        style="width:139.45pt; height:60pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span
                                style="font-family:Arial;">&nbsp;</span></p>
                    </td>
                    <td
                        style="width:122.25pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span
                                style="font-family:Arial;">&nbsp;</span></p>
                    </td>
                    <td
                        style="width:173.45pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span
                                style="font-family:Arial;">&nbsp;</span></p>
                    </td>
                </tr>
                <tr style="height:16.65pt;">
                    <td
                        style="width:139.45pt; border-top-style:solid; border-top-width:0.75pt; border-right-style:solid; border-right-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt;"><span
                                style="font-family:Arial;">{{ $fo }}</span></p>
                    </td>
                    <td
                        style="width:122.25pt; border-style:solid; border-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt;"><span
                                style="font-family:Arial;">{{ $nama_direktur }}</span></p>
                    </td>
                    <td
                        style="width:173.45pt; border-top-style:solid; border-top-width:0.75pt; border-left-style:solid; border-left-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt;"><span
                                style="font-family:Arial;">{{ $ketua }}</span></p>
                    </td>
                </tr>
                <tr style="height:22.3pt;">
                    <td colspan="3"
                        style="width:456.75pt; height:20pt; border-top-style:solid; border-top-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:middle;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt;"><strong><span
                                    style="font-family:Arial;">Di terima dan di arsipkan oleh:</span></strong></p>
                    </td>
                </tr>
                <tr style="height:19.3pt;">
                    <td colspan="3"
                        style="width:456.75pt; border-top-style:solid; border-top-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt;"><span
                                style="font-family:Arial;">Divisi Program dan Administrasi</span></p>
                    </td>
                </tr>
                <tr style="height:77.05pt;">
                    <td colspan="3"
                        style="width:456.75pt; height:60pt; border-top-style:solid; border-top-width:0.75pt; border-bottom-style:solid; border-bottom-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; font-size:11pt;"><span
                                style="font-family:Arial;">&nbsp;</span></p>
                    </td>
                </tr>
                <tr style="height:14.35pt;">
                    <td colspan="3"
                        style="width:456.75pt; border-top-style:solid; border-top-width:0.75pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:11pt;"><span
                                style="font-family:Arial;">{{ $nama_program }}</span></p>
                    </td>
                </tr>
            </tbody>
        </table>
        <p style="margin-top:0pt; margin-bottom:8pt;"><span style="font-family:Arial;">&nbsp;</span></p>
    </div>
</body>
