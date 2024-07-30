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
use App\Models\Notulen;
use App\Models\UpzisPengurus;
use App\Models\PengurusJabatan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



class KegiatanController extends Controller
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

    public function kegiatan_pc($hal)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $title = 'KEGIATAN & NOTULEN ';
        $tahuns = '';
        $bulans = '';
        $jenis_kegiatans = '';
        $hal = $hal;



        if ($hal == 'pc') {
            $page = "pc_kegiatan";
            $halaman = "Kegiatan LAZISNU";
            $kegiatan = Kegiatan::where('lembaga', 'PC')->orderby('created_at', 'desc')->get();
        } else {
            $page = "upzis_kegiatan";
            $halaman = 'Kegiatan UPZIS';
            $kegiatan = Kegiatan::where('lembaga', 'UPZIS')->orderby('created_at', 'desc')->get();
        }


        return view('kegiatan.kegiatan', compact('halaman', 'kegiatan', 'page', 'hal', 'tahuns',  'title', 'bulans', 'jenis_kegiatans'));
    }

    public function kegiatan_upzis()
    {

        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $title = 'KEGIATAN & NOTULEN ';
        $tahuns = '';
        $bulans = '';
        $jenis_kegiatans = '';

        $page = "upzis_kegiatan";
        $halaman = 'Kegiatan UPZIS';
        $kegiatan = Kegiatan::where('lembaga', 'UPZIS')->where('id_upzis', Auth::user()->UpzisPengurus->id_upzis)->orderby('created_at', 'desc')->get();
        //dd(Kegiatan::where('pembuat', Auth::user()->pengguna_id)->where('lembaga', 'UPZIS')->get());
        // $kegiatan = Kegiatan::where('pembuat', Auth::user()->pengguna_id)->get();

        return view('kegiatan.kegiatan', compact('halaman', 'kegiatan', 'page',  'tahuns',  'title', 'bulans', 'jenis_kegiatans'));
    }

    public function jenis_kegiatan(Request $request, $hal)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $title = 'KEGIATAN & NOTULEN ';
        $hal = $hal;
        $tahuns = '';
        $bulans = '';
        $asal_memos = '';
        $jenis_kegiatan = JenisKegiatan::all();
        if ($hal == 'pc') {
            $page = "pc_kegiatan";
            $halaman = "Kegiatan LAZISNU";
        } else {
            $page = "upzis_kegiatan";
            $halaman = 'Kegiatan UPZIS';
        }
        $page = "Jenis Kegiatan";
        return view('kegiatan.jenis_kegiatan', compact('hal', 'halaman', 'page', 'tahuns', 'jenis_kegiatan', 'title', 'bulans', 'asal_memos'));
    }

    public function jenis_kegiatan_upzis(Request $request)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $title = 'KEGIATAN & NOTULEN ';
        $tahuns = '';
        $bulans = '';
        $asal_memos = '';
        $jenis_kegiatan = JenisKegiatan::all();

        $page = "upzis_kegiatan";
        $halaman = 'Kegiatan UPZIS';

        $page = "Jenis Kegiatan";
        return view('kegiatan.jenis_kegiatan', compact('halaman', 'page', 'tahuns', 'jenis_kegiatan', 'title', 'bulans', 'asal_memos'));
    }

    public function aksi_tambah_kegiatan(Request $request)
    {
        $siftnu = config('app.database_siftnu');
        if (Pengguna::where('id_pengguna', Auth::user()->id_pengguna)->where('gocap_id_pc_pengurus', '!=', null)->first()) {
            $lembaga = 'PC';
        } elseif (Pengguna::where('id_pengguna', Auth::user()->id_pengguna)->where('gocap_id_upzis_pengurus', '!=', null)->first()) {
            $lembaga = 'UPZIS';
        }
        $anggaran = str_replace('.', '',  $request->estimasi_biaya_kegiatan);

        $kegiatan_id = uniqid();

        if (Auth::user()->gocap_id_pc_pengurus != NULL) {
            Kegiatan::create([
                'kegiatan_id' => $kegiatan_id,
                'tgl_kegiatan' => $request->tgl_kegiatan,
                'nama_kegiatan' => $request->nama_kegiatan,
                'jenis_kegiatan' => $request->jenis_kegiatan,
                'lokasi_kegiatan' => $request->lokasi_kegiatan,
                'pelaksana_kegiatan' => $request->pelaksana_kegiatan,
                'penanggungjawab_kegiatan' => $request->penanggungjawab_kegiatan,
                'estimasi_biaya_kegiatan' => $anggaran,
                'capaian_kegiatan' => $request->capaian_kegiatan,
                'kendala_kegiatan' => $request->kendala_kegiatan,
                'ringkasan_kegiatan' => $request->ringkasan_kegiatan,
                'solusi_kegiatan' => $request->solusi_kegiatan,
                'lembaga' =>  $lembaga,
                'pembuat' => Auth::user()->id_pengguna,
                'hadir' => 0,
                'tidak_hadir' => 0,
                'distribusi' => 0,
            ]);
        } elseif (Auth::user()->gocap_id_upzis_pengurus != NULL) {
            Kegiatan::create([
                'kegiatan_id' => $kegiatan_id,
                'tgl_kegiatan' => $request->tgl_kegiatan,
                'nama_kegiatan' => $request->nama_kegiatan,
                'jenis_kegiatan' => $request->jenis_kegiatan,
                'lokasi_kegiatan' => $request->lokasi_kegiatan,
                'pelaksana_kegiatan' => $request->pelaksana_kegiatan,
                'penanggungjawab_kegiatan' => $request->penanggungjawab_kegiatan,
                'estimasi_biaya_kegiatan' => $anggaran,
                'capaian_kegiatan' => $request->capaian_kegiatan,
                'kendala_kegiatan' => $request->kendala_kegiatan,
                'ringkasan_kegiatan' => $request->ringkasan_kegiatan,
                'solusi_kegiatan' => $request->solusi_kegiatan,
                'lembaga' =>  $lembaga,
                'id_upzis' => Auth::user()->UpzisPengurus->id_upzis,
                'pembuat' => Auth::user()->id_pengguna,
                'hadir' => 0,
                'tidak_hadir' => 0,
                'distribusi' => 0,
            ]);
        }


        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('Data Kegiatan ' . $cek . ' Berhasil Ditambahkan');
        // if (Auth::user()->gocap_id_pc_pengurus != null) {
        //     return redirect('/pc/arsip/kegiatan_pc/pc');
        // } elseif (Auth::user()->gocap_id_upzis_pengurus != null) {
        //     return redirect('/upzis/arsip/kegiatan_upzis/');
        // }

        if (Auth::user()->gocap_id_pc_pengurus != null) {
            return redirect('/pc/arsip/detail_kegiatan/' . $kegiatan_id . '/pc')->with('success', 'Data berhasil ditambahkan');
        } elseif (Auth::user()->gocap_id_upzis_pengurus != null) {
            return redirect('/upzis/arsip/detail_kegiatan_upzis/' . $kegiatan_id . '/')->with('success', 'Data berhasil ditambahkan');
        }
    }

    public function aksi_tambah_file_kegiatan(Request $request)
    {
        $siftnu = config('app.database_siftnu');
        $file = $request->file('file_foto_kegiatan');
        $ext = $file->extension();
        $filename = $file->storeAs('/file_foto_kegiatan', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext, ['disk' => 'file_foto_kegiatan']);

        FileKegiatan::create([
            'file_foto_kegiatan_id' => uniqid(),
            'kegiatan_id' => $request->kegiatan_id,
            'judul_foto_kegiatan' => $request->judul_foto_kegiatan,
            'file_foto_kegiatan' => $filename,

        ]);


        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('Foto Dokumentasi Kegiatan ' . $cek . ' Berhasil Ditambahkan');
        return redirect()->back()->with('code', true);
    }

    public function aksi_edit_kegiatan(Request $request, $id)
    {
        $siftnu = config('app.database_siftnu');
        $anggaran = str_replace('.', '',  $request->estimasi_biaya_kegiatan);

        Kegiatan::where('kegiatan_id', $id)->update([
            'nama_kegiatan' => $request->nama_kegiatan,
            'jenis_kegiatan' => $request->jenis_kegiatan,
            'lokasi_kegiatan' => $request->lokasi_kegiatan,
            'pelaksana_kegiatan' => $request->pelaksana_kegiatan,
            'penanggungjawab_kegiatan' => $request->penanggungjawab_kegiatan,
            'estimasi_biaya_kegiatan' => $anggaran,
            'capaian_kegiatan' => $request->capaian_kegiatan,
            'kendala_kegiatan' => $request->kendala_kegiatan,
            'ringkasan_kegiatan' => $request->ringkasan_kegiatan,
            'solusi_kegiatan' => $request->solusi_kegiatan,
        ]);



        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('Data Kegiatan ' . $cek . ' Berhasil Diubah');
        return back();
    }

    public function aksi_edit_file_kegiatan(Request $request, $id)
    {
        $siftnu = config('app.database_siftnu');
        $file = $request->file('file_foto_kegiatan');
        if ($file) {
            $file = $request->file('file_foto_kegiatan');
            $ext = $file->extension();
            $filename = $file->storeAs('/file_foto_kegiatan', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext, ['disk' => 'file_foto_kegiatan']);

            FileKegiatan::where('file_foto_kegiatan_id', $id)->update([
                'judul_foto_kegiatan' => $request->judul_foto_kegiatan,
                'file_foto_kegiatan' => $filename,
            ]);
            unlink('file_foto_kegiatan/' . $request->file_foto_kegiatan_lama);
        } else {
            FileKegiatan::where('file_foto_kegiatan_id', $id)->update([
                'judul_foto_kegiatan' => $request->judul_foto_kegiatan,
            ]);
        }


        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('Foto Kegiatan ' . $cek . ' Berhasil Diubah');
        return redirect()->back()->with('code', true);
    }

    public function aksi_tambah_jenis_kegiatan(Request $request)
    {
        JenisKegiatan::create([
            'jenis_kegiatan_id' => uniqid(),
            'jenis_kegiatan' => $request->jenis_kegiatan,
        ]);

        alert()->success('success', 'Data berhasil ditambahkan');
        return back();
    }

    public function aksi_edit_jenis_kegiatan(Request $request, $id)
    {
        JenisKegiatan::where('jenis_kegiatan_id', $id)->update([
            'jenis_kegiatan' => $request->jenis_kegiatan,
        ]);
        alert()->success('success', 'Data berhasil diubah');
        return back();
    }

    public function aksi_hapus_kegiatan($id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');


        $file_kegiatan = FileKegiatan::where('kegiatan_id', $id)->get();
        if ($file_kegiatan != NULL) {
            foreach ($file_kegiatan as $a) {
                $path = public_path() . "/file_foto_kegiatan/" .  $a->file_foto_kegiatan;
                if (file_exists($path)) {
                    unlink($path);
                }
            }
        }

        Kegiatan::where('kegiatan_id', $id)->delete();
        FileKegiatan::where('kegiatan_id', $id)->delete();
        Notulen::where('kegiatan_id', $id)->delete();


        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('Kegiatan ' . $cek . ' Berhasil Dihapus');

        if (Auth::user()->gocap_id_pc_pengurus != null) {
            return redirect('/pc/arsip/kegiatan_pc/pc');
        } elseif (Auth::user()->gocap_id_upzis_pengurus != null) {
            return redirect('/upzis/arsip/kegiatan_upzis/');
        }
    }

    public function aksi_hapus_jenis_kegiatan($id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        DB::table('jenis_kegiatan')->where('jenis_kegiatan_id', $id)->delete();


        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('Jenis Kegiatan ' . $cek . ' Berhasil Dihapus');
        return back();
    }

    public function aksi_hapus_file_kegiatan(Request $request, $id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        DB::table('file_kegiatan')->where('file_foto_kegiatan_id', $id)->delete();
        unlink('file_foto_kegiatan/' . $request->file_foto_kegiatan);


        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('Foto Kegiatan ' . $cek . ' Berhasil Dihapus');
        return redirect()->back()->with('code', true);
    }

    public function detail_kegiatan($id, $hal)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $title = 'KEGIATAN & NOTULEN ';
        $tahuns = '';
        $bulans = '';
        $asal_memos = '';
        $hal = $hal;
        $kegiatan = Kegiatan::where('kegiatan_id', $id)->first();
        $filekegiatan = FileKegiatan::where('kegiatan_id', $id)->get();
        $jenis_kegiatan = JenisKegiatan::all();
        $file_kegiatan = FileKegiatan::where('kegiatan_id', $id)->get();

        if ($hal == 'pc') {
            $page = "pc_kegiatan";
            $halaman = "Detail Kegiatan";
            $hals = "Kegiatan LAZISNU";
        } else {
            $page = "upzis_kegiatan";
            $halaman = 'Detail Kegiatan ';
            $hals = "Kegiatan UPZIS";
        }

        return view('kegiatan.detail_kegiatan', compact('file_kegiatan', 'jenis_kegiatan', 'filekegiatan', 'halaman', 'hals', 'kegiatan', 'page', 'hal', 'tahuns',  'title', 'bulans', 'asal_memos'));
    }

    public function detail_kegiatan_upzis($id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $title = 'KEGIATAN & NOTULEN ';
        $tahuns = '';
        $bulans = '';
        $asal_memos = '';
        $kegiatan = Kegiatan::where('kegiatan_id', $id)->first();
        $filekegiatan = FileKegiatan::where('kegiatan_id', $id)->get();
        $jenis_kegiatan = JenisKegiatan::all();
        $file_kegiatan = FileKegiatan::where('kegiatan_id', $id)->get();


        $page = "upzis_kegiatan";
        $halaman = 'Detail Kegiatan ';
        $hals = "Kegiatan UPZIS";

        return view('kegiatan.detail_kegiatan', compact('file_kegiatan', 'jenis_kegiatan', 'filekegiatan', 'halaman', 'hals', 'kegiatan', 'page', 'tahuns',  'title', 'bulans', 'asal_memos'));
    }
}
