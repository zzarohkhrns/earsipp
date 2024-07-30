<?php
function makeInt($angka)
{
    if ($angka < -0.0000001) {
        return ceil($angka - 0.0000001);
    } else {
        return floor($angka + 0.0000001);
    }
}

function konvhijriah($tanggal)
{
    $array_bulan = ['Muharram', 'Safar', 'Rabiul Awwal', 'Rabiul Akhir', 'Jumadil Awwal', 'Jumadil Akhir', 'Rajab', "Sya'ban", 'Ramadhan', 'Syawwal', 'Zulqaidah', 'Zulhijjah'];

    $date = makeInt(substr($tanggal, 8, 2));
    $month = makeInt(substr($tanggal, 5, 2));
    $year = makeInt(substr($tanggal, 0, 4));

    if ($year > 1582 || ($year == '1582' && $month > 10) || ($year == '1582' && $month == '10' && $date > 14)) {
        $jd = makeInt((1461 * ($year + 4800 + makeInt(($month - 14) / 12))) / 4) + makeInt((367 * ($month - 2 - 12 * makeInt(($month - 14) / 12))) / 12) - makeInt((3 * makeInt(($year + 4900 + makeInt(($month - 14) / 12)) / 100)) / 4) + $date - 32075;
    } else {
        $jd = 367 * $year - makeInt((7 * ($year + 5001 + makeInt(($month - 9) / 7))) / 4) + makeInt((275 * $month) / 9) + $date + 1729777;
    }

    $wd = $jd % 7;
    $l = $jd - 1948440 + 10632;
    $n = makeInt(($l - 1) / 10631);
    $l = $l - 10631 * $n + 354;
    $z = makeInt((10985 - $l) / 5316) * makeInt((50 * $l) / 17719) + makeInt($l / 5670) * makeInt((43 * $l) / 15238);
    $l = $l - makeInt((30 - $z) / 15) * makeInt((17719 * $z) / 50) - makeInt($z / 16) * makeInt((15238 * $z) / 43) + 29;
    $m = makeInt((24 * $l) / 709);
    $d = $l - makeInt((709 * $m) / 24);
    $y = 30 * $n + $z - 30;
    $g = $m - 1;
    $final = "$d $array_bulan[$g] $y H";
    return $final;
}
?>
<style type="text/css">
    @page {

        margin-left: 2.55cm;
        margin-right: 2.33cm;
        margin-top: 1cm;
        margin-bottom: 1.5cm;
    }
</style>

