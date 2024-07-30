<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TambahKegiatan extends Component
{
    public $tgl_kegiatan;
    public $nama_kegiatan;
    public $jenis_kegiatan;
    public $estimasi_biaya_kegiatan;
    public $pelaksana_kegiatan;
    public $lokasi_kegiatan;
    public $penanggungjawab_kegiatan;

    public $capaian_kegiatan;
    public $ringkasan_kegiatan;
    public $kendala_kegiatan;
    public $solusi_kegiatan;

    public function render()
    {
        return view('livewire.tambah-kegiatan');
    }
}
