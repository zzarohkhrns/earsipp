<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KontrolBarang extends Model
{
    protected $table = 'kontrol_barang';
    protected $primaryKey = 'id_kontrol_barang';
    public $incrementing = false;
    protected $keyType = 'string';

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }
}
