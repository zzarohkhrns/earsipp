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
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DataAsetController extends Controller
{

    //controller data_aset_blade
    public function data(Request $request)
    {
        // Ambil semua filter dari request dengan nilai default jika tidak ada input
        $kategori_id = $request->input('kategori', 'all');
        $status = $request->input('status', 'all');
        $tgl_pembelian_start = $request->input('tgl-pembelian-start');
        $tgl_pembelian_end = $request->input('tgl-pembelian-end');

        // Query dasar untuk mengambil aset yang memiliki detail pemeriksaan
        $asetQuery = Aset::with([
            'kategori_aset',
            'latestDetailPemeriksaanAset.pemeriksaanAset',
            'detailPemeriksaanAset.pemeriksaanAset'
        ]); 

        if ($kategori_id == 'all' && $status == 'all' && !$tgl_pembelian_start && !$tgl_pembelian_end) {
            // Eksekusi query untuk mendapatkan data aset yang sudah difilter
            $aset = $asetQuery->orderBy('created_at', 'desc')->get();
        } else {
            // Terapkan filter kategori
            if ($kategori_id !== 'all') {
                $asetQuery->whereHas('kategori_aset', function ($query) use ($kategori_id) {
                    $query->where('id_kategori', $kategori_id);
                });
            }

            // Terapkan filter status
            if ($status !== 'all') {
                $asetQuery->whereHas('latestDetailPemeriksaanAset', function ($query) use ($status) {
                    $query->where('status_aset', $status);
                });
            }

            // Terapkan filter tanggal pembelian
            if ($tgl_pembelian_start && $tgl_pembelian_end) {
                $asetQuery->whereBetween('tgl_perolehan', [$tgl_pembelian_start, $tgl_pembelian_end]);
            } elseif ($tgl_pembelian_start) {
                $asetQuery->where('tgl_perolehan', '>=', $tgl_pembelian_start);
            } elseif ($tgl_pembelian_end) {
                $asetQuery->where('tgl_perolehan', '<=', $tgl_pembelian_end);
            }
            $aset = $asetQuery->orderBy('created_at', 'desc')->get();
        }

        // Data pemeriksaan lainnya
        $pemeriksaanQuery = PemeriksaanAset::with([
            'detailPemeriksaanAset.aset.kategori_aset',
            'pcPengurus.pengguna',
            'pcPengurus.pengurusJabatan',
            'supervisor.pengurusJabatan',
            'kc.pengurusJabatan',
            'supervisor.pengguna',
            'kc.pengguna'
        ]);

        // Ambil semua filter dari request dengan nilai default jika tidak ada input
        $tgl_pemeriksaan_start = $request->input('tgl-pemeriksaan-start');
        $tgl_pemeriksaan_end = $request->input('tgl-pemeriksaan-end');
        $status_spv = $request->input('filter_status_spv', 'all');
        $status_kc = $request->input('filter_status_kc', 'all');

        if ($status_spv == 'all' && $status_kc == 'all' && !$tgl_pemeriksaan_start && !$tgl_pemeriksaan_end) {
            $pemeriksaan2 = $pemeriksaanQuery->get();
        } else {
            // Terapkan filter tanggal pemeriksaan
            if ($tgl_pemeriksaan_start && $tgl_pemeriksaan_end) {
                $pemeriksaanQuery->whereBetween('tanggal_pemeriksaan', [$tgl_pemeriksaan_start, $tgl_pemeriksaan_end]);
            } elseif ($tgl_pemeriksaan_start) {
                $pemeriksaanQuery->where('tanggal_pemeriksaan', '>=', $tgl_pemeriksaan_start);
            } elseif ($tgl_pemeriksaan_end) {
                $pemeriksaanQuery->where('tanggal_pemeriksaan', '<=', $tgl_pemeriksaan_end);
            }

            if ($status_spv != 'all') {
                $pemeriksaanQuery->where('status_spv', $status_spv);
            }
            if ($status_kc != 'all') {
                $pemeriksaanQuery->where('status_kc', $status_kc);
            }

            $pemeriksaan2 = $pemeriksaanQuery->get();
        }

        $pemeriksaanGrouped = $pemeriksaan2->sortByDesc('created_at')
        ->groupBy(function ($item) {
            return $item->pcPengurus->pengguna->nama . '-' . $item->tanggal_pemeriksaan;
        })
        ->map(function ($group) {
            return $group->unique('aset_id')->values();
        });


        // Ambil kategori
        $kategori = DB::table('kategori')->get();
        $role = 'pc';

        // Mendapatkan data user
        $divisiUser = DB::connection('gocap')
            ->table('pc_pengurus')
            ->join('pengurus_jabatan', 'pc_pengurus.id_pengurus_jabatan', '=', 'pengurus_jabatan.id_pengurus_jabatan')
            ->where('pc_pengurus.id_pc_pengurus', Auth::user()->gocap_id_pc_pengurus)
            ->select('pengurus_jabatan.divisi')
            ->first();

        $supervisor = null;
        if ($divisiUser) {
            $supervisor = DB::connection('gocap')
                ->table('pc_pengurus')
                ->join('pengurus_jabatan', 'pc_pengurus.id_pengurus_jabatan', '=', 'pengurus_jabatan.id_pengurus_jabatan')
                ->join('siftnu.pengguna', 'siftnu.pengguna.gocap_id_pc_pengurus', '=', 'pc_pengurus.id_pc_pengurus')
                ->where('pengurus_jabatan.jabatan', 'Supervisor Cabang')
                ->where('pengurus_jabatan.divisi', $divisiUser->divisi)
                ->select('pc_pengurus.id_pc_pengurus as id_supervisor', 'siftnu.pengguna.nama as nama_supervisor')
                ->first();
        }

        $kc = DB::connection('gocap')
            ->table('pc_pengurus')
            ->join('pengurus_jabatan', 'pc_pengurus.id_pengurus_jabatan', '=', 'pengurus_jabatan.id_pengurus_jabatan')
            ->join('siftnu.pengguna', 'siftnu.pengguna.gocap_id_pc_pengurus', '=', 'pc_pengurus.id_pc_pengurus')
            ->where('pengurus_jabatan.jabatan', 'Kepala Cabang')
            ->select('pc_pengurus.id_pc_pengurus as id_kc', 'siftnu.pengguna.nama as nama_kc')
            ->first();

        return view('data_aset.data_aset', compact('kategori_id', 'status', 'tgl_pembelian_start', 'tgl_pembelian_end', 'role', 'aset', 'kategori', 'pemeriksaan2', 'pemeriksaanGrouped', 'supervisor', 'kc', 'tgl_pemeriksaan_start', 'tgl_pemeriksaan_end', 'status_spv', 'status_kc'));
    }

    public function detail_aset($id)
    {
        $role = 'pc';
        //$barang =Barang::with(['kontrolBarang', 'keluarMasukBarang'])->findOrFail($id);
        $kategori = DB::table('kategori')->get();
        $aset = Aset::with(['kategori_aset', 'detailPemeriksaanAset.pemeriksaanAset'])->findOrFail($id);

        $detailPemeriksaan = DetailPemeriksaanAset::with([
            'aset.kategori_aset',
            'pemeriksaanAset.pcPengurus.pengguna',
            'pemeriksaanAset.supervisor.pengguna',
            'pemeriksaanAset.kc.pengguna'
        ])->where('aset_id', $id)->get();

        return view('data_aset.detail_aset', compact('role', 'aset', 'kategori', 'detailPemeriksaan'));
    }

    //get kode aset
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

    public function getAsetDetail($id)
    {
        $aset = Aset::with('kategori_aset')->find($id);
        return response()->json([
            'kategori_aset' => $aset->kategori_aset->kategori,
            'lokasi_penyimpanan' => $aset->lokasi_penyimpanan,
            'tgl_perolehan' => $aset->tgl_perolehan,
        ]);
    }

    public function getDataAset($id)
    {
        $aset = Aset::with('kategori_aset')->where('aset_id', $id)->get();

        // Memastikan data yang dikembalikan benar
        if ($aset) {
            return response()->json($aset);
        } else {
            return response()->json(['message' => 'Aset not found'], 404);
        }
    }


    //update data aset
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
            $aset = Aset::findOrFail($id);
            $aset->kode_aset = $request->kode_aset;
            $aset->tgl_perolehan = $request->tgl_perolehan;
            $aset->asal_perolehan = $request->asal_perolehan;
            $aset->nama_aset = $request->nama_aset;
            $aset->id_kategori = $request->kategori;
            $aset->satuan = $request->satuan;
            $aset->lokasi_penyimpanan = $request->lokasi_penyimpanan;
            $aset->spesifikasi = $request->spesifikasi;
            $aset->save();

            return redirect()->back()->with('success', 'Data berhasil diupdate.');
        } catch (\Exception $e) {
            Log::error('Error saat mengupdate data barang: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Data gagal diupdate.');
        }
    }

    //delete data aset
    public function delete_data($id)
    {
        // Temukan data aset berdasarkan ID
        $aset = Aset::find($id);

        if ($aset) {
            // Hapus detail pemeriksaan aset yang berelasi
            $detailPemeriksaan = DetailPemeriksaanAset::where('aset_id', $id)->get();

            if ($detailPemeriksaan) {
                foreach ($detailPemeriksaan as $detail) {
                    $detail->delete();
                }
            }
            $aset->delete();

            // Redirect dengan pesan sukses
            return redirect()->route('pc.data_aset')->with('success', 'Berhasil menghapus data.');
        } else {
            // Redirect dengan pesan error jika data tidak ditemukan
            return redirect()->route('pc.data_aset')->with('error', 'Data aset tidak ditemukan.');
        }
    }

    // controller pemeriksaan.blade dan detail_pemeriksaan.blade

    // tampil data detail pemeriksaan aset
    public function detail_pemeriksaan($id, $tgl)
    {
        $role = 'pc';

        // Cari Pemeriksaan Aset
        $pemeriksaanAset = PemeriksaanAset::with([
            'pcPengurus.pengguna',
            'pcPengurus.pengurusJabatan',
            'supervisor.pengguna',
            'supervisor.pengurusJabatan',
            'kc.pengguna',
            'kc.pengurusJabatan',
            'detailPemeriksaanAset.aset.kategori_aset',
        ])->where('id_pemeriksaan_aset', $id)
            ->where('tanggal_pemeriksaan', $tgl)
            ->firstOrFail();

        // Mencari Detail Pemeriksaan Aset
        $detailPemeriksaan = DetailPemeriksaanAset::with([
            'aset.kategori_aset',
            'pemeriksaanAset.pcPengurus.pengguna',
            'pemeriksaanAset.pcPengurus.pengurusJabatan',
            'pemeriksaanAset.supervisor.pengguna',
            'pemeriksaanAset.supervisor.pengurusJabatan',
            'pemeriksaanAset.kc.pengguna',
            'pemeriksaanAset.kc.pengurusJabatan',
        ])->whereHas('pemeriksaanAset', function ($query) use ($id, $tgl) {
            $query->where('id_pemeriksaan_aset', $id)
                ->where('tanggal_pemeriksaan', $tgl);
        })->get();

        // Menghitung jumlah detail pemeriksaan yang ditemukan
        if ($detailPemeriksaan->isNotEmpty()) {
            // Ambil data pemeriksaan terbaru untuk setiap aset_id
            $latestDetailPemeriksaan = $detailPemeriksaan->sortByDesc('created_at')
                ->unique('aset_id')
                ->values();

            // Hitung jumlah aset yang unik
            $jumlahAset = $latestDetailPemeriksaan->count();
        } else {
            $jumlahAset = 0; // Set ke 0 jika tidak ada detail pemeriksaan ditemukan
        }

        $aset = Aset::all();

        // Mengambil semua kategori
        $kategori = Kategori::all();

        return view('data_aset.detail_pemeriksaan', compact('role', 'detailPemeriksaan', 'jumlahAset', 'pemeriksaanAset', 'kategori', 'aset'));
    }

    // update status pemeriksaan
    public function updateStatusPemeriksaan(Request $request)
    {
        // Validasi input untuk memastikan data yang diterima valid
        $request->validate([
            'id_pemeriksaan_aset' => 'required', // Cek apakah ID ada di database
            'status_pemeriksaan' => 'required|string',
        ]);

        // Cari data pemeriksaan aset berdasarkan ID
        $pemeriksaanAset = PemeriksaanAset::find($request->id_pemeriksaan_aset);

        if ($pemeriksaanAset) {
            // Ubah status dan simpan
            $pemeriksaanAset->status_pemeriksaan = $request->status_pemeriksaan;
            $pemeriksaanAset->save();

            return back()->with('success', 'Status updated successfully');
        } else {
            // Kembalikan pesan error jika data tidak ditemukan
            return back()->with('error', 'Status updated failed');
        }
    }

    // update respon spv
    public function update_respon_spv(Request $request, $id)
    {
        $request->validate([
            //'id_pemeriksaan_aset' => 'required',
            'tanggal_pemeriksaan' => 'required',
            'status_spv' => 'required',
            'tgl_mengetahui_spv' => 'required',
            'catatan_spv' => 'required',
        ]);

        $pemeriksaanAset = PemeriksaanAset::findOrFail($id);

        if ($pemeriksaanAset) {
            $pemeriksaanAset->status_spv = $request->status_spv;
            $pemeriksaanAset->tgl_mengetahui_spv = $request->tgl_mengetahui_spv;
            $pemeriksaanAset->catatan_spv = $request->catatan_spv;
            $pemeriksaanAset->save();

            return redirect()->back()->with('success', 'Data berhasil ditambahkan');
        } else {
            return redirect()->back()->with('error', 'Data gagal ditambahkan');
        }
    }

    // update respon kc
    public function update_respon_kc(Request $request, $id)
    {
        $request->validate([
            //'id_pemeriksaan_aset' => 'required',
            //'tanggal_pemeriksaan' => 'required',
            'status_kc' => 'required',
            'tgl_mengetahui_kc' => 'required',
            'catatan_kc' => 'required',
        ]);

        $pemeriksaanAset = PemeriksaanAset::findOrFail($id);

        if ($pemeriksaanAset) {
            $pemeriksaanAset->status_kc = $request->status_kc;
            $pemeriksaanAset->tgl_mengetahui_kc = $request->tgl_mengetahui_kc;
            $pemeriksaanAset->catatan_kc = $request->catatan_kc;
            $pemeriksaanAset->save();

            return redirect()->back()->with('success', 'Data berhasil ditambahkan');
        } else {
            return redirect()->back()->with('error', 'Data gagal ditambahkan');
        }
    }

    // simpan data pemeriksaan
    public function store_pemeriksaan(Request $request)
    {
        $role = 'pc';
        $request->validate([
            'id_pemeriksa' => 'required',
            'tanggal_pemeriksaan' => ['required'],
            'id_supervisor' => 'required',
            'id_kc' => 'required',
        ]);

        try {
            PemeriksaanAset::create([
                'id_pemeriksaan_aset' => (string) Str::uuid(),
                'tanggal_pemeriksaan' => $request->tanggal_pemeriksaan,
                'id_pemeriksa' => $request->id_pemeriksa,
                'id_supervisor' => $request->id_supervisor,
                'id_kc' => $request->id_kc,
            ]);

            session()->flash('active_tab', 'pemeriksaan');
            //return redirect()->back()->with('success', 'Data berhasil ditambahkan');
            return redirect()->route($role . '.data_aset', ['tab' => 'pemeriksaan'])
            ->with('success', 'Pemeriksaan berhasil ditambahkan');
        } catch (Exception $e) {
            session()->flash('active_tab', 'pemeriksaan');
            return redirect()->back()->with('error', 'Data gagal ditambahkan.');
        }
    }

    // simpan data detail pemeriksaan
    public function store_detail_pemeriksaan(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'aset' => 'required',
            'status_aset' => 'required|in:aktif,non aktif',
            'kondisi' => 'required|string|max:255',
            'masalah_teridentifikasi' => 'required|string',
            'tindakan_diperlukan' => 'required|string',
        ]);

        // Simpan data ke database
        DetailPemeriksaanAset::create([
            'id_detail_pemeriksaan_aset' => (string) Str::uuid(),
            'id_pemeriksaan_aset' => $id,
            'aset_id' => $request->aset,
            'kondisi' => $request->kondisi,
            'status_aset' => $request->status_aset,
            'masalah_teridentifikasi' => $request->masalah_teridentifikasi,
            'tindakan_diperlukan' => $request->tindakan_diperlukan,
        ]);

        // Redirect atau berikan response sukses
        return redirect()->back()->with('success', 'Data pemeriksaan berhasil ditambahkan.');
    }

    // update detail pemeriksaan
    public function update_detail_pemeriksaan(Request $request)
    {
        $request->validate([
            'edit_id_detail_pemeriksaan' => 'required',
            'edit_aset' => 'required',
            'edit_status' => 'required|in:aktif,non aktif',
            'edit_kondisi' => 'required|string|max:255',
            'edit_masalah_teridentifikasi' => 'required|string',
            'edit_tindakan_diperlukan' => 'required|string',
        ]);

        try {

            $detail_pemeriksaan = DetailPemeriksaanAset::findOrFail($request->edit_id_detail_pemeriksaan);
            $detail_pemeriksaan->aset_id = $request->edit_aset;
            $detail_pemeriksaan->kondisi = $request->edit_kondisi;
            $detail_pemeriksaan->status_aset = $request->edit_status;
            $detail_pemeriksaan->masalah_teridentifikasi = $request->edit_masalah_teridentifikasi;
            $detail_pemeriksaan->tindakan_diperlukan = $request->edit_tindakan_diperlukan;
            $detail_pemeriksaan->save();

            return redirect()->back()->with('success', 'Data berhasil diupdate.');
        } catch (\Exception $e) {
            Log::error('Error saat mengupdate data barang: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Data gagal diupdate.');
        }
    }

    // delete detail pemeriksaan
    public function delete_detail_pemeriksaan($id)
    {
        $detailPemeriksaan = DetailPemeriksaanAset::find($id);

        if ($detailPemeriksaan) {
            $detailPemeriksaan->delete();
            return redirect()->back()->with('success', 'Data berhasil dihapus');
        } else {
            return redirect()->back()->with('error', 'Data berhasil dihapus');
        }
    }

    // delete pemeriksaan
    public function delete_pemeriksaan($id)
    {
        $Pemeriksaan = PemeriksaanAset::find($id);

        if ($Pemeriksaan) {
            $Pemeriksaan->detailPemeriksaanAset()->delete();
            $Pemeriksaan->delete();
            return redirect()->route('pc.data_aset')->with('success', 'Berhasil menghapus data.');
        } else {
            return redirect()->route('pc.data_aset')->with('error', 'Gagal menghapus data.');
        }
    }





    // //belum fix
    // public function printKontrol()
    // {
    //     $role = 'pc';
    //     return view('data_aset.cetak_kontrol', compact('role'));
    // }
    // public function printKeluar()
    // {
    //     $role = 'pc';
    //     return view('data_aset.cetak_keluar', compact('role'));
    // }
    // public function store_kontrol(Request $request)
    // {
    //     $request->validate([
    //         'tanggal_kontrol' => 'required',
    //         'berfungsi' => 'required',
    //         'kondisi' => 'required',
    //         'keterangan' => 'required'
    //     ]);

    //     dd($request);

    //     try {
    //         PemeriksaanAset::create([
    //             'id_kontrol_barang' => Str::uuid(),
    //             'id_barang' => $request->id_barang,
    //             'tanggal_kontrol' => $request->tanggal_kontrol,
    //             'berfungsi' => 'Ya',
    //             'kondisi' => 'Baik',
    //             'keterangan' => $request->keterangan,
    //         ]);
    //         return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    //     } catch (\Exception $e) {
    //         Log::error('Error saat menyimpan data kontrol: ' . $e->getMessage());
    //         return redirect()->back()->with('error', 'Data gagal ditambahkan.');
    //     }
    // }


    // public function getAsetData($id)
    // {
    //     $aset = Aset::with('kategori_aset')->where('aset_id', $id)->firstOrFail();
    //     return response()->json([$aset]);
    // }

    // public function getDetailPemeriksaan($id)
    // {
    //     $detailPemeriksaan = DetailPemeriksaanAset::with('aset.kategori_aset')
    //         ->where('id_detail_pemeriksaan_aset', $id)
    //         ->firstOrFail();

    //     return response()->json($detailPemeriksaan);
    // }


    // public function edit_detail_pemeriksaan($id)
    // {
    //     $detailPemeriksaan = DetailPemeriksaanAset::with('aset.kategori_aset')->find($id);

    //     return response()->json([
    //         'aset_id' => $detailPemeriksaan->aset_id,
    //         'kategori_aset' => $detailPemeriksaan->aset->kategori_aset->kategori,
    //         'lokasi_penyimpanan' => $detailPemeriksaan->aset->lokasi_penyimpanan,
    //         'tgl_perolehan' => $detailPemeriksaan->aset->tgl_perolehan,
    //         'status_aset' => $detailPemeriksaan->status_aset,
    //         'kondisi' => $detailPemeriksaan->kondisi,
    //         'masalah_teridentifikasi' => $detailPemeriksaan->masalah_teridentifikasi,
    //         'tindakan_diperlukan' => $detailPemeriksaan->tindakan_diperlukan,
    //     ]);
    // }

    // public function update_detail_pemeriksaan(Request $request, $id)
    // {
    //     // Validasi input
    //     $request->validate([
    //         'aset' => 'required',
    //         'status_aset' => 'required|in:aktif,non aktif',
    //         'kondisi' => 'required|string|max:255',
    //         'masalah_teridentifikasi' => 'required|string',
    //         'tindakan_diperlukan' => 'required|string',
    //     ]);

    //     // Update data di database
    //     $detailPemeriksaan = DetailPemeriksaanAset::find($id);
    //     $detailPemeriksaan->aset_id = $request->input('aset');
    //     $detailPemeriksaan->status_aset = $request->input('status_aset');
    //     $detailPemeriksaan->kondisi = $request->input('kondisi');
    //     $detailPemeriksaan->masalah_teridentifikasi = $request->input('masalah_teridentifikasi');
    //     $detailPemeriksaan->tindakan_diperlukan = $request->input('tindakan_diperlukan');
    //     $detailPemeriksaan->save();

    //     return redirect()->back()->with('success', 'Detail Pemeriksaan berhasil diupdate');
    // }



    // public function updateStatusPemeriksaan(Request $request)
    // {
    //     $pemeriksaanAset = PemeriksaanAset::findOrFail($request->id_pemeriksaan_aset);
    //     $pemeriksaanAset->status_pemeriksaan = $request->status_pemeriksaan;
    //     $pemeriksaanAset->save();

    //     return response()->json(['message' => 'Status pemeriksaan berhasil diperbarui']);
    // }



    // public function updateStatusPemeriksaan(Request $request)
    // {
    //     // Validasi input untuk memastikan data yang diterima valid
    //     $request->validate([
    //         'id_pemeriksaan_aset' => 'required|exists:pemeriksaan_asets,id',
    //         'status_pemeriksaan' => 'required|string',
    //     ]);

    //     // Cari data pemeriksaan aset berdasarkan ID
    //     $pemeriksaanAset = PemeriksaanAset::find($request->id_pemeriksaan_aset);

    //     // Jika data ditemukan, ubah status dan simpan
    //     if ($pemeriksaanAset) {
    //         $pemeriksaanAset->status_pemeriksaan = $request->status_pemeriksaan;
    //         $pemeriksaanAset->save(); // Simpan perubahan ke database
    //         return response()->json(['message' => 'Status pemeriksaan berhasil diperbarui!']);
    //     }

    //     // Jika data tidak ditemukan, kirimkan respons error
    //     return response()->json(['message' => 'Data tidak ditemukan!'], 404);
    // }

    // public function checkDate_Pemeriksaan(Request $request)
    // {
    //     $exists = PemeriksaanAset::where('id_pemeriksa', $request->id_pemeriksa)
    //         ->where('tanggal_pemeriksaan', $request->tanggal_pemeriksaan)
    //         ->exists();

    //     return response()->json(['exists' => $exists]);
    // }

}
