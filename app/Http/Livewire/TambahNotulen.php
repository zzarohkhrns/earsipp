<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TambahNotulen extends Component
{
    public $tgl_rencana;
    public $tgl_realisasi;
    public $pic;
    public $pembahasan;


    public function render()
    {

        return view('livewire.tambah-notulen');
    }
}
