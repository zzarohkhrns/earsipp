<?php

namespace App\Http\Controllers;

use App\Models\Pc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Barang;
use App\Models\KontrolBarang;
use App\Models\Upzis;
use App\Models\Ranting;
use App\Models\Pengguna;
use App\Models\PengurusJabatan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BarangController extends Controller
{
    public function data()
    {
        //$barang = DB::table('barang')->get();
        $barang = Barang::with(['latestKontrolBarang', 'latestKeluarMasukBarang'])->get();
        $role = 'pc';
        return view('barang.data_barang', compact('role', 'barang'));
    }

    public function detail($id )
    {
        $role = 'pc';
        $barang =Barang::with(['kontrolBarang', 'keluarMasukBarang'])->findOrFail($id);

        return view('barang.detail_barang', compact('role', 'barang'));
    }

    public function printKontrol()
    {
        $role = 'pc';
        return view('barang.cetak_kontrol', compact('role'));
    }
    public function printKeluar()
    {
        $role = 'pc';
        return view('barang.cetak_keluar', compact('role'));
    }

    public function store_data(Request $request)
    {
        $request->validate([
            'nama'=>'required|string|max:255',
            'satuan'=>'required|string|max:255',
            'lokasi_penyimpanan'=>'required|string|max:255',
            'spesifikasi'=>'required|string|max:255',
        ]);
        try
        {
            Barang::create([
                'id_barang' => Str::uuid(),
                'nama' => $request->nama,
                'satuan' => $request->satuan,
                'lokasi_penyimpanan' => $request->lokasi_penyimpanan,
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
            KontrolBarang::create([
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
}
