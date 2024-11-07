<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailKeluarMasukAset extends Model
{
    use HasFactory;
    protected $table = 'detail_keluar_masuk_aset';
    protected $primaryKey = 'id_detail_keluar_masuk_aset';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id_detail_keluar_masuk_aset',
        'aset_id',
        'id_keluar_masuk_aset',
        'masuk_kuantitas',
        'masuk_kondisi',
        'masuk_tindak_lanjut',
        'masuk_dokumentasi',
        'keluar_kuantitas',
        'keluar_kondisi',
        'keluar_tindak_lanjut',
        'keluar_dokumentasi'
    ];

    public function keluar_masuk_aset()
    {
        return $this->belongsTo(KeluarMasukAset::class, 'id_keluar_masuk_aset', 'id_keluar_masuk_aset');
    }

    public function aset()
    {
        return $this->belongsTo(Aset::class, 'aset_id', 'aset_id');
    }
}
