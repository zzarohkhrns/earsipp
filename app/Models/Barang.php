<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barang';
    protected $primaryKey ='id_barang';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id_barang', 'nama', 'satuan', 'lokasi_penyimpanan', 'spesifikasi'];

    public function kontrolBarang()
    {
        return $this->hasMany(KontrolBarang::class, 'id_barang', 'id_barang');
    }
    public function latestKontrolBarang()
    {
        return $this->hasOne(KontrolBarang::class, 'id_barang', 'id_barang')->latestOfMany('tanggal_kontrol', 'id_tanggal_kontrol');
    }

    public function keluarMasukBarang()
    {
        return $this->hasMany(KeluarMasukBarang::class, 'id_barang', 'id_barang');
    }

    public function latestKeluarMasukBarang()
    {
        return $this->hasOne(KeluarMasukBarang::class, 'id_barang', 'id_barang')->latestOfMany('tanggal_keluar_masuk', 'id_tanggal_keluar_masuk');
    }

}
