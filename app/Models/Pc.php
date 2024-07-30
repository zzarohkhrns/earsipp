<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pc extends Model
{
    use HasFactory;

    protected $table = 'pc';
    protected $primaryKey = 'id_pc';
    protected $connection = "gocap";
    protected $guarded = [];
    public $incrementing = false;



    public function Wilayah()
    {
        return $this->belongsTo(Wilayah::class, 'id_wilayah');
    }
}
