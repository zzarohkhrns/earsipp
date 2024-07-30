<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    public function data(){
        //$barang = DB::table('barang')->get();
        $role = 'pc';
        return view('barang.data_barang', compact('role'));
    }

}
