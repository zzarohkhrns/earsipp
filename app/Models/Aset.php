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


    public static function generateKodeAset()
    {
        // Tentukan prefix kode yang tetap
        $prefix = "PC.11.34.10/ASET/";

        // Dapatkan kode terakhir yang dihasilkan
        $lastAset = self::orderBy('kode_aset', 'desc')->first();

        if (!$lastAset) {
            // Jika belum ada data, mulai dari 0001
            $number = 1;
        } else {
            // Jika ada data, ambil nomor terakhir dan tambah 1
            $lastNumber = intval(substr($lastAset->kode_aset, strrpos($lastAset->kode_aset, '/') + 1));
            $number = $lastNumber + 1;
        }

        // Format kode dengan 4 digit angka
        return $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    public static function getNextKodeAset()
    {
        return self::generateKodeAset();
    }

    public function detaiPemeriksaanAset()
    {
        return $this->hasMany(DetailPemeriksaanAset::class, 'aset_id', 'aset_id');
    }
    public function latestDetailPemeriksaanAset()
    {
        return $this->hasOne(DetailPemeriksaanAset::class, 'aset_id', 'aset_id')->latest();
    }
    public function kategori_aset()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    // public function keluarMasukAset()
    // {
    //     return $this->hasMany(KeluarMasukAset::class, 'aset_id', 'aset_id');
    // }

    // public function latestKeluarMasukAset()
    // {
    //     return $this->hasOne(KeluarMasukAset::class, 'aset_id', 'aset_id')->latestOfMany('tanggal_keluar_masuk', 'id_keluar_masuk_aset');
    // }

}
