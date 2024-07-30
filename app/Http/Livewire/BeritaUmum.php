<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BeritaUmum extends Component
{
    public $tanggal_terbit;
    public  $kategori_berita;
    public  $judul_berita;

    public function render()
    {
        $kategori_beritas = DB::table('kategori_berita')->where('id_daerah', Auth::user()->PcPengurus->id_pc)->orderby('created_at', 'desc')->get();
        return view('livewire.berita-umum', compact('kategori_beritas'));
    }
}
