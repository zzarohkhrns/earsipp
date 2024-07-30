<?php

namespace App\Http\Controllers;

use App\Models\Pc;
use App\Models\Memo;
use App\Models\Upzis;
use App\Models\Ranting;
use App\Models\FileMemo;
use App\Models\Kegiatan;
use App\Models\Pengguna;
use App\Models\Disposisi;
use App\Models\PcPengurus;
use App\Models\FileKegiatan;
use Illuminate\Http\Request;
use App\Models\JenisKegiatan;
use App\Models\UpzisPengurus;
use App\Models\PengurusJabatan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class FilterKegiatanController extends Controller
{
    public function __construct()
    {
        view()->composer('*', function ($view) {
            $tahun_kegiatan = Kegiatan::select(DB::raw('YEAR(tgl_kegiatan) as year'))->groupBy('year')->orderBy('year', 'DESC')->get();
            $earsip = config('app.database_earsip');
            $siftnu = config('app.database_siftnu');
            $gocap = config('app.database_gocap');
            $jenis_kegiatan = JenisKegiatan::all();
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
                ->with('jenis_kegiatan', $jenis_kegiatan)
                ->with('id', $id)
                ->with('tahun_kegiatan', $tahun_kegiatan)
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

    public function filter_kegiatan(Request $request, $hal)
    {

        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $hal = $hal;
        $link = $request->link;
        $jenis_kegiatans = $request->jenis_kegiatan;
        $kondisis = $request->kondisi;
        $tahuns = $request->tahun;
        $bulans = $request->bulan;
        if ($hal == 'pc') {
            $halaman = "Kegiatan LAZISNU";
            $page = "pc_kegiatan";
            $title = "KEGIATAN & NOTULEN";
            if ($request->jenis_kegiatan == "" and $request->bulan == "" and $request->tahun == "") {
                $kegiatan =  Kegiatan::where('lembaga', 'PC')->orderby('created_at', 'desc')->get();
            } elseif ($request->jenis_kegiatan  and $request->bulan and $request->tahun) {
                $kegiatan =  Kegiatan::where('lembaga', 'PC')
                    ->where('jenis_kegiatan', $request->jenis_kegiatan)
                    ->whereMonth('tgl_kegiatan', $request->bulan)
                    ->whereYear('tgl_kegiatan', $request->tahun)
                    ->orderby('created_at', 'desc')->get();
            } elseif ($request->jenis_kegiatan and $request->bulan == "" and $request->tahun == "") {
                $kegiatan =  Kegiatan::where('lembaga', 'PC')
                    ->where('jenis_kegiatan', $request->jenis_kegiatan)
                    ->orderby('created_at', 'desc')->get();
            } elseif ($request->jenis_kegiatan == "" and $request->bulan and $request->tahun == "") {
                $kegiatan =  Kegiatan::where('lembaga', 'PC')
                    ->whereMonth('tgl_kegiatan', $request->bulan)
                    ->orderby('created_at', 'desc')->get();
            } elseif ($request->jenis_kegiatan == "" and $request->bulan == "" and $request->tahun) {
                $kegiatan =  Kegiatan::where('lembaga', 'PC')
                    ->whereYear('tgl_kegiatan', $request->tahun)
                    ->orderby('created_at', 'desc')->get();
            } elseif ($request->jenis_kegiatan and $request->bulan and $request->tahun == "") {
                $kegiatan =  Kegiatan::where('lembaga', 'PC')
                    ->where('jenis_kegiatan', $request->jenis_kegiatan)
                    ->whereMonth('tgl_kegiatan', $request->bulan)
                    ->orderby('created_at', 'desc')->get();
            } elseif ($request->jenis_kegiatan == "" and $request->bulan  and $request->tahun) {
                $kegiatan =  Kegiatan::where('lembaga', 'PC')
                    ->whereMonth('tgl_kegiatan', $request->bulan)
                    ->whereYear('tgl_kegiatan', $request->tahun)
                    ->orderby('created_at', 'desc')->get();
            } elseif ($request->jenis_kegiatan and $request->bulan == "" and $request->tahun) {
                $kegiatan =  Kegiatan::where('lembaga', 'PC')
                    ->where('jenis_kegiatan', $request->jenis_kegiatan)
                    ->whereYear('tgl_kegiatan', $request->tahun)
                    ->orderby('created_at', 'desc')->get();
            }

            return view('kegiatan.kegiatan', compact('halaman', 'hal', 'kegiatan', 'link', 'jenis_kegiatans', 'kondisis', 'tahuns', 'page', 'title', 'bulans'));
        } else {
            $tahun_kegiatan = Kegiatan::select(DB::raw('YEAR(tgl_kegiatan) as year'))->distinct()->get();
            $halaman = "Kegiatan UPZIS";
            $page = "upzis_kegiatan";
            $title = "KEGIATAN & NOTULEN";
            if ($request->jenis_kegiatan == "" and $request->bulan == "" and $request->tahun == "") {
                $kegiatan =  Kegiatan::where('lembaga', 'UPZIS')->orderby('created_at', 'desc')->get();
            } elseif ($request->jenis_kegiatan  and $request->bulan and $request->tahun) {
                $kegiatan =  Kegiatan::where('lembaga', 'UPZIS')
                    ->where('jenis_kegiatan', $request->jenis_kegiatan)
                    ->whereMonth('tgl_kegiatan', $request->bulan)
                    ->whereYear('tgl_kegiatan', $request->tahun)
                    ->orderby('created_at', 'desc')->get();
            } elseif ($request->jenis_kegiatan and $request->bulan == "" and $request->tahun == "") {
                $kegiatan =  Kegiatan::where('lembaga', 'UPZIS')
                    ->where('jenis_kegiatan', $request->jenis_kegiatan)
                    ->orderby('created_at', 'desc')->get();
            } elseif ($request->jenis_kegiatan == "" and $request->bulan and $request->tahun == "") {
                $kegiatan =  Kegiatan::where('lembaga', 'UPZIS')
                    ->whereMonth('tgl_kegiatan', $request->bulan)
                    ->orderby('created_at', 'desc')->get();
            } elseif ($request->jenis_kegiatan == "" and $request->bulan == "" and $request->tahun) {
                $kegiatan =  Kegiatan::where('lembaga', 'UPZIS')
                    ->whereYear('tgl_kegiatan', $request->tahun)
                    ->orderby('created_at', 'desc')->get();
            } elseif ($request->jenis_kegiatan and $request->bulan and $request->tahun == "") {
                $kegiatan =  Kegiatan::where('lembaga', 'UPZIS')
                    ->where('jenis_kegiatan', $request->jenis_kegiatan)
                    ->whereMonth('tgl_kegiatan', $request->bulan)
                    ->orderby('created_at', 'desc')->get();
            } elseif ($request->jenis_kegiatan == "" and $request->bulan  and $request->tahun) {
                $kegiatan =  Kegiatan::where('lembaga', 'UPZIS')
                    ->whereMonth('tgl_kegiatan', $request->bulan)
                    ->whereYear('tgl_kegiatan', $request->tahun)
                    ->orderby('created_at', 'desc')->get();
            } elseif ($request->jenis_kegiatan and $request->bulan == "" and $request->tahun) {
                $kegiatan =  Kegiatan::where('lembaga', 'UPZIS')
                    ->where('jenis_kegiatan', $request->jenis_kegiatan)
                    ->whereYear('tgl_kegiatan', $request->tahun)
                    ->orderby('created_at', 'desc')->get();
            }

            return view('kegiatan.kegiatan', compact('halaman', 'hal', 'tahun_kegiatan', 'kegiatan', 'link', 'jenis_kegiatans', 'kondisis', 'tahuns', 'page', 'title', 'bulans'));
        }
    }

    public function filter_kegiatan_upzis(Request $request)
    {

        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        $link = $request->link;
        $jenis_kegiatans = $request->jenis_kegiatan;
        $kondisis = $request->kondisi;
        $tahuns = $request->tahun;
        $bulans = $request->bulan;

        $tahun_kegiatan = Kegiatan::select(DB::raw('YEAR(tgl_kegiatan) as year'))->distinct()->get();
        $halaman = "Kegiatan UPZIS";
        $page = "upzis_kegiatan";
        $title = "KEGIATAN & NOTULEN";
        if ($request->jenis_kegiatan == "" and $request->bulan == "" and $request->tahun == "") {
            $kegiatan =  Kegiatan::where('lembaga', 'UPZIS')
                ->where('id_upzis', Auth::user()->UpzisPengurus->id_upzis)
                ->orderby('created_at', 'desc')->get();
        } elseif ($request->jenis_kegiatan  and $request->bulan and $request->tahun) {
            $kegiatan =  Kegiatan::where('lembaga', 'UPZIS')
                ->where('jenis_kegiatan', $request->jenis_kegiatan)
                ->whereMonth('tgl_kegiatan', $request->bulan)
                ->whereYear('tgl_kegiatan', $request->tahun)
                ->where('id_upzis', Auth::user()->UpzisPengurus->id_upzis)
                ->orderby('created_at', 'desc')->get();
        } elseif ($request->jenis_kegiatan and $request->bulan == "" and $request->tahun == "") {
            $kegiatan =  Kegiatan::where('lembaga', 'UPZIS')
                ->where('jenis_kegiatan', $request->jenis_kegiatan)
                ->where('id_upzis', Auth::user()->UpzisPengurus->id_upzis)
                ->orderby('created_at', 'desc')->get();
        } elseif ($request->jenis_kegiatan == "" and $request->bulan and $request->tahun == "") {
            $kegiatan =  Kegiatan::where('lembaga', 'UPZIS')
                ->whereMonth('tgl_kegiatan', $request->bulan)
                ->where('id_upzis', Auth::user()->UpzisPengurus->id_upzis)
                ->orderby('created_at', 'desc')->get();
        } elseif ($request->jenis_kegiatan == "" and $request->bulan == "" and $request->tahun) {
            $kegiatan =  Kegiatan::where('lembaga', 'UPZIS')
                ->whereYear('tgl_kegiatan', $request->tahun)
                ->where('id_upzis', Auth::user()->UpzisPengurus->id_upzis)
                ->orderby('created_at', 'desc')->get();
        } elseif ($request->jenis_kegiatan and $request->bulan and $request->tahun == "") {
            $kegiatan =  Kegiatan::where('lembaga', 'UPZIS')
                ->where('jenis_kegiatan', $request->jenis_kegiatan)
                ->whereMonth('tgl_kegiatan', $request->bulan)
                ->where('id_upzis', Auth::user()->UpzisPengurus->id_upzis)
                ->orderby('created_at', 'desc')->get();
        } elseif ($request->jenis_kegiatan == "" and $request->bulan  and $request->tahun) {
            $kegiatan =  Kegiatan::where('lembaga', 'UPZIS')
                ->whereMonth('tgl_kegiatan', $request->bulan)
                ->whereYear('tgl_kegiatan', $request->tahun)
                ->where('id_upzis', Auth::user()->UpzisPengurus->id_upzis)
                ->orderby('created_at', 'desc')->get();
        } elseif ($request->jenis_kegiatan and $request->bulan == "" and $request->tahun) {
            $kegiatan =  Kegiatan::where('lembaga', 'UPZIS')
                ->where('jenis_kegiatan', $request->jenis_kegiatan)
                ->whereYear('tgl_kegiatan', $request->tahun)
                ->where('id_upzis', Auth::user()->UpzisPengurus->id_upzis)
                ->orderby('created_at', 'desc')->get();
        }

        return view('kegiatan.kegiatan', compact('halaman', 'tahun_kegiatan', 'kegiatan', 'link', 'jenis_kegiatans', 'kondisis', 'tahuns', 'page', 'title', 'bulans'));
    }
}
