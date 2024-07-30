<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notif extends Model
{
    use HasFactory;
    protected $table = 'notif';
    protected $primaryKey = 'id';
    protected $connection = "n1651709_aplikasi";
    protected $guarded = [];
    public $incrementing = false;
}
