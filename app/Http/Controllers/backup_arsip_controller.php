<?php

namespace App\Http\Controllers;

use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Pc;
use App\Models\Ttd;
use App\Models\Memo;
use App\Models\Sppd;
use App\Models\Upzis;
use App\Models\Berita;
use App\Models\Ranting;
use App\Models\FileMemo;
use App\Models\Pengguna;
use App\Models\Disposisi;
use App\Models\FileBerita;
use App\Models\PcPengurus;
use Illuminate\Support\Str;
use App\Models\ArsipDigital;
use Illuminate\Http\Request;
use App\Models\LampiranArsip;
use App\Models\UpzisPengurus;
use App\Models\KategoriBerita;
use App\Models\PengurusJabatan;
use App\Models\Wilayah;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



class ArsipDigitalController extends Controller
{

    public function __construct()
    {
        view()->composer('*', function ($view) {

            $earsip = config('app.database_earsip');
            $siftnu = config('app.database_siftnu');
            $gocap = config('app.database_gocap');

            if (Auth::user()->gocap_id_pc_pengurus != NULL) {

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
                $wilayah = Pengguna::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $siftnu . '.pengguna.id_wilayah')->where('pengguna.id_wilayah', Auth::user()->id_wilayah)->select('wilayah.nama')->first();
            } elseif (Auth::user()->gocap_id_upzis_pengurus != NULL) {
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
                $wilayah = Pengguna::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $siftnu . '.pengguna.id_wilayah')->where('pengguna.id_wilayah', Auth::user()->id_wilayah)->select('wilayah.nama')->first();
            } elseif (Auth::user()->gocap_id_ranting_pengurus != NULL) {
                $id = Auth::user()->gocap_id_ranting_pengurus;
                $role = 'ranting';
                $ranting = '';
                $nama = 'RANTING';
                $upzis = '';
                $kategori = DB::table('kategori_aset')->where('id_pengguna', Auth::user()->id_pengguna)->get();
                $pengurus = '';
                $tahun_perolehan = DB::table('aset')->select('tahun_perolehan')->groupBy('tahun_perolehan')->get();
                $wilayah = Pengguna::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $siftnu . '.pengguna.id_wilayah')->where('pengguna.id_wilayah', Auth::user()->id_wilayah)->select('wilayah.nama')->first();
            }

