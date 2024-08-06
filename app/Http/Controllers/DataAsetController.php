<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Pc;
use Illuminate\Support\Facades\Log;
use App\Models\Barang;
use App\Models\DetailPemeriksaanAset;
use App\Models\Kategori;
use App\Models\KontrolBarang;
use App\Models\PemeriksaanAset;
use App\Models\Upzis;
use App\Models\Ranting;
use App\Models\Pengguna;
use App\Models\PengurusJabatan;
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

        
        $kategori = DB::table('kategori')->get();
        $aset = Aset::with(['kategori_aset', 'latestDetailPemeriksaanAset.pemeriksaanAset', 'detailPemeriksaanAset.pemeriksaanAset'])->get();
        $role = 'pc';
        return view('data_aset.data_aset', compact('role', 'aset', 'kategori', 'pemeriksaan'));
    }    

    public function detail($id)
    {
        $role = 'pc';
        //$barang =Barang::with(['kontrolBarang', 'keluarMasukBarang'])->findOrFail($id);
        $aset = Aset::with(['kategori_aset', 'detailPemeriksaanAset.pemeriksaanAset'])->findOrFail($id);

        return view('data_aset.detail_aset', compact('role', 'aset'));
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

        try
        {
            Aset::create([
                'aset_id' => (string) Str::uuid(),
                'kode_aset' =>$request->kode_aset,
                'tgl_perolehan' =>$request->tgl_perolehan,
                'nama_aset' =>$request->nama_aset,
                'id_kategori' =>$kategori_id,
                'satuan' =>$request->satuan,
                'lokasi_penyimpanan' =>$request->lokasi_penyimpanan,
                'spesifikasi' => $request->spesifikasi,
            ]);
            return redirect()->back()->with('success', 'Data berhasil ditambahkan.');
        }
        catch (\Exception $e)
        {
            Log::error('Error saat menyimpan data barang: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Data gagal ditambahkan.');
        }
    }

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
        }
        catch (\Exception $e)
        {
            Log::error('Error saat menyimpan data kontrol: '. $e->getMessage());
            return redirect()->back()->with('error', 'Data gagal ditambahkan.');
        }
    }

    public function detail_pemeriksaan( )
    {
        $role = 'pc';

        return view('data_aset.detail_pemeriksaan', compact('role'));
    }
}
