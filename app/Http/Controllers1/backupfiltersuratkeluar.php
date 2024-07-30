<?php

namespace App\Http\Controllers;

use App\Models\ArsipDigital;
use App\Models\Pc;
use App\Models\Upzis;
use App\Models\Ranting;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class FilterSuratKeluarController extends Controller
{
    public function __construct()
    {
        view()->composer('*', function ($view) {

            $earsip = config('app.database_earsip');
            $siftnu = config('app.database_siftnu');
            $gocap = config('app.database_gocap');

            if (Auth::user()->gocap_id_pc_pengurus != NULL) {
                $ketua_upzis = Upzis::join($gocap . '.upzis_pengurus', $gocap . '.upzis_pengurus.id_upzis', '=', $gocap . '.upzis.id_upzis')
                    ->join($gocap . '.pengurus_jabatan', $gocap . '.pengurus_jabatan.id_pengurus_jabatan', '=', $gocap . '.upzis_pengurus.id_pengurus_jabatan')
                    ->get();

                // dd(Auth::user()->PcPengurus->Pc->id_pc);
                $id = Auth::user()->gocap_id_pc_pengurus;
                $role = 'pc';
                $nama = 'PC';
                $upzis =  Upzis::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.upzis.id_wilayah')
                    ->get();
                $ranting =  Ranting::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.ranting.id_wilayah')
                    ->get();
                $kategori = DB::table('kategori_aset')->where('id_pengguna', Auth::user()->id_pengguna)->get();
                $tahun_perolehan = DB::table('aset')->select('tahun_perolehan')->groupBy('tahun_perolehan')->get();
                $pengurus =  Pengguna::join($gocap . '.pc_pengurus', $gocap . '.pc_pengurus.id_pc_pengurus', '=', $siftnu . '.pengguna.gocap_id_pc_pengurus')
                    ->where($gocap . '.pc_pengurus.id_pc', Auth::user()->PcPengurus->id_pc)->where('id_pengguna', '!=', Auth::user()->id_pengguna)
                    ->get();
                $wilayah = Auth::user()->PcPengurus->Pc->Wilayah->nama;
            } elseif (Auth::user()->gocap_id_upzis_pengurus != NULL) {
                $ketua_upzis = Upzis::join($gocap . '.upzis_pengurus', $gocap . '.upzis_pengurus.id_upzis', '=', $gocap . '.upzis.id_upzis')
                    ->join($gocap . '.pengurus_jabatan', $gocap . '.pengurus_jabatan.id_pengurus_jabatan', '=', $gocap . '.upzis_pengurus.id_pengurus_jabatan')
                    ->get();
                $id = Auth::user()->gocap_id_upzis_pengurus;
                $role = 'upzis';
                $nama = 'UPZIS';
                $upzis =  Upzis::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.upzis.id_wilayah')->where('id_upzis', '!=', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                    ->get();
                $ranting =  Ranting::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.ranting.id_wilayah')
                    ->join($gocap . '.upzis', $gocap . '.upzis.id_upzis', '=', $gocap . '.ranting.id_upzis')->where($gocap . '.upzis.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                    ->get();
                $kategori = DB::table('kategori_aset')->where('id_pengguna', Auth::user()->id_pengguna)->get();
                $tahun_perolehan = DB::table('aset')->select('tahun_perolehan')->groupBy('tahun_perolehan')->get();
                $pengurus =  Pengguna::join($gocap . '.upzis_pengurus', $gocap . '.upzis_pengurus.id_upzis_pengurus', '=', $siftnu . '.pengguna.gocap_id_upzis_pengurus')
                    ->where($gocap . '.upzis_pengurus.id_upzis', Auth::user()->UpzisPengurus->id_upzis)->where('id_pengguna', '!=', Auth::user()->id_pengguna)
                    ->get();
                $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            } elseif (Auth::user()->gocap_id_ranting_pengurus != NULL) {
                $id = Auth::user()->gocap_id_ranting_pengurus;
                $role = 'ranting';
                $ranting = '';
                $nama = 'RANTING';
                $upzis = '';
                $kategori = DB::table('kategori_aset')->where('id_pengguna', Auth::user()->id_pengguna)->get();
                $pengurus = '';
                $tahun_perolehan = DB::table('aset')->select('tahun_perolehan')->groupBy('tahun_perolehan')->get();
                $wilayah = Auth::user()->RantingPengurus->Ranting->Wilayah->nama;
            }

            $akses = ['Semua Pengurus Internal', 'Semua UPZIS MWCNU', 'Semua Ranting NU'];

            $pc =  Pc::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.pc.id_wilayah')
                ->get();

            $view->with('role', $role)
                ->with('kategori', $kategori)
                ->with('tahun_perolehan', $tahun_perolehan)
                ->with('id', $id)
                ->with('nama', $nama)
                ->with('upzis', $upzis)
                ->with('pc', $pc)
                ->with('akses', $akses)
                ->with('ranting', $ranting)
                ->with('wilayah', $wilayah)
                ->with('ketua_upzis', $ketua_upzis)
                ->with('pengurus', $pengurus);
        });
    }


    public function filter_surat_keluar(Request $request, $part, $hal)
    {

        $tahun_arsip = ArsipDigital::select(DB::raw('YEAR(tanggal_arsip) as year'))->distinct()->get();
        $hal = $hal;
        $part = $part;
        $disposisis = $request->disposisi;
        $tahuns = $request->tahun;
        $bulans = $request->bulan;
        $klasifikasis = $request->klasifikasi;
        $tahun = DB::table('arsip_digital')->select('tanggal_arsip')->groupBy('tanggal_arsip')->distinct()->get();
        $title = 'ARSIP SURAT KELUAR';
        $page = 'Surat Keluar';

        if ($hal == 'pc') {
            $hal = 'pc';
            $part = "pc_keluar";
            $head = "Lazisnu";
            $dari = 'PC';

            if (Auth::user()->gocap_id_pc_pengurus != null) {
                if ($request->klasifikasi == "" and $request->bulan == "" and $request->tahun == "" and $request->disposisi == "") {

                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi and $request->bulan and $request->tahun and $request->disposisi) {

                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi and $request->bulan == "" and $request->tahun == "" and $request->disposisi == "") {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi == "" and $request->bulan and $request->tahun == "" and $request->disposisi == "") {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi == "" and $request->bulan == "" and $request->tahun  and $request->disposisi == "") {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi == "" and $request->bulan == "" and $request->tahun == "" and $request->disposisi) {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi  and $request->bulan and $request->tahun == "" and $request->disposisi) {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi  and $request->bulan == "" and $request->tahun and $request->disposisi) {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi  and $request->bulan == "" and $request->tahun == "" and $request->disposisi) {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi == "" and $request->bulan and $request->tahun and $request->disposisi == "") {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi == "" and $request->bulan and $request->tahun == "" and $request->disposisi) {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi == "" and $request->bulan == "" and $request->tahun  and $request->disposisi) {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi and $request->bulan and $request->tahun  and $request->disposisi == "") {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi and $request->bulan and $request->tahun == "" and $request->disposisi) {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi == "" and $request->bulan and $request->tahun and $request->disposisi) {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                }
            }

            if (Auth::user()->gocap_id_upzis_pengurus != null) {
                if ($request->klasifikasi == "" and $request->bulan == "" and $request->tahun == "" and $request->disposisi == "") {

                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi and $request->bulan and $request->tahun and $request->disposisi) {

                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi and $request->bulan == "" and $request->tahun == "" and $request->disposisi == "") {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi == "" and $request->bulan and $request->tahun == "" and $request->disposisi == "") {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi == "" and $request->bulan == "" and $request->tahun  and $request->disposisi == "") {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi == "" and $request->bulan == "" and $request->tahun == "" and $request->disposisi) {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi  and $request->bulan and $request->tahun == "" and $request->disposisi) {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi  and $request->bulan == "" and $request->tahun and $request->disposisi) {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi  and $request->bulan == "" and $request->tahun == "" and $request->disposisi) {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi == "" and $request->bulan and $request->tahun and $request->disposisi == "") {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi == "" and $request->bulan and $request->tahun == "" and $request->disposisi) {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi == "" and $request->bulan == "" and $request->tahun  and $request->disposisi) {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi and $request->bulan and $request->tahun  and $request->disposisi == "") {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi and $request->bulan and $request->tahun == "" and $request->disposisi) {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi == "" and $request->bulan and $request->tahun and $request->disposisi) {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                        ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                }
            }
        }

        if ($hal == 'upzis') {

            $hal = 'upzis';
            $part = "upzis_keluar";
            $head = "Upzis";
            $dari = 'Upzis';

            if (Auth::user()->gocap_id_pc_pengurus != null) {
                if ($request->klasifikasi == "" and $request->bulan == "" and $request->tahun == "" and $request->disposisi == "") {

                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('disposisi.id_pc', Auth::user()->PcPengurus->Pc->id_pc)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi and $request->bulan and $request->tahun and $request->disposisi) {

                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('disposisi.id_pc', Auth::user()->PcPengurus->Pc->id_pc)
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi and $request->bulan == "" and $request->tahun == "" and $request->disposisi == "") {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('disposisi.id_pc', Auth::user()->PcPengurus->Pc->id_pc)
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi == "" and $request->bulan and $request->tahun == "" and $request->disposisi == "") {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('disposisi.id_pc', Auth::user()->PcPengurus->Pc->id_pc)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi == "" and $request->bulan == "" and $request->tahun  and $request->disposisi == "") {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('disposisi.id_pc', Auth::user()->PcPengurus->Pc->id_pc)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi == "" and $request->bulan == "" and $request->tahun == "" and $request->disposisi) {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('disposisi.id_pc', Auth::user()->PcPengurus->Pc->id_pc)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi  and $request->bulan and $request->tahun == "" and $request->disposisi) {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('disposisi.id_pc', Auth::user()->PcPengurus->Pc->id_pc)
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi  and $request->bulan == "" and $request->tahun and $request->disposisi) {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('disposisi.id_pc', Auth::user()->PcPengurus->Pc->id_pc)
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi  and $request->bulan == "" and $request->tahun == "" and $request->disposisi) {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('disposisi.id_pc', Auth::user()->PcPengurus->Pc->id_pc)
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi == "" and $request->bulan and $request->tahun and $request->disposisi == "") {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('disposisi.id_pc', Auth::user()->PcPengurus->Pc->id_pc)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi == "" and $request->bulan and $request->tahun == "" and $request->disposisi) {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('disposisi.id_pc', Auth::user()->PcPengurus->Pc->id_pc)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi == "" and $request->bulan == "" and $request->tahun  and $request->disposisi) {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('disposisi.id_pc', Auth::user()->PcPengurus->Pc->id_pc)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi and $request->bulan and $request->tahun  and $request->disposisi == "") {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('disposisi.id_pc', Auth::user()->PcPengurus->Pc->id_pc)
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi and $request->bulan and $request->tahun == "" and $request->disposisi) {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('disposisi.id_pc', Auth::user()->PcPengurus->Pc->id_pc)
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi == "" and $request->bulan and $request->tahun and $request->disposisi) {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('disposisi.id_pc', Auth::user()->PcPengurus->Pc->id_pc)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                }
            }
            if (Auth::user()->gocap_id_upzis_pengurus != null) {

                if ($request->klasifikasi == "" and $request->bulan == "" and $request->tahun == "" and $request->disposisi == "") {

                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('id_pengguna', Auth::user()->id_pengguna)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi and $request->bulan and $request->tahun and $request->disposisi) {

                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('id_pengguna', Auth::user()->id_pengguna)
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi and $request->bulan == "" and $request->tahun == "" and $request->disposisi == "") {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('id_pengguna', Auth::user()->id_pengguna)
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi == "" and $request->bulan and $request->tahun == "" and $request->disposisi == "") {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('id_pengguna', Auth::user()->id_pengguna)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi == "" and $request->bulan == "" and $request->tahun  and $request->disposisi == "") {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('id_pengguna', Auth::user()->id_pengguna)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi == "" and $request->bulan == "" and $request->tahun == "" and $request->disposisi) {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('id_pengguna', Auth::user()->id_pengguna)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi  and $request->bulan and $request->tahun == "" and $request->disposisi) {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('id_pengguna', Auth::user()->id_pengguna)
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi  and $request->bulan == "" and $request->tahun and $request->disposisi) {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('id_pengguna', Auth::user()->id_pengguna)
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi  and $request->bulan == "" and $request->tahun == "" and $request->disposisi) {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('id_pengguna', Auth::user()->id_pengguna)
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi == "" and $request->bulan and $request->tahun and $request->disposisi == "") {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('id_pengguna', Auth::user()->id_pengguna)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi == "" and $request->bulan and $request->tahun == "" and $request->disposisi) {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('id_pengguna', Auth::user()->id_pengguna)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi == "" and $request->bulan == "" and $request->tahun  and $request->disposisi) {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('id_pengguna', Auth::user()->id_pengguna)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi and $request->bulan and $request->tahun  and $request->disposisi == "") {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('id_pengguna', Auth::user()->id_pengguna)
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi and $request->bulan and $request->tahun == "" and $request->disposisi) {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('id_pengguna', Auth::user()->id_pengguna)
                        ->where('klasifikasi_surat', $request->klasifikasi)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                } elseif ($request->klasifikasi == "" and $request->bulan and $request->tahun and $request->disposisi) {
                    $arsip_diterima = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();

                    $arsip_dikirim = DB::table('arsip_digital')
                        ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                        ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
                        ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                        ->where('id_pengguna', Auth::user()->id_pengguna)
                        ->whereMonth('tanggal_arsip', $request->bulan)
                        ->whereYear('tanggal_arsip', $request->tahun)
                        ->where('jenis_disposisi', $request->disposisi)
                        ->distinct('arsip_digital.arsip_digital_id')
                        ->select('arsip_digital.*')->orderby('created_at', 'desc')
                        ->get();
                }
            }
        }


        if ($request->filephp == 'surat_keluar') {
            return view('arsip.surat_keluar', compact('tahun_arsip', 'bulans', 'disposisis', 'arsip_diterima', 'arsip_dikirim', 'head', 'hal', 'page', 'title', 'klasifikasis', 'tahun', 'tahuns', 'part'));
        } else {
            return view('arsip.surat_keluar2', compact('tahun_arsip', 'bulans', 'disposisis', 'arsip_diterima', 'arsip_dikirim', 'head', 'hal', 'page', 'title', 'klasifikasis', 'tahun', 'tahuns', 'part'));
        }
    }
}
