<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TambahAset extends Component
{
    use WithFileUploads;
    public $kategoris;
    public $nama;
    public $asal;
    public $lokasi;
    public $tahun_perolehan;
    public $jumlah_unit;
    public $nominal;
    public $kondisi;
    public $keterangan;
    public $nama_file;
    public $file_aset;
    public $page;

    public function render()
    {

        if (Auth::user()->gocap_id_pc_pengurus != NULL) {
            $id_daerah = Auth::user()->PcPengurus->id_pc;
        }
        if (Auth::user()->gocap_id_upzis_pengurus != NULL) {
            $id_daerah = Auth::user()->UpzisPengurus->id_upzis;
        }

        $kategori_aset_lv = DB::table('kategori_aset')
            ->where('id_daerah', $id_daerah)
            ->orderby('created_at', 'desc')
            ->get();
        return view('livewire.tambah-aset', compact('kategori_aset_lv'));
    }
}
