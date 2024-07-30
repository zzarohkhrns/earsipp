<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upzis extends Model
{
    use HasFactory;

    protected $connection = "gocap";
    protected $table = 'upzis';
    protected $primaryKey = 'id_upzis';
    public $incrementing = false;


    protected $guarded = [];

    public function Wilayah()
    {
        return $this->belongsTo(Wilayah::class, 'id_wilayah');
    }
}
