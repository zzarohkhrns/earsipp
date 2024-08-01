<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeluarMasukBarang extends Model
{
    protected $table = 'keluar_masuk_barang';
    protected $primaryKey = 'id_keluar_masuk_barang';
    public $incrementing = false;
    protected $keyType = 'string';

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }
}