<body style="font-size:11pt;">
    <div style="break-after:page">
        <div>
            <div style="clear:both;">
                <table cellpadding="0" cellspacing="0" style=" border-collapse:collapse;">
                    <tbody>
                        <tr>
                            <td style="width:20.5pt;  padding-left:5.4pt; vertical-align:top;">
                                <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:14pt;">
                                    <img src="{{ public_path('/images/lazisnu.png') }}" width="141" height="85">

                                </p>
                            </td>
                            <td style="width:359.3pt; padding-right:5.4pt; vertical-align:top;">
                                <p style="margin-top:0pt; margin-bottom:0pt; text-align:center; font-size:12pt;">
                                    <strong><span style="font-family:'Times New Roman'; color:#133910;">PENGURUS
                                            CABANG
                                            NAHDLATUL
                                            ULAMA CILACAP</span></strong>
                                </p>
                                <p style="margin-top:0pt; margin-bottom:0pt; text-align:center;font-size:12pt;">
                                    <strong><span
                                            style="font-family:'Times New Roman'; color:#133910;">{{ strtoupper($nama) }}</span></strong>
                                </p>
                                <p style="margin-top:0pt; margin-bottom:0pt; text-align:center;font-size:10pt;">
                                    <span style="font-family:'Times New Roman'; color:#133910;">Kantor Layanan :
                                        {{ $alamat }} Call Center : {{ $nohp }}</span>
                                </p>
                                {{-- <p style="margin-top:0pt; margin-bottom:0pt; text-align:center;"><span
                                style="font-family:'Cambria';">Telepon: 000000000000 Email:
                                lpmaarifnu@gmail.com</span></p> --}}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p
                    style="margin-top:0pt; margin-bottom:0pt; text-align:center; line-height:25%; border-bottom:2.25pt double #000000; padding-bottom:1pt;">
                    &nbsp;</p>
            </div>

            <table style="margin-top:4.85pt;  margin-right:5pt; line-height:17.5pt;">



                @if ($nomor_surat != null)
                    <tr>
                        <td width="180">
                            <span style="font-family:'Cambria';">Lampiran surat {{ $nama }}</span>
                        </td>
                    </tr>

                    <tr>
                        <td width="1080">
                            <span style="font-family:'Cambria';">Nomor Surat</span><span
                                style="font-family:'Cambria'; letter-spacing:0.45pt;">&nbsp;</span><span
                                style="font-family:'Cambria';">:</span><span
                                style="font-family:'Cambria'; letter-spacing:-0.25pt;">&nbsp;</span><strong><span
                                    style="font-family:'Cambria'; ">{{ $nomor_surat }}</span></strong>
                        </td>
                    </tr>
                @endif
                @if ($nama_dokumen != null)
                    <tr>
                        <td width="180">
                            <span style="font-family:'Cambria';">Lampiran Dokumen {{ $nama }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="1080">
                            <span style="font-family:'Cambria';">Nama Dokumen</span><span
                                style="font-family:'Cambria'; letter-spacing:0.45pt;">&nbsp;</span><span
                                style="font-family:'Cambria';">:</span><span
                                style="font-family:'Cambria'; letter-spacing:-0.25pt;">&nbsp;</span><strong><span
                                    style="font-family:'Cambria'; ">{{ $nama_dokumen }}</span></strong>
                        </td>
                    </tr>
                @endif

                {{-- @if ($nomor_memo != null)
                    <tr>
                        <td width="180">
                            <span style="font-family:'Cambria';">Lampiran Memo {{ $nama }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="1080">
                            <span style="font-family:'Cambria';">Nomor Memo</span><span
                                style="font-family:'Cambria'; letter-spacing:0.45pt;">&nbsp;</span><span
                                style="font-family:'Cambria';">:</span><span
                                style="font-family:'Cambria'; letter-spacing:-0.25pt;">&nbsp;</span><strong><span
                                    style="font-family:'Cambria'; ">{{ $nomor_memo }}</span></strong>
                        </td>
                    </tr>
                @endif --}}





                <tr>


                </tr>



                <tr>
                    @if ($tanggal_arsip != null)
                        <td width="1080">
                            <strong><span style="font-family:'Cambria'; ">
                                    {{ konvhijriah(date($tanggal_arsip)) }}</span></strong>
                        </td>
                    @endif

                    {{-- @if ($tanggal_memo != null)
                        <td width="1080">
                            <strong><span style="font-family:'Cambria'; ">
                                    {{ konvhijriah(date($tanggal_memo)) }}</span></strong>
                        </td>
                    @endif --}}
                </tr>
            </table>
            <br>
            <table>
                <tr>
                    <td width="230"><span style="font-family:'Cambria';">Daftar disposisi :</span></td>
                </tr>
            </table>
            <br>


            @if ($page == 'print_disposisi')

                @if (count($disposisi_internal) > 0)
                    <li style="list-style-type:none;"><b>Disposisi Internal :</b> </li>
                    @foreach ($disposisi_internal as $disposisi_internal)
                        <li style="list-style-type:none;">{{ $loop->iteration }}. {{ $disposisi_internal->nama }}</li>
                    @endforeach
                    <br>
                @endif

                @if (count($disposisi_pc) > 0)
                    <li style="list-style-type:none;"><b>Disposisi PC :</b> </li>
                    @foreach ($disposisi_pc as $disposisi_pc)
                        <li style="list-style-type:none;">{{ $loop->iteration }}. {{ $disposisi_pc->nama }}</li>
                    @endforeach
                    <br>
                @endif

                @if (count($disposisi_upzis) > 0)
                    <li style="list-style-type:none;"><b>Disposisi Upzis :</b> </li>
                    @foreach ($disposisi_upzis as $disposisi_upzis)
                        <li style="list-style-type:none;">{{ $loop->iteration }}. {{ $disposisi_upzis->nama }}</li>
                    @endforeach
                    <br>
                @endif

                @if (count($disposisi_ranting) > 0)
                    <li style="list-style-type:none;"><b>Disposisi Ranting :</b> </li>
                    @foreach ($disposisi_ranting as $disposisi_ranting)
                        <li style="list-style-type:none;">{{ $loop->iteration }}. {{ $disposisi_ranting->nama }}</li>
                    @endforeach
                @endif



            @endif


            {{-- Untuk Preview --}}
            @if ($page == 'preview_disposisi')

                {{-- Satuan PC --}}
                @if ($disposisi_pc != null)
                    <li style="list-style-type:none;"><b>Disposisi PC :</b> </li>
                    @foreach ($disposisi_pc as $disposisi_pc2)
                        <li style="list-style-type:none;">{{ $loop->iteration }}. {{ $disposisi_pc2->nama }}
                        </li>
                    @endforeach
                @endif


                {{-- Satuan Upzis --}}
                @if ($disposisi_upzis != null)
                    <br>
                    <li style="list-style-type:none;"><b>Disposisi Upzis :</b> </li>
                    @foreach ($disposisi_upzis as $disposisi_upzis2)
                        <li style="list-style-type:none;">{{ $loop->iteration }}. {{ $disposisi_upzis2->nama }}
                        </li>
                    @endforeach
                @endif


                {{-- Satuan Ranting --}}
                @if ($disposisi_ranting != null)
                    <br>
                    <li style="list-style-type:none;"><b>Disposisi Ranting :</b> </li>
                    @foreach ($disposisi_ranting as $disposisi_ranting2)
                        <li style="list-style-type:none;">{{ $loop->iteration }}. {{ $disposisi_ranting2->nama }}
                        </li>
                    @endforeach
                @endif


                {{-- Internal --}}
                @if ($disposisi_internal != null)
                    @foreach ($disposisi_internal as $disposisi_internal2)
                        @php
                            $jabatans = DB::connection('gocap')
                                ->table('pengurus_jabatan')
                                ->where('id_pengurus_jabatan', $disposisi_internal2->id_pengurus_jabatan)
                                ->select('jabatan')
                                ->get();
                        @endphp
                        <li style="list-style-type:none;">{{ $loop->iteration }}. {{ $disposisi_internal2->nama }}
                            @foreach ($jabatans as $item)
                                <span class="badge rounded-pill  bg-danger">
                                    <b>( {{ $item->jabatan }} )</b> </span>
                            @endforeach
                        </li>
                    @endforeach
                @endif

                @if ($jumlah == 1)

                    @if ($tabel_internal != null)
                        @foreach ($tabel_internal as $tabel_internals)
                            @php
                                $jabatans = DB::connection('gocap')
                                    ->table('pengurus_jabatan')
                                    ->where('id_pengurus_jabatan', $tabel_internals->id_pengurus_jabatan)
                                    ->select('jabatan')
                                    ->get();
                            @endphp
                            <li style="list-style-type:none;">{{ $loop->iteration }}. {{ $tabel_internals->nama }}
                                @foreach ($jabatans as $item)
                                    <span class="badge rounded-pill  bg-danger">
                                        <b>( {{ $item->jabatan }} )</b> </span>
                                @endforeach
                            </li>
                        @endforeach
                    @endif

                    @if ($tabel_upzis != null)
                        @foreach ($tabel_upzis as $tabel_upzis2)
                            <li style="list-style-type:none;">{{ $loop->iteration }}. {{ $tabel_upzis2->nama }}</li>
                        @endforeach
                    @endif



                    @if ($tabel_ranting != null)
                        @foreach ($tabel_ranting as $tabel_ranting2)
                            <li style="list-style-type:none;">{{ $loop->iteration }}. {{ $tabel_ranting2->nama }}</li>
                        @endforeach
                    @endif

                @endif

                @if ($jumlah == 2)
                    @if ($tabel_upzis != null && $tabel_internal)
                        <li style="list-style-type:none;"><b>Disposisi Internal :</b> </li>
                        @foreach ($tabel_internal as $tabel_internal2)
                            <li style="list-style-type:none;">{{ $loop->iteration }}. {{ $tabel_internal2->nama }}
                            </li>
                        @endforeach
                        <li style="list-style-type:none;"><b>Disposisi Upzis :</b> </li>
                        @foreach ($tabel_upzis as $tabel_upzis2)
                            <li style="list-style-type:none;">{{ $loop->iteration }}. {{ $tabel_upzis2->nama }}</li>
                        @endforeach
                        <br>

                    @endif
                    @if ($tabel_upzis != null && $tabel_ranting != null)
                        <li style="list-style-type:none;"><b>Disposisi Upzis :</b> </li>
                        @foreach ($tabel_upzis as $tabel_upzis2)
                            <li style="list-style-type:none;">{{ $loop->iteration }}. {{ $tabel_upzis2->nama }}</li>
                        @endforeach
                        <br>
                        <li style="list-style-type:none;"><b>Disposisi Ranting :</b> </li>
                        @foreach ($tabel_ranting as $tabel_ranting2)
                            <li style="list-style-type:none;">{{ $loop->iteration }}. {{ $tabel_ranting2->nama }}</li>
                        @endforeach
                    @endif
                    @if ($tabel_internal != null && $tabel_ranting != null)

                        <li style="list-style-type:none;"><b>Disposisi Internal :</b> </li>
                        @foreach ($tabel_internal as $tabel_internal2)
                            <li style="list-style-type:none;">{{ $loop->iteration }}. {{ $tabel_internal2->nama }}
                            </li>
                        @endforeach
                        <br>
                        <li style="list-style-type:none;"><b>Disposisi Ranting :</b> </li>
                        @foreach ($tabel_ranting as $tabel_ranting2)
                            <li style="list-style-type:none;">{{ $loop->iteration }}. {{ $tabel_ranting2->nama }}</li>
                        @endforeach
                    @endif
                @endif

                @if ($jumlah == 3)
                    @if ($tabel_upzis != null && $tabel_internal != null && $tabel_ranting != null)
                        <li style="list-style-type:none;"><b>Disposisi Internal :</b> </li>
                        @foreach ($tabel_internal as $tabel_internal2)
                            <li style="list-style-type:none;">{{ $loop->iteration }}. {{ $tabel_internal2->nama }}
                            </li>
                        @endforeach
                        <br>
                        <li style="list-style-type:none;"><b>Disposisi Upzis :</b> </li>
                        @foreach ($tabel_upzis as $tabel_upzis2)
                            <li style="list-style-type:none;">{{ $loop->iteration }}. {{ $tabel_upzis2->nama }}</li>
                        @endforeach
                        <br>

                        <li style="list-style-type:none;"><b>Disposisi Ranting :</b> </li>
                        @foreach ($tabel_ranting as $tabel_ranting2)
                            <li style="list-style-type:none;">{{ $loop->iteration }}. {{ $tabel_ranting2->nama }}</li>
                        @endforeach
                    @endif
                @endif
            @endif


            <p style="margin-top:0pt; margin-bottom:8pt;"><span style="font-family:'Cambria';">&nbsp;</span></p>
            <div style="clear:both;">
                <p style="margin-top:0pt; margin-bottom:0pt; line-height:normal;"><span
                        style="height:0pt; display:block; position:absolute; z-index:-65537;"></span>&nbsp;</p>
            </div>
        </div>
    </div>
</body>
