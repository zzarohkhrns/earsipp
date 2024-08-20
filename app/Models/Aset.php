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
    protected $fillable = ['aset_id', 'kode_aset', 'asal_perolehan', 'nama_aset', 'tgl_perolehan', 'harga_perolehan', 'id_pc', 'id_upzis', 'satuan', 'id_kategori', 'spesifikasi', 'lokasi_penyimpanan', 'id_pc_pengurus', 'id_upzis_pengurus'];


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

    public function detailPemeriksaanAset()
    {
        return $this->hasMany(DetailPemeriksaanAset::class, 'aset_id', 'aset_id')->orderBy('created_at', 'desc');
    }
    public function latestDetailPemeriksaanAset()
    {

        return $this->hasOne(DetailPemeriksaanAset::class, 'aset_id', 'aset_id')->latestOfMany('created_at')->orderBy('created_at', 'desc');

        // return $this->hasOne(DetailPemeriksaanAset::class, 'aset_id', 'aset_id')
        //         ->where('id_detail_pemeriksaan_aset', function($query) {
        //             $query->selectRaw('MAX(id_detail_pemeriksaan_aset)')
        //                   ->from('detail_pemeriksaan_aset')
        //                   ->whereColumn('aset_id', 'aset_id');
        //         })
        //         ->orderBy('created_at', 'desc');
    }
    public function kategori_aset()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }
}
