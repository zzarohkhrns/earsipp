<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Aset;
use App\Models\FileAset;
use App\Models\Pengguna;
use App\Models\KategoriAset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FilterAsetController extends Controller
{
    public function __construct()
    {
        view()->composer('*', function ($view) {

            $earsip = config('app.database_earsip');
            $siftnu = config('app.database_siftnu');
            $gocap = config('app.database_gocap');
            if (Auth::user()->gocap_id_pc_pengurus != NULL) {
                $role = 'pc';
                $wilayah = Auth::user()->PcPengurus->Pc->Wilayah->nama;
            } elseif (Auth::user()->gocap_id_upzis_pengurus != NULL) {
                $role = 'upzis';
                $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            } elseif (Auth::user()->gocap_id_ranting_pengurus != NULL) {
                $wilayah = Auth::user()->RantingPengurus->Ranting->Wilayah->nama;
                $role = 'ranting';
            }

            $view->with('role', $role)
                ->with('wilayah', $wilayah);
        });
    }

    public function filter_aset(Request $request)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        if (Auth::user()->gocap_id_pc_pengurus != NULL) {
            $id_daerah = Auth::user()->PcPengurus->id_pc;
        }
        if (Auth::user()->gocap_id_upzis_pengurus != NULL) {
            $id_daerah = Auth::user()->UpzisPengurus->id_upzis;
        }

        $link = $request->link;
        $kategoris = $request->kategori;
        $kondisis = $request->kondisi;
        $tahuns = $request->tahun;
        if ($request->link == 'umum') {
            $kategori = DB::table('kategori_aset')
                ->where('id_daerah', $id_daerah)
                ->orderby('created_at', 'desc')
                ->get();
            $tahun_perolehan = DB::table('aset')->select('tahun_perolehan')->where('jenis_aset', 'Umum')->groupBy('tahun_perolehan')->get();
            $page = 'Aset Umum';
            $title = "DATA ASET UMUM";
            if ($request->kategori == "" and $request->kondisi == "" and $request->tahun == "") {
                $aset = DB::table('aset')->where('jenis_aset', 'Umum')->where('id_daerah', $id_daerah)->orderby('created_at', 'desc')->get();
            } elseif ($request->kategori  and $request->kondisi and $request->tahun) {
                $aset = DB::table('aset')->where('kategori', $request->kategori)->where('kondisi', $request->kondisi)->where('tahun_perolehan', $request->tahun)->where('jenis_aset', 'Umum')->where('id_daerah', $id_daerah)->orderby('created_at', 'desc')->get();
            } elseif ($request->kategori and $request->kondisi == "" and $request->tahun == "") {
                $aset = DB::table('aset')->where('kategori', $request->kategori)->where('jenis_aset', 'Umum')->where('id_daerah', $id_daerah)->orderby('created_at', 'desc')->get();
            } elseif ($request->kategori == "" and $request->kondisi and $request->tahun == "") {
                $aset = DB::table('aset')->where('kondisi', $request->kondisi)->where('jenis_aset', 'Umum')->where('id_daerah', $id_daerah)->orderby('created_at', 'desc')->get();
            } elseif ($request->kategori == "" and $request->kondisi == "" and $request->tahun) {
                $aset = DB::table('aset')->where('tahun_perolehan', $request->tahun)->where('jenis_aset', 'Umum')->where('id_daerah', $id_daerah)->orderby('created_at', 'desc')->get();
            } elseif ($request->kategori and $request->kondisi and $request->tahun == "") {
                $aset = DB::table('aset')->where('kategori', $request->kategori)->where('kondisi', $request->kondisi)->where('jenis_aset', 'Umum')->where('id_daerah', $id_daerah)->orderby('created_at', 'desc')->get();
            } elseif ($request->kategori == "" and $request->kondisi  and $request->tahun) {
                $aset = DB::table('aset')->where('kondisi', $request->kondisi)->where('tahun_perolehan', $request->tahun)->where('jenis_aset', 'Umum')->where('id_daerah', $id_daerah)->orderby('created_at', 'desc')->get();
            } elseif ($request->kategori and $request->kondisi == "" and $request->tahun) {
                $aset = DB::table('aset')->where('kategori', $request->kategori)->where('tahun_perolehan', $request->tahun)->where('jenis_aset', 'Umum')->where('id_daerah', $id_daerah)->orderby('created_at', 'desc')->get();
            }

            return view('aset.aset', compact('tahun_perolehan', 'kategori', 'aset', 'link', 'kategoris', 'kondisis', 'tahuns', 'page', 'title'));
        } else {
            $kategori = DB::table('kategori_aset')
                ->where('id_daerah', $id_daerah)
                ->orderby('created_at', 'desc')
                ->get();
            $page = 'Aset Wakaf';
            $tahun_perolehan = DB::table('aset')->select('tahun_perolehan')->where('jenis_aset', 'Wakaf')->groupBy('tahun_perolehan')->get();
            $title = "DATA ASET WAKAF";
            if ($request->kategori == "" and $request->kondisi == "" and $request->tahun == "") {
                $aset = DB::table('aset')->where('jenis_aset', 'Wakaf')->where('id_daerah', $id_daerah)->orderby('created_at', 'desc')->get();
            } elseif ($request->kategori  and $request->kondisi and $request->tahun) {
                $aset = DB::table('aset')->where('kategori', $request->kategori)->where('kondisi', $request->kondisi)->where('tahun_perolehan', $request->tahun)->where('jenis_aset', 'Wakaf')->where('id_daerah', $id_daerah)->orderby('created_at', 'desc')->get();
            } elseif ($request->kategori and $request->kondisi == "" and $request->tahun == "") {
                $aset = DB::table('aset')->where('kategori', $request->kategori)->where('jenis_aset', 'Wakaf')->where('id_daerah', $id_daerah)->orderby('created_at', 'desc')->get();
            } elseif ($request->kategori == "" and $request->kondisi and $request->tahun == "") {
                $aset = DB::table('aset')->where('kondisi', $request->kondisi)->where('jenis_aset', 'Wakaf')->where('id_daerah', $id_daerah)->orderby('created_at', 'desc')->get();
            } elseif ($request->kategori == "" and $request->kondisi == "" and $request->tahun) {
                $aset = DB::table('aset')->where('tahun_perolehan', $request->tahun)->where('jenis_aset', 'Wakaf')->where('id_daerah', $id_daerah)->orderby('created_at', 'desc')->get();
            } elseif ($request->kategori and $request->kondisi and $request->tahun == "") {
                $aset = DB::table('aset')->where('kategori', $request->kategori)->where('kondisi', $request->kondisi)->where('jenis_aset', 'Wakaf')->where('id_daerah', $id_daerah)->orderby('created_at', 'desc')->get();
            } elseif ($request->kategori == "" and $request->kondisi  and $request->tahun) {
                $aset = DB::table('aset')->where('kondisi', $request->kondisi)->where('tahun_perolehan', $request->tahun)->where('jenis_aset', 'Wakaf')->where('id_daerah', $id_daerah)->orderby('created_at', 'desc')->get();
            } elseif ($request->kategori and $request->kondisi == "" and $request->tahun) {
                $aset = DB::table('aset')->where('kategori', $request->kategori)->where('tahun_perolehan', $request->tahun)->where('jenis_aset', 'Wakaf')->where('id_daerah', $id_daerah)->orderby('created_at', 'desc')->get();
            }

            return view('aset.aset', compact('tahun_perolehan', 'kategori', 'aset',  'link', 'kategoris', 'kondisis', 'tahuns', 'page', 'title'));
        }
    }

    public function cetak_pdf_aset(Request $request, $link)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        if (Auth::user()->gocap_id_pc_pengurus != NULL) {
            $id_daerah = Auth::user()->PcPengurus->id_pc;
        }
        if (Auth::user()->gocap_id_upzis_pengurus != NULL) {
            $id_daerah = Auth::user()->UpzisPengurus->id_upzis;
        }
        // updated_at
        $ketua = 'ketu';

        $sekretaris = 'sekre';

        $dewan_syariah = 'dewan';

        if ($link == 'umum') {
            if ($request->kategori == "" and $request->kondisi == "" and $request->tahun == "") {
                $aset = DB::table('aset')->where('jenis_aset', 'Umum')->where('id_daerah', $id_daerah)->orderby('created_at', 'desc')->get();
            } elseif ($request->kategori  and $request->kondisi and $request->tahun) {
                $aset = DB::table('aset')->where('kategori', $request->kategori)->where('kondisi', $request->kondisi)->where('tahun_perolehan', $request->tahun)->where('jenis_aset', 'Umum')->where('id_daerah', $id_daerah)->orderby('created_at', 'desc')->get();
            } elseif ($request->kategori and $request->kondisi == "" and $request->tahun == "") {
                $aset = DB::table('aset')->where('kategori', $request->kategori)->where('jenis_aset', 'Umum')->where('id_daerah', $id_daerah)->orderby('created_at', 'desc')->get();
            } elseif ($request->kategori == "" and $request->kondisi and $request->tahun == "") {
                $aset = DB::table('aset')->where('kondisi', $request->kondisi)->where('jenis_aset', 'Umum')->where('id_daerah', $id_daerah)->orderby('created_at', 'desc')->get();
            } elseif ($request->kategori == "" and $request->kondisi == "" and $request->tahun) {
                $aset = DB::table('aset')->where('tahun_perolehan', $request->tahun)->where('jenis_aset', 'Umum')->where('id_daerah', $id_daerah)->orderby('created_at', 'desc')->get();
            } elseif ($request->kategori and $request->kondisi and $request->tahun == "") {
                $aset = DB::table('aset')->where('kategori', $request->kategori)->where('kondisi', $request->kondisi)->where('jenis_aset', 'Umum')->where('id_daerah', $id_daerah)->orderby('created_at', 'desc')->get();
            } elseif ($request->kategori == "" and $request->kondisi  and $request->tahun) {
                $aset = DB::table('aset')->where('kondisi', $request->kondisi)->where('tahun_perolehan', $request->tahun)->where('jenis_aset', 'Umum')->where('id_daerah', $id_daerah)->orderby('created_at', 'desc')->get();
            } elseif ($request->kategori and $request->kondisi == "" and $request->tahun) {
                $aset = DB::table('aset')->where('kategori', $request->kategori)->where('tahun_perolehan', $request->tahun)->where('jenis_aset', 'Umum')->where('id_daerah', $id_daerah)->orderby('created_at', 'desc')->get();
            }
            $pdf = PDF::loadview('aset.print_aset', ['aset' => $aset, 'ketua' => $ketua, 'sekretaris' => $sekretaris, 'dewan_syariah' => $dewan_syariah])->setPaper('a4', 'landscape');
            return $pdf->stream();
        } else {
            if ($request->kategori == "" and $request->kondisi == "" and $request->tahun == "") {
                $aset = DB::table('aset')->where('jenis_aset', 'Wakaf')->where('id_daerah', $id_daerah)->orderby('created_at', 'desc')->get();
            } elseif ($request->kategori  and $request->kondisi and $request->tahun) {
                $aset = DB::table('aset')->where('kategori', $request->kategori)->where('kondisi', $request->kondisi)->where('tahun_perolehan', $request->tahun)->where('jenis_aset', 'Wakaf')->where('id_daerah', $id_daerah)->orderby('created_at', 'desc')->get();
            } elseif ($request->kategori and $request->kondisi == "" and $request->tahun == "") {
                $aset = DB::table('aset')->where('kategori', $request->kategori)->where('jenis_aset', 'Wakaf')->where('id_daerah', $id_daerah)->orderby('created_at', 'desc')->get();
            } elseif ($request->kategori == "" and $request->kondisi and $request->tahun == "") {
                $aset = DB::table('aset')->where('kondisi', $request->kondisi)->where('jenis_aset', 'Wakaf')->where('id_daerah', $id_daerah)->orderby('created_at', 'desc')->get();
            } elseif ($request->kategori == "" and $request->kondisi == "" and $request->tahun) {
                $aset = DB::table('aset')->where('tahun_perolehan', $request->tahun)->where('jenis_aset', 'Wakaf')->where('id_daerah', $id_daerah)->orderby('created_at', 'desc')->get();
            } elseif ($request->kategori and $request->kondisi and $request->tahun == "") {
                $aset = DB::table('aset')->where('kategori', $request->kategori)->where('kondisi', $request->kondisi)->where('jenis_aset', 'Wakaf')->where('id_daerah', $id_daerah)->orderby('created_at', 'desc')->get();
            } elseif ($request->kategori == "" and $request->kondisi  and $request->tahun) {
                $aset = DB::table('aset')->where('kondisi', $request->kondisi)->where('tahun_perolehan', $request->tahun)->where('jenis_aset', 'Wakaf')->where('id_daerah', $id_daerah)->orderby('created_at', 'desc')->get();
            } elseif ($request->kategori and $request->kondisi == "" and $request->tahun) {
                $aset = DB::table('aset')->where('kategori', $request->kategori)->where('tahun_perolehan', $request->tahun)->where('jenis_aset', 'Wakaf')->where('id_daerah', $id_daerah)->orderby('created_at', 'desc')->get();
            }

            $pdf = PDF::loadview('aset.print_aset', ['aset' => $aset, 'ketua' => $ketua, 'sekretaris' => $sekretaris, 'dewan_syariah' => $dewan_syariah])->setPaper('a4', 'landscape');
            return $pdf->stream();
        }
    }
}
