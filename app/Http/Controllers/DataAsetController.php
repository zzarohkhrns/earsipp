<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Pc;
use Illuminate\Support\Facades\Log;
use App\Models\Barang;
use App\Models\DetailPemeriksaanAset;
use App\Models\Kategori;
use App\Models\KontrolBarang;
use App\Models\PcPengurus;
use App\Models\PemeriksaanAset;
use App\Models\Upzis;
use App\Models\Ranting;
use App\Models\Pengguna;
use App\Models\PengurusJabatan;
use Egulias\EmailValidator\Result\Reason\DetailedReason;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DataAsetController extends Controller
{
    public function data()
    {
        //hanya mengambil aset yang memiliki detail pemeriksaan
        $pemeriksaan = Aset::with([
            'kategori_aset',
            'detailPemeriksaanAset.pemeriksaanAset'
        ])->whereHas('detailPemeriksaanAset', function ($query) {
            // Filter agar hanya mengambil aset yang memiliki detail pemeriksaan
            $query->whereNotNull('id_detail_pemeriksaan_aset');
        })->get();


        //menarik data pemeriksaan dari table detail pemeriksaan
        $pemeriksaan2 = DetailPemeriksaanAset::with([
            'aset.kategori_aset',
            'pemeriksaanAset.pcPengurus.pengguna',
            'pemeriksaanAset.supervisor.pengguna',
            'pemeriksaanAset.kc.pengguna'
        ])->get();

        //mengelompokkan berdasarkan nama pemeriksa dan memilih pemeriksaan terakhir untuk aset yang sama
        $pemeriksaanGrouped = $pemeriksaan2->groupBy(function ($item) {
            return $item->pemeriksaanAset->pcPengurus->pengguna->nama;
        })->map(function ($group) {
            return $group->sortByDesc('created_at')->unique('aset_id')->values();
        });

        $kategori = DB::table('kategori')->get();
        //$kondisi = DB::table('kondisi')->get();
        $aset = Aset::with(['kategori_aset', 'latestDetailPemeriksaanAset.pemeriksaanAset', 'detailPemeriksaanAset.pemeriksaanAset'])->get();
        $role = 'pc';


        // Mendapatkan divisi user yang sedang login dari database gocap
        $divisiUser = DB::connection('gocap')
            ->table('pc_pengurus')
            ->join('pengurus_jabatan', 'pc_pengurus.id_pengurus_jabatan', '=', 'pengurus_jabatan.id_pengurus_jabatan')
            ->where('pc_pengurus.id_pc_pengurus', Auth::user()->gocap_id_pc_pengurus)
            ->select('pengurus_jabatan.divisi')
            ->first();

        if ($divisiUser) {
            // Mengambil data id_pc_pengurus dan nama dari user table di database siftnu
            $supervisor = DB::connection('gocap')
                ->table('pc_pengurus')
                ->join('pengurus_jabatan', 'pc_pengurus.id_pengurus_jabatan', '=', 'pengurus_jabatan.id_pengurus_jabatan')
                ->join('siftnu.pengguna', 'siftnu.pengguna.gocap_id_pc_pengurus', '=', 'pc_pengurus.id_pc_pengurus') // Join ke table user di database siftnu
                ->where('pengurus_jabatan.jabatan', 'Supervisor Cabang')
                ->where('pengurus_jabatan.divisi', $divisiUser->divisi)
                ->select('pc_pengurus.id_pc_pengurus as id_supervisor', 'siftnu.pengguna.nama as nama_supervisor') // Memilih kolom id dan nama dari table user
                ->first();
        } else {
            $supervisor = null;
        }

        $kc = DB::connection('gocap')
              ->table('pc_pengurus')
              ->join('pengurus_jabatan', 'pc_pengurus.id_pengurus_jabatan', '=', 'pengurus_jabatan.id_pengurus_jabatan')
              ->join('siftnu.pengguna', 'siftnu.pengguna.gocap_id_pc_pengurus', '=', 'pc_pengurus.id_pc_pengurus')
              ->where('pengurus_jabatan.jabatan', 'Kepala Cabang')
              ->select('pc_pengurus.id_pc_pengurus as id_kc', 'siftnu.pengguna.nama as nama_kc')
              ->first();


        return view('data_aset.data_aset', compact('role', 'aset', 'kategori', 'pemeriksaan', 'pemeriksaanGrouped', 'supervisor', 'kc'));
    }

    public function detail($id)
    {
        $role = 'pc';
        //$barang =Barang::with(['kontrolBarang', 'keluarMasukBarang'])->findOrFail($id);
        $kategori = DB::table('kategori')->get();
        $aset = Aset::with(['kategori_aset', 'detailPemeriksaanAset.pemeriksaanAset'])->findOrFail($id);

        return view('data_aset.detail_aset', compact('role', 'aset', 'kategori'));
    }

    public function printKontrol()
    {
        $role = 'pc';
        return view('data_aset.cetak_kontrol', compact('role'));
    }
    public function printKeluar()
    {
        $role = 'pc';
        return view('data_aset.cetak_keluar', compact('role'));
    }

    public function getNextKodeAset(): JsonResponse
    {
        $kodeAset = Aset::getNextKodeAset();
        return response()->json(['kode_aset' => $kodeAset]);
    }



    //menyimpan kategori
    public function store_kategori(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        try {
            $kategori = Kategori::create([
                'id_kategori' => (string) Str::uuid(),
                'kategori' => $request->nama,
            ]);

            return response()->json(['id' => $kategori->id_kategori, 'nama' => $kategori->kategori], 201);
        } catch (\Exception $e) {
            Log::error('Error saat menyimpan kategori: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal menyimpan kategori baru.'], 500);
        }
    }

    //menyimpan data aset
    public function store_data(Request $request)
    {
        $request->validate([
            'kode_aset' => 'required|string|max:255',
            'tgl_perolehan' => 'required|date',
            'nama_aset' => 'required|string|max:255',
            'kategori' => 'required',
            'satuan' => 'required|string|max:255',
            'lokasi_penyimpanan' => 'required|string|max:255',
            'spesifikasi' => 'nullable|string|max:255',
            //ini belum selesai
        ]);

        Log::info('Memulai penyimpanan data aset. Kategori: ' . $request->id_kategori);

        $kategori = DB::table('kategori')
            ->where('id_kategori', $request->kategori)
            ->first();

        if (!$kategori) {
            return redirect()->back()->with('error', 'Gagal menambahkan kategori.');
        } else {
            $kategori_id = $kategori->id_kategori;
        }

        try {
            Aset::create([
                'aset_id' => (string) Str::uuid(),
                'kode_aset' => $request->kode_aset,
                'tgl_perolehan' => $request->tgl_perolehan,
                'nama_aset' => $request->nama_aset,
                'id_kategori' => $kategori_id,
                'satuan' => $request->satuan,
                'lokasi_penyimpanan' => $request->lokasi_penyimpanan,
                'spesifikasi' => $request->spesifikasi,
            ]);
            return redirect()->back()->with('success', 'Data berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error saat menyimpan data barang: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Data gagal ditambahkan.');
        }
    }

    public function update_data(Request $request, $id)
    {
        $request->validate([
            'aset_id' => 'required',
            'kode_aset' => 'required',
            'tgl_perolehan' => 'required|date',
            'nama_aset' => 'required|string|max:255',
            'kategori' => 'required',
            'satuan' => 'required|string|max:255',
            'asal_perolehan' => 'required|string|max:255',
            'lokasi_penyimpanan' => 'required|string|max:255',
            'spesifikasi' => 'nullable|string|max:255',
        ]);

        // Check if the kategori exists
        $kategori = DB::table('kategori')
            ->where('id_kategori', $request->kategori)
            ->first();

        if (!$kategori) {
            return redirect()->back()->with('error', 'Gagal menemukan kategori.');
        } else {
            $kategori_id = $kategori->id_kategori;
        }

        try {
            // Find the aset by aset_id
            $aset = Aset::findOrFail($request->aset_id);

            // Update the aset data
            $aset->update([
                'kode_aset' => $request->kode_aset,
                'tgl_perolehan' => $request->tgl_perolehan,
                'nama_aset' => $request->nama_aset,
                'id_kategori' => $kategori_id,
                'satuan' => $request->satuan,
                'asal_perolehan' => $request->asal_perolehan,
                'lokasi_penyimpanan' => $request->lokasi_penyimpanan,
                'spesifikasi' => $request->spesifikasi,
            ]);

            return redirect()->back()->with('success', 'Data berhasil diupdate.');
        } catch (\Exception $e) {
            Log::error('Error saat mengupdate data barang: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Data gagal diupdate.');
        }
    }

    public function delete_data($id)
    {
        // Temukan data aset berdasarkan ID
        $aset = Aset::find($id);

        if ($aset) {
            // Hapus detail pemeriksaan aset yang berelasi
            $detailPemeriksaan = DetailPemeriksaanAset::where('aset_id', $id)->get();

            foreach ($detailPemeriksaan as $detail) {
                $pemeriksaanAset_id = $detail->id_pemeriksaan_aset;
                $pemeriksaanAset = PemeriksaanAset::find($pemeriksaanAset_id);

                if ($pemeriksaanAset) {
                    $pemeriksaanAset->delete();
                }

                $detail->delete();
            }

            // // Hapus keluar masuk aset yang berelasi
            // $keluarMasukAset = KeluarMasukAset::where('aset_id', $id)->get();

            // foreach ($keluarMasukAset as $keluarMasuk) {
            //     $keluarMasuk->delete();
            // }

            // Hapus data aset
            $aset->delete();

            // Redirect dengan pesan sukses
            return redirect()->back()->back()->with('success', 'Berhasil menghapus data.');
        } else {
            // Redirect dengan pesan error jika data tidak ditemukan
            return redirect()->route('data_aset')->with('error', 'Data aset tidak ditemukan.');
        }
    }


    // public function delete_data($id)
    // {
    //     // Temukan data aset berdasarkan ID
    //     $aset = Aset::find($id);

    //     if ($aset) {

    //         $detailPemeriksaan = DetailPemeriksaanAset::where('aset_id', $id)->firstOrFail();

    //         if ($detailPemeriksaan) {
    //             $pemeriksaanAset_id = $detailPemeriksaan->id_pemeriksaan_aset;
    //             $pemeriksaanAset = PemeriksaanAset::find($pemeriksaanAset_id);
    //             // Hapus detail pemeriksaan
    //             $detailPemeriksaan->delete();

    //             //Hapus pemeriksaan
    //             $pemeriksaanAset->delete();

    //             // Hapus data aset
    //             $aset->delete();
    //         } else {
    //             // Hapus data aset
    //             $aset->delete();
    //         }


    //         // Redirect dengan pesan sukses
    //         //return redirect()->route('data_aset')->with('success', 'Data aset berhasil dihapus.');
    //         //return redirect()->back()->with('success', 'Berhasil menghapus data.');
    //         return view('data_aset.data_aset')->with('success', 'Data aset berhasil dihapus.');
    //     } else {
    //         // Redirect dengan pesan error jika data tidak ditemukan
    //         return redirect()->route('data_aset')->with('error', 'Data aset tidak ditemukan.');
    //     }
    // }


    public function store_kontrol(Request $request)
    {
        $request->validate([
            'tanggal_kontrol' => 'required',
            'berfungsi' => 'required',
            'kondisi' => 'required',
            'keterangan' => 'required'
        ]);

        dd($request);

        try {
            PemeriksaanAset::create([
                'id_kontrol_barang' => Str::uuid(),
                'id_barang' => $request->id_barang,
                'tanggal_kontrol' => $request->tanggal_kontrol,
                'berfungsi' => 'Ya',
                'kondisi' => 'Baik',
                'keterangan' => $request->keterangan,
            ]);
            return redirect()->back()->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {
            Log::error('Error saat menyimpan data kontrol: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Data gagal ditambahkan.');
        }
    }

    public function detail_pemeriksaan($id, $tgl)
    {
        $role = 'pc';

        $detailPemeriksaan = DetailPemeriksaanAset::with([
            'aset.kategori_aset',
            'pemeriksaanAset.pcPengurus.pengguna',
            'pemeriksaanAset.pcPengurus.pengurusJabatan',
            'pemeriksaanAset.supervisor.pengguna',
            'pemeriksaanAset.supervisor.pengurusJabatan',
            'pemeriksaanAset.kc.pengguna',
            'pemeriksaanAset.kc.pengurusJabatan',
            'pemeriksaanAset.kc.pengguna'
        ])->whereHas('pemeriksaanAset', function ($query) use ($id, $tgl) {
            $query->where('id_pemeriksaan_aset', $id)
                ->where('tanggal_pemeriksaan', $tgl);
        })->firstOrFail();


        //menghitung jumlah aset yang diperiksa

        // Ambil semua detail pemeriksaan aset terkait dengan ID pemeriksaan
        $pemeriksaan = DetailPemeriksaanAset::with([
            'aset.kategori_aset',
            'pemeriksaanAset.pcPengurus.pengguna',
            'pemeriksaanAset.pcPengurus.pengurusJabatan',
            'pemeriksaanAset.supervisor.pengguna',
            'pemeriksaanAset.supervisor.pengurusJabatan',
            'pemeriksaanAset.kc.pengguna',
            'pemeriksaanAset.kc.pengurusJabatan',
            'pemeriksaanAset.kc.pengguna'
        ])->whereHas('pemeriksaanAset', function ($query) use ($id, $tgl) {
            $query->where('id_pemeriksaan_aset', $id)
                ->where('tanggal_pemeriksaan', $tgl);
        })->get();

        // Ambil data pemeriksaan terbaru untuk setiap aset_id
        $latestDetailPemeriksaan = $pemeriksaan->sortByDesc('created_at')
            ->unique('aset_id')
            ->values();

        // Hitung jumlah aset yang unik
        $jumlahAset = $latestDetailPemeriksaan->count();


        //kategori
        $kategori = Kategori::all();


        return view('data_aset.detail_pemeriksaan', compact('role', 'detailPemeriksaan', 'jumlahAset', 'pemeriksaan', 'kategori'));
    }

    public function filterAset(Request $request)
    {
        // Ambil data filter dari request
        $tglStart = $request->input('tgl-pembelian-start');
        $tglEnd = $request->input('tgl-pembelian-end');
        $kategori = $request->input('kategori');
        $status = $request->input('status');

        // Query untuk mendapatkan data yang sesuai dengan filter
        $query = Aset::query();

        if ($tglStart) {
            $query->whereDate('tgl_pembelian', '>=', $tglStart);
        }

        if ($tglEnd) {
            $query->whereDate('tgl_pembelian', '<=', $tglEnd);
        }

        if ($kategori) {
            $query->where('id_kategori', $kategori);
        }

        if ($status) {
            $query->where('status', $status);
        }

        // Dapatkan hasil dari query
        $data = $query->get();

        // Kembalikan data yang difilter ke view
        return view('data_aset.data_aset', ['data' => $data]);
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama_aset' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'lokasi_aset' => 'required|string|max:255',
            'tgl_pembelian' => 'required|date',
            'status' => 'required|in:aktif,nonaktif',
            'kondisi' => 'required|string|max:255',
            'masalah' => 'nullable|string',
            'tindakan' => 'nullable|string',
        ]);

        // Simpan data ke database
        DetailPemeriksaanAset::create([]);

        // Redirect atau berikan response sukses
        return redirect()->back()->with('success', 'Data pemeriksaan berhasil ditambahkan.');
    }
}
