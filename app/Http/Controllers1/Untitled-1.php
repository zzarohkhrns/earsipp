public function filter_dokumen(Request $request, $part)
{
$part = $part;
$tahuns = $request->tahun;
$tahun = DB::table('arsip_digital')->select('tanggal_arsip')->groupBy('tanggal_arsip')->distinct()->get();
$bulan = $request->bulan;
$klasifikasi = $request->klasifikasi;
$title = 'DOKUMEN DIGITAL';
$page = 'Dokumen Digital';
if ($request->klasifikasi == "" and $request->bulan == "" and $request->tahun == "") {
$all = DB::table('arsip_digital')->where('jenis_arsip', 'Dokumen Digital')->where('id_pengguna', Auth::user()->id_pengguna)->count();
$dokumen = DB::table('arsip_digital')->where('jenis_arsip', 'Dokumen Digital')->where('id_pengguna', Auth::user()->id_pengguna)->get();
} elseif ($request->klasifikasi and $request->bulan and $request->tahun) {
$all = DB::table('arsip_digital')->where('klasifikasi_dokumen', $request->klasifikasi)->whereMonth('tanggal_arsip', $request->bulan)->whereYear('tanggal_arsip', $request->tahun)->where('jenis_arsip', 'Dokumen Digital')->where('id_pengguna', Auth::user()->id_pengguna)->count();
$dokumen = DB::table('arsip_digital')->where('klasifikasi_dokumen', $request->klasifikasi)->whereMonth('tanggal_arsip', $request->bulan)->whereYear('tanggal_arsip', $request->tahun)->where('jenis_arsip', 'Dokumen Digital')->where('id_pengguna', Auth::user()->id_pengguna)->get();
} elseif ($request->klasifikasi and $request->bulan == "" and $request->tahun == "") {
$all = DB::table('arsip_digital')->where('klasifikasi_dokumen', $request->klasifikasi)->where('jenis_arsip', 'Dokumen Digital')->where('id_pengguna', Auth::user()->id_pengguna)->count();
$dokumen = DB::table('arsip_digital')->where('klasifikasi_dokumen', $request->klasifikasi)->where('jenis_arsip', 'Dokumen Digital')->where('id_pengguna', Auth::user()->id_pengguna)->get();
} elseif ($request->klasifikasi == "" and $request->bulan and $request->tahun == "") {
$all = DB::table('arsip_digital')->whereMonth('tanggal_arsip', $request->bulan)->where('jenis_arsip', 'Dokumen Digital')->where('id_pengguna', Auth::user()->id_pengguna)->count();
$dokumen = DB::table('arsip_digital')->whereMonth('tanggal_arsip', $request->bulan)->where('jenis_arsip', 'Dokumen Digital')->where('id_pengguna', Auth::user()->id_pengguna)->get();
} elseif ($request->klasifikasi == "" and $request->bulan == "" and $request->tahun) {
$all = DB::table('arsip_digital')->whereYear('tanggal_arsip', $request->tahun)->where('jenis_arsip', 'Dokumen Digital')->where('id_pengguna', Auth::user()->id_pengguna)->count();
$dokumen = DB::table('arsip_digital')->whereYear('tanggal_arsip', $request->tahun)->where('jenis_arsip', 'Dokumen Digital')->where('id_pengguna', Auth::user()->id_pengguna)->get();
} elseif ($request->klasifikasi and $request->bulan and $request->tahun == "") {
$all = DB::table('arsip_digital')->where('klasifikasi_dokumen', $request->klasifikasi)->whereMonth('tanggal_arsip', $request->bulan)->where('jenis_arsip', 'Dokumen Digital')->where('id_pengguna', Auth::user()->id_pengguna)->count();
$dokumen = DB::table('arsip_digital')->where('klasifikasi_dokumen', $request->klasifikasi)->whereMonth('tanggal_arsip', $request->bulan)->where('jenis_arsip', 'Dokumen Digital')->where('id_pengguna', Auth::user()->id_pengguna)->get();
} elseif ($request->klasifikasi == "" and $request->bulan and $request->tahun) {
$all = DB::table('arsip_digital')->whereMonth('tanggal_arsip', $request->bulan)->whereYear('tanggal_arsip', $request->tahun)->where('jenis_arsip', 'Dokumen Digital')->where('id_pengguna', Auth::user()->id_pengguna)->count();
$dokumen = DB::table('arsip_digital')->whereMonth('tanggal_arsip', $request->bulan)->whereYear('tanggal_arsip', $request->tahun)->where('jenis_arsip', 'Dokumen Digital')->where('id_pengguna', Auth::user()->id_pengguna)->get();
} elseif ($request->klasifikasi and $request->bulan == "" and $request->tahun) {
$all = DB::table('arsip_digital')->where('klasifikasi_dokumen', $request->klasifikasi)->whereYear('tanggal_arsip', $request->tahun)->where('jenis_arsip', 'Dokumen Digital')->where('id_pengguna', Auth::user()->id_pengguna)->count();
$dokumen = DB::table('arsip_digital')->where('klasifikasi_dokumen', $request->klasifikasi)->whereYear('tanggal_arsip', $request->tahun)->where('jenis_arsip', 'Dokumen Digital')->where('id_pengguna', Auth::user()->id_pengguna)->get();
}
return view('arsip.dokumen', compact('dokumen', 'page', 'all', 'title', 'klasifikasi', 'bulan', 'tahun', 'tahuns', 'part'));
}