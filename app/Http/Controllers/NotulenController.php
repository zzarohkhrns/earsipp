<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Pc;
use App\Models\Memo;
use App\Models\Upzis;
use App\Models\Notulen;
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

class NotulenController extends Controller
{
    public function __construct()
    {
        view()->composer('*', function ($view) {
            $tahun_kegiatan = Kegiatan::select(DB::raw('YEAR(tgl_kegiatan) as year'))->distinct()->get();
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
                ->with('tahun_kegiatan', $tahun_kegiatan)
                ->with('tahun_perolehan', $tahun_perolehan)
                ->with('jenis_kegiatan', $jenis_kegiatan)
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

    public function notulen_kegiatan($id, $hal)
    {

        $ids = $id;
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $title = 'KEGIATAN & NOTULEN ';
        $hal = $hal;
        $kegiatan = Kegiatan::where('kegiatan_id', $id)->first();
        $notulen = Notulen::where('kegiatan_id', $id)->orderby('created_at', 'desc')->get();

        if ($hal == 'pc') {
            $page = "pc_kegiatan";
            $halaman = "Detail Kegiatan";
            $hals = "Kegiatan LAZISNU";
        } else {
            $page = "upzis_kegiatan";
            $halaman = 'Detail Kegiatan ';
            $hals = "Kegiatan UPZIS";
        }

        return view('kegiatan.notulen', compact('notulen', 'ids', 'halaman', 'hals', 'page', 'hal',  'title', 'kegiatan'));
    }

    public function notulen_kegiatan_upzis($id)
    {

        $ids = $id;
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $title = 'KEGIATAN & NOTULEN ';
        $kegiatan = Kegiatan::where('kegiatan_id', $id)->first();
        $notulen = Notulen::where('kegiatan_id', $id)->orderby('created_at', 'desc')->get();


        $page = "upzis_kegiatan";
        $halaman = 'Detail Kegiatan ';
        $hals = "Kegiatan UPZIS";


        return view('kegiatan.notulen', compact('notulen', 'ids', 'halaman', 'hals', 'page', 'title', 'kegiatan'));
    }


    public function print_notulen($id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $kegiatan = Kegiatan::where('kegiatan_id', $id)->first();
        $notulen = Notulen::where('kegiatan_id', $id)->get();
        $notulis = DB::table('notulen')->where('kegiatan_id', $id)->distinct()->groupBy('pembuat')->select('pembuat')->get();
        $ids = $id;
        $tgl =  Notulen::where('kegiatan_id', $id)->orderBy('created_at', 'DESC')->first();
        $pdf = PDF::loadview('kegiatan.print_notulen', ['notulen' => $notulen, 'tgl' => $tgl, 'notulis' => $notulis, 'kegiatan' => $kegiatan, 'ids' => $ids])->setPaper('a4');
        return $pdf->stream()->withHeaders([
            'Title' => 'Your meta title',
            'Content-Type' => 'application/pdf',
            'Cache-Control' => 'no-store, no-cache',
            'Content-Disposition' => 'filename="' . $tgl->created_at . '_NOTULEN.pdf',
        ]);;
    }

    public function aksi_tambah_notulen(Request $request, $id_kegiatan)
    {

        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');


        Notulen::create([
            'notulen_id' => uniqid(),
            'kegiatan_id' =>  $id_kegiatan,
            'pembuat' => Auth::user()->id_pengguna,
            'pembahasan' => $request->pembahasan,
            'pic' => implode(' , ', $request->pic),
            'tgl_rencana' => $request->tgl_rencana,
            'tgl_realisasi' => $request->tgl_realisasi,

        ]);



        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('Notulen ' . $cek . ' Berhasil Ditambahkan');


        return back()->with('success', 'Data berhasil ditambahkan');
    }

    public function aksi_ubah_kehadiran(Request $request, $id_kegiatan)
    {

        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');


        Kegiatan::where('kegiatan_id', $id_kegiatan)->update([
            'hadir' => $request->hadir,
            'tidak_hadir' => $request->tidak_hadir,
            'distribusi' => $request->distribusi,
        ]);


        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('Daftar Hadir Kegiatan ' . $cek . ' Berhasil Diubah');

        return back();
    }

    public function aksi_edit_notulen(Request $request, $id_kegiatan, $notulen_id)
    {

        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        Notulen::where('notulen_id', $notulen_id)->delete();

        Notulen::create([
            'notulen_id' => uniqid(),
            'kegiatan_id' =>  $id_kegiatan,
            'pembuat' => Auth::user()->id_pengguna,
            'pembahasan' => $request->pembahasan,
            'pic' => implode(' , ', $request->pic),
            'tgl_rencana' => $request->tgl_rencana,
            'tgl_realisasi' => $request->tgl_realisasi,

        ]);


        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('Notulen Kegiatan ' . $cek . ' Berhasil Diubah');

        return back();
    }

    public function  aksi_hapus_notulen(Request $request, $id)
    {

        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        Notulen::where('notulen_id', $id)->delete();

        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('Notulen ' . $cek . ' Berhasil Dihapus');
        return back();
    }
}
