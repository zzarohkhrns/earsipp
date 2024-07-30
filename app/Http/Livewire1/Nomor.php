<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Nomor extends Component
{
    public $sifat = "";



    public function render()
    {
        $si = $this->sifat;
        $year = date('Y');
        $no_urut = DB::table('memo')->whereYear('created_at', $year)->select('no_urut')->max('no_urut');
        $new_no =  DB::table('memo')->whereYear('created_at', $year)->select('no_urut')->exists();
        if ($no_urut == null) {
            $nomor_urut = 1;
        } else {
            if ($no_urut == $new_no)
                $nomor_urut = $no_urut + 1;
        }


        return view('livewire.nomor', compact('si', 'nomor_urut'));
    }



    public function hydrate()
    {
        $this->emit('loadContactDeviceSelect2');
    }
}
