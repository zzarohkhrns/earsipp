<?php

namespace App\Http\Controllers;

use App\Models\Pc;
use App\Models\Ttd;
use App\Models\Memo;
use App\Models\Sppd;
use App\Models\Upzis;
use App\Models\Berita;
use App\Models\Ranting;
use App\Models\Wilayah;
use App\Models\FileMemo;
use App\Models\Pengguna;
use App\Models\Disposisi;
use App\Models\FileBerita;
use App\Models\PcPengurus;
use Illuminate\Support\Str;
use App\Models\ArsipDigital;
use Illuminate\Http\Request;
use App\Models\LampiranArsip;
use App\Models\PenerimaSurat;
use App\Models\UpzisPengurus;
use App\Models\KategoriBerita;
use App\Models\KodeJenisSurat;
use App\Models\PengurusJabatan;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;



class ArsipDigitalController extends Controller
{

    public function __construct()
    {
        view()->composer('*', function ($view) {

            $earsip = config('app.database_earsip');
            $siftnu = config('app.database_siftnu');
            $gocap = config('app.database_gocap');
            $jenis_surat_table = DB::table('kode_jenis_surat')->get();


            if (Auth::user()->gocap_id_pc_pengurus != NULL) {
                $ketua_upzis = Upzis::join($gocap . '.upzis_pengurus', $gocap . '.upzis_pengurus.id_upzis', '=', $gocap . '.upzis.id_upzis')
                    ->join($gocap . '.pengurus_jabatan', $gocap . '.pengurus_jabatan.id_pengurus_jabatan', '=', $gocap . '.upzis_pengurus.id_pengurus_jabatan')
                    ->where($gocap . '.pengurus_jabatan.id_pengurus_jabatan', 'c699f7c7-7791-11ed-97ee-e4a8df91d8b3')
                    ->groupBy($gocap . '.upzis_pengurus.id_upzis')
                    ->get();

                $koordinator_plpk = Ranting::join($gocap . '.ranting_pengurus', $gocap . '.ranting_pengurus.id_ranting', '=', $gocap . '.ranting.id_ranting')
                    ->join($gocap . '.pengurus_jabatan', $gocap . '.pengurus_jabatan.id_pengurus_jabatan', '=', $gocap . '.ranting_pengurus.id_pengurus_jabatan')
                    ->where($gocap . '.pengurus_jabatan.id_pengurus_jabatan', 'f3baf470-3a29-11ed-a757-e4a8df91d887')
                    ->groupBy($gocap . '.ranting_pengurus.id_ranting')
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
                    ->where($gocap . '.pengurus_jabatan.id_pengurus_jabatan', 'c699f7c7-7791-11ed-97ee-e4a8df91d8b3')
                    ->groupBy($gocap . '.upzis_pengurus.id_upzis')
                    ->get();

                $koordinator_plpk = Ranting::join($gocap . '.ranting_pengurus', $gocap . '.ranting_pengurus.id_ranting', '=', $gocap . '.ranting.id_ranting')
                    ->join($gocap . '.pengurus_jabatan', $gocap . '.pengurus_jabatan.id_pengurus_jabatan', '=', $gocap . '.ranting_pengurus.id_pengurus_jabatan')
                    ->where($gocap . '.pengurus_jabatan.id_pengurus_jabatan', 'f3baf470-3a29-11ed-a757-e4a8df91d887')
                    ->groupBy($gocap . '.ranting_pengurus.id_ranting')
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
            $klasifikasis = '';
            $disposisis = '';
            $bulans  = '';
            $tahuns = '';


            $view->with('role', $role)
                ->with('kategori', $kategori)
                ->with('jenis_surat_table', $jenis_surat_table)
                ->with('klasifikasis', $klasifikasis)
                ->with('disposisis', $disposisis)
                ->with('bulans', $bulans)
                ->with('tahuns', $tahuns)
                ->with('tgl_perolehan', $tgl_perolehan)
                ->with('id', $id)
                ->with('nama', $nama)
                ->with('upzis', $upzis)
                ->with('pc', $pc)
                ->with('akses', $akses)
                ->with('ranting', $ranting)
                ->with('wilayah', $wilayah)
                ->with('ketua_upzis', $ketua_upzis)
                ->with('pengurus', $pengurus)
                ->with('koordinator_plpk', $koordinator_plpk);
        });
    }

    public static function nama_pengurus_pc($id)
    {
        // dd($id);
        $etasyaruf = config('app.database_etasyaruf');
        $siftnu = config('app.database_siftnu');
        $earsip = config('app.database_earsip');
        $gocap = config('app.database_gocap');

        $a = DB::table($siftnu . '.pengguna')->where('gocap_id_pc_pengurus', $id)
            ->first();
        if ($a == NULL) {
            return '-';
        } else {
            return $a->nama;
        }
    }

    public function jenis_arsip()
    {
        $jenis_surat = DB::table('kode_jenis_surat')->orderby('created_at', 'desc')
            ->get();
        $title = 'ARSIP SURAT';
        $page = "Jenis & Kode Surat";
        return view('arsip.jenis_arsip', compact('page', 'title', 'jenis_surat'));
    }

    public function  aksi_hapus_jenis_surat(Request $request, $id)
    {

        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        KodeJenisSurat::where('kode_jenis_surat_id', $id)->delete();


        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('Jenis Surat ' . $cek . ' Berhasil Dihapus');
        return back();
    }

    public function aksi_edit_jenis_arsip(Request $request, $id)
    {

        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        KodeJenisSurat::where('kode_jenis_surat_id', $id)->update([
            'jenis' => $request->jenis,
            'kode' => $request->kode,
        ]);


        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('Jenis Surat ' . $cek . ' Berhasil Diubah');

        return back();
    }

    public function aksi_tambah_jenis_surat(Request $request)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        KodeJenisSurat::create([
            'kode_jenis_surat_id' => uniqid(),
            'jenis' => $request->jenis,
            'kode' => $request->kode,
        ]);


        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('Jenis Surat ' . $cek . ' Berhasil Ditambahkan');

        return back()->with('success', 'Data berhasil ditambahkan');
    }

    public function tambah_surat_masuk($hal)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $title = 'ARSIP SURAT';
        $page = "Tambah Surat Masuk";
        $hal = $hal;
        if ($hal == 'pc') {
            $act = 'pc_masuk';
        } elseif ($hal == 'upzis') {
            $act = 'upzis_masuk';
        }


