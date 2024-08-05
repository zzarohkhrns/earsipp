<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeluarMasukAset extends Model
{
    protected $table = 'keluar_masuk_aset';
    protected $primaryKey = 'id_keluar_masuk_aset';
    public $incrementing = false;
    protected $keyType = 'string';

    public function barang()
    {
        return $this->belongsTo(Aset::class, 'aset_id', 'aset_id');
    }
}
