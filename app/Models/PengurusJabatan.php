<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengurusJabatan extends Model
{
    use HasFactory;

    protected $connection = "gocap";
    protected $table = 'pengurus_jabatan';
    protected $primaryKey = 'id_pengurus_jabatan';
    public $incrementing = false;

    protected $guarded = [];
}
