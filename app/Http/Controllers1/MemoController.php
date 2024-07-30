<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Pc;
use App\Models\Memo;
use App\Models\Upzis;
use App\Models\Ranting;
use App\Models\FileMemo;
use App\Models\Pengguna;
use App\Models\Disposisi;
use App\Models\PcPengurus;
use Illuminate\Http\Request;
use App\Models\UpzisPengurus;
use App\Models\PengurusJabatan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MemoController extends Controller
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

    public function memo()
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $title = 'MEMO INTERNAL';
        $tahuns = '';
        $bulans = '';
        $asal_memos = '';
        $page = "Memo Internal";


        $tahun_memo = Memo::select(DB::raw('YEAR(tanggal_memo) as year'))->groupBy('year')->orderBy('year', 'DESC')->get();
        if (Auth::user()->gocap_id_pc_pengurus != null) {

            if (
                Auth::user()->PcPengurus->PengurusJabatan->jabatan == 'Direktur Eksekutif' ||
                Auth::user()->PcPengurus->PengurusJabatan->jabatan == 'Ketua Pengurus Harian'
            ) {
                $memo = DB::table('memo')->join($siftnu . '.pengguna', $siftnu . '.pengguna.id_pengguna', '=', $earsip . '.memo.id_pengguna')
                    ->select('memo.*', $siftnu . '.pengguna.nama', $siftnu . '.pengguna.gocap_id_pc_pengurus')
                    ->where('id_daerah', Auth::user()->PcPengurus->id_pc)
                    ->orderby('created_at', 'desc')
                    ->get();
            } else {
                $memo = DB::table('memo')->join($siftnu . '.pengguna', $siftnu . '.pengguna.id_pengguna', '=', $earsip . '.memo.id_pengguna')
                    ->join($earsip . '.disposisi', $earsip . '.disposisi.id_memo', '=', $earsip . '.memo.id_memo')
                    ->select('memo.*', $siftnu . '.pengguna.nama', $siftnu . '.pengguna.gocap_id_pc_pengurus')
                    ->where('disposisi.id_pengurus_internal', Auth::user()->PcPengurus->id_pc_pengurus)
                    ->orderby('created_at', 'desc')
                    ->get();
            }
        }

        // } elseif (Auth::user()->gocap_id_upzis_pengurus != null) {
        //     $memo = DB::table('memo')->join($siftnu . '.pengguna', $siftnu . '.pengguna.id_pengguna', '=', $earsip . '.memo.id_pengguna')
        //         ->select('memo.*', $siftnu . '.pengguna.nama', $siftnu . '.pengguna.gocap_id_upzis_pengurus')
        //         ->where('id_daerah', Auth::user()->UpzisPengurus->id_upzis)
        //         ->orderby('created_at', 'desc')
        //         ->get();
        // }

        return view('memo.memo', compact('page', 'tahuns', 'tahun_memo', 'title', 'memo', 'bulans', 'asal_memos'));
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
                ->select($siftnu . '.pengguna.nama', $siftnu . '.pengguna.gocap_id_pc_pengurus', $siftnu . '.pengguna.nohp', $earsip . '.disposisi.status_baca', $gocap . '.pc_pengurus.id_pengurus_jabatan')->get();

            $baca_internal_jumlah =  Disposisi::join($siftnu . '.pengguna', $siftnu . '.pengguna.gocap_id_pc_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->join($gocap . '.pc_pengurus', $gocap . '.pc_pengurus.id_pc_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->where('disposisi.id_memo', '=', $id_memo)
                ->select($siftnu . '.pengguna.nama', $siftnu . '.pengguna.gocap_id_pc_pengurus', $earsip . '.disposisi.status_baca', $gocap . '.pc_pengurus.id_pengurus_jabatan')->count();
        }


        if (Auth::user()->gocap_id_upzis_pengurus != NULL) {

            $subjab =  Memo::join($siftnu . '.pengguna', $siftnu . '.pengguna.id_pengguna', '=', $earsip . '.memo.id_pengguna')
                ->where($earsip . '.memo.id_memo', '=', $id)->select($siftnu . '.pengguna.gocap_id_upzis_pengurus')->first();

            $jabatan = UpzisPengurus::where('id_upzis_pengurus', $subjab->gocap_id_upzis_pengurus)->select('id_pengurus_jabatan')->first();

            $detail_jabatan = PengurusJabatan::where('id_pengurus_jabatan', $jabatan->id_pengurus_jabatan)->select('jabatan')->get();

            $baca_internal =  Disposisi::join($siftnu . '.pengguna', $siftnu . '.pengguna.gocap_id_upzis_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->join($gocap . '.upzis_pengurus', $gocap . '.upzis_pengurus.id_upzis_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->where('disposisi.id_memo', '=', $id_memo)
                ->select($siftnu . '.pengguna.nama', $siftnu . '.pengguna.gocap_id_upzis_pengurus', $siftnu . '.pengguna.nohp', $earsip . '.disposisi.status_baca', $gocap . '.upzis_pengurus.id_pengurus_jabatan')->get();

            $baca_internal_jumlah =  Disposisi::join($siftnu . '.pengguna', $siftnu . '.pengguna.gocap_id_upzis_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->join($gocap . '.upzis_pengurus', $gocap . '.upzis_pengurus.id_upzis_pengurus', '=', $earsip . '.disposisi.id_pengurus_internal')
                ->where('disposisi.id_memo', '=', $id_memo)
                ->select($siftnu . '.pengguna.nama', $siftnu . '.pengguna.gocap_id_upzis_pengurus', $earsip . '.disposisi.status_baca', $gocap . '.upzis_pengurus.id_pengurus_jabatan')->count();
        }


        if (DB::table('memo')->where('id_pengguna', Auth::user()->id_pengguna)->where('id_memo', $memo->id_memo)->first()) {
            $info = 'Diteruskan';
        } else {
            $info = 'Diterima';
        }
        return view('memo.detail_memo', compact('kepada', 'initPermissions', 'detail_jabatan', 'jabatan', 'baca_internal_jumlah', 'nama_pengurus', 'memo', 'page', 'lampiran', 'id_memo', 'lampiran_file', 'sppd', 'disposisi', 'title', 'baca_internal', 'info'));
    }

    public function kirim_notifikasi_memo(Request $request)
    {

        $this->notif(
            $request->nohp,
            "Assalamualaikum warahmatullahi wabarakatuh, "
                . "*" . $request->nama .  "*" . "\n" . "\n" .
                "Anda menerima memo internal dengan rincian sebagai berikut: " . "\n" . "\n" .
                "Nomor " .  "*" .  $request->nomor_memo  . "*" .  "\n" .
                "Tanggal " .   $request->tanggal_memo  .  "\n" .
                "Pengirim: " .   Auth::user()->nama .   "\n" .
                "Perihal: " .   $request->hal  . "\n" . "\n" .
                "Mohon untuk segera dilihat melalui E-Arsip. Terima Kasih." . "\n" . "e-arsip.nucarecilacap.id"
        );


        alert()->success('Notifikasi WhatsApp Berhasil Dikirim ' . $request->nama . '');

        return back()->with('success', 'Data berhasil ditambahkan');
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

        return $pdf->stream()->withHeaders([
            'Title' => 'Your meta title',
            'Content-Type' => 'application/pdf',
            'Cache-Control' => 'no-store, no-cache',
            'Content-Disposition' => 'filename="' . $memo->nomor_memo . '.pdf',
        ]);
    }

    public function aksi_hapus_memo(Request $request, $id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');


        $file_memo = FileMemo::where('id_memo', $id)->get();
        if ($file_memo != NULL) {
            foreach ($file_memo as $a) {
                $path = public_path() . "/file_memo/" .  $a->file;
                if (file_exists($path)) {
                    unlink($path);
                }
            }
        }

        FileMemo::where('id_memo', $id)->delete();
        Memo::where('id_memo', $id)->delete();

        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('Memo Internal ' . $cek . ' Berhasil Dihapus');

        if (Auth::user()->gocap_id_pc_pengurus != null) {
            return redirect('/pc/arsip/memo');
        } elseif (Auth::user()->gocap_id_upzis_pengurus != null) {
            return redirect('/upzis/arsip/memo');
        }
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

        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('File Memo Internal ' . $cek . ' Berhasil Ditambahkan');
        return back()->with('success', 'Data berhasil ditambahkan');
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

        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('File Memo Internal ' . $cek . ' Berhasil Diubah');


        return back()->with('success', 'Data berhasil diubah');
    }

    public function aksi_hapus_file_memo(Request $request, $id)
    {

        $FileMemo = FileMemo::where('id_file_memo', $id)->first();
        $path = public_path() . "/file_memo/" .  $FileMemo->file;
        if (file_exists($path)) {
            unlink($path);
        }
        FileMemo::where('id_file_memo', $id)->delete();

        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');





        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('File Memo Internal ' . $cek . ' Berhasil Dihapus');

        return back();
    }

    public function aksi_edit_memo(Request $request, $id)
    {

        Memo::where('id_memo', $id)->update([
            'hal' => $request->hal,
            'isi_memo' => $request->isi_memo,
        ]);

        $dis =  Disposisi::where('id_memo', $id)->first();
        Disposisi::where('id_memo', $id)->delete();

        $b = 0;
        if ($request->kepada != null) {
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
        } else {
            Disposisi::create([
                'disposisi_id' => uniqid(),
                'id_memo' => $id,
                'sifat' => $request->sifat,
                'perihal' => $request->perihal_disposisi,
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
        alert()->success('Memo Internal ' . $cek . ' Berhasil Diubah');


        return Redirect()->back()->with('success', 'Data berhasil diubah');
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

    public function aksi_tambah_memo(Request $request)
    {

        // invalid untuk disposisi ya -> penerima golongan -> sppd ya

        $request->validate([
            // memo
            'tanggal_memo' => 'required',
            'nomor_memo' => 'required',
            'hal' => 'required',
            'isi_memo' => 'required',
            // disposisi
            'sifat' => 'required',
            'akses_internal' => 'required',
        ], [
            'tanggal_memo.required' => 'Tanggal Memo harus diisi',
            'nomor_memo.required' => 'Nomor Surat harus diisi',
            'hal.required' => 'Hal Memo harus diisi',
            'isi_memo.required' => 'Isi Memo harus diisi',
            'sifat.required' => 'Sifat harus diisi',
            'akses_internal.required' => 'Daftar penerima memo harus diisi',
        ]);


        // id arsip digital
        $id_memo = uniqid();
        // masukkan ke tabel arsip_digital
        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $id_jabatan =  PcPengurus::where('id_pc_pengurus', Auth::user()->gocap_id_pc_pengurus)->first();
            $jabatan = PengurusJabatan::where('id_pengurus_jabatan', $id_jabatan->id_pengurus_jabatan)->first();
            Memo::create([
                'id_memo' => $id_memo,
                'id_pengguna' => Auth::user()->id_pengguna,
                'tanggal_memo' => now(),
                'asal_memo' => $jabatan->jabatan,
                'nomor_memo' => $request->nomor_memo,
                'no_urut' => $request->no_urut,
                'hal' => $request->hal,
                'isi_memo' => $request->isi_memo,
                'id_daerah' => Auth::user()->PcPengurus->id_pc,
            ]);

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
        } elseif (Auth::user()->gocap_id_upzis_pengurus) {
            $id_jabatan = UpzisPengurus::where('id_upzis_pengurus', Auth::user()->gocap_id_upzis_pengurus)->first();
            $jabatan = PengurusJabatan::where('id_pengurus_jabatan', $id_jabatan->id_pengurus_jabatan)->first();
            Memo::create([
                'id_memo' => $id_memo,
                'id_pengguna' => Auth::user()->id_pengguna,
                'tanggal_memo' => now(),
                'asal_memo' => $jabatan->jabatan,
                'nomor_memo' => $request->nomor_memo,
                'no_urut' => $request->no_urut,
                'hal' => $request->hal,
                'isi_memo' => $request->isi_memo,
                'id_daerah' => Auth::user()->UpzisPengurus->id_upzis,
            ]);

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

        if ($request->file_memo != null) {
            $file = $request->file('file_memo');
            $ext_logo = $file->extension();
            $filename_scan = $file->storeAs('/file_memo', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext_logo, ['disk' => 'file_memo']);
            FileMemo::create([
                'id_file_memo' => uniqid(),
                'id_memo' => $id_memo,
                'nama' => $request->nama_surat,
                'file' => $filename_scan,
            ]);
        }

        if ($request->lampiran != null) {
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
        }

        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        //Nanti Di UnComment Lagi
        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $posts1 =  Pengguna::whereIn('gocap_id_pc_pengurus', $request->akses_internal)->select('nohp', 'nama')->get();

            foreach ($posts1 as $post1) {
                $this->notif(
                    $post1->nohp,
                    "Assalamualaikum warahmatullahi wabarakatuh, "
                        . "*" . $post1->nama .  "*" . "\n" . "\n" .
                        "Anda menerima memo internal dengan rincian sebagai berikut: " . "\n" . "\n" .
                        "Nomor " .  "*" .  $request->nomor_memo  . "*" .  "\n" .
                        "Tanggal " .   $request->tanggal_memo  .  "\n" .
                        "Pengirim: " .   Auth::user()->nama .   "\n" .
                        "Perihal: " .   $request->hal  . "\n" . "\n" .
                        "Mohon untuk segera dilihat melalui E-Arsip. Terima Kasih." . "\n" . "e-arsip.nucarecilacap.id"
                );
            };
        }

        if (Auth::user()->gocap_id_upzis_pengurus != null) {
            $posts2 =  Pengguna::whereIn('gocap_id_upzis_pengurus', $request->akses_internal)->select('nohp', 'nama')->get();
            foreach ($posts2 as $post2) {
                $this->notif(
                    $post2->nohp,
                    "Assalamualaikum warahmatullahi wabarakatuh, "
                        . "*" . $post2->nama .  "*" . "\n" . "\n" .
                        "Anda menerima memo internal dengan rincian sebagai berikut: " . "\n" . "\n" .
                        "Nomor " .  "*" .  $request->nomor_memo  . "*" .  "\n" .
                        "Tanggal " .   $request->tanggal_memo  .  "\n" .
                        "Pengirim: " .   Auth::user()->nama .   "\n" .
                        "Perihal: " .   $request->hal  . "\n" . "\n" .
                        "Mohon untuk segera dilihat melalui E-Arsip. Terima Kasih." . "\n" . "e-arsip.nucarecilacap.id"
                );
            };
        }



        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('Memo Internal ' . $cek . ' Berhasil Ditambahkan');
        return redirect('/' . $request->role . '/detail_memo/' . $id_memo)->with('success', 'Data berhasil ditambahkan');
    }
}
