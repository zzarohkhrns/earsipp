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

class FilterSuratMasukController extends Controller
{
    public function __construct()
    {
        view()->composer('*', function ($view) {
            $tahun_arsip = ArsipDigital::where('jenis_arsip', 'Surat Masuk')->select(DB::raw('YEAR(tanggal_arsip) as year'))->groupBy('year')->orderBy('year', 'DESC')->get();
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
                ->with('tahun_arsip', $tahun_arsip)
                ->with('pc', $pc)
                ->with('akses', $akses)
                ->with('ranting', $ranting)
                ->with('wilayah', $wilayah)
                ->with('ketua_upzis', $ketua_upzis)
                ->with('pengurus', $pengurus);
        });
    }


    public function filter_surat_masuk(Request $request, $part, $hal)
    {


        $hal = $hal;
        $part = $part;
        $disposisis = $request->disposisi;
        $tahuns = $request->tahun;
        $bulans = $request->bulan;
        $klasifikasis = $request->klasifikasi;
        $tahun = DB::table('arsip_digital')->select('tanggal_arsip')->groupBy('tanggal_arsip')->distinct()->get();
        $title = 'ARSIP SURAT MASUK';
        $page = 'Surat Masuk';
        $this->klasifikasi = $request->klasifikasi;
        $this->disposisi = $request->disposisi;
        $this->bulan = $request->bulan;
        $this->tahun = $request->tahun;

        if ($hal == 'pc') {
            $hal = 'pc';
            $part = "pc_keluar";
            $head = "Lazisnu";
            $dari = 'PC';
            if (Auth::user()->gocap_id_pc_pengurus != null) {


                $arsip_diterima = '';

                $arsip_dikirim = DB::table('arsip_digital')
                    ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                    ->where('arsip_digital.jenis_arsip', 'Surat Masuk')
                    ->where('tujuan_arsip', 'like', "%" . 'PC' . "%")
                    ->distinct('arsip_digital.arsip_digital_id')

                    // filter klasifikasi
                    ->when($this->klasifikasi, function ($query) {
                        return $query->where('arsip_digital.klasifikasi_surat', $this->klasifikasi);
                    })

                    // filter disposisi
                    ->when($this->disposisi, function ($query) {
                        return $query->where('arsip_digital.jenis_disposisi', $this->disposisi);
                    })

                    // filter bulan
                    ->when($this->bulan, function ($query) {
                        return $query->whereMonth('arsip_digital.tanggal_arsip', $this->bulan);
                    })
                    // filter tahun
                    ->when($this->tahun, function ($query) {
                        return $query->whereYear('arsip_digital.tanggal_arsip', $this->tahun);
                    })
                    ->select('arsip_digital.*')->orderby('created_at', 'desc')
                    ->get();
            }

            if (Auth::user()->gocap_id_upzis_pengurus != null) {

                $arsip_diterima = '';

                $arsip_dikirim = DB::table('arsip_digital')
                    ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                    ->where('arsip_digital.jenis_arsip', 'Surat Masuk')
                    ->where('tujuan_arsip', 'like', "%" . 'PC' . "%")
                    ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                    ->distinct('arsip_digital.arsip_digital_id')

                    // filter klasifikasi
                    ->when($this->klasifikasi, function ($query) {
                        return $query->where('arsip_digital.klasifikasi_surat', $this->klasifikasi);
                    })

                    // filter disposisi
                    ->when($this->disposisi, function ($query) {
                        return $query->where('arsip_digital.jenis_disposisi', $this->disposisi);
                    })

                    // filter bulan
                    ->when($this->bulan, function ($query) {
                        return $query->whereMonth('arsip_digital.tanggal_arsip', $this->bulan);
                    })
                    // filter tahun
                    ->when($this->tahun, function ($query) {
                        return $query->whereYear('arsip_digital.tanggal_arsip', $this->tahun);
                    })
                    ->select('arsip_digital.*')->orderby('created_at', 'desc')
                    ->get();
            }
        }

        if ($hal == 'upzis') {

            $hal = 'upzis';
            $part = "upzis_keluar";
            $head = "Upzis";
            $dari = 'Upzis';

            if (Auth::user()->gocap_id_pc_pengurus != null) {

                $arsip_dikirim = DB::table('arsip_digital')
                    ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                    ->where('arsip_digital.jenis_arsip', 'Surat Masuk')->where('tujuan_arsip', 'like', "%" . 'Upzis' . "%")
                    ->distinct('arsip_digital.arsip_digital_id')

                    // filter klasifikasi
                    ->when($this->klasifikasi, function ($query) {
                        return $query->where('arsip_digital.klasifikasi_surat', $this->klasifikasi);
                    })

                    // filter disposisi
                    ->when($this->disposisi, function ($query) {
                        return $query->where('arsip_digital.jenis_disposisi', $this->disposisi);
                    })

                    // filter bulan
                    ->when($this->bulan, function ($query) {
                        return $query->whereMonth('arsip_digital.tanggal_arsip', $this->bulan);
                    })
                    // filter tahun
                    ->when($this->tahun, function ($query) {
                        return $query->whereYear('arsip_digital.tanggal_arsip', $this->tahun);
                    })
                    ->select('arsip_digital.*')->orderby('created_at', 'desc')
                    ->get();

                $arsip_diterima = DB::table('arsip_digital')
                    ->join('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                    ->where('arsip_digital.jenis_arsip', 'Surat Masuk')->where('tujuan_arsip', 'like', "%" . 'Upzis' . "%")
                    ->where('disposisi.id_pc', Auth::user()->PcPengurus->Pc->id_pc)
                    ->distinct('arsip_digital.arsip_digital_id')

                    // filter klasifikasi
                    ->when($this->klasifikasi, function ($query) {
                        return $query->where('arsip_digital.klasifikasi_surat', $this->klasifikasi);
                    })

                    // filter disposisi
                    ->when($this->disposisi, function ($query) {
                        return $query->where('arsip_digital.jenis_disposisi', $this->disposisi);
                    })

                    // filter bulan
                    ->when($this->bulan, function ($query) {
                        return $query->whereMonth('arsip_digital.tanggal_arsip', $this->bulan);
                    })
                    // filter tahun
                    ->when($this->tahun, function ($query) {
                        return $query->whereYear('arsip_digital.tanggal_arsip', $this->tahun);
                    })
                    ->select('arsip_digital.*')->orderby('created_at', 'desc')
                    ->get();
            }
            if (Auth::user()->gocap_id_upzis_pengurus != null) {

                $arsip_dikirim = DB::table('arsip_digital')
                    ->leftjoin('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                    ->where('arsip_digital.jenis_arsip', 'Surat Masuk')->where('tujuan_arsip', 'like', "%" . 'Upzis' . "%")->where('id_pengguna', Auth::user()->id_pengguna)
                    ->distinct('arsip_digital.arsip_digital_id')

                    // filter klasifikasi
                    ->when($this->klasifikasi, function ($query) {
                        return $query->where('arsip_digital.klasifikasi_surat', $this->klasifikasi);
                    })

                    // filter disposisi
                    ->when($this->disposisi, function ($query) {
                        return $query->where('arsip_digital.jenis_disposisi', $this->disposisi);
                    })

                    // filter bulan
                    ->when($this->bulan, function ($query) {
                        return $query->whereMonth('arsip_digital.tanggal_arsip', $this->bulan);
                    })
                    // filter tahun
                    ->when($this->tahun, function ($query) {
                        return $query->whereYear('arsip_digital.tanggal_arsip', $this->tahun);
                    })
                    ->select('arsip_digital.*')->orderby('created_at', 'desc')
                    ->get();

                $arsip_diterima = DB::table('arsip_digital')
                    ->join('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                    ->where('disposisi.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)->where('arsip_digital.jenis_arsip', 'Surat Masuk')->where('tujuan_arsip', 'like', "%" . 'Upzis' . "%")
                    ->distinct('arsip_digital.arsip_digital_id')

                    // filter klasifikasi
                    ->when($this->klasifikasi, function ($query) {
                        return $query->where('arsip_digital.klasifikasi_surat', $this->klasifikasi);
                    })

                    // filter disposisi
                    ->when($this->disposisi, function ($query) {
                        return $query->where('arsip_digital.jenis_disposisi', $this->disposisi);
                    })

                    // filter bulan
                    ->when($this->bulan, function ($query) {
                        return $query->whereMonth('arsip_digital.tanggal_arsip', $this->bulan);
                    })
                    // filter tahun
                    ->when($this->tahun, function ($query) {
                        return $query->whereYear('arsip_digital.tanggal_arsip', $this->tahun);
                    })
                    ->select('arsip_digital.*')->orderby('created_at', 'desc')
                    ->get();
            }
        }

        // return view('arsip.surat_masuk', compact('tahun_arsip', 'bulans', 'disposisis', 'arsip_diterima', 'arsip_dikirim', 'head', 'hal', 'page', 'title', 'klasifikasis', 'tahun', 'tahuns', 'part'));

        if ($request->filephp == 'surat_masuk') {
            return view('arsip.surat_masuk', compact('bulans', 'disposisis', 'arsip_dikirim', 'head', 'hal', 'page', 'title', 'klasifikasis', 'tahun', 'tahuns', 'part'));
        } else {
            return view('arsip.surat_masuk2', compact('bulans', 'disposisis', 'arsip_diterima', 'arsip_dikirim', 'head', 'hal', 'page', 'title', 'klasifikasis', 'tahun', 'tahuns', 'part'));
        }
    }
}
