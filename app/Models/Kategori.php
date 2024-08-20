<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $primaryKey ='id_kategori';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id_kategori', 'kategori'];

    public function aset()
    {
        return $this->hasMany(Aset::class, 'id_kategori', 'id_kategori')->orderBy('created_at', 'desc');
    }
}
