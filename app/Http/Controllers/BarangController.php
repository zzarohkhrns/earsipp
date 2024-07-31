<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    public function data()
    {
        //$barang = DB::table('barang')->get();
        $role = 'pc';
        return view('barang.data_barang', compact('role'));
    }

    public function detail()
    {
        $role = 'pc';
        return view('barang.detail_barang', compact('role'));
    }

    public function printKontrol()
    {

        $pdf = Barang::loadView('barang.cetak_kontrol', compact('data')); // Menggunakan view 'cetak_kontrol'
        return $pdf->download('kontrol-barang.pdf');
    }
}
