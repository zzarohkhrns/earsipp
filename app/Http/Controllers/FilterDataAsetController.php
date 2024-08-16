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

class FilterDataAsetController extends Controller
{
    public function filter_data_aset(Request $request)
    {
        $role = 'pc';
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
            $aset = $asetQuery->get();
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
            $aset = $asetQuery->get();
        }

        // Ambil kategori
        $kategori = DB::table('kategori')->get();

        return view('data_aset.data_aset', compact('kategori','aset', 'kategori_id', 'status', 'tgl_pembelian_end', 'tgl_pembelian_start', 'role'));
    }
}
