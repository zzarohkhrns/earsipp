<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class FileBerita extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $guarded = ['id'];
    protected $table = 'file_berita';


    protected $casts = [
        'id' => 'string'
    ];
}
