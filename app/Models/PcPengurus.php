<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PcPengurus extends Model
{
    use HasFactory;

    protected $table = 'pc_pengurus';
    protected $connection = "gocap";
    protected $primaryKey = 'id_pc_pengurus';
    public $incrementing = false;

    protected $guarded = [];

    public function Pc()
    {
        return $this->belongsTo(Pc::class, 'id_pc');
    }

    public function pengguna()
    {
        return $this->hasOne(Pengguna::class, 'gocap_id_pc_pengurus', 'id_pc_pengurus');
    }

    public function pemeriksaanAset()
    {
        return $this->hasMany(PemeriksaanAset::class, 'id_pemeriksa', 'id_pc_pengurus');
    }

    public function kc()
    {
        return $this->hasMany(PemeriksaanAset::class, 'id_kc', 'id_pc_pengurus');
    }

    public function PengurusJabatan()
    {
        return $this->belongsTo(PengurusJabatan::class, 'id_pengurus_jabatan');
    }

    public function KeluarMasukAset()
    {
        return $this->hasMany(KeluarMasukAset::class, 'id_pencatat', 'id_pc_pengurus');
    }
}
