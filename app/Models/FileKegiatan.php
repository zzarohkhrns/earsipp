<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;


class FileKegiatan extends Model
{
    protected $guarded = ['id'];
    protected $table = 'file_kegiatan';
}
