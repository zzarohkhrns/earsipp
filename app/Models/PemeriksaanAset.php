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
    protected $fillable = ['id_pemeriksaan_aset', 'tanggal_pemeriksaan', 'id_pemeriksa', 'id_supervisor', 'id_kc', 'status_spv', 'status_kc', 'catatan_spv', 'tgl_mengetahui_spv', 'tgl_mengetahui_kc', 'catatan_kc'];

    public function detailPemeriksaanAset()
    {
        return $this->hasMany(DetailPemeriksaanAset::class, 'id_pemeriksaan_aset', 'id_pemeriksaan_aset');
    }

    public function pcPengurus()
    {
        return $this->belongsTo(PcPengurus::class, 'id_pemeriksa', 'id_pc_pengurus');
    }
    public function supervisor()
    {
        return $this->belongsTo(PcPengurus::class, 'id_supervisor', 'id_pc_pengurus');
    }
    public function kc()
    {
        return $this->belongsTo(PcPengurus::class, 'id_kc', 'id_pc_pengurus');
    }
}