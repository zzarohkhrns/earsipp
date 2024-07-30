<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    use HasFactory;
    protected $connection = "siftnu";

    protected $table = 'wilayah';
    protected $primaryKey = 'id_wilayah';
    public $incrementing = false;
}
