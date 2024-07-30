<?php

namespace App\Http\Livewire;

use Livewire\Component;

class PermohonanIndex extends Component
{
    public $search_tanggal_awal = '';

    public function render()
    {
        return view('livewire.permohonan-index');
    }
}
