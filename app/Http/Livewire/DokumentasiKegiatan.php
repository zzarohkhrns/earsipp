<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class DokumentasiKegiatan extends Component
{
    use WithFileUploads;
    public $file_foto_kegiatan;
    public $judul_foto_kegiatan;
    public function render()
    {
        $filz = 'ewd';
        return view('livewire.dokumentasi-kegiatan', compact('filz'));
    }
}
