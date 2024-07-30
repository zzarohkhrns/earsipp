<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class KodeJenisSurat extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $guarded = ['id'];
    protected $table = 'kode_jenis_surat';
}
