<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ranting extends Model
{
    use HasFactory;

    protected $connection = "gocap";
    protected $table = 'ranting';
    protected $primaryKey = 'id_ranting';
    public $incrementing = false;
    protected $guarded = [];

    protected $casts = [
        'id_ranting' => 'string'
    ];

    public function Wilayah()
    {
        return $this->belongsTo(Wilayah::class, 'id_wilayah');
    }
}
