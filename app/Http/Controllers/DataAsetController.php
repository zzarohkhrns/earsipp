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
use App\Models\KeluarMasukAset;
use App\Models\DetailKeluarMasukAset;
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
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

use App\Services\GoogleDriveService;
use Illuminate\Support\Facades\Storage;

class DataAsetController extends Controller
{
    protected $googleDriveService;

    public function __construct(GoogleDriveService $googleDriveService)
    {
        $this->googleDriveService = $googleDriveService;
    }


    //controller data_aset_blade
    public function data(Request $request)
    {
        /*
            DATA ASET
        */
            //menentukan tab yang muncul

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

            $kodeAset = Aset::getNextKodeAset();

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
        /*
           End Data Aset
        */
        
        
        /*
           PEMERIKSAAN ASET
        */
 

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
        /*
           END PEMERIKSAAN ASET
        */
        

        /*
        KELUAR MASUK ASET
        */

        $query = KeluarMasukAset::orderBy('created_at', 'desc');

        $tglPencatatanStart = $request->input('tgl-pencatatan-start');
        $tglPencatatanEnd = $request->input('tgl-pencatatan-end');
        $statusSPV = $request->input('filter_keluar_masuk_status_spv');
        $statusKC = $request->input('filter_keluar_masuk_status_kc');

        if($tglPencatatanStart && $tglPencatatanEnd) {
            $query->whereBetween('tanggal_pencatatan',[ $tglPencatatanStart, $tglPencatatanEnd]);
        }

        if ($statusSPV && $statusSPV !== 'all') {
            $query->where('status_spv', $statusSPV);
        }            
        if ($statusKC && $statusKC !== 'all') {
            $query->where('status_kc', $statusKC);
        }           

        $keluar_masuk_aset = $query->get();
        /*
        *
        END KELUAR MASUK
        */



        $role = 'pc';
        return view('data_aset.data_aset', compact('keluar_masuk_aset','kategori_id', 'status', 'kodeAset', 'tgl_pembelian_start', 'tgl_pembelian_end', 'role', 'aset', 'kategori', 'pemeriksaan2', 'pemeriksaanGrouped', 'supervisor', 'kc', 'tgl_pemeriksaan_start', 'tgl_pemeriksaan_end', 'status_spv', 'status_kc'));
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


        $keluar_masuk_aset = KeluarMasukAset::with('detail_keluar_masuk_aset.aset')
                                              ->whereHas('detail_keluar_masuk_aset', function ($query) use ($id) {
                                                    $query->where('aset_id', $id);
                                            })->get();

        return view('data_aset.detail_aset', compact('role', 'aset', 'kategori', 'detailPemeriksaan', 'keluar_masuk_aset'));
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
            'asal_perolehan' => 'required',
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
            $aset = Aset::create([
                'aset_id' => (string) Str::uuid(),
                'kode_aset' => $request->kode_aset,
                'tgl_perolehan' => $request->tgl_perolehan,
                'nama_aset' => $request->nama_aset,
                'id_kategori' => $kategori_id,
                'asal_perolehan' => $request->asal_perolehan,
                'satuan' => $request->satuan,
                'lokasi_penyimpanan' => $request->lokasi_penyimpanan,
                'spesifikasi' => $request->spesifikasi,
            ]);
            return redirect()->route('pc.detail_aset', $aset->aset_id);
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

    public function export_aset()
    {
        $aset = Aset::with([
            'kategori_aset',
            'latestDetailPemeriksaanAset.pemeriksaanAset',
            'detailPemeriksaanAset.pemeriksaanAset'
        ])->get();

        // Ambil tanggal saat ini
        $tanggalSekarang = Carbon::now()->format('d-m-y');

        // Buat nama file PDF dengan tanggal saat ini
        $filename = "form_aset_{$tanggalSekarang}.pdf";

        $pdf = PDF::loadView('data_aset.export_aset', compact('aset'));
        $pdf->setPaper('A4', 'la');
        return $pdf->stream($filename);
    }
    public function export_pemeriksaan()
    {
        // Data pemeriksaan lainnya
        $pemeriksaanQuery = PemeriksaanAset::with([
            'detailPemeriksaanAset.aset.kategori_aset',
            'pcPengurus.pengguna',
            'pcPengurus.pengurusJabatan',
            'supervisor.pengurusJabatan',
            'kc.pengurusJabatan',
            'supervisor.pengguna',
            'kc.pengguna'
        ])->get();

        $pemeriksaanGrouped = $pemeriksaanQuery->sortByDesc('created_at')
            ->groupBy(function ($item) {
                return $item->pcPengurus->pengguna->nama . '-' . $item->tanggal_pemeriksaan;
            })
            ->map(function ($group) {
                return $group->unique('aset_id')->values();
            });



        // Ambil tanggal saat ini
        $tanggalSekarang = Carbon::now()->format('d-m-y');

        // Buat nama file PDF dengan tanggal saat ini
        $filename = "form_pemeriksaan_{$tanggalSekarang}.pdf";

        $pdf = PDF::loadView('data_aset.export_pemeriksaan_aset', compact('pemeriksaanGrouped', 'pemeriksaanQuery'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream($filename);
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

        //dd($supervisor, $kc, Auth::user()->gocap_id_pc_pengurus);

        return view('data_aset.detail_pemeriksaan',  compact('supervisor', 'kc', 'role', 'detailPemeriksaan', 'jumlahAset', 'pemeriksaanAset', 'kategori', 'aset'));
    }

    public function exportPdfDetailPemeriksaan($id, $tgl)
    {
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

        // Format tanggal pemeriksaan
        $tanggalPemeriksaan = Carbon::parse($tgl)->format('d-m-y');

        // Buat nama file PDF dengan tanggal pemeriksaan
        $filename = "form_detail_pemeriksaan_{$tanggalPemeriksaan}.pdf";


        $pdf = PDF::loadView('data_aset.export_detail_pemeriksaan', compact('detailPemeriksaan', 'pemeriksaanAset', 'jumlahAset'));
        $pdf->setPaper('A4', 'landscape');

        // Stream PDF dengan nama file yang sudah ditentukan
        return $pdf->stream($filename);
    }

    public function exportDetailPemeriksaanByAset($id)
    {
        $detailPemeriksaan = DetailPemeriksaanAset::with([
            'aset.kategori_aset',
            'pemeriksaanAset.pcPengurus.pengguna',
            'pemeriksaanAset.supervisor.pengguna',
            'pemeriksaanAset.kc.pengguna'
        ])->where('aset_id', $id)->get();

        $pemeriksaanAset = PemeriksaanAset::find($detailPemeriksaan->first()->id_pemeriksaan_aset);

        $filename = "riwayat_pemeriksaan_ekspor_{$pemeriksaanAset->pcPengurus->pengguna->nama}.pdf";

        $pdf = PDF::loadView('data_aset.export_riwayat_pemeriksaan_aset', compact('detailPemeriksaan', 'pemeriksaanAset'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream($filename);
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
            $pemeriksaan = PemeriksaanAset::create([
                'id_pemeriksaan_aset' => (string) Str::uuid(),
                'tanggal_pemeriksaan' => $request->tanggal_pemeriksaan,
                'id_pemeriksa' => $request->id_pemeriksa,
                'id_supervisor' => $request->id_supervisor,
                'id_kc' => $request->id_kc,
            ]);

            session()->flash('active_tab', 'pemeriksaan');
            //return redirect()->back()->with('success', 'Data berhasil ditambahkan');
            // return redirect()->route($role . '.data_aset', ['tab' => 'pemeriksaan'])
            //     ->with('success', 'Pemeriksaan berhasil ditambahkan');
            return redirect()->route('pc.detail_pemeriksaan', [
                'id' => $pemeriksaan->id_pemeriksaan_aset,
                'tgl' => $pemeriksaan->tanggal_pemeriksaan,
            ]);
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


    /*
    *
    *
    *
        KELUAR MASUK ASET
    *
    *
    *
    */
    public function detail_keluar_masuk_aset($id)
    {
        $role = 'pc';
        $keluar_masuk_aset = KeluarMasukAset::find($id);
        // dd($keluar_masuk_aset);
        $aset = Aset::all();
        $totalMasukKuantitas = $keluar_masuk_aset->detail_keluar_masuk_aset()->sum('masuk_kuantitas');
        $totalKeluarKuantitas = $keluar_masuk_aset->detail_keluar_masuk_aset()->sum('keluar_kuantitas');
        // dd($totalKeluarKuantitas, $totalMasukKuantitas);
        return view('data_aset.detail_keluar_masuk', compact('keluar_masuk_aset','role', 'aset', 'totalMasukKuantitas','totalKeluarKuantitas'));
    }

    public function keluar_masuk_aset_store(Request $request)
    {
        if(Auth::user()->gocap_id_pc_pengurus !=NULL)
        {
            $role = 'pc';
        }

        try {
            $keluar_masuk_aset = KeluarMasukAset::create(
                [
                    'id_keluar_masuk_aset' => (string) Str::uuid(),
                    'tanggal_pencatatan' => $request->tanggal_pencatatan,
                    'id_pencatat' => $request->id_pencatat,
                    'id_supervisor' => $request->id_supervisor,
                    'id_kc' => $request->id_kc,
                ],
            );
            return redirect()->route('pc.detail_keluar_masuk_aset', $keluar_masuk_aset->id_keluar_masuk_aset);
        } catch(\Exception $e) {
            return redirect()->route('pc.data_aset')->with('error', 'Gagal menghapus data keluar masuk, error : '.$e->getMessage());
        }
    }

    public function keluar_masuk_aset_update(Request $request,$id)
    {
        $keluar_masuk_aset = KeluarMasukAset::find($id);

        // Cek apakah ada file gambar yang diupload
        if($request->no_faktur) {
            if($request->hasFile('dokumentasi')) {
                // Simpan file ke direktori sementara di server
                $dokumentasiPath = $request->file('dokumentasi')->store('dokumentasi', 'public');
    
                // Ambil path file yang sudah disimpan di server
                $filePath = storage_path('app/public/' . $dokumentasiPath);
                $fileName = $request->file('dokumentasi')->getClientOriginalName();
                $folderId = '1FBbNi1m7ErHojk_XJqreT-Vi14HPptbT';
    
                try {
                    // Upload file ke Google Drive
                    $googleDriveService = new GoogleDriveService(); // Pastikan sudah ada instance dari GoogleDriveService
                    $driveFileLink = $googleDriveService->uploadFile($filePath, $fileName, $folderId);
    
                    // Jika file berhasil diupload ke Google Drive (misalnya $driveFileLink berisi link file di Google Drive)
                    if ($driveFileLink) {
                        // Hapus file dari server setelah berhasil upload
                        unlink($filePath);
                    }
                } catch (\Exception $e) {
                    // Berikan pesan error jika gagal upload
                    return redirect()->back()->with('error', 'Gagal mengunggah file ke Google Drive: ' . $e->getMessage());
                }
            }
            
            try {
                if ($request->jenis == 'masuk') {      

                    $tglColumn = 'masuk_tgl_masuk';
                    $namaColumn = 'masuk_nama_pemasok';
                    $noFakturColumn = 'masuk_no_faktur';
                    $keteranganColumn = 'masuk_keterangan';
                    $dokumentasiColumn = 'masuk_dokumentasi';
                    $transaksiColumn = 'masuk_no_transaksi';
                    
                    if ($keluar_masuk_aset->masuk_dokumentasi) {
                        Storage::disk('public')->delete($keluar_masuk_aset->masuk_dokumentasi);
                    }
                } else {

                    $tglColumn = 'keluar_tgl_keluar';
                    $namaColumn = 'keluar_nama_penerima';
                    $noFakturColumn = 'keluar_no_faktur';
                    $keteranganColumn = 'keluar_keterangan';
                    $dokumentasiColumn = 'keluar_dokumentasi';
                    $transaksiColumn = 'keluar_no_transaksi';
    
                    if ($keluar_masuk_aset->keluar_dokumentasi) {
                        Storage::disk('public')->delete($keluar_masuk_aset->keluar_dokumentasi);
                    }
                }

                $transaksi_terakhir = KeluarMasukAset::whereNotNull($transaksiColumn)->orderBy($transaksiColumn, 'desc')->first();
                $no_transaksi_terakhir = $transaksi_terakhir ? $transaksi_terakhir->masuk_no_transaksi : null;
                if($no_transaksi_terakhir)
                {
                    $transaksi_baru = str_pad((int)$no_transaksi_terakhir + 1, 3, '0', STR_PAD_LEFT);
                }
                else
                {
                    $transaksi_baru = '001';
                }
                $data = [
                        $tglColumn => $request->tgl,
                        $namaColumn => $request->nama,
                        $noFakturColumn =>  $request->no_faktur,
                        $keteranganColumn => $request->keterangan,
                        $dokumentasiColumn => $driveFileLink,
                        $transaksiColumn => $transaksi_baru
                    ];
                // dd($data, $keluar_masuk_aset);
                $keluar_masuk_aset->update($data);
    
                // Redirect atau berikan response sukses
                return redirect()->back()->with('success', 'Data faktur '. $request->jenis .' berhasil ditambahkan.');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Data faktur '. $request->jenis .' gagal ditambahkan, err : '.$e->getMessage());
            }
        }
        if($request->status_pencatatan) {
            try {
                $keluar_masuk_aset->update(['status_pencatatan' => $request->status_pencatatan]);
                
                return redirect()->back()->with('success', 'Status pemeriksaan berhasil diubah');
            } catch (\Exception $e) {
                
                return redirect()->back()->with('success', 'Status pemeriksaan gagal diubah, err : '.$e->getMessage());
            }
        }
        if($request->status_spv || $request->status_kc)
        {
            $jabatan = $request->status_spv ? 'spv' : 'kc';
            try {
                $keluar_masuk_aset->update([
                    'status_'.$jabatan => $request->input('status_'.$jabatan),
                    'tgl_mengetahui_'.$jabatan => $request->input('tgl_mengetahui_'.$jabatan),
                    'catatan_'.$jabatan => $request->input('catatan_'.$jabatan),
                ]);
                session()->flash('active_tab', 'status-spv-kc');
                return redirect()->route('pc.detail_keluar_masuk_aset', $id)->with('success', 'Status '.$jabatan.' berhasil diubah');
            }catch (\Exception $e) {
                return redirect()->back()->with('success', 'Status '.$jabatan.' gagal diubah');
            }

        }
    }

    public function keluar_masuk_aset_delete($id) {
        $keluar_masuk_aset = KeluarMasukAset::find($id);
        try {
            $keluar_masuk_aset->delete();

            return redirect()->route('pc.data_aset', ['tab' => 'keluarMasuk'])->with('success', 'Berhasil menghapus data.');
        }catch(\Exception $e)
        {
            return redirect()->back()->with('error', 'Gagal menghapus data, err '. $e->getMessage());

        }
    }

    public function detail_keluar_masuk_aset_store(Request $request, $id) {

        if($request->hasFile('dokumentasi')) {
            // Simpan file ke direktori sementara di server
            $dokumentasiPath = $request->file('dokumentasi')->store('dokumentasi', 'public');

            // Ambil path file yang sudah disimpan di server
            $filePath = storage_path('app/public/' . $dokumentasiPath);
            $fileName = $request->file('dokumentasi')->getClientOriginalName();
            $folderId = '1FBbNi1m7ErHojk_XJqreT-Vi14HPptbT';

            try {
                // Upload file ke Google Drive
                $googleDriveService = new GoogleDriveService(); // Pastikan sudah ada instance dari GoogleDriveService
                $driveFileLink = $googleDriveService->uploadFile($filePath, $fileName, $folderId);

                // Jika file berhasil diupload ke Google Drive (misalnya $driveFileLink berisi link file di Google Drive)
                if ($driveFileLink) {
                    // Hapus file dari server setelah berhasil upload
                    unlink($filePath);
                }
            } catch (\Exception $e) {
                // Berikan pesan error jika gagal upload
                return redirect()->back()->with('error', 'Gagal mengunggah file ke Google Drive: ' . $e->getMessage());
            }
        }
        // dd($driveFileLink, $request->hasFile('dokumentasi'));
        try {

            if($request->jenis === 'masuk') {
                $kuantitasColumn = 'masuk_kuantitas';
                $dokumentasiColumn = 'masuk_dokumentasi';
                $kondisiColumn = 'masuk_kondisi';
                $tindak_lanjutColumn = 'masuk_tindak_lanjut';

            } else {
                $dokumentasiColumn = 'keluar_dokumentasi';
                $kuantitasColumn = 'keluar_kuantitas';
                $kondisiColumn = 'keluar_kondisi';
                $tindak_lanjutColumn = 'keluar_tindak_lanjut';
            }

            $detail_keluar_masuk_aset = DetailKeluarMasukAset::where('aset_id', $request->aset)->first();

            // dd($detail_keluar_masuk_aset);
            if($detail_keluar_masuk_aset) {
                $detail_keluar_masuk_aset->update([
                    'aset_id' => $request->aset,
                    'id_keluar_masuk_aset' => $id,
                    $kuantitasColumn => $request->kuantitas,
                    $kondisiColumn => $request->kondisi,
                    $tindak_lanjutColumn => $request->tindak_lanjut,
                    $dokumentasiColumn => $driveFileLink,
                ]);
            } else {
                DetailKeluarMasukAset::create(
                    [
                    'id_detail_keluar_masuk_aset'=> (string) Str::uuid(),
                    'aset_id' => $request->aset,
                    'id_keluar_masuk_aset' => $id,
                    $kuantitasColumn => $request->kuantitas,
                    $kondisiColumn => $request->kondisi,
                    $tindak_lanjutColumn => $request->tindak_lanjut,
                    $dokumentasiColumn => $driveFileLink,
                    ]
                );
            }

            return redirect()->back()->with('success', 'Berhasil menambahkan detail keluar masuk!');

        }catch(\Exception $e) {
            return redirect()->back()->with('error','Gagal menambahkan detail keluar masuk, error : '.$e->getMessage());
        }
    }

    public function detail_keluar_masuk_aset_update(Request $request)
    {
        try {
            // Temukan detail_keluar_masuk_aset berdasarkan ID yang dikirimkan
            $detail = DetailKeluarMasukAset::findOrFail($request->edit_id_detail_keluar_masuk_aset);

            // Tentukan kolom berdasarkan jenis
            if ($request->edit_jenis === 'masuk') {
                $kuantitasColumn = 'masuk_kuantitas';
                $dokumentasiColumn = 'masuk_dokumentasi';
                $kondisiColumn = 'masuk_kondisi';
                $tindak_lanjutColumn = 'masuk_tindak_lanjut';
            } else {
                $kuantitasColumn = 'keluar_kuantitas';
                $dokumentasiColumn = 'keluar_dokumentasi';
                $kondisiColumn = 'keluar_kondisi';
                $tindak_lanjutColumn = 'keluar_tindak_lanjut';
            }

            // Jika ada file dokumentasi yang diupload, proses penghapusan dan upload baru
            if ($request->hasFile('edit_dokumentasi')) {
                // Hapus gambar lama di Google Drive
                $googleDriveService = new GoogleDriveService();

                // Ambil link file yang lama (berada di database)
                $oldDriveLink = $detail->$dokumentasiColumn;

                // Ambil ID file Google Drive dari URL (anggap file Drive URL berbentuk https://drive.google.com/uc?id=FILE_ID)
                $oldFileId = $this->getGoogleDriveFileId($oldDriveLink);
                $folderId = '1FBbNi1m7ErHojk_XJqreT-Vi14HPptbT';

                // Hapus file lama di Google Drive
                if ($oldFileId) {
                    $googleDriveService->deleteFile($oldFileId);
                }

                // Simpan file baru ke server sementara
                $dokumentasiPath = $request->file('edit_dokumentasi')->store('dokumentasi', 'public');
                $filePath = storage_path('app/public/' . $dokumentasiPath);
                $fileName = $request->file('edit_dokumentasi')->getClientOriginalName();

                // Upload file baru ke Google Drive
                $newDriveLink = $googleDriveService->uploadFile($filePath, $fileName, $folderId);

                // Hapus file sementara dari server setelah berhasil upload
                if (file_exists($filePath)) {
                    unlink($filePath);
                }

                // Update kolom dokumentasi dengan link file baru dari Google Drive
                $detail->$dokumentasiColumn = $newDriveLink;
            }

            // Update data lainnya
            $detail->update([
                'aset_id' => $request->edit_aset,
                $kuantitasColumn => $request->edit_kuantitas,
                $kondisiColumn => $request->edit_kondisi,
                $tindak_lanjutColumn => $request->edit_tindak_lanjut,
            ]);

            return redirect()->back()->with('success', 'Data berhasil diperbarui!');
            
        } catch (\Exception $e) {
            // Menangani kesalahan
            return redirect()->back()->with('error', 'Gagal memperbarui data, error: ' . $e->getMessage());
        }
    }

    public function detail_keluar_masuk_aset_delete($id,$jenis)
    {
        $detail = DetailKeluarMasukAset::find($id);
        // dd($detail, $jenis);

        // Tentukan kolom berdasarkan jenis
        if ($jenis == 'masuk') {
            $kuantitasColumn = 'masuk_kuantitas';
            $dokumentasiColumn = 'masuk_dokumentasi';
            $kondisiColumn = 'masuk_kondisi';
            $tindak_lanjutColumn = 'masuk_tindak_lanjut';
        } else {
            $kuantitasColumn = 'keluar_kuantitas';
            $dokumentasiColumn = 'keluar_dokumentasi';
            $kondisiColumn = 'keluar_kondisi';
            $tindak_lanjutColumn = 'keluar_tindak_lanjut';
        }

        try {
            //menghapus gambar di gdrive
            if($detail->$dokumentasiColumn)
            {
                // Hapus gambar lama di Google Drive
                $googleDriveService = new GoogleDriveService();

                // Ambil link file yang lama (berada di database)
                $oldDriveLink = $detail->$dokumentasiColumn;

                // Ambil ID file Google Drive dari URL (anggap file Drive URL berbentuk https://drive.google.com/uc?id=FILE_ID)
                $oldFileId = $this->getGoogleDriveFileId($oldDriveLink);

                // Hapus file lama di Google Drive
                if ($oldFileId) {
                    $googleDriveService->deleteFile($oldFileId);
                }
            }

            $detail->update([
                $kuantitasColumn => null,
                $dokumentasiColumn => null,
                $kondisiColumn => null,
                $tindak_lanjutColumn => null,
            ]);
            if($detail->masuk_kuantitas == null && $detail->keluar_kuantitas == null)
            {
                $detail->delete();
            }

            return redirect()->back()->with('success', 'Berhasil menghapus Aset '. $jenis);
        }catch(\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus Aset '. $jenis .'<br>error :' . $e->getMessage());
        }
        
    }

    /**
     * Fungsi untuk mengambil ID file Google Drive dari URL
     *
     * @param string $driveLink
     * @return string|null
     */
    private function getGoogleDriveFileId($driveLink)
    {
        // Misalnya URL Google Drive format: https://drive.google.com/uc?id=FILE_ID
        if (preg_match('/(?:drive|docs).google.com.*?id=([^&?\/]+)/', $driveLink, $matches)) {
            return $matches[1];
        }
        return null;
    }


    public function export_detail_keluar_masuk_aset($id){
        // return view('data_aset.export_detail_keluar_masuk');
        $keluar_masuk_aset = KeluarMasukAset::findOrFail($id);
        $filename = "form_detail_keluar_masuk_aset.pdf";
        // dd($keluar_masuk_aset);

        $pdf = PDF::loadView('data_aset.export_detail_keluar_masuk', compact('keluar_masuk_aset'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream($filename);
    }

    public function export_keluar_masuk_aset(){
        $filename = "form_keluar_masuk_aset.pdf";
        $keluar_masuk_aset = KeluarMasukAset::all();

        $pdf = PDF::loadView('data_aset.export_keluar_masuk', compact('keluar_masuk_aset'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream($filename);
    }
}
