<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <title>
        Notulen_{{ $tgl->created_at }}
    </title>
    <style>
        body {
            line-height: 108%;
            font-family: "Arial Narrow", Arial, sans-serif;
            font-size: 11pt;

        }

        @page {
            margin-right: 100px;
            margin-left: 30px;
            margin-top: 20px;
            margin-bottom: 0px;
        }



        p {
            margin: 0pt 0pt 8pt
        }

        table {
            margin-top: 0pt;
            margin-bottom: 8pt
        }

        span.Strong {
            font-weight: bold
        }
    </style>
</head>

<body>
    <table style="width:541.75pt; margin-bottom:0pt; border-collapse:collapse;">
        <tbody>
            <tr style="height:49.25pt;">
                <td colspan="2" rowspan="2"
                    style="width:142.15pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">

                    <img style="width: 100%; margin:3px; " src="{{ public_path('/images/lazisnu_notulen.png') }}">
                </td>

                <td colspan="6"
                    style="width:377.25pt;  border-right:0.75pt solid #000000;  border-top:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;">&nbsp;</p>
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;">&nbsp;</p>
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;font-size:23px;">
                        <b>NOTULENSI</b>
                    </p>
                </td>
            </tr>
            <tr style="height:57.35pt;">
                <td colspan="6"
                    style="width:377.25pt; border-bottom:0.75pt solid #000000;  border-right:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal; font-size:15px;">
                        <b>F-LAZISNU/SPO &ndash;HRD /
                            14
                            REV.00</b>
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="8"
                    style="text-align:center;border:0.75pt solid #000000;border-bottom:none; padding-top:10px;">
                    <strong>KEGIATAN</strong>
                </td>
            </tr>
            <tr style="height:16.1pt;">
                <td colspan="2"
                    style="width:142.15pt; border-left:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <br>
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;">Tanggal</p>

                </td>
                <td colspan="1"
                    style="width:36.05pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <br>
                    <p style="margin-bottom:0pt; line-height:normal;">:</p>
                </td>
                <td colspan="5" style="width:330.4pt; border-right:0.75pt  solid #000000; vertical-align:top;">
                    <br>
                    <p style="margin-bottom:0pt; line-height:normal;">
                        {{ Carbon\Carbon::parse($kegiatan->tgl_kegiatan)->isoFormat('dddd, D MMMM Y') }}
                    </p>
                </td>
            </tr>
            <tr style="height:15.4pt;">
                <td colspan="2"
                    style="width:142.15pt; border-left:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;">Tempat</p>
                </td>
                <td colspan="1" style="width:36.05pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;">:</p>
                </td>
                <td colspan="5" style="width:330.4pt;border-right:0.75pt solid #000000; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;">
                        {{ $kegiatan->lokasi_kegiatan }} </p>
                </td>
            </tr>
            <tr style="height:15.4pt;">
                <td colspan="2"
                    style="width:142.15pt; border-left:0.75pt  solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;">Nama</p> <br>
                </td>
                <td colspan="1" style="width:36.05pt;  padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;">:</p> <br>
                </td>
                <td colspan="5" style="width:330.4pt; border-right:0.75pt solid #000000; \ vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;">
                        {{ $kegiatan->nama_kegiatan }}
                    </p> <br>
                </td>
            </tr>
            <tr style="height:15.4pt;">
                <td colspan="3"
                    style="width:189pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><strong>HADIR</strong></p>
                    <br>
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;">{{ $kegiatan->hadir }} Orang
                    </p>
                    <br>

                </td>
                <td colspan="3"
                    style="width:181.45pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><strong>TIDAK HADIR</strong>
                    </p>
                    <br>
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;">{{ $kegiatan->tidak_hadir }}
                        Orang</p>
                    <br>
                </td>
                <td colspan="2"
                    style="width:138.1pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal; text-align:center; "><strong>DISTRIBUSI</strong>
                    </p>
                    <br>
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;">{{ $kegiatan->distribusi }}
                        Orang</p>
                    <br>
                </td>

            </tr>

            <tr style="height:49.25pt;">
                <td
                    style="width:29.85pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><strong>No</strong></p>
                </td>
                <td colspan="2"
                    style="width:148.35pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><strong>Pembahasan Kegiatan/Keputusan</strong></p>
                </td>
                <td
                    style="width:96.3pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;"><strong>PIC</strong></p>
                </td>
                <td colspan="3"
                    style="width:109.35pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><strong>Tanggal Rencana Penyelesaian</strong></p>
                </td>
                <td
                    style="width:103.1pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;"><strong>Tanggal Realisasi Penyelesaian</strong>
                    </p>
                </td>
            </tr>
            @foreach ($notulen as $item)
                <tr style="height:15.4pt;">
                    <td
                        style="width:29.85pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-bottom:0pt; line-height:normal;">{{ $loop->iteration }}</p>
                    </td>
                    <td colspan="2"
                        style="width:148.35pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-bottom:0pt; line-height:normal; font-size:10.5pt;">{{ $item->pembahasan }}</p>
                    </td>
                    <td
                        style="width:96.3pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-bottom:0pt; line-height:normal;">
                            @php
                                $arr = explode(',', $item->pic);
                                $hitung = count($arr);
                                for ($x = 0; $x < $hitung; $x++) {
                                    echo '<p style="font-size:13px;line-height:normal; margin:0;">' . $x + 1 . '. ' . $arr[$x] . '</p>';
                                }
                                
                            @endphp
                        </p>
                    </td>
                    <td colspan="3"
                        style="width:109.35pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-bottom:0pt; line-height:normal;">
                            {{ Carbon\Carbon::parse($item->rencana)->isoFormat('dddd, D MMMM Y') }}</p>
                    </td>
                    <td
                        style="width:103.1pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                        <p style="margin-bottom:0pt; line-height:normal;">
                            {{ Carbon\Carbon::parse($item->realisasi)->isoFormat('dddd, D MMMM Y') }}</p>
                    </td>
                </tr>
            @endforeach

            <tr style="height:82.15pt;">
                <td colspan="3"
                    style="width:189pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;">Notulis :</p>
                    <p style="margin-bottom:0pt; line-height:normal;">
                        @foreach ($notulis as $lis)
                            @php
                                $namaz = DB::connection('siftnu')
                                    ->table('pengguna')
                                    ->where('id_pengguna', $lis->pembuat)
                                    ->first();
                            @endphp
                            {{ $namaz->nama }} <br>
                        @endforeach
                    </p>
                </td>
                <td colspan="2"
                    style="width:143.05pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;">Tanggal Cetak:</p>
                    <p style="margin-bottom:0pt; line-height:normal;">
                        {{ Carbon\Carbon::parse(now())->isoFormat('dddd, D MMMM Y') }}</p>
                </td>
                <td colspan="3"
                    style="width:176.5pt; border:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;">Disetujui Oleh :</p>
                    <p style="margin-bottom:0pt; line-height:normal;"></p>
                </td>
            </tr>
            <tr style="height:0pt;">
                <td style="width:40.65pt;"><br></td>
                <td style="width:112.3pt;"><br></td>
                <td style="width:46.85pt;"><br></td>
                <td style="width:107.1pt;"><br></td>
                <td style="width:46.75pt;"><br></td>
                <td style="width:38.4pt;"><br></td>
                <td style="width:35pt;"><br></td>
                <td style="width:113.95pt;"><br></td>
            </tr>
        </tbody>
    </table>
    <p>&nbsp;</p>
</body>

</html>
