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

class AsetController extends Controller
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
                $kategori = DB::table('kategori_aset')->where('id_pengguna', Auth::user()->id_pengguna)->get();
            } elseif (Auth::user()->gocap_id_upzis_pengurus != NULL) {
                $role = 'upzis';
                $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
                $kategori = DB::table('kategori_aset')->where('id_pengguna', Auth::user()->id_pengguna)->get();
            } elseif (Auth::user()->gocap_id_ranting_pengurus != NULL) {
                $role = 'ranting';
                $kategori = DB::table('kategori_aset')->where('id_pengguna', Auth::user()->id_pengguna)->get();
            }


            $view->with('role', $role)
                ->with('kategori', $kategori)
                ->with('wilayah', $wilayah);
        });
    }

    public function aset_umum()
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
        $tahun_perolehan = DB::table('aset')
            ->select('tahun_perolehan')
            ->where('jenis_aset', 'Umum')
            ->where('id_daerah', $id_daerah)
            ->groupBy('tahun_perolehan')
            ->get();
        $title = "DATA ASET";
        $page = 'Aset Umum';
        $link = 'umum';
        $kategoris = '';
        $kondisis = '';
        $tahuns = '';

        $aset = DB::table('aset')
            ->where('jenis_aset', 'Umum')
            ->where('id_daerah', $id_daerah)
            ->orderby('created_at', 'desc')
            ->get();

        return view('aset.aset', compact('tahun_perolehan', 'aset', 'page', 'kategoris', 'kondisis', 'tahuns', 'title', 'link'));
    }


    public function aset_wakaf()
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $title = "DATA ASET ";
        $kategoris = '';
        if (Auth::user()->gocap_id_pc_pengurus != NULL) {
            $id_daerah = Auth::user()->PcPengurus->id_pc;
        }
        if (Auth::user()->gocap_id_upzis_pengurus != NULL) {
            $id_daerah = Auth::user()->UpzisPengurus->id_upzis;
        }
        $tahun_perolehan = DB::table('aset')
            ->select('tahun_perolehan')
            ->where('jenis_aset', 'Wakaf')
            ->where('id_daerah', $id_daerah)
            ->groupBy('tahun_perolehan')
            ->get();
        $page = 'Aset Wakaf';
        $kondisis = '';
        $tahuns = '';
        $link = 'wakaf';
        $aset = DB::table('aset')
            ->where('jenis_aset', 'Wakaf')
            ->where('id_daerah', $id_daerah)
            ->orderby('created_at', 'desc')
            ->get();

        return view('aset.aset', compact('tahun_perolehan', 'aset',   'link', 'kategoris', 'kondisis', 'tahuns', 'title', 'link', 'page'));
    }


    public function kategori_aset()
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        // ->groupBy('browser')
        $link = 'kategori_aset';
        $page = 'Kategori Aset';
        $title = "DATA ASET";
        if (Auth::user()->gocap_id_pc_pengurus != NULL) {
            $id_daerah = Auth::user()->PcPengurus->id_pc;
        }
        if (Auth::user()->gocap_id_upzis_pengurus != NULL) {
            $id_daerah = Auth::user()->UpzisPengurus->id_upzis;
        }
        $kategori_aset = DB::table('kategori_aset')
            ->where('id_daerah', $id_daerah)
            ->orderby('created_at', 'desc')
            ->get();

        return view('aset.kategori_aset', compact('kategori_aset', 'title', 'page', 'link'));
    }


    public function tambah_aset(Request $request, $link)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        if ($link == 'umum') {
            $title = "DATA ASET";
            $link = "umum";
            $page = "Aset Umum";
            $page2 = "Tambah Aset Umum";
        } elseif ($link == 'wakaf') {
            $title = "DATA ASET";
            $link = "wakaf";
            $page = "Aset Wakaf";
            $page2 = "Tambah Aset Wakaf";
        }

        if (Auth::user()->gocap_id_pc_pengurus != NULL) {
            $id_daerah = Auth::user()->PcPengurus->id_pc;
        }
        if (Auth::user()->gocap_id_upzis_pengurus != NULL) {
            $id_daerah = Auth::user()->UpzisPengurus->id_upzis;
        }
        $kategori_aset = DB::table('kategori_aset')
            ->where('id_daerah', $id_daerah)
            ->orderby('created_at', 'desc')
            ->get();


        return view('aset.tambah_aset', compact('page2', 'kategori_aset',  'link', 'title', 'page'));
    }

    public function detail_aset(Request $request, $link, $id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        if ($link == 'umum') {
            $link = "umum";
            $title = "DATA ASET";
            $page = "Aset Umum";
            $page2 = "Detail Aset Umum";
        } elseif ($link == 'wakaf') {
            $link = "wakaf";
            $title = "DATA ASET";
            $page = "Aset Wakaf";
            $page2 = "Detail Aset Wakaf";
        }

        $kategori_aset = DB::table('kategori_aset')->where('id_pengguna', Auth::user()->id_pengguna)->get();
        $kategori_detail = DB::table('aset')->where('aset_id', $id)->where('id_pengguna', Auth::user()->id_pengguna)->first();
        $file_aset = DB::table('file_aset')->where('aset_id', $id)->orderby('created_at', 'desc')->get();
        $aset = DB::table('aset')->where('aset_id', $id)->where('id_pengguna', Auth::user()->id_pengguna)->first();

        if (DB::table('aset')->where('id_pengguna', Auth::user()->id_pengguna)->where('aset_id', $id)->first()) {
            $info = 'Diteruskan';
        } else {
            $info = 'Diterima';
        }

        return view('aset.detail_aset', compact('info', 'page2', 'file_aset', 'aset', 'kategori_aset', 'kategori_detail', 'link', 'title', 'page'));
    }

    public function aksi_tambah_aset(Request $request, $link)
    {
        $nominal = str_replace('.', '',  $request->nominal);
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        $request->validate([
            // aset umum
            'kategori' => 'required',
            'nama' => 'required',
            'asal' => 'required',
            'lokasi' => 'required',
            'tahun_perolehan' => 'required',
            'jumlah_unit' => 'required',
            'nominal' => 'required',
            'kondisi' => 'required',

        ], [
            'kategori.required' => 'Kategori Aset harus diisi',
            'nama.required' => 'Nama Aset harus diisi',
            'asal.required' => 'Asal Aset harus diisi',
            'lokasi.required' => 'Lokasi Aset harus diisi',
            'tahun_perolehan.required' => 'Tahun Perolehan harus diisi',
            'jumlah_unit.required' => 'Jumlah Unit Aset harus diisi',
            'nominal.required' => 'Nominal Aset harus diisi',
            'kondisi.required' => 'Kondisi Aset harus diisi',

        ]);

        if ($link == 'umum') {
            $aset = 'Umum';
        } elseif ($link == 'wakaf') {
            $aset = 'Wakaf';
        }

        $aset_id = uniqid();

        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $id_daerah = Auth::user()->PcPengurus->id_pc;
        } elseif (Auth::user()->gocap_id_upzis_pengurus != null) {
            $id_daerah = Auth::user()->UpzisPengurus->id_upzis;
        }

        Aset::create([
            'aset_id' => $aset_id,
            'id_pengguna' => Auth::user()->id_pengguna,
            'id_daerah' => $id_daerah,
            'kategori' => $request->kategori,
            'nama' => $request->nama,
            'jenis_aset' => $aset,
            'asal' => $request->asal,
            'lokasi' => $request->lokasi,
            'tahun_perolehan' => $request->tahun_perolehan,
            'jumlah_unit' => $request->jumlah_unit,
            'nominal' => $nominal,
            'kondisi' => $request->kondisi,
            'keterangan' => $request->keterangan,
        ]);


        $file = $request->file('file_aset');
        $ext_logo = $file->extension();
        $filename_aset = $file->storeAs('/file_aset', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext_logo, ['disk' => 'file_aset']);
        FileAset::create([
            'file_aset_id' => uniqid(),
            'aset_id' => $aset_id,
            'nama_file' => $request->nama_file,
            'file_aset' => $filename_aset,
        ]);


        if ($request->file('file_aset_baru') != null && $request->nama_file_baru != null) {
            if (is_countable($request->nama_file_baru) && count($request->nama_file_baru) > 0) {
                $a = 0;
                foreach ($request->file('file_aset_baru') as $index) {

                    $file = $index;
                    $ext_logo = $file->extension();
                    $filename_aset = $file->storeAs('/file_aset', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext_logo, ['disk' => 'file_aset']);
                    $validatedData['file_aset_id'] = uniqid();
                    $validatedData['aset_id'] = $aset_id;
                    $validatedData['nama_file'] = $request->nama_file_baru[$a];
                    $validatedData['file_aset'] = $filename_aset;
                    FileAset::create($validatedData);

                    $a++;
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
        alert()->success('Data Aset ' . $cek . ' Berhasil Ditambahkan');

        return redirect('/' . $request->role . '/detail_aset' . '/' . $link . '/' . $aset_id)->with('success', 'Data berhasil ditambahkan');
    }

    public function aksi_tambah_kategori_aset(Request $request)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        if (Auth::user()->gocap_id_pc_pengurus != null) {
            KategoriAset::create([
                'kategori_aset_id' => uniqid(),
                'id_pengguna' => Auth::user()->id_pengguna,
                'id_daerah' => Auth::user()->PcPengurus->id_pc,
                'nama_kategori' => $request->nama_kategori,
            ]);
        }

        if (Auth::user()->gocap_id_upzis_pengurus != null) {
            KategoriAset::create([
                'kategori_aset_id' => uniqid(),
                'id_pengguna' => Auth::user()->id_pengguna,
                'id_daerah' => Auth::user()->UpzisPengurus->id_upzis,
                'nama_kategori' => $request->nama_kategori,
            ]);
        }


        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('Kategori Aset ' . $cek . ' Berhasil Ditambahkan');


        return back()->with('success', 'Data berhasil ditambahkan');
    }

    public function aksi_hapus_aset(Request $request, $id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        Aset::where('aset_id', $id)->delete();
        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('Data Aset ' . $cek . ' Berhasil Dihapus');

        return back()->with('success', 'Data berhasil dihapus');
    }


    public function  aksi_hapus_kategori_aset(Request $request, $id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        KategoriAset::where('kategori_aset_id', $id)->delete();
        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('Kategori Aset ' . $cek . ' Berhasil Dihapus');

        return back();
    }


    public function aksi_edit_aset(Request $request,  $id)
    {

        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $request->validate([
            'nama' => 'required',
            'asal' => 'required',
            'lokasi' => 'required',
            'tahun_perolehan' => 'required',
            'jumlah_unit' => 'required',
            'nominal' => 'required',
            'kondisi' => 'required',

        ]);

        Aset::where('aset_id', $id)
            ->update([
                'kategori' => $request->kategori,
                'nama' => $request->nama,
                'asal' => $request->asal,
                'lokasi' => $request->lokasi,
                'tahun_perolehan' => $request->tahun_perolehan,
                'jumlah_unit' => $request->jumlah_unit,
                'nominal' => str_replace('.', '', $request->nominal),
                'kondisi' => $request->kondisi,
                'keterangan' => $request->keterangan,

            ]);


        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('Data Aset ' . $cek . ' Berhasil Diubah');

        return Redirect()->back();
    }


    public function aksi_edit_kategori_aset(Request $request, $id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        DB::table('kategori_aset')->where('kategori_aset_id', $id)->update([
            'nama_kategori' => $request->nama_kategori,
        ]);

        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('Kategori Aset ' . $cek . ' Berhasil Diubah');


        return Redirect()->back()->with('success', 'Data berhasil diubah');
    }

    public function aksi_tambah_file_aset(Request $request, $id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $file = $request->file('file_aset');
        $ext_logo = $file->extension();
        $filename_aset = $file->storeAs('/file_aset', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext_logo, ['disk' => 'file_aset']);
        FileAset::create([
            'file_aset_id' => uniqid(),
            'aset_id' => $id,
            'nama_file' => $request->nama_file,
            'file_aset' => $filename_aset,
        ]);


        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('File Aset ' . $cek . ' Berhasil Ditambahkan');


        return back()->withInput(['tab' => 'file']);
    }

    public function aksi_hapus_file_aset(Request $request, $id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        FileAset::where('file_aset_id', $id)->delete();
        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('File Aset ' . $cek . ' Berhasil Dihapus');

        return back();
    }


    public function aksi_edit_file_aset(Request $request, $id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        if ($request->file_aset) {
            $file = $request->file('file_aset');
            $ext = $file->extension();
            $filename = $file->storeAs('/file_aset', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext, ['disk' => 'file_aset']);

            $path = public_path() . "/file_aset/" . $request->file_lama;
            if (file_exists($path)) {
                unlink($path);
            }

            FileAset::where('file_aset_id', $id)->update([
                'nama_file' => $request->nama_file,
                'file_aset' => $filename,
            ]);
        } else {
            FileAset::where('file_aset_id', $id)->update([
                'nama_file' => $request->nama_file,
            ]);
        }


        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('File Aset ' . $cek . ' Berhasil Diubah');


        return back()->with('success', 'Data berhasil diubah');
    }
}
