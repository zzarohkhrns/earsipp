<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPemeriksaanAset extends Model
{
    protected $table = 'detail_pemeriksaan_aset';
    protected $primaryKey = 'id_detail_pemeriksaan_aset';
    public $incrementing = false;
    protected $keyType = 'string';

    public function pemeriksaanAset()
    {
        return $this->belongsTo(PemeriksaanAset::class, 'id_pemeriksaan_aset', 'id_pemeriksaan_aset');
    }

    public function aset()
    {
        return $this->belongsTo(Aset::class, 'aset_id', 'aset_id');
    }

}
