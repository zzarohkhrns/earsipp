<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kategori')->insert([
            [
                'id_kategori' => Str::uuid()->toString(),
                'kategori' => 'Elektronik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_kategori' => Str::uuid()->toString(),
                'kategori' => 'Furniture',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_kategori' => Str::uuid()->toString(),
                'kategori' => 'Peralatan Kantor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tambahkan data kategori lain di sini
        ]);
    }
}