            $akses = ['Akses Internal', 'Akses Upzis', 'Akses Ranting'];

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
                ->with('pengurus', $pengurus);
        });
    }

    public function tambah_surat_masuk()
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $title = 'ARSIP SURAT';
        $page = "Tambah Surat Masuk";


        return view('arsip.tambah_surat', compact('page', 'title'));
    }

    public function memo()
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $title = 'MEMO INTERNAL';
        $page = "Memo Internal";


        $memo = DB::table('memo')->join($siftnu . '.pengguna', $siftnu . '.pengguna.id_pengguna', '=', $earsip . '.memo.id_pengguna')
            ->select('memo.*', $siftnu . '.pengguna.nama', $siftnu . '.pengguna.gocap_id_pc_pengurus')
            ->orderby('created_at', 'desc')
            ->get();



        return view('memo.memo', compact('page', 'title', 'memo'));
    }

    public function berita()
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $title = 'ARSIP BERITA';
        $page = "Arsip Berita";
        $kategori_berita = DB::table('kategori_berita')->where('id_pengguna', Auth::user()->id_pengguna)->orderby('created_at', 'desc')->get();
        $berita = DB::table('berita')->where('id_pengguna', Auth::user()->id_pengguna)->orderby('created_at', 'desc')->get();
        return view('arsip.berita', compact('page', 'title', 'berita', 'kategori_berita'));
    }

    public function tambah_berita()
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $title = 'ARSIP BERITA';
        $page = "Tambah Arsip Berita";
        $kategori_berita = DB::table('kategori_berita')->where('id_pengguna', Auth::user()->id_pengguna)->orderby('created_at', 'desc')->get();
        return view('arsip.tambah_berita', compact('page', 'title', 'kategori_berita'));
    }

    public function tambah_memo()
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $title = 'MEMO INTERNAL';
        $page = "Tambah Memo Internal";
        $kategori_berita = DB::table('kategori_berita')->where('id_pengguna', Auth::user()->id_pengguna)->orderby('created_at', 'desc')->get();
        return view('memo.tambah_memo', compact('page', 'title', 'kategori_berita'));
    }

    public function kategori_berita()
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $title = 'ARSIP BERITA';
        $page = "Kategori Berita";
        $kategori_berita = DB::table('kategori_berita')->where('id_pengguna', Auth::user()->id_pengguna)->orderby('created_at', 'desc')->get();
        return view('arsip.kategori_berita', compact('page', 'title', 'kategori_berita'));
    }


    public function dokumen_digital_pc(Request $request, $id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $id = $id;
        // dd(Auth::user()->id);
        $title = 'ARSIP DOKUMEN';
        $link = 'dokumen_digital';
        $page = "Dokumen Digital";

        if ($id == 'pc') {
            $hal = 'pc';
            $part = "pc_dokumen";
            $head = "Lazisnu";
            $dokumen_diterima = DB::table('arsip_digital')
                ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                ->where('arsip_digital.jenis_arsip', 'Dokumen Digital')->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                ->distinct('arsip_digital.arsip_digital_id')
                ->select('arsip_digital.*')->orderby('created_at', 'desc')
                ->get();

            $dokumen_dikirim = DB::table('arsip_digital')
                ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                ->where('arsip_digital.jenis_arsip', 'Dokumen Digital')->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                ->distinct('arsip_digital.arsip_digital_id')
                ->select('arsip_digital.*')->orderby('created_at', 'desc')
                ->get();
        }


        if ($id == 'upzis') {

            $hal = 'upzis';
            $part = "upzis_dokumen";
            $head = "Upzis";

            $dokumen_diterima = DB::table('arsip_digital')
                ->join('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                ->where('arsip_digital.jenis_arsip', 'Dokumen Digital')->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                ->where('disposisi.id_pc', Auth::user()->PcPengurus->Pc->id_pc)
                ->select('arsip_digital.*')
                ->distinct('arsip_digital.arsip_digital_id')
                ->orderby('created_at', 'desc')
                ->get();

            $dokumen_dikirim = DB::table('arsip_digital')
                ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                ->where('arsip_digital.jenis_arsip', 'Dokumen Digital')->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                ->select('arsip_digital.*')
                ->distinct('arsip_digital.arsip_digital_id')
                ->orderby('created_at', 'desc')
                ->get();
        }



        return view('arsip.dokumen', compact('dokumen_diterima', 'dokumen_dikirim', 'page', 'part', 'id', 'title', 'link', 'head', 'hal'));
    }

    public function dokumen_digital_upzis(Request $request, $id)
    {

        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $id = $id;
        // dd(Auth::user()->id);
        $title = 'ARSIP DOKUMEN';
        $link = 'dokumen_digital';
        $page = "Dokumen Digital";

        // DB::table('pengurus')
        //     ->join('jabatan', 'pengurus.jabatan_id', '=', 'jabatan.jabatan_id')
        //     ->where('pengurus.mwcnu_id', $id)
        //     ->get();


        if ($id == 'pc') {
            $hal = 'pc';
            $part = "pc_dokumen";
            $head = "Lazisnu";
            $dokumen_diterima = DB::table('arsip_digital')
                ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                ->where('arsip_digital.jenis_arsip', 'Dokumen Digital')->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                ->distinct('arsip_digital.arsip_digital_id')
                ->select('arsip_digital.*')->orderby('created_at', 'desc')
                ->get();

            $dokumen_dikirim = DB::table('arsip_digital')
                ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                ->where('arsip_digital.jenis_arsip', 'Dokumen Digital')->where('pengirim_sumber', 'like', "%" . 'PC' . "%")
                ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                ->distinct('arsip_digital.arsip_digital_id')
                ->select('arsip_digital.*')->orderby('created_at', 'desc')
                ->get();
        }


        if ($id == 'upzis') {

            $hal = 'upzis';
            $part = "upzis_dokumen";
            $head = "Upzis";

            $dokumen_diterima = DB::table('arsip_digital')
                ->join('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                ->where('arsip_digital.jenis_arsip', 'Dokumen Digital')->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")
                ->select('arsip_digital.*')
                ->distinct('arsip_digital.arsip_digital_id')
                ->orderby('created_at', 'desc')
                ->get();

            $dokumen_dikirim = DB::table('arsip_digital')
                ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                ->where('arsip_digital.jenis_arsip', 'Dokumen Digital')
                ->where('pengirim_sumber', 'like', "%" . 'Upzis' . "%")->where('id_pengguna', Auth::user()->id_pengguna)
                ->select('arsip_digital.*')
                ->distinct('arsip_digital.arsip_digital_id')
                ->orderby('created_at', 'desc')
                ->get();
        }



        return view('arsip.dokumen', compact('dokumen_diterima', 'dokumen_dikirim', 'page', 'part', 'id', 'title', 'link', 'head', 'hal'));
    }

    public function surat_masuk_pc(Request $request, $id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $id = $id;
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



        return view('arsip.surat_masuk', compact('arsip_diterima', 'arsip_dikirim', 'page', 'part', 'id', 'title', 'link', 'head', 'hal'));
    }

    public function surat_masuk_upzis(Request $request, $id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $id = $id;
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



        return view('arsip.surat_masuk', compact('arsip_diterima', 'arsip_dikirim', 'page', 'part', 'id', 'title', 'link', 'head', 'hal'));
    }

    public function surat_keluar_pc(Request $request, $id)
    {
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
                ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
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



        return view('arsip.surat_keluar', compact('arsip_diterima', 'arsip_dikirim', 'page', 'part', 'id', 'title', 'link', 'head', 'hal'));
    }

    public function surat_keluar_upzis(Request $request, $id)
    {
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



        return view('arsip.surat_keluar', compact('arsip_diterima', 'arsip_dikirim', 'page', 'part', 'id', 'title', 'link', 'head', 'hal'));
    }


    public function tambah_dokumen_digital()
    {

        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $page = "Tambah Dokumen Digital";
        $title = 'ARSIP DOKUMEN';
        $link = 'dokumen_digital';

        return view('arsip.tambah_dokumen', compact('page', 'title', 'link'));
    }


    public function tambah_surat_keluar()
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $title = 'ARSIP SURAT';
        $stat = '0';
        $page = "Tambah Surat Keluar";

        return view('arsip.tambah_surat_keluar', compact('page', 'stat', 'title'));
    }


    public function tambah_surat_keluar_baru()
    {

        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        // $yang_bertandatangan = PcPengurus::where('id_pc', Auth::user()->PcPengurus->Pc->id_pc)
        //     ->join($siftnu . '.pengguna', $siftnu . '.pengguna.gocap_id_pc_pengurus', '=', $gocap . '.pc_pengurus.id_pc_pengurus')
        //     ->where($gocap . '.pc_pengurus.tanggal_selesai_jabatan', '>=', date('Y-m-d'))
        //     ->where($gocap . '.pc_pengurus.tanggal_mulai_jabatan', '<=', date('Y-m-d'))
        //     ->where($gocap . '.pc_pengurus.id_pc_pengurus', '!=', Auth::user()->PcPengurus->id_pc_pengurus)
        //     ->get();
        // $jabatan = DB::connection('gocap')->table('pengurus_jabatan')->where('id_pengurus_jabatan', $ttd->id_pengurus_jabatan)->first();
        $title = 'Tambah Surat Keluar Baru';
        $page = "Surat Keluar";
        $stat = '1';
        return view('arsip.tambah_surat_keluar', compact('page', 'stat', 'title'));
    }


    public function hapus_dokumen_digital($id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        DB::table('arsip_digital')->where('arsip_digital_id', $id)->delete();
        return back()->with('success', 'Data berhasil dihapus');
    }

    public function detail_surat_masuk($id, $hal)
    {
        $hal = $hal;
        if ($hal == 'pc') {
            $act = 'pc_masuk';
        } else {
            $act = 'upzis_masuk';
        }
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $id_arsip = $id;

        $title = 'ARSIP SURAT';
        $arsip = DB::table('arsip_digital')->where('arsip_digital_id', $id)->first();
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


        $disposisi = DB::table('disposisi')
            ->join('arsip_digital', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
            ->where('arsip_digital.arsip_digital_id', $arsip->arsip_digital_id)
            ->first();



        if (Auth::user()->gocap_id_pc_pengurus != NULL) {

            $baca_upzis =  Upzis::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.upzis.id_wilayah')
                ->join($earsip . '.disposisi', $earsip . '.disposisi.id_upzis', '=', $gocap . '.upzis.id_upzis')
                ->where('disposisi.arsip_digital_id', '=', $id_arsip)
                ->select($siftnu . '.wilayah.nama', $earsip . '.disposisi.status_baca')->get();

            $baca_internal =  Disposisi::join($siftnu . '.pengguna', $siftnu . '.pengguna.gocap_id_pc_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->join($gocap . '.pc_pengurus', $gocap . '.pc_pengurus.id_pc_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->where('disposisi.arsip_digital_id', '=', $id_arsip)
                ->select($siftnu . '.pengguna.nama', $earsip . '.disposisi.status_baca', $gocap . '.pc_pengurus.id_pengurus_jabatan')->get();

            $baca_pc =  Pc::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.pc.id_wilayah')
                ->join($earsip . '.disposisi', $earsip . '.disposisi.id_pc', '=', $gocap . '.pc.id_pc')
                ->where('disposisi.arsip_digital_id', '=', $id_arsip)
                ->select($siftnu . '.wilayah.nama', $earsip . '.disposisi.status_baca')->get();


            $baca_ranting =  Ranting::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.ranting.id_wilayah')
                ->join($earsip . '.disposisi', $earsip . '.disposisi.id_ranting', '=', $gocap . '.ranting.id_ranting')
                ->where('disposisi.arsip_digital_id', '=', $id_arsip)
                ->select($siftnu . '.wilayah.nama', $earsip . '.disposisi.status_baca')->get();
        }


        if (Auth::user()->gocap_id_upzis_pengurus != NULL) {


            $baca_upzis =  Upzis::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.upzis.id_wilayah')
                ->join($earsip . '.disposisi', $earsip . '.disposisi.id_upzis', '=', $gocap . '.upzis.id_upzis')
                ->where('disposisi.arsip_digital_id', '=', $id_arsip)
                ->select($siftnu . '.wilayah.nama', $earsip . '.disposisi.status_baca')->get();

            $baca_pc =  Pc::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.pc.id_wilayah')
                ->join($earsip . '.disposisi', $earsip . '.disposisi.id_pc', '=', $gocap . '.pc.id_pc')
                ->where('disposisi.arsip_digital_id', '=', $id_arsip)
                ->select($siftnu . '.wilayah.nama', $earsip . '.disposisi.status_baca')->get();


            $baca_ranting =  Ranting::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.ranting.id_wilayah')
                ->join($earsip . '.disposisi', $earsip . '.disposisi.id_ranting', '=', $gocap . '.ranting.id_ranting')
                ->where('disposisi.arsip_digital_id', '=', $id_arsip)
                ->select($siftnu . '.wilayah.nama', $earsip . '.disposisi.status_baca')->get();

            $baca_internal =  Disposisi::join($siftnu . '.pengguna', $siftnu . '.pengguna.gocap_id_upzis_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->join($gocap . '.upzis_pengurus', $gocap . '.upzis_pengurus.id_upzis_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->where('disposisi.arsip_digital_id', '=', $id_arsip)
                ->select($siftnu . '.pengguna.nama', $earsip . '.disposisi.status_baca', $gocap . '.upzis_pengurus.id_pengurus_jabatan')->get();
        }


        if (DB::table('arsip_digital')->where('jenis_arsip', 'Surat Masuk')->where('id_pengguna', Auth::user()->id_pengguna)->where('arsip_digital_id', $arsip->arsip_digital_id)->first()) {
            $info = 'Diteruskan';
            $stat = 'Diteruskan';
        } else {
            $info = 'Diterima';
            $stat = 'Diterima';
        }
        return view('arsip.detail_surat', compact('act', 'hal', 'stat', 'info', 'baca_pc', 'baca_ranting', 'arsip', 'page', 'lampiran', 'id_arsip', 'lampiran_file', 'sppd', 'disposisi',  'title', 'baca_upzis', 'baca_internal'));
    }

    public function detail_memo($id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        $kepada = DB::table('disposisi')->where('id_memo', $id)->get();
        $id_memo = $id;

        $title = 'MEMO INTERNAL';
        $memo = DB::table('memo')->where('id_memo', $id)->first();
        $page = "Detail Memo Internal";
        $lampiran = DB::table('memo')->join('file_memo', 'memo.id_memo', '=', 'file_memo.id_memo')->where('memo.id_memo', $id)->get();
        $lampiran_file = DB::table('memo')->join('file_memo', 'memo.id_memo', '=', 'file_memo.id_memo')->where('memo.id_memo', $id)->count();

        $nama_pengurus =  Memo::join($siftnu . '.pengguna', $siftnu . '.pengguna.id_pengguna', '=', $earsip . '.memo.id_pengguna')->first();

        // $arsip = DB::table('disposisi')->where('id_memo', $id)->get();
        // $internal = explode(' , ', $arsip->id_pengurus_internal); //kalau aray pakai ini (multiple select)

        $initPermissions = DB::table('disposisi')->where('id_memo', $id)->pluck('id_pengurus_internal')->toArray(); //gak dipakai tapi kalau bukan array pakai ini(multiple select)


        $sppd = DB::table('sppd')
            ->join('memo', 'memo.id_memo', '=', 'sppd.id_memo')
            ->where('sppd.id_memo', $id)->select('sppd.*')
            ->first();


        $disposisi = DB::table('disposisi')
            ->join('memo', 'memo.id_memo', '=', 'disposisi.id_memo')
            ->where('memo.id_memo', $id)
            ->first();



        if (Auth::user()->gocap_id_pc_pengurus != NULL) {


            $subjab =  Memo::join($siftnu . '.pengguna', $siftnu . '.pengguna.id_pengguna', '=', $earsip . '.memo.id_pengguna')
                ->where($earsip . '.memo.id_memo', '=', $id)->select($siftnu . '.pengguna.gocap_id_pc_pengurus')->first();

            $jabatan = PcPengurus::where('id_pc_pengurus', $subjab->gocap_id_pc_pengurus)->select('id_pengurus_jabatan')->first();

            $detail_jabatan = PengurusJabatan::where('id_pengurus_jabatan', $jabatan->id_pengurus_jabatan)->select('jabatan')->get();

            $baca_internal =  Disposisi::join($siftnu . '.pengguna', $siftnu . '.pengguna.gocap_id_pc_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->join($gocap . '.pc_pengurus', $gocap . '.pc_pengurus.id_pc_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->where('disposisi.id_memo', '=', $id_memo)
                ->select($siftnu . '.pengguna.nama', $earsip . '.disposisi.status_baca', $gocap . '.pc_pengurus.id_pengurus_jabatan')->get();

            $baca_internal_jumlah =  Disposisi::join($siftnu . '.pengguna', $siftnu . '.pengguna.gocap_id_pc_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->join($gocap . '.pc_pengurus', $gocap . '.pc_pengurus.id_pc_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->where('disposisi.id_memo', '=', $id_memo)
                ->select($siftnu . '.pengguna.nama', $earsip . '.disposisi.status_baca', $gocap . '.pc_pengurus.id_pengurus_jabatan')->count();
        }


        if (Auth::user()->gocap_id_upzis_pengurus != NULL) {

            $subjab =  Memo::join($siftnu . '.pengguna', $siftnu . '.pengguna.id_pengguna', '=', $earsip . '.memo.id_pengguna')
                ->where($earsip . '.memo.id_memo', '=', $id)->select($siftnu . '.pengguna.gocap_id_upzis_pengurus')->first();

            $jabatan = UpzisPengurus::where('id_upzis_pengurus', $subjab->gocap_id_upzis_pengurus)->select('id_pengurus_jabatan')->first();

            $detail_jabatan = PengurusJabatan::where('id_pengurus_jabatan', $jabatan->id_pengurus_jabatan)->select('jabatan')->get();

            $baca_internal =  Disposisi::join($siftnu . '.pengguna', $siftnu . '.pengguna.gocap_id_upzis_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->join($gocap . '.upzis_pengurus', $gocap . '.upzis_pengurus.id_upzis_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->where('disposisi.id_memo', '=', $id_memo)
                ->select($siftnu . '.pengguna.nama', $earsip . '.disposisi.status_baca', $gocap . '.upzis_pengurus.id_pengurus_jabatan')->get();

            $baca_internal_jumlah =  Disposisi::join($siftnu . '.pengguna', $siftnu . '.pengguna.gocap_id_upzis_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->join($gocap . '.upzis_pengurus', $gocap . '.upzis_pengurus.id_upzis_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->where('disposisi.id_memo', '=', $id_memo)
                ->select($siftnu . '.pengguna.nama', $earsip . '.disposisi.status_baca', $gocap . '.upzis_pengurus.id_pengurus_jabatan')->count();
        }


        if (DB::table('memo')->where('id_pengguna', Auth::user()->id_pengguna)->where('id_memo', $memo->id_memo)->first()) {
            $info = 'Diteruskan';
        } else {
            $info = 'Diterima';
        }
        return view('memo.detail_memo', compact('kepada', 'initPermissions', 'detail_jabatan', 'jabatan', 'baca_internal_jumlah', 'nama_pengurus', 'memo', 'page', 'lampiran', 'id_memo', 'lampiran_file', 'sppd', 'disposisi', 'title', 'baca_internal', 'info'));
    }


    public function detail_surat_keluar($id, $hal)
    {
        $hal = $hal;
        if ($hal == 'pc') {
            $act = 'pc_keluar';
        } else {
            $act = 'upzis_keluar';
        }
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $id_arsip = $id;

        $title = 'ARSIP SURAT';
        $arsip = DB::table('arsip_digital')->where('arsip_digital_id', $id)->first();
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



        if (Auth::user()->gocap_id_pc_pengurus != NULL) {

            $baca_upzis =  Upzis::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.upzis.id_wilayah')
                ->join($earsip . '.disposisi', $earsip . '.disposisi.id_upzis', '=', $gocap . '.upzis.id_upzis')
                ->where('disposisi.arsip_digital_id', '=', $id_arsip)
                ->select($siftnu . '.wilayah.nama', $earsip . '.disposisi.status_baca')->get();

            $baca_internal =  Disposisi::join($siftnu . '.pengguna', $siftnu . '.pengguna.gocap_id_pc_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->join($gocap . '.pc_pengurus', $gocap . '.pc_pengurus.id_pc_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->where('disposisi.arsip_digital_id', '=', $id_arsip)
                ->select($siftnu . '.pengguna.nama', $earsip . '.disposisi.status_baca', $gocap . '.pc_pengurus.id_pengurus_jabatan')->get();

            $baca_pc =  Pc::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.pc.id_wilayah')
                ->join($earsip . '.disposisi', $earsip . '.disposisi.id_pc', '=', $gocap . '.pc.id_pc')
                ->where('disposisi.arsip_digital_id', '=', $id_arsip)
                ->select($siftnu . '.wilayah.nama', $earsip . '.disposisi.status_baca')->get();


            $baca_ranting =  Ranting::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.ranting.id_wilayah')
                ->join($earsip . '.disposisi', $earsip . '.disposisi.id_ranting', '=', $gocap . '.ranting.id_ranting')
                ->where('disposisi.arsip_digital_id', '=', $id_arsip)
                ->select($siftnu . '.wilayah.nama', $earsip . '.disposisi.status_baca')->get();
        }


        if (Auth::user()->gocap_id_upzis_pengurus != NULL) {


            $baca_upzis =  Upzis::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.upzis.id_wilayah')
                ->join($earsip . '.disposisi', $earsip . '.disposisi.id_upzis', '=', $gocap . '.upzis.id_upzis')
                ->where('disposisi.arsip_digital_id', '=', $id_arsip)
                ->select($siftnu . '.wilayah.nama', $earsip . '.disposisi.status_baca')->get();

            $baca_pc =  Pc::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.pc.id_wilayah')
                ->join($earsip . '.disposisi', $earsip . '.disposisi.id_pc', '=', $gocap . '.pc.id_pc')
                ->where('disposisi.arsip_digital_id', '=', $id_arsip)
                ->select($siftnu . '.wilayah.nama', $earsip . '.disposisi.status_baca')->get();


            $baca_ranting =  Ranting::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.ranting.id_wilayah')
                ->join($earsip . '.disposisi', $earsip . '.disposisi.id_ranting', '=', $gocap . '.ranting.id_ranting')
                ->where('disposisi.arsip_digital_id', '=', $id_arsip)
                ->select($siftnu . '.wilayah.nama', $earsip . '.disposisi.status_baca')->get();

            $baca_internal =  Disposisi::join($siftnu . '.pengguna', $siftnu . '.pengguna.gocap_id_upzis_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->join($gocap . '.upzis_pengurus', $gocap . '.upzis_pengurus.id_upzis_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->where('disposisi.arsip_digital_id', '=', $id_arsip)
                ->select($siftnu . '.pengguna.nama', $earsip . '.disposisi.status_baca', $gocap . '.upzis_pengurus.id_pengurus_jabatan')->get();
        }


        if (DB::table('arsip_digital')->where('jenis_arsip', 'Surat Keluar')->where('id_pengguna', Auth::user()->id_pengguna)->where('arsip_digital_id', $arsip->arsip_digital_id)->first()) {
            $stat = 'Diteruskan';
            $info = 'Diteruskan';
        } else {
            $stat = 'Diterima';
            $info = 'Diterima';
        }
        return view('arsip.detail_surat_keluar', compact('act', 'hal', 'info', 'baca_pc', 'baca_ranting', 'arsip', 'page', 'lampiran', 'id_arsip', 'lampiran_file', 'sppd', 'disposisi', 'stat', 'title', 'baca_upzis', 'baca_internal'));
    }


    public function detail_dokumen_digital($id, $hal)
    {
        $halaman = $hal;
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $id_arsip = $id;
        $title = 'ARSIP DOKUMEN';

        $arsip = DB::table('arsip_digital')->where('arsip_digital_id', $id)->first();
        $page = "Tambah Dokumen Digital";
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



        if (Auth::user()->gocap_id_pc_pengurus != NULL) {

            $baca_upzis =  Upzis::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.upzis.id_wilayah')
                ->join($earsip . '.disposisi', $earsip . '.disposisi.id_upzis', '=', $gocap . '.upzis.id_upzis')
                ->where('disposisi.arsip_digital_id', '=', $id_arsip)
                ->select($siftnu . '.wilayah.nama', $earsip . '.disposisi.status_baca')->get();

            $baca_internal =  Disposisi::join($siftnu . '.pengguna', $siftnu . '.pengguna.gocap_id_pc_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->join($gocap . '.pc_pengurus', $gocap . '.pc_pengurus.id_pc_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->where('disposisi.arsip_digital_id', '=', $id_arsip)
                ->select($siftnu . '.pengguna.nama', $earsip . '.disposisi.status_baca', $gocap . '.pc_pengurus.id_pengurus_jabatan')->get();

            $baca_pc =  Pc::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.pc.id_wilayah')
                ->join($earsip . '.disposisi', $earsip . '.disposisi.id_pc', '=', $gocap . '.pc.id_pc')
                ->where('disposisi.arsip_digital_id', '=', $id_arsip)
                ->select($siftnu . '.wilayah.nama', $earsip . '.disposisi.status_baca')->get();


            $baca_ranting =  Ranting::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.ranting.id_wilayah')
                ->join($earsip . '.disposisi', $earsip . '.disposisi.id_ranting', '=', $gocap . '.ranting.id_ranting')
                ->where('disposisi.arsip_digital_id', '=', $id_arsip)
                ->select($siftnu . '.wilayah.nama', $earsip . '.disposisi.status_baca')->get();
        }


        if (Auth::user()->gocap_id_upzis_pengurus != NULL) {


            $baca_upzis =  Upzis::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.upzis.id_wilayah')
                ->join($earsip . '.disposisi', $earsip . '.disposisi.id_upzis', '=', $gocap . '.upzis.id_upzis')
                ->where('disposisi.arsip_digital_id', '=', $id_arsip)
                ->select($siftnu . '.wilayah.nama', $earsip . '.disposisi.status_baca')->get();

            $baca_pc =  Pc::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.pc.id_wilayah')
                ->join($earsip . '.disposisi', $earsip . '.disposisi.id_pc', '=', $gocap . '.pc.id_pc')
                ->where('disposisi.arsip_digital_id', '=', $id_arsip)
                ->select($siftnu . '.wilayah.nama', $earsip . '.disposisi.status_baca')->get();


            $baca_ranting =  Ranting::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.ranting.id_wilayah')
                ->join($earsip . '.disposisi', $earsip . '.disposisi.id_ranting', '=', $gocap . '.ranting.id_ranting')
                ->where('disposisi.arsip_digital_id', '=', $id_arsip)
                ->select($siftnu . '.wilayah.nama', $earsip . '.disposisi.status_baca')->get();

            $baca_internal =  Disposisi::join($siftnu . '.pengguna', $siftnu . '.pengguna.gocap_id_upzis_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->join($gocap . '.upzis_pengurus', $gocap . '.upzis_pengurus.id_upzis_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->where('disposisi.arsip_digital_id', '=', $id_arsip)
                ->select($siftnu . '.pengguna.nama', $earsip . '.disposisi.status_baca', $gocap . '.upzis_pengurus.id_pengurus_jabatan')->get();
        }


        if (DB::table('arsip_digital')->where('jenis_arsip', 'Dokumen Digital')->where('id_pengguna', Auth::user()->id_pengguna)->where('arsip_digital_id', $arsip->arsip_digital_id)->first()) {
            $stat = 'Diteruskan';
            $info = 'Diteruskan';
        } else {
            $stat = 'Diterima';
            $info = 'Diterima';
        }
        return view('arsip.detail_dokumen', compact('info', 'halaman', 'baca_pc', 'baca_ranting', 'arsip', 'page', 'lampiran', 'id_arsip', 'lampiran_file', 'sppd', 'disposisi', 'stat', 'title', 'baca_upzis', 'baca_internal'));
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
        //     'tanggal_arsip.required' => 'Tanggal Arsip harus diisi',
        //     'nomor_surat.required' => 'Nomor Surat harus diisi',
        //     'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
        //     'tujuan_arsip.required' => 'Tujuan Surat harus diisi',
        //     'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
        // ]);

        DB::table('arsip_digital')->where('arsip_digital_id', $id)->update([
            'nomor_surat' => $request->nomor_surat,
            'klasifikasi_surat' => $request->klasifikasi_surat,
            'pengirim_sumber' => $request->pengirim_sumber,
            'perihal_isi_deskripsi' => $request->perihal_isi_deskripsi,

        ]);

        return Redirect()->back()->with('success', 'Data berhasil diubah');
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

        return Redirect()->back()->with('success', 'Data berhasil diubah');
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

        return back()->withInput(['tab' => 'sppd']);
    }

    public function aksi_edit_dokumen_digital(Request $request, $id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $request->validate([
            'nama_dokumen' => 'required',
            'klasifikasi_dokumen' => 'required',
        ]);

        DB::table('arsip_digital')->where('arsip_digital_id', $id)->update([
            'nama_dokumen' => $request->nama_dokumen,
            'klasifikasi_dokumen' => $request->klasifikasi_dokumen,
            'perihal_isi_deskripsi' => $request->perihal_isi_deskripsi,

        ]);

        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $wilayah = Pengguna::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $siftnu . '.pengguna.id_wilayah')->where('pengguna.id_wilayah', Auth::user()->id_wilayah)->select('wilayah.nama')->first();
        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $cek = 'Upzis ' . $wilayah->nama;
        }
        alert()->success('Arsip Dokumen ' . $cek . ' Berhasil Diubah');
        return Redirect()->back();
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
        $wilayah = Pengguna::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $siftnu . '.pengguna.id_wilayah')->where('pengguna.id_wilayah', Auth::user()->id_wilayah)->select('wilayah.nama')->first();
        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $cek = 'Upzis ' . $wilayah->nama;
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
        $wilayah = Pengguna::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $siftnu . '.pengguna.id_wilayah')->where('pengguna.id_wilayah', Auth::user()->id_wilayah)->select('wilayah.nama')->first();
        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $cek = 'Upzis ' . $wilayah->nama;
        }
        alert()->success('Lampiran File ' . $cek . ' Berhasil Diubah');


        return back()->withInput(['tab' => 'file']);
    }

    public function aksi_hapus_lampiran(Request $request, $id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        LampiranArsip::where('lampiran_arsip_id', $id)->delete();


        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $wilayah = Pengguna::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $siftnu . '.pengguna.id_wilayah')->where('pengguna.id_wilayah', Auth::user()->id_wilayah)->select('wilayah.nama')->first();
        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $cek = 'Upzis ' . $wilayah->nama;
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

        // invalid untuk disposisi ya -> penerima satuan -> sppd ya
        if ($request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_ya == 'on') {
            $request->validate([
                // surat masuk
                'tanggal_arsip' => 'required',
                'nomor_surat' => 'required',
                'klasifikasi_surat' => 'required',
                'tujuan_arsip' => 'required',
                'pengirim_sumber' => 'required',
                // // akses
                // 'akses_satuan' => 'required',
                // disposisi
                'sifat' => 'required',
                // sppd
                'tgl_perintah' => 'required',
                'tgl_pelaksanaan' => 'required',
                'anggaran' => 'required',
            ], [
                'tanggal_arsip.required' => 'Tanggal Arsip harus diisi',
                'nomor_surat.required' => 'Nomor Surat harus diisi',
                'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
                'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                'akses_satuan.required' => 'Akses Satuan harus diisi',
                'sifat.required' => 'Sifat harus diisi',
                'tgl_perintah.required' => 'Tanggal Perintah harus diisi',
                'tgl_pelaksanaan.required' => 'Tanggal Pelaksanaan harus diisi',
                'anggaran.required' => 'Anggaran harus diisi',
            ]);
        }

        // invalid untuk disposisi ya -> penerima satuan -> sppd tidak
        if ($request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_tidak == 'on') {
            $request->validate([
                // surat masuk
                'tanggal_arsip' => 'required',
                'nomor_surat' => 'required',
                'klasifikasi_surat' => 'required',
                'tujuan_arsip' => 'required',
                'pengirim_sumber' => 'required',
                // // akses
                // 'akses_satuan' => 'required',
                // disposisi
                'sifat' => 'required',
            ], [
                'tanggal_arsip.required' => 'Tanggal Arsip harus diisi',
                'nomor_surat.required' => 'Nomor Surat harus diisi',
                'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                'tujuan_arsip.required' => 'Tujuan Surat harus diisi',
                'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                'akses_satuan.required' => 'Akses Satuan harus diisi',
                'sifat.required' => 'Sifat harus diisi',

            ]);
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
                // akses
                'akses_golongan' => 'required',
                // disposisi
                'sifat' => 'required',
                // sppd
                'tgl_perintah' => 'required',
                'tgl_pelaksanaan' => 'required',
                'anggaran' => 'required',
            ], [
                'tanggal_arsip.required' => 'Tanggal Arsip harus diisi',
                'nomor_surat.required' => 'Nomor Surat harus diisi',
                'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                'tujuan_arsip.required' => 'Tujuan Surat harus diisi',
                'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                'akses_golongan.required' => 'Akses Golongan harus diisi',
                'sifat.required' => 'Sifat harus diisi',
                'tgl_perintah.required' => 'Tanggal Perintah harus diisi',
                'tgl_pelaksanaan.required' => 'Tanggal Pelaksanaan harus diisi',
                'anggaran.required' => 'Anggaran harus diisi',
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
                // akses
                'akses_golongan' => 'required',
                // disposisi
                'sifat' => 'required',
            ], [
                'tanggal_arsip.required' => 'Tanggal Arsip harus diisi',
                'nomor_surat.required' => 'Nomor Surat harus diisi',
                'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                'tujuan_arsip.required' => 'Tujuan Surat harus diisi',
                'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                'akses_golongan.required' => 'Akses Golongan harus diisi',
                'sifat.required' => 'Sifat harus diisi',
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
                // // akses
                // 'akses_satuan' => 'required',
            ], [
                'tanggal_arsip.required' => 'Tanggal Arsip harus diisi',
                'nomor_surat.required' => 'Nomor Surat harus diisi',
                'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                'tujuan_arsip.required' => 'Tujuan Surat harus diisi',
                'pengirim_sumber.required' => 'Pengirim Surat harus diisi',

            ]);
        }


        if ($request->penerima_golongan == 'on') {


            $s = implode(',', $request->akses_golongan);
            $b = explode(',', $s);


            if (count(collect($b)) == 1) {
                if ($b[0] == 'Akses Internal') {
                    $internal = '1';
                    $upzis = '0';
                    $ranting = '0';
                } elseif ($b[0] == 'Akses Upzis') {
                    $internal = '0';
                    $upzis = '1';
                    $ranting = '0';
                } elseif ($b[0] == 'Akses Ranting') {
                    $internal = '0';
                    $upzis = '0';
                    $ranting = '1';
                }
            }

            if (count(collect($b)) == 2) {
                if ($b[0] == 'Akses Internal' && $b[1] == 'Akses Upzis') {
                    $internal = '1';
                    $upzis = '1';
                    $ranting = '0';
                } elseif ($b[0] == 'Akses Upzis' && $b[1] == 'Akses Internal') {
                    $internal = '1';
                    $upzis = '1';
                    $ranting = '0';
                } elseif ($b[0] == 'Akses Internal' && $b[1] == 'Akses Ranting') {
                    $internal = '1';
                    $upzis = '0';
                    $ranting = '1';
                } elseif ($b[0] == 'Akses Ranting' && $b[1] == 'Akses Internal') {
                    $internal = '1';
                    $upzis = '0';
                    $ranting = '1';
                } elseif ($b[0] == 'Akses Upzis' && $b[1] == 'Akses Ranting') {
                    $internal = '0';
                    $upzis = '1';
                    $ranting = '1';
                } elseif ($b[0] == 'Akses Ranting' && $b[1] == 'Akses Upzis') {
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
        // terakhir yaitu create surat masuk
        if ($request->disposisi_ya == 'on') {
            if ($request->penerima_satuan == 'on') {


                // masukkan ke tabel arsip_digital
                ArsipDigital::create([
                    'arsip_digital_id' => $arsip_digital_id,
                    'id_pengguna' => Auth::user()->id_pengguna,
                    'tanggal_arsip' => $request->tanggal_arsip,
                    'jenis_arsip' => 'Surat Masuk',
                    'jenis_disposisi' => 'Satuan',
                    'nomor_surat' => $request->nomor_surat,
                    'klasifikasi_surat' => $request->klasifikasi_surat,
                    'tujuan_arsip' => $request->tujuan_arsip,
                    'pengirim_sumber' => $request->pengirim_sumber,
                    'perihal_isi_deskripsi' => $request->perihal_isi_deskripsi,
                    'diinput_oleh' => Auth::user()->nama,
                ]);

                // masukkan ke tabel disposisi dan sppd mwcnu

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

                // masukkan ke tabel disposisi dan sppd lembaga

            } elseif ($request->penerima_golongan == 'on') {


                ArsipDigital::create([
                    'arsip_digital_id' => $arsip_digital_id,
                    'id_pengguna' => Auth::user()->id_pengguna,
                    'tanggal_arsip' => $request->tanggal_arsip,
                    'jenis_arsip' => 'Surat Masuk',
                    'jenis_disposisi' => 'Golongan',
                    'nomor_surat' => $request->nomor_surat,
                    'klasifikasi_surat' => $request->klasifikasi_surat,
                    'tujuan_arsip' => $request->tujuan_arsip,
                    'pengirim_sumber' => $request->pengirim_sumber,
                    'perihal_isi_deskripsi' => $request->perihal_isi_deskripsi,
                    'diinput_oleh' => Auth::user()->nama,
                ]);



                if (Auth::user()->gocap_id_pc_pengurus != NULL) {
                    $upzis_all = Upzis::all()->pluck('id_upzis')->toArray();
                } elseif (Auth::user()->gocap_id_upzis_pengurus != NULL) {
                    $upzis_all = Upzis::all()->where('id_upzis', '!=', Auth::user()->UpzisPengurus->Upzis->id_upzis)->pluck('id_upzis')->toArray();
                }
                // masukkan ke tabel disposisi dan sppd 
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
                // masukkan ke tabel disposisi 
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


                // masukkan ke tabel arsip_digital
                ArsipDigital::create([
                    'arsip_digital_id' => $arsip_digital_id,
                    'id_pengguna' => Auth::user()->id_pengguna,
                    'tanggal_arsip' => $request->tanggal_arsip,
                    'jenis_arsip' => 'Surat Masuk',
                    'jenis_disposisi' => 'Internal',
                    'nomor_surat' => $request->nomor_surat,
                    'klasifikasi_surat' => $request->klasifikasi_surat,
                    'tujuan_arsip' => $request->tujuan_arsip,
                    'pengirim_sumber' => $request->pengirim_sumber,
                    'perihal_isi_deskripsi' => $request->perihal_isi_deskripsi,
                    'isi_surat' => $request->isi_surat,
                    'diinput_oleh' => Auth::user()->nama,
                ]);

                if (Auth::user()->gocap_id_pc_pengurus != null) {

                    // masukkan ke tabel internal dan sppd internal
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

                    // masukkan ke tabel internal dan sppd internal
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
                'jenis_arsip' => 'Surat Masuk',
                // 'jenis_disposisi' => $jenis_disposisi,
                'nomor_surat' => $request->nomor_surat,
                'klasifikasi_surat' => $request->klasifikasi_surat,
                'tujuan_arsip' => $request->tujuan_arsip,
                'pengirim_sumber' => $request->pengirim_sumber,
                'perihal_isi_deskripsi' => $request->perihal_isi_deskripsi,
                'diinput_oleh' => Auth::user()->nama,
            ]);
        }

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


        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $wilayah = Pengguna::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $siftnu . '.pengguna.id_wilayah')->where('pengguna.id_wilayah', Auth::user()->id_wilayah)->select('wilayah.nama')->first();
        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $cek = 'Upzis ' . $wilayah->nama;
        }
        alert()->success('Surat Masuk ' . $cek . ' Berhasil Ditambahkan');

        if (Auth::user()->gocap_id_pc_pengurus != null) {
            return redirect('/' . $request->role . '/arsip/detail_surat_masuk/' . $arsip_digital_id . '/pc')->with('success', 'Data berhasil ditambahkan');
        } elseif (Auth::user()->gocap_id_upzis_pengurus != null) {
            return redirect('/' . $request->role . '/arsip/detail_surat_masuk/' . $arsip_digital_id . '/upzis')->with('success', 'Data berhasil ditambahkan');
        }
    }

    public function aksi_tambah_dokumen_digital(Request $request)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        $anggaran = str_replace('.', '',  $request->anggaran);

        if ($request->penerima_golongan == 'on') {


            $s = implode(',', $request->akses_golongan);
            $b = explode(',', $s);


            if (count(collect($b)) == 1) {
                if ($b[0] == 'Akses Internal') {
                    $internal = '1';
                    $upzis = '0';
                    $ranting = '0';
                } elseif ($b[0] == 'Akses Upzis') {
                    $internal = '0';
                    $upzis = '1';
                    $ranting = '0';
                } elseif ($b[0] == 'Akses Ranting') {
                    $internal = '0';
                    $upzis = '0';
                    $ranting = '1';
                }
            }

            if (count(collect($b)) == 2) {
                if ($b[0] == 'Akses Internal' && $b[1] == 'Akses Upzis') {
                    $internal = '1';
                    $upzis = '1';
                    $ranting = '0';
                } elseif ($b[0] == 'Akses Upzis' && $b[1] == 'Akses Internal') {
                    $internal = '1';
                    $upzis = '1';
                    $ranting = '0';
                } elseif ($b[0] == 'Akses Internal' && $b[1] == 'Akses Ranting') {
                    $internal = '1';
                    $upzis = '0';
                    $ranting = '1';
                } elseif ($b[0] == 'Akses Ranting' && $b[1] == 'Akses Internal') {
                    $internal = '1';
                    $upzis = '0';
                    $ranting = '1';
                } elseif ($b[0] == 'Akses Upzis' && $b[1] == 'Akses Ranting') {
                    $internal = '0';
                    $upzis = '1';
                    $ranting = '1';
                } elseif ($b[0] == 'Akses Ranting' && $b[1] == 'Akses Upzis') {
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
        // terakhir yaitu create surat masuk
        if ($request->disposisi_ya == 'on') {
            if ($request->penerima_satuan == 'on') {


                // masukkan ke tabel arsip_digital
                ArsipDigital::create([
                    'arsip_digital_id' => $arsip_digital_id,
                    'id_pengguna' => Auth::user()->id_pengguna,
                    'tanggal_arsip' => $request->tanggal_arsip,
                    'jenis_arsip' => 'Dokumen Digital',
                    'jenis_disposisi' => 'Satuan',
                    'nama_dokumen' => $request->nama_dokumen,
                    'klasifikasi_dokumen' => $request->klasifikasi_dokumen,
                    'tujuan_arsip' => $request->tujuan_arsip,
                    'pengirim_sumber' => $request->pengirim_sumber,
                    'perihal_isi_deskripsi' => $request->perihal_isi_deskripsi,
                    'diinput_oleh' => Auth::user()->nama,
                ]);

                // masukkan ke tabel disposisi dan sppd mwcnu

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

                // masukkan ke tabel disposisi dan sppd lembaga

            } elseif ($request->penerima_golongan == 'on') {


                ArsipDigital::create([
                    'arsip_digital_id' => $arsip_digital_id,
                    'id_pengguna' => Auth::user()->id_pengguna,
                    'tanggal_arsip' => $request->tanggal_arsip,
                    'jenis_arsip' => 'Dokumen Digital',
                    'jenis_disposisi' => 'Golongan',
                    'nama_dokumen' => $request->nama_dokumen,
                    'klasifikasi_dokumen' => $request->klasifikasi_dokumen,
                    'tujuan_arsip' => $request->tujuan_arsip,
                    'pengirim_sumber' => $request->pengirim_sumber,
                    'perihal_isi_deskripsi' => $request->perihal_isi_deskripsi,
                    'diinput_oleh' => Auth::user()->nama,
                ]);



                if (Auth::user()->gocap_id_pc_pengurus != NULL) {
                    $upzis_all = Upzis::all()->pluck('id_upzis')->toArray();
                } elseif (Auth::user()->gocap_id_upzis_pengurus != NULL) {
                    $upzis_all = Upzis::all()->where('id_upzis', '!=', Auth::user()->UpzisPengurus->Upzis->id_upzis)->pluck('id_upzis')->toArray();
                }
                // masukkan ke tabel disposisi dan sppd 
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
                // masukkan ke tabel disposisi 
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


                // masukkan ke tabel arsip_digital
                ArsipDigital::create([
                    'arsip_digital_id' => $arsip_digital_id,
                    'id_pengguna' => Auth::user()->id_pengguna,
                    'tanggal_arsip' => $request->tanggal_arsip,
                    'jenis_arsip' => 'Dokumen Digital',
                    'jenis_disposisi' => 'Internal',
                    'nama_dokumen' => $request->nama_dokumen,
                    'klasifikasi_dokumen' => $request->klasifikasi_dokumen,
                    'tujuan_arsip' => $request->tujuan_arsip,
                    'pengirim_sumber' => $request->pengirim_sumber,
                    'perihal_isi_deskripsi' => $request->perihal_isi_deskripsi,
                    'diinput_oleh' => Auth::user()->nama,
                ]);
                if (Auth::user()->gocap_id_pc_pengurus != null) {

                    // masukkan ke tabel internal dan sppd internal
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

                    // masukkan ke tabel internal dan sppd internal
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
                'jenis_arsip' => 'Dokumen Digital',
                'nama_dokumen' => $request->nama_dokumen,
                'klasifikasi_dokumen' => $request->klasifikasi_dokumen,
                'tujuan_arsip' => $request->tujuan_arsip,
                'pengirim_sumber' => $request->pengirim_sumber,
                'perihal_isi_deskripsi' => $request->perihal_isi_deskripsi,
                'diinput_oleh' => Auth::user()->nama,
            ]);
        }

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


        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $wilayah = Pengguna::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $siftnu . '.pengguna.id_wilayah')->where('pengguna.id_wilayah', Auth::user()->id_wilayah)->select('wilayah.nama')->first();
        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $cek = 'Upzis ' . $wilayah->nama;
        }
        alert()->success('Arsip Dokumen ' . $cek . ' Berhasil Ditambahkan');


        if (Auth::user()->gocap_id_pc_pengurus != null) {
            return redirect('/' . $request->role . '/arsip/detail_dokumen_digital/' . $arsip_digital_id . '/pc')->with('success', 'Data berhasil ditambahkan');
        } elseif (Auth::user()->gocap_id_upzis_pengurus != null) {
            return redirect('/' . $request->role . '/arsip/detail_dokumen_digital/' . $arsip_digital_id . '/upzis')->with('success', 'Data berhasil ditambahkan');
        }
    }


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


        $penerima_golongan = $request->penerima_golongan;
        $penerima_satuan = $request->penerima_satuan;
        $penerima_internal = $request->penerima_internal;

        if ($penerima_golongan == 'on') {
            if ($golongan != null) {
                if ($disposisi_ya == 'on') {


                    if (count(collect($golongan)) == 1) {

                        if ($golongan[0] == 'Akses Internal') {

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
                        } elseif ($golongan[0] == 'Akses Upzis') {
                            $tabel_upzis =  Upzis::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.upzis.id_wilayah')
                                ->select($siftnu . '.wilayah.nama')->get();
                            $tabel_internal = null;
                            $tabel_ranting = null;
                        } elseif ($golongan[0] == 'Akses Ranting') {
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
                        if ($golongan[0] == 'Akses Internal' && $golongan[1] == 'Akses Upzis') {
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
                        } elseif ($golongan[0] == 'Akses Upzis' && $golongan[1] == 'Akses Internal') {
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
                        } elseif ($golongan[0] == 'Akses Internal' && $golongan[1] == 'Akses Ranting') {
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
                        } elseif ($golongan[0] == 'Akses Ranting' && $golongan[1] == 'Akses Internal') {
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
                        } elseif ($golongan[0] == 'Akses Upzis' && $golongan[1] == 'Akses Ranting') {
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
                        } elseif ($golongan[0] == 'Akses Ranting' && $golongan[1] == 'Akses Upzis') {
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

    public function print_memo($id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        $id_memo = $id;

        $title = 'Detail Memo';
        $memo = DB::table('memo')->where('id_memo', $id)->first();
        $page = "Detail Memo";
        $lampiran = DB::table('memo')->join('file_memo', 'memo.id_memo', '=', 'file_memo.id_memo')->where('memo.id_memo', $id)->get();
        $lampiran_file = DB::table('memo')->join('file_memo', 'memo.id_memo', '=', 'file_memo.id_memo')->where('memo.id_memo', $id)->count();

        $nama_pengurus =  Memo::join($siftnu . '.pengguna', $siftnu . '.pengguna.id_pengguna', '=', $earsip . '.memo.id_pengguna')->first();



        $sppd = DB::table('sppd')
            ->join('memo', 'memo.id_memo', '=', 'sppd.id_memo')
            ->where('sppd.id_memo', $id)->select('sppd.*')
            ->first();


        $disposisi = DB::table('disposisi')
            ->join('memo', 'memo.id_memo', '=', 'disposisi.id_memo')
            ->where('memo.id_memo', $id)
            ->first();



        if (Auth::user()->gocap_id_pc_pengurus != NULL) {


            $subjab =  Memo::join($siftnu . '.pengguna', $siftnu . '.pengguna.id_pengguna', '=', $earsip . '.memo.id_pengguna')
                ->where($earsip . '.memo.id_memo', '=', $id)->select($siftnu . '.pengguna.gocap_id_pc_pengurus')->first();

            $jabatan = PcPengurus::where('id_pc_pengurus', $subjab->gocap_id_pc_pengurus)->select('id_pengurus_jabatan')->first();

            $detail_jabatan = PengurusJabatan::where('id_pengurus_jabatan', $jabatan->id_pengurus_jabatan)->select('jabatan')->get();

            $baca_internal =  Disposisi::join($siftnu . '.pengguna', $siftnu . '.pengguna.gocap_id_pc_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->join($gocap . '.pc_pengurus', $gocap . '.pc_pengurus.id_pc_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->where('disposisi.id_memo', '=', $id_memo)
                ->select($siftnu . '.pengguna.nama', $earsip . '.disposisi.status_baca', $gocap . '.pc_pengurus.id_pengurus_jabatan')->get();

            $baca_internal_jumlah =  Disposisi::join($siftnu . '.pengguna', $siftnu . '.pengguna.gocap_id_pc_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->join($gocap . '.pc_pengurus', $gocap . '.pc_pengurus.id_pc_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->where('disposisi.id_memo', '=', $id_memo)
                ->select($siftnu . '.pengguna.nama', $earsip . '.disposisi.status_baca', $gocap . '.pc_pengurus.id_pengurus_jabatan')->count();
        }


        if (Auth::user()->gocap_id_upzis_pengurus != NULL) {

            $subjab =  Memo::join($siftnu . '.pengguna', $siftnu . '.pengguna.id_pengguna', '=', $earsip . '.memo.id_pengguna')
                ->where($earsip . '.memo.id_memo', '=', $id)->select($siftnu . '.pengguna.gocap_id_upzis_pengurus')->first();

            $jabatan = UpzisPengurus::where('id_upzis_pengurus', $subjab->gocap_id_upzis_pengurus)->select('id_pengurus_jabatan')->first();

            $detail_jabatan = PengurusJabatan::where('id_pengurus_jabatan', $jabatan->id_pengurus_jabatan)->select('jabatan')->get();

            $baca_internal =  Disposisi::join($siftnu . '.pengguna', $siftnu . '.pengguna.gocap_id_upzis_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->join($gocap . '.upzis_pengurus', $gocap . '.upzis_pengurus.id_upzis_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->where('disposisi.id_memo', '=', $id_memo)
                ->select($siftnu . '.pengguna.nama', $earsip . '.disposisi.status_baca', $gocap . '.upzis_pengurus.id_pengurus_jabatan')->get();

            $baca_internal_jumlah =  Disposisi::join($siftnu . '.pengguna', $siftnu . '.pengguna.gocap_id_upzis_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->join($gocap . '.upzis_pengurus', $gocap . '.upzis_pengurus.id_upzis_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->where('disposisi.id_memo', '=', $id_memo)
                ->select($siftnu . '.pengguna.nama', $earsip . '.disposisi.status_baca', $gocap . '.upzis_pengurus.id_pengurus_jabatan')->count();
        }




        $pdf = PDF::loadview(
            'memo.print_memo',
            compact('detail_jabatan', 'jabatan', 'baca_internal_jumlah', 'nama_pengurus', 'memo', 'page', 'lampiran', 'id_memo', 'lampiran_file', 'sppd', 'disposisi', 'title', 'baca_internal')
        );
        return $pdf->stream();
    }

    public function print_surat($id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $s = '';
        $arsip = DB::table('arsip_digital')->where('arsip_digital_id', $id)->first();
        // dd($arsip->yang_bertandatangan);
        // $b = explode(',', $arsip->yang_bertandatangan);
        // $b0 = $b[0];
        // $b1 = $b[1];
        $pengguna = Pengguna::where('id_pengguna', $arsip->id_pengguna)->first();
        $a = PcPengurus::where('id_pc_pengurus', $pengguna->gocap_id_pc_pengurus)->first();
        $join_ketua = PcPengurus::join($gocap . '.pengurus_jabatan', $gocap . '.pengurus_jabatan.id_pengurus_jabatan', '=', $gocap . '.pc_pengurus.id_pengurus_jabatan')
            ->where('jabatan', 'Ketua')->where('pc_pengurus.id_pc', $a->id_pc)
            ->where($gocap . '.pc_pengurus.tanggal_selesai_jabatan', '>=', date('Y-m-d'))
            ->where($gocap . '.pc_pengurus.tanggal_mulai_jabatan', '<=', date('Y-m-d'))
            ->first();

        $join_sekretaris = PcPengurus::join($gocap . '.pengurus_jabatan', $gocap . '.pengurus_jabatan.id_pengurus_jabatan', '=', $gocap . '.pc_pengurus.id_pengurus_jabatan')
            ->where('jabatan', 'Sekretaris')->where('pc_pengurus.id_pc', $a->id_pc)
            ->where($gocap . '.pc_pengurus.tanggal_selesai_jabatan', '>=', date('Y-m-d'))
            ->where($gocap . '.pc_pengurus.tanggal_mulai_jabatan', '<=', date('Y-m-d'))
            ->first();
        $namas_ketua = Pengguna::where('gocap_id_pc_pengurus', $join_ketua->id_pc_pengurus)->first();
        $namas_sekretaris = Pengguna::where('gocap_id_pc_pengurus', $join_sekretaris->id_pc_pengurus)->first();
        $nama_ketua = $namas_ketua->nama;
        $nama_sekretaris = $namas_sekretaris->nama;


        // dd($pengurus = DB::connection('gocap')->table('pc_pengurus')->whereIn('id_pc_pengurus', array($b[0], $b[1]))->get());
        // dd(
        //     PcPengurus::where('id_pc_pengurus', $b[1])->get()
        // );
        $lampiran = DB::table('arsip_digital')->join('lampiran_arsip', 'arsip_digital.arsip_digital_id', '=', 'lampiran_arsip.arsip_digital_id')->where('arsip_digital.arsip_digital_id', $id)->get();
        $lampiran_file = DB::table('lampiran_arsip')
            ->join('arsip_digital', 'arsip_digital.arsip_digital_id', '=', 'lampiran_arsip.arsip_digital_id')
            ->where('arsip_digital.arsip_digital_id', $arsip->arsip_digital_id)
            ->count();
        $pdf = PDF::loadview(
            'arsip.print_surat',
            compact('s', 'arsip', 'lampiran_file', 'nama_ketua', 'nama_sekretaris')
        )->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function print_surat_upzis($id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $s = '';
        $arsip = DB::table('arsip_digital')->where('arsip_digital_id', $id)->first();
        $pengguna = Pengguna::where('id_pengguna', $arsip->id_pengguna)->first();
        $upzis = UpzisPengurus::where('id_upzis_pengurus', $pengguna->gocap_id_upzis_pengurus)->first();
        $wilayah = Upzis::where('id_upzis', $upzis->id_upzis)->first();
        $nama_wilayah = Wilayah::where('id_wilayah', $wilayah->id_wilayah)->first();
        $a = UpzisPengurus::where('id_upzis_pengurus', $pengguna->gocap_id_upzis_pengurus)->first();

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
        $namas_ketua = Pengguna::where('gocap_id_upzis_pengurus', $join_ketua->id_upzis_pengurus)->first();
        $namas_sekretaris = Pengguna::where('gocap_id_upzis_pengurus', $join_sekretaris->id_upzis_pengurus)->first();
        $nama_ketua = $namas_ketua->nama;
        $nama_sekretaris = $namas_sekretaris->nama;

        $lampiran = DB::table('arsip_digital')->join('lampiran_arsip', 'arsip_digital.arsip_digital_id', '=', 'lampiran_arsip.arsip_digital_id')->where('arsip_digital.arsip_digital_id', $id)->get();
        $lampiran_file = DB::table('lampiran_arsip')
            ->join('arsip_digital', 'arsip_digital.arsip_digital_id', '=', 'lampiran_arsip.arsip_digital_id')
            ->where('arsip_digital.arsip_digital_id', $arsip->arsip_digital_id)
            ->count();
        $pdf = PDF::loadview(
            'arsip.print_surat_upzis',
            compact('s', 'arsip', 'lampiran_file', 'nama_ketua', 'nama_sekretaris', 'nama_wilayah')
        )->setPaper('a4', 'portrait');
        return $pdf->stream();
    }

    public function aksi_tambah_surat_keluar(Request $request)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $anggaran = str_replace('.', '',  $request->anggaran);

        // invalid untuk disposisi ya -> penerima satuan -> sppd ya
        if ($request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_ya == 'on') {
            $request->validate([
                // surat masuk
                'tanggal_arsip' => 'required',
                'nomor_surat' => 'required',
                'klasifikasi_surat' => 'required',
                'tujuan_arsip' => 'required',
                'pengirim_sumber' => 'required',
                // // akses
                // 'akses_satuan' => 'required',
                // disposisi
                'sifat' => 'required',
                // sppd
                'tgl_perintah' => 'required',
                'tgl_pelaksanaan' => 'required',
                'anggaran' => 'required',
            ], [
                'tanggal_arsip.required' => 'Tanggal Arsip harus diisi',
                'nomor_surat.required' => 'Nomor Surat harus diisi',
                'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
                'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                'akses_satuan.required' => 'Akses Satuan harus diisi',
                'sifat.required' => 'Sifat harus diisi',
                'tgl_perintah.required' => 'Tanggal Perintah harus diisi',
                'tgl_pelaksanaan.required' => 'Tanggal Pelaksanaan harus diisi',
                'anggaran.required' => 'Anggaran harus diisi',
            ]);
        }

        // invalid untuk disposisi ya -> penerima satuan -> sppd tidak
        if ($request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_tidak == 'on') {
            $request->validate([
                // surat masuk
                'tanggal_arsip' => 'required',
                'nomor_surat' => 'required',
                'klasifikasi_surat' => 'required',
                'tujuan_arsip' => 'required',
                'pengirim_sumber' => 'required',
                // // akses
                // 'akses_satuan' => 'required',
                // disposisi
                'sifat' => 'required',
            ], [
                'tanggal_arsip.required' => 'Tanggal Arsip harus diisi',
                'nomor_surat.required' => 'Nomor Surat harus diisi',
                'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                'tujuan_arsip.required' => 'Tujuan Surat harus diisi',
                'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                'akses_satuan.required' => 'Akses Satuan harus diisi',
                'sifat.required' => 'Sifat harus diisi',

            ]);
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
                // akses
                'akses_golongan' => 'required',
                // disposisi
                'sifat' => 'required',
                // sppd
                'tgl_perintah' => 'required',
                'tgl_pelaksanaan' => 'required',
                'anggaran' => 'required',
            ], [
                'tanggal_arsip.required' => 'Tanggal Arsip harus diisi',
                'nomor_surat.required' => 'Nomor Surat harus diisi',
                'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                'tujuan_arsip.required' => 'Tujuan Surat harus diisi',
                'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                'akses_golongan.required' => 'Akses Golongan harus diisi',
                'sifat.required' => 'Sifat harus diisi',
                'tgl_perintah.required' => 'Tanggal Perintah harus diisi',
                'tgl_pelaksanaan.required' => 'Tanggal Pelaksanaan harus diisi',
                'anggaran.required' => 'Anggaran harus diisi',
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
                // akses
                'akses_golongan' => 'required',
                // disposisi
                'sifat' => 'required',
            ], [
                'tanggal_arsip.required' => 'Tanggal Arsip harus diisi',
                'nomor_surat.required' => 'Nomor Surat harus diisi',
                'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                'tujuan_arsip.required' => 'Tujuan Surat harus diisi',
                'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                'akses_golongan.required' => 'Akses Golongan harus diisi',
                'sifat.required' => 'Sifat harus diisi',
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
                // // akses
                // 'akses_satuan' => 'required',
            ], [
                'tanggal_arsip.required' => 'Tanggal Arsip harus diisi',
                'nomor_surat.required' => 'Nomor Surat harus diisi',
                'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                'tujuan_arsip.required' => 'Tujuan Surat harus diisi',
                'pengirim_sumber.required' => 'Pengirim Surat harus diisi',

            ]);
        }


        if ($request->penerima_golongan == 'on') {


            $s = implode(',', $request->akses_golongan);
            $b = explode(',', $s);


            if (count(collect($b)) == 1) {
                if ($b[0] == 'Akses Internal') {
                    $internal = '1';
                    $upzis = '0';
                    $ranting = '0';
                } elseif ($b[0] == 'Akses Upzis') {
                    $internal = '0';
                    $upzis = '1';
                    $ranting = '0';
                } elseif ($b[0] == 'Akses Ranting') {
                    $internal = '0';
                    $upzis = '0';
                    $ranting = '1';
                }
            }

            if (count(collect($b)) == 2) {
                if ($b[0] == 'Akses Internal' && $b[1] == 'Akses Upzis') {
                    $internal = '1';
                    $upzis = '1';
                    $ranting = '0';
                } elseif ($b[0] == 'Akses Upzis' && $b[1] == 'Akses Internal') {
                    $internal = '1';
                    $upzis = '1';
                    $ranting = '0';
                } elseif ($b[0] == 'Akses Internal' && $b[1] == 'Akses Ranting') {
                    $internal = '1';
                    $upzis = '0';
                    $ranting = '1';
                } elseif ($b[0] == 'Akses Ranting' && $b[1] == 'Akses Internal') {
                    $internal = '1';
                    $upzis = '0';
                    $ranting = '1';
                } elseif ($b[0] == 'Akses Upzis' && $b[1] == 'Akses Ranting') {
                    $internal = '0';
                    $upzis = '1';
                    $ranting = '1';
                } elseif ($b[0] == 'Akses Ranting' && $b[1] == 'Akses Upzis') {
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
                    'tujuan_arsip' => $request->tujuan_arsip,
                    'pengirim_sumber' => $request->pengirim_sumber,
                    'perihal_isi_deskripsi' => $request->perihal_isi_deskripsi,
                    'diinput_oleh' => Auth::user()->nama,
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
                    'tujuan_arsip' => $request->tujuan_arsip,
                    'pengirim_sumber' => $request->pengirim_sumber,
                    'perihal_isi_deskripsi' => $request->perihal_isi_deskripsi,
                    'diinput_oleh' => Auth::user()->nama,
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
                    'tujuan_arsip' => $request->tujuan_arsip,
                    'pengirim_sumber' => $request->pengirim_sumber,
                    'perihal_isi_deskripsi' => $request->perihal_isi_deskripsi,
                    'isi_surat' => $request->isi_surat,
                    'diinput_oleh' => Auth::user()->nama,
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
                // 'jenis_disposisi' => $jenis_disposisi,
                'nomor_surat' => $request->nomor_surat,
                'klasifikasi_surat' => $request->klasifikasi_surat,
                'tujuan_arsip' => $request->tujuan_arsip,
                'pengirim_sumber' => $request->pengirim_sumber,
                'perihal_isi_deskripsi' => $request->perihal_isi_deskripsi,
                'diinput_oleh' => Auth::user()->nama,
            ]);
        }

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


        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $wilayah = Pengguna::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $siftnu . '.pengguna.id_wilayah')->where('pengguna.id_wilayah', Auth::user()->id_wilayah)->select('wilayah.nama')->first();
        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $cek = 'Upzis ' . $wilayah->nama;
        }
        alert()->success('Surat Keluar ' . $cek . ' Berhasil Ditambahkan');

        if (Auth::user()->gocap_id_pc_pengurus != null) {
            return redirect('/' . $request->role . '/arsip/detail_surat_keluar/' . $arsip_digital_id . '/pc')->with('success', 'Data berhasil ditambahkan');
        } elseif (Auth::user()->gocap_id_upzis_pengurus != null) {
            return redirect('/' . $request->role . '/arsip/detail_surat_keluar/' . $arsip_digital_id . '/upzis')->with('success', 'Data berhasil ditambahkan');
        }
    }

    public function aksi_tambah_surat_keluar_baru(Request $request)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $anggaran = str_replace('.', '',  $request->anggaran);

        // invalid untuk disposisi ya -> penerima satuan -> sppd ya
        if ($request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_ya == 'on') {
            $request->validate([
                // surat masuk
                'tanggal_arsip' => 'required',
                'nomor_surat' => 'required',
                'klasifikasi_surat' => 'required',
                'tujuan_arsip' => 'required',
                'pengirim_sumber' => 'required',
                // // akses
                // 'akses_satuan' => 'required',
                // disposisi
                'sifat' => 'required',
                // sppd
                'tgl_perintah' => 'required',
                'tgl_pelaksanaan' => 'required',
                'anggaran' => 'required',
            ], [
                'tanggal_arsip.required' => 'Tanggal Arsip harus diisi',
                'nomor_surat.required' => 'Nomor Surat harus diisi',
                'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                'tujuan_arsip.required' => 'Tujuan Arsip harus diisi',
                'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                'akses_satuan.required' => 'Akses Satuan harus diisi',
                'sifat.required' => 'Sifat harus diisi',
                'tgl_perintah.required' => 'Tanggal Perintah harus diisi',
                'tgl_pelaksanaan.required' => 'Tanggal Pelaksanaan harus diisi',
                'anggaran.required' => 'Anggaran harus diisi',
            ]);
        }

        // invalid untuk disposisi ya -> penerima satuan -> sppd tidak
        if ($request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_tidak == 'on') {
            $request->validate([
                // surat masuk
                'tanggal_arsip' => 'required',
                'nomor_surat' => 'required',
                'klasifikasi_surat' => 'required',
                'tujuan_arsip' => 'required',
                'pengirim_sumber' => 'required',
                // // akses
                // 'akses_satuan' => 'required',
                // disposisi
                'sifat' => 'required',
            ], [
                'tanggal_arsip.required' => 'Tanggal Arsip harus diisi',
                'nomor_surat.required' => 'Nomor Surat harus diisi',
                'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                'tujuan_arsip.required' => 'Tujuan Surat harus diisi',
                'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                'akses_satuan.required' => 'Akses Satuan harus diisi',
                'sifat.required' => 'Sifat harus diisi',

            ]);
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
                // akses
                'akses_golongan' => 'required',
                // disposisi
                'sifat' => 'required',
                // sppd
                'tgl_perintah' => 'required',
                'tgl_pelaksanaan' => 'required',
                'anggaran' => 'required',
            ], [
                'tanggal_arsip.required' => 'Tanggal Arsip harus diisi',
                'nomor_surat.required' => 'Nomor Surat harus diisi',
                'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                'tujuan_arsip.required' => 'Tujuan Surat harus diisi',
                'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                'akses_golongan.required' => 'Akses Golongan harus diisi',
                'sifat.required' => 'Sifat harus diisi',
                'tgl_perintah.required' => 'Tanggal Perintah harus diisi',
                'tgl_pelaksanaan.required' => 'Tanggal Pelaksanaan harus diisi',
                'anggaran.required' => 'Anggaran harus diisi',
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
                // akses
                'akses_golongan' => 'required',
                // disposisi
                'sifat' => 'required',
            ], [
                'tanggal_arsip.required' => 'Tanggal Arsip harus diisi',
                'nomor_surat.required' => 'Nomor Surat harus diisi',
                'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                'tujuan_arsip.required' => 'Tujuan Surat harus diisi',
                'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                'akses_golongan.required' => 'Akses Golongan harus diisi',
                'sifat.required' => 'Sifat harus diisi',
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
                // // akses
                // 'akses_satuan' => 'required',
            ], [
                'tanggal_arsip.required' => 'Tanggal Arsip harus diisi',
                'nomor_surat.required' => 'Nomor Surat harus diisi',
                'klasifikasi_surat.required' => 'Klasifikasi Surat harus diisi',
                'tujuan_arsip.required' => 'Tujuan Surat harus diisi',
                'pengirim_sumber.required' => 'Pengirim Surat harus diisi',

            ]);
        }


        if ($request->penerima_golongan == 'on') {



            $s = implode(',', $request->akses_golongan);
            $b = explode(',', $s);


            if (count(collect($b)) == 1) {
                if ($b[0] == 'Akses Internal') {
                    $internal = '1';
                    $upzis = '0';
                    $ranting = '0';
                } elseif ($b[0] == 'Akses Upzis') {
                    $internal = '0';
                    $upzis = '1';
                    $ranting = '0';
                } elseif ($b[0] == 'Akses Ranting') {
                    $internal = '0';
                    $upzis = '0';
                    $ranting = '1';
                }
            }

            if (count(collect($b)) == 2) {
                if ($b[0] == 'Akses Internal' && $b[1] == 'Akses Upzis') {
                    $internal = '1';
                    $upzis = '1';
                    $ranting = '0';
                } elseif ($b[0] == 'Akses Upzis' && $b[1] == 'Akses Internal') {
                    $internal = '1';
                    $upzis = '1';
                    $ranting = '0';
                } elseif ($b[0] == 'Akses Internal' && $b[1] == 'Akses Ranting') {
                    $internal = '1';
                    $upzis = '0';
                    $ranting = '1';
                } elseif ($b[0] == 'Akses Ranting' && $b[1] == 'Akses Internal') {
                    $internal = '1';
                    $upzis = '0';
                    $ranting = '1';
                } elseif ($b[0] == 'Akses Upzis' && $b[1] == 'Akses Ranting') {
                    $internal = '0';
                    $upzis = '1';
                    $ranting = '1';
                } elseif ($b[0] == 'Akses Ranting' && $b[1] == 'Akses Upzis') {
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
                    'tujuan_arsip' => $request->tujuan_arsip,
                    'pengirim_sumber' => $request->pengirim_sumber,
                    'perihal_isi_deskripsi' => $request->perihal_isi_deskripsi,
                    'isi_surat' => $request->isi_surat,
                    'no_urut' => $request->no_urut,
                    'jenis_surat_keluar'  => 'baru',
                    'diinput_oleh' => Auth::user()->nama,

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
                    'tujuan_arsip' => $request->tujuan_arsip,
                    'pengirim_sumber' => $request->pengirim_sumber,
                    'perihal_isi_deskripsi' => $request->perihal_isi_deskripsi,
                    'isi_surat' => $request->isi_surat,
                    'jenis_surat_keluar'  => 'baru',

                    'no_urut' => $request->no_urut,
                    'diinput_oleh' => Auth::user()->nama,
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
                    'tujuan_arsip' => $request->tujuan_arsip,
                    'pengirim_sumber' => $request->pengirim_sumber,
                    'perihal_isi_deskripsi' => $request->perihal_isi_deskripsi,
                    'isi_surat' => $request->isi_surat,
                    'jenis_surat_keluar'  => 'baru',

                    'no_urut' => $request->no_urut,
                    'diinput_oleh' => Auth::user()->nama,
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
                // 'jenis_disposisi' => $jenis_disposisi,
                'nomor_surat' => $request->nomor_surat,
                'klasifikasi_surat' => $request->klasifikasi_surat,
                'tujuan_arsip' => $request->tujuan_arsip,
                'pengirim_sumber' => $request->pengirim_sumber,
                'perihal_isi_deskripsi' => $request->perihal_isi_deskripsi,
                'isi_surat' => $request->isi_surat,
                'jenis_surat_keluar'  => 'baru',

                'no_urut' => $request->no_urut,
                'diinput_oleh' => Auth::user()->nama,
            ]);
        }

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


        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $wilayah = Pengguna::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $siftnu . '.pengguna.id_wilayah')->where('pengguna.id_wilayah', Auth::user()->id_wilayah)->select('wilayah.nama')->first();
        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $cek = 'Upzis ' . $wilayah->nama;
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
        //     'tanggal_arsip.required' => 'Tanggal Arsip harus diisi',
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
        $wilayah = Pengguna::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $siftnu . '.pengguna.id_wilayah')->where('pengguna.id_wilayah', Auth::user()->id_wilayah)->select('wilayah.nama')->first();
        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $cek = 'Upzis ' . $wilayah->nama;
        }
        alert()->success('Surat Keluar ' . $cek . ' Berhasil Diubah');

        return Redirect()->back()->with('success', 'Data berhasil diubah');
    }

    public function hapus_surat_keluar($id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        DB::table('arsip_digital')->where('arsip_digital_id', $id)->delete();

        $wilayah = Pengguna::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $siftnu . '.pengguna.id_wilayah')->where('pengguna.id_wilayah', Auth::user()->id_wilayah)->select('wilayah.nama')->first();
        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $cek = 'Upzis ' . $wilayah->nama;
        }
        alert()->success('Surat Keluar ' . $cek . ' Berhasil Dihapus');
        return back();
    }

    public function hapus_surat_masuk($id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        DB::table('arsip_digital')->where('arsip_digital_id', $id)->delete();


        $wilayah = Pengguna::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $siftnu . '.pengguna.id_wilayah')->where('pengguna.id_wilayah', Auth::user()->id_wilayah)->select('wilayah.nama')->first();
        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $cek = 'Upzis ' . $wilayah->nama;
        }
        alert()->success('Surat Keluar ' . $cek . ' Berhasil Dihapus');
        return back();
    }

    public function aksi_tambah_kategori_berita(Request $request)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        KategoriBerita::create([
            'id_kategori_berita' => uniqid(),
            'id_pengguna' => Auth::user()->id_pengguna,
            'nama_kategori' => $request->nama_kategori,
        ]);

        $wilayah = Pengguna::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $siftnu . '.pengguna.id_wilayah')->where('pengguna.id_wilayah', Auth::user()->id_wilayah)->select('wilayah.nama')->first();
        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $cek = 'Upzis ' . $wilayah->nama;
        }
        alert()->success('Kategori Berita ' . $cek . ' Berhasil Ditambahkan');

        return back()->with('success', 'Data berhasil ditambahkan');
    }

    public function  aksi_hapus_kategori_berita(Request $request, $id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        KategoriBerita::where('id_kategori_berita', $id)->delete();

        $wilayah = Pengguna::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $siftnu . '.pengguna.id_wilayah')->where('pengguna.id_wilayah', Auth::user()->id_wilayah)->select('wilayah.nama')->first();
        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $cek = 'Upzis ' . $wilayah->nama;
        }
        alert()->success('Kategori Berita ' . $cek . ' Berhasil Dihapus');
        return back();
    }

    public function aksi_edit_kategori_berita(Request $request, $id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        DB::table('kategori_berita')->where('id_kategori_berita', $id)->update([
            'nama_kategori' => $request->nama_kategori,
        ]);


        $wilayah = Pengguna::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $siftnu . '.pengguna.id_wilayah')->where('pengguna.id_wilayah', Auth::user()->id_wilayah)->select('wilayah.nama')->first();
        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $cek = 'Upzis ' . $wilayah->nama;
        }
        alert()->success('Kategori Berita ' . $cek . ' Berhasil Diubah');

        return Redirect();
    }

    public function aksi_tambah_berita(Request $request)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $request->validate([
            // aset umum
            'tanggal_terbit' => 'required',
            'kategori_berita' => 'required',
            'judul_berita' => 'required',

            'hastag_berita' => 'required',
            'narasi_berita' => 'required',


        ], [
            'tanggal_terbit.required' => 'tanggal_terbit Aset harus diisi',
            'kategori_berita.required' => 'kategori_berita Aset harus diisi',
            'judul_berita.required' => 'judul_berita Aset harus diisi',

            'hastag_berita.required' => 'Tahun Perolehan harus diisi',
            'narasi_berita.required' => 'Jumlah Unit Aset harus diisi',


        ]);


        $id_berita_umum = uniqid();
        Berita::create([
            'id_berita_umum' => $id_berita_umum,
            'id_pengguna' => Auth::user()->id_pengguna,
            'kategori_berita' => $request->kategori_berita,
            'hastag_berita' => implode(' , ', $request->hastag_berita),
            'judul_berita' => $request->judul_berita,
            'narasi_berita' => $request->narasi_berita,
            'tanggal_terbit' => $request->tanggal_terbit,
        ]);

        $file = $request->file('foto_background_berita');
        $ext_logo = $file->extension();
        $filename_bg = $file->storeAs('/foto_background_berita', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext_logo, ['disk' => 'foto_background_berita']);
        FileBerita::create([
            'id_file_berita' => uniqid(),
            'id_pengguna' => Auth::user()->id_pengguna,
            'id_berita_umum' => $id_berita_umum,
            'judul_file' => $request->judul_file_bg,
            'foto_background_berita' => $filename_bg,
        ]);



        $file = $request->file('foto_dokumentasi_berita');
        $ext_logo2 = $file->extension();
        $filename_doc = $file->storeAs('/foto_dokumentasi_berita', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext_logo2, ['disk' => 'foto_dokumentasi_berita']);
        FileBerita::create([
            'id_file_berita' => uniqid(),
            'id_pengguna' => Auth::user()->id_pengguna,
            'id_berita_umum' => $id_berita_umum,
            'judul_file' => $request->judul_file_doc,
            'foto_dokumentasi_berita' => $filename_doc,
        ]);

        if ($request->judul_files && count($request->judul_files) > 0) {
            $a = 0;
            foreach ($request->file('foto_dokumentasi_beritas') as $index) {

                $file = $index;
                $ext_logo2 = $file->extension();
                $filename_doc = $file->storeAs('/foto_dokumentasi_berita', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext_logo2, ['disk' => 'foto_dokumentasi_berita']);
                $validatedData['id_file_berita'] = uniqid();
                $validatedData['id_pengguna'] = Auth::user()->id_pengguna;
                $validatedData['id_berita_umum'] = $id_berita_umum;
                $validatedData['judul_file'] = $request->judul_files[$a];
                $validatedData['foto_dokumentasi_berita'] = $filename_doc;
                FileBerita::create($validatedData);

                $a++;
            }
        }

        $wilayah = Pengguna::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $siftnu . '.pengguna.id_wilayah')->where('pengguna.id_wilayah', Auth::user()->id_wilayah)->select('wilayah.nama')->first();
        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $cek = 'Upzis ' . $wilayah->nama;
        }
        alert()->success('Arsip Berita' . $cek . ' Berhasil Ditambahkan');

        return redirect('/' . $request->role . '/arsip/detail_berita/' . $id_berita_umum)->with('success', 'Data berhasil ditambahkan');
    }

    public function aksi_hapus_berita(Request $request, $id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        Berita::where('id_berita_umum', $id)->delete();

        $wilayah = Pengguna::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $siftnu . '.pengguna.id_wilayah')->where('pengguna.id_wilayah', Auth::user()->id_wilayah)->select('wilayah.nama')->first();
        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $cek = 'Upzis ' . $wilayah->nama;
        }
        alert()->success('Arsip Berita' . $cek . ' Berhasil Dihapus');
        return back();
    }

    public function aksi_hapus_memo(Request $request, $id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        Memo::where('id_memo', $id)->delete();
        $wilayah = Pengguna::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $siftnu . '.pengguna.id_wilayah')->where('pengguna.id_wilayah', Auth::user()->id_wilayah)->select('wilayah.nama')->first();
        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $cek = 'Upzis ' . $wilayah->nama;
        }
        alert()->success('Memo Internal ' . $cek . ' Berhasil Dihapus');
        return back();
    }

    public function detail_berita($id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $foto = DB::table('file_berita')->where('id_berita_umum', $id)->first();
        $title = 'ARSIP BERITA';
        $page = 'Detail Arsip Berita';
        $kategori_berita = DB::table('kategori_berita')->where('id_pengguna', Auth::user()->id_pengguna)->orderby('created_at', 'desc')->get();
        $lampiran = DB::table('berita')->join('file_berita', 'file_berita.id_berita_umum', '=', 'berita.id_berita_umum')->where('berita.id_berita_umum', $id)->orderby('file_berita.created_at', 'desc')->get();
        $berita = DB::table('berita')->where('id_berita_umum', $id)->first();
        $id_berita_umum = $id;
        return view('arsip.detail_berita', compact('foto', 'title', 'page', 'lampiran', 'id_berita_umum', 'berita', 'kategori_berita'));
    }

    public function aksi_tambah_file_berita(Request $request, $id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        if ($request->jenis == 'background') {
            $file = $request->file('file');
            $ext_logo = $file->extension();
            $filename_berita = $file->storeAs('/foto_background_berita', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext_logo, ['disk' => 'foto_background_berita']);
            Fileberita::create([
                'id_file_berita' => uniqid(),
                'id_pengguna' => Auth::user()->id_pengguna,
                'id_berita_umum' => $id,
                'judul_file' => $request->judul_file,
                'foto_background_berita' => $filename_berita,
            ]);
        } else {
            $file = $request->file('file');
            $ext_logo = $file->extension();
            $filename_berita = $file->storeAs('/foto_dokumentasi_berita', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext_logo, ['disk' => 'foto_dokumentasi_berita']);
            Fileberita::create([
                'id_file_berita' => uniqid(),
                'id_pengguna' => Auth::user()->id_pengguna,
                'id_berita_umum' => $id,
                'judul_file' => $request->judul_file,
                'foto_dokumentasi_berita' => $filename_berita,
            ]);
        }

        $wilayah = Pengguna::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $siftnu . '.pengguna.id_wilayah')->where('pengguna.id_wilayah', Auth::user()->id_wilayah)->select('wilayah.nama')->first();
        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $cek = 'Upzis ' . $wilayah->nama;
        }
        alert()->success('File Berita ' . $cek . ' Berhasil Ditambahkan');
        return back()->withInput(['tab' => 'lampiran_berita']);
    }

    public function aksi_tambah_file_memo(Request $request, $id)
    {

        $file = $request->file('file_memo');
        $ext_logo = $file->extension();
        $filename_scan = $file->storeAs('/file_memo', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext_logo, ['disk' => 'file_memo']);
        FileMemo::create([
            'id_file_memo' => uniqid(),
            'id_memo' => $id,
            'nama' => $request->nama,
            'file' => $filename_scan,
        ]);

        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $wilayah = Pengguna::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $siftnu . '.pengguna.id_wilayah')->where('pengguna.id_wilayah', Auth::user()->id_wilayah)->select('wilayah.nama')->first();
        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $cek = 'Upzis ' . $wilayah->nama;
        }
        alert()->success('File Memo Internal ' . $cek . ' Berhasil Ditambahkan');
        return back()->with('success', 'Data berhasil ditambahkan');
    }

    public function aksi_edit_file_berita(Request $request, $id)
    {

        if ($request->jenis == 'background') {
            if ($request->file) {
                $file = $request->file('file');
                $ext = $file->extension();
                $filename = $file->storeAs('/foto_background_berita', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext, ['disk' => 'foto_background_berita']);

                $path = public_path() . "/foto_background_berita/" . $request->file_lama;
                if (file_exists($path)) {
                    unlink($path);
                }

                FileBerita::where('id_file_berita', $id)->update([
                    'judul_file' => $request->judul_file,
                    'foto_background_berita' => $filename,
                ]);
            } else {
                FileBerita::where('id_file_berita', $id)->update([
                    'judul_file' => $request->judul_file,
                ]);
            }
        } else {
            if ($request->file) {
                $file = $request->file('file');
                $ext = $file->extension();
                $filename = $file->storeAs('/foto_dokumentasi_berita', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext, ['disk' => 'foto_dokumentasi_berita']);

                $path = public_path() . "/foto_dokumentasi_berita/" . $request->file_lama;
                if (file_exists($path)) {
                    unlink($path);
                }

                FileBerita::where('id_file_berita', $id)->update([
                    'judul_file' => $request->judul_file,
                    'foto_dokumentasi_berita' => $filename,
                ]);
            } else {
                FileBerita::where('id_file_berita', $id)->update([
                    'judul_file' => $request->judul_file,
                ]);
            }
        }

        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $wilayah = Pengguna::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $siftnu . '.pengguna.id_wilayah')->where('pengguna.id_wilayah', Auth::user()->id_wilayah)->select('wilayah.nama')->first();
        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $cek = 'Upzis ' . $wilayah->nama;
        }
        alert()->success('File Arsip Berita ' . $cek . ' Berhasil Diubah');



        return back()->withInput(['tab' => 'lampiran_berita']);
    }

    public function aksi_edit_file_memo(Request $request, $id)
    {
        if ($request->file('file_memo') != null) {
            $file = $request->file('file_memo');
            $ext = $file->extension();
            $filename = $file->storeAs('/file_memo', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext, ['disk' => 'file_memo']);

            $path = public_path() . "/file_memo/" . $request->file_lama;
            if (file_exists($path)) {
                unlink($path);
            }

            FileMemo::where('id_file_memo', $id)->update([
                'nama' => $request->nama,
                'file' => $filename,
            ]);
        } else {
            FileMemo::where('id_file_memo', $id)->update([
                'nama' => $request->nama,
            ]);
        }

        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $wilayah = Pengguna::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $siftnu . '.pengguna.id_wilayah')->where('pengguna.id_wilayah', Auth::user()->id_wilayah)->select('wilayah.nama')->first();
        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $cek = 'Upzis ' . $wilayah->nama;
        }
        alert()->success('File Memo Internal ' . $cek . ' Berhasil Diubah');


        return back()->with('success', 'Data berhasil diubah');
    }

    public function aksi_hapus_file_berita(Request $request, $id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        FileBerita::where('id_file_berita', $id)->delete();

        $wilayah = Pengguna::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $siftnu . '.pengguna.id_wilayah')->where('pengguna.id_wilayah', Auth::user()->id_wilayah)->select('wilayah.nama')->first();
        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $cek = 'Upzis ' . $wilayah->nama;
        }
        alert()->success('File Arsip Berita ' . $cek . ' Berhasil Dihapus');

        return back()->withInput(['tab' => 'lampiran_berita']);
    }

    public function aksi_hapus_file_memo(Request $request, $id)
    {

        FileMemo::where('id_file_memo', $id)->delete();
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $wilayah = Pengguna::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $siftnu . '.pengguna.id_wilayah')->where('pengguna.id_wilayah', Auth::user()->id_wilayah)->select('wilayah.nama')->first();
        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $cek = 'Upzis ' . $wilayah->nama;
        }
        alert()->success('File Memo Internal ' . $cek . ' Berhasil Dihapus');

        return back();
    }


    public function aksi_edit_berita(Request $request, $id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        // $request->validate([
        //     'tanggal_arsip' => 'required',
        //     'nama_dokumen' => 'required',
        //     'klasifikasi_dokumen' => 'required',
        //     'tujuan_arsip' => 'required',
        // ]);

        DB::table('berita')->where('id_berita_umum', $id)->update([
            'kategori_berita' => $request->kategori_berita,
            'hastag_berita' => implode(' , ', $request->hastag_berita),
            'judul_berita' => $request->judul_berita,
            'narasi_berita' => $request->narasi_berita,
        ]);

        $gocap = config('app.database_gocap');
        $wilayah = Pengguna::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $siftnu . '.pengguna.id_wilayah')->where('pengguna.id_wilayah', Auth::user()->id_wilayah)->select('wilayah.nama')->first();
        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $cek = 'Upzis ' . $wilayah->nama;
        }
        alert()->success('Arsip Berita ' . $cek . ' Berhasil Diubah');


        return Redirect()->back()->with('success', 'Data berhasil diubah');
    }

    public function aksi_edit_memo(Request $request, $id)
    {

        Memo::where('id_memo', $id)->update([
            'hal' => $request->hala,
            'isi_memo' => $request->isi_memoa
        ]);

        $dis =  Disposisi::where('id_memo', $id)->first();
        Disposisi::where('id_memo', $id)->delete();

        $b = 0;
        foreach ($request->kepada as $index) {
            Disposisi::create([
                'disposisi_id' => uniqid(),
                'id_memo' => $id,
                'id_pengurus_internal' => $request->kepada[$b],
                'status_baca' => '0',
                'sifat' => $request->sifat,
                'perihal' => $request->perihal_disposisi,
            ]);

            $b++;
        }
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $wilayah = Pengguna::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $siftnu . '.pengguna.id_wilayah')->where('pengguna.id_wilayah', Auth::user()->id_wilayah)->select('wilayah.nama')->first();
        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $cek = 'Upzis ' . $wilayah->nama;
        }
        alert()->success('Memo Internal ' . $cek . ' Berhasil Diubah');


        return Redirect()->back()->with('success', 'Data berhasil diubah');
    }


    public function aksi_tambah_memo(Request $request)
    {

        // invalid untuk disposisi ya -> penerima golongan -> sppd ya

        // $request->validate([
        //     // memo
        //     'tanggal_memo' => 'required',
        //     'nomor_memo' => 'required',
        //     'kepada' => 'required',
        //     'hal' => 'required',
        //     'isi_memo' => 'required',
        //     // disposisi
        //     'sifat' => 'required',
        //     // sppd
        //     'tgl_perintah' => 'required',
        //     'tgl_pelaksanaan' => 'required',
        //     'anggaran' => 'required',
        // ], [
        //     'tanggal_memo.required' => 'Tanggal Memo harus diisi',
        //     'nomor_memo.required' => 'Nomor Surat harus diisi',
        //     'kepada.required' => 'Tujuan Memo harus diisi',
        //     'hal.required' => 'Hal Memo harus diisi',
        //     'isi_memo.required' => 'Isi Memo harus diisi',
        //     'sifat.required' => 'Sifat harus diisi',
        //     'tgl_perintah.required' => 'Tanggal Perintah harus diisi',
        //     'tgl_pelaksanaan.required' => 'Tanggal Pelaksanaan harus diisi',
        //     'anggaran.required' => 'Anggaran harus diisi',
        // ]);



        // id arsip digital
        $id_memo = uniqid();
        // masukkan ke tabel arsip_digital
        Memo::create([
            'id_memo' => $id_memo,
            'id_pengguna' => Auth::user()->id_pengguna,
            'tanggal_memo' => now(),
            'nomor_memo' => $request->nomor_memo,
            'no_urut' => $request->no_urut,
            'hal' => $request->hal,
            'isi_memo' => $request->isi_memo,

        ]);

        if (Auth::user()->gocap_id_pc_pengurus != null) {

            // masukkan ke tabel internal dan sppd internal
            if ($request->akses_internal != NULL) {

                $b = 0;

                foreach ($request->akses_internal as $index) {
                    $disposisi_id = uniqid();
                    $sppd_id = uniqid();
                    Disposisi::create([
                        'disposisi_id' => $disposisi_id,
                        'id_memo' => $id_memo,
                        'id_pengurus_internal' => $request->akses_internal[$b],
                        'status_baca' => '0',
                        'sifat' => $request->sifat,
                        'perihal' => $request->perihal_disposisi,
                    ]);

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
                    Disposisi::create([
                        'disposisi_id' => $disposisi_id,
                        'id_memo' => $id_memo,
                        'id_pengurus_internal' => $request->akses_internal[$b],
                        'status_baca' => '0',
                        'sifat' => $request->sifat,
                        'perihal' => $request->perihal_disposisi,
                    ]);

                    $b++;
                }
            }
        }

        $file = $request->file('file_memo');
        $ext_logo = $file->extension();
        $filename_scan = $file->storeAs('/file_memo', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext_logo, ['disk' => 'file_memo']);
        FileMemo::create([
            'id_file_memo' => uniqid(),
            'id_memo' => $id_memo,
            'nama' => $request->nama_surat,
            'file' => $filename_scan,
        ]);


        if ($request->nama && count($request->nama) > 0) {
            $a = 0;
            foreach ($request->file('lampiran') as $index) {

                $file = $index;
                $ext_logo = $file->extension();

                $filename_lampiran = $file->storeAs('/file_memo', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext_logo, ['disk' => 'file_memo']);
                $validatedData['id_file_memo'] = uniqid();
                $validatedData['id_memo'] = $id_memo;
                $validatedData['nama'] = $request->nama[$a];
                $validatedData['file'] = $filename_lampiran;
                FileMemo::create($validatedData);

                $a++;
            }
        }

        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $wilayah = Pengguna::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $siftnu . '.pengguna.id_wilayah')->where('pengguna.id_wilayah', Auth::user()->id_wilayah)->select('wilayah.nama')->first();
        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $cek = 'Upzis ' . $wilayah->nama;
        }
        alert()->success('Memo Internal ' . $cek . ' Berhasil Ditambahkan');


        return redirect('/' . $request->role . '/detail_memo/' . $id_memo)->with('success', 'Data berhasil ditambahkan');
    }
}
