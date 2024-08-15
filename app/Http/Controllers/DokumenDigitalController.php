<?php

namespace App\Http\Controllers;

use App\Models\Pc;
use Carbon\Carbon;
use App\Models\Sppd;
use App\Models\Upzis;
use App\Models\Ranting;
use App\Models\Pengguna;
use App\Models\Disposisi;
use App\Models\PcPengurus;
use App\Models\ArsipDigital;
use App\Models\JenisKlasifikasiDokumen;
use Illuminate\Http\Request;
use App\Models\LampiranArsip;
use App\Models\UpzisPengurus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class DokumenDigitalController extends Controller
{
    public function __construct()
    {
        view()->composer('*', function ($view) {

            $tahun_arsip = ArsipDigital::where('jenis_arsip', 'Dokumen Digital')->select(DB::raw('YEAR(tanggal_arsip) as year'))->groupBy('year')->orderBy('year', 'DESC')->get();

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
                ->with('tahun_arsip', $tahun_arsip)
                ->with('pengurus', $pengurus);
        });
    }

    public function dokumen_digital_pc(Request $request, $id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $id = $id;
        $tahuns = "";
        $bulans = "";
        $disposisis = "";
        $klasifikasis = "";
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



        return view('dokumen.dokumen', compact('dokumen_diterima', 'dokumen_dikirim', 'tahuns', 'disposisis', 'klasifikasis', 'bulans', 'page', 'part', 'id', 'title', 'link', 'head', 'hal'));
    }

    public function dokumen_digital_pc2(Request $request, $id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $id = $id;

        $tahuns = "";
        $bulans = "";
        $disposisis = "";
        $klasifikasis = "";
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



        return view('dokumen.dokumen_2', compact('dokumen_diterima', 'tahuns', 'disposisis', 'klasifikasis', 'bulans', 'dokumen_dikirim', 'page', 'part', 'id', 'title', 'link', 'head', 'hal'));
    }

    public function dokumen_digital_upzis(Request $request, $id)
    {
        $tahuns = "";
        $bulans = "";
        $disposisis = "";
        $klasifikasis = "";

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



        return view('dokumen.dokumen', compact('dokumen_diterima', 'tahuns', 'disposisis', 'klasifikasis', 'bulans', 'dokumen_dikirim', 'page', 'part', 'id', 'title', 'link', 'head', 'hal'));
    }

    public function dokumen_digital_upzis2(Request $request, $id)
    {
        $tahuns = "";
        $bulans = "";

        $disposisis = "";
        $klasifikasis = "";
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



        return view('dokumen.dokumen_2', compact('dokumen_diterima', 'tahuns', 'disposisis', 'klasifikasis', 'bulans', 'dokumen_dikirim', 'page', 'part', 'id', 'title', 'link', 'head', 'hal'));
    }

    public function tambah_dokumen_digital($hal)
    {
        $hal = $hal;
        if ($hal == 'pc') {
            $act = 'pc_dokumen';
        } elseif ($hal == 'upzis') {
            $act = 'upzis_dokumen';
        }
        $jenis_klasifikasi_dokumen = JenisKlasifikasiDokumen::all();
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $page = "Tambah Dokumen Digital";
        $title = 'ARSIP DOKUMEN';
        $link = 'dokumen_digital';

        return view('dokumen.tambah_dokumen', compact('jenis_klasifikasi_dokumen', 'act', 'hal', 'page', 'title', 'link'));
    }

    public function hapus_dokumen_digital($id)
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

        Sppd::where('arsip_digital_id', $id)->delete();
        Disposisi::where('arsip_digital_id', $id)->delete();
        LampiranArsip::where('arsip_digital_id', $id)->delete();
        ArsipDigital::where('arsip_digital_id', $id)->delete();

        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('Dokumen Digital ' . $cek . ' Berhasil Dihapus');
        if (Auth::user()->gocap_id_pc_pengurus != null) {
            return redirect('/pc/arsip/dokumen_digital_pc/pc');
        } elseif (Auth::user()->gocap_id_upzis_pengurus != null) {
            return redirect('/upzis/arsip/dokumen_digital_upzis/upzis');
        }
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
        return view('dokumen.detail_dokumen', compact('info', 'halaman', 'baca_pc', 'baca_ranting', 'arsip', 'page', 'lampiran', 'id_arsip', 'lampiran_file', 'sppd', 'disposisi', 'stat', 'title', 'baca_upzis', 'baca_internal'));
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

        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('Arsip Dokumen ' . $cek . ' Berhasil Diubah');
        return Redirect()->back();
    }

    public function aksi_tambah_dokumen_digital(Request $request)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');


        if (Auth::user()->gocap_id_pc_pengurus != null) {
            // invalid untuk disposisi ya -> penerima satuan -> sppd ya
            if ($request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_ya == 'on' && $request->akses_satuan_upzis == null && $request->akses_satuan_ranting == null) {
                $request->validate([
                    // surat masuk
                    'tanggal_arsip' => 'required',
                    'pengirim_sumber' => 'required',
                    'perihal_isi_deskripsi' => 'required',
                    'nama_dokumen' => 'required',
                    'klasifikasi_dokumen' => 'required',
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
                    'nama_surat' => 'required',
                    'scan_surat' => 'required',
                ], [
                    'tanggal_arsip.required' => 'Tanggal Dokumen harus diisi',
                    'pengirim_sumber.required' => 'Pengirim Dokumen harus diisi',
                    'perihal_isi_deskripsi.required' => 'Deskripsi Dokumen harus diisi',
                    'nama_dokumen.required' => 'Nama Dokumen harus diisi',
                    'klasifikasi_dokumen.required' => 'Klasifikasi Dokumen harus diisi',
                    'sifat.required' => 'Sifat harus diisi',
                    'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',
                    'tgl_perintah.required' => 'Tanggal Perintah harus diisi',
                    'tgl_pelaksanaan.required' => 'Tanggal Pelaksanaan harus diisi',
                    'anggaran.required' => 'Anggaran harus diisi',
                    'perihal_sppd.required' => 'Perihal Sppd harus diisi',
                    'akses_satuan_upzis.required' => 'salah satu akses satuan harus diisi',
                    'akses_satuan_ranting.required' => 'salah satu akses satuan harus diisi',
                    'nama_surat.required' => 'Nama Dokumen harus diisi',
                    'scan_surat.required' => 'Lampiran Dokumen harus diisi',
                ]);
            }

            if (
                $request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_ya == 'on' && $request->akses_satuan_upzis != null ||
                $request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_ya == 'on' &&  $request->akses_satuan_ranting != null
            ) {
                $request->validate([
                    // surat masuk
                    'tanggal_arsip' => 'required',

                    'pengirim_sumber' => 'required',
                    'perihal_isi_deskripsi' => 'required',
                    'nama_dokumen' => 'required',
                    'klasifikasi_dokumen' => 'required',

                    // disposisi
                    'sifat' => 'required',
                    'perihal_disposisi' => 'required',
                    // sppd
                    'tgl_perintah' => 'required',
                    'tgl_pelaksanaan' => 'required',
                    'anggaran' => 'required',
                    'perihal_sppd' => 'required',
                    'nama_surat' => 'required',
                    'scan_surat' => 'required',

                ], [
                    'tanggal_arsip.required' => 'Tanggal Dokumen harus diisi',



                    'pengirim_sumber.required' => 'Pengirim Dokumen harus diisi',
                    'perihal_isi_deskripsi.required' => 'Deskripsi Dokumen harus diisi',
                    'nama_dokumen.required' => 'Nama Dokumen harus diisi',
                    'klasifikasi_dokumen.required' => 'Klasifikasi Dokumen harus diisi',

                    'sifat.required' => 'Sifat harus diisi',
                    'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',

                    'tgl_perintah.required' => 'Tanggal Perintah harus diisi',
                    'tgl_pelaksanaan.required' => 'Tanggal Pelaksanaan harus diisi',
                    'anggaran.required' => 'Anggaran harus diisi',
                    'perihal_sppd.required' => 'Perihal Sppd harus diisi',
                    'nama_surat.required' => 'Nama Lampiran harus diisi',
                    'scan_surat.required' => 'Lampiran Dokumen harus diisi',

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

                    'pengirim_sumber' => 'required',
                    'perihal_isi_deskripsi' => 'required',
                    'nama_dokumen' => 'required',
                    'klasifikasi_dokumen' => 'required',
                    // disposisi
                    'sifat' => 'required',
                    'perihal_disposisi' => 'required',
                    'nama_surat' => 'required',
                    'scan_surat' => 'required',

                ], [
                    'tanggal_arsip.required' => 'Tanggal Dokumen harus diisi',



                    'pengirim_sumber.required' => 'Pengirim Dokumen harus diisi',
                    'perihal_isi_deskripsi.required' => 'Deskripsi Dokumen harus diisi',
                    'nama_dokumen.required' => 'Nama Dokumen harus diisi',
                    'klasifikasi_dokumen.required' => 'Klasifikasi Dokumen harus diisi',

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

                    'pengirim_sumber' => 'required',
                    'perihal_isi_deskripsi' => 'required',
                    'nama_dokumen' => 'required',
                    'klasifikasi_dokumen' => 'required',

                    // disposisi
                    'sifat' => 'required',
                    'perihal_disposisi' => 'required',

                    'akses_satuan_upzis' => 'required',
                    'akses_satuan_ranting' => 'required',
                    'nama_surat' => 'required',
                    'scan_surat' => 'required',




                ], [
                    'tanggal_arsip.required' => 'Tanggal Dokumen harus diisi',



                    'pengirim_sumber.required' => 'Pengirim Dokumen harus diisi',
                    'perihal_isi_deskripsi.required' => 'Deskripsi Dokumen harus diisi',
                    'nama_dokumen.required' => 'Nama Dokumen harus diisi',
                    'klasifikasi_dokumen.required' => 'Klasifikasi Dokumen harus diisi',

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

                    'klasifikasi_dokumen' => 'required',
                    'nama_dokumen' => 'required',
                    'pengirim_sumber' => 'required',
                    'perihal_isi_deskripsi' => 'required',
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

                    'nama_surat' => 'required',
                    'scan_surat' => 'required',

                ], [
                    'tanggal_arsip.required' => 'Tanggal Surat harus diisi',

                    'klasifikasi_dokumen.required' => 'Klasifikasi Dokumen harus diisi',
                    'nama_dokumen.required' => 'Nama Dokumen harus diisi',
                    'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                    'perihal_isi_deskripsi.required' => 'Perihal Surat harus diisi',


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

                    'klasifikasi_dokumen' => 'required',
                    'nama_dokumen' => 'required',
                    'pengirim_sumber' => 'required',
                    'perihal_isi_deskripsi' => 'required',
                    // disposisi
                    'sifat' => 'required',
                    'perihal_disposisi' => 'required',
                    // sppd
                    'tgl_perintah' => 'required',
                    'tgl_pelaksanaan' => 'required',
                    'anggaran' => 'required',
                    'perihal_sppd' => 'required',

                    'nama_surat' => 'required',
                    'scan_surat' => 'required',


                ], [
                    'tanggal_arsip.required' => 'Tanggal Surat harus diisi',
                    'nama_dokumen.required' => 'Nama Dokumen harus diisi',
                    'klasifikasi_dokumen.required' => 'Klasifikasi Dokumen harus diisi',

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
                $request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_tidak == 'on' && $request->akses_satuan_ranting != null ||
                $request->disposisi_ya == 'on' && $request->penerima_satuan == 'on' && $request->sppd_tidak == 'on' && $request->akses_satuan_pc != null
            ) {
                $request->validate([
                    // surat masuk
                    'tanggal_arsip' => 'required',

                    'klasifikasi_dokumen' => 'required',
                    'nama_dokumen' => 'required',
                    'pengirim_sumber' => 'required',
                    'perihal_isi_deskripsi' => 'required',
                    // disposisi
                    'sifat' => 'required',
                    'perihal_disposisi' => 'required',
                    'nama_surat' => 'required',
                    'scan_surat' => 'required',


                ], [
                    'tanggal_arsip.required' => 'Tanggal Surat harus diisi',

                    'klasifikasi_dokumen.required' => 'Klasifikasi Dokumen harus diisi',
                    'nama_dokumen.required' => 'Nama Dokumen harus diisi',

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
                && $request->akses_satuan_ranting == null && $request->akses_satuan_pc == null
            ) {

                $request->validate([
                    // surat masuk
                    'tanggal_arsip' => 'required',

                    'klasifikasi_dokumen' => 'required',
                    'nama_dokumen' => 'required',

                    'pengirim_sumber' => 'required',
                    'perihal_isi_deskripsi' => 'required',
                    // disposisi
                    'sifat' => 'required',
                    'perihal_disposisi' => 'required',

                    'akses_satuan_upzis' => 'required',
                    'akses_satuan_ranting' => 'required',
                    'akses_satuan_pc' => 'required',

                    'nama_surat' => 'required',
                    'scan_surat' => 'required',


                ], [
                    'tanggal_arsip.required' => 'Tanggal Surat harus diisi',

                    'klasifikasi_dokumen.required' => 'Klasifikasi Dokumen harus diisi',

                    'pengirim_sumber.required' => 'Pengirim Surat harus diisi',
                    'nama_dokumen.required' => 'Nama Dokumen harus diisi',
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
                'nama_dokumen' => 'required',
                'pengirim_sumber' => 'required',
                'perihal_isi_deskripsi' => 'required',
                // disposisi
                'sifat' => 'required',
                'perihal_disposisi' => 'required',
                // sppd
                'tgl_perintah' => 'required',
                'tgl_pelaksanaan' => 'required',
                'anggaran' => 'required',
                'perihal_sppd' => 'required',

                'akses_golongan' => 'required',

                'nama_surat' => 'required',
                'scan_surat' => 'required',

                'nama_dokumen' => 'required',
                'klasifikasi_dokumen' => 'required',
            ], [
                'tanggal_arsip.required' => 'Tanggal Dokumen harus diisi',


                'nama_dokumen.required' => 'Nama Dokumen harus diisi',
                'pengirim_sumber.required' => 'Pengirim Dokumen harus diisi',
                'perihal_isi_deskripsi.required' => ' Deskripsi Dokumen harus diisi',

                'sifat.required' => 'Sifat harus diisi',
                'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',

                'tgl_perintah.required' => 'Tanggal Perintah harus diisi',
                'tgl_pelaksanaan.required' => 'Tanggal Pelaksanaan harus diisi',
                'anggaran.required' => 'Anggaran harus diisi',
                'perihal_sppd.required' => 'Perihal Sppd harus diisi',
                'akses_golongan.required' => 'Akses Golongan Harus Diisi',

                'nama_surat.required' => 'Nama Surat harus diisi',
                'scan_surat.required' => 'Scan Surat harus diisi',

                'nama_dokumen.required' => 'Nama Dokumen harus diisi',
                'klasifikasi_dokumen.required' => 'Klasifikasi Dokumen harus diisi',
            ]);
        }

        // invalid untuk disposisi ya -> penerima golongan -> sppd tidak
        if ($request->disposisi_ya == 'on' && $request->penerima_golongan == 'on' && $request->sppd_tidak == 'on') {
            $request->validate([
                // surat masuk
                'tanggal_arsip' => 'required',
                'nama_dokumen' => 'required',
                'pengirim_sumber' => 'required',
                'perihal_isi_deskripsi' => 'required',
                // disposisi
                'sifat' => 'required',
                'perihal_disposisi' => 'required',

                'akses_golongan' => 'required',

                'nama_surat' => 'required',
                'scan_surat' => 'required',
                'nama_dokumen' => 'required',
                'klasifikasi_dokumen' => 'required',
            ], [
                'tanggal_arsip.required' => 'Tanggal Dokumen harus diisi',

                'nama_dokumen.required' => 'Nama Dokumen harus diisi',

                'pengirim_sumber.required' => 'Pengirim Dokumen harus diisi',
                'perihal_isi_deskripsi.required' => ' Deskripsi Dokumen harus diisi',

                'sifat.required' => 'Sifat harus diisi',
                'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',

                'akses_golongan.required' => 'Akses Golongan Harus Diisi',

                'nama_surat.required' => 'Nama Surat harus diisi',
                'scan_surat.required' => 'Scan Surat harus diisi',
                'nama_dokumen.required' => 'Nama Dokumen harus diisi',
                'klasifikasi_dokumen.required' => 'Klasifikasi Dokumen harus diisi',
            ]);
        }

        // invalid untuk disposisi ya -> penerima internal -> sppd ya
        if ($request->disposisi_ya == 'on' && $request->penerima_internal == 'on' && $request->sppd_ya == 'on') {
            $request->validate([
                // surat masuk
                'tanggal_arsip' => 'required',
                'nama_dokumen' => 'required',
                'pengirim_sumber' => 'required',
                'perihal_isi_deskripsi' => 'required',
                // disposisi
                'sifat' => 'required',
                'perihal_disposisi' => 'required',
                // sppd
                'tgl_perintah' => 'required',
                'tgl_pelaksanaan' => 'required',
                'anggaran' => 'required',
                'perihal_sppd' => 'required',

                'akses_internal' => 'required',

                'nama_surat' => 'required',
                'scan_surat' => 'required',

                'nama_dokumen' => 'required',
                'klasifikasi_dokumen' => 'required',
            ], [
                'tanggal_arsip.required' => 'Tanggal Dokumen harus diisi',

                'nama_dokumen.required' => 'Nama Dokumen harus diisi',

                'pengirim_sumber.required' => 'Pengirim Dokumen harus diisi',
                'perihal_isi_deskripsi.required' => ' Deskripsi Dokumen harus diisi',

                'sifat.required' => 'Sifat harus diisi',
                'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',

                'tgl_perintah.required' => 'Tanggal Perintah harus diisi',
                'tgl_pelaksanaan.required' => 'Tanggal Pelaksanaan harus diisi',
                'anggaran.required' => 'Anggaran harus diisi',
                'perihal_sppd.required' => 'Perihal Sppd harus diisi',
                'akses_internal.required' => 'Akses Internal Harus Diisi',

                'nama_surat.required' => 'Nama Surat harus diisi',
                'scan_surat.required' => 'Scan Surat harus diisi',

                'nama_dokumen.required' => 'Nama Dokumen harus diisi',
                'klasifikasi_dokumen.required' => 'Klasifikasi Dokumen harus diisi',
            ]);
        }

        // invalid untuk disposisi ya -> penerima internal -> sppd tidak
        if ($request->disposisi_ya == 'on' && $request->penerima_internal == 'on' && $request->sppd_tidak == 'on') {
            $request->validate([
                // surat masuk
                'tanggal_arsip' => 'required',

                'pengirim_sumber' => 'required',
                'perihal_isi_deskripsi' => 'required',
                // disposisi
                'sifat' => 'required',
                'perihal_disposisi' => 'required',

                'akses_internal' => 'required',

                'nama_surat' => 'required',
                'scan_surat' => 'required',

                'nama_dokumen' => 'required',
                'klasifikasi_dokumen' => 'required',
            ], [
                'tanggal_arsip.required' => 'Tanggal Dokumen harus diisi',



                'pengirim_sumber.required' => 'Pengirim Dokumen harus diisi',
                'perihal_isi_deskripsi.required' => ' Deskripsi Dokumen harus diisi',

                'sifat.required' => 'Sifat harus diisi',
                'perihal_disposisi.required' => 'Perihal Disposisi harus diisi',

                'akses_internal.required' => 'Akses Internal Harus Diisi',

                'nama_surat.required' => 'Nama Surat harus diisi',
                'scan_surat.required' => 'Scan Surat harus diisi',

                'nama_dokumen.required' => 'Nama Dokumen harus diisi',
                'klasifikasi_dokumen.required' => 'Klasifikasi Dokumen harus diisi',
            ]);
        }

        // invalid untuk disposisi tidak -> penerima satuan -> sppd tidak
        if ($request->disposisi_tidak == 'on') {
            $request->validate([
                // surat masuk
                'tanggal_arsip' => 'required',
                'pengirim_sumber' => 'required',
                'perihal_isi_deskripsi' => 'required',
                'nama_surat' => 'required',
                'scan_surat' => 'required',
                'nama_dokumen' => 'required',
                'klasifikasi_dokumen' => 'required',
            ], [
                'tanggal_arsip.required' => 'Tanggal Dokumen harus diisi',
                'pengirim_sumber.required' => 'Pengirim Dokumen harus diisi',
                'perihal_isi_deskripsi.required' => ' Deskripsi Dokumen harus diisi',
                'nama_surat.required' => 'Nama Surat harus diisi',
                'scan_surat.required' => 'Scan Surat harus diisi',
                'nama_dokumen.required' => 'Nama Dokumen harus diisi',
                'klasifikasi_dokumen.required' => 'Klasifikasi Dokumen harus diisi',
            ]);
        }



        $anggaran = str_replace('.', '',  $request->anggaran);

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
            ]);
        }

        // $file = $request->file('scan_surat');
        // $ext_logo = $file->extension();
        // $filename_scan = $file->storeAs('/lampiran', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext_logo, ['disk' => 'lampiran']);
        // LampiranArsip::create([
        //     'lampiran_arsip_id' => uniqid(),
        //     'arsip_digital_id' => $arsip_digital_id,
        //     'nama' => $request->nama_surat,
        //     'jenis' => 'Scan Surat',
        //     'file' => $filename_scan,
        // ]);

        // if ($request->file != null &&  $request->nama) {
        //     if ($request->nama && count($request->nama) > 0) {
        //         $a = 0;
        //         foreach ($request->file('lampiran') as $index) {

        //             $file = $index;
        //             $ext_logo = $file->extension();

        //             $filename_lampiran = $file->storeAs('/lampiran', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext_logo, ['disk' => 'lampiran']);
        //             $validatedData['lampiran_arsip_id'] = uniqid();
        //             $validatedData['arsip_digital_id'] = $arsip_digital_id;
        //             $validatedData['nama'] = $request->nama[$a];
        //             $validatedData['jenis'] = 'Lampiran';
        //             $validatedData['file'] = $filename_lampiran;
        //             LampiranArsip::create($validatedData);

        //             $a++;
        //         }
        //     }
        // }

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
        alert()->success('Arsip Dokumen ' . $cek . ' Berhasil Ditambahkan');


        if (Auth::user()->gocap_id_pc_pengurus != null) {
            return redirect('/' . $request->role . '/arsip/detail_dokumen_digital/' . $arsip_digital_id . '/pc')->with('success', 'Data berhasil ditambahkan');
        } elseif (Auth::user()->gocap_id_upzis_pengurus != null) {
            return redirect('/' . $request->role . '/arsip/detail_dokumen_digital/' . $arsip_digital_id . '/upzis')->with('success', 'Data berhasil ditambahkan');
        }
    }


    public function jenis_klasifikasi_dokumen(Request $request, $hal)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $title = 'JENIS KLASIFIKASI DOKUMEN';
        $hal = $hal;
        $tahuns = '';
        $bulans = '';
        $asal_memos = '';
        $jenis_klasifikasi_dokumen = JenisKlasifikasiDokumen::all();
        if ($hal == 'pc') {
            $page = "pc_kegiatan";
            $halaman = "Klasifikasi Dokumen LAZISNU";
        } else {
            $page = "upzis_kegiatan";
            $halaman = 'Klasifikasi Dokumen UPZIS';
        }
        $page = "Klasifikasi Dokumen";
        return view('dokumen.klasifikasi_dokumen', compact('hal', 'halaman', 'page', 'tahuns', 'jenis_klasifikasi_dokumen', 'title', 'bulans', 'asal_memos'));
    }

    public function aksi_tambah_jenis_klasifikasi_dokumen(Request $request)
    {
        JenisKlasifikasiDokumen::create([
            'jenis_klasifikasi_dokumen_id' => uniqid(),
            'id_pembuat' => Auth::user()->id_pengguna,
            'nama_klasifikasi_dokumen' => $request->nama_klasifikasi_dokumen

        ]);

        alert()->success('success', 'Data berhasil ditambahkan');
        return back();
    }

    public function aksi_edit_jenis_klasifikasi_dokumen(Request $request, $id)
    {
        JenisKlasifikasiDokumen::where('jenis_klasifikasi_dokumen_id', $id)->update([
            'nama_klasifikasi_dokumen' => $request->nama_klasifikasi_dokumen,
        ]);
        alert()->success('success', 'Data berhasil diubah');
        return back();
    }

    public function aksi_hapus_jenis_klasifikasi_dokumen($id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        DB::table('jenis_klasifikasi_dokumen')->where('jenis_klasifikasi_dokumen_id', $id)->delete();


        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('Jenis Kegiatan ' . $cek . ' Berhasil Dihapus');
        return back();
    }
}
