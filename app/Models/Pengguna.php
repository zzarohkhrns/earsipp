<?php

namespace App\Models;

use App\Models\PcPengurus;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pengguna extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $connection = "siftnu";

    protected $guarded = [];
    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';
    public $incrementing = false;
    public function PcPengurus()
    {
        return $this->belongsTo(PcPengurus::class, 'gocap_id_pc_pengurus');
    }
    public function UpzisPengurus()
    {
        return $this->belongsTo(UpzisPengurus::class, 'gocap_id_upzis_pengurus');
    }
    protected $hidden = [
        'password',
    ];
}
