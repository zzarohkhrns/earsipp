<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class NomorSurat extends Component
{

    public $klasifikasi_surat = "";
    public $jenis_surat = "";

    public function render()
    {
        $jenis_surat_table = DB::table('kode_jenis_surat')->get();
        $sifa = $this->klasifikasi_surat;
        $year = date('Y');
        $jenis_surat_isi = $this->jenis_surat;
        
        $no_urut = DB::table('arsip_digital')->whereYear('created_at', $year)->select('no_urut')->max('no_urut');
        $new_no =  DB::table('arsip_digital')->whereYear('created_at', $year)->select('no_urut')->exists();
       
      
        if ($no_urut == null) {
            $nomor_urut = 1;
        } else {
            if ($no_urut == $new_no)
                $nomor_urut = $no_urut + 1;
        }

        return view('livewire.nomor-surat', compact('sifa', 'jenis_surat_table', 'jenis_surat_isi', 'nomor_urut'));
    }
}