        return view('arsip.tambah_surat', compact('act', 'page', 'hal', 'title'));
    }

    public function surat_masuk_pc(Request $request, $id)
    {
        // dd($id);
        $tahun_arsip = ArsipDigital::where('jenis_arsip', 'Surat Masuk')->select(DB::raw('YEAR(tanggal_arsip) as year'))->groupBy('year')->orderBy('year', 'DESC')->get();
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $ids = $id;
        // dd(Auth::user()->id);
        $title = 'ARSIP SURAT';
        $link = 'surat_masuk';
        $page = "Surat Masuk";

        // DB::table('pengurus')
        //     ->join('jabatan', 'pengurus.jabatan_id', '=', 'jabatan.jabatan_id')
        //     ->where('pengurus.mwcnu_id', $id)
        //     ->get();


        if ($id == 'pc') {
            $hal = 'pc';
            $part = "pc_masuk";
            $head = "Lazisnu";
            $arsip_diterima = DB::table('arsip_digital')
                ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                ->where('arsip_digital.jenis_arsip', 'Surat Masuk')->where('tujuan_arsip', 'like', "%" . 'PC' . "%")
                ->distinct('arsip_digital.arsip_digital_id')
                ->select('arsip_digital.*', 'disposisi.sifat', 'disposisi.perihal')
                ->orderby('created_at', 'desc')
                ->get();

            $arsip_dikirim = DB::table('arsip_digital')
                ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                ->where('arsip_digital.jenis_arsip', 'Surat Masuk')->where('tujuan_arsip', 'like', "%" . 'PC' . "%")
                ->distinct('arsip_digital.arsip_digital_id')
                ->select('arsip_digital.*', 'disposisi.sifat', 'disposisi.perihal')
                ->orderby('created_at', 'desc')
                ->get();
        }


        if ($id == 'upzis') {

            $hal = 'upzis';
            $part = "upzis_masuk";
            $head = "Upzis";

            $arsip_diterima = DB::table('arsip_digital')
                ->join('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                ->where('arsip_digital.jenis_arsip', 'Surat Masuk')->where('tujuan_arsip', 'like', "%" . 'Upzis' . "%")
                ->where('disposisi.id_pc', Auth::user()->PcPengurus->Pc->id_pc)
                ->select('arsip_digital.*', 'disposisi.sifat', 'disposisi.perihal')
                ->distinct('arsip_digital.arsip_digital_id')
                ->orderby('created_at', 'desc')
                ->get();

            $arsip_dikirim = DB::table('arsip_digital')
                ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                ->where('arsip_digital.jenis_arsip', 'Surat Masuk')->where('tujuan_arsip', 'like', "%" . 'Upzis' . "%")
                ->select('arsip_digital.*', 'disposisi.sifat', 'disposisi.perihal')
                ->distinct('arsip_digital.arsip_digital_id')
                ->orderby('created_at', 'desc')
                ->get();
            // dd($arsip_diterima);
        }

        return view('arsip.surat_masuk', compact('arsip_diterima', 'tahun_arsip', 'arsip_dikirim', 'page', 'part', 'ids', 'title', 'link', 'head', 'hal'));
    }

    public function surat_masuk_pc2(Request $request, $id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $ids = $id;
        $tahun_arsip = ArsipDigital::where('jenis_arsip', 'Surat Masuk')->select(DB::raw('YEAR(tanggal_arsip) as year'))->groupBy('year')->orderBy('year', 'DESC')->get();
        // dd(Auth::user()->id);
        $title = 'ARSIP SURAT';
        $link = 'surat_masuk';
        $page = "Surat Masuk";

        // DB::table('pengurus')
        //     ->join('jabatan', 'pengurus.jabatan_id', '=', 'jabatan.jabatan_id')
        //     ->where('pengurus.mwcnu_id', $id)
        //     ->get();


        if ($id == 'pc') {
            $hal = 'pc';
            $part = "pc_masuk";
            $head = "Lazisnu";
            $arsip_diterima = DB::table('arsip_digital')
                ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                ->where('arsip_digital.jenis_arsip', 'Surat Masuk')->where('tujuan_arsip', 'like', "%" . 'PC' . "%")
                ->distinct('arsip_digital.arsip_digital_id')
                ->select('arsip_digital.*')->orderby('created_at', 'desc')
                ->get();

            $arsip_dikirim = DB::table('arsip_digital')
                ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                ->where('arsip_digital.jenis_arsip', 'Surat Masuk')->where('tujuan_arsip', 'like', "%" . 'PC' . "%")
                ->distinct('arsip_digital.arsip_digital_id')
                ->select('arsip_digital.*')->orderby('created_at', 'desc')
                ->get();
        }


        if ($id == 'upzis') {

            $hal = 'upzis';
            $part = "upzis_masuk";
            $head = "Upzis";

            $arsip_diterima = DB::table('arsip_digital')
                ->join('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                ->where('arsip_digital.jenis_arsip', 'Surat Masuk')->where('tujuan_arsip', 'like', "%" . 'Upzis' . "%")
                ->where('disposisi.id_pc', Auth::user()->PcPengurus->Pc->id_pc)
                ->select('arsip_digital.*')
                ->distinct('arsip_digital.arsip_digital_id')
                ->orderby('created_at', 'desc')
                ->get();

            $arsip_dikirim = DB::table('arsip_digital')
                ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                ->where('arsip_digital.jenis_arsip', 'Surat Masuk')->where('tujuan_arsip', 'like', "%" . 'Upzis' . "%")
                ->select('arsip_digital.*')
                ->distinct('arsip_digital.arsip_digital_id')
                ->orderby('created_at', 'desc')
                ->get();
        }



        return view('arsip.surat_masuk2', compact('arsip_diterima', 'tahun_arsip', 'arsip_dikirim', 'page', 'part', 'ids', 'title', 'link', 'head', 'hal'));
    }

    public function surat_masuk_upzis(Request $request, $id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $ids = $id;
        $tahun_arsip = ArsipDigital::where('jenis_arsip', 'Surat Masuk')->select(DB::raw('YEAR(tanggal_arsip) as year'))->groupBy('year')->orderBy('year', 'DESC')->get();
        // dd(Auth::user()->id);
        $title = 'ARSIP SURAT';
        $link = 'surat_masuk';
        $page = "Surat Masuk";

        // DB::table('pengurus')
        //     ->join('jabatan', 'pengurus.jabatan_id', '=', 'jabatan.jabatan_id')
        //     ->where('pengurus.mwcnu_id', $id)
        //     ->get();


        if ($id == 'pc') {
            $hal = 'pc';
            $part = "pc_masuk";
            $head = "Lazisnu";
            $arsip_diterima = DB::table('arsip_digital')
                ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                ->where('arsip_digital.jenis_arsip', 'Surat Masuk')->where('tujuan_arsip', 'like', "%" . 'PC' . "%")
                ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                ->distinct('arsip_digital.arsip_digital_id')
                ->select('arsip_digital.*')->orderby('created_at', 'desc')
                ->get();

            $arsip_dikirim = DB::table('arsip_digital')
                ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                ->where('arsip_digital.jenis_arsip', 'Surat Masuk')->where('tujuan_arsip', 'like', "%" . 'PC' . "%")
                ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                ->distinct('arsip_digital.arsip_digital_id')
                ->select('arsip_digital.*')->orderby('created_at', 'desc')
                ->get();
        }


        if ($id == 'upzis') {

            $hal = 'upzis';
            $part = "upzis_masuk";
            $head = "Upzis";

            $arsip_diterima = DB::table('arsip_digital')
                ->join('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)->where('arsip_digital.jenis_arsip', 'Surat Masuk')->where('tujuan_arsip', 'like', "%" . 'Upzis' . "%")
                ->select('arsip_digital.*')
                ->distinct('arsip_digital.arsip_digital_id')
                ->orderby('created_at', 'desc')
                ->get();

            $arsip_dikirim = DB::table('arsip_digital')
                ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                ->where('arsip_digital.jenis_arsip', 'Surat Masuk')->where('tujuan_arsip', 'like', "%" . 'Upzis' . "%")->where('id_pengguna', Auth::user()->id_pengguna)
                ->select('arsip_digital.*')
                ->distinct('arsip_digital.arsip_digital_id')
                ->orderby('created_at', 'desc')
                ->get();
        }

        return view('arsip.surat_masuk', compact('arsip_diterima', 'tahun_arsip', 'arsip_dikirim', 'page', 'part', 'ids', 'title', 'link', 'head', 'hal'));
    }

    public function surat_masuk_upzis2(Request $request, $id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $ids = $id;
        $tahun_arsip = ArsipDigital::where('jenis_arsip', 'Surat Masuk')->select(DB::raw('YEAR(tanggal_arsip) as year'))->groupBy('year')->orderBy('year', 'DESC')->get();
        // dd(Auth::user()->id);
        $title = 'ARSIP SURAT';
        $link = 'surat_masuk';
        $page = "Surat Masuk";

        // DB::table('pengurus')
        //     ->join('jabatan', 'pengurus.jabatan_id', '=', 'jabatan.jabatan_id')
        //     ->where('pengurus.mwcnu_id', $id)
        //     ->get();


        if ($id == 'pc') {
            $hal = 'pc';
            $part = "pc_masuk";
            $head = "Lazisnu";
            $arsip_diterima = DB::table('arsip_digital')
                ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                ->where('arsip_digital.jenis_arsip', 'Surat Masuk')->where('tujuan_arsip', 'like', "%" . 'PC' . "%")
                ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                ->distinct('arsip_digital.arsip_digital_id')
                ->select('arsip_digital.*')->orderby('created_at', 'desc')
                ->get();

            $arsip_dikirim = DB::table('arsip_digital')
                ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                ->where('arsip_digital.jenis_arsip', 'Surat Masuk')->where('tujuan_arsip', 'like', "%" . 'PC' . "%")
                ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                ->distinct('arsip_digital.arsip_digital_id')
                ->select('arsip_digital.*')->orderby('created_at', 'desc')
                ->get();
        }


        if ($id == 'upzis') {

            $hal = 'upzis';
            $part = "upzis_masuk";
            $head = "Upzis";

            $arsip_diterima = DB::table('arsip_digital')
                ->join('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)->where('arsip_digital.jenis_arsip', 'Surat Masuk')->where('tujuan_arsip', 'like', "%" . 'Upzis' . "%")
                ->select('arsip_digital.*')
                ->distinct('arsip_digital.arsip_digital_id')
                ->orderby('created_at', 'desc')
                ->get();

            $arsip_dikirim = DB::table('arsip_digital')
                ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                ->where('arsip_digital.jenis_arsip', 'Surat Masuk')->where('tujuan_arsip', 'like', "%" . 'Upzis' . "%")->where('id_pengguna', Auth::user()->id_pengguna)
                ->select('arsip_digital.*')
                ->distinct('arsip_digital.arsip_digital_id')
                ->orderby('created_at', 'desc')
                ->get();
        }



        return view('arsip.surat_masuk2', compact('arsip_diterima', 'arsip_dikirim', 'page', 'tahun_arsip', 'part', 'ids', 'title', 'link', 'head', 'hal'));
    }

    public function surat_keluar_pc(Request $request, $id)
    {

        $tahun_arsip = ArsipDigital::where('jenis_arsip', 'Surat Keluar')->select(DB::raw('YEAR(tanggal_arsip) as year'))->groupBy('year')->orderBy('year', 'DESC')->get();
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $id = $id;
        // dd(Auth::user()->id);
        $title = 'ARSIP SURAT';
        $link = 'surat_keluar';
        $page = "Surat Keluar";

        // DB::table('pengurus')
        //     ->join('jabatan', 'pengurus.jabatan_id', '=', 'jabatan.jabatan_id')
        //     ->where('pengurus.mwcnu_id', $id)
        //     ->get();


        if ($id == 'pc') {
            $hal = 'pc';
            $part = "pc_keluar";
            $head = "Lazisnu";
            $arsip_diterima = DB::table('arsip_digital')
                ->join('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                ->where('arsip_digital.jenis_arsip', 'Surat Keluar')->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                ->distinct('arsip_digital.arsip_digital_id')
                ->select('arsip_digital.*')->orderby('created_at', 'desc')
                ->get();

            $arsip_dikirim = DB::table('arsip_digital')
                ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                ->where('arsip_digital.jenis_arsip', 'Surat Keluar')->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                ->distinct('arsip_digital.arsip_digital_id')
                ->select('arsip_digital.*')->orderby('created_at', 'desc')
                ->get();
        }


        if ($id == 'upzis') {

            $hal = 'upzis';
            $part = "upzis_keluar";
            $head = "Upzis";

            $arsip_diterima = DB::table('arsip_digital')
                ->join('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                ->where('arsip_digital.jenis_arsip', 'Surat Keluar')->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                ->where('disposisi.id_pc', Auth::user()->PcPengurus->Pc->id_pc)
                ->select('arsip_digital.*')
                ->distinct('arsip_digital.arsip_digital_id')
                ->orderby('created_at', 'desc')
                ->get();

            $arsip_dikirim = DB::table('arsip_digital')
                ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                ->where('arsip_digital.jenis_arsip', 'Surat Keluar')->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                ->select('arsip_digital.*')
                ->distinct('arsip_digital.arsip_digital_id')
                ->orderby('created_at', 'desc')
                ->get();
        }
        $jumlah = '';
        $penerima = [];

        return view('arsip.surat_keluar', compact('penerima', 'jumlah', 'arsip_diterima', 'tahun_arsip', 'arsip_dikirim', 'page', 'part', 'id', 'title', 'link', 'head', 'hal'));
    }

    public function surat_keluar_pc2(Request $request, $id)
    {
        $penerima = [];
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $id = $id;
        $tahun_arsip = ArsipDigital::where('jenis_arsip', 'Surat Keluar')->select(DB::raw('YEAR(tanggal_arsip) as year'))->groupBy('year')->orderBy('year', 'DESC')->get();
        // dd(Auth::user()->id);
        $title = 'ARSIP SURAT';
        $link = 'surat_keluar';
        $page = "Surat Keluar";

        // DB::table('pengurus')
        //     ->join('jabatan', 'pengurus.jabatan_id', '=', 'jabatan.jabatan_id')
        //     ->where('pengurus.mwcnu_id', $id)
        //     ->get();


        if ($id == 'pc') {
            $hal = 'pc';
            $part = "pc_keluar";
            $head = "Lazisnu";
            $arsip_diterima = DB::table('arsip_digital')
                ->join('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                ->where('arsip_digital.jenis_arsip', 'Surat Keluar')->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                ->distinct('arsip_digital.arsip_digital_id')
                ->select('arsip_digital.*')->orderby('created_at', 'desc')
                ->get();

            $arsip_dikirim = DB::table('arsip_digital')
                ->join('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                ->where('arsip_digital.jenis_arsip', 'Surat Keluar')->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                ->distinct('arsip_digital.arsip_digital_id')
                ->select('arsip_digital.*')->orderby('created_at', 'desc')
                ->get();
        }


        if ($id == 'upzis') {

            $hal = 'upzis';
            $part = "upzis_keluar";
            $head = "Upzis";


            $arsip_diterima = DB::table('arsip_digital')
                ->join('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                ->where('arsip_digital.jenis_arsip', 'Surat Keluar')->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                ->where('disposisi.id_pc', Auth::user()->PcPengurus->Pc->id_pc)
                ->select('arsip_digital.*')
                ->distinct('arsip_digital.arsip_digital_id')
                ->orderby('created_at', 'desc')
                ->get();

            $arsip_dikirim = DB::table('arsip_digital')
                ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                ->where('arsip_digital.jenis_arsip', 'Surat Keluar')->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                ->select('arsip_digital.*')
                ->distinct('arsip_digital.arsip_digital_id')
                ->orderby('created_at', 'desc')
                ->get();
        }

        $jumlah = '';

        return view('arsip.surat_keluar2', compact('penerima', 'jumlah', 'arsip_diterima', 'arsip_dikirim', 'tahun_arsip', 'page', 'part', 'id', 'title', 'link', 'head', 'hal'));
    }

    public function surat_keluar_upzis(Request $request, $id)
    {

        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $id = $id;
        $tahun_arsip = ArsipDigital::where('jenis_arsip', 'Surat Keluar')->select(DB::raw('YEAR(tanggal_arsip) as year'))->groupBy('year')->orderBy('year', 'DESC')->get();
        // dd(Auth::user()->id);
        $title = 'ARSIP SURAT';
        $link = 'surat_keluar';
        $page = "Surat Keluar";

        // DB::table('pengurus')
        //     ->join('jabatan', 'pengurus.jabatan_id', '=', 'jabatan.jabatan_id')
        //     ->where('pengurus.mwcnu_id', $id)
        //     ->get();


        if ($id == 'pc') {
            $hal = 'pc';
            $part = "pc_keluar";
            $head = "Lazisnu";
            $arsip_diterima = DB::table('arsip_digital')
                ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                ->where('arsip_digital.jenis_arsip', 'Surat Keluar')->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                ->distinct('arsip_digital.arsip_digital_id')
                ->select('arsip_digital.*')->orderby('created_at', 'desc')
                ->get();

            $arsip_dikirim = DB::table('arsip_digital')
                ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                ->where('arsip_digital.jenis_arsip', 'Surat Keluar')->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                ->distinct('arsip_digital.arsip_digital_id')
                ->select('arsip_digital.*')->orderby('created_at', 'desc')
                ->get();
        }


        if ($id == 'upzis') {

            $hal = 'upzis';
            $part = "upzis_keluar";
            $head = "Upzis";

            $arsip_diterima = DB::table('arsip_digital')
                ->join('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)->where('arsip_digital.jenis_arsip', 'Surat Keluar')->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                ->select('arsip_digital.*')
                ->distinct('arsip_digital.arsip_digital_id')
                ->orderby('created_at', 'desc')
                ->get();

            $arsip_dikirim = DB::table('arsip_digital')
                ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                ->where('arsip_digital.jenis_arsip', 'Surat Keluar')->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")->where('id_pengguna', Auth::user()->id_pengguna)
                ->select('arsip_digital.*')
                ->distinct('arsip_digital.arsip_digital_id')
                ->orderby('created_at', 'desc')
                ->get();
        }

        $penerima = DB::table('arsip_digital')
            ->join('penerima_surat', 'arsip_digital.arsip_digital_id', '=', 'penerima_surat.arsip_digital_id')
            ->where('penerima_surat.id_pengurus', Auth::user()->UpzisPengurus->id_upzis_pengurus)
            ->where('arsip_digital.jenis_arsip', 'Surat Keluar')
            ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
            ->where('jenis_disposisi', 'Tidak Ada')
            ->select('arsip_digital.*')
            ->distinct('arsip_digital.arsip_digital_id')
            ->orderby('created_at', 'desc')
            ->get();

        $penerima_jumlah = $penerima->count();
        $jumlah = $penerima_jumlah + 1;

        // dd(Auth::user()->id_pengguna);

        return view('arsip.surat_keluar', compact('penerima', 'jumlah', 'arsip_diterima', 'arsip_dikirim', 'tahun_arsip', 'page', 'part', 'id', 'title', 'link', 'head', 'hal'));
    }

    public function surat_keluar_upzis2(Request $request, $id)
    {
        $penerima = [];
        $jumlah = '';
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $id = $id;
        $tahun_arsip = ArsipDigital::where('jenis_arsip', 'Surat Keluar')->select(DB::raw('YEAR(tanggal_arsip) as year'))->groupBy('year')->orderBy('year', 'DESC')->get();
        // dd(Auth::user()->id);
        $title = 'ARSIP SURAT';
        $link = 'surat_keluar';
        $page = "Surat Keluar";

        // DB::table('pengurus')
        //     ->join('jabatan', 'pengurus.jabatan_id', '=', 'jabatan.jabatan_id')
        //     ->where('pengurus.mwcnu_id', $id)
        //     ->get();


        if ($id == 'pc') {
            $hal = 'pc';
            $part = "pc_keluar";
            $head = "Lazisnu";
            $arsip_diterima = DB::table('arsip_digital')
                ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                ->where('arsip_digital.jenis_arsip', 'Surat Keluar')->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                ->distinct('arsip_digital.arsip_digital_id')
                ->select('arsip_digital.*')->orderby('created_at', 'desc')
                ->get();

            $arsip_dikirim = DB::table('arsip_digital')
                ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                ->where('arsip_digital.jenis_arsip', 'Surat Keluar')->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                ->distinct('arsip_digital.arsip_digital_id')
                ->select('arsip_digital.*')->orderby('created_at', 'desc')
                ->get();
        }


        if ($id == 'upzis') {

            $hal = 'upzis';
            $part = "upzis_keluar";
            $head = "Upzis";

            $arsip_diterima = DB::table('arsip_digital')
                ->join('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)->where('arsip_digital.jenis_arsip', 'Surat Keluar')->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                ->select('arsip_digital.*')
                ->distinct('arsip_digital.arsip_digital_id')
                ->orderby('created_at', 'desc')
                ->get();

            $arsip_dikirim = DB::table('arsip_digital')
                ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                ->where('arsip_digital.jenis_arsip', 'Surat Keluar')->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")->where('id_pengguna', Auth::user()->id_pengguna)
                ->select('arsip_digital.*')
                ->distinct('arsip_digital.arsip_digital_id')
                ->orderby('created_at', 'desc')
                ->get();
        }


        return view('arsip.surat_keluar2', compact('penerima', 'jumlah', 'arsip_diterima', 'arsip_dikirim', 'page', 'tahun_arsip', 'part', 'id', 'title', 'link', 'head', 'hal'));
    }

    public function tambah_surat_keluar($hal)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        if (Auth::user()->gocap_id_upzis_pengurus != null) {
            $koordinator_ranting = Ranting::join($gocap . '.ranting_pengurus', $gocap . '.ranting_pengurus.id_ranting', '=', $gocap . '.ranting.id_ranting')
                ->join($gocap . '.pengurus_jabatan', $gocap . '.pengurus_jabatan.id_pengurus_jabatan', '=', $gocap . '.ranting_pengurus.id_pengurus_jabatan')
                ->where($gocap . '.pengurus_jabatan.id_pengurus_jabatan', 'f3baf470-3a29-11ed-a757-e4a8df91d887')
                ->where($gocap . '.ranting.id_upzis',  Auth::user()->UpzisPengurus->Upzis->id_upzis)
                ->groupBy($gocap . '.ranting_pengurus.id_ranting')
                ->get();
        } else {
            $koordinator_ranting = [];
        }
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $title = 'ARSIP SURAT';

        $hal = $hal;
        if ($hal == 'pc') {
            $act = 'pc_keluar';
        } elseif ($hal == 'upzis') {
            $act = 'upzis_keluar';
        }
        $stat = '0';
        $page = "Tambah Arsip Surat";

        return view('arsip.tambah_surat_keluar', compact('act', 'koordinator_ranting', 'page', 'hal', 'stat', 'title'));
    }

    public function tambah_surat_keluar_baru($hal)
    {

        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $hal = $hal;
        if ($hal == 'pc') {
            $act = 'pc_keluar';
        } elseif ($hal == 'upzis') {
            $act = 'upzis_keluar';
        }
        if (Auth::user()->gocap_id_upzis_pengurus != null) {
            $koordinator_ranting = Ranting::join($gocap . '.ranting_pengurus', $gocap . '.ranting_pengurus.id_ranting', '=', $gocap . '.ranting.id_ranting')
                ->join($gocap . '.pengurus_jabatan', $gocap . '.pengurus_jabatan.id_pengurus_jabatan', '=', $gocap . '.ranting_pengurus.id_pengurus_jabatan')
                ->where($gocap . '.pengurus_jabatan.id_pengurus_jabatan', 'f3baf470-3a29-11ed-a757-e4a8df91d887')
                ->where($gocap . '.ranting.id_upzis',  Auth::user()->UpzisPengurus->Upzis->id_upzis)
                ->groupBy($gocap . '.ranting_pengurus.id_ranting')
                ->get();
        } else {
            $koordinator_ranting = [];
        }

        // $yang_bertandatangan = PcPengurus::where('id_pc', Auth::user()->PcPengurus->Pc->id_pc)
        //     ->join($siftnu . '.pengguna', $siftnu . '.pengguna.gocap_id_pc_pengurus', '=', $gocap . '.pc_pengurus.id_pc_pengurus')
        //     ->where($gocap . '.pc_pengurus.tanggal_selesai_jabatan', '>=', date('Y-m-d'))
        //     ->where($gocap . '.pc_pengurus.tanggal_mulai_jabatan', '<=', date('Y-m-d'))
        //     ->where($gocap . '.pc_pengurus.id_pc_pengurus', '!=', Auth::user()->PcPengurus->id_pc_pengurus)
        //     ->get();
        // $jabatan = DB::connection('gocap')->table('pengurus_jabatan')->where('id_pengurus_jabatan', $ttd->id_pengurus_jabatan)->first();
        $title = 'ARSIP SURAT';
        $page = "Tambah Surat Baru";
        $stat = '1';
        return view('arsip.tambah_surat_keluar_baru', compact('act', 'page', 'hal', 'stat', 'title', 'koordinator_ranting'));
    }


    public function detail_surat_masuk($id, $hal)
    {
        // dd($id, $hal);
        $hal = $hal;
        if ($hal == 'pc') {
            $act = 'pc_masuk';
        } else {
            $act = 'upzis_masuk';
        }
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $arsip_digital_id = $id;

        $title = 'ARSIP SURAT';
        $arsip = DB::table('arsip_digital')->where('arsip_digital_id', $id)->first();
        // dd($arsip);
        $page = "Detail Surat Masuk";
        $lampiran = DB::table('arsip_digital')->join('lampiran_arsip', 'arsip_digital.arsip_digital_id', '=', 'lampiran_arsip.arsip_digital_id')->where('arsip_digital.arsip_digital_id', $id)->get();
        $lampiran_file = DB::table('lampiran_arsip')
            ->join('arsip_digital', 'arsip_digital.arsip_digital_id', '=', 'lampiran_arsip.arsip_digital_id')
            ->where('arsip_digital.arsip_digital_id', $arsip_digital_id)
            ->count();

        $sppd = DB::table('sppd')
            ->join('arsip_digital', 'arsip_digital.arsip_digital_id', '=', 'sppd.arsip_digital_id')
            ->where('arsip_digital.arsip_digital_id', $arsip_digital_id)->select('sppd.*')
            ->first();

        $disposisi = DB::table('disposisi')
            ->join('arsip_digital', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
            ->where('arsip_digital.arsip_digital_id', $arsip_digital_id)
            ->first();
        // dd($lampiran);

        $total_count = 0;
        if (Auth::user()->gocap_id_pc_pengurus != NULL) {

            $baca_upzis =  Upzis::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.upzis.id_wilayah')
                ->join($earsip . '.disposisi', $earsip . '.disposisi.id_upzis', '=', $gocap . '.upzis.id_upzis')
                ->where('disposisi.arsip_digital_id', '=', $arsip_digital_id)
                ->select($siftnu . '.wilayah.nama', $earsip . '.disposisi.status_baca')->get();

            $baca_internal =  Disposisi::join($siftnu . '.pengguna', $siftnu . '.pengguna.gocap_id_pc_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->join($gocap . '.pc_pengurus', $gocap . '.pc_pengurus.id_pc_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->where('disposisi.arsip_digital_id', '=', $arsip_digital_id)
                ->select($siftnu . '.pengguna.nama', $earsip . '.disposisi.status_baca', $gocap . '.pc_pengurus.id_pengurus_jabatan')->get();

            $baca_pc =  Pc::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.pc.id_wilayah')
                ->join($earsip . '.disposisi', $earsip . '.disposisi.id_pc', '=', $gocap . '.pc.id_pc')
                ->where('disposisi.arsip_digital_id', '=', $arsip_digital_id)
                ->select($siftnu . '.wilayah.nama', $earsip . '.disposisi.status_baca')->get();


            $baca_ranting =  Ranting::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.ranting.id_wilayah')
                ->join($earsip . '.disposisi', $earsip . '.disposisi.id_ranting', '=', $gocap . '.ranting.id_ranting')
                ->where('disposisi.arsip_digital_id', '=', $arsip_digital_id)
                ->select($siftnu . '.wilayah.nama', $earsip . '.disposisi.status_baca')->get();

            $total_count += $baca_upzis->count();
            $total_count += $baca_internal->count();
            $total_count += $baca_pc->count();
            $total_count += $baca_ranting->count();
        }


        if (Auth::user()->gocap_id_upzis_pengurus != NULL) {


            $baca_upzis =  Upzis::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.upzis.id_wilayah')
                ->join($earsip . '.disposisi', $earsip . '.disposisi.id_upzis', '=', $gocap . '.upzis.id_upzis')
                ->where('disposisi.arsip_digital_id', '=', $arsip_digital_id)
                ->select($siftnu . '.wilayah.nama', $earsip . '.disposisi.status_baca')->get();

            $baca_pc =  Pc::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.pc.id_wilayah')
                ->join($earsip . '.disposisi', $earsip . '.disposisi.id_pc', '=', $gocap . '.pc.id_pc')
                ->where('disposisi.arsip_digital_id', '=', $arsip_digital_id)
                ->select($siftnu . '.wilayah.nama', $earsip . '.disposisi.status_baca')->get();


            $baca_ranting =  Ranting::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.ranting.id_wilayah')
                ->join($earsip . '.disposisi', $earsip . '.disposisi.id_ranting', '=', $gocap . '.ranting.id_ranting')
                ->where('disposisi.arsip_digital_id', '=', $arsip_digital_id)
                ->select($siftnu . '.wilayah.nama', $earsip . '.disposisi.status_baca')->get();

            $baca_internal =  Disposisi::join($siftnu . '.pengguna', $siftnu . '.pengguna.gocap_id_upzis_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->join($gocap . '.upzis_pengurus', $gocap . '.upzis_pengurus.id_upzis_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->where('disposisi.arsip_digital_id', '=', $arsip_digital_id)
                ->select($siftnu . '.pengguna.nama', $earsip . '.disposisi.status_baca', $gocap . '.upzis_pengurus.id_pengurus_jabatan')->get();

            $total_count += $baca_upzis->count();
            $total_count += $baca_internal->count();
            $total_count += $baca_pc->count();
            $total_count += $baca_ranting->count();
        }

        if (DB::table('arsip_digital')->where('jenis_arsip', 'Surat Masuk')->where('id_pengguna', Auth::user()->id_pengguna)->where('arsip_digital_id', $arsip_digital_id)->first()) {
            $info = 'Diteruskan';
            $stat = 'Diteruskan';
        } else {
            $info = 'Diterima';
            $stat = 'Diterima';
        }
        return view('arsip.detail_surat', compact('act', 'hal', 'stat', 'info', 'baca_pc', 'baca_ranting', 'arsip', 'page', 'lampiran', 'arsip_digital_id', 'lampiran_file', 'sppd', 'disposisi',  'title', 'baca_upzis', 'baca_internal', 'total_count'));
    }

    public function detail_surat_keluar($id, $hal)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        if (Auth::user()->gocap_id_upzis_pengurus != null) {
            $koordinator_ranting = Ranting::join($gocap . '.ranting_pengurus', $gocap . '.ranting_pengurus.id_ranting', '=', $gocap . '.ranting.id_ranting')
                ->join($gocap . '.pengurus_jabatan', $gocap . '.pengurus_jabatan.id_pengurus_jabatan', '=', $gocap . '.ranting_pengurus.id_pengurus_jabatan')
                ->where($gocap . '.pengurus_jabatan.id_pengurus_jabatan', 'f3baf470-3a29-11ed-a757-e4a8df91d887')
                ->where($gocap . '.ranting.id_upzis',  Auth::user()->UpzisPengurus->Upzis->id_upzis)
                ->groupBy($gocap . '.ranting_pengurus.id_ranting')
                ->get();
        } else {
            $koordinator_ranting = [];
        }

        $hal = $hal;
        if ($hal == 'pc') {
            $act = 'pc_keluar';
        } else {
            $act = 'upzis_keluar';
        }

        $arsip_digital_id = $id;

        $title = 'ARSIP SURAT';
        $arsip = DB::table('arsip_digital')->join('penerima_surat', 'penerima_surat.arsip_digital_id', '=', 'arsip_digital.arsip_digital_id')->where('arsip_digital.arsip_digital_id', $id)->first();
        // dd($id);



        $page = "Detail Surat Keluar";
        $lampiran = DB::table('arsip_digital')->join('lampiran_arsip', 'arsip_digital.arsip_digital_id', '=', 'lampiran_arsip.arsip_digital_id')->where('arsip_digital.arsip_digital_id', $id)->get();
        $lampiran_file = DB::table('lampiran_arsip')
            ->join('arsip_digital', 'arsip_digital.arsip_digital_id', '=', 'lampiran_arsip.arsip_digital_id')
            ->where('arsip_digital.arsip_digital_id', $arsip->arsip_digital_id)
            ->count();

        $sppd = DB::table('sppd')
            ->join('arsip_digital', 'arsip_digital.arsip_digital_id', '=', 'sppd.arsip_digital_id')
            ->where('arsip_digital.arsip_digital_id', $arsip->arsip_digital_id)->select('sppd.*')
            ->first();


        $disposisi = DB::table('disposisi')
            ->join('arsip_digital', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
            ->where('arsip_digital.arsip_digital_id', $arsip->arsip_digital_id)
            ->first();

        $penerima = DB::table('penerima_surat')
            ->join('arsip_digital', 'arsip_digital.arsip_digital_id', '=', 'penerima_surat.arsip_digital_id')
            ->where('arsip_digital.arsip_digital_id', $arsip->arsip_digital_id)
            ->first();

        $tb_penerima_surat = PenerimaSurat::where('arsip_digital_id', $id)->get();


        if (Auth::user()->gocap_id_pc_pengurus != NULL) {

            $baca_upzis =  Upzis::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.upzis.id_wilayah')
                ->join($earsip . '.disposisi', $earsip . '.disposisi.id_upzis', '=', $gocap . '.upzis.id_upzis')
                ->where('disposisi.arsip_digital_id', '=', $arsip_digital_id)
                ->select($siftnu . '.wilayah.nama', $earsip . '.disposisi.status_baca')->get();

            $baca_internal =  Disposisi::join($siftnu . '.pengguna', $siftnu . '.pengguna.gocap_id_pc_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->join($gocap . '.pc_pengurus', $gocap . '.pc_pengurus.id_pc_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->where('disposisi.arsip_digital_id', '=', $arsip_digital_id)
                ->select($siftnu . '.pengguna.nama', $earsip . '.disposisi.status_baca', $gocap . '.pc_pengurus.id_pengurus_jabatan')->get();

            $baca_pc =  Pc::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.pc.id_wilayah')
                ->join($earsip . '.disposisi', $earsip . '.disposisi.id_pc', '=', $gocap . '.pc.id_pc')
                ->where('disposisi.arsip_digital_id', '=', $arsip_digital_id)
                ->select($siftnu . '.wilayah.nama', $earsip . '.disposisi.status_baca')->get();


            $baca_ranting =  Ranting::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.ranting.id_wilayah')
                ->join($earsip . '.disposisi', $earsip . '.disposisi.id_ranting', '=', $gocap . '.ranting.id_ranting')
                ->where('disposisi.arsip_digital_id', '=', $arsip_digital_id)
                ->select($siftnu . '.wilayah.nama', $earsip . '.disposisi.status_baca')->get();
        }


        if (Auth::user()->gocap_id_upzis_pengurus != NULL) {


            $baca_upzis =  Upzis::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.upzis.id_wilayah')
                ->join($earsip . '.disposisi', $earsip . '.disposisi.id_upzis', '=', $gocap . '.upzis.id_upzis')
                ->where('disposisi.arsip_digital_id', '=', $arsip_digital_id)
                ->select($siftnu . '.wilayah.nama', $earsip . '.disposisi.status_baca')->get();

            $baca_pc =  Pc::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.pc.id_wilayah')
                ->join($earsip . '.disposisi', $earsip . '.disposisi.id_pc', '=', $gocap . '.pc.id_pc')
                ->where('disposisi.arsip_digital_id', '=', $arsip_digital_id)
                ->select($siftnu . '.wilayah.nama', $earsip . '.disposisi.status_baca')->get();


            $baca_ranting =  Ranting::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.ranting.id_wilayah')
                ->join($earsip . '.disposisi', $earsip . '.disposisi.id_ranting', '=', $gocap . '.ranting.id_ranting')
                ->where('disposisi.arsip_digital_id', '=', $arsip_digital_id)
                ->select($siftnu . '.wilayah.nama', $earsip . '.disposisi.status_baca')->get();

            $baca_internal =  Disposisi::join($siftnu . '.pengguna', $siftnu . '.pengguna.gocap_id_upzis_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->join($gocap . '.upzis_pengurus', $gocap . '.upzis_pengurus.id_upzis_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->where('disposisi.arsip_digital_id', '=', $arsip_digital_id)
                ->select($siftnu . '.pengguna.nama', $earsip . '.disposisi.status_baca', $gocap . '.upzis_pengurus.id_pengurus_jabatan')->get();
        }


        if (DB::table('arsip_digital')->where('jenis_arsip', 'Surat Keluar')->where('id_pengguna', Auth::user()->id_pengguna)->where('arsip_digital_id', $arsip->arsip_digital_id)->first()) {
            $stat = 'Diteruskan';
            $info = 'Diteruskan';
        } else {
            $stat = 'Diterima';
            $info = 'Diterima';
        }
        return view('arsip.detail_surat_keluar', compact('koordinator_ranting', 'tb_penerima_surat', 'penerima', 'act', 'hal', 'info', 'baca_pc', 'baca_ranting', 'arsip', 'page', 'lampiran', 'id_arsip', 'lampiran_file', 'sppd', 'disposisi', 'stat', 'title', 'baca_upzis', 'baca_internal'));
    }


    public function proses_edit_surat_masuk(Request $request, $id)
    {

        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        // $request->validate([
        //     'tanggal_arsip' => 'required',
        //     'nomor_surat' => 'required',
        //     'klasifikasi_surat' => 'required',
        //     'tujuan_arsip' => 'required',
        //     'pengirim_sumber' => 'required',
        // ], [
        //     'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
        //     'nomor_surat.required' => 'Nomor Surat harus diisi',
        //     'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
        //     'tujuan_arsip.required' => 'Tujuan Surat harus diisi',
        //     'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
        // ]);

        DB::table('arsip_digital')->where('arsip_digital_id', $id)->update([
            'nomor_surat' => $request->nomor_surat,
            'klasifikasi_surat' => $request->klasifikasi_surat,
            'bentuk_surat' => $request->bentuk_surat,
            'tujuan_surat' => $request->tujuan_surat,
            'pengirim_sumber' => $request->pengirim_sumber,
            'perihal_isi_deskripsi' => $request->perihal_isi_deskripsi,
            'alamat_pengirim' => $request->alamat_pengirim,
            'keterangan_surat_masuk' => $request->keterangan_surat_masuk

        ]);

        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('Arsip Surat Masuk' . $cek . ' Berhasil Diubah');


        return back();
    }

    public function proses_edit_disposisi(Request $request, $id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $request->validate([
            'sifat' => 'required',
        ]);

        DB::table('disposisi')->where('disposisi_id', $id)->update([
            'sifat' => $request->sifat,
            'perihal' => $request->perihal,
        ]);

        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('Disposisi ' . $cek . ' Berhasil Diubah');
        return back()->withInput(['tab' => 'disposisi']);
    }

    public function proses_edit_sppd(Request $request, $id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $request->validate([
            'anggaran' => 'required',
        ]);

        DB::table('sppd')->where('sppd_id', $id)->update([
            'anggaran' => str_replace('.', '', $request->anggaran),
            'perihal' => $request->perihal,
        ]);


        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('SPPD ' . $cek . ' Berhasil Diubah');
        return back()->withInput(['tab' => 'sppd']);
    }

    public function aksi_edit_lampiran(Request $request, $id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        if ($request->file) {
            $file = $request->file('file');
            $ext = $file->extension();
            $filename = $file->storeAs('/lampiran', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext, ['disk' => 'lampiran']);

            $path = public_path() . "/lampiran/" . $request->file_lama;
            if (file_exists($path)) {
                unlink($path);
            }

            LampiranArsip::where('lampiran_arsip_id', $id)->update([
                'nama' => $request->nama,
                'jenis' => $request->jenis,
                'file' => $filename,
            ]);
        } else {
            LampiranArsip::where('lampiran_arsip_id', $id)->update([
                'nama' => $request->nama,
                'jenis' =>  $request->jenis,
            ]);
        }


        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('Lampiran File ' . $cek . ' Berhasil Diubah');


        return back()->withInput(['tab' => 'file']);
    }

    public function aksi_tambah_lampiran(Request $request)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $file = $request->file('file');
        $ext_logo = $file->extension();
        $filename_scan = $file->storeAs('/lampiran', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext_logo, ['disk' => 'lampiran']);
        $dd =   LampiranArsip::create([
            'lampiran_arsip_id' => uniqid(),
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'arsip_digital_id' => $request->arsip_digital_id,
            'file' => $filename_scan,
        ]);


        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('Lampiran File ' . $cek . ' Berhasil Ditambahkan');


        return back()->withInput(['tab' => 'file']);
    }

    public function aksi_hapus_lampiran(Request $request, $id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        $LampiranArsip =  LampiranArsip::where('lampiran_arsip_id', $id)->first();
        $path = public_path() . "/lampiran/" .  $LampiranArsip->file;
        if (file_exists($path)) {
            unlink($path);
        }

        LampiranArsip::where('lampiran_arsip_id', $id)->delete();

        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('Lampiran File ' . $cek . ' Berhasil Dihapus');

        return back()->withInput(['tab' => 'file']);
    }

    public function aksi_tambah_surat_masuk(Request $request)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $anggaran = str_replace('.', '',  $request->anggaran);
        $data = $request->all();

        if (Auth::user()->gocap_id_pc_pengurus != null) {
            // invalid untuk disposisi ya -> penerima satuan -> sppd ya
            if ($request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_ya == 'on' && $request->akses_satuan_upzis == null && $request->akses_satuan_ranting == null) {
                $request->validate([
                    // surat masuk
                    'tanggal_index' => 'required',
                    'tanggal_arsip' => 'required',
                    'nomor_surat' => 'required',
                    'klasifikasi_surat' => 'required',
                    'bentuk_surat' => 'required',
                    'tujuan_surat' => 'required',
                    'tujuan_arsip' => 'required',
                    'pengirim_sumber' => 'required',
                    'perihal_isi_deskripsi' => 'required',
                    // disposisi
                    'sifat' => 'required',
                    'perihal_disposisi' => 'required',
                    'catatan_disposisi' => 'required|array',
                    'catatan_disposisi.*' => 'string',
                    // sppd
                    'tgl_perintah' => 'required',
                    'tgl_pelaksanaan' => 'required',
                    'anggaran' => 'required',
                    'perihal_sppd' => 'required',

                    'akses_satuan_upzis' => 'required',
                    'akses_satuan_ranting' => 'required',

                    'nama_surat' => 'required',
                    'scan_surat' => 'required',
                ], [
                    'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
                    'nomor_surat.required' => 'Nomor Surat harus diisi',
                    'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                    'bentuk_surat.required' => 'Bentuk Surat harus diisi',
                    'tujuan_surat.required' => 'Tujuan Surat harus diisi',
                    'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
                    'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                    'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',

                    'sifat.required' => 'Sifat harus diisi',
                    'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',
                    'catatan_disposisi.required' => 'Catatan Disposisi harus diisi',

                    'tgl_perintah.required' => 'Tanggal Perintah harus diisi',
                    'tgl_pelaksanaan.required' => 'Tanggal Pelaksanaan harus diisi',
                    'anggaran.required' => 'Anggaran harus diisi',
                    'perihal_sppd.required' => 'Perihal Sppd harus diisi',

                    'akses_satuan_upzis.required' => 'salah satu akses satuan harus diisi',
                    'akses_satuan_ranting.required' => 'salah satu akses satuan harus diisi',

                    'nama_surat.required' => 'Nama Surat harus diisi',
                    'scan_surat.required' => 'Scan Surat harus diisi',
                ]);
            }

            if (
                $request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_ya == 'on' && $request->akses_satuan_upzis != null ||
                $request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_ya == 'on' && $request->akses_satuan_ranting != null
            ) {
                $request->validate([
                    // surat masuk
                    'tanggal_arsip' => 'required',
                    'nomor_surat' => 'required',
                    'klasifikasi_surat' => 'required',
                    'bentuk_surat' => 'required',
                    'tujuan_surat' => 'required',
                    'tujuan_arsip' => 'required',
                    'pengirim_sumber' => 'required',
                    'perihal_isi_deskripsi' => 'required',
                    // disposisi
                    'sifat' => 'required',
                    'perihal_disposisi' => 'required',
                    'catatan_disposisi' => 'required|array',
                    'catatan_disposisi.*' => 'string',
                    // sppd
                    'tgl_perintah' => 'required',
                    'tgl_pelaksanaan' => 'required',
                    'anggaran' => 'required',
                    'perihal_sppd' => 'required',
                    'nama_surat' => 'required',
                    'scan_surat' => 'required',

                ], [
                    'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
                    'nomor_surat.required' => 'Nomor Surat harus diisi',
                    'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                    'bentuk_surat.required' => 'Bentuk Surat harus diisi',
                    'tujuan_surat.required' => 'Tujuan Surat harus diisi',
                    'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
                    'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                    'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',

                    'sifat.required' => 'Sifat harus diisi',
                    'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',

                    'tgl_perintah.required' => 'Tanggal Perintah harus diisi',
                    'tgl_pelaksanaan.required' => 'Tanggal Pelaksanaan harus diisi',
                    'anggaran.required' => 'Anggaran harus diisi',
                    'perihal_sppd.required' => 'Perihal Sppd harus diisi',
                    'nama_surat.required' => 'Nama Surat harus diisi',
                    'scan_surat.required' => 'Scan Surat harus diisi',

                ]);
            }

            // invalid untuk disposisi ya -> penerima satuan -> sppd tidak
            if (
                $request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_tidak == 'on' && $request->akses_satuan_upzis != null ||
                $request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_tidak == 'on' && $request->akses_satuan_ranting != null
            ) {
                $request->validate([
                    // surat masuk
                    'tanggal_arsip' => 'required',
                    'nomor_surat' => 'required',
                    'klasifikasi_surat' => 'required',
                    'bentuk_surat' => 'required',
                    'tujuan_surat' => 'required',
                    'tujuan_arsip' => 'required',
                    'pengirim_sumber' => 'required',
                    'perihal_isi_deskripsi' => 'required',
                    // disposisi
                    'sifat' => 'required',
                    'perihal_disposisi' => 'required',
                    'catatan_disposisi' => 'required|array',
                    'catatan_disposisi.*' => 'string',
                    'nama_surat' => 'required',
                    'scan_surat' => 'required',

                ], [
                    'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
                    'nomor_surat.required' => 'Nomor Surat harus diisi',
                    'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                    'bentuk_surat.required' => 'Bentuk Surat harus diisi',
                    'tujuan_surat.required' => 'Tujuan Surat harus diisi',
                    'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
                    'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                    'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',

                    'sifat.required' => 'Sifat harus diisi',
                    'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',
                    'nama_surat.required' => 'Nama Surat harus diisi',
                    'scan_surat.required' => 'Scan Surat harus diisi',

                ]);
            }

            // invalid untuk disposisi ya -> penerima satuan -> sppd tidak
            if ($request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_tidak == 'on' && $request->akses_satuan_upzis == null && $request->akses_satuan_ranting == null) {

                $request->validate([
                    // surat masuk
                    'tanggal_arsip' => 'required',
                    'nomor_surat' => 'required',
                    'klasifikasi_surat' => 'required',
                    'bentuk_surat' => 'required',
                    'tujuan_surat' => 'required',
                    'tujuan_arsip' => 'required',
                    'pengirim_sumber' => 'required',
                    'perihal_isi_deskripsi' => 'required',
                    // disposisi
                    'sifat' => 'required',
                    'perihal_disposisi' => 'required',
                    'catatan_disposisi' => 'required|array',
                    'catatan_disposisi.*' => 'string',

                    'akses_satuan_upzis' => 'required',
                    'akses_satuan_ranting' => 'required',
                    'nama_surat' => 'required',
                    'scan_surat' => 'required',


                ], [
                    'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
                    'nomor_surat.required' => 'Nomor Surat harus diisi',
                    'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                    'bentuk_surat.required' => 'Bentuk Surat harus diisi',
                    'tujuan_surat.required' => 'Tujuan Surat harus diisi',
                    'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
                    'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                    'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',

                    'sifat.required' => 'Sifat harus diisi',
                    'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',

                    'akses_satuan_upzis.required' => 'salah satu akses satuan harus diisi',
                    'akses_satuan_ranting.required' => 'salah satu akses satuan harus diisi',

                    'nama_surat.required' => 'Nama Surat harus diisi',
                    'scan_surat.required' => 'Scan Surat harus diisi',
                ]);
            }
        }

        if (Auth::user()->gocap_id_upzis_pengurus != null) {
            // invalid untuk disposisi ya -> penerima satuan -> sppd ya
            if ($request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_ya == 'on' && $request->akses_satuan_upzis == null && $request->akses_satuan_ranting == null && $request->akses_satuan_pc == null) {
                $request->validate([
                    // surat masuk
                    'tanggal_arsip' => 'required',
                    'nomor_surat' => 'required',
                    'klasifikasi_surat' => 'required',
                    'bentuk_surat' => 'required',
                    'tujuan_surat' => 'required',
                    'tujuan_arsip' => 'required',
                    'pengirim_sumber' => 'required',
                    'perihal_isi_deskripsi' => 'required',
                    // disposisi
                    'sifat' => 'required',
                    'perihal_disposisi' => 'required',
                    'catatan_disposisi' => 'required|array',
                    'catatan_disposisi.*' => 'string',
                    // sppd
                    'tgl_perintah' => 'required',
                    'tgl_pelaksanaan' => 'required',
                    'anggaran' => 'required',
                    'perihal_sppd' => 'required',

                    'akses_satuan_upzis' => 'required',
                    'akses_satuan_ranting' => 'required',
                    'akses_satuan_pc' => 'required',

                    'nama_surat' => 'required',
                    'scan_surat' => 'required',

                ], [
                    'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
                    'nomor_surat.required' => 'Nomor Surat harus diisi',
                    'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                    'bentuk_surat.required' => 'Bentuk Surat harus diisi',
                    'tujuan_surat.required' => 'Tujuan Surat harus diisi',
                    'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
                    'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                    'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',

                    'akses_satuan.required' => 'Akses Satuan harus diisi',
                    'sifat.required' => 'Sifat harus diisi',
                    'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',

                    'tgl_perintah.required' => 'Tanggal Perintah harus diisi',
                    'tgl_pelaksanaan.required' => 'Tanggal Pelaksanaan harus diisi',
                    'anggaran.required' => 'Anggaran harus diisi',
                    'perihal_sppd.required' => 'Perihal Sppd harus diisi',

                    'akses_satuan_upzis.required' => 'salah satu akses satuan harus diisi',
                    'akses_satuan_ranting.required' => 'salah satu akses satuan harus diisi',
                    'akses_satuan_pc.required' => 'salah satu akses satuan harus diisi',

                    'nama_surat.required' => 'Nama Surat harus diisi',
                    'scan_surat.required' => 'Scan Surat harus diisi',
                ]);
            }

            if (
                $request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_ya == 'on' && $request->akses_satuan_upzis != null ||
                $request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_ya == 'on' &&  $request->akses_satuan_ranting != null ||
                $request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_ya == 'on' &&  $request->akses_satuan_pc != null
            ) {
                $request->validate([
                    // surat masuk
                    'tanggal_arsip' => 'required',
                    'nomor_surat' => 'required',
                    'klasifikasi_surat' => 'required',
                    'bentuk_surat' => 'required',
                    'tujuan_surat' => 'required',
                    'tujuan_arsip' => 'required',
                    'pengirim_sumber' => 'required',
                    'perihal_isi_deskripsi' => 'required',
                    // disposisi
                    'sifat' => 'required',
                    'perihal_disposisi' => 'required',
                    'catatan_disposisi' => 'required|array',
                    'catatan_disposisi.*' => 'string',
                    // sppd
                    'tgl_perintah' => 'required',
                    'tgl_pelaksanaan' => 'required',
                    'anggaran' => 'required',
                    'perihal_sppd' => 'required',

                    'nama_surat' => 'required',
                    'scan_surat' => 'required',


                ], [
                    'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
                    'nomor_surat.required' => 'Nomor Surat harus diisi',
                    'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                    'bentuk_surat.required' => 'Bentuk Surat harus diisi',
                    'tujuan_surat.required' => 'Tujuan Surat harus diisi',
                    'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
                    'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                    'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',

                    'akses_satuan.required' => 'Akses Satuan harus diisi',
                    'sifat.required' => 'Sifat harus diisi',
                    'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',

                    'tgl_perintah.required' => 'Tanggal Perintah harus diisi',
                    'tgl_pelaksanaan.required' => 'Tanggal Pelaksanaan harus diisi',
                    'anggaran.required' => 'Anggaran harus diisi',
                    'perihal_sppd.required' => 'Perihal Sppd harus diisi',

                    'nama_surat.required' => 'Nama Surat harus diisi',
                    'scan_surat.required' => 'Scan Surat harus diisi',

                ]);
            }

            // invalid untuk disposisi ya -> penerima satuan -> sppd tidak
            if (
                $request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_tidak == 'on' && $request->akses_satuan_upzis != null ||
                $request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_tidak == 'on' &&  $request->akses_satuan_ranting != null ||
                $request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_tidak == 'on' && $request->akses_satuan_pc != null
            ) {
                $request->validate([
                    // surat masuk
                    'tanggal_arsip' => 'required',
                    'nomor_surat' => 'required',
                    'klasifikasi_surat' => 'required',
                    'bentuk_surat' => 'required',
                    'tujuan_surat' => 'required',
                    'tujuan_arsip' => 'required',
                    'pengirim_sumber' => 'required',
                    'perihal_isi_deskripsi' => 'required',
                    // disposisi
                    'sifat' => 'required',
                    'perihal_disposisi' => 'required',
                    'catatan_disposisi' => 'required|array',
                    'catatan_disposisi.*' => 'string',
                    'nama_surat' => 'required',
                    'scan_surat' => 'required',


                ], [
                    'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
                    'nomor_surat.required' => 'Nomor Surat harus diisi',
                    'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                    'bentuk_surat.required' => 'Bentuk Surat harus diisi',
                    'tujuan_surat.required' => 'Tujuan Surat harus diisi',
                    'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
                    'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                    'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',

                    'sifat.required' => 'Sifat harus diisi',
                    'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',

                    'nama_surat.required' => 'Nama Surat harus diisi',
                    'scan_surat.required' => 'Scan Surat harus diisi',

                ]);
            }

            // invalid untuk disposisi ya -> penerima satuan -> sppd tidak
            if (
                $request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_tidak == 'on' && $request->akses_satuan_upzis == null
                && $request->akses_satuan_ranting == null
                &&  $request->akses_satuan_pc == null
            ) {

                $request->validate([
                    // surat masuk
                    'tanggal_arsip' => 'required',
                    'nomor_surat' => 'required',
                    'klasifikasi_surat' => 'required',
                    'bentuk_surat' => 'required',
                    'tujuan_surat' => 'required',
                    'tujuan_arsip' => 'required',
                    'pengirim_sumber' => 'required',
                    'perihal_isi_deskripsi' => 'required',
                    // disposisi
                    'sifat' => 'required',
                    'perihal_disposisi' => 'required',
                    'catatan_disposisi' => 'required|array',
                    'catatan_disposisi.*' => 'string',

                    'akses_satuan_upzis' => 'required',
                    'akses_satuan_ranting' => 'required',
                    'akses_satuan_pc' => 'required',

                    'nama_surat' => 'required',
                    'scan_surat' => 'required',


                ], [
                    'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
                    'nomor_surat.required' => 'Nomor Surat harus diisi',
                    'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                    'bentuk_surat.required' => 'Bentuk Surat harus diisi',
                    'tujuan_surat.required' => 'Tujuan Surat harus diisi',
                    'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
                    'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                    'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',

                    'sifat.required' => 'Sifat harus diisi',
                    'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',

                    'akses_satuan_upzis.required' => 'salah satu akses satuan harus diisi',
                    'akses_satuan_ranting.required' => 'salah satu akses satuan harus diisi',
                    'akses_satuan_pc.required' => 'salah satu akses satuan harus diisi',

                    'nama_surat.required' => 'Nama Surat harus diisi',
                    'scan_surat.required' => 'Scan Surat harus diisi',
                ]);
            }
        }

        // invalid untuk disposisi ya -> penerima golongan -> sppd ya
        if ($request->disposisi_ya == 'on' && $request->penerima_golongan == 'on' && $request->sppd_ya == 'on') {
            $request->validate([
                // surat masuk
                'tanggal_arsip' => 'required',
                'nomor_surat' => 'required',
                'klasifikasi_surat' => 'required',
                'bentuk_surat' => 'required',
                'tujuan_surat' => 'required',
                'tujuan_arsip' => 'required',
                'pengirim_sumber' => 'required',
                'perihal_isi_deskripsi' => 'required',
                // disposisi
                'sifat' => 'required',
                'perihal_disposisi' => 'required',
                'catatan_disposisi' => 'required|array',
                'catatan_disposisi.*' => 'string',
                // sppd
                'tgl_perintah' => 'required',
                'tgl_pelaksanaan' => 'required',
                'anggaran' => 'required',
                'perihal_sppd' => 'required',

                'akses_golongan' => 'required',

                'nama_surat' => 'required',
                'scan_surat' => 'required',
            ], [
                'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
                'nomor_surat.required' => 'Nomor Surat harus diisi',
                'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                'bentuk_surat.required' => 'Bentuk Surat harus diisi',
                'tujuan_surat.required' => 'Tujuan Surat harus diisi',
                'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
                'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',

                'sifat.required' => 'Sifat harus diisi',
                'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',

                'tgl_perintah.required' => 'Tanggal Perintah harus diisi',
                'tgl_pelaksanaan.required' => 'Tanggal Pelaksanaan harus diisi',
                'anggaran.required' => 'Anggaran harus diisi',
                'perihal_sppd.required' => 'Perihal Sppd harus diisi',
                'akses_golongan.required' => 'Akses Golongan Harus Diisi',

                'nama_surat.required' => 'Nama Surat harus diisi',
                'scan_surat.required' => 'Scan Surat harus diisi',
            ]);
        }

        // invalid untuk disposisi ya -> penerima golongan -> sppd tidak
        if ($request->disposisi_ya == 'on' && $request->penerima_golongan == 'on' && $request->sppd_tidak == 'on') {
            $request->validate([
                // surat masuk
                'tanggal_arsip' => 'required',
                'nomor_surat' => 'required',
                'klasifikasi_surat' => 'required',
                'bentuk_surat' => 'required',
                'tujuan_surat' => 'required',
                'tujuan_arsip' => 'required',
                'pengirim_sumber' => 'required',
                'perihal_isi_deskripsi' => 'required',
                // disposisi
                'sifat' => 'required',
                'perihal_disposisi' => 'required',
                'catatan_disposisi' => 'required|array',
                'catatan_disposisi.*' => 'string',

                'akses_golongan' => 'required',

                'nama_surat' => 'required',
                'scan_surat' => 'required',
            ], [
                'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
                'nomor_surat.required' => 'Nomor Surat harus diisi',
                'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                'bentuk_surat.required' => 'Bentuk Surat harus diisi',
                'tujuan_surat.required' => 'Tujuan Surat harus diisi',
                'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
                'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',

                'sifat.required' => 'Sifat harus diisi',
                'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',

                'akses_golongan.required' => 'Akses Golongan Harus Diisi',

                'nama_surat.required' => 'Nama Surat harus diisi',
                'scan_surat.required' => 'Scan Surat harus diisi',
            ]);
        }

        // invalid untuk disposisi ya -> penerima internal -> sppd ya
        if ($request->disposisi_ya == 'on' && $request->penerima_internal == 'on' && $request->sppd_ya == 'on') {
            $request->validate([
                // surat masuk
                'tanggal_arsip' => 'required',
                'nomor_surat' => 'required',
                'klasifikasi_surat' => 'required',
                'bentuk_surat' => 'required',
                'tujuan_surat' => 'required',
                'tujuan_arsip' => 'required',
                'pengirim_sumber' => 'required',
                'perihal_isi_deskripsi' => 'required',
                // disposisi
                'sifat' => 'required',
                'perihal_disposisi' => 'required',
                'catatan_disposisi' => 'required|array',
                'catatan_disposisi.*' => 'string',
                // sppd
                'tgl_perintah' => 'required',
                'tgl_pelaksanaan' => 'required',
                'anggaran' => 'required',
                'perihal_sppd' => 'required',

                'akses_internal' => 'required',

                'nama_surat' => 'required',
                'scan_surat' => 'required',
            ], [
                'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
                'nomor_surat.required' => 'Nomor Surat harus diisi',
                'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                'bentuk_surat.required' => 'Bentuk Surat harus diisi',
                'tujuan_surat.required' => 'Tujuan Surat harus diisi',
                'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
                'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',

                'sifat.required' => 'Sifat harus diisi',
                'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',

                'tgl_perintah.required' => 'Tanggal Perintah harus diisi',
                'tgl_pelaksanaan.required' => 'Tanggal Pelaksanaan harus diisi',
                'anggaran.required' => 'Anggaran harus diisi',
                'perihal_sppd.required' => 'Perihal Sppd harus diisi',
                'akses_internal.required' => 'Akses Internal Harus Diisi',

                'nama_surat.required' => 'Nama Surat harus diisi',
                'scan_surat.required' => 'Scan Surat harus diisi',
            ]);
        }

        // invalid untuk disposisi ya -> penerima internal -> sppd tidak
        if ($request->disposisi_ya == 'on' && $request->penerima_internal == 'on' && $request->sppd_tidak == 'on') {
            $request->validate([
                // surat masuk
                'tanggal_arsip' => 'required',
                'nomor_surat' => 'required',
                'klasifikasi_surat' => 'required',
                'bentuk_surat' => 'required',
                'tujuan_surat' => 'required',
                'tujuan_arsip' => 'required',
                'pengirim_sumber' => 'required',
                'perihal_isi_deskripsi' => 'required',
                // disposisi
                'sifat' => 'required',
                'perihal_disposisi' => 'required',
                'catatan_disposisi' => 'required|array',
                'catatan_disposisi.*' => 'string',

                'akses_internal' => 'required',

                'nama_surat' => 'required',
                'scan_surat' => 'required',
            ], [
                'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
                'nomor_surat.required' => 'Nomor Surat harus diisi',
                'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                'bentuk_surat.required' => 'Bentuk Surat harus diisi',
                'tujuan_surat.required' => 'Tujuan Surat harus diisi',
                'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
                'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',

                'sifat.required' => 'Sifat harus diisi',
                'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',

                'akses_internal.required' => 'Akses Internal Harus Diisi',

                'nama_surat.required' => 'Nama Surat harus diisi',
                'scan_surat.required' => 'Scan Surat harus diisi',
            ]);
        }

        // invalid untuk disposisi tidak -> penerima satuan -> sppd tidak
        if ($request->disposisi_tidak == 'on') {
            $request->validate([
                // surat masuk
                'tanggal_arsip' => 'required',
                'nomor_surat' => 'required',
                'klasifikasi_surat' => 'required',
                'bentuk_surat' => 'required',
                'tujuan_surat' => 'required',
                'tujuan_arsip' => 'required',
                'pengirim_sumber' => 'required',
                'perihal_isi_deskripsi' => 'required',

                'nama_surat' => 'required',
                'scan_surat' => 'required',
            ], [
                'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
                'nomor_surat.required' => 'Nomor Surat harus diisi',
                'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                'bentuk_surat.required' => 'Bentuk Surat harus diisi',
                'tujuan_surat.required' => 'Tujuan Surat harus diisi',
                'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
                'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',

                'nama_surat.required' => 'Nama Surat harus diisi',
                'scan_surat.required' => 'Scan Surat harus diisi',
            ]);
        }


        if ($request->penerima_golongan == 'on') {


            $s = implode(',', $request->akses_golongan);
            $b = explode(',', $s);


            if (count(collect($b)) == 1) {
                if ($b[0] == 'Semua Pengurus Internal') {
                    $internal = '1';
                    $upzis = '0';
                    $ranting = '0';
                } elseif ($b[0] == 'Semua UPZIS MWCNU') {
                    $internal = '0';
                    $upzis = '1';
                    $ranting = '0';
                } elseif ($b[0] == 'Semua Ranting NU') {
                    $internal = '0';
                    $upzis = '0';
                    $ranting = '1';
                }
            }

            if (count(collect($b)) == 2) {
                if ($b[0] == 'Semua Pengurus Internal' && $b[1] == 'Semua UPZIS MWCNU') {
                    $internal = '1';
                    $upzis = '1';
                    $ranting = '0';
                } elseif ($b[0] == 'Semua UPZIS MWCNU' && $b[1] == 'Semua Pengurus Internal') {
                    $internal = '1';
                    $upzis = '1';
                    $ranting = '0';
                } elseif ($b[0] == 'Semua Pengurus Internal' && $b[1] == 'Semua Ranting NU') {
                    $internal = '1';
                    $upzis = '0';
                    $ranting = '1';
                } elseif ($b[0] == 'Semua Ranting NU' && $b[1] == 'Semua Pengurus Internal') {
                    $internal = '1';
                    $upzis = '0';
                    $ranting = '1';
                } elseif ($b[0] == 'Semua UPZIS MWCNU' && $b[1] == 'Semua Ranting NU') {
                    $internal = '0';
                    $upzis = '1';
                    $ranting = '1';
                } elseif ($b[0] == 'Semua Ranting NU' && $b[1] == 'Semua UPZIS MWCNU') {
                    $internal = '0';
                    $upzis = '1';
                    $ranting = '1';
                }
            }

            if (count(collect($b)) == 3) {
                $internal = '1';
                $upzis = '1';
                $ranting = '1';
            }
        }

        // disposisi
        if ($request->akses_golongan == 'on') {
            $jenis_disposisi = 'Golongan';
        } else {
            $jenis_disposisi = 'Satuan';
        }

        // if ($request->disposisi_ya == 'on') {
        // }

        // id arsip digital
        $arsip_digital_id = uniqid();

        // terakhir yaitu create surat masuk
        if ($request->penerima_satuan == 'on') {


            // masukkan ke tabel arsip_digital
            $arsipdigital = ArsipDigital::create([
                'arsip_digital_id' => $arsip_digital_id,
                'id_pengguna' => Auth::user()->id_pengguna,
                'tanggal_index' => $request->created_at,
                'tanggal_arsip' => $request->tanggal_arsip,
                'jenis_arsip' => 'Surat Masuk',
                'jenis_disposisi' => 'Satuan',
                'nomor_surat' => $request->nomor_surat,
                'klasifikasi_surat' => $request->klasifikasi_surat,
                'bentuk_surat' => $request->bentuk_surat,
                'tujuan_surat' => $request->tujuan_surat,
                'tujuan_arsip' => $request->tujuan_arsip,
                'pengirim_sumber' => $request->pengirim_sumber,
                'perihal_isi_deskripsi' => $request->perihal_isi_deskripsi,
                'diinput_oleh' => Auth::user()->gocap_id_pc_pengurus,
                'alamat_pengirim' => $request->alamat_pengirim,
                'keterangan_surat_masuk' => $request->keterangan_surat_masuk,
                'keterangan_surat_keluar' => $request->keterangan_surat_keluar,
            ]);

            // Menggabungkan array menjadi string yang dipisahkan oleh koma
            $catatan_disposisi = implode(', ', $request->catatan_disposisi);

            // masukkan ke tabel disposisi dan sppd mwcnu

            if ($request->akses_satuan_upzis != NULL) {


                $b = 0;
                foreach ($request->akses_satuan_upzis as $index) {

                    $disposisi_id = uniqid();
                    $sppd_id = uniqid();
                    $dis = Disposisi::create([
                        'disposisi_id' => $disposisi_id,
                        'arsip_digital_id' => $arsip_digital_id,
                        'id_upzis' => $request->akses_satuan_upzis[$b],
                        'status_baca' => '0',
                        'sifat' => $request->sifat,
                        'perihal' => $request->perihal_disposisi,
                        'catatan_disposisi' => $catatan_disposisi,
                    ]);
                    if ($request->sppd_ya == 'on') {
                        Sppd::create([
                            'sppd_id' => $sppd_id,
                            'arsip_digital_id' => $arsip_digital_id,
                            'disposisi_id' => $disposisi_id,
                            'perihal' => $request->perihal_sppd,
                            'tgl_pelaksanaan' => $request->tgl_pelaksanaan,
                            'anggaran' => $anggaran,
                        ]);
                    }
                    $b++;
                }
            }
            if ($request->akses_satuan_pc != NULL) {


                $b = 0;
                foreach ($request->akses_satuan_pc as $index) {

                    $disposisi_id = uniqid();
                    $sppd_id = uniqid();
                    $dis = Disposisi::create([
                        'disposisi_id' => $disposisi_id,
                        'arsip_digital_id' => $arsip_digital_id,
                        'id_pc' => $request->akses_satuan_pc[$b],
                        'status_baca' => '0',
                        'sifat' => $request->sifat,
                        'perihal' => $request->perihal_disposisi,
                        'catatan_disposisi' => $catatan_disposisi,
                    ]);
                    if ($request->sppd_ya == 'on') {
                        Sppd::create([
                            'sppd_id' => $sppd_id,
                            'arsip_digital_id' => $arsip_digital_id,
                            'disposisi_id' => $disposisi_id,
                            'perihal' => $request->perihal_sppd,
                            'tgl_pelaksanaan' => $request->tgl_pelaksanaan,
                            'anggaran' => $anggaran,
                        ]);
                    }
                    $b++;
                }
            }
            if ($request->akses_satuan_ranting != NULL) {


                $b = 0;
                foreach ($request->akses_satuan_ranting as $index) {

                    $disposisi_id = uniqid();
                    $sppd_id = uniqid();
                    $dis = Disposisi::create([
                        'disposisi_id' => $disposisi_id,
                        'arsip_digital_id' => $arsip_digital_id,
                        'id_ranting' => $request->akses_satuan_ranting[$b],
                        'status_baca' => '0',
                        'sifat' => $request->sifat,
                        'perihal' => $request->perihal_disposisi,
                        'catatan_disposisi' => $catatan_disposisi,
                    ]);
                    if ($request->sppd_ya == 'on') {
                        Sppd::create([
                            'sppd_id' => $sppd_id,
                            'arsip_digital_id' => $arsip_digital_id,
                            'disposisi_id' => $disposisi_id,
                            'perihal' => $request->perihal_sppd,
                            'tgl_pelaksanaan' => $request->tgl_pelaksanaan,
                            'anggaran' => $anggaran,
                        ]);
                    }
                    $b++;
                }
            }
        } elseif ($request->penerima_golongan == 'on') {


            ArsipDigital::create([
                'arsip_digital_id' => $arsip_digital_id,
                'id_pengguna' => Auth::user()->id_pengguna,
                'tanggal_arsip' => $request->tanggal_arsip,
                'jenis_arsip' => 'Surat Masuk',
                'jenis_disposisi' => 'Golongan',
                'nomor_surat' => $request->nomor_surat,
                'klasifikasi_surat' => $request->klasifikasi_surat,
                'bentuk_surat' => $request->bentuk_surat,
                'tujuan_surat' => $request->tujuan_surat,
                'tujuan_arsip' => $request->tujuan_arsip,
                'pengirim_sumber' => $request->pengirim_sumber,
                'perihal_isi_deskripsi' => $request->perihal_isi_deskripsi,
                'diinput_oleh' => Auth::user()->gocap_id_pc_pengurus,
                'alamat_pengirim' => $request->alamat_pengirim,
                'keterangan_surat_masuk' => $request->keterangan_surat_masuk,
                'keterangan_surat_keluar' => $request->keterangan_surat_keluar,
            ]);



            if (Auth::user()->gocap_id_pc_pengurus != NULL) {
                $upzis_all = Upzis::all()->pluck('id_upzis')->toArray();
            } elseif (Auth::user()->gocap_id_upzis_pengurus != NULL) {
                $upzis_all = Upzis::all()->where('id_upzis', '!=', Auth::user()->UpzisPengurus->Upzis->id_upzis)->pluck('id_upzis')->toArray();
            }

            // Menggabungkan array menjadi string yang dipisahkan oleh koma
            $catatan_disposisi = implode(', ', $request->catatan_disposisi);
            // masukkan ke tabel disposisi dan sppd 
            if ($upzis == '1') {
                $b = 0;
                foreach ($upzis_all as $index) {
                    $disposisi_id = uniqid();
                    $sppd_id = uniqid();
                    $dis = Disposisi::create([
                        'disposisi_id' => $disposisi_id,
                        'arsip_digital_id' => $arsip_digital_id,
                        'id_upzis' => $upzis_all[$b],
                        'status_baca' => '0',
                        'sifat' => $request->sifat,
                        'perihal' => $request->perihal_disposisi,
                        'catatan_disposisi' => $catatan_disposisi,
                    ]);
                    if ($request->sppd_ya == 'on') {
                        Sppd::create([
                            'sppd_id' => $sppd_id,
                            'arsip_digital_id' => $arsip_digital_id,
                            'disposisi_id' => $disposisi_id,
                            'perihal' => $request->perihal_sppd,
                            'tgl_pelaksanaan' => $request->tgl_pelaksanaan,
                            'anggaran' => $anggaran,
                        ]);
                    }
                    $b++;
                }
            }

            if (Auth::user()->gocap_id_pc_pengurus != NULL) {
                $ranting_all = Ranting::all()->pluck('id_ranting')->toArray();
            } elseif (Auth::user()->gocap_id_upzis_pengurus != NULL) {
                $ranting_all = Ranting::all()->where('id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)->pluck('id_ranting')->toArray();
            }

            // Menggabungkan array menjadi string yang dipisahkan oleh koma
            $catatan_disposisi = implode(', ', $request->catatan_disposisi);
            if ($ranting == '1') {
                $b = 0;
                foreach ($ranting_all as $index) {
                    $disposisi_id = uniqid();
                    $sppd_id = uniqid();
                    $dis = Disposisi::create([
                        'disposisi_id' => $disposisi_id,
                        'arsip_digital_id' => $arsip_digital_id,
                        'id_ranting' => $ranting_all[$b],
                        'status_baca' => '0',
                        'sifat' => $request->sifat,
                        'perihal' => $request->perihal_disposisi,
                        'catatan_disposisi' => $catatan_disposisi,
                    ]);
                    if ($request->sppd_ya == 'on') {
                        Sppd::create([
                            'sppd_id' => $sppd_id,
                            'arsip_digital_id' => $arsip_digital_id,
                            'disposisi_id' => $disposisi_id,
                            'perihal' => $request->perihal_sppd,
                            'tgl_pelaksanaan' => $request->tgl_pelaksanaan,
                            'anggaran' => $anggaran,
                        ]);
                    }
                    $b++;
                }
            }

            if (Auth::user()->gocap_id_pc_pengurus != NULL) {
                $internal_all = PcPengurus::all()->where('id_pc', Auth::user()->PcPengurus->id_pc)->pluck('id_pc_pengurus')->toArray();
            } elseif (Auth::user()->gocap_id_upzis_pengurus != NULL) {
                $internal_all = UpzisPengurus::all()->where('id_upzis', Auth::user()->UpzisPengurus->id_upzis)->pluck('id_upzis_pengurus')->toArray();
            }
            // masukkan ke tabel disposisi 
            if ($internal == '1') {
                $b = 0;
                if (Auth::user()->gocap_id_pc_pengurus != NULL) {
                    foreach ($internal_all as $index) {
                        $disposisi_id = uniqid();
                        $sppd_id = uniqid();
                        $dis = Disposisi::create([
                            'disposisi_id' => $disposisi_id,
                            'arsip_digital_id' => $arsip_digital_id,
                            'id_pengurus_internal' => $internal_all[$b],
                            'status_baca' => '0',
                            'sifat' => $request->sifat,
                            'perihal' => $request->perihal_disposisi,
                            'catatan_disposisi' => $catatan_disposisi,
                        ]);
                        if ($request->sppd_ya == 'on') {
                            Sppd::create([
                                'sppd_id' => $sppd_id,
                                'arsip_digital_id' => $arsip_digital_id,
                                'disposisi_id' => $disposisi_id,
                                'perihal' => $request->perihal_sppd,
                                'tgl_pelaksanaan' => $request->tgl_pelaksanaan,
                                'anggaran' => $anggaran,
                            ]);
                        }
                        $b++;
                    }
                } elseif (Auth::user()->gocap_id_upzis_pengurus != NULL) {
                    foreach ($internal_all as $index) {
                        $disposisi_id = uniqid();
                        $sppd_id = uniqid();
                        $dis = Disposisi::create([
                            'disposisi_id' => $disposisi_id,
                            'arsip_digital_id' => $arsip_digital_id,
                            'id_pengurus_internal' => $internal_all[$b],
                            'status_baca' => '0',
                            'sifat' => $request->sifat,
                            'perihal' => $request->perihal_disposisi,
                            'catatan_disposisi' => $catatan_disposisi,
                        ]);
                        if ($request->sppd_ya == 'on') {
                            Sppd::create([
                                'sppd_id' => $sppd_id,
                                'arsip_digital_id' => $arsip_digital_id,
                                'disposisi_id' => $disposisi_id,
                                'perihal' => $request->perihal_sppd,
                                'tgl_pelaksanaan' => $request->tgl_pelaksanaan,
                                'anggaran' => $anggaran,
                            ]);
                        }
                        $b++;
                    }
                }
            }
        } elseif ($request->penerima_internal == 'on') {


            // masukkan ke tabel arsip_digital
            ArsipDigital::create([
                'arsip_digital_id' => $arsip_digital_id,
                'id_pengguna' => Auth::user()->id_pengguna,
                'tanggal_arsip' => $request->tanggal_arsip,
                'jenis_arsip' => 'Surat Masuk',
                'jenis_disposisi' => 'Internal',
                'nomor_surat' => $request->nomor_surat,
                'klasifikasi_surat' => $request->klasifikasi_surat,
                'bentuk_surat' => $request->bentuk_surat,
                'tujuan_surat' => $request->tujuan_surat,
                'tujuan_arsip' => $request->tujuan_arsip,
                'pengirim_sumber' => $request->pengirim_sumber,
                'perihal_isi_deskripsi' => $request->perihal_isi_deskripsi,
                'isi_surat' => $request->isi_surat,
                'diinput_oleh' => Auth::user()->gocap_id_pc_pengurus,
                'alamat_pengirim' => $request->alamat_pengirim,
                'keterangan_surat_masuk' => $request->keterangan_surat_masuk,
                'keterangan_surat_keluar' => $request->keterangan_surat_keluar,
            ]);

            // Menggabungkan array menjadi string yang dipisahkan oleh koma
            $catatan_disposisi = implode(', ', $request->catatan_disposisi);

            if (Auth::user()->gocap_id_pc_pengurus != null) {

                // masukkan ke tabel internal dan sppd internal
                if ($request->akses_internal != NULL) {
                    $b = 0;
                    foreach ($request->akses_internal as $index) {
                        $disposisi_id = uniqid();
                        $sppd_id = uniqid();
                        $dis = Disposisi::create([
                            'disposisi_id' => $disposisi_id,
                            'arsip_digital_id' => $arsip_digital_id,
                            'id_pengurus_internal' => $request->akses_internal[$b],
                            'status_baca' => '0',
                            'sifat' => $request->sifat,
                            'perihal' => $request->perihal_disposisi,
                            'catatan_disposisi' => $catatan_disposisi,
                        ]);
                        if ($request->sppd_ya == 'on') {
                            Sppd::create([
                                'sppd_id' => $sppd_id,
                                'arsip_digital_id' => $arsip_digital_id,
                                'disposisi_id' => $disposisi_id,
                                'perihal' => $request->perihal_sppd,
                                'tgl_pelaksanaan' => $request->tgl_pelaksanaan,
                                'anggaran' => $anggaran,
                            ]);
                        }
                        $b++;
                    }
                }
            }
            if (Auth::user()->gocap_id_upzis_pengurus != null) {

                // masukkan ke tabel internal dan sppd internal
                if ($request->akses_internal != NULL) {
                    $b = 0;
                    foreach ($request->akses_internal as $index) {
                        $disposisi_id = uniqid();
                        $sppd_id = uniqid();
                        $dis = Disposisi::create([
                            'disposisi_id' => $disposisi_id,
                            'arsip_digital_id' => $arsip_digital_id,
                            'id_pengurus_internal' => $request->akses_internal[$b],
                            'status_baca' => '0',
                            'sifat' => $request->sifat,
                            'perihal' => $request->perihal_disposisi,
                            'catatan_disposisi' => $catatan_disposisi,
                        ]);
                        if ($request->sppd_ya == 'on') {
                            Sppd::create([
                                'sppd_id' => $sppd_id,
                                'arsip_digital_id' => $arsip_digital_id,
                                'disposisi_id' => $disposisi_id,
                                'perihal' => $request->perihal_sppd,
                                'tgl_pelaksanaan' => $request->tgl_pelaksanaan,
                                'anggaran' => $anggaran,
                            ]);
                        }
                        $b++;
                    }
                }
            }
        }

        if ($request->scan_surat != null && $request->nama_surat != null) {
            $file = $request->file('scan_surat');
            $ext_logo = $file->extension();
            $filename_scan = $file->storeAs('/lampiran', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext_logo, ['disk' => 'lampiran']);
            $lampiran = LampiranArsip::create([
                'lampiran_arsip_id' => uniqid(),
                'arsip_digital_id' => $arsip_digital_id,
                'nama' => $request->nama_surat,
                'jenis' => 'Scan Surat',
                'file' => $filename_scan,
            ]);

            if ($request->lampiran != null &&  $request->nama != null) {
                if ($request->nama && count($request->nama) > 0) {
                    $a = 0;
                    foreach ($request->file('lampiran') as $index) {

                        $file = $index;
                        $ext_logo = $file->extension();

                        $filename_lampiran = $file->storeAs('/lampiran', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext_logo, ['disk' => 'lampiran']);
                        $validatedData['lampiran_arsip_id'] = uniqid();
                        $validatedData['arsip_digital_id'] = $arsip_digital_id;
                        $validatedData['nama'] = $request->nama[$a];
                        $validatedData['jenis'] = 'Lampiran';
                        $validatedData['file'] = $filename_lampiran;
                        LampiranArsip::create($validatedData);

                        $a++;
                    }
                }
            }
        }

        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('Surat Masuk ' . $cek . ' Berhasil Ditambahkan');
        // dd($dis);

        if (Auth::user()->gocap_id_pc_pengurus != null) {
            return redirect('/' . $request->role . '/arsip/detail_surat_masuk/' . $arsip_digital_id . '/pc')->with('success', 'Data berhasil ditambahkan');
        } elseif (Auth::user()->gocap_id_upzis_pengurus != null) {
            return redirect('/' . $request->role . '/arsip/detail_surat_masuk/' . $arsip_digital_id . '/upzis')->with('success', 'Data berhasil ditambahkan');
        }
    }

    // public function aksi_tambah_surat_masuk(Request $request)
    // {
    //     $earsip = config('app.database_earsip');
    //     $siftnu = config('app.database_siftnu');
    //     $gocap = config('app.database_gocap');
    //     $anggaran = str_replace('.', '',  $request->anggaran);



    //     if (Auth::user()->gocap_id_pc_pengurus != null) {
    //         // invalid untuk disposisi ya -> penerima satuan -> sppd ya
    //         if ($request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_ya == 'on' && $request->akses_satuan_upzis == null && $request->akses_satuan_ranting == null) {
    //             $request->validate([
    //                 // surat masuk
    //                 'tanggal_index' => 'required',
    //                 'tanggal_arsip' => 'required',
    //                 'nomor_surat' => 'required',
    //                 'klasifikasi_surat' => 'required',
    //                 'bentuk_surat' => 'required',
    //                 'tujuan_surat' => 'required',
    //                 'tujuan_arsip' => 'required',
    //                 'pengirim_sumber' => 'required',
    //                 'perihal_isi_deskripsi' => 'required',
    //                 // disposisi
    //                 'sifat' => 'required',
    //                 'perihal_disposisi' => 'required',
    //                 'catatan_disposisi' => 'required|array',
    //                 // sppd
    //                 'tgl_perintah' => 'required',
    //                 'tgl_pelaksanaan' => 'required',
    //                 'anggaran' => 'required',
    //                 'perihal_sppd' => 'required',

    //                 'akses_satuan_upzis' => 'required',
    //                 'akses_satuan_ranting' => 'required',

    //                 'nama_surat' => 'required',
    //                 'scan_surat' => 'required',
    //             ], [
    //                 'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
    //                 'nomor_surat.required' => 'Nomor Surat harus diisi',
    //                 'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
    //                 'bentuk_surat.required' => 'Bentuk Surat harus diisi',
    //                 'tujuan_surat.required' => 'Tujuan Surat harus diisi',
    //                 'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
    //                 'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
    //                 'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',

    //                 'sifat.required' => 'Sifat harus diisi',
    //                 'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',

    //                 'tgl_perintah.required' => 'Tanggal Perintah harus diisi',
    //                 'tgl_pelaksanaan.required' => 'Tanggal Pelaksanaan harus diisi',
    //                 'anggaran.required' => 'Anggaran harus diisi',
    //                 'perihal_sppd.required' => 'Perihal Sppd harus diisi',

    //                 'akses_satuan_upzis.required' => 'salah satu akses satuan harus diisi',
    //                 'akses_satuan_ranting.required' => 'salah satu akses satuan harus diisi',

    //                 'nama_surat.required' => 'Nama Surat harus diisi',
    //                 'scan_surat.required' => 'Scan Surat harus diisi',
    //             ]);
    //         }

    //         if (
    //             $request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_ya == 'on' && $request->akses_satuan_upzis != null ||
    //             $request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_ya == 'on' && $request->akses_satuan_ranting != null
    //         ) {
    //             $request->validate([
    //                 // surat masuk
    //                 'tanggal_arsip' => 'required',
    //                 'nomor_surat' => 'required',
    //                 'klasifikasi_surat' => 'required',
    //                 'bentuk_surat' => 'required',
    //                 'tujuan_surat' => 'required',
    //                 'tujuan_arsip' => 'required',
    //                 'pengirim_sumber' => 'required',
    //                 'perihal_isi_deskripsi' => 'required',
    //                 // disposisi
    //                 'sifat' => 'required',
    //                 'perihal_disposisi' => 'required',
    //                 // sppd
    //                 'tgl_perintah' => 'required',
    //                 'tgl_pelaksanaan' => 'required',
    //                 'anggaran' => 'required',
    //                 'perihal_sppd' => 'required',
    //                 'nama_surat' => 'required',
    //                 'scan_surat' => 'required',

    //             ], [
    //                 'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
    //                 'nomor_surat.required' => 'Nomor Surat harus diisi',
    //                 'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
    //                 'bentuk_surat.required' => 'Bentuk Surat harus diisi',
    //                 'tujuan_surat.required' => 'Tujuan Surat harus diisi',
    //                 'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
    //                 'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
    //                 'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',

    //                 'sifat.required' => 'Sifat harus diisi',
    //                 'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',

    //                 'tgl_perintah.required' => 'Tanggal Perintah harus diisi',
    //                 'tgl_pelaksanaan.required' => 'Tanggal Pelaksanaan harus diisi',
    //                 'anggaran.required' => 'Anggaran harus diisi',
    //                 'perihal_sppd.required' => 'Perihal Sppd harus diisi',
    //                 'nama_surat.required' => 'Nama Surat harus diisi',
    //                 'scan_surat.required' => 'Scan Surat harus diisi',

    //             ]);
    //         }

    //         // invalid untuk disposisi ya -> penerima satuan -> sppd tidak
    //         if (
    //             $request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_tidak == 'on' && $request->akses_satuan_upzis != null ||
    //             $request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_tidak == 'on' && $request->akses_satuan_ranting != null
    //         ) {
    //             $request->validate([
    //                 // surat masuk
    //                 'tanggal_arsip' => 'required',
    //                 'nomor_surat' => 'required',
    //                 'klasifikasi_surat' => 'required',
    //                 'bentuk_surat' => 'required',
    //                 'tujuan_surat' => 'required',
    //                 'tujuan_arsip' => 'required',
    //                 'pengirim_sumber' => 'required',
    //                 'perihal_isi_deskripsi' => 'required',
    //                 // disposisi
    //                 'sifat' => 'required',
    //                 'perihal_disposisi' => 'required',
    //                 'nama_surat' => 'required',
    //                 'scan_surat' => 'required',

    //             ], [
    //                 'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
    //                 'nomor_surat.required' => 'Nomor Surat harus diisi',
    //                 'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
    //                 'bentuk_surat.required' => 'Bentuk Surat harus diisi',
    //                 'tujuan_surat.required' => 'Tujuan Surat harus diisi',
    //                 'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
    //                 'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
    //                 'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',

    //                 'sifat.required' => 'Sifat harus diisi',
    //                 'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',
    //                 'nama_surat.required' => 'Nama Surat harus diisi',
    //                 'scan_surat.required' => 'Scan Surat harus diisi',

    //             ]);
    //         }

    //         // invalid untuk disposisi ya -> penerima satuan -> sppd tidak
    //         if ($request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_tidak == 'on' && $request->akses_satuan_upzis == null && $request->akses_satuan_ranting == null) {

    //             $request->validate([
    //                 // surat masuk
    //                 'tanggal_arsip' => 'required',
    //                 'nomor_surat' => 'required',
    //                 'klasifikasi_surat' => 'required',
    //                 'bentuk_surat' => 'required',
    //                 'tujuan_surat' => 'required',
    //                 'tujuan_arsip' => 'required',
    //                 'pengirim_sumber' => 'required',
    //                 'perihal_isi_deskripsi' => 'required',
    //                 // disposisi
    //                 'sifat' => 'required',
    //                 'perihal_disposisi' => 'required',

    //                 'akses_satuan_upzis' => 'required',
    //                 'akses_satuan_ranting' => 'required',
    //                 'nama_surat' => 'required',
    //                 'scan_surat' => 'required',


    //             ], [
    //                 'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
    //                 'nomor_surat.required' => 'Nomor Surat harus diisi',
    //                 'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
    //                 'bentuk_surat.required' => 'Bentuk Surat harus diisi',
    //                 'tujuan_surat.required' => 'Tujuan Surat harus diisi',
    //                 'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
    //                 'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
    //                 'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',

    //                 'sifat.required' => 'Sifat harus diisi',
    //                 'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',

    //                 'akses_satuan_upzis.required' => 'salah satu akses satuan harus diisi',
    //                 'akses_satuan_ranting.required' => 'salah satu akses satuan harus diisi',

    //                 'nama_surat.required' => 'Nama Surat harus diisi',
    //                 'scan_surat.required' => 'Scan Surat harus diisi',
    //             ]);
    //         }
    //     }

    //     if (Auth::user()->gocap_id_upzis_pengurus != null) {
    //         // invalid untuk disposisi ya -> penerima satuan -> sppd ya
    //         if ($request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_ya == 'on' && $request->akses_satuan_upzis == null && $request->akses_satuan_ranting == null && $request->akses_satuan_pc == null) {
    //             $request->validate([
    //                 // surat masuk
    //                 'tanggal_arsip' => 'required',
    //                 'nomor_surat' => 'required',
    //                 'klasifikasi_surat' => 'required',
    //                 'bentuk_surat' => 'required',
    //                 'tujuan_surat' => 'required',
    //                 'tujuan_arsip' => 'required',
    //                 'pengirim_sumber' => 'required',
    //                 'perihal_isi_deskripsi' => 'required',
    //                 // disposisi
    //                 'sifat' => 'required',
    //                 'perihal_disposisi' => 'required',
    //                 // sppd
    //                 'tgl_perintah' => 'required',
    //                 'tgl_pelaksanaan' => 'required',
    //                 'anggaran' => 'required',
    //                 'perihal_sppd' => 'required',

    //                 'akses_satuan_upzis' => 'required',
    //                 'akses_satuan_ranting' => 'required',
    //                 'akses_satuan_pc' => 'required',

    //                 'nama_surat' => 'required',
    //                 'scan_surat' => 'required',

    //             ], [
    //                 'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
    //                 'nomor_surat.required' => 'Nomor Surat harus diisi',
    //                 'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
    //                 'bentuk_surat.required' => 'Bentuk Surat harus diisi',
    //                 'tujuan_surat.required' => 'Tujuan Surat harus diisi',
    //                 'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
    //                 'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
    //                 'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',

    //                 'akses_satuan.required' => 'Akses Satuan harus diisi',
    //                 'sifat.required' => 'Sifat harus diisi',
    //                 'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',

    //                 'tgl_perintah.required' => 'Tanggal Perintah harus diisi',
    //                 'tgl_pelaksanaan.required' => 'Tanggal Pelaksanaan harus diisi',
    //                 'anggaran.required' => 'Anggaran harus diisi',
    //                 'perihal_sppd.required' => 'Perihal Sppd harus diisi',

    //                 'akses_satuan_upzis.required' => 'salah satu akses satuan harus diisi',
    //                 'akses_satuan_ranting.required' => 'salah satu akses satuan harus diisi',
    //                 'akses_satuan_pc.required' => 'salah satu akses satuan harus diisi',

    //                 'nama_surat.required' => 'Nama Surat harus diisi',
    //                 'scan_surat.required' => 'Scan Surat harus diisi',
    //             ]);
    //         }

    //         if (
    //             $request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_ya == 'on' && $request->akses_satuan_upzis != null ||
    //             $request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_ya == 'on' &&  $request->akses_satuan_ranting != null ||
    //             $request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_ya == 'on' &&  $request->akses_satuan_pc != null
    //         ) {
    //             $request->validate([
    //                 // surat masuk
    //                 'tanggal_arsip' => 'required',
    //                 'nomor_surat' => 'required',
    //                 'klasifikasi_surat' => 'required',
    //                 'bentuk_surat' => 'required',
    //                 'tujuan_surat' => 'required',
    //                 'tujuan_arsip' => 'required',
    //                 'pengirim_sumber' => 'required',
    //                 'perihal_isi_deskripsi' => 'required',
    //                 // disposisi
    //                 'sifat' => 'required',
    //                 'perihal_disposisi' => 'required',
    //                 // sppd
    //                 'tgl_perintah' => 'required',
    //                 'tgl_pelaksanaan' => 'required',
    //                 'anggaran' => 'required',
    //                 'perihal_sppd' => 'required',

    //                 'nama_surat' => 'required',
    //                 'scan_surat' => 'required',


    //             ], [
    //                 'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
    //                 'nomor_surat.required' => 'Nomor Surat harus diisi',
    //                 'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
    //                 'bentuk_surat.required' => 'Bentuk Surat harus diisi',
    //                 'tujuan_surat.required' => 'Tujuan Surat harus diisi',
    //                 'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
    //                 'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
    //                 'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',

    //                 'akses_satuan.required' => 'Akses Satuan harus diisi',
    //                 'sifat.required' => 'Sifat harus diisi',
    //                 'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',

    //                 'tgl_perintah.required' => 'Tanggal Perintah harus diisi',
    //                 'tgl_pelaksanaan.required' => 'Tanggal Pelaksanaan harus diisi',
    //                 'anggaran.required' => 'Anggaran harus diisi',
    //                 'perihal_sppd.required' => 'Perihal Sppd harus diisi',

    //                 'nama_surat.required' => 'Nama Surat harus diisi',
    //                 'scan_surat.required' => 'Scan Surat harus diisi',

    //             ]);
    //         }

    //         // invalid untuk disposisi ya -> penerima satuan -> sppd tidak
    //         if (
    //             $request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_tidak == 'on' && $request->akses_satuan_upzis != null ||
    //             $request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_tidak == 'on' &&  $request->akses_satuan_ranting != null ||
    //             $request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_tidak == 'on' && $request->akses_satuan_pc != null
    //         ) {
    //             $request->validate([
    //                 // surat masuk
    //                 'tanggal_arsip' => 'required',
    //                 'nomor_surat' => 'required',
    //                 'klasifikasi_surat' => 'required',
    //                 'bentuk_surat' => 'required',
    //                 'tujuan_surat' => 'required',
    //                 'tujuan_arsip' => 'required',
    //                 'pengirim_sumber' => 'required',
    //                 'perihal_isi_deskripsi' => 'required',
    //                 // disposisi
    //                 'sifat' => 'required',
    //                 'perihal_disposisi' => 'required',
    //                 'nama_surat' => 'required',
    //                 'scan_surat' => 'required',


    //             ], [
    //                 'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
    //                 'nomor_surat.required' => 'Nomor Surat harus diisi',
    //                 'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
    //                 'bentuk_surat.required' => 'Bentuk Surat harus diisi',
    //                 'tujuan_surat.required' => 'Tujuan Surat harus diisi',
    //                 'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
    //                 'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
    //                 'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',

    //                 'sifat.required' => 'Sifat harus diisi',
    //                 'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',

    //                 'nama_surat.required' => 'Nama Surat harus diisi',
    //                 'scan_surat.required' => 'Scan Surat harus diisi',

    //             ]);
    //         }

    //         // invalid untuk disposisi ya -> penerima satuan -> sppd tidak
    //         if (
    //             $request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_tidak == 'on' && $request->akses_satuan_upzis == null
    //             && $request->akses_satuan_ranting == null
    //             &&  $request->akses_satuan_pc == null
    //         ) {

    //             $request->validate([
    //                 // surat masuk
    //                 'tanggal_arsip' => 'required',
    //                 'nomor_surat' => 'required',
    //                 'klasifikasi_surat' => 'required',
    //                 'bentuk_surat' => 'required',
    //                 'tujuan_surat' => 'required',
    //                 'tujuan_arsip' => 'required',
    //                 'pengirim_sumber' => 'required',
    //                 'perihal_isi_deskripsi' => 'required',
    //                 // disposisi
    //                 'sifat' => 'required',
    //                 'perihal_disposisi' => 'required',

    //                 'akses_satuan_upzis' => 'required',
    //                 'akses_satuan_ranting' => 'required',
    //                 'akses_satuan_pc' => 'required',

    //                 'nama_surat' => 'required',
    //                 'scan_surat' => 'required',


    //             ], [
    //                 'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
    //                 'nomor_surat.required' => 'Nomor Surat harus diisi',
    //                 'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
    //                 'bentuk_surat.required' => 'Bentuk Surat harus diisi',
    //                 'tujuan_surat.required' => 'Tujuan Surat harus diisi',
    //                 'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
    //                 'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
    //                 'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',

    //                 'sifat.required' => 'Sifat harus diisi',
    //                 'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',

    //                 'akses_satuan_upzis.required' => 'salah satu akses satuan harus diisi',
    //                 'akses_satuan_ranting.required' => 'salah satu akses satuan harus diisi',
    //                 'akses_satuan_pc.required' => 'salah satu akses satuan harus diisi',

    //                 'nama_surat.required' => 'Nama Surat harus diisi',
    //                 'scan_surat.required' => 'Scan Surat harus diisi',
    //             ]);
    //         }
    //     }

    //     // invalid untuk disposisi ya -> penerima golongan -> sppd ya
    //     if ($request->disposisi_ya == 'on' && $request->penerima_golongan == 'on' && $request->sppd_ya == 'on') {
    //         $request->validate([
    //             // surat masuk
    //             'tanggal_arsip' => 'required',
    //             'nomor_surat' => 'required',
    //             'klasifikasi_surat' => 'required',
    //             'bentuk_surat' => 'required',
    //             'tujuan_surat' => 'required',
    //             'tujuan_arsip' => 'required',
    //             'pengirim_sumber' => 'required',
    //             'perihal_isi_deskripsi' => 'required',
    //             // disposisi
    //             'sifat' => 'required',
    //             'perihal_disposisi' => 'required',
    //             // sppd
    //             'tgl_perintah' => 'required',
    //             'tgl_pelaksanaan' => 'required',
    //             'anggaran' => 'required',
    //             'perihal_sppd' => 'required',

    //             'akses_golongan' => 'required',

    //             'nama_surat' => 'required',
    //             'scan_surat' => 'required',
    //         ], [
    //             'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
    //             'nomor_surat.required' => 'Nomor Surat harus diisi',
    //             'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
    //             'bentuk_surat.required' => 'Bentuk Surat harus diisi',
    //             'tujuan_surat.required' => 'Tujuan Surat harus diisi',
    //             'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
    //             'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
    //             'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',

    //             'sifat.required' => 'Sifat harus diisi',
    //             'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',

    //             'tgl_perintah.required' => 'Tanggal Perintah harus diisi',
    //             'tgl_pelaksanaan.required' => 'Tanggal Pelaksanaan harus diisi',
    //             'anggaran.required' => 'Anggaran harus diisi',
    //             'perihal_sppd.required' => 'Perihal Sppd harus diisi',
    //             'akses_golongan.required' => 'Akses Golongan Harus Diisi',

    //             'nama_surat.required' => 'Nama Surat harus diisi',
    //             'scan_surat.required' => 'Scan Surat harus diisi',
    //         ]);
    //     }

    //     // invalid untuk disposisi ya -> penerima golongan -> sppd tidak
    //     if ($request->disposisi_ya == 'on' && $request->penerima_golongan == 'on' && $request->sppd_tidak == 'on') {
    //         $request->validate([
    //             // surat masuk
    //             'tanggal_arsip' => 'required',
    //             'nomor_surat' => 'required',
    //             'klasifikasi_surat' => 'required',
    //             'bentuk_surat' => 'required',
    //             'tujuan_surat' => 'required',
    //             'tujuan_arsip' => 'required',
    //             'pengirim_sumber' => 'required',
    //             'perihal_isi_deskripsi' => 'required',
    //             // disposisi
    //             'sifat' => 'required',
    //             'perihal_disposisi' => 'required',

    //             'akses_golongan' => 'required',

    //             'nama_surat' => 'required',
    //             'scan_surat' => 'required',
    //         ], [
    //             'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
    //             'nomor_surat.required' => 'Nomor Surat harus diisi',
    //             'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
    //             'bentuk_surat.required' => 'Bentuk Surat harus diisi',
    //             'tujuan_surat.required' => 'Tujuan Surat harus diisi',
    //             'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
    //             'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
    //             'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',

    //             'sifat.required' => 'Sifat harus diisi',
    //             'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',

    //             'akses_golongan.required' => 'Akses Golongan Harus Diisi',

    //             'nama_surat.required' => 'Nama Surat harus diisi',
    //             'scan_surat.required' => 'Scan Surat harus diisi',
    //         ]);
    //     }

    //     // invalid untuk disposisi ya -> penerima internal -> sppd ya
    //     if ($request->disposisi_ya == 'on' && $request->penerima_internal == 'on' && $request->sppd_ya == 'on') {
    //         $request->validate([
    //             // surat masuk
    //             'tanggal_arsip' => 'required',
    //             'nomor_surat' => 'required',
    //             'klasifikasi_surat' => 'required',
    //             'bentuk_surat' => 'required',
    //             'tujuan_surat' => 'required',
    //             'tujuan_arsip' => 'required',
    //             'pengirim_sumber' => 'required',
    //             'perihal_isi_deskripsi' => 'required',
    //             // disposisi
    //             'sifat' => 'required',
    //             'perihal_disposisi' => 'required',
    //             // sppd
    //             'tgl_perintah' => 'required',
    //             'tgl_pelaksanaan' => 'required',
    //             'anggaran' => 'required',
    //             'perihal_sppd' => 'required',

    //             'akses_internal' => 'required',

    //             'nama_surat' => 'required',
    //             'scan_surat' => 'required',
    //         ], [
    //             'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
    //             'nomor_surat.required' => 'Nomor Surat harus diisi',
    //             'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
    //             'bentuk_surat.required' => 'Bentuk Surat harus diisi',
    //             'tujuan_surat.required' => 'Tujuan Surat harus diisi',
    //             'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
    //             'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
    //             'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',

    //             'sifat.required' => 'Sifat harus diisi',
    //             'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',

    //             'tgl_perintah.required' => 'Tanggal Perintah harus diisi',
    //             'tgl_pelaksanaan.required' => 'Tanggal Pelaksanaan harus diisi',
    //             'anggaran.required' => 'Anggaran harus diisi',
    //             'perihal_sppd.required' => 'Perihal Sppd harus diisi',
    //             'akses_internal.required' => 'Akses Internal Harus Diisi',

    //             'nama_surat.required' => 'Nama Surat harus diisi',
    //             'scan_surat.required' => 'Scan Surat harus diisi',
    //         ]);
    //     }

    //     // invalid untuk disposisi ya -> penerima internal -> sppd tidak
    //     if ($request->disposisi_ya == 'on' && $request->penerima_internal == 'on' && $request->sppd_tidak == 'on') {
    //         $request->validate([
    //             // surat masuk
    //             'tanggal_arsip' => 'required',
    //             'nomor_surat' => 'required',
    //             'klasifikasi_surat' => 'required',
    //             'bentuk_surat' => 'required',
    //             'tujuan_surat' => 'required',
    //             'tujuan_arsip' => 'required',
    //             'pengirim_sumber' => 'required',
    //             'perihal_isi_deskripsi' => 'required',
    //             // disposisi
    //             'sifat' => 'required',
    //             'perihal_disposisi' => 'required',

    //             'akses_internal' => 'required',

    //             'nama_surat' => 'required',
    //             'scan_surat' => 'required',
    //         ], [
    //             'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
    //             'nomor_surat.required' => 'Nomor Surat harus diisi',
    //             'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
    //             'bentuk_surat.required' => 'Bentuk Surat harus diisi',
    //             'tujuan_surat.required' => 'Tujuan Surat harus diisi',
    //             'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
    //             'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
    //             'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',

    //             'sifat.required' => 'Sifat harus diisi',
    //             'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',

    //             'akses_internal.required' => 'Akses Internal Harus Diisi',

    //             'nama_surat.required' => 'Nama Surat harus diisi',
    //             'scan_surat.required' => 'Scan Surat harus diisi',
    //         ]);
    //     }

    //     // invalid untuk disposisi tidak -> penerima satuan -> sppd tidak
    //     if ($request->disposisi_tidak == 'on') {
    //         $request->validate([
    //             // surat masuk
    //             'tanggal_arsip' => 'required',
    //             'nomor_surat' => 'required',
    //             'klasifikasi_surat' => 'required',
    //             'bentuk_surat' => 'required',
    //             'tujuan_surat' => 'required',
    //             'tujuan_arsip' => 'required',
    //             'pengirim_sumber' => 'required',
    //             'perihal_isi_deskripsi' => 'required',

    //             'nama_surat' => 'required',
    //             'scan_surat' => 'required',
    //         ], [
    //             'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
    //             'nomor_surat.required' => 'Nomor Surat harus diisi',
    //             'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
    //             'bentuk_surat.required' => 'Bentuk Surat harus diisi',
    //             'tujuan_surat.required' => 'Tujuan Surat harus diisi',
    //             'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
    //             'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
    //             'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',

    //             'nama_surat.required' => 'Nama Surat harus diisi',
    //             'scan_surat.required' => 'Scan Surat harus diisi',
    //         ]);
    //     }


    //     if ($request->penerima_golongan == 'on') {


    //         $s = implode(',', $request->akses_golongan);
    //         $b = explode(',', $s);


    //         if (count(collect($b)) == 1) {
    //             if ($b[0] == 'Semua Pengurus Internal') {
    //                 $internal = '1';
    //                 $upzis = '0';
    //                 $ranting = '0';
    //             } elseif ($b[0] == 'Semua UPZIS MWCNU') {
    //                 $internal = '0';
    //                 $upzis = '1';
    //                 $ranting = '0';
    //             } elseif ($b[0] == 'Semua Ranting NU') {
    //                 $internal = '0';
    //                 $upzis = '0';
    //                 $ranting = '1';
    //             }
    //         }

    //         if (count(collect($b)) == 2) {
    //             if ($b[0] == 'Semua Pengurus Internal' && $b[1] == 'Semua UPZIS MWCNU') {
    //                 $internal = '1';
    //                 $upzis = '1';
    //                 $ranting = '0';
    //             } elseif ($b[0] == 'Semua UPZIS MWCNU' && $b[1] == 'Semua Pengurus Internal') {
    //                 $internal = '1';
    //                 $upzis = '1';
    //                 $ranting = '0';
    //             } elseif ($b[0] == 'Semua Pengurus Internal' && $b[1] == 'Semua Ranting NU') {
    //                 $internal = '1';
    //                 $upzis = '0';
    //                 $ranting = '1';
    //             } elseif ($b[0] == 'Semua Ranting NU' && $b[1] == 'Semua Pengurus Internal') {
    //                 $internal = '1';
    //                 $upzis = '0';
    //                 $ranting = '1';
    //             } elseif ($b[0] == 'Semua UPZIS MWCNU' && $b[1] == 'Semua Ranting NU') {
    //                 $internal = '0';
    //                 $upzis = '1';
    //                 $ranting = '1';
    //             } elseif ($b[0] == 'Semua Ranting NU' && $b[1] == 'Semua UPZIS MWCNU') {
    //                 $internal = '0';
    //                 $upzis = '1';
    //                 $ranting = '1';
    //             }
    //         }

    //         if (count(collect($b)) == 3) {
    //             $internal = '1';
    //             $upzis = '1';
    //             $ranting = '1';
    //         }
    //     }

    //     // disposisi
    //     if ($request->akses_golongan == 'on') {
    //         $jenis_disposisi = 'Golongan';
    //     } else {
    //         $jenis_disposisi = 'Satuan';
    //     }

    //     if ($request->disposisi_ya == 'on') {
    //     }


    //     // id arsip digital
    //     $arsip_digital_id = uniqid();
    //     // terakhir yaitu create surat masuk
    //     if ($request->disposisi_ya == 'on') {
    //         if ($request->penerima_satuan == 'on') {


    //             // masukkan ke tabel arsip_digital
    //             ArsipDigital::create([
    //                 'arsip_digital_id' => $arsip_digital_id,
    //                 'id_pengguna' => Auth::user()->id_pengguna,
    //                 'tanggal_index' => $request->created_at,
    //                 'tanggal_arsip' => $request->tanggal_arsip,
    //                 'jenis_arsip' => 'Surat Masuk',
    //                 'jenis_disposisi' => 'Satuan',
    //                 'nomor_surat' => $request->nomor_surat,
    //                 'klasifikasi_surat' => $request->klasifikasi_surat,
    //                 'bentuk_surat' => $request->bentuk_surat,
    //                 'tujuan_surat' => $request->tujuan_surat,
    //                 'tujuan_arsip' => $request->tujuan_arsip,
    //                 'pengirim_sumber' => $request->pengirim_sumber,
    //                 'perihal_isi_deskripsi' => $request->perihal_isi_deskripsi,
    //                 'diinput_oleh' => Auth::user()->gocap_id_pc_pengurus,
    //                 'alamat_pengirim' => $request->alamat_pengirim,
    //                 'keterangan_surat_masuk' => $request->keterangan_surat_masuk,
    //                 'keterangan_surat_keluar' => $request->keterangan_surat_keluar,
    //             ]);

    //             // masukkan ke tabel disposisi dan sppd mwcnu

    //             if ($request->akses_satuan_upzis != NULL) {


    //                 $b = 0;
    //                 foreach ($request->akses_satuan_upzis as $index) {

    //                     $disposisi_id = uniqid();
    //                     $sppd_id = uniqid();
    //                     $dis = Disposisi::create([
    //                         'disposisi_id' => $disposisi_id,
    //                         'arsip_digital_id' => $arsip_digital_id,
    //                         'id_upzis' => $request->akses_satuan_upzis[$b],
    //                         'status_baca' => '0',
    //                         'sifat' => $request->sifat,
    //                         'perihal' => $request->perihal_disposisi,
    //                     ]);
    //                     if ($request->sppd_ya == 'on') {
    //                         Sppd::create([
    //                             'sppd_id' => $sppd_id,
    //                             'arsip_digital_id' => $arsip_digital_id,
    //                             'disposisi_id' => $disposisi_id,
    //                             'perihal' => $request->perihal_sppd,
    //                             'tgl_pelaksanaan' => $request->tgl_pelaksanaan,
    //                             'anggaran' => $anggaran,
    //                         ]);
    //                     }
    //                     $b++;
    //                 }
    //             }
    //             if ($request->akses_satuan_pc != NULL) {


    //                 $b = 0;
    //                 foreach ($request->akses_satuan_pc as $index) {

    //                     $disposisi_id = uniqid();
    //                     $sppd_id = uniqid();
    //                     Disposisi::create([
    //                         'disposisi_id' => $disposisi_id,
    //                         'arsip_digital_id' => $arsip_digital_id,
    //                         'id_pc' => $request->akses_satuan_pc[$b],
    //                         'status_baca' => '0',
    //                         'sifat' => $request->sifat,
    //                         'perihal' => $request->perihal_disposisi,
    //                     ]);
    //                     if ($request->sppd_ya == 'on') {
    //                         Sppd::create([
    //                             'sppd_id' => $sppd_id,
    //                             'arsip_digital_id' => $arsip_digital_id,
    //                             'disposisi_id' => $disposisi_id,
    //                             'perihal' => $request->perihal_sppd,
    //                             'tgl_pelaksanaan' => $request->tgl_pelaksanaan,
    //                             'anggaran' => $anggaran,
    //                         ]);
    //                     }
    //                     $b++;
    //                 }
    //             }
    //             if ($request->akses_satuan_ranting != NULL) {


    //                 $b = 0;
    //                 foreach ($request->akses_satuan_ranting as $index) {

    //                     $disposisi_id = uniqid();
    //                     $sppd_id = uniqid();
    //                     Disposisi::create([
    //                         'disposisi_id' => $disposisi_id,
    //                         'arsip_digital_id' => $arsip_digital_id,
    //                         'id_ranting' => $request->akses_satuan_ranting[$b],
    //                         'status_baca' => '0',
    //                         'sifat' => $request->sifat,
    //                         'perihal' => $request->perihal_disposisi,
    //                     ]);
    //                     if ($request->sppd_ya == 'on') {
    //                         Sppd::create([
    //                             'sppd_id' => $sppd_id,
    //                             'arsip_digital_id' => $arsip_digital_id,
    //                             'disposisi_id' => $disposisi_id,
    //                             'perihal' => $request->perihal_sppd,
    //                             'tgl_pelaksanaan' => $request->tgl_pelaksanaan,
    //                             'anggaran' => $anggaran,
    //                         ]);
    //                     }
    //                     $b++;
    //                 }
    //             }

    //             // masukkan ke tabel disposisi dan sppd lembaga

    //         } elseif ($request->penerima_golongan == 'on') {


    //             ArsipDigital::create([
    //                 'arsip_digital_id' => $arsip_digital_id,
    //                 'id_pengguna' => Auth::user()->id_pengguna,
    //                 'tanggal_arsip' => $request->tanggal_arsip,
    //                 'jenis_arsip' => 'Surat Masuk',
    //                 'jenis_disposisi' => 'Golongan',
    //                 'nomor_surat' => $request->nomor_surat,
    //                 'klasifikasi_surat' => $request->klasifikasi_surat,
    //                 'bentuk_surat' => $request->bentuk_surat,
    //                 'tujuan_surat' => $request->tujuan_surat,
    //                 'tujuan_arsip' => $request->tujuan_arsip,
    //                 'pengirim_sumber' => $request->pengirim_sumber,
    //                 'perihal_isi_deskripsi' => $request->perihal_isi_deskripsi,
    //                 'diinput_oleh' => Auth::user()->gocap_id_pc_pengurus,
    //                 'alamat_pengirim' => $request->alamat_pengirim,
    //                 'keterangan_surat_masuk' => $request->keterangan_surat_masuk,
    //                 'keterangan_surat_keluar' => $request->keterangan_surat_keluar,
    //             ]);



    //             if (Auth::user()->gocap_id_pc_pengurus != NULL) {
    //                 $upzis_all = Upzis::all()->pluck('id_upzis')->toArray();
    //             } elseif (Auth::user()->gocap_id_upzis_pengurus != NULL) {
    //                 $upzis_all = Upzis::all()->where('id_upzis', '!=', Auth::user()->UpzisPengurus->Upzis->id_upzis)->pluck('id_upzis')->toArray();
    //             }
    //             // masukkan ke tabel disposisi dan sppd 
    //             if ($upzis == '1') {
    //                 $b = 0;
    //                 foreach ($upzis_all as $index) {
    //                     $disposisi_id = uniqid();
    //                     $sppd_id = uniqid();
    //                     Disposisi::create([
    //                         'disposisi_id' => $disposisi_id,
    //                         'arsip_digital_id' => $arsip_digital_id,
    //                         'id_upzis' => $upzis_all[$b],
    //                         'status_baca' => '0',
    //                         'sifat' => $request->sifat,
    //                         'perihal' => $request->perihal_disposisi,
    //                     ]);
    //                     if ($request->sppd_ya == 'on') {
    //                         Sppd::create([
    //                             'sppd_id' => $sppd_id,
    //                             'arsip_digital_id' => $arsip_digital_id,
    //                             'disposisi_id' => $disposisi_id,
    //                             'perihal' => $request->perihal_sppd,
    //                             'tgl_pelaksanaan' => $request->tgl_pelaksanaan,
    //                             'anggaran' => $anggaran,
    //                         ]);
    //                     }
    //                     $b++;
    //                 }
    //             }

    //             if (Auth::user()->gocap_id_pc_pengurus != NULL) {
    //                 $ranting_all = Ranting::all()->pluck('id_ranting')->toArray();
    //             } elseif (Auth::user()->gocap_id_upzis_pengurus != NULL) {
    //                 $ranting_all = Ranting::all()->where('id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)->pluck('id_ranting')->toArray();
    //             }
    //             if ($ranting == '1') {
    //                 $b = 0;
    //                 foreach ($ranting_all as $index) {
    //                     $disposisi_id = uniqid();
    //                     $sppd_id = uniqid();
    //                     Disposisi::create([
    //                         'disposisi_id' => $disposisi_id,
    //                         'arsip_digital_id' => $arsip_digital_id,
    //                         'id_ranting' => $ranting_all[$b],
    //                         'status_baca' => '0',
    //                         'sifat' => $request->sifat,
    //                         'perihal' => $request->perihal_disposisi,
    //                     ]);
    //                     if ($request->sppd_ya == 'on') {
    //                         Sppd::create([
    //                             'sppd_id' => $sppd_id,
    //                             'arsip_digital_id' => $arsip_digital_id,
    //                             'disposisi_id' => $disposisi_id,
    //                             'perihal' => $request->perihal_sppd,
    //                             'tgl_pelaksanaan' => $request->tgl_pelaksanaan,
    //                             'anggaran' => $anggaran,
    //                         ]);
    //                     }
    //                     $b++;
    //                 }
    //             }

    //             if (Auth::user()->gocap_id_pc_pengurus != NULL) {
    //                 $internal_all = PcPengurus::all()->where('id_pc', Auth::user()->PcPengurus->id_pc)->pluck('id_pc_pengurus')->toArray();
    //             } elseif (Auth::user()->gocap_id_upzis_pengurus != NULL) {
    //                 $internal_all = UpzisPengurus::all()->where('id_upzis', Auth::user()->UpzisPengurus->id_upzis)->pluck('id_upzis_pengurus')->toArray();
    //             }
    //             // masukkan ke tabel disposisi 
    //             if ($internal == '1') {
    //                 $b = 0;
    //                 if (Auth::user()->gocap_id_pc_pengurus != NULL) {
    //                     foreach ($internal_all as $index) {
    //                         $disposisi_id = uniqid();
    //                         $sppd_id = uniqid();
    //                         Disposisi::create([
    //                             'disposisi_id' => $disposisi_id,
    //                             'arsip_digital_id' => $arsip_digital_id,
    //                             'id_pengurus_internal' => $internal_all[$b],
    //                             'status_baca' => '0',
    //                             'sifat' => $request->sifat,
    //                             'perihal' => $request->perihal_disposisi,
    //                         ]);
    //                         if ($request->sppd_ya == 'on') {
    //                             Sppd::create([
    //                                 'sppd_id' => $sppd_id,
    //                                 'arsip_digital_id' => $arsip_digital_id,
    //                                 'disposisi_id' => $disposisi_id,
    //                                 'perihal' => $request->perihal_sppd,
    //                                 'tgl_pelaksanaan' => $request->tgl_pelaksanaan,
    //                                 'anggaran' => $anggaran,
    //                             ]);
    //                         }
    //                         $b++;
    //                     }
    //                 } elseif (Auth::user()->gocap_id_upzis_pengurus != NULL) {
    //                     foreach ($internal_all as $index) {
    //                         $disposisi_id = uniqid();
    //                         $sppd_id = uniqid();
    //                         Disposisi::create([
    //                             'disposisi_id' => $disposisi_id,
    //                             'arsip_digital_id' => $arsip_digital_id,
    //                             'id_pengurus_internal' => $internal_all[$b],
    //                             'status_baca' => '0',
    //                             'sifat' => $request->sifat,
    //                             'perihal' => $request->perihal_disposisi,
    //                         ]);
    //                         if ($request->sppd_ya == 'on') {
    //                             Sppd::create([
    //                                 'sppd_id' => $sppd_id,
    //                                 'arsip_digital_id' => $arsip_digital_id,
    //                                 'disposisi_id' => $disposisi_id,
    //                                 'perihal' => $request->perihal_sppd,
    //                                 'tgl_pelaksanaan' => $request->tgl_pelaksanaan,
    //                                 'anggaran' => $anggaran,
    //                             ]);
    //                         }
    //                         $b++;
    //                     }
    //                 }
    //             }
    //         } elseif ($request->penerima_internal == 'on') {


    //             // masukkan ke tabel arsip_digital
    //             ArsipDigital::create([
    //                 'arsip_digital_id' => $arsip_digital_id,
    //                 'id_pengguna' => Auth::user()->id_pengguna,
    //                 'tanggal_arsip' => $request->tanggal_arsip,
    //                 'jenis_arsip' => 'Surat Masuk',
    //                 'jenis_disposisi' => 'Internal',
    //                 'nomor_surat' => $request->nomor_surat,
    //                 'klasifikasi_surat' => $request->klasifikasi_surat,
    //                 'bentuk_surat' => $request->bentuk_surat,
    //                 'tujuan_surat' => $request->tujuan_surat,
    //                 'tujuan_arsip' => $request->tujuan_arsip,
    //                 'pengirim_sumber' => $request->pengirim_sumber,
    //                 'perihal_isi_deskripsi' => $request->perihal_isi_deskripsi,
    //                 'isi_surat' => $request->isi_surat,
    //                 'diinput_oleh' => Auth::user()->gocap_id_pc_pengurus,
    //                 'alamat_pengirim' => $request->alamat_pengirim,
    //                 'keterangan_surat_masuk' => $request->keterangan_surat_masuk,
    //                 'keterangan_surat_keluar' => $request->keterangan_surat_keluar,
    //             ]);

    //             if (Auth::user()->gocap_id_pc_pengurus != null) {

    //                 // masukkan ke tabel internal dan sppd internal
    //                 if ($request->akses_internal != NULL) {
    //                     $b = 0;
    //                     foreach ($request->akses_internal as $index) {
    //                         $disposisi_id = uniqid();
    //                         $sppd_id = uniqid();
    //                         Disposisi::create([
    //                             'disposisi_id' => $disposisi_id,
    //                             'arsip_digital_id' => $arsip_digital_id,
    //                             'id_pengurus_internal' => $request->akses_internal[$b],
    //                             'status_baca' => '0',
    //                             'sifat' => $request->sifat,
    //                             'perihal' => $request->perihal_disposisi,
    //                         ]);
    //                         if ($request->sppd_ya == 'on') {
    //                             Sppd::create([
    //                                 'sppd_id' => $sppd_id,
    //                                 'arsip_digital_id' => $arsip_digital_id,
    //                                 'disposisi_id' => $disposisi_id,
    //                                 'perihal' => $request->perihal_sppd,
    //                                 'tgl_pelaksanaan' => $request->tgl_pelaksanaan,
    //                                 'anggaran' => $anggaran,
    //                             ]);
    //                         }
    //                         $b++;
    //                     }
    //                 }
    //             }
    //             if (Auth::user()->gocap_id_upzis_pengurus != null) {

    //                 // masukkan ke tabel internal dan sppd internal
    //                 if ($request->akses_internal != NULL) {
    //                     $b = 0;
    //                     foreach ($request->akses_internal as $index) {
    //                         $disposisi_id = uniqid();
    //                         $sppd_id = uniqid();
    //                         Disposisi::create([
    //                             'disposisi_id' => $disposisi_id,
    //                             'arsip_digital_id' => $arsip_digital_id,
    //                             'id_pengurus_internal' => $request->akses_internal[$b],
    //                             'status_baca' => '0',
    //                             'sifat' => $request->sifat,
    //                             'perihal' => $request->perihal_disposisi,
    //                         ]);
    //                         if ($request->sppd_ya == 'on') {
    //                             Sppd::create([
    //                                 'sppd_id' => $sppd_id,
    //                                 'arsip_digital_id' => $arsip_digital_id,
    //                                 'disposisi_id' => $disposisi_id,
    //                                 'perihal' => $request->perihal_sppd,
    //                                 'tgl_pelaksanaan' => $request->tgl_pelaksanaan,
    //                                 'anggaran' => $anggaran,
    //                             ]);
    //                         }
    //                         $b++;
    //                     }
    //                 }
    //             }
    //         }
    //     } elseif ($request->disposisi_tidak == 'on') {


    //         ArsipDigital::create([
    //             'arsip_digital_id' => $arsip_digital_id,
    //             'id_pengguna' => Auth::user()->id_pengguna,
    //             'tanggal_arsip' => $request->tanggal_arsip,
    //             'jenis_arsip' => 'Surat Masuk',
    //             'jenis_disposisi' => 'Tidak Ada',
    //             'nomor_surat' => $request->nomor_surat,
    //             'klasifikasi_surat' => $request->klasifikasi_surat,
    //             'bentuk_surat' => $request->bentuk_surat,
    //                 'tujuan_surat' => $request->tujuan_surat,
    //             'tujuan_arsip' => $request->tujuan_arsip,
    //             'pengirim_sumber' => $request->pengirim_sumber,
    //             'perihal_isi_deskripsi' => $request->perihal_isi_deskripsi,
    //             'diinput_oleh' => Auth::user()->gocap_id_pc_pengurus,
    //             'alamat_pengirim' => $request->alamat_pengirim,
    //             'keterangan_surat_masuk' => $request->keterangan_surat_masuk,
    //             'keterangan_surat_keluar' => $request->keterangan_surat_keluar,

    //         ]);
    //     }

    //     // $file = $request->file('scan_surat');
    //     // $ext_logo = $file->extension();
    //     // $filename_scan = $file->storeAs('/lampiran', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext_logo, ['disk' => 'lampiran']);
    //     // LampiranArsip::create([
    //     //     'lampiran_arsip_id' => uniqid(),
    //     //     'arsip_digital_id' => $arsip_digital_id,
    //     //     'nama' => $request->nama_surat,
    //     //     'jenis' => 'Scan Surat',
    //     //     'file' => $filename_scan,
    //     // ]);

    //     // if ($request->file != null &&  $request->nama) {
    //     //     if ($request->nama && count($request->nama) > 0) {
    //     //         $a = 0;
    //     //         foreach ($request->file('lampiran') as $index) {

    //     //             $file = $index;
    //     //             $ext_logo = $file->extension();

    //     //             $filename_lampiran = $file->storeAs('/lampiran', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext_logo, ['disk' => 'lampiran']);
    //     //             $validatedData['lampiran_arsip_id'] = uniqid();
    //     //             $validatedData['arsip_digital_id'] = $arsip_digital_id;
    //     //             $validatedData['nama'] = $request->nama[$a];
    //     //             $validatedData['jenis'] = 'Lampiran';
    //     //             $validatedData['file'] = $filename_lampiran;
    //     //             LampiranArsip::create($validatedData);

    //     //             $a++;
    //     //         }
    //     //     }
    //     // }

    //     if ($request->scan_surat != null && $request->nama_surat != null) {
    //         $file = $request->file('scan_surat');
    //         $ext_logo = $file->extension();
    //         $filename_scan = $file->storeAs('/lampiran', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext_logo, ['disk' => 'lampiran']);
    //         LampiranArsip::create([
    //             'lampiran_arsip_id' => uniqid(),
    //             'arsip_digital_id' => $arsip_digital_id,
    //             'nama' => $request->nama_surat,
    //             'jenis' => 'Scan Surat',
    //             'file' => $filename_scan,
    //         ]);

    //         if ($request->lampiran != null &&  $request->nama != null) {
    //             if ($request->nama && count($request->nama) > 0) {
    //                 $a = 0;
    //                 foreach ($request->file('lampiran') as $index) {

    //                     $file = $index;
    //                     $ext_logo = $file->extension();

    //                     $filename_lampiran = $file->storeAs('/lampiran', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext_logo, ['disk' => 'lampiran']);
    //                     $validatedData['lampiran_arsip_id'] = uniqid();
    //                     $validatedData['arsip_digital_id'] = $arsip_digital_id;
    //                     $validatedData['nama'] = $request->nama[$a];
    //                     $validatedData['jenis'] = 'Lampiran';
    //                     $validatedData['file'] = $filename_lampiran;
    //                     LampiranArsip::create($validatedData);

    //                     $a++;
    //                 }
    //             }
    //         }
    //     }


    //     $earsip = config('app.database_earsip');
    //     $siftnu = config('app.database_siftnu');
    //     $gocap = config('app.database_gocap');

    //     if (Auth::user()->gocap_id_pc_pengurus != null) {
    //         $cek = 'Lazisnu';
    //     } else {
    //         $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
    //         $cek = 'Upzis ' . $wilayah;
    //     }
    //     alert()->success('Surat Masuk ' . $cek . ' Berhasil Ditambahkan');

    //     if (Auth::user()->gocap_id_pc_pengurus != null) {
    //         return redirect('/' . $request->role . '/arsip/detail_surat_masuk/' . $arsip_digital_id . '/pc')->with('success', 'Data berhasil ditambahkan');
    //     } elseif (Auth::user()->gocap_id_upzis_pengurus != null) {
    //         return redirect('/' . $request->role . '/arsip/detail_surat_masuk/' . $arsip_digital_id . '/upzis')->with('success', 'Data berhasil ditambahkan');
    //     }
    // }

    public function preview_disposisi(Request $request)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $disposisi_ya = $request->disposisi_ya;
        $disposisi_tidak = $request->disposisi_tidak;
        $golongan = $request->akses_golongan;
        $internal = $request->akses_internal;

        $akses_satuan_upzis = $request->akses_satuan_upzis;
        $akses_satuan_pc = $request->akses_satuan_pc;
        $akses_satuan_ranting = $request->akses_satuan_ranting;
        $akses_catatan = $request->akses_catatan;


        $penerima_golongan = $request->penerima_golongan;
        $penerima_satuan = $request->penerima_satuan;
        $penerima_internal = $request->penerima_internal;

        if ($penerima_golongan == 'on') {
            if ($golongan != null) {
                if ($disposisi_ya == 'on') {


                    if (count(collect($golongan)) == 1) {

                        if ($golongan[0] == 'Semua Pengurus Internal') {

                            if (Auth::user()->gocap_id_pc_pengurus != NULL) {
                                $tabel_internal =  Pengguna::join($gocap . '.pc_pengurus', $gocap . '.pc_pengurus.id_pc_pengurus', '=', $siftnu . '.pengguna.gocap_id_pc_pengurus')
                                    ->where($gocap . '.pc_pengurus.id_pc', Auth::user()->PcPengurus->id_pc)
                                    ->get();
                            }
                            if (Auth::user()->gocap_id_upzis_pengurus != NULL) {
                                $tabel_internal =  Pengguna::join($gocap . '.upzis_pengurus', $gocap . '.upzis_pengurus.id_upzis_pengurus', '=', $siftnu . '.pengguna.gocap_id_upzis_pengurus')
                                    ->where($gocap . '.upzis_pengurus.id_upzis', Auth::user()->UpzisPengurus->id_upzis)
                                    ->get();
                            }

                            $tabel_upzis = null;
                            $tabel_ranting = null;
                        } elseif ($golongan[0] == 'Semua UPZIS MWCNU') {
                            $tabel_upzis =  Upzis::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.upzis.id_wilayah')
                                ->select($siftnu . '.wilayah.nama')->get();
                            $tabel_internal = null;
                            $tabel_ranting = null;
                        } elseif ($golongan[0] == 'Semua Ranting NU') {
                            if (Auth::user()->gocap_id_pc_pengurus != NULL) {
                                $tabel_ranting =  Ranting::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.ranting.id_wilayah')
                                    ->select($siftnu . '.wilayah.nama')->get();
                            }
                            if (Auth::user()->gocap_id_upzis_pengurus != NULL) {
                                $tabel_ranting =  Ranting::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.ranting.id_wilayah')
                                    ->join($gocap . '.upzis', $gocap . '.upzis.id_upzis', '=', $gocap . '.ranting.id_upzis')->where($gocap . '.upzis.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                                    ->get();
                            }

                            $tabel_internal = null;
                            $tabel_upzis = null;
                        }
                        $jumlah = 1;
                    }

                    if (count(collect($golongan)) == 2) {
                        if ($golongan[0] == 'Semua Pengurus Internal' && $golongan[1] == 'Semua UPZIS MWCNU') {
                            if (Auth::user()->gocap_id_pc_pengurus != NULL) {
                                $tabel_internal =  Pengguna::join($gocap . '.pc_pengurus', $gocap . '.pc_pengurus.id_pc_pengurus', '=', $siftnu . '.pengguna.gocap_id_pc_pengurus')
                                    ->where($gocap . '.pc_pengurus.id_pc', Auth::user()->PcPengurus->id_pc)
                                    ->get();
                            }
                            if (Auth::user()->gocap_id_upzis_pengurus != NULL) {
                                $tabel_internal =  Pengguna::join($gocap . '.upzis_pengurus', $gocap . '.upzis_pengurus.id_upzis_pengurus', '=', $siftnu . '.pengguna.gocap_id_upzis_pengurus')
                                    ->where($gocap . '.upzis_pengurus.id_upzis', Auth::user()->UpzisPengurus->id_upzis)
                                    ->get();
                            }

                            $tabel_upzis =  Upzis::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.upzis.id_wilayah')
                                ->select($siftnu . '.wilayah.nama')->get();
                            $tabel_ranting = null;
                        } elseif ($golongan[0] == 'Semua UPZIS MWCNU' && $golongan[1] == 'Semua Pengurus Internal') {
                            if (Auth::user()->gocap_id_pc_pengurus != NULL) {
                                $tabel_internal =  Pengguna::join($gocap . '.pc_pengurus', $gocap . '.pc_pengurus.id_pc_pengurus', '=', $siftnu . '.pengguna.gocap_id_pc_pengurus')
                                    ->where($gocap . '.pc_pengurus.id_pc', Auth::user()->PcPengurus->id_pc)
                                    ->get();
                            }
                            if (Auth::user()->gocap_id_upzis_pengurus != NULL) {
                                $tabel_internal =  Pengguna::join($gocap . '.upzis_pengurus', $gocap . '.upzis_pengurus.id_upzis_pengurus', '=', $siftnu . '.pengguna.gocap_id_upzis_pengurus')
                                    ->where($gocap . '.upzis_pengurus.id_upzis', Auth::user()->UpzisPengurus->id_upzis)
                                    ->get();
                            }
                            $tabel_upzis =  Upzis::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.upzis.id_wilayah')
                                ->select($siftnu . '.wilayah.nama')->get();
                            $tabel_ranting = null;
                        } elseif ($golongan[0] == 'Semua Pengurus Internal' && $golongan[1] == 'Semua Ranting NU') {
                            if (Auth::user()->gocap_id_pc_pengurus != NULL) {
                                $tabel_internal =  Pengguna::join($gocap . '.pc_pengurus', $gocap . '.pc_pengurus.id_pc_pengurus', '=', $siftnu . '.pengguna.gocap_id_pc_pengurus')
                                    ->where($gocap . '.pc_pengurus.id_pc', Auth::user()->PcPengurus->id_pc)
                                    ->get();
                            }
                            if (Auth::user()->gocap_id_upzis_pengurus != NULL) {
                                $tabel_internal =  Pengguna::join($gocap . '.upzis_pengurus', $gocap . '.upzis_pengurus.id_upzis_pengurus', '=', $siftnu . '.pengguna.gocap_id_upzis_pengurus')
                                    ->where($gocap . '.upzis_pengurus.id_upzis', Auth::user()->UpzisPengurus->id_upzis)
                                    ->get();
                            }
                            $tabel_upzis = null;
                            if (Auth::user()->gocap_id_pc_pengurus != NULL) {
                                $tabel_ranting =  Ranting::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.ranting.id_wilayah')
                                    ->select($siftnu . '.wilayah.nama')->get();
                            }
                            if (Auth::user()->gocap_id_upzis_pengurus != NULL) {
                                $tabel_ranting =  Ranting::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.ranting.id_wilayah')
                                    ->join($gocap . '.upzis', $gocap . '.upzis.id_upzis', '=', $gocap . '.ranting.id_upzis')->where($gocap . '.upzis.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                                    ->get();
                            }
                        } elseif ($golongan[0] == 'Semua Ranting NU' && $golongan[1] == 'Semua Pengurus Internal') {
                            if (Auth::user()->gocap_id_pc_pengurus != NULL) {
                                $tabel_internal =  Pengguna::join($gocap . '.pc_pengurus', $gocap . '.pc_pengurus.id_pc_pengurus', '=', $siftnu . '.pengguna.gocap_id_pc_pengurus')
                                    ->where($gocap . '.pc_pengurus.id_pc', Auth::user()->PcPengurus->id_pc)
                                    ->get();
                            }
                            if (Auth::user()->gocap_id_upzis_pengurus != NULL) {
                                $tabel_internal =  Pengguna::join($gocap . '.upzis_pengurus', $gocap . '.upzis_pengurus.id_upzis_pengurus', '=', $siftnu . '.pengguna.gocap_id_upzis_pengurus')
                                    ->where($gocap . '.upzis_pengurus.id_upzis', Auth::user()->UpzisPengurus->id_upzis)
                                    ->get();
                            }
                            $tabel_upzis = null;
                            if (Auth::user()->gocap_id_pc_pengurus != NULL) {
                                $tabel_ranting =  Ranting::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.ranting.id_wilayah')
                                    ->select($siftnu . '.wilayah.nama')->get();
                            }
                            if (Auth::user()->gocap_id_upzis_pengurus != NULL) {
                                $tabel_ranting =  Ranting::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.ranting.id_wilayah')
                                    ->join($gocap . '.upzis', $gocap . '.upzis.id_upzis', '=', $gocap . '.ranting.id_upzis')->where($gocap . '.upzis.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                                    ->get();
                            }
                        } elseif ($golongan[0] == 'Semua UPZIS MWCNU' && $golongan[1] == 'Semua Ranting NU') {
                            $tabel_internal = null;
                            $tabel_upzis =  Upzis::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.upzis.id_wilayah')
                                ->select($siftnu . '.wilayah.nama')->get();
                            if (Auth::user()->gocap_id_pc_pengurus != NULL) {
                                $tabel_ranting =  Ranting::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.ranting.id_wilayah')
                                    ->select($siftnu . '.wilayah.nama')->get();
                            }
                            if (Auth::user()->gocap_id_upzis_pengurus != NULL) {
                                $tabel_ranting =  Ranting::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.ranting.id_wilayah')
                                    ->join($gocap . '.upzis', $gocap . '.upzis.id_upzis', '=', $gocap . '.ranting.id_upzis')->where($gocap . '.upzis.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                                    ->get();
                            }
                        } elseif ($golongan[0] == 'Semua Ranting NU' && $golongan[1] == 'Semua UPZIS MWCNU') {
                            $tabel_internal = null;
                            $tabel_upzis =  Upzis::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.upzis.id_wilayah')
                                ->select($siftnu . '.wilayah.nama')->get();
                            if (Auth::user()->gocap_id_pc_pengurus != NULL) {
                                $tabel_ranting =  Ranting::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.ranting.id_wilayah')
                                    ->select($siftnu . '.wilayah.nama')->get();
                            }
                            if (Auth::user()->gocap_id_upzis_pengurus != NULL) {
                                $tabel_ranting =  Ranting::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.ranting.id_wilayah')
                                    ->join($gocap . '.upzis', $gocap . '.upzis.id_upzis', '=', $gocap . '.ranting.id_upzis')->where($gocap . '.upzis.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                                    ->get();
                            }
                        }
                        $jumlah = 2;
                    }

                    if (count(collect($golongan)) == 3) {
                        if (Auth::user()->gocap_id_pc_pengurus != NULL) {
                            $tabel_internal =  Pengguna::join($gocap . '.pc_pengurus', $gocap . '.pc_pengurus.id_pc_pengurus', '=', $siftnu . '.pengguna.gocap_id_pc_pengurus')
                                ->where($gocap . '.pc_pengurus.id_pc', Auth::user()->PcPengurus->id_pc)
                                ->get();
                        }
                        if (Auth::user()->gocap_id_upzis_pengurus != NULL) {
                            $tabel_internal =  Pengguna::join($gocap . '.upzis_pengurus', $gocap . '.upzis_pengurus.id_upzis_pengurus', '=', $siftnu . '.pengguna.gocap_id_upzis_pengurus')
                                ->where($gocap . '.upzis_pengurus.id_upzis', Auth::user()->UpzisPengurus->id_upzis)
                                ->get();
                        }
                        $tabel_upzis =  Upzis::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.upzis.id_wilayah')
                            ->select($siftnu . '.wilayah.nama')->get();
                        if (Auth::user()->gocap_id_pc_pengurus != NULL) {
                            $tabel_ranting =  Ranting::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.ranting.id_wilayah')
                                ->select($siftnu . '.wilayah.nama')->get();
                        }
                        if (Auth::user()->gocap_id_upzis_pengurus != NULL) {
                            $tabel_ranting =  Ranting::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.ranting.id_wilayah')
                                ->join($gocap . '.upzis', $gocap . '.upzis.id_upzis', '=', $gocap . '.ranting.id_upzis')->where($gocap . '.upzis.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                                ->get();
                        }
                        $jumlah = 3;
                    }
                } else {
                    $tabel_internal = null;
                    $tabel_upzis = null;
                    $tabel_ranting = null;
                }
            } else {
                $tabel_internal = null;
                $tabel_upzis = null;
                $tabel_ranting = null;
            }
        } else {
            $tabel_internal = null;
            $tabel_upzis = null;
            $tabel_ranting = null;
            $jumlah = null;
        }

        if ($penerima_satuan == 'on') {

            if ($disposisi_ya == 'on') {
                if ($akses_satuan_upzis != NULL) {
                    $disposisi_upzis = Upzis::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.upzis.id_wilayah')
                        ->whereIn($gocap . '.upzis.id_upzis', $akses_satuan_upzis)
                        ->select($siftnu . '.wilayah.nama')->get();
                } else {
                    $disposisi_upzis = null;
                }
                if ($akses_satuan_pc != NULL) {
                    $disposisi_pc = Pc::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.pc.id_wilayah')
                        ->whereIn($gocap . '.pc.id_pc', $akses_satuan_pc)
                        ->select($siftnu . '.wilayah.nama')->get();
                } else {
                    $disposisi_pc = null;
                }
                if ($akses_satuan_ranting != NULL) {
                    $disposisi_ranting = Ranting::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.ranting.id_wilayah')
                        ->whereIn($gocap . '.ranting.id_ranting', $akses_satuan_ranting)
                        ->select($siftnu . '.wilayah.nama')->get();
                } else {
                    $disposisi_ranting = null;
                }
                $disposisi = 'ada dispisisi';
            } else {
                $disposisi_upzis = null;
                $disposisi_pc = null;
                $disposisi_ranting = null;
                $jumlah = null;
                $disposisi = null;
            }
        } else {
            $disposisi_upzis = null;
            $disposisi_pc = null;
            $disposisi_ranting = null;
            $disposisi = null;
        }

        if ($penerima_internal == 'on') {

            if ($disposisi_ya == 'on') {
                if ($internal != NULL) {
                    if (Auth::user()->gocap_id_pc_pengurus != NULL) {
                        $disposisi_internal = Pengguna::join($gocap . '.pc_pengurus', $gocap . '.pc_pengurus.id_pc_pengurus', '=', $siftnu . '.pengguna.gocap_id_pc_pengurus')
                            ->wherein($gocap . '.pc_pengurus.id_pc_pengurus', $request->akses_internal)
                            ->get();
                    }
                    if (Auth::user()->gocap_id_upzis_pengurus != NULL) {
                        $disposisi_internal = Pengguna::join($gocap . '.upzis_pengurus', $gocap . '.upzis_pengurus.id_upzis_pengurus', '=', $siftnu . '.pengguna.gocap_id_upzis_pengurus')
                            ->wherein($gocap . '.upzis_pengurus.id_upzis_pengurus', $request->akses_internal)
                            ->get();
                    }
                } else {
                    $disposisi_internal = null;
                }
            } else {
                $disposisi_internal = null;
            }
        } else {
            $disposisi_internal = null;
        }



        if (Auth::user()->gocap_id_upzis_pengurus != NULL) {
            // jika upzsis
            $upzis = Pengguna::where('gocap_id_upzis_pengurus', Auth::user()->gocap_id_upzis_pengurus)->first();
            $nama = $upzis->nama;
            $alamat = $upzis->alamat;
            $nohp = $upzis->nohp;
        }

        if (Auth::user()->gocap_id_pc_pengurus != NULL) {
            // jika internal pc
            $pc = Pengguna::where('gocap_id_pc_pengurus', Auth::user()->gocap_id_pc_pengurus)->first();
            $nama = $pc->nama;
            $alamat = $pc->alamat;
            $nohp = $pc->nohp;
        }



        $tanggal_memo = $request->tanggal_memo;
        $nomor_memo = $request->nomor_memo;
        $tanggal_arsip = $request->tanggal_arsip;
        $page = 'preview_disposisi';
        $nomor_surat = $request->nomor_surat;
        $nama_dokumen = $request->nama_dokumen;

        $pdf = PDF::loadview(
            'arsip.print_disposisi_only',
            compact(
                'page',
                'disposisi_ya',
                'tanggal_memo',
                'nomor_memo',
                'nama_dokumen',
                'nama',
                'alamat',
                'nohp',
                'nomor_surat',
                'tanggal_arsip',
                'disposisi_tidak',
                'disposisi_upzis',
                'disposisi_pc',
                'disposisi_ranting',
                'disposisi_internal',
                'tabel_ranting',
                'tabel_upzis',
                'tabel_internal',
                'penerima_satuan',
                'penerima_golongan',
                'penerima_internal',
                'jumlah',

            )
        );
        return $pdf->stream();
    }

    public function print_disposisi($id)
    {

        $page = 'print_disposisi';
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        if (Auth::user()->gocap_id_upzis_pengurus != NULL) {
            // jika upzsis
            $upzis = Pengguna::where('gocap_id_upzis_pengurus', Auth::user()->gocap_id_upzis_pengurus)->first();
            $nama = $upzis->nama;
            $alamat = $upzis->alamat;
            $nohp = $upzis->nohp;
            $disposisi_internal =  Disposisi::join($siftnu . '.pengguna', $siftnu . '.pengguna.gocap_id_upzis_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->join($gocap . '.upzis_pengurus', $gocap . '.upzis_pengurus.id_upzis_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->where('disposisi.arsip_digital_id', '=', $id)->get();
        }

        if (Auth::user()->gocap_id_pc_pengurus != NULL) {
            // jika internal pc
            $pc = Pengguna::where('gocap_id_pc_pengurus', Auth::user()->gocap_id_pc_pengurus)->first();
            $nama = $pc->nama;
            $alamat = $pc->alamat;
            $nohp = $pc->nohp;
            $disposisi_internal =  Disposisi::join($siftnu . '.pengguna', $siftnu . '.pengguna.gocap_id_pc_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->join($gocap . '.pc_pengurus', $gocap . '.pc_pengurus.id_pc_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->where('disposisi.arsip_digital_id', '=', $id)->get();
        }



        $arsip = DB::table('arsip_digital')->where('arsip_digital_id', $id)->select('arsip_digital.*')->first();
        $nomor_surat = $arsip->nomor_surat;
        $tanggal_arsip = $arsip->tanggal_arsip;
        $perihal_isi_deskripsi = $arsip->perihal_isi_deskripsi;
        $isi_surat = $arsip->isi_surat;
        $tujuan_arsip = $arsip->tujuan_arsip;

        $disposisi_upzis =  Upzis::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.upzis.id_wilayah')
            ->join($earsip . '.disposisi', $earsip . '.disposisi.id_upzis', '=', $gocap . '.upzis.id_upzis')
            ->where('disposisi.arsip_digital_id', '=', $id)->get();

        $disposisi_ranting =  Ranting::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.ranting.id_wilayah')
            ->join($earsip . '.disposisi', $earsip . '.disposisi.id_ranting', '=', $gocap . '.ranting.id_ranting')
            ->where('disposisi.arsip_digital_id', '=', $id)->get();

        $disposisi_pc =  Pc::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.pc.id_wilayah')
            ->join($earsip . '.disposisi', $earsip . '.disposisi.id_pc', '=', $gocap . '.pc.id_pc')
            ->where('disposisi.arsip_digital_id', '=', $id)->get();



        //Arsip
        $tanggal_arsip = $arsip->tanggal_arsip;
        $nomor_surat = $arsip->nomor_surat;
        $nama_dokumen = $arsip->nama_dokumen;


        $pdf = PDF::loadview(
            'arsip.print_disposisi_only',

            compact(
                'page',
                'nama',
                'alamat',
                'nohp',
                'arsip',
                'nomor_surat',
                'tanggal_arsip',
                'perihal_isi_deskripsi',
                'isi_surat',
                'tujuan_arsip',
                'disposisi_ranting',
                'disposisi_upzis',
                'disposisi_pc',
                'id',
                'nama_dokumen',
                'disposisi_internal'
            )
        );
        return $pdf->stream();
    }

    public function print_disposisi_arsip_surat_masuk($id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $arsip_digital_id = $id;

        $title = 'ARSIP SURAT';
        $arsip = DB::table('arsip_digital')->where('arsip_digital_id', $id)->first();
        // dd($arsip);
        $page = "Detail Surat Masuk";
        $lampiran = DB::table('arsip_digital')->join('lampiran_arsip', 'arsip_digital.arsip_digital_id', '=', 'lampiran_arsip.arsip_digital_id')->where('arsip_digital.arsip_digital_id', $id)->get();
        $lampiran_file = DB::table('lampiran_arsip')
            ->join('arsip_digital', 'arsip_digital.arsip_digital_id', '=', 'lampiran_arsip.arsip_digital_id')
            ->where('arsip_digital.arsip_digital_id', $arsip->arsip_digital_id)
            ->count();
        $sppd = DB::table('sppd')
            ->join('arsip_digital', 'arsip_digital.arsip_digital_id', '=', 'sppd.arsip_digital_id')
            ->where('arsip_digital.arsip_digital_id', $arsip->arsip_digital_id)->select('sppd.*')
            ->first();
        // dd($sppd);

        $disposisi = DB::table('disposisi')
            ->join('arsip_digital', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
            ->where('arsip_digital.arsip_digital_id', $arsip->arsip_digital_id)
            ->first();
        // dd($disposisi);


        if (Auth::user()->gocap_id_pc_pengurus != NULL) {

            $baca_upzis =  Upzis::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.upzis.id_wilayah')
                ->join($earsip . '.disposisi', $earsip . '.disposisi.id_upzis', '=', $gocap . '.upzis.id_upzis')
                ->where('disposisi.arsip_digital_id', '=', $arsip_digital_id)
                ->select($siftnu . '.wilayah.nama', $earsip . '.disposisi.status_baca')->get();

            $baca_internal =  Disposisi::join($siftnu . '.pengguna', $siftnu . '.pengguna.gocap_id_pc_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->join($gocap . '.pc_pengurus', $gocap . '.pc_pengurus.id_pc_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->where('disposisi.arsip_digital_id', '=', $arsip_digital_id)
                ->select($siftnu . '.pengguna.nama', $earsip . '.disposisi.status_baca', $gocap . '.pc_pengurus.id_pengurus_jabatan')->get();

            $baca_pc =  Pc::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.pc.id_wilayah')
                ->join($earsip . '.disposisi', $earsip . '.disposisi.id_pc', '=', $gocap . '.pc.id_pc')
                ->where('disposisi.arsip_digital_id', '=', $arsip_digital_id)
                ->select($siftnu . '.wilayah.nama', $earsip . '.disposisi.status_baca')->get();
            // dd($baca_pc);

            $baca_ranting =  Ranting::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.ranting.id_wilayah')
                ->join($earsip . '.disposisi', $earsip . '.disposisi.id_ranting', '=', $gocap . '.ranting.id_ranting')
                ->where('disposisi.arsip_digital_id', '=', $arsip_digital_id)
                ->select($siftnu . '.wilayah.nama', $earsip . '.disposisi.status_baca')->get();
        }


        if (Auth::user()->gocap_id_upzis_pengurus != NULL) {


            $baca_upzis =  Upzis::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.upzis.id_wilayah')
                ->join($earsip . '.disposisi', $earsip . '.disposisi.id_upzis', '=', $gocap . '.upzis.id_upzis')
                ->where('disposisi.arsip_digital_id', '=', $arsip_digital_id)
                ->select($siftnu . '.wilayah.nama', $earsip . '.disposisi.status_baca')->get();

            $baca_pc =  Pc::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.pc.id_wilayah')
                ->join($earsip . '.disposisi', $earsip . '.disposisi.id_pc', '=', $gocap . '.pc.id_pc')
                ->where('disposisi.arsip_digital_id', '=', $arsip_digital_id)
                ->select($siftnu . '.wilayah.nama', $earsip . '.disposisi.status_baca')->get();

            $baca_ranting =  Ranting::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.ranting.id_wilayah')
                ->join($earsip . '.disposisi', $earsip . '.disposisi.id_ranting', '=', $gocap . '.ranting.id_ranting')
                ->where('disposisi.arsip_digital_id', '=', $arsip_digital_id)
                ->select($siftnu . '.wilayah.nama', $earsip . '.disposisi.status_baca')->get();

            $baca_internal =  Disposisi::join($siftnu . '.pengguna', $siftnu . '.pengguna.gocap_id_upzis_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->join($gocap . '.upzis_pengurus', $gocap . '.upzis_pengurus.id_upzis_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->where('disposisi.arsip_digital_id', '=', $arsip_digital_id)
                ->select($siftnu . '.pengguna.nama', $earsip . '.disposisi.status_baca', $gocap . '.upzis_pengurus.id_pengurus_jabatan')->get();
        }

        $jabatans = ['Direktur Eksekutif', 'Ketua Pengurus Harian', 'Divisi Program dan Administrasi Umum', 'Front Office'];
        $data_pengurus = [];
        foreach ($jabatans as $jabatan) {
            $result = DB::table($gocap . '.pengurus_jabatan')
                ->where('jabatan', $jabatan)
                ->join($gocap . '.pc_pengurus', $gocap . '.pc_pengurus.id_pengurus_jabatan', '=', $gocap . '.pengurus_jabatan.id_pengurus_jabatan')
                ->join($siftnu . '.pengguna', $siftnu . '.pengguna.gocap_id_pc_pengurus', '=', $gocap . '.pc_pengurus.id_pc_pengurus')
                ->select($siftnu . '.pengguna.*')
                ->first();

            $data_pengurus[$jabatan] = $result ? $result->nama : null;
        }

        $nama_direktur = $data_pengurus['Direktur Eksekutif'];
        $ketua = $data_pengurus['Ketua Pengurus Harian'];
        $nama_program = $data_pengurus['Divisi Program dan Administrasi Umum'];
        $fo = $data_pengurus['Front Office'];
        // dd($fo);
        $pdf = PDF::loadview(
            'arsip.print_disposisi_arsip_surat_masuk',

            compact('nama_direktur', 'ketua', 'nama_program', 'fo', 'baca_pc', 'baca_ranting', 'arsip', 'page', 'lampiran', 'arsip_digital_id',  'title', 'baca_upzis', 'baca_internal', 'disposisi')
        )->setPaper('a4', 'portrait');
        // return $pdf->stream('Lembar Disposisi Surat - '. $arsip->nomor_surat.'.pdf');
        // Simpan nama file untuk digunakan pada tampilan web
        $nama_file = 'Lembar Disposisi Surat - ' . $arsip->nomor_surat . '.pdf';

        // Menampilkan PDF pada web dengan nama file
        return $pdf->stream($nama_file);
    }

    public function print_disposisi_arsip_surat_keluar($id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $arsip_digital_id = $id;
        // dd($arsip_digital_id);

        $title = 'ARSIP SURAT';
        $arsip = DB::table('arsip_digital')->where('arsip_digital_id', $id)->first();
        // dd($arsip);
        $page = "Detail Surat Masuk";
        $lampiran = DB::table('arsip_digital')->join('lampiran_arsip', 'arsip_digital.arsip_digital_id', '=', 'lampiran_arsip.arsip_digital_id')->where('arsip_digital.arsip_digital_id', $id)->get();
        $lampiran_file = DB::table('lampiran_arsip')
            ->join('arsip_digital', 'arsip_digital.arsip_digital_id', '=', 'lampiran_arsip.arsip_digital_id')
            ->where('arsip_digital.arsip_digital_id', $arsip->arsip_digital_id)
            ->count();

        $nama_lampiran_file = DB::table('lampiran_arsip')
            ->join('arsip_digital', 'arsip_digital.arsip_digital_id', '=', 'lampiran_arsip.arsip_digital_id')
            ->where('arsip_digital.arsip_digital_id', $arsip->arsip_digital_id)
            ->first();

        $sppd = DB::table('sppd')
            ->join('arsip_digital', 'arsip_digital.arsip_digital_id', '=', 'sppd.arsip_digital_id')
            ->where('arsip_digital.arsip_digital_id', $arsip->arsip_digital_id)->select('sppd.*')
            ->first();
        // dd($sppd);

        $disposisi = DB::table('disposisi')
            ->join('arsip_digital', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
            ->where('arsip_digital.arsip_digital_id', $arsip->arsip_digital_id)
            ->first();
        // dd($disposisi);


        if (Auth::user()->gocap_id_pc_pengurus != NULL) {

            $baca_upzis =  Upzis::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.upzis.id_wilayah')
                ->join($earsip . '.disposisi', $earsip . '.disposisi.id_upzis', '=', $gocap . '.upzis.id_upzis')
                ->where('disposisi.arsip_digital_id', '=', $arsip_digital_id)
                ->select($siftnu . '.wilayah.nama', $earsip . '.disposisi.status_baca')->get();

            $baca_internal =  Disposisi::join($siftnu . '.pengguna', $siftnu . '.pengguna.gocap_id_pc_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->join($gocap . '.pc_pengurus', $gocap . '.pc_pengurus.id_pc_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->where('disposisi.arsip_digital_id', '=', $arsip_digital_id)
                ->select($siftnu . '.pengguna.nama', $earsip . '.disposisi.status_baca', $gocap . '.pc_pengurus.id_pengurus_jabatan')->get();

            $baca_pc =  Pc::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.pc.id_wilayah')
                ->join($earsip . '.disposisi', $earsip . '.disposisi.id_pc', '=', $gocap . '.pc.id_pc')
                ->where('disposisi.arsip_digital_id', '=', $arsip_digital_id)
                ->select($siftnu . '.wilayah.nama', $earsip . '.disposisi.status_baca')->get();
            // dd($baca_pc);

            $baca_ranting =  Ranting::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.ranting.id_wilayah')
                ->join($earsip . '.disposisi', $earsip . '.disposisi.id_ranting', '=', $gocap . '.ranting.id_ranting')
                ->where('disposisi.arsip_digital_id', '=', $arsip_digital_id)
                ->select($siftnu . '.wilayah.nama', $earsip . '.disposisi.status_baca')->get();
        }


        if (Auth::user()->gocap_id_upzis_pengurus != NULL) {


            $baca_upzis =  Upzis::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.upzis.id_wilayah')
                ->join($earsip . '.disposisi', $earsip . '.disposisi.id_upzis', '=', $gocap . '.upzis.id_upzis')
                ->where('disposisi.arsip_digital_id', '=', $arsip_digital_id)
                ->select($siftnu . '.wilayah.nama', $earsip . '.disposisi.status_baca')->get();

            $baca_pc =  Pc::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.pc.id_wilayah')
                ->join($earsip . '.disposisi', $earsip . '.disposisi.id_pc', '=', $gocap . '.pc.id_pc')
                ->where('disposisi.arsip_digital_id', '=', $arsip_digital_id)
                ->select($siftnu . '.wilayah.nama', $earsip . '.disposisi.status_baca')->get();

            $baca_ranting =  Ranting::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.ranting.id_wilayah')
                ->join($earsip . '.disposisi', $earsip . '.disposisi.id_ranting', '=', $gocap . '.ranting.id_ranting')
                ->where('disposisi.arsip_digital_id', '=', $arsip_digital_id)
                ->select($siftnu . '.wilayah.nama', $earsip . '.disposisi.status_baca')->get();

            $baca_internal =  Disposisi::join($siftnu . '.pengguna', $siftnu . '.pengguna.gocap_id_upzis_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->join($gocap . '.upzis_pengurus', $gocap . '.upzis_pengurus.id_upzis_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->where('disposisi.arsip_digital_id', '=', $arsip_digital_id)
                ->select($siftnu . '.pengguna.nama', $earsip . '.disposisi.status_baca', $gocap . '.upzis_pengurus.id_pengurus_jabatan')->get();
        }

        $jabatans = ['Direktur Eksekutif', 'Ketua Pengurus Harian', 'Divisi Program dan Administrasi Umum', 'Front Office'];
        $data_pengurus = [];
        foreach ($jabatans as $jabatan) {
            $result = DB::table($gocap . '.pengurus_jabatan')
                ->where('jabatan', $jabatan)
                ->join($gocap . '.pc_pengurus', $gocap . '.pc_pengurus.id_pengurus_jabatan', '=', $gocap . '.pengurus_jabatan.id_pengurus_jabatan')
                ->join($siftnu . '.pengguna', $siftnu . '.pengguna.gocap_id_pc_pengurus', '=', $gocap . '.pc_pengurus.id_pc_pengurus')
                ->select($siftnu . '.pengguna.*')
                ->first();

            $data_pengurus[$jabatan] = $result ? $result->nama : null;
        }

        $nama_direktur = $data_pengurus['Direktur Eksekutif'];
        $ketua = $data_pengurus['Ketua Pengurus Harian'];
        $nama_program = $data_pengurus['Divisi Program dan Administrasi Umum'];
        $fo = $data_pengurus['Front Office'];
        // dd($fo);
        $pdf = PDF::loadview(
            'arsip.print_disposisi_arsip_surat_keluar',

            compact('nama_direktur', 'ketua', 'nama_program', 'fo', 'baca_pc', 'baca_ranting', 'arsip', 'page', 'lampiran', 'id_arsip',  'title', 'baca_upzis', 'baca_internal', 'disposisi')
        )->setPaper('a4', 'portrait');
        // return $pdf->stream('Lembar Disposisi Surat - '. $arsip->nomor_surat.'.pdf');
        // Simpan nama file untuk digunakan pada tampilan web
        $nama_file = 'Lembar Disposisi Surat - ' . $arsip->nomor_surat . '.pdf';

        // Menampilkan PDF pada web dengan nama file
        return $pdf->stream($nama_file);
    }

    public function print_surat($id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        if (Auth::user()->gocap_id_upzis_pengurus != NULL) {
            // jika upzsis
            $upzis = Pengguna::where('gocap_id_upzis_pengurus', Auth::user()->gocap_id_upzis_pengurus)->first();
            $nama = $upzis->nama;
            $alamat = $upzis->alamat;
            $nohp = $upzis->nohp;
            $disposisi_internal =  Disposisi::join($siftnu . '.pengguna', $siftnu . '.pengguna.gocap_id_upzis_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->join($gocap . '.upzis_pengurus', $gocap . '.upzis_pengurus.id_upzis_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->where('disposisi.arsip_digital_id', '=', $id)->get();
        }

        if (Auth::user()->gocap_id_pc_pengurus != NULL) {
            // jika internal pc
            $pc = Pengguna::where('gocap_id_pc_pengurus', Auth::user()->gocap_id_pc_pengurus)->first();
            $nama = $pc->nama;
            $alamat = $pc->alamat;
            $nohp = $pc->nohp;
            $disposisi_internal =  Disposisi::join($siftnu . '.pengguna', $siftnu . '.pengguna.gocap_id_pc_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->join($gocap . '.pc_pengurus', $gocap . '.pc_pengurus.id_pc_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->where('disposisi.arsip_digital_id', '=', $id)->get();
        }

        $disposisi_upzis =  Upzis::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.upzis.id_wilayah')
            ->join($earsip . '.disposisi', $earsip . '.disposisi.id_upzis', '=', $gocap . '.upzis.id_upzis')
            ->where('disposisi.arsip_digital_id', '=', $id)->get();

        $disposisi_ranting =  Ranting::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.ranting.id_wilayah')
            ->join($earsip . '.disposisi', $earsip . '.disposisi.id_ranting', '=', $gocap . '.ranting.id_ranting')
            ->where('disposisi.arsip_digital_id', '=', $id)->get();

        $disposisi_pc =  Pc::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.pc.id_wilayah')
            ->join($earsip . '.disposisi', $earsip . '.disposisi.id_pc', '=', $gocap . '.pc.id_pc')
            ->where('disposisi.arsip_digital_id', '=', $id)->get();


        $tb_penerima_surat = PenerimaSurat::where('arsip_digital_id', $id)->get();
        $arsip = DB::table('arsip_digital')->where('arsip_digital_id', $id)->first();
        $pengguna = Pengguna::where('id_pengguna', $arsip->id_pengguna)->first();
        $a = PcPengurus::where('id_pc_pengurus', $pengguna->gocap_id_pc_pengurus)->first();
        $lampiran = DB::table('arsip_digital')->join('lampiran_arsip', 'arsip_digital.arsip_digital_id', '=', 'lampiran_arsip.arsip_digital_id')->where('arsip_digital.arsip_digital_id', $id)->get();
        $lampiran_file = DB::table('lampiran_arsip')
            ->join('arsip_digital', 'arsip_digital.arsip_digital_id', '=', 'lampiran_arsip.arsip_digital_id')
            ->where('arsip_digital.arsip_digital_id', $arsip->arsip_digital_id)
            ->count();

        $join_ketua = PcPengurus::join($gocap . '.pengurus_jabatan', $gocap . '.pengurus_jabatan.id_pengurus_jabatan', '=', $gocap . '.pc_pengurus.id_pengurus_jabatan')
            ->where('jabatan', 'Ketua Pengurus Harian')
            ->where('pc_pengurus.id_pc', $a->id_pc)
            ->where($gocap . '.pc_pengurus.tanggal_selesai_jabatan', '>=', date('Y-m-d'))
            ->where($gocap . '.pc_pengurus.tanggal_mulai_jabatan', '<=', date('Y-m-d'))
            ->first();


        $join_sekretaris = PcPengurus::join($gocap . '.pengurus_jabatan', $gocap . '.pengurus_jabatan.id_pengurus_jabatan', '=', $gocap . '.pc_pengurus.id_pengurus_jabatan')
            ->where('jabatan', 'Sekretaris')->where('pc_pengurus.id_pc', $a->id_pc)
            ->where($gocap . '.pc_pengurus.tanggal_selesai_jabatan', '>=', date('Y-m-d'))
            ->where($gocap . '.pc_pengurus.tanggal_mulai_jabatan', '<=', date('Y-m-d'))
            ->first();

        if ($join_ketua != null && $join_sekretaris == null) {
            $nama_ketua = Pengguna::where('gocap_id_pc_pengurus', $join_ketua->id_pc_pengurus)->first();
            $nama_sekretaris = '';
            $pdf = PDF::loadview(
                'arsip.print_surat',
                compact('arsip', 'disposisi_internal', 'disposisi_upzis', 'disposisi_pc', 'disposisi_ranting', 'tb_penerima_surat', 'lampiran_file', 'nama_ketua', 'nama_sekretaris')
            )->setPaper('a4', 'portrait');
            return $pdf->stream();
        }

        if ($join_sekretaris != null && $join_ketua == null) {
            $nama_sekretaris = Pengguna::where('gocap_id_pc_pengurus', $join_sekretaris->id_pc_pengurus)->first();
            $nama_ketua = '';
            $pdf = PDF::loadview(
                'arsip.print_surat',
                compact('arsip', 'disposisi_internal', 'disposisi_upzis', 'disposisi_pc', 'disposisi_ranting', 'tb_penerima_surat', 'lampiran_file', 'nama_ketua', 'nama_sekretaris')
            )->setPaper('a4', 'portrait');
            return $pdf->stream();
        }

        if ($join_sekretaris && $join_ketua) {
            $nama_ketua = Pengguna::where('gocap_id_pc_pengurus', $join_ketua->id_pc_pengurus)->first();
            $nama_sekretaris = Pengguna::where('gocap_id_pc_pengurus', $join_sekretaris->id_pc_pengurus)->first();
            $pdf = PDF::loadview(
                'arsip.print_surat',
                compact('arsip', 'disposisi_internal', 'disposisi_upzis', 'disposisi_pc', 'disposisi_ranting', 'tb_penerima_surat', 'lampiran_file', 'nama_ketua', 'nama_sekretaris')
            )->setPaper('a4', 'portrait');
            return $pdf->stream();
        }

        if ($join_sekretaris == null && $join_ketua == null) {
            $nama_ketua = '';
            $nama_sekretaris = '';
            $pdf = PDF::loadview(
                'arsip.print_surat',
                compact('arsip', 'disposisi_internal', 'disposisi_upzis', 'disposisi_pc', 'disposisi_ranting', 'tb_penerima_surat', 'lampiran_file', 'nama_ketua', 'nama_sekretaris')
            )->setPaper('a4', 'portrait');

            return $pdf->stream()->withHeaders([
                'Title' => 'Your meta title',
                'Content-Type' => 'application/pdf',
                'Cache-Control' => 'no-store, no-cache',
                'Content-Disposition' => 'filename="' . $arsip->nomor_surat . '.pdf',
            ]);
        }
    }

    public function print_surat_upzis($id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');


        if (Auth::user()->gocap_id_upzis_pengurus != NULL) {
            // jika upzsis
            $upzis = Pengguna::where('gocap_id_upzis_pengurus', Auth::user()->gocap_id_upzis_pengurus)->first();
            $nama = $upzis->nama;
            $alamat = $upzis->alamat;
            $nohp = $upzis->nohp;
            $disposisi_internal =  Disposisi::join($siftnu . '.pengguna', $siftnu . '.pengguna.gocap_id_upzis_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->join($gocap . '.upzis_pengurus', $gocap . '.upzis_pengurus.id_upzis_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->where('disposisi.arsip_digital_id', '=', $id)->get();
        }

        if (Auth::user()->gocap_id_pc_pengurus != NULL) {
            // jika internal pc
            $pc = Pengguna::where('gocap_id_pc_pengurus', Auth::user()->gocap_id_pc_pengurus)->first();
            $nama = $pc->nama;
            $alamat = $pc->alamat;
            $nohp = $pc->nohp;
            $disposisi_internal =  Disposisi::join($siftnu . '.pengguna', $siftnu . '.pengguna.gocap_id_pc_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->join($gocap . '.pc_pengurus', $gocap . '.pc_pengurus.id_pc_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->where('disposisi.arsip_digital_id', '=', $id)->get();
        }

        $tb_penerima_surat = PenerimaSurat::where('arsip_digital_id', $id)->get();
        $disposisi_upzis =  Upzis::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.upzis.id_wilayah')
            ->join($earsip . '.disposisi', $earsip . '.disposisi.id_upzis', '=', $gocap . '.upzis.id_upzis')
            ->where('disposisi.arsip_digital_id', '=', $id)->get();

        $disposisi_ranting =  Ranting::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.ranting.id_wilayah')
            ->join($earsip . '.disposisi', $earsip . '.disposisi.id_ranting', '=', $gocap . '.ranting.id_ranting')
            ->where('disposisi.arsip_digital_id', '=', $id)->get();

        $disposisi_pc =  Pc::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.pc.id_wilayah')
            ->join($earsip . '.disposisi', $earsip . '.disposisi.id_pc', '=', $gocap . '.pc.id_pc')
            ->where('disposisi.arsip_digital_id', '=', $id)->get();


        $arsip = DB::table('arsip_digital')->where('arsip_digital_id', $id)->first();
        $pembuat = Pengguna::where('id_pengguna', $arsip->id_pengguna)->first();
        $pengguna = Pengguna::where('id_pengguna', $arsip->id_pengguna)->first();
        $upzis = UpzisPengurus::where('id_upzis_pengurus', $pengguna->gocap_id_upzis_pengurus)->first();
        $wilayah = Upzis::where('id_upzis', $upzis->id_upzis)->first();
        $nama_wilayah = Wilayah::where('id_wilayah', $wilayah->id_wilayah)->first();
        $a = UpzisPengurus::where('id_upzis_pengurus', $pengguna->gocap_id_upzis_pengurus)->first();
        $lampiran = DB::table('arsip_digital')->join('lampiran_arsip', 'arsip_digital.arsip_digital_id', '=', 'lampiran_arsip.arsip_digital_id')->where('arsip_digital.arsip_digital_id', $id)->get();
        $lampiran_file = DB::table('lampiran_arsip')
            ->join('arsip_digital', 'arsip_digital.arsip_digital_id', '=', 'lampiran_arsip.arsip_digital_id')
            ->where('arsip_digital.arsip_digital_id', $arsip->arsip_digital_id)
            ->count();

        $join_ketua = UpzisPengurus::join($gocap . '.pengurus_jabatan', $gocap . '.pengurus_jabatan.id_pengurus_jabatan', '=', $gocap . '.upzis_pengurus.id_pengurus_jabatan')
            ->where('jabatan', 'Ketua')
            ->where('upzis_pengurus.id_upzis', $a->id_upzis)
            ->where($gocap . '.upzis_pengurus.tanggal_selesai_jabatan', '>=', date('Y-m-d'))
            ->where($gocap . '.upzis_pengurus.tanggal_mulai_jabatan', '<=', date('Y-m-d'))
            ->first();


        $join_sekretaris = UpzisPengurus::join($gocap . '.pengurus_jabatan', $gocap . '.pengurus_jabatan.id_pengurus_jabatan', '=', $gocap . '.upzis_pengurus.id_pengurus_jabatan')
            ->where('jabatan', 'Sekretaris')->where('upzis_pengurus.id_upzis', $a->id_upzis)
            ->where($gocap . '.upzis_pengurus.tanggal_selesai_jabatan', '>=', date('Y-m-d'))
            ->where($gocap . '.upzis_pengurus.tanggal_mulai_jabatan', '<=', date('Y-m-d'))
            ->first();

        if ($join_ketua != null && $join_sekretaris == null) {
            $nama_ketua = Pengguna::where('gocap_id_upzis_pengurus', $join_ketua->id_upzis_pengurus)->first();
            $nama_sekretaris = '';
            $pdf = PDF::loadview(
                'arsip.print_surat_upzis',
                compact('nama_wilayah', 'pembuat', 'arsip', 'disposisi_internal', 'disposisi_upzis', 'disposisi_pc', 'disposisi_ranting', 'tb_penerima_surat', 'lampiran_file', 'nama_ketua', 'nama_sekretaris')
            )->setPaper('a4', 'portrait');
            return $pdf->stream();
        }

        if ($join_sekretaris != null && $join_ketua == null) {
            $nama_sekretaris = Pengguna::where('gocap_id_upzis_pengurus', $join_sekretaris->id_upzis_pengurus)->first();
            $nama_ketua = '';
            $pdf = PDF::loadview(
                'arsip.print_surat_upzis',
                compact('nama_wilayah', 'pembuat', 'arsip', 'disposisi_internal', 'disposisi_upzis', 'disposisi_pc', 'disposisi_ranting', 'tb_penerima_surat', 'lampiran_file', 'nama_ketua', 'nama_sekretaris')
            )->setPaper('a4', 'portrait');
            return $pdf->stream();
        }

        if ($join_sekretaris && $join_ketua) {
            $nama_ketua = Pengguna::where('gocap_id_upzis_pengurus', $join_ketua->id_upzis_pengurus)->first();
            $nama_sekretaris = Pengguna::where('gocap_id_upzis_pengurus', $join_sekretaris->id_upzis_pengurus)->first();
            $pdf = PDF::loadview(
                'arsip.print_surat_upzis',
                compact('nama_wilayah', 'pembuat', 'arsip', 'disposisi_internal', 'disposisi_upzis', 'disposisi_pc', 'disposisi_ranting', 'tb_penerima_surat', 'lampiran_file', 'nama_ketua', 'nama_sekretaris')
            )->setPaper('a4', 'portrait');
            return $pdf->stream();
        }

        if ($join_sekretaris == null && $join_ketua == null) {
            $nama_ketua = '';
            $nama_sekretaris = '';
            $pdf = PDF::loadview(
                'arsip.print_surat_upzis',
                compact('nama_wilayah', 'pembuat', 'arsip', 'disposisi_internal', 'disposisi_upzis', 'disposisi_pc', 'disposisi_ranting', 'tb_penerima_surat', 'lampiran_file', 'nama_ketua', 'nama_sekretaris')
            )->setPaper('a4', 'portrait');

            return $pdf->stream()->withHeaders([
                'Title' => 'Your meta title',
                'Content-Type' => 'application/pdf',
                'Cache-Control' => 'no-store, no-cache',
                'Content-Disposition' => 'filename="' . $arsip->nomor_surat . '.pdf',
            ]);;
        }
    }

    public function aksi_tambah_surat_keluar(Request $request)
    {

        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $anggaran = str_replace('.', '',  $request->anggaran);


        if (Auth::user()->gocap_id_pc_pengurus != null) {
            // invalid untuk disposisi ya -> penerima satuan -> sppd ya
            if ($request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_ya == 'on' && $request->akses_satuan_upzis == null && $request->akses_satuan_ranting == null) {
                $request->validate([
                    // surat masuk
                    'tanggal_arsip' => 'required',
                    'nomor_surat' => 'required',
                    'klasifikasi_surat' => 'required',
                    'tujuan_arsip' => 'required',
                    'pengirim_sumber' => 'required',
                    'perihal_isi_deskripsi' => 'required',
                    'akses_penerima_surat' => 'required',
                    // disposisi
                    'sifat' => 'required',
                    'perihal_disposisi' => 'required',
                    // sppd
                    'tgl_perintah' => 'required',
                    'tgl_pelaksanaan' => 'required',
                    'anggaran' => 'required',
                    'perihal_sppd' => 'required',

                    'akses_satuan_upzis' => 'required',
                    'akses_satuan_ranting' => 'required',
                ], [
                    'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
                    'nomor_surat.required' => 'Nomor Surat harus diisi',
                    'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                    'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
                    'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                    'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',
                    'akses_penerima_surat.required' => 'Akses Ketua Upzis harus diisi',

                    'sifat.required' => 'Sifat harus diisi',
                    'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',

                    'tgl_perintah.required' => 'Tanggal Perintah harus diisi',
                    'tgl_pelaksanaan.required' => 'Tanggal Pelaksanaan harus diisi',
                    'anggaran.required' => 'Anggaran harus diisi',
                    'perihal_sppd.required' => 'Perihal Sppd harus diisi',

                    'akses_satuan_upzis.required' => 'salah satu akses satuan harus diisi',
                    'akses_satuan_ranting.required' => 'salah satu akses satuan harus diisi',

                ]);
            }

            if (
                $request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_ya == 'on' && $request->akses_satuan_upzis != null ||
                $request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_ya == 'on' &&  $request->akses_satuan_ranting != null
            ) {
                $request->validate([
                    // surat masuk
                    'tanggal_arsip' => 'required',
                    'nomor_surat' => 'required',
                    'klasifikasi_surat' => 'required',
                    'tujuan_arsip' => 'required',
                    'pengirim_sumber' => 'required',
                    'perihal_isi_deskripsi' => 'required',
                    'akses_penerima_surat' => 'required',
                    // disposisi
                    'sifat' => 'required',
                    'perihal_disposisi' => 'required',
                    // sppd
                    'tgl_perintah' => 'required',
                    'tgl_pelaksanaan' => 'required',
                    'anggaran' => 'required',
                    'perihal_sppd' => 'required',


                ], [
                    'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
                    'nomor_surat.required' => 'Nomor Surat harus diisi',
                    'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                    'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
                    'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                    'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',
                    'akses_penerima_surat.required' => 'Akses Ketua Upzis harus diisi',

                    'sifat.required' => 'Sifat harus diisi',
                    'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',

                    'tgl_perintah.required' => 'Tanggal Perintah harus diisi',
                    'tgl_pelaksanaan.required' => 'Tanggal Pelaksanaan harus diisi',
                    'anggaran.required' => 'Anggaran harus diisi',
                    'perihal_sppd.required' => 'Perihal Sppd harus diisi',


                ]);
            }

            // invalid untuk disposisi ya -> penerima satuan -> sppd tidak
            if (
                $request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_tidak == 'on' && $request->akses_satuan_upzis != null ||
                $request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_tidak == 'on' &&  $request->akses_satuan_ranting != null
            ) {
                $request->validate([
                    // surat masuk
                    'tanggal_arsip' => 'required',
                    'nomor_surat' => 'required',
                    'klasifikasi_surat' => 'required',
                    'tujuan_arsip' => 'required',
                    'pengirim_sumber' => 'required',
                    'perihal_isi_deskripsi' => 'required',
                    'akses_penerima_surat' => 'required',
                    // disposisi
                    'sifat' => 'required',
                    'perihal_disposisi' => 'required',


                ], [
                    'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
                    'nomor_surat.required' => 'Nomor Surat harus diisi',
                    'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                    'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
                    'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                    'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',
                    'akses_penerima_surat.required' => 'Akses Ketua Upzis harus diisi',

                    'sifat.required' => 'Sifat harus diisi',
                    'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',


                ]);
            }

            // invalid untuk disposisi ya -> penerima satuan -> sppd tidak
            if ($request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_tidak == 'on' && $request->akses_satuan_upzis == null && $request->akses_satuan_ranting == null) {

                $request->validate([
                    // surat masuk
                    'tanggal_arsip' => 'required',
                    'nomor_surat' => 'required',
                    'klasifikasi_surat' => 'required',
                    'tujuan_arsip' => 'required',
                    'pengirim_sumber' => 'required',
                    'perihal_isi_deskripsi' => 'required',
                    'akses_penerima_surat' => 'required',
                    // disposisi
                    'sifat' => 'required',
                    'perihal_disposisi' => 'required',

                    'akses_satuan_upzis' => 'required',
                    'akses_satuan_ranting' => 'required',



                ], [
                    'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
                    'nomor_surat.required' => 'Nomor Surat harus diisi',
                    'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                    'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
                    'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                    'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',
                    'akses_penerima_surat.required' => 'Akses Ketua Upzis harus diisi',

                    'sifat.required' => 'Sifat harus diisi',
                    'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',

                    'akses_satuan_upzis.required' => 'salah satu akses satuan harus diisi',
                    'akses_satuan_ranting.required' => 'salah satu akses satuan harus diisi',


                ]);
            }
        }

        if (Auth::user()->gocap_id_upzis_pengurus != null) {
            // invalid untuk disposisi ya -> penerima satuan -> sppd ya
            if ($request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_ya == 'on' && $request->akses_satuan_upzis == null && $request->akses_satuan_ranting == null && $request->akses_satuan_pc == null) {
                $request->validate([
                    // surat masuk
                    'tanggal_arsip' => 'required',
                    'nomor_surat' => 'required',
                    'klasifikasi_surat' => 'required',
                    'tujuan_arsip' => 'required',
                    'pengirim_sumber' => 'required',
                    'perihal_isi_deskripsi' => 'required',
                    'akses_penerima_surat' => 'required',
                    // disposisi
                    'sifat' => 'required',
                    'perihal_disposisi' => 'required',
                    // sppd
                    'tgl_perintah' => 'required',
                    'tgl_pelaksanaan' => 'required',
                    'anggaran' => 'required',
                    'perihal_sppd' => 'required',

                    'akses_satuan_upzis' => 'required',
                    'akses_satuan_ranting' => 'required',
                    'akses_satuan_pc' => 'required',


                ], [
                    'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
                    'nomor_surat.required' => 'Nomor Surat harus diisi',
                    'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                    'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
                    'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                    'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',
                    'akses_penerima_surat.required' => 'Akses Ketua Upzis harus diisi',

                    'akses_satuan.required' => 'Akses Satuan harus diisi',
                    'sifat.required' => 'Sifat harus diisi',
                    'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',

                    'tgl_perintah.required' => 'Tanggal Perintah harus diisi',
                    'tgl_pelaksanaan.required' => 'Tanggal Pelaksanaan harus diisi',
                    'anggaran.required' => 'Anggaran harus diisi',
                    'perihal_sppd.required' => 'Perihal Sppd harus diisi',

                    'akses_satuan_upzis.required' => 'salah satu akses satuan harus diisi',
                    'akses_satuan_ranting.required' => 'salah satu akses satuan harus diisi',
                    'akses_satuan_pc.required' => 'salah satu akses satuan harus diisi',


                ]);
            }

            if (
                $request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_ya == 'on' && $request->akses_satuan_upzis != null ||
                $request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_ya == 'on' &&  $request->akses_satuan_ranting != null ||
                $request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_ya == 'on' && $request->akses_satuan_pc != null
            ) {
                $request->validate([
                    // surat masuk
                    'tanggal_arsip' => 'required',
                    'nomor_surat' => 'required',
                    'klasifikasi_surat' => 'required',
                    'tujuan_arsip' => 'required',
                    'pengirim_sumber' => 'required',
                    'perihal_isi_deskripsi' => 'required',
                    'akses_penerima_surat' => 'required',
                    // disposisi
                    'sifat' => 'required',
                    'perihal_disposisi' => 'required',
                    // sppd
                    'tgl_perintah' => 'required',
                    'tgl_pelaksanaan' => 'required',
                    'anggaran' => 'required',
                    'perihal_sppd' => 'required',




                ], [
                    'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
                    'nomor_surat.required' => 'Nomor Surat harus diisi',
                    'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                    'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
                    'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                    'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',
                    'akses_penerima_surat.required' => 'Akses Ketua Upzis harus diisi',

                    'akses_satuan.required' => 'Akses Satuan harus diisi',
                    'sifat.required' => 'Sifat harus diisi',
                    'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',

                    'tgl_perintah.required' => 'Tanggal Perintah harus diisi',
                    'tgl_pelaksanaan.required' => 'Tanggal Pelaksanaan harus diisi',
                    'anggaran.required' => 'Anggaran harus diisi',
                    'perihal_sppd.required' => 'Perihal Sppd harus diisi',



                ]);
            }

            // invalid untuk disposisi ya -> penerima satuan -> sppd tidak
            if (
                $request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_tidak == 'on' && $request->akses_satuan_upzis != null ||
                $request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_tidak == 'on' && $request->akses_satuan_ranting != null ||
                $request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_tidak == 'on' && $request->akses_satuan_pc != null
            ) {
                $request->validate([
                    // surat masuk
                    'tanggal_arsip' => 'required',
                    'nomor_surat' => 'required',
                    'klasifikasi_surat' => 'required',
                    'tujuan_arsip' => 'required',
                    'pengirim_sumber' => 'required',
                    'perihal_isi_deskripsi' => 'required',
                    'akses_penerima_surat' => 'required',
                    // disposisi
                    'sifat' => 'required',
                    'perihal_disposisi' => 'required',



                ], [
                    'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
                    'nomor_surat.required' => 'Nomor Surat harus diisi',
                    'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                    'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
                    'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                    'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',
                    'akses_penerima_surat.required' => 'Akses Ketua Upzis harus diisi',

                    'sifat.required' => 'Sifat harus diisi',
                    'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',


                ]);
            }

            // invalid untuk disposisi ya -> penerima satuan -> sppd tidak
            if ($request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_tidak == 'on' && $request->akses_satuan_upzis == null && $request->akses_satuan_ranting == null && $request->akses_satuan_pc == null) {

                $request->validate([
                    // surat masuk
                    'tanggal_arsip' => 'required',
                    'nomor_surat' => 'required',
                    'klasifikasi_surat' => 'required',
                    'tujuan_arsip' => 'required',
                    'pengirim_sumber' => 'required',
                    'perihal_isi_deskripsi' => 'required',
                    'akses_penerima_surat' => 'required',
                    // disposisi
                    'sifat' => 'required',
                    'perihal_disposisi' => 'required',

                    'akses_satuan_upzis' => 'required',
                    'akses_satuan_ranting' => 'required',
                    'akses_satuan_pc' => 'required',


                ], [
                    'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
                    'nomor_surat.required' => 'Nomor Surat harus diisi',
                    'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                    'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
                    'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                    'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',
                    'akses_penerima_surat.required' => 'Akses Ketua Upzis harus diisi',

                    'sifat.required' => 'Sifat harus diisi',
                    'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',

                    'akses_satuan_upzis.required' => 'salah satu akses satuan harus diisi',
                    'akses_satuan_ranting.required' => 'salah satu akses satuan harus diisi',
                    'akses_satuan_pc.required' => 'salah satu akses satuan harus diisi',


                ]);
            }
        }

        // invalid untuk disposisi ya -> penerima golongan -> sppd ya
        if ($request->disposisi_ya == 'on' && $request->penerima_golongan == 'on' && $request->sppd_ya == 'on') {
            $request->validate([
                // surat masuk
                'tanggal_arsip' => 'required',
                'nomor_surat' => 'required',
                'klasifikasi_surat' => 'required',
                'tujuan_arsip' => 'required',
                'pengirim_sumber' => 'required',
                'perihal_isi_deskripsi' => 'required',
                'akses_penerima_surat' => 'required',

                // disposisi
                'sifat' => 'required',
                'perihal_disposisi' => 'required',
                // sppd
                'tgl_perintah' => 'required',
                'tgl_pelaksanaan' => 'required',
                'anggaran' => 'required',
                'perihal_sppd' => 'required',

                'akses_golongan' => 'required',


            ], [
                'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
                'nomor_surat.required' => 'Nomor Surat harus diisi',
                'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
                'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',
                'akses_penerima_surat.required' => 'Akses Ketua Upzis harus diisi',

                'sifat.required' => 'Sifat harus diisi',
                'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',

                'tgl_perintah.required' => 'Tanggal Perintah harus diisi',
                'tgl_pelaksanaan.required' => 'Tanggal Pelaksanaan harus diisi',
                'anggaran.required' => 'Anggaran harus diisi',
                'perihal_sppd.required' => 'Perihal Sppd harus diisi',
                'akses_golongan.required' => 'Akses Golongan Harus Diisi',


            ]);
        }

        // invalid untuk disposisi ya -> penerima golongan -> sppd tidak
        if ($request->disposisi_ya == 'on' && $request->penerima_golongan == 'on' && $request->sppd_tidak == 'on') {
            $request->validate([
                // surat masuk
                'tanggal_arsip' => 'required',
                'nomor_surat' => 'required',
                'klasifikasi_surat' => 'required',
                'tujuan_arsip' => 'required',
                'pengirim_sumber' => 'required',
                'perihal_isi_deskripsi' => 'required',
                'akses_penerima_surat' => 'required',
                // disposisi
                'sifat' => 'required',
                'perihal_disposisi' => 'required',

                'akses_golongan' => 'required',


            ], [
                'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
                'nomor_surat.required' => 'Nomor Surat harus diisi',
                'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
                'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',
                'akses_penerima_surat.required' => 'Akses Ketua Upzis harus diisi',
                'sifat.required' => 'Sifat harus diisi',
                'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',

                'akses_golongan.required' => 'Akses Golongan Harus Diisi',


            ]);
        }

        // invalid untuk disposisi ya -> penerima internal -> sppd ya
        if ($request->disposisi_ya == 'on' && $request->penerima_internal == 'on' && $request->sppd_ya == 'on') {
            $request->validate([
                // surat masuk
                'tanggal_arsip' => 'required',
                'nomor_surat' => 'required',
                'klasifikasi_surat' => 'required',
                'tujuan_arsip' => 'required',
                'pengirim_sumber' => 'required',
                'perihal_isi_deskripsi' => 'required',
                'akses_penerima_surat' => 'required',
                // disposisi
                'sifat' => 'required',
                'perihal_disposisi' => 'required',
                // sppd
                'tgl_perintah' => 'required',
                'tgl_pelaksanaan' => 'required',
                'anggaran' => 'required',
                'perihal_sppd' => 'required',

                'akses_internal' => 'required',


            ], [
                'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
                'nomor_surat.required' => 'Nomor Surat harus diisi',
                'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
                'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',
                'akses_penerima_surat.required' => 'Akses Ketua Upzis harus diisi',

                'sifat.required' => 'Sifat harus diisi',
                'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',

                'tgl_perintah.required' => 'Tanggal Perintah harus diisi',
                'tgl_pelaksanaan.required' => 'Tanggal Pelaksanaan harus diisi',
                'anggaran.required' => 'Anggaran harus diisi',
                'perihal_sppd.required' => 'Perihal Sppd harus diisi',
                'akses_internal.required' => 'Akses Internal Harus Diisi',


            ]);
        }

        // invalid untuk disposisi ya -> penerima internal -> sppd tidak
        if ($request->disposisi_ya == 'on' && $request->penerima_internal == 'on' && $request->sppd_tidak == 'on') {
            $request->validate([
                // surat masuk
                'tanggal_arsip' => 'required',
                'nomor_surat' => 'required',
                'klasifikasi_surat' => 'required',
                'tujuan_arsip' => 'required',
                'pengirim_sumber' => 'required',
                'perihal_isi_deskripsi' => 'required',
                'akses_penerima_surat' => 'required',
                // disposisi
                'sifat' => 'required',
                'perihal_disposisi' => 'required',

                'akses_internal' => 'required',


            ], [
                'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
                'nomor_surat.required' => 'Nomor Surat harus diisi',
                'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
                'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',
                'akses_penerima_surat.required' => 'Akses Ketua Upzis harus diisi',

                'sifat.required' => 'Sifat harus diisi',
                'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',

                'akses_internal.required' => 'Akses Internal Harus Diisi',


            ]);
        }

        // invalid untuk disposisi tidak -> penerima satuan -> sppd tidak
        if ($request->disposisi_tidak == 'on') {
            $request->validate([
                // surat masuk
                'tanggal_arsip' => 'required',
                'nomor_surat' => 'required',
                'klasifikasi_surat' => 'required',
                'tujuan_arsip' => 'required',
                'pengirim_sumber' => 'required',
                'perihal_isi_deskripsi' => 'required',
                'akses_penerima_surat' => 'required',


            ], [
                'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
                'nomor_surat.required' => 'Nomor Surat harus diisi',
                'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
                'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',
                'akses_penerima_surat.required' => 'Akses Ketua Upzis harus diisi',


            ]);
        }


        if ($request->penerima_golongan == 'on') {


            $s = implode(',', $request->akses_golongan);
            $b = explode(',', $s);


            if (count(collect($b)) == 1) {
                if ($b[0] == 'Semua Pengurus Internal') {
                    $internal = '1';
                    $upzis = '0';
                    $ranting = '0';
                } elseif ($b[0] == 'Semua UPZIS MWCNU') {
                    $internal = '0';
                    $upzis = '1';
                    $ranting = '0';
                } elseif ($b[0] == 'Semua Ranting NU') {
                    $internal = '0';
                    $upzis = '0';
                    $ranting = '1';
                }
            }

            if (count(collect($b)) == 2) {
                if ($b[0] == 'Semua Pengurus Internal' && $b[1] == 'Semua UPZIS MWCNU') {
                    $internal = '1';
                    $upzis = '1';
                    $ranting = '0';
                } elseif ($b[0] == 'Semua UPZIS MWCNU' && $b[1] == 'Semua Pengurus Internal') {
                    $internal = '1';
                    $upzis = '1';
                    $ranting = '0';
                } elseif ($b[0] == 'Semua Pengurus Internal' && $b[1] == 'Semua Ranting NU') {
                    $internal = '1';
                    $upzis = '0';
                    $ranting = '1';
                } elseif ($b[0] == 'Semua Ranting NU' && $b[1] == 'Semua Pengurus Internal') {
                    $internal = '1';
                    $upzis = '0';
                    $ranting = '1';
                } elseif ($b[0] == 'Semua UPZIS MWCNU' && $b[1] == 'Semua Ranting NU') {
                    $internal = '0';
                    $upzis = '1';
                    $ranting = '1';
                } elseif ($b[0] == 'Semua Ranting NU' && $b[1] == 'Semua UPZIS MWCNU') {
                    $internal = '0';
                    $upzis = '1';
                    $ranting = '1';
                }
            }

            if (count(collect($b)) == 3) {
                $internal = '1';
                $upzis = '1';
                $ranting = '1';
            }
        }

        // disposisi
        if ($request->akses_golongan == 'on') {
            $jenis_disposisi = 'Golongan';
        } else {
            $jenis_disposisi = 'Satuan';
        }

        if ($request->disposisi_ya == 'on') {
        }


        // id arsip digital
        $arsip_digital_id = uniqid();

        if ($request->js_tujuan == 'Ketua UPZIS MWCNU' || $request->js_tujuan == 'Koordinator PLPK se Cilacap' || $request->js_tujuan == 'Koordinator PLPK') {
            if ($request->akses_penerima_surat != NULL) {

                $i = 0;
                foreach ($request->akses_penerima_surat as $index) {
                    if ($request->akses_penerima_surat[$i]) {
                        $id_penerima_surat = uniqid();
                        PenerimaSurat::create([
                            'id_penerima_surat' => $id_penerima_surat,
                            'arsip_digital_id' => $arsip_digital_id,
                            'id_pengurus' => $request->akses_penerima_surat[$i],
                            'tujuan' => $request->tujuan_arsip,
                            'status_baca' => '0',
                        ]);
                    }

                    $i++;
                }
            }
        }

        if ($request->js_tujuan == 'Ketua PCNU Cilacap' || $request->js_tujuan == 'Kepala Kantor PCNU Cilacap' || $request->js_tujuan == 'Lainnya') {
            if ($request->akses_penerima_surat != NULL) {

                $aksesPenerimaSuratArray = $request->akses_penerima_surat;

                foreach ($aksesPenerimaSuratArray as $penerima) {
                    $penerimaArray = explode(',', $penerima);

                    foreach ($penerimaArray as $singlePenerima) {
                        $singlePenerima = trim($singlePenerima);
                        if ($singlePenerima) {
                            $id_penerima_surat = uniqid();
                            PenerimaSurat::create([
                                'id_penerima_surat' => $id_penerima_surat,
                                'arsip_digital_id' => $arsip_digital_id,
                                'penerima_lainnya' => $singlePenerima,
                                'tujuan' => $request->tujuan_arsip,
                                'status_baca' => '0',
                            ]);
                        }
                    }
                }
            }
        }


        if ($request->js_tujuan == 'Lainnya') {
            $tujuan = $request->tujuan_lainnya;
        } else {
            $tujuan = $request->tujuan_arsip;
        }

        // terakhir yaitu create surat keluar
        if ($request->disposisi_ya == 'on') {
            if ($request->penerima_satuan == 'on') {


                // keluarkan ke tabel arsip_digital
                ArsipDigital::create([
                    'arsip_digital_id' => $arsip_digital_id,
                    'id_pengguna' => Auth::user()->id_pengguna,
                    'tanggal_arsip' => $request->tanggal_arsip,
                    'jenis_arsip' => 'Surat keluar',
                    'jenis_disposisi' => 'Satuan',
                    'nomor_surat' => $request->nomor_surat,
                    'klasifikasi_surat' => $request->klasifikasi_surat,
                    'tujuan_arsip' => $tujuan,
                    'pengirim_sumber' => $request->pengirim_sumber,
                    'perihal_isi_deskripsi' => $request->perihal_isi_deskripsi,
                    'diinput_oleh' => Auth::user()->gocap_id_pc_pengurus,
                    'alamat_pengirim' => $request->alamat_pengirim,
                    'keterangan_surat_masuk' => $request->keterangan_surat_masuk,
                    'keterangan_surat_keluar' => $request->keterangan_surat_keluar,
                ]);

                // keluarkan ke tabel disposisi dan sppd mwcnu

                if ($request->akses_satuan_upzis != NULL) {


                    $b = 0;
                    foreach ($request->akses_satuan_upzis as $index) {

                        $disposisi_id = uniqid();
                        $sppd_id = uniqid();
                        Disposisi::create([
                            'disposisi_id' => $disposisi_id,
                            'arsip_digital_id' => $arsip_digital_id,
                            'id_upzis' => $request->akses_satuan_upzis[$b],
                            'status_baca' => '0',
                            'sifat' => $request->sifat,
                            'perihal' => $request->perihal_disposisi,
                        ]);
                        if ($request->sppd_ya == 'on') {
                            Sppd::create([
                                'sppd_id' => $sppd_id,
                                'arsip_digital_id' => $arsip_digital_id,
                                'disposisi_id' => $disposisi_id,
                                'perihal' => $request->perihal_sppd,
                                'tgl_pelaksanaan' => $request->tgl_pelaksanaan,
                                'anggaran' => $anggaran,
                            ]);
                        }
                        $b++;
                    }
                }
                if ($request->akses_satuan_pc != NULL) {


                    $b = 0;
                    foreach ($request->akses_satuan_pc as $index) {

                        $disposisi_id = uniqid();
                        $sppd_id = uniqid();
                        Disposisi::create([
                            'disposisi_id' => $disposisi_id,
                            'arsip_digital_id' => $arsip_digital_id,
                            'id_pc' => $request->akses_satuan_pc[$b],
                            'status_baca' => '0',
                            'sifat' => $request->sifat,
                            'perihal' => $request->perihal_disposisi,
                        ]);
                        if ($request->sppd_ya == 'on') {
                            Sppd::create([
                                'sppd_id' => $sppd_id,
                                'arsip_digital_id' => $arsip_digital_id,
                                'disposisi_id' => $disposisi_id,
                                'perihal' => $request->perihal_sppd,
                                'tgl_pelaksanaan' => $request->tgl_pelaksanaan,
                                'anggaran' => $anggaran,
                            ]);
                        }
                        $b++;
                    }
                }
                if ($request->akses_satuan_ranting != NULL) {


                    $b = 0;
                    foreach ($request->akses_satuan_ranting as $index) {

                        $disposisi_id = uniqid();
                        $sppd_id = uniqid();
                        Disposisi::create([
                            'disposisi_id' => $disposisi_id,
                            'arsip_digital_id' => $arsip_digital_id,
                            'id_ranting' => $request->akses_satuan_ranting[$b],
                            'status_baca' => '0',
                            'sifat' => $request->sifat,
                            'perihal' => $request->perihal_disposisi,
                        ]);
                        if ($request->sppd_ya == 'on') {
                            Sppd::create([
                                'sppd_id' => $sppd_id,
                                'arsip_digital_id' => $arsip_digital_id,
                                'disposisi_id' => $disposisi_id,
                                'perihal' => $request->perihal_sppd,
                                'tgl_pelaksanaan' => $request->tgl_pelaksanaan,
                                'anggaran' => $anggaran,
                            ]);
                        }
                        $b++;
                    }
                }

                // keluarkan ke tabel disposisi dan sppd lembaga

            } elseif ($request->penerima_golongan == 'on') {


                ArsipDigital::create([
                    'arsip_digital_id' => $arsip_digital_id,
                    'id_pengguna' => Auth::user()->id_pengguna,
                    'tanggal_arsip' => $request->tanggal_arsip,
                    'jenis_arsip' => 'Surat keluar',
                    'jenis_disposisi' => 'Golongan',
                    'nomor_surat' => $request->nomor_surat,
                    'klasifikasi_surat' => $request->klasifikasi_surat,
                    'tujuan_arsip' => $tujuan,
                    'pengirim_sumber' => $request->pengirim_sumber,
                    'perihal_isi_deskripsi' => $request->perihal_isi_deskripsi,
                    'diinput_oleh' => Auth::user()->gocap_id_pc_pengurus,
                    'alamat_pengirim' => $request->alamat_pengirim,
                    'keterangan_surat_masuk' => $request->keterangan_surat_masuk,
                    'keterangan_surat_keluar' => $request->keterangan_surat_keluar,
                ]);



                if (Auth::user()->gocap_id_pc_pengurus != NULL) {
                    $upzis_all = Upzis::all()->pluck('id_upzis')->toArray();
                } elseif (Auth::user()->gocap_id_upzis_pengurus != NULL) {
                    $upzis_all = Upzis::all()->where('id_upzis', '!=', Auth::user()->UpzisPengurus->Upzis->id_upzis)->pluck('id_upzis')->toArray();
                }
                // keluarkan ke tabel disposisi dan sppd 
                if ($upzis == '1') {
                    $b = 0;
                    foreach ($upzis_all as $index) {
                        $disposisi_id = uniqid();
                        $sppd_id = uniqid();
                        Disposisi::create([
                            'disposisi_id' => $disposisi_id,
                            'arsip_digital_id' => $arsip_digital_id,
                            'id_upzis' => $upzis_all[$b],
                            'status_baca' => '0',
                            'sifat' => $request->sifat,
                            'perihal' => $request->perihal_disposisi,
                        ]);
                        if ($request->sppd_ya == 'on') {
                            Sppd::create([
                                'sppd_id' => $sppd_id,
                                'arsip_digital_id' => $arsip_digital_id,
                                'disposisi_id' => $disposisi_id,
                                'perihal' => $request->perihal_sppd,
                                'tgl_pelaksanaan' => $request->tgl_pelaksanaan,
                                'anggaran' => $anggaran,
                            ]);
                        }
                        $b++;
                    }
                }

                if (Auth::user()->gocap_id_pc_pengurus != NULL) {
                    $ranting_all = Ranting::all()->pluck('id_ranting')->toArray();
                } elseif (Auth::user()->gocap_id_upzis_pengurus != NULL) {
                    $ranting_all = Ranting::all()->where('id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)->pluck('id_ranting')->toArray();
                }
                if ($ranting == '1') {
                    $b = 0;
                    foreach ($ranting_all as $index) {
                        $disposisi_id = uniqid();
                        $sppd_id = uniqid();
                        Disposisi::create([
                            'disposisi_id' => $disposisi_id,
                            'arsip_digital_id' => $arsip_digital_id,
                            'id_ranting' => $ranting_all[$b],
                            'status_baca' => '0',
                            'sifat' => $request->sifat,
                            'perihal' => $request->perihal_disposisi,
                        ]);
                        if ($request->sppd_ya == 'on') {
                            Sppd::create([
                                'sppd_id' => $sppd_id,
                                'arsip_digital_id' => $arsip_digital_id,
                                'disposisi_id' => $disposisi_id,
                                'perihal' => $request->perihal_sppd,
                                'tgl_pelaksanaan' => $request->tgl_pelaksanaan,
                                'anggaran' => $anggaran,
                            ]);
                        }
                        $b++;
                    }
                }

                if (Auth::user()->gocap_id_pc_pengurus != NULL) {
                    $internal_all = PcPengurus::all()->where('id_pc', Auth::user()->PcPengurus->id_pc)->pluck('id_pc_pengurus')->toArray();
                } elseif (Auth::user()->gocap_id_upzis_pengurus != NULL) {
                    $internal_all = UpzisPengurus::all()->where('id_upzis', Auth::user()->UpzisPengurus->id_upzis)->pluck('id_upzis_pengurus')->toArray();
                }
                // keluarkan ke tabel disposisi 
                if ($internal == '1') {
                    $b = 0;
                    if (Auth::user()->gocap_id_pc_pengurus != NULL) {
                        foreach ($internal_all as $index) {
                            $disposisi_id = uniqid();
                            $sppd_id = uniqid();
                            Disposisi::create([
                                'disposisi_id' => $disposisi_id,
                                'arsip_digital_id' => $arsip_digital_id,
                                'id_pengurus_internal' => $internal_all[$b],
                                'status_baca' => '0',
                                'sifat' => $request->sifat,
                                'perihal' => $request->perihal_disposisi,
                            ]);
                            if ($request->sppd_ya == 'on') {
                                Sppd::create([
                                    'sppd_id' => $sppd_id,
                                    'arsip_digital_id' => $arsip_digital_id,
                                    'disposisi_id' => $disposisi_id,
                                    'perihal' => $request->perihal_sppd,
                                    'tgl_pelaksanaan' => $request->tgl_pelaksanaan,
                                    'anggaran' => $anggaran,
                                ]);
                            }
                            $b++;
                        }
                    } elseif (Auth::user()->gocap_id_upzis_pengurus != NULL) {
                        foreach ($internal_all as $index) {
                            $disposisi_id = uniqid();
                            $sppd_id = uniqid();
                            Disposisi::create([
                                'disposisi_id' => $disposisi_id,
                                'arsip_digital_id' => $arsip_digital_id,
                                'id_pengurus_internal' => $internal_all[$b],
                                'status_baca' => '0',
                                'sifat' => $request->sifat,
                                'perihal' => $request->perihal_disposisi,
                            ]);
                            if ($request->sppd_ya == 'on') {
                                Sppd::create([
                                    'sppd_id' => $sppd_id,
                                    'arsip_digital_id' => $arsip_digital_id,
                                    'disposisi_id' => $disposisi_id,
                                    'perihal' => $request->perihal_sppd,
                                    'tgl_pelaksanaan' => $request->tgl_pelaksanaan,
                                    'anggaran' => $anggaran,
                                ]);
                            }
                            $b++;
                        }
                    }
                }
            } elseif ($request->penerima_internal == 'on') {


                // keluarkan ke tabel arsip_digital
                ArsipDigital::create([
                    'arsip_digital_id' => $arsip_digital_id,
                    'id_pengguna' => Auth::user()->id_pengguna,
                    'tanggal_arsip' => $request->tanggal_arsip,
                    'jenis_arsip' => 'Surat keluar',
                    'jenis_disposisi' => 'Internal',
                    'nomor_surat' => $request->nomor_surat,
                    'klasifikasi_surat' => $request->klasifikasi_surat,
                    'tujuan_arsip' => $tujuan,
                    'pengirim_sumber' => $request->pengirim_sumber,
                    'perihal_isi_deskripsi' => $request->perihal_isi_deskripsi,
                    'isi_surat' => $request->isi_surat,
                    'diinput_oleh' => Auth::user()->gocap_id_pc_pengurus,
                    'alamat_pengirim' => $request->alamat_pengirim,
                    'keterangan_surat_masuk' => $request->keterangan_surat_masuk,
                    'keterangan_surat_keluar' => $request->keterangan_surat_keluar,
                ]);

                if (Auth::user()->gocap_id_pc_pengurus != null) {

                    // keluarkan ke tabel internal dan sppd internal
                    if ($request->akses_internal != NULL) {
                        $b = 0;
                        foreach ($request->akses_internal as $index) {
                            $disposisi_id = uniqid();
                            $sppd_id = uniqid();
                            Disposisi::create([
                                'disposisi_id' => $disposisi_id,
                                'arsip_digital_id' => $arsip_digital_id,
                                'id_pengurus_internal' => $request->akses_internal[$b],
                                'status_baca' => '0',
                                'sifat' => $request->sifat,
                                'perihal' => $request->perihal_disposisi,
                            ]);
                            if ($request->sppd_ya == 'on') {
                                Sppd::create([
                                    'sppd_id' => $sppd_id,
                                    'arsip_digital_id' => $arsip_digital_id,
                                    'disposisi_id' => $disposisi_id,
                                    'perihal' => $request->perihal_sppd,
                                    'tgl_pelaksanaan' => $request->tgl_pelaksanaan,
                                    'anggaran' => $anggaran,
                                ]);
                            }
                            $b++;
                        }
                    }
                }
                if (Auth::user()->gocap_id_upzis_pengurus != null) {

                    // keluarkan ke tabel internal dan sppd internal
                    if ($request->akses_internal != NULL) {
                        $b = 0;
                        foreach ($request->akses_internal as $index) {
                            $disposisi_id = uniqid();
                            $sppd_id = uniqid();
                            Disposisi::create([
                                'disposisi_id' => $disposisi_id,
                                'arsip_digital_id' => $arsip_digital_id,
                                'id_pengurus_internal' => $request->akses_internal[$b],
                                'status_baca' => '0',
                                'sifat' => $request->sifat,
                                'perihal' => $request->perihal_disposisi,
                            ]);
                            if ($request->sppd_ya == 'on') {
                                Sppd::create([
                                    'sppd_id' => $sppd_id,
                                    'arsip_digital_id' => $arsip_digital_id,
                                    'disposisi_id' => $disposisi_id,
                                    'perihal' => $request->perihal_sppd,
                                    'tgl_pelaksanaan' => $request->tgl_pelaksanaan,
                                    'anggaran' => $anggaran,
                                ]);
                            }
                            $b++;
                        }
                    }
                }
            }
        } elseif ($request->disposisi_tidak == 'on') {


            ArsipDigital::create([
                'arsip_digital_id' => $arsip_digital_id,
                'id_pengguna' => Auth::user()->id_pengguna,
                'tanggal_arsip' => $request->tanggal_arsip,
                'jenis_arsip' => 'Surat keluar',
                'jenis_disposisi' => 'Tidak Ada',
                'nomor_surat' => $request->nomor_surat,
                'klasifikasi_surat' => $request->klasifikasi_surat,
                'tujuan_arsip' => $tujuan,
                'pengirim_sumber' => $request->pengirim_sumber,
                'perihal_isi_deskripsi' => $request->perihal_isi_deskripsi,
                'diinput_oleh' => Auth::user()->gocap_id_pc_pengurus,
                'alamat_pengirim' => $request->alamat_pengirim,
                'keterangan_surat_masuk' => $request->keterangan_surat_masuk,
                'keterangan_surat_keluar' => $request->keterangan_surat_keluar,
            ]);
        }

        if ($request->scan_surat != null && $request->nama_surat != null) {
            $file = $request->file('scan_surat');
            $ext_logo = $file->extension();
            $filename_scan = $file->storeAs('/lampiran', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext_logo, ['disk' => 'lampiran']);
            LampiranArsip::create([
                'lampiran_arsip_id' => uniqid(),
                'arsip_digital_id' => $arsip_digital_id,
                'nama' => $request->nama_surat,
                'jenis' => 'Scan Surat',
                'file' => $filename_scan,
            ]);

            if ($request->lampiran != null &&  $request->nama != null) {
                if ($request->nama && count($request->nama) > 0) {
                    $a = 0;
                    foreach ($request->file('lampiran') as $index) {

                        $file = $index;
                        $ext_logo = $file->extension();

                        $filename_lampiran = $file->storeAs('/lampiran', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext_logo, ['disk' => 'lampiran']);
                        $validatedData['lampiran_arsip_id'] = uniqid();
                        $validatedData['arsip_digital_id'] = $arsip_digital_id;
                        $validatedData['nama'] = $request->nama[$a];
                        $validatedData['jenis'] = 'Lampiran';
                        $validatedData['file'] = $filename_lampiran;
                        LampiranArsip::create($validatedData);

                        $a++;
                    }
                }
            }
        }


        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('Surat Keluar ' . $cek . ' Berhasil Ditambahkan');

        if (Auth::user()->gocap_id_pc_pengurus != null) {
            return redirect('/' . $request->role . '/arsip/detail_surat_keluar/' . $arsip_digital_id . '/pc')->with('success', 'Data berhasil ditambahkan');
        } elseif (Auth::user()->gocap_id_upzis_pengurus != null) {
            return redirect('/' . $request->role . '/arsip/detail_surat_keluar/' . $arsip_digital_id . '/upzis')->with('success', 'Data berhasil ditambahkan');
        }
    }

    public function notif($nomor, $pesan)
    {
        $url = "https://wa.nucarecilacap.id/api/send.php?key=f1f441eaf700fa1a85f32c8a3973401be87e3c6d";
        $post = [
            'nomor' => $nomor,
            // 'nomor' => '081578447350',
            // 'nomor' => '0895358355119',
            'msg' => $pesan
        ];
        $post = json_encode($post);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $response = curl_exec($ch);

        $responseInfo = curl_getinfo($ch);

        $httpResponseCode = $responseInfo['http_code'];
        curl_close($ch);
        return (int)$httpResponseCode;
    }

    public function aksi_tambah_surat_keluar_baru(Request $request)
    {

        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $anggaran = str_replace('.', '',  $request->anggaran);


        if (Auth::user()->gocap_id_pc_pengurus != null) {
            // invalid untuk disposisi ya -> penerima satuan -> sppd ya
            if ($request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_ya == 'on' && $request->akses_satuan_upzis == null && $request->akses_satuan_ranting == null) {
                $request->validate([
                    // surat masuk
                    'tanggal_arsip' => 'required',
                    'nomor_surat' => 'required',
                    'klasifikasi_surat' => 'required',
                    'tujuan_arsip' => 'required',
                    'pengirim_sumber' => 'required',
                    'perihal_isi_deskripsi' => 'required',
                    'akses_penerima_surat' => 'required',
                    'jenis_surat' => 'required',
                    // disposisi
                    'sifat' => 'required',
                    'perihal_disposisi' => 'required',
                    // sppd
                    'tgl_perintah' => 'required',
                    'tgl_pelaksanaan' => 'required',
                    'anggaran' => 'required',
                    'perihal_sppd' => 'required',

                    'akses_satuan_upzis' => 'required',
                    'akses_satuan_ranting' => 'required',
                ], [
                    'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
                    'nomor_surat.required' => 'Nomor Surat harus diisi',
                    'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                    'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
                    'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                    'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',
                    'akses_penerima_surat.required' => 'Akses Ketua Upzis harus diisi',
                    'jenis_surat.required' => 'Jenis Surat harus diisi',

                    'sifat.required' => 'Sifat harus diisi',
                    'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',

                    'tgl_perintah.required' => 'Tanggal Perintah harus diisi',
                    'tgl_pelaksanaan.required' => 'Tanggal Pelaksanaan harus diisi',
                    'anggaran.required' => 'Anggaran harus diisi',
                    'perihal_sppd.required' => 'Perihal Sppd harus diisi',

                    'akses_satuan_upzis.required' => 'salah satu akses satuan harus diisi',
                    'akses_satuan_ranting.required' => 'salah satu akses satuan harus diisi',

                ]);
            }

            if (
                $request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_ya == 'on' && $request->akses_satuan_upzis != null ||
                $request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_ya == 'on' &&  $request->akses_satuan_ranting != null
            ) {
                $request->validate([
                    // surat masuk
                    'tanggal_arsip' => 'required',
                    'nomor_surat' => 'required',
                    'klasifikasi_surat' => 'required',
                    'tujuan_arsip' => 'required',
                    'pengirim_sumber' => 'required',
                    'perihal_isi_deskripsi' => 'required',
                    'akses_penerima_surat' => 'required',
                    'jenis_surat' => 'required',
                    // disposisi
                    'sifat' => 'required',
                    'perihal_disposisi' => 'required',
                    // sppd
                    'tgl_perintah' => 'required',
                    'tgl_pelaksanaan' => 'required',
                    'anggaran' => 'required',
                    'perihal_sppd' => 'required',


                ], [
                    'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
                    'nomor_surat.required' => 'Nomor Surat harus diisi',
                    'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                    'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
                    'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                    'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',
                    'akses_penerima_surat.required' => 'Akses Ketua Upzis harus diisi',
                    'jenis_surat.required' => 'Jenis Surat harus diisi',

                    'sifat.required' => 'Sifat harus diisi',
                    'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',

                    'tgl_perintah.required' => 'Tanggal Perintah harus diisi',
                    'tgl_pelaksanaan.required' => 'Tanggal Pelaksanaan harus diisi',
                    'anggaran.required' => 'Anggaran harus diisi',
                    'perihal_sppd.required' => 'Perihal Sppd harus diisi',


                ]);
            }

            // invalid untuk disposisi ya -> penerima satuan -> sppd tidak
            if (
                $request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_tidak == 'on' && $request->akses_satuan_upzis != null ||
                $request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_tidak == 'on' &&   $request->akses_satuan_ranting != null
            ) {
                $request->validate([
                    // surat masuk
                    'tanggal_arsip' => 'required',
                    'nomor_surat' => 'required',
                    'klasifikasi_surat' => 'required',
                    'tujuan_arsip' => 'required',
                    'pengirim_sumber' => 'required',
                    'perihal_isi_deskripsi' => 'required',
                    'akses_penerima_surat' => 'required',
                    'jenis_surat' => 'required',
                    // disposisi
                    'sifat' => 'required',
                    'perihal_disposisi' => 'required',


                ], [
                    'jenis_surat.required' => 'Jenis Surat harus diisi',
                    'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
                    'nomor_surat.required' => 'Nomor Surat harus diisi',
                    'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                    'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
                    'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                    'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',
                    'akses_penerima_surat.required' => 'Akses Ketua Upzis harus diisi',

                    'sifat.required' => 'Sifat harus diisi',
                    'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',


                ]);
            }

            // invalid untuk disposisi ya -> penerima satuan -> sppd tidak
            if ($request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_tidak == 'on' && $request->akses_satuan_upzis == null && $request->akses_satuan_ranting == null) {

                $request->validate([
                    // surat masuk
                    'tanggal_arsip' => 'required',
                    'nomor_surat' => 'required',
                    'klasifikasi_surat' => 'required',
                    'tujuan_arsip' => 'required',
                    'pengirim_sumber' => 'required',
                    'perihal_isi_deskripsi' => 'required',
                    'akses_penerima_surat' => 'required',
                    'jenis_surat' => 'required',
                    // disposisi
                    'sifat' => 'required',
                    'perihal_disposisi' => 'required',

                    'akses_satuan_upzis' => 'required',
                    'akses_satuan_ranting' => 'required',



                ], [
                    'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
                    'nomor_surat.required' => 'Nomor Surat harus diisi',
                    'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                    'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
                    'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                    'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',
                    'akses_penerima_surat.required' => 'Akses Ketua Upzis harus diisi',
                    'jenis_surat.required' => 'Jenis Surat harus diisi',

                    'sifat.required' => 'Sifat harus diisi',
                    'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',

                    'akses_satuan_upzis.required' => 'salah satu akses satuan harus diisi',
                    'akses_satuan_ranting.required' => 'salah satu akses satuan harus diisi',


                ]);
            }
        }

        if (Auth::user()->gocap_id_upzis_pengurus != null) {
            // invalid untuk disposisi ya -> penerima satuan -> sppd ya
            if ($request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_ya == 'on' && $request->akses_satuan_upzis == null && $request->akses_satuan_ranting == null && $request->akses_satuan_pc == null) {
                $request->validate([
                    // surat masuk
                    'tanggal_arsip' => 'required',
                    'nomor_surat' => 'required',
                    'klasifikasi_surat' => 'required',
                    'tujuan_arsip' => 'required',
                    'pengirim_sumber' => 'required',
                    'perihal_isi_deskripsi' => 'required',
                    'akses_penerima_surat' => 'required',
                    'jenis_surat' => 'required',
                    // disposisi
                    'sifat' => 'required',
                    'perihal_disposisi' => 'required',
                    // sppd
                    'tgl_perintah' => 'required',
                    'tgl_pelaksanaan' => 'required',
                    'anggaran' => 'required',
                    'perihal_sppd' => 'required',

                    'akses_satuan_upzis' => 'required',
                    'akses_satuan_ranting' => 'required',
                    'akses_satuan_pc' => 'required',


                ], [
                    'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
                    'nomor_surat.required' => 'Nomor Surat harus diisi',
                    'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                    'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
                    'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                    'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',
                    'akses_penerima_surat.required' => 'Akses Ketua Upzis harus diisi',
                    'jenis_surat.required' => 'Jenis Surat harus diisi',

                    'akses_satuan.required' => 'Akses Satuan harus diisi',
                    'sifat.required' => 'Sifat harus diisi',
                    'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',

                    'tgl_perintah.required' => 'Tanggal Perintah harus diisi',
                    'tgl_pelaksanaan.required' => 'Tanggal Pelaksanaan harus diisi',
                    'anggaran.required' => 'Anggaran harus diisi',
                    'perihal_sppd.required' => 'Perihal Sppd harus diisi',

                    'akses_satuan_upzis.required' => 'salah satu akses satuan harus diisi',
                    'akses_satuan_ranting.required' => 'salah satu akses satuan harus diisi',
                    'akses_satuan_pc.required' => 'salah satu akses satuan harus diisi',


                ]);
            }

            if (
                $request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_ya == 'on' && $request->akses_satuan_upzis != null ||
                $request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_ya == 'on' &&  $request->akses_satuan_ranting != null ||
                $request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_ya == 'on' &&  $request->akses_satuan_pc != null
            ) {
                $request->validate([
                    // surat masuk
                    'tanggal_arsip' => 'required',
                    'nomor_surat' => 'required',
                    'klasifikasi_surat' => 'required',
                    'tujuan_arsip' => 'required',
                    'pengirim_sumber' => 'required',
                    'perihal_isi_deskripsi' => 'required',
                    'akses_penerima_surat' => 'required',
                    'jenis_surat' => 'required',
                    // disposisi
                    'sifat' => 'required',
                    'perihal_disposisi' => 'required',
                    // sppd
                    'tgl_perintah' => 'required',
                    'tgl_pelaksanaan' => 'required',
                    'anggaran' => 'required',
                    'perihal_sppd' => 'required',




                ], [
                    'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
                    'nomor_surat.required' => 'Nomor Surat harus diisi',
                    'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                    'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
                    'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                    'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',
                    'akses_penerima_surat.required' => 'Akses Ketua Upzis harus diisi',
                    'jenis_surat.required' => 'Jenis Surat harus diisi',

                    'akses_satuan.required' => 'Akses Satuan harus diisi',
                    'sifat.required' => 'Sifat harus diisi',
                    'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',

                    'tgl_perintah.required' => 'Tanggal Perintah harus diisi',
                    'tgl_pelaksanaan.required' => 'Tanggal Pelaksanaan harus diisi',
                    'anggaran.required' => 'Anggaran harus diisi',
                    'perihal_sppd.required' => 'Perihal Sppd harus diisi',



                ]);
            }

            // invalid untuk disposisi ya -> penerima satuan -> sppd tidak
            if (
                $request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_tidak == 'on' && $request->akses_satuan_upzis != null ||
                $request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_tidak == 'on' &&  $request->akses_satuan_ranting != null ||
                $request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_tidak == 'on' &&  $request->akses_satuan_pc != null
            ) {
                $request->validate([
                    // surat masuk
                    'tanggal_arsip' => 'required',
                    'nomor_surat' => 'required',
                    'klasifikasi_surat' => 'required',
                    'tujuan_arsip' => 'required',
                    'pengirim_sumber' => 'required',
                    'perihal_isi_deskripsi' => 'required',
                    'akses_penerima_surat' => 'required',
                    'jenis_surat' => 'required',
                    // disposisi
                    'sifat' => 'required',
                    'perihal_disposisi' => 'required',



                ], [
                    'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
                    'nomor_surat.required' => 'Nomor Surat harus diisi',
                    'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                    'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
                    'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                    'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',
                    'akses_penerima_surat.required' => 'Akses Ketua Upzis harus diisi',
                    'jenis_surat.required' => 'Jenis Surat harus diisi',

                    'sifat.required' => 'Sifat harus diisi',
                    'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',


                ]);
            }

            // invalid untuk disposisi ya -> penerima satuan -> sppd tidak
            if ($request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_tidak == 'on' && $request->akses_satuan_upzis == null && $request->akses_satuan_ranting == null && $request->akses_satuan_pc == null) {

                $request->validate([
                    // surat masuk
                    'tanggal_arsip' => 'required',
                    'nomor_surat' => 'required',
                    'klasifikasi_surat' => 'required',
                    'tujuan_arsip' => 'required',
                    'pengirim_sumber' => 'required',
                    'perihal_isi_deskripsi' => 'required',
                    'akses_penerima_surat' => 'required',
                    'jenis_surat' => 'required',
                    // disposisi
                    'sifat' => 'required',
                    'perihal_disposisi' => 'required',

                    'akses_satuan_upzis' => 'required',
                    'akses_satuan_ranting' => 'required',
                    'akses_satuan_pc' => 'required',


                ], [
                    'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
                    'nomor_surat.required' => 'Nomor Surat harus diisi',
                    'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                    'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
                    'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                    'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',
                    'akses_penerima_surat.required' => 'Akses Ketua Upzis harus diisi',
                    'jenis_surat.required' => 'Jenis Surat harus diisi',

                    'sifat.required' => 'Sifat harus diisi',
                    'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',

                    'akses_satuan_upzis.required' => 'salah satu akses satuan harus diisi',
                    'akses_satuan_ranting.required' => 'salah satu akses satuan harus diisi',
                    'akses_satuan_pc.required' => 'salah satu akses satuan harus diisi',


                ]);
            }
        }

        // invalid untuk disposisi ya -> penerima golongan -> sppd ya
        if ($request->disposisi_ya == 'on' && $request->penerima_golongan == 'on' && $request->sppd_ya == 'on') {
            $request->validate([
                // surat masuk
                'tanggal_arsip' => 'required',
                'nomor_surat' => 'required',
                'klasifikasi_surat' => 'required',
                'tujuan_arsip' => 'required',
                'pengirim_sumber' => 'required',
                'perihal_isi_deskripsi' => 'required',
                'akses_penerima_surat' => 'required',
                'jenis_surat' => 'required',

                // disposisi
                'sifat' => 'required',
                'perihal_disposisi' => 'required',
                // sppd
                'tgl_perintah' => 'required',
                'tgl_pelaksanaan' => 'required',
                'anggaran' => 'required',
                'perihal_sppd' => 'required',

                'akses_golongan' => 'required',


            ], [
                'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
                'nomor_surat.required' => 'Nomor Surat harus diisi',
                'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
                'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',
                'akses_penerima_surat.required' => 'Akses Ketua Upzis harus diisi',
                'jenis_surat.required' => 'Jenis Surat harus diisi',

                'sifat.required' => 'Sifat harus diisi',
                'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',

                'tgl_perintah.required' => 'Tanggal Perintah harus diisi',
                'tgl_pelaksanaan.required' => 'Tanggal Pelaksanaan harus diisi',
                'anggaran.required' => 'Anggaran harus diisi',
                'perihal_sppd.required' => 'Perihal Sppd harus diisi',
                'akses_golongan.required' => 'Akses Golongan Harus Diisi',


            ]);
        }

        // invalid untuk disposisi ya -> penerima golongan -> sppd tidak
        if ($request->disposisi_ya == 'on' && $request->penerima_golongan == 'on' && $request->sppd_tidak == 'on') {
            $request->validate([
                // surat masuk
                'tanggal_arsip' => 'required',
                'nomor_surat' => 'required',
                'klasifikasi_surat' => 'required',
                'tujuan_arsip' => 'required',
                'pengirim_sumber' => 'required',
                'perihal_isi_deskripsi' => 'required',
                'akses_penerima_surat' => 'required',
                'jenis_surat' => 'required',
                // disposisi
                'sifat' => 'required',
                'perihal_disposisi' => 'required',

                'akses_golongan' => 'required',


            ], [
                'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
                'nomor_surat.required' => 'Nomor Surat harus diisi',
                'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
                'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',
                'akses_penerima_surat.required' => 'Akses Ketua Upzis harus diisi',
                'sifat.required' => 'Sifat harus diisi',
                'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',
                'jenis_surat.required' => 'Jenis Surat harus diisi',
                'akses_golongan.required' => 'Akses Golongan Harus Diisi',


            ]);
        }

        // invalid untuk disposisi ya -> penerima internal -> sppd ya
        if ($request->disposisi_ya == 'on' && $request->penerima_internal == 'on' && $request->sppd_ya == 'on') {
            $request->validate([
                // surat masuk
                'tanggal_arsip' => 'required',
                'nomor_surat' => 'required',
                'klasifikasi_surat' => 'required',
                'tujuan_arsip' => 'required',
                'pengirim_sumber' => 'required',
                'perihal_isi_deskripsi' => 'required',
                'akses_penerima_surat' => 'required',
                'jenis_surat' => 'required',
                // disposisi
                'sifat' => 'required',
                'perihal_disposisi' => 'required',
                // sppd
                'tgl_perintah' => 'required',
                'tgl_pelaksanaan' => 'required',
                'anggaran' => 'required',
                'perihal_sppd' => 'required',

                'akses_internal' => 'required',


            ], [
                'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
                'nomor_surat.required' => 'Nomor Surat harus diisi',
                'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
                'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',
                'akses_penerima_surat.required' => 'Akses Ketua Upzis harus diisi',
                'jenis_surat.required' => 'Jenis Surat harus diisi',

                'sifat.required' => 'Sifat harus diisi',
                'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',

                'tgl_perintah.required' => 'Tanggal Perintah harus diisi',
                'tgl_pelaksanaan.required' => 'Tanggal Pelaksanaan harus diisi',
                'anggaran.required' => 'Anggaran harus diisi',
                'perihal_sppd.required' => 'Perihal Sppd harus diisi',
                'akses_internal.required' => 'Akses Internal Harus Diisi',


            ]);
        }

        // invalid untuk disposisi ya -> penerima internal -> sppd tidak
        if ($request->disposisi_ya == 'on' && $request->penerima_internal == 'on' && $request->sppd_tidak == 'on') {
            $request->validate([
                // surat masuk
                'tanggal_arsip' => 'required',
                'nomor_surat' => 'required',
                'klasifikasi_surat' => 'required',
                'tujuan_arsip' => 'required',
                'pengirim_sumber' => 'required',
                'perihal_isi_deskripsi' => 'required',
                'akses_penerima_surat' => 'required',
                'jenis_surat' => 'required',
                // disposisi
                'sifat' => 'required',
                'perihal_disposisi' => 'required',

                'akses_internal' => 'required',


            ], [
                'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
                'nomor_surat.required' => 'Nomor Surat harus diisi',
                'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
                'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',
                'akses_penerima_surat.required' => 'Akses Ketua Upzis harus diisi',
                'jenis_surat.required' => 'Jenis Surat harus diisi',

                'sifat.required' => 'Sifat harus diisi',
                'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',

                'akses_internal.required' => 'Akses Internal Harus Diisi',


            ]);
        }

        // invalid untuk disposisi tidak -> penerima satuan -> sppd tidak
        if ($request->disposisi_tidak == 'on') {
            $request->validate([
                // surat masuk
                'tanggal_arsip' => 'required',
                'nomor_surat' => 'required',
                'klasifikasi_surat' => 'required',
                'tujuan_arsip' => 'required',
                'pengirim_sumber' => 'required',
                'perihal_isi_deskripsi' => 'required',
                'akses_penerima_surat' => 'required',
                'jenis_surat' => 'required',


            ], [
                'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
                'nomor_surat.required' => 'Nomor Surat harus diisi',
                'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
                'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',
                'akses_penerima_surat.required' => 'Akses Ketua Upzis harus diisi',
                'jenis_surat.required' => 'Jenis Surat harus diisi',


            ]);
        }


        if ($request->penerima_golongan == 'on') {
            $s = implode(',', $request->akses_golongan);
            $b = explode(',', $s);


            if (count(collect($b)) == 1) {
                if ($b[0] == 'Semua Pengurus Internal') {
                    $internal = '1';
                    $upzis = '0';
                    $ranting = '0';
                } elseif ($b[0] == 'Semua UPZIS MWCNU') {
                    $internal = '0';
                    $upzis = '1';
                    $ranting = '0';
                } elseif ($b[0] == 'Semua Ranting NU') {
                    $internal = '0';
                    $upzis = '0';
                    $ranting = '1';
                }
            }

            if (count(collect($b)) == 2) {
                if ($b[0] == 'Semua Pengurus Internal' && $b[1] == 'Semua UPZIS MWCNU') {
                    $internal = '1';
                    $upzis = '1';
                    $ranting = '0';
                } elseif ($b[0] == 'Semua UPZIS MWCNU' && $b[1] == 'Semua Pengurus Internal') {
                    $internal = '1';
                    $upzis = '1';
                    $ranting = '0';
                } elseif ($b[0] == 'Semua Pengurus Internal' && $b[1] == 'Semua Ranting NU') {
                    $internal = '1';
                    $upzis = '0';
                    $ranting = '1';
                } elseif ($b[0] == 'Semua Ranting NU' && $b[1] == 'Semua Pengurus Internal') {
                    $internal = '1';
                    $upzis = '0';
                    $ranting = '1';
                } elseif ($b[0] == 'Semua UPZIS MWCNU' && $b[1] == 'Semua Ranting NU') {
                    $internal = '0';
                    $upzis = '1';
                    $ranting = '1';
                } elseif ($b[0] == 'Semua Ranting NU' && $b[1] == 'Semua UPZIS MWCNU') {
                    $internal = '0';
                    $upzis = '1';
                    $ranting = '1';
                }
            }

            if (count(collect($b)) == 3) {
                $internal = '1';
                $upzis = '1';
                $ranting = '1';
            }
        }

        // disposisi
        if ($request->akses_golongan == 'on') {
            $jenis_disposisi = 'Golongan';
        } else {
            $jenis_disposisi = 'Satuan';
        }

        if ($request->disposisi_ya == 'on') {
        }


        // id arsip digital
        $arsip_digital_id = uniqid();
        // if ($request->akses_penerima_surat != NULL) {

        //     $i = 0;
        //     foreach ($request->akses_penerima_surat as $index) {
        //         $id_penerima_surat = uniqid();
        //         PenerimaSurat::create([
        //             'id_penerima_surat' => $id_penerima_surat,
        //             'arsip_digital_id' => $arsip_digital_id,
        //             'id_pengurus' => $request->akses_penerima_surat[$i],
        //             'status_baca' => '0',
        //         ]);

        //         $i++;
        //     }
        // }

        if ($request->js_tujuan == 'Ketua UPZIS MWCNU' || $request->js_tujuan == 'Koordinator PLPK se Cilacap' || $request->js_tujuan == 'Koordinator PLPK') {
            if ($request->akses_penerima_surat != NULL) {

                $i = 0;
                foreach ($request->akses_penerima_surat as $index) {
                    if ($request->akses_penerima_surat[$i]) {
                        $id_penerima_surat = uniqid();
                        PenerimaSurat::create([
                            'id_penerima_surat' => $id_penerima_surat,
                            'arsip_digital_id' => $arsip_digital_id,
                            'id_pengurus' => $request->akses_penerima_surat[$i],
                            'tujuan' => $request->tujuan_arsip,
                            'status_baca' => '0',
                        ]);
                    }

                    $i++;
                }
            }
        }

        if ($request->js_tujuan == 'Ketua PCNU Cilacap' || $request->js_tujuan == 'Kepala Kantor PCNU Cilacap' || $request->js_tujuan == 'Lainnya') {
            if ($request->akses_penerima_surat != NULL) {

                $aksesPenerimaSuratArray = $request->akses_penerima_surat;

                foreach ($aksesPenerimaSuratArray as $penerima) {
                    $penerimaArray = explode(',', $penerima);

                    foreach ($penerimaArray as $singlePenerima) {
                        $singlePenerima = trim($singlePenerima);
                        if ($singlePenerima) {
                            $id_penerima_surat = uniqid();
                            PenerimaSurat::create([
                                'id_penerima_surat' => $id_penerima_surat,
                                'arsip_digital_id' => $arsip_digital_id,
                                'penerima_lainnya' => $singlePenerima,
                                'tujuan' => $request->tujuan_arsip,
                                'status_baca' => '0',
                            ]);
                        }
                    }
                }
            }
        }



        //Nanti DI UNCOMMENT LAGI
        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $posts2 =  Pengguna::whereIn('gocap_id_upzis_pengurus', $request->akses_penerima_surat)->select('nohp', 'nama', 'gocap_id_pc_pengurus', 'gocap_id_upzis_pengurus')->get();
            $earsip = config('app.database_earsip');
            $siftnu = config('app.database_siftnu');
            $gocap = config('app.database_gocap');

            $url = 'https://e-arsip.nucarecilacap.id/';

            foreach ($posts2 as $post2) {
                $wilayah1 =  UpzisPengurus::where('id_upzis_pengurus', $post2->gocap_id_upzis_pengurus)->select('id_upzis', 'id_pengurus_jabatan')->first();
                $wilayah2 = Upzis::where('id_upzis', $wilayah1->id_upzis)->select('id_wilayah')->first();
                $wilayah3 = Wilayah::where('id_wilayah', $wilayah2->id_wilayah)->first();
                $jabatan = PengurusJabatan::where('id_pengurus_jabatan', $wilayah1->id_pengurus_jabatan)->first();

                //DI KOMEN DULU JANGAN DI HAPUS
                $this->notif(
                    $post2->nohp,
                    "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" .
                        "Yth. " . "*" .  $post2->nama .  "*" . "\n" .
                        'Ketua UPZIS ' . $wilayah3->nama . "\n" . "\n" .
                        "Anda menerima surat keluar dengan rincian surat sebagai berikut: " . "\n" . "\n" .
                        "*" .  "Nomor"  . "*" .  "\n" .
                        $request->nomor_surat  . "\n" .
                        "*" .  "Tanggal"  . "*" .  "\n" .
                        \Carbon\Carbon::parse($request->tanggal_arsip)->isoFormat('D MMMM Y')  .  "\n" .
                        "*" .  "Pengirim"  . "*" .  "\n" .
                        Auth::user()->gocap_id_pc_pengurus .   "\n" .
                        Auth::user()->PcPengurus->PengurusJabatan->jabatan .   "\n" .
                        "*" .  "Perihal"  . "*" .  "\n" .
                        $request->perihal_isi_deskripsi . "\n" . "\n" .
                        "Mohon untuk segera dilihat melalui E-Arsip." . "\n" .
                        "Link : " . url($url) . "\n" .
                        "Panduan : Pilih Menu surat keluar > Oleh LAZISNU" . "\n" .
                        "Terimakasih."
                );
            };
        } else {
            $posts2 =  Pengguna::whereIn('gocap_id_upzis_pengurus', $request->akses_penerima_surat)->select('nohp', 'nama', 'gocap_id_pc_pengurus', 'gocap_id_upzis_pengurus')->get();
            $earsip = config('app.database_earsip');
            $siftnu = config('app.database_siftnu');
            $gocap = config('app.database_gocap');

            $url = 'https://e-arsip.nucarecilacap.id/';

            foreach ($posts2 as $post2) {
                $wilayah1 =  UpzisPengurus::where('id_upzis_pengurus', $post2->gocap_id_upzis_pengurus)->select('id_upzis', 'id_pengurus_jabatan')->first();
                $wilayah2 = Upzis::where('id_upzis', $wilayah1->id_upzis)->select('id_wilayah')->first();
                $wilayah3 = Wilayah::where('id_wilayah', $wilayah2->id_wilayah)->first();
                $jabatan = PengurusJabatan::where('id_pengurus_jabatan', $wilayah1->id_pengurus_jabatan)->first();

                //DI KOMEN DULU JANGAN DI HAPUS
                $this->notif(
                    $post2->nohp,
                    "Assalamualaikum Warahmatullahi Wabarakatuh" . "\n" .
                        "Yth. " . "*" .  $post2->nama .  "*" . "\n" .
                        'Ketua UPZIS ' . $wilayah3->nama . "\n" . "\n" .
                        "Anda menerima surat keluar dengan rincian surat sebagai berikut: " . "\n" . "\n" .
                        "*" .  "Nomor"  . "*" .  "\n" .
                        $request->nomor_surat  . "\n" .
                        "*" .  "Tanggal"  . "*" .  "\n" .
                        \Carbon\Carbon::parse($request->tanggal_arsip)->isoFormat('D MMMM Y')  .  "\n" .
                        "*" .  "Pengirim"  . "*" .  "\n" .
                        Auth::user()->gocap_id_pc_pengurus .   "\n" .
                        Auth::user()->UpzisPengurus->PengurusJabatan->jabatan .   "\n" .
                        "*" .  "Perihal"  . "*" .  "\n" .
                        $request->perihal_isi_deskripsi . "\n" . "\n" .
                        "Mohon untuk segera dilihat melalui E-Arsip." . "\n" .
                        "Link : " . url($url) . "\n" .
                        "Panduan : Pilih Menu surat keluar > Oleh LAZISNU" . "\n" .
                        "Terimakasih."
                );
            };
        }
        //Nanti DI UNCOMMENT LAGI BATAS AKHIR

        if ($request->js_tujuan == 'Lainnya') {
            $tujuan = $request->tujuan_lainnya;
        } else {
            $tujuan = $request->tujuan_arsip;
        }

        // terakhir yaitu create surat keluar
        if ($request->disposisi_ya == 'on') {
            if ($request->penerima_satuan == 'on') {


                // keluarkan ke tabel arsip_digital
                ArsipDigital::create([
                    'arsip_digital_id' => $arsip_digital_id,
                    'id_pengguna' => Auth::user()->id_pengguna,
                    'tanggal_arsip' => $request->tanggal_arsip,
                    'jenis_arsip' => 'Surat keluar',
                    'jenis_disposisi' => 'Satuan',
                    'nomor_surat' => $request->nomor_surat,
                    'klasifikasi_surat' => $request->klasifikasi_surat,
                    'tujuan_arsip' => $tujuan,
                    'pengirim_sumber' => $request->pengirim_sumber,
                    'perihal_isi_deskripsi' => $request->perihal_isi_deskripsi,
                    'isi_surat' => $request->isi_surat,
                    'no_urut' => $request->no_urut,
                    'jenis_surat_keluar'  => 'baru',
                    'diinput_oleh' => Auth::user()->gocap_id_pc_pengurus,
                    'alamat_pengirim' => $request->alamat_pengirim,
                    'keterangan_surat_masuk' => $request->keterangan_surat_masuk,
                    'keterangan_surat_keluar' => $request->keterangan_surat_keluar,
                ]);

                // keluarkan ke tabel disposisi dan sppd mwcnu

                if ($request->akses_satuan_upzis != NULL) {


                    $b = 0;
                    foreach ($request->akses_satuan_upzis as $index) {

                        $disposisi_id = uniqid();
                        $sppd_id = uniqid();
                        Disposisi::create([
                            'disposisi_id' => $disposisi_id,
                            'arsip_digital_id' => $arsip_digital_id,
                            'id_upzis' => $request->akses_satuan_upzis[$b],
                            'status_baca' => '0',
                            'sifat' => $request->sifat,
                            'perihal' => $request->perihal_disposisi,
                        ]);
                        if ($request->sppd_ya == 'on') {
                            Sppd::create([
                                'sppd_id' => $sppd_id,
                                'arsip_digital_id' => $arsip_digital_id,
                                'disposisi_id' => $disposisi_id,
                                'perihal' => $request->perihal_sppd,
                                'tgl_pelaksanaan' => $request->tgl_pelaksanaan,
                                'anggaran' => $anggaran,
                            ]);
                        }
                        $b++;
                    }
                }
                if ($request->akses_satuan_pc != NULL) {


                    $b = 0;
                    foreach ($request->akses_satuan_pc as $index) {

                        $disposisi_id = uniqid();
                        $sppd_id = uniqid();
                        Disposisi::create([
                            'disposisi_id' => $disposisi_id,
                            'arsip_digital_id' => $arsip_digital_id,
                            'id_pc' => $request->akses_satuan_pc[$b],
                            'status_baca' => '0',
                            'sifat' => $request->sifat,
                            'perihal' => $request->perihal_disposisi,
                        ]);
                        if ($request->sppd_ya == 'on') {
                            Sppd::create([
                                'sppd_id' => $sppd_id,
                                'arsip_digital_id' => $arsip_digital_id,
                                'disposisi_id' => $disposisi_id,
                                'perihal' => $request->perihal_sppd,
                                'tgl_pelaksanaan' => $request->tgl_pelaksanaan,
                                'anggaran' => $anggaran,
                            ]);
                        }
                        $b++;
                    }
                }
                if ($request->akses_satuan_ranting != NULL) {


                    $b = 0;
                    foreach ($request->akses_satuan_ranting as $index) {

                        $disposisi_id = uniqid();
                        $sppd_id = uniqid();
                        Disposisi::create([
                            'disposisi_id' => $disposisi_id,
                            'arsip_digital_id' => $arsip_digital_id,
                            'id_ranting' => $request->akses_satuan_ranting[$b],
                            'status_baca' => '0',
                            'sifat' => $request->sifat,
                            'perihal' => $request->perihal_disposisi,
                        ]);
                        if ($request->sppd_ya == 'on') {
                            Sppd::create([
                                'sppd_id' => $sppd_id,
                                'arsip_digital_id' => $arsip_digital_id,
                                'disposisi_id' => $disposisi_id,
                                'perihal' => $request->perihal_sppd,
                                'tgl_pelaksanaan' => $request->tgl_pelaksanaan,
                                'anggaran' => $anggaran,
                            ]);
                        }
                        $b++;
                    }
                }

                // keluarkan ke tabel disposisi dan sppd lembaga

            } elseif ($request->penerima_golongan == 'on') {


                ArsipDigital::create([
                    'arsip_digital_id' => $arsip_digital_id,
                    'id_pengguna' => Auth::user()->id_pengguna,
                    'tanggal_arsip' => $request->tanggal_arsip,
                    'jenis_arsip' => 'Surat keluar',
                    'jenis_disposisi' => 'Golongan',
                    'nomor_surat' => $request->nomor_surat,
                    'klasifikasi_surat' => $request->klasifikasi_surat,
                    'tujuan_arsip' => $tujuan,
                    'pengirim_sumber' => $request->pengirim_sumber,
                    'perihal_isi_deskripsi' => $request->perihal_isi_deskripsi,
                    'isi_surat' => $request->isi_surat,
                    'jenis_surat_keluar'  => 'baru',
                    'no_urut' => $request->no_urut,
                    'diinput_oleh' => Auth::user()->gocap_id_pc_pengurus,
                    'alamat_pengirim' => $request->alamat_pengirim,
                    'keterangan_surat_masuk' => $request->keterangan_surat_masuk,
                    'keterangan_surat_keluar' => $request->keterangan_surat_keluar,
                ]);



                if (Auth::user()->gocap_id_pc_pengurus != NULL) {
                    $upzis_all = Upzis::all()->pluck('id_upzis')->toArray();
                } elseif (Auth::user()->gocap_id_upzis_pengurus != NULL) {
                    $upzis_all = Upzis::all()->where('id_upzis', '!=', Auth::user()->UpzisPengurus->Upzis->id_upzis)->pluck('id_upzis')->toArray();
                }
                // keluarkan ke tabel disposisi dan sppd 
                if ($upzis == '1') {
                    $b = 0;
                    foreach ($upzis_all as $index) {
                        $disposisi_id = uniqid();
                        $sppd_id = uniqid();
                        Disposisi::create([
                            'disposisi_id' => $disposisi_id,
                            'arsip_digital_id' => $arsip_digital_id,
                            'id_upzis' => $upzis_all[$b],
                            'status_baca' => '0',
                            'sifat' => $request->sifat,
                            'perihal' => $request->perihal_disposisi,
                        ]);
                        if ($request->sppd_ya == 'on') {
                            Sppd::create([
                                'sppd_id' => $sppd_id,
                                'arsip_digital_id' => $arsip_digital_id,
                                'disposisi_id' => $disposisi_id,
                                'perihal' => $request->perihal_sppd,
                                'tgl_pelaksanaan' => $request->tgl_pelaksanaan,
                                'anggaran' => $anggaran,
                            ]);
                        }
                        $b++;
                    }
                }

                if (Auth::user()->gocap_id_pc_pengurus != NULL) {
                    $ranting_all = Ranting::all()->pluck('id_ranting')->toArray();
                } elseif (Auth::user()->gocap_id_upzis_pengurus != NULL) {
                    $ranting_all = Ranting::all()->where('id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)->pluck('id_ranting')->toArray();
                }
                if ($ranting == '1') {
                    $b = 0;
                    foreach ($ranting_all as $index) {
                        $disposisi_id = uniqid();
                        $sppd_id = uniqid();
                        Disposisi::create([
                            'disposisi_id' => $disposisi_id,
                            'arsip_digital_id' => $arsip_digital_id,
                            'id_ranting' => $ranting_all[$b],
                            'status_baca' => '0',
                            'sifat' => $request->sifat,
                            'perihal' => $request->perihal_disposisi,
                        ]);
                        if ($request->sppd_ya == 'on') {
                            Sppd::create([
                                'sppd_id' => $sppd_id,
                                'arsip_digital_id' => $arsip_digital_id,
                                'disposisi_id' => $disposisi_id,
                                'perihal' => $request->perihal_sppd,
                                'tgl_pelaksanaan' => $request->tgl_pelaksanaan,
                                'anggaran' => $anggaran,
                            ]);
                        }
                        $b++;
                    }
                }

                if (Auth::user()->gocap_id_pc_pengurus != NULL) {
                    $internal_all = PcPengurus::all()->where('id_pc', Auth::user()->PcPengurus->id_pc)->pluck('id_pc_pengurus')->toArray();
                } elseif (Auth::user()->gocap_id_upzis_pengurus != NULL) {
                    $internal_all = UpzisPengurus::all()->where('id_upzis', Auth::user()->UpzisPengurus->id_upzis)->pluck('id_upzis_pengurus')->toArray();
                }
                // keluarkan ke tabel disposisi 
                if ($internal == '1') {
                    $b = 0;
                    if (Auth::user()->gocap_id_pc_pengurus != NULL) {
                        foreach ($internal_all as $index) {
                            $disposisi_id = uniqid();
                            $sppd_id = uniqid();
                            Disposisi::create([
                                'disposisi_id' => $disposisi_id,
                                'arsip_digital_id' => $arsip_digital_id,
                                'id_pengurus_internal' => $internal_all[$b],
                                'status_baca' => '0',
                                'sifat' => $request->sifat,
                                'perihal' => $request->perihal_disposisi,
                            ]);
                            if ($request->sppd_ya == 'on') {
                                Sppd::create([
                                    'sppd_id' => $sppd_id,
                                    'arsip_digital_id' => $arsip_digital_id,
                                    'disposisi_id' => $disposisi_id,
                                    'perihal' => $request->perihal_sppd,
                                    'tgl_pelaksanaan' => $request->tgl_pelaksanaan,
                                    'anggaran' => $anggaran,
                                ]);
                            }
                            $b++;
                        }
                    } elseif (Auth::user()->gocap_id_upzis_pengurus != NULL) {
                        foreach ($internal_all as $index) {
                            $disposisi_id = uniqid();
                            $sppd_id = uniqid();
                            Disposisi::create([
                                'disposisi_id' => $disposisi_id,
                                'arsip_digital_id' => $arsip_digital_id,
                                'id_pengurus_internal' => $internal_all[$b],
                                'status_baca' => '0',
                                'sifat' => $request->sifat,
                                'perihal' => $request->perihal_disposisi,
                            ]);
                            if ($request->sppd_ya == 'on') {
                                Sppd::create([
                                    'sppd_id' => $sppd_id,
                                    'arsip_digital_id' => $arsip_digital_id,
                                    'disposisi_id' => $disposisi_id,
                                    'perihal' => $request->perihal_sppd,
                                    'tgl_pelaksanaan' => $request->tgl_pelaksanaan,
                                    'anggaran' => $anggaran,
                                ]);
                            }
                            $b++;
                        }
                    }
                }
            } elseif ($request->penerima_internal == 'on') {


                // keluarkan ke tabel arsip_digital
                ArsipDigital::create([
                    'arsip_digital_id' => $arsip_digital_id,
                    'id_pengguna' => Auth::user()->id_pengguna,
                    'tanggal_arsip' => $request->tanggal_arsip,
                    'jenis_arsip' => 'Surat keluar',
                    'jenis_disposisi' => 'Internal',
                    'nomor_surat' => $request->nomor_surat,
                    'klasifikasi_surat' => $request->klasifikasi_surat,
                    'tujuan_arsip' => $tujuan,
                    'pengirim_sumber' => $request->pengirim_sumber,
                    'perihal_isi_deskripsi' => $request->perihal_isi_deskripsi,
                    'isi_surat' => $request->isi_surat,
                    'jenis_surat_keluar'  => 'baru',
                    'no_urut' => $request->no_urut,
                    'diinput_oleh' => Auth::user()->gocap_id_pc_pengurus,
                    'alamat_pengirim' => $request->alamat_pengirim,
                    'keterangan_surat_masuk' => $request->keterangan_surat_masuk,
                    'keterangan_surat_keluar' => $request->keterangan_surat_keluar,
                ]);

                if (Auth::user()->gocap_id_pc_pengurus != null) {

                    // keluarkan ke tabel internal dan sppd internal
                    if ($request->akses_internal != NULL) {
                        $b = 0;
                        foreach ($request->akses_internal as $index) {
                            $disposisi_id = uniqid();
                            $sppd_id = uniqid();
                            Disposisi::create([
                                'disposisi_id' => $disposisi_id,
                                'arsip_digital_id' => $arsip_digital_id,
                                'id_pengurus_internal' => $request->akses_internal[$b],
                                'status_baca' => '0',
                                'sifat' => $request->sifat,
                                'perihal' => $request->perihal_disposisi,
                            ]);
                            if ($request->sppd_ya == 'on') {
                                Sppd::create([
                                    'sppd_id' => $sppd_id,
                                    'arsip_digital_id' => $arsip_digital_id,
                                    'disposisi_id' => $disposisi_id,
                                    'perihal' => $request->perihal_sppd,
                                    'tgl_pelaksanaan' => $request->tgl_pelaksanaan,
                                    'anggaran' => $anggaran,
                                ]);
                            }
                            $b++;
                        }
                    }
                }
                if (Auth::user()->gocap_id_upzis_pengurus != null) {

                    // keluarkan ke tabel internal dan sppd internal
                    if ($request->akses_internal != NULL) {
                        $b = 0;
                        foreach ($request->akses_internal as $index) {
                            $disposisi_id = uniqid();
                            $sppd_id = uniqid();
                            Disposisi::create([
                                'disposisi_id' => $disposisi_id,
                                'arsip_digital_id' => $arsip_digital_id,
                                'id_pengurus_internal' => $request->akses_internal[$b],
                                'status_baca' => '0',
                                'sifat' => $request->sifat,
                                'perihal' => $request->perihal_disposisi,
                            ]);
                            if ($request->sppd_ya == 'on') {
                                Sppd::create([
                                    'sppd_id' => $sppd_id,
                                    'arsip_digital_id' => $arsip_digital_id,
                                    'disposisi_id' => $disposisi_id,
                                    'perihal' => $request->perihal_sppd,
                                    'tgl_pelaksanaan' => $request->tgl_pelaksanaan,
                                    'anggaran' => $anggaran,
                                ]);
                            }
                            $b++;
                        }
                    }
                }
            }
        } elseif ($request->disposisi_tidak == 'on') {
            ArsipDigital::create([
                'arsip_digital_id' => $arsip_digital_id,
                'id_pengguna' => Auth::user()->id_pengguna,
                'tanggal_arsip' => $request->tanggal_arsip,
                'jenis_arsip' => 'Surat keluar',
                'jenis_disposisi' => 'Tidak Ada',
                'nomor_surat' => $request->nomor_surat,
                'klasifikasi_surat' => $request->klasifikasi_surat,
                'tujuan_arsip' => $tujuan,
                'pengirim_sumber' => $request->pengirim_sumber,
                'perihal_isi_deskripsi' => $request->perihal_isi_deskripsi,
                'isi_surat' => $request->isi_surat,
                'jenis_surat_keluar'  => 'baru',
                'no_urut' => $request->no_urut,
                'diinput_oleh' => Auth::user()->gocap_id_pc_pengurus,
                'alamat_pengirim' => $request->alamat_pengirim,
                'keterangan_surat_masuk' => $request->keterangan_surat_masuk,
                'keterangan_surat_keluar' => $request->keterangan_surat_keluar,
            ]);
        }

        if ($request->scan_surat != null && $request->nama_surat != null) {
            $file = $request->file('scan_surat');
            $ext_logo = $file->extension();
            $filename_scan = $file->storeAs('/lampiran', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext_logo, ['disk' => 'lampiran']);
            LampiranArsip::create([
                'lampiran_arsip_id' => uniqid(),
                'arsip_digital_id' => $arsip_digital_id,
                'nama' => $request->nama_surat,
                'jenis' => 'Scan Surat',
                'file' => $filename_scan,
            ]);

            if ($request->lampiran != null &&  $request->nama != null) {
                if ($request->nama && count($request->nama) > 0) {
                    $a = 0;
                    foreach ($request->file('lampiran') as $index) {

                        $file = $index;
                        $ext_logo = $file->extension();

                        $filename_lampiran = $file->storeAs('/lampiran', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext_logo, ['disk' => 'lampiran']);
                        $validatedData['lampiran_arsip_id'] = uniqid();
                        $validatedData['arsip_digital_id'] = $arsip_digital_id;
                        $validatedData['nama'] = $request->nama[$a];
                        $validatedData['jenis'] = 'Lampiran';
                        $validatedData['file'] = $filename_lampiran;
                        LampiranArsip::create($validatedData);
                        $a++;
                    }
                }
            }
        }


        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('Surat Keluar ' . $cek . ' Berhasil Ditambahkan');

        if (Auth::user()->gocap_id_pc_pengurus != null) {
            return redirect('/' . $request->role . '/arsip/detail_surat_keluar/' . $arsip_digital_id . '/pc')->with('success', 'Data berhasil ditambahkan');
        } elseif (Auth::user()->gocap_id_upzis_pengurus != null) {
            return redirect('/' . $request->role . '/arsip/detail_surat_keluar/' . $arsip_digital_id . '/upzis')->with('success', 'Data berhasil ditambahkan');
        }
    }

    public function proses_edit_surat_keluar(Request $request, $id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        // $request->validate([
        //     'tanggal_arsip' => 'required',
        //     'nomor_surat' => 'required',
        //     'klasifikasi_surat' => 'required',
        //     'tujuan_arsip' => 'required',
        //     'pengirim_sumber' => 'required',
        // ], [
        //     'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
        //     'nomor_surat.required' => 'Nomor Surat harus diisi',
        //     'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
        //     'tujuan_arsip.required' => 'Tujuan Surat harus diisi',
        //     'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
        // ]);

        $js =   DB::table('arsip_digital')->where('arsip_digital_id', $id)->select('jenis_surat_keluar')->first();

        if ($js->jenis_surat_keluar == 'baru') {
            DB::table('arsip_digital')->where('arsip_digital_id', $id)->update([
                'nomor_surat' => $request->nomor_surat,
                'klasifikasi_surat' => $request->klasifikasi_surat,
                'tujuan_arsip' => $request->tujuan_arsip,
                'perihal_isi_deskripsi' => $request->perihal_isi_deskripsi,
                'isi_surat' => $request->isi_surat,

            ]);
        } else {
            DB::table('arsip_digital')->where('arsip_digital_id', $id)->update([
                'nomor_surat' => $request->nomor_surat,
                'klasifikasi_surat' => $request->klasifikasi_surat,
                'tujuan_arsip' => $request->tujuan_arsip,
                'perihal_isi_deskripsi' => $request->perihal_isi_deskripsi,
            ]);
        }


        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('Surat Keluar ' . $cek . ' Berhasil Diubah');

        return Redirect()->back()->with('success', 'Data berhasil diubah');
    }

    public function hapus_surat_keluar($id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');


        $lampiran_arsip = LampiranArsip::where('arsip_digital_id', $id)->get();
        if ($lampiran_arsip != NULL) {
            foreach ($lampiran_arsip as $a) {
                $path = public_path() . "/lampiran/" .  $a->file;
                if (file_exists($path)) {
                    unlink($path);
                }
            }
        }


        ArsipDigital::where('arsip_digital_id', $id)->delete();
        Disposisi::where('arsip_digital_id', $id)->delete();
        Sppd::where('arsip_digital_id', $id)->delete();
        LampiranArsip::where('arsip_digital_id', $id)->delete();
        PenerimaSurat::where('arsip_digital_id', $id)->delete();


        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('Surat Keluar ' . $cek . ' Berhasil Dihapus');
        if (Auth::user()->gocap_id_pc_pengurus != null) {
            return redirect('/pc/arsip/surat_keluar_pc/pc');
        } elseif (Auth::user()->gocap_id_upzis_pengurus != null) {
            return redirect('/upzis/arsip/surat_keluar_upzis/upzis');
        }
    }

    public function hapus_surat_masuk($id)
    {

        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        $lampiran_arsip = LampiranArsip::where('arsip_digital_id', $id)->get();
        if ($lampiran_arsip != NULL) {
            foreach ($lampiran_arsip as $a) {
                $path = public_path() . "/lampiran/" .  $a->file;
                if (file_exists($path)) {
                    unlink($path);
                }
            }
        }

        ArsipDigital::where('arsip_digital_id', $id)->delete();
        Disposisi::where('arsip_digital_id', $id)->delete();
        Sppd::where('arsip_digital_id', $id)->delete();
        LampiranArsip::where('arsip_digital_id', $id)->delete();

        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('Surat Keluar ' . $cek . ' Berhasil Dihapus');
        if (Auth::user()->gocap_id_pc_pengurus != null) {
            return redirect('/pc/arsip/surat_masuk_pc/pc');
        } elseif (Auth::user()->gocap_id_upzis_pengurus != null) {
            return redirect('/upzis/arsip/surat_masuk_upzis/upzis');
        }
    }

    public function aksi_tambah_penerima_surat(Request $request)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        // dd('dew');
        $arsip_digital_id = $request->arsip_id;

        if ($request->js_tujuan == 'Ketua UPZIS MWCNU' || $request->js_tujuan == 'Koordinator PLPK se Cilacap'  || $request->js_tujuan == 'Koordinator PLPK') {
            if ($request->akses_penerima_surat != NULL) {

                $i = 0;
                foreach ($request->akses_penerima_surat as $index) {
                    if ($request->akses_penerima_surat[$i]) {
                        $id_penerima_surat = uniqid();
                        PenerimaSurat::create([
                            'id_penerima_surat' => $id_penerima_surat,
                            'arsip_digital_id' => $arsip_digital_id,
                            'id_pengurus' => $request->akses_penerima_surat[$i],
                            'tujuan' => $request->js_tujuan,
                            'status_baca' => '0',
                        ]);
                    }

                    $i++;
                }
            }
        }

        if ($request->js_tujuan == 'Ketua PCNU Cilacap' || $request->js_tujuan == 'Kepala Kantor PCNU Cilacap' || $request->js_tujuan == 'Lainnya') {
            if ($request->akses_penerima_surat != NULL) {

                $aksesPenerimaSuratArray = $request->akses_penerima_surat;

                foreach ($aksesPenerimaSuratArray as $penerima) {
                    $penerimaArray = explode(',', $penerima);

                    foreach ($penerimaArray as $singlePenerima) {
                        $singlePenerima = trim($singlePenerima);
                        if ($singlePenerima) {
                            $id_penerima_surat = uniqid();
                            PenerimaSurat::create([
                                'id_penerima_surat' => $id_penerima_surat,
                                'arsip_digital_id' => $arsip_digital_id,
                                'penerima_lainnya' => $singlePenerima,
                                'tujuan' => $request->js_tujuan,
                                'status_baca' => '0',
                            ]);
                        }
                    }
                }
            }
        }

        // if ($request->akses_penerima_surat != NULL) {

        //     $i = 0;
        //     foreach ($request->akses_penerima_surat as $index) {
        //         PenerimaSurat::create([
        //             'id_penerima_surat' => uniqid(),
        //             'arsip_digital_id' => $request->arsip_digital_id,
        //             'id_pengurus' => $request->akses_penerima_surat[$i],
        //             'status_baca' => '0',
        //         ]);

        //         $i++;
        //     }
        // }

        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('Penerima Surat ' . $cek . ' Berhasil Ditambahkan');

        return back()->with('success', 'Data berhasil ditambahkan');
    }

    public function  aksi_hapus_penerima_surat(Request $request, $id)
    {

        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        PenerimaSurat::where('id_penerima_surat', $id)->delete();


        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('Penerima Surat ' . $cek . ' Berhasil Dihapus');
        return back();
    }
}
