<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemeriksaanAset extends Model
{
    protected $table = 'pemeriksaan_aset';
    protected $primaryKey = 'id_pemeriksaan_aset';
    public $incrementing = false;
    protected $keyType = 'string';

    // public function aset()
    // {
    //     return $this->belongsTo(Aset::class, 'aset_id', 'aset_id');
    // }

    public function detailPemeriksaanAset()
    {
        return $this->hasOne(DetailPemeriksaanAset::class, 'id_pemeriksaan_aset', 'id_pemeriksaan_aset');
    }
}