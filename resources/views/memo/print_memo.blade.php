<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <title>{{ $memo->nomor_memo }}</title>
    <style>
        body {
            line-height: 108%;
            font-family: Calibri;
            font-size: 11pt
        }

        p {
            margin: 0pt 0pt 8pt
        }

        li,
        table {
            margin-top: 0pt;
            margin-bottom: 8pt
        }

        .ListParagraph {
            margin-left: 36pt;
            margin-bottom: 8pt;
            line-height: 108%;
            font-size: 11pt
        }
    </style>
</head>

<body>
    <table style="margin-bottom:0pt; border:0.75pt solid #000000; border-collapse:collapse;">
        <tbody>
            <tr>
                <td style="width:512.05pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                    <p style="margin-bottom:0pt; line-height:normal;">&nbsp;</p>
                    <table style="margin-bottom:0pt; ">
                        <tbody>
                            <tr>
                                <td
                                    style="width:125.05pt; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                                    {{-- <p style="margin-bottom:0pt; line-height:normal;">&nbsp;</p> --}}
                                    <center>
                                        <img width="100px;" src="{{ public_path('/images/lazisnulogo1.png') }}">
                                    </center>


                                </td>
                                <td
                                    style="width:244.35pt;  padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                                    <p
                                        style="margin-bottom:0pt; text-align:center; line-height:normal; font-size:16pt;">
                                        <strong>MEMO INTERNAL PIMPINAN</strong>
                                    </p>
                                    <p
                                        style="margin-bottom:0pt; text-align:center; line-height:normal; font-size:16pt;">
                                        <strong>NUCARE LAZISNU CILACAP</strong>
                                    </p>
                                </td>
                                <td
                                    style="width:109.75pt;  padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                                    {{-- <p style="margin-bottom:0pt; line-height:normal;">&nbsp;</p> --}}
                                    <center>
                                        <img width="100px;" height="70px;"
                                            src="{{ public_path('/images/lazisnulogo2.png') }}">
                                    </center>

                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <p style="margin-bottom:0pt; line-height:normal;">&nbsp;</p>
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Hari, Tanggal : {{ Carbon\Carbon::parse($memo->tanggal_memo)->isoFormat('dddd, D MMMM Y') }}</p>
                    <p style="margin-bottom:0pt; line-height:normal;">&nbsp;</p>
                    <table style="margin-bottom:0pt; border:0.75pt solid #000000; border-collapse:collapse;">
                        <tbody>
                            <tr>
                                <td
                                    style="width:125.05pt; border-right:0.75pt solid #000000; border-bottom:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                                    <p style="margin-bottom:0pt; line-height:normal;">Nomor Memo</p>
                                </td>
                                <td
                                    style="width:364.9pt; border-left:0.75pt solid #000000; border-bottom:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                                    <p style="margin-bottom:0pt; line-height:normal;">{{ $memo->nomor_memo }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td
                                    style="width:125.05pt; border-top:0.75pt solid #000000; border-right:0.75pt solid #000000; border-bottom:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                                    <p style="margin-bottom:0pt; line-height:normal;">Dari</p>
                                </td>
                                @php
                                    $jaba = DB::connection('gocap')
                                        ->table('pengurus_jabatan')
                                        ->where('id_pengurus_jabatan', $jabatan->id_pengurus_jabatan)
                                        ->first();
                                @endphp

                                <td
                                    style="width:364.9pt; border-top:0.75pt solid #000000; border-left:0.75pt solid #000000; border-bottom:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                                    <p style="margin-bottom:0pt; line-height:normal;">{{ $nama_pengurus->nama }}
                                        ({{ $jaba->jabatan }})</p>
                                    {{-- <p style="margin-bottom:0pt; line-height:normal;">{{ $jaba->jabatan }}</p> --}}
                                    {{-- <p style="margin-bottom:0pt; line-height:normal;">&nbsp;</p> --}}
                                </td>
                            </tr>
                            <tr>
                                <td
                                    style="width:125.05pt; border-top:0.75pt solid #000000; border-right:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                                    <p style="margin-bottom:0pt; line-height:normal;">Kepada</p>
                                </td>
                                <td
                                    style="width:364.9pt; border-top:0.75pt solid #000000; border-left:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">

                                    @foreach ($baca_internal as $baca_internal)
                                        @php
                                            $jabatans = DB::connection('gocap')
                                                ->table('pengurus_jabatan')
                                                ->where('id_pengurus_jabatan', $baca_internal->id_pengurus_jabatan)
                                                ->select('jabatan')
                                                ->get();
                                        @endphp


                                        <p style="margin-bottom:0pt; line-height:normal;">{{ $loop->iteration }}.
                                            {{ $baca_internal->nama }}
                                            @foreach ($jabatans as $item)
                                                ({{ $item->jabatan }})
                                            @endforeach


                                        </p>
                                    @endforeach

                                    {{-- <p style="margin-bottom:0pt; line-height:normal;">&nbsp;</p> --}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <p style="margin-bottom:0pt; line-height:normal;">&nbsp;</p>
                    <table style="margin-bottom:0pt; border:0.75pt solid #000000; border-collapse:collapse;">
                        <tbody>
                            <tr>
                                <td
                                    style="width:500.75pt; border-bottom:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;">HAL</p>
                                </td>
                            </tr>
                            <tr>
                                <td
                                    style="width:500.75pt; border-top:0.75pt solid #000000; border-bottom:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                                    <b>{{ $memo->hal }}</b>

                                </td>
                            </tr>
                            <tr>
                                <td
                                    style="width:500.75pt; border-top:0.75pt solid #000000; border-bottom:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;">ISI MEMO</p>
                                </td>
                            </tr>
                            <tr>
                                <td
                                    style="width:500.75pt; border-top:0.75pt solid #000000; padding-right:5.03pt; padding-left:5.03pt; vertical-align:top;">
                                    @php
                                        echo $memo->isi_memo;
                                    @endphp
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <p style="margin-bottom:0pt; line-height:normal;">&nbsp;</p>
                    <p style="margin-bottom:0pt; line-height:normal;">&nbsp;</p>
                    <p style="margin-bottom:0pt; line-height:normal;">&nbsp;</p>
                    <p style="margin-bottom:0pt; line-height:normal;">&nbsp;</p>
                    <p style="margin-bottom:0pt; line-height:normal;">&nbsp;</p>
                    <p style="margin-bottom:0pt; line-height:normal;">&nbsp;</p>
                    <p style="margin-bottom:0pt; line-height:normal;">&nbsp;</p>
                    <p style="margin-bottom:0pt; line-height:normal;">&nbsp;</p>
                    <p style="margin-bottom:0pt; line-height:normal;">&nbsp;</p>
                    <p style="margin-bottom:0pt; line-height:normal;">&nbsp;</p>
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;">
                       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        {{ $nama_pengurus->nama }} </p>
                    <p style="margin-bottom:0pt; text-align:center; line-height:normal;">
                       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        {{ $jaba->jabatan }}</p>
                    <p style="margin-bottom:0pt; line-height:normal;">&nbsp;</p>
                    <p style="margin-bottom:0pt; line-height:normal;">&nbsp;</p>
                </td>
            </tr>
        </tbody>
    </table>
    <p>&nbsp;</p>
</body>

</html>
