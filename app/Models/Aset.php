<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aset extends Model
{
    use HasFactory;
    protected $table = 'aset';
    protected $primaryKey ='aset_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['aset_id', 'kode_aset', 'nama_aset', 'tgl_perolehan', 'harga_perolehan', 'id_pc', 'id_upzis', 'satuan', 'id_kategori', 'spesifikasi', 'lokasi_penyimpanan', 'id_pc_pengurus', 'id_upzis_pengurus'];

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
