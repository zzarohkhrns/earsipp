<?php

namespace App\Http\Controllers;

use App\Models\Pc;
use App\Models\Upzis;
use App\Models\Berita;
use App\Models\Ranting;
use App\Models\Pengguna;
use App\Models\FileBerita;
use Illuminate\Http\Request;
use App\Models\KategoriBerita;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class FilterBeritaController extends Controller
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
                $tgl_perolehan = DB::table('aset')->select('tgl_perolehan')->groupBy('tgl_perolehan')->get();
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
                $tgl_perolehan = DB::table('aset')->select('tgl_perolehan')->groupBy('tgl_perolehan')->get();
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
                $tgl_perolehan = DB::table('aset')->select('tgl_perolehan')->groupBy('tgl_perolehan')->get();
                $wilayah = Auth::user()->RantingPengurus->Ranting->Wilayah->nama;
            }

            $akses = ['Semua Pengurus Internal', 'Semua UPZIS MWCNU', 'Semua Ranting NU'];

            $pc =  Pc::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.pc.id_wilayah')
                ->get();

            $view->with('role', $role)
                ->with('kategori', $kategori)
                ->with('tgl_perolehan', $tgl_perolehan)
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

    public function filter_berita(Request $request)
    {

        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        $title = 'BERITA UMUM';
        $page = "Berita Umum";
        $kategoris = $request->kategori;
        $bulans = $request->bulan;
        $tahuns = $request->tahun;

        $tahun_berita = Berita::select(DB::raw('YEAR(tanggal_terbit) as year'))->groupBy('year')->orderBy('year', 'DESC')->get();

        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $daerah = Auth::user()->PcPengurus->id_pc;
            $kategori_berita = DB::table('kategori_berita')->where('id_daerah', Auth::user()->PcPengurus->id_pc)->orderby('created_at', 'desc')->get();
        } elseif (Auth::user()->gocap_id_upzis_pengurus) {
            $kategori_berita = DB::table('kategori_berita')->where('id_daerah', Auth::user()->UpzisPengurus->id_upzis)->orderby('created_at', 'desc')->get();
            $daerah = Auth::user()->UpzisPengurus->id_upzis;
        }

        if ($request->kategori == "" and $request->bulan == "" and $request->tahun == "") {
            $berita = DB::table('berita')
                ->where('id_daerah', $daerah)
                ->orderby('created_at', 'desc')->get();
        } elseif ($request->kategori  and $request->bulan and $request->tahun) {
            $berita = DB::table('berita')
                ->where('id_daerah', $daerah)
                ->where('kategori_berita', $request->kategori)
                ->whereMonth('tanggal_terbit', $request->bulan)
                ->whereYear('tanggal_terbit', $request->tahun)
                ->orderby('created_at', 'desc')->get();
        } elseif ($request->kategori and $request->bulan == "" and $request->tahun == "") {
            $berita = DB::table('berita')
                ->where('id_daerah', $daerah)
                ->where('kategori_berita', $request->kategori)
                ->orderby('created_at', 'desc')->get();
        } elseif ($request->kategori == "" and $request->bulan and $request->tahun == "") {
            $berita = DB::table('berita')
                ->where('id_daerah', $daerah)
                ->whereMonth('tanggal_terbit', $request->bulan)
                ->orderby('created_at', 'desc')->get();
        } elseif ($request->kategori == "" and $request->bulan == "" and $request->tahun) {
            $berita = DB::table('berita')
                ->where('id_daerah', $daerah)
                ->whereYear('tanggal_terbit', $request->tahun)
                ->orderby('created_at', 'desc')->get();
        } elseif ($request->kategori and $request->bulan and $request->tahun == "") {
            $berita = DB::table('berita')
                ->where('id_daerah', $daerah)
                ->where('kategori_berita', $request->kategori)
                ->whereMonth('tanggal_terbit', $request->bulan)
                ->orderby('created_at', 'desc')->get();
        } elseif ($request->kategori == "" and $request->bulan  and $request->tahun) {
            $berita = DB::table('berita')
                ->where('id_daerah', $daerah)
                ->whereMonth('tanggal_terbit', $request->bulan)
                ->whereYear('tanggal_terbit', $request->tahun)
                ->orderby('created_at', 'desc')->get();
        } elseif ($request->kategori and $request->bulan == "" and $request->tahun) {
            $berita = DB::table('berita')
                ->where('id_daerah', $daerah)
                ->where('kategori_berita', $request->kategori)
                ->whereYear('tanggal_terbit', $request->tahun)
                ->orderby('created_at', 'desc')->get();
        }

        return view('berita.berita', compact('kategori_berita', 'berita', 'page', 'title', 'tahuns', 'bulans', 'kategoris', 'tahun_berita'));
    }
}
