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

    public function pemeriksaanAset()
    {
        return $this->hasMany(PemeriksaanAset::class, 'id_pc_pengurus', 'id_pc_pengurus');
    }

    public function PengurusJabatan()
    {
        return $this->belongsTo(PengurusJabatan::class, 'id_pengurus_jabatan');
    }
}
