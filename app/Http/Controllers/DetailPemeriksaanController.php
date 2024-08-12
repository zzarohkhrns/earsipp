<?php

namespace App\Http\Controllers;

use App\Models\DetailPemeriksaanAset;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class DetailPemeriksaanController extends Controller
{
    public function getDetailPemeriksaan($id)
    {
    // $detailPemeriksaan = DetailPemeriksaanAset::with('aset.kategori_aset')
    //     ->where('id_detail_pemeriksaan_aset', $id)
    //     ->firstOrFail();

    // return response()->json($detailPemeriksaan);
    echo('berhasil masuk ke function');
    }

}
